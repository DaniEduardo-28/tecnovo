-- Añadir una relación para Unidad de Negocio
ALTER TABLE `tb_maquinaria`
ADD `id_tipo_servicio` bigint(20) NOT NULL AFTER `id_trabajador`;
ALTER TABLE `tb_maquinaria` CHANGE `id_tipo_servicio` `id_tipo_servicio` BIGINT(20) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `tb_maquinaria` ADD CONSTRAINT `fk_maquinaria_tipo_servicio` FOREIGN KEY (`id_tipo_servicio`)
 REFERENCES `tb_tipo_servicio`(`id_tipo_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;

-- añadir el campo de pago_operador
 ALTER TABLE tb_servicio ADD COLUMN pago_operador DECIMAL(8,2) NULL DEFAULT 0.00 AFTER precio;

 