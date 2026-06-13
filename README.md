## Whats' on this update ?

### update libary:
"tailwindcss": "^3.1.0" -> "tailwindcss": "^4.3.0"

karena saya melakukan update nya menggunakan terminal:
```bash
npx @tailwindcss/upgrade
```
Maka secara otomatis pada views secara keselurhan banyak yg berubah tapi tenang itu tidak merubah kok

### add libarary:
Livewire and
Flux UI

### Fitur
Menambahkan Nav Jadwal Praktikum untuk user role Prodi
Terdapat 3 Filter; Lab/Ruangan, Pekan, Prodi beserta paginate
Download PDF nya juga berdasarkan Filter yg aktif

untuk Filter ing sudah asyn yaaa, jadi nya client side
just code with php can asyn like js, coz the power of Livewire

## What should u do ?
After git clone please run this command

install libaray node for tailwind
```bash
npm install
```
install library php for livewire and flux

```bash
composer install
```

and run your webserver or
```bash
php artisan serve
```
