-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 18-12-2025 a las 12:28:58
-- Versión del servidor: 10.6.23-MariaDB-cll-lve
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `brightro_brightronix_inv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `projects`
--

INSERT INTO `projects` (`id`, `name`) VALUES
(1, 'Rexel');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shelves`
--

DROP TABLE IF EXISTS `shelves`;
CREATE TABLE `shelves` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_shelf_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `shelves`
--

INSERT INTO `shelves` (`id`, `name`) VALUES
(1, 'A1'),
(2, 'A2'),
(3, 'A3'),
(198, 'B'),
(197, 'C'),
(196, 'E'),
(195, 'F'),
(203, 'G'),
(204, 'H1'),
(205, 'H2'),
(206, 'H3'),
(188, 'I'),
(192, 'J'),
(193, 'K'),
(184, 'N'),
(185, 'O'),
(186, 'P'),
(187, 'R'),
(191, 'S'),
(202, 'T'),
(201, 'U'),
(200, 'V'),
(189, 'W'),
(190, 'X'),
(194, 'Y'),
(199, 'Z');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `media`
--

INSERT INTO `media` (`id`, `file_name`, `file_type`, `description`, `uploaded_at`) VALUES
(14, 'prod_67f41542d19543.76675455.png', 'image/png', 'Brightronix logo', '2025-04-07 22:11:14'),
(0, 'imtet2825c.jpg', 'image/jpeg', 'imtet2825c', '2025-12-18 17:12:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `shelf_id` int(11) UNSIGNED NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_prod_name` (`name`),
  UNIQUE KEY `uniq_prod_qr_code` (`qr_code`),
  KEY `idx_products_shelf` (`shelf_id`),
  KEY `idx_products_media` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `qr_code`, `quantity`, `shelf_id`, `media_id`, `date`) VALUES
(0, 'Inverter item', 'uploads/qrcodes/qrcode-0.png', '13', 188, 0, '2025-12-18 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_media`
--

DROP TABLE IF EXISTS `product_media`;
CREATE TABLE `product_media` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(11) UNSIGNED NOT NULL,
  `media_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pm_product` (`product_id`),
  KEY `idx_pm_media` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movements`
--

DROP TABLE IF EXISTS `movements`;
CREATE TABLE `movements` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL,
  `status` int(1) NOT NULL,
  `date` date NOT NULL,
  `note` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_movements_product` (`product_id`),
  KEY `idx_movements_user` (`user_id`),
  KEY `idx_movements_project` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_user_username` (`username`),
  KEY `idx_users_level` (`user_level`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, 'Admin Users', 'admin', '07aac3bd87853967bff2473b4cb0c835f5fe2253', 1, '7i9otscq1.png', 1, '2025-12-18 00:00:00'),
(13, 'Guillermo Mota', 'guillermo', '88dd1e7e0ecbddaefb20aec5bbf0b70874a3fad6', 3, '1wq3wldi13.png', 1, '2025-04-07 00:00:00'),
(15, 'Alberto Peguero', 'alberto', '60d4d892540fde1c206b95de3c56b78387266ea1', 2, '0yqvb1f15.png', 1, '2025-04-07 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_group_level` (`group_level`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(3, 'User', 3, 1),
(4, 'Special user', 2, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
