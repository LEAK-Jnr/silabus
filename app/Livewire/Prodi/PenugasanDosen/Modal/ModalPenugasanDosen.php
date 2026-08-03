<?php

namespace App\Livewire\Prodi\PenugasanDosen\Modal;

use App\Livewire\Forms\Prodi\PenugasanDosenForm;
use App\Models\Ajuan;
use App\Models\kelas;
use App\Models\MataKuliah;
use App\Models\PenugasanDosen;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalPenugasanDosen extends Component
{
    public PenugasanDosenForm $form;
    public array $data = [];

    public function render()
    {
        return view('livewire.prodi.penugasan-dosen.modal.modal-penugasan-dosen');
    }

    #[Computed]
    public function semester() {
        if (! $this->form->idMatakuliah) {
            return null;
        }
        return MataKuliah::find($this->form->idMatakuliah)
            ->semester
        ;
    }

    #[Computed]
    public function kelas() {
        if (empty($this->form->idMatakuliah) || empty($this->form->reguler)) {
            return collect();
        }
        return kelas::query()
            ->where('prodi_id', Auth::user()->prodi_id)
            ->when($this->form->reguler, fn($q) => $q->where('reguler', $this->form->reguler))
            ->when($this->form->idMatakuliah, function ($query) {
                $prefixSemester = str_pad($this->semester, 2, '0', STR_PAD_LEFT);
                $query->where('kode_kelas', 'like', "{$prefixSemester}%" );
            })
            ->get()
        ;
    }

    #[On('open-modal-addPenugasan')]
    public function openModalAddPenugasan() {
        $this->dispatch('reset-fieldSearchable');
        $this->form->reset();
        $this->form->resetErrorBag();
        Flux::modal('add-penugasan-dosen')->show();
    }

    public function submit() {
        $this->form->validate();
        $user = User::findOrFail($this->form->idDosen);
        $data = [
            'dosen_name' => $user->name,
            'id_dosen' => $this->form->idDosen,
            'kode_dosen' => $user->username,
            'matakuliah_id' => $this->form->idMatakuliah,
            'matakuliah_name' => MataKuliah::findOrFail($this->form->idMatakuliah)?->nama_mk,
            'id_kelases' => $this->form->kelasId,
            'prodi_id' => Auth::user()->prodi_id
        ];
        Flux::modal('add-penugasan-dosen')->close();
        $this->dispatch('modal-konfirmasi-penugasan', $data);
    }

    #[On('show-edit-penugasan')]
    public function showEdit($id) {
        $this->form->reset();
        $this->form->resetErrorBag();
        $penugasan = PenugasanDosen::with('dosen')->findOrFail($id);
        $this->form->idDosen = $penugasan->dosen?->id;
        $this->form->idMatakuliah = $penugasan->matakuliah_id;
        $this->form->idKelas = $penugasan->kelas_id;
        $this->form->idPenugasan = $id;
        $this->dispatch('dosenField-editMode-modal-edit', $penugasan->dosen?->id);
        $this->dispatch('mkField-editMode-modal-edit', $penugasan->matakuliah_id);
        $this->dispatch('kelasField-editMode-modal-edit', $penugasan->kelas_id);
        Flux::modal('edit-penugasan-dosen')->show();
    }

    public function updatePenugasan() {
        $this->validate();
        try {
            $this->form->update();
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type:'error');
        }
        $message = "Berhasil melakukan update!";
        $ajuanUpdated = $this->form->data['ajuanUpdated'];
        if ($ajuanUpdated > 0) {
            $message .= " Ajuan/Jadwal terupdate: {$ajuanUpdated}";
        }
        Flux::modal('edit-penugasan-dosen')->close();
        $this->form->reset();
        $this->dispatch('close-modal-sukses', $message);
    }

    #[On('show-add-penugasan-from-ajuan')]
    public function addPenugasanFromAjuan($id) {
        $this->form->reset();
        $ajuan = Ajuan::query()
            ->with(['mataKuliah', 'kelas'])
        ->findOrFail($id);
        $this->data = [
            "id_mk" => $ajuan->kode_mk,
            "nama_mk" => $ajuan->mataKuliah?->nama_mk,
            "id_kelas" => $ajuan->kode_kelas,
            "kode_kelas" => $ajuan->kelas?->kode_kelas,
            "reguler" => $ajuan->kelas->reguler,
            "semester" => $ajuan->mataKuliah?->semester
        ];
        $this->form->idMatakuliah = $ajuan->kode_mk;
        $this->form->idKelas = $ajuan->kode_kelas;
        Flux::modal('show-add-penugasan-from-ajuan')->show();
    }

    public function addSinglePenugasan() {
        $this->form->validateOnly('idDosen');
        $user = User::findOrFail($this->form->idDosen);
        $namaDosen = $user->name;
        $username = $user->username;
        $data = [
            "kode_dosen" => $username,
            "nama_dosen" => $namaDosen,
            "prodi_id" => Auth::user()->prodi_id
        ];
        $this->data = array_merge($data, $this->data);
        Flux::modal('show-add-penugasan-from-ajuan')->close();
        $this->dispatch('show-konfirmasi-single-penugasan', $this->data);
    }

    public function selectAllKelas() : void {
        $this->form->kelasId = $this->kelas->pluck('id')->map(fn($id) => (string) $id)->toArray();
    }

    public function unselectAllKelas() : void {
        $this->form->kelasId = [];
    }
}
