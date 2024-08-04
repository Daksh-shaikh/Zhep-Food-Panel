<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\BillForAppController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// New Registration login and forget password flow

Route::post('registration', [ApiController::class, 'registration']);
Route::post('login', [ApiController::class, 'login']);
Route::post('forget_verify_otp', [ApiController::class, 'forget_verify_otp']);
Route::post('forget_change_password', [ApiController::class, 'forget_change_password']);






Route::post('user_registration', [ApiController::class, 'user_registration']);

Route::get('get_user', [ApiController::class, 'get_user']);

Route::post('send_mobile_verify_otp', [ApiController::class, 'send_mobile_verify_otp']);

Route::post('add_password', [ApiController::class, 'add_password']);

Route::post('send_mobile_verify_otp_old', [ApiController::class, 'send_mobile_verify_otp_old']);

Route::post('updateUser', [ApiController::class, 'updateUser']);

Route::get('getCity', [ApiController::class, 'getCity']);

Route::get('update_city', [ApiController::class, 'update_city']);

Route::get('getCategory', [ApiController::class, 'getCategory']);

Route::get('getBanner', [ApiController::class, 'getBanner']);

Route::get('get_restro', [ApiController::class, 'get_restro']);

Route::get('get_restro_data', [ApiController::class, 'get_restro_data']);

Route::get('get_restro_new', [ApiController::class, 'get_restro_new']);

Route::get('get_restro_against_category', [ApiController::class, 'get_restro_against_category']);

Route::get('get_coupon', [ApiController::class, 'get_coupon']);

Route::get('get_company_coupon', [ApiController::class, 'get_company_coupon']);



//admin panel

Route::get('get_recipe', [ApiController::class, 'get_recipe']);

Route::get('getCart', [ApiController::class, 'getCart']);

Route::post('addToCart', [ApiController::class, 'addToCart']);

Route::post('updateAddToCart', [ApiController::class, 'updateAddToCart']);

Route::post('post_card', [ApiController::class, 'post_card']);

Route::get('remove_cart', [ApiController::class, 'remove_cart']);

Route::post('postOrder', [ApiController::class, 'postOrder']);

Route::get('get_order_history', [ApiController::class, 'get_order_history']);

Route::get('get_search_restro', [ApiController::class, 'get_search_restro']);

Route::get('getMenu', [ApiController::class, 'getMenu']);

Route::get('get_search_menu', [ApiController::class, 'get_search_menu']);

//Restro API

Route::post('restro_login', [ApiController::class, 'restro_login']);

Route::get('getRestroOrder', [ApiController::class, 'getRestroOrder']);

Route::get('restro_order_again', [ApiController::class, 'restro_order_again']);

Route::get('getRestroInfo', [ApiController::class, 'getRestroInfo']);

Route::post('accept_order', [ApiController::class, 'accept_order']);

Route::post('cancel_order', [ApiController::class, 'cancel_order']);

Route::post('delivery_address', [ApiController::class, 'delivery_address']);

Route::get('get_delivery_address', [ApiController::class, 'get_delivery_address']);

Route::get('get_delivery_address_by_id', [ApiController::class, 'get_delivery_address_by_id']);

Route::get('delete_delivery_address', [ApiController::class, 'delete_delivery_address']);

Route::post('update_delivery_address', [ApiController::class, 'update_delivery_address']);


//Delivery Boy API


Route::post('delivery_registration', [ApiController::class, 'delivery_registration']);

Route::post('delivery_check', [ApiController::class, 'delivery_check']);

Route::get('get_delivery_boy_info', [ApiController::class, 'get_delivery_boy_info']);

Route::post('updateDeliveryBoy/{id}', [ApiController::class, 'updateDeliveryBoy']);

Route::post('update_delivery_location', [ApiController::class, 'update_delivery_location']);

Route::get('get_delivery_location', [ApiController::class, 'get_delivery_location']);

Route::get('get_delivery_order', [ApiController::class, 'get_delivery_order']);

Route::post('delivery_accept_order', [ApiController::class, 'delivery_accept_order']);

Route::post('delivery_cancel_order', [ApiController::class, 'delivery_cancel_order']);

Route::post('pickup_delivery_order', [ApiController::class, 'pickup_delivery_order']);

Route::post('delivered_delivery_order', [ApiController::class, 'delivered_delivery_order']);

Route::post('send_delivery_otp', [ApiController::class, 'send_delivery_otp']);

Route::post('verify_delivery_otp', [ApiController::class, 'verify_delivery_otp']);

Route::post('updateDeliveryAddress/{id}', [ApiController::class, 'updateDeliveryAddress']);


// Kitchen API

Route::post('kitchen_registration', [ApiController::class, 'kitchen_registration']);

Route::post('kitchen_check', [ApiController::class, 'kitchen_check']);

Route::get('get_kitchen_info', [ApiController::class, 'get_kitchen_info']);

Route::post('updateKitchen/{id}', [ApiController::class, 'updateKitchen']);

Route::get('get_all_restro_kitchen', [ApiController::class, 'get_all_restro_kitchen']);

Route::get('get_kitchen_order', [ApiController::class, 'get_kitchen_order']);

Route::post('kitchen_accept_order', [ApiController::class, 'kitchen_accept_order']);

Route::post('kitchen_cancel_order', [ApiController::class, 'kitchen_cancel_order']);

Route::post('kitchen_order_completed', [ApiController::class, 'kitchen_order_completed']);


// API KEY
Route::get('api_key', [ApiController::class, 'api_key']);


// Waiter
Route::post('waiter_registration', [ApiController::class, 'waiter_registration']);
Route::post('waiter_check', [ApiController::class, 'waiter_check']);

Route::get('waiter_info', [ApiController::class, 'waiter_info']);

Route::get('dine_in_menu', [ApiController::class, 'dine_in_menu']);

Route::get('get_varients', [ApiController::class, 'get_varients']);

Route::post('dine_in_post_order', [ApiController::class, 'dine_in_post_order']);

Route::get('get_dine_in_order', [ApiController::class, 'get_dine_in_order']);

Route::get('get_dine_in_waiter_order', [ApiController::class, 'get_dine_in_waiter_order']);

//recipes added by user to his cart
Route::post('dine_in_add_to_cart', [ApiController::class, 'dine_in_add_to_cart']);

Route::get('get_dine_in_cart', [ApiController::class, 'get_dine_in_cart']);

Route::get('dine_in_remove_cart', [ApiController::class, 'dine_in_remove_cart']);

//new recipes added by waiter in user cart
Route::post('dine_in_add_to_cart_through_waiter', [ApiController::class, 'dine_in_add_to_cart_through_waiter']);

Route::get('get_dine_in_cart_waiter', [ApiController::class, 'get_dine_in_cart_waiter']);

Route::post('dine_in_waiter_update_order', [ApiController::class, 'dine_in_waiter_update_order']);

Route::post('dine_in_user_update_order', [ApiController::class, 'dine_in_user_update_order']);

Route::get('dine_in_remove_waiter_order_item', [ApiController::class, 'dine_in_remove_waiter_order_item']);

Route::post('Register_new_user_by_waiter', [ApiController::class, 'Register_new_user_by_waiter']);

Route::get('check_user', [ApiController::class, 'check_user']);

Route::post('waiter_accept_order', [ApiController::class, 'waiter_accept_order']);

Route::post('waiter_cancel_order', [ApiController::class, 'waiter_cancel_order']);

Route::post('dine_in_waiter_order_completed', [ApiController::class, 'dine_in_waiter_order_completed']);

// Dine In Kitchen API
Route::get('get_dine_in_kitchen_order', [ApiController::class, 'get_dine_in_kitchen_order']);

Route::post('dine_in_kitchen_accept_order', [ApiController::class, 'dine_in_kitchen_accept_order']);

Route::post('dine_in_kitchen_cancel_order', [ApiController::class, 'dine_in_kitchen_cancel_order']);

Route::post('dine_in_waiter_order_serve', [ApiController::class, 'dine_in_waiter_order_serve']);

Route::post('dine_in_kitchen_order_completed', [ApiController::class, 'dine_in_kitchen_order_completed']);


//Generate bill
Route::get('generate_bill', [ApiController::class, 'generate_bill']);




Route::post('dine_in_update_post_order', [ApiController::class, 'dine_in_update_post_order']);


// Coupon
Route::post('apply_coupon', [ApiController::class, 'apply_coupon']);

// GST
Route::get('get_gst', [ApiController::class, 'get_gst']);

//Notification
Route::get('get_notification', [ApiController::class, 'get_notification']);

//payment gateway...
Route::post('capturePayment', [ApiController::class, 'capturePayment']);


Route::post('forget_verify_otp_register', [ApiController::class, 'forget_verify_otp_register']);

Route::get('bill-for-app', [BillForAppController::class, 'billForApp'])->name('bill-for-app');
