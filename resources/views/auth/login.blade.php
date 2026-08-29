<x-guest-layout>
    <!-- Session Status -->
     
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col items-center justify-center min-h-screen px-4 sm:px-6">
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 w-full max-w-xs sm:max-w-sm text-center">
            <div class="mb-4">
                <div class="mx-auto w-14 h-14 bg-[#bfecff] rounded-full flex items-center justify-center text-purple-500 text-xl">
                    <i class="fa-solid fa-ice-cream"></i>
                </div>
            </div>

            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">Sistem Inventory Rumah Es Krim</h2>
            <p class="text-gray-500 text-sm sm:text-base mb-4">Masuk untuk mengelola stok es krim</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3 text-left">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan Email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div class="mb-3 text-left">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <x-primary-button class="mb-4 w-full flex justify-center items-center py-2">
                    {{ __('Masuk') }}
                </x-primary-button>

                @if (Route::has('password.request'))
                <a class="text-sm text-purple-300 hover:text-purple-400" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
                @endif
            </form>
        </div>
    </div>
</x-guest-layout>