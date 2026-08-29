<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-6 sm:p-8">
            
            <h1 class="text-2xl font-semibold text-gray-800 mb-2 text-center">
                Lupa Password
            </h1>

            <p class="text-sm text-gray-600 mb-6 text-center">
                Masukkan email Kamu. Kami akan mengirimkan link reset password.
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input
                        id="email"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        placeholder="contoh@email.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Button -->
                <div>
                    <x-primary-button class="w-full justify-center py-3 text-base">
                        Kirim Link Reset Password
                    </x-primary-button>
                </div>
            </form>

            <!-- Back to login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:underline">
                    Kembali ke Login
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>
