-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20241219.8e721911f0
-- https://www.phpmyadmin.net/
--
-- Servidor: 192.168.30.23
-- Tiempo de generación: 05-11-2025 a las 21:43:21
-- Versión del servidor: 8.0.18
-- Versión de PHP: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ClinicaInternacional`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`192.168.30.%` PROCEDURE `sp_actualizarTratamiento` (IN `p_id_historia` INT, IN `p_nuevo_tratamiento` TEXT)   BEGIN
    UPDATE Historias_Clinicas
    SET tratamiento = p_nuevo_tratamiento
    WHERE id_historia = p_id_historia;
END$$

CREATE DEFINER=`root`@`192.168.30.%` PROCEDURE `sp_agendarTurno` (IN `p_id_paciente` INT, IN `p_id_medico` INT, IN `p_fecha` DATE, IN `p_hora` TIME)   BEGIN
    INSERT INTO Turnos (id_paciente, id_medico, fecha, hora, estado)
    VALUES (p_id_paciente, p_id_medico, p_fecha, p_hora, 'pendiente');
END$$

CREATE DEFINER=`root`@`192.168.30.%` PROCEDURE `sp_cancelarTurno` (IN `p_id_turno` INT)   BEGIN
    UPDATE Turnos 
    SET estado = 'cancelado'
    WHERE id_turno = p_id_turno;
END$$

CREATE DEFINER=`root`@`192.168.30.%` PROCEDURE `sp_generarHistoria` (IN `p_id_paciente` INT, IN `p_id_medico` INT, IN `p_diagnostico` TEXT, IN `p_tratamiento` TEXT, IN `p_fecha` DATE)   BEGIN
    INSERT INTO Historias_Clinicas (id_paciente, id_medico, diagnostico, tratamiento, fecha)
    VALUES (p_id_paciente, p_id_medico, p_diagnostico, p_tratamiento, p_fecha);
END$$

CREATE DEFINER=`root`@`192.168.30.%` PROCEDURE `sp_reporteMensualIngresos` (IN `p_anio` INT, IN `p_mes` INT)   BEGIN
    SELECT 
        M.id_medico,
        M.nombre AS nombre_medico,
        COUNT(T.id_turno) AS cantidad_turnos
    FROM Turnos T
    INNER JOIN Medicos M ON T.id_medico = M.id_medico
    WHERE YEAR(T.fecha) = p_anio AND MONTH(T.fecha) = p_mes
          AND T.estado = 'completado'
    GROUP BY M.id_medico, M.nombre
    ORDER BY cantidad_turnos DESC;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Historias_Clinicas`
--

CREATE TABLE `Historias_Clinicas` (
  `id_historia` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `diagnostico` text NOT NULL,
  `tratamiento` text,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Disparadores `Historias_Clinicas`
--
DELIMITER $$
CREATE TRIGGER `trg_logEliminarHistoria` BEFORE DELETE ON `Historias_Clinicas` FOR EACH ROW BEGIN
    INSERT INTO Turnos (id_paciente, id_medico, fecha, hora, estado)
    VALUES (OLD.id_paciente, OLD.id_medico, CURDATE(), CURTIME(), 'historia_eliminada');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_registrarAccesoHistorial` AFTER INSERT ON `Historias_Clinicas` FOR EACH ROW BEGIN
    INSERT INTO Turnos (id_paciente, id_medico, fecha, hora, estado)
    VALUES (NEW.id_paciente, NEW.id_medico, NEW.fecha, '00:00:00', 'registrado');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Medicos`
--

CREATE TABLE `Medicos` (
  `id_medico` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `especialidad` varchar(100) NOT NULL,
  `matricula` varchar(50) NOT NULL,
  `disponibilidad` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pacientes`
--

CREATE TABLE `Pacientes` (
  `id_paciente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `obra_social` varchar(100) DEFAULT NULL,
  `alergias` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Turnos`
--

CREATE TABLE `Turnos` (
  `id_turno` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Disparadores `Turnos`
--
DELIMITER $$
CREATE TRIGGER `trg_ActualizarDisponibilidadMedico` AFTER INSERT ON `Turnos` FOR EACH ROW BEGIN
    UPDATE Medicos
    SET disponibilidad = CONCAT('Ocupado en turno el ', NEW.fecha, ' a las ', NEW.hora)
    WHERE id_medico = NEW.id_medico;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_actualizarEstadoTurno` BEFORE UPDATE ON `Turnos` FOR EACH ROW BEGIN
    IF NEW.fecha < CURDATE() AND NEW.estado = 'pendiente' THEN
        SET NEW.estado = 'completado';
    END IF; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `contrasenaHash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Historias_Clinicas`
--
ALTER TABLE `Historias_Clinicas`
  ADD PRIMARY KEY (`id_historia`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Indices de la tabla `Medicos`
--
ALTER TABLE `Medicos`
  ADD PRIMARY KEY (`id_medico`),
  ADD UNIQUE KEY `matricula` (`matricula`);

--
-- Indices de la tabla `Pacientes`
--
ALTER TABLE `Pacientes`
  ADD PRIMARY KEY (`id_paciente`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- Indices de la tabla `Turnos`
--
ALTER TABLE `Turnos`
  ADD PRIMARY KEY (`id_turno`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Historias_Clinicas`
--
ALTER TABLE `Historias_Clinicas`
  MODIFY `id_historia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Medicos`
--
ALTER TABLE `Medicos`
  MODIFY `id_medico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Pacientes`
--
ALTER TABLE `Pacientes`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Turnos`
--
ALTER TABLE `Turnos`
  MODIFY `id_turno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Historias_Clinicas`
--
ALTER TABLE `Historias_Clinicas`
  ADD CONSTRAINT `Historias_Clinicas_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `Pacientes` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Historias_Clinicas_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `Medicos` (`id_medico`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Turnos`
--
ALTER TABLE `Turnos`
  ADD CONSTRAINT `Turnos_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `Pacientes` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Turnos_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `Medicos` (`id_medico`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
