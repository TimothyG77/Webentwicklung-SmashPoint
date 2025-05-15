-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 15. Mai 2025 um 20:16
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `smashpoint`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `shipping_adress` text NOT NULL,
  `invoice_number` int(50) NOT NULL,
  `voucher_percent` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_each` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `produkte`
--

CREATE TABLE `produkte` (
  `ID` int(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `product_picture` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `produkte`
--

INSERT INTO `produkte` (`ID`, `product_name`, `product_description`, `price`, `product_picture`, `category`) VALUES
(28, 'Babolat 1 Bälle', 'Bälle zum Benutzen für Badminton.', 34.99, 'productpictures/Baelle/Babolat_1.jpg', 'Baelle'),
(29, 'Babolat 2 Bälle', 'Bälle für Badminton. ', 25.99, 'productpictures/Baelle/Babolat_2.jpg', 'Baelle'),
(30, 'Babolat 4 Bälle', 'Badmintonbälle für Turniere. Absolut beste Haltbarkeit.', 15.99, 'productpictures/Baelle/Babolat_4.jpg', 'Baelle'),
(31, 'Damen Babolat Shorts Schwarz', 'Angenehme Kleidung zum Anziehen.', 39.99, 'productpictures/Bekleidung-Damen/Damen_Babolat_Short_schwarz.jpg', 'Bekleidung-Damen'),
(32, 'Damen Babolat Skirts Schwarz', 'Damenrock fürs Badminton.', 23.99, 'productpictures/Bekleidung-Damen/Damen_Babolat_Skirt_schwarz.jpg', 'Bekleidung-Damen'),
(33, 'Babolat Sleeve Top Blau', 'Angenehme Kleidung für stundenlangen Sport in Badminton.', 26.99, 'productpictures/Bekleidung-Damen/Babolat_Sleeve_Top_blau_front.jpg', 'Bekleidung-Damen'),
(34, 'Babolat Sleeve Top Rot ', 'Angenehme wunderschöne Kleidung für langes Sportsessions ohne zu schwitzen.', 36.99, 'productpictures/Bekleidung-Damen/Babolat_Sleeve_Top_rot_front.jpg', 'Bekleidung-Damen'),
(35, 'Babolat Sleeve Top Schwarz', 'Angenehme Kleidung für Badminton spielen.', 37.99, 'productpictures/Bekleidung-Damen/Babolat_Sleeve_Top_schwarz_front.jpg', 'Bekleidung-Damen'),
(36, 'Damenkleidung Victor Shorts Schwarz', 'Angenehme Kleidung fürs Badminton spielen.', 29.99, 'productpictures/Bekleidung-Damen/Damen_Victor_Shorts_schwarz.jpg', 'Bekleidung-Damen'),
(37, 'Damen Skirt Victor Schwarz', 'Damenkleidung fürs Badminton spielen.', 28.99, 'productpictures/Bekleidung-Damen/Damen_Victor_Skirt_schwarz.jpg', 'Bekleidung-Damen'),
(38, 'Damenkleidung Victor T-Shirt Blau', 'Damenkleidung passend für Badminton.', 44.99, 'productpictures/Bekleidung-Damen/Damen_Victor_T-Shirt_blau_front.jpg', 'Bekleidung-Damen'),
(39, 'Damenkleidung Victor T-Shirt Rot', 'Damnekleidung für Badminton.', 59.99, 'productpictures/Bekleidung-Damen/Damen_Victor_T-Shirt_rot_front.jpg', 'Bekleidung-Damen'),
(40, 'Damenkleidung Victor T-Shirt Schwarz', 'Damenkleidung für Badminton.', 37.99, 'productpictures/Bekleidung-Damen/Damen_Victor_T-Shirt_schwarz_front.jpg', 'Bekleidung-Damen'),
(41, 'Damenkleidung Yonex Crew Neck Blau', 'Damenkleidung für Badminton.', 45.99, 'productpictures/Bekleidung-Damen/Yonex_Crew_Neck_blau_front.jpg', 'Bekleidung-Damen'),
(42, 'Damenkleidung Yonex Crew Neck Peppermint', 'Damenkleidung für Badminton.', 39.99, 'productpictures/Bekleidung-Damen/Yonex_Crew_Neck_peppermint_front.jpg', 'Bekleidung-Damen'),
(43, 'Damenkleidung Yonex Crew Neck Rot ', 'Damenkleidung für Badminton', 79.99, 'productpictures/Bekleidung-Damen/Yonex_Crew_Neck_rot_front.jpg', 'Bekleidung-Damen'),
(44, 'Damenkleidung Yonex Crew Neck Schwarz', 'Damenkleidung für Badminton.', 49.99, 'productpictures/Bekleidung-Damen/Yonex_Crew_Neck_schwarz_front.jpg', 'Bekleidung-Damen'),
(45, 'Damenkleidung Yonex Short Schwarz', 'Damenkleidung für Badminton, angenehm zu tragen.', 41.99, 'productpictures/Bekleidung-Damen/Damen_Yonex_Short_schwarz.jpg', 'Bekleidung-Damen'),
(46, 'Damenkleidung Yonex Skirt Schwarz', 'Damenkleidung für Badminton, angenehm zu tragen.', 51.99, 'productpictures/Bekleidung-Damen/Damen_Yonex_Skirt_schwarz.jpg', 'Bekleidung-Damen'),
(47, 'Babolat Crew Neck Blau', 'Herrenkleidung für Badminton, angenehm zu tragen.', 53.99, 'productpictures/Bekleidung-Herren/Babolat_Crew_Neck_blau_front.jpg', 'Bekleidung-Herren'),
(48, 'Herrenkleidung Babolat Crew Neck Rot Front', 'Herrenkleidung für Badminton, angenehm zu tragen.', 49.99, 'productpictures/Bekleidung-Herren/Babolat_Crew_Neck_rot_front.jpg', 'Bekleidung-Herren'),
(49, 'Herrenkleidung Babolat Crew Neck Schwarz', 'Herrenkleidung für Badminton, angenehm zu tragen, für lange Sportsessions.', 79.99, 'productpictures/Bekleidung-Herren/Babolat_Crew_Neck_schwarz_front.jpg', 'Bekleidung-Herren'),
(50, 'Herrenkleidung Victor Shorts Schwarz', 'Herrenkleidung angenehm zu tragen für Badminton.', 56.99, 'productpictures/Bekleidung-Herren/Victor_Shorts_schwarz.jpg', 'Bekleidung-Herren'),
(51, 'Herrenkleidung Victor T-Shirt Blau', 'Herrenkleidung für Badminton, angenehm zu tragen für lange Sportsessions.', 63.99, 'productpictures/Bekleidung-Herren/Victor_T-Shirt_blau_front.jpg', 'Bekleidung-Herren'),
(52, 'Herrenkleidung Victor T-Shirt Rot', 'Herrenkleidung angenehm zu tragen für Badminton.', 79.99, 'productpictures/Bekleidung-Herren/Victor_T-Shirt_rot_front.jpg', 'Bekleidung-Herren'),
(53, 'Herrenkleidung Victor T-Shirt Schwarz ', 'Kleidung für Herren, angenehm zu tragen für lange Sportsessions in Badminton.', 84.99, 'productpictures/Bekleidung-Herren/Victor_T-Shirt_schwarz_front.jpg', 'Bekleidung-Herren'),
(54, 'Herrenkleidung Yonex Crew Neck Blau', 'Herrenkleidung für Badminton, angenehm zu tragen für lange Sportsessions.', 64.99, 'productpictures/Bekleidung-Herren/Yonex_Crew_Neck_blau_front.jpg', 'Bekleidung-Herren'),
(55, 'Herrenkleidung Yonex Crew Neck Peppermint', 'Herrenkleidung angenehm zu tragen für lange Sportsessions in Badminton.', 49.99, 'productpictures/Bekleidung-Herren/Yonex_Crew_Neck_peppermint_front.jpg', 'Bekleidung-Herren'),
(56, 'Herrenkleidung Yonex Crew Neck Rot', 'Angenehme Kleidung zum Tragen für lange Sportsessions in Badminton.', 69.99, 'productpictures/Bekleidung-Herren/Yonex_Crew_Neck_rot_front.jpg', 'Bekleidung-Herren'),
(57, 'Herrenkleidung Yonex Crew Neck Schwarz', 'Herrenkleidung passend für lange Badminton Sessions.', 89.99, 'productpictures/Bekleidung-Herren/Yonex_Crew_Neck_schwarz_front.jpg', 'Bekleidung-Herren'),
(58, 'Griffbänder Babolat Sensation Grip Black', 'Griffbänder um ein angenehmes Gefühl zu verspüren, wenn man den Schläger hält.', 9.99, 'productpictures/Griffbaender/Babolat_Sensation_Grip_black.jpg', 'Griffbaender'),
(59, 'Griffbänder babolat Sensation Grip Weiß', 'Griffbänder zum Benutzen für Schläger um einen besseren Grip zu haben beim Spielen.', 14.99, 'productpictures/Griffbaender/Babolat_Sensation_Grip_white.jpg', 'Griffbaender'),
(60, 'Griffbänder Babolat Sensation Grip Yellow', 'Griffbänder für Badmintonschläger.', 7.99, 'productpictures/Griffbaender/Babolat_Sensation_Grip_yellow.jpg', 'Griffbaender'),
(61, 'Griffbänder Victor Frottee Grip', 'Griffbänder für die Badmintonschläger', 15.99, 'productpictures/Griffbaender/Victor_Frottee_Grip.jpg', 'Griffbaender'),
(62, 'Griffbänder Victor Soft Grip', 'Griffbänder für Badmintonschläger.', 19.99, 'productpictures/Griffbaender/Victor_Soft_Grip.jpg', 'Griffbaender'),
(63, 'Griffbänder Yonex Dry Super', 'Griffbänder von Yonex für Badmintonschläger.', 14.99, 'productpictures/Griffbaender/Yonex_Dry_Super_Grap.jpg', 'Griffbaender'),
(64, 'Griffbänder Yonex Wet Super', 'Griffbänder für Badmintonschläger.', 16.99, 'productpictures/Griffbaender/Yonex_Wet_Super_Grap.jpg', 'Griffbaender'),
(65, 'Saiten Babolat Ifeel 66', 'Saiten für Badmintonschläger.', 9.99, 'productpictures/Saiten/Babolat_I_Feel_66.jpg', 'Saiten'),
(66, 'Saiten Babolat Ifeel 68', 'Saiten für den Badmintonschläger.', 11.99, 'productpictures/Saiten/Babolat_I_Feel_68.jpg', 'Saiten'),
(67, 'Saiten Babolat Ifeel 70', 'Saiten für Badmintonschläger.', 12.99, 'productpictures/Saiten/Babolat_I_Feel_70.jpg', 'Saiten'),
(68, 'Saiten Victor VBS-63', 'Satien für Badmintonschläger.', 11.99, 'productpictures/Saiten/Victor_VBS-63.jpg', 'Saiten'),
(69, 'Saiten Victor-VBS-66N', 'Saiten für Badmintonschläger.', 14.99, 'productpictures/Saiten/Victor_VBS-66N.jpg', 'Saiten'),
(70, 'Saiten Victor VBS-70', 'Saiten für Badmintonschläger.', 15.99, 'productpictures/Saiten/Victor_VBS-70.jpg', 'Saiten'),
(71, 'Saiten Yonex Aeropbyte', 'Saiten für Badmintonschläger.', 16.99, 'productpictures/Saiten/Yonex_Aeropbyte.jpg', 'Saiten'),
(72, 'Saiten Yonex BG 65', 'Saiten für den Badmintonschläger.', 10.99, 'productpictures/Saiten/Yonex_BG_65.jpg', 'Saiten'),
(73, 'Saiten Yonex BG 80', 'Saiten für den Badmintonschläger.', 9.99, 'productpictures/Saiten/Yonex_BG_80.jpg', 'Saiten'),
(74, 'Badmintonschläger Babolat Jetstream 83', 'Badmintonschläger sehr kopflastig für einen guten Schlag im Spiel.', 74.99, 'productpictures/Schlaeger/Babolat_Jetstream_83.jpg', 'Schlaeger'),
(75, 'Badmintonschläger Babolat X-Feel-Fury-Ti', 'Badmintonschläger mit langer Haltbarkeit', 89.99, 'productpictures/Schlaeger/Babolat_X-Feel_Fury_Ti.jpg', 'Schlaeger'),
(76, 'Badmintonschläger Babolat X-Feel-Spark', 'Badmintonschläger mit langer Haltbarkeit.', 99.99, 'productpictures/Schlaeger/Babolat_X-Feel_Spark.jpg', 'Schlaeger'),
(77, 'Badmintonschläger Victor Auraspeed-100X-Ultra', 'Badmintonschläger mit langer Haltbarkeit.', 109.99, 'productpictures/Schlaeger/Victor_Auraspeed_100X_Ultra_G.jpg', 'Schlaeger'),
(78, 'Badmintonschläger Victor-DriveX-FT', 'Badmintonschläger mit langer Haltbarkeit.', 149.99, 'productpictures/Schlaeger/Victor_DriveX_F_T.jpg', 'Schlaeger'),
(79, 'Badmintonschläger Victor Thruster RYUGA-TD-C', 'Badmintonschläger mit langer Haltbarkeit.', 209.99, 'productpictures/Schlaeger/Victor_Thruster_RYUGA_TD_C.jpg', 'Schlaeger'),
(80, 'Badmintonschläger Yonex Arcsaber-11-Pro', 'Badmintonschläger mit langer Haltbarkeit.', 114.99, 'productpictures/Schlaeger/Yonex_Arcsaber_11_Pro.jpg', 'Schlaeger'),
(81, 'Badmintonschläger Yonex Astrox-100ZZ', 'Badmintonschläger mit langer Haltbarkeit.', 179.99, 'productpictures/Schlaeger/Yonex_Astrox_100ZZ.jpg', 'Schlaeger'),
(82, 'Badmintonschläger Yonex Nanoflare-100Z', 'Badmintonschläger mit langer Haltbarkeit.', 179.99, 'productpictures/Schlaeger/Yonex_Nanoflare_100Z.jpg', 'Schlaeger'),
(83, 'Schuhe Babolat Shadow Spirit 2', 'Badmintonschuhe mit guter Haltbarkeit und gut zum Benutzen für lange Trainingssessions.', 79.99, 'productpictures/Schuhe/Babolat_Shadow_Spirit_2.jpg', 'Schuhe'),
(84, 'Schuhe Babolat Shadow Team 2', 'Badmintonschuhe mit guter Haltbarkeit und gut zum Benutzen für lange Trainingssessions.', 89.99, 'productpictures/Schuhe/Babolat_Shadow_Team_2.jpg', 'Schuhe'),
(85, 'Schuhe Babolat Shadow Tour 5', 'Badmintonschuhe mit guter Haltbarkeit und gut zum Benutzen für lange Trainingssessions.', 69.99, 'productpictures/Schuhe/Babolat_Shadow_Tour_5.jpg', 'Schuhe'),
(86, 'Schuhe Victor A170-A', 'Badmintonschuhe mit guter Haltbarkeit und gut zum Benutzen für lange Trainingssessions.', 109.99, 'productpictures/Schuhe/Victor_A170_A.jpg', 'Schuhe'),
(87, 'Schuhe Victor A610IVF-AH', 'Schuhe von Victor, mit guter Haltbarkeit und gut zum Benutzen für lange Trainingssessions.', 149.99, 'productpictures/Schuhe/Victor_A610IVF_AH.jpg', 'Schuhe'),
(88, 'Schuhe Victor C90NLite-A', 'Badmintonschuhe mit guter Haltbarkeit und gut zum Benutzen für lange Trainingssessions.', 129.99, 'productpictures/Schuhe/Victor_C90NLite_A.jpg', 'Schuhe'),
(89, 'Schuhe Yonex Power Cushion 65Z', 'Badmintonschuhe mit guter Haltbarkeit und gut zum Benutzen für lange Trainingssessions.', 79.99, 'productpictures/Schuhe/Yonex_Power_Cushion_65Z.jpg', 'Schuhe'),
(90, 'Yonex Power Cushion Aerus-Z', 'Badmintonschuhe mit guter Haltbarkeit und gut zum Benutzen für lange Trainingssessions.', 89.99, 'productpictures/Schuhe/Yonex_Power_Cushion_Aerus_Z.jpg', 'Schuhe'),
(91, 'Schuhe Yonex Power Cushion Comfort-Z', 'Badmintonschuhe mit guter Haltbarkeit und gut zum Benutzen für lange Trainingssessions.', 109.99, 'productpictures/Schuhe/Yonex_Power_Cushion_Comfort_Z.jpg', 'Schuhe'),
(92, 'Tasche Babolat Court Backpack-Hero', 'Tasche für Badminton mit viel Platz zum Einpacken von Schlägern sowie Bällen.', 134.99, 'productpictures/Taschen/Babolat_Court_Backpack_Hero.jpg', 'Taschen'),
(93, 'Tasche Babolat-Court-L', 'Tasche für Badminton mit viel Platz zum Einpacken von Schlägern sowie Bällen.', 124.99, 'productpictures/Taschen/Babolat_Court_L.jpg', 'Taschen'),
(94, 'Tasche Babolat-Court-M', 'Tasche für Badminton mit viel Platz zum Einpacken von Schlägern sowie Bällen.', 149.99, 'productpictures/Taschen/Babolat_Court_M.jpg', 'Taschen'),
(95, 'Tasche Victor Doublethermobag-9115-D', 'Tasche für Badminton mit viel Platz zum Einpacken von Schlägern sowie Bällen.', 139.99, 'productpictures/Taschen/Victor_Doublethermobag_9115_D.jpg', 'Taschen'),
(96, 'Tasche Victor Multithermobag-BR9319-CF', 'Tasche für Badminton mit viel Platz zum Einpacken von Schlägern sowie Bällen.', 239.99, 'productpictures/Taschen/Victor_Multithermobag_BR9313_CF.jpg', 'Taschen'),
(97, 'Tasche Victor Rucksack-BR7007-CM', 'Tasche für Badminton mit viel Platz zum Einpacken von Schlägern sowie Bällen.', 179.99, 'productpictures/Taschen/Victor_Rucksack_BR7007_CM.jpg', 'Taschen'),
(98, 'Tasche Yonex-Pro-Backpack-B', 'Tasche für Badminton mit viel Platz zum Einpacken von Schlägern sowie Bällen.', 113.99, 'productpictures/Taschen/Yonex_Pro_Backpack_B.jpg', 'Taschen'),
(99, 'Tasche Yonex Pro Raquet Bag-6', 'Tasche für Badminton mit viel Platz zum Einpacken von Schlägern sowie Bällen.', 129.99, 'productpictures/Taschen/Yonex_Pro_Racquet_Bag_6.jpg', 'Taschen'),
(100, 'Tasche Yonex Pro Tournament Bag', 'Tasche für Badminton mit viel Platz zum Einpacken von Schlägern sowie Bällen.', 104.99, 'productpictures/Taschen/Yonex_Pro_Tournament_Bag.jpg', 'Taschen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `ID` int(255) NOT NULL,
  `salutation` enum('Herr','Frau','Divers','') NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` int(10) NOT NULL,
  `city` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `status` enum('aktiv','inaktiv') NOT NULL DEFAULT 'aktiv',
  `payment_method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`ID`, `salutation`, `firstname`, `lastname`, `address`, `postal_code`, `city`, `email`, `username`, `password`, `role`, `status`, `payment_method`) VALUES
(22, 'Herr', 'Admina', 'AdminLaa', 'qwerwefrg', 1154, 'wergt', 'admin@gmail.com', 'admin', '$2y$10$XNQZSEx.4rvxbkLQ92ukQeyqCrr7WvdPxClrTC9a8w9ba/c0sft8C', 'admin', 'aktiv', ''),
(26, 'Frau', 'Natalie', 'adefssddasd', 'awdafgsdfhgj', 1140, 'Wien', 'Natalie@gmail.com', 'natalie77.', '$2y$10$/KP1iEMvjqVPp.alYtrhMuZFjLfKKwoC3foiJx8zBabb9A2EpAHZi', 'user', 'aktiv', ''),
(29, 'Herr', 'Timothy', 'Gregorian', 'Dembelestraße 77', 1180, 'Wien', 'timmy.greg@gmail.com', 'Timothy77$', '$2y$10$zefRRhm0cCG9TAYVHxMgLu5rLjrXGpAbDMNIJ7dbYMuH5Qzl6Gl1C', 'user', 'aktiv', ''),
(30, 'Herr', 'Felix', 'Dallinger', 'Burgenlandsstraße 2', 4050, 'Eisenstadt', 'felix.dallinger@gmail.com', 'Felix-85', '$2y$10$rfJTH4ylYwWmazOYkr92GesQB84SjS/C8nkOJ8vApznKw9SIxer3O', 'user', 'aktiv', ''),
(31, 'Herr', 'Manpreet', 'Misson', 'Landstraße 47', 1030, 'Wien', 'manpreet.misson@gmail.com', 'Manpreet78?', '$2y$10$RNBK9T9Su9imcF0Cx5jDWeLxIvgfpteNA7E9mEiHPybhDgarrfWGi', 'user', 'aktiv', ''),
(32, 'Herr', 'Moritz ', 'Heberle', 'Bayerngasse 31', 11980, 'Bayern', 'moritz.heberle@gmail.com', 'moritz-b7', '$2y$10$sMBu6qrVpY.GWAby1EIdOeieJ9xjhoDpp0VtNz1WxNWrnpmP2TKaq', 'user', 'aktiv', ''),
(33, 'Herr', 'Philip', 'Zeisler', 'Badmintonstraße 45', 1200, 'Wien', 'philip.zeisler@gmail.com', 'Philip-Mint99', '$2y$10$4TAuBo78Zw6vFNUP1FY/COgNHsWtnzPj.3rlMSbmSFo706L3cESBS', 'user', 'aktiv', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `value` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `value`, `created_at`, `expires_at`, `used`) VALUES
(14, 'KC7GB', 15, '2025-05-15 19:59:36', '2025-06-14 19:59:36', 0),
(15, 'GC2UJ', 15, '2025-05-15 19:59:37', '2025-06-14 19:59:37', 0),
(16, 'Z8H4B', 15, '2025-05-15 19:59:38', '2025-06-14 19:59:38', 0),
(17, 'FPBZ9', 15, '2025-05-15 19:59:39', '2025-06-14 19:59:39', 0),
(18, 'HSLPH', 15, '2025-05-15 19:59:40', '2025-06-14 19:59:40', 0),
(19, 'U07KT', 15, '2025-05-15 19:59:41', '2025-06-14 19:59:41', 0),
(20, 'WQKXY', 15, '2025-05-15 19:59:42', '2025-06-14 19:59:42', 0),
(21, '2O5HG', 15, '2025-05-15 19:59:43', '2025-06-14 19:59:43', 0),
(22, 'HMD4R', 15, '2025-05-15 19:59:43', '2025-06-14 19:59:43', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indizes für die Tabelle `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indizes für die Tabelle `produkte`
--
ALTER TABLE `produkte`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT für Tabelle `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT für Tabelle `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT für Tabelle `produkte`
--
ALTER TABLE `produkte`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT für Tabelle `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
