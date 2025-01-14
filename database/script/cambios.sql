--
-- Añadir nuevos estados en el estado_trabajo
--
ALTER TABLE tb_cronograma
MODIFY COLUMN estado_trabajo ENUM('EN PROCESO', 'TERMINADO', 'PENDIENTE', 'ANULADO', 'REGISTRADO', 'APROBADO')
DEFAULT 'REGISTRADO';

-- Nuevo campo codigo
ALTER TABLE tb_cronograma ADD COLUMN codigo VARCHAR(20) NULL;

-- Campo serie en tipo_servicio
ALTER TABLE tb_tipo_servicio 
ADD COLUMN serie VARCHAR(6) NOT NULL;

-- TRIGGER PARA AUTOMATIZAR EL REGISTRO DE SERIE
DELIMITER //
CREATE TRIGGER trg_set_serie BEFORE INSERT ON tb_tipo_servicio
FOR EACH ROW
BEGIN
    SET NEW.serie = CONCAT('SE-', UPPER(LEFT(NEW.name_tipo, 3)));
END; //

CREATE TRIGGER trg_update_serie BEFORE UPDATE ON tb_tipo_servicio
FOR EACH ROW
BEGIN
    SET NEW.serie = CONCAT('SE-', UPPER(LEFT(NEW.name_tipo, 3)));
END; //
DELIMITER ;



