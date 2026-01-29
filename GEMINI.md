# Luminara Transaksi - Project Context

## Project Overview
**Luminara Transaksi** is a robust backend microservice and booking management system designed for **Luminara Photobooth**. It serves two primary functions:
1.  **Payment Service**: Acts as a secure bridge between the local offline-first Flutter application and the **Midtrans Payment Gateway**, facilitating QRIS, VA, and E-Wallet payments within a LAN environment.
2.  **Booking System**: A web-based booking platform for customers to check availability and book photobooth services, complete with an admin dashboard for management.

## Tech Stack
*   **Backend Framework**: Laravel 12 (PHP 8.2+)
*   **Database**: MySQL / MariaDB
*   **Frontend**: Blade Templates + Vite + Tailwind CSS v4
*   **Payment Gateway**: Midtrans (Snap API)
*   **Environment**: DDEV (Docker-based) or Native PHP
*   **API Authentication**: Laravel Sanctum

## Getting Started

### Prerequisites
*   PHP 8.2+
*   Composer
*   Node.js & NPM
*   DDEV (Recommended)

### Installation (DDEV - Recommended)
1.  Start the DDEV environment:
    ```bash
    ddev start
    ```
2.  Install dependencies and setup the project:
    ```bash
    ddev composer setup
    ```
    *This script installs Composer dependencies, sets up `.env`, generates the app key, runs migrations, installs NPM packages, and builds assets.*

### Installation (Native)
1.  Install PHP dependencies:
    ```bash
    composer install
    ```
2.  Setup environment:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
3.  Configure database in `.env`.
4.  Run migrations:
    ```bash
    php artisan migrate
    ```
5.  Install and build frontend assets:
    ```bash
    npm install && npm run build
    ```

## Development Workflow

### Running the Application
*   **DDEV**:
    ```bash
    ddev composer dev
    ```
    *Runs `php artisan serve`, queue listener, pail (logs), and `npm run dev` concurrently.*

*   **Native**:
    ```bash
    composer dev
    ```
    *Same as DDEV but runs on the host machine.*

### Running Tests
```bash
composer test
```
*Clears config and runs PHPUnit tests.*

## Project Structure
*   **`app/Models/`**: Core data models (`Booking`, `Transaction`, `BlockedDate`, `User`).
*   **`app/Http/Controllers/`**:
    *   `BookingController.php`: Handles public booking flows and admin management.
    *   `Api/PaymentController.php`: Handles API transaction logic.
    *   `AuthController.php`: Admin authentication.
*   **`routes/`**:
    *   `web.php`: Public booking pages, Admin dashboard, Auth.
    *   `api.php`: Transaction creation and status syncing (Midtrans integration).
*   **`resources/views/`**: Blade templates for the frontend.
    *   `booking.blade.php`: Public booking form.
    *   `admin/`: Admin dashboard and management views.
*   **`database/migrations/`**: Database schema definitions.

## Key Features & Conventions
*   **Payment Integration**: Uses `midtrans/midtrans-php`. Supports "Smart Synchronization" to update transaction status from Midtrans Cloud to the local DB via the `/api/transaction/{orderId}/sync` endpoint.
*   **Booking Logic**:
    *   Public users can view pricing and book dates.
    *   Admins can block/unblock dates and manage booking statuses.
    *   Availability check is implemented to prevent double booking.
*   **Styling**: Uses Tailwind CSS v4 managed by Vite.
*   **API Design**: RESTful API design for transaction management, primarily serving the Flutter mobile client.
