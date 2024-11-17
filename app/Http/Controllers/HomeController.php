<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //customer order details show and database value get
        $orders=DB::table('orders')->where('user_id',Auth::id())->orderBy('id','DESC')->take(10)->get(); //orders table er id and orders_details table er order_id er sathe relation ase tai orders table theke data ana hoyece.

        //total order
        $total_order=DB::table('orders')->where('user_id',Auth::id())->count();
        //complete order
        $complete_order=DB::table('orders')->where('user_id',Auth::id())->where('status',3)->count();
        //cancel order
        $cancel_order=DB::table('orders')->where('user_id',Auth::id())->where('status',5)->count();
        //return order
        $return_order=DB::table('orders')->where('user_id',Auth::id())->where('status',4)->count();
            return view('home',compact('orders','total_order','complete_order','cancel_order','return_order'));
    }

    //fontend logout route
    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }  
}
