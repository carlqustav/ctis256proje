-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 24, 2020 at 08:15 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bms`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

DROP TABLE IF EXISTS `bookmark`;
CREATE TABLE IF NOT EXISTS `bookmark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8mb4_turkish_ci NOT NULL,
  `url` varchar(512) COLLATE utf8mb4_turkish_ci NOT NULL,
  `note` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `owner` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(64) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`id`, `title`, `url`, `note`, `owner`, `created`, `category`) VALUES
(72, 'Free 3D Models', 'https://www.cgtrader.com/free-3d-models', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, nostrum? Molestiae ullam incidunt quos fuga repellendus quo officia hic numquam quis quaerat illum velit nulla, tempora aliquam reprehenderit, dolore maiores.', 74, '2020-05-06 15:29:11', 'Programming'),
(73, 'Yamaha Recent Motorbike Prices', 'https://www.yamaha-motor.eu/tr/tr/Deneyim/', 'A reprehenderit officiis mollitia tempora perferendis corrupti non nihil porro ipsa consequuntur error impedit similique pariatur commodi laudantium placeat, saepe quasi voluptas?\r\nDolorum, architecto! Autem laborum numquam voluptatum esse voluptatibus omnis minus reiciendis consequatur exercitationem, adipisci dolorum veritatis voluptates consequuntur sit illo voluptas, ipsa labore atque ratione hic? Ex cumque similique tempora.\r\nAd obcaecati dolor reiciendis delectus dicta ea, dolorem a porro, error', 74, '2020-05-06 15:51:53', NULL),
(74, 'PHP Reference Page', 'http://www.php.net', 'This site is the main page for php functions.', 74, '2020-05-06 15:52:26', 'Programming'),
(75, 'Learn about Material Design and our Project Team', 'https://materializecss.com/preloader.html', 'Created and designed by Google, Material Design is a design language that combines the classic principles of successful design along with innovation and technology. Google\'s goal is to develop a system of design that allows for a unified user experience across all their products on any platform.', 74, '2020-05-06 15:53:23', 'Programming'),
(76, 'The new way to improve your programming skills while having fun and getting noticed', 'https://www.codingame.com/start', 'At CodinGame, our goal is to let programmers keep on improving their coding skills by solving the World\'s most challenging problems, learn new concepts, and get inspired by the best developers.', 74, '2020-05-06 15:54:50', 'Programming'),
(77, 'Unity ', 'https://unity.com/', 'Create, operate, and monetize your interactive and immersive experiences with the world’s most widely used real-time development platform.', 74, '2020-05-06 15:56:26', 'Programming'),
(78, 'WebGL Fundamentals', 'https://webglfundamentals.org/', 'WebGL (Web Graphics Library) is often thought of as a 3D API. People think \"I\'ll use WebGL and magic I\'ll get cool 3d\". In reality WebGL is just a rasterization engine. It draws points, lines, and triangles based on code you supply. Getting WebGL to do anything else is up to you to provide code to use points, lines, and triangles to accomplish your task.', 74, '2020-05-06 15:57:32', 'Programming'),
(79, 'Exploring ES6', 'https://exploringjs.com/es6/', 'Free book for ES6', 74, '2020-05-06 15:58:49', 'Programming'),
(80, 'Clara.io for 3D Modelling', 'https://clara.io/learn/user-guide/modeling/modeling_basics', 'Modeling is the process of creating 3D geometric meshes that will eventually be textured, animated, and rendered in your final product.', 74, '2020-05-06 15:59:53', 'Programming'),
(83, 'Europa Universalis IV', 'https://store.steampowered.com/app/236850/Europa_Universalis_IV/', 'The empire building game Europa Universalis IV gives you control of a nation to guide through the years in order to create a dominant global empire. Rule your nation through the centuries, with unparalleled freedom, depth and historical accuracy.', 74, '2020-05-19 22:01:45', 'Games'),
(84, 'Sid Meier\'s Civilization® V', 'https://store.steampowered.com/app/8930/Sid_Meiers_Civilization_V/', 'Create, discover, and download new player-created maps, scenarios, interfaces, and more!', 74, '2020-05-19 22:01:45', 'Games'),
(85, 'The Binding of Isaac: Rebirth', 'https://store.steampowered.com/app/250900/The_Binding_of_Isaac_Rebirth/', 'The Binding of Isaac: Rebirth is a randomly generated action RPG shooter with heavy Rogue-like elements. Following Isaac on his journey players will find bizarre treasures that change Isaac’s form giving him super human abilities and enabling him to fight off droves of mysterious creatures, discover secrets and fight his way to safety.\r\n', 74, '2020-05-19 22:06:38', 'Games'),
(86, 'Kerbal Space Program\r\n', 'https://store.steampowered.com/app/220200/Kerbal_Space_Program/', 'n Kerbal Space Program, take charge of the space program for the alien race known as the Kerbals. You have access to an array of parts to assemble fully-functional spacecraft that flies (or doesn’t) based on realistic aerodynamic and orbital physics.', 74, '2020-05-19 22:06:38', 'Games'),
(87, 'The Elder Scrolls V: Skyrim', 'https://store.steampowered.com/app/72850/The_Elder_Scrolls_V_Skyrim/', 'EPIC FANTASY REBORN The next chapter in the highly anticipated Elder Scrolls saga arrives from the makers of the 2006 and 2008 Games of the Year, Bethesda Game Studios. Skyrim reimagines and revolutionizes the open-world fantasy epic, bringing to life a complete virtual world open for you to explore ', 74, '2020-05-19 22:06:38', 'Games'),
(88, 'Team Fortress 2', 'https://store.steampowered.com/app/440/Team_Fortress_2/', 'Nine distinct classes provide a broad range of tactical abilities and personalities. Constantly updated with new game modes, maps, equipment and, most importantly, hats!', 74, '2020-05-19 22:06:38', 'Games'),
(89, 'Cities: Skylines', 'https://store.steampowered.com/app/255710/Cities_Skylines/', 'Cities: Skylines is a modern take on the classic city simulation. The game introduces new game play elements to realize the thrill and hardships of creating and maintaining a real city whilst expanding on some well-established tropes of the city building experience.', 74, '2020-05-19 22:06:38', 'Games'),
(90, 'Stellaris', 'https://store.steampowered.com/app/281990/Stellaris/', 'Explore and discover a spectacular and ever-changing universe! Paradox Development Studio, makers of the Europa Universalis and Crusader Kings series, and publishers of the best-selling Cities: Skylines, presents Stellaris, advancing the genre of grand strategy to the very edges of the universe.', 74, '2020-05-19 22:06:38', 'Games'),
(91, 'PLAYERUNKNOWN\'S BATTLEGROUNDS', 'https://store.steampowered.com/app/578080/PLAYERUNKNOWNS_BATTLEGROUNDS/', 'PLAYERUNKNOWN\'S BATTLEGROUNDS is a battle royale shooter that pits 100 players against each other in a struggle for survival. Gather supplies and outwit your opponents to become the last person standing.', 74, '2020-05-19 22:06:38', 'Games'),
(92, 'Mount & Blade: Warband', 'https://store.steampowered.com/app/48700/Mount__Blade_Warband/', 'In a land torn asunder by incessant warfare, it is time to assemble your own band of hardened warriors and enter the fray. Lead your men into battle, expand your realm, and claim the ultimate prize: the throne of Calradia!', 74, '2020-05-19 22:06:38', 'Games'),
(93, 'RimWorld', 'https://store.steampowered.com/app/294100/RimWorld/', 'A sci-fi colony sim driven by an intelligent AI storyteller. Generates stories by simulating psychology, ecology, gunplay, melee combat, climate, biomes, diplomacy, interpersonal relationships, art, medicine, trade, and more.\r\n', 74, '2020-05-19 22:06:38', 'Games'),
(94, 'Fallout: New Vegas', 'https://store.steampowered.com/app/22380/Fallout_New_Vegas/', 'Welcome to Vegas. New Vegas. Enjoy your stay!', 74, '2020-05-19 22:06:38', 'Games'),
(96, 'DrJava', 'asdasd', 'ide', 74, '2020-05-20 03:42:47', 'Programming'),
(140, 'Free 3D Models', 'https://www.cgtrader.com/free-3d-models', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, nostrum? Molestiae ullam incidunt quos fuga repellendus quo officia hic numquam quis quaerat illum velit nulla, tempora aliquam reprehenderit, dolore maiores.', 74, '2020-05-24 05:46:12', 'Programming'),
(165, 'DrJava', 'asdasd', 'ide', 76, '2020-05-24 06:44:29', 'Programming'),
(166, 'Learn about Material Design and our Project Team', 'https://materializecss.com/preloader.html', 'Created and designed by Google, Material Design is a design language that combines the classic principles of successful design along with innovation and technology. Google', 76, '2020-05-24 06:45:15', 'Programming'),
(167, 'The new way to improve your programming skills while having fun and getting noticed', 'https://www.codingame.com/start', 'At CodinGame, our goal is to let programmers keep on improving their coding skills by solving the World', 76, '2020-05-24 06:45:19', 'Programming'),
(168, 'Osmaniye', 'osman.com.tr', 'osmaniye', 76, '2020-05-24 07:55:55', 'Programming');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(18, 'Programming'),
(2, 'Games');

-- --------------------------------------------------------

--
-- Table structure for table `share`
--

DROP TABLE IF EXISTS `share`;
CREATE TABLE IF NOT EXISTS `share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bm_id` int(11) NOT NULL,
  `own_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8mb4_turkish_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_turkish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `bday` date DEFAULT NULL,
  `profile` varchar(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `bday`, `profile`) VALUES
(72, 'Mustafa Kurnaz', 'mkurnaz@gmail.com', '$2y$10$Z/7F3o4vNOmx2y/pwtDFwuV2f2QmGBSc.I7qPpM6kzVfL.i/XfnoW', NULL, NULL),
(73, 'Özge Canlı', 'canli@one.com', '$2y$10$hlYrJq3Beaaks3ZrwogfHuwLyjLDhZsdJDNghhLsTRs97E1BlVGim', NULL, NULL),
(74, 'John Vue', 'john@one.com', '$2y$10$N6aPrvxea69QG8uZoLNJ9OaS0soLpyDzwpcuRyXHWtOfvAHNvwLxC', NULL, '874c283f485691d815b5735ec3fceb2b2a62882d_john-travolta.jpg'),
(76, 'Can Vue', 'can@one.com', '$2y$10$N6aPrvxea69QG8uZoLNJ9OaS0soLpyDzwpcuRyXHWtOfvAHNvwLxC', NULL, '5f8f723d4d33be223e720e7d43552aceed670742_cem.jpg');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
