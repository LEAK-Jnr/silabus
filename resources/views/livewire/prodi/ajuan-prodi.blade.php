<div>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-blue-900">
            {{
                __(
                    "Panel Ajuan Program Studi",
                )
            }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-xs sm:rounded-lg">
                <h3 class="mb-4 text-lg font-bold">
                    Selamat Datang, Admin Prodi {{ Auth::user()->name }}
                </h3>
                <p class="text-gray-600">Ini adalah halaman khusus untuk menginput ajuan mata kuliah dan jadwal praktikum.</p>
                
                <div class="flex-co w-fulll flex-col">
                    <div class="flex justify-end">
                        <flux:button
                            icon="plus"
                            variant="primary"
                            color="blue"
                            wire:click="addAjuan"
                        >
                            Add Ajuan
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <livewire:prodi.ajuan-modal-prodi />
</div>
