# Development Guide

This guide outlines the steps to set up the **Makassar Restaurant API** project for local development.

## Prerequisites

Ensure you have the following installed on your local machine:

-   **PHP** >= 8.2
-   **Composer**
-   **Node.js** & **NPM** (for frontend assets)
-   **Git**
-   **SQLite** (default database driver)

## Installation

1.  **Clone the Repository**

    ```bash
    git clone https://github.com/your-username/makassar-restaurant-api.git
    cd makassar-restaurant-api
    ```

2.  **Install Dependencies**

    ```bash
    composer install
    npm install
    ```

3.  **Environment Configuration**

    Copy the example environment file:

    ```bash
    cp .env.example .env
    ```

    Update `DB_CONNECTION` in `.env` if necessary (defaults to `sqlite`).

4.  **Database Setup**

    Create the SQLite database file:

    ```bash
    touch database/database.sqlite
    ```

    Run migrations and seeders:

    ```bash
    php artisan migrate
    php artisan db:seed --class=DatabaseSeeder
    # This runs User, Restaurant, and Admin seeds
    ```

5.  **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

6.  **Create Storage Link**

    Link the public storage folder to access uploaded images:

    ```bash
    php artisan storage:link
    ```

## Running the Application

1.  **Start Background Services** (Optional, if using queued jobs)

    ```bash
    php artisan queue:work
    ```

2.  **Start Development Server**

    Use the handy script defined in `composer.json` or run manually:

    ```bash
    npm run dev
    # AND in a separate terminal
    php artisan serve
    ```

    Access the application at `http://localhost:8000`.

## Testing

Run the automated test suite:

```bash
php artisan test
```

## Useful Commands

-   `php artisan migrate:fresh --seed`: Reset database and re-seed.
-   `php artisan route:list`: List all registered routes.
-   `php artisan make:model X -mcr`: Create Model, Migration, and Controller resource.
