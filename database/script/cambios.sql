ALTER TABLE `tb_pago` ADD `fecha_pago` DATETIME NULL AFTER `id_forma_pago`;

ALTER TABLE `tb_pago` CHANGE `id_ingreso` `id_ingreso` INT NULL;
ALTER TABLE `tb_pago` CHANGE `id_forma_pago` `id_forma_pago` INT NULL;
ALTER TABLE `tb_pago` CHANGE `monto_pagado` `monto_pagado` DECIMAL(18,2) NULL;
ALTER TABLE `tb_pago` CHANGE `monto_pagado` `monto_pagado` DECIMAL(18,2) NULL;

ALTER TABLE `tb_pago` CHANGE `id_pago` `id_pago` INT NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id_pago`);