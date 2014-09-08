SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE DATABASE IF NOT EXISTS `webshop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `webshop`;
DROP TABLE IF EXISTS `pc`;
CREATE TABLE IF NOT EXISTS `pc`(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` enum('laptop', 'desktop', 'other'),
  `price` numeric(10,2) NOT NULL,
  `cpu` varchar(50),
  `gpu` text,
  `hdd` varchar(255),
  `ram` varchar(40),
  `omschrijving` text,
  PRIMARY KEY(`id`))
  ENGINE=InnoDB DEFAULT CHARSET=utf8;

  INSERT INTO `pc` (`id`, `name`, `type`, `price`, `cpu`, `gpu`, `hdd`, `ram`, `omschrijving`) VALUES
  (1, 'Dell desktop', 'desktop', 500, 'i7 processor', 'gt840', '2x 500gb', '8g ddr3', 'odsjflkjhqsgljshfljsdjqklj'),
  (2, 'Dell laptop', 'laptop', 600, 'i3 processor', 'gt840', '2x 1000gb', '6g ddr3', 'sdqvhkjnjkqhqmrt');



