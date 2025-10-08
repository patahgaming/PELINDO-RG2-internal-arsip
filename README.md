# 📂 PELINDO-RG2 Internal Arsip

Sistem manajemen arsip dokumen internal untuk Pelindo Regional 2.  
Dibuat untuk memudahkan pengelolaan, pencarian, dan penyimpanan dokumen secara terstruktur.

---

## 🚀 Deployment Guide

### 1. Persiapan Server
- **OS**: Ubuntu 20.04/22.04 LTS (disarankan) atau Windows Server  
- **Software yang dibutuhkan**:
  - PHP 8.x
  - MySQL / MariaDB
  - Apache2 / Nginx
  - Git

### 2. Clone Repository
```bash
cd /var/www/
git clone https://github.com/patahgaming/PELINDO-RG2-internal-arsip.git
cd PELINDO-RG2-internal-arsip
```

### 3. Setup Database
```sql
CREATE DATABASE pelindo_arsip;
CREATE USER 'pelindo_user'@'localhost' IDENTIFIED BY 'passwordku';
GRANT ALL PRIVILEGES ON pelindo_arsip.* TO 'pelindo_user'@'localhost';
FLUSH PRIVILEGES;
```

Import file SQL:
```bash
mysql -u pelindo_user -p pelindo_arsip < database/pelindo_arsip.sql
```

### 4. Konfigurasi Aplikasi
Sesuaikan file `function.php`:
```php
<?php
    $host = "localhost";
    $user = "pelindo_user";   
    $pass = "passwordku";        
    $dbname = "pelindo_arsip";
?>
```

### 5. Konfigurasi Web Server

#### 🔹 Apache
Tambahkan VirtualHost:
```apache
<VirtualHost *:80>
    ServerName arsip.pelindo.local
    DocumentRoot /var/www/PELINDO-RG2-internal-arsip/

    <Directory /var/www/PELINDO-RG2-internal-arsip/>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
Aktifkan konfigurasi:
```bash
sudo a2ensite arsip.conf
sudo systemctl reload apache2
```

#### 🔹 Nginx
Tambahkan konfigurasi:
```nginx
server {
    listen 80;
    server_name arsip.pelindo.local;

    root /var/www/PELINDO-RG2-internal-arsip;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```
Reload nginx:
```bash
sudo systemctl restart nginx
```

### 6. Testing
Buka di browser:
```
http://arsip.pelindo.local
```

---

## 🔧 Maintenance

### Update aplikasi
```bash
cd /var/www/PELINDO-RG2-internal-arsip
git pull origin main
```

### Backup database
```bash
mysqldump -u pelindo_user -p pelindo_arsip > backup_$(date +%F).sql
```

### Cek log error
- Apache: `/var/log/apache2/`
- Nginx: `/var/log/nginx/`
- PHP: `/var/log/php8.2-fpm.log`

---

## 👤 Author
- **Yanas Prabu Aliif**
