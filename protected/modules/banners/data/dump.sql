
CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL COMMENT 'Название',
  `url` varchar(500) NOT NULL COMMENT 'URL',
  `title` varchar(250) NOT NULL COMMENT 'Атрибут Title',
  `alt` varchar(250) NOT NULL COMMENT 'Атрибут Alt',
  `image` varchar(38) NOT NULL COMMENT 'Изображение',
  `is_active` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Активен',
  `order` int(11) NOT NULL COMMENT 'Порядок',
  `date_create` int(11) NOT NULL COMMENT 'Добавлен',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;