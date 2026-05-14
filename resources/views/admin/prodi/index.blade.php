<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Data Program Studi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-bold">Daftar Prodi</h3>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Prodi</button>
                </div>

                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">No</th>
                            <th class="border p-2">Nama Prodi</th>
                            <th class="border p-2">Bobot Prioritas</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prodis as $index => $p)
                        <tr class="text-center">
                            <td class="border p-2">{{ $index + 1 }}</td>
                            <td class="border p-2 text-left">{{ $p->nama_prodi }}</td>
                            <td class="border p-2">{{ $p->bobot_prioritas }}</td>
                            <td class="border p-2">
                                <button class="text-green-600">Edit</button> | 
                                <button class="text-red-600">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>