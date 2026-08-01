<div class="relative" x-data="{ highlighted: 0 }" x-on:click.outside="$wire.showMkDropdown = false"
    x-on:keydown.arrow-down.prevent="highlighted = Math.min(highlighted + 1, ($refs.mkOptions?.children.length ?? 1) - 1)"
    x-on:keydown.arrow-up.prevent="highlighted = Math.max(highlighted - 1, 0)"
    x-on:keydown.enter.prevent="$refs.mkOptions?.children[highlighted]?.click()"
    x-on:keydown.escape="$wire.showMkDropdown = false" x-init="$watch('$wire.mkSearch', () => highlighted = 0)">
    <flux:field>
        <flux:label>Mata Kuliah</flux:label>
        <flux:input wire:model.live.debounce.300ms="mkSearch" wire:focus="showMkDropdown = true"
            wire:blur="$set('showMkDropdown', false)" placeholder="Cari Mata Kuliah..." autocomplete="off" clearable
            wire:clear="$set('kode_mk', null); showMkDropdown = false" />
        <flux:error name="kode_mk" />
    </flux:field>

    @if ($showMkDropdown && $this->matakuliahs->isNotEmpty())
        <div x-ref="mkOptions"
            class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800 max-h-56 overflow-y-auto">
            @foreach ($this->matakuliahs as $i => $mk)
                <button type="button" wire:click="selectMk({{ $mk->id }}, '{{ addslashes($mk->nama_mk) }}')"
                    :class="highlighted === {{ $i }} ? 'bg-zinc-100 dark:bg-zinc-700' : ''"
                    class="block w-full px-3 py-2 text-left text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700">
                    {{ $mk->nama_mk }}
                </button>
            @endforeach
        </div>
    @elseif ($showMkDropdown && filled($mkSearch))
        <div
            class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-500 shadow-lg dark:border-zinc-700 dark:bg-zinc-800">
            Tidak ditemukan.
        </div>
    @endif
</div>