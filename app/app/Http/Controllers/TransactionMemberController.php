<?php

namespace App\Http\Controllers;

use App\Models\member;
use App\Models\member_plat_number;
use App\Models\transaction_member;
use App\Models\transactionMemberLog;
use App\Models\voucher_plat_number;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Date;

class TransactionMemberController extends Controller
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
            $transaction_member = transaction_member::where('is_deleted', 0)->orderBy('id', "DESC")->with('member.vehicle')->get();
        } else {
            $transaction_member = transaction_member::where('is_deleted', 0)->with('member.vehicle')->where('user_id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }


        //check activation
        foreach ($transaction_member as $item) {
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

            transaction_member::where('id', $item->id)->update(
                [
                    'Status' => $validatedData['Status'],
                ]
            );

            //re call script view
            if (auth()->user()->role == 'admin') {
                $transaction_member = transaction_member::where('is_deleted', 0)->orderBy('id', "DESC")->with('member.vehicle')->get();
            } else {
                $transaction_member = transaction_member::where('is_deleted', 0)->with('member.vehicle')->where('user_id', auth()->user()->id)->orderBy('id', "DESC")->get();
            }
        }



        //    return $transaction_member;

        return view('content.new.member_list.index', [
            'transaction_member' => $transaction_member
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $member = member::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        return view('content.new.member_list.create', [
            "member" => $member
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
            'member_id' => 'required|max:255',
            'Nama' => 'required|max:255',
            'Akses' => 'required|max:255',
            'Hp' => 'required|max:255',
            'Email' => 'required|max:255',
            'Awal_Aktif' => 'required|max:255',
            'Akhir_Aktif' => 'required|max:255',
            'Plat_Number' => 'required|max:255',
            'Tarif_Member' => 'required|max:255',
            'Tarif_Kartu' => 'required|max:255',
            'Total_Biaya' => 'required|max:255',
            'Tarif_Dasar_Member' => 'required|max:255',
        ]);

        $validatedData['serial'] = time() . rand(1, 1000);


        $date = Carbon::now();
        $Awal_Aktif = Carbon::createFromFormat('Y-m-d', $validatedData['Awal_Aktif'])->toDateString();


        if ($Awal_Aktif == $date->toDateString()) {
            $validatedData['Status'] = true;
        } else {
            $validatedData['Status'] = false;
        }


        $transaction_member = transaction_member::create([
            'member_id' => $validatedData['member_id'],
            'Nama' => $validatedData['Nama'],
            'Akses' => $validatedData['Akses'],
            'Hp' => $validatedData['Hp'],
            'Email' => $validatedData['Email'],
            'Awal_Aktif' => $validatedData['Awal_Aktif'],
            'Akhir_Aktif' => $validatedData['Akhir_Aktif'],
            'Plat_Number' => str_replace(' ', '', strtolower($validatedData['Plat_Number'])),
            'Tarif_Member' => $validatedData['Tarif_Member'],
            'Tarif_Kartu' => $validatedData['Tarif_Kartu'],
            'Total_Biaya' => $validatedData['Total_Biaya'],
            'Status' => $validatedData['Status'],
            'Tarif_Dasar_Member' => $validatedData['Tarif_Dasar_Member'],
            'serial' => $validatedData['serial'],
            'user_id' => auth()->user()->id,
        ]);

        $transactionMemberLog = transactionMemberLog::create([
            'Nama' => $validatedData['Nama'],
            'Akses' => $validatedData['Akses'],
            'Hp' => $validatedData['Hp'],
            'Email' => $validatedData['Email'],
            'Awal_Aktif' => $validatedData['Awal_Aktif'],
            'Akhir_Aktif' => $validatedData['Akhir_Aktif'],
            'Plat_Number' => str_replace(' ', '', strtolower($validatedData['Plat_Number'])),
            'Tarif_Member' => $validatedData['Tarif_Member'],
            'Tarif_Kartu' => $validatedData['Tarif_Kartu'],
            'Total_Biaya' => $validatedData['Total_Biaya'],
            'Status' => $validatedData['Status'],
            'Tarif_Dasar_Member' => $validatedData['Tarif_Dasar_Member'],
            'serial' => $validatedData['serial'],
            'user_id' => auth()->user()->id,
        ]);

        foreach ($request->Plat_Number as $item) {
            member_plat_number::create([
                'transaction_member_id' => $transaction_member->id,
                'plat_number' => $item,
            ]);
        }

        return redirect('dashboard/member/list')->with('success', 'data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\transaction_member  $transaction_member
     * @return \Illuminate\Http\Response
     */
    public function show(transaction_member $transaction_member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\transaction_member  $transaction_member
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = member::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $transaction_member = transaction_member::where('is_deleted', 0)->where('id', decrypt($id))->with('member_plat_number')->orderBy('id', "DESC")->first();

        return view('content.new.member_list.edit', [
            'transaction_member' => $transaction_member,
            "member" => $member

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\transaction_member  $transaction_member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'member_id' => 'required|max:255',
            'Nama' => 'required|max:255',
            'Akses' => 'required|max:255',
            'Hp' => 'required|max:255',
            'Email' => 'required|max:255',
            // 'Awal_Aktif' => 'required|max:255',
            // 'Akhir_Aktif' => 'required|max:255',
            'Plat_Number' => 'required|max:255',
            'Tarif_Dasar_Member' => 'required|max:255',
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

        transaction_member::where('id', decrypt($id))->update(
            [
                'member_id' => $validatedData['member_id'],
                'Nama' => $validatedData['Nama'],
                'Akses' => $validatedData['Akses'],
                'Hp' => $validatedData['Hp'],
                'Email' => $validatedData['Email'],
                // 'Status' => $validatedData['Status'],
                // 'Awal_Aktif' => $validatedData['Awal_Aktif'],
                // 'Akhir_Aktif' => $validatedData['Akhir_Aktif'],
                'Tarif_Dasar_Member' => $validatedData['Tarif_Dasar_Member'],
            ]
        );


        // transaction member
        $transaction_member = transaction_member::where('is_deleted', 0)->where('id', decrypt($id))->with('member_plat_number')->orderBy('id', "DESC")->first();

        if (count($request->Plat_Number) != count($transaction_member->member_plat_number)) {
            foreach ($transaction_member->member_plat_number as $item) {
                $member_plat_number = member_plat_number::where('is_deleted', 0)->where('id', $item->id)->first();
                $member_plat_number->delete();
            }
        }

        for ($i = 0; $i < count($request->Plat_Number); $i++) {
            if (count($request->Plat_Number) == count($transaction_member->member_plat_number)) {
                member_plat_number::where('id', decrypt($request->id_Plat_Number[$i]))->update([
                    'plat_number' => str_replace(' ', '', strtolower($request->Plat_Number[$i])),
                ]);
            } else {
                member_plat_number::create([
                    'transaction_member_id' => decrypt($id),
                    'plat_number' => str_replace(' ', '', strtolower($request->Plat_Number[$i])),
                ]);
            }
        }

        return redirect('dashboard/member/list')->with('success', 'data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transaction_member  $transaction_member
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction_member = transaction_member::where('id', decrypt($id))->first();
        $transaction_member->delete();

        return decrypt($id);
    }

    public function changeStatus($id)
    {
        $transaction_member = transaction_member::where('id', decrypt($id))->first();
        transaction_member::where('id', decrypt($id))->update(
            [
                'Status' => $transaction_member->Status == 0 ? true : false,
            ]
        );

        return decrypt($id);
    }

    public function transactionMemberId($id)
    {
        $transaction_member = transaction_member::where('is_deleted', 0)->where('id', decrypt($id))->first();
        return response([
            'transaction_member' => $transaction_member
        ]);
    }

    public function transactionMemberExtendMember(Request $request, $id)
    {


        transaction_member::where('id', decrypt($id))->update(
            [
                'Akhir_Aktif' => $request->member_data_extend,
            ]
        );

        $transaction_member = transaction_member::where('is_deleted', 0)->where('id', decrypt($id))->first();

        $transactionMemberLog = transactionMemberLog::create([
            'Nama' => $transaction_member->Nama,
            'Akses' => $transaction_member->Akses,
            'Hp' => $transaction_member->Hp,
            'Email' => $transaction_member->Email,
            'Awal_Aktif' => $transaction_member->Awal_Aktif,
            'Akhir_Aktif' => $transaction_member->Akhir_Aktif,
            'Plat_Number' => $transaction_member->Plat_Number,
            'Tarif_Member' => $transaction_member->Tarif_Member,
            'Tarif_Kartu' => $transaction_member->Tarif_Kartu,
            'Total_Biaya' => $request->member_data_tarif,
            'Status' => $transaction_member->Status,
            'Tarif_Dasar_Member' => $transaction_member->Tarif_Dasar_Member,
            'serial' => $transaction_member->serial,
            'user_id' => $transaction_member->user_id,
        ]);

        return $transaction_member;
    }
}
