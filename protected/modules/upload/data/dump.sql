
--
-- Структура таблицы `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `tag` varchar(100) DEFAULT NULL,
  `has_watermark` tinyint(1) unsigned NOT NULL,
  `title` text,
  `descr` text,
  `extension` varchar(5) NOT NULL,
  `mimeType` varchar(100) NOT NULL,
  `idParent` int(11) NOT NULL,
  `typeParent` varchar(100) NOT NULL,
  `order` int(110) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=150 ;

