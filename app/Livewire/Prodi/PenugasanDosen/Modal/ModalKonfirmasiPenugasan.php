<?php

namespace App\Livewire\Prodi\PenugasanDosen\Modal;

use App\Livewire\Forms\Prodi\PenugasanDosenForm;
use App\Models\kelas;
use App\Models\PenugasanDosen;
use Flux\Flux;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalKonfirmasiPenugasan extends Component
{
    public PenugasanDosenForm $form;
    public array $dataHapus = [];
    public ?int $counter = null;
    public Collection $data;
    public array $dataPenugasan = [];
    public function render()
    {
        return view('livewire.prodi.penugasan-dosen.modal.modal-konfirmasi-penugasan');
    }

    #[On('modal-konfirmasi-penugasan')]
    public function konfirmasiPenugasan($data) {
        $dataColection = collect();
        $kelases = kelas::whereIn('id', $data['id_kelases'])->get()->keyBy('id');
        $this->form->idMatakuliah = $data['matakuliah_id'];
        $this->form->kelasId = $data['id_kelases'];
        $this->form->idDosen = $data['id_dosen'];
        foreach ($data['id_kelases'] as $kelas) {
            $kelasModel = $kelases->get($kelas);
            $dataColection->push([
                'kd_dosen' => $data['kode_dosen'],
                'dosen_name' => $data['dosen_name'],
                'matakuliah_id' => $data['matakuliah_id'],
                'matakuliah_name' => $data['matakuliah_name'],
                'id_kelas' => $kelas,
                'kode_kelas' => $kelasModel?->kode_kelas ?? 'N/A',
                'prodi_id' => $data['prodi_id']
            ]);
        }
        $this->counter = $dataColection->count();
        $this->data = $dataColection;
        Flux::modal('konfirmasi-penugasan-dosen')->show();
    }

    public function store() {
        try {
            $this->form->store($this->data);
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type:'error');
        }
        $inserted = $this->form->data['rowInserted'];
        $updated = $this->form->data['rowUpdated'];
        $message = "Berhasil Menambahkan {$inserted} Penugasan";
        if ($updated > 0) {
            $message .=" dan {$updated} Ajuan terupdated";
        }
        Flux::modal('konfirmasi-penugasan-dosen')->close();
        $this->form->reset();
        $this->dispatch('close-modal-sukses', $message);
    }

    #[On('show-konfirmasi-single-penugasan')]
    public function singleAddPenugasan($data) {
        $this->dataPenugasan = $data;
        $this->dispatch('open-modal-single-add-penugasan-ajuan');   
    }

    public function storeSinglePenugasan() {
        try {
            $this->form->storeSinglePenugasan($this->dataPenugasan);
            $ajuanUpdated = $this->form->data['ajuanUpdated'];
            $message = "Berhasil Menambahkan Penugasan Dosen";
            if ($ajuanUpdated > 0) $message .= " dan {$ajuanUpdated} ajuan telah terupdate";
            $this->form->reset();
            $this->resetExcept('data');
            $this->dispatch('toast', message: $message, type:'success');
            $this->dispatch('refreshPenugasanDosensTable');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type:'error');
        }
    }

    #[On('hapus-penugasan')]
    public function hapusPenugasan($id) {
        $penugasan = PenugasanDosen::query()
            ->with(['dosen', 'mataKuliah', 'kelas'])
            ->whereHas('mataKuliah', fn($q) => $q->where('prodi_id', Auth::user()->prodi_id))
            ->findOrFail($id)
        ;
        $this->dataHapus = [
            'id' => $id,
            'nama_dosen' => $penugasan->dosen?->name,
            'nama_mk' => $penugasan->mataKuliah?->nama_mk,
            'kode_kelas' => $penugasan->kelas?->kode_kelas,
            'semester' => $penugasan->mataKuliah?->semester,
            'reguler' => $penugasan->kelas?->reguler
        ];
        $this->dispatch('open-modal-hapus-penugasan');
    }

    public function destroy($id) {
        try {
            $this->form->destroy($id);
            $this->dispatch('close-modal-hapus-penugasan');
            $this->dataHapus = [];
            $message = "Berhasil menghapus penugasan dosen";
            $ajuanUpdated = $this->form->data['ajuanUpdated'];
            if ($ajuanUpdated > 0) $message .= " dan {$ajuanUpdated} Ajuan telah terupdate";
            $this->dispatch('toast', message: $message, type:'success');
            $this->dispatch('refreshPenugasanDosensTable');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type:'error');
        }
    }

    public function backToForm() {
        Flux::modal('konfirmasi-penugasan-dosen')->close();
        Flux::modal('add-penugasan-dosen')->show();
    }
}
