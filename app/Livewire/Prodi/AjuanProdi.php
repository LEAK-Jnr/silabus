<?php

namespace App\Livewire\Prodi;

use Livewire\Component;

class AjuanProdi extends Component
{
    public function render()
    {
        return view('livewire.prodi.ajuan-prodi');
    }

    public function addAjuan()
    {
        $this->dispatch('ajuan-modal-prodi');
    }
}
