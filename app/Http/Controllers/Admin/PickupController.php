<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;

class PickupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //pickuppoint index method
    public function index(Request $request)
    {
      if ($request->ajax()) {
        $data=DB::table('pickup_points')->latest()->get();

          return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></a>
                <a href="'.route('pickuppoint.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete_coupon"><i class="fas fa-trash"></i></a>';

                return $actionbtn;
            })
            ->rawColumns(['action'])
            ->make(true);
      }

      return view('admin.pickup_point.index');
    }

    //pickuppoint insert method
    public function store(Request $request)
    {
        $data=array();
        $data['pickup_point_name']=$request->pickup_point_name;
        $data['pickup_point_address']=$request->pickup_point_address;
        $data['pickup_point_phone']=$request->pickup_point_phone;
        $data['pickup_point_phntwo']=$request->pickup_point_phntwo;

        DB::table('pickup_points')->insert($data);
          return response()->json('Pickup Point Inserted!');
    }

    //pickuppoint delete method
    public function destroy($id)
    {
        DB::table('pickup_points')->where('id',$id)->delete();
          return response()->json('Pickup Point Deleted');
    }

    //pickuppoint edit method
    public function edit($id)
    {
        $data=DB::table('pickup_points')->where('id',$id)->first();
          return view('admin.pickup_point.edit',compact('data'));
    }

    //pickuppoint updata method
    public function update(Request $request)
    {
      $data=array();
      $data['pickup_point_name']=$request->pickup_point_name;
      $data['pickup_point_address']=$request->pickup_point_address;
      $data['pickup_point_phone']=$request->pickup_point_phone;
      $data['pickup_point_phntwo']=$request->pickup_point_phntwo;

      DB::table('pickup_points')->where('id',$request->id)->update($data);
        return response()->json('Pickup Point Updated!');
    }
}
