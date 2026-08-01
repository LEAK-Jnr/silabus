<?php

namespace App\Livewire\Prodi\Jadwal;

use App\Models\Ajuan;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ProdiJadwalIndex extends Component
{
    use WithPagination, WithoutUrlPagination;
    public ?int $ruangan = null;
    public ?int $pekan = null;
    public ?int $prodi = null;

    public function render()
    {
        return view('livewire.prodi.jadwal.prodi-jadwal-index');
    }

    #[Computed]
    public function jadwal() {
        return Ajuan::query()
            ->with(['mataKuliah', 'kelas', 'dosen', 'ruangan'])
            ->where('status', 'disetujui')
            ->when($this->ruangan, fn($q) => $q->where('ruangan_id', $this->ruangan))
            ->when($this->pekan, fn($q) => $q->where('pekan', $this->pekan))
            ->when($this->prodi, function ($query) {
                $query->whereHas('mataKuliah', fn($q) => $q->where('prodi_id', $this->prodi));
            })
            ->orderBy('ruangan_id')
            ->orderBy('pekan')
            ->paginate(35)
        ;
    }

    public function downloadPdf()
    {
        $allJadwals = Ajuan::query()
            ->with(['mataKuliah', 'kelas', 'dosen', 'ruangan'])
            ->where('status', 'disetujui')
            ->when($this->pekan, function($query) {
                $query->where('pekan', $this->pekan);
            })
            ->when($this->prodi, function($query) {
                $query->whereHas('mataKuliah', function($q) {
                    $q->where('prodi_id', $this->prodi);
                });
            })
            ->when($this->ruangan, function($query) {
                $query->where('ruangan_id', $this->ruangan);
            })
            ->orderBy('ruangan_id')
            ->orderBy('pekan')
            ->get();
        $ajuansGrouped = $allJadwals->groupBy('pekan');
        request()->merge([
            'pekan' => $this->pekan ?: null,
            'prodi' => $this->prodi ?: null,
            'lab'   => $this->ruangan ?: null,
        ]);
        return response()->streamDownload(function () use ($ajuansGrouped) {
            echo \Barryvdh\DomPDF\Facade\Pdf::loadView('pdfLayout', compact('ajuansGrouped'))
                ->setPaper('a4', 'landscape')
                ->output();
        }, 'jadwal_praktikum.pdf');
    }

    public function updatedPekan() { $this->resetPage(); }
    public function updatedProdi() { $this->resetPage(); }
    public function updatedRuangan() { $this->resetPage(); }

}
