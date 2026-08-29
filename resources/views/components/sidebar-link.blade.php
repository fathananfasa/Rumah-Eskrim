@props(['href', 'active' => false])

<a 
    href="{{ $href }}" 
    class="
        block 
        w-full 
        rounded-[10px]
        px-[15.99px]
        py-3                      {{-- Padding atas-bawah mobile, tetap --}}
        {{ $active ? 'bg-[#CDC1FF] text-white' : 'text-gray-700' }}
        lg:px-4                   {{-- Padding kiri-kanan desktop --}}
        lg:rounded-lg             {{-- Border-radius desktop --}}
        lg:py-4                   {{-- Padding atas-bawah desktop tetap sama untuk semua state --}}
        lg:mt-5
        min-h-[56px]              {{-- Tinggi minimum supaya tidak “melompat” --}}
    "
>
    <div class="flex items-center justify-between gap-[11.98px] lg:gap-2 
        {{ $active ? 'text-white' : 'text-gray-700' }}">
        
        {{-- Lingkaran atau ikon di kiri --}}
        <span class="{{ $active ? 'text-white' : 'text-gray-700' }}">
            {{ $slot }}
        </span>

    </div>
</a>
