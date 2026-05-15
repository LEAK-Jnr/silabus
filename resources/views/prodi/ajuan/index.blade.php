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
                <div class="flex-co w-fulll flex-col">
                    <!-- FORM -->
                    <form
                        class="w-full p-4"
                        method="POST"
                        action="{{ route('prodi.ajuan.store') }}"
                    >
                        @csrf
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div>
                                <label
                                    for="mata_kuliah"
                                    class="block text-sm font-medium text-gray-700"
                                    >Mata Kuliah</label
                                >
                                <select
                                    id="mata_kuliah"
                                    name="mata_kuliah"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                >
                                    <option value="">Pilih Mata Kuliah</option>
                                    @foreach ($ajuans as $ajuan)
                                        <option
                                            value="{{ $ajuan->mataKuliah->id }}"
                                        >
                                            {{
                                                $ajuan->mataKuliah
                                                    ->nama_mk
                                            }}
                                        </option>
                                    @endforeach
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
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                >
                                    <option value="">Pilih Kode Kelas</option>
                                    @foreach ($ajuans as $ajuan)
                                        <option
                                            value="{{ $ajuan->kelas->kode_kelas }}"
                                        >
                                            {{
                                                $ajuan->kelas
                                                    ->kode_kelas
                                            }} - Reg {{ $ajuan->kelas->reguler }}
                                        </option>
                                    @endforeach
                                </select>
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
                                >
                                    <option value="">
                                        Pilih Dosen Pengampu
                                    </option>
                                    @foreach ($dosenPengampu as $dosen)
                                        <option value="{{ $dosen->username }}">
                                            {{ $dosen->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- TABEL (Otomatis Ke Bawah karena Form sudah ditutup dengan benar) -->
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
                                    Dosen Pengampu
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
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
                                        {{
                                            $ajuan->dosen->name ??
                                                "-"
                                        }}
                                    </td>

                                    @if ($ajuan->status === "menunggu")
                                        <td
                                            class="px-6 py-4 font-semibold text-yellow-600"
                                        >
                                            Menunggu
                                        </td>
                                    @elseif ($ajuan->status === "disetujui")
                                        <td
                                            class="px-6 py-4 font-semibold text-green-600"
                                        >
                                            Disetujui
                                        </td>
                                    @elseif ($ajuan->status === "ditolak")
                                        <td
                                            class="px-6 py-4 font-semibold text-red-600"
                                        >
                                            Ditolak
                                        </td>
                                    @else
                                        <td class="px-6 py-4">
                                            {{
                                                $ajuan->status ??
                                                    "-"
                                            }}
                                        </td>
                                    @endif

                                    <td
                                        class="flex flex-row items-center gap-2 px-6 py-4"
                                    >
                                        <p class="cursor-pointer text-blue-500 hover:text-blue-700">Edit</p>
                                        <p>|</p>
                                        <p class="cursor-pointer text-red-500 hover:text-red-700">Hapus</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
