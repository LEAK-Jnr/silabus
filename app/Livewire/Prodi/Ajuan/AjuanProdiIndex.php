<?php

namespace App\Livewire\Prodi\Ajuan;

use App\Models\Ajuan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class AjuanProdiIndex extends Component
{
    use WithPagination, WithoutUrlPagination;
    public ?int $idRuangan = null;
    public ?int $pekan = null;
    public ?int $idDosen = null;
    public string $status = '';
    public function render()
    {
        return view('livewire.prodi.ajuan.ajuan-prodi-index');
    }

    #[Computed]
    public function ajuans() {
        return Ajuan::query()
            ->with(['mataKuliah', 'kelas', 'dosen', 'ruangan'])
            ->whereNot('status', 'disetujui')
            ->whereHas('mataKuliah', fn($q) => $q->where('prodi_id', Auth::user()->prodi_id))
            ->when($this->idRuangan, fn($q) => $q->where('ruangan_id', $this->idRuangan))
            ->when($this->pekan, fn($q) => $q->where('pekan', $this->pekan))
            ->when($this->idDosen, function ($query) {
                $query->whereHas('dosen', fn($q) => $q->where('id', $this->idDosen));
            })
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderBy('pekan')
            ->orderBy('ruangan_id')
            ->paginate(35)
        ;
    }

    public function addAjuan() {
        $this->dispatch('open-add-ajuan-modal');
    }

    public function editAjuan($id) {
        $this->dispatch('open-edit-ajuan-modal', $id);
    }

    public function deleteAjuan($id) {
        $ajuan = Ajuan::query()
            ->with(['mataKuliah', 'dosen', 'kelas', 'ruangan'])
            ->whereHas('mataKuliah', fn($q) => $q->where('prodi_id', Auth::user()->prodi_id))
            ->findOrFail($id)
        ;
        $data = [
            "id" => $id,
            "nama_mk" => $ajuan->mataKuliah?->nama_mk,
            "nama_dosen" => $ajuan->dosen?->name,
            "pekan" => $ajuan->pekan,
            "kelas" => $ajuan->kelas?->kode_kelas,
            "ruangan" => $ajuan->ruangan?->nama_ruangan
        ];
        $this->dispatch('hapus-ajuan', $data);
    }
    
    public function addPenugasanDosen($id) {
        return redirect()->route('prodi.penugasan-dosen', [
            'action' => 'addPenugasan',
            'ajuan_id' => $id
        ]);
    }

    public function updatedPekan() { $this->resetPage(); }
    public function updatedDosen() { $this->resetPage(); }
    public function updatedRuangan() { $this->resetPage(); }
    public function updatedStatus() { $this->resetPage(); }
    
    #[On('refreshAjuansTable')]
    public function refreshTable() {}
}
