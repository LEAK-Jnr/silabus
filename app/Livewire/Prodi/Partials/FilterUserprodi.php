<?php

namespace App\Livewire\Prodi\Partials;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class FilterUserprodi extends Component
{
    #[Modelable]
    public ?int $prodi = null;
    public function render()
    {
        return view('livewire.prodi.partials.filter-userprodi');
    }

    #[Computed]
    public function user() {
        return Auth::user()->loadMissing('prodi');
    }
}
