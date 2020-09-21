# Data Penduduk
Website live tersedia di [datapenduduk.azharlihan.com](https://datapenduduk.azharlihan.com/)

CRUD data penduduk menggunakan konsep OOP PHP tanpa framework.

### Cara install
1. Download melalui [link ini](https://github.com/azharlihan/datapenduduk/archive/master.zip)
2. Extract file nya, kemudian rename folder rootnya untuk mempermudah akses (misal: datapenduduk)
3. Pindahkan ke folder server (misal: htdocs)
4. Import database menggunakan sqldump. File sql ada di dalam folder `/app/datapenduduk.sql`
4. Duplikat file `/app/core/Config.example.php` dan rename menjadi `Config.php`
5. Buka file `/app/core/Config.php` kemudian isi sesuai konfigurasi database dan BASEURL nya. Jika penamaan mengikuti intruksi ini, maka BASEURL diisi dengan `http://localhost/datapenduduk/public`
6. **PENTING** Folder yang diakses pada browser adalah folder `/public`
7. Akses url sesuai konfigurasi URL tadi.

### Info tambahan
Folder `/publik` dapat dipindah ketempat lain terpisah dengan folder `/app`. Dengan penyesuaian path pada file `/publik/index,php` dan penyesuaian BASEURL pada `/app/core/Config.php`
