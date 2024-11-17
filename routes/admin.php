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
// All Admin route write here

Route::get('/admin-login', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin'])->name('admin.login');

//Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin.home')->Middleware('is_admin');

Route::group(['namespace'=>'App\Http\Controllers\Admin','middleware' =>'is_admin'], function(){
  Route::get('/admin/home','AdminController@admin' )->name('admin.home');
  Route::get('/admin/logout','AdminController@logout' )->name('admin.logout');
  Route::get('/admin/password/change','AdminController@passwordchange' )->name('admin.password.change');
  Route::post('/admin/password/update','AdminController@passwordupdate' )->name('admin.password.update');

  //category route
  Route::group(['prefix'=>'category'],function(){
    Route::get('/','CategoryController@index' )->name('category.index');
    Route::post('/store','CategoryController@store')->name('category.store');
    Route::get('/delete/{id}','CategoryController@destroy' )->name('category.delete');
    Route::get('/edit/{id}','CategoryController@edit');
    Route::post('/update','CategoryController@update')->name('category.update');
  });

  //global route
  Route::get('/get-child-category/{id}','CategoryController@GetChildCategory');

  //subcategory route
  Route::group(['prefix'=>'subcategory'],function(){
    Route::get('/','SubCategoryController@index' )->name('subcategory.index');
    Route::post('/store','SubCategoryController@store')->name('subcategory.store');
    Route::get('/delete/{id}','SubCategoryController@destroy' )->name('subcategory.delete');
    Route::get('/edit/{id}','SubCategoryController@edit');
    Route::post('/update','SubCategoryController@update')->name('subcategory.update');
  });

  //childcategory route
  Route::group(['prefix'=>'childcategory'],function(){
    Route::get('/','ChildcategoryController@index' )->name('childcategory.index');
    Route::post('/store','ChildcategoryController@store')->name('childcategory.store');
    Route::get('/delete/{id}','ChildcategoryController@destroy' )->name('childcategory.delete');
    Route::get('/edit/{id}','ChildcategoryController@edit');
    Route::post('/update','ChildcategoryController@update')->name('childcategory.update');
  });

  //brand route
  Route::group(['prefix'=>'brand'],function(){
    Route::get('/','BrandController@index' )->name('brand.index');
    Route::post('/store','BrandController@store')->name('brand.store');
    Route::get('/delete/{id}','BrandController@destroy' )->name('brand.delete');
    Route::get('/edit/{id}','BrandController@edit');
    Route::post('/update','BrandController@update')->name('brand.update');
  });

  //product route
  Route::group(['prefix'=>'product'],function(){
    Route::get('/','ProductController@index' )->name('product.index');
    Route::get('/create','ProductController@create' )->name('product.create');
    Route::post('/store','ProductController@store')->name('product.store');
    Route::get('/delete/{id}','ProductController@destroy' )->name('product.delete');
    Route::get('/edit/{id}','ProductController@edit')->name('product.edit');;
    Route::post('/update','ProductController@update')->name('product.update');
    Route::get('/not-featured/{id}','ProductController@notfeatured');
    Route::get('/active-featured/{id}','ProductController@activefeatured');
    Route::get('/not-todaydeal/{id}','ProductController@nottodaydeal');
    Route::get('/active-todaydeal/{id}','ProductController@activetodaydeal');
    Route::get('/not-status/{id}','ProductController@notstatus');
    Route::get('/active-status/{id}','ProductController@activestatus');
  });

  //coupon route
  Route::group(['prefix'=>'coupon'],function(){
    Route::get('/','CouponController@index' )->name('coupon.index');
    Route::post('/store','CouponController@store')->name('coupon.store');
    Route::delete('/delete/{id}','CouponController@destroy' )->name('coupon.delete');
    Route::get('/edit/{id}','CouponController@edit');
    Route::post('/update','CouponController@update')->name('coupon.update');
  });

   //campaing route
  Route::group(['prefix'=>'campaing'],function(){
    Route::get('/','CampaignController@index' )->name('campaing.index');
    Route::post('/store','CampaignController@store')->name('campaing.store');
    Route::get('/delete/{id}','CampaignController@destroy' )->name('campaing.delete');
    Route::get('/edit/{id}','CampaignController@edit');
    Route::post('/update','CampaignController@update')->name('campaing.update');
  });

    //admin order route
  Route::group(['prefix'=>'order'],function(){
    Route::get('/','OrderController@index' )->name('admin.order.index');
    // Route::post('/store','CampaignController@store')->name('campaing.store');
    Route::get('/delete/{id}','OrderController@destroy' )->name('order.delete');
    Route::get('/admin/edit/{id}','OrderController@adminorderedit');
    Route::get('/admin/view/{id}','OrderController@adminorderview');
    Route::post('/status/update','OrderController@updatestatus')->name('order.status.update');
  });

  //warehouse route
  Route::group(['prefix'=>'warehouse'],function(){
    Route::get('/','WarehouseController@index' )->name('warehouse.index');
    Route::post('/store','WarehouseController@store')->name('warehouse.store');
    Route::get('/delete/{id}','WarehouseController@destroy' )->name('warehouse.delete');
    Route::get('/edit/{id}','WarehouseController@edit');
    Route::post('/update','WarehouseController@update')->name('warehouse.update');
  });

  //setting route
  Route::group(['prefix'=>'setting'],function(){
    //seo setting
    Route::group(['prefix'=>'seo'],function(){
      Route::get('/','SettingController@seo' )->name('seo.setting');
      Route::post('/update/{id}','SettingController@seoupdate')->name('seo.setting.update');
    });

    //smtp setting
    Route::group(['prefix'=>'smtp'],function(){
      Route::get('/','SettingController@smtp' )->name('smtp.setting');
      Route::post('/update/{id}','SettingController@smtpupdate')->name('smtp.setting.update');
    });

    //page setting
    Route::group(['prefix'=>'page'],function(){
      Route::get('/','PageController@index' )->name('page.index');
      Route::get('/create','PageController@create' )->name('create.page');
      Route::post('/store','PageController@store')->name('page.store');
      Route::get('/delete/{id}','PageController@destroy')->name('page.delete');
      Route::get('/edit/{id}','PageController@edit')->name('page.edit');
      Route::post('/update/{id}','PageController@update')->name('page.update');
    });

    //website setting
    Route::group(['prefix'=>'website'],function(){
      Route::get('/','SettingController@website' )->name('website.setting');
      Route::post('/update/{id}','SettingController@websiteupdate')->name('website.setting.update');
    });

    //payment gateway
    Route::group(['prefix'=>'payment-gateway'],function(){
      Route::get('/','SettingController@paymentgateway')->name('payment.gateway');
      Route::post('/update/aamerpay','SettingController@updateaamerpay')->name('update.aamerpay');
      Route::post('/update/surjopay','SettingController@updatesurjopay')->name('update.surjopay');
    });

    //pickuppoint route
    Route::group(['prefix'=>'pickup-point'],function(){
      Route::get('/','PickupController@index' )->name('pickuppoint.index');
      Route::post('/store','PickupController@store')->name('pickup.point.store');
      Route::get('/delete/{id}','PickupController@destroy' )->name('pickuppoint.delete');
      Route::get('/edit/{id}','PickupController@edit');
      Route::post('/update','PickupController@update')->name('pickup.point.update');
    });

    //ticket route
    Route::group(['prefix'=>'ticket'],function(){
      Route::get('/','TicketController@index' )->name('ticket.index');
      Route::post('/ticket/reply','TicketController@replyticket')->name('admin.store.ticket');
      Route::get('/ticket/delete/{id}','TicketController@destroy' )->name('admin.ticket.delete');
      Route::get('/view/ticket/{id}','TicketController@viewticket')->name('view.ticket');
      Route::get('/close/ticket/{id}','TicketController@closeticket')->name('admin.close.ticket');
      // Route::post('/update','PickupController@update')->name('pickup.point.update');
    });

      //blog category route
    Route::group(['prefix'=>'blog-category'],function(){
      Route::get('/','BlogController@index' )->name('admin.blog.category');
      Route::post('/store','BlogController@store')->name('blog.category.store');
      Route::get('/delete/{id}','BlogController@destroy' )->name('blog.category.delete');
      Route::get('/edit/{id}','BlogController@edit');
      Route::post('/update','BlogController@update')->name('blog.category.update');
    });

  });

});
