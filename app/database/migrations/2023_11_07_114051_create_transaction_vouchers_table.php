<?php

use App\Models\User;
use App\Models\voucher;
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
        Schema::create('transaction_vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(voucher::class);
            $table->string('serial');
            $table->string('Produk');
            // $table->string('Akses');
            // $table->string('Plat_Number');
            // $table->string('Tiket');
            $table->string('Tarif');
            $table->string('Tarif_Dasar_Voucher');
            $table->string('Total_Biaya');
            // $table->string('Periode');
            // $table->string('Model_Bayar');
            $table->string('Awal_Aktif');
            $table->string('Akhir_Aktif');
            // $table->string('Kendaraan');
            // $table->string('Verifikasi');
            $table->string('Keterangan');
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
        Schema::dropIfExists('transaction_vouchers');
    }
};
