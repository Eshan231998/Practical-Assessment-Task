<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'), // Ensure to hash the password
            'role' => 'Admin', // Assuming you have a role field
        ]);

        // Create a session for the user
        $sessionId = Str::random(40);
        DB::table('sessions')->insert([
            'id' => $sessionId,
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'SeederScript',
            'payload' => '', // You can leave this empty or use session()->getHandler()->write() for real data
            'last_activity' => now()->timestamp,
        ]);

        // Call GenderSeeder
        $this->call(GenderSeeder::class);
        // Call ReligionSeeder
        $this->call(ReligionSeeder::class);
    }
}
