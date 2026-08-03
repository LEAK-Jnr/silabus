<div>
    {{-- Modal Konfirmasi Hapus --}}
    <x-dashboard.modal-confirm id="hapus-ajuan" title="Hapus Ajuan" type="danger" confirmText="Ya, Hapus Ajuan Ini"
        wire:click="destroy({{ $dataHapus['id'] ?? '-'}})">
        <div class="space-y-3">
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                Apakah Anda yakin ingin menghapus ajuan jadwal praktikum ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            {{-- konten --}}
            <div
                class="p-3 bg-red-50 dark:bg-red-950/30 border border-red-100 dark:border-red-900/50 rounded-lg text-xs space-y-1">
                <div class="flex justify-between text-red-800 dark:text-red-300">
                    <span class="font-medium">Mata Kuliah:</span>
                    <span class="font-bold">
                        {{ $dataHapus['nama_mk'] ?? '-'}}
                    </span>
                </div>
                <div class="flex justify-between text-red-800 dark:text-red-300">
                    <span class="font-medium">Dosen:</span>
                    <span class="font-bold">
                        {{ $dataHapus['nama_dosen'] ?? '-'}}
                    </span>
                </div>
                <div class="flex justify-between text-red-700 dark:text-red-400">
                    <span>Pekan & Kelas:</span>
                    <span class="font-semibold">
                        Pekan {{ $dataHapus['pekan'] ?? '-'}}
                        -
                        {{ $dataHapus['kelas'] ?? '-'}}
                    </span>
                </div>
                <div class="flex justify-between text-red-800 dark:text-red-300">
                    <span class="font-medium">Ruangan:</span>
                    <span class="font-bold">
                        {{ $dataHapus['ruangan'] ?? '-'}}
                    </span>
                </div>
            </div>
        </div>
    </x-dashboard.modal-confirm>
    {{-- modal konfirmasi ajuan bulk --}}
    <flux:modal name="konfirm-bulk-ajuan-prodi" class="max-w-4xl" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg" class="flex items-center gap-2">
                    <flux:icon name="exclamation-triangle" class="text-amber-500" variant="mini" />
                    Konfirmasi {{ $counter }} Ajuan Jadwal
                </flux:heading>
                <flux:text class="mt-1">Silakan periksa kembali detail ajuan kelompok praktikum berikut sebelum disimpan
                    ke database.</flux:text>
            </div>

            <div
                class="max-h-80 overflow-y-auto border border-zinc-200 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900">
                <flux:table class="w-full text-sm">
                    <flux:table.columns
                        class="sticky top-0 z-10 bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 shadow-sm">
                        <flux:table.column class="w-px whitespace-nowrap text-center bg-inherit">No.</flux:table.column>
                        <flux:table.column class="w-28 whitespace-nowrap bg-inherit">Pekan</flux:table.column>
                        <flux:table.column class="w-24 text-center whitespace-nowrap bg-inherit">Kelas
                        </flux:table.column>
                        <flux:table.column class="min-w-48 bg-inherit">Mata Kuliah</flux:table.column>
                        <flux:table.column class="min-w-30 bg-inherit">Dosen Pengampu
                        </flux:table.column>
                        <flux:table.column class="min-w-44 bg-inherit">Ruangan / Lab</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse ($data ?? [] as $index => $item)
                            @php
                                $kelasId = $item['id_kelas'];
                                $isInvalid = is_null($kelasId);
                                $nama_dosen = ($item['nama_dosen'] === 'unselected') ? true : false;
                            @endphp

                            <flux:table.row
                                class="align-middle odd:bg-white even:bg-zinc-50/50 dark:odd:bg-zinc-900 dark:even:bg-zinc-800/30 {{ $isInvalid ? 'text-red-500 line-through dark:text-red-400' : '' }}">

                                <flux:table.cell
                                    class="text-center font-medium text-xs {{ !$isInvalid ? 'text-zinc-500' : '' }}">
                                    {{ $index + 1 }}
                                </flux:table.cell>

                                <flux:table.cell
                                    class="whitespace-nowrap font-medium {{ !$isInvalid ? 'text-zinc-900 dark:text-zinc-100' : '' }}">
                                    Pekan {{ $item['pekan'] }}
                                </flux:table.cell>

                                <flux:table.cell class="text-center whitespace-nowrap">
                                    <span
                                        class="inline-block px-2 py-0.5 rounded text-xs font-bold border {{ $isInvalid ? 'bg-red-100 border-red-300 text-red-700 dark:bg-red-950/50 dark:border-red-900' : 'bg-zinc-100 border-zinc-200 text-zinc-700 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-300' }}">
                                        {{ $item['kelas'] }}
                                    </span>
                                </flux:table.cell>

                                <flux:table.cell
                                    class="{{ !$isInvalid ? 'text-zinc-800 dark:text-zinc-200 font-medium' : '' }}">
                                    {{ $item['nama_mk'] }}
                                </flux:table.cell>

                                <flux:table.cell>
                                    <span
                                        class=" inline-block px-2 py-0.5 rounded text-xs font-bold border {{ $nama_dosen ? 'bg-red-100 border-red-300 text-red-700 dark:bg-red-950/50 dark:border-red-900' : 'bg-zinc-100 border-zinc-200 text-zinc-700 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-300' }}">
                                        {{ $item['nama_dosen'] }}
                                    </span>
                                </flux:table.cell>

                                <flux:table.cell
                                    class="font-medium {{ !$isInvalid ? 'text-zinc-600 dark:text-zinc-400' : '' }}">
                                    {{ $item['ruangan_praktikum'] == 3 ? "Lab Komputer Tinggi (Lab Komputer 03)" : "Lab Komputer Standar (Lab Komputer 01/02)" }}
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="6" class="text-center py-8 text-zinc-400 italic">
                                    Tidak ada data untuk dikonfirmasi.
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </div>

            <flux:text class="mt-2 text-center text-red-500">Kelas merah artinya kelas tidak/belum terdaftar pada
                database. Maka baris tersebut
                tidak akan ditambahkan pada ajuan.</flux:text>
            <div class="flex items-center justify-between pt-2">
                <flux:button type="button" variant="ghost" wire:click="backConfirm">
                    &larr; Kembali & Ubah
                </flux:button>
                <div class="flex items-center gap-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary" color="green" icon="check" wire:click="addBulkAjuan">
                        Simpan Semua Ajuan
                    </flux:button>
                </div>
            </div>
        </div>
    </flux:modal>

    {{-- modal konfirmasi ajuan by penugasan --}}
    <flux:modal name="konfirm-ajuan-by-penugasan" class="max-w-4xl" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg" class="flex items-center gap-2">
                    <flux:icon name="exclamation-triangle" class="text-amber-500" variant="mini" />
                    Konfirmasi {{ $counter }} Ajuan Jadwal
                </flux:heading>
                <flux:text class="mt-1">Silakan periksa kembali detail ajuan kelompok praktikum berikut sebelum disimpan
                    ke database.</flux:text>
            </div>

            <div
                class="max-h-80 overflow-y-auto border border-zinc-200 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900">
                <flux:table class="w-full text-sm">
                    <flux:table.columns
                        class="sticky top-0 z-10 bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 shadow-sm">
                        <flux:table.column class="w-px whitespace-nowrap text-center bg-inherit">No.</flux:table.column>
                        <flux:table.column class="w-28 whitespace-nowrap bg-inherit">Pekan</flux:table.column>
                        <flux:table.column class="w-24 text-center whitespace-nowrap bg-inherit">Kelas
                        </flux:table.column>
                        <flux:table.column class="min-w-48 bg-inherit">Mata Kuliah</flux:table.column>
                        <flux:table.column class="min-w-40 bg-inherit">Dosen Pengampu</flux:table.column>
                        <flux:table.column class="min-w-44 bg-inherit">Ruangan / Lab</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse ($data ?? [] as $index => $item)
                            @php
                                $kelasId = $item['id_kelas'];
                                $isInvalid = is_null($kelasId);
                            @endphp

                            <flux:table.row
                                class="align-middle odd:bg-white even:bg-zinc-50/50 dark:odd:bg-zinc-900 dark:even:bg-zinc-800/30 {{ $isInvalid ? 'text-red-500 line-through dark:text-red-400' : '' }}">

                                <flux:table.cell
                                    class="text-center font-medium text-xs {{ !$isInvalid ? 'text-zinc-500' : '' }}">
                                    {{ $index + 1 }}
                                </flux:table.cell>

                                <flux:table.cell
                                    class="whitespace-nowrap font-medium {{ !$isInvalid ? 'text-zinc-900 dark:text-zinc-100' : '' }}">
                                    Pekan {{ $item['pekan'] }}
                                </flux:table.cell>

                                <flux:table.cell class="text-center whitespace-nowrap">
                                    <span
                                        class="inline-block px-2 py-0.5 rounded text-xs font-bold border {{ $isInvalid ? 'bg-red-100 border-red-300 text-red-700 dark:bg-red-950/50 dark:border-red-900' : 'bg-zinc-100 border-zinc-200 text-zinc-700 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-300' }}">
                                        {{ $item['kelas'] }}
                                    </span>
                                </flux:table.cell>

                                <flux:table.cell
                                    class="{{ !$isInvalid ? 'text-zinc-800 dark:text-zinc-200 font-medium' : '' }}">
                                    {{ $item['nama_mk'] }}
                                </flux:table.cell>

                                <flux:table.cell
                                    class="{{ !$isInvalid ? 'text-zinc-600 dark:text-zinc-400' : '' }} {{ $nama_dosen ? 'text-red-500' : '' }}">
                                    {{ $item['nama_dosen'] }}
                                </flux:table.cell>

                                <flux:table.cell
                                    class="font-medium {{ !$isInvalid ? 'text-zinc-600 dark:text-zinc-400' : '' }}">
                                    {{ $item['ruangan_praktikum'] == 3 ? "Lab Komputer Tinggi (Lab Komputer 03)" : "Lab Komputer Standar (Lab Komputer 01/02)" }}
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="6" class="text-center py-8 text-zinc-400 italic">
                                    Tidak ada data untuk dikonfirmasi.
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </div>

            <flux:text class="mt-2 text-center text-red-500">Kelas merah artinya kelas tidak/belum terdaftar pada
                database. Maka baris tersebut
                tidak akan ditambahkan pada ajuan.</flux:text>
            <div class="flex items-center justify-between pt-2">
                <flux:button type="button" variant="ghost" wire:click="backConfirm({{ $idPenugasan }})">
                    &larr; Kembali & Ubah
                </flux:button>
                <div class="flex items-center gap-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary" color="green" icon="check"
                        wire:click="addAjuanPenugasan">
                        Simpan Semua Ajuan
                    </flux:button>
                </div>
            </div>
        </div>
    </flux:modal>
</div>