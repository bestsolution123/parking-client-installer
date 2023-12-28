<?php

namespace App\Http\Controllers;

use App\Models\printer;
use Illuminate\Http\Request;

class PrinterController extends Controller
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
            $printer = printer::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $printer = printer::where('is_deleted', 0)->where('user_id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        return view('content.new.printer.index', [
            'printer' => $printer
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.new.printer.create');
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
            'type_connection' => 'required|max:255',
            'paper_size' => 'required|max:255',
            'name' => 'required|max:255',
            'address' => 'required|max:255',
        ]);

        $printer = printer::create([
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'paper_size' => $validatedData['paper_size'],
            'type_connection' => $validatedData['type_connection'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect('dashboard/printer')->with('success', 'data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\printer  $printer
     * @return \Illuminate\Http\Response
     */
    public function show(printer $printer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\printer  $printer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $printer = printer::where('is_deleted', 0)->where('id', decrypt($id))->orderBy('id', "DESC")->first();
        return view('content.new.printer.edit', [
            'printer' => $printer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\printer  $printer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'type_connection' => 'required|max:255',
            'paper_size' => 'required|max:255',
            'name' => 'required|max:255',
            'address' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        printer::where('id', decrypt($id))->update(
            [
                'name' => $validatedData["name"],
                'address' => $validatedData["address"],
                'type_connection' => $validatedData["type_connection"],
                'paper_size' => $validatedData["paper_size"],
            ]

        );

        return redirect('dashboard/printer')->with('success', 'data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\printer  $printer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $printer = printer::where('id', decrypt($id))->first();
        $printer->delete();

        return decrypt($id);
    }
}
