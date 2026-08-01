<div>
    {{-- Modal ajuan --}}
    <flux:modal name="add-ajuan-modal" class="max-w-3xl">
        <div class="p-2">
            {{-- Judul Modal --}}
            <flux:heading size="lg" class="text-center mb-6">Pilih jenis ajuan</flux:heading>
            {{-- Grid 2 Kolom untuk Kartu --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kartu Kiri --}}
                <div
                    class="flex flex-col items-center text-center p-6 border border-zinc-200 dark:border-zinc-700 rounded-2xl bg-zinc-50/50 dark:bg-zinc-800/50 hover:border-indigo-500 hover:bg-cyan-50/50 transition-all">
                    {{-- Button di Atas --}}
                    <div class="mb-4">
                        <flux:button icon="user-plus" variant="primary" size="xs" color="cyan"
                            wire:click="addAjuanByDosen">
                            Add Ajuan by Penugasan Dosen
                        </flux:button>
                    </div>
                    {{-- Teks Deskripsi di Bawah --}}
                    <p class="text-xs md:text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        Buat ajuan menggunakan data matakuliah dan dosen yang sudah terdaftar pada tabel penugasan
                        dosen.
                    </p>
                </div>
                {{-- Kartu Kanan --}}
                <div
                    class="flex flex-col items-center text-center p-6 border border-zinc-200 dark:border-zinc-700 rounded-2xl bg-zinc-50/50 dark:bg-zinc-800/50 hover:border-indigo-500 hover:bg-cyan-50/50 transition-all">
                    {{-- Button di Atas --}}
                    <div class="mb-4">
                        <flux:button variant="primary" color="cyan" icon="document-plus" size="xs"
                            wire:click="bulkAjuan">
                            Bulk Ajuan
                        </flux:button>
                    </div>
                    {{-- Teks Deskripsi di Bawah --}}
                    <p class="text-xs md:text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        Buat ajuan untuk matakuliah yang belum memiliki penugasan. Alokasi dosen bersifat opsional dan
                        dapat dikosongkan
                    </p>
                </div>
            </div>
        </div>
    </flux:modal>
    {{-- modal add ajuan --}}
    <flux:modal name="bulk-ajuan-modal" class="max-w-2xl" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add Ajuan</flux:heading>
                <flux:text class="mt-2">Fill in the details for the new ajuan.</flux:text>
            </div>
            {{-- field Dosen --}}
            <livewire:prodi.partials.dosen-field-searchable wire:model.live="form.kode_dosen" />
            <flux:error name="form.kode_dosen" />
            {{-- field Mata Kuliah --}}
            <livewire:prodi.partials.matakuliah-field-searchable wire:model.live="form.kode_mk" />
            <flux:error name="form.kode_mk" />
            {{-- field jumlah kelas, prefix kelas, dan reguler --}}
            <div class=" grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
                {{-- field jumlah kelas --}}
                <div>
                    <flux:input label="Jumlah Kelas" type="number" min="1" wire:model.live="form.jumlah_kelas"
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
                        <flux:input name="suffix_kelas" wire:model.live='form.suffix_kelas' type="number" min="1"
                            placeholder="Contoh: 001" clearable />
                        <flux:error name="form.suffix_kelas" />
                    </flux:field>
                </div>
                {{-- field reguler --}}
                <div>
                    <flux:select label="Reguler" wire:model.live="form.reguler" placeholder="Silahkan pilih Reguler"
                        class="w-full sm:w-auto">
                        @foreach ($this->kodeReg as $key => $label)
                            <flux:select.option value="{{ $key }}">{{ $label }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>
            {{-- Pekan --}}
            <flux:legend>Pekan</flux:legend>
            <flux:error name="form.pekan" />
            @if ($this->showPekan)
                {{-- field pekan --}}
                <flux:fieldset>
                    <flux:description>Choose the weeks you want to include.</flux:description>
                    <div
                        class="grid grid-cols-2 sm:grid-cols-5 gap-4 p-3 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800">
                        @for ($i = 1; $i <= 14; $i++)
                            <div class="flex items-center">
                                <flux:checkbox wire:model.live="form.pekan" value="{{ $i }}" label="Pekan {{ $i }}" />
                            </div>
                        @endfor
                        {{-- button select all and unselect all --}}
                        <div
                            class="col-span-2 sm:col-span-5 flex items-center gap-2 pt-2 border-t border-zinc-200 dark:border-zinc-700 mt-1">
                            <flux:button type="button" size="sm" variant="ghost" icon="check" wire:click="selectAllPekan()">
                                Pilih Semua
                            </flux:button>
                            <flux:button type="button" size="sm" variant="ghost" icon="x-mark"
                                class="text-red-600 hover:text-red-700" wire:click="unselectAllPekan">
                                Batal Semua
                            </flux:button>

                            <span class="text-xs text-zinc-400 ml-auto font-medium">
                                {{ count($this->form->pekan) }} dari 14 Terpilih
                            </span>
                        </div>
                    </div>
                </flux:fieldset>
            @else
                {{ $this->unselectAllPekan() }}
                <flux:separator />
                <flux:text class="mt-2 text-center text-red-500">Silahkan masukan Mata Kuliah sampai Reguler dengan benar
                    <br>
                    jika Dosen belum ditentukan boleh kosong
                </flux:text>
                <div class="flex justify-center items-center w-full">
                    <flux:icon.loading />
                </div>
                <flux:separator />
            @endif
            {{-- field ruangan --}}
            <div class="relative">
                <flux:select label="Ruangan Praktikum" wire:model="form.ruangan_praktikum"
                    placeholder="Silahkan pilih Ruangan Praktikum" class="w-full ">
                    <flux:select.option value="lab-komputer">Lab Komputer</flux:select.option>
                    <flux:select.option disabled class="text-red-400">Lab. lain nya sedang dalam pengembangan
                    </flux:select.option>
                </flux:select>
            </div>
            {{-- Footer --}}
            <flux:separator />
            <div class="flex items-center justify-between pt-2">
                <flux:button type="button" variant="ghost" wire:click="backBulk">
                    &larr; Kembali
                </flux:button>
                <div class="flex items-center gap-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>
                    <flux:button type="button" variant="primary" wire:click="addBulk">
                        Simpan Ajuan
                    </flux:button>
                </div>
            </div>
        </div>
    </flux:modal>
    {{-- Select Penugasan --}}
    <flux:modal name="ajuan-by-penugasan" class="max-w-3xl" :dismissible="false">
        <div class="p-2">
            <flux:heading size="lg" class="text-center mb-6">Silahkan pilih penugasan dosen yg telah ada</flux:heading>

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                {{-- field Dosen --}}
                <livewire:prodi.partials.dosen-field-searchable wire:model.live="form.kode_dosen"
                    context="filter-penugasan" />
                {{-- Field MK --}}
                <livewire:prodi.partials.matakuliah-field-searchable wire:model.live="form.kode_mk"
                    context="filter-penugasan" />
                {{-- Field Kelas --}}
                <livewire:prodi.partials.kelas-field-searchable wire:model.live="form.idKelas"
                    context="filter-penugasan" />

            </div>
            <div
                class="max-h-80 overflow-y-auto border border-zinc-200 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900 mt-3">
                <flux:table class="w-full text-sm">
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
                                    <flux:button wire:click="addAjuanPenugasan({{ $item->id }})" size="xs" variant="primary"
                                        icon="document-plus" color="blue">
                                        Buat Ajuan Praktikum
                                    </flux:button>
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
                {{-- Pagination --}}
                <div class="border-t border-zinc-200 px-4 py-4 dark:border-zinc-800 mb-3">
                    {{ $this->penugasanDosens->links() }}
                </div>
            </div>
            <flux:button type="button" variant="ghost" wire:click="backModal" class="mt-2">
                &larr; Kembali
            </flux:button>
        </div>
    </flux:modal>
    {{-- modal add ajuan by penugasan table --}}
    <flux:modal name="add-ajuan-by-penugasan" class="max-w-3xl" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add Ajuan</flux:heading>
                <flux:text class="mt-2">Fill in the details for the new ajuan.</flux:text>
            </div>
            {{-- Field Semester --}}
            <flux:input label="Dosen" readonly variant="filled" value="{{ $this->data['nama_dosen'] ?? '-' }}" />
            {{-- Field Mata Kuliah --}}
            <flux:input label="Mata Kuliah" readonly variant="filled" value="{{ $this->data['nama_mk'] ?? '-' }}" />
            {{-- Field Semester --}}
            <flux:input label="Kelas" readonly variant="filled" value="{{ $this->data['kode_kelas'] ?? '-' }}" />
            {{-- field pekan --}}
            <flux:fieldset>
                <flux:legend>Pekan</flux:legend>
                <flux:description>Choose the weeks you want to include.</flux:description>
                <flux:error name="form.pekan" />
                <div
                    class="grid grid-cols-2 sm:grid-cols-5 gap-4 p-3 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800">
                    @for ($i = 1; $i <= 14; $i++)
                        <div class="flex items-center">
                            <flux:checkbox wire:model.live="pekan" value="{{ $i }}" label="Pekan {{ $i }}" />
                        </div>
                    @endfor
                    {{-- button select all and unselect all --}}
                    <div
                        class="col-span-2 sm:col-span-5 flex items-center gap-2 pt-2 border-t border-zinc-200 dark:border-zinc-700 mt-1">
                        <flux:button type="button" size="sm" variant="ghost" icon="check"
                            wire:click="selectAllPekan({{ $data['id'] ?? null}})">
                            Pilih Semua
                        </flux:button>
                        <flux:button type="button" size="sm" variant="ghost" icon="x-mark"
                            class="text-red-600 hover:text-red-700"
                            wire:click="unselectAllPekan({{ $data['id'] ?? null }})">
                            Batal Semua
                        </flux:button>

                        <span class="text-xs text-zinc-400 ml-auto font-medium">
                            {{ count($this->pekan) }} dari 14 Terpilih
                        </span>
                    </div>
                </div>
            </flux:fieldset>
            {{-- field ruangan --}}
            <div class="relative">
                <flux:select label="Ruangan Praktikum" wire:model="form.ruangan_praktikum"
                    placeholder="Silahkan pilih Ruangan Praktikum" class="w-full ">
                    <flux:select.option value="lab-komputer">Lab Komputer</flux:select.option>
                    <flux:select.option disabled class="text-red-400">Lab. lain nya sedang dalam pengembangan
                    </flux:select.option>
                </flux:select>

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
                    <flux:button type="button" variant="primary" wire:click="storeAjuanbyPenugasan">
                        Simpan Ajuan
                    </flux:button>
                </div>
            </div>
        </div>
    </flux:modal>
    {{-- modal edit ajuan --}}
    <flux:modal name="edit-ajuan-modal" class="max-w-md" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Ajuan</flux:heading>
                <flux:text class="mt-2">Perbarui informasi dosen pengampu, mata kuliah, kelas, atau pekan ajuan
                    praktikum di bawah
                    ini.</flux:text>
            </div>
            {{-- Field Dosen --}}
            <livewire:prodi.partials.dosen-field-searchable wire:model.live="form.kode_dosen" context="modal-edit-ajuan"
                :key="'dosen-modal-edit-ajuan'" />
            <flux:error name="form.kode_dosen" />
            {{-- Field Matakuliah --}}
            <livewire:prodi.partials.matakuliah-field-searchable wire:model.live="form.kode_mk"
                context="modal-edit-ajuan" :key="'matakuliah-modal-edit-ajuan'" />
            <flux:error name="form.kode_mk" />
            {{-- Field Kelas --}}
            <livewire:prodi.partials.kelas-field-searchable wire:model.live="form.idKelas" context="modal-edit-ajuan"
                :key="'kelas-modal-edit-ajuan'" />
            <flux:error name="form.idKelas" />
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Field Pekan --}}
                <livewire:prodi.partials.filter-pekan wire:model.live="form.idPekan" context="modal-edit-ajuan"
                    :key="'pekan-modal-edit-ajuan'" />
                <flux:error name="form.idPekan" />
                {{-- Field Ruangan --}}
                <flux:select label="Ruangan Praktikum" wire:model="form.ruangan_praktikum"
                    placeholder="Silahkan pilih Ruangan Praktikum" class="w-full ">
                    <flux:select.option value="lab-komputer">Lab Komputer</flux:select.option>
                    <flux:select.option disabled class="text-red-400">Lab. lain nya sedang dalam pengembangan
                    </flux:select.option>
                </flux:select>
            </div>
            <flux:separator />
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary" wire:click="updateAjuan({{ $data['id'] ?? null }})">Update
                    Ajuan
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>