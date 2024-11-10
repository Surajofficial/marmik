<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poster;
use Illuminate\Support\Str;

class PosterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner=Poster::orderBy('id','DESC')->paginate(10);
        return view('backend.poster.index')->with('banners',$banner);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.poster.create');
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
        // $this->validate($request,[
        //     'title'=>'string|required|max:50',
        //     'description'=>'string|nullable',
        //     'photo'=>'string|required',
        //     'position'=>'string|required',
        //     'page'=>'string|required',
        //     'status'=>'required|in:active,inactive',
        // ]);
        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Poster::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $slug;
        $status=Poster::create($data);
        if($status){
            request()->session()->flash('success','Poster successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding poster');
        }
        return redirect()->route('poster.index');
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
        $banner=Poster::findOrFail($id);
        return view('backend.poster.edit')->with('banner',$banner);
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
        $banner=Poster::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();
        // $slug=Str::slug($request->title);
        // $count=Banner::where('slug',$slug)->count();
        // if($count>0){
        //     $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        // }
        // $data['slug']=$slug;
        // return $slug;
        $status=$banner->fill($data)->save();
        if($status){
            request()->session()->flash('success','Poster successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating poster');
        }
        return redirect()->route('poster.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner=Poster::findOrFail($id);
        $status=$banner->delete();
        if($status){
            request()->session()->flash('success','Poster successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting POSTER');
        }
        return redirect()->route('poster.index');
    }
}
