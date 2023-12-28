<?php

use App\Models\User;
use App\Models\vehicle_initial;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(vehicle_initial::class);
            $table->foreignIdFor(User::class);
            $table->string('serial');
            $table->string('name');
            $table->string('time_price_1');
            $table->string('time_price_2');
            $table->string('time_price_3');
            $table->string('grace_time');
            $table->string('grace_time_duration');
            $table->string('limitation_time_duration');
            $table->boolean('maximum_daily')->default(0);
            $table->string('maximum_daily_price');
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
        Schema::dropIfExists('vehicles');
    }
};
