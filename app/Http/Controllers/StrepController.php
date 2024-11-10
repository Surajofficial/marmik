<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Strep;
use Illuminate\Support\Str;

class StrepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $strep = Strep::orderBy('id', 'DESC')->paginate();
        return view('backend.strep.index')->with('streps', $strep);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //dd("hello");
        return view('backend.strep.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
        ]);
        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Strep::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        // return $data;
        $status = Strep::create($data);
        if ($status) {
            session()->flash('success', 'Strep successfully created');
        } else {
            session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('strep.index');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $strep = Strep::find($id);
        if (!$strep) {
            session()->flash('error', 'Strep not found');
        }
        return view('backend.strep.edit')->with('brand', $strep);
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
        $strep = Strep::find($id);
        $this->validate($request, [
            'title' => 'string|required',
        ]);
        $data = $request->all();

        $status = $strep->fill($data)->save();
        if ($status) {
            session()->flash('success', 'Strep successfully updated');
        } else {
            session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('strep.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $strep = Strep::find($id);
        if ($strep) {
            $status = $strep->delete();
            if ($status) {
                session()->flash('success', 'Strep successfully deleted');
            } else {
                session()->flash('error', 'Error, Please try again');
            }
            return redirect()->route('strep.index');
        } else {
            session()->flash('error', 'Strep not found');
            return redirect()->back();
        }
    }
}
