-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2018 at 08:33 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db.video`
--

-- --------------------------------------------------------

--
-- Table structure for table `casino_alexavegas_categories`
--

CREATE TABLE `casino_alexavegas_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `casino_alexavegas_categories`
--

INSERT INTO `casino_alexavegas_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'category_12', 'category-1', '2018-08-16 07:03:57', '2018-08-16 07:53:21'),
(2, 'category_2', 'category-2', '2018-08-16 07:04:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `casino_alexavegas_videos`
--

CREATE TABLE `casino_alexavegas_videos` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `youtube_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnails` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `viewCount` bigint(20) NOT NULL,
  `likeCount` bigint(20) NOT NULL,
  `dislikeCount` bigint(20) NOT NULL,
  `commentCount` bigint(20) NOT NULL,
  `favoriteCount` bigint(20) NOT NULL,
  `author` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `published_at` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'casino', '2018-01-25 03:52:59', '2018-01-25 03:52:59'),
(2, 'multiplayer', '2018-01-25 03:52:59', '2018-01-25 03:52:59'),
(3, 'sports', '2018-01-25 03:52:59', '2018-01-25 03:52:59'),
(4, 'toto', '2018-01-25 03:52:59', '2018-01-25 03:52:59');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(10) NOT NULL,
  `division_id` int(11) NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `division_id`, `name`, `url`, `created_at`, `updated_at`) VALUES
(1, 3, 'dewabet', 'http://example.com', '2018-04-25 05:19:19', '2018-04-25 06:23:50'),
(2, 4, 'bolagila', 'http://example.com', '2018-08-13 04:31:59', '2018-08-13 04:31:59'),
(3, 1, 'alexavegas', 'http://example.com', '2018-08-15 02:40:31', '2018-08-15 02:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sports_dewabet_categories`
--

CREATE TABLE `sports_dewabet_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sports_dewabet_categories`
--

INSERT INTO `sports_dewabet_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'category_1', 'slug-1', '2018-04-25 05:19:28', NULL),
(2, 'category_2', 'slug-2', '2018-04-25 05:19:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sports_dewabet_videos`
--

CREATE TABLE `sports_dewabet_videos` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `youtube_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnails` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `viewCount` bigint(20) NOT NULL,
  `likeCount` bigint(20) NOT NULL,
  `dislikeCount` bigint(20) NOT NULL,
  `commentCount` bigint(20) NOT NULL,
  `favoriteCount` bigint(20) NOT NULL,
  `author` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `published_at` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sports_dewabet_videos`
--

INSERT INTO `sports_dewabet_videos` (`id`, `category_id`, `youtube_id`, `title`, `slug`, `description`, `thumbnails`, `duration`, `viewCount`, `likeCount`, `dislikeCount`, `commentCount`, `favoriteCount`, `author`, `status`, `published_at`, `created_at`, `updated_at`) VALUES
(1, '[\"1\",\"2\"]', 'lp-EO5I60KA', 'Ed Sheeran - Thinking Out Loud [Official Video]', 'ed-sheeran-thinking-out-loud-official-video', 'The official video for \'Thinking Out Loud\', Ed learnt to dance! \r\n\'x\', available to buy via iTunes here: http://smarturl.it/x-itunesdlx\r\nFeaturing and taught by @dance10Brittany and @dance10Paul\r\n\r\nSubscribe to my channel: http://bit.ly/SubscribeToEdSheeran\r\nGo behind the scenes of the video: http://bit.ly/ThinkingOutLoudBTS\r\nHear the rest of my album, \'x\': http://bit.ly/XOfficialPlaylist\r\nAudio of \'Thinking Out Loud\': http://youtu.be/WpyfrixXBqU\r\n\r\nHey German fans! View here: http://smarturl.it/ThinkingOutLoud-DE\r\n\r\nBuy on CD & Vinyl here: http://smarturl.it/x-album\r\nBuy on Google Play: http://smarturl.it/x-googleplaydlx\r\n\r\nFollow me on...\r\nFacebook: http://www.facebook.com/EdSheeranMusic\r\nTwitter: http://twitter.com/edsheeran\r\nInstagram: http://instagram.com/teddysphotos\r\nOfficial Website: http://edsheeran.com\r\n\r\n** The best artists, the best albums, the best price **\r\nGet the FREE app now & be the first to discover TOP MUSIC DEALS\r\nhttp://Smarturl.it/top-music-deal', '{\"default\":\"https://i.ytimg.com/vi/lp-EO5I60KA/default.jpg\",\"medium\":\"https://i.ytimg.com/vi/lp-EO5I60KA/mqdefault.jpg\",\"high\":\"https://i.ytimg.com/vi/lp-EO5I60KA/hqdefault.jpg\",\"standard\":\"https://i.ytimg.com/vi/lp-EO5I60KA/sddefault.jpg\",\"maxres\":\"https://i.ytimg.com/vi/lp-EO5I60KA/maxresdefault.jpg\"}', 'PT4M57S', 2255557263, 8411034, 375431, 254580, 0, 'Julien Renvoye', 3, '2014-10-07T13:57:37.000Z', '2018-04-26 07:43:53', NULL),
(2, '[\"1\"]', 'nSDgHBxUbVQ', 'Ed Sheeran - Photograph (Official Music Video)', 'ed-sheeran-photograph-official-music-video', 'Download on iTunes: http://smarturl.it/x-itunesdlx\r\nListen on Spotify: http://smarturl.it/stream.photograph\r\nDirected by Emil Nava\r\n\r\nSubscribe to Ed\'s channel: http://bit.ly/SubscribeToEdSheeran\r\n\r\nFollow Ed on...\r\nFacebook: http://www.facebook.com/EdSheeranMusic\r\nTwitter: http://twitter.com/edsheeran\r\nInstagram: http://instagram.com/teddysphotos\r\nOfficial Website: http://edsheeran.com\r\n\r\n** The best artists, the best albums, the best price **\r\nGet the FREE app now & be the first to discover TOP MUSIC DEALS\r\nhttp://Smarturl.it/top-music-deal', '{\"default\":\"https://i.ytimg.com/vi/nSDgHBxUbVQ/default.jpg\",\"medium\":\"https://i.ytimg.com/vi/nSDgHBxUbVQ/mqdefault.jpg\",\"high\":\"https://i.ytimg.com/vi/nSDgHBxUbVQ/hqdefault.jpg\",\"standard\":\"https://i.ytimg.com/vi/nSDgHBxUbVQ/sddefault.jpg\"}', 'PT4M35S', 610487124, 3373791, 89080, 122320, 0, 'Julien Renvoye', 1, '2015-05-10T00:40:11.000Z', '2018-04-26 07:44:11', NULL),
(3, '[\"1\"]', 'K0ibBPhiaG0', 'Ed Sheeran - Castle On The Hill [Official Video]', 'ed-sheeran-castle-on-the-hill-official-video', 'Stream or Download Castle On The Hill: https://atlanti.cr/2singles\r\n÷. Out Now: https://atlanti.cr/yt-album\r\nSubscribe to Ed\'s channel: http://bit.ly/SubscribeToEdSheeran\r\n\r\nFollow Ed on...\r\nFacebook: http://www.facebook.com/EdSheeranMusic\r\nTwitter: http://twitter.com/edsheeran\r\nInstagram: http://instagram.com/teddysphotos\r\nOfficial Website: http://edsheeran.com\r\n\r\nDirector: George Belfield\r\nProducer: Tom Gardner\r\nDOP: Steve Annis\r\nCommissioner: Dan Curwin\r\nProduction Company: Somesuch\r\nExec Producer: Hannah Turnbull-Walter\r\n\r\n-- | LYRICS |--\r\n\r\nWhen I was six years old I broke my leg\r\nI was running from my brother and his friends\r\ntasted the sweet perfume of the mountain grass I rolled down\r\nI was younger then, take me back to when I \r\nFound my heart and broke it here, made friends and lost them through the years\r\nAnd I’ve not seen the roaring fields in so long, I know, I’ve grown \r\nbut I can’t wait to go home \r\n\r\nI’m on my way, driving at 90 down those country lanes\r\nSinging to Tiny Dancer, And I miss the way you make me feel, and it’s real\r\nWhen we watched the sunset over the castle on the hill\r\n\r\nFifteen years old and smoking hand rolled cigarettes\r\nRunning from the law through the backfields and getting drunk with my friends \r\nHad my first kiss on a Friday night, I don’t reckon I did it right\r\nI was younger then, take me back to when we found\r\nWeekend jobs when we got paid and buy cheap spirits and drink them straight \r\nMe and my friends have not thrown up in so long, oh how we’ve grown\r\nI can’t wait to go home\r\n\r\nI’m on my way, driving at 90 down those country lanes\r\nSinging to Tiny Dancer, And I miss the way you make me feel, it’s real\r\nWhen we watched the sunset over the castle on the hill\r\nOver the castle on the hill\r\nOver the castle on the hill\r\nOver the castle on the hill\r\n\r\nOne friend left to sell clothes\r\nOne works down by the coast \r\nOne had two kids but lives alone\r\nOne’s brother overdosed\r\nOnes already on his second wife\r\nOnes just barely getting by\r\nBut these people raised me\r\nAnd I can’t wait to go home\r\n\r\nAnd I’m on my way, and I still remember those country lanes\r\nWhen we did not know the answers, And I miss the way you make me feel, it’s real\r\nWhen we watched the sunset over the castle on the hill\r\nOver the castle on the hill\r\nOver the castle on the hill', '{\"default\":\"https://i.ytimg.com/vi/K0ibBPhiaG0/default.jpg\",\"medium\":\"https://i.ytimg.com/vi/K0ibBPhiaG0/mqdefault.jpg\",\"high\":\"https://i.ytimg.com/vi/K0ibBPhiaG0/hqdefault.jpg\",\"standard\":\"https://i.ytimg.com/vi/K0ibBPhiaG0/sddefault.jpg\"}', 'PT4M49S', 312542029, 1966284, 59256, 68923, 0, 'Julien Renvoye', 1, '2017-01-23T11:21:26.000Z', '2018-04-26 07:44:23', NULL),
(4, '[\"2\"]', 'iKzRIweSBLA', 'Ed Sheeran - Perfect [Official Lyric Video]', 'ed-sheeran-perfect-official-lyric-video', '÷. Out Now: https://atlanti.cr/yt-album\r\nSubscribe to Ed\'s channel: http://bit.ly/SubscribeToEdSheeran\r\n\r\nFollow Ed on...\r\nFacebook: http://www.facebook.com/EdSheeranMusic\r\nTwitter: http://twitter.com/edsheeran\r\nInstagram: http://instagram.com/teddysphotos\r\nOfficial Website: http://edsheeran.com\r\n\r\nVideo by http://adultartclub.co.uk\r\nJonny Costello / Charlotte Audrey / Will Lanham / Henry Wong / Callum Barnes\r\nIllustrations - Steve New Tasty', '{\"default\":\"https://i.ytimg.com/vi/iKzRIweSBLA/default.jpg\",\"medium\":\"https://i.ytimg.com/vi/iKzRIweSBLA/mqdefault.jpg\",\"high\":\"https://i.ytimg.com/vi/iKzRIweSBLA/hqdefault.jpg\",\"standard\":\"https://i.ytimg.com/vi/iKzRIweSBLA/sddefault.jpg\"}', 'PT4M24S', 220759868, 1713622, 48948, 47289, 0, 'Julien Renvoye', 1, '2017-09-22T07:02:24.000Z', '2018-04-27 04:37:44', NULL),
(5, '[\"1\",\"2\"]', 'Wv2rLZmbPMA', 'Ed Sheeran - Dive [Official Audio]', 'ed-sheeran-dive-official-audio', '÷. Out Now: https://atlanti.cr/yt-album\r\n\r\nSubscribe to Ed\'s channel: http://bit.ly/SubscribeToEdSheeran\r\n\r\nFollow Ed on...\r\nFacebook: http://www.facebook.com/EdSheeranMusic\r\nTwitter: http://twitter.com/edsheeran\r\nInstagram: http://instagram.com/teddysphotos\r\nOfficial Website: http://edsheeran.com\r\n\r\n-- | LYRICS | --\r\n\r\nMaybe I came on too strong\r\nMaybe I waited too long\r\nMaybe I played my cards wrong\r\nOh just a little bit wrong\r\nBaby I apologise for it\r\n\r\nI could fall or I could fly\r\nHere in your aeroplane\r\nI could live, I could die\r\nHanging on the words you say\r\nI’ve been known to give my all\r\nAnd jumping in harder than\r\n10,000 rocks on the lake\r\n\r\nSo don’t call me baby\r\nUnless you mean it\r\nDon’t tell me you need me\r\nIf you don’t believe it\r\nSo let me know the truth\r\nBefore I dive right into you\r\n\r\nYou’re a mystery\r\nI have travelled the world\r\nAnd there’s no other girl like you, no one\r\nWhat’s your history?\r\nDo you have a tendency to lead some people on?\r\nCause I heard you do\r\n\r\nI could fall or I could fly\r\nHere in your aeroplane\r\nI could live, I could die\r\nHanging on the words you say\r\nI’ve been known to give my all\r\nAnd lie awake, every day\r\nDon’t know how much I can take\r\n\r\nSo don’t call me baby\r\nUnless you mean it\r\nDon’t tell me you need me\r\nIf you don’t believe it\r\nSo let me know the truth\r\nBefore I dive right into you\r\n\r\nI could fall or I could fly\r\nHere in your aeroplane\r\nI could live, I could die\r\nHanging on the words you say\r\nI’ve been known to give my all\r\nSitting back, looking at\r\nEvery mess that I made\r\n\r\nSo don’t call me baby\r\nUnless you mean it\r\nDon’t tell me you need me\r\nIf you don’t believe it\r\nSo let me know the truth\r\nBefore I dive right into you\r\nBefore I dive right into you\r\nBefore I dive right into you', '{\"default\":\"https://i.ytimg.com/vi/Wv2rLZmbPMA/default.jpg\",\"medium\":\"https://i.ytimg.com/vi/Wv2rLZmbPMA/mqdefault.jpg\",\"high\":\"https://i.ytimg.com/vi/Wv2rLZmbPMA/hqdefault.jpg\",\"standard\":\"https://i.ytimg.com/vi/Wv2rLZmbPMA/sddefault.jpg\"}', 'PT3M59S', 122715185, 554332, 16013, 15333, 0, 'Julien Renvoye', 1, '2017-03-03T07:08:46.000Z', '2018-04-27 04:38:00', NULL),
(6, '[\"2\"]', 'mlmpVkhV0X4', 'Faded vs. Closer (Mashup) - Alan Walker, The Chainsmokers & Halsey (By Earlvin14)', 'faded-vs-closer-mashup-alan-walker-the-chainsmokers-halsey-by-earlvin14', 'Faded vs. Closer (Mashup) - Alan Walker, The Chainsmokers & Halsey (By Earlvin14)\r\nDon\'t forget to Like & Share the mix if you enjoy it! \r\n▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\r\n\r\nMixed by Earlvin14: https://www.youtube.com/channel/UCb4MKea924HsqweULrfPyFw\r\n\r\n◢ Subscribe: http://bit.ly/Mystical-Sounds-Subscribe\r\n\r\n♪♫ Follow Mystical Sounds ♫♪\r\nhttps://soundcloud.com/mysticalsoundsofficial\r\nhttps://twitter.com/Mystical_Sound\r\nhttps://www.facebook.com/MysticalSoundsOfficial\r\n\r\n♪♫ Support The Chainsmokers ♫♪\r\nhttps://soundcloud.com/thechainsmokers\r\nhttp://www.facebook.com/thechainsmokers\r\nhttp://www.twitter.com/thechainsmokers\r\n\r\n♪♫ Support Alan Walker ♫♪\r\nhttps://www.facebook.com/alanwalkermusic\r\nhttps://soundcloud.com/alanwalker\r\nhttps://www.youtube.com/c/alanwalkermusic\r\nhttps://twitter.com/IAmAlanWalker\r\nhttps://www.instagram.com/alanwalkermusic\r\n\r\n♪♫ Background Link ♫♪\r\n★ https://alpha.wallhaven.cc\r\n\r\n◢ Please Share this Mix on Social sites (Facebook, Google +, Twitter etc.) to more person could listen it! https://youtu.be/mlmpVkhV0X4\r\n\r\nNo copyright infringement intended for the song or picture. If you need a song or picture removed on my channel, please e-mail me: mysticalsoundsofficial@gmail.com\r\n\r\n#deephouse #deephouse2016 #nudisco #musicvideo #housemusic2016 #deep #house #summer #vocalmix #vocalhouse #deephouse2016 #nudisco #housemusic #EDM #housemusic2016 #chillout #tropicalhouse #melodichouse #music #mixes #bestmusic #newfuturehouse #futurehouse #futurehousemusic #electrohouse #partymix #housemusic #futurehouseparty #chainsmokers #thechainsmokers #alanwalker #faded', '{\"default\":\"https://i.ytimg.com/vi/mlmpVkhV0X4/default.jpg\",\"medium\":\"https://i.ytimg.com/vi/mlmpVkhV0X4/mqdefault.jpg\",\"high\":\"https://i.ytimg.com/vi/mlmpVkhV0X4/hqdefault.jpg\",\"standard\":\"https://i.ytimg.com/vi/mlmpVkhV0X4/sddefault.jpg\",\"maxres\":\"https://i.ytimg.com/vi/mlmpVkhV0X4/maxresdefault.jpg\"}', 'PT4M52S', 18381065, 224739, 4500, 8352, 0, 'Julien Renvoye', 1, '2016-12-07T12:28:11.000Z', '2018-04-27 04:38:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `toto_bolagila_categories`
--

CREATE TABLE `toto_bolagila_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `toto_bolagila_videos`
--

CREATE TABLE `toto_bolagila_videos` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `youtube_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnails` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `viewCount` bigint(20) NOT NULL,
  `likeCount` bigint(20) NOT NULL,
  `dislikeCount` bigint(20) NOT NULL,
  `commentCount` bigint(20) NOT NULL,
  `favoriteCount` bigint(20) NOT NULL,
  `author` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `published_at` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `division` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `division`, `group_id`, `name`, `email`, `username`, `password`, `passcode`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '{\"id\":\"1,2,3,4\"}', 1, 'Julien Renvoye', 'myuser@email.com', 'myuser', '63a0b24890e2ef847156ba22133e6347', '5ef0636101f71ed8c0889139392847e8', 'fbs9AMvevUaFe6h8UKMWqqrWwazwFqsP1nUXx4zG9zlEBlSKinj0sDPlWrBu', '2018-01-25 07:52:39', '2018-08-13 04:53:47'),
(2, '{\"id\":\"1\"}', 1, 'Casino', 'myuser1@email.com', 'myuser1', '63a0b24890e2ef847156ba22133e6347', '5ef0636101f71ed8c0889139392847e8', 'b82u0rS34tQkhZKqNUcpJaHn4w4sooaIL7FHNCLfzMJ2ZE7RQRRbjsmlT20i', '2018-01-25 07:52:39', '2018-08-14 10:00:59'),
(3, '{\"id\":\"2\"}', 1, 'Multiplayer', 'myuser2@email.com', 'myuser2', '63a0b24890e2ef847156ba22133e6347', '5ef0636101f71ed8c0889139392847e8', 'O6IiTPm146dswyaR12Qbgg21bSetswphy4xOrR9SviNajYiQa9LiWRsvnR8t', '2018-01-25 07:52:39', '2018-08-14 10:01:01'),
(4, '{\"id\":\"1,2,3,4\"}', 2, 'Scott Adams', 'myemail@email.com', 'myusername', '261bdc9b784119ac27007a469486b2e5', '261bdc9b784119ac27007a469486b2e5', 'rdQtZaXz7zuWiL5ENIpy2XRCXdm18DJsh36btDm64sQX0HDtRZYVhPcwX4GD', '2018-03-22 06:21:27', '2018-08-15 05:41:02');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(10) NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `name`, `access`, `created_at`, `updated_at`) VALUES
(1, 'super admin', '{\"game\":\"\",\"view\":\"1,2,3,4,5,6,8,7\",\"create\":\"1,2,3,4,6,8,7\",\"alter\":\"1,2,3,4,6,8,7\",\"drop\":\"1,2,3,4,6,8,7\"}', '2018-01-30 09:19:07', '2018-08-17 05:33:00'),
(2, 'super hero', '{\"game\":\"\",\"view\":\"1\",\"create\":\"1\",\"alter\":\"1\",\"drop\":\"1\"}', '2018-01-30 09:19:07', '2018-08-16 12:50:24'),
(6, 'super woman', '{\"game\":\"\",\"view\":\"1,2\",\"create\":\"1,2\",\"alter\":\"\",\"drop\":\"\"}', '2018-08-16 12:50:34', '2018-08-16 12:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `user_modules`
--

CREATE TABLE `user_modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) NOT NULL,
  `alias` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_link` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_modules`
--

INSERT INTO `user_modules` (`id`, `parent_id`, `name`, `description`, `alias`, `icon`, `permanent_link`, `order`, `published`) VALUES
(1, NULL, 'Dashboard', 'statistics, charts and events', 'home', 'list-icon feather feather-command', '', 1, 1),
(2, NULL, 'Game', '', 'game', 'list-icon feather  feather-box', 'games', 2, 1),
(3, NULL, 'Category', '', 'category', 'list-icon feather feather-grid', 'categories', 3, 1),
(4, NULL, 'Video', '', 'video', 'list-icon feather feather-layers', 'videos', 4, 1),
(5, NULL, 'Users', '', '', 'list-icon feather feather-user', '', 5, 1),
(6, 5, 'User', '', 'user', '', 'users', NULL, 1),
(7, NULL, 'Trash', 'videos that have been in Trash more than 30 days will be automatically deleted', 'trash', '', 'videos/trash', NULL, 0),
(8, 5, 'User Group', '', 'user_group', '', 'user_groups', NULL, 1),
(9, NULL, 'Micro Sites', '', 'microsite', 'list-icon feather feather-globe', 'microsites', 6, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `casino_alexavegas_categories`
--
ALTER TABLE `casino_alexavegas_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `casino_alexavegas_videos`
--
ALTER TABLE `casino_alexavegas_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `sports_dewabet_categories`
--
ALTER TABLE `sports_dewabet_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports_dewabet_videos`
--
ALTER TABLE `sports_dewabet_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toto_bolagila_categories`
--
ALTER TABLE `toto_bolagila_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toto_bolagila_videos`
--
ALTER TABLE `toto_bolagila_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_modules`
--
ALTER TABLE `user_modules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `casino_alexavegas_categories`
--
ALTER TABLE `casino_alexavegas_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `casino_alexavegas_videos`
--
ALTER TABLE `casino_alexavegas_videos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sports_dewabet_categories`
--
ALTER TABLE `sports_dewabet_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sports_dewabet_videos`
--
ALTER TABLE `sports_dewabet_videos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `toto_bolagila_categories`
--
ALTER TABLE `toto_bolagila_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `toto_bolagila_videos`
--
ALTER TABLE `toto_bolagila_videos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_modules`
--
ALTER TABLE `user_modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
