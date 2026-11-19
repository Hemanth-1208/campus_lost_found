CAMPUSFIND - SMART CAMPUS LOST & FOUND MANAGEMENT SYSTEM
========================================================

TECHNOLOGIES
- HTML, CSS, JavaScript
- PHP 8+
- MySQL / MariaDB
- XAMPP

PROJECT STRUCTURE
- index.php, login.php, register.php, logout.php
- admin/       Admin dashboard and management pages
- student/     Student dashboard, reports, browsing and claims
- includes/    Shared header, footer and authentication helpers
- config/      Database connection
- assets/      CSS and JavaScript
- database/    Place your database SQL export here
- uploads/     Created automatically when an item image is uploaded

INSTALLATION (WINDOWS + XAMPP)
1. Install and open XAMPP.
2. Start Apache and MySQL.
3. Copy the CampusFind folder into C:\xampp\htdocs\
4. Open http://localhost/phpmyadmin and create a database named:
   smart_campus_lost_found
5. Import your project database SQL file into that database.
6. Check config/database.php for your MySQL credentials.
7. Open http://localhost/CampusFind/

DATABASE NOTE
The uploaded source files did not include the database SQL/schema export.
The database folder is therefore empty. The application expects tables and
columns for users, items and claims. Import the matching SQL file from your
original project before running the application.

CREATE AN ADMIN ACCOUNT
1. Register a normal account through the website.
2. In phpMyAdmin, select smart_campus_lost_found and open the SQL tab.
3. Run this query, replacing the email with the account you registered:
   UPDATE users SET role='admin' WHERE email='admin@yourcollege.edu';
4. Log out and sign in again. The account will open the admin dashboard.

DEFAULT DATABASE CONFIGURATION
host = localhost
database = smart_campus_lost_found
username = root
password = (blank)

FEATURES IN THE UPLOADED SOURCE
- Student registration and login
- Password hashing and session-based role checks
- Report lost and found items
- Optional image uploads with MIME and size validation
- Browse/search/filter reports
- Submit and track ownership claims
- Admin dashboard
- Admin item status management
- Admin claim approval/rejection
- Admin student account activation/deactivation

IMPORTANT
Use this as a local academic project and test with sample data. For real
campus deployment, add HTTPS, email verification, rate limiting, audit logs,
backups, stronger moderation and privacy policies. Grant admin access only
through a trusted database administrator.

\nUPDATED CLAIM FORM (IMPORTANT)
1. Open phpMyAdmin and select the smart_campus_lost_found database.
2. Open the Import tab and run database/update_claims_form.sql (or paste its SQL into the SQL tab).
3. The item claim form now collects the claimant's name, class/section, handover location, and an owner-only item description.
4. Students can see these details in My Claims, and admins can review them in Manage Claims.
