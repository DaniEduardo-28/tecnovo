ALTER TABLE `tb_persona`
ADD COLUMN `apodo` varchar(100) NULL;

ALTER TABLE `tb_cliente`
CHANGE `name_user` `name_user` varchar(100) NULL,
CHANGE `pass_user` `pass_user` varchar(500) NULL;

