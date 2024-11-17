<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Cart;
use DB;
use Auth;

class CartController extends Controller
{
      //add to cart method
      public function addtocartqv(Request $request)
      {
          //3 way to retrive data from database

          // $product=DB::table('products')->where('id',$request->id)->first();
          // $product=Product::where('id',$request->id)->first();

          $product=Product::find($request->id);
          Cart::add([
            'id'=>$product->id,
            'name'=>$product->product_name,
            'qty'=>$request->qty,
            'price'=>$request->price,
            'weight'=>1,
            'options'=>['size'=>$request->size, 'color'=>$request->color, 'thumbnail'=>$product->thumbnail]

          ]);
            return response()->json("Product Added Cart");
      }

      // all cart method
      public function allcart()
      {
          $data=array();
          $data['cart_qty']=Cart::count();
          $data['cart_total']=Cart::total();

          return response()->json($data);
      }

      //wishlist add method
        public function addwishlist($id)
          {
            if(Auth::check()){
                $check=DB::table('wishlists')->where('product_id',$id)->where('user_id',Auth::id())->first();

                if($check) {
                  $notification=array('message' => 'Already have it on your wishlist!','alert-type'=>'error' );
                  return redirect()->back()->with($notification);
                }else{
                  $data=array();
                  $data['product_id']=$id;
                  $data['user_id']=Auth::id();
                  $data['wishlist_date']=date('d, F Y');
                  DB::table('wishlists')->insert($data);

                  $notification=array('message' => 'Your Product Added Wishlist Succesfully!','alert-type'=>'success' );
                  return redirect()->back()->with($notification);
                }
            }
             $notification=array('message' => 'Login Your Account!','alert-type'=>'error' );
              return redirect()->back()->with($notification); 
        }

        //cart method
        public function mycart()
             {
                 $content=Cart::content();
                    return view('frontend.cart.cart',compact('content'));
             } 

        //cart product remove method
        public function removeproduct($rowId)
            {
                Cart::remove($rowId);
                    return response()->json('Success!');
            } 
 
            //cart product update qty method
            public function updateqty($rowId,$qty)
               {
                   Cart::update($rowId, ['qty' => $qty]);
                    return response()->json('Successfully Updated!');
               }

               //cart product update color method
               public function updatecolor($rowId,$color)
                  {
                    $product=Cart::get($rowId);
                    $thumbnail=$product->options->thumbnail;
                    $color=$product->options->color;
                      Cart::update($rowId, ['options' => ['color' => $color, 'thumbnail' => $thumbnail, 'size' => $size]]);
                        return response()->json('Successfully Updated!');
                  }

              //cart product update size method
               public function updatesize($rowId,$size)
                  {
                    $product=Cart::get($rowId);
                    $thumbnail=$product->options->thumbnail;
                    $size=$product->options->size;
                      Cart::update($rowId, ['options' => ['size' => $size, 'thumbnail' => $thumbnail, 'color' => $color]]);
                        return response()->json('Successfully Updated!');
                  } 

                  //cart empty method
                  public function cartempty()
                    {
                        Cart::destroy();

                        $notification=array('message' => 'Cart item empty Succesfully!','alert-type'=>'success' );
                        return redirect()->to('/')->with($notification);
                    }

                    //wishlist method
                    public function wishlist()
                      {
                          if(Auth::check()){
                            $wishlist=DB::table('wishlists')->leftjoin('products','wishlists.product_id','products.id')->select('products.product_name','products.thumbnail','products.slug','wishlists.*')->where('wishlists.user_id',Auth::id())->get();
                                return view('frontend.cart.wishlist',compact('wishlist'));
                          }
                            $notification=array('message' => 'At first login your account!','alert-type'=>'error' );
                            return redirect()->back()->with($notification);
                      } 

                      //wishlist empty method
                      public function wishlistempty()
                       {
                           DB::table('wishlists')->where('user_id',Auth::id())->delete();
                            $notification=array('message' => 'Wishlist Empty Successfully!','alert-type'=>'success' );
                            return redirect()->back()->with($notification);
                       }

                       //wishlistproduct delete method
                       public function wishlistproductdelete($id)
                        {
                            DB::table('wishlists')->where('id',$id)->delete();
                                $notification=array('message' => 'Wishlist Product Delete Successfull!','alert-type'=>'success' );
                                return redirect()->back()->with($notification);
                        } 
}
