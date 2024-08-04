<?php

use App\Http\Controllers\ApiController;

//super admin route
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CityController;
use App\Http\Controllers\Frontend\BannerController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\GstController;
use App\Http\Controllers\Frontend\RestroController;
use App\Http\Controllers\Frontend\CouponController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\MenuController;
use App\Http\Controllers\Frontend\DeliveryBoyController;
use App\Http\Controllers\Frontend\CompanyCouponController;
use App\Http\Controllers\Frontend\NotificationController;

// Import middleware classes
use App\Http\Middleware\SuperadminCheckStatus;
use App\Http\Middleware\AdminCheckStatus;


// //middleware route
// use App\Http\Controller\Middleware\CheckStatus;

//admin route
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\LeaveDateController;
use App\Http\Controllers\admin\DeliverySlotTimingController;
use App\Http\Controllers\admin\RecipeController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\KitchenController;
use App\Http\Controllers\admin\tableController;
use App\Http\Controllers\admin\waiterController;
use App\Http\Controllers\admin\AreaController;
use App\Http\Controllers\admin\AllOrdersController;
use App\Http\Controllers\admin\BillController;
use App\Http\Controllers\admin\LogoController;
// use App\Http\Controllers\admin\BillForAppController;


use App\Http\Controllers\Frontend\PrivacyPolicyController;

// QR
use Intervention\Image\ImageManager;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'web'], function () {

//login routes
Route::get('/', [AdminLoginController::class, 'index'])->name('adminLogin');
Route::post('/postlogin', [AdminLoginController::class, 'login'])->name('postlogin');
// Route::get('/logout', [AdminLoginController::class, 'logout'])->name('logout');
Route::match(['get', 'post'], '/logout', [AdminLoginController::class, 'logout'])->name('logout');
// Route::get('/getOrdersByType', [AdminLoginController::class, 'getOrdersByType'])->name('orders.byType');


// Route::middleware([CheckStatus::class])->group(function(){
    //----------------------------------
// Route::group(['middleware'=>'CheckStatus'],function(){
    //----------------------------------

Route::group(['middleware' => SuperadminCheckStatus::class], function () {
        // Define superadmin routes here
        // Example:
Route::get('/superadmin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/order-data', [DashboardController::class, 'getOrderData']);
// Route::get('/getOrdersByType', [DashboardController::class, 'getOrdersByType'])->name('orders.byType');
Route::get('/orders/by-type', [DashboardController::class, 'getOrdersByType'])->name('orders.byType');

Route::get('/city',[CityController::class, 'index'])->name('city');
Route::post('cityStore',[CityController::class, 'cityStore'])->name('cityStore');
Route::get('cityDestroy/{id}',[CityController::class, 'cityDestroy'])->name('cityDestroy');
Route::get('cityEdit/{id}', [CityController::class, 'cityEdit'])->name('cityEdit');
Route::post('cityUpdate', [CityController::class, 'cityUpdate'])->name('cityUpdate');
Route::get('/update_city_status/{id}', [CityController::class, 'update_city_status'])->name('update_city_status');


Route::get('bannerIndex',[BannerController::class, 'index'])->name('bannerIndex');
Route::post('bannerStore',[BannerController::class, 'bannerStore'])->name('bannerStore');
Route::get('bannerDestroy/{id}', [BannerController::class, 'bannerDestroy'])->name('bannerDestroy');
Route::get('bannerEdit/{id}', [BannerController::class, 'bannerEdit'])->name('bannerEdit');
Route::post('bannerUpdate', [BannerController::class, 'bannerUpdate'])->name('bannerUpdate');
Route::get('/update_banner_status/{id}', [BannerController::class, 'update_banner_status'])->name('update_banner_status');


Route::get('categoryIndex',[CategoryController::class, 'index'])->name('categoryIndex');
Route::post('categoryStore',[CategoryController::class, 'categoryStore'])->name('categoryStore');
Route::get('categoryDestroy/{id}',[CategoryController::class, 'categoryDestroy'])->name('categoryDestroy');
// Route::get('categoryEdit/{id}', [CategoryController::class, 'categoryEdit'])->name('categoryEdit');
Route::match(['get', 'post'], 'categoryEdit/{id}', [CategoryController::class, 'categoryEdit'])->name('categoryEdit');
Route::post('categoryUpdate', [CategoryController::class, 'categoryUpdate'])->name('categoryUpdate');
Route::get('/update_category_status/{id}', [CategoryController::class, 'update_category_status'])->name('update_category_status');


Route::get('gstIndex', [GstController::class, 'index'])->name('gstIndex');
Route::post('gstStore', [GstController::class, 'gstStore'])->name('gstStore');

Route::get('restroIndex', [RestroController::class, 'index'])->name('restroIndex');
Route::post('restroStore', [RestroController::class, 'restroStore'])->name('restroStore');
Route::get('restroDestroy/{id}', [RestroController::class, 'restroDestroy'])->name('restroDestroy');
Route::get('restroEdit/{id}', [RestroController::class, 'restroEdit'])->name('restroEdit');
Route::post('restroUpdate', [RestroController::class, 'restroUpdate'])->name('restroUpdate');
Route::get('/login', [RestroController::class, 'login'])->name('login');
Route::get('/view', [RestroController::class, 'view'])->name('view');
//for status active or inactive
Route::get('/update_status/{id}', [RestroController::class, 'update_status'])->name('update_status');
// Route::get('/getCoordinates/{cityId}', [RestroController::class, 'getCoordinates'])->name('getCoordinates');

Route::get('couponIndex', [CouponController::class, 'index'])->name('couponIndex');
Route::post('couponStore', [CouponController::class, 'couponStore'])->name('couponStore');
Route::get('coupon/create', [CouponController::class, 'create'])->name('createCoupon');
Route::get('couponDestroy/{id}', [CouponController::class, 'couponDestroy'])->name('couponDestroy');
Route::get('couponEdit/{id}', [CouponController::class, 'couponEdit'])->name('couponEdit');
Route::post('couponUpdate', [CouponController::class, 'couponUpdate'])->name('couponUpdate');
//for status active or inactive
Route::get('/update_coupon_status/{id}', [CouponController::class, 'update_coupon_status'])->name('update_coupon_status');
Route::get('/get-restaurants-by-city', [CouponController::class, 'getRestaurantsByCity'])->name('getRestaurantsByCity');
Route::get('/getAllRestaurants', [CouponController::class, 'getAllRestaurants'])->name('getAllRestaurants');

// Company Coupon
Route::get('companyCouponIndex', [CompanyCouponController::class, 'index'])->name('companyCouponIndex');
Route::post('companyCouponStore', [CompanyCouponController::class, 'companyCouponStore'])->name('companyCouponStore');
Route::get('coupon/create', [CompanyCouponController::class, 'create'])->name('createCoupon');
Route::get('companyCouponDestroy/{id}', [CompanyCouponController::class, 'companyCouponDestroy'])->name('companyCouponDestroy');
Route::get('companyCouponEdit/{id}', [CompanyCouponController::class, 'companyCouponEdit'])->name('companyCouponEdit');
Route::post('companyCouponUpdate', [CompanyCouponController::class, 'companyCouponUpdate'])->name('companyCouponUpdate');
//for status active or inactive
Route::get('/update_company_coupon_status/{id}', [CompanyCouponController::class, 'update_company_coupon_status'])->name('update_company_coupon_status');


Route::get('menu', [MenuController::class, 'index'])->name('menuIndex');
Route::post('menuStore', [MenuController::class, 'menuStore'])->name('menuStore');
Route::get('menuDestroy/{id}', [MenuController::class, 'menuDestroy'])->name('menuDestroy');
Route::get('menuEdit/{id}', [MenuController::class, 'menuEdit'])->name('menuEdit');
Route::post('menuUpdate', [MenuController::class, 'menuUpdate'])->name('menuUpdate');
//for status active or inactive
Route::get('/update_menu_status/{id}', [MenuController::class, 'update_menu_status'])->name('update_menu_status');
Route::get('/get-restaurants-by-city', [MenuController::class, 'getRestaurantsByCity'])->name('getRestaurantsByCity');
Route::get('/get-categories-by-restaurant', [MenuController::class, 'getCategoriesByRestaurant'])->name('getCategoriesByRestaurant');

// routes/web.php

// Route::get('/getRestaurants/{cityId}', [MenuController::class,'getRestaurants'])->name('getRestaurants');


// Notification
Route::get('notification-index', [NotificationController::class, 'index'])->name('notification-index');
Route::post('notification-store', [NotificationController::class, 'store'])->name('notification-store');
Route::get('notice-edit/{id}', [NotificationController::class, 'Edit'])->name('notice-edit');
Route::post('notification-update',[NotificationController::class, 'update'])->name('notification-update');
Route::get('notice-destroy/{id}', [NotificationController::class, 'destroy'])->name('notice-destroy');
Route::get('notice-destroy/{id}', [NotificationController::class, 'destroy'])->name('notice-destroy');


//DELIVERY BOY
Route::get('/delivery_boy', [DeliveryBoyController::class, 'index'])->name('delivery_boy');
Route::post('store-delivery-boy',[DeliveryBoyController::class, 'store_delivery_boy'])->name('store-delivery-boy');
Route::get('/delivery-boy-edit/{id}', [DeliveryBoyController::class, 'edit_delivery_boy'])->name('edit_delivery_boy');
Route::post('update-delivery-boy',[DeliveryBoyController::class, 'update_delivery_boy'])->name('update_delivery_boy');
Route::get('/project-delete-layout-image/{id}', [DeliveryBoyController::class, 'deleteImage'])->name('project.delete-layout-image');
Route::get('/update_delivery_boy_status/{id}', [DeliveryBoyController::class, 'update_delivery_boy_status'])->name('update_delivery_boy_status');
});

// Admin routes
// Route::get('/', [AdminLoginController::class, 'index'])->name('adminLogin');
// Route::post('/login', [AdminLoginController::class, 'login'])->name('postlogin');

Route::group(['middleware' => AdminCheckStatus::class], function () {
    // Define admin routes here
    // Example:
    // Route::get('/admin/dashboard', 'AdminController@dashboard');

Route::get('dashboard-user', [AdminDashboardController::class, 'index'])->name('adminDashboard');
// Route::get('dashboard-waiter', [AdminDashboardController::class, 'index_waiter'])->name('dashboard-waiter');
// Route::get('dashboard-food', [AdminDashboardController::class, 'index_food'])->name('dashboard-food');
Route::get('/getOrdersByTypeAdmin', [AdminDashboardController::class, 'getOrdersByTypeAdmin'])->name('orders.byTypeAdmin');
Route::get('/getOrdersByTypeStatus', [AdminDashboardController::class, 'getOrdersByStatus'])->name('orders.byStatus');

Route::get('showProfile/{id}', [ProfileController::class, 'showProfile'])->name('showProfile');
Route::post('updateProfile/{id}', [ProfileController::class, 'updateProfile'])->name('profile.update');

Route::get('add_recipe', [RecipeController::class, 'index'])->name('add_recipe');
Route::post('recipeStore', [RecipeController::class, 'recipeStore'])->name('recipeStore');
Route::get('recipeDestroy/{id}', [RecipeController::class, 'recipeDestroy'])->name('recipeDestroy');
Route::get('recipeEdit/{id}', [RecipeController::class, 'recipeEdit'])->name('recipeEdit');
Route::post('recipeUpdate', [RecipeController::class, 'recipeUpdate'])->name('recipeUpdate');
Route::get('/update_recipe_status/{id}', [RecipeController::class, 'update_recipe_status'])->name('update_recipe_status');

Route::get('leave_date', [LeaveDateController::class, 'index'])->name('leave_date');
Route::post('leave_date/store', [LeaveDateController::class, 'dateStore'])->name('dateStore');
Route::get('leaveDateDestroy/{id}', [LeaveDateController::class, 'leaveDateDestroy'])->name('leaveDateDestroy');
Route::get('leaveDateEdit/{id}', [LeaveDateController::class, 'leaveDateEdit'])->name('leaveDateEdit');
Route::post('leaveDateUpdate', [LeaveDateController::class, 'leaveDateUpdate'])->name('leaveDateUpdate');

Route::get('delivery_slots_timing', [DeliverySlotTimingController::class, 'index'])->name('delivery_slots_timing');
Route::post('delivery_slots_timing/store', [DeliverySlotTimingController::class, 'deliverySlotStore'])->name('deliverySlotStore');
Route::get('deliverySlotDestroy/{id}', [DeliverySlotTimingController::class, 'deliverySlotDestroy'])->name('deliverySlotDestroy');
Route::get('deliverySlotEdit/{id}', [DeliverySlotTimingController::class, 'deliverySlotEdit'])->name('deliverySlotEdit');
Route::post('deliverySlotUpdate', [DeliverySlotTimingController::class, 'deliverySlotUpdate'])->name('deliverySlotUpdate');

Route::get('kitchen', [KitchenController::class, 'index'])->name('kitchen');
Route::post('kitchen-registration', [KitchenController::class, 'kitchen_registration'])->name('kitchen-registration');
Route::get('kitchen-edit/{id}', [KitchenController::class, 'kitchen_edit'])->name('kitchen-edit');
Route::post('kitchen-update', [KitchenController::class, 'kitchen_update'])->name('kitchen-update');
Route::get('/update-kitchen-status/{id}', [KitchenController::class, 'update_kitchen_status'])->name('update-kitchen-status');

Route::get('area', [AreaController::class, 'index'])->name('area');
Route::post('area-store', [AreaController::class, 'areaStore'])->name('area-store');
Route::get('/update-area-status/{id}', [AreaController::class, 'update_area_status'])->name('update-area-status');

Route::get('table', [tableController::class, 'index'])->name('table');
Route::post('table-store', [tableController::class, 'tableStore'])->name('tableStore');
Route::get('/update-table-status/{id}', [tableController::class, 'update_table_status'])->name('update-table-status');

Route::get('waiter_view', [WaiterController::class, 'index'])->name('waiter_view');
Route::post('waiter-registration', [WaiterController::class, 'waiter_registration'])->name('waiter-registration');
Route::get('waiter-edit/{id}', [WaiterController::class, 'waiter_edit'])->name('waiter-edit');
Route::post('waiter-update', [WaiterController::class, 'waiter_update'])->name('waiter-update');
Route::get('/update-waiter-status/{id}', [WaiterController::class, 'update_waiter_status'])->name('update-waiter-status');
Route::get('/delete-waiter-image/{id}', [WaiterController::class, 'deleteImage'])->name('delete-waiter-image');

// Route::get('gst', [GSTController::class, 'index'])->name('gstIndex');
// Route::post('gstStore', [GSTController::class, 'gstStore'])->name('gst');

Route::get('add-logo', [LogoController::class, 'index'])->name('add-logo');
Route::post('update-logo', [LogoController::class, 'updateLogo'])->name('update-logo');


Route::get('generate-bill', [AllOrdersController::class, 'index'])->name('all-orders');
Route::get('/bill/{order}', [AllOrdersController::class, 'generateBill'])->name('bill');
Route::get('counter-bill', [BillController::class, 'counterBill'])->name('counter-bill');
Route::post('counter-bill-store', [BillController::class, 'counterBillStore'])->name('counter-bill-store');
Route::get('show-counter-bill/{bill}', [BillController::class, 'showCounterBill'])->name('show-counter-bill');
Route::get('/get-recipes/{categoryId}', [BillController::class, 'getRecipesByCategory'])->name('get-recipes');
Route::get('/get-recipes', [BillController::class, 'getAllRecipes'])->name('get-all-recipes');


// Route::get('bill', [BillController::class, 'index'])->name('bill');
// Route::get('/order-details/{orderId}', [BillController::class, 'getOrderDetails'])->name('admin.generateBill');


});
// Route::get('downloadQrCode/{restroId}/{tableNo}', [ApiController::class, 'qr_code'])->name('downloadQrCode');
Route::get('/download-qr/{restaurant_id}/{table_number}', [ApiController::class, 'downloadQrCode'])->name('downloadQrCode');


});

// route to show privacy policy
Route::get('privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy');


Route::get('/test-gd', function () {
    $manager = new ImageManager(['driver' => 'gd']);
    $image = $manager->make(storage_path('app/public/qrcode.png'))->resize(300, 300);
    $image->save(storage_path('app/public/test_image.png'));

    return 'GD Library is being used';
});

// Route::get('bill-for-app', [BillForAppController::class, 'billForApp'])->name('bill-for-app');
