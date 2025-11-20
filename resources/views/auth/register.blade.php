<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block w-full mt-1" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Google reCAPTCHA -->
        <div class="mt-4">
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
            @if ($errors->has('g-recaptcha-response'))
                <span class="mt-2 text-sm text-red-600 dark:text-red-400" style="display:block">
                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                </span>
            @endif
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('register-form');

            // Cek apakah form ada dan reCAPTCHA script sudah dimuat
            if (form && typeof grecaptcha !== 'undefined') {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Mencegah form submit default

                    // Panggil reCAPTCHA v3 dengan action yang spesifik
                    grecaptcha.ready(function() {
                        grecaptcha.execute('{{ env('CAPTCHA_KEY') }}', {
                            action: 'register'
                        }).then(function(token) {
                            // Masukkan token ke input tersembunyi
                            document.getElementById('g-recaptcha-response').value = token;

                            // Lanjutkan submit form secara manual
                            form.submit();
                        });
                    });
                });
            }
        });
    </script>
</x-guest-layout>
