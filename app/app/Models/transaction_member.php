<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction_member extends Model
{
    use HasFactory;
    // protected $guarded = ['id'];
    protected $guarded = [''];


    public function member()
    {
        return $this->belongsTo(member::class);
    }

    public function member_plat_number()
    {
        return $this->hasMany(member_plat_number::class);
    }

}
