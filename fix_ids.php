<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\User;

$users = User::where('role', 'PENDAFTAR')->whereNull('nomor_pendaftaran')->get();
foreach ($users as $u) {
    $u->update(['nomor_pendaftaran' => strtoupper(uniqid('E-'))]);
    echo "Updated: {$u->username} -> {$u->nomor_pendaftaran}\n";
}
echo "Done fixing registration IDs.\n";
