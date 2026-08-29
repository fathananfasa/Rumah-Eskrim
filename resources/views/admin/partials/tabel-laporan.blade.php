@forelse ($laporan as $item)
<tr class="border-b hover:bg-gray-50 transition-all duration-200">

  {{-- Tanggal --}}
  <td class="px-4 py-3 text-gray-700 text-sm">
    {{ $item['tanggal'] }}
  </td>

  {{-- Nama item --}}
  <td class="px-4 py-3 text-gray-800 font-medium">
    {{ data_get($item, 'nama_item', data_get($item, 'nama_barang', data_get($item, 'nama', '-'))) }}
  </td>

  {{-- Kategori --}}
  <td class="px-4 py-3">
    @php
    $kategori = data_get($item, 'kategori_item', data_get($item, 'kategori', (data_get($item,'item_type') === 'produk' ? 'Es Krim' : 'Perlengkapan')));
    @endphp

    @if ($kategori === 'Es Krim')
    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-medium">Es Krim</span>
    @else
    <span class="bg-purple-100 text-purple-700 text-xs px-3 py-1 rounded-full font-medium">Perlengkapan</span>
    @endif
  </td>

  {{-- Hitung level --}}
  @php
  $level = intval(data_get($item, 'level_stok', data_get($item, 'stok', 0)));
  $satuan = $kategori === 'Es Krim' ? '%' : ' pcs';
  $tampil = $level . $satuan;
  @endphp

  {{-- TAMPILKAN di <td> --}}
  <td class="px-4 py-3 font-semibold text-sm">
    @if ($kategori === 'Es Krim')
    {{-- Warna untuk Es Krim (persentase) --}}
    @if ($level >= 76)
    <span class="text-green-600">{{ $tampil }}</span>
    @elseif ($level >= 51)
    <span class="text-yellow-600">{{ $tampil }}</span>
    @elseif ($level >= 26)
    <span class="text-orange-600">{{ $tampil }}</span>
    @else
    <span class="text-red-600">{{ $tampil }}</span>
    @endif
    @else

    @php
    $warna = 'text-green-700';
    if ($level <= 15) {
      $warna='text-red-700' ;
      } elseif ($level <=35) {
      $warna='text-yellow-700' ;
      }
      @endphp

      <span class="rounded-full text-sm {{ $warna }}">
      {{ $tampil }}
      </span>
      @endif
  </td>

</tr>
@empty
<tr>
  <td colspan="4" class="py-6 text-gray-500">
    Tidak ada data
  </td>
</tr>
@endforelse