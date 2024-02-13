<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;









/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();

Route::resource('invoices', 'App\Http\Controllers\InvoicesController'); 

Route::resource('sections', 'App\Http\Controllers\SectionsController'); 

Route::resource('products', 'App\Http\Controllers\ProductsController');

//get products of section via ajax
Route::get('section/{id}', [InvoicesController::class, 'getproducts']);

Route::get('InvoicesDetails/{id}', [InvoicesDetailsController::class, 'edit']);

//3 buttons in details_invoice (attachments)
Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'get_file']);

Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file']);

Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');


Route::resource('InvoiceAttachments', 'App\Http\Controllers\InvoiceAttachmentsController');


Route::get('/edit_invoice/{id}',  [InvoicesController::class, 'edit']);


Route::get('/Status_show/{id}', [InvoicesController::class, 'show'])->name('Status_show');

Route::post('/Status_Update/{id}', [InvoicesController::class, 'Status_Update'])->name('Status_Update');

Route::get('Invoice_Paid',[InvoicesController::class, 'Invoice_Paid']);

Route::get('Invoice_UnPaid',[InvoicesController::class, 'Invoice_UnPaid']);

Route::get('Invoice_Partial',[InvoicesController::class, 'Invoice_Partial']);

Route::resource('Archive', 'App\Http\Controllers\InvoiceAchiveController');

Route::get('Print_invoice/{id}',[InvoicesController::class, 'Print_invoice']);

Route::get('export_invoices', [InvoicesController::class, 'export']);

//permission
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','App\Http\Controllers\RoleController');
    Route::resource('users','App\Http\Controllers\UserController');
    });


Route::get('invoices_report', 'App\Http\Controllers\Invoices_Report@index');
Route::post('Search_invoices', 'App\Http\Controllers\Invoices_Report@Search_invoices');

Route::get('customers_report', 'App\Http\Controllers\Customers_Report@index');
Route::post('Search_customers', 'App\Http\Controllers\Customers_Report@Search_customers');

//read all notification
Route::get('MarkAsRead_all','App\Http\Controllers\InvoicesController@MarkAsRead_all');

//show profile
Route::get('/show_profile/{id}', 'App\Http\Controllers\UserController@show_profile')->name('show_profile');

//search input (header)
Route::get('/searchPage','App\Http\Controllers\InvoicesController@searchPage')->name('searchPage');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/{page}', 'App\Http\Controllers\AdminController@index');

