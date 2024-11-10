<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concern;
use Illuminate\Support\Str;

class ConcernController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $concerns = Concern::getAllConcern();
        //     print
        // return $concern;
        return view('backend.concern.index')->with('concerns', $concerns);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // print_r("hello");exit();
        $parent_cats = Concern::where('is_parent', 1)->orderBy('title', 'ASC')->get();
        //   print_r($parent_cats);
        return view('backend.concern.create')->with('parent_cats', $parent_cats);
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
        //     'title'=>'string|required',
        //     'summary'=>'string|nullable',
        //     'photo'=>'string|nullable',
        //     'status'=>'required|in:active,inactive',
        //     'is_parent'=>'sometimes|in:1',
        //     'parent_id'=>'nullable|exists:concern,id',
        // ]);
        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Concern::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        $data['is_parent'] = $request->input('is_parent', 0);
        // return $data;   
        $status = Concern::create($data);
        if ($status) {
            request()->session()->flash('success', 'Concern successfully added');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }
        return redirect()->route('concern.index');
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
        $parent_cats = Concern::where('is_parent', 1)->get();
        $concern = Concern::findOrFail($id);
        return view('backend.concern.edit')->with('concern', $concern)->with('parent_cats', $parent_cats);
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
        $concern = Concern::findOrFail($id);
        // $this->validate($request,[
        //     'title'=>'string|required',
        //     'summary'=>'string|nullable',
        //     'photo'=>'string|nullable',
        //     'status'=>'required|in:active,inactive',
        //     'is_parent'=>'sometimes|in:1',
        //     'parent_id'=>'nullable|exists:concern,id',
        // ]);
        $data = $request->all();
        $data['is_parent'] = $request->input('is_parent', 0);
        // return $data;
        $status = $concern->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Concern successfully updated');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }
        return redirect()->route('concern.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $concern = Concern::findOrFail($id);
        $child_cat_id = Concern::where('parent_id', $id)->pluck('id');
        // return $child_cat_id;
        $status = $concern->delete();

        if ($status) {
            if (count($child_cat_id) > 0) {
                Concern::shiftChild($child_cat_id);
            }
            request()->session()->flash('success', 'Concern successfully deleted');
        } else {
            request()->session()->flash('error', 'Error while deleting concern');
        }
        return redirect()->route('concern.index');
    }

    public function getChildByParent(Request $request)
    {
        // return $request->all();
        $concern = Concern::findOrFail($request->id);
        $child_cat = Concern::getChildByParentID($request->id);
        // return $child_cat;
        if (count($child_cat) <= 0) {
            return response()->json(['status' => false, 'msg' => '', 'data' => null]);
        } else {
            return response()->json(['status' => true, 'msg' => '', 'data' => $child_cat]);
        }
    }
}
