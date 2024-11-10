<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Brand;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'suppliers';
        $suppliers = Supplier::get();

        if($request->ajax()){
            $suppliers = Supplier::get();
            return DataTables::of($suppliers)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("suppliers.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('suppliers.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    if (!auth()->user()->hasPermissionTo('edit-supplier')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-supplier')) {
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('backend.suppliers.index',compact(
            'title','suppliers'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'create supplier';
        $brand = Brand::get();

        return view('backend.suppliers.create',compact(
            'title','brand'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //   dd($request);
        $status= Supplier::create([
            "company" => $request->company,
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "address" => $request->address,
            "city" => $request->city,
            "state" => $request->state,
            "pin" => $request->pin,
            "bname" =>$request->bname,
            "bnumber" => $request->bnumber,
            "bcode" => $request->bcode,
            "pno" => $request->pno,
            "gst" =>$request->gst,
            "opening" => $request->opening,
            "contactp" => $request->contactp,
            "contactn" => $request->contactn,
            "odetail" => $request->odetail,
        ]);
        
      //  $notification = notify("Supplier has been added");
        if($status){
            request()->session()->flash('success','Supplier successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('suppliers.index');
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $title = 'edit supplier';
        $brand = Brand::get();
        return view('backend.suppliers.edit',compact(
            'title','supplier','brand'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
       // dd("hello");
        // $this->validate($request,[
        //     'name'=>'required|min:10|max:255',
        //     'product'=>'required',
        //     'email'=>'nullable|email|string',
        //     'phone'=>'nullable|min:10|max:20',
        //     'company'=>'nullable',
        //     'address'=>'nullable|required|max:200',
        //     'comment' =>'nullable|max:255',
        // ]);
      //  dd($request);
        $supplier->update([
            "company" => $request->company,
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "address" => $request->address,
            "city" => $request->city,
            "state" => $request->state,
            "pin" => $request->pin,
            "bname" =>$request->bname,
            "bnumber" => $request->bnumber,
            "bcode" => $request->bcode,
            "pno" => $request->pno,
            "gst" =>$request->gst,
            "opening" => $request->opening,
            "contactp" => $request->contactp,
            "contactn" => $request->contactn,
            "odetail" => $request->odetail,
        ]);
        if($supplier){
            request()->session()->flash('success','Supplier updated ');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        $notification = 'Supplier updated ';
        return redirect()->route('suppliers.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Supplier::findOrFail($request->id)->delete();
    }
}
