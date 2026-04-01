<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Creates the initial Super Admin user + admins record inside a
     * single DB transaction so both rows are inserted atomically.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // 1. Create the User account with role PANITIA
            $adminUser = User::create([
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role'     => 'PANITIA',
                'email'    => 'admin@enumbiz.sch.id',
            ]);

            // 2. Create the corresponding admins record
            Admin::create([
                'user_id'     => $adminUser->id,
                'nama_panitia' => 'Super Admin',
                'no_hp'       => '08100000000',
            ]);
        });
    }
}
