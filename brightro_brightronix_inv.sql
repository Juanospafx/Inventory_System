-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-02-2026 a las 21:17:14
-- Versión del servidor: 10.6.24-MariaDB-cll-lve
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
-- Estructura de tabla para la tabla `media`
--

CREATE TABLE `media` (
  `id` int(11) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `media`
--

INSERT INTO `media` (`id`, `file_name`, `file_type`, `description`, `uploaded_at`) VALUES
(0, 'imtet2825c.jpg', 'image/jpeg', 'imtet2825c', '2025-12-18 17:12:10'),
(14, 'prod_67f41542d19543.76675455.png', 'image/png', 'Brightronix logo', '2025-04-07 22:11:14'),
(15, 'WhatsApp Image 2025-12-18 at 12.49.22 PM.jpeg', 'image/jpeg', 'WhatsApp Image 2025-12-18 at 12.49.22 PM', '2025-12-19 19:10:30'),
(16, 'WhatsApp Image 2025-12-18 at 12.49.22 PM.jpeg', 'image/jpeg', 'WhatsApp Image 2025-12-18 at 12.49.22 PM', '2025-12-19 19:14:23'),
(17, 'WhatsApp Image 2025-12-18 at 12.52.59 PM.jpeg', 'image/jpeg', 'WhatsApp Image 2025-12-18 at 12.52.59 PM', '2025-12-19 19:20:30'),
(18, 'WhatsApp Image 2025-12-18 at 1.06.59 PM.jpeg', 'image/jpeg', 'WhatsApp Image 2025-12-18 at 1.06.59 PM', '2025-12-19 19:31:50'),
(19, 'WhatsApp Image 2025-12-18 at 1.09.50 PM.jpeg', 'image/jpeg', 'WhatsApp Image 2025-12-18 at 1.09.50 PM', '2025-12-19 19:32:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movements`
--

CREATE TABLE `movements` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL,
  `status` int(1) NOT NULL,
  `date` date NOT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `movements`
--

INSERT INTO `movements` (`id`, `product_id`, `quantity`, `user_id`, `project_id`, `status`, `date`, `note`) VALUES
(1, 2, 12, 16, 2, 0, '2025-12-18', 'Salida de inventario a proyecto Oakland');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `shelf_id` int(11) UNSIGNED NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `qr_code`, `quantity`, `shelf_id`, `media_id`, `date`, `note`) VALUES
(2, 'Tipo de fixture B', 'uploads/qrcodes/qrcode-2.png', '4', 207, 16, '2025-12-19 00:00:00', 'Proyecto: oakland'),
(3, 'Tipo fixture C', 'uploads/qrcodes/qrcode-3.png', '26', 207, 17, '2025-12-19 00:00:00', 'Proyecto oakland'),
(4, 'Inverter isolite', 'uploads/qrcodes/qrcode-4.png', '8', 207, 18, '2025-12-19 00:00:00', 'Proyecto: oakland'),
(5, 'Fixture tipo D', 'uploads/qrcodes/qrcode-5.png', '4', 207, 19, '2025-12-19 00:00:00', 'Proyecto: oakland');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_media`
--

CREATE TABLE `product_media` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `media_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `product_media`
--

INSERT INTO `product_media` (`id`, `product_id`, `media_id`) VALUES
(1, 1, 15),
(2, 2, 16),
(3, 3, 17),
(4, 4, 18),
(5, 5, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

CREATE TABLE `projects` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `projects`
--

INSERT INTO `projects` (`id`, `name`) VALUES
(2, 'Oakland');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shelves`
--

CREATE TABLE `shelves` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `shelves`
--

INSERT INTO `shelves` (`id`, `name`) VALUES
(362, 'A1_10L'),
(361, 'A1_10R'),
(386, 'A1_11L'),
(385, 'A1_11R'),
(209, 'A1_1L'),
(208, 'A1_1R'),
(215, 'A1_2L'),
(214, 'A1_2R'),
(221, 'A1_3L'),
(220, 'A1_3R'),
(308, 'A1_4L'),
(307, 'A1_4R'),
(314, 'A1_5L'),
(313, 'A1_5R'),
(320, 'A1_6L'),
(319, 'A1_6R'),
(326, 'A1_7L'),
(325, 'A1_7R'),
(332, 'A1_8L'),
(331, 'A1_8R'),
(356, 'A1_9L'),
(355, 'A1_9R'),
(364, 'A2_10L'),
(363, 'A2_10R'),
(388, 'A2_11L'),
(387, 'A2_11R'),
(211, 'A2_1L'),
(210, 'A2_1R'),
(217, 'A2_2L'),
(216, 'A2_2R'),
(223, 'A2_3L'),
(222, 'A2_3R'),
(310, 'A2_4L'),
(309, 'A2_4R'),
(316, 'A2_5L'),
(315, 'A2_5R'),
(322, 'A2_6L'),
(321, 'A2_6R'),
(328, 'A2_7L'),
(327, 'A2_7R'),
(334, 'A2_8L'),
(333, 'A2_8R'),
(358, 'A2_9L'),
(357, 'A2_9R'),
(366, 'A3_10L'),
(365, 'A3_10R'),
(390, 'A3_11L'),
(389, 'A3_11R'),
(213, 'A3_1L'),
(212, 'A3_1R'),
(219, 'A3_2L'),
(218, 'A3_2R'),
(225, 'A3_3L'),
(224, 'A3_3R'),
(312, 'A3_4L'),
(311, 'A3_4R'),
(318, 'A3_5L'),
(317, 'A3_5R'),
(324, 'A3_6L'),
(323, 'A3_6R'),
(330, 'A3_7L'),
(329, 'A3_7R'),
(336, 'A3_8L'),
(335, 'A3_8R'),
(360, 'A3_9L'),
(359, 'A3_9R'),
(227, 'B_1L'),
(226, 'B_1R'),
(338, 'B_2L'),
(337, 'B_2R'),
(368, 'B_3L'),
(367, 'B_3R'),
(229, 'C_1L'),
(228, 'C_1R'),
(340, 'C_2L'),
(339, 'C_2R'),
(370, 'C_3L'),
(369, 'C_3R'),
(231, 'D_1L'),
(230, 'D_1R'),
(342, 'D_2L'),
(341, 'D_2R'),
(372, 'D_3L'),
(371, 'D_3R'),
(233, 'E_1L'),
(232, 'E_1R'),
(344, 'E_2L'),
(343, 'E_2R'),
(374, 'E_3L'),
(373, 'E_3R'),
(235, 'F_1L'),
(234, 'F_1R'),
(346, 'F_2L'),
(345, 'F_2R'),
(376, 'F_3L'),
(375, 'F_3R'),
(237, 'G_1L'),
(236, 'G_1R'),
(348, 'G_2L'),
(347, 'G_2R'),
(378, 'G_3L'),
(377, 'G_3R'),
(239, 'H1_1L'),
(238, 'H1_1R'),
(350, 'H1_2L'),
(349, 'H1_2R'),
(380, 'H1_3L'),
(379, 'H1_3R'),
(241, 'H2_1L'),
(240, 'H2_1R'),
(352, 'H2_2L'),
(351, 'H2_2R'),
(382, 'H2_3L'),
(381, 'H2_3R'),
(243, 'H3_1L'),
(242, 'H3_1R'),
(354, 'H3_2L'),
(353, 'H3_2R'),
(384, 'H3_3L'),
(383, 'H3_3R'),
(244, 'I_1'),
(245, 'I_2'),
(246, 'I_3'),
(247, 'J_1'),
(248, 'J_2'),
(249, 'J_3'),
(250, 'K_1'),
(251, 'K_2'),
(252, 'K_3'),
(253, 'L_1'),
(254, 'L_2'),
(255, 'L_3'),
(256, 'M_1'),
(257, 'M_2'),
(258, 'M_3'),
(259, 'N_1'),
(260, 'N_2'),
(261, 'N_3'),
(262, 'O_1'),
(263, 'O_2'),
(264, 'O_3'),
(207, 'Paleta'),
(265, 'P_1'),
(266, 'P_2'),
(267, 'P_3'),
(268, 'Q_1'),
(269, 'Q_2'),
(270, 'Q_3'),
(271, 'R_1'),
(272, 'R_2'),
(273, 'R_3'),
(274, 'S_1'),
(275, 'S_2'),
(276, 'S_3'),
(277, 'T_1'),
(278, 'T_2'),
(279, 'T_3'),
(280, 'U_1'),
(281, 'U_2'),
(282, 'U_3'),
(283, 'V_1'),
(284, 'V_2'),
(285, 'V_3'),
(287, 'W_1L'),
(286, 'W_1R'),
(289, 'W_2L'),
(288, 'W_2R'),
(291, 'W_3L'),
(290, 'W_3R'),
(293, 'X_1L'),
(292, 'X_1R'),
(295, 'X_2L'),
(294, 'X_2R'),
(297, 'X_3L'),
(296, 'X_3R'),
(299, 'Y_1L'),
(298, 'Y_1R'),
(301, 'Y_2L'),
(300, 'Y_2R'),
(303, 'Y_3L'),
(302, 'Y_3R'),
(304, 'Z_1'),
(305, 'Z_2'),
(306, 'Z_3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, 'Admin Users', 'admin', '4ccb032bf875eee69a6efb95980eff703062e432', 1, '7i9otscq1.png', 1, '2026-02-10 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(3, 'User', 3, 1),
(4, 'Special user', 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movements`
--
ALTER TABLE `movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_movements_product` (`product_id`),
  ADD KEY `idx_movements_user` (`user_id`),
  ADD KEY `idx_movements_project` (`project_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_prod_name` (`name`),
  ADD UNIQUE KEY `uniq_prod_qr_code` (`qr_code`),
  ADD KEY `idx_products_shelf` (`shelf_id`),
  ADD KEY `idx_products_media` (`media_id`);

--
-- Indices de la tabla `product_media`
--
ALTER TABLE `product_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pm_product` (`product_id`),
  ADD KEY `idx_pm_media` (`media_id`);

--
-- Indices de la tabla `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `shelves`
--
ALTER TABLE `shelves`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_shelf_name` (`name`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_user_username` (`username`),
  ADD KEY `idx_users_level` (`user_level`);

--
-- Indices de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_group_level` (`group_level`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `movements`
--
ALTER TABLE `movements`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `product_media`
--
ALTER TABLE `product_media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `shelves`
--
ALTER TABLE `shelves`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=391;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
