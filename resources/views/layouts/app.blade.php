<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome Free -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
/>

</head>

<body class="font-sans antialiased  bg-[#fff8e6] ">
    <div>
        {{-- Sidebar kiri --}}
        @include('layouts.navigation')

        {{-- Konten utama di kanan --}}
        <main class="p-4 md:ml-64 bg-[#fff8e6] min-h-screen transition-all duration-300 ">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
