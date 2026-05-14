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
                <form
                    action="{{ route('admin.matakuliah.store') }}"
                    method="POST"
                    class="grid grid-cols-1 gap-4 md:grid-cols-3"
                >
                    @csrf
                    <input
                        type="text"
                        name="kode_mk"
                        placeholder="Kode MK (ex: INF101)"
                        class="rounded-lg border-gray-300 focus:ring-blue-500"
                        required
                    />
                    <input
                        type="text"
                        name="nama_mk"
                        placeholder="Nama Mata Kuliah"
                        class="rounded-lg border-gray-300 focus:ring-blue-500"
                        required
                    />

                    <select
                        name="prodi_id"
                        class="rounded-lg border-gray-300 focus:ring-blue-500"
                        required
                    >
                        <option value="">-- Pilih Prodi Pemilik --</option>
                        @foreach ($prodis as $prodi)
                            <option value="{{ $prodi->id }}">
                                {{ $prodi->nama_prodi }}
                            </option>
                        @endforeach
                    </select>

                    <input
                        type="number"
                        name="sks"
                        placeholder="SKS"
                        class="rounded-lg border-gray-300 focus:ring-blue-500"
                        required
                    />
                    <input
                        type="number"
                        name="skor_prioritas"
                        placeholder="Skor Prioritas (1-100)"
                        class="rounded-lg border-gray-300 focus:ring-blue-500"
                        required
                    />

                    <select
                        name="spesifikasi"
                        class="rounded-lg border-gray-300 focus:ring-blue-500"
                        required
                    >
                        <option value="standar">Spesifikasi: Standar</option>
                        <option value="tinggi">
                            Spesifikasi: Tinggi (Lab 3)
                        </option>
                    </select>

                    <button
                        type="submit"
                        class="rounded-lg bg-blue-600 py-2 font-bold text-white transition hover:bg-blue-700 md:col-span-3"
                    >
                        Simpan Mata Kuliah
                    </button>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
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
                                SKS
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
                                class="px-6 py-3 text-right text-xs font-bold uppercase text-gray-500"
                            >
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
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
                                    {{ $mk->sks }}
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
                                <td class="px-6 py-4 text-right">
                                    <form
                                        action="{{ route('admin.matakuliah.destroy', $mk->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method ("DELETE")
                                        <button
                                            class="text-sm font-bold text-red-500 hover:underline"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
