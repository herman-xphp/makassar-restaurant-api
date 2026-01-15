# Makassar Restaurant API

Backend API for the Makassar Restaurant Finder application. This project provides a robust RESTful API to manage restaurant data, perform location-based searches, and generate recommendations based on user proximity.

## 🧠 Algorithm & Logic

This project utilizes a **Location-Based Recommendation Engine** powered by the **Haversine Formula**.

### How it works:

1.  **Distance Calculation**:
    The core logic resides in the `RestaurantRepository`. We calculate the spherical distance between the user's coordinates (Latitude/Longitude) and each restaurant in the database using a raw SQL query implementing the Haversine formula:

    ```sql
    (6371 * acos(cos(radians($userLat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($userLon)) + sin(radians($userLat)) * sin(radians(latitude))))
    ```

    _6371 is the Earth's radius in kilometers._

2.  **Smart Filtering & Ranking**:

    -   **Radius Filter**: Users can specify a radius (e.g., 5km) to find restaurants only within that range.
    -   **Search**: A flexible search allowing users to find restaurants by name, description, address, or cuisine type.
    -   **Sorting**:
        -   If User Location is provided: Results are sorted by **Distance (Nearest first)**.
        -   Default: Results are sorted by **Rating (Highest first)**.

3.  **Efficiency**:
    -   Implements **Repository & Service Pattern** for clean separation of concerns.
    -   Supports **Pagination** (limit/offset) to handle large datasets efficiently.

---

## 🛠 Tech Stack

-   **Language**: PHP 8.x
-   **Framework**: Laravel
-   **Database**: MySQL / MariaDB
-   **Architecture**: REST API with Repository-Service Pattern

---

## 📂 Folder Structure

Key directories in the project:

```
app/
├── Http/Controllers/Api/   # API Controllers (Entry point for requests)
├── Interfaces/             # Contracts for Repositories and Services
├── Models/                 # Eloquent Models (Database representation)
├── Repositories/           # Data Access Layer (Database queries & Logic)
└── Services/               # Business Logic Layer (Data transformation)
routes/
└── api.php                 # API Route definitions
```

---

## 🚀 Installation

### Prerequisites

-   PHP >= 8.1
-   Composer
-   MySQL

### Steps

1.  **Clone the repository**
2.  **Install dependencies**:
    ```bash
    composer install
    ```
3.  **Environment Setup**:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4.  **Database Configuration**:
    Update the `.env` file with your database credentials:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=makassar_restaurant
    DB_USERNAME=root
    DB_PASSWORD=
    ```
5.  **Run Migrations**:
    ```bash
    php artisan migrate
    ```

---

## 🌐 Running the Project

### Local Development

To run the server locally on your machine:

```bash
php artisan serve
```

Access the API at: `http://localhost:8000`

### Network Access (For Real-Device Testing)

To allow devices on the same Wi-Fi network (like your phone) to access the API:

1.  Find your local IP address (e.g., using `ipconfig` or `ifconfig`). Let's say it is `192.168.1.10`.
2.  Run the server binding to `0.0.0.0`:
    ```bash
    php artisan serve --host=0.0.0.0 --port=8000
    ```
3.  On your mobile device/frontend, connect using your IP:
    `http://192.168.1.10:8000/api/restaurants/recommendations`

---

## 🔗 Main Endpoints

-   `GET /api/restaurants/recommendations`: Get nearest restaurants (requires lat/lon params).
-   `GET /api/restaurants/search`: Search restaurants by keyword.
-   `GET /api/restaurants/{id}`: Get restaurant details.
