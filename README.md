# **Setup Server FrankenPHP untuk Laravel 11 dengan docker**  
Menggunakan Docker, Laravel 11, MariaDB, PhpMyAdmin, dan FrankenPHP

## **Pendahuluan**  
Panduan ini membantu Anda menyiapkan lingkungan pengembangan dengan Docker menggunakan Laravel 11, MariaDB sebagai database, PhpMyAdmin untuk pengelolaan database, dan FrankenPHP sebagai server PHP.

---

## **Prasyarat**  
Sebelum memulai docker, pastikan:  
1. **Laravel** sudah di-*clone* atau di-*generate* ke dalam folder `apps`.  
2. Aplikasi Laravel sudah di-*build* (misalnya, `composer install` / `npm run build` telah dijalankan).  
3. File `.env` Laravel sudah dikonfigurasi sesuai kebutuhan.  

---

## **Konfigurasi**  

### **1. File `.env` Laravel**  
Sesuaikan file `.env` Laravel untuk menggunakan MariaDB. Berikut adalah contoh konfigurasi:  

#### **.env** 
```env
# DB_CONNECTION=sqlite #disable sqlite
DB_CONNECTION=mysql
DB_HOST=172.20.0.3
# DB_PORT=3306 #disable port
DB_DATABASE=testdb
DB_USERNAME=root
DB_PASSWORD=X321Dsq
```

> **Catatan:**  
> - `DB_HOST` harus sama dengan nama layanan MariaDB di `docker-compose.yml`.  
> - Pastikan kredensial `DB_USERNAME` dan `DB_PASSWORD` sesuai dengan yang ada di `docker-compose.yml`.

---

### **2. File `docker-compose.yml`**  
Sesuaikan pengaturan layanan MariaDB dan PhpMyAdmin.

#### **MariaDB**  
```yaml
environment:
  MYSQL_ROOT_PASSWORD: X321Dsq
  MYSQL_DATABASE: testdb
```

#### **PhpMyAdmin**  
```yaml
environment:
  PMA_HOST: mariadb # Nama layanan MariaDB
  PMA_USER: root
  PMA_PASSWORD: X321Dsq
```

---

## **Langkah-Langkah**  

### **1. Bangun dan Jalankan Layanan Docker**  
Jalankan perintah berikut untuk membangun dan menjalankan layanan Docker:  
#### **Terminal**  
```bash
docker-compose up -d
```

### **2. Akses Layanan**  
Setelah layanan berjalan, akses URL berikut:  
- **Aplikasi Laravel**:  
  URL ditentukan pada file `docker-compose.yml` sesuaikan url dan port nya, contoh:.
  - **Http**: `http://localhost:7772` 
  - **Https**: `https://localhost:774`
- **PhpMyAdmin**:  
  URL PhpMyAdmin (misalnya, `http://localhost:8080`). Gunakan kredensial berikut:  
  - **Username**: `root`  
  - **Password**: `X321Dsq`

---

## **Perintah Tambahan**  

### **1. Jalankan Migrasi Database**  
Setelah layanan berjalan, jalankan migrasi database Laravel:  
#### **Terminal**  
```bash
docker exec -it <container_name> php artisan migrate
```

### **2. Buat Storage Link**  
Pastikan untuk menjalankan perintah berikut agar symlink untuk storage dibuat:  
#### **Terminal**  
```bash
docker exec -it <container_name> php artisan storage:link
```

### **3. Debugging**  
Jika ada masalah, periksa log dengan:  
#### **Terminal**  
```bash
docker logs <container_name>
```

---

## **Catatan Penting**  
1. Pastikan semua dependensi Laravel telah diinstal sebelum memulai layanan Docker.  
2. Nama layanan MariaDB di `docker-compose.yml` harus sesuai dengan konfigurasi `DB_HOST` di file `.env` Laravel.  
3. Pastikan port yang digunakan pada `docker-compose.yml` tidak bentrok dengan layanan lain di sistem Anda.  
4. Untuk mengakses dengan menggunakan HTTPS, Disable atau beri command pada Dockerfile 
```Dockerfile
# Hanya saat development:
ENV SERVER_NAME=":7772"
```

---

Dengan langkah-langkah ini, server Laravel Anda akan siap berjalan. Jika Anda mengalami masalah, silakan periksa dokumentasi resmi [Docker](https://docs.docker.com/), [Laravel](https://laravel.com/docs) dan [FrankenPHP](https://frankenphp.dev/docs/). 😊

