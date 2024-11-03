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
    og.id_orden_gasto,
    p.id_proveedor,
    p.nombre_proveedor,
    p.src_imagen_proveedor,
    og.fecha_gasto,
    og.observaciones,
    m.id_moneda,
    dg.cod_gasto,
    dg.name_tabla,
    g.name_gasto,
    dg.precio_unitario,
    dg.cantidad_solicitada,
    (
        dg.precio_unitario * dg.cantidad_solicitada
    ) AS total
FROM
    tb_orden_gasto og
JOIN vw_proveedores p ON
    og.id_proveedor = p.id_proveedor
JOIN tb_moneda m ON
    og.id_moneda = m.id_moneda
JOIN tb_detalle_gasto dg ON
    dg.id_orden_gasto = og.id_orden_gasto AND dg.name_tabla = 'gasto'
JOIN tb_gasto g ON
    g.id_gasto = dg.cod_gasto;

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


-- Una nueva tabla de orden de gasto
CREATE TABLE tb_orden_gasto (
    id_orden_gasto INT AUTO_INCREMENT PRIMARY KEY,
    id_orden INT NOT NULL,
    id_documento INT NOT NULL,
    id_documento_venta INT NOT NULL,
    id_moneda INT NOT NULL,
    id_proveedor INT NOT NULL,
    id_gasto INT NOT NULL,
    id_servicio INT NOT NULL,
    serie VARCHAR(50),
    correlativo VARCHAR(50),
    fecha_gasto DATE
);
