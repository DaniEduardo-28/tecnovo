-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 18-10-2024 a las 23:47:32
-- Versión del servidor: 8.0.30
-- Versión de PHP: 7.4.33
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;

/*!40101 SET NAMES utf8mb4 */
;

--
-- Base de datos: `syscos`
--
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_accesorio`
--
CREATE TABLE `tb_accesorio` (
  `id_accesorio` bigint UNSIGNED NOT NULL,
  `id_fundo` int NOT NULL DEFAULT '1',
  `id_categoria` bigint UNSIGNED NOT NULL,
  `id_unidad_medida` int NOT NULL DEFAULT '1',
  `name_accesorio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `stock_minimo` int NOT NULL DEFAULT '0',
  `precio_compra` double(8, 2) NOT NULL DEFAULT '0.00',
  `id_moneda` int NOT NULL DEFAULT '1',
  `signo_moneda` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'S/',
  `precio_venta` double(8, 2) NOT NULL DEFAULT '0.00',
  `flag_igv` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '1',
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo',
  `src_imagen` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_acceso_opcion`
--
CREATE TABLE `tb_acceso_opcion` (
  `id` bigint UNSIGNED NOT NULL,
  `id_grupo` bigint UNSIGNED NOT NULL,
  `id_opcion` int NOT NULL,
  `flag_agregar` tinyint(1) NOT NULL DEFAULT '0',
  `flag_buscar` tinyint(1) NOT NULL DEFAULT '0',
  `flag_editar` tinyint(1) NOT NULL DEFAULT '0',
  `flag_eliminar` tinyint(1) NOT NULL DEFAULT '0',
  `flag_anular` tinyint(1) NOT NULL DEFAULT '0',
  `flag_ver` tinyint(1) NOT NULL DEFAULT '0',
  `flag_descargar` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_acceso_opcion`
--
INSERT INTO
  `tb_acceso_opcion` (
    `id`,
    `id_grupo`,
    `id_opcion`,
    `flag_agregar`,
    `flag_buscar`,
    `flag_editar`,
    `flag_eliminar`,
    `flag_anular`,
    `flag_ver`,
    `flag_descargar`
  )
VALUES
  (81, 1, 100, 0, 0, 0, 0, 0, 0, 0),
  (82, 1, 101, 1, 1, 1, 1, 1, 1, 1),
  (83, 1, 102, 1, 1, 1, 1, 1, 1, 1),
  (84, 1, 103, 1, 1, 1, 1, 1, 1, 1),
  (85, 1, 104, 1, 1, 1, 1, 1, 1, 1),
  (88, 1, 107, 1, 1, 1, 1, 1, 1, 1),
  (89, 1, 108, 0, 0, 0, 0, 0, 0, 0),
  (90, 1, 109, 0, 0, 0, 0, 0, 0, 0),
  (91, 1, 110, 0, 0, 0, 0, 0, 0, 0),
  (92, 1, 111, 0, 0, 0, 0, 0, 0, 0),
  (93, 1, 112, 0, 0, 0, 0, 0, 0, 0),
  (94, 1, 113, 1, 1, 1, 1, 1, 1, 1),
  (95, 1, 114, 1, 1, 1, 1, 1, 1, 1),
  (96, 1, 115, 1, 1, 1, 1, 1, 1, 1),
  (97, 1, 200, 0, 0, 0, 0, 0, 0, 0),
  (98, 1, 201, 1, 1, 1, 1, 1, 1, 1),
  (99, 1, 202, 1, 1, 1, 1, 1, 1, 1),
  (100, 1, 203, 1, 1, 1, 1, 1, 1, 1),
  (101, 1, 204, 1, 1, 1, 1, 1, 1, 1),
  (102, 1, 205, 1, 1, 1, 1, 1, 1, 1),
  (103, 1, 206, 1, 1, 1, 1, 1, 1, 1),
  (104, 1, 207, 1, 1, 1, 1, 1, 1, 1),
  (105, 1, 208, 1, 1, 1, 1, 1, 1, 1),
  (106, 1, 209, 1, 1, 1, 1, 1, 1, 1),
  (107, 1, 210, 1, 1, 1, 1, 1, 1, 1),
  (108, 1, 211, 1, 1, 1, 1, 1, 1, 1),
  (109, 1, 212, 1, 1, 1, 1, 1, 1, 1),
  (110, 1, 213, 0, 0, 0, 0, 0, 0, 0),
  (111, 1, 214, 0, 0, 0, 0, 0, 0, 0),
  (112, 1, 215, 0, 0, 0, 0, 0, 0, 0),
  (113, 1, 300, 0, 0, 0, 0, 0, 0, 0),
  (114, 1, 301, 1, 1, 1, 1, 1, 1, 1),
  (115, 1, 302, 1, 1, 1, 1, 1, 1, 1),
  (116, 1, 303, 1, 1, 1, 1, 1, 1, 1),
  (117, 1, 304, 1, 1, 1, 1, 1, 1, 1),
  (118, 1, 305, 1, 1, 1, 1, 1, 1, 1),
  (119, 1, 306, 0, 0, 0, 0, 0, 0, 0),
  (120, 1, 307, 0, 0, 0, 0, 0, 0, 0),
  (121, 1, 308, 0, 0, 0, 0, 0, 0, 0),
  (122, 1, 309, 0, 0, 0, 0, 0, 0, 0),
  (123, 1, 310, 0, 0, 0, 0, 0, 0, 0),
  (124, 1, 311, 0, 0, 0, 0, 0, 0, 0),
  (125, 1, 312, 0, 0, 0, 0, 0, 0, 0),
  (126, 1, 313, 0, 0, 0, 0, 0, 0, 0),
  (127, 1, 314, 0, 0, 0, 0, 0, 0, 0),
  (128, 1, 315, 0, 0, 0, 0, 0, 0, 0),
  (129, 1, 400, 0, 0, 0, 0, 0, 0, 0),
  (130, 1, 401, 1, 1, 1, 1, 1, 1, 1),
  (131, 1, 402, 1, 1, 1, 1, 1, 1, 1),
  (132, 1, 403, 1, 1, 1, 1, 1, 1, 1),
  (133, 1, 404, 1, 1, 1, 1, 1, 1, 1),
  (134, 1, 405, 1, 1, 1, 1, 1, 1, 1),
  (135, 1, 406, 1, 1, 1, 1, 1, 1, 1),
  (136, 1, 407, 0, 0, 0, 0, 0, 0, 0),
  (137, 1, 408, 0, 0, 0, 0, 0, 0, 0),
  (138, 1, 409, 0, 0, 0, 0, 0, 0, 0),
  (139, 1, 410, 0, 0, 0, 0, 0, 0, 0),
  (140, 1, 411, 0, 0, 0, 0, 0, 0, 0),
  (141, 1, 412, 0, 0, 0, 0, 0, 0, 0),
  (142, 1, 413, 0, 0, 0, 0, 0, 0, 0),
  (143, 1, 414, 0, 0, 0, 0, 0, 0, 0),
  (144, 1, 415, 0, 0, 0, 0, 0, 0, 0),
  (145, 1, 500, 0, 0, 0, 0, 0, 0, 0),
  (146, 1, 501, 1, 1, 1, 1, 1, 1, 1),
  (147, 1, 502, 1, 1, 1, 1, 1, 1, 1),
  (148, 1, 503, 1, 1, 1, 1, 1, 1, 1),
  (149, 1, 504, 0, 0, 0, 0, 0, 0, 0),
  (150, 1, 505, 0, 0, 0, 0, 0, 0, 0),
  (151, 1, 506, 0, 0, 0, 0, 0, 0, 0),
  (152, 1, 507, 0, 0, 0, 0, 0, 0, 0),
  (153, 1, 508, 0, 0, 0, 0, 0, 0, 0),
  (154, 1, 509, 0, 0, 0, 0, 0, 0, 0),
  (155, 1, 510, 0, 0, 0, 0, 0, 0, 0),
  (156, 1, 511, 0, 0, 0, 0, 0, 0, 0),
  (157, 1, 512, 0, 0, 0, 0, 0, 0, 0),
  (158, 1, 513, 0, 0, 0, 0, 0, 0, 0),
  (159, 1, 514, 0, 0, 0, 0, 0, 0, 0),
  (160, 1, 515, 0, 0, 0, 0, 0, 0, 0),
  (161, 1, 600, 0, 0, 0, 0, 0, 0, 0),
  (162, 1, 601, 1, 1, 1, 1, 1, 1, 1),
  (163, 1, 602, 1, 1, 1, 1, 1, 1, 1),
  (164, 1, 603, 1, 1, 1, 1, 1, 1, 1),
  (165, 1, 604, 1, 1, 1, 1, 1, 1, 1),
  (166, 1, 605, 1, 1, 1, 1, 1, 1, 1),
  (167, 1, 606, 1, 1, 1, 1, 1, 1, 1),
  (168, 1, 607, 0, 0, 0, 0, 0, 0, 0),
  (169, 1, 608, 0, 0, 0, 0, 0, 0, 0),
  (170, 1, 609, 0, 0, 0, 0, 0, 0, 0),
  (171, 1, 610, 0, 0, 0, 0, 0, 0, 0),
  (172, 1, 611, 0, 0, 0, 0, 0, 0, 0),
  (173, 1, 612, 0, 0, 0, 0, 0, 0, 0),
  (174, 1, 613, 0, 0, 0, 0, 0, 0, 0),
  (175, 1, 614, 0, 0, 0, 0, 0, 0, 0),
  (176, 1, 615, 0, 0, 0, 0, 0, 0, 0),
  (177, 1, 700, 0, 0, 0, 0, 0, 0, 0),
  (178, 1, 701, 1, 1, 1, 1, 1, 1, 1),
  (179, 1, 702, 1, 1, 1, 1, 1, 1, 1),
  (180, 1, 703, 1, 1, 1, 1, 1, 1, 1),
  (181, 1, 704, 1, 1, 1, 1, 1, 1, 1),
  (182, 1, 705, 1, 1, 1, 1, 1, 1, 1),
  (183, 1, 706, 1, 1, 1, 1, 1, 1, 1),
  (184, 1, 707, 0, 0, 0, 0, 0, 0, 0),
  (185, 1, 708, 0, 0, 0, 0, 0, 0, 0),
  (186, 1, 709, 0, 0, 0, 0, 0, 0, 0),
  (187, 1, 710, 0, 0, 0, 0, 0, 0, 0),
  (188, 1, 711, 0, 0, 0, 0, 0, 0, 0),
  (189, 1, 712, 0, 0, 0, 0, 0, 0, 0),
  (190, 1, 713, 0, 0, 0, 0, 0, 0, 0),
  (191, 1, 714, 0, 0, 0, 0, 0, 0, 0),
  (192, 1, 715, 0, 0, 0, 0, 0, 0, 0),
  (320, 3, 100, 0, 0, 0, 0, 0, 0, 0),
  (321, 3, 101, 0, 0, 0, 0, 0, 0, 0),
  (322, 3, 102, 0, 0, 0, 0, 0, 0, 0),
  (323, 3, 103, 0, 0, 0, 0, 0, 0, 0),
  (324, 3, 104, 0, 0, 0, 0, 0, 0, 0),
  (326, 3, 106, 0, 0, 0, 0, 0, 0, 0),
  (327, 3, 107, 0, 0, 0, 0, 0, 0, 0),
  (328, 3, 108, 0, 0, 0, 0, 0, 0, 0),
  (329, 3, 109, 0, 0, 0, 0, 0, 0, 0),
  (330, 3, 110, 0, 0, 0, 0, 0, 0, 0),
  (331, 3, 111, 0, 0, 0, 0, 0, 0, 0),
  (332, 3, 112, 0, 0, 0, 0, 0, 0, 0),
  (333, 3, 113, 0, 0, 0, 0, 0, 0, 0),
  (334, 3, 114, 0, 0, 0, 0, 0, 0, 0),
  (335, 3, 115, 0, 0, 0, 0, 0, 0, 0),
  (336, 3, 200, 0, 0, 0, 0, 0, 0, 0),
  (337, 3, 201, 1, 1, 1, 1, 0, 1, 1),
  (338, 3, 202, 1, 1, 1, 1, 0, 1, 1),
  (339, 3, 203, 1, 1, 1, 0, 0, 1, 1),
  (340, 3, 204, 1, 1, 1, 0, 0, 1, 1),
  (341, 3, 205, 0, 0, 0, 0, 0, 0, 0),
  (342, 3, 206, 0, 0, 0, 0, 0, 0, 0),
  (343, 3, 207, 1, 1, 1, 0, 0, 1, 1),
  (344, 3, 208, 1, 1, 1, 0, 0, 1, 1),
  (345, 3, 209, 1, 1, 1, 0, 0, 1, 0),
  (346, 3, 210, 1, 1, 1, 0, 0, 1, 0),
  (347, 3, 211, 1, 1, 1, 0, 0, 1, 0),
  (348, 3, 212, 1, 1, 1, 1, 0, 1, 0),
  (349, 3, 213, 0, 0, 0, 0, 0, 0, 0),
  (350, 3, 214, 0, 0, 0, 0, 0, 0, 0),
  (351, 3, 215, 0, 0, 0, 0, 0, 0, 0),
  (352, 3, 300, 0, 0, 0, 0, 0, 0, 0),
  (353, 3, 301, 0, 0, 0, 0, 0, 0, 0),
  (354, 3, 302, 0, 0, 0, 0, 0, 0, 0),
  (355, 3, 303, 0, 0, 0, 0, 0, 0, 0),
  (356, 3, 304, 0, 0, 0, 0, 0, 0, 0),
  (357, 3, 305, 0, 0, 0, 0, 0, 0, 0),
  (358, 3, 306, 0, 0, 0, 0, 0, 0, 0),
  (359, 3, 307, 0, 0, 0, 0, 0, 0, 0),
  (360, 3, 308, 0, 0, 0, 0, 0, 0, 0),
  (361, 3, 309, 0, 0, 0, 0, 0, 0, 0),
  (362, 3, 310, 0, 0, 0, 0, 0, 0, 0),
  (363, 3, 311, 0, 0, 0, 0, 0, 0, 0),
  (364, 3, 312, 0, 0, 0, 0, 0, 0, 0),
  (365, 3, 313, 0, 0, 0, 0, 0, 0, 0),
  (366, 3, 314, 0, 0, 0, 0, 0, 0, 0),
  (367, 3, 315, 0, 0, 0, 0, 0, 0, 0),
  (368, 3, 400, 0, 0, 0, 0, 0, 0, 0),
  (369, 3, 401, 0, 0, 0, 0, 0, 0, 0),
  (370, 3, 402, 0, 0, 0, 0, 0, 0, 0),
  (371, 3, 403, 0, 0, 0, 0, 0, 0, 0),
  (372, 3, 404, 0, 0, 0, 0, 0, 0, 0),
  (373, 3, 405, 0, 0, 0, 0, 0, 0, 0),
  (374, 3, 406, 0, 0, 0, 0, 0, 0, 0),
  (375, 3, 407, 0, 0, 0, 0, 0, 0, 0),
  (376, 3, 408, 0, 0, 0, 0, 0, 0, 0),
  (377, 3, 409, 0, 0, 0, 0, 0, 0, 0),
  (378, 3, 410, 0, 0, 0, 0, 0, 0, 0),
  (379, 3, 411, 0, 0, 0, 0, 0, 0, 0),
  (380, 3, 412, 0, 0, 0, 0, 0, 0, 0),
  (381, 3, 413, 0, 0, 0, 0, 0, 0, 0),
  (382, 3, 414, 0, 0, 0, 0, 0, 0, 0),
  (383, 3, 415, 0, 0, 0, 0, 0, 0, 0),
  (384, 3, 500, 0, 0, 0, 0, 0, 0, 0),
  (385, 3, 501, 0, 0, 0, 0, 0, 0, 0),
  (386, 3, 502, 0, 0, 0, 0, 0, 0, 0),
  (387, 3, 503, 0, 0, 0, 0, 0, 0, 0),
  (388, 3, 504, 0, 0, 0, 0, 0, 0, 0),
  (389, 3, 505, 0, 0, 0, 0, 0, 0, 0),
  (390, 3, 506, 0, 0, 0, 0, 0, 0, 0),
  (391, 3, 507, 0, 0, 0, 0, 0, 0, 0),
  (392, 3, 508, 0, 0, 0, 0, 0, 0, 0),
  (393, 3, 509, 0, 0, 0, 0, 0, 0, 0),
  (394, 3, 510, 0, 0, 0, 0, 0, 0, 0),
  (395, 3, 511, 0, 0, 0, 0, 0, 0, 0),
  (396, 3, 512, 0, 0, 0, 0, 0, 0, 0),
  (397, 3, 513, 0, 0, 0, 0, 0, 0, 0),
  (398, 3, 514, 0, 0, 0, 0, 0, 0, 0),
  (399, 3, 515, 0, 0, 0, 0, 0, 0, 0),
  (400, 3, 600, 0, 0, 0, 0, 0, 0, 0),
  (401, 3, 601, 0, 0, 0, 0, 0, 0, 0),
  (402, 3, 602, 1, 1, 1, 0, 0, 1, 1),
  (403, 3, 603, 1, 1, 1, 0, 0, 1, 1),
  (404, 3, 604, 1, 1, 1, 0, 0, 1, 1),
  (405, 3, 605, 1, 1, 1, 0, 0, 1, 1),
  (406, 3, 606, 1, 1, 1, 1, 1, 1, 1),
  (407, 3, 607, 0, 0, 0, 0, 0, 0, 0),
  (408, 3, 608, 0, 0, 0, 0, 0, 0, 0),
  (409, 3, 609, 0, 0, 0, 0, 0, 0, 0),
  (410, 3, 610, 0, 0, 0, 0, 0, 0, 0),
  (411, 3, 611, 0, 0, 0, 0, 0, 0, 0),
  (412, 3, 612, 0, 0, 0, 0, 0, 0, 0),
  (413, 3, 613, 0, 0, 0, 0, 0, 0, 0),
  (414, 3, 614, 0, 0, 0, 0, 0, 0, 0),
  (415, 3, 615, 0, 0, 0, 0, 0, 0, 0),
  (416, 3, 700, 0, 0, 0, 0, 0, 0, 0),
  (417, 3, 701, 0, 0, 0, 0, 0, 0, 0),
  (418, 3, 702, 0, 0, 0, 0, 0, 0, 0),
  (419, 3, 703, 0, 0, 0, 0, 0, 0, 0),
  (420, 3, 704, 0, 0, 0, 0, 0, 0, 0),
  (421, 3, 705, 0, 0, 0, 0, 0, 0, 0),
  (422, 3, 706, 0, 0, 0, 0, 0, 0, 0),
  (423, 3, 707, 0, 0, 0, 0, 0, 0, 0),
  (424, 3, 708, 0, 0, 0, 0, 0, 0, 0),
  (425, 3, 709, 0, 0, 0, 0, 0, 0, 0),
  (426, 3, 710, 0, 0, 0, 0, 0, 0, 0),
  (427, 3, 711, 0, 0, 0, 0, 0, 0, 0),
  (428, 3, 712, 0, 0, 0, 0, 0, 0, 0),
  (429, 3, 713, 0, 0, 0, 0, 0, 0, 0),
  (430, 3, 714, 0, 0, 0, 0, 0, 0, 0),
  (431, 3, 715, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_categoria_accesorio`
--
CREATE TABLE `tb_categoria_accesorio` (
  `id_categoria` bigint UNSIGNED NOT NULL,
  `name_categoria` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_cliente`
--
CREATE TABLE `tb_cliente` (
  `id_cliente` bigint UNSIGNED NOT NULL,
  `id_persona` bigint UNSIGNED NOT NULL,
  `name_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `pass_user` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cod_recuperacion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fecha_activacion` date DEFAULT NULL,
  `fecha_recuperacion` date DEFAULT NULL,
  `src_imagen` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_cliente`
--
INSERT INTO
  `tb_cliente` (
    `id_cliente`,
    `id_persona`,
    `name_user`,
    `pass_user`,
    `cod_recuperacion`,
    `fecha_activacion`,
    `fecha_recuperacion`,
    `src_imagen`,
    `estado`
  )
VALUES
  (
    1,
    2,
    'zaid',
    'd41d8cd98f00b204e9800998ecf8427e',
    NULL,
    '2019-10-16',
    NULL,
    'resources/global/images/persons/img-1571243739.png',
    'activo'
  ),
  (
    2,
    10,
    '',
    '',
    NULL,
    '2024-09-30',
    NULL,
    'resources/global/images/sin_imagen.png',
    'activo'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_cliente_fundo`
--
CREATE TABLE `tb_cliente_fundo` (
  `id` bigint NOT NULL,
  `id_cliente` bigint UNSIGNED DEFAULT NULL,
  `id_fundo` int DEFAULT NULL,
  `cantidad_hc` float DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tb_cliente_fundo`
--
INSERT INTO
  `tb_cliente_fundo` (`id`, `id_cliente`, `id_fundo`, `cantidad_hc`)
VALUES
  (34, 2, 1, 3),
  (37, 1, 1, 9),
  (38, 1, 2, 2),
  (39, 1, 3, 4),
  (40, 1, 5, 6),
  (41, 1, 6, 2),
  (42, 1, 7, 3);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_compra`
--
CREATE TABLE `tb_compra` (
  `id_compra` int NOT NULL,
  `id_fundo` int NOT NULL,
  `id_trabajador` bigint UNSIGNED NOT NULL,
  `id_documento_compra` int NOT NULL,
  `name_documento_compra` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_documento_compra` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correlativo` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_documento_proveedor` bigint UNSIGNED NOT NULL,
  `name_documento_proveedor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_documento_proveedor` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_documento_proveedor` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_forma_pago` int NOT NULL,
  `codigo_forma_pago` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_forma_pago` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `proveedor` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
  `descuento_total` decimal(18, 2) DEFAULT '0.00',
  `sub_total` decimal(18, 2) NOT NULL,
  `igv` decimal(18, 2) NOT NULL,
  `total` decimal(18, 2) NOT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `pdf` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xml` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cdr` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mensaje_sunat` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruta` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag_doc_interno` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `monto_recibido` decimal(18, 2) DEFAULT NULL,
  `vuelto` decimal(18, 2) DEFAULT NULL,
  `id_moneda` int NOT NULL,
  `codigo_moneda` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `signo_moneda` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abreviatura_moneda` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signo_moneda_cambio` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'S/ ',
  `monto_tipo_cambio` decimal(18, 2) DEFAULT NULL,
  `observaciones` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag_enviado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_detalle_compra`
--
CREATE TABLE `tb_detalle_compra` (
  `id_detalle` bigint NOT NULL,
  `id_orden_compra` int NOT NULL,
  `name_tabla` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cod_producto` int NOT NULL,
  `cantidad_solicitada` int DEFAULT NULL,
  `cantidad_ingresada` int DEFAULT NULL,
  `precio_unitario` decimal(18, 2) DEFAULT NULL,
  `notas` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_detalle_gasto`
--
CREATE TABLE `tb_detalle_gasto` (
  `id_detalle` bigint NOT NULL,
  `id_orden_gasto` int NOT NULL,
  `name_tabla` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cod_gasto` int NOT NULL,
  `cantidad_solicitada` int DEFAULT NULL,
  `precio_unitario` decimal(18, 2) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_detalle_ingreso`
--
CREATE TABLE `tb_detalle_ingreso` (
  `id_detalle` bigint NOT NULL,
  `id_ingreso` bigint NOT NULL,
  `name_tabla` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_producto` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `observaciones` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_detalle_venta`
--
CREATE TABLE `tb_detalle_venta` (
  `id_detalle` bigint UNSIGNED NOT NULL,
  `id_venta` int NOT NULL,
  `name_tabla` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_producto` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` decimal(18, 2) NOT NULL,
  `precio_unitario` decimal(18, 3) NOT NULL,
  `descuento` decimal(18, 2) DEFAULT '0.00',
  `sub_total` decimal(18, 2) NOT NULL,
  `tipo_igv` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `igv` decimal(18, 2) NOT NULL,
  `total` decimal(18, 2) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_documento_identidad`
--
CREATE TABLE `tb_documento_identidad` (
  `id_documento` bigint UNSIGNED NOT NULL,
  `name_documento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `codigo_sunat` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `flag_numerico` tinyint(1) NOT NULL DEFAULT '0',
  `flag_exacto` tinyint(1) NOT NULL DEFAULT '0',
  `size` int NOT NULL DEFAULT '8',
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_documento_identidad`
--
INSERT INTO
  `tb_documento_identidad` (
    `id_documento`,
    `name_documento`,
    `codigo_sunat`,
    `flag_numerico`,
    `flag_exacto`,
    `size`,
    `estado`
  )
VALUES
  (1, 'DNI', '1', 1, 1, 8, 'activo'),
  (3, 'RUC', '6', 1, 1, 12, 'activo'),
  (
    4,
    'CARNET DE EXTRANJERÍA',
    '4',
    0,
    0,
    12,
    'activo'
  ),
  (5, 'PASAPORTE', '7', 0, 0, 11, 'activo');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_documento_venta`
--
CREATE TABLE `tb_documento_venta` (
  `id_documento_venta` int NOT NULL,
  `id_fundo` int NOT NULL,
  `cod_sunat` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_corto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correlativo` bigint DEFAULT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag_doc_interno` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tb_documento_venta`
--
INSERT INTO
  `tb_documento_venta` (
    `id_documento_venta`,
    `id_fundo`,
    `cod_sunat`,
    `nombre`,
    `nombre_corto`,
    `serie`,
    `correlativo`,
    `estado`,
    `flag_doc_interno`
  )
VALUES
  (
    1,
    1,
    '2',
    'BOLETA ELECTRÓNICA',
    'BOLETA',
    'BPP1',
    2,
    '1',
    '0'
  ),
  (
    2,
    1,
    '1',
    'FACTURA ELECTRÓNICA',
    'FACTURA',
    'FPP1',
    1,
    '1',
    '0'
  ),
  (
    3,
    1,
    '-',
    'TIKET INTERNO',
    'TIKET INTERNO',
    'TIK1',
    1,
    '1',
    '1'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_empresa`
--
CREATE TABLE `tb_empresa` (
  `id_empresa` bigint UNSIGNED NOT NULL,
  `id_documento` bigint UNSIGNED NOT NULL,
  `num_documento` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `razon_social` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre_comercial` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `direccion` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fono01` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `correo01` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `web` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_documento_representante` bigint UNSIGNED NOT NULL,
  `num_documento_representante` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombres_representante` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellidos_representante` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fono02` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `correo02` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo',
  `src_logo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_empresa`
--
INSERT INTO
  `tb_empresa` (
    `id_empresa`,
    `id_documento`,
    `num_documento`,
    `razon_social`,
    `nombre_comercial`,
    `direccion`,
    `fono01`,
    `correo01`,
    `web`,
    `id_documento_representante`,
    `num_documento_representante`,
    `nombres_representante`,
    `apellidos_representante`,
    `fono02`,
    `correo02`,
    `estado`,
    `src_logo`
  )
VALUES
  (
    1,
    3,
    '10707623433',
    'SYSCOS',
    'SysCos: Sistema para la gestión de cosechas',
    'Jr. Pedro Remy N 239, San Martín de Porres - Lima - Lima',
    '916028408',
    'informes@syscoss.com',
    'https://syscos-sistemas.com/',
    1,
    '70762343',
    'Hector',
    'Laboe',
    '916028408',
    'jolu@syscos.com',
    'activo',
    'resources/global/images/business_logo/img-1571242080.jpg'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_forma_pago`
--
CREATE TABLE `tb_forma_pago` (
  `id_forma_pago` int NOT NULL,
  `name_forma_pago` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cod_sunat` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tb_forma_pago`
--
INSERT INTO
  `tb_forma_pago` (
    `id_forma_pago`,
    `name_forma_pago`,
    `cod_sunat`,
    `estado`
  )
VALUES
  (1, 'EFECTIVO', '01', '1'),
  (2, 'CHEQUE', '02', '1'),
  (3, 'TARJETA DE CRÉDITO', '03', '1'),
  (4, 'TARJETA DE DÉBITO', '04', '1');

-- --------------------------------------------------------
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

--
-- Volcado de datos para la tabla `tb_fundo`
--
INSERT INTO
  `tb_fundo` (
    `id_fundo`,
    `id_empresa`,
    `nombre`,
    `cod_ubigeo`,
    `direccion`,
    `telefono`,
    `mapa`,
    `estado`,
    `token`,
    `ruta`
  )
VALUES
  (
    1,
    1,
    'MALVINAS',
    '150302',
    'JR. TOMÁS GUIDO N 239 - OF. 302 - LINCE',
    '987654326',
    '',
    '1',
    '',
    ''
  ),
  (
    2,
    1,
    'SOL NACIENTE',
    '1086767',
    '',
    '928373817',
    '',
    '1',
    '',
    ''
  ),
  (
    3,
    1,
    '16 DE NOVIEMBRE',
    '19029838',
    '',
    '',
    '',
    '1',
    '',
    ''
  ),
  (
    4,
    1,
    'FLOR DEL VALLE',
    '109283',
    '',
    '',
    '',
    '1',
    '',
    ''
  ),
  (
    5,
    1,
    'LIBERTAD',
    '102823',
    '',
    '',
    '',
    '1',
    '',
    ''
  ),
  (
    6,
    1,
    'SAN JUAN',
    '102832',
    '',
    '',
    '',
    '1',
    '',
    ''
  ),
  (
    7,
    1,
    'MARONAL',
    '120384',
    '',
    '',
    '',
    '1',
    '',
    ''
  ),
  (
    8,
    1,
    'CURIMANA',
    '20283',
    '',
    '',
    '',
    '1',
    '',
    ''
  ),
  (9, 1, 'OTROS', '892893', '', '', '', '1', '', '');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_galeria`
--
CREATE TABLE `tb_galeria` (
  `id` bigint UNSIGNED NOT NULL,
  `name_tabla` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `src` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referencia_1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referencia_2` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_gasto`
--
CREATE TABLE `tb_gasto` (
  `id_gasto` bigint UNSIGNED NOT NULL,
  `id_tipo_gasto` bigint UNSIGNED NOT NULL,
  `name_gasto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion_gasto` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `flag_igv` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT '1',
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tb_gasto`
--
INSERT INTO
  `tb_gasto` (
    `id_gasto`,
    `id_tipo_gasto`,
    `name_gasto`,
    `descripcion_gasto`,
    `flag_igv`,
    `estado`
  )
VALUES
  (
    1,
    3,
    'BALDE DE ACEITES',
    'Balde de Aceite de 140 caja',
    '0',
    'activo'
  ),
  (
    2,
    3,
    'FILTRO DE HST',
    'Partes de reemplazo en la maquinaria',
    '0',
    ''
  ),
  (
    3,
    3,
    'MANGUERA DE BOMBA',
    'Manguera de bomba de dirección',
    '1',
    'activo'
  ),
  (
    5,
    4,
    'MANTENIMIENTO',
    'Mantenimiento preventivo de camioneta',
    '1',
    'activo'
  ),
  (
    6,
    4,
    'REPARACIÓN DE CAÑERIAS',
    'Reparación de cañerias de combustible',
    '0',
    ''
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_grupo_usuario`
--
CREATE TABLE `tb_grupo_usuario` (
  `id_grupo` bigint UNSIGNED NOT NULL,
  `name_grupo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_grupo_usuario`
--
INSERT INTO
  `tb_grupo_usuario` (`id_grupo`, `name_grupo`, `estado`)
VALUES
  (1, 'Administrador', 'activo'),
  (3, 'Operador', 'activo');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_ingreso`
--
CREATE TABLE `tb_ingreso` (
  `id_ingreso` bigint NOT NULL,
  `id_orden_compra` int NOT NULL,
  `id_sucursal` int NOT NULL,
  `id_trabajador` int NOT NULL,
  `id_tipo_docu` int DEFAULT NULL,
  `num_documento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `observaciones` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_ingreso_gasto`
--
CREATE TABLE `tb_ingreso_gasto` (
  `id_ingreso_gasto` bigint NOT NULL,
  `id_orden_gasto` int NOT NULL,
  `id_gasto` int NOT NULL,
  `id_trabajador` int NOT NULL,
  `id_tipo_docu` int DEFAULT NULL,
  `num_documento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `observaciones` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
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
-- Volcado de datos para la tabla `tb_maquinaria`
--
INSERT INTO
  `tb_maquinaria` (
    `id_maquinaria`,
    `descripcion`,
    `observaciones`,
    `estado`
  )
VALUES
  (1, 'MAQUINA 1', 'Defectuosa', ''),
  (
    2,
    'MAQUINA 3',
    'Cambiar manguera de agua',
    'activo'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_metodo_envio`
--
CREATE TABLE `tb_metodo_envio` (
  `id_metodo_envio` int NOT NULL,
  `name_metodo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_moneda`
--
CREATE TABLE `tb_moneda` (
  `id_moneda` int NOT NULL,
  `name_moneda` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_sunat` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abreviatura` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_cambio` decimal(18, 3) DEFAULT '1.000',
  `flag_principal` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tb_moneda`
--
INSERT INTO
  `tb_moneda` (
    `id_moneda`,
    `name_moneda`,
    `cod_sunat`,
    `signo`,
    `abreviatura`,
    `tipo_cambio`,
    `flag_principal`,
    `estado`
  )
VALUES
  (1, 'SOLES', '1', 'S/', 'PEN', 1.000, '1', '1'),
  (2, 'DÓLARES', '2', '$', 'USD', 3.350, '0', '1'),
  (3, 'EUROS', '3', '€', 'EUR', 3.750, '0', '1');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_opcion`
--
CREATE TABLE `tb_opcion` (
  `id_opcion` int NOT NULL,
  `name_opcion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo',
  `url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `icono` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_opcion`
--
INSERT INTO
  `tb_opcion` (
    `id_opcion`,
    `name_opcion`,
    `estado`,
    `url`,
    `order`,
    `icono`
  )
VALUES
  (100, 'Configuración', 'activo', NULL, 0, NULL),
  (101, 'Mi Empresa', 'activo', NULL, 1, NULL),
  (102, 'Sucursales', 'activo', NULL, 2, NULL),
  (103, 'Monedas', 'activo', NULL, 3, NULL),
  (
    104,
    'Documentos de Identidad',
    'activo',
    NULL,
    4,
    NULL
  ),
  (106, '', 'inactivo', NULL, 6, NULL),
  (
    107,
    'Tipos de Servicios',
    'activo',
    NULL,
    7,
    NULL
  ),
  (108, '', 'inactivo', NULL, 8, NULL),
  (109, '', 'inactivo', NULL, 9, NULL),
  (110, '', 'inactivo', NULL, 10, NULL),
  (111, '', 'inactivo', NULL, 11, NULL),
  (112, '', 'inactivo', NULL, 12, NULL),
  (113, '', 'inactivo', NULL, 13, NULL),
  (114, '', 'inactivo', NULL, 14, NULL),
  (
    115,
    'Tipos de Cosecha',
    'activo',
    NULL,
    15,
    NULL
  ),
  (200, 'Mantenimiento', 'activo', NULL, 0, NULL),
  (201, 'Clientes', 'activo', NULL, 0, NULL),
  (202, 'Servicios', 'activo', NULL, 0, NULL),
  (203, '', 'inactivo', NULL, 0, NULL),
  (204, '', 'inactivo', NULL, 0, NULL),
  (205, '', 'inactivo', NULL, 0, NULL),
  (206, '', 'inactivo', NULL, 0, NULL),
  (207, '', 'inactivo', NULL, 0, NULL),
  (208, 'Proveedores', 'activo', NULL, 0, NULL),
  (209, 'Operadores', 'activo', NULL, 0, NULL),
  (210, 'Maquinarias', 'activo', NULL, 0, NULL),
  (211, 'Tipos de Gastos', 'activo', NULL, 0, NULL),
  (212, 'Gastos', 'activo', NULL, 0, NULL),
  (213, NULL, '', NULL, 0, NULL),
  (214, NULL, '', NULL, 0, NULL),
  (215, NULL, '', NULL, 0, NULL),
  (300, 'Seguridad', 'activo', NULL, 0, NULL),
  (
    301,
    'Grupos de Usuarios',
    'activo',
    NULL,
    0,
    NULL
  ),
  (
    302,
    'Acceso a Opciones',
    'activo',
    NULL,
    0,
    NULL
  ),
  (
    303,
    'Acceso a Sucursales',
    'activo',
    NULL,
    0,
    NULL
  ),
  (304, 'Trabajadores', 'activo', NULL, 0, NULL),
  (305, 'Acceso a Fundos', 'activo', NULL, 0, NULL),
  (306, NULL, '', NULL, 0, NULL),
  (307, NULL, '', NULL, 0, NULL),
  (308, NULL, '', NULL, 0, NULL),
  (309, NULL, '', NULL, 0, NULL),
  (310, NULL, '', NULL, 0, NULL),
  (311, NULL, '', NULL, 0, NULL),
  (312, NULL, '', NULL, 0, NULL),
  (313, NULL, '', NULL, 0, NULL),
  (314, NULL, '', NULL, 0, NULL),
  (315, NULL, '', NULL, 0, NULL),
  (400, '', 'inactivo', NULL, 0, NULL),
  (401, '', 'inactivo', NULL, 0, NULL),
  (402, '', 'inactivo', NULL, 0, NULL),
  (403, '', 'inactivo', NULL, 0, NULL),
  (404, '', 'inactivo', NULL, 0, NULL),
  (405, '', 'inactivo', NULL, 0, NULL),
  (406, '', 'inactivo', NULL, 0, NULL),
  (407, NULL, '', NULL, 0, NULL),
  (408, NULL, '', NULL, 0, NULL),
  (409, NULL, '', NULL, 0, NULL),
  (410, NULL, '', NULL, 0, NULL),
  (411, NULL, '', NULL, 0, NULL),
  (412, NULL, '', NULL, 0, NULL),
  (413, NULL, '', NULL, 0, NULL),
  (414, NULL, '', NULL, 0, NULL),
  (415, NULL, '', NULL, 0, NULL),
  (500, '', 'inactivo', NULL, 0, NULL),
  (501, '', 'inactivo', NULL, 0, NULL),
  (502, '', 'inactivo', NULL, 0, NULL),
  (503, '', 'inactivo', NULL, 0, NULL),
  (504, NULL, '', NULL, 0, NULL),
  (505, NULL, '', NULL, 0, NULL),
  (506, NULL, '', NULL, 0, NULL),
  (507, NULL, '', NULL, 0, NULL),
  (508, NULL, '', NULL, 0, NULL),
  (509, NULL, '', NULL, 0, NULL),
  (510, NULL, '', NULL, 0, NULL),
  (511, NULL, '', NULL, 0, NULL),
  (512, NULL, '', NULL, 0, NULL),
  (513, NULL, '', NULL, 0, NULL),
  (514, NULL, '', NULL, 0, NULL),
  (515, NULL, '', NULL, 0, NULL),
  (600, 'Operaciones', 'activo', NULL, 0, NULL),
  (601, '', 'inactivo', NULL, 0, NULL),
  (602, 'Facturación', 'activo', NULL, 0, NULL),
  (
    603,
    'Ordenes de Compra',
    'activo',
    NULL,
    0,
    NULL
  ),
  (
    604,
    'Promociones Clientes',
    'activo',
    NULL,
    0,
    NULL
  ),
  (
    605,
    'Ingreso de Productos',
    'activo',
    NULL,
    0,
    NULL
  ),
  (
    606,
    'Ordenes de Gastos',
    'activo',
    NULL,
    0,
    NULL
  ),
  (607, NULL, 'inactivo', NULL, 0, NULL),
  (608, NULL, 'inactivo', NULL, 0, NULL),
  (609, NULL, 'inactivo', NULL, 0, NULL),
  (610, NULL, 'inactivo', NULL, 0, NULL),
  (611, NULL, 'inactivo', NULL, 0, NULL),
  (612, NULL, 'inactivo', NULL, 0, NULL),
  (613, NULL, 'inactivo', NULL, 0, NULL),
  (614, NULL, 'inactivo', NULL, 0, NULL),
  (615, NULL, 'inactivo', NULL, 0, NULL),
  (700, 'Reportes', 'activo', NULL, 0, NULL),
  (701, '', 'inactivo', NULL, 0, NULL),
  (
    702,
    'Reporte de Ventas',
    'activo',
    NULL,
    0,
    NULL
  ),
  (703, '', 'inactivo', NULL, 0, NULL),
  (704, '', 'inactivo', NULL, 0, NULL),
  (
    705,
    'Mostrar Estadísticas',
    'activo',
    NULL,
    0,
    NULL
  ),
  (
    706,
    'Observaciones de Proveedor',
    'activo',
    NULL,
    0,
    NULL
  ),
  (707, NULL, 'inactivo', NULL, 0, NULL),
  (708, NULL, 'inactivo', NULL, 0, NULL),
  (709, NULL, 'inactivo', NULL, 0, NULL),
  (710, NULL, 'inactivo', NULL, 0, NULL),
  (711, NULL, 'inactivo', NULL, 0, NULL),
  (712, NULL, 'inactivo', NULL, 0, NULL),
  (713, NULL, 'inactivo', NULL, 0, NULL),
  (714, NULL, 'inactivo', NULL, 0, NULL),
  (715, NULL, 'inactivo', NULL, 0, NULL);

-- --------------------------------------------------------
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

--
-- Volcado de datos para la tabla `tb_operador`
--
INSERT INTO
  `tb_operador` (
    `id_operador`,
    `id_persona`,
    `name_user`,
    `pass_user`,
    `cod_recuperacion`,
    `fecha_activacion`,
    `fecha_recuperacion`,
    `src_imagen`,
    `estado`
  )
VALUES
  (
    1,
    7,
    '',
    '',
    NULL,
    '2024-09-27',
    NULL,
    'resources/global/images/sin_imagen.png',
    'activo'
  ),
  (
    2,
    9,
    '',
    '',
    NULL,
    '2024-09-27',
    NULL,
    'resources/global/images/sin_imagen.png',
    'activo'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_orden_compra`
--
CREATE TABLE `tb_orden_compra` (
  `id_orden_compra` int NOT NULL,
  `id_metodo_envio` int NOT NULL,
  `id_proveedor` int NOT NULL,
  `id_trabajador` int NOT NULL,
  `id_fundo` int NOT NULL,
  `fecha_orden` datetime NOT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `descripcion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_moneda` int NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tb_orden_compra`
--
INSERT INTO
  `tb_orden_compra` (
    `id_orden_compra`,
    `id_metodo_envio`,
    `id_proveedor`,
    `id_trabajador`,
    `id_fundo`,
    `fecha_orden`,
    `fecha_entrega`,
    `descripcion`,
    `observaciones`,
    `estado`,
    `id_moneda`
  )
VALUES
  (
    1,
    1,
    1,
    1,
    1,
    '2019-10-16 13:02:49',
    '2019-10-16 00:00:00',
    NULL,
    '',
    '0',
    1
  ),
  (
    2,
    1,
    1,
    1,
    1,
    '2019-10-16 14:24:52',
    '2019-10-16 00:00:00',
    NULL,
    '',
    '3',
    1
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_orden_gasto`
--
CREATE TABLE `tb_orden_gasto` (
  `id_orden_gasto` int NOT NULL,
  `id_proveedor` int NOT NULL,
  `id_trabajador` int NOT NULL,
  `id_gasto` int NOT NULL,
  `fecha_gasto` datetime DEFAULT NULL,
  `observaciones` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_moneda` int NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_parametros_generales`
--
CREATE TABLE `tb_parametros_generales` (
  `id_parametro` int NOT NULL,
  `name_parametro` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `valor_int` int NOT NULL DEFAULT '0',
  `valor_string` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `valor_decimal` decimal(8, 2) NOT NULL DEFAULT '0.00',
  `valor_bit` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_parametros_generales`
--
INSERT INTO
  `tb_parametros_generales` (
    `id_parametro`,
    `name_parametro`,
    `valor_int`,
    `valor_string`,
    `valor_decimal`,
    `valor_bit`
  )
VALUES
  (
    1,
    'Imagen Banner 1',
    0,
    'resources/global/images/paginaweb/fondo1.jpg',
    0.00,
    1
  ),
  (
    2,
    'Imagen Banner 2',
    0,
    'resources/global/images/paginaweb/fondo2.jpg',
    0.00,
    1
  ),
  (
    3,
    'Imagen Banner 3',
    0,
    'resources/global/images/paginaweb/fondo3.jpg',
    0.00,
    1
  ),
  (
    4,
    'Titulo Banner 1',
    0,
    'Bienvenidos a Pet Space',
    0.00,
    1
  ),
  (
    5,
    'Titulo Banner 2',
    0,
    'Brinda una mejor atención a tus clientes',
    0.00,
    0
  ),
  (
    6,
    'Titulo Banner 3',
    0,
    'Profesionales altamente calificados',
    0.00,
    1
  ),
  (
    7,
    'Descripcion Banner 1',
    0,
    'Una Plataforma en la cuál podrás administrar tu veterinaria desde cualquier lugar.',
    0.00,
    0
  ),
  (
    8,
    'Descripcion Banner 2',
    0,
    'Así podrás mantenerte en contacto con tus clientes, ofreciendo un valor agregado a tu negocio.',
    0.00,
    0
  ),
  (
    9,
    'Descripcion Banner 3',
    0,
    'Nuestro equipo de profesionales con más de 10 años de experiencia, te brindarán un apoyo constante en todo momento.',
    0.00,
    0
  ),
  (
    10,
    'Texto Boton 1',
    0,
    'Mas información',
    0.00,
    0
  ),
  (
    11,
    'Texto Boton 2',
    0,
    'Mas isnformación',
    0.00,
    0
  ),
  (
    12,
    'Texto Boton 3',
    0,
    'Mas información',
    0.00,
    0
  ),
  (
    13,
    'Enlace banner 1',
    0,
    '?view=conocenos',
    0.00,
    0
  ),
  (
    14,
    'Enlace banner 2',
    0,
    '?view=conocenos',
    0.00,
    0
  ),
  (
    15,
    'Enlace banner 3',
    0,
    '?view=conocenos',
    0.00,
    0
  ),
  (
    16,
    'Horario Top Nav',
    0,
    'Lunes - Sábado 8:00 - 17:00',
    0.00,
    0
  ),
  (
    17,
    'Correo Soporte Técnico',
    0,
    'informes@veterinariamican.com',
    0.00,
    0
  ),
  (18, 'Telefono', 0, '(+51) 930744960', 0.00, 0),
  (
    19,
    'Link Facebook',
    0,
    'https://www.facebook.com',
    0.00,
    0
  ),
  (
    20,
    'Link Instagram',
    0,
    'https://www.instagram.com',
    0.00,
    0
  ),
  (
    21,
    'Link Youtube',
    0,
    'https://www.youtube.com',
    0.00,
    0
  ),
  (
    22,
    'Link Twitter',
    0,
    'https://www.twitter.com',
    0.00,
    0
  ),
  (
    23,
    'Logo Página',
    0,
    'resources/assets-web/img/logo.png',
    0.00,
    0
  ),
  (
    24,
    'Direccion Footer',
    0,
    'Jr. Pedro Remy 177 - SMP - Lima',
    0.00,
    0
  ),
  (25, 'Clientes Felices', 1015, NULL, 0.00, 0),
  (26, 'Proyectos Completados', 12, NULL, 0.00, 0),
  (27, 'Premios Ganados', 15, NULL, 0.00, 0),
  (28, 'Horas Trabajadas', 3050, NULL, 0.00, 0),
  (29, 'Horario Lunes', 0, '8:00 - 18:00', 0.00, 0),
  (30, 'Horario Martes', 0, '8:00 - 18:00', 0.00, 0),
  (
    31,
    'Horario Miercoles',
    0,
    '8:00 - 18:00',
    0.00,
    0
  ),
  (32, 'Horario Jueves', 0, '8:00 - 18:00', 0.00, 0),
  (
    33,
    'Horario Viernes',
    0,
    '8:00 - 18:00',
    0.00,
    0
  ),
  (34, 'Horario Sabado', 0, 'Cerrado', 0.00, 0),
  (35, 'Horario Domingo', 0, 'Cerrado', 0.00, 0),
  (
    36,
    'Descripcion Footer',
    0,
    'Descripcion Footer',
    0.00,
    0
  ),
  (
    37,
    'Mapa Contacto',
    0,
    '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.3688387144507!2d-77.03578688561743!3d-12.086882845937915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c9da03b255e1%3A0xfba2569a5919029a!2sTecnovo+Per%C3%BA!5e0!3m2!1ses-419!2sus!4v1566490062500!5m2!1ses-419!2sus\" width=\"100%\" height=\"500\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>',
    0.00,
    0
  ),
  (38, 'IGV', 0, NULL, 18.00, 0);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_persona`
--
CREATE TABLE `tb_persona` (
  `id_persona` bigint UNSIGNED NOT NULL,
  `id_documento` bigint UNSIGNED NOT NULL,
  `num_documento` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombres` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellidos` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nickname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `direccion` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `telefono` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `correo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` enum('masculino', 'femenino') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'masculino'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_persona`
--
INSERT INTO
  `tb_persona` (
    `id_persona`,
    `id_documento`,
    `num_documento`,
    `nombres`,
    `apellidos`,
    `nickname`,
    `direccion`,
    `telefono`,
    `correo`,
    `fecha_nacimiento`,
    `sexo`
  )
VALUES
  (
    1,
    1,
    '77229532',
    'Zhaúl Alberto',
    'Valdera Vidaurre',
    NULL,
    'JR. PEDRO REMY 177 - URB. INGENERIA - SMP',
    '930744960',
    'ZVALDERA@TECNOVOPER.COM',
    '1995-05-12',
    'masculino'
  ),
  (
    2,
    1,
    '12345678',
    'Luisa Magnolia',
    'Valdera Zurita',
    NULL,
    'Jr. Pedro Remy N 317 - Urbanización Ingenería',
    '987653243',
    'zhaul_aries15@hotmail.com',
    '2000-12-07',
    'femenino'
  ),
  (
    4,
    1,
    '09890978',
    'David',
    'Moreno',
    NULL,
    'Jr. Pedro Remy N 317 - Urbanización Ingenería',
    '987654341',
    'davidmoreno@gmail.com',
    '1989-10-16',
    'masculino'
  ),
  (
    5,
    1,
    '76589746',
    'Irving',
    'Tovar',
    NULL,
    'Jr. Pedro Remy N 317 - Urbanización Ingenería',
    '987654321',
    'irvingtvar@gmail.com',
    '1989-10-16',
    'masculino'
  ),
  (
    7,
    1,
    '45343212',
    'RAUL THOMAS',
    'AGHATA MANRIQUE',
    NULL,
    'AV LOS OLIVOS EN EL PARADERO 50',
    '927828321',
    'RAUL@GMAIL.COM',
    '2003-04-18',
    'masculino'
  ),
  (
    9,
    3,
    '209183838387',
    'SAC',
    'THE DIALEX S',
    NULL,
    'AVENIDA COLOMBIA 203',
    '564657656',
    'DIALEX@GMAIL.COM',
    '2001-04-24',
    'masculino'
  ),
  (
    10,
    1,
    '38274382',
    'Eduardo Daniel',
    'Peralta Cuya',
    'carlos',
    'avv los jardines',
    '978662654',
    'danic@gmail.com',
    '2000-07-19',
    'masculino'
  ),
  (
    11,
    1,
    '70570131',
    'danico',
    'peraleduard',
    NULL,
    'dewwffeferge',
    '243454344',
    'dafegfasda@gmail.com',
    '2024-10-07',
    'masculino'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_proveedor`
--
CREATE TABLE `tb_proveedor` (
  `id_proveedor` int NOT NULL,
  `id_persona` bigint UNSIGNED NOT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `src_imagen` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tb_proveedor`
--
INSERT INTO
  `tb_proveedor` (
    `id_proveedor`,
    `id_persona`,
    `estado`,
    `src_imagen`
  )
VALUES
  (
    1,
    11,
    '1',
    'resources/global/images/sin_imagen.png'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_servicio`
--
CREATE TABLE `tb_servicio` (
  `id_servicio` bigint UNSIGNED NOT NULL,
  `id_tipo_servicio` bigint UNSIGNED NOT NULL,
  `name_servicio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion_breve` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `descripcion_larga` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_moneda` int NOT NULL DEFAULT '1',
  `signo_moneda` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `precio` decimal(8, 2) NOT NULL DEFAULT '0.00',
  `flag_igv` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT '1',
  `src_imagen` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_servicio`
--
INSERT INTO
  `tb_servicio` (
    `id_servicio`,
    `id_tipo_servicio`,
    `name_servicio`,
    `descripcion_breve`,
    `descripcion_larga`,
    `id_moneda`,
    `signo_moneda`,
    `precio`,
    `flag_igv`,
    `src_imagen`,
    `estado`
  )
VALUES
  (
    1,
    1,
    'Protección de hectáreas',
    'Cuidado de las áreas de cosecha frente a amenazas',
    'También se verificará el estado de las plantaciones u observaciones rutinarios',
    1,
    'S/',
    40.00,
    '1',
    'resources/global/images/servicios/img-1727187464.png',
    'activo'
  ),
  (
    2,
    2,
    'Distribución del agua',
    'Monitorear los sistemas de riego ',
    'Observación para posibles reparos en los sistemas de cañerias ubicados dentro de la hectarea',
    1,
    'S/',
    60.00,
    '1',
    'resources/global/images/servicios/img-1727187708.png',
    'activo'
  ),
  (
    3,
    7,
    'Reparación rutinaria',
    'Observación y mantenimiento de maquinarias',
    '',
    2,
    '$',
    60.00,
    '1',
    'resources/global/images/servicios/img-1571244228.png',
    'activo'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_tipo_cambio`
--
CREATE TABLE `tb_tipo_cambio` (
  `id` int NOT NULL,
  `id_moneda` int NOT NULL,
  `name_user` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `tipo_cambio` decimal(18, 3) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tb_tipo_cambio`
--
INSERT INTO
  `tb_tipo_cambio` (
    `id`,
    `id_moneda`,
    `name_user`,
    `fecha`,
    `tipo_cambio`
  )
VALUES
  (1, 2, 'zhaul', '2019-10-16 11:33:38', 3.350),
  (2, 3, 'zhaul', '2019-10-16 11:33:44', 3.750);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_tipo_cosecha`
--
CREATE TABLE `tb_tipo_cosecha` (
  `id_tipo_cosecha` bigint UNSIGNED NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tb_tipo_cosecha`
--
INSERT INTO
  `tb_tipo_cosecha` (`id_tipo_cosecha`, `descripcion`, `estado`)
VALUES
  (2, 'gamndes', ''),
  (3, 'GRANDES', 'activo');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_tipo_gasto`
--
CREATE TABLE `tb_tipo_gasto` (
  `id_tipo_gasto` bigint UNSIGNED NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tb_tipo_gasto`
--
INSERT INTO
  `tb_tipo_gasto` (`id_tipo_gasto`, `descripcion`, `estado`)
VALUES
  (3, 'MANTENIMIENTO DE MAQUINA', 'activo'),
  (4, 'CAMIONETA', 'activo');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_tipo_servicio`
--
CREATE TABLE `tb_tipo_servicio` (
  `id_tipo_servicio` bigint UNSIGNED NOT NULL,
  `name_tipo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_tipo_servicio`
--
INSERT INTO
  `tb_tipo_servicio` (`id_tipo_servicio`, `name_tipo`, `estado`)
VALUES
  (1, 'MANTENIMIENTO HTC', 'activo'),
  (2, 'REPARACIÓN DE CAÑERIAS', 'activo'),
  (7, 'MANTENIMIENTO MAQUINARIA', 'activo');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_trabajador`
--
CREATE TABLE `tb_trabajador` (
  `id_trabajador` bigint UNSIGNED NOT NULL,
  `id_persona` bigint UNSIGNED NOT NULL,
  `id_grupo` bigint UNSIGNED NOT NULL,
  `name_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `pass_user` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `cod_recuperacion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fecha_activacion` date DEFAULT NULL,
  `fecha_recuperacion` date DEFAULT NULL,
  `src_imagen` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo',
  `flag_medico` tinyint(1) NOT NULL DEFAULT '0',
  `link_facebook` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `link_instagram` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `link_twitter` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `descripcion` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_trabajador`
--
INSERT INTO
  `tb_trabajador` (
    `id_trabajador`,
    `id_persona`,
    `id_grupo`,
    `name_user`,
    `pass_user`,
    `cod_recuperacion`,
    `fecha_activacion`,
    `fecha_recuperacion`,
    `src_imagen`,
    `estado`,
    `flag_medico`,
    `link_facebook`,
    `link_instagram`,
    `link_twitter`,
    `descripcion`
  )
VALUES
  (
    1,
    1,
    1,
    'zhaul',
    'e67f455a5414e8f58488ae39fe9e7f76',
    NULL,
    '2019-06-10',
    NULL,
    'resources/global/images/persons/zhaul-1571241993.png',
    'activo',
    0,
    '#',
    '#',
    '#',
    ''
  ),
  (
    2,
    4,
    1,
    'davidmoreno@gmail.com',
    '1dd4ecb6f7f0091bc464fee9b9202d59',
    NULL,
    '2019-10-16',
    NULL,
    'resources/global/images/persons/img-1727713943.png',
    'activo',
    0,
    '',
    '',
    '',
    'Profesional muy destacado en el ambiente laboral, se caracteriza por su habilidad de comunicar al cliente.'
  ),
  (
    3,
    5,
    1,
    'irvingtovar@gmail.com',
    '1dd4ecb6f7f0091bc464fee9b9202d59',
    NULL,
    '2019-10-16',
    NULL,
    'resources/global/images/persons/img-1571246677.png',
    'activo',
    0,
    '',
    '',
    '',
    'Su área de competencia es medicina interna y cirugía de tejidos blandos, con especial dedicación a la reproducción canina y endocrinóloga.'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_trabajador_servicio`
--
CREATE TABLE `tb_trabajador_servicio` (
  `id` bigint UNSIGNED NOT NULL,
  `id_servicio` bigint UNSIGNED NOT NULL,
  `id_trabajador` bigint UNSIGNED NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_trabajador_sucursal`
--
CREATE TABLE `tb_trabajador_sucursal` (
  `id` bigint NOT NULL,
  `id_trabajador` bigint UNSIGNED DEFAULT NULL,
  `id_fundo` int DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_unidad_medida`
--
CREATE TABLE `tb_unidad_medida` (
  `id_unidad_medida` int NOT NULL,
  `name_unidad` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_sunat` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_venta`
--
CREATE TABLE `tb_venta` (
  `id_venta` int NOT NULL,
  `id_fundo` int NOT NULL,
  `id_trabajador` bigint UNSIGNED NOT NULL,
  `id_documento_venta` int NOT NULL,
  `name_documento_venta` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_documento_venta` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correlativo` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_documento_cliente` bigint UNSIGNED NOT NULL,
  `name_documento_cliente` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_documento_cliente` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_documento_cliente` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_forma_pago` int NOT NULL,
  `codigo_forma_pago` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_forma_pago` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
  `descuento_total` decimal(18, 2) DEFAULT '0.00',
  `sub_total` decimal(18, 2) NOT NULL,
  `igv` decimal(18, 2) NOT NULL,
  `total` decimal(18, 2) NOT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `pdf` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xml` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cdr` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mensaje_sunat` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruta` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag_doc_interno` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `monto_recibido` decimal(18, 2) DEFAULT NULL,
  `vuelto` decimal(18, 2) DEFAULT NULL,
  `id_moneda` int NOT NULL,
  `codigo_moneda` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `signo_moneda` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abreviatura_moneda` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signo_moneda_cambio` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'S/ ',
  `monto_tipo_cambio` decimal(18, 2) DEFAULT NULL,
  `observaciones` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag_enviado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tb_venta`
--
INSERT INTO
  `tb_venta` (
    `id_venta`,
    `id_fundo`,
    `id_trabajador`,
    `id_documento_venta`,
    `name_documento_venta`,
    `codigo_documento_venta`,
    `serie`,
    `correlativo`,
    `id_documento_cliente`,
    `name_documento_cliente`,
    `codigo_documento_cliente`,
    `numero_documento_cliente`,
    `id_forma_pago`,
    `codigo_forma_pago`,
    `name_forma_pago`,
    `cliente`,
    `direccion`,
    `telefono`,
    `correo`,
    `fecha`,
    `fecha_vencimiento`,
    `descuento_total`,
    `sub_total`,
    `igv`,
    `total`,
    `estado`,
    `pdf`,
    `xml`,
    `cdr`,
    `mensaje_sunat`,
    `ruta`,
    `token`,
    `flag_doc_interno`,
    `monto_recibido`,
    `vuelto`,
    `id_moneda`,
    `codigo_moneda`,
    `signo_moneda`,
    `abreviatura_moneda`,
    `signo_moneda_cambio`,
    `monto_tipo_cambio`,
    `observaciones`,
    `flag_enviado`
  )
VALUES
  (
    1,
    1,
    1,
    1,
    'BOLETA',
    '2',
    'BPP1',
    '1',
    1,
    'DNI',
    '1',
    '12345678',
    1,
    '01',
    'EFECTIVO',
    'Luisa Magnolia Valdera Zurita',
    'Jr. Pedro Remy N 317 - Urbanización Ingenería',
    '987654321',
    'zhaul_aries15@hotmail.com',
    '2019-10-16 00:00:00',
    NULL,
    0.00,
    1426.91,
    256.84,
    1683.75,
    '2',
    'https://www.pse.pe/cpe/b8bd5e9b-1ba7-4618-9a82-70c0ca8df487-e28e10e8-a836-469c-8540-ed8f0c8bf2b1.pdf',
    'https://www.pse.pe/cpe/b8bd5e9b-1ba7-4618-9a82-70c0ca8df487-e28e10e8-a836-469c-8540-ed8f0c8bf2b1.xml',
    'https://www.pse.pe/cpe/b8bd5e9b-1ba7-4618-9a82-70c0ca8df487-e28e10e8-a836-469c-8540-ed8f0c8bf2b1.cdr',
    NULL,
    'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4',
    'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc',
    '0',
    1683.75,
    0.00,
    1,
    '1',
    'S/',
    'PEN',
    'S/ ',
    1.00,
    NULL,
    '1'
  );

-- --------------------------------------------------------
--
-- Estructura Stand-in para la vista `vw_clientes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_clientes` (
  `id_cliente` bigint unsigned,
  `id_persona` bigint unsigned,
  `src_imagen` varchar(500),
  `estado` enum('activo', 'inactivo'),
  `id_documento` bigint unsigned,
  `num_documento` varchar(30),
  `nombres_cliente` varchar(100),
  `apellidos_cliente` varchar(100),
  `direccion_cliente` varchar(150),
  `telefono_cliente` varchar(30),
  `correo_cliente` varchar(150),
  `fecha_nacimiento_cliente` date,
  `sexo_cliente` enum('masculino', 'femenino'),
  `name_documento` varchar(100)
);

-- --------------------------------------------------------
--
-- Estructura Stand-in para la vista `vw_orden_gasto`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_orden_gasto` ();

-- --------------------------------------------------------
--
-- Estructura Stand-in para la vista `vw_proveedores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_proveedores` (
  `id_proveedor` int,
  `id_persona_proveedor` bigint unsigned,
  `estado_proveedor` char(1),
  `id_documento_proveedor` bigint unsigned,
  `num_documento_proveedor` varchar(30),
  `nombre_proveedor` varchar(201),
  `direccion_proveedor` varchar(150),
  `telefono_proveedor` varchar(30),
  `correo_proveedor` varchar(150),
  `fecha_nacimiento_proveedor` date,
  `sexo_proveedor` enum('masculino', 'femenino'),
  `src_imagen_proveedor` varchar(300)
);

-- --------------------------------------------------------
--
-- Estructura Stand-in para la vista `vw_trabajadores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_trabajadores` ();

-- --------------------------------------------------------
--
-- Estructura para la vista `vw_clientes`
--
DROP TABLE IF EXISTS `vw_clientes`;

CREATE ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `vw_clientes` AS
SELECT
  `t`.`id_cliente` AS `id_cliente`,
  `t`.`id_persona` AS `id_persona`,
  `t`.`src_imagen` AS `src_imagen`,
  `t`.`estado` AS `estado`,
  `p`.`id_documento` AS `id_documento`,
  `p`.`num_documento` AS `num_documento`,
  `p`.`nombres` AS `nombres_cliente`,
  `p`.`apellidos` AS `apellidos_cliente`,
  `p`.`direccion` AS `direccion_cliente`,
  `p`.`telefono` AS `telefono_cliente`,
  `p`.`correo` AS `correo_cliente`,
  `p`.`fecha_nacimiento` AS `fecha_nacimiento_cliente`,
  `p`.`sexo` AS `sexo_cliente`,
  `d`.`name_documento` AS `name_documento`
FROM
  (
    (
      `tb_cliente` `t`
      join `tb_persona` `p` on((`p`.`id_persona` = `t`.`id_persona`))
    )
    join `tb_documento_identidad` `d` on((`d`.`id_documento` = `p`.`id_documento`))
  );

-- --------------------------------------------------------
--
-- Estructura para la vista `vw_orden_gasto`
--
DROP TABLE IF EXISTS `vw_orden_gasto`;

CREATE ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `vw_orden_gasto` AS
SELECT
  `og`.`id_orden_gasto` AS `id_orden_gasto`,
  `p`.`id_proveedor` AS `id_proveedor`,
  `p`.`nombre_proveedor` AS `nombre_proveedor`,
  `p`.`src_imagen_proveedor` AS `src_imagen_proveedor`,
  `og`.`fecha_gasto` AS `fecha_gasto`,
  `og`.`observaciones` AS `observaciones`,
  `m`.`id_moneda` AS `id_moneda`,
  `g`.`id_gasto` AS `id_gasto`,
  `g`.`name_gasto` AS `name_gasto`,
  `og`.`precio_unit` AS `precio`,
  `og`.`cantidad_ga` AS `cantidad_solicitada`,
  (`og`.`precio_unit` * `og`.`cantidad_ga`) AS `total`
FROM
  (
    (
      (
        `tb_orden_gasto` `og`
        join `vw_proveedores` `p` on((`og`.`id_proveedor` = `p`.`id_proveedor`))
      )
      join `tb_moneda` `m` on((`og`.`id_moneda` = `m`.`id_moneda`))
    )
    join `tb_gasto` `g` on((`og`.`id_gasto` = `g`.`id_gasto`))
  );

-- --------------------------------------------------------
--
-- Estructura para la vista `vw_proveedores`
--
DROP TABLE IF EXISTS `vw_proveedores`;

CREATE ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `vw_proveedores` AS
SELECT
  `pr`.`id_proveedor` AS `id_proveedor`,
  `pr`.`id_persona` AS `id_persona_proveedor`,
  `pr`.`estado` AS `estado_proveedor`,
  `p`.`id_documento` AS `id_documento_proveedor`,
  `p`.`num_documento` AS `num_documento_proveedor`,
  concat(`p`.`nombres`, ' ', `p`.`apellidos`) AS `nombre_proveedor`,
  `p`.`direccion` AS `direccion_proveedor`,
  `p`.`telefono` AS `telefono_proveedor`,
  `p`.`correo` AS `correo_proveedor`,
  `p`.`fecha_nacimiento` AS `fecha_nacimiento_proveedor`,
  `p`.`sexo` AS `sexo_proveedor`,
  `pr`.`src_imagen` AS `src_imagen_proveedor`
FROM
  (
    `tb_proveedor` `pr`
    join `tb_persona` `p` on((`pr`.`id_persona` = `p`.`id_persona`))
  );

-- --------------------------------------------------------
--
-- Estructura para la vista `vw_trabajadores`
--
DROP TABLE IF EXISTS `vw_trabajadores`;

CREATE ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `vw_trabajadores` AS
SELECT
  `t`.`id_trabajador` AS `id_trabajador`,
  `t`.`id_persona` AS `id_persona`,
  `t`.`id_grupo` AS `id_grupo`,
  `t`.`id_especialidad` AS `id_especialidad`,
  `t`.`name_user` AS `name_user`,
  `t`.`pass_user` AS `pass_user`,
  `t`.`cod_recuperacion` AS `cod_recuperacion`,
  `t`.`fecha_activacion` AS `fecha_activacion`,
  `t`.`fecha_recuperacion` AS `fecha_recuperacion`,
  `t`.`src_imagen` AS `src_imagen`,
  `t`.`estado` AS `estado`,
  `t`.`flag_medico` AS `flag_medico`,
  `t`.`link_facebook` AS `link_facebook`,
  `t`.`link_instagram` AS `link_instagram`,
  `t`.`link_twitter` AS `link_twitter`,
  `t`.`descripcion` AS `descripcion`,
  `p`.`id_documento` AS `id_documento`,
  `p`.`num_documento` AS `num_documento`,
  `p`.`nombres` AS `nombres_trabajador`,
  `p`.`apellidos` AS `apellidos_trabajador`,
  `p`.`direccion` AS `direccion_trabajador`,
  `p`.`telefono` AS `telefono_trabajador`,
  `p`.`correo` AS `correo_trabajador`,
  `p`.`fecha_nacimiento` AS `fecha_nacimiento_trabajador`,
  `p`.`sexo` AS `sexo_trabajador`,
  `d`.`name_documento` AS `name_documento_trabajador`
FROM
  (
    (
      `tb_trabajador` `t`
      join `tb_persona` `p` on((`p`.`id_persona` = `t`.`id_persona`))
    )
    join `tb_documento_identidad` `d` on((`d`.`id_documento` = `p`.`id_documento`))
  );

--
-- Índices para tablas volcadas
--
--
-- Indices de la tabla `tb_accesorio`
--
ALTER TABLE
  `tb_accesorio`
ADD
  PRIMARY KEY (`id_accesorio`),
ADD
  KEY `tb_accesorio_id_categoria_foreign` (`id_categoria`),
ADD
  KEY `id_sucursal` (`id_fundo`),
ADD
  KEY `id_unidad_medida` (`id_unidad_medida`),
ADD
  KEY `id_moneda` (`id_moneda`);

--
-- Indices de la tabla `tb_acceso_opcion`
--
ALTER TABLE
  `tb_acceso_opcion`
ADD
  PRIMARY KEY (`id`),
ADD
  KEY `tb_acceso_opcion_id_grupo_foreign` (`id_grupo`),
ADD
  KEY `tb_acceso_opcion_id_opcion_foreign` (`id_opcion`);

--
-- Indices de la tabla `tb_categoria_accesorio`
--
ALTER TABLE
  `tb_categoria_accesorio`
ADD
  PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `tb_cliente`
--
ALTER TABLE
  `tb_cliente`
ADD
  PRIMARY KEY (`id_cliente`),
ADD
  KEY `tb_cliente_id_persona_foreign` (`id_persona`);

--
-- Indices de la tabla `tb_cliente_fundo`
--
ALTER TABLE
  `tb_cliente_fundo`
ADD
  PRIMARY KEY (`id`),
ADD
  KEY `id_cliente` (`id_cliente`),
ADD
  KEY `id_fundo` (`id_fundo`);

--
-- Indices de la tabla `tb_compra`
--
ALTER TABLE
  `tb_compra`
ADD
  PRIMARY KEY (`id_compra`),
ADD
  UNIQUE KEY `id_compra` (`id_compra`),
ADD
  KEY `id_sucursal` (`id_fundo`),
ADD
  KEY `id_trabajador` (`id_trabajador`),
ADD
  KEY `id_documento_venta` (`id_documento_compra`),
ADD
  KEY `id_documento_proveedor` (`id_documento_proveedor`),
ADD
  KEY `id_forma_pago` (`id_forma_pago`),
ADD
  KEY `id_moneda` (`id_moneda`);

--
-- Indices de la tabla `tb_detalle_compra`
--
ALTER TABLE
  `tb_detalle_compra`
ADD
  PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `tb_detalle_gasto`
--
ALTER TABLE
  `tb_detalle_gasto`
ADD
  PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `tb_detalle_ingreso`
--
ALTER TABLE
  `tb_detalle_ingreso`
ADD
  PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `tb_detalle_venta`
--
ALTER TABLE
  `tb_detalle_venta`
ADD
  PRIMARY KEY (`id_detalle`),
ADD
  KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `tb_documento_identidad`
--
ALTER TABLE
  `tb_documento_identidad`
ADD
  PRIMARY KEY (`id_documento`);

--
-- Indices de la tabla `tb_documento_venta`
--
ALTER TABLE
  `tb_documento_venta`
ADD
  PRIMARY KEY (`id_documento_venta`),
ADD
  KEY `id_sucursal` (`id_fundo`);

--
-- Indices de la tabla `tb_empresa`
--
ALTER TABLE
  `tb_empresa`
ADD
  PRIMARY KEY (`id_empresa`),
ADD
  KEY `tb_empresa_id_documento_num_documento_index` (`id_documento`, `num_documento`),
ADD
  KEY `tb_empresa_id_documento_representante_foreign` (`id_documento_representante`);

--
-- Indices de la tabla `tb_forma_pago`
--
ALTER TABLE
  `tb_forma_pago`
ADD
  PRIMARY KEY (`id_forma_pago`);

--
-- Indices de la tabla `tb_fundo`
--
ALTER TABLE
  `tb_fundo`
ADD
  PRIMARY KEY (`id_fundo`),
ADD
  KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tb_galeria`
--
ALTER TABLE
  `tb_galeria`
ADD
  PRIMARY KEY (`id`);

--
-- Indices de la tabla `tb_gasto`
--
ALTER TABLE
  `tb_gasto`
ADD
  PRIMARY KEY (`id_gasto`),
ADD
  KEY `id_tipo_gasto` (`id_tipo_gasto`);

--
-- Indices de la tabla `tb_grupo_usuario`
--
ALTER TABLE
  `tb_grupo_usuario`
ADD
  PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `tb_ingreso`
--
ALTER TABLE
  `tb_ingreso`
ADD
  PRIMARY KEY (`id_ingreso`);

--
-- Indices de la tabla `tb_ingreso_gasto`
--
ALTER TABLE
  `tb_ingreso_gasto`
ADD
  PRIMARY KEY (`id_ingreso_gasto`);

--
-- Indices de la tabla `tb_maquinaria`
--
ALTER TABLE
  `tb_maquinaria`
ADD
  PRIMARY KEY (`id_maquinaria`);

--
-- Indices de la tabla `tb_metodo_envio`
--
ALTER TABLE
  `tb_metodo_envio`
ADD
  PRIMARY KEY (`id_metodo_envio`);

--
-- Indices de la tabla `tb_moneda`
--
ALTER TABLE
  `tb_moneda`
ADD
  PRIMARY KEY (`id_moneda`);

--
-- Indices de la tabla `tb_opcion`
--
ALTER TABLE
  `tb_opcion`
ADD
  PRIMARY KEY (`id_opcion`);

--
-- Indices de la tabla `tb_operador`
--
ALTER TABLE
  `tb_operador`
ADD
  PRIMARY KEY (`id_operador`),
ADD
  KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `tb_orden_compra`
--
ALTER TABLE
  `tb_orden_compra`
ADD
  PRIMARY KEY (`id_orden_compra`);

--
-- Indices de la tabla `tb_orden_gasto`
--
ALTER TABLE
  `tb_orden_gasto`
ADD
  PRIMARY KEY (`id_orden_gasto`),
ADD
  KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `tb_parametros_generales`
--
ALTER TABLE
  `tb_parametros_generales`
ADD
  PRIMARY KEY (`id_parametro`);

--
-- Indices de la tabla `tb_persona`
--
ALTER TABLE
  `tb_persona`
ADD
  PRIMARY KEY (`id_persona`),
ADD
  KEY `tb_persona_id_documento_num_documento_index` (`id_documento`, `num_documento`);

--
-- Indices de la tabla `tb_proveedor`
--
ALTER TABLE
  `tb_proveedor`
ADD
  PRIMARY KEY (`id_proveedor`),
ADD
  KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `tb_servicio`
--
ALTER TABLE
  `tb_servicio`
ADD
  PRIMARY KEY (`id_servicio`),
ADD
  KEY `fk_tbtiposervicio_servicio` (`id_tipo_servicio`),
ADD
  KEY `id_moneda` (`id_moneda`);

--
-- Indices de la tabla `tb_tipo_cambio`
--
ALTER TABLE
  `tb_tipo_cambio`
ADD
  PRIMARY KEY (`id`),
ADD
  KEY `id_moneda` (`id_moneda`);

--
-- Indices de la tabla `tb_tipo_cosecha`
--
ALTER TABLE
  `tb_tipo_cosecha`
ADD
  PRIMARY KEY (`id_tipo_cosecha`);

--
-- Indices de la tabla `tb_tipo_gasto`
--
ALTER TABLE
  `tb_tipo_gasto`
ADD
  PRIMARY KEY (`id_tipo_gasto`);

--
-- Indices de la tabla `tb_tipo_servicio`
--
ALTER TABLE
  `tb_tipo_servicio`
ADD
  PRIMARY KEY (`id_tipo_servicio`);

--
-- Indices de la tabla `tb_trabajador`
--
ALTER TABLE
  `tb_trabajador`
ADD
  PRIMARY KEY (`id_trabajador`),
ADD
  UNIQUE KEY `tb_trabajador_name_user_unique` (`name_user`),
ADD
  KEY `fk_tbpersona_tb_trabajador` (`id_persona`),
ADD
  KEY `fktb_trabajador_tbgrupousuario` (`id_grupo`);

--
-- Indices de la tabla `tb_trabajador_servicio`
--
ALTER TABLE
  `tb_trabajador_servicio`
ADD
  PRIMARY KEY (`id`),
ADD
  KEY `tb_trabajador_servicio_id_servicio_foreign` (`id_servicio`),
ADD
  KEY `tb_trabajador_servicio_id_trabajador_foreign` (`id_trabajador`);

--
-- Indices de la tabla `tb_trabajador_sucursal`
--
ALTER TABLE
  `tb_trabajador_sucursal`
ADD
  PRIMARY KEY (`id`),
ADD
  KEY `id_trabajador` (`id_trabajador`),
ADD
  KEY `id_sucursal` (`id_fundo`);

--
-- Indices de la tabla `tb_unidad_medida`
--
ALTER TABLE
  `tb_unidad_medida`
ADD
  PRIMARY KEY (`id_unidad_medida`);

--
-- Indices de la tabla `tb_venta`
--
ALTER TABLE
  `tb_venta`
ADD
  PRIMARY KEY (`id_venta`),
ADD
  UNIQUE KEY `id_venta` (`id_venta`),
ADD
  KEY `id_sucursal` (`id_fundo`),
ADD
  KEY `id_trabajador` (`id_trabajador`),
ADD
  KEY `id_documento_venta` (`id_documento_venta`),
ADD
  KEY `id_documento_cliente` (`id_documento_cliente`),
ADD
  KEY `id_forma_pago` (`id_forma_pago`),
ADD
  KEY `id_moneda` (`id_moneda`);

--
-- AUTO_INCREMENT de las tablas volcadas
--
--
-- AUTO_INCREMENT de la tabla `tb_accesorio`
--
ALTER TABLE
  `tb_accesorio`
MODIFY
  `id_accesorio` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 9;

--
-- AUTO_INCREMENT de la tabla `tb_acceso_opcion`
--
ALTER TABLE
  `tb_acceso_opcion`
MODIFY
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 432;

--
-- AUTO_INCREMENT de la tabla `tb_categoria_accesorio`
--
ALTER TABLE
  `tb_categoria_accesorio`
MODIFY
  `id_categoria` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT de la tabla `tb_cliente`
--
ALTER TABLE
  `tb_cliente`
MODIFY
  `id_cliente` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de la tabla `tb_cliente_fundo`
--
ALTER TABLE
  `tb_cliente_fundo`
MODIFY
  `id` bigint NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 43;

--
-- AUTO_INCREMENT de la tabla `tb_compra`
--
ALTER TABLE
  `tb_compra`
MODIFY
  `id_compra` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_compra`
--
ALTER TABLE
  `tb_detalle_compra`
MODIFY
  `id_detalle` bigint NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 25;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_gasto`
--
ALTER TABLE
  `tb_detalle_gasto`
MODIFY
  `id_detalle` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_ingreso`
--
ALTER TABLE
  `tb_detalle_ingreso`
MODIFY
  `id_detalle` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_documento_identidad`
--
ALTER TABLE
  `tb_documento_identidad`
MODIFY
  `id_documento` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT de la tabla `tb_documento_venta`
--
ALTER TABLE
  `tb_documento_venta`
MODIFY
  `id_documento_venta` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de la tabla `tb_empresa`
--
ALTER TABLE
  `tb_empresa`
MODIFY
  `id_empresa` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT de la tabla `tb_forma_pago`
--
ALTER TABLE
  `tb_forma_pago`
MODIFY
  `id_forma_pago` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT de la tabla `tb_fundo`
--
ALTER TABLE
  `tb_fundo`
MODIFY
  `id_fundo` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 10;

--
-- AUTO_INCREMENT de la tabla `tb_galeria`
--
ALTER TABLE
  `tb_galeria`
MODIFY
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT de la tabla `tb_gasto`
--
ALTER TABLE
  `tb_gasto`
MODIFY
  `id_gasto` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT de la tabla `tb_grupo_usuario`
--
ALTER TABLE
  `tb_grupo_usuario`
MODIFY
  `id_grupo` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de la tabla `tb_ingreso_gasto`
--
ALTER TABLE
  `tb_ingreso_gasto`
MODIFY
  `id_ingreso_gasto` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_maquinaria`
--
ALTER TABLE
  `tb_maquinaria`
MODIFY
  `id_maquinaria` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT de la tabla `tb_moneda`
--
ALTER TABLE
  `tb_moneda`
MODIFY
  `id_moneda` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de la tabla `tb_operador`
--
ALTER TABLE
  `tb_operador`
MODIFY
  `id_operador` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT de la tabla `tb_orden_gasto`
--
ALTER TABLE
  `tb_orden_gasto`
MODIFY
  `id_orden_gasto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_persona`
--
ALTER TABLE
  `tb_persona`
MODIFY
  `id_persona` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 13;

--
-- AUTO_INCREMENT de la tabla `tb_proveedor`
--
ALTER TABLE
  `tb_proveedor`
MODIFY
  `id_proveedor` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT de la tabla `tb_servicio`
--
ALTER TABLE
  `tb_servicio`
MODIFY
  `id_servicio` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT de la tabla `tb_tipo_cambio`
--
ALTER TABLE
  `tb_tipo_cambio`
MODIFY
  `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT de la tabla `tb_tipo_cosecha`
--
ALTER TABLE
  `tb_tipo_cosecha`
MODIFY
  `id_tipo_cosecha` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 7;

--
-- AUTO_INCREMENT de la tabla `tb_tipo_gasto`
--
ALTER TABLE
  `tb_tipo_gasto`
MODIFY
  `id_tipo_gasto` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT de la tabla `tb_tipo_servicio`
--
ALTER TABLE
  `tb_tipo_servicio`
MODIFY
  `id_tipo_servicio` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 11;

--
-- AUTO_INCREMENT de la tabla `tb_trabajador`
--
ALTER TABLE
  `tb_trabajador`
MODIFY
  `id_trabajador` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT de la tabla `tb_trabajador_servicio`
--
ALTER TABLE
  `tb_trabajador_servicio`
MODIFY
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT de la tabla `tb_trabajador_sucursal`
--
ALTER TABLE
  `tb_trabajador_sucursal`
MODIFY
  `id` bigint NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de la tabla `tb_unidad_medida`
--
ALTER TABLE
  `tb_unidad_medida`
MODIFY
  `id_unidad_medida` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de la tabla `tb_venta`
--
ALTER TABLE
  `tb_venta`
MODIFY
  `id_venta` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- Restricciones para tablas volcadas
--
--
-- Filtros para la tabla `tb_accesorio`
--
ALTER TABLE
  `tb_accesorio`
ADD
  CONSTRAINT `tb_accesorio_ibfk_3` FOREIGN KEY (`id_unidad_medida`) REFERENCES `tb_unidad_medida` (`id_unidad_medida`),
ADD
  CONSTRAINT `tb_accesorio_ibfk_4` FOREIGN KEY (`id_fundo`) REFERENCES `tb_fundo` (`id_fundo`),
ADD
  CONSTRAINT `tb_accesorio_ibfk_5` FOREIGN KEY (`id_moneda`) REFERENCES `tb_moneda` (`id_moneda`),
ADD
  CONSTRAINT `tb_accesorio_id_categoria_foreign` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria_accesorio` (`id_categoria`);

--
-- Filtros para la tabla `tb_acceso_opcion`
--
ALTER TABLE
  `tb_acceso_opcion`
ADD
  CONSTRAINT `tb_acceso_opcion_id_grupo_foreign` FOREIGN KEY (`id_grupo`) REFERENCES `tb_grupo_usuario` (`id_grupo`),
ADD
  CONSTRAINT `tb_acceso_opcion_id_opcion_foreign` FOREIGN KEY (`id_opcion`) REFERENCES `tb_opcion` (`id_opcion`);

--
-- Filtros para la tabla `tb_cliente`
--
ALTER TABLE
  `tb_cliente`
ADD
  CONSTRAINT `tb_cliente_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`);

--
-- Filtros para la tabla `tb_cliente_fundo`
--
ALTER TABLE
  `tb_cliente_fundo`
ADD
  CONSTRAINT `tb_cliente_fundo_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `tb_cliente_fundo_ibfk_2` FOREIGN KEY (`id_fundo`) REFERENCES `tb_fundo` (`id_fundo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_compra`
--
ALTER TABLE
  `tb_compra`
ADD
  CONSTRAINT `tb_compra_ibfk_1` FOREIGN KEY (`id_fundo`) REFERENCES `tb_fundo` (`id_fundo`),
ADD
  CONSTRAINT `tb_compra_ibfk_2` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

--
-- Filtros para la tabla `tb_detalle_venta`
--
ALTER TABLE
  `tb_detalle_venta`
ADD
  CONSTRAINT `tb_detalle_venta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `tb_venta` (`id_venta`);

--
-- Filtros para la tabla `tb_documento_venta`
--
ALTER TABLE
  `tb_documento_venta`
ADD
  CONSTRAINT `tb_documento_venta_ibfk_1` FOREIGN KEY (`id_fundo`) REFERENCES `tb_fundo` (`id_fundo`);

--
-- Filtros para la tabla `tb_empresa`
--
ALTER TABLE
  `tb_empresa`
ADD
  CONSTRAINT `tb_empresa_id_documento_foreign` FOREIGN KEY (`id_documento`) REFERENCES `tb_documento_identidad` (`id_documento`),
ADD
  CONSTRAINT `tb_empresa_id_documento_representante_foreign` FOREIGN KEY (`id_documento_representante`) REFERENCES `tb_documento_identidad` (`id_documento`);

--
-- Filtros para la tabla `tb_fundo`
--
ALTER TABLE
  `tb_fundo`
ADD
  CONSTRAINT `tb_fundo_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `tb_empresa` (`id_empresa`);

--
-- Filtros para la tabla `tb_gasto`
--
ALTER TABLE
  `tb_gasto`
ADD
  CONSTRAINT `tb_gasto_ibfk_1` FOREIGN KEY (`id_tipo_gasto`) REFERENCES `tb_tipo_gasto` (`id_tipo_gasto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_operador`
--
ALTER TABLE
  `tb_operador`
ADD
  CONSTRAINT `tb_operador_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_orden_gasto`
--
ALTER TABLE
  `tb_orden_gasto`
ADD
  CONSTRAINT `tb_orden_gasto_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `tb_proveedor` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_persona`
--
ALTER TABLE
  `tb_persona`
ADD
  CONSTRAINT `fk_tbpersona_documento_ident` FOREIGN KEY (`id_documento`) REFERENCES `tb_documento_identidad` (`id_documento`);

--
-- Filtros para la tabla `tb_proveedor`
--
ALTER TABLE
  `tb_proveedor`
ADD
  CONSTRAINT `tb_proveedor_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_servicio`
--
ALTER TABLE
  `tb_servicio`
ADD
  CONSTRAINT `fk_tbtiposervicio_servicio` FOREIGN KEY (`id_tipo_servicio`) REFERENCES `tb_tipo_servicio` (`id_tipo_servicio`),
ADD
  CONSTRAINT `tb_servicio_ibfk_1` FOREIGN KEY (`id_moneda`) REFERENCES `tb_moneda` (`id_moneda`);

--
-- Filtros para la tabla `tb_tipo_cambio`
--
ALTER TABLE
  `tb_tipo_cambio`
ADD
  CONSTRAINT `tb_tipo_cambio_ibfk_1` FOREIGN KEY (`id_moneda`) REFERENCES `tb_moneda` (`id_moneda`);

--
-- Filtros para la tabla `tb_trabajador`
--
ALTER TABLE
  `tb_trabajador`
ADD
  CONSTRAINT `fk_tbpersona_tb_trabajador` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`),
ADD
  CONSTRAINT `fktb_trabajador_tbgrupousuario` FOREIGN KEY (`id_grupo`) REFERENCES `tb_grupo_usuario` (`id_grupo`);

--
-- Filtros para la tabla `tb_trabajador_servicio`
--
ALTER TABLE
  `tb_trabajador_servicio`
ADD
  CONSTRAINT `tb_trabajador_servicio_id_servicio_foreign` FOREIGN KEY (`id_servicio`) REFERENCES `tb_servicio` (`id_servicio`),
ADD
  CONSTRAINT `tb_trabajador_servicio_id_trabajador_foreign` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

--
-- Filtros para la tabla `tb_venta`
--
ALTER TABLE
  `tb_venta`
ADD
  CONSTRAINT `tb_venta_ibfk_1` FOREIGN KEY (`id_fundo`) REFERENCES `tb_fundo` (`id_fundo`),
ADD
  CONSTRAINT `tb_venta_ibfk_2` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;