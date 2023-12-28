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
        Schema::create('transaction_member_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('serial');
            $table->string('Nama');
            $table->string('Akses');
            $table->string('Hp');
            $table->string('Email');
            $table->string('Tarif_Dasar_Member');
            $table->string('Tarif_Member');
            $table->string('Tarif_Kartu');
            $table->string('Awal_Aktif');
            $table->string('Akhir_Aktif');
            $table->string('Total_Biaya');
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
        Schema::dropIfExists('transaction_member_logs');
    }
};
