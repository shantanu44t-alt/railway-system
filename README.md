# RailYatri - Railway Reservation Project

A simple PHP + MySQL/MariaDB railway reservation demo based on the original uploaded project.

## Technologies
- PHP 8+
- MySQL / MariaDB
- HTML5
- CSS3
- XAMPP (for local development)
- GitHub (source-code hosting)

## Project files

- `index.php` - Displays trains from the RDBMS and provides the booking form.
- `book.php` - Validates the form, creates a passenger record, saves the booking, and displays the ticket.
- `railway_db.sql` - Creates the `railway_db` database and its tables/data.
- `.gitignore` - Prevents local/server files from being uploaded.

## Run locally with XAMPP

1. Install XAMPP.
2. Start **Apache** and **MySQL**.
3. Copy this folder to:
   `C:\xampp\htdocs\Railway-Reservation`
4. Open phpMyAdmin:
   `http://localhost/phpmyadmin/`
5. Import `railway_db.sql`.
6. Open:
   `http://localhost/Railway-Reservation/`

The PHP files use:
- Host: `localhost`
- User: `root`
- Password: empty
- Database: `railway_db`

If your MySQL root password is different, update the connection line in `index.php` and `book.php`.

## Important GitHub note

GitHub stores the project source code, but GitHub Pages does **not** execute PHP and does **not** provide a MySQL database.

To make the public website actually run, deploy the PHP files to a PHP-capable hosting service and create/import the MySQL database there. Do not upload database passwords or production credentials to a public GitHub repository.

## Test booking

Select a train, enter a passenger name, choose a future date, and click **Book Now**.

The booking is stored in:
`railway_db -> bookings`

The passenger name is stored in:
`railway_db -> users`
