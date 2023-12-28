<?php

use App\Models\manlessPayment;
use App\Models\site_gate_parking;
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
        Schema::create('site_gate_parking_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(manlessPayment::class);
            $table->foreignIdFor(site_gate_parking::class);
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
        Schema::dropIfExists('site_gate_parking_payments');
    }
};
