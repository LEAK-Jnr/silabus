<?php

namespace App\Livewire\Prodi;

use App\Livewire\Forms\Prodi\AjuanProdiForm;
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
    public bool $showMkDropdown = false;
    public bool $showDosenDropdown = false;

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
        Flux::modal('add-ajuan-prodi')->show();
    }

    #[Computed]
    public function matakuliahs()
    {
        if (blank($this->ajuanProdiForm->mkSearch)) {
            return collect();
        }

        return MataKuliah::query()
            ->with('prodi')
            ->where('prodi_id', Auth::user()->prodi_id)
            ->when($this->ajuanProdiForm->mkSearch, function ($query) {
                $query->where('nama_mk', 'like', '%' . $this->ajuanProdiForm->mkSearch . '%');
            })
            ->orderBy('nama_mk', 'asc')
            ->get();
    }

    #[Computed]
    public function dosens(){
        if (blank($this->ajuanProdiForm->dosenSearch)) {
            return collect();
        }

        return User::query()
            ->where('role', 'dosen')
            ->where('prodi_id', Auth::user()->prodi_id)
            ->when($this->ajuanProdiForm->dosenSearch, function ($query) {
                $query->where('name', 'like', '%' . $this->ajuanProdiForm->dosenSearch . '%');
            })
            ->orderBy('name', 'asc')
            ->get();
    }

    public function save()
    {   
        $this->ajuanProdiForm->validate();
        $this->generateData();
        Flux::modal('add-ajuan-prodi')->close();
        Flux::modal('konfirm-add-ajuan-prodi')->show();
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
        $insertedData = $this->ajuanProdiForm->data->count();
        $this->ajuanProdiForm->resetExcept('data');
        $this->ajuanProdiForm->data = collect();
        return redirect()->route('prodi.test')->with('success', "$insertedData ajuan berhasil dibuat!");
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

    public function selectAllPekan(): void
    {
        $this->ajuanProdiForm->pekan = array_map('strval', range(1, 14));
    }

    public function unselectAllPekan(): void
    {
        $this->ajuanProdiForm->pekan = [];
    }

    public function updatedDosenSearch(): void
    {
        $this->showDosenDropdown = true;
    }

    public function updatedMkSearch(): void
    {
        $this->showMkDropdown = true;
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
        if ($this->ajuanProdiForm->ruangan_praktikum === 'lab-komputer') {
            $spesifikasiMK = $this->matakuliahs()->firstWhere('id', $this->ajuanProdiForm->kode_mk)?->spesifikasi;
            if ($spesifikasiMK === 'tinggi') {
                $ruangan_praktikum = 'Lab Komputer Tinggi (Lab Komputer 03)';
            } else {
                $ruangan_praktikum = 'Lab Komputer Standar (Lab Komputer 01/02)';
            }
        }

        foreach ($this->ajuanProdiForm->pekan as $pekan) {
            for ($i = 0; $i < $this->ajuanProdiForm->jumlah_kelas; $i++) {
                // $kelas = 'Kelas Reg' . $this->Reguler . '-' . ($this->suffix_kelas + $i);
                $urutan = str_pad($this->ajuanProdiForm->suffix_kelas + $i, 3, '0', STR_PAD_LEFT);
                $kelas = $prefixSemester . $mapProdi[$this->matakuliahs()->firstWhere('id', $this->ajuanProdiForm->kode_mk)?->prodi?->nama_prodi] . $regulers[$this->ajuanProdiForm->reguler] . $urutan;
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

}
