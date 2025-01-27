

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `tb_accesorio` (
  `id_accesorio` bigint(20) UNSIGNED NOT NULL,
  `id_sucursal` int(11) NOT NULL DEFAULT 1,
  `id_categoria` bigint(20) UNSIGNED NOT NULL,
  `id_unidad_medida` int(11) NOT NULL DEFAULT 1,
  `name_accesorio` varchar(100) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 0,
  `precio_compra` double(8,2) NOT NULL DEFAULT 0.00,
  `id_moneda` int(11) NOT NULL DEFAULT 1,
  `signo_moneda` varchar(10) NOT NULL DEFAULT 'S/',
  `precio_venta` double(8,2) NOT NULL DEFAULT 0.00,
  `flag_igv` char(1) NOT NULL DEFAULT '1',
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `src_imagen` varchar(150) DEFAULT NULL,
  `flag_consumo` enum('SI','NO') DEFAULT 'SI'
) ;


INSERT INTO `tb_accesorio` (`id_accesorio`, `id_sucursal`, `id_categoria`, `id_unidad_medida`, `name_accesorio`, `descripcion`, `stock`, `stock_minimo`, `precio_compra`, `id_moneda`, `signo_moneda`, `precio_venta`, `flag_igv`, `estado`, `src_imagen`, `flag_consumo`) VALUES
(1, 1, 3, 1, 'BOCINA DE POLEA DE HST', 'W2.5DA-03H-10-02-00', 3, 3, 70.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/accesorios/img-1734559439.png', 'SI'),
(2, 1, 3, 1, 'BOCINA DEL ROTOR', 'W2.5K-02S-02-01-00A', 0, 2, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(3, 1, 3, 1, 'BOCINA DE MANGA', 'ZKB80-305-003', 0, 4, 25.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(5, 1, 3, 1, 'BOCINA DE CARRIL', 'W1.8-33-06-04-00', 9, 10, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(6, 1, 3, 1, 'BASE DEL EJE DE LA GARGANTA', 'W.2.5E-01B-02-38X', 1, 1, 180.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(7, 1, 4, 1, 'CADENA DEL GRANO LIMPIO', 'W2.5K-02PB-10A-15', 0, 3, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(8, 1, 4, 1, 'CADENA DEL BANERO', 'W2.5-02-02-11-06', 1, 3, 25.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(9, 1, 4, 1, 'CADENA DE ALIMENTACION COMPLETA', 'W3.5-01A-02-09-00', 0, 1, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(10, 1, 4, 1, 'ANGULO DE LA CADENA DE CORTE', 'W2.5E-01B-02-09B-02', 0, 3, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(11, 1, 5, 1, 'PIÑON DE DESCARGUE DE 22 DIENTES', 'W2.5B-04HX-11-02', 3, 2, 59.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(12, 1, 5, 1, 'PIÑON DE DESCARGUE DE 15 DIENTES', 'W2.5B-04HX-02A-07', 3, 3, 46.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(13, 1, 5, 1, 'CATALINA DE LA CADENA DE ALIMENTACION', 'W2.5E-01B-02-04Y', 0, 2, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(14, 1, 6, 1, 'ZETA COMPLETA', 'W2.0-01-01-07-01-02', 2, 1, 130.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(15, 1, 6, 1, 'VAQUELA DE DEDOS', 'W2.0-01-01-02A-11', 28, 10, 8.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(16, 1, 6, 1, 'DEDOS DE CORTE', 'W2.0-01-01-03G-01', 16, 10, 20.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(17, 1, 6, 1, 'CUCHILLA DE CORTE', 'W3.0G-08-04-23R', 56, 20, 4.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(18, 1, 7, 1, 'TERMINAL DE BARRA DE CORTE', '25-40', 2, 2, 45.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(19, 1, 7, 1, 'EJE SUPERIOR DE LA GARGANTA', 'W2.5E-01B-02-05Y', 0, 1, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(20, 1, 7, 1, 'EJE MACHO DE CAJA DE TRILLA', 'W2.5-02S-01-17-09', 1, 2, 125.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(21, 1, 7, 1, 'EJE SUPERIOR DE HST DONDE VA EL RODAJE', 'W2.5DD-05DB-09-00', 2, 1, 180.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(22, 1, 8, 1, 'RESORTE TEMPLADOR', 'W2.5-02-02-10-08A', 4, 6, 27.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(23, 1, 8, 1, 'POLEA DEL GRANO LIMPIO', 'W2.5P-02-02-10-06', 0, 1, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(24, 1, 8, 1, 'POLEA DEL BANERO', 'W2.5P-02-02-11-05', 0, 1, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(25, 1, 8, 1, 'FAJA HB-1195 PARA DESATORAR', 'F-HB1195', 3, 2, 70.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(26, 1, 8, 1, 'FAJA HC-2508 DEL VENTILADOR', 'F-HC2508', 6, 4, 127.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(27, 1, 8, 1, 'FAJA C-1850 DE LA DESCARGA', 'F-HC1850', 3, 2, 105.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(28, 1, 8, 1, 'FAJA HB-3020', 'F-HB3020', 3, 2, 70.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(29, 1, 8, 1, 'FAJA 9J-5-1605LW DE TRANSMISION ', 'W2.5-02S-01A-37', 3, 2, 182.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(30, 1, 8, 1, 'FAJA 3280 LARGA DE SARANDA', 'F-HC3280', 1, 3, 127.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(31, 1, 8, 1, 'FAJA 4SB-1490 DE TRILLA', 'F-4SB:1490', 1, 2, 180.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(32, 1, 8, 1, 'CABLE PARA APAGAR EL MOTOR', 'I-0036', 1, 1, 70.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(33, 1, 9, 1, 'BASE DEL SINFÍN HORIZONTAL DEL GRANO LIMPIO', 'W2.5P-02-02-10-07', 0, 1, 50.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(34, 1, 9, 1, 'BASE DEL SINFÍN HORIZONTAL DEL BANERO', 'W2.5-02-02-11-04', 1, 1, 50.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(35, 1, 9, 1, 'Y DE LA RUEDA DE GUIA', 'WD.4ME.27.2A', 1, 1, 150.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(36, 1, 9, 1, 'BOMBA HIDRAULICA', 'W2.5DD-05DC-09-00A', 1, 1, 370.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(37, 1, 9, 1, 'TEMPLADOR DE TRILLA COMPLETO', 'W2.5DA-03H-17C-00', 1, 1, 280.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(38, 1, 9, 1, 'MEDIA LUNA DEL EJE DE SARANDA', 'W2.0-02-13-01-08', 3, 1, 40.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(39, 1, 9, 1, 'HORQUILLA DE LA CAJA', 'ZKB85-206A400-1', 2, 2, 80.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(40, 1, 9, 1, 'EJE DE CARRIL SOLO', 'WD.4MC.32-06', 15, 5, 30.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(41, 1, 10, 1, 'FILTRO SEPARADOR DE AGUA SFR-3243FW', 'F-SFR3243', 0, 3, 45.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(42, 1, 10, 1, 'FILTRO PEQUEÑO DE PETROLEO', 'F-PETR-PEQ', 2, 3, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(43, 1, 10, 1, 'FILTRO PEQUEÑO DE HST', 'GB/T5785-86', 2, 4, 70.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(44, 1, 10, 1, 'FILTRO GRANDE DE LA BOMBA DE PETROLEO', 'W.45.22C-46.8', 1, 1, 160.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(45, 1, 10, 1, 'FILTRO GRANDE DE HST', 'GB/T97.1-85', 2, 2, 85.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(46, 1, 10, 1, 'FILTRO ELECTRICO CON BASE', 'F-ELE-23', 1, 1, 680.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(47, 1, 10, 1, 'FILTRO DE AIRE COSECHADORA', 'GB/T119.1', 6, 4, 105.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(48, 1, 10, 1, 'FILTRO PER-810 DE ACEITE', 'F-PER-810', 3, 3, 28.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(49, 1, 10, 1, 'FILTRO DE ACEITE DE CAMION', 'F-L20290', 1, 1, 30.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(50, 1, 10, 1, 'FILTRO DE TRANSMISION KUBOTA', 'W9501-45101', 6, 2, 140.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(51, 1, 10, 1, 'FILTRO DE AIRE KUBOTA', 'F-P82888', 2, 2, 180.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(52, 1, 11, 1, 'SOPLETE PARA BALON DE GAS', 'H-0005', 1, 1, 25.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(53, 1, 11, 1, 'SACAFILTRO PARA FILTRO PER-810', 'H-0004', 2, 1, 30.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(54, 1, 11, 1, 'PISTOLA PARA APLICAR SIKAFLEX', 'H-0012', 1, 1, 25.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(55, 1, 11, 1, 'MACHO M6*1.00 SET COMPLETO', 'H-0011', 1, 1, 30.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(56, 1, 11, 1, 'JUEGO DE HEXAGONALES MARCA STANLEY', 'H-0015', 1, 1, 80.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(57, 1, 11, 1, 'IMAN MARCA TOPTUL', 'H-0013', 1, 1, 55.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(58, 1, 11, 1, 'IMAN MARCA STANLEY', 'H-0014', 1, 1, 116.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(59, 1, 11, 1, 'GATA DE 12 TONELADAS TRUPER', 'H-0003', 1, 1, 225.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(60, 1, 11, 1, 'ESTRACTOR DE RODAJES DE 2 Y 3 UÑAS MARCA STANLEY', 'H-0002', 1, 1, 350.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(61, 1, 11, 1, 'ESTRACTOR DE RODAJES DE 2 UÑAS MARCA IUSTOOLS', 'H-0001', 1, 1, 180.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(62, 1, 11, 1, 'DADO 41 DE 3/4', 'H-0006', 2, 1, 55.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(63, 1, 11, 1, 'DADO 33 DE 3/4', 'H-0007', 1, 1, 45.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(64, 1, 11, 1, 'DADO 32 DE 3/4', 'H-0008', 1, 1, 40.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(65, 1, 11, 1, 'DADO 30 DE 3/4', 'H-0009', 2, 1, 40.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(66, 1, 11, 1, 'DADO 28 DE 3/4', 'H-0010', 1, 1, 35.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(67, 1, 11, 1, 'JUEGO DE MACHOS MARCA TRUPER', 'H-0016', 1, 1, 200.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(68, 1, 11, 1, 'VERNIER MARCA KAMASA', 'H-0017', 1, 1, 40.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(69, 1, 11, 1, 'JUEGO DE SACABOCADOS MARCA IUSTOOLS', 'H-0018', 1, 1, 90.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(70, 1, 11, 1, 'PISTOLA DE PINTAR MARCA TRUPER', 'H-0019', 1, 1, 60.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(71, 1, 12, 1, 'SIKAFLEX', 'I-0007', 2, 2, 41.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(72, 1, 12, 1, 'PLATINA DE 1.1/4 * 3/16 POR 2 METROS', 'I-0008', 1, 2, 20.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(73, 1, 12, 1, 'LIQUIDO DE FRENO 946 ML', 'I-0005', 1, 1, 70.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(74, 1, 12, 1, 'DISCOS FLAP PEQUEÑO', 'I-0004', 3, 3, 7.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(75, 1, 12, 1, 'DISCOS DE CORTE PEQUEÑO', 'I-0002', 22, 3, 2.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(76, 1, 12, 1, 'DISCO DE CORTE GRANDE', 'I-0003', 19, 3, 6.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(77, 1, 12, 1, 'BALDE DE GRASA VISTONY 15.85 KG', 'I-0009', 0, 1, 350.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(78, 1, 12, 1, 'AFLOJATODO', 'I-0006', 4, 3, 13.30, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(79, 1, 12, 1, 'DISCO PARA LIJAR PARA AMOLDORA PEQUEÑA', 'I-0010', 3, 3, 45.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(80, 1, 12, 1, 'SOLDADURA SUPERCITO POR KG', 'I-0011', 7, 3, 80.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(81, 1, 12, 1, 'PINTURA BASE EPOXICA', 'I-0012', 0, 1, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(82, 1, 12, 1, 'PINTURA GLOSS ROJO BERMELLON', 'I-0013', 0, 1, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(83, 1, 12, 1, 'PINTURA GLOSS GRIS VOLVO', 'I-0014', 0, 1, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(84, 1, 12, 1, 'THINER ACRILICO', 'I-0015', 0, 3, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(85, 1, 12, 1, 'ESCOBILLA PARA LIJAR DE COPA SIMPLE', 'I-0017', 1, 3, 10.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(86, 1, 12, 1, 'ESCOBILLA PARA LIJAR DE COPA ACERO TRENZADO', 'I-0018', 3, 3, 13.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(87, 1, 12, 1, 'MASILLA AUTOMOTRIZ VELOZ FLEX', 'I-0019', 1, 1, 13.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(88, 1, 12, 1, 'TRAPO INDUSTRIAL POR KG', 'I-0020', 2, 1, 5.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(89, 1, 12, 1, 'SOLDIMIX DE 24 HORAS', 'I-0021', 2, 3, 7.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(90, 1, 12, 1, 'SOLDIMIX DE 10 MIN', 'I-0022', 5, 2, 7.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(91, 1, 12, 1, 'PINTURA MATIZADA GLOSS CREMA COSECHADORA', 'I-0023', 0, 1, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(92, 1, 12, 1, 'SILICONA AUTOMOTRIZ PEQUEÑA', 'I-0024', 5, 2, 7.10, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(93, 1, 12, 1, 'PERNO N° 8 PARA CUCHILLAS', 'I-0025', 64, 20, 0.20, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(94, 1, 12, 1, 'PERNO N° 10', 'I-0026', 0, 20, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(95, 1, 12, 1, 'PERNO N° 13', 'I-0027', 26, 10, 0.80, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(96, 1, 12, 1, 'PERNO N° 15', 'I-0028', 16, 10, 1.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', ''),
(97, 1, 12, 1, 'PERNO N° 17', 'I-0029', 9, 10, 1.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(98, 1, 12, 1, 'PERNO N° 17 BASE DEL RODAJE DETRÁS DEL ROTOR', 'I-0030', 9, 4, 2.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(99, 1, 12, 1, 'ACEITE HIDRAULICO GRADO 68', 'I-0032', 1, 1, 235.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(100, 1, 12, 1, 'SOLDADURA PUNTO AZUL', 'I-0033', 3, 2, 10.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(101, 1, 12, 1, 'DISCO DE DESGASTE PEQUEÑO', 'I-0035', 3, 4, 18.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(102, 1, 13, 1, 'TUBO DEL GRANO LIMPIO', 'W2.5K-02PB-10C-01-00', 0, 1, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(103, 1, 13, 1, 'TUBO DEL DEL BANERO', 'W3.5H-02-11-01-01-00', 0, 1, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(104, 1, 13, 1, 'TERMINAL DE AVANCE LADO IZQUIERDO', 'W2.5DA-07E-04-21R', 0, 2, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(105, 1, 13, 1, 'TERMINAL DE AVANCE LADO DERECHO', 'W2.5DA-07E-04-21L', 0, 2, 25.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(106, 1, 13, 1, 'TAPA DE BASE DE CADENA DE BANERO', 'W2.0-02-11-13', 1, 1, 40.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(107, 1, 13, 1, 'SAPO DE CORTE', 'GB/T96-85', 5, 5, 15.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(108, 1, 13, 1, 'PROTECTOR DE ZETA', 'WK34-30-38-12Ñ-4', 2, 2, 40.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(109, 1, 13, 1, 'PATIN TRASERO', 'WD.4FE.33', 3, 2, 135.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(110, 1, 13, 1, 'PATIN DELANTERO', 'W2.5D-03-32-00', 1, 2, 120.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(111, 1, 13, 1, 'PATA DE DIRECCIONAL DERECHO', 'ZKB40-206A-401-2-00S', 1, 2, 35.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(112, 1, 13, 1, 'PATA DE DIRECCIONAL IZQUIERDO', 'ZKB40-206A-401-1-00S', 3, 2, 35.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(113, 1, 13, 1, 'PALETA DEL VENTILADOR', 'GB6176-86', 0, 2, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(114, 1, 13, 1, 'PALETA DE SINFÍN DE BANERO', 'W2.5-02-02-11-02-02-00', 8, 2, 20.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(115, 1, 13, 1, 'OLLA DEL BANERO', 'W2.5-02-02-11-03-00', 0, 2, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(116, 1, 13, 1, 'CONJUNTO DE ENTRADA IZQUIERDO GARGANTA', 'W2.5-02G-01-05B-00', 0, 1, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(117, 1, 13, 1, 'CONJUNTO DE ENTRADA DERECHO GARGANTA', 'W2.5-02G-01-03B-00', 0, 1, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(118, 1, 13, 1, 'CAJA DE CADENA DEL BANERO', 'W2.0-02-11-14-00', 0, 2, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(119, 1, 13, 1, 'ABRAZADERA DE CARRETA', 'AD-23-19C-09A', 0, 100, 55.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(120, 1, 14, 1, 'CERBO DEL BANERO', 'W2.5-02-02-11-01-09-00', 1, 1, 160.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(121, 1, 15, 1, 'PERNO TEMPLADOR DE ORUGA', 'WD.4FE.27-03', 3, 2, 65.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(122, 1, 15, 1, 'GUACHA DE CATALINA', 'ZKB40-305-008', 2, 2, 25.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(123, 1, 16, 1, 'PINTURA GLOSS BASE', 'I-0037', 0, 100, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/accesorios/img-1734559323.png', 'SI'),
(124, 1, 17, 1, 'SEPARADORES DE DISCOS', 'ZKB75-303-003', 4, 10, 20.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(125, 1, 17, 1, 'PIÑON TRIPLE DE LA CAJA', 'ZKB85-301-003', 1, 100, 113.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(126, 1, 17, 1, 'PIÑON TEMPLADOR DE 14 DIENTES CADENA GRANO LIMPIO', 'L1.8A-03-02-04-00', 2, 2, 45.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(127, 1, 17, 1, 'PIÑON PESTAÑA ALTA DEL CERBO DEL BANERO', 'WD-150-03.05.10.01-04', 2, 2, 25.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(128, 1, 17, 1, 'PIÑON DEL CERBO DEL BANERO DE 13 DIENTES', 'W2.0-02-11-10', 4, 2, 30.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(129, 1, 17, 1, 'PIÑON DEL BANERO CON CHAVETA 14 DIENTES', 'W2.0-02-11-07', 3, 2, 35.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(130, 1, 17, 1, 'PIÑON DE Y DEL CODO DE LA DESCARGA', 'W2.5B-04BX-11-01-03', 1, 2, 49.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(131, 1, 17, 1, 'PIÑON DE LA BOMBA HIDRAULICCA', 'W2.0M-33-05-08-02', 2, 1, 90.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(132, 1, 17, 1, 'PIÑON DE 17 DIENTES GRANO LIMPIO CON CHAVETA', 'L1.8A-03-02-01-04A', 1, 2, 46.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(133, 1, 17, 1, 'PIÑON DE 15 DIENTES DEL GRANO LIMPIO', 'L1.8A-03-02-03-01', 3, 2, 27.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(134, 1, 17, 1, 'EJE DEL PIÑON TRIPLE', 'ZKB85-301-001', 1, 100, 60.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(135, 1, 17, 1, 'DOBLE REDUCTOR PIÑON DE CAJA', 'ZKB80-304-002', 1, 2, 110.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(136, 1, 17, 1, 'DISCOS DE LA CAJA', 'ZKB80-303-004a', 4, 10, 20.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(137, 1, 17, 1, 'ACOPLE DE DIRECCIONAL', 'ZKB80-303-002', 0, 2, 126.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(138, 1, 17, 1, 'PIÑON DE SEGUNDA DE CAJA', 'ZKB85-302-003', 1, 100, 65.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(139, 1, 17, 1, 'EJE DIRECCIONAL CON PIÑON DE CAJA', 'ZKB85-203-100-1', 1, 1, 190.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(140, 1, 17, 1, 'PIÑON DE 17 DIENTES DE HST', 'ZKB80-307-001', 2, 2, 40.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(141, 1, 17, 1, 'PIÑON CONICO CON CHAVETA DEL MOTOR DE GRANO LIMPIO', 'L1.8A-03-04-03-05', 2, 2, 45.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(142, 1, 17, 1, 'ENGRANAJE DEL CERBO DEL DESCARGUE', 'W2.5B-04HX-02A-05-03', 0, 2, 50.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(143, 1, 17, 1, 'PIÑON DE CORONA DE LA CAJA ', 'ZKB80-304-004', 3, 100, 210.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(144, 1, 17, 1, 'PIÑON DE TERCERA DE LA CAJA', 'ZKB60-302-004', 0, 100, 40.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(145, 1, 20, 1, 'SEGUROS', 'C-0001', 7, 4, 8.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(146, 1, 20, 1, 'SEGURO DE TAPA DE CARRIL', 'W1.8-33-06-08', 12, 100, 7.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(147, 1, 20, 1, 'EMPAQUE DE CULATA', 'E-CULATA-102', 0, 100, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(148, 1, 21, 1, 'SENSOR DE ACEITE', 'GB276-94', 2, 1, 80.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(149, 1, 21, 1, 'COMANDO DE TUBO DE DESCARGUE', 'W.61-79B.C90-8.1', 0, 1, 300.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(150, 1, 21, 1, 'COMANDO DE LUCES', 'W.75-C728-89.4', 1, 1, 150.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(151, 1, 21, 1, 'BLOQUEADOR DE CORRIENTE', 'B8.3-45.8-8B', 1, 2, 40.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(152, 1, 22, 1, 'SINFÍN VERTICAL DEL GRANO LIMPIO', 'W2.5A-02B-02-10-02-00', 0, 100, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(153, 1, 22, 1, 'SINFÍN VERTICAL DEL BANNERO', 'W3.5H-02-11-01-07-00', 0, 100, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(154, 1, 22, 1, 'SINFÍN TENDIDO DEL BANERO', 'W3.5H-02-11-02-00', 0, 100, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(155, 1, 18, 1, 'TAPA DE CARRIL', 'W1.8-33-06-01', 48, 100, 12.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(156, 1, 18, 1, 'RETEN DE RUEDA DE GUIA', 'W2.5DA-03H-27-06-00B', 5, 100, 20.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(157, 1, 18, 1, 'RETEN DE MANGA', 'MC65X90X17', 3, 2, 25.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(158, 1, 18, 1, 'RETEN DE CARRIL', 'W1.8-33-06-09', 13, 10, 20.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(159, 1, 18, 1, 'RETEN 40X90X10 CAJA DE RETRILLA', 'R-90.60.10', 3, 100, 30.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(160, 1, 18, 1, 'RETEN 55X75X8', 'R-55.75.8', 6, 100, 23.30, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(161, 1, 18, 1, 'RETEN 50X72X10', 'R-50.72.10', 4, 100, 21.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(162, 1, 18, 1, 'RETEN 46X68X10 DE CAJA DE RETRILLA', 'R-46.68.10', 4, 100, 20.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(163, 1, 18, 1, 'RETEN 38X52X12', 'R-38.52.12', 4, 100, 20.60, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(164, 1, 18, 1, 'RETEN 35X80X10 DE CAJA DE RETRILLA', 'R-35.80.10', 5, 100, 40.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(165, 1, 18, 1, 'RETEN 32X62X8', 'R-32.62.8', 5, 100, 15.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(166, 1, 18, 1, 'RETEN 30-47-7 DEL CERBO DEL BANERO', 'GB/T13871-92', 6, 100, 17.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(167, 1, 18, 1, 'RETEN 28-40-8', 'R-28.40.8', 7, 100, 21.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(168, 1, 18, 1, 'RETEN 25x35x6 DE HST', 'WH.6C.56-C', 4, 100, 18.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(169, 1, 18, 1, 'RETEN 25-47-7 DEL CERBO DEL BANERO', 'R-25.47.7', 5, 100, 16.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(170, 1, 18, 1, 'RETEN 25-40-7 DE LA CAJA DE LA CADENA DEL BANERO', 'R-25.40.7', 5, 100, 15.60, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(171, 1, 17, 1, 'RENTEN 60X85X17', 'R-60.85.17', 4, 1, 34.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(172, 1, 18, 1, 'RETEN 25x47x7 DEL CERBO DEL BANERO', 'R-25.47.7', 4, 100, 16.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(173, 1, 18, 1, 'RETEN 20x42x7', 'R-20.42.7', 4, 100, 12.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(174, 1, 18, 1, 'RETEN 30x45x10', 'R-30.45.10', 5, 100, 12.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(175, 1, 19, 1, 'RUEDA DE GUIA COMPLETA', 'W5.0-03X-27-00', 2, 2, 275.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(176, 1, 19, 1, 'RODAJE R40-15A DE LA LLANTA DE LA CARRETA', 'R-R40-15A', 1, 100, 196.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(177, 1, 19, 1, 'RODAJE NJ305 DE LA CAJA', 'R-NJ305', 0, 100, 86.70, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(178, 1, 19, 1, 'RODAJE HMK2530 DE HST', 'R-HMK2530', 4, 2, 41.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(179, 1, 19, 1, 'RODAJE DE COSECHADORA 6008', 'R-6008', 1, 2, 40.20, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(180, 1, 19, 1, 'RODAJE 6310 DE COSECHADORA MANGA', 'R-6310', 2, 2, 106.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(181, 1, 18, 1, 'RODAJE 6308 POLEA DE LA CAJA DE TRANSMISION SUPERIOR', 'R-6308', 2, 2, 30.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(182, 1, 19, 1, 'RODAJE 6307 ATRÁS DEL CILINDRO DE TRILLA', 'R-6307', 5, 100, 71.60, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(183, 1, 19, 1, 'RODAJE 6306', 'R-6306', 6, 100, 25.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(184, 1, 19, 1, 'RODAJE 6305 SKF', 'R-6305SKF', 0, 100, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(185, 1, 19, 1, 'RODAJE 6305 CHINO', 'R-6305CH', 15, 100, 8.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(186, 1, 19, 1, 'RODAJE 6304', 'R-6304', 2, 100, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(187, 1, 19, 1, 'RODAJE 6303', 'R-6303', 7, 100, 18.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(188, 1, 19, 1, 'RODAJE 6302', 'R-6302', 4, 2, 22.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(189, 1, 19, 1, 'RODAJE 6301 DE SARANDA', 'R-6301', 7, 2, 8.80, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(190, 1, 19, 1, 'RODAJE 6210 DELANTE DEL CILINDO DE TRILLA', 'R-6210', 2, 2, 65.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(191, 1, 19, 1, 'RODAJE 6209', 'R-6209', 1, 2, 38.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(192, 1, 19, 1, 'RODAJE 6207', 'R-6207', 6, 100, 35.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(193, 1, 19, 1, 'RODAJE 6206', 'R-6206', 13, 100, 25.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(194, 1, 19, 1, 'RODAJE 6205', 'R-6205', 3, 4, 29.90, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(195, 1, 19, 1, 'RODAJE 6204', 'R-6204', 2, 3, 21.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(196, 1, 19, 1, 'RODAJE 6203', 'R-6203', 2, 100, 13.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(197, 1, 16, 1, 'RODAJE 6012', 'R-6012', 2, 100, 82.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(198, 1, 19, 1, 'RODAJE 6007 DEL HST', 'R-6007', 4, 100, 27.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(199, 1, 19, 1, 'RODAJE 6006', 'R-6006', 4, 100, 45.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(200, 1, 19, 1, 'RODAJE 6005', 'R-6005', 13, 100, 16.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(201, 1, 19, 1, 'RODAJE 6003', 'R-6003', 5, 2, 12.50, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(202, 1, 19, 1, 'RODAJE 6002', 'R-6002', 1, 2, 12.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(203, 1, 19, 1, 'RODAJE 1205 DEL BRAZO DE LA ZETA', 'R-1205C3', 0, 100, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(204, 1, 19, 1, 'RODAJE  R55-5AS-A DE LLANTA DE LA CARRETA', 'R-R55-5AS-A', 1, 2, 240.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(205, 1, 19, 1, 'CHUMACERA UC207 DEL VENTILADOR', 'R-UC207', 0, 100, 95.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(206, 1, 19, 1, 'CHUMACERA UC206 ATRÁS DEL CABEZAL', 'R-UC206', 3, 2, 80.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(207, 1, 19, 1, 'CHUMACERA UC205 DENTRO DEL SINFÍN GRANDE DE CABEZAL', 'CH-UC205', 0, 100, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(208, 1, 19, 1, 'CATALINA DE LA CAJA DE TRANSMISION', 'WD.4MC.2-01C', 0, 2, 0.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(209, 1, 19, 1, 'RODAJE NJ307 DE LA CAJA', 'R-NJ307', 2, 2, 130.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(210, 1, 19, 1, 'RODAJE 6004', 'R-6004', 3, 2, 18.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(211, 1, 19, 1, 'RODAJE DE LA HORQUILLA DE LA CAJA', 'GB/6445.0-1996', 3, 2, 25.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(212, 1, 19, 1, 'ORUGA 550x90x56', 'I-0038', 2, 1, 3800.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(213, 1, 23, 1, 'Máquina 1', '', 1, 1, 135000.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', ''),
(214, 1, 19, 1, 'RODAJE 6202', '', 1, 2, 15.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(215, 1, 11, 1, 'GATA HIDRÁULICA DE 20 TN', 'H-0020', 1, 1, 310.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(216, 1, 11, 1, 'GATA HIDRÁULICA DE 3 TN', 'H-0021', 1, 1, 70.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(217, 1, 11, 1, 'Dado 42 de 3/4', 'H-0022', 1, 1, 60.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(218, 1, 11, 1, 'SET DE MACHO M16x1.5 set', 'H-0023', 1, 1, 45.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(219, 1, 17, 1, 'PIÑON DE PRIMERA DE CAJA', 'ZKB85-302-002', 1, 1, 42.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(220, 1, 9, 1, ' BASE DEL RODAJE 6012 DEL EJE DE SARANDA', 'W2.0-02-13-01-03', 2, 1, 50.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(221, 1, 12, 1, 'CITODUR 600 POR KG', 'I-0001', 10, 5, 60.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(222, 1, 12, 1, 'DISCO FLAP GRANDE', 'I-0036', 1, 2, 12.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(223, 1, 11, 1, 'JUEGO DE BROCAS CAJA ROJA', 'H-0024', 1, 1, 160.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(224, 1, 11, 1, 'PALANCA DE 3/4 MARCA TRUPER', 'H-0025', 2, 1, 120.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(225, 1, 11, 1, 'JUEGO DE HEXAGONALES ESTRELLA TOTAL', 'H-0026', 1, 1, 55.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(226, 1, 11, 1, 'JUEGO DE HEXAGONALES MARCA TOTAL', 'H-0027', 1, 1, 70.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(227, 1, 11, 1, 'JUEGO DE DESARMADORES KAMASA', 'H-0028', 1, 1, 38.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(228, 1, 11, 1, 'SACASEGUROS QUE CIERRA', 'H-0020', 3, 1, 18.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(229, 1, 11, 1, 'SACASEGUROS QUE ABRE', 'H-0030', 2, 2, 22.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(230, 1, 17, 1, 'PIÑON DE PESTAÑA BAJA DEL CERBO DEL BAÑERO', 'WD-150-03.05.10.01-03', 1, 2, 20.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(231, 1, 9, 1, 'BASE DEL RODAJE PEQUEÑO DEL EJE DE SARANDA', 'W2.5-02B-02-13-02-03', 2, 1, 30.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(232, 1, 9, 1, 'BASE SUPERIOR DEL SINFÍN DE BAÑERO', 'WD-150A-03A.05.10-03', 1, 1, 40.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(233, 1, 11, 1, 'JUEGO DE BROCAS SIERRA MARCA TRUPER', 'H-0031', 1, 1, 60.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(234, 1, 11, 1, 'BOQUILLA PARA INYECTAR GRASA MARCA TRUPER', 'H-0032', 1, 1, 15.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(235, 1, 7, 1, 'EJE DE HST QUE VA A LA POLEA', 'GB/T894.1', 0, 1, 280.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(236, 1, 3, 1, 'BOCINA DE CAJA DE RETRILLA', 'W2.5K-02S-02-01-00A', 0, 1, 150.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(237, 1, 12, 1, 'SOLDADURA PUNTO AZUL POR KG', 'I-0037', 4, 5, 20.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(238, 1, 11, 1, 'SET DE MACHOS MARCA TRUPER', 'H-0033', 1, 1, 200.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(239, 1, 11, 1, 'JUEGO DE LLAVES MIXTAS DE 20 PIEZAS MARCA STANLEY', 'H-0034', 3, 7, 150.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(240, 1, 11, 1, 'JUEGO DE DADOS DE 25 PIEZAS MARCA TOTAL', 'H-0035', 3, 7, 290.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(241, 1, 11, 1, 'JUEGO DE DADOS DE 19 PIEZAS MARCA STALEY', 'H-0036', 2, 1, 220.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(242, 1, 11, 1, 'JUEGO DE DADOS DE 15 PIEZAS MARCA STANLEY', 'H-0037', 1, 1, 320.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(243, 1, 11, 1, 'SET COMPLETO DE TALADRO INALÁMBRICO MARCA DEWALT', 'H-0038', 1, 1, 450.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI'),
(244, 1, 11, 1, 'SET COMPLETO DE PISTOLA DE IMPACTO MARCA INGCO', 'H-0039', 1, 1, 400.00, 1, 'S/', 1.00, '1', 'activo', 'resources/global/images/sin_imagen.png', 'SI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_acceso_opcion`
--

CREATE TABLE `tb_acceso_opcion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_grupo` bigint(20) UNSIGNED NOT NULL,
  `id_opcion` int(11) NOT NULL,
  `flag_agregar` tinyint(1) NOT NULL DEFAULT 0,
  `flag_buscar` tinyint(1) NOT NULL DEFAULT 0,
  `flag_editar` tinyint(1) NOT NULL DEFAULT 0,
  `flag_eliminar` tinyint(1) NOT NULL DEFAULT 0,
  `flag_anular` tinyint(1) NOT NULL DEFAULT 0,
  `flag_ver` tinyint(1) NOT NULL DEFAULT 0,
  `flag_descargar` tinyint(1) NOT NULL DEFAULT 0
) ;

--
-- Volcado de datos para la tabla `tb_acceso_opcion`
--

INSERT INTO `tb_acceso_opcion` (`id`, `id_grupo`, `id_opcion`, `flag_agregar`, `flag_buscar`, `flag_editar`, `flag_eliminar`, `flag_anular`, `flag_ver`, `flag_descargar`) VALUES
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
(184, 1, 707, 1, 1, 1, 1, 1, 1, 1),
(185, 1, 708, 1, 1, 1, 1, 1, 1, 1),
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
(198, 2, 105, 0, 0, 0, 0, 0, 0, 0),
(199, 2, 106, 0, 0, 0, 0, 0, 0, 0),
(200, 2, 107, 0, 0, 0, 0, 0, 0, 0),
(201, 2, 108, 0, 0, 0, 0, 0, 0, 0),
(202, 2, 109, 0, 0, 0, 0, 0, 0, 0),
(203, 2, 110, 0, 0, 0, 0, 0, 0, 0),
(204, 2, 111, 0, 0, 0, 0, 0, 0, 0),
(205, 2, 112, 0, 0, 0, 0, 0, 0, 0),
(206, 2, 113, 0, 0, 0, 0, 0, 0, 0),
(207, 2, 114, 0, 0, 0, 0, 0, 0, 0),
(208, 2, 115, 0, 0, 0, 0, 0, 0, 0),
(209, 2, 200, 0, 0, 0, 0, 0, 0, 0),
(210, 2, 201, 0, 0, 0, 0, 0, 0, 0),
(211, 2, 202, 0, 0, 0, 0, 0, 0, 0),
(212, 2, 203, 0, 1, 0, 0, 0, 1, 1),
(213, 2, 204, 0, 0, 0, 0, 0, 0, 0),
(214, 2, 205, 0, 0, 0, 0, 0, 0, 0),
(215, 2, 206, 0, 0, 0, 0, 0, 0, 0),
(216, 2, 207, 0, 0, 0, 0, 0, 0, 0),
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
(258, 2, 501, 1, 1, 0, 0, 0, 1, 0),
(259, 2, 502, 0, 0, 0, 0, 0, 0, 0),
(260, 2, 503, 0, 0, 0, 0, 0, 0, 0),
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
(274, 2, 601, 0, 0, 0, 0, 0, 0, 0),
(275, 2, 602, 0, 0, 0, 0, 0, 0, 0),
(276, 2, 603, 0, 0, 0, 0, 0, 0, 0),
(277, 2, 604, 0, 0, 0, 0, 0, 0, 0),
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
(292, 2, 703, 0, 0, 0, 0, 0, 1, 0),
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
(432, 4, 100, 0, 0, 0, 0, 0, 0, 0),
(433, 4, 101, 1, 1, 1, 1, 1, 1, 1),
(434, 4, 102, 1, 1, 1, 1, 1, 1, 1),
(435, 4, 103, 1, 1, 1, 1, 1, 1, 1),
(436, 4, 104, 1, 1, 1, 1, 1, 1, 1),
(437, 4, 105, 1, 1, 1, 1, 1, 1, 1),
(438, 4, 106, 1, 1, 1, 1, 1, 1, 1),
(439, 4, 107, 1, 1, 1, 1, 1, 1, 1),
(440, 4, 108, 1, 1, 1, 1, 1, 1, 1),
(441, 4, 109, 1, 1, 1, 1, 1, 1, 1),
(442, 4, 110, 1, 1, 1, 1, 1, 1, 1),
(443, 4, 111, 1, 1, 1, 1, 1, 1, 1),
(444, 4, 112, 1, 1, 1, 1, 1, 1, 1),
(445, 4, 113, 1, 1, 1, 1, 1, 1, 1),
(446, 4, 114, 1, 1, 1, 1, 1, 1, 1),
(447, 4, 115, 1, 1, 1, 1, 1, 1, 1),
(448, 4, 200, 0, 0, 0, 0, 0, 0, 0),
(449, 4, 201, 1, 1, 1, 1, 1, 1, 1),
(450, 4, 202, 1, 1, 1, 1, 1, 1, 1),
(451, 4, 203, 1, 1, 1, 1, 1, 1, 1),
(452, 4, 204, 1, 1, 1, 1, 1, 1, 1),
(453, 4, 205, 1, 1, 1, 1, 1, 1, 1),
(454, 4, 206, 1, 1, 1, 1, 1, 1, 1),
(455, 4, 207, 1, 1, 1, 1, 1, 1, 1),
(456, 4, 208, 1, 1, 1, 1, 1, 1, 1),
(457, 4, 209, 1, 1, 1, 1, 1, 1, 1),
(458, 4, 210, 1, 1, 1, 1, 1, 1, 1),
(459, 4, 211, 1, 1, 1, 1, 1, 1, 1),
(460, 4, 212, 1, 1, 1, 1, 1, 1, 1),
(461, 4, 213, 0, 0, 0, 0, 0, 0, 0),
(462, 4, 214, 0, 0, 0, 0, 0, 0, 0),
(463, 4, 215, 0, 0, 0, 0, 0, 0, 0),
(464, 4, 300, 0, 0, 0, 0, 0, 0, 0),
(465, 4, 301, 1, 1, 1, 1, 1, 1, 1),
(466, 4, 302, 1, 1, 1, 1, 1, 1, 1),
(467, 4, 303, 1, 1, 1, 1, 1, 1, 1),
(468, 4, 304, 1, 1, 1, 1, 1, 1, 1),
(469, 4, 305, 0, 0, 0, 0, 0, 0, 0),
(470, 4, 306, 0, 0, 0, 0, 0, 0, 0),
(471, 4, 307, 0, 0, 0, 0, 0, 0, 0),
(472, 4, 308, 0, 0, 0, 0, 0, 0, 0),
(473, 4, 309, 0, 0, 0, 0, 0, 0, 0),
(474, 4, 310, 0, 0, 0, 0, 0, 0, 0),
(475, 4, 311, 0, 0, 0, 0, 0, 0, 0),
(476, 4, 312, 0, 0, 0, 0, 0, 0, 0),
(477, 4, 313, 0, 0, 0, 0, 0, 0, 0),
(478, 4, 314, 0, 0, 0, 0, 0, 0, 0),
(479, 4, 315, 0, 0, 0, 0, 0, 0, 0),
(480, 4, 400, 0, 0, 0, 0, 0, 0, 0),
(481, 4, 401, 0, 0, 0, 0, 0, 0, 0),
(482, 4, 402, 0, 0, 0, 0, 0, 0, 0),
(483, 4, 403, 0, 0, 0, 0, 0, 0, 0),
(484, 4, 404, 0, 0, 0, 0, 0, 0, 0),
(485, 4, 405, 0, 0, 0, 0, 0, 0, 0),
(486, 4, 406, 0, 0, 0, 0, 0, 0, 0),
(487, 4, 407, 0, 0, 0, 0, 0, 0, 0),
(488, 4, 408, 0, 0, 0, 0, 0, 0, 0),
(489, 4, 409, 0, 0, 0, 0, 0, 0, 0),
(490, 4, 410, 0, 0, 0, 0, 0, 0, 0),
(491, 4, 411, 0, 0, 0, 0, 0, 0, 0),
(492, 4, 412, 0, 0, 0, 0, 0, 0, 0),
(493, 4, 413, 0, 0, 0, 0, 0, 0, 0),
(494, 4, 414, 0, 0, 0, 0, 0, 0, 0),
(495, 4, 415, 0, 0, 0, 0, 0, 0, 0),
(496, 4, 500, 0, 0, 0, 0, 0, 0, 0),
(497, 4, 501, 0, 0, 0, 0, 0, 0, 0),
(498, 4, 502, 0, 0, 0, 0, 0, 0, 0),
(499, 4, 503, 0, 0, 0, 0, 0, 0, 0),
(500, 4, 504, 0, 0, 0, 0, 0, 0, 0),
(501, 4, 505, 0, 0, 0, 0, 0, 0, 0),
(502, 4, 506, 0, 0, 0, 0, 0, 0, 0),
(503, 4, 507, 0, 0, 0, 0, 0, 0, 0),
(504, 4, 508, 0, 0, 0, 0, 0, 0, 0),
(505, 4, 509, 0, 0, 0, 0, 0, 0, 0),
(506, 4, 510, 0, 0, 0, 0, 0, 0, 0),
(507, 4, 511, 0, 0, 0, 0, 0, 0, 0),
(508, 4, 512, 0, 0, 0, 0, 0, 0, 0),
(509, 4, 513, 0, 0, 0, 0, 0, 0, 0),
(510, 4, 514, 0, 0, 0, 0, 0, 0, 0),
(511, 4, 515, 0, 0, 0, 0, 0, 0, 0),
(512, 4, 600, 0, 0, 0, 0, 0, 0, 0),
(513, 4, 601, 0, 0, 0, 0, 0, 0, 0),
(514, 4, 602, 0, 0, 0, 0, 0, 0, 0),
(515, 4, 603, 0, 0, 0, 0, 0, 0, 0),
(516, 4, 604, 0, 0, 0, 0, 0, 0, 0),
(517, 4, 605, 0, 0, 0, 0, 0, 0, 0),
(518, 4, 606, 0, 0, 0, 0, 0, 0, 0),
(519, 4, 607, 0, 0, 0, 0, 0, 0, 0),
(520, 4, 608, 0, 0, 0, 0, 0, 0, 0),
(521, 4, 609, 0, 0, 0, 0, 0, 0, 0),
(522, 4, 610, 0, 0, 0, 0, 0, 0, 0),
(523, 4, 611, 0, 0, 0, 0, 0, 0, 0),
(524, 4, 612, 0, 0, 0, 0, 0, 0, 0),
(525, 4, 613, 0, 0, 0, 0, 0, 0, 0),
(526, 4, 614, 0, 0, 0, 0, 0, 0, 0),
(527, 4, 615, 0, 0, 0, 0, 0, 0, 0),
(528, 4, 700, 0, 0, 0, 0, 0, 0, 0),
(529, 4, 701, 0, 0, 0, 0, 0, 0, 0),
(530, 4, 702, 0, 0, 0, 0, 0, 0, 0),
(531, 4, 703, 0, 0, 0, 0, 0, 0, 0),
(532, 4, 704, 0, 0, 0, 0, 0, 0, 0),
(533, 4, 705, 0, 0, 0, 0, 0, 0, 0),
(534, 4, 706, 0, 0, 0, 0, 0, 0, 0),
(535, 4, 707, 0, 0, 0, 0, 0, 0, 0),
(536, 4, 708, 0, 0, 0, 0, 0, 0, 0),
(537, 4, 709, 0, 0, 0, 0, 0, 0, 0),
(538, 4, 710, 0, 0, 0, 0, 0, 0, 0),
(539, 4, 711, 0, 0, 0, 0, 0, 0, 0),
(540, 4, 712, 0, 0, 0, 0, 0, 0, 0),
(541, 4, 713, 0, 0, 0, 0, 0, 0, 0),
(542, 4, 714, 0, 0, 0, 0, 0, 0, 0),
(543, 4, 715, 0, 0, 0, 0, 0, 0, 0),
(559, 5, 100, 0, 0, 0, 0, 0, 0, 0),
(560, 5, 101, 0, 0, 0, 0, 0, 0, 0),
(561, 5, 102, 0, 0, 0, 0, 0, 0, 0),
(562, 5, 103, 0, 0, 0, 0, 0, 0, 0),
(563, 5, 104, 0, 0, 0, 0, 0, 0, 0),
(564, 5, 105, 0, 0, 0, 0, 0, 0, 0),
(565, 5, 106, 0, 0, 0, 0, 0, 0, 0),
(566, 5, 107, 0, 0, 0, 0, 0, 0, 0),
(567, 5, 108, 0, 0, 0, 0, 0, 0, 0),
(568, 5, 109, 0, 0, 0, 0, 0, 0, 0),
(569, 5, 110, 0, 0, 0, 0, 0, 0, 0),
(570, 5, 111, 0, 0, 0, 0, 0, 0, 0),
(571, 5, 112, 0, 0, 0, 0, 0, 0, 0),
(572, 5, 113, 0, 0, 0, 0, 0, 0, 0),
(573, 5, 114, 0, 0, 0, 0, 0, 0, 0),
(574, 5, 115, 0, 0, 0, 0, 0, 0, 0),
(575, 5, 200, 0, 0, 0, 0, 0, 0, 0),
(576, 5, 201, 0, 1, 0, 0, 0, 1, 0),
(577, 5, 202, 0, 0, 0, 0, 0, 0, 0),
(578, 5, 203, 0, 1, 0, 0, 0, 1, 0),
(579, 5, 204, 0, 1, 0, 0, 0, 1, 0),
(580, 5, 205, 0, 0, 0, 0, 0, 0, 0),
(581, 5, 206, 0, 0, 0, 0, 0, 0, 0),
(582, 5, 207, 0, 0, 0, 0, 0, 0, 0),
(583, 5, 208, 0, 0, 0, 0, 0, 0, 0),
(584, 5, 209, 0, 1, 0, 0, 0, 1, 0),
(585, 5, 210, 0, 0, 0, 0, 0, 0, 0),
(586, 5, 211, 0, 1, 0, 0, 0, 1, 0),
(587, 5, 212, 0, 1, 0, 0, 0, 1, 0),
(588, 5, 213, 0, 0, 0, 0, 0, 0, 0),
(589, 5, 214, 0, 0, 0, 0, 0, 0, 0),
(590, 5, 215, 0, 0, 0, 0, 0, 0, 0),
(591, 5, 300, 0, 0, 0, 0, 0, 0, 0),
(592, 5, 301, 0, 0, 0, 0, 0, 0, 0),
(593, 5, 302, 0, 0, 0, 0, 0, 0, 0),
(594, 5, 303, 0, 0, 0, 0, 0, 0, 0),
(595, 5, 304, 0, 0, 0, 0, 0, 0, 0),
(596, 5, 305, 0, 0, 0, 0, 0, 0, 0),
(597, 5, 306, 0, 0, 0, 0, 0, 0, 0),
(598, 5, 307, 0, 0, 0, 0, 0, 0, 0),
(599, 5, 308, 0, 0, 0, 0, 0, 0, 0),
(600, 5, 309, 0, 0, 0, 0, 0, 0, 0),
(601, 5, 310, 0, 0, 0, 0, 0, 0, 0),
(602, 5, 311, 0, 0, 0, 0, 0, 0, 0),
(603, 5, 312, 0, 0, 0, 0, 0, 0, 0),
(604, 5, 313, 0, 0, 0, 0, 0, 0, 0),
(605, 5, 314, 0, 0, 0, 0, 0, 0, 0),
(606, 5, 315, 0, 0, 0, 0, 0, 0, 0),
(607, 5, 400, 0, 0, 0, 0, 0, 0, 0),
(608, 5, 401, 0, 0, 0, 0, 0, 0, 0),
(609, 5, 402, 0, 0, 0, 0, 0, 0, 0),
(610, 5, 403, 0, 0, 0, 0, 0, 0, 0),
(611, 5, 404, 0, 0, 0, 0, 0, 0, 0),
(612, 5, 405, 0, 0, 0, 0, 0, 0, 0),
(613, 5, 406, 0, 0, 0, 0, 0, 0, 0),
(614, 5, 407, 0, 0, 0, 0, 0, 0, 0),
(615, 5, 408, 0, 0, 0, 0, 0, 0, 0),
(616, 5, 409, 0, 0, 0, 0, 0, 0, 0),
(617, 5, 410, 0, 0, 0, 0, 0, 0, 0),
(618, 5, 411, 0, 0, 0, 0, 0, 0, 0),
(619, 5, 412, 0, 0, 0, 0, 0, 0, 0),
(620, 5, 413, 0, 0, 0, 0, 0, 0, 0),
(621, 5, 414, 0, 0, 0, 0, 0, 0, 0),
(622, 5, 415, 0, 0, 0, 0, 0, 0, 0),
(623, 5, 500, 0, 0, 0, 0, 0, 0, 0),
(624, 5, 501, 1, 1, 1, 1, 1, 1, 1),
(625, 5, 502, 1, 1, 1, 1, 1, 1, 1),
(626, 5, 503, 1, 1, 1, 1, 1, 1, 1),
(627, 5, 504, 0, 0, 0, 0, 0, 0, 0),
(628, 5, 505, 0, 0, 0, 0, 0, 0, 0),
(629, 5, 506, 0, 0, 0, 0, 0, 0, 0),
(630, 5, 507, 0, 0, 0, 0, 0, 0, 0),
(631, 5, 508, 0, 0, 0, 0, 0, 0, 0),
(632, 5, 509, 0, 0, 0, 0, 0, 0, 0),
(633, 5, 510, 0, 0, 0, 0, 0, 0, 0),
(634, 5, 511, 0, 0, 0, 0, 0, 0, 0),
(635, 5, 512, 0, 0, 0, 0, 0, 0, 0),
(636, 5, 513, 0, 0, 0, 0, 0, 0, 0),
(637, 5, 514, 0, 0, 0, 0, 0, 0, 0),
(638, 5, 515, 0, 0, 0, 0, 0, 0, 0),
(639, 5, 600, 0, 0, 0, 0, 0, 0, 0),
(640, 5, 601, 0, 0, 0, 0, 0, 0, 0),
(641, 5, 602, 0, 0, 0, 0, 0, 0, 0),
(642, 5, 603, 0, 0, 0, 0, 0, 0, 0),
(643, 5, 604, 0, 0, 0, 0, 0, 0, 0),
(644, 5, 605, 0, 0, 0, 0, 0, 0, 0),
(645, 5, 606, 0, 0, 0, 0, 0, 0, 0),
(646, 5, 607, 0, 0, 0, 0, 0, 0, 0),
(647, 5, 608, 0, 0, 0, 0, 0, 0, 0),
(648, 5, 609, 0, 0, 0, 0, 0, 0, 0),
(649, 5, 610, 0, 0, 0, 0, 0, 0, 0),
(650, 5, 611, 0, 0, 0, 0, 0, 0, 0),
(651, 5, 612, 0, 0, 0, 0, 0, 0, 0),
(652, 5, 613, 0, 0, 0, 0, 0, 0, 0),
(653, 5, 614, 0, 0, 0, 0, 0, 0, 0),
(654, 5, 615, 0, 0, 0, 0, 0, 0, 0),
(655, 5, 700, 0, 0, 0, 0, 0, 0, 0),
(656, 5, 701, 0, 0, 0, 0, 0, 0, 0),
(657, 5, 702, 0, 0, 0, 0, 0, 0, 0),
(658, 5, 703, 1, 0, 0, 0, 0, 0, 0),
(659, 5, 704, 1, 0, 0, 0, 0, 0, 0),
(660, 5, 705, 0, 0, 0, 0, 0, 0, 0),
(661, 5, 706, 0, 0, 0, 0, 0, 0, 0),
(662, 5, 707, 0, 0, 0, 0, 0, 0, 0),
(663, 5, 708, 0, 0, 0, 0, 0, 0, 0),
(664, 5, 709, 0, 0, 0, 0, 0, 0, 0),
(665, 5, 710, 0, 0, 0, 0, 0, 0, 0),
(666, 5, 711, 0, 0, 0, 0, 0, 0, 0),
(667, 5, 712, 0, 0, 0, 0, 0, 0, 0),
(668, 5, 713, 0, 0, 0, 0, 0, 0, 0),
(669, 5, 714, 0, 0, 0, 0, 0, 0, 0),
(670, 5, 715, 0, 0, 0, 0, 0, 0, 0),
(686, 6, 100, 0, 0, 0, 0, 0, 0, 0),
(687, 6, 101, 0, 0, 0, 0, 0, 0, 0),
(688, 6, 102, 0, 0, 0, 0, 0, 0, 0),
(689, 6, 103, 0, 0, 0, 0, 0, 0, 0),
(690, 6, 104, 0, 0, 0, 0, 0, 0, 0),
(691, 6, 105, 0, 0, 0, 0, 0, 0, 0),
(692, 6, 106, 0, 0, 0, 0, 0, 0, 0),
(693, 6, 107, 0, 0, 0, 0, 0, 0, 0),
(694, 6, 108, 0, 0, 0, 0, 0, 0, 0),
(695, 6, 109, 0, 0, 0, 0, 0, 0, 0),
(696, 6, 110, 0, 0, 0, 0, 0, 0, 0),
(697, 6, 111, 0, 0, 0, 0, 0, 0, 0),
(698, 6, 112, 0, 0, 0, 0, 0, 0, 0),
(699, 6, 113, 0, 0, 0, 0, 0, 0, 0),
(700, 6, 114, 0, 0, 0, 0, 0, 0, 0),
(701, 6, 115, 0, 0, 0, 0, 0, 0, 0),
(702, 6, 200, 0, 0, 0, 0, 0, 0, 0),
(703, 6, 201, 0, 0, 0, 0, 0, 0, 0),
(704, 6, 202, 0, 0, 0, 0, 0, 0, 0),
(705, 6, 203, 0, 1, 0, 0, 0, 1, 1),
(706, 6, 204, 0, 0, 0, 0, 0, 0, 0),
(707, 6, 205, 0, 0, 0, 0, 0, 0, 0),
(708, 6, 206, 0, 0, 0, 0, 0, 0, 0),
(709, 6, 207, 0, 0, 0, 0, 0, 0, 0),
(710, 6, 208, 0, 0, 0, 0, 0, 0, 0),
(711, 6, 209, 0, 0, 0, 0, 0, 0, 0),
(712, 6, 210, 0, 0, 0, 0, 0, 0, 0),
(713, 6, 211, 0, 1, 0, 0, 0, 1, 1),
(714, 6, 212, 0, 0, 0, 0, 0, 0, 0),
(715, 6, 213, 0, 0, 0, 0, 0, 0, 0),
(716, 6, 214, 0, 0, 0, 0, 0, 0, 0),
(717, 6, 215, 0, 0, 0, 0, 0, 0, 0),
(718, 6, 300, 0, 0, 0, 0, 0, 0, 0),
(719, 6, 301, 0, 0, 0, 0, 0, 0, 0),
(720, 6, 302, 0, 0, 0, 0, 0, 0, 0),
(721, 6, 303, 0, 0, 0, 0, 0, 0, 0),
(722, 6, 304, 0, 0, 0, 0, 0, 0, 0),
(723, 6, 305, 0, 0, 0, 0, 0, 0, 0),
(724, 6, 306, 0, 0, 0, 0, 0, 0, 0),
(725, 6, 307, 0, 0, 0, 0, 0, 0, 0),
(726, 6, 308, 0, 0, 0, 0, 0, 0, 0),
(727, 6, 309, 0, 0, 0, 0, 0, 0, 0),
(728, 6, 310, 0, 0, 0, 0, 0, 0, 0),
(729, 6, 311, 0, 0, 0, 0, 0, 0, 0),
(730, 6, 312, 0, 0, 0, 0, 0, 0, 0),
(731, 6, 313, 0, 0, 0, 0, 0, 0, 0),
(732, 6, 314, 0, 0, 0, 0, 0, 0, 0),
(733, 6, 315, 0, 0, 0, 0, 0, 0, 0),
(734, 6, 400, 0, 0, 0, 0, 0, 0, 0),
(735, 6, 401, 0, 0, 0, 0, 0, 0, 0),
(736, 6, 402, 0, 0, 0, 0, 0, 0, 0),
(737, 6, 403, 0, 0, 0, 0, 0, 0, 0),
(738, 6, 404, 0, 0, 0, 0, 0, 0, 0),
(739, 6, 405, 0, 0, 0, 0, 0, 0, 0),
(740, 6, 406, 0, 0, 0, 0, 0, 0, 0),
(741, 6, 407, 0, 0, 0, 0, 0, 0, 0),
(742, 6, 408, 0, 0, 0, 0, 0, 0, 0),
(743, 6, 409, 0, 0, 0, 0, 0, 0, 0),
(744, 6, 410, 0, 0, 0, 0, 0, 0, 0),
(745, 6, 411, 0, 0, 0, 0, 0, 0, 0),
(746, 6, 412, 0, 0, 0, 0, 0, 0, 0),
(747, 6, 413, 0, 0, 0, 0, 0, 0, 0),
(748, 6, 414, 0, 0, 0, 0, 0, 0, 0),
(749, 6, 415, 0, 0, 0, 0, 0, 0, 0),
(750, 6, 500, 0, 0, 0, 0, 0, 0, 0),
(751, 6, 501, 0, 0, 0, 0, 0, 0, 0),
(752, 6, 502, 0, 0, 0, 0, 0, 0, 0),
(753, 6, 503, 0, 0, 0, 0, 0, 0, 0),
(754, 6, 504, 0, 0, 0, 0, 0, 0, 0),
(755, 6, 505, 0, 0, 0, 0, 0, 0, 0),
(756, 6, 506, 0, 0, 0, 0, 0, 0, 0),
(757, 6, 507, 0, 0, 0, 0, 0, 0, 0),
(758, 6, 508, 0, 0, 0, 0, 0, 0, 0),
(759, 6, 509, 0, 0, 0, 0, 0, 0, 0),
(760, 6, 510, 0, 0, 0, 0, 0, 0, 0),
(761, 6, 511, 0, 0, 0, 0, 0, 0, 0),
(762, 6, 512, 0, 0, 0, 0, 0, 0, 0),
(763, 6, 513, 0, 0, 0, 0, 0, 0, 0),
(764, 6, 514, 0, 0, 0, 0, 0, 0, 0),
(765, 6, 515, 0, 0, 0, 0, 0, 0, 0),
(766, 6, 600, 0, 0, 0, 0, 0, 0, 0),
(767, 6, 601, 1, 1, 1, 1, 1, 1, 1),
(768, 6, 602, 1, 1, 1, 1, 1, 1, 1),
(769, 6, 603, 1, 1, 1, 1, 1, 1, 1),
(770, 6, 604, 1, 1, 1, 1, 1, 1, 1),
(771, 6, 605, 1, 1, 1, 1, 1, 1, 1),
(772, 6, 606, 0, 0, 0, 0, 0, 0, 0),
(773, 6, 607, 0, 0, 0, 0, 0, 0, 0),
(774, 6, 608, 0, 0, 0, 0, 0, 0, 0),
(775, 6, 609, 0, 0, 0, 0, 0, 0, 0),
(776, 6, 610, 0, 0, 0, 0, 0, 0, 0),
(777, 6, 611, 0, 0, 0, 0, 0, 0, 0),
(778, 6, 612, 0, 0, 0, 0, 0, 0, 0),
(779, 6, 613, 0, 0, 0, 0, 0, 0, 0),
(780, 6, 614, 0, 0, 0, 0, 0, 0, 0),
(781, 6, 615, 0, 0, 0, 0, 0, 0, 0),
(782, 6, 700, 0, 0, 0, 0, 0, 0, 0),
(783, 6, 701, 0, 0, 0, 0, 0, 0, 0),
(784, 6, 702, 0, 0, 0, 0, 0, 0, 0),
(785, 6, 703, 0, 1, 0, 0, 0, 1, 1),
(786, 6, 704, 0, 1, 0, 0, 0, 1, 1),
(787, 6, 705, 0, 0, 0, 0, 0, 0, 0),
(788, 6, 706, 0, 0, 0, 0, 0, 0, 0),
(789, 6, 707, 0, 0, 0, 0, 0, 0, 0),
(790, 6, 708, 0, 0, 0, 0, 0, 0, 0),
(791, 6, 709, 0, 0, 0, 0, 0, 0, 0),
(792, 6, 710, 0, 0, 0, 0, 0, 0, 0),
(793, 6, 711, 0, 0, 0, 0, 0, 0, 0),
(794, 6, 712, 0, 0, 0, 0, 0, 0, 0),
(795, 6, 713, 0, 0, 0, 0, 0, 0, 0),
(796, 6, 714, 0, 0, 0, 0, 0, 0, 0),
(797, 6, 715, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_categoria_accesorio`
--

CREATE TABLE `tb_categoria_accesorio` (
  `id_categoria` bigint(20) UNSIGNED NOT NULL,
  `name_categoria` varchar(50) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_categoria_accesorio`
--

INSERT INTO `tb_categoria_accesorio` (`id_categoria`, `name_categoria`, `estado`) VALUES
(3, 'BOCINAS', 'activo'),
(4, 'CADENA', 'activo'),
(5, 'CATALINAS', 'activo'),
(6, 'CORTE', 'activo'),
(7, 'EJE', 'activo'),
(8, 'FAJA', 'activo'),
(9, 'FIERRO', 'activo'),
(10, 'FILTRO', 'activo'),
(11, 'HERRAMIENTAS', 'activo'),
(12, 'INSUMOS DE TALLER', 'activo'),
(13, 'LATAS', 'activo'),
(14, 'MOTORCERBO', 'activo'),
(15, 'PERNOS', 'activo'),
(16, 'PINTURA', 'activo'),
(17, 'PIÑONES', 'activo'),
(18, 'RETENES', 'activo'),
(19, 'RODAMIENTO', 'activo'),
(20, 'SEGUROS', 'activo'),
(21, 'SENSOR', 'activo'),
(22, 'SINFÍN', 'activo'),
(23, 'Maquinaria', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cita`
--

CREATE TABLE `tb_cita` (
  `id_cita` bigint(20) UNSIGNED NOT NULL,
  `id_sucursal` int(11) NOT NULL DEFAULT 1,
  `id_trabajador` bigint(20) UNSIGNED NOT NULL,
  `id_servicio` bigint(20) UNSIGNED NOT NULL,
  `id_mascota` bigint(20) UNSIGNED NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_cita` datetime NOT NULL,
  `fecha_termino` datetime DEFAULT NULL,
  `sintoma` varchar(1000) DEFAULT NULL,
  `observaciones` varchar(1000) DEFAULT NULL,
  `mensaje_cita` varchar(1000) DEFAULT NULL,
  `estado` enum('registrada','aceptada','cancelada','anulada','atendida') NOT NULL DEFAULT 'registrada'
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cliente`
--

CREATE TABLE `tb_cliente` (
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_persona` bigint(20) UNSIGNED NOT NULL,
  `name_user` varchar(100) DEFAULT NULL,
  `pass_user` varchar(500) DEFAULT NULL,
  `cod_recuperacion` varchar(500) DEFAULT NULL,
  `fecha_activacion` date DEFAULT NULL,
  `fecha_recuperacion` date DEFAULT NULL,
  `src_imagen` varchar(500) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_cliente`
--

INSERT INTO `tb_cliente` (`id_cliente`, `id_persona`, `name_user`, `pass_user`, `cod_recuperacion`, `fecha_activacion`, `fecha_recuperacion`, `src_imagen`, `estado`) VALUES
(2, 32, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(3, 33, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(4, 34, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(5, 35, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(6, 36, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(7, 37, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(8, 38, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(9, 39, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(10, 40, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(11, 41, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(12, 42, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(13, 43, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(14, 44, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(15, 45, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(16, 46, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(17, 47, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(18, 48, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(19, 49, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(20, 50, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(21, 51, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(22, 52, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(23, 53, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(24, 54, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(25, 55, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(26, 56, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(27, 57, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(28, 58, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(29, 59, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(30, 60, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(31, 61, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(32, 62, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(33, 64, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(34, 65, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(35, 66, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(36, 67, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(37, 68, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(40, 70, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(41, 71, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(42, 72, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(43, 73, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(44, 74, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(45, 75, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(46, 76, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(47, 77, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(48, 78, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(49, 79, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(50, 80, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(51, 81, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(52, 82, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(53, 83, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(54, 84, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(55, 85, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(56, 86, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(57, 87, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(58, 88, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(59, 89, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(60, 90, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(61, 91, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(62, 92, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(63, 93, NULL, NULL, NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(64, 97, NULL, NULL, NULL, '2024-12-13', NULL, 'resources/global/images/sin_imagen.png', 'activo'),
(65, 1, '77229532@gmail.com', '1234', NULL, '2024-12-18', NULL, 'resources/global/images/default-profile.png', 'activo'),
(66, 29, '76531247@gmail.com', '1234', NULL, '2024-12-18', NULL, 'resources/global/images/default-profile.png', 'activo'),
(67, 63, '48745179@gmail.com', '1234', NULL, '2024-12-18', NULL, 'resources/global/images/default-profile.png', 'activo'),
(68, 95, '01045475@gmail.com', '1234', NULL, '2024-12-23', NULL, 'resources/global/images/default-profile.png', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cliente_fundo`
--

CREATE TABLE `tb_cliente_fundo` (
  `id` bigint(20) NOT NULL,
  `id_cliente` bigint(20) UNSIGNED DEFAULT NULL,
  `id_fundo` int(11) DEFAULT NULL,
  `cantidad_hc` float DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_cliente_fundo`
--

INSERT INTO `tb_cliente_fundo` (`id`, `id_cliente`, `id_fundo`, `cantidad_hc`) VALUES
(5, 7, 1, 45),
(6, 7, 3, 9),
(8, 18, 2, 6),
(9, 2, 8, 5.5),
(10, 3, 1, 6),
(11, 3, 4, 23),
(12, 4, 2, 6),
(13, 5, 2, 1.5),
(14, 6, 2, 1),
(15, 8, 6, 4.5),
(18, 9, 2, 20),
(19, 9, 8, 10),
(20, 10, 1, 1.1),
(21, 11, 2, 20),
(22, 11, 3, 3),
(23, 11, 4, 4),
(24, 12, 2, 6),
(25, 13, 8, 11.5),
(26, 14, 4, 7),
(27, 15, 2, 2.5),
(29, 19, 2, 21),
(30, 20, 4, 3.5),
(31, 21, 2, 2),
(32, 22, 2, 6),
(33, 23, 9, 6),
(34, 24, 2, 3),
(35, 24, 3, 8),
(36, 24, 8, 10),
(37, 25, 2, 8),
(38, 26, 2, 22),
(39, 27, 2, 13),
(40, 28, 4, 4.5),
(41, 29, 2, 2.5),
(42, 29, 3, 2),
(43, 29, 4, 2),
(44, 30, 3, 18),
(45, 31, 6, 14),
(46, 32, 2, 5),
(47, 33, 9, 5.25),
(48, 35, 2, 8),
(49, 36, 2, 23),
(50, 37, 4, 5),
(51, 40, 4, 8),
(52, 41, 1, 7),
(53, 41, 3, 4),
(54, 42, 4, 11),
(55, 43, 4, 4),
(56, 44, 3, 10),
(57, 45, 2, 8),
(58, 16, 2, 5),
(59, 46, 2, 6),
(60, 46, 4, 11),
(61, 47, 4, 15),
(62, 48, 3, 6),
(63, 49, 3, 7),
(64, 50, 2, 1.25),
(65, 51, 2, 5),
(66, 52, 3, 10.5),
(67, 52, 4, 7.5),
(68, 53, 2, 12),
(69, 54, 1, 2.5),
(70, 55, 2, 14),
(71, 56, 9, 3.5),
(72, 57, 2, 10),
(73, 59, 3, 24.25),
(74, 60, 4, 11.5),
(75, 62, 5, 9),
(76, 63, 3, 14),
(77, 61, 3, 5),
(78, 17, 2, 3.75);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_compra`
--

CREATE TABLE `tb_compra` (
  `id_compra` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_trabajador` bigint(20) UNSIGNED NOT NULL,
  `id_documento_compra` int(11) NOT NULL,
  `name_documento_compra` varchar(100) NOT NULL,
  `codigo_documento_compra` varchar(4) NOT NULL,
  `serie` varchar(4) NOT NULL,
  `correlativo` varchar(12) NOT NULL,
  `id_documento_proveedor` bigint(20) UNSIGNED NOT NULL,
  `name_documento_proveedor` varchar(100) NOT NULL,
  `codigo_documento_proveedor` varchar(4) NOT NULL,
  `numero_documento_proveedor` varchar(30) NOT NULL,
  `id_forma_pago` int(11) NOT NULL,
  `codigo_forma_pago` varchar(4) NOT NULL,
  `name_forma_pago` varchar(100) NOT NULL,
  `proveedor` varchar(500) NOT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
  `descuento_total` decimal(18,2) DEFAULT 0.00,
  `sub_total` decimal(18,2) NOT NULL,
  `igv` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT '1',
  `pdf` varchar(500) DEFAULT NULL,
  `xml` varchar(500) DEFAULT NULL,
  `cdr` varchar(500) DEFAULT NULL,
  `mensaje_sunat` varchar(1000) DEFAULT NULL,
  `ruta` varchar(500) DEFAULT NULL,
  `token` varchar(500) DEFAULT NULL,
  `flag_doc_interno` char(1) NOT NULL DEFAULT '1',
  `monto_recibido` decimal(18,2) DEFAULT NULL,
  `vuelto` decimal(18,2) DEFAULT NULL,
  `id_moneda` int(11) NOT NULL,
  `codigo_moneda` varchar(4) NOT NULL,
  `signo_moneda` varchar(10) DEFAULT NULL,
  `abreviatura_moneda` varchar(10) DEFAULT NULL,
  `signo_moneda_cambio` varchar(10) NOT NULL DEFAULT 'S/ ',
  `monto_tipo_cambio` decimal(18,2) DEFAULT NULL,
  `observaciones` varchar(1000) DEFAULT NULL,
  `flag_enviado` char(1) DEFAULT '1'
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cronograma`
--

CREATE TABLE `tb_cronograma` (
  `id_cronograma` bigint(20) UNSIGNED NOT NULL,
  `id_servicio` bigint(20) UNSIGNED NOT NULL,
  `fecha_ingreso` datetime(2) NOT NULL,
  `fecha_salida` datetime(2) NOT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `monto_unitario` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) DEFAULT 0.00,
  `adelanto` decimal(10,2) DEFAULT 0.00,
  `monto_total` decimal(10,2) DEFAULT NULL,
  `saldo_por_pagar` decimal(10,2) DEFAULT NULL,
  `estado_pago` enum('PENDIENTE','CANCELADO') DEFAULT 'PENDIENTE',
  `estado_trabajo` enum('EN PROCESO','TERMINADO') DEFAULT 'EN PROCESO',
  `id_fundo` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_cronograma`
--

INSERT INTO `tb_cronograma` (`id_cronograma`, `id_servicio`, `fecha_ingreso`, `fecha_salida`, `lugar`, `cantidad`, `monto_unitario`, `descuento`, `adelanto`, `monto_total`, `saldo_por_pagar`, `estado_pago`, `estado_trabajo`, `id_fundo`, `id_cliente`) VALUES
(1, 8, '2024-12-24 12:00:00.00', '2024-12-24 13:30:00.00', '', 5.00, 170.00, 0.00, 0.00, 850.00, 850.00, 'PENDIENTE', 'EN PROCESO', 3, 61),
(2, 7, '2024-12-23 07:30:00.00', '2024-12-23 13:30:00.00', '', 6.00, 500.00, 0.00, 0.00, 3000.00, 3000.00, 'PENDIENTE', 'TERMINADO', 2, 18),
(3, 10, '2024-12-23 07:30:00.00', '2024-12-23 08:00:00.00', '', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', 'EN PROCESO', 2, 18),
(4, 4, '2024-12-28 03:00:00.00', '2024-12-28 03:30:00.00', '', 6.00, 500.00, 0.00, 0.00, 3000.00, 3000.00, 'PENDIENTE', 'EN PROCESO', 2, 18),
(10, 8, '2025-01-08 00:00:00.00', '2025-01-09 00:00:00.00', '', 7.00, 170.00, 0.00, 0.00, 1190.00, 1190.00, 'PENDIENTE', 'EN PROCESO', 8, 2),
(11, 4, '2025-01-17 00:00:00.00', '2025-01-18 00:00:00.00', '', 6.00, 500.00, 0.00, 0.00, 3000.00, 3000.00, 'PENDIENTE', 'EN PROCESO', 2, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cronograma_maquinaria`
--

CREATE TABLE `tb_cronograma_maquinaria` (
  `id_cronograma_maquinaria` bigint(20) UNSIGNED NOT NULL,
  `id_cronograma` bigint(20) UNSIGNED NOT NULL,
  `id_maquinaria` bigint(20) UNSIGNED NOT NULL,
  `petroleo_entrada` decimal(10,2) DEFAULT NULL,
  `petroleo_salida` decimal(10,2) DEFAULT NULL,
  `consumo_petroleo` decimal(10,2) DEFAULT NULL,
  `precio_petroleo` decimal(10,2) DEFAULT NULL,
  `pago_petroleo` decimal(10,2) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_cronograma_maquinaria`
--

INSERT INTO `tb_cronograma_maquinaria` (`id_cronograma_maquinaria`, `id_cronograma`, `id_maquinaria`, `petroleo_entrada`, `petroleo_salida`, `consumo_petroleo`, `precio_petroleo`, `pago_petroleo`) VALUES
(1, 10, 2, NULL, NULL, NULL, NULL, NULL),
(2, 11, 5, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cronograma_operadores`
--

CREATE TABLE `tb_cronograma_operadores` (
  `id_cronograma_operador` bigint(20) UNSIGNED NOT NULL,
  `id_cronograma` bigint(20) UNSIGNED NOT NULL,
  `id_trabajador` bigint(20) UNSIGNED NOT NULL,
  `horas_trabajadas` decimal(10,2) NOT NULL,
  `pago_por_hora` decimal(10,2) DEFAULT NULL,
  `total_pago` decimal(10,2) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_cronograma_operadores`
--

INSERT INTO `tb_cronograma_operadores` (`id_cronograma_operador`, `id_cronograma`, `id_trabajador`, `horas_trabajadas`, `pago_por_hora`, `total_pago`) VALUES
(1, 10, 8, 0.00, NULL, NULL),
(2, 11, 7, 0.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_detalle_cita`
--

CREATE TABLE `tb_detalle_cita` (
  `id_detalle` bigint(20) NOT NULL,
  `id_cita` bigint(20) UNSIGNED NOT NULL,
  `name_servicio` varchar(200) DEFAULT NULL,
  `motivo` text DEFAULT NULL,
  `sintomas` text DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `vacunas_aplicadas` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `peso` varchar(100) DEFAULT NULL,
  `fecha_detalle_cita` datetime DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_detalle_compra`
--

CREATE TABLE `tb_detalle_compra` (
  `id_detalle` bigint(20) NOT NULL,
  `id_orden_compra` int(11) NOT NULL,
  `name_tabla` varchar(100) NOT NULL,
  `cod_producto` int(11) NOT NULL,
  `cantidad_solicitada` int(11) DEFAULT NULL,
  `cantidad_ingresada` int(11) DEFAULT NULL,
  `precio_unitario` decimal(18,2) DEFAULT NULL,
  `notas` varchar(200) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_detalle_compra`
--

INSERT INTO `tb_detalle_compra` (`id_detalle`, `id_orden_compra`, `name_tabla`, `cod_producto`, `cantidad_solicitada`, `cantidad_ingresada`, `precio_unitario`, `notas`) VALUES
(36, 2, 'accesorio', 1, 5, 0, 70.00, ''),
(40, 3, 'accesorio', 1, 1, 0, 70.00, ''),
(41, 3, 'accesorio', 2, 1, 0, 0.00, ''),
(42, 4, 'accesorio', 213, 1, 0, 135000.00, ''),
(43, 5, 'accesorio', 1, 2, 0, 95.00, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_detalle_ingreso`
--

CREATE TABLE `tb_detalle_ingreso` (
  `id_detalle` bigint(20) NOT NULL,
  `id_ingreso` bigint(20) NOT NULL,
  `name_tabla` varchar(200) DEFAULT NULL,
  `cod_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_detalle_ingreso`
--

INSERT INTO `tb_detalle_ingreso` (`id_detalle`, `id_ingreso`, `name_tabla`, `cod_producto`, `cantidad`, `observaciones`) VALUES
(7, 1, 'accesorio', 1, 5, ''),
(8, 2, 'accesorio', 2, 1, 'fdfdfddf dffdfdfdf'),
(9, 3, 'accesorio', 2, 1, ''),
(10, 3, 'accesorio', 1, 1, ''),
(11, 4, 'accesorio', 1, 2, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_detalle_venta`
--

CREATE TABLE `tb_detalle_venta` (
  `id_detalle` bigint(20) UNSIGNED NOT NULL,
  `id_venta` int(11) NOT NULL,
  `name_tabla` varchar(100) DEFAULT NULL,
  `cod_producto` varchar(20) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `cantidad` decimal(18,2) NOT NULL,
  `precio_unitario` decimal(18,2) DEFAULT NULL,
  `descuento` decimal(18,2) DEFAULT 0.00,
  `sub_total` decimal(18,2) DEFAULT 0.00,
  `tipo_igv` varchar(2) DEFAULT NULL,
  `igv` decimal(18,2) DEFAULT 0.00,
  `total` decimal(18,2) DEFAULT 0.00,
  `notas` varchar(200) DEFAULT NULL,
  `id_maquinaria` int(11) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_detalle_venta`
--

INSERT INTO `tb_detalle_venta` (`id_detalle`, `id_venta`, `name_tabla`, `cod_producto`, `descripcion`, `cantidad`, `precio_unitario`, `descuento`, `sub_total`, `tipo_igv`, `igv`, `total`, `notas`, `id_maquinaria`) VALUES
(1, 1, 'producto', '13', 'CATALINA DE LA CADENA DE ALIMENTACION', 1.00, 0.85, 1.00, 1.00, '1', 0.18, 1.18, '', 8),
(2, 1, 'producto', '16', 'DEDOS DE CORTE', 1.00, 0.85, 1.00, 1.00, '1', 0.18, 1.18, '', 1),
(3, 2, 'producto', '1', 'BOCINA DE POLEA DE HST', 1.00, 0.85, 1.00, 1.00, '1', 0.18, 1.18, '', 4),
(4, 3, 'producto', '1', 'BOCINA DE POLEA DE HST', 4.00, 0.85, 1.00, 4.00, '1', 0.72, 4.72, '', 6),
(5, 4, 'producto', '1', 'BOCINA DE POLEA DE HST', 1.00, 0.85, 1.00, 1.00, '1', 0.18, 1.18, 'gyjgjfgdhfgdh', 1),
(6, 5, 'producto', '186', 'RODAJE 6304', 4.00, 0.85, 1.00, 4.00, '1', 0.72, 4.72, 'fghdsrdgdgdg', 3),
(7, 6, 'producto', '2', 'BOCINA DEL ROTOR', 1.00, 0.85, 1.00, 1.00, '1', 0.18, 1.18, '', 4),
(8, 7, 'producto', '77', 'BALDE DE GRASA VISTONY 15.85 KG', 1.00, 0.85, 1.00, 1.00, '1', 0.18, 1.18, '', 0),
(9, 8, 'producto', '77', 'BALDE DE GRASA VISTONY 15.85 KG', 1.00, 0.85, 1.00, 1.00, '1', 0.18, 1.18, 'PARA TODOS LOS TRACTORES', 8),
(10, 9, 'producto', '71', 'SIKAFLEX', 31.00, 0.85, 1.00, 31.00, '1', 5.58, 36.58, '', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_documento_identidad`
--

CREATE TABLE `tb_documento_identidad` (
  `id_documento` bigint(20) UNSIGNED NOT NULL,
  `name_documento` varchar(100) NOT NULL,
  `codigo_sunat` varchar(10) NOT NULL,
  `flag_numerico` tinyint(1) NOT NULL DEFAULT 0,
  `flag_exacto` tinyint(1) NOT NULL DEFAULT 0,
  `size` int(11) NOT NULL DEFAULT 8,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_documento_identidad`
--

INSERT INTO `tb_documento_identidad` (`id_documento`, `name_documento`, `codigo_sunat`, `flag_numerico`, `flag_exacto`, `size`, `estado`) VALUES
(1, 'DNI', '1', 1, 1, 8, 'activo'),
(3, 'RUC', '6', 1, 1, 11, 'activo'),
(4, 'C.E.', '4', 0, 0, 12, 'activo'),
(5, 'PASAPORTE', '7', 0, 0, 11, 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_documento_venta`
--

CREATE TABLE `tb_documento_venta` (
  `id_documento_venta` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `cod_sunat` varchar(10) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `nombre_corto` varchar(50) NOT NULL,
  `serie` varchar(6) DEFAULT NULL,
  `correlativo` bigint(20) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `flag_doc_interno` char(1) DEFAULT NULL,
  `flag_ingreso` char(1) DEFAULT NULL,
  `flag_salida` char(1) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_documento_venta`
--

INSERT INTO `tb_documento_venta` (`id_documento_venta`, `id_sucursal`, `cod_sunat`, `nombre`, `nombre_corto`, `serie`, `correlativo`, `estado`, `flag_doc_interno`, `flag_ingreso`, `flag_salida`) VALUES
(3, 1, '-', 'TICKET DE SALIDA', 'TICKET DE SALIDA', 'TIK1', 10, '1', '1', '0', '1'),
(4, 1, '03', 'BOLETA', 'BOLETA', 'B001', 1, '1', '0', '1', '0'),
(5, 1, '01', 'FACTURA', 'FACTURA', 'F001', 1, '1', '0', '1', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_empresa`
--

CREATE TABLE `tb_empresa` (
  `id_empresa` bigint(20) UNSIGNED NOT NULL,
  `id_documento` bigint(20) UNSIGNED NOT NULL,
  `num_documento` varchar(30) NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `nombre_comercial` varchar(150) DEFAULT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  `fono01` varchar(30) DEFAULT NULL,
  `correo01` varchar(100) DEFAULT NULL,
  `web` varchar(150) DEFAULT NULL,
  `id_documento_representante` bigint(20) UNSIGNED NOT NULL,
  `num_documento_representante` varchar(30) NOT NULL,
  `nombres_representante` varchar(50) NOT NULL,
  `apellidos_representante` varchar(50) NOT NULL,
  `fono02` varchar(30) DEFAULT NULL,
  `correo02` varchar(100) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `src_logo` varchar(150) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_empresa`
--

INSERT INTO `tb_empresa` (`id_empresa`, `id_documento`, `num_documento`, `razon_social`, `nombre_comercial`, `direccion`, `fono01`, `correo01`, `web`, `id_documento_representante`, `num_documento_representante`, `nombres_representante`, `apellidos_representante`, `fono02`, `correo02`, `estado`, `src_logo`) VALUES
(1, 3, '20609073323', 'BARBOZA AGROSERVICIOS EIRL', 'BSGPERU', 'CASERIO LAS MALVINAS-CURIMANA', '924708460', 'Administracion@bsgperu.com', 'https://syscos.com/', 1, '41137440', 'Segundo Alcides', 'Barboza Nuñez', '924708460', 'barboza.sg2008@gmail.com', 'activo', 'resources/global/images/business_logo/img-1736147863.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_especialidad`
--

CREATE TABLE `tb_especialidad` (
  `id_especialidad` bigint(20) UNSIGNED NOT NULL,
  `name_especialidad` varchar(100) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_especialidad`
--

INSERT INTO `tb_especialidad` (`id_especialidad`, `name_especialidad`, `estado`) VALUES
(1, 'Usuario', 'activo'),
(2, 'Administrador', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_forma_pago`
--

CREATE TABLE `tb_forma_pago` (
  `id_forma_pago` int(11) NOT NULL,
  `name_forma_pago` varchar(200) NOT NULL,
  `cod_sunat` varchar(10) DEFAULT NULL,
  `estado` char(1) DEFAULT '1'
) ;

--
-- Volcado de datos para la tabla `tb_forma_pago`
--

INSERT INTO `tb_forma_pago` (`id_forma_pago`, `name_forma_pago`, `cod_sunat`, `estado`) VALUES
(1, 'EFECTIVO', '01', '1'),
(2, 'CHEQUE', '02', '1'),
(3, 'TARJETA DE CRÉDITO', '03', '1'),
(4, 'TARJETA DE DÉBITO', '04', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_fundo`
--

CREATE TABLE `tb_fundo` (
  `id_fundo` int(11) NOT NULL,
  `id_empresa` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(300) NOT NULL,
  `cod_ubigeo` varchar(10) DEFAULT NULL,
  `direccion` varchar(1000) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `mapa` varchar(1000) DEFAULT NULL,
  `estado` char(1) DEFAULT '1',
  `token` varchar(1000) DEFAULT NULL,
  `ruta` varchar(1000) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_fundo`
--

INSERT INTO `tb_fundo` (`id_fundo`, `id_empresa`, `nombre`, `cod_ubigeo`, `direccion`, `telefono`, `mapa`, `estado`, `token`, `ruta`) VALUES
(1, 1, 'MALVINAS', '', '', '', '', '1', '', ''),
(2, 1, 'SOL NACIENTE', '', '', '', '', '1', '', ''),
(3, 1, '16 DE NOVIEMBRE', '', '', '', '', '1', '', ''),
(4, 1, 'FLOR DEL VALLE', '', '', '', '', '1', '', ''),
(5, 1, 'LIBERTAD', '', '', '', '', '1', '', ''),
(6, 1, 'SAN JUAN', '', '', '', '', '1', '', ''),
(7, 1, 'MARONAL', '', '', '', '', '1', '', ''),
(8, 1, 'CURIMANA', '', '', '', '', '1', '', ''),
(9, 1, 'OTROS (sin nombrar)', '', '', '', '', '1', '', ''),
(10, 1, 'ROCA FUERTE', '', 'ROCA FUERTE', '', '', '1', '', ''),
(11, 1, 'ALIANZA', '', 'ALIANZA', '', '', '1', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_galeria`
--

CREATE TABLE `tb_galeria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_tabla` varchar(1) NOT NULL DEFAULT '0',
  `src` varchar(200) DEFAULT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `referencia_1` varchar(200) DEFAULT NULL,
  `referencia_2` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_galeria`
--

INSERT INTO `tb_galeria` (`id`, `name_tabla`, `src`, `titulo`, `descripcion`, `referencia_1`, `referencia_2`, `url`, `estado`) VALUES
(1, '1', 'resources/global/images/galeria/img-1571247362.png', 'Acompañando al engrído', 'Una foto con la mascota en la clínica veterinaría.', NULL, NULL, NULL, 'activo'),
(2, '2', 'resources/global/images/galeria/img-1571247402.png', 'Pedigree', 'https://pedigree.com', NULL, NULL, NULL, 'activo'),
(3, '3', 'resources/global/images/testimonio/img-1571247436.png', 'Luisa Sanchez', 'Quiero recomendar a clínica veterinaria por el tiempo que mi mascota estuvo internado la trataron con mucha dedicación y amor... Amigos les recomiendo por la atención profesional que brinda.', '4', '16/10/2019', NULL, 'activo'),
(4, '3', 'resources/global/images/testimonio/img-1571247491.png', 'Magnolia Ramirez', 'Gracias al apoyo de la veterinaria que se preocupa por los animales abandonados, pude adoptar a Machin y ahora es parte de mi familia y me encanta ver a mis hijos felices con Machim, ', '5', '16/10/2019', NULL, 'activo'),
(5, '3', 'resources/global/images/testimonio/img-1571247599.png', 'Luis Sanchez', 'Cuando le detectaron un tumor a mi mascota la llevé a clínica veterinaria, la operaron y ahora está muy bien. Gracias, les recomiendo la atención es muy buena y los profesionales son muy carismáticos.', '5', '16/10/2019', NULL, 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_grupo_usuario`
--

CREATE TABLE `tb_grupo_usuario` (
  `id_grupo` bigint(20) UNSIGNED NOT NULL,
  `name_grupo` varchar(50) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_grupo_usuario`
--

INSERT INTO `tb_grupo_usuario` (`id_grupo`, `name_grupo`, `estado`) VALUES
(1, 'Administrador', 'activo'),
(2, 'Usuario', 'activo'),
(4, 'Asistente de Gerencia', 'activo'),
(5, 'Supervisor', 'activo'),
(6, 'Almacen', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ingreso`
--

CREATE TABLE `tb_ingreso` (
  `id_ingreso` bigint(20) NOT NULL,
  `id_orden_compra` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_trabajador` int(11) NOT NULL,
  `id_tipo_docu` int(11) DEFAULT NULL,
  `num_documento` varchar(50) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `src_evidencia` varchar(500) DEFAULT NULL,
  `total_ing` decimal(18,2) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_ingreso`
--

INSERT INTO `tb_ingreso` (`id_ingreso`, `id_orden_compra`, `id_sucursal`, `id_trabajador`, `id_tipo_docu`, `num_documento`, `fecha`, `observaciones`, `estado`, `src_evidencia`, `total_ing`) VALUES
(1, 2, 1, 4, 5, 'E001-0005', '2024-12-11 12:04:12', 'Mitad al contado y diferencia a credito', '0', 'resources/global/images/Pago IGV Julio.pdf', 0.00),
(2, 3, 1, 1, 4, 'B001-1212', '2024-12-12 19:20:50', '', '0', 'resources/global/images/Indicador_Tasa_Deteccion.png', 500.00),
(3, 3, 1, 4, 3, '123131-555', '2024-12-13 11:32:27', '', '0', 'resources/global/images/sin_imagen.png', 0.00),
(4, 5, 1, 6, 5, 'F001-00000324', '2025-01-02 07:36:22', '', '0', 'resources/global/images/ficha.pdf', 354.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_maquinaria`
--

CREATE TABLE `tb_maquinaria` (
  `id_maquinaria` bigint(20) UNSIGNED NOT NULL,
  `id_trabajador` int(11) DEFAULT NULL,
  `descripcion` varchar(200) NOT NULL,
  `observaciones` varchar(200) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_maquinaria`
--

INSERT INTO `tb_maquinaria` (`id_maquinaria`, `id_trabajador`, `descripcion`, `observaciones`, `estado`) VALUES
(1, 7, 'MAQUINA 1', '', 'activo'),
(2, 8, 'MAQUINA 2', '', 'activo'),
(3, 7, 'MAQUINA 3', '', 'activo'),
(4, 8, 'MAQUINA 4', '', 'activo'),
(5, 7, 'MAQUINA 5', '', 'activo'),
(6, 8, 'MAQUINA 6', '', 'activo'),
(7, 7, 'MAQUINA 7', '', 'activo'),
(8, 8, 'TRACTOR KUBOTA-1', '', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_mascota`
--

CREATE TABLE `tb_mascota` (
  `id_mascota` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_mascota` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `raza` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `peso` varchar(50) DEFAULT NULL,
  `sexo` enum('hembra','macho') NOT NULL DEFAULT 'hembra',
  `fecha_nacimiento` date DEFAULT NULL,
  `observaciones` varchar(1000) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `src_imagen` varchar(150) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_mascota_vacuna`
--

CREATE TABLE `tb_mascota_vacuna` (
  `id_mascota_vacuna` bigint(20) UNSIGNED NOT NULL,
  `id_mascota` bigint(20) UNSIGNED NOT NULL,
  `id_vacuna` bigint(20) UNSIGNED NOT NULL,
  `fecha_minima` date DEFAULT NULL,
  `fecha_maxima` date DEFAULT NULL,
  `fecha_aplicacion` datetime DEFAULT NULL,
  `flag_vacuna` tinyint(1) NOT NULL DEFAULT 0,
  `observaciones` varchar(1000) DEFAULT NULL,
  `name_sucursal` varchar(300) DEFAULT '',
  `name_user` varchar(300) DEFAULT ''
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_medicamento`
--

CREATE TABLE `tb_medicamento` (
  `id_medicamento` bigint(20) UNSIGNED NOT NULL,
  `id_sucursal` int(11) NOT NULL DEFAULT 1,
  `id_tipo_medicamento` bigint(20) UNSIGNED NOT NULL,
  `id_unidad_medida` int(11) NOT NULL DEFAULT 1,
  `name_medicamento` varchar(100) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 0,
  `precio_compra` double(8,2) NOT NULL DEFAULT 0.00,
  `id_moneda` int(11) NOT NULL DEFAULT 1,
  `signo_moneda` varchar(10) NOT NULL DEFAULT 'S/',
  `precio_venta` double(8,2) NOT NULL DEFAULT 0.00,
  `flag_igv` char(1) NOT NULL DEFAULT '1',
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `src_imagen` varchar(150) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_metodo_envio`
--

CREATE TABLE `tb_metodo_envio` (
  `id_metodo_envio` int(11) NOT NULL,
  `name_metodo` varchar(200) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_metodo_envio`
--

INSERT INTO `tb_metodo_envio` (`id_metodo_envio`, `name_metodo`, `estado`) VALUES
(1, 'DHL EXPRESS', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_moneda`
--

CREATE TABLE `tb_moneda` (
  `id_moneda` int(11) NOT NULL,
  `name_moneda` varchar(200) DEFAULT NULL,
  `cod_sunat` varchar(10) DEFAULT NULL,
  `signo` varchar(10) DEFAULT NULL,
  `abreviatura` varchar(10) DEFAULT NULL,
  `tipo_cambio` decimal(18,3) DEFAULT 1.000,
  `flag_principal` char(1) DEFAULT '0',
  `estado` char(1) DEFAULT '1'
) ;

--
-- Volcado de datos para la tabla `tb_moneda`
--

INSERT INTO `tb_moneda` (`id_moneda`, `name_moneda`, `cod_sunat`, `signo`, `abreviatura`, `tipo_cambio`, `flag_principal`, `estado`) VALUES
(1, 'SOLES', '1', 'S/', 'PEN', 1.000, '1', '1'),
(2, 'DÓLARES', '2', '$', 'USD', 3.500, '0', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_opcion`
--

CREATE TABLE `tb_opcion` (
  `id_opcion` int(11) NOT NULL,
  `name_opcion` varchar(50) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `url` varchar(100) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `icono` varchar(100) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_opcion`
--

INSERT INTO `tb_opcion` (`id_opcion`, `name_opcion`, `estado`, `url`, `order`, `icono`) VALUES
(100, 'Configuración', 'activo', NULL, 0, NULL),
(101, 'Mi Empresa', 'activo', NULL, 1, NULL),
(102, 'Sucursales', 'activo', NULL, 2, NULL),
(103, 'Monedas', 'activo', NULL, 3, NULL),
(104, 'Documentos de Identidad', 'activo', NULL, 4, NULL),
(105, 'Cargos usuarios', 'activo', NULL, 5, NULL),
(106, 'Categorias de Productos', 'activo', NULL, 6, NULL),
(107, 'Tipos de Servicios', 'activo', NULL, 7, NULL),
(108, 'Tipos de Operaciones', 'activo', NULL, 8, NULL),
(109, 'Tipos de Productos', 'activo', NULL, 9, NULL),
(110, 'Métodos de Pago', 'activo', NULL, 10, NULL),
(111, 'Tipo de Cambio', 'activo', NULL, 11, NULL),
(112, 'Documentos de Venta', 'activo', NULL, 12, NULL),
(113, 'Unidades de Medida', 'activo', NULL, 13, NULL),
(114, 'Métodos de Envío', 'activo', NULL, 14, NULL),
(115, 'Tipo de Cosecha', 'activo', NULL, 0, NULL),
(200, 'Mantenimiento', 'activo', NULL, 0, NULL),
(201, 'Clientes', 'activo', NULL, 0, NULL),
(202, 'Servicios', 'activo', NULL, 0, NULL),
(203, 'Productos', 'activo', NULL, 0, NULL),
(204, 'Productos', 'activo', NULL, 0, NULL),
(205, 'Médicos - Servicios', 'activo', NULL, 0, NULL),
(206, 'Vacunas', 'activo', NULL, 0, NULL),
(207, 'Operaciones', 'activo', NULL, 0, NULL),
(208, 'Proveedores', 'activo', NULL, 0, NULL),
(209, 'Fundos', 'activo', NULL, 0, NULL),
(210, 'Operador', 'activo', NULL, 0, NULL),
(211, 'Maquinaria', 'activo', NULL, 0, NULL),
(212, 'Acceso a Fundos', 'activo', NULL, 0, NULL),
(213, NULL, '', NULL, 0, NULL),
(214, NULL, '', NULL, 0, NULL),
(215, NULL, '', NULL, 0, NULL),
(300, 'Seguridad', 'activo', NULL, 0, NULL),
(301, 'Grupos de Usuarios', 'activo', NULL, 0, NULL),
(302, 'Acceso a Opciones', 'activo', NULL, 0, NULL),
(303, 'Acceso a Sucursales', 'activo', NULL, 0, NULL),
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
(406, 'Datos de Contacto', 'activo', NULL, 0, NULL),
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
(502, 'Atención de Citas', 'activo', NULL, 0, NULL),
(503, 'Historial ', 'activo', NULL, 0, NULL),
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
(601, 'Ficha de Operación y Vacunas', 'activo', NULL, 0, NULL),
(602, 'Facturación', 'activo', NULL, 0, NULL),
(603, 'Ordenes de Compra', 'activo', NULL, 0, NULL),
(604, 'Promociones Clientes', 'activo', NULL, 0, NULL),
(605, 'Ingreso de Productos', 'activo', NULL, 0, NULL),
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
(701, 'Reporte de Compras', 'inactivo', NULL, 0, NULL),
(702, 'Reporte de Ventas', 'activo', NULL, 0, NULL),
(703, 'Reporte de Productos', 'activo', NULL, 0, NULL),
(704, 'Reporte de Productos', 'activo', NULL, 0, NULL),
(705, 'Mostrar Estadísticas', 'activo', NULL, 0, NULL),
(706, 'Reporte de Proveedores', 'activo', NULL, 0, NULL),
(707, 'Reporte de Citas', 'activo', NULL, 0, NULL),
(708, 'Reporte de Clientes', 'activo', NULL, 0, NULL),
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
  `id_operador` bigint(20) UNSIGNED NOT NULL,
  `id_persona` bigint(20) UNSIGNED NOT NULL,
  `name_user` varchar(255) DEFAULT NULL,
  `pass_user` varchar(255) DEFAULT NULL,
  `cod_recuperacion` varchar(500) DEFAULT NULL,
  `fecha_activacion` date DEFAULT NULL,
  `fecha_recuperacion` date DEFAULT NULL,
  `src_imagen` varchar(500) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_operador`
--

INSERT INTO `tb_operador` (`id_operador`, `id_persona`, `name_user`, `pass_user`, `cod_recuperacion`, `fecha_activacion`, `fecha_recuperacion`, `src_imagen`, `estado`) VALUES
(1, 6, '', '', NULL, '2024-11-20', NULL, 'resources/global/images/sin_imagen.png', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_orden_compra`
--

CREATE TABLE `tb_orden_compra` (
  `id_orden_compra` int(11) NOT NULL,
  `id_metodo_envio` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_trabajador` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `fecha_orden` datetime NOT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `estado` char(1) NOT NULL,
  `id_moneda` int(11) NOT NULL
) ;

--
-- Volcado de datos para la tabla `tb_orden_compra`
--

INSERT INTO `tb_orden_compra` (`id_orden_compra`, `id_metodo_envio`, `id_proveedor`, `id_trabajador`, `id_sucursal`, `fecha_orden`, `fecha_entrega`, `descripcion`, `observaciones`, `estado`, `id_moneda`) VALUES
(2, 1, 1, 4, 1, '2024-12-11 12:01:17', '2024-12-11 00:00:00', NULL, '', '2', 1),
(3, 1, 1, 1, 1, '2024-12-12 19:19:23', '2024-12-12 00:00:00', NULL, '', '2', 1),
(4, 1, 1, 4, 1, '2024-12-16 03:27:51', '2024-12-16 00:00:00', NULL, '', '0', 1),
(5, 1, 2, 6, 1, '2025-01-02 07:30:29', '2025-01-02 00:00:00', NULL, '', '2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_pago`
--

CREATE TABLE `tb_pago` (
  `id_pago` int(11) NOT NULL,
  `id_ingreso` int(11) DEFAULT NULL,
  `id_forma_pago` int(11) DEFAULT NULL,
  `fecha_pago` datetime DEFAULT NULL,
  `monto_pagado` decimal(18,2) DEFAULT NULL,
  `src_factura` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_pago`
--

INSERT INTO `tb_pago` (`id_pago`, `id_ingreso`, `id_forma_pago`, `fecha_pago`, `monto_pagado`, `src_factura`) VALUES
(1, 2, 1, '2024-12-12 00:00:00', 250.00, 'resources/global/images/Indicador3_Fortaleza_Contrase%C3%B1as.png'),
(2, 2, 1, '2024-12-13 00:00:00', 250.00, 'resources/global/images/Indicador3_Fortaleza_Contrase%C3%B1as.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_pagos_clientes`
--

CREATE TABLE `tb_pagos_clientes` (
  `id_pago_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_cronograma` bigint(20) UNSIGNED NOT NULL,
  `fecha_pago` date NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_parametros_generales`
--

CREATE TABLE `tb_parametros_generales` (
  `id_parametro` int(11) NOT NULL,
  `name_parametro` varchar(150) DEFAULT NULL,
  `valor_int` int(11) NOT NULL DEFAULT 0,
  `valor_string` varchar(1000) DEFAULT NULL,
  `valor_decimal` decimal(8,2) NOT NULL DEFAULT 0.00,
  `valor_bit` tinyint(1) NOT NULL DEFAULT 0
) ;

--
-- Volcado de datos para la tabla `tb_parametros_generales`
--

INSERT INTO `tb_parametros_generales` (`id_parametro`, `name_parametro`, `valor_int`, `valor_string`, `valor_decimal`, `valor_bit`) VALUES
(1, 'Imagen Banner 1', 0, 'resources/global/images/paginaweb/fondo1.jpg', 0.00, 1),
(2, 'Imagen Banner 2', 0, 'resources/global/images/paginaweb/fondo2.jpg', 0.00, 1),
(3, 'Imagen Banner 3', 0, 'resources/global/images/paginaweb/fondo3.jpg', 0.00, 1),
(4, 'Titulo Banner 1', 0, 'Bienvenidos a Pet Space', 0.00, 1),
(5, 'Titulo Banner 2', 0, 'Brinda una mejor atención a tus clientes', 0.00, 0),
(6, 'Titulo Banner 3', 0, 'Profesionales altamente calificados', 0.00, 1),
(7, 'Descripcion Banner 1', 0, 'Una Plataforma en la cuál podrás administrar tu veterinaria desde cualquier lugar.', 0.00, 0),
(8, 'Descripcion Banner 2', 0, 'Así podrás mantenerte en contacto con tus clientes, ofreciendo un valor agregado a tu negocio.', 0.00, 0),
(9, 'Descripcion Banner 3', 0, 'Nuestro equipo de profesionales con más de 10 años de experiencia, te brindarán un apoyo constante en todo momento.', 0.00, 0),
(10, 'Texto Boton 1', 0, 'Mas información', 0.00, 0),
(11, 'Texto Boton 2', 0, 'Mas isnformación', 0.00, 0),
(12, 'Texto Boton 3', 0, 'Mas información', 0.00, 0),
(13, 'Enlace banner 1', 0, '?view=conocenos', 0.00, 0),
(14, 'Enlace banner 2', 0, '?view=conocenos', 0.00, 0),
(15, 'Enlace banner 3', 0, '?view=conocenos', 0.00, 0),
(16, 'Horario Top Nav', 0, 'Lunes - Sábado 8:00 - 17:00', 0.00, 0),
(17, 'Correo Soporte Técnico', 0, 'informes@veterinariamican.com', 0.00, 0),
(18, 'Telefono', 0, '(+51) 930744960', 0.00, 0),
(19, 'Link Facebook', 0, 'https://www.facebook.com', 0.00, 0),
(20, 'Link Instagram', 0, 'https://www.instagram.com', 0.00, 0),
(21, 'Link Youtube', 0, 'https://www.youtube.com', 0.00, 0),
(22, 'Link Twitter', 0, 'https://www.twitter.com', 0.00, 0),
(23, 'Logo Página', 0, 'resources/assets-web/img/logo.png', 0.00, 0),
(24, 'Direccion Footer', 0, 'Jr. Pedro Remy 177 - SMP - Lima', 0.00, 0),
(25, 'Clientes Felices', 1076, NULL, 0.00, 0),
(26, 'Proyectos Completados', 12, NULL, 0.00, 0),
(27, 'Premios Ganados', 15, NULL, 0.00, 0),
(28, 'Horas Trabajadas', 3050, NULL, 0.00, 0),
(29, 'Horario Lunes', 0, '8:00 - 18:00', 0.00, 0),
(30, 'Horario Martes', 0, '8:00 - 18:00', 0.00, 0),
(31, 'Horario Miercoles', 0, '8:00 - 18:00', 0.00, 0),
(32, 'Horario Jueves', 0, '8:00 - 18:00', 0.00, 0),
(33, 'Horario Viernes', 0, '8:00 - 18:00', 0.00, 0),
(34, 'Horario Sabado', 0, 'Cerrado', 0.00, 0),
(35, 'Horario Domingo', 0, 'Cerrado', 0.00, 0),
(36, 'Descripcion Footer', 0, 'Descripcion Footer', 0.00, 0),
(37, 'Mapa Contacto', 0, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.3688387144507!2d-77.03578688561743!3d-12.086882845937915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c9da03b255e1%3A0xfba2569a5919029a!2sTecnovo+Per%C3%BA!5e0!3m2!1ses-419!2sus!4v1566490062500!5m2!1ses-419!2sus\" width=\"100%\" height=\"500\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 0.00, 0),
(38, 'IGV', 0, NULL, 18.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_persona`
--

CREATE TABLE `tb_persona` (
  `id_persona` bigint(20) UNSIGNED NOT NULL,
  `id_documento` bigint(20) UNSIGNED NOT NULL,
  `num_documento` varchar(30) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` enum('masculino','femenino') NOT NULL DEFAULT 'masculino',
  `apodo` varchar(100) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_persona`
--

INSERT INTO `tb_persona` (`id_persona`, `id_documento`, `num_documento`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo`, `fecha_nacimiento`, `sexo`, `apodo`) VALUES
(1, 1, '77229532', 'ZHAUL ALBERTO', 'VALDERA VIDAURRE', '', '', '', '1995-05-12', 'masculino', ''),
(29, 1, '76531247', 'SOYNER LUIS', 'CORONEL QUINTANA', '', '', '', '1994-06-14', 'masculino', NULL),
(30, 4, '007381362', 'Eluz Yinezka', 'Aguilera', 'Lima', '901468527', 'asistente@bsgperu.com', '1981-07-18', 'femenino', ''),
(31, 1, '77229534', 'JORGE LUIS', 'SANTISTEBAN BANCES', 'ssdsdsds', '987237832', '', '1994-12-02', 'masculino', ''),
(32, 1, '41286369', 'ELDER', 'HURTADO GARCIA', 'Malvinas', '922034484', '', '1994-12-02', 'masculino', 'SOCIO AMANDA'),
(33, 1, '40304662', 'YLSIAS', 'ENCALADA TAFUR', 'Malvinas', '955356677', '', '1994-12-02', 'masculino', 'YLSIAS'),
(34, 1, '01049136', 'JAIVER', 'MONTENEGRO CARRASCO', 'Malvinas', '', '', '1994-12-02', 'masculino', 'JAIME'),
(35, 1, '77041551', 'LEOPOLDO', 'MALDONADO MONSALVE', 'Malvinas', '', '', '1994-12-02', 'masculino', 'LEO'),
(36, 1, '42131622', 'FRANCISCO', 'DELGADO OCHOA', 'Malvinas', '902280691', '', '1994-12-02', 'masculino', 'PRIMO JUANITO'),
(37, 1, '01053464', 'ALCIDES', 'BARBOZA ACUÑA', 'Malvinas', '942863442', '', '1994-12-02', 'masculino', 'ALCIDES'),
(38, 1, '18988149', 'WILDER', 'ROJAS SALAZAR', 'Malvinas', '', '', '1994-12-02', 'masculino', 'WILDER'),
(39, 1, '00952584', 'ONECIMO', 'RAMOS YDROGO', 'Malvinas', '921216671', '', '1994-12-02', 'masculino', 'ONECIMO'),
(40, 1, '27737918', 'FELIPE', 'MIJAHUANCA RAMIREZ', 'Malvinas', '', '', '1994-12-02', 'masculino', 'FELIPE'),
(41, 1, '45168934', 'JAIME', 'RODRIGO BAUTISTA', 'Malvinas', '934687276', '', '1994-12-02', 'masculino', 'PEPE LUCHO'),
(42, 1, '77041542', 'BARTOLOME', 'RODRIGO VITON', 'Malvinas', '', '', '1994-12-02', 'masculino', 'BARTOLOME'),
(43, 1, '20043382', 'HUGO RAUL', 'SANCHEZ ESPINOZA', 'Malvinas', '996236617', '', '1994-12-02', 'masculino', 'MENESES'),
(44, 1, '16800010', 'CLEMENTE', 'SANTOS CRUZ', 'Malvinas', '903559097', '', '1994-12-02', 'masculino', 'PUNTA'),
(45, 1, '73211515', 'ROYFER', 'VALENCIA GUEVARA', 'Malvinas', '', '', '1994-12-02', 'masculino', 'GUARASHO'),
(46, 1, '40915823', 'JOSE NELVY', 'LULIQUIS CARRASCO', 'Malvinas', '', '', '1994-12-02', 'masculino', 'JOSE'),
(47, 1, '78463061', 'HELI RAMIRO', 'CORONEL GONZALES', 'mALVINAS', '', '', '1994-12-02', 'masculino', 'HELI'),
(48, 3, '10457319296', 'CARRANZA MESTANZA JOSE EBER', '', 'Malvinas', '966300153', '', '1994-12-02', 'masculino', 'HOGAREÑO'),
(49, 1, '41634648', 'MANUEL', 'HEREDIA MARTINEZ', 'Malvinas', '922397268', '', '1994-12-02', 'masculino', 'HEREDIA'),
(50, 1, '80563343', 'NORVIL MERCEDES', 'RAFAEL SANCHEZ', 'Malvinas', '', '', '1994-12-02', 'femenino', 'NORVIL'),
(51, 1, '80327419', 'VICTOR', 'DEL AGUILA MAS', 'Malvinas', '', '', '1994-12-02', 'masculino', 'VICTOR'),
(52, 1, '43475199', 'SALVADOR', 'CARRASCO CHACHAPOYAS', 'Malvinas', '', '', '1994-12-02', 'masculino', 'SALVADOR'),
(53, 1, '41435108', 'EDUAR', 'HURTADO GARCIA', 'Malvinas', '919667357', '', '1994-12-02', 'masculino', 'SOCIO AMANDA'),
(54, 1, '27398237', 'IVAN', 'BURGA MONTEZA', 'Malvinas', '944218797', '', '1994-12-02', 'masculino', 'IVAN'),
(55, 1, '27398042', 'ROMAN JUSTIMIANO', 'DAVILA LULIMACHE', 'Malvinas', '983442618', '', '1994-12-02', 'masculino', 'MONO'),
(56, 1, '46177880', 'JOSELITO', 'IRIGOIN CARRASCO', 'Malvinas', '', '', '1994-12-02', 'masculino', 'JOTA'),
(57, 1, '27379589', 'LUIS REYES', 'CARRASCO CARRERO', 'Malvinas', '', '', '1994-12-02', 'masculino', 'PAPÁ ALEX'),
(58, 1, '45317789', 'ATILANO', 'CHACHAPOYAS LULIMACHE', 'Malvinas', '936377090', '', '1994-12-02', 'masculino', 'ATILANO'),
(59, 1, '72272528', 'NILVER MARINO', 'LULIMACHE BURGA', 'Malvinas', '', '', '1994-12-02', 'masculino', 'NILVER'),
(60, 1, '40565137', 'GEITSEN DIDI', 'ENCALADA TAFUR', 'Malvinas', '938578845', '', '1994-12-02', 'masculino', 'GEITSEN'),
(61, 1, '46688464', 'VILI', 'MONSALVE VASQUEZ', 'Malvinas', '996242711', '', '1994-12-02', 'masculino', 'VILI'),
(62, 1, '27284275', 'MARIA ROJANA', 'BENAVIDES TARRILLO', 'Malvinas', '', '', '1994-12-02', 'femenino', 'ESPOSA MONITO'),
(63, 1, '48745179', 'HERNAN', 'BARBOZA ACUÑA', '', '', '', '1994-12-02', 'masculino', 'HERNAN'),
(64, 1, '44694956', 'DANIEL', 'MESTANZA OLIVERA', 'Malvinas', '', '', '1994-12-02', 'masculino', 'OPERADOR CHAVEZ'),
(65, 3, '20610593489', 'AGRO INVERSIONES N & S EMPRESA INDIVIDUAL DE RESPONSABILIDAD LIMITADA', '', 'AV. MIRAFLORES MZ. 379 LT. 1C A.H. JOSE OLAYA, UCAYALI - CORONEL PORTILLO - CALLERIA', '960207650', '', '1994-12-02', 'masculino', 'MELVIN NICODEMOS'),
(66, 1, '43135078', 'RONALD HAMILCAR', 'SAMAME QUISPE', '', '930525171', '', '1994-12-02', 'masculino', 'ÑATO'),
(67, 1, '27427686', 'EDILBERTO', 'IRIGOIN BUSTAMANTE', 'Malvinas', '946358058', '', '1994-12-02', 'masculino', 'MUDITOS'),
(68, 1, '48051644', 'JHONY', 'ROJAS TRAUCO', 'Malvinas', '934026484', '', '1994-12-02', 'masculino', 'JHONY'),
(69, 1, '41137440', 'SEGUNDO ALCIDES', 'BARBOZA NUÑEZ', 'Malvinas', '', '', '1994-12-02', 'masculino', 'SEGUNDO'),
(70, 1, '80315761', 'SECUNDINO', 'VALDIVIA CRUZ', 'Malvinas', '', '', '1994-12-02', 'masculino', 'ALMA'),
(71, 1, '27378127', 'MANUEL REINERIO', 'QUIROZ CARRASCO', 'Malvinas', '924320299', '', '1994-12-02', 'masculino', 'SHAYO'),
(72, 1, '01056552', 'HUMBERTO', 'ALVAREZ CARRION', 'Malvinas', '', '', '1994-12-02', 'masculino', 'ALVARES'),
(73, 1, '80322589', 'ALEJANDRO', 'TRAUCO MAGALLAN', 'Malvinas', '922432835', '', '1994-12-02', 'masculino', 'PEJE'),
(74, 1, '33569407', 'LUSMAN', 'ILATOMA SANCHEZ', 'Malvinas', '952934862', '', '1994-12-02', 'masculino', 'GUZMAN'),
(75, 1, '27379781', 'ANICETO', 'LULIQUIZ CARRASCO', 'Malvinas', '926859819', '', '1994-12-02', 'masculino', 'ANICETO'),
(76, 1, '01033571', 'RAMOS', 'CALVA BUSTAMANTE', 'Malvinas', '', '', '1994-12-02', 'masculino', 'CABUYAS'),
(77, 1, '33585720', 'DOMISIANO', 'YLATOMA SANCHEZ', '', '', '', '1994-12-02', 'masculino', 'TIMOLINA'),
(78, 1, '47238196', 'DERMELI', 'YLATOMA RAFAEL', 'Malvinas', '922869451', '', '1994-12-02', 'masculino', 'VIEJO'),
(79, 1, '46516633', 'EDWIN JHONY', 'TERRONES CUBAS', 'Malvinas', '', '', '1994-12-02', 'masculino', 'TERRONES'),
(80, 1, '27398080', 'VIDEIRO', 'MALDONADO IDROGO', 'Malvinas', '', '', '1994-12-02', 'masculino', 'VIDEIRO'),
(81, 1, '63473706', 'TEOFILO', 'RODRIGO VITON', 'Malvinas', '970638249', '', '1994-12-02', 'masculino', 'HERMANO HEINER'),
(82, 1, '43678284', 'DONALDO', 'PEREZ OLIVERA', 'Malvinas', '', '', '1994-12-02', 'masculino', 'NANDO'),
(83, 1, '73492228', 'JOSE ALEX', 'CARRASCO LULIMACHE', 'Malvinas', '', '', '1994-12-02', 'masculino', 'JOSE'),
(84, 1, '44353261', 'MOISES', 'SAAVEDRA TERRONES', 'Malvinas', '', '', '1994-12-02', 'masculino', 'MOSHO'),
(85, 1, '46173096', 'EDWIN NILSON', 'CABRERA MEDINA', 'Malvinas', '', '', '1994-12-02', 'masculino', 'EDWIN'),
(86, 1, '76910332', 'NEYSER FERNANDO', 'PEÑA CASTILLO', 'Malvinas', '', '', '1994-12-02', 'masculino', 'NEYRSE'),
(87, 1, '27735712', 'JUAN', 'VASQUEZ CABANILLAS', 'Malvinas', '', '', '1994-12-02', 'masculino', 'BOA'),
(88, 1, '70056562', 'JOSUE DANIEL', 'MAS DELGADO', 'Malvinas', '', '', '1994-12-02', 'masculino', 'JOSEU'),
(89, 1, '01153986', 'WILMER SAUL', 'LULIMACHE BURGA', 'Malvinas', '994361884', '', '1994-12-02', 'masculino', 'WILMER'),
(90, 1, '27413575', 'NICOLAS JUVENAL', 'VASQUEZ MARTINEZ', 'Malvinas', '', '', '1994-12-02', 'masculino', 'JUVENAL VASQUEZ'),
(91, 3, '10010421760', 'MAS CULQUI GABRIEL', '', 'Malvinas', '', '', '1994-12-02', 'masculino', 'MAS'),
(92, 1, '45720425', 'EDWIN', 'MELENDEZ ESPICHAN', 'Malvinas', '', '', '1994-12-02', 'masculino', 'EDWIN'),
(93, 1, '76630705', 'WILDER OMAR', 'CRUZ CARRASCO', 'Malvinas', '', '', '1994-12-02', 'masculino', 'PRIMO JOTA'),
(94, 1, '78112207', 'LEVI', 'ALVARADO CARRASCO', 'Malvinas', '918807093', '', '1994-12-02', 'masculino', 'DAVID'),
(95, 1, '01045475', 'SANTOS PEDRO', 'SANTA CRUZ QUIROZ', '', '', '', '1994-12-03', 'masculino', ''),
(96, 3, '20602912672', 'MULTISERVICIOS B.Q E.I.R.L.', 'Multiservicios ', 'JR. 25 DE MARZO MZ. 16 LT. 09 A.H. NUEVO LURIN, LIMA - LIMA - LURIN', '912897332', 'soyner.coronel@gmail.com', '2024-12-04', 'masculino', NULL),
(97, 1, '80518215', 'HUBERT', 'TINEO TORRES', 'MALVINAS', '923605687', '', '1994-12-13', 'masculino', 'HUBERT'),
(98, 1, '47937779', 'KELY ELIZABETH', 'CIEZA DIAZ', 'Las Malvinas', '', '', '1994-12-16', 'femenino', 'Kely'),
(99, 3, '10744109766', 'FERREIRA CRUZADO CESIA NOEMI', 'MULTISERVICIOS CESIA', 'AV. CURIMANA MZA. 24 LOTE. 01D ', '', '', '2025-01-02', 'masculino', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_promocion`
--

CREATE TABLE `tb_promocion` (
  `id_promocion` int(11) NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(500) NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio` decimal(18,2) DEFAULT 0.00,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `src_imagen` varchar(500) DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT '1'
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_proveedor`
--

CREATE TABLE `tb_proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `id_persona` bigint(20) UNSIGNED NOT NULL,
  `estado` char(1) NOT NULL DEFAULT '1',
  `src_imagen` varchar(300) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_proveedor`
--

INSERT INTO `tb_proveedor` (`id_proveedor`, `id_persona`, `estado`, `src_imagen`) VALUES
(1, 96, '1', 'resources/global/images/sin_imagen.png'),
(2, 99, '1', 'resources/global/images/sin_imagen.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_proveedor_observaciones`
--

CREATE TABLE `tb_proveedor_observaciones` (
  `id_detalle` bigint(20) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` char(1) DEFAULT '1'
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_servicio`
--

CREATE TABLE `tb_servicio` (
  `id_servicio` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_servicio` bigint(20) UNSIGNED NOT NULL,
  `id_maquinaria` bigint(20) UNSIGNED NOT NULL,
  `id_unidad_medida` int(11) DEFAULT NULL,
  `name_servicio` varchar(100) NOT NULL,
  `descripcion_breve` varchar(1000) DEFAULT NULL,
  `descripcion_larga` varchar(1000) DEFAULT NULL,
  `id_moneda` int(11) NOT NULL DEFAULT 1,
  `signo_moneda` varchar(10) DEFAULT NULL,
  `precio` decimal(8,2) NOT NULL DEFAULT 0.00,
  `flag_igv` char(1) DEFAULT '1',
  `src_imagen` varchar(1000) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_servicio`
--

INSERT INTO `tb_servicio` (`id_servicio`, `id_tipo_servicio`, `id_maquinaria`, `id_unidad_medida`, `name_servicio`, `descripcion_breve`, `descripcion_larga`, `id_moneda`, `signo_moneda`, `precio`, `flag_igv`, `src_imagen`, `estado`) VALUES
(1, 4, 1, 5, 'Cosecha de Arroz', '', 'edssdds', 1, 'S/', 500.00, '1', 'resources/global/images/sin_imagen.png', 'activo'),
(2, 4, 2, 5, 'Cosecha de Arroz', '', '', 1, 'S/', 500.00, '1', 'resources/global/images/sin_imagen.png', 'activo'),
(3, 4, 3, 5, 'Cosecha de Arroz', '', '', 1, 'S/', 500.00, '1', 'resources/global/images/sin_imagen.png', 'activo'),
(4, 4, 4, 4, 'Cosecha de Arroz', '', '', 1, 'S/', 500.00, '1', 'resources/global/images/sin_imagen.png', 'activo'),
(5, 4, 5, 5, 'Cosecha de Arroz', '', '', 1, 'S/', 500.00, '1', 'resources/global/images/sin_imagen.png', 'activo'),
(6, 4, 6, 5, 'Cosecha de Arroz', '', '', 1, 'S/', 500.00, '1', 'resources/global/images/sin_imagen.png', 'activo'),
(7, 4, 7, 5, 'Cosecha de Arroz', '', '', 1, 'S/', 500.00, '1', 'resources/global/images/sin_imagen.png', 'activo'),
(8, 5, 8, 4, 'Lampon', '', '', 1, 'S/', 170.00, '1', 'resources/global/images/sin_imagen.png', 'activo'),
(9, 5, 8, 4, 'Rastra Liviana', '', '', 1, 'S/', 170.00, '1', 'resources/global/images/sin_imagen.png', 'activo'),
(10, 5, 8, 4, 'Rastra Pesada', '', '', 1, 'S/', 170.00, '1', 'resources/global/images/sin_imagen.png', 'activo'),
(11, 5, 8, 4, 'Rufa', '', '', 1, 'S/', 170.00, '1', 'resources/global/images/sin_imagen.png', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_sucursal`
--

CREATE TABLE `tb_sucursal` (
  `id_sucursal` int(11) NOT NULL,
  `id_empresa` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(300) NOT NULL,
  `cod_ubigeo` varchar(10) DEFAULT NULL,
  `direccion` varchar(1000) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `mapa` varchar(1000) DEFAULT NULL,
  `estado` char(1) DEFAULT '1',
  `token` varchar(1000) DEFAULT NULL,
  `ruta` varchar(1000) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_sucursal`
--

INSERT INTO `tb_sucursal` (`id_sucursal`, `id_empresa`, `nombre`, `cod_ubigeo`, `direccion`, `telefono`, `mapa`, `estado`, `token`, `ruta`) VALUES
(1, 1, 'LOCAL PRINCIPAL', '150302', 'JR. TOMÁS GUIDO N 239 - OF. 302 - LINCE', '98765432', '', '1', 'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc', 'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_tipo_cambio`
--

CREATE TABLE `tb_tipo_cambio` (
  `id` int(11) NOT NULL,
  `id_moneda` int(11) NOT NULL,
  `name_user` varchar(300) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `tipo_cambio` decimal(18,3) NOT NULL
) ;

--
-- Volcado de datos para la tabla `tb_tipo_cambio`
--

INSERT INTO `tb_tipo_cambio` (`id`, `id_moneda`, `name_user`, `fecha`, `tipo_cambio`) VALUES
(1, 2, 'zhaul', '2019-10-16 11:33:38', 3.350),
(3, 2, 'zhaul', '2024-11-22 12:53:17', 3.500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_tipo_cosecha`
--

CREATE TABLE `tb_tipo_cosecha` (
  `id_tipo_cosecha` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_tipo_cosecha`
--

INSERT INTO `tb_tipo_cosecha` (`id_tipo_cosecha`, `descripcion`, `estado`) VALUES
(1, 'Normal', 'activo'),
(2, 'Cabrilla', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_tipo_mascota`
--

CREATE TABLE `tb_tipo_mascota` (
  `id_tipo_mascota` bigint(20) UNSIGNED NOT NULL,
  `name_tipo` varchar(50) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_tipo_mascota`
--

INSERT INTO `tb_tipo_mascota` (`id_tipo_mascota`, `name_tipo`, `estado`) VALUES
(1, 'Perro', 'activo'),
(2, 'Gato', 'activo'),
(3, 'Conejo', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_tipo_medicamento`
--

CREATE TABLE `tb_tipo_medicamento` (
  `id_tipo_medicamento` bigint(20) UNSIGNED NOT NULL,
  `name_tipo` varchar(50) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_tipo_medicamento`
--

INSERT INTO `tb_tipo_medicamento` (`id_tipo_medicamento`, `name_tipo`, `estado`) VALUES
(1, 'Antibióticos', 'activo'),
(2, 'Sulfonamidas', 'activo'),
(3, 'Tetraciclinas', 'activo'),
(4, 'Antiparasitarios', 'activo'),
(5, 'Anticoagulantes', 'activo'),
(6, 'Antiparasitarios', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_tipo_servicio`
--

CREATE TABLE `tb_tipo_servicio` (
  `id_tipo_servicio` bigint(20) UNSIGNED NOT NULL,
  `name_tipo` varchar(50) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_tipo_servicio`
--

INSERT INTO `tb_tipo_servicio` (`id_tipo_servicio`, `name_tipo`, `estado`) VALUES
(4, 'Cosechadoras', 'activo'),
(5, 'Tractores', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_trabajador`
--

CREATE TABLE `tb_trabajador` (
  `id_trabajador` bigint(20) UNSIGNED NOT NULL,
  `id_persona` bigint(20) UNSIGNED NOT NULL,
  `id_grupo` bigint(20) UNSIGNED NOT NULL,
  `id_especialidad` bigint(20) UNSIGNED NOT NULL,
  `name_user` varchar(100) DEFAULT NULL,
  `pass_user` varchar(500) DEFAULT NULL,
  `cod_recuperacion` varchar(500) DEFAULT NULL,
  `fecha_activacion` date DEFAULT NULL,
  `fecha_recuperacion` date DEFAULT NULL,
  `src_imagen` varchar(500) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `flag_medico` tinyint(1) NOT NULL DEFAULT 0,
  `link_facebook` varchar(500) DEFAULT NULL,
  `link_instagram` varchar(500) DEFAULT NULL,
  `link_twitter` varchar(500) DEFAULT NULL,
  `descripcion` varchar(1000) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_trabajador`
--

INSERT INTO `tb_trabajador` (`id_trabajador`, `id_persona`, `id_grupo`, `id_especialidad`, `name_user`, `pass_user`, `cod_recuperacion`, `fecha_activacion`, `fecha_recuperacion`, `src_imagen`, `estado`, `flag_medico`, `link_facebook`, `link_instagram`, `link_twitter`, `descripcion`) VALUES
(1, 1, 1, 1, 'zhaul', 'e67f455a5414e8f58488ae39fe9e7f76', NULL, '2019-06-10', NULL, 'resources/global/images/persons/zhaul-1571241993.png', 'activo', 0, '#', '#', '#', ''),
(4, 29, 1, 2, 'Soyner', 'ac96cce270a60721f905f618e7a18634', NULL, '2024-12-01', NULL, 'resources/global/images/sin_imagen.png', 'activo', 0, '', '', '', ''),
(5, 30, 1, 2, 'Eluz', '4c45da22ad9d69c134e4eb42f8c586a3', NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo', 0, '', '', '', ''),
(6, 63, 1, 2, 'Hernan', 'bd8209e366390024cf19a53e2f810265', NULL, '2024-12-02', NULL, 'resources/global/images/persons/Hernan-1733931492.png', 'activo', 0, '', '', '', ''),
(7, 94, 5, 1, 'DAVID', '63014a90498e27861f354a664a325792', NULL, '2024-12-02', NULL, 'resources/global/images/sin_imagen.png', 'activo', 1, '', '', '', ''),
(8, 95, 2, 1, 'PEDRO', 'de2a54ed04545546551070be3260bdea', NULL, '2024-12-03', NULL, 'resources/global/images/sin_imagen.png', 'activo', 1, '', '', '', ''),
(9, 98, 6, 1, 'Kely', 'b1cbfdda34638b84d39e43bc278482b6', NULL, '2024-12-16', NULL, 'resources/global/images/sin_imagen.png', 'activo', 0, '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_trabajador_servicio`
--

CREATE TABLE `tb_trabajador_servicio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_servicio` bigint(20) UNSIGNED NOT NULL,
  `id_trabajador` bigint(20) UNSIGNED NOT NULL
) ;

--
-- Volcado de datos para la tabla `tb_trabajador_servicio`
--

INSERT INTO `tb_trabajador_servicio` (`id`, `id_servicio`, `id_trabajador`) VALUES
(29, 8, 8),
(30, 9, 8),
(31, 10, 8),
(32, 11, 8),
(40, 4, 7),
(41, 1, 7),
(42, 2, 7),
(43, 3, 7),
(44, 5, 7),
(45, 6, 7),
(46, 7, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_trabajador_sucursal`
--

CREATE TABLE `tb_trabajador_sucursal` (
  `id` bigint(20) NOT NULL,
  `id_trabajador` bigint(20) UNSIGNED DEFAULT NULL,
  `id_sucursal` int(11) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_trabajador_sucursal`
--

INSERT INTO `tb_trabajador_sucursal` (`id`, `id_trabajador`, `id_sucursal`) VALUES
(1, 1, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 8, 1),
(8, 7, 1),
(9, 9, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_unidad_medida`
--

CREATE TABLE `tb_unidad_medida` (
  `id_unidad_medida` int(11) NOT NULL,
  `name_unidad` varchar(200) DEFAULT NULL,
  `cod_sunat` varchar(10) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tb_unidad_medida`
--

INSERT INTO `tb_unidad_medida` (`id_unidad_medida`, `name_unidad`, `cod_sunat`, `estado`) VALUES
(1, 'UNIDADES', 'NIU', '1'),
(4, 'HORAS', 'HR', '1'),
(5, 'HECTÁREAS', 'HZ', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_vacuna`
--

CREATE TABLE `tb_vacuna` (
  `id_vacuna` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_mascota` bigint(20) UNSIGNED NOT NULL,
  `name_vacuna` varchar(150) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `edad_minima` int(11) NOT NULL DEFAULT 1,
  `edad_maxima` int(11) DEFAULT NULL,
  `tipo` char(1) DEFAULT '0',
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ;

--
-- Volcado de datos para la tabla `tb_vacuna`
--

INSERT INTO `tb_vacuna` (`id_vacuna`, `id_tipo_mascota`, `name_vacuna`, `descripcion`, `edad_minima`, `edad_maxima`, `tipo`, `estado`) VALUES
(1, 1, 'Primera Vacuna	', 'Esta es una descripción de la vacuna	', 12, 20, '1', 'activo'),
(2, 1, 'Segunda Vacuna', 'Esta es una descripción de la vacuna.', 30, 40, '1', 'activo'),
(3, 1, 'Tercera Vacuna', 'Esta es una descripción de la vacuna.', 70, 80, '1', 'activo'),
(4, 1, 'Cuarta Vacuna', 'Esta es una descripción de la vacuna', 100, 110, '1', 'activo'),
(5, 2, 'Primera Vacuna', 'Esta es una descripción de la vacuna.', 10, 20, '1', 'activo'),
(6, 2, 'Segunda Vacuna', 'Esta es una descripción de la vacuna.', 40, 50, '1', 'activo'),
(7, 2, 'Tercera Vacuna', 'Esta es una descripción de la vacuna.', 70, 80, '1', 'activo'),
(8, 2, 'Cuarta Vacuna', 'Esta es una descripción de la vacuna.', 120, 140, '1', 'activo'),
(9, 3, 'Primera Vacuna', 'Esta es una descripción de la vacuna.', 10, 20, '1', 'activo'),
(10, 3, 'Segunda Vacuna', 'Esta es una descripción de la vacuna.', 40, 50, '1', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_venta`
--

CREATE TABLE `tb_venta` (
  `id_venta` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_trabajador` bigint(20) UNSIGNED NOT NULL,
  `id_documento_venta` int(11) NOT NULL,
  `name_documento_venta` varchar(100) NOT NULL,
  `codigo_documento_venta` varchar(4) NOT NULL,
  `serie` varchar(4) NOT NULL,
  `correlativo` varchar(12) NOT NULL,
  `id_documento_cliente` bigint(20) UNSIGNED NOT NULL,
  `name_documento_cliente` varchar(100) NOT NULL,
  `codigo_documento_cliente` varchar(4) NOT NULL,
  `numero_documento_cliente` varchar(30) NOT NULL,
  `id_forma_pago` int(11) NOT NULL,
  `codigo_forma_pago` varchar(4) NOT NULL,
  `name_forma_pago` varchar(100) NOT NULL,
  `cliente` varchar(500) NOT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
  `descuento_total` decimal(18,2) DEFAULT 0.00,
  `sub_total` decimal(18,2) NOT NULL,
  `igv` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT '1',
  `pdf` varchar(500) DEFAULT NULL,
  `xml` varchar(500) DEFAULT NULL,
  `cdr` varchar(500) DEFAULT NULL,
  `mensaje_sunat` varchar(1000) DEFAULT NULL,
  `ruta` varchar(500) DEFAULT NULL,
  `token` varchar(500) DEFAULT NULL,
  `flag_doc_interno` char(1) NOT NULL DEFAULT '1',
  `monto_recibido` decimal(18,2) DEFAULT NULL,
  `vuelto` decimal(18,2) DEFAULT NULL,
  `id_moneda` int(11) NOT NULL,
  `codigo_moneda` varchar(4) NOT NULL,
  `signo_moneda` varchar(10) DEFAULT NULL,
  `abreviatura_moneda` varchar(10) DEFAULT NULL,
  `signo_moneda_cambio` varchar(10) NOT NULL DEFAULT 'S/ ',
  `monto_tipo_cambio` decimal(18,2) DEFAULT NULL,
  `observaciones` varchar(1000) DEFAULT NULL,
  `flag_enviado` char(1) DEFAULT '1'
) ;

--
-- Volcado de datos para la tabla `tb_venta`
--

INSERT INTO `tb_venta` (`id_venta`, `id_sucursal`, `id_trabajador`, `id_documento_venta`, `name_documento_venta`, `codigo_documento_venta`, `serie`, `correlativo`, `id_documento_cliente`, `name_documento_cliente`, `codigo_documento_cliente`, `numero_documento_cliente`, `id_forma_pago`, `codigo_forma_pago`, `name_forma_pago`, `cliente`, `direccion`, `telefono`, `correo`, `fecha`, `fecha_vencimiento`, `descuento_total`, `sub_total`, `igv`, `total`, `estado`, `pdf`, `xml`, `cdr`, `mensaje_sunat`, `ruta`, `token`, `flag_doc_interno`, `monto_recibido`, `vuelto`, `id_moneda`, `codigo_moneda`, `signo_moneda`, `abreviatura_moneda`, `signo_moneda_cambio`, `monto_tipo_cambio`, `observaciones`, `flag_enviado`) VALUES
(1, 1, 1, 3, 'TICKET DE SALIDA', '-', 'TIK1', '1', 1, 'DNI', '1', '77229532', 1, '01', 'EFECTIVO', 'ZHAUL ALBERTO VALDERA VIDAURRE', '', '', '', '2024-12-18 00:00:00', NULL, 2.00, 2.00, 0.36, 2.36, '3', 'NOK', 'NOK', 'NOK', '', 'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4', 'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc', '1', 2.36, 0.00, 1, '1', 'S/', 'PEN', 'S/ ', 1.00, NULL, '1'),
(2, 1, 9, 3, 'TICKET DE SALIDA', '-', 'TIK1', '2', 1, 'DNI', '1', '76531247', 1, '01', 'EFECTIVO', 'SOYNER LUIS CORONEL QUINTANA', '', '', '', '2024-12-18 00:00:00', NULL, 1.00, 1.00, 0.18, 1.18, '3', 'NOK', 'NOK', 'NOK', '', 'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4', 'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc', '1', 1.18, 0.00, 1, '1', 'S/', 'PEN', 'S/ ', 1.00, NULL, '1'),
(3, 1, 9, 3, 'TICKET DE SALIDA', '-', 'TIK1', '3', 1, 'DNI', '1', '76531247', 1, '01', 'EFECTIVO', 'SOYNER LUIS CORONEL QUINTANA', '', '', '', '2024-12-18 00:00:00', NULL, 4.00, 4.00, 0.72, 4.72, '3', 'NOK', 'NOK', 'NOK', '', 'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4', 'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc', '1', 4.72, 0.00, 1, '1', 'S/', 'PEN', 'S/ ', 1.00, NULL, '1'),
(4, 1, 9, 3, 'TICKET DE SALIDA', '-', 'TIK1', '4', 1, 'DNI', '1', '48745179', 1, '01', 'EFECTIVO', 'HERNAN BARBOZA ACUÑA', '', '', '', '2024-12-18 00:00:00', NULL, 1.00, 1.00, 0.18, 1.18, '3', 'NOK', 'NOK', 'NOK', '', 'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4', 'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc', '1', 1.18, 0.00, 1, '1', 'S/', 'PEN', 'S/ ', 1.00, NULL, '1'),
(5, 1, 9, 3, 'TICKET DE SALIDA', '-', 'TIK1', '5', 1, 'DNI', '1', '48745179', 1, '01', 'EFECTIVO', 'HERNAN BARBOZA ACUÑA', '', '', '', '2024-12-19 00:00:00', NULL, 4.00, 4.00, 0.72, 4.72, '3', 'NOK', 'NOK', 'NOK', '', 'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4', 'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc', '1', 4.72, 0.00, 1, '1', 'S/', 'PEN', 'S/ ', 1.00, NULL, '1'),
(6, 1, 9, 3, 'TICKET DE SALIDA', '-', 'TIK1', '6', 1, 'DNI', '1', '48745179', 1, '01', 'EFECTIVO', 'HERNAN BARBOZA ACUÑA', '', '', '', '2024-12-19 00:00:00', NULL, 1.00, 1.00, 0.18, 1.18, '3', 'NOK', 'NOK', 'NOK', '', 'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4', 'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc', '1', 1.18, 0.00, 1, '1', 'S/', 'PEN', 'S/ ', 1.00, NULL, '1'),
(7, 1, 6, 3, 'TICKET DE SALIDA', '-', 'TIK1', '7', 1, 'DNI', '1', '01045475', 1, '01', 'EFECTIVO', 'SANTOS PEDRO SANTA CRUZ QUIROZ', '', '', '', '2024-12-23 00:00:00', NULL, 1.00, 1.00, 0.18, 1.18, '3', 'NOK', 'NOK', 'NOK', '', 'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4', 'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc', '1', 1.18, 0.00, 1, '1', 'S/', 'PEN', 'S/ ', 1.00, NULL, '1'),
(8, 1, 6, 3, 'TICKET DE SALIDA', '-', 'TIK1', '8', 1, 'DNI', '1', '01045475', 1, '01', 'EFECTIVO', 'SANTOS PEDRO SANTA CRUZ QUIROZ', '', '', '', '2024-12-23 00:00:00', NULL, 1.00, 1.00, 0.18, 1.18, '2', 'NOK', 'NOK', 'NOK', '', 'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4', 'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc', '1', 1.18, 0.00, 1, '1', 'S/', 'PEN', 'S/ ', 1.00, NULL, '1'),
(9, 1, 6, 3, 'TICKET DE SALIDA', '-', 'TIK1', '9', 1, 'DNI', '1', '48745179', 1, '01', 'EFECTIVO', 'HERNAN BARBOZA ACUÑA', '', '', '', '2025-01-02 00:00:00', NULL, 31.00, 31.00, 5.58, 36.58, '3', 'NOK', 'NOK', 'NOK', '', 'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4', 'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc', '1', 36.58, 0.00, 1, '1', 'S/', 'PEN', 'S/ ', 1.00, NULL, '1');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_clientes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_clientes` (
`id_cliente` bigint(20) unsigned
,`id_persona` bigint(20) unsigned
,`src_imagen` varchar(500)
,`estado` enum('activo','inactivo')
,`id_documento` bigint(20) unsigned
,`num_documento` varchar(30)
,`nombres_cliente` varchar(100)
,`apellidos_cliente` varchar(100)
,`direccion_cliente` varchar(150)
,`telefono_cliente` varchar(30)
,`correo_cliente` varchar(150)
,`fecha_nacimiento_cliente` date
,`sexo_cliente` enum('masculino','femenino')
,`name_documento` varchar(100)
,`apodo` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_mascotas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_mascotas` (
`id_mascota` bigint(20) unsigned
,`id_cliente` bigint(20) unsigned
,`id_tipo_mascota` bigint(20) unsigned
,`nombre` varchar(100)
,`raza` varchar(50)
,`color` varchar(50)
,`peso` varchar(50)
,`sexo` enum('hembra','macho')
,`fecha_nacimiento` date
,`observaciones` varchar(1000)
,`estado` enum('activo','inactivo')
,`src_imagen` varchar(150)
,`name_tipo` varchar(50)
,`name_documento` varchar(100)
,`id_documento` bigint(20) unsigned
,`num_documento` varchar(30)
,`nombres` varchar(100)
,`apellidos` varchar(100)
,`direccion` varchar(150)
,`telefono` varchar(30)
,`correo` varchar(150)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_operadores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_operadores` (
`id_operador` bigint(20) unsigned
,`id_persona_operador` bigint(20) unsigned
,`estado_operador` enum('activo','inactivo')
,`id_documento_operador` bigint(20) unsigned
,`num_documento_operador` varchar(30)
,`nombre_operador` varchar(201)
,`direccion_operador` varchar(150)
,`telefono_operador` varchar(30)
,`correo_operador` varchar(150)
,`fecha_nacimiento_operador` date
,`sexo_operador` enum('masculino','femenino')
,`src_imagen_operador` varchar(500)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_orden_compra`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_orden_compra` (
`id_orden_compra` int(11)
,`id_proveedor` int(11)
,`nombre_proveedor` varchar(201)
,`src_imagen_proveedor` varchar(300)
,`id_metodo_envio` int(11)
,`fecha_orden` datetime /* mariadb-5.3 */
,`fecha_entrega` datetime /* mariadb-5.3 */
,`observaciones` varchar(500)
,`id_moneda` int(11)
,`id_sucursal` int(11)
,`estado_int` char(1)
,`estado` varchar(14)
,`cod_producto` int(11)
,`name_tabla` varchar(100)
,`name_producto` varchar(100)
,`stock` int(11)
,`precio_unitario` decimal(18,2)
,`cantidad_solicitada` int(11)
,`notas` varchar(237)
,`total` decimal(28,2)
,`src_imagen_producto` varchar(150)
,`cantidad_ingresada` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_productos_agotados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_productos_agotados` (
`descripcion_producto` varchar(100)
,`stock` int(11)
,`stock_minimo` int(11)
,`nombre_sucursal` varchar(300)
,`name_unidad` varchar(10)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_proveedor`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_proveedor` (
`id_proveedor` int(11)
,`id_persona_proveedor` bigint(20) unsigned
,`estado_proveedor` char(1)
,`id_documento_proveedor` bigint(20) unsigned
,`num_documento_proveedor` varchar(30)
,`nombre_proveedor` varchar(201)
,`direccion_proveedor` varchar(150)
,`telefono_proveedor` varchar(30)
,`correo_proveedor` varchar(150)
,`fecha_nacimiento_proveedor` date
,`sexo_proveedor` enum('masculino','femenino')
,`src_imagen_proveedor` varchar(300)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_trabajadores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_trabajadores` (
`id_trabajador` bigint(20) unsigned
,`id_persona` bigint(20) unsigned
,`id_grupo` bigint(20) unsigned
,`id_especialidad` bigint(20) unsigned
,`name_user` varchar(100)
,`pass_user` varchar(500)
,`cod_recuperacion` varchar(500)
,`fecha_activacion` date
,`fecha_recuperacion` date
,`src_imagen` varchar(500)
,`estado` enum('activo','inactivo')
,`flag_medico` tinyint(1)
,`link_facebook` varchar(500)
,`link_instagram` varchar(500)
,`link_twitter` varchar(500)
,`descripcion` varchar(1000)
,`id_documento` bigint(20) unsigned
,`num_documento` varchar(30)
,`nombres_trabajador` varchar(100)
,`apellidos_trabajador` varchar(100)
,`direccion_trabajador` varchar(150)
,`telefono_trabajador` varchar(30)
,`correo_trabajador` varchar(150)
,`fecha_nacimiento_trabajador` date
,`sexo_trabajador` enum('masculino','femenino')
,`name_documento_trabajador` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_clientes`
--
DROP TABLE IF EXISTS `vw_clientes`;

CREATE  VIEW `vw_clientes`  AS SELECT `t`.`id_cliente` AS `id_cliente`, `t`.`id_persona` AS `id_persona`, `t`.`src_imagen` AS `src_imagen`, `t`.`estado` AS `estado`, `p`.`id_documento` AS `id_documento`, `p`.`num_documento` AS `num_documento`, `p`.`nombres` AS `nombres_cliente`, `p`.`apellidos` AS `apellidos_cliente`, `p`.`direccion` AS `direccion_cliente`, `p`.`telefono` AS `telefono_cliente`, `p`.`correo` AS `correo_cliente`, `p`.`fecha_nacimiento` AS `fecha_nacimiento_cliente`, `p`.`sexo` AS `sexo_cliente`, `d`.`name_documento` AS `name_documento`, `p`.`apodo` AS `apodo` FROM ((`tb_cliente` `t` join `tb_persona` `p` on(`p`.`id_persona` = `t`.`id_persona`)) join `tb_documento_identidad` `d` on(`d`.`id_documento` = `p`.`id_documento`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_mascotas`
--
DROP TABLE IF EXISTS `vw_mascotas`;

CREATE  VIEW `vw_mascotas`  AS SELECT `m`.`id_mascota` AS `id_mascota`, `m`.`id_cliente` AS `id_cliente`, `m`.`id_tipo_mascota` AS `id_tipo_mascota`, `m`.`nombre` AS `nombre`, `m`.`raza` AS `raza`, `m`.`color` AS `color`, `m`.`peso` AS `peso`, `m`.`sexo` AS `sexo`, `m`.`fecha_nacimiento` AS `fecha_nacimiento`, `m`.`observaciones` AS `observaciones`, `m`.`estado` AS `estado`, `m`.`src_imagen` AS `src_imagen`, `t`.`name_tipo` AS `name_tipo`, `di`.`name_documento` AS `name_documento`, `p`.`id_documento` AS `id_documento`, `p`.`num_documento` AS `num_documento`, `p`.`nombres` AS `nombres`, `p`.`apellidos` AS `apellidos`, `p`.`direccion` AS `direccion`, `p`.`telefono` AS `telefono`, `p`.`correo` AS `correo` FROM ((((`tb_mascota` `m` join `tb_cliente` `c` on(`c`.`id_cliente` = `m`.`id_cliente`)) join `tb_tipo_mascota` `t` on(`t`.`id_tipo_mascota` = `m`.`id_tipo_mascota`)) join `tb_persona` `p` on(`p`.`id_persona` = `c`.`id_persona`)) join `tb_documento_identidad` `di` on(`di`.`id_documento` = `p`.`id_documento`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_operadores`
--
DROP TABLE IF EXISTS `vw_operadores`;

CREATE  VIEW `vw_operadores`  AS SELECT `o`.`id_operador` AS `id_operador`, `o`.`id_persona` AS `id_persona_operador`, `o`.`estado` AS `estado_operador`, `p`.`id_documento` AS `id_documento_operador`, `p`.`num_documento` AS `num_documento_operador`, concat(`p`.`nombres`,' ',`p`.`apellidos`) AS `nombre_operador`, `p`.`direccion` AS `direccion_operador`, `p`.`telefono` AS `telefono_operador`, `p`.`correo` AS `correo_operador`, `p`.`fecha_nacimiento` AS `fecha_nacimiento_operador`, `p`.`sexo` AS `sexo_operador`, `o`.`src_imagen` AS `src_imagen_operador` FROM (`tb_operador` `o` join `tb_persona` `p` on(`o`.`id_persona` = `p`.`id_persona`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_orden_compra`
--
DROP TABLE IF EXISTS `vw_orden_compra`;

CREATE  VIEW `vw_orden_compra`  AS SELECT `o`.`id_orden_compra` AS `id_orden_compra`, `o`.`id_proveedor` AS `id_proveedor`, `pr`.`nombre_proveedor` AS `nombre_proveedor`, `pr`.`src_imagen_proveedor` AS `src_imagen_proveedor`, `o`.`id_metodo_envio` AS `id_metodo_envio`, `o`.`fecha_orden` AS `fecha_orden`, `o`.`fecha_entrega` AS `fecha_entrega`, `o`.`observaciones` AS `observaciones`, `o`.`id_moneda` AS `id_moneda`, `o`.`id_sucursal` AS `id_sucursal`, `o`.`estado` AS `estado_int`, CASE WHEN `o`.`estado` = '0' THEN 'EN proceso ...' WHEN `o`.`estado` = '1' THEN 'EN espera ...' WHEN `o`.`estado` = '2' THEN 'Recibido' WHEN `o`.`estado` = '3' THEN 'Anulado' END AS `estado`, `dc`.`cod_producto` AS `cod_producto`, `dc`.`name_tabla` AS `name_tabla`, `pro`.`name_accesorio` AS `name_producto`, `pro`.`stock` AS `stock`, `dc`.`precio_unitario` AS `precio_unitario`, `dc`.`cantidad_solicitada` AS `cantidad_solicitada`, CASE WHEN `dc`.`cantidad_ingresada` > 0 THEN concat('Ingresaron ',`dc`.`cantidad_ingresada`,' de ',`dc`.`cantidad_solicitada`,`dc`.`notas`) WHEN `dc`.`cantidad_ingresada` = 0 AND `o`.`estado` = '1' THEN concat('Ingresaron ',`dc`.`cantidad_ingresada`,' de ',`dc`.`cantidad_solicitada`,`dc`.`notas`) ELSE `dc`.`notas` END AS `notas`, `dc`.`precio_unitario`* `dc`.`cantidad_solicitada` AS `total`, `pro`.`src_imagen` AS `src_imagen_producto`, `dc`.`cantidad_ingresada` AS `cantidad_ingresada` FROM (((`tb_orden_compra` `o` join `vw_proveedor` `pr` on(`pr`.`id_proveedor` = `o`.`id_proveedor`)) join `tb_detalle_compra` `dc` on(`dc`.`id_orden_compra` = `o`.`id_orden_compra` and `dc`.`name_tabla` = 'accesorio')) join `tb_accesorio` `pro` on(`pro`.`id_accesorio` = `dc`.`cod_producto`))union select `o`.`id_orden_compra` AS `id_orden_compra`,`o`.`id_proveedor` AS `id_proveedor`,`pr`.`nombre_proveedor` AS `nombre_proveedor`,`pr`.`src_imagen_proveedor` AS `src_imagen_proveedor`,`o`.`id_metodo_envio` AS `id_metodo_envio`,`o`.`fecha_orden` AS `fecha_orden`,`o`.`fecha_entrega` AS `fecha_entrega`,`o`.`observaciones` AS `observaciones`,`o`.`id_moneda` AS `id_moneda`,`o`.`id_sucursal` AS `id_sucursal`,`o`.`estado` AS `estado_int`,case when `o`.`estado` = '0' then 'EN proceso ...' when `o`.`estado` = '1' then 'EN espera ...' when `o`.`estado` = '2' then 'Recibido' when `o`.`estado` = '3' then 'Anulado' end AS `estado`,`dc`.`cod_producto` AS `cod_producto`,`dc`.`name_tabla` AS `name_tabla`,`pro`.`name_medicamento` AS `name_producto`,`pro`.`stock` AS `stock`,`dc`.`precio_unitario` AS `precio_unitario`,`dc`.`cantidad_solicitada` AS `cantidad_solicitada`,case when `dc`.`cantidad_ingresada` > 0 then concat('Ingresaron ',`dc`.`cantidad_ingresada`,' de ',`dc`.`cantidad_solicitada`,`dc`.`notas`) when `dc`.`cantidad_ingresada` = 0 and `o`.`estado` = '1' then concat('Ingresaron ',`dc`.`cantidad_ingresada`,' de ',`dc`.`cantidad_solicitada`,`dc`.`notas`) else `dc`.`notas` end AS `notas`,`dc`.`precio_unitario` * `dc`.`cantidad_solicitada` AS `total`,`pro`.`src_imagen` AS `src_imagen_producto`,`dc`.`cantidad_ingresada` AS `cantidad_ingresada` from (((`tb_orden_compra` `o` join `vw_proveedor` `pr` on(`pr`.`id_proveedor` = `o`.`id_proveedor`)) join `tb_detalle_compra` `dc` on(`dc`.`id_orden_compra` = `o`.`id_orden_compra` and `dc`.`name_tabla` = 'medicamento')) join `tb_medicamento` `pro` on(`pro`.`id_medicamento` = `dc`.`cod_producto`))  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_productos_agotados`
--
DROP TABLE IF EXISTS `vw_productos_agotados`;

CREATE  VIEW `vw_productos_agotados`  AS SELECT `m`.`name_medicamento` AS `descripcion_producto`, `m`.`stock` AS `stock`, `m`.`stock_minimo` AS `stock_minimo`, `s`.`nombre` AS `nombre_sucursal`, `u`.`cod_sunat` AS `name_unidad` FROM ((`tb_medicamento` `m` join `tb_sucursal` `s` on(`s`.`id_sucursal` = `m`.`id_sucursal`)) join `tb_unidad_medida` `u` on(`u`.`id_unidad_medida` = `m`.`id_unidad_medida`)) WHERE `m`.`stock_minimo` >= `m`.`stock`union select `a`.`name_accesorio` AS `descripcion_producto`,`a`.`stock` AS `stock`,`a`.`stock_minimo` AS `stock_minimo`,`s`.`nombre` AS `nombre_sucursal`,`u`.`cod_sunat` AS `name_unidad` from ((`tb_accesorio` `a` join `tb_sucursal` `s` on(`s`.`id_sucursal` = `a`.`id_sucursal`)) join `tb_unidad_medida` `u` on(`u`.`id_unidad_medida` = `a`.`id_unidad_medida`)) where `a`.`stock_minimo` >= `a`.`stock`  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_proveedor`
--
DROP TABLE IF EXISTS `vw_proveedor`;

CREATE  VIEW `vw_proveedor`  AS SELECT `pr`.`id_proveedor` AS `id_proveedor`, `pr`.`id_persona` AS `id_persona_proveedor`, `pr`.`estado` AS `estado_proveedor`, `p`.`id_documento` AS `id_documento_proveedor`, `p`.`num_documento` AS `num_documento_proveedor`, concat(`p`.`nombres`,' ',`p`.`apellidos`) AS `nombre_proveedor`, `p`.`direccion` AS `direccion_proveedor`, `p`.`telefono` AS `telefono_proveedor`, `p`.`correo` AS `correo_proveedor`, `p`.`fecha_nacimiento` AS `fecha_nacimiento_proveedor`, `p`.`sexo` AS `sexo_proveedor`, `pr`.`src_imagen` AS `src_imagen_proveedor` FROM (`tb_persona` `p` join `tb_proveedor` `pr` on(`pr`.`id_persona` = `p`.`id_persona`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_trabajadores`
--
DROP TABLE IF EXISTS `vw_trabajadores`;

CREATE  VIEW `vw_trabajadores`  AS SELECT `t`.`id_trabajador` AS `id_trabajador`, `t`.`id_persona` AS `id_persona`, `t`.`id_grupo` AS `id_grupo`, `t`.`id_especialidad` AS `id_especialidad`, `t`.`name_user` AS `name_user`, `t`.`pass_user` AS `pass_user`, `t`.`cod_recuperacion` AS `cod_recuperacion`, `t`.`fecha_activacion` AS `fecha_activacion`, `t`.`fecha_recuperacion` AS `fecha_recuperacion`, `t`.`src_imagen` AS `src_imagen`, `t`.`estado` AS `estado`, `t`.`flag_medico` AS `flag_medico`, `t`.`link_facebook` AS `link_facebook`, `t`.`link_instagram` AS `link_instagram`, `t`.`link_twitter` AS `link_twitter`, `t`.`descripcion` AS `descripcion`, `p`.`id_documento` AS `id_documento`, `p`.`num_documento` AS `num_documento`, `p`.`nombres` AS `nombres_trabajador`, `p`.`apellidos` AS `apellidos_trabajador`, `p`.`direccion` AS `direccion_trabajador`, `p`.`telefono` AS `telefono_trabajador`, `p`.`correo` AS `correo_trabajador`, `p`.`fecha_nacimiento` AS `fecha_nacimiento_trabajador`, `p`.`sexo` AS `sexo_trabajador`, `d`.`name_documento` AS `name_documento_trabajador` FROM ((`tb_trabajador` `t` join `tb_persona` `p` on(`p`.`id_persona` = `t`.`id_persona`)) join `tb_documento_identidad` `d` on(`d`.`id_documento` = `p`.`id_documento`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_accesorio`
--
ALTER TABLE `tb_accesorio`
  ADD PRIMARY KEY (`id_accesorio`),
  ADD KEY `tb_accesorio_id_categoria_foreign` (`id_categoria`),
  ADD KEY `id_sucursal` (`id_sucursal`),
  ADD KEY `id_unidad_medida` (`id_unidad_medida`),
  ADD KEY `id_moneda` (`id_moneda`);

--
-- Indices de la tabla `tb_acceso_opcion`
--
ALTER TABLE `tb_acceso_opcion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_acceso_opcion_id_grupo_foreign` (`id_grupo`),
  ADD KEY `tb_acceso_opcion_id_opcion_foreign` (`id_opcion`);

--
-- Indices de la tabla `tb_categoria_accesorio`
--
ALTER TABLE `tb_categoria_accesorio`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `tb_cita`
--
ALTER TABLE `tb_cita`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `tb_cita_id_trabajador_foreign` (`id_trabajador`),
  ADD KEY `tb_cita_id_servicio_foreign` (`id_servicio`),
  ADD KEY `id_sucursal` (`id_sucursal`);

--
-- Indices de la tabla `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `tb_cliente_name_user_unique` (`name_user`),
  ADD KEY `tb_cliente_id_persona_foreign` (`id_persona`);

--
-- Indices de la tabla `tb_cliente_fundo`
--
ALTER TABLE `tb_cliente_fundo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tb_compra`
--
ALTER TABLE `tb_compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD UNIQUE KEY `id_compra` (`id_compra`),
  ADD KEY `id_sucursal` (`id_sucursal`),
  ADD KEY `id_trabajador` (`id_trabajador`),
  ADD KEY `id_documento_venta` (`id_documento_compra`),
  ADD KEY `id_documento_proveedor` (`id_documento_proveedor`),
  ADD KEY `id_forma_pago` (`id_forma_pago`),
  ADD KEY `id_moneda` (`id_moneda`);

--
-- Indices de la tabla `tb_cronograma`
--
ALTER TABLE `tb_cronograma`
  ADD PRIMARY KEY (`id_cronograma`),
  ADD KEY `fk_servicio_cronograma` (`id_servicio`);

--
-- Indices de la tabla `tb_cronograma_maquinaria`
--
ALTER TABLE `tb_cronograma_maquinaria`
  ADD PRIMARY KEY (`id_cronograma_maquinaria`),
  ADD KEY `fk_cronograma_maquinaria` (`id_cronograma`),
  ADD KEY `fk_maquinaria_cronograma` (`id_maquinaria`);

--
-- Indices de la tabla `tb_cronograma_operadores`
--
ALTER TABLE `tb_cronograma_operadores`
  ADD PRIMARY KEY (`id_cronograma_operador`),
  ADD KEY `fk_cronograma_operador` (`id_cronograma`),
  ADD KEY `fk_trabajador_cronograma` (`id_trabajador`);

--
-- Indices de la tabla `tb_detalle_cita`
--
ALTER TABLE `tb_detalle_cita`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_cita` (`id_cita`);

--
-- Indices de la tabla `tb_detalle_compra`
--
ALTER TABLE `tb_detalle_compra`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `tb_detalle_ingreso`
--
ALTER TABLE `tb_detalle_ingreso`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `tb_detalle_venta`
--
ALTER TABLE `tb_detalle_venta`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `tb_documento_identidad`
--
ALTER TABLE `tb_documento_identidad`
  ADD PRIMARY KEY (`id_documento`);

--
-- Indices de la tabla `tb_documento_venta`
--
ALTER TABLE `tb_documento_venta`
  ADD PRIMARY KEY (`id_documento_venta`),
  ADD KEY `id_sucursal` (`id_sucursal`);

--
-- Indices de la tabla `tb_empresa`
--
ALTER TABLE `tb_empresa`
  ADD PRIMARY KEY (`id_empresa`),
  ADD KEY `tb_empresa_id_documento_num_documento_index` (`id_documento`,`num_documento`),
  ADD KEY `tb_empresa_id_documento_representante_foreign` (`id_documento_representante`);

--
-- Indices de la tabla `tb_especialidad`
--
ALTER TABLE `tb_especialidad`
  ADD PRIMARY KEY (`id_especialidad`);

--
-- Indices de la tabla `tb_forma_pago`
--
ALTER TABLE `tb_forma_pago`
  ADD PRIMARY KEY (`id_forma_pago`);

--
-- Indices de la tabla `tb_galeria`
--
ALTER TABLE `tb_galeria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tb_grupo_usuario`
--
ALTER TABLE `tb_grupo_usuario`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `tb_ingreso`
--
ALTER TABLE `tb_ingreso`
  ADD PRIMARY KEY (`id_ingreso`);

--
-- Indices de la tabla `tb_maquinaria`
--
ALTER TABLE `tb_maquinaria`
  ADD PRIMARY KEY (`id_maquinaria`);

--
-- Indices de la tabla `tb_mascota`
--
ALTER TABLE `tb_mascota`
  ADD PRIMARY KEY (`id_mascota`),
  ADD KEY `tb_mascota_id_cliente_foreign` (`id_cliente`),
  ADD KEY `tb_mascota_id_tipo_mascota_foreign` (`id_tipo_mascota`);

--
-- Indices de la tabla `tb_mascota_vacuna`
--
ALTER TABLE `tb_mascota_vacuna`
  ADD PRIMARY KEY (`id_mascota_vacuna`),
  ADD KEY `tb_mascota_vacuna_id_mascota_foreign` (`id_mascota`),
  ADD KEY `tb_mascota_vacuna_id_vacuna_foreign` (`id_vacuna`);

--
-- Indices de la tabla `tb_medicamento`
--
ALTER TABLE `tb_medicamento`
  ADD PRIMARY KEY (`id_medicamento`),
  ADD KEY `tb_medicamento_id_tipo_medicamento_foreign` (`id_tipo_medicamento`),
  ADD KEY `id_sucursal` (`id_sucursal`),
  ADD KEY `id_unidad_medida` (`id_unidad_medida`),
  ADD KEY `id_moneda` (`id_moneda`);

--
-- Indices de la tabla `tb_metodo_envio`
--
ALTER TABLE `tb_metodo_envio`
  ADD PRIMARY KEY (`id_metodo_envio`);

--
-- Indices de la tabla `tb_moneda`
--
ALTER TABLE `tb_moneda`
  ADD PRIMARY KEY (`id_moneda`);

--
-- Indices de la tabla `tb_opcion`
--
ALTER TABLE `tb_opcion`
  ADD PRIMARY KEY (`id_opcion`);

--
-- Indices de la tabla `tb_orden_compra`
--
ALTER TABLE `tb_orden_compra`
  ADD PRIMARY KEY (`id_orden_compra`);

--
-- Indices de la tabla `tb_pago`
--
ALTER TABLE `tb_pago`
  ADD PRIMARY KEY (`id_pago`);

--
-- Indices de la tabla `tb_pagos_clientes`
--
ALTER TABLE `tb_pagos_clientes`
  ADD PRIMARY KEY (`id_pago_cliente`),
  ADD KEY `fk_cronograma_pago` (`id_cronograma`);

--
-- Indices de la tabla `tb_parametros_generales`
--
ALTER TABLE `tb_parametros_generales`
  ADD PRIMARY KEY (`id_parametro`);

--
-- Indices de la tabla `tb_persona`
--
ALTER TABLE `tb_persona`
  ADD PRIMARY KEY (`id_persona`),
  ADD KEY `tb_persona_id_documento_num_documento_index` (`id_documento`,`num_documento`);

--
-- Indices de la tabla `tb_promocion`
--
ALTER TABLE `tb_promocion`
  ADD PRIMARY KEY (`id_promocion`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `tb_proveedor`
--
ALTER TABLE `tb_proveedor`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `tb_proveedor_observaciones`
--
ALTER TABLE `tb_proveedor_observaciones`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `tb_servicio`
--
ALTER TABLE `tb_servicio`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `fk_tbtiposervicio_servicio` (`id_tipo_servicio`),
  ADD KEY `id_moneda` (`id_moneda`),
  ADD KEY `fk_id_maquinaria` (`id_maquinaria`);

--
-- Indices de la tabla `tb_sucursal`
--
ALTER TABLE `tb_sucursal`
  ADD PRIMARY KEY (`id_sucursal`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tb_tipo_cambio`
--
ALTER TABLE `tb_tipo_cambio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_moneda` (`id_moneda`);

--
-- Indices de la tabla `tb_tipo_mascota`
--
ALTER TABLE `tb_tipo_mascota`
  ADD PRIMARY KEY (`id_tipo_mascota`);

--
-- Indices de la tabla `tb_tipo_medicamento`
--
ALTER TABLE `tb_tipo_medicamento`
  ADD PRIMARY KEY (`id_tipo_medicamento`);

--
-- Indices de la tabla `tb_tipo_servicio`
--
ALTER TABLE `tb_tipo_servicio`
  ADD PRIMARY KEY (`id_tipo_servicio`);

--
-- Indices de la tabla `tb_trabajador`
--
ALTER TABLE `tb_trabajador`
  ADD PRIMARY KEY (`id_trabajador`),
  ADD UNIQUE KEY `tb_trabajador_name_user_unique` (`name_user`),
  ADD KEY `fk_tbpersona_tb_trabajador` (`id_persona`),
  ADD KEY `fktb_trabajador_tbgrupousuario` (`id_grupo`),
  ADD KEY `fktb_trabajador_tbespecialidad` (`id_especialidad`);

--
-- Indices de la tabla `tb_trabajador_servicio`
--
ALTER TABLE `tb_trabajador_servicio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_trabajador_servicio_id_servicio_foreign` (`id_servicio`),
  ADD KEY `tb_trabajador_servicio_id_trabajador_foreign` (`id_trabajador`);

--
-- Indices de la tabla `tb_trabajador_sucursal`
--
ALTER TABLE `tb_trabajador_sucursal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_trabajador` (`id_trabajador`),
  ADD KEY `id_sucursal` (`id_sucursal`);

--
-- Indices de la tabla `tb_unidad_medida`
--
ALTER TABLE `tb_unidad_medida`
  ADD PRIMARY KEY (`id_unidad_medida`);

--
-- Indices de la tabla `tb_vacuna`
--
ALTER TABLE `tb_vacuna`
  ADD PRIMARY KEY (`id_vacuna`),
  ADD KEY `tb_vacuna_id_tipo_mascota_foreign` (`id_tipo_mascota`);

--
-- Indices de la tabla `tb_venta`
--
ALTER TABLE `tb_venta`
  ADD PRIMARY KEY (`id_venta`),
  ADD UNIQUE KEY `id_venta` (`id_venta`),
  ADD KEY `id_sucursal` (`id_sucursal`),
  ADD KEY `id_trabajador` (`id_trabajador`),
  ADD KEY `id_documento_venta` (`id_documento_venta`),
  ADD KEY `id_documento_cliente` (`id_documento_cliente`),
  ADD KEY `id_forma_pago` (`id_forma_pago`),
  ADD KEY `id_moneda` (`id_moneda`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_accesorio`
--
ALTER TABLE `tb_accesorio`
  MODIFY `id_accesorio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

--
-- AUTO_INCREMENT de la tabla `tb_acceso_opcion`
--
ALTER TABLE `tb_acceso_opcion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=798;

--
-- AUTO_INCREMENT de la tabla `tb_categoria_accesorio`
--
ALTER TABLE `tb_categoria_accesorio`
  MODIFY `id_categoria` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `tb_cita`
--
ALTER TABLE `tb_cita`
  MODIFY `id_cita` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tb_cliente`
--
ALTER TABLE `tb_cliente`
  MODIFY `id_cliente` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `tb_cliente_fundo`
--
ALTER TABLE `tb_cliente_fundo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `tb_compra`
--
ALTER TABLE `tb_compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_cronograma`
--
ALTER TABLE `tb_cronograma`
  MODIFY `id_cronograma` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tb_cronograma_maquinaria`
--
ALTER TABLE `tb_cronograma_maquinaria`
  MODIFY `id_cronograma_maquinaria` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_cronograma_operadores`
--
ALTER TABLE `tb_cronograma_operadores`
  MODIFY `id_cronograma_operador` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_cita`
--
ALTER TABLE `tb_detalle_cita`
  MODIFY `id_detalle` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_compra`
--
ALTER TABLE `tb_detalle_compra`
  MODIFY `id_detalle` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_ingreso`
--
ALTER TABLE `tb_detalle_ingreso`
  MODIFY `id_detalle` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tb_documento_identidad`
--
ALTER TABLE `tb_documento_identidad`
  MODIFY `id_documento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tb_documento_venta`
--
ALTER TABLE `tb_documento_venta`
  MODIFY `id_documento_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tb_empresa`
--
ALTER TABLE `tb_empresa`
  MODIFY `id_empresa` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_especialidad`
--
ALTER TABLE `tb_especialidad`
  MODIFY `id_especialidad` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tb_forma_pago`
--
ALTER TABLE `tb_forma_pago`
  MODIFY `id_forma_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tb_galeria`
--
ALTER TABLE `tb_galeria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tb_grupo_usuario`
--
ALTER TABLE `tb_grupo_usuario`
  MODIFY `id_grupo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tb_maquinaria`
--
ALTER TABLE `tb_maquinaria`
  MODIFY `id_maquinaria` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tb_mascota`
--
ALTER TABLE `tb_mascota`
  MODIFY `id_mascota` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_mascota_vacuna`
--
ALTER TABLE `tb_mascota_vacuna`
  MODIFY `id_mascota_vacuna` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tb_medicamento`
--
ALTER TABLE `tb_medicamento`
  MODIFY `id_medicamento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_moneda`
--
ALTER TABLE `tb_moneda`
  MODIFY `id_moneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_pago`
--
ALTER TABLE `tb_pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_pagos_clientes`
--
ALTER TABLE `tb_pagos_clientes`
  MODIFY `id_pago_cliente` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_persona`
--
ALTER TABLE `tb_persona`
  MODIFY `id_persona` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `tb_promocion`
--
ALTER TABLE `tb_promocion`
  MODIFY `id_promocion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_proveedor`
--
ALTER TABLE `tb_proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_proveedor_observaciones`
--
ALTER TABLE `tb_proveedor_observaciones`
  MODIFY `id_detalle` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_servicio`
--
ALTER TABLE `tb_servicio`
  MODIFY `id_servicio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tb_sucursal`
--
ALTER TABLE `tb_sucursal`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_tipo_cambio`
--
ALTER TABLE `tb_tipo_cambio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_tipo_mascota`
--
ALTER TABLE `tb_tipo_mascota`
  MODIFY `id_tipo_mascota` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_tipo_medicamento`
--
ALTER TABLE `tb_tipo_medicamento`
  MODIFY `id_tipo_medicamento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tb_tipo_servicio`
--
ALTER TABLE `tb_tipo_servicio`
  MODIFY `id_tipo_servicio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tb_trabajador`
--
ALTER TABLE `tb_trabajador`
  MODIFY `id_trabajador` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tb_trabajador_servicio`
--
ALTER TABLE `tb_trabajador_servicio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `tb_trabajador_sucursal`
--
ALTER TABLE `tb_trabajador_sucursal`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tb_unidad_medida`
--
ALTER TABLE `tb_unidad_medida`
  MODIFY `id_unidad_medida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tb_vacuna`
--
ALTER TABLE `tb_vacuna`
  MODIFY `id_vacuna` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tb_venta`
--
ALTER TABLE `tb_venta`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_accesorio`
--
ALTER TABLE `tb_accesorio`
  ADD CONSTRAINT `tb_accesorio_ibfk_3` FOREIGN KEY (`id_unidad_medida`) REFERENCES `tb_unidad_medida` (`id_unidad_medida`),
  ADD CONSTRAINT `tb_accesorio_ibfk_4` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
  ADD CONSTRAINT `tb_accesorio_ibfk_5` FOREIGN KEY (`id_moneda`) REFERENCES `tb_moneda` (`id_moneda`),
  ADD CONSTRAINT `tb_accesorio_id_categoria_foreign` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria_accesorio` (`id_categoria`);

--
-- Filtros para la tabla `tb_acceso_opcion`
--
ALTER TABLE `tb_acceso_opcion`
  ADD CONSTRAINT `tb_acceso_opcion_id_grupo_foreign` FOREIGN KEY (`id_grupo`) REFERENCES `tb_grupo_usuario` (`id_grupo`),
  ADD CONSTRAINT `tb_acceso_opcion_id_opcion_foreign` FOREIGN KEY (`id_opcion`) REFERENCES `tb_opcion` (`id_opcion`);

--
-- Filtros para la tabla `tb_cita`
--
ALTER TABLE `tb_cita`
  ADD CONSTRAINT `tb_cita_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
  ADD CONSTRAINT `tb_cita_id_servicio_foreign` FOREIGN KEY (`id_servicio`) REFERENCES `tb_servicio` (`id_servicio`),
  ADD CONSTRAINT `tb_cita_id_trabajador_foreign` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

--
-- Filtros para la tabla `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD CONSTRAINT `tb_cliente_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`);

--
-- Filtros para la tabla `tb_compra`
--
ALTER TABLE `tb_compra`
  ADD CONSTRAINT `tb_compra_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
  ADD CONSTRAINT `tb_compra_ibfk_2` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

--
-- Filtros para la tabla `tb_cronograma`
--
ALTER TABLE `tb_cronograma`
  ADD CONSTRAINT `fk_servicio_cronograma` FOREIGN KEY (`id_servicio`) REFERENCES `tb_servicio` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_cronograma_maquinaria`
--
ALTER TABLE `tb_cronograma_maquinaria`
  ADD CONSTRAINT `fk_cronograma_maquinaria` FOREIGN KEY (`id_cronograma`) REFERENCES `tb_cronograma` (`id_cronograma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_maquinaria_cronograma` FOREIGN KEY (`id_maquinaria`) REFERENCES `tb_maquinaria` (`id_maquinaria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_cronograma_operadores`
--
ALTER TABLE `tb_cronograma_operadores`
  ADD CONSTRAINT `fk_cronograma_operador` FOREIGN KEY (`id_cronograma`) REFERENCES `tb_cronograma` (`id_cronograma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trabajador_cronograma` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_detalle_cita`
--
ALTER TABLE `tb_detalle_cita`
  ADD CONSTRAINT `tb_detalle_cita_ibfk_1` FOREIGN KEY (`id_cita`) REFERENCES `tb_cita` (`id_cita`);

--
-- Filtros para la tabla `tb_detalle_venta`
--
ALTER TABLE `tb_detalle_venta`
  ADD CONSTRAINT `tb_detalle_venta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `tb_venta` (`id_venta`);

--
-- Filtros para la tabla `tb_documento_venta`
--
ALTER TABLE `tb_documento_venta`
  ADD CONSTRAINT `tb_documento_venta_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`);

--
-- Filtros para la tabla `tb_empresa`
--
ALTER TABLE `tb_empresa`
  ADD CONSTRAINT `tb_empresa_id_documento_foreign` FOREIGN KEY (`id_documento`) REFERENCES `tb_documento_identidad` (`id_documento`),
  ADD CONSTRAINT `tb_empresa_id_documento_representante_foreign` FOREIGN KEY (`id_documento_representante`) REFERENCES `tb_documento_identidad` (`id_documento`);

--
-- Filtros para la tabla `tb_mascota`
--
ALTER TABLE `tb_mascota`
  ADD CONSTRAINT `tb_mascota_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id_cliente`),
  ADD CONSTRAINT `tb_mascota_id_tipo_mascota_foreign` FOREIGN KEY (`id_tipo_mascota`) REFERENCES `tb_tipo_mascota` (`id_tipo_mascota`);

--
-- Filtros para la tabla `tb_mascota_vacuna`
--
ALTER TABLE `tb_mascota_vacuna`
  ADD CONSTRAINT `tb_mascota_vacuna_id_mascota_foreign` FOREIGN KEY (`id_mascota`) REFERENCES `tb_mascota` (`id_mascota`),
  ADD CONSTRAINT `tb_mascota_vacuna_id_vacuna_foreign` FOREIGN KEY (`id_vacuna`) REFERENCES `tb_vacuna` (`id_vacuna`);

--
-- Filtros para la tabla `tb_medicamento`
--
ALTER TABLE `tb_medicamento`
  ADD CONSTRAINT `tb_medicamento_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
  ADD CONSTRAINT `tb_medicamento_ibfk_2` FOREIGN KEY (`id_unidad_medida`) REFERENCES `tb_unidad_medida` (`id_unidad_medida`),
  ADD CONSTRAINT `tb_medicamento_ibfk_3` FOREIGN KEY (`id_moneda`) REFERENCES `tb_moneda` (`id_moneda`),
  ADD CONSTRAINT `tb_medicamento_id_tipo_medicamento_foreign` FOREIGN KEY (`id_tipo_medicamento`) REFERENCES `tb_tipo_medicamento` (`id_tipo_medicamento`);

--
-- Filtros para la tabla `tb_pagos_clientes`
--
ALTER TABLE `tb_pagos_clientes`
  ADD CONSTRAINT `fk_cronograma_pago` FOREIGN KEY (`id_cronograma`) REFERENCES `tb_cronograma` (`id_cronograma`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_persona`
--
ALTER TABLE `tb_persona`
  ADD CONSTRAINT `fk_tbpersona_documento_ident` FOREIGN KEY (`id_documento`) REFERENCES `tb_documento_identidad` (`id_documento`);

--
-- Filtros para la tabla `tb_promocion`
--
ALTER TABLE `tb_promocion`
  ADD CONSTRAINT `tb_promocion_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id_cliente`);

--
-- Filtros para la tabla `tb_proveedor`
--
ALTER TABLE `tb_proveedor`
  ADD CONSTRAINT `tb_proveedor_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`);

--
-- Filtros para la tabla `tb_proveedor_observaciones`
--
ALTER TABLE `tb_proveedor_observaciones`
  ADD CONSTRAINT `tb_proveedor_observaciones_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `tb_proveedor` (`id_proveedor`);

--
-- Filtros para la tabla `tb_servicio`
--
ALTER TABLE `tb_servicio`
  ADD CONSTRAINT `fk_id_maquinaria` FOREIGN KEY (`id_maquinaria`) REFERENCES `tb_maquinaria` (`id_maquinaria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tbtiposervicio_servicio` FOREIGN KEY (`id_tipo_servicio`) REFERENCES `tb_tipo_servicio` (`id_tipo_servicio`),
  ADD CONSTRAINT `tb_servicio_ibfk_1` FOREIGN KEY (`id_moneda`) REFERENCES `tb_moneda` (`id_moneda`);

--
-- Filtros para la tabla `tb_sucursal`
--
ALTER TABLE `tb_sucursal`
  ADD CONSTRAINT `tb_sucursal_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `tb_empresa` (`id_empresa`);

--
-- Filtros para la tabla `tb_tipo_cambio`
--
ALTER TABLE `tb_tipo_cambio`
  ADD CONSTRAINT `tb_tipo_cambio_ibfk_1` FOREIGN KEY (`id_moneda`) REFERENCES `tb_moneda` (`id_moneda`);

--
-- Filtros para la tabla `tb_trabajador`
--
ALTER TABLE `tb_trabajador`
  ADD CONSTRAINT `fk_tbpersona_tb_trabajador` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`),
  ADD CONSTRAINT `fktb_trabajador_tbespecialidad` FOREIGN KEY (`id_especialidad`) REFERENCES `tb_especialidad` (`id_especialidad`),
  ADD CONSTRAINT `fktb_trabajador_tbgrupousuario` FOREIGN KEY (`id_grupo`) REFERENCES `tb_grupo_usuario` (`id_grupo`);

--
-- Filtros para la tabla `tb_trabajador_servicio`
--
ALTER TABLE `tb_trabajador_servicio`
  ADD CONSTRAINT `tb_trabajador_servicio_id_servicio_foreign` FOREIGN KEY (`id_servicio`) REFERENCES `tb_servicio` (`id_servicio`),
  ADD CONSTRAINT `tb_trabajador_servicio_id_trabajador_foreign` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

--
-- Filtros para la tabla `tb_trabajador_sucursal`
--
ALTER TABLE `tb_trabajador_sucursal`
  ADD CONSTRAINT `tb_trabajador_sucursal_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
  ADD CONSTRAINT `tb_trabajador_sucursal_ibfk_2` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

--
-- Filtros para la tabla `tb_vacuna`
--
ALTER TABLE `tb_vacuna`
  ADD CONSTRAINT `tb_vacuna_id_tipo_mascota_foreign` FOREIGN KEY (`id_tipo_mascota`) REFERENCES `tb_tipo_mascota` (`id_tipo_mascota`);

--
-- Filtros para la tabla `tb_venta`
--
ALTER TABLE `tb_venta`
  ADD CONSTRAINT `tb_venta_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
  ADD CONSTRAINT `tb_venta_ibfk_2` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);
COMMIT;

--
-- Añadir nuevos estados en el estado_trabajo
--
ALTER TABLE tb_cronograma
MODIFY COLUMN estado_trabajo ENUM('EN PROCESO', 'TERMINADO', 'PENDIENTE', 'ANULADO', 'REGISTRADO', 'APROBADO')
DEFAULT 'REGISTRADO';


-- Nuevo campo codigo
ALTER TABLE tb_cronograma ADD COLUMN codigo INT;

-- Campo serie en tipo_servicio
ALTER TABLE tb_tipo_servicio 
ADD COLUMN serie VARCHAR(6) NOT NULL;

-- TRIGGER PARA AUTOMATIZAR EL REGISTRO DE SERIE
DELIMITER //
CREATE TRIGGER trg_set_serie BEFORE INSERT ON tb_tipo_servicio
FOR EACH ROW
BEGIN
    SET NEW.serie = CONCAT('SE-', UPPER(LEFT(NEW.name_tipo, 3)));
END; //

CREATE TRIGGER trg_update_serie BEFORE UPDATE ON tb_tipo_servicio
FOR EACH ROW
BEGIN
    SET NEW.serie = CONCAT('SE-', UPPER(LEFT(NEW.name_tipo, 3)));
END; //
DELIMITER ;

-- Añadir una relación para Unidad de Negocio
ALTER TABLE `tb_maquinaria`
ADD `id_tipo_servicio` bigint(20) NOT NULL AFTER `id_trabajador`;
ALTER TABLE `tb_maquinaria` CHANGE `id_tipo_servicio` `id_tipo_servicio` BIGINT(20) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `tb_maquinaria` ADD CONSTRAINT `fk_maquinaria_tipo_servicio` FOREIGN KEY (`id_tipo_servicio`)
 REFERENCES `tb_tipo_servicio`(`id_tipo_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;

-- añadir el campo de pago_operador
 ALTER TABLE tb_servicio ADD COLUMN pago_operador DECIMAL(8,2) NULL DEFAULT 0.00 AFTER precio;
