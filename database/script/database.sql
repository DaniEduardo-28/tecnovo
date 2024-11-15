-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 16, 2019 at 07:30 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.11
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET
  AUTOCOMMIT = 0;

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
-- Database: `mican`
--
-- --------------------------------------------------------
--
-- Table structure for table `tb_accesorio`
--
CREATE TABLE `tb_accesorio` (
  `id_accesorio` bigint(20) UNSIGNED NOT NULL,
  `id_sucursal` int(11) NOT NULL DEFAULT '1',
  `id_categoria` bigint(20) UNSIGNED NOT NULL,
  `id_unidad_medida` int(11) NOT NULL DEFAULT '1',
  `name_accesorio` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(1000) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  `stock_minimo` int(11) NOT NULL DEFAULT '0',
  `precio_compra` double(8, 2) NOT NULL DEFAULT '0.00',
  `id_moneda` int(11) NOT NULL DEFAULT '1',
  `signo_moneda` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'S/',
  `precio_venta` double(8, 2) NOT NULL DEFAULT '0.00',
  `flag_igv` char(1) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '1',
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo',
  `src_imagen` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_accesorio`
--
INSERT INTO
  `tb_accesorio` (
    `id_accesorio`,
    `id_sucursal`,
    `id_categoria`,
    `id_unidad_medida`,
    `name_accesorio`,
    `descripcion`,
    `stock`,
    `stock_minimo`,
    `precio_compra`,
    `id_moneda`,
    `signo_moneda`,
    `precio_venta`,
    `flag_igv`,
    `estado`,
    `src_imagen`
  )
VALUES
  (
    1,
    1,
    1,
    1,
    'Brekkies Pienso para Perros con Buey y Verduras - 15000 gr',
    '100% Completo y Equilibrado Huesos y dientes fuertes: Con vitaminas y minerales Pelo brillante y piel sana: Con ácidos grasos esenciales Agilidad: Niv',
    49,
    10,
    40.00,
    1,
    'S/',
    50.00,
    '1',
    'activo',
    'resources/global/images/accesorios/img-1571244572.png'
  ),
  (
    2,
    1,
    1,
    1,
    'KIEM Saco de pienso para Perros Mantenimiento 20 kg, Comida para Perros',
    'Pienso para perro compuesto por carnes cereales y productos vegetales pienso para el mantenimiento de tu perro muy barato y de calidad saco de pienso.',
    99,
    15,
    30.00,
    2,
    '$',
    50.00,
    '1',
    'activo',
    'resources/global/images/accesorios/img-1571244647.png'
  ),
  (
    3,
    1,
    2,
    1,
    'Artero Protein Vital, Acondicionador - 100 ml',
    'Efecto regenerador inmediato del pelo del perro Aporta suavidad y brillo únicos a tu perro Evita que el pelo se rompa debido a las largas sesiones de',
    10,
    10,
    45.00,
    2,
    '$',
    55.00,
    '1',
    'activo',
    'resources/global/images/accesorios/img-1571245068.png'
  ),
  (
    4,
    1,
    2,
    1,
    'Pro Pooch Gotas oculares para Perros (250 ML)',
    'SOLUCION SEGURA NO TÓXICA PARA OJOS - Puede aplicarse 3-4 veces al día o según lo indique su veterinario de confianza. ✔ GMP: fabricado en una instal	',
    40,
    5,
    55.00,
    3,
    '€',
    40.00,
    '1',
    'activo',
    'resources/global/images/accesorios/img-1571245194.png'
  ),
  (
    5,
    1,
    3,
    1,
    '10 delicioso Hueso para roer 17 cm - 1000g',
    '10 sabrosos huesos para morder 17 cm - 1000g Huesos kauk para perros Producto natural hecho de cuero vacuno puro paraperros de tamaño grande y mediano	',
    50,
    12,
    45.00,
    1,
    'S/',
    65.00,
    '1',
    'activo',
    'resources/global/images/accesorios/img-1571245228.png'
  ),
  (
    6,
    1,
    3,
    1,
    'Hopey \'s kausnack para perros Conejos Orejas con pelo',
    'Hopey \'s kausnack natural para perros, conejos, orejas con pelo secado Unique elfutt ermittel para perros, Contenido: 100 g Libre de humo, especias y	',
    10,
    10,
    78.00,
    1,
    'S/',
    89.00,
    '1',
    'activo',
    'resources/global/images/accesorios/img-1571245266.png'
  ),
  (
    7,
    1,
    4,
    1,
    'Halti Training Lead (6\' 6\")',
    'ONTROL Y GUÍA: diseñado para entrenamiento general de obediencia o para caminar, el líder de entrenamiento HALTI es un conductor multifuncional de dob	',
    30,
    5,
    34.00,
    1,
    'S/',
    44.00,
    '1',
    'activo',
    'resources/global/images/accesorios/img-1571245997.png'
  ),
  (
    8,
    1,
    4,
    1,
    'Company of Animals HALTI Jefe de Entrenamiento, Negro, L',
    'CONTROL Y GU?A: dise?ado para entrenamiento general de obediencia o para caminar, el l?der de entrenamiento HALTI es un conductor multifuncional de do	',
    100,
    10,
    5.00,
    2,
    '$',
    10.00,
    '1',
    'activo',
    'resources/global/images/accesorios/img-1571246033.png'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_acceso_opcion`
--
CREATE TABLE `tb_acceso_opcion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_grupo` bigint(20) UNSIGNED NOT NULL,
  `id_opcion` int(11) NOT NULL,
  `flag_agregar` tinyint(1) NOT NULL DEFAULT '0',
  `flag_buscar` tinyint(1) NOT NULL DEFAULT '0',
  `flag_editar` tinyint(1) NOT NULL DEFAULT '0',
  `flag_eliminar` tinyint(1) NOT NULL DEFAULT '0',
  `flag_anular` tinyint(1) NOT NULL DEFAULT '0',
  `flag_ver` tinyint(1) NOT NULL DEFAULT '0',
  `flag_descargar` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_acceso_opcion`
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
  (86, 1, 105, 1, 1, 1, 1, 1, 1, 1),
  (87, 1, 106, 1, 1, 1, 1, 1, 1, 1),
  (88, 1, 107, 1, 1, 1, 1, 1, 1, 1),
  (89, 1, 108, 1, 1, 1, 1, 1, 1, 1),
  (90, 1, 109, 1, 1, 1, 1, 1, 1, 1),
  (91, 1, 110, 1, 1, 1, 1, 1, 1, 1),
  (92, 1, 111, 1, 1, 1, 1, 1, 1, 1),
  (93, 1, 112, 1, 1, 1, 1, 1, 1, 1),
  (94, 1, 113, 1, 1, 1, 1, 1, 1, 1),
  (95, 1, 114, 1, 1, 1, 1, 1, 1, 1),
  (96, 1, 115, 0, 0, 0, 0, 0, 0, 0),
  (97, 1, 200, 0, 0, 0, 0, 0, 0, 0),
  (98, 1, 201, 1, 1, 1, 1, 1, 1, 1),
  (99, 1, 202, 1, 1, 1, 1, 1, 1, 1),
  (100, 1, 203, 1, 1, 1, 1, 1, 1, 1),
  (101, 1, 204, 1, 1, 1, 1, 1, 1, 1),
  (102, 1, 205, 1, 1, 1, 1, 1, 1, 1),
  (103, 1, 206, 1, 1, 1, 1, 1, 1, 1),
  (104, 1, 207, 1, 1, 1, 1, 1, 1, 1),
  (105, 1, 208, 1, 1, 1, 1, 1, 1, 1),
  (106, 1, 209, 0, 0, 0, 0, 0, 0, 0),
  (107, 1, 210, 0, 0, 0, 0, 0, 0, 0),
  (108, 1, 211, 0, 0, 0, 0, 0, 0, 0),
  (109, 1, 212, 0, 0, 0, 0, 0, 0, 0),
  (110, 1, 213, 0, 0, 0, 0, 0, 0, 0),
  (111, 1, 214, 0, 0, 0, 0, 0, 0, 0),
  (112, 1, 215, 0, 0, 0, 0, 0, 0, 0),
  (113, 1, 300, 0, 0, 0, 0, 0, 0, 0),
  (114, 1, 301, 1, 1, 1, 1, 1, 1, 1),
  (115, 1, 302, 1, 1, 1, 1, 1, 1, 1),
  (116, 1, 303, 1, 1, 1, 1, 1, 1, 1),
  (117, 1, 304, 1, 1, 1, 1, 1, 1, 1),
  (118, 1, 305, 0, 0, 0, 0, 0, 0, 0),
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
  (167, 1, 606, 0, 0, 0, 0, 0, 0, 0),
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
  (193, 2, 100, 0, 0, 0, 0, 0, 0, 0),
  (194, 2, 101, 0, 0, 0, 0, 0, 0, 0),
  (195, 2, 102, 0, 0, 0, 0, 0, 0, 0),
  (196, 2, 103, 0, 0, 0, 0, 0, 0, 0),
  (197, 2, 104, 0, 0, 0, 0, 0, 0, 0),
  (198, 2, 105, 1, 1, 1, 0, 0, 1, 0),
  (199, 2, 106, 0, 0, 0, 0, 0, 0, 0),
  (200, 2, 107, 1, 1, 1, 0, 0, 1, 0),
  (201, 2, 108, 1, 1, 1, 0, 0, 1, 0),
  (202, 2, 109, 1, 1, 1, 0, 0, 1, 0),
  (203, 2, 110, 0, 0, 0, 0, 0, 0, 0),
  (204, 2, 111, 0, 0, 0, 0, 0, 0, 0),
  (205, 2, 112, 0, 0, 0, 0, 0, 0, 0),
  (206, 2, 113, 0, 0, 0, 0, 0, 0, 0),
  (207, 2, 114, 0, 0, 0, 0, 0, 0, 0),
  (208, 2, 115, 0, 0, 0, 0, 0, 0, 0),
  (209, 2, 200, 0, 0, 0, 0, 0, 0, 0),
  (210, 2, 201, 1, 1, 1, 0, 0, 1, 0),
  (211, 2, 202, 1, 1, 1, 0, 0, 1, 0),
  (212, 2, 203, 1, 1, 1, 0, 0, 1, 0),
  (213, 2, 204, 1, 1, 1, 0, 0, 1, 0),
  (214, 2, 205, 0, 0, 0, 0, 0, 0, 0),
  (215, 2, 206, 1, 1, 1, 0, 0, 1, 0),
  (216, 2, 207, 1, 1, 1, 0, 0, 1, 0),
  (217, 2, 208, 0, 0, 0, 0, 0, 0, 0),
  (218, 2, 209, 0, 0, 0, 0, 0, 0, 0),
  (219, 2, 210, 0, 0, 0, 0, 0, 0, 0),
  (220, 2, 211, 0, 0, 0, 0, 0, 0, 0),
  (221, 2, 212, 0, 0, 0, 0, 0, 0, 0),
  (222, 2, 213, 0, 0, 0, 0, 0, 0, 0),
  (223, 2, 214, 0, 0, 0, 0, 0, 0, 0),
  (224, 2, 215, 0, 0, 0, 0, 0, 0, 0),
  (225, 2, 300, 0, 0, 0, 0, 0, 0, 0),
  (226, 2, 301, 0, 0, 0, 0, 0, 0, 0),
  (227, 2, 302, 0, 0, 0, 0, 0, 0, 0),
  (228, 2, 303, 0, 0, 0, 0, 0, 0, 0),
  (229, 2, 304, 0, 0, 0, 0, 0, 0, 0),
  (230, 2, 305, 0, 0, 0, 0, 0, 0, 0),
  (231, 2, 306, 0, 0, 0, 0, 0, 0, 0),
  (232, 2, 307, 0, 0, 0, 0, 0, 0, 0),
  (233, 2, 308, 0, 0, 0, 0, 0, 0, 0),
  (234, 2, 309, 0, 0, 0, 0, 0, 0, 0),
  (235, 2, 310, 0, 0, 0, 0, 0, 0, 0),
  (236, 2, 311, 0, 0, 0, 0, 0, 0, 0),
  (237, 2, 312, 0, 0, 0, 0, 0, 0, 0),
  (238, 2, 313, 0, 0, 0, 0, 0, 0, 0),
  (239, 2, 314, 0, 0, 0, 0, 0, 0, 0),
  (240, 2, 315, 0, 0, 0, 0, 0, 0, 0),
  (241, 2, 400, 0, 0, 0, 0, 0, 0, 0),
  (242, 2, 401, 0, 0, 0, 0, 0, 0, 0),
  (243, 2, 402, 0, 0, 0, 0, 0, 0, 0),
  (244, 2, 403, 0, 0, 0, 0, 0, 0, 0),
  (245, 2, 404, 0, 0, 0, 0, 0, 0, 0),
  (246, 2, 405, 0, 0, 0, 0, 0, 0, 0),
  (247, 2, 406, 0, 0, 0, 0, 0, 0, 0),
  (248, 2, 407, 0, 0, 0, 0, 0, 0, 0),
  (249, 2, 408, 0, 0, 0, 0, 0, 0, 0),
  (250, 2, 409, 0, 0, 0, 0, 0, 0, 0),
  (251, 2, 410, 0, 0, 0, 0, 0, 0, 0),
  (252, 2, 411, 0, 0, 0, 0, 0, 0, 0),
  (253, 2, 412, 0, 0, 0, 0, 0, 0, 0),
  (254, 2, 413, 0, 0, 0, 0, 0, 0, 0),
  (255, 2, 414, 0, 0, 0, 0, 0, 0, 0),
  (256, 2, 415, 0, 0, 0, 0, 0, 0, 0),
  (257, 2, 500, 0, 0, 0, 0, 0, 0, 0),
  (258, 2, 501, 0, 0, 0, 0, 0, 0, 0),
  (259, 2, 502, 1, 1, 1, 1, 1, 1, 1),
  (260, 2, 503, 1, 1, 1, 1, 1, 1, 1),
  (261, 2, 504, 0, 0, 0, 0, 0, 0, 0),
  (262, 2, 505, 0, 0, 0, 0, 0, 0, 0),
  (263, 2, 506, 0, 0, 0, 0, 0, 0, 0),
  (264, 2, 507, 0, 0, 0, 0, 0, 0, 0),
  (265, 2, 508, 0, 0, 0, 0, 0, 0, 0),
  (266, 2, 509, 0, 0, 0, 0, 0, 0, 0),
  (267, 2, 510, 0, 0, 0, 0, 0, 0, 0),
  (268, 2, 511, 0, 0, 0, 0, 0, 0, 0),
  (269, 2, 512, 0, 0, 0, 0, 0, 0, 0),
  (270, 2, 513, 0, 0, 0, 0, 0, 0, 0),
  (271, 2, 514, 0, 0, 0, 0, 0, 0, 0),
  (272, 2, 515, 0, 0, 0, 0, 0, 0, 0),
  (273, 2, 600, 0, 0, 0, 0, 0, 0, 0),
  (274, 2, 601, 1, 1, 1, 0, 0, 1, 1),
  (275, 2, 602, 1, 1, 1, 0, 0, 1, 1),
  (276, 2, 603, 0, 0, 0, 0, 0, 0, 0),
  (277, 2, 604, 0, 1, 0, 0, 0, 1, 1),
  (278, 2, 605, 0, 0, 0, 0, 0, 0, 0),
  (279, 2, 606, 0, 0, 0, 0, 0, 0, 0),
  (280, 2, 607, 0, 0, 0, 0, 0, 0, 0),
  (281, 2, 608, 0, 0, 0, 0, 0, 0, 0),
  (282, 2, 609, 0, 0, 0, 0, 0, 0, 0),
  (283, 2, 610, 0, 0, 0, 0, 0, 0, 0),
  (284, 2, 611, 0, 0, 0, 0, 0, 0, 0),
  (285, 2, 612, 0, 0, 0, 0, 0, 0, 0),
  (286, 2, 613, 0, 0, 0, 0, 0, 0, 0),
  (287, 2, 614, 0, 0, 0, 0, 0, 0, 0),
  (288, 2, 615, 0, 0, 0, 0, 0, 0, 0),
  (289, 2, 700, 0, 0, 0, 0, 0, 0, 0),
  (290, 2, 701, 0, 0, 0, 0, 0, 0, 0),
  (291, 2, 702, 0, 0, 0, 0, 0, 0, 0),
  (292, 2, 703, 0, 0, 0, 0, 0, 0, 0),
  (293, 2, 704, 0, 0, 0, 0, 0, 0, 0),
  (294, 2, 705, 0, 0, 0, 0, 0, 0, 0),
  (295, 2, 706, 0, 0, 0, 0, 0, 0, 0),
  (296, 2, 707, 0, 0, 0, 0, 0, 0, 0),
  (297, 2, 708, 0, 0, 0, 0, 0, 0, 0),
  (298, 2, 709, 0, 0, 0, 0, 0, 0, 0),
  (299, 2, 710, 0, 0, 0, 0, 0, 0, 0),
  (300, 2, 711, 0, 0, 0, 0, 0, 0, 0),
  (301, 2, 712, 0, 0, 0, 0, 0, 0, 0),
  (302, 2, 713, 0, 0, 0, 0, 0, 0, 0),
  (303, 2, 714, 0, 0, 0, 0, 0, 0, 0),
  (304, 2, 715, 0, 0, 0, 0, 0, 0, 0),
  (320, 3, 100, 0, 0, 0, 0, 0, 0, 0),
  (321, 3, 101, 0, 0, 0, 0, 0, 0, 0),
  (322, 3, 102, 0, 0, 0, 0, 0, 0, 0),
  (323, 3, 103, 0, 0, 0, 0, 0, 0, 0),
  (324, 3, 104, 0, 0, 0, 0, 0, 0, 0),
  (325, 3, 105, 0, 0, 0, 0, 0, 0, 0),
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
  (337, 3, 201, 1, 1, 1, 0, 0, 1, 1),
  (338, 3, 202, 1, 1, 1, 0, 0, 1, 1),
  (339, 3, 203, 1, 1, 1, 0, 0, 1, 1),
  (340, 3, 204, 1, 1, 1, 0, 0, 1, 1),
  (341, 3, 205, 0, 0, 0, 0, 0, 0, 0),
  (342, 3, 206, 0, 0, 0, 0, 0, 0, 0),
  (343, 3, 207, 1, 1, 1, 0, 0, 1, 1),
  (344, 3, 208, 1, 1, 1, 0, 0, 1, 1),
  (345, 3, 209, 0, 0, 0, 0, 0, 0, 0),
  (346, 3, 210, 0, 0, 0, 0, 0, 0, 0),
  (347, 3, 211, 0, 0, 0, 0, 0, 0, 0),
  (348, 3, 212, 0, 0, 0, 0, 0, 0, 0),
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
  (406, 3, 606, 0, 0, 0, 0, 0, 0, 0),
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
-- Table structure for table `tb_categoria_accesorio`
--
CREATE TABLE `tb_categoria_accesorio` (
  `id_categoria` bigint(20) UNSIGNED NOT NULL,
  `name_categoria` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_categoria_accesorio`
--
INSERT INTO
  `tb_categoria_accesorio` (`id_categoria`, `name_categoria`, `estado`)
VALUES
  (1, 'Comida', 'activo'),
  (2, 'Higiene', 'activo'),
  (3, 'Juguetes', 'activo'),
  (4, 'Collares y Correas', 'activo');

-- --------------------------------------------------------
--
-- Table structure for table `tb_cita`
--
CREATE TABLE `tb_cita` (
  `id_cita` bigint(20) UNSIGNED NOT NULL,
  `id_sucursal` int(11) NOT NULL DEFAULT '1',
  `id_trabajador` bigint(20) UNSIGNED NOT NULL,
  `id_servicio` bigint(20) UNSIGNED NOT NULL,
  `id_mascota` bigint(20) UNSIGNED NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_cita` datetime NOT NULL,
  `fecha_termino` datetime DEFAULT NULL,
  `sintoma` varchar(1000) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `observaciones` varchar(1000) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `mensaje_cita` varchar(1000) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum(
    'registrada',
    'aceptada',
    'cancelada',
    'anulada',
    'atendida'
  ) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'registrada'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_cita`
--
INSERT INTO
  `tb_cita` (
    `id_cita`,
    `id_sucursal`,
    `id_trabajador`,
    `id_servicio`,
    `id_mascota`,
    `fecha_registro`,
    `fecha_cita`,
    `fecha_termino`,
    `sintoma`,
    `observaciones`,
    `mensaje_cita`,
    `estado`
  )
VALUES
  (
    1,
    1,
    2,
    1,
    1,
    '2019-10-16 12:42:52',
    '2019-10-17 08:00:00',
    '2019-10-17 09:15:00',
    'Necesito realizar el chequeo mensual de mi mascota',
    NULL,
    NULL,
    'aceptada'
  ),
  (
    2,
    1,
    2,
    1,
    1,
    '2019-10-16 12:44:54',
    '2019-10-18 10:00:00',
    '2019-10-18 11:15:00',
    'Necesito realizar el chequeo mensual de mi mascota',
    NULL,
    NULL,
    'aceptada'
  ),
  (
    3,
    1,
    2,
    3,
    1,
    '2019-10-16 12:53:14',
    '2019-10-19 12:30:00',
    '2019-10-19 14:30:00',
    'Necesito que se realice una operación a mi mascota.',
    NULL,
    NULL,
    'registrada'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_cliente`
--
CREATE TABLE `tb_cliente` (
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_persona` bigint(20) UNSIGNED NOT NULL,
  `name_user` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `pass_user` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `cod_recuperacion` varchar(500) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fecha_activacion` date DEFAULT NULL,
  `fecha_recuperacion` date DEFAULT NULL,
  `src_imagen` varchar(500) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_cliente`
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
    'luisa@gmail.com',
    '1dd4ecb6f7f0091bc464fee9b9202d59',
    NULL,
    '2019-10-16',
    NULL,
    'resources/global/images/persons/img-1571243739.png',
    'activo'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_compra`
--
CREATE TABLE `tb_compra` (
  `id_compra` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_trabajador` bigint(20) UNSIGNED NOT NULL,
  `id_documento_compra` int(11) NOT NULL,
  `name_documento_compra` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_documento_compra` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correlativo` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_documento_proveedor` bigint(20) UNSIGNED NOT NULL,
  `name_documento_proveedor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_documento_proveedor` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_documento_proveedor` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_forma_pago` int(11) NOT NULL,
  `codigo_forma_pago` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_forma_pago` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proveedor` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
  `descuento_total` decimal(18, 2) DEFAULT '0.00',
  `sub_total` decimal(18, 2) NOT NULL,
  `igv` decimal(18, 2) NOT NULL,
  `total` decimal(18, 2) NOT NULL,
  `estado` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `pdf` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xml` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cdr` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mensaje_sunat` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruta` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag_doc_interno` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `monto_recibido` decimal(18, 2) DEFAULT NULL,
  `vuelto` decimal(18, 2) DEFAULT NULL,
  `id_moneda` int(11) NOT NULL,
  `codigo_moneda` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signo_moneda` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abreviatura_moneda` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signo_moneda_cambio` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'S/ ',
  `monto_tipo_cambio` decimal(18, 2) DEFAULT NULL,
  `observaciones` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag_enviado` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `tb_detalle_cita`
--
CREATE TABLE `tb_detalle_cita` (
  `id_detalle` bigint(20) NOT NULL,
  `id_cita` bigint(20) UNSIGNED NOT NULL,
  `name_servicio` varchar(200) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `motivo` text COLLATE utf8mb4_spanish_ci,
  `sintomas` text COLLATE utf8mb4_spanish_ci,
  `tratamiento` text COLLATE utf8mb4_spanish_ci,
  `vacunas_aplicadas` text COLLATE utf8mb4_spanish_ci,
  `observaciones` text COLLATE utf8mb4_spanish_ci,
  `peso` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fecha_detalle_cita` datetime DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_detalle_cita`
--
INSERT INTO
  `tb_detalle_cita` (
    `id_detalle`,
    `id_cita`,
    `name_servicio`,
    `motivo`,
    `sintomas`,
    `tratamiento`,
    `vacunas_aplicadas`,
    `observaciones`,
    `peso`,
    `fecha_detalle_cita`
  )
VALUES
  (
    1,
    1,
    'Medicina preventiva',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
  ),
  (
    2,
    2,
    'Medicina preventiva',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
  ),
  (
    3,
    3,
    'Cirugía',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_detalle_compra`
--
CREATE TABLE `tb_detalle_compra` (
  `id_detalle` bigint(20) NOT NULL,
  `id_orden_compra` int(18) NOT NULL,
  `name_tabla` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cod_producto` int(18) NOT NULL,
  `cantidad_solicitada` int(11) DEFAULT NULL,
  `cantidad_ingresada` int(11) DEFAULT NULL,
  `precio_unitario` decimal(18, 2) DEFAULT NULL,
  `notas` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_detalle_compra`
--
INSERT INTO
  `tb_detalle_compra` (
    `id_detalle`,
    `id_orden_compra`,
    `name_tabla`,
    `cod_producto`,
    `cantidad_solicitada`,
    `cantidad_ingresada`,
    `precio_unitario`,
    `notas`
  )
VALUES
  (18, 1, 'accesorio', 1, 50, 0, '40.00', ''),
  (19, 1, 'accesorio', 2, 20, 0, '100.50', ''),
  (20, 1, 'accesorio', 3, 20, 0, '150.75', ''),
  (21, 1, 'medicamento', 1, 15, 0, '100.00', ''),
  (22, 1, 'medicamento', 2, 15, 0, '50.00', ''),
  (23, 2, 'accesorio', 1, 10, 0, '40.00', ''),
  (24, 2, 'accesorio', 2, 10, 0, '100.50', '');

-- --------------------------------------------------------
--
-- Table structure for table `tb_detalle_ingreso`
--
CREATE TABLE `tb_detalle_ingreso` (
  `id_detalle` bigint(20) NOT NULL,
  `id_ingreso` bigint(20) NOT NULL,
  `name_tabla` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `observaciones` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `tb_detalle_venta`
--
CREATE TABLE `tb_detalle_venta` (
  `id_detalle` bigint(20) UNSIGNED NOT NULL,
  `id_venta` int(11) NOT NULL,
  `name_tabla` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_producto` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` decimal(18, 2) NOT NULL,
  `precio_unitario` decimal(18, 3) NOT NULL,
  `descuento` decimal(18, 2) DEFAULT '0.00',
  `sub_total` decimal(18, 2) NOT NULL,
  `tipo_igv` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `igv` decimal(18, 2) NOT NULL,
  `total` decimal(18, 2) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_detalle_venta`
--
INSERT INTO
  `tb_detalle_venta` (
    `id_detalle`,
    `id_venta`,
    `name_tabla`,
    `cod_producto`,
    `descripcion`,
    `cantidad`,
    `precio_unitario`,
    `descuento`,
    `sub_total`,
    `tipo_igv`,
    `igv`,
    `total`
  )
VALUES
  (
    1,
    1,
    'servicio',
    '2',
    'Consultas',
    '1.00',
    '16.949',
    '0.00',
    '16.95',
    '1',
    '3.05',
    '20.00'
  ),
  (
    2,
    1,
    'servicio',
    '3',
    'Cirugía',
    '1.00',
    '709.746',
    '0.00',
    '709.75',
    '1',
    '127.75',
    '837.50'
  ),
  (
    3,
    1,
    'servicio',
    '4',
    'Hospitalización',
    '1.00',
    '158.898',
    '0.00',
    '158.90',
    '1',
    '28.60',
    '187.50'
  ),
  (
    4,
    1,
    'accesorio',
    '1',
    'Brekkies Pienso para Perros con Buey y Verduras - 15000 gr',
    '1.00',
    '42.373',
    '0.00',
    '42.37',
    '1',
    '7.63',
    '50.00'
  ),
  (
    5,
    1,
    'accesorio',
    '2',
    'KIEM Saco de pienso para Perros Mantenimiento 20 kg, Comida para Perros',
    '1.00',
    '141.949',
    '0.00',
    '141.95',
    '1',
    '25.55',
    '167.50'
  ),
  (
    6,
    1,
    'medicamento',
    '3',
    'BIOSPORINE 3®',
    '1.00',
    '212.924',
    '0.00',
    '212.92',
    '1',
    '38.33',
    '251.25'
  ),
  (
    7,
    1,
    'medicamento',
    '2',
    'AMOXYCOL® WS',
    '1.00',
    '50.847',
    '0.00',
    '50.85',
    '1',
    '9.15',
    '60.00'
  ),
  (
    8,
    1,
    'medicamento',
    '1',
    'AGROMYCIN® 11',
    '1.00',
    '93.220',
    '0.00',
    '93.22',
    '1',
    '16.78',
    '110.00'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_documento_identidad`
--
CREATE TABLE `tb_documento_identidad` (
  `id_documento` bigint(20) UNSIGNED NOT NULL,
  `name_documento` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `codigo_sunat` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `flag_numerico` tinyint(1) NOT NULL DEFAULT '0',
  `flag_exacto` tinyint(1) NOT NULL DEFAULT '0',
  `size` int(11) NOT NULL DEFAULT '8',
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_documento_identidad`
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
  (3, 'RUC', '6', 1, 1, 11, 'activo'),
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
-- Table structure for table `tb_documento_venta`
--
CREATE TABLE `tb_documento_venta` (
  `id_documento_venta` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `cod_sunat` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_corto` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correlativo` bigint(20) DEFAULT NULL,
  `estado` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag_doc_interno` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_documento_venta`
--
INSERT INTO
  `tb_documento_venta` (
    `id_documento_venta`,
    `id_sucursal`,
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
-- Table structure for table `tb_empresa`
--
CREATE TABLE `tb_empresa` (
  `id_empresa` bigint(20) UNSIGNED NOT NULL,
  `id_documento` bigint(20) UNSIGNED NOT NULL,
  `num_documento` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `razon_social` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre_comercial` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `direccion` varchar(300) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fono01` varchar(30) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `correo01` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `web` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_documento_representante` bigint(20) UNSIGNED NOT NULL,
  `num_documento_representante` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombres_representante` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellidos_representante` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fono02` varchar(30) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `correo02` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo',
  `src_logo` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_empresa`
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
    'Veterinaria Mican',
    'Clínica Veterinaría Mican',
    'Jr. Pedro Remy N 239, San Martín de Porres - Lima - Lima',
    '916028408',
    'informes@veterinariamican.com',
    'https://mican.com/',
    1,
    '70762343',
    'Jolu',
    'Quispe',
    '916028408',
    'jolu@mican.com',
    'activo',
    'resources/global/images/business_logo/img-1571242080.jpg'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_especialidad`
--
CREATE TABLE `tb_especialidad` (
  `id_especialidad` bigint(20) UNSIGNED NOT NULL,
  `name_especialidad` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_especialidad`
--
INSERT INTO
  `tb_especialidad` (`id_especialidad`, `name_especialidad`, `estado`)
VALUES
  (1, 'Usuario', 'activo'),
  (2, 'Anestesiología Veterinaria', 'activo'),
  (3, 'Cardiología veterinaria', 'activo'),
  (4, 'Cirugía', 'activo'),
  (5, 'Dermatología', 'activo'),
  (6, 'Fisioterapia', 'activo'),
  (7, 'Oftalmología veterinaria', 'activo'),
  (8, 'Oncología Veterinaria', 'activo'),
  (9, 'Ortopedia', 'activo');

-- --------------------------------------------------------
--
-- Table structure for table `tb_forma_pago`
--
CREATE TABLE `tb_forma_pago` (
  `id_forma_pago` int(11) NOT NULL,
  `name_forma_pago` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cod_sunat` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_forma_pago`
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
-- Table structure for table `tb_galeria`
--
CREATE TABLE `tb_galeria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_tabla` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `src` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referencia_1` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referencia_2` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_galeria`
--
INSERT INTO
  `tb_galeria` (
    `id`,
    `name_tabla`,
    `src`,
    `titulo`,
    `descripcion`,
    `referencia_1`,
    `referencia_2`,
    `url`,
    `estado`
  )
VALUES
  (
    1,
    '1',
    'resources/global/images/galeria/img-1571247362.png',
    'Acompañando al engrído',
    'Una foto con la mascota en la clínica veterinaría.',
    NULL,
    NULL,
    NULL,
    'activo'
  ),
  (
    2,
    '2',
    'resources/global/images/galeria/img-1571247402.png',
    'Pedigree',
    'https://pedigree.com',
    NULL,
    NULL,
    NULL,
    'activo'
  ),
  (
    3,
    '3',
    'resources/global/images/testimonio/img-1571247436.png',
    'Luisa Sanchez',
    'Quiero recomendar a clínica veterinaria por el tiempo que mi mascota estuvo internado la trataron con mucha dedicación y amor... Amigos les recomiendo por la atención profesional que brinda.',
    '4',
    '16/10/2019',
    NULL,
    'activo'
  ),
  (
    4,
    '3',
    'resources/global/images/testimonio/img-1571247491.png',
    'Magnolia Ramirez',
    'Gracias al apoyo de la veterinaria que se preocupa por los animales abandonados, pude adoptar a Machin y ahora es parte de mi familia y me encanta ver a mis hijos felices con Machim, ',
    '5',
    '16/10/2019',
    NULL,
    'activo'
  ),
  (
    5,
    '3',
    'resources/global/images/testimonio/img-1571247599.png',
    'Luis Sanchez',
    'Cuando le detectaron un tumor a mi mascota la llevé a clínica veterinaria, la operaron y ahora está muy bien. Gracias, les recomiendo la atención es muy buena y los profesionales son muy carismáticos.',
    '5',
    '16/10/2019',
    NULL,
    'activo'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_grupo_usuario`
--
CREATE TABLE `tb_grupo_usuario` (
  `id_grupo` bigint(20) UNSIGNED NOT NULL,
  `name_grupo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_grupo_usuario`
--
INSERT INTO
  `tb_grupo_usuario` (`id_grupo`, `name_grupo`, `estado`)
VALUES
  (1, 'Administrador', 'activo'),
  (2, 'Usuario', 'activo'),
  (3, 'Caja', 'activo');

-- --------------------------------------------------------
--
-- Table structure for table `tb_ingreso`
--
CREATE TABLE `tb_ingreso` (
  `id_ingreso` bigint(20) NOT NULL,
  `id_orden_compra` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_trabajador` int(11) NOT NULL,
  `id_tipo_docu` int(11) DEFAULT NULL,
  `num_documento` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `observaciones` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `tb_mascota`
--
CREATE TABLE `tb_mascota` (
  `id_mascota` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_mascota` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `raza` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `peso` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `sexo` enum('hembra', 'macho') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'hembra',
  `fecha_nacimiento` date DEFAULT NULL,
  `observaciones` varchar(1000) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo',
  `src_imagen` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_mascota`
--
INSERT INTO
  `tb_mascota` (
    `id_mascota`,
    `id_cliente`,
    `id_tipo_mascota`,
    `nombre`,
    `raza`,
    `color`,
    `peso`,
    `sexo`,
    `fecha_nacimiento`,
    `observaciones`,
    `estado`,
    `src_imagen`
  )
VALUES
  (
    1,
    1,
    1,
    'DECAN',
    'LABRADOR',
    'MARRÓN',
    '4',
    'macho',
    '2019-09-12',
    'Sin Observaciones',
    'activo',
    'resources/global/images/mascotas/img-1571247077.png'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_mascota_vacuna`
--
CREATE TABLE `tb_mascota_vacuna` (
  `id_mascota_vacuna` bigint(20) UNSIGNED NOT NULL,
  `id_mascota` bigint(20) UNSIGNED NOT NULL,
  `id_vacuna` bigint(20) UNSIGNED NOT NULL,
  `fecha_minima` date DEFAULT NULL,
  `fecha_maxima` date DEFAULT NULL,
  `fecha_aplicacion` datetime DEFAULT NULL,
  `flag_vacuna` tinyint(1) NOT NULL DEFAULT '0',
  `observaciones` varchar(1000) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `name_sucursal` varchar(300) COLLATE utf8mb4_spanish_ci DEFAULT '',
  `name_user` varchar(300) COLLATE utf8mb4_spanish_ci DEFAULT ''
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_mascota_vacuna`
--
INSERT INTO
  `tb_mascota_vacuna` (
    `id_mascota_vacuna`,
    `id_mascota`,
    `id_vacuna`,
    `fecha_minima`,
    `fecha_maxima`,
    `fecha_aplicacion`,
    `flag_vacuna`,
    `observaciones`,
    `name_sucursal`,
    `name_user`
  )
VALUES
  (
    1,
    1,
    1,
    '2019-09-24',
    '2019-10-02',
    '2019-10-16 12:57:24',
    1,
    'Sin observaciones',
    'LOCAL PRINCIPAL',
    'David Moreno'
  ),
  (
    2,
    1,
    2,
    '2019-10-12',
    '2019-10-22',
    '2019-10-16 13:00:20',
    1,
    'Sin observaciones',
    'LOCAL PRINCIPAL',
    'David Moreno'
  ),
  (
    3,
    1,
    3,
    '2019-11-21',
    '2019-12-01',
    NULL,
    0,
    NULL,
    '',
    ''
  ),
  (
    4,
    1,
    4,
    '2019-12-21',
    '2019-12-31',
    NULL,
    0,
    NULL,
    '',
    ''
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_medicamento`
--
CREATE TABLE `tb_medicamento` (
  `id_medicamento` bigint(20) UNSIGNED NOT NULL,
  `id_sucursal` int(11) NOT NULL DEFAULT '1',
  `id_tipo_medicamento` bigint(20) UNSIGNED NOT NULL,
  `id_unidad_medida` int(11) NOT NULL DEFAULT '1',
  `name_medicamento` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(1000) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  `stock_minimo` int(11) NOT NULL DEFAULT '0',
  `precio_compra` double(8, 2) NOT NULL DEFAULT '0.00',
  `id_moneda` int(11) NOT NULL DEFAULT '1',
  `signo_moneda` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'S/',
  `precio_venta` double(8, 2) NOT NULL DEFAULT '0.00',
  `flag_igv` char(1) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '1',
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo',
  `src_imagen` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_medicamento`
--
INSERT INTO
  `tb_medicamento` (
    `id_medicamento`,
    `id_sucursal`,
    `id_tipo_medicamento`,
    `id_unidad_medida`,
    `name_medicamento`,
    `descripcion`,
    `stock`,
    `stock_minimo`,
    `precio_compra`,
    `id_moneda`,
    `signo_moneda`,
    `precio_venta`,
    `flag_igv`,
    `estado`,
    `src_imagen`
  )
VALUES
  (
    1,
    1,
    1,
    1,
    'AGROMYCIN® 11',
    'Tratamiento de infecciones causadas por microorganismos sensibles a la oxitetraciclina (locales y generalizadas) en todas las especies de animales.	',
    99,
    5,
    100.00,
    1,
    'S/',
    110.00,
    '1',
    'activo',
    'resources/global/images/medicamentos/img-1571246151.png'
  ),
  (
    2,
    1,
    1,
    1,
    'AMOXYCOL® WS',
    'Potente Combinación Antibiótica Betalactámica-Polipéptido de Amplio Espectro	',
    3,
    10,
    50.00,
    1,
    'S/',
    60.00,
    '1',
    'activo',
    'resources/global/images/medicamentos/img-1571246250.png'
  ),
  (
    3,
    1,
    6,
    1,
    'BIOSPORINE 3®',
    'Crema Topical Triple asociación antibiótica topical de amplio espectro	',
    53,
    4,
    65.00,
    2,
    '$',
    75.00,
    '1',
    'activo',
    'resources/global/images/medicamentos/img-1571246283.png'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_metodo_envio`
--
CREATE TABLE `tb_metodo_envio` (
  `id_metodo_envio` int(11) NOT NULL,
  `name_metodo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_metodo_envio`
--
INSERT INTO
  `tb_metodo_envio` (`id_metodo_envio`, `name_metodo`, `estado`)
VALUES
  (1, 'DHL EXPRESS', '1');

-- --------------------------------------------------------
--
-- Table structure for table `tb_moneda`
--
CREATE TABLE `tb_moneda` (
  `id_moneda` int(11) NOT NULL,
  `name_moneda` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_sunat` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abreviatura` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_cambio` decimal(18, 3) DEFAULT '1.000',
  `flag_principal` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `estado` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_moneda`
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
  (1, 'SOLES', '1', 'S/', 'PEN', '1.000', '1', '1'),
  (2, 'DÓLARES', '2', '$', 'USD', '3.350', '0', '1'),
  (3, 'EUROS', '3', '€', 'EUR', '3.750', '0', '1');

-- --------------------------------------------------------
--
-- Table structure for table `tb_opcion`
--
CREATE TABLE `tb_opcion` (
  `id_opcion` int(11) NOT NULL,
  `name_opcion` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo',
  `url` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `icono` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_opcion`
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
  (105, 'Cargos usuarios', 'activo', NULL, 5, NULL),
  (
    106,
    'Categorias de Productos',
    'activo',
    NULL,
    6,
    NULL
  ),
  (
    107,
    'Tipos de Servicios',
    'activo',
    NULL,
    7,
    NULL
  ),
  (
    108,
    'Tipos de Operaciones',
    'activo',
    NULL,
    8,
    NULL
  ),
  (
    109,
    'Tipos de Productos',
    'activo',
    NULL,
    9,
    NULL
  ),
  (110, 'Métodos de Pago', 'activo', NULL, 10, NULL),
  (111, 'Tipo de Cambio', 'activo', NULL, 11, NULL),
  (
    112,
    'Documentos de Venta',
    'activo',
    NULL,
    12,
    NULL
  ),
  (
    113,
    'Unidades de Medida',
    'activo',
    NULL,
    13,
    NULL
  ),
  (
    114,
    'Métodos de Envío',
    'activo',
    NULL,
    14,
    NULL
  ),
  (115, NULL, '', NULL, 0, NULL),
  (200, 'Mantenimiento', 'activo', NULL, 0, NULL),
  (201, 'Clientes', 'activo', NULL, 0, NULL),
  (202, 'Servicios', 'activo', NULL, 0, NULL),
  (203, 'Productos', 'activo', NULL, 0, NULL),
  (204, 'Productos', 'activo', NULL, 0, NULL),
  (
    205,
    'Médicos - Servicios',
    'activo',
    NULL,
    0,
    NULL
  ),
  (206, 'Vacunas', 'activo', NULL, 0, NULL),
  (207, 'Operaciones', 'activo', NULL, 0, NULL),
  (208, 'Proveedores', 'activo', NULL, 0, NULL),
  (209, NULL, '', NULL, 0, NULL),
  (210, NULL, '', NULL, 0, NULL),
  (211, NULL, '', NULL, 0, NULL),
  (212, NULL, '', NULL, 0, NULL),
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
  (305, NULL, '', NULL, 0, NULL),
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
  (400, 'Página Web', 'activo', NULL, 0, NULL),
  (401, 'Cabezera', 'activo', NULL, 0, NULL),
  (402, 'Redes Sociales', 'activo', NULL, 0, NULL),
  (403, 'Galería', 'activo', NULL, 0, NULL),
  (404, 'Socios', 'activo', NULL, 0, NULL),
  (405, 'Testimonios', 'activo', NULL, 0, NULL),
  (
    406,
    'Datos de Contacto',
    'activo',
    NULL,
    0,
    NULL
  ),
  (407, NULL, '', NULL, 0, NULL),
  (408, NULL, '', NULL, 0, NULL),
  (409, NULL, '', NULL, 0, NULL),
  (410, NULL, '', NULL, 0, NULL),
  (411, NULL, '', NULL, 0, NULL),
  (412, NULL, '', NULL, 0, NULL),
  (413, NULL, '', NULL, 0, NULL),
  (414, NULL, '', NULL, 0, NULL),
  (415, NULL, '', NULL, 0, NULL),
  (500, 'Citas', 'activo', NULL, 0, NULL),
  (501, 'Gestionar Citas', 'activo', NULL, 0, NULL),
  (
    502,
    'Atención de Citas',
    'activo',
    NULL,
    0,
    NULL
  ),
  (
    503,
    'Historial ',
    'activo',
    NULL,
    0,
    NULL
  ),
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
  (
    601,
    'Ficha de Operación y Vacunas',
    'activo',
    NULL,
    0,
    NULL
  ),
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
  (606, NULL, 'inactivo', NULL, 0, NULL),
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
  (
    701,
    'Reporte de Compras',
    'inactivo',
    NULL,
    0,
    NULL
  ),
  (
    702,
    'Reporte de Ventas',
    'activo',
    NULL,
    0,
    NULL
  ),
  (
    703,
    'Reporte de Productos',
    'activo',
    NULL,
    0,
    NULL
  ),
  (
    704,
    'Reporte de Productos',
    'activo',
    NULL,
    0,
    NULL
  ),
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
-- Table structure for table `tb_orden_compra`
--
CREATE TABLE `tb_orden_compra` (
  `id_orden_compra` int(18) NOT NULL,
  `id_metodo_envio` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_trabajador` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `fecha_orden` datetime NOT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `descripcion` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_moneda` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_orden_compra`
--
INSERT INTO
  `tb_orden_compra` (
    `id_orden_compra`,
    `id_metodo_envio`,
    `id_proveedor`,
    `id_trabajador`,
    `id_sucursal`,
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
-- Table structure for table `tb_parametros_generales`
--
CREATE TABLE `tb_parametros_generales` (
  `id_parametro` int(11) NOT NULL,
  `name_parametro` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `valor_int` int(11) NOT NULL DEFAULT '0',
  `valor_string` varchar(1000) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `valor_decimal` decimal(8, 2) NOT NULL DEFAULT '0.00',
  `valor_bit` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_parametros_generales`
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
    '0.00',
    1
  ),
  (
    2,
    'Imagen Banner 2',
    0,
    'resources/global/images/paginaweb/fondo2.jpg',
    '0.00',
    1
  ),
  (
    3,
    'Imagen Banner 3',
    0,
    'resources/global/images/paginaweb/fondo3.jpg',
    '0.00',
    1
  ),
  (
    4,
    'Titulo Banner 1',
    0,
    'Bienvenidos a Pet Space',
    '0.00',
    1
  ),
  (
    5,
    'Titulo Banner 2',
    0,
    'Brinda una mejor atención a tus clientes',
    '0.00',
    0
  ),
  (
    6,
    'Titulo Banner 3',
    0,
    'Profesionales altamente calificados',
    '0.00',
    1
  ),
  (
    7,
    'Descripcion Banner 1',
    0,
    'Una Plataforma en la cuál podrás administrar tu veterinaria desde cualquier lugar.',
    '0.00',
    0
  ),
  (
    8,
    'Descripcion Banner 2',
    0,
    'Así podrás mantenerte en contacto con tus clientes, ofreciendo un valor agregado a tu negocio.',
    '0.00',
    0
  ),
  (
    9,
    'Descripcion Banner 3',
    0,
    'Nuestro equipo de profesionales con más de 10 años de experiencia, te brindarán un apoyo constante en todo momento.',
    '0.00',
    0
  ),
  (
    10,
    'Texto Boton 1',
    0,
    'Mas información',
    '0.00',
    0
  ),
  (
    11,
    'Texto Boton 2',
    0,
    'Mas isnformación',
    '0.00',
    0
  ),
  (
    12,
    'Texto Boton 3',
    0,
    'Mas información',
    '0.00',
    0
  ),
  (
    13,
    'Enlace banner 1',
    0,
    '?view=conocenos',
    '0.00',
    0
  ),
  (
    14,
    'Enlace banner 2',
    0,
    '?view=conocenos',
    '0.00',
    0
  ),
  (
    15,
    'Enlace banner 3',
    0,
    '?view=conocenos',
    '0.00',
    0
  ),
  (
    16,
    'Horario Top Nav',
    0,
    'Lunes - Sábado 8:00 - 17:00',
    '0.00',
    0
  ),
  (
    17,
    'Correo Soporte Técnico',
    0,
    'informes@veterinariamican.com',
    '0.00',
    0
  ),
  (18, 'Telefono', 0, '(+51) 930744960', '0.00', 0),
  (
    19,
    'Link Facebook',
    0,
    'https://www.facebook.com',
    '0.00',
    0
  ),
  (
    20,
    'Link Instagram',
    0,
    'https://www.instagram.com',
    '0.00',
    0
  ),
  (
    21,
    'Link Youtube',
    0,
    'https://www.youtube.com',
    '0.00',
    0
  ),
  (
    22,
    'Link Twitter',
    0,
    'https://www.twitter.com',
    '0.00',
    0
  ),
  (
    23,
    'Logo Página',
    0,
    'resources/assets-web/img/logo.png',
    '0.00',
    0
  ),
  (
    24,
    'Direccion Footer',
    0,
    'Jr. Pedro Remy 177 - SMP - Lima',
    '0.00',
    0
  ),
  (25, 'Clientes Felices', 1011, NULL, '0.00', 0),
  (26, 'Proyectos Completados', 12, NULL, '0.00', 0),
  (27, 'Premios Ganados', 15, NULL, '0.00', 0),
  (28, 'Horas Trabajadas', 3050, NULL, '0.00', 0),
  (
    29,
    'Horario Lunes',
    0,
    '8:00 - 18:00',
    '0.00',
    0
  ),
  (
    30,
    'Horario Martes',
    0,
    '8:00 - 18:00',
    '0.00',
    0
  ),
  (
    31,
    'Horario Miercoles',
    0,
    '8:00 - 18:00',
    '0.00',
    0
  ),
  (
    32,
    'Horario Jueves',
    0,
    '8:00 - 18:00',
    '0.00',
    0
  ),
  (
    33,
    'Horario Viernes',
    0,
    '8:00 - 18:00',
    '0.00',
    0
  ),
  (34, 'Horario Sabado', 0, 'Cerrado', '0.00', 0),
  (35, 'Horario Domingo', 0, 'Cerrado', '0.00', 0),
  (
    36,
    'Descripcion Footer',
    0,
    'Descripcion Footer',
    '0.00',
    0
  ),
  (
    37,
    'Mapa Contacto',
    0,
    '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.3688387144507!2d-77.03578688561743!3d-12.086882845937915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c9da03b255e1%3A0xfba2569a5919029a!2sTecnovo+Per%C3%BA!5e0!3m2!1ses-419!2sus!4v1566490062500!5m2!1ses-419!2sus\" width=\"100%\" height=\"500\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>',
    '0.00',
    0
  ),
  (38, 'IGV', 0, NULL, '18.00', 0);

-- --------------------------------------------------------
--
-- Table structure for table `tb_persona`
--
CREATE TABLE `tb_persona` (
  `id_persona` bigint(20) UNSIGNED NOT NULL,
  `id_documento` bigint(20) UNSIGNED NOT NULL,
  `num_documento` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombres` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `correo` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` enum('masculino', 'femenino') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'masculino'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_persona`
--
INSERT INTO
  `tb_persona` (
    `id_persona`,
    `id_documento`,
    `num_documento`,
    `nombres`,
    `apellidos`,
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
    'Jr. Pedro Remy 177 - Urb. Ingeneria - SMP',
    '930744960',
    'zvaldera@oxerva.com',
    '1995-05-12',
    'masculino'
  ),
  (
    2,
    1,
    '12345678',
    'Luisa Magnolia',
    'Valdera Zurita',
    'Jr. Pedro Remy N 317 - Urbanización Ingenería',
    '987654321',
    'zhaul_aries15@hotmail.com',
    '2000-12-07',
    'femenino'
  ),
  (
    3,
    3,
    '20202020202',
    'Pedigree SAC',
    'Pedigree SAC',
    'Jr. Pedro Remy N 317 - Urbanización Ingenería',
    '012083489',
    '',
    '2019-10-16',
    'masculino'
  ),
  (
    4,
    1,
    '09890978',
    'David',
    'Moreno',
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
    'Jr. Pedro Remy N 317 - Urbanización Ingenería',
    '987654321',
    'irvingtovar@gmail.com',
    '1989-10-16',
    'masculino'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_promocion`
--
CREATE TABLE `tb_promocion` (
  `id_promocion` int(11) NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `precio` decimal(18, 2) DEFAULT '0.00',
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `src_imagen` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `tb_proveedor`
--
CREATE TABLE `tb_proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `id_persona` bigint(20) UNSIGNED NOT NULL,
  `estado` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `src_imagen` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_proveedor`
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
    3,
    '1',
    'resources/global/images/persons/img-1571244091.png'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_proveedor_observaciones`
--
CREATE TABLE `tb_proveedor_observaciones` (
  `id_detalle` bigint(20) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `observacion` text COLLATE utf8mb4_unicode_ci,
  `fecha` datetime DEFAULT NULL,
  `estado` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `tb_servicio`
--
CREATE TABLE `tb_servicio` (
  `id_servicio` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_servicio` bigint(20) UNSIGNED NOT NULL,
  `name_servicio` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion_breve` varchar(1000) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `descripcion_larga` varchar(1000) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_moneda` int(11) NOT NULL DEFAULT '1',
  `signo_moneda` varchar(10) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `precio` decimal(8, 2) NOT NULL DEFAULT '0.00',
  `flag_igv` char(1) COLLATE utf8mb4_spanish_ci DEFAULT '1',
  `src_imagen` varchar(1000) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_servicio`
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
    'Medicina preventiva',
    'Contamos con excelentes programas de medicina preventiva como es la aplicación de vacunas para perros, gatos y mucho más...',
    'También contamos con el chequeo geriátrico el cual recomendamos para perros de talla miniatura a partir de los 9 años de edad, los perros de talla media a partir de los 7 años y los de talla gigante como el gran danés o san bernardo a partir de los 6 años.',
    1,
    'S/',
    '45.00',
    '1',
    'resources/global/images/servicios/img-1571244152.png',
    'activo'
  ),
  (
    2,
    2,
    'Consultas',
    'La Clínica Veterinaria del Bosque cuenta con médicos veterinarios expertos en diferentes disciplinas y con la metodología necesaria para llegar a los ',
    'Seguimos a detalle el expediente clínico orientado a problemas, en el que al conjuntar los datos generales, la historia clínica y el examen clínico.',
    1,
    'S/',
    '20.00',
    '1',
    'resources/global/images/servicios/img-1571244190.png',
    'activo'
  ),
  (
    3,
    3,
    'Cirugía',
    'En la Clínica Veterinaria del Bosque contamos con quirófano equipado con anestesia inhalada y monitores trans quirúrgicos.',
    'Frecuencia respiratoria, cantidad de oxigeno y bióxido de carbono circulante en el organismo de nuestra mascota, entre otras  mientras son intervenidas quirúrgicamente, nuestro quirófano cuenta también con la instrumentación suficiente para la práctica de cirugía en tejidos blandos.',
    2,
    '$',
    '250.00',
    '1',
    'resources/global/images/servicios/img-1571244228.png',
    'activo'
  ),
  (
    4,
    3,
    'Hospitalización',
    'Contamos con las instalaciones y el personal capacitado para brindar el internamiento de pacientes con fines tanto terapéuticos como diagnostico.',
    'Cuenta con la flexibilidad para ofrecer  hospitalización diurna en donde los pacientes son internados durante el día para la supervisión y administración de fármacos o tratamientos mientras los propietarios trabajan.',
    3,
    '€',
    '50.00',
    '1',
    'resources/global/images/servicios/img-1571244267.png',
    'activo'
  ),
  (
    5,
    4,
    'Medicina interna',
    'Contamos con los métodos diagnósticos y tratamiento de las enfermedades de los órganos internos de manera no quirúrgica con este fin hemos incorporado',
    'Imagenología, electrocardiografía, entre otros y también colaboran un excelente equipo de expertos en disciplinas como oftalmología (Dr. Fred Pineda),',
    1,
    'S/',
    '200.00',
    '1',
    'resources/global/images/servicios/img-1571244302.png',
    'activo'
  ),
  (
    6,
    5,
    'Imagenología',
    'La Clínica Veterinaria del Bosque cuenta con métodos diagnósticos de alta calidad como son radiología de alta frecuencia que es un equipo de rayos X.',
    'Se cuenta también con ecosonografía y endoscopía de fibra óptica, estas técnicas complementarias ayudan a tener métodos diagnósticos confiables para enfocar la terapia de manera eficiente.',
    2,
    '$',
    '65.00',
    '1',
    'resources/global/images/servicios/img-1571244338.png',
    'activo'
  ),
  (
    7,
    6,
    'Laboratorio de análisis clínico',
    'Laboratorios integrados que le permite correr pruebas como química sanguínea en húmeda y seca, lo que facilita la obtención de datos a cualquier hora.',
    'Y en cuestión de minutos, hemograma (biometría hemética), coproparasitología, prueba que ayuda a la detección de parásitos o huevos de los mismos en heces fecales, serología, estas últimas.',
    2,
    '$',
    '23.00',
    '1',
    'resources/global/images/servicios/img-1571244377.png',
    'activo'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_sucursal`
--
CREATE TABLE `tb_sucursal` (
  `id_sucursal` int(11) NOT NULL,
  `id_empresa` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cod_ubigeo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mapa` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `token` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruta` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_sucursal`
--
INSERT INTO
  `tb_sucursal` (
    `id_sucursal`,
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
    'LOCAL PRINCIPAL',
    '150302',
    'JR. TOMÁS GUIDO N 239 - OF. 302 - LINCE',
    '98765432',
    '',
    '1',
    'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc',
    'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_tipo_cambio`
--
CREATE TABLE `tb_tipo_cambio` (
  `id` int(11) NOT NULL,
  `id_moneda` int(11) NOT NULL,
  `name_user` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `tipo_cambio` decimal(18, 3) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_tipo_cambio`
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
  (1, 2, 'zhaul', '2019-10-16 11:33:38', '3.350'),
  (2, 3, 'zhaul', '2019-10-16 11:33:44', '3.750');

-- --------------------------------------------------------
--
-- Table structure for table `tb_tipo_mascota`
--
CREATE TABLE `tb_tipo_mascota` (
  `id_tipo_mascota` bigint(20) UNSIGNED NOT NULL,
  `name_tipo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_tipo_mascota`
--
INSERT INTO
  `tb_tipo_mascota` (`id_tipo_mascota`, `name_tipo`, `estado`)
VALUES
  (1, 'Perro', 'activo'),
  (2, 'Gato', 'activo'),
  (3, 'Conejo', 'activo');

-- --------------------------------------------------------
--
-- Table structure for table `tb_tipo_medicamento`
--
CREATE TABLE `tb_tipo_medicamento` (
  `id_tipo_medicamento` bigint(20) UNSIGNED NOT NULL,
  `name_tipo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_tipo_medicamento`
--
INSERT INTO
  `tb_tipo_medicamento` (`id_tipo_medicamento`, `name_tipo`, `estado`)
VALUES
  (1, 'Antibióticos', 'activo'),
  (2, 'Sulfonamidas', 'activo'),
  (3, 'Tetraciclinas', 'activo'),
  (4, 'Antiparasitarios', 'activo'),
  (5, 'Anticoagulantes', 'activo'),
  (6, 'Antiparasitarios', 'activo');

-- --------------------------------------------------------
--
-- Table structure for table `tb_tipo_servicio`
--
CREATE TABLE `tb_tipo_servicio` (
  `id_tipo_servicio` bigint(20) UNSIGNED NOT NULL,
  `name_tipo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_tipo_servicio`
--
INSERT INTO
  `tb_tipo_servicio` (`id_tipo_servicio`, `name_tipo`, `estado`)
VALUES
  (1, 'Medicina preventiva', 'activo'),
  (2, 'Consulta', 'activo'),
  (3, 'Cirugía', 'activo'),
  (4, 'Medicina interna', 'activo'),
  (5, 'Imagenología', 'activo'),
  (6, 'Laboratorio de análisis clínico', 'activo'),
  (7, 'Etología', 'activo'),
  (8, 'Reproducción', 'activo'),
  (9, 'Estética', 'activo'),
  (10, 'Servicios a domicilio', 'activo');

-- --------------------------------------------------------
--
-- Table structure for table `tb_trabajador`
--
CREATE TABLE `tb_trabajador` (
  `id_trabajador` bigint(20) UNSIGNED NOT NULL,
  `id_persona` bigint(20) UNSIGNED NOT NULL,
  `id_grupo` bigint(20) UNSIGNED NOT NULL,
  `id_especialidad` bigint(20) UNSIGNED NOT NULL,
  `name_user` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `pass_user` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `cod_recuperacion` varchar(500) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fecha_activacion` date DEFAULT NULL,
  `fecha_recuperacion` date DEFAULT NULL,
  `src_imagen` varchar(500) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo',
  `flag_medico` tinyint(1) NOT NULL DEFAULT '0',
  `link_facebook` varchar(500) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `link_instagram` varchar(500) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `link_twitter` varchar(500) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `descripcion` varchar(1000) COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_trabajador`
--
INSERT INTO
  `tb_trabajador` (
    `id_trabajador`,
    `id_persona`,
    `id_grupo`,
    `id_especialidad`,
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
    2,
    4,
    'davidmoreno@gmail.com',
    '1dd4ecb6f7f0091bc464fee9b9202d59',
    NULL,
    '2019-10-16',
    NULL,
    'resources/global/images/persons/img-1571246568.png',
    'activo',
    1,
    'https://www.facebook.com',
    'https://www.instagram.com',
    'https://www.twitter.com',
    'Profesional muy destacado en el ambiente laboral, se caracteriza por su habilidad de comunicar al cliente.'
  ),
  (
    3,
    5,
    2,
    3,
    'irvingtovar@gmail.com',
    '1dd4ecb6f7f0091bc464fee9b9202d59',
    NULL,
    '2019-10-16',
    NULL,
    'resources/global/images/persons/img-1571246677.png',
    'activo',
    1,
    'https://www.facebook.com',
    'https://www.instagram.com',
    'https://www.twitter.com',
    'Su área de competencia es medicina interna y cirugía de tejidos blandos, con especial dedicación a la reproducción canina y endocrinóloga.'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_trabajador_servicio`
--
CREATE TABLE `tb_trabajador_servicio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_servicio` bigint(20) UNSIGNED NOT NULL,
  `id_trabajador` bigint(20) UNSIGNED NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_trabajador_servicio`
--
INSERT INTO
  `tb_trabajador_servicio` (`id`, `id_servicio`, `id_trabajador`)
VALUES
  (1, 1, 2),
  (2, 2, 2),
  (3, 3, 2),
  (4, 4, 2),
  (5, 5, 3),
  (6, 6, 3),
  (7, 7, 3);

-- --------------------------------------------------------
--
-- Table structure for table `tb_trabajador_sucursal`
--
CREATE TABLE `tb_trabajador_sucursal` (
  `id` bigint(20) NOT NULL,
  `id_trabajador` bigint(20) UNSIGNED DEFAULT NULL,
  `id_sucursal` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_trabajador_sucursal`
--
INSERT INTO
  `tb_trabajador_sucursal` (`id`, `id_trabajador`, `id_sucursal`)
VALUES
  (1, 1, 1),
  (2, 2, 1),
  (3, 3, 1);

-- --------------------------------------------------------
--
-- Table structure for table `tb_unidad_medida`
--
CREATE TABLE `tb_unidad_medida` (
  `id_unidad_medida` int(11) NOT NULL,
  `name_unidad` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_sunat` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_unidad_medida`
--
INSERT INTO
  `tb_unidad_medida` (
    `id_unidad_medida`,
    `name_unidad`,
    `cod_sunat`,
    `estado`
  )
VALUES
  (1, 'UNIDADES', 'NIU', '1'),
  (2, 'KILOGRAMOS', 'KGM', '1'),
  (3, 'CAJAS', 'BX', '1');

-- --------------------------------------------------------
--
-- Table structure for table `tb_vacuna`
--
CREATE TABLE `tb_vacuna` (
  `id_vacuna` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_mascota` bigint(20) UNSIGNED NOT NULL,
  `name_vacuna` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(1000) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `edad_minima` int(11) NOT NULL DEFAULT '1',
  `edad_maxima` int(11) DEFAULT NULL,
  `tipo` char(1) COLLATE utf8mb4_spanish_ci DEFAULT '0',
  `estado` enum('activo', 'inactivo') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

--
-- Dumping data for table `tb_vacuna`
--
INSERT INTO
  `tb_vacuna` (
    `id_vacuna`,
    `id_tipo_mascota`,
    `name_vacuna`,
    `descripcion`,
    `edad_minima`,
    `edad_maxima`,
    `tipo`,
    `estado`
  )
VALUES
  (
    1,
    1,
    'Primera Vacuna	',
    'Esta es una descripción de la vacuna	',
    12,
    20,
    '1',
    'activo'
  ),
  (
    2,
    1,
    'Segunda Vacuna',
    'Esta es una descripción de la vacuna.',
    30,
    40,
    '1',
    'activo'
  ),
  (
    3,
    1,
    'Tercera Vacuna',
    'Esta es una descripción de la vacuna.',
    70,
    80,
    '1',
    'activo'
  ),
  (
    4,
    1,
    'Cuarta Vacuna',
    'Esta es una descripción de la vacuna',
    100,
    110,
    '1',
    'activo'
  ),
  (
    5,
    2,
    'Primera Vacuna',
    'Esta es una descripción de la vacuna.',
    10,
    20,
    '1',
    'activo'
  ),
  (
    6,
    2,
    'Segunda Vacuna',
    'Esta es una descripción de la vacuna.',
    40,
    50,
    '1',
    'activo'
  ),
  (
    7,
    2,
    'Tercera Vacuna',
    'Esta es una descripción de la vacuna.',
    70,
    80,
    '1',
    'activo'
  ),
  (
    8,
    2,
    'Cuarta Vacuna',
    'Esta es una descripción de la vacuna.',
    120,
    140,
    '1',
    'activo'
  ),
  (
    9,
    3,
    'Primera Vacuna',
    'Esta es una descripción de la vacuna.',
    10,
    20,
    '1',
    'activo'
  ),
  (
    10,
    3,
    'Segunda Vacuna',
    'Esta es una descripción de la vacuna.',
    40,
    50,
    '1',
    'activo'
  );

-- --------------------------------------------------------
--
-- Table structure for table `tb_venta`
--
CREATE TABLE `tb_venta` (
  `id_venta` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_trabajador` bigint(20) UNSIGNED NOT NULL,
  `id_documento_venta` int(11) NOT NULL,
  `name_documento_venta` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_documento_venta` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correlativo` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_documento_cliente` bigint(20) UNSIGNED NOT NULL,
  `name_documento_cliente` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_documento_cliente` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_documento_cliente` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_forma_pago` int(11) NOT NULL,
  `codigo_forma_pago` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_forma_pago` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
  `descuento_total` decimal(18, 2) DEFAULT '0.00',
  `sub_total` decimal(18, 2) NOT NULL,
  `igv` decimal(18, 2) NOT NULL,
  `total` decimal(18, 2) NOT NULL,
  `estado` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `pdf` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xml` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cdr` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mensaje_sunat` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruta` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag_doc_interno` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `monto_recibido` decimal(18, 2) DEFAULT NULL,
  `vuelto` decimal(18, 2) DEFAULT NULL,
  `id_moneda` int(11) NOT NULL,
  `codigo_moneda` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signo_moneda` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abreviatura_moneda` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signo_moneda_cambio` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'S/ ',
  `monto_tipo_cambio` decimal(18, 2) DEFAULT NULL,
  `observaciones` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag_enviado` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_venta`
--
INSERT INTO
  `tb_venta` (
    `id_venta`,
    `id_sucursal`,
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
    '0.00',
    '1426.91',
    '256.84',
    '1683.75',
    '2',
    'https://www.pse.pe/cpe/b8bd5e9b-1ba7-4618-9a82-70c0ca8df487-e28e10e8-a836-469c-8540-ed8f0c8bf2b1.pdf',
    'https://www.pse.pe/cpe/b8bd5e9b-1ba7-4618-9a82-70c0ca8df487-e28e10e8-a836-469c-8540-ed8f0c8bf2b1.xml',
    'https://www.pse.pe/cpe/b8bd5e9b-1ba7-4618-9a82-70c0ca8df487-e28e10e8-a836-469c-8540-ed8f0c8bf2b1.cdr',
    NULL,
    'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4',
    'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc',
    '0',
    '1683.75',
    '0.00',
    1,
    '1',
    'S/',
    'PEN',
    'S/ ',
    '1.00',
    NULL,
    '1'
  );

-- --------------------------------------------------------
--
-- Stand-in structure for view `vw_mascotas`
-- (See below for the actual view)
--
CREATE TABLE `vw_mascotas` (
  `id_mascota` bigint(20) unsigned,
  `id_cliente` bigint(20) unsigned,
  `id_tipo_mascota` bigint(20) unsigned,
  `nombre` varchar(100),
  `raza` varchar(50),
  `color` varchar(50),
  `peso` varchar(50),
  `sexo` enum('hembra', 'macho'),
  `fecha_nacimiento` date,
  `observaciones` varchar(1000),
  `estado` enum('activo', 'inactivo'),
  `src_imagen` varchar(150),
  `name_tipo` varchar(50),
  `name_documento` varchar(100),
  `id_documento` bigint(20) unsigned,
  `num_documento` varchar(30),
  `nombres` varchar(100),
  `apellidos` varchar(100),
  `direccion` varchar(150),
  `telefono` varchar(30),
  `correo` varchar(150)
);

-- --------------------------------------------------------
--
-- Stand-in structure for view `vw_orden_compra`
-- (See below for the actual view)
--
CREATE TABLE `vw_orden_compra` (
  `id_orden_compra` int(18),
  `id_proveedor` int(11),
  `nombre_proveedor` varchar(201),
  `src_imagen_proveedor` varchar(300),
  `id_metodo_envio` int(11),
  `fecha_orden` datetime,
  `fecha_entrega` datetime,
  `observaciones` varchar(500),
  `id_moneda` int(11),
  `id_sucursal` int(11),
  `estado_int` char(1),
  `estado` varchar(14),
  `cod_producto` int(18),
  `name_tabla` varchar(100),
  `name_producto` varchar(100),
  `stock` int(11),
  `precio_unitario` decimal(18, 2),
  `cantidad_solicitada` int(11),
  `notas` varchar(237),
  `total` decimal(28, 2),
  `src_imagen_producto` varchar(150),
  `cantidad_ingresada` int(11)
);

-- --------------------------------------------------------
--
-- Stand-in structure for view `vw_productos_agotados`
-- (See below for the actual view)
--
CREATE TABLE `vw_productos_agotados` (
  `descripcion_producto` varchar(100),
  `stock` int(11),
  `stock_minimo` int(11),
  `nombre_sucursal` varchar(300),
  `name_unidad` varchar(10)
);

-- --------------------------------------------------------
--
-- Stand-in structure for view `vw_proveedor`
-- (See below for the actual view)
--
CREATE TABLE `vw_proveedor` (
  `id_proveedor` int(11),
  `id_persona_proveedor` bigint(20) unsigned,
  `estado_proveedor` char(1),
  `id_documento_proveedor` bigint(20) unsigned,
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
-- Stand-in structure for view `vw_trabajadores`
-- (See below for the actual view)
--
CREATE TABLE `vw_trabajadores` (
  `id_trabajador` bigint(20) unsigned,
  `id_persona` bigint(20) unsigned,
  `id_grupo` bigint(20) unsigned,
  `id_especialidad` bigint(20) unsigned,
  `name_user` varchar(100),
  `pass_user` varchar(500),
  `cod_recuperacion` varchar(500),
  `fecha_activacion` date,
  `fecha_recuperacion` date,
  `src_imagen` varchar(500),
  `estado` enum('activo', 'inactivo'),
  `flag_medico` tinyint(1),
  `link_facebook` varchar(500),
  `link_instagram` varchar(500),
  `link_twitter` varchar(500),
  `descripcion` varchar(1000),
  `id_documento` bigint(20) unsigned,
  `num_documento` varchar(30),
  `nombres_trabajador` varchar(100),
  `apellidos_trabajador` varchar(100),
  `direccion_trabajador` varchar(150),
  `telefono_trabajador` varchar(30),
  `correo_trabajador` varchar(150),
  `fecha_nacimiento_trabajador` date,
  `sexo_trabajador` enum('masculino', 'femenino'),
  `name_documento_trabajador` varchar(100)
);

-- --------------------------------------------------------
--
-- Structure for view `vw_mascotas`
--
DROP TABLE IF EXISTS `vw_mascotas`;

CREATE ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `vw_mascotas` AS
select
  `m`.`id_mascota` AS `id_mascota`,
  `m`.`id_cliente` AS `id_cliente`,
  `m`.`id_tipo_mascota` AS `id_tipo_mascota`,
  `m`.`nombre` AS `nombre`,
  `m`.`raza` AS `raza`,
  `m`.`color` AS `color`,
  `m`.`peso` AS `peso`,
  `m`.`sexo` AS `sexo`,
  `m`.`fecha_nacimiento` AS `fecha_nacimiento`,
  `m`.`observaciones` AS `observaciones`,
  `m`.`estado` AS `estado`,
  `m`.`src_imagen` AS `src_imagen`,
  `t`.`name_tipo` AS `name_tipo`,
  `di`.`name_documento` AS `name_documento`,
  `p`.`id_documento` AS `id_documento`,
  `p`.`num_documento` AS `num_documento`,
  `p`.`nombres` AS `nombres`,
  `p`.`apellidos` AS `apellidos`,
  `p`.`direccion` AS `direccion`,
  `p`.`telefono` AS `telefono`,
  `p`.`correo` AS `correo`
from
  (
    (
      (
        (
          `tb_mascota` `m`
          join `tb_cliente` `c` on((`c`.`id_cliente` = `m`.`id_cliente`))
        )
        join `tb_tipo_mascota` `t` on((`t`.`id_tipo_mascota` = `m`.`id_tipo_mascota`))
      )
      join `tb_persona` `p` on((`p`.`id_persona` = `c`.`id_persona`))
    )
    join `tb_documento_identidad` `di` on((`di`.`id_documento` = `p`.`id_documento`))
  );

-- --------------------------------------------------------
--
-- Structure for view `vw_orden_compra`
--
DROP TABLE IF EXISTS `vw_orden_compra`;

CREATE ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `vw_orden_compra` AS
select
  `o`.`id_orden_compra` AS `id_orden_compra`,
  `o`.`id_proveedor` AS `id_proveedor`,
  `pr`.`nombre_proveedor` AS `nombre_proveedor`,
  `pr`.`src_imagen_proveedor` AS `src_imagen_proveedor`,
  `o`.`id_metodo_envio` AS `id_metodo_envio`,
  `o`.`fecha_orden` AS `fecha_orden`,
  `o`.`fecha_entrega` AS `fecha_entrega`,
  `o`.`observaciones` AS `observaciones`,
  `o`.`id_moneda` AS `id_moneda`,
  `o`.`id_sucursal` AS `id_sucursal`,
  `o`.`estado` AS `estado_int`,
(
    case
      when (`o`.`estado` = '0') then 'EN proceso ...'
      when (`o`.`estado` = '1') then 'EN espera ...'
      when (`o`.`estado` = '2') then 'Recibido'
      when (`o`.`estado` = '3') then 'Anulado'
    end
  ) AS `estado`,
  `dc`.`cod_producto` AS `cod_producto`,
  `dc`.`name_tabla` AS `name_tabla`,
  `pro`.`name_accesorio` AS `name_producto`,
  `pro`.`stock` AS `stock`,
  `dc`.`precio_unitario` AS `precio_unitario`,
  `dc`.`cantidad_solicitada` AS `cantidad_solicitada`,
(
    case
      when (`dc`.`cantidad_ingresada` > 0) then concat(
        'Ingresaron ',
        `dc`.`cantidad_ingresada`,
        ' de ',
        `dc`.`cantidad_solicitada`,
        `dc`.`notas`
      )
      when (
        (`dc`.`cantidad_ingresada` = 0)
        and (`o`.`estado` = '1')
      ) then concat(
        'Ingresaron ',
        `dc`.`cantidad_ingresada`,
        ' de ',
        `dc`.`cantidad_solicitada`,
        `dc`.`notas`
      )
      else `dc`.`notas`
    end
  ) AS `notas`,
(
    `dc`.`precio_unitario` * `dc`.`cantidad_solicitada`
  ) AS `total`,
  `pro`.`src_imagen` AS `src_imagen_producto`,
  `dc`.`cantidad_ingresada` AS `cantidad_ingresada`
from
  (
    (
      (
        `tb_orden_compra` `o`
        join `vw_proveedor` `pr` on((`pr`.`id_proveedor` = `o`.`id_proveedor`))
      )
      join `tb_detalle_compra` `dc` on(
        (
          (`dc`.`id_orden_compra` = `o`.`id_orden_compra`)
          and (`dc`.`name_tabla` = 'accesorio')
        )
      )
    )
    join `tb_accesorio` `pro` on((`pro`.`id_accesorio` = `dc`.`cod_producto`))
  )
union
select
  `o`.`id_orden_compra` AS `id_orden_compra`,
  `o`.`id_proveedor` AS `id_proveedor`,
  `pr`.`nombre_proveedor` AS `nombre_proveedor`,
  `pr`.`src_imagen_proveedor` AS `src_imagen_proveedor`,
  `o`.`id_metodo_envio` AS `id_metodo_envio`,
  `o`.`fecha_orden` AS `fecha_orden`,
  `o`.`fecha_entrega` AS `fecha_entrega`,
  `o`.`observaciones` AS `observaciones`,
  `o`.`id_moneda` AS `id_moneda`,
  `o`.`id_sucursal` AS `id_sucursal`,
  `o`.`estado` AS `estado_int`,
(
    case
      when (`o`.`estado` = '0') then 'EN proceso ...'
      when (`o`.`estado` = '1') then 'EN espera ...'
      when (`o`.`estado` = '2') then 'Recibido'
      when (`o`.`estado` = '3') then 'Anulado'
    end
  ) AS `estado`,
  `dc`.`cod_producto` AS `cod_producto`,
  `dc`.`name_tabla` AS `name_tabla`,
  `pro`.`name_medicamento` AS `name_producto`,
  `pro`.`stock` AS `stock`,
  `dc`.`precio_unitario` AS `precio_unitario`,
  `dc`.`cantidad_solicitada` AS `cantidad_solicitada`,
(
    case
      when (`dc`.`cantidad_ingresada` > 0) then concat(
        'Ingresaron ',
        `dc`.`cantidad_ingresada`,
        ' de ',
        `dc`.`cantidad_solicitada`,
        `dc`.`notas`
      )
      when (
        (`dc`.`cantidad_ingresada` = 0)
        and (`o`.`estado` = '1')
      ) then concat(
        'Ingresaron ',
        `dc`.`cantidad_ingresada`,
        ' de ',
        `dc`.`cantidad_solicitada`,
        `dc`.`notas`
      )
      else `dc`.`notas`
    end
  ) AS `notas`,
(
    `dc`.`precio_unitario` * `dc`.`cantidad_solicitada`
  ) AS `total`,
  `pro`.`src_imagen` AS `src_imagen_producto`,
  `dc`.`cantidad_ingresada` AS `cantidad_ingresada`
from
  (
    (
      (
        `tb_orden_compra` `o`
        join `vw_proveedor` `pr` on((`pr`.`id_proveedor` = `o`.`id_proveedor`))
      )
      join `tb_detalle_compra` `dc` on(
        (
          (`dc`.`id_orden_compra` = `o`.`id_orden_compra`)
          and (`dc`.`name_tabla` = 'medicamento')
        )
      )
    )
    join `tb_medicamento` `pro` on((`pro`.`id_medicamento` = `dc`.`cod_producto`))
  );

-- --------------------------------------------------------
--
-- Structure for view `vw_productos_agotados`
--
DROP TABLE IF EXISTS `vw_productos_agotados`;

CREATE ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `vw_productos_agotados` AS
select
  `m`.`name_medicamento` AS `descripcion_producto`,
  `m`.`stock` AS `stock`,
  `m`.`stock_minimo` AS `stock_minimo`,
  `s`.`nombre` AS `nombre_sucursal`,
  `u`.`cod_sunat` AS `name_unidad`
from
  (
    (
      `tb_medicamento` `m`
      join `tb_sucursal` `s` on((`s`.`id_sucursal` = `m`.`id_sucursal`))
    )
    join `tb_unidad_medida` `u` on(
      (`u`.`id_unidad_medida` = `m`.`id_unidad_medida`)
    )
  )
where
  (`m`.`stock_minimo` >= `m`.`stock`)
union
select
  `a`.`name_accesorio` AS `descripcion_producto`,
  `a`.`stock` AS `stock`,
  `a`.`stock_minimo` AS `stock_minimo`,
  `s`.`nombre` AS `nombre_sucursal`,
  `u`.`cod_sunat` AS `name_unidad`
from
  (
    (
      `tb_accesorio` `a`
      join `tb_sucursal` `s` on((`s`.`id_sucursal` = `a`.`id_sucursal`))
    )
    join `tb_unidad_medida` `u` on(
      (`u`.`id_unidad_medida` = `a`.`id_unidad_medida`)
    )
  )
where
  (`a`.`stock_minimo` >= `a`.`stock`);

-- --------------------------------------------------------
--
-- Structure for view `vw_proveedor`
--
DROP TABLE IF EXISTS `vw_proveedor`;

CREATE ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `vw_proveedor` AS
select
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
from
  (
    `tb_persona` `p`
    join `tb_proveedor` `pr` on((`pr`.`id_persona` = `p`.`id_persona`))
  );

-- --------------------------------------------------------
--
-- Structure for view `vw_trabajadores`
--
DROP TABLE IF EXISTS `vw_trabajadores`;

CREATE ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `vw_trabajadores` AS
select
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
from
  (
    (
      `tb_trabajador` `t`
      join `tb_persona` `p` on((`p`.`id_persona` = `t`.`id_persona`))
    )
    join `tb_documento_identidad` `d` on((`d`.`id_documento` = `p`.`id_documento`))
  );

--
-- Indexes for dumped tables
--
--
-- Indexes for table `tb_accesorio`
--
ALTER TABLE
  `tb_accesorio`
ADD
  PRIMARY KEY (`id_accesorio`),
ADD
  KEY `tb_accesorio_id_categoria_foreign` (`id_categoria`),
ADD
  KEY `id_sucursal` (`id_sucursal`),
ADD
  KEY `id_unidad_medida` (`id_unidad_medida`),
ADD
  KEY `id_moneda` (`id_moneda`);

--
-- Indexes for table `tb_acceso_opcion`
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
-- Indexes for table `tb_categoria_accesorio`
--
ALTER TABLE
  `tb_categoria_accesorio`
ADD
  PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `tb_cita`
--
ALTER TABLE
  `tb_cita`
ADD
  PRIMARY KEY (`id_cita`),
ADD
  KEY `tb_cita_id_trabajador_foreign` (`id_trabajador`),
ADD
  KEY `tb_cita_id_servicio_foreign` (`id_servicio`),
ADD
  KEY `tb_cita_id_mascota_foreign` (`id_mascota`),
ADD
  KEY `id_sucursal` (`id_sucursal`);

--
-- Indexes for table `tb_cliente`
--
ALTER TABLE
  `tb_cliente`
ADD
  PRIMARY KEY (`id_cliente`),
ADD
  UNIQUE KEY `tb_cliente_name_user_unique` (`name_user`),
ADD
  KEY `tb_cliente_id_persona_foreign` (`id_persona`);

--
-- Indexes for table `tb_compra`
--
ALTER TABLE
  `tb_compra`
ADD
  PRIMARY KEY (`id_compra`),
ADD
  UNIQUE KEY `id_compra` (`id_compra`),
ADD
  KEY `id_sucursal` (`id_sucursal`),
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
-- Indexes for table `tb_detalle_cita`
--
ALTER TABLE
  `tb_detalle_cita`
ADD
  PRIMARY KEY (`id_detalle`),
ADD
  KEY `id_cita` (`id_cita`);

--
-- Indexes for table `tb_detalle_compra`
--
ALTER TABLE
  `tb_detalle_compra`
ADD
  PRIMARY KEY (`id_detalle`);

--
-- Indexes for table `tb_detalle_ingreso`
--
ALTER TABLE
  `tb_detalle_ingreso`
ADD
  PRIMARY KEY (`id_detalle`);

--
-- Indexes for table `tb_detalle_venta`
--
ALTER TABLE
  `tb_detalle_venta`
ADD
  PRIMARY KEY (`id_detalle`),
ADD
  KEY `id_venta` (`id_venta`);

--
-- Indexes for table `tb_documento_identidad`
--
ALTER TABLE
  `tb_documento_identidad`
ADD
  PRIMARY KEY (`id_documento`);

--
-- Indexes for table `tb_documento_venta`
--
ALTER TABLE
  `tb_documento_venta`
ADD
  PRIMARY KEY (`id_documento_venta`),
ADD
  KEY `id_sucursal` (`id_sucursal`);

--
-- Indexes for table `tb_empresa`
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
-- Indexes for table `tb_especialidad`
--
ALTER TABLE
  `tb_especialidad`
ADD
  PRIMARY KEY (`id_especialidad`);

--
-- Indexes for table `tb_forma_pago`
--
ALTER TABLE
  `tb_forma_pago`
ADD
  PRIMARY KEY (`id_forma_pago`);

--
-- Indexes for table `tb_galeria`
--
ALTER TABLE
  `tb_galeria`
ADD
  PRIMARY KEY (`id`);

--
-- Indexes for table `tb_grupo_usuario`
--
ALTER TABLE
  `tb_grupo_usuario`
ADD
  PRIMARY KEY (`id_grupo`);

--
-- Indexes for table `tb_ingreso`
--
ALTER TABLE
  `tb_ingreso`
ADD
  PRIMARY KEY (`id_ingreso`);

--
-- Indexes for table `tb_mascota`
--
ALTER TABLE
  `tb_mascota`
ADD
  PRIMARY KEY (`id_mascota`),
ADD
  KEY `tb_mascota_id_cliente_foreign` (`id_cliente`),
ADD
  KEY `tb_mascota_id_tipo_mascota_foreign` (`id_tipo_mascota`);

--
-- Indexes for table `tb_mascota_vacuna`
--
ALTER TABLE
  `tb_mascota_vacuna`
ADD
  PRIMARY KEY (`id_mascota_vacuna`),
ADD
  KEY `tb_mascota_vacuna_id_mascota_foreign` (`id_mascota`),
ADD
  KEY `tb_mascota_vacuna_id_vacuna_foreign` (`id_vacuna`);

--
-- Indexes for table `tb_medicamento`
--
ALTER TABLE
  `tb_medicamento`
ADD
  PRIMARY KEY (`id_medicamento`),
ADD
  KEY `tb_medicamento_id_tipo_medicamento_foreign` (`id_tipo_medicamento`),
ADD
  KEY `id_sucursal` (`id_sucursal`),
ADD
  KEY `id_unidad_medida` (`id_unidad_medida`),
ADD
  KEY `id_moneda` (`id_moneda`);

--
-- Indexes for table `tb_metodo_envio`
--
ALTER TABLE
  `tb_metodo_envio`
ADD
  PRIMARY KEY (`id_metodo_envio`);

--
-- Indexes for table `tb_moneda`
--
ALTER TABLE
  `tb_moneda`
ADD
  PRIMARY KEY (`id_moneda`);

--
-- Indexes for table `tb_opcion`
--
ALTER TABLE
  `tb_opcion`
ADD
  PRIMARY KEY (`id_opcion`);

--
-- Indexes for table `tb_orden_compra`
--
ALTER TABLE
  `tb_orden_compra`
ADD
  PRIMARY KEY (`id_orden_compra`);

--
-- Indexes for table `tb_parametros_generales`
--
ALTER TABLE
  `tb_parametros_generales`
ADD
  PRIMARY KEY (`id_parametro`);

--
-- Indexes for table `tb_persona`
--
ALTER TABLE
  `tb_persona`
ADD
  PRIMARY KEY (`id_persona`),
ADD
  KEY `tb_persona_id_documento_num_documento_index` (`id_documento`, `num_documento`);

--
-- Indexes for table `tb_promocion`
--
ALTER TABLE
  `tb_promocion`
ADD
  PRIMARY KEY (`id_promocion`),
ADD
  KEY `id_cliente` (`id_cliente`);

--
-- Indexes for table `tb_proveedor`
--
ALTER TABLE
  `tb_proveedor`
ADD
  PRIMARY KEY (`id_proveedor`),
ADD
  KEY `id_persona` (`id_persona`);

--
-- Indexes for table `tb_proveedor_observaciones`
--
ALTER TABLE
  `tb_proveedor_observaciones`
ADD
  PRIMARY KEY (`id_detalle`),
ADD
  KEY `id_proveedor` (`id_proveedor`);

--
-- Indexes for table `tb_servicio`
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
-- Indexes for table `tb_sucursal`
--
ALTER TABLE
  `tb_sucursal`
ADD
  PRIMARY KEY (`id_sucursal`),
ADD
  KEY `id_empresa` (`id_empresa`);

--
-- Indexes for table `tb_tipo_cambio`
--
ALTER TABLE
  `tb_tipo_cambio`
ADD
  PRIMARY KEY (`id`),
ADD
  KEY `id_moneda` (`id_moneda`);

--
-- Indexes for table `tb_tipo_mascota`
--
ALTER TABLE
  `tb_tipo_mascota`
ADD
  PRIMARY KEY (`id_tipo_mascota`);

--
-- Indexes for table `tb_tipo_medicamento`
--
ALTER TABLE
  `tb_tipo_medicamento`
ADD
  PRIMARY KEY (`id_tipo_medicamento`);

--
-- Indexes for table `tb_tipo_servicio`
--
ALTER TABLE
  `tb_tipo_servicio`
ADD
  PRIMARY KEY (`id_tipo_servicio`);

--
-- Indexes for table `tb_trabajador`
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
  KEY `fktb_trabajador_tbgrupousuario` (`id_grupo`),
ADD
  KEY `fktb_trabajador_tbespecialidad` (`id_especialidad`);

--
-- Indexes for table `tb_trabajador_servicio`
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
-- Indexes for table `tb_trabajador_sucursal`
--
ALTER TABLE
  `tb_trabajador_sucursal`
ADD
  PRIMARY KEY (`id`),
ADD
  KEY `id_trabajador` (`id_trabajador`),
ADD
  KEY `id_sucursal` (`id_sucursal`);

--
-- Indexes for table `tb_unidad_medida`
--
ALTER TABLE
  `tb_unidad_medida`
ADD
  PRIMARY KEY (`id_unidad_medida`);

--
-- Indexes for table `tb_vacuna`
--
ALTER TABLE
  `tb_vacuna`
ADD
  PRIMARY KEY (`id_vacuna`),
ADD
  KEY `tb_vacuna_id_tipo_mascota_foreign` (`id_tipo_mascota`);

--
-- Indexes for table `tb_venta`
--
ALTER TABLE
  `tb_venta`
ADD
  PRIMARY KEY (`id_venta`),
ADD
  UNIQUE KEY `id_venta` (`id_venta`),
ADD
  KEY `id_sucursal` (`id_sucursal`),
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
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `tb_accesorio`
--
ALTER TABLE
  `tb_accesorio`
MODIFY
  `id_accesorio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 9;

--
-- AUTO_INCREMENT for table `tb_acceso_opcion`
--
ALTER TABLE
  `tb_acceso_opcion`
MODIFY
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 432;

--
-- AUTO_INCREMENT for table `tb_categoria_accesorio`
--
ALTER TABLE
  `tb_categoria_accesorio`
MODIFY
  `id_categoria` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT for table `tb_cita`
--
ALTER TABLE
  `tb_cita`
MODIFY
  `id_cita` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `tb_cliente`
--
ALTER TABLE
  `tb_cliente`
MODIFY
  `id_cliente` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `tb_compra`
--
ALTER TABLE
  `tb_compra`
MODIFY
  `id_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_detalle_cita`
--
ALTER TABLE
  `tb_detalle_cita`
MODIFY
  `id_detalle` bigint(20) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `tb_detalle_compra`
--
ALTER TABLE
  `tb_detalle_compra`
MODIFY
  `id_detalle` bigint(20) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 25;

--
-- AUTO_INCREMENT for table `tb_detalle_ingreso`
--
ALTER TABLE
  `tb_detalle_ingreso`
MODIFY
  `id_detalle` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_documento_identidad`
--
ALTER TABLE
  `tb_documento_identidad`
MODIFY
  `id_documento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT for table `tb_documento_venta`
--
ALTER TABLE
  `tb_documento_venta`
MODIFY
  `id_documento_venta` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `tb_empresa`
--
ALTER TABLE
  `tb_empresa`
MODIFY
  `id_empresa` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `tb_especialidad`
--
ALTER TABLE
  `tb_especialidad`
MODIFY
  `id_especialidad` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 10;

--
-- AUTO_INCREMENT for table `tb_forma_pago`
--
ALTER TABLE
  `tb_forma_pago`
MODIFY
  `id_forma_pago` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT for table `tb_galeria`
--
ALTER TABLE
  `tb_galeria`
MODIFY
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT for table `tb_grupo_usuario`
--
ALTER TABLE
  `tb_grupo_usuario`
MODIFY
  `id_grupo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `tb_mascota`
--
ALTER TABLE
  `tb_mascota`
MODIFY
  `id_mascota` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `tb_mascota_vacuna`
--
ALTER TABLE
  `tb_mascota_vacuna`
MODIFY
  `id_mascota_vacuna` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT for table `tb_medicamento`
--
ALTER TABLE
  `tb_medicamento`
MODIFY
  `id_medicamento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `tb_moneda`
--
ALTER TABLE
  `tb_moneda`
MODIFY
  `id_moneda` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `tb_persona`
--
ALTER TABLE
  `tb_persona`
MODIFY
  `id_persona` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT for table `tb_promocion`
--
ALTER TABLE
  `tb_promocion`
MODIFY
  `id_promocion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_proveedor`
--
ALTER TABLE
  `tb_proveedor`
MODIFY
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `tb_proveedor_observaciones`
--
ALTER TABLE
  `tb_proveedor_observaciones`
MODIFY
  `id_detalle` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_servicio`
--
ALTER TABLE
  `tb_servicio`
MODIFY
  `id_servicio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT for table `tb_sucursal`
--
ALTER TABLE
  `tb_sucursal`
MODIFY
  `id_sucursal` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `tb_tipo_cambio`
--
ALTER TABLE
  `tb_tipo_cambio`
MODIFY
  `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT for table `tb_tipo_mascota`
--
ALTER TABLE
  `tb_tipo_mascota`
MODIFY
  `id_tipo_mascota` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `tb_tipo_medicamento`
--
ALTER TABLE
  `tb_tipo_medicamento`
MODIFY
  `id_tipo_medicamento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 7;

--
-- AUTO_INCREMENT for table `tb_tipo_servicio`
--
ALTER TABLE
  `tb_tipo_servicio`
MODIFY
  `id_tipo_servicio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 11;

--
-- AUTO_INCREMENT for table `tb_trabajador`
--
ALTER TABLE
  `tb_trabajador`
MODIFY
  `id_trabajador` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `tb_trabajador_servicio`
--
ALTER TABLE
  `tb_trabajador_servicio`
MODIFY
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT for table `tb_trabajador_sucursal`
--
ALTER TABLE
  `tb_trabajador_sucursal`
MODIFY
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `tb_unidad_medida`
--
ALTER TABLE
  `tb_unidad_medida`
MODIFY
  `id_unidad_medida` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `tb_vacuna`
--
ALTER TABLE
  `tb_vacuna`
MODIFY
  `id_vacuna` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 11;

--
-- AUTO_INCREMENT for table `tb_venta`
--
ALTER TABLE
  `tb_venta`
MODIFY
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- Constraints for dumped tables
--
--
-- Constraints for table `tb_accesorio`
--
ALTER TABLE
  `tb_accesorio`
ADD
  CONSTRAINT `tb_accesorio_ibfk_3` FOREIGN KEY (`id_unidad_medida`) REFERENCES `tb_unidad_medida` (`id_unidad_medida`),
ADD
  CONSTRAINT `tb_accesorio_ibfk_4` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
ADD
  CONSTRAINT `tb_accesorio_ibfk_5` FOREIGN KEY (`id_moneda`) REFERENCES `tb_moneda` (`id_moneda`),
ADD
  CONSTRAINT `tb_accesorio_id_categoria_foreign` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria_accesorio` (`id_categoria`);

--
-- Constraints for table `tb_acceso_opcion`
--
ALTER TABLE
  `tb_acceso_opcion`
ADD
  CONSTRAINT `tb_acceso_opcion_id_grupo_foreign` FOREIGN KEY (`id_grupo`) REFERENCES `tb_grupo_usuario` (`id_grupo`),
ADD
  CONSTRAINT `tb_acceso_opcion_id_opcion_foreign` FOREIGN KEY (`id_opcion`) REFERENCES `tb_opcion` (`id_opcion`);

--
-- Constraints for table `tb_cita`
--
ALTER TABLE
  `tb_cita`
ADD
  CONSTRAINT `tb_cita_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
ADD
  CONSTRAINT `tb_cita_id_mascota_foreign` FOREIGN KEY (`id_mascota`) REFERENCES `tb_mascota` (`id_mascota`),
ADD
  CONSTRAINT `tb_cita_id_servicio_foreign` FOREIGN KEY (`id_servicio`) REFERENCES `tb_servicio` (`id_servicio`),
ADD
  CONSTRAINT `tb_cita_id_trabajador_foreign` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

--
-- Constraints for table `tb_cliente`
--
ALTER TABLE
  `tb_cliente`
ADD
  CONSTRAINT `tb_cliente_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`);

--
-- Constraints for table `tb_compra`
--
ALTER TABLE
  `tb_compra`
ADD
  CONSTRAINT `tb_compra_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
ADD
  CONSTRAINT `tb_compra_ibfk_2` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

--
-- Constraints for table `tb_detalle_cita`
--
ALTER TABLE
  `tb_detalle_cita`
ADD
  CONSTRAINT `tb_detalle_cita_ibfk_1` FOREIGN KEY (`id_cita`) REFERENCES `tb_cita` (`id_cita`);

--
-- Constraints for table `tb_detalle_venta`
--
ALTER TABLE
  `tb_detalle_venta`
ADD
  CONSTRAINT `tb_detalle_venta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `tb_venta` (`id_venta`);

--
-- Constraints for table `tb_documento_venta`
--
ALTER TABLE
  `tb_documento_venta`
ADD
  CONSTRAINT `tb_documento_venta_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`);

--
-- Constraints for table `tb_empresa`
--
ALTER TABLE
  `tb_empresa`
ADD
  CONSTRAINT `tb_empresa_id_documento_foreign` FOREIGN KEY (`id_documento`) REFERENCES `tb_documento_identidad` (`id_documento`),
ADD
  CONSTRAINT `tb_empresa_id_documento_representante_foreign` FOREIGN KEY (`id_documento_representante`) REFERENCES `tb_documento_identidad` (`id_documento`);

--
-- Constraints for table `tb_mascota`
--
ALTER TABLE
  `tb_mascota`
ADD
  CONSTRAINT `tb_mascota_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id_cliente`),
ADD
  CONSTRAINT `tb_mascota_id_tipo_mascota_foreign` FOREIGN KEY (`id_tipo_mascota`) REFERENCES `tb_tipo_mascota` (`id_tipo_mascota`);

--
-- Constraints for table `tb_mascota_vacuna`
--
ALTER TABLE
  `tb_mascota_vacuna`
ADD
  CONSTRAINT `tb_mascota_vacuna_id_mascota_foreign` FOREIGN KEY (`id_mascota`) REFERENCES `tb_mascota` (`id_mascota`),
ADD
  CONSTRAINT `tb_mascota_vacuna_id_vacuna_foreign` FOREIGN KEY (`id_vacuna`) REFERENCES `tb_vacuna` (`id_vacuna`);

--
-- Constraints for table `tb_medicamento`
--
ALTER TABLE
  `tb_medicamento`
ADD
  CONSTRAINT `tb_medicamento_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
ADD
  CONSTRAINT `tb_medicamento_ibfk_2` FOREIGN KEY (`id_unidad_medida`) REFERENCES `tb_unidad_medida` (`id_unidad_medida`),
ADD
  CONSTRAINT `tb_medicamento_ibfk_3` FOREIGN KEY (`id_moneda`) REFERENCES `tb_moneda` (`id_moneda`),
ADD
  CONSTRAINT `tb_medicamento_id_tipo_medicamento_foreign` FOREIGN KEY (`id_tipo_medicamento`) REFERENCES `tb_tipo_medicamento` (`id_tipo_medicamento`);

--
-- Constraints for table `tb_persona`
--
ALTER TABLE
  `tb_persona`
ADD
  CONSTRAINT `fk_tbpersona_documento_ident` FOREIGN KEY (`id_documento`) REFERENCES `tb_documento_identidad` (`id_documento`);

--
-- Constraints for table `tb_promocion`
--
ALTER TABLE
  `tb_promocion`
ADD
  CONSTRAINT `tb_promocion_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id_cliente`);

--
-- Constraints for table `tb_proveedor`
--
ALTER TABLE
  `tb_proveedor`
ADD
  CONSTRAINT `tb_proveedor_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`);

--
-- Constraints for table `tb_proveedor_observaciones`
--
ALTER TABLE
  `tb_proveedor_observaciones`
ADD
  CONSTRAINT `tb_proveedor_observaciones_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `tb_proveedor` (`id_proveedor`);

--
-- Constraints for table `tb_servicio`
--
ALTER TABLE
  `tb_servicio`
ADD
  CONSTRAINT `fk_tbtiposervicio_servicio` FOREIGN KEY (`id_tipo_servicio`) REFERENCES `tb_tipo_servicio` (`id_tipo_servicio`),
ADD
  CONSTRAINT `tb_servicio_ibfk_1` FOREIGN KEY (`id_moneda`) REFERENCES `tb_moneda` (`id_moneda`);

--
-- Constraints for table `tb_sucursal`
--
ALTER TABLE
  `tb_sucursal`
ADD
  CONSTRAINT `tb_sucursal_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `tb_empresa` (`id_empresa`);

--
-- Constraints for table `tb_tipo_cambio`
--
ALTER TABLE
  `tb_tipo_cambio`
ADD
  CONSTRAINT `tb_tipo_cambio_ibfk_1` FOREIGN KEY (`id_moneda`) REFERENCES `tb_moneda` (`id_moneda`);

--
-- Constraints for table `tb_trabajador`
--
ALTER TABLE
  `tb_trabajador`
ADD
  CONSTRAINT `fk_tbpersona_tb_trabajador` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`),
ADD
  CONSTRAINT `fktb_trabajador_tbespecialidad` FOREIGN KEY (`id_especialidad`) REFERENCES `tb_especialidad` (`id_especialidad`),
ADD
  CONSTRAINT `fktb_trabajador_tbgrupousuario` FOREIGN KEY (`id_grupo`) REFERENCES `tb_grupo_usuario` (`id_grupo`);

--
-- Constraints for table `tb_trabajador_servicio`
--
ALTER TABLE
  `tb_trabajador_servicio`
ADD
  CONSTRAINT `tb_trabajador_servicio_id_servicio_foreign` FOREIGN KEY (`id_servicio`) REFERENCES `tb_servicio` (`id_servicio`),
ADD
  CONSTRAINT `tb_trabajador_servicio_id_trabajador_foreign` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

--
-- Constraints for table `tb_trabajador_sucursal`
--
ALTER TABLE
  `tb_trabajador_sucursal`
ADD
  CONSTRAINT `tb_trabajador_sucursal_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
ADD
  CONSTRAINT `tb_trabajador_sucursal_ibfk_2` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

--
-- Constraints for table `tb_vacuna`
--
ALTER TABLE
  `tb_vacuna`
ADD
  CONSTRAINT `tb_vacuna_id_tipo_mascota_foreign` FOREIGN KEY (`id_tipo_mascota`) REFERENCES `tb_tipo_mascota` (`id_tipo_mascota`);

--
-- Constraints for table `tb_venta`
--
ALTER TABLE
  `tb_venta`
ADD
  CONSTRAINT `tb_venta_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
ADD
  CONSTRAINT `tb_venta_ibfk_2` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;