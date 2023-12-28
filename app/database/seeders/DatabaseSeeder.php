<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\vehicle_initial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(30)->create();


        // for ($i = 0; $i < 2; $i++) {

        //     if ($i == 0) {
        //         $a = User::create([
        //             'name' => 'admin',
        //             'role' => 'admin',
        //             'email' => 'admin@gmail.com',
        //             'password' =>  Hash::make('123'),
        //         ]);

        //     } else if ($i == 1) {
        //         $b = User::create([
        //             'name' => 'editor',
        //             'role' => 'editor',
        //             'email' => 'editor@gmail.com',
        //             'password' =>  Hash::make('123'),
        //         ]);

        //     }

        // }

        // for ($i = 0; $i < 2; $i++) {

        //     if ($i == 0) {
        //         $a = vehicle_initial::create([
        //             'name' => 'Mobil',
        //             'user_id' => auth()->user()->id,
        //         ]);

        //     } else if ($i == 1) {
        //         $b = vehicle_initial::create([
        //             'name' => 'Motor',
        //             'user_id' => auth()->user()->id,
        //         ]);

        //     }

        // }

    }
}
