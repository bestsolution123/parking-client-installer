<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siteGateParkingPayment extends Model
{
    use HasFactory;
    // protected $guarded = ['id'];
    protected $guarded = [''];


    public function manlessPayment()
    {
        return $this->belongsTo(manlessPayment::class);
    }

}
