-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2025 at 09:00 PM
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
-- Database: `sklep internetowy`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ankieta`
--

CREATE TABLE `ankieta` (
  `ankieta_id` mediumint(8) UNSIGNED NOT NULL,
  `zamowienie_id` int(10) UNSIGNED NOT NULL,
  `ocena` enum('0','1','2','3','4','5') NOT NULL,
  `komentarz` varchar(150) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dokument`
--

CREATE TABLE `dokument` (
  `dokument_id` int(10) UNSIGNED NOT NULL,
  `zamowienie_id` int(10) UNSIGNED NOT NULL,
  `typ` enum('paragon','faktura') NOT NULL,
  `data` datetime NOT NULL,
  `kwota` decimal(10,2) NOT NULL,
  `klient_id` int(10) UNSIGNED NOT NULL,
  `NIP` varchar(15) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategoria`
--

CREATE TABLE `kategoria` (
  `kategoria_id` int(10) UNSIGNED NOT NULL,
  `kategoria` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `kategoria`
--

INSERT INTO `kategoria` (`kategoria_id`, `kategoria`) VALUES
(1, 'Elektorinka'),
(2, 'Ksiazki'),
(7, 'Gospodarstwo domowe'),
(9, 'Odziez'),
(10, 'Uslugi'),
(11, 'Budownictwo');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klient`
--

CREATE TABLE `klient` (
  `klient_id` int(10) UNSIGNED NOT NULL,
  `imie` varchar(30) NOT NULL,
  `nazwisko` varchar(40) NOT NULL,
  `adres` varchar(60) NOT NULL,
  `nr_telefonu` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `konto`
--

CREATE TABLE `konto` (
  `konto_id` mediumint(8) UNSIGNED NOT NULL,
  `nazwa_uzytkownika` varchar(50) NOT NULL,
  `haslo` varchar(50) NOT NULL,
  `email` varchar(320) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `konto`
--

INSERT INTO `konto` (`konto_id`, `nazwa_uzytkownika`, `haslo`, `email`, `admin`) VALUES
(1, 'Jonatan Knapik', '12345678', 'xrej.game@gmail.com', 1),
(2, 'kondzio', '12345678', 'nigger@czarnuch.pl', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk`
--

CREATE TABLE `koszyk` (
  `koszyk_id` int(10) UNSIGNED NOT NULL,
  `klient_id` int(10) UNSIGNED NOT NULL,
  `produkt_id` int(10) UNSIGNED NOT NULL,
  `ilosc` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ocena`
--

CREATE TABLE `ocena` (
  `ocena_id` int(11) NOT NULL,
  `ocena` enum('0.0','0.5','1.0','1.5','2.0','2.5','3.0','3.5','4.0','4.5','5.0') NOT NULL,
  `komentarz` varchar(150) NOT NULL,
  `klient_id` int(10) UNSIGNED NOT NULL,
  `produkt_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `producent`
--

CREATE TABLE `producent` (
  `producent_id` int(10) UNSIGNED NOT NULL,
  `producent` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `producent`
--

INSERT INTO `producent` (`producent_id`, `producent`) VALUES
(1, 'Emiter'),
(2, 'Elektret'),
(3, 'Motorola'),
(4, 'FirmaA');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkt`
--

CREATE TABLE `produkt` (
  `produkt_id` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(60) NOT NULL,
  `kategoria_id` int(10) UNSIGNED NOT NULL,
  `cena` decimal(10,0) UNSIGNED NOT NULL,
  `fotografia` varchar(70) NOT NULL,
  `producent_id` int(10) UNSIGNED NOT NULL,
  `opis` varchar(150) NOT NULL,
  `ilosc` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `produkt`
--

INSERT INTO `produkt` (`produkt_id`, `nazwa`, `kategoria_id`, `cena`, `fotografia`, `producent_id`, `opis`, `ilosc`) VALUES
(1, 'Xiaomi ', 1, 2000, '', 1, 'telefon', 50);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `promocja`
--

CREATE TABLE `promocja` (
  `promocja_id` tinyint(3) UNSIGNED NOT NULL,
  `promocja` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `promocja`
--

INSERT INTO `promocja` (`promocja_id`, `promocja`) VALUES
(2, 'Black Friday');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `promocja_produkt`
--

CREATE TABLE `promocja_produkt` (
  `promocja_produkt_id` int(11) NOT NULL,
  `promocja_id` tinyint(3) UNSIGNED NOT NULL,
  `produkt_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `token_reset`
--

CREATE TABLE `token_reset` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `konto_id` mediumint(8) UNSIGNED NOT NULL,
  `token` varchar(64) NOT NULL,
  `wygasa` datetime NOT NULL,
  `wykorzystany` tinyint(1) NOT NULL,
  `utworzono` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienie`
--

CREATE TABLE `zamowienie` (
  `zamowienie_id` int(10) UNSIGNED NOT NULL,
  `klient_id` int(10) UNSIGNED NOT NULL,
  `data_zlozenia_zamowienia` datetime NOT NULL,
  `czy_zaplacono` tinyint(1) NOT NULL,
  `status` enum('nie wyslano','w drodze','dostarczono') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `sposob_wysylki` enum('inpost','orlen paczka','kurier','dpd') NOT NULL,
  `sposob_platnosci` enum('blik','karta','paypal','applepay','przy odbiorze') NOT NULL,
  `cena_laczna` decimal(10,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienie_produkt`
--

CREATE TABLE `zamowienie_produkt` (
  `id` int(10) UNSIGNED NOT NULL,
  `zamowienie_id` int(10) UNSIGNED NOT NULL,
  `produkt_id` int(10) UNSIGNED NOT NULL,
  `ilosc` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia`
--

CREATE TABLE `zdjecia` (
  `zdjecia_id` int(11) NOT NULL,
  `link` varchar(70) NOT NULL,
  `produkt_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `ankieta`
--
ALTER TABLE `ankieta`
  ADD PRIMARY KEY (`ankieta_id`),
  ADD KEY `zamowienie_id` (`zamowienie_id`);

--
-- Indeksy dla tabeli `dokument`
--
ALTER TABLE `dokument`
  ADD PRIMARY KEY (`dokument_id`),
  ADD KEY `zamowienie_id` (`zamowienie_id`,`klient_id`),
  ADD KEY `klient_id` (`klient_id`);

--
-- Indeksy dla tabeli `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`kategoria_id`);

--
-- Indeksy dla tabeli `klient`
--
ALTER TABLE `klient`
  ADD PRIMARY KEY (`klient_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `konto`
--
ALTER TABLE `konto`
  ADD PRIMARY KEY (`konto_id`);

--
-- Indeksy dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  ADD PRIMARY KEY (`koszyk_id`),
  ADD KEY `klient_id` (`klient_id`,`produkt_id`),
  ADD KEY `produkt_id` (`produkt_id`);

--
-- Indeksy dla tabeli `ocena`
--
ALTER TABLE `ocena`
  ADD PRIMARY KEY (`ocena_id`),
  ADD KEY `klinet_id` (`klient_id`,`produkt_id`),
  ADD KEY `produkt_id` (`produkt_id`);

--
-- Indeksy dla tabeli `producent`
--
ALTER TABLE `producent`
  ADD PRIMARY KEY (`producent_id`);

--
-- Indeksy dla tabeli `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`produkt_id`),
  ADD KEY `typ_id` (`kategoria_id`,`producent_id`),
  ADD KEY `producent_id` (`producent_id`);

--
-- Indeksy dla tabeli `promocja`
--
ALTER TABLE `promocja`
  ADD PRIMARY KEY (`promocja_id`);

--
-- Indeksy dla tabeli `promocja_produkt`
--
ALTER TABLE `promocja_produkt`
  ADD KEY `promocja_id` (`promocja_id`,`produkt_id`),
  ADD KEY `produkt_id` (`produkt_id`);

--
-- Indeksy dla tabeli `token_reset`
--
ALTER TABLE `token_reset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `konto_id` (`konto_id`);

--
-- Indeksy dla tabeli `zamowienie`
--
ALTER TABLE `zamowienie`
  ADD PRIMARY KEY (`zamowienie_id`),
  ADD KEY `klinet_id` (`klient_id`);

--
-- Indeksy dla tabeli `zamowienie_produkt`
--
ALTER TABLE `zamowienie_produkt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zamowienie_id` (`zamowienie_id`,`produkt_id`),
  ADD KEY `produkt_id` (`produkt_id`);

--
-- Indeksy dla tabeli `zdjecia`
--
ALTER TABLE `zdjecia`
  ADD PRIMARY KEY (`zdjecia_id`),
  ADD KEY `produkt_id` (`produkt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ankieta`
--
ALTER TABLE `ankieta`
  MODIFY `ankieta_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dokument`
--
ALTER TABLE `dokument`
  MODIFY `dokument_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `kategoria_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `klient`
--
ALTER TABLE `klient`
  MODIFY `klient_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konto`
--
ALTER TABLE `konto`
  MODIFY `konto_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `koszyk`
--
ALTER TABLE `koszyk`
  MODIFY `koszyk_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ocena`
--
ALTER TABLE `ocena`
  MODIFY `ocena_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `producent`
--
ALTER TABLE `producent`
  MODIFY `producent_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produkt`
--
ALTER TABLE `produkt`
  MODIFY `produkt_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promocja`
--
ALTER TABLE `promocja`
  MODIFY `promocja_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `token_reset`
--
ALTER TABLE `token_reset`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zamowienie`
--
ALTER TABLE `zamowienie`
  MODIFY `zamowienie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zamowienie_produkt`
--
ALTER TABLE `zamowienie_produkt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zdjecia`
--
ALTER TABLE `zdjecia`
  MODIFY `zdjecia_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ankieta`
--
ALTER TABLE `ankieta`
  ADD CONSTRAINT `ankieta_ibfk_1` FOREIGN KEY (`zamowienie_id`) REFERENCES `zamowienie` (`zamowienie_id`);

--
-- Constraints for table `dokument`
--
ALTER TABLE `dokument`
  ADD CONSTRAINT `dokument_ibfk_1` FOREIGN KEY (`zamowienie_id`) REFERENCES `zamowienie` (`zamowienie_id`),
  ADD CONSTRAINT `dokument_ibfk_2` FOREIGN KEY (`klient_id`) REFERENCES `klient` (`klient_id`);

--
-- Constraints for table `koszyk`
--
ALTER TABLE `koszyk`
  ADD CONSTRAINT `koszyk_ibfk_1` FOREIGN KEY (`produkt_id`) REFERENCES `produkt` (`produkt_id`),
  ADD CONSTRAINT `koszyk_ibfk_2` FOREIGN KEY (`klient_id`) REFERENCES `klient` (`klient_id`);

--
-- Constraints for table `ocena`
--
ALTER TABLE `ocena`
  ADD CONSTRAINT `ocena_ibfk_1` FOREIGN KEY (`produkt_id`) REFERENCES `produkt` (`produkt_id`),
  ADD CONSTRAINT `ocena_ibfk_2` FOREIGN KEY (`klient_id`) REFERENCES `klient` (`klient_id`);

--
-- Constraints for table `produkt`
--
ALTER TABLE `produkt`
  ADD CONSTRAINT `produkt_ibfk_1` FOREIGN KEY (`producent_id`) REFERENCES `producent` (`producent_id`),
  ADD CONSTRAINT `produkt_ibfk_2` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`kategoria_id`);

--
-- Constraints for table `promocja_produkt`
--
ALTER TABLE `promocja_produkt`
  ADD CONSTRAINT `promocja_produkt_ibfk_1` FOREIGN KEY (`produkt_id`) REFERENCES `produkt` (`produkt_id`),
  ADD CONSTRAINT `promocja_produkt_ibfk_2` FOREIGN KEY (`promocja_id`) REFERENCES `promocja` (`promocja_id`);

--
-- Constraints for table `token_reset`
--
ALTER TABLE `token_reset`
  ADD CONSTRAINT `token_reset_ibfk_1` FOREIGN KEY (`konto_id`) REFERENCES `konto` (`konto_id`);

--
-- Constraints for table `zamowienie`
--
ALTER TABLE `zamowienie`
  ADD CONSTRAINT `zamowienie_ibfk_1` FOREIGN KEY (`klient_id`) REFERENCES `klient` (`klient_id`);

--
-- Constraints for table `zamowienie_produkt`
--
ALTER TABLE `zamowienie_produkt`
  ADD CONSTRAINT `zamowienie_produkt_ibfk_1` FOREIGN KEY (`zamowienie_id`) REFERENCES `zamowienie` (`zamowienie_id`),
  ADD CONSTRAINT `zamowienie_produkt_ibfk_2` FOREIGN KEY (`produkt_id`) REFERENCES `produkt` (`produkt_id`);

--
-- Constraints for table `zdjecia`
--
ALTER TABLE `zdjecia`
  ADD CONSTRAINT `zdjecia_ibfk_1` FOREIGN KEY (`produkt_id`) REFERENCES `produkt` (`produkt_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
