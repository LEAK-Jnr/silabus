<?php

namespace App\Livewire\Forms\Prodi;

use App\Models\Ajuan;
use App\Models\kelas;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Form;

class AjuanProdiForm extends Form
{
    public string $mkSearch = '';
    public string $dosenSearch = '';
    public ?int $jumlah_kelas = null;
    public ?int $suffix_kelas = null;
    public string $reguler = '';
    public string $ruangan_praktikum = '';
    public ?int $kode_mk = null;
    public ?int $kode_dosen = null;
    public array $pekan = [];

    public Collection $data;

    public function rules(): array
    {
        return [
            'mkSearch' => ['required', 'string'],
            'dosenSearch' => ['required', 'string'],
            'jumlah_kelas' => ['required', 'integer', 'min:1'],
            'suffix_kelas' => ['required', 'integer', 'min:1'],
            'reguler' => ['required', 'string'],
            'ruangan_praktikum' => ['required', 'string'],
            'kode_mk' => ['required', 'integer', 'exists:mata_kuliahs,id'],
            'kode_dosen' => ['required', 'integer', 'exists:users,id'],
            'pekan' => ['required', 'array'],
            'pekan.*' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'mkSearch.required' => 'Mata kuliah harus diisi.',
            'dosenSearch.required' => 'Nama dosen harus diisi.',
            'jumlah_kelas.required' => 'Jumlah kelas harus diisi.',
            'jumlah_kelas.integer' => 'Jumlah kelas harus berupa angka.',
            'jumlah_kelas.min' => 'Jumlah kelas minimal 1.',
            'suffix_kelas.required' => 'Suffix kelas harus diisi.',
            'suffix_kelas.integer' => 'Suffix kelas harus berupa angka.',
            'suffix_kelas.min' => 'Suffix kelas minimal 1.',
            'reguler.required' => 'Reguler harus diisi.',
            'reguler.in' => 'Reguler harus berupa "reguler" atau "non-reguler".',
            'ruangan_praktikum.required' => 'Ruangan praktikum harus diisi.',
            'kode_mk.required' => 'Kode mata kuliah harus diisi.',
            'kode_mk.integer' => 'Kode mata kuliah harus berupa angka.',
            'kode_mk.exists' => 'Kode mata kuliah tidak valid.',
            'kode_dosen.required' => 'Kode dosen harus diisi.',
            'kode_dosen.integer' => 'Kode dosen harus berupa angka.',
            'kode_dosen.exists' => 'Kode dosen tidak valid.',
            'pekan.required' => 'Pekan harus diisi minimal 1.',
            'pekan.array' => 'Pekan harus berupa array.',
            'pekan.*.required' => 'Pekan tidak boleh kosong.',
            'pekan.*.integer' => 'Pekan harus berupa angka.',
            'pekan.*.min' => 'Pekan minimal 1.',
        ];
    }

    public function store(): void
    {
        // dd($this->data);
        foreach ($this->data as $item) {
            DB::beginTransaction();
            try {
                Ajuan::create([
                    'kode_mk' => $item['kode_mk'],
                    'kode_kelas' => $this->getIdKelas($item['kelas']),
                    'user_username' => $this->getKodeDosen($item['kode_dosen']),
                    'ruangan_id' => $item['ruangan_praktikum'],
                    'pekan' => $item['pekan'],
                    'hari' => null,
                    'jam_mulai' => null,
                    'jam_selesai' => null,
                    'status' => 'menunggu',
                ]);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack(); 
                throw $th;
            }
        }
    }

    public function getIdKelas($kodeKelas){
        return kelas::where('kode_kelas', $kodeKelas)->first()?->id;
    }

    public function getKodeDosen($idDosen){
        return User::where('id', $idDosen)->first()?->username;
    }

}
