-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 04. jul 2026 ob 13.10
-- Različica strežnika: 10.4.32-MariaDB
-- Različica PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `trgovina_db`
--

-- --------------------------------------------------------

--
-- Struktura tabele `izdelki`
--

CREATE TABLE `izdelki` (
  `id` int(11) NOT NULL,
  `ime` varchar(255) NOT NULL,
  `opis` text DEFAULT NULL,
  `cena` decimal(10,2) NOT NULL,
  `slika` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Odloži podatke za tabelo `izdelki`
--

INSERT INTO `izdelki` (`id`, `ime`, `opis`, `cena`, `slika`) VALUES
(1, 'Pametni telefon', 'Vrhunski pametni telefon z odlično kamero.', 599.99, 'telefon.jpg'),
(2, 'Brezžične slušalke', 'Slušalke z aktivnim dušenjem hrupa.', 129.99, 'slusalke.jpg'),
(3, 'Prenosni računalnik', 'Lahek in zmogljiv prenosnik za delo na terenu.', 899.00, 'prenosnik.jpg');

-- --------------------------------------------------------

--
-- Struktura tabele `narocila`
--

CREATE TABLE `narocila` (
  `id` int(11) NOT NULL,
  `ime_kupca` varchar(255) NOT NULL,
  `priimek_kupca` varchar(255) NOT NULL,
  `naslov` varchar(255) NOT NULL,
  `posta` varchar(50) NOT NULL,
  `datum_narocila` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Odloži podatke za tabelo `narocila`
--

INSERT INTO `narocila` (`id`, `ime_kupca`, `priimek_kupca`, `naslov`, `posta`, `datum_narocila`) VALUES
(1, 'Daniel', 'Test', 'Testna ulica 13', '1000 Ljubljana', '2026-07-04 09:59:04');

-- --------------------------------------------------------

--
-- Struktura tabele `postavke_narocila`
--

CREATE TABLE `postavke_narocila` (
  `id` int(11) NOT NULL,
  `narocilo_id` int(11) DEFAULT NULL,
  `izdelek_id` int(11) DEFAULT NULL,
  `kolicina` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Odloži podatke za tabelo `postavke_narocila`
--

INSERT INTO `postavke_narocila` (`id`, `narocilo_id`, `izdelek_id`, `kolicina`) VALUES
(1, 1, 3, 1);

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `izdelki`
--
ALTER TABLE `izdelki`
  ADD PRIMARY KEY (`id`);

--
-- Indeksi tabele `narocila`
--
ALTER TABLE `narocila`
  ADD PRIMARY KEY (`id`);

--
-- Indeksi tabele `postavke_narocila`
--
ALTER TABLE `postavke_narocila`
  ADD PRIMARY KEY (`id`),
  ADD KEY `narocilo_id` (`narocilo_id`),
  ADD KEY `izdelek_id` (`izdelek_id`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `izdelki`
--
ALTER TABLE `izdelki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT tabele `narocila`
--
ALTER TABLE `narocila`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT tabele `postavke_narocila`
--
ALTER TABLE `postavke_narocila`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `postavke_narocila`
--
ALTER TABLE `postavke_narocila`
  ADD CONSTRAINT `postavke_narocila_ibfk_1` FOREIGN KEY (`narocilo_id`) REFERENCES `narocila` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `postavke_narocila_ibfk_2` FOREIGN KEY (`izdelek_id`) REFERENCES `izdelki` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
