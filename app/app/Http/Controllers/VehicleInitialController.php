<?php

namespace App\Http\Controllers;

use App\Models\vehicle_initial;
use Illuminate\Http\Request;

class VehicleInitialController extends Controller
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
            $vehicle_initial = vehicle_initial::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $vehicle_initial = vehicle_initial::where('is_deleted', 0)->where('user_id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        return view('content.new.vehicle_initial.index', [
            'vehicle_initial' => $vehicle_initial
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.new.vehicle_initial.create');

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
        ]);

        $vehicle_initial = vehicle_initial::create([
            'name' => $validatedData['name'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect('dashboard/vehicleInitial')->with('success', 'data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\vehicle_initial  $vehicle_initial
     * @return \Illuminate\Http\Response
     */
    public function show(vehicle_initial $vehicle_initial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\vehicle_initial  $vehicle_initial
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $vehicle_initial = vehicle_initial::where('is_deleted', 0)->where('id', decrypt($id))->orderBy('id', "DESC")->first();
        return view('content.new.vehicle_initial.edit', [
            'vehicle_initial' => $vehicle_initial
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\vehicle_initial  $vehicle_initial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        vehicle_initial::where('id', decrypt($id))->update(
            [
                'name' => $validatedData["name"],
            ]

        );

        return redirect('dashboard/vehicleInitial')->with('success', 'data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\vehicle_initial  $vehicle_initial
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle_initial = vehicle_initial::where('id', decrypt($id))->first();
        $vehicle_initial->delete();

        return decrypt($id);
    }
}
