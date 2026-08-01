<?php

namespace App\Livewire\Prodi\Partials;

use App\Models\MataKuliah;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class MatakuliahFieldSearchable extends Component
{
    #[Modelable]
    public ?int $kode_mk = null;
    
    public string $mkSearch = '';
    public bool $showMkDropdown = false;
    public string $context = 'default';

    public function render()
    {
        return view('livewire.prodi.partials.matakuliah-field-searchable');
    }
    
    #[Computed]
    public function matakuliahs() {
        return MataKuliah::query()
            ->where('prodi_id', Auth::user()->prodi_id)
            ->when($this->mkSearch, fn ($q) => $q->where('nama_mk', 'like', "%{$this->mkSearch}%"))
            ->orderBy('nama_mk')
            ->limit(5)
            ->get()
        ;
    }

    public function selectMk(int $id, string $nama) : void {
        $this->kode_mk = $id;
        $this->mkSearch = $nama;
        $this->showMkDropdown = false;
    }

    public function updatedMkSearch() : void {
        $this->showMkDropdown = true;

        if ($this->kode_mk && $this->matakuliahs()->firstWhere('id', $this->kode_mk)?->nama_mk !== $this->mkSearch) {
            $this->kode_mk = null;
        }
    }

    #[On('mkField-editMode-{context}')]
    public function editMode($id) {
        $this->reset(['kode_mk', 'mkSearch', 'showMkDropdown']);
        $this->kode_mk = $id;
        $this->mkSearch = $id ? (MataKuliah::find($id)?->nama_mk ?? '') : '';
    }

    #[On('reset-fieldSearchable')]
    public function resetField() {
        $this->reset(['kode_mk', 'mkSearch', 'showMkDropdown']);
    }
}
