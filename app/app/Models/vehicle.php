<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicle extends Model
{
    use HasFactory;
    // protected $guarded = ['id'];
    protected $guarded = [''];


    public function vehicle_initial()
    {
        return $this->belongsTo(vehicle_initial::class);
    }

    public function transaction()
    {
        return $this->hasMany(transaction::class);
    }

}
