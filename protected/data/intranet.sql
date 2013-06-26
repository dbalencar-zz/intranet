-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 26, 2013 at 02:08 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.6-1ubuntu1.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `intranet`
--

-- --------------------------------------------------------

--
-- Table structure for table `AuthAssignment`
--

CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) CHARACTER SET latin1 NOT NULL,
  `userid` varchar(64) CHARACTER SET latin1 NOT NULL,
  `bizrule` text CHARACTER SET latin1,
  `data` text CHARACTER SET latin1,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `AuthAssignment`
--

INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('Admin', '1', NULL, 'N;'),
('Arquivista', '10', NULL, 'N;'),
('Arquivista', '2', NULL, 'N;'),
('Arquivista', '5', NULL, 'N;'),
('Desapensador', '5', NULL, 'N;'),
('Protocolista', '5', NULL, 'N;'),
('Tramitador', '10', NULL, 'N;'),
('Tramitador', '3', NULL, 'N;'),
('Tramitador', '4', NULL, 'N;'),
('Tramitador', '7', NULL, 'N;'),
('Tramitador', '8', NULL, 'N;'),
('Tramitador', '9', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `AuthItem`
--

CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) CHARACTER SET latin1 NOT NULL,
  `type` int(11) NOT NULL,
  `description` text CHARACTER SET latin1,
  `bizrule` text CHARACTER SET latin1,
  `data` text CHARACTER SET latin1,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `AuthItem`
--

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Admin', 2, NULL, NULL, 'N;'),
('Apensador', 2, 'Apensador', NULL, 'N;'),
('Arquivista', 2, 'Arquivista', NULL, 'N;'),
('Desapensador', 2, 'Desapensador', NULL, 'N;'),
('Protocolista', 2, 'Protocolista', NULL, 'N;'),
('Protocolo.Default.Arquivar', 0, NULL, NULL, 'N;'),
('Protocolo.Default.Destinar', 0, NULL, NULL, 'N;'),
('Protocolo.Default.Desvincular', 0, NULL, NULL, 'N;'),
('Protocolo.Default.Imprimir', 0, NULL, NULL, 'N;'),
('Protocolo.Default.Inbox', 0, NULL, NULL, 'N;'),
('Protocolo.Default.Protocolar', 0, NULL, NULL, 'N;'),
('Protocolo.Default.Receber', 0, NULL, NULL, 'N;'),
('Protocolo.Default.Tramitar', 0, NULL, NULL, 'N;'),
('Protocolo.Default.Vincular', 0, NULL, NULL, 'N;'),
('Recebedor', 2, 'Recebedor', NULL, 'N;'),
('Tramitador', 2, 'Tramitador', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `AuthItemChild`
--

CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) CHARACTER SET latin1 NOT NULL,
  `child` varchar(64) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `AuthItemChild`
--

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('Protocolista', 'Apensador'),
('Arquivista', 'Protocolo.Default.Arquivar'),
('Tramitador', 'Protocolo.Default.Destinar'),
('Desapensador', 'Protocolo.Default.Desvincular'),
('Tramitador', 'Protocolo.Default.Imprimir'),
('Recebedor', 'Protocolo.Default.Inbox'),
('Protocolista', 'Protocolo.Default.Protocolar'),
('Recebedor', 'Protocolo.Default.Receber'),
('Tramitador', 'Protocolo.Default.Tramitar'),
('Apensador', 'Protocolo.Default.Vincular'),
('Tramitador', 'Recebedor'),
('Arquivista', 'Tramitador'),
('Protocolista', 'Tramitador');

-- --------------------------------------------------------

--
-- Table structure for table `protocolo`
--

CREATE TABLE IF NOT EXISTS `protocolo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `protocolo` varchar(17) DEFAULT NULL,
  `documento` varchar(50) NOT NULL,
  `origem` varchar(100) NOT NULL,
  `assunto` varchar(100) NOT NULL,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` int(10) unsigned NOT NULL,
  `observacao` varchar(100) DEFAULT NULL,
  `arquivado` char(1) NOT NULL DEFAULT '0',
  `ar_usuario` int(11) DEFAULT NULL,
  `ar_datahora` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `protocolo` (`protocolo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `Rights`
--

CREATE TABLE IF NOT EXISTS `Rights` (
  `itemname` varchar(64) CHARACTER SET latin1 NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) CHARACTER SET latin1 NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1368625893),
('m110805_153437_installYiiUser', 1368625926),
('m110810_162301_userTimestampFix', 1368625927);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profiles`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL DEFAULT '',
  `extension` int(4) NOT NULL DEFAULT '0',
  `unidade_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_profiles`
--

INSERT INTO `tbl_profiles` (`user_id`, `first_name`, `last_name`, `phone`, `extension`, `unidade_id`) VALUES
(1, 'Douglas', 'Braga de Alencar', '8428-0337', 2007, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profiles_fields`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `field_type` varchar(50) NOT NULL DEFAULT '',
  `field_size` int(3) NOT NULL DEFAULT '0',
  `field_size_min` int(3) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` text,
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` text,
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_profiles_fields`
--

INSERT INTO `tbl_profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'first_name', 'First Name', 'VARCHAR', 255, 3, 2, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'last_name', 'Last Name', 'VARCHAR', 255, 3, 2, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 2, 3),
(4, 'phone', 'Phone', 'VARCHAR', 255, 8, 2, '', '', 'Invalid Phone', '', '', '', '', 3, 2),
(5, 'extension', 'Extension', 'INTEGER', 4, 4, 2, '', '', 'Invalid Extension', '', '0', '', '', 4, 2),
(7, 'unidade_id', 'Unidade', 'INTEGER', 10, 0, 1, '', '', '', '', '0', 'UWrelBelongsTo', '{"modelName":"Unidade","optionName":"nome","emptyField":"Nenhum","relationName":"unidade"}', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_username` (`username`),
  UNIQUE KEY `user_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `email`, `activkey`, `superuser`, `status`, `create_at`, `lastvisit_at`) VALUES
(1, 'admin', 'e9763a5e0f95e9145fa0f4832aac8cc1', 'sistemas@ssp.am.gov.br', 'c5fef1818e6bc27f43ba3a549df92dcb', 1, 1, '2013-05-15 13:52:05', '2013-06-25 18:13:25');

-- --------------------------------------------------------

--
-- Table structure for table `tramitacao`
--

CREATE TABLE IF NOT EXISTS `tramitacao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `protocolo_id` int(10) unsigned NOT NULL,
  `origem` int(10) unsigned NOT NULL,
  `or_usuario` int(10) unsigned NOT NULL,
  `or_datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `destino` int(10) unsigned NOT NULL,
  `de_usuario` int(10) unsigned DEFAULT NULL,
  `de_datahora` timestamp NULL DEFAULT NULL,
  `despacho` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `unidade`
--

CREATE TABLE IF NOT EXISTS `unidade` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sigla` varchar(10) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `pai` int(11) DEFAULT NULL,
  `protocolo` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `unidade`
--

INSERT INTO `unidade` (`id`, `sigla`, `nome`, `pai`, `protocolo`) VALUES
(1, 'SSP', 'Secretaria de Estado de Segurança Pública', NULL, 0),
(2, 'DETEC', 'Departamento de Tecnologia', 14, 0),
(3, 'DA', 'Departamento de Administração', 14, 0),
(4, 'GCS', 'Gerência de Compras e Serviços', 3, 0),
(5, 'GAP', 'Gerência de Almoxarifado e Patrimônio', 3, 0),
(7, 'DOF', 'Departamento de Orçamento e Finanças', 14, 0),
(8, 'OD', 'Ordenação de Despesas', 1, 0),
(9, 'SEARB', 'Secretaria Executiva Adjunta do Ronda no Bairro', 1, 0),
(10, 'GTRA', 'Gerência de Transporte', 3, 0),
(11, 'CORREG', 'Corregedoria Geral do Sistema de Segurança Pública', 1, 0),
(12, 'SEAI', 'Secretaria Executiva Adjunta de Inteligência', 1, 0),
(13, 'CG', 'Chefia de Gabinete', 1, 0),
(14, 'SESP', 'Secretaria Executiva de Segurança Pública', 1, 0),
(15, 'IESP', 'Instituto Integrado de Ensino de Segurança Pública', 14, 0),
(16, 'DEPLAN', 'Deptº. de Planej. e Cont. de Projetos e Convênios', 14, 0),
(17, 'JMP', 'Junta Médico-Pericial', 14, 0),
(18, 'AJ', 'Assessoria Jurídica', 1, 0),
(19, 'AC', 'Assessoria de Comunicação', 1, 0),
(20, 'PREVINE', 'Previne', 1, 0),
(21, 'SEAO', 'Secretaria Executiva Adjunta Operacional', 1, 0),
(22, 'GRH', 'Gerência de Recursos Humanos', 3, 0),
(23, 'GPG', 'Gerência de Protocolo Geral', 3, 0),
(24, 'GSG', 'Gerência de Serviços Gerais', 3, 0),
(25, 'CE', 'Coodenadoria de Estágio', 3, 0),
(26, 'GF', 'Gerência de Finanças', 7, 0),
(27, 'GO', 'Gerência de Orçamento', 7, 0),
(28, 'GC', 'Gerência de Contabilidade', 7, 0),
(29, 'GCOM', 'Gerência de Comunicação', 2, 0),
(30, 'GCONV', 'Gerência de Convênios', 16, 0),
(31, 'GCONT', 'Gerência de Contratos', 16, 0),
(32, 'CGESFRON', 'Coordenadoria Geral do ESFRON', 16, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vinculo`
--

CREATE TABLE IF NOT EXISTS `vinculo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protocolo` int(11) NOT NULL,
  `vinculo` int(11) NOT NULL,
  `vinculado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vin_usuario` int(11) NOT NULL,
  `desvinculado` timestamp NULL DEFAULT NULL,
  `des_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AuthAssignment`
--
ALTER TABLE `AuthAssignment`
  ADD CONSTRAINT `AuthAssignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `AuthItemChild`
--
ALTER TABLE `AuthItemChild`
  ADD CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Rights`
--
ALTER TABLE `Rights`
  ADD CONSTRAINT `Rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  ADD CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
