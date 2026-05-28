<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Jadwal Kuliah Pekan {{ $pekanAktif }}</title>
    <style>
        @page {
            margin: 10mm 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #374151;
            margin: 0;
            padding: 0;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 12px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            color: #111827;
            font-weight: bold;
        }
        .header p {
            margin: 4px 0 0 0;
            font-size: 11px;
            color: #6b7280;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th,
        td {
            border-bottom: 1px solid #e5e7eb;
            padding: 8px 10px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.5px;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 8px;
            font-weight: bold;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .menunggu {
            background-color: #fef3c7;
            color: #92400e;
        }
        .disetujui {
            background-color: #dcfce7;
            color: #166534;
        }
        .ditolak {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .text-blue-700 {
            color: #1d4ed8;
            font-weight: bold;
        }
        .text-gray-500 {
            color: #6b7280;
        }
        .text-gray-700 {
            color: #374151;
        }
        .text-xs {
            font-size: 9px;
        }
        .font-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Manajemen Plotting Jadwal Kuliah</h2>
        <p>Jadwal Pekan ke-{{ $pekanAktif }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Waktu & Ruangan</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Kelas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ajuans as $j)
                <tr>
                    <td>
                        @if ($j->hari)
                            <div class="text-blue-700 font-bold">{{ $j->hari }}</div>
                            <div class="text-gray-500 text-xs">
                                {{ $j->jam_mulai?->format('H:i') }} - {{ $j->jam_selesai?->format('H:i') }}
                            </div>
                            <div class="text-gray-500 text-xs" style="margin-top: 2px; font-style: italic;">
                                Ruangan: {{ $j->ruangan->nama_ruangan ?? 'N/A' }}
                            </div>
                        @else
                            <span class="text-gray-500" style="font-style: italic;">Belum di-plot</span>
                        @endif
                    </td>
                    <td>
                        <div class="font-bold text-gray-700">{{ $j->mataKuliah->nama_mk }}</div>
                        <div class="text-gray-500 text-xs">
                            {{ $j->mataKuliah->kode_mk }} ({{ $j->mataKuliah->sks }} SKS)
                        </div>
                    </td>
                    <td>
                        <div class="text-gray-700">{{ $j->dosen->name }}</div>
                    </td>
                    <td>
                        <div class="font-bold text-gray-700">{{ $j->kelas->kode_kelas }}</div>
                        <div class="text-gray-500 text-xs">
                            Reg {{ strtoupper($j->kelas->reguler) }}
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $j->status }}">
                            {{ $j->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td
                        colspan="5"
                        class="text-center text-gray-500"
                        style="padding: 20px; font-style: italic;"
                    >
                        Tidak ada ajuan atau jadwal pada pekan ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
