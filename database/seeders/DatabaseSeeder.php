<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'javeedkhanjohnbasha8@gmail.com'],
            [
                'name' => 'Javeed Khan J',
                'password' => Hash::make('Javeed@123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->call(PortfolioSeeder::class);
    }
}
