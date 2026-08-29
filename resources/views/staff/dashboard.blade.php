<x-app-layout>
    <div class="py-8 bg-[#fff8e6] min-h-screen">
        <div class="max-w-7xl mx-auto space-y-8 sm:px-6 lg:px-8">

            <!-- Header -->
            <div>
                <h1 class="mt-4 sm:mt-0 text-2xl sm:text-3xl font-bold flex items-center gap-2 text-gray-800">
                    Dashboard Stok Es Krim
                </h1>
                <p class="text-gray-600 text-sm sm:text-base">
                    Selamat datang kembali! Berikut ringkasan stok hari ini.
                </p>
            </div>

            <!-- Stok Es Krim -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Stok Es Krim</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                    @foreach ($produks as $produk)
                    @php
                    $persentase = $produk->stok_maksimum > 0 ? ($produk->stok / $produk->stok_maksimum) * 100 : 0;

                    if ($persentase <= 25) {
                        $bgColor='bg-red-500' ;
                        $textColor='text-red-600' ;
                        $labelText='Menipis' ;
                        } elseif ($persentase <=50) {
                        $bgColor='bg-orange-400' ;
                        $textColor='text-orange-500' ;
                        $labelText=round($persentase).'%';
                        } elseif ($persentase <=75) {
                        $bgColor='bg-yellow-400' ;
                        $textColor='text-yellow-500' ;
                        $labelText=round($persentase).'%';
                        } else {
                        $bgColor='bg-green-400' ;
                        $textColor='text-green-500' ;
                        $labelText=round($persentase).'%';
                        }
                        @endphp

                        <div class="bg-white p-4 rounded-2xl shadow">
                        <div class="flex flex-col">
                            <!-- Lingkaran kiri + LabelText kanan -->
                            <div class="flex justify-between items-center">
                                <div class="h-8 w-8 rounded-full {{ $bgColor }}"></div>
                                <span class="text-sm {{ $textColor }}">{{ $labelText }}</span>
                            </div>

                            <!-- Nama produk tetap di bawah lingkaran -->
                            <span class="mt-2 font-semibold">{{ $produk->nama_produk }}</span>

                            <!-- Progress bar -->
                            <div class="mt-2">
                                <div class="w-full h-2 bg-gray-200 rounded-full">
                                    <div class="h-2 rounded-full {{ $bgColor }}" style="width: {{ $persentase }}%"></div>
                                </div>
                            </div>
                        </div>

                </div>
                @endforeach
            </div>
        </div>

        <!-- Perlengkapan Pendukung -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Perlengkapan Pendukung</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($perlengkapans as $item)
                @php
                $warnaKartu = $item->stok <= 15 ? 'bg-pink-100 border border-pink-300' : 'bg-white' ;
                    @endphp
                    <div class="{{ $warnaKartu }} shadow rounded-2xl p-5 relative">
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-bold text-gray-800">📦{{ $item->nama_perlengkapan }}</span>
                        @if ($item->stok <= 15)
                            <span class="text-red-500 text-lg font-bold absolute top-3 right-3">!</span>
                            @endif
                    </div>
                    <p class="text-2xl font-semibold text-gray-700">{{ $item->stok }} pcs</p>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>