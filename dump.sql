-- Adminer 4.8.1 MySQL 8.0.40-0ubuntu0.22.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `character`;
CREATE TABLE `character` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abstract` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` datetime NOT NULL,
  `death_date` datetime DEFAULT NULL,
  `long_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `character` (`id`, `nickname`, `abstract`, `birth_date`, `death_date`, `long_description`, `background_image`, `avatar_image`) VALUES
(1,	'Janus',	'Janus est le plus jeune de sa fratrie.',	'1980-01-23 00:00:00',	NULL,	'Janus est le plus jeune de sa fratrie. Il est le dernier d\'une famille de douze enfants. Ses parents étaient pauvres, son père était un homme courageux qui ne se ménageait pas pour subvenir aux besoins de sa famille. Et Janus n\'était pas le plus malchanceux car ses aînés lui avaient appris à se débrouiller dès le plus jeune âge. Il est vite devenu quelqu\'un de dégourdi et sachant faire un peu tout mais son domaine de prédilection était l\'aventure.\r\nAccomplira-t-il sa destinée en restant avec sa famille à travailler ?',	'blue-sky-country-road.jpg',	'young-mason.jpg'),
(2,	'James',	'James n\'a pas d\'ami, c\'est dommage pour lui.',	'2018-01-23 00:00:00',	NULL,	'James est un petit garçon joyeux, il adore s\'amuser avec tout ce qui l\'entoure et pose des questions sur tout ce qu\'il voit.\r\nSes parents en ont des fois assez de l\'entendre et de l\'avoir dans les pattes.\r\nIls l\'envoient à l\'école tous les jours pour qu\'ils côtoient d\'autres enfants, étant le seul enfant de sa famille.\r\nMais malgré sa gentillesse, personne ne veut devenir son ami.\r\nQu\'est-ce qui cloche chez lui ? ',	'blurry-mountains.jpg',	'tiny-boy-curly-hair.jpg'),
(3,	'Georgette',	'Georgette a toujours été courageuse face aux évènements de la vie, c\'est un exemple de ténacité.',	'1928-09-23 00:00:00',	'2023-09-23 00:00:00',	'Georgette est une femme simple, gentille et travailleuse. Son père était cordonnier, sa maman était mère au foyer. Elle avait une soeur bonne soeur. Et elle aussi elle a été éduquée par les soeurs. Et elle a travaillé avec elles en tant qu\'infirmière dans sa jeunesse.\r\nEnsuite elle a rencontré l\'homme de sa vie. \r\nAlors elle s\'est consacrée à ses enfants.\r\nElle a beaucoup de loisirs : la pêche, le tricot, la couture mais ce qu\'elle aime par dessus tout, c\'est le jardinage !\r\nEt malgré son âge avancé, elle ne peut s\'empêcher de continuer... ',	'paris-from-roof.jpg',	'old-woman-gardener.jpg'),
(4,	'Javalo',	'Javalo, magicien de la tribu des Hanayos',	'1880-11-13 00:00:00',	'1932-10-07 00:00:00',	'Javalo fait partie de la tribu des Hanayos. Son peuple a été le seul survivant d\'une longue guerre acharnée contre le peuple voisin dont le chef était un tyran d\'une extrême cruauté. Javalo n\'avait qu\'un rêve, c\'était que toute cette barbarie s\'arrête.\r\nAlors il a cherché dans les trésors de la forêt des secrets que seul lui a pu apprivoiser. Et a ainsi sauvé les siens.',	'blurry-mountains.jpg',	'apache.jpg'),
(5,	'Kayo',	'Kayo, jeune prince, ne sentait pas la force de régner sur son royaume',	'1960-05-23 00:00:00',	NULL,	'Kayo est né dans le royaume de Junyo. Unique fils d\'un roi âgé qui n\'avait jamais pu avoir d\'enfant avant lui, sa venue au monde fut fêtée comme un miracle dans le royaume. Mais la personnalité si fragile de Kayo ne correspondait pas aux attentes qu\'on avait de lui et,bien qui\'l ne veuille pas décevoir son père ni l\'abandonner, il rêvait d\'une autre vie... Comment pourra-il faire concilier ses devoirs et son propre bonheur ?',	'rice-fields.jpg',	'asian-male-manga-hero.jpg');

DROP TABLE IF EXISTS `character_personality`;
CREATE TABLE `character_personality` (
  `character_id` int NOT NULL,
  `personality_id` int NOT NULL,
  PRIMARY KEY (`character_id`,`personality_id`),
  KEY `IDX_E5A53A021136BE75` (`character_id`),
  KEY `IDX_E5A53A02CF3DE080` (`personality_id`),
  CONSTRAINT `FK_E5A53A021136BE75` FOREIGN KEY (`character_id`) REFERENCES `character` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_E5A53A02CF3DE080` FOREIGN KEY (`personality_id`) REFERENCES `personality` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `character_personality` (`character_id`, `personality_id`) VALUES
(1,	1),
(1,	2),
(1,	3),
(1,	6),
(2,	1),
(2,	4),
(2,	11),
(2,	13),
(2,	19),
(3,	1),
(3,	3),
(3,	11),
(3,	13),
(3,	18),
(3,	21),
(4,	1),
(4,	3),
(4,	7),
(4,	15),
(4,	17),
(4,	22),
(5,	1),
(5,	3),
(5,	4),
(5,	13),
(5,	19),
(5,	20),
(5,	21),
(5,	22);

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250111054827',	'2025-01-11 05:48:40',	21),
('DoctrineMigrations\\Version20250118030014',	'2025-01-18 03:00:18',	14),
('DoctrineMigrations\\Version20250119211210',	'2025-01-19 21:12:19',	14),
('DoctrineMigrations\\Version20250124165341',	'2025-01-24 16:53:47',	23),
('DoctrineMigrations\\Version20250124165929',	'2025-01-24 16:59:34',	141),
('DoctrineMigrations\\Version20250124173834',	'2025-01-24 17:38:41',	130);

DROP TABLE IF EXISTS `personality`;
CREATE TABLE `personality` (
  `id` int NOT NULL AUTO_INCREMENT,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `personality` (`id`, `value`) VALUES
(1,	'gentil'),
(2,	'méchant'),
(3,	'courageux'),
(4,	'fragile'),
(5,	'impatient'),
(6,	'dynamique'),
(7,	'fort'),
(8,	'hyperactif'),
(9,	'naïf'),
(10,	'menteur'),
(11,	'vif'),
(12,	'charmeur'),
(13,	'perspicace'),
(14,	'hypocrite'),
(15,	'ambitieux'),
(16,	'arriviste'),
(17,	'aventurier'),
(18,	'modeste'),
(19,	'calme'),
(20,	'doux'),
(21,	'serein'),
(22,	'mystérieux');

-- 2025-01-29 01:23:16
