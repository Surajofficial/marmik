<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skincareroutine;

class Skincareroutinecontroller extends Controller
{


    public function skincare(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'age' => 'required|integer|min:1',
            'mobile' => 'required|string|max:15|unique:skin_care_routine',
            'email' => 'required|email|max:255|unique:skin_care_routine',
        ]);

        // Create a new user record
        Skincareroutine::create([
            'name' => $validatedData['name'],
            'gender' => $validatedData['gender'],
            'age' => $validatedData['age'],
            'mobile' => $validatedData['mobile'],
            'email' => $validatedData['email'],
        ]);


        // Redirect to the face scan page
        return redirect()->route('scan.face')->with('success', 'Record inserted successfully! Now scan your face.');
        ;
    }

    public function scanFace()
    {
        return view('frontend.scan-face'); // This will return a Blade view for the camera page
    }


    public function randomDiet()
    {
        // Random diet suggestions
        $diets = [
            'Low-Carb Diet: Ideal for quick fat loss.',
            'Mediterranean Diet: Great for heart health.',
            'Vegan Diet: Best for ethical and environmental concerns.',
            'Paleo Diet: Focuses on whole foods.',
            'Keto Diet: A high-fat, low-carb diet.',
            'Intermittent Fasting: A popular eating pattern.'
        ];

        // Pick a random diet from the list
        $randomDiet = $diets[array_rand($diets)];

        return view('frontend.random-diet', compact('randomDiet'));
    }

}
