SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

CREATE DATABASE IF NOT EXISTS `cinema` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cinema`;

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking`
(
    `booking_id`  int(11)  NOT NULL AUTO_INCREMENT,
    `schedule_id` int(11)  NOT NULL,
    `user_id`     int(11)  NOT NULL,
    `booked_date` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`booking_id`),
    KEY `schedule_id` (`schedule_id`),
    KEY `user_id` (`user_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 10
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `canceledbookings`;
CREATE TABLE IF NOT EXISTS `canceledbookings`
(
    `canceled_bookingID` int(11)      NOT NULL AUTO_INCREMENT,
    `c_Email`            varchar(128) NOT NULL,
    `movie`              varchar(128) NOT NULL,
    `room`               varchar(128) NOT NULL,
    `seat`               varchar(5)   NOT NULL,
    `s_date`             date         NOT NULL,
    `s_time`             time         NOT NULL,
    `cancelDate`         datetime DEFAULT current_timestamp(),
    PRIMARY KEY (`canceled_bookingID`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `canceledschedules`;
CREATE TABLE IF NOT EXISTS `canceledschedules`
(
    `cS_id`       int(11)      NOT NULL AUTO_INCREMENT,
    `movieName`   varchar(128) NOT NULL,
    `roomName`    varchar(128) NOT NULL,
    `startDate`   date         NOT NULL,
    `startHours`  time         NOT NULL,
    `cancelDate`  datetime     NOT NULL DEFAULT current_timestamp(),
    `schedule_id` int(255)     NOT NULL,
    PRIMARY KEY (`cS_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `completed_bookings`;
CREATE TABLE IF NOT EXISTS `completed_bookings`
(
    `compB_id`   int(11)      NOT NULL AUTO_INCREMENT,
    `userEmail`  varchar(128) NOT NULL,
    `movieName`  varchar(128) NOT NULL,
    `roomName`   varchar(128) NOT NULL,
    `seatName`   varchar(5)   NOT NULL,
    `startDate`  date         NOT NULL,
    `startHours` time         NOT NULL,
    PRIMARY KEY (`compB_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 28
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `completed_schedule`;
CREATE TABLE IF NOT EXISTS `completed_schedule`
(
    `compS_id`    int(11)      NOT NULL AUTO_INCREMENT,
    `movieName`   varchar(128) NOT NULL,
    `roomName`    varchar(128) NOT NULL,
    `startDate`   date         NOT NULL,
    `startHours`  time         NOT NULL,
    `schedule_id` int(255)     NOT NULL,
    PRIMARY KEY (`compS_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies`
(
    `movie_id`         int(11)      NOT NULL AUTO_INCREMENT,
    `movieName`        varchar(128) NOT NULL,
    `movieImage`       longblob     NOT NULL,
    `movieDescription` mediumtext   NOT NULL,
    PRIMARY KEY (`movie_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 9
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `reservedseats`;
CREATE TABLE IF NOT EXISTS `reservedseats`
(
    `reservedSeat_id` int(11)    NOT NULL AUTO_INCREMENT,
    `booking_id`      int(11)    NOT NULL,
    `seatName`        varchar(5) NOT NULL,
    `seat_id`         int(11)    NOT NULL,
    PRIMARY KEY (`reservedSeat_id`),
    KEY `booking_id` (`booking_id`),
    KEY `seat_id` (`seat_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 60
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms`
(
    `room_id`         int(11)      NOT NULL AUTO_INCREMENT,
    `roomName`        varchar(128) NOT NULL,
    `seat_column`     int(11)      NOT NULL,
    `seat_row`        int(11)      NOT NULL,
    `roomDescription` mediumtext   NOT NULL,
    `room_image`      longblob     NOT NULL,
    PRIMARY KEY (`room_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 9
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule`
(
    `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
    `movie_id`    int(11) NOT NULL,
    `room_id`     int(11) NOT NULL,
    `startDate`   date    NOT NULL,
    `startHours`  time    NOT NULL,
    PRIMARY KEY (`schedule_id`),
    KEY `movie_id` (`movie_id`),
    KEY `room_id` (`room_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 12
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `seats`;
CREATE TABLE IF NOT EXISTS `seats`
(
    `seat_id`    int(255)     NOT NULL AUTO_INCREMENT,
    `seatName`   varchar(5)   NOT NULL,
    `seatStatus` varchar(20)  NOT NULL DEFAULT 'Not booked',
    `roomName`   varchar(128) NOT NULL,
    `startDate`  date         NOT NULL,
    `startHours` time         NOT NULL,
    `movieName`  varchar(128) NOT NULL,
    PRIMARY KEY (`seat_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 2909
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users`
(
    `userID`        int(11)      NOT NULL AUTO_INCREMENT,
    `userFirstName` varchar(128) NOT NULL,
    `userLastName`  varchar(100) NOT NULL,
    `userEmail`     varchar(128) NOT NULL,
    `userName`      varchar(128) NOT NULL,
    `userPassw`     varchar(128) NOT NULL,
    `userPhone`     varchar(100) NOT NULL,
    `role`          varchar(128) DEFAULT 'Customer',
    PRIMARY KEY (`userID`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 6
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

INSERT INTO `users` (`userID`, `userFirstName`, `userLastName`, `userEmail`, `userName`, `userPassw`, `userPhone`,
                     `role`)
VALUES (1, 'Rares Cristian', 'Olteanu', 'rarescolteanu@gmail.com', 'tory',
        '$2y$10$Dwm9HkL/fObzySzV14XUt.iR5pR7iIL.DqLJOFshG6Wht6PlBPZk6', '0748122806', 'Administrator');


ALTER TABLE `booking`
    ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`schedule_id`),
    ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`userID`);

ALTER TABLE `reservedseats`
    ADD CONSTRAINT `reservedseats_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`);

ALTER TABLE `schedule`
    ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`),
    ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);
COMMIT;
