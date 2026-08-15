# Student Complaint Portal — Full Laravel Project

A complete, ready-to-run Laravel 10 application. This is the real Laravel
framework skeleton (from laravel/laravel) with all the Student Complaint
Portal features already merged in — you do NOT need to run
`composer create-project` or manually copy any files.

## What's included
- Student registration/login, admin login (shared login form, role-based redirect)
- Complaint submission: category, title, description, priority, optional file
  attachment (jpg/png/pdf, max 5MB), optional anonymous submission
- Unique complaint tracking ID (e.g. `CMP-2026-4F91A3`)
- Student "My Complaints" list + detail page with full status timeline
- Public "Track Complaint" page (works for anonymous complaints too)
- Student can edit their own complaint while still Pending
- Admin dashboard: totals, breakdown by category, average resolution time
- Admin complaint list: filter by status/category/date/search + pagination
- Admin: update status (Pending/In Progress/Resolved/Rejected), remarks,
  rejection reason, assign to an admin/officer, delete invalid complaints
- Role-based access control (`admin` middleware) protecting all /admin routes
- Full status-change audit trail (`complaint_status_logs` table)
- Bootstrap 5 responsive UI, purple theme

## Requirements
- PHP 8.1+
- Composer 2.x
- MySQL 8.0 (or MariaDB 10.6+) — e.g. via XAMPP / Laragon

## Setup (from a terminal inside this folder)

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Create the database (via phpMyAdmin, or):
```bash
mysql -u root -e "CREATE DATABASE scp_db CHARACTER SET utf8mb4;"
```

Check `.env` — it's pre-filled with `DB_DATABASE=scp_db`, `DB_USERNAME=root`,
`DB_PASSWORD=` (blank, XAMPP default). Edit `DB_PASSWORD` if your MySQL root
user has one set.

```bash
php artisan storage:link
php artisan migrate
php artisan db:seed
php artisan serve
```

Visit **http://localhost:8000**

`db:seed` creates a default admin account:
- **Email:** admin@iub.edu.pk
- **Password:** Admin@123

⚠️ Change this password after your first login.

## Notes for your SDD / demo
- Backend: Laravel 10 (MVC) · Database: MySQL · Frontend: Blade + Bootstrap 5 + custom CSS
- Every functional requirement from your SRS is covered by a specific
  controller action — see the comments in the controller files under
  `app/Http/Controllers`.
- Admin RBAC is enforced in `app/Http/Middleware/IsAdmin.php`, registered
  as the `admin` alias in `app/Http/Kernel.php`.#deploy on Railway
