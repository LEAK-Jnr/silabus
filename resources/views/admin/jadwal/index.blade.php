<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Manajemen Plotting Jadwal Kuliah") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-2xl">
                
                {{-- Bagian Header: Judul & Tombol Generate --}}
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Jadwal Pekan ke-{{ $pekanAktif }}</h3>
                        <p class="text-sm text-gray-500">Klik tombol generate untuk memproses plotting otomatis berdasarkan prioritas.</p>
                    </div>

                    <form action="{{ route('admin.jadwal.generate') }}" method="POST" onsubmit="return confirm('Sistem akan memplotting ajuan status menunggu berdasarkan skor prioritas. Lanjutkan?')">
                        @csrf
                        <button type="submit" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Generate Jadwal Otomatis
                        </button>
                    </form>
                </div>

                {{-- Bagian Filter Pekan --}}
                <div class="mb-6 flex items-center space-x-4 rounded-xl bg-gray-50 p-4 border border-gray-100">
                    <label class="text-sm font-medium text-gray-700">Pilih Pekan:</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach (range(1, 14) as $p)
                            <a href="{{ route('admin.jadwal.index', ['pekan' => $p]) }}" 
                               class="rounded-lg px-3 py-1 text-sm font-semibold transition {{ $pekanAktif == $p ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100' }}">
                                {{ $p }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Tabel Jadwal --}}
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-300">
                                <th class="p-3 text-sm font-bold uppercase text-gray-700">Waktu & Ruangan</th>
                                <th class="p-3 text-sm font-bold uppercase text-gray-700">Mata Kuliah</th>
                                <th class="p-3 text-sm font-bold uppercase text-gray-700">Dosen</th>
                                <th class="p-3 text-sm font-bold uppercase text-gray-700">Kelas</th>
                                <th class="p-3 text-sm font-bold uppercase text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ajuans as $index => $j)
                                <tr class="text-center odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition">
                                    <td class="p-3 border-b border-gray-100 text-left">
                                        @if($j->hari)
                                            <div class="font-bold text-blue-700">{{ $j->hari }}</div>
                                            <div class="text-xs text-gray-500">{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</div>
                                            <div class="mt-1 text-xs font-semibold text-gray-600 italic">📍 {{ $j->ruangan->nama_ruangan ?? 'N/A' }}</div>
                                        @else
                                            <span class="text-xs italic text-gray-400">Belum di-plot</span>
                                        @endif
                                    </td>
                                    <td class="p-3 border-b border-gray-100 text-left">
                                        <div class="text-sm font-bold">{{ $j->mataKuliah->nama_mk }}</div>
                                        <div class="text-xs text-gray-400">{{ $j->mataKuliah->kode_mk }} ({{ $j->mataKuliah->sks }} SKS)</div>
                                    </td>
                                    <td class="p-3 border-b border-gray-100">
                                        <div class="text-sm font-medium text-gray-700">{{ $j->dosen->name }}</div>
                                    </td>
                                    <td class="p-3 border-b border-gray-100 text-xs">
                                        <span class="font-bold">{{ $j->kelas->kode_kelas }}</span>
                                        <br>
                                        <span class="text-gray-500 text-[10px]">Reg {{ strtoupper($j->kelas->reguler) }}</span>
                                    </td>
                                    <td class="p-3 border-b border-gray-100">
                                        @php
                                            $badgeColor = [
                                                'menunggu' => 'bg-amber-100 text-amber-800',
                                                'disetujui' => 'bg-green-100 text-green-800',
                                                'ditolak' => 'bg-red-100 text-red-800',
                                            ][$j->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-block rounded-full {{ $badgeColor }} px-3 py-1 text-[10px] font-bold uppercase">
                                            {{ $j->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-10 text-center text-gray-400 italic">
                                        Tidak ada ajuan atau jadwal pada pekan ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>