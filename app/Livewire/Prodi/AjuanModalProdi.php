<?php

namespace App\Livewire\Prodi;

use App\Models\MataKuliah;
use App\Models\User;
use Flux\Flux;
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
        dd([
            'jumlah_kelas' => $this->jumlah_kelas,
            'suffix_kelas' => $this->suffix_kelas,
            'Reguler' => $this->Reguler,
            'pekan' => $this->pekan,
            'ruangan_praktikum' => $this->ruangan_praktikum,
            'kode_mk' => $this->kode_mk,
            'kode_dosen' => $this->kode_dosen
        ]);
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

}
