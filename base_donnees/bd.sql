-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: hegolagunak
-- ------------------------------------------------------
-- Server version       8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `formulaire`
--

DROP TABLE IF EXISTS `formulaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `formulaire` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TYPEASSOS` enum('auto','1','2') DEFAULT NULL,
  `DATE_DEBUT` date DEFAULT NULL,
  `DATE_FINAL` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formulaire`
--

LOCK TABLES `formulaire` WRITE;
/*!40000 ALTER TABLE `formulaire` DISABLE KEYS */;
INSERT INTO `formulaire` VALUES (1,'auto','2022-12-27','2022-12-30');
/*!40000 ALTER TABLE `formulaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parrainer`
--

DROP TABLE IF EXISTS `parrainer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parrainer` (
  `LOGIN_PARRAIN` varchar(64) NOT NULL,
  `LOGIN_FILLEUL` varchar(64) NOT NULL,
  PRIMARY KEY (`LOGIN_PARRAIN`,`LOGIN_FILLEUL`),
  KEY `LOGIN_FILLEUL` (`LOGIN_FILLEUL`),
  CONSTRAINT `parrainer_ibfk_1` FOREIGN KEY (`LOGIN_PARRAIN`) REFERENCES `utilisateur` (`LOGIN`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `parrainer_ibfk_2` FOREIGN KEY (`LOGIN_FILLEUL`) REFERENCES `utilisateur` (`LOGIN`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parrainer`
--

LOCK TABLES `parrainer` WRITE;
/*!40000 ALTER TABLE `parrainer` DISABLE KEYS */;
/*!40000 ALTER TABLE `parrainer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proposition`
--

DROP TABLE IF EXISTS `proposition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proposition` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TEXTE` varchar(500) NOT NULL,
  `COULEUR` varchar(7) DEFAULT '#808080',
  `ID_QUESTION` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_QUESTION` (`ID_QUESTION`),
  CONSTRAINT `proposition_ibfk_1` FOREIGN KEY (`ID_QUESTION`) REFERENCES `question` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposition`
--

LOCK TABLES `proposition` WRITE;
/*!40000 ALTER TABLE `proposition` DISABLE KEYS */;
INSERT INTO `proposition` VALUES (1,'BIEN','#008000',1),(2,'MAL','#FF0000',1),(3,'UN','#808080',3),(4,'DEUX','#808080',3);
/*!40000 ALTER TABLE `proposition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `INTITULE` varchar(50) NOT NULL,
  `ID_FORMULAIRE` int DEFAULT NULL,
  `IMAGE` varchar(260) DEFAULT '..\\sources\\images\\imgplaceholder.jpg',
  `VISIBILITE` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '''all''',
  `TYPEQUESTION` enum('QCM','LIBRE') DEFAULT NULL,
  `NBREPONSE` int DEFAULT '1',
  `NBCARACTEREMAX` int DEFAULT '255',
  PRIMARY KEY (`ID`),
  KEY `ID_FORMULAIRE` (`ID_FORMULAIRE`),
  CONSTRAINT `question_ibfk_1` FOREIGN KEY (`ID_FORMULAIRE`) REFERENCES `formulaire` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,'Comment ça va ?',1,'..\\sources\\images\\imgplaceholder.jpg','all','QCM',0,255),(2,'Racontez votre vie',1,'..\\sources\\images\\imgplaceholder.jpg','2','LIBRE',1,356),(3,'Vous avez combien de chat ?',1,'..\\sources\\images\\imgplaceholder.jpg','all','QCM',2,255);
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repondre`
--

DROP TABLE IF EXISTS `repondre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `repondre` (
  `ID_QUESTION` int NOT NULL,
  `LOGIN` varchar(64) NOT NULL,
  `REPONSE` varchar(500) NOT NULL,
  PRIMARY KEY (`ID_QUESTION`,`LOGIN`),
  KEY `LOGIN` (`LOGIN`),
  CONSTRAINT `repondre_ibfk_1` FOREIGN KEY (`ID_QUESTION`) REFERENCES `question` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `repondre_ibfk_2` FOREIGN KEY (`LOGIN`) REFERENCES `utilisateur` (`LOGIN`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repondre`
--

LOCK TABLES `repondre` WRITE;
/*!40000 ALTER TABLE `repondre` DISABLE KEYS */;
/*!40000 ALTER TABLE `repondre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilisateur` (
  `LOGIN` varchar(64) NOT NULL,
  `NOM` varchar(64) DEFAULT NULL,
  `PRENOM` varchar(64) DEFAULT NULL,
  `PASSWORD` varchar(64) DEFAULT NULL,
  `ROLE` enum('admin','user') DEFAULT 'user',
  `NIVEAU` int DEFAULT NULL,
  `VALIDE` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`LOGIN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES ('amaurice006','Maurice','Alexandre',NULL,'user',2,0),('espicka','Spicka','Evan',NULL,'user',2,0),('hegoberria',NULL,NULL,'$2y$10$Gl93xsaDRMeYum4tMFp1uu31koELgb0i4n0TxErfZuV8.oaZEx6zy','admin',NULL,1),('ndargazan001','Dargazanli','Nicolas',NULL,'user',1,0),('pdavid003','David','Pierre',NULL,'user',1,0),('tbrierre','Brierre','Titouan',NULL,'user',2,0),('user','user','user','$2y$10$nVNxkuP258oiuRhp4nZlVOsYBIihAV7A8NzwWuerPWsveqvMpQmvm','user',2,1);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-13  0:10:03