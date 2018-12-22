-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Czas generowania: 16 Gru 2018, 14:09
-- Wersja serwera: 10.1.30-MariaDB
-- Wersja PHP: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";



-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `await_deposit`
--

CREATE TABLE `await_deposit` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Zrzut danych tabeli `await_deposit`
--
CREATE TABLE `anti_log` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `await_withdraw`
--

CREATE TABLE `await_withdraw` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Zrzut danych tabeli `await_withdraw`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `FlipCoin`
--

CREATE TABLE `FlipCoin` (
  `id` int(11) NOT NULL,
  `DateSeed` date NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Side` text,
  `sender_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `result` text NOT NULL,
  `Ch` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Zrzut danych tabeli `FlipCoin`
--



-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `general_info`
--

CREATE TABLE `general_info` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Zrzut danych tabeli `general_info`
--

INSERT INTO `general_info` (`id`, `name`, `value`) VALUES
(1, 'CoinValue', ''),
(2, 'RoundNumber', '1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `code` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Zrzut danych tabeli `logs`
--



-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `seed_story`
--

CREATE TABLE `seed_story` (
  `id` int(11) NOT NULL,
  `ServerSeed` text NOT NULL,
  `PublicSeed` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Zrzut danych tabeli `seed_story`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nick` text NOT NULL,
  `funds` int(11) NOT NULL,
  `profile_pc` text NOT NULL,
  `profile_mobile` text NOT NULL,
  `name` text NOT NULL,
  `surname` text NOT NULL,
  `language` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `rank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--



-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ValueChange`
--

CREATE TABLE `ValueChange` (
  `id` int(11) NOT NULL,
  `ChangeValue` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `await_deposit`
--
ALTER TABLE `await_deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `await_withdraw`
--
ALTER TABLE `await_withdraw`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `FlipCoin`
--
ALTER TABLE `FlipCoin`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `general_info`
--
ALTER TABLE `general_info`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `seed_story`
--
ALTER TABLE `seed_story`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `ValueChange`
--
ALTER TABLE `ValueChange`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `await_deposit`
--
ALTER TABLE `await_deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT dla tabeli `await_withdraw`
--
ALTER TABLE `await_withdraw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT dla tabeli `FlipCoin`
--
ALTER TABLE `FlipCoin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT dla tabeli `general_info`
--
ALTER TABLE `general_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT dla tabeli `seed_story`
--
ALTER TABLE `seed_story`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT dla tabeli `ValueChange`
--
ALTER TABLE `ValueChange`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
