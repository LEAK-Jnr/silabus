<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-900 leading-tight">
            {{ __('Dashboard Utama') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border-b-4 border-blue-600">
                    <p class="text-gray-500 text-sm font-semibold uppercase">Total Program Studi</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Prodi::count() }}</h3>
                    <p class="text-xs text-blue-600 mt-2">● Terintegrasi Sistem</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-b-4 border-green-500">
                    <p class="text-gray-500 text-sm font-semibold uppercase">Ajuan Praktikum</p>
                    <h3 class="text-3xl font-bold text-gray-800">12</h3>
                    <p class="text-xs text-green-600 mt-2">↑ 4 Baru masuk</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-b-4 border-yellow-500">
                    <p class="text-gray-500 text-sm font-semibold uppercase">Laboratorium Aktif</p>
                    <h3 class="text-3xl font-bold text-gray-800">4</h3>
                    <p class="text-xs text-yellow-600 mt-2">● Monitoring Real-time</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-b-4 border-purple-600">
                    <p class="text-gray-500 text-sm font-semibold uppercase">Total Dosen</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'dosen')->count() }}</h3>
                    <p class="text-xs text-purple-600 mt-2">● Akun Terverifikasi</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 bg-white rounded-2xl shadow-sm p-8">
                    <h4 class="text-lg font-bold text-blue-900 mb-4">Selamat Datang di SIM-LAB</h4>
                    <p class="text-gray-600 leading-relaxed">
                        Sistem Informasi Manajemen Laboratorium saat ini sudah siap untuk mengelola data master Program Studi dan autentikasi pengguna. Anda dapat mulai melakukan plotting jadwal setelah semua Prodi mengunggah ajuan praktikum.
                    </p>
                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('admin.prodi.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            Kelola Master Prodi
                        </a>
                        <button class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition">
                            Lihat Panduan Sistem
                        </button>
                    </div>
                </div>

                <div class="bg-blue-900 rounded-2xl shadow-xl p-8 text-white">
                    <h4 class="text-lg font-bold mb-4 italic">System Health</h4>
                    <ul class="space-y-4">
                        <li class="flex justify-between items-center border-b border-blue-800 pb-2">
                            <span class="text-blue-200 text-sm">Database</span>
                            <span class="bg-green-500 text-[10px] px-2 py-1 rounded-full uppercase font-bold">Connected</span>
                        </li>
                        <li class="flex justify-between items-center border-b border-blue-800 pb-2">
                            <span class="text-blue-200 text-sm">Auth System</span>
                            <span class="bg-green-500 text-[10px] px-2 py-1 rounded-full uppercase font-bold">Encrypted</span>
                        </li>
                        <li class="flex justify-between items-center border-b border-blue-800 pb-2">
                            <span class="text-blue-200 text-sm">Vite Server</span>
                            <span class="bg-blue-400 text-[10px] px-2 py-1 rounded-full uppercase font-bold">Ready</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>