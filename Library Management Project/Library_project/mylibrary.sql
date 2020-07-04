-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2020 at 10:20 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mylibrary`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`, `email`, `contact`) VALUES
('1', 'Hamid', '123456', 'mr.hamid@gmail.com', '12345678'),
('2', 'Nobonita', '111111', 'nobonita@gmail.com', '012345678'),
('3', 'X', '222222', 'samiarahman@gmail.com', '133446557');

-- --------------------------------------------------------

--
-- Table structure for table `appr_req`
--

CREATE TABLE `appr_req` (
  `sid` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appr_req`
--

INSERT INTO `appr_req` (`sid`, `name`, `email`, `phone`, `password`) VALUES
('17BCL0265', 'Nimba', 'jdjd@gmail.com', '98767890', 'rfvbgtyhn'),
('18BCE2479', 'Ram', 'dgdhd@gmail.com', '4537289262', '12345'),
('18BCE3454', 'Shekhar', 'adgdhd@gmail.com', '5678876545', 'qwertyui'),
('18BCL0275', 'Sagar Das', 'bkkw@gmail.com', '5678876545', 'wesdx'),
('19BCE2477', 'Hari Mohan', 'hari@gmail.com', '3794834989', 'qazwsx');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bid` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `authors` varchar(100) NOT NULL,
  `edition` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `checkout` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bid`, `name`, `authors`, `edition`, `quantity`, `department`, `checkout`) VALUES
('1', 'Principal of electronics', 'V.K. Mehta, Rohit Mehta', '3rd', 0, 'EEE', 1),
('10', 'Advance Mathematics', 'XYZ', '5th', 5, 'Mathematics', 0),
('11', 'Basic Maths', 'ram', '4th', 5, 'Mathematics', 0),
('2', 'The Complete Reference C++', 'Herbert Schildt', '4th', 4, 'CSE', 0),
('23', 'Psychology', 'pratyasha', '4th', 4, 'science', 0),
('3', 'Data Structure', 'Seymour Lipschutz', '4th', 0, 'ECE', 3),
('4', 'Mathematics', 'xyz', '3rd', 4, 'Maths', 1),
('5', 'Science', 'abcd', '2nd', 2, 'Science', 1),
('6', 'Modern Physics', 'Arther Byser', '6th', 5, 'Science', 2),
('7', 'Internet And Web Programming', 'xyz', '8th', 0, 'Web Programming', 1),
('8', 'Advance', 'xyz', '4th', 8, 'Misc', 0),
('9', 'advance', 'xyz', '6th', 8, 'Misc', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fine`
--

CREATE TABLE `fine` (
  `username` varchar(100) NOT NULL,
  `fine` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fine`
--

INSERT INTO `fine` (`username`, `fine`) VALUES
('18BCE2481', 84),
('18BCE2482', 6),
('KAJAL', 0);

-- --------------------------------------------------------

--
-- Table structure for table `issue_book`
--

CREATE TABLE `issue_book` (
  `sid` varchar(100) NOT NULL,
  `bid` int(100) NOT NULL,
  `issue` varchar(100) NOT NULL,
  `return` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `issue_book`
--

INSERT INTO `issue_book` (`sid`, `bid`, `issue`, `return`) VALUES
('18BCE2478', 7, '2020-04-26', '2020-05-11'),
('18BCE2481', 3, '2020-04-07', '2020-05-07'),
('18BCE2481', 6, '2020-04-07', '2020-04-21'),
('18BCE2482', 1, '2020-04-26', '2020-05-26'),
('18BVFG256', 4, '2020-05-16', '2020-05-31'),
('18BVFG256', 5, '2020-05-16', '2020-05-31');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `pp` varchar(200) NOT NULL DEFAULT 'uploaded/p.jpg',
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`pp`, `id`, `name`, `email`, `phone`, `password`) VALUES
('uploaded/p.jpg', '18BCB0163', 'Pratyasha', 'ajsjj@mail.com', '7988999897', '12345678'),
('uploaded/cs3.jpg', '18BCE2481', 'Dhananjay Kapar', 'worldseeker4@gmail.com', '998654567', '1234qwer'),
('uploaded/p.jpg', '18BCE2482', 'Saurav', 'ygdygdi@gmail.com', '0998654333', 'qwertyui'),
('uploaded/p.jpg', '18BCE2489', 'Shyam', 'fhfdgdhd@gmail.com', '6878705537', 'rtyuio'),
('uploaded/p.jpg', '18BCL0264', 'Abhishek singh', 'w444@gmail.com', '0998654333', '12345678'),
('uploaded/Thanos with time stone.jpeg', '18BVFG256', 'Suman kapar', 'kjejkj@gmail.com', '2565654565', 'suman1234'),
('uploaded/1.jpg', 'KAJAL', 'kajal kumari', 'adgdhd@gmail.com', '2345678998', 'qwertyuiop');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appr_req`
--
ALTER TABLE `appr_req`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `issue_book`
--
ALTER TABLE `issue_book`
  ADD PRIMARY KEY (`sid`,`bid`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
