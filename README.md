# Nama Aplikasi: Kaizen Management System

## 📑 Deskripsi

Kaizen Management System adalah aplikasi web berbasis Laravel, Inertia, dan VueJS yang dirancang untuk membantu pegawai dan manajemen perusahaan dalam mengelola ide-ide kaizen dan memfasilitasi proses pengajuan, review, dan pemantauan ide-ide tersebut.

## 📌 Fitur

-   Manajemen pengguna dengan sistem RBAC (Role-Based Access Controll)
-   Cetak bukti pengiriman kaizen (.pdf)
-   Tanda tangan elektronik untuk setiap ide kaizen
-   Pemberian status, point, dan review untuk setiap ide kaizen
-   Monitoring status ide kaizen yang diajukan
-   Dan masih banyak lagi.

## 🛠 Teknologi

-   [Laravel v9](https://github.com/laravel/framework)
-   [InertiaJS](https://github.com/inertiajs/inertia)
-   [VueJS 3](https://github.com/vuejs/core)
-   [Spatie](https://github.com/spatie/laravel-permission)

## Minimum Requirement

Untuk menjalankan aplikasi ini, sistem minimal yang dibutuhkan adalah sebagai berikut:

-   PHP 8.0 atau yang lebih tinggi
-   MySQL 5.7 atau yang lebih tinggi
-   Composer
-   Node.js 16 atau yang lebih tinggi
-   NPM 7 atau yang lebih tinggi

## 💻 Cara Install dan Menjalankan Aplikasi

1. Clone repository ini dengan perintah

```
git clone https://github.com/bloomingbug/kaizen-management-system.git
```

2. Masuk ke direktori aplikasi dengan perintah

```
cd namadirektori
```

3. Salin file .env.example menjadi .env dengan perintah

```
cp .env.example .env
```

4. Sesuaikan konfigurasi database pada file .env sesuai dengan database yang akan digunakan

5. Jalankan perintah

```
composer install
```

untuk menginstal semua package PHP yang dibutuhkan

6. Jalankan perintah

```
npm install
```

untuk menginstal semua package JavaScript yang dibutuhkan

7. Jalankan perintah

```
php artisan key:generate
```

untuk menghasilkan application key yang diperlukan

8. Jalankan perintah

```
php artisan storage:link
```

untuk membuat symbolic link ke direktori storage

9. Jalankan perintah

```
php artisan migrate --seed
```

untuk menjalankan migrasi database dan menambahkan data awal. Kamu bisa merubah data awal pada file database/seeders/

10. Jalankan perintah

```
php artisan serve
```

untuk menjalankan aplikasi pada http://localhost:8000/

11. Jalankan perintah

```
npm run dev
// atau
npm run build
```

untuk mengkompilasi file-file Vue.js dan JavaScript

Sekarang kamu bisa mengakses aplikasi ini pada http://localhost:8000/

## ✌ Kontributor

-   [Tarmuji](https://instagram.com/_tarmuji22)
-   Ujang Ahmad Khoerudin

## 🤝 Credits

-   Dashboard Admin menggunakan [Mazer](https://zuramai.github.io/mazer/)

## 🧾 License

[MIT license](https://opensource.org/licenses/MIT).
