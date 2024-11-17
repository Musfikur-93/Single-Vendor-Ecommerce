<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;

class WarehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //warehouse index method
    public function index(Request $request)
    {
      if ($request->ajax()) {
        $data=DB::table('warehouse')->latest()->get();

          return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></a>
                <a href="'.route('warehouse.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i></a>';

                return $actionbtn;
            })
            ->rawColumns(['action'])
            ->make(true);
      }

      return view('admin.categories.warehouse.index');
    }

    //warehouse store method
    public function store(Request $request)
    {
      $validated = $request->validate([
        'warehouse_name' => 'required|unique:warehouse',
      ]);

      $data=array();
      $data['warehouse_name']=$request->warehouse_name;
      $data['warehouse_address']=$request->warehouse_address;
      $data['warehouse_phone']=$request->warehouse_phone;

      DB::table('warehouse')->insert($data);

      $notification=array('message' => 'Warehouse Added!','alert-type'=>'success' );
      return redirect()->back()->with($notification);
    }

    //warehouse delete method
    public function destroy($id)
    {
        DB::table('warehouse')->where('id',$id)->delete();

        $notification=array('message' => 'Warehouse Deleted!','alert-type'=>'success' );
        return redirect()->back()->with($notification);
    }

    //warehouse edit method
    public function edit($id)
    {
        $warehouse=DB::table('warehouse')->where('id',$id)->first();
          return view('admin.categories.warehouse.edit',compact('warehouse'));
    }

    //warehouse update method
    public function update(Request $request)
    {
      $data=array();
      $data['warehouse_name']=$request->warehouse_name;
      $data['warehouse_address']=$request->warehouse_address;
      $data['warehouse_phone']=$request->warehouse_phone;

      DB::table('warehouse')->where('id',$request->id)->update($data);

      $notification=array('message' => 'Warehouse Updated!','alert-type'=>'success' );
      return redirect()->route('warehouse.index')->with($notification);
    }
}
