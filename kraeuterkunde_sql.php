CREATE TABLE IF NOT EXISTS `e107_kraeuterkunde` (
  `kk_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kk_Name_dt` varchar(255) NOT NULL COMMENT 'der deutsche Name',
  `kk_Name_lt` varchar(255) NOT NULL COMMENT 'der lateinische Name',
  `kk_Name_vt` text COMMENT 'volkstuemliche Namen',
  `kk_HWirkung_ID_fremd` varchar(255) NOT NULL COMMENT 'die IDs aus der Heilwirkung-Tabelle',
  `kk_Anwendung_ID_fremd` varchar(255) NOT NULL COMMENT 'die IDs aus der Anwendungs-Tabelle',
  `kk_Pflanzenteile` varchar(255) NOT NULL COMMENT 'die Teile der Pflanze, die man nutzen kann',
  `kk_Sammelzeit` varchar(255) NOT NULL COMMENT 'Erntereife, Sammelzeit',
  `kk_Inhaltsstoffe` text COMMENT 'Was ist drin in der Pflanze',
  `kk_Benutzung` text NOT NULL COMMENT 'Wie benutzt man die Pflanze',
  PRIMARY KEY (`kk_id`),
  UNIQUE KEY `kk_Name_dt` (`kk_Name_dt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Kleine Kräuterkunde - die Kräuter' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `e107_kraeuterkunde_anwendungsbereich` (
  `kk_Anwendung_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kk_Anwendung_Bereich` varchar(255) NOT NULL,
  PRIMARY KEY (`kk_Anwendung_ID`),
  UNIQUE KEY `kk_Anwendung_Bereich` (`kk_Anwendung_Bereich`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='bei welchen Beschwerden einsetzen' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `e107_kraeuterkunde_heilwirkung` (
  `kk_HWirkung_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kk_HWirkung_Wirkung` varchar(255) NOT NULL,
  PRIMARY KEY (`kk_HWirkung_ID`),
  UNIQUE KEY `kk_HWirkung_Wirkung` (`kk_HWirkung_Wirkung`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Die Wirkungen der Pflanzen' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `e107_kraeuterkunde_inhaltsstoffe_def` (
  `kk_inhalt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kk_inhalt_inhalt` text NOT NULL,
  PRIMARY KEY (`kk_inhalt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Die Inhaltsstoffe kurz erklärt' AUTO_INCREMENT=1 ;