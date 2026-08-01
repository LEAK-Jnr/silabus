<div class="w-full sm:w-56">
    <flux:select wire:model.live="ruangan" label="Ruangan / Lab">
        <flux:select.option value="">Semua Ruangan</flux:select.option>
        @foreach ($this->ruangans as $r)
            <flux:select.option value="{{ $r->id }}">
                {{ $r->nama_ruangan }}
            </flux:select.option>
        @endforeach
    </flux:select>
</div>