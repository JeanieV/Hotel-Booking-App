-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 17, 2023 at 07:49 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `greece_bookings`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingNo` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `checkInDate` date DEFAULT NULL,
  `checkOutDate` date DEFAULT NULL,
  `totalCost` int(11) DEFAULT NULL,
  `cancelled` tinyint(1) DEFAULT NULL,
  `completed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingNo`, `user_id`, `hotel_id`, `checkInDate`, `checkOutDate`, `totalCost`, `cancelled`, `completed`) VALUES
(23, 23, 1, '2023-08-03', '2023-08-05', 34100, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `hotel_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pricePerNight` int(11) NOT NULL,
  `thumbnail` blob NOT NULL,
  `features` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `beds` int(25) NOT NULL,
  `rating` int(25) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`hotel_id`, `name`, `pricePerNight`, `thumbnail`, `features`, `type`, `beds`, `rating`, `address`) VALUES
(1, 'Marbella Elix', 17050, 0x6d617262656c6c61456c69782e6a7067, 'Beautifully designed rooms are meticulously appointed down to the very last detail, complete with five-star amenities and luxuries: flat-screen TV, free 			Wi-Fi, organic toiletries, and premium ultra-soft bedding promise to make each and every stay unforgettable.', 'Executive suite', 2, 5, 'Καραβοστάσι 461 00, Greece'),
(2, 'Royal Senses', 11000, 0x726f79616c53656e7365732e6a7067, 'The hotel will feature state of the art facilities including a spa, indoor and outdoor pool, water park, tennis courts as well as a private beach and marina.', 'Villa Suite', 2, 4, 'Herakliou 58 km, Panormos 740 57, Greece'),
(3, 'The View', 9008, 0x746865566965772e6a7067, 'A restaurant, spa and gym- is available by arrangement', 'Studio', 4, 3, 'Mikonos 846 00, Greece'),
(4, 'Angsana Corfu', 10700, 0x616e6773616e61436f7266752e6a7067, 'Amongst Angsana Corfu luxurious facilities, a main outdoor infinity pool encapsulates the heart of the resort’s lifestyle. An indoor heated pool for winter days or training regimes and a kids’ pool bring the fun of poolside life to every guest. A personal fitness program can be designed and executed at Angsana Corfu dedicated state-of-the-art Gym and at the outdoor Yoga Pavilion, for a healthy and fit summer life. There will always be something for the children, who can happily hang out and socially mingle at our kids’ club and pool, the Ranger’s Club. The beach spot will offer luxurious sun loungers, a beach bar and fun water sports activities.', 'Presidential suite', 6, 5, 'Akra Punta, National Rd 11 Km, Mpenitses 490 84, Greece'),
(5, 'The Rooster', 15400, 0x746865526f6f737465722e6a7067, 'The Rooster is comprised of 17 independent houses, where one feels like a welcomed guest. An open space is available for interactive activities aiming to support the quest for inner peace in an area blessed with unparalleled natural beauty. Each house has its own character where guests can feel at home, with four different layouts to choose from, all including ample space, private gardens, outdoor showers and a breath-taking view of the sea and the surrounding landscape. Understated and unpretentious luxury, privacy, simplicity and comfort are leading values of the design philosophy.', 'Executive suite', 3, 5, ' Livadia Bay, Antiparos 840 07, Greece'),
(6, 'Destino Pacha', 17400, 0x64657374696e6f50616368612e6a706567, 'The swimming pool, the restaurant, the lounge and the bar are in the heart of the Mykonos hotel experience. Guests will experience the exclusive Pacha experience of Ibiza, which has been identified with fun, luxury and quality. Many will be the artists, performers and world-renowned DJs who will contribute to this experience.', 'Villa Suite', 4, 4, 'Agios Stefanos 846 00, Greece');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNumber` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `fullname`, `address`, `password`, `email`, `phoneNumber`) VALUES
(22, 'Ben', 'Ben Swart', '17 Acacia street', '123', 'ben@gmail.com', '083-666-1691'),
(23, 'Mia', 'Mia Renolds', '123 Coral Reef', '123#', 'mia@gmail.com', '071-333-4569');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingNo`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`hotel_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `hotel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
