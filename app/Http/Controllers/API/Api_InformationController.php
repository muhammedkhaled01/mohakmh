<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Information;

class Api_InformationController extends Controller
{
    public function informations()
    {
        $information = Information::all();
        // احتاج عمل خانة للتفعيل حتى يتم طلب ريكورد واحد فقط
        $response = [
            'status' => true,
            'message' => 'this is informations for the mohakama platform',
            'data' => $information,
        ];
        return response()->json($response, 200);
    }
}
