<x-mail::message>
# Halo, {{ $user->username }}!

Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda di **Enumbiz School**.

<x-mail::button :url="route('password.reset', ['token' => $token])">
Atur Ulang Password
</x-mail::button>

Link reset password ini akan kadaluarsa dalam **{{ env('RESET_TOKEN_LIFETIME', 60) }} menit**.

Jika Anda tidak merasa melakukan permintaan ini, abaikan saja email ini. Akun Anda tetap aman.

Terima kasih,<br>
Panitia PPDB {{ config('app.name') }}
</x-mail::message>
