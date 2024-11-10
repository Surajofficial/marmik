<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfoRequest;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $information = Information::paginate(10);
        return view("backend.info.index", compact("information"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("backend.info.form");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InfoRequest $request)
    {
        $validatedData = $request->validated();
        Information::create($validatedData);
        return redirect()->route('information.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Information $information)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information $information)
    {
        // return $information;
        return view("backend.info.form", ['info' => $information]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(InfoRequest $request, Information $information)
    {
        $validatedData = $request->validated();
        $information->update($validatedData);
        return redirect()->route('information.index')->with('success', 'Information updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information $information)
    {
        $information->delete();
        return redirect()->route('information.index')->with('success', 'Information deleted successfully.');
    }
}
