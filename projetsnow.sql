-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 15 juin 2022 à 12:50
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projetsnow`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `slug`) VALUES
(145, 'grab', 'Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »', 'grab'),
(146, 'rotation', 'On désigne par le mot « rotation » uniquement des rotations horizontales ; les rotations verticales sont des flips.', 'rotation'),
(147, 'flip', 'Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière.', 'flip'),
(148, 'slide', 'Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l\'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé.', 'slide'),
(149, 'old school', 'Le terme old school désigne un style de freestyle caractérisée par en ensemble de figure et une manière de réaliser des figures passée de mode, qui fait penser au freestyle des années 1980 - début 1990 ', 'old-school');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `trick_id`, `created_at`, `message`) VALUES
(34, 96, 40, '2022-05-07 19:43:11', 'Extra trick'),
(35, 97, 41, '2022-05-07 19:43:11', 'Fantastique'),
(36, 98, 42, '2022-05-07 19:43:11', 'Genial'),
(37, 99, 43, '2022-05-07 19:43:11', 'Extraordinaire'),
(38, 95, 44, '2022-05-07 19:43:11', 'Incroyable'),
(39, 96, 45, '2022-05-07 19:43:11', 'Superbe'),
(40, 97, 46, '2022-05-07 19:43:11', 'Sans faute'),
(41, 98, 47, '2022-05-07 19:43:11', 'Très bien'),
(42, 99, 48, '2022-05-07 19:43:11', 'Bon courage'),
(43, 97, 49, '2022-05-07 19:43:11', 'C\'est genial'),
(44, 95, 45, '2022-05-08 18:39:32', 'Beau trick'),
(45, 95, 41, '2022-05-09 14:25:21', 'C\'est extraordinaire'),
(46, 100, 44, '2022-05-10 14:11:40', 'Comments nouveaux'),
(47, 100, 56, '2022-05-19 10:42:27', 'Joli trick'),
(48, 100, 44, '2022-05-19 10:43:08', 'Joli trick');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220328204924', '2022-03-28 22:51:49', 11936),
('DoctrineMigrations\\Version20220329120812', '2022-03-29 14:26:38', 681),
('DoctrineMigrations\\Version20220329122613', '2022-03-29 14:26:39', 4641),
('DoctrineMigrations\\Version20220403155801', '2022-04-03 18:00:01', 2027),
('DoctrineMigrations\\Version20220404174908', '2022-04-04 19:50:36', 4570),
('DoctrineMigrations\\Version20220405121412', '2022-04-05 14:14:52', 6857),
('DoctrineMigrations\\Version20220405123031', '2022-04-05 14:30:50', 1356),
('DoctrineMigrations\\Version20220405131505', '2022-04-05 15:15:30', 1502),
('DoctrineMigrations\\Version20220407124208', '2022-04-07 14:42:33', 2425),
('DoctrineMigrations\\Version20220407125453', '2022-04-07 14:55:08', 623),
('DoctrineMigrations\\Version20220408083301', '2022-04-08 10:33:34', 4483),
('DoctrineMigrations\\Version20220408121232', '2022-04-08 14:14:35', 1595),
('DoctrineMigrations\\Version20220420150017', '2022-04-20 17:02:31', 2003);

-- --------------------------------------------------------

--
-- Structure de la table `picture`
--

CREATE TABLE `picture` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `picture`
--

INSERT INTO `picture` (`id`, `trick_id`, `filename`, `main`) VALUES
(32, 40, 'trick-1.jpg', 1),
(33, 41, 'trick-2.jpg', 1),
(34, 42, 'trick-3.jpg', 1),
(35, 43, 'trick-4.jpg', 1),
(36, 44, 'trick-5.jpg', 1),
(37, 45, 'trick-6.jpg', 1),
(38, 46, 'trick-7.jpg', 1),
(39, 47, 'trick-8.jpg', 1),
(40, 48, 'trick-9.jpg', 1),
(41, 49, 'trick-10.jpg', 1),
(56, 57, 'c142fb5efd9824c1f70262d06dc71087.jpg', 0),
(57, 56, '2dfd4c66245d2cb8e9433f1c0fcb1f0f.jpg', 1),
(60, 58, 'adff58dfa366e6965e394ced844e40fe.jpg', 0),
(62, 57, 'd24211ab1a94c7695f7a54008dff28ac.jpg', 1),
(63, 58, '3aa3951cc7ad93b1076d1af83608e254.jpg', 1),
(70, 59, '33751e828547c11756185b702a2740d0.jpg', 1),
(72, 59, 'ec03ba11af896296a9f181376a848062.jpg', 0),
(73, 59, '729918a7158946b8aa5e13d3b285bc90.jpg', 0),
(75, 59, 'cb31f136df083f7c66dc44017f184418.jpg', 0),
(76, 59, 'f8d154bfb9d011c2c990b47bca880d30.jpg', 0),
(77, 41, '960d1e49507c3dc2ccd02cba6363a562.jpg', 0),
(78, 41, '51a34d8f5bea514da2d094907eabe631.jpg', 0),
(79, 41, 'c8d7f2035511c9b3707f040703b5bbe0.jpg', 0),
(82, 74, '76e86a0ec9f5006876a1405b77b6db32.jpg', 1),
(83, 74, '85b90bed4f10eff3e0f7efe3bb2568fc.jpg', 0);

-- --------------------------------------------------------

--
-- Structure de la table `trick`
--

CREATE TABLE `trick` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick`
--

INSERT INTO `trick` (`id`, `user_id`, `category_id`, `name`, `created_at`, `updated_at`, `content`, `slug`) VALUES
(40, 95, 145, 'Mute', '2022-05-07 19:43:10', NULL, 'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant', 'mute'),
(41, 100, 145, 'Indy', '2022-05-07 19:43:10', '2022-06-09 20:03:29', 'Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière', 'Indy'),
(42, 96, 148, 'Un slide', '2022-05-07 19:43:10', NULL, 'Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l\'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé.', 'un-slide'),
(43, 97, 149, 'Figures désuètes', '2022-05-07 19:43:10', NULL, 'Japan air - saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside', 'figures-desuetes'),
(44, 98, 145, 'Tail grab', '2022-05-07 19:43:11', NULL, 'Saisie de la partie arrière de la planche, avec la main arrière', 'tail-grab'),
(45, 99, 147, 'Un flip', '2022-05-07 19:43:11', NULL, 'Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière. Il est possible de faire plusieurs flips à la suite, et d\'ajouter un grab à la rotation.', 'un-flip'),
(46, 97, 146, 'Un 180', '2022-05-07 19:43:11', NULL, 'Un 180 désigne un demi-tour, soit 180 degrés d\'angle', 'un-180'),
(47, 96, 145, 'Seat belt', '2022-05-07 19:43:11', NULL, 'Saisie du carre frontside à l\'arrière avec la main avant', 'seat-belt'),
(48, 97, 145, 'Truck driver', '2022-05-07 19:43:11', NULL, 'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)', 'truck-driver'),
(49, 97, 145, 'Nose grab', '2022-05-07 19:43:11', NULL, 'Saisie de la partie avant de la planche, avec la main avant', 'nose-grab'),
(56, 100, 146, 'One Foot Tricks', '2022-05-17 05:24:15', '2022-06-15 09:04:12', 'Bode Merril est la preuve vivante que la réincarnation n’est pas un conte de fée. Dans sa vie antérieure de flamant rose, il avait déjà l’habitude d’affronter le quotidien sur une patte. Quelque 200 ans plus tard, il a eu la chance d’être un homme doté d’un snowboard, ce qui a fini par donner à son être l’élan nécessaire. Il aime bien s’avaler quelques one foot double backflips au p’tit déj.', 'One Foot Tricks'),
(57, 100, 145, 'Blaza', '2022-05-17 14:13:04', '2022-06-15 07:04:21', 'Blaza est un trick extraordinaire.', 'Blaza'),
(58, 100, 147, 'Backside Air', '2022-05-23 05:41:02', '2022-05-26 17:00:28', 'On commence tout simplement avec LE trick. Les mauvaises langues prétendent qu’un backside air suffit à reconnaître ceux qui savent snowboarder. Si c’est vrai, alors Nicolas Müller est le meilleur snowboardeur du monde. Personne ne sait s’étirer aussi joliment, ne demeure aussi zen, n’est aussi provocant dans la jouissance.', 'Backside Air'),
(59, 100, 145, 'Grab', '2022-05-24 14:22:18', '2022-06-15 07:03:43', 'Grabber consiste à attraper sa planche avec sa main pendant un saut. C’est à la fois pratique (la board est tenue fermement et ça rassure) et joli (lorsque c’est bien fait). Mais au début, c’est plutôt la cata : le grab est inefficace. Il ne permet pas, d’une part, d’assurer que la board ne va pas bouger et d’autre part, il risque d’être super moche.', 'Grab'),
(74, 100, 148, 'Going bigge', '2022-06-15 09:06:48', NULL, 'Soyons francs, tous les tricks de Travis pourraient être des signatures. Son genre «I go bigger» se voit probablement dès le matin aux toilettes. Trois fois par dessus la tête ou simply straight, il semble que Travis puisse à peu près tout essayer plus haut, plus loin, plus extrême, plus beau et en premier la plupart du temps.', 'Going bigge');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated` int(11) DEFAULT NULL,
  `validated_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_password_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `pseudo`, `avatar`, `activated`, `validated_token`, `reset_password_token`) VALUES
(95, 'berni@gmail.com', '[]', '$2y$13$msPGDUqGEQNiYMh6UAFmb.XA9DnJeCKBNXjdY5razDHK3HnbsHU/C', 'Berni', ' ', 1, NULL, NULL),
(96, 'Ola@gmail.com', '[]', '$2y$13$A9wVB9rKJyfo59QaUTe/2.oxo5ut1KxA8l.qIvsZr797e17iNoe6i', 'Ola', ' ', 1, NULL, NULL),
(97, 'jack@yahoo.fr', '[]', '$2y$13$HuF7yjXF8pNukNnMQbIrLeV9Zmz5EoEhlBYdwLyZvp7vQ.ArxoyGi', 'Jack', ' ', 1, NULL, NULL),
(98, 'erin@gmail.com', '[]', '$2y$13$YV20W1DH0RziPffRww73Ee4PpsgelyaocDi1EF.08CnyttLEoQYPG', 'Erin', ' ', 1, NULL, NULL),
(99, 'gabin@gmail.com', '[]', '$2y$13$wkhd0WE/5CQW7sb99lMY0.7ptJTAV/tsce8Sko6stP71wLGumTbnC', 'Gabin', ' ', 1, NULL, NULL),
(100, 'aleks@gmail.com', '[]', '$2y$13$pR462LfTyPOlpNOYidZt5e8HfVjsNqV4k6WaSsQ5.8K7JVaeBuzce', 'Aleks', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `trick_id`, `url`) VALUES
(32, 40, 'V9xuy-rVj9w'),
(33, 41, 'http://6vA4BuJM3_g'),
(34, 42, '_OMar04NRZw'),
(35, 43, '9LQkQXMuuUc'),
(36, 44, 'DO0Xfada_xw'),
(37, 45, '-vyWHLblti0'),
(38, 46, 'sVUnwWhz1x0'),
(39, 47, 'qsd8uaex-Is'),
(40, 48, '_8TBfD5VPnM'),
(41, 49, ''),
(66, 56, 'https://youtu.be/yK5GFfqeYfU'),
(67, 74, 'https://www.youtu.be/wlEY-D2F6Yk');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_64C19C15E237E06` (`name`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526CA76ED395` (`user_id`),
  ADD KEY `IDX_9474526CB281BE2E` (`trick_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_16DB4F89B281BE2E` (`trick_id`);

--
-- Index pour la table `trick`
--
ALTER TABLE `trick`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D8F0A91E5E237E06` (`name`),
  ADD KEY `IDX_D8F0A91EA76ED395` (`user_id`),
  ADD KEY `IDX_D8F0A91E12469DE2` (`category_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_8D93D64986CC499D` (`pseudo`);

--
-- Index pour la table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CC7DA2CB281BE2E` (`trick_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT pour la table `trick`
--
ALTER TABLE `trick`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT pour la table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_9474526CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `FK_16DB4F89B281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `trick`
--
ALTER TABLE `trick`
  ADD CONSTRAINT `FK_D8F0A91E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D8F0A91EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `FK_7CC7DA2CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
