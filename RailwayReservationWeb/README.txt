RAILWAY RESERVATION MANAGEMENT SYSTEM
Web + Java + JDBC + MySQL sample

TECHNOLOGY
- Frontend: HTML, CSS, JavaScript
- Backend: Java Servlet
- Database: MySQL
- Database connectivity: JDBC
- Server: Apache Tomcat 10.1+
- Build: Maven

STEP 1 - INSTALL
Install JDK 17, MySQL Server/MySQL Workbench, Apache Tomcat 10.1+, and Maven.

STEP 2 - DATABASE
Open MySQL Workbench and run:
src/main/resources/schema.sql
This creates railway_db and Passenger, Train, Reservation, Ticket and Payment tables.

STEP 3 - PASSWORD
Open:
src/main/java/com/railway/DBConnection.java
Replace YOUR_MYSQL_PASSWORD with your MySQL root password.
If your username is not root, change USER too.

STEP 4 - RUN
Open a terminal in the project folder and run:
mvn clean package
The WAR file will be created in target/railway-reservation.war

STEP 5 - TOMCAT
Copy target/railway-reservation.war into Tomcat's webapps folder.
Start Tomcat.
Open:
http://localhost:8080/railway-reservation/

STEP 6 - TEST
Enter a new Passenger ID, name, age, gender and 10-digit phone number.
Click Save Passenger.
Then run in MySQL:
USE railway_db;
SELECT * FROM Passenger;
The new web form record should appear in the database.

IMPORTANT
Do not use an existing Passenger_ID or Phone because they are PRIMARY KEY/UNIQUE fields.
This sample saves Passenger data. Reservation/Ticket/Payment pages can be added using the same JDBC pattern.
