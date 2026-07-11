<div>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-blue-900">
            {{
    __(
        "Jadwal Praktikum",
    )
            }}
        </h2>
    </x-slot>
    <flux:heading size="xl" class="text-center py-5 text-black">Jadwal Praktikum</flux:heading>

    <div
        class="flex flex-col md:flex-row md:items-end md:justify-between bg-white rounded-lg shadow-md mx-4 md:mx-10 p-4 md:p-5 mt-5 gap-3">
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <div class="w-full sm:w-56">
                <flux:select wire:model.live="ruangan" label="Ruangan / Lab">
                    <flux:select.option value="">Semua Ruangan</flux:select.option>
                    @foreach ($this->ruangans as $r)
                        <flux:select.option value="{{ $r->id }}">
                            {{ $r->nama_ruangan }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div class="w-full sm:w-40">
                <flux:select wire:model.live="pekan" label="Pekan">
                    <flux:select.option value="">Semua Pekan</flux:select.option>
                    @for($i = 1; $i <= 14; $i++)
                        <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
                    @endfor
                </flux:select>
            </div>

            <div class="w-full sm:w-56">
                <flux:select wire:model.live="prodi" label="Prodi">
                    <flux:select.option value="">Semua Prodi</flux:select.option>
                    <flux:select.option value="{{ $this->user->prodi_id }}">
                        {{ $this->user?->prodi->nama_prodi }}
                    </flux:select.option>
                </flux:select>
            </div>
        </div>

        <div class="w-full sm:w-auto">
            <flux:button icon="document-arrow-down" variant="danger" class="w-full sm:w-auto" wire:click="downloadPdf">
                Download PDF
            </flux:button>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md mx-4 md:mx-10 py-4 md:py-5 px-4 md:px-5 mt-5 mb-5">
        <div class="overflow-x-auto -mx-4 md:-mx-5">
            <div class="px-4 md:px-5">
                <flux:table class="w-full text-sm md:text-base">
                    <flux:table.columns class="bg-gray-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200">
                        <flux:table.column class="w-px whitespace-nowrap text-center">No.</flux:table.column>
                        <flux:table.column class="w-40 whitespace-nowrap">Ruangan / Lab</flux:table.column>
                        <flux:table.column class="w-44 whitespace-nowrap">Waktu Pelaksanaan</flux:table.column>
                        <flux:table.column class="min-w-56">Mata Kuliah</flux:table.column>
                        <flux:table.column class="min-w-44">Dosen Pengampu</flux:table.column>
                        <flux:table.column class="w-24 text-center whitespace-nowrap">Kelas</flux:table.column>
                        <flux:table.column class="min-w-44">Program Studi</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse ($this->jadwal as $ajuan)
                            <flux:table.row :key="$ajuan->id" class="align-middle">

                                <flux:table.cell class="text-center whitespace-nowrap text-zinc-500 text-xs md:text-sm">
                                    {{ ($this->jadwal->currentPage() - 1) * $this->jadwal->perPage() + $loop->iteration }}
                                </flux:table.cell>

                                <flux:table.cell class="whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <flux:icon name="home" variant="micro" class="text-zinc-400" />
                                        <span class="font-medium text-zinc-800 dark:text-zinc-200 text-xs md:text-sm">
                                            {{ $ajuan->ruangan?->nama_ruangan ?? 'Belum Diplot' }}
                                        </span>
                                    </div>
                                </flux:table.cell>

                                <flux:table.cell class="whitescpace-nowrap text-center">
                                    <div class="mb-1 flex items-center gap-2 justify-center">
                                        <flux:badge size="sm" variant="outline" inset="top bottom">
                                            Pekan {{ $ajuan->pekan }}
                                        </flux:badge>
                                        <span class="font-semibold text-zinc-900 dark:text-white text-xs md:text-sm">
                                            {{ $ajuan->hari }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-zinc-500">
                                        {{ $ajuan->jam_mulai?->format("H:i") }} -
                                        {{ $ajuan->jam_selesai?->format("H:i") }}
                                    </div>

                                </flux:table.cell>

                                <flux:table.cell class="text-xs md:text-sm text-zinc-900 dark:text-white font-medium">
                                    {{ $ajuan->mataKuliah?->nama_mk }}
                                </flux:table.cell>

                                <flux:table.cell class="text-xs md:text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $ajuan->dosen?->name ?? 'N/A' }}
                                </flux:table.cell>

                                <flux:table.cell class="text-center whitespace-nowrap">
                                    <span
                                        class="inline-block px-2 py-0.5 rounded text-xs font-bold bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                                        {{ $ajuan->kelas?->kode_kelas }}
                                    </span>
                                </flux:table.cell>

                                <flux:table.cell class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $ajuan->mataKuliah?->prodi?->nama_prodi }}
                                </flux:table.cell>

                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="7" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center space-y-2 text-zinc-400">
                                        <flux:icon name="calendar" class="h-8 w-8 stroke-1" />
                                        <flux:text size="lg" class="font-medium">Tidak ada jadwal yang ditemukan.
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
            {{ $this->jadwal->links() }}
        </div>
    </div>

</div>