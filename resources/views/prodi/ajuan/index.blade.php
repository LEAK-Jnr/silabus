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
                <p class="mb-4 mt-4 flex items-center rounded-lg bg-slate-100 px-5 py-5 shadow-md"><span class="mr-4"><svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <g fill="none"><path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                            <path fill="#001a69" d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2m-.01 8H11a1 1 0 0 0-.117 1.993L11 12v4.99c0 .52.394.95.9 1.004l.11.006h.49a1 1 0 0 0 .596-1.803L13 16.134V11.01c0-.52-.394-.95-.9-1.004zM12 7a1 1 0 1 0 0 2a1 1 0 0 0 0-2" /></g>
                    </svg> </span>Ajuan yang sudah <span class="font-bold text-green-500">&nbsp;disetujui&nbsp;</span> tidak dapat<span class="font-bold text-blue-500">&nbsp;edit&nbsp;</span>atau <span class="font-bold text-red-500">&nbsp;hapus&nbsp;</span>. Harap diperhatikan.</p>
                {{-- <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700">
                    Sistem sedang disiapkan untuk fitur upload ajuan.
                </div> --}}
                <div class="flex-co w-fulll flex-col">
                    <div class="flex justify-end">
                        <x-dashboard.modal
                            :action="route('prodi.ajuan.store')"
                            title="Tambah Ajuan Baru"
                        >
                            <x-slot:trigger>
                                + Tambah Ajuan Baru
                            </x-slot:trigger>

                            <div class="grid grid-cols-1 gap-4">
                                {{-- Ditambahkan gap agar antar baris tidak rapat --}}
                                <div>
                                    <label
                                        for="kode_mk"
                                        class="block text-sm font-medium text-gray-700"
                                        >Mata Kuliah</label
                                    >
                                    <select
                                        id="kode_mk"
                                        name="kode_mk"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    >
                                        <option value="">
                                            Pilih Mata Kuliah
                                        </option>
                                        @foreach ($matakuliahs as $mk)
                                            <option value="{{ $mk->id }}">
                                                {{ $mk->nama_mk }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    {{-- Saya bagi dua kolom agar lebih compact --}}
                                    <div>
                                        <label
                                            for="kode_kelas"
                                            class="block text-sm font-medium text-gray-700"
                                            >Kode Kelas</label
                                        >
                                        <select
                                            id="kode_kelas"
                                            name="kode_kelas"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            required
                                        >
                                            <option value="">
                                                Pilih Kode Kelas
                                            </option>
                                            @foreach ($kelases as $kelas)
                                                <option
                                                    value="{{ $kelas->id }}"
                                                >
                                                    {{ $kelas->kode_kelas }} -
                                                    Reg {{ $kelas->reguler }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- --- MODIFIKASI: INPUT PEKAN --- --}}
                                    <div>
                                        <label
                                            for="pekan"
                                            class="block text-sm font-medium text-gray-700"
                                            >Pekan Ke-</label
                                        >
                                        <select
                                            id="pekan"
                                            name="pekan"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            required
                                        >
                                            <option value="">
                                                Pilih Pekan
                                            </option>
                                            @for ($i = 1; $i <= 14; $i++)
                                                <option value="{{ $i }}">
                                                    Pekan {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label
                                        for="username_dosen"
                                        class="block text-sm font-medium text-gray-700"
                                        >Dosen Pengampu</label
                                    >
                                    <select
                                        id="username_dosen"
                                        name="username_dosen"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        required
                                    >
                                        <option value="">
                                            Pilih Dosen Pengampu
                                        </option>
                                        @foreach ($dosenPengampu as $dosen)
                                            <option
                                                value="{{ $dosen->username }}"
                                            >
                                                {{ $dosen->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label
                                        for="ruangan_id"
                                        class="block text-sm font-medium text-gray-700"
                                        >Ruangan Ajuan</label
                                    >
                                    <select
                                        id="ruangan_id"
                                        name="ruangan_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        required
                                    >
                                        <option value="">Pilih Ruangan</option>
                                        @foreach ($ruangans as $ruangan)
                                            <option value="{{ $ruangan->id }}">
                                                {{ $ruangan->nama_ruangan }} (Kapasitas: {{ $ruangan->kapasitas }} |
                                                Spek: {{ $ruangan->spesifikasi }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </x-dashboard.modal>
                    </div>
                </div>
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

                                    <td class="px-6 py-4">
                                        <div
                                            class="flex flex-row items-center justify-start gap-2"
                                        >
                                            <x-dashboard.modal
                                                :action="route('prodi.ajuan.update', $ajuan->id)"
                                                method="PUT"
                                                title="Edit Ajuan"
                                                :triggerAttributes="'text-blue-600 hover:text-blue-800 font-semibold'"
                                                :trigger="'Edit'"
                                            >
                                                <div
                                                    class="grid grid-cols-1 gap-4"
                                                >
                                                    <div>
                                                        <label
                                                            for="kode_mk"
                                                            class="block text-sm font-medium text-gray-700"
                                                            >Mata Kuliah</label
                                                        >
                                                        <select
                                                            id="kode_mk"
                                                            name="kode_mk"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                                        >
                                                            <option value="">
                                                                Pilih Mata
                                                                Kuliah
                                                            </option>
                                                            @foreach ($matakuliahs as $mk)
                                                                <option
                                                                    value="{{ $mk->id }}"
                                                                    {{
                                                                        $mk->id === $ajuan->kode_mk
                                                                            ? "selected"
                                                                            : ""
                                                                    }}
                                                                    >{{ $mk->nama_mk }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label
                                                            for="pekan"
                                                            class="block text-sm font-medium text-gray-700"
                                                            >Pekan
                                                            Perkuliahan</label
                                                        >
                                                        <select
                                                            id="pekan"
                                                            name="pekan"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                                            required
                                                        >
                                                            @for ($i = 1; $i <= 16; $i++)
                                                                <option
                                                                    value="{{ $i }}"
                                                                    {{
                                                                        $ajuan->pekan == $i
                                                                            ? "selected"
                                                                            : ""
                                                                    }}
                                                                    >Pekan {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label
                                                            for="kode_kelas"
                                                            class="block text-sm font-medium text-gray-700"
                                                            >Kode Kelas</label
                                                        >
                                                        <select
                                                            id="kode_kelas"
                                                            name="kode_kelas"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                                            required
                                                        >
                                                            @foreach ($kelases as $kelas)
                                                                <option
                                                                    value="{{ $kelas->id }}"
                                                                    {{
                                                                        $kelas->id === $ajuan->kode_kelas
                                                                            ? "selected"
                                                                            : ""
                                                                    }}
                                                                    >{{ $kelas->kode_kelas }} -
                                                                    Reg {{ $kelas->reguler }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label
                                                            for="username_dosen"
                                                            class="block text-sm font-medium text-gray-700"
                                                            >Dosen
                                                            Pengampu</label
                                                        >
                                                        <select
                                                            id="username_dosen"
                                                            name="username_dosen"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                                            required
                                                        >
                                                            @foreach ($dosenPengampu as $dosen)
                                                                <option
                                                                    value="{{ $dosen->username }}"
                                                                    {{
                                                                        $dosen->username ===
                                                                        $ajuan->username_dosen
                                                                            ? "selected"
                                                                            : ""
                                                                    }}
                                                                    >{{ $dosen->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label
                                                            for="ruangan_id"
                                                            class="block text-sm font-medium text-gray-700"
                                                            >Ruangan
                                                            Ajuan</label
                                                        >
                                                        <select
                                                            id="ruangan_id"
                                                            name="ruangan_id"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                                            required
                                                        >
                                                            @foreach ($ruangans as $ruangan)
                                                                <option
                                                                    value="{{ $ruangan->id }}"
                                                                    {{
                                                                        $ruangan->id === $ajuan->ruangan_id
                                                                            ? "selected"
                                                                            : ""
                                                                    }}
                                                                    >{{ $ruangan->nama_ruangan }} (Kapasitas: {{ $ruangan->kapasitas }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label
                                                            for="status"
                                                            class="block text-sm font-medium text-gray-700"
                                                            >Status Ajuan</label
                                                        >
                                                        <select
                                                            id="status"
                                                            name="status"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                                            required
                                                        >
                                                            @foreach (["menunggu", "disetujui", "ditolak"] as $status)
                                                                <option
                                                                    value="{{ $status }}"
                                                                    {{
                                                                        $status === $ajuan->status
                                                                            ? "selected"
                                                                            : ""
                                                                    }}
                                                                    >{{
                                                                        ucfirst(
                                                                            $status,
                                                                        )
                                                                    }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </x-dashboard.modal>

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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($errors->any())
                        <div
                            class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-800"
                        >
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
