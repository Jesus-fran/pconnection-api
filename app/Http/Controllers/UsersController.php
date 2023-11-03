<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRecoveryRequest;
use App\Http\Requests\UserAutenticationRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class UsersController extends Controller
{
    public function Index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function Store(UserRegistrationRequest $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->password = $request->password;
        $user->username = $request->username;
        $user->created_at = Carbon::now();
        $user->rol = 'user';

        if (!$user->save()) {
            return response()->json(['status' => false, 'message' => 'Error al registrar']);
        }
        $token = $user->createToken($user->username, ['user'])->plainTextToken;
        return response()->json(['status' => true, 'message' => 'Registrado correctamente', 'user' => $user, 'token' => $token]);
    }

    public function Login(UserAutenticationRequest $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'Correo o contraseña invalido']);
        }

        $user->tokens()->delete();
        $token = $user->createToken($user->username, [$user->rol])->plainTextToken;
        return response()->json(['status' => true, 'message' => 'Logueado correctamente', 'user' => $user, 'token' => $token]);
    }

    public function Recovery(PasswordRecoveryRequest $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Este correo no está registrado']);
        }

        try {
            $mail = new PHPMailer(true);

            //Configuración del servidor
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  //ssl
            $mail->Port = 465;

            //Configuración del remitente y destinatario
            $mail->setFrom(env('MAIL_USERNAME'), "soporte-perfectconnection");
            $mail->addAddress($request->email);

            //Configuración del contenido del correo
            $mail->isHTML(true);
            $mail->Subject = mb_encode_mimeheader('Recuperación de contraseña', 'UTF-8', 'Q');
            $mail->Body = "<h1>Hola</h1>";

            $mail->send();

            return response()->json(['status' => true, 'message' => 'Correo de recuperación enviado con éxito. Revisa tu correo']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => "Hubo un error al enviar el correo de recuperación"]);
        }
    }
}
