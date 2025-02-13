

--Para hacer visible el reporte de Clientes por Cobrar
UPDATE `tb_opcion` SET `name_opcion` = 'Clientes por Cobrar', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 710;

UPDATE `tb_acceso_opcion` SET `flag_agregar` = '1', `flag_buscar` = '1', `flag_editar` = '1', `flag_eliminar` = '1', `flag_anular` = '1', `flag_ver` = '1', `flag_descargar` = '1' WHERE `tb_acceso_opcion`.`id` = 187;

--Cambios en el tb_detalle_gastoserv
ALTER TABLE tb_detalle_gastoserv
ADD COLUMN id_tipo_gasto INT NULL,
ADD COLUMN cantidad DECIMAL(10,2) NULL,
ADD COLUMN precio_unitario DECIMAL(10,2) NULL,

