<?php

namespace App\Livewire\Prodi;

use App\Livewire\Forms\Prodi\AjuanProdiForm;
use App\Models\Ajuan;
use App\Models\Ruangan;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
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
    public $idHapus ='';

    public AjuanProdiForm $form;

    public function render()
    {
        return view('livewire.prodi.ajuan-prodi');
    }

    public function addAjuan()
    {
        $this->dispatch('ajuan-modal-prodi');
    }

    public function editAjuan($id){
        $this->dispatch('edit-ajuan-modal-prodi', $id);
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
            ->paginate(35);
    }

    public function deleteAjuan($id){
        $this->idHapus = $id;
        $this->dispatch('open-modal-hapus-ajuan');
    }

    public function destroy(){
        try {
            $this->form->destroy($this->idHapus);
            return redirect()->route('prodi.test')->with('success', 'data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('prodi.test')->with('error', "Gagal Hapus | " . $e->getMessage() );
        }
    }

    public function updatedPekan() { $this->resetPage(); }
    public function updatedDosen() { $this->resetPage(); }
    public function updatedRuangan() { $this->resetPage(); }
    public function updatedStatus() { $this->resetPage(); }
    #[On('refreshAjuansTable')]
    public function refreshTable() {}
}
