<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight text-blue-900">
            Master Mata Kuliah
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-6 rounded-2xl bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-bold text-gray-700">
                    Tambah Mata Kuliah Baru
                </h3>
                <div class="flex justify-end">
                    <x-dashboard.modal
                        :action="route('admin.matakuliah.store')"
                        title="Tambah Mata Kuliah"
                        :trigger="'Tambah Mata Kuliah'"
                    >
                        <x-slot:trigger>
                            + Tambah Mata Kuliah Baru
                        </x-slot:trigger>

                        <div class="space-y-4">
                            <!-- Kode Mata Kuliah -->
                            <div>
                                <label
                                    for="kode_mk"
                                    class="mb-1 block text-sm font-medium text-gray-700"
                                    >Kode Mata Kuliah</label
                                >
                                <input
                                    type="text"
                                    id="kode_mk"
                                    name="kode_mk"
                                    placeholder="Kode MK (ex: INF101)"
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500"
                                    required
                                />
                            </div>

                            <!-- Nama Mata Kuliah -->
                            <div>
                                <label
                                    for="nama_mk"
                                    class="mb-1 block text-sm font-medium text-gray-700"
                                    >Nama Mata Kuliah</label
                                >
                                <input
                                    type="text"
                                    id="nama_mk"
                                    name="nama_mk"
                                    placeholder="Nama Mata Kuliah"
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500"
                                    required
                                />
                            </div>

                            <!-- Program Studi -->
                            <div>
                                <label
                                    for="prodi_id"
                                    class="mb-1 block text-sm font-medium text-gray-700"
                                    >Program Studi</label
                                >
                                <select
                                    id="prodi_id"
                                    name="prodi_id"
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500"
                                    required
                                >
                                    <option value="">
                                        -- Pilih Prodi Pemilik --
                                    </option>
                                    @foreach ($prodis as $prodi)
                                        <option value="{{ $prodi->id }}">
                                            {{ $prodi->nama_prodi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- SKS -->
                            <div>
                                <label
                                    for="sks"
                                    class="mb-1 block text-sm font-medium text-gray-700"
                                    >SKS</label
                                >
                                <input
                                    type="number"
                                    id="sks"
                                    name="sks"
                                    placeholder="Jumlah SKS"
                                    value="1"
                                    min="1"
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500"
                                    required
                                />
                            </div>

                            <!-- Semester -->
                            <div>
                                <label
                                    for="semester"
                                    class="mb-1 block text-sm font-medium text-gray-700"
                                    >Semester</label
                                >
                                <input
                                    type="number"
                                    id="semester"
                                    value="1"
                                    min="1"
                                    name="semester"
                                    placeholder="Semester"
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500"
                                    required
                                />
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label
                                    for="kategori"
                                    class="mb-1 block text-sm font-medium text-gray-700"
                                    >Kategori</label
                                >
                                <select
                                    id="kategori"
                                    name="kategori"
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500"
                                    required
                                >
                                    <option value="">
                                        -- Pilih Kategori --
                                    </option>
                                    <option value="teori">Teori</option>
                                    <option value="teori-praktik">
                                        Teori & Praktik
                                    </option>
                                    <option value="praktik">Praktik</option>
                                </select>
                            </div>

                            <!-- Spesifikasi -->
                            <div>
                                <label
                                    for="spesifikasi"
                                    class="mb-1 block text-sm font-medium text-gray-700"
                                    >Spesifikasi</label
                                >
                                <select
                                    id="spesifikasi"
                                    name="spesifikasi"
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500"
                                    required
                                >
                                    <option value="standar">
                                        Spesifikasi: Standar
                                    </option>
                                    <option value="tinggi">
                                        Spesifikasi: Tinggi (Lab 3)
                                    </option>
                                </select>
                            </div>
                        </div>
                    </x-dashboard.modal>
                </div>
            </div>

            <div class="w-full overflow-x-auto rounded-2xl bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500"
                            >
                                Kode
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500"
                            >
                                Nama MK / Prodi
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500"
                            >
                                Semester
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500"
                            >
                                SKS
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500"
                            >
                                Kategori
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500"
                            >
                                Prioritas
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500"
                            >
                                Spek
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500"
                            >
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @if ($matakuliahs->isEmpty())
                            <tr>
                                <td
                                    colspan="7"
                                    class="px-6 py-4 text-center text-gray-500"
                                >
                                    Belum ada mata kuliah. Tambahkan mata kuliah
                                    baru menggunakan form di atas.
                                </td>
                            </tr>
                        @endif
                        @foreach ($matakuliahs as $mk)
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="px-6 py-4 font-mono text-sm">
                                    {{ $mk->kode_mk }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800">
                                        {{ $mk->nama_mk }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{
                                            $mk->prodi
                                                ->nama_prodi
                                        }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="text-white-700 rounded bg-blue-100 px-2 py-1 text-xs font-bold text-blue-800"
                                        >{{ $mk->semester }}</span
                                    >
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $mk->sks }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $mk->kategori }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="rounded bg-orange-100 px-2 py-1 text-xs font-bold text-orange-700"
                                        >{{ $mk->skor_prioritas }}</span
                                    >
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($mk->spesifikasi == "tinggi")
                                        <span class="text-red-600">Tinggi</span>
                                    @else
                                        <span class="text-gray-700"
                                            >Standar</span
                                        >
                                    @endif
                                </td>
                                <td
                                    class="flex items-center justify-center gap-2 px-6 py-6 text-right"
                                >
                                    <x-dashboard.modal
                                        :action="route('admin.matakuliah.update', $mk->id)"
                                        method="PUT"
                                        title="Edit Mata Kuliah"
                                        :triggerAttributes="'text-md text-blue-600 hover:text-blue-800 font-semibold'"
                                        :trigger="'Edit'"
                                    >
                                        <div class="flex flex-col text-start">
                                            <label
                                                for="nama_mk"
                                                class="mb-1 block text-sm font-medium text-gray-700"
                                                >Nama Mata Kuliah</label
                                            >
                                            <input
                                                type="text"
                                                name="nama_mk"
                                                id="nama_mk"
                                                value="{{ $mk->nama_mk }}"
                                                required
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                            />
                                        </div>
                                        <div class="flex flex-col text-start">
                                            <label
                                                for="prodi_id"
                                                class="mb-1 block text-sm font-medium text-gray-700"
                                                >Program Studi</label
                                            >
                                            <select
                                                name="prodi_id"
                                                id="prodi_id"
                                                required
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                            >
                                                <option value="">
                                                    Pilih Program Studi
                                                </option>
                                                @foreach ($prodis as $prodi)
                                                    <option
                                                        value="{{ $prodi->id }}"
                                                        {{
                                                            $mk->prodi_id == $prodi->id
                                                                ? "selected"
                                                                : ""
                                                        }}
                                                    >
                                                        {{ $prodi->nama_prodi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex flex-col text-start">
                                            <label
                                                for="sks"
                                                class="mb-1 block text-sm font-medium text-gray-700"
                                                >SKS</label
                                            >
                                            <input
                                                type="number"
                                                name="sks"
                                                id="sks"
                                                value="{{ $mk->sks }}"
                                                max="6"
                                                required
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                            />
                                        </div>
                                        <div class="flex flex-col text-start">
                                            <label
                                                for="semester"
                                                class="mb-1 block text-sm font-medium text-gray-700"
                                                >Semester</label
                                            >
                                            <input
                                                type="number"
                                                name="semester"
                                                id="semester"
                                                value="{{ $mk->semester ?? 1 }}"
                                                max="8"
                                                required
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                            />
                                        </div>
                                        <div class="flex flex-col text-start">
                                            <label
                                                for="kategori"
                                                class="mb-1 block text-sm font-medium text-gray-700"
                                                >Kategori</label
                                            >
                                            <select
                                                name="kategori"
                                                id="kategori"
                                                required
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                            >
                                                <option
                                                    value="teori"
                                                    {{
                                                        $mk->kategori == "teori"
                                                            ? "selected"
                                                            : ""
                                                    }}
                                                    >Teori
                                                </option>
                                                <option
                                                    value="teori-praktik"
                                                    {{
                                                        $mk->kategori == "teori_praktikum"
                                                            ? "selected"
                                                            : ""
                                                    }}
                                                    >Teori & Praktik
                                                </option>
                                                <option
                                                    value="praktik"
                                                    {{
                                                        $mk->kategori == "praktikum"
                                                            ? "selected"
                                                            : ""
                                                    }}
                                                    >Praktik
                                                </option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col text-start">
                                            <label
                                                for="spesifikasi"
                                                class="mb-1 block text-sm font-medium text-gray-700"
                                                >Spesifikasi</label
                                            >
                                            <select
                                                name="spesifikasi"
                                                id="spesifikasi"
                                                required
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                            >
                                                <option
                                                    value="standar"
                                                    {{
                                                        $mk->spesifikasi == "standar"
                                                            ? "selected"
                                                            : ""
                                                    }}
                                                >
                                                    Standar
                                                </option>
                                                <option
                                                    value="tinggi"
                                                    {{
                                                        $mk->spesifikasi == "tinggi"
                                                            ? "selected"
                                                            : ""
                                                    }}
                                                >
                                                    Tinggi
                                                </option>
                                            </select>
                                        </div>
                                    </x-dashboard.modal>
                                    <div class="h-4 w-px bg-black"></div>
                                    <button
                                        x-data
                                        @click="$dispatch('open-modal-delete-mk-{{ $mk->id }}')"
                                        class="cursor-pointer font-semibold text-red-500 hover:text-red-700"
                                    >
                                        Hapus
                                    </button>
                                    <x-dashboard.modal-confirm
                                        :action="route('admin.matakuliah.destroy', $mk->id)"
                                        method="DELETE"
                                        title="Hapus Mata Kuliah"
                                        type="danger"
                                        confirmText="Ya, Hapus Mata Kuliah Ini"
                                        :id="'delete-mk-' . $mk->id"
                                    >
                                        Apakah Anda yakin ingin menghapus mata
                                        kuliah
                                        <strong>{{ $mk->nama_mk }}</strong>?
                                    </x-dashboard.modal-confirm>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
