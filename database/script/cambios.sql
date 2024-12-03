

ALTER TABLE `tb_accesorio` CHANGE `flag_consumo` `flag_consumo` ENUM('SI','NO') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT 'SI';


-- Para el reporte de clientes
UPDATE `tb_opcion` SET `name_opcion` = 'Reporte de Clientes', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 708;