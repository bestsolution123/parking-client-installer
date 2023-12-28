<?php

use App\Models\User;
use App\Models\vehicle;
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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('Nama');
            $table->string('Periode');
            // $table->string('Kendaraan');
            $table->foreignIdFor(vehicle::class);
            $table->string('Tarif');
            $table->string('Model_Pembayaran');
            $table->string('Metode_Verifikasi');
            $table->string('Status');
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
        Schema::dropIfExists('vouchers');
    }
};
