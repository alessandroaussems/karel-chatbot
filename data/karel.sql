-- MySQL dump 10.13  Distrib 5.6.37, for osx10.6 (i386)
--
-- Host: localhost    Database: karel
-- ------------------------------------------------------
-- Server version	5.6.37

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `livechats`
--

DROP TABLE IF EXISTS `livechats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livechats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `livechats_session_id_foreign` (`session_id`),
  CONSTRAINT `livechats_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livechats`
--

LOCK TABLES `livechats` WRITE;
/*!40000 ALTER TABLE `livechats` DISABLE KEYS */;
/*!40000 ALTER TABLE `livechats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `answer` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'<p>Jouw naam is: [intranet]NAAM[/intranet]</p>'),(2,'<p>Jouw recentste meldingen: [intranet]MELDINGEN[/intranet]</p><p><br></p>'),(3,'<p>[intranet]DAGMENU[/intranet]</p>'),(4,'<p>Je planning voor vandaag ziet er zo uit:</p><p>[intranet]LESSEN[/intranet]</p>'),(5,'<p>[intranet]AFWEZIGEN[/intranet]<br></p><p></p><p class=\"sceditor-nlf\"><br></p>'),(6,'<p><meta charset=\"utf-8\"></p><p style=\"\" open=\"\" sans\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" font-style:=\"\" normal;=\"\" font-variant-ligatures:=\"\" font-variant-caps:=\"\" letter-spacing:=\"\" orphans:=\"\" 2;=\"\" text-align:=\"\" start;=\"\" text-indent:=\"\" 0px;=\"\" text-transform:=\"\" none;=\"\" white-space:=\"\" widows:=\"\" word-spacing:=\"\" -webkit-text-stroke-width:=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);=\"\" text-decoration-style:=\"\" initial;=\"\" text-decoration-color:=\"\" initial;\"=\"\" class=\"\">Home is where the wifi is...</p><p style=\"\" open=\"\" sans\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" font-style:=\"\" normal;=\"\" font-variant-ligatures:=\"\" font-variant-caps:=\"\" letter-spacing:=\"\" orphans:=\"\" 2;=\"\" text-align:=\"\" start;=\"\" text-indent:=\"\" 0px;=\"\" text-transform:=\"\" none;=\"\" white-space:=\"\" widows:=\"\" word-spacing:=\"\" -webkit-text-stroke-width:=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);=\"\" text-decoration-style:=\"\" initial;=\"\" text-decoration-color:=\"\" initial;\"=\"\" class=\"\">Voor studenten zijn er 2 draadloze netwerken beschikbaar.<br></p><p style=\"\" open=\"\" sans\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" font-style:=\"\" normal;=\"\" font-variant-ligatures:=\"\" font-variant-caps:=\"\" letter-spacing:=\"\" orphans:=\"\" 2;=\"\" text-align:=\"\" start;=\"\" text-indent:=\"\" 0px;=\"\" text-transform:=\"\" none;=\"\" white-space:=\"\" widows:=\"\" word-spacing:=\"\" -webkit-text-stroke-width:=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);=\"\" text-decoration-style:=\"\" initial;=\"\" text-decoration-color:=\"\" initial;\"=\"\" class=\"\">Beschikbare draadloze netwerken in vernieuwde situatie:<br><b>KdG</b><br><b>KdG-Portal</b><br>Je kan kan verbinden met deze netwerken door in te loggen met je KdG-account.</p><p></p><p class=\"sceditor-nlf\"><br></p>'),(7,'<p>Dit zijn de printprijzen van het huide academiejaar:</p><p>[intranet]PRINTPRIJZEN[/intranet]<br></p><p>Je printkrediet opladen kan op&nbsp;<a href=\"https://webpurse.kdg.be\">webpurse.kdg.be</a></p><p>Meer info vind je ook op&nbsp;<a href=\"http://print.kdg.be/\">print.kdg.be</a></p>'),(8,'<p>De code van de fietsenstalling is 2660 + sleuteltje (icoontje links onder op klavier). Als je een verkeerde code intikt, wacht dan tot je een pieptoon hoort en probeer het dan opnieuw.</p><p></p>'),(10,'<p>Jouw reeds behaalde punten van dit academiejaar:</p><p>[intranet]PUNTEN[/intranet]</p>'),(11,'<p>[intranet]PRIKBORD[/intranet]</p>'),(12,'<p>[intranet]WIEISWIE[/intranet]</p>'),(16,'<p>[intranet]MEDEWERKER[/intranet]</p>'),(17,'<p>Geen paniek! Wat kan je me allemaal vragen?</p><p>Enkele voorbeelden:</p><p></p><ul><li><b>Mijn meldingen</b></li><p class=\"\" style=\"\">Je meest recente meldingen van Intranet</p><li><b>Dagmenu</b></li><p class=\"\" style=\"\">Het dagmenu op je campus</p><li><b>Afwezige docenten</b></li><p class=\"\" style=\"\">Da afwezige docenten van je studierichting</p><li><b>Printen</b></li><p class=\"\" style=\"\">De huidige printtarieven van dit academiejaar</p><li><b>Mijn punten</b></li><p class=\"\" style=\"\">Je reeds behaalde punten van dit academiejaar</p><li><b>Prikbord</b></li><p class=\"\" style=\"\">Prikbord meldingen</p><li><b>Wie is</b> Alessandro Aussems</li><p class=\"\" style=\"\">Geeft meer info over wie Alessandro Aussems is.</p><li><b>Medewerker</b></li><p class=\"\" style=\"\">Start een live chat met een KdG-medewerker</p><li><b>Mijn campus</b></li><p class=\"\" style=\"\">Geeft je meer info over je campus</p></ul><p></p><p class=\"sceditor-nlf\"><br></p>'),(19,'<p>Wat meer info over je campus vind je hier:</p><p>[intranet]CAMPUS[/intranet]<br></p>'),(20,'<p>Jouw leekrediet bedraagt momenteel: [intranet]LEERKREDIET[/intranet]</p>'),(21,'<p>Dit is wat je allemaal nodig hebt:</p><p>[intranet]BENODIGDHEDEN[/intranet]</p>');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_03_03_135546_create_messages_table',1),(4,'2018_03_03_160009_create_users_sentences',1),(5,'2018_03_17_142458_create_sessions_table',1),(6,'2018_04_03_191520_add_userdata_to_sessions',1),(7,'2018_05_10_122239_create_tags_table',1),(8,'2018_05_24_115912_create_livechats_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sentences`
--

DROP TABLE IF EXISTS `sentences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sentences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(10) unsigned DEFAULT NULL,
  `sentence` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sentences_message_id_foreign` (`message_id`),
  CONSTRAINT `sentences_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sentences`
--

LOCK TABLES `sentences` WRITE;
/*!40000 ALTER TABLE `sentences` DISABLE KEYS */;
INSERT INTO `sentences` VALUES (1,1,'Mijn naam'),(2,2,'Mijn meldingen'),(3,3,'Dagmenu'),(4,4,'Lessen'),(5,5,'Afwezige docenten'),(6,6,'Wifi'),(7,7,'Afdrukken'),(8,7,'Printen'),(9,7,'Print'),(10,8,'Fietsenstalling'),(11,8,'Code fietsenstalling'),(13,10,'Mijn punten'),(14,11,'Prikbord'),(15,11,'Gezocht'),(16,11,'Evenementen'),(17,12,'Wie is'),(19,16,'Medewerker'),(20,17,'Help'),(21,17,'Paniek'),(22,17,'Wat moet ik doen?'),(23,19,'Mijn campus'),(24,19,'Campus'),(25,17,'Hallo'),(26,20,'Mijn leerkrediet'),(27,21,'Wat heb ik nodig?'),(28,21,'Benodigdheden'),(30,4,'Lessenrooster'),(31,12,'wie is');
/*!40000 ALTER TABLE `sentences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `messages` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_active` datetime NOT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('5b12865982114','[[\"Hallo ik ben Karel! Stel je vragen maar! Weet je niet wat vragen? Dan kan je altijd \'Help\' typen!\",\"B\"],[\"Mijn meldingen\",\"H\"],[\"<p>Jouw recentste meldingen:  <p onclick=\'showLoginForm(this.event)\' style=\'cursor: pointer\'><strong>Log je in bij KdG<span style=\'font-family: icon; border: 1px solid white; margin-left: 1%; margin-right: 1%; padding: 1%\' onclick=\'showLoginForm(this.event)\'> h <\\/span> zodat ik deze informatie te weten kan komen!<\\/strong><\\/p> <\\/p><p><br><\\/p>\",\"B\"],[\"Medewerker\",\"H\"],[\"<p> <p>Oke! No hard feelings...Vanaf nu ben je aan het chatten met een medewerken van KdG. Stel je vragen maar! Om de sessie te bee\\u00efndigen kan je altijd \'Medewerker stop\' ingeven.<\\/p> <\\/p>\",\"B\"],[\"Hallo!\",\"H\"],[\"Hallo! Hoe is het ermee?\",\"B\"],[\"Goed ik heb wel een vraag....\",\"H\"],[\"Hallo?\",\"H\"],[\"Stel ze maar!\",\"B\"],[\"Wanneer is onze proclamatie?\",\"H\"],[\"Die is 29juni!\",\"B\"],[\"Dankjewel!\",\"H\"],[\"Graag gedaan!\",\"B\"],[\"Medewerkerk stop\",\"H\"],[\"<p>Hopelijk heeft de KdG-Medewerker je kunnen helpen...Vanaf nu kan je al je vragen weer gewoon aan mij stellen, Karel d\\u00e9 chatbot van KdG!<\\/p>\",\"B\"],[\"Mijn meldingen\",\"H\"],[\"<p>Jouw recentste meldingen:  <ul><li><h5>Vrijdag 1 juni: Bibliotheken campus Groenplaats en Hoboken gesloten<\\/h5><p>                                  De bibliotheken van campus Zuid en campus Sint Lucas zijn geopend.                              ...<\\/p><\\/li><li><h5>Teleblok<\\/h5><p>                                  Het is eind mei, dus staan traditiegetrouw \\\"de blok\\\" en de examenperiode voor de deur. Loopt niet alles zoals gewens...<\\/p><\\/li><li><h5>Welke 5 laatstejaarsstudenten verdienen De Grote Award editie 2018?<\\/h5><p>                                  \\r\\nVoor het eerst reiken we dit jaar tijdens onze proclamaties niet alleen diploma\\u2019s, maar ook De Grote Award uit. ...<\\/p><\\/li><\\/ul> <\\/p><p><br><\\/p>\",\"B\"],[\"Mijn punten\",\"H\"],[\"<p>Jouw reeds behaalde punten van dit academiejaar:<\\/p><p> <table border=\'1\' style=\'width: 80%; margin: 0 auto\'><tr><td>Communicatie 3<\\/td><td>15<\\/td><\\/tr><tr><td>Frans 3<\\/td><td>13,0<\\/td><\\/tr><tr><td>RZL 3<\\/td><td>16,0<\\/td><\\/tr><tr><td>Ondernemen 3<\\/td><td>17<\\/td><\\/tr><tr><td>Project Web-UX 3<\\/td><td>14<\\/td><\\/tr><tr><td>Web Design 3<\\/td><td>13<\\/td><\\/tr><tr><td>Web Development 3<\\/td><td>13<\\/td><\\/tr><tr><td>Web Research 3<\\/td><td>15<\\/td><\\/tr><\\/table> <\\/p>\",\"B\"],[\"Mijn campus\",\"H\"],[\"<p>Wat meer info over je campus vind je hier:<\\/p><p> <p>Adres:&nbsp;<a target=\'_blank\' title=\'Navigeren\' href=\'https:\\/\\/www.google.com\\/maps\\/dir\\/?api=1&amp;destination=Salesianenlaan90%0D%0A2660Hoboken&amp;travelmode=transit\'>Salesianenlaan 90                          \\r\\n                          2660                          Hoboken<\\/a>&nbsp;<a id=\'marker\' target=\'_blank\' title=\'Navigeren\' href=\'https:\\/\\/www.google.com\\/maps\\/dir\\/?api=1&amp;destination=Salesianenlaan90%0D%0A2660Hoboken&amp;travelmode=transit\'>j<\\/a><p>Openingsuren van de campus:<\\/p><table border=\'1\' style=\'width: 80%; margin: 0 auto\'<tr><td>M<\\/td><td>07.30 - 20.00 u.<\\/td><\\/tr><tr><td>D<\\/td><td>07.30 - 21.00 u.<\\/td><\\/tr><tr><td>W<\\/td><td>07.30 - 21.00 u.<\\/td><\\/tr><tr><td>D<\\/td><td>07.30 - 21.00 u.<\\/td><\\/tr><tr><td>V<\\/td><td>07.30 - 20.00 u.<\\/td><\\/tr><tr><td>Z<\\/td><td>Gesloten<\\/td><\\/tr><tr><td>Z<\\/td><td>Gesloten<\\/td><\\/tr><\\/table> <br><\\/p>\",\"B\"],[\"Prikbord\",\"H\"],[\"<p> <ul style=\'padding: 0\'><li><h5>GEZOCHT: vacature opvoeder\\/begeleider<\\/h5><p>voor een vervanging wegens zwangerschap zijn wij op zoek naar een deeltijds persoonlijk assistent, regio westerlo. \\r\\n \\r\\nmeer info <a target=\'_blank\' href=\'https:\\/\\/werkgevers.vdab.be\\/include\\/vacature\\/57655046\'>https:\\/\\/werkgevers.vdab.be\\/include\\/vacature\\/57655046<\\/a> <\\/p><\\/li><li><h5>GEZOCHT: Oppas gezocht<\\/h5><p>Oppas gezocht voor Eneya, meisje van bijna 4, regio Deurne. \\r\\n \\r\\nVerloning onderhandelbaar naargelang de \\u2018opdracht\\u2019 (enkel avond of met overnachting). Indicatie: tarieven gezinsbond. \\r\\n \\r\\nEneya heeft geen bijzondere noden, maar zoekt wel een flexibele, leuke oppas met verantwoordelijkheidszin en bereidheid tot een lange termijn commitment. \\r\\n \\r\\nVoor meer info: contacteer mama Gwen (gwen.schoeters@gmail.com of 0486 623985)<\\/p><\\/li><\\/ul> <\\/p>\",\"B\"],[\"Afwezige docenten\",\"H\"],[\"<p> <ul style=\'list-style-type: none; padding: 0\'><li>              Brys Ans <br \\/>              <small><strong>afwezig van<\\/strong> 7\\/12\\/2017 <strong>tot en met<\\/strong> 30\\/06\\/2018<\\/small>                      <\\/li><li>              De Boi ivan <br \\/>              <small><strong>afwezig van<\\/strong> 14\\/05\\/2018 <strong>tot en met<\\/strong> 29\\/06\\/2018<\\/small>                      <\\/li><li>              Soontjens Koen <br \\/>              <small><strong>afwezig van<\\/strong> 31\\/03\\/2018 <strong>tot en met<\\/strong> 30\\/06\\/2018<\\/small>                      <\\/li><\\/ul> <br><\\/p><p><\\/p><p class=\\\"sceditor-nlf\\\"><br><\\/p>\",\"B\"],[\"Dagmenu\",\"H\"],[\"<p> <span id=\\\"pagemain_0_homefooter_0_MyStudyfieldRepeater_MenuText_0\\\">Geen menu beschikbaar voor vandaag<\\/span> <\\/p>\",\"B\"],[\"TEST\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D\",\"B\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D\",\"B\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D\",\"B\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D\",\"B\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie Exacte wetenschappen\",\"H\"],[\"Mijn intresses: Administratie Exacte wetenschappen Muziek\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Mijn intresses: Administratie\",\"H\"],[\"Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D\",\"B\"],[\"Mijn leerkrediet\",\"H\"],[\"<p>Jouw leekrediet bedraagt momenteel:   <\\/p>\",\"B\"],[\"Mijn leerkrediet\",\"H\"],[\"<p>Jouw leekrediet bedraagt momenteel:   <\\/p>\",\"B\"],[\"Mijn leerkrediet\",\"H\"],[\"<p>Jouw leekrediet bedraagt momenteel:   <\\/p>\",\"B\"],[\"Mijn leerkrediet\",\"H\"],[\"<p>Jouw leekrediet bedraagt momenteel:  <p>+168<\\/p> <\\/p>\",\"B\"],[\"Mijn leerkrediet\",\"H\"],[\"<p>Jouw leekrediet bedraagt momenteel:  <p>+168<\\/p><br><small>Dit is de meest recente raadpleging.<\\/small> <\\/p>\",\"B\"],[\"Benodigdheden\",\"H\"],[\"<p>Dit is wat je allemaal nodig hebt:<\\/p><p> <p>+168<\\/p><br><small>Dit is de meest recente raadpleging.<\\/small> <\\/p>\",\"B\"],[\"Benodigdheden\",\"H\"],[\"Benodigdheden\",\"H\"],[\"Benodigdheden\",\"H\"],[\"Benodigdheden\",\"H\"],[\"Benodigdheden\",\"H\"],[\"Benodigdheden\",\"H\"],[\"Benodigdheden\",\"H\"],[\"Benodigdheden\",\"H\"],[\"Benodigdheden\",\"H\"],[\"Benodigdheden\",\"H\"],[\"Benodigdheden\",\"H\"],[\"Benodigdheden\",\"H\"],[\"Benodigdheden\",\"H\"],[\"Benodigdheden\",\"H\"],[\"<p>Dit is wat je allemaal nodig hebt:<\\/p><p> <div><h5>Frans   3<\\/h5><p>Auteur:&nbsp;P.Pelckmans\\r\\nUitgever:&nbsp;KdG\\r\\nMedium:&nbsp;Cursussen\\r\\nISBN-nr:&nbsp;222-00-800-7230-0<\\/p><p>Opleidingsonderdeel&nbsp;Frans 3<\\/p><p>Kalender: Periode 1+2<\\/p><div><h5>Ondernemen 3<\\/h5><p>Auteur:&nbsp;Sonja Geerts\\r\\nUitgever:&nbsp;KdG\\r\\nMedium:&nbsp;Cursussen\\r\\nISBN-nr:&nbsp;222-00-800-8918-6\\r\\nEditie:&nbsp;2017<\\/p><p>Opleidingsonderdeel&nbsp;Ondernemen 3<\\/p><p>Kalender: Periode 1+2<\\/p> <\\/p>\",\"B\"],[\"Benodigdheden\",\"H\"],[\"<p>Dit is wat je allemaal nodig hebt:<\\/p><p> <div><h5>Frans   3<\\/h5><p>Auteur:&nbsp;P.Pelckmans\\r\\nUitgever:&nbsp;KdG\\r\\nMedium:&nbsp;Cursussen\\r\\nISBN-nr:&nbsp;222-00-800-7230-0<\\/p><p>Opleidingsonderdeel:&nbsp;Frans 3<\\/p><p>Kalender: Periode 1+2<\\/p><div><h5>Ondernemen 3<\\/h5><p>Auteur:&nbsp;Sonja Geerts\\r\\nUitgever:&nbsp;KdG\\r\\nMedium:&nbsp;Cursussen\\r\\nISBN-nr:&nbsp;222-00-800-8918-6\\r\\nEditie:&nbsp;2017<\\/p><p>Opleidingsonderdeel:&nbsp;Ondernemen 3<\\/p><p>Kalender: Periode 1+2<\\/p> <\\/p>\",\"B\"],[\"Benodigdheden\",\"H\"],[\"<p>Dit is wat je allemaal nodig hebt:<\\/p><p> <div><h5>Frans   3<\\/h5><p>Auteur:&nbsp;P.Pelckmans\\r\\nUitgever:&nbsp;KdG\\r\\nMedium:&nbsp;Cursussen\\r\\nISBN-nr:&nbsp;222-00-800-7230-0<\\/p><p>Opleidingsonderdeel:&nbsp;Frans 3<\\/p><p>Kalender: Periode 1+2<\\/p><div><h5>Ondernemen 3<\\/h5><p>Auteur:&nbsp;Sonja Geerts\\r\\nUitgever:&nbsp;KdG\\r\\nMedium:&nbsp;Cursussen\\r\\nISBN-nr:&nbsp;222-00-800-8918-6\\r\\nEditie:&nbsp;2017<\\/p><p>Opleidingsonderdeel:&nbsp;Ondernemen 3<\\/p><p>Kalender: Periode 1+2<\\/p> <\\/p>\",\"B\"],[\"Benodigdheden\",\"H\"],[\"<p>Dit is wat je allemaal nodig hebt:<\\/p><p> <div><h5>Frans   3<\\/h5><p>Auteur:&nbsp;P.Pelckmans\\r\\nUitgever:&nbsp;KdG\\r\\nMedium:&nbsp;Cursussen\\r\\nISBN-nr:&nbsp;222-00-800-7230-0<\\/p><p>Opleidingsonderdeel:&nbsp;Frans 3<\\/p><p>Kalender: Periode 1+2<\\/p><div><h5>Ondernemen 3<\\/h5><p>Auteur:&nbsp;Sonja Geerts\\r\\nUitgever:&nbsp;KdG\\r\\nMedium:&nbsp;Cursussen\\r\\nISBN-nr:&nbsp;222-00-800-8918-6\\r\\nEditie:&nbsp;2017<\\/p><p>Opleidingsonderdeel:&nbsp;Ondernemen 3<\\/p><p>Kalender: Periode 1+2<\\/p> <\\/p>\",\"B\"],[\"Benodigdheden\",\"H\"],[\"<p>Dit is wat je allemaal nodig hebt:<\\/p><p> <div><h5>Frans   3<\\/h5><p>Auteur:&nbsp;P.Pelckmans<br \\/>\\r\\nUitgever:&nbsp;KdG<br \\/>\\r\\nMedium:&nbsp;Cursussen<br \\/>\\r\\nISBN-nr:&nbsp;222-00-800-7230-0<\\/p><p>Opleidingsonderdeel:&nbsp;Frans 3<\\/p><p>Kalender: Periode 1+2<\\/p><div><h5>Ondernemen 3<\\/h5><p>Auteur:&nbsp;Sonja Geerts<br \\/>\\r\\nUitgever:&nbsp;KdG<br \\/>\\r\\nMedium:&nbsp;Cursussen<br \\/>\\r\\nISBN-nr:&nbsp;222-00-800-8918-6<br \\/>\\r\\nEditie:&nbsp;2017<\\/p><p>Opleidingsonderdeel:&nbsp;Ondernemen 3<\\/p><p>Kalender: Periode 1+2<\\/p> <\\/p>\",\"B\"],[\"Benodigdheden\",\"H\"],[\"<p>Dit is wat je allemaal nodig hebt:<\\/p><p> <div><h5>Frans   3<\\/h5><p>Auteur:&nbsp;P.Pelckmans<br \\/>\\r\\nUitgever:&nbsp;KdG<br \\/>\\r\\nMedium:&nbsp;Cursussen<br \\/>\\r\\nISBN-nr:&nbsp;222-00-800-7230-0<\\/p><p>Opleidingsonderdeel:&nbsp;Frans 3<\\/p><p>Kalender: Periode 1+2<\\/p><\\/div><div><h5>Ondernemen 3<\\/h5><p>Auteur:&nbsp;Sonja Geerts<br \\/>\\r\\nUitgever:&nbsp;KdG<br \\/>\\r\\nMedium:&nbsp;Cursussen<br \\/>\\r\\nISBN-nr:&nbsp;222-00-800-8918-6<br \\/>\\r\\nEditie:&nbsp;2017<\\/p><p>Opleidingsonderdeel:&nbsp;Ondernemen 3<\\/p><p>Kalender: Periode 1+2<\\/p><\\/div> <\\/p>\",\"B\"],[\"Help\",\"H\"],[\"<p>Geen paniek! Wat kan je me allemaal vragen?<\\/p><p>Enkele voorbeelden:<\\/p><p><\\/p><ul><li>Mijn meldingen<\\/li><p class=\\\"\\\" style=\\\"\\\">Je meest recente meldingen van Intranet<\\/p><li>Dagmenu<\\/li><p class=\\\"\\\" style=\\\"\\\">Het dagmenu op je campus<\\/p><li>Afwezige docenten<\\/li><p class=\\\"\\\" style=\\\"\\\">Da afwezige docenten van je studierichting<\\/p><li>Printen<\\/li><p class=\\\"\\\" style=\\\"\\\">De huidige printtarieven van dit academiejaar<\\/p><li>Mijn punten<\\/li><p class=\\\"\\\" style=\\\"\\\">Je reeds behaalde punten van dit academiejaar<\\/p><li>Prikbord<\\/li><p class=\\\"\\\" style=\\\"\\\">Prikbord meldingen<\\/p><li>Wie is Alessandro Aussems<\\/li><p class=\\\"\\\" style=\\\"\\\">Geeft meer info over wie Alessandro Aussems is.<\\/p><li>Medewerker<\\/li><p class=\\\"\\\" style=\\\"\\\">Start een live chat met een KdG-medewerker<\\/p><li>Mijn campus<\\/li><p class=\\\"\\\" style=\\\"\\\">Geeft je meer info over je campus<\\/p><\\/ul><p><\\/p><p class=\\\"sceditor-nlf\\\"><br><\\/p>\",\"B\"],[\"Help\",\"H\"],[\"<p>Geen paniek! Wat kan je me allemaal vragen?<\\/p><p>Enkele voorbeelden:<\\/p><p><\\/p><ul><li><b>Mijn meldingen<\\/b><\\/li><p class=\\\"\\\" style=\\\"\\\">Je meest recente meldingen van Intranet<\\/p><li><b>Dagmenu<\\/b><\\/li><p class=\\\"\\\" style=\\\"\\\">Het dagmenu op je campus<\\/p><li><b>Afwezige docenten<\\/b><\\/li><p class=\\\"\\\" style=\\\"\\\">Da afwezige docenten van je studierichting<\\/p><li><b>Printen<\\/b><\\/li><p class=\\\"\\\" style=\\\"\\\">De huidige printtarieven van dit academiejaar<\\/p><li><b>Mijn punten<\\/b><\\/li><p class=\\\"\\\" style=\\\"\\\">Je reeds behaalde punten van dit academiejaar<\\/p><li><b>Prikbord<\\/b><\\/li><p class=\\\"\\\" style=\\\"\\\">Prikbord meldingen<\\/p><li><b>Wie is<\\/b> Alessandro Aussems<\\/li><p class=\\\"\\\" style=\\\"\\\">Geeft meer info over wie Alessandro Aussems is.<\\/p><li><b>Medewerker<\\/b><\\/li><p class=\\\"\\\" style=\\\"\\\">Start een live chat met een KdG-medewerker<\\/p><li><b>Mijn campus<\\/b><\\/li><p class=\\\"\\\" style=\\\"\\\">Geeft je meer info over je campus<\\/p><\\/ul><p><\\/p><p class=\\\"sceditor-nlf\\\"><br><\\/p>\",\"B\"],[\"Hangit\",\"H\"],[\"<p>HangGit<\\/p><p><iframe src=\\\"https:\\/\\/hangit.alessandro.aussems.mtantwerp.eu\\/\\\"><\\/iframe><\\/p>\",\"B\"],[\"lessen\",\"H\"],[\"<p> 05 06 <\\/p>\",\"B\"],[\"lessen\",\"H\"],[\"<p> 05 <\\/p>\",\"B\"],[\"lessen\",\"H\"],[\"<p> 05 <\\/p>\",\"B\"],[\"lessen\",\"H\"],[\"<p> <p>Deze functie is nog in ontwikkeling...<\\/p> <\\/p>\",\"B\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"<p> <h4>Examen Projectontwikkeling 2 (Presentatie)<\\/h4><p>HO-A106<\\/p><\\/p>08:30 - 17:30<\\/p> <\\/p>\",\"B\"],[\"lessen\",\"H\"],[\"<p> <h4>Examen Projectontwikkeling 2 (Presentatie)<\\/h4><\\/p>08:30 - 17:30<\\/p><p>HO-A106<\\/p> <\\/p>\",\"B\"],[\"lessen\",\"H\"],[\"<p> Voor vandaag staat er niets gepland! Je kan gezellig thuis blijven! <\\/p>\",\"B\"],[\"Lessen\",\"H\"],[\"<p> Voor vandaag staat er niets gepland! Je kan gezellig thuis blijven! <\\/p>\",\"B\"]]','2018-06-05 00:00:00','Alessandro','Aussems','alessandro.aussems@student.kdg.be','1C+btKT8IuMFjDIdwffXDw=='),('5b13bd658a129','[[\"Hallo ik ben Karel! Stel je vragen maar! Weet je niet wat vragen? Dan kan je altijd \'Help\' typen!\",\"B\"],[\"Benodigdheden\",\"H\"],[\"<p>Dit is wat je allemaal nodig hebt:<\\/p><p> <div><h5>Frans   3<\\/h5><p>Auteur:&nbsp;P.Pelckmans<br \\/>\\r\\nUitgever:&nbsp;KdG<br \\/>\\r\\nMedium:&nbsp;Cursussen<br \\/>\\r\\nISBN-nr:&nbsp;222-00-800-7230-0<\\/p><p>Opleidingsonderdeel:&nbsp;Frans 3<\\/p><p>Kalender: Periode 1+2<\\/p><\\/div><div><h5>Ondernemen 3<\\/h5><p>Auteur:&nbsp;Sonja Geerts<br \\/>\\r\\nUitgever:&nbsp;KdG<br \\/>\\r\\nMedium:&nbsp;Cursussen<br \\/>\\r\\nISBN-nr:&nbsp;222-00-800-8918-6<br \\/>\\r\\nEditie:&nbsp;2017<\\/p><p>Opleidingsonderdeel:&nbsp;Ondernemen 3<\\/p><p>Kalender: Periode 1+2<\\/p><\\/div> <\\/p>\",\"B\"],[\"Afwezigen\",\"H\"],[\"Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D\",\"B\"],[\"Afwezige docenten\",\"H\"],[\"<p> <ul style=\'list-style-type: none; padding: 0\'><li>              Brys Ans <br \\/>              <small><strong>afwezig van<\\/strong> 7\\/12\\/2017 <strong>tot en met<\\/strong> 30\\/06\\/2018<\\/small>                      <\\/li><li>              De Boi ivan <br \\/>              <small><strong>afwezig van<\\/strong> 14\\/05\\/2018 <strong>tot en met<\\/strong> 29\\/06\\/2018<\\/small>                      <\\/li><li>              Soontjens Koen <br \\/>              <small><strong>afwezig van<\\/strong> 31\\/03\\/2018 <strong>tot en met<\\/strong> 30\\/06\\/2018<\\/small>                      <\\/li><\\/ul> <br><\\/p><p><\\/p><p class=\\\"sceditor-nlf\\\"><br><\\/p>\",\"B\"],[\"Medewerker\",\"H\"],[\"<p> <p>Oke! No hard feelings...Vanaf nu ben je aan het chatten met een medewerken van KdG. Stel je vragen maar! Om de sessie te bee\\u00efndigen kan je altijd \'Medewerker stop\' ingeven.<\\/p> <\\/p>\",\"B\"],[\"Hallo! Ik ben Karlo! Laatste jaars in de opleiding fotografie waarmee kan ik je helpen?\",\"B\"],[\"Ik heb een vraag over de opdracht van Mr. Vleugels. Heb jij misschien tips hoe ik deze het beste aanpak?\",\"H\"]]','2018-06-03 00:00:00','Alessandro','Aussems','alessandro.aussems@student.kdg.be','1C+btKT8IuMFjDIdwffXDw=='),('5b13c79797ba6','[[\"Hallo ik ben Karel! Stel je vragen maar! Weet je niet wat vragen? Dan kan je altijd \'Help\' typen!\",\"B\"]]','2018-06-03 00:00:00',NULL,NULL,NULL,NULL),('5b155b06b8143','[[\"Hallo ik ben Karel! Stel je vragen maar! Weet je niet wat vragen? Dan kan je altijd \'Help\' typen!\",\"B\"]]','2018-06-04 00:00:00',NULL,NULL,NULL,NULL),('5b165e4bce1f2','[[\"Hallo ik ben Karel! Stel je vragen maar! Weet je niet wat vragen? Dan kan je altijd \'Help\' typen!\",\"B\"]]','2018-06-05 00:00:00',NULL,NULL,NULL,NULL),('5b165e4d858c2','[[\"Hallo ik ben Karel! Stel je vragen maar! Weet je niet wat vragen? Dan kan je altijd \'Help\' typen!\",\"B\"],[\"lessen\",\"H\"],[\"<p> <p onclick=\'showLoginForm(this.event)\' style=\'cursor: pointer\'><strong>Log je in bij KdG<span style=\'font-family: icon; border: 1px solid white; margin-left: 1%; margin-right: 1%; padding: 1%\' onclick=\'showLoginForm(this.event)\'> h <\\/span> zodat ik deze informatie te weten kan komen!<\\/strong><\\/p> <\\/p>\",\"B\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"lessen\",\"H\"],[\"<p> Voor vandaag staat er niets gepland! Je kan gezellig thuis blijven! <\\/p>\",\"B\"],[\"Wie is Robbert Luit\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Robbert Luit is:<\\/p><br><img style=\'max-width: 150px;\' src=\'https:\\/\\/intranet.student.kdg.be:443\\/~\\/media\\/images\\/global\\/profile\\/profilepictures\\/stud\\/1\\/0\\/6\\/3\\/2\\/2\\/stud106322.jpeg?v=20140918T092113&mw=85&sc=1&bc=white\' alt=\'Robbert Luit\'><h5>Robbert Luit<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:robbert.luit@student.kdg.be\'>robbert.luit@student.kdg.be<\\/a> <\\/p>\",\"B\"],[\"Wie is Melis Pieter\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Melis Pieter is:<\\/p><br><img style=\'max-width: 150px;\' src=\'https:\\/\\/images.kdg.be\\/dcpprofilepictures\\/18f32482-99c2-4bc5-a742-9b0ffbb78fbb.jpg?v=20170915T010835\' alt=\'Melis Pieter\'><h5>Melis Pieter<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:melis.pieter@student.kdg.be\'>melis.pieter@student.kdg.be<\\/a> <\\/p>\",\"B\"],[\"Wie is Robbert Luit\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Robbert Luit is:<\\/p><br><img style=\'max-width: 150px;\' src=\'.\\/img\\/intranet\\/anonymous.png\' alt=\'Robbert Luit\'><h5>Robbert Luit<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:robbert.luit@student.kdg.be\'>robbert.luit@student.kdg.be<\\/a> <\\/p>\",\"B\"],[\"Wie is Robbert Luit\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Robbert Luit is:<\\/p><br><img style=\'max-width: 150px;\' src=\'.\\/img\\/intranet\\/anonymous.png\' alt=\'Robbert Luit\'><h5>Robbert Luit<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:robbert.luit@student.kdg.be\'>robbert.luit@student.kdg.be<\\/a> <\\/p>\",\"B\"],[\"Wie is Robbert Luit\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Robbert Luit is:<\\/p><br><img style=\'max-width: 150px;\' src=\'.\\/img\\/intranet\\/anonymous.png\' alt=\'Robbert Luit\'><h5>Robbert Luit<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:robbert.luit@student.kdg.be\'>robbert.luit@student.kdg.be<\\/a> <\\/p>\",\"B\"],[\"Wie is Robbert Luit\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Robbert Luit is:<\\/p><br><img style=\'max-width: 150px;\' src=\'\\/img\\/intranet\\/anonymous.png\' alt=\'Robbert Luit\'><h5>Robbert Luit<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:robbert.luit@student.kdg.be\'>robbert.luit@student.kdg.be<\\/a> <\\/p>\",\"B\"],[\"Wie is Robbert Luit\",\"H\"],[\"Wie is Robbert Luit\",\"H\"],[\"Wie is Robbert Luit\",\"H\"],[\"Wie is Robbert Luit\",\"H\"],[\"Wie is Robbert Luit\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Robbert Luit is:<\\/p><br><img style=\'max-width: 150px;\' src=\'\\/img\\/intranet\\/9d09e246a4de83447f97af788378e1e8a283d9b6e05c474bb4a4114871ffbfb3jpeg\' alt=\'Robbert Luit\'><h5>Robbert Luit<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:robbert.luit@student.kdg.be\'>robbert.luit@student.kdg.be<\\/a> <\\/p>\",\"B\"],[\"Wie is Robbert Luit\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Robbert Luit is:<\\/p><br><img style=\'max-width: 150px;\' src=\'\\/img\\/intranet\\/f7ce0dbb703d0d1503b9646206af1c3804fcea62d1d810b08ad4dc53f0f6a5b7.jpeg\' alt=\'Robbert Luit\'><h5>Robbert Luit<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:robbert.luit@student.kdg.be\'>robbert.luit@student.kdg.be<\\/a> <\\/p>\",\"B\"],[\"Wie is Adriaan Vermeire\",\"H\"],[\"<p> <p>Ik heb helaas niets gevonden met de zoekterm:  Adriaan Vermeire, het spijt me ten zeerste!<\\/p> <\\/p>\",\"B\"],[\"Wie is Pieter-Jan De Ridder\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Pieter-Jan De Ridder is:<\\/p><br><img style=\'max-width: 150px;\' src=\'\\/img\\/intranet\\/79dd41f302e7db37eb74a6e4957fdcb88f08bfc34e5fe71ce5a7192f9cd0cc43.jpeg\' alt=\'Pieter-Jan De Ridder\'><h5>Pieter-Jan De Ridder<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:pieterjan.deridder@student.kdg.be\'>pieterjan.deridder@student.kdg.be<\\/a> <\\/p>\",\"B\"],[\"Wie is Sam Serrien\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Sam Serrien is:<\\/p><br><img style=\'max-width: 150px;\' src=\'\\/img\\/intranet\\/53927689cd9d1413ae05688e912ea1d95a58f13a2167e035189b744b63d8a52f.jpeg\' alt=\'Sam Serrien\'><h5>Sam Serrien<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:sam.serrien@kdg.be\'>sam.serrien@kdg.be<\\/a> <\\/p>\",\"B\"],[\"wie is \",\"H\"],[\"<p> <p>Ik heb helaas niets gevonden met de zoekterm: wie is , het spijt me ten zeerste!<\\/p> <\\/p>\",\"B\"],[\"wie is Alessandro Aussems\",\"H\"],[\"Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D\",\"B\"],[\"wie is Alessandro Aussems\",\"H\"],[\"Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D\",\"B\"],[\"wie is Sam Serrien\",\"H\"],[\"Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D\",\"B\"],[\"Wie is Alessandro Aussems\",\"H\"],[\"<p> <p>Ik heb helaas niets gevonden met de zoekterm: Wie is Alessandro Aussems, het spijt me ten zeerste!<\\/p> <\\/p>\",\"B\"],[\"wie is Alessandro Aussems\",\"H\"],[\"Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D\",\"B\"],[\"Wie is Alessandro Aussems\",\"H\"],[\"<p> <p>Ik heb helaas niets gevonden met de zoekterm: Wie is Alessandro Aussems, het spijt me ten zeerste!<\\/p> <\\/p>\",\"B\"],[\"wie is Alessandro Aussems\",\"H\"],[\"Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D\",\"B\"],[\"Wie is Alessandro Aussems\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Alessandro Aussems is:<\\/p><br><img style=\'max-width: 150px;\' src=\'\\/img\\/intranet\\/b2b01dbe379ac922b50b697d167f7aa928086f90dcc43b359445e439b6e18a9e.jpeg\' alt=\'Alessandro Aussems\'><h5>Alessandro Aussems<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:alessandro.aussems@student.kdg.be\'>alessandro.aussems@student.kdg.be<\\/a> <\\/p>\",\"B\"],[\"wie is Alessandro Aussems\",\"H\"],[\"Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D\",\"B\"],[\"Wie is Robbert Luit\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Robbert Luit is:<\\/p><br><img style=\'max-width: 150px;\' src=\'\\/img\\/intranet\\/42654ca4f427bb04d198b651dbb17db454ff753c703609bdb4065a67662d4fc6.jpeg\' alt=\'Robbert Luit\'><h5>Robbert Luit<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:robbert.luit@student.kdg.be\'>robbert.luit@student.kdg.be<\\/a> <\\/p>\",\"B\"],[\"wie is Robbert Luit\",\"H\"],[\"Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D\",\"B\"],[\"wie is Robbert Luit\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Robbert Luit is:<\\/p><br><img style=\'max-width: 150px;\' src=\'\\/img\\/intranet\\/577d6e28c90aa5bdfff64add67c854fa6bfc8b044094397b2a850b75e66dd50c.jpeg\' alt=\'Robbert Luit\'><h5>Robbert Luit<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:robbert.luit@student.kdg.be\'>robbert.luit@student.kdg.be<\\/a> <\\/p>\",\"B\"],[\"Wie is Robbert Luit\",\"H\"],[\"<p> <p>Het beste resultaat dat ik kan vinden voor:  Robbert Luit is:<\\/p><br><img style=\'max-width: 150px;\' src=\'\\/img\\/intranet\\/4a3ab209a5ab6123549e93a1830fa0932f282e19706ad1250a2b67a0462404a7.jpeg\' alt=\'Robbert Luit\'><h5>Robbert Luit<\\/h5><p>Je kan deze persoon bereiken via email: <a href=\'mailto:robbert.luit@student.kdg.be\'>robbert.luit@student.kdg.be<\\/a> <\\/p>\",\"B\"]]','2018-06-05 00:00:00','Alessandro','Aussems','alessandro.aussems@student.kdg.be','1C+btKT8IuMFjDIdwffXDw==');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'MELDINGEN'),(2,'NAAM'),(3,'DAGMENU'),(4,'LESSEN'),(5,'AFWEZIGEN'),(6,'PRINTPRIJZEN'),(7,'PUNTEN'),(8,'PRIKBORD'),(9,'WIEISWIE'),(10,'MEDEWERKER'),(11,'CAMPUS'),(12,'LEERKREDIET'),(13,'BENODIGDHEDEN');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','alessandro.aussems@student.kdg.be','$2y$10$c6RomkNs7LqXZXew7YY49.nG/IkliJbhHwm7DeXwwdTtdxjx0rAeu','admin','M5UdsdLeE3QZWyNn8YLQ77dmwuIcFpFvnGBow7UugKxFrc8905w5ElnsCoMp',NULL,NULL),(3,'Chatter','chatter@karel-chatbot.be','$2y$10$mpTu2AZ9Sd8Zm0BT1l2n/OgdJmZ5x3hXRYyXONNzw4r6Jk0lYFJpK','chatter','HnCX87tqwYf7z1ftLaOUCyowHFD0vmywIQ6ucrIZGaN348aSrPBS2Jxzn7ht','2018-06-02 11:25:14','2018-06-02 11:25:14'),(4,'Editor','editor@karel-chatbot.be','$2y$10$2.utVV9bWe0YY5Yi44sbg.oI4HzONV0mvm8vNIUc3QcuHeaSPiWqG','editor','UxPnqXS2hDi87eevGc5oLQxdfqiTmc69N6qqm7FGc8qbaQet9bAOnSK3ad1t','2018-06-02 11:31:43','2018-06-02 11:31:43');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-05 16:54:35
