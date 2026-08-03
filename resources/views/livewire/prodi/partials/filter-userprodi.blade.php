<div class="w-full sm:w-56">
    <flux:select wire:model.live="prodi" label="Prodi">
        <flux:select.option value="">Semua Prodi</flux:select.option>
        <flux:select.option value="{{ $this->user->prodi_id }}">
            {{ $this->user?->prodi->nama_prodi }}
        </flux:select.option>
    </flux:select>
</div>