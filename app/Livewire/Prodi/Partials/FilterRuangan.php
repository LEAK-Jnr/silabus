<?php

namespace App\Livewire\Prodi\Partials;

use App\Models\Ruangan;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class FilterRuangan extends Component
{
    #[Modelable]
    public ?int $ruangan = null;
    public function render()
    {
        return view('livewire.prodi.partials.filter-ruangan');
    }
    
    #[Computed()]
    public function ruangans() {
        return Ruangan::orderBy('nama_ruangan')->get();
    }
}
