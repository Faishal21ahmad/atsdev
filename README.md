# ATS Application

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

### 3. Build Frontend Assets
```sh
npm run build
```

### 4. Set Up SSL Certificate
```sh
cd ..    
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout ./ssl/key.pem -out ./ssl/cert.pem -subj "/CN=yourdomain.com"
```

### 5. Configure Server (Optional)
```sh
nano nginx.conf  # Edit configuration
nano Dockerfile  # Edit configuration
nano docker-compose.yml  # Edit configuration
```

### 6. Start Docker Containers
```sh
sudo docker-compose up -d
```

### 7. Access the Application 
Open your web browser and access the application at:
```sh
https://<ip-device>:884
```

Your application is now ready to use!