<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class site_gate_parking extends Model
{
    use HasFactory;
    // protected $guarded = ['id'];
    protected $guarded = [''];


    public function printer()
    {
        return $this->belongsTo(printer::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(vehicle::class);
    }

    public function printer_setting()
    {
        return $this->hasMany(printer_setting::class);
    }

    public function siteGateParkingPayment()
    {
        return $this->hasMany(siteGateParkingPayment::class);
    }


    public function manlessPayment()
    {
        return $this->belongsTo(manlessPayment::class);
    }

}
