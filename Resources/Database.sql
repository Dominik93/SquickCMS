-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 18 Gru 2014, 19:04
-- Wersja serwera: 5.5.28-log
-- Wersja PHP: 5.2.17


-- !! Root account: 
-- !!  LOGIN: Admin
-- !!  PASSWORD: Admin
-- !! Remember! Change this value after first login!


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `virt101443_cms`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Articles`
--

CREATE TABLE IF NOT EXISTS `Articles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `ID_Author` int(11) NOT NULL,
  `Create_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Text` text COLLATE utf8_polish_ci NOT NULL,
  `Public` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Author` (`ID_Author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Coords`
--

CREATE TABLE IF NOT EXISTS `Coords` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `About_Place` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `X_Coords` double NOT NULL,
  `Y_Coords` double NOT NULL,
  `ID_Coords` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Coords` (`ID_Coords`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Galleries`
--

CREATE TABLE IF NOT EXISTS `Galleries` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `ID_Author` int(11) NOT NULL,
  `Create_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `ID_Author` (`ID_Author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `inGallery`
--

CREATE TABLE IF NOT EXISTS `inGallery` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Photo` int(11) NOT NULL,
  `ID_Gallery` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Photo` (`ID_Photo`),
  KEY `ID_Gallery` (`ID_Gallery`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Logs`
--

CREATE TABLE IF NOT EXISTS `Logs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_User` int(11) NOT NULL,
  `Object_Type` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Object_Field` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `ID_Object` int(11) NOT NULL,
  `Operation_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Operation_Type` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Value_Before` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Value_After` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Maps`
--

CREATE TABLE IF NOT EXISTS `Maps` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `ID_Author` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_id_author` (`ID_Author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Photos`
--

CREATE TABLE IF NOT EXISTS `Photos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Photo_Author` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `Storage_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Path` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Predefined_Areas`
--

CREATE TABLE IF NOT EXISTS `Predefined_Areas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Area_Name` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `Area_Input` text COLLATE utf8_polish_ci NOT NULL,
  `ID_Template` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Template` (`ID_Template`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Privilages`
--

CREATE TABLE IF NOT EXISTS `Privilages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Privilage_Name` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `Enable` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Ranks`
--

CREATE TABLE IF NOT EXISTS `Ranks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Privilages` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Privilages` (`ID_Privilages`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Sessions`
--

CREATE TABLE IF NOT EXISTS `Sessions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_User` int(11) NOT NULL,
  `Session` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Session_IP` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `LastAction_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Tasks`
--

CREATE TABLE IF NOT EXISTS `Tasks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Text` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Create_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID_Author` int(11) NOT NULL,
  `Passed` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Author` (`ID_Author`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Templates`
--

CREATE TABLE IF NOT EXISTS `Templates` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `Add_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ID_Creator` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Creator` (`ID_Creator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Rank` int(11) NOT NULL,
  `Login` varchar(64) COLLATE utf8_polish_ci NOT NULL,
  `Password` varchar(64) COLLATE utf8_polish_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `Display_Name` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `Registry_Date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Lastlog_Date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

--
-- Wyzwalacze `Users`
--
DROP TRIGGER IF EXISTS `user_delete_logs`;
DELIMITER //
CREATE TRIGGER `user_delete_logs` BEFORE DELETE ON `Users`
 FOR EACH ROW BEGIN
 
    INSERT INTO Logs
    SET Object_Type = 'Users',
    	Object_Field = 'ALL',
     	ID_Object = OLD.ID,
     	Operation_Type = "Delete",
        Value_Before = CONCAT(OLD.ID,";",
        		OLD.Login,";",
                        OLD.Password,";",
                        OLD.Email,";",
                        OLD.Display_Name,";",
                        OLD.Registry_Date),
	Value_After = "NULL";
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `user_update_logs`;
DELIMITER //
CREATE TRIGGER `user_update_logs` BEFORE UPDATE ON `Users`
 FOR EACH ROW BEGIN
    IF OLD.ID_Rank!=NEW.ID_Rank THEN
    	INSERT INTO Logs 
    	SET Object_Type = 'Users',
        	Object_Field = 'ID_Rank',
     		ID_Object = OLD.ID,
     		Operation_Type = "Update",
                Value_Before = OLD.ID_Rank,
                Value_After = NEW.ID_Rank;
    END IF;
    IF OLD.Login!=NEW.Login THEN
    	INSERT INTO Logs 
    	SET Object_Type = 'Users',
        	Object_Field = 'Login',
     		ID_Object = OLD.ID,
     		Operation_Type = "Update",
                Value_Before = OLD.Login,
                Value_After = NEW.Login;
    END IF;
    IF OLD.Email!=NEW.Email THEN
    	INSERT INTO Logs 
    	SET Object_Type = 'Users',
        	Object_Field = 'Email',
     		ID_Object = OLD.ID,
     		Operation_Type = "Update",
                Value_Before = OLD.Email,
                Value_After = NEW.Email;
    END IF;
    IF OLD.Display_Name!=NEW.Display_Name THEN
    	INSERT INTO Logs 
    	SET Object_Type = 'Users',
        	Object_Field = 'Display_Name',
     		ID_Object = OLD.ID,
     		Operation_Type = "Update",
                Value_Before = OLD.Display_Name,
                Value_After = NEW.Display_Name;
    END IF;
     
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `Users_with_Ranks`
--
CREATE TABLE IF NOT EXISTS `Users_with_Ranks` (
`User_ID` int(11)
,`User_Login` varchar(64)
,`User_DisplayName` varchar(20)
,`User_Email` varchar(50)
,`User_Lastlog` timestamp
,`User_Registry` timestamp
,`User_Rank` varchar(30)
);
-- --------------------------------------------------------

--
-- Struktura widoku `Users_with_Ranks`
--
DROP TABLE IF EXISTS `Users_with_Ranks`;

CREATE ALGORITHM=UNDEFINED DEFINER=`virt101443_cms`@`localhost` SQL SECURITY DEFINER VIEW `Users_with_Ranks` AS select `Users`.`ID` AS `User_ID`,`Users`.`Login` AS `User_Login`,`Users`.`Display_Name` AS `User_DisplayName`,`Users`.`Email` AS `User_Email`,`Users`.`Lastlog_Date` AS `User_Lastlog`,`Users`.`Registry_Date` AS `User_Registry`,`Ranks`.`Name` AS `User_Rank` from (`Users` join `Ranks` on((`Users`.`ID_Rank` = `Ranks`.`ID`)));

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Articles`
--
ALTER TABLE `Articles`
  ADD CONSTRAINT `Articles_ibfk_1` FOREIGN KEY (`ID_Author`) REFERENCES `Users` (`ID`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `Coords`
--
ALTER TABLE `Coords`
  ADD CONSTRAINT `Coords_ibfk_1` FOREIGN KEY (`ID_Coords`) REFERENCES `Maps` (`ID`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `Galleries`
--
ALTER TABLE `Galleries`
  ADD CONSTRAINT `Galleries_ibfk_1` FOREIGN KEY (`ID_Author`) REFERENCES `Users` (`ID`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `inGallery`
--
ALTER TABLE `inGallery`
  ADD CONSTRAINT `inGallery_ibfk_2` FOREIGN KEY (`ID_Gallery`) REFERENCES `Galleries` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `inGallery_ibfk_1` FOREIGN KEY (`ID_Photo`) REFERENCES `Photos` (`ID`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `Maps`
--
ALTER TABLE `Maps`
  ADD CONSTRAINT `fk_id_author` FOREIGN KEY (`ID_Author`) REFERENCES `Users` (`ID`);

--
-- Ograniczenia dla tabeli `Predefined_Areas`
--
ALTER TABLE `Predefined_Areas`
  ADD CONSTRAINT `Predefined_Areas_ibfk_1` FOREIGN KEY (`ID_Template`) REFERENCES `Templates` (`ID`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `Ranks`
--
ALTER TABLE `Ranks`
  ADD CONSTRAINT `Ranks_ibfk_1` FOREIGN KEY (`ID_Privilages`) REFERENCES `Privilages` (`ID`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `Tasks`
--
ALTER TABLE `Tasks`
  ADD CONSTRAINT `Tasks_ibfk_1` FOREIGN KEY (`ID_Author`) REFERENCES `Users` (`ID`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `Templates`
--
ALTER TABLE `Templates`
  ADD CONSTRAINT `Templates_ibfk_1` FOREIGN KEY (`ID_Creator`) REFERENCES `Users` (`ID`) ON UPDATE CASCADE;

DELIMITER $$
--
-- Zdarzenia
--
CREATE DEFINER=`virt101443_cms`@`localhost` EVENT `Clear sessions` ON SCHEDULE EVERY 5 MINUTE STARTS '2014-12-08 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM Sessions$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
