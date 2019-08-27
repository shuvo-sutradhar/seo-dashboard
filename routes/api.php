<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::apiResources(['/order-form' => 'API\OrderFormController']);
Route::get('/create-form','API\OrderFormController@create');
Route::patch('/order-form-status/{status}','API\OrderFormController@create');
Route::get('/order-form-status/{id}/{status}','API\OrderFormController@status')->name('order-form-status');
Route::get('/order-form-duplocate/{id}','API\OrderFormController@duplicate')->name('order-form-duplocate');
/*
* Order form submit
*/
Route::apiResources(['/submit-form' => 'API\FormSubmitController']);
Route::post('/create-order','API\FormSubmitController@createOrder');

/*
* Order controller
*/

Route::apiResources(['/orders' => 'API\OrderController']);
Route::get('/show-order/{order_number}','API\OrderController@show');
Route::put('/orders/order-note/{id}','API\OrderController@order_note');
Route::put('/orders/order-status/{id}','API\OrderController@order_status');
Route::put('/orders/order-following/{order_number}','API\OrderController@order_follow');
Route::put('/orders/order-assign/{order_number}','API\OrderController@assign_orders');
/*
* Invoice controller
*/

Route::apiResources(['/invoices' => 'API\InvoiceController']);
Route::get('/create-invoice','API\InvoiceController@create');