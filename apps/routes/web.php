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
use App\Http\Controllers\AccountCtrl;
use App\Http\Controllers\CheckinCtrl;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutCtrl;
use App\Http\Controllers\LocationCtrl;
use App\Http\Controllers\CategoriesCtrl;
use App\Http\Controllers\PermissionCtrl;
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

Route::middleware(['auth','permission:asset-management'])->group(function () {
    Route::get('asset', [AssetsCtrl::class, 'showAsset'])->name('asset')->middleware('permission:asset-management');
    Route::get('master/{slug}', [AssetsCtrl::class, 'showMasterAsset'])->name('masterAsset')->middleware('permission:detail-master-asset');
    Route::post('master/update', [AssetsCtrl::class, 'actionEditMasterAsset'])->name('masterAsset.edit.action')->middleware('permission:edit-master-asset');
    Route::get('item/{codeAsset}', [AssetsCtrl::class, 'showItemAsset'])->name('itemAsset')->middleware('permission:detail-item-asset');
    Route::post('item/update', [AssetsCtrl::class, 'actionEditItemAsset'])->name('itemAsset.edit.action')->middleware('permission:edit-item-asset');
});

Route::middleware(['auth','permission:maintenance-management'])->group(function () {
    Route::get('maintenence/refreshschedule',[MaintenenceCtrl::class, 'refreshSchedule'])->name('refreshSchedule')->middleware('permission:refresh-schaduler-maintenance');
    Route::get('maintenence', [MaintenenceCtrl::class, 'showMaintenence'])->name('showMainten')->middleware('permission:maintenance-management');
    Route::get('maintenence/resolve/{codeMainten}', [MaintenenceCtrl::class, 'showResolveMainten'])->name('mainten.resolve')->middleware('permission:resolve-maintenance');
    Route::post('maintenence/resolve', [MaintenenceCtrl::class, 'actionResolveMainten'])->name('mainten.resolve.action')->middleware('permission:resolve-maintenance');
});

Route::middleware(['auth','permission:checkin'])->group(function () {
    Route::get('checkin/{slug?}', [CheckinCtrl::class, 'showCheckin'])->name('showCheckIn')->middleware('permission:checkin');
    Route::post('checkin/add', [CheckinCtrl::class, 'actionAddCheckinCart'])->name('checkin.add.action')->middleware('permission:checkin');
    Route::post('checkin/remove/{id}', [CheckinCtrl::class, 'actionRmfCheckinCart'])->name('checkin.remove.action')->middleware('permission:checkin');
    Route::post('checkin/save', [CheckinCtrl::class, 'actionSaveCheckinCart'])->name('checkin.save.action')->middleware('permission:checkin');
    Route::post('checkin/importexcel', [CheckinCtrl::class, 'importCheckinExcel'])->name('checkin.import.action')->middleware('permission:checkin');
});


Route::middleware(['auth','permission:checkout'])->group(function () {
    Route::get('checkout', [CheckoutCtrl::class, 'showCheckOut'])->name('showCheckOut')->middleware('permission:checkout');
    Route::post('checkout/add', [CheckoutCtrl::class, 'actionAddcheckoutCart'])->name('checkout.add.action')->middleware('permission:checkout');
    Route::post('checkout/remove/{id}', [CheckoutCtrl::class, 'actionRmfcheckoutCart'])->name('checkout.remove.action')->middleware('permission:checkout');
    Route::post('checkout/save', [CheckoutCtrl::class, 'actionSavecheckoutCart'])->name('checkout.save.action')->middleware('permission:checkout');
});

Route::middleware(['auth','permission:location-management'])->group(function () {
    Route::get('location', [LocationCtrl::class, 'showLocation'])->name('location')->middleware('permission:location-management');
    Route::post('location/add', [LocationCtrl::class, 'actionAddLocation'])->name('location.add.action')->middleware('permission:add-location');
    Route::post('location/update', [LocationCtrl::class, 'actionUpdateLocation'])->name('location.edit.action')->middleware('permission:edit-location');
    Route::post('location/importexcel', [LocationCtrl::class, 'importLocationExcel'])->name('location.import.action')->middleware('permission:import-location');
    Route::delete('location/delete/{id}', [LocationCtrl::class, 'actionDeleteLocation'])->name('location.delete.action')->middleware('permission:delete-location');
});

Route::middleware(['auth','permission:department-management'])->group(function () {
    Route::get('department', [DepartementCtrl::class, 'showDepartment'])->name('department')->middleware('permission:department-management');
    Route::post('department/add', [DepartementCtrl::class, 'actionAddDepartment'])->name('department.add.action')->middleware('permission:add-department');
    Route::post('department/update', [DepartementCtrl::class, 'actionUpdateDepartment'])->name('department.edit.action')->middleware('permission:edit-department');
    Route::post('department/importexcel', [DepartementCtrl::class, 'importDeparmentExcel'])->name('department.import.action')->middleware('permission:import-department');
    Route::delete('department/delete/{id}', [DepartementCtrl::class, 'actionDeleteDepartment'])->name('department.delete.action')->middleware('permission:delete-department');
});

Route::middleware(['auth','permission:category-management'])->group(function () {
    Route::get('category', [CategoriesCtrl::class, 'showCategory'])->name('category')->middleware('permission:category-management');
    Route::post('category/add', [CategoriesCtrl::class, 'actionAddCategory'])->name('category.add.action')->middleware('permission:add-category');
    Route::post('category/update', [CategoriesCtrl::class, 'actionUpdateCategory'])->name('category.edit.action')->middleware('permission:edit-category');
    Route::post('category/importexcel', [CategoriesCtrl::class, 'importCategoryExcel'])->name('category.import.action')->middleware('permission:import-category');
    Route::delete('category/delete/{id}', [CategoriesCtrl::class, 'actionDeleteCategory'])->name('category.delete.action')->middleware('permission:delete-category');
});

Route::middleware(['auth','permission:role-management'])->group(function () {
    Route::get('role', [RolesCtrl::class, 'showRoles'])->name('role')->middleware('permission:role-management');
    Route::post('role/add', [RolesCtrl::class, 'actionAddRole'])->name('role.add.action')->middleware('permission:add-role');
    Route::post('role/update', [RolesCtrl::class, 'actionUpdateRole'])->name('role.edit.action')->middleware('permission:edit-role');
    Route::delete('role/delete/{id}', [RolesCtrl::class, 'actionDeleteRole'])->name('role.delete.action')->middleware('permission:delete-role');
    Route::get('permission/{id}', [PermissionCtrl::class, 'showPermission'])->name('permission')->middleware('permission:role-permission-management');
    Route::post('permission/update/{id}', [PermissionCtrl::class, 'syncPermissions'])->name('permission.update.action')->middleware('permission:role-permission-management');
});

Route::middleware(['auth','permission:vendor-management'])->group(function () {
    Route::get('vendor', [VendorCtrl::class, 'showVendor'])->name('vendor')->middleware('permission:vendor-management');
    Route::post('vendor/add', [VendorCtrl::class, 'actionAddVendor'])->name('vendor.add.action')->middleware('permission:add-vendor');
    Route::post('vendor/update', [VendorCtrl::class, 'actionUpdateVendor'])->name('vendor.edit.action')->middleware('permission:edit-vendor');
    Route::post('vendor/importexcel', [VendorCtrl::class, 'importVendorExcel'])->name('vendor.import.action')->middleware('permission:import-vendor');
    Route::delete('vendor/delete/{id}', [VendorCtrl::class, 'actionDeleteVendor'])->name('vendor.delete.action')->middleware('permission:delete-vendor');
});

Route::middleware(['auth','permission:account-management'])->group(function () {
    Route::get('account', [AccountCtrl::class, 'showAccount'])->name('account')->middleware('permission:account-management');
    Route::post('account/add', [AccountCtrl::class, 'actionAddAccount'])->name('account.add.action')->middleware('permission:add-account');
    Route::post('account/update', [AccountCtrl::class, 'actionUpdateAccount'])->name('account.edit.action')->middleware('permission:edit-account');
    Route::post('account/reset', [AccountCtrl::class, 'actionResetAccount'])->name('account.reset.action')->middleware('permission:reset-account');
    Route::post('account/disable', [AccountCtrl::class, 'actionDisableAccount'])->name('account.disable.action')->middleware('permission:disable-account');
    Route::post('account/enable', [AccountCtrl::class, 'actionEnableAccount'])->name('account.enable.action')->middleware('permission:disable-account');
    Route::post('account/importexcel', [AccountCtrl::class, 'importAccountExcel'])->name('account.import.action')->middleware('permission:import-account');
    Route::post('account/delete', [AccountCtrl::class, 'actionDeleteAccount'])->name('account.delete.action')->middleware('permission:delete-account');
});

Route::middleware(['auth','permission:audit-management'])->group(function () {
    Route::get('audit', [AuditCtrl::class, 'showAudit'])->name('audit');
    Route::get('audit/checkin/{codecheckin}', [AuditCtrl::class, 'showAuditCheckin'])->name('audit.checkin');
    Route::get('audit/checkout/{codecheckout}', [AuditCtrl::class, 'showAuditCheckout'])->name('audit.checkout');
    Route::get('audit/maintenence/{codeMainten}', [AuditCtrl::class, 'showAuditMaintenance'])->name('audit.mainten');
});


Route::middleware('auth')->group(function () {
    Route::get('dashboard', [Dashboard::class, 'showDashboard'])->name('dashboard');

    Route::get('prints/{slug}', [PrintCtrl::class, 'showPrint'])->name('print')->middleware('permission:printqr-master-asset');
    Route::get('print/{codeAsset}', [PrintCtrl::class, 'showPrint1'])->name('printbycode')->middleware('permission:printqr-item-asset');   

    Route::get('report/mainten/{codeAsset}', [MaintenenceCtrl::class, 'showReportMaintenence'])->name('mainten.report')->middleware('permission:report-maintenance');
    Route::post('report/mainten/', [MaintenenceCtrl::class, 'actionReportMainten'])->name('mainten.report.action')->middleware('permission:report-maintenance');
    Route::get('maintenence/{codeMainten}', [MaintenenceCtrl::class, 'showDetailMaintenence'])->name('showDetailMainten')->middleware('permission:detail-maintenance');
    
    Route::get('scan/asset', [ScanCtrl::class, 'showScanAsset'])->name('scanAsset')->middleware('permission:scan-item-asset');
    Route::get('scan/reportmaintence', [ScanCtrl::class, 'showScanReportMainten'])->name('scanReportMaintence')->middleware('permission:scan-maintenance-report');

    Route::get('profile', [UsersCtrl::class,'showProfile'])->name('profile');
    Route::post('profile/update', [UsersCtrl::class,'actionUpdateProfile'])->name('profile.edit.action');
    Route::post('profile/forgotpw', [UsersCtrl::class,'actionForgotProfile'])->name('profile.forgot.action');

    Route::get('logout', [Sesiauth::class, 'logout'])->name('auth.logout');
});