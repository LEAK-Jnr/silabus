<div>
    {{-- header from Layout --}}
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-blue-900">
            Penugasan Dosen
        </h2>
    </x-slot>

    {{-- header --}}
    <div class="py-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-xs sm:rounded-lg">
                <h3 class="mb-4 text-lg font-bold">
                    Penugasan Dosen Program Studi
                </h3>
                <p class="text-gray-600">Plotting dosen ke mata kuliah dan kelas yang diampu.
                </p>
            </div>
        </div>
    </div>

    {{-- Title --}}
    <flux:heading size="xl" class="text-center pt-4 text-black">Daftar Penugasan Dosen</flux:heading>

    {{-- Filter section --}}
    <div
        class="flex flex-col md:flex-row md:items-end md:justify-between bg-white rounded-lg shadow-md mx-4 md:mx-10 p-4 md:p-5 mt-5 gap-3">
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            {{-- field Dosen --}}
            <div class="w-full sm:w-56">
                <livewire:prodi.partials.dosen-field-searchable wire:model.live="idDosen" context="filter" />
            </div>

            {{-- field mata kuliah --}}
            <div class="w-full sm:w-56">
                <livewire:prodi.partials.matakuliah-field-searchable wire:model.live="idMatakuliah" context="filter" />
            </div>

            {{-- field kelas --}}
            <div class="w-full sm:w-40">
                <livewire:prodi.partials.kelas-field-searchable wire:model.live="idKelas" context="filter" />
            </div>
        </div>

        <div class="w-full sm:w-auto">
            <flux:button icon="plus" variant="primary" color="green" wire:click="addPenugasan">
                Add Penugasan
            </flux:button>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="bg-white p-3 m-4 rounded-lg shadow-md">
        <div
            class="mx-4 mt-5 mb-5 rounded-xl border border-zinc-200 bg-white shadow-sm md:mx-10 dark:border-zinc-800 dark:bg-zinc-900">
            <div class="overflow-x-auto">
                <flux:table class="w-full text-sm">
                    {{-- Header Tabel --}}
                    <flux:table.columns class="bg-cyan-50 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-200">
                        <flux:table.column class="w-12 text-center">No</flux:table.column>
                        <flux:table.column class="min-w-40 text-left">Dosen Pengampu</flux:table.column>
                        <flux:table.column class="min-w-40 text-left">Kelas</flux:table.column>
                        <flux:table.column class="min-w-40 text-left">Mata Kuliah</flux:table.column>
                        <flux:table.column class="min-w-36 text-center">Action</flux:table.column>
                    </flux:table.columns>
                    {{-- Isi Baris Data --}}
                    <flux:table.rows>
                        @forelse ($this->penugasanDosens as $index => $item)
                            <flux:table.row wire:key="penugasan-{{ $item->id }}"
                                class="align-middle odd:bg-white even:bg-cyan-50/40 hover:bg-cyan-50 dark:odd:bg-zinc-900 dark:even:bg-zinc-800/30 dark:hover:bg-zinc-800/60">
                                {{-- 1. No --}}
                                <flux:table.cell class="text-center font-medium text-zinc-500 dark:text-zinc-400">
                                    {{ $index + 1 }}
                                </flux:table.cell>

                                {{-- 2. Dosen Pengampu --}}
                                <flux:table.cell class="whitespace-nowrap font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $item->dosen->name ?? '-' }}
                                </flux:table.cell>

                                {{-- 3. Kelas --}}
                                <flux:table.cell class="whitespace-nowrap">
                                    <span class="block font-semibold text-zinc-900 dark:text-zinc-100">
                                        {{ $item->kelas->kode_kelas ?? '-' }}
                                    </span>
                                    <span class="mt-0.5 block text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $item->kelas->reguler ?? '-' }} &middot; Semester
                                        {{ $item->mataKuliah->semester ?? '-' }}
                                    </span>
                                </flux:table.cell>

                                {{-- 4. Mata Kuliah --}}
                                <flux:table.cell class="font-medium text-zinc-800 dark:text-zinc-200">
                                    {{ $item->mataKuliah->nama_mk ?? '-' }}
                                </flux:table.cell>

                                {{-- 5. Action --}}
                                <flux:table.cell class="whitespace-nowrap text-center">
                                    <div
                                        class="flex flex-col items-stretch justify-center gap-2 sm:flex-row sm:items-center">
                                        <flux:button wire:click="editPenugasan({{ $item->id }})" size="sm" variant="primary"
                                            icon="pencil-square" color="blue">
                                            Edit
                                        </flux:button>
                                        <flux:button wire:click="deletePenugasan({{ $item->id }})" size="sm"
                                            variant="danger" icon="trash">
                                            Hapus
                                        </flux:button>
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="5"
                                    class="py-8 text-center italic text-zinc-400 dark:text-zinc-500">
                                    Belum ada data penugasan dosen.
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </div>

            {{-- Pagination --}}
            <div class="border-t border-zinc-200 px-4 py-4 dark:border-zinc-800">
                {{ $this->penugasanDosens->links() }}
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <livewire:prodi.penugasan-dosen.modal.modal-penugasan-dosen />
    {{-- Modal Konfirmasi --}}
    <livewire:prodi.penugasan-dosen.modal.modal-konfirmasi-penugasan />
</div>