<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction_voucher extends Model
{
    use HasFactory;
    // protected $guarded = ['id'];
    protected $guarded = [''];


    public function voucher()
    {
        return $this->belongsTo(voucher::class);
    }

    public function voucher_plat_number()
    {
        return $this->hasMany(voucher_plat_number::class);
    }

}
