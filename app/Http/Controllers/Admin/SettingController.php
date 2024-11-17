<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Image;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //seo page show method
    public function seo()
    {
      $data=DB::table('seos')->first();
        return view('admin.setting.seo',compact('data'));
    }

    //seo update method
    public function seoupdate(Request $request, $id)
    {
        $data=array();
        $data['meta_title']=$request->meta_title;
        $data['meta_author']=$request->meta_author;
        $data['meta_tag']=$request->meta_tag;
        $data['meta_keyword']=$request->meta_keyword;
        $data['meta_description']=$request->meta_description;
        $data['google_verification']=$request->google_verification;
        $data['alexa_verification']=$request->alexa_verification;
        $data['google_analytics']=$request->google_analytics;
        $data['google_adsense']=$request->google_adsense;

        DB::table('seos')->where('id',$id)->update($data);

        $notification=array('message' => 'SEO Setting Updated!','alert-type'=>'success' );
        return redirect()->back()->with($notification);
    }

    //smtp setting method
    public function smtp()
    {
      $smtp=DB::table('smtps')->first();
        return view('admin.setting.smtp',compact('smtp'));
    }

    //smtp update method
    public function smtpupdate(Request $request, $id)
    {
      $data=array();
      $data['mailer']=$request->mailer;
      $data['host']=$request->host;
      $data['port']=$request->port;
      $data['username']=$request->username;
      $data['password']=$request->password;

      DB::table('smtps')->where('id',$id)->update($data);

      $notification=array('message' => 'SMTP Setting Updated!','alert-type'=>'success' );
      return redirect()->back()->with($notification);
    }

    //website setting method
    public function website()
    {
      $setting=DB::table('settings')->first();
        return view('admin.setting.website',compact('setting'));
    }

    //website update method
    public function websiteupdate(Request $request, $id)
    {
      $data=array();
      $data['currency']=$request->currency;
      $data['phone_one']=$request->phone_one;
      $data['phone_two']=$request->phone_two;
      $data['main_email']=$request->main_email;
      $data['support_email']=$request->support_email;
      $data['address']=$request->address;
      $data['facebook']=$request->facebook;
      $data['twitter']=$request->twitter;
      $data['instagram']=$request->instagram;
      $data['linkedin']=$request->linkedin;
      $data['youtube']=$request->youtube;

      if ($request->logo) {  //jodi new logo die thake
        $logo=$request->logo;
        $logo_name=uniqid().'.'.$logo->getClientOriginalExtension();
        Image::make($logo)->resize(320,120)->save('public/files/setting/'.$logo_name);
        $data['logo']='public/files/setting/'.$logo_name;
      }else {  //jodi new logo na day
        $data['logo']=$request->old_logo;
      }

      if ($request->favicon) {  //jodi new favicon die thake
        $favicon=$request->favicon;
        $favicon_name=uniqid().'.'.$favicon->getClientOriginalExtension();
        Image::make($favicon)->resize(32,32)->save('public/files/setting/'.$favicon_name);
        $data['favicon']='public/files/setting/'.$favicon_name;
      }else {  //jodi new logo na day
        $data['favicon']=$request->old_favicon;
      }

      DB::table('settings')->where('id',$id)->update($data);

      $notification=array('message' => 'Setting Updated!','alert-type'=>'success' );
      return redirect()->back()->with($notification);
    }

    //bd payment gateway method
    public function paymentgateway()
    {
      $aamerpay=DB::table('bd_payment_gateway')->first();
      $surjopay=DB::table('bd_payment_gateway')->skip(1)->first();
      $ssl=DB::table('bd_payment_gateway')->skip(2)->first();

        return view('admin.bdpayment_gateway.edit',compact('aamerpay','surjopay','ssl'));
    }

    //update aamerpay method
    public function updateaamerpay(Request $request)
    {
      $date=array();
      $data['store_id']=$request->store_id;
      $data['signature_key']=$request->signature_key;
      $data['status']=$request->status;

      DB::table('bd_payment_gateway')->where('id',$request->id)->update($data);

      $notification=array('message' => 'Payment Gateway Updated!','alert-type'=>'success' );
      return redirect()->back()->with($notification);
    }

    //update surjoypay method
    public function updatesurjopay(Request $request)
    {
      $date=array();
      $data['store_id']=$request->store_id;
      $data['signature_key']=$request->signature_key;
      $data['status']=$request->status;

      DB::table('bd_payment_gateway')->where('id',$request->id)->update($data);

      $notification=array('message' => 'Payment Gateway Updated!','alert-type'=>'success' );
      return redirect()->back()->with($notification);
    }


}
