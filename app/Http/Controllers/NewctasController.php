<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newctas;
use Illuminate\Support\Str;

class NewctasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $cta=Newctas::orderBy('id','DESC')->paginate();
        return view('backend.cta.index')->with('ctas',$cta);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.cta.create');
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

        $this->validate($request,[
            'title'=>'string|required',
            'description'=>'string|nullable',
            'url'=>'string|nullable',
            'image'=>'string|nullable'
           
        ]);
        $data= $request->all();

        $status=Newctas::create($data);
        if($status){
            request()->session()->flash('success','Cta successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('cta.index');


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
        $cta=Newctas::findOrFail($id);
        return view('backend.cta.edit')->with('ctas',$cta);
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
        $cta=Newctas::findOrFail($id);
       
        $data= $request->all();

        // return $data;
        $status=$cta->fill($data)->save();
        if($status){
            request()->session()->flash('success','Cta successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('cta.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cta=Newctas::findOrFail($id);
        // return $child_cat_id;
        $status=$cta->delete();
        
        if($status){
           
            request()->session()->flash('success','Cta successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting  cta');
        }
        return redirect()->route('cta.index');
    }


}
