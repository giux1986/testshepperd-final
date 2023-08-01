<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Clear the existing users table records (if any).
        DB::table('users')->truncate();

        // Insert fake users using the factory.
        User::factory()->count(10)->create();
    }
}
