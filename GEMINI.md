# Luminara Transaksi - Project Context

## Project Overview
**Luminara Transaksi** is a robust backend microservice and booking management system designed for **Luminara Photobooth**. It serves two primary functions:
1.  **Payment Service**: Acts as a secure bridge between the local offline-first Flutter application and the **Midtrans Payment Gateway**, facilitating QRIS, VA, and E-Wallet payments within a LAN environment.
2.  **Booking System**: A web-based booking platform for customers to check availability and book photobooth services, complete with an admin dashboard for management.
3.  **Invoice System**: Automated and manual invoice generation, management, and printing for client billing.

## Tech Stack
*   **Backend Framework**: Laravel 12 (PHP 8.2+)
*   **Database**: MySQL / MariaDB
*   **Frontend**: Blade Templates + Vite + Tailwind CSS v4
*   **Payment Gateway**: Midtrans (Snap API)
*   **Environment**: DDEV (Docker-based) or Native PHP
*   **API Authentication**: Laravel Sanctum

## Database Schema
The database has evolved to support a multi-division business model (`photobooth` & `visual`).

### Core Tables
1.  **Users (`users`)**
    *   `division`: Role/Access control (`super_admin`, `photobooth`, `visual`).
2.  **Packages (`packages` & `package_prices`)**
    *   `business_unit`: Links package to specific division.
    *   `type`: Unique identifier (e.g., `pb_unlimited`).
    *   `base_price`: Starting price.
    *   `prices` (Relation): One-to-many pricing tiers based on `duration_hours`.
3.  **Bookings (`bookings`)**
    *   `business_unit`: Inherited from the selected package.
    *   `payment_proof`: Path to uploaded transfer proof.
    *   `dp_amount`: Recorded down payment.
    *   `event_maps_link`: Google Maps URL for the event.
4.  **Invoices (`invoices` & `invoice_items`)**
    *   Linked to `bookings` (optional for manual invoices).
    *   Comprehensive financial tracking (`subtotal`, `tax`, `discount`, `grand_total`, `balance_due`).
    *   `status`: `UNPAID`, `PARTIAL`, `PAID`.
5.  **Galleries (`galleries`)**
    *   `business_unit`: Segregates images by division.
    *   `is_featured`: Flags images for landing page hero sections.

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
*   **`app/Models/`**: Core data models (`Booking`, `Transaction`, `BlockedDate`, `User`, `Invoice`, `InvoiceItem`, `Gallery`, `Package`).
*   **`app/Http/Controllers/`**:
    *   `BookingController.php`: Handles public booking flows and admin dashboard logic.
    *   `Admin/`: Specialized admin controllers (`InvoiceController`, `GalleryController`, `PackageController`, `UserController`).
    *   `Api/PaymentController.php`: Handles API transaction logic.
    *   `AuthController.php`: Admin authentication.
*   **`routes/`**:
    *   `web.php`: Public booking pages, Admin dashboard, Invoices, Auth.
    *   `api.php`: Transaction creation and status syncing (Midtrans integration).
*   **`resources/views/`**: Blade templates for the frontend.
    *   `booking.blade.php`: Public booking form.
    *   `admin/`: Admin dashboard and management views.
        *   `invoices/`: Invoice list, create, edit, and print views.
        *   `bookings/`: Booking management.
        *   `calendar/`: Availability calendar.
*   **`database/migrations/`**: Database schema definitions.

## Key Features & Conventions
*   **Multi-Division Architecture**:
    *   **Data Segregation**: Resources (Bookings, Packages, Galleries) are tagged with a `business_unit` ('photobooth' or 'visual').
    *   **Access Control**: `super_admin` can see all data. Division-specific users (e.g., 'visual') are restricted to their unit's data.
    *   **Frontend Routing**: Public landing pages are separated (e.g., `/` for Photobooth, `/visual` for Visual services).
*   **Payment Integration**: Uses `midtrans/midtrans-php`. Supports "Smart Synchronization" to update transaction status from Midtrans Cloud to the local DB via the `/api/transaction/{orderId}/sync` endpoint.
*   **Booking Logic**:
    *   Public users can view pricing and book dates.
    *   Admins can block/unblock dates and manage booking statuses.
    *   Availability check is implemented to prevent double booking.
    *   **Auto-Invoice**: New bookings automatically generate a corresponding invoice.
    *   **Payment Status Feedback**: The booking form provides real-time visual feedback (checkmark and text) indicating whether the payment is a Down Payment (DP) or Full Payment (Lunas).
    *   **AJAX Workflow**: Public booking form uses `fetch` (AJAX) for submission to provide a seamless UX with loading states and success popups.
*   **Invoice Management**:
    *   **CRUD**: Create (manual/auto), Read (List/Detail), Update, Delete.
    *   **Printing**: Direct "silent" printing via hidden iframe or standard window print. Supports PDF generation context.
    *   **Calculations**: Auto-calculation of subtotals, discounts (fixed/percent), tax, and balance due (DP handling).
*   **WhatsApp Integration**: 
    *   Booking details are forwarded to WhatsApp. 
    *   Messages dynamically reflect the payment status (**DP** vs **Lunas**) and the specific amount paid.
*   **Styling**: Uses Tailwind CSS v4 managed by Vite.
*   **UX Components**: **SweetAlert2** is integrated throughout the system for form submission feedback, success notifications, and critical confirmations (e.g., deletions).
*   **API Design**: RESTful API design for transaction management, primarily serving the Flutter mobile client.
