-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2024 at 10:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pure_air_solutions`
--

-- --------------------------------------------------------

--
-- Table structure for table `AZIENDE`
--

CREATE TABLE `AZIENDE` (
  `AZIENDA_ID` bigint(20) NOT NULL,
  `AZIENDA_NOME` varchar(255) DEFAULT NULL,
  `PARTITA_IVA` varchar(255) DEFAULT NULL,
  `CODICE_FISCALE` varchar(255) DEFAULT NULL,
  `CONTATTO_1` varchar(255) DEFAULT NULL,
  `CONTATTO_2` varchar(255) DEFAULT NULL,
  `CONTATTO_3` varchar(255) DEFAULT NULL,
  `EMAIL_1` varchar(255) DEFAULT NULL,
  `EMAIL_2` varchar(255) DEFAULT NULL,
  `EMAIL_3` varchar(255) DEFAULT NULL,
  `TELEFONO_1` bigint(20) DEFAULT NULL,
  `TELEFONO_2` bigint(20) DEFAULT NULL,
  `TELEFONO_3` bigint(20) DEFAULT NULL,
  `INDIRIZZO` varchar(255) DEFAULT NULL,
  `CITTA` varchar(255) DEFAULT NULL,
  `INDIRIZZO_PEC` varchar(255) DEFAULT NULL,
  `DATA_INIZIO` date DEFAULT NULL,
  `DATA_FINITO` date DEFAULT NULL,
  `WEBSITE` varchar(2555) DEFAULT NULL,
  `INFORMAZIONI` varchar(255) DEFAULT NULL,
  `E_ATTIVO` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `AZIENDE`
--

INSERT INTO `AZIENDE` (`AZIENDA_ID`, `AZIENDA_NOME`, `PARTITA_IVA`, `CODICE_FISCALE`, `CONTATTO_1`, `CONTATTO_2`, `CONTATTO_3`, `EMAIL_1`, `EMAIL_2`, `EMAIL_3`, `TELEFONO_1`, `TELEFONO_2`, `TELEFONO_3`, `INDIRIZZO`, `CITTA`, `INDIRIZZO_PEC`, `DATA_INIZIO`, `DATA_FINITO`, `WEBSITE`, `INFORMAZIONI`, `E_ATTIVO`) VALUES
(1, 'Company A', '12345678901', 'CF12345678901', 'John Doe', 'Jane Doe', 'Mark Smith', 'john@example.com', 'jane@example.com', 'mark@example.com', 1234567890, 2147483647, 2147483647, '123 Main St', 'New York', 'companya@example.com', '2023-01-01', '2024-03-12', 'https://www.companya.com', 'Some information about Company A', b'1'),
(2, 'Company B', '23456789012', 'CF23456789012', 'Alice Johnson', 'Bob Smith', 'Emily Brown', 'alice@example.com', 'bob@example.com', 'emily@example.com', 2147483647, 2147483647, 2147483647, '456 Elm St', 'Los Angeles', 'companyb@example.com', '2023-02-01', NULL, 'https://www.companyb.com', 'Some information about Company B', b'1'),
(3, 'Company C', '34567890123', 'CF34567890123', 'Michael Taylor', 'Sarah White', 'David Davis', 'michael@example.com', 'sarah@example.com', 'david@example.com', 2147483647, 2147483647, 2147483647, '789 Oak St', 'Chicago', 'companyc@example.com', '2023-03-01', NULL, 'https://www.companyc.com', 'Some information about Company C', b'1'),
(4, 'Company D', '45678901234', 'CF45678901234', 'Jennifer Martinez', 'Christopher Rodriguez', 'Jessica Garcia', 'jennifer@example.com', 'christopher@example.com', 'jessica@example.com', 2147483647, 2147483647, 2147483647, '101 Pine St', 'Houston', 'companyd@example.com', '2023-04-01', NULL, 'https://www.companyd.com', 'Some information about Company D', b'1'),
(5, 'Company E', '56789012345', 'CF56789012345', 'Matthew Hernandez', 'Emma Martinez', 'James Wilson', 'matthew@example.com', 'emma@example.com', 'james@example.com', 2147483647, 2147483647, 2147483647, '202 Maple St', 'Phoenix', 'companye@example.com', '2023-05-01', NULL, 'https://www.companye.com', 'Some information about Company E', b'1'),
(6, 'Company F', '67890123456', 'CF67890123456', 'Olivia Lopez', 'Daniel Anderson', 'Sophia Taylor', 'olivia@example.com', 'daniel@example.com', 'sophia@example.com', 2147483647, 2147483647, 2147483647, '303 Cedar St', 'Philadelphia', 'companyf@example.com', '2023-06-01', NULL, 'https://www.companyf.com', 'Some information about Company F', b'1'),
(7, 'Company G', '78901234567', 'CF78901234567', 'Alexander Thomas', 'Mia Moore', 'Ethan Jackson', 'alexander@example.com', 'mia@example.com', 'ethan@example.com', 2147483647, 2147483647, 2147483647, '404 Walnut St', 'San Antonio', 'companyg@example.com', '2023-07-01', NULL, 'https://www.companyg.com', 'Some information about Company G', b'1'),
(8, 'Company H', '89012345678', 'CF89012345678', 'Isabella Martin', 'Ryan Garcia', 'Chloe Hernandez', 'isabella@example.com', 'ryan@example.com', 'chloe@example.com', 2147483647, 2147483647, 2147483647, '505 Birch St', 'San Diego', 'companyh@example.com', '0000-00-00', NULL, 'https://www.companyh.com', 'Some information about Company H', b'1'),
(9, 'Company I', '90123456789', 'CF90123456789', 'Elijah Martinez', 'Ava Lopez', 'Logan Perez', 'elijah@example.com', 'ava@example.com', 'logan@example.com', 2147483647, 2147483647, 2147483647, '606 Pine St', 'Dallas', 'companyi@example.com', '2023-09-01', NULL, 'https://www.companyi.com', 'Some information about Company I', b'1'),
(10, 'Company J', '01234567890', 'CF01234567890', 'Mason Hernandez', 'Sofia Rodriguez', 'Jackson Moore', 'mason@example.com', 'sofia@example.com', 'jackson@example.com', 2147483647, 2147483647, 1234567890, '707 Oak St', 'Austin', 'companyj@example.com', '2023-10-01', NULL, 'https://www.companyj.com', 'Some information about Company J', b'1'),
(11, 'Suva', NULL, 'mmm', '', '', '', 'sss@gmail.com', '', '', 0, 0, 0, '', '', 'm@gmail.com', '2024-03-05', NULL, '', '', b'1'),
(12, 'Ana', 'jjjjjj', '2020', '', '', '', 'anaperduka@gmail.com', '', '', 0, 0, 0, '', '', 'a@fm.com', '0000-00-00', '0000-00-00', '', '', b'1'),
(13, 'KILL', 'KILL', 'KILL', 'KILL1', 'KILL2', 'KILL3', 'kill1@gmail.com', 'kill2@gmail.com', 'kill3@gmail.com', 123, 456, 789, 'KILL', 'KILL', 'kill@gmail.com', '2024-03-11', '2024-03-12', 'KILL', 'KILL', b'1'),
(14, 'American Hospital Tirana', 'KILL', 'swewewe', 'KILL1', 'KILL2', 'KILL3', 'anaperduka@unyt.edu.com', 'kill2@gmail.com', 'kill3@gmail.com', 215645, 2654, 644655, 'vgjbh', '', 'hm@gmail.com', '2024-03-16', NULL, 'KILL', 'hgjmbn ', b'1'),
(15, 'American Hospital1112', 'KILLhh', 'KILLh', 'KILL1', 'KILL2', 'KILL1', 'kill1@hgmail.com', 'kill2@gmail.com', 'kill3@gmail.com', 65542, 85421, 52410, 'gyfbn ', 'ujkmn ', 'a@vvvfm.com', '2024-03-16', '2024-03-07', 'KILL', 'hbjhbjhbgg', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `BANCA_CONTI`
--

CREATE TABLE `BANCA_CONTI` (
  `BANCA_CONTO_ID` bigint(20) NOT NULL,
  `AZIENDA_ID` bigint(20) NOT NULL,
  `BANCA_NOME` varchar(255) DEFAULT NULL,
  `IBAN` varchar(255) DEFAULT NULL,
  `DATA_INIZIO` date DEFAULT NULL,
  `DATA_FINITO` date DEFAULT NULL,
  `E_ATTIVO` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `BANCA_CONTI`
--

INSERT INTO `BANCA_CONTI` (`BANCA_CONTO_ID`, `AZIENDA_ID`, `BANCA_NOME`, `IBAN`, `DATA_INIZIO`, `DATA_FINITO`, `E_ATTIVO`) VALUES
(1, 12, 'Bank A', 'IT00A12345678901234567890', NULL, NULL, b'0'),
(2, 2, 'Bank B', 'IT00B12345678901234567890', NULL, NULL, b'1'),
(3, 3, 'Bank C', 'IT00C12345678901234567890', NULL, NULL, b'1'),
(4, 4, 'Bank D', 'IT00D12345678901234567890', NULL, NULL, b'1'),
(5, 5, 'Bank E', 'IT00E12345678901234567890', NULL, NULL, b'1'),
(6, 6, 'Bank F', 'IT00F12345678901234567890', NULL, NULL, b'1'),
(7, 2, 'Bank G', 'IT00G12345678901234567890', NULL, NULL, b'1'),
(8, 8, 'Bank H', 'IT00H12345678901234567890', NULL, NULL, b'1'),
(9, 9, 'Bank I', 'IT00I12345678901234567890', NULL, NULL, b'1'),
(10, 10, 'Bank J', 'IT00J12345678901234567890', NULL, NULL, b'1'),
(12, 1, 'BKT', '682852ASD', NULL, NULL, b'0'),
(13, 6, 'OTP', '456263521', NULL, NULL, b'1'),
(14, 14, 'otp', '890', NULL, NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `FATTURE`
--

CREATE TABLE `FATTURE` (
  `FATTURA_ID` bigint(20) NOT NULL,
  `AZIENDA_ID` bigint(20) NOT NULL,
  `BANCA_CONTO_ID` bigint(20) DEFAULT NULL,
  `FATTURA_NOME` varchar(255) DEFAULT NULL,
  `VALORE` decimal(20,2) DEFAULT NULL,
  `VALORE_IVA_INCLUSA` decimal(20,2) DEFAULT NULL,
  `IVA` decimal(20,2) DEFAULT NULL,
  `MONETA` varchar(10) DEFAULT NULL,
  `DATA_FATTURAZIONE` date DEFAULT NULL,
  `DATA_SCADENZA` date DEFAULT NULL,
  `DATA_PAGAMENTO` date DEFAULT NULL,
  `DESCRIZIONE` varchar(255) DEFAULT NULL,
  `E_PAGATO` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `FATTURE`
--

INSERT INTO `FATTURE` (`FATTURA_ID`, `AZIENDA_ID`, `BANCA_CONTO_ID`, `FATTURA_NOME`, `VALORE`, `VALORE_IVA_INCLUSA`, `IVA`, `MONETA`, `DATA_FATTURAZIONE`, `DATA_SCADENZA`, `DATA_PAGAMENTO`, `DESCRIZIONE`, `E_PAGATO`) VALUES
(1, 1, NULL, 'n', 1000.00, 2000.00, 100.00, '0', '2023-01-15', NULL, '2023-02-15', 'Product A', b'0'),
(2, 2, NULL, NULL, 1500.00, 1800.00, 300.00, '1', '2023-02-15', NULL, '2023-03-15', 'Product B', b'1'),
(3, 3, NULL, NULL, 2000.00, 2400.00, 400.00, '1', '2023-03-15', NULL, '2023-04-15', 'Product C', b'1'),
(4, 4, NULL, NULL, 2500.00, 3000.00, 500.00, '1', '2023-04-15', NULL, '2023-05-15', 'Product D', b'1'),
(5, 5, NULL, NULL, 3000.00, 3600.00, 600.00, '1', '2023-05-15', NULL, '2023-06-15', 'Product E', b'1'),
(6, 6, NULL, NULL, 3500.00, 4200.00, 700.00, '1', '2023-06-15', NULL, '2023-07-15', 'Product F', b'1'),
(7, 7, NULL, NULL, 4000.00, 4800.00, 800.00, '1', '2023-07-15', NULL, '2023-08-15', 'Product G', b'1'),
(8, 8, NULL, NULL, 4500.00, 5400.00, 900.00, '1', '2023-08-15', NULL, '2023-09-15', 'Product H', b'1'),
(9, 9, NULL, NULL, 5000.00, 6000.00, 1000.00, '1', '2023-09-15', NULL, '2023-10-15', 'Product I', b'1'),
(10, 10, NULL, NULL, 5500.00, 6600.00, 1100.00, '1', '2023-10-15', NULL, '2023-11-15', 'Product J', b'1'),
(11, 1, NULL, 'Fattura2', 586.00, 536.00, 9.00, '0', '0000-00-00', NULL, '0000-00-00', '', b'1'),
(12, 1, NULL, 'Fattura2', 586.00, 536.14, 9.30, '0', '0000-00-00', NULL, '0000-00-00', '', b'1'),
(13, 2, NULL, 'Fattura3', 120.00, 117.42, 2.20, '0', '2024-03-10', NULL, '2024-03-16', 'Pensioni', b'0'),
(14, 7, NULL, 'Fattura4', 102.56, 82.94, 23.65, '0', '2024-03-27', NULL, '2024-03-29', 'YEA', b'0'),
(15, 6, NULL, 'Fattura1', 56679.00, 68014.80, 20.00, 'KRW', '2024-03-11', NULL, '2024-03-25', 'b', b'1'),
(16, 7, NULL, 'Fattura1', 10.00, 10.10, 1.00, 'KRW', '2024-03-28', NULL, '2024-03-29', '', b'0'),
(17, 7, NULL, 'Fattura1', 10.00, 10.10, 1.00, 'KRW', '2024-03-28', NULL, '2024-03-29', '', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `IMPIANTI`
--

CREATE TABLE `IMPIANTI` (
  `IMPIANTO_ID` bigint(25) NOT NULL,
  `AZIENDA_ID` bigint(25) NOT NULL,
  `STRUTTURA_ID` bigint(25) NOT NULL,
  `REPARTO_ID` bigint(25) NOT NULL,
  `NOME_UTA` varchar(255) DEFAULT NULL,
  `CAPACITA_UTA` decimal(20,2) DEFAULT NULL,
  `MANDATA` decimal(20,2) DEFAULT NULL,
  `RIPRESA` decimal(20,2) DEFAULT NULL,
  `ESPULSIONE` decimal(20,2) DEFAULT NULL,
  `PRESA_ARIA_ESTERNA` decimal(20,2) DEFAULT NULL,
  `ULTIMA_ATTIVITA` varchar(255) DEFAULT NULL,
  `DATA_DI_INIZIO_UTILIZZO` date DEFAULT NULL,
  `DATA_ULTIMA_ATT` date DEFAULT NULL,
  `E_ATTIVO` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `IMPIANTI`
--

INSERT INTO `IMPIANTI` (`IMPIANTO_ID`, `AZIENDA_ID`, `STRUTTURA_ID`, `REPARTO_ID`, `NOME_UTA`, `CAPACITA_UTA`, `MANDATA`, `RIPRESA`, `ESPULSIONE`, `PRESA_ARIA_ESTERNA`, `ULTIMA_ATTIVITA`, `DATA_DI_INIZIO_UTILIZZO`, `DATA_ULTIMA_ATT`, `E_ATTIVO`) VALUES
(1, 1, 1, 1, 'n', 74.00, 852.00, 7410.00, 96521.00, 9541.00, 'plkm', '2024-03-23', '2024-03-31', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `LOGS`
--

CREATE TABLE `LOGS` (
  `LOG_ID` bigint(20) NOT NULL,
  `UTENTE_ID` bigint(20) NOT NULL,
  `ENTITY` varchar(140) NOT NULL,
  `ENTITY_ID` bigint(20) DEFAULT NULL,
  `ACTION` varchar(140) NOT NULL,
  `ATTRIBUTE` longtext NOT NULL,
  `OLD_VALUE` longtext NOT NULL,
  `NEW_VALUE` longtext NOT NULL,
  `DATE` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `LOGS`
--

INSERT INTO `LOGS` (`LOG_ID`, `UTENTE_ID`, `ENTITY`, `ENTITY_ID`, `ACTION`, `ATTRIBUTE`, `OLD_VALUE`, `NEW_VALUE`, `DATE`) VALUES
(1, 2, 'Utenti', NULL, 'Creare', '', '', '', '2024-06-09 23:36:33');

-- --------------------------------------------------------

--
-- Table structure for table `REPARTI`
--

CREATE TABLE `REPARTI` (
  `REPARTO_ID` bigint(20) NOT NULL,
  `AZIENDA_ID` bigint(20) NOT NULL,
  `STRUTTURA_ID` bigint(20) NOT NULL,
  `REPARTO_NOME` varchar(255) DEFAULT NULL,
  `INDIRIZZO` varchar(255) DEFAULT NULL,
  `CITTA` varchar(255) DEFAULT NULL,
  `DATA_INIZIO` date DEFAULT NULL,
  `DATA_FINITO` date DEFAULT NULL,
  `INFORMAZIONI` varchar(255) DEFAULT NULL,
  `E_ATTIVO` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `REPARTI`
--

INSERT INTO `REPARTI` (`REPARTO_ID`, `AZIENDA_ID`, `STRUTTURA_ID`, `REPARTO_NOME`, `INDIRIZZO`, `CITTA`, `DATA_INIZIO`, `DATA_FINITO`, `INFORMAZIONI`, `E_ATTIVO`) VALUES
(1, 1, 1, 'Production', '123 Factory St', 'New York', NULL, NULL, 'Some information about Production department', b'0'),
(2, 2, 2, 'Assembly', '456 Assembly St', 'Los Angeles', NULL, NULL, 'Some information about Assembly department', b'1'),
(3, 3, 3, 'Quality Control', '789 QC St', 'Chicago', NULL, NULL, 'Some information about Quality Control department', b'1'),
(4, 4, 4, 'Research & Development', '101 R&D St', 'Houston', NULL, NULL, 'Some information about Research & Development department', b'1'),
(5, 5, 5, 'Maintenance', '202 Maintenance St', 'Phoenix', NULL, NULL, 'Some information about Maintenance department', b'1'),
(6, 6, 6, 'Logistics', '303 Logistics St', 'Philadelphia', NULL, NULL, 'Some information about Logistics department', b'1'),
(7, 7, 7, 'Marketing', '404 Marketing St', 'San Antonio', NULL, NULL, 'Some information about Marketing department', b'1'),
(8, 8, 8, 'Human Resources', '505 HR St', 'San Diego', NULL, NULL, 'Some information about Human Resources department', b'1'),
(9, 9, 9, 'Finance', '606 Finance St', 'Dallas', NULL, NULL, 'Some information about Finance department', b'1'),
(10, 10, 10, 'Information Technology', '707 IT St', 'Austin', NULL, NULL, 'Some information about IT department', b'1'),
(11, 5, 5, 'AS', 'Vendorss  ', 'dddddn', NULL, NULL, 'ddd\\\\\\\"\\\"j', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `STRUTTURE`
--

CREATE TABLE `STRUTTURE` (
  `STRUTTURA_ID` bigint(20) NOT NULL,
  `AZIENDA_ID` bigint(20) NOT NULL,
  `STRUTTURA_NOME` varchar(255) DEFAULT NULL,
  `INDIRIZZO` varchar(255) DEFAULT NULL,
  `CITTA` varchar(255) DEFAULT NULL,
  `DATA_INIZIO` date DEFAULT NULL,
  `DATA_FINITO` date DEFAULT NULL,
  `INFORMAZIONI` varchar(255) DEFAULT NULL,
  `E_ATTIVO` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `STRUTTURE`
--

INSERT INTO `STRUTTURE` (`STRUTTURA_ID`, `AZIENDA_ID`, `STRUTTURA_NOME`, `INDIRIZZO`, `CITTA`, `DATA_INIZIO`, `DATA_FINITO`, `INFORMAZIONI`, `E_ATTIVO`) VALUES
(1, 1, 'Headquarters', '123 HQ St', 'New York', NULL, NULL, 'Some information about Headquarters', b'1'),
(2, 1, 'Branch Office', '456 Branch Stgg', 'vLos Angeles', NULL, NULL, 'Some information about Branch Office', b'1'),
(3, 3, 'Warehouse', '789 Warehouse St', 'Chicago', NULL, NULL, 'Some information about Warehouse', b'1'),
(4, 4, 'Lab', '101 Lab St', 'Houston', NULL, NULL, 'Some information about Lab', b'1'),
(5, 5, 'Plant', '202 Plant St', 'Phoenix', NULL, NULL, 'Some information about Plant', b'1'),
(6, 6, 'Distribution Center', '303 DC St', 'Philadelphia', NULL, NULL, 'Some information about Distribution Center', b'1'),
(7, 7, 'Store', '404 Store St', 'San Antonio', NULL, NULL, 'Some information about Store', b'1'),
(8, 8, 'Office Building', '505 Office St', 'San Diego', NULL, NULL, 'Some information about Office Building', b'1'),
(9, 9, 'Data Center', '606 Data St', 'Dallas', NULL, NULL, 'Some information about Data Center', b'1'),
(10, 10, 'Tech Hub', '707 Tech St', 'Austin', NULL, NULL, 'Some information about Tech Hub', b'1'),
(11, 2, 'Headquarters', '123 HQ St', 'New York', NULL, NULL, 'Some information about Headquarters', b'1'),
(12, 3, 'Struttura A', 'wr', 'ds', NULL, NULL, 'HELLO', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `UTENTI`
--

CREATE TABLE `UTENTI` (
  `UTENTE_ID` bigint(20) NOT NULL,
  `NOME` varchar(255) DEFAULT NULL,
  `COGNOME` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  `NUMERO` bigint(20) DEFAULT NULL,
  `AZIENDA_POSIZIONE` varchar(255) DEFAULT NULL,
  `RUOLO` varchar(255) DEFAULT NULL,
  `DATA_INIZIO` date DEFAULT NULL,
  `DATA_FINITO` date DEFAULT NULL,
  `E_ATTIVO` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `UTENTI`
--

INSERT INTO `UTENTI` (`UTENTE_ID`, `NOME`, `COGNOME`, `EMAIL`, `PASSWORD`, `NUMERO`, `AZIENDA_POSIZIONE`, `RUOLO`, `DATA_INIZIO`, `DATA_FINITO`, `E_ATTIVO`) VALUES
(1, 'Krenar', 'Sulejmani', 'ksulejmani@gmail.com', '$2y$10$VfyvZkQnOUeF2A/9d5/Hve6blShzD6Ny2QBPo0RJLu10.A/0KDXBG', NULL, NULL, 'Admin', NULL, NULL, b'0'),
(2, 'Endi', 'Trico', 'enditrico@gmail.com', '$2y$10$tgcyrJpzKVEq/tCLsFdneeLi2Pyp/tLVZDHZkpyiCaW1n0Xa9IAjS', 695725489, 'Assistant', 'Admin', NULL, NULL, b'1'),
(3, 'John', 'Doee', 'john@example.com', '$2y$10$OyGdy1eel2WBIzxlZ7HAfOrXk9YKF9pAV8CvwTGmLD4ajZm2.XT7e', 695789652, 'Manager', 'Cliente', NULL, NULL, b'1'),
(4, 'Jane', 'Doe', 'jane@example.com', 'password2', 2147483647, 'Supervisor', 'User', NULL, NULL, b'1'),
(5, 'Mark', 'Smith', 'mark@example.com', 'password3', 2147483647, 'Employee', 'User', NULL, NULL, b'1'),
(6, 'Alice', 'Johnson', 'alice@example.com', 'password4', 2147483647, 'Manager', 'Admin', NULL, NULL, b'1'),
(7, 'Bob', 'Smith', 'bob@example.com', 'password5', 2147483647, 'Supervisor', 'User', NULL, NULL, b'1'),
(8, 'Emily', 'Brown', 'emily@example.com', 'password6', 2147483647, 'Employee', 'User', NULL, NULL, b'1'),
(9, 'Michael', 'Taylor', 'michael@example.com', 'password7', 2147483647, 'Manager', 'Admin', NULL, NULL, b'1'),
(10, 'Sarah', 'White', 'sarah@example.com', 'password8', 2147483647, 'Supervisor', 'User', NULL, NULL, b'1'),
(11, 'David', 'Davis', 'david@example.com', 'password9', 2147483647, 'Employee', 'User', NULL, NULL, b'1'),
(12, 'Jennifer', 'Martinez', 'jennifer@example.com', 'password10', 2147483647, 'Manager', 'Admin', NULL, NULL, b'1'),
(13, 'Dajna', 'Nako', 'dnako@gmail.com', '$2y$10$7q2H7kaSkXwyhfkP8xQlMeHy61f2hgEuI9jDTpzfui7r3sdWoH4Ya', 0, 'Assistant', NULL, NULL, NULL, b'1'),
(14, 'Dajna', 'Nako', 'dajnanako@gmail.com', '$2y$10$Y9sQCW/kK75cT4otiffmCOFHTHNo6jPk3WiaQ0IKM1GpT1qRvxgea', 695789652, 'Assistant', NULL, NULL, NULL, b'1'),
(15, 'Elti', 'Hoxha', 'elti@gmail.com', '$2y$10$oau5SaUiewyQnXaw0Gu2cegGikxgM6wQfLiNRtnKEQ7iq33zgbxUC', 695789652, 'Assistant', NULL, NULL, NULL, b'1'),
(16, 'Renis', 'Garxenaj', 'renis@gmail.com', '$2y$10$RytjtNu9SbLjXTbA6xwqfOaciELrF6ZcbfFxpGtzxARyZ6CTDzavu', 695789652, 'Assistant', NULL, NULL, NULL, b'1'),
(17, 'Elti', 'Nako', 'eltii@gmail.com', '$2y$10$OoAy0Nvfob7iFraQX4ZdmOwUFfPRUpj3Jy7FuAatlli.U7NXEjBvm', 695789652, 'Assistant', NULL, NULL, NULL, b'1'),
(18, 'Dajna', 'Hoxha', 'edlti@gmail.com', '$2y$10$IOe32H6xBoxUH7TDLVcC1.HEbnx2aQ7Lz1ebugckkXOqS7io2NWsq', 695789652, 'Assistant', 'Cliente', NULL, NULL, b'1'),
(19, 'Keisi', 'Bylyku', 'keisi@gmail.com', '$2y$10$aU7ILt1SwcW4yoexZDLXievnIPwhtf8vHntKfp7CkjsH2qxN51G8C', 695789652, 'Assistant', 'Cliente', NULL, NULL, b'1'),
(20, 'Redi', 'Trifoni', 'redi@gmail.com', '$2y$10$Gq7Q9N8GsxbuHAQoJi1QoeP6lOxb0/g9v3psF1FbgjEWJnOUSSvYW', 695789652, 'Assistant', 'Cliente', NULL, NULL, b'1'),
(21, 'Marenglen', 'Biba', 'mari@gmail.com', '$2y$10$DMgO1hzrQgPH3IzG2T4hcu9oP2pFIF5LuZGBzB/7GnPv7mKsHI.Fa', 695789652, 'Assistant', 'Cliente', NULL, NULL, b'1'),
(22, 'Lorena', 'Kola', 'lorenakola@unyt.edu.al', '$2y$10$0EiAqC31vNSI9mKqzo84o.rtZuInpPq2i7zF/bIWTMk386gsH/KAK', 695725896, 'CEO', 'Cliente', NULL, NULL, b'1'),
(23, 'Dajana', 'Aruci', 'dajanaaruci@unyt.edu.al', '$2y$10$8k.ZkrYBiqlEPOMxA2DGvuVyqNHm2tqJrSgmEgmJgVnRPyltQJedC', 695789652, 'Marketing', 'Cliente', NULL, NULL, b'1'),
(24, 'Fabjola', 'Shehu', 'fabi123@gmail.com', '$2y$10$pfRUd84VjmE6PhuADK/ohucUlM9vG9utHtTP079yjwEx7GSlrCpdC', 695789652, 'Assistant', 'Cliente', NULL, NULL, b'1'),
(25, 'Edona', 'Selim', 'edonaselim@gmail.com', '$2y$10$ZGtAwD0R81oKdozLW/X.R.hjqp9GQwZI3HcdM8yB0oPYrsVHHfRwi', 6589321456, 'Shefe', 'Cliente', NULL, NULL, b'1'),
(26, 'Renis', 'Hoxha', 'r@gmail.com', '$2y$10$n1sgos0h68AVuIgGcYvTrOc76LTi2ep.lOSincminT1n8SsWetDnO', 695789652, 'Manager', 'Cliente', NULL, NULL, b'1'),
(27, 'ewewew', 'ewew', 'werwerewr@gmail.com', '$2y$10$bdlta.pgWePvWKFMDokdJ.xxq/DMpYVOzGBUDc3KpYRRYDud3hRnq', 0, 'weewew', 'Admin', NULL, NULL, b'1'),
(28, 'Fabi', 'Lokuj', 'fabilokuj@gmail.com', '$2y$10$jzZWnfLsvQZ79qkWVxtlAuaJUPB4yfKmutDjchI0yX2Tmxv4DB8Om', 695725896, '', 'Cliente', '2024-06-06', '0000-00-00', b'0'),
(29, 'Elti', 'Bylyku', 'dnakso@gmail.com', '$2y$10$J/6EWP210KGkdsZKnFQcUuekQA1J0FX9xoSHp8w2Hrp.taxvtUkiu', 6589321456, '', 'Cliente', '2024-06-13', '0000-00-00', b'0'),
(30, 'Redi', 'Hoxha', 'elti@gmail.coms', '$2y$10$LCmCdIN4yBoeH8wlCSPpvu3jcoSNmMT832OHpi8V.NLUCjXxwNOMu', 695725896, '', 'Cliente', '2024-06-06', '0000-00-00', b'0'),
(31, 'Dajna', 'Bylyku', 'dnako@bgmail.com', '$2y$10$QG23/FhqzZuHZnIf0vXsWuz75J3mL/h2PvHuGUrS5atXR90vnhZA6', 6589321456, '', 'Cliente', '2024-06-07', '0000-00-00', b'0'),
(32, 'Dajna', 'Bylyku', 'enditridco@gmail.com', '$2y$10$DOkwcHlPTGnkEvKQMzxHIugv6Se4Z3nBIJmiWHstLDZpEL/D3GBAW', 6589321456, '', 'Admin', '2024-06-06', '0000-00-00', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `UTENTI_AZIENDE`
--

CREATE TABLE `UTENTI_AZIENDE` (
  `UTENTE_ID` bigint(20) NOT NULL,
  `AZIENDA_ID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `UTENTI_AZIENDE`
--

INSERT INTO `UTENTI_AZIENDE` (`UTENTE_ID`, `AZIENDA_ID`) VALUES
(3, 2),
(3, 5),
(3, 7),
(3, 8),
(3, 9),
(5, 6),
(10, 10),
(21, 2),
(21, 3),
(21, 4),
(21, 7),
(25, 5),
(26, 1),
(27, 8),
(28, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AZIENDE`
--
ALTER TABLE `AZIENDE`
  ADD PRIMARY KEY (`AZIENDA_ID`);

--
-- Indexes for table `BANCA_CONTI`
--
ALTER TABLE `BANCA_CONTI`
  ADD PRIMARY KEY (`BANCA_CONTO_ID`),
  ADD KEY `FK_AZIENDE_BANCA_ACCOUNTS` (`AZIENDA_ID`);

--
-- Indexes for table `FATTURE`
--
ALTER TABLE `FATTURE`
  ADD PRIMARY KEY (`FATTURA_ID`),
  ADD KEY `FK_AZIENDE_FATTURE` (`AZIENDA_ID`),
  ADD KEY `FK_BANCA_CONTI_FATTURE` (`BANCA_CONTO_ID`) USING BTREE;

--
-- Indexes for table `IMPIANTI`
--
ALTER TABLE `IMPIANTI`
  ADD PRIMARY KEY (`IMPIANTO_ID`);

--
-- Indexes for table `LOGS`
--
ALTER TABLE `LOGS`
  ADD PRIMARY KEY (`LOG_ID`);

--
-- Indexes for table `REPARTI`
--
ALTER TABLE `REPARTI`
  ADD PRIMARY KEY (`REPARTO_ID`),
  ADD UNIQUE KEY `UQ_AZIENDA_ID_STRUTTURA_ID_REPARTO_NOME_REPARTO` (`AZIENDA_ID`,`STRUTTURA_ID`,`REPARTO_NOME`),
  ADD KEY `FK_STRUTTURE_REPARTI` (`STRUTTURA_ID`);

--
-- Indexes for table `STRUTTURE`
--
ALTER TABLE `STRUTTURE`
  ADD PRIMARY KEY (`STRUTTURA_ID`),
  ADD UNIQUE KEY `UQ_AZIENDA_ID_STRUTTURA_NOME_STRUTTURA` (`AZIENDA_ID`,`STRUTTURA_NOME`);

--
-- Indexes for table `UTENTI`
--
ALTER TABLE `UTENTI`
  ADD PRIMARY KEY (`UTENTE_ID`),
  ADD UNIQUE KEY `UQ_EMAIL_UTENTI` (`EMAIL`);

--
-- Indexes for table `UTENTI_AZIENDE`
--
ALTER TABLE `UTENTI_AZIENDE`
  ADD PRIMARY KEY (`UTENTE_ID`,`AZIENDA_ID`),
  ADD KEY `FK_AZIENDA_UTENTI_AZIENDE` (`AZIENDA_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AZIENDE`
--
ALTER TABLE `AZIENDE`
  MODIFY `AZIENDA_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `BANCA_CONTI`
--
ALTER TABLE `BANCA_CONTI`
  MODIFY `BANCA_CONTO_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `FATTURE`
--
ALTER TABLE `FATTURE`
  MODIFY `FATTURA_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `IMPIANTI`
--
ALTER TABLE `IMPIANTI`
  MODIFY `IMPIANTO_ID` bigint(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `LOGS`
--
ALTER TABLE `LOGS`
  MODIFY `LOG_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `REPARTI`
--
ALTER TABLE `REPARTI`
  MODIFY `REPARTO_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `STRUTTURE`
--
ALTER TABLE `STRUTTURE`
  MODIFY `STRUTTURA_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `UTENTI`
--
ALTER TABLE `UTENTI`
  MODIFY `UTENTE_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `BANCA_CONTI`
--
ALTER TABLE `BANCA_CONTI`
  ADD CONSTRAINT `FK_AZIENDE_BANCA_ACCOUNTS` FOREIGN KEY (`AZIENDA_ID`) REFERENCES `AZIENDE` (`AZIENDA_ID`);

--
-- Constraints for table `FATTURE`
--
ALTER TABLE `FATTURE`
  ADD CONSTRAINT `FK_AZIENDE_FATTURE` FOREIGN KEY (`AZIENDA_ID`) REFERENCES `AZIENDE` (`AZIENDA_ID`),
  ADD CONSTRAINT `FK_BANCA_CONTI_ID` FOREIGN KEY (`BANCA_CONTO_ID`) REFERENCES `BANCA_CONTI` (`BANCA_CONTO_ID`);

--
-- Constraints for table `REPARTI`
--
ALTER TABLE `REPARTI`
  ADD CONSTRAINT `FK_AZIENDE_REPARTI` FOREIGN KEY (`AZIENDA_ID`) REFERENCES `AZIENDE` (`AZIENDA_ID`),
  ADD CONSTRAINT `FK_STRUTTURE_REPARTI` FOREIGN KEY (`STRUTTURA_ID`) REFERENCES `STRUTTURE` (`STRUTTURA_ID`);

--
-- Constraints for table `STRUTTURE`
--
ALTER TABLE `STRUTTURE`
  ADD CONSTRAINT `FK_AZIENDE_STRUTTURE` FOREIGN KEY (`AZIENDA_ID`) REFERENCES `AZIENDE` (`AZIENDA_ID`);

--
-- Constraints for table `UTENTI_AZIENDE`
--
ALTER TABLE `UTENTI_AZIENDE`
  ADD CONSTRAINT `FK_AZIENDA_UTENTI_AZIENDE` FOREIGN KEY (`AZIENDA_ID`) REFERENCES `AZIENDE` (`AZIENDA_ID`),
  ADD CONSTRAINT `FK_UTENTI_UTENTI_AZIENDE` FOREIGN KEY (`UTENTE_ID`) REFERENCES `UTENTI` (`UTENTE_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
