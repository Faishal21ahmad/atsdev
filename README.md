# ATS Application
## Installation Guide

## Prerequisites
Ensure you have the following installed on your system:
- PHP lastest version
- Composer lastest version
- Node.js & npm lastest version
- OpenSSL
- Docker & Docker Compose

## Installation Steps

### 1. Set Up Application Dependencies
```sh
cd apps/
composer install
npm install
```

### 2. Configure Environment Variables
```sh
cp .env.example .env
nano .env  # Edit the .env file as needed
```

### 3. Generate Application Key
```sh
php artisan key:generate
```

### 4. Build Frontend Assets
```sh
npm run build
```

### 5. Set Up SSL Certificate
```sh
cd ..
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout ./ssl/key.pem -out ./ssl/cert.pem -subj "/CN=localhost"
```

### 6. Configure Server (Optional)
```sh
nano nginx.conf  # Edit configuration
nano Dockerfile  # Edit configuration
nano docker-compose.yml  # Edit configuration
```

### 7. Start Docker Containers
```sh
sudo docker-compose up -d
```

### 8. Access Application Container
```sh
docker exec -it atsapp bash
```

### 9. Set File Permissions
```sh
chmod -R 775 storage bootstrap/cache
chown -R $USER:www-data storage bootstrap/cache
```

### 10. Set Up Application Database and Storage
```sh
php artisan storage:link
php artisan migrate:fresh --seed
```

### 11. Clear and Cache Configuration
```sh
php artisan config:clear
php artisan config:cache
```

### 11. Clear and Cache Configuration
```sh
php artisan config:clear
php artisan config:cache
```
### 12. Access the Application
Open your web browser and navigate to:
```sh
https://<ip-device>:884
```

Your application is now ready to use!

