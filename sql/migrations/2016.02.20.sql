ALTER TABLE  `dbStats` ADD COLUMN `referrer` varchar(255) DEFAULT NULL;
ALTER TABLE  `dbStats` ADD COLUMN `ipaddress` varchar(15) DEFAULT NULL;

DROP TABLE IF EXISTS `ipLocations`;
CREATE TABLE `ipLocations` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ipRange` varchar(75) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;