<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full py-2 font-bold bg-[#CDC1FF] hover:bg-purple-500 text-white rounded-lg text-center']) }}>
    {{ $slot }}
</button>
