<?php

use App\Models\User;
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
        Schema::create('transaction_voucher_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('serial');
            $table->string('Produk');
            $table->string('Tarif');
            $table->string('Tarif_Dasar_Voucher');
            $table->string('Total_Biaya');
            $table->string('Awal_Aktif');
            $table->string('Akhir_Aktif');
            $table->string('Keterangan');
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
        Schema::dropIfExists('transaction_voucher_logs');
    }
};
