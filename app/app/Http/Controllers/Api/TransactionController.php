<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\site_gate_parking;
use App\Models\transaction;
use App\Models\transaction_member;
use App\Models\transaction_voucher;
use App\Models\vehicle;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('is_deleted', 0)->where('user_id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        return view('content.new.transaction.index', [
            'transaction' => $transaction
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'plat_number' => 'required|max:255',
        ]);

        $validatedData['serial'] = time() . rand(1, 1000);

        $transaction = transaction::create([
            'name' => $validatedData['name'],
            'serial' => $validatedData['serial'],
            'plat_number' => $validatedData['plat_number'],
        ]);

        return redirect('dashboard/siteGateParking')->with('success', 'data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(transaction $transaction)
    {
        //
    }


    public function reportIndex()
    {
        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('is_deleted', 0)->orderBy('id', "DESC")->filter(request(['calendar', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->filter(request(['calendar', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        return view('content.new.report.index', [
            'transaction' => $transaction,
            'site_gate_parking' => $site_gate_parking
        ]);
    }

    public function getTransactionLatest()
    {
        $transaction = transaction::where('is_deleted', 0)->get();
        return $transaction;
    }

    public function getTransactionVoucherLatest()
    {
        $transaction_voucher = transaction_voucher::where('is_deleted', 0)->get();
        return $transaction_voucher;
    }

    public function getAllVechile()
    {
        $vehicle = vehicle::where('is_deleted', 0)->get();
        return $vehicle;
    }

    public function getTransactionMemberLatest()
    {
        $transaction_member = transaction_member::where('is_deleted', 0)->get();
        return $transaction_member;
    }

}
