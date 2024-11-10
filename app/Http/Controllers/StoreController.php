<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Store = Store::orderBy('id', 'DESC')->paginate(10);
        
        return view('backend.store.index')->with('stores', $Store);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.store.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         // Validate the request data
         $request->validate([
            'title' => 'required|string',
            'address' => 'required|string',
            'locationurl' => 'required|url', // Update here to validate as a URL
            'status' => 'required|in:active,inactive',
        ]);

        // Get all the validated data
        $data = $request->only(['title', 'address', 'locationurl', 'status']);
        
        // Create the store record
        $status = Store::create($data);

        // Provide feedback based on the operation result
        if ($status) {
            session()->flash('success', 'Store successfully added');
        } else {
           session()->flash('error', 'Error occurred while adding the store');
        }
        
        return redirect()->route('store.index');
    }
       

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Store = Store::findOrFail($id);
        return view('backend.store.edit')->with('store', $Store);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Store = Store::findOrFail($id);

        $data = $request->all();

        $status = $Store->fill($data)->save();
        if ($status) {
            session()->flash('success', 'Store successfully updated');
        } else {
            session()->flash('error', 'Error occurred while updating store');
        }
        return redirect()->route('store.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Store = Store::findOrFail($id);
        $status = $Store->delete();
        if ($status) {
           session()->flash('success', 'Store successfully deleted');
        } else {
            session()->flash('error', 'Error occurred while deleting banner');
        }
        return redirect()->route('store.index');
    }

}
