<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Master Data Dosen") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-xs sm:rounded-2xl">
                <div class="mb-4 flex justify-between">
                    <h3 class="text-lg font-bold">Daftar Dosen</h3>
                    <x-dashboard.modal
                        :action="route('admin.dosen.store')"
                        title="Tambah Dosen"
                    >
                        <x-slot:trigger>
                            + Tambah Dosen Baru
                        </x-slot:trigger>

                        <div>
                            <label for="name" class="mb-1 block text-sm font-medium text-gray-700">Nama Dosen</label>
                            <input type="text" name="name" id="name" required
                                class="w-full rounded-md border-gray-300 shadow-xs focus:border-blue-500 focus:ring-3 focus:ring-blue-200" />
                        </div>

                        <div>
                            <label for="username" class="mb-1 block text-sm font-medium text-gray-700">NIP / NIDOS (Username)</label>
                            <input type="text" name="username" id="username" required
                                class="w-full rounded-md border-gray-300 shadow-xs focus:border-blue-500 focus:ring-3 focus:ring-blue-200" />
                        </div>

                        <div>
                            <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email (Opsional)</label>
                            <input type="email" name="email" id="email"
                                class="w-full rounded-md border-gray-300 shadow-xs focus:border-blue-500 focus:ring-3 focus:ring-blue-200" />
                        </div>

                        <div>
                            <label for="password" class="mb-1 block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" required
                                class="w-full rounded-md border-gray-300 shadow-xs focus:border-blue-500 focus:ring-3 focus:ring-blue-200" />
                        </div>

                        <div>
                            <label for="prodi_id" class="mb-1 block text-sm font-medium text-gray-700">Program Studi</label>
                            <select name="prodi_id" id="prodi_id" class="w-full rounded-md border-gray-300 shadow-xs focus:border-blue-500 focus:ring-3 focus:ring-blue-200">
                                <option value="">-- Pilih Program Studi (Opsional) --</option>
                                @foreach($prodis as $prodi)
                                    <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </x-dashboard.modal>
                </div>

                <table class="w-full border-collapse border border-gray-200 text-sm">
                    <thead>
                        <tr class="bg-gray-300">
                            <th class="p-2 w-12">No</th>
                            <th class="p-2 text-left">Nama Dosen</th>
                            <th class="p-2 text-left">NIP/NIDOS</th>
                            <th class="p-2 text-left">Email</th>
                            <th class="p-2 text-left">Program Studi</th>
                            <th class="p-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dosens as $index => $dosen)
                            <tr class="text-center odd:bg-white even:bg-gray-100">
                                <td class="p-2">{{ $index + 1 }}</td>
                                <td class="p-2 text-left font-medium">{{ $dosen->name }}</td>
                                <td class="p-2 text-left">{{ $dosen->username }}</td>
                                <td class="p-2 text-left">{{ $dosen->email ?? '-' }}</td>
                                <td class="p-2 text-left">
                                    @if($dosen->prodi)
                                        <span class="inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">
                                            {{ $dosen->prodi->nama_prodi }}
                                        </span>
                                    @else
                                        <span class="text-gray-500 italic text-xs">Belum diplot</span>
                                    @endif
                                </td>
                                <td class="flex items-center justify-center space-x-2 p-2">
                                    <x-dashboard.modal
                                        :action="route('admin.dosen.update', $dosen->id)"
                                        method="PUT"
                                        title="Edit Dosen"
                                        :triggerAttributes="'text-blue-600 hover:text-blue-800 font-semibold'"
                                        :trigger="'Edit'"
                                    >
                                        <div class="flex flex-col text-start space-y-3">
                                            <div>
                                                <label for="name_{{ $dosen->id }}" class="mb-1 block text-sm font-medium text-gray-700">Nama Dosen</label>
                                                <input type="text" name="name" id="name_{{ $dosen->id }}" value="{{ $dosen->name }}" required
                                                    class="w-full rounded-md border-gray-300 shadow-xs focus:border-blue-500 focus:ring-3 focus:ring-blue-200" />
                                            </div>

                                            <div>
                                                <label for="username_{{ $dosen->id }}" class="mb-1 block text-sm font-medium text-gray-700">NIP / NIDOS (Username)</label>
                                                <input type="text" name="username" id="username_{{ $dosen->id }}" value="{{ $dosen->username }}" required
                                                    class="w-full rounded-md border-gray-300 shadow-xs focus:border-blue-500 focus:ring-3 focus:ring-blue-200" />
                                            </div>

                                            <div>
                                                <label for="email_{{ $dosen->id }}" class="mb-1 block text-sm font-medium text-gray-700">Email (Opsional)</label>
                                                <input type="email" name="email" id="email_{{ $dosen->id }}" value="{{ $dosen->email }}"
                                                    class="w-full rounded-md border-gray-300 shadow-xs focus:border-blue-500 focus:ring-3 focus:ring-blue-200" />
                                            </div>

                                            <div>
                                                <label for="password_{{ $dosen->id }}" class="mb-1 block text-sm font-medium text-gray-700">Password (Kosongkan jika tidak ingin diubah)</label>
                                                <input type="password" name="password" id="password_{{ $dosen->id }}" placeholder="Biarkan kosong jika tidak diubah"
                                                    class="w-full rounded-md border-gray-300 shadow-xs focus:border-blue-500 focus:ring-3 focus:ring-blue-200" />
                                            </div>

                                            <div>
                                                <label for="prodi_id_{{ $dosen->id }}" class="mb-1 block text-sm font-medium text-gray-700">Program Studi</label>
                                                <select name="prodi_id" id="prodi_id_{{ $dosen->id }}" class="w-full rounded-md border-gray-300 shadow-xs focus:border-blue-500 focus:ring-3 focus:ring-blue-200">
                                                    <option value="">-- Pilih Program Studi (Opsional) --</option>
                                                    @foreach($prodis as $prodi)
                                                        <option value="{{ $prodi->id }}" @selected($dosen->prodi_id == $prodi->id)>
                                                            {{ $prodi->nama_prodi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </x-dashboard.modal>
                                    
                                    <div class="h-4 w-px bg-black"></div>
                                    
                                    <button
                                        x-data
                                        @click="$dispatch('open-modal-delete-dosen-{{ $dosen->id }}')"
                                        class="cursor-pointer font-semibold text-red-500 hover:text-red-700"
                                    >
                                        Hapus
                                    </button>
                                    <x-dashboard.modal-confirm
                                        :action="route('admin.dosen.destroy', $dosen->id)"
                                        method="DELETE"
                                        title="Hapus Dosen"
                                        type="danger"
                                        confirmText="Ya, Hapus Dosen Ini"
                                        :id="'delete-dosen-' . $dosen->id"
                                    >
                                        Apakah Anda yakin ingin menghapus data dosen <strong>{{ $dosen->name }}</strong>?
                                    </x-dashboard.modal-confirm>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data dosen.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
