<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Religion;
use Illuminate\Support\Facades\DB;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $religions = [
            ['id' => 1, 'name' => 'Buddhism'],
            ['id' => 2, 'name' => 'Hinduism'],
            ['id' => 3, 'name' => 'Islam'],
            ['id' => 4, 'name' => 'Christianity'],
            ['id' => 5, 'name' => 'Other'],
        ];
        DB::table('religions')->truncate();
        foreach ($religions as $religion) {
            Religion::create($religion);
        }
    }
}
