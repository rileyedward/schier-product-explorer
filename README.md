# Schier Product Explorer

A web application for exploring, searching, and managing Schier products. This tool provides an intuitive interface for users to interact with the Schier product catalog.

## Overview

### What is Schier Product Explorer?

Schier Product Explorer is a Laravel and Vue.js based application designed to help users browse, search, and manage Schier products. It integrates with the Schier Products API to provide up-to-date product information and allows users to maintain a personalized list of favorite products for quick access.

### Key Features

- **Product Search**: Easily search for products by name, short name, or part number. The application keeps track of your recent searches for quick access to frequently searched items.
- **Product Favorites**: Mark products as favorites for quick access. The favorites view allows you to see all your bookmarked products in one place.
- **Product Syncing**: Synchronize the local product database with the latest data from the Schier API to ensure you always have the most up-to-date product information.

## Getting Started

### Prerequisites

Ensure you have the following prerequisites installed on your system. You can verify each installation by running the provided commands in your terminal.

1. **PHP** is required for the application. Check if PHP is installed by running:

   ```bash
   php --version
   ```

2. **Composer** is necessary for managing PHP dependencies. Verify its installation with:

   ```bash
   composer --version
   ```

3. **Docker** is used for containerization. Confirm Docker is installed by running:

   ```bash
   docker --version
   ```

4. **Node** and **NPM** (Node Package Manager) are needed for managing frontend dependencies. Check their installations with:

   ```bash
   node --version
   npm --version
   ```

### Installation

1. Duplicate the example environment file and configure it with your settings:

   ```bash
   cp .env.example .env
   ```

    > Note: The most important of the environment variables to include being the `SCHIER_API_KEY`

2. Install PHP and JavaScript dependencies:

   ```bash
   composer install
   npm install
   ```

3. Generate a new PHP application key:

   ```bash
   php artisan key:generate
   ```

4. Use Sail to build and start the application:

   ```bash
   ./vendor/bin/sail up -d
   ```

5. Apply database migrations:

   ```bash
   sail artisan migrate
   ```

6. Seed the database with test data:

   ```bash
    sail artisan db:seed
   ```

7. Compile assets and run the Vue frontend:

   ```bash
   npm run dev
   ```
