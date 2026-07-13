<div>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-blue-900">
            Selamat Datang, {{ Auth::user()->name }} - {{ $prodiName }} - Kampus Serang
        </h2>
    </x-slot>

    <div class="mx-auto max-w-6xl space-y-6 py-6">
        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white p-6 shadow-xs sm:rounded-lg">
                    <h3 class="mb-4 text-lg font-bold">
                        Menu Utama
                    </h3>
                    <p class="text-gray-600">
                        Kelola penugasan dosen, ajuan, dan jadwal praktikum program studi.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

            {{-- 1. Penugasan Dosen --}}
            <a href="{{ route('prodi.penugasan-dosen') }}"
                class="group flex flex-col rounded-xl border border-zinc-200 bg-white p-6 shadow-sm transition-all hover:border-blue-300 hover:shadow-md dark:border-zinc-700 dark:bg-zinc-800">
                <div
                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                    <flux:icon name="user-group" class="size-6" />
                </div>

                <flux:heading size="base" class="mb-1">Penugasan Dosen</flux:heading>
                <flux:subheading class="mb-4 flex-1">
                    Plotting dosen ke mata kuliah dan kelas yang diampu.
                </flux:subheading>

                <span
                    class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 group-hover:gap-2 transition-all dark:text-blue-400">
                    Kelola Penugasan
                    <flux:icon name="arrow-right" class="size-4" />
                </span>
            </a>

            {{-- 2. Ajuan Praktikum --}}
            <a href="{{ route('prodi.ajuan') }}"
                class="group flex flex-col rounded-xl border border-zinc-200 bg-white p-6 shadow-sm transition-all hover:border-emerald-300 hover:shadow-md dark:border-zinc-700 dark:bg-zinc-800">
                <div
                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400">
                    <flux:icon name="document-text" class="size-6" />
                </div>

                <flux:heading size="base" class="mb-1">Ajuan Praktikum</flux:heading>
                <flux:subheading class="mb-4 flex-1">
                    Tambah, ubah, hapus, dan lihat daftar ajuan praktikum.
                </flux:subheading>

                <span
                    class="inline-flex items-center gap-1 text-sm font-medium text-emerald-600 group-hover:gap-2 transition-all dark:text-emerald-400">
                    Kelola Ajuan
                    <flux:icon name="arrow-right" class="size-4" />
                </span>
            </a>

            {{-- 3. Jadwal Praktikum --}}
            <a href="{{ route('prodi.jadwal') }}"
                class="group flex flex-col rounded-xl border border-zinc-200 bg-white p-6 shadow-sm transition-all hover:border-amber-300 hover:shadow-md dark:border-zinc-700 dark:bg-zinc-800">
                <div
                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-lg bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400">
                    <flux:icon name="calendar-days" class="size-6" />
                </div>

                <flux:heading size="base" class="mb-1">Jadwal Praktikum</flux:heading>
                <flux:subheading class="mb-4 flex-1">
                    Lihat daftar jadwal dari ajuan yang telah disetujui.
                </flux:subheading>

                <span
                    class="inline-flex items-center gap-1 text-sm font-medium text-amber-600 group-hover:gap-2 transition-all dark:text-amber-400">
                    Lihat Jadwal
                    <flux:icon name="arrow-right" class="size-4" />
                </span>
            </a>

        </div>
    </div>
</div>