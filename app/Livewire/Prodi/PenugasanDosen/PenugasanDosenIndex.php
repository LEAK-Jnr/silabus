<?php

namespace App\Livewire\Prodi\PenugasanDosen;

use App\Models\kelas;
use App\Models\PenugasanDosen;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PenugasanDosenIndex extends Component
{
    public ?int $idDosen = null;
    public ?int $idMatakuliah = null;
    public ?int $idKelas = null;
    
    #[Url]
    public $action;
    #[Url]
    public $ajuan_id;
    use WithPagination, WithoutUrlPagination;

    public function render()
    {
        return view('livewire.prodi.penugasan-dosen.penugasan-dosen-index');
    }

    public function mount() {
        if ($this->action === 'addPenugasan') {
            $this->dispatch('show-add-penugasan-from-ajuan', $this->ajuan_id);
        }
    }

    #[Computed]
    public function penugasanDosens() {
        return PenugasanDosen::query()
            ->with(['dosen', 'mataKuliah', 'kelas'])
            ->where('prodi_id', Auth::user()->prodi_id)
            ->when($this->idDosen, function ($query) {
                $query->whereHas('dosen', fn($q) => $q->where('id', $this->idDosen));
            })
            ->when($this->idMatakuliah, fn($q) => $q->where('matakuliah_id', $this->idMatakuliah))
            ->when($this->idKelas, fn($q) => $q->where('kelas_id', $this->idKelas))
            ->orderBy('kd_dosen')
            ->orderBy(
                kelas::select('kode_kelas')->whereColumn('kelas.id', 'penugasan_dosens.kelas_id')
            )
            ->paginate(12)
        ;
    }

    public function addPenugasan() {
        $this->dispatch('open-modal-addPenugasan');
    }

    public function editPenugasan($id) {
        $this->dispatch('show-edit-penugasan', $id);
    }

    public function deletePenugasan($id) {
        $this->dispatch('hapus-penugasan', $id);
    }

    #[On('close-modal-sukses')]
    public function closeModalPenugasan($message) {
        $this->dispatch('toast', message:$message, type:'success');
        $this->dispatch('refreshPenugasanDosensTable');
    }

     #[On('refreshPenugasanDosensTable')]
    public function refreshTable() {}
}
