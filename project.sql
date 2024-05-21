-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 23-05-31 05:46
-- 서버 버전: 10.4.27-MariaDB
-- PHP 버전: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `project`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `debate`
--

CREATE TABLE `debate` (
  `num` int(11) NOT NULL,
  `id` varchar(15) NOT NULL,
  `name` varchar(10) NOT NULL,
  `nick` varchar(10) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `regist_day` varchar(20) DEFAULT NULL,
  `hit` int(11) DEFAULT NULL,
  `is_html` char(1) DEFAULT NULL,
  `file_name_0` varchar(40) DEFAULT NULL,
  `file_name_1` varchar(40) DEFAULT NULL,
  `file_name_2` varchar(40) DEFAULT NULL,
  `file_name_3` varchar(40) DEFAULT NULL,
  `file_name_4` varchar(40) DEFAULT NULL,
  `file_copied_0` varchar(30) DEFAULT NULL,
  `file_copied_1` varchar(30) DEFAULT NULL,
  `file_copied_2` varchar(30) DEFAULT NULL,
  `file_copied_3` varchar(30) DEFAULT NULL,
  `file_copied_4` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `debate_ripple`
--

CREATE TABLE `debate_ripple` (
  `num` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `id` varchar(15) NOT NULL,
  `name` varchar(10) NOT NULL,
  `nick` varchar(10) NOT NULL,
  `content` text NOT NULL,
  `regist_day` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `download`
--

CREATE TABLE `download` (
  `num` int(11) NOT NULL,
  `id` varchar(15) NOT NULL,
  `name` varchar(10) NOT NULL,
  `nick` varchar(10) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `regist_day` varchar(20) DEFAULT NULL,
  `hit` int(11) DEFAULT NULL,
  `is_html` char(1) DEFAULT NULL,
  `file_name_0` varchar(40) DEFAULT NULL,
  `file_name_1` varchar(40) DEFAULT NULL,
  `file_name_2` varchar(40) DEFAULT NULL,
  `file_name_3` varchar(40) DEFAULT NULL,
  `file_name_4` varchar(40) DEFAULT NULL,
  `file_copied_0` varchar(30) DEFAULT NULL,
  `file_copied_1` varchar(30) DEFAULT NULL,
  `file_copied_2` varchar(30) DEFAULT NULL,
  `file_copied_3` varchar(30) DEFAULT NULL,
  `file_copied_4` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `free`
--

CREATE TABLE `free` (
  `num` int(11) NOT NULL,
  `id` varchar(15) NOT NULL,
  `name` varchar(10) NOT NULL,
  `nick` varchar(10) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `regist_day` char(20) DEFAULT NULL,
  `hit` int(11) DEFAULT NULL,
  `is_html` char(1) DEFAULT NULL,
  `file_name_0` varchar(40) DEFAULT NULL,
  `file_name_1` varchar(40) DEFAULT NULL,
  `file_name_2` varchar(40) DEFAULT NULL,
  `file_name_3` varchar(40) DEFAULT NULL,
  `file_name_4` varchar(40) DEFAULT NULL,
  `file_copied_0` varchar(30) DEFAULT NULL,
  `file_copied_1` varchar(30) DEFAULT NULL,
  `file_copied_2` varchar(30) DEFAULT NULL,
  `file_copied_3` varchar(30) DEFAULT NULL,
  `file_copied_4` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `free_ripple`
--

CREATE TABLE `free_ripple` (
  `num` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `id` varchar(15) NOT NULL,
  `name` varchar(10) NOT NULL,
  `nick` varchar(10) NOT NULL,
  `content` text NOT NULL,
  `regist_day` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `member`
--

CREATE TABLE `member` (
  `id` varchar(15) NOT NULL,
  `pass` varchar(15) NOT NULL,
  `name` varchar(10) NOT NULL,
  `nick` varchar(10) NOT NULL,
  `hp` char(20) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `regist_day` char(20) DEFAULT NULL,
  `level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `product`
--

CREATE TABLE `product` (
  `num` int(11) NOT NULL,
  `id` varchar(15) NOT NULL,
  `name` varchar(10) NOT NULL,
  `nick` varchar(10) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `regist_day` varchar(20) DEFAULT NULL,
  `hit` int(11) DEFAULT NULL,
  `is_html` char(1) DEFAULT NULL,
  `file_name_0` varchar(40) DEFAULT NULL,
  `file_name_1` varchar(40) DEFAULT NULL,
  `file_name_2` varchar(40) DEFAULT NULL,
  `file_name_3` varchar(40) DEFAULT NULL,
  `file_name_4` varchar(40) DEFAULT NULL,
  `file_copied_0` varchar(30) DEFAULT NULL,
  `file_copied_1` varchar(30) DEFAULT NULL,
  `file_copied_2` varchar(30) DEFAULT NULL,
  `file_copied_3` varchar(30) DEFAULT NULL,
  `file_copied_4` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `debate`
--
ALTER TABLE `debate`
  ADD PRIMARY KEY (`num`);

--
-- 테이블의 인덱스 `debate_ripple`
--
ALTER TABLE `debate_ripple`
  ADD PRIMARY KEY (`num`);

--
-- 테이블의 인덱스 `download`
--
ALTER TABLE `download`
  ADD PRIMARY KEY (`num`);

--
-- 테이블의 인덱스 `free`
--
ALTER TABLE `free`
  ADD PRIMARY KEY (`num`);

--
-- 테이블의 인덱스 `free_ripple`
--
ALTER TABLE `free_ripple`
  ADD PRIMARY KEY (`num`);

--
-- 테이블의 인덱스 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`num`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `debate`
--
ALTER TABLE `debate`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `debate_ripple`
--
ALTER TABLE `debate_ripple`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `download`
--
ALTER TABLE `download`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `free`
--
ALTER TABLE `free`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `free_ripple`
--
ALTER TABLE `free_ripple`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
