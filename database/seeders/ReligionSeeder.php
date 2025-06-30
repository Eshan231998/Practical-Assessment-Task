<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Religion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReligionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('religions')->truncate();
        Schema::enableForeignKeyConstraints();
        DB::table('religions')->insert([[
            'id' => '1',
            'name' => 'Buddhism',
        ], [
            'id' => '2',
            'name' => 'Christianity',
        ], [
            'id' => '3',
            'name' => 'Hinduism'
        ], [
            'id' => '4',
            'name' => 'Indigenous',
        ], [
            'id' => '5',
            'name' => 'Islam',
        ], [
            'id' => '6',
            'name' => 'Judaism',
        ], [
            'id' => '7',
            'name' => 'Prevailing Beliefs',
        ], [
            'id' => '8',
            'name' => 'Non-Religious'
        ], [
            'id' => '9',
            'name' => 'Other',
        ]]);
    }
}
