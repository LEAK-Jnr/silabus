<?php

namespace App\Livewire\Prodi\Ajuan\Modal;

use App\Livewire\Forms\Prodi\AjuanProdiForm;
use App\Models\Ajuan;
use App\Models\kelas;
use App\Models\MataKuliah;
use App\Models\PenugasanDosen;
use App\Models\Prodi;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalAjuanKonfirmasi extends Component
{
    public AjuanProdiForm $form;
    public array $dataHapus = [];
    public ?int $counter = null;
    public ?int $idPenugasan = null;
    public Collection $data;
    public function render()
    {
        return view('livewire.prodi.ajuan.modal.modal-ajuan-konfirmasi');
    }

    #[On('konfirmasi-add-bulk')]
    public function bulkAjuan($data) {
        $dataCollection = collect ();
        $mapProdi = [
           'SIS' => 'S1 Sistem Informasi',
           'SKM' => 'S1 Sistem Komputer',
           'ELS' => 'S1 Teknik Elektro',
           'MSS' => 'S1 Teknik Mesin',
           'MTS' => 'S1 Matematika',
           'KIM' => 'S1 Kimia',
           'BIO' => 'S1 Biologi',
           'AKS' => 'S1 Akuntansi',
           'MJS' => 'S1 Manajemen',
           'HKS' => 'S1 Ilmu Hukum',
           'IPM' => 'S1 Ilmu Pemerintahan',
           'ADN' => 'S1 Administrasi Negara',
       ];
       $regulers = [
            'A' => 'P',
            'B' => 'M',
            'C' => 'E', 
        ];
        $dataPekan = $data['pekan'];
        $mataKuliah = MataKuliah::findOrFail($data['id_matakuliah']);
        $semester = $mataKuliah->semester;
        $prefixSemester = str_pad($semester, 2, '0', STR_PAD_LEFT);
        $namaProdi = Prodi::findOrFail($data['prodi_id'])->nama_prodi;
        $kodeProdi = array_search($namaProdi, $mapProdi);
        $kodeReg = $regulers[$data['reguler']];
        $spesifikasiMK = $mataKuliah->spesifikasi;
        $user = User::find($data['id_dosen']);
        $namaDosen = $user?->name ?? "unselected";
        $kodeDosen = $user?->username ?? null;
        foreach ($dataPekan as $pekan) {
            $ruanganPraktikum = $this->generateIdRuangan($spesifikasiMK, $pekan, $data['reguler']);
            for ($i=0; $i < $data['jumlah_kelas']; $i++) { 
                $urutan = str_pad($data['suffix_kelas'] + $i, 3, '0', STR_PAD_LEFT);
                $kelas = $prefixSemester . $kodeProdi . $kodeReg . $urutan;
                $dataCollection->push([
                    'pekan' => $pekan,
                    'id_kelas' => $this->getIdKelas($kelas),
                    'kelas' => $kelas,
                    'ruangan_praktikum' => $ruanganPraktikum,
                    'id_dosen' => $data['id_dosen'],
                    'id_matakuliah' => $data['id_matakuliah'],
                    'nama_mk' => $mataKuliah->nama_mk,
                    'nama_dosen' => $namaDosen,
                    'kode_dosen' => $kodeDosen,
                    'prodi_id' => $data['prodi_id']
                ]);
            }
        }
        $this->counter = $dataCollection->count();
        $this->data = $dataCollection;
        Flux::modal('konfirm-bulk-ajuan-prodi')->show();
    }

    public function addBulkAjuan() {
        try {
            $this->form->storeBulkAjuan($this->data);
            $rowInserted = $this->form->data['rowInserted'];
            $errorInsert = $this->form->data['errorInsert'];
            $penugasanInsert = $this->form->data['penugasanInserted'];
            $message = "Berhasil menyimpan {$rowInserted} ajuan jadwal praktikum.";
            if ($errorInsert > 0) {
                $message .= " Sebanyak {$errorInsert} data otomatis dilewati karena kode kelas tidak valid.";
            }
            if ($penugasanInsert > 0 ) {
                $message .= " Penugasan: {$penugasanInsert} added";
            }
            Flux::modal('konfirm-bulk-ajuan-prodi')->close();
            $this->form->reset();
            $this->reset();
            $this->dispatch('toast', message: $message, type: 'success');
            $this->dispatch('refreshAjuansTable');
        } catch (\Exception $e) {
            Flux::modal('konfirm-bulk-ajuan-prodi')->close();
            $this->dispatch('toast', message: $e->getMessage(), type:'error');
        }
    }

    public function addAjuanPenugasan() {
        try {
            $this->form->storeAjuanPenugasan($this->data);
            $rowInserted = $this->form->data['rowInserted'];
            $message = "Berhasil menyimpan {$rowInserted} ajuan jadwal praktikum.";
            Flux::modal('konfirm-ajuan-by-penugasan')->close();
            $this->form->reset();
            $this->reset();
            $this->dispatch('toast', message: $message, type:'success');
            $this->dispatch('refreshAjuansTable');
        } catch (\Exception $e) {
            Flux::modal('konfirm-ajuan-by-penugasan')->close();
            $this->dispatch('toast', message: $e->getMessage(), type:'error');
        }
    }

    #[On('konfirmasi-ajuan-by-penugasan')]
    public function addAjuanByPenugasan($data) {
        $this->idPenugasan = $data['id'];
        $dataAjuanByPenugasan = collect();
        $dataPekan = $data['pekan'];
        foreach ($dataPekan as $pekan) {
            $idRuangan = $this->generateIdRuangan($data['spesifikasi_mk'], $pekan, $data['kode_reguler']);
            $dataAjuanByPenugasan->push([
                'pekan' => $pekan,
                'id_kelas' => $data['id_kelas'],
                'kelas' => $data['kode_kelas'],
                'ruangan_praktikum' => $idRuangan,
                'id_dosen' => $data['id_dosen'],
                'id_matakuliah' => $data['kode_mk'],
                'nama_mk' => $data['nama_mk'],
                'nama_dosen' => $data['nama_dosen'],
                'kode_dosen' => $data['kode_dosen']
            ]);
        }
        $this->counter = $dataAjuanByPenugasan->count();
        $this->data = $dataAjuanByPenugasan;
        Flux::modal('konfirm-ajuan-by-penugasan')->show();
    }

    #[On('update-ajuan')]
    public function updateAjuan($data) {
        $this->resetExcept(['form', 'data']);
        $this->form->reset();
        $mataKuliah = MataKuliah::findOrFail($data['id_matakuliah']);
        $spesifikasiMK = $mataKuliah->spesifikasi;
        $kodeReg = substr(kelas::findOrFail($data['id_kelas'])->reguler, -1);
        $idRuangan = $this->generateIdRuangan($spesifikasiMK, $data['id_pekan'], $kodeReg);
        $username = User::findOrFail($data['id_dosen'])->username;
        $dataUpdate = [
            'id' => $data['id'],
            'kode_dosen' => $username,
            'id_matakuliah' => $data['id_matakuliah'],
            'id_kelas' => $data['id_kelas'],
            'id_pekan' => $data['id_pekan'],
            'id_ruangan' => $idRuangan
        ];
        try {
            $this->form->updateAjuan($dataUpdate);
            $ajuanUpdated = $this->form->data['ajuanUpdated'];
            $penugasanUpdated = $this->form->data['penugasanUpdated'];
            $message = "Berhasil melakukan update {$ajuanUpdated} Ajuan";
            if ($penugasanUpdated > 0) $message .= " dan {$penugasanUpdated} Penugasan Dosen terupdate!";
            $this->dispatch('sukses-update', $message);
        } catch (\Exception $e) {
            // dd($e->getMessage());
            Flux::modal('edit-ajuan-modal')->close();
            $this->dispatch('toast', message: $e->getMessage(), type:'error');
        }
    }

    #[On('hapus-ajuan')]
    public function hapusAjuan($data) {
        $this->dataHapus = $data;
        $this->dispatch('open-modal-hapus-ajuan');
    }

    public function generateIdRuangan(string $spesifikasiMK, int $pekan, string $kodeReg) : int
    {
        $ruanganPraktikum = 0;
        if ($spesifikasiMK === 'tinggi') {
            $ruanganPraktikum = 3;
        } elseif ($spesifikasiMK === 'sedang') {
            $labkom_satu = $this->getCountTotalAjuanLabkom($pekan, $kodeReg, 1);
            $labkom_dua = $this->getCountTotalAjuanLabkom($pekan, $kodeReg, 2);
            $limit = match ($kodeReg) {
                'A' => 20,
                'B' => 10,
                'C' => 5,
                default => null,
            };
            if ($limit !== null && $labkom_satu < $labkom_dua && $labkom_satu <= $limit) {
                $ruanganPraktikum = 1;
            } elseif ($limit !== null && $labkom_dua < $labkom_satu && $labkom_dua <= $limit) {
                $ruanganPraktikum = 2;
            } else {
                // fallback: reguler tidak dikenali, atau kedua labkom sama penuh/tidak memenuhi limit
                $ruanganPraktikum = rand(1, 2);
            }
        } else {
            $ruanganPraktikum = rand(1, 2);
        }
        return $ruanganPraktikum;
    }

    public function getCountTotalAjuanLabkom($pekan, $reguler, $ruanganId) {
        return Ajuan::query()
            ->with('kelas')
            ->where('pekan', $pekan)
            ->whereHas('kelas', function ($query) use ($reguler) {
                $query->where('reguler', "Reguler {$reguler}");
            })
            ->where('ruangan_id', $ruanganId)
            ->where('status', 'disetujui')
            ->count()
        ;
    }

    public function getIdKelas($kodeKelas) {
        return kelas::where('kode_kelas', $kodeKelas)->first()?->id;
    }
    public function destroy($id) {
        try {
            $this->form->destroy($id);
            $this->dispatch('close-modal-hapus-ajuan');
            $this->reset();
            $this->dispatch('toast', message:'Berhasil menghapus Ajuan', type:'success');
            $this->dispatch('refreshAjuansTable');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type:'error');
        }
    }

    public function backConfirm(?int $id = null) {
        if (is_null($id)) {
            Flux::modal('konfirm-bulk-ajuan-prodi')->close();
            Flux::modal('bulk-ajuan-modal')->show();
        }else{
            Flux::modal('konfirm-ajuan-by-penugasan')->close();
            Flux::modal('add-ajuan-by-penugasan')->show();

        }
    }
}
