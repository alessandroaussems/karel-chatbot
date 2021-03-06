-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: mysql208.hosting.combell.com:3306
-- Gegenereerd op: 18 jun 2018 om 12:46
-- Serverversie: 5.7.20-18
-- PHP-versie: 5.6.17-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ID241951_karelchatbot`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `keywords`
--

CREATE TABLE `keywords` (
  `id` int(10) UNSIGNED NOT NULL,
  `message_id` int(10) UNSIGNED DEFAULT NULL,
  `keyword` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `keywords`
--

INSERT INTO `keywords` (`id`, `message_id`, `keyword`) VALUES
(2, 2, 'meldingen'),
(3, 3, 'dagmenu'),
(4, 4, 'lessen'),
(5, 5, 'afwezigen'),
(6, 6, 'wifi'),
(7, 7, 'afdrukken'),
(8, 7, 'printen'),
(9, 7, 'print'),
(10, 8, 'fietsenstalling'),
(11, 8, 'code'),
(13, 10, 'punten'),
(14, 11, 'prikbord'),
(15, 11, 'gezocht'),
(17, 12, 'Wie is'),
(19, 16, 'Medewerker'),
(20, 17, 'help'),
(21, 17, 'paniek'),
(23, 19, 'campus'),
(25, 17, 'Hallo'),
(26, 20, 'leerkrediet'),
(27, 21, 'benodigdheden'),
(28, 21, 'nodig'),
(30, 4, 'lessenrooster'),
(31, 12, 'wie is'),
(32, 22, 'vakken'),
(33, 23, 'onderscheiding'),
(34, 1, 'naam'),
(35, 5, 'ziek'),
(36, 23, 'graad verdienstelijkheid');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `livechats`
--

CREATE TABLE `livechats` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `messages`
--

INSERT INTO `messages` (`id`, `answer`) VALUES
(1, '<p>Jouw naam is: [intranet]NAAM[/intranet]</p>'),
(2, '<p>Jouw recentste meldingen: [intranet]MELDINGEN[/intranet]</p><p><br></p>'),
(3, '<p>[intranet]DAGMENU[/intranet]</p>'),
(4, '<p>Je planning voor vandaag ziet er zo uit:</p><p>[intranet]LESSEN[/intranet]</p>'),
(5, '<p>[intranet]AFWEZIGEN[/intranet]<br></p><p></p><p class=\"sceditor-nlf\"><br></p>'),
(6, '<p><meta charset=\"utf-8\"></p><p style=\"\" open=\"\" sans\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" font-style:=\"\" normal;=\"\" font-variant-ligatures:=\"\" font-variant-caps:=\"\" letter-spacing:=\"\" orphans:=\"\" 2;=\"\" text-align:=\"\" start;=\"\" text-indent:=\"\" 0px;=\"\" text-transform:=\"\" none;=\"\" white-space:=\"\" widows:=\"\" word-spacing:=\"\" -webkit-text-stroke-width:=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);=\"\" text-decoration-style:=\"\" initial;=\"\" text-decoration-color:=\"\" initial;\"=\"\" class=\"\">Home is where the wifi is...</p><p style=\"\" open=\"\" sans\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" font-style:=\"\" normal;=\"\" font-variant-ligatures:=\"\" font-variant-caps:=\"\" letter-spacing:=\"\" orphans:=\"\" 2;=\"\" text-align:=\"\" start;=\"\" text-indent:=\"\" 0px;=\"\" text-transform:=\"\" none;=\"\" white-space:=\"\" widows:=\"\" word-spacing:=\"\" -webkit-text-stroke-width:=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);=\"\" text-decoration-style:=\"\" initial;=\"\" text-decoration-color:=\"\" initial;\"=\"\" class=\"\">Voor studenten zijn er 2 draadloze netwerken beschikbaar.<br></p><p style=\"\" open=\"\" sans\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" font-style:=\"\" normal;=\"\" font-variant-ligatures:=\"\" font-variant-caps:=\"\" letter-spacing:=\"\" orphans:=\"\" 2;=\"\" text-align:=\"\" start;=\"\" text-indent:=\"\" 0px;=\"\" text-transform:=\"\" none;=\"\" white-space:=\"\" widows:=\"\" word-spacing:=\"\" -webkit-text-stroke-width:=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);=\"\" text-decoration-style:=\"\" initial;=\"\" text-decoration-color:=\"\" initial;\"=\"\" class=\"\">Beschikbare draadloze netwerken in vernieuwde situatie:<br><b>KdG</b><br><b>KdG-Portal</b><br>Je kan kan verbinden met deze netwerken door in te loggen met je KdG-account.</p><p></p><p class=\"sceditor-nlf\"><br></p>'),
(7, '<p>Dit zijn de printprijzen van het huidige academiejaar:</p><p>[intranet]PRINTPRIJZEN[/intranet]<br></p><p>Je printkrediet opladen kan op&nbsp;<a href=\"https://webpurse.kdg.be\">webpurse.kdg.be</a></p><p>Meer info vind je ook op&nbsp;<a href=\"http://print.kdg.be/\">print.kdg.be</a><br></p>'),
(8, '<p>De code van de fietsenstalling is 2660 + sleuteltje (icoontje links onder op klavier). Als je een verkeerde code intikt, wacht dan tot je een pieptoon hoort en probeer het dan opnieuw.</p><p></p>'),
(10, '<p>Jouw reeds behaalde punten van dit academiejaar:</p><p>[intranet]PUNTEN[/intranet]</p>'),
(11, '<p>[intranet]PRIKBORD[/intranet]</p>'),
(12, '<p>[intranet]WIEISWIE[/intranet]</p>'),
(16, '<p>[intranet]MEDEWERKER[/intranet]</p>'),
(17, '<p>Geen paniek! Wat kan je me allemaal vragen?</p><p>Enkele voorbeelden:</p><p></p><ul><li onclick=\"clickToInput(event)\"><b>Mijn meldingen</b></li><p class=\"\" style=\"\">Je meest recente meldingen van Intranet</p><li \r\n onclick=\"clickToInput(event)\"><b>Dagmenu</b></li><p class=\"\" style=\"\">Het dagmenu op je campus</p><li onclick=\"clickToInput(event)\"><b>Afwezige docenten</b></li><p class=\"\" style=\"\">De afwezige docenten van je studierichting</p><li onclick=\"clickToInput(event)\"><b>Printen</b></li><p class=\"\" style=\"\">De huidige printtarieven van dit academiejaar</p><li onclick=\"clickToInput(event)\"><b>Mijn punten</b></li><p class=\"\" style=\"\">Je reeds behaalde punten van dit academiejaar</p><li onclick=\"clickToInput(event)\"><b>Prikbord</b></li><p class=\"\" style=\"\">Prikbord meldingen</p><li onclick=\"clickToInput(event)\"><b>Wie is</b> Alessandro Aussems</li><p class=\"\" style=\"\">Geeft meer info over wie Alessandro Aussems is.</p><li onclick=\"clickToInput(event)\"><b>Medewerker</b></li><p class=\"\" style=\"\">Start een live chat met een KdG-medewerker</p><li onclick=\"clickToInput(event)\"><b>Mijn campus</b></li><p class=\"\" style=\"\">Geeft je meer info over je campus</p></ul><p></p><p class=\"sceditor-nlf\"><br></p>'),
(19, '<p>Wat meer info over je campus vind je hier:</p><p>[intranet]CAMPUS[/intranet]<br></p>'),
(20, '<p>Jouw leekrediet bedraagt momenteel: [intranet]LEERKREDIET[/intranet]</p>'),
(21, '<p>Dit is wat je allemaal nodig hebt:</p><p>[intranet]BENODIGDHEDEN[/intranet]</p>'),
(22, '<p>Dit zijn alle vakken die je dit academiejaar volgt. Je kan ook de ECTS-fiche bekijken!</p><p>[intranet]VAKKEN[/intranet]</p>'),
(23, '<p>Je huidige graad van verdienstelijkheid bedraagt:</p><p>[intranet]VERDIENSTELIJKHEID[/intranet]</p><p><meta charset=\"utf-8\">De hogeschool kent graden toe op basis van het eindtotaal van de student:</p><p>• minstens 50%: op voldoende wijze&nbsp;</p><p>• minstens 65%: met onderscheiding</p><p>• minstens 75%: met grote onderscheiding&nbsp;</p><p>• minstens 85%: met grootste onderscheiding.</p><p><br></p>');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_03_03_135546_create_messages_table', 1),
(4, '2018_03_03_160009_create_users_sentences', 1),
(5, '2018_03_17_142458_create_sessions_table', 1),
(6, '2018_04_03_191520_add_userdata_to_sessions', 1),
(7, '2018_05_10_122239_create_tags_table', 1),
(8, '2018_05_24_115912_create_livechats_table', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `messages` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_active` datetime NOT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sendmail` tinyint(1) NOT NULL DEFAULT '1',
  `sendsms` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `tags`
--

INSERT INTO `tags` (`id`, `tag`) VALUES
(1, 'MELDINGEN'),
(2, 'NAAM'),
(3, 'DAGMENU'),
(4, 'LESSEN'),
(5, 'AFWEZIGEN'),
(6, 'PRINTPRIJZEN'),
(7, 'PUNTEN'),
(8, 'PRIKBORD'),
(9, 'WIEISWIE'),
(10, 'MEDEWERKER'),
(11, 'CAMPUS'),
(12, 'LEERKREDIET'),
(13, 'BENODIGDHEDEN'),
(14, 'VAKKEN'),
(15, 'VERDIENSTELIJKHEID');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_active` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `last_active`) VALUES
(1, 'Admin', 'info@karel-chatbot.be', '$2y$10$c6RomkNs7LqXZXew7YY49.nG/IkliJbhHwm7DeXwwdTtdxjx0rAeu', 'admin', 'A0A9zIw7l48aY3AH4rS1WMGaomAHkowD1wWYtrAHuWU9bbE6MKGXVLBFHEFL', NULL, '2018-06-17 14:14:40', '2018-06-17 16:14:40'),
(3, 'Chatter', 'chatter@karel-chatbot.be', '$2y$10$mpTu2AZ9Sd8Zm0BT1l2n/OgdJmZ5x3hXRYyXONNzw4r6Jk0lYFJpK', 'chatter', 'HnCX87tqwYf7z1ftLaOUCyowHFD0vmywIQ6ucrIZGaN348aSrPBS2Jxzn7ht', '2018-06-02 11:25:14', '2018-06-02 11:25:14', NULL),
(4, 'Editor', 'editor@karel-chatbot.be', '$2y$10$2.utVV9bWe0YY5Yi44sbg.oI4HzONV0mvm8vNIUc3QcuHeaSPiWqG', 'editor', 'UxPnqXS2hDi87eevGc5oLQxdfqiTmc69N6qqm7FGc8qbaQet9bAOnSK3ad1t', '2018-06-02 11:31:43', '2018-06-02 11:31:43', NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `keywords`
--
ALTER TABLE `keywords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sentences_message_id_foreign` (`message_id`);

--
-- Indexen voor tabel `livechats`
--
ALTER TABLE `livechats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `livechats_session_id_foreign` (`session_id`);

--
-- Indexen voor tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexen voor tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `keywords`
--
ALTER TABLE `keywords`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT voor een tabel `livechats`
--
ALTER TABLE `livechats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT voor een tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `keywords`
--
ALTER TABLE `keywords`
  ADD CONSTRAINT `sentences_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `livechats`
--
ALTER TABLE `livechats`
  ADD CONSTRAINT `livechats_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
