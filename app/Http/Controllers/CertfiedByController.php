<?php

namespace App\Http\Controllers;

use App\Models\CertfiedBy;
use Illuminate\Http\Request;
use Illuminate\Support\Str;



class CertfiedByController extends Controller
{
    public function index()
    {
        $banner = CertfiedBy::orderBy('id', 'DESC')->paginate(10);
        return view('backend.certified.index')->with('banners', $banner);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.certified.create');
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
            'title' => 'string|required|max:50',
            'photo' => 'string|required',
            'status' => 'required|in:active,inactive',
        ]);
        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = CertfiedBy::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        // return $slug;
        $status = CertfiedBy::create($data);
        if ($status) {
            session()->flash('success', 'Certified successfully added');
        } else {
            session()->flash('error', 'Error occurred while adding promise');
        }
        return redirect()->route('certified.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = CertfiedBy::findOrFail($id);
        return view('backend.certified.edit')->with('banner', $banner);
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
        $banner = CertfiedBy::findOrFail($id);
        $this->validate($request, [
            'title' => 'string|required|max:50',
            'photo' => 'string|required',
            'status' => 'required|in:active,inactive',
        ]);
        $data = $request->all();
        // $slug=Str::slug($request->title);
        // $count=Banner::where('slug',$slug)->count();
        // if($count>0){
        //     $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        // }
        // $data['slug']=$slug;
        // return $slug;
        $status = $banner->fill($data)->save();
        if ($status) {
            session()->flash('success', 'Promise successfully updated');
        } else {
            session()->flash('error', 'Error occurred while updating promise');
        }
        return redirect()->route('certified.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = CertfiedBy::findOrFail($id);
        $status = $banner->delete();
        if ($status) {
            session()->flash('success', 'Promise successfully deleted');
        } else {
            session()->flash('error', 'Error occurred while deleting promise');
        }
        return redirect()->route('certified.index');
    }
}
