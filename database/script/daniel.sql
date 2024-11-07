-- Añadir la columna id_operador en la tabla tb_maquinaria
ALTER TABLE `tb_maquinaria` ADD `id_operador` BIGINT UNSIGNED NOT NULL AFTER `estado`;

-- Convertir id_operador de tb_maquinaria en clave foránea
ALTER TABLE tb_maquinaria ADD FOREIGN KEY (id_operador) REFERENCES tb_operador(id_operador) ON DELETE CASCADE ON UPDATE CASCADE;

-- Eliminar estas dos vistas ya que se cargaron mal al subir el database.sql en el PHPMyAdmin
DROP VIEW vw_proveedores;
DROP VIEW vw_clientes;
DROP VIEW vw_orden_gasto;

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

-- Vista de proveedores
CREATE VIEW vw_proveedores AS SELECT
    pr.id_proveedor AS id_proveedor,
    pr.id_persona AS id_persona_proveedor,
    pr.estado AS estado_proveedor,
    p.id_documento AS id_documento_proveedor,
    p.num_documento AS num_documento_proveedor,
    CONCAT(p.nombres, ' ', p.apellidos) AS nombre_proveedor,
    p.direccion AS direccion_proveedor,
    p.telefono AS telefono_proveedor,
    p.correo AS correo_proveedor,
    p.fecha_nacimiento AS fecha_nacimiento_proveedor,
    p.sexo AS sexo_proveedor,
    pr.src_imagen AS src_imagen_proveedor
FROM
    (
        syscos.tb_proveedor pr
    JOIN syscos.tb_persona p
    ON
        ((pr.id_persona = p.id_persona))
    )

-- Vista de orden de gasto
CREATE VIEW vw_orden_gasto AS 
SELECT
    o.id_orden_gasto,
    o.id_proveedor,
    pr.nombre_proveedor,
    pr.src_imagen_proveedor,
    o.fecha_gasto,
    dg.cod_producto,
    dg.name_tabla,
    pro.name_servicio AS name_producto,
    dg.precio_unitario,
    dg.cantidad,
    dg.descuento,
    ((dg.precio_unitario * dg.cantidad) - dg.descuento) AS sub_total,
    dg.tipo_igv,
    dg.igv,
    ((dg.precio_unitario * dg.cantidad - dg.descuento) - ((dg.precio_unitario * dg.cantidad - dg.descuento) * dg.igv)) AS total
FROM
    tb_orden_gasto o
JOIN vw_proveedores pr ON
    pr.id_proveedor = o.id_proveedor
JOIN tb_detalle_gasto dg ON
    dg.id_orden_gasto = o.id_orden_gasto AND dg.name_tabla = 'servicio'
JOIN tb_servicio pro ON
    pro.id_servicio = dg.cod_producto
UNION
SELECT
    o.id_orden_gasto,
    o.id_proveedor,
    pr.nombre_proveedor,
    pr.src_imagen_proveedor,
    o.fecha_gasto,
    dg.cod_producto,
    dg.name_tabla,
    pro.name_gasto AS name_producto,
    dg.precio_unitario,
    dg.cantidad,
    dg.descuento,
    ((dg.precio_unitario * dg.cantidad) - dg.descuento) AS sub_total,
    dg.tipo_igv,
    dg.igv,
    ((dg.precio_unitario * dg.cantidad - dg.descuento) - ((dg.precio_unitario * dg.cantidad - dg.descuento) * dg.igv)) AS total
FROM
    tb_orden_gasto o
JOIN vw_proveedores pr ON
    pr.id_proveedor = o.id_proveedor
JOIN tb_detalle_gasto dg ON
    dg.id_orden_gasto = o.id_orden_gasto AND dg.name_tabla = 'producto'
JOIN tb_gasto pro ON
    pro.id_gasto = dg.cod_producto;


-- Vista de operadores 
-- Este último para facilitar el llamado de los datos del operador
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

-- Al cargar la BD, puede que ciertas tablas pierdan su primary key
-- Añadirlo al tb_cliente_fundo para que siga operativo correctamente
ALTER TABLE `tb_cliente_fundo` CHANGE `id` `id` INT NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);

-- Eliminar la anterior tabla de detalle gasto
DROP TABLE tb_detalle_gasto;

-- Una nueva tabla de tb_detalle_gasto
CREATE TABLE tb_detalle_gasto (
  id_detalle BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_orden_gasto INT NOT NULL,
  name_tabla VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  cod_producto VARCHAR(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  descripcion VARCHAR(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  cantidad DECIMAL(18,2) NOT NULL,
  precio_unitario DECIMAL(18,3) NOT NULL,
  descuento DECIMAL(18,2) DEFAULT 0.00,
  sub_total DECIMAL(18,2) NOT NULL,
  tipo_igv VARCHAR(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  igv DECIMAL(18,2) NOT NULL,
  total DECIMAL(18,2) NOT NULL,
  PRIMARY KEY (id_detalle)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Eliminar la anterior tabla tb_orden_gasto
DROP TABLE tb_orden_gasto;

-- Una nueva tabla de tb_orden_gasto
CREATE TABLE tb_orden_gasto (
  id_orden_gasto INT NOT NULL,
  id_documento_venta INT NOT NULL,
  serie VARCHAR(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  correlativo VARCHAR(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  id_proveedor INT NOT NULL,
  fecha_gasto DATETIME NOT NULL,
  descuento_total DECIMAL(18,2) DEFAULT 0.00,
  sub_total DECIMAL(18,2) NOT NULL,
  igv DECIMAL(18,2) NOT NULL,
  total DECIMAL(18,2) NOT NULL,
  monto_recibido DECIMAL(18,2) DEFAULT NULL,
  vuelto DECIMAL(18,2) DEFAULT NULL,
  id_moneda INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `tb_orden_gasto` CHANGE `igv` `igv_total` DECIMAL(18,2) NOT NULL;
ALTER TABLE `tb_orden_gasto` CHANGE `total` `monto_total` DECIMAL(18,2) NOT NULL;

-- Creación de la vista vw_trabajadores
-- Por cambios anteriores, este se corrompió por lo que se hizo un cambio en su diseño

CREATE VIEW vw_trabajdores AS SELECT
    `t`.`id_trabajador` AS `id_trabajador`,
    `t`.`id_persona` AS `id_persona`,
    `t`.`id_grupo` AS `id_grupo`,
    `t`.`name_user` AS `name_user`,
    `t`.`pass_user` AS `pass_user`,
    `t`.`cod_recuperacion` AS `cod_recuperacion`,
    `t`.`fecha_activacion` AS `fecha_activacion`,
    `t`.`fecha_recuperacion` AS `fecha_recuperacion`,
    `t`.`src_imagen` AS `src_imagen`,
    `t`.`estado` AS `estado`,
    `t`.`flag_medico` AS `flag_medico`,
    `t`.`link_facebook` AS `link_facebook`,
    `t`.`link_instagram` AS `link_instagram`,
    `t`.`link_twitter` AS `link_twitter`,
    `t`.`descripcion` AS `descripcion`,
    `p`.`id_documento` AS `id_documento`,
    `p`.`num_documento` AS `num_documento`,
    `p`.`nombres` AS `nombres_trabajador`,
    `p`.`apellidos` AS `apellidos_trabajador`,
    `p`.`direccion` AS `direccion_trabajador`,
    `p`.`telefono` AS `telefono_trabajador`,
    `p`.`correo` AS `correo_trabajador`,
    `p`.`fecha_nacimiento` AS `fecha_nacimiento_trabajador`,
    `p`.`sexo` AS `sexo_trabajador`,
    `d`.`name_documento` AS `name_documento_trabajador`
FROM
    (
        (
            `syscos`.`tb_trabajador` `t`
        JOIN `syscos`.`tb_persona` `p`
        ON
            ((`p`.`id_persona` = `t`.`id_persona`))
        )
    JOIN `syscos`.`tb_documento_identidad` `d`
    ON
        (
            (
                `d`.`id_documento` = `p`.`id_documento`
            )
        )
    )


    -- ASIMISMO UN ÚLTIMO MÉTODO, sería utilizar la borrada orden de venta para ser el nuevo registro de gastos
    -- ya que comparten misma estructura solicitada.

    ALTER TABLE `tb_venta` CHANGE `id_trabajador` `id_trabajador` BIGINT UNSIGNED NULL;
    ALTER TABLE `tb_venta` CHANGE `id_fundo` `id_fundo` BIGINT UNSIGNED NULL;
    ALTER TABLE `tb_venta` CHANGE `id_documento_cliente` `id_documento_proveedor` BIGINT UNSIGNED NOT NULL;
    ALTER TABLE `tb_venta` CHANGE `name_documento_cliente` `name_documento_proveedor` BIGINT UNSIGNED NOT NULL;
    ALTER TABLE `tb_venta` CHANGE `codigo_documento_cliente` `codigo_documento_proveedor` BIGINT UNSIGNED NOT NULL;
    ALTER TABLE `tb_venta` CHANGE `numero_documento_cliente` `numero_documento_proveedor` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

    ALTER TABLE `tb_venta` CHANGE `id_venta` `id_venta` INT NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id_venta`);