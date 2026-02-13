-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2026 at 08:26 PM
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
  `kategoria` varchar(30) NOT NULL,
  `ikona` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `kategoria`
--

INSERT INTO `kategoria` (`kategoria_id`, `kategoria`, `ikona`) VALUES
(1, 'Elektorinka', '../assets/Icons/Elektronika.jpg'),
(2, 'Ksiazki', '../assets/Icons/Ksiazka.jpg'),
(11, 'Budownictwo', '../assets/Icons/Budownictwo.jpg');

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

--
-- Dumping data for table `klient`
--

INSERT INTO `klient` (`klient_id`, `imie`, `nazwisko`, `adres`, `nr_telefonu`, `email`) VALUES
(15, 'Jonatan', 'Knapik', 'Sloneczna 5, 50-208', '000000000', 'jakis@email.com');

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
(1, 'Jonasz', '12345678', 'xrej.game@gmail.com', 1),
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

--
-- Dumping data for table `koszyk`
--

INSERT INTO `koszyk` (`koszyk_id`, `klient_id`, `produkt_id`, `ilosc`) VALUES
(2, 15, 1, 3),
(5, 15, 32, 5),
(6, 15, 30, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ocena`
--

CREATE TABLE `ocena` (
  `ocena_id` int(11) NOT NULL,
  `ocena` enum('0.0','0.5','1.0','1.5','2.0','2.5','3.0','3.5','4.0','4.5','5.0') NOT NULL,
  `komentarz` varchar(150) NOT NULL,
  `konto_id` mediumint(8) UNSIGNED NOT NULL,
  `produkt_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `ocena`
--

INSERT INTO `ocena` (`ocena_id`, `ocena`, `komentarz`, `konto_id`, `produkt_id`) VALUES
(1, '2.0', 'Bardzo super telefon posiadam go od rokou i nie bylo zadnych problemow.Bardzo super telefon posiadam go od rokou i nie bylo zadnych problemow.Bardzo s', 2, 1),
(4, '4.5', 'abcd', 1, 1);

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
(4, 'Techland');

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
(1, 'Xiaomi ', 1, 2000, '../assets/Product_images/xiaomiredmi14pro-01.jpg', 1, 'telefon', 50),
(23, 'Laptop Acer Nitro 5', 1, 5000, '../assets/Product_images/acernitro5-01.jpg', 2, 'Dla graczy', 100),
(28, 'Telewizor Sharp QLED', 1, 4000, '../assets/Product_images/sharpQLED-01.jpg', 4, 'Telewizor z technologia QLED', 75),
(29, 'Drukarka Brother', 1, 500, '../assets/Product_images/drukarkabrother-01.jpg', 1, 'Tania i nie zawodna drukarka', 255),
(30, 'Iphone', 1, 7000, '../assets/Product_images/iphone15promax-01.jpg', 3, 'Telefon firmy motorola', 100),
(32, 'Hobbit', 2, 50, '../assets/Product_images/hobbit-01.jpg', 1, 'Ksiazka J.R.R. Tolkien', 255),
(37, 'Pan Tadeusz', 2, 50, '../assets/Product_images/PanTadeusz-01.jpg', 4, 'Epopeja polska Mickiewicza', 255),
(39, 'Lalka', 2, 50, '../assets/Product_images/lalka-01.jpg', 2, 'Ksiazka Boleslawa Prusa', 255),
(41, 'Zbrodnia i kara', 2, 50, '../assets/Product_images/zbrodniaIKara-01.jpg', 3, 'kriminal Fiodora Dostojewskiego', 255),
(42, 'Wesele', 2, 50, '../assets/Product_images/wesele-01.jpg', 2, 'Jedna z lektur w polskich szkolach', 255),
(43, 'Duck Tape', 11, 20, '../assets/Product_images/DuckTape-01.jpg', 2, 'Sprawdzona amerykanska tasma', 100),
(44, 'Lopata', 11, 250, '../assets/Product_images/Lopata-01.jpg', 2, 'Lopata budowlana', 50),
(45, 'Cegla', 11, 5, '../assets/Product_images/cegla-01.jpg', 2, 'Cegla z afryki', 255),
(46, 'Gwozdzie', 11, 2, '../assets/Product_images/gwozdzie-01.jpg', 1, 'Gwozdzie 10szt', 255),
(47, 'Cement', 11, 60, '../assets/Product_images/cement-01.jpg', 3, 'Cement 50kg', 100);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `promocja`
--

CREATE TABLE `promocja` (
  `promocja_id` tinyint(3) UNSIGNED NOT NULL,
  `promocja` varchar(50) NOT NULL,
  `obnizka_ceny` int(11) NOT NULL CHECK (`obnizka_ceny` between 1 and 100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `promocja`
--

INSERT INTO `promocja` (`promocja_id`, `promocja`, `obnizka_ceny`) VALUES
(1, 'Black Friday', 30),
(5, 'Winter sales', 20),
(6, 'Summer 50% off', 50),
(8, 'Aniversary sales', 15),
(9, 'Cyber Monday', 25);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `promocja_produkt`
--

CREATE TABLE `promocja_produkt` (
  `promocja_produkt_id` int(11) UNSIGNED NOT NULL,
  `promocja_id` tinyint(3) UNSIGNED NOT NULL,
  `produkt_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `promocja_produkt`
--

INSERT INTO `promocja_produkt` (`promocja_produkt_id`, `promocja_id`, `produkt_id`) VALUES
(5, 9, 1),
(7, 9, 23),
(9, 9, 28),
(6, 9, 29),
(8, 9, 30);

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
-- Dumping data for table `zdjecia`
--

INSERT INTO `zdjecia` (`zdjecia_id`, `link`, `produkt_id`) VALUES
(13, '../assets/Product_images/xiaomiredmi14pro-01.jpg', 1),
(14, '../assets/Product_images/xiaomiredmi14pro-02.jpg', 1),
(15, '../assets/Product_images/xiaomiredmi14pro-03.jpg', 1),
(16, '../assets/Product_images/xiaomiredmi14pro-04.jpg', 1),
(17, '../assets/Product_images/acernitro5-01.jpg', 23),
(18, '../assets/Product_images/acernitro5-02.jpg', 23),
(19, '../assets/Product_images/acernitro5-03.jpg', 23),
(20, '../assets/Product_images/acernitro5-04.jpg', 23),
(21, '../assets/Product_images/drukarkabrother-01.jpg', 29),
(22, '../assets/Product_images/drukarkabrother-02.jpg', 29),
(23, '../assets/Product_images/sharpQLED-01.jpg', 28),
(24, '../assets/Product_images/sharpQLED-02.jpg', 28),
(25, '../assets/Product_images/sharpQLED-03.jpg', 28),
(26, '../assets/Product_images/sharpQLED-04.jpg', 28),
(28, '../assets/Product_images/iphone15promax-01.jpg', 30),
(29, '../assets/Product_images/iphone15promax-02.jpg', 30),
(31, '../assets/Product_images/iphone15promax-03.jpg', 30),
(32, '../assets/Product_images/iphone15promax-04.jpg', 30),
(34, '../assets/Product_images/hobbit-01.jpg', 32),
(35, '../assets/Product_images/PanTadeusz-01.jpg', 37),
(36, '../assets/Product_images/lalka-01.jpg', 39),
(37, '../assets/Product_images/zbrodniaIKara-01.jpg', 41),
(38, '../assets/Product_images/wesele-01.jpg', 42),
(39, '../assets/Product_images/DuckTape-01.jpg', 43),
(40, '../assets/Product_images/DuckTape-02.jpg', 43),
(41, '../assets/Product_images/DuckTape-03.jpg', 43),
(42, '../assets/Product_images/Lopata-01.jpg', 44),
(43, '../assets/Product_images/Lopata-02.jpg', 44),
(44, '../assets/Product_images/Lopata-03.jpg', 44),
(45, '../assets/Product_images/cegla-01.jpg', 45),
(46, '../assets/Product_images/gwozdzie-01.jpg', 46),
(47, '../assets/Product_images/gwozdzie-02.jpg', 46),
(48, '../assets/Product_images/gwozdzie-03.jpg', 46),
(49, '../assets/Product_images/cement-01.jpg', 47),
(50, '../assets/Product_images/cement-02.jpg', 47);

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
  ADD KEY `klinet_id` (`konto_id`,`produkt_id`),
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
  ADD PRIMARY KEY (`promocja_produkt_id`),
  ADD UNIQUE KEY `produkt_id_2` (`produkt_id`),
  ADD KEY `promocja_id` (`promocja_id`,`produkt_id`),
  ADD KEY `produkt_id` (`produkt_id`);

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
  MODIFY `kategoria_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `klient`
--
ALTER TABLE `klient`
  MODIFY `klient_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `konto`
--
ALTER TABLE `konto`
  MODIFY `konto_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `koszyk`
--
ALTER TABLE `koszyk`
  MODIFY `koszyk_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ocena`
--
ALTER TABLE `ocena`
  MODIFY `ocena_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `producent`
--
ALTER TABLE `producent`
  MODIFY `producent_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `produkt`
--
ALTER TABLE `produkt`
  MODIFY `produkt_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `promocja`
--
ALTER TABLE `promocja`
  MODIFY `promocja_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `promocja_produkt`
--
ALTER TABLE `promocja_produkt`
  MODIFY `promocja_produkt_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `zdjecia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
  ADD CONSTRAINT `ocena_ibfk_2` FOREIGN KEY (`konto_id`) REFERENCES `konto` (`konto_id`);

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
