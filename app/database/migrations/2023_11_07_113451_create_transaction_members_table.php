<?php

use App\Models\member;
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
        Schema::create('transaction_members', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(member::class);
            $table->string('serial');
            $table->string('Nama');
            // $table->string('Member');
            $table->string('Akses');
            // $table->string('No_Kartu');
            $table->string('Hp');
            $table->string('Email');
            $table->string('Tarif_Dasar_Member');
            $table->string('Tarif_Member');
            $table->string('Tarif_Kartu');
            // $table->string('Periode');
            $table->string('Awal_Aktif');
            $table->string('Akhir_Aktif');
            $table->string('Total_Biaya');
            // $table->string('Kendaran');
            // $table->string('Plat_Number');
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
        Schema::dropIfExists('transaction_members');
    }
};
