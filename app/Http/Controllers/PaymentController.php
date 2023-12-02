<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelSubscriptionRequest;
use App\Http\Requests\PaymentRequest;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Stripe\Stripe;

class PaymentController extends Controller
{


    public function ToSuscribe(PaymentRequest $request)
    {
        // Mostrar mensajes de error en español
        function getMessageError($e)
        {
            $message = "";
            $error = $e->getError()->code;
            if ($error == 'card_declined') {
                $decline_code = $e->getError()->decline_code;
                if ($decline_code == 'generic_decline') {
                    $message = 'La tarjeta fue rechazada por una razón desconocida, contacte con su banco.';
                } elseif ($decline_code == 'insufficient_funds') {
                    $message = 'La tarjeta no tiene fondos suficientes para completar el pago de su suscripción';
                } elseif ($decline_code == 'lost_card') {
                    $message = 'El pago fue rechazado porque la tarjeta se reportó perdida.';
                } elseif ($decline_code == 'stolen_card') {
                    $message = 'El pago fue rechazado porque se reportó el robo de la tarjeta.';
                } else {
                    $message = 'La tarjeta fue rechazada. Intente de nuevo';
                }
                return $message;
            }

            if ($error == 'expired_card') {
                $message = 'La tarjeta ha caducado. Verifique la fecha de vencimiento o use una tarjeta diferente.';
            } elseif ($error == 'incorrect_cvc') {
                $message = 'El código de seguridad de la tarjeta es incorrecto. Verifique el código de seguridad de la tarjeta o use una tarjeta diferente.';
            } elseif ($error == 'processing_error') {
                $message = 'Se produjo un error al procesar la tarjeta. Vuelve a intentarlo más tarde o con un método de pago diferente.';
            } elseif ($error == 'incorrect_number') {
                $message = 'El número de tarjeta es incorrecto. Verifique el número de la tarjeta o use una tarjeta diferente.';
            } else {
                $message = $e->getError()->message;
            }
            return $message;
        }

        // Valida si la contraseña es correcta
        $user = Auth::user();
        $userAutenticated = User::where('email', '=', $user->email)->first();

        if (!$user || !Hash::check($request->password, $userAutenticated->password)) {
            return response()->json(['status' => false, 'message' => 'Contraseña incorrecta']);
        }

        $tokenCard = $request->tokenCard;
        $stripe = new \Stripe\StripeClient('sk_test_51K4UY3AIicvw06Nve5Gz2dVSKTDteB2yx8cypfeP83BxT9moLwrJoT1SjOzu77J7yrDV3H7T4jWyeymAs5hGfGe000Wj7Qqykd');
        $id_price = 'none';

        if ($request->plan == 'basicomen') {
            $id_price = 'price_1ODjoDAIicvw06Nv5ZPqzTAN';
        } elseif ($request->plan == 'basicoanual') {
            $id_price = 'price_1ODjpaAIicvw06NvTDWU37Ij';
        } elseif ($request->plan == 'premiummen') {
            $id_price = 'price_1ODjqSAIicvw06Nvya22QKTw';
        } elseif ($request->plan == 'premiumanual') {
            $id_price = 'price_1ODjtyAIicvw06NvSRboOv31';
        }

        //Si no es un customer en stripe, significa que no tiene una suscripción. Entonces se registra como customer y se crea una subscripción.
        if ($user->token_stripe == null) {
            try {
                $customer = $stripe->customers->create(
                    [
                        'name' => $user->username,
                        'email' => $user->email,
                        'payment_method' => $tokenCard,
                        "invoice_settings" => ["default_payment_method" => $tokenCard],
                    ]
                );
                $subscription = $stripe->subscriptions->create([
                    'customer' => $customer->id,
                    'items' => [
                        ['price' => $id_price],
                    ],
                ]);
                if ($subscription->status != "active") {
                    return response()->json(['status' => false, 'message' => 'Hubo un error al intentar suscribirte.']);
                }
                $updated = User::where('id_user', '=', $user->id_user)->update(['token_stripe' => $customer->id, 'token_subscription' => $subscription->id, 'token_card' => $tokenCard, 'plan' => $request->plan]);
                if ($updated != 1) {
                    return response()->json(['status' => false, 'message' => 'Hubo un error al intentar guardar tu suscripción']);
                }

                // Para actualizar la visibilidad de los restaurants
                try {
                    DB::table('restaurants')->where('id_user', $user->id_user)->update(['visibility' => true]);
                } catch (\Throwable $th) {
                    return response()->json(['status' => false, 'message' => 'Hubo un error al intentar cambiar la visibilidad de los restaurantes.']);
                }

                // Para cambiar el rol y los permisos del token
                $rol = User::where('id_user', '=', $user->id_user)->update(['rol' => "restaurantero"]);
                if ($rol != 1) {
                    return response()->json(['status' => false, 'message' => 'Hubo un error al intentar cambiar el rol']);
                }
                $ability = DB::table('personal_access_tokens')->where('tokenable_id', $user->id_user)->update(['abilities' => ["restaurantero"]]);
                if ($ability != 1) {
                    return response()->json(['status' => false, 'message' => 'Hubo un error al intentar cambiar permisos']);
                }

                return response()->json(['status' => true, 'message' => "¡Bien hecho! subscripción completada."]);
            } catch (\Stripe\Exception\CardException $e) {
                // Manejar errores relacionados con la tarjeta (por ejemplo, tarjeta rechazada)
                $message = getMessageError($e);
                return response()->json(['status' => false, 'message' => $message]);
            } catch (\Throwable $th) {
                return response()->json(['status' => false, 'message' => 'Hubo un error desconocido al procesar tu suscripción.']);
            }
        }

        // Como ya es un customer, entonces comprueba si tiene una subscripción, si la tiene lo cancela.
        if ($user->token_subscription != null) {
            try {
                $subDeleted = $stripe->subscriptions->cancel(
                    $user->token_subscription,
                    []
                );
                if ($subDeleted->status != "canceled") {
                    return response()->json(['status' => false, 'message' => 'Hubo un error al intentar cancelar tu actual suscripción.']);
                }
            } catch (\Throwable $th) {
                return response()->json(['status' => false, 'message' => 'hubo un error desconocido al procesar la cancelación de tu actual suscripción.']);
            }
        }

        // Comprueba si el customer tiene un metodo de pago, si no tiene le agrega uno y lo hace determinado.
        if ($user->token_card == null) {
            try {
                $stripe->paymentMethods->attach(
                    $tokenCard,
                    ['customer' => $user->token_stripe]
                );
                $stripe->customers->update(
                    $user->token_stripe,
                    [
                        "invoice_settings" => ["default_payment_method" => $tokenCard],
                    ]
                );
                $updated = User::where('id_user', '=', $user->id_user)->update(['token_card' => $tokenCard]);
                if ($updated != 1) {
                    return response()->json(['status' => false, 'message' => 'Hubo un error al intentar guardar tu metodo de pago.']);
                }
            } catch (\Throwable $th) {
                return response()->json(['status' => false, 'message' => 'hubo un error desconocido al procesar tu metodo de pago.']);
            }
        }

        // Entonces procede a crear la nueva suscripción y guardarla.
        try {
            $subscription = $stripe->subscriptions->create([
                'customer' => $user->token_stripe,
                'items' => [
                    ['price' => $id_price],
                ],
            ]);
            if ($subscription->status != "active") {
                return response()->json(['status' => false, 'message' => 'Hubo un error al intentar suscribirte.']);
            }
            $updated = User::where('id_user', '=', $user->id_user)->update(['token_subscription' => $subscription->id, 'plan' => $request->plan]);
            if ($updated != 1) {
                return response()->json(['status' => false, 'message' => 'Hubo un error al intentar guardar tu suscripción']);
            }

            // Para actualizar la visibilidad de los restaurants
            try {
                DB::table('restaurants')->where('id_user', $user->id_user)->update(['visibility' => true]);
            } catch (\Throwable $th) {
                return response()->json(['status' => false, 'message' => 'Hubo un error al intentar cambiar la visibilidad de los restaurantes.']);
            }

            // Para cambiar el rol y los permisos del token
            $rol = User::where('id_user', '=', $user->id_user)->update(['rol' => "restaurantero"]);
            if ($rol != 1) {
                return response()->json(['status' => false, 'message' => 'Hubo un error al intentar cambiar el rol']);
            }
            $ability = DB::table('personal_access_tokens')->where('tokenable_id', $user->id_user)->update(['abilities' => ["restaurantero"]]);
            if ($ability != 1) {
                return response()->json(['status' => false, 'message' => 'Hubo un error al intentar cambiar permisos']);
            }

            return response()->json(['status' => true, 'message' => "¡Bien hecho! subscripción completada."]);
        } catch (\Stripe\Exception\CardException $e) {
            // Manejar errores relacionados con la tarjeta (por ejemplo, tarjeta rechazada)
            $message = getMessageError($e);
            return response()->json(['status' => false, 'message' => $message]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'hubo un error desconocido al procesar tu suscripción.']);
        }
    }

    public function cancelSubscription(CancelSubscriptionRequest $request)
    {
        $user = Auth::user();
        $userAutenticated = User::where('email', '=', $user->email)->first();

        if (!$user || !Hash::check($request->password, $userAutenticated->password)) {
            return response()->json(['status' => false, 'message' => 'Contraseña incorrecta']);
        }

        $stripe = new \Stripe\StripeClient('sk_test_51K4UY3AIicvw06Nve5Gz2dVSKTDteB2yx8cypfeP83BxT9moLwrJoT1SjOzu77J7yrDV3H7T4jWyeymAs5hGfGe000Wj7Qqykd');
        // Como ya es un customer, entonces comprueba si tiene una subscripción, si la tiene lo cancela.
        if ($user->token_subscription != null) {
            try {
                $subDeleted = $stripe->subscriptions->cancel(
                    $user->token_subscription,
                    []
                );
                if ($subDeleted->status != "canceled") {
                    return response()->json(['status' => false, 'message' => 'Hubo un error al intentar cancelar tu actual suscripción.']);
                }
                $updated = User::where('id_user', '=', $user->id_user)->update(['token_subscription' => null, 'plan' => "none"]);
                if ($updated != 1) {
                    return response()->json(['status' => false, 'message' => 'Hubo un error al intentar eliminar tu suscripción']);
                }

                // Para actualizar la visibilidad de los restaurants
                try {
                    DB::table('restaurants')->where('id_user', $user->id_user)->update(['visibility' => false]);
                } catch (\Throwable $th) {
                    return response()->json(['status' => false, 'message' => 'Hubo un error al intentar cambiar la visibilidad de los restaurantes.']);
                }

                // Para actualizar el rol y el permiso del token
                $rol = User::where('id_user', '=', $user->id_user)->update(['rol' => "user"]);

                if ($rol != 1) {
                    return response()->json(['status' => false, 'message' => 'Hubo un error al intentar cambiar el rol']);
                }
                $ability = DB::table('personal_access_tokens')->where('tokenable_id', $user->id_user)->update(['abilities' => ["user"]]);
                if ($ability != 1) {
                    return response()->json(['status' => false, 'message' => 'Hubo un error al intentar cambiar permisos']);
                }
                return response()->json(['status' => true, 'message' => "Bien. Tu suscripción se ha cancelado."]);
            } catch (\Throwable $th) {
                return response()->json(['status' => false, 'message' => 'hubo un error desconocido al procesar la cancelación de tu actual suscripción.']);
            }
        }
    }
}
