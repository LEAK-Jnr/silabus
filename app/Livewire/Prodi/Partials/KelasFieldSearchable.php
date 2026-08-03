<?php

namespace App\Livewire\Prodi\Partials;

use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class KelasFieldSearchable extends Component
{
    #[Modelable]
    public ?int $idKelas = null;
    public bool $showKelasDropdown = false;
    public string $kelasSearch = '';
    public string $context = 'default';
    public function render()
    {
        return view('livewire.prodi.partials.kelas-field-searchable');
    }

    #[Computed]
    public function kelas() {
        return Kelas::query()
            ->where('prodi_id', Auth::user()->prodi_id)
            ->when($this->kelasSearch, fn($q) => $q->where('kode_kelas', 'like', "%{$this->kelasSearch}%"))
            ->orderBy('reguler')
            ->limit(5)
            ->get()
        ;
    }

    public function selecKelas(int $id, string $kode_kelas) : void {
        $this->idKelas = $id;
        $this->kelasSearch = $kode_kelas;
        $this->showKelasDropdown = false;
    }

     #[On('kelasField-editMode-{context}')]
    public function editMode($id) {
        $this->reset(['idKelas', 'kelasSearch', 'showKelasDropdown']);
        $this->idKelas = $id;
        $this->kelasSearch = $id ? (Kelas::find($id)?->kode_kelas ?? '') : '';
    }

    public function updateKelas() : void {
        $this->showKelasDropdown = true;
        if ($this->idKelas && $this->kelas()->firstWhere('id', $this->idKelas)?->kode_kelas !== $this->kelasSearch) {
            $this->idKelas = null;
        }
    }
}
