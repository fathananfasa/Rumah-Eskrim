<x-app-layout>
    <div class="py-10 bg-[#fff8e6] min-h-screen">
        <div class="max-w-5xl mx-auto space-y-8 sm:px-6 lg:px-8">
             @if (session('success'))
    <div class="mt-6 mb-6 mx-auto max-w-5xl">
        <div class="bg-green-100 text-green-700 px-5 py-4 rounded-xl shadow-sm">
            {{ session('success') }}
        </div>
    </div>
@endif

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
                <div>
                    <h1 class="mt-4 sm:mt-0 text-2xl sm:text-3xl font-bold flex items-center gap-2 text-gray-800">
                        Profil Pengguna
                    </h1>
                    <p class="text-gray-600 text-sm sm:text-base">Kelola informasi akun dan pengaturan</p>
                </div>
            </div>

            <!-- Kartu Profil -->
            <div class="bg-white rounded-xl shadow p-6 
    flex sm:flex-row flex-col 
    sm:items-center items-start 
    sm:space-x-6 space-x-0 space-y-4 sm:space-y-0">

                <!-- Avatar -->
                <div class="w-20 h-20 flex items-center justify-center rounded-full bg-gray-100 text-2xl font-bold text-gray-500 mx-auto sm:mx-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <!-- Info -->
                <div class="text-center sm:text-left 
        flex flex-col items-center sm:items-start w-full">

                    <h3 class="text-xl font-semibold text-gray-800">
                        Nama: {{ $user->name }}
                    </h3>

                    <p class="text-gray-600">
                        Role: {{ ucfirst($user->role) }}
                    </p>

                    <p class="flex items-center justify-center sm:justify-start text-gray-600 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="h-4 w-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        {{ $user->email }}
                    </p>
                </div>
            </div>



            <!-- Kelola Akun Pengguna -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center items-start gap-3 mb-4">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-shield fa-thin text-purple-500"></i>
                        <h3 class="text-lg font-semibold text-gray-800">Kelola Akun Pengguna</h3>
                    </div>
                    <button id="btnTambahAkun"
                        class="flex items-center bg-[#CDC1FF] text-white px-4 py-2 font-semibold rounded-lg hover:bg-[#b7a8ff] 
    w-full sm:w-auto justify-center sm:justify-start">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H6a1 1 0 010-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Tambah Akun
                    </button>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    @foreach ($users as $u)
                    <div class="border border-purple-200 rounded-xl p-4 flex items-start justify-between hover:shadow-md transition">

                        <!-- Kiri -->
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full text-gray-500 font-semibold">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>

                            <div class="space-y-1">
                                <p class="font-semibold text-gray-800">{{ $u->name }}</p>
                                <p class="text-sm text-gray-600 leading-tight">{{ ucfirst($u->role) }}</p>
                                <p class="text-xs text-gray-500 leading-tight">{{ $u->email }}</p>
                            </div>
                        </div>

                        <!-- Kanan -->
                        <div class="flex space-x-2 mt-1">
                            <button
                                class="w-8 h-8 flex items-center justify-center rounded-[8px] bg-blue-100 text-blue-700"
                                onclick="openEditModal({{ $u->id_user}}, '{{ $u->name }}', '{{ $u->email }}', '{{ $u->role }}')">
                                <i class="far fa-edit text-sm"></i>
                            </button>

                            <form action="{{ route('admin.users.destroy', $u->id_user) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus akun ini?')">
                                @csrf
                                @method('DELETE')

                                <button
                                    class="w-8 h-8 flex items-center justify-center rounded-[8px] bg-red-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-4 h-4 text-red-700">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                    </div>

                    @endforeach
                </div>
            </div>

            <!-- Logout -->
            <div class="bg-[#fff1e6] border border-[#ffd6cc] rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-800 mb-1">Keluar dari Akun</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Anda akan keluar dari sistem inventory. Pastikan semua perubahan sudah disimpan.
                </p>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <!-- Wrapper agar tombol berada di tengah hanya di HP -->
                    <div class="flex justify-center sm:justify-start">
                        <button type="submit"
                            class="flex items-center bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 002 2h4a2 2 0 002-2v-1m0-10V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v1" />
                            </svg>
                            Logout
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal Tambah Akun -->
    <div id="modalTambahAkun"
        class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <div class="mb-4 text-left">
                <h2 class="text-xl font-semibold text-gray-900">Tambah Akun Baru</h2>
                <p class="text-sm text-gray-500">Masukkan informasi pengguna baru</p>
            </div>
            <button id="btnCloseModal"
                class="absolute top-3 right-4 text-gray-500 hover:text-gray-700 text-xl">
                ×
            </button>

            <form method="POST" action="{{ route('admin.register') }}">
                @csrf
                <div>
                    <label class="block font-medium text-sm text-gray-700">Nama</label>
                    <input type="text" name="name" placeholder="Masukkan nama"
                        class="border-gray-300 rounded-md w-full mt-1 bg-gray-100" required>
                </div>

                <div class="mt-3">
                    <label class="block font-medium text-sm text-gray-700">Email</label>
                    <input type="email" name="email" placeholder="Masukkan email"
                        class="border-gray-300 rounded-md w-full mt-1 bg-gray-100" required>
                </div>

                <div class="mt-3">
                    <label class="block font-medium text-sm text-gray-700">Password</label>
                    <input type="password" name="password" placeholder="Masukkan password"
                        class="border-gray-300 rounded-md w-full mt-1 bg-gray-100" required>
                </div>

                <div class="mt-3">
                    <label class="block font-medium text-sm text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi password"
                        class="border-gray-300 rounded-md w-full mt-1 bg-gray-100" required>
                </div>

                <div class="mt-3">
                    <label class="block font-medium text-sm text-gray-700">Role</label>
                    <select name="role" class="border-gray-300 rounded-md w-full mt-1 bg-gray-100">
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="mt-5 flex justify-end space-x-3">
                    <button type="button" id="btnBatal"
                        class="border border-red-500 text-red-500 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Akun -->
    <div id="modalEditAkun"
        class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <div class="mb-4 text-left">
                <h2 class="text-xl font-semibold text-gray-900">Edit Akun Pengguna</h2>
                <p class="text-sm text-gray-500">Ubah informasi pengguna</p>
            </div>
            <button id="btnCloseEditModal"
                class="absolute top-3 right-4 text-gray-500 hover:text-gray-700 text-xl">×</button>

            <form id="formEditAkun" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-medium text-sm text-gray-700">Nama</label>
                    <input type="text" id="editName" name="name"
                        class="border-gray-300 rounded-md w-full mt-1 bg-gray-100" required>
                </div>

                <div class="mt-3">
                    <label class="block font-medium text-sm text-gray-700">Email</label>
                    <input type="email" id="editEmail" name="email"
                        class="border-gray-300 rounded-md w-full mt-1 bg-gray-100" required>
                </div>

                <div class="mt-3">
                    <label class="block font-medium text-sm text-gray-700">Role</label>
                    <select id="editRole" name="role"
                        class="border-gray-300 rounded-md w-full mt-1 bg-gray-100">
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="mt-3">
                    <label class="block font-medium text-sm text-gray-700">New Password</label>
                    <input type="password" name="password" placeholder="Masukkan password baru"
                        class="border-gray-300 rounded-md w-full mt-1 bg-gray-100">
                </div>

                <div class="mt-3">
                    <label class="block font-medium text-sm text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru"
                        class="border-gray-300 rounded-md w-full mt-1 bg-gray-100">
                </div>

                <div class="mt-5 flex justify-end space-x-3">
                    <button type="button" id="btnBatalEdit"
                        class="border border-red-500 text-red-500 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modalTambahAkun');
        const editModal = document.getElementById('modalEditAkun');
        const btnTambah = document.getElementById('btnTambahAkun');
        const btnClose = document.getElementById('btnCloseModal');
        const btnBatal = document.getElementById('btnBatal');
        const btnCloseEdit = document.getElementById('btnCloseEditModal');
        const btnBatalEdit = document.getElementById('btnBatalEdit');
        const formEdit = document.getElementById('formEditAkun');

        btnTambah.addEventListener('click', () => modal.classList.remove('hidden'));
        btnClose.addEventListener('click', () => modal.classList.add('hidden'));
        btnBatal.addEventListener('click', () => modal.classList.add('hidden'));
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });

        btnCloseEdit.addEventListener('click', () => editModal.classList.add('hidden'));
        btnBatalEdit.addEventListener('click', () => editModal.classList.add('hidden'));
        editModal.addEventListener('click', (e) => {
            if (e.target === editModal) editModal.classList.add('hidden');
        });

        function openEditModal(id_, name, email, role) {
            editModal.classList.remove('hidden');
            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value = role;
            formEdit.action = `/admin/users/${id_}`;
        }
    </script>
</x-app-layout>