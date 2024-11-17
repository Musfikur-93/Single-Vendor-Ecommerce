<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Models\User;
use Image;

class ProfileController extends Controller
{
        public function __construct()
        {
            $this->middleware('auth');
        }

        // customer profile setting method
        public function setting()
        {
            return view('user.setting');
        }

        //customer password change
        public function customerpasswordchange(Request $request)
        {
            $validated = $request->validate([
              'old_password' => 'required',
              'password'=> 'required|min:8|confirmed',
            ]);

            $current_password=Auth::user()->password;

            $oldpass=$request->old_password;
            $newpass=$request->password;

            if(Hash::check($oldpass,$current_password))
            {
              $user=User::findorfail(Auth::id());
              $user->password=Hash::make($request->password);
              $user->save();
              Auth::logout();

              $notification=array('message' => 'Your Password Changed!','alert-type'=>'success');
              return redirect()->to('/')->with($notification);

            }else{
              $notification=array('message' => 'Old Password Not Matched!','alert-type'=>'error');
              return redirect()->back()->with($notification);
            }
        }

        //myorder method
        public function myorder()
        {
            $myorder=DB::table('orders')->where('user_id',Auth::id())->orderBy('id','DESC')->get();
                return view('user.my_order',compact('myorder'));
        }

        //open ticket method
        public function openticket()
        {
            $ticket=DB::table('tickets')->where('user_id',Auth::id())->orderBy('id','DESC')->take(10)->get();
                return view('user.ticket',compact('ticket'));
        }

        //new ticket method
        public function newticket()
        {
            return view('user.new_ticket');
        }

        //store ticket method
        public function storeticket(Request $request)
        {
            $validated = $request->validate([
            'subject' => 'required',
            ]);

          
          $data=array();
          $data['subject']=$request->subject;
          $data['service']=$request->service;
          $data['priority']=$request->priority;
          $data['message']=$request->message;
          $data['user_id']=Auth::id();
          $data['status']=0;
          $data['date']=date('Y-m-d');
          
          if ($request->image) {
            $photo=$request->image;
            $photoname=uniqid().'.'.$photo->getClientOriginalExtension();
            Image::make($photo)->resize(600,350)->save('public/files/ticket/'.$photoname); //image intervention
            $data['image']='public/files/ticket/'.$photoname; //public/files/brand/plus-point.jpg
          }
            

          DB::table('tickets')->insert($data);

          $notification=array('message' => 'Ticket Inserted!','alert-type'=>'success' );
          return redirect()->route('open.ticket')->with($notification);
        }

        //show ticket method
        public function showticket($id)
        {
            $showticket=DB::table('tickets')->where('id',$id)->first();
                return view('user.show_ticket',compact('showticket'));
        }

        //reply ticket method
        public function replyticket(Request $request)
        {
            $validated = $request->validate([
            'message' => 'required',
            ]);

          $data=array();
          $data['message']=$request->message;
          $data['ticket_id']=$request->ticket_id;
          $data['user_id']=Auth::id();
          $data['reply_date']=date('Y-m-d');
          
          if ($request->image) {
            $photo=$request->image;
            $photoname=uniqid().'.'.$photo->getClientOriginalExtension();
            Image::make($photo)->resize(600,350)->save('public/files/ticket/'.$photoname); //image intervention
            $data['image']='public/files/ticket/'.$photoname; //public/files/brand/plus-point.jpg
          }
            

          DB::table('replies')->insert($data);
          DB::table('tickets')->where('id',$request->ticket_id)->update(['status'=>0]); //aita hocce user jokhon reply korbe tokhon status=>0 hobe.

          $notification=array('message' => 'Replied Done!','alert-type'=>'success' );
          return redirect()->back()->with($notification);
        }

        //customer view order method
        public function vieworder($id)
        {
            $order=DB::table('orders')->where('id',$id)->first();
            //$order=Order::findorfail($id); eloquent orm

            $order_details=DB::table('order_details')->where('order_id',$id)->get();

                return view('user.order_details',compact('order','order_details'));
        }
      
}
