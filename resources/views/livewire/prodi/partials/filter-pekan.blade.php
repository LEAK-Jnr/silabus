<div class="w-full sm:w-40">
    <flux:select wire:model.live="pekan" label="Pekan">
        <flux:select.option value="">Semua Pekan</flux:select.option>
        @for($i = 1; $i <= 14; $i++)
            <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
        @endfor
    </flux:select>
</div>