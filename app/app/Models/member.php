<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class member extends Model
{
    // use HasFactory;
    // protected $guarded = ['id'];
    protected $guarded = [''];

    public function vehicle()
    {
        return $this->belongsTo(vehicle::class);
    }

}
