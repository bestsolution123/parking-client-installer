<?php

use App\Models\transaction_voucher;
use App\Models\voucher_plat_number;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_plat_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(transaction_voucher::class);
            $table->string('plat_number');
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_plat_numbers');
    }
};
