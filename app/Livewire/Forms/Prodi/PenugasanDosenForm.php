<?php

namespace App\Livewire\Forms\Prodi;

use App\Models\Ajuan;
use App\Models\PenugasanDosen;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Form;

class PenugasanDosenForm extends Form
{
    public ?int $idDosen = null;
    public ?int $idMatakuliah = null;
    public ?int $idKelas = null;
    public ?int $idPenugasan = null;
    public array $kelasId = [];
    public string $reguler = '';
    public array $data = [];

    public function rules() : array {
        // 1. Validasi saat Create (Multiple Kelas/Checkbox)
        if (!$this->idPenugasan) {
            return [
                'idMatakuliah' => ['required', 'integer', 'exists:mata_kuliahs,id'],
                'idDosen'      => ['required', 'integer', 'exists:users,id'],
                'reguler'      => ['required', 'string'],
                'kelasId'      => ['required', 'array', 'min:1'],
                'kelasId.*'    => [
                    'required', 
                    'integer', 
                    'exists:kelas,id',
                    // 🌟 Cek unik: kelas ini + MK ini belum pernah di-assign ke siapapun
                    Rule::unique('penugasan_dosens', 'kelas_id')
                        ->where('matakuliah_id', $this->idMatakuliah)
                ]
            ];
        }
        // 2. Validasi saat Update (Single Kelas)
        return [
            'idMatakuliah' => ['required', 'integer', 'exists:mata_kuliahs,id'],
            'idDosen'      => ['required', 'integer', 'exists:users,id'],
            'idKelas'      => [
                'required', 
                'integer', 
                'exists:kelas,id',
                // 🌟 Cek unik: abaikan ID penugasan yang sedang di-update
                Rule::unique('penugasan_dosens', 'kelas_id')
                    ->where('matakuliah_id', $this->idMatakuliah)
                    ->ignore($this->idPenugasan)
            ]
        ];
    }

    public function messages() : array 
    {
        return [
            // Validasi Mata Kuliah
            'idMatakuliah.required' => 'Mata kuliah wajib dipilih.',
            'idMatakuliah.integer'  => 'Format mata kuliah tidak valid.',
            'idMatakuliah.exists'   => 'Mata kuliah yang dipilih tidak ditemukan di sistem.',

            // Validasi Dosen
            'idDosen.required'      => 'Dosen pengampu wajib dipilih.',
            'idDosen.integer'       => 'Format dosen tidak valid.',
            'idDosen.exists'        => 'Dosen yang dipilih tidak ditemukan di sistem.',

            // Validasi Reguler
            'reguler.required'      => 'Jenis reguler wajib dipilih.',
            'reguler.string'        => 'Format jenis reguler tidak valid.',

            // Validasi Single Kelas (Update)
            'idKelas.required'      => 'Kelas wajib dipilih.',
            'idKelas.integer'       => 'Format kelas tidak valid.',
            'idKelas.exists'        => 'Kelas yang dipilih tidak ditemukan di sistem.',
            'idKelas.unique'        => 'Mata kuliah pada kelas ini sudah memiliki dosen pengampu lain.',

            // Validasi Array Kelas (Store / Checkbox)
            'kelasId.required'      => 'Pilih minimal satu kelas.',
            'kelasId.array'         => 'Format pilihan kelas tidak valid.',
            'kelasId.min'           => 'Pilih minimal satu kelas.',

            // Validasi Item di Dalam Array Kelas
            'kelasId.*.required'    => 'Kelas yang dipilih tidak boleh kosong.',
            'kelasId.*.integer'     => 'Format ID kelas tidak valid.',
            'kelasId.*.exists'      => 'Salah satu kelas yang dipilih tidak valid atau tidak ditemukan.',
            'kelasId.*.unique'      => 'Salah satu kelas pada mata kuliah ini sudah ditugaskan ke dosen lain.',
        ];
    }

    public function store($data) 
    {
        $rowInserted=0;
        $rowUpdated=0;
        DB::beginTransaction();
        try {
            foreach ($data as $item) {
                PenugasanDosen::create([
                    'prodi_id' => $item['prodi_id'],
                    'kd_dosen' => $item['kd_dosen'],
                    'matakuliah_id' => $item['matakuliah_id'],
                    'kelas_id' => $item['id_kelas']
                ]);
                $rowInserted++;
                $ajuan = Ajuan::query()
                    ->where([
                        'kode_mk' => $this->idMatakuliah,
                        'kode_kelas' => $item['id_kelas'],
                        'status' => 'menunggu'
                    ])
                ->update(
                    [
                        'user_username' => $item['kd_dosen']
                    ]
                );
                $rowUpdated += $ajuan;
            }
            DB::commit();
            $this->data = [
                'rowInserted' => $rowInserted,
                'rowUpdated' => $rowUpdated
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update() {
        $usernameBaru = User::findOrFail($this->idDosen)->username;
        DB::beginTransaction();
        try {
            // 1. Ambil data penugasan lama SEBELUM di-update
            $penugasanLama = PenugasanDosen::findOrFail($this->idPenugasan);
            
            $dosenLama = $penugasanLama->kd_dosen;
            $mkLama    = $penugasanLama->matakuliah_id;
            $kelasLama = $penugasanLama->kelas_id;

            // 2. Update record PenugasanDosen
            $penugasanLama->update([
                'kd_dosen'      => $usernameBaru,
                'matakuliah_id' => $this->idMatakuliah,
                'kelas_id'      => $this->idKelas
            ]);

            // 3. Update tabel Ajuan (Mencari berdasarkan data LAMA -> Mengubah ke data BARU)
            $ajuanUpdated = Ajuan::query()
                ->where([
                    'user_username' => $dosenLama,
                    'kode_mk' => $mkLama,
                    'kode_kelas' => $kelasLama,
                    'status' => 'menunggu',
                ])
                ->update([
                    'user_username' => $usernameBaru,
                    'kode_mk'       => $this->idMatakuliah,
                    'kode_kelas'    => $this->idKelas
                ]);

            DB::commit();

            // 4. Simpan jumlah baris yang ter-update ke $this->data
            $this->data = ['ajuanUpdated' => $ajuanUpdated];
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function storeSinglePenugasan($data) {
        $this->reset(); 
        DB::beginTransaction();
        try {
            PenugasanDosen::create([
                'prodi_id' => $data['prodi_id'],
                'kd_dosen' => $data['kode_dosen'],
                'matakuliah_id' => $data['id_mk'],
                'kelas_id' => $data['id_kelas']
            ]);
            $ajuanUpdated = Ajuan::query()
                ->where(
                    [
                        'kode_mk' => $data['id_mk'],
                        'kode_kelas' => $data['id_kelas'],
                        'status' => 'menunggu'
                    ]
                )
            ->update([
                'user_username' => $data['kode_dosen']
            ]);
            DB::commit();
            $this->data = [
                'ajuanUpdated' => $ajuanUpdated
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function destroy($id) {
        DB::beginTransaction();
        try {
            // 1. Ambil data Penugasan Dosen berdasarkan ID
            $penugasan = PenugasanDosen::findOrFail($id);

            // 2. Cari data Ajuan yang sesuai, lalu update user_username (kode_dosen) menjadi null
            $ajuanUpdated = Ajuan::where('kode_mk', $penugasan->matakuliah_id)
                ->where(
                    [
                        'kode_kelas' => $penugasan->kelas_id,
                        'user_username' => $penugasan->kd_dosen,
                        'status' => 'menunggu'
                    ]
                )
                ->update([
                    'user_username' => null
                ]);

            // 3. Hapus data Penugasan Dosen
            $penugasan->delete();
            DB::commit();
            $this->data = [
                'ajuanUpdated' => $ajuanUpdated
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
