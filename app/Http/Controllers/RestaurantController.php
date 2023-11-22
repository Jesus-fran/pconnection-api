<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformationBasicRequest;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{

    public function getInformationBasic()
    {
        $user = Auth::user();
        $restaurant = Restaurant::where('id_restaurant', '=', $user->id_user)->first();
        if ($restaurant) {
            return response()->json($restaurant, 200);
        }
        return response()->json($restaurant, 301);
    }

    public function UpdateInformationBasic(InformationBasicRequest $request)
    {
        $user = Auth::user();
        $infoBasic = Restaurant::where('id_restaurant', '=', $user->id_user)->update(['restaurant' => $request->restaurant, 'logo' => $request->logo, 'telefono' => $request->telefono, 'descripcion' => $request->descripcion, 'tipo' => $request->tipo]);

        if ($infoBasic != 1) {
            return response()->json(['status' => false, 'message' => 'Nada que guardar.' . $request->logo]);
        }
        return response()->json(['status' => true, 'message' => 'Cambios guardados.']);
    }
}
