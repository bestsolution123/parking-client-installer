<?php

use App\Http\Controllers\Api\allfunction;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\gateScannerController;
use App\Http\Controllers\Api\SerialComunicationController;
use App\Http\Controllers\Api\SiteGateParkingController;
use App\Http\Controllers\Api\SiteGateParkingControllerIndex;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('serial_comunication_index', [SerialComunicationController::class, 'index']);
Route::post('serial_comunication', [SerialComunicationController::class, 'create']);
Route::get('dashboard/getTransactionLatest', [TransactionController::class, 'getTransactionLatest']);
Route::get('dashboard/getTransactionVoucherLatest', [TransactionController::class, 'getTransactionVoucherLatest']);
Route::get('dashboard/getTransactionMemberLatest', [TransactionController::class, 'getTransactionMemberLatest']);
Route::post('qrcode/scanners', [gateScannerController::class, 'QrcodeScannerStore']);
Route::get('gate/checkPrinting/{gate_id}', [gateScannerController::class, 'checkPrinting']);
Route::get('gate/transaction/plat_number/{visitor_type}', [gateScannerController::class, 'transactionPlatNumber']);
Route::get('gate/punishment', [gateScannerController::class, 'punishment']);
Route::get('gate/member', [gateScannerController::class, 'member']);
Route::get('gate/voucher', [gateScannerController::class, 'voucher']);
Route::get('gate/voucher/{id}', [gateScannerController::class, 'voucherId']);
Route::get('gate/platnumber/{id}', [gateScannerController::class, 'platnumber']);
Route::get('gate/member/{id}', [gateScannerController::class, 'memberId']);
Route::get('gate/member/detail/{serial}', [gateScannerController::class, 'memberDetail']);
Route::get('gate/transaction/transactionQRCode/{serial}', [gateScannerController::class, 'transactionQRCode'])->name('dashboard/transaction');
Route::post('gate/transaction/finish/{serial}', [gateScannerController::class, 'finish'])->name('dashboard/transaction');
Route::get('gate/transaction/getAllData', [gateScannerController::class, 'getAllData'])->name('dashboard/transaction');
Route::post('gate/transaction/cron', [gateScannerController::class, 'GateScannerCronStore']);
Route::post('gate/transaction/cron/update', [gateScannerController::class, 'GateScannerCronUpdate']);
Route::post('gate/transaction/storeAllData', [gateScannerController::class, 'storeAllData'])->name('dashboard/transaction');
Route::post('gate/transaction/inCamera/update', [gateScannerController::class, 'inCameraUpdate'])->name('dashboard/transaction');
Route::post('gate/transaction/outCamera/update', [gateScannerController::class, 'outCameraUpdate'])->name('dashboard/transaction');
Route::post('gate/transaction/proccessFileCamera', [gateScannerController::class, 'proccessFileCamera'])->name('dashboard/transaction');
Route::post('gate/transaction/moveFileCamera', [gateScannerController::class, 'moveFileCamera'])->name('dashboard/transaction');



Route::get('dashboard/siteGateParking', [allfunction::class, 'index']);
Route::get('gate/checkVehicle/{id}', [allfunction::class, 'checkVehicle']);
Route::get('gate/printParkingExit/{serial}', [allfunction::class, 'printParkingExit']);
Route::post('gate/scanners/manual', [allfunction::class, 'GateScannerManualStore']);
Route::get('gate/printParking/{transaction_id}', [allfunction::class, 'printParking']);
Route::post('gate/scanners', [allfunction::class, 'GateScannerStore']);
Route::post('gate/scanners/voucher', [allfunction::class, 'GateScannerVoucherStore']);
Route::post('gate/scanners/member', [allfunction::class, 'GateScannerMemberStore']);
Route::post('gate/transaction/payment', [allfunction::class, 'payment'])->name('dashboard/transaction');
Route::get('gate/transaction/plat_number/detail/{plat_number}', [allfunction::class, 'transactionPlatNumberDetail']);
Route::get('gate/transaction/plat_number/detail/subscriber/{plat_number}', [allfunction::class, 'transactionPlatNumberSubscriberDetail']);
Route::post('gate/transaction/checkTransaction', [allfunction::class, 'checkTransaction'])->name('dashboard/transaction');


Route::post('dashboard/loginStore', [AuthController::class, 'loginStore']);
Route::post('dashboard/loginStore', [AuthController::class, 'loginStore']);
Route::get('dashboard/getAllVechile', [TransactionController::class, 'getAllVechile']);
