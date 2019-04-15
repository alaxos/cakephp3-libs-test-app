
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `cakephp-test`
--

-- --------------------------------------------------------

--
-- Structure de la table `log_categories`
--

CREATE TABLE `log_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `log_categories`
--

INSERT INTO `log_categories` (`id`, `name`) VALUES
(1, 'request'),
(2, 'bot request'),
(3, 'visit'),
(4, 'login'),
(5, 'new_contact_request'),
(6, 'contact_request_accepted'),
(7, 'contact_request_cancelled'),
(8, 'contact_request_declined'),
(9, 'new_contact_message'),
(10, 'new_abuse_report'),
(11, 'new_user'),
(12, 'contact_request_deleted');

-- --------------------------------------------------------

--
-- Structure de la table `log_entries`
--

CREATE TABLE `log_entries` (
  `id` int(11) NOT NULL,
  `log_level_id` int(11) NOT NULL,
  `log_category_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `url` varchar(512) DEFAULT NULL,
  `http_method` varchar(10) DEFAULT NULL,
  `client_ip` varchar(50) DEFAULT NULL,
  `client_hostname` varchar(100) DEFAULT NULL,
  `user_agent` varchar(256) DEFAULT NULL,
  `referer` varchar(1024) DEFAULT NULL,
  `post_data` text,
  `headers` text,
  `cookies` text,
  `session` text,
  `created` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `log_levels`
--

CREATE TABLE `log_levels` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `log_levels`
--

INSERT INTO `log_levels` (`id`, `name`, `created`, `modified`) VALUES
(1, 'alert', '2014-08-21 09:53:38', '2014-08-21 09:53:38'),
(2, 'critical', '2014-08-21 09:53:38', '2014-08-21 09:53:38'),
(3, 'error', '2014-08-21 09:53:38', '2014-08-21 09:53:38'),
(4, 'warning', '2014-08-21 09:53:38', '2014-08-21 09:53:38'),
(5, 'notice', '2014-08-21 09:53:38', '2014-08-21 09:53:38'),
(6, 'info', '2014-08-21 09:53:38', '2014-08-21 09:53:38'),
(7, 'debug', '2014-08-21 09:53:38', '2014-08-21 09:53:38'),
(9, 'emergency', '2014-08-21 09:53:38', '2014-08-21 09:53:38');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'admin', '2017-03-10 14:39:09', NULL, '2019-04-15 10:21:07', NULL),
(2, 'user', '2017-03-16 14:39:16', NULL, '2019-04-15 10:21:17', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `things`
--

CREATE TABLE `things` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `int_field` int(11) DEFAULT NULL,
  `smallint_field` smallint(6) DEFAULT NULL,
  `bigint_field` bigint(20) DEFAULT NULL,
  `decimal_field` decimal(10,2) DEFAULT NULL,
  `float_field` float DEFAULT NULL,
  `double_field` double DEFAULT NULL,
  `real_field` double DEFAULT NULL,
  `boolean_field` tinyint(1) NOT NULL DEFAULT '0',
  `date_field` date DEFAULT NULL,
  `datetime_field` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `things`
--

INSERT INTO `things` (`id`, `user_id`, `name`, `description`, `int_field`, `smallint_field`, `bigint_field`, `decimal_field`, `float_field`, `double_field`, `real_field`, `boolean_field`, `date_field`, `datetime_field`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 5, 'Something', 'Just a thing', 35, 5, 9223372036854775807, '56.90', 12.6981, 45.9821, 0.056998, 0, NULL, NULL, '2019-04-15 08:07:53', NULL, '2019-04-15 10:22:04', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `external_uid` varchar(100) NOT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `role_id`, `firstname`, `lastname`, `email`, `external_uid`, `last_login_date`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 1, 'John', 'Doe', 'john.doe@example.com', '12345@example.com', NULL, '2018-06-25 10:40:00', NULL, '2019-04-15 10:20:41', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `log_categories`
--
ALTER TABLE `log_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `log_entries`
--
ALTER TABLE `log_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_level_id` (`log_level_id`),
  ADD KEY `log_category_id` (`log_category_id`);

--
-- Index pour la table `log_levels`
--
ALTER TABLE `log_levels`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `things`
--
ALTER TABLE `things`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `external_uid` (`external_uid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `log_categories`
--
ALTER TABLE `log_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `log_entries`
--
ALTER TABLE `log_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `log_levels`
--
ALTER TABLE `log_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `things`
--
ALTER TABLE `things`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `log_entries`
--
ALTER TABLE `log_entries`
  ADD CONSTRAINT `log_entries_ibfk_1` FOREIGN KEY (`log_level_id`) REFERENCES `log_levels` (`id`),
  ADD CONSTRAINT `log_entries_ibfk_2` FOREIGN KEY (`log_category_id`) REFERENCES `log_categories` (`id`);

--
-- Contraintes pour la table `things`
--
ALTER TABLE `things`
  ADD CONSTRAINT `things_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
