DROP VIEW IF EXISTS `vw_clientes`;

CREATE VIEW `vw_clientes` AS
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
    `d`.`name_documento` AS `name_documento`,
    `p`.`apodo` AS `apodo`
FROM 
    `syscos`.`tb_cliente` `t`
JOIN 
    `syscos`.`tb_persona` `p` ON `p`.`id_persona` = `t`.`id_persona`
JOIN 
    `syscos`.`tb_documento_identidad` `d` ON `d`.`id_documento` = `p`.`id_documento`;