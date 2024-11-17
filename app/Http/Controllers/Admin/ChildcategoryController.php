<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Illuminate\Support\Str;

class ChildcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //childcategory index method
    public function index(Request $request)
    {
        if ($request->ajax()) {
          $data=DB::table('childcategories')->leftJoin('categories','childcategories.category_id','categories.id')->leftJoin('subcategories','childcategories.subcategory_id','subcategories.id')
            ->select('categories.category_name','subcategories.subcategory_name','childcategories.*')->get();

            return DataTables::of($data)
              ->addIndexColumn()
              ->addColumn('action', function($row){

                  $actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></a>
                  <a href="'.route('childcategory.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i></a>';

                  return $actionbtn;
              })
              ->rawColumns(['action'])
              ->make(true);
        }

        $category=DB::table('categories')->get();
        return view('admin.categories.childcategory.index',compact('category'));
    }

    //childcategory store method
    public function store(Request $request)
    {
      $cat=DB::table('subcategories')->where('id',$request->subcategory_id)->first();

      $data=array();
      $data['category_id']=$cat->category_id;
      $data['subcategory_id']=$request->subcategory_id;
      $data['childcategory_slug']=Str::slug($request->childcategory_name, '-');
      $data['childcategory_name']=$request->childcategory_name;

      DB::table('childcategories')->insert($data);

      $notification=array('message' => 'Child Category Inserted!','alert-type'=>'success' );
      return redirect()->back()->with($notification);

    }

    //childcategory delete method
    public function destroy($id)
    {
        DB::table('childcategories')->where('id',$id)->delete();

        $notification=array('message' => 'Child Category Deleted!','alert-type'=>'success' );
        return redirect()->back()->with($notification);
    }

    //childcategory edit method
    public function edit($id)
    {
      //category table value request er maddhome ana hoyece
      $category=DB::table('categories')->get();
      $data=DB::table('childcategories')->where('id',$id)->first();
      return view('admin.categories.childcategory.edit',compact('category','data'));
    }

    //childcategory update method
    public function update(Request $request)
    {
      $cat=DB::table('subcategories')->where('id',$request->subcategory_id)->first();

      $data=array();
      $data['category_id']=$cat->category_id;
      $data['subcategory_id']=$request->subcategory_id;
      $data['childcategory_slug']=Str::slug($request->childcategory_name, '-');
      $data['childcategory_name']=$request->childcategory_name;

      DB::table('childcategories')->where('id',$request->id)->update($data);

      $notification=array('message' => 'Child Category Updated!','alert-type'=>'success' );
      return redirect()->back()->with($notification);
    }

}
