# Laravel and React Project


## Overview 
This project is a Laravel backend. Follow the instructions below to set up and run the project locally.

## Prerequisites
Install Docker and Docker Compose: Ensure that Docker and Docker Compose are installed on your device. You can download and install Docker Desktop from the official Docker website or follow instructions for your specific operating system.

## Installation

### 1. Clone the Repository
```
git clone https://github.com/Hamsa1991/news-backend.git
cd path/to/laravel/project
```

### 2. Setup

### Configure the .env File (if needed)
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=news_db
DB_USERNAME=root
DB_PASSWORD=

```

### 3. Build and start the containers
In the terminal, navigate to the directory containing your Dockerfile and docker-compose.yml, then run:
```

docker-compose build
docker-compose up -d
```

### 4. Install Composer Dependencies
```$xslt
docker-compose exec app composer install
```

### 5. Run Migrations
```$xslt
docker-compose exec app php artisan migrate
```

### 6. Access your application:
```
http://localhost:9000
```
 For phpMyAdmin, you can go to http://localhost:9001
 
 To fetch more news from the specified Apis please run in the terminal:
 ```$xslt
php artisan app:fetch-news
```





