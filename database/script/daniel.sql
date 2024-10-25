-- Añadir la columna id_operador en la tabla tb_maquinaria
ALTER TABLE `tb_maquinaria` ADD `id_operador` BIGINT UNSIGNED NOT NULL AFTER `estado`;

-- Convertir id_operador de tb_maquinaria en clave foránea
ALTER TABLE tb_maquinaria ADD FOREIGN KEY (id_operador) REFERENCES tb_operador(id_operador) ON DELETE CASCADE ON UPDATE CASCADE;

