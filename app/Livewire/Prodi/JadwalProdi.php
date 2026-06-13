<?php

namespace App\Livewire\Prodi;

use App\Models\Ajuan;
use App\Models\Ruangan;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class JadwalProdi extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $pekan = '';
    public $prodi = '';
    public $ruangan = '';

    public Ajuan $ajuan;
    public function render()
    {
        return view('livewire.prodi.jadwal-prodi');
    }

    public function mount(Ajuan $ajuan)
    {
        $this->ajuan = $ajuan;
        $this->pekan = request()->get('pekan', '');
        $this->prodi = request()->get('prodi', '');
        $this->ruangan = request()->get('lab', '');
    }

    #[Computed]
    public function user(){
        return auth()->user();
    }

    #[Computed]
    public function ruangans(){
        return Ruangan::orderBy('nama_ruangan', 'asc')->get();
    }

    #[Computed]
    public function jadwal(){
        return Ajuan::query()
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
            ->paginate(5);
    }

    public function downloadPdf()
    {
        $allJadwals = \App\Models\Ajuan::query()
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
