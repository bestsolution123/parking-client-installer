<?php

use App\Http\Controllers\AgamaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\gateScanner;
use App\Http\Controllers\gateScannerController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\GolonganRuangController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\ManlessPaymentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\PunishmentController;
use App\Http\Controllers\SiteGateParkingController;
use App\Http\Controllers\StatusKepegawaianController;
use App\Http\Controllers\StatusPerkawinanController;
use App\Http\Controllers\TingkatPendidikanController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionMemberController;
use App\Http\Controllers\TransactionVoucherController;
use App\Http\Controllers\userController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleInitialController;
use App\Http\Controllers\VoucherController;
use App\Models\status_kepegawaian;
use App\Models\status_perkawinan;
use App\Models\transaction;
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

// Route::get('/', [dashboardController::class, 'index'])->middleware('auth');
Route::get('/', [dashboardController::class, 'index'])->name('dashboard-analytics');

// site gate parking
Route::get('dashboard/siteGateParking', [SiteGateParkingController::class, 'index'])->name('dashboard/siteGateParking');
Route::get('dashboard/siteGateParking/create', [SiteGateParkingController::class, 'create'])->name('dashboard/siteGateParking');
Route::post('dashboard/siteGateParking/create', [SiteGateParkingController::class, 'store'])->name('dashboard/siteGateParking');
Route::get('dashboard/siteGateParking/edit/{id}', [SiteGateParkingController::class, 'edit'])->name('dashboard/siteGateParking');
Route::post('dashboard/siteGateParking/edit/{id}', [SiteGateParkingController::class, 'update'])->name('dashboard/siteGateParking');
Route::post('dashboard/siteGateParking/delete/{id}', [SiteGateParkingController::class, 'destroy'])->name('dashboard/siteGateParking');

// initial kendaraan
Route::get('dashboard/vehicleInitial', [VehicleInitialController::class, 'index'])->name('dashboard/vehicleInitial');
Route::get('dashboard/vehicleInitial/create', [VehicleInitialController::class, 'create'])->name('dashboard/vehicleInitial');
Route::post('dashboard/vehicleInitial/create', [VehicleInitialController::class, 'store'])->name('dashboard/vehicleInitial');
Route::get('dashboard/vehicleInitial/edit/{id}', [VehicleInitialController::class, 'edit'])->name('dashboard/vehicleInitial');
Route::post('dashboard/vehicleInitial/edit/{id}', [VehicleInitialController::class, 'update'])->name('dashboard/vehicleInitial');
Route::post('dashboard/vehicleInitial/delete/{id}', [VehicleInitialController::class, 'destroy'])->name('dashboard/vehicleInitial');

//  kendaraan
Route::get('dashboard/vehicle', [VehicleController::class, 'index'])->name('dashboard/vehicle');
Route::get('dashboard/vehicle/create', [VehicleController::class, 'create'])->name('dashboard/vehicle');
Route::post('dashboard/vehicle/create', [VehicleController::class, 'store'])->name('dashboard/vehicle');
Route::get('dashboard/vehicle/edit/{id}', [VehicleController::class, 'edit'])->name('dashboard/vehicle');
Route::post('dashboard/vehicle/edit/{id}', [VehicleController::class, 'update'])->name('dashboard/vehicle');
Route::post('dashboard/vehicle/delete/{id}', [VehicleController::class, 'destroy'])->name('dashboard/vehicle');

//  punishment
Route::get('dashboard/punishment', [PunishmentController::class, 'index'])->name('dashboard/punishment');
Route::get('dashboard/punishment/create', [PunishmentController::class, 'create'])->name('dashboard/punishment');
Route::post('dashboard/punishment/create', [PunishmentController::class, 'store'])->name('dashboard/punishment');
Route::get('dashboard/punishment/edit/{id}', [PunishmentController::class, 'edit'])->name('dashboard/punishment');
Route::post('dashboard/punishment/edit/{id}', [PunishmentController::class, 'update'])->name('dashboard/punishment');
Route::post('dashboard/punishment/delete/{id}', [PunishmentController::class, 'destroy'])->name('dashboard/punishment');

//  user
Route::get('dashboard/auth', [userController::class, 'index'])->name('dashboard/auth');
Route::get('dashboard/auth/create', [userController::class, 'create'])->name('dashboard/auth');
Route::post('dashboard/auth/create', [userController::class, 'store'])->name('dashboard/auth');
Route::get('dashboard/auth/edit/{id}', [userController::class, 'edit'])->name('dashboard/auth');
Route::post('dashboard/auth/edit/{id}', [userController::class, 'update'])->name('dashboard/auth');
Route::post('dashboard/auth/delete/{id}', [userController::class, 'destroy'])->name('dashboard/auth');


//  printer
Route::get('dashboard/printer', [PrinterController::class, 'index'])->name('dashboard/printer');
Route::get('dashboard/printer/create', [PrinterController::class, 'create'])->name('dashboard/printer');
Route::post('dashboard/printer/create', [PrinterController::class, 'store'])->name('dashboard/printer');
Route::get('dashboard/printer/edit/{id}', [PrinterController::class, 'edit'])->name('dashboard/printer');
Route::post('dashboard/printer/edit/{id}', [PrinterController::class, 'update'])->name('dashboard/printer');
Route::post('dashboard/printer/delete/{id}', [PrinterController::class, 'destroy'])->name('dashboard/printer');


//  mainlessPayment
Route::get('dashboard/manlessPayment', [ManlessPaymentController::class, 'index'])->name('dashboard/manlessPayment');
Route::get('dashboard/manlessPayment/create', [ManlessPaymentController::class, 'create'])->name('dashboard/manlessPayment');
Route::post('dashboard/manlessPayment/create', [ManlessPaymentController::class, 'store'])->name('dashboard/manlessPayment');
Route::get('dashboard/manlessPayment/edit/{id}', [ManlessPaymentController::class, 'edit'])->name('dashboard/manlessPayment');
Route::post('dashboard/manlessPayment/edit/{id}', [ManlessPaymentController::class, 'update'])->name('dashboard/manlessPayment');
Route::post('dashboard/manlessPayment/delete/{id}', [ManlessPaymentController::class, 'destroy'])->name('dashboard/manlessPayment');


//  member
Route::get('dashboard/member', [MemberController::class, 'index'])->name('dashboard/member');
Route::get('dashboard/member/create', [MemberController::class, 'create'])->name('dashboard/member');
Route::post('dashboard/member/create', [MemberController::class, 'store'])->name('dashboard/member');
Route::get('dashboard/member/edit/{id}', [MemberController::class, 'edit'])->name('dashboard/member');
Route::post('dashboard/member/edit/{id}', [MemberController::class, 'update'])->name('dashboard/member');
Route::post('dashboard/member/delete/{id}', [MemberController::class, 'destroy'])->name('dashboard/member');
Route::post('dashboard/member/changeStatus/{id}', [MemberController::class, 'changeStatus'])->name('dashboard/member');

//  voucher
Route::get('dashboard/voucher', [VoucherController::class, 'index'])->name('dashboard/voucher');
Route::get('dashboard/voucher/create', [VoucherController::class, 'create'])->name('dashboard/voucher');
Route::post('dashboard/voucher/create', [VoucherController::class, 'store'])->name('dashboard/voucher');
Route::get('dashboard/voucher/edit/{id}', [VoucherController::class, 'edit'])->name('dashboard/voucher');
Route::post('dashboard/voucher/edit/{id}', [VoucherController::class, 'update'])->name('dashboard/voucher');
Route::post('dashboard/voucher/delete/{id}', [VoucherController::class, 'destroy'])->name('dashboard/voucher');
Route::post('dashboard/voucher/changeStatus/{id}', [VoucherController::class, 'changeStatus'])->name('dashboard/member');

// list voucher
Route::get('dashboard/voucher/list', [TransactionVoucherController::class, 'index'])->name('dashboard/voucher/list');
Route::get('dashboard/voucher/list/create', [TransactionVoucherController::class, 'create'])->name('dashboard/voucher/list');
Route::post('dashboard/voucher/list/create', [TransactionVoucherController::class, 'store'])->name('dashboard/voucher/list');
Route::get('dashboard/voucher/list/edit/{id}', [TransactionVoucherController::class, 'edit'])->name('dashboard/voucher/list');
Route::post('dashboard/voucher/list/edit/{id}', [TransactionVoucherController::class, 'update'])->name('dashboard/voucher/list');
Route::post('dashboard/voucher/list/delete/{id}', [TransactionVoucherController::class, 'destroy'])->name('dashboard/voucher/list');
Route::post('dashboard/voucher/list/changeStatus/{id}', [TransactionVoucherController::class, 'changeStatus'])->name('dashboard/member');

// list member
Route::get('dashboard/member/list', [TransactionMemberController::class, 'index'])->name('dashboard/member/list');
Route::get('dashboard/member/list/create', [TransactionMemberController::class, 'create'])->name('dashboard/member/list');
Route::post('dashboard/member/list/create', [TransactionMemberController::class, 'store'])->name('dashboard/member/list');
Route::get('dashboard/member/list/edit/{id}', [TransactionMemberController::class, 'edit'])->name('dashboard/member/list');
Route::post('dashboard/member/list/edit/{id}', [TransactionMemberController::class, 'update'])->name('dashboard/member/list');
Route::post('dashboard/member/list/delete/{id}', [TransactionMemberController::class, 'destroy'])->name('dashboard/member/list');
Route::post('dashboard/member/list/changeStatus/{id}', [TransactionMemberController::class, 'changeStatus'])->name('dashboard/member');


// transaction
Route::get('dashboard/report', [TransactionController::class, 'reportIndex'])->name('dashboard/report');
// Route::get('gate/printParkingExit/{transaction_id}', [TransactionController::class, 'printParkingExit']);
Route::get('gate/printParkingExit/{transaction_id}/{printer_id}', [TransactionController::class, 'printParkingExitAdmin']);
Route::get('dashboard/report/member', [TransactionController::class, 'reportIndexMember'])->name('dashboard/report/member');
Route::get('dashboard/transaction', [TransactionController::class, 'index'])->name('dashboard/transaction');
Route::get('dashboard/transaction/create', [TransactionController::class, 'create'])->name('dashboard/transaction');
Route::post('dashboard/transaction/create', [TransactionController::class, 'store'])->name('dashboard/transaction');
Route::get('dashboard/transaction/edit/{id}', [TransactionController::class, 'edit'])->name('dashboard/transaction');
Route::post('dashboard/transaction/edit/{id}', [TransactionController::class, 'update'])->name('dashboard/transaction');
Route::post('dashboard/transaction/delete/{id}', [TransactionController::class, 'destroy'])->name('dashboard/transaction');
Route::get('dashboard/getTransactionLatest', [TransactionController::class, 'getTransactionLatest'])->name('dashboard/transaction');
Route::post('dashboard/transaction/finish/{id}', [TransactionController::class, 'finish'])->name('dashboard/transaction');

//laporan
Route::get('dashboard/report/kendaraan', [TransactionController::class, 'reportKendaraan'])->name('dashboard/report/kendaraan');
Route::get('dashboard/report/overnight', [TransactionController::class, 'reportOvernight'])->name('dashboard/report/overnight');
Route::get('dashboard/report/pendapatan/parkir', [TransactionController::class, 'reportPendapatanParkir'])->name('dashboard/report/pendapatan/parkir');
Route::get('dashboard/report/pendapatan/member', [TransactionController::class, 'reportPendapatanMember'])->name('dashboard/report/pendapatan/member');
Route::get('dashboard/report/pendapatan/voucher', [TransactionController::class, 'reportPendapatanVoucher'])->name('dashboard/report/pendapatan/voucher');
Route::get('dashboard/report/pendapatan/gabungan', [TransactionController::class, 'reportPendapatanGabungan'])->name('dashboard/report/pendapatan/gabungan');
Route::get('dashboard/report/pembatalan/transaksi', [TransactionController::class, 'reportPembatalanTransaksi'])->name('dashboard/report/pembatalan/transaksi');

//transaction log
Route::get('dashboard/transaction/regular', [TransactionController::class, 'transactionRegular'])->name('dashboard/transaction/regular');
Route::get('dashboard/transaction/member', [TransactionController::class, 'transactionMember'])->name('dashboard/transaction/member');
Route::get('dashboard/transaction/voucher', [TransactionController::class, 'transactionVoucher'])->name('dashboard/transaction/voucher');


//scanner
Route::get('gate/scanners/{id}/{user_id}', [gateScannerController::class, 'GateScanner']);
Route::post('gate/scanners', [gateScannerController::class, 'GateScannerStore']);


//printer
Route::get('gate/printParking/{gate_id}/{transaction_id}', [gateScannerController::class, 'printParking']);
Route::get('gate/checkPrinting/{gate_id}', [gateScannerController::class, 'checkPrinting']);


// login
Route::get('login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'loginStore']);
Route::post('logout', [AuthController::class, 'logout']);


//json
Route::get('dashboard/memberId/{id}', [MemberController::class, 'memberId'])->name('dashboard/member');
Route::get('dashboard/voicherId/{id}', [MemberController::class, 'voicherId'])->name('dashboard/member');
Route::get('dashboard/transaction/member/{id}', [TransactionMemberController::class, 'transactionMemberId'])->name('dashboard/member');
Route::post('dashboard/transaction/memberExtendMember/{id}', [TransactionMemberController::class, 'transactionMemberExtendMember'])->name('dashboard/member');
Route::get('dashboard/transaction/voucher/{id}', [TransactionVoucherController::class, 'transactionVoucherId'])->name('dashboard/member');
Route::post('dashboard/transaction/voucherExtendVoucher/{id}', [TransactionVoucherController::class, 'transactionVoucherExtendVoucher'])->name('dashboard/member');

//export excel
Route::get('dashboard/exportExcel/transaksi/{type_visitor}', [TransactionController::class, 'export_excel_transaksi'])->name('dashboard/report');