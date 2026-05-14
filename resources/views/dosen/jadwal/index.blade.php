<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-indigo-900 leading-tight">
            {{ __('Portal Jadwal Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xl">
                        👤
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}</h3>
                        <p class="text-sm text-gray-500">NIDOS: {{ Auth::user()->username }}</p>
                    </div>
                </div>

                <hr class="mb-6">

                <h4 class="font-semibold text-gray-700 mb-4">Jadwal Praktikum Anda Minggu Ini:</h4>
                
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-10 text-center">
                    <p class="text-gray-400 italic">Belum ada jadwal praktikum yang dipublikasikan untuk akun Anda.</p>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-indigo-50 rounded-lg border border-indigo-100">
                        <h5 class="font-bold text-indigo-900 mb-2">Informasi Penting</h5>
                        <ul class="text-sm text-indigo-800 list-disc list-inside space-y-1">
                            <li>Pastikan melakukan check-in saat memulai praktikum.</li>
                            <li>Laporkan kerusakan alat melalui menu 'Lapor Sarpras'.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>