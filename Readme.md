# LMS PHP Application Setup Guide

Follow these steps to set up and run the LMS PHP application:

## Prerequisites

- PHP (>=7.2)
- MySQL/MariaDB
- Web server (e.g., Apache, XAMPP)
- Composer (if dependencies are managed)

## Installation Steps

1. **Clone or Download the Project**
    - Place the project files in your web server's root directory (e.g., `htdocs` for XAMPP).

2. **Import the Database**
    - Open phpMyAdmin or use the MySQL command line.
    - Create a new database named `lmsdb`.
    - Import the `lmsdb.sql` file into the `lmsdb` database.

3. **Configure Database Connection**
    - Open the `env.php` file.
    - Update the database credentials (host, username, password, database name) as needed.

    ```php
    <?php
    return [
         'host' => 'localhost',
         'username' => 'your_db_username',
         'password' => 'your_db_password',
         'database' => 'lmsdb'
    ];
    ```

4. **Install Dependencies (If Any)**
    - If the project uses Composer, run:
      ```
      composer install
      ```

5. **Run the Application**
    - Start your web server (e.g., XAMPP).
    - Access the application in your browser at:  
      `http://localhost/lms/`

## Troubleshooting

- Ensure PHP and MySQL services are running.
- Check file permissions if you encounter errors.
- Review `env.php` for correct database credentials.

---

**You're ready to use the LMS application!**