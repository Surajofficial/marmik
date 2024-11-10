<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Returns;
use App\Models\User;

class ReturnsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returns = Returns::getAllreturns();
        // return $returns;
        return view('backend.returns.index')->with('returnss', $returns);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.returns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'title' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'string|nullable'
        ]);

        $data = $request->all();


        // return $data;

        $status = returns::create($data);
        if ($status) {
            request()->session()->flash('success', 'Return Policy Successfully added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('returns.index');
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
        $returns = Returns::findOrFail($id);
        return view('backend.returns.edit')->with('returns', $returns);
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
        $returns = Returns::findOrFail($id);
        // return $request->all();
        $this->validate($request, [
            'title' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'string|nullable'
        ]);

        $data = $request->all();
        // return $data;

        $status = $returns->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Return Policy Successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('returns.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $returns = Returns::findOrFail($id);

        $status = $returns->delete();

        if ($status) {
            request()->session()->flash('success', 'Returns Policy successfully deleted');
        } else {
            request()->session()->flash('error', 'Error while deleting returns');
        }
        return redirect()->route('returns.index');
    }
}
