

ALTER TABLE `tb_accesorio` CHANGE `flag_consumo` `flag_consumo` ENUM('SI','NO') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT 'SI';


-- Para el reporte de clientes
UPDATE `tb_opcion` SET `name_opcion` = 'Reporte de Clientes', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 708;

-- Agregar los dos nuevos checks para Documento de Ingreso y Salida
ALTER TABLE `tb_documento_venta` ADD `flag_ingreso` CHAR(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `flag_doc_interno`, 
ADD `flag_salida` CHAR(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `flag_ingreso`;

