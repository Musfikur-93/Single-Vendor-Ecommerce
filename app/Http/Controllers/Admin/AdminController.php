<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class AdminController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  //admin after Login
  public function admin(){
    return view('admin.home');
  }

  //admin custom Logout
  public function logout(){
    Auth::logout();
    $notification=array('message' => 'Your are logged out!','alert-type'=>'success' );
    return redirect()->route('admin.login')->with($notification);
  }

  //admin password change page
  public function passwordchange()
  {
    return view('admin.profile.password_change');
  }

  //admin password update
  public function passwordupdate(Request $request)
  {
    $validated = $request->validate([
      'old_password' => 'required',
      'password'=> 'required|confirmed',
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
      return redirect()->route('admin.login')->with($notification);

    }else{
      $notification=array('message' => 'Old Password Not Matched!','alert-type'=>'error');
      return redirect()->back()->with($notification);
    }

  }

}
