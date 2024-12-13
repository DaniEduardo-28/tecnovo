
CREATE TABLE tb_cronograma (
    id_cronograma BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_servicio BIGINT(20) UNSIGNED NOT NULL,
    fecha_ingreso DATE NOT NULL,
    fecha_salida DATE NOT NULL,
    lugar VARCHAR(100),
    cantidad DECIMAL(10,2) NOT NULL,
    monto_unitario DECIMAL(10,2) NOT NULL,
    descuento DECIMAL(10,2) DEFAULT 0,
    adelanto DECIMAL(10,2) DEFAULT 0,
    monto_total DECIMAL(10,2),
    saldo_por_pagar DECIMAL(10,2),
    estado_pago ENUM('PENDIENTE', 'CANCELADO') DEFAULT 'PENDIENTE',
    estado_trabajo ENUM('EN PROCESO', 'TERMINADO') DEFAULT 'EN PROCESO',
    CONSTRAINT fk_servicio_cronograma FOREIGN KEY (id_servicio) REFERENCES tb_servicio(id_servicio) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tb_cronograma_operadores (
    id_cronograma_operador BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_cronograma BIGINT(20) UNSIGNED NOT NULL,
    id_trabajador BIGINT(20) UNSIGNED NOT NULL,
    horas_trabajadas DECIMAL(10,2) NOT NULL,
    pago_por_hora DECIMAL(10,2),
    total_pago DECIMAL(10,2),
    CONSTRAINT fk_cronograma_operador FOREIGN KEY (id_cronograma) REFERENCES tb_cronograma(id_cronograma) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_trabajador_cronograma FOREIGN KEY (id_trabajador) REFERENCES tb_trabajador(id_trabajador) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tb_cronograma_maquinaria (
    id_cronograma_maquinaria BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_cronograma BIGINT(20) UNSIGNED NOT NULL,
    id_maquinaria BIGINT(20) UNSIGNED NOT NULL,
    petroleo_entrada DECIMAL(10,2),
    petroleo_salida DECIMAL(10,2),
    consumo_petroleo DECIMAL(10,2),
    precio_petroleo DECIMAL(10,2),
    pago_petroleo DECIMAL(10,2),
    CONSTRAINT fk_cronograma_maquinaria FOREIGN KEY (id_cronograma) REFERENCES tb_cronograma(id_cronograma) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_maquinaria_cronograma FOREIGN KEY (id_maquinaria) REFERENCES tb_maquinaria(id_maquinaria) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tb_pagos_clientes (
    id_pago_cliente BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_cronograma BIGINT(20) UNSIGNED NOT NULL,
    fecha_pago DATE NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    metodo_pago VARCHAR(50),
    CONSTRAINT fk_cronograma_pago FOREIGN KEY (id_cronograma) REFERENCES tb_cronograma(id_cronograma) ON DELETE CASCADE ON UPDATE CASCADE
);
