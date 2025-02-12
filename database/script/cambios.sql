-- Añadir una relación para Unidad de Negocio
ALTER TABLE `tb_maquinaria`
ADD `id_tipo_servicio` bigint(20) NOT NULL AFTER `id_trabajador`;
ALTER TABLE `tb_maquinaria` CHANGE `id_tipo_servicio` `id_tipo_servicio` BIGINT(20) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `tb_maquinaria` ADD CONSTRAINT `fk_maquinaria_tipo_servicio` FOREIGN KEY (`id_tipo_servicio`)
 REFERENCES `tb_tipo_servicio`(`id_tipo_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;

-- añadir el campo de pago_operador
 ALTER TABLE tb_servicio ADD COLUMN pago_operador DECIMAL(8,2) NULL DEFAULT 0.00 AFTER precio;
 
 -- añadir el campo de fecha de pago en tb_cronograma
 ALTER TABLE `tb_cronograma` ADD `fecha_pago` DATETIME(2) NULL AFTER `fecha_salida`;

-- campo de cantidad_restante para llamarlo en funcion de estoao
 ALTER TABLE tb_cronograma ADD COLUMN cantidad_restante DECIMAL(10,2) NULL DEFAULT NULL;

-- cambiarlo para llamar a la tb_forma_pago
 ALTER TABLE `tb_pagos_clientes` CHANGE `metodo_pago` `metodo_pago` INT NULL DEFAULT NULL;

ALTER TABLE `tb_cronograma_maquinaria` CHANGE `id_maquinaria` `id_maquinaria` BIGINT UNSIGNED NULL;

-- Nueva tabla tb_tipo_gasto
CREATE TABLE tb_tipo_gasto (
    id_tipo_gasto BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_tipo_servicio BIGINT UNSIGNED NOT NULL,
    desc_gasto VARCHAR(500) NULL,
    estado ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
--Llave foránea para id_tipo_servicio
ALTER TABLE tb_tipo_gasto ADD CONSTRAINT fk_tipo_servicio FOREIGN KEY (id_tipo_servicio) REFERENCES tb_tipo_servicio(id_tipo_servicio) ON DELETE CASCADE;

INSERT INTO `tb_opcion` (`id_opcion`, `name_opcion`, `estado`, `url`, `order`, `icono`) VALUES ('116', 'Tipos de Gastos', 'activo', NULL, '0', NULL);

INSERT INTO `tb_acceso_opcion` (`id`, `id_grupo`, `id_opcion`, `flag_agregar`, `flag_buscar`, `flag_editar`, `flag_eliminar`, `flag_anular`, `flag_ver`, `flag_descargar`) VALUES (NULL, '1', '116', '0', '0', '0', '0', '0', '0', '0');

--Nueva opción
UPDATE `tb_opcion` SET `name_opcion` = 'Gastos de Servicios', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 606;

CREATE TABLE tb_gasto_servicio (
    id_gasto_servicio INT AUTO_INCREMENT PRIMARY KEY,
    id_proveedor INT NOT NULL,
    id_trabajador INT NOT NULL,
    id_sucursal INT NOT NULL,
    fecha_emision DATETIME NOT NULL,
    id_moneda INT NOT NULL,
    estado CHAR(1) NOT NULL,
    id_tipo_gasto INT NOT NULL,
    id_documento_venta INT NOT NULL,
    serie VARCHAR(10) NOT NULL,
    correlativo VARCHAR(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE tb_detalle_gastoserv (
    id_detalle_gastoserv BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_gasto_servicio INT NOT NULL,
    descripcion_gasto VARCHAR(500) NOT NULL,
    monto_gastado DECIMAL(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE tb_pagos_gastos (
    id_pago_gasto BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_gasto_servicio INT NOT NULL,
    fecha_pago DATE NOT NULL,
    monto DECIMAL(10,2) NULL,
    metodo_pago INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
