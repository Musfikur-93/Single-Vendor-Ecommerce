<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;
use File;
use DB;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //all category showing method
    public function index()
    {
      //query builder
      $data=DB::table('blog_category')->get();
        return view('admin.blog.category',compact('data'));
    }

    //blog category store method
    public function store(Request $request)
    {
        $validated = $request->validate([
        'category_name' => 'required|max:55',
        ]);
        //query builder
        $data=array();
        $data['category_name']=$request->category_name;
        $data['category_slug']=Str::slug($request->category_name, '-');
        DB::table('blog_category')->insert($data);

        $notification=array('message' => 'Blog Category Inserted!','alert-type'=>'success' );
        return redirect()->back()->with($notification); //same route a thakar jonno back() korte hoi.
    }

    //blog category delete method
    public function destroy($id)
    {
        DB::table('blog_category')->where('id',$id)->delete();
        $notification=array('message' => 'Blog Category Deleted!','alert-type'=>'success' );
            return redirect()->back()->with($notification);
    }

    //blog category edit method
    public function edit($id)
    {
        //query builder
        $data=DB::table('blog_category')->where('id',$id)->first();

        return view('admin.blog.category_edit',compact('data'));
    }

    //blog category update method
    public function update(Request $request)
    {
        //query builder
          $data=array();
          $data['category_name']=$request->category_name;
          $data['category_slug']=Str::slug($request->category_name, '-');
          DB::table('blog_category')->where('id',$request->id)->update($data);

            $notification=array('message' => 'Blog Category Updated!','alert-type'=>'success' );
            return redirect()->back()->with($notification);
    }
}
