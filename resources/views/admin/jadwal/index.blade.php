<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{
                __(
                    "Manajemen Plotting Jadwal Kuliah",
                )
            }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-xs sm:rounded-2xl">
                {{-- Bagian Header: Judul & Tombol Generate --}}
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">
                            Jadwal Pekan ke-{{ $pekanAktif }}
                        </h3>
                        <p class="text-sm text-gray-500">Klik tombol generate untuk memproses plotting otomatis berdasarkan prioritas.</p>
                    </div>

                    <div class="flex items-center gap-3">
                        {{-- Area Export PDF --}}
                        <div x-data="{ selectedPekan: '{{ $pekanAktif }}' }" class="flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 p-1.5">
                            <span class="pl-2 text-xs font-semibold text-gray-500">Cetak PDF:</span>
                            <select 
                                x-model="selectedPekan"
                                class="rounded-lg border border-gray-300 bg-white py-1 px-2.5 text-xs font-semibold text-gray-700 shadow-xs focus:border-blue-500 focus:outline-hidden focus:ring-1 focus:ring-blue-500"
                            >
                                <option value="all">Semua Pekan (1-14)</option>
                                @foreach (range(1, 14) as $p)
                                    <option value="{{ $p }}">Pekan {{ $p }}</option>
                                @endforeach
                            </select>
                            
                            <a 
                                :href="selectedPekan === 'all' ? '{{ route('admin.jadwal.export-pdf-all') }}' : '{{ route('admin.jadwal.export-pdf') }}?pekan=' + selectedPekan"
                                class="inline-flex items-center rounded-lg bg-red-600 px-3.5 py-1.5 text-xs font-bold text-white shadow-xs transition hover:bg-red-700"
                            >
                                <svg class="mr-1.5 h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Export
                            </a>
                        </div>

                        <button
                            x-data
                            @click="$dispatch('open-modal-generate-jadwal')"
                            class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-bold text-white shadow-xs transition hover:bg-blue-700"
                        >
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Generate Jadwal Otomatis
                        </button>
                    </div>

                    <x-dashboard.modal-confirm
                        id="generate-jadwal"
                        title="Konfirmasi Generate Jadwal"
                        btnColor="bg-blue-600 hover:bg-blue-700"
                        confirmText="Ya, Generate!"
                        action="{{ route('admin.jadwal.generate') }}"
                        method="POST"
                    >
                        <p>Sistem akan memplotting ajuan status menunggu berdasarkan skor prioritas. Lanjutkan?</p>
                    </x-dashboard.modal-confirm>
                </div>

                {{-- Bagian Filter Pekan --}}
                <div
                    class="mb-6 flex items-center space-x-4 rounded-xl border border-gray-100 bg-gray-50 p-4"
                >
                    <label class="text-sm font-medium text-gray-700"
                        >Pilih Pekan:</label
                    >
                    <div class="flex flex-wrap gap-2">
                        @foreach (range(1, 14) as $p)
                            <a
                                href="{{ route('admin.jadwal.index', ['pekan' => $p]) }}"
                                class="rounded-lg px-3 py-1 text-sm font-semibold transition {{ $pekanAktif == $p ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100' }}"
                            >
                                {{ $p }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Tabel Jadwal --}}
                <div class="overflow-x-auto">
                    <table
                        class="w-full border-collapse border border-gray-200"
                    >
                        <thead>
                            <tr class="bg-gray-300">
                                <th
                                    class="p-3 text-sm font-bold uppercase text-gray-700"
                                >
                                    Waktu & Ruangan
                                </th>
                                <th
                                    class="p-3 text-sm font-bold uppercase text-gray-700"
                                >
                                    Mata Kuliah
                                </th>
                                <th
                                    class="p-3 text-sm font-bold uppercase text-gray-700"
                                >
                                    Dosen
                                </th>
                                <th
                                    class="p-3 text-sm font-bold uppercase text-gray-700"
                                >
                                    Kelas
                                </th>
                                <th
                                    class="p-3 text-sm font-bold uppercase text-gray-700"
                                >
                                    Aksi Presensi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ajuans as $index => $j)
                                <tr
                                    class="text-center transition odd:bg-white even:bg-gray-50 hover:bg-blue-50"
                                >
                                    <td
                                        class="border-b border-gray-100 p-3 text-left"
                                    >
                                        @if ($j->hari)
                                            <div
                                                class="font-bold text-blue-700"
                                            >
                                                {{ $j->hari }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{
                                                    $j->jam_mulai?->format(
                                                        "H:i",
                                                    )
                                                }} - {{
                                                    $j->jam_selesai?->format(
                                                        "H:i",
                                                    )
                                                }}
                                            </div>
                                            <div
                                                class="mt-1 flex items-center gap-2 text-xs font-semibold italic text-gray-600"
                                            >
                                                <span
                                                    ><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 12 12">
                                                        <path d="M0 0h12v12H0z" fill="none" />
                                                        <path fill="#f52323" d="M6 .5A4.5 4.5 0 0 1 10.5 5c0 1.863-1.42 3.815-4.2 5.9a.5.5 0 0 1-.6 0C2.92 8.815 1.5 6.863 1.5 5A4.5 4.5 0 0 1 6 .5m0 3a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3" />
                                                    </svg> </span
                                                >{{
                                                    $j->ruangan->nama_ruangan ??
                                                        "N/A"
                                                }}
                                            </div>
                                        @else
                                            <span
                                                class="text-xs italic text-gray-400"
                                                >Belum di-plot</span
                                            >
                                        @endif
                                    </td>
                                    <td
                                        class="border-b border-gray-100 p-3 text-left"
                                    >
                                        <div class="text-sm font-bold">
                                            {{
                                                $j->mataKuliah
                                                    ->nama_mk
                                            }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $j->mataKuliah->kode_mk }} ({{ $j->mataKuliah->sks }} SKS)
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-100 p-3">
                                        <div
                                            class="text-sm font-medium text-gray-700"
                                        >
                                            {{
                                                $j->dosen
                                                    ->name
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        class="border-b border-gray-100 p-3 text-xs"
                                    >
                                        <span class="font-bold">{{
                                            $j->kelas
                                                ->kode_kelas
                                        }}</span>
                                        <br />
                                        <span class="text-[10px] text-gray-500"
                                            >Reg {{
                                                strtoupper(
                                                    $j->kelas->reguler,
                                                )
                                            }}</span
                                        >
                                    </td>
                                    <td class="border-b border-gray-100 p-3">
                                        @if($j->status === 'menunggu')
                                            <span class="inline-block rounded-full bg-amber-100 px-3 py-1 text-[10px] font-bold uppercase text-amber-800">Menunggu Plotting</span>
                                        @elseif($j->status === 'ditolak')
                                            <span class="inline-block rounded-full bg-red-100 px-3 py-1 text-[10px] font-bold uppercase text-red-800">Ditolak</span>
                                        @else
                                            @php
                                                $now = now();
                                                $jamSelesaiCarbon = $j->jam_selesai ? \Carbon\Carbon::parse($j->jam_selesai) : null;
                                                $isPast = $jamSelesaiCarbon ? $now->greaterThan($jamSelesaiCarbon) : false;
                                                $isNoShow = $isPast && !$j->presensi;
                                            @endphp

                                            @if($isNoShow)
                                                <span class="inline-block rounded-full bg-red-100 px-3 py-1 text-[10px] font-bold uppercase text-red-800">No Show</span>
                                            @elseif(!$j->presensi)
                                                <button
                                                    x-data
                                                    @click="$dispatch('open-modal-checkin-{{ $j->id }}')"
                                                    class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-bold text-white shadow-xs transition hover:bg-blue-700"
                                                >
                                                    Check-in
                                                </button>

                                                <x-dashboard.modal-confirm
                                                    id="checkin-{{ $j->id }}"
                                                    title="Check-in Dosen"
                                                    btnColor="bg-blue-600 hover:bg-blue-700"
                                                    confirmText="Ya, Check-in"
                                                    action="{{ route('admin.jadwal.checkin', $j->id) }}"
                                                    method="POST"
                                                >
                                                    <p>Lakukan check-in untuk dosen <strong>{{ $j->dosen->name }}</strong>?</p>
                                                </x-dashboard.modal-confirm>
                                            @else
                                                <div x-data="{ openDetail: false }">
                                                    <button @click="openDetail = true" class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-bold text-white shadow-xs transition hover:bg-indigo-700">
                                                        Detail
                                                    </button>

                                                    <div x-show="openDetail" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/20 text-left">
                                                        <div @click.away="openDetail = false" class="z-10 m-4 w-full max-w-sm rounded-lg bg-white shadow-xl">
                                                            <div class="flex items-center justify-between border-b border-gray-200 bg-gray-50 px-4 py-3 rounded-t-lg">
                                                                <h3 class="text-base font-bold text-gray-800">Detail Presensi</h3>
                                                                <button @click="openDetail = false" class="text-xl font-bold text-gray-400 hover:text-gray-600">&times;</button>
                                                            </div>
                                                            <div class="p-4 text-sm text-gray-700">
                                                                <p class="mb-2"><strong>Dosen:</strong> {{ $j->dosen->name }}</p>
                                                                <p class="mb-2">
                                                                    <strong>Waktu Masuk:</strong> {{ \Carbon\Carbon::parse($j->presensi->jam_masuk)->format('H:i') }}
                                                                    @if($j->presensi->status === 'terlambat')
                                                                        <span class="font-bold text-red-600">(Telat {{ $j->presensi->keterlambatan_menit }} mnt)</span>
                                                                    @else
                                                                        <span class="font-bold text-green-600">(Tepat)</span>
                                                                    @endif
                                                                </p>
                                                                <p class="mb-2">
                                                                    <strong>Waktu Keluar:</strong> 
                                                                    @if($j->presensi->jam_keluar)
                                                                        {{ \Carbon\Carbon::parse($j->presensi->jam_keluar)->format('H:i') }}
                                                                    @else
                                                                        <span class="italic text-gray-400">Belum check-out</span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div class="flex justify-end border-t border-gray-200 bg-gray-50 px-4 py-3 rounded-b-lg">
                                                                <button @click="openDetail = false" class="rounded bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-300">Tutup</button>
                                                                @if(!$j->presensi->jam_keluar)
                                                                    <button @click="openDetail = false; $dispatch('open-modal-checkout-{{ $j->id }}')" class="ml-2 rounded bg-orange-500 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-600">Check-out</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if(!$j->presensi->jam_keluar)
                                                <x-dashboard.modal-confirm
                                                    id="checkout-{{ $j->id }}"
                                                    title="Check-out Dosen"
                                                    btnColor="bg-orange-500 hover:bg-orange-600"
                                                    confirmText="Ya, Check-out"
                                                    action="{{ route('admin.jadwal.checkout', $j->id) }}"
                                                    method="POST"
                                                >
                                                    <p>Lakukan check-out untuk dosen <strong>{{ $j->dosen->name }}</strong>?</p>
                                                </x-dashboard.modal-confirm>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="5"
                                        class="p-10 text-center italic text-gray-400"
                                    >
                                        Tidak ada ajuan atau jadwal pada pekan
                                        ini.
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
