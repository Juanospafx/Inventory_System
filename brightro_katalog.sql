-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 19-02-2026 a las 18:07:21
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
-- Base de datos: `brightro_katalog`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `short_name` varchar(200) NOT NULL,
  `in_home` tinyint(1) DEFAULT 0,
  `in_menu` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id`, `name`, `short_name`, `in_home`, `in_menu`, `is_active`) VALUES
(3, 'Conduit, Duct, & Raceway', 'Conduit', 0, 0, 1),
(4, 'Boxes & Enclosures', 'Boxes', 0, 0, 1),
(5, 'Wire, Cable, & Cord', 'wire', 0, 0, 1),
(6, 'Connectors, Crimps, & Termination', 'Connectors', 0, 0, 1),
(7, 'Straps', 'Straps', 0, 0, 1),
(8, 'Power Distribution', 'Power Distribution', 0, 0, 1),
(9, 'Lighting & Lighting Controls', 'Lighting ', 0, 0, 1),
(10, 'MC, NM-B, Liquidtight, Flex Fittings', 'MC', 0, 0, 1),
(11, 'GFCI & AFCI Wiring Devices', 'GFCI ', 0, 0, 1),
(12, 'PVCs Elbows', 'pvc', 0, 0, 1),
(13, 'Control & Automation', 'Control', 0, 0, 1),
(14, 'Wiring Devices', 'Wiring', 0, 0, 1),
(15, 'Fittings', 'Fi', 0, 0, 1),
(16, 'Tools, Testing, & Meters', 'Tools', 0, 0, 1),
(17, 'Lamps, Bulbs, & Ballasts', 'Lamps', 0, 0, 1),
(18, 'Fasteners', 'Faste', 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuration`
--

CREATE TABLE `configuration` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `label` varchar(200) NOT NULL,
  `kind` int(11) NOT NULL,
  `val` text DEFAULT NULL,
  `cfg_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `configuration`
--

INSERT INTO `configuration` (`id`, `name`, `label`, `kind`, `val`, `cfg_id`) VALUES
(1, 'general_main_title', 'Titulo Principal', 1, 'BrigCAT', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `short_name` varchar(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `code` varchar(200) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `offer_txt` varchar(1000) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_public` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `order_at` datetime DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id`, `short_name`, `name`, `code`, `description`, `offer_txt`, `image`, `link`, `is_featured`, `is_public`, `created_at`, `order_at`, `category_id`) VALUES
(10, 'lM4WancR_cx', '3/4\" EMT Conduit, Steel, 10\' Length', '49014', '3/4 Inch EMT Conduit, Steel, 10 Foot Length\r\nEMT is also called \"thin-wall\" conduit because it is thin and lightweight, especially compared to RMC. EMT is rigid but can be bent with a simple tool called a conduit bender. EMT is installed with couplings and fittings that are secured with setscrew or compression-type fasteners.\r\nAlso known as: 091111020025, 075, tunnel conduit, emt, 3/4 emt, 3/4\" EMT, PIPE', NULL, '34e_7.jpg', '', 1, 1, '2025-03-12 14:20:45', NULL, 3),
(11, 'iB1ihoxIDRG', '1\" EMT Conduit, Steel, 10\' Length', '49230', '1 Inch EMT Conduit, Steel, 10 Foot Length\r\nEMT is also called \"thin-wall\" conduit because it is thin and lightweight, especially compared to RMC. EMT is rigid but can be bent with a simple tool called a conduit bender. EMT is installed with couplings and fittings that are secured with setscrew or compression-type fasteners.\r\nAlso known as: 091111020032, 100, 1\" EMT, metal pipe, Conduit , Metal conduit, Shock tube', NULL, '34e_6.jpg', '', 0, 1, '2025-03-12 14:31:08', NULL, 3),
(12, 'JyI5d8SSkSK', '1/2\" EMT Conduit, Steel, 10\' Length', '49250', '1/2 Inch EMT Conduit, Steel, 10 Foot Length\r\nEMT is also called \"thin-wall\" conduit because it is thin and lightweight, especially compared to RMC. EMT is rigid but can be bent with a simple tool called a conduit bender. EMT is installed with couplings and fittings that are secured with setscrew or compression-type fasteners.\r\nAlso known as: 091111020018, 050, 1/2\" EMT, 1/2\" thinwall emt, EMT, thinwall, half inch emt, moneymaker, thin wall, 1/2\" thinwall, half-inch emt, tunnel conduit, 1/2 stick. , Metal pipe, Electrical Metalic Tubing', NULL, '34e_5.jpg', '', 1, 1, '2025-03-12 14:32:24', NULL, 3),
(13, 'pTvNTvxCAiZ', '1-1/4\" EMT Conduit, Steel, 10\' Length', '49034', '1-1/4 Inch EMT Conduit, Steel, 10 Foot Length\r\nEMT is also called \"thin-wall\" conduit because it is thin and lightweight, especially compared to RMC. EMT is rigid but can be bent with a simple tool called a conduit bender. EMT is installed with couplings and fittings that are secured with setscrew or compression-type fasteners.', NULL, '34e_4.jpg', '', 0, 1, '2025-03-12 14:33:46', NULL, 3),
(14, 'PuNq37-Gpw3', '2\" EMT Conduit, Steel, 10\' Length', '49053', '2 Inch EMT Conduit, Steel, 10 Foot Length\r\nEMT is also called \"thin-wall\" conduit because it is thin and lightweight, especially compared to RMC. EMT is rigid but can be bent with a simple tool called a conduit bender. EMT is installed with couplings and fittings that are secured with setscrew or compression-type fasteners.', NULL, '34e_3.jpg', '', 0, 1, '2025-03-12 14:36:04', NULL, 3),
(15, 'frAuTJtGOHN', '3-1/2\" EMT Conduit, Steel, 10\' Length', '49073', '3-1/2 Inch EMT Conduit, Steel, 10 Foot Length\r\nEMT is also called \"thin-wall\" conduit because it is thin and lightweight, especially compared to RMC. EMT is rigid but can be bent with a simple tool called a conduit bender. EMT is installed with couplings and fittings that are secured with setscrew or compression-type fasteners.', NULL, '34e_2.jpg', '', 0, 1, '2025-03-12 14:37:31', NULL, 3),
(16, 'FWaSTnu8kPt', '4\" EMT Conduit, Steel, 10\' Length', '49166', '4 Inch EMT Conduit, Steel, 10 Foot Length\r\nEMT is also called \"thin-wall\" conduit because it is thin and lightweight, especially compared to RMC. EMT is rigid but can be bent with a simple tool called a conduit bender. EMT is installed with couplings and fittings that are secured with setscrew or compression-type fasteners.\r\nAlso known as: 091111020100, 400, Pipe, EMT, Stick', NULL, '34e_1.jpg', '', 0, 1, '2025-03-13 10:58:55', NULL, 3),
(17, 'z_-qDV9OmW5', 'EMT Conduit Strap, 1-Hole, 3/4\", Steel', '49603', 'EMT Conduit Strap, 1-Hole, 3/4 Inch, Steel, For Use With EMT Conduit\r\nArlington\'s EMT conduit straps are made of plated steel, feature \"click-on\" application, and are made in the USA.\r\nAlso known as: 018997003713, 371', NULL, 'rac2088_5.jpg', '', 1, 1, '2025-03-13 11:07:52', NULL, 7),
(18, 'Gm1ilHxwnuh', 'EMT Conduit Strap, 1-Hole, 1/2\", Steel', '243915', 'EMT Conduit Strap, 1-Hole, 1/2 Inch, Steel, For Use With EMT Conduit\r\nMount EMT conduit with RACOÂ® 1-hole push-on straps. Easliy position the straps with the snap on style. Align the fastener easily with the oversized bolt holes located on the strap.\r\nAlso known as: 050169020821, 2082', NULL, 'rac2088_4.jpg', '', 1, 1, '2025-03-13 11:11:02', NULL, 7),
(19, 'Ym8nkE2K71Y', 'EMT Conduit Strap, 1-Hole, 2\", Steel', '271760', 'EMT Conduit Strap, 1-Hole, 2 Inch, Steel, For Use With EMT Conduit\r\nMount EMT conduit with RACOÂ® 1-hole push-on straps. Easliy position the straps with the snap on style. Align the fastener easily with the oversized bolt holes located on the strap.\r\nAlso known as: 050169020883, 2088', NULL, 'rac2088_3.jpg', '', 0, 1, '2025-03-13 11:17:32', NULL, 7),
(21, 'JG6375fZq9p', 'EMT Conduit Strap, 1-Hole, 1-1/4\", Steel', '153682', 'EMT Conduit Strap, 1-Hole, 1-1/4 Inch, Steel, For Use With EMT Conduit\r\nMount EMT conduit with RACOÂ® 1-hole push-on straps. Easliy position the straps with the snap on style. Align the fastener easily with the oversized bolt holes located on the strap.\r\nAlso known as: 050169020852, 2085', NULL, 'rac2088_2.jpg', '', 0, 1, '2025-03-13 11:26:17', NULL, 7),
(22, 'vPbzYH1tdA-', '4\" Square Box, Welded, 1-1/2\" Depth, 1/2 and 3/4\" Knockouts, Steel', '27477', '4 Inch Square Box With Raised Ground, Welded, 1-1/2 Inch Depth, Side Knockouts: (8) 1/2 Inch, (4) TKO, Bottom Knockouts: (2) 1/2 Inch, (2) TKO, 21 Cubic Inches, Steel\r\nRaco\'s selection of 4 inch square boxes are ideal for electrical installations in residential, commercial, and industrial settings. Available in various depths and made from durable steel in drawn or welded construction, these boxes ensure longevity and safety. Perfect for new constructions, renovations, or upgrades, our 4-inch square boxes and covers provide reliability and flexibility for a secure and efficient electrical system.\r\nAlso known as: 050169901892, 189, 4 square shallow , attic box, 4S Shallow', NULL, 'raco232prodimage45deg1200-1.jpg', '', 0, 1, '2025-03-13 11:33:04', NULL, 4),
(23, '-FhcxZsjOqv', '12 AWG THHN/THWN-2 Stranded Copper, black, 500\'', '68941', '12 AWG THHN/THWN-2 Stranded Copper, 600 volts, Black, 500 foot reel\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image_3.jpg', '', 1, 1, '2025-03-13 11:54:26', NULL, 5),
(24, '4edpMEpbwJn', '500 MCM THHN/THWN-2 Stranded Aluminum, black,Cut to Length', '1259855', '500 MCM THHN/THWN-2 Stranded Aluminum, Black, Cut to Length\r\nTHHN / THWN-2 / T90 cables are primarily used for power distribution. The cables may be used in wet or dry locations, with conductor temperatures not exceeding 90 Degrees Celsius.\r\nAlso known as: THHN500STRBLK-CUT', NULL, 'image-6_2.jpg', '', 0, 1, '2025-03-13 12:00:37', NULL, 5),
(25, 'eas76FcD6LF', '250 MCM XHHW Stranded Aluminum, Black, Cut to Length', '1259864', 'Type XHHW, 250 MCM, Aluminum, Stranded, Black, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.\r\nAlso known as: XHHW250STRBLK-CUT', NULL, 'image-6_1.jpg', '', 0, 1, '2025-03-13 12:04:48', NULL, 5),
(30, '1lxFnKa3Ihv', '4\" PVC Conduit, 20\' Length, Schedule 40, Gray, Bell End', '43353', '4 Inch PVC Conduit, 20 Foot Length, Schedule 40, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.', NULL, '2px20_4.jpg', '', 0, 1, '2025-03-17 08:44:03', NULL, 3),
(31, 'vQb3ljgcW0c', '3-1/2\" PVC Conduit, 10\' Length, Schedule 40, Gray, Bell End', '43185', '3-1/2 Inch PVC Conduit, 10 Foot Length, Schedule 40, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.', NULL, '2px20_3.jpg', '', 0, 1, '2025-03-17 08:46:05', NULL, 3),
(32, 'QJSzSBuAvPm', 'Meter Base, 7 Jaw, 200A, OH/UG Steel Enclosure, with Closing Plate', '331779', 'Meter Base, 7 Jaw, 200 Amp, 3-Phase, with Lever Bypass OH/UG Steel Enclosure, with Closing Plate, Type HQU, Stainless Steel Latch and Hasp\r\nTalon has been the standard for quality and innovation for meter mounting equipment for over half a century. The basic design of our sockets has not changed since inception, making Talon a solid, time-proven design. The residential socket line continues to grow daily as we continuously add or update our products for an ever-changing market.', NULL, 'image-7_1.jpg', '', 1, 1, '2025-03-17 08:53:22', NULL, 8),
(33, 'UCYNNIkmmK8', '3\" PVC Conduit, 10\' Length, Schedule 40, Gray, Bell End', '43163', '3 Inch PVC Conduit, 10 Foot Length, Schedule 40, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.', NULL, '2px20_2.jpg', '', 0, 1, '2025-03-17 08:54:43', NULL, 3),
(34, '9pdbhH4m8P5', '2\" PVC Conduit, 20\' Length, Schedule 40, Gray, Bell End', '43411', '2 Inch PVC Conduit, 20 Foot Length, Schedule 40, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.', NULL, '2px20_1.jpg', '', 0, 1, '2025-03-17 08:56:12', NULL, 3),
(35, '5fPHpgpDulg', '600 MCM THHN/THWN-2 Stranded Copper, Blue, Cut to Length', '237929', '600 MCM, THHN/THWN-2, Stranded Copper, 600V, Blue, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image-5_8.jpg', '', 1, 1, '2025-03-17 08:57:58', NULL, 5),
(36, 'ACWwPp5f7VU', '600 MCM THHN/THWN-2 Stranded Copper, Black, Cut to Length', '68329', '600 MCM, THHN/THWN-2, Stranded Copper, 600V, Black, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image_2.jpg', '', 0, 1, '2025-03-17 08:58:50', NULL, 5),
(37, 'CiYjgA9AYmv', '600 MCM THHN/THWN-2 Stranded Copper, White, Cut to Length', '237933', '600 MCM, THHN/THWN-2, Stranded Copper, 600V, White, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image-4_1.jpg', '', 0, 1, '2025-03-17 08:59:36', NULL, 5),
(39, 'udWngfhTQD3', '600 MCM THHN/THWN-2 Stranded Copper, Red, Cut to Length', '237932', '600 MCM, THHN/THWN-2, Stranded Copper, 600V, Red, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image-3_1.jpg', '', 1, 1, '2025-03-17 09:21:33', NULL, 5),
(40, 'eksFLN52Ua9', '12 AWG THHN/THWN-2 Stranded Copper, White, 500\'', '68976', '12 AWG, THHN/THWN-2, Stranded Copper, 600V, White, 500 ft. Reel.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'white-cable_1.jpg', '', 1, 1, '2025-03-17 09:23:08', NULL, 5),
(41, 'M03BkZ-IMLI', '500 MCM XHHW Stranded Aluminum, Blue, Cut to Length', '1288288', '500 XHHW Stranded Aluminum, Blue, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.', NULL, 'image-22_2.jpg', '', 0, 1, '2025-03-17 09:24:23', NULL, 5),
(42, 'GoQIARdNrux', '500 MCM XHHW Stranded Aluminum, Red, Cut to Length', '1288292', 'Building Wire, Type XHHW, 500 MCM, Aluminum, Stranded, Red, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.', NULL, 'image-10_3.jpg', '', 1, 1, '2025-03-17 09:26:02', NULL, 5),
(43, 'pm-J--rOmDs', '500 MCM XHHW Stranded Aluminum, Black, Cut to Length', '121156', 'Building Wire, Type XHHW, 500 MCM, Aluminum, Stranded, Black, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.', NULL, 'image-8_4.jpg', '', 0, 1, '2025-03-17 09:28:49', NULL, 5),
(44, 'oCwYQJB1BWf', '500 MCM XHHW Stranded Aluminum, White, Cut to Length', '1288293', '500 MCM XHHW Stranded Aluminum, White, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.', NULL, 'image-11_4.jpg', '', 0, 1, '2025-03-17 09:29:46', NULL, 5),
(45, 'VkeE866lzKy', 'Wiring Trough, Type 3R, Screw Cover, 12\" x 12\" x 96\", Gray, No KOs', '5065', 'Wiring Trough, Type 3R, Rainproof, Screw Cover, 14 Gauge Steel, Painted ANSI 61 Gray Acrylic Electrocoat Finish, Size: 12 Inches Width, 12 Inches Depth, 8 Feet Length, No Knockouts\r\nWiring Trough, Type 3R, Rainproof, Screw Cover, 14 Gauge Steel, Painted ANSI 61 Gray Acrylic Electrocoat Finish, Size: 12 Inches Width, 12 Inches Depth, 8 Feet Length, No Knockouts', NULL, 'image-2_1.jpg', '', 0, 1, '2025-03-17 09:31:35', NULL, 3),
(46, 'xsJI3olWef2', 'Electronic Control, 365/7-Day Astronomic', '919541', 'Electronic Control, 365/7-Day Astronomic, 2 Circuits, 120-277 Volts AC, Switch Type: SPST, 120-277V, 30A, Indoor/Outdoor Type 3R, Plastic Enclosure', NULL, 'imtet2825c.jpg', '', 1, 1, '2025-03-17 09:34:56', NULL, 9),
(47, 'wtWJB6dx2pc', 'Wiring Trough, 3R, 14x14x116', '87512', 'Wiring Trough, NEMA Type 3R, Material: Steel, Dimensions: 14\" x 14\" x 116\"', NULL, 'hofa6648rt.jpg', '', 0, 1, '2025-03-17 09:36:58', NULL, 3),
(48, 'pfOvfal0jIG', 'Ground Rod, 5/8\" x 10\', Sectional, Copper', '331130', 'Ground Rod, Diameter 5/8 Inch, Length 10 Foot, Sectional, Copper\r\nGalvanâ€™s copper coated rods have a heavy, uniform coating of copper metallurgically bonded to a rigid steel core.', NULL, 'image-1.jpg', '', 1, 1, '2025-03-17 09:38:32', NULL, 6),
(49, '-5zlJQe4CT6', '3/0 AWG THHN/THWN-2 Stranded Copper, Black, Cut to Length', '258098', '3/0 AWG, THHN/THWN-2, Stranded Copper, 600V, Black, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image.jpg', '', 1, 1, '2025-03-17 09:39:59', NULL, 5),
(50, 'w8TlVH_3G6g', '12/2 w/Ground, MC, Aluminum Armor, Solid', '63967', '12/2 Copper Conductors with Ground, 600V, Interlocked Aluminum Armor, Solid, 1000 ft. Reel. Wire Colors (120 Volt): Black, White, Green. O.D.: .460\"\r\nType MC Steel Metal Clad Cable is a traditional Type MC cable containing one or more copper grounding conductors; the armor is not an equipment grounding means.', NULL, 'image-37.jpg', '', 0, 1, '2025-03-17 09:51:47', NULL, 5),
(51, '2S8y-01LvSR', 'PRX, Main Circuit Breaker Kit, PDD33G, 400A, 240VAC, 65kAIC', '1829511', 'PRX, Main Circuit Breaker Kit, PDD33G, Breaker Type, 240 Volt AC, 65KAIC, 400 Amp\r\nPower panelboards can be a critical part of the complete small project or light commercial (LCOM) job. Pow-R-Xpress (PRX) distributors have access to additional support capabilities through Eatonâ€™s satellite network where the PRX distributor will be able to provide a complete package including power panelboards.', NULL, 'bkd3g400.jpg', '', 0, 1, '2025-03-17 09:53:55', NULL, 8),
(52, 'Uw8qxeRH6Gs', '3/0 AWG THHN/THWN-2 Stranded Copper, Blue, Cut to Length', '258113', '3/0 AWG, THHN/THWN-2, Stranded Copper, 600V, Blue, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image-14_3.jpg', '', 0, 1, '2025-03-17 09:57:14', NULL, 5),
(53, '3UE_lUvEUom', '3/0 AWG THHN/THWN-2 Stranded Copper, Red, Cut to Length', '258128', '3/0 AWG, THHN/THWN-2, Stranded Copper, 600V, Red, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image-29_6.jpg', '', 0, 1, '2025-03-17 09:59:05', NULL, 5),
(54, 'zN8oI2TrgJA', 'Wiring Trough, Type 3R, Screw Cover, 12\" x 12\" x 72\", Gray, No KOs', '147335', 'Wiring Trough, Type 3R, Rainproof, Screw Cover, 14 Gauge Steel, Painted ANSI 61 Gray Acrylic Electrocoat Finish, Size: 12 Inches Width, 12 Inches Depth, 6 Feet Length, No Knockouts\r\nWiring Trough, Type 3R, Rainproof, Screw Cover, 14 Gauge Steel, Painted ANSI 61 Gray Acrylic Electrocoat Finish, Size: 12 Inches Width, 12 Inches Depth, 6 Feet Length, No Knockouts', NULL, 'image-30_1.jpg', '', 0, 1, '2025-03-17 10:00:20', NULL, 3),
(55, 'jj0Ozns-L5l', '3/0 AWG THHN/THWN-2 Stranded Copper, White, Cut to Length', '258143', '3/0 AWG, THHN/THWN-2, Stranded Copper, 600V, White, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, '10usecstrwhix500_1.jpg', '', 0, 1, '2025-03-17 10:01:30', NULL, 5),
(56, 'aNQmJjwM8-z', '12 AWG THHN/THWN-2 Stranded Copper, Red, 500\'', '68835', '12 AWG, THHN/THWN-2, Stranded Copper, 600V, Red, 500 ft. Reel.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image-29_5.jpg', '', 0, 1, '2025-03-17 10:02:37', NULL, 5),
(57, '0T1OR_UFkPQ', '12 AWG THHN/THWN-2 Stranded Copper, Green, 500\'', '68955', '12 AWG, THHN/THWN-2, Stranded Copper, 600V, Green, 500 ft. Reel\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, '12thhncstrgrex500_6.jpg', '', 0, 1, '2025-03-17 10:03:41', NULL, 5),
(58, 'eScG6qnpyAJ', '10 AWG THHN/THWN-2 Stranded Copper, Green 500\'', '68536', '10 AWG, THHN/THWN-2, Stranded Copper, 600V, Green, 500 Foot Reel\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, '12thhncstrgrex500_5.jpg', '', 0, 1, '2025-03-17 10:04:36', NULL, 5),
(59, 'v9Rxfx5kPoJ', 'MC/AC Cable Connector, Snap-In, 3/8\", Insulated, Zinc Die Cast', '57695', '3/8 inch, Snap-Tite Insulated Throat Zinc Die-Cast Connector - For AC/MC Cable Range .405 to .612\r\nArlingtonâ€™s SNAP2IT connectors are designed for safe and fast installations of flex, MC, AC, and HCF cable â€“ and cover the widest cable ranges in the industry. They save time too â€“ about 17 seconds per fitting. Just snap the fitting onto the cable, then into the electrical box. No tools are required for the installation. For easier insertion of larger cables or for overlapping cable ranges, use the larger 40AST or 50AST fittings', NULL, 'arl38ast.jpg', '', 0, 1, '2025-03-17 10:07:30', NULL, 10),
(60, 'wQhP4o4vuyR', 'AC/MC/Flex Connector, Duplex, Saddle Type, 3/8\", Zinc Die Cast', '57042', 'AC/MC/Flex Connector, Duplex, Saddle Type, 3/8 Inch, Insulated, Diameter .445 - .612 Inch, Zinc Die Cast\r\nArlington\'s Snap-Tite connectors are for use aluminum and steel Flex â€¢ AC â€¢ AC90 â€¢ MCI â€¢ MCI-A cable.', NULL, 'image-36.jpg', '', 0, 1, '2025-03-17 10:08:28', NULL, 10),
(61, 'tpt-ySuUsWc', '1\" PVC Conduit, 10\' Length, Schedule 40, Gray, Bell End', '43232', '1 Inch PVC Conduit, 10 Foot Length, Schedule 40, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.', NULL, '1p_9.jpg', '', 0, 1, '2025-03-17 10:09:19', NULL, 3),
(63, 'IyJ7mqdgw0W', '1\" PVC Conduit, 20\' Length, Schedule 40, Gray, Bell End', '43272', '1 Inch PVC Conduit, 20 Foot Length, Schedule 40, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.', NULL, '1p_8.jpg', '', 0, 1, '2025-03-17 10:10:40', NULL, 3),
(64, 'RGHR5Ow3R4_', '8 AWG THHN/THWN-2 Stranded Copper, Black, Cut to Length', '445249', '8 AWG, THHN/THWN-2, Stranded Copper, 600V, Black, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image-5_7.jpg', '', 0, 1, '2025-03-17 10:12:13', NULL, 5),
(65, '1cvkCpA237I', '3/4\" PVC Conduit, 10\' Length, Schedule 40, Gray, Bell End', '43293', '3/4 Inch PVC Conduit, 10 Foot Length, Schedule 40, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.', NULL, '1p_7.jpg', '', 0, 1, '2025-03-17 10:38:23', NULL, 3),
(66, 'hx1w2mWWeTe', 'Fuse, 200A, Class RK5, Dual-Element Time-Delay, 250VAC', '46535', '200 Amp, Class RK5, Dual-Element, Time-Delay Fuse, 250 Volt AC, Current-Limiting, Provides Motor Overload, Ground Fault and Short-Circuit Protection\r\nFRN-R, Class RK5 Fusetronâ„¢ energy efficient, dual-element, time-delay fuses Dual-element, time-delay Class RK5 fuses. FRN-R â€” 10 seconds (minimum) at 500% rated amps (8 seconds for 0-30 A sizes).&nbsp;FRN-R available with optional indication on select ratings (see catalog numbers table). For superior electrical protection, Eaton recommends upgrading to Bussmann series Low-Peak LPN-RK fuses', NULL, 'cutfrn-r-100image_1.jpg', '', 0, 1, '2025-03-17 10:39:57', NULL, 8),
(67, 'jLvfaKoLuJT', '8 AWG THHN/THWN-2 Stranded Copper, Black, 500\'', '94584', '8 AWG, THHN/THWN-2, Stranded Copper, 600V, Black, 500 ft. Reel.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image-5_6.jpg', '', 0, 1, '2025-03-17 10:41:22', NULL, 5),
(68, 'Syrz1eawD9Z', '12 AWG THHN/THWN-2 Stranded Copper, Blue, 500\'', '68197', '12 AWG, THHN/THWN-2, Stranded Copper, 600V, Blue, 500 ft. Reel.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image-14_2.jpg', '', 0, 1, '2025-03-17 10:43:41', NULL, 5),
(69, '_Lo9nFTrYxV', 'Tamper/Weather Resistant GFCI Receptacle, 20A, 125V, White', '851523', '20 Amp, 125 Volt Receptacle, 20 Amp Feed-Through, Self Testing, SmartLock Pro Slim Weather & Tamper-Resistant GFCI, Monochromatic, Back & Side Wired, Wallplate Sold Separately - White\r\nSelf-Test Tamper Resistant, Weather Resistant GFCI Receptacle. Nema 5-20R 20A-125V At Receptacle, 20A-125V Feed-through - White With White Test And Reset Buttons', NULL, 'levgfwt2gy.jpg', '', 0, 1, '2025-03-17 10:46:27', NULL, 11),
(70, 'hjiLPMdklEu', '8 AWG THHN/THWN-2 Stranded Copper, Red, 1000\'', '69299', '8 AWG, THHN/THWN-2, Stranded Copper, 600V, Red, 1000 ft. Reel.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image-29_4.jpg', '', 0, 1, '2025-03-17 10:48:38', NULL, 5),
(71, 'fFUBHCqpz4C', 'TALON 13J RING SPTCVR CT SKT ST PROGRESS', '330119', '13J RING SPTCVR CT SKT ST PROGRESS ENERG\r\nTalon has been the standard for quality and innovation for meter mounting equipment for over half a century. The basic design of our sockets has not changed since inception, making Talon a solid, time-proven design. The residential socket line continues to grow daily as we continuously add or update our products for an ever-changing market.', NULL, 'sie9837-0424image.jpg', '', 0, 1, '2025-03-17 10:50:28', NULL, 8),
(72, 'HdeMlDQ7b9W', 'AC/Flex Connector, Saddle Type, 3/8\", Zinc Die Cast', '57970', 'AC/Flex Connector, Saddle Type, 3/8 Inch, Cable Range .405 - .612, Zinc Die Cast\r\nArlington saddle grip connectors for use with aluminum and steel Flex, AC/MC cable.', NULL, 'arlsg38.jpg', '', 0, 1, '2025-03-17 11:13:31', NULL, 10),
(73, 'hpwFtVJeH_W', '10 AWG THHN/THWN-2 Stranded Copper, White, 500\'', '68731', '10 AWG, THHN/THWN-2, Stranded Copper, 600V, White, 500 ft. Reel.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, '10usecstrwhix500.jpg', '', 0, 1, '2025-03-17 11:15:55', NULL, 5),
(74, 'KMaPxaSAWid', '10 AWG THHN/THWN-2 Stranded Copper, Black, 500\'', '68873', '10 AWG, THHN/THWN-2, Stranded Copper, 600V, Black, 500 ft. Reel.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.', NULL, 'image-5_5.jpg', '', 0, 1, '2025-03-17 11:19:04', NULL, 5),
(75, 'if5m9hFFSx9', 'Safety Switch, 200A, 3P, 240VAC/250VDC, Type DH, Fusible, NEMA 1', '91124', '200 AMP, 3-Pole, Heavy Duty Safety Switch, Fusible with Neutral, 240 VAC, 250 VDC, NEMA 1. Uses: FLNR Series Fuses. Enclosure Dims: H: 25.25\", W: 16.00\", D: 6.14\".\r\nEatonâ€™s heavy-duty safety switches with enhanced visible blade provide a highly visible means of disconnect to help improve personnel safety and equipment protection. Additionally, theyâ€™re ideal for applications where reliable performance, safety, and service continuity are critical.&nbsp;Safety switches with enhanced visible blade are available in standard switch construction (with solid front door) or with an optional viewing window (as shown here).', NULL, 'image-35.jpg', '', 0, 1, '2025-03-18 08:36:31', NULL, 8),
(76, 't0dLfcCdoDZ', '6 AWG THHN/THWN-2 Stranded Copper, Black, Cut to Length', '682523', '6 AWG, THHN/THWN-2, Stranded Copper, 600V, Black, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\nAlso known as: THHN6STRBLK-CUT, 6 thhn', NULL, 'image-5_4.jpg', '', 0, 1, '2025-03-18 08:38:48', NULL, 5),
(77, 'OcQa69YBsgk', '4\" Square Box, Welded, 2-1/8\" Depth, 1/2 and 3/4\" Knockouts, Steel', '36229', '4 Inch Square Box With Raised Ground, Welded, 2-1/8 Inch Depth, Side Knockouts: (8) 1/2 Inch, (4) 1/2 and 3/4 Inch, Bottom Knockouts: (2) 1/2 Inch, (2) 1/2 and 3/4 Inch, 30.300 Cubic Inches, Steel\r\nRaco\'s selection of 4 inch square boxes are ideal for electrical installations in residential, commercial, and industrial settings. Available in various depths and made from durable steel in drawn or welded construction, these boxes ensure longevity and safety. Perfect for new constructions, renovations, or upgrades, our 4-inch square boxes and covers provide reliability and flexibility for a secure and efficient electrical system.\r\nAlso known as: 050169902325, 232, special deep, Combo box, mounting box, Hub box, 52171k, 4 square box, hotbox, deep 1900, 1900 box, 4 square, metal cut in box, Doctor, mig, 5A052, 4sq Deep Combo, deep 1900 box, 42 deep, 4s deep, box12, metal box, 4\" junction box, 4 square JB, madtest, 1900 deep, 4/S, 4SQ DEEP COMBO BOX, 1900 Deep Combo, 4s deep special', NULL, 'raco232prodimage45deg1200.jpg', '', 1, 1, '2025-03-18 08:40:34', NULL, 4),
(78, 'i4I8OjnSz4a', '3-1/2\" PVC Conduit, 10\' Length, Schedule 80, Gray, Bell End', '34854', '3-1/2 Inch PVC Conduit, 10 Foot Length, Schedule 80, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.\r\nAlso known as: 091111031410, 35080', NULL, '34p.jpg', '', 1, 1, '2025-03-18 08:42:30', NULL, 3),
(79, 'LS4hRkEkqdu', '4\" PVC Conduit, 10\' Length, Schedule 40, Gray, Bell End', '43526', '4 Inch PVC Conduit, 10 Foot Length, Schedule 40, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.\r\nAlso known as: 670648235074, 400', NULL, '1p_6.jpg', '', 0, 1, '2025-03-18 08:43:57', NULL, 3),
(80, 'ii9_RT02vJK', 'Safety Switch, 100A, 3P, 240V, Type DG, Fusible, NEMA 3R', '59453', '100 AMP, 3-Pole, General Duty Safety Switch, Cartridge Fuse Type, Fusible with Neutral, 240 VAC, NEMA 3R. Uses: FLNR Series Fuses. Enclosure Dims: H: 19.25\", W: 9.13\", D: 4.23\".\r\nEaton General Duty Cartridge Fuse Safety Switch, 100A, 240V, 3 -pole, 4 -wire, Fusible with neutral, NEMA 3R, Painted galvanized steEl, Class H fuses\r\nAlso known as: 782113144351, DG323NRB, Disco, Fusible disconnect', NULL, 'image-34.jpg', '', 0, 1, '2025-03-18 08:45:42', NULL, 8),
(81, '5_baoA-Gs2k', 'Cable Support, Hammer-On, For Metal and Wood Studs', '19717', 'Colorado Jim Cable Support to Metal or Wood Studs, Hammer-On, Accommodates Up To 6 Conductors, 6-2 With Ground to 14-2 AWG, For Use With Non-Metallic Sheathed Cable or Metal Clad Cable, Includes Easy Locking Tabs, Cable Locating Ribs To Maintain Cable Separation, and Flared Edges for Cable Protection\r\nEasy-to-use locking tab Cable locating ribs to maintain cable separation Flared edges for cable protection NECÂ® 300.4D applicable For wood or metal stud\r\nAlso known as: 782856504061, CJ6, Catcus Jacks, CJâ€™s, Colorado jim, billings jim, chicago jim, Colorado jims, Colorado strap, slim jim, Tacoma Jay, Cj 6, Slim jims', NULL, 'ph19646g.jpg', '', 0, 1, '2025-03-18 08:48:34', NULL, 6),
(82, 'lO63u2WU0f7', '6 AWG THHN/THWN-2 Stranded Copper, Black, 500\'', '94553', '6 AWG, THHN/THWN-2, Stranded Copper, 600V, Black, 500 ft. Reel.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\nAlso known as: 048243231539, THHN6STRBLK500RL', NULL, 'image-5_3.jpg', '', 0, 1, '2025-03-18 09:10:58', NULL, 5),
(83, 'CDrDbiDKV9c', '8 AWG THHN/THWN-2 Stranded Copper, Red, Cut to Length', '1259482', '8 AWG, THHN/THWN-2, Stranded Copper, 600V, Red, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\nAlso known as: THHN8STRRED-CUT', NULL, 'image-29_3.jpg', '', 0, 1, '2025-03-18 09:12:32', NULL, 5),
(84, 'U3-yamFJ3qW', '8 AWG THHN/THWN-2 Stranded Copper, Blue, Cut to Length', '1259478', '8 AWG, THHN/THWN-2, Stranded Copper, 600V, Blue, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\nAlso known as: THHN8STRBLU-CUT', NULL, 'image-14_1.jpg', '', 0, 1, '2025-03-18 09:13:58', NULL, 5),
(85, 'w6CBqB29JEh', '3\" PVC 90Â° Elbow, Schedule 40, Gray', '42318', '3 Inch PVC 90 Degree Elbow, Schedule 40, Gray\r\nThe PVC elbow allows a degree change in direction to assist turning corners in a pipeline. During installation solvent cement will be required in the two elbow sockets to bond the pipes to the elbow fitting.\r\nAlso known as: 980060060483, 30090ELB, sweep', NULL, '3p90.jpg', '', 1, 1, '2025-03-18 09:17:14', NULL, 12),
(86, '2xwxBMpk-sF', '1 AWG XHHW Stranded Aluminum, Black, Cut to Length', '1259375', '1 XHHW Stranded Aluminum, Black, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.\r\nAlso known as: XHHW1STRBLK-CUT', NULL, 'image-8_3.jpg', '', 0, 1, '2025-03-18 09:18:42', NULL, 5),
(87, 'wcK4MsZtT6c', '30.5 mm, Control Station, Break Glass Station, Red Enclosure, 1NC', '235436', '30.5 mm, Heavy-Duty, Assembled, Control Station, Die Cast, 1 Element, Break Glass, Station, 1 Normally Closed, Logic Level, Contact, EMERG. OFF, Red Enclosure, NEMA Type 4, 4X,12, 13\r\nEaton\'s 10250T line of 30.5 mmÂ  pushbuttons Â features a heavy-duty zinc die-cast construction. Reliability nibs improve contact reliability even under dry circuit and fine dust conditions. In addition, drainage holes prevent the buildup of liquid inside the operator, which can prevent operation in freezing environments.Â  The versatileÂ 10250T line offers theÂ largest breadth of functionality options in the industry using a single metal operator housing. The portfolioâ€™sÂ heavy-duty, water- and oil-tight 30.5 mm pushbuttons are an excellent choice for applications where reliability and durability areÂ required.\r\nAlso known as: 782113137650, 10250TGR', NULL, 'image-33.jpg', '', 0, 1, '2025-03-18 09:20:38', NULL, 13),
(88, 'Uf4HMhlSP_c', '8 AWG THHN/THWN-2 Stranded Copper, Red, 500\'', '94585', '8 AWG, THHN/THWN-2, Stranded Copper, 600V, Red, 500 ft. Reel.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\nAlso known as: 048243231201, THHN8STRRED500RL', NULL, 'image-29_2.jpg', '', 0, 1, '2025-03-18 09:22:44', NULL, 5),
(89, 'cK6A3iRrPVz', '400 XHHW-2 Stranded Aluminum Black, Cut to Length', '1259876', '400 MCM, XHHW-2, Compact Stranded Aluminum, 600V, Black, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.\r\nAlso known as: XHHW400STRBLK-CUT', NULL, 'image-8_2.jpg', '', 0, 1, '2025-03-18 09:25:11', NULL, 5),
(90, 'Guqr3rd0Gq1', '400 MCM XHHW Stranded Aluminum, Blue, Cut to Length', '1288279', '400 MCM XHHW Stranded Aluminum, Blue, Cut to Length\r\nXHHW is a multi-purpose electrical wire with cross-linked high heat water-resistant insulation. The most common applications include raceways for branch circuit wiring, conduits, services, and feeders. It is also used as a building wire.\r\nAlso known as: XHHW400STRBLU-CUT', NULL, 'image-22_1.jpg', '', 0, 1, '2025-03-18 09:26:50', NULL, 5),
(91, 'ex1jwNwzgt3', '400 XHHW Stranded Aluminum, Red, Cut to Length', '1288284', '400 MCM XHHW Stranded Aluminum, Red, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.\r\nAlso known as: XHHW400STRRED-CUT', NULL, 'Aluminio-red-cable_1.jpg', '', 0, 1, '2025-03-18 09:29:35', NULL, 5),
(92, 'FiR4ZZRQ6cU', '400 XHHW Stranded Aluminum, White, Cut to Length', '1288285', '400 MCM XHHW Stranded Aluminum, White, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.\r\nAlso known as: XHHW400STRWHT-CUT', NULL, 'image-11_3.jpg', '', 0, 1, '2025-03-18 09:31:44', NULL, 5),
(93, '9WkiYfOlSnK', '2\" PVC 90Â° Elbow, 36\" Radius, Schedule 40, Gray', '41796', '2 Inch PVC 90 Degree Sweep Elbow, 36 Inch Radius, Schedule 40, Gray\r\nThe PVC street elbows have 90Â°, 45Â° and 22.5Â° bends. They can be used for water supply, drainage, sewers, vents, central vacuum systems, compressed air and gas lines, HVAC, sewage pump drains, and any location where pipe fittings are used to connect pipe sections.\r\nAlso known as: 980060067185, 2009036ELB, Sweep, Elbow, bend', NULL, 'image-13_4.jpg', '', 0, 1, '2025-03-18 09:33:30', NULL, 12),
(94, '7S1xZV9c597', 'Fuse, 400 Amp, Class RK5, Dual-Element, Time-Delay, 250V AC/DC', '1139', '400 Amp Class RK5 Dual-Element Time-Delay Fuse, 250V, Current-Limiting, Provides motor overload, ground fault and short-circuit protection\r\nFRN-R, Class RK5 Fusetronâ„¢ energy efficient, dual-element, time-delay fuses Dual-element, time-delay Class RK5 fuses. FRN-R â€” 10 seconds (minimum) at 500% rated amps (8 seconds for 0-30 A sizes).&nbsp;FRN-R available with optional indication on select ratings (see catalog numbers table). For superior electrical protection, Eaton recommends upgrading to Bussmann series Low-Peak LPN-RK fuses\r\nAlso known as: 051712507530, FRN-R-400', NULL, 'busfrsr225image_1.jpg', '', 0, 1, '2025-03-18 09:35:06', NULL, 8),
(95, 'a8zfDAEtQPl', 'Shallow Strut, Elongated Holes, Steel, Pre-Galvanized, 1-5/8\" x 13/16\" x 10\'', '69130', 'Shallow Strut, Elongated Holes On Back, 13/16\" Height, 1-5/8\" Width, Pre-Galvanized Steel, 14 Gauge, Sold In Multiples of 10 Ft.\r\nChannel - Elongated Holes, Steel, Pre-Galvanized, 1-5/8\" x 13/16\" x 10\'\r\nAlso known as: 702316501546, PS-500-EH-10-PG, bee-line, Unistrut, A strut, Kindorf, Uni-strut, Shallow, shallow strut', NULL, 'ps-500-eh-10-pg.jpg', '', 0, 1, '2025-03-18 09:37:43', NULL, 3),
(96, '2rGkD7Pj26L', 'Fuse Adapter Kit, 200A, 240-600V, Type R', '87218', 'R Fuse Adapter Kit for 200 Amp, 240 - 600V, General Duty, Heavy Duty and Double Throw Safety Switches. Order (1) Kit for 3 Poles and (2) Kits for Double Throw\r\nEatonâ€™s heavy-duty safety switches with enhanced visible blade provide a highly visible means of disconnect to help improve personnel safety and equipment protection. Additionally, theyâ€™re ideal for applications where reliable performance, safety, and service continuity are critical.&amp;nbsp;Safety switches with enhanced visible blade are available in standard switch construction (with solid front door) or with an optional viewing window\r\nAlso known as: 782113207728, DS46FK', NULL, 'ds46fk.jpg', '', 0, 1, '2025-03-18 09:40:38', NULL, 8),
(97, 'za49BaMd1hb', '2\" PVC Conduit, 10\' Length, Schedule 40, Gray, Bell End', '43435', '2 Inch PVC Conduit, 10 Foot Length, Schedule 40, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.\r\nAlso known as: 670648234893, 200, 2â€™ electrical conduits , Electric conduit, pipe, electrical conduit, pvc', NULL, '1p_5.jpg', '', 0, 1, '2025-03-18 09:41:25', NULL, 3),
(98, 'Pwuoz5P7JCY', '3\" EMT Conduit, Steel, 10\' Length', '48991', '3 Inch EMT Conduit, Steel, 10 Foot Length\r\nEMT is also called \"thin-wall\" conduit because it is thin and lightweight, especially compared to RMC. EMT is rigid but can be bent with a simple tool called a conduit bender. EMT is installed with couplings and fittings that are secured with setscrew or compression-type fasteners.\r\nAlso known as: 091111020087, 300, Runway, Peter piper, stick', NULL, '34e.jpg', '', 0, 1, '2025-03-18 09:42:51', NULL, 3),
(99, 'k6tPvf3u1NK', 'Fuse, 600 Amp, Class RK5, Dual-Element, Time-Delay, 250V', '1126', 'Eaton Bussmann series FRN-R fuse, 250 Vac, 125 Vdc, 600A, 200 kAIC at 250 Vac, 20 kAIC at 125 Vdc, Non Indicating, Current-limiting, time delay, Blade end X blade end, Class RK5\r\nBussmann\'s UL Class RK5 Fusetron product offering provides energy efficient advanced protection with its dual-element, time-delay construction and is available with optional open fuse indication on select ratings. Available in both 250Vac and 600Vac, 200kA RMS Sym interrupting rating and sizes ranging from 0 to 600 amp. Fusetron\'s deliver 10 seconds (minimum) of time-delay at 500% of rated current (8 seconds for 1/10-30A sizes).\r\nAlso known as: 051712507561, FRN-R-600', NULL, 'busfrsr225image.jpg', '', 0, 1, '2025-03-18 09:43:48', NULL, 8),
(100, 'gKo6__Cz3xQ', 'Telescoping Screw Gun Bracket, 15-3/4 to 25\" Studs', '310634', 'Telescoping Screw Gun Bracket 15- 3/4\" to 25\" Stud Spacing. Standard Package Quantity: 50.\r\nCan mount multiple boxes Notched and marked for easy identification and bending Improved design with stamped inch markings and pilot holes accelerates precise box conduit mounting between studs Pilot holes allow easy box attachment with a screwdriver Requires only a screw gun to install Can be mounted to face or inside of stud Adjustable for non-standard stud spacing Interlocking tab prevents accidental disassembly Unique, one-piece, break apart design Reduces movement of the box when used with flexible conduit, ENT, MC, AC or non-metallic sheathed cable\r\nAlso known as: 782856679677, TSGB1624, Brady Bar, Helecopter brackets, Steel fish, spanner bar, spredder bar, spreader bar, sliding bracket', NULL, 'ph3008g-1.jpg', '', 0, 1, '2025-03-18 09:44:47', NULL, 6),
(101, 'BkcaFY7oNpp', '12/2 HCF Aluminum Armored Cable, 250\'', '64618', 'Healthcare Facilities Cable, Aluminum Flex, 12 AWG, 2 Conductors, Solid, Copper, 16 AWG Integral Bond, 250 Foot Coil\r\nType MC Steel Metal Clad Cable is a traditional Type MC cable containing one or more copper grounding conductors; the armor is not an equipment grounding means.\r\nAlso known as: 980100348052, ACHCFAL122SOL250CL', NULL, 'image-32.jpg', '', 0, 1, '2025-03-18 09:46:30', NULL, 5),
(102, 'Ir4cy_PbHDk', '12 AWG THHN/THWN-2 Solid Copper, White, 500\'', '94542', '12 AWG, THHN/THWN-2, Solid Copper, 600V, White, 500 foot Spool.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\nAlso known as: 048243224104, THHN12SOLWHT500RL', NULL, 'image-31.jpg', '', 0, 1, '2025-03-18 09:49:06', NULL, 5),
(103, '3_u3ibzTp0J', '3-1/2\" PVC 90Â° Elbow, Schedule 40, Gray', '42260', '3-1/2 Inch PVC 90 Degree Elbow, Schedule 40, Gray\r\nThe PVC elbow allows a degree change in direction to assist turning corners in a pipeline. During installation solvent cement will be required in the two elbow sockets to bond the pipes to the elbow fitting.\r\nAlso known as: 980060060490, 35090ELB', NULL, 'image-13_3.jpg', '', 0, 1, '2025-03-18 09:50:10', NULL, 12),
(104, 'Qy3FgeqHiVW', 'Safety Switch, 30A, 3P, 240V, Type DG, Non-Fusible, NEMA 3R', '58905', '30 AMP, 3-Pole, General Duty Safety Switch, Non-Fusible, 240 VAC, NEMA 3R. Enclosure Dims: H: 10.81\", W: 6.38\", D: 3.75\".\r\nGeneral duty safety switches are used in residential and commercial applications. They are suitable for light duty motor circuits and service entrance applications. Fusible (plug or cartidge) and non-fusible switches are available.\r\nAlso known as: 782113120287, DG321URB, Disconnect, External disconnect', NULL, 'cutdg321urb.jpg', '', 0, 1, '2025-03-18 09:51:22', NULL, 8),
(105, 'Cm0lBoA_PUk', 'Wiring Trough, Type 3R, Screw Cover, 10\" x 10\" x 96\", Gray, No KOs', '177410', 'Wiring Trough, Type 3R, Rainproof, Screw Cover, 14 Gauge Steel, Painted ANSI 61 Gray Acrylic Electrocoat Finish, Size: 10 Inches Width, 10 Inches Depth, 8 Feet Length, No Knockouts\r\nWiring Trough, Type 3R, Rainproof, Screw Cover, 14 Gauge Steel, Painted ANSI 61 Gray Acrylic Electrocoat Finish, Size: 10 Inches Width, 10 Inches Depth, 8 Feet Length, No Knockouts\r\nAlso known as: 783510133429, A101096RT', NULL, 'image-30.jpg', '', 0, 1, '2025-03-18 09:52:37', NULL, 3),
(106, 'zZnAmTZn1Kj', '20A, 1P, 120/240V, Type BAB, 10 kAlC, Bolt On', '9264', '20 Amp, 1-Pole, Miniature Industrial Circuit Breaker, Type BAB, Quicklag, Bolt-On, 10 kAIC, 120/240 VAC\r\nBAB bolt-on miniature circuit breakers. Eatonâ€™s bolt-on miniature circuit breakers (Quicklag) provide superior protection in panelboards,&nbsp;and offer easy installation. They are also switching duty rated for 120 VAC fluorescent light applications, and UL 489 listed. All products 15â€“100A are HACR rated.&nbsp;Select from one-, two-, or three-pole designs.\r\nAlso known as: 786679301203, BAB1020, gym light breaker', NULL, 'cutbab1020.jpg', '', 0, 1, '2025-03-18 09:53:51', NULL, 8),
(107, 'Ujkp7CfT-7u', '100 Amp Class RK5 Dual-Element Time-Delay Fuse, 250V', '46580', '100 Amp Class RK5 Dual-Element Time-Delay Fuse, 250V, Current-Limiting, Provides motor overload, ground fault and short-circuit protection\r\nFRN-R (250 V) and FRS-R (600 V) Class RK5 Fusetronâ„¢ energy efficient, dual-element, time-delay fuses Dual-element, time-delay Class RK5 fuses. FRN-R â€” 10 seconds (minimum) at 500% rated amps (8 seconds for 0-30 A sizes). FRS-R â€” 10 seconds (minimum) at 500% rated amps. FRN-R and FRS-R available with optional indication on select ratings (see catalog numbers table). For superior electrical protection, Eaton recommends upgrading to Bussmann series Low-Peak LPN-RK (250 V) or LPS-RK (600 V) fuses\r\nAlso known as: 051712101851, FRN-R-100', NULL, 'cutfrn-r-100image-1.jpg', '', 0, 1, '2025-03-18 09:54:56', NULL, 8),
(108, 'KIY1drgMQyH', '20A Commercial Grade Duplex Receptacle, 5-20R, White', '5469', 'Duplex Receptacle Outlet, Commercial Specification Grade, Indented Face, 20 Amp, 125 Volt, Side Wire, NEMA 5-20R, 2-Pole, 3-Wire, Self-Grounding - White\r\nLevitonâ€™s line of Heavy-Duty Specification Grade receptacles are designed and manufactured to withstand the most demanding environments. Available in a wide variety of configurations, including isolated ground, tamper-resistant, etc., these Commercial Grade devices are the electrical contractor\'s choice for use in hotels, schools, hospitals and commercial office buildings.\r\nAlso known as: 078477815458, CR20-W', NULL, 'levcr20w.jpg', '', 0, 1, '2025-03-18 09:57:35', NULL, 14),
(109, 'iq2ydTwU6e4', 'Strut Post Base, Single, 6\" X 6\" X 3-1/2\", Steel/Electro-Galvanized', '80789', 'Post Base, 4 Holes Bottom Plate, Bolt Hole Diameter 9/16 in, Material: Steel, Finish: Electro-Galvanized, Use with PS 200, 210\r\nPower-Strut, a part of Atkore, is a metal framing system that can be regarded as a basic building material. Our metal framing system is an erector set concept, using channel and fittings to solve many applications. You can conceal metal framing in the basic structure of a building or run it along the surface of walls, ceilings and floors. An endless array of fittings provide freedom to work at virtually any angle along any surface to shape a support system that fits your exact needs.\r\nAlso known as: 702316510968, PS-3033-SQ-EG, STRUT FEET', NULL, 'productsproducts560527d5-5d50-4c83-8503-aacbd2758e7a.jpg', '', 0, 1, '2025-03-18 09:59:10', NULL, 15),
(110, 'jf5MDEBRTVu', '6 AWG THHN/THWN-2 Stranded Copper, Green, Cut to Length', '682645', '6 AWG, THHN/THWN-2, Stranded Copper, 600V, Green, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\nAlso known as: THHN6STRGRN-CUT', NULL, '12thhncstrgrex500_4.jpg', '', 0, 1, '2025-03-18 10:01:04', NULL, 5),
(112, 'SSth4spiWdq', '4\" Square Cover, 1-Device, Mud Ring, 5/8\" Raised, Drawn', '27359', '4 Inch Square Cover, 1-Device, Mud Ring, 5/8 Inch Raised, Drawn, Metallic\r\nRaco has assembled one of the most complete outlet box product lines in the business. Weâ€™ve been leading in quality and selection for decades and throughout Raco\'s steel outlet box offering, you will find innovative products and solutions that save labor, cut material costs and increase productivity.\r\nAlso known as: 050169907689, 768, 58 ml mudring, p rings', NULL, 'rac768.jpg', '', 0, 1, '2025-03-18 10:03:55', NULL, 4);
INSERT INTO `post` (`id`, `short_name`, `name`, `code`, `description`, `offer_txt`, `image`, `link`, `is_featured`, `is_public`, `created_at`, `order_at`, `category_id`) VALUES
(113, 'B54FqNxPFyB', 'Non-Metallic Liquidtight, 3/4\", Gray, 100\' Coil', '96581', 'Non-Metallic Liquidtight Conduit, 3/4\", Gray, 100\' Coil, UL Listed for Outdoor Use & Sunlight Resistant\r\nLiquidtight conduits are perfect for use in environments that are likely to get moist or wet. Used in conjunction with liquid-tight fittings, conduit can keep moisture at bay.\r\nAlso known as: 980050029773, NM075100CL, kwik-flex, Poly, car flex, 34lnmf', NULL, 'image-16_2.jpg', '', 0, 1, '2025-03-18 10:04:56', NULL, 3),
(116, 'zJD9DAdfeBU', '250 MCM XHHW Stranded Aluminum, Red, Cut to Length', '1288199', '250 MCM XHHW Stranded Aluminum, Red, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.\r\nAlso known as: XHHW250STRRED-CUT', NULL, 'image-10_2.jpg', '', 0, 1, '2025-03-18 10:09:55', NULL, 5),
(117, 'HPzcLabBhea', '250 MCM XHHW Stranded Aluminum, White, Cut to Length', '1288200', '250 MCM XHHW Stranded Aluminum, White, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.\r\nAlso known as: XHHW250STRWHT-CUT', NULL, 'image-11_2.jpg', '', 0, 1, '2025-03-18 10:12:06', NULL, 5),
(118, 'cU3zvbAYn8R', '6 AWG THHN/THWN-2 Stranded Copper, Red, 500\'', '94581', '6 AWG, THHN/THWN-2, Stranded Copper, 600V, Red, 500 ft. Reel.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\nAlso known as: 048243231737, THHN6STRRED500RL', NULL, 'image-29_1.jpg', '', 0, 1, '2025-03-18 10:15:17', NULL, 5),
(119, 'SS8HCdCq0ox', '10 AWG THHN/THWN-2 Stranded Copper, Red 500\'', '68712', '10 AWG, THHN/THWN-2, Stranded Copper, 600V, Red, 500 ft. Reel.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\nAlso known as: 048243230204, THHN10STRRED500RL', NULL, 'image-29.jpg', '', 0, 1, '2025-03-18 10:16:52', NULL, 5),
(120, 'MSLJzD54rOy', '4\" PVC 90Â° Elbow, Schedule 40, Gray', '42127', '4 Inch PVC 90 Degree Elbow, Schedule 40, Gray\r\nThe PVC elbow allows a degree change in direction to assist turning corners in a pipeline. During installation solvent cement will be required in the two elbow sockets to bond the pipes to the elbow fitting.\r\nAlso known as: 980060060506, 40090ELB', NULL, 'image-13_2.jpg', '', 0, 1, '2025-03-18 10:18:02', NULL, 12),
(121, 'D-3pZZsIO6C', '3/0 AWG THHN/THWN-2 Stranded Copper, Green, Cut to Length', '1293973', '3/0 AWG, THHN/THWN-2, Stranded Copper, 600V, Green, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\nAlso known as: THHN3/0STRGRN-CUT', NULL, '12thhncstrgrex500_3.jpg', '', 0, 1, '2025-03-18 10:19:05', NULL, 5),
(122, 't6Lt3DcmHT5', '2/0 AWG THHN/THWN-2 Stranded Copper, Black, Cut to Length', '682624', '2/0 AWG, THHN/THWN-2, Stranded Copper, Black, 600V, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\nAlso known as: THHN2/0STRBLK-CUT', NULL, 'image-5_2.jpg', '', 0, 1, '2025-03-18 10:19:53', NULL, 5),
(123, 'sWONNQF1DVA', 'SO Portable Cord, 6/4, Copper, Black, Cut to Length', '1310344', 'SO Portable Cord, 6 AWG, 4 Conductor, Copper, Black, Cut to Length\r\nSO cord is a cable with multiple conductors manufactured for the purpose of electrical power connections requiring flexibility. So cord is a multi-conductor power cable that can be operated both inside and outside environments. Common applications include wiring for industrial machinery, enormous appliances, heavy-duty tools, motors, and temporary electrical power and lighting for construction sites\r\nAlso known as: SO64BLK-CUT', NULL, '1612soowx500mcr_1.jpg', '', 0, 1, '2025-03-18 10:21:26', NULL, 5),
(124, 'vBeG9SHeGrC', 'Liquidtight Connector, 3/4\", Straight, Non-Metallic', '12231', 'Liquidtight Connector, Straight, 3/4 Inch, Non-Metallic, For Use With Non-Metallic Liquidtight Type B Conduit\r\nNon Metallic straight connector for use with non metallic liquid tight conduit type B only. 3/4\" Trade Size.\r\nAlso known as: 018997547507, NMLT75, carflex connector', NULL, 'arlnmlt50_1.jpg', '', 0, 1, '2025-03-18 10:22:48', NULL, 15),
(125, 'AKkuBkqEtes', 'Fuse, 150A, Class RK5, Dual-Element Time-Delay, 250VAC', '46558', '150 Amp, Class RK5, Dual-Element, Time-Delay Fuse, 250 Volt AC, Current-Limiting, Provides Motor Overload, Ground Fault and Short-Circuit Protection\r\nFRN-R, Class RK5 Fusetronâ„¢ energy efficient, dual-element, time-delay fuses Dual-element, time-delay Class RK5 fuses. FRN-R â€” 10 seconds (minimum) at 500% rated amps (8 seconds for 0-30 A sizes).&nbsp;FRN-R available with optional indication on select ratings (see catalog numbers table). For superior electrical protection, Eaton recommends upgrading to Bussmann series Low-Peak LPN-RK fuses\r\nAlso known as: 051712101875, FRN-R-150', NULL, 'cutfrn-r-100image.jpg', '', 0, 1, '2025-03-18 10:24:43', NULL, 8),
(126, 'JqjcgkeTG_7', 'Red/Green Emergency Sign, Round Lights', '1766481', 'Red/Green Emergency Sign, Round Lights, 120-277 Volt, LED Color Switch Gives Users Easy Access To Flip Between Red & Green LED Even After Field Installation\r\nThe Lithonia Lighting BasicsTM EXRG and ECRG emergency products now bring convenience with reliability and affordability. With the option to have a low-profile round lamp heads or square lamp heads for replacement business makes the ECRG the most versatile product we offer today.\r\nAlso known as: 194994900412, ECRG-RD-M6', NULL, 'ecrg-rd.jpg', '', 0, 1, '2025-03-18 10:26:26', NULL, 9),
(127, '5Gt0jCbeSlR', 'Load Center, 125A, Main Lug, 120/208/240V, 3PH, 12/24, NEMA 3R', '104113', '125 AMP, 208Y/120V or 240V AC, 3-Phase, Main Lug Loadcenter, 12-Space, 24-Pole, Aluminum Bus, Cover: Surface, NEMA 3R - Rainproof. Includes: Hub Closure Plate. Dims: H: 21\", W: 14.31\", D: 5.19\"\r\nLoadcenters are enclosures specifically designed to house the branch circuit breakers and wiring required to distribute power to individual circuits. They contain either a main breaker when used at the service entrance point or a main lug when used as a sub-panel to add circuits to existing service. The main breaker protects the main entire panel and can be used as a service disconnect. The branch breakers protect the wires leading to individual electrical loads such as fixtures and outlets.\r\nAlso known as: 786676441452, 3BR1224L125R', NULL, 'cut3br1224l125r.jpg', '', 0, 1, '2025-03-18 10:27:21', NULL, 8),
(128, '9MePoa8QOim', 'Angled Plug, 50A, 125/250V, 14-50P', '48758', 'Angled Straight Blade Plug, 50A, 125/250V, 14-50P, 3 Pole, 4 Wire Grounding, Nylon, 4 Position, .625\" - 1.31\" Cord Range\r\nAlso known as: 783585015330, HBL9452C', NULL, 'image-28.jpg', '', 0, 1, '2025-03-18 10:28:12', NULL, 14),
(129, 'GfgELmn5Loj', 'Combination Box/Conduit Hanger, Drop Wire/Rod/Beam, 1/2\" or 3/4\"', '47602', 'Combination Box/Conduit Hangers from Drop Wire/Rod and Beam. 1/2\" or 3/4\" Conduit Plain Center Hole for Screw or Threaded Rod Mount. Standard Packaging Quantity: 25.\r\nOne assembly provides support for horizontal electrical box and/or conduit from threaded rod Eliminates need for offset bending conduit 66% less Drop Wires (rod/wire application) NECÂ® & CEC compliant\r\nAlso known as: 782856520023, 812MB18A, Bow tie, Army Guys, crab legs, Combo clamp, helicopters, helicopter clamp, Hooker , Do nothings, code pleaser, Helicopter, Code keeper, FAKE STRAPS, spider bracket, helicopter bracket, Bruce Bracket, WING DING, Break aparts, Phony Balognas, Scare Crows, ape hangers, cheater box, monkey arms, Cheater bar', NULL, 'ph34315g.jpg', '', 0, 1, '2025-03-18 10:51:11', NULL, 15),
(130, 'VHz_MrU8OSN', '4\" Octagon Box, 1-1/2\" Deep, 1/2\" Knockouts, Steel, Drawn', '24912', '4\" Octagon Box, Drawn, Metallic. Depth: 1-1/2\". Side Knockouts: (4) 1/2\". Bottom Knockouts: (4) 1/2\". Cubic Inches: 15.5\". Maximum Static Load: 50 lbs.\r\nCombination screw heads provide for faster installation â€¢ RACOÂ® offers a variety of labor saving mounting brackets that allow for easy positioning of box along studs or joists\r\nAlso known as: 050169901250, 125', NULL, 'app40spl.jpg', '', 0, 1, '2025-03-18 10:53:22', NULL, 4),
(131, 'gUjaLz4a_fR', '2-1/2\" PVC Conduit, 10\' Length, Schedule 40, Gray, Bell End', '43141', '2-1/2 Inch PVC Conduit, 10 Foot Length, Schedule 40, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.\r\nAlso known as: 670648234978, 250, 2.5â€ sched 40', NULL, '1p_4.jpg', '', 0, 1, '2025-03-18 10:54:21', NULL, 3),
(132, 'i4A0rK7wZmb', 'Fusetron Current Limiting Time Delay Fuse, 125 A, 250 VAC/125 VDC', '1191', 'Fusetron Current Limiting Time Delay Fuse, 125 A, 250 VAC/125 VDC, 200/20 kA, Class RK5, Cartridge\r\nBussmann\'s UL Class RK5 Fusetron product offering provides energy efficient advanced protection with its dual-element, time-delay construction and is available with optional open fuse indication on select ratings. Available in both 250Vac and 600Vac, 200kA RMS Sym interrupting rating and sizes ranging from 0 to 600 amp. Fusetron\'s deliver 10 seconds (minimum) of time-delay at 500% of rated current (8 seconds for 1/10-30A sizes).\r\nAlso known as: 051712507455, FRN-R-125', NULL, 'busfrn-r-80image.jpg', '', 0, 1, '2025-03-18 10:55:17', NULL, 8),
(133, 'ovpCQzx6ld0', 'Power Inlet, 50A, 125/250V, NEMA CS63-75 Inlet Receptacle', '191997', '50 Amp, 125/250V AC. Inlet Receptacle, NEMA Configuration: CS63-75, 3-Combo 1/2\" & 3/4\" KO\'s. Outdoor Use Only, Maximum Generator Input: 12.5 kW. Size: 6.25\" x 6.25\" x 4.40\".\r\nThe raintight NEMA 3R PBN Series non-metallic power inlet box is designed for use with the Pro/Tran transfer switches and Panel/Link manual transfer panels and generator-ready load centers. This power inlet box must be installed outdoors in an open area where the generator is being used. Using one of the three Â¾-inch knockouts (one each on the sides and back) the power inlet box can be wired directly to the transfer switch or panel. The patented design provides over 100 cubic inches of wiring space and the slide-out base allows easy 360Â° access to the flanged inlet.&nbsp;\r\nAlso known as: 81518101072, PBN50', NULL, 'image-27.jpg', '', 0, 1, '2025-03-18 10:56:47', NULL, 8),
(134, 'GK0gfnJISxb', 'Terminal Plug, Copper, 600 MCM, Offset, CU/AL Rated', '113891', 'Terminal Plug, Copper, 600 MCM, Offset, CU/AL Rated\r\nBurndy\'s compression pin adapter provides the shortest connector length design possible permitting easy installation in equipment with limited working space.\r\nAlso known as: 781810738504, AYPO600, Pin Connector, Pin Adapter', NULL, 'image-26.jpg', '', 0, 1, '2025-03-18 10:59:07', NULL, 6),
(135, 'YcFDtj2aDnB', 'Pro-Pullâ„¢ Measuring Pull Tape, 400 lb. Tensile Strength, 4500\' Bucket', '1852761', 'Pro-Pullâ„¢ Measuring Pull Tape, 400 lb. Tensile Strength, 4500 Foot Bucket\r\nSave time and money with Pro-Pullâ„¢ Measuring Pull Tape.Â Made from woven polyester fiber, Pro-Pullâ„¢ Measuring Pull Tape maintains softness for less hand damage than traditional polypropylene rope while minimizing stretch and maximizing abrasion resistance. Pro-Pullâ„¢ is clearly printed with tensile strength, sequential footage markings, printing dates, and lot tracing for easy product identification and peace of mind.\r\nAlso known as: 783250163595, 31-400B-45', NULL, '31400b45.jpg', '', 0, 1, '2025-03-18 11:00:23', NULL, 16),
(136, '6yjJIF-u2JF', 'Power Inlet, 30A, 125/250VAC, NEMA L14-30P, Recessed Inlet, NEMA 3R', '38864', '30 Amp, 125/250V AC. Inlet Receptacle, NEMA Configuration: L14-30P, 4-Combo 1/2\" &amp; 3/4\" KO\'s, For Outdoor Use Only, Maximum Generator Input: 7.5 kW. Size: 6.00\" x 4.00\" x 2.63\"\r\nThe raintight NEMA 3R power inlet box is designed for the use with the&nbsp;Pro/Tran&nbsp;transfer switches and Reliance&nbsp;Panel/Link&nbsp;manual transfer panels and generator-ready load centers. The power inlet box may be installed outdoors in an open area where the generator is being used. Using one of the four combination 1/2-inch and 3/4-inch knockouts (one on each side, bottom and back) the power inlet box can be wired directly to the transfer switch or panel. The exclusive patented design provides generous wiring space and facilitates rough-in. The PR Series includes circuit breakers that match the amperage of the power inlet. UL listed.The raintight NEMA 3R PBN Series non-metallic power inlet box is designed for use with the Pro/Tran transfer switches and Panel/Link manual transfer panels and gene', NULL, 'image-25.jpg', '', 0, 1, '2025-03-18 11:02:41', NULL, 8),
(137, '76CxJzlO6sj', '50A, 2P, 120/240V, Type BAB, 10 kAIC, Bolt On', '12386', '50 Amp, 2-Pole, Miniature Industrial Circuit Breaker, Type BAB, Quicklag, Bolt-On, 10 kAIC, 120/240 VAC\r\nBAB bolt-on miniature circuit breakers. Eatonâ€™s bolt-on miniature circuit breakers (Quicklag) provide superior protection in panelboards,&nbsp;and offer easy installation. They are also switching duty rated for 120 VAC fluorescent light applications, and UL 489 listed. All products 15â€“100A are HACR rated.&nbsp;Select from one-, two-, or three-pole designs.\r\nAlso known as: 786679302507, BAB2050', NULL, 'cutbab2050.jpg', '', 0, 1, '2025-03-18 11:04:40', NULL, 8),
(138, 'AjjJ0-Ivu0S', 'Power Outlet Panel, Temporary, 50A, 120/240VAC, NEMA 3R', '81021', '50 Amp, 120/240V, 1-Phase, Unmetered, Surface Mount, Top Feed, NEMA 3R Receptacles: (1) 14-50R Breakers: None\r\nPortable equipment requiring electricity continues to increase steadily in both number and variety. This creates the need for conveniently located receptacles to provide power for cord connected equipment. Midwest Electric Power Outlets provide one or more receptacles, with or without overcurrent protection, in a single enclosure, eliminating the need for several separately mounted components while providing maximum protection against weather and normal field use. Additionally, many models also include disconnecting, metering, and/or pedestal mounting functions in a single NEMA 3R enclosure/assembly\r\nAlso known as: 784567300185, U054, 50 amp RV plug, Fargobuster, 50a RV outdoor plug, WP evc receptacle', NULL, 'midu054.jpg', '', 0, 1, '2025-03-18 11:05:59', NULL, 8),
(139, 'goBeDqY-CE0', 'MC/AC/Flex Connector, 90Â°, 3/8\", Insulated, Zinc Die Cast', '57548', '3/8 inch, MC/AC/Flex Connector, 90Â°, Insulated, Zinc Die Cast, For Use With Flexible Metal Conduit/Armored Cable\r\nAlso known as: 018997801548, 850ST', NULL, 'image-24.jpg', '', 0, 1, '2025-03-18 11:07:29', NULL, 15),
(140, 'g_M5rn41zdR', 'Hub, 2\", Rainproof, Conduit/Plate', '92104', '2\" Diameter, Rainproof Conduit/Plate Type Hub for Conduit Size: 2\" (50.8 mm).\r\nField Installable Rainproof Conduit Hubs. Group 2â€”for use with 150, 200 and 225 A MLO and MCB loadcenters and circuit breaker enclosures except for the following 200 A loadcenters: BR48B200RF. Also for use with 400 and 600 A loadcenters and New York City loadcenters manufactured after November 1, 2005\r\nAlso known as: 782113109961, DS200H2, hub, Closing Hub', NULL, 'image-23.jpg', '', 0, 1, '2025-03-18 11:08:40', NULL, 8),
(141, 'eVw9Ld2cjjM', 'Deep Strut - Elongated Holes, Steel, Pre-Galvanized, 1-5/8\" x 1-5/8\" x 10\'', '69170', 'Deep Strut, Elongated Holes on Back, 1-5/8\" Height, 1-5/8\" Width, Pre-Galvanized Steel, 12 Gauge, Sold In Multiples of 10 Ft.\r\nChannel - Elongated Holes, Steel, Pre-Galvanized, 1-5/8\" x 1-5/8\" x 10\'\r\nAlso known as: 702316501027, PS-200-EH-10-PG, Deep slotted, SDEEP, thick strut, Kindorf, Tall Strut, Junior Strut, Slotted Channel, Storack, unistrut, Deep', NULL, 'pstps200eh10pgal.jpg', '', 0, 1, '2025-03-18 11:09:44', NULL, 3),
(142, 'LilRiuT0p7F', '250 MCM XHHW Stranded Aluminum, Blue, Cut to Length', '1288194', '250 MCM XHHW Stranded Aluminum, Blue, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.\r\nAlso known as: XHHW250STRBLU-CUT', NULL, 'image-22.jpg', '', 0, 1, '2025-03-19 08:55:35', NULL, 5),
(143, 'DnRQocCWIRf', '4\" Square Cover, 0-Device, Cover, No Raise, Drawn, Metallic', '35489', '4\" Square Cover, 0-Device, Cover, No Raise, Drawn, Metallic.\r\n4 in. Square Cover, Flat, Blank Angled mounting slots compensate up to 12 degrees for box misalignment\r\nAlso known as: 050169907528, 752, 4s blank, jbox blank, 4 sq blank plate, 4 square cover, 1900 BLANK, 1900 blank plate', NULL, 'rac752.jpg', '', 0, 1, '2025-03-21 09:35:43', NULL, 4),
(144, 'HwPfwUVePGQ', '2\" EMT 90Â° Elbow', '40556', 'Overview\r\n2 Inch EMT 90 Degree Elbow\r\nThe elbows are bent sections of the conduit run and used to change raceway direction or bypass the obstructions.\r\nAlso known as: 786692020266, EMT20090, Turn', NULL, '3e90_1.jpg', '', 0, 1, '2025-03-21 09:36:34', NULL, 3),
(145, 'JIS8J8Q6Be8', 'Weather-Resistant GFCI Receptacle, 20A, 125V White', '861227', '20 Amp, 125 Volt Receptacle, 20 Amp Feed-Through, Self Testing, SmartLock Pro Slim Weather-Resistant GFCI, Monochromatic, Back & Side Wired, Wallplate Sold Separately - White\r\nPeace of mind, all the time. The SmartlockPro Self-Test GFCI tests itself even if you forget. Designed to meet the latest UL standard for auto-monitoring (self-test) our complete line of self-test GFCIs periodically conduct an automatic internal test to confirm that it can respond to a ground fault. With the slimmest profile on the market, the device allows for fast and easy installation, while Levitonâ€™s patented reset lockout mechanism prevents reset of the GFCI if it is not wired or operating correctly. The SmartlockPro Self-Test GFCI is the smart choice in ground fault circuit interrupter protection.\r\nAlso known as: 078477709085, GFWR2-W', NULL, 'gfwt2-wa.jpg', '', 0, 1, '2025-03-21 09:37:40', NULL, 14),
(146, '0IECAzjNefU', 'Breaker, Bolt On, 60A, 3P, 240VAC, Type QBHW, 22 kAIC, CB', '110654', '60 Amp, 3-Pole, Miniature Industrial Circuit Breaker, Type QBHW, Quicklag, Bolt-On, 22 kAIC, 240 Volt AC\r\nEatonâ€™s low and medium-voltage circuit breakers provide premium protection for overheating wires, overloads and short circuits in residential, commercial, industrial and hazardous area applications.\r\nAlso known as: 786679393505, QBHW3060H', NULL, 'cutqbhw3060h.jpg', '', 0, 1, '2025-03-21 09:39:47', NULL, 8),
(147, 'hpBt0KTOTrv', '1-1/4\" PVC Conduit, 10\' Length, Schedule 40, Gray, Bell End', '43481', '1-1/4 Inch PVC Conduit, 10 Foot Length, Schedule 40, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.\r\nAlso known as: 670648234817, 125, schedule 40', NULL, '1p_3.jpg', '', 0, 1, '2025-03-21 09:40:48', NULL, 3),
(148, 'oPsDzGRDd3C', 'LED Lamp, T8, 4\', 12 Watt, 1800 Lumen, 5000K, 120-277V', '2003007', 'LED Lamp, T8, 4\', 12 Watt, 1800 Lumen, 5000K, 82 CRI, 120-277 Volt, Dimmable, Frosted Glass, 1 per SKU, 25 per Case *Sylvania Product Code 41453* *Sylvania Part # 41453*\r\nLEDlescent T8 Ballast-Free lamps are an energy saving alternative, designed to replace traditional fluorescent T8/T12 lamps by bypassing the existing ballast.\r\nAlso known as: 046135414534, LED12T8/L48/FG/850/BFG2', NULL, '41452.jpg', '', 0, 1, '2025-03-21 09:41:55', NULL, 17),
(149, 'unAAYjL-DYH', 'Grounding Bushing, 3-1/2\", Threaded, Insulated, Zinc', '51041', 'Grounding Bushing, 3-1/2 Inch, Threaded, Insulated, 1/0 to 14 AWG, Zinc, For Use With Rigid/IMC Conduit\r\nAlso known as: 687855139101, GBL-900', NULL, '12dcigbu.jpg', '', 0, 1, '2025-03-21 09:43:38', NULL, 15),
(150, 'J5e0WUHfBT3', 'Underground Post Section, 6 x 6 x 96\", Concrete', '475341', 'Underground Post Section, 6 x 6 x 96 Inch, (4) #3 Rebar, (3) Sides Form Finish, (1) Side Hand Trowel Finish, Concrete\r\nChristyÂ® concrete products deliver reliable, cost-effective performance. The ChristyÂ® product line offers a wide variety of sizes making it the preferred choice for many applications. You can depend on the trusted ChristyÂ® product line, delivering reliable hand holes, valve boxes, meter boxes and vaults to the utility market for over 40 years\r\nAlso known as: POST6X6X96', NULL, 'post.jpg', '', 0, 1, '2025-03-21 09:45:15', NULL, 4),
(151, 'Tg37H7yzsbM', 'Weatherproof-In-Use Cover, 1-Gang, Universal, Horizontal/Vertical, Polycorbonate, Clear', '142420', 'In-Use Cover, 1-Gang, Weatherproof, Vertical Mount, Non-Metallic, Depth: 2-3/4\". Includes Separate Insert Types: Duplex, Decorator/GFCI Receptacle, Toggle Switch and Single Receptacle Diameters: 1.125\", 1.375\", 1.56\", 1.625\", 1.687\" & 2.125\", Clear. Includes: Lockable Tab.\r\nHigh-impact polycarbonate construction provides maximum durability Patented Quick-Fit keyhole mounting system allows installation in under a minute Patented Universal Fit Adapter System Technology (U-Fast) for 16-in-1 custom device configurations, comes pre-configured for GFCI Includes attached gasket and mounting hardware Lockable tab', NULL, 'tymmm410c.jpg', '', 0, 1, '2025-03-21 09:49:56', NULL, 4),
(152, 'oIjYH8v_cTl', 'Ground Rod, Copper, 5/8\", 10\' Long', '7150', 'Ground Rod, Copper, Length: 10\', Diameter: 5/8\".\r\nNVent ERICOÂ® GRDC5810 copper bonded ground rods are the highest quality ground rods available today. We use a unique manufacturing process, which includes drawing the steel rod to size before the copper bonding process begins. This results in a straighter, harder steel core, making installation easier. NVent ERICOÂ® uses a continuous electro plating process over the steel core that results in a permanent molecular bond that provides decades of reliable performance.', NULL, 'galvan6260.jpg', '', 0, 1, '2025-03-21 09:51:02', NULL, 6),
(153, 'ytg80sQknMl', 'Emergence Series LED White Thermoplastic Exit/Emergency Light Combo Sign, Red/Green Letter Selectable', '2382648', 'Emergence Series LED White Thermoplastic Exit/Emergency Light Combo Sign, 120/277V, Red/Green Letter Selectable, White Housing, Emergency Test Button and Battery, Charging Indicator, Long-life Maintenance Free NiCad Battery, 24 Hour Recharge Time\r\nThe Emergence Series Exit Sign offers the most versatile code compliant solution for hallway, stairwell, and other Life Safety applications. The universal red/green stencil face, field-selectable single/double face, and universal ceiling/end/wall mounting includes universal chevron indicators as well as universal input voltage to provide the most field configurable exit sign on the market. The low profile design makes it ideal to mount on ceilings or walls in surface or end mount configurations, indicating the path of egress for a minimum of 90 minutes after a power loss. Also available with remote capacity\r\nAlso known as: 97102', NULL, '4.jpg', '', 0, 1, '2025-03-21 09:57:38', NULL, 9),
(154, 'edWM8KP52b_', 'Non-Metallic Liquidtight, 1/2\", Gray, 100\' Coil', '96858', '1/2\" Diameter, Liquidtight, Non-Metallic, Type B, UL Listed for Outdoor Use & Sunlight Resistant, Color: Gray. 100 feet Coil.\r\nLiquidtight conduits are perfect for use in environments that are likely to get moist or wet. Used in conjunction with liquid-tight fittings, conduit can keep moisture at bay.\r\nAlso known as: 980050029766, NM050100CL, super flex, 12lnmf, 1/2\" carflex, Sealtite, poly', NULL, 'image-16_1.jpg', '', 0, 1, '2025-03-21 09:59:20', NULL, 3),
(155, 'yWvhPa763yI', 'Telescoping Screw Gun Bracket, 17 to 26\" Studs', '20382', 'Telescoping Screw Gun Bracket 17\" to 26\" (432 mm- 660 mm) Stud Spacing. Load Limit: 50 lbs. Standard Packaging Quantity: 50.\r\nCan mount multiple boxes Notched and marked for easy identification and bending Improved design with stamped inch markings and pilot holes accelerates precise box conduit mounting between studs Pilot holes allow easy box attachment with a screwdriver Requires only a screw gun to install Can be mounted to face or inside of stud Adjustable for non-standard stud spacing Interlocking tab prevents accidental disassembly Unique, one-piece, break apart design Reduces movement of the box when used with flexible conduit, ENT, MC, AC or non-metallic sheathed cable\r\nAlso known as: 782856476245, TSGB24, caddy bars, jbd, illusion bar, Flat caddy screw, gun box bracket, flat caddyscrew, spreader bars, Slider Bracket, DOG BONES', NULL, 'ph3008g.jpg', '', 0, 1, '2025-03-21 10:00:11', NULL, 15),
(156, 'JK37LeyYIl9', 'Aluminum Flex, 1/2\", 100\' Coil', '48590', '1/2\" Diameter, Reduced Wall Aluminum Conduit, Metallic, Lightweight Aluminum Alloy, 100 ft Reel.\r\nFlexible conduits are used to connect to motors or other devices where isolation from vibration is useful, or where an excessive number of fittings would be needed to use rigid connections. Electrical codes may restrict the length of a run of some types of flexible conduit.\r\nAlso known as: 980050022026, ALC050RW100CL, temflex, 1/2 al flex, flex, 1/2\" flex, 1/2\" aluminum flex, 1/2 flex, 1/2 FMC, metallic Flex', NULL, '38fax100_1.jpg', '', 0, 1, '2025-03-21 10:01:16', NULL, 3),
(157, 'm7FtcQP5Km6', '4/0 AWG XHHW-2 Stranded Aluminum Black, Cut to Length', '1259871', '4/0 AWG, XHHW-2, Compact Stranded Aluminum, 600V, Black, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.\r\nAlso known as: XHHW4/0STRBLK-CUT', NULL, 'image-8_1.jpg', '', 0, 1, '2025-03-21 10:03:18', NULL, 5),
(158, 'TvVYUzForhM', '4/0 XHHW Stranded Aluminum, Red, Cut to Length', '1288276', 'Type XHHW, 4/0 AWG, Aluminum, Stranded, Red, Cut to Length\r\nXHHW is a multi-purpose electrical wire with cross-linked high heat water-resistant insulation. The most common applications include raceways for branch circuit wiring, conduits, services, and feeders. It is also used as a building wire.\r\nAlso known as: XHHW4/0STRRED-CUT', NULL, 'image-10_1.jpg', '', 0, 1, '2025-03-21 10:04:08', NULL, 5),
(159, 'tlB9eLF-WdQ', '4/0 XHHW Stranded Aluminum, White, Cut to Length', '1288278', 'Type XHHW, 4/0 AWG, Aluminum, Stranded, White, Cut to Length\r\nXHHW is a multi-purpose electrical wire with cross-linked high heat water-resistant insulation. The most common applications include raceways for branch circuit wiring, conduits, services, and feeders. It is also used as a building wire.\r\nAlso known as: XHHW4/0STRWHT-CUT', NULL, 'image-11_1.jpg', '', 0, 1, '2025-03-21 10:05:23', NULL, 5),
(160, 'MhxMEtOnzY9', 'Mechanical Lug, 2-Conductor, 1-Hole Mount, Aluminum, 4 AWG - 350 MCM', '138723', 'Aluminum Connector Lug, 2-Conductor, 1 Hole Mount, 4 AWG to 350 MCM, 9/16 Inch Opening, 5/16 Inch Allen\r\nAlso known as: 783643503700, H56732', NULL, 'image-21.jpg', '', 0, 1, '2025-03-21 10:06:24', NULL, 6),
(161, 'y7e_yvFPEhF', '30A, 3P, 240V, Type BAB, 10 kAIC, Bolt On', '12181', '30 Amp, 3-Pole, Miniature Industrial Circuit Breaker, Type BAB, Quicklag, Bolt-On, 10 kAIC, 240 VAC\r\nBAB bolt-on miniature circuit breakers. Eatonâ€™s bolt-on miniature circuit breakers (Quicklag) provide superior protection in panelboards,&nbsp;and offer easy installation. They are also switching duty rated for 120 VAC fluorescent light applications, and UL 489 listed. All products 15â€“100A are HACR rated.&nbsp;Select from one-, two-, or three-pole designs.\r\nAlso known as: 786679303306, BAB3030H', NULL, 'cutbab3030h.jpg', '', 0, 1, '2025-03-21 10:10:09', NULL, 8),
(165, 'b_jmJVpCnxj', '1-1/2\" PVC Conduit, 10\' Length, Schedule 40, Gray, Bell End', '43456', '1-1/2 Inch PVC Conduit, 10 Foot Length, Schedule 40, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.\r\nAlso known as: 670648234855, 150', NULL, '1p_2.jpg', '', 0, 1, '2025-03-21 10:16:22', NULL, 3),
(166, 'QS5HwHzOFd3', 'EMT Set Screw Coupling, 2\", Steel', '21605', 'EMT Set Screw Coupling, 1/2 Inch, Steel, For Use with EMT Conduit, UL 514B, CSA C22.2\r\nAppletonâ„¢ and O-Z/Gedneyâ„¢ products are manufactured to keep you and your job site safe and efficient. Superior design standards and a wide range of options meet the needs of a variety of application driven requirements. From Commercial Fittings, Industrial Location Fittings, and Reels and Switches â€” Emerson delivers the best products and services along with safe reliable power where you need it.\r\nAlso known as: 687855851263, 5200S', NULL, 'c7f15fae1555455994fae6e61927f27555ed8f99-large_2.jpg', '', 0, 1, '2025-03-21 10:18:02', NULL, 15),
(167, 'F3UhekQwQa7', 'Armored Cable Strap, 1-Hole, 3/8\", Steel', '51313', 'Armored Cable Strap, 1-Hole, 3/8\", Steel, For Use With Armored Cable\r\nMS &amp; BX armored cable straps provide support for runs of armored cable.\r\nAlso known as: 687855105519, BX-50, MC strap', NULL, 'appbx50.jpg', '', 0, 1, '2025-03-21 10:20:10', NULL, 7),
(168, 'cKN0MmNofyk', 'Ground Rod, Copper Coated, 3/4\", 10\' Long', '7570', 'Ground Rod, Length 10 Feet, Diameter 3/4 Inch, Steel Core With Copper Coating\r\nGalvanâ€™s copper coated rods have a heavy, uniform coating of copper metallurgically bonded to a rigid steel core.\r\nAlso known as: 632591613408, 7510', NULL, 'image-20.jpg', '', 0, 1, '2025-03-21 10:27:46', NULL, 6),
(169, '_VgdYycCdsR', '1 AWG THHN/THWN-2 Stranded Copper, Green, Cut to Length', '1294018', 'Building Wire, Type THHN/THWN-2, 1 AWG, Copper, Stranded, Green, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\nAlso known as: THHN1STRGRN-CUT', NULL, '12thhncstrgrex500_2.jpg', '', 0, 1, '2025-03-21 10:29:40', NULL, 5),
(170, 'Yvjeny0LbLA', 'WingTwistÂ® Wire Connector, WT52 Red, 500/Bag', '84371', 'Wire Connector, Winged, 14 to 12 AWG, 600 Volt, Square Wire Spring, Rated 105Â°, Color: Red, Bag of 500 Each\r\nWith a full line for virtually every wire size and combination, the WingTwistÂ® Wire Connector offers a great combination of performance and value. The contoured wing design of the WingTwistÂ® provides maximum torque for a variety of electrical applications while the copolymer shell and live-action spring expand for smooth, progressive tightening providing dependable connections.\r\nAlso known as: 781789611037, WT52-B', NULL, '700x560letterboximage.jpg', '', 0, 1, '2025-03-21 10:31:00', NULL, 6),
(184, 'TK0v4h9-2Na', 'EMT Set Screw Coupling, 1\", Steel', '21564', 'EMT Set Screw Coupling, 1 Inch, Steel, For Use with EMT Conduit, UL 514B, CSA C22.2\r\nAppletonâ„¢ and O-Z/Gedneyâ„¢ products are manufactured to keep you and your job site safe and efficient. Superior design standards and a wide range of options meet the needs of a variety of application driven requirements. From Commercial Fittings, Industrial Location Fittings, and Reels and Switches â€” Emerson delivers the best products and services along with safe reliable power where you need it.\r\nAlso known as: 687855851119, 5100S', NULL, 'rac2024.jpg', '', 0, 1, '2025-03-31 13:53:25', NULL, 15),
(185, 'N9uAM3FS6zd', 'EMT Compression Coupling, Steel, 1\"', '21436', 'EMT Compression Coupling, 1 inch, Material: Steel\r\nAppletonâ„¢ and O-Z/Gedneyâ„¢ products are manufactured to keep you and your job site safe and efficient. Superior design standards and a wide range of options meet the needs of a variety of application driven requirements. From Commercial Fittings, Industrial Location Fittings, and Reels and Switches. Emerson delivers the best products and services along with safe reliable power where you need it\r\nAlso known as: 687855867097, 6100S', NULL, 'rac2922.jpg', '', 0, 1, '2025-03-31 13:54:27', NULL, 15),
(186, 'Uv3mo80vDk_', 'EMT Compression Coupling, 3\", Concrete Tight', '21350', 'EMT Compression Coupling, 3 Inch, Steel With Zinc Plating, Concrete Tight, For Use with EMT Conduit, UL 514B\r\nAppleton/OZ Gedney ETP 6000S EMT compression couplings are used to ground and secure EMT raceway section together.\r\nAlso known as: 687855868308, 6300S', NULL, 'image-19_1.jpg', '', 0, 1, '2025-03-31 13:57:03', NULL, 15),
(187, '-CiAYRUbvyN', 'Conduit Hanger with Bolt, Diameter: 3\", Steel', '185486', 'Conduit Hanger with Bolt, Diameter: 3 Inch, Steel, For Use With Rigid/IMC/EMT to Threaded Rod\r\nAlso known as: 050169020593, 2059, mini', NULL, 'beefd9afbd3a8cafbadca834af151065ozgedney-neer-conduit-hanger.jpg', '', 0, 1, '2025-03-31 14:00:36', NULL, 15),
(189, '6fbtHz6F-C2', 'EMT Set Screw Coupling, 3\", Steel', '21621', 'EMT Set Screw Coupling, 3 Inch, Steel, For Use with EMT Conduit\r\nAppletonâ„¢ and O-Z/Gedneyâ„¢ products are manufactured to keep you and your job site safe and efficient. Superior design standards and a wide range of options meet the needs of a variety of application driven requirements. From Commercial Fittings, Industrial Location Fittings, and Reels and Switches. Emerson delivers the best products and services along with safe reliable power where you need it\r\nAlso known as: 687855851362, 5300S', NULL, 'c7f15fae1555455994fae6e61927f27555ed8f99-large_1.jpg', '', 0, 1, '2025-03-31 14:02:26', NULL, 15),
(190, 'ERsiP22Z7m1', '3\" EMT 90Â° Elbow', '1126736', '3 Inch EMT 90 Degree Elbow\r\n90 Degree&nbsp;EMT elbow is manufactured from prime EMT conduit in accordance with the latest specifications and standards of ANSI C80.3 (UL797). The interior and exterior surface of elbows are free from defect with a smooth welded seam, and also are thoroughly and evenly coated with zinc using hot dip galvanizing process. Elbows are produced in normal trade sizes from Â½â€œ to 4â€ and used to connect the EMT conduit to change the way of the EMT conduit.\r\nAlso known as: 835243053083, EEL90-300', NULL, '3e90.jpg', '', 0, 1, '2025-03-31 14:04:57', NULL, 3),
(191, '5yHG9b-YAIh', '3\" EMT 45Â° Elbow', '40331', '3 Inch EMT 45 Degree Elbow\r\nThe elbows are bent sections of the conduit run and used to change raceway direction or bypass the obstructions.\r\nAlso known as: 786692020389, EMT30045', NULL, '3e45.jpg', '', 0, 1, '2025-03-31 14:06:34', NULL, 3),
(192, 'dcG7B_xABp9', 'Capped Bushing, 3\", Insulating, Threadless, Non-Metallic', '25620', 'Capped Bushing, 3 Inch, Insulating, Threadless, Non-Metallic, Threadless, For Use With EMT Conduit. Can also be used for rigid, IMC, and PVC rigid conduit.\r\nUse this capped version to seal off conduit during concrete pours. Then remove cap/seal with razor knife or use screwdriver to punch hole in cap.\r\nAlso known as: 018997122179, EMT300C', NULL, 'arlemt100c_1.jpg', '', 0, 1, '2025-03-31 14:07:55', NULL, 15),
(193, 'aDqj-ClUrub', 'EMT Compression Coupling, 1/2\" Diameter, Raintight/Concrete Tight, Steel', '333360', 'EMT Compression Coupling, 1/2 Inch Diameter, Raintight and Concrete Tight, Steel\r\nSteel EMT compression coupling. Concrete tight and rain tight. Trade Size 1/2\".\r\nAlso known as: 018997820303, 830RT, raintight connector, rain tight coupler', NULL, 'arl836rt.jpg', '', 0, 1, '2025-04-09 12:23:08', NULL, 15),
(194, 'wE2OFk4UNN4', 'EMT Set Screw Coupling, 1/2\", Steel', '21512', 'EMT Set Screw Coupling, 1/2 Inch, Steel, For Use with EMT Conduit, UL 514B, CSA C22.2\r\nEMT set screw couplings are used to ground and secure EMT raceway sections together.\r\nAlso known as: 687855851010, 5050S', NULL, 'c7f15fae1555455994fae6e61927f27555ed8f99-large.jpg', '', 0, 1, '2025-04-09 12:29:32', NULL, 15),
(195, 'zLstId_q3Kf', 'EMT Compression Coupling, 1/2\", Steel, Concrete Tight', '21473', 'EMT Compression Coupling, 1/2 Inch, Material: Steel, Concrete Tight, For Use with EMT Conduit, UL 514B\r\nAppleton\'s 6000S Series couplings are used to ground and secure EMT raceway sections together.\r\nAlso known as: 687855866991, 6050S', NULL, 'image-19.jpg', '', 0, 1, '2025-04-09 12:47:38', NULL, 15),
(199, 'uxInYomaitV', 'Capped Bushing, 1/2\", Insulating, Threadless, Non-Metallic', '25437', 'Capped Bushing, 1/2 Inch, Insulating, Threadless, Non-Metallic, Threadless, For Use With EMT Conduit\r\nUse this capped version to seal off conduit during concrete pours. Then remove cap/seal with razor knife or use screwdriver to punch hole in cap.\r\nAlso known as: 018997122032, EMT50C', NULL, 'arlemt100c.jpg', '', 0, 1, '2025-04-09 12:51:14', NULL, 15),
(200, 'Ml6zUJAcJ5n', 'EMT Set Screw Coupling, 3/4\", Steel', '21585', 'EMT Set Screw Coupling, 3/4 Inch, Steel, Use with EMT Conduit, UL 514B, CSA C22.2\r\nAppletonâ„¢ and O-Z/Gedneyâ„¢ products are manufactured to keep you and your job site safe and efficient. Superior design standards and a wide range of options meet the needs of a variety of application driven requirements. From Commercial Fittings, Industrial Location Fittings, and Reels and Switches â€” Emerson delivers the best products and services along with safe reliable power where you need it.\r\nAlso known as: 687855851065, 5075S', NULL, 'rac2023.jpg', '', 0, 1, '2025-04-09 14:01:15', NULL, 15),
(201, 'OQSOJasPG5x', 'Set Screw Connector, 3/4\" Steel', '22938', 'EMT Connector, Set Screw, 3/4 Inch, Steel, Non-Insulated, Use with EMT Conduit, UL 514 B, CSA C22.2, APPLICABLE STANDARD FEDERAL SPECIFICATION WF 408E, NEMA\r\nAppletonâ„¢ and O-Z/Gedneyâ„¢ products are manufactured to keep you and your job site safe and efficient. Superior design standards and a wide range of options meet the needs of a variety of application driven requirements. From Commercial Fittings, Industrial Location Fittings, and Reels and Switches â€” Emerson delivers the best products and services along with safe reliable power where you need it.\r\nAlso known as: 687855846061, 4075S', NULL, 'rac2002_5.jpg', '', 0, 1, '2025-05-01 10:11:40', NULL, 15),
(202, 'stdyazORpaG', 'Set Screw Connector, 1/2\" Steel', '22923', 'EMT Set Screw Connector, 1/2 Inch, Non-Insulated, Steel, For Use with EMT Conduit\r\nAppleton\'s 4000S Series Connectors are used to ground and secure EMT raceways to boxes and enclosures. These connectors are manufactured with heavy steel walls, concretetight when taped.\r\nAlso known as: 687855846016, 4050S', NULL, 'rac2002_4.jpg', '', 0, 1, '2025-05-01 10:13:41', NULL, 15),
(203, 'saCDLvPFqrM', 'Set Screw Connector, 1\" Steel', '23156', 'EMT Connector, Set Screw, 1 Inch, Steel, Non-Insulated, For Use with EMT Conduit, UL 514 B, CSA C22.2, APPLICABLE STANDARD FEDERAL SPECIFICATION WF 408E, NEMA\r\n4000S Series Connectors are used to ground and secure EMT raceways to boxes and enclosures\r\nAlso known as: 687855846115, 4100S', NULL, 'rac2002_3.jpg', '', 0, 1, '2025-05-01 10:15:18', NULL, 15),
(204, 'rWrGkeQRx8D', 'Conduit Bushing, Insulating, 1\", Threaded, Plastic', '35563', 'Conduit Bushing, Insulating, 1 Inch Diameter, Threaded, Plastic, Rated 105 Degrees Celsius, For Use With Rigid/IMC Conduit\r\nThreaded plastic bushings are used at the end of threaded conduit, or conduit connector, to provide smooth well rounded bearing surface for wires or cables as required by the National Electrical Code.\r\nAlso known as: 687855143009, PB-300-D, 1 inch bushing', NULL, 'image-18.jpg', '', 0, 1, '2025-05-01 10:28:18', NULL, 15),
(205, 'Bwkij-qEwsy', 'Fender Washer, 1/4\" x 1-1/4\", Steel 100/PK', '46999', 'Fender Washer, 1/4\" x 1-1/4\", Steel, Zinc Plated, Order of 1 Each = Pack of 100\r\nFender washers provides a large load bearing surface. Washer features steel construction with zinc-plated finish. It measures 1/4-Inch ID x 1-1/4-Inch OD. Washer is ideal for general-purpose applications.\r\nAlso known as: 705591195394, R14114FW', NULL, 'r3161fw-1.jpg', '', 0, 1, '2025-05-01 10:29:59', NULL, 18),
(208, 'DRYiW4DxMuM', 'Strut Strap, Universal, 3/4\", Steel', '79324', 'Universal Strut Strap, Diameter: 3/4\", Material: Steel, Finish: Electro-Galvanized, .060\" Thickness, Universal Clamp for EMT, IMC & GRC.\r\nUniversal Clamps for Rigid or Thin wall Conduit PS 1300 series pipe clamps are designed for broad use with rigid or thin wall conduit (EMT). These clamps are commonly used for trapeze supports, seismic bracing, wall supports, vertical runs, attachment to poles, and general framing needs. For application examples, refer to our Application Showcase.\r\nAlso known as: 702316506947, PS-1300-AS-3/4-EG, COWBOY', NULL, 'pstps1300as1eg_2.jpg', '', 0, 1, '2025-05-01 10:34:27', NULL, 15),
(209, 'qLS-AiWvZDS', 'Strut Strap, Universal, 2\", Steel', '116298', 'Universal Strut Strap, Diameter: 2\", Material: Steel, Finish: Electro-Galvanized, .075\" Thickness, Universal Clamp for EMT, IMC & GRC.\r\nUniversal Clamps for Rigid or Thin wall Conduit PS 1300 series pipe clamps are designed for broad use with rigid or thin wall conduit (EMT). These clamps are commonly used for trapeze supports, seismic bracing, wall supports, vertical runs, attachment to poles, and general framing needs. For application examples, refer to our Application Showcase.\r\nAlso known as: 702316506930, PS-1300-AS-2-EG, Belly strap, 2\" rigid strut clamp, 2\" strut clamp', NULL, 'pstps1300as1eg_1.jpg', '', 0, 1, '2025-05-01 10:35:19', NULL, 15),
(210, 'jHjhn_PMPVj', 'Strut Strap, Universal, 1\", Steel', '63696', 'Universal Strut Strap, Diameter: 1\", Material: Steel, Finish: Electro-Galvanized, .060\" Thickness, Universal Clamp for EMT, IMC & GRC.\r\nUniversal Clamps for Rigid or Thin wall Conduit PS 1300 series pipe clamps are designed for broad use with rigid or thin wall conduit (EMT). These clamps are commonly used for trapeze supports, seismic bracing, wall supports, vertical runs, attachment to poles, and general framing needs. For application examples, refer to our Application Showcase.\r\nAlso known as: 702316506817, PS-1300-AS-1-EG, 1\" rigid, GRS', NULL, 'pstps1300as1eg.jpg', '', 0, 1, '2025-05-01 10:36:58', NULL, 15),
(211, 'tJRYDldIJhD', 'EMT Conduit Strap, 1-Hole, 3/4\", Steel/Zinc', '20182', 'EMT Conduit Strap, 1-Hole, 3/4 Inch, Steel With Zinc Finish, For Use With EMT Conduit\r\nAppleton\'s Click-On type one hole straps for EMT provides support for conduit, as required by the National Electrical Code\r\nAlso known as: 687855219025, 1902', NULL, 'app1901.jpg', '', 0, 1, '2025-05-01 10:38:40', NULL, 7),
(212, 'VV9FaUHC4FL', 'EMT Conduit Strap, 1-Hole, 1\", Steel', '20222', 'EMT Conduit Strap, 1-Hole, 1 Inch, Steel, For Use With EMT Conduit\r\nAppleton\'s Click-On type one hole straps for EMT provides support for conduit, as required by the National Electrical Code\r\nAlso known as: 687855219032, 1903', NULL, 'rac2088.jpg', '', 0, 1, '2025-05-01 10:39:34', NULL, 15),
(213, 'ClvPRGRVih2', 'Wing-NutÂ® Wire Conn, Model 451Â® Yellow, 100/Box', '14131', 'Wire Connector, Color Coded, Winged Type, Yellow, Wire Range: 18 - 10 AWG, Package of 100. Includes: Internal Square Wire Spring. For Copper-to-Copper Connections Only., Wire-NutÂ®\r\nThe Wing-NutÂ® wire connector provides an easy, secure grip when connecting a wide range of wires. The specially designed contoured wings make for extra torque and quick work on any electrical job. The wide range, live action spring is flexible enough to handle small combinations with ease but then expands to accept large combinations when you need it. It can also be reused on same size or larger combinations for quick and easy circuit changes and additions.\r\nAlso known as: 783250304516, 30-451, wire connectors, wire connector, wire nuts', NULL, '66-1.jpg', '', 0, 1, '2025-05-01 10:41:52', NULL, 6),
(214, 'l9ljjfSM1Ls', 'Wing-NutÂ® Wire Conn, Model 452Â® Red, 100/Box', '14110', 'Wire Connector, Color Coded, Winged Type, Color: Red, Wire Range: 18 - 8 AWG, Package of 100. Includes: Internal Square Wire Spring. For Copper-to-Copper Connections Only.\r\nThe Wing-NutÂ® wire connector provides an easy, secure grip when connecting a wide range of wires. The specially designed contoured wings make for extra torque and quick work on any electrical job. The wide range, live action spring is flexible enough to handle small combinations with ease but then expands to accept large combinations when you need it. It can also be reused on same size or larger combinations for quick and easy circuit changes and additions.\r\nAlso known as: 783250304523, 30-452, Red Wire Connector, Red Wirenut', NULL, '66_1.jpg', '', 0, 1, '2025-05-01 10:43:24', NULL, 6),
(215, '2lVmqNdkbS7', 'Self-Drilling Screw, #10 x 1\", Steel, Hex Washer Head', '265377', 'Self Drilling Screw, Hex Washer Head, Size: #10 x 1\". Hex Size: 5/16\". Zinc Plated Steel. Package Quantity: 100. *Dottie Part # 17535.*\r\nSelf-Drilling Screws are manufactured from cold-heading steel and feature a #2 drill point. The unique tip design allows them to drill, tap, and fasten metal to metal objects in one operation, without the need to pre-drill. This creates the optimal drill performance and thread forming experience. The most common applications are used on metal to metal, but they can also be used in a wide variety of other applications. IFI-113 and ASTM C954 cover the material and performance requirements for steel self-drilling screws.\r\nAlso known as: 781002175353, TEKHW101, hex screws self tapping, self tapping', NULL, 'product.jpg', '', 0, 1, '2025-05-01 10:44:35', NULL, 18),
(216, 'Z6uBt4955F-', 'Grounding Screw, # 10-32 x 3/8\" 100/PK', '41015', 'Grounding Screw, Type C, # 10-32 x 3/8\", Green, Leader Point, Order of 1 Each = Pack of 100\r\nThe green color identifies these as grounding screws. They have a flange that provides a wide flat surface for making solid electrical connections. Screws cut threads in drilled holes as they\'re turned, so they require less driving torque and cause less stress on your material than thread forming screws.\r\nAlso known as: 705591196681, R1038GSC', NULL, 'gs.jpg', '', 0, 1, '2025-05-01 10:45:56', NULL, 18),
(217, 'otQ-fPuGyaH', 'Beam Clamp, 1/4\"-20 Tap, 3/4\" Jaw', '928090', 'Beam Clamp, 1/4\"-20 Tap, 3/4 Inch Jaw, Steel\r\nAlso known as: 835243032354, BC-25', NULL, 'orbbc-25image.jpg', '', 0, 1, '2025-05-01 10:47:00', NULL, 15),
(218, 'ICdIYNiIWMg', '4\" Octagon Box, 1-1/2\" Deep, 1/2\" KOs, Drawn, Steel', '34862', '4 Inch Octagon Box, 1-1/2 Inch Deep, Side Knockouts: (1) 1/2 Inch, End Knockouts: (1) 1/2 Inch, Side Knockouts: (5) 1/2 Inch Cubic Inches: 15.8, Drawn, Steel\r\nSteel CityÂ® metallic outlet boxes and accessories provide innovative and efficient solutions for electrical rough-in. Save time and labor by shipping prefabricated, ready-to-install assemblies of steel CityÂ® boxes, covers, fittings and brackets directly to the job site. Steel CityÂ® innovative bracket designs simplify the process of positioning and mounting electrical outlet boxes.\r\nAlso known as: 785991169003, 54151-1/2', NULL, '54151-12pi.jpg', '', 0, 1, '2025-05-01 10:48:30', NULL, 4),
(219, 'JwbDrtuZpEv', 'Flange Mount Conduit Clip, Type: Snap, 1/2 to 3/4\" Conduit, Steel', '21215', 'Flange mount conduit clips (snap- close). 1/2\" to 3/4\" conduit to 1/8\" to 1/4\" flanges - Side Mount. Standard Package Quantity: 100.\r\nSupports conduit/pipe or cable from beam flanges Snap close clip pivots a full 360Â° Requires only a hammer to install\r\nAlso known as: 782856112105, 812M24SM, Caddy Slammer, conduit thingys, pound ons, Bang Ons, Bang on straights, Smash On', NULL, 'ph5980g.jpg', '', 0, 1, '2025-05-01 10:49:55', NULL, 15),
(220, 'Qso43pAJDwl', 'Set Screw Connector, 2\" Steel', '23022', 'EMT Connector, Set Screw, 2 Inch, Steel, Non-Insulated, For Use with EMT Conduit\r\n4000S Series Connectors are used to ground and secure EMT raceways to boxes and enclosures.\r\nAlso known as: 687855846269, 4200S, TW200S', NULL, 'rac2002_2.jpg', '', 0, 1, '2025-05-01 10:51:49', NULL, 15);
INSERT INTO `post` (`id`, `short_name`, `name`, `code`, `description`, `offer_txt`, `image`, `link`, `is_featured`, `is_public`, `created_at`, `order_at`, `category_id`) VALUES
(221, '80Ujifa5AVz', 'NEMA 1 Screw Cover Enclosure, Powder Coated Steel with Knockouts, 6\" x 6\" x 6\"', '39701', 'Designed for indoor use for applications that require a junction or pull box to secure and manage electrical connections.\r\nSecure and manage electrical connections with these enclosures, designed for indoor use in commercial environments that require a junction or pull box. Engineered to meet NEMA 1 standards, they ensure protection against contact with the enclosed equipment. The removable screw cover facilitates easy access for wiring tasks, while the choice of models with or without knockouts provides versatility for various electrical setups. Offered in either galvanized steel or powder coated finishes, these enclosures are built to last and resist corrosion. NEMA 1 Rating: Indoor protection against contact with live components and environmental factors like dust. Removable Screw Cover: Easy access for wiring and inspection, enhancing maintenance efficiency. Optional Knockouts: Reduce the need for additional drilling or cutting, facilitating a more streamlined installation. Galvani', NULL, 'hofase12x12x6nk_1.jpg', '', 0, 1, '2025-05-01 10:53:59', NULL, 4),
(222, 'QMSSLy2iCof', 'CONCRETE POST', '1079260', 'CONCRETE POST 6 x 6 x 120\"\r\nAlso known as: POST6X6X120', NULL, 'PRE-FP-UNP240.jpg', '', 0, 1, '2025-05-05 08:58:45', NULL, 4),
(224, 'Ck5jbb7TsVj', '4\" Square Box, Welded, 1-1/2\" Depth, 1/2\" Knockouts, Steel', '19315', '4 Inch Square Box, Welded, 1-1/2 Inch Depth, Side Knockouts: (8) 1/2 Inch, (4) Eccentric, Bottom Knockouts: (2) 1/2 Inch, (2) Eccentric, 21 Cubic Inches, Steel\r\nAppleton\'s 4 inch square boxes are widely recognized for quality, selection and ease of installation. They may be used as a junction box or a device box for switches, receptacles, GFCIs, etc. Manufactured of durable materials with consistent construction means easy installation, making all the difference in the speed and final quality of any wiring job.\r\n\r\nAlso known as: 687855703173, 4SEK, JB, 4 SQUARE SHALLOW, 4 sq deep', NULL, '1891200.jpg', '', 0, 1, '2025-05-05 09:06:54', NULL, 4),
(225, 'vojU5ELpGt1', 'Locking Connector, 30A, 125/250V, L14-30R, 3P4W', '52907', '30 Amp, 125/250 Volt, NEMA L14-30R, 3P, 4W, Locking Connector, Industrial Grade, Grounding - Black/White\r\n30 Amp, 125/250 Volt, NEMA L14-30R, 3P, 4W, Locking Connector, Industrial Grade, Grounding - Black-White\r\n\r\nAlso known as: 078477807439, 2713, L14-30R', NULL, 'image-17.jpg', '', 0, 1, '2025-05-05 09:11:18', NULL, 14),
(226, 'T4ItsA8xfl4', '12 AWG THHN/THWN-2 Solid Copper, Black, 500\'', '94533', '12 AWG, THHN/THWN-2, Solid Copper, 600V, Black, 500 foot Spool.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\n\r\nAlso known as: 048243224005, THHN12SOLBLK500RL', NULL, 'image-5_1.jpg', '', 0, 1, '2025-05-05 09:12:44', NULL, 5),
(227, 'Lf0zMj1I5fS', 'Aluminum Flex, 3/4\", 100\' Coil', '48349', '3/4\" Diameter, Reduced Wall Aluminum Conduit, Metallic, Lightweight Aluminum Alloy, 100 feet Coil\r\nFlexible conduits are used to connect to motors or other devices where isolation from vibration is useful, or where an excessive number of fittings would be needed to use rigid connections. Electrical codes may restrict the length of a run of some types of flexible conduit.\r\n\r\nAlso known as: 980050022033, ALC075RW100CL, SNAKE TUBING, Greenfield', NULL, '38fax100.jpg', '', 0, 1, '2025-05-05 09:13:51', NULL, 3),
(228, 'g9cEjBcP7wY', '2\" PVC Conduit, 10\' Length, Schedule 80, Gray, Bell End', '26995', '2 Inch PVC Conduit, 10 Foot Length, Schedule 80, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.\r\n\r\nAlso known as: 670648235371, 20080, Gaemans stool', NULL, '34ps8_3.jpg', '', 0, 1, '2025-05-05 09:15:56', NULL, 3),
(229, 'E7AMDc1IJBm', 'Bare Wire Ground Clamp, Open Lug, 3/8\" to 1\", Bronze', '11177', 'Bare Ground Clamp, Direct Burial, Clamp Material: Bronze, Screw Material: Stainless Steel, Wire Size: 8-4/0 AWG, Pipe/Rebar Size: 3/8 Inch to 1 Inch.\r\nAlso known as: 018997720016, 719DB', NULL, 'arl719db.jpg', '', 0, 1, '2025-05-05 09:17:11', NULL, 6),
(230, 'VsJcMc7TohT', '4\" Square Cover, 1-Device, Mud Ring, Flat, Drawn, Metallic', '27195', '4\" Square Cover, 1-Device, Mud Ring, No Raise, Drawn, Metallic, for 1900\r\n4 in. Square Single Device Cover, Flat Angled mounting slots compensate up to 12 degrees for box misalignment\r\n\r\nAlso known as: 050169007877, 787, flat mud ring', NULL, 'rac787.jpg', '', 0, 1, '2025-05-05 09:18:33', NULL, 4),
(231, '4n3hDUUA1C4', 'SO Portable Cord, 10/4, Copper, Black, Cut to Length', '1310335', 'SO Portable Cord, 10/4, Copper, Black, Cut to Length\r\nSO cord is a cable with multiple conductors manufactured for the purpose of electrical power connections requiring flexibility. So cord is a multi-conductor power cable that can be operated both inside and outside environments. Common applications include wiring for industrial machinery, enormous appliances, heavy-duty tools, motors, and temporary electrical power and lighting for construction sites\r\n\r\nAlso known as: SO104BLK-CUT', NULL, '1612soowx500mcr.jpg', '', 0, 1, '2025-05-05 09:23:02', NULL, 5),
(232, 'pTrggmky2MD', 'Grounding Bushing, 2\", Threaded, Insulated, Zinc', '51059', 'Grounding Bushing, 2 Inch, Threaded, Insulated, 1/0 to 14 AWG, Zinc, For Use With Rigid/IMC Conduit\r\nAppletonâ„¢ and O-Z/Gedneyâ„¢ offer NEERâ„¢ GBL grounding type insulated bushings. They include an aluminum grounding lug and are used with a locknut to terminate rigid metal conduit or IMC conduit to a box or enclosure.\r\n\r\nAlso known as: 687855136100, GBL-600', NULL, 'arl452.jpg', '', 0, 1, '2025-05-05 09:37:25', NULL, 15),
(233, 'PJEUOLerZ0x', 'Tapcon Anchor, Hex Head, 1/4\" x 1-1/4\" 100/PK', '45593', 'Tapcon Anchor, Concrete Screw, Hex Head, 1/4\" x 1-1/4\", Steel, Zinc Plated, Order of 1 Each = Pack of 100\r\nTapconÂ® is the #1 recognized screw anchor brand in the industry. The blue, corrosion-resistant coating enables them to withstand the harshest conditions. And their unmatched performance in concrete, block and brick applications make them an excellent alternative to expansion anchors, plugs and lag shields.\r\n\r\nAlso known as: 705591196537, R114HMS', NULL, 'r3114hms-1_1.jpg', '', 0, 1, '2025-05-05 10:49:11', NULL, 18),
(234, '_r1egWYhjSY', 'Breaker, 30A, 3P, 240V, 10 kAIC', '4021', '30 Amp, 3-Pole, BR Plug-On Circuit Breaker, 10 kAIC, Wire Size #14-4, 240 VAC.\r\nBR Loadcenters are enclosures specifically designed to house the branch circuit breakers and wiring required to distribute power to individual circuits. They contain either a main breaker when used at the service entrance point or a main lug when used as a sub-panel to add circuits to existing service. The main breaker protects the main entire panel and can be used as a service disconnect. The branch breakers protect the wires leading to individual electrical loads such as fixtures and outlets.\r\n\r\nAlso known as: 786676367806, BR330, Challenger', NULL, 'cutbr330.jpg', '', 0, 1, '2025-05-05 10:50:59', NULL, 8),
(235, 'HcnjWvls_mB', 'Non-Metallic Liquidtight, 1\", Gray, 100\' Coil', '475090', '1\" Diameter, Liquidtight, Non-Metallic, UL Listed for Outdoor Use & Sunlight Resistant, Color: Gray. 100 feet Coil.\r\nLiquidtight conduits are perfect for use in environments that are likely to get moist or wet. Used in conjunction with liquid-tight fittings, conduit can keep moisture at bay.\r\n\r\nAlso known as: 980050029780, NM100100CL, 1lnmf, pvc flex, 1\" carlon', NULL, 'image-16.jpg', '', 0, 1, '2025-05-05 10:51:56', NULL, 3),
(238, 'xRkVp-Abm2v', '2\" PVC 90Â° Elbow, Schedule 40, Gray', '41775', '2 Inch PVC 90 Degree Elbow, Schedule 40, Gray\r\nThe PVC elbow allows a degree change in direction to assist turning corners in a pipeline. During installation solvent cement will be required in the two elbow sockets to bond the pipes to the elbow fitting.\r\n\r\nAlso known as: 980060060469, 20090ELB, Sweep', NULL, 'image-13_1.jpg', '', 0, 1, '2025-05-05 10:53:29', NULL, 3),
(239, 'y0KEQCZ-Byd', 'NEMA 1 Screw Cover Enclosure, Powder Coated Steel without Knockouts, 12\" x 12\" x 6\"', '38836', 'Designed for indoor use for applications that require a junction or pull box to secure and manage electrical connections.\r\nSecure and manage electrical connections with these enclosures, designed for indoor use in commercial environments that require a junction or pull box. Engineered to meet NEMA 1 standards, they ensure protection against contact with the enclosed equipment. The removable screw cover facilitates easy access for wiring tasks, while the choice of models with or without knockouts provides versatility for various electrical setups. Offered in either galvanized steel or powder coated finishes, these enclosures are built to last and resist corrosion.\r\n\r\nNEMA 1 Rating: Indoor protection against contact with live components and environmental factors like dust.\r\nRemovable Screw Cover: Easy access for wiring and inspection, enhancing maintenance efficiency.\r\nOptional Knockouts: Reduce the need for additional drilling or cutting, facilitating a more streamlined installation.\r\nG', NULL, 'hofase12x12x6nk.jpg', '', 0, 1, '2025-05-05 10:55:01', NULL, 4),
(240, 'f8kAknLrUs9', 'Liquidtight Connector, 1/2\", Straight, Non-Metallic', '9808', 'Liquidtight Connector, Straight, 1/2 inch, UV Rated Plastic, Sealing Ring, Material: Non-Metallic, For Non-Metallic Liquidtight - Type B; Flexible Non-Metallic Tubing, UL, CSA\r\nPlastic straight liquid tight connector bonds conduit to an enclosure or box. Grey connector is used with 1/2 inch non-metallic liquid tight conduit, type B. Connector is UV-rated plastic for long outdoor life. Connector is UL Listed and CSA certified.\r\n\r\nAlso known as: 018997545008, NMLT50, 1/2 carlons, liquid tight straights, 1/2 straights, carlons', NULL, 'arlnmlt50.jpg', '', 0, 1, '2025-05-05 10:56:11', NULL, 15),
(241, '0UT2Fup3fT-', '3\" PVC Conduit, 10\' Length, Schedule 80, Gray, Bell End', '26900', '3 Inch PVC Conduit, 10 Foot Length, Schedule 80, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.\r\n\r\nAlso known as: 670648235449, 30080', NULL, '34ps8_2.jpg', '', 0, 1, '2025-05-05 10:57:08', NULL, 3),
(242, '67ixpSJBBS3', 'Conduit Hanger MC/AC or BX, #8 to #12 Wire Size, Steel', '47887', 'Conduit Hanger MC/AC or BX to #8 Wire. Standard Packaging Quantity: 100.\r\nSupports conduit to rod, wire or flange Can also be used for flexible metallic tubing, armored cable, portable cables, control tubes and communications cable Available for EMT, rigid, ENT, IMT, MC/AC and aluminum conduit No installation tools required\r\n\r\nAlso known as: 782856245032, KX, bx, m8, batwing, bat wing, 1900, BATWANGS, battys', NULL, 'ph37847g.jpg', '', 0, 1, '2025-05-05 10:58:09', NULL, 15),
(243, 'zEIEVLH5zsv', '4\" Square Exposed Work Cover, (1) Duplex Receptacle', '27086', '4\" Square, Exposed Work Cover, Type: (1) Duplex Receptacle, 1/2\" Raised, Drawn, Metallic. Cubic Inches: 7.3\".\r\nRACOÂ® exposed work covers include required hardware for mounting the receptacle(s) RACOÂ® exposed work covers meet the requirements of the 2014 NEC Article 250.146(A). No bonding jumper is required for covers with: (1) Crushed corners Hardware and cover are packed in a poly-bag with printed catalog number, compliances and installation instructions UL listed\r\n\r\nAlso known as: 050169999950, 902C, RS COVER, R.s cover, duplex ir , Duplex IRC, duplex mulberry cover, Taylor cover, Austin Cover, Garvin Cover', NULL, 'rac902c.jpg', '', 0, 1, '2025-05-05 10:59:11', NULL, 4),
(244, '1qFLJQFT_09', 'PVC Cement, Clear, 1 Gallon', '473646', 'PVC Cement, Clear, 1 Gallon\r\nPVC cement is environmentally friendly with low VOC levels. PVC glue is ideal to fit PVC pipes and fittings together. Helps to form a strong bond by softening the fitting surface.\r\n\r\nAlso known as: GLGAL-1', NULL, 'image-15.jpg', '', 0, 1, '2025-05-05 11:00:09', NULL, 15),
(245, 'oB-1BTelCUQ', '12 AWG THHN/THWN-2 Solid Copper, Blue, 500\'', '94310', '12 AWG, THHN/THWN-2, Solid Copper, 600V, Blue, 500 foot Spool.\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\n\r\nAlso known as: 048243224302, THHN12SOLBLU500RL', NULL, 'image-14.jpg', '', 0, 1, '2025-05-05 11:01:01', NULL, 5),
(246, 'hoAqM1a58c8', 'Grounding Bushing, 3\", Threaded, Insulated, Zinc', '49766', 'Grounding Bushing, 3 Inch, Threaded, Insulated, 1/0 to 14 AWG Aluminum Lug, Zinc Body, For Use With Rigid/IMC Conduit\r\nAppletonâ„¢ and O-Z/Gedneyâ„¢ offer NEERâ„¢ GBL grounding type insulated bushings. They include an aluminum grounding lug and are used with a locknut to terminate rigid metal conduit or IMC conduit to a box or enclosure.\r\n\r\nAlso known as: 687855350148, GBL-800', NULL, 'appgbl800.jpg', '', 0, 1, '2025-05-05 11:02:23', NULL, 15),
(247, 'rJf8MQIro9n', 'Coupling, 3\" Diameter, PVC, Gray', '31380', 'Coupling, 3 Inch Diameter, PVC, Gray\r\nAll socket fittings should be attached using Carlon solvent cement. Using Carlon fittings with Carlon non-metallic conduit insures system integrity.\r\n\r\nAlso known as: 088700569515, 300CPL, 3\" pvc coupling', NULL, '212pcp_3.jpg', '', 0, 1, '2025-05-05 11:03:39', NULL, 15),
(248, 'sxEJxG2SSRY', 'Tapcon Anchor, Hex Head, 3/16\" x 1-1/4\" 100/PK', '44873', 'Tapcon Anchor, Concrete Screw, Hex Head, 3/16\" x 1-1/4\", Steel, Zinc Plated, Order of 1 Each = Pack of 100\r\nAlso known as: 705591197671, R3114HMS', NULL, 'r3114hms-1.jpg', '', 0, 1, '2025-05-05 11:06:34', NULL, 18),
(249, 'M9wEexgUIVn', '1\" PVC 90Â° Elbow, Schedule 40, Gray', '41959', '1 Inch PVC 90 Degree Elbow, Schedule 40, Gray\r\nThe PVC elbow allows a degree change in direction to assist turning corners in a pipeline. During installation solvent cement will be required in the two elbow sockets to bond the pipes to the elbow fitting.\r\n\r\nAlso known as: 980060060438, 10090ELB, corner, elbow, bent angle, 90\'s', NULL, 'image-13.jpg', '', 0, 1, '2025-05-05 11:07:52', NULL, 3),
(250, 'tdbR_enPpCD', 'Coupling, 3-1/2\" Diameter, PVC, Gray', '31292', 'Coupling, 3-1/2 Inch Diameter, PVC, Gray\r\nWe offer one of the most complete line of non-metallic elbows and fittings in the electrical industry, with products designed for use above- and below-ground.\r\n\r\nAlso known as: 088700061095, 350CPL', NULL, '212pcp_2.jpg', '', 0, 1, '2025-05-05 11:08:49', NULL, 15),
(251, 'vzzScO5iEtH', 'Junction Box, NEMA 4X, Screw Cover, 6\" x 6\" x 4\"', '27759', 'Junction Box, NEMA 4X, Solid Screw Cover, 6 x 6 x 4 Inch, PVC/Gray\r\nThis pvc junction box features quarter-turn fasteners that are hand-close and tool-assist to open. No more loose screws to fumble with or over-tighten.\r\n\r\nAlso known as: 980060066867, 6X6X4-JCT-BOX-W/CVR, PVC submersible j box, PVC J Box, squid box', NULL, 'image-12.jpg', '', 0, 1, '2025-05-05 11:10:15', NULL, 4),
(252, 'eG_Rg90IH71', '1 AWG XHHW Stranded Aluminum, White, Cut to Length', '1293922', 'Building Wire, Type XHHW, 1 AWG, Aluminum, Stranded, White, Cut to Length\r\nXHHW is a multi-purpose electrical wire with cross-linked high heat water-resistant insulation. The most common applications include raceways for branch circuit wiring, conduits, services, and feeders. It is also used as a building wire.\r\n\r\nAlso known as: XHHW1STRWHT-CUT', NULL, 'image-11.jpg', '', 0, 1, '2025-05-05 11:11:58', NULL, 5),
(253, 'WG6GIYp4KdV', '3 AWG THHN/THWN-2 Stranded Copper, Green, Cut to Length', '1259524', '3 AWG, THHN/THWN-2, Stranded Copper, 600V, Green, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\n\r\nAlso known as: THHN3STRGRN-CUT, #3 Green', NULL, '12thhncstrgrex500_1.jpg', '', 0, 1, '2025-05-05 11:13:19', NULL, 5),
(254, 'bjANAPaHFEA', '1 AWG XHHW Stranded Aluminum, Red, Cut to Length', '1293921', 'Building Wire, Type XHHW, 1 AWG, Aluminum, Stranded, Red, Cut to Length\r\nXHHW is a multi-purpose electrical wire with cross-linked high heat water-resistant insulation. The most common applications include raceways for branch circuit wiring, conduits, services, and feeders. It is also used as a building wire.\r\n\r\nAlso known as: XHHW1STRRED-CUT', NULL, 'image-10.jpg', '', 0, 1, '2025-05-05 11:14:33', NULL, 5),
(255, 'MghVLoxPmME', 'Tamper Resistant GFCI Receptacle, 20A, 125V, White', '851422', '20 Amp, 125 Volt Receptacle, Feed-Through, Tamper Resistant, Self Testing, SmartLock Pro Slim GFCI, Monochromatic, Back & Side Wired, Nylon Wallplate & Self Grounding Clip Included - White\r\nSelf-Test Slim Tamper Resistant GFCI Receptacle. Nema 5-20R 20A-125V At Receptacle, 20A-125V Feed-through. Lighted - White With White Test And Reset Button.\r\n\r\nAlso known as: 078477497364, GFTR2-W', NULL, '6.jpg', '', 0, 1, '2025-05-05 11:15:55', NULL, 14),
(256, 'zusBv1y4peK', 'Hub, 2\", for Talon Meter Bases', '112901', 'Hub, 2 Inch, Small Opening, RX Type, Unpainted, for Talon Meter Bases\r\nAlso known as: 783643188020, H38599-2', NULL, 'image-9.jpg', '', 0, 1, '2025-05-05 11:17:00', NULL, 8),
(257, 'ZTPkHM7oGlu', 'Liquidtight Gasket, 3-1/2\"', '18463', 'Sealing Gasket, Trade Size: 3-1/2 Inch, Material: Steel Backed Neoprene, Standard: Csa C22.2 No. 18.3, Csa 065178, Nema Fb-1, For Liquidtight Flexible Metal Conduit\r\nAlso known as: 781381289122, STG-350', NULL, 'appstg350.jpg', '', 0, 1, '2025-05-05 11:18:01', NULL, 15),
(258, 'mNFU3zQzEzQ', 'Coupling, 2\" Diameter, PVC, Gray', '30519', 'Coupling, 2 Inch Diameter, PVC, Gray\r\nAll socket fittings should be attached using Carlon solvent cement. Using Carlon fittings with Carlon non-metallic conduit insures system integrity.\r\n\r\nAlso known as: 088700567337, 200CPL', NULL, '212pcp_1.jpg', '', 0, 1, '2025-05-05 11:19:11', NULL, 14),
(259, 'HG2vocWllZ7', '4 AWG XHHW-2 Stranded Aluminum Black, Cut to Length', '1259879', '4 AWG, XHHW-2, Compact Stranded Aluminum, 600V, Black, Cut to Length\r\nType XHHW-2 or RW90 wires are primarily used for power distribution and are sometimes referred to as feeders. They may be used in wet or dry locations with conductor temperatures not exceeding 90 Degees Celsius and may be used in conduit and recognized raceways as specified in the National Electric Code.\r\n\r\nAlso known as: XHHW4STRBLK-CUT', NULL, 'image-8.jpg', '', 0, 1, '2025-05-05 11:20:59', NULL, 5),
(260, 'Q_rMxdcw8vd', 'Coupling, 4\" Diameter, PVC, Gray', '31265', 'Coupling, 4 Inch Diameter, PVC, Gray\r\nAll socket fittings should be attached using Carlon solvent cement. Using Carlon fittings with Carlon non-metallic conduit insures system integrity.\r\n\r\nAlso known as: 980060061107, 400CPL, Slip coupling', NULL, '212pcp.jpg', '', 0, 1, '2025-05-05 11:22:19', NULL, 15),
(261, 'iWRKY2uIN90', '4-11/16\" Square Box, Welded, Metallic, 2-1/8\" Deep', '36116', '4-11/16\" Square Box, Welded, Metallic. Depth: 2-1/8\". Side Knockouts: (12) 1/2\" & 3/4\" TKO (eccentric) . Bottom Knockouts: (1) 1/2\" & (1) 3/4\" & (2) 1/2\" & 3/4\" TKO (eccentric). Cubic Inches: 42.0\". Includes: Ground Screw.\r\n4-11/16 in. Square Box, Welded, 2-1/8 in. Deep with One 1/2 in. KO & Fifteen TKO\'s, Raised Combination screw heads provide for faster installation TKO knockouts allow for design and installation flexibility\r\n\r\nAlso known as: 050169902578, 257, Four eleven , 5 Square, 5square, Five Square', NULL, 'app4sspl.jpg', '', 0, 1, '2025-05-05 11:23:48', NULL, 4),
(262, 'tLaPchuYgBW', 'Terminal Adapter, 3-1/2\" Diameter, PVC', '30562', 'Terminal Adapter, 3-1/2 Inch Diameter, PVC\r\nTerminal adapters are used for adapting nonmetallic conduits to boxes threaded fittings, metallic systems. Male threads on one end, socket end on other.\r\n\r\nAlso known as: 088700527799, 350MA', NULL, '12pta.jpg', '', 0, 1, '2025-05-05 11:26:10', NULL, 15),
(263, '7C6JgZvmv4P', 'Thread Forming Ground Screw, 100/Jar', '423252', 'Grounding Screw, Zinc-Plated Steel, Package: 100/Jar, ASTM 1929\r\nConvenient for device grounding applicationsEnsures compliance with Article 250 of the National Electrical CodeThread-forming, hole-finding ground screw with combination Slotted, Phillips, Hex and #2 Robertson head\r\n\r\nAlso known as: 783250708598, 30-3594', NULL, 'image-7.jpg', '', 0, 1, '2025-05-05 11:27:22', NULL, 18),
(264, 'aC3upNqRF6o', 'Electrical Box Attachment, Mounts to TSGB, Steel', '294989', 'Electrical Box Attachment, Mounts to TSGB, Steel\r\nAttaches electrical boxes to the TSGB with a single screw, without tools and without need for disassembly Allows closer installation of multiple boxes between or against the studs Allows for easy repositioning of electrical boxes Ideal for pre-fab assemblies\r\n\r\nAlso known as: 782856663720, TSGLDR1', NULL, 'ph31720g.jpg', '', 0, 1, '2025-05-05 11:28:20', NULL, 4),
(265, 'GNGK_JWrSyh', 'Box Extender, 1-Gang, Depth 1-1/2\", White, Non-Metallic', '12858', 'Box Extender, 1-Gang, Non-Metallic. Color: White. Depth: 1-1/2\".\r\nArlingtonâ€™s non-conductive box extenders extend set back metal or non-metallic electrical boxes up to 1-1/2 inches, the easy way! They work with any single gang device and most steel and non-metallic outlet boxes, and provide a level, fully supported wiring device thatâ€™s flush with the wall surface. In steel boxes they prevent arcing and shorting by creating a barrier between the box and device screws. Our newest box extender, the BE1X, has a slightly larger flange that provides extra device support when the wall opening is miscut or oversized. It accommodates midi or maxi cover plates and costs the same as our â€˜regularâ€™ single gang BE1. If you normally use a midi plate this is the box extender for you!\r\n\r\nAlso known as: 018997401601, BE1, adda depth, goof rings, add adapter, outlet box extension, diapers, spark rings, goof ring, arc guard, shock guard, box extender, Spark gaurd, spark guard, add a depth, Box ext', NULL, 'be1.jpg', '', 0, 1, '2025-05-05 11:29:56', NULL, 4),
(266, 'Vl9GzyeTT_2', 'Conduit Body, LB, \"R\" Series, 2\", Die Cast Aluminum', '843592', 'Conduit Body, Type LB, \"R\" Series, 2\", Die Cast Aluminum. Includes Cover & Gasket\r\nRaco conduit bodies offer a great approach in size for neat compact installation. We have several different families of conduit bodies in iron, die cast and copper-free aluminum, with superior corrosive protected electro-statically applied paint.\r\n\r\nAlso known as: 092326211963, RLB200', NULL, '2787dc2bdbb4dd9b63b5bd1ab71f2ac926f63b99-large.jpg', '', 0, 1, '2025-05-05 11:30:54', NULL, 15),
(267, 'uwKobOu8uBh', 'Occupancy Sensor Switch, 2A, Maestro, White', '338514', 'Lutron Maestro Motion Sensor Switch, No Neutral Required, 150W LED, Single Pole, White (Wall Plates Sold Separately)\r\nMaestro Occupancy-Sensing Switch, Single-pole, 120V/2A in white\r\n\r\nAlso known as: 027557982825, MS-OPS2-WH', NULL, 'jpegecomms-ops2whnowallplate3.jpg', '', 0, 1, '2025-05-05 11:32:07', NULL, 9),
(268, '4QBp-IYDGis', 'Grounding Bridge, Zinc, 6 - 2 AWG Grounding Electrode, 14 - 4 AWG', '18879', 'Bonding Termination, Bonding Conductors: 5, Bonding Gauge Range: 14 - 4 AWG. Grounding Conductors: 1, Grounding Gauge Range: 6 - 2 AWG. For Outdoor Use in Residential and Commercial Applications.\r\nArlington heavy duty Grounding Bridges provide reliable intersystem bonding between power and communication grounding systems. They have four termination points; one more than required by 250.94 of the 2014 NEC. Available in zinc and bronze, our Grounding Bridges have the capacity to handle multiple hookups of communications systems like telephone, CATV or satellite dish.\r\n\r\nAlso known as: 018997760951, GB5, Intersystem bonding bar, utility ground bar, Bonding bridge, intergalactic bonding terminal, ground bridge, grounding bridge,', NULL, 'image-6.jpg', '', 0, 1, '2025-05-05 11:33:41', NULL, 6),
(269, '1TaOnva3bhE', '2 AWG THHN/THWN-2 Stranded Copper, Black, Cut to Length', '152053', '2 AWG, THHN/THWN-2, Stranded Copper, 600V, Black, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\n\r\nAlso known as: THHN2STRBLK-CUT', NULL, 'image-5.jpg', '', 0, 1, '2025-05-05 11:35:17', NULL, 5),
(270, 'pcFOR8i7eM6', 'Breaker, 20A, 1P, 120/240V, 10 kAIC', '3749', '20 Amp, 1-Pole, BR Plug-On Circuit Breaker, 10 kAIC, Wire Size #14-4, 120/240 VAC\r\nEaton BR offers this 20 Amp, 1-Pole, BR Plug-On Circuit Breaker, 10 kAIC, Wire Size #14-4, 120/240 VAC circuit breaker with a thermal-magnetic trip curve that avoids nuisance tripping on mild overloads while reacting almost instantaneously to severe short-circuit conditions.\r\n\r\nAlso known as: 786676362108, BR120, 1-Pole 20A 120/240V BR Plug-On Breaker, breaker breaker, 20a breaker, Thumper, BRIZO, BR', NULL, 'cutbr120-2.jpg', '', 0, 1, '2025-05-05 11:36:28', NULL, 8),
(271, 'yVSPe4PNin6', 'PHOTO CONTROL THRML', '76686', 'The 120 V 50/60 Hz. 1800 Watt \"T\" Stem Mounting The K4100 & K4400 Series Photo Controls feature stem mounting, thermal-type, controls with single and multi-voltage models. Thermal-type photo controls provide dusk-to-dawn lighting control and a delay action, which eliminates loads switching OFF due to car headlights, and lighting. The thermal-type controls feature a cadmium sulfide photocell and a sonic-welded polycarbonate case and lens to seal out moisture. The design utilizes a dual temperature compensating bimetal and composite resistor for reliable long life operation over ambient temperature extremes. These models are California Title 24 compliant.\r\nThese photocontrols install on standard outdoor light fixtures and electrical boxes with 1/2\"-14 NPSM thread or 7/8\" knock-out holes for dusk-to-dawn ON/OFF control of outdoor lighting.\r\n\r\nAlso known as: 078275002012, K4121C, K4221c', NULL, 'imtk4121c.jpg', '', 0, 1, '2025-05-05 11:46:51', NULL, 9),
(272, '3E2SmUF56zA', 'Barricade Tape, \"Caution\", 3\" x 1,000\', Yellow, Polyethylene', '32977', 'Barricade Tape, Legend: CAUTION, 3 Inch x 1,000 Foot, Yellow, Polyethylene\r\nIDEAL baricade tapes meet OSHA specifications for marking physical hazards\r\n\r\nAlso known as: 783250420018, 42-001', NULL, '42-001.jpg', '', 0, 1, '2025-05-05 11:49:06', NULL, 16),
(273, 'k2gQ-G3-oZb', 'EMT Set Screw Connector, 3/4\", Steel', '30711', 'EMT Set Screw Connector, 3/4 Inch, Non-Insulated, Steel, Concrete-Tight When Taped, For Use With EMT Conduit\r\nTo bond EMT conduit to a box or enclosure, use RACOÂ® set-screws. Provides concrete-tight connections when taped. Offered either as insulated or uninsulated. Suitable for applications above 600V.\r\n\r\nAlso known as: 050169020036, 2003', NULL, 'rac2002_1.jpg', '', 0, 1, '2025-05-05 11:52:32', NULL, 15),
(274, 'k5U0-rme9_3', '1-1/2\" PVC Conduit, 20\' Length, Schedule 40, Gray, Bell End', '316870', '1-1/2 Inch PVC Conduit, 20 Foot Length, Schedule 40, Gray, Bell End\r\nPVC Conduit 1-1/2\" X20\' SCH 40\r\n\r\nAlso known as: 670648234862, 15020', NULL, '1p.jpg', '', 0, 1, '2025-05-05 11:54:52', NULL, 3),
(275, 'BHTr2Chanxu', 'Cable Support, 3/4\", J-Hook, Steel', '48104', 'J-Hook Accepts Up to 16 4-Pair UTP CAT 5e or 2- Strand Fiber Optic Cable, or 10 CAT 3/4\" dia. Standard Packaging Quantity: 50.\r\nCaddyÂ® CADCAT12 Cat HP J-hooks are the heart of the CaddyÂ® Cat HP system. The J-hooks have a wide base design and smooth beveled edges to provide a large bending radius for current and future high performance data cables and fiber optics. CaddyÂ® Cat HP J-hook are available in a wide range of sizes to offer a solution that meets industry standards for Cat 6A and easily accommodates Cat 7, large diameter fiber optic, inner duct and coax cable.\r\n\r\nAlso known as: 782856331780, CAT12', NULL, 'ph36223g.jpg', '', 0, 1, '2025-05-05 11:56:57', NULL, 15),
(276, 'oesYynVx3zD', '6 AWG XHHW Stranded Aluminum, Green, Cut to Length', '1288220', '6 AWG, XHHW-2, Compact Stranded Aluminum, 600V, Green, Cut to Length\r\nXHHW is a multi-purpose electrical wire with cross-linked high heat water-resistant insulation. The most common applications include raceways for branch circuit wiring, conduits, services, and feeders. It is also used as a building wire.\r\n\r\nAlso known as: XHHW6STRGRN-CUT', NULL, 'image-4.jpg', '', 0, 1, '2025-05-05 11:59:33', NULL, 5),
(277, 'R7gFLASSToN', 'AC/Flex Connector, 1/2\", 90Â°, 2-Screw Clamp, Zinc Die Cast', '54112', 'AC/Flex Cable Connector, 1/2 Inch, 90Â°, Two Screw Clamp, Zinc Die Cast, For Use With Armored Cable and Flexible Metal Conduit\r\nNEER Zinc AC Series 90Â° Two Screw Clamp Connectors, are used to make a 90Â° termination of conduit or cable to a knockout or unthreaded slip hole in a dry location box or enclosure\r\n\r\nAlso known as: 687855100958, AC95', NULL, 'arl8510-1.jpg', '', 0, 1, '2025-05-05 12:02:18', NULL, 15),
(279, 'RzO73ICkw1d', 'PVC Cement, Clear, 1 Quart', '66441', 'PVC Cement, Medium Bodied 404, Brush Top Lid, 1 Quart\r\nPVC cement is environmentally friendly with low VOC levels. PVC glue is ideal to fit PVC pipes and fittings together. Helps to form a strong bond by softening the fitting surface.\r\n\r\nAlso known as: CEMENTQT', NULL, 'ptpcewb_2.jpg', '', 0, 1, '2025-05-05 12:07:07', NULL, 15),
(280, 'IqO4fKbfJfv', 'NEMA 1 Screw Cover Enclosure, Powder Coated Steel without Knockouts, 18\" x 18\" x 6\"', '38792', 'Designed for indoor use for applications that require a junction or pull box to secure and manage electrical connections.\r\nSecure and manage electrical connections with these enclosures, designed for indoor use in commercial environments that require a junction or pull box. Engineered to meet NEMA 1 standards, they ensure protection against contact with the enclosed equipment. The removable screw cover facilitates easy access for wiring tasks, while the choice of models with or without knockouts provides versatility for various electrical setups. Offered in either galvanized steel or powder coated finishes, these enclosures are built to last and resist corrosion.\r\n\r\nNEMA 1 Rating: Indoor protection against contact with live components and environmental factors like dust.\r\nRemovable Screw Cover: Easy access for wiring and inspection, enhancing maintenance efficiency.\r\nOptional Knockouts: Reduce the need for additional drilling or cutting, facilitating a more streamlined installation.\r\nG', NULL, 'hofase18x18x6nk.jpg', '', 0, 1, '2025-05-05 12:12:01', NULL, 4),
(281, 'KNwdJQhqs72', '20A GFCI Commercial Grade Decora Receptacle, 5-20R, White', '851464', '20 Amp, 125 Volt Receptacle, 20 Amp Feed-Through, Self Testing, SmartLock Pro Slim GFCI, Monochromatic, Back & Side Wired, Wallplate & Self Grounding Clip Included - White\r\nPeace of mind, all the time. The SmartlockPro Self-Test GFCI tests itself even if you forget. Designed to meet the latest UL standard for auto-monitoring (self-test) our complete line of self-test GFCIs periodically conduct an automatic internal test to confirm that it can respond to a ground fault. With the slimmest profile on the market, the device allows for fast and easy installation, while Levitonâ€™s patented reset lockout mechanism prevents reset of the GFCI if it is not wired or operating correctly. The SmartlockPro Self-Test GFCI is the smart choice in ground fault circuit interrupter protection.\r\n\r\nAlso known as: 078477712764, GFNT2-W, 20 AMP GFCI', NULL, 'satellitejsessionidsqvcb35hwmb5pslcbi7hqvhll7txcqsuhull8eekmsmk2o6j9k6-233869812125194393blobcolurldatablobkeyidblobnocachefalseblobtablemungoblobsblobwhere1470098929817localeenssbinarytrue.jpg', '', 0, 1, '2025-05-05 12:13:59', NULL, 14),
(282, '498eIBezuFi', 'Conduit Locknut, 3-1/2\" Diameter, Steel/Zinc', '50582', 'Conduit Locknut, 3-1/2 Inch Diameter, Threaded, Steel With Zinc Finish, For Use With Rigid/IMC Conduit\r\nNeer standard conduit locknuts are used for securing conduit or connectors with tapered or straight thread to a knockout or unthreaded slip hole.\r\n\r\nAlso known as: 687855169009, L-900', NULL, 'image-3.jpg', '', 0, 1, '2025-05-05 12:16:11', NULL, 15),
(283, 'IHfpKei_yh9', 'Wing-NutÂ® Wire Connector, Model 452Â® Red, 500/Bag', '15225', 'Wire Connector, Color Coded, Winged Type, Red, Wire Range: 18 - 8 AWG, Package of 500. Includes: Internal Square Wire Spring. For Copper-to-Copper Connections Only., Wire-NutÂ®\r\nIDEAL, Wire Connector, Wing-NutÂ® , Twist-On, Number Of Conductors: 1 to 6, Environmental Conditions: Tough, UL 94V-2 Flame-Retardant Shell Rated At 105 DEG C (221 F), Conductor Range: 18 - 8 AWG, Min 2 - 18, MAX 4-10, Material: Flame-retardant polypropelene shell, Color: Red, Voltage Rating: 600 V, Model Number: 452, Width: 1-15/64 IN, Height: 15/16 IN, Flammability Rating: UL 94V-2\r\n\r\nAlso known as: 783250306527, 30-652, Wire Connector, bagofreds, Wire connectors, Wire Nut', NULL, '66.jpg', '', 0, 1, '2025-05-05 12:18:12', NULL, 6),
(284, '81EUuGwBRU5', 'AC/Flex Connector, 3/4\", 90Â°, 2-Screw Clamp, Zinc Die Cast', '53079', 'AC/Flex Connector, 3/4 Inch Diameter, 90 Degree, 2-Screw Clamp, Zinc Die Cast\r\nArlington is a leading manufacturer of traditional and unique metallic and non-metallic electrical fittings and low voltage products.\r\n\r\nAlso known as: 018997008527, 852, 3/4\" ko', NULL, 'arl8510.jpg', '', 0, 1, '2025-05-05 12:21:51', NULL, 14),
(285, 'o9bJiK9Tn1U', '1-1/2\" PVC Conduit, 10\' Length, Schedule 80, Gray, Bell End', '26962', '1-1/2 Inch PVC Conduit, 10 Foot Length, Schedule 80, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.\r\n\r\nAlso known as: 670648235333, 15080', NULL, '34ps8_1.jpg', '', 0, 1, '2025-05-05 12:30:45', NULL, 3),
(286, '-HQe5hZIoTk', 'Spring Nut, Long Spring, Size: 1/4-20, Steel/Electro-Galvanized', '80020', 'Channel Nut W/ long spring, Thread Diameter: 1/4\", Material: Steel, Finish: Electro-Galvanized. For Use w/ PS 200, 210, 300.\r\nSpring Nuts allow for easy installation into Powerstrut channel. Once inserted into the channel and with a 90Â° turn, these spring nuts will stay in place allowing hands-free installation of other components. Seismic load capacities have been tested in accordance with seismic standards.\r\n\r\nAlso known as: 702316502130, PS-RS-1/4-EG, T Nuts, Strut Nut, Spring Nut', NULL, 'pstpsrs1420eg.jpg', '', 0, 1, '2025-05-08 13:28:00', NULL, 15),
(287, '3Nmd6E9o13n', '2\" EMT 45Â° Elbow', '40679', '2 Inch EMT 45 Degree Elbow\r\nThe elbows are bent sections of the conduit run and used to change raceway direction or bypass the obstructions.\r\n\r\nAlso known as: 786692020365, EMT20045', NULL, '2e45.jpg', '', 0, 1, '2025-05-08 13:30:38', NULL, 3),
(288, 'WjfoxJ262nU', 'Weatherproof Box, 1 Gang, (3) 1/2\" Outlets, 2\" Depth, Aluminum Die Cast', '51844', 'Weatherproof Box, 1-Gang, Die Cast. Depth: 2\". (3) 1/2\" Threaded Outlets (1 in each end, 1 in back), Cubic Inches: 17.5\". Includes: (2) Closure Plugs & Ground Screw. Gray, Box Quantity: 20\r\nReinforced connector outlets State-of-the-art powder coat finish provides maximum weatherability and scratch resistance Eight box mounting options with detachable lugs Two closure plugs included Hubs accept all threaded fittings and threaded conduit Ground screw installed Multi-lingual instructions in each package Includes gasket and mounting hardware\r\n\r\nAlso known as: 050169532003, 5320-0, BELL 1/2, Bell, weatherproof box, Bell Box, BELL BOX 1/2, weatherproof', NULL, 'rac53200.jpg', '', 0, 1, '2025-05-08 13:46:55', NULL, 4),
(289, 'YYYaySrsgj7', 'EMT Set Screw Connector, 2\", Steel', '149368', 'EMT Set Screw Connector, 2 Inch, Non-Insulated, Steel, Concrete-Tight When Taped, For Use With EMT Conduit\r\nRaco\'s set screw connectors are used to bond EMT conduit to a box or enclosure, use RACOÂ® set-screws. Provides concrete-tight connections when taped. Offered either as insulated or uninsulated. Suitable for applications above 600V.\r\n\r\nAlso known as: 050169020081, 2008', NULL, 'rac2002.jpg', '', 0, 1, '2025-05-08 13:50:00', NULL, 15),
(290, 'vgEiJoNp7lM', '3/4\" Liquidtight Steel Flex, UL Listed, Type UA, Gray, Cut to Length', '1259571', '3/4 Inch Liquidtight Steel Flex, UL Listed, Type UA, Steel Core, PVC Jacket, Gray, Cut to Length, Integral Bonding Strip\r\nA flexible steel conduit which is both listed by Underwriters Laboratories Inc. and certified by Canadian Standards Association for â€œHeavy-Dutyâ€ applications. It offers outstanding protection against wet, oily conditions and is permitted for use in exposed or concealed locations.\r\n\r\nAlso known as: UA075GRY-CUT', NULL, 'typeua-piece.jpg', '', 0, 1, '2025-05-08 13:52:32', NULL, 3),
(291, 'CyzvEs5j2uT', '4\" Square Extension Ring, 1-1/2\" Deep, Drawn, Metallic', '36793', '4\" Square, Extension Ring, Drawn, Metallic. Depth: 1-1/2\". Side Knockouts: (8) 1/2\" & (4) 3/4\". Cubic Inches: 22.5\"\r\nExtension rings provide additional cubic capicity. May be used an an outlet box fro surface conduit. Constructed from 1/16 in. pre-galvanized steel.\r\n\r\nAlso known as: 050169902035, 203', NULL, 'image-2.jpg', '', 0, 1, '2025-05-08 13:56:28', NULL, 4),
(292, '43vjtYKa6iK', 'PVC Cement, Clear, 1 Pint', '66466', 'PVC Cement, Medium Bodied 404, Brush Top Lid, 1 Pint\r\nPVC cement is environmentally friendly with low VOC levels. PVC glue is ideal to fit PVC pipes and fittings together. Helps to form a strong bond by softening the fitting surface.\r\n\r\nAlso known as: CEMENTPT', NULL, 'ptpcewb_1.jpg', '', 0, 1, '2025-05-08 13:58:21', NULL, 15),
(293, 'n3ZZIIcN6pg', 'Flex Connector, Squeeze, Straight, 1/2\", Die Cast Zinc', '53817', 'Flex Connector, Squeeze, Straight, 1/2 Inch, Die Cast Zinc, For Use With Flexible Metal Conduit\r\nNEER set screw type connectors are used to terminate 1/2 inch regular wall steel or aluminum flexible conduit to a 1/2 inch knockout in a dry location box or enclosure.\r\n\r\nAlso known as: 687855200504, SC-50', NULL, '8990517imageurl.jpg', '', 0, 1, '2025-05-08 14:00:13', NULL, 15),
(295, 'hK0tDvIMOue', 'PVC Cement, Clear, Quart', '373966', 'PVC Cement, Clear, Quart\r\nPVC cement is environmentally friendly with low VOC levels. PVC glue is ideal to fit PVC pipes and fittings together. Helps to form a strong bond by softening the fitting surface.\r\n\r\nAlso known as: GLQTS-1', NULL, 'ptpcewb.jpg', '', 0, 1, '2025-05-08 14:13:38', NULL, 15),
(296, 'GzAjfQsGLJs', 'Liquidtight Connector, 90Â°, 1/2\", Non-Metallic', '10051', 'Liquidtight Connector, 90Â°, 1/2 inch, UV Rated Plastic, Sealing Ring, Material: Non-Metallic, For Non-Metallic Liquidtight - Type B; Flexible Non-Metallic Tubing, UL, CSA, Refer to Diagram: A = 2.325\", B = 0.562\", C = 2.440\"\r\nFor use with non-metallic liquid-tight conduit, type B only. 90Â° connector provides a smooth, gradual radius bend. Wiring is easily pulled or pushed through fitting and there are no sharp edges to strip wire. Produced from UV rated plastic for long outdoor life.\r\n\r\nAlso known as: 018997549051, NMLT9050, flex male 90, INSIDE 90', NULL, 'arlnmlt9050.jpg', '', 0, 1, '2025-05-08 14:16:28', NULL, 15),
(297, 'UDrWRdbiYME', 'Round Head Machine Screw, Slot/Phillips Combo, 1/4\" x 3/4\" 100/PK', '43869', 'Machine Screw, Round Head - Combo, 1/4 x 3/4\", Zinc Plated, Order of 1 Each = Pack of 100\r\nCap and machine screws are used to clamp machine parts together, either when one of the parts has a threaded hole or in conjunction with a nut. These screws stretch when tightened, and the tensile load created clamps the parts together.\r\n\r\nAlso known as: 705591194762, R1434RHC', NULL, 'image-1_1.jpg', '', 0, 1, '2025-05-08 15:05:43', NULL, 18),
(298, '1azChS2sk1E', 'Ground Rod, Galvanized, Diameter: 5/8\", Length 8\'', '7613', 'Ground Rod, Galvanized, Diameter 5/8 Inch, Length 8 Feet\r\nThe basic philosophy of a grounding installation should be to maximize the surface area contact of electrodes or conductors within the surrounding soil. Not only does this help to lower the earth resistance of the grounding system, but it also greatly improves the impedance of the grounding system under lightning surge conditions. Galvanâ€™s products are designed and tested to meet the most demanding requirements available.\r\n\r\nAlso known as: 632591707022, GR6258', NULL, 'ph35775g.jpg', '', 0, 1, '2025-05-08 15:08:52', NULL, 6),
(299, 'DzxMKctoJ3o', '3/4\" PVC Conduit, 10\' Length, Schedule 80, Gray, Bell End', '27011', '3/4 Inch PVC Conduit, 10 Foot Length, Schedule 80, Gray, Bell End\r\nPVC conduit is often used in underground and wet location applications. This type of conduit has its PVC fittings, connectors, couplings, and elbows. They are easy to attach with a cleaner and PVC glue.\r\n\r\nAlso known as: 670648235265, 07580', NULL, '34ps8.jpg', '', 0, 1, '2025-05-08 15:13:07', NULL, 3),
(300, 'Z3zamEZpBQ6', 'Conduit Bushing, Insulating, 3-1/2\", Threaded, Plastic', '142683', 'Conduit Bushing, Insulating, 3-1/2 Inch, Threaded, Plastic, Rated 105Â° Celsius, For Use With Rigid/IMC Conduit\r\n3-1/2\" Plastic insulated bushing with a temperature rating of 105 degrees C. Protects cables being pulled through Rigid and IMC conduit and is UL and CSA listed.\r\n\r\nAlso known as: 018997004482, 448', NULL, 'arl448.jpg', '', 0, 1, '2025-05-08 15:19:14', NULL, 15),
(301, 'uy0j-F7lAMo', 'Liquidtight Connector, Straight, 3/4\", Die Cast Zinc', '61709', 'Liquidtight Connector, Straight, Non-Insulated, 3/4 Inch, Die Cast Zinc, Liquidtight Flexible Metal Conduit & Type B Non-Metallic Conduit\r\nAppletonâ„¢ and O-Z/Gedneyâ„¢ products are manufactured to keep you and your job site safe and efficient. Superior design standards and a wide range of options meet the needs of a variety of application driven requirements. From Commercial Fittings, Industrial Location Fittings, and Reels and Switches â€” Emerson delivers the best products and services along with safe reliable power where you need it.\r\n\r\nAlso known as: 687855382217, LMM-21', NULL, 'image_1.jpg', '', 0, 1, '2025-05-08 15:30:50', NULL, 15),
(302, 'YIiD1IYyctT', '8 AWG THHN/THWN-2 Stranded Copper, Green, Cut to Length', '682463', '8 AWG, THHN/THWN-2, Stranded Copper, 600V, Green, Cut to Length\r\nTHHN is a thermoplastic high-heat-resistant, nylon-coated wire. It is designed with a specific insulation material, temperature rating and condition of use for electrical wire and cable.\r\n\r\nAlso known as: THHN8STRGRN-CUT, #8 THHN', NULL, '12thhncstrgrex500.jpg', '', 0, 1, '2025-05-08 15:35:10', NULL, 5),
(303, 'PqZFrwLKbt_', 'Chase Nipple, 3\", Zinc Die Cast', '144377', 'Chase Nipple, 3/4 Inch, Zinc Die Cast, For Use With a Conduit Coupling to Connect Conduit to a Box, or With a Locknut to Connect Two Boxes\r\nChase nipple terminate 3/4 inch threaded rigid conduit into an enclosure or box. Chase nipple is used with a locknut to connect two boxes side by side or back to back or to connect a fixture housing to continuous runs. Chase nipple is zinc die cast.\r\n\r\nAlso known as: 018997005021, 502, Long chase nippl', NULL, 'Chase-Nipple-3-Zinc-Die-Cast.jpg', '', 0, 1, '2025-05-08 15:37:33', NULL, 15),
(304, 'C6CZHaHLl6e', 'MC/AC Connector, 3/8\", Duplex, Zinc Die Cast', '204406', 'MC/AC Connector, 3/8 Inch, Duplex, Zinc Die Cast, For Use With Flexible Metal Conduit/Armored Cable\r\nRaco armored cable connectors are for use in dry locations to bond armored cable to a box or enclosure, and feature a rugged metallic construction that insures mechanical protection for the raceway.\r\n\r\nAlso known as: 050169026113, 2611, double barrel connector', NULL, 'MCAC-Connector-38-Duplex-Zinc-Die-Cast.jpg', '', 0, 1, '2025-05-08 15:39:25', NULL, 15),
(305, 'uHHRecCooz5', '4-11/16\" Square Cover, Flat, Blank', '27166', '4-11/16\" Square Cover, Blank, Mud Ring, No Raise, Drawn, Metallic\r\nRaco has assembled one of the most complete outlet box product lines in the business. Weâ€™ve been leading in quality and selection for decades and throughout Raco\'s steel outlet box offering, you will find innovative products and solutions that save labor, cut material costs and increase productivity.\r\n\r\nAlso known as: 050169908327, 832, 411 blank', NULL, '4-1116-Square-Cover-Flat-Blank.jpg', '', 0, 1, '2025-05-08 15:42:07', NULL, 4),
(306, '1KJKzfcYACr', '3\" PVC Male Terminal Adapter.', '31440', '3/4\" PVC Male Terminal Adapter.\r\nFor adapting nonmetallic conduits to boxes threaded fittings, metallic systems. Male threads on one end, socket end on other.\r\n\r\nAlso known as: 088700567078, 075MA, Male Adapter, TA, mip', NULL, '3-PVC-Male-Terminal-Adapter.jpg', '', 0, 1, '2025-05-08 15:44:13', NULL, 15),
(307, '4Fl6fvuD5et', 'Locking Plug, 30A, 125V, 2P3W', '42711', '30 Amp, 125 Volt, NEMA L5-30P, 2P, 3W, Locking Plug, Industrial Grade, Grounding - Black/White\r\n30 Amp, 125 Volt, NEMA L5-30P, 2P, 3W, Locking Plug, Industrial Grade, Grounding - Black-White\r\n\r\nAlso known as: 078477807989, 2611', NULL, 'Locking-Plug-30A-125V-2P3W.jpg', '', 0, 1, '2025-05-08 15:47:18', NULL, 14),
(308, 'HBETYMH-B0A', 'Offset Nipple, Threaded, 1/2\", Zinc Die Cast', '50237', 'Offset Nipple, Threaded, 1/2 Inch Diameter, 3/4 Inch Offset, Zinc Die Cast\r\nAppleton\'s offset nipples provide on offset connection between two outlet boxes or enclosures.\r\n\r\nAlso known as: 687855290505, RN-50', NULL, 'Offset-Nipple-Threaded-12-Zinc-Die-Cast.jpg', '', 0, 1, '2025-05-08 15:49:13', NULL, 15),
(309, 'eMZaKGGQ6SQ', '1/2\" Non-Metallic Liquidtight Flexible Conduit, Gray, Cut to Length', '1310213', '1/2\" Non-Metallic Liquidtight Flexible Conduit, Gray, Cut to Length\r\nNon-metallic conduit is a versatile product that has a variety of applications for indoor and outdoor locations. Non-metallic conduit is used in fixture whips, data centers, electric signs and outdoor lighting, HVAC, pool and spas and locations with exposure to sunlight and weather conditions and more.\r\n\r\nAlso known as: NM050-CUT', NULL, 'no-metalic.jpg', '', 0, 1, '2025-05-08 15:55:01', NULL, 3),
(310, 'ajI47mvhhpR', '3\" PVC Conduit, 20\' Length, Schedule 40, Gray, Bell End', '144663', '3\" Inch PVC Conduit, 20 Foot Length, Schedule 40, Gray, Bell End\r\nCarlon 49013-020 490 Series Heavy Wall EPC Nonmetallic Conduit, 3 IN Trade Size,3-1/2 IN Outside Diameter, 3.068 IN Inside Diameter, 20 FT Length, Rigid Flexibility, Integral Bell Connection, PVC, 0.216 IN Wall Thickness, 40 Schedule, For Underground Applications Encased In Concrete Or Direct Burial And Also For Used In Exposed Or Concealed Applications Aboveground\r\n\r\nAlso known as: 670648235029, 30020', NULL, '2px20.jpg', '', 0, 1, '2025-05-08 15:58:25', NULL, 3),
(311, '3wHIcExZaSn', 'Meter Offset Nipple, 2', '113935', 'Meter Offset, 2 Inch, PVC\r\nMeter offset nipples are designed to offset the axis of a raceway between enclosure runs when knockouts are not in line.\r\n\r\nAlso known as: 200METEROFFSET', NULL, 'e995grcl1.jpg', '', 0, 1, '2025-05-08 16:00:27', NULL, 15),
(312, 'We2Ff5OUnKn', 'Reducing Bushing, Threaded, 3/4', '22046', 'Reducing Bushing, 3/4 - 1/2 Inch, Threaded - NPT, Bushing Material: Steel.\r\nAppletonâ„¢ RB Series reducers are explosionproof and dust-ignitionproof. They are designed to reduce conduit entries to a smaller size and are used in threaded rigid and IMC conduit systems.\r\n\r\nAlso known as: 781381654357, RB75-50, R E bushing, RE', NULL, 'apprb7550.jpg', '', 0, 1, '2025-05-08 16:04:58', NULL, 15),
(313, 'Kh1IHTYPfLJ', 'Conduit Hub, 3\", Insulated, Raintight, Zinc Die Cast', '12456667', 'Conduit Hub, 3 Inch, Insulated, Raintight, Zinc Die Cast, Threaded, Use With Rigid/IMC Conduit\r\nUsed to connect rigid metal conduit or IMC to a threadless opening in an enclosure. May be used in wet or dry locations, indoors or outdoors.', NULL, '11301image2a_1.jpg', '', 0, 1, '2025-12-03 11:03:11', NULL, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_relations`
--

CREATE TABLE `post_relations` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_view`
--

CREATE TABLE `post_view` (
  `id` int(11) NOT NULL,
  `viewer_id` int(11) DEFAULT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `realip` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_subcategories`
--

CREATE TABLE `product_subcategories` (
  `post_id` int(11) NOT NULL,
  `subcategory_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `product_subcategories`
--

INSERT INTO `product_subcategories` (`post_id`, `subcategory_id`) VALUES
(10, 15),
(11, 10),
(12, 14),
(14, 18),
(22, 19),
(33, 20),
(85, 20),
(98, 12),
(130, 19),
(144, 18),
(166, 18),
(168, 15),
(184, 10),
(185, 10),
(186, 12),
(187, 12),
(189, 12),
(190, 12),
(191, 12),
(192, 12),
(193, 14),
(194, 14),
(195, 14),
(199, 14),
(200, 15),
(201, 15),
(202, 14),
(203, 10),
(204, 10),
(205, 16),
(208, 15),
(209, 18),
(210, 10),
(211, 15),
(212, 10),
(218, 19),
(220, 18),
(224, 19),
(241, 20),
(247, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'Administrador', 'Acceso completo al sistema'),
(2, 'Empleado', 'Acceso limitado a operaciones internas'),
(3, 'Supervisor', 'Supervisión y control de operaciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('pending','completed','canceled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `code` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slide`
--

CREATE TABLE `slide` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_public` tinyint(1) DEFAULT 0,
  `position` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `short_name`, `category_id`, `is_active`) VALUES
(10, '1\" EMT Conduit assamblie', '1\" emt', 3, 1),
(12, '3\" EMT Conduit, assamblie', '3\" emt', 3, 1),
(14, '1/2\" EMT Conduit assamblies', '1/2 emt', 3, 1),
(15, '3/4\" EMT Conduit, assamblie', '3/4 emt', 3, 1),
(16, '1/4\" x 1-1/4\" assamblie', '1/4\" x 1-1/4\"', 18, 1),
(18, '2\" EMT Conduit assamblie', '2\" EMT', 3, 1),
(19, '1-1/2\" EMT Conduit assamblie', '1-1/2\" EMT ', 3, 1),
(20, '3\" pvc Conduit, assamblie', '3\" pvc ', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `lastname`, `username`, `email`, `password`, `is_active`, `created_at`) VALUES
(1, 'Admin', 'User', 'admin', 'admin@example.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 1, '2025-03-10 10:57:09'),
(2, 'pedro', 'pedro', 'pedro', 'pedro@example.com', 'bdc7eb3cfc152df04e5f1fa283f7a96bc533a966', 1, '2025-03-11 10:28:48'),
(3, 'Alberto', 'Peguero', 'Alberto_P', 'alberto@example.com', 'adee9ec35875e63ac2fe254f5633723bb667cad8', 1, '2025-03-13 14:49:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_name` (`short_name`);

--
-- Indices de la tabla `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_name` (`short_name`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `category_id` (`category_id`);

--
-- Indices de la tabla `post_relations`
--
ALTER TABLE `post_relations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post_id` (`post_id`),
  ADD KEY `fk_related_id` (`related_id`);

--
-- Indices de la tabla `post_view`
--
ALTER TABLE `post_view`
  ADD PRIMARY KEY (`id`),
  ADD KEY `viewer_id` (`viewer_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indices de la tabla `product_subcategories`
--
ALTER TABLE `product_subcategories`
  ADD PRIMARY KEY (`post_id`,`subcategory_id`),
  ADD KEY `fk_subcategory` (`subcategory_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indices de la tabla `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_name` (`short_name`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=314;

--
-- AUTO_INCREMENT de la tabla `post_relations`
--
ALTER TABLE `post_relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `post_view`
--
ALTER TABLE `post_view`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `slide`
--
ALTER TABLE `slide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `post_relations`
--
ALTER TABLE `post_relations`
  ADD CONSTRAINT `fk_post_id` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `fk_related_id` FOREIGN KEY (`related_id`) REFERENCES `post` (`id`);

--
-- Filtros para la tabla `post_view`
--
ALTER TABLE `post_view`
  ADD CONSTRAINT `post_view_ibfk_1` FOREIGN KEY (`viewer_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `post_view_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `product_subcategories`
--
ALTER TABLE `product_subcategories`
  ADD CONSTRAINT `fk_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_subcategory` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
