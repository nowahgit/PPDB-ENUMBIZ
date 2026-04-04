<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use App\Models\Berkas;
use App\Models\Seleksi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with complete and realistic student data.
     */
    public function run(): void
    {
        // 0. Cleanup safely (OUTSIDE transaction to avoid PDO commitment errors with truncate)
        Schema::disableForeignKeyConstraints();
        DB::table('seleksis')->truncate();
        DB::table('berkas')->truncate();
        DB::table('admins')->truncate();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Create the Master Admin (Panitia)
        $adminUser = User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role'     => 'PANITIA',
            'email'    => 'admin@enumbiz.sch.id',
        ]);

        $adminProfile = Admin::create([
            'user_id'      => $adminUser->id,
            'nama_panitia' => 'Super Admin',
            'no_hp'        => '08100000000',
        ]);

        // 2. Configuration for students
        $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        $cities = ['Surakarta', 'Semarang', 'Yogyakarta', 'Boyolali', 'Sukoharjo'];
        
        // 3. Create 100 PENDAFTAR users with COMPLETE profiles & snapshots
        for ($i = 1; $i <= 100; $i++) {
            $username = 'siswa' . $i;
            $gender = ($i % 2 == 0) ? 'LAKI-LAKI' : 'PEREMPUAN';
            $city = $cities[array_rand($cities)];
            
            $userData = [
                'username'               => $username,
                'password'               => Hash::make('siswa123'),
                'role'                   => 'PENDAFTAR',
                'email'                  => $username . '@gmail.com',
                'nomor_pendaftaran'      => date('Y') . str_pad($i, 8, '0', STR_PAD_LEFT),
                'nama_pendaftar'         => 'SISWA PPDB NO ' . $i,
                'nisn_pendaftar'         => '008' . rand(1000000, 9999999),
                'jenis_kelamin'          => $gender,
                'asal_sekolah'           => 'SMP Negeri ' . rand(1, 100) . ' ' . $city,
                'no_hp'                  => '08' . rand(100000000, 999999999),
                'tanggallahir_pendaftar' => '2008-08-13',
                'agama'                  => $religions[array_rand($religions)],
                'alamat_pendaftar'       => 'Jl. Perintis Kemerdekaan No. ' . $i . ', ' . $city,
                'nama_ortu'              => 'Wali dari Siswa ' . $i,
                'pekerjaan_ortu'         => 'Karyawan Swasta',
                'no_hp_ortu'             => '08' . rand(100000000, 999999999),
                'alamat_ortu'            => 'Jl. Perintis Kemerdekaan No. ' . $i . ', ' . $city,
                'nilai_smt1'             => (float) rand(75, 95),
                'nilai_smt2'             => (float) rand(75, 95),
                'nilai_smt3'             => (float) rand(75, 95),
                'nilai_smt4'             => (float) rand(75, 95),
                'nilai_smt5'             => (float) rand(75, 95),
            ];

            $user = User::create($userData);

            // 4. Create associated Berkas with snapshots & simulated file paths
            Berkas::create([
                'user_id'                => $user->id,
                'nisn_pendaftar'         => $userData['nisn_pendaftar'],
                'nama_pendaftar'         => $userData['nama_pendaftar'],
                'tanggallahir_pendaftar' => $userData['tanggallahir_pendaftar'],
                'alamat_pendaftar'       => $userData['alamat_pendaftar'],
                'agama'                  => $userData['agama'],
                'nama_ortu'              => $userData['nama_ortu'],
                'pekerjaan_ortu'         => $userData['pekerjaan_ortu'],
                'no_hp_ortu'             => $userData['no_hp_ortu'],
                'alamat_ortu'            => $userData['alamat_ortu'],
                'file_kk'                => 'seeders/documents/kk_simulated.pdf',
                'file_akte'              => 'seeders/documents/akte_simulated.pdf',
                'file_skl'               => 'seeders/documents/skl_simulated.pdf',
                'status_validasi'        => 'MENUNGGU',
            ]);

            // 5. Create associated Seleksi record
            $seleksi = new Seleksi();
            $seleksi->user_id = $user->id;
            $seleksi->id_panitia = $adminProfile->id_panitia;
            $seleksi->nama_seleksi = 'Reguler Terpadu 2026';
            $seleksi->nilai_smt1 = $userData['nilai_smt1'];
            $seleksi->nilai_smt2 = $userData['nilai_smt2'];
            $seleksi->nilai_smt3 = $userData['nilai_smt3'];
            $seleksi->nilai_smt4 = $userData['nilai_smt4'];
            $seleksi->nilai_smt5 = $userData['nilai_smt5'];
            $seleksi->status_seleksi = 'MENUNGGU';
            $seleksi->waktu_seleksi = now();
            $seleksi->save();
        }
    }
}