<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Jadwal Kuliah Pekan 1 - 14</title>
    <style>
        @page {
            margin: 10mm 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #374151;
            margin: 0;
            padding: 0;
        }
        .page-break {
            page-break-after: always;
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
    @php
        // Tentukan pekan yang akan ditampilkan
        $pekanRequest = request('pekan');
        $pekanList = $pekanRequest ? [$pekanRequest] : range(1, 14);
        
        // Ambil filter dari request
        $prodiFilter = request('prodi');
        $labFilter = request('lab');
    @endphp
    
    @foreach ($pekanList as $pekan)
        @php
            $pekanAjuans = $ajuansGrouped->get($pekan, collect());
            
            // Filter berdasarkan prodi jika ada parameter
            if ($prodiFilter) {
                $pekanAjuans = $pekanAjuans->filter(function($item) use ($prodiFilter) {
                    return $item->mataKuliah->prodi_id == $prodiFilter;
                });
            }
            
            // Filter berdasarkan lab jika ada parameter
            if ($labFilter) {
                $pekanAjuans = $pekanAjuans->filter(function($item) use ($labFilter) {
                    return $item->ruangan_id == $labFilter;
                });
            }
        @endphp
        
        <div class="header">
            <h2>Manajemen Laboratorium</h2>
            <p>
                Jadwal Pekan ke-{{ $pekan }}
                @if ($prodiFilter)
                    | Prodi: {{ $prodiFilter }}
                @endif
                @if ($labFilter)
                    | Lab: {{ $labFilter }}
                @endif
            </p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Waktu</th>
                    <th>Ruangan</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Kelas</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pekanAjuans as $j)
                    <tr>
                        <td>
                            @if ($j->hari)
                                <div class="font-bold text-blue-700">
                                    {{ $j->hari }}
                                </div>
                            @else
                                <span class="text-gray-500" style="font-style: italic">Belum di-plot</span>
                            @endif
                        </td>
                        <td>
                            @if ($j->hari)
                                <div class="text-xs text-gray-700">
                                    {{
                                        $j->jam_mulai?->format("H:i")
                                    }} - {{
                                        $j->jam_selesai?->format("H:i")
                                    }}
                                </div>
                            @else
                                <span class="text-gray-500" style="font-style: italic">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="text-gray-700">
                                {{ $j->ruangan->nama_ruangan ?? "N/A" }}
                            </div>
                        </td>
                        <td>
                            <div class="font-bold text-gray-700">
                                {{
                                    $j->mataKuliah
                                        ->nama_mk
                                }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $j->mataKuliah->kode_mk }} ({{ $j->mataKuliah->sks }} SKS)
                            </div>
                        </td>
                        <td>
                            <div class="text-gray-700">
                                {{
                                    $j->dosen
                                        ->name
                                }}
                            </div>
                        </td>
                        <td>
                            <div class="font-bold text-gray-700">
                                {{
                                    $j->kelas
                                        ->kode_kelas
                                }}
                            </div>
                            <div class="text-xs text-gray-500">
                                Reg {{
                                    strtoupper(
                                        $j->kelas->reguler,
                                    )
                                }}
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
                            colspan="7"
                            class="text-center text-gray-500"
                            style="padding: 20px; font-style: italic"
                        >
                            Tidak ada ajuan atau jadwal pada pekan ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
