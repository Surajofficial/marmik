<?php

namespace App\Http\Controllers;

use App\Models\Skintype;
use Illuminate\Http\Request;

class SkintypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $concerns=Skintype::getAllSkin();
   //     print
        // return $concern;
        return view('backend.skin-type.index')->with('concerns',$concerns);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     
    //   print_r($parent_cats);
        return view('backend.skin-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data= $request->all();
        // return $data;   
        $status=Skintype::create($data);
        if($status){
            request()->session()->flash('success','Skin Type successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('skin.index');


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
   
        $skin=Skintype::findOrFail($id);
        return view('backend.skin-type.edit')->with('concern',$skin);
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
        // return $request->all();
        $skin=Skintype::findOrFail($id);
        $data= $request->all();
        $data['is_parent']=$request->input('is_parent',0);
        // return $data;
        $status=$skin->fill($data)->save();
        if($status){
            request()->session()->flash('success','Skin Type successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('skin.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $skin=Skintype::findOrFail($id);
   
        $status=$skin->delete();
        return redirect()->route('skin.index');
    }

  
}
