# Ecommerce App (Laravel)

## What is this application?

This is a **Laravel 12** learning project built with a **modular structure** ([nwidart/laravel-modules](https://github.com/nwidart/laravel-modules)). It models a small **e-commerce style** domain: users with roles (admin, customer, supplier), **categories and products** with images, a **shopping cart**, and modules for **orders** and **payments** as the feature set grows.

**Functionality at a glance**

- Browse and manage **product catalog** (categories, products, product images).
- **Customers** can use a **cart** tied to their account.
- **Suppliers** are linked to products they supply; **admins** can manage catalog content depending on how routes and policies are wired in your branch.
- **Orders** and **payments** live in separate modules for clear boundaries; seed data focuses on users, catalog, and cart so you can run and explore the app locally.

The goal is to practice **database design**, **relationships**, and **clean module boundaries** in a real Laravel app—not a production storefront.

---

## Local setup (after cloning)

1. **Copy environment file**  
   Copy `.env.example` and rename it to `.env`.

2. **Install dependencies**

   ```bash
   composer install && npm install
   ```

3. **Application key**

   ```bash
   php artisan key:generate
   ```

4. **Storage link** (for uploaded or seeded files served under `storage/`)

   ```bash
   php artisan storage:link
   ```

5. **Database**

   ```bash
   php artisan migrate --seed
   ```

   `--seed` is optional: omit it if you do not want demo users, categories, products, and cart data. Use it if you want sample data for browsing the app.

6. **Run the app**

   ```bash
   php artisan serve && npm run dev
   ```

That is all required for the application.

---

## Requirements

- PHP 8.2+
- [Composer](https://getcomposer.org/)
- Node.js and npm (for the Vite frontend toolchain)

The default `.env.example` uses **SQLite**; ensure `database/database.sqlite` exists if you keep that configuration, or configure MySQL/PostgreSQL in `.env` instead.
