<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Mail;
use App\Mail\ReceivedMail;

class OrderController extends Controller
{
    public function __construct()
      {
          $this->middleware('auth');
      }

      //order list/index method

      public function index(Request $request)
      {
        if ($request->ajax()) {
        //$data=Product::latest()->get(); //eloquent orm joint korar jonno model ke call kora hoyece.

        //query join
        $product=""; //query join korar jonno aita initial kora hoyece.
        $query=DB::table('orders')->orderBy('id','DESC');

        //condition dawa hoyece value ase kina dekhar jonno.
        
         if($request->payment_type){
           $query->where('payment_type', $request->payment_type);
          }
          if($request->date){
            $order_date=date('d-m-Y',strtotime($request->date));
            $query->where('date', $order_date);
           }
       
        if($request->status==0){
          $query->where('status', 0);
         }
         if($request->status==1){
          $query->where('status', 1);
         }
         if($request->status==2){
          $query->where('status', 2);
         }
         if($request->status==3){
          $query->where('status', 3);
         }
         if($request->status==4){
          $query->where('status', 4);
         }
         if($request->status==5){
          $query->where('status', 5);
         }

        $product=$query->get();

          return DataTables::of($product)
            ->addIndexColumn()
            
            //eloquent orm diye join kore database field gulo call kora hoyece.

            // ->editColumn('category_name', function($row){
            //     return $row->category->category_name;
            // })
            // ->editColumn('subcategory_name', function($row){
            //     return $row->subcategory->subcategory_name;
            // })
            // ->editColumn('brand_name', function($row){
            //     return $row->brand->brand_name;
            // })

            ->editColumn('status', function($row){
                if ($row->status==0) {
                  return '<span class="badge badge-danger">pending</span>';
                }elseif($row->status==1) {
                  return '<span class="badge badge-primary">received</span>';
                }elseif($row->status==2) {
                  return '<span class="badge badge-info">shipped</span>';
                }elseif($row->status==3) {
                  return '<span class="badge badge-success">completed</span>';
                }elseif($row->status==4) {
                  return '<span class="badge badge-warning">return</span>';
                }elseif($row->status==5) {
                  return '<span class="badge badge-danger">cancel</span>';
                }
            })
            ->addColumn('action', function($row){

                $actionbtn='<a href="#" data-id="'.$row->id.'" class="btn btn-info btn-sm edit" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-success btn-sm view" data-id="'.$row->id.'" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye"></i></a>
                <a href="'.route('order.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i></a>';

                return $actionbtn;
            })
            ->rawColumns(['action','status'])
            ->make(true);
      }
          
      return view('admin.order.index');

      }

      //admin order edit
      public function adminorderedit($id)
      {
          $order=DB::table('orders')->where('id',$id)->first();
            return view('admin.order.edit', compact('order'));
      }

      //admin order update status
      public function updatestatus(Request $request)
      {
          $data=array();
          $data['c_name']=$request->c_name;
          $data['c_address']=$request->c_address;
          $data['c_phone']=$request->c_phone;
          $data['status']=$request->status;
          $data['c_email']=$request->c_email;

          if ($request->status=='1') {
            Mail::to($request->c_email)->send(new ReceivedMail($data));
          }
          
          DB::table('orders')->where('id',$request->id)->update($data);
            return response()->json('Successfully Changed Stauts!');
      }

      //admin order with order details view
      public function adminorderview($id)
      {
          $order=DB::table('orders')->where('id',$id)->first();
          $order_details=DB::table('order_details')->where('order_id',$id)->get();
            return view('admin.order.order_details',compact('order','order_details'));
      }

      //admin order with order details delete
      public function destroy($id)
      {
          $order=DB::table('orders')->where('id',$id)->delete();
          $order_details=DB::table('order_details')->where('order_id',$id)->delete();

          $notification=array('message' => 'Order Deleted!','alert-type'=>'success' );
            return redirect()->back()->with($notification);
      }
}
