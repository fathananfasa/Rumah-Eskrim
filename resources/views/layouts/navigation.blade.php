<!-- Topbar MOBILE -->
<nav x-data="{ open: false }" class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200">
  <div class="flex justify-between items-center h-16 px-4">

    <!-- Logo -->
    <a href="{{ route('staff.dashboard') }}" class="flex items-center gap-2">
       <div class="w-10 h-10 bg-[#bfecff] rounded-full flex items-center justify-center text-purple-500 text-lg">
        <i class="fa-solid fa-ice-cream"></i>
    </div>

    <span class="text-base font-semibold text-gray-700 leading-none">
        Inventory Es Krim
    </span>
    </a>

    <!-- Hamburger -->
    <button @click="open = !open" class="p-2 rounded-md text-gray-600 hover:bg-gray-100">
      <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
        <path :class="{ 'hidden': open }" class="inline-flex"
          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16" />
        <path :class="{ 'hidden': !open }" class="hidden"
          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <!-- Sidebar MOBILE -->
  <div x-cloak x-show="open" class="fixed inset-0 z-50 flex justify-end">

    <!-- Overlay -->
    <div @click="open = false" class="absolute inset-0 bg-black/40"
      x-transition:enter="transition-opacity duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition-opacity duration-300"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"></div>

    <!-- Panel -->
    <div x-show="open"
      class="relative bg-white w-64 h-full shadow-lg flex flex-col"
      x-transition:enter="transition transform ease-out duration-300"
      x-transition:enter-start="translate-x-full"
      x-transition:enter-end="translate-x-0"
      x-transition:leave="transition transform ease-in duration-300"
      x-transition:leave-start="translate-x-0"
      x-transition:leave-end="translate-x-full">

      <button @click="open = false" class="absolute top-3 right-3 text-gray-500">✕</button>

      <!-- Menu items -->
      <div class="flex-1 mt-10 px-2 space-y-2 overflow-y-auto">

        @if(auth()->user()->role === 'staff')
        <x-sidebar-link href="{{ route('staff.dashboard') }}" :active="request()->routeIs('staff.dashboard')">
          <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
            </svg>
            <span>Dashboard</span>
          </div>
        </x-sidebar-link>

        <x-sidebar-link href="{{ route('stok') }}" :active="request()->routeIs('stok')">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-box-open"></i>
            <span>Stok</span>
          </div>
        </x-sidebar-link>
        @endif

        @if(auth()->user()->role === 'admin')
        <x-sidebar-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
          <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
            </svg>
            <span>Dashboard</span>
          </div>
        </x-sidebar-link>

        <x-sidebar-link href="{{ route('admin.stok') }}" :active="request()->routeIs('admin.stok')">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-box-open"></i>
          <span>Stok</span>
          </div>
        </x-sidebar-link>

        <x-sidebar-link href="{{ route('laporan') }}" :active="request()->routeIs('laporan')">
          <div class="flex items-center gap-3">
            <i class="far fa-file-lines"></i>
            <span>Laporan</span>
          </div>
        </x-sidebar-link>

        <x-sidebar-link href="{{ route('profil') }}" :active="request()->routeIs('profil')">
          <div class="flex items-center gap-3">
            <i class="fas fa-user"></i>
            <span>Profil</span>
          </div>
        </x-sidebar-link>
        @endif

      </div>

      <!-- Logout button -->
      <form method="POST" action="{{ route('logout') }}" class="p-4 border-t">
        @csrf
        <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 flex items-center gap-2">
          <i class="fa-solid fa-arrow-right-from-bracket"></i>
          Keluar
        </button>
      </form>

    </div>
  </div>
</nav>

<!-- Sidebar DESKTOP -->
<aside class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 bg-white border-r">

  <!-- Logo -->
  <div class="flex items-center gap-3 h-16 border-b px-6">
    <div class="w-10 h-10 bg-[#bfecff] rounded-full flex items-center justify-center text-purple-500 text-lg">
        <i class="fa-solid fa-ice-cream"></i>
    </div>

    <span class="text-base font-semibold text-gray-700 leading-none">
        Inventory Es Krim
    </span>
</div>


  <!-- Menu -->
  <div class="flex-1 px-0 py-4 space-y-2 overflow-y-auto">

    @if(auth()->user()->role === 'staff')
    <x-sidebar-link href="{{ route('staff.dashboard') }}" :active="request()->routeIs('staff.dashboard')">
      <div class="flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
        </svg>

        <span>Dashboard</span>
      </div>
    </x-sidebar-link>

    <x-sidebar-link href="{{ route('stok') }}" :active="request()->routeIs('stok')">
      <div class="flex items-center gap-3">
        <i class="fa-solid fa-box-open"></i>
        <span>Stok</span>
      </div>
    </x-sidebar-link>
    @endif

    @if(auth()->user()->role === 'admin')
    <x-sidebar-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
      <div class="flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
        </svg>
        <span>Dashboard</span>
      </div>
    </x-sidebar-link>

    <x-sidebar-link href="{{ route('admin.stok') }}" :active="request()->routeIs('admin.stok')">
      <div class="flex items-center gap-3">
        <i class="fa-solid fa-box-open"></i>
        <span>Stok</span>
      </div>
    </x-sidebar-link>

    <x-sidebar-link href="{{ route('laporan') }}" :active="request()->routeIs('laporan')">
      <div class="flex items-center gap-3">
        <i class="far fa-file-lines"></i>
        <span>Laporan</span>
      </div>
    </x-sidebar-link>

    <x-sidebar-link href="{{ route('profil') }}" :active="request()->routeIs('profil')">
      <div class="flex items-center gap-3">
        <i class="fas fa-user"></i>
        <span>Profil</span>
      </div>
    </x-sidebar-link>
    @endif

  </div>

  <!-- Logout -->
  <form method="POST" action="{{ route('logout') }}" class="p-4">
    @csrf
    <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 flex items-center gap-2">
      <i class="fa-solid fa-arrow-right-from-bracket"></i>
      Keluar
    </button>
  </form>

</aside>