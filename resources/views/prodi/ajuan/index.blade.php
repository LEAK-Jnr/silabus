<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-blue-900 leading-tight">
            {{ __('Panel Ajuan Program Studi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Selamat Datang, Admin Prodi {{ Auth::user()->name }}</h3>
                <p class="text-gray-600">Ini adalah halaman khusus untuk menginput ajuan mata kuliah dan jadwal praktikum.</p>
                
                <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700">
                    Sistem sedang disiapkan untuk fitur upload ajuan.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>