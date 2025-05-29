# 🧰 Laravel Sample Project

This repository is a **sample Laravel project** demonstrating my ability to build web applications. It includes a variety of Laravel features, design patterns, and tools commonly used in real-world systems.

---

## 🚀 Features & Laravel Concepts Demonstrated

### 🧱 Design Patterns
- **Repository Pattern** – for abstraction and clean data access.
- **Builder Pattern** – for composing complex queries and filters.

### 📐 Architecture & Best Practices
- **Custom Request Validation** – using `FormRequest` classes to handle input validation.
- **Custom Validation Rules** – reusable and domain-specific validation logic.
- **Validation Exception Handling** – clean and consistent error responses.
- **REST API Response Handling** – unified API response format (success/error/data).
- **Model Observers** – for separating side effects from model logic.
- **Accessors & Mutators** – for transforming model attributes.
- **Custom Middleware** – for handling the user role.

### 🧩 Laravel Ecosystem & Tools
- **[Filament Admin Panel](https://filamentphp.com/)** – used to build the admin dashboard.
- **[Yajra DataTables](https://github.com/yajra/laravel-datatables)** – for server-side tables and search.
- **[Filament Spatie Media Library Plugin](https://filamentphp.com/plugins/spatie-laravel-media-library)** – media file management inside Filament.
- **[Spatie Laravel Media Library](https://spatie.be/docs/laravel-medialibrary)** – for attaching and managing files on models.
- **[Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)** – roles and permissions management system.
- **[RealRashid SweetAlert](https://github.com/realrashid/sweet-alert)** – beautiful alert modals and toast notifications.
- **[Typhoon Iran Cities](https://github.com/salibhdr/typhoon-iran-cities)** – structured data for all Iranian cities and provinces.
- **Components** – reusable Blade components for cleaner views.
- **Facades** – custom or Laravel-provided for clean service access.
- **Custom Artisan Commands** – e.g., project setup scripts.
- **Email Sending** – using Mailable classes for notifications.

### 🧬 Data Handling
- **Seeders & Factories** – for generating test and demo data.
- **Events & Listeners** – decoupling logic with event-driven architecture.
- **Jobs (Queued)** – handling async tasks like emails or background processing.

---

## 📦 API Design

The project includes a **RESTful API** built with:
- Authentication using `Laravel Sanctum`
- JSON responses with proper status codes

---

## 🛠️ Admin Panel

The admin panel is built with **Filament**, supporting:
- Dynamic access control
- Custom login logic
- Role-based panel access

---

## ✅ Requirements

- PHP >= 8.2
- Laravel 12
- Composer
- MySQL

---

## 🧪 Setup Instructions

```bash
git clone https://github.com/masoumeh9977/your-sample-project.git
cd your-sample-project

composer install
cp .env.example .env
php artisan key:generate

**To set up the admin panel**
php artisan filament:install

php artisan app:setup
php artisan serve
