--
-- Añadir nuevos estados en el estado_trabajo
--
ALTER TABLE tb_cronograma 
CHANGE estado_trabajo estado_trabajo ENUM('EN PROCESO', 'TERMINADO', 'PENDIENTE', 'ANULADO') 
DEFAULT 'PENDIENTE';