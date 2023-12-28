<?php

namespace App\Http\Controllers;

use App\Models\transaction_voucher;
use App\Models\transactionVoucherLog;
use App\Models\voucher;
use App\Models\voucher_plat_number;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionVoucherController extends Controller
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
        if (auth()->user()->role == 'admin') {
            $transaction_voucher = transaction_voucher::where('is_deleted', 0)->with('voucher.vehicle')->orderBy('id', "DESC")->get();
        } else {
            $transaction_voucher = transaction_voucher::where('is_deleted', 0)->with('voucher.vehicle')->where('user_id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        //check activation
        foreach ($transaction_voucher as $item) {
            // return date('Y-m-d',strtotime( $item->Awal_Aktif));
            // return date('Y-m-d');

            if (
                date('Y-m-d') >= date('Y-m-d', strtotime($item->Awal_Aktif)) && date('Y-m-d') <=
                date('Y-m-d', strtotime($item->Akhir_Aktif))
            ) {
                $validatedData['Status'] = true;
            } else {
                $validatedData['Status'] = false;
            }

            transaction_voucher::where('id', $item->id)->update(
                [
                    'Status' => $validatedData['Status'],
                ]
            );

            //re call script view
            if (auth()->user()->role == 'admin') {
                $transaction_voucher = transaction_voucher::where('is_deleted', 0)->with('voucher.vehicle')->orderBy('id', "DESC")->get();
            } else {
                $transaction_voucher = transaction_voucher::where('is_deleted', 0)->with('voucher.vehicle')->where('user_id', auth()->user()->id)->orderBy('id', "DESC")->get();
            }

        }

        //    return  $transaction_voucher ;

        return view('content.new.voucher_list.index', [
            'transaction_voucher' => $transaction_voucher
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $voucher = voucher::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        return view('content.new.voucher_list.create', [
            "voucher" => $voucher
        ]);
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
            'voucher_id' => 'required|max:255',
            'Produk' => 'required|max:255',
            'Awal_Aktif' => 'required|max:255',
            'Akhir_Aktif' => 'required|max:255',
            'Keterangan' => 'required|max:255',
            'Tarif_Dasar_Voucher' => 'required|max:255',
            'Tarif' => 'required|max:255',
            'Total_Biaya' => 'required|max:255',
        ]);

        $validatedData['serial'] = time() . rand(1, 1000);

        $date = Carbon::now();
        $Awal_Aktif = Carbon::createFromFormat('Y-m-d', $validatedData['Awal_Aktif'])->toDateString();

        if ($Awal_Aktif == $date->toDateString()) {
            $validatedData['Status'] = true;
        } else {
            $validatedData['Status'] = false;
        }

        $voucher = transaction_voucher::create([
            'serial' => $validatedData['serial'],
            'user_id' => auth()->user()->id,
            'voucher_id' => $validatedData['voucher_id'],
            'Produk' => $validatedData['Produk'],
            'Awal_Aktif' => $validatedData['Awal_Aktif'],
            'Akhir_Aktif' => $validatedData['Akhir_Aktif'],
            'Keterangan' => $validatedData['Keterangan'],
            'Tarif_Dasar_Voucher' => $validatedData['Tarif_Dasar_Voucher'],
            'Tarif' => $validatedData['Tarif'],
            'Status' => $validatedData['Status'],
            'Total_Biaya' => $validatedData['Total_Biaya'],
        ]);


        $transactionVoucherLog = transactionVoucherLog::create([
            'serial' => $validatedData['serial'],
            'user_id' => auth()->user()->id,
            'Produk' => $validatedData['Produk'],
            'Awal_Aktif' => $validatedData['Awal_Aktif'],
            'Akhir_Aktif' => $validatedData['Akhir_Aktif'],
            'Keterangan' => $validatedData['Keterangan'],
            'Tarif_Dasar_Voucher' => $validatedData['Tarif_Dasar_Voucher'],
            'Tarif' => $validatedData['Tarif'],
            'Status' => $validatedData['Status'],
            'Total_Biaya' => $validatedData['Total_Biaya'],
        ]);

        foreach ($request->Plat_Number as $item) {
            voucher_plat_number::create([
                'transaction_voucher_id' => $voucher->id,
                'plat_number' => strtolower(str_replace(' ', '', $item)),
            ]);
        }

        return redirect('dashboard/voucher/list')->with('success', 'data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\transaction_voucher  $transaction_voucher
     * @return \Illuminate\Http\Response
     */
    public function show(transaction_voucher $transaction_voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\transaction_voucher  $transaction_voucher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaction_voucher = transaction_voucher::where('is_deleted', 0)->where('id', decrypt($id))->with('voucher_plat_number')->orderBy('id', "DESC")->first();
        $voucher = voucher::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        return view('content.new.voucher_list.edit', [
            'voucher' => $voucher,
            "transaction_voucher" => $transaction_voucher
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\transaction_voucher  $transaction_voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'voucher_id' => 'required|max:255',
            'Produk' => 'required|max:255',
            // 'Awal_Aktif' => 'required|max:255',
            // 'Akhir_Aktif' => 'required|max:255',
            'Keterangan' => 'required|max:255',
            'Tarif_Dasar_Voucher' => 'required|max:255',
            'Tarif' => 'required|max:255',
            'Total_Biaya' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        $date = Carbon::now();
        // $Awal_Aktif =  Carbon::createFromFormat('Y-m-d', $validatedData['Awal_Aktif'])->toDateString();

        // if($Awal_Aktif == $date->toDateString())
        // {
        //     $validatedData['Status'] = true;
        // }
        // else
        // {
        //     $validatedData['Status'] = false;
        // }

        transaction_voucher::where('id', decrypt($id))->update(
            [
                'voucher_id' => $validatedData["voucher_id"],
                'Produk' => $validatedData["Produk"],
                // 'Awal_Aktif' => $validatedData["Awal_Aktif"],
                // 'Akhir_Aktif' => $validatedData["Akhir_Aktif"],
                'Keterangan' => $validatedData["Keterangan"],
                'Tarif_Dasar_Voucher' => $validatedData['Tarif_Dasar_Voucher'],
                'Tarif' => $validatedData['Tarif'],
                'Total_Biaya' => $validatedData['Total_Biaya'],
            ]

        );

        // transaction voucher
        $transaction_voucher = transaction_voucher::where('is_deleted', 0)->where('id', decrypt($id))->with('voucher_plat_number')->orderBy('id', "DESC")->first();

        if (count($request->Plat_Number) != count($transaction_voucher->voucher_plat_number)) {
            foreach ($transaction_voucher->voucher_plat_number as $item) {
                $voucher_plat_number = voucher_plat_number::where('is_deleted', 0)->where('id', $item->id)->first();
                $voucher_plat_number->delete();
            }
        }

        for ($i = 0; $i < count($request->Plat_Number); $i++) {
            if (count($request->Plat_Number) == count($transaction_voucher->voucher_plat_number)) {
                voucher_plat_number::where('id', decrypt($request->id_Plat_Number[$i]))->update([
                    'plat_number' => str_replace(' ', '', strtolower($request->Plat_Number[$i])),
                ]);
            } else {
                voucher_plat_number::create([
                    'transaction_voucher_id' => decrypt($id),
                    'plat_number' => str_replace(' ', '', strtolower($request->Plat_Number[$i])),
                ]);
            }
        }

        return redirect('dashboard/voucher/list')->with('success', 'data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transaction_voucher  $transaction_voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction_voucher = transaction_voucher::where('id', decrypt($id))->first();
        $transaction_voucher->delete();

        return decrypt($id);
    }

    public function changeStatus($id)
    {
        $transaction_voucher = transaction_voucher::where('id', decrypt($id))->first();
        transaction_voucher::where('id', decrypt($id))->update(
            [
                'Status' => $transaction_voucher->Status == 0 ? true : false,
            ]
        );

        return decrypt($id);
    }

    public function transactionVoucherId($id)
    {
        $transaction_voucher = transaction_voucher::where('is_deleted', 0)->where('id', decrypt($id))->first();
        return response([
            'transaction_voucher' => $transaction_voucher
        ]);
    }

    public function transactionVoucherExtendVoucher(Request $request, $id)
    {

        $transaction_voucher = transaction_voucher::where('id', decrypt($id))->update(
            [
                'Akhir_Aktif' => $request->voucher_data_extend,
            ]
        );

        $transaction_voucher = transaction_voucher::where('is_deleted', 0)->where('id', decrypt($id))->first();

        $transactionVoucherLog = transactionVoucherLog::create([
            'serial' => $transaction_voucher->serial,
            'user_id' => $transaction_voucher->user_id,
            'Produk' => $transaction_voucher->Produk,
            'Awal_Aktif' => $transaction_voucher->Awal_Aktif,
            'Akhir_Aktif' => $transaction_voucher->Akhir_Aktif,
            'Keterangan' => $transaction_voucher->Keterangan,
            'Tarif_Dasar_Voucher' => $transaction_voucher->Tarif_Dasar_Voucher,
            'Tarif' => $transaction_voucher->Tarif,
            'Status' => $transaction_voucher->Status,
            'Total_Biaya' => $request->voucher_data_tarif,
        ]);

        return $transaction_voucher;
    }
}
