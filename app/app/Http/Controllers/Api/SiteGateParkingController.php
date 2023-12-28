<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\printer;
use App\Models\site_gate_parking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteGateParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  public function __construct()
    //  {
    //      $this->middleware('auth:sanctum');  
    //  }

    //    public function index()
//    {
//         $site_gate_parking = site_gate_parking::where('is_deleted', 0)
//         ->where('id',  Auth::user()->site_gate_parking_id)
//         ->orderBy('id', "DESC")
//         ->with('printer')
//         ->first();
//         return $site_gate_parking;
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $printer = printer::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        return view('content.new.site_gate_parking.create', [
            'printer' => $printer
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
            'name' => 'required|max:255',
            'printer_id' => 'required|max:255',
            'address' => 'required|max:255',
        ]);

        $site_gate_parking = site_gate_parking::create([
            'name' => $validatedData['name'],
            'printer_id' => $validatedData['printer_id'],
            'address' => $validatedData['address'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect('dashboard/siteGateParking')->with('success', 'data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\site_gate_parking  $site_gate_parking
     * @return \Illuminate\Http\Response
     */
    public function show(site_gate_parking $site_gate_parking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\site_gate_parking  $site_gate_parking
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', decrypt($id))->orderBy('id', "DESC")->first();
        $printer = printer::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        return view('content.new.site_gate_parking.edit', [
            'site_gate_parking' => $site_gate_parking,
            'printer' => $printer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\site_gate_parking  $site_gate_parking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        site_gate_parking::where('id', decrypt($id))->update(
            [
                'name' => $validatedData["name"],
                'address' => $validatedData["address"],
            ]

        );

        return redirect('dashboard/siteGateParking')->with('success', 'data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\site_gate_parking  $site_gate_parking
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $site_gate_parking = site_gate_parking::where('id', decrypt($id))->first();
        $site_gate_parking->delete();

        return decrypt($id);
    }
}
