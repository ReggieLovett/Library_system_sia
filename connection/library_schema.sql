CREATE DATABASE IF NOT EXISTS `library`;
USE `library`;

CREATE TABLE IF NOT EXISTS `borrow_transactions` (
  `trans_id` INT NOT NULL AUTO_INCREMENT,
  `book_burrowed` VARCHAR(255) NOT NULL,
  `date_burrowed` DATE NOT NULL,
  `status` VARCHAR(50) NOT NULL,
  `librarian_incharge` VARCHAR(255) NOT NULL,
  `student_id` INT NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `students` (
  `student_id` INT NOT NULL AUTO_INCREMENT,
  `student_name` VARCHAR(255) NOT NULL,
  `course` VARCHAR(255) DEFAULT NULL,
  `year_level` VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
