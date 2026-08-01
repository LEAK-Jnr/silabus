<div class="relative" x-data="{ highlighted: 0 }" x-on:click.outside="$wire.showDosenDropdown = false"
    x-on:keydown.arrow-down.prevent="highlighted = Math.min(highlighted + 1, ($refs.dosenOptions?.children.length ?? 1) - 1)"
    x-on:keydown.arrow-up.prevent="highlighted = Math.max(highlighted - 1, 0)"
    x-on:keydown.enter.prevent="$refs.dosenOptions?.children[highlighted]?.click()"
    x-on:keydown.escape="$wire.showDosenDropdown = false" x-init="$watch('$wire.dosenSearch', () => highlighted = 0)">
    <flux:field>
        <flux:label>Dosen</flux:label>
        <flux:input wire:model.live.debounce.300ms="dosenSearch" wire:focus="showDosenDropdown = true"
            wire:blur="$set('showDosenDropdown', false)" placeholder="Cari nama Dosen..." autocomplete="off" clearable
            wire:clear="$set('kode_dosen', null); showDosenDropdown = false" />
        <flux:error name="kode_dosen" />
    </flux:field>

    @if ($showDosenDropdown && $this->dosens->isNotEmpty())
        <div x-ref="dosenOptions"
            class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800 max-h-56 overflow-y-auto">
            @foreach ($this->dosens as $i => $dosen)
                <button type="button" wire:click="selectDosen({{ $dosen->id }}, '{{ addslashes($dosen->name) }}')"
                    :class="highlighted === {{ $i }} ? 'bg-zinc-100 dark:bg-zinc-700' : ''"
                    class="block w-full px-3 py-2 text-left text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700">
                    {{ $dosen->name }}
                    <span class="text-zinc-400 text-xs">({{ $dosen->username }})</span>
                </button>
            @endforeach
        </div>
    @elseif ($showDosenDropdown && filled($dosenSearch))
        <div
            class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-500 shadow-lg dark:border-zinc-700 dark:bg-zinc-800">
            Tidak ditemukan.
        </div>
    @endif
</div>