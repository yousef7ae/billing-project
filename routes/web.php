<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailController;
use App\Http\Controllers\InvoicesAttachmentController;
use App\Http\Controllers\archiveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;


use App\Http\Controllers\Auth\LoginController;
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

Auth::routes();

//Auth::routes(['register' => flase]);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[HomeController::class,'index'])->middleware(['auth','Status'])
->name('dashboard');

//  Route::get('/dashboard', function () {
//      return view('dashboard');
//  })->middleware(['auth','EnsureStatus'])->name('dashboard');



Route::get('sections',[SectionController::class,'index']);

Route::post('section/store',[SectionController::class,'store']);

Route::patch('section/update',[SectionController::class,'update']);

Route::delete('section/delete',[SectionController::class,'destroy']);

//Route::get('sections/{secId}',[InvoicesController::class,'getProduct']);




Route::get('products',[ProductController::class,'index']);

Route::post('products/store',[ProductController::class,'store']);

Route::post('products/update',[ProductController::class,'update']);

Route::post('products/delete',[ProductController::class,'destroy']);


//جلب المنتجات التابعة لقسم معين عن طريق ايدي القسم
Route::get('sections/{secId}',[InvoicesController::class,'getProduct']);




Route::get('invoices',[InvoicesController::class,'index']);

Route::get('invoices/create',[InvoicesController::class,'create']);

Route::post('invoices/store',[InvoicesController::class,'store'])->name('invoices.store');

Route::get('invoices/edit/{id}',[InvoicesController::class,'edit']);

Route::post('invoices/update',[InvoicesController::class,'update'])->name('invoice.update');

Route::post('invoice/delete',[InvoicesController::class,'destroy']);



//تفاصيل الفاتورة
Route::get('InvoicesDetails/{id}',[InvoicesDetailController::class,'edit']);

//تفاصيل الفاتورة المؤرشفة
Route::get('InvoicesArchiveDetails/{id}',[InvoicesDetailController::class,'showArchive']);


// فتح المرفق
Route::get('View_file/{invoice_number}/{file_name}',[InvoicesDetailController::class,'open_file']);

// تحميل المرفق
Route::get('download/{invoice_number}/{file_name}',[InvoicesDetailController::class,'download_file']);

// حذف المرفق
Route::post('delete/file',[InvoicesDetailController::class,'destroy']);

//اضافة مرفق
Route::post('InvoiceAttachments',[InvoicesAttachmentController::class,'store']);

//عرض حالة الفاتورة
Route::get('show_status/{id}',[InvoicesController::class,'showStatus'])->name('show_status');

// تحديث حالة الفاتورة
Route::post('status_update/{id}',[InvoicesController::class,'updateStatus'])->name('status_update');

// الفواتير المدفوعة
Route::get('paid_Invoices',[InvoicesController::class,'get_paid'])->middleware(['Status']);

// الفواتير المدفوعة جزئيا
Route::get('partially_Paid_Invoices',[InvoicesController::class,'get_partially_Paid']);

// الفواتير الغير مدفوعة
Route::get('unpaid_Invoices',[InvoicesController::class,'get_unpaid']);

//الفواتير المؤرشفة
Route::get('archive_Invoices',[archiveController::class,'index']);

Route::post('delete_Archive',[archiveController::class,'destroy'])->name('delete_Archive');

Route::post('restore_Archive',[archiveController::class,'update'])->name('restore_Archive');

Route::get('print_Invoice/{id}',[InvoicesController::class,'Print_invoice'])->name('print_Invoice');

//تصدير ملف اكسل للفواتير

Route::get('invoicesExport', [InvoicesController::class, 'export']);

//الصلاحيات

Route::group(['middleware' => ['auth']], function() {
    
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
 
   
});

//التقارير

//تقارير الفواتير
Route::get('report_invoices', [ReportController::class, 'index1']);

//جلب تقارير الفواتير 
Route::post('Search_invoices', [ReportController::class, 'Search_invoices']);

//Route::get('invoicesExport/{type}/{start_at}/{end_at}', [ReportController::class, 'export']);


// تقارير العملاء
Route::get('report_customer',[ReportController::class, 'index2']);


// جلب تقارير العملاء
Route::post('Search_customers', [ReportController::class, 'Search_customer']);


//قراءة كل الاشعارات 

Route::get('markAsRead' , [InvoicesController::class, 'markAsRead'])->name('markAsRead');

//تفاصيل الفاتورة مع قراء اشعار واحد فقط
Route::get('InvoicesDetails_WithRead/{id}',[InvoicesDetailController::class,'edit2']);

require __DIR__.'/auth.php';



