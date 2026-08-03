<?php

namespace App\Livewire\Forms\Prodi;

use App\Models\Ajuan;
use App\Models\PenugasanDosen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AjuanProdiForm extends Form
{
    public ?int $kode_mk = null;
    public ?int $kode_dosen = null;
    public ?int $jumlah_kelas = null;
    public ?int $suffix_kelas = null;
    public ?int $idKelas = null;
    public ?int $idPekan = null;
    public string $reguler = '';
    public array $pekan = [];
    public string $ruangan_praktikum = '';
    public array $data = [];

    public function rules(): array
    {
        return [
            'kode_mk'           => ['required', 'integer', 'exists:mata_kuliahs,id'],
            'kode_dosen'        => ['nullable', 'integer', 'exists:users,id'],
            'jumlah_kelas'      => ['required', 'integer', 'min:1'],
            'suffix_kelas'      => ['required', 'integer'],
            'reguler'           => ['required', 'string'],
            'ruangan_praktikum' => ['required', 'string'],
            'pekan'             => ['required', 'array', 'min:1'],
            'pekan.*'           => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_mk.required'           => 'Mata kuliah wajib dipilih.',
            'kode_mk.exists'             => 'Mata kuliah tidak valid.',
            'kode_dosen.required'        => 'Dosen wajib dipilih.',
            'kode_dosen.exists'          => 'Dosen tidak terdaftar.',
            'jumlah_kelas.required'      => 'Jumlah kelas wajib diisi.',
            'jumlah_kelas.min'           => 'Jumlah kelas minimal 1.',
            'suffix_kelas.required'      => 'Akhiran/suffix kelas wajib diisi.',
            'reguler.required'           => 'Jenis reguler wajib dipilih.',
            'ruangan_praktikum.required' => 'Ruangan praktikum wajib dipilih.',
            'pekan.required'             => 'Pilih minimal satu pekan.',
            'pekan.min'                  => 'Anda harus memilih setidaknya 1 pekan.',
            'id_kelas.required'          => 'Kelas wajib dipilih.',
            'id_kelas.exists'            => 'Kelas tidak valid.',
            'id_kelas.unique'            => 'Kelas ini dengan Mata Kuliah yang sama sudah ditugaskan ke dosen lain.',
            'id_pekan.required'          => 'Pekan wajib dipilih.',
            'id_ruangan.required'        => 'Ruangan praktikum wajib ditentukan.',
        ];
    }

    public function storeBulkAjuan($data) {
        $rowInserted = 0;
        $errorInsert = 0;
        $penugasanInserted = 0;
        
        DB::beginTransaction();
        try {
            foreach ($data as $item) {
                if (!isset($item['kelas'])) {
                    continue;
                }
                if (is_null($item['id_kelas'])) {
                    $errorInsert++;
                    continue;
                }

                // Cari penugasan yang sudah ada berdasarkan Mata Kuliah & Kelas
                $existingPenugasan = PenugasanDosen::query()
                    ->with(['dosen', 'matakuliah', 'kelas'])
                    ->where([
                        'matakuliah_id' => $item['id_matakuliah'],
                        'kelas_id' => $item['id_kelas']
                    ])
                    ->first();

                if (!empty($item['kode_dosen'])) {
                    // KONDISI A: kode_dosen DIISI, tapi di DB sudah ditugaskan ke dosen BERBEDA
                    if ($existingPenugasan && $existingPenugasan->kd_dosen !== $item['kode_dosen']) {
                        throw new \Exception(
                            "Gagal menyimpan: Mata kuliah {$existingPenugasan->matakuliah?->nama_mk} kelas {$existingPenugasan->kelas?->kode_kelas} sudah ditugaskan kepada dosen {$existingPenugasan->dosen?->name}."
                        );
                    }
                } else {
                    // KONDISI B: kode_dosen NULL / KOSONG, tapi di DB MK & Kelas ini SUDAH ditugaskan
                    if ($existingPenugasan && !empty($existingPenugasan->kd_dosen)) {
                        throw new \Exception(
                            "Gagal menyimpan: Mata kuliah {$existingPenugasan->matakuliah?->nama_mk} kelas {$existingPenugasan->kelas?->kode_kelas} sudah ditugaskan kepada dosen {$existingPenugasan->dosen?->name}. Tidak dapat membuat ajuan tanpa dosen."
                        );
                    }
                }

                // Simpan ke tabel Ajuan
                Ajuan::create([
                    'kode_mk'       => $item['id_matakuliah'],
                    'kode_kelas'    => $item['id_kelas'],
                    'user_username' => $item['kode_dosen'],
                    'ruangan_id'    => $item['ruangan_praktikum'],
                    'pekan'         => $item['pekan'],
                    'status'        => 'menunggu'
                ]);
                $rowInserted++;

                // Handle Penugasan
                if (!empty($item['kode_dosen']) && !is_null($item['id_kelas'])) {
                    $penugasan = PenugasanDosen::firstOrCreate(
                        [
                            'matakuliah_id' => $item['id_matakuliah'],
                            'kelas_id'      => $item['id_kelas']
                        ],
                        [
                            'prodi_id'      => $item['prodi_id'],
                            'kd_dosen'      => $item['kode_dosen']
                        ]
                    );

                    if ($penugasan->wasRecentlyCreated) {
                        $penugasanInserted++;
                    }
                }
            }

            DB::commit();

            $this->data = [
                'rowInserted'       => $rowInserted,
                'errorInsert'       => $errorInsert,
                'penugasanInserted' => $penugasanInserted
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    
    public function storeAjuanPenugasan($data) {
        $rowInserted = 0;
        DB::beginTransaction();
        try {
            foreach ($data as $item) {
                Ajuan::create([
                    'kode_mk' => $item['id_matakuliah'],
                    'kode_kelas' => $item['id_kelas'],
                    'user_username' => $item['kode_dosen'],
                    'ruangan_id' => $item['ruangan_praktikum'],
                    'pekan' => $item['pekan'],
                    'status' => 'menunggu'
                ]);
                $rowInserted++;
            }
            DB::commit();
            $this->data=[
                'rowInserted' => $rowInserted
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateAjuan($data) {
        $ajuanLama = Ajuan::findOrFail($data['id']);
        $dosenLama = $ajuanLama->user_username;
        $mkLama    = $ajuanLama->kode_mk;
        $kelasLama = $ajuanLama->kode_kelas;
        $penugasanLama = PenugasanDosen::query()
            ->where('kd_dosen', $dosenLama)
            ->where('matakuliah_id', $mkLama)
            ->where('kelas_id', $kelasLama)
        ->first();
        Validator::make($data, [
            'id'            => ['required', 'exists:ajuans,id'],
            'id_matakuliah' => ['required', 'integer', 'exists:mata_kuliahs,id'],
            'kode_dosen'    => ['required', 'string', 'exists:users,username'],
            'id_pekan'      => ['required'],
            'id_ruangan'    => ['required'],
            'id_kelas'      => [
                'required',
                'integer',
                'exists:kelas,id',
                // 🌟 Rule Unique: Abaikan ID PenugasanLama jika ada
                Rule::unique('penugasan_dosens', 'kelas_id')
                    ->where('matakuliah_id', $data['id_matakuliah'])
                    ->ignore($penugasanLama?->id)
            ],
        ], $this->messages())->validate();
        DB::beginTransaction();
        try {
            // 2. Update record Ajuan dengan data BARU
            $ajuanUpdated = $ajuanLama->update([
                'kode_mk'       => $data['id_matakuliah'],
                'user_username' => $data['kode_dosen'],
                'kode_kelas'    => $data['id_kelas'],
                'pekan'         => $data['id_pekan'],
                'ruangan_id'    => $data['id_ruangan']
            ]);
            // 3. Update PenugasanDosen berdasarkan kombinasi data LAMA -> ubah ke BARU
            $penugasanUpdated = PenugasanDosen::query()
                ->where('kd_dosen', $dosenLama)
                ->where('matakuliah_id', $mkLama)
                ->where('kelas_id', $kelasLama)
                ->update([
                    'kd_dosen'      => $data['kode_dosen'],
                    'matakuliah_id' => $data['id_matakuliah'],
                    'kelas_id'      => $data['id_kelas']
                ]);
            DB::commit();
            $this->data = [
                'ajuanUpdated' => $ajuanUpdated,
                'penugasanUpdated' => $penugasanUpdated
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public function destroy($idHapus)
    {
        DB::beginTransaction();
        try {
            Ajuan::findOrFail($idHapus)->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
