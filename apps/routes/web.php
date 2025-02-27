<?php

use App\Mail\SendOtp;
use App\Http\Controllers\ScanCtrl;
use App\Http\Controllers\Sesiauth;
use App\Http\Controllers\AuditCtrl;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\PrintCtrl;
use App\Http\Controllers\RolesCtrl;
use App\Http\Controllers\UsersCtrl;
use App\Http\Controllers\AssetsCtrl;
use App\Http\Controllers\VendorCtrl;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AccountCtrl;
use App\Http\Controllers\CheckinCtrl;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutCtrl;
use App\Http\Controllers\LocationCtrl;
use App\Http\Controllers\CategoriesCtrl;
use App\Http\Controllers\DepartementCtrl;
use App\Http\Controllers\MaintenenceCtrl;

// ** Authentication Routes **
// ** Routes Guest **
Route::middleware('guest')->group(function () {
    Route::redirect('/','login');
    Route::get('login', [Sesiauth::class, 'showLoginForm'])->name('login');
    Route::post('login', [Sesiauth::class, 'login'])->name('login.action');
    Route::get('confirmEmail', [Sesiauth::class,'showConfirmEmail'])->name('show.confirm.email');
    Route::post('confirmEmail', [Sesiauth::class, 'actionConfirmEmail'])->name('confirm.email.action');
    Route::get('forgotPassword', [Sesiauth::class,'showForgotPassword'])->name('show.forgot.password');
    Route::post('forgotPassword', [Sesiauth::class, 'actionForgotPassword'])->name('forgot.password.action');
    Route::get('otp', [Sesiauth::class, 'showOtpForm'])->name('otp.form');
    Route::post('otp', [Sesiauth::class, 'validateOtp'])->name('otp');
});
    

// **  Route User Registerd **
Route::middleware('auth')->group(function () {
   
    Route::get('dashboard', [Dashboard::class, 'showDashboard'])->name('dashboard');
    Route::get('asset', [AssetsCtrl::class, 'showAsset'])->name('asset');
    
    Route::get('master/{slug}', [AssetsCtrl::class, 'showMasterAsset'])->name('masterAsset');
    Route::post('master/update', [AssetsCtrl::class, 'actionEditMasterAsset'])->name('masterAsset.edit.action');

    Route::get('prints/{slug}', [PrintCtrl::class, 'showPrint'])->name('print');
    Route::get('print/{codeAsset}', [PrintCtrl::class, 'showPrint1'])->name('printbycode');

    
    Route::get('item/{codeAsset?}', [AssetsCtrl::class, 'showItemAsset'])->name('itemAsset');
    Route::post('item/update', [AssetsCtrl::class, 'actionEditItemAsset'])->name('itemAsset.edit.action');

    Route::get('maintenence/refreshschedule',[MaintenenceCtrl::class, 'refreshSchedule'])->name('refreshSchedule');

    Route::get('maintenence', [MaintenenceCtrl::class, 'showMaintenence'])->name('showMainten');
    Route::get('maintenence/{codeMainten}', [MaintenenceCtrl::class, 'showDetailMaintenence'])->name('showDetailMainten');
    
    Route::get('maintenence/resolve/{codeMainten}', [MaintenenceCtrl::class, 'showResolveMainten'])->name('mainten.resolve');
    Route::post('maintenence/resolve', [MaintenenceCtrl::class, 'actionResolveMainten'])->name('mainten.resolve.action');

    Route::get('report/mainten/{codeAsset}', [MaintenenceCtrl::class, 'showReportMaintenence'])->name('mainten.report');
    Route::post('report/mainten/', [MaintenenceCtrl::class, 'actionReportMainten'])->name('mainten.report.action');

    Route::get('scan/asset', [ScanCtrl::class, 'showScanAsset'])->name('scanAsset');
    Route::get('scan/reportmaintence', [ScanCtrl::class, 'showScanReportMainten'])->name('scanReportMaintence');
    
    Route::get('checkin', [CheckinCtrl::class, 'showCheckin'])->name('showCheckIn');
    Route::post('checkin/add', [CheckinCtrl::class, 'actionAddCheckinCart'])->name('checkin.add.action');
    Route::post('checkin/remove/{id}', [CheckinCtrl::class, 'actionRmfCheckinCart'])->name('checkin.remove.action');
    Route::post('checkin/save', [CheckinCtrl::class, 'actionSaveCheckinCart'])->name('checkin.save.action');
    Route::post('checkin/importexcel', [CheckinCtrl::class, 'importCheckinExcel'])->name('checkin.import.action');
    

    Route::get('checkout', [CheckoutCtrl::class, 'showCheckOut'])->name('showCheckOut');
    Route::post('checkout/add', [CheckoutCtrl::class, 'actionAddcheckoutCart'])->name('checkout.add.action');
    Route::post('checkout/remove/{id}', [CheckoutCtrl::class, 'actionRmfcheckoutCart'])->name('checkout.remove.action');
    Route::post('checkout/save', [CheckoutCtrl::class, 'actionSavecheckoutCart'])->name('checkout.save.action');


    Route::get('location', [LocationCtrl::class, 'showLocation'])->name('location');
    Route::post('location/add', [LocationCtrl::class, 'actionAddLocation'])->name('location.add.action');
    Route::post('location/update', [LocationCtrl::class, 'actionUpdateLocation'])->name('location.edit.action');
    Route::post('location/importexcel', [LocationCtrl::class, 'importLocationExcel'])->name('location.import.action');
    Route::delete('location/delete/{id?}', [LocationCtrl::class, 'actionDeleteLocation'])->name('location.delete.action');

    Route::get('category', [CategoriesCtrl::class, 'showCategory'])->name('category');
    Route::post('category/add', [CategoriesCtrl::class, 'actionAddCategory'])->name('category.add.action');
    Route::post('category/update', [CategoriesCtrl::class, 'actionUpdateCategory'])->name('category.edit.action');
    Route::post('category/importexcel', [CategoriesCtrl::class, 'importCategoryExcel'])->name('category.import.action');
    Route::delete('category/delete/{id}', [CategoriesCtrl::class, 'actionDeleteCategory'])->name('category.delete.action');

    Route::get('department', [DepartementCtrl::class, 'showDepartment'])->name('department');
    Route::post('department/add', [DepartementCtrl::class, 'actionAddDepartment'])->name('department.add.action');
    Route::post('department/update', [DepartementCtrl::class, 'actionUpdateDepartment'])->name('department.edit.action');
    Route::post('department/importexcel', [DepartementCtrl::class, 'importDeparmentExcel'])->name('department.import.action');
    Route::delete('department/delete/{id}', [DepartementCtrl::class, 'actionDeleteDepartment'])->name('department.delete.action');

    Route::get('role', [RolesCtrl::class, 'showRoles'])->name('role');
    Route::post('role/add', [RolesCtrl::class, 'actionAddRole'])->name('role.add.action');
    Route::post('role/update', [RolesCtrl::class, 'actionUpdateRole'])->name('role.edit.action');
    Route::delete('role/delete/{id}', [RolesCtrl::class, 'actionDeleteRole'])->name('role.delete.action');

    Route::get('vendor', [VendorCtrl::class, 'showVendor'])->name('vendor');
    Route::post('vendor/add', [VendorCtrl::class, 'actionAddVendor'])->name('vendor.add.action');
    Route::post('vendor/update', [VendorCtrl::class, 'actionUpdateVendor'])->name('vendor.edit.action');
    Route::post('vendor/importexcel', [VendorCtrl::class, 'importVendorExcel'])->name('vendor.import.action');
    Route::delete('vendor/delete/{id}', [VendorCtrl::class, 'actionDeleteVendor'])->name('vendor.delete.action');

    Route::get('account', [AccountCtrl::class, 'showAccount'])->name('account');
    Route::post('account/add', [AccountCtrl::class, 'actionAddAccount'])->name('account.add.action');
    Route::post('account/update', [AccountCtrl::class, 'actionUpdateAccount'])->name('account.edit.action');
    Route::post('account/reset', [AccountCtrl::class, 'actionResetAccount'])->name('account.reset.action');
    Route::post('account/disable', [AccountCtrl::class, 'actionDisableAccount'])->name('account.disable.action');
    Route::post('account/enable', [AccountCtrl::class, 'actionEnableAccount'])->name('account.enable.action');
    Route::post('account/importexcel', [AccountCtrl::class, 'importAccountExcel'])->name('account.import.action');
    Route::post('account/delete', [AccountCtrl::class, 'actionDeleteAccount'])->name('account.delete.action');

    Route::get('profile', [UsersCtrl::class,'showProfile'])->name('profile');
    Route::post('profile/update', [UsersCtrl::class,'actionUpdateProfile'])->name('profile.edit.action');
    Route::post('profile/forgotpw', [UsersCtrl::class,'actionForgotProfile'])->name('profile.forgot.action');

    Route::get('logout', [Sesiauth::class, 'logout'])->name('auth.logout');
    Route::get('audit', [AuditCtrl::class, 'showAudit'])->name('audit');
});


