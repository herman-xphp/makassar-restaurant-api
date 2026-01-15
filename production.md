# Production Deployment Guide

This guide outlines the steps and best practices for deploying the **Makassar Restaurant API** to a production environment.

## Server Requirements

-   **Linux** (Ubuntu 22.04 LTS recommended)
-   **Web Server**: Nginx (preferred) or Apache
-   **PHP**: 8.2+ with extensions (`bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `sqlite3` or `mysql`)
-   **Consumer**: Supervisor (for queue workers, if needed)

## Setup Steps

1.  **Clone Release**

    Clone the repository to `/var/www/makassar-restaurant-api`.

    ```bash
    git clone https://github.com/your-username/makassar-restaurant-api.git .
    git checkout main # Deployment should be from main/release branch
    ```

2.  **Dependencies**

    Install optimized class maps and no dev dependencies:

    ```bash
    composer install --optimize-autoloader --no-dev
    ```

    Build frontend assets for production:

    ```bash
    npm ci
    npm run build
    ```

3.  **Environment**

    ```bash
    cp .env.example .env
    nano .env
    ```

    **Critical Production Settings:**

    -   `APP_ENV=production`
    -   `APP_DEBUG=false`
    -   `APP_KEY=` (Run `php artisan key:generate`)
    -   `DB_CONNECTION=` (Use MySQL/MariaDB/PostgreSQL for heavy loads, though SQLite is fine for small scale)

4.  **Permissions**

    Ensure the web server user (`www-data`) owns the storage logs:

    ```bash
    chown -R www-data:www-data storage bootstrap/cache
    chmod -R 775 storage bootstrap/cache
    ```

5.  **Database & Optimization**

    ```bash
    # Migrate Forcefully
    php artisan migrate --force

    # Cache Configuration
    php artisan config:cache
    php artisan event:cache
    php artisan route:cache
    php artisan view:cache
    ```

## Web Server Configuration (Nginx Example)

Create a configuration file in `/etc/nginx/sites-available/makassar-restaurant`.

```nginx
server {
    listen 80;
    server_name example.com;
    root /var/www/makassar-restaurant-api/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Security Checklist

-   [ ] **SSL/TLS**: Use Certbot (`certbot --nginx`) to enable HTTPS.
-   [ ] **Firewall**: Setup UFW to allow only SSH (22), HTTP (80), and HTTPS (443).
-   [ ] **Backups**: Schedule daily backups of `database.sqlite` (or your database) and `storage/app/public`.

## Shared Hosting Deployment (cPanel / MySQL)

Since you are using Shared Hosting with MySQL, the process differs slightly as you may not have root access.

### 1. Preparation (Local)

1.  **Build Assets**:
    Run this locally since Node.js might not be available on shared hosting.

    ```bash
    npm run build
    ```

2.  **Prepare Files**:
    Zip your entire project excluding `node_modules` and `.git`.

### 2. Upload to Server

1.  **File Manager**:

    -   Upload your project zip to a folder _above_ `public_html` (e.g., `/home/username/makassar-app`).
    -   Extract the files.

2.  **Public Folder**:

    -   Move the contents of your project's `public/` folder to your public directory (e.g., `public_html` or `public_html/subdomain`).
    -   Edit `index.php` in that public folder:

    ```php
    // Update paths to point to your project folder
    require __DIR__.'/../makassar-app/storage/framework/maintenance.php';
    require __DIR__.'/../makassar-app/vendor/autoload.php';
    $app = require_once __DIR__.'/../makassar-app/bootstrap/app.php';
    ```

### 3. Database Setup (MySQL)

1.  **Create Database**:

    -   Go to cPanel > MySQL Database Wizard.
    -   Create a database (e.g., `username_makassar`).
    -   Create a user (e.g., `username_admin`) and password.
    -   **Grant All Privileges** to the user for that database.

2.  **Environment Config**:

    -   Edit `.env` in your project folder (`/home/username/makassar-app/.env`).

    ```env
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://your-domain.com

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=username_makassar
    DB_USERNAME=username_admin
    DB_PASSWORD=your_secure_password
    ```

### 4. Migrations & Symlink

If you have SSH access (Terminal) in cPanel:

```bash
cd /home/username/makassar-app
php artisan migrate --force
php artisan storage:link
php artisan optimize
```

**If NO SSH Access:**

1.  **Migrations**: You might need to import a local SQL dump via phpMyAdmin.
    -   Locally: `php artisan migrate` (ensuring .env points to a local mysql equivalent) -> Export SQL.
    -   Server: Import SQL via phpMyAdmin.
2.  **Storage Link**: You can create a PHP script in your public folder to create the link once:
    ```php
    <?php
    symlink('/home/username/makassar-app/storage/app/public', '/home/username/public_html/storage');
    echo "Symlink Created";
    ?>
    ```
    Run it via browser `your-domain.com/link.php`, then delete it.

### 5. .htaccess (Apache)

Ensure you have the default Laravel `.htaccess` in your public folder. If you are serving from a subdirectory, you might need to adjust `RewriteBase`.
