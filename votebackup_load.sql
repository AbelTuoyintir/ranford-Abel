-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: ucvote
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `candidate_coalitions`
--

DROP TABLE IF EXISTS `candidate_coalitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `candidate_coalitions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `election_coalition_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ballot_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ghana_card_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biography` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `portfolio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `votes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vote_status` enum('winner','loser') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidate_coalitions_election_coalition_id_foreign` (`election_coalition_id`),
  CONSTRAINT `candidate_coalitions_election_coalition_id_foreign` FOREIGN KEY (`election_coalition_id`) REFERENCES `election_coalitions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidate_coalitions`
--

LOCK TABLES `candidate_coalitions` WRITE;
/*!40000 ALTER TABLE `candidate_coalitions` DISABLE KEYS */;
/*!40000 ALTER TABLE `candidate_coalitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `candidates`
--

DROP TABLE IF EXISTS `candidates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `candidates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `poll_id` bigint unsigned NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hall` text COLLATE utf8mb4_unicode_ci,
  `ballot_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cgpa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ghana_card_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biography` text COLLATE utf8mb4_unicode_ci,
  `teaser` text COLLATE utf8mb4_unicode_ci,
  `team_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('candidate') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'candidate',
  `portfolio_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidates_poll_id_foreign` (`poll_id`),
  KEY `candidates_portfolio_id_foreign` (`portfolio_id`),
  CONSTRAINT `candidates_poll_id_foreign` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE,
  CONSTRAINT `candidates_portfolio_id_foreign` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidates`
--

LOCK TABLES `candidates` WRITE;
/*!40000 ALTER TABLE `candidates` DISABLE KEYS */;
INSERT INTO `candidates` VALUES (1,1,'KEKELI',NULL,'KPODOVIA','OGUAA','1','3.825','GHA-000000000-0','TEAM MOG','TEAM MOG','TEAM MOG','$2y$12$0nrYOccryRUhl/ECcmLtz.JgNjDAqqiDgqMyxx7/ahPN7kBlCYzbC','AR/CMS/22/0025','candidate',1,'candidates/B9byaXnJEJSADGkSqvH4RS10cxpA9Q4FLroSdds0.png','2025-07-19 22:43:19','2025-07-19 22:43:19'),(2,1,'SAMUEL',NULL,'ADAMS','OGUAA','2','2.765','GHA-000000000-0','TEAM ADAMS','TEAM ADAMS','TEAM ADAMS','$2y$12$mGhwzxjhtU.xJD8Wehebd.v4yDmq0iHP.R7QoYTd3cS1dmSUdo5ZC','AR/BAA/22/0040','candidate',1,'candidates/ZquAf6RahhTQxyFyyC12PcXPHidFCFMQrvfWz3Eu.jpg','2025-07-19 22:45:50','2025-07-19 22:45:50'),(3,1,'MATILDA',NULL,'QUAYE','ADEHYE','3','3.459','GHA-000000000-0','Team Tilly','Team Tilly','Team Tilly','$2y$12$/W4THI7CJdGPGBQgQZ/nGuKfy/sAirIOipg0sw/yW6hGF3qqHbYYe','AR/CMS/22/0056','candidate',1,'candidates/z86dyHG440Io9pHutJhfz2lqOwhPW7c89itTUcaZ.jpg','2025-07-19 22:57:41','2025-07-19 22:57:41'),(4,1,'RAHAMA',NULL,'YAKUBU','SRC','1','2.738','GHA-000000000-0','Nasara','Nasara','Nasara','$2y$12$LPgO/idZ/uhosty8CwtYTO3LGcv6AHGbIsPLrYURl8pGpvtImKMA.','AR/CMS/22/0136','candidate',2,'candidates/rckB7qzzvcXohNMmbYNtsNS2UEttm1DhWfA2CGeb.png','2025-07-19 23:13:06','2025-07-19 23:13:06'),(5,1,'BENEDICTA',NULL,'ACQUAH','OGUAA','1','3.513','GHA-000000000-0','MISS BAE','MISS BAE','MISS BAE','$2y$12$wmBKPB5Ghu8h0oNTcfn6teVmEco.tlo0Cc87oxw/UHRWTAHhozrDi','AR/CMS/23/0140','candidate',3,'candidates/PqNTRyNFhJha2BmVeMBKl5eK0Ee23X22AMChEExO.jpg','2025-07-19 23:15:23','2025-07-19 23:15:23'),(6,1,'ABITO',NULL,'MARTIN','KNHALL','1','3.425','GHA-000000000-0','Martin','Martin','Martin','$2y$12$gr96VUH3ap5u7yk7OiTCMuOWmdFNm6CjGz/3DWbtCTc5uN6a7Buya','AR/CMS/23/0084','candidate',4,'candidates/W0E4dblQTI7yHN7bmYSviTgV6ozt3N4dXsmLlC2W.jpg','2025-07-19 23:18:25','2025-07-19 23:18:25'),(7,1,'ELSIE',NULL,'DADZIE','VALCO','1','2.816','GHA-000000000-0','Miss Elsy','Miss Elsy','Miss Elsy','$2y$12$3KvGKz/Ka3lPo3PiJiXRtuVxflDXstY2Dga5NMsKr3dSO200dEGFq','AR/CMS/23/0185','candidate',5,'candidates/IKeIpj5SY2GNAF2jwmxZtv07Te2aNK3p6gZz3K7K.jpg','2025-07-19 23:19:46','2025-07-19 23:19:46');
/*!40000 ALTER TABLE `candidates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nominee_id` bigint unsigned NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('cgpa','fee_receipt','cv','medical_report','passport_photo') COLLATE utf8mb4_unicode_ci NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_nominee_id_foreign` (`nominee_id`),
  CONSTRAINT `documents_nominee_id_foreign` FOREIGN KEY (`nominee_id`) REFERENCES `nominees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `election_coalitions`
--

DROP TABLE IF EXISTS `election_coalitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `election_coalitions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `start_date` date NOT NULL,
  `all_portfolios` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_time` time DEFAULT NULL,
  `status` enum('active','inactive','complete') COLLATE utf8mb4_unicode_ci NOT NULL,
  `poll_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `querystring` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `votes_received` int NOT NULL DEFAULT '0',
  `skipped_votes_breakdown` json DEFAULT NULL,
  `votes_skipped` int NOT NULL DEFAULT '0',
  `total_voters` int NOT NULL DEFAULT '0',
  `voters` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `election_coalitions`
--

LOCK TABLES `election_coalitions` WRITE;
/*!40000 ALTER TABLE `election_coalitions` DISABLE KEYS */;
/*!40000 ALTER TABLE `election_coalitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ip_addresses`
--

DROP TABLE IF EXISTS `ip_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ip_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `last_active` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip_addresses_address_unique` (`address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ip_addresses`
--

LOCK TABLES `ip_addresses` WRITE;
/*!40000 ALTER TABLE `ip_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `ip_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_11_17_040307_create_portfolios_table',1),(5,'2024_11_17_100228_create_polls_table',1),(6,'2024_11_25_155519_create_candidate_table',1),(7,'2024_12_27_233523_create_user_activities_table',1),(8,'2024_12_30_105444_create_votes_table',1),(9,'2024_12_30_110839_create_poll_settings_table',1),(10,'2025_03_10_213548_create_settings_table',1),(11,'2025_03_10_225624_create_election_coalitions_table',1),(12,'2025_03_10_225714_create_candidate_coalitions_table',1),(13,'2025_03_13_214648_create_ip_addresses_table',1),(14,'2025_03_18_191814_create_route_maps_table',1),(15,'2025_04_03_143817_create_nominees__table',1),(16,'2025_04_04_152950_create_tickets_table',1),(17,'2025_04_09_160746_create_supporters_table',1),(18,'2025_04_09_160817_create_documents_table',1),(19,'2025_04_09_165319_create_running_mates_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nominees`
--

DROP TABLE IF EXISTS `nominees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nominees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hall` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `program` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominee_cgpa` decimal(5,2) NOT NULL,
  `medical_clearance` tinyint(1) DEFAULT '0',
  `fee_paid` tinyint(1) DEFAULT '0',
  `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) DEFAULT '0',
  `role` enum('applicant','nominee','aspirant','candidate') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nominee',
  `status` enum('draft','submitted','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nominees_reg_number_unique` (`reg_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nominees`
--

LOCK TABLES `nominees` WRITE;
/*!40000 ALTER TABLE `nominees` DISABLE KEYS */;
/*!40000 ALTER TABLE `nominees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poll_settings`
--

DROP TABLE IF EXISTS `poll_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `poll_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `poll_id` bigint unsigned NOT NULL,
  `querystring` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash_voter_names_numbers` tinyint(1) NOT NULL DEFAULT '0',
  `hash_voter_names_Alphabet` tinyint(1) NOT NULL DEFAULT '1',
  `show_teaser` tinyint(1) NOT NULL DEFAULT '0',
  `hide_profile_pictures` tinyint(1) NOT NULL DEFAULT '1',
  `anonymous_voting` tinyint(1) NOT NULL DEFAULT '1',
  `all_portfolios` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `show_candidate_cgpa` tinyint(1) NOT NULL DEFAULT '0',
  `display_ballot_numbers` tinyint(1) NOT NULL DEFAULT '1',
  `allow_candidate_biographies` tinyint(1) NOT NULL DEFAULT '0',
  `show_live_results` tinyint(1) NOT NULL DEFAULT '1',
  `display_vote_counts` tinyint(1) NOT NULL DEFAULT '0',
  `show_percentage_results` tinyint(1) NOT NULL DEFAULT '0',
  `send_result_slips` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `poll_settings_poll_id_foreign` (`poll_id`),
  CONSTRAINT `poll_settings_poll_id_foreign` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poll_settings`
--

LOCK TABLES `poll_settings` WRITE;
/*!40000 ALTER TABLE `poll_settings` DISABLE KEYS */;
INSERT INTO `poll_settings` VALUES (1,'2025-07-19 21:47:31','2025-07-19 21:47:31',1,'DEPARTMENT',0,1,0,1,1,'[\"DEPARTMENT FASA PRESIDENT\",\"DEPARTMENT FASA SECRETARY\",\"DEPARTMENT FASA TREASURER\",\"DEPARTMENT FASA PUBLIC RELATION OFFICER\",\"DEPARTMENT FASA WOMEN\'S COMMISSIONER\"]',0,1,0,1,0,0,1);
/*!40000 ALTER TABLE `poll_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `polls`
--

DROP TABLE IF EXISTS `polls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `polls` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time DEFAULT NULL,
  `start_date` date NOT NULL,
  `status` enum('active','inactive','complete') COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poll_type` enum('UCC GENERAL VOTING','DEPARTMENT','HALL','SPECIAL VOTING') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `polls`
--

LOCK TABLES `polls` WRITE;
/*!40000 ALTER TABLE `polls` DISABLE KEYS */;
INSERT INTO `polls` VALUES (1,'FACULTY OF ART STUDENT ASSOCIATION ELECTION 2025','THIS ELECTION IS FOR FACULTY OF ART STUDENTS ONLY.','08:00:00','18:00:00','2025-07-22','inactive','default_image/department.jpg','DEPARTMENT','2025-07-19 21:47:15','2025-07-19 21:47:15');
/*!40000 ALTER TABLE `polls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolios`
--

DROP TABLE IF EXISTS `portfolios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `portfolios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `portfolios_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolios`
--

LOCK TABLES `portfolios` WRITE;
/*!40000 ALTER TABLE `portfolios` DISABLE KEYS */;
INSERT INTO `portfolios` VALUES (1,'DEPARTMENT FASA PRESIDENT','FASA PRESIDENT','DEPARTMENT','2025-07-19 21:41:55','2025-07-19 21:41:55'),(2,'DEPARTMENT FASA SECRETARY','FASA SECRETARY','DEPARTMENT','2025-07-19 21:42:18','2025-07-19 21:42:18'),(3,'DEPARTMENT FASA TREASURER','FASA TREASURER','DEPARTMENT','2025-07-19 21:42:45','2025-07-19 21:42:45'),(4,'DEPARTMENT FASA PUBLIC RELATION OFFICER','FASA P.R.O','DEPARTMENT','2025-07-19 21:43:31','2025-07-19 21:43:31'),(5,'DEPARTMENT FASA WOMEN\'S COMMISSIONER','FASA WOCOM','DEPARTMENT','2025-07-19 21:44:20','2025-07-19 21:44:20');
/*!40000 ALTER TABLE `portfolios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `route_maps`
--

DROP TABLE IF EXISTS `route_maps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `route_maps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the route mappings table.',
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Unique UUID for the obfuscated route.',
  `actual_route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The actual route being obfuscated.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `route_maps_uuid_unique` (`uuid`),
  KEY `route_maps_actual_route_index` (`actual_route`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores mappings between UUIDs and actual routes for obfuscated URLs.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `route_maps`
--

LOCK TABLES `route_maps` WRITE;
/*!40000 ALTER TABLE `route_maps` DISABLE KEYS */;
INSERT INTO `route_maps` VALUES (1,'55528e9a-8530-4a00-8e94-b8f7b3168a15','dashboard','2025-07-19 21:27:59','2025-07-19 21:27:59'),(2,'b1de30e7-3096-4611-9709-77d10b401bf7','manageMembers','2025-07-19 21:27:59','2025-07-19 21:27:59'),(3,'f0549242-c2af-49d2-ae7e-14596711a5ac','strong-room','2025-07-19 21:27:59','2025-07-19 21:27:59'),(4,'b5f12036-9136-4a15-9d4e-9f01b4557e6a','portfolios','2025-07-19 21:27:59','2025-07-19 21:27:59'),(5,'915f5daf-016b-48f8-9438-82cb54d66b68','generate-voucher','2025-07-19 21:27:59','2025-07-19 21:27:59'),(6,'b329b1e3-10da-4874-8681-7749c28d4812','nomination-management','2025-07-19 21:27:59','2025-07-19 21:27:59'),(7,'df159262-aee5-476d-90c0-adf957762267','create-poll','2025-07-19 21:27:59','2025-07-19 21:27:59'),(8,'74a23ecf-9197-4ccb-b803-0b6fcdccebfd','analysis','2025-07-19 21:27:59','2025-07-19 21:27:59'),(9,'ce114005-938a-479b-9083-677f2975024c','verification','2025-07-19 21:27:59','2025-07-19 21:27:59'),(10,'47f48cc4-7d0b-47a0-8657-3438a048c82a','automatic-verification','2025-07-19 21:27:59','2025-07-19 21:27:59'),(11,'bafb0561-2f33-44e3-a14c-cfe0adb88de1','update-email','2025-07-19 21:27:59','2025-07-19 21:27:59'),(12,'1fb28fea-38f4-41d1-be1c-9f60da94c650','ipblocker','2025-07-19 21:27:59','2025-07-19 21:27:59'),(13,'27ffec7f-58fc-43c8-8a54-b9f6ad671e35','database','2025-07-19 21:27:59','2025-07-19 21:27:59'),(14,'29f0ac38-2b40-474e-b4d1-15f37c0f8d76','election-coalition','2025-07-19 21:27:59','2025-07-19 21:27:59'),(15,'8ddb90f4-7ebd-48f2-8302-167d5aaf7f5b','log','2025-07-19 21:27:59','2025-07-19 21:27:59'),(16,'2e976bb5-c401-49fb-b0b8-e0b77dd3c24a','details','2025-07-19 21:27:59','2025-07-19 21:27:59'),(17,'14ea2534-22e7-43a2-a9bc-0ceb7e1c034a','overview','2025-07-19 21:27:59','2025-07-19 21:27:59'),(18,'721e618c-82b0-4e5c-91bc-475d260493c2','advance-settings','2025-07-19 21:27:59','2025-07-19 21:27:59'),(19,'7a0a0bc3-89b1-4700-8834-12c6acae30ff','update/profile','2025-07-19 21:27:59','2025-07-19 21:27:59');
/*!40000 ALTER TABLE `route_maps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `running_mates`
--

DROP TABLE IF EXISTS `running_mates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `running_mates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nominee_id` bigint unsigned NOT NULL,
  `running_mates_full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `running_mates_cgpa` decimal(5,2) NOT NULL,
  `running_mates_reg_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `running_mates_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `running_mates_hall` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `running_mates_program` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `running_mates_photo_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `running_mates_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `running_mates_nominee_id_unique` (`nominee_id`),
  UNIQUE KEY `running_mates_running_mates_reg_number_unique` (`running_mates_reg_number`),
  CONSTRAINT `running_mates_nominee_id_foreign` FOREIGN KEY (`nominee_id`) REFERENCES `nominees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `running_mates`
--

LOCK TABLES `running_mates` WRITE;
/*!40000 ALTER TABLE `running_mates` DISABLE KEYS */;
/*!40000 ALTER TABLE `running_mates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_foreign` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`),
  CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('5Uk8IDHepJQFNAxpyANlgeznfS15hxNVbTvQV4Zv',NULL,'10.10.22.18','Mozilla/5.0 (iPhone; CPU iPhone OS 16_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/136.0.7103.91 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTDQzZ25oUDdTQk9ncGFvaWlKWFZVSjB5aENiY2tZUm1RUHFuSWhubyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vdm90ZS51Y2MuZWR1LmdoL3ZvdGVycy1yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','inactive',1753039634),('bOQbUIq3kxL6C5ZrZbPSImOX8RZHBTUUk6HQUOMB',NULL,'10.10.22.93','Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVDRzWGFEcXJReXNXQXpyUjUyZFZHa3Jyc2JSemR6NVF6UVBWSUhidCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vdm90ZS51Y2MuZWR1LmdoL3ZvdGVycy1yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','inactive',1753039827),('qsEaSkHNLtI4LjQyRyUjNzVHjXUyUYrkvgrmdXRo',11,'10.10.22.18','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:140.0) Gecko/20100101 Firefox/140.0','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiWlFYVjRpWFVEODJ6c2hZWlR6YzdNdkRDWjI0a2F1MUZjMUR4ZmsydCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMjoiaHR0cHM6Ly92b3RlLnVjYy5lZHUuZ2gvYW5hbHlzaXMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMjoiaHR0cHM6Ly92b3RlLnVjYy5lZHUuZ2gvZGF0YWJhc2UiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMTtzOjc6InVzZXJfaWQiO2k6MTE7fQ==','active',1753039367);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_network_restriction` tinyint(1) NOT NULL DEFAULT '0',
  `normal_mode` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supporters`
--

DROP TABLE IF EXISTS `supporters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supporters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nominee_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hall` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `program` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `id_copy_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `confirmation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supporters_nominee_id_foreign` (`nominee_id`),
  CONSTRAINT `supporters_nominee_id_foreign` FOREIGN KEY (`nominee_id`) REFERENCES `nominees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supporters`
--

LOCK TABLES `supporters` WRITE;
/*!40000 ALTER TABLE `supporters` DISABLE KEYS */;
/*!40000 ALTER TABLE `supporters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Voucher` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_activities`
--

DROP TABLE IF EXISTS `user_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_activities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `school_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_activities_user_id_foreign` (`user_id`),
  CONSTRAINT `user_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_activities`
--

LOCK TABLES `user_activities` WRITE;
/*!40000 ALTER TABLE `user_activities` DISABLE KEYS */;
INSERT INTO `user_activities` VALUES (1,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','login','User logged in successfully','2025-07-19 21:26:14','2025-07-19 21:26:14'),(2,11,'15657','B2MXnfbVSmGaIqMBUgujI8ZNO2TTOaG6BWLDmbvT','login','User logged in successfully','2025-07-19 21:26:17','2025-07-19 21:26:17'),(3,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','Portfolios','DEPARTMENT FASA PRESIDENTportfolio created  successfully!','2025-07-19 21:41:55','2025-07-19 21:41:55'),(4,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','Portfolios','DEPARTMENT FASA SECRETARYportfolio created  successfully!','2025-07-19 21:42:18','2025-07-19 21:42:18'),(5,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','Portfolios','DEPARTMENT FASA TREASURERportfolio created  successfully!','2025-07-19 21:42:45','2025-07-19 21:42:45'),(6,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','Portfolios','DEPARTMENT FASA PUBLIC RELATION OFFICERportfolio created  successfully!','2025-07-19 21:43:31','2025-07-19 21:43:31'),(7,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','Portfolios','DEPARTMENT FASA WOMEN\'S COMMISSIONERportfolio created  successfully!','2025-07-19 21:44:20','2025-07-19 21:44:20'),(8,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','Poll creation','User created a poll successfully!','2025-07-19 21:47:15','2025-07-19 21:47:15'),(9,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','Portfolios','MS.NANCY OBIKYEREportfolio submitted  successfully!','2025-07-19 21:47:31','2025-07-19 21:47:31'),(10,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','candidates','MS.NANCY OBIKYERE added KEKELI  KPODOVIA added successfully!','2025-07-19 22:43:19','2025-07-19 22:43:19'),(11,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','candidates','MS.NANCY OBIKYERE added SAMUEL  ADAMS added successfully!','2025-07-19 22:45:50','2025-07-19 22:45:50'),(12,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','candidates','MS.NANCY OBIKYERE added MATILDA  QUAYE added successfully!','2025-07-19 22:57:41','2025-07-19 22:57:41'),(13,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','candidates','MS.NANCY OBIKYERE added RAHAMA  YAKUBU added successfully!','2025-07-19 23:13:06','2025-07-19 23:13:06'),(14,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','candidates','MS.NANCY OBIKYERE added BENEDICTA  ACQUAH added successfully!','2025-07-19 23:15:23','2025-07-19 23:15:23'),(15,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','candidates','MS.NANCY OBIKYERE added ABITO  MARTIN added successfully!','2025-07-19 23:18:25','2025-07-19 23:18:25'),(16,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','candidates','MS.NANCY OBIKYERE added ELSIE  DADZIE added successfully!','2025-07-19 23:19:46','2025-07-19 23:19:46'),(17,11,'15657','JKtyw1P8pd3adO1KpLGYt4yrKgv8T4NZO0PL3foF','logout','User logged out','2025-07-19 23:20:16','2025-07-19 23:20:16'),(18,11,'15657','DAz3zT4BlRX8PLMKU4IsNb6cMEPXgMmQZtmOIr0w','failed','User logged out due to unrecognized role','2025-07-20 19:21:30','2025-07-20 19:21:30'),(19,11,'15657','qsEaSkHNLtI4LjQyRyUjNzVHjXUyUYrkvgrmdXRo','login','User logged in successfully','2025-07-20 19:22:02','2025-07-20 19:22:02');
/*!40000 ALTER TABLE `user_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middleName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Programs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hall` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `broadcast_status` enum('pending','sent','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `email_verification_expires_at` timestamp NULL DEFAULT NULL,
  `DOB` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','moderator','super_moderator','voter','verification_officer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'voter',
  `type` enum('student','staff') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` enum('voted','verified','unverified') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2349 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'MR.ALBERT','K.','BAIDOO','12094',NULL,'SRC','cdn.ucc.edu.gh/photos/?tag=12094','srchall@ucc.edu.gh','2025-07-19 21:25:05','$2y$12$9sMJHhkphKppKEl/JUsaT.ZRcIFnvGs75EfQyf9GPwuhjewbvZLca',NULL,'pending',NULL,NULL,'M',NULL,NULL,'udC4UYuDpG','admin',NULL,NULL,'2025-07-19 21:25:06','2025-07-19 21:25:06'),(2,'MR.RAYMOND',NULL,'BENTIL','8713',NULL,'CASFORD','cdn.ucc.edu.gh/photos/?tag=8713','casely.hayfordhall@ucc.edu.gh','2025-07-19 21:25:06','$2y$12$D4DFFV6o7UYVrKooFsdIsOjIDp9Mn7S79ksXV1O3Px2N4bM9c4OBO',NULL,'pending',NULL,NULL,'M',NULL,NULL,'2yLKcNpq6s','admin',NULL,NULL,'2025-07-19 21:25:06','2025-07-19 21:25:06'),(3,'MS.SARAH','R.','ADDAI-BUOBU','11900',NULL,'GUSSS','cdn.ucc.edu.gh/photos/?tag=11900','superannuationh@ucc.edu.gh','2025-07-19 21:25:06','$2y$12$dhxQkVe7d2gA4jG7yuuuBeNy6gTyzH8PASmYw/9pzJPtovbmF4yWm',NULL,'pending',NULL,NULL,'F',NULL,NULL,'YqPbalDG52','admin',NULL,NULL,'2025-07-19 21:25:06','2025-07-19 21:25:06'),(4,'MS.PATIENCE',NULL,'ADJABENG','16407',NULL,'ATLANTIC','cdn.ucc.edu.gh/photos/?tag=16407','atl.hall@ucc.edu.gh','2025-07-19 21:25:07','$2y$12$qX0D4sH09HSOPpET6px/IOrg.mf1Z9R6bUhI.F8K9UUisGv43DuZe',NULL,'pending',NULL,NULL,'F',NULL,NULL,'Z6kgr83nMT','admin',NULL,NULL,'2025-07-19 21:25:07','2025-07-19 21:25:07'),(5,'MR.STEPHEN','E.','ESSEL','15416',NULL,'KNHALL','cdn.ucc.edu.gh/photos/?tag=15416','manageress.knh@ucc.edu.gh','2025-07-19 21:25:07','$2y$12$xWFi6RinALKfcRHRN9Zi3Oz3qxow5BSGEiUZjM/3jcBg4Ej4a4GCa',NULL,'pending',NULL,NULL,'M',NULL,NULL,'T6iKirp7wn','admin',NULL,NULL,'2025-07-19 21:25:07','2025-07-19 21:25:07'),(6,'MR.GODWIN','K.','YAWOTSE','12117',NULL,'VALCO','cdn.ucc.edu.gh/photos/?tag=12117','valco.hall@ucc.edu.gh','2025-07-19 21:25:07','$2y$12$d/bZLjAh8toaxF/Gzsmaduw1wc.mOPokzKk302lAB58zeI1lXUPkS',NULL,'pending',NULL,NULL,'M',NULL,NULL,'5L6LB6JUrO','admin',NULL,NULL,'2025-07-19 21:25:07','2025-07-19 21:25:07'),(7,'MS.REGINA',NULL,'OBENG','10535',NULL,'ADEHYE','cdn.ucc.edu.gh/photos/?tag=10535','adehyehall@ucc.edu.gh','2025-07-19 21:25:08','$2y$12$ljlO7.cRihdh87la5jRASezpATlOBQtjXmpcDqNG9A3UZwx8cYGBe',NULL,'pending',NULL,NULL,'F',NULL,NULL,'vsj9MHBCCo','admin',NULL,NULL,'2025-07-19 21:25:08','2025-07-19 21:25:08'),(8,'MR.MICHEAL','A.','MINNAH','14860',NULL,'VTRUST','cdn.ucc.edu.gh/photos/?tag=14860','valcotrust.hall@ucc.edu.gh','2025-07-19 21:25:08','$2y$12$TnBlFaacXEYDPHvzUtQKK.dhyne.Ae5QoE/z4XhhydIf9frD/4esq',NULL,'pending',NULL,NULL,'M',NULL,NULL,'R9M6vjNzvk','admin',NULL,NULL,'2025-07-19 21:25:08','2025-07-19 21:25:08'),(9,'MS.BERTHA',NULL,'AFREH','13752',NULL,'OGUAA','cdn.ucc.edu.gh/photos/?tag=13752','oguaahall@ucc.edu.gh','2025-07-19 21:25:08','$2y$12$F.kzNO9DRkwqujuhjJ8cmeMYTd1.4yTyNXBhcNw55uSyntif9U1NS',NULL,'pending',NULL,NULL,'F',NULL,NULL,'HGInHspTNS','admin',NULL,NULL,'2025-07-19 21:25:08','2025-07-19 21:25:08'),(10,'MR.JOHN','KOJO','SAM','1191',NULL,'UHALL','cdn.ucc.edu.gh/photos/?tag=1191','uhms.office@ucc.edu.gh','2025-07-19 21:25:09','$2y$12$XlSzitv4p.eTZuW5m0IZweuCODmbU3oANOX9HBR9v6bLqQ.WsWdpi',NULL,'pending',NULL,NULL,'M',NULL,NULL,'fY8oU1Xf5c','admin',NULL,NULL,'2025-07-19 21:25:09','2025-07-19 21:25:09'),(11,'MS.NANCY',NULL,'OBIKYERE','15657',NULL,NULL,'cdn.ucc.edu.gh/photos/?tag=15657','superannuationh@ucc.edu.gh','2025-07-19 21:25:09','$2y$12$ss6v8dO5ZDm8SHI4lYan.exL8qIk1.sVPap1KFxWuvEgb.f.lQsfO',NULL,'pending',NULL,NULL,'F',NULL,NULL,'YM2MAyhGFLtdmSvLSoSu1ClsUSqb9upcsxPcCBxh5fh5VTppPfJYOnH8ngaC','admin',NULL,NULL,'2025-07-19 21:25:09','2025-07-19 21:25:09');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `poll_id` bigint unsigned NOT NULL,
  `candidate_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `poll_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `votes` int NOT NULL,
  `votes_status` enum('voted','skipped') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `votes_poll_id_user_id_candidate_id_unique` (`poll_id`,`user_id`,`candidate_id`),
  KEY `votes_candidate_id_foreign` (`candidate_id`),
  KEY `votes_user_id_foreign` (`user_id`),
  CONSTRAINT `votes_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`),
  CONSTRAINT `votes_poll_id_foreign` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE,
  CONSTRAINT `votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votes`
--

LOCK TABLES `votes` WRITE;
/*!40000 ALTER TABLE `votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `votes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-20 19:33:45
