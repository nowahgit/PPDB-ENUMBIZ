<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use App\Models\Berkas;
use App\Models\Seleksi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

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
            $adminUser = User::updateOrCreate(
                ['username' => 'admin'],
                [
                    'password' => Hash::make('admin123'),
                    'role'     => 'PANITIA',
                    'email'    => 'admin@enumbiz.sch.id',
                ]
            );

            // 2. Create the corresponding admins record
            $admin = Admin::updateOrCreate(
                ['user_id' => $adminUser->id],
                [
                    'nama_panitia' => 'Super Admin',
                    'no_hp'       => '08100000000',
                ]
            );

            // 3. Create Demo Users for Testing
            $faker = Faker::create('id_ID');
            $statuses = ['MENUNGGU', 'LULUS', 'TIDAK_LULUS'];
            $berkasStatuses = ['MENUNGGU', 'VALID', 'DITOLAK'];

            for ($i = 1; $i <= 10; $i++) {
                $username = 'siswa' . $i;
                
                // Fetch existing or prepare new data
                $existingUser = User::where('username', $username)->first();
                $nisn = $existingUser->nisn_pendaftar ?? $faker->unique()->numerify('##########');
                $nama = $existingUser->nama_pendaftar ?? $faker->name;
                $alamat = $existingUser->alamat_pendaftar ?? $faker->address;
                $agama = $existingUser->agama ?? $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']);

                // Create/Update User (PENDAFTAR)
                $user = User::updateOrCreate(
                    ['username' => $username],
                    [
                        'password' => Hash::make('siswa123'),
                        'role'     => 'PENDAFTAR',
                        'email'    => $username . '@gmail.com',
                        'nomor_pendaftaran' => $existingUser->nomor_pendaftaran ?? 'PPDB' . date('Y') . sprintf('%04d', $i),
                        'no_hp' => $existingUser->no_hp ?? '08' . $faker->numerify('##########'),
                        'jenis_kelamin' => $existingUser->jenis_kelamin ?? $faker->randomElement(['LAKI-LAKI', 'PEREMPUAN']),
                        'nisn_pendaftar' => $nisn,
                        'nama_pendaftar' => $nama,
                        'tanggallahir_pendaftar' => $existingUser->tanggallahir_pendaftar ?? $faker->dateTimeBetween('-16 years', '-14 years')->format('Y-m-d'),
                        'alamat_pendaftar' => $alamat,
                        'agama' => $agama,
                        'nama_ortu' => $existingUser->nama_ortu ?? $faker->name,
                        'pekerjaan_ortu' => $existingUser->pekerjaan_ortu ?? $faker->jobTitle,
                        'no_hp_ortu' => $existingUser->no_hp_ortu ?? '08' . $faker->numerify('##########'),
                        'alamat_ortu' => $alamat,
                        'nilai_smt1' => $existingUser->nilai_smt1 ?? $faker->randomFloat(1, 75, 100),
                        'nilai_smt2' => $existingUser->nilai_smt2 ?? $faker->randomFloat(1, 75, 100),
                        'nilai_smt3' => $existingUser->nilai_smt3 ?? $faker->randomFloat(1, 75, 100),
                        'nilai_smt4' => $existingUser->nilai_smt4 ?? $faker->randomFloat(1, 75, 100),
                        'nilai_smt5' => $existingUser->nilai_smt5 ?? $faker->randomFloat(1, 75, 100),
                    ]
                );

                // Create/Update Berkas for testing
                Berkas::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nisn_pendaftar' => $nisn,
                        'nama_pendaftar' => $nama,
                        'tanggallahir_pendaftar' => $user->tanggallahir_pendaftar,
                        'alamat_pendaftar' => $alamat,
                        'agama' => $agama,
                        'nama_ortu' => $user->nama_ortu,
                        'pekerjaan_ortu' => $user->pekerjaan_ortu,
                        'no_hp_ortu' => $user->no_hp_ortu,
                        'alamat_ortu' => $alamat,
                        'status_validasi' => $existingUser ? ($user->berkas->status_validasi ?? 'MENUNGGU') : $faker->randomElement($berkasStatuses),
                    ]
                );

                // Create/Update Seleksi for testing
                Seleksi::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'id_panitia' => $admin->id_panitia,
                        'nama_seleksi' => 'Seleksi PPDB Gelombang 1',
                        'nilai_smt1' => $user->nilai_smt1,
                        'nilai_smt2' => $user->nilai_smt2,
                        'nilai_smt3' => $user->nilai_smt3,
                        'nilai_smt4' => $user->nilai_smt4,
                        'nilai_smt5' => $user->nilai_smt5,
                        'status_seleksi' => $existingUser ? ($user->seleksis->first()->status_seleksi ?? 'MENUNGGU') : $faker->randomElement($statuses),
                        'waktu_seleksi' => now(),
                        'is_archived' => false,
                    ]
                );
            }
        });
    }
}
