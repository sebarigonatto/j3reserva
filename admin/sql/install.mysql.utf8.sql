CREATE TABLE IF NOT EXISTS `#__items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET latin1 NOT NULL,
  `img` varchar(255) CHARACTER SET latin1 NOT NULL,
  `descripcion` text CHARACTER SET latin1 NOT NULL,
  `costo` float NOT NULL COMMENT 'valor por hora',
  -- para funciones de joomla--
   `state` TINYINT(1) NOT NULL default '0',
  `publish_up` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', 
  `publish_down` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='items a reservar ' AUTO_INCREMENT=1 ;


-- Estructura de tabla para la tabla `eventos`--

CREATE TABLE IF NOT EXISTS `#__eventos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(80) NOT NULL,
  `inicio` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `lugar` varchar(120) NOT NULL,
  `descripcion` text NOT NULL,
  `tel` varchar(15) NOT NULL COMMENT 'telefono o celular del resposable del evento',
  `mail` varchar(320) NOT NULL COMMENT 'email del responsable del evento',
 -- para funciones de joomla--
   `state` TINYINT(1) NOT NULL default '0',
  `publish_up` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', 
  `publish_down` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` INT(11) NOT NULL DEFAULT '0',  
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='eventos para el componente j3reserva' AUTO_INCREMENT=1 ;

-- Estructura de tabla para la tabla `eventos_items`relacion Muchos a Muchos--

CREATE TABLE IF NOT EXISTS `#__eventos_items` (
  `eventos_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `precio` float NOT NULL,
 -- para funciones de joomla--
   `state` TINYINT(1) NOT NULL default '0',
  `publish_up` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', 
  `publish_down` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`eventos_id`,`items_id`),
  KEY `items_id` (`items_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- llaves foraneas 
--
ALTER TABLE `#__eventos_items`
  ADD CONSTRAINT `#__eventos_items_ibfk_2` FOREIGN KEY (`items_id`) REFERENCES `#__items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `#__eventos_items_ibfk_1` FOREIGN KEY (`eventos_id`) REFERENCES `#__eventos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;