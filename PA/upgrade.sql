-- Add the 'issueDate' field
ALTER TABLE `paFiles` ADD COLUMN `issueDate` DATE NULL  AFTER `name` ;

-- Add the 'issueNumber' field
ALTER TABLE `paFiles` ADD COLUMN `issueNumber` VARCHAR(10) NULL  AFTER `issueDate` ;

-- Add the 'issueYear' field (Added for improved SQL query speed)
ALTER TABLE `paFiles` ADD COLUMN `issueYear` SMALLINT(4) AFTER `issueDate`;

-- Add an index for the issueDate (will speed up several SQL statements greatly)
CREATE INDEX paFiles_issueDate ON paFiles(issueDate);
CREATE INDEX paFiles_issueYear ON paFiles(issueYear);

-- Drop the 'year' field since we can now determine this from the 'issueDate' field
ALTER TABLE `paFiles` DROP COLUMN `year` ;

-- Delete the 2 known 'bad' PA issues
DELETE FROM `paFiles` WHERE `ID` IN (48,330);

-- Manualy set the 1 PDF that's in the seed database
UPDATE `paFiles` SET `issueDate`='2007-2-3', `issueYear`=2007 WHER `id`=337;

-- Create the 'snippets' table
CREATE  TABLE `snippets` (
  `ID` VARCHAR(25) NULL,
  `systems` INT(1),
  `name` VARCHAR(45) NULL,
  `value` TEXT NULL ,
  PRIMARY KEY (`ID`));
INSERT INTO `snippets` (`ID`,`systems`,`name`,`value`) VALUES('allowedFileTypes','1','[Systems] Allowed MIME Types', 'text/html,application/pdf');
INSERT INTO `snippets` (`ID`,`systems`,`name`,`value`) VALUES('baseURL',         '1','[Systems] database base URL',  'http://www.libraries.wvu.edu/databases/PA');
INSERT INTO `snippets` (`ID`,`systems`,`name`,`value`) VALUES('name',            '0','Database Name',                'Petroleum Abstracts');
INSERT INTO `snippets` (`ID`,`systems`,`name`,`value`) VALUES('description',     '0','Database description',         'The Petroleum Abstracts service provides bibliographic petroleum information products and services for the global petroleum exploration and production industry. These products cover the petroleum topic areas of geosciences, drilling, reservoir and production engineering, shipping and storage and other technologies relevant to the upstream petroleum industry.');
INSERT INTO `snippets` (`ID`,`systems`,`name`,`value`) VALUES('imgSource',       '0','Database image',               '{snippet field="value" id="baseURL"}/images/cover.png');
INSERT INTO `snippets` (`ID`,`systems`,`name`,`value`) VALUES('imgAlt',          '0','Database image alt text',      '{snippet field="value" id="name"}');
INSERT INTO `snippets` (`ID`,`systems`,`name`,`value`) VALUES('pageTitle',       '0','Homepage title',               '{snippet field="value" id="name"}');

