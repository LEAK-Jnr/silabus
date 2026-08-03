<?php

namespace App\Livewire\Prodi\Partials;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class FilterPekan extends Component
{
    #[Modelable]
    public ?int $pekan = null;
    public function render()
    {
        return view('livewire.prodi.partials.filter-pekan');
    }
}
