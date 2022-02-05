/*
SQLyog Professional v10.42 
MySQL - 5.6.16 : Database - javantest
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`javantest` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `javantest`;

/*Table structure for table `silsilahs` */

DROP TABLE IF EXISTS `silsilahs`;

CREATE TABLE `silsilahs` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nama` varchar(255) DEFAULT NULL,
  `JenisKelamin` varchar(1) DEFAULT NULL,
  `Parent` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `silsilahs` */

insert  into `silsilahs`(`Id`,`Nama`,`JenisKelamin`,`Parent`,`created_at`,`updated_at`) values (1,'Budi','L',NULL,'2022-02-02 16:40:29','2022-02-02 16:40:29'),(2,'Dedi','L',1,'2022-02-02 16:40:29','2022-02-03 02:41:29'),(3,'Dodi','L',1,'2022-02-02 16:40:29','2022-02-02 16:40:29'),(4,'Dede','L',1,'2022-02-02 16:40:29','2022-02-02 16:40:29'),(5,'Dewi','P',1,'2022-02-02 16:40:29','2022-02-02 16:40:29'),(6,'Feri','L',2,'2022-02-02 16:40:29','2022-02-02 16:40:29'),(7,'Farah','P',2,'2022-02-02 16:40:29','2022-02-02 16:40:29'),(8,'Gugus','L',3,'2022-02-02 16:40:29','2022-02-02 16:40:29'),(9,'Gandi','L',3,'2022-02-02 16:40:29','2022-02-02 16:40:29'),(10,'Hani','P',4,'2022-02-02 16:40:29','2022-02-02 16:40:29'),(11,'Hana','P',4,'2022-02-02 16:40:29','2022-02-02 16:40:29');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
