<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centers = Center::get();
        return view('backend.center.index', compact('centers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.center.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'center_name' => 'required|unique:centers,center_name|max:255',
        ]);

        Center::create([
            'center_name' => $request->center_name
        ]);

        return redirect()->route('centers.index')->with('success', 'Center created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Center $center)
    {
        return view('backend.center.edit', compact('center'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Center $center)
    {
        $request->validate([
            'center_name' => 'required|unique:centers,center_name,' . $center->id . '|max:255',
        ]);

        $center->update([
            'center_name' => $request->center_name
        ]);

        return redirect()->route('centers.index')->with('success', 'Center updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Center $center)
    {
        $center->delete();
        return redirect()->route('centers.index')->with('success', 'Center deleted successfully.');
    }
    
}
