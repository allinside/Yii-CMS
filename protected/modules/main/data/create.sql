CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) NOT NULL COMMENT 'Имя',
  `email` varchar(200) NOT NULL COMMENT 'Email',
  `message` text NOT NULL COMMENT 'Сообщение',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создано',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(128) DEFAULT NULL COMMENT 'Тип',
  `category` varchar(128) DEFAULT NULL COMMENT 'Категория',
  `logtime` datetime DEFAULT NULL COMMENT 'Время',
  `message` text COMMENT 'Сообщение',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=627 ;

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `section_id` int(11) unsigned DEFAULT NULL COMMENT 'Раздел',
  `const` varchar(50) NOT NULL COMMENT 'Константа',
  `title` varchar(100) NOT NULL COMMENT 'Заголовок',
  `value` text NOT NULL COMMENT 'Значение',
  `element` enum('text','textarea','editor') NOT NULL COMMENT 'Элемент',
  PRIMARY KEY (`id`),
  UNIQUE KEY `const` (`const`),
  UNIQUE KEY `title` (`title`),
  KEY `section_id` (`section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

CREATE TABLE IF NOT EXISTS `settings_sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT 'Название раздела',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Разделы настроек' AUTO_INCREMENT=5 ;

ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `settings_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
