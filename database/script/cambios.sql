--
-- Añadir nuevos estados en el estado_trabajo
--
ALTER TABLE tb_cronograma
MODIFY COLUMN estado_trabajo ENUM('EN PROCESO', 'TERMINADO', 'PENDIENTE', 'ANULADO', 'REGISTRADO', 'APROBADO')
DEFAULT 'REGISTRADO';

-- Nuevo campo codigo
ALTER TABLE tb_cronograma ADD COLUMN codigo VARCHAR(20) NULL;
