<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SILABUS | Sistem Informasi Manajemen Laboratorium</title>
    @vite (["resources/css/app.css", "resources/js/app.js"])
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap"
        rel="stylesheet"
    />
    <style>
        body {
            font-family: "Plus Jakarta Sans", sans-serif;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <nav
        class="flex items-center justify-between bg-white px-12 py-6 shadow-sm"
    >
        <div class="flex items-center gap-3">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600 text-xl font-bold text-white"
            >
                L
            </div>
            <span class="text-xl font-extrabold tracking-tight text-blue-900"
                >SILAB<span class="text-blue-600">US</span></span
            >
        </div>
        <div class="space-x-6">
            @if (Route::has("login"))
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="font-semibold text-blue-600"
                        >Dashboard</a
                    >
                @else
                    <a
                        href="{{ route('login') }}"
                        class="rounded-full bg-blue-600 px-6 py-2.5 font-semibold text-white transition hover:bg-blue-700"
                        >Masuk Sistem</a
                    >
                @endauth
            @endif
        </div>
    </nav>

    <section
        class="hero-gradient relative overflow-hidden px-12 py-24 text-white"
    >
        <div class="relative z-10 max-w-4xl">
            <h1 class="mb-6 text-5xl font-extrabold leading-tight md:text-6xl">
                Sistem Manajemen <br /><span class="text-blue-200"
                    >Laboratorium Terpadu.</span
                >
            </h1>
            <p class="mb-10 max-w-2xl text-lg text-blue-100">Efisiensi penjadwalan, pengelolaan inventaris, dan pemantauan aktivitas laboratorium dalam satu platform terintegrasi. Dirancang untuk meningkatkan kualitas riset dan praktikum.</p>
            <div class="flex gap-4">
                <a
                    href="#features"
                    class="rounded-lg bg-white px-8 py-3 font-bold text-blue-900 shadow-lg"
                    >Pelajari Fitur</a
                >
                <div class="flex items-center gap-2 italic text-blue-100">
                    <span>TIM LABORATORIUM UNPAM SERANG</span>
                </div>
            </div>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/3 opacity-10">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#FFFFFF" d="M44.7,-76.4C58.1,-69.2,70.1,-59,78.8,-46.1C87.4,-33.1,92.7,-17.5,91.8,-2.2C90.9,13.1,83.8,28.1,74.2,40.8C64.6,53.5,52.5,63.9,38.8,71C25.1,78.1,9.8,81.9,-4.9,80.3C-19.6,78.7,-33.7,71.7,-46.2,62.1C-58.7,52.5,-69.6,40.3,-76.4,26.1C-83.2,11.9,-85.9,-4.3,-82.4,-19.1C-78.9,-33.9,-69.2,-47.3,-56.9,-54.9C-44.6,-62.5,-29.7,-64.3,-15.8,-70.8C-1.9,-77.3,10.9,-88.5,24.8,-88.2C38.7,-87.9,53.7,-76.1,44.7,-76.4Z" transform="translate(100 100)" />
            </svg>
        </div>
    </section>

    <section id="features" class="grid gap-8 px-12 py-20 md:grid-cols-3">
        <div class="rounded-2xl border border-gray-100 bg-white p-8 shadow-sm">
            <div
                class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 text-blue-600"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 48 48">
                    <path d="M0 0h48v48H0z" fill="none" />
                    <defs>
                        <mask id="SVGjtLwKbIn">
                            <g fill="#555" stroke="#fff" stroke-linejoin="round" stroke-width="4">
                                <path d="M18.284 43.171a20 20 0 0 1-8.696-5.304a6 6 0 0 0-5.182-9.838A20 20 0 0 1 4 24c0-2.09.32-4.106.916-6H5a6 6 0 0 0 5.385-8.65a20 20 0 0 1 8.267-4.627A6 6 0 0 0 24 8a6 6 0 0 0 5.348-3.277a20 20 0 0 1 8.267 4.627A6 6 0 0 0 43.084 18A20 20 0 0 1 44 24c0 1.38-.14 2.728-.406 4.03a6 6 0 0 0-5.182 9.838a20 20 0 0 1-8.696 5.303a6.003 6.003 0 0 0-11.432 0Z" />
                                <path d="M24 31a7 7 0 1 0 0-14a7 7 0 0 0 0 14Z" />
                            </g>
                        </mask>
                    </defs>
                    <path fill="#86621a" d="M0 0h48v48H0z" mask="url(#SVGjtLwKbIn)" />
                </svg>
            </div>
            <h3 class="mb-3 text-xl font-bold">Admin Lab</h3>
            <p class="text-gray-600">Fitur plotting jadwal otomatis dan manajemen aset laboratorium secara real-time.</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-8 shadow-sm">
            <div
                class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 text-green-600"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 256 256">
                    <path d="M0 0h256v256H0z" fill="none" />
                    <path fill="#1a6386" d="m226.53 56.41l-96-32a8 8 0 0 0-5.06 0l-96 32A8 8 0 0 0 24 64v80a8 8 0 0 0 16 0V75.1l33.59 11.19a64 64 0 0 0 20.65 88.05c-18 7.06-33.56 19.83-44.94 37.29a8 8 0 1 0 13.4 8.74C77.77 197.25 101.57 184 128 184s50.23 13.25 65.3 36.37a8 8 0 0 0 13.4-8.74c-11.38-17.46-27-30.23-44.94-37.29a64 64 0 0 0 20.65-88l44.12-14.7a8 8 0 0 0 0-15.18ZM176 120a48 48 0 1 1-86.65-28.45l36.12 12a8 8 0 0 0 5.06 0l36.12-12A47.9 47.9 0 0 1 176 120" />
                </svg>
            </div>
            <h3 class="mb-3 text-xl font-bold">Program Studi</h3>
            <p class="text-gray-600">Unggah ajuan praktikum, manajemen kelas paralel, dan pantau status persetujuan jadwal.</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-8 shadow-sm">
            <div
                class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 text-purple-600"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 28 28">
                    <path d="M0 0h28v28H0z" fill="none" />
                    <path fill="#1a863b" d="M21 16a3 3 0 0 1 3 3v.715C24 23.292 19.79 26 14 26S4 23.433 4 19.715V19a3 3 0 0 1 3-3zM14 2a6 6 0 1 1 0 12a6 6 0 0 1 0-12" />
                </svg>
            </div>
            <h3 class="mb-3 text-xl font-bold">Dosen & Mahasiswa</h3>
            <p class="text-gray-600">Akses jadwal kuliah, sistem check-in praktikum, dan pelaporan kerusakan fasilitas.</p>
        </div>
    </section>
</body>
</html>
