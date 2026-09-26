CREATE DATABASE IF NOT EXISTS railway_db;
USE railway_db;

CREATE TABLE IF NOT EXISTS Passenger (
    Passenger_ID INT PRIMARY KEY,
    Name VARCHAR(30) NOT NULL,
    Age INT,
    Gender VARCHAR(10),
    Phone VARCHAR(10) UNIQUE
);

CREATE TABLE IF NOT EXISTS Train (
    Train_ID INT PRIMARY KEY,
    Train_Name VARCHAR(40) NOT NULL,
    Source VARCHAR(30),
    Destination VARCHAR(30),
    Total_Seats INT
);

CREATE TABLE IF NOT EXISTS Reservation (
    Reservation_ID INT PRIMARY KEY,
    Passenger_ID INT NOT NULL,
    Train_ID INT NOT NULL,
    Journey_Date DATE,
    Seat_No VARCHAR(10),
    Status VARCHAR(15),
    CONSTRAINT fk_passenger FOREIGN KEY (Passenger_ID) REFERENCES Passenger(Passenger_ID),
    CONSTRAINT fk_train FOREIGN KEY (Train_ID) REFERENCES Train(Train_ID)
);

CREATE TABLE IF NOT EXISTS Ticket (
    Ticket_ID INT PRIMARY KEY,
    Reservation_ID INT NOT NULL,
    Fare INT,
    Ticket_Status VARCHAR(15),
    CONSTRAINT fk_reservation FOREIGN KEY (Reservation_ID) REFERENCES Reservation(Reservation_ID)
);

CREATE TABLE IF NOT EXISTS Payment (
    Payment_ID INT PRIMARY KEY,
    Ticket_ID INT NOT NULL,
    Amount INT,
    Payment_Mode VARCHAR(20),
    Payment_Status VARCHAR(15),
    CONSTRAINT fk_ticket FOREIGN KEY (Ticket_ID) REFERENCES Ticket(Ticket_ID)
);

INSERT IGNORE INTO Train VALUES
(201,'Deccan Express','Pune','Mumbai',500),
(202,'Intercity Express','Pune','Nashik',450),
(203,'Rajdhani Express','Mumbai','Delhi',700),
(204,'Sinhagad Express','Pune','Mumbai',600),
(205,'Pragati Express','Pune','Mumbai',550),
(206,'Duronto Express','Mumbai','Nagpur',650),
(207,'Garib Rath','Pune','Delhi',800),
(208,'Maharashtra Express','Kolhapur','Gondia',500),
(209,'Konkan Kanya','Mumbai','Madgaon',550),
(210,'Shatabdi Express','Mumbai','Ahmedabad',600);

INSERT IGNORE INTO Passenger VALUES
(101,'Rahul Patil',21,'Male','9876543210'),
(102,'Sneha Joshi',20,'Female','9876543211'),
(103,'Amit Shah',25,'Male','9876543212');
