-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2024 at 06:16 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expense`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_statement_sp` (IN `_userId` VARCHAR(50) CHARSET utf8, IN `_from` DATE, IN `_to` DATE)   BEGIN
    SET @tbalance = 0;
    SET @expense = 0;
    SET @income = 0;

    IF _from = '0000-00-00' THEN
        CREATE TEMPORARY TABLE tb AS
        SELECT tblexpense.date, tblexpense.user_id,
            IF(type = 'Income', tblexpense.amount, 0) AS Income,
            IF(type = 'Expense', tblexpense.amount, 0) AS Expense,
            IF(type = 'Income', @tbalance := @tbalance + tblexpense.amount,
                @tbalance := @tbalance - tblexpense.amount) AS Balance
        FROM tblexpense
        WHERE tblexpense.user_id = _userId
        ORDER BY tblexpense.date ASC;
        SELECT *FROM tb
        UNION
        SELECT '', '', SUM(Income) AS Income, SUM(Expense) AS Expense, @tbalance AS Balance
        FROM tb;
    ELSE
        CREATE TEMPORARY TABLE tb AS
        SELECT tblexpense.date, tblexpense.user_id,
            IF(type = 'Income', tblexpense.amount, 0) AS Income,
            IF(type = 'Expense', tblexpense.amount, 0) AS Expense,
            IF(type = 'Income', @tbalance := @tbalance + tblexpense.amount,
                @tbalance := @tbalance - tblexpense.amount) AS Balance
        FROM tblexpense
        WHERE tblexpense.user_id = _userId AND tblexpense.date BETWEEN _from AND _to
        ORDER BY tblexpense.date ASC;
        SELECT *FROM tb
        UNION
        SELECT '', '', SUM(Income) AS Icome, SUM(Expense) AS Expense, @tbalance AS Balance
        FROM tb;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `register_expense_sp` (IN `_id` INT, IN `_amount` FLOAT(11,2), IN `_type` VARCHAR(20) CHARSET utf8, IN `_desc` TEXT CHARSET utf8, IN `_userId` VARCHAR(50) CHARSET utf8)   BEGIN

if EXISTS(SELECT *from tblexpense where tblexpense.id = _id)THEN






if(_type='Expense' && (SELECT get_user_balance_fn(_userId)<_amount))THEN
SELECT 'Denied' as Message;
ELSE
UPDATE tblexpense SET tblexpense.amount = _amount, tblexpense.type=_type, tblexpense.description =_desc WHERE tblexpense.id =_id;
SELECT "Updated" as Message;
END IF;





ELSE

if(_type='Expense') THEN

if((SELECT get_user_balance_fn(_userId)<_amount))THEN
SELECT 'Denied' as Message;
ELSE
INSERT INTO tblexpense(tblexpense.amount,tblexpense.type,tblexpense.description, tblexpense.user_id)VALUES(_amount,_type,_desc,_userId);
SELECT 'Registered' as Message;
END IF;

ELSE
INSERT INTO tblexpense(tblexpense.amount,tblexpense.type,tblexpense.description, tblexpense.user_id)VALUES(_amount,_type,_desc,_userId);
SELECT 'Registered' as Message;
END IF;
END IF;

END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `get_user_balance_fn` (`userId` VARCHAR(50) CHARSET utf8) RETURNS FLOAT(11,2)  BEGIN

SET @balance=0.00;

SET @income  = (SELECT SUM(tblexpense.amount)from tblexpense WHERE tblexpense.type='Income' AND tblexpense.user_id=userId);


SET @expense  = (SELECT SUM(tblexpense.amount) from tblexpense WHERE tblexpense.type='Expense' AND tblexpense.user_id=userId);

SET @balance =ifnull(@income,0)-ifnull(@expense,0);

RETURN @balance;


END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblexpense`
--

CREATE TABLE `tblexpense` (
  `id` int(11) NOT NULL,
  `amount` float(11,2) NOT NULL,
  `type` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblexpense`
--

INSERT INTO `tblexpense` (`id`, `amount`, `type`, `description`, `user_id`, `date`) VALUES
(91, 50.00, 'Expense', 'JavaScript Course', 'USR001', '2024-08-24 06:26:16'),
(92, 100.00, 'Expense', 'home rent', 'USR001', '2024-08-23 03:22:27'),
(97, 300.00, 'Expense', 'JavaScript Course', 'USR001', '2024-08-24 06:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Active',
  `image` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `status`, `image`, `date`) VALUES
('USR001', 'suleyman', '44fefb1ff1fbd29abdc7d1683a1ff641', 'Active', 'USR001.png', '2024-09-16 03:44:02'),
('USR002', 'abas beereed', '1984f90f5374be9e408fa654dd393ec4', 'Active', 'USR002.png', '2024-09-16 03:42:12'),
('USR003', 'kaamil ali', 'ca9d2001c6ac82b244e0b8e1554bf26a', 'Active', 'USR003.png', '2024-09-16 03:46:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblexpense`
--
ALTER TABLE `tblexpense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblexpense`
--
ALTER TABLE `tblexpense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
