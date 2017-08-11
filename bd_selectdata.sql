-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-06-2017 a las 17:05:39
-- Versión del servidor: 10.0.30-MariaDB-0+deb8u2
-- Versión de PHP: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bd_selectdata`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curriculo`
--

CREATE TABLE IF NOT EXISTS `curriculo` (
`id` int(11) NOT NULL,
  `categoria` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `profesion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cargo_postulado` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_postulacion` date NOT NULL,
  `ruta_de_pdf` text COLLATE utf8_spanish_ci NOT NULL,
  `ruta_de_foto` text COLLATE utf8_spanish_ci NOT NULL,
  `completado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `curriculo`
--

INSERT INTO `curriculo` (`id`, `categoria`, `profesion`, `cargo_postulado`, `fecha_postulacion`, `ruta_de_pdf`, `ruta_de_foto`, `completado`) VALUES
(1, '', '', '', '0000-00-00', '', '', 0),
(2, 'Docente', 'Ingeniero informático', 'Docente en programación web', '2017-06-10', '', '', 0),
(3, 'Obrero', 'TSU Ingormática', 'Vigilante', '2017-06-28', '', 'img/fotos/foto-3.png', 1),
(4, 'Docente', 'Ingeniero en Informática', 'Docente en Programación Web', '2017-06-10', '', '', 0),
(5, 'Docente', 'TSU en Matenimiento', 'Mantenimiento de motores', '2017-06-14', '', '', 0),
(6, 'Docente', 'TSU en Matenimiento', 'Mantenimiento de motores', '2017-06-14', '', '', 0),
(7, 'Obrero', 'Carpintería', 'Carpintero', '2017-06-14', '', '', 0),
(8, 'Obrero', 'Peluquería', 'Peluquera', '2017-06-17', '', 'img/fotos/foto-8.jpeg', 1),
(9, 'Docente', 'Licenciada en Turismo', 'Docente en Proyecto Sociointegrador', '2017-06-17', '', 'img/fotos/foto-9.jpeg', 1),
(10, 'Docente', 'Licenciado en Administración', 'Docente en Matemáticas Financiera', '2017-06-20', '', 'img/fotos/foto-10.jpeg', 1),
(11, 'Obrero', 'Carpientero', 'Carpientero', '2017-06-21', '', 'img/fotos/foto-11.jpeg', 1),
(13, '', '', '', '0000-00-00', '', '', 0),
(14, 'Administrativo', 'Licenciado en Administración', 'Asistente Administrativo', '2017-06-27', '', 'img/fotos/foto-14.jpeg', 1),
(15, 'Docente', 'licenciado en educacion mencion matematica', 'profesor de matematicas', '2017-06-27', '', 'img/fotos/foto-15.jpeg', 1),
(16, '', '', '', '0000-00-00', '', '', 0),
(19, '', '', '', '0000-00-00', '', '', 0),
(20, '', '', '', '0000-00-00', '', '', 0),
(21, '', '', '', '0000-00-00', '', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_personales`
--

CREATE TABLE IF NOT EXISTS `datos_personales` (
`id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cedula` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `genero` enum('F','M','') COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `fecha_natal` date NOT NULL,
  `estado_civil` enum('Casado','Soltero','Viudo','Divorciado','') COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `nacionalidad` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `lugar_natal` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono_hab` char(11) COLLATE utf8_spanish_ci NOT NULL,
  `telefono_movil` char(11) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_actualizacion` date NOT NULL,
  `hora_actualizacion` time NOT NULL,
  `completado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `datos_personales`
--

INSERT INTO `datos_personales` (`id`, `nombre`, `apellido`, `cedula`, `genero`, `fecha_natal`, `estado_civil`, `nacionalidad`, `lugar_natal`, `direccion`, `telefono_hab`, `telefono_movil`, `fecha_actualizacion`, `hora_actualizacion`, `completado`) VALUES
(1, 'Admin', 'Admin', 'V-0000000', '', '0000-00-00', '', '', '', '', '', '', '2017-06-27', '22:31:11', 0),
(2, 'Miguel', 'Salazar', 'V-21011918', '', '0000-00-00', '', '', '', '', '', '', '2017-06-11', '09:04:53', 0),
(3, 'José', 'Seijas', 'V-17781781', 'M', '1975-07-23', 'Soltero', '', 'Carúpano', 'Charallave', '4554-515151', '0412-545877', '2017-06-11', '05:19:11', 1),
(4, 'Jose', 'Seijas', 'V-13123213', 'M', '1990-08-25', 'Soltero', '', 'Carúpano', 'Carúpano', '-', '0412-188589', '2017-06-27', '00:20:17', 1),
(5, 'Moises', 'Salazar', 'V-24841293', '', '0000-00-00', '', '', '', '', '', '', '0000-00-00', '00:00:00', 0),
(6, 'Cristhian', 'Salazar', 'V-24841291', '', '0000-00-00', '', '', '', '', '', '', '0000-00-00', '00:00:00', 0),
(7, 'Daniel', 'Salazar', 'V-24841294', '', '0000-00-00', '', '', '', '', '', '', '0000-00-00', '00:00:00', 0),
(8, 'Mary', 'Castillo', 'V-11442751', '', '0000-00-00', '', '', '', '', '', '', '0000-00-00', '00:00:00', 0),
(9, 'Mónica Eyeu', 'Bastardo Méndez', 'V-24625158', 'F', '1994-06-28', 'Soltero', '', 'Carúpano', 'Los Molinos', '-', '0426-283659', '2017-06-18', '00:20:17', 1),
(10, 'Prueba', 'Prueba', 'V-14313631', 'F', '1998-06-17', 'Soltero', '', 'Carúpano', 'Charallave', '0294-331851', '0426-187876', '2017-06-20', '00:20:17', 1),
(11, 'Nombrew', 'Apellido', 'V-45611515', 'F', '1985-05-12', 'Casado', '', 'Bolívar', 'Centro', '0294-213131', '0426-444555', '2017-06-21', '00:20:17', 1),
(12, 'Master', 'Admin', '', '', '0000-00-00', '', '', '', '', '', '', '2017-06-21', '14:42:07', 0),
(13, 'Postulante', 'Postulante', 'V-12345678', '', '0000-00-00', '', '', '', '', '', '', '0000-00-00', '00:00:00', 0),
(14, 'Andres', 'Ramírez', 'V-12321321', 'M', '1980-05-25', 'Casado', '', 'Carúpano', 'Carúpano', '0294-151515', '0412-515515', '2017-06-27', '00:20:17', 1),
(15, 'Miguel', 'Gil', 'V-17781552', 'M', '1987-03-17', 'Soltero', '', 'charallave', 'charallave', '0294-331451', '0146-282667', '2017-06-27', '00:20:17', 1),
(16, 'crismar', 'Rodriguez', '', '', '0000-00-00', '', '', '', '', '', '', '2017-06-27', '16:04:43', 0),
(19, 'Miguel', 'Salazar', 'V-21011917', '', '0000-00-00', '', '', '', '', '', '', '0000-00-00', '00:00:00', 0),
(20, 'miguel', 'salazar', 'V-12313312', '', '0000-00-00', '', '', '', '', '', '', '2017-06-29', '13:27:35', 0),
(21, 'Miguel', 'Salazar', 'V-21011916', '', '0000-00-00', '', '', '', '', '', '', '0000-00-00', '00:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_postulacion`
--

CREATE TABLE IF NOT EXISTS `estatus_postulacion` (
`id` int(11) NOT NULL,
  `curriculo` int(11) NOT NULL,
  `estatus` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'En Proceso',
  `recomendador` int(11) DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_estatus` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estatus_postulacion`
--

INSERT INTO `estatus_postulacion` (`id`, `curriculo`, `estatus`, `recomendador`, `descripcion`, `fecha_estatus`) VALUES
(1, 3, 'Seleccionado', 4, '', '2017-06-29'),
(2, 7, 'En Proceso', 4, 'No califica', '2017-06-27'),
(3, 5, 'En Proceso', 4, '', '2017-06-20'),
(4, 6, 'En Proceso', NULL, '6', '2017-06-20'),
(5, 8, 'En Proceso', NULL, '', '2017-06-14'),
(24, 9, 'En Proceso', NULL, '', '2017-06-17'),
(25, 10, 'En Proceso', 4, '', '2017-06-29'),
(26, 11, 'En Proceso', 4, '', '2017-06-21'),
(27, 14, 'Pre Seleccionado', 4, '', '2017-06-29'),
(28, 15, 'En Proceso', NULL, '', '2017-06-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `experiencia_laboral`
--

CREATE TABLE IF NOT EXISTS `experiencia_laboral` (
`id` int(11) NOT NULL,
  `curriculo` int(11) NOT NULL,
  `cargo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `empresa` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `anio_inicio` year(4) NOT NULL,
  `anio_fin` year(4) NOT NULL,
  `mes_inicio` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `mes_fin` char(2) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `experiencia_laboral`
--

INSERT INTO `experiencia_laboral` (`id`, `curriculo`, `cargo`, `descripcion`, `empresa`, `anio_inicio`, `anio_fin`, `mes_inicio`, `mes_fin`) VALUES
(3, 14, 'Vendedor', '', 'Tecnomaná', 2009, 2010, '4', '10'),
(4, 15, 'Asesor Tecnico', '', 'MPPTOP', 2010, 2012, '2', '3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formacion`
--

CREATE TABLE IF NOT EXISTS `formacion` (
`id` int(11) NOT NULL,
  `curriculo` int(11) NOT NULL,
  `nivel` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `centro_educativo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `anio_inicio` year(4) NOT NULL,
  `anio_fin` year(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `formacion`
--

INSERT INTO `formacion` (`id`, `curriculo`, `nivel`, `centro_educativo`, `anio_inicio`, `anio_fin`) VALUES
(4, 11, 'Educación Básica Primaria', 'UE Maria de Vera', 1982, 1991),
(5, 14, 'Universidad', 'UPTP Luis Mariano Rivera', 1997, 2002),
(6, 14, 'Universidad', 'UDO', 1995, 1999),
(7, 15, 'Universidad', 'IUT Jacinto Navarro Vallenilla', 2007, 2010);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id` int(11) NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT '1',
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `username` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `password` char(16) COLLATE utf8_spanish_ci NOT NULL,
  `key_password` char(40) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `pregunta_secreta` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `respuesta_secreta` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `nivel` enum('Admin','Secretario','Postulante') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Postulante',
  `fecha_creacion` date NOT NULL,
  `hora_creacion` time NOT NULL,
  `fecha_actualizacion` date NOT NULL,
  `hora_actualizacion` time NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `estatus`, `eliminado`, `username`, `password`, `key_password`, `email`, `pregunta_secreta`, `respuesta_secreta`, `nivel`, `fecha_creacion`, `hora_creacion`, `fecha_actualizacion`, `hora_actualizacion`) VALUES
(1, 1, 0, 'Admin', 'eMfPoqOUlJZn', '641af4d1409ca4c1c41baeebaa95c14643472dc3', 'admin@mail.com', '', '', 'Admin', '2017-06-10', '06:30:41', '2017-06-27', '22:31:11'),
(2, 1, 1, 'Miguel2', 'pKLM2srNo2I=', '4cb3e2563ee9f126b5c2d82fd254beb9f02e6eaf', 'miguel2__salazar@hotmail.com', '', '', 'Postulante', '2017-06-10', '06:42:59', '2017-06-11', '09:04:53'),
(3, 1, 0, 'Seijas', 'ipfMmpfYZpZpmg==', '752ff5c36c33d0b64573defd7f8f5cd3504c23dc', 'seijas@mail.com', '', '', 'Postulante', '2017-06-10', '10:31:06', '2017-06-11', '05:19:11'),
(4, 1, 0, 'Jose', 'pM+brcudeGU=', '230c5de6d59ab992c3b43d7847334869faf9df07', 'miguel@mail.com', '', '', 'Secretario', '2017-06-10', '19:20:53', '2017-06-11', '20:00:13'),
(5, 1, 0, 'Moises', 'pM+bpZjQo2E=', '1df428d4fdbc31ba1be100253cdeebbde42051bc', 'moises@mail.com', '', '', 'Postulante', '2017-06-14', '05:23:23', '0000-00-00', '00:00:00'),
(6, 1, 1, 'Cristhian', 'pJ6dqJWipGo=', '0af4ea6c8c9e7778a299d3cd3ce249e5d1ebe2c1', 'cristhian@mail.com', '', '', 'Postulante', '2017-06-14', '05:30:16', '0000-00-00', '00:00:00'),
(7, 1, 0, 'Daniel', 'pJufrZijdWk=', '96b1790e77560f799215cd5cecc14321d382c850', 'daniel@mail.com', '', '', 'Postulante', '2017-06-14', '05:30:48', '0000-00-00', '00:00:00'),
(8, 0, 1, 'Mary', 'pMvJqcmid5U=', '11da4ae407a09b8b0b964f5b1db19aaf8c5f3376', 'mary@mail.com', '', '', 'Postulante', '2017-06-14', '08:24:29', '0000-00-00', '00:00:00'),
(9, 1, 1, 'Monica', 'pJzN25ald5c=', 'c32586fc95e1998fe49494f2d91e8fe5a1d03ec1', 'monica@mail.com', '', '', 'Postulante', '2017-06-17', '23:52:49', '0000-00-00', '00:00:00'),
(10, 1, 0, 'Prueba', 'h6umyJOZaWuVlg==', '1da8be62421ebe8ede57982b6839978bb5f7e027', 'prueba@mail.com', '', '', 'Postulante', '2017-06-20', '13:05:27', '0000-00-00', '00:00:00'),
(11, 1, 0, 'Nombre', 'haLQw9WWZ2hplw==', '261d20f168da0086c09c4b4fcc0cd61d023e68c7', 'nombre@mas.com', '', '', 'Postulante', '2017-06-21', '14:22:23', '0000-00-00', '00:00:00'),
(12, 1, 0, 'Master', 'aGtkaA==', 'd77b3849fb8fccd4813da13aeb7388945cbdfd35', 'masta@mail.com', '', '', 'Admin', '0000-00-00', '00:00:00', '2017-06-21', '14:42:07'),
(13, 1, 0, 'Postulante', 'h6PVrajPmc/VyJRi', '0a36026c200bf40b991e2a5bcf430a70d00820a7', 'postulante@mail.co', '', '', 'Postulante', '2017-06-27', '14:42:17', '0000-00-00', '00:00:00'),
(14, 0, 0, 'andres', 'eM+Z1ZalkmdoZA==', '1949369d5a41b8982571c7cba6c41bfa0b182cf1', 'andres@mail.com', '', '', 'Postulante', '2017-06-27', '14:44:25', '0000-00-00', '00:00:00'),
(15, 1, 0, 'Seigil', 'ipWayqKelGWWZA==', '56b1e992c18cfaa10ba9a94704d0714ef012bc75', 'giljo@hotmail.com', '', '', 'Postulante', '2017-06-27', '15:52:29', '0000-00-00', '00:00:00'),
(16, 1, 0, 'crismar145', 'aGeVlg==', 'f15b88635f1828481f4ce649811b61b9f5e32844', 'cris@hotmail.com', '', '', 'Postulante', '0000-00-00', '00:00:00', '2017-06-27', '16:04:43'),
(19, 1, 0, 'Miguel', 'pJyfqZ6fpZY=', 'bcd6886a4282de6cefd4c1cd616d7e7addd1e339', 'monica2@mail.com', '', '', 'Postulante', '2017-06-27', '17:45:26', '0000-00-00', '00:00:00'),
(20, 1, 0, '1231232131', 'eMSSmGeVbps=', 'ad21158062f9cbbdc8de09e79cc20c8eadb7735e', 'mail.cadad@mail.com', '', '', 'Postulante', '2017-06-29', '12:12:04', '0000-00-00', '00:00:00'),
(21, 1, 0, 'miguel23', 'pJvMppifemU=', '8da2b317cb9d15efa81f27f5ddba259c733e1113', 'miguel2@mail.com', '', '', 'Postulante', '2017-06-29', '13:49:29', '0000-00-00', '00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `curriculo`
--
ALTER TABLE `curriculo`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `datos_personales`
--
ALTER TABLE `datos_personales`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estatus_postulacion`
--
ALTER TABLE `estatus_postulacion`
 ADD PRIMARY KEY (`id`), ADD KEY `curriculo` (`curriculo`,`recomendador`), ADD KEY `estatus` (`estatus`), ADD KEY `recomendador` (`recomendador`);

--
-- Indices de la tabla `experiencia_laboral`
--
ALTER TABLE `experiencia_laboral`
 ADD PRIMARY KEY (`id`), ADD KEY `curriculo` (`curriculo`);

--
-- Indices de la tabla `formacion`
--
ALTER TABLE `formacion`
 ADD PRIMARY KEY (`id`), ADD KEY `curriculo` (`curriculo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email_2` (`email`), ADD UNIQUE KEY `email_3` (`email`), ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `curriculo`
--
ALTER TABLE `curriculo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `datos_personales`
--
ALTER TABLE `datos_personales`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `estatus_postulacion`
--
ALTER TABLE `estatus_postulacion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT de la tabla `experiencia_laboral`
--
ALTER TABLE `experiencia_laboral`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `formacion`
--
ALTER TABLE `formacion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `curriculo`
--
ALTER TABLE `curriculo`
ADD CONSTRAINT `curriculo_ibfk_2` FOREIGN KEY (`id`) REFERENCES `datos_personales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `datos_personales`
--
ALTER TABLE `datos_personales`
ADD CONSTRAINT `datos_personales_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estatus_postulacion`
--
ALTER TABLE `estatus_postulacion`
ADD CONSTRAINT `estatus_postulacion_ibfk_1` FOREIGN KEY (`curriculo`) REFERENCES `curriculo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `estatus_postulacion_ibfk_2` FOREIGN KEY (`recomendador`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `experiencia_laboral`
--
ALTER TABLE `experiencia_laboral`
ADD CONSTRAINT `experiencia_laboral_ibfk_1` FOREIGN KEY (`curriculo`) REFERENCES `curriculo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `formacion`
--
ALTER TABLE `formacion`
ADD CONSTRAINT `formacion_ibfk_1` FOREIGN KEY (`curriculo`) REFERENCES `curriculo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
