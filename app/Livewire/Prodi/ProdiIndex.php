<?php

namespace App\Livewire\Prodi;

use App\Models\Prodi;
use Auth;
use Livewire\Component;

class ProdiIndex extends Component
{
    public function render()
    {
        $prodi = Prodi::find(Auth::user()->prodi_id);
        $prodiName = $prodi ? $prodi->nama_prodi : 'Prodi Tidak Diketahui';
        return view('livewire.prodi.prodi-index', compact('prodiName'));
    }
}
