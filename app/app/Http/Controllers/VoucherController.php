<?php

namespace App\Http\Controllers;

use App\Models\vehicle;
use App\Models\vehicle_initial;
use App\Models\voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
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
            $voucher = voucher::where('is_deleted', 0)->orderBy('id', "DESC")->with('vehicle')->get();
        } else {
            $voucher = voucher::where('is_deleted', 0)->with('vehicle')->where('user_id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        return view('content.new.voucher.index', [
            'voucher' => $voucher
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicle = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        return view('content.new.voucher.create', [
            "vehicle" => $vehicle
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
            'Nama' => 'required|max:255',
            'Periode' => 'required|max:255',
            'vehicle_id' => 'required|max:255',
            'Tarif' => 'required|max:255',
            'Model_Pembayaran' => 'required|max:255',
            'Metode_Verifikasi' => 'required|max:255',
            'Status' => 'required|max:255',
        ]);

        $voucher = voucher::create([
            'Nama' => $validatedData['Nama'],
            'Periode' => $validatedData['Periode'],
            'vehicle_id' => $validatedData['vehicle_id'],
            'Tarif' => $validatedData['Tarif'],
            'Model_Pembayaran' => $validatedData['Model_Pembayaran'],
            'Metode_Verifikasi' => $validatedData['Metode_Verifikasi'],
            'Status' => $validatedData['Status'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect('dashboard/voucher')->with('success', 'data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicle = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $voucher = voucher::where('is_deleted', 0)->where('id', decrypt($id))->orderBy('id', "DESC")->first();
        return view('content.new.voucher.edit', [
            'voucher' => $voucher,
            "vehicle" => $vehicle

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'Nama' => 'required|max:255',
            'Periode' => 'required|max:255',
            'vehicle_id' => 'required|max:255',
            'Tarif' => 'required|max:255',
            'Model_Pembayaran' => 'required|max:255',
            'Metode_Verifikasi' => 'required|max:255',
            // 'Status' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        voucher::where('id', decrypt($id))->update(
            [
                'Nama' => $validatedData["Nama"],
                'Periode' => $validatedData["Periode"],
                'vehicle_id' => $validatedData["vehicle_id"],
                'Tarif' => $validatedData["Tarif"],
                'Model_Pembayaran' => $validatedData["Model_Pembayaran"],
                'Metode_Verifikasi' => $validatedData["Metode_Verifikasi"],
                // 'Status' => $validatedData["Status"],
            ]

        );

        return redirect('dashboard/voucher')->with('success', 'data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $voucher = voucher::where('id', decrypt($id))->first();
        $voucher->delete();

        return decrypt($id);
    }

    public function changeStatus($id)
    {
        $voucher = voucher::where('id', decrypt($id))->first();
        voucher::where('id', decrypt($id))->update(
            [
                'Status' => $voucher->Status == 0 ? true : false,
            ]
        );

        return decrypt($id);
    }
}
