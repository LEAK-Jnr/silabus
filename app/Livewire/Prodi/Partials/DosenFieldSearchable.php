<?php

namespace App\Livewire\Prodi\Partials;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class DosenFieldSearchable extends Component
{
    #[Modelable]
    public ?int $kode_dosen = null;
    
    public string $dosenSearch = '';
    public bool $showDosenDropdown = false;
    public string $context = 'default';

    public function render()
    {
        return view('livewire.prodi.partials.dosen-field-searchable');
    }

    #[Computed]
    public function dosens() {
        return User::query()
            ->where('role', 'dosen')
            ->where('prodi_id', Auth::user()->prodi_id)
            ->when($this->dosenSearch, fn($q) => $q->where('name', 'like', '%' . $this->dosenSearch . '%'))
            ->orderBy('name')
            ->limit(5)
            ->get();
        ;
    }

    public function selectDosen(int $id, string $nama): void
    {
        $this->kode_dosen = $id;
        $this->dosenSearch = $nama;
        $this->showDosenDropdown = false;
    }

    public function updatedDosenSearch(): void
    {
        $this->showDosenDropdown = true;
        if ($this->kode_dosen && $this->dosens()->firstWhere('id', $this->kode_dosen)?->name !== $this->dosenSearch) {
            $this->kode_dosen = null;
        }
    }
    
    #[On('dosenField-editMode-{context}')]
    public function editMode($id) {
        $this->reset(['kode_dosen', 'dosenSearch', 'showDosenDropdown']);
        $this->kode_dosen = $id;
        $this->dosenSearch = User::find($id)?->name ?? '';
    }

    #[On('reset-fieldSearchable')]
    public function resetField(){
        $this->reset(['kode_dosen','dosenSearch', 'showDosenDropdown']);
    }
}
