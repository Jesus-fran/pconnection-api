-- MariaDB dump 10.19  Distrib 10.5.21-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: pconnection
-- ------------------------------------------------------
-- Server version	8.1.0

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
-- Table structure for table `calificaciones`
--

DROP TABLE IF EXISTS `calificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calificaciones` (
  `id_calificacion` int NOT NULL AUTO_INCREMENT,
  `calificacion` int NOT NULL,
  `created_at` datetime NOT NULL,
  `id_restaurant` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_calificacion`),
  KEY `calificaciones_FK` (`id_user`),
  KEY `calificaciones_FK_1` (`id_restaurant`),
  CONSTRAINT `calificaciones_FK` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `calificaciones_FK_1` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id_restaurant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calificaciones`
--

LOCK TABLES `calificaciones` WRITE;
/*!40000 ALTER TABLE `calificaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `calificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentarios` (
  `id_comment` int NOT NULL AUTO_INCREMENT,
  `comentario` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `id_user` int NOT NULL,
  `id_restaurant` int NOT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `comentarios_FK` (`id_user`),
  KEY `comentarios_FK_1` (`id_restaurant`),
  CONSTRAINT `comentarios_FK` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `comentarios_FK_1` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id_restaurant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fotos`
--

DROP TABLE IF EXISTS `fotos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fotos` (
  `id_foto` int NOT NULL AUTO_INCREMENT,
  `foto` blob NOT NULL,
  `created_at` datetime NOT NULL,
  `id_restaurant` int NOT NULL,
  PRIMARY KEY (`id_foto`),
  KEY `fotos_FK` (`id_restaurant`),
  CONSTRAINT `fotos_FK` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id_restaurant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fotos`
--

LOCK TABLES `fotos` WRITE;
/*!40000 ALTER TABLE `fotos` DISABLE KEYS */;
/*!40000 ALTER TABLE `fotos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_100000_create_password_reset_tokens_table',1),(2,'2019_08_19_000000_create_failed_jobs_table',1),(3,'2019_12_14_000001_create_personal_access_tokens_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (120,'App\\Models\\User',34,'Frank Jesus','5312ee8956335073f50c2e2d4dbb1b4f1fea8664ba709f9fa4302759dc4d6dcd','[\"user\"]','2023-11-22 14:51:08',NULL,'2023-11-22 11:44:04','2023-11-22 14:51:08'),(121,'App\\Models\\User',35,'Jesus Doe','640afc09ac7ef59d5c2038792b5f5daf83dc27b14e0720d209021ddf0181ba3d','[\"user\"]','2023-11-22 19:20:40',NULL,'2023-11-22 14:52:16','2023-11-22 19:20:40'),(134,'App\\Models\\User',36,'Jesús','66e8eb7f842bd9a0aa98c58ce8db4cbba4820c0e8ba39c64db7c8b40f861b944','[\"restaurantero\"]','2023-12-04 21:56:18',NULL,'2023-12-03 08:15:47','2023-12-04 21:56:18');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respuestas`
--

DROP TABLE IF EXISTS `respuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `respuestas` (
  `id_respuesta` int NOT NULL AUTO_INCREMENT,
  `respuesta` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `id_user` int NOT NULL,
  `id_comment` int NOT NULL,
  PRIMARY KEY (`id_respuesta`),
  KEY `respuestas_FK` (`id_user`),
  KEY `respuestas_FK_1` (`id_comment`),
  CONSTRAINT `respuestas_FK` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `respuestas_FK_1` FOREIGN KEY (`id_comment`) REFERENCES `comentarios` (`id_comment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respuestas`
--

LOCK TABLES `respuestas` WRITE;
/*!40000 ALTER TABLE `respuestas` DISABLE KEYS */;
/*!40000 ALTER TABLE `respuestas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurants` (
  `id_restaurant` int NOT NULL AUTO_INCREMENT,
  `restaurant` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logo` blob,
  `telefono` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ubicacion` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `desc_oferta` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `oferta` blob,
  `id_user` int NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_restaurant`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurants`
--

LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
INSERT INTO `restaurants` VALUES (56,'Mero Lek','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','9191173466','Desayuna en este hermoso lugar, vistas bellas e inigualables a toda la región selvática,','Taquería',NULL,NULL,NULL,36,1),(57,'El desvan',NULL,NULL,NULL,'Taquería',NULL,NULL,NULL,36,1);
/*!40000 ALTER TABLE `restaurants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `email` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `password` blob NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `rol` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `token_stripe` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token_subscription` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token_card` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `plan` enum('none','basicomen','basicoanual','premiummen','premiumanual') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'none',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `users_UN` (`email`),
  UNIQUE KEY `token_UN` (`token_stripe`),
  UNIQUE KEY `subs_UN` (`token_subscription`),
  UNIQUE KEY `card_UN` (`token_card`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (36,'chuzzgomez18@gmail.com','$2y$10$BcAPJmKlQ4E1z5aN4tNTt.WucJr1SvynTUrLrH9K9FFUvylR8RzMy','Jesús','2023-11-27 03:44:31','restaurantero','cus_P6TU2gdCbsez4H','sub_1OJ9rJAIicvw06Nv3QLBukcK','pm_1OIGXUAIicvw06Nv9YVwCQs4','basicomen',0);
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

-- Dump completed on 2023-12-04 16:43:03
