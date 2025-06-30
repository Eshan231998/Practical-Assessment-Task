<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gender;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('genders')->truncate();
        Schema::enableForeignKeyConstraints();
        DB::table('genders')->insert([[
            'id' => '1',
            'name' => 'Male',
        ], [
            'id' => '2',
            'name' => 'Female',
        ]]);
    }
}
