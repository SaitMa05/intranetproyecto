-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 26, 2024 at 02:52 PM
-- Server version: 8.0.40
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `c2650896_asisten`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `asistencias_persistir` (IN `varAsistencia` INT, IN `varFkUsuario` INT, IN `varFkAlumnos` INT, IN `varDetalles` LONGTEXT, IN `varTardanza` INT, IN `varMedia` INT, IN `varCuarto` INT)   BEGIN

	-- Si no existe, insertamos un nuevo registro

	INSERT INTO asistencia (fecha, asistencia, fkUsuario, fkAlumnos, fechaCreacion, fechaEliminacion, detalles, tardanza, media, cuarto)

	VALUES ( now(), varAsistencia, varFkUsuario, varFkAlumnos, now(), null, varDetalles, varTardanza, varMedia, varCuarto);

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expoAsistentes_persistir` (IN `varId` INT, IN `varNombre` VARCHAR(60), IN `varApellido` VARCHAR(60), IN `varEmail` VARCHAR(255), IN `varEdad` INT, IN `varEscuela` VARCHAR(100), IN `varEmpresa` VARCHAR(100), IN `varCantidad` INT, IN `varInfo` LONGTEXT, IN `varFkUsuario` INT)   BEGIN

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

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expoCompania_persistir` (IN `varId` INT, IN `varIdAsistentes` INT, IN `varNombre` VARCHAR(60))   BEGIN

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

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_obtenerEdad` ()   BEGIN

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

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_obtenerEmpresas` ()   BEGIN

	SELECT ea.empresa, ea.nombre, ea.apellido, ea.email, ea.edad, ea.fecha, ea.cantidad, ea.info, CONCAT(u.nombre, " ", u.apellido) as nombreUsuario

	FROM expoAsistentes ea
	LEFT JOIN usuarios u ON u.id = ea.fkUsuario

	WHERE ea.empresa IS NOT NULL AND ea.escuela IS NULL

	ORDER BY ea.fecha DESC;

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_obtenerEscuelas` ()   BEGIN

	SELECT ea.escuela, ea.nombre, ea.apellido, ea.email, ea.edad, ea.fecha, ea.cantidad, ea.info, CONCAT(u.nombre, " ", u.apellido) as nombreUsuario 

	FROM expoAsistentes ea 
	LEFT JOIN usuarios u ON u.id = ea.fkUsuario

	WHERE ea.empresa IS NULL AND ea.escuela IS NOT NULL

	ORDER BY ea.fecha DESC;

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_obtenerPersonas` ()   BEGIN

	SELECT ea.nombre, ea.apellido, ea.email, ea.edad, ea.fecha, COUNT(ec.id) AS compania, CONCAT(u.nombre, " ", u.apellido) as nombreUsuario

	FROM expoAsistentes ea  

	LEFT JOIN expoCompania ec ON ec.id_asistente = ea.id  
	LEFT JOIN usuarios u ON u.id = ea.fkUsuario

	WHERE ea.empresa IS NULL AND ea.escuela IS NULL

	GROUP BY ea.nombre, ea.apellido, ea.email, ea.edad, ea.fecha, u.nombre ORDER BY ea.fecha DESC;

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_obtenerTiposPersonas` ()   BEGIN

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



END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_obtenerTodasEdades` ()   BEGIN

	SELECT edad, COUNT(*) AS totalPersonas

	FROM expoAsistentes

	GROUP BY edad

	ORDER BY edad;

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_personasSolas` ()   BEGIN

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





END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `expo_registroPorHora` ()   BEGIN

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

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `movimiento_obtener` ()   BEGIN

	SELECT u.nombre as nombreUsuario, u.apellido as apellidoUsuario, p.nombre as nombrePuerta, m.fechaApertura FROM movimientopuerta m

	INNER JOIN puertas p ON p.id = m.fkPuertas

	INNER JOIN usuarios u ON u.id = m.fkUsuario ORDER BY fechaApertura DESC;

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `movimiento_persistir` (IN `varFkUsuario` INT, IN `varFkPuerta` INT)   BEGIN

	INSERT INTO movimientopuerta (fkUsuario, fkPuertas, fechaApertura) VALUES (varFkUsuario, varFkPuerta, now());

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `obtener_alumnosPorCurso` (IN `varFkCurso` INT)   BEGIN

    SELECT * FROM alumnos WHERE fkCursos = varFkCurso;

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `obtener_cursos` ()   BEGIN

	SELECT * FROM cursos;

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `obtener_rolPorId` (IN `varFkRol` INT)   BEGIN

    SELECT nombre FROM rol WHERE id = varFkRol;

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `obtener_tokenPuertas` (IN `varFkPuertas` INT)   BEGIN

	SELECT token from puertas where id = varFkPuertas;



END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `puertas_eliminar` (IN `varId` INT, IN `varUsuario` VARCHAR(60))   BEGIN

	UPDATE puertas SET fechaEliminacion = now(), eliminadoPor = varUsuario where id = varId;

END$$

CREATE DEFINER=`c2650896`@`localhost` PROCEDURE `puertas_obtener` ()   begin

        SELECT * FROM puertas
        WHERE fechaEliminacion IS NULL
        ORDER BY nombre ASC;
END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `puertas_persistir` (IN `varId` INT, IN `varNombre` VARCHAR(60), IN `varDescripcion` LONGTEXT, IN `varCreadoPor` VARCHAR(60), IN `varModificadoPor` VARCHAR(60))   BEGIN
	  IF varId IS NULL OR varId = 0 THEN
        -- Insertar nuevo registro
        INSERT INTO puertas
        (
        	nombre,
        	descripcion,
        	fechaCreacion,
        	fechaModificacion,
        	fechaEliminacion,
        	creadoPor,
        	modificadoPor,
        	eliminadoPor
        )
        VALUES
        (	
        	varNombre,
        	varDescripcion,
        	now(),
        	NULL,
        	NULL,
        	varCreadoPor,
        	NULL,
        	NULL
        );
        -- Devolver el nuevo registro insertado
        SELECT * FROM puertas WHERE id = LAST_INSERT_ID();
    ELSE
        -- Actualizar un registro existente
        UPDATE puertas
        SET
            nombre = varNombre,
            descripcion = varDescripcion,
            fechaModificacion = NOW(),
            modificadoPor = varModificadoPor
        WHERE id = varId;
        
        -- Devolver el registro actualizado
        SELECT * FROM puertas WHERE id = varId;
    END IF;
END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `rols_obtener` ()   BEGIN
	SELECT * FROM rol where fechaEliminacion is null;
END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `usuario_aceptar` (IN `varId` INT, IN `varUsuario` VARCHAR(60))   BEGIN
	UPDATE usuarios SET aceptado = 1, aceptadoPor = varUsuario where id = varId;
END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `usuario_actualizarPassword` (IN `varId` INT, IN `varPassword` CHAR(60))   BEGIN
	UPDATE usuarios SET password = varPassword, token = NULL, token_expiracion = NULL WHERE id = varId;
END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `usuario_agregarToken` (IN `varEmail` VARCHAR(255), IN `varToken` VARCHAR(100))   BEGIN
	UPDATE usuarios SET token = varToken, token_expiracion = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = varEmail;
END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `usuario_eliminar` (IN `varId` INT, IN `varUsuario` VARCHAR(60))   BEGIN
	UPDATE usuarios SET fechaEliminacion = now(), eliminadoPor = varUsuario where id = varId;
END$$

CREATE DEFINER=`c2650896`@`localhost` PROCEDURE `usuario_obtener` ()   begin

	

	select * from usuarios where fechaEliminacion is null order by id;

	

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `usuario_obtenerNoAceptados` ()   BEGIN
	SELECT usuarios.*, r.nombre as nombreRol
	FROM usuarios
	INNER JOIN rol r ON usuarios.fkRol = r.id
	WHERE usuarios.aceptado = 0 AND usuarios.fechaEliminacion IS NULL;
END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `usuario_obtenerPorEmail` (IN `varEmail` VARCHAR(255))   BEGIN
	SELECT email 
    FROM usuarios
    WHERE aceptado = 1 and email = varEmail and fechaEliminacion is null limit 1;
END$$

CREATE DEFINER=`c2650896`@`localhost` PROCEDURE `usuario_obtenerPorLogin` (IN `inputUsuario` VARCHAR(255))   begin
    SELECT * -- agrega los campos necesarios
    FROM usuarios
    WHERE aceptado = 1 and nombreUsuario = inputUsuario and fechaEliminacion is null OR email = inputUsuario and fechaEliminacion is null limit 1;
END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `usuario_obtenerTodos` ()   BEGIN
	SELECT usuarios.*, r.nombre as nombreRol
	FROM usuarios
	INNER JOIN rol r ON usuarios.fkRol = r.id
	WHERE usuarios.aceptado = 1 AND usuarios.fechaEliminacion IS NULL;
END$$

CREATE DEFINER=`c2650896`@`localhost` PROCEDURE `usuario_persistir` (IN `varId` INT, IN `varNombre` VARCHAR(60), IN `varApellido` VARCHAR(60), IN `varNombreUsuario` VARCHAR(60), IN `varDni` VARCHAR(60), IN `varTelefono` VARCHAR(100), IN `varEmail` VARCHAR(255), IN `varPassword` CHAR(60), IN `varAceptado` INT(1), IN `varFechaModificacion` DATETIME, IN `varCreadoPor` VARCHAR(60), IN `varModificadoPor` VARCHAR(60), IN `varAceptadoPor` VARCHAR(60), IN `varFkRol` INT, IN `varDni1` VARCHAR(255), IN `varDni2` VARCHAR(255), IN `varDni3` VARCHAR(255))   BEGIN
    IF varId IS NULL OR varId = 0 THEN
        -- Insertar nuevo registro
        INSERT INTO usuarios
        (
            nombre,
            apellido,
            nombreUsuario,
            dni,
            telefono,
            email,
            password,
            aceptado,
            fechaCreacion,
            fechaModificacion,
            creadoPor,
            modificadoPor,
            aceptadoPor,
            fkRol,
            dni1,
            dni2,
            dni3
        )
        VALUES
        (
            varNombre,
            varApellido,
            varNombreUsuario,
            varDni,
            varTelefono,
            varEmail,
            varPassword,
			0,
            NOW(),
            NULL,
            varCreadoPor,
            NULL,
            NULL,
            varFkRol,
            varDni1,
            varDni2,
            varDni3
        );
        -- Devolver el nuevo registro insertado
        SELECT * FROM usuarios WHERE id = LAST_INSERT_ID();
    ELSE
        -- Actualizar un registro existente
        UPDATE usuarios
        set
            nombre = varNombre,
            apellido = varApellido,
            nombreUsuario = varNombreUsuario,
            dni = varDni,
            telefono = varTelefono,
            email = varEmail,
            fechaModificacion = NOW(),
            modificadoPor = varModificadoPor
        WHERE id = varId;
        
        -- Devolver el registro actualizado
        SELECT * FROM usuarios WHERE id = varId;
    END IF;
END$$

CREATE DEFINER=`c2650896`@`localhost` PROCEDURE `usuario_verificarRegistro` (IN `varNombreUsuario` VARCHAR(100), IN `varDni` VARCHAR(10), IN `varTelefono` VARCHAR(100), IN `varEmail` VARCHAR(255))   BEGIN

	SELECT * 
	FROM usuarios 
	WHERE ( (nombreUsuario = varNombreUsuario OR varNombreUsuario IS NULL) 
		AND fechaEliminacion IS NULL )
	OR ( (dni = varDni OR varDni IS NULL) 
		AND fechaEliminacion IS NULL )
	OR ( (telefono = varTelefono OR varTelefono IS NULL) 
		AND fechaEliminacion IS NULL )
	OR ( (email = varEmail OR varEmail IS NULL) 
		AND fechaEliminacion IS NULL );

END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `usuario_verificarRegistroAdmin` (IN `varId` INT, IN `varNombreUsuario` VARCHAR(60), IN `varDni` VARCHAR(10), IN `varTelefono` VARCHAR(100), IN `varEmail` VARCHAR(255))   BEGIN
	SELECT * 
	FROM usuarios 
	WHERE id != varId
	  AND (
	    ( (nombreUsuario = varNombreUsuario OR varNombreUsuario IS NULL) 
	      AND fechaEliminacion IS NULL )
	    OR 
	    ( (dni = varDni OR varDni IS NULL) 
	      AND fechaEliminacion IS NULL )
	    OR 
	    ( (telefono = varTelefono OR varTelefono IS NULL) 
	      AND fechaEliminacion IS NULL )
	    OR 
	    ( (email = varEmail OR varEmail IS NULL) 
	      AND fechaEliminacion IS NULL )
	  );
END$$

CREATE DEFINER=`c2650896_asisten`@`%` PROCEDURE `usuario_verificarToken` (IN `varToken` VARCHAR(100))   BEGIN
	SELECT * FROM usuarios WHERE token = varToken AND token_expiracion > NOW() LIMIT 1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int NOT NULL,
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
  `fkCursos` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asistencia`
--

CREATE TABLE `asistencia` (
  `id` int NOT NULL,
  `fecha` datetime NOT NULL,
  `asistencia` int NOT NULL,
  `fkUsuario` int NOT NULL,
  `fkAlumnos` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaEliminacion` datetime DEFAULT NULL,
  `detalles` longtext,
  `tardanza` int DEFAULT NULL,
  `media` int DEFAULT NULL,
  `cuarto` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cursos`
--

CREATE TABLE `cursos` (
  `id` int NOT NULL,
  `year` varchar(10) NOT NULL,
  `division` varchar(10) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fechaEliminacion` datetime DEFAULT NULL,
  `creadoPor` varchar(60) NOT NULL,
  `modificadoPor` varchar(60) DEFAULT NULL,
  `eliminadoPor` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expoAsistentes`
--

CREATE TABLE `expoAsistentes` (
  `id` int NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `edad` int NOT NULL,
  `fecha` datetime NOT NULL,
  `escuela` varchar(100) DEFAULT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `info` longtext,
  `fkUsuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `expoCompania`
--

CREATE TABLE `expoCompania` (
  `id` int NOT NULL,
  `id_asistente` int DEFAULT NULL,
  `nombreCompleto` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `movimientopuerta`
--

CREATE TABLE `movimientopuerta` (
  `id` int NOT NULL,
  `fkUsuario` int NOT NULL,
  `fkPuertas` int NOT NULL,
  `fechaApertura` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `puertas`
--

CREATE TABLE `puertas` (
  `id` int NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `descripcion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `fechaCreacion` datetime NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fechaEliminacion` datetime DEFAULT NULL,
  `creadoPor` varchar(60) NOT NULL,
  `modificadoPor` varchar(60) DEFAULT NULL,
  `eliminadoPor` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fechaEliminacion` datetime DEFAULT NULL,
  `creadoPor` varchar(60) NOT NULL,
  `modificadoPor` varchar(60) DEFAULT NULL,
  `eliminadoPor` varchar(60) DEFAULT NULL,
  `aceptadoPor` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `titulo`, `descripcion`, `fechaCreacion`, `fechaModificacion`, `fechaEliminacion`, `creadoPor`, `modificadoPor`, `eliminadoPor`, `aceptadoPor`) VALUES
(2, 'ROOT', 'ROOT', 'ROOT', '2024-10-13 18:12:13', NULL, NULL, 'Mati', NULL, NULL, 'ROOT'),
(3, 'Profesor', 'Profesor', 'Profesor', '2024-10-15 13:41:08', NULL, '2024-11-20 14:19:42', 'ROOT', NULL, NULL, NULL),
(4, 'TEMPORAL', 'TEMPORAL', 'Usuarios Temporales', '2024-11-12 11:35:00', NULL, NULL, 'ROOT', NULL, NULL, 'ROOT');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
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
  `dni3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `nombreUsuario`, `dni`, `telefono`, `email`, `password`, `aceptado`, `fechaCreacion`, `fechaModificacion`, `fechaEliminacion`, `creadoPor`, `modificadoPor`, `eliminadoPor`, `aceptadoPor`, `fkRol`, `token`, `token_expiracion`, `dni1`, `dni2`, `dni3`) VALUES
(42, 'Prueba', 'Prueba', 'MEM', '00000000', '00000000', '@gmail.com', '$2y$10$T0E1BXjkArHwa3H0PulhN.lE3KEmtGohb2z7xKnadn/jO80FgEEO6', 1, '2024-11-21 23:50:30', '2024-11-22 00:07:37', NULL, 'noc', '', '', NULL, 2, NULL, NULL, 'No hay imagen. Creado en Admin', 'No hay imagen. Creado en Admin', 'No hay imagen. Creado en Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_alumnos_cursos1_idx` (`fkCursos`);

--
-- Indexes for table `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_asistencia_usuarios1_idx` (`fkUsuario`),
  ADD KEY `fk_asistencia_alumnos1_idx` (`fkAlumnos`);

--
-- Indexes for table `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expoAsistentes`
--
ALTER TABLE `expoAsistentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_expoAsistentes_usuarios` (`fkUsuario`);

--
-- Indexes for table `expoCompania`
--
ALTER TABLE `expoCompania`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_asistente` (`id_asistente`);

--
-- Indexes for table `movimientopuerta`
--
ALTER TABLE `movimientopuerta`
  ADD PRIMARY KEY (`id`,`fkUsuario`,`fkPuertas`),
  ADD KEY `fk_usuarios_has_puertas_puertas1_idx` (`fkPuertas`),
  ADD KEY `fk_usuarios_has_puertas_usuarios1_idx` (`fkUsuario`);

--
-- Indexes for table `puertas`
--
ALTER TABLE `puertas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuarios_rol_idx` (`fkRol`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `expoAsistentes`
--
ALTER TABLE `expoAsistentes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=358;

--
-- AUTO_INCREMENT for table `expoCompania`
--
ALTER TABLE `expoCompania`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `movimientopuerta`
--
ALTER TABLE `movimientopuerta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `puertas`
--
ALTER TABLE `puertas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `fk_alumnos_cursos1` FOREIGN KEY (`fkCursos`) REFERENCES `cursos` (`id`);

--
-- Constraints for table `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `fk_asistencia_alumnos1` FOREIGN KEY (`fkAlumnos`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `fk_asistencia_usuarios1` FOREIGN KEY (`fkUsuario`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `expoAsistentes`
--
ALTER TABLE `expoAsistentes`
  ADD CONSTRAINT `fk_expoAsistentes_usuarios` FOREIGN KEY (`fkUsuario`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `expoCompania`
--
ALTER TABLE `expoCompania`
  ADD CONSTRAINT `expoCompania_ibfk_1` FOREIGN KEY (`id_asistente`) REFERENCES `expoAsistentes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movimientopuerta`
--
ALTER TABLE `movimientopuerta`
  ADD CONSTRAINT `fk_usuarios_has_puertas_puertas1` FOREIGN KEY (`fkPuertas`) REFERENCES `puertas` (`id`),
  ADD CONSTRAINT `fk_usuarios_has_puertas_usuarios1` FOREIGN KEY (`fkUsuario`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`fkRol`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
