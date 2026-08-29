<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#fff8e6] px-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-6 sm:p-8">
            
            <h1 class="text-xl font-semibold text-gray-800 text-center">
                Reset Password
            </h1>

            <p class="text-sm text-gray-500 text-center mt-2">
                Masukkan password baru untuk akun Kamu
            </p>

            <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-4">
                @csrf

                <!-- Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        class="block w-full mt-1"
                        :value="old('email', $request->email)"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="Password Baru" />
                    <x-text-input
                        id="password"
                        type="password"
                        name="password"
                        class="block w-full mt-1"
                        required
                        autocomplete="new-password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                    <x-text-input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="block w-full mt-1"
                        required
                        autocomplete="new-password"
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <!-- Button -->
                <div class="pt-4">
                    <x-primary-button class="w-full justify-center">
                        Reset Password
                    </x-primary-button>
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>
