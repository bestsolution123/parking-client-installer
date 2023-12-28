<?php

namespace App\Http\Controllers;

use App\Models\pegawai;
use App\Models\site_gate_parking;
use App\Models\status_kepegawaian;
use App\Models\transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;


class dashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {

        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('is_deleted', 0)->get();
            $transaction_today = transaction::where('is_deleted', 0)->whereDate('created_at', Carbon::today())->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        } else {
            $transaction = transaction::where('is_deleted', 0)->where('user_id', auth()->user()->id)->get();
            $transaction_today = transaction::where('is_deleted', 0)->whereDate('created_at', Carbon::today())->where('user_id', auth()->user()->id)->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->where('user_id', auth()->user()->id)->get();

        }


        return view('content.dashboard.dashboards-analytics', [
            'transaction' => $transaction,
            'transaction_today' => $transaction_today,
            'site_gate_parking' => $site_gate_parking,
        ]);
    }
}
