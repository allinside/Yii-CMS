CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) NOT NULL COMMENT 'Имя пользователя',
  `section_id` int(11) NOT NULL COMMENT 'Раздел',
  `question` longtext NOT NULL COMMENT 'Вопрос',
  `answer` longtext COMMENT 'Ответ',
  `is_published` int(1) NOT NULL DEFAULT '0' COMMENT 'Опубликовано',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добалено',
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`),
  KEY `date` (`date_create`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


CREATE TABLE IF NOT EXISTS `faq_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL COMMENT 'Название',
  `is_published` int(1) NOT NULL DEFAULT '0' COMMENT 'Опубликован',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


ALTER TABLE `faq`
  ADD CONSTRAINT `faq_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `faq_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

