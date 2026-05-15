<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Master Data Ruangan Laboratorium") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-2xl">
                <div class="mb-4 flex justify-between">
                    <h3 class="text-lg font-bold">Daftar Ruangan</h3>
                    <x-dashboard.modal
                        :action="route('admin.ruangan.store')"
                        title="Tambah Ruangan Baru"
                    >
                        <x-slot:trigger>
                            + Tambah Ruangan Baru
                        </x-slot:trigger>

                        <div class="space-y-4">
                            <div>
                                <label for="nama_ruangan" class="mb-1 block text-sm font-medium text-gray-700">Nama Ruangan</label>
                                <input
                                    type="text"
                                    name="nama_ruangan"
                                    id="nama_ruangan"
                                    placeholder="Contoh: Lab Komputer 01"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                />
                            </div>

                            <div>
                                <label for="kapasitas" class="mb-1 block text-sm font-medium text-gray-700">Kapasitas (Orang)</label>
                                <input
                                    type="number"
                                    name="kapasitas"
                                    id="kapasitas"
                                    placeholder="Contoh: 30"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                />
                            </div>

                            <div>
                                <label for="spesifikasi" class="mb-1 block text-sm font-medium text-gray-700">Spesifikasi</label>
                                <select name="spesifikasi" id="spesifikasi" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="standar">Standar</option>
                                    <option value="tinggi">Tinggi (High-Spec)</option>
                                </select>
                            </div>
                        </div>
                    </x-dashboard.modal>
                </div>

                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-300">
                            <th class="p-2">No</th>
                            <th class="p-2">Nama Ruangan</th>
                            <th class="p-2">Kapasitas</th>
                            <th class="p-2">Spesifikasi</th>
                            <th class="p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ruangans as $index => $r)
                            <tr class="text-center odd:bg-white even:bg-gray-100">
                                <td class="p-2">{{ $index + 1 }}</td>
                                <td class="p-2 text-left">{{ $r->nama_ruangan }}</td>
                                <td class="p-2">{{ $r->kapasitas }} Kursi</td>
                                <td class="p-2">
                                    <span class="inline-block rounded-full {{ $r->spesifikasi == 'tinggi' ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800' }} px-3 py-1 text-xs font-semibold">
                                        {{ ucfirst($r->spesifikasi) }}
                                    </span>
                                </td>
                                <td class="flex items-center justify-center space-x-2 p-2">
                                    <x-dashboard.modal
                                        :action="route('admin.ruangan.update', $r->id)"
                                        method="PUT"
                                        title="Edit Ruangan"
                                        :triggerAttributes="'text-blue-600 hover:text-blue-800 font-semibold'"
                                        :trigger="'Edit'"
                                    >
                                        <div class="flex flex-col space-y-4 text-start">
                                            <div>
                                                <label for="nama_ruangan" class="mb-1 block text-sm font-medium text-gray-700">Nama Ruangan</label>
                                                <input
                                                    type="text"
                                                    name="nama_ruangan"
                                                    value="{{ $r->nama_ruangan }}"
                                                    required
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                                />
                                            </div>
                                            <div>
                                                <label for="kapasitas" class="mb-1 block text-sm font-medium text-gray-700">Kapasitas</label>
                                                <input
                                                    type="number"
                                                    name="kapasitas"
                                                    value="{{ $r->kapasitas }}"
                                                    required
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                                />
                                            </div>
                                            <div>
                                                <label for="spesifikasi" class="mb-1 block text-sm font-medium text-gray-700">Spesifikasi</label>
                                                <select name="spesifikasi" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                    <option value="standar" {{ $r->spesifikasi == 'standar' ? 'selected' : '' }}>Standar</option>
                                                    <option value="tinggi" {{ $r->spesifikasi == 'tinggi' ? 'selected' : '' }}>Tinggi (High-Spec)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </x-dashboard.modal>
                                    <div class="h-4 w-px bg-black"></div>
                                    <button
                                        x-data
                                        @click="$dispatch('open-modal-delete-ruangan-{{ $r->id }}')"
                                        class="cursor-pointer font-semibold text-red-500 hover:text-red-700"
                                    >
                                        Hapus
                                    </button>
                                    <x-dashboard.modal-confirm
                                        :action="route('admin.ruangan.destroy', $r->id)"
                                        method="DELETE"
                                        title="Hapus Ruangan"
                                        type="danger"
                                        confirmText="Ya, Hapus"
                                        :id="'delete-ruangan-' . $r->id"
                                    >
                                        Apakah Anda yakin ingin menghapus <strong>{{ $r->nama_ruangan }}</strong>?
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