<?php

namespace App\Livewire\Prodi;

use App\Livewire\Forms\Prodi\AjuanProdiForm;
use App\Models\Ajuan;
use App\Models\kelas;
use App\Models\MataKuliah;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class AjuanModalProdi extends Component
{
    public bool $showKelasDropdown = false;
    public $spesifikasiMK = '';
    public $reg ='';
    public AjuanProdiForm $ajuanProdiForm;

    public function render()
    {   
        return view('livewire.prodi.ajuan-modal-prodi');
    }

    #[On('ajuan-modal-prodi')]
    public function showForm()
    {
        $this->ajuanProdiForm->resetExcept('data');
        $this->ajuanProdiForm->data = collect();
        $this->dispatch('reset-fieldSearchable');
        Flux::modal('add-ajuan-prodi')->show();
    }

    #[On('edit-ajuan-modal-prodi')]
    public function showEditForm($id){
        $this->ajuanProdiForm->resetExcept('data');
        $ajuan = Ajuan::with(['mataKuliah', 'kelas', 'dosen'])->findOrFail($id);
        $this->spesifikasiMK = $ajuan->mataKuliah?->spesifikasi ?? '';
        $this->reg = $ajuan->kelas?->reguler ?? '';
        $this->ajuanProdiForm->setAjuan($id);
        $this->dispatch('mkField-editMode', $ajuan->kode_mk);
        $this->dispatch('dosenField-editMode', $ajuan->dosen?->id);
        Flux::modal('edit-ajuan-prodi')->show();
    }

    #[Computed]
    public function matakuliahs()
    {
        return MataKuliah::query();
    }

    #[Computed]
    public function dosens(){
        return User::query();
    }

    #[Computed]
    public function kelas(){
        if (blank($this->ajuanProdiForm->kelas)) {
            return collect();
        }
        $idProdi = Auth::user()->prodi_id;
        $semester = $this->matakuliahs()->firstWhere('id', $this->ajuanProdiForm->kode_mk)?->semester;
        $prefixSemester = str_pad($semester, 2, '0', STR_PAD_LEFT);
        return kelas::query()
            ->where('prodi_id', $idProdi)
            ->where('kode_kelas', 'like', $prefixSemester . '%')
            ->when($this->ajuanProdiForm->kelas, function ($query) {
                $query->where('kode_kelas', 'like', '%' . $this->ajuanProdiForm->kelas . '%');
            })
            ->orderBy('kode_kelas', 'asc')
            ->get();
        ;
    }
    public function save()
    {   
        $this->ajuanProdiForm->validate();
        $this->generateData();
        Flux::modal('add-ajuan-prodi')->close();
        Flux::modal('konfirm-add-ajuan-prodi')->show();
    }

    public function updateAjuan(){
        $this->ajuanProdiForm->validate();
        try {
            $this->ajuanProdiForm->update();
            Flux::modal('edit-ajuan-modal')->close();
            return redirect()->route('prodi.ajuan')->with('success', "Berhasil update ajuan");
        } catch (\Exception $e) {
            $this->errorAddAjuan($e->getCode());
        }
    }

    public function storeAjuan()
    {
        Flux::modal('konfirm-add-ajuan-prodi')->close();
        try {
            $this->ajuanProdiForm->store();
            $this->successAddAjuan();
        } catch (\Exception $e) {
            // dd($e->errorInfo[2], $e);
            // $this->errorAddAjuan($e->errorInfo[2]);
            $this->errorAddAjuan($e->getCode());
        }        
    }

    public function successAddAjuan()
    {
        $sukses = $this->ajuanProdiForm->data->get('rowInserted', 0);
        $gagal  = $this->ajuanProdiForm->data->get('errorInsert', 0);
        $this->ajuanProdiForm->resetExcept('data');
        $this->ajuanProdiForm->data = collect();
        $message = "Berhasil menyimpan {$sukses} ajuan jadwal praktikum.";
        if ($gagal > 0) {
            $message .= " Sebanyak {$gagal} data otomatis dilewati karena kode kelas tidak valid.";
        }
        return redirect()->route('prodi.test')->with('success', $message);
    }

    public function errorAddAjuan($messages)
    {
        // return redirect()->route('prodi.test')->with('error', $messages);
        return redirect()->route('prodi.test')->with('error', "Terjadi kesalahan saat menyimpan ajuan | Error Code: $messages");
    }

    public function selectMk(int $id, string $nama): void
    {
        $this->ajuanProdiForm->kode_mk = $id;
        $this->ajuanProdiForm->mkSearch = $nama;
        $this->showMkDropdown = false;
    }

    public function selectDosen(int $id, string $nama): void
    {
        $this->ajuanProdiForm->kode_dosen = $id;
        $this->ajuanProdiForm->dosenSearch = $nama;
        $this->showDosenDropdown = false;
    }

    public function selectKelas(int $id, string $kode_kelas, string $reguler) : void {
        $this->ajuanProdiForm->idKelas = $id;
        $this->ajuanProdiForm->kelas = $kode_kelas;
        $this->reg = $reguler;
        $this->showKelasDropdown = false;
    }

    public function selectAllPekan(): void
    {
        $this->ajuanProdiForm->pekan = array_map('strval', range(1, 14));
    }

    public function unselectAllPekan(): void
    {
        $this->ajuanProdiForm->pekan = [];
    }

    public function generateData(): Collection
    {
        $data = collect();

        $mapProdi = [
            'S1 Sistem Informasi' => 'SIS',
            'S1 Sistem Komputer' => 'SKM',
            'S1 Teknik Elektro' => 'ELS',
            'S1 Teknik Mesin' => 'MSS',
            'S1 Matematika' => 'MTS',
            'S1 Kimia' => 'KIM',
            'S1 Biologi' => 'BIO',
            'S1 Akuntansi' => 'AKS',
            'S1 Manajemen' => 'MJS',
            'S1 Ilmu Hukum' => 'HKS',
            'S1 Ilmu Pemerintahan' => 'IPM',
            'S1 Administrasi Negara' => 'ADN',
        ];

        // Daftar Reguler
        $regulers = [
            
            'A' => 'P',
            'B' => 'M',
            'C' => 'E', 
            
        ];
        $semester = $this->matakuliahs()->firstWhere('id', $this->ajuanProdiForm->kode_mk)?->semester;
        $prefixSemester = str_pad($semester, 2, '0', STR_PAD_LEFT);

        $ruangan_praktikum = '';

        foreach ($this->ajuanProdiForm->pekan as $pekan) {
            // plotting Ruangan
            $spesifikasiMK = $this->matakuliahs()->firstWhere('id', $this->ajuanProdiForm->kode_mk)?->spesifikasi;
            $ruangan_praktikum = null;
            if ($spesifikasiMK === 'tinggi') {
                $ruangan_praktikum = 3;
            } elseif ($spesifikasiMK === 'sedang') {
                $labkom_satu = $this->getCountTotalAjuanLabkom($pekan, $this->ajuanProdiForm->reguler, 1);
                $labkom_dua = $this->getCountTotalAjuanLabkom($pekan, $this->ajuanProdiForm->reguler, 2);
                $limit = match ($this->ajuanProdiForm->reguler) {
                    'A' => 20,
                    'B' => 10,
                    'C' => 5,
                    default => null,
                };
                if ($limit !== null && $labkom_satu < $labkom_dua && $labkom_satu <= $limit) {
                    $ruangan_praktikum = 1;
                } elseif ($limit !== null && $labkom_dua < $labkom_satu && $labkom_dua <= $limit) {
                    $ruangan_praktikum = 2;
                } else {
                    // fallback: reguler tidak dikenali, atau kedua labkom sama penuh/tidak memenuhi limit
                    $ruangan_praktikum = rand(1, 2);
                }
            } else {
                $ruangan_praktikum = rand(1, 2);
            }
            for ($i = 0; $i < $this->ajuanProdiForm->jumlah_kelas; $i++) {
                // $kelas = 'Kelas Reg' . $this->Reguler . '-' . ($this->suffix_kelas + $i);
                $urutan = str_pad($this->ajuanProdiForm->suffix_kelas + $i, 3, '0', STR_PAD_LEFT);
                $kodeProdi = $this->matakuliahs()->firstWhere('id', $this->ajuanProdiForm->kode_mk)?->prodi?->nama_prodi ?? '-';
                $kdReg = $this->ajuanProdiForm?->reguler ?? "-";
                $kelas = $prefixSemester . $mapProdi[$kodeProdi] . $regulers[$kdReg] . $urutan ?? "not selected properly";
                $data->push([
                    'pekan' => $pekan,
                    'kelas' => $kelas,
                    'ruangan_praktikum' => $ruangan_praktikum,
                    'kode_mk' => $this->ajuanProdiForm->kode_mk,
                    'kode_dosen' => $this->ajuanProdiForm->kode_dosen,
                    'mata_kuliah' => $this->matakuliahs()->firstWhere('id', $this->ajuanProdiForm->kode_mk)?->nama_mk,
                    'dosen' => $this->dosens()->firstWhere('id', $this->ajuanProdiForm->kode_dosen)?->name,
                ]);
            }
        }

        return $this->ajuanProdiForm->data = $data;
    }

    public function getCountTotalAjuanLabkom($pekan, $reguler, $ruanganId)
    {
        return Ajuan::query()
            ->with('kelas')
            ->where('pekan', $pekan)
            ->whereHas('kelas', function ($query) use ($reguler) {
                $query->where('reguler', "Reguler $reguler");
            })
            ->where('ruangan_id', $ruanganId)
            ->where('status', 'disetujui')
            ->count();
    }

    public function closeModal() {
        $this->ajuanProdiForm->resetExcept('data');
    }
}
