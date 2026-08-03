<div>
    {{-- Modal Add Penugasan Dosen --}}
    <flux:modal name="add-penugasan-dosen" class="md:max-w-xl" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Tambah Penugasan Dosen</flux:heading>
                <flux:text class="mt-2">Lengkapi formulir di bawah ini untuk menetapkan dosen pengampu pada mata kuliah
                    dan kelas yang sesuai.</flux:text>
            </div>
            {{-- Field Dosen --}}
            <livewire:prodi.partials.dosen-field-searchable wire:model.live="form.idDosen" />
            <flux:error name="form.idDosen" />


            {{-- Field Matakuliah --}}
            <livewire:prodi.partials.matakuliah-field-searchable wire:model.live="form.idMatakuliah" />
            <flux:error name="form.idMatakuliah" />

            {{-- Field Reguler dan Semester --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Field Reguler --}}
                <flux:select wire:model.live="form.reguler" label="Reguler">
                    <option value="">Pilih Reguler</option>
                    <option value="Reguler A">Reguler A</option>
                    <option value="Reguler B">Reguler B</option>
                    <option value="Reguler C">Reguler C</option>
                </flux:select>

                {{-- Field Semester --}}
                <flux:input label="Semester" readonly variant="filled"
                    value="{{ $this->form->idMatakuliah ? $this->semester : 'Matakuliah Belum dipilih' }}" />
            </div>

            <flux:fieldset>
                <flux:legend>Kelas</flux:legend>
                <flux:description>Choose the class you want to include.</flux:description>
                <flux:error name="form.kelasId" />
                <div
                    class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-4 bg-zinc-50 dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800">
                    @forelse ($this->kelas as $kelas)
                        <div class="flex items-center" wire:key="kelas-{{ $kelas->id }}">
                            <flux:checkbox wire:model.live="form.kelasId" value="{{ $kelas->id }}"
                                label="{{ $kelas->kode_kelas }}" />
                        </div>
                    @empty
                        <div class="col-span-2 sm:col-span-4 py-2 text-center text-xs text-red-500 italic">
                            Pilih Matakuliah dan Reguler terlebih dahulu untuk menampilkan daftar kelas
                        </div>
                    @endforelse
                    @if ($this->kelas->isNotEmpty())
                        {{-- Button Select All / Unselect All & Counter Status --}}
                        <div
                            class="col-span-2 sm:col-span-4 flex items-center gap-2 pt-3 border-t border-zinc-200 dark:border-zinc-700 mt-1">
                            <flux:button type="button" size="sm" variant="ghost" icon="check" wire:click="selectAllKelas">
                                Pilih Semua
                            </flux:button>

                            <flux:button type="button" size="sm" variant="ghost" icon="x-mark"
                                class="text-red-600 hover:text-red-700 dark:text-red-400" wire:click="unselectAllKelas">
                                Batal Semua
                            </flux:button>

                            <span class="text-xs text-zinc-400 ml-auto font-medium">
                                {{ is_array($this->form->kelasId) ? count($this->form->kelasId) : 0 }} dari
                                {{ count($this->kelas) }} Terpilih
                            </span>
                        </div>
                    @endif
                </div>
            </flux:fieldset>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary" wire:click="submit">Save changes</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Modal Edit Penugasan Dosen --}}
    @persist('edit-penugasan-dosen')
    <flux:modal name="edit-penugasan-dosen" class="md:max-w-xl" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Penugasan Dosen</flux:heading>
                <flux:text class="mt-2">Perbarui informasi dosen pengampu, mata kuliah, atau kelas penugasan di bawah
                    ini.</flux:text>
            </div>
            {{-- Field Dosen --}}
            <livewire:prodi.partials.dosen-field-searchable wire:model.live="form.idDosen" context="modal-edit"
                :key="'dosen-modal-edit'" />
            <flux:error name="form.idDosen" />
            {{-- Field Matakuliah --}}
            <livewire:prodi.partials.matakuliah-field-searchable wire:model.live="form.idMatakuliah"
                context="modal-edit" :key="'matakuliah-modal-edit'" />
            <flux:error name="form.idMatakuliah" />
            {{-- Field Kelas --}}
            <livewire:prodi.partials.kelas-field-searchable wire:model.live="form.idKelas" context="modal-edit"
                :key="'kelas-modal-edit'" />
            <flux:error name="form.idKelas" />
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary" wire:click="updatePenugasan">Save changes</flux:button>
            </div>
        </div>
    </flux:modal>
    @endpersist

    {{-- Modal show-add-penugasan-from-ajuan --}}
    <flux:modal name="show-add-penugasan-from-ajuan" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Modal Penugasan Dosen</flux:heading>
                <flux:text class="mt-2">Make changes to your personal details.</flux:text>
            </div>
            {{-- Field Dosen --}}
            <livewire:prodi.partials.dosen-field-searchable wire:model.live="form.idDosen" />
            <flux:error name="form.idDosen" />
            {{-- Field Matakuliah --}}
            <flux:input readonly variant="filled" label="MataKuliah" value="{{ $data['nama_mk'] ?? '-' }}" />
            <div class=" grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
                <div>
                    <flux:input readonly variant="filled" label="Kelas" value="{{ $data['kode_kelas'] ?? '-' }}" />
                </div>
                <div>
                    <flux:input readonly variant="filled" label="Reguler" value="{{ $data['reguler'] ?? '-' }}" />
                </div>
                <div>
                    <flux:input readonly variant="filled" label="Semester" value="{{ $data['semester'] ?? '-' }}" />
                </div>
            </div>
            {{-- Footer --}}
            <flux:separator />
            <div class="flex items-center justify-between pt-2">
                <flux:tooltip content="Kembali ke Halaman Ajuan">
                    <flux:button type="button" variant="ghost" href="{{ route('prodi.ajuan') }}" wire:navigate>
                        &larr; Ajuan
                    </flux:button>
                </flux:tooltip>
                <div class="flex items-center gap-2">
                    <flux:button href="{{ route('prodi.penugasan-dosen') }}" wire:navigate variant="ghost">
                        Cancel
                    </flux:button>
                    <flux:button type="button" variant="primary" wire:click="addSinglePenugasan">
                        Simpan Ajuan
                    </flux:button>
                </div>
            </div>
        </div>
    </flux:modal>
</div>