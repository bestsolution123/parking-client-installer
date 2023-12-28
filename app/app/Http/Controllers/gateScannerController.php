<?php

namespace App\Http\Controllers;

use App\Models\site_gate_parking;
use App\Models\transaction;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Carbon\Carbon;
use Exception;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\ImagickEscposImage;

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

    public function GateScannerStore(Request $request)
    {

        $validatedData = $request->validate([
            'user_id' => 'required|max:255',
            'gate_name' => 'required|max:255',
            'number' => 'required|max:255',
            'plat_number' => 'required|max:255',
        ]);

        $validatedData['serial'] = time() . rand(1, 1000);

        $transaction = transaction::create([
            'user_id' => decrypt($validatedData['user_id']),
            'serial' => $validatedData['serial'],
            'gate_name' => decrypt($validatedData['gate_name']),
            'number' => $validatedData['number'],
            'plat_number' => $validatedData['plat_number'],
        ]);

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

    public function printParking($gate_id, $transaction_id)
    {

        // $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id',decrypt($gate_id))->orderBy('id', "DESC")->with('printer')->first();
        $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', $gate_id)->orderBy('id', "DESC")->with('printer')->first();
        $transaction = transaction::where('is_deleted', 0)->where('id', $transaction_id)->orderBy('id', "DESC")->first();
        // return $site_gate_parking;
        $date = Carbon::now();


        if ($site_gate_parking->printer->type_connection == "LAN") {
            $connector = new NetworkPrintConnector($site_gate_parking->printer->address);
        } else {
            $connector = new WindowsPrintConnector($site_gate_parking->printer->address);
        }

        $printer = new Printer($connector);
        // $printer->setJustification(Printer::JUSTIFY_LEFT);

        // if($site_gate_parking->printer->paper_size == "80")
        // {
        //     $printer->text($date->format('Y-m-d')."                             ");
        // }
        // else  if($site_gate_parking->printer->paper_size == "55")
        // {
        //     $printer->text($date->format('Y-m-d')."                 ");
        // }

        // Most simple examples
        // $printer->text($date->format('h:i:s')." \n");

        //image
        // $tux = EscposImage::load("assets/img/parking_logo.png", false);
        // $printer->bitImage($tux);

        //batas garis
        if ($site_gate_parking->printer->paper_size == "80") {
            $printer->textRaw(str_repeat(chr(196), 48) . PHP_EOL);
        } else if ($site_gate_parking->printer->paper_size == "55") {
            $printer->textRaw(str_repeat(chr(196), 32) . PHP_EOL);
        }


        //qrcode
        $printer->feed(3);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->qrCode($transaction->serial, Printer::QR_ECLEVEL_M, 12, printer::QR_MODEL_2);

        //qrcode serial
        $printer->feed(1);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text($transaction->serial . " \n");
        $printer->feed(3);

        //transacction detail
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Plat Kendaraan : ");
        $printer->text("5 ABC 321 \n");
        $printer->text("Tanggal Masuk : ");
        $printer->text($transaction->created_at . "\n");

        //address
        $printer->feed(3);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->selectPrintMode(Printer::MODE_FONT_A);
        $printer->text($site_gate_parking->address . "\n");
        $printer->feed(1);


        //batas garis
        if ($site_gate_parking->printer->paper_size == "80") {
            $printer->textRaw(str_repeat(chr(196), 48) . PHP_EOL);
        } else if ($site_gate_parking->printer->paper_size == "55") {
            $printer->textRaw(str_repeat(chr(196), 32) . PHP_EOL);
        }

        //informasi catatan
        $printer->feed(1);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Jangan Meninggalkan Tiket & Barang Berharga Di  Dalam Kendaraan Anda \n");

        $printer->feed(3);
        //printer cut
        $printer->cut();
        $printer->close();


        // return redirect('/gate/scanners/' . $id)->with('status', 'Profile updated!');
    }

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


}
