/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.1.2-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: laravel
-- ------------------------------------------------------
-- Server version	12.1.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `aplicacion_medicamentos`
--

DROP TABLE IF EXISTS `aplicacion_medicamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `aplicacion_medicamentos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hoja_medicamento_id` bigint(20) unsigned NOT NULL,
  `fecha_aplicacion` datetime NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aplicacion_medicamentos_hoja_medicamento_id_foreign` (`hoja_medicamento_id`),
  KEY `aplicacion_medicamentos_user_id_foreign` (`user_id`),
  CONSTRAINT `aplicacion_medicamentos_hoja_medicamento_id_foreign` FOREIGN KEY (`hoja_medicamento_id`) REFERENCES `hoja_medicamentos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `aplicacion_medicamentos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aplicacion_medicamentos`
--

LOCK TABLES `aplicacion_medicamentos` WRITE;
/*!40000 ALTER TABLE `aplicacion_medicamentos` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `aplicacion_medicamentos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `backups`
--

DROP TABLE IF EXISTS `backups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `backups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `backups_user_id_foreign` (`user_id`),
  CONSTRAINT `backups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backups`
--

LOCK TABLES `backups` WRITE;
/*!40000 ALTER TABLE `backups` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `backups` VALUES
(1,7,'backup-7-2026-02-12-154835.sql','backups/backup-7-2026-02-12-154835.sql','pending','2026-02-12 21:48:35','2026-02-12 21:48:35');
/*!40000 ALTER TABLE `backups` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `cache` VALUES
('hospitalidad_healh_care_cache_spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:63:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:15:\"crear pacientes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:12;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:19:\"consultar pacientes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:6:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:12;i:5;i:13;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:16:\"editar pacientes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:12;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:18:\"eliminar pacientes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:15:\"crear estancias\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:12;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:19:\"consultar estancias\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:13;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:16:\"editar estancias\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:18:\"eliminar estancias\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:21:\"crear hojas frontales\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:25:\"consultar hojas frontales\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:22:\"editar hojas frontales\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:24:\"eliminar hojas frontales\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:18:\"crear habitaciones\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:22:\"consultar habitaciones\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:19:\"editar habitaciones\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:21:\"eliminar habitaciones\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:19:\"crear colaboradores\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:23:\"consultar colaboradores\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:20:\"editar colaboradores\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:22:\"eliminar colaboradores\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:27:\"crear productos y servicios\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:13;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:31:\"consultar productos y servicios\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:13;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:28:\"editar productos y servicios\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:13;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:30:\"eliminar productos y servicios\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:13;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:19:\"consultar historial\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:16:\"consultar ventas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:13;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:15:\"eliminar ventas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:13;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:13:\"editar ventas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:13;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:12:\"crear ventas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:13;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:25:\"consultar detalles ventas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:13;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:24:\"eliminar detalles ventas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:13;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:22:\"editar detalles ventas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:13;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:21:\"crear detalles ventas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:13;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:11:\"crear hojas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:15:\"consultar hojas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:12:\"editar hojas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:14:\"eliminar hojas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:23:\"crear hojas enfermerias\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:27:\"consultar hojas enfermerias\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:26:\"eliminar hojas enfermerias\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:26:\"crear solicitudes estudios\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:27:\"editar solicitudes estudios\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:30:\"consultar solicitudes estudios\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:29:\"eliminar solicitudes estudios\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:38:\"crear solicitudes estudios patologicos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:39:\"editar solicitudes estudios patologicos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:42:\"consultar solicitudes estudios patologicos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:41:\"eliminar solicitudes estudios patologicos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:24:\"crear documentos medicos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:28:\"consultar documentos medicos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:21:\"crear consentimientos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:16:\"consultar dietas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:6;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:12:\"crear dietas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:6;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:15:\"eliminar dietas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:6;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:13:\"editar dietas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:6;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:23:\"consultar base de datos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:23:\"respaldar base de datos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:23:\"restaurar base de datos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:31:\"consultar peticion medicamentos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:28:\"editar peticion medicamentos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:8;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:27:\"crear peticion medicamentos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:25:\"consultar peticion dietas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:6;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:22:\"editar peticion dietas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:6;}}}s:5:\"roles\";a:8:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:13:\"administrador\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:6:\"medico\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:19:\"medico especialista\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"enfermera(o)\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:12;s:1:\"b\";s:9:\"recepcion\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:13;s:1:\"b\";s:4:\"caja\";s:1:\"c\";s:3:\"web\";}i:6;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:6:\"cocina\";s:1:\"c\";s:3:\"web\";}i:7;a:3:{s:1:\"a\";i:8;s:1:\"b\";s:8:\"farmacia\";s:1:\"c\";s:3:\"web\";}}}',1771019264);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cargos`
--

DROP TABLE IF EXISTS `cargos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargos`
--

LOCK TABLES `cargos` WRITE;
/*!40000 ALTER TABLE `cargos` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `cargos` VALUES
(1,'Médico','Responsable de la atención médica primaria, diagnóstico inicial y derivación a especialistas.','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(2,'Médico Especialista','Profesional con formación avanzada en un área específica (ej. Cirugía, Cardiología, Pediatría).','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(3,'Licenciado(a) en Enfermería','Profesional universitario responsable de la planificación, ejecución y evaluación de los cuidados del paciente.','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(4,'Técnico(a) en Enfermería','Asiste al personal de enfermería en procedimientos, toma de signos vitales y cuidados básicos del paciente.','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(5,'Auxiliar de Enfermería','Apoya en tareas de cuidados básicos, movilización de pacientes, higiene, confort y alimentación.','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(6,'Técnico(a) Radiólogo(a)','Opera equipos de diagnóstico por imagen (Rayos X, Tomografías, etc.) y asiste en procedimientos.','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(7,'Técnico(a) de Laboratorio','Realiza la toma de muestras y el procesamiento de análisis clínicos solicitados.','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(8,'Fisioterapeuta','Profesional encargado de la rehabilitación física, terapia y recuperación funcional de pacientes.','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(9,'Auxiliar de Farmacia','Asiste al farmacéutico en la dispensación de medicamentos, control de inventario y preparación de dosis.','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(10,'Personal Administrativo','Encargado de admisiones, gestión de citas, expedientes clínicos y atención al público.','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(11,'Personal de Cocina','Responsable de la preparación de alimentos y dietas específicas para pacientes según prescripción.','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(12,'Personal de Mantenimiento','Encargado de la reparación y mantenimiento preventivo de las instalaciones y equipo general.','2026-02-12 21:46:56','2026-02-12 21:46:56');
/*!40000 ALTER TABLE `cargos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `catalogo_dietas`
--

DROP TABLE IF EXISTS `catalogo_dietas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `catalogo_dietas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_dieta` varchar(255) NOT NULL,
  `opcion_nombre` varchar(255) NOT NULL,
  `es_apto_diabetico` tinyint(1) NOT NULL DEFAULT 1,
  `es_apto_celiaco` tinyint(1) NOT NULL DEFAULT 1,
  `es_apto_hipertenso` tinyint(1) NOT NULL DEFAULT 1,
  `es_apto_colecisto` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogo_dietas`
--

LOCK TABLES `catalogo_dietas` WRITE;
/*!40000 ALTER TABLE `catalogo_dietas` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `catalogo_dietas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `catalogo_estudios`
--

DROP TABLE IF EXISTS `catalogo_estudios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `catalogo_estudios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` int(11) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo_estudio` varchar(255) NOT NULL,
  `departamento` varchar(255) NOT NULL,
  `tiempo_entrega` int(11) DEFAULT NULL,
  `costo` decimal(8,2) NOT NULL DEFAULT 0.01,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogo_estudios`
--

LOCK TABLES `catalogo_estudios` WRITE;
/*!40000 ALTER TABLE `catalogo_estudios` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `catalogo_estudios` VALUES
(1,NULL,'BIOMETRIA HEMATICA','Laboratorio','Hematología',1,110.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(2,NULL,'VELOCIDAD DE SEDIMENTACIÓN GLOBULAR','Laboratorio','Hematología',1,80.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(3,NULL,'GRUPO SANGUINEO Y RH','Laboratorio','Hematología',1,80.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(4,NULL,'PRUEBA INMUNOLOGICA DE EMBARAZO (SANGRE U ORINA)','Laboratorio','Hematología',1,100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(5,NULL,'COOMBS DIRECTO','Laboratorio','Hematología',1,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(6,NULL,'COPROLOGICO','Laboratorio','Parasitología',1,400.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(7,NULL,'COPROPARASITOSCÓPICO','Laboratorio','Parasitología',1,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(8,NULL,'CITOLOGÍA DE MOCO FECAL','Laboratorio','Parasitología',1,180.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(9,NULL,'SANGRE OCULTA EN HECES','Laboratorio','Parasitología',1,200.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(10,NULL,'CALPROCTECTINA','Laboratorio','Parasitología',1,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(11,NULL,'PERFIL TIROIDEO BASICO','Laboratorio','Hormonas',1,650.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(12,NULL,'PERFIL TIROIDEO I','Laboratorio','Hormonas',1,790.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(13,NULL,'PERFIL GINECOLOGICO','Laboratorio','Hormonas',1,900.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(14,NULL,'PERFIL HORMONAL','Laboratorio','Hormonas',1,1390.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(15,NULL,'TESTOSTERONA','Laboratorio','Hormonas',1,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(16,NULL,'PROGESTERONA','Laboratorio','Hormonas',1,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(17,NULL,'PSA TOTAL','Laboratorio','Hormonas',1,320.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(18,NULL,'PSA LIBRE','Laboratorio','Hormonas',1,320.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(19,NULL,'ANTIGENO CARCINOEMBRIONARIO','Laboratorio','Hormonas',1,500.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(20,NULL,'CEA 15.3','Laboratorio','Hormonas',1,600.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(21,NULL,'CEA 19.9','Laboratorio','Hormonas',1,600.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(22,NULL,'CEA 125','Laboratorio','Hormonas',1,600.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(23,NULL,'ALFAFETOPROTEINAS','Laboratorio','Hormonas',1,504.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(24,NULL,'HGC HUMANA','Laboratorio','Hormonas',1,500.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(25,NULL,'INSULINA','Laboratorio','Hormonas',1,480.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(26,NULL,'PERFIL DE MARCADORES TUMORALES BASICO (HGC, AFP, CEA)','Laboratorio','Hormonas',1,890.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(27,NULL,'HEMOGLOBINA GLICOSILADA','Laboratorio','Química clínica',1,422.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(28,NULL,'GLUCOSA','Laboratorio','Química clínica',1,70.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(29,NULL,'UREA','Laboratorio','Química clínica',1,90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(30,NULL,'CREATININA','Laboratorio','Química clínica',1,140.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(31,NULL,'ACIDO URICO','Laboratorio','Química clínica',1,160.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(32,NULL,'COLESTEROL','Laboratorio','Química clínica',1,120.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(33,NULL,'TRIGLICERIDOS','Laboratorio','Química clínica',1,120.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(34,NULL,'COLESTEROL HDL','Laboratorio','Química clínica',1,190.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(35,NULL,'QUIMICA SANGUINEA DE 6 ELEMENTOS','Laboratorio','Química clínica',1,300.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(36,NULL,'QUIMICA SANGUINEA DE 12 ELEMENTOS','Laboratorio','Química clínica',1,420.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(37,NULL,'QUIMICA SANGUINEA DE 28 ELEMENTOS','Laboratorio','Química clínica',1,750.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(38,NULL,'QUIMICA SANGUINEA DE 30 ELEMENTOS','Laboratorio','Química clínica',1,850.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(39,NULL,'QUIMICA SANGUINEA DE 35 ELEMENTOS','Laboratorio','Química clínica',1,900.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(40,NULL,'QUIMICA SANGUINEA DE 50 ELEMENTOS','Laboratorio','Química clínica',1,1580.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(41,NULL,'PRUEBAS DE FUNCIONAMIENTO HEPATICO','Laboratorio','Química clínica',2,450.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(42,NULL,'BILIRRUBINAS','Laboratorio','Química clínica',1,300.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(43,NULL,'ASPARTATO AMINOTRANSFERASA AST','Laboratorio','Química clínica',1,130.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(44,NULL,'ALANINAMINONSTRANSFERASA ALT','Laboratorio','Química clínica',1,130.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(45,NULL,'PROTEINAS TOTALES','Laboratorio','Química clínica',1,150.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(46,NULL,'ALBUMINA','Laboratorio','Química clínica',1,185.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(47,NULL,'LACTATO DESHIDROGENASA LDH','Laboratorio','Química clínica',1,190.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(48,NULL,'FOSFATASA ALCALINA ALP','Laboratorio','Química clínica',1,190.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(49,NULL,'GAMMA GLUTAMILTRANSPEPTIDASA GGT','Laboratorio','Química clínica',1,220.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(50,NULL,'CLORO','Laboratorio','Química clínica',1,350.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(51,NULL,'SODIO','Laboratorio','Química clínica',1,350.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(52,NULL,'POTASIO','Laboratorio','Química clínica',1,350.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(53,NULL,'CALCIO','Laboratorio','Química clínica',1,120.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(54,NULL,'FOSFORO','Laboratorio','Química clínica',1,120.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(55,NULL,'MAGNESIO','Laboratorio','Química clínica',1,120.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(56,NULL,'DIMERO D','Laboratorio','Química clínica',1,803.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(57,NULL,'FERRITINA','Laboratorio','Química clínica',1,420.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(58,NULL,'CREATINFOSFOQUINASA','Laboratorio','Química clínica',1,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(59,NULL,'FRACCIÓN MB','Laboratorio','Química clínica',1,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(60,NULL,'AMILASA','Laboratorio','Química clínica',1,150.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(61,NULL,'LIPASA','Laboratorio','Química clínica',1,180.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(62,NULL,'ELECTROLITOS SERICOS 3','Laboratorio','Química clínica',1,350.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(63,NULL,'ELECTROLITOS SERICOS 6','Laboratorio','Química clínica',1,450.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(64,NULL,'CULTIVO DE EXUDADO FARINGEO','Laboratorio','Bacterología',3,400.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(65,NULL,'CULTIVO DE EXUDADO NASAL','Laboratorio','Bacterología',3,400.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(66,NULL,'CULTIVO DE EXUDADO VAGINAL','Laboratorio','Bacterología',3,400.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(67,NULL,'UROCULTIVO','Laboratorio','Bacterología',3,400.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(68,NULL,'COPROCULTIVO','Laboratorio','Bacterología',3,500.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(69,NULL,'CITOLOGIA DE MOCO NASAL','Laboratorio','Bacterología',1,220.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(70,NULL,'EXAMEN GENERAL DE ORINA','Laboratorio','Uroanálisis',1,80.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(71,NULL,'DEPURACION DE CREATININA 24 HRS','Laboratorio','Uroanálisis',1,250.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(72,NULL,'PERFIL DE DROGAS 3 (MARIH, COC, AMPHET)','Laboratorio','Uroanálisis',1,340.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(73,NULL,'PERFIL DE DROGAS 5 (OPI, COC, AMP, MET, THC)','Laboratorio','Uroanálisis',1,560.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(74,NULL,'CONCENTRACIÓN ESPERMATICA','Laboratorio','Seminograma',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(75,NULL,'MOTILIDAD','Laboratorio','Seminograma',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(76,NULL,'MORFOLOGIA','Laboratorio','Seminograma',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(77,NULL,'VITALIDAD ESPERMATICA','Laboratorio','Seminograma',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(78,NULL,'ESPERMATOBIOSCOPIA','Laboratorio','Seminograma',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(79,NULL,'SEMINOGRAMA','Laboratorio','Seminograma',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(80,NULL,'PERFIL DE TIEMPOS DE COAGULACIÓN (TP, TTP, INR)','Laboratorio','Coagulación',1,350.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(81,NULL,'ANTIESTRPETOLISINAS','Laboratorio','Otros estudios y/o perfiles',1,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(82,NULL,'FACTOR REUMATOIDE','Laboratorio','Otros estudios y/o perfiles',1,230.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(83,NULL,'PROTEINA C REACTIVA','Laboratorio','Otros estudios y/o perfiles',1,500.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(84,NULL,'REACCIONES FEBRILES','Laboratorio','Otros estudios y/o perfiles',1,210.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(85,NULL,'VDRL','Laboratorio','Otros estudios y/o perfiles',1,155.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(86,NULL,'HIV','Laboratorio','Otros estudios y/o perfiles',1,450.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(87,NULL,'COVID 19 + INFLUENZA AB','Laboratorio','Otros estudios y/o perfiles',1,450.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(88,NULL,'PAPANICOLAOU','Laboratorio','Otros estudios y/o perfiles',3,380.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(89,NULL,'PREOPERATORIOS DE RTU (QS6, BH, P. TIEMPOS)','Laboratorio','Otros estudios y/o perfiles',1,700.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(90,NULL,'PERFIL DE MEDICINA INTERNA (BH, QS6, PFH, ES6, AMI, LIP, T. COAGULACIÓN, GPO SANGUINEO)','Laboratorio','Otros estudios y/o perfiles',1,1340.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(91,NULL,'PERFIL DE HEPATITIS ABC RAPIDAS','Laboratorio','Otros estudios y/o perfiles',1,1990.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(92,NULL,'INDICE HOMA','Laboratorio','Otros estudios y/o perfiles',1,550.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(93,NULL,'PERFIL PRENATAL (BH, QS6, VDRL, HIV, EGO, GRUPO Y RH)','Laboratorio','Otros estudios y/o perfiles',1,750.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(94,NULL,'PERFIL DE LIPIDOS','Laboratorio','Otros estudios y/o perfiles',1,400.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(95,NULL,'CURVA DE TOLERANCIA A LA GLUCOSA','Laboratorio','Otros estudios y/o perfiles',1,500.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(96,NULL,'GASOMETRIA ARTERIAL','Laboratorio','Otros estudios y/o perfiles',1,1550.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(97,NULL,'SIMPLE','Imagenología','Tomografía computada',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(98,NULL,'CONTRASTADA','Imagenología','Tomografía computada',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(99,NULL,'CRÁNEO','Imagenología','Tomografía computada',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(100,NULL,'SENOS PARANASALES','Imagenología','Tomografía computada',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(101,NULL,'LIMITADA A 8 CORTES','Imagenología','Tomografía computada',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(102,NULL,'TORÁX','Imagenología','Tomografía computada',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(103,NULL,'ABDÓMEN COMPLETO (INCLUYE PELVIS)','Imagenología','Tomografía computada',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(104,NULL,'ABDÓMEN  SUPERIOR','Imagenología','Tomografía computada',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(105,NULL,'UROTOMOGRAFÍA','Imagenología','Tomografía computada',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(106,NULL,'BARRIDO RENAL','Imagenología','Tomografía computada',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(107,NULL,'ANGIO TAC MPI','Imagenología','Tomografía computada',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(108,NULL,'PELVIS','Imagenología','Tomografía computada',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(109,NULL,'ANGIO TAC X REGIÓN','Imagenología','Tomografía computada',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(110,NULL,'SIMPLE','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(111,NULL,'CONTRASTADA','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(112,NULL,'CRÁNEO','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(113,NULL,'HIPÓFISIS','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(114,NULL,'COLUMNA CERVICAL','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(115,NULL,'COLUMNA DORSAL','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(116,NULL,'COLUMNA LUMBAR','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(117,NULL,'ABDÓMEN','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(118,NULL,'PELVIS','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(119,NULL,'ANGIORESONANCIA RENAL','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(120,NULL,'ANGIORESONANCIA DE ENCÉFALO','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(121,NULL,'ANGIO DE MIEMBROS  INFERIORES','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(122,NULL,'COLANGIORESONANCIA','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(123,NULL,'PELVIS GINECOLOGÍA (ÚTERO Y OVARIOS)','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(124,NULL,'MAMA','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(125,NULL,'OÍDOS','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(126,NULL,'ÓRBITAS','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(127,NULL,'ESPECTROSCOPÍA','Imagenología','Resonancia magnética',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(128,NULL,'PÉLVICO SUPRAPÚBICO','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(129,NULL,'PÉLVICO ENDOVAGINAL','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(130,NULL,'PROSTÁTICO TRANSRECTAL','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(131,NULL,'PROSTÁTICO SUPRAPÚBICO','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(132,NULL,'ABDÓMEN SUPERIOR','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(133,NULL,'ABDÓMEN COMPLETO','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(134,NULL,'MAMARIO','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(135,NULL,'HÍGADO Y VB','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(136,NULL,'RENAL','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(137,NULL,'VESICAL C/ ORINA RESIDUAL','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(138,NULL,'OBSTÉTRICO CONVENCIONAL','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(139,NULL,'4D','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(140,NULL,'ECOCARDIOGRAMA','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(141,NULL,'PARTES BLANDAS','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(142,NULL,'MÚSCULO ESQUELÉTICO','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(143,NULL,'TIROIDES','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(144,NULL,'ESTRUCTURAL','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(145,NULL,'CARÓTIDAS','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(146,NULL,'MIEMBROS SUPERIORES ARTERIAL','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(147,NULL,'MIEMBROS SUPERIORES VENOSO','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(148,NULL,'TESTICULAR','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(149,NULL,'OBSTÉTRICO','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(150,NULL,'MIEMBROS INFERIORES ARTERIAL','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(151,NULL,'MIEMBROS INFERIORES VENOSO','Imagenología','Ultrasonido',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(152,NULL,'TELE DE TÓRAX','Imagenología','Radiología general',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(153,NULL,'CRÁNEO AP Y LAT','Imagenología','Radiología general',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(154,NULL,'SENOS PARANASALES','Imagenología','Radiología general',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(155,NULL,'PERFILOGRAMA','Imagenología','Radiología general',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(156,NULL,'RODILLA A Y LAT','Imagenología','Radiología general',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(157,NULL,'COLUMNA CERVICAL AP Y LAT','Imagenología','Radiología general',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(158,NULL,'CEFALOPELVIMETRÍA','Imagenología','Radiología general',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(159,NULL,'SIMPLE DE ABDÓMEN','Imagenología','Radiología general',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(160,NULL,'PIÉ Y DE CÚBITO','Imagenología','Radiología general',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(161,NULL,'COLUMNA DORSAL AP Y LAT','Imagenología','Radiología general',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(162,NULL,'COLUMNA LUMBOSACRA AP Y LAT','Imagenología','Radiología general',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(163,NULL,'COLUMNA DORSOLUMBAR AP Y LAT','Imagenología','Radiología general',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(164,NULL,'MEDICIÓN DE MIEMBROS PÉLVICOS','Imagenología','Radiología general',NULL,0.00,'2026-02-12 21:47:02','2026-02-12 21:47:02');
/*!40000 ALTER TABLE `catalogo_estudios` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `catalogo_preguntas`
--

DROP TABLE IF EXISTS `catalogo_preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `catalogo_preguntas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(255) NOT NULL,
  `orden` int(11) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `permite_desconozco` tinyint(1) NOT NULL DEFAULT 0,
  `opciones_respuesta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`opciones_respuesta`)),
  `tipo_pregunta` varchar(255) NOT NULL DEFAULT 'simple',
  `campos_adicionales` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`campos_adicionales`)),
  `formulario_catalogo_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catalogo_preguntas_formulario_catalogo_id_foreign` (`formulario_catalogo_id`),
  CONSTRAINT `catalogo_preguntas_formulario_catalogo_id_foreign` FOREIGN KEY (`formulario_catalogo_id`) REFERENCES `formulario_catalogos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogo_preguntas`
--

LOCK TABLES `catalogo_preguntas` WRITE;
/*!40000 ALTER TABLE `catalogo_preguntas` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `catalogo_preguntas` VALUES
(1,'Obesidad',1,'heredo_familiares',0,NULL,'simple','[]',2),
(2,'Diabetes',2,'heredo_familiares',0,NULL,'simple','[]',2),
(3,'Cardiovasculares',3,'heredo_familiares',0,NULL,'simple','[]',2),
(4,'Neoplásicos (cáncer)',4,'heredo_familiares',0,NULL,'multiple_campos','[{\"name\":\"tipo\",\"label\":\"Tipo de c\\u00e1ncer\",\"type\":\"text\"},{\"name\":\"fecha\",\"label\":\"Fecha de diagn\\u00f3stico\",\"type\":\"month_unknown\"}]',2),
(5,'Hipertensión',5,'heredo_familiares',0,NULL,'simple','[]',2),
(6,'Psiquiátricos',6,'heredo_familiares',0,NULL,'simple','[]',2),
(7,'Epilepsia',7,'heredo_familiares',0,NULL,'simple','[]',2),
(8,'Reumáticos',8,'heredo_familiares',0,NULL,'multiple_campos','[{\"name\":\"tipo\",\"label\":\"Tipo\",\"type\":\"text\"},{\"name\":\"tiempo\",\"label\":\"\\u00bfDesde hace cu\\u00e1nto tiempo?\",\"type\":\"month_unknown\"}]',2),
(9,'Otros',9,'heredo_familiares',0,NULL,'simple','[]',2),
(10,'Alcoholismo',10,'no_patologicos',0,NULL,'multiple_campos','[{\"name\":\"tipo\",\"label\":\"Tipo de sustancia\",\"type\":\"text\"},{\"name\":\"frecuencia\",\"label\":\"Frecuencia (litros por semana)\",\"type\":\"text\"}]',2),
(11,'Tabaquismo',11,'no_patologicos',0,NULL,'multiple_campos','[{\"name\":\"frecuencia\",\"label\":\"Frecuencia (cajetillas por semana)\",\"type\":\"text\"}]',2),
(12,'Toxicomanías',12,'no_patologicos',0,NULL,'repetible','[{\"name\":\"tipo\",\"label\":\"Tipo de sustancia\",\"type\":\"text\"},{\"name\":\"frecuencia\",\"label\":\"Frecuencia (unidades por semana)\",\"type\":\"text\"}]',2),
(13,'Grupo Sanguíneo',13,'no_patologicos',0,'[{\"value\":\"Conozco\",\"label\":\"Conozco\",\"triggersFields\":true},{\"value\":\"Desconozco\",\"label\":\"Desconozco\",\"triggersFields\":false}]','multiple_campos','[{\"name\":\"grupo\",\"label\":\"Grupo\",\"type\":\"select\",\"options\":[\"A\",\"B\",\"AB\",\"O\"]}]',2),
(14,'RH',14,'no_patologicos',0,'[{\"value\":\"Conozco\",\"label\":\"Conozco\",\"triggersFields\":true},{\"value\":\"Desconozco\",\"label\":\"Desconozco\",\"triggersFields\":false}]','multiple_campos','[{\"name\":\"rh\",\"label\":\"Factor RH\",\"type\":\"select\",\"options\":[\"+\",\"-\"]}]',2),
(15,'Alergías',15,'no_patologicos',0,NULL,'simple','[]',2),
(16,'Actividad física',16,'no_patologicos',0,NULL,'multiple_campos','[{\"name\":\"tipo\",\"label\":\"tipo\",\"type\":\"text\"},{\"name\":\"frecuencia\",\"label\":\"Frecuencia (horas por semana)\",\"type\":\"text\"}]',2),
(17,'Consumo de medicamentos',17,'no_patologicos',0,NULL,'simple','[]',2),
(18,'Quirúrgicos',18,'a_patologicos',0,NULL,'repetible','[{\"name\":\"cirugia\",\"label\":\"Tipo de cirug\\u00eda\",\"type\":\"text\"},{\"name\":\"tiempo\",\"label\":\"Hace cu\\u00e1nto tiempo\",\"type\":\"month_unknown\"}]',2),
(19,'Infecciones',19,'a_patologicos',0,NULL,'multiple_campos','[{\"name\":\"control\",\"label\":\"\\u00bfCon qu\\u00e9 se controla?\",\"type\":\"text\"},{\"name\":\"tiempo\",\"label\":\"Desde hace cu\\u00e1nto tiempo\",\"type\":\"month_unknown\"}]',2),
(20,'Diabetes',20,'a_patologicos',0,NULL,'multiple_campos','[{\"name\":\"control\",\"label\":\"\\u00bfCon qu\\u00e9 se controla?\",\"type\":\"text\"},{\"name\":\"tiempo\",\"label\":\"Desde hace cu\\u00e1nto tiempo\",\"type\":\"month_unknown\"}]',2),
(21,'Hipertensión',21,'a_patologicos',0,NULL,'multiple_campos','[{\"name\":\"control\",\"label\":\"\\u00bfCon qu\\u00e9 se controla?\",\"type\":\"text\"},{\"name\":\"tiempo\",\"label\":\"Desde hace cu\\u00e1nto tiempo\",\"type\":\"month_unknown\"}]',2),
(22,'Transfusionales',22,'a_patologicos',0,NULL,'multiple_campos','[{\"name\":\"tiempo\",\"label\":\"Hace cu\\u00e1nto tiempo\",\"type\":\"text\"},{\"name\":\"aplicacion\",\"label\":\"\\u00bfQu\\u00e9 se aplic\\u00f3?\",\"type\":\"select\",\"options\":[\"Plaquetas\",\"Plasma\",\"Paquete globular (Sangre)\"]}]',2),
(23,'VIH',23,'a_patologicos',0,NULL,'multiple_campos','[{\"name\":\"adquisicion\",\"label\":\"Tipo de adquisici\\u00f3n\",\"type\":\"select\",\"options\":[\"Adquirido\",\"Cong\\u00e9nito (heredado)\"]},{\"name\":\"tiempo\",\"label\":\"Desde hace cu\\u00e1nto tiempo (si fue adquirido)\",\"type\":\"text\",\"dependsOn\":\"adquisicion\",\"dependsValue\":\"Adquirido\"},{\"name\":\"control\",\"label\":\"\\u00bfSe controla?\",\"type\":\"select\",\"options\":[\"Si\",\"No\"]},{\"name\":\"medicamento\",\"label\":\"Medicamento(s)\",\"type\":\"text\",\"dependsOn\":\"control\",\"dependsValue\":\"Si\"}]',2),
(24,'Neoplásicos (cáncer)',24,'a_patologicos',0,NULL,'multiple_campos','[{\"name\":\"tipo\",\"label\":\"Tipo de c\\u00e1ncer\",\"type\":\"text\"},{\"name\":\"fecha\",\"label\":\"Fecha de diagn\\u00f3stico\",\"type\":\"month_unknown\"}]',2),
(25,'Reumáticos',25,'a_patologicos',0,NULL,'multiple_campos','[{\"name\":\"tipo\",\"label\":\"Especificar\",\"type\":\"text\"},{\"name\":\"fecha\",\"label\":\"Desde hace cu\\u00e1nto tiempo\",\"type\":\"month_unknown\"}]',2),
(26,'Otro',26,'a_patologicos',0,NULL,'simple','[]',2),
(27,'Gesta',27,'gineco_obstetrico',0,NULL,'multiple_campos','[{\"name\":\"cantidad\",\"label\":\"N\\u00famero\",\"type\":\"number\"}]',2),
(28,'Partos',28,'gineco_obstetrico',0,NULL,'multiple_campos','[{\"name\":\"cantidad\",\"label\":\"N\\u00famero\",\"type\":\"number\"}]',2),
(29,'Abortos',29,'gineco_obstetrico',0,NULL,'multiple_campos','[{\"name\":\"cantidad\",\"label\":\"N\\u00famero de abortos\",\"type\":\"number\"},{\"name\":\"causa\",\"label\":\"Causa del aborto\",\"type\":\"text\"}]',2),
(30,'Cesáreas',30,'gineco_obstetrico',0,NULL,'multiple_campos','[{\"name\":\"cantidad\",\"label\":\"N\\u00famero\",\"type\":\"number\"},{\"name\":\"razon\",\"label\":\"Raz\\u00f3n de ces\\u00e1reas\",\"type\":\"text\"}]',2),
(31,'Menarca',31,'gineco_obstetrico',0,NULL,'multiple_campos','[{\"name\":\"cantidad\",\"label\":\"Edad del primer ciclo menstrual\",\"type\":\"number\"}]',2),
(32,'Ritmo',32,'gineco_obstetrico',0,NULL,'multiple_campos','[{\"name\":\"ritmo\",\"label\":\"Ritmo\",\"type\":\"select\",\"options\":[\"Regular\",\"Irregular\",\"Amenorrea\"]}]',2),
(33,'Inicio de Vida Sexual Activa',33,'gineco_obstetrico',0,NULL,'multiple_campos','[{\"name\":\"fecha\",\"label\":\"Edad de inicio\",\"type\":\"number\"}]',2),
(34,'Fecha de Última Menstruación',34,'gineco_obstetrico',0,NULL,'multiple_campos','[{\"name\":\"fecha\",\"label\":\"Fecha de inicio\",\"type\":\"date\"}]',2),
(35,'Fecha de Último Papanicolaou',35,'gineco_obstetrico',0,NULL,'multiple_campos','[{\"name\":\"fecha\",\"label\":\"Fecha\",\"type\":\"month_unknown\"},{\"name\":\"alteraciones\",\"label\":\"Alteraciones\",\"type\":\"text\"}]',2),
(36,'Control de Natalidad',36,'gineco_obstetrico',0,NULL,'multiple_campos','[{\"name\":\"consultas\",\"label\":\"\\u00bfA cu\\u00e1ntas consultas asisti\\u00f3?\",\"type\":\"number\"},{\"name\":\"trimestre\",\"label\":\"\\u00bfA partir de qu\\u00e9 trimestre?\",\"type\":\"number\"}]',2),
(37,'Otros',37,'gineco_obstetrico',0,NULL,'simple','[]',2),
(38,'Cráneo',38,'exploracion_fisica',0,NULL,'simple','[]',2),
(39,'Cara',39,'exploracion_fisica',0,NULL,'simple','[]',2),
(40,'Reflejos pupilares',40,'exploracion_fisica',0,NULL,'simple','[]',2),
(41,'Fondo de ojo',41,'exploracion_fisica',0,NULL,'simple','[]',2),
(42,'Nariz',42,'exploracion_fisica',0,NULL,'simple','[]',2),
(43,'Boca',43,'exploracion_fisica',0,NULL,'simple','[]',2),
(44,'Amígdalas',44,'exploracion_fisica',0,NULL,'simple','[]',2),
(45,'Oídos',45,'exploracion_fisica',0,NULL,'simple','[]',2),
(46,'Cuello',46,'exploracion_fisica',0,NULL,'simple','[]',2),
(47,'Adenomegalias',47,'exploracion_fisica',0,NULL,'simple','[]',2),
(48,'Pulsos carotídeos',48,'exploracion_fisica',0,NULL,'simple','[]',2),
(49,'Tiroides',49,'exploracion_fisica',0,NULL,'simple','[]',2),
(50,'Tórax',50,'exploracion_fisica',0,NULL,'simple','[]',2),
(51,'Glándulas mamarias',51,'exploracion_fisica',0,NULL,'simple','[]',2),
(52,'Abdomen',52,'exploracion_fisica',0,NULL,'simple','[]',2),
(53,'Hernias',53,'exploracion_fisica',0,NULL,'simple','[]',2),
(54,'Visceromegalías',54,'exploracion_fisica',0,NULL,'simple','[]',2),
(55,'Genitales',55,'exploracion_fisica',0,NULL,'simple','[]',2),
(56,'Columna',56,'exploracion_fisica',0,NULL,'simple','[]',2),
(57,'Pelvis',57,'exploracion_fisica',0,NULL,'simple','[]',2),
(58,'Extremidades superiores',58,'exploracion_fisica',0,NULL,'simple','[]',2),
(59,'Hombro',59,'exploracion_fisica',0,NULL,'simple','[]',2),
(60,'Codo',60,'exploracion_fisica',0,NULL,'simple','[]',2),
(61,'Muñeca y mano',61,'exploracion_fisica',0,NULL,'simple','[]',2),
(62,'Extremidades inferiores',62,'exploracion_fisica',0,NULL,'simple','[]',2),
(63,'Cadera',63,'exploracion_fisica',0,NULL,'simple','[]',2),
(64,'Rodilla',64,'exploracion_fisica',0,NULL,'simple','[]',2),
(65,'Tobillo y pie',65,'exploracion_fisica',0,NULL,'simple','[]',2),
(66,'Reflejos osteotendinosos',66,'exploracion_fisica',0,NULL,'simple','[]',2),
(67,'Piel y faneros',67,'exploracion_fisica',0,NULL,'simple','[]',2),
(68,'Otros',68,'exploracion_fisica',0,NULL,'simple','[]',2);
/*!40000 ALTER TABLE `catalogo_preguntas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `catalogo_via_administracions`
--

DROP TABLE IF EXISTS `catalogo_via_administracions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `catalogo_via_administracions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `via_administracion` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogo_via_administracions`
--

LOCK TABLES `catalogo_via_administracions` WRITE;
/*!40000 ALTER TABLE `catalogo_via_administracions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `catalogo_via_administracions` VALUES
(1,'INTRAMUSCULAR','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(2,'INTRAARTICULAR','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(3,'NASAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(4,'INTRAVENOSA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(5,'SUBCUTÁNEA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(6,'INHALATORIA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(7,'EPIDURAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(8,'INFILTRACIÓN TRONCULAR','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(9,'PERIDURAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(10,'RETROBULBAR','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(11,'SUBARACNOIDEA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(12,'ORAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(13,'INTRALESIONAL Y TEJIDOS BLANDOS','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(14,'BUCAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(15,'INTRAARTERIAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(16,'TÓPICA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(17,'TRONCULAR','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(18,'INTRALESIONAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(19,'INFILTRACIÓN LOCAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(20,'BLOQUEO REGIONAL/TRONCULAR','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(21,'INTRATECAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(22,'INTRAPERITONEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(23,'OFTÁLMICA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(24,'DÉRMICA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(25,'INTRAUTERINA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(26,'CUTÁNEA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(27,'RECTAL','2026-02-12 21:46:57','2026-02-12 21:46:57');
/*!40000 ALTER TABLE `catalogo_via_administracions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `categoria_dietas`
--

DROP TABLE IF EXISTS `categoria_dietas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria_dietas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `categoria` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria_dietas`
--

LOCK TABLES `categoria_dietas` WRITE;
/*!40000 ALTER TABLE `categoria_dietas` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `categoria_dietas` VALUES
(1,'Dieta de liquidos claros','2026-02-12 21:47:02','2026-02-12 21:47:02'),
(2,'Dieta blanda - Desayuno','2026-02-12 21:47:02','2026-02-12 21:47:02'),
(3,'Dieta blanda - Comida','2026-02-12 21:47:02','2026-02-12 21:47:02'),
(4,'Dieta blanda - Cena','2026-02-12 21:47:02','2026-02-12 21:47:02'),
(5,'Dieta para paciente diabético','2026-02-12 21:47:02','2026-02-12 21:47:02'),
(6,'Dieta para paciente celiaco','2026-02-12 21:47:02','2026-02-12 21:47:02'),
(7,'Dieta para paciente oncológico','2026-02-12 21:47:02','2026-02-12 21:47:02');
/*!40000 ALTER TABLE `categoria_dietas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `check_list_items`
--

DROP TABLE IF EXISTS `check_list_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `check_list_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nota_type` varchar(255) NOT NULL,
  `nota_id` bigint(20) unsigned NOT NULL,
  `section_id` varchar(255) NOT NULL,
  `task_index` int(11) NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_task_item` (`nota_id`,`nota_type`,`section_id`,`task_index`),
  KEY `check_list_items_nota_type_nota_id_index` (`nota_type`,`nota_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `check_list_items`
--

LOCK TABLES `check_list_items` WRITE;
/*!40000 ALTER TABLE `check_list_items` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `check_list_items` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `consentimientos`
--

DROP TABLE IF EXISTS `consentimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `consentimientos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `estancia_id` bigint(20) unsigned DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `route_pdf` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consentimientos_estancia_id_foreign` (`estancia_id`),
  KEY `consentimientos_user_id_foreign` (`user_id`),
  CONSTRAINT `consentimientos_estancia_id_foreign` FOREIGN KEY (`estancia_id`) REFERENCES `estancias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `consentimientos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consentimientos`
--

LOCK TABLES `consentimientos` WRITE;
/*!40000 ALTER TABLE `consentimientos` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `consentimientos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `credencial_empleados`
--

DROP TABLE IF EXISTS `credencial_empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `credencial_empleados` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `cedula_profesional` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `credencial_empleados_user_id_foreign` (`user_id`),
  CONSTRAINT `credencial_empleados_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credencial_empleados`
--

LOCK TABLES `credencial_empleados` WRITE;
/*!40000 ALTER TABLE `credencial_empleados` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `credencial_empleados` VALUES
(1,2,'Licenciatura en Enfermería','7654321','2026-02-12 21:46:58','2026-02-12 21:46:58'),
(2,6,'Médico Especialista en Cirugía General','9123456','2026-02-12 21:46:58','2026-02-12 21:46:58'),
(3,6,'Médico Especialista en Pediatría','8765432','2026-02-12 21:46:58','2026-02-12 21:46:58'),
(4,9,'Médico Especialista en Pediatría','8765432','2026-02-12 21:46:59','2026-02-12 21:46:59');
/*!40000 ALTER TABLE `credencial_empleados` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `detalle_ventas`
--

DROP TABLE IF EXISTS `detalle_ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_ventas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_producto_servicio` varchar(255) DEFAULT NULL,
  `precio_unitario` decimal(8,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `descuento` decimal(8,2) DEFAULT NULL,
  `estado` varchar(255) NOT NULL,
  `iva_aplicado` decimal(8,2) NOT NULL,
  `venta_id` bigint(20) unsigned NOT NULL,
  `itemable_type` varchar(255) DEFAULT NULL,
  `itemable_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detalle_ventas_venta_id_foreign` (`venta_id`),
  KEY `detalle_ventas_itemable_type_itemable_id_index` (`itemable_type`,`itemable_id`),
  CONSTRAINT `detalle_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_ventas`
--

LOCK TABLES `detalle_ventas` WRITE;
/*!40000 ALTER TABLE `detalle_ventas` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `detalle_ventas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `dietas`
--

DROP TABLE IF EXISTS `dietas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dietas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `categoria_dieta_id` bigint(20) unsigned NOT NULL,
  `alimento` text NOT NULL,
  `costo` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dietas_categoria_dieta_id_foreign` (`categoria_dieta_id`),
  CONSTRAINT `dietas_categoria_dieta_id_foreign` FOREIGN KEY (`categoria_dieta_id`) REFERENCES `categoria_dietas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dietas`
--

LOCK TABLES `dietas` WRITE;
/*!40000 ALTER TABLE `dietas` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `dietas` VALUES
(1,1,'1 pieza de gelatina de sabor: piña, limón, manzana, uva (sujeto a disponibilidad). 1 vaso de té de manzanilla sin añadir azúcar de 250 ml. 1 vaso de jugo de manzana diluido (125 ml de agua y 125 ml de jugo). 1 vaso de agua natural de 250 ml.',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(2,2,'Omelette de espinacas con queso panela',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(3,2,'Waffles de avena con miel y fruta',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(4,2,'Huevo a la mexicana sin picante',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(5,2,'Huevo revuelto con jamón de pavo',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(6,2,'Caldito de verduras con pollo deshebrado',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(7,3,'Pechuga asada con verduras al vapor',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(8,3,'Caldito de verduras con pollo deshebrado',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(9,3,'Fajitas de pollo con zanahoria, cebolla y queso panela en cubos',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(10,3,'Rollitos de pechuga rellenas de calabacitas o zanahoria fileteadas en caldillo de jitomate',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(11,3,'Consomé sin verduras ni pollo (paciente bichectomía)',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(12,4,'Huevo revuelto con jamón de pavo',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(13,4,'Waffles de avena con miel y fruta',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(14,4,'2 quesadillas de queso panela (con tortillas de maíz)',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(15,4,'Sándwich de jamón de pavo (pan integral)',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(16,4,'Huevo a la mexicana sin picante',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(17,5,'Omelette de espinacas o champiñones con queso panela',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(18,5,'Huevo revuelto con jamón de pavo o huevo a la mexicana sin picante',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(19,5,'Pechuga asada con guarnición de verduras al vapor',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(20,5,'Sándwich de pollo deshebrado con queso panela y verdura (usar pan integral)',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(21,5,'Caldito de verduras con pollo deshebrado',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(22,6,'2 quesadillas de queso panela (con tortillas de maíz)',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(23,6,'Omelette de espinacas con queso panela',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(24,6,'Pechuga asada con guarnición de verduras al vapor',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(25,6,'Rollitos de pechuga rellenas de calabacitas o zanahoria fileteadas en caldillo de jitomate',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(26,6,'Caldito de verduras con pollo deshebrado',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(27,7,'Frutas hervidas (manzana y pera), opcional retirar la cáscara',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(28,7,'Papilla de verduras cocidas con pollo deshebrado',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(29,7,'Fajitas de pollo con zanahoria, cebolla y queso panela en cubos',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(30,7,'Huevo revuelto con jamón de pavo o huevo a la mexicana sin picante',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(31,7,'2 quesadillas de queso panela (con tortillas de maíz)',100.00,'2026-02-12 21:47:02','2026-02-12 21:47:02');
/*!40000 ALTER TABLE `dietas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `dispositivo_pacientes`
--

DROP TABLE IF EXISTS `dispositivo_pacientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dispositivo_pacientes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `estancia_id` bigint(20) unsigned NOT NULL,
  `tipo_dispositivo` varchar(255) NOT NULL,
  `calibre` varchar(255) DEFAULT NULL,
  `fecha_instalacion` datetime NOT NULL,
  `fecha_colocacion` datetime NOT NULL,
  `observaciones` text DEFAULT NULL,
  `usuario_instalo_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dispositivo_pacientes_estancia_id_foreign` (`estancia_id`),
  KEY `dispositivo_pacientes_usuario_instalo_id_foreign` (`usuario_instalo_id`),
  CONSTRAINT `dispositivo_pacientes_estancia_id_foreign` FOREIGN KEY (`estancia_id`) REFERENCES `estancias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dispositivo_pacientes_usuario_instalo_id_foreign` FOREIGN KEY (`usuario_instalo_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispositivo_pacientes`
--

LOCK TABLES `dispositivo_pacientes` WRITE;
/*!40000 ALTER TABLE `dispositivo_pacientes` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `dispositivo_pacientes` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `encuesta_satisfaccions`
--

DROP TABLE IF EXISTS `encuesta_satisfaccions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `encuesta_satisfaccions` (
  `id` bigint(20) unsigned NOT NULL,
  `atencion_recpcion` int(11) NOT NULL,
  `trato_personal_enfermeria` int(11) NOT NULL,
  `limpieza_comodidad_habitacion` int(11) NOT NULL,
  `calidad_comida` int(11) NOT NULL,
  `tiempo_atencion` int(11) NOT NULL,
  `informacion_tratamiento` int(11) NOT NULL,
  `atencion_nutricional` tinyint(1) NOT NULL,
  `comentarios` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `encuesta_satisfaccions_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encuesta_satisfaccions`
--

LOCK TABLES `encuesta_satisfaccions` WRITE;
/*!40000 ALTER TABLE `encuesta_satisfaccions` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `encuesta_satisfaccions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `estancias`
--

DROP TABLE IF EXISTS `estancias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `estancias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `folio` varchar(255) NOT NULL,
  `paciente_id` bigint(20) unsigned NOT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `fecha_egreso` datetime DEFAULT NULL,
  `habitacion_id` bigint(20) unsigned DEFAULT NULL,
  `tipo_estancia` enum('Interconsulta','Hospitalizacion') NOT NULL,
  `modalidad_ingreso` varchar(255) NOT NULL,
  `tipo_ingreso` varchar(255) NOT NULL,
  `estancia_anterior_id` bigint(20) unsigned DEFAULT NULL,
  `familiar_responsable_id` bigint(20) unsigned DEFAULT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `estancias_folio_unique` (`folio`),
  KEY `estancias_paciente_id_foreign` (`paciente_id`),
  KEY `estancias_habitacion_id_foreign` (`habitacion_id`),
  KEY `estancias_estancia_anterior_id_foreign` (`estancia_anterior_id`),
  KEY `estancias_familiar_responsable_id_foreign` (`familiar_responsable_id`),
  KEY `estancias_created_by_foreign` (`created_by`),
  KEY `estancias_updated_by_foreign` (`updated_by`),
  CONSTRAINT `estancias_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `estancias_estancia_anterior_id_foreign` FOREIGN KEY (`estancia_anterior_id`) REFERENCES `estancias` (`id`) ON DELETE SET NULL,
  CONSTRAINT `estancias_familiar_responsable_id_foreign` FOREIGN KEY (`familiar_responsable_id`) REFERENCES `familiar_responsables` (`id`) ON DELETE CASCADE,
  CONSTRAINT `estancias_habitacion_id_foreign` FOREIGN KEY (`habitacion_id`) REFERENCES `habitaciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `estancias_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `estancias_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estancias`
--

LOCK TABLES `estancias` WRITE;
/*!40000 ALTER TABLE `estancias` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `estancias` VALUES
(1,'12892025',1,'2025-09-28 10:00:00',NULL,NULL,'Interconsulta','Particular','Ingreso',NULL,1,7,NULL,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(2,'11282025',1,'2025-08-12 14:30:00','2025-08-20 09:00:00',2,'Hospitalizacion','Particular','Ingreso',1,2,7,NULL,'2026-02-12 21:47:02','2026-02-12 21:47:02');
/*!40000 ALTER TABLE `estancias` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `familiar_responsables`
--

DROP TABLE IF EXISTS `familiar_responsables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `familiar_responsables` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parentesco` varchar(255) NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `paciente_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `familiar_responsables_paciente_id_foreign` (`paciente_id`),
  CONSTRAINT `familiar_responsables_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `familiar_responsables`
--

LOCK TABLES `familiar_responsables` WRITE;
/*!40000 ALTER TABLE `familiar_responsables` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `familiar_responsables` VALUES
(1,'PADRE','JAIME ORTÍZ',1),
(2,'MADRE','MARÍA HERNÁNDEZ',1),
(3,'PADRE','PEDRO SOLÍS',2);
/*!40000 ALTER TABLE `familiar_responsables` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `formulario_catalogos`
--

DROP TABLE IF EXISTS `formulario_catalogos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `formulario_catalogos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_formulario` varchar(100) NOT NULL,
  `nombre_tabla_fisica` varchar(255) NOT NULL,
  `route_prefix` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formulario_catalogos`
--

LOCK TABLES `formulario_catalogos` WRITE;
/*!40000 ALTER TABLE `formulario_catalogos` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `formulario_catalogos` VALUES
(1,'Hoja frontal','hoja_frontales','hojasfrontales'),
(2,'Historia clínica','historia_clinicas','historiasclinicas'),
(3,'Interconsulta','interconsultas','interconsultas'),
(4,'Hoja de enfermería en hospitalización','hoja_enfermerias','hojasenfermerias'),
(5,'Traslados','traslados','traslados'),
(6,'Preoperatoria','preoperatorias','preoperatorias'),
(7,'Nota postoperatoria','nota_postoperatorias','notaspostoperatorias'),
(8,'Nota de urgencias','nota_urgencias','notasurgencias'),
(9,'Estudio anatomopatológico','solicitud_patologias','solicitudes-patologias'),
(10,'Nota de egreso','nota_egreso','notasegresos'),
(11,'Nota evolucion','nota_evoluciones','notasevoluciones'),
(12,'Nota pre-anestesica','nota_preanestecia','notaspreanestesicas'),
(13,'Nota postanestésica','nota_postanestesicas','notaspostanestesicas'),
(14,'Hoja de enfermeria en quirófano','hoja_enfermeria_quirofanos','hojasenfermeriasquirofanos'),
(15,'Solicitud de exámenes','solicitud_estudios','solicitudes-estudios'),
(16,'Encuesta satisfacción','encuesta_satisfacccions','encuesta-satifaccions');
/*!40000 ALTER TABLE `formulario_catalogos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `formulario_instancias`
--

DROP TABLE IF EXISTS `formulario_instancias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `formulario_instancias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_hora` datetime NOT NULL,
  `estancia_id` bigint(20) unsigned NOT NULL,
  `formulario_catalogo_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `formulario_instancias_estancia_id_foreign` (`estancia_id`),
  KEY `formulario_instancias_formulario_catalogo_id_foreign` (`formulario_catalogo_id`),
  KEY `formulario_instancias_user_id_foreign` (`user_id`),
  CONSTRAINT `formulario_instancias_estancia_id_foreign` FOREIGN KEY (`estancia_id`) REFERENCES `estancias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `formulario_instancias_formulario_catalogo_id_foreign` FOREIGN KEY (`formulario_catalogo_id`) REFERENCES `formulario_catalogos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `formulario_instancias_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formulario_instancias`
--

LOCK TABLES `formulario_instancias` WRITE;
/*!40000 ALTER TABLE `formulario_instancias` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `formulario_instancias` VALUES
(1,'2026-02-12 15:47:59',1,4,7,'2026-02-12 21:47:59','2026-02-12 21:47:59');
/*!40000 ALTER TABLE `formulario_instancias` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `habitacion_precios`
--

DROP TABLE IF EXISTS `habitacion_precios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `habitacion_precios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `habitacion_id` bigint(20) unsigned NOT NULL,
  `horario_inicio` time NOT NULL,
  `horario_fin` time NOT NULL,
  `precio` decimal(8,2) NOT NULL DEFAULT 100.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `habitacion_precios_habitacion_id_foreign` (`habitacion_id`),
  CONSTRAINT `habitacion_precios_habitacion_id_foreign` FOREIGN KEY (`habitacion_id`) REFERENCES `habitaciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `habitacion_precios`
--

LOCK TABLES `habitacion_precios` WRITE;
/*!40000 ALTER TABLE `habitacion_precios` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `habitacion_precios` VALUES
(1,1,'08:00:00','08:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(2,1,'08:30:00','09:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(3,1,'09:00:00','09:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(4,1,'09:30:00','10:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(5,1,'10:00:00','10:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(6,1,'10:30:00','11:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(7,1,'11:00:00','11:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(8,1,'11:30:00','12:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(9,1,'12:00:00','12:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(10,1,'12:30:00','13:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(11,1,'13:00:00','13:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(12,1,'13:30:00','14:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(13,1,'14:00:00','14:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(14,1,'14:30:00','15:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(15,1,'15:00:00','15:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(16,1,'15:30:00','16:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(17,1,'16:00:00','16:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(18,1,'16:30:00','17:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(19,1,'17:00:00','17:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(20,1,'17:30:00','18:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(21,1,'18:00:00','18:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(22,1,'18:30:00','19:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(23,1,'19:00:00','19:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(24,1,'19:30:00','20:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(25,1,'20:00:00','20:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(26,1,'20:30:00','21:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(27,1,'21:00:00','21:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(28,1,'21:30:00','22:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(29,1,'22:00:00','22:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(30,1,'22:30:00','23:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(31,2,'08:00:00','08:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(32,2,'08:30:00','09:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(33,2,'09:00:00','09:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(34,2,'09:30:00','10:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(35,2,'10:00:00','10:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(36,2,'10:30:00','11:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(37,2,'11:00:00','11:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(38,2,'11:30:00','12:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(39,2,'12:00:00','12:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(40,2,'12:30:00','13:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(41,2,'13:00:00','13:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(42,2,'13:30:00','14:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(43,2,'14:00:00','14:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(44,2,'14:30:00','15:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(45,2,'15:00:00','15:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(46,2,'15:30:00','16:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(47,2,'16:00:00','16:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(48,2,'16:30:00','17:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(49,2,'17:00:00','17:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(50,2,'17:30:00','18:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(51,2,'18:00:00','18:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(52,2,'18:30:00','19:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(53,2,'19:00:00','19:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(54,2,'19:30:00','20:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(55,2,'20:00:00','20:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(56,2,'20:30:00','21:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(57,2,'21:00:00','21:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(58,2,'21:30:00','22:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(59,2,'22:00:00','22:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(60,2,'22:30:00','23:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(61,3,'08:00:00','08:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(62,3,'08:30:00','09:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(63,3,'09:00:00','09:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(64,3,'09:30:00','10:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(65,3,'10:00:00','10:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(66,3,'10:30:00','11:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(67,3,'11:00:00','11:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(68,3,'11:30:00','12:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(69,3,'12:00:00','12:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(70,3,'12:30:00','13:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(71,3,'13:00:00','13:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(72,3,'13:30:00','14:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(73,3,'14:00:00','14:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(74,3,'14:30:00','15:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(75,3,'15:00:00','15:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(76,3,'15:30:00','16:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(77,3,'16:00:00','16:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(78,3,'16:30:00','17:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(79,3,'17:00:00','17:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(80,3,'17:30:00','18:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(81,3,'18:00:00','18:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(82,3,'18:30:00','19:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(83,3,'19:00:00','19:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(84,3,'19:30:00','20:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(85,3,'20:00:00','20:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(86,3,'20:30:00','21:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(87,3,'21:00:00','21:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(88,3,'21:30:00','22:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(89,3,'22:00:00','22:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(90,3,'22:30:00','23:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(91,4,'08:00:00','08:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(92,4,'08:30:00','09:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(93,4,'09:00:00','09:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(94,4,'09:30:00','10:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(95,4,'10:00:00','10:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(96,4,'10:30:00','11:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(97,4,'11:00:00','11:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(98,4,'11:30:00','12:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(99,4,'12:00:00','12:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(100,4,'12:30:00','13:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(101,4,'13:00:00','13:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(102,4,'13:30:00','14:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(103,4,'14:00:00','14:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(104,4,'14:30:00','15:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(105,4,'15:00:00','15:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(106,4,'15:30:00','16:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(107,4,'16:00:00','16:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(108,4,'16:30:00','17:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(109,4,'17:00:00','17:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(110,4,'17:30:00','18:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(111,4,'18:00:00','18:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(112,4,'18:30:00','19:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(113,4,'19:00:00','19:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(114,4,'19:30:00','20:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(115,4,'20:00:00','20:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(116,4,'20:30:00','21:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(117,4,'21:00:00','21:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(118,4,'21:30:00','22:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(119,4,'22:00:00','22:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(120,4,'22:30:00','23:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(121,5,'08:00:00','08:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(122,5,'08:30:00','09:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(123,5,'09:00:00','09:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(124,5,'09:30:00','10:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(125,5,'10:00:00','10:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(126,5,'10:30:00','11:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(127,5,'11:00:00','11:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(128,5,'11:30:00','12:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(129,5,'12:00:00','12:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(130,5,'12:30:00','13:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(131,5,'13:00:00','13:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(132,5,'13:30:00','14:00:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(133,5,'14:00:00','14:30:00',40.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(134,5,'14:30:00','15:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(135,5,'15:00:00','15:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(136,5,'15:30:00','16:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(137,5,'16:00:00','16:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(138,5,'16:30:00','17:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(139,5,'17:00:00','17:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(140,5,'17:30:00','18:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(141,5,'18:00:00','18:30:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(142,5,'18:30:00','19:00:00',75.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(143,5,'19:00:00','19:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(144,5,'19:30:00','20:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(145,5,'20:00:00','20:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(146,5,'20:30:00','21:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(147,5,'21:00:00','21:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(148,5,'21:30:00','22:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(149,5,'22:00:00','22:30:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(150,5,'22:30:00','23:00:00',50.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(151,6,'08:00:00','08:30:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(152,6,'08:30:00','09:00:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(153,6,'09:00:00','09:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(154,6,'09:30:00','10:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(155,6,'10:00:00','10:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(156,6,'10:30:00','11:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(157,6,'11:00:00','11:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(158,6,'11:30:00','12:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(159,6,'12:00:00','12:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(160,6,'12:30:00','13:00:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(161,6,'13:00:00','13:30:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(162,6,'13:30:00','14:00:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(163,6,'14:00:00','14:30:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(164,6,'14:30:00','15:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(165,6,'15:00:00','15:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(166,6,'15:30:00','16:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(167,6,'16:00:00','16:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(168,6,'16:30:00','17:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(169,6,'17:00:00','17:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(170,6,'17:30:00','18:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(171,6,'18:00:00','18:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(172,6,'18:30:00','19:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(173,6,'19:00:00','19:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(174,6,'19:30:00','20:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(175,6,'20:00:00','20:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(176,6,'20:30:00','21:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(177,6,'21:00:00','21:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(178,6,'21:30:00','22:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(179,6,'22:00:00','22:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(180,6,'22:30:00','23:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(181,7,'08:00:00','08:30:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(182,7,'08:30:00','09:00:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(183,7,'09:00:00','09:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(184,7,'09:30:00','10:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(185,7,'10:00:00','10:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(186,7,'10:30:00','11:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(187,7,'11:00:00','11:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(188,7,'11:30:00','12:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(189,7,'12:00:00','12:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(190,7,'12:30:00','13:00:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(191,7,'13:00:00','13:30:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(192,7,'13:30:00','14:00:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(193,7,'14:00:00','14:30:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(194,7,'14:30:00','15:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(195,7,'15:00:00','15:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(196,7,'15:30:00','16:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(197,7,'16:00:00','16:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(198,7,'16:30:00','17:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(199,7,'17:00:00','17:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(200,7,'17:30:00','18:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(201,7,'18:00:00','18:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(202,7,'18:30:00','19:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(203,7,'19:00:00','19:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(204,7,'19:30:00','20:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(205,7,'20:00:00','20:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(206,7,'20:30:00','21:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(207,7,'21:00:00','21:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(208,7,'21:30:00','22:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(209,7,'22:00:00','22:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(210,7,'22:30:00','23:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(211,8,'08:00:00','08:30:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(212,8,'08:30:00','09:00:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(213,8,'09:00:00','09:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(214,8,'09:30:00','10:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(215,8,'10:00:00','10:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(216,8,'10:30:00','11:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(217,8,'11:00:00','11:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(218,8,'11:30:00','12:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(219,8,'12:00:00','12:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(220,8,'12:30:00','13:00:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(221,8,'13:00:00','13:30:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(222,8,'13:30:00','14:00:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(223,8,'14:00:00','14:30:00',55.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(224,8,'14:30:00','15:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(225,8,'15:00:00','15:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(226,8,'15:30:00','16:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(227,8,'16:00:00','16:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(228,8,'16:30:00','17:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(229,8,'17:00:00','17:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(230,8,'17:30:00','18:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(231,8,'18:00:00','18:30:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(232,8,'18:30:00','19:00:00',90.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(233,8,'19:00:00','19:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(234,8,'19:30:00','20:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(235,8,'20:00:00','20:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(236,8,'20:30:00','21:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(237,8,'21:00:00','21:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(238,8,'21:30:00','22:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(239,8,'22:00:00','22:30:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02'),
(240,8,'22:30:00','23:00:00',65.00,'2026-02-12 21:47:02','2026-02-12 21:47:02');
/*!40000 ALTER TABLE `habitacion_precios` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `habitaciones`
--

DROP TABLE IF EXISTS `habitaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `habitaciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `identificador` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `estado` enum('Ocupado','Libre') NOT NULL DEFAULT 'Libre',
  `piso` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `habitaciones`
--

LOCK TABLES `habitaciones` WRITE;
/*!40000 ALTER TABLE `habitaciones` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `habitaciones` VALUES
(1,'Consultorio 1','Consultorio','Plan de Ayutla','Libre','Planta Ayutla'),
(2,'Consultorio 2','Consultorio','Plan de Ayutla','Libre','Planta baja'),
(3,'Consultorio 3','Consultorio','Plan de Ayutla','Libre','Planta baja'),
(4,'Consultorio 4','Consultorio','Plan de Ayutla','Libre','Planta baja'),
(5,'Consultorio 5','Consultorio','Plan de Ayutla','Libre','Planta baja'),
(6,'Consultorio 1','Consultorio','Gustavo Díaz Ordaz','Libre','Planta baja'),
(7,'Consultorio 2','Consultorio','Gustavo Díaz Ordaz','Libre','Planta baja'),
(8,'Consultorio 3','Consultorio','Gustavo Díaz Ordaz','Libre','Planta baja'),
(9,'Suit 1A','Habitación','Plan de Ayutla','Libre','Planta baja'),
(10,'Suit 1B','Habitación','Plan de Ayutla','Libre','Planta baja'),
(11,'Suit 2','Habitación','Plan de Ayutla','Libre','Planta Baja'),
(12,'Suit 3','Habitación','Plan de Ayutla','Libre','Planta Baja'),
(13,'Suit 4','Habitación','Plan de Ayutla','Libre','Planta Baja'),
(14,'Suit 5','Habitación','Plan de Ayutla','Libre','Planta Baja'),
(15,'Suit 6','Habitación','Plan de Ayutla','Libre','Planta Baja'),
(16,'Quirofano','Quirofano','Plan de Ayutla','Libre','Planta Alta');
/*!40000 ALTER TABLE `habitaciones` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `historia_clinicas`
--

DROP TABLE IF EXISTS `historia_clinicas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `historia_clinicas` (
  `id` bigint(20) unsigned NOT NULL,
  `padecimiento_actual` text NOT NULL,
  `tension_arterial` varchar(255) NOT NULL,
  `frecuencia_cardiaca` int(11) NOT NULL,
  `frecuencia_respiratoria` int(11) NOT NULL,
  `saturacion_oxigeno` int(11) DEFAULT NULL,
  `temperatura` double NOT NULL,
  `peso` double NOT NULL,
  `talla` int(11) NOT NULL,
  `resultados_previos` text NOT NULL,
  `diagnostico` text NOT NULL,
  `pronostico` text NOT NULL,
  `indicacion_terapeutica` text NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `historia_clinicas_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historia_clinicas`
--

LOCK TABLES `historia_clinicas` WRITE;
/*!40000 ALTER TABLE `historia_clinicas` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `historia_clinicas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `histories`
--

DROP TABLE IF EXISTS `histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `histories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL COMMENT 'El usuario que realizó la acción',
  `model_type` varchar(255) NOT NULL COMMENT 'El modelo que fue afectado (ej: App\\Models\\Product)',
  `model_id` bigint(20) unsigned NOT NULL COMMENT 'El ID del registro afectado',
  `action` varchar(255) NOT NULL COMMENT 'La acción realizada (created, updated, deleted)',
  `before` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Estado del modelo antes del cambio' CHECK (json_valid(`before`)),
  `after` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Estado del modelo después del cambio' CHECK (json_valid(`after`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `histories_model_type_model_id_index` (`model_type`,`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `histories`
--

LOCK TABLES `histories` WRITE;
/*!40000 ALTER TABLE `histories` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `histories` VALUES
(1,NULL,'App\\Models\\Paciente',1,'created',NULL,'\"{\\\"curp\\\":\\\"MARP850101HDFLRS01\\\",\\\"nombre\\\":\\\"Mar\\\\u00eda\\\",\\\"apellido_paterno\\\":\\\"Ram\\\\u00edrez\\\",\\\"apellido_materno\\\":\\\"L\\\\u00f3pez\\\",\\\"sexo\\\":\\\"Femenino\\\",\\\"fecha_nacimiento\\\":\\\"1985-01-01\\\",\\\"calle\\\":\\\"Av. Reforma\\\",\\\"numero_exterior\\\":\\\"123\\\",\\\"numero_interior\\\":\\\"2B\\\",\\\"colonia\\\":\\\"Centro\\\",\\\"municipio\\\":\\\"Cuauht\\\\u00e9moc\\\",\\\"estado\\\":\\\"Ciudad de M\\\\u00e9xico\\\",\\\"pais\\\":\\\"M\\\\u00e9xico\\\",\\\"cp\\\":\\\"06000\\\",\\\"telefono\\\":\\\"555-111-2233\\\",\\\"estado_civil\\\":\\\"Casado(a)\\\",\\\"ocupacion\\\":\\\"Contadora\\\",\\\"lugar_origen\\\":\\\"Ciudad de M\\\\u00e9xico\\\",\\\"nombre_padre\\\":\\\"Juan Ram\\\\u00edrez\\\",\\\"nombre_madre\\\":\\\"Elena L\\\\u00f3pez\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:56\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:56\\\",\\\"id\\\":1}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(2,NULL,'App\\Models\\Paciente',2,'created',NULL,'\"{\\\"curp\\\":\\\"LOPE900305HDFGNS02\\\",\\\"nombre\\\":\\\"Jos\\\\u00e9\\\",\\\"apellido_paterno\\\":\\\"L\\\\u00f3pez\\\",\\\"apellido_materno\\\":\\\"Gonz\\\\u00e1lez\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1990-03-05\\\",\\\"calle\\\":\\\"Calle Insurgentes\\\",\\\"numero_exterior\\\":\\\"456\\\",\\\"numero_interior\\\":null,\\\"colonia\\\":\\\"Roma Norte\\\",\\\"municipio\\\":\\\"Cuauht\\\\u00e9moc\\\",\\\"estado\\\":\\\"Ciudad de M\\\\u00e9xico\\\",\\\"pais\\\":\\\"M\\\\u00e9xico\\\",\\\"cp\\\":\\\"06700\\\",\\\"telefono\\\":\\\"555-222-3344\\\",\\\"estado_civil\\\":\\\"Soltero(a)\\\",\\\"ocupacion\\\":\\\"Ingeniero\\\",\\\"lugar_origen\\\":\\\"Puebla\\\",\\\"nombre_padre\\\":\\\"Carlos L\\\\u00f3pez\\\",\\\"nombre_madre\\\":\\\"Mar\\\\u00eda Gonz\\\\u00e1lez\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:56\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:56\\\",\\\"id\\\":2}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(3,NULL,'App\\Models\\Paciente',3,'created',NULL,'\"{\\\"curp\\\":\\\"FERL750712MMNGRZ03\\\",\\\"nombre\\\":\\\"Luc\\\\u00eda\\\",\\\"apellido_paterno\\\":\\\"Fern\\\\u00e1ndez\\\",\\\"apellido_materno\\\":\\\"Mart\\\\u00ednez\\\",\\\"sexo\\\":\\\"Femenino\\\",\\\"fecha_nacimiento\\\":\\\"1975-07-12\\\",\\\"calle\\\":\\\"Av. Morelos\\\",\\\"numero_exterior\\\":\\\"789\\\",\\\"numero_interior\\\":\\\"5A\\\",\\\"colonia\\\":\\\"Chapultepec\\\",\\\"municipio\\\":\\\"Morelia\\\",\\\"estado\\\":\\\"Michoac\\\\u00e1n\\\",\\\"pais\\\":\\\"M\\\\u00e9xico\\\",\\\"cp\\\":\\\"58000\\\",\\\"telefono\\\":\\\"555-333-4455\\\",\\\"estado_civil\\\":\\\"Divorciado(a)\\\",\\\"ocupacion\\\":\\\"Maestra\\\",\\\"lugar_origen\\\":\\\"Morelia\\\",\\\"nombre_padre\\\":\\\"Rafael Fern\\\\u00e1ndez\\\",\\\"nombre_madre\\\":\\\"Laura Mart\\\\u00ednez\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:56\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:56\\\",\\\"id\\\":3}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(4,NULL,'App\\Models\\Paciente',4,'created',NULL,'\"{\\\"curp\\\":\\\"GOME820914HGTPLD04\\\",\\\"nombre\\\":\\\"Pedro\\\",\\\"apellido_paterno\\\":\\\"G\\\\u00f3mez\\\",\\\"apellido_materno\\\":\\\"Paredes\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1982-09-14\\\",\\\"calle\\\":\\\"Av. Hidalgo\\\",\\\"numero_exterior\\\":\\\"101\\\",\\\"numero_interior\\\":null,\\\"colonia\\\":\\\"Centro\\\",\\\"municipio\\\":\\\"Guadalajara\\\",\\\"estado\\\":\\\"Jalisco\\\",\\\"pais\\\":\\\"M\\\\u00e9xico\\\",\\\"cp\\\":\\\"44100\\\",\\\"telefono\\\":\\\"555-444-5566\\\",\\\"estado_civil\\\":\\\"Union libre\\\",\\\"ocupacion\\\":\\\"Mec\\\\u00e1nico\\\",\\\"lugar_origen\\\":\\\"Guadalajara\\\",\\\"nombre_padre\\\":\\\"Manuel G\\\\u00f3mez\\\",\\\"nombre_madre\\\":\\\"Isabel Paredes\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:56\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:56\\\",\\\"id\\\":4}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(5,NULL,'App\\Models\\Paciente',5,'created',NULL,'\"{\\\"curp\\\":\\\"RUIE950221HNLTRS05\\\",\\\"nombre\\\":\\\"Elena\\\",\\\"apellido_paterno\\\":\\\"Ruiz\\\",\\\"apellido_materno\\\":\\\"Trevi\\\\u00f1o\\\",\\\"sexo\\\":\\\"Femenino\\\",\\\"fecha_nacimiento\\\":\\\"1995-02-21\\\",\\\"calle\\\":\\\"Calle Ju\\\\u00e1rez\\\",\\\"numero_exterior\\\":\\\"567\\\",\\\"numero_interior\\\":\\\"3C\\\",\\\"colonia\\\":\\\"Obrera\\\",\\\"municipio\\\":\\\"Monterrey\\\",\\\"estado\\\":\\\"Nuevo Le\\\\u00f3n\\\",\\\"pais\\\":\\\"M\\\\u00e9xico\\\",\\\"cp\\\":\\\"64000\\\",\\\"telefono\\\":\\\"555-555-6677\\\",\\\"estado_civil\\\":\\\"Soltero(a)\\\",\\\"ocupacion\\\":\\\"Dise\\\\u00f1adora\\\",\\\"lugar_origen\\\":\\\"Monterrey\\\",\\\"nombre_padre\\\":\\\"H\\\\u00e9ctor Ruiz\\\",\\\"nombre_madre\\\":\\\"Marta Trevi\\\\u00f1o\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:56\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:56\\\",\\\"id\\\":5}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(6,NULL,'App\\Models\\Paciente',6,'created',NULL,'\"{\\\"curp\\\":\\\"SANM700811HOCGRD06\\\",\\\"nombre\\\":\\\"Miguel\\\",\\\"apellido_paterno\\\":\\\"S\\\\u00e1nchez\\\",\\\"apellido_materno\\\":\\\"Morales\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1970-08-11\\\",\\\"calle\\\":\\\"Av. Independencia\\\",\\\"numero_exterior\\\":\\\"890\\\",\\\"numero_interior\\\":null,\\\"colonia\\\":\\\"Centro\\\",\\\"municipio\\\":\\\"Oaxaca de Ju\\\\u00e1rez\\\",\\\"estado\\\":\\\"Oaxaca\\\",\\\"pais\\\":\\\"M\\\\u00e9xico\\\",\\\"cp\\\":\\\"68000\\\",\\\"telefono\\\":\\\"555-666-7788\\\",\\\"estado_civil\\\":\\\"Viudo(a)\\\",\\\"ocupacion\\\":\\\"Carpintero\\\",\\\"lugar_origen\\\":\\\"Oaxaca\\\",\\\"nombre_padre\\\":\\\"Domingo S\\\\u00e1nchez\\\",\\\"nombre_madre\\\":\\\"Juana Morales\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:56\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:56\\\",\\\"id\\\":6}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(7,NULL,'App\\Models\\Habitacion',1,'created',NULL,'\"{\\\"identificador\\\":\\\"Consultorio 1\\\",\\\"tipo\\\":\\\"Consultorio\\\",\\\"estado\\\":\\\"Libre\\\",\\\"ubicacion\\\":\\\"Plan de Ayutla\\\",\\\"piso\\\":\\\"Planta Ayutla\\\",\\\"id\\\":1}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(8,NULL,'App\\Models\\Habitacion',2,'created',NULL,'\"{\\\"identificador\\\":\\\"Consultorio 2\\\",\\\"tipo\\\":\\\"Consultorio\\\",\\\"estado\\\":\\\"Libre\\\",\\\"ubicacion\\\":\\\"Plan de Ayutla\\\",\\\"piso\\\":\\\"Planta baja\\\",\\\"id\\\":2}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(9,NULL,'App\\Models\\Habitacion',3,'created',NULL,'\"{\\\"identificador\\\":\\\"Consultorio 3\\\",\\\"tipo\\\":\\\"Consultorio\\\",\\\"estado\\\":\\\"Libre\\\",\\\"ubicacion\\\":\\\"Plan de Ayutla\\\",\\\"piso\\\":\\\"Planta baja\\\",\\\"id\\\":3}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(10,NULL,'App\\Models\\Habitacion',4,'created',NULL,'\"{\\\"identificador\\\":\\\"Consultorio 4\\\",\\\"tipo\\\":\\\"Consultorio\\\",\\\"estado\\\":\\\"Libre\\\",\\\"ubicacion\\\":\\\"Plan de Ayutla\\\",\\\"piso\\\":\\\"Planta baja\\\",\\\"id\\\":4}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(11,NULL,'App\\Models\\Habitacion',5,'created',NULL,'\"{\\\"identificador\\\":\\\"Consultorio 5\\\",\\\"tipo\\\":\\\"Consultorio\\\",\\\"estado\\\":\\\"Libre\\\",\\\"ubicacion\\\":\\\"Plan de Ayutla\\\",\\\"piso\\\":\\\"Planta baja\\\",\\\"id\\\":5}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(12,NULL,'App\\Models\\Habitacion',6,'created',NULL,'\"{\\\"identificador\\\":\\\"Consultorio 1\\\",\\\"tipo\\\":\\\"Consultorio\\\",\\\"estado\\\":\\\"Libre\\\",\\\"ubicacion\\\":\\\"Gustavo D\\\\u00edaz Ordaz\\\",\\\"piso\\\":\\\"Planta baja\\\",\\\"id\\\":6}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(13,NULL,'App\\Models\\Habitacion',7,'created',NULL,'\"{\\\"identificador\\\":\\\"Consultorio 2\\\",\\\"tipo\\\":\\\"Consultorio\\\",\\\"estado\\\":\\\"Libre\\\",\\\"ubicacion\\\":\\\"Gustavo D\\\\u00edaz Ordaz\\\",\\\"piso\\\":\\\"Planta baja\\\",\\\"id\\\":7}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(14,NULL,'App\\Models\\Habitacion',8,'created',NULL,'\"{\\\"identificador\\\":\\\"Consultorio 3\\\",\\\"tipo\\\":\\\"Consultorio\\\",\\\"estado\\\":\\\"Libre\\\",\\\"ubicacion\\\":\\\"Gustavo D\\\\u00edaz Ordaz\\\",\\\"piso\\\":\\\"Planta baja\\\",\\\"id\\\":8}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(15,NULL,'App\\Models\\Habitacion',9,'created',NULL,'\"{\\\"identificador\\\":\\\"Suit 1A\\\",\\\"tipo\\\":\\\"Habitaci\\\\u00f3n\\\",\\\"estado\\\":\\\"Libre\\\",\\\"ubicacion\\\":\\\"Plan de Ayutla\\\",\\\"piso\\\":\\\"Planta baja\\\",\\\"id\\\":9}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(16,NULL,'App\\Models\\Habitacion',10,'created',NULL,'\"{\\\"identificador\\\":\\\"Suit 1B\\\",\\\"tipo\\\":\\\"Habitaci\\\\u00f3n\\\",\\\"estado\\\":\\\"Libre\\\",\\\"ubicacion\\\":\\\"Plan de Ayutla\\\",\\\"piso\\\":\\\"Planta baja\\\",\\\"id\\\":10}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(17,NULL,'App\\Models\\Habitacion',11,'created',NULL,'\"{\\\"identificador\\\":\\\"Suit 2\\\",\\\"tipo\\\":\\\"Habitaci\\\\u00f3n\\\",\\\"estado\\\":\\\"Libre\\\",\\\"piso\\\":\\\"Planta Baja\\\",\\\"ubicacion\\\":\\\"Plan de Ayutla\\\",\\\"id\\\":11}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(18,NULL,'App\\Models\\Habitacion',12,'created',NULL,'\"{\\\"identificador\\\":\\\"Suit 3\\\",\\\"tipo\\\":\\\"Habitaci\\\\u00f3n\\\",\\\"estado\\\":\\\"Libre\\\",\\\"piso\\\":\\\"Planta Baja\\\",\\\"ubicacion\\\":\\\"Plan de Ayutla\\\",\\\"id\\\":12}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(19,NULL,'App\\Models\\Habitacion',13,'created',NULL,'\"{\\\"identificador\\\":\\\"Suit 4\\\",\\\"tipo\\\":\\\"Habitaci\\\\u00f3n\\\",\\\"estado\\\":\\\"Libre\\\",\\\"piso\\\":\\\"Planta Baja\\\",\\\"ubicacion\\\":\\\"Plan de Ayutla\\\",\\\"id\\\":13}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(20,NULL,'App\\Models\\Habitacion',14,'created',NULL,'\"{\\\"identificador\\\":\\\"Suit 5\\\",\\\"tipo\\\":\\\"Habitaci\\\\u00f3n\\\",\\\"estado\\\":\\\"Libre\\\",\\\"piso\\\":\\\"Planta Baja\\\",\\\"ubicacion\\\":\\\"Plan de Ayutla\\\",\\\"id\\\":14}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(21,NULL,'App\\Models\\Habitacion',15,'created',NULL,'\"{\\\"identificador\\\":\\\"Suit 6\\\",\\\"tipo\\\":\\\"Habitaci\\\\u00f3n\\\",\\\"estado\\\":\\\"Libre\\\",\\\"piso\\\":\\\"Planta Baja\\\",\\\"ubicacion\\\":\\\"Plan de Ayutla\\\",\\\"id\\\":15}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(22,NULL,'App\\Models\\Habitacion',16,'created',NULL,'\"{\\\"identificador\\\":\\\"Quirofano\\\",\\\"tipo\\\":\\\"Quirofano\\\",\\\"estado\\\":\\\"Libre\\\",\\\"ubicacion\\\":\\\"Plan de Ayutla\\\",\\\"piso\\\":\\\"Planta Alta\\\",\\\"id\\\":16}\"','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(23,NULL,'App\\Models\\ProductoServicio',785,'created',NULL,'\"{\\\"tipo\\\":\\\"SERVICIOS\\\",\\\"subtipo\\\":\\\"ADMISION\\\",\\\"codigo_prestacion\\\":\\\"\\\",\\\"nombre_prestacion\\\":\\\"LLENADO DE HOJA FRONTAL\\\",\\\"importe\\\":0.1,\\\"cantidad\\\":null,\\\"updated_at\\\":\\\"2026-02-12 15:46:57\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:57\\\",\\\"id\\\":785}\"','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(24,NULL,'App\\Models\\ProductoServicio',786,'created',NULL,'\"{\\\"tipo\\\":\\\"SERVICIOS\\\",\\\"subtipo\\\":\\\"ESTUDIOS\\\",\\\"codigo_prestacion\\\":\\\"85121801_01\\\",\\\"nombre_prestacion\\\":\\\"SOLICITUD PATOLOG\\\\u00cdA\\\",\\\"importe\\\":0.1,\\\"cantidad\\\":null,\\\"updated_at\\\":\\\"2026-02-12 15:46:57\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:57\\\",\\\"id\\\":786}\"','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(25,NULL,'App\\Models\\User',1,'created',NULL,'\"{\\\"curp\\\":\\\"JUAP850101HDFLRS01\\\",\\\"nombre\\\":\\\"Juan\\\",\\\"apellido_paterno\\\":\\\"P\\\\u00e9rez\\\",\\\"apellido_materno\\\":\\\"Ram\\\\u00edrez\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1985-01-01 00:00:00\\\",\\\"email\\\":\\\"juan.perez@hospital.com\\\",\\\"password\\\":\\\"$2y$12$od1qPe1wCavLX.aJiSaMUe.HeoHhewoM9uBZ4OIlpAOuyXYOrUX8W\\\",\\\"telefono\\\":\\\"7774441234\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:57\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:57\\\",\\\"id\\\":1}\"','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(26,NULL,'App\\Models\\User',1,'updated','\"[]\"','\"{\\\"colaborador_responsable_id\\\":1}\"','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(27,NULL,'App\\Models\\User',2,'created',NULL,'\"{\\\"curp\\\":\\\"MALO900214MDFLPS02\\\",\\\"nombre\\\":\\\"Mar\\\\u00eda\\\",\\\"apellido_paterno\\\":\\\"L\\\\u00f3pez\\\",\\\"apellido_materno\\\":\\\"Santos\\\",\\\"sexo\\\":\\\"Femenino\\\",\\\"fecha_nacimiento\\\":\\\"1990-02-14 00:00:00\\\",\\\"email\\\":\\\"enfermeralicenciada@hospital.com\\\",\\\"telefono\\\":\\\"7774441234\\\",\\\"colaborador_responsable_id\\\":1,\\\"password\\\":\\\"$2y$12$BowIFQ4U7yjG6Ye1lR1Wve1Sh5q7Pl9j2TWTSIrDxwh0MqkoL.1RG\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:58\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:58\\\",\\\"id\\\":2}\"','2026-02-12 21:46:58','2026-02-12 21:46:58'),
(28,NULL,'App\\Models\\User',3,'created',NULL,'\"{\\\"curp\\\":\\\"CARA820710HDFRMR03\\\",\\\"nombre\\\":\\\"Carlos\\\",\\\"apellido_paterno\\\":\\\"Ram\\\\u00edrez\\\",\\\"apellido_materno\\\":\\\"Moreno\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1982-07-10 00:00:00\\\",\\\"colaborador_responsable_id\\\":1,\\\"telefono\\\":\\\"7774441234\\\",\\\"email\\\":\\\"enfermeraauxiliar@test.com\\\",\\\"password\\\":\\\"$2y$12$pdAw10AOmSrzWhrD60nL6.wDw7x4feI0p3cixNKpqv07PVzdZ.kB6\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:58\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:58\\\",\\\"id\\\":3}\"','2026-02-12 21:46:58','2026-02-12 21:46:58'),
(29,NULL,'App\\Models\\User',4,'created',NULL,'\"{\\\"curp\\\":\\\"LAHE880320MDFHND04\\\",\\\"nombre\\\":\\\"Laura\\\",\\\"apellido_paterno\\\":\\\"Hern\\\\u00e1ndez\\\",\\\"apellido_materno\\\":\\\"D\\\\u00edaz\\\",\\\"sexo\\\":\\\"Femenino\\\",\\\"fecha_nacimiento\\\":\\\"1988-03-20 00:00:00\\\",\\\"colaborador_responsable_id\\\":3,\\\"telefono\\\":\\\"7774441234\\\",\\\"email\\\":\\\"laura.hernandez@hospital.com\\\",\\\"password\\\":\\\"$2y$12$EOmGW2ofnKD7hnis9lXGaOJeN6vIJULTgKg7eqjR7t.yOZsD5T\\\\\\/8q\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:58\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:58\\\",\\\"id\\\":4}\"','2026-02-12 21:46:58','2026-02-12 21:46:58'),
(30,NULL,'App\\Models\\User',5,'created',NULL,'\"{\\\"curp\\\":\\\"ANGG910923HDFGLZ05\\\",\\\"nombre\\\":\\\"Andr\\\\u00e9s\\\",\\\"apellido_paterno\\\":\\\"Gonz\\\\u00e1lez\\\",\\\"apellido_materno\\\":\\\"Luna\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1991-09-23 00:00:00\\\",\\\"colaborador_responsable_id\\\":2,\\\"telefono\\\":\\\"7774441234\\\",\\\"email\\\":\\\"andres.gonzalez@hospital.com\\\",\\\"password\\\":\\\"$2y$12$6JPjtYWjopAzz8Ck9QFEceOq3kTZoYUTH3xA3KwkZAPUTIss\\\\\\/tvBi\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:58\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:58\\\",\\\"id\\\":5}\"','2026-02-12 21:46:58','2026-02-12 21:46:58'),
(31,NULL,'App\\Models\\User',6,'created',NULL,'\"{\\\"curp\\\":\\\"SOMA950105MDFMRT06\\\",\\\"nombre\\\":\\\"Sof\\\\u00eda\\\",\\\"apellido_paterno\\\":\\\"Mart\\\\u00ednez\\\",\\\"apellido_materno\\\":\\\"Rojas\\\",\\\"sexo\\\":\\\"Femenino\\\",\\\"fecha_nacimiento\\\":\\\"1995-01-05 00:00:00\\\",\\\"colaborador_responsable_id\\\":5,\\\"telefono\\\":\\\"7774441234\\\",\\\"email\\\":\\\"sofia.martinez@hospital.com\\\",\\\"password\\\":\\\"$2y$12$gS6LKGztMybHTXA2eqGuBOd85CRNJR\\\\\\/XN0Zu96LZuwRC1s4O.5L9i\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:58\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:58\\\",\\\"id\\\":6}\"','2026-02-12 21:46:58','2026-02-12 21:46:58'),
(32,NULL,'App\\Models\\User',7,'created',NULL,'\"{\\\"curp\\\":\\\"TIMK040210HMSRDVA6\\\",\\\"nombre\\\":\\\"Kevin Yahir\\\",\\\"apellido_paterno\\\":\\\"Trinidad\\\",\\\"apellido_materno\\\":\\\"Medina\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"2004-02-10 00:00:00\\\",\\\"email\\\":\\\"kevinyahirt@gmail.com\\\",\\\"telefono\\\":\\\"7774441234\\\",\\\"password\\\":\\\"$2y$12$Ya2oTyYQ0zcz85\\\\\\/hXc3mIe6V3ZJ7w6ALldVCxD\\\\\\/7fV0GDJ3Kb1txq\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:58\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:58\\\",\\\"id\\\":7}\"','2026-02-12 21:46:58','2026-02-12 21:46:58'),
(33,NULL,'App\\Models\\User',8,'created',NULL,'\"{\\\"curp\\\":\\\"HEAL000101HDFXXX01\\\",\\\"nombre\\\":\\\"HealthCare\\\",\\\"apellido_paterno\\\":\\\"Prueba\\\",\\\"apellido_materno\\\":\\\"Sistema\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"2000-01-01 00:00:00\\\",\\\"email\\\":\\\"healthcare@test.com\\\",\\\"telefono\\\":\\\"7774441234\\\",\\\"password\\\":\\\"$2y$12$1gvst4pMNT0Irt6X3w0Biub.BY8on0snNqaczttOiR1L0avdt2Ufq\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:59\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:59\\\",\\\"id\\\":8}\"','2026-02-12 21:46:59','2026-02-12 21:46:59'),
(34,NULL,'App\\Models\\User',9,'created',NULL,'\"{\\\"curp\\\":\\\"HEGE040302HMSRMFA0\\\",\\\"nombre\\\":\\\"Efrain\\\",\\\"apellido_paterno\\\":\\\"Hern\\\\u00e1ndez\\\",\\\"apellido_materno\\\":\\\"G\\\\u00f3mez\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"2004-03-02 00:00:00\\\",\\\"email\\\":\\\"efrainhdz@gmail.com\\\",\\\"telefono\\\":\\\"7774441234\\\",\\\"password\\\":\\\"$2y$12$rXO1u1ZrqfZFOxPQHPEwx.wRNs0NzVvB\\\\\\/UmhI6U2\\\\\\/F4NpOSrEe1K6\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:59\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:59\\\",\\\"id\\\":9}\"','2026-02-12 21:46:59','2026-02-12 21:46:59'),
(35,NULL,'App\\Models\\User',10,'created',NULL,'\"{\\\"curp\\\":\\\"HEGE040302HMRMFA2\\\",\\\"nombre\\\":\\\"Efrain \\\",\\\"apellido_paterno\\\":\\\"Hern\\\\u00e1ndez\\\",\\\"apellido_materno\\\":\\\"G\\\\u00f3mez\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"2004-03-02 00:00:00\\\",\\\"email\\\":\\\"farmacia@test.com\\\",\\\"telefono\\\":\\\"7774441234\\\",\\\"password\\\":\\\"$2y$12$BNGuVmE1gn9t\\\\\\/w6sQEDbB.7DEMlgKNn5tEIh8945rqKrRJCZXQai6\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:59\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:59\\\",\\\"id\\\":10}\"','2026-02-12 21:46:59','2026-02-12 21:46:59'),
(36,NULL,'App\\Models\\User',11,'created',NULL,'\"{\\\"curp\\\":\\\"PESA950615MDFRNS03\\\",\\\"nombre\\\":\\\"Ana Mar\\\\u00eda\\\",\\\"apellido_paterno\\\":\\\"P\\\\u00e9rez\\\",\\\"apellido_materno\\\":\\\"S\\\\u00e1nchez\\\",\\\"sexo\\\":\\\"Femenino\\\",\\\"fecha_nacimiento\\\":\\\"1995-06-15 00:00:00\\\",\\\"email\\\":\\\"recepcion@test.com\\\",\\\"telefono\\\":\\\"7774441234\\\",\\\"password\\\":\\\"$2y$12$QMK5Og8v167GpbgelPjDeeaNI3TvwbR5r813y1tyMn\\\\\\/DlTFEbY9Bi\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:59\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:59\\\",\\\"id\\\":11}\"','2026-02-12 21:46:59','2026-02-12 21:46:59'),
(37,NULL,'App\\Models\\User',12,'created',NULL,'\"{\\\"curp\\\":\\\"GOLO900101HDFRNS05\\\",\\\"nombre\\\":\\\"Carlos\\\",\\\"apellido_paterno\\\":\\\"G\\\\u00f3mez\\\",\\\"apellido_materno\\\":\\\"L\\\\u00f3pez\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1990-01-01 00:00:00\\\",\\\"email\\\":\\\"caja@test.com\\\",\\\"telefono\\\":\\\"7774441234\\\",\\\"password\\\":\\\"$2y$12$oAwhjcz4RUmwvSafJVlwhO3H0Gx6nIKYwNRqbJvIbzjUnqaFVWeZi\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:59\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:59\\\",\\\"id\\\":12}\"','2026-02-12 21:46:59','2026-02-12 21:46:59'),
(38,NULL,'App\\Models\\User',13,'created',NULL,'\"{\\\"curp\\\":\\\"TORA920515MDFRRN01\\\",\\\"nombre\\\":\\\"Ana\\\",\\\"apellido_paterno\\\":\\\"Torres\\\",\\\"apellido_materno\\\":\\\"Ruiz\\\",\\\"sexo\\\":\\\"Femenino\\\",\\\"fecha_nacimiento\\\":\\\"1992-05-15 00:00:00\\\",\\\"telefono\\\":\\\"7774441234\\\",\\\"email\\\":\\\"tmko220776@upemor.edu.mx\\\",\\\"password\\\":\\\"$2y$12$gHqCe6s4DOihlFzf95U3XuFxinzbbsDylFQFdEsx5ReVD3jvbSIJm\\\",\\\"updated_at\\\":\\\"2026-02-12 15:46:59\\\",\\\"created_at\\\":\\\"2026-02-12 15:46:59\\\",\\\"id\\\":13}\"','2026-02-12 21:46:59','2026-02-12 21:46:59'),
(39,NULL,'App\\Models\\User',14,'created',NULL,'\"{\\\"curp\\\":\\\"AHTJ800101HDFRRN02\\\",\\\"nombre\\\":\\\"Juan Manuel\\\",\\\"apellido_paterno\\\":\\\"Ahumada\\\",\\\"apellido_materno\\\":\\\"Trujillo\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1980-01-01 00:00:00\\\",\\\"telefono\\\":\\\"7771002030\\\",\\\"email\\\":\\\"juan.ahumada@test.com\\\",\\\"password\\\":\\\"$2y$12$9QiaEhsPHvTyw6xdNkJ5HO8Z0C23JKhKiKuUgBfmMeLMKG0zRUzzC\\\",\\\"updated_at\\\":\\\"2026-02-12 15:47:00\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:00\\\",\\\"id\\\":14}\"','2026-02-12 21:47:00','2026-02-12 21:47:00'),
(40,NULL,'App\\Models\\User',15,'created',NULL,'\"{\\\"curp\\\":\\\"OIEF820520HDFRRN03\\\",\\\"nombre\\\":\\\"Fidel Humberto\\\",\\\"apellido_paterno\\\":\\\"Ortiz\\\",\\\"apellido_materno\\\":\\\"Espinoza\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1982-05-20 00:00:00\\\",\\\"telefono\\\":\\\"7772003040\\\",\\\"email\\\":\\\"fidel.ortiz@test.com\\\",\\\"password\\\":\\\"$2y$12$Slco4.sFvY6kuWYzmadQsud5cgRo6xbuMyAHU8Alj\\\\\\/5E2q9DNH26e\\\",\\\"updated_at\\\":\\\"2026-02-12 15:47:00\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:00\\\",\\\"id\\\":15}\"','2026-02-12 21:47:00','2026-02-12 21:47:00'),
(41,NULL,'App\\Models\\User',16,'created',NULL,'\"{\\\"curp\\\":\\\"JUTC850815HDFRRN04\\\",\\\"nombre\\\":\\\"Carlos Gabriel\\\",\\\"apellido_paterno\\\":\\\"Juarez\\\",\\\"apellido_materno\\\":\\\"Tapia\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1985-08-15 00:00:00\\\",\\\"telefono\\\":\\\"7773004050\\\",\\\"email\\\":\\\"carlos.juarez@test.com\\\",\\\"password\\\":\\\"$2y$12$Ns\\\\\\/jPOvhTpxrwoBKfA\\\\\\/jbeyRTEfLqddkV\\\\\\/.T7vkFWKwEt8MwYSdIu\\\",\\\"updated_at\\\":\\\"2026-02-12 15:47:00\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:00\\\",\\\"id\\\":16}\"','2026-02-12 21:47:00','2026-02-12 21:47:00'),
(42,NULL,'App\\Models\\User',17,'created',NULL,'\"{\\\"curp\\\":\\\"MOLX900210MDFRRN05\\\",\\\"nombre\\\":\\\"Luz\\\",\\\"apellido_paterno\\\":\\\"Morales\\\",\\\"apellido_materno\\\":\\\"\\\",\\\"sexo\\\":\\\"Femenino\\\",\\\"fecha_nacimiento\\\":\\\"1990-02-10 00:00:00\\\",\\\"telefono\\\":\\\"7774005060\\\",\\\"email\\\":\\\"luz.morales@test.com\\\",\\\"password\\\":\\\"$2y$12$3zSCjFr1\\\\\\/SS2im3X04jNeObDDcTYhdj5gaRWK5Gs8nIPVlQna6lOW\\\",\\\"updated_at\\\":\\\"2026-02-12 15:47:00\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:00\\\",\\\"id\\\":17}\"','2026-02-12 21:47:00','2026-02-12 21:47:00'),
(43,NULL,'App\\Models\\User',18,'created',NULL,'\"{\\\"curp\\\":\\\"JABA930725MDFRRN06\\\",\\\"nombre\\\":\\\"America\\\",\\\"apellido_paterno\\\":\\\"Jaimes\\\",\\\"apellido_materno\\\":\\\"Barcenas\\\",\\\"sexo\\\":\\\"Femenino\\\",\\\"fecha_nacimiento\\\":\\\"1993-07-25 00:00:00\\\",\\\"telefono\\\":\\\"7775006070\\\",\\\"email\\\":\\\"america.jaimes@test.com\\\",\\\"password\\\":\\\"$2y$12$iN8wi\\\\\\/P2wbxvl\\\\\\/QVEyGkQ.k3e.ub29xL415HjDuUOpU.9EfdtQgnu\\\",\\\"updated_at\\\":\\\"2026-02-12 15:47:00\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:00\\\",\\\"id\\\":18}\"','2026-02-12 21:47:00','2026-02-12 21:47:00'),
(44,NULL,'App\\Models\\User',19,'created',NULL,'\"{\\\"curp\\\":\\\"OILJ951130HDFRRN07\\\",\\\"nombre\\\":\\\"Josu\\\\u00e9\\\",\\\"apellido_paterno\\\":\\\"Ortiz\\\",\\\"apellido_materno\\\":\\\"L\\\\u00f3pez\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1995-11-30 00:00:00\\\",\\\"telefono\\\":\\\"7776007080\\\",\\\"email\\\":\\\"josue.ortiz@test.com\\\",\\\"password\\\":\\\"$2y$12$dy7DkJ165J0ohgczy8El6uB1OGHinak0S8R7\\\\\\/dny9PXjYVg0o6GoS\\\",\\\"updated_at\\\":\\\"2026-02-12 15:47:01\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:01\\\",\\\"id\\\":19}\"','2026-02-12 21:47:01','2026-02-12 21:47:01'),
(45,NULL,'App\\Models\\User',20,'created',NULL,'\"{\\\"curp\\\":\\\"FORE900101MDFRRN01\\\",\\\"nombre\\\":\\\"Erika\\\",\\\"apellido_paterno\\\":\\\"Flores\\\",\\\"apellido_materno\\\":\\\"Rodriguez\\\",\\\"sexo\\\":\\\"Femenino\\\",\\\"fecha_nacimiento\\\":\\\"1990-01-01 00:00:00\\\",\\\"telefono\\\":\\\"7772329969\\\",\\\"email\\\":\\\"erika.flores@test.com\\\",\\\"password\\\":\\\"$2y$12$PlFGgaBg5XZCgtAwkjUm5.7a3bt0pF04O\\\\\\/rac1N77UPZNRHrmkqIa\\\",\\\"updated_at\\\":\\\"2026-02-12 15:47:01\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:01\\\",\\\"id\\\":20}\"','2026-02-12 21:47:01','2026-02-12 21:47:01'),
(46,NULL,'App\\Models\\User',21,'created',NULL,'\"{\\\"curp\\\":\\\"VARA920202HDFRRN02\\\",\\\"nombre\\\":\\\"Azamar Aaron\\\",\\\"apellido_paterno\\\":\\\"Vargas\\\",\\\"apellido_materno\\\":\\\"Radilla\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1992-02-02 00:00:00\\\",\\\"telefono\\\":\\\"7774608751\\\",\\\"email\\\":\\\"azamar.vargas@test.com\\\",\\\"password\\\":\\\"$2y$12$i2ihpO7M81va8cub491gVO5p1lTeuixR\\\\\\/taEKs\\\\\\/VdXyqBbeJDwpZ6\\\",\\\"updated_at\\\":\\\"2026-02-12 15:47:01\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:01\\\",\\\"id\\\":21}\"','2026-02-12 21:47:01','2026-02-12 21:47:01'),
(47,NULL,'App\\Models\\User',22,'created',NULL,'\"{\\\"curp\\\":\\\"EABD950303HDFRRN03\\\",\\\"nombre\\\":\\\"Diego Enrique\\\",\\\"apellido_paterno\\\":\\\"Erazo\\\",\\\"apellido_materno\\\":\\\"Barreto\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1995-03-03 00:00:00\\\",\\\"telefono\\\":\\\"7773895596\\\",\\\"email\\\":\\\"diego.erazo@test.com\\\",\\\"password\\\":\\\"$2y$12$MDNkCgDHqnIOWQkLqHqnKuyYOxq5P2Pn3grBPJZsylkAjIdKnVlNK\\\",\\\"updated_at\\\":\\\"2026-02-12 15:47:01\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:01\\\",\\\"id\\\":22}\"','2026-02-12 21:47:01','2026-02-12 21:47:01'),
(48,NULL,'App\\Models\\User',23,'created',NULL,'\"{\\\"curp\\\":\\\"PEGR880404HDFRRN04\\\",\\\"nombre\\\":\\\"Rodolfo\\\",\\\"apellido_paterno\\\":\\\"P\\\\u00e9rez\\\",\\\"apellido_materno\\\":\\\"Guti\\\\u00e9rrez\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1988-04-04 00:00:00\\\",\\\"telefono\\\":\\\"7772583877\\\",\\\"email\\\":\\\"rodolfo.perez@test.com\\\",\\\"password\\\":\\\"$2y$12$aSEZXBL.d\\\\\\/CmtfgKX1KBhuuJfK1LZrRshD46CQ0fU8lJFlm\\\\\\/UUUnK\\\",\\\"updated_at\\\":\\\"2026-02-12 15:47:01\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:01\\\",\\\"id\\\":23}\"','2026-02-12 21:47:01','2026-02-12 21:47:01'),
(49,NULL,'App\\Models\\User',24,'created',NULL,'\"{\\\"curp\\\":\\\"GAGL900101HDFRNS05\\\",\\\"nombre\\\":\\\"Gabriel\\\",\\\"apellido_paterno\\\":\\\"G\\\\u00f3mez\\\",\\\"apellido_materno\\\":\\\"L\\\\u00f3pez\\\",\\\"sexo\\\":\\\"Masculino\\\",\\\"fecha_nacimiento\\\":\\\"1990-01-01 00:00:00\\\",\\\"email\\\":\\\"gabriel@test.com\\\",\\\"telefono\\\":\\\"7774441234\\\",\\\"password\\\":\\\"$2y$12$2XcQpsvn5Ciedd2Q3So6HOoMkE0GiK6qUOCPwzNTKgt8sD1btHiyO\\\",\\\"updated_at\\\":\\\"2026-02-12 15:47:01\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:01\\\",\\\"id\\\":24}\"','2026-02-12 21:47:01','2026-02-12 21:47:01'),
(50,NULL,'App\\Models\\User',25,'created',NULL,'\"{\\\"curp\\\":\\\"ROMA850512MDFRNS08\\\",\\\"nombre\\\":\\\"Rosa\\\",\\\"apellido_paterno\\\":\\\"Mart\\\\u00ednez\\\",\\\"apellido_materno\\\":\\\"Aguirre\\\",\\\"sexo\\\":\\\"Femenino\\\",\\\"fecha_nacimiento\\\":\\\"1985-05-12 00:00:00\\\",\\\"email\\\":\\\"cocina@test.com\\\",\\\"telefono\\\":\\\"7775556789\\\",\\\"password\\\":\\\"$2y$12$PtXcv79KWRdJ50mmamzYI.Hi80B4G9nVoZRXAjbiIishstSRKGQZe\\\",\\\"updated_at\\\":\\\"2026-02-12 15:47:02\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:02\\\",\\\"id\\\":25}\"','2026-02-12 21:47:02','2026-02-12 21:47:02'),
(51,NULL,'App\\Models\\Estancia',1,'created',NULL,'\"{\\\"folio\\\":\\\"12892025\\\",\\\"paciente_id\\\":1,\\\"fecha_ingreso\\\":\\\"2025-09-28 10:00\\\",\\\"tipo_estancia\\\":\\\"Interconsulta\\\",\\\"tipo_ingreso\\\":\\\"Ingreso\\\",\\\"modalidad_ingreso\\\":\\\"Particular\\\",\\\"familiar_responsable_id\\\":1,\\\"created_by\\\":7,\\\"updated_at\\\":\\\"2026-02-12 15:47:02\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:02\\\",\\\"id\\\":1}\"','2026-02-12 21:47:02','2026-02-12 21:47:02'),
(52,NULL,'App\\Models\\Estancia',2,'created',NULL,'\"{\\\"folio\\\":\\\"11282025\\\",\\\"paciente_id\\\":1,\\\"fecha_ingreso\\\":\\\"2025-08-12 14:30\\\",\\\"fecha_egreso\\\":\\\"2025-08-20 09:00\\\",\\\"habitacion_id\\\":2,\\\"estancia_anterior_id\\\":1,\\\"tipo_estancia\\\":\\\"Hospitalizacion\\\",\\\"tipo_ingreso\\\":\\\"Ingreso\\\",\\\"modalidad_ingreso\\\":\\\"Particular\\\",\\\"familiar_responsable_id\\\":2,\\\"created_by\\\":7,\\\"updated_at\\\":\\\"2026-02-12 15:47:02\\\",\\\"created_at\\\":\\\"2026-02-12 15:47:02\\\",\\\"id\\\":2}\"','2026-02-12 21:47:02','2026-02-12 21:47:02');
/*!40000 ALTER TABLE `histories` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `hoja_control_liquidos`
--

DROP TABLE IF EXISTS `hoja_control_liquidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoja_control_liquidos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hoja_enfermeria_id` bigint(20) unsigned NOT NULL,
  `fecha_hora_registro` datetime NOT NULL,
  `uresis` int(11) DEFAULT NULL,
  `uresis_descripcion` varchar(255) DEFAULT NULL,
  `evacuaciones` int(11) DEFAULT NULL,
  `evacuaciones_descripcion` varchar(255) DEFAULT NULL,
  `emesis` int(11) DEFAULT NULL,
  `emesis_descripcion` varchar(255) DEFAULT NULL,
  `drenes` int(11) DEFAULT NULL,
  `drenes_descripcion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hoja_control_liquidos_hoja_enfermeria_id_foreign` (`hoja_enfermeria_id`),
  CONSTRAINT `hoja_control_liquidos_hoja_enfermeria_id_foreign` FOREIGN KEY (`hoja_enfermeria_id`) REFERENCES `hoja_enfermerias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoja_control_liquidos`
--

LOCK TABLES `hoja_control_liquidos` WRITE;
/*!40000 ALTER TABLE `hoja_control_liquidos` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `hoja_control_liquidos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `hoja_enfermeria_quirofanos`
--

DROP TABLE IF EXISTS `hoja_enfermeria_quirofanos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoja_enfermeria_quirofanos` (
  `id` bigint(20) unsigned NOT NULL,
  `anestesia` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`anestesia`)),
  `servicios_especiales` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`servicios_especiales`)),
  `hora_inicio_cirugia` datetime DEFAULT NULL,
  `hora_inicio_anestesia` datetime DEFAULT NULL,
  `hora_inicio_paciente` datetime DEFAULT NULL,
  `hora_fin_cirugia` datetime DEFAULT NULL,
  `hora_fin_anestesia` datetime DEFAULT NULL,
  `hora_fin_paciente` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `hoja_enfermeria_quirofanos_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoja_enfermeria_quirofanos`
--

LOCK TABLES `hoja_enfermeria_quirofanos` WRITE;
/*!40000 ALTER TABLE `hoja_enfermeria_quirofanos` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `hoja_enfermeria_quirofanos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `hoja_enfermerias`
--

DROP TABLE IF EXISTS `hoja_enfermerias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoja_enfermerias` (
  `id` bigint(20) unsigned NOT NULL,
  `turno` varchar(255) NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `habitus_exterior` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`habitus_exterior`)),
  `estado` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `hoja_enfermerias_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoja_enfermerias`
--

LOCK TABLES `hoja_enfermerias` WRITE;
/*!40000 ALTER TABLE `hoja_enfermerias` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `hoja_enfermerias` VALUES
(1,'Matutino',NULL,NULL,'Abierto','2026-02-12 21:47:59','2026-02-12 21:47:59');
/*!40000 ALTER TABLE `hoja_enfermerias` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `hoja_escala_valoracions`
--

DROP TABLE IF EXISTS `hoja_escala_valoracions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoja_escala_valoracions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hoja_enfermeria_id` bigint(20) unsigned NOT NULL,
  `fecha_hora_registro` datetime NOT NULL,
  `escala_braden` varchar(255) DEFAULT NULL,
  `escala_glasgow` varchar(255) DEFAULT NULL,
  `escala_ramsey` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hoja_escala_valoracions_hoja_enfermeria_id_foreign` (`hoja_enfermeria_id`),
  CONSTRAINT `hoja_escala_valoracions_hoja_enfermeria_id_foreign` FOREIGN KEY (`hoja_enfermeria_id`) REFERENCES `hoja_enfermerias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoja_escala_valoracions`
--

LOCK TABLES `hoja_escala_valoracions` WRITE;
/*!40000 ALTER TABLE `hoja_escala_valoracions` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `hoja_escala_valoracions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `hoja_frontales`
--

DROP TABLE IF EXISTS `hoja_frontales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoja_frontales` (
  `id` bigint(20) unsigned NOT NULL,
  `medico_id` bigint(20) unsigned NOT NULL,
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hoja_frontales_medico_id_foreign` (`medico_id`),
  CONSTRAINT `hoja_frontales_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hoja_frontales_medico_id_foreign` FOREIGN KEY (`medico_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoja_frontales`
--

LOCK TABLES `hoja_frontales` WRITE;
/*!40000 ALTER TABLE `hoja_frontales` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `hoja_frontales` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `hoja_habitus_exteriors`
--

DROP TABLE IF EXISTS `hoja_habitus_exteriors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoja_habitus_exteriors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hoja_enfermeria_id` bigint(20) unsigned NOT NULL,
  `sexo` varchar(255) NOT NULL,
  `condicion_llegada` varchar(255) NOT NULL,
  `facies` varchar(255) NOT NULL,
  `constitucion` varchar(255) NOT NULL,
  `postura` varchar(255) NOT NULL,
  `piel` varchar(255) NOT NULL,
  `estado_conciencia` varchar(255) NOT NULL,
  `marcha` varchar(255) NOT NULL,
  `movimientos` varchar(255) NOT NULL,
  `higiene` varchar(255) NOT NULL,
  `edad_aparente` varchar(255) NOT NULL,
  `orientacion` varchar(255) NOT NULL,
  `lenguaje` varchar(255) NOT NULL,
  `olores_ruidos` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hoja_habitus_exteriors_hoja_enfermeria_id_foreign` (`hoja_enfermeria_id`),
  CONSTRAINT `hoja_habitus_exteriors_hoja_enfermeria_id_foreign` FOREIGN KEY (`hoja_enfermeria_id`) REFERENCES `hoja_enfermerias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoja_habitus_exteriors`
--

LOCK TABLES `hoja_habitus_exteriors` WRITE;
/*!40000 ALTER TABLE `hoja_habitus_exteriors` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `hoja_habitus_exteriors` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `hoja_insumos_basicos`
--

DROP TABLE IF EXISTS `hoja_insumos_basicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoja_insumos_basicos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `producto_servicio_id` bigint(20) unsigned NOT NULL,
  `hoja_enfermeria_quirofano_id` bigint(20) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hoja_insumos_basicos_producto_servicio_id_foreign` (`producto_servicio_id`),
  KEY `hoja_insumos_basicos_hoja_enfermeria_quirofano_id_foreign` (`hoja_enfermeria_quirofano_id`),
  CONSTRAINT `hoja_insumos_basicos_hoja_enfermeria_quirofano_id_foreign` FOREIGN KEY (`hoja_enfermeria_quirofano_id`) REFERENCES `hoja_enfermeria_quirofanos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hoja_insumos_basicos_producto_servicio_id_foreign` FOREIGN KEY (`producto_servicio_id`) REFERENCES `producto_servicios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoja_insumos_basicos`
--

LOCK TABLES `hoja_insumos_basicos` WRITE;
/*!40000 ALTER TABLE `hoja_insumos_basicos` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `hoja_insumos_basicos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `hoja_medicamentos`
--

DROP TABLE IF EXISTS `hoja_medicamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoja_medicamentos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hoja_enfermeria_id` bigint(20) unsigned NOT NULL,
  `producto_servicio_id` bigint(20) unsigned DEFAULT NULL,
  `dosis` int(11) NOT NULL,
  `gramaje` varchar(255) NOT NULL,
  `unidad` varchar(255) NOT NULL,
  `via_administracion` varchar(255) DEFAULT NULL,
  `duracion_tratamiento` int(11) NOT NULL,
  `fecha_hora_inicio` datetime DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'solicitado',
  `fecha_hora_solicitud` datetime NOT NULL,
  `fecha_hora_surtido_farmacia` datetime DEFAULT NULL,
  `nombre_medicamento` varchar(255) NOT NULL,
  `farmaceutico_id` bigint(20) unsigned DEFAULT NULL,
  `fecha_hora_recibido_enfermeria` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hoja_medicamentos_hoja_enfermeria_id_foreign` (`hoja_enfermeria_id`),
  KEY `hoja_medicamentos_producto_servicio_id_foreign` (`producto_servicio_id`),
  KEY `hoja_medicamentos_farmaceutico_id_foreign` (`farmaceutico_id`),
  CONSTRAINT `hoja_medicamentos_farmaceutico_id_foreign` FOREIGN KEY (`farmaceutico_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `hoja_medicamentos_hoja_enfermeria_id_foreign` FOREIGN KEY (`hoja_enfermeria_id`) REFERENCES `hoja_enfermerias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hoja_medicamentos_producto_servicio_id_foreign` FOREIGN KEY (`producto_servicio_id`) REFERENCES `producto_servicios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoja_medicamentos`
--

LOCK TABLES `hoja_medicamentos` WRITE;
/*!40000 ALTER TABLE `hoja_medicamentos` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `hoja_medicamentos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `hoja_oxigenos`
--

DROP TABLE IF EXISTS `hoja_oxigenos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoja_oxigenos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `itemable_type` varchar(255) NOT NULL,
  `itemable_id` bigint(20) unsigned NOT NULL,
  `user_id_inicio` bigint(20) unsigned NOT NULL,
  `user_id_fin` bigint(20) unsigned DEFAULT NULL,
  `hora_inicio` datetime NOT NULL,
  `hora_fin` datetime DEFAULT NULL,
  `litros_minuto` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hoja_oxigenos_itemable_type_itemable_id_index` (`itemable_type`,`itemable_id`),
  KEY `hoja_oxigenos_user_id_inicio_foreign` (`user_id_inicio`),
  KEY `hoja_oxigenos_user_id_fin_foreign` (`user_id_fin`),
  CONSTRAINT `hoja_oxigenos_user_id_fin_foreign` FOREIGN KEY (`user_id_fin`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `hoja_oxigenos_user_id_inicio_foreign` FOREIGN KEY (`user_id_inicio`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoja_oxigenos`
--

LOCK TABLES `hoja_oxigenos` WRITE;
/*!40000 ALTER TABLE `hoja_oxigenos` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `hoja_oxigenos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `hoja_registros`
--

DROP TABLE IF EXISTS `hoja_registros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoja_registros` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hoja_enfermeria_id` bigint(20) unsigned NOT NULL,
  `fecha_hora_registro` datetime NOT NULL,
  `tension_arterial_sistolica` int(11) DEFAULT NULL,
  `tension_arterial_diastolica` int(11) DEFAULT NULL,
  `frecuencia_cardiaca` int(11) DEFAULT NULL,
  `frecuencia_respiratoria` int(11) DEFAULT NULL,
  `temperatura` decimal(8,2) DEFAULT NULL,
  `saturacion_oxigeno` int(11) DEFAULT NULL,
  `glucemia_capilar` int(11) DEFAULT NULL,
  `talla` decimal(8,2) DEFAULT NULL,
  `peso` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hoja_registros_hoja_enfermeria_id_foreign` (`hoja_enfermeria_id`),
  CONSTRAINT `hoja_registros_hoja_enfermeria_id_foreign` FOREIGN KEY (`hoja_enfermeria_id`) REFERENCES `hoja_enfermerias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoja_registros`
--

LOCK TABLES `hoja_registros` WRITE;
/*!40000 ALTER TABLE `hoja_registros` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `hoja_registros` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `hoja_riesgo_caidas`
--

DROP TABLE IF EXISTS `hoja_riesgo_caidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoja_riesgo_caidas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hoja_enfermeria_id` bigint(20) unsigned NOT NULL,
  `caidas_previas` tinyint(1) NOT NULL,
  `estado_mental` varchar(255) NOT NULL,
  `deambulacion` varchar(255) NOT NULL,
  `edad_mayor_70` tinyint(1) NOT NULL,
  `medicamentos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`medicamentos`)),
  `deficits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`deficits`)),
  `puntaje_total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hoja_riesgo_caidas_hoja_enfermeria_id_foreign` (`hoja_enfermeria_id`),
  CONSTRAINT `hoja_riesgo_caidas_hoja_enfermeria_id_foreign` FOREIGN KEY (`hoja_enfermeria_id`) REFERENCES `hoja_enfermerias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoja_riesgo_caidas`
--

LOCK TABLES `hoja_riesgo_caidas` WRITE;
/*!40000 ALTER TABLE `hoja_riesgo_caidas` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `hoja_riesgo_caidas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `hoja_sonda_cateters`
--

DROP TABLE IF EXISTS `hoja_sonda_cateters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoja_sonda_cateters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `producto_servicio_id` bigint(20) unsigned NOT NULL,
  `fecha_instalacion` datetime DEFAULT NULL,
  `fecha_caducidad` datetime DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `hoja_enfermeria_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hoja_sonda_cateters_producto_servicio_id_foreign` (`producto_servicio_id`),
  KEY `hoja_sonda_cateters_user_id_foreign` (`user_id`),
  KEY `hoja_sonda_cateters_hoja_enfermeria_id_foreign` (`hoja_enfermeria_id`),
  CONSTRAINT `hoja_sonda_cateters_hoja_enfermeria_id_foreign` FOREIGN KEY (`hoja_enfermeria_id`) REFERENCES `hoja_enfermerias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hoja_sonda_cateters_producto_servicio_id_foreign` FOREIGN KEY (`producto_servicio_id`) REFERENCES `producto_servicios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hoja_sonda_cateters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoja_sonda_cateters`
--

LOCK TABLES `hoja_sonda_cateters` WRITE;
/*!40000 ALTER TABLE `hoja_sonda_cateters` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `hoja_sonda_cateters` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `hoja_terapias`
--

DROP TABLE IF EXISTS `hoja_terapias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoja_terapias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hoja_enfermeria_id` bigint(20) unsigned NOT NULL,
  `solucion` bigint(20) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL,
  `duracion` decimal(8,2) NOT NULL,
  `flujo_ml_hora` decimal(8,2) NOT NULL,
  `fecha_hora_inicio` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hoja_terapias_hoja_enfermeria_id_foreign` (`hoja_enfermeria_id`),
  KEY `hoja_terapias_solucion_foreign` (`solucion`),
  CONSTRAINT `hoja_terapias_hoja_enfermeria_id_foreign` FOREIGN KEY (`hoja_enfermeria_id`) REFERENCES `hoja_enfermerias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hoja_terapias_solucion_foreign` FOREIGN KEY (`solucion`) REFERENCES `producto_servicios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoja_terapias`
--

LOCK TABLES `hoja_terapias` WRITE;
/*!40000 ALTER TABLE `hoja_terapias` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `hoja_terapias` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `honorarios`
--

DROP TABLE IF EXISTS `honorarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `honorarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `interconsulta_id` bigint(20) unsigned NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `honorarios_interconsulta_id_foreign` (`interconsulta_id`),
  CONSTRAINT `honorarios_interconsulta_id_foreign` FOREIGN KEY (`interconsulta_id`) REFERENCES `interconsultas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `honorarios`
--

LOCK TABLES `honorarios` WRITE;
/*!40000 ALTER TABLE `honorarios` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `honorarios` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `insumos`
--

DROP TABLE IF EXISTS `insumos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `insumos` (
  `id` bigint(20) unsigned NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `especificacion` varchar(255) NOT NULL,
  `categoria_unitaria` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `insumos_id_foreign` FOREIGN KEY (`id`) REFERENCES `producto_servicios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insumos`
--

LOCK TABLES `insumos` WRITE;
/*!40000 ALTER TABLE `insumos` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `insumos` VALUES
(390,'AGUJA','20 G (AMARILLA)','AGUJA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(391,'AGUJA','22 G (NEGRA)','AGUJA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(392,'AGUJA','18 G (ROSA)','AGUJA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(393,'AGUJA','21 G (VERDE)','AGUJA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(394,'AGUJA','27 G (DE INSULINA)','AGUJA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(395,'AGUJA PARA VACUTAINER','21 G','AGUJA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(396,'AGUJA RAQUINESTESICA WHITACRE 25 G','CORTA',' AGUJA RAQUINESTESICA ','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(397,'AGUJA RAQUINESTESICA WHITACRE 25 G','LARGA ',' AGUJA RAQUINESTESICA ','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(398,'AGUJA RAQUINESTESICA WHITACRE 27 G','CORTA',' AGUJA RAQUINESTESICA ','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(399,'AGUJA RAQUINESTESICA WHITACRE 27 G','LARGA',' AGUJA RAQUINESTESICA ','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(400,'AGUJA RAQUINESTESICA QUINCKE 22 C','CORTO',' AGUJA RAQUINESTESICA ','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(401,'AGUJA RAQUINESTESICA QUINCKE 25 C','CORTO',' AGUJA RAQUINESTESICA ','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(402,'AGUJA RAQUINESTESICA QUINCKE 25 C','LARGO',' AGUJA RAQUINESTESICA ','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(403,'AGUJA RAQUINESTESICA QUINCKE 26 G','CORTO',' AGUJA RAQUINESTESICA ','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(404,'AGUJA RAQUINESTESICA QUINCKE 27 G','CORTO',' AGUJA RAQUINESTESICA ','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(405,'AGUJA RAQUINESTESICA QUINCKE 27 G','LARGO',' AGUJA RAQUINESTESICA ','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(406,'AMBU ','ADULTO','AMBU','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(407,'AMBU ','NEONATAL','AMBU','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(408,'APOSITO ','CHICO',' APOSITO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(409,'APOSITO PARA HERIDAS SUPERFICIALES ','ROLLO 10 CMX10 CM',' APOSITO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(410,'APOSITOS','GRANDE',' APOSITO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(411,'BOLSA AMARILLA','110 CM X 120 CM',' BOLSA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(412,'BOLSA PARA ENEMA ','1500 ML',' BOLSA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(413,'BOLSA PARA EROCULTIVO PEDRIATICA ','50 ML',' BOLSA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(414,'BOLSA PARA ILESTOMIA','ADULTO',' BOLSA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(415,'BOLSA PARA RECOLECCION DE ORINA','2000 ML',' BOLSA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(416,'BOLSA PARA RECOLECCION DE ORINA \nANTIRREFLUJO','2000 ML',' BOLSA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(417,'BOLSA RESERVORIO LIBRE DE LATEX','1 L ',' BOLSA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(418,'BOLSA ROJA','110 CM X 120 CM',' BOLSA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(419,'BOLSAS DE ALGODON COMPLETAS','500 G',' BOLSA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(420,'BOLSA DE ALGODON PLISADO','300 G ',' BOLSA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(421,'BOLSA DE TORUNDAS','500 G',' BOLSA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(422,'CABESRILLO CON SOPORTE','INFANTIL ',' CABESRILLO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(423,'CABESRILLO CON SOPORTE','PEDIATRICO ',' CABESRILLO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(424,'CABESTRILLO ADULTO CON SOPORTE ','INMOVILIZADOR DE HOMBRO \nUNITALLA ',' CABESRILLO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(425,'CABESTRILLO ADULTO ','GRANDE',' CABESRILLO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(426,'CABESTRILLO ADULTO ','MEDIANO',' CABESRILLO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(427,'CABESTRILLO PEDIATRICO','UNITALLA',' CABESRILLO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(428,'CANULA DE GUADEL ','TALLA: 0 (AZUL)',' CANULA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(429,'CANULA DE GUADEL ','TALLA: 1 (NEGRA)',' CANULA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(430,'CANULA DE GUADEL ','TALLA: 00 (ROSA)',' CANULA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(431,'CANULA DE GUADEL ','TALLA: 2 (BLANCA)',' CANULA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(432,'CANULA DE GUADEL ','TALLA: 3 (VERDE)',' CANULA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(433,'CANULA DE GUADEL ','TALLA: 4 (AMARILLA )',' CANULA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(434,'CANULA DE GUADEL ','TALLA: 5 (ROJA)',' CANULA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(435,'CANULA DE GUADEL ','TALLA: 6 (NARANJA)',' CANULA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(436,'CANULA DE GUADEL ','TALLA: 6 (AZUL)',' CANULA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(437,'CATETER ','14 G (NARANJA)',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(438,'CATETER ','16G (GRIS)',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(439,'CATETER ','18 G (VERDE)',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(440,'CATETER',' 17G (ROJO)',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(441,'CATETER',' 19G (AZUL)',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(442,'CATETER','20 G (ROSA)',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(443,'CATETER ','21G (BLANCO AZULADO)',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(444,'CATETER ','22 G  (AZUL CLARO)',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(445,'CATETER ','23G (MORADO)',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(446,'CATETER ','24 G (AMARILLO)',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(447,'CATETER ARROW ','3 LUMENES',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(448,'CATETER ARROW ','2 LUMENES',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(449,'CATETER HUMBILICAL ','3.5 FR',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(450,'CATETER HUMBILICAL ','5 FR',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(451,'CATETER DE 3 VIAS OCTOPUS ','7 FR',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(452,'CATETER TORACICO PLEURAL ','12 FR',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(453,'CATETER TORACICO PLEURAL ','16 FR',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(454,'CATETER TORACICO PLEURAL ','20 FR',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(455,'CATETER TORACICO PLEURAL ','24 FR',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(456,'CATETER TORACICO PLEURAL ','28 FR ',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(457,'CATETER TORACICO PLEURAL ','32 FR',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(458,'CATETER TORACICO PLEURAL ','36 FR',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(459,'CATETER EMBOLECTOMIA','5 FR',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(460,'CATETER EMBOLECTOMIA','3 FR',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(461,'CATETER EMBOLECTOMIA','4 FR',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(462,'CATETER EMBOLECTOMIA','7 FR',' CATETER','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(463,'CEPILLO CERVICAL','CITOBRUSH','CEPILLO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(464,'CEPILLO QUIRURGICO','CON GLUCONATO DE CLORHEXIDINA AL 4%','CEPILLO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(465,'CEPILLO QUIRURGICO','SIN DESINFECTANTE ','CEPILLO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(466,'CINTA MICROPORE ','1.25 CM',' CINTA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(467,'CINTA MICROPORE ','2.5 CM',' CINTA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(468,'CINTA MICROPORE ','5 CM',' CINTA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(469,'CINTA TESTIGO PARA OXIDO DE ETILENO','19 MM X 50 M',' CINTA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(470,'CINTA TESTIGO DE VAPOR','18 MM X 50 M ',' CINTA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(471,'CINTA TRANSPORE ','2.5 CM',' CINTA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(472,'CINTA TRANSPORE ','1.25 CM',' CINTA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(473,'CINTA TRANSPORE ','5 CM',' CINTA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(474,'CINTA TRANSPORE ','7.5 CM',' CINTA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(475,'TELA ADHESIVA ','7.5 CM',' CINTA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(476,'TELA ADHESIVA ','2.5 CM',' CINTA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(477,'TELA ADHESIVA ','1.25 CM',' CINTA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(478,'CIRCUITO DE ANESTESIA ','ADULTO','CIRCUITO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(479,'CIRCUITO DE ANESTESIA ','PEDIATRICO TALLA: 6','CIRCUITO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(480,'CONECTOR TIPO SIMS','DELGADO',' CONECTOR','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(481,'CONECTOR DP DE TITANIO','TENCKHOFF DP',' CONECTOR','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(482,'CONECTOR  TIPO SIMS','GRUESO',' CONECTOR','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(483,'CONECTOR  TIPO SIMS','(3 CONECTORES)',' CONECTOR','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(484,'CPAP SYSTEM INFANTIL','TALLA 0','CPAP','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(485,'CPAP SYSTEM INFANTIL','TALLA 1','CPAP','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(486,'CPAP SYSTEM INFANTIL','TALLA 2','CPAP','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(487,'CPAP SYSTEM INFANTIL','TALLA 3','CPAP','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(488,'EQUIPO DE BOMBA DE INFUSION ','INTRAVENOSA',' EQUIPO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(489,'EQUIPO DE BOMBA ','MARCA BAXTER',' EQUIPO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(490,'EQUIPO PARA ANESTESIA',' DURAL 111',' EQUIPO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(491,'EQUIPO PARA ANESTESIA ','RAQUIMIX',' EQUIPO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(492,'EQUIPO PARA APLICACION DE VOLUMNES MEDIDOS','100 ML (METRISET 100)',' EQUIPO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(493,'EQUIPO PARA DIALISIS PERITONEAL\n CON DOS COJINETES ','(COLA DE COCHINO)',' EQUIPO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(494,'EQUIPO PARA TRANSFUSION ','(HEMOTECK)',' EQUIPO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(495,'EQUIPO PARA VENOCLISIS EN FORMA DE MARIPOSA ','25 FR G',' EQUIPO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(496,'EQUIPO DE DRENAJE ','(DRENOVAC 1/4)',' EQUIPO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(497,'EQUIPO DE DRENAJE ','(DRENOVAC 1/8)',' EQUIPO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(498,'GUANTES  ','TALLA: 6',' GUANTES','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(499,'GUANTES ','TALLA: 6 1/2',' GUANTES','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(500,'GUANTES ','TALLA: 7',' GUANTES','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(501,'GUANTES',' TALLA: 7 1/2',' GUANTES','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(502,'GUANTES','TALLA: 8',' GUANTES','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(503,'GUANTES ','TALLA: 8 1/2',' GUANTES','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(504,'GUANTES DE EXPLORACION BOLSA \nESTERIL','TALLA: GRANDE',' GUANTES','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(505,'GUANTES DE LATEX DE CAJA','TALLA: MEDIANO',' GUANTES','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(506,'GUANTES DE NITRILO ','TALLA: 7',' GUANTES','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(507,'GASAS SIMPLE ESTERIL','10X10 CM ','GASAS','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(508,'GASAS CON TRAMA ','PAQUETE DE 200 PIEZAS','GASAS','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(509,'GASAS SIN TRAMA ','PAQUETE DE 200 PIEZAS','GASAS','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(510,'GASAS SIN TRAMA ','PAQUETE DE 200 PIEZAS','GASAS','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(511,'GORROS DE CIRUGIA DE RESORTE ','50 UNIDADES POR BOLSA',' GORROS','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(512,'GORROS DE CIRUGIA DE RESORTE ','100 UNIDADES POR BOLSA',' GORROS','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(513,'GORROS DE CIRUGIA PARA CIRUJANO ','100 UNIDADES POR BOLSA',' GORROS','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(514,'HOJAS DE BISTURI \nTALLA: 10','100 UNIDADES POR CAJA ',' BISTURI','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(515,'HOJAS DE BISTURI \nTALLA: 11','101 UNIDADES POR CAJA',' BISTURI','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(516,'HOJAS DE BISTURI \nTALLA: 15','100 UNIDADES POR CAJA ',' BISTURI','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(517,'HOJAS DE BISTURI\n TALLA: 20','100 UNIDADES POR CAJA ',' BISTURI','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(518,'HOJAS DE BISTURI\n TALLA: 21','100 UNIDADES POR CAJA',' BISTURI','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(519,'HOJAS DE BISTURI\n TALLA: 22','100 UNIDADES POR CAJA',' BISTURI','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(520,'HOJAS DE BISTURI\n TALLA: 23','100 UNIDADES POR CAJA',' BISTURI','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(521,'AGUA OXIGENADA','1 L',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(522,'AGUA OXIGENADA','480 ML',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(523,'ALCOHOL ','GARRAFAS DE 20 L',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(524,'ALKASEPTIC','1 L',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(525,'ALKAZYME (DETERGENTE ENZIMATICO)','BOLSA DE 12 DOSIS DE 20 G',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(526,'BAUMANOMETRO ','ANEROIDE',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(527,'BOMBA HOMEPUMP','ELASTOMERIC',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(528,'BOTAS QUIRURJICAS','50 UNI./ PAQUETE ',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(529,'BULTOS PARA CIRUGIA DESECHABLES','TALLA: UNIVERSAL',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(530,'CHUPONES PARA MAMILA ','LIBRE DE LATEX',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(531,'CINTA HUMBILICAL','LARGO: 41 CM',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(532,'CLORURO DE BENZALCONIO (BENZAL)','750 ML',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(533,'COLA DE RATON','GENERICO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(534,'COLLARIN CERVICAL','BLANDO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(535,'COMPRESAS','PAQUETE DE 5 ',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(536,'CUBIERTA PARA EMPUÃADURA ','ESTERIL',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(537,'CUBRE BOCA','PAQUETES DE 50 UNIDADES ',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(538,'DETERGENTE ENZIMATICO ','4 L',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(539,'DEXPANTENOL','5% CREMA',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(540,'DISPOSITIVO INTRAUTERINO ','(DIU)',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(541,'DRENAJE JACKSON PRATT','100 ML',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(542,'ELECTRODO DE AGUJA PARA ESU','7 CM',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(543,'ELECTRODOS  ','ADULTO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(544,'ELECTRODOS ','PEDIATRICOS',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(545,'ELECTROGEL','4 KG ',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(546,'ESPEJO VAGINAL ','DESECHABLE',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(547,'ETIQUETA PLASTICA ','NUMERADA',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(548,'FLUGOMETRO ','PURITAN O2',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(549,'FORMOL','1 L ',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(550,'FORMOL','4 L',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(551,'FORMULA LACTEA ','ENTEREX 131 G',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(552,'FORMULA LACTEA ','NUTRIBABY 225 G',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(553,'GAFIDEX (ALKASEPTIC)','4L',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(554,'HEMOSTATICO SATIN ','8 X4 CM',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(555,'HOJA LARINGO CURVA','FR: 4',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(556,'HOJA LARINGO CURVA','FR:5',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(557,'INDICADOR QUIMICO ','(200 PIEZAS)',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(558,'INSERCION DE CATETER URETRAL','5 FR   COOK MEDICAL ',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(559,'ISODINE ESPUMA','3.500 L',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(560,'ISODINE SOLUCION','3.500 L',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(561,'ISOPOS ','GRUESOS',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(562,'ISOPOS ','DELGADO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(563,'JABON CON CLORHEXIDINA ','AL 2 %, 950 ML ',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(564,'JABON EN BARRA','25 G ',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(565,'JABON QUIRURJICO','3.850 L',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(566,'JALEA','135 G ',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(567,'LANCETAS ','28 G ',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(568,'LENTES INTRAOCULARES ','27 D',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(569,'LINEA PARA DIALISIS PERITONEAL CORTA \n DE LARGA VIDA','(PISATEK DP)',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(570,'MANGO LARINGO',' ADULTO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(571,'MICRODACYN','240 ML',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(572,'MICROGOTERO','ADULTO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(573,'NEURO ESPONJAS','COTONOIDES',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(574,'NORMOGOTERO','ADULTO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(575,'PANTUNFLAS ','UNITALLA',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(576,'PAÃALES','10 UNIDADES POR PAQUETE',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(577,'PAÃALES','30 UNIDADES POR PAQUETE',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(578,'PERILLAS DE ASPIRACION ','DE HULE',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(579,'PINZAS CLAM ','GENERICAS',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(580,'PLACAS DE ELECTROCAUTERIO ','ADULTO/PEDIATRICO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(581,'PUNTAS DE ELECTROCAUTERIO','ADULTO/PEDIATRICO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(582,'PUNTAS NASALES',' ADULTO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(583,'PUNTAS NASALES ','PEDIATRICAS',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(584,'RASTRILLOS','MARCA SAFARI',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(585,'SHAMPOO','10 ML ',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(586,'SISTEMA DE DRENAJE TORÃCICO CERRADO \n','(PLEUR-EVAC)',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(587,'SUJETADOR HIBRIDO ','DE NITINOL',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(588,'TAPETE ADHESIVO','BACTERIOSTATIC',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(589,'TAPONES DE HEPARINA ','(SELLO VENOSO)',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(590,'TEGADERM','(FILM TRANSPARENTE)',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(591,'TIJERAS ','TIPO POLLERAS',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(592,'TINTURA DE BENJUI','1 L',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(593,'TIRAS REACTIVAS\n ','PARA GLUCOMETRO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(594,'VACUTANER','GENERICO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(595,'VALVULA 3 VIAS','(VALVULA LOPEZ)',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(596,'VASO ','CLINICO ESTERIL ',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(597,'VASO ','HUMIDIFICADOR ',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(598,'GEL FOAM','HEMOSTATICO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(599,'GEL FOAM ODONTOLOGICO','ODONTOLOGICO',' INSUMO','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(600,'JERINGA CON AGUJA','3 ML',' JERINGA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(601,'JERINGA SIN AGUJA','3 ML',' JERINGA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(602,'JERINJAS CON AGUJA ','5 ML',' JERINGA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(603,'JERINGA SIN AGUJA','5 ML',' JERINGA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(604,'JERINGA SIN AGUJA','10 ML',' JERINGA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(605,'JERINJAS CON AGUJA ','10 ML',' JERINGA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(606,'JERINGA SIN AGUJA','20 ML',' JERINGA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(607,'JERINGA CON AGUJA','20 ML',' JERINGA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(608,'JERINGA CON AGUJA','50 ML ',' JERINGA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(609,'JERINGA ','1 ML (INSULINA)',' JERINGA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(610,'JERINGA ASEPTO DE VIDRIO','50 ML ',' JERINGA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(611,'LLAVE DE 3 VIAS ','CON EXTENSION ',' LLAVE','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(612,'LLAVE DE 3 VIAS ','SIN EXTENSION ',' LLAVE','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(613,'LLAVE DE 4 VIAS ','CON EXTENSION ',' LLAVE','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(614,'MALLAS','','','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(615,'MALLA QUIRURGICA','25 A 35 CM X 25 A 35 CM',' MALLA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(616,'MALLA QUIRURGICA','MALTEX 15 CM X 15 CM ',' MALLA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(617,'MASCARILLA CON NEBULIZADOR ','ADULTO','MASCARILLA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(618,'MASCARILLA CON NEBULIZADOR ','INFALTIL','MASCARILLA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(619,'MASCARILLA CON RESERVORIO ','ADULTO','MASCARILLA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(620,'MASCARILLA FACIAL ','ADULTO','MASCARILLA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(621,'MASCARILLA FACIAL ','NEONATAL ','MASCARILLA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(622,'MASCARILLA LARINGEA','TALLA: 2','MASCARILLA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(623,'MASCARILLA LARINGEA','TALLA:  4','MASCARILLA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(624,'MASCARILLA LARINGEA','TALLA: 3','MASCARILLA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(625,'MASCARILLA LARINGEA','TALLA:  5','MASCARILLA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(626,'MASCARILLA SIN RESERVORIO ','ADULTO','MASCARILLA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(627,'MEDIAS ANTIEMBOLICAS','LARGA','MEDIA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(628,'MEDIAS ANTIEMBOLICAS','MEDIANA','MEDIA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(629,'MEDIAS ANTIEMBOLICAS','CHICA','MEDIA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(630,'PENROSE','1',' PENROSE','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(631,'PENROSE ','1/2',' PENROSE','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(632,'PENROSE ','1/4',' PENROSE','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(633,'PAPEL CRAF','(ROLLO)','PAPEL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(634,'PAPEL PARA ELECTROCARDIOGRAFO','6.2 CM','PAPEL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(635,'PAPEL PARA ELECTROCARDIOGRAFO','10.8 CM','PAPEL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(636,'DEXON ','3-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(637,'DEXON ','3-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(638,'MAXSORB','3-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(639,'MONOCRYL ','3-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(640,'POLIDIOXANONA ','3-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(641,'SUTURA CATGUT CROMICO SIMPLE ','0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(642,'SUTURA CATGUT CROMICO SIMPLE ','1-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(643,'SUTURA CATGUT CROMICO SIMPLE ','1-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(644,'SUTURA CATGUT CROMICO SIMPLE ','2-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(645,'SUTURA CATGUT CROMICO SIMPLE ','2-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(646,'SUTURA CATGUT CROMICO SIMPLE ','4-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(647,'SUTURA CERA','PARA HUESO',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(648,'SUTURA CROMICO',' 3-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(649,'SUTURA CROMICO ','4-0 A/CH DOBLE ARMADA ',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(650,'SUTURA CROMICO ','4-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(651,'SUTURA NAYLON ','2-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(652,'SUTURA NAYLON ','3-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(653,'SUTURA NYLON ','10-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(654,'SUTURA NYLON ','4-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(655,'SUTURA NYLON ','5-0  A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(656,'SUTURA NYLON ','6-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(657,'SUTURA POLIPROPILENO ','1-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(658,'SUTURA POLIPROPILENO ','2-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(659,'SUTURA POLIPROPILENO ','2-0 DOBLE ARMADA',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(660,'SUTURA POLIPROPILENO  ','3-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(661,'SUTURA POLIPROPILENO ','3-0 A/CH DOBLE ARMADA',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(662,'SUTURA POLIPROPILENO ','3-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(663,'SUTURA POLIPROPILENO ','3-0 DOBLE ARMADA',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(664,'SUTURA POLIPROPILENO ','5-0 A/CH DOBLE ARMADA',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(665,'SUTURA POLIPROPILENO ','6-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(666,'SUTURA POLIPROPILENO',' 6-0 A/CH DOBLE ARMADA',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(667,'SUTURA POLIPROPILENO  ','7-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(668,'SUTURA SEDA ','1-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(669,'SUTURA SEDA','1-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(670,'SUTURA SEDA','2-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(671,'SUTURA SEDA','2-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(672,'SUTURA SEDA ','3-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(673,'SUTURA SEDA ','3-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(674,'SUTURA SEDA ','7-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(675,'SUTURA SEDA ','7-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(676,'SUTURA SEDA LIBRE  ','0 SIN AGUJA',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(677,'SUTURA SEDA LIBRE  ','1-0 SIN AGUJA',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(678,'SUTURA SEDA LIBRE  ','2-0 SIN AGUJA',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(679,'SUTURA SEDA LIBRE ','3-0 SIN AGUJA ',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(680,'SUTURA VICRYL ','0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(681,'SUTURA VICRYL','0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(682,'SUTURA VICRYL ','1-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(683,'SUTURA VICRYL ','1-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(684,'SUTURA VICRYL ','2-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(685,'SUTURA VICRYL ','2-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(686,'SUTURA VICRYL ','3-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(687,'SUTURA VICRYL ','3-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(688,'SUTURA VICRYL ','4-0 A/CH',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(689,'SUTURA VICRYL ','5-0 A/G',' SUTURA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(690,'SONDA DE DRENAJE BILIAR KEHR, SONDA EN T','FR: 14',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(691,'SONDA DE DRENAJE BILIAR KEHR, SONDA EN T','FR: 16',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(692,'SONDA DE DRENAJE BILIAR KEHR, SONDA EN T','FR: 18',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(693,'SONDA FOLEY  DE DOS VIAS ','FR: 12 ',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(694,'SONDA FOLEY  DE DOS VIAS ','FR: 14',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(695,'SONDA FOLEY  DE DOS VIAS ','FR: 16',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(696,'SONDA FOLEY  DE DOS VIAS ','FR: 18 ',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(697,'SONDA FOLEY  DE DOS VIAS','FR: 20',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(698,'SONDA FOLEY  DE DOS VIAS ','FR: 22',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(699,'SONDA FOLEY  DE DOS VIAS ','FR: 24',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(700,'SONDA FOLEY DE TRES VIAS GLOBO 30 ','FR: 18 ',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(701,'SONDA FOLEY DE TRES VIAS GLOBO 30 ','FR: 20',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(702,'SONDA FOLEY DE TRES VIAS GLOBO 30 ','FR: 22',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(703,'SONDA FOLEY DE TRES VIAS GLOBO 30 ','FR: 24',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(704,'SONDA PARA ALIMENTACION INFANTIL CORTA','FR: 5 ',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(705,'SONDA PARA ALIMENTACION INFANTIL CORTA','FR: 5 (NO SECTOR SALUD)',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(706,'SONDA PARA ALIMENTACION INFANTIL CORTA','FR: 6 ',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(707,'SONDA PARA ALIMENTACION INFANTIL CORTA','FR: 8 ',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(708,'SONDA PARA ALIMENTACION INFANTIL CORTA','FR: 8 (NO SECTOR SALUD)',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(709,'SONDA PARA ASPIRACION DE SECRECIONES ','FR: 8',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(710,'SONDA PARA ASPIRACION DE SECRECIONES ','FR: 10 ',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(711,'SONDA PARA ASPIRACION DE SECRECIONES ','FR: 12 ',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(712,'SONDA PARA ASPIRACION DE SECRECIONES ','FR: 14',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(713,'SONDA PARA ASPIRACION DE SECRECIONES ','FR: 16',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(714,'SONDA PARA ASPIRACION DE SECRECIONES ','FR: 18',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(715,'SONDA PARA ASPIRACION DE SECRECIONES ','FR: 20',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(716,'SONDAS NELATON ','FR: 8',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(717,'SONDAS NELATON ','FR: 12 ',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(718,'SONDAS NELATON ','FR: 14',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(719,'SONDAS NELATON ','FR: 16',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(720,'SONDAS NELATON ','FR: 18 ',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(721,'SONDAS NELATON ','FR: 22 ',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(722,'SONDAS NELATON ','FR: 24',' SONDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(723,'SOLUCION ESTERIL ','500 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(724,'SOLUCION FISIOLOGICA','3000 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(725,'SOLUCION FISIOLOGICA','1000 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(726,'SOLUCION FISIOLOGICA',' 500 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(727,'SOLUCION FISIOLOGICA ','100 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(728,'SOLUCION FISIOLOGICA ','250 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(729,'SOLUCION FISIOLOGICA ','50 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(730,'SOLUCION GLUCOSA AL 5% ','1000 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(731,'SOLUCION GLUCOSA AL 5% ','250 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(732,'SOLUCION GLUCOSA AL 5% ','500 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(733,'SOLUCION GLUCOSA AL 10% ','1000 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(734,'SOLUCION GLUCOSA AL 10% ','500 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(735,'SOLUCION HARTMAN ','1000 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(736,'SOLUCION HARTMAN ','500 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(737,'SOLUCION HARTMAN ','250 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(738,'SOLUCION MIXTA ','1000 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(739,'SOLUCION MIXTA ','250 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(740,'SOLUCION MIXTA ','500 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(741,'SOLUCION GLUCOSA 50%','50 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(742,'SOLUCIONES DE AZUL DE TRIPANO','OCULAR ','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(743,'SOLUCION DIALISIS PERITONEAL ','1.5% 2000 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(744,'SOLUCION DIALISIS PERITONEAL ','2.5% 2000 ML','SOLUCION','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(745,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 3.0','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(746,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 3.5  ','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(747,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 4.0','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(748,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 4.5','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(749,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 5.0','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(750,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 5.5','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(751,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 6.0 ','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(752,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 6.5','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(753,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 7.0','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(754,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 7.5','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(755,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 8.0','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(756,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 8.5 ','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(757,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 9.0','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(758,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 9.5 ','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(759,'TUBO ENDOTRAQUEAL CON GLOBO','FR: 10.0','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(760,'TUBO ENDOTRAQUEAL DOBLE ARMADA','FR: 5.5 ','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(761,'TUBO ENDOTRAQUEAL DOBLE ARMADA','FR: 6.0 ','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(762,'TUBO ENDOTRAQUEAL DOBLE ARMADA','FR: 6.5 ','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(763,'TUBO ENDOTRAQUEAL DOBLE ARMADA','FR: 7.0','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(764,'TUBO ENDOTRAQUEAL SIN GLOBO','FR: 2.0','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(765,'TUBO ENDOTRAQUEAL SIN GLOBO','FR: 2.5','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(766,'TUBO ENDOTRAQUEAL SIN GLOBO','FR: 3.0','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(767,'TUBO ENDOTRAQUEAL SIN GLOBO','FR: 3.5 ','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(768,'TUBO ENDOTRAQUEAL SIN GLOBO','FR: 4.0','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(769,'TUBO ENDOTRAQUEAL SIN GLOBO','FR: 4.5 ','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(770,'TUBO ENDOTRAQUEAL SIN GLOBO','FR: 5.0','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(771,'TUBO ENDOTRAQUEAL SIN GLOBO','FR: 5.5 ','TUBO ENDOTRAQUEAL','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(772,'VENDA DE ALGODON ','5 CM ',' VENDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(773,'VENDA DE ALGODON ','10 CM',' VENDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(774,'VENDA DE ALGODON ','15 CM',' VENDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(775,'VENDA DE ALGODON ','30 CM',' VENDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(776,'VENDA DE GOMA TIPO SMART','10 CM',' VENDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(777,'VENDA DE GOMA TIPO SMART','15 CM',' VENDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(778,'VENDA DE MALLA ELASTICA EN FORMA TUBULAR (PEDIATRICO)','4 FR, 100 M',' VENDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(779,'VENDA DE YESO ','10 CM ',' VENDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(780,'VENDA DE YESO ','15 CM',' VENDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(781,'VENDA DE HUATA ','20 CM ',' VENDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(782,'VENDA DE HUATA ','15 CM ',' VENDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(783,'VENDA ELASTICA ADHESIVA','7.5 CM',' VENDA','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(784,'VENDA ELASTICA ADHESIVA','15 CM ',' VENDA','2026-02-12 21:46:57','2026-02-12 21:46:57');
/*!40000 ALTER TABLE `insumos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `interconsultas`
--

DROP TABLE IF EXISTS `interconsultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `interconsultas` (
  `id` bigint(20) unsigned NOT NULL,
  `criterio_diagnostico` text NOT NULL,
  `plan_de_estudio` text NOT NULL,
  `sugerencia_diagnostica` text NOT NULL,
  `ta` varchar(255) NOT NULL,
  `fc` int(11) NOT NULL,
  `fr` int(11) NOT NULL,
  `temp` decimal(5,2) NOT NULL,
  `peso` decimal(6,2) NOT NULL,
  `talla` int(11) NOT NULL,
  `motivo_de_la_atencion_o_interconsulta` text NOT NULL,
  `resumen_del_interrogatorio` text NOT NULL,
  `exploracion_fisica` text NOT NULL,
  `estado_mental` text NOT NULL,
  `resultados_relevantes_del_estudio_diagnostico` text NOT NULL,
  `diagnostico_o_problemas_clinicos` text NOT NULL,
  `tratamiento` text NOT NULL,
  `pronostico` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `interconsultas_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interconsultas`
--

LOCK TABLES `interconsultas` WRITE;
/*!40000 ALTER TABLE `interconsultas` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `interconsultas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `jobs` VALUES
(1,'default','{\"uuid\":\"bc18fa15-105f-4df9-9b19-0fc370467991\",\"displayName\":\"App\\\\Jobs\\\\GenerarBackupJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\GenerarBackupJob\",\"command\":\"O:25:\\\"App\\\\Jobs\\\\GenerarBackupJob\\\":1:{s:9:\\\"\\u0000*\\u0000userId\\\";i:7;}\"},\"createdAt\":1770932914,\"delay\":null}',1,1770932915,1770932914,1770932914);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `medicamento_vias`
--

DROP TABLE IF EXISTS `medicamento_vias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `medicamento_vias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `medicamento_id` bigint(20) unsigned NOT NULL,
  `catalogo_via_administracion_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medicamento_vias_medicamento_id_foreign` (`medicamento_id`),
  KEY `medicamento_vias_catalogo_via_administracion_id_foreign` (`catalogo_via_administracion_id`),
  CONSTRAINT `medicamento_vias_catalogo_via_administracion_id_foreign` FOREIGN KEY (`catalogo_via_administracion_id`) REFERENCES `catalogo_via_administracions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `medicamento_vias_medicamento_id_foreign` FOREIGN KEY (`medicamento_id`) REFERENCES `medicamentos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=310 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicamento_vias`
--

LOCK TABLES `medicamento_vias` WRITE;
/*!40000 ALTER TABLE `medicamento_vias` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `medicamento_vias` VALUES
(1,153,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(2,153,2,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(3,154,3,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(4,155,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(5,156,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(6,157,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(7,158,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(8,158,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(9,159,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(10,159,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(11,160,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(12,160,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(13,161,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(14,161,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(15,162,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(16,162,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(17,163,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(18,163,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(19,164,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(20,164,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(21,165,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(22,165,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(23,167,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(24,168,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(25,169,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(26,170,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(27,171,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(28,171,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(29,172,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(30,172,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(31,172,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(32,173,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(33,173,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(34,173,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(35,174,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(36,174,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(37,177,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(38,177,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(39,178,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(40,178,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(41,179,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(42,179,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(43,180,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(44,180,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(45,184,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(46,185,6,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(47,188,6,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(48,189,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(49,190,6,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(50,191,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(51,191,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(52,191,7,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(53,192,8,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(54,192,9,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(55,193,9,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(56,193,10,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(57,194,11,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(58,196,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(59,196,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(60,197,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(61,198,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(62,198,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(63,199,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(64,200,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(65,200,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(66,201,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(67,202,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(68,202,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(69,203,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(70,203,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(71,204,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(72,205,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(73,205,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(74,206,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(75,207,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(76,208,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(77,209,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(78,210,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(79,211,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(80,212,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(81,214,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(82,214,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(83,214,2,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(84,214,13,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(85,215,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(86,215,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(87,216,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(88,216,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(89,217,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(90,218,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(91,218,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(92,219,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(93,219,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(94,220,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(95,220,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(96,221,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(97,221,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(98,222,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(99,223,14,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(100,224,14,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(101,226,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(102,227,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(103,228,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(104,229,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(105,231,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(106,232,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(107,232,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(108,232,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(109,234,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(110,234,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(111,235,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(112,235,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(113,236,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(114,237,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(115,238,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(116,238,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(117,239,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(118,239,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(119,240,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(120,240,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(121,241,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(122,241,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(123,242,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(124,242,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(125,243,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(126,243,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(127,244,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(128,244,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(129,245,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(130,245,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(131,247,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(132,248,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(133,249,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(134,249,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(135,250,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(136,251,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(137,252,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(138,252,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(139,253,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(140,253,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(141,254,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(142,255,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(143,256,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(144,256,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(145,257,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(146,257,15,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(147,257,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(148,258,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(149,258,15,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(150,258,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(151,259,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(152,259,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(153,260,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(154,260,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(155,261,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(156,261,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(157,262,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(158,262,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(159,263,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(160,263,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(161,264,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(162,264,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(163,265,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(164,265,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(165,267,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(166,268,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(167,269,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(168,270,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(169,271,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(170,272,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(171,273,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(172,274,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(173,275,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(174,275,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(175,276,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(176,277,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(177,278,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(178,279,16,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(179,280,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(180,280,7,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(181,280,17,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(182,280,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(183,281,17,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(184,281,18,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(185,283,19,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(186,283,20,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(187,285,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(188,287,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(189,288,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(190,288,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(191,289,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(192,289,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(193,291,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(194,291,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(195,292,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(196,293,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(197,294,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(198,294,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(199,295,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(200,295,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(201,296,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(202,296,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(203,296,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(204,296,21,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(205,296,7,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(206,297,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(207,298,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(208,298,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(209,298,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(210,298,7,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(211,299,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(212,299,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(213,299,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(214,299,7,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(215,301,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(216,302,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(217,302,22,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(218,303,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(219,303,22,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(220,305,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(221,306,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(222,307,3,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(223,308,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(224,308,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(225,309,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(226,310,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(227,312,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(228,312,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(229,313,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(230,314,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(231,316,18,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(232,316,21,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(233,316,7,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(234,317,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(235,318,6,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(236,319,6,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(237,321,6,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(238,322,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(239,322,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(240,323,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(241,324,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(242,325,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(243,325,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(244,326,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(245,326,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(246,327,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(247,327,1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(248,328,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(249,329,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(250,330,4,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(251,331,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(252,332,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(253,333,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(254,334,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(255,335,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(256,336,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(257,337,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(258,338,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(259,339,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(260,340,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(261,341,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(262,342,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(263,343,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(264,344,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(265,345,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(266,346,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(267,347,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(268,348,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(269,349,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(270,350,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(271,351,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(272,352,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(273,353,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(274,354,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(275,355,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(276,356,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(277,357,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(278,358,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(279,359,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(280,360,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(281,361,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(282,362,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(283,363,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(284,364,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(285,365,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(286,366,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(287,367,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(288,368,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(289,369,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(290,370,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(291,371,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(292,372,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(293,373,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(294,374,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(295,375,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(296,376,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(297,377,12,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(298,378,23,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(299,379,23,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(300,380,23,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(301,381,24,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(302,382,5,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(303,383,23,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(304,384,23,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(305,385,25,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(306,386,26,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(307,387,26,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(308,388,26,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(309,389,27,'2026-02-12 21:46:57','2026-02-12 21:46:57');
/*!40000 ALTER TABLE `medicamento_vias` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `medicamentos`
--

DROP TABLE IF EXISTS `medicamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `medicamentos` (
  `id` bigint(20) unsigned NOT NULL,
  `excipiente_activo_gramaje` text NOT NULL,
  `volumen_total` decimal(8,2) NOT NULL,
  `nombre_comercial` varchar(255) NOT NULL,
  `gramaje` varchar(255) DEFAULT NULL,
  `fraccion` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `medicamentos_id_foreign` FOREIGN KEY (`id`) REFERENCES `producto_servicios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicamentos`
--

LOCK TABLES `medicamentos` WRITE;
/*!40000 ALTER TABLE `medicamentos` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `medicamentos` VALUES
(153,'ACETATO DE METILPREDNISOLONA  40 MG/ML',1.00,'ACETATO DE METILPREDNISOLONA ','40 MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(154,'ACETILCISTEINA  100 MG/ ML',1.00,'ACETILCISTEINA ','100 MG/ ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(155,'ACIDO ASCORBICO  1G/10 ML',10.00,'INFALET','1G/10 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(156,'ACIDO TRANEXAMICO 100 MG/ML',10.00,'ACIDO TRANEXAMICO','100 MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(157,'ACIDO TRANEXAMICO 500 MG/ 5 ML',5.00,'ACIDO TRANEXAMICO','500 MG/ 5 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(158,'ADEMETIONINA 500 MG',500.00,'SAMYR','500 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(159,'ALBUMINA HUMANA 12.5 G/50 ML',50.00,'KEDRIALB OCTALBIN','12.5 G/50 ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(160,'ALBUMINA HUMANA 12.5 G/50 ML',50.00,'KEDRIALB OCTALBIN','12.5 G/50 ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(161,'ALBUMINA HUMANA 12.5 G/50 ML',50.00,'KEDRIALB OCTALBIN','12.5 G/50 ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(162,'ALBUMINA HUMANA 12.5 G/50 ML',50.00,'OCTABIL','12.5 G/50 ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(163,'ALBUMINA HUMANA 12.5 G/50 ML',50.00,'OCTABIL','12.5 G/50 ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(164,'ALBUMINA HUMANA 12.5 G/50 ML',50.00,'HI-BUMIN','12.5 G/50 ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(165,'AMIKACINA  500 MG/2 ML',2.00,'AMIKACINA ','500 MG/2 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(166,'AMIKACINA 1GR ',0.00,'AMIKACINA 1GR','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(167,'AMINOFILINA 250 MG/10 ML',10.00,'AMOFILIN','250 MG/10 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(168,'AMINOFILINA 250 MG/10 ML',10.00,'AMOFILIN','250 MG/10 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(169,'AMIODARONA 150 MG/3 ML',3.00,'CIRTRENT','150 MG/3 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(170,'AMIODARONA 150 MG/3 ML',3.00,'CIRTRENT','150 MG/3 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(171,'AMPICILINA 1 G',1.00,'AMPICILINA','1 G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(172,'ATROPINA 1 ML/ 1 ML',1.00,'AMIXTERIA','1 ML/ 1 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(173,'ATROPINA 1 ML/ 1 ML',1.00,'AMIXTERIA','1 ML/ 1 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(174,'AVAPENA  20 MG/2 ML',2.00,'AVAPENA ','20 MG/2 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(175,'BECLOMETAZONA AEROSOL ',0.00,'BECLOMETAZONA AEROSOL','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(176,'BEPLENOVAX ',0.00,'BEPLENOVAX','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(177,'BESILATO DE CISATRACURIO 2 MG/ML',5.00,'BENSITRAK','2 MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(178,'BESILATO DE CISATRACURIO 2 MG/ML ',5.00,'BENSITRAK','2 MG/ML ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(179,'BETAMETASONA 8MG/2ML',2.00,'ERISPAN','8MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(180,'BETAMETASONA 8MG/2ML',2.00,'BETAMETASONA','8MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(181,'BETAMETASONA ',0.00,'BETAMETASONA','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(182,'BETAMETASONA ',0.00,'BETAMETASONA','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(183,'BETAMETASONA ',0.00,'BETAMETASONA','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(184,'BICARBONATO DE SODIO 7.5 %',10.00,'BICARNAT','7.5 %',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(185,'BROMURO DE IPRATOPIO, SALBUTAMOL 0.5MG/2.5MG',2.50,'BROMURO DE IPRATOPIO, SALBUTAMOL','0.5MG/2.5MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(186,'BROMURO DE IPRATROPIO ',0.00,'BROMURO DE IPRATROPIO','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(187,'BROMURO DE IPRATROPIO ',0.00,'BROMURO DE IPRATROPIO','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(188,'BROMURO DE TIOTROPIO 0.226MG/1ML',1.00,'RESPIMAT','0.226MG/1ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(189,'BROMURO DE VECURONIO 4 MG/ML',4.00,'NODESCRON','4 MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(190,'BUDESONIDA 0.250 MG/2ML',2.00,'LIBONIDE','0.250 MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(191,'BUPRENORFINA 0.3 MG/ML',1.00,'HERBANE','0.3 MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(192,'BUVACAINA GLUCOSA 150 MG/30 ML',30.00,'BUVACAINA','150 MG/30 ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(193,'BUVACAINA GLUCOSA 7.5 MG/ML',30.00,'BUVACAINA','7.5 MG/ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(194,'BUVACAINA PESADA 5 MG/1 ML',1.00,'BUVACAINA PESADA','5 MG/1 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(195,'CARBETOCINA 100 MCG/ML',1.00,'ANAFRAX','100 MCG/ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(196,'CEFALOTINA 1G',1.00,'CEFALOTINA','1G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(197,'CEFOTAXIMA 1G',1.00,'CEFOTAXIMA','1G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(198,'CEFOTAXIMA 1G/4 ML',1.00,'TAXISENSI','1G/4 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(199,'CEFTRIAXONA 1G',1.00,'CEFTRIAXONA','1G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(200,'CIPROFLOXACINO 1 G',1.00,'ABEFEN','1 G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(201,'CIPROFLOXACINO 200MG/100ML',100.00,'CIPROFLOXACINO','200MG/100ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(202,'CLINDAMICINA 600MG/4ML',4.00,'CLINDAMICINA','600MG/4ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(203,'CLINDAMICINA 600MG/4ML',4.00,'CLINDAMICINA','600MG/4ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(204,'CLONAZEPAM GOTAS 2.5 MG/ML',10.00,'CLONAZEPAM GOTAS','2.5 MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(205,'CLONIXINATO DE LISINA 100 MG/2 ML',2.00,'CLONIXINATO DE LISINA','100 MG/2 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(206,'CLORANFENICOL 5 MG/ML',15.00,'CLORANFENICOL','5 MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(207,'CLORANFENICOL 5MG/G',5.00,'OPKO','5MG/G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(208,'CLORHIDRATO DE MOXIFLOXACINO 400 MG',100.00,'CLORHIDRATO DE MOXIFLOXACINO','400 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(209,'CLORURO DE POTASIO 1.49GR / 5ML',5.00,'KELEFUSIN','1.49GR / 5ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(210,'CLORURO DE POTASIO 1.49GR / 5ML ',5.00,'KELEFUSIN','1.49GR / 5ML ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(211,'CLORURO DE SODIO 0.177',10.00,'CLORURO DE SODIO','0',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(212,'CLORURO DE SODIO 0.177',50.00,'CLORURO DE SODIO','0',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(213,'CLORURO DE SODIO ',0.00,'CLORURO DE SODIO','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(214,'DEXAMETASONA 8MG/2ML',2.00,'DEXAMETASONA','8MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(215,'DEXKETOPROFENO 50 MG/2ML',2.00,'KERAL','50 MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(216,'DEXKETOPROFENO 50 MG/2ML',2.00,'KERAL','50 MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(217,'DEXMEDETOMIDINA 200MCG/2 ML',2.00,'KAMADIX','200MCG/2 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(218,'DIAZEPAM 10 MG/2ML',2.00,'DIAZEPAM','10 MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(219,'DICLOFENACO 75MG/ 3ML',3.00,'DICLOFENACO','75MG/ 3ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(220,'DICLOFENACO 75MG/ 3ML',3.00,'DICLOFENACO','75MG/ 3ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(221,'DIFENIDOL 40MG/2ML',2.00,'DIFENIDOL','40MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(222,'DIGOXINA 0.5 MG MG/2ML',2.00,'DIGOXINA','0.5 MG MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(223,'DIPROPIONATO DE BECLOMETAZONA AEROSOL 50 MCG',12.80,'CLOFHIVEN','50 MCG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(224,'DIPROPIONATO DE BECLOMETAZONA AEROSOL 50 MCG ',12.80,'CLOFHIVEN','50 MCG ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(225,'DIPROPIONATO DE BECLOMETAZONA AEROSOL ',0.00,'DIPROPIONATO DE BECLOMETAZONA AEROSOL','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(226,'DOBUTAMINA 250MG/5ML',5.00,'DOBUJECT','250MG/5ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(227,'DOBUTAMINA 250MG/5ML',5.00,'DOBUJECT','250MG/5ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(228,'DOPAMINA 200MG/5ML',5.00,'INOTROPISA','200MG/5ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(229,'DOPAMINA 200MG/5ML',6.00,'DOPAMINA','200MG/5ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(230,'EFEDRINA ',0.00,'EFEDRINA','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(231,'ENOXOPARINA SODICA 40 MG 40MG/0.4ml',0.40,'ENOXOPARINA SODICA','40MG/0.4ml',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(232,'EPINEFRINA 1MG/ML',1.00,'PINADRINA','1MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(233,'ERGOMETRINA 0.2 MG/ML',0.00,'ERGOMETRINA','0.2 MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(234,'ERITROPOYECTINA HUMANA 4000 UL/ML',1.00,'EXETIN-A','4000 UL/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(235,'ETAMCILATO 250MG/2ML',2.00,'ETAMCILATO','250MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(236,'FENITOINA SODICA 250 MG/5 ML',5.00,'FENITOINA SODICA','250 MG/5 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(237,'FENITOINA SODICA 250 MG/5 ML',5.00,'DALMARIL','250 MG/5 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(238,'FENTANILO 0.5MG/10ML',10.00,'FENODID','0.5MG/10ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(239,'FITOMENADIONA (VITAMINA K) 10MG/1ML',1.00,'UNOKAVI','10MG/1ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(240,'FITOMENADIONA (VITAMINA K) 2MG/0.2ML',1.00,'UNOKAVI','2MG/0.2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(241,'FITOMENADIONA (VITAMINA K) 2MG/0.2ML',1.00,'UNOKAVI','2MG/0.2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(242,'FITOMENADIONA (VITAMINA K) 2MG/0.2ML',1.00,'UNOKAVI','2MG/0.2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(243,'FITOMENADIONA (VITAMINA K) 2MG/0.2ML',1.00,'UNOKAVI','2MG/0.2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(244,'FITOMENADIONA (VITAMINA K) 2MG/0.2ML',1.00,'UNOKAVI','2MG/0.2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(245,'FITOMENADIONA (VITAMINA K) 2MG/0.2ML',1.00,'UNOKAVI','2MG/0.2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(246,'FLUMAZENILL ',0.00,'FLUMAZENILL','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(247,'FOSFATO DE POTASIO 10 ML ',10.00,'PF-20','10 ML ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(248,'FOSFATO DE POTASIO 10 ML ',11.00,'PF-21','10 ML ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(249,'FUROSEMIDA 20MG/2ML',2.00,'FUROSEMIDA','20MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(250,'GELATINA SUCCINILADA 3.5 %',500.00,'GELATINA SUCCINILADA','3.5 %',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(251,'GELATINA SUCCINILADA 4 %',500.00,'GELAFUNDIN 4','4 %',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(252,'GENTAMICINA 80MG/2ML',2.00,'GENTAMICINA','80MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(253,'GENTAMICINA 80MG/2ML',2.00,'GENKOVA','80MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(254,'GLUCONATO DE CALCIO 10 %',10.00,'SOLUCION GC AL 10%','10 %',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(255,'GLUCOSA DEXTROSA AL 50% 25 G',50.00,'SOLUCION DX-50 ','25 G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(256,'HALOPERIDOL 5 MG/ML',1.00,'HALOPERIDOL','5 MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(257,'HEPARINA 1000 UL/ML',10.00,'INHEPAR','1000 UL/ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(258,'HEPARINA 1001 UL/ML',10.00,'INHEPAR','1001 UL/ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(259,'HIDRALAZINA AMP 20 MG/ML',1.00,'DINITRYL','20 MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(260,'HIDROCORTIZONA 100 MG',100.00,'HIDROCORTIZONA','100 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(261,'HIDROCORTIZONA 500 MG',500.00,'TISODANK','500 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(262,'HIDROCORTIZONA 500 MG',500.00,'FLEBONADROL','500 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(263,'HIERRO DEXTRAN 100MG/2ML',2.00,'HIERRO DEXTRAN','100MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(264,'HIOCINA /METAMIZOL SODICO 20MG-2.5GR /5 ML',5.00,'BUSCONET','20MG-2.5GR /5 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(265,'HIOCINA O BUTILHIOCINA 20MG/1ML',1.00,'HIOSCINA','20MG/1ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(266,'IMIPENEM ',0.00,'IMIPENEM','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(267,'IMIPENEM/CILASTATINA 500 MG/500 MG',1.00,'IMIPENEM/CILASTATINA','500 MG/500 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(268,'INSULINA CLARGINA 100 U/ML',10.00,'LANTUS','100 U/ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(269,'INSULINA CLARGINA 100 U/ML',10.00,'LANTUS','100 U/ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(270,'INSULINA CLARGINA 100 U/ML',10.00,'LANTUS','100 U/ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(271,'INSULINA HUMANA 100 UL/ML',10.00,'INSULEX','100 UL/ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(272,'INSULINA HUMANA 100 UL/ML',10.00,'INSULINA HUMANA','100 UL/ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(273,'INSULINA HUMANA RECOMBINANTE ISOFARICA 100 UL/ML',10.00,'INSULINA HUMANA RECOMBINANTE ISOFARICA','100 UL/ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(274,'KETOPROFENO 2 ML',2.00,'PROFENID','2 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(275,'KETOROLACO 30MG/1ML',1.00,'KETOROLACO','30MG/1ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(276,'L-ORNITINA L-ASPARTATO 5 G/10 ML',10.00,'HEPA-MERZ','5 G/10 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(277,'LAUROMACROGOL 60 MG/2 ML',2.00,'AETHOXYLEROL','60 MG/2 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(278,'LEVOFLOXACINO 500 MG/100 ML',100.00,'LEVOFLOXACINO','500 MG/100 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(279,'LIDOCAINA 0.1',115.00,'PHARMACAINE','0',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(280,'LIDOCAINA 20 MG/ML',50.00,'LIDOCAINA','20 MG/ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(281,'LIDOCAINA CON EPINEFRINA 20 MG/0.005 MG/1ML',50.00,'PISACAINA 2 % CON EPINEFRINA','20 MG/0.005 MG/1ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(282,'LIDOCAINA CON EPINEFRINA ',0.00,'LIDOCAINA CON EPINEFRINA','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(283,'LIDOCAINA HCL EPINEFRINA 36 MG, 18 MCG',1.80,'ZEYCO','36 MG, 18 MCG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(284,'LIDOCAINA ',0.00,'LIDOCAINA','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(285,'LOPROMIDA MEDIO DE CONTRASTE 300 MG/ ML',100.00,'ULTRAVIST','300 MG/ ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(286,'MEDIO DE CONTRASTE ',0.00,'MEDIO DE CONTRASTE','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(287,'MEROPENEM 1GR',1.00,'DIMETHYPER','1GR',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(288,'METAMIZOL SODICO 1MG/2ML',2.00,'METAMIZOL SODICO','1MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(289,'METILPREDNISOLONA 500MG',500.00,'METILPREDNISOLONA','500MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(290,'METILPREDNISOLONA ',100.00,'METILPREDNISOLONA','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(291,'METOCLOPRAMIDA 10MG/2ML',2.00,'METOCLOPRAMIDA','10MG/2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(292,'METRONIDAZOL 500 MG /100 ML',100.00,'METRIS','500 MG /100 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(293,'METRONIDAZOL 500 MG /100 ML',100.00,'OTROZOL','500 MG /100 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(294,'MIDAZOLAM 15MG/3ML',3.00,'MIDAZOLAM','15MG/3ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(295,'MIDAZOLAM 5MG/5ML',5.00,'RELACUM','5MG/5ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(296,'MORFINA 10MG/10ML',10.00,'GRATEN','10MG/10ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(297,'MULTIVITAMINAS 5.719 G ',10.00,'DEXTREVIT','5.719 G ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(298,'NABULFINA 10MG/1ML',1.00,'BUFIGEN','10MG/1ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(299,'NABULFINA 10MG/1ML',1.00,'BUFIGEN','10MG/1ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(300,'NALOXONA ',0.00,'NALOXONA','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(301,'NEOSTIGMINA 0.5GR/1ML',1.00,'PROSTIGMINE','0.5GR/1ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(302,'NOREPINEFRINA 4 MG/4 ML',4.00,'NOREPINEFRINA','4 MG/4 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(303,'NOREPINEFRINA 4 MG/4 ML',4.00,'NOREPINEFRINA','4 MG/4 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(304,'OCTREOTIDA ',0.00,'OCTREOTIDA','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(305,'OMEOPRAZOL 40 MG',40.00,'OMEOPRAZOL','40 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(306,'ONDASETRON 8MG/4ML',4.00,'HT-BLOC','8MG/4ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(307,'OXIMETAZOLINA 20 ML',20.00,'AFRIN','20 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(308,'OXITOCINA 5 UL/ 1ML',1.00,'OXITOPISA','5 UL/ 1ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(309,'PANTOPRAZOL 40 MG',40.00,'SUPACID','40 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(310,'PARACETAMOL 1G/100 ML',100.00,'SENSIFAZOL','1G/100 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(311,'PARCHE DE NITROGLICERINA ',0.00,'PARCHE DE NITROGLICERINA','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(312,'PAREXCOBIT 40 MG',40.00,'KENEXIB','40 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(313,'PROPOFOL 10 MG/ML',100.00,'RECOFOL','10 MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(314,'PROPOFOL 200 MG/20ML',20.00,'VALFOPROX','200 MG/20ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(315,'ROCURONIO ',0.00,'ROCURONIO','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(316,'ROPIVACAINA 7.5% 7.5MG/1ML ',20.00,'ROPICONEST','7.5MG/1ML ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(317,'SACARATO FERRICO 100 MG/5ML',5.00,'VENOFERRUM','100 MG/5ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(318,'SALBUTAMOL 5 MG/ML',10.00,'SALBUTAMOL','5 MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(319,'SALBUTAMOL SPRAY 100 MCG',0.02,'BRESALTEC','100 MCG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(320,'SALMETEROL, FLUTICASONA ',0.00,'ULFHINLAS-AIR','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(321,'SEVOFLURANO (250 ML POR FRASCO) 250 ML',250.00,'SOVENER','250 ML',1,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(322,'SULFATO DE MAGNESIO 10% 1G/10ML  ',10.00,'MAGNEFUSIN','10% 1G/10ML  ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(323,'TERLIPRESINA 1 MG',1.00,'FHIPOL','1 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(324,'TERLIPRESINA 1 MG',1.00,'GLYPRESSIN','1 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(325,'TRAMADOL 100 MG/ 2ML',2.00,'TRAMADOL','100 MG/ 2ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(326,'TRIMEBUTINA 50 MG/5ML',5.00,'LIBERTRIM','50 MG/5ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(327,'TRIMEBUTINA 50 MG/5ML',5.00,'LIBERTRIM','50 MG/5ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(328,'VANCOMICINA 500 MG',500.00,'VANCOMICINA','500 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(329,'VANCOMICINA 500 MG',500.00,'VANCOMICINA','500 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(330,'VITAMINAS -',0.00,'VITAFUSIN','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(331,'ACETIL SALISILICO 500 MG',0.00,'ASPIRINA','500 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(332,'ACIDO ASCORBICO 1G',1.00,'REDOXON','1G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(333,'AMLODIPINO 5 MG',5.00,'ZAGAPSOL','5 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(334,'AZITROMICINA  ',0.00,'AZITROMICINA ','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(335,'CAPTOPRIL 25 MG',0.00,'CAPTOPRIL','25 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(336,'CEFIXIMA  100 MG/ 5 ML',25.00,'CECILET','100 MG/ 5 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(337,'CEFUROXIMA 250 MG/5 ML ',0.00,'CEFUROXIMA','250 MG/5 ML ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(338,'CELECOXIB 200 MG',200.00,'CELECOXIB','200 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(339,'CINITAPRIDA 1 MG',1.00,'CINITAPRIDA','1 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(340,'CIPROFLOXACINO 500 MG',500.00,'BACPROIN','500 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(341,'CLINDAMICINA 300 MG',300.00,'CLINDAMICINA','300 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(342,'CLOPIDOGREL 75 MG',75.00,'CLOPIDOGREL','75 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(343,'DAPAGLIFLOZINA 10 MG',10.00,'DAPAGLIFLOZINA','10 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(344,'DICLOFENACO 100 MG',100.00,'DICLOFENACO','100 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(345,'DINITRITO DE ISOSORBIDA 5 MG',5.00,'DEBISOR ','5 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(346,'ERDOSTEINA 175 MG/ 5 ML',90.00,'DOSTEIN','175 MG/ 5 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(347,'ESPIROLACTONA 25 MG',25.00,'ESPIROLACTONA','25 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(348,'ETORICOXIB 90 MG',90.00,'ETORICOXIB','90 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(349,'HIOCINA CON METAMIZOL SODICO  10 MG',0.00,'BUSCAPINA','10 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(350,'IBUPROFENO 2 G/ 100 ML',120.00,'MOTRIN','2 G/ 100 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(351,'IBUPROFENO 400 MG',400.00,'GELUBRIN','400 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(352,'INDAPAMIDA 1.5 MG',1.50,'NATRILIX','1.5 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(353,'LACTULOSA 66. 7G /100 ML',120.00,'LACTULOSA','66. 7G /100 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(354,'LORATADINA 10 G',10.00,'LORATADINA','10 G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(355,'LOSARTAN  50 MG',50.00,'LOSARTAN ','50 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(356,'LOSARTAN/AMLOPIDINO 100 MG/5MG ',100.00,'LODESTAR-DUO','100 MG/5MG ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(357,'MEGALDRATO,DIMETICONA 80 MG, 10 MG, 1 ML',0.00,'MEGALDRATO,DIMETICONA','80 MG, 10 MG, 1 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(358,'METFORMINA  850 MG ',850.00,'PREDIALPLUS','850 MG ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(359,'METOPROLOL 100 MG',100.00,'METOPROLOL','100 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(360,'METOPROLOL ',0.00,'METOPROLOL','',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(361,'MISOPROSTOL 200 MG',200.00,'CYRUX','200 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(362,'MISOPROSTOL 200 MG',200.00,'CYRUX','200 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(363,'NIFEDIPINO 30 MG',30.00,'NIFEDIPINO','30 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(364,'OMEOPRAZOL 20 MG',0.00,'OMEOPRAZOL','20 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(365,'PARACETAMOL 500 MG',500.00,'PORTEM','500 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(366,'PREGABALINA 150 MG',150.00,'PREGABALINA','150 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(367,'PREGABALINA 75 MG',75.00,'VIRAVIR','75 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(368,'PROGESTERONA 200 MG',200.00,'GESLUTIN','200 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(369,'SALBUTAMOL, AMBROXOL 40 MG, 150 MG/100 ML',0.00,'SALBUTAMOL, AMBROXOL','40 MG, 150 MG/100 ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(370,'SENOSIDOS A-B 8.6 MG',8.60,'NOVAKOSID','8.6 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(371,'STOMAHESIVE 28.3 G',0.00,'STOMAHESIVE','28.3 G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(372,'TELMISARTAN 40 MG',40.00,'TELMISARTAN','40 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(373,'TINITRATO DE GLICERILO 18 MG ',18.00,'MINITRAN','18 MG ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(374,'TRIMEBUTINA 200 MG',0.00,'ESPABION','200 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(375,'TRIMETOPRIMA Y SULFAMETOXAZOL 100 MG-800 MG',160.00,'BACTELAN','100 MG-800 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(376,'VITAMINAS 500 MG ',500.00,'PRENA MAX CAPSULAS','500 MG ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(377,'CARBON ACTIVADO  100 G,POLVO',100.00,'CARBON ACTIVADO ','100 G,POLVO',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(378,'CLORANFENICOL   5 MG/ML',15.00,'FENICOL','5 MG/ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(379,'CLORANFENICOL  5 MG/G',5.00,'CLORANFENICOL ','5 MG/G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(380,'CLORANFENICOL  6 MG/G',5.00,'CLORANFENICOL ','6 MG/G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(381,'CONDONES SIN DATOS ',0.00,'POSSESS','SIN DATOS ',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(382,'ETONOGESTREL 68 MG',68.00,'IMPLANON','68 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(383,'HIPROMELOSA 0.5 %',11.00,'HIPROMELOSA','0.5 %',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(384,'HIPROMELOSA 5 MG/ ML',10.00,'HIPROMELOSA','5 MG/ ML',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(385,'LEVONORGESTREL 52.00 MG',52.00,'MIRENA','52.00 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(386,'LIDOCAINA UNGUENTO 5% TUBO CON 35 G',35.00,'LIDOCAINA UNGUENTO','5% TUBO CON 35 G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(387,'MUPIRUCINA 2 G',15.00,'BERNIVER','2 G',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(388,'PASTA PARA OSTOMIA  128 MG',128.00,'KARAYA 5','128 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(389,'SUPOSITORIOS DE INDOMETACINA 100 MG',100.00,'SUPOSITORIOS DE INDOMETACINA','100 MG',0,'2026-02-12 21:46:57','2026-02-12 21:46:57');
/*!40000 ALTER TABLE `medicamentos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2025_08_26_100418_add_two_factor_columns_to_users_table',1),
(5,'2025_09_21_060822_create_pacientes_table',1),
(6,'2025_09_21_121538_create_familiarresponsables_table',1),
(7,'2025_09_21_212345_create_credencial_empleados_table',1),
(8,'2025_09_21_213606_create_habitaciones_table',1),
(9,'2025_09_21_215115_create_estancias_table',1),
(10,'2025_09_21_222333_create_formularioscatalogo_table',1),
(11,'2025_09_21_232545_create_formulariosinstancia_table',1),
(12,'2025_10_01_194752_create_hoja_frontales_table',1),
(13,'2025_10_07_000648_create_permission_tables',1),
(14,'2025_10_07_201811_create_producto_servicios_table',1),
(15,'2025_10_07_230056_create_ventas_table',1),
(16,'2025_10_07_230100_create_detalle_ventas_table',1),
(17,'2025_10_08_154550_create_cargos_table',1),
(18,'2025_10_08_163901_create_personal_access_tokens_table',1),
(19,'2025_10_09_075345_create_cargo_table',1),
(20,'2025_10_10_142605_create_histories_table',1),
(21,'2025_10_12_173632_create_historia_clinicas_table',1),
(22,'2025_10_12_204052_create_catalogo_preguntas_table',1),
(23,'2025_10_12_204235_create_respuesta_formularios_table',1),
(24,'2025_10_13_071544_create_interconsultas_table',1),
(25,'2025_10_16_093520_drop_id_user_from_credencial_empleados',1),
(26,'2025_10_23_095448_create_honorarios_table',1),
(27,'2025_10_24_195659_create_hoja_enfermerias_table',1),
(28,'2025_10_24_213534_create_hoja_registros_table',1),
(29,'2025_10_24_213626_create_hoja_medicamentos_table',1),
(30,'2025_10_24_213908_create_hoja_terapias_table',1),
(31,'2025_10_25_005234_create_dispositivo_pacientes_table',1),
(32,'2025_10_28_171932_create_notifications_table',1),
(33,'2025_10_30_140747_create_hoja_sonda_cateters_table',1),
(34,'2025_11_01_150109_create_traslado_table',1),
(35,'2025_11_01_153848_create_aplicacion_medicamentos_table',1),
(36,'2025_11_03_112504_create_catalogo_estudios_table',1),
(37,'2025_11_03_112624_create_solicitud_estudios_table',1),
(38,'2025_11_03_112805_create_solicitud_items_table',1),
(39,'2025_11_03_140519_create_solicitud_patologias_table',1),
(40,'2025_11_06_221237_create_catalogo_dietas_table',1),
(41,'2025_11_07_120836_create_preoperatorios_table',1),
(42,'2025_11_08_130427_create_nota_postoperatorias_table',1),
(43,'2025_11_08_160100_create_nota_urgencias',1),
(44,'2025_11_08_165503_create_transfusion_realizadas_table',1),
(45,'2025_11_08_174410_create_personal_empleados_table',1),
(46,'2025_11_13_130823_create_notas_egresos_table',1),
(47,'2025_11_15_145005_create_notas_evoluciones',1),
(48,'2025_11_17_130808_create_nota_postanestesicas_table',1),
(49,'2025_11_17_132335_create_nota_pre_anestesicas_table',1),
(50,'2025_11_22_153226_create_hoja_oxigenos_table',1),
(51,'2025_11_29_104617_create_hoja_enfermeria_quirofanos_table',1),
(52,'2025_12_01_145859_create_hoja_insumos_basicos_table',1),
(53,'2025_12_04_133724_create_consentimientos_table',1),
(54,'2025_12_11_115341_create_reservaciones_table',1),
(55,'2025_12_16_142234_create_customer_columns',1),
(56,'2025_12_16_142235_create_subscriptions_table',1),
(57,'2025_12_16_142236_create_subscription_items_table',1),
(58,'2025_12_16_142237_add_meter_id_to_subscription_items_table',1),
(59,'2025_12_16_142238_add_meter_event_name_to_subscription_items_table',1),
(60,'2025_12_20_105150_create_reservacion_quirofanos_table',1),
(61,'2025_12_23_120330_create_habitacion_precios_table',1),
(62,'2025_12_23_131835_create_reservacion_horarios_table',1),
(63,'2025_12_26_222526_create_check_list_items_table',1),
(64,'2025_12_29_110512_create_hoja_control_liquidos_table',1),
(65,'2025_12_29_110543_create_hoja_escala_valoracions_table',1),
(66,'2026_01_02_104552_create_categoria_dietas_table',1),
(67,'2026_01_02_105757_create_dietas_table',1),
(68,'2026_01_02_234249_create_solicitud_dietas_table',1),
(69,'2026_01_10_111045_create_valoracion_dolors_table',1),
(70,'2026_01_10_121840_create_hoja_riesgo_caidas_table',1),
(71,'2026_01_10_162048_create_hoja_habitus_exteriors_table',1),
(72,'2026_01_24_192049_add_itemable_to_solicitud_patologias_table',1),
(73,'2026_01_26_111417_add_column_saturacion_oxigeno_to_historia_clinicas',1),
(74,'2026_01_26_132435_add_tratamiento',1),
(75,'2026_01_26_144312_create_catalogo_via_administracions_table',1),
(76,'2026_01_26_150328_create_medicamentos_table',1),
(77,'2026_01_26_150427_create_insumos_table',1),
(78,'2026_01_26_150628_create_medicamento_vias_table',1),
(79,'2026_02_07_150900_create_backups_table',1),
(80,'2026_02_09_103659_create_encuesta_satisfaccions_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `model_has_roles` VALUES
(4,'App\\Models\\User',3),
(1,'App\\Models\\User',7),
(1,'App\\Models\\User',8),
(1,'App\\Models\\User',9),
(8,'App\\Models\\User',10),
(12,'App\\Models\\User',11),
(13,'App\\Models\\User',12),
(10,'App\\Models\\User',13),
(3,'App\\Models\\User',14),
(3,'App\\Models\\User',15),
(3,'App\\Models\\User',16),
(4,'App\\Models\\User',17),
(1,'App\\Models\\User',18),
(1,'App\\Models\\User',19),
(2,'App\\Models\\User',20),
(2,'App\\Models\\User',21),
(2,'App\\Models\\User',22),
(2,'App\\Models\\User',23),
(13,'App\\Models\\User',24),
(6,'App\\Models\\User',25);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `nota_egresos`
--

DROP TABLE IF EXISTS `nota_egresos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `nota_egresos` (
  `id` bigint(20) unsigned NOT NULL,
  `motivo_egreso` varchar(255) NOT NULL,
  `diagnosticos_finales` text NOT NULL,
  `resumen_evolucion_estado_actual` text NOT NULL,
  `manejo_durante_estancia` text NOT NULL,
  `problemas_pendientes` text NOT NULL,
  `plan_manejo_tratamiento` text NOT NULL,
  `recomendaciones` text NOT NULL,
  `factores_riesgo` text NOT NULL,
  `pronostico` text NOT NULL,
  `defuncion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `nota_egresos_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nota_egresos`
--

LOCK TABLES `nota_egresos` WRITE;
/*!40000 ALTER TABLE `nota_egresos` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `nota_egresos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `nota_postanestesicas`
--

DROP TABLE IF EXISTS `nota_postanestesicas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `nota_postanestesicas` (
  `id` bigint(20) unsigned NOT NULL,
  `ta` varchar(255) NOT NULL,
  `fc` int(11) NOT NULL,
  `fr` int(11) NOT NULL,
  `temp` double NOT NULL,
  `peso` double NOT NULL,
  `talla` int(11) NOT NULL,
  `resumen_del_interrogatorio` varchar(255) NOT NULL,
  `exploracion_fisica` varchar(255) NOT NULL,
  `resultado_estudios` varchar(255) NOT NULL,
  `diagnostico_o_problemas_clinicos` varchar(255) NOT NULL,
  `plan_de_estudio` varchar(255) NOT NULL,
  `pronostico` varchar(255) NOT NULL,
  `tratamiento` varchar(255) NOT NULL,
  `tecnica_anestesica` text NOT NULL,
  `farmacos_administrados` text NOT NULL,
  `duracion_anestesia` time NOT NULL,
  `incidentes_anestesia` text NOT NULL,
  `balance_hidrico` text NOT NULL,
  `estado_clinico` text NOT NULL,
  `plan_manejo` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `nota_postanestesicas_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nota_postanestesicas`
--

LOCK TABLES `nota_postanestesicas` WRITE;
/*!40000 ALTER TABLE `nota_postanestesicas` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `nota_postanestesicas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `nota_postoperatorias`
--

DROP TABLE IF EXISTS `nota_postoperatorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `nota_postoperatorias` (
  `id` bigint(20) unsigned NOT NULL,
  `ta` varchar(255) NOT NULL,
  `fc` int(11) NOT NULL,
  `fr` int(11) NOT NULL,
  `temp` double NOT NULL,
  `peso` double NOT NULL,
  `talla` int(11) NOT NULL,
  `resumen_del_interrogatorio` text NOT NULL,
  `exploracion_fisica` text NOT NULL,
  `resultado_estudios` text NOT NULL,
  `tratamiento` text NOT NULL,
  `diagnostico_o_problemas_clinicos` text NOT NULL,
  `plan_de_estudio` text NOT NULL,
  `pronostico` text NOT NULL,
  `hora_inicio_operacion` datetime NOT NULL,
  `hora_termino_operacion` datetime NOT NULL,
  `diagnostico_preoperatorio` text NOT NULL,
  `operacion_planeada` text NOT NULL,
  `operacion_realizada` text NOT NULL,
  `diagnostico_postoperatorio` text NOT NULL,
  `descripcion_tecnica_quirurgica` text NOT NULL,
  `hallazgos_transoperatorios` text NOT NULL,
  `reporte_conteo` text NOT NULL,
  `incidentes_accidentes` text NOT NULL,
  `cuantificacion_sangrado` text NOT NULL,
  `estado_postquirurgico` text NOT NULL,
  `manejo_dieta` text DEFAULT NULL,
  `manejo_soluciones` text DEFAULT NULL,
  `manejo_medicamentos` text DEFAULT NULL,
  `manejo_medidas_generales` text DEFAULT NULL,
  `manejo_laboratorios` text DEFAULT NULL,
  `hallazgos_importancia` text NOT NULL,
  `solicitud_patologia_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nota_postoperatorias_solicitud_patologia_id_foreign` (`solicitud_patologia_id`),
  CONSTRAINT `nota_postoperatorias_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `nota_postoperatorias_solicitud_patologia_id_foreign` FOREIGN KEY (`solicitud_patologia_id`) REFERENCES `solicitud_patologias` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nota_postoperatorias`
--

LOCK TABLES `nota_postoperatorias` WRITE;
/*!40000 ALTER TABLE `nota_postoperatorias` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `nota_postoperatorias` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `nota_pre_anestesicas`
--

DROP TABLE IF EXISTS `nota_pre_anestesicas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `nota_pre_anestesicas` (
  `id` bigint(20) unsigned NOT NULL,
  `ta` varchar(255) DEFAULT NULL,
  `fc` int(11) DEFAULT NULL,
  `fr` int(11) DEFAULT NULL,
  `peso` decimal(8,2) DEFAULT NULL,
  `talla` int(11) DEFAULT NULL,
  `temp` decimal(4,2) DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `resultado_estudios` text DEFAULT NULL,
  `resumen_del_interrogatorio` text DEFAULT NULL,
  `exploracion_fisica` text DEFAULT NULL,
  `diagnostico_o_problemas_clinicos` text DEFAULT NULL,
  `plan_de_estudio` text DEFAULT NULL,
  `pronostico` text DEFAULT NULL,
  `plan_estudios_tratamiento` text DEFAULT NULL,
  `evaluacion_clinica` text DEFAULT NULL,
  `plan_anestesico` text DEFAULT NULL,
  `valoracion_riesgos` text DEFAULT NULL,
  `indicaciones_recomendaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `nota_pre_anestesicas_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nota_pre_anestesicas`
--

LOCK TABLES `nota_pre_anestesicas` WRITE;
/*!40000 ALTER TABLE `nota_pre_anestesicas` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `nota_pre_anestesicas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `nota_urgencias`
--

DROP TABLE IF EXISTS `nota_urgencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `nota_urgencias` (
  `id` bigint(20) unsigned NOT NULL,
  `ta` varchar(255) NOT NULL,
  `fc` int(11) NOT NULL,
  `fr` int(11) NOT NULL,
  `temp` double NOT NULL,
  `peso` double NOT NULL,
  `talla` int(11) NOT NULL,
  `motivo_atencion` text NOT NULL,
  `resumen_interrogatorio` text NOT NULL,
  `exploracion_fisica` text NOT NULL,
  `estado_mental` text NOT NULL,
  `resultados_relevantes` text NOT NULL,
  `diagnostico_problemas_clinicos` text NOT NULL,
  `tratamiento` text NOT NULL,
  `pronostico` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `nota_urgencias_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nota_urgencias`
--

LOCK TABLES `nota_urgencias` WRITE;
/*!40000 ALTER TABLE `nota_urgencias` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `nota_urgencias` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `notas_evoluciones`
--

DROP TABLE IF EXISTS `notas_evoluciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `notas_evoluciones` (
  `id` bigint(20) unsigned NOT NULL,
  `evolucion_actualizacion` text NOT NULL,
  `ta` varchar(255) NOT NULL,
  `fc` int(11) NOT NULL,
  `fr` int(11) NOT NULL,
  `temp` decimal(5,2) DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `talla` decimal(5,2) DEFAULT NULL,
  `resultado_estudios` text DEFAULT NULL,
  `resumen_del_interrogatorio` text DEFAULT NULL,
  `exploracion_fisica` text DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `diagnostico_o_problemas_clinicos` text DEFAULT NULL,
  `plan_de_estudio` text DEFAULT NULL,
  `pronostico` text DEFAULT NULL,
  `manejo_dieta` text DEFAULT NULL,
  `manejo_soluciones` text DEFAULT NULL,
  `manejo_medicamentos` text DEFAULT NULL,
  `manejo_laboratorios` text DEFAULT NULL,
  `manejo_medidas_generales` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `notas_evoluciones_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notas_evoluciones`
--

LOCK TABLES `notas_evoluciones` WRITE;
/*!40000 ALTER TABLE `notas_evoluciones` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `notas_evoluciones` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `pacientes`
--

DROP TABLE IF EXISTS `pacientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pacientes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `curp` varchar(18) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido_paterno` varchar(100) NOT NULL,
  `apellido_materno` varchar(100) NOT NULL,
  `sexo` enum('Masculino','Femenino') NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `calle` varchar(100) NOT NULL,
  `numero_exterior` varchar(50) NOT NULL,
  `numero_interior` varchar(50) DEFAULT NULL,
  `colonia` varchar(100) NOT NULL,
  `municipio` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `estado_civil` enum('Soltero(a)','Casado(a)','Divorciado(a)','Viudo(a)','Union libre') NOT NULL,
  `ocupacion` varchar(100) NOT NULL,
  `lugar_origen` varchar(100) NOT NULL,
  `nombre_padre` varchar(255) DEFAULT NULL,
  `nombre_madre` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pacientes_curp_unique` (`curp`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pacientes`
--

LOCK TABLES `pacientes` WRITE;
/*!40000 ALTER TABLE `pacientes` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `pacientes` VALUES
(1,'MARP850101HDFLRS01','María','Ramírez','López','Femenino','1985-01-01','Av. Reforma','123','2B','Centro','Cuauhtémoc','Ciudad de México','México','06000','555-111-2233','Casado(a)','Contadora','Ciudad de México','Juan Ramírez','Elena López','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(2,'LOPE900305HDFGNS02','José','López','González','Masculino','1990-03-05','Calle Insurgentes','456',NULL,'Roma Norte','Cuauhtémoc','Ciudad de México','México','06700','555-222-3344','Soltero(a)','Ingeniero','Puebla','Carlos López','María González','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(3,'FERL750712MMNGRZ03','Lucía','Fernández','Martínez','Femenino','1975-07-12','Av. Morelos','789','5A','Chapultepec','Morelia','Michoacán','México','58000','555-333-4455','Divorciado(a)','Maestra','Morelia','Rafael Fernández','Laura Martínez','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(4,'GOME820914HGTPLD04','Pedro','Gómez','Paredes','Masculino','1982-09-14','Av. Hidalgo','101',NULL,'Centro','Guadalajara','Jalisco','México','44100','555-444-5566','Union libre','Mecánico','Guadalajara','Manuel Gómez','Isabel Paredes','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(5,'RUIE950221HNLTRS05','Elena','Ruiz','Treviño','Femenino','1995-02-21','Calle Juárez','567','3C','Obrera','Monterrey','Nuevo León','México','64000','555-555-6677','Soltero(a)','Diseñadora','Monterrey','Héctor Ruiz','Marta Treviño','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(6,'SANM700811HOCGRD06','Miguel','Sánchez','Morales','Masculino','1970-08-11','Av. Independencia','890',NULL,'Centro','Oaxaca de Juárez','Oaxaca','México','68000','555-666-7788','Viudo(a)','Carpintero','Oaxaca','Domingo Sánchez','Juana Morales','2026-02-12 21:46:56','2026-02-12 21:46:56');
/*!40000 ALTER TABLE `pacientes` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `permissions` VALUES
(1,'crear pacientes','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(2,'consultar pacientes','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(3,'editar pacientes','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(4,'eliminar pacientes','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(5,'crear estancias','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(6,'consultar estancias','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(7,'editar estancias','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(8,'eliminar estancias','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(9,'crear hojas frontales','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(10,'consultar hojas frontales','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(11,'editar hojas frontales','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(12,'eliminar hojas frontales','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(13,'crear habitaciones','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(14,'consultar habitaciones','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(15,'editar habitaciones','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(16,'eliminar habitaciones','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(17,'crear colaboradores','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(18,'consultar colaboradores','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(19,'editar colaboradores','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(20,'eliminar colaboradores','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(21,'crear productos y servicios','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(22,'consultar productos y servicios','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(23,'editar productos y servicios','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(24,'eliminar productos y servicios','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(25,'consultar historial','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(26,'consultar ventas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(27,'eliminar ventas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(28,'editar ventas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(29,'crear ventas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(30,'consultar detalles ventas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(31,'eliminar detalles ventas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(32,'editar detalles ventas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(33,'crear detalles ventas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(34,'crear hojas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(35,'consultar hojas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(36,'editar hojas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(37,'eliminar hojas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(38,'crear hojas enfermerias','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(39,'consultar hojas enfermerias','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(40,'eliminar hojas enfermerias','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(41,'crear solicitudes estudios','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(42,'editar solicitudes estudios','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(43,'consultar solicitudes estudios','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(44,'eliminar solicitudes estudios','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(45,'crear solicitudes estudios patologicos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(46,'editar solicitudes estudios patologicos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(47,'consultar solicitudes estudios patologicos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(48,'eliminar solicitudes estudios patologicos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(49,'crear documentos medicos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(50,'consultar documentos medicos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(51,'crear consentimientos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(52,'consultar dietas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(53,'crear dietas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(54,'eliminar dietas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(55,'editar dietas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(56,'consultar base de datos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(57,'respaldar base de datos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(58,'restaurar base de datos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(59,'consultar peticion medicamentos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(60,'editar peticion medicamentos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(61,'crear peticion medicamentos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(62,'consultar peticion dietas','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(63,'editar peticion dietas','web','2026-02-12 21:46:57','2026-02-12 21:46:57');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `personal_empleados`
--

DROP TABLE IF EXISTS `personal_empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_empleados` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `itemable_type` varchar(255) NOT NULL,
  `itemable_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `cargo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `personal_empleados_itemable_type_itemable_id_index` (`itemable_type`,`itemable_id`),
  KEY `personal_empleados_user_id_foreign` (`user_id`),
  CONSTRAINT `personal_empleados_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_empleados`
--

LOCK TABLES `personal_empleados` WRITE;
/*!40000 ALTER TABLE `personal_empleados` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `personal_empleados` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `preoperatorios`
--

DROP TABLE IF EXISTS `preoperatorios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `preoperatorios` (
  `id` bigint(20) unsigned NOT NULL,
  `fecha_cirugia` date NOT NULL,
  `diagnostico_preoperatorio` text NOT NULL,
  `plan_quirurgico` text NOT NULL,
  `tipo_intervencion_quirurgica` text NOT NULL,
  `ta` varchar(255) NOT NULL,
  `fc` int(11) NOT NULL,
  `fr` int(11) NOT NULL,
  `peso` decimal(8,2) NOT NULL,
  `talla` int(11) NOT NULL,
  `temp` decimal(4,2) NOT NULL,
  `resultado_estudios` text NOT NULL,
  `resumen_del_interrogatorio` text NOT NULL,
  `exploracion_fisica` text NOT NULL,
  `diagnostico_o_problemas_clinicos` text NOT NULL,
  `plan_de_estudio` text NOT NULL,
  `pronostico` text NOT NULL,
  `tratamiento` text NOT NULL,
  `riesgo_quirurgico` varchar(255) NOT NULL,
  `cuidados_plan_preoperatorios` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `preoperatorios_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preoperatorios`
--

LOCK TABLES `preoperatorios` WRITE;
/*!40000 ALTER TABLE `preoperatorios` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `preoperatorios` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `producto_servicios`
--

DROP TABLE IF EXISTS `producto_servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_servicios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL,
  `subtipo` varchar(255) NOT NULL,
  `codigo_prestacion` varchar(255) DEFAULT NULL,
  `codigo_barras` varchar(255) DEFAULT NULL,
  `nombre_prestacion` varchar(200) NOT NULL,
  `importe` decimal(8,2) NOT NULL DEFAULT 0.10,
  `importe_compra` decimal(8,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `cantidad_maxima` int(11) DEFAULT NULL,
  `cantidad_minima` int(11) DEFAULT NULL,
  `proveedor` varchar(255) DEFAULT NULL,
  `fecha_caducidad` date DEFAULT NULL,
  `iva` decimal(8,2) NOT NULL DEFAULT 16.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `producto_servicios_codigo_barras_index` (`codigo_barras`)
) ENGINE=InnoDB AUTO_INCREMENT=787 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_servicios`
--

LOCK TABLES `producto_servicios` WRITE;
/*!40000 ALTER TABLE `producto_servicios` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `producto_servicios` VALUES
(1,'SERVICIO','ADMISION  ','	80161602-03',NULL,'ENTREGA DE RESULTADO DE LABORATORIOS',174.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(2,'SERVICIO','ADMISION  ','	80161602-04',NULL,'ENTREGA DE RESULTADOS DE PATOLOGIA',174.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(3,'SERVICIO','ADMISION  ','	80161602-02',NULL,'LLENADO DE CONSENTIMIENTOS QUIRURJICOS',174.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(4,'SERVICIO','ADMISION  ','	80161602-05',NULL,'RECORDATORIO DE CITAS',174.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(5,'SERVICIO','ADMISION  ','	80161602-01',NULL,'REGISTRO DE PACIENTE ',174.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(6,'SERVICIO','CONSULTA GENERAL','	85121601-03',NULL,'CONSULTA PROGRAMADA',290.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(7,'SERVICIO','CONSULTA GENERAL','	85121601-04',NULL,'CONSULTA URGENTE',406.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(8,'SERVICIO','CONSULTA GENERAL','	85121601-02',NULL,'HONORARIOS QUIRURJICOS SEGUNDO AYUDANTE',1740.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(9,'SERVICIO','CONSULTA GENERAL','	85121601-01',NULL,'HONORARIOS QUIRURJICOS/AYUDANTIA',2320.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(10,'SERVICIO','GINECOLOGIA','85121601-10',NULL,'CULTIVO',500.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(11,'SERVICIO','GINECOLOGIA','	85121601-05',NULL,'HONORARIOS QUIRURJICOS GINECOLOGICO',4640.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(12,'SERVICIO','GINECOLOGIA','	85121601-08',NULL,'INTERCONSULTA PROGRAMADA',1740.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(13,'SERVICIO','GINECOLOGIA','	85121601-09',NULL,'INTERCONSULTA URGENTE',2320.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(14,'SERVICIO','GINECOLOGIA','	85121601-06',NULL,'VPO(VALUACION PREOPERATORIA) PROGRAMADA',1160.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(15,'SERVICIO','GINECOLOGIA','	85121601-07',NULL,'VPO(VALUACION PREOPERATORIA) URGENTE',1740.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(16,'SERVICIO','CIRUGIA GENERAL','	85121600_03',NULL,'HONORARIOS QUIRURJICOS CIRUGIA GENERAL',4640.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(17,'SERVICIO','CIRUGIA GENERAL','	85121600_01',NULL,'INTERCONSULTA',1740.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(18,'SERVICIO','CIRUGIA GENERAL','	85121600_02',NULL,'INTERCONSULTA',2320.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(19,'SERVICIO','MEDICINA INTERNA','	85121600_06',NULL,'MANEJO HOSPITALARIO',2320.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(20,'SERVICIO','MEDICINA INTERNA','85121600_07',NULL,'MANEJO HOSPITALARIO',4640.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(21,'SERVICIO','MEDICINA INTERNA','85121600_04',NULL,'VPO (EVALUCION PREOPERATORIA)',1740.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(22,'SERVICIO','MEDICINA INTERNA','	85121600_05',NULL,'VPO (EVALUCION PREOPERATORIA) URGENTE',2900.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(23,'SERVICIO','TRAUMATOLOGIA','	85121600_10',NULL,'HONORARIOS QUIRURJICOS TRAUMATOLOGIA',0.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(24,'SERVICIO','TRAUMATOLOGIA','	85121600_08',NULL,'INTERCONSULTA PROGRAMADA',1740.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(25,'SERVICIO','TRAUMATOLOGIA','	85121600_09',NULL,'INTERCONSULTA URGENTE',2320.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(26,'SERVICIO','OTORRINO','	85121600_13',NULL,'HONORARIOS QUIRURJICOS OTORRINO',0.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(27,'SERVICIO','OTORRINO','	85121600_11',NULL,'INTERCONSULTA PROGRAMADA',1740.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(28,'SERVICIO','OTORRINO','	85121600_12',NULL,'INTERCONSULTA URGENTE',2320.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(29,'SERVICIO','NEFROLOGIA','	85121600_18',NULL,'HONORARIOS QUIRURJICOS DE NEFROLOGIA',0.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(30,'SERVICIO','NEFROLOGIA','	85121600_16',NULL,'MANEJO HOSPITALARIO',2320.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(31,'SERVICIO','NEFROLOGIA','	85121600_17',NULL,'MANEJO HOSPITALARIO',4640.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(32,'SERVICIO','NEFROLOGIA','	85121600_14',NULL,'VPO (EVALUCION PREOPERATORIA)',1740.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(33,'SERVICIO','NEFROLOGIA','	85121600_15',NULL,'VPO (EVALUCION PREOPERATORIA) URGENTE',2900.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(34,'SERVICIO','RX','	85121808_03',NULL,'A DOMICILIO',1624.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(35,'SERVICIO','RX','	85121808_01',NULL,'ESTUDIOS PREOPERATORIO',232.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(36,'SERVICIO','RX','	85121808_05',NULL,'FISIOTERAPIA',464.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(37,'SERVICIO','RX','	85121808_04',NULL,'INTERPRETACION ',116.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(38,'SERVICIO','RX','	85121808_06',NULL,'PAQUETE DE 10 SESIONES',4872.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(39,'SERVICIO','RX','	85121808_02',NULL,'RAYOS X (CUALQUIER ZONA) POR TOMA',371.20,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(40,'SERVICIO','RX','	85121808_10',NULL,'RESONANCIA MAGNETICA CONSTRASTADA',5568.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(41,'SERVICIO','RX','	85121808_09',NULL,'RESONANCIA MAGNETICA SIMPLE ',5220.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(42,'SERVICIO','RX','	85121808_08',NULL,'TOMOGRAFIA CONSTRASTADA',4408.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(43,'SERVICIO','RX','	85121808_07',NULL,'TOMOGRAFIAS SIMPLE',4060.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(44,'SERVICIO','RX URGENTES','	85121808_13',NULL,'A DOMICILIO',3248.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(45,'SERVICIO','RX URGENTES','	85121808_11',NULL,'ESTUDIOS PREOPERATORIO',928.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(46,'SERVICIO','RX URGENTES','	85121808_15',NULL,'FISIOTERAPIA',464.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(47,'SERVICIO','RX URGENTES','	85121808_14',NULL,'INTERPRETACION ',348.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(48,'SERVICIO','RX URGENTES','	85121808_16',NULL,'PAQUETE DE 10 SESIONES',4915.05,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(49,'SERVICIO','RX URGENTES','	85121808_12',NULL,'RAYOS X (CUALQUIER ZONA) POR TOMA',928.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(50,'SERVICIO','RX URGENTES','	85121808_20',NULL,'RESONANCIA MAGNETICA CONSTRASTADA',6728.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(51,'SERVICIO','RX URGENTES','	85121808_19',NULL,'RESONANCIA MAGNETICA SIMPLE ',6380.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(52,'SERVICIO','RX URGENTES','	85121808_18',NULL,'TOMOGRAFIA CONSTRASTADA',5568.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(53,'SERVICIO','RX URGENTES','	85121808_17',NULL,'TOMOGRAFIAS SIMPLE',5220.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(54,'SERVICIO','RX EN QUIROFANO','	85121808_21',NULL,'USO DE ARCO EN C',8120.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(55,'SERVICIO','RX EN QUIROFANO','	85121808_22',NULL,'USO DE RAYOS X PORTATIL',812.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(56,'SERVICIO','ESTUDIOS','	85121800_03',NULL,'ELECTROCARDIOGRAMA DE VERIFICACION POR FALLECIMIENTO',812.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(57,'SERVICIO','ESTUDIOS','	85121800_01',NULL,'ELECTROCARDIOGRAMA EN REPOSO',522.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(58,'SERVICIO','ESTUDIOS','	85121800_02',NULL,'REGISTRO DE TOCOCARDIOGRAFO',580.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(59,'SERVICIO','ENFERMERIA','	85101601_24',NULL,'APLICACION DE EMODERIVADOS HOSPITALARIA',580.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(60,'SERVICIO','ENFERMERIA','	85101601_21',NULL,'APLICACION DE ENEMA HOSPITALARIA',696.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(61,'SERVICIO','ENFERMERIA','	85101601_07',NULL,'APLICACION DE INYECCION INTRAMUSCULAR AMBULATORIA',58.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(62,'SERVICIO','ENFERMERIA','	85101601_08',NULL,'APLICACION DE INYECCION INTRAMUSCULAR HOSPITALARIA',40.60,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(63,'SERVICIO','ENFERMERIA','	85101601_09',NULL,'APLICACION DE INYECCION INTRAVENOSA AMBULATORIA',58.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(64,'SERVICIO','ENFERMERIA','	85101601_10',NULL,'APLICACION DE INYECCION INTRAVENOSA HOSPITALARIA',40.60,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(65,'SERVICIO','ENFERMERIA','	85101601_13',NULL,'APLICACION DE MEDICAMENTO ORAL AMBULATORIO',23.20,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(66,'SERVICIO','ENFERMERIA','	85101601_14',NULL,'APLICACION DE MEDICAMENTO ORAL HOSPITALARIO',23.20,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(67,'SERVICIO','ENFERMERIA','	85101601_11',NULL,'APLICACION DE MEDICAMENTO TOPICO AMBULATORIO',580.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(68,'SERVICIO','ENFERMERIA','	85101601_12',NULL,'APLICACION DE MEDICAMENTO TOPICO HOSPITALARIO',580.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(69,'SERVICIO','ENFERMERIA','	85101601_25',NULL,'APLICACION DE MEDICAMENTOS CON BOMBA DE INFUSION',580.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(70,'SERVICIO','ENFERMERIA','	85101601_26',NULL,'APLICACION DE OXIGENO',116.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(71,'SERVICIO','ENFERMERIA','	85101601_15',NULL,'APLICACION DE SONDA URETRAL AMBULATORIA',696.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(72,'SERVICIO','ENFERMERIA','	85101601_16',NULL,'APLICACION DE SONDA URETRAL HOSPITALARIA',696.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(73,'SERVICIO','ENFERMERIA','	85101601_27',NULL,'APLICACION DE YESO 1 VENDA DE 15 CM ',174.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(74,'SERVICIO','ENFERMERIA','	85101601_35',NULL,'ARMADO DE CHAROLAS DE INSTRUMENTAL',232.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(75,'SERVICIO','ENFERMERIA','	85101601_36',NULL,'ARMADO DE COMPRESAS',232.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(76,'SERVICIO','ENFERMERIA','	85101601_37',NULL,'ARMADO DE GASAS',232.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(77,'SERVICIO','ENFERMERIA','	85101601_38',NULL,'ARMADO DE MATERIAL DIVERSO',696.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(78,'SERVICIO','ENFERMERIA','	85101601_34',NULL,'ARMADO DE VULTOS DE CIRUJIA GENERAL',348.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(79,'SERVICIO','ENFERMERIA','	85101601_28',NULL,'BANO DE ESPONJA',232.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(80,'SERVICIO','ENFERMERIA','	85101601_29',NULL,'BANO DEL BEBE',232.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(81,'SERVICIO','ENFERMERIA','	85101601_31',NULL,'CIRCULANTE',580.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(82,'SERVICIO','ENFERMERIA','	85101601_39',NULL,'COLOCACION DE ARETES',232.01,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(83,'SERVICIO','ENFERMERIA','	85101601_01',NULL,'CURACION AMBULATORIA',696.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(84,'SERVICIO','ENFERMERIA','	85101601_02',NULL,'CURACION DE HERIDAS (FRICCION O QUEMADURA)',0.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(85,'SERVICIO','ENFERMERIA','	85101601_03',NULL,'CURACION HOSPITALARIA',0.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(86,'SERVICIO','ENFERMERIA','	85101601_33',NULL,'ESTERILIZACION A GAS OXIDO DE HETILENO POR AMPULA ',11600.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(87,'SERVICIO','ENFERMERIA','	85101601_32',NULL,'ESTERILIZACION A VAPOR 1 KG ',696.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(88,'SERVICIO','ENFERMERIA','	85101601_30',NULL,'INTRUMENTISTA',580.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(89,'SERVICIO','ENFERMERIA','	85101601_23',NULL,'PREPARACION HOSPITALARIA',348.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(90,'SERVICIO','ENFERMERIA','	85101601_22',NULL,'PREPARACION QUIRURJICA',348.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(91,'SERVICIO','ENFERMERIA','	85101601_06',NULL,'RETIRO DE PUNTOS',348.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(92,'SERVICIO','ENFERMERIA','	85101601_04',NULL,'RETIRO DE SONDA ',696.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(93,'SERVICIO','ENFERMERIA','	85101601_05',NULL,'SUTURA DE MAX 4 PUNTOS ',928.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(94,'SERVICIO','ENFERMERIA','	85101601_20',NULL,'TOMAS DE DEXTROCTIS CAPILAR (TOMA DE AZUCAR EN EL DEDO)',75.40,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(95,'SERVICIO','ENFERMERIA','	85101601_19',NULL,'TOMAS DE DEXTROCTIS CAPILAR (TOMA DE AZUCAR EN EL DEDO) AMBULATORIOS',75.40,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(96,'SERVICIO','ENFERMERIA','	85101601_17',NULL,'TOMAS DE SIGNOS VITALES AMBULATORIOS',75.40,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(97,'SERVICIO','ENFERMERIA','	85101601_18',NULL,'TOMAS DE SIGNOS VITALES HOSPITALARIOS',75.40,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(98,'SERVICIO','NUTRICION','	85101601_41',NULL,'DISENO DE DIETA DE EGRESO',348.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(99,'SERVICIO','NUTRICION','	85101601_40',NULL,'SUMINISTRO DE DIETAS Y VIGILANCIA ',406.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(100,'SERVICIO','LIMPIEZA','	72101508_01',NULL,'ASEO DE HABITACION DIARIO',348.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(101,'SERVICIO','LIMPIEZA','	72101508_02',NULL,'ASEO DE HABITACION EXHAUSTIVO',696.01,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(102,'SERVICIO','LIMPIEZA','	72101508_04',NULL,'ASEO DE QUIROFANO EXHAUSTIVO',1160.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(103,'SERVICIO','LIMPIEZA','	72101508_03',NULL,'ASEO DE QUIROFANO REGULAR',696.01,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(104,'SERVICIO','HOSPITALIZACION','	85101501_04',NULL,' HORA HABITACION CORTA ESTANCIA ',174.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(105,'SERVICIO','HOSPITALIZACION','	85101501_03',NULL,' HORA HABITACION PRIVADA ',348.01,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(106,'SERVICIO','HOSPITALIZACION','	85101501_01',NULL,'DIA DE HOSPITALIZACION  HABITACION PRIVADA 24 HRS',2320.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(107,'SERVICIO','HOSPITALIZACION','	85101501_02',NULL,'DIA DE HOSPITALIZACION CORTA ESTANCIA 24 HRS',1740.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(108,'SERVICIO','URGENCIA','	85101501_05',NULL,'USO DE ESTACION DE OBSERVACION',0.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(109,'SERVICIO','URGENCIA','	85101501_06',NULL,'USO DE SALA DE CHOQUE',0.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(110,'SERVICIO','QUIROFANO','	85121600-01',NULL,'ANESTESIOLOGO',3480.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(111,'SERVICIO','QUIROFANO','	85121600-02',NULL,'ANGEOLOGO',6960.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(112,'SERVICIO','QUIROFANO','	85121600-03',NULL,'ONCOLOGO',3480.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(113,'SERVICIO','QUIROFANO','	85121600-05',NULL,'USO DE QUIROFANO AMBULATORIO ',4060.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(114,'SERVICIO','QUIROFANO','	85121600-04',NULL,'USO DE QUIROFANO HASTA 2HRS',6496.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(115,'SERVICIO','EQUIPO MEDICO','	42000000_02',NULL,'BOMBA DE INFUSION PO HORA ',174.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(116,'SERVICIO','EQUIPO MEDICO','	42000000_10',NULL,'BULTO DE CIRUGIA DESECHABLE',1740.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(117,'SERVICIO','EQUIPO MEDICO','	42000000_09',NULL,'BULTO DE CIRUGIA ESTERIL REUTILIZABLE',1740.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(118,'SERVICIO','EQUIPO MEDICO','	42000000_08',NULL,'EQUIPO DE ANESTESIA (USO)',2320.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(119,'SERVICIO','EQUIPO MEDICO','	42000000_01',NULL,'MONITOR DE SIGNOS VITALES',696.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(120,'SERVICIO','EQUIPO MEDICO','42000000_11',NULL,'TORRE DE LAPARO',3480.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(121,'SERVICIO','EQUIPO MEDICO','	42000000_06',NULL,'USO CARRO ROJO CON DESFIBRILADOR',11600.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(122,'SERVICIO','EQUIPO MEDICO','	42000000_05',NULL,'USO DE ASPIRADOR POR HORA ',2320.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(123,'SERVICIO','EQUIPO MEDICO','	42000000_04',NULL,'USO DE CUNA TERMICA POR HORA ',232.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(124,'SERVICIO','EQUIPO MEDICO','	42000000_07',NULL,'USO DE CUNERO POR HORA ',232.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(125,'SERVICIO','EQUIPO MEDICO','	42000000_03',NULL,'USO DE INCUBADORA POR HORA ',232.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(126,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-01',NULL,'DISPENSACION DE OXIGENO HORA POR 1 LITRO X MINUTO ',58.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(127,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-10',NULL,'DISPENSACION DE OXIGENO HORA POR 10 LITRO X MINUTO ',580.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(128,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-11',NULL,'DISPENSACION DE OXIGENO HORA POR 11 LITRO X MINUTO ',638.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(129,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-12',NULL,'DISPENSACION DE OXIGENO HORA POR 12 LITRO X MINUTO ',696.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(130,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-13',NULL,'DISPENSACION DE OXIGENO HORA POR 13 LITRO X MINUTO ',754.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(131,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-14',NULL,'DISPENSACION DE OXIGENO HORA POR 14 LITRO X MINUTO ',812.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(132,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-15',NULL,'DISPENSACION DE OXIGENO HORA POR 15 LITRO X MINUTO ',870.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(133,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-02',NULL,'DISPENSACION DE OXIGENO HORA POR 2 LITRO X MINUTO',116.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(134,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-03',NULL,'DISPENSACION DE OXIGENO HORA POR 3 LITRO X MINUTO ',174.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(135,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-04',NULL,'DISPENSACION DE OXIGENO HORA POR 4 LITRO X MINUTO ',232.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(136,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-05',NULL,'DISPENSACION DE OXIGENO HORA POR 5 LITRO X MINUTO ',290.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(137,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-06',NULL,'DISPENSACION DE OXIGENO HORA POR 6 LITRO X MINUTO',348.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(138,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-07',NULL,'DISPENSACION DE OXIGENO HORA POR 7 LITRO X MINUTO ',406.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(139,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-08',NULL,'DISPENSACION DE OXIGENO HORA POR 8 LITRO X MINUTO ',464.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(140,'SERVICIO','DISPENSACION DE OXIGENO','	42271700-09',NULL,'DISPENSACION DE OXIGENO HORA POR 9 LITRO X MINUTO',522.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(141,'SERVICIO','GESTION','	30102206_01',NULL,'CONCENTRADO DE HEMATIES SANGRE/ GESTION',9280.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(142,'SERVICIO','GESTION','	30102206_03',NULL,'PLAQUETAS/ GESTION',17400.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(143,'SERVICIO','GESTION','	30102206_02',NULL,'PLASMA/ GESTION',11600.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(144,'SERVICIO','TRANSPORTE','	85101501_01',NULL,'AMBULANCIA COMISION',580.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(145,'SERVICIO','TRANSPORTE','	85101501_03',NULL,'TRAYECTO DE AMBULANCIA',0.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(146,'SERVICIO','TRANSPORTE','	85101501_02',NULL,'UNIDAD DE MOVILIZACION DE SILLA DE RUEDAS',696.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(147,'SERVICIO','ESTUDIOS','	85121800_02',NULL,'BIOPCIA ',928.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(148,'SERVICIO','ESTUDIOS','	85121800_05',NULL,'PIEZA PATOLOGIA  APENDICE',1740.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(149,'SERVICIO','ESTUDIOS','	85121800_06',NULL,'PIEZA PATOLOGIA  PROSTATA',600.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(150,'SERVICIO','ESTUDIOS','	85121800_03',NULL,'PIEZA PATOLOGIA  RINON',580.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(151,'SERVICIO','ESTUDIOS','	85121800_04',NULL,'PIEZA PATOLOGIA UTERO',1740.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(152,'SERVICIO','ESTUDIOS','	85121800_01',NULL,'PIEZA PATOLOGICA PIEL ',1160.00,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(153,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ACETATO DE METILPREDNISOLONA  40 MG/ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(154,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ACETILCISTEINA  100 MG/ ML',0.10,NULL,26,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(155,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ACIDO ASCORBICO  1G/10 ML',0.10,NULL,6,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(156,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ACIDO TRANEXAMICO 100 MG/ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(157,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ACIDO TRANEXAMICO 500 MG/ 5 ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(158,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ADEMETIONINA 500 MG',0.10,NULL,3,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(159,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ALBUMINA HUMANA 12.5 G/50 ML',0.10,NULL,3,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(160,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ALBUMINA HUMANA 12.5 G/50 ML',0.10,NULL,9,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(161,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ALBUMINA HUMANA 12.5 G/50 ML',0.10,NULL,8,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(162,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ALBUMINA HUMANA 12.5 G/50 ML',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(163,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ALBUMINA HUMANA 12.5 G/50 ML',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(164,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ALBUMINA HUMANA 12.5 G/50 ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(165,'INSUMOS','MEDICAMENTOS',NULL,NULL,'AMIKACINA  500 MG/2 ML',0.10,NULL,63,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(166,'INSUMOS','MEDICAMENTOS',NULL,NULL,'AMIKACINA 1GR ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(167,'INSUMOS','MEDICAMENTOS',NULL,NULL,'AMINOFILINA 250 MG/10 ML',0.10,NULL,6,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(168,'INSUMOS','MEDICAMENTOS',NULL,NULL,'AMINOFILINA 250 MG/10 ML',0.10,NULL,3,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(169,'INSUMOS','MEDICAMENTOS',NULL,NULL,'AMIODARONA 150 MG/3 ML',0.10,NULL,6,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(170,'INSUMOS','MEDICAMENTOS',NULL,NULL,'AMIODARONA 150 MG/3 ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(171,'INSUMOS','MEDICAMENTOS',NULL,NULL,'AMPICILINA 1 G',0.10,NULL,8,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(172,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ATROPINA 1 ML/ 1 ML',0.10,NULL,103,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(173,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ATROPINA 1 ML/ 1 ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(174,'INSUMOS','MEDICAMENTOS',NULL,NULL,'AVAPENA  20 MG/2 ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(175,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BECLOMETAZONA AEROSOL ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(176,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BEPLENOVAX ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(177,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BESILATO DE CISATRACURIO 2 MG/ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(178,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BESILATO DE CISATRACURIO 2 MG/ML ',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(179,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BETAMETASONA 8MG/2ML',0.10,NULL,3,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(180,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BETAMETASONA 8MG/2ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(181,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BETAMETASONA ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(182,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BETAMETASONA ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(183,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BETAMETASONA ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(184,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BICARBONATO DE SODIO 7.5 %',0.10,NULL,112,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(185,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BROMURO DE IPRATOPIO, SALBUTAMOL 0.5MG/2.5MG',0.10,NULL,54,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(186,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BROMURO DE IPRATROPIO ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(187,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BROMURO DE IPRATROPIO ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(188,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BROMURO DE TIOTROPIO 0.226MG/1ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(189,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BROMURO DE VECURONIO 4 MG/ML',0.10,NULL,32,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(190,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BUDESONIDA 0.250 MG/2ML',0.10,NULL,15,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(191,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BUPRENORFINA 0.3 MG/ML',0.10,NULL,67,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(192,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BUVACAINA GLUCOSA 150 MG/30 ML',0.10,NULL,3,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(193,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BUVACAINA GLUCOSA 7.5 MG/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(194,'INSUMOS','MEDICAMENTOS',NULL,NULL,'BUVACAINA PESADA 5 MG/1 ML',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(195,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CARBETOCINA 100 MCG/ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(196,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CEFALOTINA 1G',0.10,NULL,5,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(197,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CEFOTAXIMA 1G',0.10,NULL,83,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(198,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CEFOTAXIMA 1G/4 ML',0.10,NULL,11,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(199,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CEFTRIAXONA 1G',0.10,NULL,160,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(200,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CIPROFLOXACINO 1 G',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(201,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CIPROFLOXACINO 200MG/100ML',0.10,NULL,38,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(202,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLINDAMICINA 600MG/4ML',0.10,NULL,91,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(203,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLINDAMICINA 600MG/4ML',0.10,NULL,40,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(204,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLONAZEPAM GOTAS 2.5 MG/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(205,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLONIXINATO DE LISINA 100 MG/2 ML',0.10,NULL,32,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(206,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLORANFENICOL 5 MG/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(207,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLORANFENICOL 5MG/G',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(208,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLORHIDRATO DE MOXIFLOXACINO 400 MG',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(209,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLORURO DE POTASIO 1.49GR / 5ML',0.10,NULL,73,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(210,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLORURO DE POTASIO 1.49GR / 5ML ',0.10,NULL,56,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(211,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLORURO DE SODIO 0.177',0.10,NULL,69,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(212,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLORURO DE SODIO 0.177',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(213,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLORURO DE SODIO ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(214,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DEXAMETASONA 8MG/2ML',0.10,NULL,39,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(215,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DEXKETOPROFENO 50 MG/2ML',0.10,NULL,31,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(216,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DEXKETOPROFENO 50 MG/2ML',0.10,NULL,97,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(217,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DEXMEDETOMIDINA 200MCG/2 ML',0.10,NULL,5,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(218,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DIAZEPAM 10 MG/2ML',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(219,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DICLOFENACO 75MG/ 3ML',0.10,NULL,22,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(220,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DICLOFENACO 75MG/ 3ML',0.10,NULL,80,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(221,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DIFENIDOL 40MG/2ML',0.10,NULL,13,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(222,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DIGOXINA 0.5 MG MG/2ML',0.10,NULL,5,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(223,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DIPROPIONATO DE BECLOMETAZONA AEROSOL 50 MCG',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(224,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DIPROPIONATO DE BECLOMETAZONA AEROSOL 50 MCG ',0.10,NULL,3,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(225,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DIPROPIONATO DE BECLOMETAZONA AEROSOL ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(226,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DOBUTAMINA 250MG/5ML',0.10,NULL,3,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(227,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DOBUTAMINA 250MG/5ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(228,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DOPAMINA 200MG/5ML',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(229,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DOPAMINA 200MG/5ML',0.10,NULL,15,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(230,'INSUMOS','MEDICAMENTOS',NULL,NULL,'EFEDRINA ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(231,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ENOXOPARINA SODICA 40 MG 40MG/0.4ml',0.10,NULL,55,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(232,'INSUMOS','MEDICAMENTOS',NULL,NULL,'EPINEFRINA 1MG/ML',0.10,NULL,91,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(233,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ERGOMETRINA 0.2 MG/ML',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(234,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ERITROPOYECTINA HUMANA 4000 UL/ML',0.10,NULL,5,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(235,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ETAMCILATO 250MG/2ML',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(236,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FENITOINA SODICA 250 MG/5 ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(237,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FENITOINA SODICA 250 MG/5 ML',0.10,NULL,3,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(238,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FENTANILO 0.5MG/10ML',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(239,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FITOMENADIONA (VITAMINA K) 10MG/1ML',0.10,NULL,3,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(240,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FITOMENADIONA (VITAMINA K) 2MG/0.2ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(241,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FITOMENADIONA (VITAMINA K) 2MG/0.2ML',0.10,NULL,5,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(242,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FITOMENADIONA (VITAMINA K) 2MG/0.2ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(243,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FITOMENADIONA (VITAMINA K) 2MG/0.2ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(244,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FITOMENADIONA (VITAMINA K) 2MG/0.2ML',0.10,NULL,3,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(245,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FITOMENADIONA (VITAMINA K) 2MG/0.2ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(246,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FLUMAZENILL ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(247,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FOSFATO DE POTASIO 10 ML ',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(248,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FOSFATO DE POTASIO 10 ML ',0.10,NULL,5,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(249,'INSUMOS','MEDICAMENTOS',NULL,NULL,'FUROSEMIDA 20MG/2ML',0.10,NULL,55,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(250,'INSUMOS','MEDICAMENTOS',NULL,NULL,'GELATINA SUCCINILADA 3.5 %',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(251,'INSUMOS','MEDICAMENTOS',NULL,NULL,'GELATINA SUCCINILADA 4 %',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(252,'INSUMOS','MEDICAMENTOS',NULL,NULL,'GENTAMICINA 80MG/2ML',0.10,NULL,9,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(253,'INSUMOS','MEDICAMENTOS',NULL,NULL,'GENTAMICINA 80MG/2ML',0.10,NULL,10,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(254,'INSUMOS','MEDICAMENTOS',NULL,NULL,'GLUCONATO DE CALCIO 10 %',0.10,NULL,42,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(255,'INSUMOS','MEDICAMENTOS',NULL,NULL,'GLUCOSA DEXTROSA AL 50% 25 G',0.10,NULL,8,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(256,'INSUMOS','MEDICAMENTOS',NULL,NULL,'HALOPERIDOL 5 MG/ML',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(257,'INSUMOS','MEDICAMENTOS',NULL,NULL,'HEPARINA 1000 UL/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(258,'INSUMOS','MEDICAMENTOS',NULL,NULL,'HEPARINA 1001 UL/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(259,'INSUMOS','MEDICAMENTOS',NULL,NULL,'HIDRALAZINA AMP 20 MG/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(260,'INSUMOS','MEDICAMENTOS',NULL,NULL,'HIDROCORTIZONA 100 MG',0.10,NULL,90,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(261,'INSUMOS','MEDICAMENTOS',NULL,NULL,'HIDROCORTIZONA 500 MG',0.10,NULL,6,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(262,'INSUMOS','MEDICAMENTOS',NULL,NULL,'HIDROCORTIZONA 500 MG',0.10,NULL,5,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(263,'INSUMOS','MEDICAMENTOS',NULL,NULL,'HIERRO DEXTRAN 100MG/2ML',0.10,NULL,58,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(264,'INSUMOS','MEDICAMENTOS',NULL,NULL,'HIOCINA /METAMIZOL SODICO 20MG-2.5GR /5 ML',0.10,NULL,25,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(265,'INSUMOS','MEDICAMENTOS',NULL,NULL,'HIOCINA O BUTILHIOCINA 20MG/1ML',0.10,NULL,109,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(266,'INSUMOS','MEDICAMENTOS',NULL,NULL,'IMIPENEM ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(267,'INSUMOS','MEDICAMENTOS',NULL,NULL,'IMIPENEM/CILASTATINA 500 MG/500 MG',0.10,NULL,46,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(268,'INSUMOS','MEDICAMENTOS',NULL,NULL,'INSULINA CLARGINA 100 U/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(269,'INSUMOS','MEDICAMENTOS',NULL,NULL,'INSULINA CLARGINA 100 U/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(270,'INSUMOS','MEDICAMENTOS',NULL,NULL,'INSULINA CLARGINA 100 U/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(271,'INSUMOS','MEDICAMENTOS',NULL,NULL,'INSULINA HUMANA 100 UL/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(272,'INSUMOS','MEDICAMENTOS',NULL,NULL,'INSULINA HUMANA 100 UL/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(273,'INSUMOS','MEDICAMENTOS',NULL,NULL,'INSULINA HUMANA RECOMBINANTE ISOFARICA 100 UL/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(274,'INSUMOS','MEDICAMENTOS',NULL,NULL,'KETOPROFENO 2 ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(275,'INSUMOS','MEDICAMENTOS',NULL,NULL,'KETOROLACO 30MG/1ML',0.10,NULL,368,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(276,'INSUMOS','MEDICAMENTOS',NULL,NULL,'L-ORNITINA L-ASPARTATO 5 G/10 ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(277,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LAUROMACROGOL 60 MG/2 ML',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(278,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LEVOFLOXACINO 500 MG/100 ML',0.10,NULL,61,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(279,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LIDOCAINA 0.1',0.10,NULL,5,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(280,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LIDOCAINA 20 MG/ML',0.10,NULL,15,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(281,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LIDOCAINA CON EPINEFRINA 20 MG/0.005 MG/1ML',0.10,NULL,6,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(282,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LIDOCAINA CON EPINEFRINA ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(283,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LIDOCAINA HCL EPINEFRINA 36 MG, 18 MCG',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(284,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LIDOCAINA ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(285,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LOPROMIDA MEDIO DE CONTRASTE 300 MG/ ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(286,'INSUMOS','MEDICAMENTOS',NULL,NULL,'MEDIO DE CONTRASTE ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(287,'INSUMOS','MEDICAMENTOS',NULL,NULL,'MEROPENEM 1GR',0.10,NULL,28,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(288,'INSUMOS','MEDICAMENTOS',NULL,NULL,'METAMIZOL SODICO 1MG/2ML',0.10,NULL,98,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(289,'INSUMOS','MEDICAMENTOS',NULL,NULL,'METILPREDNISOLONA 500MG',0.10,NULL,30,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(290,'INSUMOS','MEDICAMENTOS',NULL,NULL,'METILPREDNISOLONA ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(291,'INSUMOS','MEDICAMENTOS',NULL,NULL,'METOCLOPRAMIDA 10MG/2ML',0.10,NULL,41,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(292,'INSUMOS','MEDICAMENTOS',NULL,NULL,'METRONIDAZOL 500 MG /100 ML',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(293,'INSUMOS','MEDICAMENTOS',NULL,NULL,'METRONIDAZOL 500 MG /100 ML',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(294,'INSUMOS','MEDICAMENTOS',NULL,NULL,'MIDAZOLAM 15MG/3ML',0.10,NULL,13,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(295,'INSUMOS','MEDICAMENTOS',NULL,NULL,'MIDAZOLAM 5MG/5ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(296,'INSUMOS','MEDICAMENTOS',NULL,NULL,'MORFINA 10MG/10ML',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(297,'INSUMOS','MEDICAMENTOS',NULL,NULL,'MULTIVITAMINAS 5.719 G ',0.10,NULL,6,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(298,'INSUMOS','MEDICAMENTOS',NULL,NULL,'NABULFINA 10MG/1ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(299,'INSUMOS','MEDICAMENTOS',NULL,NULL,'NABULFINA 10MG/1ML',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(300,'INSUMOS','MEDICAMENTOS',NULL,NULL,'NALOXONA ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(301,'INSUMOS','MEDICAMENTOS',NULL,NULL,'NEOSTIGMINA 0.5GR/1ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(302,'INSUMOS','MEDICAMENTOS',NULL,NULL,'NOREPINEFRINA 4 MG/4 ML',0.10,NULL,9,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(303,'INSUMOS','MEDICAMENTOS',NULL,NULL,'NOREPINEFRINA 4 MG/4 ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(304,'INSUMOS','MEDICAMENTOS',NULL,NULL,'OCTREOTIDA ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(305,'INSUMOS','MEDICAMENTOS',NULL,NULL,'OMEOPRAZOL 40 MG',0.10,NULL,80,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(306,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ONDASETRON 8MG/4ML',0.10,NULL,236,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(307,'INSUMOS','MEDICAMENTOS',NULL,NULL,'OXIMETAZOLINA 20 ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(308,'INSUMOS','MEDICAMENTOS',NULL,NULL,'OXITOCINA 5 UL/ 1ML',0.10,NULL,26,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(309,'INSUMOS','MEDICAMENTOS',NULL,NULL,'PANTOPRAZOL 40 MG',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(310,'INSUMOS','MEDICAMENTOS',NULL,NULL,'PARACETAMOL 1G/100 ML',0.10,NULL,76,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(311,'INSUMOS','MEDICAMENTOS',NULL,NULL,'PARCHE DE NITROGLICERINA ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(312,'INSUMOS','MEDICAMENTOS',NULL,NULL,'PAREXCOBIT 40 MG',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(313,'INSUMOS','MEDICAMENTOS',NULL,NULL,'PROPOFOL 10 MG/ML',0.10,NULL,3,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(314,'INSUMOS','MEDICAMENTOS',NULL,NULL,'PROPOFOL 200 MG/20ML',0.10,NULL,11,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(315,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ROCURONIO ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(316,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ROPIVACAINA 7.5% 7.5MG/1ML ',0.10,NULL,7,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(317,'INSUMOS','MEDICAMENTOS',NULL,NULL,'SACARATO FERRICO 100 MG/5ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(318,'INSUMOS','MEDICAMENTOS',NULL,NULL,'SALBUTAMOL 5 MG/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(319,'INSUMOS','MEDICAMENTOS',NULL,NULL,'SALBUTAMOL SPRAY 100 MCG',0.10,NULL,8,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(320,'INSUMOS','MEDICAMENTOS',NULL,NULL,'SALMETEROL, FLUTICASONA ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(321,'INSUMOS','MEDICAMENTOS',NULL,NULL,'SEVOFLURANO (250 ML POR FRASCO) 250 ML',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(322,'INSUMOS','MEDICAMENTOS',NULL,NULL,'SULFATO DE MAGNESIO 10% 1G/10ML  ',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(323,'INSUMOS','MEDICAMENTOS',NULL,NULL,'TERLIPRESINA 1 MG',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(324,'INSUMOS','MEDICAMENTOS',NULL,NULL,'TERLIPRESINA 1 MG',0.10,NULL,3,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(325,'INSUMOS','MEDICAMENTOS',NULL,NULL,'TRAMADOL 100 MG/ 2ML',0.10,NULL,21,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(326,'INSUMOS','MEDICAMENTOS',NULL,NULL,'TRIMEBUTINA 50 MG/5ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(327,'INSUMOS','MEDICAMENTOS',NULL,NULL,'TRIMEBUTINA 50 MG/5ML',0.10,NULL,5,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(328,'INSUMOS','MEDICAMENTOS',NULL,NULL,'VANCOMICINA 500 MG',0.10,NULL,11,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(329,'INSUMOS','MEDICAMENTOS',NULL,NULL,'VANCOMICINA 500 MG',0.10,NULL,10,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(330,'INSUMOS','MEDICAMENTOS',NULL,NULL,'VITAMINAS -',0.10,NULL,4,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(331,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ACETIL SALISILICO 500 MG',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(332,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ACIDO ASCORBICO 1G',0.10,NULL,6,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(333,'INSUMOS','MEDICAMENTOS',NULL,NULL,'AMLODIPINO 5 MG',0.10,NULL,3,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(334,'INSUMOS','MEDICAMENTOS',NULL,NULL,'AZITROMICINA  ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(335,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CAPTOPRIL 25 MG',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(336,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CEFIXIMA  100 MG/ 5 ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(337,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CEFUROXIMA 250 MG/5 ML ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(338,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CELECOXIB 200 MG',0.10,NULL,7,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(339,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CINITAPRIDA 1 MG',0.10,NULL,25,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(340,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CIPROFLOXACINO 500 MG',0.10,NULL,8,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(341,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLINDAMICINA 300 MG',0.10,NULL,12,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(342,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLOPIDOGREL 75 MG',0.10,NULL,8,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(343,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DAPAGLIFLOZINA 10 MG',0.10,NULL,20,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(344,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DICLOFENACO 100 MG',0.10,NULL,20,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(345,'INSUMOS','MEDICAMENTOS',NULL,NULL,'DINITRITO DE ISOSORBIDA 5 MG',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(346,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ERDOSTEINA 175 MG/ 5 ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(347,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ESPIROLACTONA 25 MG',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(348,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ETORICOXIB 90 MG',0.10,NULL,24,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(349,'INSUMOS','MEDICAMENTOS',NULL,NULL,'HIOCINA CON METAMIZOL SODICO  10 MG',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(350,'INSUMOS','MEDICAMENTOS',NULL,NULL,'IBUPROFENO 2 G/ 100 ML',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(351,'INSUMOS','MEDICAMENTOS',NULL,NULL,'IBUPROFENO 400 MG',0.10,NULL,70,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(352,'INSUMOS','MEDICAMENTOS',NULL,NULL,'INDAPAMIDA 1.5 MG',0.10,NULL,29,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(353,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LACTULOSA 66. 7G /100 ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(354,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LORATADINA 10 G',0.10,NULL,8,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(355,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LOSARTAN  50 MG',0.10,NULL,210,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(356,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LOSARTAN/AMLOPIDINO 100 MG/5MG ',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(357,'INSUMOS','MEDICAMENTOS',NULL,NULL,'MEGALDRATO,DIMETICONA 80 MG, 10 MG, 1 ML',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(358,'INSUMOS','MEDICAMENTOS',NULL,NULL,'METFORMINA  850 MG ',0.10,NULL,36,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(359,'INSUMOS','MEDICAMENTOS',NULL,NULL,'METOPROLOL 100 MG',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(360,'INSUMOS','MEDICAMENTOS',NULL,NULL,'METOPROLOL ',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(361,'INSUMOS','MEDICAMENTOS',NULL,NULL,'MISOPROSTOL 200 MG',0.10,NULL,137,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(362,'INSUMOS','MEDICAMENTOS',NULL,NULL,'MISOPROSTOL 200 MG',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(363,'INSUMOS','MEDICAMENTOS',NULL,NULL,'NIFEDIPINO 30 MG',0.10,NULL,18,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(364,'INSUMOS','MEDICAMENTOS',NULL,NULL,'OMEOPRAZOL 20 MG',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(365,'INSUMOS','MEDICAMENTOS',NULL,NULL,'PARACETAMOL 500 MG',0.10,NULL,60,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(366,'INSUMOS','MEDICAMENTOS',NULL,NULL,'PREGABALINA 150 MG',0.10,NULL,28,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(367,'INSUMOS','MEDICAMENTOS',NULL,NULL,'PREGABALINA 75 MG',0.10,NULL,2,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(368,'INSUMOS','MEDICAMENTOS',NULL,NULL,'PROGESTERONA 200 MG',0.10,NULL,13,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(369,'INSUMOS','MEDICAMENTOS',NULL,NULL,'SALBUTAMOL, AMBROXOL 40 MG, 150 MG/100 ML',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(370,'INSUMOS','MEDICAMENTOS',NULL,NULL,'SENOSIDOS A-B 8.6 MG',0.10,NULL,21,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(371,'INSUMOS','MEDICAMENTOS',NULL,NULL,'STOMAHESIVE 28.3 G',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(372,'INSUMOS','MEDICAMENTOS',NULL,NULL,'TELMISARTAN 40 MG',0.10,NULL,14,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(373,'INSUMOS','MEDICAMENTOS',NULL,NULL,'TINITRATO DE GLICERILO 18 MG ',0.10,NULL,8,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(374,'INSUMOS','MEDICAMENTOS',NULL,NULL,'TRIMEBUTINA 200 MG',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(375,'INSUMOS','MEDICAMENTOS',NULL,NULL,'TRIMETOPRIMA Y SULFAMETOXAZOL 100 MG-800 MG',0.10,NULL,14,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(376,'INSUMOS','MEDICAMENTOS',NULL,NULL,'VITAMINAS 500 MG ',0.10,NULL,90,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(377,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CARBON ACTIVADO  100 G,POLVO',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(378,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLORANFENICOL   5 MG/ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(379,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLORANFENICOL  5 MG/G',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(380,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CLORANFENICOL  6 MG/G',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(381,'INSUMOS','MEDICAMENTOS',NULL,NULL,'CONDONES SIN DATOS ',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(382,'INSUMOS','MEDICAMENTOS',NULL,NULL,'ETONOGESTREL 68 MG',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(383,'INSUMOS','MEDICAMENTOS',NULL,NULL,'HIPROMELOSA 0.5 %',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(384,'INSUMOS','MEDICAMENTOS',NULL,NULL,'HIPROMELOSA 5 MG/ ML',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(385,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LEVONORGESTREL 52.00 MG',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(386,'INSUMOS','MEDICAMENTOS',NULL,NULL,'LIDOCAINA UNGUENTO 5% TUBO CON 35 G',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(387,'INSUMOS','MEDICAMENTOS',NULL,NULL,'MUPIRUCINA 2 G',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(388,'INSUMOS','MEDICAMENTOS',NULL,NULL,'PASTA PARA OSTOMIA  128 MG',0.10,NULL,1,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(389,'INSUMOS','MEDICAMENTOS',NULL,NULL,'SUPOSITORIOS DE INDOMETACINA 100 MG',0.10,NULL,0,NULL,NULL,NULL,NULL,0.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(390,'INSUMOS','GENERAL',NULL,NULL,'AGUJA 20 G (AMARILLA)',0.10,NULL,4812,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(391,'INSUMOS','GENERAL',NULL,NULL,'AGUJA 22 G (NEGRA)',0.10,NULL,950,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(392,'INSUMOS','GENERAL',NULL,NULL,'AGUJA 18 G (ROSA)',0.10,NULL,191,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(393,'INSUMOS','GENERAL',NULL,NULL,'AGUJA 21 G (VERDE)',0.10,NULL,141,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(394,'INSUMOS','GENERAL',NULL,NULL,'AGUJA 27 G (DE INSULINA)',0.10,NULL,789,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(395,'INSUMOS','GENERAL',NULL,NULL,'AGUJA PARA VACUTAINER 21 G',0.10,NULL,18,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(396,'INSUMOS','GENERAL',NULL,NULL,'AGUJA RAQUINESTESICA WHITACRE 25 G CORTA',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(397,'INSUMOS','GENERAL',NULL,NULL,'AGUJA RAQUINESTESICA WHITACRE 25 G LARGA ',0.10,NULL,20,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(398,'INSUMOS','GENERAL',NULL,NULL,'AGUJA RAQUINESTESICA WHITACRE 27 G CORTA',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(399,'INSUMOS','GENERAL',NULL,NULL,'AGUJA RAQUINESTESICA WHITACRE 27 G LARGA',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(400,'INSUMOS','GENERAL',NULL,NULL,'AGUJA RAQUINESTESICA QUINCKE 22 C CORTO',0.10,NULL,19,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(401,'INSUMOS','GENERAL',NULL,NULL,'AGUJA RAQUINESTESICA QUINCKE 25 C CORTO',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(402,'INSUMOS','GENERAL',NULL,NULL,'AGUJA RAQUINESTESICA QUINCKE 25 C LARGO',0.10,NULL,20,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(403,'INSUMOS','GENERAL',NULL,NULL,'AGUJA RAQUINESTESICA QUINCKE 26 G CORTO',0.10,NULL,25,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(404,'INSUMOS','GENERAL',NULL,NULL,'AGUJA RAQUINESTESICA QUINCKE 27 G CORTO',0.10,NULL,14,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(405,'INSUMOS','GENERAL',NULL,NULL,'AGUJA RAQUINESTESICA QUINCKE 27 G LARGO',0.10,NULL,7,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(406,'INSUMOS','GENERAL',NULL,NULL,'AMBU  ADULTO',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(407,'INSUMOS','GENERAL',NULL,NULL,'AMBU  NEONATAL',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(408,'INSUMOS','GENERAL',NULL,NULL,'APOSITO  CHICO',0.10,NULL,76,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(409,'INSUMOS','GENERAL',NULL,NULL,'APOSITO PARA HERIDAS SUPERFICIALES  ROLLO 10 CMX10 CM',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(410,'INSUMOS','GENERAL',NULL,NULL,'APOSITOS GRANDE',0.10,NULL,43,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(411,'INSUMOS','GENERAL',NULL,NULL,'BOLSA AMARILLA 110 CM X 120 CM',0.10,NULL,105,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(412,'INSUMOS','GENERAL',NULL,NULL,'BOLSA PARA ENEMA  1500 ML',0.10,NULL,26,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(413,'INSUMOS','GENERAL',NULL,NULL,'BOLSA PARA EROCULTIVO PEDRIATICA  50 ML',0.10,NULL,85,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(414,'INSUMOS','GENERAL',NULL,NULL,'BOLSA PARA ILESTOMIA ADULTO',0.10,NULL,115,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(415,'INSUMOS','GENERAL',NULL,NULL,'BOLSA PARA RECOLECCION DE ORINA 2000 ML',0.10,NULL,128,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(416,'INSUMOS','GENERAL',NULL,NULL,'BOLSA PARA RECOLECCION DE ORINA \nANTIRREFLUJO 2000 ML',0.10,NULL,15,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(417,'INSUMOS','GENERAL',NULL,NULL,'BOLSA RESERVORIO LIBRE DE LATEX 1 L ',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(418,'INSUMOS','GENERAL',NULL,NULL,'BOLSA ROJA 110 CM X 120 CM',0.10,NULL,1383,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(419,'INSUMOS','GENERAL',NULL,NULL,'BOLSAS DE ALGODON COMPLETAS 500 G',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(420,'INSUMOS','GENERAL',NULL,NULL,'BOLSA DE ALGODON PLISADO 300 G ',0.10,NULL,8,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(421,'INSUMOS','GENERAL',NULL,NULL,'BOLSA DE TORUNDAS 500 G',0.10,NULL,8,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(422,'INSUMOS','GENERAL',NULL,NULL,'CABESRILLO CON SOPORTE INFANTIL ',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(423,'INSUMOS','GENERAL',NULL,NULL,'CABESRILLO CON SOPORTE PEDIATRICO ',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(424,'INSUMOS','GENERAL',NULL,NULL,'CABESTRILLO ADULTO CON SOPORTE  INMOVILIZADOR DE HOMBRO \nUNITALLA ',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(425,'INSUMOS','GENERAL',NULL,NULL,'CABESTRILLO ADULTO  GRANDE',0.10,NULL,5,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(426,'INSUMOS','GENERAL',NULL,NULL,'CABESTRILLO ADULTO  MEDIANO',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(427,'INSUMOS','GENERAL',NULL,NULL,'CABESTRILLO PEDIATRICO UNITALLA',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(428,'INSUMOS','GENERAL',NULL,NULL,'CANULA DE GUADEL  TALLA: 0 (AZUL)',0.10,NULL,15,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(429,'INSUMOS','GENERAL',NULL,NULL,'CANULA DE GUADEL  TALLA: 1 (NEGRA)',0.10,NULL,10,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(430,'INSUMOS','GENERAL',NULL,NULL,'CANULA DE GUADEL  TALLA: 00 (ROSA)',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(431,'INSUMOS','GENERAL',NULL,NULL,'CANULA DE GUADEL  TALLA: 2 (BLANCA)',0.10,NULL,16,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(432,'INSUMOS','GENERAL',NULL,NULL,'CANULA DE GUADEL  TALLA: 3 (VERDE)',0.10,NULL,15,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(433,'INSUMOS','GENERAL',NULL,NULL,'CANULA DE GUADEL  TALLA: 4 (AMARILLA )',0.10,NULL,18,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(434,'INSUMOS','GENERAL',NULL,NULL,'CANULA DE GUADEL  TALLA: 5 (ROJA)',0.10,NULL,29,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(435,'INSUMOS','GENERAL',NULL,NULL,'CANULA DE GUADEL  TALLA: 6 (NARANJA)',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(436,'INSUMOS','GENERAL',NULL,NULL,'CANULA DE GUADEL  TALLA: 6 (AZUL)',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(437,'INSUMOS','GENERAL',NULL,NULL,'CATETER  14 G (NARANJA)',0.10,NULL,67,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(438,'INSUMOS','GENERAL',NULL,NULL,'CATETER  16G (GRIS)',0.10,NULL,120,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(439,'INSUMOS','GENERAL',NULL,NULL,'CATETER  18 G (VERDE)',0.10,NULL,1032,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(440,'INSUMOS','GENERAL',NULL,NULL,'CATETER  17G (ROJO)',0.10,NULL,29,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(441,'INSUMOS','GENERAL',NULL,NULL,'CATETER  19G (AZUL)',0.10,NULL,52,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(442,'INSUMOS','GENERAL',NULL,NULL,'CATETER 20 G (ROSA)',0.10,NULL,962,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(443,'INSUMOS','GENERAL',NULL,NULL,'CATETER  21G (BLANCO AZULADO)',0.10,NULL,18,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(444,'INSUMOS','GENERAL',NULL,NULL,'CATETER  22 G  (AZUL CLARO)',0.10,NULL,504,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(445,'INSUMOS','GENERAL',NULL,NULL,'CATETER  23G (MORADO)',0.10,NULL,17,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(446,'INSUMOS','GENERAL',NULL,NULL,'CATETER  24 G (AMARILLO)',0.10,NULL,190,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(447,'INSUMOS','GENERAL',NULL,NULL,'CATETER ARROW  3 LUMENES',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(448,'INSUMOS','GENERAL',NULL,NULL,'CATETER ARROW  2 LUMENES',0.10,NULL,4,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(449,'INSUMOS','GENERAL',NULL,NULL,'CATETER HUMBILICAL  3.5 FR',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(450,'INSUMOS','GENERAL',NULL,NULL,'CATETER HUMBILICAL  5 FR',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(451,'INSUMOS','GENERAL',NULL,NULL,'CATETER DE 3 VIAS OCTOPUS  7 FR',0.10,NULL,5,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(452,'INSUMOS','GENERAL',NULL,NULL,'CATETER TORACICO PLEURAL  12 FR',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(453,'INSUMOS','GENERAL',NULL,NULL,'CATETER TORACICO PLEURAL  16 FR',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(454,'INSUMOS','GENERAL',NULL,NULL,'CATETER TORACICO PLEURAL  20 FR',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(455,'INSUMOS','GENERAL',NULL,NULL,'CATETER TORACICO PLEURAL  24 FR',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(456,'INSUMOS','GENERAL',NULL,NULL,'CATETER TORACICO PLEURAL  28 FR ',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(457,'INSUMOS','GENERAL',NULL,NULL,'CATETER TORACICO PLEURAL  32 FR',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(458,'INSUMOS','GENERAL',NULL,NULL,'CATETER TORACICO PLEURAL  36 FR',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(459,'INSUMOS','GENERAL',NULL,NULL,'CATETER EMBOLECTOMIA 5 FR',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(460,'INSUMOS','GENERAL',NULL,NULL,'CATETER EMBOLECTOMIA 3 FR',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(461,'INSUMOS','GENERAL',NULL,NULL,'CATETER EMBOLECTOMIA 4 FR',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(462,'INSUMOS','GENERAL',NULL,NULL,'CATETER EMBOLECTOMIA 7 FR',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(463,'INSUMOS','GENERAL',NULL,NULL,'CEPILLO CERVICAL CITOBRUSH',0.10,NULL,200,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(464,'INSUMOS','GENERAL',NULL,NULL,'CEPILLO QUIRURGICO CON GLUCONATO DE CLORHEXIDINA AL 4%',0.10,NULL,45,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(465,'INSUMOS','GENERAL',NULL,NULL,'CEPILLO QUIRURGICO SIN DESINFECTANTE ',0.10,NULL,140,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(466,'INSUMOS','GENERAL',NULL,NULL,'CINTA MICROPORE  1.25 CM',0.10,NULL,104,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(467,'INSUMOS','GENERAL',NULL,NULL,'CINTA MICROPORE  2.5 CM',0.10,NULL,158,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(468,'INSUMOS','GENERAL',NULL,NULL,'CINTA MICROPORE  5 CM',0.10,NULL,30,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(469,'INSUMOS','GENERAL',NULL,NULL,'CINTA TESTIGO PARA OXIDO DE ETILENO 19 MM X 50 M',0.10,NULL,4,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(470,'INSUMOS','GENERAL',NULL,NULL,'CINTA TESTIGO DE VAPOR 18 MM X 50 M ',0.10,NULL,31,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(471,'INSUMOS','GENERAL',NULL,NULL,'CINTA TRANSPORE  2.5 CM',0.10,NULL,103,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(472,'INSUMOS','GENERAL',NULL,NULL,'CINTA TRANSPORE  1.25 CM',0.10,NULL,24,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(473,'INSUMOS','GENERAL',NULL,NULL,'CINTA TRANSPORE  5 CM',0.10,NULL,6,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(474,'INSUMOS','GENERAL',NULL,NULL,'CINTA TRANSPORE  7.5 CM',0.10,NULL,9,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(475,'INSUMOS','GENERAL',NULL,NULL,'TELA ADHESIVA  7.5 CM',0.10,NULL,105,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(476,'INSUMOS','GENERAL',NULL,NULL,'TELA ADHESIVA  2.5 CM',0.10,NULL,118,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(477,'INSUMOS','GENERAL',NULL,NULL,'TELA ADHESIVA  1.25 CM',0.10,NULL,120,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(478,'INSUMOS','GENERAL',NULL,NULL,'CIRCUITO DE ANESTESIA  ADULTO',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(479,'INSUMOS','GENERAL',NULL,NULL,'CIRCUITO DE ANESTESIA  PEDIATRICO TALLA: 6',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(480,'INSUMOS','GENERAL',NULL,NULL,'CONECTOR TIPO SIMS DELGADO',0.10,NULL,26,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(481,'INSUMOS','GENERAL',NULL,NULL,'CONECTOR DP DE TITANIO TENCKHOFF DP',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(482,'INSUMOS','GENERAL',NULL,NULL,'CONECTOR  TIPO SIMS GRUESO',0.10,NULL,56,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(483,'INSUMOS','GENERAL',NULL,NULL,'CONECTOR  TIPO SIMS (3 CONECTORES)',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(484,'INSUMOS','GENERAL',NULL,NULL,'CPAP SYSTEM INFANTIL TALLA 0',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(485,'INSUMOS','GENERAL',NULL,NULL,'CPAP SYSTEM INFANTIL TALLA 1',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(486,'INSUMOS','GENERAL',NULL,NULL,'CPAP SYSTEM INFANTIL TALLA 2',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(487,'INSUMOS','GENERAL',NULL,NULL,'CPAP SYSTEM INFANTIL TALLA 3',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(488,'INSUMOS','GENERAL',NULL,NULL,'EQUIPO DE BOMBA DE INFUSION  INTRAVENOSA',0.10,NULL,45,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(489,'INSUMOS','GENERAL',NULL,NULL,'EQUIPO DE BOMBA  MARCA BAXTER',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(490,'INSUMOS','GENERAL',NULL,NULL,'EQUIPO PARA ANESTESIA  DURAL 111',0.10,NULL,7,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(491,'INSUMOS','GENERAL',NULL,NULL,'EQUIPO PARA ANESTESIA  RAQUIMIX',0.10,NULL,105,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(492,'INSUMOS','GENERAL',NULL,NULL,'EQUIPO PARA APLICACION DE VOLUMNES MEDIDOS 100 ML (METRISET 100)',0.10,NULL,5,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(493,'INSUMOS','GENERAL',NULL,NULL,'EQUIPO PARA DIALISIS PERITONEAL\n CON DOS COJINETES  (COLA DE COCHINO)',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(494,'INSUMOS','GENERAL',NULL,NULL,'EQUIPO PARA TRANSFUSION  (HEMOTECK)',0.10,NULL,139,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(495,'INSUMOS','GENERAL',NULL,NULL,'EQUIPO PARA VENOCLISIS EN FORMA DE MARIPOSA  25 FR G',0.10,NULL,5,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(496,'INSUMOS','GENERAL',NULL,NULL,'EQUIPO DE DRENAJE  (DRENOVAC 1/4)',0.10,NULL,17,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(497,'INSUMOS','GENERAL',NULL,NULL,'EQUIPO DE DRENAJE  (DRENOVAC 1/8)',0.10,NULL,9,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(498,'INSUMOS','GENERAL',NULL,NULL,'GUANTES   TALLA: 6',0.10,NULL,100,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(499,'INSUMOS','GENERAL',NULL,NULL,'GUANTES  TALLA: 6 1/2',0.10,NULL,973,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(500,'INSUMOS','GENERAL',NULL,NULL,'GUANTES  TALLA: 7',0.10,NULL,342,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(501,'INSUMOS','GENERAL',NULL,NULL,'GUANTES  TALLA: 7 1/2',0.10,NULL,153,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(502,'INSUMOS','GENERAL',NULL,NULL,'GUANTES TALLA: 8',0.10,NULL,28,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(503,'INSUMOS','GENERAL',NULL,NULL,'GUANTES  TALLA: 8 1/2',0.10,NULL,46,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(504,'INSUMOS','GENERAL',NULL,NULL,'GUANTES DE EXPLORACION BOLSA \nESTERIL TALLA: GRANDE',0.10,NULL,137,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(505,'INSUMOS','GENERAL',NULL,NULL,'GUANTES DE LATEX DE CAJA TALLA: MEDIANO',0.10,NULL,480,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(506,'INSUMOS','GENERAL',NULL,NULL,'GUANTES DE NITRILO  TALLA: 7',0.10,NULL,570,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(507,'INSUMOS','GENERAL',NULL,NULL,'GASAS SIMPLE ESTERIL 10X10 CM ',0.10,NULL,1877,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(508,'INSUMOS','GENERAL',NULL,NULL,'GASAS CON TRAMA  PAQUETE DE 200 PIEZAS',0.10,NULL,8,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(509,'INSUMOS','GENERAL',NULL,NULL,'GASAS SIN TRAMA  PAQUETE DE 200 PIEZAS',0.10,NULL,36,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(510,'INSUMOS','GENERAL',NULL,NULL,'GASAS SIN TRAMA  PAQUETE DE 200 PIEZAS',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(511,'INSUMOS','GENERAL',NULL,NULL,'GORROS DE CIRUGIA DE RESORTE  50 UNIDADES POR BOLSA',0.10,NULL,650,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(512,'INSUMOS','GENERAL',NULL,NULL,'GORROS DE CIRUGIA DE RESORTE  100 UNIDADES POR BOLSA',0.10,NULL,2150,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(513,'INSUMOS','GENERAL',NULL,NULL,'GORROS DE CIRUGIA PARA CIRUJANO  100 UNIDADES POR BOLSA',0.10,NULL,350,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(514,'INSUMOS','GENERAL',NULL,NULL,'HOJAS DE BISTURI \nTALLA: 10 100 UNIDADES POR CAJA ',0.10,NULL,160,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(515,'INSUMOS','GENERAL',NULL,NULL,'HOJAS DE BISTURI \nTALLA: 11 101 UNIDADES POR CAJA',0.10,NULL,146,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(516,'INSUMOS','GENERAL',NULL,NULL,'HOJAS DE BISTURI \nTALLA: 15 100 UNIDADES POR CAJA ',0.10,NULL,516,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(517,'INSUMOS','GENERAL',NULL,NULL,'HOJAS DE BISTURI\n TALLA: 20 100 UNIDADES POR CAJA ',0.10,NULL,502,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(518,'INSUMOS','GENERAL',NULL,NULL,'HOJAS DE BISTURI\n TALLA: 21 100 UNIDADES POR CAJA',0.10,NULL,150,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(519,'INSUMOS','GENERAL',NULL,NULL,'HOJAS DE BISTURI\n TALLA: 22 100 UNIDADES POR CAJA',0.10,NULL,170,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(520,'INSUMOS','GENERAL',NULL,NULL,'HOJAS DE BISTURI\n TALLA: 23 100 UNIDADES POR CAJA',0.10,NULL,185,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(521,'INSUMOS','GENERAL',NULL,NULL,'AGUA OXIGENADA 1 L',0.10,NULL,4,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(522,'INSUMOS','GENERAL',NULL,NULL,'AGUA OXIGENADA 480 ML',0.10,NULL,10,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(523,'INSUMOS','GENERAL',NULL,NULL,'ALCOHOL  GARRAFAS DE 20 L',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(524,'INSUMOS','GENERAL',NULL,NULL,'ALKASEPTIC 1 L',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(525,'INSUMOS','GENERAL',NULL,NULL,'ALKAZYME (DETERGENTE ENZIMATICO) BOLSA DE 12 DOSIS DE 20 G',0.10,NULL,16,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(526,'INSUMOS','GENERAL',NULL,NULL,'BAUMANOMETRO  ANEROIDE',0.10,NULL,10,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(527,'INSUMOS','GENERAL',NULL,NULL,'BOMBA HOMEPUMP ELASTOMERIC',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(528,'INSUMOS','GENERAL',NULL,NULL,'BOTAS QUIRURJICAS 50 UNI./ PAQUETE ',0.10,NULL,300,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(529,'INSUMOS','GENERAL',NULL,NULL,'BULTOS PARA CIRUGIA DESECHABLES TALLA: UNIVERSAL',0.10,NULL,20,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(530,'INSUMOS','GENERAL',NULL,NULL,'CHUPONES PARA MAMILA  LIBRE DE LATEX',0.10,NULL,32,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(531,'INSUMOS','GENERAL',NULL,NULL,'CINTA HUMBILICAL LARGO: 41 CM',0.10,NULL,562,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(532,'INSUMOS','GENERAL',NULL,NULL,'CLORURO DE BENZALCONIO (BENZAL) 750 ML',0.10,NULL,5,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(533,'INSUMOS','GENERAL',NULL,NULL,'COLA DE RATON GENERICO',0.10,NULL,23,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(534,'INSUMOS','GENERAL',NULL,NULL,'COLLARIN CERVICAL BLANDO',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(535,'INSUMOS','GENERAL',NULL,NULL,'COMPRESAS PAQUETE DE 5 ',0.10,NULL,135,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(536,'INSUMOS','GENERAL',NULL,NULL,'CUBIERTA PARA EMPUÃADURA  ESTERIL',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(537,'INSUMOS','GENERAL',NULL,NULL,'CUBRE BOCA PAQUETES DE 50 UNIDADES ',0.10,NULL,500,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(538,'INSUMOS','GENERAL',NULL,NULL,'DETERGENTE ENZIMATICO  4 L',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(539,'INSUMOS','GENERAL',NULL,NULL,'DEXPANTENOL 5% CREMA',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(540,'INSUMOS','GENERAL',NULL,NULL,'DISPOSITIVO INTRAUTERINO  (DIU)',0.10,NULL,5,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(541,'INSUMOS','GENERAL',NULL,NULL,'DRENAJE JACKSON PRATT 100 ML',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(542,'INSUMOS','GENERAL',NULL,NULL,'ELECTRODO DE AGUJA PARA ESU 7 CM',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(543,'INSUMOS','GENERAL',NULL,NULL,'ELECTRODOS   ADULTO',0.10,NULL,56,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(544,'INSUMOS','GENERAL',NULL,NULL,'ELECTRODOS  PEDIATRICOS',0.10,NULL,450,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(545,'INSUMOS','GENERAL',NULL,NULL,'ELECTROGEL 4 KG ',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(546,'INSUMOS','GENERAL',NULL,NULL,'ESPEJO VAGINAL  DESECHABLE',0.10,NULL,12,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(547,'INSUMOS','GENERAL',NULL,NULL,'ETIQUETA PLASTICA  NUMERADA',0.10,NULL,356,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(548,'INSUMOS','GENERAL',NULL,NULL,'FLUGOMETRO  PURITAN O2',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(549,'INSUMOS','GENERAL',NULL,NULL,'FORMOL 1 L ',0.10,NULL,6,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(550,'INSUMOS','GENERAL',NULL,NULL,'FORMOL 4 L',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(551,'INSUMOS','GENERAL',NULL,NULL,'FORMULA LACTEA  ENTEREX 131 G',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(552,'INSUMOS','GENERAL',NULL,NULL,'FORMULA LACTEA  NUTRIBABY 225 G',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(553,'INSUMOS','GENERAL',NULL,NULL,'GAFIDEX (ALKASEPTIC) 4L',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(554,'INSUMOS','GENERAL',NULL,NULL,'HEMOSTATICO SATIN  8 X4 CM',0.10,NULL,83,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(555,'INSUMOS','GENERAL',NULL,NULL,'HOJA LARINGO CURVA FR: 4',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(556,'INSUMOS','GENERAL',NULL,NULL,'HOJA LARINGO CURVA FR:5',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(557,'INSUMOS','GENERAL',NULL,NULL,'INDICADOR QUIMICO  (200 PIEZAS)',0.10,NULL,4,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(558,'INSUMOS','GENERAL',NULL,NULL,'INSERCION DE CATETER URETRAL 5 FR   COOK MEDICAL ',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(559,'INSUMOS','GENERAL',NULL,NULL,'ISODINE ESPUMA 3.500 L',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(560,'INSUMOS','GENERAL',NULL,NULL,'ISODINE SOLUCION 3.500 L',0.10,NULL,7,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(561,'INSUMOS','GENERAL',NULL,NULL,'ISOPOS  GRUESOS',0.10,NULL,100,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(562,'INSUMOS','GENERAL',NULL,NULL,'ISOPOS  DELGADO',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(563,'INSUMOS','GENERAL',NULL,NULL,'JABON CON CLORHEXIDINA  AL 2 %, 950 ML ',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(564,'INSUMOS','GENERAL',NULL,NULL,'JABON EN BARRA 25 G ',0.10,NULL,249,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(565,'INSUMOS','GENERAL',NULL,NULL,'JABON QUIRURJICO 3.850 L',0.10,NULL,16,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(566,'INSUMOS','GENERAL',NULL,NULL,'JALEA 135 G ',0.10,NULL,18,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(567,'INSUMOS','GENERAL',NULL,NULL,'LANCETAS  28 G ',0.10,NULL,780,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(568,'INSUMOS','GENERAL',NULL,NULL,'LENTES INTRAOCULARES  27 D',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(569,'INSUMOS','GENERAL',NULL,NULL,'LINEA PARA DIALISIS PERITONEAL CORTA \n DE LARGA VIDA (PISATEK DP)',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(570,'INSUMOS','GENERAL',NULL,NULL,'MANGO LARINGO  ADULTO',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(571,'INSUMOS','GENERAL',NULL,NULL,'MICRODACYN 240 ML',0.10,NULL,7,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(572,'INSUMOS','GENERAL',NULL,NULL,'MICROGOTERO ADULTO',0.10,NULL,11,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(573,'INSUMOS','GENERAL',NULL,NULL,'NEURO ESPONJAS COTONOIDES',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(574,'INSUMOS','GENERAL',NULL,NULL,'NORMOGOTERO ADULTO',0.10,NULL,1715,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(575,'INSUMOS','GENERAL',NULL,NULL,'PANTUNFLAS  UNITALLA',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(576,'INSUMOS','GENERAL',NULL,NULL,'PAÃALES 10 UNIDADES POR PAQUETE',0.10,NULL,452,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(577,'INSUMOS','GENERAL',NULL,NULL,'PAÃALES 30 UNIDADES POR PAQUETE',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(578,'INSUMOS','GENERAL',NULL,NULL,'PERILLAS DE ASPIRACION  DE HULE',0.10,NULL,9,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(579,'INSUMOS','GENERAL',NULL,NULL,'PINZAS CLAM  GENERICAS',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(580,'INSUMOS','GENERAL',NULL,NULL,'PLACAS DE ELECTROCAUTERIO  ADULTO/PEDIATRICO',0.10,NULL,30,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(581,'INSUMOS','GENERAL',NULL,NULL,'PUNTAS DE ELECTROCAUTERIO ADULTO/PEDIATRICO',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(582,'INSUMOS','GENERAL',NULL,NULL,'PUNTAS NASALES  ADULTO',0.10,NULL,109,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(583,'INSUMOS','GENERAL',NULL,NULL,'PUNTAS NASALES  PEDIATRICAS',0.10,NULL,137,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(584,'INSUMOS','GENERAL',NULL,NULL,'RASTRILLOS MARCA SAFARI',0.10,NULL,123,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(585,'INSUMOS','GENERAL',NULL,NULL,'SHAMPOO 10 ML ',0.10,NULL,365,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(586,'INSUMOS','GENERAL',NULL,NULL,'SISTEMA DE DRENAJE TORÃCICO CERRADO \n (PLEUR-EVAC)',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(587,'INSUMOS','GENERAL',NULL,NULL,'SUJETADOR HIBRIDO  DE NITINOL',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(588,'INSUMOS','GENERAL',NULL,NULL,'TAPETE ADHESIVO BACTERIOSTATIC',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(589,'INSUMOS','GENERAL',NULL,NULL,'TAPONES DE HEPARINA  (SELLO VENOSO)',0.10,NULL,43,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(590,'INSUMOS','GENERAL',NULL,NULL,'TEGADERM (FILM TRANSPARENTE)',0.10,NULL,965,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(591,'INSUMOS','GENERAL',NULL,NULL,'TIJERAS  TIPO POLLERAS',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(592,'INSUMOS','GENERAL',NULL,NULL,'TINTURA DE BENJUI 1 L',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(593,'INSUMOS','GENERAL',NULL,NULL,'TIRAS REACTIVAS\n  PARA GLUCOMETRO',0.10,NULL,150,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(594,'INSUMOS','GENERAL',NULL,NULL,'VACUTANER GENERICO',0.10,NULL,10,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(595,'INSUMOS','GENERAL',NULL,NULL,'VALVULA 3 VIAS (VALVULA LOPEZ)',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(596,'INSUMOS','GENERAL',NULL,NULL,'VASO  CLINICO ESTERIL ',0.10,NULL,140,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(597,'INSUMOS','GENERAL',NULL,NULL,'VASO  HUMIDIFICADOR ',0.10,NULL,18,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(598,'INSUMOS','GENERAL',NULL,NULL,'GEL FOAM HEMOSTATICO',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(599,'INSUMOS','GENERAL',NULL,NULL,'GEL FOAM ODONTOLOGICO ODONTOLOGICO',0.10,NULL,25,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(600,'INSUMOS','GENERAL',NULL,NULL,'JERINGA CON AGUJA 3 ML',0.10,NULL,1644,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(601,'INSUMOS','GENERAL',NULL,NULL,'JERINGA SIN AGUJA 3 ML',0.10,NULL,3806,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(602,'INSUMOS','GENERAL',NULL,NULL,'JERINJAS CON AGUJA  5 ML',0.10,NULL,1461,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(603,'INSUMOS','GENERAL',NULL,NULL,'JERINGA SIN AGUJA 5 ML',0.10,NULL,3467,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(604,'INSUMOS','GENERAL',NULL,NULL,'JERINGA SIN AGUJA 10 ML',0.10,NULL,102,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(605,'INSUMOS','GENERAL',NULL,NULL,'JERINJAS CON AGUJA  10 ML',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(606,'INSUMOS','GENERAL',NULL,NULL,'JERINGA SIN AGUJA 20 ML',0.10,NULL,943,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(607,'INSUMOS','GENERAL',NULL,NULL,'JERINGA CON AGUJA 20 ML',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(608,'INSUMOS','GENERAL',NULL,NULL,'JERINGA CON AGUJA 50 ML ',0.10,NULL,27,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(609,'INSUMOS','GENERAL',NULL,NULL,'JERINGA  1 ML (INSULINA)',0.10,NULL,1181,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(610,'INSUMOS','GENERAL',NULL,NULL,'JERINGA ASEPTO DE VIDRIO 50 ML ',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(611,'INSUMOS','GENERAL',NULL,NULL,'LLAVE DE 3 VIAS  CON EXTENSION ',0.10,NULL,434,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(612,'INSUMOS','GENERAL',NULL,NULL,'LLAVE DE 3 VIAS  SIN EXTENSION ',0.10,NULL,76,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(613,'INSUMOS','GENERAL',NULL,NULL,'LLAVE DE 4 VIAS  CON EXTENSION ',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(614,'INSUMOS','GENERAL',NULL,NULL,'MALLAS ',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(615,'INSUMOS','GENERAL',NULL,NULL,'MALLA QUIRURGICA 25 A 35 CM X 25 A 35 CM',0.10,NULL,5,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(616,'INSUMOS','GENERAL',NULL,NULL,'MALLA QUIRURGICA MALTEX 15 CM X 15 CM ',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(617,'INSUMOS','GENERAL',NULL,NULL,'MASCARILLA CON NEBULIZADOR  ADULTO',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(618,'INSUMOS','GENERAL',NULL,NULL,'MASCARILLA CON NEBULIZADOR  INFALTIL',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(619,'INSUMOS','GENERAL',NULL,NULL,'MASCARILLA CON RESERVORIO  ADULTO',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(620,'INSUMOS','GENERAL',NULL,NULL,'MASCARILLA FACIAL  ADULTO',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(621,'INSUMOS','GENERAL',NULL,NULL,'MASCARILLA FACIAL  NEONATAL ',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(622,'INSUMOS','GENERAL',NULL,NULL,'MASCARILLA LARINGEA TALLA: 2',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(623,'INSUMOS','GENERAL',NULL,NULL,'MASCARILLA LARINGEA TALLA:  4',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(624,'INSUMOS','GENERAL',NULL,NULL,'MASCARILLA LARINGEA TALLA: 3',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(625,'INSUMOS','GENERAL',NULL,NULL,'MASCARILLA LARINGEA TALLA:  5',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(626,'INSUMOS','GENERAL',NULL,NULL,'MASCARILLA SIN RESERVORIO  ADULTO',0.10,NULL,17,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(627,'INSUMOS','GENERAL',NULL,NULL,'MEDIAS ANTIEMBOLICAS LARGA',0.10,NULL,20,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(628,'INSUMOS','GENERAL',NULL,NULL,'MEDIAS ANTIEMBOLICAS MEDIANA',0.10,NULL,30,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(629,'INSUMOS','GENERAL',NULL,NULL,'MEDIAS ANTIEMBOLICAS CHICA',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(630,'INSUMOS','GENERAL',NULL,NULL,'PENROSE 1',0.10,NULL,18,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(631,'INSUMOS','GENERAL',NULL,NULL,'PENROSE  1/2',0.10,NULL,23,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(632,'INSUMOS','GENERAL',NULL,NULL,'PENROSE  1/4',0.10,NULL,11,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(633,'INSUMOS','GENERAL',NULL,NULL,'PAPEL CRAF (ROLLO)',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(634,'INSUMOS','GENERAL',NULL,NULL,'PAPEL PARA ELECTROCARDIOGRAFO 6.2 CM',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(635,'INSUMOS','GENERAL',NULL,NULL,'PAPEL PARA ELECTROCARDIOGRAFO 10.8 CM',0.10,NULL,6,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(636,'INSUMOS','GENERAL',NULL,NULL,'DEXON  3-0 A/CH',0.10,NULL,142,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(637,'INSUMOS','GENERAL',NULL,NULL,'DEXON  3-0 A/G',0.10,NULL,11,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(638,'INSUMOS','GENERAL',NULL,NULL,'MAXSORB 3-0 A/G',0.10,NULL,25,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(639,'INSUMOS','GENERAL',NULL,NULL,'MONOCRYL  3-0 A/CH',0.10,NULL,12,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(640,'INSUMOS','GENERAL',NULL,NULL,'POLIDIOXANONA  3-0 A/G',0.10,NULL,7,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(641,'INSUMOS','GENERAL',NULL,NULL,'SUTURA CATGUT CROMICO SIMPLE  0 A/G',0.10,NULL,133,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(642,'INSUMOS','GENERAL',NULL,NULL,'SUTURA CATGUT CROMICO SIMPLE  1-0 A/CH',0.10,NULL,31,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(643,'INSUMOS','GENERAL',NULL,NULL,'SUTURA CATGUT CROMICO SIMPLE  1-0 A/G',0.10,NULL,32,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(644,'INSUMOS','GENERAL',NULL,NULL,'SUTURA CATGUT CROMICO SIMPLE  2-0 A/CH',0.10,NULL,89,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(645,'INSUMOS','GENERAL',NULL,NULL,'SUTURA CATGUT CROMICO SIMPLE  2-0 A/G',0.10,NULL,377,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(646,'INSUMOS','GENERAL',NULL,NULL,'SUTURA CATGUT CROMICO SIMPLE  4-0 A/G',0.10,NULL,60,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(647,'INSUMOS','GENERAL',NULL,NULL,'SUTURA CERA PARA HUESO',0.10,NULL,60,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(648,'INSUMOS','GENERAL',NULL,NULL,'SUTURA CROMICO  3-0 A/G',0.10,NULL,76,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(649,'INSUMOS','GENERAL',NULL,NULL,'SUTURA CROMICO  4-0 A/CH DOBLE ARMADA ',0.10,NULL,12,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(650,'INSUMOS','GENERAL',NULL,NULL,'SUTURA CROMICO  4-0 A/G',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(651,'INSUMOS','GENERAL',NULL,NULL,'SUTURA NAYLON  2-0 A/CH',0.10,NULL,277,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(652,'INSUMOS','GENERAL',NULL,NULL,'SUTURA NAYLON  3-0 A/CH',0.10,NULL,72,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(653,'INSUMOS','GENERAL',NULL,NULL,'SUTURA NYLON  10-0 A/CH',0.10,NULL,36,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(654,'INSUMOS','GENERAL',NULL,NULL,'SUTURA NYLON  4-0 A/CH',0.10,NULL,72,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(655,'INSUMOS','GENERAL',NULL,NULL,'SUTURA NYLON  5-0  A/CH',0.10,NULL,31,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(656,'INSUMOS','GENERAL',NULL,NULL,'SUTURA NYLON  6-0 A/CH',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(657,'INSUMOS','GENERAL',NULL,NULL,'SUTURA POLIPROPILENO  1-0 A/G',0.10,NULL,100,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(658,'INSUMOS','GENERAL',NULL,NULL,'SUTURA POLIPROPILENO  2-0 A/CH',0.10,NULL,72,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(659,'INSUMOS','GENERAL',NULL,NULL,'SUTURA POLIPROPILENO  2-0 DOBLE ARMADA',0.10,NULL,15,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(660,'INSUMOS','GENERAL',NULL,NULL,'SUTURA POLIPROPILENO   3-0 A/CH',0.10,NULL,15,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(661,'INSUMOS','GENERAL',NULL,NULL,'SUTURA POLIPROPILENO  3-0 A/CH DOBLE ARMADA',0.10,NULL,8,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(662,'INSUMOS','GENERAL',NULL,NULL,'SUTURA POLIPROPILENO  3-0 A/G',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(663,'INSUMOS','GENERAL',NULL,NULL,'SUTURA POLIPROPILENO  3-0 DOBLE ARMADA',0.10,NULL,24,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(664,'INSUMOS','GENERAL',NULL,NULL,'SUTURA POLIPROPILENO  5-0 A/CH DOBLE ARMADA',0.10,NULL,16,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(665,'INSUMOS','GENERAL',NULL,NULL,'SUTURA POLIPROPILENO  6-0 A/CH',0.10,NULL,12,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(666,'INSUMOS','GENERAL',NULL,NULL,'SUTURA POLIPROPILENO  6-0 A/CH DOBLE ARMADA',0.10,NULL,28,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(667,'INSUMOS','GENERAL',NULL,NULL,'SUTURA POLIPROPILENO   7-0 A/CH',0.10,NULL,7,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(668,'INSUMOS','GENERAL',NULL,NULL,'SUTURA SEDA  1-0 A/CH',0.10,NULL,8,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(669,'INSUMOS','GENERAL',NULL,NULL,'SUTURA SEDA 1-0 A/G',0.10,NULL,71,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(670,'INSUMOS','GENERAL',NULL,NULL,'SUTURA SEDA 2-0 A/CH',0.10,NULL,12,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(671,'INSUMOS','GENERAL',NULL,NULL,'SUTURA SEDA 2-0 A/G',0.10,NULL,168,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(672,'INSUMOS','GENERAL',NULL,NULL,'SUTURA SEDA  3-0 A/CH',0.10,NULL,72,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(673,'INSUMOS','GENERAL',NULL,NULL,'SUTURA SEDA  3-0 A/G',0.10,NULL,26,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(674,'INSUMOS','GENERAL',NULL,NULL,'SUTURA SEDA  7-0 A/CH',0.10,NULL,24,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(675,'INSUMOS','GENERAL',NULL,NULL,'SUTURA SEDA  7-0 A/G',0.10,NULL,24,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(676,'INSUMOS','GENERAL',NULL,NULL,'SUTURA SEDA LIBRE   0 SIN AGUJA',0.10,NULL,48,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(677,'INSUMOS','GENERAL',NULL,NULL,'SUTURA SEDA LIBRE   1-0 SIN AGUJA',0.10,NULL,58,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(678,'INSUMOS','GENERAL',NULL,NULL,'SUTURA SEDA LIBRE   2-0 SIN AGUJA',0.10,NULL,43,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(679,'INSUMOS','GENERAL',NULL,NULL,'SUTURA SEDA LIBRE  3-0 SIN AGUJA ',0.10,NULL,12,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(680,'INSUMOS','GENERAL',NULL,NULL,'SUTURA VICRYL  0 A/CH',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(681,'INSUMOS','GENERAL',NULL,NULL,'SUTURA VICRYL 0 A/G',0.10,NULL,284,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(682,'INSUMOS','GENERAL',NULL,NULL,'SUTURA VICRYL  1-0 A/CH',0.10,NULL,10,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(683,'INSUMOS','GENERAL',NULL,NULL,'SUTURA VICRYL  1-0 A/G',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(684,'INSUMOS','GENERAL',NULL,NULL,'SUTURA VICRYL  2-0 A/CH',0.10,NULL,410,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(685,'INSUMOS','GENERAL',NULL,NULL,'SUTURA VICRYL  2-0 A/G',0.10,NULL,139,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(686,'INSUMOS','GENERAL',NULL,NULL,'SUTURA VICRYL  3-0 A/CH',0.10,NULL,137,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(687,'INSUMOS','GENERAL',NULL,NULL,'SUTURA VICRYL  3-0 A/G',0.10,NULL,5,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(688,'INSUMOS','GENERAL',NULL,NULL,'SUTURA VICRYL  4-0 A/CH',0.10,NULL,12,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(689,'INSUMOS','GENERAL',NULL,NULL,'SUTURA VICRYL  5-0 A/G',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(690,'INSUMOS','GENERAL',NULL,NULL,'SONDA DE DRENAJE BILIAR KEHR, SONDA EN T FR: 14',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(691,'INSUMOS','GENERAL',NULL,NULL,'SONDA DE DRENAJE BILIAR KEHR, SONDA EN T FR: 16',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(692,'INSUMOS','GENERAL',NULL,NULL,'SONDA DE DRENAJE BILIAR KEHR, SONDA EN T FR: 18',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(693,'INSUMOS','GENERAL',NULL,NULL,'SONDA FOLEY  DE DOS VIAS  FR: 12 ',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(694,'INSUMOS','GENERAL',NULL,NULL,'SONDA FOLEY  DE DOS VIAS  FR: 14',0.10,NULL,65,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(695,'INSUMOS','GENERAL',NULL,NULL,'SONDA FOLEY  DE DOS VIAS  FR: 16',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(696,'INSUMOS','GENERAL',NULL,NULL,'SONDA FOLEY  DE DOS VIAS  FR: 18 ',0.10,NULL,14,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(697,'INSUMOS','GENERAL',NULL,NULL,'SONDA FOLEY  DE DOS VIAS FR: 20',0.10,NULL,16,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(698,'INSUMOS','GENERAL',NULL,NULL,'SONDA FOLEY  DE DOS VIAS  FR: 22',0.10,NULL,12,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(699,'INSUMOS','GENERAL',NULL,NULL,'SONDA FOLEY  DE DOS VIAS  FR: 24',0.10,NULL,5,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(700,'INSUMOS','GENERAL',NULL,NULL,'SONDA FOLEY DE TRES VIAS GLOBO 30  FR: 18 ',0.10,NULL,10,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(701,'INSUMOS','GENERAL',NULL,NULL,'SONDA FOLEY DE TRES VIAS GLOBO 30  FR: 20',0.10,NULL,24,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(702,'INSUMOS','GENERAL',NULL,NULL,'SONDA FOLEY DE TRES VIAS GLOBO 30  FR: 22',0.10,NULL,15,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(703,'INSUMOS','GENERAL',NULL,NULL,'SONDA FOLEY DE TRES VIAS GLOBO 30  FR: 24',0.10,NULL,10,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(704,'INSUMOS','GENERAL',NULL,NULL,'SONDA PARA ALIMENTACION INFANTIL CORTA FR: 5 ',0.10,NULL,43,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(705,'INSUMOS','GENERAL',NULL,NULL,'SONDA PARA ALIMENTACION INFANTIL CORTA FR: 5 (NO SECTOR SALUD)',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(706,'INSUMOS','GENERAL',NULL,NULL,'SONDA PARA ALIMENTACION INFANTIL CORTA FR: 6 ',0.10,NULL,58,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(707,'INSUMOS','GENERAL',NULL,NULL,'SONDA PARA ALIMENTACION INFANTIL CORTA FR: 8 ',0.10,NULL,64,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(708,'INSUMOS','GENERAL',NULL,NULL,'SONDA PARA ALIMENTACION INFANTIL CORTA FR: 8 (NO SECTOR SALUD)',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(709,'INSUMOS','GENERAL',NULL,NULL,'SONDA PARA ASPIRACION DE SECRECIONES  FR: 8',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(710,'INSUMOS','GENERAL',NULL,NULL,'SONDA PARA ASPIRACION DE SECRECIONES  FR: 10 ',0.10,NULL,15,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(711,'INSUMOS','GENERAL',NULL,NULL,'SONDA PARA ASPIRACION DE SECRECIONES  FR: 12 ',0.10,NULL,7,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(712,'INSUMOS','GENERAL',NULL,NULL,'SONDA PARA ASPIRACION DE SECRECIONES  FR: 14',0.10,NULL,36,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(713,'INSUMOS','GENERAL',NULL,NULL,'SONDA PARA ASPIRACION DE SECRECIONES  FR: 16',0.10,NULL,20,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(714,'INSUMOS','GENERAL',NULL,NULL,'SONDA PARA ASPIRACION DE SECRECIONES  FR: 18',0.10,NULL,12,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(715,'INSUMOS','GENERAL',NULL,NULL,'SONDA PARA ASPIRACION DE SECRECIONES  FR: 20',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(716,'INSUMOS','GENERAL',NULL,NULL,'SONDAS NELATON  FR: 8',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(717,'INSUMOS','GENERAL',NULL,NULL,'SONDAS NELATON  FR: 12 ',0.10,NULL,5,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(718,'INSUMOS','GENERAL',NULL,NULL,'SONDAS NELATON  FR: 14',0.10,NULL,31,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(719,'INSUMOS','GENERAL',NULL,NULL,'SONDAS NELATON  FR: 16',0.10,NULL,22,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(720,'INSUMOS','GENERAL',NULL,NULL,'SONDAS NELATON  FR: 18 ',0.10,NULL,25,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(721,'INSUMOS','GENERAL',NULL,NULL,'SONDAS NELATON  FR: 22 ',0.10,NULL,12,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(722,'INSUMOS','GENERAL',NULL,NULL,'SONDAS NELATON  FR: 24',0.10,NULL,10,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(723,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION ESTERIL  500 ML',0.10,NULL,30,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(724,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION FISIOLOGICA 3000 ML',0.10,NULL,66,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(725,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION FISIOLOGICA 1000 ML',0.10,NULL,301,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(726,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION FISIOLOGICA  500 ML',0.10,NULL,50,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(727,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION FISIOLOGICA  100 ML',0.10,NULL,438,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(728,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION FISIOLOGICA  250 ML',0.10,NULL,34,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(729,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION FISIOLOGICA  50 ML',0.10,NULL,133,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(730,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION GLUCOSA AL 5%  1000 ML',0.10,NULL,109,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(731,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION GLUCOSA AL 5%  250 ML',0.10,NULL,7,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(732,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION GLUCOSA AL 5%  500 ML',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(733,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION GLUCOSA AL 10%  1000 ML',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(734,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION GLUCOSA AL 10%  500 ML',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(735,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION HARTMAN  1000 ML',0.10,NULL,54,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(736,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION HARTMAN  500 ML',0.10,NULL,242,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(737,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION HARTMAN  250 ML',0.10,NULL,75,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(738,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION MIXTA  1000 ML',0.10,NULL,42,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(739,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION MIXTA  250 ML',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(740,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION MIXTA  500 ML',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(741,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION GLUCOSA 50% 50 ML',0.10,NULL,8,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(742,'INSUMOS','GENERAL',NULL,NULL,'SOLUCIONES DE AZUL DE TRIPANO OCULAR ',0.10,NULL,5,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(743,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION DIALISIS PERITONEAL  1.5% 2000 ML',0.10,NULL,11,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(744,'INSUMOS','GENERAL',NULL,NULL,'SOLUCION DIALISIS PERITONEAL  2.5% 2000 ML',0.10,NULL,17,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(745,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 3.0',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(746,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 3.5  ',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(747,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 4.0',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(748,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 4.5',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(749,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 5.0',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(750,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 5.5',0.10,NULL,4,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(751,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 6.0 ',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(752,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 6.5',0.10,NULL,5,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(753,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 7.0',0.10,NULL,27,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(754,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 7.5',0.10,NULL,26,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(755,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 8.0',0.10,NULL,22,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(756,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 8.5 ',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(757,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 9.0',0.10,NULL,8,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(758,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 9.5 ',0.10,NULL,12,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(759,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL CON GLOBO FR: 10.0',0.10,NULL,0,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(760,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL DOBLE ARMADA FR: 5.5 ',0.10,NULL,4,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(761,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL DOBLE ARMADA FR: 6.0 ',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(762,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL DOBLE ARMADA FR: 6.5 ',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(763,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL DOBLE ARMADA FR: 7.0',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(764,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL SIN GLOBO FR: 2.0',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(765,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL SIN GLOBO FR: 2.5',0.10,NULL,4,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(766,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL SIN GLOBO FR: 3.0',0.10,NULL,4,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(767,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL SIN GLOBO FR: 3.5 ',0.10,NULL,3,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(768,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL SIN GLOBO FR: 4.0',0.10,NULL,4,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(769,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL SIN GLOBO FR: 4.5 ',0.10,NULL,7,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(770,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL SIN GLOBO FR: 5.0',0.10,NULL,2,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(771,'INSUMOS','GENERAL',NULL,NULL,'TUBO ENDOTRAQUEAL SIN GLOBO FR: 5.5 ',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(772,'INSUMOS','GENERAL',NULL,NULL,'VENDA DE ALGODON  5 CM ',0.10,NULL,314,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(773,'INSUMOS','GENERAL',NULL,NULL,'VENDA DE ALGODON  10 CM',0.10,NULL,121,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(774,'INSUMOS','GENERAL',NULL,NULL,'VENDA DE ALGODON  15 CM',0.10,NULL,83,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(775,'INSUMOS','GENERAL',NULL,NULL,'VENDA DE ALGODON  30 CM',0.10,NULL,307,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(776,'INSUMOS','GENERAL',NULL,NULL,'VENDA DE GOMA TIPO SMART 10 CM',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(777,'INSUMOS','GENERAL',NULL,NULL,'VENDA DE GOMA TIPO SMART 15 CM',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(778,'INSUMOS','GENERAL',NULL,NULL,'VENDA DE MALLA ELASTICA EN FORMA TUBULAR (PEDIATRICO) 4 FR, 100 M',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(779,'INSUMOS','GENERAL',NULL,NULL,'VENDA DE YESO  10 CM ',0.10,NULL,41,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(780,'INSUMOS','GENERAL',NULL,NULL,'VENDA DE YESO  15 CM',0.10,NULL,22,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(781,'INSUMOS','GENERAL',NULL,NULL,'VENDA DE HUATA  20 CM ',0.10,NULL,42,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(782,'INSUMOS','GENERAL',NULL,NULL,'VENDA DE HUATA  15 CM ',0.10,NULL,4,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(783,'INSUMOS','GENERAL',NULL,NULL,'VENDA ELASTICA ADHESIVA 7.5 CM',0.10,NULL,6,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(784,'INSUMOS','GENERAL',NULL,NULL,'VENDA ELASTICA ADHESIVA 15 CM ',0.10,NULL,1,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(785,'SERVICIOS','ADMISION','',NULL,'LLENADO DE HOJA FRONTAL',0.10,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57'),
(786,'SERVICIOS','ESTUDIOS','85121801_01',NULL,'SOLICITUD PATOLOGÍA',0.10,NULL,NULL,NULL,NULL,NULL,NULL,16.00,'2026-02-12 21:46:57','2026-02-12 21:46:57');
/*!40000 ALTER TABLE `producto_servicios` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `reservacion_horarios`
--

DROP TABLE IF EXISTS `reservacion_horarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservacion_horarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reservacion_id` bigint(20) unsigned NOT NULL,
  `habitacion_precio_id` bigint(20) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservacion_horarios_reservacion_id_foreign` (`reservacion_id`),
  KEY `reservacion_horarios_habitacion_precio_id_foreign` (`habitacion_precio_id`),
  CONSTRAINT `reservacion_horarios_habitacion_precio_id_foreign` FOREIGN KEY (`habitacion_precio_id`) REFERENCES `habitacion_precios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservacion_horarios_reservacion_id_foreign` FOREIGN KEY (`reservacion_id`) REFERENCES `reservaciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservacion_horarios`
--

LOCK TABLES `reservacion_horarios` WRITE;
/*!40000 ALTER TABLE `reservacion_horarios` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `reservacion_horarios` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `reservacion_quirofanos`
--

DROP TABLE IF EXISTS `reservacion_quirofanos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservacion_quirofanos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `habitacion_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `estancia_id` bigint(20) unsigned DEFAULT NULL,
  `paciente` varchar(255) DEFAULT NULL,
  `tratante` varchar(255) NOT NULL,
  `procedimiento` varchar(255) NOT NULL,
  `tiempo_estimado` varchar(255) NOT NULL,
  `medico_operacion` varchar(255) NOT NULL,
  `laparoscopia_detalle` text DEFAULT NULL,
  `instrumentista` text DEFAULT NULL,
  `anestesiologo` text DEFAULT NULL,
  `insumos_medicamentos` text DEFAULT NULL,
  `esterilizar_detalle` text DEFAULT NULL,
  `rayosx_detalle` text DEFAULT NULL,
  `patologico_detalle` text DEFAULT NULL,
  `comentarios` text DEFAULT NULL,
  `horarios` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`horarios`)),
  `fecha` date NOT NULL,
  `localizacion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservacion_quirofanos_habitacion_id_foreign` (`habitacion_id`),
  KEY `reservacion_quirofanos_user_id_foreign` (`user_id`),
  KEY `reservacion_quirofanos_estancia_id_foreign` (`estancia_id`),
  CONSTRAINT `reservacion_quirofanos_estancia_id_foreign` FOREIGN KEY (`estancia_id`) REFERENCES `estancias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservacion_quirofanos_habitacion_id_foreign` FOREIGN KEY (`habitacion_id`) REFERENCES `habitaciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservacion_quirofanos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservacion_quirofanos`
--

LOCK TABLES `reservacion_quirofanos` WRITE;
/*!40000 ALTER TABLE `reservacion_quirofanos` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `reservacion_quirofanos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `reservaciones`
--

DROP TABLE IF EXISTS `reservaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservaciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `pago_total` decimal(8,2) DEFAULT NULL,
  `estatus` enum('pendiente','pagado','cancelado') NOT NULL DEFAULT 'pendiente',
  `user_id` bigint(20) unsigned NOT NULL,
  `stripe_payment_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservaciones_user_id_foreign` (`user_id`),
  CONSTRAINT `reservaciones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservaciones`
--

LOCK TABLES `reservaciones` WRITE;
/*!40000 ALTER TABLE `reservaciones` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `reservaciones` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `respuesta_formularios`
--

DROP TABLE IF EXISTS `respuesta_formularios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `respuesta_formularios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `detalles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`detalles`)),
  `catalogo_pregunta_id` bigint(20) unsigned NOT NULL,
  `historia_clinica_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `respuesta_formularios_catalogo_pregunta_id_foreign` (`catalogo_pregunta_id`),
  KEY `respuesta_formularios_historia_clinica_id_foreign` (`historia_clinica_id`),
  CONSTRAINT `respuesta_formularios_catalogo_pregunta_id_foreign` FOREIGN KEY (`catalogo_pregunta_id`) REFERENCES `catalogo_preguntas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `respuesta_formularios_historia_clinica_id_foreign` FOREIGN KEY (`historia_clinica_id`) REFERENCES `historia_clinicas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respuesta_formularios`
--

LOCK TABLES `respuesta_formularios` WRITE;
/*!40000 ALTER TABLE `respuesta_formularios` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `respuesta_formularios` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `role_has_permissions` VALUES
(1,1),
(2,1),
(3,1),
(4,1),
(5,1),
(6,1),
(7,1),
(8,1),
(9,1),
(10,1),
(11,1),
(12,1),
(13,1),
(14,1),
(15,1),
(16,1),
(17,1),
(18,1),
(19,1),
(20,1),
(21,1),
(22,1),
(23,1),
(24,1),
(25,1),
(26,1),
(27,1),
(28,1),
(29,1),
(30,1),
(31,1),
(32,1),
(33,1),
(34,1),
(35,1),
(36,1),
(37,1),
(38,1),
(39,1),
(40,1),
(41,1),
(42,1),
(43,1),
(44,1),
(45,1),
(46,1),
(47,1),
(48,1),
(49,1),
(50,1),
(51,1),
(52,1),
(53,1),
(54,1),
(55,1),
(56,1),
(57,1),
(58,1),
(59,1),
(60,1),
(61,1),
(62,1),
(63,1),
(1,2),
(2,2),
(3,2),
(5,2),
(6,2),
(7,2),
(34,2),
(35,2),
(37,2),
(39,2),
(41,2),
(43,2),
(45,2),
(47,2),
(49,2),
(50,2),
(1,3),
(2,3),
(3,3),
(5,3),
(6,3),
(7,3),
(39,3),
(49,3),
(50,3),
(1,4),
(2,4),
(3,4),
(5,4),
(6,4),
(35,4),
(38,4),
(39,4),
(41,4),
(43,4),
(45,4),
(47,4),
(52,6),
(53,6),
(54,6),
(55,6),
(62,6),
(63,6),
(59,8),
(60,8),
(1,12),
(2,12),
(3,12),
(5,12),
(2,13),
(6,13),
(21,13),
(22,13),
(23,13),
(24,13),
(26,13),
(27,13),
(28,13),
(29,13),
(30,13),
(31,13),
(32,13),
(33,13);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `roles` VALUES
(1,'administrador','web','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(2,'medico','web','2026-02-12 21:46:56','2026-02-12 21:46:56'),
(3,'medico especialista','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(4,'enfermera(o)','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(5,'administrativos','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(6,'cocina','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(7,'mantenimiento','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(8,'farmacia','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(9,'técnico radiólogo','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(10,'técnico de laboratorio','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(11,'fisoterapeuta','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(12,'recepcion','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(13,'caja','web','2026-02-12 21:46:57','2026-02-12 21:46:57'),
(14,'químico','web','2026-02-12 21:46:57','2026-02-12 21:46:57');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_foreign` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`),
  CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sessions` VALUES
('h4fykVTO14SWn7K8ovzoLTB55mAEHGrZeQRhI8LZ',7,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYUhydHY5cnlUa3ZSTjFPWGVmalFsdlpaOE5HSHhUWk5XTU9HZjk1QSI7czozOiJ1cmwiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob2phc2VuZmVybWVyaWFzLzEvZWRpdCI7czo1OiJyb3V0ZSI7czoyMToiaG9qYXNlbmZlcm1lcmlhcy5lZGl0Ijt9fQ==',1770932914);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `solicitud_dietas`
--

DROP TABLE IF EXISTS `solicitud_dietas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitud_dietas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hoja_enfermeria_id` bigint(20) unsigned NOT NULL,
  `dieta_id` bigint(20) unsigned NOT NULL,
  `horario_solicitud` datetime NOT NULL,
  `user_supervisa_id` bigint(20) unsigned DEFAULT NULL,
  `horario_entrega` datetime DEFAULT NULL,
  `user_entrega_id` bigint(20) unsigned DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `solicitud_dietas_hoja_enfermeria_id_foreign` (`hoja_enfermeria_id`),
  KEY `solicitud_dietas_dieta_id_foreign` (`dieta_id`),
  KEY `solicitud_dietas_user_supervisa_id_foreign` (`user_supervisa_id`),
  KEY `solicitud_dietas_user_entrega_id_foreign` (`user_entrega_id`),
  CONSTRAINT `solicitud_dietas_dieta_id_foreign` FOREIGN KEY (`dieta_id`) REFERENCES `dietas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `solicitud_dietas_hoja_enfermeria_id_foreign` FOREIGN KEY (`hoja_enfermeria_id`) REFERENCES `hoja_enfermerias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `solicitud_dietas_user_entrega_id_foreign` FOREIGN KEY (`user_entrega_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `solicitud_dietas_user_supervisa_id_foreign` FOREIGN KEY (`user_supervisa_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud_dietas`
--

LOCK TABLES `solicitud_dietas` WRITE;
/*!40000 ALTER TABLE `solicitud_dietas` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `solicitud_dietas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `solicitud_estudios`
--

DROP TABLE IF EXISTS `solicitud_estudios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitud_estudios` (
  `id` bigint(20) unsigned NOT NULL,
  `user_solicita_id` bigint(20) unsigned NOT NULL,
  `user_llena_id` bigint(20) unsigned NOT NULL,
  `problemas_clinicos` text DEFAULT NULL,
  `incidentes_accidentes` text DEFAULT NULL,
  `resultado` text DEFAULT NULL,
  `itemable_type` varchar(255) DEFAULT NULL,
  `itemable_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `solicitud_estudios_user_solicita_id_foreign` (`user_solicita_id`),
  KEY `solicitud_estudios_user_llena_id_foreign` (`user_llena_id`),
  KEY `solicitud_estudios_itemable_type_itemable_id_index` (`itemable_type`,`itemable_id`),
  CONSTRAINT `solicitud_estudios_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `solicitud_estudios_user_llena_id_foreign` FOREIGN KEY (`user_llena_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `solicitud_estudios_user_solicita_id_foreign` FOREIGN KEY (`user_solicita_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud_estudios`
--

LOCK TABLES `solicitud_estudios` WRITE;
/*!40000 ALTER TABLE `solicitud_estudios` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `solicitud_estudios` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `solicitud_items`
--

DROP TABLE IF EXISTS `solicitud_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitud_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `solicitud_estudio_id` bigint(20) unsigned NOT NULL,
  `catalogo_estudio_id` bigint(20) unsigned DEFAULT NULL,
  `detalles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`detalles`)),
  `otro_estudio` varchar(255) DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'solicitado',
  `user_realiza_id` bigint(20) unsigned DEFAULT NULL,
  `fecha_realizacion` datetime DEFAULT NULL,
  `problema_clinico` varchar(255) DEFAULT NULL,
  `incidentes_accidentes` varchar(255) DEFAULT NULL,
  `ruta_archivo_resultado` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `solicitud_items_solicitud_estudio_id_foreign` (`solicitud_estudio_id`),
  KEY `solicitud_items_catalogo_estudio_id_foreign` (`catalogo_estudio_id`),
  KEY `solicitud_items_user_realiza_id_foreign` (`user_realiza_id`),
  CONSTRAINT `solicitud_items_catalogo_estudio_id_foreign` FOREIGN KEY (`catalogo_estudio_id`) REFERENCES `catalogo_estudios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `solicitud_items_solicitud_estudio_id_foreign` FOREIGN KEY (`solicitud_estudio_id`) REFERENCES `solicitud_estudios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `solicitud_items_user_realiza_id_foreign` FOREIGN KEY (`user_realiza_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud_items`
--

LOCK TABLES `solicitud_items` WRITE;
/*!40000 ALTER TABLE `solicitud_items` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `solicitud_items` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `solicitud_patologias`
--

DROP TABLE IF EXISTS `solicitud_patologias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitud_patologias` (
  `id` bigint(20) unsigned NOT NULL,
  `user_solicita_id` bigint(20) unsigned NOT NULL,
  `fecha_estudio` date NOT NULL,
  `estudio_solicitado` varchar(255) NOT NULL,
  `biopsia_pieza_quirurgica` varchar(255) DEFAULT NULL,
  `revision_laminillas` varchar(255) DEFAULT NULL,
  `estudios_especiales` varchar(255) DEFAULT NULL,
  `pcr` varchar(255) DEFAULT NULL,
  `pieza_remitida` varchar(255) NOT NULL,
  `contenedores_enviados` int(11) NOT NULL DEFAULT 1,
  `datos_clinicos` text DEFAULT NULL,
  `empresa_enviar` varchar(255) DEFAULT NULL,
  `resultados` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `itemable_type` varchar(255) DEFAULT NULL,
  `itemable_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `solicitud_patologias_user_solicita_id_foreign` (`user_solicita_id`),
  KEY `solicitud_patologias_itemable_type_itemable_id_index` (`itemable_type`,`itemable_id`),
  CONSTRAINT `solicitud_patologias_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `solicitud_patologias_user_solicita_id_foreign` FOREIGN KEY (`user_solicita_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud_patologias`
--

LOCK TABLES `solicitud_patologias` WRITE;
/*!40000 ALTER TABLE `solicitud_patologias` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `solicitud_patologias` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `subscription_items`
--

DROP TABLE IF EXISTS `subscription_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscription_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint(20) unsigned NOT NULL,
  `stripe_id` varchar(255) NOT NULL,
  `stripe_product` varchar(255) NOT NULL,
  `stripe_price` varchar(255) NOT NULL,
  `meter_id` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `meter_event_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscription_items_stripe_id_unique` (`stripe_id`),
  KEY `subscription_items_subscription_id_stripe_price_index` (`subscription_id`,`stripe_price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_items`
--

LOCK TABLES `subscription_items` WRITE;
/*!40000 ALTER TABLE `subscription_items` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `subscription_items` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `stripe_id` varchar(255) NOT NULL,
  `stripe_status` varchar(255) NOT NULL,
  `stripe_price` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscriptions_stripe_id_unique` (`stripe_id`),
  KEY `subscriptions_user_id_stripe_status_index` (`user_id`,`stripe_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `transfusion_realizadas`
--

DROP TABLE IF EXISTS `transfusion_realizadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transfusion_realizadas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nota_postoperatoria_id` bigint(20) unsigned NOT NULL,
  `tipo_transfusion` varchar(255) NOT NULL,
  `cantidad` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfusion_realizadas_nota_postoperatoria_id_foreign` (`nota_postoperatoria_id`),
  CONSTRAINT `transfusion_realizadas_nota_postoperatoria_id_foreign` FOREIGN KEY (`nota_postoperatoria_id`) REFERENCES `nota_postoperatorias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfusion_realizadas`
--

LOCK TABLES `transfusion_realizadas` WRITE;
/*!40000 ALTER TABLE `transfusion_realizadas` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `transfusion_realizadas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `traslado`
--

DROP TABLE IF EXISTS `traslado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `traslado` (
  `id` bigint(20) unsigned NOT NULL,
  `ta` varchar(255) NOT NULL,
  `fc` int(11) NOT NULL,
  `fr` int(11) NOT NULL,
  `peso` decimal(8,2) NOT NULL,
  `talla` int(11) NOT NULL,
  `temp` decimal(4,2) NOT NULL,
  `resultado_estudios` text NOT NULL,
  `tratamiento` text NOT NULL,
  `resumen_del_interrogatorio` text NOT NULL,
  `exploracion_fisica` text NOT NULL,
  `diagnostico_o_problemas_clinicos` text NOT NULL,
  `plan_de_estudio` text NOT NULL,
  `pronostico` text NOT NULL,
  `unidad_medica_envia` varchar(255) NOT NULL,
  `unidad_medica_recibe` varchar(255) NOT NULL,
  `motivo_translado` text NOT NULL,
  `impresion_diagnostica` text NOT NULL,
  `terapeutica_empleada` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `traslado_id_foreign` FOREIGN KEY (`id`) REFERENCES `formulario_instancias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `traslado`
--

LOCK TABLES `traslado` WRITE;
/*!40000 ALTER TABLE `traslado` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `traslado` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `curp` varchar(18) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido_paterno` varchar(100) NOT NULL,
  `apellido_materno` varchar(100) NOT NULL,
  `sexo` enum('Masculino','Femenino') NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `colaborador_responsable_id` bigint(20) unsigned DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(255) DEFAULT NULL,
  `pm_type` varchar(255) DEFAULT NULL,
  `pm_last_four` varchar(4) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_curp_unique` (`curp`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_colaborador_responsable_id_foreign` (`colaborador_responsable_id`),
  KEY `users_stripe_id_index` (`stripe_id`),
  CONSTRAINT `users_colaborador_responsable_id_foreign` FOREIGN KEY (`colaborador_responsable_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `users` VALUES
(1,'JUAP850101HDFLRS01','Juan','Pérez','Ramírez','Masculino','1985-01-01','7774441234',1,'juan.perez@hospital.com',NULL,'$2y$12$od1qPe1wCavLX.aJiSaMUe.HeoHhewoM9uBZ4OIlpAOuyXYOrUX8W',NULL,NULL,NULL,NULL,'2026-02-12 21:46:57','2026-02-12 21:46:57',NULL,NULL,NULL,NULL),
(2,'MALO900214MDFLPS02','María','López','Santos','Femenino','1990-02-14','7774441234',1,'enfermeralicenciada@hospital.com',NULL,'$2y$12$BowIFQ4U7yjG6Ye1lR1Wve1Sh5q7Pl9j2TWTSIrDxwh0MqkoL.1RG',NULL,NULL,NULL,NULL,'2026-02-12 21:46:58','2026-02-12 21:46:58',NULL,NULL,NULL,NULL),
(3,'CARA820710HDFRMR03','Carlos','Ramírez','Moreno','Masculino','1982-07-10','7774441234',1,'enfermeraauxiliar@test.com',NULL,'$2y$12$pdAw10AOmSrzWhrD60nL6.wDw7x4feI0p3cixNKpqv07PVzdZ.kB6',NULL,NULL,NULL,NULL,'2026-02-12 21:46:58','2026-02-12 21:46:58',NULL,NULL,NULL,NULL),
(4,'LAHE880320MDFHND04','Laura','Hernández','Díaz','Femenino','1988-03-20','7774441234',3,'laura.hernandez@hospital.com',NULL,'$2y$12$EOmGW2ofnKD7hnis9lXGaOJeN6vIJULTgKg7eqjR7t.yOZsD5T/8q',NULL,NULL,NULL,NULL,'2026-02-12 21:46:58','2026-02-12 21:46:58',NULL,NULL,NULL,NULL),
(5,'ANGG910923HDFGLZ05','Andrés','González','Luna','Masculino','1991-09-23','7774441234',2,'andres.gonzalez@hospital.com',NULL,'$2y$12$6JPjtYWjopAzz8Ck9QFEceOq3kTZoYUTH3xA3KwkZAPUTIss/tvBi',NULL,NULL,NULL,NULL,'2026-02-12 21:46:58','2026-02-12 21:46:58',NULL,NULL,NULL,NULL),
(6,'SOMA950105MDFMRT06','Sofía','Martínez','Rojas','Femenino','1995-01-05','7774441234',5,'sofia.martinez@hospital.com',NULL,'$2y$12$gS6LKGztMybHTXA2eqGuBOd85CRNJR/XN0Zu96LZuwRC1s4O.5L9i',NULL,NULL,NULL,NULL,'2026-02-12 21:46:58','2026-02-12 21:46:58',NULL,NULL,NULL,NULL),
(7,'TIMK040210HMSRDVA6','Kevin Yahir','Trinidad','Medina','Masculino','2004-02-10','7774441234',NULL,'kevinyahirt@gmail.com',NULL,'$2y$12$Ya2oTyYQ0zcz85/hXc3mIe6V3ZJ7w6ALldVCxD/7fV0GDJ3Kb1txq',NULL,NULL,NULL,NULL,'2026-02-12 21:46:58','2026-02-12 21:46:58',NULL,NULL,NULL,NULL),
(8,'HEAL000101HDFXXX01','HealthCare','Prueba','Sistema','Masculino','2000-01-01','7774441234',NULL,'healthcare@test.com',NULL,'$2y$12$1gvst4pMNT0Irt6X3w0Biub.BY8on0snNqaczttOiR1L0avdt2Ufq',NULL,NULL,NULL,NULL,'2026-02-12 21:46:59','2026-02-12 21:46:59',NULL,NULL,NULL,NULL),
(9,'HEGE040302HMSRMFA0','Efrain','Hernández','Gómez','Masculino','2004-03-02','7774441234',NULL,'efrainhdz@gmail.com',NULL,'$2y$12$rXO1u1ZrqfZFOxPQHPEwx.wRNs0NzVvB/UmhI6U2/F4NpOSrEe1K6',NULL,NULL,NULL,NULL,'2026-02-12 21:46:59','2026-02-12 21:46:59',NULL,NULL,NULL,NULL),
(10,'HEGE040302HMRMFA2','Efrain ','Hernández','Gómez','Masculino','2004-03-02','7774441234',NULL,'farmacia@test.com',NULL,'$2y$12$BNGuVmE1gn9t/w6sQEDbB.7DEMlgKNn5tEIh8945rqKrRJCZXQai6',NULL,NULL,NULL,NULL,'2026-02-12 21:46:59','2026-02-12 21:46:59',NULL,NULL,NULL,NULL),
(11,'PESA950615MDFRNS03','Ana María','Pérez','Sánchez','Femenino','1995-06-15','7774441234',NULL,'recepcion@test.com',NULL,'$2y$12$QMK5Og8v167GpbgelPjDeeaNI3TvwbR5r813y1tyMn/DlTFEbY9Bi',NULL,NULL,NULL,NULL,'2026-02-12 21:46:59','2026-02-12 21:46:59',NULL,NULL,NULL,NULL),
(12,'GOLO900101HDFRNS05','Carlos','Gómez','López','Masculino','1990-01-01','7774441234',NULL,'caja@test.com',NULL,'$2y$12$oAwhjcz4RUmwvSafJVlwhO3H0Gx6nIKYwNRqbJvIbzjUnqaFVWeZi',NULL,NULL,NULL,NULL,'2026-02-12 21:46:59','2026-02-12 21:46:59',NULL,NULL,NULL,NULL),
(13,'TORA920515MDFRRN01','Ana','Torres','Ruiz','Femenino','1992-05-15','7774441234',NULL,'tmko220776@upemor.edu.mx',NULL,'$2y$12$gHqCe6s4DOihlFzf95U3XuFxinzbbsDylFQFdEsx5ReVD3jvbSIJm',NULL,NULL,NULL,NULL,'2026-02-12 21:46:59','2026-02-12 21:46:59',NULL,NULL,NULL,NULL),
(14,'AHTJ800101HDFRRN02','Juan Manuel','Ahumada','Trujillo','Masculino','1980-01-01','7771002030',NULL,'juan.ahumada@test.com',NULL,'$2y$12$9QiaEhsPHvTyw6xdNkJ5HO8Z0C23JKhKiKuUgBfmMeLMKG0zRUzzC',NULL,NULL,NULL,NULL,'2026-02-12 21:47:00','2026-02-12 21:47:00',NULL,NULL,NULL,NULL),
(15,'OIEF820520HDFRRN03','Fidel Humberto','Ortiz','Espinoza','Masculino','1982-05-20','7772003040',NULL,'fidel.ortiz@test.com',NULL,'$2y$12$Slco4.sFvY6kuWYzmadQsud5cgRo6xbuMyAHU8Alj/5E2q9DNH26e',NULL,NULL,NULL,NULL,'2026-02-12 21:47:00','2026-02-12 21:47:00',NULL,NULL,NULL,NULL),
(16,'JUTC850815HDFRRN04','Carlos Gabriel','Juarez','Tapia','Masculino','1985-08-15','7773004050',NULL,'carlos.juarez@test.com',NULL,'$2y$12$Ns/jPOvhTpxrwoBKfA/jbeyRTEfLqddkV/.T7vkFWKwEt8MwYSdIu',NULL,NULL,NULL,NULL,'2026-02-12 21:47:00','2026-02-12 21:47:00',NULL,NULL,NULL,NULL),
(17,'MOLX900210MDFRRN05','Luz','Morales','','Femenino','1990-02-10','7774005060',NULL,'luz.morales@test.com',NULL,'$2y$12$3zSCjFr1/SS2im3X04jNeObDDcTYhdj5gaRWK5Gs8nIPVlQna6lOW',NULL,NULL,NULL,NULL,'2026-02-12 21:47:00','2026-02-12 21:47:00',NULL,NULL,NULL,NULL),
(18,'JABA930725MDFRRN06','America','Jaimes','Barcenas','Femenino','1993-07-25','7775006070',NULL,'america.jaimes@test.com',NULL,'$2y$12$iN8wi/P2wbxvl/QVEyGkQ.k3e.ub29xL415HjDuUOpU.9EfdtQgnu',NULL,NULL,NULL,NULL,'2026-02-12 21:47:00','2026-02-12 21:47:00',NULL,NULL,NULL,NULL),
(19,'OILJ951130HDFRRN07','Josué','Ortiz','López','Masculino','1995-11-30','7776007080',NULL,'josue.ortiz@test.com',NULL,'$2y$12$dy7DkJ165J0ohgczy8El6uB1OGHinak0S8R7/dny9PXjYVg0o6GoS',NULL,NULL,NULL,NULL,'2026-02-12 21:47:01','2026-02-12 21:47:01',NULL,NULL,NULL,NULL),
(20,'FORE900101MDFRRN01','Erika','Flores','Rodriguez','Femenino','1990-01-01','7772329969',NULL,'erika.flores@test.com',NULL,'$2y$12$PlFGgaBg5XZCgtAwkjUm5.7a3bt0pF04O/rac1N77UPZNRHrmkqIa',NULL,NULL,NULL,NULL,'2026-02-12 21:47:01','2026-02-12 21:47:01',NULL,NULL,NULL,NULL),
(21,'VARA920202HDFRRN02','Azamar Aaron','Vargas','Radilla','Masculino','1992-02-02','7774608751',NULL,'azamar.vargas@test.com',NULL,'$2y$12$i2ihpO7M81va8cub491gVO5p1lTeuixR/taEKs/VdXyqBbeJDwpZ6',NULL,NULL,NULL,NULL,'2026-02-12 21:47:01','2026-02-12 21:47:01',NULL,NULL,NULL,NULL),
(22,'EABD950303HDFRRN03','Diego Enrique','Erazo','Barreto','Masculino','1995-03-03','7773895596',NULL,'diego.erazo@test.com',NULL,'$2y$12$MDNkCgDHqnIOWQkLqHqnKuyYOxq5P2Pn3grBPJZsylkAjIdKnVlNK',NULL,NULL,NULL,NULL,'2026-02-12 21:47:01','2026-02-12 21:47:01',NULL,NULL,NULL,NULL),
(23,'PEGR880404HDFRRN04','Rodolfo','Pérez','Gutiérrez','Masculino','1988-04-04','7772583877',NULL,'rodolfo.perez@test.com',NULL,'$2y$12$aSEZXBL.d/CmtfgKX1KBhuuJfK1LZrRshD46CQ0fU8lJFlm/UUUnK',NULL,NULL,NULL,NULL,'2026-02-12 21:47:01','2026-02-12 21:47:01',NULL,NULL,NULL,NULL),
(24,'GAGL900101HDFRNS05','Gabriel','Gómez','López','Masculino','1990-01-01','7774441234',NULL,'gabriel@test.com',NULL,'$2y$12$2XcQpsvn5Ciedd2Q3So6HOoMkE0GiK6qUOCPwzNTKgt8sD1btHiyO',NULL,NULL,NULL,NULL,'2026-02-12 21:47:01','2026-02-12 21:47:01',NULL,NULL,NULL,NULL),
(25,'ROMA850512MDFRNS08','Rosa','Martínez','Aguirre','Femenino','1985-05-12','7775556789',NULL,'cocina@test.com',NULL,'$2y$12$PtXcv79KWRdJ50mmamzYI.Hi80B4G9nVoZRXAjbiIishstSRKGQZe',NULL,NULL,NULL,NULL,'2026-02-12 21:47:02','2026-02-12 21:47:02',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `valoracion_dolors`
--

DROP TABLE IF EXISTS `valoracion_dolors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `valoracion_dolors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `escala_eva` int(11) NOT NULL,
  `ubicacion_dolor` varchar(255) DEFAULT NULL,
  `hoja_escala_valoracion_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `valoracion_dolors_hoja_escala_valoracion_id_foreign` (`hoja_escala_valoracion_id`),
  CONSTRAINT `valoracion_dolors_hoja_escala_valoracion_id_foreign` FOREIGN KEY (`hoja_escala_valoracion_id`) REFERENCES `hoja_escala_valoracions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valoracion_dolors`
--

LOCK TABLES `valoracion_dolors` WRITE;
/*!40000 ALTER TABLE `valoracion_dolors` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `valoracion_dolors` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `descuento` decimal(8,2) DEFAULT NULL,
  `estado` varchar(255) NOT NULL,
  `total_pagado` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estancia_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ventas_estancia_id_foreign` (`estancia_id`),
  KEY `ventas_user_id_foreign` (`user_id`),
  CONSTRAINT `ventas_estancia_id_foreign` FOREIGN KEY (`estancia_id`) REFERENCES `estancias` (`id`) ON DELETE SET NULL,
  CONSTRAINT `ventas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-02-12 15:48:35
