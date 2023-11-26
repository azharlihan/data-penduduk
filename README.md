# Data Penduduk
Website live tersedia di [datapenduduk.azharlihan.com](https://datapenduduk.azharlihan.com/)

CRUD (Create, Read, Update, Delete) data penduduk menggunakan konsep OOP PHP tanpa framework.

## Cara install

1. Clone repository ini: `git clone https://github.com/azharlihan/data-penduduk.git`
1. Buat database mysql.
1. Pindah ke folder core: `cd data-penduduk/app/core`
1. Duplikat file **Config.example.php** dan rename menjadi **Config.php**: `cp Config.example.php Config.php`
1. Isi database credential pada file **Config.php**
1. kembali ke root project: `cd ../..`
1. Jalankan migrasi database: `php cli migrate`

## Info tambahan

### Pemindahan folder public

Folder `/public` dapat dipindah ketempat lain terpisah dengan folder `/app`. Dengan penyesuaian path pada file `/public/index.php` dan penyesuaian BASEURL pada `/app/core/Config.php`

### Rewrite nginx

Jika menggunakan nginx, silahkan konfigurasikan vhost nya agar ditambahkan rewrite rule:

```
location / {  
	try_files $uri $uri/ /index.php$is_args$query_string;  
}
```