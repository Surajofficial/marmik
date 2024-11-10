<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Terms;
use App\Models\User;

class TermsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms=Terms::getAllterms();
        // return $terms;
        return view('backend.terms.index')->with('terms',$terms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.terms.create');
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
            'status'=>'required|in:active,inactive'
        ]);

        $data=$request->all();

       
        // return $data;

        $status=Terms::create($data);
        if($status){
            request()->session()->flash('success','terms Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('terms.index');
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
        $terms=Terms::findOrFail($id);
        return view('backend.terms.edit')->with('terms',$terms);
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
        $terms=Terms::findOrFail($id);
         // return $request->all();
         $this->validate($request,[
            'title'=>'string|required',
            'description'=>'string|nullable',
            'status'=>'required|in:active,inactive'
        ]);

        $data=$request->all();
        // return $data;

        $status=$terms->fill($data)->save();
        if($status){
            request()->session()->flash('success','terms Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('terms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $terms=Terms::findOrFail($id);
       
        $status=$terms->delete();
        
        if($status){
            request()->session()->flash('success','terms successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting terms');
        }
        return redirect()->route('terms.index');
    }
}
