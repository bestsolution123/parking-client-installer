<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\manlessPayment;
use App\Models\member;
use App\Models\member_plat_number;
use App\Models\printer as ModelsPrinter;
use App\Models\printer_setting;
use App\Models\punishment;
use App\Models\User;
use App\Models\site_gate_parking;
use App\Models\siteGateParkingPayment;
use App\Models\transaction;
use App\Models\transaction_member;
use App\Models\transaction_voucher;
use App\Models\vehicle;
use App\Models\vehicle_initial;
use App\Models\voucher;
use App\Models\voucher_plat_number;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Psr7;


class gateScannerController extends Controller
{
    public function GateScanner($id, $user_id)
    {

        if (auth()->user()->role == 'admin') {
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->first();
            $transaction = transaction::where('is_deleted', 0)->whereDate('created_at', Carbon::today())->get();

        } else {
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', decrypt($id))->orderBy('id', "DESC")->first();
            $transaction = transaction::where('is_deleted', 0)->where('id', decrypt($id))->whereDate('created_at', Carbon::today())->get();

        }


        return view('content.new.index', [
            'site_gate_parking' => $site_gate_parking,
            'transaction' => $transaction,
            'user_id' => $user_id,
        ]);
    }



    public function QrcodeScannerStore(Request $request)
    {

        $validatedData = $request->validate([
            'serial' => 'required|max:255',
            'status' => 'required|max:255',
            'gate_out' => 'required|max:255',
            'out_photo' => 'required|max:255',
        ]);


        $transaction = transaction::where('is_deleted', 0)->where('serial', $validatedData['serial'])->first();
        // return $transaction;

        if ($transaction) {
            if ($transaction->status == '-') {
                $time_now = Carbon::now();

                transaction::where('serial', $validatedData['serial'])->update(
                    [
                        'date_out' => $time_now,
                        'status' => $validatedData['status'],
                        'gate_out' => $validatedData['gate_out'],
                        'out_photo' => $validatedData['out_photo'],
                    ]
                );
            }
        }

        return $transaction;
    }

    // public function printAntrian()
    // {
    //     $connector = new WindowsPrintConnector("192.168.1.90");
    //     $printer = new Printer($connector);
    //     // Most simple example
    //     $printer->setJustification(Printer::JUSTIFY_LEFT);
    //     $printer->text("20-10-2022                 ");
    //     $printer->text("10:00 \n");
    //     $printer->textRaw(str_repeat(chr(196), 32) . PHP_EOL);
    //     $printer->feed(1);
    //     $printer->setJustification(Printer::JUSTIFY_CENTER);
    //     $printer->setFont(Printer::FONT_A);
    //     $printer->setTextSize(2, 2);
    //     $printer->text("A12 \n");
    //     $printer->feed(1);
    //     $printer->selectPrintMode(Printer::MODE_FONT_A);
    //     $printer->text("Jalan Raya PKP No. 24 Kelapa Dua Wetan, Ciracas, jakarta TImur \n");
    //     $printer->feed(3);
    //     $printer->cut();
    //     $printer->close();
    // }

    // public function printParkingExit($transaction_id)
    // {

    //     // $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id',decrypt($gate_id))->orderBy('id', "DESC")->with('printer')->first();
    //     $transaction = transaction::where('is_deleted', 0)->where('id',$transaction_id)->orderBy('id', "DESC")->with('site_gate_parking.vehicle')->first();
    //     $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id',$transaction->site_gate_parking_id)->orderBy('id', "DESC")->with('printer')->with('printer_setting')->first();
    //     $date = Carbon::now();

    //     $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
    //     $all_price = 0;


    //     //calculate time
    //     $date1 = new DateTime($transaction->created_at);
    //     $date2 = new DateTime($transaction->date_out);
    //     $interval = $date1->diff($date2);

    //     $price = 0;
    //     $time_1 = 0;
    //     $time_2 = 0;

    //     if ($interval->h < 1 && $interval->m < (int) $transaction->site_gate_parking->vehicle->grace_time_duration) {
    //         $grace_time = (int) str_replace(['.', 'Rp'], '', $transaction->site_gate_parking->vehicle->grace_time);
    //         $price = $grace_time;
    //     }

    //     if ($time_1 == 0) {
    //         if ($interval->d < 1 && $interval->h > 0) {
    //             $time_price_1 = (int) str_replace(['.', 'Rp'], '', $transaction->site_gate_parking->vehicle->time_price_1);
    //             $price = $price + $time_price_1;
    //         }
    //         $time_1++;
    //     }

    //     if ($time_2 == 0) {
    //         if ($interval->d < 1 && $interval->h > 1) {
    //             $time_price_2 = (int) str_replace(['.', 'Rp'], '', $transaction->site_gate_parking->vehicle->time_price_2);
    //             $price = $price + $time_price_2;
    //         }
    //         $time_2++;
    //     }

    //     if ($interval->d < 1 && $interval->h > 2) {
    //         $time_price_3 = (int) str_replace(['.', 'Rp'], '', $transaction->site_gate_parking->vehicle->time_price_3);
    //         $price = $price + $time_price_3 * ($interval->h - 2);
    //     }

    //     if ($transaction->site_gate_parking->vehicle->maximum_daily == 1) {
    //         $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $transaction->site_gate_parking->vehicle->maximum_daily_price);
    //         if ($price > $maximum_daily_price) {
    //             $price = $maximum_daily_price;
    //         }
    //     }

    //     foreach ($punishment as $item2) {
    //         if ($item2->name == $transaction->status) {
    //             $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
    //             $price = $price + $punishment_price;
    //         }
    //     }

    //     $all_price = $all_price + $price;
    //     $all_price  = 'Rp ' . number_format($all_price);



    //     // return  $all_price ;


    //     if($site_gate_parking->printer->type_connection == "LAN")
    //     {
    //         $connector = new NetworkPrintConnector($site_gate_parking->printer->address);
    //     }
    //     else
    //     {
    //         $connector = new WindowsPrintConnector($site_gate_parking->printer->address);
    //     }

    //     $printer = new Printer($connector);

    //     // Most simple examples
    //     // $printer->text($date->format('h:i:s')." \n");        

    //     foreach($site_gate_parking->printer_setting as $item)
    //     {

    //         // if($item->name == "Logo")
    //         // {
    //         //     if($item->is_on == 1)
    //         //     {
    //         //         //logo
    //         //         // $tux = EscposImage::load("assets/img/parking_logo.png", false);
    //         //         // $printer->bitImage($tux);

    //         //         //batas garis
    //         //         if($site_gate_parking->printer->paper_size == "80")
    //         //         {
    //         //             $printer->textRaw(str_repeat(chr(196), 48) . PHP_EOL);
    //         //         }
    //         //         else  if($site_gate_parking->printer->paper_size == "55")
    //         //         {
    //         //             $printer->textRaw(str_repeat(chr(196), 32) . PHP_EOL);
    //         //         }

    //         //         $printer->feed(3);
    //         //     }

    //         // }

    //         if($item->name == "QRCode")
    //         {
    //             if($item->is_on == 1)
    //             {
    //                 $time = $transaction->created_at;
    //                 $timestr = $time->format('His');
    //                 $datestr = $time->format('Ymd');
    //                 $rand_number = rand (100 ,999);

    //                 if($site_gate_parking->id < 10)
    //                 {
    //                     $site_gate_parkingid = '0'. (string)$site_gate_parking->id;
    //                 }

    //                 $result_barcode = $site_gate_parkingid.$datestr.$timestr.$transaction->number.$rand_number;

    //                 //qrcode / barcode
    //                 $printer->setJustification(Printer::JUSTIFY_CENTER);
    //                 $printer->barcode($site_gate_parkingid.$datestr, Printer::BARCODE_CODE39);
    //                 // $printer->qrCode($transaction->serial, Printer::QR_ECLEVEL_M, 12, printer::QR_MODEL_2);

    //                 //qrcode serial
    //                 // $printer->feed(1);
    //                 // $printer->setJustification(Printer::JUSTIFY_CENTER);
    //                 // $printer->text( $transaction->serial . " \n");
    //                 $printer->feed(3);
    //             }

    //         }

    //         if($item->name == "Plat Kendaraan")
    //         {
    //             if($item->is_on == 1)
    //             {
    //                 //harga
    //                 $printer->setJustification(Printer::JUSTIFY_LEFT);
    //                 $printer->text("Harga : ");
    //                 $printer->text($all_price."\n");

    //                 //transaction detail
    //                 $printer->setJustification(Printer::JUSTIFY_LEFT);
    //                 $printer->text("Plat Kendaraan : ");
    //                 $printer->text("5 ABC 321 \n");

    //             }

    //         }

    //         if($item->name == "Tanggal Masuk")
    //         {
    //             if($item->is_on == 1)
    //             {
    //                 // transaction detail
    //                 $printer->text("Tanggal Masuk : ");
    //                 $printer->text($transaction->created_at . "\n");

    //                  // transaction detail
    //                  $printer->text("Tanggal Keluar : ");
    //                  $printer->text($transaction->date_out . "\n");
    //                  $printer->feed(3);
    //             }

    //         }

    //         if($item->name == "Alamat")
    //         {
    //             if($item->is_on == 1)
    //             {
    //                 //address
    //                 $printer->setJustification(Printer::JUSTIFY_CENTER);
    //                 $printer->selectPrintMode(Printer::MODE_FONT_A);
    //                 $printer->text($site_gate_parking->address . "\n");
    //                 $printer->feed(1);
    //             }

    //         }

    //         if($item->name == "Catatan")
    //         {
    //             if($item->is_on == 1)
    //             {
    //                 //batas garis
    //                 if($site_gate_parking->printer->paper_size == "80")
    //                 {
    //                     $printer->textRaw(str_repeat(chr(196), 48) . PHP_EOL);
    //                 }
    //                 else  if($site_gate_parking->printer->paper_size == "55")
    //                 {
    //                     $printer->textRaw(str_repeat(chr(196), 32) . PHP_EOL);
    //                 }

    //                 //informasi catatan
    //                 $printer->feed(1);
    //                 $printer->setJustification(Printer::JUSTIFY_CENTER);
    //                 $printer->text("Terimakasih Telah Berkunjung \n");

    //                 $printer->feed(3);
    //             }

    //         }

    //     }

    //     //printer cut
    //     $printer->cut();
    //     $printer->close();


    //     // return redirect('/gate/scanners/' . $id)->with('status', 'Profile updated!');
    // }

    public function checkPrinting($gate_id)
    {

        // $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id',decrypt($gate_id))->orderBy('id', "DESC")->with('printer')->first();
        $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', $gate_id)->orderBy('id', "DESC")->with('printer')->first();
        // return $site_gate_parking;
        $date = Carbon::now();

        if ($site_gate_parking->printer->type_connection == "LAN") {
            $connector = new NetworkPrintConnector($site_gate_parking->printer->address);
        } else {
            $connector = new WindowsPrintConnector($site_gate_parking->printer->address);
        }

        $printer = new Printer($connector);

        return 'printer_connected';


        // return redirect('/gate/scanners/' . $id)->with('status', 'Profile updated!');
    }

    public function transactionPlatNumber($visitor_type)
    {

        if ($visitor_type == "No Polisi") {
            $visitor_type = "Regular";
        }

        $transaction = DB::table('transactions')
            ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
            ->where('transactions.status', '-')
            ->where('transactions.visitor_type', $visitor_type)
            ->where('site_gate_parkings.type_payment', 'Manual')
            ->select('transactions.*')
            ->get();

        return response([
            'transaction' => $transaction
        ]);
    }



    public function punishment()
    {
        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        return response([
            'punishment' => $punishment
        ]);
    }

    public function platnumber($id)
    {
        $transaction = transaction::where('is_deleted', 0)->where('plat_number', $id)->orderBy('id', "DESC")->get();

        if ($transaction) {
            return response([
                'transaction' => '-'
            ]);

        }

    }

    public function member()
    {
        $transaction_member = transaction_member::where('is_deleted', 0)->with('member_plat_number')->orderBy('id', "DESC")->get();

        return response([
            'transaction_member' => $transaction_member
        ]);
    }

    public function transactionQRCode($serial)
    {
        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $transaction = transaction::where('is_deleted', 0)
            ->where('serial', $serial)
            ->where('status', '-')
            ->with('vehicle.vehicle_initial')
            ->with('site_gate_parking')
            ->first();

        if ($transaction) {
            return response([
                'message' => 'success',
                'transaction' => $transaction,
                'punishment' => $punishment,
            ]);
        } else {
            return response([
                'message' => 'error',
                'transaction' => $transaction,
                'punishment' => $punishment,
            ]);
        }

    }

    public function voucher()
    {
        $transaction_voucher = transaction_voucher::where('is_deleted', 0)->with('voucher_plat_number')->orderBy('id', "DESC")->get();

        return response([
            'transaction_voucher' => $transaction_voucher
        ]);
    }

    public function voucherId($id)
    {
        $transaction_voucher = transaction_voucher::where('is_deleted', 0)->where('serial', $id)->with('voucher_plat_number')->orderBy('id', "DESC")->first();
        $transaction = transaction::where('is_deleted', 0)->where('status', '-')->orderBy('id', "DESC")->get();

        $plat_number_result = array();
        $number = 0;

        foreach ($transaction as $item) {
            foreach ($transaction_voucher->voucher_plat_number as $item2) {
                if ($item2->plat_number == $item->plat_number) {
                    $plat_number_result[$number] = $item2->plat_number;
                    $number++;
                }
            }
        }

        return response([
            'transaction_voucher' => $plat_number_result
        ]);
    }


    public function memberId($id)
    {
        $transaction_member = transaction_member::where('is_deleted', 0)->where('serial', $id)->with('member_plat_number')->orderBy('id', "DESC")->first();
        $transaction = transaction::where('is_deleted', 0)->where('status', '-')->orderBy('id', "DESC")->get();

        $plat_number_result = array();
        $number = 0;

        foreach ($transaction as $item) {
            foreach ($transaction_member->member_plat_number as $item2) {
                if ($item2->plat_number == $item->plat_number) {
                    $plat_number_result[$number] = $item2->plat_number;
                    $number++;
                }
            }
        }

        return response([
            'transaction_member' => $plat_number_result
        ]);
    }

    public function memberDetail($serial)
    {
        $transaction_member = transaction_member::where('is_deleted', 0)->orderBy('id', "DESC")->with('member_plat_number')->where('serial', $serial)->first();

        return response([
            'transaction_member' => $transaction_member
        ]);
    }

    public function checkTransaction(Request $request)
    {

        // SAMPLE HIT API iPaymu v2 PHP //

        $va = '0000005889863432'; //get on iPaymu dashboard
        $apiKey = 'SANDBOX050B6053-FC4A-4F73-BAAA-731FBE2947BF'; //get on iPaymu dashboard

        $url = 'https://sandbox.ipaymu.com/api/v2/transaction'; // for development mode
        // $url          = 'https://my.ipaymu.com/api/v2/payment'; // for production mode

        $method = 'POST'; //method

        //Request Body//
        $body['transactionId'] = $request->transactionId;
        $body['account'] = "$va";
        // $body['qty']        = array('1', '3');
        // $body['price']      = array('100000', '20000');
        //End Request Body//

        //Generate Signature
        // *Don't change this
        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $apiKey;
        $signature = hash_hmac('sha256', $stringToSign, $apiKey);
        $timestamp = Date('YmdHis');
        //End Generate Signature


        $ch = curl_init($url);

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'va: ' . $va,
            'signature: ' . $signature,
            'timestamp: ' . $timestamp
        );

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_POST, count($body));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $err = curl_error($ch);
        $ret = curl_exec($ch);
        curl_close($ch);


        if ($err) {
            echo $err;
        } else {

            //Response
            $ret = json_decode($ret);
            return $ret;

            // if($ret->Status == 200) {
            //     $sessionId  = $ret->Data->SessionID;
            //     $url        =  $ret->Data->Url;
            //     header('Location:' . $url);
            // } else {
            //     echo $ret;
            // }
            //End Response
        }

    }

    public function finish(Request $request, $serial)
    {
        $transaction = transaction::where('is_deleted', 0)->with('site_gate_parking')->where('serial', $serial)->first();
        // return $transaction;

        if ($transaction->status == '-') {

            // date_default_timezone_set(Auth::user()->timeZone);
            date_default_timezone_set($transaction->timeZone);
            $time_now = Carbon::now();

            transaction::where('serial', $serial)->update(
                [
                    'status' => $request->status,
                    'gate_out' => $transaction->site_gate_parking->name,
                    'date_out' => $time_now,
                    'payment_method' => $transaction->site_gate_parking->type_payment,
                    'payment_type' => $request->payment_type,
                ]
            );

        } else {
            transaction::where('serial', $serial)->update(
                [
                    'status' => $request->status,
                ]
            );
        }

        return $transaction;


        // return redirect('dashboard/transaction')->with('success', 'data berhasil di ubah');

    }

    public function getAllData()
    {
        $manlessPayment = manlessPayment::where('is_deleted', 0)->get();
        $member = member::where('is_deleted', 0)->get();
        $member_plat_number = member_plat_number::where('is_deleted', 0)->get();
        $printer = ModelsPrinter::where('is_deleted', 0)->get();
        $printer_setting = printer_setting::where('is_deleted', 0)->get();
        $punishment = punishment::where('is_deleted', 0)->get();
        $site_gate_parking = site_gate_parking::where('is_deleted', 0)->get();
        $siteGateParkingPayment = siteGateParkingPayment::where('is_deleted', 0)->get();
        $transaction_member = transaction_member::where('is_deleted', 0)->get();
        $transaction_voucher = transaction_voucher::where('is_deleted', 0)->get();
        $transaction = transaction::where('is_deleted', 0)->get();

        $User = User::all();
        $vehicle = vehicle::where('is_deleted', 0)->get();
        $vehicle_initial = vehicle_initial::where('is_deleted', 0)->get();
        $voucher = voucher::where('is_deleted', 0)->get();
        $voucher_plat_number = voucher_plat_number::where('is_deleted', 0)->get();


        // return $transaction;


        return response([
            'manlessPayment' => $manlessPayment,
            'member' => $member,
            'member_plat_number' => $member_plat_number,
            'printer' => $printer,
            'printer_setting' => $printer_setting,
            'punishment' => $punishment,
            'site_gate_parking' => $site_gate_parking,
            'siteGateParkingPayment' => $siteGateParkingPayment,
            'transaction' => $transaction,
            'transaction_member' => $transaction_member,
            'transaction_voucher' => $transaction_voucher,
            'User' => $User,
            'vehicle' => $vehicle,
            'vehicle_initial' => $vehicle_initial,
            'voucher' => $voucher,
            'voucher_plat_number' => $voucher_plat_number,
        ]);


    }

    public function GateScannerCronStore(Request $request)
    {

        if ($request->gate_parking_type == "Keluar") {
            return response([
                "Message" => "Pintu Keluar Tidak Perlu Mengirim Data"
            ]);
        }


        if ($request->data != null) {
            foreach ($request->data as $item) {

                $transaction_all = transaction::where('number', $item['number'])->where('date_in', $item['date_in'])->get();

                if (count($transaction_all) == 0) {

                    $transaction = transaction::create([
                        'user_id' => $item['user_id'],
                        'vehicle_id' => $item['vehicle_id'],
                        'site_gate_parking_id' => $item['site_gate_parking_id'],
                        'serial' => $item['serial'],
                        'transaction_member_id' => $item['transaction_member_id'],
                        'transaction_voucher_id' => $item['transaction_voucher_id'],
                        'number' => $item['number'],
                        'visitor_type' => $item['visitor_type'],
                        'status' => $item['status'],
                        'gate_out' => $item['gate_out'],
                        'payment_type' => $item['payment_type'],
                        'payment_method' => $item['payment_method'],
                        'date_in' => $item['date_in'],
                        'date_out' => $item['date_out'],
                        'plat_number' => $item['plat_number'],
                        'in_photo' => $item['in_photo'],
                        'out_photo' => $item['out_photo'],
                        'timeZone' => $item['timeZone'],
                    ]);

                }


            }
        }



        return response([
            "Message" => "Success Kirim Data Transaksi"
        ]);

    }

    public function GateScannerCronUpdate(Request $request)
    {

        if ($request->gate_parking_type == "Masuk") {
            return response([
                "Message" => "Pintu Masuk Tidak Perlu Mengupdate Data"
            ]);
        }

        if ($request->data) {
            foreach ($request->data as $item) {

                transaction::where('serial', $item['serial'])->update(
                    [
                        'user_id' => $item['user_id'],
                        'vehicle_id' => $item['vehicle_id'],
                        'site_gate_parking_id' => $item['site_gate_parking_id'],
                        'serial' => $item['serial'],
                        'transaction_member_id' => $item['transaction_member_id'],
                        'transaction_voucher_id' => $item['transaction_voucher_id'],
                        'number' => $item['number'],
                        'visitor_type' => $item['visitor_type'],
                        'status' => $item['status'],
                        'gate_out' => $item['gate_out'],
                        'payment_type' => $item['payment_type'],
                        'payment_method' => $item['payment_method'],
                        'date_in' => $item['date_in'],
                        'date_out' => $item['date_out'],
                        'plat_number' => $item['plat_number'],
                        'in_photo' => $item['in_photo'],
                        'out_photo' => $item['out_photo'],
                        'timeZone' => $item['timeZone'],
                    ]

                );

            }
        }



        return response([
            "Message" => "Success Update Transaksi"
        ]);

    }

    public function storeAllData(Request $request)
    {

        $manlessPayment = manlessPayment::all();
        if (count($manlessPayment) != count($request->manlessPayment)) {
            if ($manlessPayment) {
                foreach ($manlessPayment as $item) {
                    $item->delete();
                }
            }

            foreach ($request->manlessPayment as $item) {
                manlessPayment::create([
                    "id" => $item['id'],
                    "name" => $item['name'],
                    "payment_type" => $item['payment_type'],
                    "payment_bank" => $item['payment_bank'],
                ]);
            }
        }

        $member = member::all();
        if (count($member) != count($request->member)) {
            if ($member) {
                foreach ($member as $item) {
                    $item->delete();
                }
            }
            foreach ($request->member as $item) {
                member::create([
                    "id" => $item['id'],
                    "user_id" => $item['user_id'],
                    "Nama" => $item['Nama'],
                    "Periode" => $item['Periode'],
                    "vehicle_id" => $item['vehicle_id'],
                    "Max_Kendaraan" => $item['Max_Kendaraan'],
                    "Tarif" => $item['Tarif'],
                    "Biaya_Kartu" => $item['Biaya_Kartu'],
                    "Biaya_Ganti_Plat_Number" => $item['Biaya_Ganti_Plat_Number'],
                    "Status" => $item['Status'],
                ]);
            }
        }



        $member_plat_number = member_plat_number::all();
        if (count($member_plat_number) != count($request->member_plat_number)) {
            if ($member_plat_number) {
                foreach ($member_plat_number as $item) {
                    $item->delete();
                }
            }
            foreach ($request->member_plat_number as $item) {
                member_plat_number::create([
                    "id" => $item['id'],
                    "transaction_member_id" => $item['transaction_member_id'],
                    "plat_number" => $item['plat_number'],
                ]);
            }
        }


        $printer = ModelsPrinter::all();
        if (count($printer) != count($request->printer)) {
            if ($printer) {
                foreach ($printer as $item) {
                    $item->delete();
                }
            }
            foreach ($request->printer as $item) {
                ModelsPrinter::create([
                    "id" => $item['id'],
                    "user_id" => $item['user_id'],
                    "name" => $item['name'],
                    "address" => $item['address'],
                    "type_connection" => $item['type_connection'],
                    "paper_size" => $item['paper_size'],
                ]);
            }
        }


        $printer_setting = printer_setting::all();
        if (count($printer_setting) != count($request->printer_setting)) {
            if ($printer_setting) {
                foreach ($printer_setting as $item) {
                    $item->delete();
                }
            }
            foreach ($request->printer_setting as $item) {
                printer_setting::create([
                    "id" => $item['id'],
                    "site_gate_parking_id" => $item['site_gate_parking_id'],
                    "user_id" => $item['user_id'],
                    "name" => $item['name'],
                    "is_on" => $item['is_on'],
                ]);
            }
        }

        $punishment = punishment::all();
        if (count($punishment) != count($request->punishment)) {
            if ($punishment) {
                foreach ($punishment as $item) {
                    $item->delete();
                }
            }
            foreach ($request->punishment as $item) {
                punishment::create([
                    "id" => $item['id'],
                    "user_id" => $item['user_id'],
                    "name" => $item['name'],
                    "price" => $item['price'],
                ]);
            }
        }


        $site_gate_parking = site_gate_parking::all();
        if (count($site_gate_parking) != count($request->site_gate_parking)) {
            if ($site_gate_parking) {
                foreach ($site_gate_parking as $item) {
                    $item->delete();
                }
            }
            foreach ($request->site_gate_parking as $item) {
                site_gate_parking::create([
                    "id" => $item['id'],
                    "user_id" => $item['user_id'],
                    "printer_id" => $item['printer_id'],
                    "vehicle_id" => $item['vehicle_id'],
                    "type_payment" => $item['type_payment'],
                    "name" => $item['name'],
                    "type" => $item['type'],
                    "address" => $item['address'],
                    "is_print" => $item['is_print'],
                ]);
            }
        }


        $siteGateParkingPayment = siteGateParkingPayment::all();
        if (count($siteGateParkingPayment) != count($request->siteGateParkingPayment)) {
            if ($siteGateParkingPayment) {
                foreach ($siteGateParkingPayment as $item) {
                    $item->delete();
                }
            }
            foreach ($request->siteGateParkingPayment as $item) {
                siteGateParkingPayment::create([
                    "id" => $item['id'],
                    "manless_payment_id" => $item['manless_payment_id'],
                    "site_gate_parking_id" => $item['site_gate_parking_id'],
                ]);
            }
        }


        $transaction_member = transaction_member::all();
        if (count($transaction_member) != count($request->transaction_member)) {
            if ($transaction_member) {
                foreach ($transaction_member as $item) {
                    $item->delete();
                }
            }
            foreach ($request->transaction_member as $item) {
                transaction_member::create([
                    "id" => $item['id'],
                    "user_id" => $item['user_id'],
                    "member_id" => $item['member_id'],
                    "serial" => $item['serial'],
                    "Nama" => $item['Nama'],
                    "Akses" => $item['Akses'],
                    "Hp" => $item['Hp'],
                    "Email" => $item['Email'],
                    "Tarif_Dasar_Member" => $item['Tarif_Dasar_Member'],
                    "Tarif_Member" => $item['Tarif_Member'],
                    "Tarif_Kartu" => $item['Tarif_Kartu'],
                    "Awal_Aktif" => $item['Awal_Aktif'],
                    "Akhir_Aktif" => $item['Akhir_Aktif'],
                    "Total_Biaya" => $item['Total_Biaya'],
                    "Status" => $item['Status'],
                ]);
            }
        }


        $transaction_voucher = transaction_voucher::all();
        if (count($transaction_voucher) != count($request->transaction_voucher)) {
            if ($transaction_voucher) {
                foreach ($transaction_voucher as $item) {
                    $item->delete();
                }
            }
            foreach ($request->transaction_voucher as $item) {
                transaction_voucher::create([
                    "id" => $item['id'],
                    "user_id" => $item['user_id'],
                    "voucher_id" => $item['voucher_id'],
                    "serial" => $item['serial'],
                    "Produk" => $item['Produk'],
                    "Tarif" => $item['Tarif'],
                    "Tarif_Dasar_Voucher" => $item['Tarif_Dasar_Voucher'],
                    "Total_Biaya" => $item['Total_Biaya'],
                    "Awal_Aktif" => $item['Awal_Aktif'],
                    "Akhir_Aktif" => $item['Akhir_Aktif'],
                    "Keterangan" => $item['Keterangan'],
                    "Status" => $item['Status'],
                ]);
            }
        }


        $User = User::all();
        if (count($User) != count($request->User)) {
            if ($User) {
                foreach ($User as $item) {
                    $item->delete();
                }
            }

            foreach ($request->User as $item) {
                User::create([
                    "id" => $item['id'],
                    "site_gate_parking_id" => $item['site_gate_parking_id'],
                    "name" => $item['name'],
                    "role" => $item['role'],
                    "timeZone" => $item['timeZone'],
                    "email" => $item['email'],
                    "password" => $item['password'],
                ]);
            }
        }



        $vehicle = vehicle::all();
        if (count($vehicle) != count($request->vehicle)) {
            if ($vehicle) {
                foreach ($vehicle as $item) {
                    $item->delete();
                }
            }
            foreach ($request->vehicle as $item) {
                vehicle::create([
                    "id" => $item['id'],
                    "vehicle_initial_id" => $item['vehicle_initial_id'],
                    "user_id" => $item['user_id'],
                    "serial" => $item['serial'],
                    "name" => $item['name'],
                    "time_price_1" => $item['time_price_1'],
                    "time_price_2" => $item['time_price_2'],
                    "time_price_3" => $item['time_price_3'],
                    "grace_time" => $item['grace_time'],
                    "grace_time_duration" => $item['grace_time_duration'],
                    "limitation_time_duration" => $item['limitation_time_duration'],
                    "maximum_daily" => $item['maximum_daily'],
                    "maximum_daily_price" => $item['maximum_daily_price'],
                ]);
            }
        }



        $vehicle_initial = vehicle_initial::all();
        if (count($vehicle_initial) != count($request->vehicle_initial)) {
            if ($vehicle_initial) {
                foreach ($vehicle_initial as $item) {
                    $item->delete();
                }
            }
            foreach ($request->vehicle_initial as $item) {
                vehicle_initial::create([
                    "id" => $item['id'],
                    "user_id" => $item['user_id'],
                    "name" => $item['name'],
                ]);
            }
        }



        $voucher = voucher::all();
        if (count($voucher) != count($request->voucher)) {
            if ($voucher) {
                foreach ($voucher as $item) {
                    $item->delete();
                }
            }
            foreach ($request->voucher as $item) {
                voucher::create([
                    "id" => $item['id'],
                    "user_id" => $item['user_id'],
                    "Nama" => $item['Nama'],
                    "Periode" => $item['Periode'],
                    "vehicle_id" => $item['vehicle_id'],
                    "Tarif" => $item['Tarif'],
                    "Model_Pembayaran" => $item['Model_Pembayaran'],
                    "Metode_Verifikasi" => $item['Metode_Verifikasi'],
                    "Status" => $item['Status'],
                ]);
            }
        }


        $voucher_plat_number = voucher_plat_number::all();
        if (count($voucher_plat_number) != count($request->voucher_plat_number)) {
            if ($voucher_plat_number) {
                foreach ($voucher_plat_number as $item) {
                    $item->delete();
                }
            }
            foreach ($request->voucher_plat_number as $item) {
                voucher_plat_number::create([
                    "id" => $item['id'],
                    "transaction_voucher_id" => $item['transaction_voucher_id'],
                    "plat_number" => $item['plat_number'],
                ]);
            }
        }

        if ($request->gate_parking_type == "Keluar") {

            $transaction = transaction::all();
            if (count($transaction) != 0) {
                if (count($transaction) != count($request->transaction)) {
                    if ($transaction) {
                        foreach ($transaction as $item) {
                            $item->delete();
                        }
                    }
                    foreach ($request->transaction as $item) {
                        transaction::create([
                            "id" => $item['id'],
                            "user_id" => $item['user_id'],
                            "site_gate_parking_id" => $item['site_gate_parking_id'],
                            "transaction_voucher_id" => $item['transaction_voucher_id'],
                            "transaction_member_id" => $item['transaction_member_id'],
                            "vehicle_id" => $item['vehicle_id'],
                            "serial" => $item['serial'],
                            "number" => $item['number'],
                            "plat_number" => $item['plat_number'],
                            "in_photo" => $item['in_photo'],
                            "out_photo" => $item['out_photo'],
                            "visitor_type" => $item['visitor_type'],
                            "payment_method" => $item['payment_method'],
                            "payment_type" => $item['payment_type'],
                            "status" => $item['status'],
                            "gate_out" => $item['gate_out'],
                            "date_out" => $item['date_out'],
                            "timeZone" => $item['timeZone'],
                            "date_in" => $item['date_in'],
                        ]);
                    }
                }
            }


            return response([
                "Message" => "Pintu Keluar Sukses Mengambil Data Transaksi"
            ]);
        }

        // return $transaction;


        return response([
            'Message' => 'Success Mengambil Basic Data',
        ]);


    }


    public function inCameraUpdate(Request $request)
    {
        $transaction = transaction::where('is_deleted', 0)->where('serial', $request->serial)->first();
        // return $transaction;

        transaction::where('serial', $request->serial)->update(
            [
                'in_photo' => $request->out_photo,
            ]
        );

        return $transaction;
        // return redirect('dashboard/transaction')->with('success', 'data berhasil di ubah');

    }


    public function outCameraUpdate(Request $request)
    {
        $transaction = transaction::where('is_deleted', 0)->where('serial', $request->serial)->first();
        // return $transaction;

        transaction::where('serial', $request->serial)->update(
            [
                'out_photo' => $request->out_photo,
            ]
        );

        return $transaction;
        // return redirect('dashboard/transaction')->with('success', 'data berhasil di ubah');

    }


    public function moveFileCamera(Request $request)
    {
        if (!file_exists(public_path('storage/cctv/') . $request->name)) {
            $request['contents']->move(public_path('storage/cctv'), $request->name);
        }

        return response([
            'message' => 'success',
        ]);
        // return redirect('dashboard/transaction')->with('success', 'data berhasil di ubah');

    }

    public function proccessFileCamera(Request $request)
    {

        $transaction = transaction::where('is_deleted', 0)->get();
        $server_address = 'http://127.0.0.1:8000';

        foreach ($transaction as $item) {
            //send gate in take capture image

            if ($request->gate_parking_type == "Keluar") {
                $file = $item->out_photo;
            } else if ($request->gate_parking_type == "Masuk") {
                $file = $item->in_photo;
            }

            if (file_exists(public_path('storage/cctv/') . $file)) {

                $file_path = public_path('storage/cctv/');
                $client = new \GuzzleHttp\Client();
                $url = $server_address . '/api/gate/transaction/moveFileCamera';

                $response = $client->request('POST', $url, [
                    'multipart' => [
                        [
                            'name' => 'contents',
                            'contents' => Psr7\Utils::tryFopen($file_path . $file, 'r'),
                        ],
                        [
                            'name' => 'name',
                            'contents' => $file
                        ],
                    ]
                ]);

                $code = $response->getStatusCode();
                $response = $response->getBody();
                $responseData = json_decode($response, true);
            }
        }

        return response([
            "message" => "file capture berhasil dikirim"
        ]);

    }

}
