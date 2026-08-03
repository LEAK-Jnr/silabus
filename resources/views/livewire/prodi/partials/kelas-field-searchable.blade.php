<div class="relative" x-data="{ highlighted: 0 }" x-on:click.outside="$wire.showKelasDropdown = false"
    x-on:keydown.arrow-down.prevent="highlighted = Math.min(highlighted + 1, ($refs.kelasOptions?.children.length ?? 1) - 1)"
    x-on:keydown.arrow-up.prevent="highlighted = Math.max(highlighted - 1, 0)"
    x-on:keydown.enter.prevent="$refs.kelasOptions?.children[highlighted]?.click()"
    x-on:keydown.escape="$wire.showKelasDropdown = false" x-init="$watch('$wire.kelasSearch', () => highlighted = 0)">
    <flux:field>
        <flux:label>Kelas</flux:label>
        <flux:input wire:model.live.debounce.300ms="kelasSearch" wire:focus="showKelasDropdown = true"
            wire:blur="$set('showKelasDropdown', false)" placeholder="Cari Kode Kelas..." autocomplete="off" clearable
            wire:clear="$set('idKelas', null); showKelasDropdown = false" />
        <flux:error name="idKelas" />
    </flux:field>

    @if ($showKelasDropdown && $this->kelas->isNotEmpty())
        <div x-ref="kelasOptions"
            class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800 max-h-56 overflow-y-auto">
            @foreach ($this->kelas as $i => $item)
                <button type="button" wire:click="selecKelas({{ $item->id }}, '{{ addslashes($item->kode_kelas) }}')"
                    :class="highlighted === {{ $i }} ? 'bg-zinc-100 dark:bg-zinc-700' : ''"
                    class="block w-full px-3 py-2 text-left text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700">
                    {{ $item->kode_kelas }}
                </button>
            @endforeach
        </div>
    @elseif ($showKelasDropdown && filled($kelasSearch))
        <div
            class="absolute z-10 mt-1 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-500 shadow-lg dark:border-zinc-700 dark:bg-zinc-800">
            Tidak ditemukan.
        </div>
    @endif
</div>