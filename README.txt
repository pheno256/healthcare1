==============================
HealthCare Appointment System
==============================

✔ Version: Full Admin + Secure Login + CSV Export + Calendar
✔ Deployment Target: cPanel / Shared Hosting

-----------------------------------------
🌐 How to Deploy (cPanel / Hostinger / etc)
-----------------------------------------

1. Upload Files:
   - Go to cPanel > File Manager
   - Navigate to: public_html/
   - Upload and extract ALL contents of this project ZIP

2. Set Up the Database:
   - Go to cPanel > MySQL® Databases
   - Create a new database (e.g. healthcare)
   - Create a new user and assign to the DB with ALL PRIVILEGES

3. Import SQL Data:
   - Go to cPanel > phpMyAdmin
   - Select your new database
   - Click Import > upload: sql/healthcare.sql

4. Configure Database Connection:
   - Edit: includes/db.php
   - Update the credentials:
       $db = 'your_db_name';
       $user = 'your_db_user';
       $pass = 'your_db_password';

5. Launch Your Website:
   https://yourdomain.com/welcome.html

------------------------------------------
🔐 Admin Access
------------------------------------------
- Login Page: admin_login.php
- Email: admin@example.com
- Password: admin123

You can change admin login credentials directly in the database.

------------------------------------------
📂 Writable Folder
------------------------------------------
- /uploads should be writable (for profile photo upload)
- Use permissions 755 or 775

------------------------------------------
📤 CSV Export
------------------------------------------
Use links like:
- export_csv.php?type=users
- export_csv.php?type=doctors
- export_csv.php?type=appointments

------------------------------------------
📅 Appointment Calendar
------------------------------------------
Visit calendar.html to view all appointments in a visual monthly layout.

------------------------------------------
📧 Email Verification (Optional)
------------------------------------------
- send_verification_email.php is preconfigured to work with PHPMailer
- Requires setting SMTP credentials and enabling mail extensions
