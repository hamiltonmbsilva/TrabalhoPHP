-- MySQL Script generated by MySQL Workbench
-- Thu Aug 23 21:42:12 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema eca
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `eca` ;

-- -----------------------------------------------------
-- Schema eca
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `eca` DEFAULT CHARACTER SET latin1 ;
USE `eca` ;

-- -----------------------------------------------------
-- Table `eca`.`tb_action`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eca`.`tb_action` ;

CREATE TABLE IF NOT EXISTS `eca`.`tb_action` (
  `id_action` INT(11) NOT NULL AUTO_INCREMENT,
  `str_cod_action` VARCHAR(4) NOT NULL,
  `str_name_action` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_action`),
  UNIQUE INDEX `str_cod_action_UNIQUE` (`str_cod_action` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eca`.`tb_beneficiaries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eca`.`tb_beneficiaries` ;

CREATE TABLE IF NOT EXISTS `eca`.`tb_beneficiaries` (
  `id_beneficiaries` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `str_nis` VARCHAR(14) NOT NULL,
  `str_name_person` VARCHAR(255) NOT NULL,
  `str_cpf` VARCHAR(14) NULL,
  `int_rgp` INT NULL,
  PRIMARY KEY (`id_beneficiaries`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eca`.`tb_region`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eca`.`tb_region` ;

CREATE TABLE IF NOT EXISTS `eca`.`tb_region` (
  `id_region` INT(11) NOT NULL AUTO_INCREMENT,
  `str_name_region` VARCHAR(12) NULL DEFAULT NULL,
  PRIMARY KEY (`id_region`),
  UNIQUE INDEX `str_name_region_UNIQUE` (`str_name_region` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eca`.`tb_state`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eca`.`tb_state` ;

CREATE TABLE IF NOT EXISTS `eca`.`tb_state` (
  `id_state` INT(11) NOT NULL AUTO_INCREMENT,
  `str_uf` VARCHAR(2) NOT NULL,
  `str_name` VARCHAR(19) NULL DEFAULT NULL,
  `tb_region_id_region` INT(11) NOT NULL,
  PRIMARY KEY (`id_state`),
  UNIQUE INDEX `str_uf_UNIQUE` (`str_uf` ASC),
  UNIQUE INDEX `str_name_UNIQUE` (`str_name` ASC),
  INDEX `fk_tb_state_tb_region1_idx` (`tb_region_id_region` ASC),
  CONSTRAINT `fk_tb_state_tb_region1`
    FOREIGN KEY (`tb_region_id_region`)
    REFERENCES `eca`.`tb_region` (`id_region`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eca`.`tb_city`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eca`.`tb_city` ;

CREATE TABLE IF NOT EXISTS `eca`.`tb_city` (
  `id_city` INT(11) NOT NULL AUTO_INCREMENT,
  `str_name_city` VARCHAR(255) NULL DEFAULT NULL,
  `str_cod_siafi_city` VARCHAR(4) NOT NULL,
  `tb_state_id_state` INT(11) NOT NULL,
  PRIMARY KEY (`id_city`),
  UNIQUE INDEX `str_cod_siafi_city_UNIQUE` (`str_cod_siafi_city` ASC),
  INDEX `fk_tb_city_tb_state_idx` (`tb_state_id_state` ASC),
  CONSTRAINT `fk_tb_city_tb_state`
    FOREIGN KEY (`tb_state_id_state`)
    REFERENCES `eca`.`tb_state` (`id_state`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eca`.`tb_files`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eca`.`tb_files` ;

CREATE TABLE IF NOT EXISTS `eca`.`tb_files` (
  `id_file` INT(11) NOT NULL AUTO_INCREMENT,
  `str_name_file` VARCHAR(45) NOT NULL,
  `str_month` VARCHAR(2) NULL DEFAULT NULL,
  `str_year` VARCHAR(4) NULL DEFAULT NULL,
  PRIMARY KEY (`id_file`),
  UNIQUE INDEX `str_name_file_UNIQUE` (`str_name_file` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eca`.`tb_functions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eca`.`tb_functions` ;

CREATE TABLE IF NOT EXISTS `eca`.`tb_functions` (
  `id_function` INT(11) NOT NULL AUTO_INCREMENT,
  `str_cod_function` VARCHAR(4) NOT NULL,
  `str_name_function` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_function`),
  UNIQUE INDEX `str_cod_function_UNIQUE` (`str_cod_function` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eca`.`tb_program`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eca`.`tb_program` ;

CREATE TABLE IF NOT EXISTS `eca`.`tb_program` (
  `id_program` INT(11) NOT NULL AUTO_INCREMENT,
  `str_cod_program` VARCHAR(4) NOT NULL,
  `str_name_program` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_program`),
  UNIQUE INDEX `str_cod_program_UNIQUE` (`str_cod_program` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eca`.`tb_source`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eca`.`tb_source` ;

CREATE TABLE IF NOT EXISTS `eca`.`tb_source` (
  `id_source` INT(11) NOT NULL AUTO_INCREMENT,
  `str_goal` VARCHAR(255) NOT NULL,
  `str_origin` VARCHAR(255) NULL DEFAULT NULL,
  `str_periodicity` VARCHAR(9) NULL DEFAULT NULL,
  PRIMARY KEY (`id_source`),
  UNIQUE INDEX `str_goal_UNIQUE` (`str_goal` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eca`.`tb_subfunctions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eca`.`tb_subfunctions` ;

CREATE TABLE IF NOT EXISTS `eca`.`tb_subfunctions` (
  `id_subfunction` INT(11) NOT NULL AUTO_INCREMENT,
  `str_cod_subfunction` VARCHAR(4) NOT NULL,
  `str_name_subfunction` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_subfunction`),
  UNIQUE INDEX `str_cod_subfunction_UNIQUE` (`str_cod_subfunction` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eca`.`tb_payments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eca`.`tb_payments` ;

CREATE TABLE IF NOT EXISTS `eca`.`tb_payments` (
  `id_payment` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `tb_city_id_city` INT(11) NOT NULL,
  `tb_functions_id_function` INT(11) NOT NULL,
  `tb_subfunctions_id_subfunction` INT(11) NOT NULL,
  `tb_program_id_program` INT(11) NOT NULL,
  `tb_action_id_action` INT(11) NOT NULL,
  `tb_beneficiaries_id_beneficiaries` BIGINT(20) NOT NULL,
  `tb_source_id_source` INT(11) NOT NULL,
  `tb_files_id_file` INT(11) NOT NULL,
  `db_value` DOUBLE NOT NULL,
  PRIMARY KEY (`id_payment`),
  INDEX `fk_tb_payments_tb_city1_idx` (`tb_city_id_city` ASC),
  INDEX `fk_tb_payments_tb_program1_idx` (`tb_program_id_program` ASC),
  INDEX `fk_tb_payments_tb_action1_idx` (`tb_action_id_action` ASC),
  INDEX `fk_tb_payments_tb_source1_idx` (`tb_source_id_source` ASC),
  INDEX `fk_tb_payments_tb_files1_idx` (`tb_files_id_file` ASC),
  INDEX `fk_tb_payments_tb_functions1_idx` (`tb_functions_id_function` ASC),
  INDEX `fk_tb_payments_tb_subfunctions1_idx` (`tb_subfunctions_id_subfunction` ASC),
  INDEX `fk_tb_payments_tb_beneficiaries1_idx` (`tb_beneficiaries_id_beneficiaries` ASC),
  CONSTRAINT `fk_tb_payments_tb_action1`
    FOREIGN KEY (`tb_action_id_action`)
    REFERENCES `eca`.`tb_action` (`id_action`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_payments_tb_beneficiaries1`
    FOREIGN KEY (`tb_beneficiaries_id_beneficiaries`)
    REFERENCES `eca`.`tb_beneficiaries` (`id_beneficiaries`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_payments_tb_city1`
    FOREIGN KEY (`tb_city_id_city`)
    REFERENCES `eca`.`tb_city` (`id_city`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_payments_tb_files1`
    FOREIGN KEY (`tb_files_id_file`)
    REFERENCES `eca`.`tb_files` (`id_file`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_payments_tb_functions1`
    FOREIGN KEY (`tb_functions_id_function`)
    REFERENCES `eca`.`tb_functions` (`id_function`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_payments_tb_program1`
    FOREIGN KEY (`tb_program_id_program`)
    REFERENCES `eca`.`tb_program` (`id_program`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_payments_tb_source1`
    FOREIGN KEY (`tb_source_id_source`)
    REFERENCES `eca`.`tb_source` (`id_source`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_payments_tb_subfunctions1`
    FOREIGN KEY (`tb_subfunctions_id_subfunction`)
    REFERENCES `eca`.`tb_subfunctions` (`id_subfunction`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eca`.`tb_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eca`.`tb_user` ;

CREATE TABLE IF NOT EXISTS `eca`.`tb_user` (
  `iduser` INT(11) NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `resetar` TINYINT(4) NOT NULL,
  `perfil` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`iduser`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eca`.`tb_fisherman_insurance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eca`.`tb_fisherman_insurance` ;

CREATE TABLE IF NOT EXISTS `eca`.`tb_fisherman_insurance` (
  `idtb_fisherman_insurance` INT NOT NULL AUTO_INCREMENT,
  `str_month` VARCHAR(2) NOT NULL,
  `str_year` VARCHAR(45) NOT NULL,
  `db_value` VARCHAR(45) NOT NULL,
  `tb_beneficiaries_id_beneficiaries` BIGINT(20) NOT NULL,
  `tb_city_id_city` INT(11) NOT NULL,
  PRIMARY KEY (`idtb_fisherman_insurance`),
  INDEX `fk_tb_fisherman_insurance_tb_beneficiaries1_idx` (`tb_beneficiaries_id_beneficiaries` ASC),
  INDEX `fk_tb_fisherman_insurance_tb_city1_idx` (`tb_city_id_city` ASC),
  CONSTRAINT `fk_tb_fisherman_insurance_tb_beneficiaries1`
    FOREIGN KEY (`tb_beneficiaries_id_beneficiaries`)
    REFERENCES `eca`.`tb_beneficiaries` (`id_beneficiaries`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_fisherman_insurance_tb_city1`
    FOREIGN KEY (`tb_city_id_city`)
    REFERENCES `eca`.`tb_city` (`id_city`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
