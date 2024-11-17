<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // subcategory method
    public function index()
    {
      //query builder with one to one join
      // $data=DB::table('subcategories')->leftJoin('categories','subcategories.category_id','categories.id')
      //   ->select('subcategories.*','categories.category_name')->get();

      //Eloquent ORM
        $data=Subcategory::all();
        $category=Category::all();
        
        //query builder
        //$category=DB::table('categories')->get();
        return view('admin.categories.subcategory.index',compact('data','category'));
    }

    //store method
    public function store(Request $request)
    {
      $validated = $request->validate([
        'subcategory_name' => 'required|max:55',
      ]);

      // $data=array();
      // $data['category_id']=$request->category_id;
      // $data['subcategory_name']=$request->subcategory_name;
      // $data['subcate_slug']=Str::slug($request->subcategory_name, '-');
      //
      // DB::table('subcategories')->insert($data);

      //Eloquent ORM
      SubCategory::insert([
        'category_id'=>$request->category_id,
        'subcategory_name'=>$request->subcategory_name,
        'subcate_slug'=>Str::slug($request->subcategory_name, '-'),
      ]);

      $notification=array('message' => 'Subcategory Inserted!','alert-type'=>'success' );
      return redirect()->back()->with($notification);
    }

    // Subcategory Destroy method

    public function destroy($id)
    {
      //query builder
      //DB::table('subcategories')->where('id',$id)->delete();

      //Eloquent ORM
      //$subcat=Subcategory::where('id',$id)->delete();
      //$subcat=Subcategory::findOrFail($id);
      $subcat=Subcategory::find($id);
      $subcat->delete();

      $notification=array('message' => 'Subcategory Deleted!','alert-type'=>'success' );
      return redirect()->back()->with($notification);
    }

    //subcategory edit method

    public function edit($id)
    {
      //Eloquent ORM
      // $data=Subcategory::find($id);
      // $category=Category::all();

      //query builder
      $data=Subcategory::find($id);
      $category=DB::table('categories')->get();

      return view('admin.categories.subcategory.edit',compact('data','category'));
    }

    //subcategory update method
    public function update(Request $request)
    {
      //query builder
      // $data=$request->id; //aita niche query te dile r dite hobe na.
      // $data=array();
      // $data['category_id']=$request->category_id;
      // $data['subcategory_name']=$request->subcategory_name;
      // $data['subcate_slug']=Str::slug($request->subcategory_name, '-');
      // DB::table('subcategories')->where('id',$request->id)->update($data);


      //Eloquent ORM
      $subcategory=SubCategory::where('id',$request->id)->firstOrFail();
      $subcategory->update([
        'category_id'=>$request->category_id,
        'subcategory_name'=>$request->subcategory_name,
        'subcate_slug'=>Str::slug($request->subcategory_name, '-'),
      ]);

      $notification=array('message' => 'Subcategory updated!','alert-type'=>'success' );
      return redirect()->back()->with($notification);
    }
}
