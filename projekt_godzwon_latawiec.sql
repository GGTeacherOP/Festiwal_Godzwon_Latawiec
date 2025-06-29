-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 02, 2025 at 07:03 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

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
  `data_zakupu` datetime DEFAULT current_timestamp(),
  `cena` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `bilety`
--

INSERT INTO `bilety` (`bilet_id`, `uzytkownicy_id`, `wydarzenia_id`, `data_zakupu`, `cena`) VALUES
(1, 12, 10, '2025-06-01 16:17:36', 150.00);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategoria_wydarzenia`
--

CREATE TABLE `kategoria_wydarzenia` (
  `kategoria_id` int(11) NOT NULL,
  `nazwa` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `kategoria_wydarzenia`
--

INSERT INTO `kategoria_wydarzenia` (`kategoria_id`, `nazwa`) VALUES
(1, 'Festiwal Muzyki Rockowej'),
(2, 'Festiwal Filmowy'),
(3, 'Festiwal Kultury i Sztuki'),
(4, 'Festiwal Jedzenia i Wina'),
(5, 'Festiwal Technologii'),
(6, 'Festiwal Komedii'),
(7, 'Festiwal Literacki'),
(8, 'Festiwal Gier Planszowych'),
(9, 'Festiwal Muzyki Alternatywnej'),
(10, 'Festiwal Kina Niezależnego'),
(11, 'Festiwal Sztuki Nowoczesnej');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lokalizacja`
--

CREATE TABLE `lokalizacja` (
  `lokalizacja_id` int(11) NOT NULL,
  `nazwa` varchar(150) DEFAULT NULL,
  `adres` varchar(255) DEFAULT NULL,
  `zdjecie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `lokalizacja`
--

INSERT INTO `lokalizacja` (`lokalizacja_id`, `nazwa`, `adres`, `zdjecie`) VALUES
(1, 'Sala Koncertowa A', 'ul. Muzyczna 12, Warszawa', '../zdjecia/galeria1.jpg'),
(2, 'Galeria Sztuki Nowoczesnej', 'ul. Artystyczna 5, Kraków', '../zdjecia/galeria2.jpg'),
(3, 'Centrum Kongresowe', 'ul. Wiedzy 3, Wrocław', '../zdjecia/galeria3.jpg'),
(4, 'Stadion Miejski', 'ul. Sportowa 10, Poznań', '../zdjecia/galeria4.jpg'),
(5, 'Park Centralny', 'ul. Zielona 1, Gdańsk', '../zdjecia/galeria5.jpg'),
(6, 'Hala Mosir', 'ul. Kreteńska 13, Mielec', '../zdjecia/galeria6.jpg'),
(7, 'Planty', 'ul. Platowa 20A, Lublin', '../zdjecia/galeria1.jpg'),
(8, 'Górka Glebowa', 'ul. Glebowa 113, Glebnica', '../zdjecia/galeria2.jpg'),
(9, 'Ogrody Politechniki', 'ul. inteligetna 99, Rzeszów', '../zdjecia/galeria3.jpg'),
(10, 'Stadion Wiejski', 'ul. Parkingowa 76, Szczecin', '../zdjecia/galeria4.jpg'),
(11, 'Plaża', 'ul. Wypoczynkowa 4, Hel', '../zdjecia/galeria5.jpg'),
(12, 'Bulwary', 'ul. Jajowa 6, Gdynia', '../zdjecia/galeria6.jpg'),
(13, 'Pod Mostem', 'ul. Mostowa 3, Łódź', '../zdjecia/galeria1.jpg'),
(14, 'Uniwersytet Śląski', 'ul. Górnicza 33, Gliwice', '../zdjecia/galeria2.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `noclegi`
--

CREATE TABLE `noclegi` (
  `nocleg_id` int(11) NOT NULL,
  `lokalizacja_id` int(11) NOT NULL,
  `nazwa` varchar(150) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `liczba_pokoi` int(11) DEFAULT 0,
  `cena_za_noc` decimal(10,2) DEFAULT NULL,
  `dostepnosc` tinyint(1) DEFAULT 1,
  `zdjecie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `noclegi`
--

INSERT INTO `noclegi` (`nocleg_id`, `lokalizacja_id`, `nazwa`, `adres`, `liczba_pokoi`, `cena_za_noc`, `dostepnosc`, `zdjecie`) VALUES
(1, 1, 'Hotel Premium', 'ul. Muzyczna 15, Warszawa', 50, 320.00, 1, '../zdjecia/HotelPremium.jpg'),
(2, 5, 'Hostel Festiwalowy', 'ul. Zielona 2, Gdańsk', 25, 110.00, 1, '../zdjecia/HostelFestiwal.png'),
(3, 11, 'Apartamenty Nad Brzegiem', 'ul. Wypoczynkowa 5, Hel', 12, 290.00, 0, '../zdjecia/apartamentNadBrzegiem.jpg'),
(4, 4, 'Hotel Miejski', 'ul. Sportowa 15, Poznań', 40, 240.00, 1, '../zdjecia/HotelMiejski.png'),
(5, 14, 'Pensjonat Zacisze', 'ul. Górnicza 35, Gliwice', 18, 170.00, 1, '../zdjecia/pensjonatZacisze.png'),
(6, 8, 'Kemping Festiwalowy', 'ul. Glebowa 114, Glebnica', 60, 60.00, 1, '../zdjecia/kempingFestiwalowy.png');

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

--
-- Dumping data for table `pracownicy`
--

INSERT INTO `pracownicy` (`pracownik_id`, `uzytkownicy_id`, `stanowisko`, `data_zatrudnienia`, `zarobki`) VALUES
(1, 7, 'informatyk', '2025-05-01', 6500.00),
(2, 8, 'sprzątaczka', '2025-04-20', 3500.00),
(3, 9, 'organizator', '2025-05-10', 5000.00),
(4, 10, 'technik sceniczny', '2025-05-02', 4700.00),
(5, 11, 'specjalista ds. promocji', '2025-05-05', 5300.00),
(6, 12, 'koordynator wolontariuszy', '2025-05-08', 4800.00);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rezerwacje_noclegow`
--

CREATE TABLE `rezerwacje_noclegow` (
  `rezerwacja_id` int(11) NOT NULL,
  `uzytkownicy_id` int(11) NOT NULL,
  `nocleg_id` int(11) NOT NULL,
  `data_przyjazdu` date NOT NULL,
  `data_wyjazdu` date NOT NULL,
  `liczba_osob` int(11) DEFAULT 1,
  `status` varchar(50) DEFAULT 'potwierdzona'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `rezerwacje_noclegow`
--

INSERT INTO `rezerwacje_noclegow` (`rezerwacja_id`, `uzytkownicy_id`, `nocleg_id`, `data_przyjazdu`, `data_wyjazdu`, `liczba_osob`, `status`) VALUES
(1, 1, 1, '2025-07-19', '2025-07-21', 2, 'potwierdzona'),
(2, 2, 2, '2025-08-14', '2025-08-16', 1, 'potwierdzona'),
(4, 4, 4, '2025-07-28', '2025-07-30', 3, 'potwierdzona'),
(6, 6, 6, '2025-09-21', '2025-09-24', 2, 'potwierdzona');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uczestnicy`
--

CREATE TABLE `uczestnicy` (
  `uczestnik_id` int(11) NOT NULL,
  `uzytkownicy_id` int(11) NOT NULL,
  `data_dolaczenia` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `uczestnicy`
--

INSERT INTO `uczestnicy` (`uczestnik_id`, `uzytkownicy_id`, `data_dolaczenia`) VALUES
(1, 1, '2025-05-18'),
(2, 2, '2025-05-18'),
(4, 4, '2025-05-18'),
(6, 6, '2025-05-18');

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
  `haslo` varchar(255) NOT NULL,
  `rola` varchar(50) NOT NULL DEFAULT 'klient',
  `data_dodania` datetime DEFAULT current_timestamp(),
  `aktywny` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`uzytkownicy_id`, `nazwa`, `imie`, `nazwisko`, `data_urodzenia`, `email`, `telefon`, `haslo`, `rola`, `data_dodania`, `aktywny`) VALUES
(1, 'maciej_latawiec', 'Maciej', 'Latawiec', '2025-05-13', 'maciej.latawiec29@gmail.com', '668939663', '827ccb0eea8a706c4c34a16891f84e7b', 'klient', '2025-05-18 20:08:21', 1),
(2, 'latini', 'michal', 'kowalski', '2025-05-01', 'drapacz.fok29@gmail.com', '123456789', 'e10adc3949ba59abbe56e057f20f883e', 'wlasciciel', '2025-05-18 20:12:50', 1),
(4, 'lala', 'oskar', 'kotlet', '2025-06-06', 'lala@gmail.com', '123456789', '202cb962ac59075b964b07152d234b70', 'klient', '2025-05-18 20:22:29', 1),
(6, 'uaua', 'Szymon', 'Gordi', '2025-05-05', 's@gmail.com', '123456789', '202cb962ac59075b964b07152d234b70', 'wlasciciel', '2025-05-18 20:45:22', 1),
(7, 'blaba', 'sratuys', 'sr', '2025-05-15', 'aka@gmail.com', '098765432', '$2y$10$ThVz5cof/SlIKTXgoX91e.10PDCz8/qX2P7ldgiv7GB', 'klient', '2025-05-18 21:35:14', 1),
(8, 'gcuio', 'mateusz', 'pezda', '2024-12-31', 'mateusz@gmail.com', '123123123', '$2y$10$2ARuO97PaUJ5THF/mIz1C.a4bz7ZxHP9l0Lg4XWNT2h', 'klient', '2025-05-18 21:36:37', 1),
(9, 'ulala', 'karol', 'glaz', '2023-05-09', 'glaz@gmail.com', '123', '$2y$10$LqLg62Tpdr.wmkGHA66Pruted4r2yVEGThOo3ykIg3H', 'klient', '2025-05-18 21:41:00', 1),
(10, 'kipi', 'kacper', 'szewc', '2021-06-15', 'kipi@gmail.com', '888999111', '$2y$10$IZhdgALyVXn7fC/IMTvaz.IruHt.xWFZOeUKRQCdHJ8', 'klient', '2025-05-19 21:57:02', 1),
(11, 'szymus', 'szymek', 'godzwon', '2111-03-12', 'gordi@gmail.com', '111222333', '$2y$10$rwoGG6eAt0un4iRiXP.rlu3GZUOgs7o/g4b4OgulWPi', 'klient', '2025-05-19 21:59:17', 1),
(12, 'dominis', 'marcin', 'wewewe', '2025-05-14', 'xdpl@gmail.com', '111222333', '$2y$10$Iyj/.IVZ9ZPNQH1VLB4a.O4P0NhM1JJDSVgmuiYVfkzbZfx/Oq7f2', 'klient', '2025-05-21 22:11:32', 1),
(13, 'baru', 'Bartosz', 'Dziewit', '2025-05-13', 'baru@gmail.com', '173959424', '$2y$10$vRrfLSueGGaz8USgELQ.HumKaUI47Bbj8t7qM6.DdtV/X0IQXuJTO', 'wlasciciel', '2025-05-25 20:39:26', 1),
(14, 'informatyk', 'olek', 'olisowski', '2025-05-14', 'info@gmail.com', '000111888', '$2y$10$VKsyuPhk/SJhq2jujUgnZemkwzse5mZRtCKt4UNetnd2ykhfDC/1S', 'sprzataczka', '2025-05-25 21:30:02', 1),
(15, 'orga', 'Kazimierz', 'Plamba', '2025-05-28', 'plamba@gmail.com', '121232454', '$2y$10$XW4kW.UHf/bYszmOdtSkH.aRtMeHa7ufDxmOXNXVL2TDp0k3XTuum', 'informatyk', '2025-05-25 21:30:36', 1),
(16, 'sprzataczka', 'katarzyna', 'Plumbowska', '2025-05-06', 'kat@gmail.com', '020858626', '$2y$10$p5v5NQjT4q.an7ZWoZv2.useT6h3pJ8hH/tv2hkY61BBJEEorDczm', 'organizator', '2025-05-25 21:31:26', 1),
(17, 'technikS', 'katastrof', 'Gumiak', '2025-04-30', 'gumiak@gmail.com', '212434676', '$2y$10$g5xA31awYw/8FOE0BTQJc.tAGM6X3UPtsFV5NfuoTfFGrEI6NWWHi', 'technik sceniczny', '2025-05-25 21:32:06', 1),
(18, 'specjalistaDP', 'Patryk', 'Sraki', '2025-05-28', 'sraki@gmasil.com', '213766343', '$2y$10$yoQGiWb.4ZLmwfKBQ92YeeOGdpCJnMeo9thCFB6g1u3tUL7yc/ZlS', 'specjalista ds. promocji', '2025-05-25 21:32:44', 1),
(19, 'koordynatorW', 'Krzysztof', 'Bomba', '2025-05-28', 'bombix@gmail.com', '989545212', '$2y$10$CIPaDzCAiaKfVOXgXOB4z.r2Hw4mm/aMdQiV2awC1mxR07Hz1CdSq', 'koordynator wolontariuszy', '2025-05-25 21:33:14', 1),
(20, 'test', 'test', 'test', '2025-06-18', 'test@gmail.com', '111222999', '$2y$10$nSJxB18/Q6RBfhntdhpN.eyCsA3DsJIc5kFqxfENcHzcDefTI3KCO', 'wlasciciel', '2025-06-01 16:23:02', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wiadomosci_kontaktowe`
--

CREATE TABLE `wiadomosci_kontaktowe` (
  `id` int(11) NOT NULL,
  `nazwisko_imie` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `wiadomosc` text NOT NULL,
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
  `zdjecie` varchar(255) DEFAULT NULL,
  `cena` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `wydarzenia`
--

INSERT INTO `wydarzenia` (`wydarzenia_id`, `tytul`, `opis`, `rozpoczecie`, `zakonczenie`, `lokalizacja_id`, `kategoria_id`, `zdjecie`, `cena`) VALUES
(5, 'Rockowa Burza', 'Eksplozja rockowych brzmień pod gołym niebem.', '2025-07-20 17:00:00', '2025-07-20 23:30:00', 4, 1, '../zdjecia/festiwalMuzykiRockowej.png', 100.00),
(6, 'Filmowa Noc', 'Pokaz filmów niezależnych pod gwiazdami.', '2025-08-05 20:00:00', '2025-08-06 02:00:00', 11, 10, '../zdjecia/festiwalFilmowy.jpg', 150.00),
(7, 'Sztuka Życia', 'Prezentacja nowoczesnych instalacji artystycznych.', '2025-06-25 10:00:00', '2025-06-27 18:00:00', 2, 11, '../zdjecia/festiwalKulturyiSztuki.jpg', 200.00),
(8, 'Smak Fest', 'Festiwal kulinarny z pokazami gotowania.', '2025-08-15 12:00:00', '2025-08-16 22:00:00', 5, 4, '../zdjecia/festiwalJedzeniaiWIna.jpg', 120.00),
(9, 'Tech Days 2025', 'Nowinki technologiczne i panele dyskusyjne.', '2025-09-10 09:00:00', '2025-09-12 18:00:00', 9, 5, '../zdjecia/festiwalTechnologii.jpg', 180.00),
(10, 'Kulturalny Melanż', 'Koncerty i performance kultury miejskiej.', '2025-07-29 16:00:00', '2025-07-29 23:00:00', 12, 3, '../zdjecia/festiwalKulturyiSztuki.jpg', 150.00),
(11, 'Głodni Śmiechu', 'Maraton stand-upów i komedii.', '2025-06-21 19:00:00', '2025-06-21 23:59:00', 6, 6, '../zdjecia/festiwalKomedii.jpg', 100.00),
(14, 'Alt Scena', 'Muzyczne brzmienia alternatywy.', '2025-08-20 17:00:00', '2025-08-20 22:00:00', 7, 9, '../zdjecia/festiwalMuzykiRockowej.png', 100.00),
(15, 'Kino OFF(Najlepsze Kino)', 'Kameralne kino artystyczne i dyskusje....', '2025-07-11 18:00:00', '2025-07-12 00:00:00', 13, 10, '../zdjecia/festiwalFilmowy.jpg', 200.00);

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

--
-- Dumping data for table `zarobki`
--

INSERT INTO `zarobki` (`zarobki_id`, `uzytkownicy_id`, `kwota`, `data_wyplaty`, `opis`) VALUES
(1, 7, 6500.00, '2025-05-25', 'Wypłata za maj 2025 - informatyk'),
(2, 8, 3500.00, '2025-05-25', 'Wypłata za maj 2025 - sprzątaczka'),
(3, 9, 5000.00, '2025-05-25', 'Wypłata za maj 2025 - organizator'),
(4, 10, 4700.00, '2025-05-25', 'Wypłata za maj 2025 - technik sceniczny'),
(5, 11, 5300.00, '2025-05-25', 'Wypłata za maj 2025 - promocja'),
(6, 12, 4800.00, '2025-05-25', 'Wypłata za maj 2025 - koordynator wolontariuszy');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zespoly`
--

CREATE TABLE `zespoly` (
  `zespol_id` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `gatunek` varchar(100) DEFAULT NULL,
  `data_zalozenia` date DEFAULT NULL,
  `zdjecie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `zespoly`
--

INSERT INTO `zespoly` (`zespol_id`, `nazwa`, `gatunek`, `data_zalozenia`, `zdjecie`) VALUES
(5, 'Rockersi', 'Rock', '2010-06-15', '../zdjecia/artysta1.png'),
(6, 'KinoSymfonia', 'Filmowa', '2014-04-10', '../zdjecia/artysta2.png'),
(7, 'ArtNova', 'Ambient/Nowoczesna sztuka', '2016-09-01', '../zdjecia/artysta3.png'),
(8, 'Kucharze Bitów', 'Kulinarny Hip-Hop', '2018-03-18', '../zdjecia/artysta4.png'),
(9, 'Future Sound', 'Elektronika', '2019-05-27', '../zdjecia/artysta5.png'),
(10, 'UrbanVibe', 'Rap/Alternatywa', '2015-11-30', '../zdjecia/artysta6.png'),
(11, 'ŚmiechoGrani', 'Komedia muzyczna', '2017-07-01', '../zdjecia/artysta1.png'),
(12, 'ProzaŻycia', 'Literacki Spoken Word', '2020-02-29', '../zdjecia/artysta2.png'),
(13, 'Planszówka Band', 'Jazz-Folk-Gaming', '2013-08-20', '../zdjecia/artysta3.png'),
(14, 'AltTrack', 'Alternatywa', '2011-12-15', '../zdjecia/artysta4.png'),
(15, 'Projekt OFF', 'Eksperymentalna muzyka filmowa', '2012-04-05', '../zdjecia/artysta5.png');

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
-- Dumping data for table `zespoly_wydarzenia`
--

INSERT INTO `zespoly_wydarzenia` (`id`, `zespol_id`, `wydarzenia_id`, `godzina_wystepu`) VALUES
(5, 5, 5, '2025-07-20 18:00:00'),
(6, 6, 6, '2025-08-05 21:00:00'),
(7, 7, 7, '2025-06-25 11:00:00'),
(8, 8, 8, '2025-08-15 14:00:00'),
(9, 9, 9, '2025-09-10 10:00:00'),
(10, 10, 10, '2025-07-29 17:00:00'),
(11, 11, 11, '2025-06-21 20:00:00'),
(14, 14, 14, '2025-08-20 18:00:00'),
(15, 15, 15, '2025-07-11 19:00:00');

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
-- Indeksy dla tabeli `noclegi`
--
ALTER TABLE `noclegi`
  ADD PRIMARY KEY (`nocleg_id`),
  ADD KEY `lokalizacja_id` (`lokalizacja_id`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`pracownik_id`),
  ADD KEY `uzytkownicy_id` (`uzytkownicy_id`);

--
-- Indeksy dla tabeli `rezerwacje_noclegow`
--
ALTER TABLE `rezerwacje_noclegow`
  ADD PRIMARY KEY (`rezerwacja_id`),
  ADD KEY `uzytkownicy_id` (`uzytkownicy_id`),
  ADD KEY `nocleg_id` (`nocleg_id`);

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
  ADD KEY `kategoria_id` (`kategoria_id`);

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
  MODIFY `bilet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategoria_wydarzenia`
--
ALTER TABLE `kategoria_wydarzenia`
  MODIFY `kategoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lokalizacja`
--
ALTER TABLE `lokalizacja`
  MODIFY `lokalizacja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `noclegi`
--
ALTER TABLE `noclegi`
  MODIFY `nocleg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `pracownik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rezerwacje_noclegow`
--
ALTER TABLE `rezerwacje_noclegow`
  MODIFY `rezerwacja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `uczestnicy`
--
ALTER TABLE `uczestnicy`
  MODIFY `uczestnik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `uczestnicy_zespolu`
--
ALTER TABLE `uczestnicy_zespolu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `uzytkownicy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `wydarzenia`
--
ALTER TABLE `wydarzenia`
  MODIFY `wydarzenia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `zarobki`
--
ALTER TABLE `zarobki`
  MODIFY `zarobki_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `zespoly`
--
ALTER TABLE `zespoly`
  MODIFY `zespol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `zespoly_wydarzenia`
--
ALTER TABLE `zespoly_wydarzenia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
-- Constraints for table `noclegi`
--
ALTER TABLE `noclegi`
  ADD CONSTRAINT `noclegi_ibfk_1` FOREIGN KEY (`lokalizacja_id`) REFERENCES `lokalizacja` (`lokalizacja_id`);

--
-- Constraints for table `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD CONSTRAINT `pracownicy_ibfk_1` FOREIGN KEY (`uzytkownicy_id`) REFERENCES `uzytkownicy` (`uzytkownicy_id`);

--
-- Constraints for table `rezerwacje_noclegow`
--
ALTER TABLE `rezerwacje_noclegow`
  ADD CONSTRAINT `rezerwacje_noclegow_ibfk_1` FOREIGN KEY (`uzytkownicy_id`) REFERENCES `uzytkownicy` (`uzytkownicy_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rezerwacje_noclegow_ibfk_2` FOREIGN KEY (`nocleg_id`) REFERENCES `noclegi` (`nocleg_id`);

--
-- Constraints for table `uczestnicy`
--
ALTER TABLE `uczestnicy`
  ADD CONSTRAINT `uczestnicy_ibfk_1` FOREIGN KEY (`uzytkownicy_id`) REFERENCES `uzytkownicy` (`uzytkownicy_id`) ON DELETE CASCADE;

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
