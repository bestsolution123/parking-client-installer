<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\punishment;
use App\Models\site_gate_parking;
use App\Models\transaction;
use App\Models\transaction_member;
use App\Models\transaction_voucher;
use App\Models\User;
use App\Models\vehicle;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Carbon\Carbon;
use App\Models\member;
use App\Models\member_plat_number;
use App\Models\manlessPayment;
use App\Models\printer as ModelsPrinter;
use App\Models\siteGateParkingPayment;
use App\Models\printer_setting;
use App\Models\voucher;
use App\Models\voucher_plat_number;
use App\Models\vehicle_initial;
use GuzzleHttp\Psr7;




class allfunction extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $site_gate_parking = site_gate_parking::where('is_deleted', 0)
            ->where('id', Auth::user()->site_gate_parking_id)
            ->orderBy('id', "DESC")
            ->with('printer')
            ->with('vehicle.vehicle_initial')
            ->first();
        return $site_gate_parking;
    }

    public function checkVehicle($id)
    {
        $vehicle = vehicle::where('is_deleted', 0)
            ->where('serial', $id)
            ->first();
        return $vehicle;
    }

    public function printParkingExit($serial)
    {

        // $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id',decrypt($gate_id))->orderBy('id', "DESC")->with('printer')->first();
        $transaction = transaction::where('is_deleted', 0)->where('serial', $serial)->orderBy('id', "DESC")->with('site_gate_parking.vehicle')->first();
        $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', Auth::user()->site_gate_parking_id)->orderBy('id', "DESC")->with('printer')->with('printer_setting')->first();
        $date = Carbon::now();

        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $all_price = 0;

        //calculate time
        $date1 = new DateTime($transaction->created_at);
        $date2 = new DateTime($transaction->date_out);
        $interval = $date1->diff($date2);

        $price = 0;
        $time_1 = 0;
        $time_2 = 0;


        if ($interval->d < 1 && $interval->h < 1 && $interval->i < (int) $transaction->vehicle->grace_time_duration) {
            $grace_time = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->grace_time);
            $price = $grace_time;
        } elseif ($interval->d < 1 && $interval->h < 1 && $interval->i > (int) $transaction->vehicle->grace_time_duration) {
            $time_price_1 = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->time_price_1);
            $price = $time_price_1;
        }

        if ($time_1 == 0) {
            if (60 + $interval->i >= $transaction->vehicle->limitation_time_duration) {
                $time_price_1 = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->time_price_1);
                $price = $price + $time_price_1;
            }
            $time_1++;
        }

        if ($time_2 == 0) {
            if ($interval->h * 60 + $interval->i >= 60 + $transaction->vehicle->limitation_time_duration) {
                $time_price_2 = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->time_price_2);
                $price = $price + $time_price_2;
            }
            $time_2++;
        }

        if ($interval->h * 60 + $interval->i >= 120 + $transaction->vehicle->limitation_time_duration) {
            $time_price_3 = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->time_price_3);
            if ($interval->h <= 2) {
                $price = $price + $time_price_3;
            } else {
                $price = $price + $time_price_3 * ($interval->h - 1);
            }
        }

        if ($transaction->vehicle->maximum_daily >= 1) {
            $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $transaction->site_gate_parking->vehicle->maximum_daily_price);
            $price = $price + $maximum_daily_price * $interval->d;
        }

        foreach ($punishment as $item2) {
            if ($item2->name == $transaction->status) {
                $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                $price = $price + $punishment_price;
            }
        }

        $all_price = $all_price + $price;
        $all_price = 'Rp ' . number_format($all_price);


        // return  $all_price ;


        if ($site_gate_parking->printer->type_connection == "LAN") {
            $connector = new NetworkPrintConnector($site_gate_parking->printer->address);
        } else {
            $connector = new WindowsPrintConnector($site_gate_parking->printer->address);
        }

        $printer = new Printer($connector);

        // Most simple examples
        // $printer->text($date->format('h:i:s')." \n");        

        //Title
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->selectPrintMode(Printer::MODE_FONT_B);
        $printer->setTextSize(2, 2);
        $printer->text('Tiket Parkir' . "\n");
        $printer->selectPrintMode(Printer::MODE_FONT_A);
        $printer->setTextSize(1, 1);
        $printer->feed(3);

        foreach ($site_gate_parking->printer_setting as $item) {

            // if($item->name == "Logo")
            // {
            //     if($item->is_on == 1)
            //     {

            //         //logo
            //         try {
            //             // $img = EscposImage::load("assets/img/bg.jpg", false);
            //             $logo = EscposImage::load("assets/img/bg.jpg");
            //             $printer -> initialize();
            //             $printer -> bitImage($logo);

            //         } catch (Exception $e) {
            //             echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            //         }

            //         //batas garis
            //         if($site_gate_parking->printer->paper_size == "80")
            //         {
            //             $printer->textRaw(str_repeat(chr(196), 48) . PHP_EOL);
            //         }
            //         else  if($site_gate_parking->printer->paper_size == "55")
            //         {
            //             $printer->textRaw(str_repeat(chr(196), 32) . PHP_EOL);
            //         }

            //         $printer->feed(3);
            //     }

            // }

            if ($item->name == "Plat Kendaraan") {
                if ($item->is_on == 1) {
                    //harga
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("Harga : ");
                    if ($transaction->visitor_type == "Voucher" || $transaction->visitor_type == "Member") {
                        $printer->text('-' . "\n");
                    } else {
                        $printer->text($all_price . "\n");
                    }

                    //method payment
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("Metode Pembayaran : ");
                    $printer->text($transaction->payment_type . "\n");

                    //transaction detail
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("Nomor Polisi : ");
                    $printer->text("$transaction->plat_number \n");

                }

            }

            if ($item->name == "Tanggal Masuk") {
                if ($item->is_on == 1) {
                    // transaction detail
                    $printer->text("Tanggal Masuk : ");
                    $printer->text($transaction->created_at . "\n");

                    // transaction detail
                    $printer->text("Tanggal Keluar : ");
                    $printer->text($transaction->date_out . "\n");

                    // transaction duration
                    $date1 = new DateTime($transaction->created_at);
                    $date2 = new DateTime($transaction->date_out);
                    $interval = $date1->diff($date2);

                    $printer->text("Durasi : ");
                    $printer->text($interval->d . ' Hari ' . sprintf("%02d", $interval->h) . ':' . sprintf("%02d", $interval->i) . ':' . sprintf("%02d", $interval->s) . "\n");
                    $printer->feed(3);
                }

            }

            // if ($item->name == "QRCode") {
            //     if ($item->is_on == 1) {
            //         $time = $transaction->created_at;
            //         $datestr = $time->format('ymd');

            //         $weekMap = [
            //             0 => 'SU',
            //             1 => 'MO',
            //             2 => 'TU',
            //             3 => 'WE',
            //             4 => 'TH',
            //             5 => 'FR',
            //             6 => 'SA',
            //         ];
            //         $dayOfTheWeek = Carbon::now()->dayOfWeek;

            //         if ($transaction->number < 10) {
            //             $transactionNumber = '000' . (string) $transaction->number;
            //         } else if ($transaction->number >= 10 && $transaction->number < 100) {
            //             $transactionNumber = '00' . (string) $transaction->number;
            //         } else if ($transaction->number >= 100 && $transaction->number < 1000) {
            //             $transactionNumber = '0' . (string) $transaction->number;
            //         } else if ($transaction->number >= 1000) {
            //             $transactionNumber = (string) $transaction->number;
            //         }

            //         $result_barcode = $datestr . $transactionNumber . $transaction->vehicle->vehicle_initial->id . $dayOfTheWeek;

            //         //qrcode / barcode
            //         $printer->setJustification(Printer::JUSTIFY_CENTER);
            //         $printer->barcode($result_barcode, Printer::BARCODE_UPCA);
            //         // $printer->qrCode($transaction->serial, Printer::QR_ECLEVEL_M, 12, printer::QR_MODEL_2);

            //         //qrcode serial
            //         // $printer->feed(1);
            //         // $printer->setJustification(Printer::JUSTIFY_CENTER);
            //         // $printer->text( $transaction->serial . " \n");
            //         $printer->feed(3);
            //     }

            // }

            if ($item->name == "Alamat") {
                if ($item->is_on == 1) {
                    //address
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->selectPrintMode(Printer::MODE_FONT_A);
                    $printer->text($site_gate_parking->address . "\n");
                    $printer->feed(1);
                }

            }

            if ($item->name == "Catatan") {
                if ($item->is_on == 1) {
                    //batas garis
                    if ($site_gate_parking->printer->paper_size == "80") {
                        $printer->textRaw(str_repeat(chr(196), 48) . PHP_EOL);
                    } else if ($site_gate_parking->printer->paper_size == "55") {
                        $printer->textRaw(str_repeat(chr(196), 32) . PHP_EOL);
                    }

                    //informasi catatan
                    $printer->feed(1);
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->text("Terimakasih Telah Berkunjung \n");
                    $printer->feed(3);
                }

            }

        }

        //printer cut
        $printer->cut();
        $printer->close();


        // return redirect('/gate/scanners/' . $id)->with('status', 'Profile updated!');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return response(null, 404);
    }

    public function GateScannerManualStore(Request $request)
    {

        $validatedData = $request->validate([
            // 'user_id' => 'required|max:255',
            'vehicle_id' => 'required|max:255',
            // 'site_gate_parking_id' => 'required|max:255',
            // 'number' => 'required|max:255',
            'transaction_member_id' => 'required|max:255',
            'transaction_voucher_id' => 'required|max:255',
            'visitor_type' => 'required|max:255',
            'plat_number' => 'required|max:255',
            'in_photo' => 'required|max:255',
            'out_photo' => 'required|max:255',
            'gate_out' => 'required|max:255',
            'status' => 'required|max:255',
        ]);


        $transaction = transaction::where('is_deleted', 0)->get();
        $vehicle = vehicle::where('is_deleted', 0)->where('name', $validatedData['vehicle_id'])->first();
        $site_gate_parking = site_gate_parking::where('id', Auth::user()->site_gate_parking_id)
            ->first();
        $time_now = Carbon::now();
        $validatedData['serial'] = time() . rand(1, 1000);


        if ($site_gate_parking->type == "Keluar") {
            return response([
                "message" => "wrong_gate",
            ]);
        }

        if ($vehicle) {

            $transaction = transaction::create([
                'user_id' => Auth::user()->id,
                'vehicle_id' => $vehicle->id,
                'site_gate_parking_id' => Auth::user()->site_gate_parking_id,
                'serial' => $validatedData['serial'],
                'transaction_member_id' => $validatedData['transaction_member_id'],
                'transaction_voucher_id' => $validatedData['transaction_voucher_id'],
                'number' => count($transaction) + 1,
                'visitor_type' => $validatedData['visitor_type'],
                'status' => $validatedData['status'],
                'gate_out' => $validatedData['gate_out'],
                'payment_method' => '-',
                'payment_type' => '-',
                'date_in' => $time_now,
                'date_out' => $time_now,
                'plat_number' => $validatedData['plat_number'],
                'in_photo' => $validatedData['in_photo'],
                'out_photo' => $validatedData['out_photo'],
                'timeZone' => Auth::user()->timeZone,
            ]);
            return $transaction;

        } else {
            return response([
                "message" => "wrong_vehicle",
            ]);
        }




    }

    public function printParking($transaction_id)
    {

        $transaction = transaction::where('is_deleted', 0)->where('id', $transaction_id)->orderBy('id', "DESC")->first();
        $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', Auth::user()->site_gate_parking_id)->orderBy('id', "DESC")->with('printer')->with('printer_setting')->first();
        $date = Carbon::now();

        if ($site_gate_parking->printer->type_connection == "LAN") {
            $connector = new NetworkPrintConnector($site_gate_parking->printer->address);
        } else {
            $connector = new WindowsPrintConnector($site_gate_parking->printer->address);
        }
        $printer = new Printer($connector);

        // Most simple examples
        // $printer->text($date->format('h:i:s')." \n");       

        //Title
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->selectPrintMode(Printer::MODE_FONT_B);
        $printer->setTextSize(2, 2);
        $printer->text('Tiket Parkir' . "\n");
        $printer->selectPrintMode(Printer::MODE_FONT_A);
        $printer->setTextSize(1, 1);
        $printer->feed(3);

        foreach ($site_gate_parking->printer_setting as $item) {

            // if($item->name == "Logo")
            // {
            //     if($item->is_on == 1)
            //     {
            //         //logo
            //         // $tux = EscposImage::load("assets/img/parking_logo.png", false);
            //         // $printer->bitImage($tux);

            //         //batas garis
            //         if($site_gate_parking->printer->paper_size == "80")
            //         {
            //             $printer->textRaw(str_repeat(chr(196), 48) . PHP_EOL);
            //         }
            //         else  if($site_gate_parking->printer->paper_size == "55")
            //         {
            //             $printer->textRaw(str_repeat(chr(196), 32) . PHP_EOL);
            //         }

            //         $printer->feed(3);
            //     }

            // }


            if ($item->name == "QRCode") {
                if ($item->is_on == 1) {
                    $time = $transaction->created_at;
                    $datestr = $time->format('ymd');

                    $weekMap = [
                        0 => 'SU',
                        1 => 'MO',
                        2 => 'TU',
                        3 => 'WE',
                        4 => 'TH',
                        5 => 'FR',
                        6 => 'SA',
                    ];
                    $dayOfTheWeek = Carbon::now()->dayOfWeek;

                    $num = $transaction->number;
                    $transactionNumber = sprintf("%04d", $num);

                    // $result_barcode = $site_gate_parkingid.$datestr.$timestr.$transaction->number.$rand_number;
                    $result_barcode = $datestr . $transactionNumber . $transaction->vehicle->vehicle_initial->id . $dayOfTheWeek . sprintf("%04d", $site_gate_parking->id);

                    //qrcode / barcode
                    // $printer->setJustification(Printer::JUSTIFY_CENTER);
                    // $printer->barcode($result_barcode, Printer::BARCODE_UPCA);
                    $printer->qrCode($result_barcode, Printer::QR_ECLEVEL_M, 12, printer::QR_MODEL_2);

                    //qrcode serial
                    $printer->feed(1);
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->text($result_barcode . " \n");
                    $printer->feed(3);
                }

            }

            if ($item->name == "Plat Kendaraan") {
                if ($item->is_on == 1) {
                    //transaction detail
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("Nomor Polisi : ");
                    $printer->text("$transaction->plat_number \n");

                }

            }

            if ($item->name == "Tanggal Masuk") {
                if ($item->is_on == 1) {
                    // transaction detail
                    $printer->text("Tanggal Masuk : ");
                    $printer->text($transaction->created_at . "\n");
                    $printer->feed(3);
                }

            }

            if ($item->name == "Alamat") {
                if ($item->is_on == 1) {
                    //address
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->selectPrintMode(Printer::MODE_FONT_A);
                    $printer->text($site_gate_parking->address . "\n");
                    $printer->feed(1);
                }

            }

            if ($item->name == "Catatan") {
                if ($item->is_on == 1) {
                    //batas garis
                    if ($site_gate_parking->printer->paper_size == "80") {
                        $printer->textRaw(str_repeat(chr(196), 48) . PHP_EOL);
                    } else if ($site_gate_parking->printer->paper_size == "55") {
                        $printer->textRaw(str_repeat(chr(196), 32) . PHP_EOL);
                    }

                    //informasi catatan
                    $printer->feed(1);
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->text("JANGAN TINGGALKAN KARCIS TANDA MASUK DAN BARANG BERHARGA DIDALAM KENDARAAN  \n");
                    $printer->feed(3);
                }

            }

        }

        //printer cut
        $printer->cut();
        $printer->close();


        // return redirect('/gate/scanners/' . $id)->with('status', 'Profile updated!');
    }

    public function GateScannerStore(Request $request)
    {

        $validatedData = $request->validate([
            'user_id' => 'required|max:255',
            'vehicle_id' => 'required|max:255',
            'vehicle_initial_id' => 'required|max:255',
            'site_gate_parking_id' => 'required|max:255',
            'number' => 'required|max:255',
            'transaction_member_id' => 'required|max:255',
            'transaction_voucher_id' => 'required|max:255',
            'visitor_type' => 'required|max:255',
            'plat_number' => 'required|max:255',
            'in_photo' => 'required|max:255',
            'out_photo' => 'required|max:255',
            'gate_out' => 'required|max:255',
            'status' => 'required|max:255',
        ]);

        $transaction_member = transaction_member::where('is_deleted', 0)->where('serial', $request->scanner)->first();
        $transaction_voucher = transaction_voucher::where('is_deleted', 0)->where('serial', $request->scanner)->first();
        $site_gate_parking = site_gate_parking::where('id', Auth::user()->site_gate_parking_id)
            ->first();

        date_default_timezone_set(Auth::user()->timeZone);
        $time_now = Carbon::now();

        $time = $time_now;
        $datestr = $time->format('ymd');

        $weekMap = [
            0 => 'SU',
            1 => 'MO',
            2 => 'TU',
            3 => 'WE',
            4 => 'TH',
            5 => 'FR',
            6 => 'SA',
        ];
        $dayOfTheWeek = Carbon::now()->dayOfWeek;


        $num = $validatedData['number'];
        $transactionNumber = sprintf("%04d", $num);

        $result_barcode = $datestr . $transactionNumber . $validatedData['vehicle_initial_id'] . $dayOfTheWeek . sprintf("%04d", $site_gate_parking->id);
        $validatedData['serial'] = $result_barcode;
        $validatedData['visitor_type'] = "Regular";

        //check activation member
        if ($transaction_member) {
            $validatedData['transaction_member_id'] = $transaction_member->id;
            $validatedData['visitor_type'] = "Member";
            $validatedData['transaction_member_id'] = $request->scanner;

            if ($transaction_member) {
                //check activation
                if (
                    date('Y-m-d') >= date('Y-m-d', strtotime($transaction_member->Awal_Aktif)) && date('Y-m-d') <=
                    date('Y-m-d', strtotime($transaction_member->Akhir_Aktif))
                ) {
                } else {
                    return 'Member Expired';
                }
            } else {
                return 'data tidak tersedia';
            }


        }

        //check activation Voucher
        if ($transaction_voucher) {
            $validatedData['transaction_voucher_id'] = $transaction_voucher->id;

            if ($transaction_voucher) {
                //check activation
                if (
                    date('Y-m-d') >= date('Y-m-d', strtotime($transaction_voucher->Awal_Aktif)) && date('Y-m-d') <=
                    date('Y-m-d', strtotime($transaction_voucher->Akhir_Aktif))
                ) {
                } else {
                    return 'Voucher Expired';
                }
            } else {
                return 'data tidak tersedia';
            }

            $validatedData['visitor_type'] = "Voucher";
            $validatedData['transaction_voucher_id'] = $request->scanner;

        }


        if ($site_gate_parking->type == "Keluar") {
            return 'Tidak Bisa Membuat Transaksi Di Pintu Keluar';
        }


        $transaction = transaction::create([
            'user_id' => $validatedData['user_id'],
            'vehicle_id' => $validatedData['vehicle_id'],
            'site_gate_parking_id' => $validatedData['site_gate_parking_id'],
            'serial' => $validatedData['serial'],
            'transaction_member_id' => $validatedData['transaction_member_id'],
            'transaction_voucher_id' => $validatedData['transaction_voucher_id'],
            'number' => $validatedData['number'],
            'visitor_type' => $validatedData['visitor_type'],
            'status' => $validatedData['status'],
            'gate_out' => $validatedData['gate_out'],
            'payment_method' => '-',
            'payment_type' => '-',
            'date_in' => $time_now,
            'date_out' => $time_now,
            'plat_number' => $validatedData['plat_number'],
            'in_photo' => $validatedData['in_photo'],
            'out_photo' => $validatedData['out_photo'],
            'timeZone' => Auth::user()->timeZone,
        ]);

        return $transaction;


    }


    public function payment(Request $request)
    {

        $transaction = transaction::where('is_deleted', 0)
            ->with('site_gate_parking.siteGateParkingPayment.manlessPayment')
            ->where('serial', $request->serial)->first();

        $transaction_member = transaction_member::where('is_deleted', 0)
            ->with('member_plat_number')
            ->where('serial', $request->serial)->first();

        $transaction_voucher = transaction_voucher::where('is_deleted', 0)
            ->with('voucher_plat_number')
            ->where('serial', $request->serial)->first();

        $site_gate_parking = site_gate_parking::where('id', Auth::user()->site_gate_parking_id)
            ->first();

        if ($transaction) {

            //calculate time
            $date1 = new DateTime($transaction->date_in);
            $date2 = new DateTime($transaction->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;

            if ($interval->d < 1 && $interval->h < 1 && $interval->i < (int) $transaction->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->grace_time);
                $price = $grace_time;
            } elseif ($interval->d < 1 && $interval->h < 1 && $interval->i > (int) $transaction->vehicle->grace_time_duration) {
                $time_price_1 = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->time_price_1);
                $price = $time_price_1;
            }

            if ($time_1 == 0) {
                if (60 + $interval->i >= $transaction->vehicle->limitation_time_duration) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->h * 60 + $interval->i >= 60 + $transaction->vehicle->limitation_time_duration) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->h * 60 + $interval->i >= 120 + $transaction->vehicle->limitation_time_duration) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->time_price_3);
                if ($interval->h <= 2) {
                    $price = $price + $time_price_3;
                } else {
                    $price = $price + $time_price_3 * ($interval->h - 1);
                }
            }

            if ($transaction->vehicle->maximum_daily >= 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $transaction->site_gate_parking->vehicle->maximum_daily_price);
                $price = $price + $maximum_daily_price * $interval->d;
            }

            if ($site_gate_parking->type == "Keluar") {

                if ($transaction->status == "-") {
                    // SAMPLE HIT API iPaymu v2 PHP //
                    $va = '0000005889863432'; //get on iPaymu dashboard
                    $apiKey = 'SANDBOX050B6053-FC4A-4F73-BAAA-731FBE2947BF'; //get on iPaymu dashboard

                    $url = 'https://sandbox.ipaymu.com/api/v2/payment/direct'; // for development mode
                    // $url          = 'https://my.ipaymu.com/api/v2/payment'; // for production mode

                    $method = 'POST'; //method

                    //Request Body//
                    $body['name'] = 'buyer';
                    $body['phone'] = '081999501092';
                    $body['email'] = 'buyer@mail.com';
                    $body['amount'] = "$price";
                    $body['notifyUrl'] = 'https://mywebsite.com';
                    $body['expired'] = '24';
                    $body['comments'] = 'Payment to XYZ';
                    $body['referenceId'] = "$request->serial";
                    foreach ($transaction->site_gate_parking->siteGateParkingPayment as $item) {
                        if ($item->manlessPayment->payment_type == $request->payment_type) {

                            transaction::where('id', $transaction->id)->update(
                                [
                                    'payment_type' => $item->manlessPayment->payment_bank,
                                ]
                            );

                            $body['paymentMethod'] = $item->manlessPayment->payment_type;
                            $body['paymentChannel'] = $item->manlessPayment->payment_bank;
                        }
                    }

                    // $body['product']    = array('produk 1');
                    // $body['qty']    = array('1');
                    // $body['price']    = array('10000');
                    // $body['weight']    = array('1', '1');
                    // $body['width']    = array('1', '1');
                    // $body['height']    = array('1', '1');
                    // $body['length']    = array('1', '1');
                    // $body['deliveryArea']    = '76111';
                    // $body['deliveryAddress']    = 'Denpasar';
                    $body['feeDirection'] = 'BUYER';

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


                    $price = 'Rp ' . number_format($price);

                    if ($err) {
                        echo $err;
                    } else {

                        //Response
                        $ret = json_decode($ret);
                        return response([
                            "visitor_type" => 'Regular',
                            "price" => $price,
                            "transaction" => $transaction,
                            'payment' => $ret
                        ]);

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

            }

        } else if ($transaction_member) {


            foreach ($transaction_member->member_plat_number as $item) {

                $transaction = transaction::where('is_deleted', 0)
                    ->with('vehicle.vehicle_initial')
                    ->with('site_gate_parking')
                    ->where('plat_number', $item->plat_number)
                    ->where('status', '-')
                    ->first();

                if ($site_gate_parking->type == "Keluar" && $transaction) {

                    if ($transaction->status == '-') {
                        // date_default_timezone_set(Auth::user()->timeZone);
                        date_default_timezone_set($transaction->timeZone);
                        $time_now = Carbon::now();

                        transaction::where('serial', $transaction->serial)->update(
                            [
                                'status' => $request->status,
                                'gate_out' => $transaction->site_gate_parking->name,
                                'date_out' => $time_now,
                                'payment_method' => $transaction->site_gate_parking->type_payment,
                                'payment_type' => $request->payment_type,
                            ]
                        );

                        return response([
                            "status" => "success",
                            "visitor_type" => 'Member',
                            "transaction" => $transaction,
                        ]);
                    }

                }

            }

            if ($site_gate_parking->type == "Keluar") {
                return response([
                    "status" => "error",
                    "visitor_type" => 'Member',
                    "transaction" => $transaction,
                ]);
            }

        } else if ($transaction_voucher) {

            foreach ($transaction_voucher->voucher_plat_number as $item) {

                $transaction = transaction::where('is_deleted', 0)
                    ->with('vehicle.vehicle_initial')
                    ->with('site_gate_parking')
                    ->where('plat_number', $item->plat_number)
                    ->where('status', '-')
                    ->first();

                if ($site_gate_parking->type == "Keluar" && $transaction) {

                    if ($transaction->status == '-') {
                        // date_default_timezone_set(Auth::user()->timeZone);
                        date_default_timezone_set($transaction->timeZone);
                        $time_now = Carbon::now();

                        transaction::where('serial', $transaction->serial)->update(
                            [
                                'status' => $request->status,
                                'gate_out' => $transaction->site_gate_parking->name,
                                'date_out' => $time_now,
                                'payment_method' => $transaction->site_gate_parking->type_payment,
                                'payment_type' => $request->payment_type,
                            ]
                        );

                        return response([
                            "status" => "success",
                            "visitor_type" => 'Voucher',
                            "transaction" => $transaction,
                        ]);
                    }

                }

            }

            if ($site_gate_parking->type == "Keluar") {
                return response([
                    "status" => "error",
                    "visitor_type" => 'Voucher',
                    "transaction" => $transaction,
                ]);
            }


        }

    }


    public function transactionPlatNumberDetail($plat_number)
    {

        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $site_gate_parking = site_gate_parking::where('id', Auth::user()->site_gate_parking_id)
            ->first();
        $transaction = transaction::where('is_deleted', 0)
            ->with('vehicle.vehicle_initial')
            ->with('site_gate_parking')
            ->where('plat_number', $plat_number)
            ->where('plat_number', '!=', '-')
            ->where('status', '-')
            ->orWhere('serial', $plat_number)
            ->where('status', '-')
            ->first();


        if ($site_gate_parking->type == "Keluar") {

            if ($transaction) {

                if ($transaction->status == '-') {

                    return response([
                        'message' => 'success',
                        'transaction' => $transaction,
                        'punishment' => $punishment,
                    ]);
                }

            }
        }


    }

    public function transactionPlatNumberSubscriberDetail($plat_number)
    {

        $transaction_member = transaction_member::where('is_deleted', 0)
            ->with('member_plat_number')
            ->where('serial', $plat_number)->first();




        $transaction_voucher = transaction_voucher::where('is_deleted', 0)
            ->with('voucher_plat_number')
            ->where('serial', $plat_number)->first();

        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $site_gate_parking = site_gate_parking::where('id', Auth::user()->site_gate_parking_id)
            ->first();


        if ($transaction_member) {

            foreach ($transaction_member->member_plat_number as $item) {

                $transaction = transaction::where('is_deleted', 0)
                    ->with('vehicle.vehicle_initial')
                    ->with('site_gate_parking')
                    ->where('plat_number', $item->plat_number)
                    ->where('status', '-')
                    ->first();

                if ($site_gate_parking->type == "Keluar" && $transaction) {
                    if ($transaction->status == '-') {
                        return response([
                            'message' => 'success',
                            'visitor_type' => 'Member',
                            'transaction' => $transaction,
                            'punishment' => $punishment,
                            'plat_number_list' => $transaction_member,
                        ]);
                    }
                } else {
                    return response([
                        'message' => 'error',
                        'visitor_type' => 'Member',
                        'transaction' => $transaction,
                        'punishment' => $punishment,
                        'plat_number_list' => $transaction_member,
                    ]);
                }

            }

            if ($site_gate_parking->type == "Keluar" && $transaction) {

                return response([
                    'message' => 'error',
                    'visitor_type' => 'Member',
                    'transaction' => $transaction,
                    'punishment' => $punishment,
                    'plat_number_list' => $transaction_member,
                ]);
            }
        } else if ($transaction_voucher) {
            foreach ($transaction_voucher->voucher_plat_number as $item) {

                $transaction = transaction::where('is_deleted', 0)
                    ->with('vehicle.vehicle_initial')
                    ->with('site_gate_parking')
                    ->where('plat_number', $item->plat_number)
                    ->where('status', '-')
                    ->first();

                if ($site_gate_parking->type == "Keluar" && $transaction) {
                    if ($transaction->status == '-') {
                        return response([
                            'message' => 'success',
                            'visitor_type' => 'Voucher',
                            'transaction' => $transaction,
                            'punishment' => $punishment,
                            'plat_number_list' => $transaction_voucher,
                        ]);
                    }

                }

            }

            if ($site_gate_parking->type == "Keluar") {
                return response([
                    'message' => 'error',
                    'visitor_type' => 'Voucher',
                    'transaction' => $transaction,
                    'punishment' => $punishment,
                    'plat_number_list' => $transaction_voucher,
                ]);
            } else {
                return response([
                    'message' => 'error',
                    'visitor_type' => 'Member',
                    'transaction' => $transaction,
                    'punishment' => $punishment,
                    'plat_number_list' => $transaction_voucher,
                ]);
            }
        }

    }




}
