<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(JenisPinjamanSeeder::class);

        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email_verified_at' => now(),
            'password' => '$2y$10$VcI/g6.b.lya.XoiM.eDgu5dnvAslmAAUTHWJ/GwS0mpEF9hVSV8a', // admin123
            'remember_token' => Str::random(10),
            'is_admin' => true
        ]);
    }
}
