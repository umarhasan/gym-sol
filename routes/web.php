<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\LeadStatusController;
use App\Http\Controllers\LeadSourcesController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\FeesCollectionsController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\InvoiceController;
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
Route::get('/', function () {
return view('auth.login');
});


Route::get('/google-calendar/connect', [GoogleCalendarController::class,'connect']);

Route::get('/signup', [RegisterController::class, 'register_form'])->name('signup');
Route::get('logout', [LoginController::class, 'logout']);
Route::get('account/verify/{token}', [LoginController::class, 'verifyAccount'])->name('user.verify'); 

// Route::get('/', [HomeController::class,'index']);
Route::get('/detail/{id}', [HomeController::class,'product_detail'])->name('product.detail');

Auth::routes(['verify' => true]);


Route::group(['middleware' => ['auth','verified']], function(){
    Route::get('/change_password', [DashboardController::class, 'change_password'])->name('change_password');
    Route::post('/store_change_password', [DashboardController::class, 'store_change_password'])->name('store_change_password');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
    Route::resource('roles', RoleController::class);
    Route::resource('shift', ShiftController::class);
    Route::resource('attendance', AttendanceController::class);
    // Satrt Leads
    Route::resource('leads', LeadsController::class);
    Route::get('leads/accepted/{id}', [LeadsController::class, 'LeadAccepted'])->name('leads.accepted');
    Route::get('leads/user/invoice', [LeadsController::class, 'LeadsUserInvoice'])->name('leads.invoice');
    Route::post('leads/mark/convert', [LeadsController::class, 'LeadsMarkConvert'])->name('leads.mark.convert');
    Route::get('pick', [LeadsController::class, 'LeadsPick'])->name('leads.pick');
    Route::get('leads/invoice/view/{id}', [LeadsController::class, 'LeadsInvoiceShow'])->name('leads.invoice.show');
    
    // End Leads
    Route::resource('leaves', LeavesController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('task', TaskController::class);
    Route::resource('client', ClientController::class);
    Route::resource('project', ProjectController::class);
    Route::resource('mail', MailController::class);
    Route::resource('leadStatus', LeadStatusController::class);
    Route::resource('leadSources', LeadSourcesController::class);
    Route::resource('member', MemberController::class);
    Route::resource('fees', FeesController::class);

    Route::get('invoice/{invoice_url}', [InvoiceController::class,'show'])->name('member.invoice');
    Route::resource('expenses', ExpensesController::class);
    Route::get('expenses-invoice/{id}', [ExpensesController::class,'ExpensesInvoice'])->name('expenses-invoice');
    Route::get('club/create', [SettingController::class,'create'])->name('club.create');
    Route::get('/club/settings', [SettingController::class, 'createOrUpdate'])->name('club.settings.createOrUpdate');
    Route::post('/club/settings', [SettingController::class, 'createOrUpdate']);
    Route::put('/club/settings/{club_id}', [SettingController::class, 'createOrUpdate'])->name('club.settings.update');
    Route::get('fees/create/{id}', [FeesController::class,'create'])->name('fees.create');
    Route::get('fees-collections', [FeesCollectionsController::class,'FeesCollections'])->name('fees-collections');
    // Reports
    Route::get('unpaid-members', [ReportsController::class,'UnpaidMembers'])->name('members.unpaid');
    Route::get('expired-members', [ReportsController::class,'ExpiredMembers'])->name('members.expired');
    Route::get('soon-expire-members', [ReportsController::class,'SoonToExpireMembers'])->name('members.expired.soon');
    Route::get('collections-history', [ReportsController::class,'CollectionHistory'])->name('collections.history');
    Route::get('attendance-history', [ReportsController::class,'AttendanceHistory'])->name('attendance.history');
    Route::get('expenses-reports', [ReportsController::class,'ExpensesReport'])->name('expenses.reports');
    Route::get('profit-loss', [ReportsController::class,'ProfitandLoss'])->name('profit_loss');
    // End Reports
    Route::get('member-profile/{id}', [MemberController::class,'MemberProfile'])->name('member.profile');   
    Route::resource('staff', StaffController::class);
  	Route::get('clients/fetch', [ClientController::class, 'assign_client'])->name('clients.fetch');
  	Route::get('projects/fetch', [ProjectController::class, 'assign_project'])->name('projects.fetch');
    
    Route::resource('users', UserController::class);
  	Route::get('user/fetch', [UserController::class, 'assign_user'])->name('user.fetch');
  	Route::get('user/permission/{id}', [UserController::class, 'user_permission'])->name('users.permission');
    Route::post('user/permission/update/{id}', [UserController::class, 'user_permission_update'])->name('user.permission.update');
    
   
    Route::resource('packages', PackagesController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('subcategory', SubCategoryController::class);
    
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile.index');
    Route::post('/profile', [DashboardController::class, 'profileupdate'])->name('user.update');
  

    Route::resource('product', ProductController::class);
    Route::get('subcatories/{category}', [SubCategoryController::class,'subcatories']);
    Route::get('product/{id}/images', [ProductController::class, 'images']);
  	Route::post('product/{id}/images', [ProductController::class, 'postImages']);
  	Route::get('product/image/{id}/delete', [ProductController::class, 'imgDelete']);
    
    Route::resource('pages',PageController::class);
    Route::resource('sections',SectionController::class);
    Route::resource('general_setting',GeneralSettingController::class);
    Route::resource('orders',OrderController::class);
});
  
  
// Add cart
Route::post('addcart', [CheckoutController::class, 'addcart'])->name('addcart');
Route::get('ajaxcart', [CheckoutController::class, 'ajaxcart'])->name('cart.ajax');
Route::get('cart', [CheckoutController::class, 'cart'])->name('cart');
Route::post('updatecart', [CheckoutController::class, 'updatecart'])->name('updatecart');
Route::get('deletecart', [CheckoutController::class, 'deletecart'])->name('deletecart');
Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('post_checkout', [CheckoutController::class, 'post_checkout'])->name('post_checkout');

// Add Wishlist
Route::post('addwishlist', [CheckoutController::class, 'addwishlist'])->name('addwishlist');