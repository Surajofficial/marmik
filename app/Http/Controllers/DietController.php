<?php
namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class DietController extends Controller
{
    public function recommendDiet(): JsonResponse
    {
        $diets = [
            'Mediterranean Diet',
            'DASH Diet',
            'Paleo Diet',
            'Vegan Diet',
            'Ketogenic Diet',
            'Raw Food Diet'
        ];

        $randomDiet = $diets[array_rand($diets)];

        return response()->json(['diet' => $randomDiet]);
    }
}
