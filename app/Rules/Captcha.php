<?php

namespace App\Rules;

use Closure;
use ReCaptcha\ReCaptcha;
use Illuminate\Contracts\Validation\ValidationRule;

class Captcha implements ValidationRule
{
    // Threshold skor yang Anda anggap aman (misal: 0.5 atau lebih tinggi).
    // Nilai terendah (pasti bot) adalah 0.0, tertinggi (pasti manusia) adalah 1.0.
    protected $threshold = 0.6; // <- Nilai yang lebih aman untuk registrasi

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 1. Inisiasi ReCaptcha dengan Secret Key dari .env
        $recaptcha = new ReCaptcha(env('CAPTCHA_SECRET'));

        // 2. Verifikasi token. Menggunakan request()->ip() lebih aman daripada $_SERVER['REMOTE_ADDR']
        // Walaupun $_SERVER['REMOTE_ADDR'] di kode Anda sudah berfungsi.
        $response = $recaptcha->verify(
            $value,
            request()->ip() // Menggunakan helper request()->ip() Laravel
        );

        // 3. Periksa dua hal: Apakah verifikasi berhasil DAN apakah skornya aman
        if (! $response->isSuccess() || $response->getScore() < $this->threshold) {

            // Panggil $fail() untuk menampilkan pesan error
            $fail('Verifikasi reCAPTCHA gagal. Harap coba lagi. (Skor: ' . round($response->getScore(), 2) . ')');
        }
    }
}
