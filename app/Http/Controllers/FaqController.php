<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $faq=Faq::getAllFaq();
    //    return $faq;
        // return $faq;
       return view('backend.faq.index')->with('faqs',$faq);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $users=User::get();
        return view('backend.faq.create');
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
            'question'=>'string|nullable',
            'answer'=>'string|nullable',
            'status'=>'required|in:active,inactive'
        ]);


        $data=$request->all();


        // return $data;

        $status=Faq::create($data);
        if($status){
            request()->session()->flash('success','faq Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('faq.index');
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
        $faq=Faq::findOrFail($id);
        return view('backend.faq.edit')->with('faq',$faq);
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
        $faq=faq::findOrFail($id);
        // return $request->all();
         $this->validate($request,[
            'title'=>'string|required',
            'question'=>'string',
            'answer'=>'string',
            'status'=>'required|in:active,inactive'
        ]);

        $data=$request->all();
     //   dd($data);
        // return $tags;
    
        // return $data;

        $status=$faq->fill($data)->save();
        if($status){
            request()->session()->flash('success','faq Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('faq.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq=Faq::findOrFail($id);
       
        $status=$faq->delete();
        
        if($status){
            request()->session()->flash('success','faq successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting faq');
        }
        return redirect()->route('faq.index');
    }
}
