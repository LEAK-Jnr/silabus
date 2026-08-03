<div>
    {{-- Header from layout --}}
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-blue-900">
            Ajuan Praktikum
        </h2>
    </x-slot>

    {{-- header --}}
    <div class="py-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-xs sm:rounded-lg">
                <h3 class="mb-4 text-lg font-bold">
                    Panel Ajuan Program Studi
                </h3>
                <p class="text-gray-600">Ini adalah halaman khusus untuk menginput ajuan mata kuliah dan jadwal
                    praktikum.
                </p>
            </div>
        </div>
    </div>
    {{-- subtitle --}}
    <flux:heading size="xl" class="text-center pt-4 text-black">Ajuan Praktikum</flux:heading>

    {{-- filter section --}}
    <div
        class="flex flex-col md:flex-row md:items-end md:justify-between bg-white rounded-lg shadow-md mx-4 md:mx-10 p-4 md:p-5 mt-5 gap-3">
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            {{-- Filter Ruangan --}}
            <div class="w-full sm:w-56">
                <livewire:prodi.partials.filter-ruangan wire:model.live="idRuangan" context="filter" />
            </div>
            {{-- Filter Pekan --}}
            <div class="w-full sm:w-40">
                <livewire:prodi.partials.filter-pekan wire:model.live="pekan" context="filter" />
            </div>
            {{-- Filter Dosen --}}
            <div class="w-full sm:w-56">
                <livewire:prodi.partials.dosen-field-searchable wire:model.live="idDosen" context="filter" />
            </div>
            {{-- Filter Status --}}
            <div class="w-full sm:w-40">
                <flux:select wire:model.live="status" label="Status">
                    <flux:select.option value="">Semua Status</flux:select.option>
                    <flux:select.option value="menunggu">Menunggu</flux:select.option>
                    <flux:select.option value="ditolak">Ditolak</flux:select.option>
                </flux:select>
            </div>
        </div>
        {{-- Button tambah Ajuan --}}
        <div class="w-full sm:w-auto">
            <flux:button icon="plus" variant="primary" color="green" wire:click="addAjuan">
                Add Ajuan
            </flux:button>
        </div>
    </div>

    {{-- table section --}}
    <div class="bg-white rounded-lg shadow-md mx-4 md:mx-10 pb-4 md:py-5 px-4 md:px-5 mt-5 mb-5">
        <div class="overflow-x-auto -mx-4 md:-mx-5">
            <div class="px-4 md:px-5">
                <flux:table class="w-full text-sm md:text-base">
                    <flux:table.columns class="bg-gray-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200">
                        <flux:table.column class="w-px whitespace-nowrap text-center">No.</flux:table.column>
                        <flux:table.column class="w-56">Ruangan / Lab</flux:table.column>
                        <flux:table.column class="w-24 whitespace-nowrap">Pekan</flux:table.column>
                        <flux:table.column class="min-w-56">Mata Kuliah</flux:table.column>
                        <flux:table.column class="min-w-44">Dosen Pengampu</flux:table.column>
                        <flux:table.column class="w-24 text-center whitespace-nowrap">Kelas</flux:table.column>
                        <flux:table.column class="w-36 whitespace-nowrap">Tanggal Pengajuan</flux:table.column>
                        <flux:table.column class="w-36 whitespace-nowrap">Update Terakhir</flux:table.column>
                        <flux:table.column class="w-24 text-center whitespace-nowrap">Status</flux:table.column>
                        <flux:table.column class="min-w-44">Aksi</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse ($this->ajuans as $ajuan)
                            <flux:table.row :key="$ajuan->id" class="align-middle">
                                {{-- no --}}
                                <flux:table.cell class="text-center whitespace-nowrap text-zinc-500 text-xs md:text-sm">
                                    {{ ($this->ajuans->currentPage() - 1) * $this->ajuans->perPage() + $loop->iteration }}
                                </flux:table.cell>
                                {{-- Ruangan --}}
                                <flux:table.cell class="whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <flux:icon name="home" variant="micro" class="text-zinc-400" />
                                        <span class="font-medium text-zinc-800 dark:text-zinc-200 text-xs md:text-sm">
                                            {{ $ajuan->ruangan?->nama_ruangan ?? 'Belum Diplot' }}
                                        </span>
                                    </div>
                                </flux:table.cell>
                                {{-- Pekan --}}
                                <flux:table.cell class="whitespace-nowrap">
                                    <flux:badge size="sm" variant="outline" inset="top bottom">
                                        Pekan {{ $ajuan->pekan }}
                                    </flux:badge>
                                </flux:table.cell>
                                {{-- Mata Kuliah --}}
                                <flux:table.cell class="text-xs md:text-sm text-zinc-900 dark:text-white font-medium">
                                    {{ $ajuan->mataKuliah?->nama_mk }}
                                </flux:table.cell>
                                {{-- Dosen --}}
                                <flux:table.cell class="text-xs md:text-sm text-zinc-600 dark:text-zinc-400">
                                    @if ($ajuan->dosen?->name)
                                        {{ $ajuan->dosen?->name }}
                                    @else
                                        <flux:button size="xs" variant="primary" color="green" icon="user-plus"
                                            wire:click="addPenugasanDosen({{ $ajuan->id }})">
                                            Tambah Penugasan Dosen
                                        </flux:button>
                                    @endif
                                </flux:table.cell>
                                {{-- Kelas --}}
                                <flux:table.cell class="text-center whitespace-nowrap">
                                    {{ $ajuan->kelas?->kode_kelas }}
                                </flux:table.cell>
                                {{-- Tanggal Pengajuan --}}
                                <flux:table.cell
                                    class="text-xs whitespace-nowrap text-center md:text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $ajuan->created_at->format('d M Y') }}
                                </flux:table.cell>
                                {{-- Update Terakhir --}}
                                <flux:table.cell
                                    class="text-xs whitespace-nowrap text-center md:text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $ajuan->updated_at->format('d M Y') }}
                                </flux:table.cell>
                                {{-- Status --}}
                                <flux:table.cell class="text-center whitespace-nowrap">
                                    @if ($ajuan->status == 'menunggu')
                                        <flux:badge size="sm" color="cyan" inset="top bottom">
                                            {{ ucfirst($ajuan->status) }}
                                        </flux:badge>
                                    @elseif ($ajuan->status == 'ditolak')
                                        <flux:badge size="sm" variant="solid" color="red" inset="top bottom">
                                            {{ ucfirst($ajuan->status) }}
                                        </flux:badge>
                                    @endif
                                </flux:table.cell>
                                {{-- Aksi --}}
                                <flux:table.cell class="text-center whitespace-nowrap">
                                    <div class="flex flex-row gap-2 justify-center">
                                        <flux:button wire:click="editAjuan({{ $ajuan->id }})" size="sm" variant="primary"
                                            icon="pencil-square" color="blue">
                                            Edit
                                        </flux:button>
                                        <flux:button wire:click="deleteAjuan({{ $ajuan->id }})" size="sm" variant="danger"
                                            icon="trash">
                                            Hapus
                                        </flux:button>
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="10" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center space-y-2 text-zinc-400">
                                        <flux:icon name="calendar" class="h-8 w-8 stroke-1" />
                                        <flux:text size="lg" class="font-medium">Tidak ada Ajuan yang ditemukan.
                                        </flux:text>
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </div>
        </div>
        <div class="mt-6 px-4 md:px-0">
            {{ $this->ajuans->links() }}
        </div>
    </div>

    {{-- Modal --}}
    <livewire:prodi.ajuan.modal.modal-ajuan-prodi />
    {{-- Modal konfirmasi --}}
    <livewire:prodi.ajuan.modal.modal-ajuan-konfirmasi />
</div>