# Panduan Deploy Aplikasi di Server VPS (Ubuntu + aaPanel)

Panduan ini menjelaskan cara mendeploy aplikasi Laravel + React ke server VPS yang menggunakan Ubuntu dan aaPanel.

## Prasyarat

1.  **Akses Server**: Anda memiliki akses SSH ke server VPS Anda.
2.  **aaPanel Terinstall**: aaPanel sudah terinstall di server Ubuntu Anda.
3.  **Software di aaPanel**: Pastikan software berikut sudah terinstall melalui App Store di aaPanel:
    *   Nginx (atau Apache)
    *   PHP 8.2+
    *   MySQL
    *   PM2 Manager (untuk proses Node.js jika diperlukan, meskipun untuk build saja tidak wajib)
4.  **File `deployment.zip`**: File zip proyek yang sudah Anda buat.

## Langkah-langkah Deployment

### 1. Upload Proyek ke Server

1.  **Login ke Server**: Buka terminal atau SSH client dan login ke server Anda:
    ```bash
    ssh root@IP_SERVER_ANDA
    ```

2.  **Buat Direktori Proyek**: Buat direktori baru untuk proyek Anda. Sebaiknya di dalam `/www/wwwroot/`.
    ```bash
    mkdir -p /www/wwwroot/nama_domain_anda
    cd /www/wwwroot/nama_domain_anda
    ```

3.  **Upload File Zip**: Upload file `deployment.zip` dari komputer lokal Anda ke direktori proyek di server. Anda bisa menggunakan `scp` atau fitur **Files** di aaPanel.

    Menggunakan `scp` dari terminal lokal Anda:
    ```bash
    scp /path/to/your/local/lampiran/deployment.zip root@IP_SERVER_ANDA:/www/wwwroot/nama_domain_anda/
    ```

4.  **Unzip Proyek**: Kembali ke terminal SSH di server, unzip file proyek:
    ```bash
    unzip deployment.zip
    ```

### 2. Konfigurasi di aaPanel

1.  **Tambahkan Website**:
    *   Buka aaPanel, pergi ke menu **Website**.
    *   Klik **Add site**.
    *   Masukkan nama domain Anda (misal: `pemilu2024.aswandi.id`).
    *   Pilih **PHP Version** ke `8.2` atau yang lebih baru.
    *   **Document Root** akan otomatis mengarah ke `/www/wwwroot/nama_domain_anda`.
    *   Submit.

2.  **Buat Database**:
    *   Pergi ke menu **Database**.
    *   Klik **Add database**.
    *   Masukkan nama database (misal: `036_laravel12-pusat-data-pemilu-polmark`), username, dan password.
    *   Simpan informasi ini untuk konfigurasi `.env`.
    *   Submit.
    *   (Opsional) Jika Anda punya file SQL, Anda bisa mengimpornya melalui phpMyAdmin yang ada di aaPanel.

3.  **Konfigurasi Nginx/Apache**:
    *   Di menu **Website**, klik nama domain Anda untuk membuka pengaturannya.
    *   Pilih **URL rewrite** (untuk Nginx) atau `.htaccess` (untuk Apache).
    *   Pastikan konfigurasi rewrite rule untuk Laravel sudah benar. Untuk Nginx, biasanya seperti ini:
        ```nginx
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }
        ```
    *   Ubah **Document Root** agar mengarah ke folder `public` di dalam direktori proyek Anda.
        *   Di pengaturan situs, cari **Document Root**.
        *   Ubah dari `/www/wwwroot/nama_domain_anda` menjadi `/www/wwwroot/nama_domain_anda/public`.
        *   Simpan perubahan.

### 3. Konfigurasi Proyek dan Dependensi

1.  **Konfigurasi Environment (`.env`)**:
    *   Kembali ke terminal SSH di server.
    *   Salin file `.env.example` menjadi `.env`:
        ```bash
        cp .env.example .env
        ```
    *   Buka file `.env` dengan editor nano atau vim:
        ```bash
        nano .env
        ```
    *   Sesuaikan konfigurasi berikut:
        ```
        APP_NAME=PusatDataPemilu
        APP_ENV=production
        APP_DEBUG=false
        APP_URL=http://nama_domain_anda

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=nama_database_anda
        DB_USERNAME=username_database_anda
        DB_PASSWORD=password_database_anda
        ```
    *   Simpan file (`Ctrl+X`, lalu `Y`, lalu `Enter` di nano).

2.  **Install Dependensi**:
    *   Install dependensi PHP dengan Composer:
        ```bash
        composer install --no-dev --optimize-autoloader
        ```
    *   Install dependensi Node.js dengan npm:
        ```bash
        npm install
        ```

3.  **Build Aset Frontend**:
    *   Jalankan perintah build Vite untuk mengkompilasi aset React:
        ```bash
        npm run build
        ```

4.  **Jalankan Migrasi Database**:
    *   Jika Anda perlu menjalankan migrasi untuk membuat tabel (misalnya tabel `users`), jalankan:
        ```bash
        php artisan migrate --force
        ```
        *Note: `--force` diperlukan karena aplikasi berada di mode produksi.*

5.  **Generate Kunci Aplikasi**:
    ```bash
    php artisan key:generate
    ```

6.  **Optimasi Laravel**:
    *   Cache konfigurasi dan route untuk performa yang lebih baik di produksi:
        ```bash
        php artisan config:cache
        php artisan route:cache
        php artisan view:cache
        ```

### 4. Atur Hak Akses (Permissions)

Pastikan folder `storage` dan `bootstrap/cache` dapat ditulis oleh web server.

```bash
sudo chown -R www:www /www/wwwroot/nama_domain_anda/storage
sudo chown -R www:www /www/wwwroot/nama_domain_anda/bootstrap/cache
sudo chmod -R 775 /www/wwwroot/nama_domain_anda/storage
sudo chmod -R 775 /www/wwwroot/nama_domain_anda/bootstrap/cache
```
*Note: `www` adalah user dan grup default untuk Nginx/Apache di aaPanel. Ini mungkin berbeda tergantung konfigurasi Anda.*

### 5. Selesai!

Aplikasi Anda sekarang seharusnya sudah bisa diakses melalui nama domain Anda. Jika ada masalah, periksa log error Laravel di `/www/wwwroot/nama_domain_anda/storage/logs/laravel.log` dan log Nginx/Apache di aaPanel.

Untuk membersihkan cache jika ada perubahan konfigurasi:
```bash
php artisan optimize:clear
```
