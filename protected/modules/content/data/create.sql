SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(50) NOT NULL COMMENT 'Название',
  `is_visible` tinyint(1) NOT NULL COMMENT 'Отображать',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `menu_links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned DEFAULT NULL COMMENT 'Страница',
  `menu_id` int(11) unsigned NOT NULL COMMENT 'Меню',
  `title` varchar(50) NOT NULL COMMENT 'Заголовок',
  `url` varchar(200) NOT NULL COMMENT 'Адрес',
  `user_role` varchar(100) NOT NULL COMMENT 'Только для',
  `order` int(11) NOT NULL COMMENT 'Порядок',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Отображать',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Родитель',
  `meta_title` varchar(250) DEFAULT NULL COMMENT 'META заголовок',
  `meta_description` varchar(250) DEFAULT NULL COMMENT 'META описание',
  `meta_keywords` varchar(250) DEFAULT NULL COMMENT 'META ключевые слова',
  `title` varchar(200) NOT NULL COMMENT 'Заголовок',
  `url` varchar(250) DEFAULT NULL COMMENT 'Адрес',
  `short_text` text COMMENT 'Краткий текст',
  `text` text NOT NULL COMMENT 'Текст',
  `is_folder` tinyint(1) unsigned NOT NULL COMMENT 'Папка',
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Опубликована',
  `date` date DEFAULT NULL COMMENT 'Дата',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создана',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

CREATE TABLE IF NOT EXISTS `pages_blocks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL COMMENT 'Заголовок',
  `name` varchar(50) NOT NULL COMMENT 'Название (англ.)',
  `text` longtext NOT NULL COMMENT 'Текст',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлено',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
