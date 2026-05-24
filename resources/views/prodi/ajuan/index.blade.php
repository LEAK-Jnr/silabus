<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-blue-900">
            {{
                __(
                    "Panel Ajuan Program Studi",
                )
            }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="mb-4 text-lg font-bold">
                    Selamat Datang, Admin Prodi {{ Auth::user()->name }}
                </h3>
                <p class="text-gray-600">Ini adalah halaman khusus untuk menginput ajuan mata kuliah dan jadwal praktikum.</p>
                {{-- <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700">
                    Sistem sedang disiapkan untuk fitur upload ajuan.
                </div> --}}
                {{-- di bawhah ini modal tambah ajuan --}}
                <div class="flex-co w-fulll flex-col">
    <div class="flex justify-end">
        <x-dashboard.modal :action="route('prodi.ajuan.store')" title="Tambah Ajuan Baru">
            <x-slot:trigger>
                + Tambah Ajuan Baru
            </x-slot:trigger>

            <div class="grid grid-cols-1 gap-4">
                {{-- 1. MATA KULIAH (DATALIST) --}}
                <div>
                    <label for="mk_search" class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
                    <input list="list_mk" id="mk_search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Cari Mata Kuliah...">
                    <datalist id="list_mk">
                        @foreach ($matakuliahs as $mk)
                            <option data-id="{{ $mk->id }}" value="{{ $mk->nama_mk }}">
                        @endforeach
                    </datalist>
                    <input type="hidden" name="kode_mk" id="kode_mk" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    {{-- 2. KODE KELAS (DATALIST) --}}
                    <div>
                        <label for="kelas_search" class="block text-sm font-medium text-gray-700">Kode Kelas</label>
                        <input list="list_kelas" id="kelas_search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Cari Kelas...">
                        <datalist id="list_kelas">
                            @foreach ($kelases as $kelas)
                                <option data-id="{{ $kelas->id }}" value="{{ $kelas->kode_kelas }} ({{ $kelas->reguler }})">
                            @endforeach
                        </datalist>
                        <input type="hidden" name="kode_kelas" id="kode_kelas" required>
                    </div>

                    {{-- 3. PEKAN (TETAP SELECT KARENA HANYA 14 OPSI) --}}
                    <div>
                        <label for="pekan" class="block text-sm font-medium text-gray-700">Pekan Ke-</label>
                        <select id="pekan" name="pekan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                            <option value="">Pilih Pekan</option>
                            @for ($i = 1; $i <= 14; $i++)
                                <option value="{{ $i }}">Pekan {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                {{-- 4. DOSEN (DATALIST) --}}
                <div>
                    <label for="dosen_search" class="block text-sm font-medium text-gray-700">Dosen Pengampu</label>
                    <input list="list_dosen" id="dosen_search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Cari Nama Dosen...">
                    <datalist id="list_dosen">
                        @foreach ($dosenPengampu as $dosen)
                            <option data-id="{{ $dosen->username }}" value="{{ $dosen->name }}">
                        @endforeach
                    </datalist>
                    <input type="hidden" name="user_username" id="user_username" required>
                </div>

                {{-- 5. RUANGAN (DATALIST) --}}
                <div>
                    <label for="ruangan_id" class="block text-sm font-medium text-gray-700">Ruangan Ajuan</label>
                    <select 
                        id="ruangan_id" 
                        name="ruangan_id" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                        required
                    >
                        <option value="">Pilih Ruangan</option>
                            @foreach ($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}">
                                    {{ $ruangan->nama_ruangan }} (Kap: {{ $ruangan->kapasitas }} | {{ $ruangan->spesifikasi }})
                                </option>
                            @endforeach
                    </select>
                </div>
            </div>
        </x-dashboard.modal>
    </div>
</div>

{{-- akhir modal ajuan --}}
                <div
                    class="bg-neutral-primary-soft shadow-xs rounded-base border-default relative mt-5 w-full overflow-x-auto border"
                >
                    <table
                        class="text-body w-full text-left text-sm rtl:text-right"
                    >
                        <thead
                            class="bg-neutral-secondary-soft border-default border-b"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Kode
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Mata Kuliah
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Kelas
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Reguler
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Pekan
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Dosen Pengampu
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Ruangan
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Tanggal Pengajuan
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Update Terakhir
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($ajuans->isEmpty())
                                <tr>
                                    <td
                                        colspan="11"
                                        class="px-6 py-4 text-center text-gray-500"
                                    >
                                        Belum ada ajuan yang dibuat.
                                    </td>
                                </tr>
                            @endif
                            @foreach ($ajuans as $ajuan)
                                <tr
                                    class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-default border-b"
                                >
                                    <td class="px-6 py-4">
                                        {{
                                            $ajuan->mataKuliah->kode_mk ??
                                                "-"
                                        }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{
                                            $ajuan->mataKuliah->nama_mk ??
                                                "-"
                                        }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{
                                            $ajuan->kelas->kode_kelas ??
                                                "-"
                                        }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{
                                            $ajuan->kelas->reguler ??
                                                "-"
                                        }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span
                                            class="rounded bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800"
                                        >
                                            {{
                                                $ajuan->pekan ??
                                                    "-"
                                            }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        {{
                                            $ajuan->dosen->name ??
                                                "-"
                                        }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{
                                            $ajuan->ruangan
                                                ? $ajuan->ruangan->nama_ruangan
                                                : "-"
                                        }}
                                    </td>

                                    <td
                                        class="px-6 py-4 font-semibold {{ 
                    $ajuan->status === 'menunggu' ? 'text-yellow-600' : 
                    ($ajuan->status === 'disetujui' ? 'text-green-600' : 
                    ($ajuan->status === 'ditolak' ? 'text-red-600' : '')) 
                }}"
                                    >
                                        {{
                                            ucfirst(
                                                $ajuan->status ?? "-",
                                            )
                                        }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{
                                            $ajuan->created_at
                                                ->timezone("Asia/Jakarta")
                                                ->locale("id_ID")
                                                ->isoFormat("D MMMM YYYY, HH:mm")
                                        }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{
                                            $ajuan->updated_at
                                                ->timezone("Asia/Jakarta")
                                                ->locale("id_ID")
                                                ->isoFormat("D MMMM YYYY, HH:mm")
                                        }}
                                    </td>

                                    @if ($ajuan->status === "disetujui")
                                        <td class="px-6 py-4">
                                            <span class="italic text-gray-500">
                                                -
                                            </span>
                                        </td>
                                    @else
                                        <td class="px-6 py-4">
                                            <div
                                                class="flex flex-row items-center justify-start gap-2"
                                            >
                                                {{-- modal edit --}}
                                                <x-dashboard.modal 
    :action="route('prodi.ajuan.update', $ajuan->id)" 
    method="PUT" 
    title="Edit Ajuan" 
    :triggerAttributes="'text-blue-600 hover:text-blue-800 font-semibold'" 
    :trigger="'Edit'"
>
    <div class="grid grid-cols-1 gap-4 text-left">
        {{-- 1. MATA KULIAH (DATALIST) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
            <input 
                list="edit_list_mk" 
                id="edit_mk_search_{{ $ajuan->id }}" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" 
                placeholder="Cari Mata Kuliah..."
                value="{{ $ajuan->mataKuliah->nama_mk ?? '' }}"
            >
            <datalist id="edit_list_mk">
                @foreach ($matakuliahs as $mk)
                    <option data-id="{{ $mk->id }}" value="{{ $mk->nama_mk }}">
                @endforeach
            </datalist>
            <input type="hidden" name="kode_mk" id="edit_kode_mk_{{ $ajuan->id }}" value="{{ $ajuan->kode_mk }}" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            {{-- 2. KODE KELAS (DATALIST) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Kode Kelas</label>
                <input 
                    list="edit_list_kelas" 
                    id="edit_kelas_search_{{ $ajuan->id }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" 
                    placeholder="Cari Kelas..."
                    value="{{ $ajuan->kelas->kode_kelas ?? '' }} - Reg {{ $ajuan->kelas->reguler ?? '' }}"
                >
                <datalist id="edit_list_kelas">
                    @foreach ($kelases as $kelas)
                        <option data-id="{{ $kelas->id }}" value="{{ $kelas->kode_kelas }} - Reg {{ $kelas->reguler }}">
                    @endforeach
                </datalist>
                <input type="hidden" name="kode_kelas" id="edit_kode_kelas_{{ $ajuan->id }}" value="{{ $ajuan->kode_kelas }}" required>
            </div>

            {{-- 3. PEKAN (SELECT TETAP) --}}
            <div>
                <label for="pekan" class="block text-sm font-medium text-gray-700">Pekan Perkuliahan</label>
                <select name="pekan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                    @foreach ($pekans as $p)
                        <option value="{{ $p }}" {{ $ajuan->pekan == $p ? 'selected' : '' }}>Pekan {{ $p }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- 4. DOSEN (DATALIST) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Dosen Pengampu</label>
            <input 
                list="edit_list_dosen" 
                id="edit_dosen_search_{{ $ajuan->id }}" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" 
                placeholder="Cari Nama Dosen..."
                value="{{ $ajuan->dosen->name ?? '' }}"
            >
            <datalist id="edit_list_dosen">
                @foreach ($dosenPengampu as $dosen)
                    <option data-id="{{ $dosen->username }}" value="{{ $dosen->name }}">
                @endforeach
            </datalist>
            <input type="hidden" name="user_username" id="edit_user_username_{{ $ajuan->id }}" value="{{ $ajuan->user_username }}" required>
        </div>

        {{-- 5. RUANGAN (KEMBALI KE SELECT SESUAI REQUEST) --}}
        <div>
            <label for="ruangan_id" class="block text-sm font-medium text-gray-700">Ruangan Ajuan</label>
            <select name="ruangan_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                @foreach ($ruangans as $ruangan)
                    <option value="{{ $ruangan->id }}" {{ $ajuan->ruangan_id == $ruangan->id ? 'selected' : '' }}>
                        {{ $ruangan->nama_ruangan }} (Kapasitas: {{ $ruangan->kapasitas }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</x-dashboard.modal>
{{-- akhir modal edit --}}
                                                <div
                                                    class="h-4 w-px bg-black"
                                                ></div>

                                                <button
                                                    x-data
                                                    @click="$dispatch('open-modal-delete-ajuan-{{ $ajuan->id }}')"
                                                    class="cursor-pointer font-semibold text-red-500 hover:text-red-700"
                                                >
                                                    Hapus
                                                </button>

                                                <x-dashboard.modal-confirm
                                                    id="delete-ajuan-{{ $ajuan->id }}"
                                                    action="{{ route('prodi.ajuan.destroy', $ajuan->id) }}"
                                                    method="DELETE"
                                                    title="Hapus Ajuan"
                                                    type="danger"
                                                    confirmText="Ya, Hapus Ajuan Ini"
                                                >
                                                    Apakah Anda yakin ingin
                                                    menghapus ajuan mata kuliah
                                                    <strong>{{
                                                        $ajuan->mataKuliah->nama_mk ??
                                                            "N/A"
                                                    }}</strong
                                                    >?
                                                </x-dashboard.modal-confirm>
                                            </div>
                                        </td>

                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi utama untuk menghubungkan input pencarian dengan ID tersembunyi
        function setupDatalist(inputId, listId, hiddenId) {
            const input = document.getElementById(inputId);
            const list = document.getElementById(listId);
            const hidden = document.getElementById(hiddenId);

            if(!input || !list || !hidden) return;

            input.addEventListener('input', function() {
                const options = list.querySelectorAll('option');
                let foundValue = "";
                
                options.forEach(option => {
                    if (option.value === input.value) {
                        foundValue = option.getAttribute('data-id');
                    }
                });
                
                // Masukkan ID asli ke input hidden agar bisa dikirim ke database
                hidden.value = foundValue;
                console.log('Input:', inputId, 'ID Set to:', foundValue); // Untuk debugging di console
            });
        }

        // --- 1. INISIALISASI UNTUK MODAL TAMBAH ---
        // Pastikan ID ini sesuai dengan yang ada di modal tambah Anda
        setupDatalist('mk_search', 'list_mk', 'kode_mk');
        setupDatalist('kelas_search', 'list_kelas', 'kode_kelas');
        setupDatalist('dosen_search', 'list_dosen', 'user_username');

        // --- 2. INISIALISASI UNTUK SEMUA MODAL EDIT (DINAMIS) ---
        // Kita menggunakan looping blade untuk mendaftarkan ID unik tiap baris
        @foreach($ajuans as $ajuan)
            setupDatalist('edit_mk_search_{{ $ajuan->id }}', 'edit_list_mk', 'edit_kode_mk_{{ $ajuan->id }}');
            setupDatalist('edit_kelas_search_{{ $ajuan->id }}', 'edit_list_kelas', 'edit_kode_kelas_{{ $ajuan->id }}');
            setupDatalist('edit_dosen_search_{{ $ajuan->id }}', 'edit_list_dosen', 'edit_user_username_{{ $ajuan->id }}');
        @endforeach
    });
</script>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
