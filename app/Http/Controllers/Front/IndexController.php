<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Review;
use DB;

class IndexController extends Controller
{
      //root page

      public function index()
      {
        //$category=Category::all();
        $category=DB::table('categories')->get();
        $brand=DB::table('brands')->where('front_page',1)->limit(24)->get();
        $bannerproduct=Product::where('status',1)->where('product_slider',1)->latest()->first();
        $featured=Product::where('status',1)->where('featured',1)->orderBy('id','DESC')->limit(8)->get();
        $todaydeal=Product::where('status',1)->where('today_deal',1)->orderBy('id','DESC')->limit(6)->get();
        $popular_product=Product::where('status',1)->orderBy('product_view','DESC')->limit(8)->get();
        $trendy_product=Product::where('status',1)->where('trendy',1)->orderBy('id','DESC')->limit(8)->get();
        $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();
        $wbreview=DB::table('wbreviews')->where('status',1)->orderBy('id', 'DESC')->limit(12)->get();
        


        //homepage category product show
        $home_category=DB::table('categories')->where('home_page',1)->orderBy('category_name','ASC')->get();
        //campaing frontend show
        $campaing=DB::table('campaigns')->where('status',1)->orderBy('id','DESC')->first();

          return view('frontend.index',compact('category','bannerproduct','featured','popular_product','trendy_product','home_category','brand','random_product','todaydeal','wbreview','campaing'));
      }

      //single product page calling method
      public function productdetails($slug) 
       {
          $product=Product::where('slug',$slug)->first();
                   Product::where('slug',$slug)->increment('product_view');
          $related_product=Product::where('category_id',$product->category_id)->orderBy('id','DESC')->take(10)->get();

          $reviews=Review::where('product_id',$product->id)->get();
          
            return view('frontend.product.product_details',compact('product','related_product','reviews'));
       }

       //product quick view method

       public function productquickview($id)
        {
            $product=Product::where('id',$id)->first();
              return view('frontend.product.quick_view',compact('product'));
        } 

        //categorywise product page method
        public function categorywiseproduct($id)
        {
            $category=DB::table('categories')->where('id',$id)->first();
            $subcategory=DB::table('subcategories')->where('category_id',$id)->get();
            $brand=DB::table('brands')->get();
            $product=DB::table('products')->where('category_id',$id)->paginate(60);
            $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();

              return view('frontend.product.category_products', compact('category','subcategory','brand','product','random_product'));
        }

        //subcategorywise product page method
        public function subcategorywiseproduct($id)
        {
            $subcategory=DB::table('subcategories')->where('id',$id)->first();
            $childcategory=DB::table('childcategories')->where('subcategory_id',$id)->get();
            $brand=DB::table('brands')->get();
            $product=DB::table('products')->where('subcategory_id',$id)->paginate(60);
            $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();

              return view('frontend.product.subcategory_products', compact('subcategory','childcategory','brand','product','random_product'));
        }

        //childcategorywise product page method
        public function childcategorywiseproduct($id)
        {
            $childcategory=DB::table('childcategories')->where('id',$id)->first();
            $category=DB::table('categories')->get();
            $brand=DB::table('brands')->get();
            $product=DB::table('products')->where('childcategory_id',$id)->paginate(60);
            $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();

              return view('frontend.product.childcategory_products', compact('childcategory','category','brand','product','random_product'));
        }

        //brandwise product page method
        public function brandwiseproduct($id)
        {
            $brand=DB::table('brands')->where('id',$id)->first();
            $category=DB::table('categories')->get();
            $brands=DB::table('brands')->get();
            $product=DB::table('products')->where('brand_id',$id)->paginate(60);
            $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();

              return view('frontend.product.brand_products', compact('brand','category','brands','product','random_product'));
        }

        //custom page view method
        public function pageview($page_slug)
        {
          
          $page=DB::table('pages')->where('page_slug', $page_slug)->first();
              return view('frontend.page',compact('page'));
        }

        //store newsletter method
        public function storenewsletter(Request $request)
        {
            $email=$request->email;
            $check=DB::table('newsletter')->where('email',$email)->first();

            if($check){
             return response()->json('Email Already Exist');
            } else{
              $data=array();
              $data['email']=$request->email;
              DB::table('newsletter')->insert($data);

              return response()->json('Thanks for subscribe us');
            }
        }

        //order tracking method
        public function ordertracking()
        {
          return view('frontend.order_tracking');
        }

        //check order method
        public function checkorder(Request $request)
        {
          $check=DB::table('orders')->where('order_id',$request->order_id)->first();

          if ($check) {
            $order=DB::table('orders')->where('order_id',$request->order_id)->first();
            $order_details=DB::table('order_details')->where('order_id',$order->id)->get();
              return view('frontend.order_details',compact('order','order_details'));
          }else{
            $notification=array('message' => 'Invalid Order Id! Try Again','alert-type'=>'error' );
                return redirect()->back()->with($notification);
          }
        }

        //contact us method
        public function contact()
        {
          return view('frontend.contact');
        }

        //blog method
        public function blog()
        {
          return view('frontend.blog');
        }

}
