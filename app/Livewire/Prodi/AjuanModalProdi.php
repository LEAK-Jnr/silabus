<?php

namespace App\Livewire\Prodi;

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
    public bool $showMkDropdown = false;
    public bool $showDosenDropdown = false;
    public string $mkSearch = '';
    public string $dosenSearch = '';
    public ?int $jumlah_kelas = null;
    public ?int $suffix_kelas = null;
    public string $Reguler = '';
    public array $pekan = [];
    public string $ruangan_praktikum = '';
    public ?int $kode_mk = null;
    public ?int $kode_dosen = null;

    public function render()
    {   
        return view('livewire.prodi.ajuan-modal-prodi');
    }

    #[On('ajuan-modal-prodi')]
    public function showForm()
    {
        $this->reset();
        Flux::modal('add-ajuan-prodi')->show();
    }

    #[Computed]
    public function matakuliahs()
    {
        if (blank($this->mkSearch)) {
            return collect();
        }

        return MataKuliah::query()
            ->with('prodi')
            ->where('prodi_id', Auth::user()->prodi_id)
            ->when($this->mkSearch, function ($query) {
                $query->where('nama_mk', 'like', '%' . $this->mkSearch . '%');
            })
            ->orderBy('nama_mk', 'asc')
            ->get();
    }

    #[Computed]
    public function dosens(){
        if (blank($this->dosenSearch)) {
            return collect();
        }

        return User::query()
            ->where('role', 'dosen')
            ->where('prodi_id', Auth::user()->prodi_id)
            ->when($this->dosenSearch, function ($query) {
                $query->where('name', 'like', '%' . $this->dosenSearch . '%');
            })
            ->orderBy('name', 'asc')
            ->get();
    }

    public function save()
    {
        Flux::modal('add-ajuan-prodi')->close();
        Flux::modal('konfirm-add-ajuan-prodi')->show();
    }

    public function selectMk(int $id, string $nama): void
    {
        $this->kode_mk = $id;
        $this->mkSearch = $nama;
        $this->showMkDropdown = false;
    }

    public function selectDosen(int $id, string $nama): void
    {
        $this->kode_dosen = $id;
        $this->dosenSearch = $nama;
        $this->showDosenDropdown = false;
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
        $semester = $this->matakuliahs()->firstWhere('id', $this->kode_mk)?->semester;
        $prefixSemester = str_pad($semester, 2, '0', STR_PAD_LEFT);

        $ruangan_praktikum = '';
        if ($this->ruangan_praktikum === 'lab-komputer') {
            $spesifikasiMK = $this->matakuliahs()->firstWhere('id', $this->kode_mk)?->spesifikasi;
            if ($spesifikasiMK === 'tinggi') {
                $ruangan_praktikum = 'Lab Komputer Tinggi (Lab Komputer 03)';
            } else {
                $ruangan_praktikum = 'Lab Komputer Standar (Lab Komputer 01/02)';
            }
        }

        foreach ($this->pekan as $pekan) {
            for ($i = 0; $i < $this->jumlah_kelas; $i++) {
                // $kelas = 'Kelas Reg' . $this->Reguler . '-' . ($this->suffix_kelas + $i);
                $urutan = str_pad($this->suffix_kelas + $i, 3, '0', STR_PAD_LEFT);
                $kelas = $prefixSemester . $mapProdi[$this->matakuliahs()->firstWhere('id', $this->kode_mk)?->prodi?->nama_prodi] . $regulers[$this->Reguler] . $urutan;
                $data->push([
                    'pekan' => $pekan,
                    'kelas' => $kelas,
                    'ruangan_praktikum' => $ruangan_praktikum,
                    'kode_mk' => $this->kode_mk,
                    'kode_dosen' => $this->kode_dosen,
                    'mata_kuliah' => $this->matakuliahs()->firstWhere('id', $this->kode_mk)?->nama_mk,
                    'dosen' => $this->dosens()->firstWhere('id', $this->kode_dosen)?->name,
                ]);
            }
        }

        return $data;
    }

}
