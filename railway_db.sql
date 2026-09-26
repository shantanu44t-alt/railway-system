-- Railway Reservation Project
-- Database: railway_db
-- Compatible with MySQL / MariaDB

CREATE DATABASE IF NOT EXISTS railway_db;
USE railway_db;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS trains;

CREATE TABLE trains (
    train_id INT NOT NULL,
    train_name VARCHAR(100) DEFAULT NULL,
    source VARCHAR(100) DEFAULT NULL,
    destination VARCHAR(100) DEFAULT NULL,
    seats INT DEFAULT NULL,
    PRIMARY KEY (train_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) DEFAULT NULL,
    email VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE bookings (
    booking_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    train_id INT NOT NULL,
    journey_date DATE NOT NULL,
    PRIMARY KEY (booking_id),
    CONSTRAINT fk_booking_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_booking_train
        FOREIGN KEY (train_id) REFERENCES trains(train_id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO trains (train_id, train_name, source, destination, seats) VALUES
(101, 'Deccan Express', 'Pune', 'Mumbai', 100),
(102, 'Chennai Express', 'Mumbai', 'Chennai', 120),
(103, 'Rajdhani', 'Delhi', 'Mumbai', 80);

SET FOREIGN_KEY_CHECKS = 1;
