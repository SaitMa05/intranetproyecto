-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: vps-4445190-x.dattaweb.com    Database: c2650896_asisten
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fechaEliminacion` datetime DEFAULT NULL,
  `creadoPor` varchar(60) NOT NULL,
  `modificadoPor` varchar(60) DEFAULT NULL,
  `elimandoPor` varchar(60) DEFAULT NULL,
  `fkCursos` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_alumnos_cursos1_idx` (`fkCursos`),
  CONSTRAINT `fk_alumnos_cursos1` FOREIGN KEY (`fkCursos`) REFERENCES `cursos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asistencia`
--

DROP TABLE IF EXISTS `asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asistencia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `asistencia` int NOT NULL,
  `fkUsuario` int NOT NULL,
  `fkAlumnos` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaEliminacion` datetime DEFAULT NULL,
  `detalles` longtext,
  `tardanza` int DEFAULT NULL,
  `media` int DEFAULT NULL,
  `cuarto` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_asistencia_usuarios1_idx` (`fkUsuario`),
  KEY `fk_asistencia_alumnos1_idx` (`fkAlumnos`),
  CONSTRAINT `fk_asistencia_alumnos1` FOREIGN KEY (`fkAlumnos`) REFERENCES `alumnos` (`id`),
  CONSTRAINT `fk_asistencia_usuarios1` FOREIGN KEY (`fkUsuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asistencia`
--

LOCK TABLES `asistencia` WRITE;
/*!40000 ALTER TABLE `asistencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `asistencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cursos`
--

DROP TABLE IF EXISTS `cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cursos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year` varchar(10) NOT NULL,
  `division` varchar(10) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fechaEliminacion` datetime DEFAULT NULL,
  `creadoPor` varchar(60) NOT NULL,
  `modificadoPor` varchar(60) DEFAULT NULL,
  `eliminadoPor` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cursos`
--

LOCK TABLES `cursos` WRITE;
/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expoAsistentes`
--

DROP TABLE IF EXISTS `expoAsistentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expoAsistentes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `edad` int NOT NULL,
  `fecha` datetime NOT NULL,
  `escuela` varchar(100) DEFAULT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `info` longtext,
  `fkUsuario` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_expoAsistentes_usuarios` (`fkUsuario`),
  CONSTRAINT `fk_expoAsistentes_usuarios` FOREIGN KEY (`fkUsuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=359 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expoAsistentes`
--

LOCK TABLES `expoAsistentes` WRITE;
/*!40000 ALTER TABLE `expoAsistentes` DISABLE KEYS */;
/*!40000 ALTER TABLE `expoAsistentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expoCompania`
--

DROP TABLE IF EXISTS `expoCompania`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expoCompania` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_asistente` int DEFAULT NULL,
  `nombreCompleto` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_asistente` (`id_asistente`),
  CONSTRAINT `expoCompania_ibfk_1` FOREIGN KEY (`id_asistente`) REFERENCES `expoAsistentes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expoCompania`
--

LOCK TABLES `expoCompania` WRITE;
/*!40000 ALTER TABLE `expoCompania` DISABLE KEYS */;
/*!40000 ALTER TABLE `expoCompania` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimientopuerta`
--

DROP TABLE IF EXISTS `movimientopuerta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movimientopuerta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fkUsuario` int NOT NULL,
  `fkPuertas` int NOT NULL,
  `fechaApertura` datetime NOT NULL,
  PRIMARY KEY (`id`,`fkUsuario`,`fkPuertas`),
  KEY `fk_usuarios_has_puertas_puertas1_idx` (`fkPuertas`),
  KEY `fk_usuarios_has_puertas_usuarios1_idx` (`fkUsuario`),
  CONSTRAINT `fk_usuarios_has_puertas_puertas1` FOREIGN KEY (`fkPuertas`) REFERENCES `puertas` (`id`),
  CONSTRAINT `fk_usuarios_has_puertas_usuarios1` FOREIGN KEY (`fkUsuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=399 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimientopuerta`
--

LOCK TABLES `movimientopuerta` WRITE;
/*!40000 ALTER TABLE `movimientopuerta` DISABLE KEYS */;
/*!40000 ALTER TABLE `movimientopuerta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puertas`
--

DROP TABLE IF EXISTS `puertas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `puertas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `descripcion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `fechaCreacion` datetime NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fechaEliminacion` datetime DEFAULT NULL,
  `creadoPor` varchar(60) NOT NULL,
  `modificadoPor` varchar(60) DEFAULT NULL,
  `eliminadoPor` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puertas`
--

LOCK TABLES `puertas` WRITE;
/*!40000 ALTER TABLE `puertas` DISABLE KEYS */;
/*!40000 ALTER TABLE `puertas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fechaEliminacion` datetime DEFAULT NULL,
  `creadoPor` varchar(60) NOT NULL,
  `modificadoPor` varchar(60) DEFAULT NULL,
  `eliminadoPor` varchar(60) DEFAULT NULL,
  `aceptadoPor` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (2,'ROOT','ROOT','ROOT','2024-10-13 18:12:13',NULL,NULL,'Mati',NULL,NULL,'ROOT');
INSERT INTO `rol` VALUES (3,'Profesor','Profesor','Profesor','2024-10-15 13:41:08',NULL,'2024-11-20 14:19:42','ROOT',NULL,NULL,NULL);
INSERT INTO `rol` VALUES (4,'TEMPORAL','TEMPORAL','Usuarios Temporales','2024-11-12 11:35:00',NULL,NULL,'ROOT',NULL,NULL,'ROOT');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `nombreUsuario` varchar(60) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `aceptado` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fechaEliminacion` datetime DEFAULT NULL,
  `creadoPor` varchar(60) NOT NULL,
  `modificadoPor` varchar(60) DEFAULT NULL,
  `eliminadoPor` varchar(60) DEFAULT NULL,
  `aceptadoPor` varchar(60) DEFAULT NULL,
  `fkRol` int NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `token_expiracion` datetime DEFAULT NULL,
  `dni1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dni2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dni3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuarios_rol_idx` (`fkRol`),
  CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`fkRol`) REFERENCES `rol` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'c2650896_asisten'
--

--
-- Dumping routines for database 'c2650896_asisten'
--
/*!50003 DROP PROCEDURE IF EXISTS `asistencias_persistir` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `asistencias_persistir`(
	IN varAsistencia INT,
	IN varFkUsuario INT,
	IN varFkAlumnos INT,
	IN varDetalles LONGTEXT,
	IN varTardanza INT,
	IN varMedia INT,
	IN varCuarto INT
)
BEGIN
	-- Si no existe, insertamos un nuevo registro
	INSERT INTO asistencia (fecha, asistencia, fkUsuario, fkAlumnos, fechaCreacion, fechaEliminacion, detalles, tardanza, media, cuarto)
	VALUES ( now(), varAsistencia, varFkUsuario, varFkAlumnos, now(), null, varDetalles, varTardanza, varMedia, varCuarto);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `expoAsistentes_persistir` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expoAsistentes_persistir`(
	IN varId INT,
	IN varNombre VARCHAR(60),
	IN varApellido VARCHAR(60),
	IN varEmail VARCHAR(255),
	IN varEdad INT,
	IN varEscuela VARCHAR(100),
	IN varEmpresa VARCHAR(100),
	IN varCantidad INT,
	IN varInfo LONGTEXT,
	IN varFkUsuario INT
	
)
BEGIN
	IF varId IS NULL OR varId = 0 THEN
        -- Insertar nuevo registro
        INSERT INTO expoAsistentes
        (
        	nombre,
        	apellido,
        	email,
        	edad,
        	fecha,
        	escuela,
        	empresa,
        	cantidad,
        	info,
        	fkUsuario
        )
        VALUES
        (	
        	varNombre,
        	varApellido,
        	varEmail,
        	varEdad,
        	now(),
        	varEscuela,
        	varEmpresa,
        	varCantidad,
        	varInfo,
        	varFkUsuario
        );
        -- Devolver el nuevo registro insertado
        SELECT * FROM expoAsistentes WHERE id = LAST_INSERT_ID();
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `expoCompania_persistir` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expoCompania_persistir`(
	IN varId INT,
	IN varIdAsistentes INT,
	IN varNombre VARCHAR(60)
)
BEGIN
	IF varId IS NULL OR varId = 0 THEN
        -- Insertar nuevo registro
        INSERT INTO expoCompania
        (
        	id_asistente,
        	nombreCompleto
        )
        VALUES
        (	
        	varIdAsistentes,
        	varNombre
        );
        -- Devolver el nuevo registro insertado
        SELECT * FROM expoCompania WHERE id = LAST_INSERT_ID();
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `expo_obtenerEdad` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_obtenerEdad`()
BEGIN
SELECT 
        CASE 
            WHEN edad BETWEEN 0 AND 2 THEN '0-2'
            WHEN edad BETWEEN 3 AND 5 THEN '3-5'
            WHEN edad BETWEEN 6 AND 9 THEN '6-9'
            WHEN edad BETWEEN 10 AND 15 THEN '10-15'
            WHEN edad BETWEEN 16 AND 20 THEN '16-20'
            WHEN edad BETWEEN 21 AND 25 THEN '21-25'
            WHEN edad BETWEEN 26 AND 30 THEN '26-30'
            WHEN edad BETWEEN 31 AND 35 THEN '31-35'
            WHEN edad BETWEEN 36 AND 40 THEN '36-40'
            WHEN edad BETWEEN 41 AND 45 THEN '41-45'
            WHEN edad BETWEEN 46 AND 50 THEN '46-50'
            WHEN edad BETWEEN 51 AND 55 THEN '51-55'
            WHEN edad BETWEEN 56 AND 60 THEN '56-60'
            WHEN edad BETWEEN 61 AND 65 THEN '61-65'
            WHEN edad BETWEEN 66 AND 70 THEN '66-70'
            WHEN edad BETWEEN 71 AND 75 THEN '71-75'
            WHEN edad BETWEEN 76 AND 80 THEN '76-80'
            WHEN edad BETWEEN 81 AND 85 THEN '81-85'
            WHEN edad BETWEEN 86 AND 90 THEN '86-90'
            WHEN edad BETWEEN 91 AND 95 THEN '91-95'
            WHEN edad BETWEEN 96 AND 100 THEN '96-100'
            ELSE 'mayores_100'
        END AS rangoEdad,
        COUNT(*) AS totalPersonas
    FROM expoAsistentes
    GROUP BY rangoEdad
    ORDER BY rangoEdad;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `expo_obtenerEmpresas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_obtenerEmpresas`()
BEGIN
	SELECT ea.empresa, ea.nombre, ea.apellido, ea.email, ea.edad, ea.fecha, ea.cantidad, ea.info, CONCAT(u.nombre, " ", u.apellido) as nombreUsuario
	FROM expoAsistentes ea
	LEFT JOIN usuarios u ON u.id = ea.fkUsuario
	WHERE ea.empresa IS NOT NULL AND ea.escuela IS NULL
	ORDER BY ea.fecha DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `expo_obtenerEscuelas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_obtenerEscuelas`()
BEGIN
	SELECT ea.escuela, ea.nombre, ea.apellido, ea.email, ea.edad, ea.fecha, ea.cantidad, ea.info, CONCAT(u.nombre, " ", u.apellido) as nombreUsuario 
	FROM expoAsistentes ea 
	LEFT JOIN usuarios u ON u.id = ea.fkUsuario
	WHERE ea.empresa IS NULL AND ea.escuela IS NOT NULL
	ORDER BY ea.fecha DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `expo_obtenerPersonas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_obtenerPersonas`()
BEGIN
	SELECT ea.nombre, ea.apellido, ea.email, ea.edad, ea.fecha, COUNT(ec.id) AS compania, CONCAT(u.nombre, " ", u.apellido) as nombreUsuario
	FROM expoAsistentes ea  
	LEFT JOIN expoCompania ec ON ec.id_asistente = ea.id  
	LEFT JOIN usuarios u ON u.id = ea.fkUsuario
	WHERE ea.empresa IS NULL AND ea.escuela IS NULL
	GROUP BY ea.nombre, ea.apellido, ea.email, ea.edad, ea.fecha, u.nombre ORDER BY ea.fecha DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `expo_obtenerTiposPersonas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_obtenerTiposPersonas`()
BEGIN
-- Total de Personas (sin empresa ni escuela, incluyendo acompañantes)
SELECT 
    'personas' AS tipo, 
    SUM(sub.total_personas_con_acompanantes) AS total
FROM (
    SELECT 
        p.id, 
        COUNT(a.id_asistente) + 1 AS total_personas_con_acompanantes -- Persona principal + acompañantes
    FROM expoAsistentes p
    LEFT JOIN expoCompania a ON p.id = a.id_asistente
    WHERE p.empresa IS NULL AND p.escuela IS NULL
    GROUP BY p.id
) sub

UNION ALL

-- Total por Empresa (persona principal + cantidad asociada)
SELECT 
    'empresa' AS tipo, 
    COALESCE(SUM(p.cantidad + 1), 0) AS total
FROM expoAsistentes p
WHERE p.empresa IS NOT NULL

UNION ALL

-- Total por Escuela (persona principal + cantidad asociada)
SELECT 
    'escuela' AS tipo, 
    COALESCE(SUM(p.cantidad + 1), 0) AS total
FROM expoAsistentes p
WHERE p.escuela IS NOT NULL

UNION ALL

-- Total General de todas las personas
SELECT 
    'total_general' AS tipo, 
    SUM(t.total) AS total
FROM (
    -- Subconsulta para combinar totales de Personas, Empresa y Escuela
    SELECT 
        SUM(sub.total_personas_con_acompanantes) AS total
    FROM (
        SELECT 
            p.id, 
            COUNT(a.id_asistente) + 1 AS total_personas_con_acompanantes
        FROM expoAsistentes p
        LEFT JOIN expoCompania a ON p.id = a.id_asistente
        WHERE p.empresa IS NULL AND p.escuela IS NULL
        GROUP BY p.id
    ) sub
    UNION ALL
    SELECT 
        COALESCE(SUM(p.cantidad + 1), 0) AS total
    FROM expoAsistentes p
    WHERE p.empresa IS NOT NULL
    UNION ALL
    SELECT 
        COALESCE(SUM(p.cantidad + 1), 0) AS total
    FROM expoAsistentes p
    WHERE p.escuela IS NOT NULL
) t;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `expo_obtenerTodasEdades` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_obtenerTodasEdades`()
BEGIN
	SELECT edad, COUNT(*) AS totalPersonas
	FROM expoAsistentes
	GROUP BY edad
	ORDER BY edad;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `expo_personasSolas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_personasSolas`()
BEGIN
SELECT 
    -- Personas solas (sin registros en expoCompania y cantidad = 0 o NULL)
    COUNT(DISTINCT p.id) AS personasSolasData,
    
    -- Personas con acompañantes o con cantidad > 0
    (
        SELECT COUNT(DISTINCT p2.id)
        FROM expoAsistentes p2
        LEFT JOIN expoCompania ec2 ON p2.id = ec2.id_asistente
        WHERE ec2.id_asistente IS NOT NULL OR p2.cantidad > 0
    ) AS personasConAcompanantes
FROM expoAsistentes p
LEFT JOIN expoCompania ec ON p.id = ec.id_asistente
WHERE ec.id_asistente IS NULL AND (p.cantidad = 0 OR p.cantidad IS NULL);


END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `expo_registroPorHora` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_registroPorHora`()
BEGIN
SELECT 
    DATE_FORMAT(p.fecha, '%Y-%m-%d %H:00:00') AS hora, 
    SUM(
        CASE 
            WHEN p.empresa IS NULL AND p.escuela IS NULL THEN (1 + IFNULL(ac.total_acompanantes, 0))
            ELSE (1 + p.cantidad)
        END
    ) AS totalPersonas
FROM expoAsistentes p
LEFT JOIN (
    SELECT id_asistente, COUNT(*) AS total_acompanantes
    FROM expoCompania
    GROUP BY id_asistente
) ac ON p.id = ac.id_asistente
GROUP BY hora
ORDER BY hora;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `movimiento_obtener` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `movimiento_obtener`()
BEGIN
	SELECT u.nombre as nombreUsuario, u.apellido as apellidoUsuario, p.nombre as nombrePuerta, m.fechaApertura FROM movimientopuerta m
	INNER JOIN puertas p ON p.id = m.fkPuertas
	INNER JOIN usuarios u ON u.id = m.fkUsuario ORDER BY fechaApertura DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `movimiento_persistir` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `movimiento_persistir`(
	IN varFkUsuario INT,
	IN varFkPuerta INT
)
BEGIN
	INSERT INTO movimientopuerta (fkUsuario, fkPuertas, fechaApertura) VALUES (varFkUsuario, varFkPuerta, now());
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtener_alumnosPorCurso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `obtener_alumnosPorCurso`(
    IN varFkCurso INT
)
BEGIN
    SELECT * FROM alumnos WHERE fkCursos = varFkCurso;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtener_cursos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `obtener_cursos`()
BEGIN
	SELECT * FROM cursos;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtener_rolPorId` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `obtener_rolPorId`(
	IN varFkRol INT
)
BEGIN
    SELECT nombre FROM rol WHERE id = varFkRol;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `obtener_tokenPuertas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `obtener_tokenPuertas`(
	IN varFkPuertas INT
)
BEGIN
	SELECT token from puertas where id = varFkPuertas;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `puertas_eliminar` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `puertas_eliminar`(
	IN varId INT,
	IN varUsuario VARCHAR(60)
)
BEGIN
	UPDATE puertas SET fechaEliminacion = now(), eliminadoPor = varUsuario where id = varId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

-- insufficient privileges to SHOW CREATE PROCEDURE `puertas_obtener`
-- does c2650896_asisten have permissions on mysql.proc?

