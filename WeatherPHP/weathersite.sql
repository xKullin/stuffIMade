-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2020 at 04:40 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weathersite`
--

-- --------------------------------------------------------

--
-- Table structure for table `weathercomments`
--

CREATE TABLE `weathercomments` (
  `id` int(6) UNSIGNED NOT NULL,
  `ComText` varchar(100) NOT NULL,
  `temp` varchar(15) DEFAULT NULL,
  `optionStatus` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `weathercomments`
--

INSERT INTO `weathercomments` (`id`, `ComText`, `temp`, `optionStatus`) VALUES
(2, 'No thanks.', '0-3', ''),
(3, 'Wow, that\'s cold as fuck.', '0-3', ''),
(4, 'Honestly, anything under 10°C is just too cold.', '0-3', ''),
(5, 'If it\'s this gold you\'re not allowed to go outside.', '0-3', ''),
(6, 'Is earth testing our limits?', '0-3', ''),
(7, 'A bit chilly. That means it\'s too chilly.', '4-7', ''),
(10, 'I honestly have nothing to say about the weather, it\'s just there.', '8-11', ''),
(11, 'This weather is as interesting as my personal life.', '8-11', ''),
(12, 'The weather outside is weather.', '8-11', ''),
(16, 'Hell is probably freezing over.', 'minus', ''),
(17, 'No.', 'minus', ''),
(18, 'What the damn hell.', 'minus', ''),
(19, 'Ah yes, weather.', '12-15', ''),
(20, 'It\'s alright outside, but can you make popcorn outside?', '12-15', ''),
(31, 'Now we\'re talking!', '16-20', ''),
(32, 'The weather gets a polite nod from me today.', '16-20', ''),
(33, 'Could be worse.', '16-20', ''),
(34, 'Weather, am I right?', '16-20', ''),
(35, 'Oh damn, that\'s very hot. Too hot? Yes.', '20+', ''),
(36, 'Why is the weather bad you ask? Because mother nature hates all of us.', '4-7', ''),
(37, 'We\'re just not gonna go outside, simple as that.', '4-7', ''),
(38, 'The weather is, wait for it... terrible.', '4-7', ''),
(39, 'What the hell is your problem Mr. Weather?', '4-7', ''),
(40, 'The weather is just.. weather.', '16-20', ''),
(41, 'This is the weird middle ground where the weather just isn\'t interesting.', '8-11', ''),
(42, 'Could be better, could be worse.', '8-11', ''),
(43, 'It could be better, but I\'ll give it a pass.', '12-15', ''),
(44, 'I mean, the weather is just kinda there today.', '12-15', ''),
(45, 'Wow, weather.', '12-15', ''),
(46, 'How about we just stay inside where it\'s not hot? Please.', '20+', ''),
(47, 'Wow, absolutely way too damn hot outside.', '20+', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `weathercomments`
--
ALTER TABLE `weathercomments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `weathercomments`
--
ALTER TABLE `weathercomments`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
