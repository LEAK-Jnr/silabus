<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-900 leading-tight">Master Mata Kuliah</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm mb-6">
                <h3 class="font-bold text-gray-700 mb-4 text-lg">Tambah Mata Kuliah Baru</h3>
                <form action="{{ route('admin.matakuliah.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf
                    <input type="text" name="kode_mk" placeholder="Kode MK (ex: INF101)" class="rounded-lg border-gray-300 focus:ring-blue-500" required>
                    <input type="text" name="nama_mk" placeholder="Nama Mata Kuliah" class="rounded-lg border-gray-300 focus:ring-blue-500" required>
                    
                    <select name="prodi_id" class="rounded-lg border-gray-300 focus:ring-blue-500" required>
                        <option value="">-- Pilih Prodi Pemilik --</option>
                        @foreach($prodis as $prodi)
                            <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                        @endforeach
                    </select>

                    <input type="number" name="sks" placeholder="SKS" class="rounded-lg border-gray-300 focus:ring-blue-500" required>
                    <input type="number" name="skor_prioritas" placeholder="Skor Prioritas (1-100)" class="rounded-lg border-gray-300 focus:ring-blue-500" required>
                    
                    <select name="spesifikasi" class="rounded-lg border-gray-300 focus:ring-blue-500" required>
                        <option value="standar">Spesifikasi: Standar</option>
                        <option value="tinggi">Spesifikasi: Tinggi (Lab 3)</option>
                    </select>

                    <button type="submit" class="md:col-span-3 bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition">
                        Simpan Mata Kuliah
                    </button>
                </form>
            </div>

            <div class="bg-white shadow-sm rounded-2xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama MK / Prodi</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">SKS</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Prioritas</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Spek</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($matakuliahs as $mk)
                        <tr>
                            <td class="px-6 py-4 font-mono text-sm">{{ $mk->kode_mk }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">{{ $mk->nama_mk }}</div>
                                <div class="text-xs text-gray-500">{{ $mk->prodi->nama_prodi }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">{{ $mk->sks }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-bold">{{ $mk->skor_prioritas }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($mk->spesifikasi == 'tinggi')
                                    <span class="text-red-600">🚀 Tinggi</span>
                                @else
                                    <span class="text-gray-400 text-xs">Standar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.matakuliah.destroy', $mk->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline text-sm font-bold">Hapus</button>
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