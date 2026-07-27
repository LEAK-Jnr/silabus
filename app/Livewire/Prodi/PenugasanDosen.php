<?php

namespace App\Livewire\Prodi;

use Livewire\Component;

class PenugasanDosen extends Component
{
    public function render()
    {
        return view('livewire.prodi.penugasan-dosen');
    }

    public function addPenugasan()
    {
        // TODO: Implement addPenugasan logic
        $this->dispatch('open-modal-penugasan');
    }
}
