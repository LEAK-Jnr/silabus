<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SILABUS | Sistem Informasi Manajemen Laboratorium</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <nav class="flex justify-between items-center px-12 py-6 bg-white shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">L</div>
            <span class="text-xl font-extrabold tracking-tight text-blue-900">SILAB<span class="text-blue-600">US</span></span>
        </div>
        <div class="space-x-6">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-blue-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2.5 bg-blue-600 text-white rounded-full font-semibold hover:bg-blue-700 transition">Masuk Sistem</a>
                @endauth
            @endif
        </div>
    </nav>

    <section class="hero-gradient text-white py-24 px-12 relative overflow-hidden">
        <div class="max-w-4xl relative z-10">
            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6">
                Sistem Manajemen <br><span class="text-blue-200">Laboratorium Terpadu.</span>
            </h1>
            <p class="text-lg text-blue-100 mb-10 max-w-2xl">
                Efisiensi penjadwalan, pengelolaan inventaris, dan pemantauan aktivitas laboratorium dalam satu platform terintegrasi. Dirancang untuk meningkatkan kualitas riset dan praktikum.
            </p>
            <div class="flex gap-4">
                <a href="#features" class="bg-white text-blue-900 px-8 py-3 rounded-lg font-bold shadow-lg">Pelajari Fitur</a>
                <div class="flex items-center gap-2 text-blue-100 italic">
                    <span>TIM LABORATORIUM UNPAM SERANG</span>
                </div>
            </div>
        </div>
        <div class="absolute right-0 top-0 w-1/3 h-full opacity-10">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#FFFFFF" d="M44.7,-76.4C58.1,-69.2,70.1,-59,78.8,-46.1C87.4,-33.1,92.7,-17.5,91.8,-2.2C90.9,13.1,83.8,28.1,74.2,40.8C64.6,53.5,52.5,63.9,38.8,71C25.1,78.1,9.8,81.9,-4.9,80.3C-19.6,78.7,-33.7,71.7,-46.2,62.1C-58.7,52.5,-69.6,40.3,-76.4,26.1C-83.2,11.9,-85.9,-4.3,-82.4,-19.1C-78.9,-33.9,-69.2,-47.3,-56.9,-54.9C-44.6,-62.5,-29.7,-64.3,-15.8,-70.8C-1.9,-77.3,10.9,-88.5,24.8,-88.2C38.7,-87.9,53.7,-76.1,44.7,-76.4Z" transform="translate(100 100)" />
            </svg>
        </div>
    </section>

    <section id="features" class="py-20 px-12 grid md:grid-cols-3 gap-8">
        <div class="p-8 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-6">⚙️</div>
            <h3 class="text-xl font-bold mb-3">Admin Lab</h3>
            <p class="text-gray-600">Fitur plotting jadwal otomatis dan manajemen aset laboratorium secara real-time.</p>
        </div>
        <div class="p-8 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-6">🎓</div>
            <h3 class="text-xl font-bold mb-3">Program Studi</h3>
            <p class="text-gray-600">Unggah ajuan praktikum, manajemen kelas paralel, dan pantau status persetujuan jadwal.</p>
        </div>
        <div class="p-8 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mb-6">👤</div>
            <h3 class="text-xl font-bold mb-3">Dosen & Mahasiswa</h3>
            <p class="text-gray-600">Akses jadwal kuliah, sistem check-in praktikum, dan pelaporan kerusakan fasilitas.</p>
        </div>
    </section>
</body>
</html>