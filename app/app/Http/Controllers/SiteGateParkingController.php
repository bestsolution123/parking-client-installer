<?php

namespace App\Http\Controllers;

use App\Models\manlessPayment;
use App\Models\printer;
use App\Models\printer_setting;
use App\Models\site_gate_parking;
use App\Models\siteGateParkingPayment;
use App\Models\vehicle;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class SiteGateParkingController extends Controller
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
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->with('printer')->with('printer_setting')->get();
        } else {
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('user_id', auth()->user()->id)->orderBy('id', "DESC")->with('printer')->with('printer_setting')->get();
        }

        // return $site_gate_parking;

        return view('content.new.site_gate_parking.index', [
            'site_gate_parking' => $site_gate_parking,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $printer = printer::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $vehicle = vehicle::where('is_deleted', 0)->get();
        $manlessPayment = manlessPayment::where('is_deleted', 0)->get();

        return view('content.new.site_gate_parking.create', [
            'printer' => $printer,
            'vehicle' => $vehicle,
            'manlessPayment' => $manlessPayment,

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
            'vehicle_id' => 'required|max:255',
            'address' => 'required|max:255',
            'type' => 'required|max:255',
            'type_payment' => 'required|max:255',
        ]);


        if ($request->has('is_print')) {
            $validatedData['is_print'] = true;
        } else {
            $validatedData['is_print'] = false;
        }

        $site_gate_parking = site_gate_parking::create([
            'name' => $validatedData['name'],
            'printer_id' => $validatedData['printer_id'],
            'vehicle_id' => $validatedData['vehicle_id'],
            'address' => $validatedData['address'],
            'type' => $validatedData['type'],
            'is_print' => $validatedData['is_print'],
            'type_payment' => $validatedData['type_payment'],
            'user_id' => auth()->user()->id,
        ]);


        foreach ($request->manless_payment_id as $item) {
            if ($item != null) {
                $siteGateParkingPayment = siteGateParkingPayment::create([
                    'site_gate_parking_id' => $site_gate_parking->id,
                    'manless_payment_id' => $item,
                ]);
            }

        }


        for ($i = 0; $i < count($request->printer_settings_name); $i++) {

            if ($request['printer_settings_isOn' . $i] == 'on') {
                $validatedData['printer_settings_isOn' . $i] = 1;
            } else {
                $validatedData['printer_settings_isOn' . $i] = 0;
            }

            $printer_setting = printer_setting::create([
                'site_gate_parking_id' => $site_gate_parking->id,
                'name' => $request->printer_settings_name[$i],
                'is_on' => $validatedData['printer_settings_isOn' . $i],
                'user_id' => auth()->user()->id,
            ]);
        }

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
        $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', decrypt($id))
            ->with('siteGateParkingPayment')
            ->with('printer_setting')
            ->orderBy('id', "DESC")
            ->first();
        $printer = printer::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $vehicle = vehicle::where('is_deleted', 0)->get();
        $manlessPayment = manlessPayment::where('is_deleted', 0)->get();

        // return $site_gate_parking;

        return view('content.new.site_gate_parking.edit', [
            'site_gate_parking' => $site_gate_parking,
            'printer' => $printer,
            'vehicle' => $vehicle,
            'manlessPayment' => $manlessPayment,
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
            'printer_id' => 'required|max:255',
            'vehicle_id' => 'required|max:255',
            'type' => 'required|max:255',
            'type_payment' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);



        if ($request->has('is_print')) {
            $validatedData['is_print'] = true;
        } else {
            $validatedData['is_print'] = false;
        }

        site_gate_parking::where('id', decrypt($id))->update(
            [
                'name' => $validatedData["name"],
                'address' => $validatedData["address"],
                'printer_id' => $validatedData['printer_id'],
                'vehicle_id' => $validatedData['vehicle_id'],
                'type' => $validatedData['type'],
                'is_print' => $validatedData['is_print'],
                'type_payment' => $validatedData['type_payment'],
            ]

        );

        for ($i = 0; $i < count($request->printer_settings_name); $i++) {
            if ($request['printer_settings_isOn' . $i] == 'on') {
                $validatedData['printer_settings_isOn' . $i] = 1;
            } else {
                $validatedData['printer_settings_isOn' . $i] = 0;
            }

            printer_setting::where('id', decrypt($request['printer_settings_id' . $i]))->update(
                [
                    'is_on' => $validatedData['printer_settings_isOn' . $i],
                ]

            );
        }

        // siteGateParkingPayment
        $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', decrypt($id))->orderBy('id', "DESC")->first();
        if ($request->manless_payment_id) {

            if ($validatedData['type_payment'] == 'Manual') {
                foreach ($site_gate_parking->siteGateParkingPayment as $item) {
                    $siteGateParkingPayment = siteGateParkingPayment::where('is_deleted', 0)->where('id', $item->id)->first();
                    $siteGateParkingPayment->delete();
                }
            }

            if (count($request->manless_payment_id) != count($site_gate_parking->siteGateParkingPayment)) {
                foreach ($site_gate_parking->siteGateParkingPayment as $item) {
                    $siteGateParkingPayment = siteGateParkingPayment::where('is_deleted', 0)->where('id', $item->id)->first();
                    $siteGateParkingPayment->delete();
                }
            }

            for ($i = 0; $i < count($request->manless_payment_id); $i++) {
                if (count($request->manless_payment_id) == count($site_gate_parking->siteGateParkingPayment)) {
                    siteGateParkingPayment::where('id', decrypt($request->id_manless_payment_id[$i]))->update([
                        'manless_payment_id' => $request->manless_payment_id[$i],
                    ]);
                } else {
                    siteGateParkingPayment::create([
                        'site_gate_parking_id' => decrypt($id),
                        'manless_payment_id' => $request->manless_payment_id[$i],
                    ]);
                }
            }
        }




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
        $site_gate_parking = site_gate_parking::where('id', decrypt($id))->with('printer_setting')->first();
        // return $site_gate_parking->printer_setting;
        $site_gate_parking->delete();

        for ($i = 0; $i < count($site_gate_parking->printer_setting); $i++) {
            $printer_setting = printer_setting::where('id', $site_gate_parking->printer_setting[$i]['id'])->first();
            $printer_setting->delete();
        }

        return decrypt($id);
    }
}
