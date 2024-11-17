<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Category;
use Illuminate\Support\Str;
use Image;
use File;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //all category showing method
    public function index()
    {
      //query builder
      //$data=DB::table('categories')->get();
      $data=Category::all(); //eloquent ORM
        return view('admin.categories.category.index',compact('data'));
    }

    //store method
    public function store(Request $request)
    {
      $validated = $request->validate([
        'category_name' => 'required|unique:categories|max:55',
        'icon' => 'required',
    ]);
    //query builder
    // $data=array();
    // $data['category_name']=$request->category_name;
    // $data['category_slug']=Str::slug($request->category_name, '-');
    // DB::table('categories')->insert($data);

    //Eloquent ORM [eti models niye kaj kore]
      $slug=Str::slug($request->category_name, '-');
      $photo=$request->icon;
      $photoname=$slug.'.'.$photo->getClientOriginalExtension();  
      Image::make($photo)->resize(32,32)->save('public/files/category/'.$photoname); //image intervention

      Category::insert([
        'category_name'=>$request->category_name,
        'category_slug'=>$slug,
        'home_page'=>$request->home_page,
        'icon'=>'public/files/category/'.$photoname,
      ]);

    $notification=array('message' => 'Category Inserted!','alert-type'=>'success' );
    return redirect()->back()->with($notification); //same route a thakar jonno back() korte hoi.
    }

    //edit category method
    public function edit($id)
    {
      //query builder
      // $data=DB::table('categories')->where('id',$id)->first();

      //Eloquent ORM
      $data=Category::findOrFail($id);
        return view('admin.categories.category.edit',compact('data'));
      //return response()->json($data);
    }

    //update category method
    public function update(Request $request)
    {
      //query builder
      //$data=$request->id; aita niche query te dile r dite hobe na.
      // $data=array();
      // $data['category_name']=$request->category_name;
      // $data['category_slug']=Str::slug($request->category_name, '-');
      // DB::table('categories')->where('id',$request->id)->update($data);

      //Eloquent ORM

      /*$category=Category::where('id',$request->id)->firstOrFail();
      $category->update([
        'category_name'=>$request->category_name,
        'category_slug'=>Str::slug($request->category_name, '-'),
      ]);*/
    $slug=Str::slug($request->category_name, '-');

    $data=array();
    $data['category_name']=$request->category_name;
    $data['category_slug']=$slug;
    $data['home_page']=$request->home_page;

      if ($request->icon) {
        if (File::exists($request->old_icon)) {
          unlink($request->old_icon);
        }
        $photo=$request->icon;
        $photoname=$slug.'.'.$photo->getClientOriginalExtension();
        Image::make($photo)->resize(32,32)->save('public/files/category/'.$photoname);
        $data['icon']='public/files/category/'.$photoname;

        DB::table('categories')->where('id',$request->id)->update($data);

        $notification=array('message' => 'Category Updated!','alert-type'=>'success' );
        return redirect()->back()->with($notification);

      }else{
        $data['icon']=$request->old_icon;
  
        DB::table('categories')->where('id',$request->id)->update($data);

        $notification=array('message' => 'Category Updated!','alert-type'=>'success' );
        return redirect()->back()->with($notification);
      }
    }

    //delete category method
    public function destroy($id)
    {
      //query builder
      // DB::table('categories')->where('id',$id)->delete();

      //Eloquent ORM
      $category=Category::findOrFail($id);
      $category->delete();
      $notification=array('message' => 'Category Deleted!','alert-type'=>'success' );
      return redirect()->back()->with($notification);
    }

    //global getchildcategory method
    public function GetChildCategory($id)  //amra ekhane peyeci 'subcategory_id'
    {
        $data=DB::table('childcategories')->where('subcategory_id',$id)->get();  //jekhane 'subcategory_id' equal je $id method a pathiyeci.
        return response()->json($data);
    }


}
