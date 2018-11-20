-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2018 at 03:50 AM
-- Server version: 5.7.23-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weble`
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
(10, 4, 0, 1, 0, '2018-08-07 08:13:14'),
(11, 8, 0, 1, 0, '2018-08-07 08:54:22'),
(12, 5, 0, 1, 0, '2018-08-10 07:39:08'),
(13, 2, 0, 1, 0, '2018-08-15 06:57:34'),
(14, 1, 2, 0, 0, '2018-09-17 13:58:27'),
(16, 24, 0, 1, 0, '2018-09-18 13:07:07'),
(19, 1, 1, 1, 1, '2018-09-19 16:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `cms_article_content`
--

CREATE TABLE `cms_article_content` (
  `article_content_id` int(11) NOT NULL,
  `article_fk` int(11) NOT NULL,
  `lang_fk` int(11) NOT NULL,
  `article_title` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_article_content`
--

INSERT INTO `cms_article_content` (`article_content_id`, `article_fk`, `lang_fk`, `article_title`, `text`, `timestamp`) VALUES
(1, 1, 1, 'ABCD', '<p>ABC</p>\r\n<p><img src="../media/richtext/avatar.png" alt="" width="133" height="133" /></p>\r\n<p>&nbsp;</p>\r\n<p><a title="404 erzwingen" href="../de/fgjdskgfsld">Hier klicken f&uuml;r einen erzwungenen 404 Fehler</a></p>', '2018-01-15 15:41:03'),
(2, 1, 2, 'ABCD', '<p>ABC</p>\r\n<p><img src="../media/richtext/ship_ice.jpg" alt="" width="317" height="211" /></p>\r\n<p>&nbsp;</p>\r\n<p><a title="force 404" href="../en/fgjdskgfsld">Click here to force a 404 error</a></p>', '2018-01-15 15:41:03'),
(3, 2, 1, '', '', '2018-07-30 09:14:40'),
(4, 2, 2, '', '', '2018-07-30 09:14:40'),
(13, 7, 1, 'Kontakt', '<p>Das ist der Inhalt des Kontakt-dingens</p>\r\n<p><img src="../media/richtext/converse_shoes.jpg" alt="" width="320" height="201" /></p>', '2018-07-31 14:25:00'),
(14, 7, 2, 'Contact', '<p>This is the content of the first contact-article</p>\r\n<p><img src="../media/richtext/book_space.jpg" alt="" width="320" height="200" /></p>', '2018-07-31 14:25:00'),
(17, 9, 1, 'Neuer Artikel', '<p>Mit Bilder&nbsp;</p>', '2018-08-02 11:54:14'),
(18, 9, 2, 'New Article', '<p>With images</p>', '2018-08-02 11:54:14'),
(19, 10, 1, 'Ãœber uns', '<p>&nbsp;</p>\r\n<p>Da sich das Weble CMS immernoch in der Entwicklung befindet, ist eine vollst&auml;ndige Dokumentation leider noch nicht vorhanden. Die aktuelle Dokumentation wird jedoch stetig ausgebaut/verbessert und erweitert.</p>\r\n<p>Die aktulle Dokumentation finden Sie&nbsp;<a href="https://documentation.weble.lmeier.ch/" target="_blank">hier</a></p>\r\n<p><img src="/media/richtext/theComaRecut.jpg" alt="" width="150" height="148" /></p>', '2018-08-07 08:13:14'),
(20, 10, 2, 'About us', '<p>Since the Weble CMS is still in development, a complete documentation is unfortunately not yet available. However, the current documentation is constantly being expanded/improved and extended.</p>\r\n<p>The current documentation can be found&nbsp;<a href="https://documentation.weble.lmeier.ch/" target="_blank">here</a></p>', '2018-08-07 08:13:14'),
(21, 11, 1, '404 - Seite nicht gefunden', '<p>Diese Seite konnte leider nicht gefunden werden.</p>\r\n<p><a href="de">Zur&uuml;ck</a></p>', '2018-08-07 08:54:22'),
(22, 11, 2, '404 - Page not found', '<p>This page could not be found.</p>\r\n<p><a href="en">Go Back</a></p>', '2018-08-07 08:54:22'),
(23, 12, 1, 'Inhalt', '<p>Das ist Inhalt</p>', '2018-08-10 07:39:08'),
(24, 13, 1, 'Download des Weble-CMS', '<p>Das Weble-CMS befindet sich momentan noch in der Entwicklungsphase und es wird abgeraten, das System produktiv einzusetzen. Obwohl keine Sicherheitsl&uuml;cken, oder schwerwiegende Fehler bekannt sind, kann die fehlerfreie Verwendung des CMS nicht garantiert werden.&nbsp;</p>\r\n<p>Sollten Sie trotzdem interesse haben, Weble zu verwenden oder sich ein wenig damiz vertraut zu machen, k&ouml;nnen Sie den Quellcode hier herunterladen.</p>\r\n<p>Wie sie Weble einrichten k&ouml;nnen und ein kleines Tutorial zu wichtigsten Funktionen finden Sie in dem Bereich: "Erste Schritte"</p>\r\n<h3>Downloadlinks</h3>\r\n<ul>\r\n<li><a href="/media/userdocuments/weble-cms_alpha_0.4.1.3.zip" target="_blank">weble-cms_alpha_0.4.1.3.zip</a></li>\r\n</ul>', '2018-08-15 06:57:34'),
(25, 13, 2, 'Download of the Weble-CMS', '<p>The Weble CMS is currently still in the development phase and it is not recommended to use the system productively. Although there are no known security holes or serious bugs, the flawless use of the CMS cannot be guaranteed.</p>\r\n<p>If you are still interested in using Weble or getting a little familiar with it, you can download the source code here.</p>\r\n<p>How to set up Weble and a small tutorial on the most important functions can be found in the section: "Getting started".</p>\r\n<h3>Downloadlinks</h3>\r\n<ul>\r\n<li><a href="/media/userdocuments/weble-cms_alpha_0.4.1.3.zip" target="_blank">weble-cms_alpha_0.4.1.3.zip</a></li>\r\n</ul>', '2018-08-15 06:57:34'),
(26, 14, 1, 'Webseiten sind unsere Passion', '<p>Bla bla</p>', '2018-09-17 13:58:27'),
(27, 14, 2, 'Webpages are our passion', '<p>Bla blah</p>', '2018-09-17 13:58:27'),
(28, 0, 1, 'Test', '<p>Test</p>', '2018-09-18 06:02:24'),
(29, 0, 2, 'Test', '<p>Test</p>', '2018-09-18 06:02:25'),
(30, 0, 1, 'gfsgf', '<p>gfdsgf</p>', '2018-09-18 06:04:42'),
(31, 0, 2, 'gfdsgfd', '<p>gsfdg</p>', '2018-09-18 06:04:42'),
(34, 16, 1, 'Installation und Einrichtung', '<p>Nachdem Sie die Zip-Datei mit dem Quellcode heruntergeladen und entpackt haben, kopieren Sie den Ihnalt in das Root-Verzeichnis ihrer Webseite.</p>\r\n<p>Legen Sie als n&auml;chstes eine neue SQL-Datenbank an und importieren Sie den SQL-Dump, welchen Sie im Verzeichnis _tmp finden.</p>\r\n<p>Die Einrichtung des Weble-CMS ist schon beinahe abgeschlossen. Sie brauchen nun nur noch eine Datei namens "db.php" im Root-Verzeichnis anzulegen und dort den folgenden Inhalt einzutragen:</p>\r\n<p><code>$username = "root";<br />$password = "";<br />$server = "localhost";<br />$database = "weble";</code></p>\r\n<p>&Auml;ndern Sie die Werte der Variablen entsprechend, dass eine Verbindung mit der Datenbank hergestellt werden kann.</p>', '2018-09-18 13:07:07'),
(35, 16, 2, 'Installation and setup', '<p>After you have downloaded and unpacked the zip file with the source code, copy it into the root directory of your website.</p>\r\n<p>Next, create a new SQL database and import the SQL dump, which you will find in the _tmp directory.</p>\r\n<p>The setup of the Weble-CMS is almost finished. Now all you have to do is create a file called "db.php" in the root directory and enter the following content there:</p>\r\n<p><code>$username = "root";<br />$password = "";<br />$server = "localhost";<br />$database = "weble";</code></p>\r\n<p>Change the values of the variables so that you can connect to the database.</p>', '2018-09-18 13:07:07'),
(40, 19, 1, 'fdsafd', '<p>safdsa</p>', '2018-09-19 16:14:16'),
(41, 19, 2, 'fdsaf', '<p>fdsafds</p>', '2018-09-19 16:14:16');

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
(1, 14, 1, 'DSC_0500.JPG', 0, '2018-09-17 13:59:08'),
(2, 14, 2, 'DSC_0500.JPG', 0, '2018-09-17 13:59:12'),
(3, 13, 1, 'Capture.PNG', 0, '2018-09-17 14:02:02'),
(4, 13, 2, 'Capture.PNG', 0, '2018-09-17 14:02:05'),
(5, 11, 1, '404.png', 0, '2018-09-18 07:01:21'),
(6, 11, 2, '404.png', 0, '2018-09-18 07:01:22'),
(9, 16, 1, 'install.png', 0, '2018-09-18 13:17:19'),
(10, 16, 2, 'install.png', 0, '2018-09-18 13:17:32'),
(11, 10, 1, 'documents.jpg', 0, '2018-09-18 13:40:28'),
(12, 10, 2, 'documents.jpg', 0, '2018-09-18 13:40:28');

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
(1, 'de', 'Deutsch', '2018-01-15 15:28:41'),
(2, 'en', 'English', '2018-01-15 15:28:41');

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
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_navigation`
--

INSERT INTO `cms_navigation` (`navigation_id`, `navigation_fk`, `sort`, `is_active`, `is_invisible`, `is_deleted`, `timestamp`) VALUES
(1, 0, 1, 1, 1, 0, '2018-03-11 16:56:15'),
(2, 0, 4, 1, 0, 0, '2018-03-11 16:56:21'),
(4, 0, 2, 1, 0, 0, '2018-08-07 06:58:25'),
(8, 0, 7, 1, 1, 0, '2018-08-07 08:53:42'),
(21, 0, 3, 1, 0, 0, '2018-08-28 13:06:56'),
(22, 0, 6, 1, 0, 0, '2018-08-28 13:08:03'),
(24, 0, 5, 1, 0, 0, '2018-09-17 15:55:41'),
(26, 0, 8, 1, 1, 0, '2018-09-18 06:56:11');

-- --------------------------------------------------------

--
-- Table structure for table `cms_navigation_title`
--

CREATE TABLE `cms_navigation_title` (
  `navigation_title_id` int(11) NOT NULL,
  `navigation_fk` int(11) NOT NULL,
  `lang_fk` int(11) NOT NULL,
  `title` varchar(400) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `keywords` text COLLATE utf8_bin NOT NULL,
  `link` varchar(500) COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cms_navigation_title`
--

INSERT INTO `cms_navigation_title` (`navigation_title_id`, `navigation_fk`, `lang_fk`, `title`, `description`, `keywords`, `link`, `timestamp`) VALUES
(1, 1, 1, 'Home', 'Die erste sichtbare Seite beim erstellen eines neuen Weble-Projekts', 'Home, Weble, Testpage, Homepage, Weblecms', 'home', '2018-09-17 15:44:59'),
(2, 1, 2, 'Home', 'The first page if you create a new Weble-Project', 'Home, Weble, Testpage, Homepage, Weblecms', 'home', '2018-09-17 13:32:09'),
(3, 2, 1, 'Download', 'Download des Weble CMS', 'download, weble cms, herunterladen, verwenden', 'download', '2018-09-17 13:32:22'),
(4, 2, 2, 'Download', 'Download of the Weble CMS', 'download, weble cms, get it, get it now, use, usage', 'download', '2018-09-17 13:32:22'),
(7, 4, 1, 'Dokumentation', 'Dokumentation des Weble CMS', 'dokumentation, weble cms, how to, anleitung', 'dokumentation', '2018-09-17 13:32:26'),
(8, 4, 2, 'Documentation', 'Documentation of the Weble CMS', 'documentation, weble cms, how to, manual, usage', 'documentation', '2018-09-17 13:32:26'),
(15, 8, 1, '404', '', '', '404', '2018-09-17 13:32:35'),
(16, 8, 2, '404', '', '', '404', '2018-09-17 13:32:35'),
(41, 21, 1, 'Referenzen', 'Referenzen fÃ¼r das Weble CMS', 'referenzen, weble cms, kunden', 'referenzen', '2018-09-17 13:32:29'),
(42, 21, 2, 'References', 'References for the Weble CMS', 'ferences, weble cms, customers, users', 'references', '2018-09-17 13:32:29'),
(43, 22, 1, 'Ãœber Weble', 'Ãœber das Weble CMS', 'Ã¼ber, weble cms, geschichte, vorteile, pro', 'ueber-weble', '2018-09-17 13:32:32'),
(44, 22, 2, 'About Weble', 'About the Weble CMS', 'about, weble cms, history, advantages, pro', 'about-weble', '2018-09-17 13:32:32'),
(69, 24, 1, 'Erste Schritte', 'Erste Schritte zur erfolgreichen Verwendung des Weble-CMS', 'Weble-CMS, erste Schritte, anfÃ¤nger, installation, verwendung, anwendung', 'erste-schritte', '2018-09-17 15:55:41'),
(70, 24, 2, 'First steps', 'First steps to set up the Weble-CMS and begin coding your Website', 'Weble-CMS, first steps, beginner, guide, installation, usage', 'first-steps', '2018-09-17 15:55:41'),
(73, 26, 1, 'Impressum', 'Impressum des Weble-CMS', 'Impressum, weble cms', 'impressum', '2018-09-18 06:56:11'),
(74, 26, 2, 'Impressum', 'Impressum of the Weble-CMS', 'Impressum, weble cms', 'impressum', '2018-09-18 06:56:11');

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
(74, 'navigation_inactive', '2018-09-20 05:20:02');

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
(17, 9, 1, 'Ãœbersetzungen', '2018-09-19 12:20:46'),
(18, 9, 2, 'Translations', '2018-09-19 12:20:46'),
(19, 10, 1, 'Einstellungen', '2018-09-19 12:21:03'),
(20, 10, 2, 'Settings', '2018-09-19 12:21:03'),
(21, 11, 1, 'ZurÃ¼ck', '2018-09-19 12:22:15'),
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
(51, 26, 1, 'Passwort erfolgreich zurÃ¼ckgesetzt', '2018-09-19 13:01:16'),
(52, 26, 2, 'Password changed sucessfully', '2018-09-19 13:01:16'),
(53, 27, 1, 'Ein unbekannter Fehler ist aufgetreten', '2018-09-19 13:02:08'),
(54, 27, 2, 'An unknown error occured', '2018-09-19 13:02:08'),
(55, 28, 1, 'Die PasswÃ¶rter stimmen nicht Ã¼berein oder sind kÃ¼rzer als 6 Zeichen', '2018-09-19 13:02:50'),
(56, 28, 2, 'The provided passwords don\\\'t match or are less than 6 characters long', '2018-09-19 13:02:50'),
(57, 29, 1, 'Passwort zurÃ¼cksetzen', '2018-09-19 13:04:38'),
(58, 29, 2, 'Reset password', '2018-09-19 13:04:38'),
(59, 30, 1, 'Benutzer nicht gefunden', '2018-09-19 13:05:35'),
(60, 30, 2, 'User not found', '2018-09-19 13:05:35'),
(61, 31, 1, 'Navigation', '2018-09-19 13:14:42'),
(62, 31, 2, 'Navigation', '2018-09-19 13:14:42'),
(63, 32, 1, 'Hier kÃ¶nnen Sie die Seiten und deren Inhalt bearbeiten, welche in dem Frontend dargestellt werden', '2018-09-19 13:15:25'),
(64, 32, 2, 'Edit and manage the pages that will be displayed in the frontend', '2018-09-19 13:15:25'),
(65, 33, 1, 'Unsichtbar', '2018-09-19 13:17:30'),
(66, 33, 2, 'Invisible', '2018-09-19 13:17:30'),
(67, 34, 1, 'Seiten', '2018-09-19 13:18:47'),
(68, 34, 2, 'Pages', '2018-09-19 13:18:47'),
(69, 35, 1, 'Titel', '2018-09-19 13:19:00'),
(70, 35, 2, 'Title', '2018-09-19 13:19:00'),
(71, 36, 1, 'Dieser Link ist nicht mehr gÃ¼ltig', '2018-09-19 13:21:55'),
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
(85, 43, 1, 'LÃ¶schen', '2018-09-19 13:30:47'),
(86, 43, 2, 'Delete', '2018-09-19 13:30:47'),
(87, 44, 1, 'Abmelden', '2018-09-19 15:35:42'),
(88, 44, 2, 'Logout', '2018-09-19 15:35:42'),
(89, 45, 1, 'Dokumente', '2018-09-19 15:37:10'),
(90, 45, 2, 'Documents', '2018-09-19 15:37:10'),
(91, 46, 1, 'Verwalten Sie hier die Dateien welche Sie auf der Webseite einbinden mÃ¶chten', '2018-09-19 15:37:59'),
(92, 46, 2, 'Manage the files here, that you\\\'d like to include in the frontend', '2018-09-19 15:37:59'),
(93, 47, 1, 'Datei', '2018-09-19 15:38:39'),
(94, 47, 2, 'File', '2018-09-19 15:38:39'),
(95, 48, 1, 'Dateien', '2018-09-19 15:39:14'),
(96, 48, 2, 'Files', '2018-09-19 15:39:14'),
(97, 49, 1, 'Dateiname', '2018-09-19 15:39:20'),
(98, 49, 2, 'Filename', '2018-09-19 15:39:21'),
(101, 51, 1, 'Das Element wurde erfolgreich gelÃ¶scht', '2018-09-19 15:40:59'),
(102, 51, 2, 'The item was deleted successfully', '2018-09-19 15:40:59'),
(103, 52, 1, 'Ãœbersetzungen', '2018-09-19 15:41:50'),
(104, 52, 2, 'Translations', '2018-09-19 15:41:50'),
(105, 53, 1, 'Verwalten Sie hier alle ÃœbersetzungsschlÃ¼ssel der Webseite und des Backends', '2018-09-19 15:42:25'),
(106, 53, 2, 'Manage all the Translationkeys for the webpage and the backend here', '2018-09-19 15:42:25'),
(107, 54, 1, 'Wert', '2018-09-19 15:43:25'),
(108, 54, 2, 'Value', '2018-09-19 15:43:25'),
(109, 55, 1, 'Ãœbersetzung', '2018-09-19 15:44:30'),
(110, 55, 2, 'Translation', '2018-09-19 15:44:30'),
(113, 57, 1, 'MÃ¶chten Sie dieses Element wirklich lÃ¶schen?', '2018-09-19 15:46:07'),
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
(133, 67, 1, 'Ã„nderungen erfolgreich gespeichert', '2018-09-19 16:03:51'),
(134, 67, 2, 'Changes saved successfully', '2018-09-19 16:03:51'),
(135, 68, 1, 'Eintrag erfolgreich hinzugefÃ¼gt', '2018-09-19 16:04:59'),
(136, 68, 2, 'Entry added successfully', '2018-09-19 16:04:59'),
(137, 69, 1, 'Sie kÃ¶nnen sich nicht selbst aus dem System entfernen', '2018-09-19 16:07:16'),
(138, 69, 2, 'You cannot delete your own account', '2018-09-19 16:07:16'),
(139, 70, 1, 'Unterseite von', '2018-09-19 16:09:52'),
(140, 70, 2, 'Subpage of', '2018-09-19 16:09:52'),
(141, 71, 1, 'Seitenbeschreibung', '2018-09-19 16:10:23'),
(142, 71, 2, 'Page description', '2018-09-19 16:10:23'),
(143, 72, 1, 'StichwÃ¶rter (kommagetrennt)', '2018-09-19 16:11:20'),
(144, 72, 2, 'Keywords (comma separated)', '2018-09-19 16:11:20'),
(145, 73, 1, 'Social-Media Bild', '2018-09-19 16:12:14'),
(146, 73, 2, 'Social media image', '2018-09-19 16:12:14'),
(147, 74, 1, 'Inaktiv', '2018-09-20 05:20:03'),
(148, 74, 2, 'Inactive', '2018-09-20 05:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `cms_user`
--

CREATE TABLE `cms_user` (
  `user_id` int(11) NOT NULL,
  `lang_fk` int(11) NOT NULL DEFAULT '1',
  `username` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `permission_level` int(11) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `is_active` int(11) NOT NULL DEFAULT '1',
  `is_disabled` tinyint(4) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_user`
--

INSERT INTO `cms_user` (`user_id`, `lang_fk`, `username`, `password`, `email`, `permission_level`, `last_login`, `is_active`, `is_disabled`, `timestamp`) VALUES
(1, 1, 'admin', '$2y$10$hvarQ0o34ZINFuyScRaZWeZQ9JyPowZpZQPCgYN.OXvwhVP7TbJUW', 'me@lmeier.ch', 2, '2018-09-23 19:23:35', 1, 0, '2018-01-15 17:11:10'),
(3, 1, 'testman', '$2y$10$jsYTiIewsnQlAcWfpGXw0eI.JmOcn7ELbUZ5O5L4qpdiCbHCBrvrW', 'test@man.com', 0, '1970-01-01 00:00:00', 1, 0, '2018-09-23 17:32:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_calendar`
--

CREATE TABLE `tbl_calendar` (
  `calendar_id` int(11) NOT NULL,
  `name` varchar(300) COLLATE utf8_bin NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `all_day` tinyint(4) NOT NULL,
  `color` varchar(50) COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_calendar`
--

INSERT INTO `tbl_calendar` (`calendar_id`, `name`, `start_date`, `end_date`, `start_time`, `end_time`, `all_day`, `color`, `timestamp`) VALUES
(1, 'Squash', '2018-09-04', '2018-09-04', '20:00:00', '21:00:00', 0, '#ec8db0', '2018-09-04 15:30:01'),
(2, 'Tische Aufstellen fÃ¼r das Strassenfest', '2018-09-06', '2018-09-06', '18:30:00', '20:30:00', 1, '#8decec', '2018-09-04 15:30:51'),
(3, 'Amsterdam', '2018-10-04', '2018-10-07', '00:00:00', '00:00:00', 1, '#c7ec8d', '2018-09-04 15:31:06'),
(5, 'GanztÃ¤giger Event', '2018-10-06', '2018-10-06', '00:00:00', '00:00:00', 1, '#f6ff6b', '2018-09-04 15:32:00'),
(6, 'Counter Strike - Global Offensive', '2018-09-18', '2018-09-18', '19:00:00', '22:00:00', 0, '#c7ec8d', '2018-09-17 13:35:53'),
(8, 'Ferien im Wallis', '2018-10-09', '2018-10-13', '00:00:00', '00:00:00', 1, '#8decec', '2018-09-18 07:13:41'),
(10, 'Kleiner Event', '2018-10-15', '2018-10-15', '10:00:00', '12:00:00', 0, '#8decec', '2018-09-18 12:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_team`
--

CREATE TABLE `tbl_team` (
  `team_id` int(11) NOT NULL,
  `firstname` varchar(200) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(200) COLLATE utf8_bin NOT NULL,
  `birthday` date NOT NULL,
  `role` varchar(200) COLLATE utf8_bin NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `sort` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
-- Indexes for table `tbl_calendar`
--
ALTER TABLE `tbl_calendar`
  ADD PRIMARY KEY (`calendar_id`);

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
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `cms_article_content`
--
ALTER TABLE `cms_article_content`
  MODIFY `article_content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `cms_article_content_image`
--
ALTER TABLE `cms_article_content_image`
  MODIFY `article_content_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `cms_lang`
--
ALTER TABLE `cms_lang`
  MODIFY `lang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cms_navigation`
--
ALTER TABLE `cms_navigation`
  MODIFY `navigation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `cms_navigation_title`
--
ALTER TABLE `cms_navigation_title`
  MODIFY `navigation_title_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `cms_password_reset`
--
ALTER TABLE `cms_password_reset`
  MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cms_translation`
--
ALTER TABLE `cms_translation`
  MODIFY `translation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `cms_translation_text`
--
ALTER TABLE `cms_translation_text`
  MODIFY `translation_text_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;
--
-- AUTO_INCREMENT for table `cms_user`
--
ALTER TABLE `cms_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_calendar`
--
ALTER TABLE `tbl_calendar`
  MODIFY `calendar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_team`
--
ALTER TABLE `tbl_team`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
