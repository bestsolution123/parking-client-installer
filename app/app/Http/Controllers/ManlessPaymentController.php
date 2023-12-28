<?php

namespace App\Http\Controllers;

use App\Models\manlessPayment;
use Illuminate\Http\Request;

class ManlessPaymentController extends Controller
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
            $manlessPayment = manlessPayment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $manlessPayment = manlessPayment::where('is_deleted', 0)->where('user_id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        return view('content.new.manlessPayment.index', [
            'manlessPayment' => $manlessPayment
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.new.manlessPayment.create');
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
            'payment_type' => 'required|max:255',
            'payment_bank' => 'required|max:255',
        ]);

        $printer = manlessPayment::create([
            'name' => $validatedData['name'],
            'payment_type' => $validatedData['payment_type'],
            'payment_bank' => $validatedData['payment_bank'],
        ]);

        return redirect('dashboard/manlessPayment')->with('success', 'data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mainlessPayment  $mainlessPayment
     * @return \Illuminate\Http\Response
     */
    public function show(manlessPayment $manlessPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mainlessPayment  $mainlessPayment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manlessPayment = manlessPayment::where('is_deleted', 0)->where('id', decrypt($id))->orderBy('id', "DESC")->first();
        return view('content.new.manlessPayment.edit', [
            'manlessPayment' => $manlessPayment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\mainlessPayment  $mainlessPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'payment_type' => 'required|max:255',
            'payment_bank' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        manlessPayment::where('id', decrypt($id))->update(
            [
                'name' => $validatedData["name"],
                'payment_type' => $validatedData["payment_type"],
                'payment_bank' => $validatedData["payment_bank"],
            ]

        );

        return redirect('dashboard/manlessPayment')->with('success', 'data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mainlessPayment  $mainlessPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manlessPayment = manlessPayment::where('id', decrypt($id))->first();
        $manlessPayment->delete();

        return decrypt($id);
    }
}
