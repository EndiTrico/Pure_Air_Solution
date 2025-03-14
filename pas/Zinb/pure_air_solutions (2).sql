-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2024 at 10:18 PM
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
-- Table structure for table `aziende`
--

CREATE TABLE `aziende` (
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
  `DATA_FINE` date DEFAULT NULL,
  `WEBSITE` varchar(2555) DEFAULT NULL,
  `INFORMAZIONI` varchar(255) DEFAULT NULL,
  `E_ATTIVO` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aziende`
--

INSERT INTO `aziende` (`AZIENDA_ID`, `AZIENDA_NOME`, `PARTITA_IVA`, `CODICE_FISCALE`, `CONTATTO_1`, `CONTATTO_2`, `CONTATTO_3`, `EMAIL_1`, `EMAIL_2`, `EMAIL_3`, `TELEFONO_1`, `TELEFONO_2`, `TELEFONO_3`, `INDIRIZZO`, `CITTA`, `INDIRIZZO_PEC`, `DATA_INIZIO`, `DATA_FINE`, `WEBSITE`, `INFORMAZIONI`, `E_ATTIVO`) VALUES
(1, 'Company A', '12345678901', 'CF12345678901', 'John Doe', 'Jane Doe', 'Mark Smith', 'john@example.com', 'jane@example.com', 'mark@example.com', 1234567890, 2147483647, 2147483647, '123 Main St', 'New York', 'companya@example.com', '2023-01-01', '2024-07-13', 'https://www.companya.com', 'Some information about Company A', b'1'),
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
(12, 'Ana', 'jjjjjj', '2020', '', '', '', 'anaperduka@gmail.com', '', '', 0, 0, 0, '', '', 'a@fm.com', '0000-00-00', '2024-08-10', '', '', b'0'),
(13, 'KILL', 'KILL', 'KILL', 'KILL1', 'KILL2', 'KILL3', 'kill1@gmail.com', 'kill2@gmail.com', 'kill3@gmail.com', 123, 456, 789, 'KILL', 'KILL', 'kill@gmail.com', '2024-03-11', '2024-03-12', 'KILL', 'KILL', b'1'),
(14, 'American Hospital Tirana500', 'KILL5', 'swewewe5', 'KILL155', 'KILL25', 'KILL35', 'anaperduka@unyt.edu.com5', 'kill2@gmail.com5', 'kill3@gmail.com5', 2156455, 26545, 6446555, 'vgjbh5', '5', 'hm@gmail.com5', '2024-04-04', '2024-07-13', 'KILL55', '  Young01 55 ', b'0'),
(15, 'American Hospital1112', 'KILLhh', 'KILLh', 'KILL1', 'KILL2', 'KILL1', 'kill1@hgmail.com', 'kill2@gmail.com', 'kill3@gmail.com', 65542, 85421, 52410, 'gyfbn ', 'ujkmn ', 'a@vvvfm.com', '2024-03-16', '2024-07-13', 'KILL', 'hbjhbjhbgg', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `banca_conti`
--

CREATE TABLE `banca_conti` (
  `BANCA_CONTO_ID` bigint(20) NOT NULL,
  `AZIENDA_ID` bigint(20) NOT NULL,
  `BANCA_NOME` varchar(255) DEFAULT NULL,
  `IBAN` varchar(255) DEFAULT NULL,
  `DATA_INIZIO` date DEFAULT NULL,
  `DATA_FINE` date DEFAULT NULL,
  `E_ATTIVO` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banca_conti`
--

INSERT INTO `banca_conti` (`BANCA_CONTO_ID`, `AZIENDA_ID`, `BANCA_NOME`, `IBAN`, `DATA_INIZIO`, `DATA_FINE`, `E_ATTIVO`) VALUES
(1, 1, 'Bank A', 'IT00A12345678901234567890', '2024-07-03', '2024-07-13', b'0'),
(2, 2, 'Bank B', 'IT00B12345678901234567890', NULL, '2024-07-13', b'0'),
(3, 3, 'Bank C', 'IT00C12345678901234567890', NULL, '2024-07-13', b'0'),
(4, 4, 'Bank D', 'IT00D12345678901234567890', NULL, '2024-07-13', b'0'),
(5, 5, 'Bank E', 'IT00E12345678901234567890', NULL, '2024-08-10', b'0'),
(6, 6, 'Bank F', 'IT00F12345678901234567890', NULL, NULL, b'1'),
(7, 2, 'Bank G', 'IT00G12345678901234567890', NULL, '2024-07-13', b'0'),
(8, 8, 'Bank H', 'IT00H12345678901234567890', NULL, NULL, b'1'),
(9, 9, 'Bank I', 'IT00I12345678901234567890', NULL, NULL, b'1'),
(10, 10, 'Bank J', 'IT00J12345678901234567890', NULL, NULL, b'1'),
(12, 1, 'BKT', '682852ASD', NULL, NULL, b'0'),
(13, 6, 'OTP', '456263521', NULL, NULL, b'1'),
(14, 5, 'RZB', '55555', '2024-07-24', '2024-07-31', b'1'),
(15, 7, 'OTP', 'bhhggghhv bij', '2024-07-24', NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `documenti`
--

CREATE TABLE `documenti` (
  `DOCUMENTO_ID` bigint(20) NOT NULL,
  `AZIENDA_ID` bigint(20) NOT NULL,
  `STRUTTURA_ID` bigint(20) NOT NULL,
  `NOME` varchar(1024) NOT NULL,
  `PERCORSO` varchar(3072) DEFAULT NULL,
  `DATA_CARICAMENTO` datetime DEFAULT current_timestamp(),
  `DATA_CANCELLATA` datetime DEFAULT NULL,
  `E_ATTIVO` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documenti`
--

INSERT INTO `documenti` (`DOCUMENTO_ID`, `AZIENDA_ID`, `STRUTTURA_ID`, `NOME`, `PERCORSO`, `DATA_CARICAMENTO`, `DATA_CANCELLATA`, `E_ATTIVO`) VALUES
(3, 1, 1, '', './raw/LOMA/Supplies4medics_Presantation.pdf', '2024-07-18 00:00:00', NULL, b'0'),
(4, 1, 1, 'Invoice-AD2B0D35-0005.pdf', 'files/Invoice-AD2B0D35-0005.pdf', '2024-07-28 12:07:26', NULL, b'1'),
(5, 1, 1, 'n.png', 'files/n.png', '2024-07-28 12:13:18', NULL, b'1'),
(6, 1, 1, 'add_file.png', 'files/shqip/add_file.png', '2024-07-28 13:31:54', '2024-07-28 18:19:10', b'0'),
(7, 1, 1, 'remove.png', 'files/remove.png', '2024-07-28 17:43:48', '2024-08-03 14:00:55', b'0'),
(8, 1, 1, 'delete_file.png', 'files/delete_file.png', '2024-07-28 17:48:43', '2024-07-28 17:48:54', b'0'),
(9, 1, 1, 'FA_109993144714.pdf', 'files/shqip/FA_109993144714.pdf', '2024-07-28 18:20:10', '2024-07-28 18:20:59', b'0'),
(10, 1, 1, 'NAM SP24 Project Work.pdf', 'files/NAM SP24 Project Work.pdf', '2024-07-28 18:26:18', NULL, b'1'),
(11, 1, 2, 'small_logo.png', 'files/breshka/small_logo.png', '2024-08-03 13:52:48', NULL, b'1'),
(12, 1, 2, 'Answer.html', 'files/Answer.html', '2024-08-03 18:06:50', '2024-08-03 20:28:53', b'0'),
(13, 1, 2, 'RickAndMortyScripts.csv', 'files/RickAndMortyScripts.csv', '2024-08-03 20:33:21', NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `fatture`
--

CREATE TABLE `fatture` (
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
-- Dumping data for table `fatture`
--

INSERT INTO `fatture` (`FATTURA_ID`, `AZIENDA_ID`, `BANCA_CONTO_ID`, `FATTURA_NOME`, `VALORE`, `VALORE_IVA_INCLUSA`, `IVA`, `MONETA`, `DATA_FATTURAZIONE`, `DATA_SCADENZA`, `DATA_PAGAMENTO`, `DESCRIZIONE`, `E_PAGATO`) VALUES
(1, 6, 6, 'n', 555544434.00, 861110539.03, 55.00, 'USD', '2023-01-27', '2024-09-06', NULL, 'nn', b'0'),
(2, 5, NULL, NULL, 5455.00, 1800.00, 50.00, 'USD', '2023-02-15', NULL, NULL, 'nn', b'0'),
(3, 3, NULL, NULL, 2000.00, 2400.00, 400.00, '1', '2023-03-15', NULL, '2024-07-13', 'Product C', b'1'),
(4, 4, NULL, NULL, 2500.00, 3000.00, 20.00, 'INR', '2023-04-15', NULL, NULL, 'Product D', b'0'),
(5, 5, NULL, NULL, 3000.00, 3600.00, 600.00, '1', '2023-05-15', NULL, '2023-06-15', 'Product E', b'1'),
(6, 6, NULL, NULL, 3500.00, 4200.00, 700.00, '1', '2023-06-15', NULL, '2023-07-15', 'Product F', b'1'),
(7, 7, NULL, NULL, 4000.00, 4800.00, 800.00, '1', '2023-07-15', NULL, '2023-08-15', 'Product G', b'1'),
(8, 8, NULL, NULL, 4500.00, 5400.00, 900.00, '1', '2023-08-15', NULL, '2023-09-15', 'Product H', b'1'),
(9, 9, NULL, NULL, 5000.00, 6000.00, 1000.00, '1', '2023-09-15', NULL, '2023-10-15', 'Product I', b'1'),
(10, 10, NULL, NULL, 5500.00, 6600.00, 1100.00, '1', '2023-10-15', NULL, '2023-11-15', 'Product J', b'1'),
(11, 1, NULL, 'Fattura2', 586.00, 536.00, 9.00, '0', '0000-00-00', NULL, '0000-00-00', '', b'1'),
(12, 1, NULL, 'Fattura2', 586.00, 536.14, 9.30, '0', '0000-00-00', NULL, '0000-00-00', '', b'1'),
(13, 2, NULL, 'Fattura3', 120.00, 117.42, 2.20, 'USD', '2024-03-10', '2024-08-01', '2024-03-16', 'Pensioni', b'0'),
(14, 7, NULL, 'Fattura4', 102.56, 82.94, 23.65, '0', '2024-03-27', NULL, '2024-03-29', 'YEA', b'0'),
(15, 6, NULL, 'Fattura1', 56679.00, 68014.80, 20.00, 'KRW', '2024-03-11', NULL, '2024-03-25', 'b', b'1'),
(16, 7, NULL, 'Fattura1', 10.00, 10.10, 1.00, 'KRW', '2024-03-28', NULL, '2024-03-29', '', b'0'),
(17, 7, NULL, 'Fattura1', 10.00, 10.10, 1.00, 'TRY', '2024-03-28', '2024-08-28', '2024-03-29', '', b'0'),
(18, 5, NULL, NULL, 23.00, 27.60, 20.00, 'EUR', NULL, NULL, NULL, '', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `impianti`
--

CREATE TABLE `impianti` (
  `IMPIANTO_ID` bigint(20) NOT NULL,
  `AZIENDA_ID` bigint(20) NOT NULL,
  `STRUTTURA_ID` bigint(20) NOT NULL,
  `REPARTO_ID` bigint(20) NOT NULL,
  `IMPIANTO_NOME` varchar(255) DEFAULT NULL,
  `CAPACITA_UTA` decimal(20,2) DEFAULT NULL,
  `MANDATA` decimal(20,2) DEFAULT NULL,
  `RIPRESA` decimal(20,2) DEFAULT NULL,
  `ESPULSIONE` decimal(20,2) DEFAULT NULL,
  `PRESA_ARIA_ESTERNA` decimal(20,2) DEFAULT NULL,
  `ULTIMA_ATTIVITA` varchar(255) DEFAULT NULL,
  `DATA_INIZIO` date DEFAULT NULL,
  `DATA_FINE` date DEFAULT NULL,
  `DATA_ULTIMA_ATT` date DEFAULT NULL,
  `E_ATTIVO` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `impianti`
--

INSERT INTO `impianti` (`IMPIANTO_ID`, `AZIENDA_ID`, `STRUTTURA_ID`, `REPARTO_ID`, `IMPIANTO_NOME`, `CAPACITA_UTA`, `MANDATA`, `RIPRESA`, `ESPULSIONE`, `PRESA_ARIA_ESTERNA`, `ULTIMA_ATTIVITA`, `DATA_INIZIO`, `DATA_FINE`, `DATA_ULTIMA_ATT`, `E_ATTIVO`) VALUES
(1, 4, 4, 4, 'IMPIANTO01', 74.00, 852.00, 7410.00, 96521.00, 9541.00, 'NOJ', '2024-11-14', '2024-08-10', '2024-03-31', b'0'),
(2, 3, 3, 3, 'IMPIANTO02', 25.00, 14.00, 18.00, 25.00, 19.00, '741', '2024-07-26', '0000-00-00', NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `LOG_ID` bigint(20) NOT NULL,
  `UTENTE_ID` bigint(20) NOT NULL,
  `ENTITA` varchar(140) NOT NULL,
  `ENTITA_ID` bigint(20) DEFAULT NULL,
  `AZIONE` varchar(140) DEFAULT NULL,
  `UA_AZIENDA_ID` bigint(20) DEFAULT NULL,
  `UA_UTENTE_ID` bigint(20) DEFAULT NULL,
  `ATTRIBUTO` longtext DEFAULT NULL,
  `VECCHIO_VALORE` longtext DEFAULT NULL,
  `NUOVO_VALORE` longtext DEFAULT NULL,
  `DATA_ORA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`LOG_ID`, `UTENTE_ID`, `ENTITA`, `ENTITA_ID`, `AZIONE`, `UA_AZIENDA_ID`, `UA_UTENTE_ID`, `ATTRIBUTO`, `VECCHIO_VALORE`, `NUOVO_VALORE`, `DATA_ORA`) VALUES
(1, 2, 'Utenti', NULL, 'Creare', NULL, NULL, '', '', '', '2024-06-09 23:36:33'),
(2, 2, 'Utenti', NULL, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-07 15:11:41'),
(3, 2, 'Strutture', 13, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-07 16:39:15'),
(4, 2, 'Strutture', 13, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-07 16:49:15'),
(5, 2, 'Strutture', 25, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-07 17:05:46'),
(6, 2, 'Conto Banco', 15, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-07 18:19:16'),
(7, 2, 'Utenti', NULL, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-07 18:51:54'),
(8, 2, 'Utenti', NULL, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-07 20:12:40'),
(9, 2, 'Utenti', NULL, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-07 20:15:15'),
(10, 2, 'Utenti', 41, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-07 20:17:24'),
(11, 2, 'Utenti', 39, 'Modificare', NULL, NULL, 'NOME', 'Alban02', 'Alban03', '2024-07-07 00:00:00'),
(12, 2, 'Utenti', 39, 'Modificare', NULL, NULL, 'COGNOME', 'Berisha02', 'Berisha03', '2024-07-07 00:00:00'),
(13, 2, 'Utenti', 39, 'Modificare', NULL, NULL, 'EMAIL', 'alban02@gmail.com', 'alban03@gmail.com', '2024-07-07 00:00:00'),
(14, 2, 'Utenti', 39, 'Modificare', NULL, NULL, 'DATA_FINITO', '2024-08-01', '2024-08-02', '2024-07-07 00:00:00'),
(15, 2, 'Utenti', 39, 'Modificare', NULL, NULL, 'NOME', 'Alban03', 'Alban04', '2024-07-07 00:00:00'),
(16, 2, 'Utenti', 39, 'Modificare', NULL, NULL, 'COGNOME', 'Berisha03', 'Berisha04', '2024-07-07 00:00:00'),
(17, 2, 'Utenti', 39, 'Modificare', NULL, NULL, 'EMAIL', 'alban03@gmail.com', 'alban04@gmail.com', '2024-07-07 00:00:00'),
(18, 2, 'UTENTI_AZIENDE', 6, 'Eliminare', NULL, NULL, 'AZIENDA_ID', '7', NULL, '2024-07-07 22:48:29'),
(19, 2, 'UTENTI_AZIENDE', 6, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '6', '2024-07-07 22:49:47'),
(20, 2, 'UTENTI_AZIENDE', 6, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '7', '2024-07-07 22:49:47'),
(21, 2, 'UTENTI_AZIENDE', 6, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '8', '2024-07-07 22:49:47'),
(22, 2, 'Utenti', 6, 'Modificare', NULL, NULL, 'NOME', 'Alice07', 'Alice08', '2024-07-07 22:49:47'),
(23, 2, 'Utenti', 6, 'Modificare', NULL, NULL, 'COGNOME', 'Johnson07', 'Johnson08', '2024-07-07 22:49:47'),
(24, 2, 'UTENTI_AZIENDE', 7, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '5', '2024-07-07 22:51:10'),
(25, 2, 'UTENTI_AZIENDE', 7, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '7', '2024-07-07 22:51:10'),
(26, 2, 'UTENTI_AZIENDE', 7, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '8', '2024-07-07 22:51:10'),
(27, 2, 'Utenti', 7, 'Modificare', NULL, NULL, 'NOME', 'Bob', 'Bob07', '2024-07-07 22:51:10'),
(28, 2, 'Utenti', 7, 'Modificare', NULL, NULL, 'COGNOME', 'Smith', 'Smith07', '2024-07-07 22:51:10'),
(29, 2, 'Utenti', 7, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-07-07 22:51:10'),
(30, 2, 'Utenti', 7, 'Modificare', NULL, NULL, 'RUOLO', 'User', 'Cliente', '2024-07-07 22:51:10'),
(31, 2, 'Utenti', 7, 'Modificare', NULL, NULL, 'DATA_INIZIO', NULL, '2024-07-21', '2024-07-07 22:51:10'),
(32, 2, 'Utenti', 7, 'Modificare', NULL, NULL, 'DATA_FINITO', NULL, '2024-07-31', '2024-07-07 22:51:10'),
(33, 2, 'UTENTI_AZIENDE', 6, 'Eliminare', NULL, NULL, 'AZIENDA_ID', '6', NULL, '2024-07-08 21:14:09'),
(34, 2, 'UTENTI_AZIENDE', 6, 'Eliminare', NULL, NULL, 'AZIENDA_ID', '7', NULL, '2024-07-08 21:14:09'),
(35, 2, 'UTENTI_AZIENDE', 6, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '4', '2024-07-08 21:14:09'),
(36, 2, 'UTENTI_AZIENDE', 6, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '5', '2024-07-08 21:14:09'),
(37, 2, 'UTENTI', NULL, 'Modificare', NULL, NULL, 'NOME', NULL, 'Alice10', NULL),
(38, 2, 'UTENTI', NULL, 'Modificare', NULL, NULL, 'COGNOME', NULL, 'Johnson10', NULL),
(39, 2, 'UTENTI', NULL, 'Modificare', NULL, NULL, 'EMAIL', NULL, 'alice10@example.com', NULL),
(40, 2, 'UTENTI', NULL, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, NULL),
(41, 2, 'UTENTI', NULL, 'Modificare', NULL, NULL, 'RUOLO', NULL, 'Admin', NULL),
(42, 2, 'UTENTI', NULL, 'Modificare', NULL, NULL, 'NUMERO', NULL, '0698745236', NULL),
(43, 2, 'UTENTI', NULL, 'Modificare', NULL, NULL, 'AZIENDA_POSIZIONE', NULL, 'BASKETBOLLISTE', NULL),
(44, 2, 'UTENTI', NULL, 'Modificare', NULL, NULL, 'DATA_INIZIO', NULL, '2024-07-12', NULL),
(45, 2, 'UTENTI', NULL, 'Modificare', NULL, NULL, 'DATA_FINITO', NULL, '2024-07-21', NULL),
(46, 2, 'UTENTI', 6, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, NULL),
(47, 2, 'UTENTI', 6, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-07-08 21:25:50'),
(48, 2, 'UTENTI_AZIENDE', 7, 'Eliminare', NULL, NULL, 'AZIENDA_ID', '5', NULL, '2024-07-08 21:30:20'),
(49, 2, 'UTENTI_AZIENDE', 7, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '1', '2024-07-08 21:30:20'),
(50, 2, 'UTENTI', 7, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-07-08 21:30:20'),
(51, 2, 'UTENTI_AZIENDE', 7, 'Eliminare', NULL, NULL, 'AZIENDA_ID', '1', NULL, '2024-07-08 21:37:19'),
(52, 2, 'UTENTI_AZIENDE', 7, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '2', '2024-07-08 21:37:19'),
(53, 2, 'UTENTI', 7, 'Modificare', NULL, NULL, 'NUMERO', '78910', '78910b nbhnmnmnnm', '2024-07-08 21:40:55'),
(54, 2, 'UTENTI', 7, 'Modificare', NULL, NULL, 'NUMERO', '78910', '78910b', '2024-07-08 21:43:39'),
(55, 2, 'UTENTI_AZIENDE', 7, 'Eliminare', NULL, NULL, 'AZIENDA_ID', '2', NULL, '2024-07-08 21:47:17'),
(56, 2, 'UTENTI_AZIENDE', 7, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '1', '2024-07-08 21:47:17'),
(57, 2, 'UTENTI', 7, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-07-08 21:47:17'),
(58, 2, 'UTENTI', 7, 'Modificare', NULL, NULL, 'NUMERO', '78910', '78910b200', '2024-07-08 21:47:17'),
(59, 2, 'UTENTI_AZIENDE', 13, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '1', '2024-07-08 21:48:18'),
(60, 2, 'UTENTI', 13, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-07-08 21:48:18'),
(61, 2, 'UTENTI_AZIENDE', 39, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '6', '2024-07-08 21:50:10'),
(62, 2, 'UTENTI_AZIENDE', 39, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '7', '2024-07-08 21:50:10'),
(63, 2, 'UTENTI_AZIENDE', 39, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '8', '2024-07-08 21:50:10'),
(64, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-07-08 21:50:10'),
(65, 2, 'UTENTI_AZIENDE', 18, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '1', '2024-07-08 22:00:56'),
(66, 2, 'UTENTI_AZIENDE', 18, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '2', '2024-07-08 22:00:56'),
(67, 2, 'UTENTI_AZIENDE', 18, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '3', '2024-07-08 22:00:56'),
(68, 2, 'UTENTI', 18, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-07-08 22:00:56'),
(69, 2, 'UTENTI_AZIENDE', 39, 'Eliminare', NULL, NULL, 'AZIENDA_ID', '6', NULL, '2024-07-08 22:04:40'),
(70, 2, 'UTENTI_AZIENDE', 39, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '1', '2024-07-08 22:04:40'),
(71, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'NOME', NULL, 'Alban555', '2024-07-08 22:04:40'),
(72, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'COGNOME', NULL, 'Berisha555', '2024-07-08 22:04:40'),
(73, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'EMAIL', NULL, 'alban04@gmail.com555', '2024-07-08 22:04:40'),
(74, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-07-08 22:04:40'),
(75, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'RUOLO', NULL, 'Cliente', '2024-07-08 22:04:40'),
(76, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'NUMERO', NULL, '6589321456222555', '2024-07-08 22:04:40'),
(77, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'AZIENDA_POSIZIONE', NULL, '555', '2024-07-08 22:04:40'),
(78, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_INIZIO', NULL, '2024-07-26', '2024-07-08 22:04:40'),
(79, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_FINITO', NULL, '2024-08-31', '2024-07-08 22:04:40'),
(80, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'NOME', NULL, 'Alban555', '2024-07-08 22:07:05'),
(81, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'COGNOME', NULL, 'Berisha555', '2024-07-08 22:07:05'),
(82, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'EMAIL', NULL, 'alban04@gmail.com555', '2024-07-08 22:07:05'),
(83, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'RUOLO', NULL, 'Cliente', '2024-07-08 22:07:05'),
(84, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'NUMERO', NULL, '6589321456222555', '2024-07-08 22:07:05'),
(85, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'AZIENDA_POSIZIONE', NULL, '555', '2024-07-08 22:07:05'),
(86, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_INIZIO', NULL, '2024-07-26', '2024-07-08 22:07:05'),
(87, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_FINITO', NULL, '2024-08-31', '2024-07-08 22:07:05'),
(88, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'NOME', NULL, 'Alban20', '2024-07-08 22:09:06'),
(89, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'COGNOME', NULL, 'Berisha25', '2024-07-08 22:09:06'),
(90, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'EMAIL', NULL, 'alban04@gmail.com5255', '2024-07-08 22:09:06'),
(91, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-07-08 22:09:06'),
(92, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'RUOLO', NULL, 'Cliente', '2024-07-08 22:09:06'),
(93, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'NUMERO', NULL, '6589321456222555', '2024-07-08 22:09:06'),
(94, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'AZIENDA_POSIZIONE', NULL, '555', '2024-07-08 22:09:06'),
(95, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_INIZIO', NULL, '2024-07-26', '2024-07-08 22:09:06'),
(96, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_FINITO', NULL, '2024-08-31', '2024-07-08 22:09:06'),
(97, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'NOME', NULL, 'Alban20', '2024-07-08 22:10:50'),
(98, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'COGNOME', NULL, 'Berisha25', '2024-07-08 22:10:50'),
(99, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'EMAIL', NULL, 'alban04@gmail.com5255', '2024-07-08 22:10:50'),
(100, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'RUOLO', NULL, 'Cliente', '2024-07-08 22:10:50'),
(101, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'NUMERO', NULL, '6589321456222555', '2024-07-08 22:10:50'),
(102, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'AZIENDA_POSIZIONE', NULL, '555', '2024-07-08 22:10:50'),
(103, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_INIZIO', NULL, '2024-07-26', '2024-07-08 22:10:50'),
(104, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_FINITO', NULL, '2024-08-31', '2024-07-08 22:10:50'),
(105, 2, 'UTENTI_AZIENDE', 39, 'Eliminare', NULL, NULL, 'AZIENDA_ID', '1', NULL, '2024-07-08 22:15:49'),
(106, 2, 'UTENTI_AZIENDE', 39, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '2', '2024-07-08 22:15:49'),
(107, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'NOME', 'Alban20', 'Alban800', '2024-07-08 22:15:49'),
(108, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'COGNOME', 'Berisha25', 'Berisha800', '2024-07-08 22:15:49'),
(109, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'EMAIL', 'alban04@gmail.com5255', 'alban04@gmail.com800', '2024-07-08 22:15:49'),
(110, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-07-08 22:15:49'),
(111, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'RUOLO', 'Cliente', 'Admin', '2024-07-08 22:15:49'),
(112, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'NUMERO', '6589321456222555', '800', '2024-07-08 22:15:49'),
(113, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'AZIENDA_POSIZIONE', '555', '800', '2024-07-08 22:15:49'),
(114, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_INIZIO', '2024-07-26', '2024-07-31', '2024-07-08 22:15:49'),
(115, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_FINITO', '2024-08-31', '2024-09-08', '2024-07-08 22:15:49'),
(116, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-07-08 22:16:42'),
(117, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'AZIENDA_NOME', 'American Hospital Tirana', 'American Hospital Tirana500', '2024-07-08 22:25:11'),
(118, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'PARTITA_IVA', 'KILL', 'KILL5', '2024-07-08 22:25:11'),
(119, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'CODICE_FISCALE', 'swewewe', 'swewewe5', '2024-07-08 22:25:11'),
(120, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'CONTATTO_1', 'KILL1', 'KILL155', '2024-07-08 22:25:11'),
(121, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'CONTATTO_2', 'KILL2', 'KILL25', '2024-07-08 22:25:11'),
(122, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'CONTATTO_3', 'KILL3', 'KILL35', '2024-07-08 22:25:11'),
(123, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'EMAIL_1', 'anaperduka@unyt.edu.com', 'anaperduka@unyt.edu.com5', '2024-07-08 22:25:11'),
(124, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'EMAIL_2', 'kill2@gmail.com', 'kill2@gmail.com5', '2024-07-08 22:25:11'),
(125, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'EMAIL_3', 'kill3@gmail.com', 'kill3@gmail.com5', '2024-07-08 22:25:11'),
(126, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'TELEFONO_1', '215645', '2156455', '2024-07-08 22:25:11'),
(127, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'TELEFONO_2', '2654', '26545', '2024-07-08 22:25:11'),
(128, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'TELEFONO_3', '644655', '6446555', '2024-07-08 22:25:11'),
(129, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'INDIRIZZO', 'vgjbh', 'vgjbh5', '2024-07-08 22:25:11'),
(130, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'CITTA', '', '5', '2024-07-08 22:25:11'),
(131, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'INDIRIZZO_PEC', 'hm@gmail.com', 'hm@gmail.com5', '2024-07-08 22:25:11'),
(132, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'DATA_INIZIO', '2024-03-16', '2024-04-04', '2024-07-08 22:25:11'),
(133, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'DATA_FINITO', NULL, '2024-08-01', '2024-07-08 22:25:11'),
(134, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'WEBSITE', 'KILL', 'KILL55', '2024-07-08 22:25:11'),
(135, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'INFORMAZIONI', 'Young01', ' Young01 55', '2024-07-08 22:25:11'),
(136, 2, 'STRUTTURE', 2, 'Modificare', NULL, NULL, 'STRUTTURA_NOME', 'Branch Office', 'Branch Office500', '2024-07-08 23:19:22'),
(137, 2, 'STRUTTURE', 2, 'Modificare', NULL, NULL, 'AZIENDA_ID', '1', '10', '2024-07-08 23:19:22'),
(138, 2, 'STRUTTURE', 2, 'Modificare', NULL, NULL, 'INDIRIZZO', '456 Branch Stgg', '456 Branch Stgg500', '2024-07-08 23:19:22'),
(139, 2, 'STRUTTURE', 2, 'Modificare', NULL, NULL, 'CITTA', 'vLos Angeles', 'vLos Angeles500', '2024-07-08 23:19:22'),
(140, 2, 'STRUTTURE', 2, 'Modificare', NULL, NULL, 'INFORMAZIONI', 'Some information about Branch Office', '500', '2024-07-08 23:19:22'),
(141, 2, 'STRUTTURE', 2, 'Modificare', NULL, NULL, 'DATA_INIZIO', NULL, '2024-08-01', '2024-07-08 23:19:22'),
(142, 2, 'STRUTTURE', 2, 'Modificare', NULL, NULL, 'DATA_FINITO', NULL, '2024-07-31', '2024-07-08 23:19:22'),
(143, 2, 'BANCA CONTI', 14, 'Modificare', NULL, NULL, 'AZIENDA_ID', '14', '5', '2024-07-09 20:49:10'),
(144, 2, 'BANCA CONTI', 14, 'Modificare', NULL, NULL, 'BANCA_NOME', 'otp', 'RZB', '2024-07-09 20:49:10'),
(145, 2, 'BANCA CONTI', 14, 'Modificare', NULL, NULL, 'IBAN', '890', '55555', '2024-07-09 20:49:10'),
(146, 2, 'BANCA CONTI', 14, 'Modificare', NULL, NULL, 'DATA_INIZIO', NULL, '2024-07-24', '2024-07-09 20:49:10'),
(147, 2, 'BANCA CONTI', 14, 'Modificare', NULL, NULL, 'DATA_FINITO', NULL, '2024-07-31', '2024-07-09 20:49:10'),
(148, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'AZIENDA_ID', '1', '6', '2024-07-09 20:53:52'),
(149, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'VALORE', '1000.00', '55554444', '2024-07-09 20:53:52'),
(150, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'DATA_FATTURAZIONE', '2023-01-15', '2023-01-27', '2024-07-09 20:53:52'),
(151, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'IVA', '100.00', '55', '2024-07-09 20:53:52'),
(152, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'MONETA', '0', 'ZAR', '2024-07-09 20:53:52'),
(153, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'DESCRIZIONE', 'Product A', '', '2024-07-09 20:53:52'),
(154, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'DATA_SCADENZA', NULL, '2024-07-24', '2024-07-09 20:53:52'),
(155, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'BANCA_CONTO_ID', NULL, '12', '2024-07-09 20:53:52'),
(156, 2, 'FATTURE', 2, 'Modificare', NULL, NULL, 'AZIENDA_ID', '2', '5', '2024-07-09 20:55:17'),
(157, 2, 'FATTURE', 2, 'Modificare', NULL, NULL, 'VALORE', '1500.00', '5455', '2024-07-09 20:55:17'),
(158, 2, 'FATTURE', 2, 'Modificare', NULL, NULL, 'IVA', '300.00', '50', '2024-07-09 20:55:17'),
(159, 2, 'FATTURE', 2, 'Modificare', NULL, NULL, 'MONETA', '1', 'INR', '2024-07-09 20:55:17'),
(160, 2, 'FATTURE', 2, 'Modificare', NULL, NULL, 'DESCRIZIONE', 'Product B', '', '2024-07-09 20:55:17'),
(161, 2, 'FATTURE', 2, 'Modificare', NULL, NULL, 'MONETA', 'INR', 'USD', '2024-07-09 21:20:36'),
(162, 2, 'FATTURE', 2, 'Modificare', NULL, NULL, 'DESCRIZIONE', '', 'nn', '2024-07-09 21:20:36'),
(163, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'MONETA', 'ZAR', 'USD', '2024-07-09 21:22:46'),
(164, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'DESCRIZIONE', '', 'nn', '2024-07-09 21:22:46'),
(165, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'BANCA_CONTO_ID', '12', '6', '2024-07-09 21:22:46'),
(166, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'VALORE', '55554444.00', '555544434', '2024-07-09 22:08:51'),
(167, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'VALORE_IVA_INCLUSA', '2000.00', '861110539.03', '2024-07-09 22:08:51'),
(168, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'MONETA', 'USD', 'MXN', '2024-07-09 22:09:55'),
(169, 2, 'UTENTI', 44, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-11 21:09:15'),
(170, 2, 'utenti', 39, 'Activate', NULL, NULL, NULL, NULL, NULL, '2024-07-11 21:50:39'),
(171, 2, 'UTENTI', 29, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-11 21:53:29'),
(172, 2, 'UTENTI', 39, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 12:56:03'),
(173, 2, 'UTENTI', 39, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 13:54:28'),
(174, 2, 'UTENTI', 39, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:05:43'),
(175, 2, 'UTENTI_AZIENDE', 39, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '2', '2024-07-13 15:06:40'),
(176, 2, 'UTENTI_AZIENDE', 39, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '3', '2024-07-13 15:06:40'),
(177, 2, 'UTENTI', 39, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:08:36'),
(178, 2, 'FATTURE', 3, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:21:56'),
(179, 2, 'FATTURE', 4, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:28:04'),
(180, 2, 'BANCA_CONTI', 2, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:29:16'),
(181, 2, 'UTENTI', 39, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:34:41'),
(182, 2, 'UTENTI', 6, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:36:40'),
(183, 2, 'UTENTI_AZIENDE', 7, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '1', '2024-07-13 15:39:50'),
(184, 2, 'UTENTI_AZIENDE', 7, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '2', '2024-07-13 15:39:50'),
(185, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', NULL, 7, NULL, NULL, NULL, '2024-07-13 15:39:59'),
(186, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', NULL, 7, NULL, NULL, NULL, '2024-07-13 15:39:59'),
(187, 2, 'UTENTI', 7, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:39:59'),
(188, 2, 'UTENTI_AZIENDE', 23, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '3', '2024-07-13 15:46:24'),
(189, 2, 'UTENTI_AZIENDE', 23, 'Creare', NULL, NULL, 'AZIENDA_ID', NULL, '4', '2024-07-13 15:46:24'),
(190, 2, 'UTENTI', 23, 'Modificare', NULL, NULL, 'DATA_INIZIO', NULL, '2024-07-04', '2024-07-13 15:46:24'),
(191, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', 3, 23, NULL, NULL, NULL, '2024-07-13 15:46:47'),
(192, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', 4, 23, NULL, NULL, NULL, '2024-07-13 15:46:47'),
(193, 2, 'UTENTI', 23, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:46:47'),
(194, 2, 'REPARTI', 11, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:51:09'),
(195, 2, 'REPARTI', NULL, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:52:51'),
(196, 2, 'UTENTI', 2, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:52:51'),
(197, 2, 'REPARTI', 9, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:55:11'),
(198, 2, 'UTENTI', 9, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:55:11'),
(199, 2, 'STRUTTURE', 17, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 15:57:10'),
(200, 2, 'STRUTTURE', 17, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:03:54'),
(201, 2, 'STRUTTURE', 17, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:05:14'),
(202, 2, 'REPARTI', 2, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:05:38'),
(203, 2, 'STRUTTURE', 11, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:05:38'),
(204, 2, 'STRUTTURE', 22, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:05:38'),
(205, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', 2, 3, NULL, NULL, NULL, '2024-07-13 16:05:38'),
(206, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', 2, 18, NULL, NULL, NULL, '2024-07-13 16:05:38'),
(207, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', 2, 21, NULL, NULL, NULL, '2024-07-13 16:05:38'),
(208, 2, 'BANCA_CONTI', 2, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:05:38'),
(209, 2, 'BANCA_CONTI', 7, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:05:38'),
(210, 2, 'STRUTTURE', 17, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:12:14'),
(211, 2, 'STRUTTURE', 17, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:16:26'),
(212, 2, 'STRUTTURE', 17, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:16:29'),
(213, 2, 'STRUTTURE', 17, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:18:29'),
(214, 2, 'STRUTTURE', 17, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:20:23'),
(215, 2, 'AZIENDE', 14, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:20:23'),
(216, 2, 'STRUTTURE', 15, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:28:12'),
(217, 2, 'STRUTTURE', 18, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:28:12'),
(218, 2, 'AZIENDE', 15, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:30:46'),
(219, 2, 'STRUTTURE', 24, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:30:55'),
(220, 2, 'AZIENDE', 12, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 16:30:55'),
(221, 2, 'STRUTTURE', 1, 'Modificare', NULL, NULL, 'INFORMAZIONI', 'Some information about Headquarters', ' Some information about Headquarters', '2024-07-13 21:24:33'),
(222, 2, 'STRUTTURE', 1, 'Modificare', NULL, NULL, 'DATA_INIZIO', NULL, '2024-08-04', '2024-07-13 21:24:33'),
(223, 2, 'STRUTTURE', 1, 'Modificare', NULL, NULL, 'DATA_FINITO', NULL, '2024-09-07', '2024-07-13 21:24:33'),
(224, 2, 'FATTURE', 1, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 21:25:43'),
(225, 2, 'FATTURE', 3, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 21:25:52'),
(226, 2, 'UTENTI', 6, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 21:26:12'),
(227, 2, 'REPARTI', 11, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 21:27:11'),
(228, 2, 'STRUTTURE', 1, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:14:26'),
(229, 2, 'STRUTTURE', 14, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:14:26'),
(230, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', 1, 13, NULL, NULL, NULL, '2024-07-13 22:14:26'),
(231, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', 1, 18, NULL, NULL, NULL, '2024-07-13 22:14:26'),
(232, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', 1, 26, NULL, NULL, NULL, '2024-07-13 22:14:26'),
(233, 2, 'IMPIANTI', 1, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:14:26'),
(234, 2, 'AZIENDE', 1, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:14:26'),
(235, 2, 'REPARTI', 6, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:16:41'),
(236, 2, 'STRUTTURE', 6, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:16:41'),
(237, 2, 'REPARTI', 11, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:19:47'),
(238, 2, 'UTENTI', 6, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:20:41'),
(239, 2, 'BANCA_CONTI', 3, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:21:48'),
(240, 2, 'FATTURE', 1, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:21:58'),
(241, 2, 'UTENTI', 39, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:22:15'),
(242, 2, 'UTENTI_AZIENDE', NULL, 'Creare', 8, 39, NULL, NULL, NULL, '2024-07-13 22:22:29'),
(243, 2, 'UTENTI_AZIENDE', NULL, 'Creare', 9, 39, NULL, NULL, NULL, '2024-07-13 22:22:29'),
(244, 2, 'UTENTI_AZIENDE', NULL, 'Creare', 10, 39, NULL, NULL, NULL, '2024-07-13 22:22:29'),
(245, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_INIZIO', '2024-07-31', NULL, '2024-07-13 22:22:29'),
(246, 2, 'REPARTI', 11, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:24:10'),
(247, 2, 'FATTURE', 1, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:24:29'),
(248, 2, 'AZIENDE', 2, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:28:42'),
(249, 2, 'IMPIANTI', 1, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:28:52'),
(250, 2, 'STRUTTURE', 1, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:28:52'),
(251, 2, 'BANCA_CONTI', 4, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:29:02'),
(252, 2, 'FATTURE', 2, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-13 22:46:01'),
(253, 2, 'UTENTI', 46, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-17 21:34:41'),
(254, 2, 'DOCUMENTI', 3, 'Eliminare', NULL, NULL, NULL, NULL, NULL, NULL),
(255, 2, 'DOCUMENTI', NULL, 'Eliminare', NULL, NULL, NULL, NULL, NULL, NULL),
(256, 2, 'DOCUMENTI', NULL, 'Eliminare', NULL, NULL, NULL, NULL, NULL, NULL),
(257, 2, 'DOCUMENTI', 3, 'Eliminare', NULL, NULL, NULL, NULL, NULL, NULL),
(258, 2, 'DOCUMENTI', NULL, 'Inserimento', NULL, NULL, NULL, NULL, NULL, '2024-07-28 11:52:19'),
(259, 2, 'DOCUMENTI', 4, 'Inserimento', NULL, NULL, NULL, NULL, NULL, '2024-07-28 12:07:26'),
(260, 2, 'DOCUMENTI', 5, 'Inserimento', NULL, NULL, NULL, NULL, NULL, '2024-07-28 12:13:18'),
(261, 2, 'DOCUMENTI', 6, 'Inserimento', NULL, NULL, NULL, NULL, NULL, '2024-07-28 13:31:54'),
(262, 2, 'DOCUMENTI', 6, 'Modificare', NULL, NULL, 'Percorso', 'files/breshka', 'files/CompanyEEE', '2024-07-28 15:43:45'),
(263, 2, 'CARTELLE', NULL, 'Modificare', NULL, NULL, 'NOME', '0', 'files/CompanyEEE', '2024-07-28 15:43:45'),
(264, 2, 'DOCUMENTI', 6, 'Modificare', NULL, NULL, 'PERCORSO', 'files/CompanyEEE', 'files/shqip', '2024-07-28 15:53:27'),
(265, 2, 'CARTELLE', NULL, 'Modificare', NULL, NULL, 'NOME', 'files/CompanyEEE', 'files/shqip', '2024-07-28 15:53:27'),
(266, 2, 'CARTELLE', NULL, 'Inserimento', NULL, NULL, 'NOME', NULL, NULL, '2024-07-28 15:58:01'),
(267, 2, 'CARTELLE', NULL, 'Inserimento', NULL, NULL, 'NOME', NULL, NULL, '2024-07-28 15:58:16'),
(268, 2, 'CARTELLE', NULL, 'Inserimento', NULL, NULL, 'NOME', NULL, NULL, '2024-07-28 16:09:16'),
(269, 2, 'CARTELLE', NULL, 'Inserimento', NULL, NULL, 'NOME', NULL, 'files/Panel/Zin', '2024-07-28 16:10:15'),
(270, 2, 'CARTELLE', NULL, 'Eliminare', NULL, NULL, NULL, 'files/Panel/Zin/', NULL, '2024-07-28 16:10:37'),
(271, 2, 'CARTELLE', NULL, 'Eliminare', NULL, NULL, NULL, 'files/Panel/', NULL, '2024-07-28 16:10:37'),
(272, 2, 'DOCUMENTI', NULL, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-28 17:41:00'),
(273, 2, 'DOCUMENTI', 7, 'Inserimento', NULL, NULL, NULL, NULL, NULL, '2024-07-28 17:43:48'),
(274, 2, 'DOCUMENTI', 7, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-28 17:44:08'),
(275, 2, 'DOCUMENTI', 8, 'Inserimento', NULL, NULL, NULL, NULL, NULL, '2024-07-28 17:48:43'),
(276, 2, 'DOCUMENTI', 8, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-28 17:48:54'),
(277, 2, 'DOCUMENTI', 6, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-28 18:19:10'),
(278, 2, 'DOCUMENTI', 9, 'Inserimento', NULL, NULL, NULL, NULL, NULL, '2024-07-28 18:20:10'),
(279, 2, 'DOCUMENTI', 9, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-28 18:20:59'),
(280, 2, 'DOCUMENTI', 10, 'Inserimento', NULL, NULL, NULL, NULL, NULL, '2024-07-28 18:26:18'),
(281, 2, 'DOCUMENTI', NULL, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-28 19:43:10'),
(282, 2, 'CARTELLE', NULL, 'Inserimento', NULL, NULL, 'NOME', NULL, 'files/shqip/Paguaj/Zinxhir', '2024-07-28 19:43:30'),
(283, 2, 'CARTELLE', NULL, 'Modificare', NULL, NULL, 'NOME', 'files/shqip/Paguaj', 'files/shqip/Pagato', '2024-07-28 19:43:51'),
(284, 2, 'CARTELLE', NULL, 'Eliminare', NULL, NULL, NULL, 'files/shqip/Pagato/Zinxhir/', NULL, '2024-07-28 19:44:15'),
(285, 2, 'CARTELLE', NULL, 'Eliminare', NULL, NULL, NULL, 'files/shqip/Pagato/', NULL, '2024-07-28 19:44:15'),
(286, 2, 'Strutture', 26, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-28 21:06:33'),
(287, 2, 'Strutture', 27, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-28 21:08:47'),
(288, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'AZIENDA_ID', '1', '4', '2024-07-28 22:17:47'),
(289, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'STRUTTURA_ID', '1', '4', '2024-07-28 22:17:47'),
(290, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'REPARTO_ID', '1', '4', '2024-07-28 22:17:47'),
(291, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'ULTIMA_ATTIVITA', 'plkm', '2024-03-31', '2024-07-28 22:17:47'),
(292, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_FINITO', '2024-07-13 00:00:00', '2024-07-13', '2024-07-28 22:17:47'),
(293, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_ULTIMA_ATT', '2024-03-31', 'plkm', '2024-07-28 22:17:47'),
(294, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_INIZIO', '0000-00-00 00:00:00', '2024-11-14', '2024-07-28 22:27:04'),
(295, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'ULTIMA_ATTIVITA', 'plkm', '2024-03-31', '2024-07-28 22:27:04'),
(296, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_FINITO', '2024-07-13 00:00:00', '2024-07-10', '2024-07-28 22:27:04'),
(297, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_ULTIMA_ATT', '2024-03-31', 'plkm', '2024-07-28 22:27:04'),
(298, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_INIZIO', '2024-11-14 00:00:00', '2024-11-14', '2024-07-28 22:28:10'),
(299, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_FINITO', '2024-07-10 00:00:00', '2024-07-10', '2024-07-28 22:28:10'),
(300, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_INIZIO', '2024-11-14 00:00:00', '2024-11-14', '2024-07-28 22:30:22'),
(301, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'ULTIMA_ATTIVITA', 'plkm', 'NOJ', '2024-07-28 22:30:22'),
(302, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_FINITO', '2024-07-10 00:00:00', '', '2024-07-28 22:30:22'),
(303, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_INIZIO', '2024-11-14 00:00:00', '2024-11-14', '2024-07-28 22:32:27'),
(304, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_FINITO', '0000-00-00 00:00:00', '', '2024-07-28 22:32:27'),
(305, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_ULTIMA_ATT', '2024-03-31 00:00:00', '2024-03-31', '2024-07-28 22:32:27'),
(306, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'IMPIANTO_NOME', 'n', 'IMPIANTO01', '2024-07-28 22:32:57'),
(307, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_INIZIO', '2024-11-14 00:00:00', '2024-11-14', '2024-07-28 22:32:57'),
(308, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_FINITO', '0000-00-00 00:00:00', '00-1-11-30', '2024-07-28 22:32:57'),
(309, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_FINITO', '0000-00-00', '2024-11-30', '2024-07-28 22:38:52'),
(310, 2, 'Impianto', 2, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-28 23:12:13'),
(311, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'MONETA', 'MXN', 'USD', '2024-07-28 23:41:20'),
(312, 2, 'BANCA CONTI', 1, 'Modificare', NULL, NULL, 'AZIENDA_ID', '12', '1', '2024-07-28 23:41:33'),
(313, 2, 'AZIENDE', 14, 'Modificare', NULL, NULL, 'INFORMAZIONI', ' Young01 55', '  Young01 55 ', '2024-07-28 23:43:48'),
(314, 2, 'STRUTTURE', 2, 'Modificare', NULL, NULL, 'AZIENDA_ID', '10', '1', '2024-07-28 23:43:57'),
(315, 2, 'STRUTTURE', 9, 'Modificare', NULL, NULL, 'INFORMAZIONI', 'Some information about Data Center', ' Some information about Data Center', '2024-07-28 23:46:55'),
(316, 2, 'REPARTI', 11, 'Modificare', NULL, NULL, 'INFORMAZIONI', 'ddd\\\\\\\"\\\"j', 'ddd\\\\\\\\\\\\\\\"\\\\\\\"j ', '2024-07-28 23:47:55'),
(317, 2, 'REPARTI', 9, 'Modificare', NULL, NULL, 'DATA_FINITO', '2024-07-13', NULL, '2024-07-28 23:49:27'),
(318, 2, 'REPARTI', 1, 'Modificare', NULL, NULL, 'DATA_FINITO', '2024-07-13', NULL, '2024-07-28 23:51:06'),
(319, 2, 'STRUTTURE', 9, 'Modificare', NULL, NULL, 'DATA_INIZIO', NULL, '2024-07-01', '2024-07-28 23:52:38'),
(320, 2, 'REPARTI', 7, 'Modificare', NULL, NULL, 'DATA_INIZIO', NULL, '2024-07-30', '2024-07-28 23:53:21'),
(321, 2, 'REPARTI', 7, 'Modificare', NULL, NULL, 'DATA_FINITO', NULL, '2024-08-02', '2024-07-28 23:53:21'),
(322, 2, 'BANCA CONTI', 1, 'Modificare', NULL, NULL, 'DATA_INIZIO', NULL, '2024-07-03', '2024-07-28 23:53:44'),
(323, 2, 'FATTURE', 1, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-28 23:56:16'),
(324, 2, 'IMPIANTI', 1, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-07-28 23:59:07'),
(325, 2, 'IMPIANTI', 1, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-07-28 23:59:11'),
(326, 2, 'UTENTI', 47, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-07-30 20:46:07'),
(327, 2, 'CARTELLE', NULL, 'Inserimento', NULL, NULL, 'NOME', NULL, 'files/Company A', '2024-07-30 20:46:25'),
(328, 2, 'CARTELLE', NULL, 'Inserimento', NULL, NULL, 'NOME', NULL, 'files/Company C', '2024-07-30 20:46:33'),
(329, 2, 'UTENTI', 47, 'Modificare', NULL, NULL, 'PASSWORD', NULL, '$2y$10$A2hv74ryFf.Q4oDMx7o4nOVCMAuUHZz3wJpzBj2zuyNwAeA5qxT6u', '2024-07-30 20:46:54'),
(330, 2, 'UTENTI', 47, 'Modificare', NULL, NULL, 'DATA_INIZIO', '2024-07-10', NULL, '2024-07-30 20:46:54'),
(331, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'PASSWORD', NULL, '$2y$10$NQbiVUcdKLvSrteNhFFHJO/areOp6HIF0tl4Tf6mmYV90x0gYOwGe', '2024-08-01 19:40:49'),
(332, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'PASSWORD', NULL, '$2y$10$mHkBvZ.ik25znyQO.7Ato.wyl6GaYqEL6Za.ZseubvMqP0/4m1TZi', '2024-08-01 19:41:29'),
(333, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_FINITO', NULL, '2024-08-27', '2024-08-01 19:42:06'),
(334, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_INIZIO', '0000-00-00', '00-1-11-30', '2024-08-01 19:42:15'),
(335, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_FINITO', '2024-08-27', '2024-08-15', '2024-08-01 19:42:15'),
(336, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'DATA_INIZIO', '0000-00-00', '2001-11-11', '2024-08-01 20:21:49'),
(337, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'PASSWORD', '$2y$10$zItEC8ThpxNiPrzpddeoYuhbzCoKl/kP6vqwIJcTPFotbdfiodhXK', 'llllllll', '2024-08-01 20:24:33'),
(338, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'PASSWORD', '$2y$10$amH9AahF5yNm/Hz04HMVaO8VPJkRFYGaFK0FoJZ9YbZmUyDisvj/6', '$2y$10$fq5glqrPTO3LgCCkQkmG0uXJbEF4nWh7MCJnINNFIQOuMWBqd5d4i', '2024-08-01 20:27:54'),
(339, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'PASSWORD', '$2y$10$fq5glqrPTO3LgCCkQkmG0uXJbEF4nWh7MCJnINNFIQOuMWBqd5d4i', '$2y$10$8imAFDmpp/GhoWMK/sZuIedFpN/FhLNuH7HdGpl1sksIiDCx5r98W', '2024-08-01 20:28:02'),
(340, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'PASSWORD', '$2y$10$8imAFDmpp/GhoWMK/sZuIedFpN/FhLNuH7HdGpl1sksIiDCx5r98W', '$2y$10$fwHw4prfIUtvhf0.XJ6WLuHJ.qVogoh7Ao58VTNHQNTN3Ur7D5Fr2', '2024-08-01 20:33:13'),
(341, 2, '', 2, 'Modificare', NULL, NULL, 'NOME', 'Endi1', 'Endi2', '2024-08-01 20:39:05'),
(342, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'PASSWORD', '$2y$10$/08q1xp5MUerhmEo1Jyc.OehByPx1fw1ktliz/zKnQWUjnncuneEi', '$2y$10$0Qy6p302BzQyZbI6zirs8OOR0iBgFODlWaTqyF9jaSPInodWPYYMC', '2024-08-01 20:40:46'),
(343, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'PASSWORD', '$2y$10$0Qy6p302BzQyZbI6zirs8OOR0iBgFODlWaTqyF9jaSPInodWPYYMC', '$2y$10$JpGpHr5eG.c6c98K2MYuBu.pGwkjA8ujWip1kK/NXQVQTq9qHHQc.', '2024-08-01 20:40:52'),
(344, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'PASSWORD', '$2y$10$JpGpHr5eG.c6c98K2MYuBu.pGwkjA8ujWip1kK/NXQVQTq9qHHQc.', '$2y$10$Ri/h06d01Q715I/X0Rmq/.H3oro7b0fEW8oEaHFfOn3nfOFdY98ke', '2024-08-01 20:41:50'),
(345, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'PASSWORD', '$2y$10$Ri/h06d01Q715I/X0Rmq/.H3oro7b0fEW8oEaHFfOn3nfOFdY98ke', '$2y$10$eXkYA7T6M4e6dUy3yncFkuKIUHwvq5dnWGqatTEUe1A7GJCcvTM2y', '2024-08-01 20:42:08'),
(346, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'PASSWORD', '$2y$10$eXkYA7T6M4e6dUy3yncFkuKIUHwvq5dnWGqatTEUe1A7GJCcvTM2y', '$2y$10$shc4X2fj9HQKJLEOqG9T8uJpHKBCqPNZpP44xHMl74boMsVFYTIOO', '2024-08-01 20:42:12'),
(347, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'NOME', 'Endi2', 'Endi2', '2024-08-01 20:46:28'),
(348, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'COGNOME', 'Trico', 'Trico', '2024-08-01 20:46:28'),
(349, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'EMAIL', 'enditrico@gmail.com', 'enditrico@gmail.com', '2024-08-01 20:46:28'),
(350, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'NUMERO', '695725489', '695725489', '2024-08-01 20:46:28'),
(351, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'NOME', 'Endi2', 'Endi11', '2024-08-01 20:46:34'),
(352, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'COGNOME', 'Trico', 'Trico', '2024-08-01 20:46:34'),
(353, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'EMAIL', 'enditrico@gmail.com', 'enditrico@gmail.com', '2024-08-01 20:46:34'),
(354, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'NUMERO', '695725489', '695725489', '2024-08-01 20:46:34'),
(355, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'NOME', 'Endi11', 'Endi123', '2024-08-01 20:48:33'),
(356, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'PASSWORD', '$2y$10$N06msp5b4SNc.JCngoB1huMjSMDpYu5zkN9R9v1t/GRQcCHvElLKu', '$2y$10$TORS.qOhIIDXL1FlPrPTHeSiZMZYrAry/aA4B21ZU/Mge.0RBqeLy', '2024-08-01 20:48:33'),
(357, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'NOME', 'Endi123', 'Endi123juuu', '2024-08-01 20:53:01'),
(358, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-08-01 20:56:07'),
(359, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-08-01 20:56:16'),
(360, 2, 'UTENTI', 2, 'Modificare', NULL, NULL, 'NOME', 'Endi123juuu', 'Endi', '2024-08-01 20:56:46'),
(361, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'PASSWORD', '$2y$10$fwHw4prfIUtvhf0.XJ6WLuHJ.qVogoh7Ao58VTNHQNTN3Ur7D5Fr2', 'eee', '2024-08-01 21:19:43'),
(362, 2, 'UTENTI', 39, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-08-01 21:24:58'),
(363, 47, 'UTENTI', 47, 'Modificare', NULL, NULL, 'PASSWORD', NULL, NULL, '2024-08-01 21:29:06'),
(364, 2, 'DOCUMENTI', NULL, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-03 13:07:32'),
(365, 2, 'AZIENDE', 2, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-08-03 13:21:56'),
(366, 2, 'CARTELLE', NULL, 'Inserimento', NULL, NULL, 'NOME', NULL, 'files/Company C/Zin', '2024-08-03 13:23:32'),
(367, 2, 'CARTELLE', NULL, 'Modificare', NULL, NULL, 'NOME', 'files/Company C', 'files/CompanyCCC', '2024-08-03 13:23:45'),
(368, 2, 'DOCUMENTI', 11, 'Inserimento', NULL, NULL, NULL, NULL, NULL, '2024-08-03 13:52:48'),
(369, 2, 'CARTELLE', NULL, 'Eliminare', NULL, NULL, NULL, 'files/CompanyCCC/Zin/', NULL, '2024-08-03 14:00:11'),
(370, 2, 'DOCUMENTI', 7, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-03 14:00:55'),
(371, 2, 'IMPIANTI', 1, 'Modificare', NULL, NULL, 'DATA_FINITO', NULL, '2024-08-31', '2024-08-03 14:02:22'),
(372, 2, 'DOCUMENTI', NULL, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-03 17:49:29'),
(373, 2, 'DOCUMENTI', NULL, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-03 18:02:27'),
(374, 2, 'CARTELLE', NULL, 'Inserimento', NULL, NULL, 'NOME', NULL, 'files/Zinb', '2024-08-03 18:04:09'),
(375, 2, 'DOCUMENTI', 12, 'Inserimento', NULL, NULL, NULL, NULL, NULL, '2024-08-03 18:06:50'),
(376, 2, 'UTENTI', 48, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-08-03 20:10:15'),
(377, 2, 'UTENTI', 6, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-08-03 20:19:30'),
(378, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', NULL, 39, NULL, NULL, NULL, '2024-08-03 20:19:50'),
(379, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', NULL, 39, NULL, NULL, NULL, '2024-08-03 20:19:50'),
(380, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', NULL, 39, NULL, NULL, NULL, '2024-08-03 20:19:50'),
(381, 2, 'DOCUMENTI', 12, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-03 20:28:53'),
(382, 2, 'DOCUMENTI', 13, 'Inserimento', NULL, NULL, NULL, NULL, NULL, '2024-08-03 20:33:21'),
(383, 2, 'CARTELLE', NULL, 'Eliminare', NULL, NULL, NULL, 'files/Company A/', NULL, '2024-08-03 20:54:02'),
(384, 2, 'DOCUMENTI', 11, 'Modificare', NULL, NULL, 'PERCORSO', 'files/CompanyCCC', 'files/breshka', '2024-08-03 20:57:45'),
(385, 2, 'CARTELLE', NULL, 'Modificare', NULL, NULL, 'NOME', 'files/CompanyCCC', 'files/breshka', '2024-08-03 20:57:45'),
(386, 2, 'CARTELLE', NULL, 'Inserimento', NULL, NULL, 'NOME', NULL, 'files/Company B', '2024-08-03 21:00:47'),
(387, 2, 'CARTELLE', NULL, 'Inserimento', NULL, NULL, 'NOME', NULL, 'files/Company D', '2024-08-03 21:01:18'),
(388, 2, 'UTENTI', 49, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-08-03 21:03:20'),
(389, 2, 'FATTURE', 1, 'Modificare', NULL, NULL, 'DATA_SCADENZA', '2024-07-24', '2024-09-06', '2024-08-10 15:29:47'),
(390, 2, 'CARTELLE', NULL, 'Modificare', NULL, NULL, 'NOME', 'files/Company B', 'files/Company B - 23456789012', '2024-08-10 16:13:33'),
(391, 2, 'UTENTI', 7, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:14:09'),
(392, 2, 'AZIENDE', 12, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:18:08'),
(393, 2, 'AZIENDE', 12, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:18:20'),
(394, 2, 'IMPIANTI', 1, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:18:38'),
(395, 2, 'REPARTI', 4, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:18:38'),
(396, 2, 'STRUTTURE', 4, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:18:38'),
(397, 2, 'BANCA_CONTI', 5, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:18:57'),
(398, 2, 'FATTURE', 2, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:19:11'),
(399, 2, 'IMPIANTI', 2, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:19:20'),
(400, 2, 'UTENTI', 6, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:34:36'),
(401, 2, 'UTENTI', 6, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:38:44'),
(402, 2, 'UTENTI', 6, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:45:03'),
(403, 2, 'UTENTI', 6, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:45:12'),
(404, 2, 'UTENTI', 6, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:47:33'),
(405, 2, 'UTENTI', 6, 'Eliminare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:52:04'),
(406, 2, 'UTENTI', 6, 'Attivare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 16:52:11'),
(407, 2, 'UTENTI_AZIENDE', NULL, 'Creare', 1, 6, NULL, NULL, NULL, '2024-08-10 16:52:29'),
(408, 2, 'UTENTI_AZIENDE', NULL, 'Creare', 2, 6, NULL, NULL, NULL, '2024-08-10 16:52:29'),
(409, 2, 'UTENTI_AZIENDE', NULL, 'Creare', 3, 6, NULL, NULL, NULL, '2024-08-10 16:52:29'),
(410, 2, 'UTENTI_AZIENDE', NULL, 'Creare', 4, 51, NULL, NULL, NULL, '2024-08-10 17:18:06'),
(411, 2, 'UTENTI_AZIENDE', NULL, 'Creare', 5, 51, NULL, NULL, NULL, '2024-08-10 17:18:06'),
(412, 2, 'UTENTI_AZIENDE', NULL, 'Creare', 6, 51, NULL, NULL, NULL, '2024-08-10 17:18:06'),
(413, 2, 'UTENTI', 51, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 17:18:06'),
(414, 2, 'UTENTI_AZIENDE', NULL, 'Creare', 1, 52, NULL, NULL, NULL, '2024-08-10 17:25:29'),
(415, 2, 'UTENTI', 52, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-08-10 17:25:29'),
(416, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', 1, 6, NULL, NULL, NULL, '2024-08-10 17:50:53'),
(417, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', 2, 6, NULL, NULL, NULL, '2024-08-10 17:50:53'),
(418, 2, 'UTENTI_AZIENDE', NULL, 'Eliminare', 3, 6, NULL, NULL, NULL, '2024-08-10 17:50:53'),
(419, 2, 'UTENTI_AZIENDE', NULL, 'Creare', 8, 6, NULL, NULL, NULL, '2024-08-10 17:50:53'),
(420, 2, 'UTENTI_AZIENDE', NULL, 'Creare', 2, 47, NULL, NULL, NULL, '2024-08-10 18:00:20'),
(421, 2, 'FATTURE', 13, 'Modificare', NULL, NULL, 'MONETA', '0', 'USD', '2024-08-17 22:11:52'),
(422, 2, 'FATTURE', 13, 'Modificare', NULL, NULL, 'DATA_SCADENZA', NULL, '2024-08-01', '2024-08-17 22:11:52'),
(423, 2, 'FATTURE', 4, 'Modificare', NULL, NULL, 'IVA', '500.00', '20', '2024-08-18 18:34:45'),
(424, 2, 'FATTURE', 4, 'Modificare', NULL, NULL, 'MONETA', '1', 'INR', '2024-08-18 18:34:45'),
(425, 2, 'Fattura', 18, 'Creare', NULL, NULL, NULL, NULL, NULL, '2024-08-18 18:37:54'),
(426, 2, 'FATTURE', 17, 'Modificare', NULL, NULL, 'MONETA', 'KRW', 'TRY', '2024-08-18 18:51:26'),
(427, 2, 'FATTURE', 17, 'Modificare', NULL, NULL, 'DATA_SCADENZA', NULL, '2024-08-28', '2024-08-18 18:51:26');

-- --------------------------------------------------------

--
-- Table structure for table `reparti`
--

CREATE TABLE `reparti` (
  `REPARTO_ID` bigint(20) NOT NULL,
  `AZIENDA_ID` bigint(20) NOT NULL,
  `STRUTTURA_ID` bigint(20) NOT NULL,
  `REPARTO_NOME` varchar(255) DEFAULT NULL,
  `INDIRIZZO` varchar(255) DEFAULT NULL,
  `CITTA` varchar(255) DEFAULT NULL,
  `DATA_INIZIO` date DEFAULT NULL,
  `DATA_FINE` date DEFAULT NULL,
  `INFORMAZIONI` varchar(255) DEFAULT NULL,
  `E_ATTIVO` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reparti`
--

INSERT INTO `reparti` (`REPARTO_ID`, `AZIENDA_ID`, `STRUTTURA_ID`, `REPARTO_NOME`, `INDIRIZZO`, `CITTA`, `DATA_INIZIO`, `DATA_FINE`, `INFORMAZIONI`, `E_ATTIVO`) VALUES
(1, 1, 1, 'Production', '123 Factory St', 'New York', NULL, NULL, 'Some information about Production department', b'0'),
(2, 2, 2, 'Assembly', '456 Assembly St', 'Los Angeles', NULL, '2024-07-13', 'Some information about Assembly department', b'0'),
(3, 3, 3, 'Quality Control', '789 QC St', 'Chicago', NULL, NULL, 'Some information about Quality Control department', b'1'),
(4, 4, 4, 'Research & Development', '101 R&D St', 'Houston', NULL, '2024-08-10', 'Some information about Research & Development department', b'0'),
(5, 5, 5, 'Maintenance', '202 Maintenance St', 'Phoenix', NULL, NULL, 'Some information about Maintenance department', b'1'),
(6, 6, 6, 'Logistics', '303 Logistics St', 'Philadelphia', NULL, '2024-07-13', 'Some information about Logistics department', b'0'),
(7, 7, 7, 'Marketing', '404 Marketing St', 'San Antonio', '2024-07-30', '2024-08-02', 'Some information about Marketing department', b'1'),
(8, 8, 8, 'Human Resources', '505 HR St', 'San Diego', NULL, NULL, 'Some information about Human Resources department', b'1'),
(9, 9, 9, 'Finance', '606 Finance St', 'Dallas', NULL, NULL, 'Some information about Finance department', b'0'),
(10, 10, 10, 'Information Technology', '707 IT St', 'Austin', NULL, NULL, 'Some information about IT department', b'1'),
(11, 5, 5, 'AS', 'Vendorss  ', 'dddddn', NULL, NULL, 'ddd\\\\\\\\\\\\\\\"\\\\\\\"j ', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `strutture`
--

CREATE TABLE `strutture` (
  `STRUTTURA_ID` bigint(20) NOT NULL,
  `AZIENDA_ID` bigint(20) NOT NULL,
  `STRUTTURA_NOME` varchar(255) DEFAULT NULL,
  `INDIRIZZO` varchar(255) DEFAULT NULL,
  `CITTA` varchar(255) DEFAULT NULL,
  `DATA_INIZIO` date DEFAULT NULL,
  `DATA_FINE` date DEFAULT NULL,
  `INFORMAZIONI` varchar(255) DEFAULT NULL,
  `E_ATTIVO` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `strutture`
--

INSERT INTO `strutture` (`STRUTTURA_ID`, `AZIENDA_ID`, `STRUTTURA_NOME`, `INDIRIZZO`, `CITTA`, `DATA_INIZIO`, `DATA_FINE`, `INFORMAZIONI`, `E_ATTIVO`) VALUES
(1, 1, 'Headquarters', '123 HQ St', 'New York', '2024-08-04', '2024-07-13', ' Some information about Headquarters', b'0'),
(2, 1, 'Branch Office500', '456 Branch Stgg500', 'vLos Angeles500', '2024-08-01', '2024-07-13', ' 500', b'0'),
(3, 3, 'Warehouse', '789 Warehouse St', 'Chicago', NULL, NULL, 'Some information about Warehouse', b'1'),
(4, 4, 'Lab', '101 Lab St', 'Houston', NULL, '2024-08-10', 'Some information about Lab', b'0'),
(5, 5, 'Plant', '202 Plant St', 'Phoenix', NULL, NULL, 'Some information about Plant', b'1'),
(6, 6, 'Distribution Center', '303 DC St', 'Philadelphia', NULL, '2024-07-13', 'Some information about Distribution Center', b'0'),
(7, 7, 'Store', '404 Store St', 'San Antonio', NULL, NULL, 'Some information about Store', b'1'),
(8, 8, 'Office Building', '505 Office St', 'San Diego', NULL, NULL, 'Some information about Office Building', b'1'),
(9, 9, 'Data Center', '606 Data St', 'Dallas', '2024-07-01', '2024-07-13', ' Some information about Data Center', b'0'),
(10, 10, 'Tech Hub', '707 Tech St', 'Austin', NULL, NULL, 'Some information about Tech Hub', b'1'),
(11, 2, 'Headquarters', '123 HQ St', 'New York', NULL, '2024-07-13', 'Some information about Headquarters', b'0'),
(12, 3, 'Struttura A', 'wr', 'ds', NULL, NULL, 'HELLO', b'1'),
(13, 7, 'Struttura AP', '456 Branch Stgg', 'vLos Angeles', NULL, NULL, '', b'0'),
(14, 1, 'Struttura AP', '456 Branch Stgg', 'ds', NULL, NULL, '', b'1'),
(15, 15, 'Struttura AP', '456 Branch Stgg', 'vLos Angeles', NULL, '2024-07-13', '', b'0'),
(16, 11, 'Struttura A', '456 Branch Stgg', 'vLos Angeles', '2024-08-02', '2024-07-21', '', b'0'),
(17, 14, 'Struttura WW', 'Mongo', 'Li', '2024-07-03', '2024-07-13', '', b'0'),
(18, 15, 'Struttura CCC', '', '', '2024-07-04', '2024-07-13', '', b'0'),
(19, 11, 'Struttura AP', '456 Branch Stgg', 'vLos Angeles', '2024-07-02', NULL, '', b'1'),
(20, 5, 'Struttura WWp', '456 Branch Stgg', 'vLos Angeles', '2024-07-12', '2024-07-27', 'bb', b'0'),
(21, 4, 'Struttura CCC', 'Mongo', '', '2024-07-01', NULL, '', b'1'),
(22, 2, 'Struttura A', '', '', '2024-07-18', '2024-07-13', '', b'0'),
(23, 3, 'Movie', '', '', '2024-07-23', NULL, '', b'1'),
(24, 12, 'lrel', '', '', '2024-07-11', '2024-07-13', '', b'0'),
(25, 9, 'Struttura Al', '456 Branch Stgg', '', '2024-07-23', NULL, '', b'1'),
(26, 1, 'Struttura ABC', 'Mongo01', 'Los Angeles500', '2024-07-17', NULL, '', b'1'),
(27, 4, 'Struttura AN', 'Mongo', 'Li', NULL, NULL, '', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `UTENTE_ID` bigint(20) NOT NULL,
  `NOME` varchar(255) DEFAULT NULL,
  `COGNOME` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  `NUMERO` bigint(20) DEFAULT NULL,
  `AZIENDA_POSIZIONE` varchar(255) DEFAULT NULL,
  `RUOLO` varchar(255) DEFAULT NULL,
  `DATA_INIZIO` date DEFAULT curdate(),
  `DATA_FINE` date DEFAULT NULL,
  `E_ATTIVO` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`UTENTE_ID`, `NOME`, `COGNOME`, `EMAIL`, `PASSWORD`, `NUMERO`, `AZIENDA_POSIZIONE`, `RUOLO`, `DATA_INIZIO`, `DATA_FINE`, `E_ATTIVO`) VALUES
(1, 'Krenar', 'Sulejmani', 'ksulejmani@gmail.com', '$2y$10$VfyvZkQnOUeF2A/9d5/Hve6blShzD6Ny2QBPo0RJLu10.A/0KDXBG', NULL, NULL, 'Admin', NULL, NULL, b'0'),
(2, 'Endi', 'Trico', 'enditrico@gmail.com', '$2y$10$Tt6Q3FOisIwPio1EPNtmO.fepZwompmhmVwkr4p48lqmpOo/k8wNG', 695725489, 'Assistant', 'Admin', NULL, NULL, b'1'),
(3, 'John', 'Doee', 'john@example.com', '$2y$10$OyGdy1eel2WBIzxlZ7HAfOrXk9YKF9pAV8CvwTGmLD4ajZm2.XT7e', 695789652, 'Manager', 'Cliente', NULL, NULL, b'1'),
(4, 'Jane', 'Doe', 'jane@example.com', 'password2', 2147483647, 'Supervisor', 'User', NULL, NULL, b'1'),
(5, 'Mark', 'Smith', 'mark@example.com', 'password3', 2147483647, 'Employee', 'User', NULL, NULL, b'1'),
(6, 'Alice10', 'Johnson10', 'alice10@example.com', '$2y$10$Po7LpfOnV2jmvNdT81YGpeWcPL7GTtmWCbboC9AV9Zzi2h6b9nK6C', 698745236, 'BASKETBOLLISTE', 'Admin', '2024-07-12', NULL, b'1'),
(7, 'Bob200', 'Smith100POOOO200', 'bob100@example.com200', '$2y$10$PyLJ7PeT7X5rWm9Ausv47ebtkG.AJSdMhP5vNDQ46.tqqRe7C1qLK', 78910, 'Superviso200', 'Cliente', '2024-07-05', NULL, b'1'),
(8, 'Emily', 'Brown', 'emily@example.com', 'password6', 2147483647, 'Employee', 'User', NULL, NULL, b'1'),
(9, 'Michael', 'Taylor', 'michael@example.com', 'password7', 2147483647, 'Manager', 'Admin', NULL, NULL, b'1'),
(10, 'Sarah', 'White', 'sarah@example.com', 'password8', 2147483647, 'Supervisor', 'User', NULL, NULL, b'1'),
(11, 'David', 'Davis', 'david@example.com', 'password9', 2147483647, 'Employee', 'User', NULL, NULL, b'1'),
(12, 'Jennifer', 'Martinez', 'jennifer@example.com', 'password10', 2147483647, 'Manager', 'Admin', NULL, NULL, b'1'),
(13, 'Dajna200', 'Nako200', 'dnako@gmail.com200', '$2y$10$Z.et7ZQmHJUYpgIWo33axuG/g4ENVkAFroEhS49RmcfOtYMcaF6t2', 200, 'Assistant', 'Cliente', '2024-07-03', '2024-07-05', b'1'),
(14, 'Dajna', 'Nako', 'dajnanako@gmail.com', '$2y$10$Y9sQCW/kK75cT4otiffmCOFHTHNo6jPk3WiaQ0IKM1GpT1qRvxgea', 695789652, 'Assistant', NULL, NULL, NULL, b'1'),
(15, 'Elti', 'Hoxha', 'elti@gmail.com', '$2y$10$oau5SaUiewyQnXaw0Gu2cegGikxgM6wQfLiNRtnKEQ7iq33zgbxUC', 695789652, 'Assistant', NULL, NULL, NULL, b'1'),
(16, 'Renis', 'Garxenaj', 'renis@gmail.com', '$2y$10$RytjtNu9SbLjXTbA6xwqfOaciELrF6ZcbfFxpGtzxARyZ6CTDzavu', 695789652, 'Assistant', NULL, NULL, NULL, b'1'),
(17, 'Elti', 'Nako', 'eltii@gmail.com', '$2y$10$OoAy0Nvfob7iFraQX4ZdmOwUFfPRUpj3Jy7FuAatlli.U7NXEjBvm', 695789652, 'Assistant', NULL, NULL, NULL, b'1'),
(18, 'Dajna200', 'Hoxha200', 'edlti@gmail.com200', '$2y$10$aKF3vWRNMsgvvGCKCRzdu.MXRWI8eVbYXVB7dOPJp06yPcA29/Jzu', 695789652200, 'Assistant200', 'Admin', '2024-07-30', '2024-07-31', b'1'),
(19, 'Keisi', 'Bylyku', 'keisi@gmail.com', '$2y$10$aU7ILt1SwcW4yoexZDLXievnIPwhtf8vHntKfp7CkjsH2qxN51G8C', 695789652, 'Assistant', 'Cliente', NULL, NULL, b'1'),
(20, 'Redi', 'Trifoni', 'redi@gmail.com', '$2y$10$Gq7Q9N8GsxbuHAQoJi1QoeP6lOxb0/g9v3psF1FbgjEWJnOUSSvYW', 695789652, 'Assistant', 'Cliente', NULL, NULL, b'1'),
(21, 'Marenglen', 'Biba', 'mari@gmail.com', '$2y$10$DMgO1hzrQgPH3IzG2T4hcu9oP2pFIF5LuZGBzB/7GnPv7mKsHI.Fa', 695789652, 'Assistant', 'Cliente', NULL, NULL, b'1'),
(22, 'Lorena', 'Kola', 'lorenakola@unyt.edu.al', '$2y$10$0EiAqC31vNSI9mKqzo84o.rtZuInpPq2i7zF/bIWTMk386gsH/KAK', 695725896, 'CEO', 'Cliente', NULL, NULL, b'1'),
(23, 'Dajana', 'Aruci', 'dajanaaruci@unyt.edu.al', '$2y$10$8k.ZkrYBiqlEPOMxA2DGvuVyqNHm2tqJrSgmEgmJgVnRPyltQJedC', 695789652, 'Marketing', 'Cliente', '2024-07-04', '2024-07-13', b'0'),
(24, 'Fabjola', 'Shehu', 'fabi123@gmail.com', '$2y$10$pfRUd84VjmE6PhuADK/ohucUlM9vG9utHtTP079yjwEx7GSlrCpdC', 695789652, 'Assistant', 'Cliente', '2024-07-04', NULL, b'1'),
(25, 'Edona', 'Selim', 'edonaselim@gmail.com', '$2y$10$ZGtAwD0R81oKdozLW/X.R.hjqp9GQwZI3HcdM8yB0oPYrsVHHfRwi', 6589321456, 'Shefe', 'Cliente', NULL, NULL, b'1'),
(26, 'Renis', 'Hoxha', 'r@gmail.com', '$2y$10$n1sgos0h68AVuIgGcYvTrOc76LTi2ep.lOSincminT1n8SsWetDnO', 695789652, 'Manager', 'Cliente', NULL, NULL, b'1'),
(27, 'ewewew', 'ewew', 'werwerewr@gmail.com', '$2y$10$bdlta.pgWePvWKFMDokdJ.xxq/DMpYVOzGBUDc3KpYRRYDud3hRnq', 0, 'weewew', 'Admin', NULL, NULL, b'1'),
(28, 'Fabi', 'Lokuj', 'fabilokuj@gmail.com', '$2y$10$jzZWnfLsvQZ79qkWVxtlAuaJUPB4yfKmutDjchI0yX2Tmxv4DB8Om', 695725896, '', 'Cliente', '2024-06-06', '0000-00-00', b'0'),
(29, 'Elti', 'Bylyku', 'dnakso@gmail.com', '$2y$10$J/6EWP210KGkdsZKnFQcUuekQA1J0FX9xoSHp8w2Hrp.taxvtUkiu', 6589321456, '', 'Cliente', '2024-06-13', NULL, b'1'),
(30, 'Redi', 'Hoxha', 'elti@gmail.coms', '$2y$10$LCmCdIN4yBoeH8wlCSPpvu3jcoSNmMT832OHpi8V.NLUCjXxwNOMu', 695725896, '', 'Cliente', '2024-06-06', '0000-00-00', b'0'),
(31, 'Dajna', 'Bylyku', 'dnako@bgmail.com', '$2y$10$QG23/FhqzZuHZnIf0vXsWuz75J3mL/h2PvHuGUrS5atXR90vnhZA6', 6589321456, '', 'Cliente', '2024-06-07', NULL, b'1'),
(32, 'Dajna', 'Bylyku', 'enditridco@gmail.com', '$2y$10$DOkwcHlPTGnkEvKQMzxHIugv6Se4Z3nBIJmiWHstLDZpEL/D3GBAW', 6589321456, '', 'Admin', '2024-06-06', NULL, b'1'),
(33, 'Kasandra', 'Jamaku', 'kjamaku@gmail.com', '$2y$10$tev75eKHXCBp00yD0c24Jeato9jB/zLLv3AZI/cko18GQbNsGgT.q', 693525969, '', 'Cliente', '2024-07-11', '2024-08-01', b'1'),
(34, 'Kasandra', 'Trifoni', 'dnakbo@gmail.com', '$2y$10$hBL.LJVnrxLsOrRmz2UcQOhREnsvFDFK12byavVT3HWtK76cLN4CW', 695789652, 'l', 'Cliente', '2024-07-24', '2024-08-01', b'1'),
(35, 'Elti', 'Nako', 'anapjerduka@gmail.com', '$2y$10$2TWRXU/5j9f0ALH.yEvPG.Q.MIWnVcoQ8YE9bJkWhBQaLh8eWhv2e', 6589321456, 'l', 'Cliente', '2024-07-19', '2024-08-08', b'0'),
(36, 'Elti', 'Nako', 'endivtrico@gmail.com', '$2y$10$7QZvc0TcU9SkNw53Nsgq4eP8aDR4N/2omrRsQAM7vuuwicJ1AdJ.C', 695789652, '', 'Cliente', '2024-07-18', '2024-07-31', b'0'),
(37, 'LOP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0'),
(38, 'Dajna', 'Garxenaj', 'ksulejmani@gmbail.com', '$2y$10$0Zn61pxFy.LHIGEnPNBLsOJFksygRBiT.tcRNiiSm2bplP8fvzMUu', 695725896, '', 'Cliente', '2024-07-07', NULL, b'1'),
(39, 'Alban800', 'Berisha800', 'alban04@gmail.com800', '$2y$10$CurYGDBqd5xK.Ed/SI0kBuc81V7Wuh.sptwVcF5QQHIP1KicJHrRu', 800, '800', 'Admin', '2001-11-11', '2024-08-15', b'1'),
(40, 'Monica', 'Chandler', 'dnakos@gmail.com', '$2y$10$ehheS9XmUa10gBlXmgqpFe8HjAT4R8rtzitl6i23pKnUELptLUl0m', 6589321456, '', 'Cliente', '2024-07-07', NULL, b'1'),
(41, 'Kasandra', 'Nako', 'enditrichno@gmail.com', '$2y$10$fTxXBWcPrdFQvonnvJx4euwWPSXAT5Lg2ipVj3tO2Aq1HT73iZ0VC', 6589321456, '', 'Cliente', '2024-07-07', NULL, b'1'),
(42, 'Kasandra', 'Nako', 'ksulejm2ani@gmail.com', '$2y$10$aVRsv0WPUcw2exdvgPRx/uvDOWXrAQq.bFMfSCO12/UakPKWqxE7C', 2, '', 'Cliente', '2024-07-11', NULL, b'1'),
(43, 'Elti', 'Hoxha', 'dnako@gmaail.com', '$2y$10$jy5g/kONkfC6qiRAHTOnqOs9h678jguyIGuiCvJSsd7c1./Xr/3/K', 22, '', 'Cliente', '2024-07-11', NULL, b'1'),
(44, 'Dajna', 'Hoxha', 'ksulejmani@gmqail.com', '$2y$10$AM0bbNDvosi//2BMmybM2OmptzkNqjEY5EhUKuC.hUpg3tq7ZcRYa', 2, '', 'Cliente', '2024-07-11', NULL, b'1'),
(45, 'Dajna', 'Nako', 'dnako@gbmail.com', '$2y$10$/aWaGSZbwizg0D.YklJFD.mzxlj5mW/bR5Eq0fp53hZIlsHGksdWq', 0, '', 'Cliente', '2024-07-11', NULL, b'1'),
(46, 'h', 'nh', 'kjamaku@gmail.comnnn', '$2y$10$AciiIW6HlbtgR3WdTAp.9.gSLnIhXf6Ivo77BUQ9b4tdPosrAViYO', 695789652, 'Mng', 'Cliente', NULL, NULL, b'1'),
(47, 'Dan', 'Joe', 'danjoe@gmail.com', '$2y$10$0xizzzbeHLr3QHAD.9K.Eeei0AyNPqjMaQTa6Umkp0S2ks3GTxweK', 695789652, 'Mng', 'Cliente', NULL, NULL, b'1'),
(48, 'Enisa', 'sfg', 'enisat@gmail.com', '$2y$10$0Sx79QxJ2vlhwkbECVA3puWN8sSHyEeJsIw6XxvC.lpm5s2I5.jTy', 6589321456, 'Assistant', 'Cliente', NULL, NULL, b'1'),
(49, 'Krenar', 'Sulejmani', 'krenarsulejmani10@gmail.com', '$2y$10$VFG5iLfT1057AJAjA90bo.exHtJeYQ7Z57n5.Z.YzMTUiCI8EzARu', 123, '', 'Admin', '2024-08-03', NULL, b'1'),
(50, 'Kasandra', 'Hoxha', 'dnaknno@gmail.com', '$2y$10$Pc4ZBuczACcmfSnBQdes.uJGy.irug5xxicysgUiwXGZeundKqvRW', 6589321456, '', 'Cliente', NULL, NULL, b'1'),
(51, 'aaaa', 'aaa', 'dnako@gmail.comaaaa', '$2y$10$66FxAEZH7b2i40sU7sLCjOBJtqXCHui1zso6GjBAVVBzs8FrNgqLm', 695789652, '', 'Cliente', NULL, NULL, b'1'),
(52, 'Dajnarfrf', 'frrffr', 'ksulejmanfffi@gmail.com', '$2y$10$UU0iTao8R7qHSGnbcaSwT.3w4lK5F4iZPeAH9I0wnKsIUv12QJdJC', 2, '', 'Cliente', NULL, NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `utenti_aziende`
--

CREATE TABLE `utenti_aziende` (
  `UTENTE_ID` bigint(20) NOT NULL,
  `AZIENDA_ID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utenti_aziende`
--

INSERT INTO `utenti_aziende` (`UTENTE_ID`, `AZIENDA_ID`) VALUES
(3, 5),
(3, 7),
(3, 8),
(3, 9),
(5, 6),
(6, 8),
(10, 10),
(13, 1),
(18, 1),
(18, 3),
(21, 3),
(21, 4),
(21, 7),
(25, 5),
(26, 1),
(27, 8),
(28, 7),
(34, 6),
(47, 1),
(47, 2),
(47, 3),
(47, 4),
(47, 7),
(47, 10),
(48, 1),
(48, 3),
(48, 6),
(48, 7),
(50, 3),
(51, 4),
(51, 5),
(51, 6),
(52, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aziende`
--
ALTER TABLE `aziende`
  ADD PRIMARY KEY (`AZIENDA_ID`);

--
-- Indexes for table `banca_conti`
--
ALTER TABLE `banca_conti`
  ADD PRIMARY KEY (`BANCA_CONTO_ID`),
  ADD KEY `FK_AZIENDE_BANCA_ACCOUNTS` (`AZIENDA_ID`);

--
-- Indexes for table `documenti`
--
ALTER TABLE `documenti`
  ADD PRIMARY KEY (`DOCUMENTO_ID`),
  ADD KEY `FK_STRUTTURE_DOCUMENTI` (`STRUTTURA_ID`),
  ADD KEY `FK_AZIENDE_DOCUMENTI` (`AZIENDA_ID`);

--
-- Indexes for table `fatture`
--
ALTER TABLE `fatture`
  ADD PRIMARY KEY (`FATTURA_ID`),
  ADD KEY `FK_AZIENDE_FATTURE` (`AZIENDA_ID`),
  ADD KEY `FK_BANCA_CONTI_FATTURE` (`BANCA_CONTO_ID`) USING BTREE;

--
-- Indexes for table `impianti`
--
ALTER TABLE `impianti`
  ADD PRIMARY KEY (`IMPIANTO_ID`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`LOG_ID`);

--
-- Indexes for table `reparti`
--
ALTER TABLE `reparti`
  ADD PRIMARY KEY (`REPARTO_ID`),
  ADD UNIQUE KEY `UQ_AZIENDA_ID_STRUTTURA_ID_REPARTO_NOME_REPARTO` (`AZIENDA_ID`,`STRUTTURA_ID`,`REPARTO_NOME`),
  ADD KEY `FK_STRUTTURE_REPARTI` (`STRUTTURA_ID`);

--
-- Indexes for table `strutture`
--
ALTER TABLE `strutture`
  ADD PRIMARY KEY (`STRUTTURA_ID`),
  ADD UNIQUE KEY `UQ_AZIENDA_ID_STRUTTURA_NOME_STRUTTURA` (`AZIENDA_ID`,`STRUTTURA_NOME`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`UTENTE_ID`),
  ADD UNIQUE KEY `UQ_EMAIL_UTENTI` (`EMAIL`);

--
-- Indexes for table `utenti_aziende`
--
ALTER TABLE `utenti_aziende`
  ADD PRIMARY KEY (`UTENTE_ID`,`AZIENDA_ID`),
  ADD KEY `FK_AZIENDA_UTENTI_AZIENDE` (`AZIENDA_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aziende`
--
ALTER TABLE `aziende`
  MODIFY `AZIENDA_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `banca_conti`
--
ALTER TABLE `banca_conti`
  MODIFY `BANCA_CONTO_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `documenti`
--
ALTER TABLE `documenti`
  MODIFY `DOCUMENTO_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `fatture`
--
ALTER TABLE `fatture`
  MODIFY `FATTURA_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `impianti`
--
ALTER TABLE `impianti`
  MODIFY `IMPIANTO_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `LOG_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=428;

--
-- AUTO_INCREMENT for table `reparti`
--
ALTER TABLE `reparti`
  MODIFY `REPARTO_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `strutture`
--
ALTER TABLE `strutture`
  MODIFY `STRUTTURA_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
  MODIFY `UTENTE_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banca_conti`
--
ALTER TABLE `banca_conti`
  ADD CONSTRAINT `FK_AZIENDE_BANCA_ACCOUNTS` FOREIGN KEY (`AZIENDA_ID`) REFERENCES `aziende` (`AZIENDA_ID`);

--
-- Constraints for table `documenti`
--
ALTER TABLE `documenti`
  ADD CONSTRAINT `FK_AZIENDE_DOCUMENTI` FOREIGN KEY (`AZIENDA_ID`) REFERENCES `aziende` (`AZIENDA_ID`),
  ADD CONSTRAINT `FK_IMPIANTI_DOCUMENTI` FOREIGN KEY (`STRUTTURA_ID`) REFERENCES `impianti` (`IMPIANTO_ID`),
  ADD CONSTRAINT `FK_STRUTTURE_DOCUMENTI` FOREIGN KEY (`STRUTTURA_ID`) REFERENCES `strutture` (`STRUTTURA_ID`);

--
-- Constraints for table `fatture`
--
ALTER TABLE `fatture`
  ADD CONSTRAINT `FK_AZIENDE_FATTURE` FOREIGN KEY (`AZIENDA_ID`) REFERENCES `aziende` (`AZIENDA_ID`),
  ADD CONSTRAINT `FK_BANCA_CONTI_ID` FOREIGN KEY (`BANCA_CONTO_ID`) REFERENCES `banca_conti` (`BANCA_CONTO_ID`);

--
-- Constraints for table `reparti`
--
ALTER TABLE `reparti`
  ADD CONSTRAINT `FK_AZIENDE_REPARTI` FOREIGN KEY (`AZIENDA_ID`) REFERENCES `aziende` (`AZIENDA_ID`),
  ADD CONSTRAINT `FK_STRUTTURE_REPARTI` FOREIGN KEY (`STRUTTURA_ID`) REFERENCES `strutture` (`STRUTTURA_ID`);

--
-- Constraints for table `strutture`
--
ALTER TABLE `strutture`
  ADD CONSTRAINT `FK_AZIENDE_STRUTTURE` FOREIGN KEY (`AZIENDA_ID`) REFERENCES `aziende` (`AZIENDA_ID`);

--
-- Constraints for table `utenti_aziende`
--
ALTER TABLE `utenti_aziende`
  ADD CONSTRAINT `FK_AZIENDA_UTENTI_AZIENDE` FOREIGN KEY (`AZIENDA_ID`) REFERENCES `aziende` (`AZIENDA_ID`),
  ADD CONSTRAINT `FK_UTENTI_UTENTI_AZIENDE` FOREIGN KEY (`UTENTE_ID`) REFERENCES `utenti` (`UTENTE_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
