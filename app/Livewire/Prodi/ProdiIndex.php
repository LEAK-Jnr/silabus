<?php

namespace App\Livewire\Prodi;

use App\Models\Prodi;
use Auth;
use Livewire\Component;

class ProdiIndex extends Component
{
    public function render()
    {
        $prodiName = Prodi::findOrFail(Auth::user()->prodi_id)->nama_prodi;
        return view('livewire.prodi.prodi-index', compact('prodiName'));
    }
}
