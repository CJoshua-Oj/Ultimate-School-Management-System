# Ultimate-School-Management-System
The Ultimate School Management System is a PHP-based web application designed to manage school operations, including students, teachers, classes, attendance, examinations, fees, and academic activities.

# Features

Student management

Teacher management

Parent management

Classes and subjects

Attendance management

Examinations and results

Fees and payments

Assignments and study materials

Library management

School events and announcements

User and system settings

Admin dashboard

# Requirements
- PHP 8.3
- MySQL 5.7+/MariaDB 10
- Apache/Nginx
- PHP extensions: mysqli, session

Installation:
1. Create a MySQL database.
2. Import `database/install.sql` using phpMyAdmin or the MySQL client.
3. Edit `config/config.php` or set `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS`.
4. Point your web server document root to `public/`.
5. Open `public/` in your browser.
6. Log in with an account present in the imported database.

# Structure
- `public/` — executable PHP pages and HTML markup
- `includes/` — native PHP bootstrap/layout helpers
- `config/` — database/application configuration
- `assets/css/` — CSS
- `assets/js/` — JavaScript
- `database/` — original database schema/data
- `uploads/` — user-uploaded assets

