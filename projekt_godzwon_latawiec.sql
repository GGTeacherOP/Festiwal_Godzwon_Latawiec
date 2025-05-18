-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 18, 2025 at 12:31 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projekt_godzwon_latawiec`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bilety`
--

CREATE TABLE `bilety` (
  `bilet_id` int(11) NOT NULL,
  `uzytkownicy_id` int(11) DEFAULT NULL,
  `wydarzenia_id` int(11) DEFAULT NULL,
  `data_zakupu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategoria_wydarzenia`
--

CREATE TABLE `kategoria_wydarzenia` (
  `kategoria_id` int(11) NOT NULL,
  `nazwa` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lokalizacja`
--

CREATE TABLE `lokalizacja` (
  `lokalizacja_id` int(11) NOT NULL,
  `nazwa` varchar(150) DEFAULT NULL,
  `adres` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `pracownik_id` int(11) NOT NULL,
  `uzytkownicy_id` int(11) NOT NULL,
  `stanowisko` varchar(100) DEFAULT NULL,
  `data_zatrudnienia` date DEFAULT NULL,
  `zarobki` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uczestnicy`
--

CREATE TABLE `uczestnicy` (
  `uczestnik_id` int(11) NOT NULL,
  `uzytkownicy_id` int(11) NOT NULL,
  `data_dolaczenia` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uczestnicy_zespolu`
--

CREATE TABLE `uczestnicy_zespolu` (
  `id` int(11) NOT NULL,
  `uczestnik_id` int(11) NOT NULL,
  `zespol_id` int(11) NOT NULL,
  `rola` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `uzytkownicy_id` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `data_urodzenia` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `haslo` varchar(50) NOT NULL,
  `data_dodania` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wydarzenia`
--

CREATE TABLE `wydarzenia` (
  `wydarzenia_id` int(11) NOT NULL,
  `tytul` varchar(150) DEFAULT NULL,
  `opis` text DEFAULT NULL,
  `rozpoczecie` datetime DEFAULT NULL,
  `zakonczenie` datetime DEFAULT NULL,
  `lokalizacja_id` int(11) DEFAULT NULL,
  `kategoria_id` int(11) DEFAULT NULL,
  `miejsce_festiwalu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zarobki`
--

CREATE TABLE `zarobki` (
  `zarobki_id` int(11) NOT NULL,
  `uzytkownicy_id` int(11) NOT NULL,
  `kwota` decimal(10,2) NOT NULL,
  `data_wyplaty` date NOT NULL,
  `opis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zespoly`
--

CREATE TABLE `zespoly` (
  `zespol_id` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `gatunek` varchar(100) DEFAULT NULL,
  `data_zalozenia` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zespoly_wydarzenia`
--

CREATE TABLE `zespoly_wydarzenia` (
  `id` int(11) NOT NULL,
  `zespol_id` int(11) NOT NULL,
  `wydarzenia_id` int(11) NOT NULL,
  `godzina_wystepu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `bilety`
--
ALTER TABLE `bilety`
  ADD PRIMARY KEY (`bilet_id`),
  ADD KEY `uzytkownicy_id` (`uzytkownicy_id`),
  ADD KEY `wydarzenia_id` (`wydarzenia_id`);

--
-- Indeksy dla tabeli `kategoria_wydarzenia`
--
ALTER TABLE `kategoria_wydarzenia`
  ADD PRIMARY KEY (`kategoria_id`);

--
-- Indeksy dla tabeli `lokalizacja`
--
ALTER TABLE `lokalizacja`
  ADD PRIMARY KEY (`lokalizacja_id`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`pracownik_id`),
  ADD KEY `uzytkownicy_id` (`uzytkownicy_id`);

--
-- Indeksy dla tabeli `uczestnicy`
--
ALTER TABLE `uczestnicy`
  ADD PRIMARY KEY (`uczestnik_id`),
  ADD KEY `uzytkownicy_id` (`uzytkownicy_id`);

--
-- Indeksy dla tabeli `uczestnicy_zespolu`
--
ALTER TABLE `uczestnicy_zespolu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uczestnik_id` (`uczestnik_id`),
  ADD KEY `zespol_id` (`zespol_id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`uzytkownicy_id`),
  ADD UNIQUE KEY `nazwa` (`nazwa`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `wydarzenia`
--
ALTER TABLE `wydarzenia`
  ADD PRIMARY KEY (`wydarzenia_id`),
  ADD KEY `lokalizacja_id` (`lokalizacja_id`),
  ADD KEY `kategoria_id` (`kategoria_id`),
  ADD KEY `miejsce_festiwalu_id` (`miejsce_festiwalu_id`);

--
-- Indeksy dla tabeli `zarobki`
--
ALTER TABLE `zarobki`
  ADD PRIMARY KEY (`zarobki_id`),
  ADD KEY `uzytkownicy_id` (`uzytkownicy_id`);

--
-- Indeksy dla tabeli `zespoly`
--
ALTER TABLE `zespoly`
  ADD PRIMARY KEY (`zespol_id`);

--
-- Indeksy dla tabeli `zespoly_wydarzenia`
--
ALTER TABLE `zespoly_wydarzenia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zespol_id` (`zespol_id`),
  ADD KEY `wydarzenia_id` (`wydarzenia_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bilety`
--
ALTER TABLE `bilety`
  MODIFY `bilet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoria_wydarzenia`
--
ALTER TABLE `kategoria_wydarzenia`
  MODIFY `kategoria_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lokalizacja`
--
ALTER TABLE `lokalizacja`
  MODIFY `lokalizacja_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `pracownik_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uczestnicy`
--
ALTER TABLE `uczestnicy`
  MODIFY `uczestnik_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uczestnicy_zespolu`
--
ALTER TABLE `uczestnicy_zespolu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `uzytkownicy_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wydarzenia`
--
ALTER TABLE `wydarzenia`
  MODIFY `wydarzenia_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zarobki`
--
ALTER TABLE `zarobki`
  MODIFY `zarobki_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zespoly`
--
ALTER TABLE `zespoly`
  MODIFY `zespol_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zespoly_wydarzenia`
--
ALTER TABLE `zespoly_wydarzenia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bilety`
--
ALTER TABLE `bilety`
  ADD CONSTRAINT `bilety_ibfk_1` FOREIGN KEY (`uzytkownicy_id`) REFERENCES `uzytkownicy` (`uzytkownicy_id`),
  ADD CONSTRAINT `bilety_ibfk_2` FOREIGN KEY (`wydarzenia_id`) REFERENCES `wydarzenia` (`wydarzenia_id`);

--
-- Constraints for table `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD CONSTRAINT `pracownicy_ibfk_1` FOREIGN KEY (`uzytkownicy_id`) REFERENCES `uzytkownicy` (`uzytkownicy_id`);

--
-- Constraints for table `uczestnicy`
--
ALTER TABLE `uczestnicy`
  ADD CONSTRAINT `uczestnicy_ibfk_1` FOREIGN KEY (`uzytkownicy_id`) REFERENCES `uzytkownicy` (`uzytkownicy_id`);

--
-- Constraints for table `uczestnicy_zespolu`
--
ALTER TABLE `uczestnicy_zespolu`
  ADD CONSTRAINT `uczestnicy_zespolu_ibfk_1` FOREIGN KEY (`uczestnik_id`) REFERENCES `uczestnicy` (`uczestnik_id`),
  ADD CONSTRAINT `uczestnicy_zespolu_ibfk_2` FOREIGN KEY (`zespol_id`) REFERENCES `zespoly` (`zespol_id`);

--
-- Constraints for table `wydarzenia`
--
ALTER TABLE `wydarzenia`
  ADD CONSTRAINT `wydarzenia_ibfk_1` FOREIGN KEY (`lokalizacja_id`) REFERENCES `lokalizacja` (`lokalizacja_id`),
  ADD CONSTRAINT `wydarzenia_ibfk_2` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria_wydarzenia` (`kategoria_id`);

--
-- Constraints for table `zarobki`
--
ALTER TABLE `zarobki`
  ADD CONSTRAINT `zarobki_ibfk_1` FOREIGN KEY (`uzytkownicy_id`) REFERENCES `uzytkownicy` (`uzytkownicy_id`);

--
-- Constraints for table `zespoly_wydarzenia`
--
ALTER TABLE `zespoly_wydarzenia`
  ADD CONSTRAINT `zespoly_wydarzenia_ibfk_1` FOREIGN KEY (`zespol_id`) REFERENCES `zespoly` (`zespol_id`),
  ADD CONSTRAINT `zespoly_wydarzenia_ibfk_2` FOREIGN KEY (`wydarzenia_id`) REFERENCES `wydarzenia` (`wydarzenia_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
