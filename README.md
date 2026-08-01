## Whats' on this update ?

### Database
Menambahkan constrait nullable pada field: user_username di table ajuans, penambahan Unique pada table penugasan dosens

### Refaktor
most common update is Refactoring

Refaktor struktur folder berdasarkan Fitur.

component field input nyg juga dinamis dan reusable

### Integrasi Fitur Penugasan Update dan Fitur Ajuan

Pada Penugasan Dosen: CRUD data

1 MK dan 1 Kelas diampu oleh 1 Dosen, 1 Dosen bisa mengampu banyak kelas dan mata kuliah

Integrasi pada Fitur ajuan: Pembuatan Ajuan bisa berdasarkan Penugasan Dosen atau Bulk Update, 
pada Add Ajuan berdasarkan Penugasan, flow nya adalah memilih data nya terlebih dahulu, lalu input pekan dan ruangan
untuk pekan bisa multiple choice, validasi nya adalah pekan => array min:1

Bulk Update: Field Dosen bisa nullable, multiple kelas berdasarkan urutan suffix kelas nya, dan multiple pekan.
can create nullabale dosen pada ajuans, dan di table akan keluar button untuk menambahkan dosen, yg nanti nya akan trigger modal form

jika matakuliah dan kelas yg di inputkan sudah ada di table penugasan dosen dan dosen yg di input berbeda dengan yg ada di table ataupun kosong maka proses bulk akan throw exception.

jika matakuliah, kelas dan dosen belum ada pada table penugasan maka data tersebut akan secara otomatis ditambahkan pada table penugasan

Penugasan Edit: data yg diubah pada table penugasan akan mengalami perubahan juga di table ajuan

Penugasan Delete: data yg dihapus pada table penugasan akan mengalami perubahan juga di table ajuan, Dosen => null

# NOTE
Pada Generate update tolong diubah, jika dosen nya null maka akan secara otomatis di tolak

IF YOU FIND BUG, PLEASE GET ME KNOW, I'LL FIX IT SOON


