<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRestaurantRequest;
use App\Http\Requests\DeleteRestaurantRequest;
use App\Http\Requests\InformationBasicRequest;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{

    public function getInformationBasic()
    {
        $user = Auth::user();
        $restaurant = Restaurant::where('id_user', '=', $user->id_user)->get();
        if ($restaurant && count((array)$restaurant) > 0) {
            return response()->json($restaurant, 200);
        }
        return response()->json($restaurant, 301);
    }

    public function getRestaurant(Request $request)
    {
        $user = Auth::user();
        $restaurant = Restaurant::where('id_user', '=', $user->id_user)->where('id_restaurant', '=', $request->id)->first();
        if (!$restaurant) {
            return response()->json(['status' => false, 'message' => 'Hubo un error al obtener los datos del restaurante.']);
        }
        return response()->json($restaurant);
    }

    public function UpdateInformationBasic(InformationBasicRequest $request)
    {
        $user = Auth::user();
        $infoBasic = Restaurant::where('id_user', '=', $user->id_user)->where('id_restaurant', '=', $request->id)->update(['restaurant' => $request->restaurant, 'logo' => $request->logo, 'telefono' => $request->telefono, 'descripcion' => $request->descripcion, 'tipo' => $request->tipo]);

        if ($infoBasic != 1) {
            return response()->json(['status' => true, 'message' => 'Todo actualizado.']);
        }
        return response()->json(['status' => true, 'message' => 'Cambios guardados.']);
    }

    public function createRestaurant(CreateRestaurantRequest $request)
    {
        $user = Auth::user();
        $restaurant = new Restaurant();
        $restaurant->restaurant = $request->restaurant;
        $restaurant->id_user = $user->id_user;
        if (!$restaurant->save()) {
            return response()->json(['status' => false, 'message' => 'Hubo un error al intentar crear tu restaurant']);
        }
        return response()->json(['status' => true, 'message' => '¡Bien hecho!. Restaurante creado']);
    }

    public function deleteRestaurant(DeleteRestaurantRequest $request)
    {
        $user = Auth::user();
        $userAutenticated = User::where('email', '=', $user->email)->first();

        if (!$user || !Hash::check($request->password, $userAutenticated->password)) {
            return response()->json(['status' => false, 'message' => 'Contraseña incorrecta']);
        }
        $deleted = DB::table('restaurants')->where('id_restaurant', '=', $request->id)->delete();
        if ($deleted != 1) {
            return response()->json(['status' => false, 'message' => 'Hubo un error al eliminar el restaurante.']);
        }
        return response()->json(['status' => true, 'message' => 'Eliminado correctamente.']);
    }
}
