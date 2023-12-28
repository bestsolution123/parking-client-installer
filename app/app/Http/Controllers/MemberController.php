<?php

namespace App\Http\Controllers;

use App\Models\member;
use App\Models\transaction_member;
use App\Models\transaction_voucher;
use App\Models\vehicle;
use App\Models\vehicle_initial;
use App\Models\voucher;
use Illuminate\Http\Request;

class MemberController extends Controller
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
            $member = member::where('is_deleted', 0)->orderBy('id', "DESC")->with('vehicle')->get();
        } else {
            $member = member::where('is_deleted', 0)->with('vehicle')->where('user_id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        return view('content.new.member.index', [
            'member' => $member
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

        return view('content.new.member.create', [
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
            'Max_Kendaraan' => 'required|max:255',
            'Tarif' => 'required|max:255',
            'Biaya_Kartu' => 'required|max:255',
            'Biaya_Ganti_Plat_Number' => 'required|max:255',
            'Status' => 'required|max:255',
        ]);

        $MemberController = member::create([
            'Nama' => $validatedData['Nama'],
            'Periode' => $validatedData['Periode'],
            'vehicle_id' => $validatedData['vehicle_id'],
            'Max_Kendaraan' => $validatedData['Max_Kendaraan'],
            'Tarif' => $validatedData['Tarif'],
            'Biaya_Kartu' => $validatedData['Biaya_Kartu'],
            'Biaya_Ganti_Plat_Number' => $validatedData['Biaya_Ganti_Plat_Number'],
            'Status' => $validatedData['Status'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect('dashboard/member')->with('success', 'data berhasil di tambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(member $member)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicle = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        $member = member::where('is_deleted', 0)->where('id', decrypt($id))->orderBy('id', "DESC")->first();
        return view('content.new.member.edit', [
            'member' => $member,
            "vehicle" => $vehicle
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'Nama' => 'required|max:255',
            'Periode' => 'required|max:255',
            'vehicle_id' => 'required|max:255',
            'Max_Kendaraan' => 'required|max:255',
            'Tarif' => 'required|max:255',
            'Biaya_Kartu' => 'required|max:255',
            'Biaya_Ganti_Plat_Number' => 'required|max:255',
            // 'Status' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        member::where('id', decrypt($id))->update(
            [
                'Nama' => $validatedData['Nama'],
                'Periode' => $validatedData['Periode'],
                'vehicle_id' => $validatedData['vehicle_id'],
                'Max_Kendaraan' => $validatedData['Max_Kendaraan'],
                'Tarif' => $validatedData['Tarif'],
                'Biaya_Kartu' => $validatedData['Biaya_Kartu'],
                'Biaya_Ganti_Plat_Number' => $validatedData['Biaya_Ganti_Plat_Number'],
                // 'Status' => $validatedData['Status'],
            ]

        );

        return redirect('dashboard/member')->with('success', 'data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = member::where('id', decrypt($id))->first();
        $member->delete();

        return decrypt($id);
    }

    public function changeStatus($id)
    {
        $member = member::where('id', decrypt($id))->first();
        member::where('id', decrypt($id))->update(
            [
                'Status' => $member->Status == 0 ? true : false,
            ]
        );

        return decrypt($id);
    }

    public function memberId($id)
    {
        $member = member::where('is_deleted', 0)->where('id', $id)->with('vehicle')->first();
        return response([
            'member' => $member
        ]);
    }

    public function voicherId($id)
    {
        $voucher = voucher::where('is_deleted', 0)->where('id', $id)->first();
        return response([
            'voucher' => $voucher
        ]);
    }


}
