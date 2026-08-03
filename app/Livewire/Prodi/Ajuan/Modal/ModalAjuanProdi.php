<?php

namespace App\Livewire\Prodi\Ajuan\Modal;

use App\Livewire\Forms\Prodi\AjuanProdiForm;
use App\Models\Ajuan;
use App\Models\kelas;
use App\Models\MataKuliah;
use App\Models\PenugasanDosen;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ModalAjuanProdi extends Component
{
    use WithPagination, WithoutUrlPagination;
    public array $data = [];
    public array $pekan = [];
    public AjuanProdiForm $form;
    
    public function render()
    {
        return view('livewire.prodi.ajuan.modal.modal-ajuan-prodi');
    }

    #[Computed]
    public function kodeReg() 
    {
        return [
            'A' => 'Reguler A',
            'B' => 'Reguler B',
            'C' => 'Reguler C'
        ];
    }

    #[Computed]
    public function showPekan() : bool 
    {
        return filled($this->form->kode_mk) 
        && filled($this->form->jumlah_kelas) 
        && filled($this->form->suffix_kelas) 
        && filled($this->form->reguler);
    }

    #[Computed]
    public function penugasanDosens() 
    {
        return PenugasanDosen::query()
        ->with(['dosen', 'mataKuliah', 'kelas'])
            ->where('prodi_id', Auth::user()->prodi_id)
            ->when($this->form->kode_dosen, function ($query) {
                $query->whereHas('dosen', fn($q) => $q->where('id', $this->form->kode_dosen));
            })
            ->when($this->form->kode_mk, fn($q) => $q->where('matakuliah_id', $this->form->kode_mk))
            ->when($this->form->idKelas, fn($q) => $q->where('kelas_id', $this->form->idKelas))
            ->orderBy('kd_dosen')
            ->orderBy(
                kelas::select('kode_kelas')->whereColumn('kelas.id', 'penugasan_dosens.kelas_id')
            )
            ->paginate(5);
    }  

    #[On('open-add-ajuan-modal')]
    public function openAddAjuan() 
    {
        Flux::modal('add-ajuan-modal')->show();
    }

    public function bulkAjuan() 
    {
        $this->form->reset();
        Flux::modal('add-ajuan-modal')->close();
        $this->dispatch('reset-fieldSearchable');
        $this->dispatch('reset-fieldSearchable');
        $this->form->resetErrorBag();
        Flux::modal('bulk-ajuan-modal')->show();
    }

    public function addBulk() 
    {
        $this->form->validate();
        $data = [
            'id_dosen' => $this->form->kode_dosen,
            'id_matakuliah' => $this->form->kode_mk,
            'jumlah_kelas' => $this->form->jumlah_kelas,
            'suffix_kelas' => $this->form->suffix_kelas,
            'reguler' => $this->form->reguler,
            'pekan' => $this->form->pekan,
            'prodi_id' => Auth::user()->prodi_id
        ];
        Flux::modal('bulk-ajuan-modal')->close();
        $this->dispatch('konfirmasi-add-bulk', $data);
    }

    public function addAjuanByDosen() 
    {
        $this->form->reset();
        Flux::modal('add-ajuan-modal')->close();
        Flux::modal('ajuan-by-penugasan')->show();
    }

    public function addAjuanPenugasan($id) 
    {
        Flux::modal('ajuan-by-penugasan')->close();
        $this->form->reset();
        $penugasan = PenugasanDosen::query()
            ->with(['mataKuliah', 'dosen', 'kelas'])
            ->findOrFail($id)
        ;
        $this->data = [
            'id' =>  $id,
            'id_dosen' => $penugasan->dosen?->id,
            'kode_dosen' => $penugasan->kd_dosen,
            'nama_dosen' => $penugasan->dosen?->name,
            'kode_mk' => $penugasan->matakuliah_id,
            'spesifikasi_mk' => $penugasan->mataKuliah?->spesifikasi,
            'nama_mk' => $penugasan->mataKuliah?->nama_mk,
            'id_kelas' => $penugasan->kelas_id,
            'kode_kelas' => $penugasan->kelas?->kode_kelas,
            'kode_reguler' => substr($penugasan->kelas?->reguler,-1)
        ];
        $this->form->resetErrorBag();
        Flux::modal('add-ajuan-by-penugasan')->show();
    }

    public function storeAjuanbyPenugasan() 
    {
        $this->form->pekan = $this->pekan;
        $this->form->validate([
            'ruangan_praktikum' => ['required', 'string'],
            'pekan'             => ['required', 'array', 'min:1'],
            'pekan.*'           => ['required']
        ]);
        $this->data['pekan'] = $this->pekan;
        Flux::modal('add-ajuan-by-penugasan')->close();
        $this->dispatch('konfirmasi-ajuan-by-penugasan', $this->data);
    }  

    #[On('open-edit-ajuan-modal')]
    public function showEditAjuanModal($id) {
        $this->resetExcept('form');
        $this->form->reset();
        $ajuan = Ajuan::query()
            ->with('dosen')
            ->findOrFail($id)
        ;
        $this->data['id'] = $id;
        $this->dispatch('dosenField-editMode-modal-edit-ajuan', $ajuan->dosen?->id);
        $this->dispatch('mkField-editMode-modal-edit-ajuan', $ajuan->kode_mk);
        $this->dispatch('kelasField-editMode-modal-edit-ajuan', $ajuan->kode_kelas);
        $this->form->idPekan = $ajuan->pekan;
        $this->form->ruangan_praktikum = 'lab-komputer';
        Flux::modal('edit-ajuan-modal')->show();
    }

    public function updateAjuan($id) {
        $data = [
            'id_dosen' => $this->form->kode_dosen,
            'id_matakuliah' => $this->form->kode_mk,
            'id_kelas' => $this->form->idKelas,
            'id_pekan' => $this->form->idPekan,
            'ruangan_praktikum' => $this->form->ruangan_praktikum
        ];
        $this->data = array_merge($this->data, $data);
        $this->dispatch('update-ajuan', $this->data);
    }

    #[On('sukses-update')]
    public function suksesUpdated($message) {
        Flux::modal('edit-ajuan-modal')->close();
        $this->dispatch('toast', message: $message, type: 'success');
        $this->dispatch('refreshAjuansTable');
    }

    public function backToForm() {
        $this->form->reset();
        Flux::modal('add-ajuan-by-penugasan')->close();
        Flux::modal('ajuan-by-penugasan')->show();
    }

    public function selectAllPekan(?int $id=null): void
    {
        $allPekan = array_map('strval', range(1, 14));
        is_null($id) ? $this->form->pekan = $allPekan : $this->pekan = $allPekan;
    }

    public function unselectAllPekan(?int $id=null): void
    {
        is_null($id) ? $this->form->pekan = [] : $this->pekan = [];
    }

    public function backModal() {
        $this->form->reset();
        Flux::modal('ajuan-by-penugasan')->close();
        Flux::modal('add-ajuan-modal')->show();
    }
    
    public function backBulk() 
    {
        $this->form->reset();
        Flux::modal('bulk-ajuan-modal')->close();
        Flux::modal('add-ajuan-modal')->show();
    }
}
