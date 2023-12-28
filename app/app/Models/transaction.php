<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class transaction extends Model
{
    use HasFactory;
    // protected $guarded = ['id'];
    protected $guarded = [''];


    public function scopeFilter($query, array $filters)
    {
        // if (isset($filters['search']) ? $filters['search'] : false) {
        //     return $query->where('name_guests', 'like', '%' . $filters['search'] . '%');
        // }

        $query->when($filters['calendar_from'] ?? false, function ($query, $calendar_from) {
            return $query->whereDate('transactions.date_in', '>=', date('Y-m-d', strtotime($calendar_from)));
        });

        $query->when($filters['calendar_to'] ?? false, function ($query, $calendar_to) {
            return $query->whereDate('transactions.date_in', '<=', date('Y-m-d', strtotime($calendar_to)));
        });

        $query->when($filters['gate'] ?? false, function ($query, $gate) {
            return $query->where('transactions.site_gate_parking_id', $gate);
        });

        $query->when($filters['vehicle'] ?? false, function ($query, $vehicle) {
            return $query->where('transactions.vehicle_id', $vehicle);
        });

        $query->when($filters['operator'] ?? false, function ($query, $operator) {
            return $query->where('transactions.user_id', $operator);
        });

        $query->when($filters['no_polisi'] ?? false, function ($query, $no_polisi) {
            return $query->where('transactions.plat_number', $no_polisi);
        });

        $query->when($filters['visitor_type'] ?? false, function ($query, $visitor_type) {
            return $query->where('transactions.visitor_type', $visitor_type);
        });


    }

    public function site_gate_parking()
    {
        return $this->belongsTo(site_gate_parking::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(vehicle::class);
    }

    public function transaction_member()
    {
        return $this->belongsTo(transaction_member::class);
    }

    public function transaction_voucher()
    {
        return $this->belongsTo(transaction_voucher::class);
    }

}
