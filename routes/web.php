<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// All Frontend route write Here

Auth::routes();

Route::get('/login', function(){
  return redirect()->to('/');
})->name('login');

/*Route::get('/access', function(){
  return view();
})->name('access');*/

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/customer/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('customer.logout');

//frontend all routes here
Route::group(['namespace'=>'App\Http\Controllers\Front'], function(){
  Route::get('/','IndexController@index');
  Route::get('/product-details/{slug}','IndexController@productdetails')->name('product.details');

  Route::get('/product-quick-view/{id}','IndexController@productquickview');
  Route::post('/add-to-cart','CartController@addtocartqv')->name('add.to.cart.quickview');
  
  //cart
  Route::get('/all-cart','CartController@allcart')->name('all.cart'); // ajax request for subtotal
  Route::get('/my/cart','CartController@mycart')->name('cart'); 
  Route::get('/cart/empty','CartController@cartempty')->name('cart.empty'); 
  Route::get('/cartproduct/remove/{rowId}','CartController@removeproduct'); 
  Route::get('/cartproduct/updateqty/{rowId}/{qty}','CartController@updateqty'); 
  Route::get('/cartproduct/updatecolor/{rowId}/{color}','CartController@updatecolor'); 
  Route::get('/cartproduct/updatesize/{rowId}/{size}','CartController@updatesize'); 

  //whishlist
  Route::get('/add/wishlist/{id}','CartController@addwishlist')->name('add.wishlist');
  Route::get('/wishlist','CartController@wishlist')->name('wishlist');
  Route::get('/wishlist/empty','CartController@wishlistempty')->name('wishlist.empty');
  Route::get('/wishlistproduct/delete/{id}','CartController@wishlistproductdelete')->name('wishlistproduct.delete');

  //categorywise product route
  Route::get('/category/product/{id}','IndexController@categorywiseproduct')->name('categorywise.product');
  Route::get('/subcategory/product/{id}','IndexController@subcategorywiseproduct')->name('subcategorywise.product');
  Route::get('/childcategory/product/{id}','IndexController@childcategorywiseproduct')->name('childcategorywise.product');

  //brandwise product route
  Route::get('/brandwise/product/{id}','IndexController@brandwiseproduct')->name('brandwise.product');

  //review for product route
  Route::post('/store/review','ReviewController@store')->name('review.store');

  //this review for website not product
  Route::get('/write/review','ReviewController@write')->name('review.write');
  Route::post('/store/website/review','ReviewController@storewebsitereview')->name('store.website.review');

  //setting route and profile
  Route::get('/home/setting','ProfileController@setting')->name('customer.setting');
  Route::post('/home/password/change','ProfileController@customerpasswordchange')->name('customer.password.change');
  Route::get('/page/{page_slug}','IndexController@pageview')->name('page.view');
  Route::get('/my/order','ProfileController@myorder')->name('my.order');
  Route::get('/view/order/{id}','ProfileController@vieworder')->name('view.order');

  //newsletter route
  Route::post('/store/newsletter','IndexController@storenewsletter')->name('store.newsletter');

  //checkout route
  Route::get('/checkout','CheckoutController@checkout')->name('checkout');
  Route::post('/apply/coupon','CheckoutController@applycoupon')->name('apply.coupon');
  Route::get('/remove/coupon','CheckoutController@removecoupon')->name('remove.coupon');
  Route::post('/order/place','CheckoutController@orderplace')->name('order.place');

  //support ticket route
  Route::get('/open/ticket','ProfileController@openticket')->name('open.ticket');
  Route::get('/new/ticket','ProfileController@newticket')->name('new.ticket');
  Route::post('/store/ticket','ProfileController@storeticket')->name('store.ticket');
  Route::get('/show/ticket/{id}','ProfileController@showticket')->name('show.ticket');
  Route::post('/reply/ticket','ProfileController@replyticket')->name('reply.ticket');

  //order tracking
  Route::get('/order/tracking','IndexController@ordertracking')->name('order.tracking');
  Route::post('/check/order','IndexController@checkorder')->name('check.order');

  //aamarpay paymet gateway
  Route::post('/success','CheckoutController@success')->name('success');
  Route::post('/fail','CheckoutController@fail')->name('fail');

  //contact route
  Route::get('/contact-us','IndexController@contact')->name('contact');
  //blog route
  Route::get('/blog','IndexController@blog')->name('blog');

});

