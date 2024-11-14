--
-- Estructura de tabla para la tabla `tb_maquinaria`
--
CREATE TABLE `tb_maquinaria` (
  `id_maquinaria` bigint UNSIGNED NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `observaciones` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Estructura de tabla para la tabla `tb_fundo`
--
CREATE TABLE `tb_fundo` (
  `id_fundo` int NOT NULL,
  `id_empresa` bigint UNSIGNED NOT NULL,
  `nombre` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cod_ubigeo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mapa` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `token` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruta` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;


UPDATE `tb_opcion` SET `name_opcion` = 'Fundos', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 209;


--
-- Estructura de tabla para la tabla `tb_operador`
--
CREATE TABLE `tb_operador` (
  `id_operador` bigint UNSIGNED NOT NULL,
  `id_persona` bigint UNSIGNED NOT NULL,
  `name_user` varchar(255) DEFAULT NULL,
  `pass_user` varchar(255) DEFAULT NULL,
  `cod_recuperacion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fecha_activacion` date DEFAULT NULL,
  `fecha_recuperacion` date DEFAULT NULL,
  `src_imagen` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

UPDATE `tb_opcion` SET `name_opcion` = 'Operador', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 210;

ALTER TABLE `tb_maquinaria` ADD `id_operador` INT NOT NULL AFTER `id_maquinaria`;

UPDATE `tb_opcion` SET `name_opcion` = 'Maquinaria', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 211;