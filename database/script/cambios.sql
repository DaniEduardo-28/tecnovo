
CREATE TABLE `tb_maquinaria` (
  `id_maquinaria` bigint UNSIGNED NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `observaciones` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
);
ALTER TABLE `tb_maquinaria` CHANGE `id_maquinaria` `id_maquinaria` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id_maquinaria`);

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
);


UPDATE `tb_opcion` SET `name_opcion` = 'Fundos', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 209;


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
) ;

UPDATE `tb_opcion` SET `name_opcion` = 'Operador', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 210;

ALTER TABLE `tb_maquinaria` ADD `id_operador` INT NOT NULL AFTER `id_maquinaria`;

UPDATE `tb_opcion` SET `name_opcion` = 'Maquinaria', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 211;


CREATE VIEW vw_operadores AS SELECT
    o.id_operador AS id_operador,
    o.id_persona AS id_persona_operador,
    o.estado AS estado_operador,
    p.id_documento AS id_documento_operador,
    p.num_documento AS num_documento_operador,
    CONCAT(p.nombres, ' ', p.apellidos) AS nombre_operador,
    p.direccion AS direccion_operador,
    p.telefono AS telefono_operador,
    p.correo AS correo_operador,
    p.fecha_nacimiento AS fecha_nacimiento_operador,
    p.sexo AS sexo_operador,
    o.src_imagen AS src_imagen_operador
FROM
    tb_operador o
JOIN tb_persona p ON
    o.id_persona = p.id_persona;

-- TABLA DE RELACIÓN tb_cliente_fundo

CREATE TABLE `tb_cliente_fundo` (
  `id` bigint NOT NULL,
  `id_cliente` bigint UNSIGNED DEFAULT NULL,
  `id_fundo` int DEFAULT NULL,
  `cantidad_hc` float DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
 -- ID volverla PRIMARY KEY
ALTER TABLE `tb_cliente_fundo` CHANGE `id` `id` BIGINT NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
 -- Añadir su número de opción
UPDATE `tb_opcion` SET `name_opcion` = 'Acceso a Fundos', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 212;

-- Añadir las siguientes vistas
-- Vista de clientes
CREATE VIEW vw_clientes AS SELECT
    t.id_cliente AS id_cliente,
    t.id_persona AS id_persona,
    t.src_imagen AS src_imagen,
    t.estado AS estado,
    p.id_documento AS id_documento,
    p.num_documento AS num_documento,
    p.nombres AS nombres_cliente,
    p.apellidos AS apellidos_cliente,
    p.direccion AS direccion_cliente,
    p.telefono AS telefono_cliente,
    p.correo AS correo_cliente,
    p.fecha_nacimiento AS fecha_nacimiento_cliente,
    p.sexo AS sexo_cliente,
    d.name_documento AS name_documento
FROM
    (
        (
            syscos.tb_cliente t
        JOIN syscos.tb_persona p
        ON
            ((p.id_persona = t.id_persona))
        )
    JOIN syscos.tb_documento_identidad d
    ON
        (
            (
                d.id_documento = p.id_documento
            )
        )
    )

-- agregar la nueva unidad de medida de tiempo para medir el 
    INSERT INTO `tb_unidad_medida` (`id_unidad_medida`, `name_unidad`, `cod_sunat`, `estado`) VALUES (NULL, 'HORAS', 'H', '1');

 -- Convertir id_maquinaria en llave foránea
    ALTER TABLE tb_servicio ADD CONSTRAINT fk_id_maquinaria FOREIGN KEY (id_maquinaria) REFERENCES tb_maquinaria (id_maquinaria) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `tb_servicio` ADD `id_maquinaria` INT NOT NULL AFTER `id_tipo_servicio`;
    ALTER TABLE tb_cita DROP FOREIGN KEY tb_cita_id_mascota_foreign;



UPDATE `tb_opcion` SET `name_opcion` = 'Tipo de Cosecha', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 115;


-- Estructura de tabla para la tabla `tb_tipo_cosecha`
--
CREATE TABLE `tb_tipo_cosecha` (
  `id_tipo_cosecha` bigint UNSIGNED NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` enum('activo', 'inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'activo'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Cambio en la tabla tb_maquinaria
ALTER TABLE `tb_maquinaria` CHANGE `id_operador` `id_trabajador` INT NOT NULL;

ALTER TABLE `tb_detalle_venta` CHANGE `precio_unitario` `precio_unitario` DECIMAL(18,2) NULL DEFAULT NULL;
ALTER TABLE `tb_detalle_venta` CHANGE `sub_total` `sub_total` DECIMAL(18,2) NULL DEFAULT '0.00';
ALTER TABLE `tb_detalle_venta` CHANGE `descuento` `descuento` DECIMAL(18,2) NULL DEFAULT '0.00';
ALTER TABLE `tb_detalle_venta` CHANGE `tipo_igv` `tipo_igv` VARCHAR(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `tb_detalle_venta` CHANGE `igv` `igv` DECIMAL(18,2) NULL DEFAULT '0.00';
ALTER TABLE `tb_detalle_venta` CHANGE `total` `total` DECIMAL(18,2) NULL DEFAULT '0.00';

--Agregando la columna notas

ALTER TABLE `tb_detalle_venta` ADD `notas` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `total`;

UPDATE `tb_opcion` SET `name_opcion` = 'Reporte de Citas', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 707;

-- Hacer que id_trabajador acepte valores nulos
ALTER TABLE tb_maquinaria MODIFY id_trabajador INT NULL;