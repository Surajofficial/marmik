<?php

namespace App\Http\Controllers;

use App\Models\Concern;
use App\Models\Product;
use App\Models\Routine;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routine=Routine::get();
        // return $returns;
        return view('backend.routine.index')->with('routine',$routine);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $concerns= Concern::getAllConcern();
        $products=Product::getAllProduct();
       
        return view('backend.routine.create')->with('concern',$concerns)->with('product',$products);
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
        $data=$request->all();
    //    dd($data);
        $routine = new Routine();
        $data['age'] =  implode(",",$data['age']);
        $data['skin'] =  implode(",",$data['skin']);
        $data['pconcern_id'] =  implode(",",$data['pconcern_id']);
        $data['sconcern_id'] =  implode(",",$data['sconcern_id']);
        $data['pid'] =  implode(",",$data['pid']);
        $data['pb'] =  $data['pb'];
        $data['sensitive'] =  $data['sensitive'];
        dd($data);
      

       // return $data;
      $status= $routine->fill($data);
        // $status=Routine::create($routine);
        if($status){
            request()->session()->flash('success','Routine Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('routine.index');
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
        $routine=Routine::findOrFail($id);
        return view('backend.routine.edit')->with('returns',$routine);
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
        $routine=Routine::findOrFail($id);
         // return $request->all();


        $data=$request->all();
        // return $data;

        $status=$routine->fill($data)->save();
        if($status){
            request()->session()->flash('success','Routine  Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('routine.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $routine=Routine::findOrFail($id);
       
        $status=$routine->delete();
        
        if($status){
            request()->session()->flash('success','Routine successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting routine');
        }
        return redirect()->route('routine.index');
    }
}
