<?php
$db->query("CREATE TABLE `cms_article` (`article_id` int(11) NOT NULL,`navigation_fk` int(11) NOT NULL,`sort` int(11) NOT NULL DEFAULT '0',`is_active` tinyint(4) NOT NULL,`is_deleted` tinyint(4) NOT NULL,`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1");
$db->query("CREATE TABLE `cms_article_content` (`article_content_id` int(11) NOT NULL,`article_fk` int(11) NOT NULL,`lang_fk` int(11) NOT NULL,`article_title` varchar(100) NOT NULL,`text` text NOT NULL,`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1");
$db->query("CREATE TABLE `cms_article_content_image` (`article_content_image_id` int(11) NOT NULL,`article_content_fk` int(11) NOT NULL,`lang_fk` int(11) NOT NULL,`image` varchar(500) COLLATE utf8_bin NOT NULL,`sort` int(11) NOT NULL DEFAULT '0',`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin");
$db->query("CREATE TABLE `cms_lang` (`lang_id` int(11) NOT NULL,`short` varchar(500) NOT NULL,`name` varchar(500) NOT NULL,`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1");
$db->query("CREATE TABLE `cms_navigation` (`navigation_id` int(11) NOT NULL,`navigation_fk` int(11) NOT NULL,`sort` int(11) NOT NULL DEFAULT '0',`is_active` tinyint(4) NOT NULL,`is_invisible` tinyint(4) NOT NULL,`is_deleted` tinyint(4) NOT NULL,`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1");
$db->query("CREATE TABLE `cms_navigation_title` (`navigation_title_id` int(11) NOT NULL,`navigation_fk` int(11) NOT NULL,`lang_fk` int(11) NOT NULL,`title` varchar(400) COLLATE utf8_bin NOT NULL,`description` text COLLATE utf8_bin NOT NULL,`keywords` text COLLATE utf8_bin NOT NULL,`link` varchar(500) COLLATE utf8_bin NOT NULL,`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin");
$db->query("CREATE TABLE `cms_password_reset` (`password_reset_id` int(11) NOT NULL,`username` varchar(250) NOT NULL,`hash` varchar(500) NOT NULL,`used` tinyint(4) NOT NULL DEFAULT '0',`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1");
$db->query("CREATE TABLE `cms_translation` (`translation_id` int(11) NOT NULL,`key` varchar(500) NOT NULL,`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1");
$db->query("CREATE TABLE `cms_translation_text` (`translation_text_id` int(11) NOT NULL,`translation_fk` int(11) NOT NULL,`lang_fk` int(11) NOT NULL,`text` text CHARACTER SET latin1 NOT NULL,`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin");
$db->query("CREATE TABLE `cms_user` (`user_id` int(11) NOT NULL,`lang_fk` int(11) NOT NULL DEFAULT '1',`username` varchar(50) NOT NULL,`password` varchar(500) NOT NULL,`email` varchar(500) NOT NULL,`permission_level` int(11) NOT NULL,`last_login` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',`is_active` int(11) NOT NULL DEFAULT '1',`is_disabled` tinyint(4) NOT NULL DEFAULT '0',`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1");
$db->query("CREATE TABLE `cms_log` (`log_id` int(11) NOT NULL,`user_fk` int(11) NOT NULL,`message` text COLLATE utf8_bin NOT NULL,`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin");

//INDEX TABLES
$db->query("ALTER TABLE `cms_article` ADD PRIMARY KEY (`article_id`)");
$db->query("ALTER TABLE `cms_article_content` ADD PRIMARY KEY (`article_content_id`)");
$db->query("ALTER TABLE `cms_article_content_image` ADD PRIMARY KEY (`article_content_image_id`)");
$db->query("ALTER TABLE `cms_lang` ADD PRIMARY KEY (`lang_id`)");
$db->query("ALTER TABLE `cms_navigation` ADD PRIMARY KEY (`navigation_id`)");
$db->query("ALTER TABLE `cms_navigation_title` ADD PRIMARY KEY (`navigation_title_id`)");
$db->query("ALTER TABLE `cms_password_reset` ADD PRIMARY KEY (`password_reset_id`)");
$db->query("ALTER TABLE `cms_translation` ADD PRIMARY KEY (`translation_id`)");
$db->query("ALTER TABLE `cms_translation_text` ADD PRIMARY KEY (`translation_text_id`)");
$db->query("ALTER TABLE `cms_user` ADD PRIMARY KEY (`user_id`)");
$db->query("ALTER TABLE `cms_log` ADD PRIMARY KEY (`log_id`)");

//AUTO INCREMENT
$db->query("ALTER TABLE `cms_article` MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1");
$db->query("ALTER TABLE `cms_article_content` MODIFY `article_content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1");
$db->query("ALTER TABLE `cms_article_content_image` MODIFY `article_content_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1");
$db->query("ALTER TABLE `cms_lang` MODIFY `lang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1");
$db->query("ALTER TABLE `cms_navigation` MODIFY `navigation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1");
$db->query("ALTER TABLE `cms_navigation_title` MODIFY `navigation_title_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1");
$db->query("ALTER TABLE `cms_password_reset` MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1");
$db->query("ALTER TABLE `cms_translation` MODIFY `translation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1");
$db->query("ALTER TABLE `cms_translation_text` MODIFY `translation_text_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1");
$db->query("ALTER TABLE `cms_user` MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1");
$db->query("ALTER TABLE `cms_log` MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20");

//INSERT DATA
$db->query("INSERT INTO `cms_lang` (`lang_id`, `short`, `name`, `timestamp`) VALUES (1, 'de', 'Deutsch', '".date("Y-m-d H:i:s")."'),(2, 'en', 'English', '".date("Y-m-d H:i:s")."')");
$db->query("INSERT INTO `cms_translation` (`translation_id`, `key`, `timestamp`) VALUES
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
	(75, 'media_foldername', '2018-09-25 09:12:31'),
	(76, 'login_error_mailserver', '2018-09-26 07:42:54')");

$db->query("INSERT INTO `cms_translation_text` (`translation_text_id`, `translation_fk`, `lang_fk`, `text`, `timestamp`) VALUES
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
	(56, 28, 2, 'The provided passwords don\'t match or are less than 6 characters long', '2018-09-19 13:02:50'),
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
	(92, 46, 2, 'Manage the files here, that you\'d like to include in the frontend', '2018-09-19 15:37:59'),
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
	(148, 74, 2, 'Inactive', '2018-09-20 05:20:03'),
	(149, 75, 1, 'Ordnername', '2018-09-25 09:12:31'),
	(150, 75, 2, 'Foldername', '2018-09-25 09:12:31'),
	(151, 76, 1, 'Es konnte keine Verbindung zum Mailserver aufgebaut werden', '2018-09-26 07:42:54'),
	(152, 76, 2, 'The connection to the mailserver could not have been established', '2018-09-26 07:42:54')");

?>