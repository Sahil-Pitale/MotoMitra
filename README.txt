MotoMitra Admin Package
======================

Included:
- Admin/ (folder) containing your uploaded files plus helper files:
  - dashboard.php (uploaded or placeholder)
  - login.php (uploaded or placeholder)
  - users.php (uploaded or placeholder)
  - db.php (database connection)
  - logout.php (session logout)
- sql/setup.sql : SQL to create database and tables required by dashboard

Instructions:
1. Place this folder in your webroot (e.g., C:/wamp64/www/MotoMitra/ or /var/www/html/MotoMitra/)
2. Edit Admin/db.php if your DB credentials or DB name differ.
3. Import sql/setup.sql into phpMyAdmin to create tables and sample admin user.
4. Access admin login at: http://localhost/MotoMitra/Admin/login.php
