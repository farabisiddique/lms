-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 04:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(10) NOT NULL,
  `books_name` varchar(50) NOT NULL,
  `books_image` varchar(5000) NOT NULL,
  `books_author_name` varchar(50) NOT NULL,
  `books_publication_name` varchar(50) NOT NULL,
  `books_price` float NOT NULL,
  `books_quantity` int(11) NOT NULL,
  `books_stock` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `books_name`, `books_image`, `books_author_name`, `books_publication_name`, `books_price`, `books_quantity`, `books_stock`, `added_at`) VALUES
(17, 'Theory of Computing', 'upload/books/book_68276bb6c3cb2.png', 'McGill', 'Schaum', 123.45, 10, 10, '2025-05-16 16:45:42'),
(19, 'Operating System', 'upload/books/book_68276bb6c3cb2.png', 'McGill', 'Schaum', 123.45, 10, 11, '2025-05-16 16:45:42'),
(20, 'Introduction to Algorithms', 'upload/books/book_68276bb6c3cb2.png', 'Cormen', 'MIT Press', 89.99, 15, 15, '2025-05-17 01:39:34'),
(21, 'Database Systems', 'upload/books/book_68276bb6c3cb3.png', 'Silberschatz', 'McGraw-Hill', 75.5, 10, 10, '2025-05-17 01:39:34'),
(22, 'Artificial Intelligence Basics', 'upload/books/book_68276bb6c3cb4.png', 'Russell', 'Pearson', 120, 12, 12, '2025-05-17 01:39:34'),
(23, 'Computer Networks', 'upload/books/book_68276bb6c3cb5.png', 'Tanenbaum', 'Prentice Hall', 65.25, 8, 8, '2025-05-17 01:39:34'),
(24, 'Data Structures', 'upload/books/book_68276bb6c3cb6.png', 'Weiss', 'Addison-Wesley', 95, 20, 20, '2025-05-17 01:39:34'),
(25, 'Machine Learning', 'upload/books/book_68276bb6c3cb7.png', 'Mitchell', 'McGraw-Hill', 110, 10, 10, '2025-05-17 01:39:34'),
(26, 'Software Engineering', 'upload/books/book_68276bb6c3cb8.png', 'Sommerville', 'Pearson', 85.75, 15, 15, '2025-05-17 01:39:34'),
(27, 'Computer Architecture', 'upload/books/book_68276bb6c3cb9.png', 'Hennessy', 'Morgan Kaufmann', 130, 7, 7, '2025-05-17 01:39:34'),
(28, 'Cybersecurity Fundamentals', 'upload/books/book_68276bb6c3cba.png', 'Stallings', 'Prentice Hall', 99.99, 9, 9, '2025-05-17 01:39:34'),
(29, 'Cloud Computing', 'upload/books/book_68276bb6c3cbc.png', 'Buyya', 'Wiley', 115, 13, 13, '2025-05-17 01:39:34'),
(30, 'Big Data Analytics', 'upload/books/book_68276bb6c3cbd.png', 'Hadoop', 'Apress', 80.5, 10, 10, '2025-05-17 01:39:34'),
(31, 'Blockchain Basics', 'upload/books/book_68276bb6c3cbe.png', 'Drescher', 'Packt', 60, 8, 8, '2025-05-17 01:39:34'),
(32, 'Quantum Computing', 'upload/books/book_68276bb6c3cbf.png', 'Nielsen', 'Cambridge Press', 140, 5, 5, '2025-05-17 01:39:34'),
(33, 'Parallel Computing', 'upload/books/book_68276bb6c3cc0.png', 'Quinn', 'McGraw-Hill', 92.25, 12, 12, '2025-05-17 01:39:34'),
(34, 'Embedded Systems', 'upload/books/book_68276bb6c3cc1.png', 'Kamal', 'Pearson', 78, 10, 10, '2025-05-17 01:39:34'),
(35, 'Computer Graphics', 'upload/books/book_68276bb6c3cc2.png', 'Foley', 'Addison-Wesley', 105, 15, 15, '2025-05-17 01:39:34'),
(36, 'Robotics Engineering', 'upload/books/book_68276bb6c3cc3.png', 'Siciliano', 'Springer', 125, 7, 7, '2025-05-17 01:39:34'),
(37, 'Game Development', 'upload/books/book_68276bb6c3cc4.png', 'Gregory', 'A K Peters', 88, 9, 9, '2025-05-17 01:39:34'),
(38, 'Mobile Computing', 'upload/books/book_68276bb6c3cc5.png', 'Adelstein', 'Addison-Wesley', 72.5, 11, 11, '2025-05-17 01:39:34'),
(39, 'Natural Language Processing', 'upload/books/book_68276bb6c3cc6.png', 'Jurafsky', 'Pearson', 118, 13, 13, '2025-05-17 01:39:34'),
(40, 'Computer Vision', 'upload/books/book_68276bb6c3cc7.png', 'Szeliski', 'Springer', 97.5, 10, 10, '2025-05-17 01:39:34'),
(41, 'Distributed Systems', 'upload/books/book_68276bb6c3cc8.png', 'Coulouris', 'Addison-Wesley', 82, 8, 8, '2025-05-17 01:39:34'),
(42, 'Network Security', 'upload/books/book_68276bb6c3cc9.png', 'Kaufman', 'Prentice Hall', 135, 6, 5, '2025-05-17 01:39:34'),
(43, 'Data Mining', 'upload/books/book_68276bb6c3cca.png', 'Han', 'Morgan Kaufmann', 90, 14, 14, '2025-05-17 01:39:34'),
(44, 'Advanced Algorithms', 'upload/books/book_68276bb6c3ccb.png', 'Kleinberg', 'Pearson', 100, 10, 10, '2025-05-17 01:39:34'),
(45, 'Operating Systems Design', 'upload/books/book_68276bb6c3ccc.png', 'Tanenbaum', 'Prentice Hall', 87.5, 12, 11, '2025-05-17 01:39:34'),
(46, 'Compiler Design', 'upload/books/book_68276bb6c3ccd.png', 'Aho', 'Addison-Wesley', 112, 9, 9, '2025-05-17 01:39:34'),
(47, 'Information Retrieval', 'upload/books/book_68276bb6c3cce.png', 'Manning', 'Cambridge Press', 79, 11, 11, '2025-05-17 01:39:34'),
(48, 'Bioinformatics', 'upload/books/book_68276bb6c3ccf.png', 'Lesk', 'Oxford Press', 145, 7, 7, '2025-05-17 01:39:34'),
(49, 'Cryptography', 'upload/books/book_68276bb6c3cd0.png', 'Katz', 'CRC Press', 95.5, 10, 10, '2025-05-17 01:39:34'),
(50, 'Human-Computer Interaction', 'upload/books/book_68276bb6c3cd1.png', 'Dix', 'Pearson', 68, 15, 15, '2025-05-17 01:39:34'),
(51, 'Augmented Reality', 'upload/books/book_68276bb6c3cd2.png', 'Schmalstieg', 'Addison-Wesley', 122, 8, 8, '2025-05-17 01:39:34'),
(52, 'Virtual Reality', 'upload/books/book_68276bb6c3cd3.png', 'Burdea', 'Wiley', 84, 10, 10, '2025-05-17 01:39:34'),
(53, 'Internet of Things', 'upload/books/book_68276bb6c3cd4.png', 'Atzori', 'Springer', 91, 12, 12, '2025-05-17 01:39:34'),
(54, 'Edge Computing', 'upload/books/book_68276bb6c3cd5.png', 'Shi', 'McGraw-Hill', 77.5, 9, 9, '2025-05-17 01:39:34'),
(55, 'Software Testing', 'upload/books/book_68276bb6c3cd6.png', 'Myers', 'Wiley', 103, 11, 11, '2025-05-17 01:39:34'),
(56, 'Microservices Architecture', 'upload/books/book_68276bb6c3cd8.png', 'Newman', 'Addison-Wesley', 108, 10, 10, '2025-05-17 01:39:34'),
(57, 'Graph Theory', 'upload/books/book_68276bb6c3cd9.png', 'West', 'Prentice Hall', 94, 8, 8, '2025-05-17 01:39:34'),
(58, 'Numerical Methods', 'upload/books/book_68276bb6c3cda.png', 'Burden', 'Cengage', 86.5, 15, 15, '2025-05-17 01:39:34'),
(59, 'Simulation Modeling', 'upload/books/book_68276bb6c3cdb.png', 'Law', 'McGraw-Hill', 119, 7, 7, '2025-05-17 01:39:34'),
(60, 'Pattern Recognition', 'upload/books/book_68276bb6c3cdc.png', 'Duda', 'Wiley', 101, 10, 10, '2025-05-17 01:39:34'),
(61, 'Speech Processing', 'upload/books/book_68276bb6c3cdd.png', 'Rabiner', 'Pearson', 83, 12, 12, '2025-05-17 01:39:34'),
(62, 'Signal Processing', 'upload/books/book_68276bb6c3cde.png', 'Oppenheim', 'Prentice Hall', 127, 9, 9, '2025-05-17 01:39:34'),
(63, 'Control Systems', 'upload/books/book_68276bb6c3cdf.png', 'Nise', 'Wiley', 93.5, 11, 11, '2025-05-17 01:39:34'),
(64, 'Digital Design', 'upload/books/book_68276bb6c3ce0.png', 'Mano', 'Pearson', 76, 13, 13, '2025-05-17 01:39:34'),
(65, 'VLSI Design', 'upload/books/book_68276bb6c3ce1.png', 'Weste', 'Addison-Wesley', 132, 6, 6, '2025-05-17 01:39:34'),
(66, 'Computer Ethics', 'upload/books/book_68276bb6c3ce2.png', 'Johnson', 'Pearson', 62.5, 10, 10, '2025-05-17 01:39:34'),
(67, 'English For Today', 'upload/books/book_6828ac30b06b1.png', 'Lekhok', 'NCTB', 200, 12, 12, '2025-05-17 15:33:04');

-- --------------------------------------------------------

--
-- Table structure for table `issue_book`
--

CREATE TABLE `issue_book` (
  `issue_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `last_date_to_return` date NOT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `issue_book`
--

INSERT INTO `issue_book` (`issue_id`, `book_id`, `user_id`, `issue_date`, `last_date_to_return`, `return_date`) VALUES
(1, 17, 2, '2025-05-11', '2025-06-11', '2025-05-17'),
(2, 19, 2, '2025-05-11', '2025-06-11', '2025-05-17'),
(3, 45, 2, '2025-05-17', '2025-06-17', NULL),
(4, 42, 2, '2025-05-17', '2025-06-17', NULL),
(5, 57, 2, '2025-05-17', '2025-06-17', '2025-05-17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `username` text NOT NULL,
  `pass` text NOT NULL,
  `email` text NOT NULL,
  `user_type` text NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL,
  `photo` text NOT NULL,
  `dept` text NOT NULL,
  `designation` text NOT NULL,
  `uniqueid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `pass`, `email`, `user_type`, `phone`, `address`, `photo`, `dept`, `designation`, `uniqueid`) VALUES
(1, 'Umme Aiman ', 'admin', '123', 'uam@gmail.com', 'staff', '4567890', 'Dhaka', 'upload/1744767879.jpg', 'Library', 'Librarian', '250001'),
(2, 'Anika Sharmila', 'anika', '123', 'anika@lms.com', 'student', '01712345678', 'Feni', 'upload/1744767879.jpg', 'CSE', 'Student', '120001'),
(3, 'Dr. Md. Shamsul Arefin', 'arefin', '123', 'arefin@lms.com', 'teacher', '091234567', 'Chittagong', 'upload/1744767879.jpg', 'CSE', 'Professor', '280003'),
(7, 'Fatema tuj johora', 'fatema', '123', 'fatematuj1234@gmail.com', 'student', '01533415066', 'North Anandapur,Munshirhut,Fulgaji\r\nF-A3,H.N.-77,Road-8,Mirpur-12', 'upload/1747494241_images.png', 'CSE', 'Student', '120004'),
(9, 'MD Faizul Abedin Shibli', 'faizul', '456789', 'fas@feniuniversity.com', 'teacher', '5654654', 'Feni', 'upload/1747496676_fas.jpeg', 'CSE', 'Lecturer', 'T20009');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue_book`
--
ALTER TABLE `issue_book`
  ADD PRIMARY KEY (`issue_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `issue_book`
--
ALTER TABLE `issue_book`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
