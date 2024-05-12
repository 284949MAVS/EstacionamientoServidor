-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-05-2024 a las 22:23:03
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `estacionamientobd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajones`
--

CREATE TABLE `cajones` (
  `id_Cajon` int(11) NOT NULL COMMENT 'Clave identificadora del tipo de cajon',
  `cve_Est` int(11) NOT NULL COMMENT 'Clave del estacionamiento',
  `num_Cajon` int(11) NOT NULL COMMENT 'Numero de cajón individual',
  `tipo_Cajon` int(11) NOT NULL COMMENT 'Tipo de cajon',
  `disp_Cajon` tinyint(1) NOT NULL COMMENT 'Disponibilidad de cajon'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_Cliente` int(11) NOT NULL,
  `nom_Cliente` varchar(50) NOT NULL,
  `ap_Patc` varchar(15) NOT NULL,
  `ap_Matc` varchar(15) DEFAULT NULL,
  `rfc_Cliente` varchar(30) DEFAULT NULL,
  `dir_Cliente` varchar(70) NOT NULL,
  `tel_Cliente` varchar(20) NOT NULL,
  `correo_Cliente` mediumtext NOT NULL,
  `id_Credencial` int(11) NOT NULL,
  `tipo_Cliente` int(11) NOT NULL,
  `act_Cli` tinyint(1) NOT NULL,
  `dentro` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE `contratos` (
  `id_Contrato` int(11) NOT NULL,
  `id_Cliente` int(11) NOT NULL,
  `auto_Cliente` mediumtext NOT NULL,
  `pago_Cliente` int(11) NOT NULL,
  `fechacont_Cliente` date NOT NULL,
  `vigCon_cliente` date NOT NULL,
  `cont_Act` tinyint(1) NOT NULL,
  `tipo_Cajon` int(11) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `placa` varchar(9) DEFAULT NULL,
  `cajon` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cortes_caja`
--

CREATE TABLE `cortes_caja` (
  `num_Corte` int(11) NOT NULL COMMENT 'Número de corte de caja',
  `id_User` int(11) NOT NULL COMMENT 'Identificador unico de usuario',
  `inicio_Turno` datetime NOT NULL COMMENT 'Inicio de turno de trabajo',
  `fin_Turno` datetime DEFAULT NULL COMMENT 'Fin de turno de trabajo',
  `autos_Salida` int(11) DEFAULT 0 COMMENT 'Total de autos que han salido',
  `tickets_Canc` int(11) DEFAULT 0 COMMENT 'Tickets cancelados durante el turno',
  `efectivo` float DEFAULT 0 COMMENT 'Cantidad pagada en efectivo durante el turno',
  `depos` int(11) DEFAULT 0 COMMENT 'Total de comprobantes de pago de mes durante el turno',
  `total_Corte` float DEFAULT 0 COMMENT 'Cantidad total acumulada durante el corte.',
  `corte_Act` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credencial`
--

CREATE TABLE `credencial` (
  `id_Credencial` int(11) NOT NULL,
  `nom_Cliente` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estacionamientos`
--

CREATE TABLE `estacionamientos` (
  `cve_Est` int(11) NOT NULL COMMENT 'Identificador unico de cada estacionamiento',
  `tipo_Est` int(11) NOT NULL COMMENT 'Tipo de estacionamiento',
  `ubi_Est` mediumtext NOT NULL COMMENT 'Ubicación del estacionamiento',
  `lugares_Tot` int(11) NOT NULL COMMENT 'Lugares totales que contiene cada estacionamiento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_clientes`
--

CREATE TABLE `historial_clientes` (
  `id_historial` int(100) NOT NULL,
  `fecha_entrada` datetime(6) NOT NULL,
  `fecha_salida` datetime(6) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_cliente` varchar(20) NOT NULL,
  `clave_estacionamiento` int(20) NOT NULL,
  `operacion` int(10) DEFAULT NULL,
  `id_Cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_espera`
--

CREATE TABLE `lista_espera` (
  `posicion` int(90) NOT NULL,
  `Fecha_solicitud` date NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `RPE_cliente` int(11) DEFAULT NULL,
  `nom_Cliente` varchar(90) NOT NULL,
  `Ap_PatC` varchar(90) NOT NULL,
  `Ap_MatC` varchar(90) DEFAULT NULL,
  `telefono_cliente` varchar(90) NOT NULL,
  `Facultad_cliente` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `porcentajes`
--

CREATE TABLE `porcentajes` (
  `num_Porc` int(11) NOT NULL,
  `tipo_Est` int(11) NOT NULL,
  `cant_Docs` int(11) NOT NULL,
  `cant_Admins` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id_Ticket` int(11) NOT NULL,
  `cve_Est` int(11) NOT NULL,
  `id_User` int(11) NOT NULL,
  `hr_Ent` datetime NOT NULL,
  `hr_Sal` datetime NOT NULL,
  `num_Cajon` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `id_Cliente` int(8) DEFAULT NULL,
  `pago` float DEFAULT NULL,
  `num_Corte` int(11) NOT NULL,
  `cortesia` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_cajones`
--

CREATE TABLE `tipos_cajones` (
  `id_Cajon` int(11) NOT NULL COMMENT 'Tipo de cajon',
  `desc_Cajon` mediumtext NOT NULL COMMENT 'Descripcion del tipo de cajon'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_clientes`
--

CREATE TABLE `tipos_clientes` (
  `tipo_Cliente` int(11) NOT NULL,
  `desc_Cliente` mediumtext NOT NULL,
  `cliente_pago` int(3) NOT NULL,
  `subsecuente` int(11) DEFAULT NULL,
  `horas` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_estacionamientos`
--

CREATE TABLE `tipos_estacionamientos` (
  `tipo_Est` int(11) NOT NULL COMMENT 'Tipo de estacionamiento',
  `desc_Esta` mediumtext NOT NULL COMMENT 'Descripción del estacionamiento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

CREATE TABLE `tipo_pago` (
  `pago_Cliente` int(11) NOT NULL,
  `desc_PCliente` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `tipo_User` int(1) NOT NULL COMMENT 'Tipo de usuario',
  `desc_User` varchar(20) NOT NULL COMMENT 'Descripción del usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_User` int(8) NOT NULL COMMENT 'Identificador único de usuario',
  `nom_User` varchar(30) NOT NULL COMMENT 'Nombre del usuario',
  `ap_PatU` varchar(20) NOT NULL COMMENT 'Apellido paterno del usuario',
  `ap_MatU` varchar(20) DEFAULT NULL COMMENT 'Apellido materno del usuario',
  `tipo_User` int(11) NOT NULL COMMENT 'Tipo de usuario',
  `correo_User` mediumtext NOT NULL COMMENT 'Correo del usuario',
  `tel_User` varchar(20) NOT NULL COMMENT 'Telefono del usuario',
  `act_User` tinyint(1) NOT NULL COMMENT 'Verificador de actividad del usuario',
  `pass_User` varchar(12) NOT NULL COMMENT 'Contraseña del usuario',
  `corte_Act` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cajones`
--
ALTER TABLE `cajones`
  ADD PRIMARY KEY (`id_Cajon`),
  ADD KEY `fk_caj_type` (`tipo_Cajon`),
  ADD KEY `fk_caj_est` (`cve_Est`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_Cliente`),
  ADD KEY `fk_cl_cre` (`id_Credencial`),
  ADD KEY `fk_cl_type` (`tipo_Cliente`);

--
-- Indices de la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id_Contrato`),
  ADD KEY `fk_con_cli` (`id_Cliente`),
  ADD KEY `fk_con_typec` (`tipo_Cajon`),
  ADD KEY `fk_con_typep` (`pago_Cliente`);

--
-- Indices de la tabla `cortes_caja`
--
ALTER TABLE `cortes_caja`
  ADD PRIMARY KEY (`num_Corte`),
  ADD KEY `fk_cc_usuario` (`id_User`);

--
-- Indices de la tabla `credencial`
--
ALTER TABLE `credencial`
  ADD PRIMARY KEY (`id_Credencial`);

--
-- Indices de la tabla `estacionamientos`
--
ALTER TABLE `estacionamientos`
  ADD PRIMARY KEY (`cve_Est`),
  ADD KEY `fk_est_type` (`tipo_Est`);

--
-- Indices de la tabla `historial_clientes`
--
ALTER TABLE `historial_clientes`
  ADD PRIMARY KEY (`id_historial`);

--
-- Indices de la tabla `lista_espera`
--
ALTER TABLE `lista_espera`
  ADD PRIMARY KEY (`posicion`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id_Ticket`),
  ADD KEY `ff_tick_est` (`cve_Est`),
  ADD KEY `ff_tick_user` (`id_User`),
  ADD KEY `num_Corte` (`num_Corte`);

--
-- Indices de la tabla `tipos_cajones`
--
ALTER TABLE `tipos_cajones`
  ADD PRIMARY KEY (`id_Cajon`);

--
-- Indices de la tabla `tipos_clientes`
--
ALTER TABLE `tipos_clientes`
  ADD PRIMARY KEY (`tipo_Cliente`);

--
-- Indices de la tabla `tipos_estacionamientos`
--
ALTER TABLE `tipos_estacionamientos`
  ADD PRIMARY KEY (`tipo_Est`);

--
-- Indices de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`pago_Cliente`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`tipo_User`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_User`),
  ADD KEY `fk_usuarios_tipo_usuario` (`tipo_User`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_Cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id_Contrato` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cortes_caja`
--
ALTER TABLE `cortes_caja`
  MODIFY `num_Corte` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Número de corte de caja';

--
-- AUTO_INCREMENT de la tabla `credencial`
--
ALTER TABLE `credencial`
  MODIFY `id_Credencial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estacionamientos`
--
ALTER TABLE `estacionamientos`
  MODIFY `cve_Est` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de cada estacionamiento';

--
-- AUTO_INCREMENT de la tabla `historial_clientes`
--
ALTER TABLE `historial_clientes`
  MODIFY `id_historial` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lista_espera`
--
ALTER TABLE `lista_espera`
  MODIFY `posicion` int(90) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id_Ticket` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_cajones`
--
ALTER TABLE `tipos_cajones`
  MODIFY `id_Cajon` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tipo de cajon';

--
-- AUTO_INCREMENT de la tabla `tipos_clientes`
--
ALTER TABLE `tipos_clientes`
  MODIFY `tipo_Cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `pago_Cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `tipo_User` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Tipo de usuario';

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_User` int(8) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de usuario';

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cajones`
--
ALTER TABLE `cajones`
  ADD CONSTRAINT `fk_caj_est` FOREIGN KEY (`cve_Est`) REFERENCES `estacionamientos` (`cve_Est`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_caj_type` FOREIGN KEY (`tipo_Cajon`) REFERENCES `tipos_cajones` (`id_Cajon`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_cl_cre` FOREIGN KEY (`id_Credencial`) REFERENCES `credencial` (`id_Credencial`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cl_type` FOREIGN KEY (`tipo_Cliente`) REFERENCES `tipos_clientes` (`tipo_Cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `fk_con_cli` FOREIGN KEY (`id_Cliente`) REFERENCES `clientes` (`id_Cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_con_typec` FOREIGN KEY (`tipo_Cajon`) REFERENCES `tipos_cajones` (`id_Cajon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_con_typep` FOREIGN KEY (`pago_Cliente`) REFERENCES `tipo_pago` (`pago_Cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cortes_caja`
--
ALTER TABLE `cortes_caja`
  ADD CONSTRAINT `fk_cc_usuario` FOREIGN KEY (`id_User`) REFERENCES `usuarios` (`id_User`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estacionamientos`
--
ALTER TABLE `estacionamientos`
  ADD CONSTRAINT `fk_est_type` FOREIGN KEY (`tipo_Est`) REFERENCES `tipos_estacionamientos` (`tipo_Est`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `ff_tick_est` FOREIGN KEY (`cve_Est`) REFERENCES `estacionamientos` (`cve_Est`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ff_tick_user` FOREIGN KEY (`id_User`) REFERENCES `usuarios` (`id_User`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_tipo_usuario` FOREIGN KEY (`tipo_User`) REFERENCES `tipo_usuario` (`tipo_User`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
