<x-app-layout>
  <div class="p-4 sm:p-8 bg-[#fff8e6] min-h-[calc(100vh-100px)] relative z-0 mt-16 sm:mt-0">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
      <div>
        <h1 class="mt-4 sm:mt-0 text-2xl sm:text-3xl font-bold flex items-center gap-2 text-gray-800">
          📊 Laporan Stok
        </h1>
        <p class="text-gray-600 text-sm sm:text-base">Analisis tren dan distribusi stok</p>
      </div>

      <div class="flex sm:justify-start">
        <button id="downloadLaporan"
          class="flex items-center gap-2 bg-[#CDC1FF] font-semibold hover:bg-purple-500 text-white px-4 py-2 rounded-lg text-sm shadow">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5 flex-shrink-0" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
          </svg>
          <span>Download Laporan (PDF)</span>
        </button>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white shadow rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:gap-3 gap-3 mb-8">
      <div class="flex items-center gap-2 w-full sm:w-auto">
        <i class="fa-solid fa-filter fa-thin"></i>
        <span class="text-gray-700 font-semibold">Filter:</span>
      </div>

      <select id="periodeFilter"
        class="w-full sm:w-auto border border-blue-200 bg-blue-50 rounded-lg px-3 py-2 text-gray-700 font-medium">
        <option value="">Pilih Periode</option>
        <option value="Harian">Harian</option>
        <option value="Mingguan">Mingguan</option>
        <option value="Bulanan">Bulanan</option>
      </select>

      <select id="kategoriFilter"
        class="hidden w-full sm:w-auto border border-blue-200 bg-blue-50 rounded-lg px-3 py-2 text-gray-700 font-medium">
        <option value="Semua Kategori">Semua Kategori</option>
        <option value="Es Krim">Es Krim</option>
        <option value="Perlengkapan">Perlengkapan</option>
      </select>

      <select id="tanggalFilter"
        class="hidden w-full sm:w-auto border border-blue-200 bg-blue-50 rounded-lg px-3 py-2 text-gray-700 font-medium">
        <option value="Semua Tanggal">Semua Tanggal</option>
        @foreach ($laporan->pluck('tanggal')->unique() as $tgl)
        <option>{{ $tgl }}</option>
        @endforeach
      </select>

      <input type="month" id="bulanFilter"
        class="hidden w-full sm:w-auto border border-blue-200 bg-blue-50 rounded-lg px-3 py-2 text-gray-700 font-medium">

      <button id="resetFilter"
        class="border border-pink-300 text-pink-500 rounded-lg px-3 py-2 text-sm hover:bg-pink-50 transition w-full sm:w-auto hidden">
        Reset Filter
      </button>



    </div>

    <!-- Data Laporan -->
    <div class="bg-white shadow rounded-2xl p-4 sm:p-6 border border-yellow-100 overflow-x-auto">
      <h3 class="text-lg font-semibold text-gray-700 mb-1 flex items-center gap-2">
        📋 Data Laporan Stok
      </h3>
      <p class="text-sm text-gray-500 mb-4">Riwayat pencatatan level stok harian</p>

      <table class="min-w-full text-sm text-left">
        <thead class="bg-[#fff3d6] text-gray-700 font-semibold">
          <tr>
            <th class="px-4 py-3 text-left">Tanggal</th>
            <th class="px-4 py-3 text-left">Nama Barang</th>
            <th class="px-4 py-3 text-left">Kategori</th>
            <th class="px-4 py-3 text-left">Level Stok</th>
          </tr>
        </thead>
        <tbody id="laporanTable">
          @include('admin.partials.tabel-laporan', ['laporan' => $laporan->take(20)])
        </tbody>
      </table>

      <!-- Info -->
      <div id="infoEntri" class="text-sm text-gray-500 mt-3">
        Menampilkan {{ min(20, count($laporan)) }} entri
      </div>
      <div id="infoPeriode" class="text-sm text-gray-400 text-left sm:text-right mt-2">
        Periode: {{ $laporan->last()['tanggal'] ?? '-' }} - {{ $laporan->first()['tanggal'] ?? '-' }}
      </div>

      <!-- Pagination -->
      <div id="pagination" class="flex justify-center items-center gap-2 mt-4">
        <button id="prevPage" class="px-3 py-1 border rounded hover:bg-gray-100">Prev</button>
        <span id="currentPage">1</span> / <span id="lastPage">{{ ceil(count($laporan)/20) }}</span>
        <button id="nextPage" class="px-3 py-1 border rounded hover:bg-gray-100">Next</button>
      </div>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mt-8">
      <div class="bg-white border-2 border-green-100 shadow rounded-2xl p-4 text-center">
        <h4 class="text-gray-600 text-sm">Total Entri</h4>
        <p id="totalEntri" class="text-2xl sm:text-3xl font-bold text-green-600">{{ count($laporan) }}</p>
      </div>

      <div class="bg-white border-2 border-purple-100 shadow rounded-2xl p-4 text-center">
        <h4 class="text-gray-600 text-sm">Item Es Krim</h4>
        <p id="itemEsKrim" class="text-2xl sm:text-3xl font-bold text-purple-600">
          {{ $laporan->where('kategori', 'Es Krim')->count() }}
        </p>
      </div>

      <div class="bg-white border-2 border-pink-100 shadow rounded-2xl p-4 text-center">
        <h4 class="text-gray-600 text-sm">Item Perlengkapan</h4>
        <p id="itemPerlengkapan" class="text-2xl sm:text-3xl font-bold text-pink-600">
          {{ $laporan->where('kategori', 'Perlengkapan')->count() }}
        </p>
      </div>
    </div>
  </div>

  <!-- SCRIPT FILTER & PAGINATION -->
  <script>
    const kategoriFilter = document.getElementById('kategoriFilter');
    const tanggalFilter = document.getElementById('tanggalFilter');
    const bulanFilter = document.getElementById('bulanFilter');
    const periodeFilter = document.getElementById('periodeFilter');
    const laporanTable = document.getElementById('laporanTable');
    const resetFilter = document.getElementById('resetFilter');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const currentPageSpan = document.getElementById('currentPage');
    const lastPageSpan = document.getElementById('lastPage');

    let currentPage = 1;

    function toggleFilters() {
      const p = periodeFilter.value;
      kategoriFilter.classList.add('hidden');
      tanggalFilter.classList.add('hidden');
      bulanFilter.classList.add('hidden');

      if (p !== '') kategoriFilter.classList.remove('hidden');
      if (p === 'Harian' || p === 'Mingguan') tanggalFilter.classList.remove('hidden');
      if (p === 'Bulanan') bulanFilter.classList.remove('hidden');
    }

    function updateTable(page = 1) {
      const kategori = kategoriFilter.value || 'Semua Kategori';
      const tanggal = tanggalFilter.value || 'Semua Tanggal';
      const periode = periodeFilter.value || '';
      const bulan = bulanFilter.value || '';

      // aktif/nonaktifkan tombol reset
      // tampilkan tombol hanya saat filter aktif
      if (kategori !== 'Semua Kategori' || tanggal !== 'Semua Tanggal' || periode !== '' || bulan !== '') {
        resetFilter.classList.remove('hidden'); // tombol muncul
      } else {
        resetFilter.classList.add('hidden'); // tombol disembunyikan
      }


      let url = `{{ route('admin.laporan.filter') }}?kategori=${encodeURIComponent(kategori)}&tanggal=${encodeURIComponent(tanggal)}&periode=${encodeURIComponent(periode)}&bulan=${encodeURIComponent(bulan)}&page=${page}`;

      fetch(url)
        .then(r => r.json())
        .then(d => {
          laporanTable.innerHTML = d.html;
          document.getElementById('totalEntri').textContent = d.total;
          document.getElementById('itemEsKrim').textContent = d.eskrim;
          document.getElementById('itemPerlengkapan').textContent = d.perlengkapan;
          document.getElementById('infoEntri').textContent = 'Menampilkan ' + d.html.match(/<tr/g).length + ' entri';
          document.getElementById('infoPeriode').textContent = 'Periode: ' + d.periode;
          currentPage = d.current_page;
          currentPageSpan.textContent = currentPage;
          lastPageSpan.textContent = d.last_page;
        });
    }


    periodeFilter.addEventListener('change', () => {
      toggleFilters();
      updateTable();
    });
    kategoriFilter.addEventListener('change', () => updateTable());
    tanggalFilter.addEventListener('change', () => updateTable());
    bulanFilter.addEventListener('change', () => updateTable());
    resetFilter.addEventListener('click', () => {
      kategoriFilter.value = 'Semua Kategori';
      tanggalFilter.value = 'Semua Tanggal';
      bulanFilter.value = '';
      periodeFilter.value = '';

      toggleFilters();
      updateTable(); // ini otomatis akan men-disable tombol
    });


    prevPageBtn.addEventListener('click', () => {
      if (currentPage > 1) updateTable(currentPage - 1);
    });
    nextPageBtn.addEventListener('click', () => {
      updateTable(currentPage + 1);
    });

    toggleFilters();

    const downloadBtn = document.getElementById('downloadLaporan');
    downloadBtn.addEventListener('click', function(e) {
      e.preventDefault();
      let kategori = kategoriFilter.value === 'Semua Kategori' ? '' : kategoriFilter.value;
      let tanggal = tanggalFilter.value === 'Semua Tanggal' ? '' : tanggalFilter.value;
      let bulan = bulanFilter.value || '';
      let url = `{{ route('laporan.download') }}?periode=${periodeFilter.value}&kategori=${kategori}&tanggal=${tanggal}&bulan=${bulan}`;
      window.location.href = url;
    });
  </script>

</x-app-layout>