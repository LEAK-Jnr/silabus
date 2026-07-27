<div>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-blue-900">
            Penugasan Dosen
        </h2>
    </x-slot>
    
    {{-- header --}}
    <div class="py-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-xs sm:rounded-lg">
                <h3 class="mb-4 text-lg font-bold">
                    Penugasan Dosen Program Studi
                </h3>
                <p class="text-gray-600">Plotting dosen ke mata kuliah dan kelas yang diampu.
                </p>
            </div>
        </div>
    </div>
    
    {{-- subtitle --}}
    <flux:heading size="xl" class="text-center pt-4 text-black">Daftar Penugasan Dosen</flux:heading>
    
    {{-- Filter section --}}
    <div class="py-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-4 md:p-5 mt-5">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3">
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        {{-- field Dosen --}}
                        <div class="w-full sm:w-56">
                            <flux:label>Dosen</flux:label>
                            {{-- type field ? --}}
                        </div>

                        {{-- field mata kuliah --}}
                        <div class="w-full sm:w-56">
                            <flux:label>Mata Kuliah</flux:label>
                            {{-- type field ? --}}
                        </div>

                        {{-- field kelas --}}
                        <div class="w-full sm:w-40">
                            <flux:label>Kelas</flux:label>
                            {{-- type field ? --}}
                        </div>
                    </div>

                    <div class="w-full sm:w-auto">
                        <flux:button icon="plus" variant="primary" color="green" wire:click="addPenugasan">
                            Add Penugasan
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>