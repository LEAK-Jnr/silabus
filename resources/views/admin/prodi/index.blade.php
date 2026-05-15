<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{
                __(
                    "Master Data Program Studi",
                )
            }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-2xl">
                <div class="mb-4 flex justify-between">
                    <h3 class="text-lg font-bold">Daftar Prodi</h3>
                    <x-dashboard.modal
                        :action="route('admin.prodi.store')"
                        title="Tambah Program Studi"
                    >
                        <x-slot:trigger>
                            + Tambah Prodi Baru
                        </x-slot:trigger>

                        <div>
                            <label
                                for="nama_prodi"
                                class="mb-1 block text-sm font-medium text-gray-700"
                                >Nama Prodi</label
                            >
                            <input
                                type="text"
                                name="nama_prodi"
                                id="nama_prodi"
                                placeholder="Contoh: S1 Sastra Indonesia"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            />
                        </div>

                        <div>
                            <label
                                for="kode_prodi"
                                class="mb-1 block text-sm font-medium text-gray-700"
                                >Bobot Prioritas</label
                            >
                            <input
                                type="number"
                                name="bobot_prioritas"
                                id="bobot_prioritas"
                                value="1"
                                max="5"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            />
                        </div>
                    </x-dashboard.modal>
                </div>

                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-300">
                            <th class="p-2">No</th>
                            <th class="p-2">Nama Prodi</th>
                            <th class="p-2">Bobot Prioritas</th>
                            <th class="p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prodis as $index => $p)
                            <tr
                                class="text-center odd:bg-white even:bg-gray-100"
                            >
                                <td class="p-2">{{ $index + 1 }}</td>
                                <td class="p-2 text-left">
                                    {{ $p->nama_prodi }}
                                </td>
                                <td class="p-2">
                                    <p class="inline-block rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-800">
                                        {{ $p->bobot_prioritas }}
                                    </p>
                                </td>
                                <td
                                    class="flex items-center justify-center space-x-2 p-2"
                                >
                                    <x-dashboard.modal
                                        :action="route('admin.prodi.update', $p->id)"
                                        method="PUT"
                                        title="Edit Prodi"
                                        :triggerAttributes="'text-blue-600 hover:text-blue-800 font-semibold'"
                                        :trigger="'Edit'"
                                    >
                                        <div class="flex flex-col text-start">
                                            <label
                                                for="nama_prodi"
                                                class="mb-1 block text-sm font-medium text-gray-700"
                                                >Nama Prodi</label
                                            >
                                            <input
                                                type="text"
                                                name="nama_prodi"
                                                id="nama_prodi"
                                                value="{{ $p->nama_prodi }}"
                                                required
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                            />
                                        </div>
                                        <div class="flex flex-col text-start">
                                            <label
                                                for="bobot_prioritas"
                                                class="mb-1 block text-sm font-medium text-gray-700"
                                                >Bobot Prioritas</label
                                            >
                                            <input
                                                type="number"
                                                name="bobot_prioritas"
                                                id="bobot_prioritas"
                                                value="{{ $p->bobot_prioritas }}"
                                                max="5"
                                                required
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                            />
                                        </div>
                                    </x-dashboard.modal>
                                    <div class="h-4 w-px bg-black"></div>
                                    <button
                                        x-data
                                        @click="$dispatch('open-modal-delete-prodi-{{ $p->id }}')"
                                        class="cursor-pointer font-semibold text-red-500 hover:text-red-700"
                                    >
                                        Hapus
                                    </button>
                                    <x-dashboard.modal-confirm
                                        :action="route('admin.prodi.destroy', $p->id)"
                                        method="DELETE"
                                        title="Hapus Prodi"
                                        type="danger"
                                        confirmText="Ya, Hapus Prodi Ini"
                                        :id="'delete-prodi-' . $p->id"
                                    >
                                        Apakah Anda yakin ingin menghapus prodi
                                        <strong>{{ $p->nama_prodi }}</strong>?
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
