<div>
    {{-- modal add ajuan --}}
    <flux:modal name="add-ajuan-prodi" class="max-w-2xl" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add Ajuan</flux:heading>
                <flux:text class="mt-2">Fill in the details for the new ajuan.</flux:text>
            </div>

            {{-- field Mata Kuliah --}}
            <div class="relative" x-data x-on:click.outside="$wire.showMkDropdown = false">
                <flux:field>
                    <flux:label>Mata Kuliah</flux:label>
                    <flux:input wire:model.live.debounce.300ms="ajuanProdiForm.mkSearch"
                        wire:focus="showMkDropdown = true" placeholder="Cari Mata Kuliah..." autocomplete="off"
                        clearable wire:clear="$set('ajuanProdiForm.kode_mk', null); showMkDropdown = false" />
                    <flux:error name="ajuanProdiForm.kode_mk" />
                </flux:field>

                @if ($showMkDropdown && $this->matakuliahs->isNotEmpty())
                    <div
                        class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800 max-h-56 overflow-y-auto">
                        @foreach ($this->matakuliahs as $mk)
                            <button type="button" wire:click="selectMk({{ $mk->id }}, '{{ addslashes($mk->nama_mk) }}')"
                                class="block w-full px-3 py-2 text-left text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                {{ $mk->nama_mk }}
                            </button>
                        @endforeach
                    </div>
                @elseif ($showMkDropdown && filled($this->ajuanProdiForm->mkSearch))
                    <div
                        class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-500 shadow-lg dark:border-zinc-700 dark:bg-zinc-800">
                        Tidak ditemukan.
                    </div>
                @endif
            </div>

            {{-- field Dosen --}}
            <div class="relative" x-data x-on:click.outside="$wire.showDosenDropdown = false">
                <flux:field>
                    <flux:label>Nama Dosen</flux:label>
                    <flux:input wire:model.live.debounce.300ms="ajuanProdiForm.dosenSearch"
                        wire:focus="showDosenDropdown = true" placeholder="Cari Nama Dosen..." autocomplete="off"
                        clearable />
                    <flux:error name="ajuanProdiForm.kode_dosen" />
                </flux:field>
                @if ($showDosenDropdown && $this->dosens->isNotEmpty())
                    <div
                        class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800 max-h-56 overflow-y-auto">
                        @foreach ($this->dosens as $dosen)
                            <button type="button" wire:click="selectDosen({{ $dosen->id }}, '{{ addslashes($dosen->name) }}')"
                                class="block w-full px-3 py-2 text-left text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                {{ $dosen->name }}
                                <span class="text-zinc-400 text-xs">({{ $dosen->username }})</span>
                            </button>
                        @endforeach
                    </div>

                @elseif ($showDosenDropdown && filled($this->ajuanProdiForm->dosenSearch))
                    <div
                        class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-500 shadow-lg dark:border-zinc-700 dark:bg-zinc-800">
                        Tidak ditemukan.
                    </div>
                @endif
            </div>

            {{-- field jumlah kelas, prefix kelas, dan reguler --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
                {{-- field jumlah kelas --}}
                <div>
                    <flux:input label="Jumlah Kelas" type="number" min="1" wire:model="ajuanProdiForm.jumlah_kelas"
                        placeholder="Masukkan Jumlah Kelas" class="w-full sm:w-auto" clearable />
                </div>
                {{-- field suffix kelas --}}
                <div>
                    <flux:field>
                        <flux:heading class="flex items-center gap-2">
                            Suffix Kelas
                            <flux:tooltip toggleable>
                                <flux:button icon="information-circle" size="sm" variant="ghost"
                                    class="text-zinc-400 hover:text-zinc-500 cursor-help" />

                                <flux:tooltip.content class="max-w-[20rem] space-y-2">
                                    <p>Sufix kelas digunakan untuk membedakan kelas yang berbeda</p>
                                    <p>misalnya 01SISP001, 01SISP002, 01SISP003, dst.</p>
                                    <p>maka tulis kan angka terakhirnya saja</p>
                                </flux:tooltip.content>
                            </flux:tooltip>
                        </flux:heading>
                        <flux:input name="suffix_kelas" wire:model='ajuanProdiForm.suffix_kelas' type="number" min="1"
                            placeholder="Contoh: 001" clearable />
                        <flux:error name="ajuanProdiForm.suffix_kelas" />
                    </flux:field>
                </div>
                {{-- field reguler --}}
                <div>
                    <flux:select label="Reguler" wire:model="ajuanProdiForm.reguler"
                        placeholder="Silahkan pilih Reguler" class="w-full sm:w-auto">
                        <flux:select.option value="A">Reguler A</flux:select.option>
                        <flux:select.option value="B">Reguler B</flux:select.option>
                        <flux:select.option value="C">Reguler C</flux:select.option>
                    </flux:select>
                </div>
            </div>

            @if ($this->ajuanProdiForm->mkSearch && $this->ajuanProdiForm->kode_mk)
                {{-- field pekan --}}
                <flux:fieldset>
                    <flux:legend>Pekan</flux:legend>
                    <flux:description>Choose the weeks you want to include.</flux:description>
                    <flux:error name="ajuanProdiForm.pekan" />
                    <div
                        class="grid grid-cols-2 sm:grid-cols-5 gap-4 p-3 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800">
                        @for ($i = 1; $i <= 14; $i++)
                            <div class="flex items-center">
                                <flux:checkbox wire:model.live="ajuanProdiForm.pekan" value="{{ $i }}" label="Pekan {{ $i }}" />
                            </div>
                        @endfor
                        {{-- button select all and unselect all --}}
                        <div
                            class="col-span-2 sm:col-span-5 flex items-center gap-2 pt-2 border-t border-zinc-200 dark:border-zinc-700 mt-1">
                            <flux:button type="button" size="sm" variant="ghost" icon="check" wire:click="selectAllPekan">
                                Pilih Semua
                            </flux:button>
                            <flux:button type="button" size="sm" variant="ghost" icon="x-mark"
                                class="text-red-600 hover:text-red-700" wire:click="unselectAllPekan">
                                Batal Semua
                            </flux:button>

                            <span class="text-xs text-zinc-400 ml-auto font-medium">
                                {{ count($this->ajuanProdiForm->pekan) }} dari 14 Terpilih
                            </span>
                        </div>
                    </div>
                </flux:fieldset>
            @else
                {{ $this->unselectAllPekan() }}
                <flux:legend>Pekan</flux:legend>
                <flux:separator />
                <flux:text class="mt-2 text-center text-red-500">Silahkan masukan Mata Kuliah dengan benar</flux:text>
                <flux:separator />
            @endif

            {{-- field ruangan --}}
            <div class="relative">
                <flux:select label="Ruangan Praktikum" wire:model="ajuanProdiForm.ruangan_praktikum"
                    placeholder="Silahkan pilih Ruangan Praktikum" class="w-full ">
                    <flux:select.option value="lab-komputer">Lab Komputer</flux:select.option>
                    <flux:select.option disabled class="text-red-400">Lab. lain nya sedang dalam pengembangan
                    </flux:select.option>
                </flux:select>
            </div>

            <flux:separator />
            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>
                <flux:button type="submit" icon="plus" color="blue" variant="primary" wire:click='save'>Save changes
                </flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- modal konfirmasi ajuan --}}
    <flux:modal name="konfirm-add-ajuan-prodi" class="max-w-4xl" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg" class="flex items-center gap-2">
                    <flux:icon name="exclamation-triangle" class="text-amber-500" variant="mini" />
                    Konfirmasi {{ count($this->generateData()) }} Ajuan Jadwal
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
                        @forelse ($this->ajuanProdiForm->data as $index => $item)
                            @php
                                $kelasId = $this->ajuanProdiForm->getIdKelas($item['kelas']);
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
                                    {{ $item['mata_kuliah'] }}
                                </flux:table.cell>

                                <flux:table.cell class="{{ !$isInvalid ? 'text-zinc-600 dark:text-zinc-400' : '' }}">
                                    {{ $item['dosen'] }}
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
            <div class="flex justify-end gap-2 pt-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary" color="green" icon="check" wire:click="storeAjuan">
                    Simpan Semua Ajuan
                </flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- modal edit ajuan --}}
    <flux:modal name="edit-ajuan-prodi" class="max-w-2xl" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Ajuan Jadwal</flux:heading>
                <flux:text class="mt-2">Ubah rincian data ajuan kelompok praktikum.</flux:text>
            </div>

            {{-- field Mata Kuliah (Sama seperti ADD) --}}
            <div class="relative" x-data x-on:click.outside="$wire.showMkDropdown = false">
                <flux:field>
                    <flux:label>Mata Kuliah</flux:label>
                    <flux:input wire:model.live.debounce.300ms="ajuanProdiForm.mkSearch"
                        wire:focus="showMkDropdown = true" placeholder="Cari Mata Kuliah..." autocomplete="off"
                        clearable />
                    <flux:error name="ajuanProdiForm.kode_mk" />
                </flux:field>

                @if ($showMkDropdown && $this->matakuliahs->isNotEmpty())
                    <div
                        class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800 max-h-56 overflow-y-auto">
                        @foreach ($this->matakuliahs as $mk)
                            <button type="button" wire:click="selectMk({{ $mk->id }}, '{{ addslashes($mk->nama_mk) }}')"
                                class="block w-full px-3 py-2 text-left text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                {{ $mk->nama_mk }}
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- field Dosen (Sama seperti ADD) --}}
            <div class="relative" x-data x-on:click.outside="$wire.showDosenDropdown = false">
                <flux:field>
                    <flux:label>Nama Dosen</flux:label>
                    <flux:input wire:model.live.debounce.300ms="ajuanProdiForm.dosenSearch"
                        wire:focus="showDosenDropdown = true" placeholder="Cari Nama Dosen..." autocomplete="off"
                        clearable />
                    <flux:error name="ajuanProdiForm.kode_dosen" />
                </flux:field>
                @if ($showDosenDropdown && $this->dosens->isNotEmpty())
                    <div
                        class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800 max-h-56 overflow-y-auto">
                        @foreach ($this->dosens as $dosen)
                            <button type="button" wire:click="selectDosen({{ $dosen->id }}, '{{ addslashes($dosen->name) }}')"
                                class="block w-full px-3 py-2 text-left text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                {{ $dosen->name }} <span class="text-zinc-400 text-xs">({{ $dosen->username }})</span>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Row untuk Kelas & Reguler --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
                {{-- field Nama/Kode Kelas --}}
                <div x-data x-on:click.outside="$wire.showKelasDropdown = false">
                    <flux:field>
                        <flux:label>Kode Kelas</flux:label>
                        <flux:input wire:model.live.debounce.300ms="ajuanProdiForm.kelas"
                            wire:focus="showKelasDropdown = true" placeholder="Contoh: 03SISM002" autocomplete="off"
                            clearable />
                        <flux:error name="ajuanProdiForm.kelas" />
                    </flux:field>
                    @if ($showKelasDropdown && $this->kelas->isNotEmpty())
                        <div
                            class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800 max-h-56 overflow-y-auto">
                            @foreach ($this->kelas as $kelas)
                                <button type="button"
                                    wire:click="selectKelas({{ $kelas->id }}, '{{ addslashes($kelas->kode_kelas) }}', '{{ $kelas->reguler }}')"
                                    class="block w-full px-3 py-2 text-left text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                    {{ $kelas->kode_kelas }} <span class="text-zinc-400 text-xs">({{ $kelas->reguler }})</span>
                                    -
                                    <span class="text-zinc-400 text-xs">(Semester {{ substr($kelas->kode_kelas, 1, 1) }})</span>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
                {{-- field reguler --}}
                <div>
                    <flux:input disabled label="Reguler" wire:model.live="reg" />
                </div>
            </div>

            {{-- field pekan (Select dropdown tunggal) --}}
            <div>
                <flux:select label="Pekan" wire:model="ajuanProdiForm.pekan.0" placeholder="Silahkan pilih Pekan">
                    @for ($i = 1; $i <= 14; $i++)
                        <flux:select.option value="{{ $i }}">Pekan {{ $i }}</flux:select.option>
                    @endfor
                </flux:select>
                <flux:error name="ajuanProdiForm.pekan" />
            </div>

            {{-- field Ruangan (Bisa diedit secara bebas lewat select option master ID Ruangan) --}}
            <div>
                <flux:select label="Ruangan Praktikum" wire:model="ajuanProdiForm.ruangan_praktikum"
                    placeholder="Pilih Ruangan">
                    @if ($spesifikasiMK == 'standar')
                        <flux:select.option value="1">Lab Komputer 01 (Standar)</flux:select.option>
                        <flux:select.option value="2">Lab Komputer 02 (Standar)</flux:select.option>
                    @else
                        <flux:select.option value="3">Lab Komputer 03 (Spesifikasi Tinggi)</flux:select.option>
                    @endif
                </flux:select>
                <flux:error name="ajuanProdiForm.ruangan_praktikum" />
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost" class="mr-2">Batal</flux:button>
                </flux:modal.close>
                <flux:button type="submit" icon="check" color="green" variant="primary" wire:click='updateAjuan'>Simpan
                    Perubahan</flux:button>
            </div>
        </div>
    </flux:modal>
</div>