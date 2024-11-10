<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Social;

use Illuminate\Support\Str;
use Mockery\Undefined;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $social=Social::get();
        return view('backend.social.index')->with('socials',$social);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.social.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();
        //dd($data);
        if(isset($data['video']))
        {
        $video=$data['video'];
        $input = time().".".$video->getClientOriginalExtension();
        $destinationPath = 'assets/uploads/';
        $video->move($destinationPath, $input);
        $data['video']=$input;
        }
        $status=Social::create($data);
        if($status){
            request()->session()->flash('success','Product Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('social.index');
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
      
        $social=Social::findOrFail($id);
        return view('backend.social.edit')->with('social',$social);
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
        $social=Social::findOrFail($id);
        $data=$request->all();
        if(isset($data['video']))
        {
            $video=$data['video'];
            var_dump($video);
            $input = time().".".$video->getClientOriginalExtension();
            $destinationPath = 'assets/uploads/';
            $video->move($destinationPath, $input);
            $data['video']=$input;
        }
        $status=$social->fill($data)->save();
        if($status){
            request()->session()->flash('success','Social Media Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('social.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $social=Social::findOrFail($id);
        $status=$social->delete();
        
        if($status){
            request()->session()->flash('success','Social Media Data successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting social media data');
        }
        return redirect()->route('social.index');
    }
}
