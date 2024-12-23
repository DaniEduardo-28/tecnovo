ALTER TABLE `syscos`.`tb_cronograma`
ADD COLUMN `id_fundo` INT(11) NULL;

ALTER TABLE `syscos`.`tb_cronograma`
ADD COLUMN `id_cliente` INT(11) NULL;

ALTER TABLE `syscos`.`tb_cronograma`
CHANGE `fecha_ingreso` `fecha_ingreso` datetime(2) NOT NULL,
CHANGE `fecha_salida` `fecha_salida` datetime(2) NOT NULL;