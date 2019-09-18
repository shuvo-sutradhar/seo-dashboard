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
Route::get('/edit-order/{order_number}','API\OrderController@edit');
Route::patch('/update-order/{order_number}','API\OrderController@update');
Route::put('/orders/order-note/{id}','API\OrderController@order_note');
Route::put('/orders/order-status/{id}','API\OrderController@order_status');
Route::put('/orders/order-following/{order_number}','API\OrderController@order_follow');
Route::put('/orders/order-assign/{order_number}','API\OrderController@assign_orders');
Route::put('/orders/order-tag-status/{id}','API\OrderController@tag_orders');
Route::post('/orders/order-tag/{id}','API\OrderController@order_tag');
Route::delete('/orders/order-tag/{id}','API\OrderController@order_tag_delete');
/*
* messenger controller
*/
Route::apiResources(['/message' => 'API\MessageController']);
Route::get('/message/{id}','API\MessageController@show');
Route::post('/message/send','API\MessageController@store');
/*
* order message controller
*/
Route::apiResources(['/order-message' => 'API\OrderMessageController']);
Route::post('/order-message/send','API\OrderMessageController@store');
Route::get('/order-message/{order_id}','API\OrderMessageController@show');

/*
* Invoice controller
*/

Route::apiResources(['/invoices' => 'API\InvoiceController']);
Route::get('/invoices/edit/{invoice_number}', 'API\InvoiceController@edit');
Route::get('/create-invoice','API\InvoiceController@create');
Route::put('/invoice-paid/{id}','API\InvoiceController@makeAsPaid');
Route::put('/invoices/address/{id}','API\InvoiceController@address');

/*
* Discount controller
*/
Route::apiResources(['/discount' => 'API\DiscountController']);
Route::get('/create-discount','API\DiscountController@create');

/*
* client controller
*/
Route::resource('/clients', 'API\ClientController')->names([
    'index' => 'clients.index',
    'create' => 'clients.create',
    'show' => 'clients.show',
    'store' => 'clients.store',
]);
Route::get('/clients-edit/{email}','API\ClientController@edit');
Route::get('/clients_get_country','API\ClientController@getAllCountry');


/*
* Service controller
*/
Route::apiResources(['/services' => 'API\ServiceController']);
Route::get('/duplicate/{id}','API\ServiceController@duplicate');
Route::patch('/services/data-field/{slug}','API\ServiceController@dataField');
Route::get('/services/data-field/{slug}','API\ServiceController@getDataField');
Route::delete('/services/data-field/{id}','API\ServiceController@dataFieldDelete');

/*
* Client Dashboard
*/

Route::get('/client-invoice','API\ClientDashboardController@invoice');
Route::get('/client-invoice/{invoice_number}','API\ClientDashboardController@showInvoiceDetils');


