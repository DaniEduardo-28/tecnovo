

ALTER TABLE `tb_accesorio` CHANGE `flag_consumo` `flag_consumo` ENUM('SI','NO') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT 'SI';


-- Para el reporte de clientes
UPDATE `tb_opcion` SET `name_opcion` = 'Reporte de Clientes', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 708;

-- Agregar los dos nuevos checks para Documento de Ingreso y Salida
ALTER TABLE `tb_documento_venta` ADD `flag_ingreso` CHAR(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `flag_doc_interno`, 
ADD `flag_salida` CHAR(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `flag_ingreso`;

-- Añadir comprobante de boleta o factura en el registro de ingresos
ALTER TABLE `tb_ingreso` ADD `src_evidencia` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL AFTER `estado`;


ALTER TABLE `tb_ingreso` ADD `total` DECIMAL(18,2) NULL AFTER `src_evidencia`;

CREATE TABLE `tb_pago` (
  `id_pago` INT NOT NULL AUTO_INCREMENT,
  `id_ingreso` INT NOT NULL,
  `id_forma_pago` INT NOT NULL,
  `monto_pagado` DECIMAL(18,2) DEFAULT NULL,
  `monto_pendiente` DECIMAL(18,2) DEFAULT NULL,
  PRIMARY KEY (`id_pago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
