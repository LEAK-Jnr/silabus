<div>
    <flux:modal name="add-ajuan-prodi" class="max-w-2xl">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add Ajuan</flux:heading>
                <flux:text class="mt-2">Fill in the details for the new ajuan.</flux:text>
            </div>

            {{-- field Mata Kuliah --}}
            <div class="relative" x-data x-on:click.outside="$wire.showMkDropdown = false">
                <flux:field>
                    <flux:label>Mata Kuliah</flux:label>
                    <flux:input
                        wire:model.live.debounce.300ms="mkSearch"
                        wire:focus="showMkDropdown = true"
                        placeholder="Cari Mata Kuliah..."
                        autocomplete="off"
                    />
                    <flux:error name="kode_mk" />
                </flux:field>

                @if ($showMkDropdown && $this->matakuliahs->isNotEmpty())
                    <div class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800 max-h-56 overflow-y-auto">
                        @foreach ($this->matakuliahs as $mk)
                            <button
                                type="button"
                                wire:click="selectMk({{ $mk->id }}, '{{ addslashes($mk->nama_mk) }}')"
                                class="block w-full px-3 py-2 text-left text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700"
                            >
                                {{ $mk->nama_mk }}
                            </button>
                        @endforeach
                    </div>
                @elseif ($showMkDropdown && filled($mkSearch))
                    <div class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-500 shadow-lg dark:border-zinc-700 dark:bg-zinc-800">
                        Tidak ditemukan.
                    </div>
                @endif
            </div>

            {{-- field Dosen --}}
            <div class="relative" x-data x-on:click.outside="$wire.showDosenDropdown = false">
                <flux:field>
                    <flux:label>Nama Dosen</flux:label>
                    <flux:input
                        wire:model.live.debounce.300ms="dosenSearch"
                        wire:focus="showDosenDropdown = true"
                        placeholder="Cari Nama Dosen..."
                        autocomplete="off"
                    />
                    <flux:error name="kode_dosen" />
                </flux:field>
                @if ($showDosenDropdown && $this->dosens->isNotEmpty())
                    <div class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800 max-h-56 overflow-y-auto">
                        @foreach ($this->dosens as $dosen)
                            <button
                                type="button"
                                wire:click="selectDosen({{ $dosen->id }}, '{{ addslashes($dosen->name) }}')"
                                class="block w-full px-3 py-2 text-left text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700"
                            >
                                {{ $dosen->name }} 
                                <span class="text-zinc-400 text-xs">({{ $dosen->username }})</span>
                            </button>
                        @endforeach
                    </div>
                    
                @elseif ($showDosenDropdown && filled($dosenSearch))
                    <div class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-500 shadow-lg dark:border-zinc-700 dark:bg-zinc-800">
                        Tidak ditemukan.
                    </div>
                @endif
            </div>

            {{-- field jumlah kelas, prefix kelas, dan reguler --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
                {{-- field jumlah kelas --}}
                <div>
                    <flux:input
                        label="Jumlah Kelas"
                        type="number"
                        min="1"
                        wire:model="jumlah_kelas"
                        placeholder="Masukkan Jumlah Kelas"
                        class="w-full sm:w-auto"
                    />
                </div>
                {{-- field suffix kelas --}}
                <div>
                    <flux:field>
                        <flux:heading class="flex items-center gap-2">
                            Suffix Kelas
                            <flux:tooltip toggleable>
                                <flux:button icon="information-circle" size="sm" variant="ghost" class="text-zinc-400 hover:text-zinc-500 cursor-help" />

                                <flux:tooltip.content class="max-w-[20rem] space-y-2">
                                    <p>Sufix kelas digunakan untuk membedakan kelas yang berbeda</p>
                                    <p>misalnya 01SISP001, 01SISP002, 01SISP003, dst.</p>
                                    <p>maka tulis kan angka terakhirnya saja</p>
                                </flux:tooltip.content>
                            </flux:tooltip>
                        </flux:heading>
                        <flux:input name="suffix_kelas" wire:model='suffix_kelas' type="number" min="1" placeholder="Contoh: 001" />
                        <flux:error name="suffix_kelas" />
                    </flux:field>
                </div>
                {{-- field reguler --}}
                <div>
                    <flux:select
                        label="Reguler"
                        wire:model="Reguler"
                        placeholder="Silahkan pilih Reguler"
                        class="w-full sm:w-auto"
                    >
                        <flux:select.option value="A">Reguler A</flux:select.option>
                        <flux:select.option value="B">Reguler B</flux:select.option>
                        <flux:select.option value="C">Reguler C</flux:select.option>
                    </flux:select>
                </div>
            </div>

            {{-- field pekan --}}
            <flux:fieldset>
                <flux:legend>Pekan</flux:legend>
                <flux:description>Choose the weeks you want to include.</flux:description>
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 p-3 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800">
                    @for ($i=1; $i <= 14; $i++ )
                        <div class="flex items-center">
                            <flux:checkbox wire:model="pekan" value="pekan-{{ $i }}" label="Pekan {{ $i }}" />
                        </div>
                    @endfor
                </div>
            </flux:fieldset>

            {{-- field ruangan --}}
            <div class="relative">
                <flux:select
                    label="Ruangan Praktikum"
                    wire:model="ruangan_praktikum"
                    placeholder="Silahkan pilih Ruangan Praktikum"
                    class="w-full "
                >
                    <flux:select.option value="lab-komputer">Lab Komputer</flux:select.option>
                    <flux:select.option disabled class="text-red-400" >Lab. lain nya sedang dalam pengembangan</flux:select.option>
                </flux:select>
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" icon="plus" color="blue" variant="primary" wire:click='save'>Save changes</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
