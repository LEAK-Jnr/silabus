## Whats' on this update ?

### Database
Merubah struktur database, dengan menambahakan Table Baru: 'penugasan_dosen' sekaligus membuat Model nya juga

Table ini digunakan untuk fitur Penugasan Dosen, Dosen x akan mengampu Matakuliah y pada kelas z
yang nanti akan digunakan pada form penambahan ajuan, akan binding ke table ini --> soon

### Routes
Memperbaharui Daftar url untuk role Prodi, Menggunakan Prefix/Awalan Prodi lalu mengelompokan Prefix tersebut

Menambahkan index juga untuk Dashboard role Prodi, Penambahan URL untuk Fitur Penugasan Dosen.

semuanya url sudah menggunakan Class dari Livewire, bukan Native Controller lagi

### Views
Penambahan Navigation pada Role:Prodi.

Nav Link pada Role Prodi: Home, Penugasan Dosen, Ajuan, Jadwal

Create a new blade: prodi-index dan penugasan-dosen, kedua blade menggunakan Livewire
Drop blade: Prodi/Index. Don't worry! sudah ai Backup kok file nya.

### App
Membuat Model baru: Penugasan Dosen

Model tersebut ber relasi ke 3 model lainnya; User, MataKuliah dan Kelas.
Drop Controller Prodi/ProdiController. sama seperti view sudah ai backup kok

## After Pull
Jangan Lupa untuk migrate kembali!
```
php artisan migrate:fresh --seed
```