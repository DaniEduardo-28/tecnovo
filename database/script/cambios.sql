

--Para hacer visible el reporte de Clientes por Cobrar
UPDATE `tb_opcion` SET `name_opcion` = 'Clientes por Cobrar', `estado` = 'activo' WHERE `tb_opcion`.`id_opcion` = 710;

UPDATE `tb_acceso_opcion` SET `flag_agregar` = '1', `flag_buscar` = '1', `flag_editar` = '1', `flag_eliminar` = '1', `flag_anular` = '1', `flag_ver` = '1', `flag_descargar` = '1' WHERE `tb_acceso_opcion`.`id` = 187;

--Cambios en el tb_detalle_gastoserv
ALTER TABLE tb_detalle_gastoserv
ADD COLUMN id_tipo_gasto INT NULL,
ADD COLUMN cantidad DECIMAL(10,2) NULL,
ADD COLUMN precio_unitario DECIMAL(10,2) NULL

--Quitar id_tipo_gasto de la tabla tb_gasto_servicio
ALTER TABLE tb_gasto_servicio 
DROP COLUMN id_tipo_gasto, 
ADD COLUMN observaciones VARCHAR(500) NULL;

-- Campos nuevos en la orden de compra
ALTER TABLE tb_orden_compra
ADD serie VARCHAR(10) NULL AFTER id_moneda,
ADD correlativo VARCHAR(20) NULL AFTER serie,
ADD evidencia VARCHAR(255) NULL AFTER correlativo;

--nueva vista de orden de compra
CREATE VIEW `vw_orden_compra` AS 
SELECT
    o.id_orden_compra AS id_orden_compra,
    o.id_proveedor AS id_proveedor,
    pr.nombre_proveedor AS nombre_proveedor,
    pr.src_imagen_proveedor AS src_imagen_proveedor,
    o.id_metodo_envio AS id_metodo_envio,
    o.fecha_orden AS fecha_orden,
    o.fecha_entrega AS fecha_entrega,
    o.observaciones AS observaciones,
    o.id_moneda AS id_moneda,
    o.id_sucursal AS id_sucursal,
    o.estado AS estado_int,
    o.serie AS serie,
    o.correlativo AS correlativo,
    o.evidencia AS evidencia,
    CASE 
        WHEN o.estado = '0' THEN 'EN proceso ...'
        WHEN o.estado = '1' THEN 'EN espera ...'
        WHEN o.estado = '2' THEN 'Recibido'
        WHEN o.estado = '3' THEN 'Anulado'
    END AS estado,
    dc.cod_producto AS cod_producto,
    dc.name_tabla AS name_tabla,
    pro.name_accesorio AS name_producto,
    pro.stock AS stock,
    dc.precio_unitario AS precio_unitario,
    dc.cantidad_solicitada AS cantidad_solicitada,
    CASE 
        WHEN dc.cantidad_ingresada > 0 THEN CONCAT(
            'Ingresaron ', dc.cantidad_ingresada, ' de ', dc.cantidad_solicitada, dc.notas
        )
        WHEN dc.cantidad_ingresada = 0 AND o.estado = '1' THEN CONCAT(
            'Ingresaron ', dc.cantidad_ingresada, ' de ', dc.cantidad_solicitada, dc.notas
        )
        ELSE dc.notas
    END AS notas,
    dc.precio_unitario * dc.cantidad_solicitada AS total,
    pro.src_imagen AS src_imagen_producto,
    dc.cantidad_ingresada AS cantidad_ingresada
FROM
    tb_orden_compra o
    JOIN vw_proveedor pr ON pr.id_proveedor = o.id_proveedor
    JOIN tb_detalle_compra dc ON dc.id_orden_compra = o.id_orden_compra AND dc.name_tabla = 'accesorio'
    JOIN tb_accesorio pro ON pro.id_accesorio = dc.cod_producto;
