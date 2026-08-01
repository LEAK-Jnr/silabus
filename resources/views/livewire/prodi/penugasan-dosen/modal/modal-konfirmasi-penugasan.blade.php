<div>
    {{-- Modal Konfirmasi Penugasan Dosen --}}
    <flux:modal name="konfirmasi-penugasan-dosen" class="max-w-4xl" :dismissible="false">
        <div class="space-y-6">
            <!-- Header Modal -->
            <div>
                <flux:heading size="lg" class="flex items-center gap-2">
                    <flux:icon name="exclamation-triangle" class="text-amber-500" variant="mini" />
                    Konfirmasi {{ $counter ?? 0 }} Penugasan Kelas
                </flux:heading>
                <flux:text class="mt-1">
                    Silakan periksa kembali detail penugasan dosen pengampu berikut sebelum disimpan ke database.
                </flux:text>
            </div>
            <!-- Tabel Ringkasan Konfirmasi -->
            <div
                class="max-h-80 overflow-y-auto border border-zinc-200 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900">
                <flux:table class="w-full text-sm">
                    <flux:table.columns
                        class="sticky top-0 z-10 bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 shadow-sm">
                        <flux:table.column class="w-12 text-center bg-inherit">No.</flux:table.column>
                        <flux:table.column class="w-28 text-center bg-inherit">Kode Kelas</flux:table.column>
                        <flux:table.column class="min-w-48 bg-inherit">Mata Kuliah</flux:table.column>
                        <flux:table.column class="min-w-48 bg-inherit">Dosen Pengampu</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @forelse ($data ?? [] as $index => $item)
                            @php
                                $isValid = $item['is_valid'] ?? true;
                            @endphp
                            <flux:table.row
                                class="align-middle odd:bg-white even:bg-zinc-50/50 dark:odd:bg-zinc-900 dark:even:bg-zinc-800/30 {{ !$isValid ? 'text-red-500 line-through dark:text-red-400' : '' }}">
                                {{-- Kolom No --}}
                                <flux:table.cell
                                    class="text-center font-medium text-xs {{ $isValid ? 'text-zinc-500' : '' }}">
                                    {{ $index + 1 }}
                                </flux:table.cell>
                                {{-- Kolom Kode Kelas --}}
                                <flux:table.cell class="text-center whitespace-nowrap">
                                    <span
                                        class="inline-block px-2.5 py-1 rounded text-xs font-bold border {{ !$isValid ? 'bg-red-100 border-red-300 text-red-700 dark:bg-red-950/50 dark:border-red-900' : 'bg-emerald-50 border-emerald-200 text-emerald-700 dark:bg-emerald-950/40 dark:border-emerald-800 dark:text-emerald-400' }}">
                                        {{ $item['kode_kelas'] }}
                                    </span>
                                </flux:table.cell>
                                {{-- Kolom Mata Kuliah --}}
                                <flux:table.cell
                                    class="{{ $isValid ? 'text-zinc-800 dark:text-zinc-200 font-medium' : '' }}">
                                    {{ $item['matakuliah_name'] }}
                                </flux:table.cell>
                                {{-- Kolom Dosen Pengampu --}}
                                <flux:table.cell class="{{ $isValid ? 'text-zinc-600 dark:text-zinc-400' : '' }}">
                                    {{ $item['dosen_name'] }}
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="4" class="text-center py-8 text-zinc-400 italic">
                                    Tidak ada data penugasan untuk dikonfirmasi.
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </div>
            <!-- Tombol Aksi (Footer Modal) -->
            <div class="flex items-center justify-between pt-2">
                <flux:button type="button" variant="ghost" wire:click="backToForm">
                    &larr; Kembali & Ubah
                </flux:button>
                <div class="flex items-center gap-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>
                    <flux:button type="button" variant="primary" wire:click="store">
                        Simpan Penugasan
                    </flux:button>
                </div>
            </div>
        </div>
    </flux:modal>

    <x-dashboard.modal-confirm id="single-add-penugasan-ajuan" title="Konfirmasi Penugasan Dosen" type="info"
        confirmText="Simpan Penugasan" wire:click="storeSinglePenugasan">
        <div class="space-y-3">
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                Apakah Anda yakin ingin menambahkan penugasan dosen berdasarkan data berikut ini?
            </p>
            {{-- Ringkasan Data Penugasan --}}
            <div
                class="p-3 bg-blue-50 dark:bg-blue-950/30 border border-blue-100 dark:border-blue-900/50 rounded-lg text-xs space-y-1.5">
                <div class="flex justify-between text-blue-900 dark:text-blue-200">
                    <span class="font-medium">Dosen Ditugaskan:</span>
                    <span class="font-bold text-right">
                        {{ $dataPenugasan['nama_dosen'] ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between text-blue-900 dark:text-blue-200">
                    <span class="font-medium">Mata Kuliah:</span>
                    <span class="font-bold text-right text-blue-700 dark:text-blue-400">
                        {{ $dataPenugasan['nama_mk'] ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between text-blue-800 dark:text-blue-300">
                    <span class="font-medium">Kelas:</span>
                    <span class="font-semibold text-right">
                        {{ $dataPenugasan['kode_kelas'] ?? '-' }} - Reg
                        {{ substr($dataPenugasan['reguler'] ?? '-', -1) }} - Smt.
                        {{ $dataPenugasan['semester'] ?? '-' }}
                    </span>
                </div>
            </div>
        </div>
    </x-dashboard.modal-confirm>

    {{-- Modal Konfirmasi hapus --}}
    <x-dashboard.modal-confirm id="hapus-penugasan" title="Hapus Penugasan" type="danger"
        confirmText="Ya, Hapus Penugasan Ini" wire:click="destroy({{ $dataHapus['id'] ?? '-' }})">
        <div class="space-y-3">
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                Apakah Anda yakin ingin menghapus Penugasan ini? Tindakan ini tidak dapat dibatalkan.
            </p>

            <div
                class="p-3 bg-red-50 dark:bg-red-950/30 border border-red-100 dark:border-red-900/50 rounded-lg text-xs space-y-1">
                <div class="flex justify-between text-red-800 dark:text-red-300">
                    <span class="font-medium">Dosen:</span>
                    <span class="font-bold">
                        {{ $dataHapus['nama_dosen'] ?? '-' }}
                    </span>
                </div>
                <div class="flex justify-between text-red-800 dark:text-red-300">
                    <span class="font-medium">Mata Kuliah:</span>
                    <span class="font-bold">
                        {{ $dataHapus['nama_mk'] ?? '-' }}
                    </span>
                </div>
                <div class="flex justify-between text-red-700 dark:text-red-400">
                    <span>Kelas & Semester:</span>
                    <span class="font-semibold">
                        {{ $dataHapus['kode_kelas'] ?? '-' }}
                        - Semester
                        {{ $dataHapus['semester'] ?? '-' }}
                    </span>
                </div>
                <div class="flex justify-between text-red-800 dark:text-red-300">
                    <span class="font-medium">Reguler:</span>
                    <span class="font-bold">
                        {{ $dataHapus['reguler'] ?? '-' }}
                    </span>
                </div>
            </div>
            <div
                class="p-2.5 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/50 rounded-lg text-xs text-amber-800 dark:text-amber-300">
                <p>
                    <strong>Catatan:</strong> Dosen yang ditugaskan pada mata kuliah dan kelas ini akan dikosongkan dari
                    tabel Ajuan.
                </p>
            </div>

            <flux:heading class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                Apakah Anda yakin ingin melanjutkan?
            </flux:heading>
        </div>
    </x-dashboard.modal-confirm>
</div>