<?php

namespace App\Http\Controllers;

use App\Models\vehicle;
use App\Models\vehicle_initial;
use Illuminate\Http\Request;

class VehicleController extends Controller
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
            $vehicle = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")->with('vehicle_initial')->get();
        } else {
            $vehicle = vehicle::where('is_deleted', 0)->where('user_id', auth()->user()->id)->orderBy('id', "DESC")->with('vehicle_initial')->get();
        }

        return view('content.new.vehicle.index', [
            'vehicle' => $vehicle
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicle_initial = vehicle_initial::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        return view('content.new.vehicle.create', [
            'vehicle_initial' => $vehicle_initial
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
            'vehicle_initial_id' => 'required|max:255',
            'time_price_1' => 'required|max:255',
            'time_price_2' => 'required|max:255',
            'time_price_3' => 'required|max:255',
            'grace_time' => 'required|max:255',
            'grace_time_duration' => 'required|max:255',
            'limitation_time_duration' => 'required|max:255',
        ]);

        $time_price_1 = (int) str_replace(['.', 'Rp'], '', $request->time_price_1);
        $time_price_2 = (int) str_replace(['.', 'Rp'], '', $request->time_price_2);
        $time_price_3 = (int) str_replace(['.', 'Rp'], '', $request->time_price_3);
        $grace_time = (int) str_replace(['.', 'Rp'], '', $request->grace_time);
        $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $request->maximum_daily_price);

        //validasi
        if ($time_price_1 < 1000) {
            return redirect()->back()->withInput()->with('danger', 'Harga Jam Ke 1 Tidak Boleh Kurang Dari Rp.1000');
        }

        if ($time_price_2 < 1000) {
            return redirect()->back()->withInput()->with('danger', 'Harga Jam Ke 2 Tidak Boleh Kurang Dari Rp.1000');
        }


        if ($time_price_3 < 1000) {
            return redirect()->back()->withInput()->with('danger', 'Harga Jam Ke 3 Tidak Boleh Kurang Dari Rp.1000');
        }


        if ($grace_time < 1000) {
            return redirect()->back()->withInput()->with('danger', 'Harga Sebelum Jam Ke 1 Tidak Boleh Kurang Dari Rp.1000');
        }

        if ($maximum_daily_price < 1000) {
            return redirect()->back()->withInput()->with('danger', 'Batas Maksimal Harga Perhari Tidak Boleh Kurang Dari Rp.1000');
        }

        if ($request->maximum_daily == 'on') {
            $validatedData['maximum_daily'] = 1;
        } else {
            $validatedData['maximum_daily'] = 0;
        }

        $validatedData['serial'] = time() . rand(1, 1000);

        $vehicle = vehicle::create([
            'serial' => $validatedData['serial'],
            'name' => $validatedData['name'],
            'vehicle_initial_id' => $validatedData['vehicle_initial_id'],
            'time_price_1' => $validatedData['time_price_1'],
            'time_price_2' => $validatedData['time_price_2'],
            'time_price_3' => $validatedData['time_price_3'],
            'grace_time' => $validatedData['grace_time'],
            'grace_time_duration' => $validatedData['grace_time_duration'],
            'limitation_time_duration' => $validatedData['limitation_time_duration'],
            'maximum_daily' => $validatedData['maximum_daily'],
            'maximum_daily_price' => $request->maximum_daily_price == '' ? '0' : $request->maximum_daily_price,
            'user_id' => auth()->user()->id,
        ]);

        return redirect('dashboard/vehicle')->with('success', 'data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicle = vehicle::where('is_deleted', 0)->where('id', decrypt($id))->orderBy('id', "DESC")->first();
        $vehicle_initial = vehicle_initial::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        return view('content.new.vehicle.edit', [
            'vehicle' => $vehicle,
            'vehicle_initial' => $vehicle_initial,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'name' => 'required|max:255',
            'vehicle_initial_id' => 'required|max:255',
            'time_price_1' => 'required|max:255',
            'time_price_2' => 'required|max:255',
            'time_price_3' => 'required|max:255',
            'grace_time' => 'required|max:255',
            'grace_time_duration' => 'required|max:255',
            'limitation_time_duration' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        $time_price_1 = (int) str_replace(['.', 'Rp'], '', $request->time_price_1);
        $time_price_2 = (int) str_replace(['.', 'Rp'], '', $request->time_price_2);
        $time_price_3 = (int) str_replace(['.', 'Rp'], '', $request->time_price_3);
        $grace_time = (int) str_replace(['.', 'Rp'], '', $request->grace_time);
        $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $request->maximum_daily_price);

        //validasi
        if ($time_price_1 < 1000) {
            return redirect()->back()->withInput()->with('danger', 'Harga Jam Ke 1 Tidak Boleh Kurang Dari Rp.1000');
        }

        if ($time_price_2 < 1000) {
            return redirect()->back()->withInput()->with('danger', 'Harga Jam Ke 2 Tidak Boleh Kurang Dari Rp.1000');
        }


        if ($time_price_3 < 1000) {
            return redirect()->back()->withInput()->with('danger', 'Harga Jam Ke 3 Tidak Boleh Kurang Dari Rp.1000');
        }


        if ($grace_time < 1000) {
            return redirect()->back()->withInput()->with('danger', 'Harga Sebelum Jam Ke 1 Tidak Boleh Kurang Dari Rp.1000');
        }

        if ($maximum_daily_price < 1000) {
            return redirect()->back()->withInput()->with('danger', 'Batas Maksimal Harga Perhari Tidak Boleh Kurang Dari Rp.1000');
        }

        if ($request->maximum_daily == 'on') {
            $validatedData['maximum_daily'] = 1;
        } else {
            $validatedData['maximum_daily'] = 0;
        }

        vehicle::where('id', decrypt($id))->update(
            [
                'name' => $validatedData["name"],
                'vehicle_initial_id' => $validatedData["vehicle_initial_id"],
                'time_price_1' => $validatedData['time_price_1'],
                'time_price_2' => $validatedData['time_price_2'],
                'time_price_3' => $validatedData['time_price_3'],
                'grace_time' => $validatedData['grace_time'],
                'grace_time_duration' => $validatedData['grace_time_duration'],
                'limitation_time_duration' => $validatedData['limitation_time_duration'],
                'maximum_daily' => $validatedData['maximum_daily'],
                'maximum_daily_price' => $request->maximum_daily_price == '' ? '0' : $request->maximum_daily_price,
            ]

        );

        return redirect('dashboard/vehicle')->with('success', 'data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = vehicle::where('id', decrypt($id))->first();
        $vehicle->delete();

        return decrypt($id);
    }
}
