# Pusat Data Pemilu 2024

## Overview

This application serves as a comprehensive visualization tool for the Indonesian Pemilu 2024 election data. It is designed to provide a clear, interactive, and modern interface for exploring vote distributions, party statistics, and electoral maps. The system leverages a combination of server-side rendering with Blade for map-intensive visualizations and client-side rendering with React and Inertia.js for dynamic data tables and charts.

The visual design aims for a modern, futuristic aesthetic with animated gradient backgrounds, responsive layouts, and colorful data representations.

## Tech Stack

-   **Backend:** Laravel 12 (PHP 8.2+)
-   **Frontend:** React 18, Inertia.js 2.0, Tailwind CSS 4.0
-   **Database:** MySQL
-   **Charting:** Chart.js with `react-chartjs-2`
-   **Mapping:** Leaflet.js with GeoJSON for boundary overlays
-   **Build Tool:** Vite

## Features

-   **Interactive National Vote Map:** Visualize presidential election vote distribution across all provinces.
-   **Provincial DPRD Map:** View detailed vote data for provincial legislative elections.
-   **Party-Specific Analysis:** Analyze party performance by province and electoral district (Dapil).
-   **Provincial Data Breakdown:** Explore detailed statistics for each province, including a breakdown by Dapil.
-   **DPR RI Candidate Data:** Interactive tables and charts for DPR RI candidate performance (powered by Inertia.js/React).
-   **Wilayah Statistics:** View and tabulate administrative region data, including the number of electoral districts, regencies, sub-districts, villages, polling stations (TPS), and the final voter list (DPT).

## Getting Started

### Prerequisites

-   PHP 8.2+
-   Node.js and npm
-   Composer
-   MySQL Database

### Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/aswandi/dashboard-data-pemilu-2024.git
    cd dashboard-data-pemilu-2024
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Install NPM dependencies:**
    ```bash
    npm install
    ```

4.  **Setup Environment:**
    -   Copy the `.env.example` file to `.env`:
        ```bash
        copy .env.example .env
        ```
    -   Update the database credentials in your `.env` file:
        ```
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=036_laravel12-pusat-data-pemilu-polmark
        DB_USERNAME=root
        DB_PASSWORD=kansas8
        ```

5.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

### Development

To start the development server, which includes the Laravel server, Vite dev server, and queue worker, run:

```bash
composer dev
```

Alternatively, you can start the services manually:
-   **Laravel Server:** `php artisan serve`
-   **Vite Dev Server:** `npm run dev`

### Building for Production

To create a production-ready build of the frontend assets:

```bash
npm run build
```

### Testing and Code Quality

-   **Run Pest/PHPUnit tests:**
    ```bash
    composer test
    ```
-   **Format code with Laravel Pint:**
    ```bash
    ./vendor/bin/pint
    ```

## Application Structure

### Key Routes

-   `/`: Home page displaying Wilayah (administrative region) data.
-   `/peta-suara`: National vote map for the presidential election.
-   `/peta-suara/dprd-prov`: Provincial DPRD election map.
-   `/data-utama/dpr-ri`: DPR RI candidate data visualization (Inertia/React page).
-   `/data-utama/partai`: Party performance analysis page.
-   `/data-utama/provinsi`: Provincial data analysis page.

### Rendering Architecture

This project uses a hybrid rendering approach:
1.  **Blade Templates (`resources/views/`):** Used for pages that are heavy on geographical maps (Leaflet.js), such as `peta-suara-temp.blade.php`. These pages are rendered on the server-side, with client-side interactivity provided by embedded JavaScript.
2.  **Inertia.js + React (`resources/js/Pages/`):** Used for highly interactive, data-driven pages like the DPR RI candidate browser. This allows for a more dynamic, single-page application feel without the complexity of a full SPA.

### Database Interaction

For performance-critical queries on large electoral datasets, the application primarily uses **Laravel's Query Builder** instead of Eloquent ORM. This provides more control over the generated SQL and avoids the overhead of model hydration.

A critical convention to follow in all queries is to **exclude aggregated data rows**:
```php
// Always use this filter when querying vote data
->where('caleg_id', '<>', 333333)
```