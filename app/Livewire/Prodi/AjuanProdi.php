<?php

namespace App\Livewire\Prodi;

use App\Models\Ajuan;
use App\Models\Ruangan;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class AjuanProdi extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $pekan = '';
    public $ruangan = '';
    public $status = '';
    public $dosen = '';

    public function render()
    {
        return view('livewire.prodi.ajuan-prodi');
    }

    public function addAjuan()
    {
        $this->dispatch('ajuan-modal-prodi');
    }

    #[Computed]
    public function ruangans(){
        return Ruangan::query()
            ->orderBy('nama_ruangan', 'asc')
            ->get();
    }

    #[Computed]
    public function dosens(){
        return User::query()
            ->where('role', 'dosen')
            ->where('prodi_id', auth()->user()->prodi_id)
            ->orderBy('name', 'asc')
            ->get();
    }

    #[Computed]
    public function ajuans(){
        return Ajuan::query()
            ->with(['mataKuliah', 'kelas', 'dosen', 'ruangan'])
            ->whereNot('status', 'disetujui')
            ->whereHas('mataKuliah', function ($query) {
                $query->where('prodi_id', auth()->user()->prodi_id);
            })
            ->when($this->pekan, function($query) {
                $query->where('pekan', $this->pekan);
            })
            ->when($this->ruangan, function($query) {
                $query->where('ruangan_id', $this->ruangan);
            })
            ->when($this->status, function($query) {
                $query->where('status', $this->status);
            })
            ->when($this->dosen, function($query) {
                $query->where('user_username', $this->dosen);
            })
            ->orderBy('pekan')
            ->orderBy('ruangan_id')
            ->paginate(10);
    }

    public function updatedPekan() { $this->resetPage(); }
    public function updatedDosen() { $this->resetPage(); }
    public function updatedRuangan() { $this->resetPage(); }
    public function updatedStatus() { $this->resetPage(); }
}
