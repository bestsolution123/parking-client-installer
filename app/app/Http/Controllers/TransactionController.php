<?php

namespace App\Http\Controllers;

use App\Exports\transactionExport;
use App\Models\printer as ModelsPrinter;
use App\Models\punishment;
use App\Models\site_gate_parking;
use App\Models\transaction;
use App\Models\transactionMemberLog;
use App\Models\transactionVoucherLog;
use App\Models\User;
use App\Models\vehicle;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\GdEscposImage;
use Mike42\Escpos\ImagickEscposImage;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class TransactionController extends Controller
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
            $transaction = transaction::where('is_deleted', 0)->orderBy('id', "DESC")->with('site_gate_parking.vehicle.vehicle_initial')->get();
        } else {
            $transaction = transaction::where('is_deleted', 0)->where('user_id', auth()->user()->id)->with('site_gate_parking.vehicle.vehicle_initial')->orderBy('id', "DESC")->get();
        }

        $punishment = punishment::where('is_deleted', 0)->get();


        // return $transaction;

        return view('content.new.transaction.index', [
            'transaction' => $transaction,
            'punishment' => $punishment
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'plat_number' => 'required|max:255',
        ]);

        $validatedData['serial'] = time() . rand(1, 1000);

        $transaction = transaction::create([
            'name' => $validatedData['name'],
            'serial' => $validatedData['serial'],
            'plat_number' => $validatedData['plat_number'],
        ]);

        return redirect('dashboard/siteGateParking')->with('success', 'data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(transaction $transaction)
    {
        //
    }



    public function reportIndex(Request $request)
    {

        // $transaction = DB::table('transactions')
        //     ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
        //     ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
        //     // ->select( 'vehicles.name', 'site_gate_parkings.name as gate_name')
        //     // ->whereDate('transactions.created_at', $request->calendar)
        //     // ->where('site_gate_parkings.name', $request->gate)
        //     ->get();

        // $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        // $all_price = array();

        // foreach ($transaction as $number => $item)
        // {
        //     //calculate time
        //     $date1 = new DateTime($item->created_at);
        //     $date2 = new DateTime($item->date_out);
        //     $interval = $date1->diff($date2);

        //     $price = 0;
        //     $time_1 = 0;
        //     $time_2 = 0;

        //     if ($interval->h < 1 && $interval->m < (int) $item->grace_time_duration) {
        //         $grace_time = (int) str_replace(['.', 'Rp'], '', $item->grace_time);
        //         $price = $grace_time;
        //     }

        //     if ($time_1 == 0) {
        //         if ($interval->d < 1 && $interval->h > 0) {
        //             $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->time_price_1);
        //             $price = $price + $time_price_1;
        //         }
        //         $time_1++;
        //     }

        //     if ($time_2 == 0) {
        //         if ($interval->d < 1 && $interval->h > 1) {
        //             $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->time_price_2);
        //             $price = $price + $time_price_2;
        //         }
        //         $time_2++;
        //     }

        //     if ($interval->d < 1 && $interval->h > 2) {
        //         $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->time_price_3);
        //         $price = $price + $time_price_3 * ($interval->h - 2);
        //     }

        //     if ($item->maximum_daily == 1) {
        //         $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->maximum_daily_price);
        //         if ($price > $maximum_daily_price) {
        //             $price = $maximum_daily_price;
        //         }
        //     }

        //     foreach ($punishment as $item2) {
        //         if ($item2->name == $item->status) {
        //             $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
        //             $price = $price + $punishment_price;
        //         }
        //     }

        //     $all_price[$number] =+ $price;
        // }

        // $transaction = $transaction->merge($all_price);
        // return $transaction;


        if ($request->calendar != '') {

            $transaction_all_vehicle = DB::table('transactions')
                ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
                ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
                ->select('vehicles.name', 'site_gate_parkings.name as gate_name')
                ->whereDate('transactions.created_at', $request->calendar)
                ->where('site_gate_parkings.name', $request->gate)
                ->get();
        } else {
            $transaction_all_vehicle = DB::table('transactions')
                ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
                ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
                ->select('vehicles.name')
                ->get();
        }

        // $transaction_all_vehicle_custom = DB::table('transactions')
        //     ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
        //     ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
        //     ->select('transactions.*', 'site_gate_parkings.name')
        //     ->get();

        // return $transaction_all_vehicle;

        if ($request->calendar != '') {
            $transaction_all_vehicle_unique = DB::table('transactions')
                ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
                ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
                ->select('vehicles.name', DB::raw('COUNT(vehicles.name) as count'))
                ->groupBy('vehicles.name')
                ->whereDate('transactions.created_at', $request->calendar)
                ->get()
                ->unique('name');
        } else {
            $transaction_all_vehicle_unique = DB::table('transactions')
                ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
                ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
                ->select('vehicles.name', DB::raw('COUNT(vehicles.name) as count'))
                ->groupBy('vehicles.name')
                ->get()
                ->unique('name');
        }

        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('transactions.is_deleted', 0)->with('site_gate_parking.vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('transactions.is_deleted', 0)->where('id', auth()->user()->id)->with('site_gate_parking.vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();


        //summary
        //daily
        $transaction_all_vehicle_today = transaction::whereDate('created_at', Carbon::now())->get();
        $all_price_today = 0;
        foreach ($transaction_all_vehicle_today as $item) {
            //calculate time
            $date1 = new DateTime($item->created_at);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;

            if ($interval->h < 1 && $interval->m < (int) $item->site_gate_parking->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->grace_time);
                $price = $grace_time;
            }

            if ($time_1 == 0) {
                if ($interval->d < 1 && $interval->h > 0) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->d < 1 && $interval->h > 1) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->d < 1 && $interval->h > 2) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_3);
                $price = $price + $time_price_3 * ($interval->h - 2);
            }

            if ($item->site_gate_parking->vehicle->maximum_daily == 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                if ($price > $maximum_daily_price) {
                    $price = $maximum_daily_price;
                }
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }
            $all_price_today = $all_price_today + $price;

        }

        //weekly
        $transaction_all_vehicle_weekly = transaction::whereDate('created_at', '>=', Carbon::now()->subDays(8)->toDateTimeString())->get();
        $all_price_weekly = 0;
        foreach ($transaction_all_vehicle_weekly as $item) {
            //calculate time
            $date1 = new DateTime($item->created_at);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;

            if ($interval->h < 1 && $interval->m < (int) $item->site_gate_parking->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->grace_time);
                $price = $grace_time;
            }

            if ($time_1 == 0) {
                if ($interval->d < 1 && $interval->h > 0) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->d < 1 && $interval->h > 1) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->d < 1 && $interval->h > 2) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_3);
                $price = $price + $time_price_3 * ($interval->h - 2);
            }

            if ($item->site_gate_parking->vehicle->maximum_daily == 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                if ($price > $maximum_daily_price) {
                    $price = $maximum_daily_price;
                }
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }
            $all_price_weekly = $all_price_weekly + $price;

        }

        //monthly
        $transaction_all_vehicle_monthly = transaction::whereDate('created_at', '>=', Carbon::now()->subDays(31)->toDateTimeString())->get();
        $all_price_monthly = 0;
        foreach ($transaction_all_vehicle_monthly as $item) {
            //calculate time
            $date1 = new DateTime($item->created_at);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;

            if ($interval->h < 1 && $interval->m < (int) $item->site_gate_parking->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->grace_time);
                $price = $grace_time;
            }

            if ($time_1 == 0) {
                if ($interval->d < 1 && $interval->h > 0) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->d < 1 && $interval->h > 1) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->d < 1 && $interval->h > 2) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_3);
                $price = $price + $time_price_3 * ($interval->h - 2);
            }

            if ($item->site_gate_parking->vehicle->maximum_daily == 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                if ($price > $maximum_daily_price) {
                    $price = $maximum_daily_price;
                }
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }
            $all_price_monthly = $all_price_monthly + $price;

        }

        //yearly
        $transaction_all_vehicle_yearly = transaction::whereDate('created_at', '>=', Carbon::now()->subDays(366)->toDateTimeString())->get();
        $all_price_yearly = 0;
        foreach ($transaction_all_vehicle_yearly as $item) {
            //calculate time
            $date1 = new DateTime($item->created_at);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;

            if ($interval->h < 1 && $interval->m < (int) $item->site_gate_parking->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->grace_time);
                $price = $grace_time;
            }

            if ($time_1 == 0) {
                if ($interval->d < 1 && $interval->h > 0) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->d < 1 && $interval->h > 1) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->d < 1 && $interval->h > 2) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_3);
                $price = $price + $time_price_3 * ($interval->h - 2);
            }

            if ($item->site_gate_parking->vehicle->maximum_daily == 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                if ($price > $maximum_daily_price) {
                    $price = $maximum_daily_price;
                }
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }
            $all_price_yearly = $all_price_yearly + $price;

        }

        $all_price_today = 'Rp ' . number_format($all_price_today);
        $all_price_weekly = 'Rp ' . number_format($all_price_weekly);
        $all_price_monthly = 'Rp ' . number_format($all_price_monthly);
        $all_price_yearly = 'Rp ' . number_format($all_price_yearly);


        // return count($transaction_all_vehicle_weekly);
        // return $transaction;

        return view('content.new.report.index', [
            'all_price_today' => $all_price_today,
            'all_price_weekly' => $all_price_weekly,
            'all_price_monthly' => $all_price_monthly,
            'all_price_yearly' => $all_price_yearly,
            'transaction_all_vehicle_today' => $transaction_all_vehicle_today,
            'transaction_all_vehicle_weekly' => $transaction_all_vehicle_weekly,
            'transaction_all_vehicle_monthly' => $transaction_all_vehicle_monthly,
            'transaction_all_vehicle_yearly' => $transaction_all_vehicle_yearly,
            'transaction' => $transaction,
            'punishment' => $punishment,
            'transaction_all_vehicle' => $transaction_all_vehicle,
            'transaction_all_vehicle_unique' => $transaction_all_vehicle_unique,
            'site_gate_parking' => $site_gate_parking
        ]);
    }

    public function reportIndexMember(Request $request)
    {

        // return $request->gate ;

        if ($request->calendar != '') {

            $transaction_all_vehicle = DB::table('transactions')
                ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
                ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
                ->select('vehicles.name', 'site_gate_parkings.name as gate_name')
                ->whereDate('transactions.created_at', $request->calendar)
                ->where('site_gate_parkings.name', $request->gate)
                ->where('transactions.visitor_type', 'Member')
                ->get();
        } else {
            $transaction_all_vehicle = DB::table('transactions')
                ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
                ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
                ->select('vehicles.name')
                ->where('transactions.visitor_type', 'Member')
                ->get();
        }



        // $transaction_all_vehicle_custom = DB::table('transactions')
        //     ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
        //     ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
        //     ->select('transactions.*', 'site_gate_parkings.name')
        //     ->get();

        // return $transaction_all_vehicle;

        if ($request->calendar != '') {
            $transaction_all_vehicle_unique = DB::table('transactions')
                ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
                ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
                ->select('vehicles.name', DB::raw('COUNT(vehicles.name) as count'))
                ->groupBy('vehicles.name')
                ->whereDate('transactions.created_at', $request->calendar)
                ->where('transactions.visitor_type', 'Member')
                ->get()
                ->unique('name');
        } else {
            $transaction_all_vehicle_unique = DB::table('transactions')
                ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
                ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
                ->select('vehicles.name', DB::raw('COUNT(vehicles.name) as count'))
                ->groupBy('vehicles.name')
                ->where('transactions.visitor_type', 'Member')
                ->get()
                ->unique('name');
        }

        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('transactions.is_deleted', 0)->where('visitor_type', 'Member')->with('site_gate_parking.vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('transactions.is_deleted', 0)->where('visitor_type', 'Member')->where('id', auth()->user()->id)->with('site_gate_parking.vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        // return $transaction;

        return view('content.new.report.index_member', [
            'transaction' => $transaction,
            'transaction_all_vehicle' => $transaction_all_vehicle,
            'transaction_all_vehicle_unique' => $transaction_all_vehicle_unique,
            'site_gate_parking' => $site_gate_parking
        ]);
    }

    public function getTransactionLatest()
    {
        $transaction = transaction::where('is_deleted', 0)->get();
        return $transaction;
    }

    public function finish(Request $request, $id)
    {

        $transaction = transaction::where('is_deleted', 0)->where('id', decrypt($id))->first();
        if ($transaction->status == '-') {
            $time_now = Carbon::now();

            transaction::where('id', decrypt($id))->update(
                [
                    'status' => $request->status,
                    'date_out' => $time_now,
                    'payment_method' => 'Tunai',
                ]
            );

        } else {
            transaction::where('id', decrypt($id))->update(
                [
                    'status' => $request->status,
                ]
            );
        }

        return $transaction;


        // return redirect('dashboard/transaction')->with('success', 'data berhasil di ubah');

    }

    public function export_excel_transaksi($visitor_type)
    {


        return Excel::download(new transactionExport($visitor_type), 'transaction.xlsx');
        // return Excel::download(new guestExport($event_id), 'guest.xlsx');
    }


    public function printParkingExit($transaction_id)
    {

        // $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id',decrypt($gate_id))->orderBy('id', "DESC")->with('printer')->first();
        $transaction = transaction::where('is_deleted', 0)->where('id', $transaction_id)->orderBy('id', "DESC")->with('site_gate_parking.vehicle')->first();
        $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', $transaction->site_gate_parking_id)->orderBy('id', "DESC")->with('printer')->with('printer_setting')->first();
        $date = Carbon::now();

        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $all_price = 0;


        //calculate time
        $date1 = new DateTime($transaction->created_at);
        $date2 = new DateTime($transaction->date_out);
        $interval = $date1->diff($date2);

        $price = 0;
        $time_1 = 0;
        $time_2 = 0;

        if ($interval->h < 1 && $interval->m < (int) $transaction->site_gate_parking->vehicle->grace_time_duration) {
            $grace_time = (int) str_replace(['.', 'Rp'], '', $transaction->site_gate_parking->vehicle->grace_time);
            $price = $grace_time;
        }

        if ($time_1 == 0) {
            if ($interval->d < 1 && $interval->h > 0) {
                $time_price_1 = (int) str_replace(['.', 'Rp'], '', $transaction->site_gate_parking->vehicle->time_price_1);
                $price = $price + $time_price_1;
            }
            $time_1++;
        }

        if ($time_2 == 0) {
            if ($interval->d < 1 && $interval->h > 1) {
                $time_price_2 = (int) str_replace(['.', 'Rp'], '', $transaction->site_gate_parking->vehicle->time_price_2);
                $price = $price + $time_price_2;
            }
            $time_2++;
        }

        if ($interval->d < 1 && $interval->h > 2) {
            $time_price_3 = (int) str_replace(['.', 'Rp'], '', $transaction->site_gate_parking->vehicle->time_price_3);
            $price = $price + $time_price_3 * ($interval->h - 2);
        }

        if ($transaction->site_gate_parking->vehicle->maximum_daily == 1) {
            $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $transaction->site_gate_parking->vehicle->maximum_daily_price);
            if ($price > $maximum_daily_price) {
                $price = $maximum_daily_price;
            }
        }

        foreach ($punishment as $item2) {
            if ($item2->name == $transaction->status) {
                $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                $price = $price + $punishment_price;
            }
        }

        $all_price = $all_price + $price;
        $all_price = 'Rp ' . number_format($all_price);



        // return  $all_price ;


        if ($site_gate_parking->printer->type_connection == "LAN") {
            $connector = new NetworkPrintConnector($site_gate_parking->printer->address);
        } else {
            $connector = new WindowsPrintConnector($site_gate_parking->printer->address);
        }

        $printer = new Printer($connector);

        // Most simple examples
        // $printer->text($date->format('h:i:s')." \n");        

        foreach ($site_gate_parking->printer_setting as $item) {

            // if($item->name == "Logo")
            // {
            //     if($item->is_on == 1)
            //     {

            //         //logo
            //         try {
            //             // $img = EscposImage::load("assets/img/bg.jpg", false);
            //             $logo = EscposImage::load("assets/img/bg.jpg");
            //             $printer -> initialize();
            //             $printer -> bitImage($logo);

            //         } catch (Exception $e) {
            //             echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            //         }

            //         //batas garis
            //         if($site_gate_parking->printer->paper_size == "80")
            //         {
            //             $printer->textRaw(str_repeat(chr(196), 48) . PHP_EOL);
            //         }
            //         else  if($site_gate_parking->printer->paper_size == "55")
            //         {
            //             $printer->textRaw(str_repeat(chr(196), 32) . PHP_EOL);
            //         }

            //         $printer->feed(3);
            //     }

            // }

            // if ($item->name == "QRCode") {
            //     if ($item->is_on == 1) {
            //         $time = $transaction->created_at;
            //         $datestr = $time->format('ymd');

            //         $weekMap = [
            //             0 => 'SU',
            //             1 => 'MO',
            //             2 => 'TU',
            //             3 => 'WE',
            //             4 => 'TH',
            //             5 => 'FR',
            //             6 => 'SA',
            //         ];
            //         $dayOfTheWeek = Carbon::now()->dayOfWeek;

            //         if ($transaction->number < 10) {
            //             $transactionNumber = '000' . (string) $transaction->number;
            //         } else if ($transaction->number >= 10 && $transaction->number < 100) {
            //             $transactionNumber = '00' . (string) $transaction->number;
            //         } else if ($transaction->number >= 100 && $transaction->number < 1000) {
            //             $transactionNumber = '0' . (string) $transaction->number;
            //         } else if ($transaction->number >= 1000) {
            //             $transactionNumber = (string) $transaction->number;
            //         }

            //         $result_barcode = $datestr . $transactionNumber . $transaction->vehicle->vehicle_initial->id . $dayOfTheWeek;

            //         //qrcode / barcode
            //         $printer->setJustification(Printer::JUSTIFY_CENTER);
            //         $printer->barcode($result_barcode, Printer::BARCODE_UPCA);
            //         // $printer->qrCode($transaction->serial, Printer::QR_ECLEVEL_M, 12, printer::QR_MODEL_2);

            //         //qrcode serial
            //         // $printer->feed(1);
            //         // $printer->setJustification(Printer::JUSTIFY_CENTER);
            //         // $printer->text( $transaction->serial . " \n");
            //         $printer->feed(3);
            //     }

            // }

            if ($item->name == "Plat Kendaraan") {
                if ($item->is_on == 1) {
                    //harga
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("Harga : ");
                    if ($transaction->visitor_type == "Voucher" || $transaction->visitor_type == "Member") {
                        $printer->text('-' . "\n");
                    } else {
                        $printer->text($all_price . "\n");
                    }

                    //method payment
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("Metode Pembayaran : ");
                    $printer->text($transaction->payment_type . "\n");

                    //transaction detail
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("Plat Kendaraan : ");
                    $printer->text("$transaction->plat_number \n");

                }

            }

            if ($item->name == "Tanggal Masuk") {
                if ($item->is_on == 1) {
                    // transaction detail
                    $printer->text("Tanggal Masuk : ");
                    $printer->text($transaction->created_at . "\n");

                    // transaction detail
                    $printer->text("Tanggal Keluar : ");
                    $printer->text($transaction->date_out . "\n");

                    // transaction duration
                    $date1 = new DateTime($transaction->created_at);
                    $date2 = new DateTime($transaction->date_out);
                    $interval = $date1->diff($date2);

                    $printer->text("Durasi : ");
                    $printer->text($interval->d . ' Hari ' . sprintf("%02d", $interval->h) . ':' . sprintf("%02d", $interval->i) . ':' . sprintf("%02d", $interval->s) . "\n");
                    $printer->feed(3);
                }

            }

            if ($item->name == "Alamat") {
                if ($item->is_on == 1) {
                    //address
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->selectPrintMode(Printer::MODE_FONT_A);
                    $printer->text($site_gate_parking->address . "\n");
                    $printer->feed(1);
                }

            }

            if ($item->name == "Catatan") {
                if ($item->is_on == 1) {
                    //batas garis
                    if ($site_gate_parking->printer->paper_size == "80") {
                        $printer->textRaw(str_repeat(chr(196), 48) . PHP_EOL);
                    } else if ($site_gate_parking->printer->paper_size == "55") {
                        $printer->textRaw(str_repeat(chr(196), 32) . PHP_EOL);
                    }

                    //informasi catatan
                    $printer->feed(1);
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->text("Terimakasih Telah Berkunjung \n");

                    $printer->feed(3);
                }

            }

        }

        //printer cut
        $printer->cut();
        $printer->close();


        // return redirect('/gate/scanners/' . $id)->with('status', 'Profile updated!');
    }

    public function printParkingExitAdmin($transaction_id, $printer_id)
    {

        // $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id',decrypt($gate_id))->orderBy('id', "DESC")->with('printer')->first();
        $transaction = transaction::where('is_deleted', 0)->where('id', decrypt($transaction_id))->orderBy('id', "DESC")->with('site_gate_parking.vehicle')->first();
        $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', $transaction->site_gate_parking_id)->orderBy('id', "DESC")->with('printer')->with('printer_setting')->first();
        $ModelsPrinter = ModelsPrinter::where('is_deleted', 0)->where('id', decrypt($printer_id))->orderBy('id', "DESC")->first();
        $date = Carbon::now();

        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $all_price = 0;


        //calculate time
        $date1 = new DateTime($transaction->created_at);
        $date2 = new DateTime($transaction->date_out);
        $interval = $date1->diff($date2);

        $price = 0;
        $time_1 = 0;
        $time_2 = 0;


        if ($interval->d < 1 && $interval->h < 1 && $interval->i < (int) $transaction->vehicle->grace_time_duration) {
            $grace_time = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->grace_time);
            $price = $grace_time;
        } elseif ($interval->d < 1 && $interval->h < 1 && $interval->i > (int) $transaction->vehicle->grace_time_duration) {
            $time_price_1 = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->time_price_1);
            $price = $time_price_1;
        }

        if ($time_1 == 0) {
            if (60 + $interval->i >= $transaction->vehicle->limitation_time_duration) {
                $time_price_1 = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->time_price_1);
                $price = $price + $time_price_1;
            }
            $time_1++;
        }

        if ($time_2 == 0) {
            if ($interval->h * 60 + $interval->i >= 60 + $transaction->vehicle->limitation_time_duration) {
                $time_price_2 = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->time_price_2);
                $price = $price + $time_price_2;
            }
            $time_2++;
        }

        if ($interval->h * 60 + $interval->i >= 120 + $transaction->vehicle->limitation_time_duration) {
            $time_price_3 = (int) str_replace(['.', 'Rp'], '', $transaction->vehicle->time_price_3);
            if ($interval->h <= 2) {
                $price = $price + $time_price_3;
            } else {
                $price = $price + $time_price_3 * ($interval->h - 1);
            }
        }

        if ($transaction->vehicle->maximum_daily >= 1) {
            $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $transaction->site_gate_parking->vehicle->maximum_daily_price);
            $price = $price + $maximum_daily_price * $interval->d;
        }

        foreach ($punishment as $item2) {
            if ($item2->name == $transaction->status) {
                $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                $price = $price + $punishment_price;
            }
        }

        $all_price = $all_price + $price;
        $all_price = 'Rp ' . number_format($all_price);



        // return  $all_price ;


        if ($ModelsPrinter->type_connection == "LAN") {
            $connector = new NetworkPrintConnector($ModelsPrinter->address);
        } else {
            $connector = new WindowsPrintConnector($ModelsPrinter->address);
        }

        $printer = new Printer($connector);

        // Most simple examples
        // $printer->text($date->format('h:i:s')." \n");    

        //Title
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->selectPrintMode(Printer::MODE_FONT_B);
        $printer->setTextSize(2, 2);
        $printer->text('Tiket Parkir' . "\n");
        $printer->selectPrintMode(Printer::MODE_FONT_A);
        $printer->setTextSize(1, 1);
        $printer->feed(3);

        foreach ($site_gate_parking->printer_setting as $item) {

            // if($item->name == "Logo")
            // {
            //     if($item->is_on == 1)
            //     {

            //         //logo
            //         try {
            //             // $img = EscposImage::load("assets/img/bg.jpg", false);
            //             $logo = EscposImage::load("assets/img/bg.jpg");
            //             $printer -> initialize();
            //             $printer -> bitImage($logo);

            //         } catch (Exception $e) {
            //             echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            //         }

            //         //batas garis
            //         if($site_gate_parking->printer->paper_size == "80")
            //         {
            //             $printer->textRaw(str_repeat(chr(196), 48) . PHP_EOL);
            //         }
            //         else  if($site_gate_parking->printer->paper_size == "55")
            //         {
            //             $printer->textRaw(str_repeat(chr(196), 32) . PHP_EOL);
            //         }

            //         $printer->feed(3);
            //     }

            // }

            if ($item->name == "Plat Kendaraan") {
                if ($item->is_on == 1) {
                    //harga
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("Harga : ");
                    if ($transaction->visitor_type == "Voucher" || $transaction->visitor_type == "Member") {
                        $printer->text('-' . "\n");
                    } else {
                        $printer->text($all_price . "\n");
                    }

                    //method payment
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("Metode Pembayaran : ");
                    $printer->text($transaction->payment_type . "\n");

                    //transaction detail
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("Nomor Polisi : ");
                    $printer->text("$transaction->plat_number \n");

                }

            }

            if ($item->name == "Tanggal Masuk") {
                if ($item->is_on == 1) {
                    // transaction detail
                    $printer->text("Tanggal Masuk : ");
                    $printer->text($transaction->created_at . "\n");

                    // transaction detail
                    $printer->text("Tanggal Keluar : ");
                    $printer->text($transaction->date_out . "\n");

                    // transaction duration
                    $date1 = new DateTime($transaction->created_at);
                    $date2 = new DateTime($transaction->date_out);
                    $interval = $date1->diff($date2);

                    $printer->text("Durasi : ");
                    $printer->text($interval->d . ' Hari ' . sprintf("%02d", $interval->h) . ':' . sprintf("%02d", $interval->i) . ':' . sprintf("%02d", $interval->s) . "\n");
                    $printer->feed(3);
                }

            }

            // if ($item->name == "QRCode") {
            //     if ($item->is_on == 1) {
            //         $time = $transaction->created_at;
            //         $datestr = $time->format('ymd');

            //         $weekMap = [
            //             0 => 'SU',
            //             1 => 'MO',
            //             2 => 'TU',
            //             3 => 'WE',
            //             4 => 'TH',
            //             5 => 'FR',
            //             6 => 'SA',
            //         ];
            //         $dayOfTheWeek = Carbon::now()->dayOfWeek;

            //         if ($transaction->number < 10) {
            //             $transactionNumber = '000' . (string) $transaction->number;
            //         } else if ($transaction->number >= 10 && $transaction->number < 100) {
            //             $transactionNumber = '00' . (string) $transaction->number;
            //         } else if ($transaction->number >= 100 && $transaction->number < 1000) {
            //             $transactionNumber = '0' . (string) $transaction->number;
            //         } else if ($transaction->number >= 1000) {
            //             $transactionNumber = (string) $transaction->number;
            //         }

            //         $result_barcode = $datestr . $transactionNumber . $transaction->vehicle->vehicle_initial->id . $dayOfTheWeek;

            //         //qrcode / barcode
            //         $printer->setJustification(Printer::JUSTIFY_CENTER);
            //         $printer->barcode($result_barcode, Printer::BARCODE_UPCA);
            //         // $printer->qrCode($transaction->serial, Printer::QR_ECLEVEL_M, 12, printer::QR_MODEL_2);

            //         //qrcode serial
            //         // $printer->feed(1);
            //         // $printer->setJustification(Printer::JUSTIFY_CENTER);
            //         // $printer->text( $transaction->serial . " \n");
            //         $printer->feed(3);
            //     }

            // }

            if ($item->name == "Alamat") {
                if ($item->is_on == 1) {
                    //address
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->selectPrintMode(Printer::MODE_FONT_A);
                    $printer->text($site_gate_parking->address . "\n");
                    $printer->feed(1);
                }

            }

            if ($item->name == "Catatan") {
                if ($item->is_on == 1) {
                    //batas garis
                    if ($ModelsPrinter->paper_size == "80") {
                        $printer->textRaw(str_repeat(chr(196), 48) . PHP_EOL);
                    } else if ($ModelsPrinter->paper_size == "55") {
                        $printer->textRaw(str_repeat(chr(196), 32) . PHP_EOL);
                    }

                    //informasi catatan
                    $printer->feed(1);
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->text("Terimakasih Telah Berkunjung \n");
                    $printer->feed(3);
                }

            }

        }

        //printer cut
        $printer->cut();
        $printer->close();


        // return redirect('/gate/scanners/' . $id)->with('status', 'Profile updated!');
    }

    public function reportKendaraan(Request $request)
    {



        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('transactions.is_deleted', 0)->with('site_gate_parking')->with('vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate', 'vehicle', 'operator', 'no_polisi', 'visitor_type']))->get();
            $transaction_no_pol = transaction::where('transactions.is_deleted', 0)->orderBy('id', "DESC")->get()->unique('plat_number');
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('transactions.is_deleted', 0)->where('id', auth()->user()->id)->with('site_gate_parking')->with('vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate', 'vehicle', 'operator', 'no_polisi', 'visitor_type']))->get();
            $transaction_no_pol = transaction::where('transactions.is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get()->unique('plat_number');
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }


        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $User = User::where('role', '!=', 'admin')->orderBy('id', "DESC")->get();

        $vehicle = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $request->calendar_from == '' ? '' : $query->whereDate('date_in', '>=', $request->calendar_from);
                $request->calendar_to == '' ? '' : $query->whereDate('date_in', '<=', $request->calendar_to);
                $request->gate == '' ? '' : $query->where('site_gate_parking_id', $request->gate);
                $request->vehicle == '' ? '' : $query->where('vehicle_id', $request->vehicle);
                $request->operator == '' ? '' : $query->where('user_id', $request->operator);
                $request->no_polisi == '' ? '' : $query->where('plat_number', $request->no_polisi);
                $request->visitor_type == '' ? '' : $query->where('visitor_type', $request->visitor_type);
            }])
            ->get();

        $count_vehicle_overnight = array();

        foreach ($vehicle as $item) {
            $count_vehicle_overnight[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d < 1) {
                    $count_vehicle_overnight[$item->name] += 1;
                }
            }
        }

        // return $count_vehicle_overnight;


        $count_transaction_overnight = 0;
        foreach ($transaction as $item) {
            //calculate time
            $date1 = new DateTime($item->date_in);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            if ($interval->d < 1) {
                $count_transaction_overnight++;
            }
        }

        // return  $transaction_no_pol;
        return view('content.new.report.indexReportKendaraan', [
            'transaction' => $transaction,
            'count_transaction_overnight' => $count_transaction_overnight,
            'count_vehicle_overnight' => $count_vehicle_overnight,
            'vehicle' => $vehicle,
            'User' => $User,
            'transaction_no_pol' => $transaction_no_pol,
            'punishment' => $punishment,
            'site_gate_parking' => $site_gate_parking
        ]);
    }


    public function reportOvernight(Request $request)
    {

        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('transactions.is_deleted', 0)->with('site_gate_parking')->with('vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate', 'vehicle', 'operator', 'no_polisi', 'visitor_type']))->get();
            $transaction_no_pol = transaction::where('transactions.is_deleted', 0)->orderBy('id', "DESC")->get()->unique('plat_number');
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('transactions.is_deleted', 0)->where('id', auth()->user()->id)->with('site_gate_parking')->with('vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate', 'vehicle', 'operator', 'no_polisi', 'visitor_type']))->get();
            $transaction_no_pol = transaction::where('transactions.is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get()->unique('plat_number');
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }


        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $User = User::where('role', '!=', 'admin')->orderBy('id', "DESC")->get();

        $vehicle = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $request->calendar_from == '' ? '' : $query->whereDate('date_in', '>=', $request->calendar_from);
                $request->calendar_to == '' ? '' : $query->whereDate('date_in', '<=', $request->calendar_to);
                $request->gate == '' ? '' : $query->where('site_gate_parking_id', $request->gate);
                $request->vehicle == '' ? '' : $query->where('vehicle_id', $request->vehicle);
                $request->operator == '' ? '' : $query->where('user_id', $request->operator);
                $request->no_polisi == '' ? '' : $query->where('plat_number', $request->no_polisi);
                $request->visitor_type == '' ? '' : $query->where('visitor_type', $request->visitor_type);
            }])
            ->get();

        $count_vehicle_overnight = array();

        foreach ($vehicle as $item) {
            $count_vehicle_overnight[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d > 0) {
                    $count_vehicle_overnight[$item->name] += 1;
                }
            }
        }

        // return $count_vehicle_overnight;


        $count_transaction_overnight = 0;
        foreach ($transaction as $item) {
            //calculate time
            $date1 = new DateTime($item->date_in);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            if ($interval->d > 0) {
                $count_transaction_overnight++;
            }
        }


        // return  $vehicle;
        return view('content.new.report.indexReportOvernight', [
            'transaction' => $transaction,
            'count_transaction_overnight' => $count_transaction_overnight,
            'count_vehicle_overnight' => $count_vehicle_overnight,
            'vehicle' => $vehicle,
            'User' => $User,
            'transaction_no_pol' => $transaction_no_pol,
            'punishment' => $punishment,
            'site_gate_parking' => $site_gate_parking
        ]);
    }


    public function reportPendapatanParkir(Request $request)
    {

        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('transactions.is_deleted', 0)->where('visitor_type', 'Regular')->with('site_gate_parking')->with('vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('transactions.is_deleted', 0)->where('visitor_type', 'Regular')->where('id', auth()->user()->id)->with('site_gate_parking')->with('vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();




        //summary
        //daily
        $transaction_all_vehicle_today = transaction::whereDate('date_in', Carbon::now())->where('visitor_type', 'Regular')->get();
        $all_price_today = 0;
        foreach ($transaction_all_vehicle_today as $item) {
            //calculate time
            $date1 = new DateTime($item->date_in);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;

            if ($interval->d < 1 && $interval->h < 1 && $interval->i < (int) $item->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->vehicle->grace_time);
                $price = $grace_time;
            } elseif ($interval->d < 1 && $interval->h < 1 && $interval->i > (int) $item->vehicle->grace_time_duration) {
                $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                $price = $time_price_1;
            }

            if ($time_1 == 0) {
                if (60 + $interval->i >= $item->vehicle->limitation_time_duration) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->h * 60 + $interval->i >= 60 + $item->vehicle->limitation_time_duration) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->h * 60 + $interval->i >= 120 + $item->vehicle->limitation_time_duration) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_3);
                if ($interval->h <= 2) {
                    $price = $price + $time_price_3;
                } else {
                    $price = $price + $time_price_3 * ($interval->h - 1);
                }
            }

            if ($item->vehicle->maximum_daily >= 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                $price = $price + $maximum_daily_price * $interval->d;
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }

            $all_price_today = $all_price_today + $price;

        }

        $vehicle_today = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', Carbon::now());
                $query->where('visitor_type', 'Regular');

            }])
            ->get();

        $count_vehicle_today = array();

        foreach ($vehicle_today as $item) {
            $count_vehicle_today[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_today[$item->name] += 1;
                }
            }
        }

        // return $count_vehicle_overnight;

        //weekly
        $transaction_all_vehicle_weekly = transaction::whereDate('date_in', '>=', Carbon::now()->subDays(8)->toDateTimeString())->where('visitor_type', 'Regular')->get();
        $all_price_weekly = 0;
        foreach ($transaction_all_vehicle_weekly as $item) {
            //calculate time
            $date1 = new DateTime($item->date_in);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;

            if ($interval->d < 1 && $interval->h < 1 && $interval->i < (int) $item->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->vehicle->grace_time);
                $price = $grace_time;
            } elseif ($interval->d < 1 && $interval->h < 1 && $interval->i > (int) $item->vehicle->grace_time_duration) {
                $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                $price = $time_price_1;
            }

            if ($time_1 == 0) {
                if (60 + $interval->i >= $item->vehicle->limitation_time_duration) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->h * 60 + $interval->i >= 60 + $item->vehicle->limitation_time_duration) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->h * 60 + $interval->i >= 120 + $item->vehicle->limitation_time_duration) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_3);
                if ($interval->h <= 2) {
                    $price = $price + $time_price_3;
                } else {
                    $price = $price + $time_price_3 * ($interval->h - 1);
                }
            }

            if ($item->vehicle->maximum_daily >= 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                $price = $price + $maximum_daily_price * $interval->d;
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }

            $all_price_weekly = $all_price_weekly + $price;

        }

        $vehicle_weekly = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', '>=', Carbon::now()->subDays(8)->toDateTimeString());
                $query->where('visitor_type', 'Regular');

            }])
            ->get();

        $count_vehicle_weekly = array();

        foreach ($vehicle_weekly as $item) {
            $count_vehicle_weekly[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_weekly[$item->name] += 1;
                }
            }
        }

        //monthly
        $transaction_all_vehicle_monthly = transaction::whereDate('date_in', '>=', Carbon::now()->subDays(31)->toDateTimeString())->where('visitor_type', 'Regular')->get();
        $all_price_monthly = 0;
        foreach ($transaction_all_vehicle_monthly as $item) {
            //calculate time
            $date1 = new DateTime($item->date_in);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;
            if ($interval->d < 1 && $interval->h < 1 && $interval->i < (int) $item->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->vehicle->grace_time);
                $price = $grace_time;
            } elseif ($interval->d < 1 && $interval->h < 1 && $interval->i > (int) $item->vehicle->grace_time_duration) {
                $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                $price = $time_price_1;
            }

            if ($time_1 == 0) {
                if (60 + $interval->i >= $item->vehicle->limitation_time_duration) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->h * 60 + $interval->i >= 60 + $item->vehicle->limitation_time_duration) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->h * 60 + $interval->i >= 120 + $item->vehicle->limitation_time_duration) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_3);
                if ($interval->h <= 2) {
                    $price = $price + $time_price_3;
                } else {
                    $price = $price + $time_price_3 * ($interval->h - 1);
                }
            }

            if ($item->vehicle->maximum_daily >= 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                $price = $price + $maximum_daily_price * $interval->d;
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }
            $all_price_monthly = $all_price_monthly + $price;

        }

        $vehicle_monthly = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', '>=', Carbon::now()->subDays(31)->toDateTimeString());
                $query->where('visitor_type', 'Regular');

            }])
            ->get();

        $count_vehicle_monthly = array();

        foreach ($vehicle_monthly as $item) {
            $count_vehicle_monthly[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_monthly[$item->name] += 1;
                }
            }
        }

        //yearly
        $transaction_all_vehicle_yearly = transaction::whereDate('date_in', '>=', Carbon::now()->subDays(366)->toDateTimeString())->where('visitor_type', 'Regular')->get();
        $all_price_yearly = 0;
        foreach ($transaction_all_vehicle_yearly as $item) {
            //calculate time
            $date1 = new DateTime($item->date_in);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;
            if ($interval->d < 1 && $interval->h < 1 && $interval->i < (int) $item->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->vehicle->grace_time);
                $price = $grace_time;
            } elseif ($interval->d < 1 && $interval->h < 1 && $interval->i > (int) $item->vehicle->grace_time_duration) {
                $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                $price = $time_price_1;
            }

            if ($time_1 == 0) {
                if (60 + $interval->i >= $item->vehicle->limitation_time_duration) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->h * 60 + $interval->i >= 60 + $item->vehicle->limitation_time_duration) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->h * 60 + $interval->i >= 120 + $item->vehicle->limitation_time_duration) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_3);
                if ($interval->h <= 2) {
                    $price = $price + $time_price_3;
                } else {
                    $price = $price + $time_price_3 * ($interval->h - 1);
                }
            }

            if ($item->vehicle->maximum_daily >= 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                $price = $price + $maximum_daily_price * $interval->d;
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }
            $all_price_yearly = $all_price_yearly + $price;

        }

        $vehicle_yearly = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', '>=', Carbon::now()->subDays(366)->toDateTimeString());
                $query->where('visitor_type', 'Regular');

            }])
            ->get();

        $count_vehicle_yearly = array();

        foreach ($vehicle_yearly as $item) {
            $count_vehicle_yearly[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_yearly[$item->name] += 1;
                }
            }
        }

        $all_price_today = 'Rp ' . number_format($all_price_today);
        $all_price_weekly = 'Rp ' . number_format($all_price_weekly);
        $all_price_monthly = 'Rp ' . number_format($all_price_monthly);
        $all_price_yearly = 'Rp ' . number_format($all_price_yearly);


        // return count($transaction_all_vehicle_weekly);
        // return $transaction;

        return view('content.new.report.indexReportPendapatanParkir', [
            'all_price_today' => $all_price_today,
            'all_price_weekly' => $all_price_weekly,
            'all_price_monthly' => $all_price_monthly,
            'all_price_yearly' => $all_price_yearly,
            'transaction_all_vehicle_today' => $transaction_all_vehicle_today,
            'transaction_all_vehicle_weekly' => $transaction_all_vehicle_weekly,
            'transaction_all_vehicle_monthly' => $transaction_all_vehicle_monthly,
            'transaction_all_vehicle_yearly' => $transaction_all_vehicle_yearly,
            'count_vehicle_today' => $count_vehicle_today,
            'vehicle_today' => $vehicle_today,
            'count_vehicle_weekly' => $count_vehicle_weekly,
            'vehicle_weekly' => $vehicle_weekly,
            'count_vehicle_monthly' => $count_vehicle_monthly,
            'vehicle_monthly' => $vehicle_monthly,
            'count_vehicle_yearly' => $count_vehicle_yearly,
            'vehicle_yearly' => $vehicle_yearly,
            'transaction' => $transaction,
            'punishment' => $punishment,
            'site_gate_parking' => $site_gate_parking
        ]);
    }


    public function reportPendapatanMember(Request $request)
    {

        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('transactions.is_deleted', 0)->where('visitor_type', 'Member')->with('site_gate_parking')->with('vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('transactions.is_deleted', 0)->where('visitor_type', 'Member')->where('id', auth()->user()->id)->with('site_gate_parking')->with('vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        //summary
        //daily
        $transactionMemberLog_daily = transactionMemberLog::whereDate('created_at', Carbon::now())->get();
        $transaction_all_vehicle_today = transaction::whereDate('date_in', Carbon::now())->where('visitor_type', 'Member')->get();
        $all_price_today = 0;

        foreach ($transactionMemberLog_daily as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_today += $total_biaya;
        }

        $vehicle_today = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', Carbon::now());
                $query->where('visitor_type', 'Member');
            }])
            ->get();

        $count_vehicle_today = array();

        foreach ($vehicle_today as $item) {
            $count_vehicle_today[$item->name] = 0;

            foreach ($item->transaction as $item2) {

                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_today[$item->name] += 1;
                }
            }
        }

        // return $count_vehicle_overnight;

        //weekly
        $transactionMemberLog_weekly = transactionMemberLog::whereDate('created_at', '>=', Carbon::now()->subDays(8)->toDateTimeString())->get();
        $transaction_all_vehicle_weekly = transaction::whereDate('date_in', '>=', Carbon::now()->subDays(8)->toDateTimeString())->where('visitor_type', 'Member')->with('transaction_member')->get();
        $all_price_weekly = 0;
        // return  $transaction_all_vehicle_weekly;

        foreach ($transactionMemberLog_weekly as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_weekly += $total_biaya;
        }

        $vehicle_weekly = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', '>=', Carbon::now()->subDays(8)->toDateTimeString());
                $query->where('visitor_type', 'Member');
            }])
            ->get();

        $count_vehicle_weekly = array();

        foreach ($vehicle_weekly as $item) {
            $count_vehicle_weekly[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_weekly[$item->name] += 1;
                }
            }
        }

        //monthly
        $transactionMemberLog_monthly = transactionMemberLog::whereDate('created_at', '>=', Carbon::now()->subDays(31)->toDateTimeString())->get();
        $transaction_all_vehicle_monthly = transaction::whereDate('date_in', '>=', Carbon::now()->subDays(31)->toDateTimeString())->where('visitor_type', 'Member')->get();
        $all_price_monthly = 0;

        foreach ($transactionMemberLog_monthly as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_monthly += $total_biaya;
        }

        $vehicle_monthly = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', '>=', Carbon::now()->subDays(31)->toDateTimeString());
                $query->where('visitor_type', 'Member');

            }])
            ->get();

        $count_vehicle_monthly = array();

        foreach ($vehicle_monthly as $item) {
            $count_vehicle_monthly[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_monthly[$item->name] += 1;
                }
            }
        }

        //yearly
        $transactionMemberLog_yearly = transactionMemberLog::whereDate('created_at', '>=', Carbon::now()->subDays(366)->toDateTimeString())->get();
        $transaction_all_vehicle_yearly = transaction::whereDate('date_in', '>=', Carbon::now()->subDays(366)->toDateTimeString())->where('visitor_type', 'Member')->get();

        $all_price_yearly = 0;

        foreach ($transactionMemberLog_yearly as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_yearly += $total_biaya;
        }

        $vehicle_yearly = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', '>=', Carbon::now()->subDays(366)->toDateTimeString());
                $query->where('visitor_type', 'Member');

            }])
            ->get();

        $count_vehicle_yearly = array();

        foreach ($vehicle_yearly as $item) {
            $count_vehicle_yearly[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_yearly[$item->name] += 1;
                }
            }
        }

        $all_price_today = 'Rp ' . number_format($all_price_today);
        $all_price_weekly = 'Rp ' . number_format($all_price_weekly);
        $all_price_monthly = 'Rp ' . number_format($all_price_monthly);
        $all_price_yearly = 'Rp ' . number_format($all_price_yearly);


        // return count($transaction_all_vehicle_weekly);
        // return $transaction;

        return view('content.new.report.indexReportPendapatanMember', [
            'all_price_today' => $all_price_today,
            'all_price_weekly' => $all_price_weekly,
            'all_price_monthly' => $all_price_monthly,
            'all_price_yearly' => $all_price_yearly,
            'transaction_all_vehicle_today' => $transaction_all_vehicle_today,
            'transaction_all_vehicle_weekly' => $transaction_all_vehicle_weekly,
            'transaction_all_vehicle_monthly' => $transaction_all_vehicle_monthly,
            'transaction_all_vehicle_yearly' => $transaction_all_vehicle_yearly,
            'count_vehicle_today' => $count_vehicle_today,
            'vehicle_today' => $vehicle_today,
            'count_vehicle_weekly' => $count_vehicle_weekly,
            'vehicle_weekly' => $vehicle_weekly,
            'count_vehicle_monthly' => $count_vehicle_monthly,
            'vehicle_monthly' => $vehicle_monthly,
            'count_vehicle_yearly' => $count_vehicle_yearly,
            'vehicle_yearly' => $vehicle_yearly,
            'transaction' => $transaction,
            'punishment' => $punishment,
            'site_gate_parking' => $site_gate_parking
        ]);

    }


    public function reportPendapatanVoucher(Request $request)
    {

        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('transactions.is_deleted', 0)->where('visitor_type', 'Voucher')->with('site_gate_parking')->with('vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('transactions.is_deleted', 0)->where('visitor_type', 'Voucher')->where('id', auth()->user()->id)->with('site_gate_parking')->with('vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        //summary
        //daily
        $transactionVoucherLog_daily = transactionVoucherLog::whereDate('created_at', Carbon::now())->get();
        $transaction_all_vehicle_today = transaction::whereDate('date_in', Carbon::now())->where('visitor_type', 'Voucher')->get();
        $all_price_today = 0;

        foreach ($transactionVoucherLog_daily as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_today += $total_biaya;
        }

        $vehicle_today = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', Carbon::now());
                $query->where('visitor_type', 'Voucher');

            }])
            ->get();

        $count_vehicle_today = array();

        foreach ($vehicle_today as $item) {
            $count_vehicle_today[$item->name] = 0;

            foreach ($item->transaction as $item2) {

                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_today[$item->name] += 1;
                }
            }
        }

        // return $count_vehicle_overnight;

        //weekly
        $transactionVoucherLog_weekly = transactionVoucherLog::whereDate('created_at', '>=', Carbon::now()->subDays(8)->toDateTimeString())->get();
        $transaction_all_vehicle_weekly = transaction::whereDate('date_in', '>=', Carbon::now()->subDays(8)->toDateTimeString())->where('visitor_type', 'Voucher')->with('transaction_voucher')->get();
        $all_price_weekly = 0;
        // return  $transaction_all_vehicle_weekly;


        foreach ($transactionVoucherLog_weekly as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_weekly += $total_biaya;
        }

        $vehicle_weekly = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', '>=', Carbon::now()->subDays(8)->toDateTimeString());
                $query->where('visitor_type', 'Voucher');
            }])
            ->get();

        $count_vehicle_weekly = array();

        foreach ($vehicle_weekly as $item) {
            $count_vehicle_weekly[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_weekly[$item->name] += 1;
                }
            }
        }

        //monthly
        $transactionVoucherLog_monthly = transactionVoucherLog::whereDate('created_at', '>=', Carbon::now()->subDays(31)->toDateTimeString())->get();
        $transaction_all_vehicle_monthly = transaction::whereDate('date_in', '>=', Carbon::now()->subDays(31)->toDateTimeString())->where('visitor_type', 'Voucher')->get();
        $all_price_monthly = 0;

        foreach ($transactionVoucherLog_monthly as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_monthly += $total_biaya;
        }

        $vehicle_monthly = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', '>=', Carbon::now()->subDays(31)->toDateTimeString());
                $query->where('visitor_type', 'Voucher');

            }])
            ->get();

        $count_vehicle_monthly = array();

        foreach ($vehicle_monthly as $item) {
            $count_vehicle_monthly[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_monthly[$item->name] += 1;
                }
            }
        }

        //yearly
        $transactionVoucherLog_yearly = transactionVoucherLog::whereDate('created_at', '>=', Carbon::now()->subDays(366)->toDateTimeString())->get();
        $transaction_all_vehicle_yearly = transaction::whereDate('date_in', '>=', Carbon::now()->subDays(366)->toDateTimeString())->where('visitor_type', 'Voucher')->get();
        $all_price_yearly = 0;

        foreach ($transactionVoucherLog_yearly as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_yearly += $total_biaya;
        }

        $vehicle_yearly = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', '>=', Carbon::now()->subDays(366)->toDateTimeString());
                $query->where('visitor_type', 'Voucher');

            }])
            ->get();

        $count_vehicle_yearly = array();

        foreach ($vehicle_yearly as $item) {
            $count_vehicle_yearly[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_yearly[$item->name] += 1;
                }
            }
        }

        $all_price_today = 'Rp ' . number_format($all_price_today);
        $all_price_weekly = 'Rp ' . number_format($all_price_weekly);
        $all_price_monthly = 'Rp ' . number_format($all_price_monthly);
        $all_price_yearly = 'Rp ' . number_format($all_price_yearly);


        // return count($transaction_all_vehicle_weekly);
        // return $transaction;

        return view('content.new.report.indexReportPendapatanVoucher', [
            'all_price_today' => $all_price_today,
            'all_price_weekly' => $all_price_weekly,
            'all_price_monthly' => $all_price_monthly,
            'all_price_yearly' => $all_price_yearly,
            'transaction_all_vehicle_today' => $transaction_all_vehicle_today,
            'transaction_all_vehicle_weekly' => $transaction_all_vehicle_weekly,
            'transaction_all_vehicle_monthly' => $transaction_all_vehicle_monthly,
            'transaction_all_vehicle_yearly' => $transaction_all_vehicle_yearly,
            'count_vehicle_today' => $count_vehicle_today,
            'vehicle_today' => $vehicle_today,
            'count_vehicle_weekly' => $count_vehicle_weekly,
            'vehicle_weekly' => $vehicle_weekly,
            'count_vehicle_monthly' => $count_vehicle_monthly,
            'vehicle_monthly' => $vehicle_monthly,
            'count_vehicle_yearly' => $count_vehicle_yearly,
            'vehicle_yearly' => $vehicle_yearly,
            'transaction' => $transaction,
            'punishment' => $punishment,
            'site_gate_parking' => $site_gate_parking
        ]);

    }


    public function reportPendapatanGabungan(Request $request)
    {

        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('transactions.is_deleted', 0)->with('site_gate_parking')->with('vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('transactions.is_deleted', 0)->where('id', auth()->user()->id)->with('site_gate_parking')->with('vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }


        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();



        //summary
        //daily
        $transaction_all_vehicle_today = transaction::whereDate('date_in', Carbon::now())->get();
        $all_price_today = 0;

        //price pendapatan parkir
        foreach ($transaction_all_vehicle_today as $item) {
            //calculate time
            $date1 = new DateTime($item->date_in);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;

            if ($interval->d < 1 && $interval->h < 1 && $interval->i < (int) $item->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->vehicle->grace_time);
                $price = $grace_time;
            } elseif ($interval->d < 1 && $interval->h < 1 && $interval->i > (int) $item->vehicle->grace_time_duration) {
                $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                $price = $time_price_1;
            }

            if ($time_1 == 0) {
                if (60 + $interval->i >= $item->vehicle->limitation_time_duration) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->h * 60 + $interval->i >= 60 + $item->vehicle->limitation_time_duration) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->h * 60 + $interval->i >= 120 + $item->vehicle->limitation_time_duration) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_3);
                if ($interval->h <= 2) {
                    $price = $price + $time_price_3;
                } else {
                    $price = $price + $time_price_3 * ($interval->h - 1);
                }
            }

            if ($item->vehicle->maximum_daily >= 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                $price = $price + $maximum_daily_price * $interval->d;
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }

            $all_price_today = $all_price_today + $price;

        }

        //price member
        $transactionMemberLog_daily = transactionMemberLog::whereDate('created_at', Carbon::now())->get();
        foreach ($transactionMemberLog_daily as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_today += $total_biaya;
        }

        //price voucher
        $transactionVoucherLog_daily = transactionVoucherLog::whereDate('created_at', Carbon::now())->get();
        foreach ($transactionVoucherLog_daily as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_today += $total_biaya;
        }


        $vehicle_today = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', Carbon::now());
            }])
            ->get();

        $count_vehicle_today = array();

        foreach ($vehicle_today as $item) {
            $count_vehicle_today[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_today[$item->name] += 1;
                }
            }
        }

        // return $count_vehicle_overnight;

        //weekly
        $transaction_all_vehicle_weekly = transaction::whereDate('date_in', '>=', Carbon::now()->subDays(8)->toDateTimeString())->get();
        $all_price_weekly = 0;

        //price pendapatan parkir
        foreach ($transaction_all_vehicle_weekly as $item) {
            //calculate time
            $date1 = new DateTime($item->date_in);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;

            if ($interval->d < 1 && $interval->h < 1 && $interval->i < (int) $item->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->vehicle->grace_time);
                $price = $grace_time;
            } elseif ($interval->d < 1 && $interval->h < 1 && $interval->i > (int) $item->vehicle->grace_time_duration) {
                $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                $price = $time_price_1;
            }

            if ($time_1 == 0) {
                if (60 + $interval->i >= $item->vehicle->limitation_time_duration) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->h * 60 + $interval->i >= 60 + $item->vehicle->limitation_time_duration) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->h * 60 + $interval->i >= 120 + $item->vehicle->limitation_time_duration) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_3);
                if ($interval->h <= 2) {
                    $price = $price + $time_price_3;
                } else {
                    $price = $price + $time_price_3 * ($interval->h - 1);
                }
            }

            if ($item->vehicle->maximum_daily >= 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                $price = $price + $maximum_daily_price * $interval->d;
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }
            $all_price_weekly = $all_price_weekly + $price;

        }

        //price member
        $transactionMemberLog_weekly = transactionMemberLog::whereDate('created_at', '>=', Carbon::now()->subDays(8)->toDateTimeString())->get();
        foreach ($transactionMemberLog_weekly as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_weekly += $total_biaya;
        }


        //price voucher
        $transactionVoucherLog_weekly = transactionVoucherLog::whereDate('created_at', '>=', Carbon::now()->subDays(8)->toDateTimeString())->get();
        foreach ($transactionVoucherLog_weekly as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_weekly += $total_biaya;
        }

        $vehicle_weekly = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', '>=', Carbon::now()->subDays(8)->toDateTimeString());
            }])
            ->get();

        $count_vehicle_weekly = array();

        foreach ($vehicle_weekly as $item) {
            $count_vehicle_weekly[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_weekly[$item->name] += 1;
                }
            }
        }

        //monthly
        $transaction_all_vehicle_monthly = transaction::whereDate('date_in', '>=', Carbon::now()->subDays(31)->toDateTimeString())->get();
        $all_price_monthly = 0;

        //price pendapatan parkir
        foreach ($transaction_all_vehicle_monthly as $item) {
            //calculate time
            $date1 = new DateTime($item->date_in);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;
            if ($interval->d < 1 && $interval->h < 1 && $interval->i < (int) $item->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->vehicle->grace_time);
                $price = $grace_time;
            } elseif ($interval->d < 1 && $interval->h < 1 && $interval->i > (int) $item->vehicle->grace_time_duration) {
                $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                $price = $time_price_1;
            }

            if ($time_1 == 0) {
                if (60 + $interval->i >= $item->vehicle->limitation_time_duration) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->h * 60 + $interval->i >= 60 + $item->vehicle->limitation_time_duration) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->h * 60 + $interval->i >= 120 + $item->vehicle->limitation_time_duration) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_3);
                if ($interval->h <= 2) {
                    $price = $price + $time_price_3;
                } else {
                    $price = $price + $time_price_3 * ($interval->h - 1);
                }
            }

            if ($item->vehicle->maximum_daily >= 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                $price = $price + $maximum_daily_price * $interval->d;
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }
            $all_price_monthly = $all_price_monthly + $price;

        }

        //price member
        $transactionMemberLog_monthly = transactionMemberLog::whereDate('created_at', '>=', Carbon::now()->subDays(31)->toDateTimeString())->get();
        foreach ($transactionMemberLog_monthly as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_monthly += $total_biaya;
        }

        //price voucher
        $transactionVoucherLog_monthly = transactionVoucherLog::whereDate('created_at', '>=', Carbon::now()->subDays(31)->toDateTimeString())->get();
        foreach ($transactionVoucherLog_monthly as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_monthly += $total_biaya;
        }

        $vehicle_monthly = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', '>=', Carbon::now()->subDays(31)->toDateTimeString());
            }])
            ->get();

        $count_vehicle_monthly = array();

        foreach ($vehicle_monthly as $item) {
            $count_vehicle_monthly[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_monthly[$item->name] += 1;
                }
            }
        }

        //yearly
        $transaction_all_vehicle_yearly = transaction::whereDate('date_in', '>=', Carbon::now()->subDays(366)->toDateTimeString())->get();
        $all_price_yearly = 0;

        //price pendapatan parkir
        foreach ($transaction_all_vehicle_yearly as $item) {
            //calculate time
            $date1 = new DateTime($item->date_in);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;
            if ($interval->d < 1 && $interval->h < 1 && $interval->i < (int) $item->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->vehicle->grace_time);
                $price = $grace_time;
            } elseif ($interval->d < 1 && $interval->h < 1 && $interval->i > (int) $item->vehicle->grace_time_duration) {
                $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                $price = $time_price_1;
            }

            if ($time_1 == 0) {
                if (60 + $interval->i >= $item->vehicle->limitation_time_duration) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->h * 60 + $interval->i >= 60 + $item->vehicle->limitation_time_duration) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->h * 60 + $interval->i >= 120 + $item->vehicle->limitation_time_duration) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_3);
                if ($interval->h <= 2) {
                    $price = $price + $time_price_3;
                } else {
                    $price = $price + $time_price_3 * ($interval->h - 1);
                }
            }

            if ($item->vehicle->maximum_daily >= 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                $price = $price + $maximum_daily_price * $interval->d;
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }
            $all_price_yearly = $all_price_yearly + $price;

        }

        //price member
        $transactionMemberLog_yearly = transactionMemberLog::whereDate('created_at', '>=', Carbon::now()->subDays(366)->toDateTimeString())->get();
        foreach ($transactionMemberLog_yearly as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_yearly += $total_biaya;
        }

        //price voucher
        $transactionVoucherLog_yearly = transactionVoucherLog::whereDate('created_at', '>=', Carbon::now()->subDays(366)->toDateTimeString())->get();
        foreach ($transactionVoucherLog_yearly as $item) {
            $total_biaya = (int) str_replace(['.', 'Rp'], '', $item->Total_Biaya);
            $all_price_yearly += $total_biaya;
        }

        $vehicle_yearly = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")
            ->with(["transaction" => function ($query) use ($request) {
                $query->whereDate('date_in', '>=', Carbon::now()->subDays(366)->toDateTimeString());
            }])
            ->get();

        $count_vehicle_yearly = array();

        foreach ($vehicle_yearly as $item) {
            $count_vehicle_yearly[$item->name] = 0;

            foreach ($item->transaction as $item2) {
                //calculate time
                $date1 = new DateTime($item2->date_in);
                $date2 = new DateTime($item2->date_out);
                $interval = $date1->diff($date2);

                if ($interval->d >= 0) {
                    $count_vehicle_yearly[$item->name] += 1;
                }
            }
        }

        $all_price_today = 'Rp ' . number_format($all_price_today);
        $all_price_weekly = 'Rp ' . number_format($all_price_weekly);
        $all_price_monthly = 'Rp ' . number_format($all_price_monthly);
        $all_price_yearly = 'Rp ' . number_format($all_price_yearly);


        // return count($transaction_all_vehicle_weekly);
        // return $transaction;

        return view('content.new.report.indexReportPendapatanGabungan', [
            'all_price_today' => $all_price_today,
            'all_price_weekly' => $all_price_weekly,
            'all_price_monthly' => $all_price_monthly,
            'all_price_yearly' => $all_price_yearly,
            'transaction_all_vehicle_today' => $transaction_all_vehicle_today,
            'transaction_all_vehicle_weekly' => $transaction_all_vehicle_weekly,
            'transaction_all_vehicle_monthly' => $transaction_all_vehicle_monthly,
            'transaction_all_vehicle_yearly' => $transaction_all_vehicle_yearly,
            'count_vehicle_today' => $count_vehicle_today,
            'vehicle_today' => $vehicle_today,
            'count_vehicle_weekly' => $count_vehicle_weekly,
            'vehicle_weekly' => $vehicle_weekly,
            'count_vehicle_monthly' => $count_vehicle_monthly,
            'vehicle_monthly' => $vehicle_monthly,
            'count_vehicle_yearly' => $count_vehicle_yearly,
            'vehicle_yearly' => $vehicle_yearly,
            'transaction' => $transaction,
            'punishment' => $punishment,
            'site_gate_parking' => $site_gate_parking
        ]);
    }


    public function reportPembatalanTransaksi(Request $request)
    {

        if ($request->calendar != '') {

            $transaction_all_vehicle = DB::table('transactions')
                ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
                ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
                ->select('vehicles.name', 'site_gate_parkings.name as gate_name')
                ->whereDate('transactions.created_at', $request->calendar)
                ->where('site_gate_parkings.name', $request->gate)
                ->get();
        } else {
            $transaction_all_vehicle = DB::table('transactions')
                ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
                ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
                ->select('vehicles.name')
                ->get();
        }

        if ($request->calendar != '') {
            $transaction_all_vehicle_unique = DB::table('transactions')
                ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
                ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
                ->select('vehicles.name', DB::raw('COUNT(vehicles.name) as count'))
                ->groupBy('vehicles.name')
                ->whereDate('transactions.created_at', $request->calendar)
                ->get()
                ->unique('name');
        } else {
            $transaction_all_vehicle_unique = DB::table('transactions')
                ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
                ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
                ->select('vehicles.name', DB::raw('COUNT(vehicles.name) as count'))
                ->groupBy('vehicles.name')
                ->get()
                ->unique('name');
        }

        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('transactions.is_deleted', 0)->with('site_gate_parking.vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('transactions.is_deleted', 0)->where('id', auth()->user()->id)->with('site_gate_parking.vehicle')->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate']))->get();
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();


        //summary
        //daily
        $transaction_all_vehicle_today = transaction::whereDate('created_at', Carbon::now())->get();
        $all_price_today = 0;
        foreach ($transaction_all_vehicle_today as $item) {
            //calculate time
            $date1 = new DateTime($item->created_at);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;

            if ($interval->h < 1 && $interval->m < (int) $item->site_gate_parking->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->grace_time);
                $price = $grace_time;
            }

            if ($time_1 == 0) {
                if ($interval->d < 1 && $interval->h > 0) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->d < 1 && $interval->h > 1) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->d < 1 && $interval->h > 2) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_3);
                $price = $price + $time_price_3 * ($interval->h - 2);
            }

            if ($item->site_gate_parking->vehicle->maximum_daily == 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                if ($price > $maximum_daily_price) {
                    $price = $maximum_daily_price;
                }
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }
            $all_price_today = $all_price_today + $price;

        }

        //weekly
        $transaction_all_vehicle_weekly = transaction::whereDate('created_at', '>=', Carbon::now()->subDays(8)->toDateTimeString())->get();
        $all_price_weekly = 0;
        foreach ($transaction_all_vehicle_weekly as $item) {
            //calculate time
            $date1 = new DateTime($item->created_at);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;

            if ($interval->h < 1 && $interval->m < (int) $item->site_gate_parking->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->grace_time);
                $price = $grace_time;
            }

            if ($time_1 == 0) {
                if ($interval->d < 1 && $interval->h > 0) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->d < 1 && $interval->h > 1) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->d < 1 && $interval->h > 2) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_3);
                $price = $price + $time_price_3 * ($interval->h - 2);
            }

            if ($item->site_gate_parking->vehicle->maximum_daily == 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                if ($price > $maximum_daily_price) {
                    $price = $maximum_daily_price;
                }
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }
            $all_price_weekly = $all_price_weekly + $price;

        }

        //monthly
        $transaction_all_vehicle_monthly = transaction::whereDate('created_at', '>=', Carbon::now()->subDays(31)->toDateTimeString())->get();
        $all_price_monthly = 0;
        foreach ($transaction_all_vehicle_monthly as $item) {
            //calculate time
            $date1 = new DateTime($item->created_at);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;

            if ($interval->h < 1 && $interval->m < (int) $item->site_gate_parking->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->grace_time);
                $price = $grace_time;
            }

            if ($time_1 == 0) {
                if ($interval->d < 1 && $interval->h > 0) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->d < 1 && $interval->h > 1) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->d < 1 && $interval->h > 2) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_3);
                $price = $price + $time_price_3 * ($interval->h - 2);
            }

            if ($item->site_gate_parking->vehicle->maximum_daily == 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                if ($price > $maximum_daily_price) {
                    $price = $maximum_daily_price;
                }
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }
            $all_price_monthly = $all_price_monthly + $price;

        }

        //yearly
        $transaction_all_vehicle_yearly = transaction::whereDate('created_at', '>=', Carbon::now()->subDays(366)->toDateTimeString())->get();
        $all_price_yearly = 0;
        foreach ($transaction_all_vehicle_yearly as $item) {
            //calculate time
            $date1 = new DateTime($item->created_at);
            $date2 = new DateTime($item->date_out);
            $interval = $date1->diff($date2);

            $price = 0;
            $time_1 = 0;
            $time_2 = 0;

            if ($interval->h < 1 && $interval->m < (int) $item->site_gate_parking->vehicle->grace_time_duration) {
                $grace_time = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->grace_time);
                $price = $grace_time;
            }

            if ($time_1 == 0) {
                if ($interval->d < 1 && $interval->h > 0) {
                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_1);
                    $price = $price + $time_price_1;
                }
                $time_1++;
            }

            if ($time_2 == 0) {
                if ($interval->d < 1 && $interval->h > 1) {
                    $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_2);
                    $price = $price + $time_price_2;
                }
                $time_2++;
            }

            if ($interval->d < 1 && $interval->h > 2) {
                $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_3);
                $price = $price + $time_price_3 * ($interval->h - 2);
            }

            if ($item->site_gate_parking->vehicle->maximum_daily == 1) {
                $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                if ($price > $maximum_daily_price) {
                    $price = $maximum_daily_price;
                }
            }

            foreach ($punishment as $item2) {
                if ($item2->name == $item->status) {
                    $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                    $price = $price + $punishment_price;
                }
            }
            $all_price_yearly = $all_price_yearly + $price;

        }

        $all_price_today = 'Rp ' . number_format($all_price_today);
        $all_price_weekly = 'Rp ' . number_format($all_price_weekly);
        $all_price_monthly = 'Rp ' . number_format($all_price_monthly);
        $all_price_yearly = 'Rp ' . number_format($all_price_yearly);


        // return count($transaction_all_vehicle_weekly);
        // return $transaction;

        return view('content.new.report.indexReportPembatalanTransaksi', [
            'all_price_today' => $all_price_today,
            'all_price_weekly' => $all_price_weekly,
            'all_price_monthly' => $all_price_monthly,
            'all_price_yearly' => $all_price_yearly,
            'transaction_all_vehicle_today' => $transaction_all_vehicle_today,
            'transaction_all_vehicle_weekly' => $transaction_all_vehicle_weekly,
            'transaction_all_vehicle_monthly' => $transaction_all_vehicle_monthly,
            'transaction_all_vehicle_yearly' => $transaction_all_vehicle_yearly,
            'transaction' => $transaction,
            'punishment' => $punishment,
            'transaction_all_vehicle' => $transaction_all_vehicle,
            'transaction_all_vehicle_unique' => $transaction_all_vehicle_unique,
            'site_gate_parking' => $site_gate_parking
        ]);
    }


    public function transactionRegular(Request $request)
    {


        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('transactions.is_deleted', 0)
                ->where('visitor_type', 'Regular')
                ->with('site_gate_parking')->with('vehicle')
                ->orderBy('id', "DESC")
                ->filter(request(['calendar_from', 'calendar_to', 'gate', 'vehicle', 'operator', 'no_polisi', 'visitor_type']))
                ->get();
            $transaction_no_pol = transaction::where('transactions.is_deleted', 0)->orderBy('id', "DESC")->get()->unique('plat_number');
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('transactions.is_deleted', 0)
                ->where('visitor_type', 'Regular')
                ->where('id', auth()->user()->id)
                ->with('site_gate_parking')->with('vehicle')
                ->orderBy('id', "DESC")->filter(request(['calendar_from', 'calendar_to', 'gate', 'vehicle', 'operator', 'no_polisi', 'visitor_type']))
                ->get();
            $transaction_no_pol = transaction::where('transactions.is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get()->unique('plat_number');
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }


        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $User = User::where('role', '!=', 'admin')->orderBy('id', "DESC")->get();
        $vehicle = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $printer = ModelsPrinter::where('is_deleted', 0)->orderBy('id', "DESC")->get();


        // return  $transaction_no_pol;
        return view('content.new.transactionDetail.indexReportPendapatanParkir', [
            'transaction' => $transaction,
            'vehicle' => $vehicle,
            'User' => $User,
            'printer' => $printer,
            'transaction_no_pol' => $transaction_no_pol,
            'punishment' => $punishment,
            'site_gate_parking' => $site_gate_parking
        ]);

    }


    public function transactionMember(Request $request)
    {

        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('transactions.is_deleted', 0)
                ->where('visitor_type', 'Member')
                ->with('site_gate_parking')->with('vehicle')
                ->orderBy('id', "DESC")
                ->filter(request(['calendar_from', 'calendar_to', 'gate', 'vehicle', 'operator', 'no_polisi', 'visitor_type']))
                ->get();
            $transaction_no_pol = transaction::where('transactions.is_deleted', 0)->orderBy('id', "DESC")->get()->unique('plat_number');
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('transactions.is_deleted', 0)
                ->where('visitor_type', 'Member')
                ->where('id', auth()->user()->id)
                ->with('site_gate_parking')
                ->with('vehicle')
                ->orderBy('id', "DESC")
                ->filter(request(['calendar_from', 'calendar_to', 'gate', 'vehicle', 'operator', 'no_polisi', 'visitor_type']))
                ->get();
            $transaction_no_pol = transaction::where('transactions.is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get()->unique('plat_number');
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }


        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $User = User::where('role', '!=', 'admin')->orderBy('id', "DESC")->get();
        $vehicle = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $printer = ModelsPrinter::where('is_deleted', 0)->orderBy('id', "DESC")->get();


        // return  $transaction_no_pol;
        return view('content.new.transactionDetail.indexReportPendapatanMember', [
            'transaction' => $transaction,
            'vehicle' => $vehicle,
            'User' => $User,
            'printer' => $printer,
            'transaction_no_pol' => $transaction_no_pol,
            'punishment' => $punishment,
            'site_gate_parking' => $site_gate_parking
        ]);

    }

    public function transactionVoucher(Request $request)
    {

        if (auth()->user()->role == 'admin') {
            $transaction = transaction::where('transactions.is_deleted', 0)
                ->where('visitor_type', 'Voucher')
                ->with('site_gate_parking')
                ->with('vehicle')
                ->orderBy('id', "DESC")
                ->filter(request(['calendar_from', 'calendar_to', 'gate', 'vehicle', 'operator', 'no_polisi', 'visitor_type']))
                ->get();
            $transaction_no_pol = transaction::where('transactions.is_deleted', 0)->orderBy('id', "DESC")->get()->unique('plat_number');
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $transaction = transaction::where('transactions.is_deleted', 0)
                ->where('visitor_type', 'Voucher')
                ->where('id', auth()->user()->id)->with('site_gate_parking')
                ->with('vehicle')
                ->orderBy('id', "DESC")
                ->filter(request(['calendar_from', 'calendar_to', 'gate', 'vehicle', 'operator', 'no_polisi', 'visitor_type']))
                ->get();
            $transaction_no_pol = transaction::where('transactions.is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get()->unique('plat_number');
            $site_gate_parking = site_gate_parking::where('is_deleted', 0)->where('id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }


        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $User = User::where('role', '!=', 'admin')->orderBy('id', "DESC")->get();
        $vehicle = vehicle::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        $printer = ModelsPrinter::where('is_deleted', 0)->orderBy('id', "DESC")->get();


        // return  $transaction_no_pol;
        return view('content.new.transactionDetail.indexReportPendapatanVoucher', [
            'transaction' => $transaction,
            'vehicle' => $vehicle,
            'User' => $User,
            'printer' => $printer,
            'transaction_no_pol' => $transaction_no_pol,
            'punishment' => $punishment,
            'site_gate_parking' => $site_gate_parking
        ]);

    }


}
