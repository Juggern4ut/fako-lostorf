-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 24, 2018 at 01:06 PM
-- Server version: 5.7.22-log-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fakolost_fasnacht2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cms_article`
--

CREATE TABLE `cms_article` (
  `article_id` int(11) NOT NULL,
  `navigation_fk` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(4) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_article`
--

INSERT INTO `cms_article` (`article_id`, `navigation_fk`, `sort`, `is_active`, `is_deleted`, `timestamp`) VALUES
(1, 1, 1, 1, 0, '2018-01-15 15:40:21'),
(2, 1, 3, 1, 1, '2018-07-30 09:14:40'),
(7, 2, 0, 1, 1, '2018-07-31 14:25:00'),
(8, 3, 0, 1, 0, '2018-07-31 14:26:50'),
(9, 1, 2, 1, 1, '2018-08-02 11:54:14'),
(10, 4, 0, 1, 0, '2018-08-07 08:13:14'),
(11, 8, 0, 1, 0, '2018-08-07 08:54:22'),
(12, 5, 0, 1, 0, '2018-08-10 07:39:08'),
(13, 2, 0, 1, 0, '2018-08-15 06:57:34'),
(14, 19, 0, 1, 0, '2018-08-21 05:54:50'),
(15, 20, 0, 1, 0, '2018-08-21 05:56:22'),
(16, 21, 0, 1, 0, '2018-08-21 06:05:27'),
(17, 22, 0, 1, 0, '2018-08-21 06:35:06'),
(18, 23, 0, 1, 0, '2018-08-21 06:37:35'),
(19, 25, 0, 1, 0, '2018-08-21 06:39:01'),
(20, 30, 3, 1, 0, '2018-08-23 20:21:35'),
(21, 31, 0, 1, 0, '2018-08-24 11:20:19'),
(22, 30, 0, 1, 1, '2018-08-24 11:37:50'),
(23, 29, 1, 0, 0, '2018-09-22 09:34:27'),
(24, 29, 2, 0, 0, '2018-09-22 09:37:23'),
(25, 29, 3, 0, 0, '2018-09-22 09:38:19'),
(26, 29, 4, 0, 0, '2018-09-22 09:43:16'),
(27, 29, 5, 0, 0, '2018-09-22 09:44:44'),
(28, 29, 6, 0, 0, '2018-09-22 09:49:29'),
(29, 29, 7, 0, 0, '2018-09-22 09:50:42'),
(30, 30, 1, 1, 0, '2018-09-29 12:15:42'),
(31, 30, 2, 1, 0, '2018-09-29 12:19:17'),
(32, 30, 0, 0, 1, '2018-09-29 12:29:15'),
(33, 30, 0, 1, 1, '2018-10-01 09:16:17'),
(34, 29, 0, 0, 1, '2018-11-01 19:29:17'),
(35, 36, 0, 0, 1, '2018-11-20 14:04:55');

-- --------------------------------------------------------

--
-- Table structure for table `cms_article_content`
--

CREATE TABLE `cms_article_content` (
  `article_content_id` int(11) NOT NULL,
  `article_fk` int(11) NOT NULL,
  `lang_fk` int(11) NOT NULL,
  `article_title` varchar(100) COLLATE utf8_bin NOT NULL,
  `text` text COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cms_article_content`
--

INSERT INTO `cms_article_content` (`article_content_id`, `article_fk`, `lang_fk`, `article_title`, `text`, `timestamp`) VALUES
(1, 1, 1, 'Home', '<h1>Willkommen beim Fasnachtsverein Lostorf</h1>\n<p>Herzlich willkommen auf der offiziellen Webseite des Fasnachtsvereins Lostorf. Sch&ouml;n, dass Sie bei uns reinschauen.</p>\n<p>Auf unsere Webseite k&ouml;nnen Sie unter anderem alle Fotos unserer bisherigen Anl&auml;sse ansehen oder uns mithilfe des <a href=\"/de/kontakt\">Kontaktformulares</a>&nbsp;direkt eure Anfragen stellen.</p>\n<p>Des Weiteren k&ouml;nnen Sie <a href=\"/de/news\">News</a>&nbsp;&uuml;ber unseren Verein sowie auch das aktuelle <a href=\"/de/programm\">Programm</a> einsehen, oder ein wenig etwas &uuml;ber die <a href=\"/de/verein\">Entstehung des Vereins</a> lesen.</p>', '2018-11-23 11:19:25'),
(3, 2, 1, 'Noch ein Artikel, mit titel', '<p>Das ist ein weiterer Artikel mit einer &Auml;nderung</p>\r\n<p><a href=\"../media/userdocuments/changesDev.txt\" target=\"_blank\">Ein Link auf eine Datei</a></p>', '2018-07-30 09:14:40'),
(13, 7, 1, 'Kontakt', '<p>Das ist der Inhalt des Kontakt-dingens</p>\r\n<p><img src=\"../media/richtext/converse_shoes.jpg\" alt=\"\" width=\"320\" height=\"201\" /></p>', '2018-07-31 14:25:00'),
(15, 8, 1, 'Anfahrt', '<p>Schauen Sie auf einen Besuch vorbei</p>\r\n<ul>\r\n<li>Auto:&nbsp;Unsere Anlagen sind mit dem Auto leider nicht zug&auml;nglich.</li>\r\n<li>&Ouml;ffentlicher Verkehr:&nbsp;Ein Bus f&auml;hrt jede Woche am Montag morgen um 02:10 Uhr im Industriegebiet.</li>\r\n<li>Zu Fuss: &Uuml;berqueren Sie die A1 und schwimmen Sie danach in der Aare gegen die Str&ouml;mung bis Sie unsere Firma auf der linken Seite hinter dem 2 Meter hohen Zaun erkennen k&ouml;nnen.</li>\r\n</ul>\r\n<p><img src=\"../media/richtext/583ae652e02ba71e008b6557-750.jpg\" alt=\"\" width=\"320\" height=\"240\" /></p>', '2018-07-31 14:26:50'),
(17, 9, 1, 'Neuer Artikel', '<p>Mit Bilder&nbsp;</p>', '2018-08-02 11:54:14'),
(19, 10, 1, 'Über uns', '<p>Wir sind die Weble AG</p>\r\n<p>Schon seit vielen vielen Stunden bieten wir Dienstleistungen und Produkte zum Verkauf an.</p>\r\n<p>Zu unserem Sortiment geh&ouml;ren viele n&uuml;tzliche Produkte f&uuml;r den Alltag wie zum Beipsiel&nbsp;⍰⍰⍰⍰ oder auch das beliebte&nbsp;⍰⍰⍰⍰⍰⍰⍰⍰⍰</p>\r\n<p><img src=\"../media/richtext/theComaRecut.jpg\" alt=\"\" width=\"150\" height=\"148\" /></p>', '2018-08-07 08:13:14'),
(21, 11, 1, '404 - Seite nicht gefunden', '<h1>404 - Seite nicht gefunden</h1>\n<p>Die von Ihnen aufgerufene Seite konnte leider nicht gefunden werden.</p>\n<p><a title=\"Home\" href=\"/de/home\">Home</a></p>', '2018-11-23 13:25:31'),
(23, 12, 1, 'Inhalt', '<p>Das ist Inhalt</p>', '2018-08-10 07:39:08'),
(24, 13, 1, 'Kontakt', '<p><img src=\"../media/richtext/se&ntilde;or weble.png\" alt=\"\" width=\"250\" height=\"348\" /></p>\r\n<p>Hallo, ich bin der CEO der Weble-Studios.</p>\r\n<p>Wenn Sie Fragen zu einem unserer Produkte haben, kontaktieren Sie uns ungeniert mit einer der folgenden M&ouml;glichkeiten, oder schauen Sie bei uns direkt vorbei.</p>\r\n<p><a href=\"mailto:info@weble.ch\">info@weble.ch</a></p>\r\n<p>Tel: +41 79 789 876 123<br />Fax: +41 79 789 876 124</p>\r\n<p>Weble Management<br />Se&ntilde;or Weble<br />CMS-Street 1994<br />2000 PownTown<br /><br /></p>', '2018-08-15 06:57:34'),
(26, 14, 1, 'Geschichte', '<h1>Geschichte</h1>\n<p>Der \"Fasnachtsverein Lostorf\" wurde am 18. Oktober 2012 um ca. 22.00h im Rest. Wartenfels von Rolf Riesen, Ren&eacute; Knecht, Martin Lehmann und Philipp Baisotti gegr&uuml;ndet. Das Vereinslokal befindet sich an der Bachstrasse 40 in 4654 Lostorf.</p>\n<p>Die Fasnacht ist aus dem kulturellen Leben unserer Gemeinde nicht mehr wegzudenken. Seit Jahrzehnten war es immer ein Anliegen diverser Fako`s, die Dorffasnacht zu aktivieren und ihr neue Impulse zu verleihen. Es wird immer unser Ziel sein, auch mit anderen Fasnachtsgruppen, die zuk&uuml;nftigen n&auml;rrischen Tage ideenreich zu gestalten.</p>\n<p>Ohne die Mithilfe der Bev&ouml;lkerung und der Beh&ouml;rden sind unsere Ziele jedoch nicht realisierbar. Wir freuen uns immer wieder &uuml;ber die aktive Teilnahme vieler Lostorfer an unseren Veranstaltungen. Nur so k&ouml;nnen wir in Lostorf auch in den n&auml;chsten Jahrzehnten tolle Fasnachtstage erleben und geniessen.</p>\n<h2 style=\"text-align: left;\">\"daf&uuml;r m&ouml;chten wir uns bei allen recht herzlich bedanken\"</h2>', '2018-08-21 05:54:50'),
(28, 15, 1, 'Kontakt', '<h1>Vereinsadresse</h1>\n<p>Fasnachtsverein Lostorf<br />Bachstrasse 40<br />4654 Lostorf<br />Pr&auml;si: +41796944726</p>\n<h1>Kontaktformular</h1>\n<p>Haben Sie eine Frage oder ein anderes Anliegen? Treten Sie einfach mit uns in Kontakt indem Sie das untenstehende Formular ausf&uuml;llen und absenden. Wir werden Ihnen danach so schnell wie m&ouml;glich eine Antwort zukommen lassen.</p>\n<p>{kontakt_formular}</p>', '2018-08-21 05:56:22'),
(30, 16, 1, 'Chesslete 2018', '', '2018-08-21 06:05:27'),
(32, 17, 1, 'Schlüsselübergabe 2018', '', '2018-11-24 11:34:21'),
(34, 18, 1, 'Schmudo 2018', '', '2018-08-21 06:37:36'),
(36, 19, 1, 'SA Umzug und Fasnachtsparty 18', '', '2018-08-21 06:39:02'),
(38, 20, 1, 'Neue Homepage', '<p>Seit Heute haben wir eine Neue Homepage</p>', '2018-08-23 20:21:35'),
(39, 21, 1, 'Impressum', '<h1>Impressum</h1>\n<h3><strong>Vereinsname: Fasnachtsverein Lostorf<br /></strong><strong>Bachstrasse 40<br /></strong><strong>4654 Lostorf</strong></h3>\n<p>&nbsp;</p>', '2018-08-24 11:20:19'),
(40, 22, 1, 'Beispiel News', '<p>Das sind Beispiel News</p>\r\n<p>Diese haben keinen Inhalt, oder zumindest keinen der Sinn macht...</p>\r\n<p>Bla bla</p>\r\n<p>:D</p>', '2018-08-24 11:37:50'),
(41, 23, 1, 'Fasnachtsbeginn 11.11.2018', '<p>Wie jedes Jahr beginnt am 11.11 die Fasnacht.&nbsp;<br />Wir starten den Betrieb um 16:11 Uhr.&nbsp;</p>', '2018-09-22 09:34:27'),
(42, 24, 1, 'Hilari 05.01.2019', '<p>Am Samstag 5.1.2019 findet in Lostorf der Hilari statt.<br />Wir freuen uns, euch auf dem Gemeindeplatz mit Speis und Trank und guter Musik unterhalten zu k&ouml;nnen.</p>', '2018-09-22 09:37:23'),
(43, 25, 1, 'Donnerstag 28.02.2019', '<p>Am 28.2.2018 Starten wir den Schmuitzigen Donnerstag um 5.00Uhr mit der Chesslete.<br />Anschliessend findet die Kinderfasnacht Statt.<br />Um 19.00Uhr Beginnen die Schnitzelb&auml;nke und lassen den Abend miut guter Musik und guter Stimmung Ausklingen.</p>', '2018-09-22 09:38:19'),
(44, 26, 1, 'Samstag 02.03.2019', '<p>Am Samstag 2.3.2019 um 11.30 Beginnt Der Fasnachtsumzug in Lostorf.<br />Danach Feiern wir Fasnacht im Festzelt Lostorf.</p>', '2018-09-22 09:43:16'),
(45, 27, 1, 'Sonntag 03.03.2019', '<p>Am Sonntag Trifft man den Fasnachtsverein Lostorf in Olten am Umzug an.</p>', '2018-09-22 09:44:44'),
(46, 28, 1, 'Dienstag 05.03.2019', '<p>Am Dienstag 5.3.2019 Findet die Allj&auml;hrige Kinderfasnacht mit Umzug statt.<br />Der Umzug beginnt um 13.30 mit anschliessendem Festbetrieb im Zelt.</p>', '2018-09-22 09:49:29'),
(47, 29, 1, 'Samstag 09.03.2019', '<p>Am Samstag 9.3.2019 schliessen wir die Fasnacht mit dem B&ouml;gverbrennen ab.</p>', '2018-09-22 09:50:42'),
(48, 30, 1, 'Fasnachtsmotto 2019', '<p>Unser neues Motto f&uuml;r die Fasnacht 2019 ist bekannt!<br />Zahlreiche Ideen f&uuml;r ein neues Motto sind bei uns am Dorfm&auml;ret eingegangen.<br />Wir freuen uns auf eure Ideen und Verkleidungen zum Motto:</p>\n<p><strong>Casino - Las Vegas-Feeling in Lostorf</strong>&nbsp;</p>\n<p>Wir gratulieren der Gewinnerin vom Wettbewerb,&nbsp;Sarah Loosli, und w&uuml;nschen Ihr viel Spass im Kino!!</p>', '2018-09-29 12:15:42'),
(49, 31, 1, 'Obernarr', '<p>Der diesj&auml;hrige Obernarr in Lostorf ist bekannt.</p>\n<p>WER IST ES WOHL?</p>\n<p>am 11.11 Wird der Obernarr bekannt gegeben.</p>\n<p>Seid dabei!</p>', '2018-09-29 12:19:17'),
(50, 32, 1, 'test', '', '2018-09-29 12:29:15'),
(51, 33, 1, 'Test', '<p>Test</p>', '2018-10-01 09:16:17'),
(52, 34, 1, 'Test', '<p>Test</p>', '2018-11-01 19:29:17'),
(53, 35, 1, 'gfdsg', '<p>dsgfdsfgds</p>', '2018-11-20 14:04:55');

-- --------------------------------------------------------

--
-- Table structure for table `cms_article_content_image`
--

CREATE TABLE `cms_article_content_image` (
  `article_content_image_id` int(11) NOT NULL,
  `article_content_fk` int(11) NOT NULL,
  `lang_fk` int(11) NOT NULL,
  `image` varchar(500) COLLATE utf8_bin NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cms_article_content_image`
--

INSERT INTO `cms_article_content_image` (`article_content_image_id`, `article_content_fk`, `lang_fk`, `image`, `sort`, `timestamp`) VALUES
(12, 2, 1, 'Chrysanthemum.jpg', 3, '2018-08-03 07:43:11'),
(13, 2, 1, 'Desert.jpg', 1, '2018-08-03 07:43:11'),
(15, 2, 1, 'Jellyfish.jpg', 2, '2018-08-03 07:43:12'),
(24, 16, 1, 'image (1).jpg', 0, '2018-08-21 06:07:30'),
(25, 16, 1, 'image (2).jpg', 0, '2018-08-21 06:07:30'),
(26, 16, 1, 'image (3).jpg', 0, '2018-08-21 06:07:30'),
(27, 16, 1, 'image (4).jpg', 0, '2018-08-21 06:07:31'),
(28, 16, 1, 'image (5).jpg', 0, '2018-08-21 06:07:31'),
(29, 16, 1, 'image (6).jpg', 0, '2018-08-21 06:07:31'),
(36, 17, 1, 'image (1).jpg', 0, '2018-08-21 06:35:06'),
(37, 17, 1, 'image (2).jpg', 0, '2018-08-21 06:35:06'),
(38, 17, 1, 'image (3).jpg', 0, '2018-08-21 06:35:06'),
(39, 17, 1, 'image (4).jpg', 0, '2018-08-21 06:35:06'),
(40, 17, 1, 'image (5).jpg', 0, '2018-08-21 06:35:06'),
(41, 17, 1, 'image (6).jpg', 0, '2018-08-21 06:35:07'),
(42, 17, 1, 'image (7).jpg', 0, '2018-08-21 06:35:07'),
(43, 17, 1, 'image (8).jpg', 0, '2018-08-21 06:35:07'),
(52, 18, 1, 'image (1).jpg', 0, '2018-08-21 06:37:35'),
(53, 18, 1, 'image (2).jpg', 0, '2018-08-21 06:37:35'),
(54, 18, 1, 'image (3).jpg', 0, '2018-08-21 06:37:35'),
(55, 18, 1, 'image (4).jpg', 0, '2018-08-21 06:37:35'),
(56, 18, 1, 'image (5).jpg', 0, '2018-08-21 06:37:35'),
(57, 18, 1, 'image (6).jpg', 0, '2018-08-21 06:37:36'),
(64, 19, 1, 'image (1).jpg', 0, '2018-08-21 06:39:02'),
(65, 19, 1, 'image (2).jpg', 0, '2018-08-21 06:39:02'),
(66, 19, 1, 'image (3).jpg', 0, '2018-08-21 06:39:02'),
(67, 19, 1, 'image (4).jpg', 0, '2018-08-21 06:39:02'),
(68, 19, 1, 'image (5).jpg', 0, '2018-08-21 06:39:02'),
(69, 19, 1, 'image (6).jpg', 0, '2018-08-21 06:39:02'),
(70, 19, 1, 'image (7).jpg', 0, '2018-08-21 06:39:02'),
(71, 19, 1, 'image.jpg', 0, '2018-08-21 06:39:02'),
(82, 1, 1, 'image.jpg', 1, '2018-08-24 10:29:40'),
(84, 14, 1, '15260284628.jpg', 0, '2018-08-24 10:33:02'),
(86, 14, 1, '1526028468.jpg', 0, '2018-08-24 10:34:10'),
(89, 15, 1, 'DJI_0088_000012.jpg', 0, '2018-09-29 13:07:56'),
(94, 15, 1, 'org_b323e4604bd34482_1537619162000.jpg', 0, '2018-10-02 10:06:38'),
(95, 34, 1, '11.11 2018 A4_Auftakt.jpg', 0, '2018-11-01 19:29:17'),
(97, 23, 1, '11.11 2018 A4_Auftakt.jpg', 0, '2018-11-01 19:32:42'),
(100, 11, 1, 'wp_engine.PNG', 0, '2018-11-20 14:01:47'),
(102, 35, 1, 'buckethead.jpg', 1, '2018-11-20 14:05:05'),
(103, 35, 1, 'dead-island.png', 5, '2018-11-20 14:05:08'),
(104, 35, 1, 'MadisonAffair.jpg', 2, '2018-11-20 14:27:51'),
(105, 35, 1, 'MonstersOfMetal.jpg', 3, '2018-11-20 14:27:51'),
(106, 35, 1, 'muertos.jpg', 4, '2018-11-20 14:27:52'),
(108, 21, 1, 'image.jpg', 0, '2018-11-21 07:21:15'),
(109, 30, 1, 'image (5).jpg', 0, '2018-11-21 07:34:17'),
(114, 11, 1, '15260284628.jpg', 0, '2018-11-23 13:26:04');

-- --------------------------------------------------------

--
-- Table structure for table `cms_lang`
--

CREATE TABLE `cms_lang` (
  `lang_id` int(11) NOT NULL,
  `short` varchar(500) NOT NULL,
  `name` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_lang`
--

INSERT INTO `cms_lang` (`lang_id`, `short`, `name`, `timestamp`) VALUES
(1, 'de', 'Deutsch', '2018-01-15 15:28:41');

-- --------------------------------------------------------

--
-- Table structure for table `cms_log`
--

CREATE TABLE `cms_log` (
  `log_id` int(11) NOT NULL,
  `user_fk` int(11) NOT NULL,
  `message` text COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cms_log`
--

INSERT INTO `cms_log` (`log_id`, `user_fk`, `message`, `timestamp`) VALUES
(1, 1, 'luki updated the page \'404\'.', '2018-11-23 13:25:08'),
(2, 1, 'luki edited the article \'404 - Seite nicht gefunden\'.', '2018-11-23 13:25:31'),
(3, 1, 'luki edited the article \'404 - Seite nicht gefunden\'.', '2018-11-23 13:26:04'),
(4, 1, 'luki edited the article \'Schlüsselübergabe 2018\'.', '2018-11-24 11:34:21'),
(5, 1, 'luki updated the page \'Schlüsselübergabe 2018\'.', '2018-11-24 11:34:34'),
(6, 1, 'luki updated the page \'Böögverbrennen 2018\'.', '2018-11-24 11:34:43');

-- --------------------------------------------------------

--
-- Table structure for table `cms_navigation`
--

CREATE TABLE `cms_navigation` (
  `navigation_id` int(11) NOT NULL,
  `navigation_fk` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(4) NOT NULL,
  `is_invisible` tinyint(4) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `is_errorpage` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_navigation`
--

INSERT INTO `cms_navigation` (`navigation_id`, `navigation_fk`, `sort`, `is_active`, `is_invisible`, `is_deleted`, `is_errorpage`, `timestamp`) VALUES
(1, 0, 1, 1, 0, 0, 0, '2018-03-11 16:56:15'),
(2, 0, 14, 1, 0, 1, 0, '2018-03-11 16:56:21'),
(3, 2, 15, 1, 0, 0, 0, '2018-03-11 16:56:25'),
(4, 0, 13, 1, 0, 1, 0, '2018-08-07 06:58:25'),
(5, 1, 3, 1, 0, 1, 0, '2018-08-07 06:58:30'),
(6, 1, 4, 1, 0, 1, 0, '2018-08-07 06:58:34'),
(7, 6, 5, 1, 0, 1, 0, '2018-08-07 07:11:49'),
(8, 0, 17, 1, 1, 0, 1, '2018-08-07 08:53:42'),
(9, 0, 9, 1, 0, 1, 0, '2018-08-08 08:06:51'),
(10, 0, 16, 1, 1, 1, 0, '2018-08-08 11:52:19'),
(11, 0, 0, 0, 0, 1, 0, '2018-08-13 07:37:22'),
(12, 0, 0, 0, 0, 1, 0, '2018-08-13 07:38:09'),
(13, 0, 0, 0, 0, 1, 0, '2018-08-13 07:40:30'),
(14, 0, 0, 0, 0, 1, 0, '2018-08-13 07:44:33'),
(15, 0, 0, 0, 0, 1, 0, '2018-08-13 07:45:53'),
(16, 0, 0, 0, 0, 1, 0, '2018-08-13 08:17:44'),
(17, 8, 0, 0, 0, 1, 0, '2018-08-13 08:26:38'),
(18, 1, 0, 0, 1, 1, 0, '2018-08-13 08:43:29'),
(19, 0, 2, 1, 0, 0, 0, '2018-08-21 05:41:40'),
(20, 0, 14, 1, 0, 0, 0, '2018-08-21 05:42:04'),
(21, 33, 5, 1, 0, 0, 0, '2018-08-21 05:42:31'),
(22, 33, 6, 1, 0, 0, 0, '2018-08-21 05:43:10'),
(23, 33, 7, 1, 0, 0, 0, '2018-08-21 05:43:30'),
(24, 0, 3, 1, 0, 0, 0, '2018-08-21 05:44:16'),
(25, 33, 8, 1, 0, 0, 0, '2018-08-21 05:45:11'),
(26, 33, 9, 1, 0, 0, 0, '2018-08-21 05:45:53'),
(27, 33, 10, 1, 0, 0, 0, '2018-08-21 05:46:32'),
(28, 33, 11, 1, 0, 0, 0, '2018-08-21 05:46:59'),
(29, 0, 16, 1, 0, 0, 0, '2018-08-23 19:39:17'),
(30, 0, 15, 1, 0, 0, 0, '2018-08-23 19:39:34'),
(31, 0, 18, 1, 1, 0, 0, '2018-08-24 11:19:02'),
(32, 32, 0, 0, 0, 0, 0, '2018-09-22 06:47:52'),
(33, 24, 4, 1, 0, 0, 0, '2018-09-22 06:49:55'),
(34, 24, 12, 1, 0, 0, 0, '2018-09-22 06:52:12'),
(35, 34, 13, 1, 0, 0, 0, '2018-10-01 07:55:46'),
(36, 0, 0, 0, 0, 1, 0, '2018-11-20 14:04:44'),
(37, 0, 0, 0, 0, 1, 0, '2018-11-23 10:23:19'),
(38, 24, 0, 1, 0, 0, 0, '2018-11-23 10:24:00'),
(39, 0, 0, 0, 0, 1, 0, '2018-11-23 12:36:43');

-- --------------------------------------------------------

--
-- Table structure for table `cms_navigation_title`
--

CREATE TABLE `cms_navigation_title` (
  `navigation_title_id` int(11) NOT NULL,
  `navigation_fk` int(11) NOT NULL,
  `lang_fk` int(11) NOT NULL,
  `title` varchar(400) COLLATE utf8_bin NOT NULL,
  `link` varchar(500) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `keywords` text COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cms_navigation_title`
--

INSERT INTO `cms_navigation_title` (`navigation_title_id`, `navigation_fk`, `lang_fk`, `title`, `link`, `description`, `keywords`, `timestamp`) VALUES
(1, 1, 1, 'Home', 'home', 'Startseite des Fasnachtsverein Lostorf', 'Home, Fasnacht, Lostorf, Fasnachtsverein, Startseite', '2018-11-21 11:51:40'),
(3, 2, 1, 'Kontakt', '', '', '', '2018-03-11 16:56:21'),
(5, 3, 1, 'Anfahrt', '', 'Diese Seite beschreibt den Anfahrtsweg zu der Firma XYZ', 'Anfahrt, Weg, Route, FirmaXYZ, Maps', '2018-08-08 08:06:09'),
(7, 4, 1, 'Ãœber uns', '', 'Ãœber uns - Weble CMS', 'Ã¼ber uns, weble, cms, about us', '2018-08-15 06:40:47'),
(9, 5, 1, 'Page 4', '', '', '', '2018-08-07 06:58:30'),
(11, 6, 1, 'Seite 5', '', '', '', '2018-08-07 06:58:34'),
(13, 7, 1, 'Seite 6', '', '', '', '2018-08-07 07:11:49'),
(15, 8, 1, '404', '404', '', '', '2018-09-22 09:40:59'),
(17, 9, 1, 'Neu', '', 'Neue Seite', 'new, page', '2018-08-08 08:06:51'),
(19, 10, 1, 'Team', '', 'Teamseite', 'Team, Personen', '2018-08-08 11:52:19'),
(21, 11, 1, '123231', '', '', '', '2018-08-13 07:37:22'),
(23, 12, 1, '1231232', '', '', '', '2018-08-13 07:38:09'),
(25, 13, 1, 'fdsafdsafdsfAAAA', '', '', '', '2018-08-13 07:40:30'),
(27, 14, 1, 'gfhdrxfhxrfh', '', '', '', '2018-08-13 07:44:33'),
(29, 15, 1, 'dsadf', '', '', '', '2018-08-13 07:45:53'),
(31, 16, 1, '123', '', '', '', '2018-08-13 08:17:44'),
(33, 17, 1, '404.1', '', '', '', '2018-08-13 08:26:38'),
(35, 18, 1, 'fdsafds', '', '', '', '2018-08-13 08:43:29'),
(37, 19, 1, 'Verein', 'verein', 'Verein FAKO Lostdorf', 'Verein, Lostdorf, Fasnachtsverein, FaKo, Fasnacht', '2018-11-21 11:52:17'),
(39, 20, 1, 'Kontakt', 'kontakt', '', '', '2018-09-22 09:40:46'),
(41, 21, 1, 'Chesslete 2018', 'chesslete-2018', '', '', '2018-10-02 07:50:10'),
(43, 22, 1, 'Schlüsselübergabe 2018', 'schluesseluebergabe-2018', '', '', '2018-11-24 11:34:34'),
(45, 23, 1, 'Schmudo 2018', 'schmudo-2018', '', '', '2018-10-02 07:51:09'),
(47, 24, 1, 'Gallerie', 'gallerie', '', '', '2018-09-22 09:40:32'),
(49, 25, 1, 'SA Umzug und Fasnachtsparty 18', 'sa-umzug-und-fasnachtsparty-18', '', '', '2018-10-02 07:51:13'),
(51, 26, 1, 'Umzug in Olten 2018', 'umzug-in-olten-2018', '', '', '2018-10-02 07:51:21'),
(53, 27, 1, 'KiFa Dienstag 2018', 'kifa-dienstag-2018', '', '', '2018-10-02 07:51:24'),
(55, 28, 1, 'Böögverbrennen 2018', 'boeoegverbrennen-2018', '', '', '2018-11-24 11:34:43'),
(57, 29, 1, 'Programm', 'programm', 'Programm des Fako Lostdorf', 'Programm, Fako Lostdorf', '2018-09-22 09:40:55'),
(59, 30, 1, 'News', 'news', 'News des Fako Lostdorf', 'News, Fako Lostdorf', '2018-09-22 09:40:51'),
(60, 31, 1, 'Impressum', 'impressum', 'Impressum des Fasnachtsvereins Lostdorf', 'Impressum', '2018-09-22 09:41:03'),
(61, 32, 1, 'Fasnacht 2018', '', '', '', '2018-09-22 06:47:52'),
(62, 33, 1, 'Fasnacht 2018', 'fasnacht-2018', '', '', '2018-09-22 09:42:59'),
(63, 34, 1, 'Fasnacht 2019', 'fasnacht-2019', '', '', '2018-09-22 09:43:05'),
(64, 35, 1, 'Chesslete 2019', 'chesslete-2019', '', '', '2018-10-01 07:55:46'),
(65, 36, 1, 'Test', 'test', 'Testpage', 'test, page', '2018-11-20 14:04:44'),
(66, 0, 1, 'Fasnacht 2017', 'fasnacht-2017', 'Gallerie der Fasnacht im Jahre 2017', 'Fasnacht, Fasnacht 2017, Lostorf, Fasnachtsverein, Bilder, Gallerie', '2018-11-23 10:20:36'),
(67, 0, 1, 'Fasnacht 2017', 'fasnacht-2017', 'Fotos des Fasnachtsverein Lostorf der Fasnacht 2017', '', '2018-11-23 10:22:06'),
(68, 0, 1, 'Test', 'test', '', '', '2018-11-23 10:22:59'),
(69, 37, 1, 'test', 'test', '', '', '2018-11-23 10:23:20'),
(70, 38, 1, 'Fasnacht 2017', 'fasnacht-2017', 'Fotogallerie des Fasnachtverein Lostorf der Fasnacht 2017', 'Fasnacht, Fasnacht 2017, Gallerie, Fotos, Bilder, Lostorf, Fasnachtsverein Lostorf, Fasnachtsverein', '2018-11-23 10:24:39'),
(71, 39, 1, 'Test', 'test', '', '', '2018-11-23 12:36:43');

-- --------------------------------------------------------

--
-- Table structure for table `cms_password_reset`
--

CREATE TABLE `cms_password_reset` (
  `password_reset_id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `hash` varchar(500) NOT NULL,
  `used` tinyint(4) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cms_translation`
--

CREATE TABLE `cms_translation` (
  `translation_id` int(11) NOT NULL,
  `key` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_translation`
--

INSERT INTO `cms_translation` (`translation_id`, `key`, `timestamp`) VALUES
(1, 'dashboard_welcome', '2018-09-19 12:15:01'),
(2, 'dashboard_empty_pages_title', '2018-09-19 12:18:32'),
(3, 'dashboard_empty_pages_description', '2018-09-19 12:19:03'),
(4, 'global_submit', '2018-09-19 12:19:16'),
(5, 'global_yes', '2018-09-19 12:19:24'),
(6, 'global_no', '2018-09-19 12:19:30'),
(7, 'module_navigation', '2018-09-19 12:20:19'),
(8, 'module_media', '2018-09-19 12:20:28'),
(9, 'module_translation', '2018-09-19 12:20:46'),
(10, 'module_settings', '2018-09-19 12:21:03'),
(11, 'global_back', '2018-09-19 12:22:15'),
(14, 'dashboard_last_login', '2018-09-19 12:39:31'),
(15, 'dashboard_diskspace', '2018-09-19 12:41:00'),
(16, 'dashboard_used_diskspace', '2018-09-19 12:41:59'),
(17, 'dashboard_of', '2018-09-19 12:43:00'),
(18, 'login_username', '2018-09-19 12:50:09'),
(19, 'login_password', '2018-09-19 12:50:16'),
(20, 'login_forgot_password', '2018-09-19 12:50:35'),
(21, 'login_no_input', '2018-09-19 12:51:46'),
(22, 'login_error', '2018-09-19 12:52:01'),
(23, 'login_success', '2018-09-19 12:52:22'),
(24, 'login_new_password', '2018-09-19 12:58:15'),
(25, 'login_repeat_new_password', '2018-09-19 12:58:36'),
(26, 'login_password_reset_success', '2018-09-19 13:01:16'),
(27, 'login_password_reset_error', '2018-09-19 13:02:07'),
(28, 'login_password_short_error', '2018-09-19 13:02:50'),
(29, 'login_password_reset', '2018-09-19 13:04:38'),
(30, 'login_password_reset_not_found', '2018-09-19 13:05:35'),
(31, 'navigation_module_title', '2018-09-19 13:14:42'),
(32, 'navigation_module_description', '2018-09-19 13:15:25'),
(33, 'navigation_invisible', '2018-09-19 13:17:29'),
(34, 'navigation_pages', '2018-09-19 13:18:47'),
(35, 'navigation_title', '2018-09-19 13:19:00'),
(36, 'login_password_reset_used', '2018-09-19 13:21:55'),
(37, 'navigation_articles', '2018-09-19 13:23:49'),
(38, 'navigation_text', '2018-09-19 13:24:21'),
(39, 'global_no_entry_found', '2018-09-19 13:24:30'),
(40, 'navigation_images', '2018-09-19 13:28:11'),
(41, 'navigation_content', '2018-09-19 13:28:31'),
(42, 'global_edit', '2018-09-19 13:30:38'),
(43, 'global_remove', '2018-09-19 13:30:47'),
(44, 'global_logout', '2018-09-19 15:35:42'),
(45, 'media_module_title', '2018-09-19 15:37:09'),
(46, 'media_module_description', '2018-09-19 15:37:59'),
(47, 'media_file', '2018-09-19 15:38:39'),
(48, 'media_files', '2018-09-19 15:39:14'),
(49, 'media_filename', '2018-09-19 15:39:20'),
(51, 'global_delete_success', '2018-09-19 15:40:59'),
(52, 'translation_module_title', '2018-09-19 15:41:49'),
(53, 'translation_module_description', '2018-09-19 15:42:25'),
(54, 'translation_value', '2018-09-19 15:43:25'),
(55, 'translation_translation', '2018-09-19 15:44:30'),
(57, 'global_confirm_delete', '2018-09-19 15:46:06'),
(58, 'settings_module_title', '2018-09-19 15:56:30'),
(59, 'settings_module_description', '2018-09-19 15:56:59'),
(60, 'settings_user', '2018-09-19 16:00:10'),
(61, 'settings_username', '2018-09-19 16:00:30'),
(62, 'settings_email', '2018-09-19 16:00:43'),
(63, 'settings_language', '2018-09-19 16:00:52'),
(64, 'settings_permissions', '2018-09-19 16:01:05'),
(65, 'settings_password', '2018-09-19 16:01:16'),
(66, 'settings_password_repeat', '2018-09-19 16:01:34'),
(67, 'global_edit_success', '2018-09-19 16:03:51'),
(68, 'global_add_success', '2018-09-19 16:04:59'),
(69, 'settings_delete_self_error', '2018-09-19 16:07:16'),
(70, 'navigation_child_of', '2018-09-19 16:09:52'),
(71, 'navigation_description', '2018-09-19 16:10:23'),
(72, 'navigation_keywords', '2018-09-19 16:11:20'),
(73, 'navigation_meta_image', '2018-09-19 16:12:14'),
(74, 'navigation_inactive', '2018-09-20 05:20:02'),
(75, 'media_foldername', '2018-10-15 05:31:01'),
(76, 'navigation_errorpage', '2018-11-23 13:26:34'),
(77, 'dashboard_visits_today', '2018-11-24 11:39:52'),
(78, 'dashboard_unique_visits_today', '2018-11-24 11:40:06'),
(79, 'dashboard_visits_all_time', '2018-11-24 11:40:23'),
(80, 'dashboard_unique_visits_all_time', '2018-11-24 11:40:35'),
(81, 'module_visitors', '2018-11-24 12:02:27'),
(82, 'visitors_platform', '2018-11-24 12:03:38'),
(83, 'visitors_count', '2018-11-24 12:03:46');

-- --------------------------------------------------------

--
-- Table structure for table `cms_translation_text`
--

CREATE TABLE `cms_translation_text` (
  `translation_text_id` int(11) NOT NULL,
  `translation_fk` int(11) NOT NULL,
  `lang_fk` int(11) NOT NULL,
  `text` text CHARACTER SET latin1 NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cms_translation_text`
--

INSERT INTO `cms_translation_text` (`translation_text_id`, `translation_fk`, `lang_fk`, `text`, `timestamp`) VALUES
(1, 1, 1, 'Willkommen', '2018-09-19 12:15:01'),
(2, 1, 2, 'Welcome', '2018-09-19 12:15:01'),
(3, 2, 1, 'Leere Seiten', '2018-09-19 12:18:32'),
(4, 2, 2, 'Empty pages', '2018-09-19 12:18:32'),
(5, 3, 1, 'Die folgenden Seiten wurden angelegt, aber haben keinen Inhalt', '2018-09-19 12:19:03'),
(6, 3, 2, 'The following pages have been created, but have no content.', '2018-09-19 12:19:03'),
(7, 4, 1, 'Speichern', '2018-09-19 12:19:16'),
(8, 4, 2, 'Submit', '2018-09-19 12:19:16'),
(9, 5, 1, 'Ja', '2018-09-19 12:19:24'),
(10, 5, 2, 'Yes', '2018-09-19 12:19:24'),
(11, 6, 1, 'Nein', '2018-09-19 12:19:30'),
(12, 6, 2, 'No', '2018-09-19 12:19:30'),
(13, 7, 1, 'Navigation', '2018-09-19 12:20:19'),
(14, 7, 2, 'Navigation', '2018-09-19 12:20:19'),
(15, 8, 1, 'Dokumente', '2018-09-19 12:20:28'),
(16, 8, 2, 'Media', '2018-09-19 12:20:28'),
(17, 9, 1, 'Übersetzungen', '2018-09-19 12:20:46'),
(18, 9, 2, 'Translations', '2018-09-19 12:20:46'),
(19, 10, 1, 'Einstellungen', '2018-09-19 12:21:03'),
(20, 10, 2, 'Settings', '2018-09-19 12:21:03'),
(21, 11, 1, 'Zurück', '2018-09-19 12:22:15'),
(22, 11, 2, 'Back', '2018-09-19 12:22:16'),
(27, 14, 1, 'Letzter Login:', '2018-09-19 12:39:31'),
(28, 14, 2, 'Last login:', '2018-09-19 12:39:31'),
(29, 15, 1, 'Speicherplatz', '2018-09-19 12:41:01'),
(30, 15, 2, 'Storage', '2018-09-19 12:41:01'),
(31, 16, 1, 'Verwendeter Speicherplatz:', '2018-09-19 12:41:59'),
(32, 16, 2, 'Used diskspace:', '2018-09-19 12:41:59'),
(33, 17, 1, 'von', '2018-09-19 12:43:01'),
(34, 17, 2, 'of', '2018-09-19 12:43:01'),
(35, 18, 1, 'Benutzername', '2018-09-19 12:50:09'),
(36, 18, 2, 'Username', '2018-09-19 12:50:09'),
(37, 19, 1, 'Passwort', '2018-09-19 12:50:16'),
(38, 19, 2, 'Password', '2018-09-19 12:50:16'),
(39, 20, 1, 'Passwort vergessen', '2018-09-19 12:50:35'),
(40, 20, 2, 'Forgot password', '2018-09-19 12:50:35'),
(41, 21, 1, 'Benutzername oder Passwort leer', '2018-09-19 12:51:46'),
(42, 21, 2, 'Username or password empty', '2018-09-19 12:51:46'),
(43, 22, 1, 'Benutzername oder Passwort falsch', '2018-09-19 12:52:01'),
(44, 22, 2, 'Username or password wrong', '2018-09-19 12:52:01'),
(45, 23, 1, 'Login erfolgreich', '2018-09-19 12:52:22'),
(46, 23, 2, 'Login successful', '2018-09-19 12:52:22'),
(47, 24, 1, 'Neues Passwort', '2018-09-19 12:58:16'),
(48, 24, 2, 'New password', '2018-09-19 12:58:16'),
(49, 25, 1, 'Neues Passwort wiederholen', '2018-09-19 12:58:36'),
(50, 25, 2, 'Repeat new password', '2018-09-19 12:58:36'),
(51, 26, 1, 'Passwort erfolgreich zurückgesetzt', '2018-09-19 13:01:16'),
(52, 26, 2, 'Password changed sucessfully', '2018-09-19 13:01:16'),
(53, 27, 1, 'Ein unbekannter Fehler ist aufgetreten', '2018-09-19 13:02:08'),
(54, 27, 2, 'An unknown error occured', '2018-09-19 13:02:08'),
(55, 28, 1, 'Die Passwörter stimmen nicht überein oder sind kürzer als 6 Zeichen', '2018-09-19 13:02:50'),
(56, 28, 2, 'The provided passwords don\\\'t match or are less than 6 characters long', '2018-09-19 13:02:50'),
(57, 29, 1, 'Passwort zurücksetzen', '2018-09-19 13:04:38'),
(58, 29, 2, 'Reset password', '2018-09-19 13:04:38'),
(59, 30, 1, 'Benutzer nicht gefunden', '2018-09-19 13:05:35'),
(60, 30, 2, 'User not found', '2018-09-19 13:05:35'),
(61, 31, 1, 'Navigation', '2018-09-19 13:14:42'),
(62, 31, 2, 'Navigation', '2018-09-19 13:14:42'),
(63, 32, 1, 'Hier können Sie die Seiten und deren Inhalt bearbeiten, welche in dem Frontend dargestellt werden', '2018-09-19 13:15:25'),
(64, 32, 2, 'Edit and manage the pages that will be displayed in the frontend', '2018-09-19 13:15:25'),
(65, 33, 1, 'Unsichtbar', '2018-09-19 13:17:30'),
(66, 33, 2, 'Invisible', '2018-09-19 13:17:30'),
(67, 34, 1, 'Seiten', '2018-09-19 13:18:47'),
(68, 34, 2, 'Pages', '2018-09-19 13:18:47'),
(69, 35, 1, 'Titel', '2018-09-19 13:19:00'),
(70, 35, 2, 'Title', '2018-09-19 13:19:00'),
(71, 36, 1, 'Dieser Link ist nicht mehr gültig', '2018-09-19 13:21:55'),
(72, 36, 2, 'This link is no longer valid', '2018-09-19 13:21:55'),
(73, 37, 1, 'Artikel', '2018-09-19 13:23:49'),
(74, 37, 2, 'Articles', '2018-09-19 13:23:49'),
(75, 38, 1, 'Text', '2018-09-19 13:24:21'),
(76, 38, 2, 'Text', '2018-09-19 13:24:21'),
(77, 39, 1, 'Kein Eintrag gefunden', '2018-09-19 13:24:30'),
(78, 39, 2, 'No entry found', '2018-09-19 13:24:30'),
(79, 40, 1, 'Bilder', '2018-09-19 13:28:11'),
(80, 40, 2, 'Images', '2018-09-19 13:28:11'),
(81, 41, 1, 'Inhalt', '2018-09-19 13:28:31'),
(82, 41, 2, 'Content', '2018-09-19 13:28:31'),
(83, 42, 1, 'Bearbeiten', '2018-09-19 13:30:38'),
(84, 42, 2, 'Edit', '2018-09-19 13:30:38'),
(85, 43, 1, 'Löschen', '2018-09-19 13:30:47'),
(86, 43, 2, 'Delete', '2018-09-19 13:30:47'),
(87, 44, 1, 'Abmelden', '2018-09-19 15:35:42'),
(88, 44, 2, 'Logout', '2018-09-19 15:35:42'),
(89, 45, 1, 'Dokumente', '2018-09-19 15:37:10'),
(90, 45, 2, 'Documents', '2018-09-19 15:37:10'),
(91, 46, 1, 'Verwalten Sie hier die Dateien welche Sie auf der Webseite einbinden möchten', '2018-09-19 15:37:59'),
(92, 46, 2, 'Manage the files here, that you\\\'d like to include in the frontend', '2018-09-19 15:37:59'),
(93, 47, 1, 'Datei', '2018-09-19 15:38:39'),
(94, 47, 2, 'File', '2018-09-19 15:38:39'),
(95, 48, 1, 'Dateien', '2018-09-19 15:39:14'),
(96, 48, 2, 'Files', '2018-09-19 15:39:14'),
(97, 49, 1, 'Dateiname', '2018-09-19 15:39:20'),
(98, 49, 2, 'Filename', '2018-09-19 15:39:21'),
(101, 51, 1, 'Das Element wurde erfolgreich gelöscht', '2018-09-19 15:40:59'),
(102, 51, 2, 'The item was deleted successfully', '2018-09-19 15:40:59'),
(103, 52, 1, 'Übersetzungen', '2018-09-19 15:41:50'),
(104, 52, 2, 'Translations', '2018-09-19 15:41:50'),
(105, 53, 1, 'Verwalten Sie hier alle Übersetzungsschlüssel der Webseite und des Backends', '2018-09-19 15:42:25'),
(106, 53, 2, 'Manage all the Translationkeys for the webpage and the backend here', '2018-09-19 15:42:25'),
(107, 54, 1, 'Wert', '2018-09-19 15:43:25'),
(108, 54, 2, 'Value', '2018-09-19 15:43:25'),
(109, 55, 1, 'Übersetzung', '2018-09-19 15:44:30'),
(110, 55, 2, 'Translation', '2018-09-19 15:44:30'),
(113, 57, 1, 'Möchten Sie dieses Element wirklich löschen?', '2018-09-19 15:46:07'),
(114, 57, 2, 'Do you really want to delete this item?', '2018-09-19 15:46:07'),
(115, 58, 1, 'Einstellungen', '2018-09-19 15:56:31'),
(116, 58, 2, 'Settings', '2018-09-19 15:56:31'),
(117, 59, 1, 'Verwalten SIe hier die Benutzer welche auf das Backend Zugriff haben', '2018-09-19 15:56:59'),
(118, 59, 2, 'Manage the users that can access the backend here', '2018-09-19 15:56:59'),
(119, 60, 1, 'Benutzer', '2018-09-19 16:00:10'),
(120, 60, 2, 'User', '2018-09-19 16:00:11'),
(121, 61, 1, 'Benutzername', '2018-09-19 16:00:30'),
(122, 61, 2, 'Username', '2018-09-19 16:00:30'),
(123, 62, 1, 'E-Mail', '2018-09-19 16:00:43'),
(124, 62, 2, 'E-Mail', '2018-09-19 16:00:43'),
(125, 63, 1, 'Sprache', '2018-09-19 16:00:52'),
(126, 63, 2, 'Language', '2018-09-19 16:00:52'),
(127, 64, 1, 'Berechtigungen', '2018-09-19 16:01:05'),
(128, 64, 2, 'Permissions', '2018-09-19 16:01:05'),
(129, 65, 1, 'Passwort', '2018-09-19 16:01:16'),
(130, 65, 2, 'Password', '2018-09-19 16:01:16'),
(131, 66, 1, 'Passwort wiederholen', '2018-09-19 16:01:34'),
(132, 66, 2, 'Repeat password', '2018-09-19 16:01:34'),
(133, 67, 1, 'Änderungen erfolgreich gespeichert', '2018-09-19 16:03:51'),
(134, 67, 2, 'Changes saved successfully', '2018-09-19 16:03:51'),
(135, 68, 1, 'Eintrag erfolgreich hinzugefügt', '2018-09-19 16:04:59'),
(136, 68, 2, 'Entry added successfully', '2018-09-19 16:04:59'),
(137, 69, 1, 'Sie können sich nicht selbst aus dem System entfernen', '2018-09-19 16:07:16'),
(138, 69, 2, 'You cannot delete your own account', '2018-09-19 16:07:16'),
(139, 70, 1, 'Unterseite von', '2018-09-19 16:09:52'),
(140, 70, 2, 'Subpage of', '2018-09-19 16:09:52'),
(141, 71, 1, 'Seitenbeschreibung', '2018-09-19 16:10:23'),
(142, 71, 2, 'Page description', '2018-09-19 16:10:23'),
(143, 72, 1, 'Stichwörter (kommagetrennt)', '2018-09-19 16:11:20'),
(144, 72, 2, 'Keywords (comma separated)', '2018-09-19 16:11:20'),
(145, 73, 1, 'Social-Media Bild', '2018-09-19 16:12:14'),
(146, 73, 2, 'Social media image', '2018-09-19 16:12:14'),
(147, 74, 1, 'Inaktiv', '2018-09-20 05:20:03'),
(148, 74, 2, 'Inactive', '2018-09-20 05:20:03'),
(149, 75, 1, 'Ordnername', '2018-10-15 05:31:01'),
(150, 76, 1, 'Errorseite (404)', '2018-11-23 13:26:35'),
(151, 77, 1, 'Seitenaufrufe heute', '2018-11-24 11:39:52'),
(152, 78, 1, 'Einmalige Seitenaufrufe heute', '2018-11-24 11:40:06'),
(153, 79, 1, 'Seitenaufrufe insgesamt', '2018-11-24 11:40:23'),
(154, 80, 1, 'Einmalige Seitenaufrufe insgesamt', '2018-11-24 11:40:35'),
(155, 81, 1, 'Besucherstatistik', '2018-11-24 12:02:27'),
(156, 82, 1, 'Platformen', '2018-11-24 12:03:38'),
(157, 83, 1, 'Besucherstatistik', '2018-11-24 12:03:46');

-- --------------------------------------------------------

--
-- Table structure for table `cms_user`
--

CREATE TABLE `cms_user` (
  `user_id` int(11) NOT NULL,
  `lang_fk` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `permission_level` int(11) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `is_active` int(11) NOT NULL DEFAULT '1',
  `is_disabled` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_user`
--

INSERT INTO `cms_user` (`user_id`, `lang_fk`, `username`, `password`, `email`, `permission_level`, `last_login`, `is_active`, `is_disabled`, `timestamp`) VALUES
(1, 1, 'luki', '$2y$10$BTEPi3Gy/uDFFvnT/7PpP.WFLDyMhvKfgxYYjTfv4mJ/fNb82xXby', 'me@lmeier.ch', 2, '2018-11-24 12:55:42', 1, 0, '2018-01-15 17:11:10'),
(3, 1, 'gianreto', '$2y$10$0tulw.VZ7LjjmPGiYxA5guFxMkN9EsdIwozoJTrwfHIj6Nk4Gbx7e', 'gian.vd@gmx.ch', 1, '2018-11-01 20:26:07', 1, 0, '2018-08-20 08:15:37'),
(4, 1, 'fabienne', '$2y$10$xx1AsQ/IxynWXKBOm.URd.cFeW5.U8Nq2IIKi5FvMU.fUAKtqbb86', '', 1, '2018-11-22 15:37:24', 1, 0, '2018-08-23 20:32:04'),
(5, 1, 'test', '$2y$10$a3lE/bDKjILIpC59tQ4P5.XbRNmDaBFDIKT1VQbcYqkbz67cKJzk6', 'test@test.com', 0, '2018-09-27 15:42:49', 1, 0, '2018-08-24 12:02:57'),
(6, 1, 'FaGi', '$2y$10$8KIjwVKePrVIAZhnP46ZBebdZ/FRjgaGY5xQIycfhdfp2gwX5wTAO', 'FaGi', 1, '2018-11-01 20:38:27', 1, 1, '2018-11-01 19:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `cms_visit`
--

CREATE TABLE `cms_visit` (
  `visit_id` int(11) NOT NULL,
  `remote_ip` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `is_mobile` tinyint(4) NOT NULL,
  `useragent` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `browser_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `browser_version` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `platform_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `platform_version` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_visit`
--

INSERT INTO `cms_visit` (`visit_id`, `remote_ip`, `is_mobile`, `useragent`, `browser_name`, `browser_version`, `platform_name`, `platform_version`, `timestamp`) VALUES
(5, '178.197.232.182', 1, 'Mozilla/5.0 (Linux; Android 8.0.0; G8141) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.80 Mobile Safari/537.36', 'Chrome', '70.0.3538.80', 'Android', 'Oreo', '2018-11-24 11:54:34'),
(6, '178.192.149.130', 0, 'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko', 'Internet Explorer', '11.0', 'Windows', 'Windows 10', '2018-11-24 11:55:19'),
(7, '178.192.149.130', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'Chrome', '70.0.3538.110', 'Windows', 'Windows 10', '2018-11-24 11:55:35'),
(8, '157.55.39.26', 0, 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)', 'Bingbot', '2.0', 'unknown', 'unknown', '2018-11-24 11:57:33'),
(9, '157.55.39.26', 0, 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)', 'Bingbot', '2.0', 'unknown', 'unknown', '2018-11-24 11:57:34'),
(10, '40.77.167.162', 0, 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)', 'Bingbot', '2.0', 'unknown', 'unknown', '2018-11-24 11:57:40'),
(11, '178.192.149.130', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; Trident/7.0; rv:11.0) like Gecko', 'Internet Explorer', '11.0', 'Windows', 'Windows 10', '2018-11-24 12:00:41'),
(12, '91.242.162.42', 0, 'Mozilla/5.0 (compatible; Qwantify/2.4w; +https://www.qwant.com/)/2.4w', 'Mozilla', 'unknown', 'unknown', 'unknown', '2018-11-24 12:05:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment`
--

CREATE TABLE `tbl_appointment` (
  `appointment_id` int(11) NOT NULL,
  `name` varchar(500) COLLATE utf8_bin NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `location` varchar(1000) COLLATE utf8_bin NOT NULL,
  `all_day` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_appointment`
--

INSERT INTO `tbl_appointment` (`appointment_id`, `name`, `start_date`, `end_date`, `start_time`, `end_time`, `description`, `location`, `all_day`, `timestamp`) VALUES
(8, 'Sitzung', '2018-09-06', '2018-09-06', '19:00:00', '00:00:00', '<p>Besprechung f&uuml;r den Dorfm&auml;ret am daraufkommenden Samstag 8.9.2018</p>', '', 0, '2018-09-22 07:35:21'),
(9, 'DorfmÃ¤ret', '2018-09-08', '2018-09-08', '09:00:00', '17:00:00', '<p>D&ouml;rfm&auml;ret Lostorf</p>', 'Lostorf', 1, '2018-09-22 07:36:04'),
(10, 'Sitzung', '2018-09-13', '2018-09-13', '00:00:00', '00:00:00', '', '', 1, '2018-09-22 07:37:08'),
(11, 'Sitzung', '2018-09-13', '2018-09-13', '19:00:00', '00:00:00', '<p>Nachbesprechung Dorfm&auml;ret, Auswahl Fasnachtsmotto</p>', '', 0, '2018-09-22 07:38:09'),
(12, 'Sitzung', '2018-10-04', '2018-10-04', '19:00:00', '00:00:00', '<p>Sitzung</p>', 'Vereinslokal', 1, '2018-09-22 07:40:32'),
(13, 'Testevent', '2018-11-24', '2018-11-24', '00:00:00', '00:00:00', '', 'Vereinslokal', 1, '2018-11-21 12:19:54');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_team`
--

CREATE TABLE `tbl_team` (
  `team_id` int(11) NOT NULL,
  `firstname` varchar(200) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(200) COLLATE utf8_bin NOT NULL,
  `birthday` date NOT NULL,
  `mail` varchar(200) COLLATE utf8_bin NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `sort` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_team`
--

INSERT INTO `tbl_team` (`team_id`, `firstname`, `lastname`, `birthday`, `mail`, `is_active`, `sort`, `timestamp`) VALUES
(1, 'Gaby', 'Hurschler', '0000-00-00', 'baloga@hispeed.ch', 1, 0, '2018-08-24 08:47:16'),
(2, 'Beatrice', 'Bur', '0000-00-00', 'b.bur@hotmail.com', 1, 0, '2018-08-24 08:47:28'),
(3, 'Fabienne', 'Hurschler', '0000-00-00', 'fabienne.hurschler@hotmail.com', 1, 0, '2018-08-24 08:46:06'),
(4, 'Gian-Reto', 'von Däniken', '0000-00-00', 'gian-reto.vd@gmx.ch', 1, 0, '2018-08-24 08:46:07'),
(5, 'Leh', 'Lehmann', '0000-00-00', 'lehmann.m@hispeed.ch', 1, 0, '2018-08-24 08:48:18'),
(6, 'Pascal', 'Roos', '0000-00-00', 'pascal.roos@bluewin.ch', 1, 0, '2018-08-24 08:47:47'),
(7, 'Marco', 'Pickel', '0000-00-00', 'marco.pickel@bluewin.ch', 1, 0, '2018-08-24 08:47:53'),
(8, 'René', 'Knecht', '0000-00-00', 'r.knecht@kkstahl.ch', 1, 0, '2018-08-24 08:48:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cms_article`
--
ALTER TABLE `cms_article`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `cms_article_content`
--
ALTER TABLE `cms_article_content`
  ADD PRIMARY KEY (`article_content_id`);

--
-- Indexes for table `cms_article_content_image`
--
ALTER TABLE `cms_article_content_image`
  ADD PRIMARY KEY (`article_content_image_id`);

--
-- Indexes for table `cms_lang`
--
ALTER TABLE `cms_lang`
  ADD PRIMARY KEY (`lang_id`);

--
-- Indexes for table `cms_log`
--
ALTER TABLE `cms_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `cms_navigation`
--
ALTER TABLE `cms_navigation`
  ADD PRIMARY KEY (`navigation_id`);

--
-- Indexes for table `cms_navigation_title`
--
ALTER TABLE `cms_navigation_title`
  ADD PRIMARY KEY (`navigation_title_id`);

--
-- Indexes for table `cms_password_reset`
--
ALTER TABLE `cms_password_reset`
  ADD PRIMARY KEY (`password_reset_id`);

--
-- Indexes for table `cms_translation`
--
ALTER TABLE `cms_translation`
  ADD PRIMARY KEY (`translation_id`);

--
-- Indexes for table `cms_translation_text`
--
ALTER TABLE `cms_translation_text`
  ADD PRIMARY KEY (`translation_text_id`);

--
-- Indexes for table `cms_user`
--
ALTER TABLE `cms_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `cms_visit`
--
ALTER TABLE `cms_visit`
  ADD PRIMARY KEY (`visit_id`);

--
-- Indexes for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `tbl_team`
--
ALTER TABLE `tbl_team`
  ADD PRIMARY KEY (`team_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cms_article`
--
ALTER TABLE `cms_article`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `cms_article_content`
--
ALTER TABLE `cms_article_content`
  MODIFY `article_content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `cms_article_content_image`
--
ALTER TABLE `cms_article_content_image`
  MODIFY `article_content_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `cms_lang`
--
ALTER TABLE `cms_lang`
  MODIFY `lang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms_log`
--
ALTER TABLE `cms_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cms_navigation`
--
ALTER TABLE `cms_navigation`
  MODIFY `navigation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `cms_navigation_title`
--
ALTER TABLE `cms_navigation_title`
  MODIFY `navigation_title_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `cms_password_reset`
--
ALTER TABLE `cms_password_reset`
  MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_translation`
--
ALTER TABLE `cms_translation`
  MODIFY `translation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `cms_translation_text`
--
ALTER TABLE `cms_translation_text`
  MODIFY `translation_text_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `cms_user`
--
ALTER TABLE `cms_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cms_visit`
--
ALTER TABLE `cms_visit`
  MODIFY `visit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_team`
--
ALTER TABLE `tbl_team`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
