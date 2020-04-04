<?php

use Illuminate\Routing\RouteGroup;
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

//frontend
Route::get('','frontend\HomeController@GetHome');
Route::get('contact','frontend\HomeController@GetContact');
Route::get('about','frontend\HomeController@GetAbout');
Route::group(['prefix' => 'product'], function () {
    Route::get('','frontend\ProductController@ListProduct');
    Route::get('detail/{idPrd}','frontend\ProductController@DetailProduct');
    Route::get('cart','frontend\ProductController@GetCart');
    Route::get('addcart','frontend\ProductController@AddCart');
    Route::get('removecart/{id}','frontend\ProductController@RemoveCart');
    Route::get('updatecart/{id}/{qty}','frontend\ProductController@UpdateCart');
    Route::get('checkout','frontend\ProductController@CheckOut');
    Route::post('checkout','frontend\ProductController@PostCheckOut');
    Route::get('complete/{id_customer}','frontend\ProductController@Complete');
});


// backend

Route::get('login','backend\LoginController@GetLogin')->middleware('CheckLogout');
Route::post('login','backend\LoginController@PostLogin');

Route::group(['prefix' => 'admin','middleware'=>'CheckLogin'], function () {
    Route::get('','backend\LoginController@GetIndex');
    Route::get('logout','backend\LoginController@Logout');

    //category
    Route::group(['prefix' => 'category'], function () {
        Route::get('','backend\CategoryController@GetCategory');
        Route::post('','backend\CategoryController@PostAddCategory');
        Route::get('edit/{IdCate}','backend\CategoryController@EditCategory');
        Route::post('edit/{IdCate}','backend\CategoryController@PostEditCategory');
        Route::get('del/{IdCate}','backend\CategoryController@DelCategory');
    });

    //product
    Route::group(['prefix' => 'product'], function () {
        Route::get('','backend\ProductController@ListProduct');
        Route::get('add','backend\ProductController@AddProduct');
        Route::post('add','backend\ProductController@PostAddProduct');
        Route::get('edit/{idPrd}','backend\ProductController@EditProduct');
        Route::post('edit/{idPrd}','backend\ProductController@PostEditProduct');
        Route::get('del/{idPrd}','backend\ProductController@DelProduct');

        Route::post('add-attr','backend\ProductController@AddAttr');
        Route::get('detail-attr','backend\ProductController@DetailAttr');
        Route::get('edit-attr/{idAttr}','backend\ProductController@EditAttr');
        Route::post('edit-attr/{idAttr}','backend\ProductController@PostEditAttr');
        Route::get('del-attr/{idAttr}','backend\ProductController@DelAttr');

        Route::post('add-value','backend\ProductController@AddValue');
        Route::get('edit-value/{idValue}','backend\ProductController@EditValue');
        Route::post('edit-value/{idValue}','backend\ProductController@PostEditValue');
        Route::get('del-value/{idValue}','backend\ProductController@DelValue');

        Route::get('add-variant/{idPrd}','backend\ProductController@AddVariant');
        Route::post('add-variant/{idPrd}','backend\ProductController@PostAddVariant');
        Route::get('edit-variant/{idPrd}','backend\ProductController@EditVariant');
        Route::post('edit-variant/{idPrd}','backend\ProductController@PostEditVariant');
        Route::get('del-variant/{idVariant}','backend\ProductController@DelVariant');
    });

    //order
    Route::group(['prefix' => 'order'], function () {
        Route::get('','backend\OrderController@ListOrder');
        Route::get('detail/{customer_id}','backend\OrderController@DetailOrder');
        Route::get('active-order/{customer_id}','backend\OrderController@ActivelOrder');
        Route::get('processed','backend\OrderController@Processed');
    });
});


