<?php

use App\Models\manlessPayment;
use App\Models\printer;
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
        Schema::create('site_gate_parkings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(printer::class);
            $table->foreignIdFor(vehicle::class);
            $table->string('name');
            $table->string('type');
            $table->string('address');
            $table->string('type_payment');
            $table->boolean('is_print')->default(0);
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
        Schema::dropIfExists('site_gate_parkings');
    }
};
