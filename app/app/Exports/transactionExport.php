<?php

namespace App\Exports;

use App\Models\punishment;
use App\Models\transaction;
use DateTime;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class transactionExport implements FromCollection, WithHeadings
// class transactionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $visitor_type;

    function __construct($visitor_type) {
        $this->visitor_type = $visitor_type;
    }

    // ->where('guest_forms.event_id' , decrypt($this->event_id))


    public function collection()
    {
        

        if(auth()->user()->role == 'admin')
        {
            $transaction = DB::table('transactions')
            ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
            ->join('vehicles', 'vehicles.id', '=', 'transactions.vehicle_id')
            ->select( 
                'transactions.id', 
                'transactions.number',
                'transactions.plat_number',
                'transactions.visitor_type',
                'transactions.payment_method',
                'transactions.status',
                'transactions.gate_out',
                'transactions.date_out',
                'transactions.date_in',
                'site_gate_parkings.name as Gerbang Parkir',
                'vehicles.name as Jenis Kendaraan',
            )
            ->where('transactions.is_deleted', 0)
            ->where('transactions.visitor_type', $this->visitor_type)
            ->get();
        }
        else
        {
            $transaction = DB::table('transactions')
            ->join('site_gate_parkings', 'site_gate_parkings.id', '=', 'transactions.site_gate_parking_id')
            ->join('vehicles', 'vehicles.id', '=', 'site_gate_parkings.vehicle_id')
            ->select( 
                'transactions.id', 
                'transactions.number',
                'transactions.plat_number',
                'transactions.visitor_type',
                'transactions.payment_method',
                'transactions.status',
                'transactions.date_out',
                'transactions.date_in',
                'site_gate_parkings.name as Gerbang Parkir',
                'transactions.gate_out',
                'vehicles.name as Jenis Kendaraan',
            )
            ->where('transactions.is_deleted', 0)
            ->where('transactions.id', auth()->user()->id)
            ->where('transactions.visitor_type', $this->visitor_type)
            ->get();
        }

        return $transaction ;
    }

    

     public function headings(): array
    {
        return [
            "id",
            "Number Kehadiran",
            "Nomor Polisi",
            "Jenis Pengunjung",
            "Jenis Pembayaran",
            "Status",
            "waktu Keluar",
            "waktu Masuk",
            "Pintu Masuk",
            "Pintu Keluar",
            "Jenis Kendaraan",
        ];
    }
}
