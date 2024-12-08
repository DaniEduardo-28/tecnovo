-- Ya que cada pago tendra su evidencia de factura
ALTER TABLE `tb_pago` CHANGE `monto_pendiente` `src_factura` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;