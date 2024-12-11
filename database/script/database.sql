CREATE TABLE `tb_accesorio` (
  `id_accesorio` bigint UNSIGNED NOT NULL,
  `id_sucursal` int NOT NULL DEFAULT '1',
  `id_categoria` bigint UNSIGNED NOT NULL,
  `id_unidad_medida` int NOT NULL DEFAULT '1',
  `name_accesorio` varchar(100) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `stock_minimo` int NOT NULL DEFAULT '0',
  `precio_compra` double(8, 2) NOT NULL DEFAULT '0.00',
  `id_moneda` int NOT NULL DEFAULT '1',
  `signo_moneda` varchar(10) NOT NULL DEFAULT 'S/',
  `precio_venta` double(8, 2) NOT NULL DEFAULT '0.00',
  `flag_igv` char(1) NOT NULL DEFAULT '1',
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo',
  `src_imagen` varchar(150) DEFAULT NULL
);


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
    2,
    1,
    'Balde de Aceites',
    'Aceite para mantenimiento de maquinaria.',
    7,
    10,
    40.00,
    1,
    'S/',
    1.00,
    '1',
    'activo',
    'resources/global/images/accesorios/img-1732221122.png'
  ),
  (
    2,
    1,
    1,
    1,
    'Filtro de HST',
    'Filtro de repuesto',
    36,
    15,
    30.00,
    1,
    'S/',
    1.00,
    '1',
    'activo',
    'resources/global/images/accesorios/img-1732221173.png'
  ),
  (
    3,
    1,
    1,
    1,
    'Manguera de Bomba',
    'Repuesto para maquinaria',
    9,
    10,
    45.00,
    1,
    'S/',
    1.00,
    '1',
    'activo',
    'resources/global/images/accesorios/img-1732221218.png'
  ),
  (
    4,
    1,
    1,
    1,
    'Cañerías de Respuesto',
    'Cañería para reemplazar',
    0,
    4,
    75.00,
    1,
    'S/',
    1.00,
    '1',
    'activo',
    'resources/global/images/accesorios/img-1732221330.png'
  );

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
);


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
-- Estructura de tabla para la tabla `tb_categoria_accesorio`
--
CREATE TABLE `tb_categoria_accesorio` (
  `id_categoria` bigint UNSIGNED NOT NULL,
  `name_categoria` varchar(50) NOT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);

--
-- Volcado de datos para la tabla `tb_categoria_accesorio`
--
INSERT INTO
  `tb_categoria_accesorio` (`id_categoria`, `name_categoria`, `estado`)
VALUES
  (1, 'REPUESTO', 'activo'),
  (2, 'LIMPIEZA', 'activo');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_cita`
--
CREATE TABLE `tb_cita` (
  `id_cita` bigint UNSIGNED NOT NULL,
  `id_sucursal` int NOT NULL DEFAULT '1',
  `id_trabajador` bigint UNSIGNED NOT NULL,
  `id_servicio` bigint UNSIGNED NOT NULL,
  `id_mascota` bigint UNSIGNED NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_cita` datetime NOT NULL,
  `fecha_termino` datetime DEFAULT NULL,
  `sintoma` varchar(1000) DEFAULT NULL,
  `observaciones` varchar(1000) DEFAULT NULL,
  `mensaje_cita` varchar(1000) DEFAULT NULL,
  `estado` enum(
    'registrada',
    'aceptada',
    'cancelada',
    'anulada',
    'atendida'
  ) NOT NULL DEFAULT 'registrada'
);

--
-- Volcado de datos para la tabla `tb_cita`
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
  ),
  (
    4,
    1,
    2,
    1,
    0,
    '2024-11-21 16:27:18',
    '2024-11-22 15:15:00',
    '2024-11-22 15:30:00',
    '',
    NULL,
    NULL,
    'registrada'
  ),
  (
    5,
    1,
    3,
    1,
    0,
    '2024-11-25 12:20:09',
    '2024-11-26 09:30:00',
    '2024-11-26 11:15:00',
    'err',
    NULL,
    NULL,
    'registrada'
  ),
  (
    6,
    1,
    3,
    5,
    0,
    '2024-11-25 12:33:25',
    '2024-11-26 19:00:00',
    '2024-11-28 19:00:00',
    '',
    NULL,
    NULL,
    'registrada'
  ),
  (
    7,
    1,
    3,
    1,
    0,
    '2024-11-25 12:55:24',
    '2024-11-25 00:00:00',
    '2024-11-26 00:00:00',
    'teteo',
    NULL,
    NULL,
    'registrada'
  ),
  (
    8,
    1,
    2,
    1,
    0,
    '2024-11-25 13:26:12',
    '2024-11-25 00:00:00',
    '2024-11-26 00:00:00',
    '34',
    NULL,
    NULL,
    'registrada'
  ),
  (
    9,
    1,
    2,
    6,
    0,
    '2024-11-25 13:37:31',
    '2024-11-25 19:00:00',
    '2024-11-26 19:00:00',
    '',
    NULL,
    NULL,
    'registrada'
  ),
  (
    10,
    1,
    1,
    3,
    0,
    '2024-11-25 13:43:45',
    '2024-11-27 19:00:00',
    '2024-11-28 19:00:00',
    '',
    NULL,
    NULL,
    'registrada'
  ),
  (
    11,
    1,
    2,
    3,
    0,
    '2024-11-25 16:41:57',
    '2024-11-25 19:00:00',
    '2024-11-26 19:00:00',
    'prueba',
    NULL,
    NULL,
    'registrada'
  ),
  (
    12,
    1,
    2,
    5,
    0,
    '2024-11-28 10:27:52',
    '2024-11-28 19:00:00',
    '2024-11-29 19:00:00',
    'testeo ',
    NULL,
    NULL,
    'registrada'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_cliente`
--
CREATE TABLE `tb_cliente` (
  `id_cliente` bigint UNSIGNED NOT NULL,
  `id_persona` bigint UNSIGNED NOT NULL,
  `name_user` varchar(100) NOT NULL,
  `pass_user` varchar(500) NOT NULL,
  `cod_recuperacion` varchar(500) DEFAULT NULL,
  `fecha_activacion` date DEFAULT NULL,
  `fecha_recuperacion` date DEFAULT NULL,
  `src_imagen` varchar(500) DEFAULT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);

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
    'luisa@gmail.com',
    '1dd4ecb6f7f0091bc464fee9b9202d59',
    NULL,
    '2019-10-16',
    NULL,
    'resources/global/images/persons/img-1571243739.png',
    'activo'
  ),
  (
    2,
    7,
    '70570123@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    3,
    8,
    '77229533@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    4,
    9,
    '70570128@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    5,
    10,
    '70570127@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    6,
    11,
    '70570182@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    7,
    12,
    '70570131@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    8,
    13,
    '20608147307@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    9,
    14,
    '70570162@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    10,
    15,
    '70570124@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    11,
    16,
    '70570223@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    12,
    17,
    '70570126@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    13,
    18,
    '70570172@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    14,
    19,
    '70570193@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    15,
    20,
    '70570132@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    16,
    21,
    '70570179@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    17,
    22,
    '70570271@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    18,
    23,
    '70372212@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    19,
    24,
    '70570192@gmail.com',
    '1234',
    NULL,
    '2024-11-27',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    20,
    25,
    '70570251@gmail.com',
    '1234',
    NULL,
    '2024-11-28',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    21,
    26,
    '70470132@gmail.com',
    '1234',
    NULL,
    '2024-11-28',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    22,
    27,
    '70472318@gmail.com',
    '1234',
    NULL,
    '2024-11-29',
    NULL,
    'resources/global/images/default-profile.png',
    'activo'
  ),
  (
    23,
    28,
    '70367121@gmail.com',
    '1234',
    NULL,
    '2024-11-29',
    NULL,
    'resources/global/images/default-profile.png',
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
);

--
-- Volcado de datos para la tabla `tb_cliente_fundo`
--
INSERT INTO
  `tb_cliente_fundo` (`id`, `id_cliente`, `id_fundo`, `cantidad_hc`)
VALUES
  (1, 1, 2, 5),
  (2, 1, 3, 2);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_compra`
--
CREATE TABLE `tb_compra` (
  `id_compra` int NOT NULL,
  `id_sucursal` int NOT NULL,
  `id_trabajador` bigint UNSIGNED NOT NULL,
  `id_documento_compra` int NOT NULL,
  `name_documento_compra` varchar(100) NOT NULL,
  `codigo_documento_compra` varchar(4) NOT NULL,
  `serie` varchar(4) NOT NULL,
  `correlativo` varchar(12) NOT NULL,
  `id_documento_proveedor` bigint UNSIGNED NOT NULL,
  `name_documento_proveedor` varchar(100) NOT NULL,
  `codigo_documento_proveedor` varchar(4) NOT NULL,
  `numero_documento_proveedor` varchar(30) NOT NULL,
  `id_forma_pago` int NOT NULL,
  `codigo_forma_pago` varchar(4) NOT NULL,
  `name_forma_pago` varchar(100) NOT NULL,
  `proveedor` varchar(500) NOT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
  `descuento_total` decimal(18, 2) DEFAULT '0.00',
  `sub_total` decimal(18, 2) NOT NULL,
  `igv` decimal(18, 2) NOT NULL,
  `total` decimal(18, 2) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT '1',
  `pdf` varchar(500) DEFAULT NULL,
  `xml` varchar(500) DEFAULT NULL,
  `cdr` varchar(500) DEFAULT NULL,
  `mensaje_sunat` varchar(1000) DEFAULT NULL,
  `ruta` varchar(500) DEFAULT NULL,
  `token` varchar(500) DEFAULT NULL,
  `flag_doc_interno` char(1) NOT NULL DEFAULT '1',
  `monto_recibido` decimal(18, 2) DEFAULT NULL,
  `vuelto` decimal(18, 2) DEFAULT NULL,
  `id_moneda` int NOT NULL,
  `codigo_moneda` varchar(4) NOT NULL,
  `signo_moneda` varchar(10) DEFAULT NULL,
  `abreviatura_moneda` varchar(10) DEFAULT NULL,
  `signo_moneda_cambio` varchar(10) NOT NULL DEFAULT 'S/ ',
  `monto_tipo_cambio` decimal(18, 2) DEFAULT NULL,
  `observaciones` varchar(1000) DEFAULT NULL,
  `flag_enviado` char(1) DEFAULT '1'
);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_detalle_cita`
--
CREATE TABLE `tb_detalle_cita` (
  `id_detalle` bigint NOT NULL,
  `id_cita` bigint UNSIGNED NOT NULL,
  `name_servicio` varchar(200) DEFAULT NULL,
  `motivo` text ,
  `sintomas` text ,
  `tratamiento` text ,
  `vacunas_aplicadas` text ,
  `observaciones` text ,
  `peso` varchar(100) DEFAULT NULL,
  `fecha_detalle_cita` datetime DEFAULT NULL
);

--
-- Volcado de datos para la tabla `tb_detalle_cita`
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
  ),
  (
    4,
    4,
    'Protección de Hectáreas',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
  ),
  (
    5,
    5,
    'Protección de Hectáreas',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
  ),
  (
    6,
    6,
    'Reparación Rutinaria',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
  ),
  (
    7,
    7,
    'Protección de Hectáreas',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
  ),
  (
    8,
    8,
    'Protección de Hectáreas',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
  ),
  (
    9,
    9,
    'Cosechas de arroz',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
  ),
  (
    10,
    10,
    'Distribución de agua',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
  ),
  (
    11,
    11,
    'Distribución de agua',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
  ),
  (
    12,
    12,
    'Reparación Rutinaria',
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
-- Estructura de tabla para la tabla `tb_detalle_compra`
--
CREATE TABLE `tb_detalle_compra` (
  `id_detalle` bigint NOT NULL,
  `id_orden_compra` int NOT NULL,
  `name_tabla` varchar(100) NOT NULL,
  `cod_producto` int NOT NULL,
  `cantidad_solicitada` int DEFAULT NULL,
  `cantidad_ingresada` int DEFAULT NULL,
  `precio_unitario` decimal(18, 2) DEFAULT NULL,
  `notas` varchar(200) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `tb_detalle_compra`
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
  (18, 1, 'accesorio', 1, 50, 0, 40.00, ''),
  (19, 1, 'accesorio', 2, 20, 0, 100.50, ''),
  (20, 1, 'accesorio', 3, 20, 0, 150.75, ''),
  (21, 1, 'medicamento', 1, 15, 0, 100.00, ''),
  (22, 1, 'medicamento', 2, 15, 0, 50.00, ''),
  (23, 2, 'accesorio', 1, 10, 0, 40.00, ''),
  (24, 2, 'accesorio', 2, 10, 0, 100.50, ''),
  (25, 3, 'accesorio', 3, 3, 0, 150.75, ''),
  (27, 4, 'accesorio', 3, 3, 3, 13.43, ''),
  (
    28,
    5,
    'accesorio',
    2,
    1,
    1,
    105.00,
    'Para uso único'
  ),
  (29, 6, 'accesorio', 1, 1, 1, 40.00, 'olos'),
  (30, 6, 'accesorio', 3, 1, 1, 45.00, 'serp'),
  (31, 6, 'accesorio', 4, 1, 1, 75.00, 'awda');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_detalle_ingreso`
--
CREATE TABLE `tb_detalle_ingreso` (
  `id_detalle` bigint NOT NULL,
  `id_ingreso` bigint NOT NULL,
  `name_tabla` varchar(200) DEFAULT NULL,
  `cod_producto` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `tb_detalle_ingreso`
--
INSERT INTO
  `tb_detalle_ingreso` (
    `id_detalle`,
    `id_ingreso`,
    `name_tabla`,
    `cod_producto`,
    `cantidad`,
    `observaciones`
  )
VALUES
  (1, 1, 'accesorio', 3, 3, 'Recibido'),
  (2, 2, 'accesorio', 2, 1, 'Ok'),
  (3, 3, 'accesorio', 1, 1, 'pp'),
  (4, 3, 'accesorio', 3, 1, 'gt'),
  (5, 3, 'accesorio', 4, 1, 'afp');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_detalle_venta`
--
CREATE TABLE `tb_detalle_venta` (
  `id_detalle` bigint UNSIGNED NOT NULL,
  `id_venta` int NOT NULL,
  `name_tabla` varchar(100) DEFAULT NULL,
  `cod_producto` varchar(20) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `cantidad` decimal(18, 2) NOT NULL,
  `precio_unitario` decimal(18, 2) DEFAULT NULL,
  `descuento` decimal(18, 2) DEFAULT '0.00',
  `sub_total` decimal(18, 2) DEFAULT '0.00',
  `tipo_igv` varchar(2) DEFAULT NULL,
  `igv` decimal(18, 2) DEFAULT '0.00',
  `total` decimal(18, 2) DEFAULT '0.00',
  `notas` varchar(200) DEFAULT NULL,
  `id_maquinaria` int DEFAULT NULL
);

--
-- Volcado de datos para la tabla `tb_detalle_venta`
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
    `total`,
    `notas`,
    `id_maquinaria`
  )
VALUES
  (
    1,
    1,
    'producto',
    '1',
    'Balde de Aceites',
    4.00,
    0.85,
    1.00,
    4.00,
    '1',
    0.72,
    4.72,
    'Para la maquinaria 2',
    0
  ),
  (
    2,
    1,
    'producto',
    '3',
    'Manguera de Bomba',
    3.00,
    0.85,
    1.00,
    3.00,
    '1',
    0.54,
    3.54,
    'Para el mantenimiento',
    0
  ),
  (
    3,
    2,
    'producto',
    '1',
    'Balde de Aceites',
    3.00,
    0.85,
    1.00,
    3.00,
    '1',
    0.54,
    3.54,
    'Uso diario',
    0
  ),
  (
    4,
    2,
    'producto',
    '3',
    'Manguera de Bomba',
    3.00,
    0.85,
    1.00,
    3.00,
    '1',
    0.54,
    3.54,
    'Uso diario',
    0
  ),
  (
    5,
    3,
    'producto',
    '3',
    'Manguera de Bomba',
    1.00,
    0.85,
    1.00,
    1.00,
    '1',
    0.18,
    1.18,
    'Restablecer ',
    0
  ),
  (
    6,
    3,
    'producto',
    '1',
    'Balde de Aceites',
    1.00,
    0.85,
    1.00,
    1.00,
    '1',
    0.18,
    1.18,
    'Mínimas unidades',
    0
  ),
  (
    7,
    4,
    'producto',
    '1',
    'Balde de Aceites',
    1.00,
    0.85,
    1.00,
    1.00,
    '1',
    0.18,
    1.18,
    'En desgaste',
    0
  ),
  (
    8,
    4,
    'producto',
    '2',
    'Filtro de HST',
    4.00,
    0.85,
    1.00,
    4.00,
    '1',
    0.72,
    4.72,
    'Reponer',
    0
  ),
  (
    9,
    4,
    'producto',
    '3',
    'Manguera de Bomba',
    5.00,
    0.85,
    1.00,
    5.00,
    '1',
    0.90,
    5.90,
    'Reponer',
    0
  ),
  (
    10,
    4,
    'producto',
    '4',
    'Cañerías de Respuesto',
    2.00,
    0.85,
    1.00,
    2.00,
    '1',
    0.36,
    2.36,
    '',
    0
  ),
  (
    11,
    5,
    'producto',
    '2',
    'Filtro de HST',
    1.00,
    0.85,
    1.00,
    1.00,
    '1',
    0.18,
    1.18,
    'notas',
    2
  ),
  (
    12,
    6,
    'producto',
    '1',
    'Balde de Aceites',
    1.00,
    0.85,
    1.00,
    1.00,
    '1',
    0.18,
    1.18,
    'asefe',
    1
  ),
  (
    13,
    6,
    'producto',
    '3',
    'Manguera de Bomba',
    3.00,
    0.85,
    1.00,
    3.00,
    '1',
    0.54,
    3.54,
    '',
    2
  ),
  (
    14,
    7,
    'producto',
    '2',
    'Filtro de HST',
    1.00,
    0.85,
    1.00,
    1.00,
    '1',
    0.18,
    1.18,
    '',
    4
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_documento_identidad`
--
CREATE TABLE `tb_documento_identidad` (
  `id_documento` bigint UNSIGNED NOT NULL,
  `name_documento` varchar(100) NOT NULL,
  `codigo_sunat` varchar(10) NOT NULL,
  `flag_numerico` tinyint(1) NOT NULL DEFAULT '0',
  `flag_exacto` tinyint(1) NOT NULL DEFAULT '0',
  `size` int NOT NULL DEFAULT '8',
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);

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
-- Estructura de tabla para la tabla `tb_documento_venta`
--
CREATE TABLE `tb_documento_venta` (
  `id_documento_venta` int NOT NULL,
  `id_sucursal` int NOT NULL,
  `cod_sunat` varchar(10) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `nombre_corto` varchar(50) NOT NULL,
  `serie` varchar(6) DEFAULT NULL,
  `correlativo` bigint DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `flag_doc_interno` char(1) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `tb_documento_venta`
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
    3,
    1,
    '-',
    'TICKET DE SALIDA',
    'TIKET INTERNO',
    'TIK1',
    51,
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
  `num_documento` varchar(30) NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `nombre_comercial` varchar(150) DEFAULT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  `fono01` varchar(30) DEFAULT NULL,
  `correo01` varchar(100) DEFAULT NULL,
  `web` varchar(150) DEFAULT NULL,
  `id_documento_representante` bigint UNSIGNED NOT NULL,
  `num_documento_representante` varchar(30) NOT NULL,
  `nombres_representante` varchar(50) NOT NULL,
  `apellidos_representante` varchar(50) NOT NULL,
  `fono02` varchar(30) DEFAULT NULL,
  `correo02` varchar(100) DEFAULT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo',
  `src_logo` varchar(150) DEFAULT NULL
);

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
    'SYSCOS',
    'Jr. Pedro Remy N 239, San Martín de Porres - Lima - Lima',
    '916028408',
    'informes@veterinariamican.com',
    'https://syscos.com/',
    1,
    '70762343',
    'Jolu',
    'Quispe',
    '916028408',
    'jolu@syscos.com',
    'activo',
    'resources/global/images/business_logo/img-1571242080.jpg'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_especialidad`
--
CREATE TABLE `tb_especialidad` (
  `id_especialidad` bigint UNSIGNED NOT NULL,
  `name_especialidad` varchar(100) NOT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);

--
-- Volcado de datos para la tabla `tb_especialidad`
--
INSERT INTO
  `tb_especialidad` (`id_especialidad`, `name_especialidad`, `estado`)
VALUES
  (1, 'Usuario', 'activo'),
  (2, 'Administrador', 'activo');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_forma_pago`
--
CREATE TABLE `tb_forma_pago` (
  `id_forma_pago` int NOT NULL,
  `name_forma_pago` varchar(200) NOT NULL,
  `cod_sunat` varchar(10) DEFAULT NULL,
  `estado` char(1) DEFAULT '1'
);

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
  `nombre` varchar(300) NOT NULL,
  `cod_ubigeo` varchar(10) DEFAULT NULL,
  `direccion` varchar(1000) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `mapa` varchar(1000) DEFAULT NULL,
  `estado` char(1) DEFAULT '1',
  `token` varchar(1000) DEFAULT NULL,
  `ruta` varchar(1000) DEFAULT NULL
);

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
  (1, 1, 'MALVINAS', '', '', '', '', '1', '', ''),
  (
    2,
    1,
    'SOL NACIENTE',
    '',
    '',
    '',
    '',
    '1',
    '',
    ''
  ),
  (
    3,
    1,
    '16 DE NOVIEMBRE',
    '',
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
    '',
    '',
    '',
    '',
    '1',
    '',
    ''
  ),
  (5, 1, 'LIBERTAD', '', '', '', '', '1', '', ''),
  (6, 1, 'SAN JUAN', '', '', '', '', '1', '', ''),
  (7, 1, 'MARONAL', '', '', '', '', '1', '', ''),
  (8, 1, 'CURIMANA', '', '', '', '', '1', '', ''),
  (
    9,
    1,
    'OTROS (sin nombrar)',
    '',
    '',
    '',
    '',
    '1',
    '',
    ''
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_galeria`
--
CREATE TABLE `tb_galeria` (
  `id` bigint UNSIGNED NOT NULL,
  `name_tabla` varchar(1) NOT NULL DEFAULT '0',
  `src` varchar(200) DEFAULT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `referencia_1` varchar(200) DEFAULT NULL,
  `referencia_2` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);

--
-- Volcado de datos para la tabla `tb_galeria`
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
-- Estructura de tabla para la tabla `tb_grupo_usuario`
--
CREATE TABLE `tb_grupo_usuario` (
  `id_grupo` bigint UNSIGNED NOT NULL,
  `name_grupo` varchar(50) NOT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);

--
-- Volcado de datos para la tabla `tb_grupo_usuario`
--
INSERT INTO
  `tb_grupo_usuario` (`id_grupo`, `name_grupo`, `estado`)
VALUES
  (1, 'Administrador', 'activo'),
  (2, 'Usuario', 'activo'),
  (3, 'Caja', 'activo');

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
  `num_documento` varchar(50) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `tb_ingreso`
--
INSERT INTO
  `tb_ingreso` (
    `id_ingreso`,
    `id_orden_compra`,
    `id_sucursal`,
    `id_trabajador`,
    `id_tipo_docu`,
    `num_documento`,
    `fecha`,
    `observaciones`,
    `estado`
  )
VALUES
  (
    1,
    4,
    1,
    1,
    2,
    '029383823',
    '2024-11-22 13:00:38',
    'JAJKSJA',
    '1'
  ),
  (
    2,
    5,
    1,
    1,
    1,
    '7289393',
    '2024-11-26 09:33:40',
    '',
    '1'
  ),
  (
    3,
    6,
    1,
    1,
    1,
    '999',
    '2024-11-26 16:23:21',
    '',
    '1'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_maquinaria`
--
CREATE TABLE `tb_maquinaria` (
  `id_maquinaria` bigint UNSIGNED NOT NULL,
  `id_trabajador` int DEFAULT NULL,
  `descripcion` varchar(200) NOT NULL,
  `observaciones` varchar(200) NOT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);

--
-- Volcado de datos para la tabla `tb_maquinaria`
--
INSERT INTO
  `tb_maquinaria` (
    `id_maquinaria`,
    `id_trabajador`,
    `descripcion`,
    `observaciones`,
    `estado`
  )
VALUES
  (1, 2, 'MAQUINA 2', 'En buen estado', 'activo'),
  (2, 3, 'MAQUINA 4', 'Mantenimiento', 'activo'),
  (
    3,
    NULL,
    'MAQUINA 1',
    'En buen funcionamiento',
    'activo'
  ),
  (
    4,
    1,
    'MAQUINA 3',
    'En perfecto Estado',
    'activo'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_mascota`
--
CREATE TABLE `tb_mascota` (
  `id_mascota` bigint UNSIGNED NOT NULL,
  `id_cliente` bigint UNSIGNED NOT NULL,
  `id_tipo_mascota` bigint UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `raza` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `peso` varchar(50) DEFAULT NULL,
  `sexo` enum('hembra', 'macho') NOT NULL DEFAULT 'hembra',
  `fecha_nacimiento` date DEFAULT NULL,
  `observaciones` varchar(1000) DEFAULT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo',
  `src_imagen` varchar(150) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `tb_mascota`
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
-- Estructura de tabla para la tabla `tb_mascota_vacuna`
--
CREATE TABLE `tb_mascota_vacuna` (
  `id_mascota_vacuna` bigint UNSIGNED NOT NULL,
  `id_mascota` bigint UNSIGNED NOT NULL,
  `id_vacuna` bigint UNSIGNED NOT NULL,
  `fecha_minima` date DEFAULT NULL,
  `fecha_maxima` date DEFAULT NULL,
  `fecha_aplicacion` datetime DEFAULT NULL,
  `flag_vacuna` tinyint(1) NOT NULL DEFAULT '0',
  `observaciones` varchar(1000) DEFAULT NULL,
  `name_sucursal` varchar(300) DEFAULT '',
  `name_user` varchar(300) DEFAULT ''
);

--
-- Volcado de datos para la tabla `tb_mascota_vacuna`
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
-- Estructura de tabla para la tabla `tb_medicamento`
--
CREATE TABLE `tb_medicamento` (
  `id_medicamento` bigint UNSIGNED NOT NULL,
  `id_sucursal` int NOT NULL DEFAULT '1',
  `id_tipo_medicamento` bigint UNSIGNED NOT NULL,
  `id_unidad_medida` int NOT NULL DEFAULT '1',
  `name_medicamento` varchar(100) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `stock_minimo` int NOT NULL DEFAULT '0',
  `precio_compra` double(8, 2) NOT NULL DEFAULT '0.00',
  `id_moneda` int NOT NULL DEFAULT '1',
  `signo_moneda` varchar(10) NOT NULL DEFAULT 'S/',
  `precio_venta` double(8, 2) NOT NULL DEFAULT '0.00',
  `flag_igv` char(1) NOT NULL DEFAULT '1',
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo',
  `src_imagen` varchar(150) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `tb_medicamento`
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
-- Estructura de tabla para la tabla `tb_metodo_envio`
--
CREATE TABLE `tb_metodo_envio` (
  `id_metodo_envio` int NOT NULL,
  `name_metodo` varchar(200) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `tb_metodo_envio`
--
INSERT INTO
  `tb_metodo_envio` (`id_metodo_envio`, `name_metodo`, `estado`)
VALUES
  (1, 'DHL EXPRESS', '1');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_moneda`
--
CREATE TABLE `tb_moneda` (
  `id_moneda` int NOT NULL,
  `name_moneda` varchar(200) DEFAULT NULL,
  `cod_sunat` varchar(10) DEFAULT NULL,
  `signo` varchar(10) DEFAULT NULL,
  `abreviatura` varchar(10) DEFAULT NULL,
  `tipo_cambio` decimal(18, 3) DEFAULT '1.000',
  `flag_principal` char(1) DEFAULT '0',
  `estado` char(1) DEFAULT '1'
);

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
  (2, 'DÓLARES', '2', '$', 'USD', 3.500, '0', '1'),
  (3, 'EUROS', '3', '€', 'EUR', 3.750, '0', '1');


CREATE TABLE `tb_opcion` (
  `id_opcion` int NOT NULL,
  `name_opcion` varchar(50) DEFAULT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo',
  `url` varchar(100) DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `icono` varchar(100) DEFAULT NULL
);

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
  (115, 'Tipo de Cosecha', 'activo', NULL, 0, NULL),
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
  (209, 'Fundos', 'activo', NULL, 0, NULL),
  (210, 'Operador', 'activo', NULL, 0, NULL),
  (211, 'Maquinaria', 'activo', NULL, 0, NULL),
  (212, 'Acceso a Fundos', 'activo', NULL, 0, NULL),
  (213, NULL, 'inactivo', NULL, 0, NULL),
  (214, NULL, 'inactivo', NULL, 0, NULL),
  (215, NULL, 'inactivo', NULL, 0, NULL),
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
  (305, NULL, 'inactivo', NULL, 0, NULL),
  (306, NULL, 'inactivo', NULL, 0, NULL),
  (307, NULL, 'inactivo', NULL, 0, NULL),
  (308, NULL, 'inactivo', NULL, 0, NULL),
  (309, NULL, 'inactivo', NULL, 0, NULL),
  (310, NULL, 'inactivo', NULL, 0, NULL),
  (311, NULL, 'inactivo', NULL, 0, NULL),
  (312, NULL, 'inactivo', NULL, 0, NULL),
  (313, NULL, 'inactivo', NULL, 0, NULL),
  (314, NULL, 'inactivo', NULL, 0, NULL),
  (315, NULL, 'inactivo', NULL, 0, NULL),
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
  (407, NULL, 'inactivo', NULL, 0, NULL),
  (408, NULL, 'inactivo', NULL, 0, NULL),
  (409, NULL, 'inactivo', NULL, 0, NULL),
  (410, NULL, 'inactivo', NULL, 0, NULL),
  (411, NULL, 'inactivo', NULL, 0, NULL),
  (412, NULL, 'inactivo', NULL, 0, NULL),
  (413, NULL, 'inactivo', NULL, 0, NULL),
  (414, NULL, 'inactivo', NULL, 0, NULL),
  (415, NULL, 'inactivo', NULL, 0, NULL),
  (500, 'Cronograma', 'activo', NULL, 0, NULL),
  (501, 'Gestionar Cronograma', 'activo', NULL, 0, NULL),
  (
    502,
    'Atención de Cronograma',
    'activo',
    NULL,
    0,
    NULL
  ),
  (503, 'Historial ', 'activo', NULL, 0, NULL),
  (504, NULL, 'inactivo', NULL, 0, NULL),
  (505, NULL, 'inactivo', NULL, 0, NULL),
  (506, NULL, 'inactivo', NULL, 0, NULL),
  (507, NULL, 'inactivo', NULL, 0, NULL),
  (508, NULL, 'inactivo', NULL, 0, NULL),
  (509, NULL, 'inactivo', NULL, 0, NULL),
  (510, NULL, 'inactivo', NULL, 0, NULL),
  (511, NULL, 'inactivo', NULL, 0, NULL),
  (512, NULL, 'inactivo', NULL, 0, NULL),
  (513, NULL, 'inactivo', NULL, 0, NULL),
  (514, NULL, 'inactivo', NULL, 0, NULL),
  (515, NULL, 'inactivo', NULL, 0, NULL),
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
  (707, 'Reporte de Cronograma', 'activo', NULL, 0, NULL),
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
  `cod_recuperacion` varchar(500) DEFAULT NULL,
  `fecha_activacion` date DEFAULT NULL,
  `fecha_recuperacion` date DEFAULT NULL,
  `src_imagen` varchar(500) DEFAULT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);

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
    6,
    '',
    '',
    NULL,
    '2024-11-20',
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
  `id_sucursal` int NOT NULL,
  `fecha_orden` datetime NOT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `estado` char(1) NOT NULL,
  `id_moneda` int NOT NULL
);

--
-- Volcado de datos para la tabla `tb_orden_compra`
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
  ),
  (
    3,
    1,
    1,
    1,
    1,
    '2024-11-21 09:36:06',
    '2024-11-21 00:00:00',
    NULL,
    'JAJKSJA',
    '3',
    1
  ),
  (
    4,
    1,
    1,
    1,
    1,
    '2024-11-22 12:47:26',
    '2024-11-22 00:00:00',
    NULL,
    'JAJKSJA',
    '2',
    2
  ),
  (
    5,
    1,
    1,
    1,
    1,
    '2024-11-26 09:32:43',
    '2024-11-26 00:00:00',
    NULL,
    '',
    '2',
    1
  ),
  (
    6,
    1,
    1,
    1,
    1,
    '2024-11-26 16:21:30',
    '2024-11-26 00:00:00',
    NULL,
    '',
    '2',
    1
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_parametros_generales`
--
CREATE TABLE `tb_parametros_generales` (
  `id_parametro` int NOT NULL,
  `name_parametro` varchar(150) DEFAULT NULL,
  `valor_int` int NOT NULL DEFAULT '0',
  `valor_string` varchar(1000) DEFAULT NULL,
  `valor_decimal` decimal(8, 2) NOT NULL DEFAULT '0.00',
  `valor_bit` tinyint(1) NOT NULL DEFAULT '0'
);

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
  (25, 'Clientes Felices', 1034, NULL, 0.00, 0),
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
  `num_documento` varchar(30) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` enum('masculino', 'femenino') NOT NULL DEFAULT 'masculino'
);

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
    'Empresa Ferretera',
    'Ferretera',
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
    'Irving Adolfo',
    'Tovar',
    'Jr. Pedro Remy N 317 - Urbanización Ingenería',
    '987654321',
    'irvingtovar@gmail.com',
    '1989-10-16',
    'masculino'
  ),
  (
    6,
    1,
    '41286369',
    'ELDER',
    'HURTADO GARCIA',
    '',
    '',
    '',
    '1995-01-26',
    'masculino'
  ),
  (
    7,
    1,
    '70570123',
    'HILLARY URSULA',
    'BACA ALIAGA',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    8,
    1,
    '77229533',
    'HUMBERTO',
    'VALDERA VIDAURRE',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    9,
    1,
    '70570128',
    'INGRID',
    'BRICEÑO CASTRO',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    10,
    1,
    '70570127',
    'FABRIZIO JOSE',
    'GUTIERREZ PACHECO',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    11,
    1,
    '70570182',
    'WERNER',
    'LAIME MAYTA',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    12,
    1,
    '70570131',
    'EDUARDO DANIEL',
    'PERALES CUYA',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    13,
    3,
    '20608147307',
    'TECNOVO PERU SOLUCIONES S.A.C. ',
    '',
    'CAL. GERMAN SCHEREIBER NRO. 276 INT. 240 URB. SANTA ANA, LIMA - LIMA - SAN ISIDRO',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    14,
    1,
    '70570162',
    'HUGO AMERICO',
    'TULA CONDORI',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    15,
    1,
    '70570124',
    'JESUS EDUARDO',
    'VALLEJOS VILLAVERDE',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    16,
    1,
    '70570223',
    'ANDRES ALFREDO',
    'RAMIREZ YOPLAC',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    17,
    1,
    '70570126',
    'BRENDA',
    'HUARANCCA VASQUEZ',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    18,
    1,
    '70570172',
    'JULIA',
    'LARICO APAZA',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    19,
    1,
    '70570193',
    'DIEGO ANDRE',
    'AMPUERO VIVANCO',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    20,
    1,
    '70570132',
    'ALEXANDRA',
    'HUERTAS PERCCA',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    21,
    1,
    '70570179',
    'ROLANDO',
    'TITO APAZA',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    22,
    1,
    '70570271',
    'KISSY EDITH',
    'FIESTAS PALACIOS',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    23,
    1,
    '70372212',
    'LUCERO',
    'NUÑEZ FIGUEROA',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    24,
    1,
    '70570192',
    'CARMEN VALERYA',
    'PERALES MENDIOLA',
    '',
    '',
    '',
    '2024-11-27',
    'masculino'
  ),
  (
    25,
    1,
    '70570251',
    'GONZALO JOSE PEREZ RAMIREZ',
    '',
    '',
    '',
    '',
    '2024-11-28',
    'masculino'
  ),
  (
    26,
    1,
    '70470132',
    'GIOVANNA DAMIANA',
    'VALLE CALDERON',
    '',
    '',
    '',
    '2024-11-28',
    'masculino'
  ),
  (
    27,
    1,
    '70472318',
    'GREYSI YAMILIT',
    'VILCA GELDRES',
    '',
    '',
    '',
    '2024-11-29',
    'masculino'
  ),
  (
    28,
    1,
    '70367121',
    'SOL ARIATNA',
    'FLORES ARISTA',
    '',
    '',
    '',
    '2024-11-29',
    'masculino'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_promocion`
--
CREATE TABLE `tb_promocion` (
  `id_promocion` int NOT NULL,
  `id_cliente` bigint UNSIGNED NOT NULL,
  `titulo` varchar(500) NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `precio` decimal(18, 2) DEFAULT '0.00',
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `src_imagen` varchar(500) DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT '1'
);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_proveedor`
--
CREATE TABLE `tb_proveedor` (
  `id_proveedor` int NOT NULL,
  `id_persona` bigint UNSIGNED NOT NULL,
  `estado` char(1) NOT NULL DEFAULT '1',
  `src_imagen` varchar(300) DEFAULT NULL
);

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
    3,
    '1',
    'resources/global/images/persons/img-1732631523.png'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_proveedor_observaciones`
--
CREATE TABLE `tb_proveedor_observaciones` (
  `id_detalle` bigint NOT NULL,
  `id_proveedor` int NOT NULL,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha` datetime DEFAULT NULL,
  `estado` char(1) DEFAULT '1'
);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_servicio`
--
CREATE TABLE `tb_servicio` (
  `id_servicio` bigint UNSIGNED NOT NULL,
  `id_tipo_servicio` bigint UNSIGNED NOT NULL,
  `id_maquinaria` bigint UNSIGNED NOT NULL,
  `name_servicio` varchar(100) NOT NULL,
  `descripcion_breve` varchar(1000) DEFAULT NULL,
  `descripcion_larga` varchar(1000) DEFAULT NULL,
  `id_moneda` int NOT NULL DEFAULT '1',
  `signo_moneda` varchar(10) DEFAULT NULL,
  `precio` decimal(8, 2) NOT NULL DEFAULT '0.00',
  `flag_igv` char(1) DEFAULT '1',
  `src_imagen` varchar(1000) DEFAULT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);


INSERT INTO
  `tb_servicio` (
    `id_servicio`,
    `id_tipo_servicio`,
    `id_maquinaria`,
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
    3,
    'Protección de Hectáreas',
    '',
    'Mantenimiento de las hectáreas',
    1,
    'S/',
    45.00,
    '1',
    'resources/global/images/servicios/img-1732210383.png',
    'activo'
  ),
  (
    3,
    2,
    1,
    'Distribución de agua',
    '',
    'Reparación de las cañerias de una maquinaria',
    2,
    '$',
    250.00,
    '1',
    'resources/global/images/servicios/img-1732210483.png',
    'activo'
  ),
  (
    5,
    3,
    1,
    'Reparación Rutinaria',
    '',
    'Mantenimiento de Maquinaria',
    1,
    'S/',
    200.00,
    '1',
    'resources/global/images/servicios/img-1732210466.png',
    'activo'
  ),
  (
    6,
    4,
    2,
    'Cosechas de arroz',
    '',
    'Servicio de cosecha de arroz',
    1,
    'S/',
    34.00,
    '1',
    'resources/global/images/sin_imagen.png',
    'activo'
  ),
  (
    7,
    3,
    2,
    'Mantenimiento de regaderas',
    '',
    'Mantenimiento rutinario',
    2,
    '$',
    40.00,
    '1',
    'resources/global/images/sin_imagen.png',
    'activo'
  );

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_sucursal`
--
CREATE TABLE `tb_sucursal` (
  `id_sucursal` int NOT NULL,
  `id_empresa` bigint UNSIGNED NOT NULL,
  `nombre` varchar(300) NOT NULL,
  `cod_ubigeo` varchar(10) DEFAULT NULL,
  `direccion` varchar(1000) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `mapa` varchar(1000) DEFAULT NULL,
  `estado` char(1) DEFAULT '1',
  `token` varchar(1000) DEFAULT NULL,
  `ruta` varchar(1000) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `tb_sucursal`
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
-- Estructura de tabla para la tabla `tb_tipo_cambio`
--
CREATE TABLE `tb_tipo_cambio` (
  `id` int NOT NULL,
  `id_moneda` int NOT NULL,
  `name_user` varchar(300) DEFAULT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `tipo_cambio` decimal(18, 3) NOT NULL
);

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
  (2, 3, 'zhaul', '2019-10-16 11:33:44', 3.750),
  (3, 2, 'zhaul', '2024-11-22 12:53:17', 3.500);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_tipo_cosecha`
--
CREATE TABLE `tb_tipo_cosecha` (
  `id_tipo_cosecha` bigint UNSIGNED NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);

--
-- Volcado de datos para la tabla `tb_tipo_cosecha`
--
INSERT INTO
  `tb_tipo_cosecha` (`id_tipo_cosecha`, `descripcion`, `estado`)
VALUES
  (1, 'GRANDES', 'activo'),
  (2, 'ANGOSTOS', 'activo');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_tipo_mascota`
--
CREATE TABLE `tb_tipo_mascota` (
  `id_tipo_mascota` bigint UNSIGNED NOT NULL,
  `name_tipo` varchar(50) NOT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);

--
-- Volcado de datos para la tabla `tb_tipo_mascota`
--
INSERT INTO
  `tb_tipo_mascota` (`id_tipo_mascota`, `name_tipo`, `estado`)
VALUES
  (1, 'Perro', 'activo'),
  (2, 'Gato', 'activo'),
  (3, 'Conejo', 'activo');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_tipo_medicamento`
--
CREATE TABLE `tb_tipo_medicamento` (
  `id_tipo_medicamento` bigint UNSIGNED NOT NULL,
  `name_tipo` varchar(50) NOT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);

--
-- Volcado de datos para la tabla `tb_tipo_medicamento`
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
-- Estructura de tabla para la tabla `tb_tipo_servicio`
--
CREATE TABLE `tb_tipo_servicio` (
  `id_tipo_servicio` bigint UNSIGNED NOT NULL,
  `name_tipo` varchar(50) NOT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);

--
-- Volcado de datos para la tabla `tb_tipo_servicio`
--
INSERT INTO
  `tb_tipo_servicio` (`id_tipo_servicio`, `name_tipo`, `estado`)
VALUES
  (1, 'MANTENIMIENTO HTC', 'activo'),
  (2, 'REPARACIÓN DE CAÑERIAS', 'activo'),
  (3, 'MANTENIMIENTO DE MAQUINARIA', 'activo'),
  (4, 'COSECHAS', 'activo');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_trabajador`
--
CREATE TABLE `tb_trabajador` (
  `id_trabajador` bigint UNSIGNED NOT NULL,
  `id_persona` bigint UNSIGNED NOT NULL,
  `id_grupo` bigint UNSIGNED NOT NULL,
  `id_especialidad` bigint UNSIGNED NOT NULL,
  `name_user` varchar(100) NOT NULL,
  `pass_user` varchar(500) NOT NULL,
  `cod_recuperacion` varchar(500) DEFAULT NULL,
  `fecha_activacion` date DEFAULT NULL,
  `fecha_recuperacion` date DEFAULT NULL,
  `src_imagen` varchar(500) DEFAULT NULL,
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo',
  `flag_medico` tinyint(1) NOT NULL DEFAULT '0',
  `link_facebook` varchar(500) DEFAULT NULL,
  `link_instagram` varchar(500) DEFAULT NULL,
  `link_twitter` varchar(500) DEFAULT NULL,
  `descripcion` varchar(1000) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `tb_trabajador`
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
    1,
    '#',
    '#',
    '#',
    ''
  ),
  (
    2,
    4,
    2,
    1,
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
    1,
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
-- Estructura de tabla para la tabla `tb_trabajador_servicio`
--
CREATE TABLE `tb_trabajador_servicio` (
  `id` bigint UNSIGNED NOT NULL,
  `id_servicio` bigint UNSIGNED NOT NULL,
  `id_trabajador` bigint UNSIGNED NOT NULL
);

--
-- Volcado de datos para la tabla `tb_trabajador_servicio`
--
INSERT INTO
  `tb_trabajador_servicio` (`id`, `id_servicio`, `id_trabajador`)
VALUES
  (18, 1, 3),
  (19, 3, 3),
  (20, 1, 1),
  (21, 3, 1),
  (22, 5, 1),
  (23, 6, 1),
  (24, 1, 2),
  (25, 3, 2),
  (26, 5, 2),
  (27, 6, 2),
  (28, 7, 2);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_trabajador_sucursal`
--
CREATE TABLE `tb_trabajador_sucursal` (
  `id` bigint NOT NULL,
  `id_trabajador` bigint UNSIGNED DEFAULT NULL,
  `id_sucursal` int DEFAULT NULL
);

--
-- Volcado de datos para la tabla `tb_trabajador_sucursal`
--
INSERT INTO
  `tb_trabajador_sucursal` (`id`, `id_trabajador`, `id_sucursal`)
VALUES
  (1, 1, 1),
  (2, 2, 1),
  (3, 3, 1);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_unidad_medida`
--
CREATE TABLE `tb_unidad_medida` (
  `id_unidad_medida` int NOT NULL,
  `name_unidad` varchar(200) DEFAULT NULL,
  `cod_sunat` varchar(10) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `tb_unidad_medida`
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
  (3, 'CAJAS', 'BX', '1'),
  (4, 'HORAS', 'H', '1');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tb_vacuna`
--
CREATE TABLE `tb_vacuna` (
  `id_vacuna` bigint UNSIGNED NOT NULL,
  `id_tipo_mascota` bigint UNSIGNED NOT NULL,
  `name_vacuna` varchar(150) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `edad_minima` int NOT NULL DEFAULT '1',
  `edad_maxima` int DEFAULT NULL,
  `tipo` char(1) DEFAULT '0',
  `estado` enum('activo', 'inactivo') NOT NULL DEFAULT 'activo'
);

--
-- Volcado de datos para la tabla `tb_vacuna`
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
-- Estructura de tabla para la tabla `tb_venta`
--
CREATE TABLE `tb_venta` (
  `id_venta` int NOT NULL,
  `id_sucursal` int NOT NULL,
  `id_trabajador` bigint UNSIGNED NOT NULL,
  `id_documento_venta` int NOT NULL,
  `name_documento_venta` varchar(100) NOT NULL,
  `codigo_documento_venta` varchar(4) NOT NULL,
  `serie` varchar(4) NOT NULL,
  `correlativo` varchar(12) NOT NULL,
  `id_documento_cliente` bigint UNSIGNED NOT NULL,
  `name_documento_cliente` varchar(100) NOT NULL,
  `codigo_documento_cliente` varchar(4) NOT NULL,
  `numero_documento_cliente` varchar(30) NOT NULL,
  `id_forma_pago` int NOT NULL,
  `codigo_forma_pago` varchar(4) NOT NULL,
  `name_forma_pago` varchar(100) NOT NULL,
  `cliente` varchar(500) NOT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
  `descuento_total` decimal(18, 2) DEFAULT '0.00',
  `sub_total` decimal(18, 2) NOT NULL,
  `igv` decimal(18, 2) NOT NULL,
  `total` decimal(18, 2) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT '1',
  `pdf` varchar(500) DEFAULT NULL,
  `xml` varchar(500) DEFAULT NULL,
  `cdr` varchar(500) DEFAULT NULL,
  `mensaje_sunat` varchar(1000) DEFAULT NULL,
  `ruta` varchar(500) DEFAULT NULL,
  `token` varchar(500) DEFAULT NULL,
  `flag_doc_interno` char(1) NOT NULL DEFAULT '1',
  `monto_recibido` decimal(18, 2) DEFAULT NULL,
  `vuelto` decimal(18, 2) DEFAULT NULL,
  `id_moneda` int NOT NULL,
  `codigo_moneda` varchar(4) NOT NULL,
  `signo_moneda` varchar(10) DEFAULT NULL,
  `abreviatura_moneda` varchar(10) DEFAULT NULL,
  `signo_moneda_cambio` varchar(10) NOT NULL DEFAULT 'S/ ',
  `monto_tipo_cambio` decimal(18, 2) DEFAULT NULL,
  `observaciones` varchar(1000) DEFAULT NULL,
  `flag_enviado` char(1) DEFAULT '1'
);

--
-- Volcado de datos para la tabla `tb_venta`
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
    3,
    'TICKET DE SALIDA',
    '-',
    'TIK1',
    '45',
    1,
    'DNI',
    '1',
    '70570131',
    1,
    '01',
    'EFECTIVO',
    'EDUARDO DANIEL PERALES CUYA',
    '',
    '',
    '',
    '2024-11-28 00:00:00',
    NULL,
    7.00,
    7.00,
    1.26,
    8.26,
    '3',
    'NOK',
    'NOK',
    'NOK',
    '',
    'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4',
    'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc',
    '1',
    8.26,
    0.00,
    1,
    '1',
    'S/',
    'PEN',
    'S/ ',
    1.00,
    NULL,
    '1'
  ),
  (
    2,
    1,
    1,
    3,
    'TICKET DE SALIDA',
    '-',
    'TIK1',
    '46',
    3,
    'RUC',
    '6',
    '20608147307',
    1,
    '01',
    'EFECTIVO',
    'TECNOVO PERU SOLUCIONES S.A.C.  ',
    'CAL. GERMAN SCHEREIBER NRO. 276 INT. 240 URB. SANTA ANA, LIMA - LIMA - SAN ISIDRO',
    '',
    '',
    '2024-11-28 00:00:00',
    NULL,
    6.00,
    6.00,
    1.08,
    7.08,
    '2',
    'NOK',
    'NOK',
    'NOK',
    '',
    'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4',
    'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc',
    '1',
    7.08,
    0.00,
    1,
    '1',
    'S/',
    'PEN',
    'S/ ',
    1.00,
    NULL,
    '1'
  ),
  (
    3,
    1,
    1,
    3,
    'TICKET DE SALIDA',
    '-',
    'TIK1',
    '47',
    1,
    'DNI',
    '1',
    '70570251',
    1,
    '01',
    'EFECTIVO',
    'GONZALO JOSE PEREZ RAMIREZ ',
    '',
    '',
    '',
    '2024-11-28 00:00:00',
    NULL,
    2.00,
    2.00,
    0.36,
    2.36,
    '1',
    'NOK',
    'NOK',
    'NOK',
    NULL,
    'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4',
    'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc',
    '1',
    2.36,
    0.00,
    1,
    '1',
    'S/',
    'PEN',
    'S/ ',
    1.00,
    NULL,
    '0'
  ),
  (
    4,
    1,
    1,
    3,
    'TICKET DE SALIDA',
    '-',
    'TIK1',
    '47',
    1,
    'DNI',
    '1',
    '70470132',
    1,
    '01',
    'EFECTIVO',
    'GIOVANNA DAMIANA VALLE CALDERON',
    '',
    '',
    '',
    '2024-11-28 00:00:00',
    NULL,
    12.00,
    12.00,
    2.16,
    14.16,
    '2',
    'NOK',
    'NOK',
    'NOK',
    '',
    'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4',
    'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc',
    '1',
    14.16,
    0.00,
    1,
    '1',
    'S/',
    'PEN',
    'S/ ',
    1.00,
    NULL,
    '1'
  ),
  (
    5,
    1,
    1,
    3,
    'TICKET DE SALIDA',
    '-',
    'TIK1',
    '48',
    1,
    'DNI',
    '1',
    '70472318',
    1,
    '01',
    'EFECTIVO',
    'GREYSI YAMILIT VILCA GELDRES',
    '',
    '',
    '',
    '2024-11-29 00:00:00',
    NULL,
    1.00,
    1.00,
    0.18,
    1.18,
    '2',
    'NOK',
    'NOK',
    'NOK',
    '',
    'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4',
    'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc',
    '1',
    1.18,
    0.00,
    1,
    '1',
    'S/',
    'PEN',
    'S/ ',
    1.00,
    NULL,
    '1'
  ),
  (
    6,
    1,
    1,
    3,
    'TICKET DE SALIDA',
    '-',
    'TIK1',
    '49',
    1,
    'DNI',
    '1',
    '70367121',
    1,
    '01',
    'EFECTIVO',
    'SOL ARIATNA FLORES ARISTA',
    '',
    '',
    '',
    '2024-11-29 00:00:00',
    NULL,
    4.00,
    4.00,
    0.72,
    4.72,
    '2',
    'NOK',
    'NOK',
    'NOK',
    '',
    'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4',
    'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc',
    '1',
    4.72,
    0.00,
    1,
    '1',
    'S/',
    'PEN',
    'S/ ',
    1.00,
    NULL,
    '1'
  ),
  (
    7,
    1,
    1,
    3,
    'TICKET DE SALIDA',
    '-',
    'TIK1',
    '50',
    1,
    'DNI',
    '1',
    '70570131',
    1,
    '01',
    'EFECTIVO',
    'EDUARDO DANIEL PERALES CUYA',
    '',
    '',
    '',
    '2024-11-29 00:00:00',
    NULL,
    1.00,
    1.00,
    0.18,
    1.18,
    '2',
    'NOK',
    'NOK',
    'NOK',
    '',
    'https://www.pse.pe/api/v1/74142b6b76614a74a26d9b8e347d4ff8f3962e1276a9403fae3652c010416ba4',
    'eyJhbGciOiJIUzI1NiJ9.IjE2NDBjYTc5ODM1MzRkZTdhOWJjNGM3YzAxNmQ5NzRjYzY2MDJiY2RiMjE0NGNjYWEzMGFmODE3MjA1NWJkOGYi.IcO44mj7fdDqzDMhCymLuw0l0PrKfnhAcUwERs_Smjc',
    '1',
    1.18,
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
  `apellidos_cliente` varchar(100),
  `correo_cliente` varchar(150),
  `direccion_cliente` varchar(150),
  `estado` enum('activo', 'inactivo'),
  `fecha_nacimiento_cliente` date,
  `id_cliente` bigint unsigned,
  `id_documento` bigint unsigned,
  `id_persona` bigint unsigned,
  `name_documento` varchar(100),
  `nombres_cliente` varchar(100),
  `num_documento` varchar(30),
  `sexo_cliente` enum('masculino', 'femenino'),
  `src_imagen` varchar(500),
  `telefono_cliente` varchar(30)
);

-- --------------------------------------------------------
--
-- Estructura Stand-in para la vista `vw_mascotas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_mascotas` (
  `apellidos` varchar(100),
  `color` varchar(50),
  `correo` varchar(150),
  `direccion` varchar(150),
  `estado` enum('activo', 'inactivo'),
  `fecha_nacimiento` date,
  `id_cliente` bigint unsigned,
  `id_documento` bigint unsigned,
  `id_mascota` bigint unsigned,
  `id_tipo_mascota` bigint unsigned,
  `name_documento` varchar(100),
  `name_tipo` varchar(50),
  `nombre` varchar(100),
  `nombres` varchar(100),
  `num_documento` varchar(30),
  `observaciones` varchar(1000),
  `peso` varchar(50),
  `raza` varchar(50),
  `sexo` enum('hembra', 'macho'),
  `src_imagen` varchar(150),
  `telefono` varchar(30)
);

-- --------------------------------------------------------
--
-- Estructura Stand-in para la vista `vw_operadores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_operadores` (
  `correo_operador` varchar(150),
  `direccion_operador` varchar(150),
  `estado_operador` enum('activo', 'inactivo'),
  `fecha_nacimiento_operador` date,
  `id_documento_operador` bigint unsigned,
  `id_operador` bigint unsigned,
  `id_persona_operador` bigint unsigned,
  `nombre_operador` varchar(201),
  `num_documento_operador` varchar(30),
  `sexo_operador` enum('masculino', 'femenino'),
  `src_imagen_operador` varchar(500),
  `telefono_operador` varchar(30)
);

-- --------------------------------------------------------
--
-- Estructura Stand-in para la vista `vw_orden_compra`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_orden_compra` (
  `cantidad_ingresada` int,
  `cantidad_solicitada` int,
  `cod_producto` int,
  `estado` varchar(14),
  `estado_int` char(1),
  `fecha_entrega` datetime,
  `fecha_orden` datetime,
  `id_metodo_envio` int,
  `id_moneda` int,
  `id_orden_compra` int,
  `id_proveedor` int,
  `id_sucursal` int,
  `name_producto` varchar(100),
  `name_tabla` varchar(100),
  `nombre_proveedor` varchar(201),
  `notas` varchar(237),
  `observaciones` varchar(500),
  `precio_unitario` decimal(18, 2),
  `src_imagen_producto` varchar(150),
  `src_imagen_proveedor` varchar(300),
  `stock` int,
  `total` decimal(28, 2)
);

-- --------------------------------------------------------
--
-- Estructura Stand-in para la vista `vw_productos_agotados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_productos_agotados` (
  `descripcion_producto` varchar(100),
  `name_unidad` varchar(10),
  `nombre_sucursal` varchar(300),
  `stock` int,
  `stock_minimo` int
);

-- --------------------------------------------------------
--
-- Estructura Stand-in para la vista `vw_proveedor`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_proveedor` (
  `correo_proveedor` varchar(150),
  `direccion_proveedor` varchar(150),
  `estado_proveedor` char(1),
  `fecha_nacimiento_proveedor` date,
  `id_documento_proveedor` bigint unsigned,
  `id_persona_proveedor` bigint unsigned,
  `id_proveedor` int,
  `nombre_proveedor` varchar(201),
  `num_documento_proveedor` varchar(30),
  `sexo_proveedor` enum('masculino', 'femenino'),
  `src_imagen_proveedor` varchar(300),
  `telefono_proveedor` varchar(30)
);

-- --------------------------------------------------------
--
-- Estructura Stand-in para la vista `vw_trabajadores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_trabajadores` (
  `apellidos_trabajador` varchar(100),
  `cod_recuperacion` varchar(500),
  `correo_trabajador` varchar(150),
  `descripcion` varchar(1000),
  `direccion_trabajador` varchar(150),
  `estado` enum('activo', 'inactivo'),
  `fecha_activacion` date,
  `fecha_nacimiento_trabajador` date,
  `fecha_recuperacion` date,
  `flag_medico` tinyint(1),
  `id_documento` bigint unsigned,
  `id_especialidad` bigint unsigned,
  `id_grupo` bigint unsigned,
  `id_persona` bigint unsigned,
  `id_trabajador` bigint unsigned,
  `link_facebook` varchar(500),
  `link_instagram` varchar(500),
  `link_twitter` varchar(500),
  `name_documento_trabajador` varchar(100),
  `name_user` varchar(100),
  `nombres_trabajador` varchar(100),
  `num_documento` varchar(30),
  `pass_user` varchar(500),
  `sexo_trabajador` enum('masculino', 'femenino'),
  `src_imagen` varchar(500),
  `telefono_trabajador` varchar(30)
);

-- --------------------------------------------------------
--
-- Estructura para la vista `vw_clientes`
--
DROP TABLE IF EXISTS `vw_clientes`;

CREATE  VIEW `vw_clientes` AS
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
-- Estructura para la vista `vw_mascotas`
--
DROP TABLE IF EXISTS `vw_mascotas`;

CREATE  VIEW `vw_mascotas` AS
SELECT
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
FROM
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
-- Estructura para la vista `vw_operadores`
--
DROP TABLE IF EXISTS `vw_operadores`;

CREATE  VIEW `vw_operadores` AS
SELECT
  `o`.`id_operador` AS `id_operador`,
  `o`.`id_persona` AS `id_persona_operador`,
  `o`.`estado` AS `estado_operador`,
  `p`.`id_documento` AS `id_documento_operador`,
  `p`.`num_documento` AS `num_documento_operador`,
  concat(`p`.`nombres`, ' ', `p`.`apellidos`) AS `nombre_operador`,
  `p`.`direccion` AS `direccion_operador`,
  `p`.`telefono` AS `telefono_operador`,
  `p`.`correo` AS `correo_operador`,
  `p`.`fecha_nacimiento` AS `fecha_nacimiento_operador`,
  `p`.`sexo` AS `sexo_operador`,
  `o`.`src_imagen` AS `src_imagen_operador`
FROM
  (
    `tb_operador` `o`
    join `tb_persona` `p` on((`o`.`id_persona` = `p`.`id_persona`))
  );

-- --------------------------------------------------------
--
-- Estructura para la vista `vw_orden_compra`
--
DROP TABLE IF EXISTS `vw_orden_compra`;

CREATE  VIEW `vw_orden_compra` AS
SELECT
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
FROM
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
-- Estructura para la vista `vw_productos_agotados`
--
DROP TABLE IF EXISTS `vw_productos_agotados`;

CREATE  VIEW `vw_productos_agotados` AS
SELECT
  `m`.`name_medicamento` AS `descripcion_producto`,
  `m`.`stock` AS `stock`,
  `m`.`stock_minimo` AS `stock_minimo`,
  `s`.`nombre` AS `nombre_sucursal`,
  `u`.`cod_sunat` AS `name_unidad`
FROM
  (
    (
      `tb_medicamento` `m`
      join `tb_sucursal` `s` on((`s`.`id_sucursal` = `m`.`id_sucursal`))
    )
    join `tb_unidad_medida` `u` on(
      (`u`.`id_unidad_medida` = `m`.`id_unidad_medida`)
    )
  )
WHERE
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
-- Estructura para la vista `vw_proveedor`
--
DROP TABLE IF EXISTS `vw_proveedor`;

CREATE  VIEW `vw_proveedor` AS
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
    `tb_persona` `p`
    join `tb_proveedor` `pr` on((`pr`.`id_persona` = `p`.`id_persona`))
  );

-- --------------------------------------------------------
--
-- Estructura para la vista `vw_trabajadores`
--
DROP TABLE IF EXISTS `vw_trabajadores`;

CREATE  VIEW `vw_trabajadores` AS
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
  KEY `id_sucursal` (`id_sucursal`),
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
-- Indices de la tabla `tb_cita`
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
  KEY `id_sucursal` (`id_sucursal`);

--
-- Indices de la tabla `tb_cliente`
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
-- Indices de la tabla `tb_cliente_fundo`
--
ALTER TABLE
  `tb_cliente_fundo`
ADD
  PRIMARY KEY (`id`);

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
-- Indices de la tabla `tb_detalle_cita`
--
ALTER TABLE
  `tb_detalle_cita`
ADD
  PRIMARY KEY (`id_detalle`),
ADD
  KEY `id_cita` (`id_cita`);

--
-- Indices de la tabla `tb_detalle_compra`
--
ALTER TABLE
  `tb_detalle_compra`
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
  KEY `id_sucursal` (`id_sucursal`);

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
-- Indices de la tabla `tb_especialidad`
--
ALTER TABLE
  `tb_especialidad`
ADD
  PRIMARY KEY (`id_especialidad`);

--
-- Indices de la tabla `tb_forma_pago`
--
ALTER TABLE
  `tb_forma_pago`
ADD
  PRIMARY KEY (`id_forma_pago`);

--
-- Indices de la tabla `tb_galeria`
--
ALTER TABLE
  `tb_galeria`
ADD
  PRIMARY KEY (`id`);

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
-- Indices de la tabla `tb_maquinaria`
--
ALTER TABLE
  `tb_maquinaria`
ADD
  PRIMARY KEY (`id_maquinaria`);

--
-- Indices de la tabla `tb_mascota`
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
-- Indices de la tabla `tb_mascota_vacuna`
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
-- Indices de la tabla `tb_medicamento`
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
-- Indices de la tabla `tb_orden_compra`
--
ALTER TABLE
  `tb_orden_compra`
ADD
  PRIMARY KEY (`id_orden_compra`);

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
-- Indices de la tabla `tb_promocion`
--
ALTER TABLE
  `tb_promocion`
ADD
  PRIMARY KEY (`id_promocion`),
ADD
  KEY `id_cliente` (`id_cliente`);

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
-- Indices de la tabla `tb_proveedor_observaciones`
--
ALTER TABLE
  `tb_proveedor_observaciones`
ADD
  PRIMARY KEY (`id_detalle`),
ADD
  KEY `id_proveedor` (`id_proveedor`);

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
  KEY `id_moneda` (`id_moneda`),
ADD
  KEY `fk_id_maquinaria` (`id_maquinaria`);

--
-- Indices de la tabla `tb_sucursal`
--
ALTER TABLE
  `tb_sucursal`
ADD
  PRIMARY KEY (`id_sucursal`),
ADD
  KEY `id_empresa` (`id_empresa`);

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
-- Indices de la tabla `tb_tipo_mascota`
--
ALTER TABLE
  `tb_tipo_mascota`
ADD
  PRIMARY KEY (`id_tipo_mascota`);

--
-- Indices de la tabla `tb_tipo_medicamento`
--
ALTER TABLE
  `tb_tipo_medicamento`
ADD
  PRIMARY KEY (`id_tipo_medicamento`);

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
  KEY `fktb_trabajador_tbgrupousuario` (`id_grupo`),
ADD
  KEY `fktb_trabajador_tbespecialidad` (`id_especialidad`);

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
  KEY `id_sucursal` (`id_sucursal`);

--
-- Indices de la tabla `tb_unidad_medida`
--
ALTER TABLE
  `tb_unidad_medida`
ADD
  PRIMARY KEY (`id_unidad_medida`);

--
-- Indices de la tabla `tb_vacuna`
--
ALTER TABLE
  `tb_vacuna`
ADD
  PRIMARY KEY (`id_vacuna`),
ADD
  KEY `tb_vacuna_id_tipo_mascota_foreign` (`id_tipo_mascota`);

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
-- AUTO_INCREMENT de la tabla `tb_cita`
--
ALTER TABLE
  `tb_cita`
MODIFY
  `id_cita` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 13;

--
-- AUTO_INCREMENT de la tabla `tb_cliente`
--
ALTER TABLE
  `tb_cliente`
MODIFY
  `id_cliente` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 24;

--
-- AUTO_INCREMENT de la tabla `tb_cliente_fundo`
--
ALTER TABLE
  `tb_cliente_fundo`
MODIFY
  `id` bigint NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT de la tabla `tb_compra`
--
ALTER TABLE
  `tb_compra`
MODIFY
  `id_compra` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_cita`
--
ALTER TABLE
  `tb_detalle_cita`
MODIFY
  `id_detalle` bigint NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 13;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_compra`
--
ALTER TABLE
  `tb_detalle_compra`
MODIFY
  `id_detalle` bigint NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 32;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_ingreso`
--
ALTER TABLE
  `tb_detalle_ingreso`
MODIFY
  `id_detalle` bigint NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;

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
-- AUTO_INCREMENT de la tabla `tb_especialidad`
--
ALTER TABLE
  `tb_especialidad`
MODIFY
  `id_especialidad` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 10;

--
-- AUTO_INCREMENT de la tabla `tb_forma_pago`
--
ALTER TABLE
  `tb_forma_pago`
MODIFY
  `id_forma_pago` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT de la tabla `tb_galeria`
--
ALTER TABLE
  `tb_galeria`
MODIFY
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT de la tabla `tb_grupo_usuario`
--
ALTER TABLE
  `tb_grupo_usuario`
MODIFY
  `id_grupo` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de la tabla `tb_maquinaria`
--
ALTER TABLE
  `tb_maquinaria`
MODIFY
  `id_maquinaria` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT de la tabla `tb_mascota`
--
ALTER TABLE
  `tb_mascota`
MODIFY
  `id_mascota` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT de la tabla `tb_mascota_vacuna`
--
ALTER TABLE
  `tb_mascota_vacuna`
MODIFY
  `id_mascota_vacuna` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT de la tabla `tb_medicamento`
--
ALTER TABLE
  `tb_medicamento`
MODIFY
  `id_medicamento` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de la tabla `tb_moneda`
--
ALTER TABLE
  `tb_moneda`
MODIFY
  `id_moneda` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de la tabla `tb_persona`
--
ALTER TABLE
  `tb_persona`
MODIFY
  `id_persona` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 29;

--
-- AUTO_INCREMENT de la tabla `tb_promocion`
--
ALTER TABLE
  `tb_promocion`
MODIFY
  `id_promocion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_proveedor`
--
ALTER TABLE
  `tb_proveedor`
MODIFY
  `id_proveedor` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT de la tabla `tb_proveedor_observaciones`
--
ALTER TABLE
  `tb_proveedor_observaciones`
MODIFY
  `id_detalle` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_servicio`
--
ALTER TABLE
  `tb_servicio`
MODIFY
  `id_servicio` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT de la tabla `tb_sucursal`
--
ALTER TABLE
  `tb_sucursal`
MODIFY
  `id_sucursal` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT de la tabla `tb_tipo_cambio`
--
ALTER TABLE
  `tb_tipo_cambio`
MODIFY
  `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de la tabla `tb_tipo_mascota`
--
ALTER TABLE
  `tb_tipo_mascota`
MODIFY
  `id_tipo_mascota` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de la tabla `tb_tipo_medicamento`
--
ALTER TABLE
  `tb_tipo_medicamento`
MODIFY
  `id_tipo_medicamento` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 7;

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
  AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de la tabla `tb_trabajador_servicio`
--
ALTER TABLE
  `tb_trabajador_servicio`
MODIFY
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 29;

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
  AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT de la tabla `tb_vacuna`
--
ALTER TABLE
  `tb_vacuna`
MODIFY
  `id_vacuna` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 11;

--
-- AUTO_INCREMENT de la tabla `tb_venta`
--
ALTER TABLE
  `tb_venta`
MODIFY
  `id_venta` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 22;


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
-- Filtros para la tabla `tb_acceso_opcion`
--
ALTER TABLE
  `tb_acceso_opcion`
ADD
  CONSTRAINT `tb_acceso_opcion_id_grupo_foreign` FOREIGN KEY (`id_grupo`) REFERENCES `tb_grupo_usuario` (`id_grupo`),
ADD
  CONSTRAINT `tb_acceso_opcion_id_opcion_foreign` FOREIGN KEY (`id_opcion`) REFERENCES `tb_opcion` (`id_opcion`);

--
-- Filtros para la tabla `tb_cita`
--
ALTER TABLE
  `tb_cita`
ADD
  CONSTRAINT `tb_cita_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
ADD
  CONSTRAINT `tb_cita_id_servicio_foreign` FOREIGN KEY (`id_servicio`) REFERENCES `tb_servicio` (`id_servicio`),
ADD
  CONSTRAINT `tb_cita_id_trabajador_foreign` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

--
-- Filtros para la tabla `tb_cliente`
--
ALTER TABLE
  `tb_cliente`
ADD
  CONSTRAINT `tb_cliente_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`);

--
-- Filtros para la tabla `tb_compra`
--
ALTER TABLE
  `tb_compra`
ADD
  CONSTRAINT `tb_compra_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
ADD
  CONSTRAINT `tb_compra_ibfk_2` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

--
-- Filtros para la tabla `tb_detalle_cita`
--
ALTER TABLE
  `tb_detalle_cita`
ADD
  CONSTRAINT `tb_detalle_cita_ibfk_1` FOREIGN KEY (`id_cita`) REFERENCES `tb_cita` (`id_cita`);

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
  CONSTRAINT `tb_documento_venta_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`);

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
-- Filtros para la tabla `tb_mascota`
--
ALTER TABLE
  `tb_mascota`
ADD
  CONSTRAINT `tb_mascota_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id_cliente`),
ADD
  CONSTRAINT `tb_mascota_id_tipo_mascota_foreign` FOREIGN KEY (`id_tipo_mascota`) REFERENCES `tb_tipo_mascota` (`id_tipo_mascota`);

--
-- Filtros para la tabla `tb_mascota_vacuna`
--
ALTER TABLE
  `tb_mascota_vacuna`
ADD
  CONSTRAINT `tb_mascota_vacuna_id_mascota_foreign` FOREIGN KEY (`id_mascota`) REFERENCES `tb_mascota` (`id_mascota`),
ADD
  CONSTRAINT `tb_mascota_vacuna_id_vacuna_foreign` FOREIGN KEY (`id_vacuna`) REFERENCES `tb_vacuna` (`id_vacuna`);

--
-- Filtros para la tabla `tb_medicamento`
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
-- Filtros para la tabla `tb_persona`
--
ALTER TABLE
  `tb_persona`
ADD
  CONSTRAINT `fk_tbpersona_documento_ident` FOREIGN KEY (`id_documento`) REFERENCES `tb_documento_identidad` (`id_documento`);

--
-- Filtros para la tabla `tb_promocion`
--
ALTER TABLE
  `tb_promocion`
ADD
  CONSTRAINT `tb_promocion_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id_cliente`);

--
-- Filtros para la tabla `tb_proveedor`
--
ALTER TABLE
  `tb_proveedor`
ADD
  CONSTRAINT `tb_proveedor_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `tb_persona` (`id_persona`);

--
-- Filtros para la tabla `tb_proveedor_observaciones`
--
ALTER TABLE
  `tb_proveedor_observaciones`
ADD
  CONSTRAINT `tb_proveedor_observaciones_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `tb_proveedor` (`id_proveedor`);

--
-- Filtros para la tabla `tb_servicio`
--
ALTER TABLE
  `tb_servicio`
ADD
  CONSTRAINT `fk_id_maquinaria` FOREIGN KEY (`id_maquinaria`) REFERENCES `tb_maquinaria` (`id_maquinaria`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `fk_tbtiposervicio_servicio` FOREIGN KEY (`id_tipo_servicio`) REFERENCES `tb_tipo_servicio` (`id_tipo_servicio`),
ADD
  CONSTRAINT `tb_servicio_ibfk_1` FOREIGN KEY (`id_moneda`) REFERENCES `tb_moneda` (`id_moneda`);

--
-- Filtros para la tabla `tb_sucursal`
--
ALTER TABLE
  `tb_sucursal`
ADD
  CONSTRAINT `tb_sucursal_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `tb_empresa` (`id_empresa`);

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
  CONSTRAINT `fktb_trabajador_tbespecialidad` FOREIGN KEY (`id_especialidad`) REFERENCES `tb_especialidad` (`id_especialidad`),
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
-- Filtros para la tabla `tb_trabajador_sucursal`
--
ALTER TABLE
  `tb_trabajador_sucursal`
ADD
  CONSTRAINT `tb_trabajador_sucursal_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
ADD
  CONSTRAINT `tb_trabajador_sucursal_ibfk_2` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

--
-- Filtros para la tabla `tb_vacuna`
--
ALTER TABLE
  `tb_vacuna`
ADD
  CONSTRAINT `tb_vacuna_id_tipo_mascota_foreign` FOREIGN KEY (`id_tipo_mascota`) REFERENCES `tb_tipo_mascota` (`id_tipo_mascota`);

--
-- Filtros para la tabla `tb_venta`
--
ALTER TABLE
  `tb_venta`
ADD
  CONSTRAINT `tb_venta_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `tb_sucursal` (`id_sucursal`),
ADD
  CONSTRAINT `tb_venta_ibfk_2` FOREIGN KEY (`id_trabajador`) REFERENCES `tb_trabajador` (`id_trabajador`);

ALTER TABLE `tb_servicio` ADD `id_unidad_medida` INT NULL AFTER `id_maquinaria`;

ALTER TABLE `tb_persona`
ADD COLUMN `apodo` varchar(100) NULL;

ALTER TABLE `tb_cliente`
CHANGE `name_user` `name_user` varchar(100) NULL,
CHANGE `pass_user` `pass_user` varchar(500) NULL;

ALTER TABLE `tb_accesorio` ADD `flag_consumo` ENUM('SI','NO') NULL DEFAULT 'SI';

UPDATE `tb_opcion` SET `name_opcion` = 'Reporte de Clientes', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 708;

ALTER TABLE `tb_documento_venta` ADD `flag_ingreso` CHAR(1) NULL DEFAULT NULL AFTER `flag_doc_interno`, 
ADD `flag_salida` CHAR(1) NULL DEFAULT NULL AFTER `flag_ingreso`;

ALTER TABLE `tb_ingreso` ADD `src_evidencia` VARCHAR(500) NULL AFTER `estado`;

ALTER TABLE `tb_ingreso` ADD `total` DECIMAL(18,2) NULL AFTER `src_evidencia`;

CREATE TABLE `tb_pago` (
  `id_pago` INT NOT NULL AUTO_INCREMENT,
  `id_ingreso` INT NOT NULL,
  `id_forma_pago` INT NOT NULL,
  `monto_pagado` DECIMAL(18,2) DEFAULT NULL,
  `monto_pendiente` DECIMAL(18,2) DEFAULT NULL,
  PRIMARY KEY (`id_pago`)
);

ALTER TABLE `tb_trabajador`
CHANGE `name_user` `name_user` varchar(100) NULL,
CHANGE `pass_user` `pass_user` varchar(500) NULL;

ALTER TABLE `tb_pago` ADD `fecha_pago` DATETIME NULL AFTER `id_forma_pago`;

ALTER TABLE `tb_pago` CHANGE `id_ingreso` `id_ingreso` INT NULL;
ALTER TABLE `tb_pago` CHANGE `id_forma_pago` `id_forma_pago` INT NULL;
ALTER TABLE `tb_pago` CHANGE `monto_pagado` `monto_pagado` DECIMAL(18,2) NULL;
ALTER TABLE `tb_pago` CHANGE `monto_pagado` `monto_pagado` DECIMAL(18,2) NULL;

ALTER TABLE `tb_ingreso` CHANGE `total` `total_ing` DECIMAL(18,2) NULL DEFAULT NULL;

ALTER TABLE `tb_pago` CHANGE `monto_pendiente` `src_factura` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

COMMIT;
