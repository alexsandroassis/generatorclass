CREATE TABLE `cliente` (
  `idPessoa` INT(10) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(20) DEFAULT NULL,
  `endereco` VARCHAR(50) DEFAULT NULL,
  `sexo` CHAR(1) DEFAULT NULL,
  PRIMARY KEY (`idPessoa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1