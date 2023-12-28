<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\serial_comunication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SerialComunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $serial_comunication = serial_comunication::orderBy('id', "DESC")->get();
        return $serial_comunication;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $serial_comunication = serial_comunication::create($validatedData);
        return $serial_comunication;


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\serial_comunication  $serial_comunication
     * @return \Illuminate\Http\Response
     */
    public function show(serial_comunication $serial_comunication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\serial_comunication  $serial_comunication
     * @return \Illuminate\Http\Response
     */
    public function edit(serial_comunication $serial_comunication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\serial_comunication  $serial_comunication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, serial_comunication $serial_comunication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\serial_comunication  $serial_comunication
     * @return \Illuminate\Http\Response
     */
    public function destroy(serial_comunication $serial_comunication)
    {
        //
    }
}
