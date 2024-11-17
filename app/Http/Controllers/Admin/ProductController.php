<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Auth;
use Image;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Pickuppoint;
use File;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //product index method
    public function index(Request $request)
    {
      if ($request->ajax()) {
        $imgurl='public/files/product';

        //$data=Product::latest()->get(); //eloquent orm joint korar jonno model ke call kora hoyece.

        //query join
        $product=""; //query join korar jonno aita initial kora hoyece.
        $query=DB::table('products')->leftJoin('categories','products.category_id','categories.id')
                                   ->leftJoin('subcategories','products.subcategory_id','subcategories.id')
                                   ->leftJoin('brands','products.brand_id','brands.id');

        //condition dawa hoyece value ase kina dekhar jonno.
        if($request->category_id){
          $query->where('products.category_id', $request->category_id);
         }
         if($request->brand_id){
           $query->where('products.brand_id', $request->brand_id);
          }
          if($request->warehouse){
            $query->where('products.warehouse', $request->warehouse);
           }
           if($request->status==1){
             $query->where('products.status', 1);
            }
            if($request->status==0){
              $query->where('products.status', 0);
             }


        $product=$query->select('products.*','categories.category_name','subcategories.subcategory_name','brands.brand_name')
        ->get();

          return DataTables::of($product)
            ->addIndexColumn()
            ->editColumn('thumbnail', function($row) use($imgurl){
                return '<img src="'.$imgurl.'/'.$row->thumbnail.'" height="30" width="30">';
            })

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

            ->editColumn('featured', function($row){
                if ($row->featured==1) {
                  return '<a href="#" data-id="'.$row->id.'" class="deactive_featured"><i class="fas fa-thumbs-down text-danger"></i> <span class="badge badge-success">active</span> </a>';
                }else {
                  return '<a href="#" data-id="'.$row->id.'" class="active_featured"><i class="fas fa-thumbs-up text-success"></i> <span class="badge badge-danger">deactive</span> </a>';
                }
            })
            ->editColumn('today_deal', function($row){
                if ($row->today_deal==1) {
                  return '<a href="#" data-id="'.$row->id.'" class="deactive_tdeal"><i class="fas fa-thumbs-down text-danger"></i> <span class="badge badge-success">active</span> </a>';
                }else {
                  return '<a href="#" data-id="'.$row->id.'" class="active_tdeal"><i class="fas fa-thumbs-up text-success"></i> <span class="badge badge-danger">deactive</span> </a>';
                }
            })
            ->editColumn('status', function($row){
                if ($row->status==1) {
                  return '<a href="#" data-id="'.$row->id.'" class="deactive_status"><i class="fas fa-thumbs-down text-danger"></i> <span class="badge badge-success">active</span> </a>';
                }else {
                  return '<a href="#" data-id="'.$row->id.'" class="active_status"><i class="fas fa-thumbs-up text-success"></i> <span class="badge badge-danger">deactive</span> </a>';
                }
            })
            ->addColumn('action', function($row){

                $actionbtn='<a href="'.route('product.edit',[$row->id]).'" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-success btn-sm" id="delete"><i class="fas fa-eye"></i></a>
                <a href="'.route('product.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i></a>';

                return $actionbtn;
            })
            ->rawColumns(['action','category_name','subcategory_name','brand_name','thumbnail','featured','today_deal','status'])
            ->make(true);
      }

      $category=DB::table('categories')->get(); //query builder
      //$category=Category::all(); //eloquent orm
      $brand=DB::table('brands')->get();
      $warehouse=DB::table('warehouse')->get();

      return view('admin.product.index',compact('category','brand','warehouse'));
    }


    //product create method
    public function create()
    {
      $category=DB::table('categories')->get(); //Category::all();
      $brand=DB::table('brands')->get(); //Brand::all();
      $pickuppoint=DB::table('pickup_points')->get(); //Pickuppoint::all();
      $warehouse=DB::table('warehouse')->get(); //Warehouse::all();

      return view('admin.product.create',compact('category','brand','pickuppoint','warehouse'));
    }

    //product store method
    public function store(Request $request)
    {
      $validated = $request->validate([
        'product_name' => 'required',
        'product_code' => 'required|unique:products|max:55',
        'subcategory_id' => 'required',
        'brand_id' => 'required',
        'unit' => 'required',
        'selling_price' => 'required',
        'color' => 'required',
        'description' => 'required',
      ]);

      //subcategory call for category id [category id anar jonno subcategory table ke call kora hoyece]
      $subcategory=DB::table('subcategories')->where('id',$request->subcategory_id)->first();
      //$subcategory->category_id;
      $slug = Str::slug($request->product_name, '-');

      $data=array();
      $data['product_name']=$request->product_name;
      $data['slug']=Str::slug($request->product_name, '-');
      $data['product_code']=$request->product_code;
      $data['category_id']=$subcategory->category_id;
      $data['subcategory_id']=$request->subcategory_id;
      $data['childcategory_id']=$request->childcategory_id;
      $data['brand_id']=$request->brand_id;
      $data['pickup_point_id']=$request->pickup_point_id;
      $data['unit']=$request->unit;
      $data['tags']=$request->tags;
      $data['purchase_price']=$request->purchase_price;
      $data['selling_price']=$request->selling_price;
      $data['discount_price']=$request->discount_price;
      $data['warehouse']=$request->warehouse;
      $data['stock_quantity']=$request->stock_quantity;
      $data['color']=$request->color;
      $data['size']=$request->size;
      $data['description']=$request->description;
      $data['video']=$request->video;
      $data['featured']=$request->featured;
      $data['today_deal']=$request->today_deal;
      $data['product_slider']=$request->product_slider;
      $data['trendy']=$request->trendy;
      $data['status']=$request->status;
      $data['admin_id']=Auth::id();
      $data['date']=date('d-m-Y');
      $data['month']=date('F');
      $data['year']=date('Y');

      //single thumbnail show
      if ($request->thumbnail) {
        //working with image
        $thumbnail=$request->thumbnail;
        $photoname=$slug.'.'.$thumbnail->getClientOriginalExtension();
        // $photo->move('public/files/brand/',$photoname); //without image intervention
        Image::make($thumbnail)->resize(600,600)->save('public/files/product/'.$photoname); //image intervention
      $data['thumbnail']=$photoname; //public/files/product/plus-point.jpg
      }

      //working with multiple images
      $images = array();
      if($request->hasFile('images')){
        foreach ($request->file('images') as $key => $image) {
          $imageName= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
          Image::make($image)->resize(600,600)->save('public/files/product/'.$imageName);
          array_push($images,$imageName);
        }
        $data['images']=json_encode($images); //database er images field ke array te dukanor por images field ke aber json encode kora hoyace
      }
      DB::table('products')->insert($data);

      $notification=array('message' => 'Product Inserted!','alert-type'=>'success' );
      return redirect()->back()->with($notification);

    }

    //product edit method
    public function edit($id)
    {
        $product=Product::findorfail($id);
        $category=Category::all();
        $brand=Brand::all();
        $pickuppoint=DB::table('pickup_points')->get();
        $warehouse=DB::table('warehouse')->get();
        $childcategory=DB::table('childcategories')->where('subcategory_id', $product->subcategory_id)->get();
        return view('admin.product.edit',compact('product','category','brand','pickuppoint','warehouse','childcategory'));
    }

    //product update method
    public function update(Request $request)
    {
        $validated = $request->validate([
        'product_name' => 'required',
        'product_code' => 'required|max:55',
        'subcategory_id' => 'required',
        'brand_id' => 'required',
        'unit' => 'required',
        'selling_price' => 'required',
        'color' => 'required',
        'description' => 'required',
      ]);

      //subcategory call for category id [category id anar jonno subcategory table ke call kora hoyece]
      $subcategory=DB::table('subcategories')->where('id',$request->subcategory_id)->first();
      //$subcategory->category_id;
      $slug = Str::slug($request->product_name, '-');

      $data=array();
      $data['product_name']=$request->product_name;
      $data['slug']=Str::slug($request->product_name, '-');
      $data['product_code']=$request->product_code;
      $data['category_id']=$subcategory->category_id;
      $data['subcategory_id']=$request->subcategory_id;
      $data['childcategory_id']=$request->childcategory_id;
      $data['brand_id']=$request->brand_id;
      $data['pickup_point_id']=$request->pickup_point_id;
      $data['unit']=$request->unit;
      $data['tags']=$request->tags;
      $data['purchase_price']=$request->purchase_price;
      $data['selling_price']=$request->selling_price;
      $data['discount_price']=$request->discount_price;
      $data['warehouse']=$request->warehouse;
      $data['stock_quantity']=$request->stock_quantity;
      $data['color']=$request->color;
      $data['size']=$request->size;
      $data['description']=$request->description;
      $data['video']=$request->video;
      $data['featured']=$request->featured;
      $data['today_deal']=$request->today_deal;
      $data['product_slider']=$request->product_slider;
      $data['status']=$request->status;
      

      //old thumbnail ase kina, jodi thake new thumbnail insert korte hobe
    
      $thumbnail=$request->file('thumbnail');
        if($thumbnail)
        {
          $thumbnail=$request->thumbnail;
          $photoname=$slug.'.'.$thumbnail->getClientOriginalExtension();
          Image::make($thumbnail)->resize(600,600)->save('public/files/product/'.$photoname); 
        $data['thumbnail']=$photoname;
   
        }

     //multiple image update

      $old_images=$request->has('old_images');
        if($old_images){
            $images=$request->old_images;
            $data['images']=json_encode($images);
        }else{
          $images=array();
          $data['images']=json_encode($images);
        }

      if($request->hasFile('images')){
        foreach ($request->file('images') as $key => $image) {
          $imageName= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
          Image::make($image)->resize(600,600)->save('public/files/product/'.$imageName);
          array_push($images,$imageName);
        }
        $data['images']=json_encode($images);
      }

      DB::table('products')->where('id',$request->id)->update($data);

      $notification=array('message' => 'Product Updated!','alert-type'=>'success' );
      return redirect()->back()->with($notification);
    }

    //not featured method
    public function notfeatured($id)
    {
        DB::table('products')->where('id',$id)->update(['featured'=>0]);
          return response()->json('Product Not Featured');
    }

    //active featured method
    public function activefeatured($id)
    {
        DB::table('products')->where('id',$id)->update(['featured'=>1]);
          return response()->json('Product Featured Activated');
    }

    //not today deal method
    public function nottodaydeal($id)
    {
        DB::table('products')->where('id',$id)->update(['today_deal'=>0]);
          return response()->json('Product Not Today Deal');
    }

    //active today deal method
    public function activetodaydeal($id)
    {
        DB::table('products')->where('id',$id)->update(['today_deal'=>1]);
          return response()->json('Product Today Deal Activated');
    }

    //not status method
    public function notstatus($id)
    {
        DB::table('products')->where('id',$id)->update(['status'=>0]);
          return response()->json('Product Deactivated');
    }

    //active status method
    public function activestatus($id)
    {
        DB::table('products')->where('id',$id)->update(['status'=>1]);
          return response()->json('Product Activated');
    }

    //product delete method
    public function destroy($id)
    {
        $product=DB::table('products')->where('id',$id)->first(); //product data get
        if (File::exists('public/files/product/'.$product->thumbnail)) {
              File::delete('public/files/product/'.$product->thumbnail);
        }

        $images=json_decode($product->images);
          foreach($images as $image){
            if (File::exists('public/files/product/'.$image)) {
              File::delete('public/files/product/'.$image);
          }  
        }

        DB::table('products')->where('id',$id)->delete();

        $notification=array('message' => 'Product Deleted!','alert-type'=>'success' );
        return redirect()->back()->with($notification);
    }
}
