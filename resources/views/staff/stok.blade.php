<x-app-layout>
    <div class="py-6 bg-[#fff8e6] min-h-screen">
        <div class="px-4 sm:px-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
                <div>
                    <h1 class="mt-6 sm:mt-0 text-2xl sm:text-3xl font-bold text-gray-800">
                        Manajemen Stok
                    </h1>
                    <p class="text-gray-600 text-sm sm:text-base">
                        Kelola stok es krim dan perlengkapan toko
                    </p>
                </div>
            </div>
        </div>



        <div class="max-w-6xl mx-auto bg-transparent sm:bg-white rounded-2xl shadow p-4 sm:p-6 mt-4">
            <!-- Tabel Data -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="min-w-full border-collapse text-sm sm:text-base">
                    <thead class="bg-[#fff8e6]">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Nama Barang</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Kategori</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Level Stok (%)</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Jumlah (pcs)</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produks as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2">🍦 {{ $item->nama_produk }}</td>
                            <td class="px-4 py-2">Es Krim</td>

                            {{-- LEVEL STOK --}}
                            <td class="px-4 py-2 text-center
                        @if(($item->stok / $item->stok_maksimum) * 100 >= 76)
                            text-green-600
                        @elseif(($item->stok / $item->stok_maksimum) * 100 >= 51)
                            text-yellow-600
                        @else
                            text-orange-600
                        @endif">
                                {{ round(($item->stok / $item->stok_maksimum) * 100) }}%
                            </td>

                            {{-- JUMLAH --}}
                            <td class="px-4 py-2 text-center">-</td>

                            {{-- STATUS --}}
                            <td class="px-4 py-2">
                                @php
                                $persen = ($item->stok_maksimum > 0) ? ($item->stok / $item->stok_maksimum) * 100 : 0;
                                if ($persen <= 25) {
                                    $warna='bg-red-100 text-red-700' ;
                                    $status='Menipis' ;
                                    } elseif ($persen <=50) {
                                    $warna='bg-orange-100 text-orange-700' ;
                                    $status='Normal' ;
                                    } elseif ($persen <=75) {
                                    $warna='bg-yellow-100 text-yellow-700' ;
                                    $status='Normal' ;
                                    } else {
                                    $warna='bg-green-100 text-green-700' ;
                                    $status='Normal' ;
                                    }
                                    @endphp
                                    <span class="{{ $warna }} px-3 py-1 rounded-full text-xs sm:text-sm">
                                    {{ $status }}
                                    </span>
                            </td>

                            {{-- AKSI --}}
                            <td class="px-4 py-2 space-y-2 sm:space-y-0 sm:space-x-2 flex flex-col sm:flex-row">
                                <button class="bg-blue-100 text-blue-700 px-3 py-1 rounded editBtn"
                                    data-id="{{ $item->id_prod }}"
                                    data-kategori="Es Krim"
                                    data-nama="{{ $item->nama_produk }}"
                                    data-stok="{{ $item->stok }}"
                                    data-persentase="{{ $item->persentase }}">
                                    Edit
                                </button>

                            </td>
                        </tr>
                        @endforeach

                        @foreach ($perlengkapan as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2">🧰 {{ $item->nama_perlengkapan }}</td>
                            <td class="px-4 py-2">Perlengkapan</td>
                            <td class="px-4 py-2 text-center text-gray-500">-</td>
                            <td class="px-4 py-2 text-center">{{ $item->stok }} pcs</td>
                            <td class="px-4 py-2">
                                <span class="{{ $item->warna }} px-3 py-1 rounded-full text-xs sm:text-sm">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 space-y-2 sm:space-y-0 sm:space-x-2 flex flex-col sm:flex-row">
                                <button class="bg-blue-100 text-blue-700 px-3 py-1 rounded editBtn"
                                    data-id="{{ $item->id_per}}"
                                    data-kategori="Perlengkapan"
                                    data-nama="{{ $item->nama_perlengkapan }}"
                                    data-stok="{{ $item->stok }}">
                                    Edit
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <!-- CARD VIEW MOBILE -->
            <!-- CARD VIEW MOBILE -->
            <div class="sm:hidden space-y-4 mt-4">
                @foreach ($produks as $item)
                @php
                $persen = ($item->stok_maksimum > 0) ? ($item->stok / $item->stok_maksimum) * 100 : 0;

                // STATUS dari database dipakai, tapi warna dihitung otomatis
                if ($persen <= 25) {
                    $warnaBadge='bg-red-100 text-red-700' ;
                    $warnaDot='bg-red-500' ;
                    } elseif ($persen <=50) {
                    $warnaBadge='bg-orange-100 text-orange-700' ;
                    $warnaDot='bg-orange-500' ;
                    } elseif ($persen <=75) {
                    $warnaBadge='bg-yellow-100 text-yellow-700' ;
                    $warnaDot='bg-yellow-500' ;
                    } else {
                    $warnaBadge='bg-green-100 text-green-700' ;
                    $warnaDot='bg-green-500' ;
                    }
                    @endphp

                    <div class="bg-white border border-purple-100 rounded-xl p-4 shadow-sm">

                    <!-- HEADER PRODUK -->
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center gap-2">
                            <span>🍦</span>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">{{ $item->nama_produk }}</p>
                                <p class="text-xs text-gray-500">Es Krim</p>
                            </div>
                        </div>

                        <span class="{{ $warnaBadge }} px-2 py-1 rounded-full text-xs">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>

                    <!-- LEVEL STOK -->
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-gray-700">Level Stok</p>
                        <div class="flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full {{ $warnaDot }}"></span>
                            <p class="text-xs font-semibold">
                                {{ round($persen) }}%
                            </p>
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <div class="flex gap-2 mt-3">
                        <button
                            class="bg-blue-100 text-blue-700 rounded px-3 py-1 text-xs flex-1 editBtn"
                            data-id="{{ $item->id_prod}}"
                            data-kategori="Es Krim"
                            data-nama="{{ $item->nama_produk }}"
                            data-stok="{{ $item->stok }}">
                            Edit
                        </button>
                    </div>
            </div>
            @endforeach



            <!-- PERLENGKAPAN -->
            @foreach ($perlengkapan as $item)

            @php
            // Warna dihitung otomatis dari stok (MODE A)
            if ($item->stok <= 15) {
                $warnaBadge='bg-red-100 text-red-700' ;
                $status='Menipis' ;
                } elseif($item->stok <= 35){
                    $warnaBadge='bg-yellow-100 text-yellow-700' ;
                    $status='Normal' ;
                    } else {
                    $warnaBadge='bg-green-100 text-green-700' ;
                    $status='Normal' ;
                    }
                    @endphp

                    <div class="bg-white border border-purple-100 rounded-xl p-4 shadow-sm">

                    <!-- HEADER PERLENGKAPAN -->
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center gap-2">
                            <span>🧰</span>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">{{ $item->nama_perlengkapan }}</p>
                                <p class="text-xs text-gray-500">Perlengkapan</p>
                            </div>
                        </div>

                        <span class="{{ $warnaBadge }} px-2 py-1 rounded-full text-xs">
                            {{ $status }}
                        </span>
                    </div>

                    <!-- LEVEL JUMLAH -->
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-gray-700">Jumlah</p>
                        <div class="flex items-center gap-1">
                            <p class="text-xs font-semibold">{{ $item->stok }} pcs</p>
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <div class="flex gap-2 mt-3">
                        <button
                            class="bg-blue-100 text-blue-700 rounded px-3 py-1 text-xs flex-1 editBtn"
                            data-id="{{ $item->id_per}}"
                            data-kategori="Perlengkapan"
                            data-nama="{{ $item->nama_perlengkapan }}"
                            data-stok="{{ $item->stok }}">
                            Edit
                        </button>
                    </div>
        </div>

        @endforeach
    </div>


    </div>
    </div>

    <!-- Modal Edit -->
    <div id="modalEdit"
        class="hidden fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center p-4 sm:p-0">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl">
            <h3 class="text-lg font-semibold mb-4">Edit Barang</h3>
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700">Kategori</label>
                    <select id="editKategori" name="kategori" class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Es Krim">🍦 Es Krim</option>
                        <option value="Perlengkapan">📦 Perlengkapan</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Nama Barang</label>
                    <select id="editNama" name="nama_produk" class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih Nama Barang --</option>
                    </select>
                </div>

                <div class="mb-4" id="stokSection">
                    <label class="block text-gray-700" id="stokLabel">Level Stok (%)</label>
                    <select id="editPersentase" name="level_stok" class="w-full border rounded px-3 py-2">
                        <option value="100">🟢 100% (Full)</option>
                        <option value="75">🟡 75% (¾)</option>
                        <option value="50">🟠 50% (½)</option>
                        <option value="25">🔴 Menipis</option>
                    </select>
                    <input type="number" id="editJumlah" name="stok" placeholder="Masukkan jumlah pcs"
                        class="hidden w-full border rounded px-3 py-2">
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3 mt-4">
                    <button type="submit"
                        class="bg-purple-200 hover:bg-purple-300 text-purple-900 px-4 py-2 rounded w-full sm:w-auto">
                        Simpan
                    </button>
                    <button type="button" id="btnBatal"
                        class="bg-pink-200 hover:bg-pink-300 text-pink-800 px-4 py-2 rounded w-full sm:w-auto">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Barang -->
    <div id="modalTambah"
        class="hidden fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center p-4 sm:p-0">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl">
            <h3 class="text-lg font-semibold mb-4">Tambah Barang</h3>
            <form id="formTambah" method="POST" action="{{ route('produk.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Nama Barang</label>
                    <input type="text" name="nama_produk" required class="w-full border rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Stok Awal</label>
                    <input type="number" name="stok" required class="w-full border rounded px-3 py-2">
                </div>
                <div class="flex flex-col sm:flex-row justify-end gap-3 mt-4">
                    <button type="submit"
                        class="bg-purple-200 hover:bg-purple-300 text-purple-900 px-4 py-2 rounded w-full sm:w-auto">
                        Simpan
                    </button>
                    <button type="button" id="btnBatalTambah"
                        class="bg-pink-200 hover:bg-pink-300 text-pink-800 px-4 py-2 rounded w-full sm:w-auto">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const dataBarang = @json($dataBarang);

        // Tombol edit
        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                const modal = document.getElementById('modalEdit');
                modal.classList.remove('hidden');

                const kategori = btn.dataset.kategori;
                const nama = btn.dataset.nama;
                const stok = btn.dataset.stok;
                const persen = btn.dataset.persentase || 100;

                // Set kategori select
                const kategoriSelect = document.getElementById('editKategori');
                kategoriSelect.value = kategori;

                // Set nama select
                const namaSelect = document.getElementById('editNama');
                namaSelect.innerHTML = '<option value="">-- Pilih Nama Barang --</option>';
                if (dataBarang[kategori]) {
                    dataBarang[kategori].forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item;
                        opt.textContent = item;
                        if (item === nama) opt.selected = true;
                        namaSelect.appendChild(opt);
                    });
                }

                // Atur input sesuai kategori
                if (kategori === "Perlengkapan") {
                    namaSelect.setAttribute('name', 'nama_perlengkapan');
                    document.getElementById('editPersentase').classList.add('hidden');

                    const jumlah = document.getElementById('editJumlah');
                    jumlah.classList.remove('hidden');
                    jumlah.value = stok;
                    jumlah.setAttribute('name', 'stok');
                } else {
                    namaSelect.setAttribute('name', 'nama_produk');
                    document.getElementById('editPersentase').classList.remove('hidden');
                    document.getElementById('editJumlah').classList.add('hidden');

                    // Tampilkan persentase sesuai data asli
                    document.getElementById('editPersentase').value = persen;
                }

                // Set form action
                const form = document.getElementById('formEdit');
                form.action = (kategori === "Es Krim") ?
                    "{{ route('staff.produk.update', '') }}/" + btn.dataset.id :
    "{{ route('staff.perlengkapan.update', '') }}/" + btn.dataset.id;
            });
        });

        // Ganti nama ketika kategori diubah di modal edit
        document.getElementById('editKategori').addEventListener('change', e => {
            const kategori = e.target.value;
            const namaSelect = document.getElementById('editNama');
            namaSelect.innerHTML = '<option value="">-- Pilih Nama Barang --</option>';

            if (dataBarang[kategori]) {
                dataBarang[kategori].forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item;
                    opt.textContent = item;
                    namaSelect.appendChild(opt);
                });
            }

            if (kategori === "Perlengkapan") {
                namaSelect.setAttribute('name', 'nama_perlengkapan');
                document.getElementById('editPersentase').classList.add('hidden');
                const jumlah = document.getElementById('editJumlah');
                jumlah.classList.remove('hidden');
                jumlah.setAttribute('name', 'stok');
            } else {
                namaSelect.setAttribute('name', 'nama_produk');
                document.getElementById('editPersentase').classList.remove('hidden');
                document.getElementById('editJumlah').classList.add('hidden');
                document.getElementById('editJumlah').removeAttribute('name');
            }
        });

        // Tombol batal
        document.getElementById('btnBatal').addEventListener('click', () => {
            document.getElementById('modalEdit').classList.add('hidden');
        });
    </script>
</x-app-layout>