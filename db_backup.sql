-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: mobile_shop
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accessories_log`
--

DROP TABLE IF EXISTS `accessories_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accessories_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `total_price` decimal(15,2) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `accessories_log_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accessories_log`
--

LOCK TABLES `accessories_log` WRITE;
/*!40000 ALTER TABLE `accessories_log` DISABLE KEYS */;
INSERT INTO `accessories_log` VALUES (1,2,9,NULL,'used for packing','2025-02-10 15:04:49'),(2,3,7,NULL,'normally used','2025-02-10 16:32:06'),(3,5,1,NULL,'Used normally','2025-02-11 08:09:04'),(4,2,1,NULL,'used normally','2025-02-11 09:21:22'),(5,2,10,NULL,'used in packing the memories','2025-02-15 10:25:23'),(6,2,20,94.00,'Used in the packing of memories and pin drives','2025-02-15 10:39:26'),(7,2,1,4.70,'Used suddenly in shoping','2025-02-15 10:52:45'),(8,2,50,250.00,'used in packing','2025-02-19 10:26:42'),(9,41,100,0.00,'','2025-02-20 09:07:10'),(10,43,100,30.00,'','2025-02-25 15:09:02'),(11,43,100,30.00,'used in packing','2025-02-25 15:41:20'),(12,46,100,500.00,'','2025-02-25 17:00:42'),(13,47,100,40.00,'','2025-02-25 17:00:51'),(15,48,100,300.00,'','2025-02-26 15:23:12'),(16,48,100,300.00,'100 were packed.','2025-02-26 15:24:49'),(17,2,10,120.00,'10 were packed.','2025-05-18 21:47:15');
/*!40000 ALTER TABLE `accessories_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `advance_payments`
--

DROP TABLE IF EXISTS `advance_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advance_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `advance_payments_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advance_payments`
--

LOCK TABLES `advance_payments` WRITE;
/*!40000 ALTER TABLE `advance_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `advance_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `annual_expenses`
--

DROP TABLE IF EXISTS `annual_expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `annual_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annual_expenses`
--

LOCK TABLES `annual_expenses` WRITE;
/*!40000 ALTER TABLE `annual_expenses` DISABLE KEYS */;
INSERT INTO `annual_expenses` VALUES (5,'Permission refreshment',20000.00,'2025'),(6,'tax',5000.00,'2025'),(7,'tax',10000.00,'2025');
/*!40000 ALTER TABLE `annual_expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `annual_profits`
--

DROP TABLE IF EXISTS `annual_profits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `annual_profits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` year(4) NOT NULL,
  `total_net_profit` decimal(10,2) DEFAULT NULL,
  `annual_loss` decimal(10,2) DEFAULT NULL,
  `annual_net_profit` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `year` (`year`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annual_profits`
--

LOCK TABLES `annual_profits` WRITE;
/*!40000 ALTER TABLE `annual_profits` DISABLE KEYS */;
INSERT INTO `annual_profits` VALUES (3,2025,1264.49,274114.62,-272850.13);
/*!40000 ALTER TABLE `annual_profits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `capital_history`
--

DROP TABLE IF EXISTS `capital_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `capital_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `initial_capital` decimal(15,2) NOT NULL,
  `total_profit` decimal(15,2) NOT NULL,
  `total_loss` decimal(15,2) NOT NULL,
  `net_capital` decimal(15,2) GENERATED ALWAYS AS (`total_profit` - `total_loss`) STORED,
  `current_capital` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capital_history`
--

LOCK TABLES `capital_history` WRITE;
/*!40000 ALTER TABLE `capital_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `capital_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cash_in_bank_log`
--

DROP TABLE IF EXISTS `cash_in_bank_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cash_in_bank_log` (
  `id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `add_sub` enum('add','sub') NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cash_in_bank_log`
--

LOCK TABLES `cash_in_bank_log` WRITE;
/*!40000 ALTER TABLE `cash_in_bank_log` DISABLE KEYS */;
INSERT INTO `cash_in_bank_log` VALUES (0,100.00,'add','2025-02-20 11:36:55'),(0,50.00,'sub','2025-02-20 11:37:49'),(0,100.00,'add','2025-02-20 11:38:06'),(0,40.00,'add','2025-02-20 11:41:01'),(0,20.00,'sub','2025-02-20 11:41:35'),(0,500.00,'add','2025-02-20 12:37:15'),(0,100.00,'add','2025-02-20 12:41:55'),(0,300.00,'sub','2025-02-20 12:45:10'),(0,5000.00,'add','2025-02-20 12:45:20');
/*!40000 ALTER TABLE `cash_in_bank_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cash_log`
--

DROP TABLE IF EXISTS `cash_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cash_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) NOT NULL,
  `add_sub` enum('add','sub') NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cash_log`
--

LOCK TABLES `cash_log` WRITE;
/*!40000 ALTER TABLE `cash_log` DISABLE KEYS */;
INSERT INTO `cash_log` VALUES (1,100.00,'add','2025-02-13 12:12:26'),(2,200.00,'add','2025-02-14 11:13:32'),(3,100.00,'add','2025-02-14 11:13:49'),(4,100.00,'add','2025-02-15 04:04:19'),(5,100.00,'add','2025-02-15 04:04:53'),(6,200.00,'sub','2025-02-15 04:28:55'),(7,50.00,'add','2025-02-15 04:33:49'),(8,30.00,'sub','2025-02-15 04:35:33'),(9,200.00,'add','2025-02-15 04:36:31'),(10,100.00,'sub','2025-02-15 04:44:51'),(11,50.00,'sub','2025-02-15 04:45:23'),(12,150.00,'add','2025-02-15 04:46:55'),(13,20.00,'add','2025-02-15 04:48:01'),(14,30.00,'add','2025-02-15 04:49:25'),(15,50.00,'add','2025-02-15 04:51:55'),(16,100.00,'add','2025-02-15 04:52:19'),(17,50.00,'sub','2025-02-15 04:54:20'),(18,20.00,'sub','2025-02-15 04:54:39'),(19,25.00,'sub','2025-02-15 04:57:01'),(20,100.00,'sub','2025-02-15 05:25:00'),(21,100.00,'sub','2025-02-15 05:27:15'),(22,5.30,'add','2025-02-15 05:40:28'),(23,550.00,'sub','2025-02-16 07:27:47'),(24,200.00,'add','2025-02-25 12:50:34'),(25,200.00,'add','2025-02-25 12:51:44');
/*!40000 ALTER TABLE `cash_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rate` decimal(10,4) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (1,75.5000,'2025-01-30 00:00:00',NULL),(2,76.8000,'2025-01-31 00:00:00',NULL),(3,75.1000,'2025-02-01 00:00:00',NULL),(4,75.2000,'2025-02-02 00:00:00',NULL),(10,75.2000,'2025-02-02 00:00:00',NULL),(11,74.7000,'2025-02-04 00:00:00',NULL),(12,75.0000,'2025-02-05 00:00:00',NULL),(13,74.5000,'2025-02-05 08:18:40',NULL),(16,76.5000,'2025-02-06 15:16:58',NULL),(18,77.4000,'2025-02-08 05:31:03',NULL),(20,75.0000,'2025-02-09 06:36:20',NULL),(21,74.3000,'2025-02-09 12:31:20',NULL),(23,74.0000,'2025-02-09 17:24:29',NULL),(24,75.2000,'2025-02-10 08:37:25',NULL),(25,74.6000,'2025-02-11 05:47:19',NULL),(26,74.3000,'2025-02-11 06:35:32',NULL),(27,73.6000,'2025-02-13 08:48:27',NULL),(28,74.3000,'2025-02-15 05:06:13',NULL),(29,75.1000,'2025-02-18 12:30:11','shershah'),(30,75.2000,'2025-02-18 12:31:25','shershah'),(31,74.5000,'2025-02-20 11:28:11','shahid'),(32,73.6000,'2025-02-22 06:27:23','shahid'),(33,73.9000,'2025-02-23 13:17:06','shahid'),(34,74.3000,'2025-02-25 09:01:29','shershah'),(35,75.0000,'2025-04-06 09:35:20','shahid'),(36,74.3000,'2025-04-21 09:24:36','shahid'),(37,75.3500,'2025-05-18 19:05:09','shahid');
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_loans`
--

DROP TABLE IF EXISTS `customer_loans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_loans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `sale_id` (`sale_id`),
  CONSTRAINT `customer_loans_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `customer_loans_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_loans`
--

LOCK TABLES `customer_loans` WRITE;
/*!40000 ALTER TABLE `customer_loans` DISABLE KEYS */;
INSERT INTO `customer_loans` VALUES (3,2,51,'2025-01-28 10:19:05','2025-01-28 10:19:05'),(4,14,53,'2025-01-29 04:06:18','2025-01-29 04:06:18'),(5,1,70,'2025-02-02 06:54:40','2025-02-02 06:54:40'),(7,1,91,'2025-02-04 05:07:15','2025-02-04 05:07:15'),(8,2,99,'2025-02-11 07:52:46','2025-02-11 07:52:46'),(9,1,106,'2025-02-11 08:26:05','2025-02-11 08:26:05'),(10,16,111,'2025-02-13 04:36:22','2025-02-13 04:36:22'),(11,16,112,'2025-02-13 04:36:48','2025-02-13 04:36:48'),(12,2,116,'2025-02-15 04:58:35','2025-02-15 04:58:35'),(13,5,126,'2025-02-15 05:28:01','2025-02-15 05:28:01'),(14,1,130,'2025-02-17 06:12:36','2025-02-17 06:12:36'),(15,17,137,'2025-02-24 05:35:50','2025-02-24 05:35:50'),(16,18,138,'2025-02-24 05:39:17','2025-02-24 05:39:17'),(17,18,139,'2025-02-24 05:40:21','2025-02-24 05:40:21'),(18,18,140,'2025-02-24 07:00:27','2025-02-24 07:00:27'),(20,18,142,'2025-02-24 07:05:25','2025-02-24 07:05:25'),(21,18,143,'2025-02-24 07:07:30','2025-02-24 07:07:30'),(22,18,144,'2025-02-24 07:08:32','2025-02-24 07:08:32'),(23,1,145,'2025-02-24 07:10:16','2025-02-24 07:10:16'),(24,5,146,'2025-02-24 07:10:48','2025-02-24 07:10:48'),(25,1,147,'2025-02-24 07:13:13','2025-02-24 07:13:13');
/*!40000 ALTER TABLE `customer_loans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_loans_log`
--

DROP TABLE IF EXISTS `customer_loans_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_loans_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `repay_lend` enum('repay','lend') NOT NULL DEFAULT 'lend',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `sale_id` (`sale_id`),
  CONSTRAINT `customer_loans_log_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `customer_loans_log_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_loans_log`
--

LOCK TABLES `customer_loans_log` WRITE;
/*!40000 ALTER TABLE `customer_loans_log` DISABLE KEYS */;
INSERT INTO `customer_loans_log` VALUES (1,2,NULL,120.00,'lend','2025-02-02 15:51:19',NULL),(2,2,NULL,940.00,'lend','2025-02-02 15:52:34',NULL),(3,2,NULL,940.00,'lend','2025-02-02 15:53:14',NULL),(4,2,NULL,940.00,'lend','2025-02-02 15:55:42',NULL),(5,2,NULL,250.00,'lend','2025-02-02 15:58:55',NULL),(6,2,NULL,220.00,'lend','2025-02-02 16:00:35',NULL),(7,2,NULL,25.00,'lend','2025-02-02 16:01:42',NULL),(8,2,NULL,300.00,'lend','2025-02-02 16:05:45',NULL),(9,2,NULL,200.00,'lend','2025-02-02 16:06:47',NULL),(10,2,NULL,200.00,'lend','2025-02-02 16:07:30',NULL),(11,2,NULL,200.00,'lend','2025-02-02 16:12:15',NULL),(12,2,NULL,100.00,'lend','2025-02-02 16:13:27',NULL),(13,2,NULL,150.00,'lend','2025-02-02 16:14:20',NULL),(14,2,NULL,200.00,'lend','2025-02-02 16:15:11',NULL),(15,2,NULL,240.00,'lend','2025-02-02 16:15:38',NULL),(16,2,NULL,210.00,'lend','2025-02-02 16:20:29',NULL),(17,2,NULL,200.00,'lend','2025-02-03 09:02:09',NULL),(18,1,NULL,1200.00,'lend','2025-02-04 05:08:09',NULL),(19,2,NULL,100.00,'lend','2025-02-12 11:37:56',NULL),(20,2,NULL,150.00,'lend','2025-02-12 11:38:41',NULL),(21,16,NULL,200.00,'lend','2025-02-13 04:37:23',NULL),(22,16,NULL,300.00,'lend','2025-02-13 13:04:37',NULL),(23,16,NULL,200.00,'lend','2025-02-19 04:11:06','ehsanullah'),(24,18,NULL,7200.00,'lend','2025-02-24 07:25:57','shahid'),(25,19,NULL,2000.00,'lend','2025-02-24 07:47:33','shahid'),(26,18,NULL,200.00,'lend','2025-02-24 07:50:22','shahid'),(27,1,NULL,1115.00,'lend','2025-02-24 07:54:30','shahid'),(28,20,NULL,5000.00,'lend','2025-02-24 07:58:21','shahid'),(29,19,NULL,3000.00,'lend','2025-02-25 12:41:47','shahid'),(30,16,NULL,5500.00,'lend','2025-03-08 07:59:34','shahid'),(31,16,NULL,8000.00,'lend','2025-03-08 07:59:40','shahid'),(32,17,NULL,2000.00,'repay','2025-03-08 07:59:57','shahid'),(33,17,NULL,10000.00,'lend','2025-03-08 08:00:11','shahid'),(34,18,NULL,15500.00,'lend','2025-03-08 08:00:26','shahid'),(35,18,NULL,1000.00,'repay','2025-03-08 08:00:34','shahid'),(36,23,NULL,10000.00,'lend','2025-03-08 08:02:46','shahid'),(37,23,NULL,3000.00,'repay','2025-03-08 08:02:52','shahid'),(38,6,NULL,10.00,'repay','2025-05-18 17:40:52','shahid');
/*!40000 ALTER TABLE `customer_loans_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `loan` decimal(10,2) DEFAULT 0.00,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Ahmad',0.00,NULL,NULL,'2025-01-28 04:27:34','2025-02-24 07:54:30',NULL),(2,'Wali',-4085.00,NULL,NULL,'2025-01-28 04:39:36','2025-02-24 07:47:33',NULL),(3,'Ali',-19585.00,NULL,NULL,'2025-01-28 04:39:40','2025-02-24 07:47:33',NULL),(4,'Mohammad',-19585.00,NULL,NULL,'2025-01-28 04:39:44','2025-02-24 07:47:33',NULL),(5,'Akram',-17135.00,NULL,NULL,'2025-01-28 04:39:51','2025-02-24 07:47:33',NULL),(6,'Shah mahmod',-19595.00,NULL,NULL,'2025-01-28 05:28:05','2025-05-18 17:40:52',NULL),(8,'Mahmud',-19585.00,NULL,NULL,'2025-01-28 05:29:51','2025-02-24 07:47:33',NULL),(9,'Basheer',-19585.00,NULL,NULL,'2025-01-28 05:31:01','2025-02-24 07:47:33',NULL),(10,'Bakhtyar',-19585.00,NULL,NULL,'2025-01-28 05:46:53','2025-02-24 07:47:33',NULL),(11,'Gul khan',-19585.00,NULL,NULL,'2025-01-28 05:48:32','2025-02-24 07:47:33',NULL),(12,'Jan',-19585.00,NULL,NULL,'2025-01-28 05:52:50','2025-02-24 07:47:33',NULL),(13,'Niamatullah',-19585.00,NULL,NULL,'2025-01-28 06:35:08','2025-02-24 07:47:33',NULL),(14,'hashmat',-17835.00,NULL,NULL,'2025-01-29 04:02:34','2025-02-24 07:47:33',NULL),(15,'Hejratullah',-10350.00,NULL,NULL,'2025-02-12 10:47:10','2025-02-24 07:47:33',NULL),(16,'Ezatullah',4800.00,'077506044','Karte naw, kabul afghanistan','2025-02-12 12:41:55','2025-03-08 07:59:40',NULL),(17,'Ghulam sakhi',7800.00,'0767495649','Baghlan, Afghanistan','2025-02-18 12:49:16','2025-03-08 08:00:11','shershah'),(18,'Wali mohammad',12300.00,'0768593574','Ghazni, Afghanistan','2025-02-24 05:38:37','2025-03-08 08:00:34','shahid'),(19,'Noor Ahmed',60000.00,'0784738567','Kabul, Afghanistan','2025-02-24 07:46:27','2025-02-25 12:41:46','shahid'),(20,'Rizwan',0.00,'0748856395','Peshawer, Pakistan','2025-02-24 07:57:37','2025-02-24 07:58:21','shahid'),(23,'Mohammed Akbar',7000.00,'0775 870 659','Logar, Afghanistan','2025-03-08 08:02:04','2025-03-08 08:02:52','shahid');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_expenses`
--

DROP TABLE IF EXISTS `daily_expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `daily_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_expenses`
--

LOCK TABLES `daily_expenses` WRITE;
/*!40000 ALTER TABLE `daily_expenses` DISABLE KEYS */;
INSERT INTO `daily_expenses` VALUES (1,'Lunch',350.00,'2025-01-30'),(2,'car rent',100.00,'2025-01-30'),(3,'cold drinks',70.00,'2025-01-30'),(4,'lunch',250.00,'2025-02-01'),(5,'car rent',100.00,'2025-02-01'),(6,'lunch 5 bargurs',400.00,'2025-02-02'),(7,'Energy for guest',30.00,'2025-02-04'),(8,'lunch',300.00,'2025-02-04'),(9,'car rent',100.00,'2025-02-04'),(10,'juice',50.00,'2025-02-04'),(11,'juice',50.00,'2025-02-04'),(12,'juice',50.00,'2025-02-04'),(13,'juice',50.00,'2025-02-04'),(14,'juice',50.00,'2025-02-04'),(15,'juice',50.00,'2025-02-04'),(16,'juice',50.00,'2025-02-04'),(17,'juice',50.00,'2025-02-04'),(18,'juice',50.00,'2025-02-04'),(19,'lunch',400.00,'2025-02-05'),(20,'served guest with energy',30.00,'2025-02-13'),(21,'lunch',400.00,'2025-02-15'),(22,'car rent',100.00,'2025-02-15'),(23,'guest energy',250.00,'2025-02-15'),(24,'lunch',200.00,'2025-03-01'),(25,'lunch',300.00,'2025-02-25'),(26,'lunch',300.00,'2025-02-26');
/*!40000 ALTER TABLE `daily_expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `drawer_safe_log`
--

DROP TABLE IF EXISTS `drawer_safe_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drawer_safe_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `drawer_cash` decimal(10,2) NOT NULL,
  `safe_cash` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `action` enum('drawer','safe','safeAdd','safeSub','drawerAdd','drawerSub') NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drawer_safe_log`
--

LOCK TABLES `drawer_safe_log` WRITE;
/*!40000 ALTER TABLE `drawer_safe_log` DISABLE KEYS */;
INSERT INTO `drawer_safe_log` VALUES (1,100.00,0.00,100.00,'','2025-03-02 07:40:31'),(2,50.00,0.00,50.00,'','2025-03-02 07:40:47'),(3,30.00,20.00,20.00,'safe','2025-03-02 07:41:00'),(4,130.00,20.00,100.00,'','2025-03-02 07:42:18'),(5,130.00,120.00,100.00,'','2025-03-02 07:42:50'),(6,80.00,120.00,50.00,'','2025-03-02 07:43:00'),(7,77.50,120.00,2.50,'','2025-03-02 07:43:12'),(8,67.20,130.30,10.30,'safe','2025-03-02 07:43:20'),(9,87.20,130.30,20.00,'drawerAdd','2025-03-02 07:48:11'),(10,87.20,230.30,100.00,'safeAdd','2025-03-02 07:48:25'),(11,87.20,220.30,10.00,'safeSub','2025-03-02 07:48:28'),(12,97.20,210.30,10.00,'drawer','2025-03-02 07:48:32'),(13,87.20,220.30,10.00,'safe','2025-03-02 07:48:36'),(14,77.20,230.30,10.00,'safe','2025-03-02 07:53:45'),(15,177.20,230.30,100.00,'drawerAdd','2025-03-02 07:53:49'),(16,127.20,230.30,50.00,'drawerSub','2025-03-02 07:53:55'),(17,227.20,130.30,100.00,'drawer','2025-03-02 07:54:04'),(18,227.20,230.30,100.00,'safeAdd','2025-03-02 07:54:08'),(19,227.20,208.30,22.00,'safeSub','2025-03-02 07:54:10'),(20,327.20,208.30,100.00,'drawerAdd','2025-03-02 09:14:45'),(21,377.20,208.30,50.00,'drawerAdd','2025-03-02 09:16:56'),(22,377.20,408.30,200.00,'safeAdd','2025-03-02 09:18:29'),(23,456.76,408.30,100.00,'drawerSub','2025-03-02 09:19:11'),(24,556.76,408.30,100.00,'drawerAdd','2025-05-18 17:37:21'),(25,736.52,308.30,100.00,'drawer','2025-05-18 17:37:40');
/*!40000 ALTER TABLE `drawer_safe_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_name` varchar(100) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'Ahmad Khan',16000.00),(2,'Ali',13000.00),(4,'Majeed',12000.00),(35,'Waris Kaka',11000.00);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (9,'Web_Dev_Syllabus.pdf','uploads/Web_Dev_Syllabus.pdf','2025-02-17 10:37:10'),(10,'12_Rules_to_Learn_to_Code__2nd_Edition__2022.pdf','uploads/12_Rules_to_Learn_to_Code__2nd_Edition__2022.pdf','2025-02-17 10:37:23'),(11,'AppBreweryCornellNotesTemplate.pdf','uploads/AppBreweryCornellNotesTemplate.pdf','2025-02-25 12:46:01'),(12,'111.pdf','uploads/111.pdf','2025-05-18 17:39:02');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monthly_expenses`
--

DROP TABLE IF EXISTS `monthly_expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `monthly_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monthly_expenses`
--

LOCK TABLES `monthly_expenses` WRITE;
/*!40000 ALTER TABLE `monthly_expenses` DISABLE KEYS */;
INSERT INTO `monthly_expenses` VALUES (1,'electricity bill',10000.00,'2025-02'),(2,'shop rent',30000.00,'2025-02'),(3,'ele',10000.00,'2025-02');
/*!40000 ALTER TABLE `monthly_expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monthly_profits`
--

DROP TABLE IF EXISTS `monthly_profits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `monthly_profits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month` varchar(7) NOT NULL,
  `total_net_profit` decimal(10,2) DEFAULT NULL,
  `monthly_loss` decimal(10,2) DEFAULT NULL,
  `monthly_net_profit` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `month` (`month`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monthly_profits`
--

LOCK TABLES `monthly_profits` WRITE;
/*!40000 ALTER TABLE `monthly_profits` DISABLE KEYS */;
INSERT INTO `monthly_profits` VALUES (2,'2025-02',1764.17,955.59,808.58),(61,'2025-03',5.08,0.00,5.08),(63,'2025-05',450.83,0.00,450.83);
/*!40000 ALTER TABLE `monthly_profits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `warehouse` int(11) DEFAULT 0,
  `current_price` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_purchase` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (2,'Apple watch','apple watch 2025',281,550,12.00,'2025-01-15 12:56:36','2025-05-21 07:08:20','2025-02-19 10:25:25'),(3,'air phones','white airpads',382,50,7.00,'2025-01-15 16:06:48','2025-05-18 17:27:27','2025-02-20 09:21:07'),(4,'telephone',NULL,242,0,12.00,'2025-01-15 16:10:17','2025-02-10 12:30:57','2025-02-10 17:00:57'),(5,'music pad',NULL,78,0,70.00,'2025-01-15 16:27:03','2025-02-11 03:39:04','2025-02-01 14:01:40'),(6,'video pad',NULL,415,0,74.00,'2025-01-15 16:27:32','2025-02-01 10:53:37','2025-02-01 14:01:49'),(7,'display',NULL,668,0,38.00,'2025-01-15 16:28:03','2025-02-01 10:53:37','2025-02-01 14:02:00'),(8,'car plate','something',428,0,120.00,'2025-01-15 16:30:43','2025-02-01 09:32:08','2025-02-01 14:02:08'),(9,'samsung galaxy s9+',NULL,85,0,78.00,'2025-01-18 02:27:26','2025-02-01 10:53:37','2025-02-01 14:02:21'),(10,'iPhone 8',NULL,65,0,120.00,'2025-01-18 02:40:52','2025-02-01 09:37:23','2025-02-01 14:07:23'),(11,'Air pads pro 2','White air pads pro 2',1595,0,70.00,'2025-01-18 14:53:55','2025-02-01 10:53:37','2025-02-01 14:02:43'),(12,'Samsung watch',NULL,114,0,25.00,'2025-01-18 14:55:51','2025-02-01 09:32:58','2025-02-01 14:02:58'),(13,'sandisk 32 gb memory cards','sandsik memory',720,0,3.00,'2025-01-18 16:12:15','2025-02-01 09:33:17','2025-02-01 14:03:17'),(14,'hp 64 gb falsh','hp flash',365,0,7.00,'2025-01-18 17:06:44','2025-02-01 10:49:52','2025-02-01 14:03:29'),(15,'hp Ù…ÛŒÙ…ÙˆØ±ÛŒ Û³Û² Ø¬ÛŒ Ø¨ÛŒ ',NULL,25,0,12.00,'2025-01-19 10:19:44','2025-02-01 10:53:37','2025-02-01 14:07:36'),(16,'Ù…ÛŒÙ…ÙˆØ±ÛŒ Ú©Ø§Ø±Øª Û±Û¶ Ø¬ÛŒ Ø¨ÛŒ','Û±Û¶ Ø¬ÛŒ Ø¨ÛŒ Ù…ÛŒÙ…ÙˆØ±ÛŒ',12,0,5.00,'2025-01-20 10:19:41','2025-05-18 17:26:06','2025-02-01 14:06:38'),(17,'Mouse','Computer mouses',287,0,3.50,'2025-01-23 09:53:23','2025-02-01 10:53:37','2025-02-01 14:06:27'),(18,'keyboard',NULL,220,0,8.00,'2025-01-23 10:21:35','2025-02-01 10:53:37','2025-02-01 14:06:18'),(19,'35W Charger',NULL,345,0,3.00,'2025-01-23 12:26:37','2025-02-01 10:53:37','2025-02-01 14:05:32'),(20,'laptop',NULL,562,0,150.00,'2025-01-24 11:09:11','2025-02-01 09:35:14','2025-02-01 14:05:14'),(21,'Type-C cables','USB type-c black cables',120,0,2.50,'2025-01-24 12:05:57','2025-02-01 09:38:03','2025-02-01 14:08:03'),(22,'ÙÙ„Ø´ Û² Ø¬ÛŒ Ø¨ÛŒ','2 gb pin drive',220,0,25.00,'2025-01-24 12:37:16','2025-02-01 09:34:54','2025-02-01 14:04:54'),(23,'ÙÙ„Ø´ Û¶Û´',NULL,250,0,10.00,'2025-01-26 06:55:00','2025-02-01 09:34:35','2025-02-01 14:04:35'),(24,'iva mobile 64','iva mobile 64gb storage and 8gb RAM',500,0,20.00,'2025-01-26 11:57:01','2025-02-01 09:34:26','2025-02-01 14:04:26'),(25,'Car adapter','Car 40W adapter',409,0,150.00,'2025-01-27 05:05:33','2025-01-27 06:27:03',NULL),(26,'Phone case','iOS 10 phone case',620,0,40.00,'2025-01-27 06:28:43','2025-01-27 06:30:01',NULL),(27,'wired airpads',NULL,710,0,60.00,'2025-01-27 06:47:43','2025-01-27 06:49:17',NULL),(28,'HP flash',NULL,635,0,70.00,'2025-01-29 03:43:15','2025-01-29 06:19:55','2025-01-29 10:49:55'),(29,'airpads pro 3',NULL,70,0,12.00,'2025-02-01 04:23:57','2025-02-01 04:34:17','2025-02-01 08:54:18'),(30,'Smart watch v1',NULL,218,0,20.00,'2025-02-01 07:40:06','2025-02-01 10:49:52','2025-02-01 12:10:22'),(31,' Bluetooth mouse',NULL,500,0,5.00,'2025-02-01 14:37:46','2025-02-01 14:38:41','2025-02-01 19:08:41'),(32,'128 GB memory',NULL,0,0,0.00,'2025-02-10 07:51:36','2025-02-10 07:51:36',NULL),(33,'256 GB Memory card','HP 256 GB memory',0,0,0.00,'2025-02-10 07:59:27','2025-02-10 07:59:27',NULL),(34,'64 gb flash',NULL,0,0,0.00,'2025-02-10 08:00:04','2025-02-10 08:00:04',NULL),(35,'2 GB memory samsung','2 gb samsung memory',0,0,0.00,'2025-02-11 04:48:25','2025-02-11 04:48:25',NULL),(36,'4 GB Samsung Memory',NULL,0,0,0.00,'2025-02-11 04:50:29','2025-02-11 04:50:29',NULL),(37,'8 GB samsung memory',NULL,0,0,0.00,'2025-02-11 04:50:48','2025-02-11 04:50:48',NULL),(38,'128 GB SanDisk Memory card',NULL,269,0,7.00,'2025-02-12 05:13:51','2025-02-12 07:24:13','2025-02-12 09:44:17'),(39,'120 W charger',NULL,410,0,4.00,'2025-02-12 08:26:19','2025-02-12 09:35:40','2025-02-12 12:56:33'),(40,'40k power bank','40k wired power bank',0,900,20.00,'2025-02-19 05:44:47','2025-02-19 05:49:57','2025-02-19 10:19:57'),(41,'OTG USB 3.0','USB 3',-100,0,0.00,'2025-02-20 04:36:39','2025-02-20 04:37:10',NULL),(42,'HP 64GB',NULL,20,80,2.50,'2025-02-25 08:08:42','2025-02-25 10:37:11','2025-02-25 15:06:17'),(43,'Flash Acccessories',NULL,100,100,0.30,'2025-02-25 10:37:52','2025-02-25 11:11:20','2025-02-25 15:08:11'),(44,'32GB Flash',NULL,0,200,1.30,'2025-02-25 10:44:37','2025-02-25 10:46:54','2025-02-25 15:16:54'),(45,'128 Flash',NULL,300,100,2.70,'2025-02-25 11:09:18','2025-02-25 11:13:33','2025-02-25 15:39:35'),(46,'UDP 128',NULL,300,0,2.70,'2025-02-25 12:28:08','2025-02-26 10:54:49','2025-02-26 15:09:16'),(47,'Accessories 128',NULL,300,0,0.30,'2025-02-25 12:28:54','2025-02-26 10:54:49','2025-02-26 15:09:29'),(48,'128 Flash',NULL,200,0,3.00,'2025-02-25 12:30:17','2025-02-26 10:54:49',NULL),(49,'Yosonda 30k',NULL,1,11,925.00,'2025-02-27 04:17:34','2025-02-27 04:18:46','2025-02-27 08:48:46'),(50,'1TB SSD','1 Terabyte SSD',0,0,0.00,'2025-05-18 17:13:15','2025-05-18 17:13:15',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profits`
--

DROP TABLE IF EXISTS `profits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `gross_profit` decimal(10,2) DEFAULT NULL,
  `loss` decimal(10,2) DEFAULT NULL,
  `net_profit` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profits`
--

LOCK TABLES `profits` WRITE;
/*!40000 ALTER TABLE `profits` DISABLE KEYS */;
INSERT INTO `profits` VALUES (1,'2025-02-02',337.12,400.00,-62.88),(12,'2025-02-04',50.74,11.84,38.90),(21,'2025-02-05',0.00,5.37,-5.37),(22,'2025-02-11',35.24,0.00,35.24),(30,'2025-02-12',570.02,0.00,570.02),(34,'2025-02-13',33.41,0.40,33.01),(37,'2025-02-14',1.69,0.00,1.69),(38,'2025-02-15',47.82,108.79,-60.97),(56,'2025-02-16',12.18,0.00,12.18),(64,'2025-02-17',1751.79,0.00,1751.79),(73,'2025-02-18',11.04,0.00,11.04),(76,'2025-02-19',82.45,250.00,-167.55),(78,'2025-02-20',0.00,0.00,0.00),(82,'2025-02-21',17.11,0.00,17.11),(83,'2025-02-23',1.79,0.00,1.79),(84,'2025-02-24',104.22,0.00,104.22),(100,'2025-02-25',83.58,604.04,-520.46),(111,'2025-02-26',8.45,4.04,4.41),(114,'2025-03-08',5.08,0.00,5.08),(116,'2025-05-18',504.47,0.00,504.47),(120,'2025-05-21',-53.64,0.00,-53.64);
/*!40000 ALTER TABLE `profits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) GENERATED ALWAYS AS (`price` * `quantity`) STORED,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
INSERT INTO `purchases` VALUES (1,2,500,2500.00,1250000.00,'2025-01-18 15:44:56'),(2,13,545,270.00,147150.00,'2025-01-18 16:13:06'),(3,4,20,6700.00,134000.00,'2025-01-19 04:17:58'),(4,7,12,1650.00,19800.00,'2025-01-19 07:07:02'),(5,2,20,53.00,1060.00,'2025-01-19 07:54:24'),(6,15,10,57.00,570.00,'2025-01-19 10:20:14'),(7,16,100,50.00,5000.00,'2025-01-20 10:20:10'),(8,17,500,60.00,30000.00,'2025-01-23 09:53:49'),(9,18,100,70.00,7000.00,'2025-01-23 10:22:01'),(10,19,300,180.00,54000.00,'2025-01-23 12:27:15'),(11,6,100,2.00,200.00,'2025-01-24 02:38:04'),(12,20,50,300.00,15000.00,'2025-01-24 11:09:39'),(13,6,500,100.00,50000.00,'2025-01-26 06:54:39'),(14,4,250,100.00,25000.00,'2025-01-26 10:25:45'),(15,8,120,250.00,30000.00,'2025-01-26 10:26:45'),(16,7,225,60.00,13500.00,'2025-01-26 10:29:47'),(17,2,11,84.00,924.00,'2025-01-26 10:30:27'),(18,24,500,2700.00,1350000.00,'2025-01-26 11:57:31'),(19,25,500,150.00,75000.00,'2025-01-27 05:08:10'),(20,26,700,40.00,28000.00,'2025-01-27 06:29:01'),(21,27,750,60.00,45000.00,'2025-01-27 06:47:57'),(22,28,500,100.00,50000.00,'2025-01-29 03:44:38'),(23,28,200,70.00,14000.00,'2025-01-29 06:19:54'),(24,3,850,240.00,204000.00,'2025-01-29 07:31:52'),(25,3,200,250.00,50000.00,'2025-01-29 07:32:18'),(26,29,100,12.00,1200.00,'2025-02-01 04:24:18'),(27,30,250,20.00,5000.00,'2025-02-01 07:40:21'),(28,2,2,120.00,240.00,'2025-02-01 09:31:15'),(29,4,15,320.00,4800.00,'2025-02-01 09:31:31'),(30,5,28,70.00,1960.00,'2025-02-01 09:31:40'),(31,6,12,74.00,888.00,'2025-02-01 09:31:49'),(32,7,16,38.00,608.00,'2025-02-01 09:32:00'),(33,8,5,120.00,600.00,'2025-02-01 09:32:08'),(34,9,100,78.00,7800.00,'2025-02-01 09:32:21'),(35,10,20,320.00,6400.00,'2025-02-01 09:32:29'),(36,11,1000,70.00,70000.00,'2025-02-01 09:32:43'),(37,12,100,25.00,2500.00,'2025-02-01 09:32:58'),(38,13,250,3.00,750.00,'2025-02-01 09:33:17'),(39,14,500,7.00,3500.00,'2025-02-01 09:33:29'),(40,15,100,6.00,600.00,'2025-02-01 09:33:39'),(41,24,100,20.00,2000.00,'2025-02-01 09:34:25'),(42,23,250,10.00,2500.00,'2025-02-01 09:34:35'),(43,22,120,12.00,1440.00,'2025-02-01 09:34:44'),(44,22,100,25.00,2500.00,'2025-02-01 09:34:54'),(45,20,500,2.00,1000.00,'2025-02-01 09:35:04'),(46,20,20,150.00,3000.00,'2025-02-01 09:35:14'),(47,19,200,3.00,600.00,'2025-02-01 09:35:32'),(48,18,200,8.00,1600.00,'2025-02-01 09:36:18'),(49,17,150,3.50,525.00,'2025-02-01 09:36:27'),(50,16,20,5.00,100.00,'2025-02-01 09:36:38'),(51,10,100,120.00,12000.00,'2025-02-01 09:37:23'),(52,15,100,12.00,1200.00,'2025-02-01 09:37:36'),(53,21,120,2.50,300.00,'2025-02-01 09:38:03'),(54,31,500,5.00,2500.00,'2025-02-01 14:38:40'),(55,2,100,2.00,200.00,'2025-02-01 14:40:11'),(56,2,20,5.00,100.00,'2025-02-01 14:41:18'),(57,3,100,7.00,700.00,'2025-02-02 10:01:12'),(58,4,2,12.00,24.00,'2025-02-10 12:30:57'),(59,2,100,5.00,500.00,'2025-02-11 04:25:36'),(60,2,100,5.00,500.00,'2025-02-11 04:27:18'),(61,2,100,5.00,500.00,'2025-02-11 04:28:58'),(62,2,100,5.00,500.00,'2025-02-11 04:30:53'),(63,2,100,5.00,500.00,'2025-02-11 04:32:12'),(64,2,1,5.00,5.00,'2025-02-11 04:32:57'),(65,2,1,5.00,5.00,'2025-02-11 04:37:28'),(66,2,1,5.00,5.00,'2025-02-11 04:42:02'),(67,2,1,5.00,5.00,'2025-02-11 04:42:33'),(68,2,10,5.00,50.00,'2025-02-11 05:00:24'),(69,3,10,7.20,72.00,'2025-02-11 05:40:58'),(70,3,4,7.10,28.40,'2025-02-11 05:43:33'),(71,3,4,7.10,28.40,'2025-02-11 05:43:47'),(72,2,4,5.10,20.40,'2025-02-11 06:54:31'),(73,38,500,7.00,3500.00,'2025-02-12 05:14:17'),(74,39,500,4.00,2000.00,'2025-02-12 08:26:33'),(75,2,100,4.70,470.00,'2025-02-15 04:40:01'),(76,40,800,20.00,16000.00,'2025-02-19 05:49:14'),(77,40,100,20.00,2000.00,'2025-02-19 05:49:57'),(78,2,200,5.00,1000.00,'2025-02-19 05:51:36'),(79,2,50,5.00,250.00,'2025-02-19 05:53:21'),(80,2,100,5.00,500.00,'2025-02-19 05:55:04'),(81,2,50,5.00,250.00,'2025-02-19 05:55:25'),(82,3,100,7.00,700.00,'2025-02-20 04:51:07'),(83,42,100,2.50,250.00,'2025-02-25 10:36:17'),(84,43,500,0.30,150.00,'2025-02-25 10:38:11'),(85,44,100,13.00,1300.00,'2025-02-25 10:45:14'),(86,44,100,1.30,130.00,'2025-02-25 10:46:54'),(87,45,500,2.70,1350.00,'2025-02-25 11:09:35'),(88,46,100,5.00,500.00,'2025-02-25 12:28:24'),(89,47,100,0.40,40.00,'2025-02-25 12:29:32'),(90,46,500,2.70,1350.00,'2025-02-26 10:39:16'),(91,47,500,0.30,150.00,'2025-02-26 10:39:28'),(92,49,2,1050.00,2100.00,'2025-02-27 04:18:04'),(93,49,10,900.00,9000.00,'2025-02-27 04:18:46');
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rejected_sales`
--

DROP TABLE IF EXISTS `rejected_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rejected_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `restock_quantity` int(11) DEFAULT 0,
  `resell_quantity` int(11) DEFAULT 0,
  `resell_price` decimal(10,2) DEFAULT 0.00,
  `total_amount` decimal(10,2) GENERATED ALWAYS AS (`resell_quantity` * `resell_price`) STORED,
  `loss_per_item` decimal(10,2) DEFAULT NULL,
  `total_loss` decimal(10,2) GENERATED ALWAYS AS (`resell_quantity` * `loss_per_item`) STORED,
  `rejection_date` date NOT NULL DEFAULT curdate(),
  `sold_date` date DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`),
  KEY `product_id` (`product_id`),
  KEY `fk_rejected_sales_currency` (`currency_id`),
  CONSTRAINT `fk_rejected_sales_currency` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rejected_sales_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  CONSTRAINT `rejected_sales_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rejected_sales`
--

LOCK TABLES `rejected_sales` WRITE;
/*!40000 ALTER TABLE `rejected_sales` DISABLE KEYS */;
INSERT INTO `rejected_sales` VALUES (1,10,2,12,4,3,15.00,45.00,53.00,159.00,'2025-01-21','2025-01-20',NULL),(2,4,6,3,1,2,10.00,20.00,-10.00,-20.00,'2025-01-21','2025-01-19',NULL),(3,4,6,3,2,1,10.00,10.00,NULL,NULL,'2025-01-21','2025-01-19',NULL),(4,4,6,3,2,1,10.00,10.00,NULL,NULL,'2025-01-21','2025-01-19',NULL),(5,4,6,3,2,1,10.00,10.00,NULL,NULL,'2025-01-21','2025-01-19',NULL),(6,10,4,12,6,4,20.00,80.00,6685.00,26740.00,'2025-01-21','2025-01-20',NULL),(7,10,4,12,5,2,150.00,300.00,850.00,1700.00,'2025-01-21','2025-01-20',NULL),(8,4,10,12,3,1,1500.00,1500.00,NULL,NULL,'2025-01-21','2025-01-19',NULL),(9,12,2,115,10,5,250.00,1250.00,-197.00,-985.00,'2025-01-21','2025-01-20',NULL),(10,4,10,7,3,4,15.00,60.00,12485.00,49940.00,'2025-01-21',NULL,NULL),(11,3,5,30,11,19,20.00,380.00,230.00,4370.00,'2025-01-21',NULL,NULL),(12,6,4,10,3,7,10.00,70.00,-7.00,-49.00,'2025-01-21',NULL,NULL),(13,3,14,12,1,11,10.00,110.00,170.00,1870.00,'2025-01-21',NULL,NULL),(14,3,5,12,5,7,10.00,70.00,-10.00,-70.00,'2025-01-22',NULL,NULL),(15,3,5,12,5,7,10.00,70.00,240.00,1680.00,'2025-01-22','2025-01-19',NULL),(16,5,3,3,0,0,0.00,0.00,100.00,0.00,'2025-01-22','2025-01-19',NULL),(17,15,17,40,20,10,0.00,0.00,70.00,700.00,'2025-01-23','2025-01-23',NULL),(18,16,18,30,15,13,25.00,325.00,55.00,715.00,'2025-01-23','2025-01-23',NULL),(19,17,19,30,10,20,40.00,800.00,160.00,3200.00,'2025-01-23','2025-01-23',NULL),(20,15,17,40,10,30,10.00,300.00,60.00,1800.00,'2025-01-24','2025-01-23',NULL),(21,19,20,5,2,3,100.00,300.00,14900.00,44700.00,'2025-01-24','2025-01-24',NULL),(22,19,20,5,0,0,0.00,0.00,15000.00,0.00,'2025-01-24','2025-01-24',NULL),(23,20,2,30,10,20,10.00,200.00,690.00,13800.00,'2025-01-24','2025-01-24',NULL),(24,20,2,30,12,13,25.00,325.00,675.00,8775.00,'2025-01-24','2025-01-24',NULL),(25,14,3,50,0,0,0.00,0.00,180.00,0.00,'2025-01-24','2025-01-22',NULL),(26,2,3,3,0,0,0.00,0.00,550.00,0.00,'2025-01-24','2025-01-19',NULL),(27,2,3,3,0,0,0.00,0.00,550.00,0.00,'2025-01-24','2025-01-19',NULL),(28,2,3,3,0,0,0.00,0.00,550.00,0.00,'2025-01-24','2025-01-19',NULL),(29,5,3,2,0,2,10.00,20.00,90.00,180.00,'2025-01-26','2025-01-19',NULL),(30,7,16,10,4,6,20.00,120.00,40.00,240.00,'2025-01-26','2025-01-20',NULL),(31,36,24,50,10,40,100.00,4000.00,2700.00,108000.00,'2025-01-26','2025-01-26',NULL),(32,37,25,30,10,20,20.00,400.00,-20.00,-400.00,'2025-01-27','2025-01-27',NULL),(33,37,25,30,10,20,20.00,400.00,130.00,2600.00,'2025-01-27','2025-01-27',NULL),(34,38,25,10,4,6,23.00,138.00,127.00,762.00,'2025-01-27','2025-01-27',NULL),(35,39,26,50,20,30,23.00,690.00,17.00,510.00,'2025-01-27','2025-01-27',NULL),(36,39,26,50,0,0,0.00,0.00,40.00,0.00,'2025-01-27','2025-01-27',NULL),(37,40,27,50,20,30,13.00,390.00,47.00,1410.00,'2025-01-27','2025-01-27',NULL),(38,52,28,10,5,5,5.00,25.00,95.00,475.00,'2025-01-29','2025-01-29',NULL),(39,60,30,1,0,0,0.00,0.00,20.00,0.00,'2025-02-02','2025-02-01',10),(40,62,2,2,0,2,10.00,20.00,4.87,9.74,'2025-02-02','2025-02-01',10),(41,65,2,1,0,1,10.00,10.00,4.87,4.87,'2025-02-02','2025-02-02',10),(42,101,2,1,0,1,2.00,2.00,5.07,5.07,'2025-02-11','2025-02-11',26),(43,107,38,50,0,50,20.00,1000.00,6.73,336.50,'2025-02-12','2025-02-12',26),(44,107,38,10,5,5,25.00,125.00,6.66,33.30,'2025-02-12','2025-02-12',26),(45,107,38,20,10,10,30.00,300.00,6.60,66.00,'2025-02-12','2025-02-12',26),(46,107,38,20,10,10,30.00,300.00,6.60,66.00,'2025-02-12','2025-02-12',26),(47,108,38,50,20,30,40.00,1200.00,6.46,193.80,'2025-02-12','2025-02-12',26),(48,109,38,20,9,10,45.00,450.00,6.39,63.90,'2025-02-12','2025-02-12',26),(49,110,39,50,10,16,22.00,352.00,3.70,59.20,'2025-02-12','2025-02-12',26),(50,70,2,2,0,2,10.00,20.00,4.87,9.74,'2025-02-25','2025-02-02',34),(51,150,3,1,0,0,0.00,0.00,7.00,0.00,'2025-03-06','2025-02-24',34);
/*!40000 ALTER TABLE `rejected_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salaries`
--

DROP TABLE IF EXISTS `salaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `month` varchar(7) NOT NULL,
  `salary` decimal(15,2) DEFAULT NULL,
  `amount_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_employee_month` (`employee_id`,`month`),
  CONSTRAINT `fk_salaries_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salaries`
--

LOCK TABLES `salaries` WRITE;
/*!40000 ALTER TABLE `salaries` DISABLE KEYS */;
INSERT INTO `salaries` VALUES (23,1,'2024-12',15000.00,15000.00),(25,2,'2024-12',13000.00,13000.00),(26,4,'2024-12',12000.00,12000.00),(27,1,'2025-01',15000.00,15000.00),(29,2,'2025-01',13000.00,13000.00),(30,4,'2025-01',12000.00,12000.00),(42,1,'2025-02',16000.00,10000.00),(43,35,'2025-02',11000.00,11000.00);
/*!40000 ALTER TABLE `salaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary_log`
--

DROP TABLE IF EXISTS `salary_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salary_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `dollar_rate` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `fk_dollar_rate` (`dollar_rate`),
  CONSTRAINT `fk_dollar_rate` FOREIGN KEY (`dollar_rate`) REFERENCES `currency` (`id`),
  CONSTRAINT `salary_log_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_log`
--

LOCK TABLES `salary_log` WRITE;
/*!40000 ALTER TABLE `salary_log` DISABLE KEYS */;
INSERT INTO `salary_log` VALUES (36,1,2000.00,'2025-02-16 06:34:37',28),(37,1,13000.00,'2025-02-16 06:34:55',28),(38,2,13000.00,'2025-02-16 06:35:11',28),(39,4,12000.00,'2025-02-16 06:35:20',28),(40,1,2000.00,'2025-02-16 06:36:08',28),(41,1,13000.00,'2025-02-16 06:37:15',28),(42,2,13000.00,'2025-02-16 06:37:23',28),(43,4,12000.00,'2025-02-16 06:37:28',28),(44,1,5000.00,'2025-02-16 06:37:56',28),(45,2,100.00,'2025-02-16 06:38:03',28),(46,4,12000.00,'2025-02-16 06:38:09',28),(47,1,2000.00,'2025-02-16 07:06:57',28),(48,2,500.00,'2025-02-16 07:07:45',28),(50,1,8000.00,'2025-03-01 09:34:19',28),(51,1,1000.00,'2025-02-20 04:28:29',30),(52,2,3000.00,'2025-02-20 04:29:13',30),(53,1,10000.00,'2025-02-20 04:31:01',30),(54,35,2000.00,'2025-02-25 12:47:52',34),(55,35,9000.00,'2025-02-25 12:49:11',34);
/*!40000 ALTER TABLE `salary_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_items`
--

DROP TABLE IF EXISTS `sale_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `rejected_quantity` int(11) NOT NULL DEFAULT 0,
  `price` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) GENERATED ALWAYS AS (`price` * `quantity`) STORED,
  `total_profit` decimal(15,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_items`
--

LOCK TABLES `sale_items` WRITE;
/*!40000 ALTER TABLE `sale_items` DISABLE KEYS */;
INSERT INTO `sale_items` VALUES (1,1,2,5,0,700.00,3500.00,0.00),(2,2,3,5,9,550.00,2750.00,0.00),(3,3,5,57,54,250.00,14250.00,0.00),(4,3,14,43,12,180.00,7740.00,0.00),(5,4,6,5,0,650.00,3250.00,0.00),(6,4,10,12,19,12500.00,150000.00,0.00),(7,5,3,5,5,100.00,500.00,0.00),(8,6,4,14,10,3.00,42.00,0.00),(9,6,11,3,0,55.00,165.00,0.00),(10,6,9,6,0,45.00,270.00,0.00),(11,7,16,15,10,60.00,900.00,0.00),(12,8,4,5,0,35.00,175.00,0.00),(14,10,2,45,0,750.00,33750.00,0.00),(15,10,4,12,0,1000.00,12000.00,0.00),(16,11,2,125,0,4500.00,562500.00,0.00),(17,12,2,115,115,2700.00,310500.00,0.00),(21,14,3,250,50,180.00,45000.00,0.00),(22,15,17,100,80,70.00,7000.00,0.00),(23,16,18,50,30,80.00,4000.00,0.00),(24,17,19,100,30,200.00,20000.00,0.00),(25,18,2,5,0,100.00,500.00,0.00),(26,18,16,20,0,150.00,3000.00,0.00),(27,19,20,10,10,15000.00,150000.00,0.00),(28,20,2,50,60,700.00,35000.00,0.00),(29,21,4,20,0,200.00,4000.00,0.00),(30,21,14,5,0,100.00,500.00,0.00),(31,21,15,10,0,120.00,1200.00,0.00),(32,21,18,15,0,250.00,3750.00,0.00),(34,3,2,10,0,25.50,255.00,0.00),(35,21,5,10,0,25.20,252.00,0.00),(36,21,10,20,0,75.50,1510.00,0.00),(37,22,2,55,0,30.00,1650.00,0.00),(38,23,16,20,0,120.00,2400.00,0.00),(39,23,10,5,0,14000.00,70000.00,0.00),(40,24,4,10,0,20.00,200.00,0.00),(41,25,4,2,0,100.00,200.00,0.00),(42,26,7,10,0,250.00,2500.00,0.00),(43,27,4,25,0,3700.00,92500.00,0.00),(44,28,3,20,0,250.00,5000.00,0.00),(45,29,6,100,0,750.00,75000.00,0.00),(46,30,8,240,0,1450.00,348000.00,0.00),(47,31,6,130,0,370.00,48100.00,0.00),(48,32,3,350,0,145.00,50750.00,0.00),(49,33,3,100,0,220.00,22000.00,0.00),(50,33,10,150,0,7500.00,1125000.00,0.00),(51,33,15,170,0,620.00,105400.00,0.00),(52,34,2,10,0,205.00,2050.00,0.00),(53,34,12,5,0,55.00,275.00,0.00),(54,34,13,44,0,35.00,1540.00,0.00),(55,35,2,12,0,21.00,252.00,0.00),(56,36,24,100,50,2800.00,280000.00,0.00),(57,37,25,70,60,200.00,14000.00,0.00),(58,38,25,25,10,170.00,4250.00,0.00),(59,39,26,100,100,50.00,5000.00,0.00),(60,40,27,60,50,70.00,4200.00,0.00),(61,41,16,11,0,250.00,2750.00,0.00),(62,42,12,11,0,110.00,1210.00,0.00),(63,43,17,270,0,120.00,32400.00,0.00),(64,44,9,5,0,250.00,1250.00,0.00),(65,45,13,11,0,21.00,231.00,0.00),(66,46,12,3,0,210.00,630.00,0.00),(67,47,12,2,0,670.00,1340.00,0.00),(68,48,17,12,0,22.00,264.00,0.00),(69,49,4,20,0,2700.00,54000.00,0.00),(70,50,13,10,0,1200.00,12000.00,0.00),(71,51,13,10,0,1200.00,12000.00,0.00),(72,52,28,70,10,120.00,8400.00,0.00),(73,53,9,5,0,350.00,1750.00,0.00),(74,54,9,3,0,110.00,330.00,0.00),(75,56,29,20,0,1000.00,20000.00,29.91),(76,57,29,10,0,1060.00,10600.00,23.05),(77,60,30,5,1,1700.00,8500.00,0.00),(78,61,14,120,0,10.00,1200.00,0.00),(79,62,2,10,2,2500.00,25000.00,0.00),(80,62,3,12,0,750.00,9000.00,0.00),(81,62,4,10,0,4750.00,47500.00,0.00),(82,62,9,16,0,7000.00,112000.00,0.00),(83,62,18,22,0,340.00,7480.00,0.00),(84,62,17,19,0,150.00,2850.00,0.00),(85,62,16,7,0,130.00,910.00,0.00),(86,62,19,14,0,430.00,6020.00,0.00),(87,62,30,27,0,2500.00,67500.00,0.00),(88,62,14,10,0,200.00,2000.00,0.00),(89,63,2,10,0,2400.00,24000.00,0.00),(90,63,3,25,0,270.00,6750.00,0.00),(91,63,4,10,0,150.00,1500.00,0.00),(92,63,5,2,0,250.00,500.00,0.00),(93,63,6,10,0,750.00,7500.00,0.00),(94,63,7,20,0,400.00,8000.00,0.00),(95,63,9,11,0,340.00,3740.00,0.00),(96,63,17,2,0,430.00,860.00,0.00),(97,63,18,8,0,150.00,1200.00,0.00),(98,63,19,42,0,120.00,5040.00,0.00),(99,63,15,5,0,350.00,1750.00,0.00),(100,63,16,10,0,100.00,1000.00,0.00),(101,63,17,10,0,130.00,1300.00,0.00),(102,63,19,9,0,460.00,4140.00,0.00),(103,63,11,5,0,250.00,1250.00,0.00),(104,64,2,3,0,535.00,1605.00,6.06),(105,65,2,2,1,530.00,1060.00,3.91),(106,65,3,2,0,19500.00,39000.00,11.81),(107,66,2,2,0,480.00,960.00,2.72),(109,68,2,5,0,570.00,2850.00,11.96),(110,69,2,1,0,600.00,600.00,2.78),(111,70,2,5,2,3000.00,15000.00,169.55),(112,71,2,5,0,390.00,1950.00,0.93),(113,72,2,4,0,600.00,2400.00,11.91),(114,73,2,4,0,600.00,2400.00,11.91),(115,74,2,4,0,600.00,2400.00,11.91),(116,75,2,4,0,600.00,2400.00,11.91),(117,76,2,4,0,600.00,2400.00,11.91),(118,77,2,10,0,550.00,5500.00,23.14),(119,78,2,3,0,750.00,2250.00,14.92),(120,79,2,10,0,600.00,6000.00,29.79),(131,90,2,3,0,560.00,1680.00,7.34),(132,91,3,3,0,700.00,2100.00,7.26),(133,92,2,2,0,700.00,1400.00,8.84),(134,93,3,2,0,750.00,1500.00,6.19),(135,94,3,5,0,650.00,3250.00,8.74),(136,95,3,1,0,590.00,590.00,0.94),(137,96,3,2,0,600.00,1200.00,2.15),(138,97,3,3,0,750.00,2250.00,9.28),(139,98,2,1,0,500.00,500.00,1.63),(140,99,3,5,0,700.00,3500.00,11.61),(142,101,2,2,1,480.00,960.00,2.72),(143,102,2,1,0,520.00,520.00,1.90),(144,103,2,1,0,470.00,470.00,1.23),(145,104,2,2,0,540.00,1080.00,4.34),(146,105,3,1,0,700.00,700.00,2.32),(147,106,2,5,0,520.00,2600.00,9.49),(148,107,38,100,100,630.00,63000.00,147.91),(149,108,38,100,50,640.00,64000.00,161.37),(150,109,38,70,20,650.00,45500.00,122.38),(151,110,39,100,50,400.00,40000.00,138.36),(152,111,2,5,0,670.00,3350.00,19.59),(153,111,3,2,0,720.00,1440.00,5.18),(154,112,2,2,0,700.00,1400.00,8.64),(155,113,2,1,0,500.00,500.00,1.69),(156,114,2,2,0,560.00,1120.00,4.87),(158,116,2,3,0,540.00,1620.00,7.70),(159,117,2,3,0,450.00,1350.00,4.07),(160,118,3,1,0,750.00,750.00,2.99),(161,119,3,1,0,500.00,500.00,-0.37),(162,120,2,2,0,700.00,1400.00,9.44),(163,121,2,2,0,540.00,1080.00,5.14),(164,122,2,1,0,600.00,600.00,3.38),(165,123,2,1,0,650.00,650.00,4.05),(166,124,2,2,0,440.00,880.00,2.44),(167,125,3,1,0,800.00,800.00,3.67),(168,126,3,1,0,560.00,560.00,0.44),(169,127,2,1,0,500.00,500.00,2.03),(170,128,2,5,0,500.00,2500.00,10.15),(171,129,3,2,0,650.00,1300.00,3.30),(172,130,2,200,0,1000.00,200000.00,1751.79),(173,131,2,2,0,480.00,960.00,3.37),(174,132,2,3,0,500.00,1500.00,5.85),(175,133,2,1,0,490.00,490.00,1.82),(176,134,2,50,0,500.00,25000.00,82.45),(177,135,2,10,0,500.00,5000.00,17.11),(178,136,2,1,0,500.00,500.00,1.79),(179,137,2,20,0,470.00,9400.00,27.20),(180,138,2,1,0,560.00,560.00,2.58),(181,139,2,2,0,540.00,1080.00,4.61),(182,140,2,1,0,540.00,540.00,2.31),(184,142,3,5,0,730.00,3650.00,14.39),(185,143,2,1,0,460.00,460.00,1.22),(186,144,3,3,0,670.00,2010.00,6.20),(187,145,2,1,0,500.00,500.00,1.77),(188,146,2,5,0,490.00,2450.00,8.15),(189,147,2,1,0,500.00,500.00,1.77),(190,148,2,3,0,700.00,2100.00,13.42),(191,149,2,2,0,650.00,1300.00,7.59),(192,150,3,1,1,700.00,700.00,2.47),(193,151,3,3,0,750.00,2250.00,9.45),(194,152,2,1,0,450.00,450.00,1.09),(195,153,43,100,0,35.00,3500.00,17.11),(196,154,45,100,0,250.00,25000.00,66.47),(197,155,2,5,0,400.00,2000.00,1.92),(198,156,2,10,0,420.00,4200.00,6.53),(199,157,2,1,0,560.00,560.00,2.54),(200,158,2,1,0,560.00,560.00,2.54),(201,159,16,10,0,100.00,1000.00,-36.73),(202,160,2,10,0,500.00,5000.00,-53.64),(203,161,3,10,0,5000.00,50000.00,593.57),(204,162,2,1,0,1000.00,1000.00,1.27),(205,163,2,10,0,500.00,5000.00,-53.64);
/*!40000 ALTER TABLE `sale_items` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER update_sale_total AFTER INSERT ON sale_items
FOR EACH ROW
BEGIN
    -- Update the total_amount in the sales table by summing all item totals for the given sale_id
    UPDATE sales 
    SET total_amount = (SELECT SUM(total) FROM sale_items WHERE sale_id = NEW.sale_id)
    WHERE id = NEW.sale_id;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER update_sale_total_after_update AFTER UPDATE ON sale_items
FOR EACH ROW
BEGIN
    -- Update the total_amount in the sales table by summing all item totals for the given sale_id
    UPDATE sales 
    SET total_amount = (SELECT SUM(total) FROM sale_items WHERE sale_id = OLD.sale_id)
    WHERE id = OLD.sale_id;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_loan` tinyint(1) NOT NULL DEFAULT 0,
  `total_profit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `currency_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_currency` (`currency_id`),
  CONSTRAINT `fk_currency` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,'Ahmad',3500.00,'2025-01-19 06:18:55',0,0.00,NULL,NULL),(2,'Ahmad',2750.00,'2025-01-19 06:23:16',0,0.00,NULL,NULL),(3,'Said Shah',22245.00,'2025-01-19 09:38:25',0,0.00,NULL,NULL),(4,'Waris kaka',153250.00,'2025-01-19 09:43:21',0,0.00,NULL,NULL),(5,'Wali',500.00,'2025-01-19 10:05:00',0,0.00,NULL,NULL),(6,'Shah Mehmod',477.00,'2025-01-19 11:32:32',0,0.00,NULL,NULL),(7,'Ø³Ù„Ø·Ø§Ù†',900.00,'2025-01-20 10:20:46',0,0.00,NULL,NULL),(8,'Ø³Ù…ÛŒØ¹',175.00,'2025-01-20 11:18:07',0,0.00,NULL,NULL),(10,'Ù…Ø­Ù…Ø¯ Ù‚Ø§Ø¯Ø±',45750.00,'2025-01-20 11:44:46',0,0.00,NULL,NULL),(11,'Ø¹Ø¨Ø¯ Ø§Ù„Ù‡Ø§Ø¯ÛŒ',562500.00,'2025-01-20 11:45:42',0,0.00,NULL,NULL),(12,'Ø±Ø´ÛŒØ¯',310500.00,'2025-01-20 11:47:49',0,0.00,NULL,NULL),(14,'Ø­Ø§Ø¬ÛŒ Ø§Ø­Ù…Ø¯',45000.00,'2025-01-22 07:24:30',0,0.00,NULL,NULL),(15,'Ø³ÛŒØ¯ Ù…Ø­Ù…Ø¯ Ø®Ø§Ù†',7000.00,'2025-01-23 09:54:32',0,0.00,NULL,NULL),(16,'Ø§Ú©Ø¨Ø± ÙˆÙ„ÛŒ',4000.00,'2025-01-23 10:22:28',0,0.00,NULL,NULL),(17,'Ø¹Ø¨Ø¯ Ø§Ù„Ù…ØµÙˆØ±',20000.00,'2025-01-23 12:27:54',0,0.00,NULL,NULL),(18,'Ø§Ø­Ù…Ø¯',3500.00,'2025-01-24 02:40:24',0,0.00,NULL,NULL),(19,'Ø§Ù…ÛŒØ±',150000.00,'2025-01-24 11:10:30',0,0.00,NULL,NULL),(20,'ÙˆØ§ØµÙ',35000.00,'2025-01-24 11:23:35',0,0.00,NULL,NULL),(21,'Ù…Ø­Ù…Ø¯ Ø§Ú©Ø¨Ø±',11212.00,'2025-01-25 05:04:06',0,0.00,NULL,NULL),(22,'Ù…Ø­Ù…Ø¯ Ù‡Ø§Ø´Ù…',1650.00,'2025-01-25 11:28:35',0,0.00,NULL,NULL),(23,'Ø¨Ø§Ø³Ø·',72400.00,'2025-01-25 11:52:39',0,0.00,NULL,NULL),(24,'Ú©Ø§Ù…Ø±Ø§Ù†',200.00,'2025-01-25 11:58:27',0,0.00,NULL,NULL),(25,'Ù†ÙˆØ±Ù…Ù„',200.00,'2025-01-25 12:00:22',0,0.00,NULL,NULL),(26,'Ø¨Ù„Ø§Ù„',2500.00,'2025-01-25 12:03:29',0,0.00,NULL,NULL),(27,'Ø¬Ù…Ø´ÛŒØ¯',92500.00,'2025-01-25 12:05:54',0,0.00,NULL,NULL),(28,'Ø¨ÛŒØª Ø§Ù„Ù„Ù‡',5000.00,'2025-01-25 12:10:43',0,0.00,NULL,NULL),(29,'ÙÙˆØ§Ø¯',75000.00,'2025-01-25 12:11:41',0,0.00,NULL,NULL),(30,'Ø¹Ø¨Ø¯Ø§Ù„Ù„Ù‡',348000.00,'2025-01-25 12:17:44',0,0.00,NULL,NULL),(31,'Ø¹Ø¨Ø¯ Ø§Ù„Ø±Ø­Ù…Ù†',48100.00,'2025-01-25 12:18:36',0,0.00,NULL,NULL),(32,'Ø¨Ø´ÛŒØ±',50750.00,'2025-01-25 12:20:46',0,0.00,NULL,NULL),(33,'Ù†ÙˆØ± Ø§Ù„Ù„Ù‡',1252400.00,'2025-01-25 12:28:55',0,0.00,NULL,NULL),(34,'Ø¸Ø§Ù‡Ø±',3865.00,'2025-01-26 06:10:40',0,0.00,NULL,NULL),(35,'Ù…Ø­Ù…Ø¯',252.00,'2025-01-26 06:12:52',0,0.00,NULL,NULL),(36,'mohammad mahdi',280000.00,'2025-01-26 11:58:33',0,0.00,NULL,NULL),(37,'Basheer',14000.00,'2025-01-27 05:08:48',0,0.00,NULL,NULL),(38,'jan mohammad',4250.00,'2025-01-27 05:17:41',0,0.00,NULL,NULL),(39,'Wali',5000.00,'2025-01-27 06:29:22',0,0.00,NULL,NULL),(40,'ghazi',4200.00,'2025-01-27 06:48:22',0,0.00,NULL,NULL),(41,'Abdullah',2750.00,'2025-01-28 08:00:32',0,0.00,NULL,NULL),(42,'Gul mohammad khan',1210.00,'2025-01-28 08:22:01',0,0.00,NULL,NULL),(43,'',32400.00,'2025-01-28 08:22:29',0,0.00,NULL,NULL),(44,'',1250.00,'2025-01-28 08:26:33',0,0.00,NULL,NULL),(45,'Ali',231.00,'2025-01-28 08:27:58',0,0.00,NULL,NULL),(46,'',630.00,'2025-01-28 09:38:53',0,0.00,NULL,NULL),(47,'',1340.00,'2025-01-28 09:43:35',0,0.00,NULL,NULL),(48,'Gul khan',264.00,'2025-01-28 10:01:57',0,0.00,NULL,NULL),(49,'Ali',54000.00,'2025-01-28 10:03:48',0,0.00,NULL,NULL),(50,'Wali',12000.00,'2025-01-28 10:18:39',0,0.00,NULL,NULL),(51,'Wali',12000.00,'2025-01-28 10:19:04',0,0.00,NULL,NULL),(52,'Ù…Ø­Ù…Ø¯',8400.00,'2025-01-29 03:51:08',0,0.00,NULL,NULL),(53,'hashmat',1750.00,'2025-01-29 04:06:18',0,0.00,NULL,NULL),(54,'hashmat',330.00,'2025-01-29 04:07:00',0,0.00,NULL,NULL),(56,'akbar wali',20000.00,'2025-02-01 04:26:08',0,0.00,NULL,NULL),(57,'kamran khan',10600.00,'2025-02-01 04:34:17',0,23.05,NULL,NULL),(60,'Asad',8500.00,'2025-02-01 07:41:48',0,0.00,NULL,NULL),(61,'Ali',1200.00,'2025-02-01 09:51:34',0,0.00,NULL,NULL),(62,'Qadeer',280260.00,'2025-02-01 10:49:52',0,0.00,NULL,NULL),(63,'Adnan',68530.00,'2025-02-01 10:53:37',0,0.00,NULL,NULL),(64,'gul zada',1605.00,'2025-02-02 05:40:47',0,6.06,NULL,NULL),(65,'yaseen mama',40060.00,'2025-02-02 05:43:28',0,15.72,NULL,NULL),(66,'khan',960.00,'2025-02-02 05:51:52',0,2.72,NULL,NULL),(68,'ahmad',2850.00,'2025-02-02 06:43:34',0,11.96,NULL,NULL),(69,'Ahmad',600.00,'2025-02-02 06:53:17',0,2.78,NULL,NULL),(70,'Ahmad',15000.00,'2025-02-02 06:54:39',1,169.55,NULL,NULL),(71,'shershah',1950.00,'2025-02-02 07:00:17',0,0.93,10,NULL),(72,'ali',2400.00,'2025-02-02 09:20:05',0,11.91,10,NULL),(73,'ali',2400.00,'2025-02-02 09:20:59',0,11.91,10,NULL),(74,'ali',2400.00,'2025-02-02 09:21:13',0,11.91,10,NULL),(75,'ali',2400.00,'2025-02-02 09:21:40',0,11.91,10,NULL),(76,'ali',2400.00,'2025-02-02 09:23:11',0,11.91,10,NULL),(77,'gul',5500.00,'2025-02-02 09:30:09',0,23.14,10,NULL),(78,'muhammed',2250.00,'2025-02-02 13:46:44',0,14.92,10,NULL),(79,'Ahmad shah',6000.00,'2025-02-02 15:23:18',0,29.79,10,NULL),(90,'Ahmad',1680.00,'2025-02-04 05:04:58',0,7.34,10,NULL),(91,'Ahmad',2100.00,'2025-02-04 05:07:14',1,7.26,11,NULL),(92,'Akram',1400.00,'2025-02-04 05:28:59',0,8.84,11,NULL),(93,'Waseem',1500.00,'2025-02-04 05:31:41',0,6.19,11,NULL),(94,'Jan',3250.00,'2025-02-04 05:36:23',0,8.74,11,NULL),(95,'Akbar',590.00,'2025-02-04 05:37:17',0,0.94,11,NULL),(96,'Shadab',1200.00,'2025-02-04 05:39:24',0,2.15,11,NULL),(97,'Jahanzeb',2250.00,'2025-02-04 06:10:22',0,9.28,11,NULL),(98,'Ahmad',500.00,'2025-02-11 07:50:49',0,1.63,26,NULL),(99,'Wali',3500.00,'2025-02-11 07:52:46',1,11.61,26,NULL),(101,'Khan',960.00,'2025-02-11 08:15:33',0,2.72,26,NULL),(102,'Ali',520.00,'2025-02-11 08:16:07',0,1.90,26,NULL),(103,'Ahmad',470.00,'2025-02-11 08:18:58',0,1.23,26,NULL),(104,'Mohammad',1080.00,'2025-02-11 08:20:11',0,4.34,26,NULL),(105,'Jan',700.00,'2025-02-11 08:24:03',0,2.32,26,NULL),(106,'Ahmad',2600.00,'2025-02-11 08:26:05',1,9.49,26,NULL),(107,'Hameed',63000.00,'2025-02-12 05:15:05',0,147.91,26,NULL),(108,'Gul Mohammad',64000.00,'2025-02-12 06:12:18',0,161.37,26,NULL),(109,'Akram',45500.00,'2025-02-12 07:07:29',0,122.38,26,NULL),(110,'Bakhtyar',40000.00,'2025-02-12 08:26:53',0,138.36,26,NULL),(111,'Ezatullah',4790.00,'2025-02-13 04:36:22',0,24.77,26,NULL),(112,'Ezatullah',1400.00,'2025-02-13 04:36:48',1,8.64,26,NULL),(113,'Khan',500.00,'2025-02-14 13:56:57',0,1.69,27,NULL),(114,'Khan',1120.00,'2025-02-15 04:08:02',0,4.87,28,NULL),(116,'Wali',1620.00,'2025-02-15 04:58:35',0,7.70,28,NULL),(117,'Mohammad',1350.00,'2025-02-15 05:01:18',0,4.07,28,NULL),(118,'Ahmad',750.00,'2025-02-15 05:06:21',0,2.99,28,NULL),(119,'wali',500.00,'2025-02-15 05:13:33',0,-0.37,28,NULL),(120,'ali',1400.00,'2025-02-15 05:15:11',0,9.44,28,NULL),(121,'mohammad',1080.00,'2025-02-15 05:15:44',0,5.14,28,NULL),(122,'jan',600.00,'2025-02-15 05:19:50',0,3.38,28,NULL),(123,'Khan',650.00,'2025-02-15 05:21:22',0,4.05,28,NULL),(124,'mahmud',880.00,'2025-02-15 05:23:36',0,2.44,28,NULL),(125,'mohammad',800.00,'2025-02-15 05:24:20',0,3.67,28,NULL),(126,'Akram',560.00,'2025-02-15 05:28:01',0,0.44,28,NULL),(127,'wali gul',500.00,'2025-02-16 07:12:11',0,2.03,28,NULL),(128,'John',2500.00,'2025-02-16 07:38:56',0,10.15,28,NULL),(129,'Shabeer',1300.00,'2025-03-01 09:33:31',0,3.30,28,NULL),(130,'Ahmad',200000.00,'2025-02-17 06:12:36',0,1751.79,28,NULL),(131,'Ali khan',960.00,'2025-02-18 11:35:31',0,3.37,30,NULL),(132,'Mohammed',1500.00,'2025-02-18 11:37:12',0,5.85,30,NULL),(133,'Gul khan jan',490.00,'2025-02-18 11:38:58',0,1.82,30,'shershah'),(134,'Baran',25000.00,'2025-02-19 05:58:20',0,82.45,30,'shahid'),(135,'ALi',5000.00,'2025-02-21 05:43:47',0,17.11,31,'shahid'),(136,'Abobaker',500.00,'2025-02-23 06:35:17',0,1.79,32,'shahid'),(137,'Ghulam sakhi',9400.00,'2025-02-24 05:35:50',1,27.20,33,'shahid'),(138,'Wali mohammad',560.00,'2025-02-24 05:39:17',0,2.58,33,'shahid'),(139,'Wali mohammad',1080.00,'2025-02-24 05:40:21',1,4.61,33,'shahid'),(140,'Wali mohammad',540.00,'2025-02-24 07:00:27',0,2.31,33,'shahid'),(142,'Wali mohammad',3650.00,'2025-02-24 07:05:25',1,14.39,33,'shahid'),(143,'Wali mohammad',460.00,'2025-02-24 07:07:30',1,1.22,33,'shahid'),(144,'Wali mohammad',2010.00,'2025-02-24 07:08:32',1,6.20,33,'shahid'),(145,'Ahmad',500.00,'2025-02-24 07:10:16',1,1.77,33,'shahid'),(146,'Akram',2450.00,'2025-02-24 07:10:48',1,8.15,33,'shahid'),(147,'Ahmad',500.00,'2025-02-24 07:13:13',1,1.77,33,'shahid'),(148,'ALi',2100.00,'2025-02-24 07:13:42',0,13.42,33,'shahid'),(149,'Khan',1300.00,'2025-02-24 07:17:17',0,7.59,33,'shahid'),(150,'Jan',700.00,'2025-02-24 07:18:11',0,2.47,33,'shahid'),(151,'Shekib',2250.00,'2025-02-24 07:21:59',0,9.45,33,'shahid'),(152,'Zakir',450.00,'2025-02-24 07:23:37',0,1.09,33,'shahid'),(153,'Sami',3500.00,'2025-02-25 10:42:38',0,17.11,34,'shahid'),(154,'Zakir',25000.00,'2025-02-25 11:13:32',0,66.47,34,'shahid'),(155,'Abdul hadi',2000.00,'2025-02-26 03:47:51',0,1.92,34,'shahid'),(156,'GUl khan',4200.00,'2025-02-26 03:49:12',0,6.53,34,'shahid'),(157,'Mustafa',560.00,'2025-03-08 09:00:20',0,2.54,34,'shahid'),(158,'Mustafa',560.00,'2025-03-08 09:01:36',0,2.54,34,'shahid'),(159,'khan',1000.00,'2025-05-18 17:26:06',0,-36.73,37,'shahid'),(160,'wali',5000.00,'2025-05-18 17:26:24',0,-53.64,37,'shahid'),(161,'khan',50000.00,'2025-05-18 17:27:27',0,593.57,37,'shahid'),(162,'mohammad',1000.00,'2025-05-18 17:48:29',0,1.27,37,'hijratullah'),(163,'sir mahdi',5000.00,'2025-05-21 07:08:19',0,-53.64,37,'shahid');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_expenses`
--

DROP TABLE IF EXISTS `shop_expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_expenses`
--

LOCK TABLES `shop_expenses` WRITE;
/*!40000 ALTER TABLE `shop_expenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_transfers`
--

DROP TABLE IF EXISTS `stock_transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_transfers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `transfer_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `destination` enum('stock','warehouse') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `stock_transfers_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_transfers`
--

LOCK TABLES `stock_transfers` WRITE;
/*!40000 ALTER TABLE `stock_transfers` DISABLE KEYS */;
INSERT INTO `stock_transfers` VALUES (1,2,200,'2025-02-19 07:55:19',''),(2,2,100,'2025-02-19 07:55:44','warehouse'),(3,2,500,'2025-02-19 07:56:09','warehouse'),(4,2,100,'2025-02-19 07:56:20',''),(5,2,100,'2025-02-19 07:57:55',''),(6,2,100,'2025-02-19 08:50:39',''),(7,2,50,'2025-02-19 08:53:01',''),(8,2,200,'2025-02-19 08:53:25','warehouse'),(9,2,100,'2025-02-19 08:53:32','stock'),(10,2,50,'2025-02-19 08:58:01',''),(11,2,50,'2025-02-19 08:58:14',''),(12,2,500,'2025-02-19 09:02:01','warehouse'),(13,2,100,'2025-02-19 09:02:13','stock'),(14,2,100,'2025-02-19 09:02:26','stock'),(15,2,50,'2025-02-19 09:03:34',''),(16,2,50,'2025-02-19 09:04:07',''),(17,2,50,'2025-02-19 09:04:36','stock'),(18,3,50,'2025-02-20 05:01:58','stock'),(19,2,100,'2025-02-20 05:05:12','warehouse'),(20,2,100,'2025-02-20 10:31:14','warehouse'),(21,42,20,'2025-02-25 10:37:11','stock'),(22,43,100,'2025-02-25 10:38:46','stock'),(23,43,300,'2025-02-25 10:41:44','stock'),(24,45,400,'2025-02-25 11:12:47','stock'),(25,46,100,'2025-02-25 12:28:40','stock'),(26,47,100,'2025-02-25 12:29:47','stock'),(27,46,500,'2025-02-26 10:39:40','stock'),(28,47,500,'2025-02-26 10:39:47','stock'),(29,49,1,'2025-02-27 04:18:24','stock'),(30,2,100,'2025-05-13 05:38:44','warehouse'),(31,2,100,'2025-05-13 05:39:12','stock'),(32,2,150,'2025-05-18 17:14:23','warehouse');
/*!40000 ALTER TABLE `stock_transfers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total_products` decimal(10,2) NOT NULL,
  `cash` decimal(10,2) NOT NULL,
  `cash_in_banks` decimal(10,2) NOT NULL,
  `message` text DEFAULT NULL,
  `add_sub` enum('add','sub') DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,615402.50,0.00,0.00,NULL,'','2025-02-08 12:21:11'),(2,615402.50,0.00,0.00,NULL,'','2025-02-08 12:23:01'),(3,615402.50,0.00,0.00,NULL,'','2025-02-08 12:27:50'),(4,615402.50,200.00,0.00,'just added\r\n','add','2025-02-08 12:31:10'),(5,615402.50,100.00,0.00,'just windthrown','sub','2025-02-08 12:33:46'),(6,615402.50,350.00,0.00,'simply deposited','add','2025-02-08 12:48:38'),(7,615402.50,250.00,0.00,'a test withdraw','sub','2025-02-08 12:48:57'),(8,615402.50,750.00,0.00,'normally added','add','2025-02-09 06:06:05'),(9,615402.50,480.00,0.00,'for electricity bill','sub','2025-02-09 06:21:20'),(10,543292.50,480.00,0.00,'Added purchase','add','2025-02-11 04:30:53'),(11,543792.50,480.00,0.00,'Added purchase','add','2025-02-11 04:32:12'),(12,543797.50,480.00,0.00,'Added purchase','add','2025-02-11 04:32:57'),(13,543802.50,480.00,0.00,'Added purchase','add','2025-02-11 04:37:28'),(14,543807.50,480.00,0.00,'Added purchase','add','2025-02-11 04:42:02'),(15,543812.50,480.00,0.00,'Added purchase','add','2025-02-11 04:42:33'),(16,543857.50,480.00,0.00,'Added new purchase. Product id: 2, quantity: 10, price: 5','add','2025-02-11 05:00:24'),(17,544001.50,480.00,0.00,'Added new purchase. Product id: 3, quantity: 10, price: 7.2','add','2025-02-11 05:40:58'),(18,544021.30,480.00,0.00,'Added new purchase. Product: air phones, quantity: 4, price: 7.1','add','2025-02-11 05:43:47'),(19,544124.00,480.00,0.00,'Added new purchase. Product: Apple watch, quantity: 4, price: 5.1','add','2025-02-11 06:54:31'),(20,547520.20,480.00,0.00,'Added new purchase. Product: 128 GB SanDisk Memory card, quantity: 500, price: 7','add','2025-02-12 05:14:17'),(21,547903.20,480.00,0.00,'Added new purchase. Product: 120 W charger, quantity: 500, price: 4','add','2025-02-12 08:26:33'),(22,547493.30,-320.00,0.00,'','sub','2025-02-13 08:02:23'),(23,547493.30,-220.00,0.00,'Added some cash','add','2025-02-13 12:12:26'),(24,547493.30,-20.00,0.00,'I added 200 rupees normally','add','2025-02-14 11:13:32'),(25,547493.30,80.00,0.00,'','add','2025-02-14 11:13:49'),(26,547488.20,180.00,0.00,'','add','2025-02-15 04:04:19'),(27,547488.20,280.00,0.00,'Added 100 rupees\r\n','add','2025-02-15 04:04:53'),(28,547478.00,80.00,0.00,'200 rupees has been gotten for going to somewhere','sub','2025-02-15 04:28:55'),(29,547478.00,130.00,0.00,'','add','2025-02-15 04:33:49'),(30,547478.00,100.00,0.00,'','sub','2025-02-15 04:35:33'),(31,547478.00,300.00,0.00,'','add','2025-02-15 04:36:31'),(32,547626.00,300.00,0.00,'Added new purchase. Product: Apple watch, quantity: 100, price: 4.70','add','2025-02-15 04:40:02'),(33,547626.00,200.00,0.00,'','sub','2025-02-15 04:44:51'),(34,547626.00,150.00,0.00,'Subtracted 50 rupees','sub','2025-02-15 04:45:23'),(35,547626.00,300.00,0.00,'','add','2025-02-15 04:46:55'),(36,547626.00,320.00,0.00,'','add','2025-02-15 04:48:01'),(37,547626.00,350.00,0.00,'Cash\n','add','2025-02-15 04:49:25'),(38,547626.00,400.00,0.00,'50 Cash subtracted\n','add','2025-02-15 04:51:55'),(39,547626.00,500.00,0.00,'100 Cash subtracted\nNeeded for repairing the car','add','2025-02-15 04:52:19'),(40,547626.00,450.00,0.00,'50 Cash subtracted\n','sub','2025-02-15 04:54:20'),(41,547626.00,430.00,0.00,'20 Cash subtracted\nI needed it','sub','2025-02-15 04:54:39'),(42,547626.00,405.00,0.00,'25 Cash subtracted\n','sub','2025-02-15 04:57:01'),(44,547626.00,405.00,0.00,'Sale added successfully with 7.7034993270525 profit.','add','2025-02-15 04:58:35'),(45,547611.90,405.00,0.00,'Sale added successfully with 4.0695827725437 profit.','add','2025-02-15 05:01:18'),(46,547597.80,405.00,0.00,'Sale added successfully with 2.9942126514132 profit.','add','2025-02-15 05:06:22'),(47,547590.70,405.00,0.00,'Sale added successfully with -0.37052489905787 profit.','add','2025-02-15 05:13:34'),(48,547574.20,405.00,0.00,'Sale added successfully with 5.135666218035 profit.','add','2025-02-15 05:15:44'),(49,547564.80,405.00,0.00,'Sale added successfully with 3.3753701211306 profit.','add','2025-02-15 05:19:50'),(50,547560.10,405.00,0.00,'Sale added successfully with 4.0483176312248 profit.','add','2025-02-15 05:21:22'),(51,547555.40,405.00,0.00,'Sale added successfully with 2.4438761776581 profit.','add','2025-02-15 05:23:36'),(52,547546.00,405.00,0.00,'Sale added successfully with 3.6671601615074 profit.','add','2025-02-15 05:24:20'),(53,547538.90,305.00,0.00,'100 Cash subtracted\n','sub','2025-02-15 05:25:00'),(54,547538.90,205.00,0.00,'100 Cash subtracted\n','sub','2025-02-15 05:27:15'),(55,547538.90,205.00,0.00,'Sale added successfully with 0.44 profit.','add','2025-02-15 05:28:01'),(56,547531.80,210.30,0.00,'5.3 Cash added\nextra income in exchanging','add','2025-02-15 05:40:28'),(57,547390.80,210.30,0.00,'10 Apple watch has been used with 47 loss.','','2025-02-15 05:55:23'),(58,547202.80,210.30,0.00,'20 Apple watch has been used with $94 loss.','','2025-02-15 06:09:26'),(59,547198.10,210.30,0.00,'1 Apple watch has been used with $4.7 loss.','','2025-02-15 06:22:45'),(60,547198.10,210.30,0.00,'Sale added successfully with 2.03 profit.','add','2025-02-16 07:12:12'),(61,547193.40,-339.70,0.00,'550 Cash subtracted\nelectricity bill','sub','2025-02-16 07:27:47'),(62,547193.40,-339.70,0.00,'Sale added successfully with 10.15 profit.','add','2025-02-16 07:38:56'),(64,547155.70,-339.70,0.00,'Sale added successfully with 1,751.79 profit.','add','2025-02-17 06:12:36'),(65,546215.70,-339.70,0.00,'Sale added successfully with 3.37 profit.','add','2025-02-18 11:35:31'),(66,546206.30,-339.70,0.00,'Sale added successfully with 5.85 profit.','add','2025-02-18 11:37:12'),(67,546192.20,-339.70,0.00,'Sale added successfully with 1.82 profit.','add','2025-02-18 11:38:58'),(68,546187.50,-339.70,0.00,'Added new purchase. Product: 40k power bank, quantity: 800, price: 20','add','2025-02-19 05:49:14'),(69,546187.50,-339.70,0.00,'Added new purchase. Product: 40k power bank, quantity: 100, price: 20','add','2025-02-19 05:49:57'),(70,546369.90,-339.70,0.00,'Added new purchase. Product: Apple watch, quantity: 200, price: 5','add','2025-02-19 05:51:36'),(71,546369.90,-339.70,0.00,'Added new purchase. Product: Apple watch, quantity: 50, price: 5','add','2025-02-19 05:53:21'),(72,546369.90,-339.70,0.00,'Added new purchase. Product: Apple watch, quantity: 100, price: 5','add','2025-02-19 05:55:04'),(73,546369.90,-339.70,0.00,'Added new purchase. Product: Apple watch, quantity: 50, price: 5','add','2025-02-19 05:55:25'),(74,546119.90,-339.70,0.00,'50 Apple watch has been used with $250 loss.','','2025-02-19 05:56:42'),(75,546119.90,-339.70,0.00,'Sale added successfully with 82.45 profit.','add','2025-02-19 05:58:20'),(76,546869.90,-339.70,0.00,'100 OTG USB 3.0 has been used with $0 loss.','','2025-02-20 04:37:10'),(77,546833.50,-339.70,0.00,'Added new purchase. Product: air phones, quantity: 100, price: 7','add','2025-02-20 04:51:07'),(78,546183.50,-439.70,0.00,'100 Cash added to bank\ninitial adding','add','2025-02-20 11:36:55'),(79,546183.50,-389.70,0.00,'50 Cash subtracted from bank\n','sub','2025-02-20 11:37:49'),(80,546183.50,-439.70,0.00,'100 Cash added to bank\n','add','2025-02-20 11:38:06'),(81,546183.50,-339.70,40.00,'40 Cash added to bank\n','add','2025-02-20 11:41:01'),(82,546183.50,-339.70,-20.00,'20 Cash subtracted from bank\n','sub','2025-02-20 11:41:35'),(83,546183.50,-339.70,500.00,'500 Cash added to bank\n','add','2025-02-20 12:37:15'),(84,546183.50,-339.70,100.00,'100 Cash added to bank\n','add','2025-02-20 12:41:55'),(85,546183.50,-339.70,-200.00,'300 Cash subtracted from bank\n','sub','2025-02-20 12:45:10'),(86,546183.50,-339.70,4800.00,'5000 Cash added to bank\n','add','2025-02-20 12:45:21'),(87,546183.50,-339.70,4800.00,'Sale added successfully with 17.11 profit.','add','2025-02-21 05:43:47'),(88,546133.50,-339.70,4800.00,'Sale added successfully with 1.79 profit.','add','2025-02-23 06:35:17'),(89,546128.50,-339.70,4800.00,'Sale added successfully with 27.20 profit.','add','2025-02-24 05:35:50'),(90,546028.50,-339.70,4800.00,'Sale added successfully with 2.58 profit.','add','2025-02-24 05:39:17'),(91,546023.50,-339.70,4800.00,'Sale added successfully with 4.61 profit.','add','2025-02-24 05:40:21'),(92,546013.50,-339.70,4800.00,'Sale added successfully with 2.31 profit.','add','2025-02-24 07:00:27'),(94,546008.50,-339.70,4800.00,'Sale added successfully with 14.39 profit.','add','2025-02-24 07:05:25'),(95,545973.50,-339.70,4800.00,'Sale added successfully with 1.22 profit.','add','2025-02-24 07:07:30'),(96,545968.50,-339.70,4800.00,'Sale added successfully with 6.20 profit.','add','2025-02-24 07:08:32'),(97,545947.50,-339.70,4800.00,'Sale added successfully with 1.77 profit.','add','2025-02-24 07:10:16'),(98,545942.50,-339.70,4800.00,'Sale added successfully with 8.15 profit.','add','2025-02-24 07:10:48'),(99,545917.50,-339.70,4800.00,'Sale added successfully with 1.77 profit.','add','2025-02-24 07:13:13'),(100,545912.50,-339.70,4800.00,'Sale added successfully with 13.42 profit.','add','2025-02-24 07:13:42'),(101,545897.50,-339.70,4800.00,'Sale added successfully with 7.59 profit.','add','2025-02-24 07:17:17'),(102,545887.50,-339.70,4800.00,'Sale added successfully with 2.47 profit.','add','2025-02-24 07:18:11'),(103,545880.50,-339.70,4800.00,'Sale added successfully with 9.45 profit.','add','2025-02-24 07:21:59'),(104,545859.50,-339.70,4800.00,'Sale added successfully with 1.09 profit.','add','2025-02-24 07:23:37'),(105,545854.50,-339.70,4800.00,'Added new purchase. Product: HP 64GB, quantity: 100, price: 2.5','add','2025-02-25 10:36:18'),(106,545904.50,-339.70,4800.00,'Added new purchase. Product: Flash Acccessories, quantity: 500, price: 0.3','add','2025-02-25 10:38:11'),(107,545904.50,-339.70,4800.00,'100 Flash Acccessories has been used with $30 loss.','','2025-02-25 10:39:02'),(108,545994.50,-339.70,4800.00,'Sale added successfully with 17.11 profit.','add','2025-02-25 10:42:38'),(109,545964.50,-339.70,4800.00,'Added new purchase. Product: 32GB Flash, quantity: 100, price: 13','add','2025-02-25 10:45:15'),(110,545964.50,-339.70,4800.00,'Added new purchase. Product: 32GB Flash, quantity: 100, price: 1.3','add','2025-02-25 10:46:54'),(111,545964.50,-339.70,4800.00,'Added new purchase. Product: 128 Flash, quantity: 500, price: 2.7','add','2025-02-25 11:09:35'),(112,545934.50,-339.70,4800.00,'100 Flash Acccessories has been used with $30 loss.','','2025-02-25 11:11:20'),(113,547014.50,-339.70,4800.00,'Sale added successfully with 66.47 profit.','add','2025-02-25 11:13:33'),(114,546744.50,-339.70,4800.00,'Added new purchase. Product: UDP 128, quantity: 100, price: 5','add','2025-02-25 12:28:24'),(115,547244.50,-339.70,4800.00,'Added new purchase. Product: Accessories 128, quantity: 100, price: 0.4','add','2025-02-25 12:29:32'),(116,546784.50,-339.70,4800.00,'100 UDP 128 has been used with $500 loss.','','2025-02-25 12:30:42'),(117,546744.50,-339.70,4800.00,'100 Accessories 128 has been used with $40 loss.','','2025-02-25 12:30:51'),(118,546744.50,-139.70,4800.00,'200 Cash added\n','add','2025-02-25 12:50:34'),(119,546744.50,60.30,4800.00,'200 Cash added\nExtra income while currency exchange\r\n','add','2025-02-25 12:51:44'),(120,546744.50,60.30,4800.00,'Sale added successfully with 1.92 profit.','add','2025-02-26 03:47:51'),(121,546719.50,60.30,4800.00,'Sale added successfully with 6.53 profit.','add','2025-02-26 03:49:12'),(122,569129.50,60.30,4800.00,'Added new purchase. Product: UDP 128, quantity: 500, price: 2.7','add','2025-02-26 10:39:16'),(123,569279.50,60.30,4800.00,'Added new purchase. Product: Accessories 128, quantity: 500, price: 0.3','add','2025-02-26 10:39:29'),(124,571379.50,60.30,4800.00,'Added new purchase. Product: Yosonda 30k, quantity: 2, price: 1050','add','2025-02-27 04:18:04'),(125,580379.50,60.30,4800.00,'Added new purchase. Product: Yosonda 30k, quantity: 10, price: 900','add','2025-02-27 04:18:46'),(126,580379.50,435.50,4800.00,'','add','2025-03-02 09:14:45'),(127,580379.50,535.50,4800.00,'50 amount added.','add','2025-03-02 09:16:56'),(128,580379.50,585.50,4800.00,'$200 amount added to safe.','add','2025-03-02 09:18:29'),(129,580379.50,785.50,4800.00,'$100 subtracted from drawer.','sub','2025-03-02 09:19:10');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','standard') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'shahid','shahid@729','admin','2025-02-17 12:51:46'),(2,'ehsanullah','eh2025','standard','2025-02-17 12:51:46'),(3,'shershah','sh6070','standard','2025-02-17 12:51:46'),(4,'samiullah','234567','standard','2025-02-17 12:51:46');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-22  4:31:27
