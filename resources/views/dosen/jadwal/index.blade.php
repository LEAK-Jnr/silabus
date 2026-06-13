<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{
                __(
                    "Portal Jadwal Dosen",
                )
            }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-8 shadow-xs sm:rounded-lg">
                <div class="mb-6 flex items-center gap-4">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-xl text-indigo-600"
                    >
                        👤
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">
                            Selamat Datang, {{ Auth::user()->name }}
                        </h3>
                        <p class="text-sm text-gray-500">NIDOS: {{ Auth::user()->username }}</p>
                    </div>
                </div>

                <hr class="mb-6" />

                <h4 class="mb-4 font-semibold text-gray-700">
                    Jadwal Praktikum Anda Minggu Ini:
                </h4>

                <div
                    class="rounded-xl border-2 border-dashed border-gray-200 p-10 text-center"
                >
                    <p class="italic text-gray-400">Belum ada jadwal praktikum yang dipublikasikan untuk akun Anda.</p>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div
                        class="rounded-lg border border-indigo-100 bg-indigo-50 p-4"
                    >
                        <h5 class="mb-2 font-bold text-indigo-900">
                            Informasi Penting
                        </h5>
                        <ul
                            class="list-inside list-disc space-y-1 text-sm text-indigo-800"
                        >
                            <li>
                                Pastikan melakukan check-in saat memulai
                                praktikum.
                            </li>
                            <li>
                                Laporkan kerusakan alat melalui menu 'Lapor
                                Sarpras'.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
