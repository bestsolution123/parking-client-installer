<?php

use App\Models\member;
use App\Models\site_gate_parking;
use App\Models\transaction_member;
use App\Models\transaction_voucher;
use App\Models\User;
use App\Models\vehicle;
use App\Models\voucher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(site_gate_parking::class);
            $table->foreignIdFor(transaction_voucher::class);
            $table->foreignIdFor(transaction_member::class);
            $table->foreignIdFor(vehicle::class);
            $table->string('serial');
            $table->string('number');
            $table->string('plat_number');
            $table->string('in_photo');
            $table->string('out_photo');
            $table->string('visitor_type');
            $table->string('payment_method');
            $table->string('payment_type');
            $table->string('status');
            $table->string('gate_out');
            $table->string('timeZone');
            $table->dateTime('date_out', $precision = 0);
            $table->dateTime('date_in', $precision = 0);
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
        Schema::dropIfExists('transactions');
    }
};
