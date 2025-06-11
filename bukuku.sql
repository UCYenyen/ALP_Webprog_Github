-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 11, 2025 at 02:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bukuku`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `genre` varchar(25) NOT NULL,
  `year_published` year(4) NOT NULL,
  `cover_image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `popularity_counter` int(11) DEFAULT 0,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `genre`, `year_published`, `cover_image`, `description`, `link`, `popularity_counter`, `owner_id`) VALUES
(11, 'The Psychology of Money', 'Morgan Housel', 'Economic', '2021', 'uploads/books/ThePsychologyOfMoney.avif', 'Kesuksesan dalam mengelola uang tidak selalu tentang apa yang Anda ketahui. Ini tentang bagaimana Anda berperilaku. Dan perilaku sulit untuk diajarkan, bahkan kepada orang yang sangat pintar sekalipun. Seorang genius yang kehilangan kendali atas emosinya bisa mengalami bencana keuangan. Sebaliknya, orang biasa tanpa pendidikan finansial bisa kaya jika mereka punya sejumlah keahlian terkait perilaku yang tak berhubungan dengan ukuran kecerdasan formal.', 'https://inspiredbyislam.wordpress.com/wp-content/uploads/2022/08/the-psychology-of-money-timeless-lessons-on-wealth-greed-and-happiness-morgan-housel-z-lib.org_.pdf', 1, 1),
(12, 'Konosuba 1!', 'Natsume Akatsuki', 'Fiction', '2024', 'uploads/books/Konosuba.avif', 'Kehidupan Kazuma Sato, seorang anak laki-laki penyendiri yang menyukai game, seharusnya telah berakhir. Namun ketika dia terbangun, seorang “dewi” yang cantik nan menyebalkan menawarkan padanya untuk hidup kembali di dunia lain. “Kamu akan terbangun di dunia lain, tapi sebelumnya kamu boleh meminta satu hal apa pun untuk di bawa ke sana. Aku akan mengabulkannya.”', 'https://cgtranslations.me/2018/01/02/konosuba-volume-3-prologue-youre-being-called-darkness/', 1, 1),
(13, 'The Power of Crazy Affiliate', 'Ken Andaru', 'Economic', '2025', 'uploads/books/the power of crazy affiliate.avif', 'Kita pasti akrab dengan kalimat tersebut. Biasanya digunakan sebagai dalih setelah seseorang belanja, baik secara online maupun offline. Ya, sekarang ini membeli barang bisa dilakukan dengan sangat mudah, apalagi dengan kehadiran marketplace seperti Shopee, Tokopedia, TikTok, dan lain sebagainya.', 'https://divapress-online.com/book/the-power-of-crazy-affiliate', 1, 1),
(14, 'Sendiri Menemui-Mu', 'Hendro Siswanggono', 'Fashion', '2022', 'uploads/books/Sendiri_Menemui-Mu.avif', 'Sebuah kebanggaan tersendiri jika penyair menerbitkan buku puisi. Karena terbitnya buku puisi sebagai sebuah legacy, atau bisa dibilang keabsahan penyair berkarya puisi. Bukti otentiknya tentu penyair punya buku puisi karyanya. Begitu pula dengan penyair Hendro Siswanggono, yang juga seorang dokter, meluncurkan buku kumpulan sajak bertajuk ‘Sendiri Menemui-Mu’ pada awal tahun 2022. Buku terbitan Balai Pustaka yang berisi 143 sajak-sajak pendek karya Hendro Siswanggono ini siap menemui pembacanya.', 'https://www.gramedia.com/products/sendiri-menemui-mu', 0, 1),
(16, 'Space &amp; Time', 'Laurentiu Mihaescu', 'Education', '2022', 'uploads/books/SpaceAndTimeBook.jpg', 'Considering the special mechanics of a granular space, the theory of relativity must be reformulated to include the absolute frames or references and to describe the real perception of various observers on a body in motion. As the same mechanics established the laws of physics and allowed the primordial matter to self-organize and create increasingly larger cosmic formations, new explanations can now be given, shedding light on the formation and evolution of our universe and elucidating the mysteries of dark matter and dark energy. Moreover, the granular model can also help us to find out if a certain physical quantity is continuous or discrete at different dimensional scales.', 'https://www.free-ebooks.net/science/Space-and-Time/pdf?dl&amp;preview', 0, 2),
(17, 'Read People Like A Book', 'Patrick King', 'Psychology', '2020', 'uploads/books/readPeopleLikeAbookBook.jpg', 'Speed read people, decipher body language, detect lies, and understand human nature. Is it possible to analyze people without them saying a word? Yes, it is. Learn how to become a “mind reader” and forge deep connections. How to get inside people’s heads without them knowing. Read People Like a Book isn’t a normal book on body language of facial expressions. Yes, it includes all of those things, as well as new techniques on how to truly detect lies in your everyday life, but this book is more about understanding human psychology and nature.', 'https://fliphtml5.com/ebdrc/ihpj/Read_People_Like_a_Book_-_Patrick_King__OceanofPDF.com_/', 1, 2),
(18, 'Emotional Intelligence', 'Daniel Goleman', 'Psychology', '1996', 'uploads/books/EmotionalIntellegenceBook.jpg', 'Why do some people seem endowed with a special gift that allows them to live well, even though they aren&#039;t the most distinguished for their intelligence? Why doesn&#039;t the smartest student always end up being the most successful? Why are some more capable than others of facing setbacks, overcoming obstacles, and seeing difficulties from a different perspective?', 'https://donainfo.wordpress.com/wp-content/uploads/2017/09/emotional-intelligence-daniel-goleman.pdf', 0, 2),
(19, 'Teasing Master Takagi Vol 1', 'Yamamoto Souichirou', 'Romance', '2021', 'uploads/books/teasing_master_takag_1.avif', 'Teasing Master Takagi-san adalah serial manga Jepang yang ditulis dan diilustrasikan oleh Soichiro Yamamoto. Serial ini menampilkan kehidupan sehari-hari Takagi. Takagi yang suka menggoda teman sekelasnya Nishikata, dan Nishikata gagal untuk membalasnya. Di Amerika Utara, manga ini dilisensikan oleh Yen Press.', 'https://www.yumpu.com/xx/document/read/64354334/read-books-teasing-master-takagi-san-vol-1-by-soichiro-yamamoto', 1, 2),
(20, 'The Angel Next Door Spoils Me Rotten', 'Saekisan', 'Romance', '2020', 'uploads/books/The_Angel_Next_Door_Spoils_Me_Rotten_volume_1_cover.jpg', 'Mahiru Shiina pantas dijuluki &quot;Malaikat&quot;: dia adalah wanita cantik yang dicintai semua orang, dan dia unggul dalam bidang akademik dan atletik. Shiina tinggal di dunia yang sama sekali berbeda dari Amane Fujimiya, tetangga sebelahnya. Meskipun tinggal sangat dekat, mereka tidak pernah berbicara sekali pun. Namun, keheningan mereka pecah ketika Fujimiya melihat Shiina duduk dengan murung di ayunan di tengah hujan lebat dan meminjamkan payungnya.', 'https://www.yumpu.com/en/document/read/70426476/download-free-pdf-the-angel-next-door-spoils-me-rotten-vol-1-ligh-by-saekisan-hanekoto', 1, 2),
(21, 'Cloud Computing - The Complete Manual', 'Obie', 'Technology', '2020', 'uploads/books/CloudComputing.jpg', 'Pelajari cara memanfaatkan cloud secara maksimal untuk rumah &amp; bisnis! Cloud computing telah hadir bersama kita selama beberapa waktu, memberikan cara baru bagi pengguna rumahan, bisnis kecil hingga menengah, dan perusahaan untuk mendukung dan memanfaatkan infrastruktur dan data mereka. Meskipun cloud mungkin memiliki banyak masalah, terutama keamanan data, cloud merupakan salah satu aspek komputasi modern yang paling cepat berkembang dan menarik. Dengan The Cloud Computing Guidebook, kami akan menunjukkan kepada Anda cara menerapkan dan memanfaatkan cloud dengan lebih baik: secara pribadi atau untuk bisnis Anda. Kami juga membahas cara mengamankan dan bahkan membangun layanan cloud Anda sendiri. 100% tidak resmi.', 'https://www.yumpu.com/news/en/issue/89119-cloud-computing-the-complete-manual-issue-032021/read', 1, 1),
(22, 'Re:Zero: Starting Life in Another World', 'Tappei Nagatsuki', 'Fantasy', '2019', 'uploads/books/1980-manga-rezero-kara-hajimeru-isekai-seikatsu-vol-6.png', 'Subaru Natsuki tiba-tiba dipindahkan ke sebuah dunia lain. Tanpa mengetahui siapa yang memindahkan dirinya, Subaru berteman dengan seorang gadis setengah elf berambut perak. Saat dia dan gadis tersebut secara misterius terbunuh, Subaru terbangun dan menyadari bahwa dirinya mendapatkan kemampuan &quot;Return by Death&quot;, memungkinkan dirinya kembali ke waktu sebelum ia meninggal dunia.', 'https://www.yumpu.com/en/document/read/69569562/get-pdf-rezero-starting-life-in-another-world-vol-1-rezero-starting-life-in-another-world-1-volume-1-unlimited', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_collections`
--

CREATE TABLE `personal_collections` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_favorite` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_collections`
--

INSERT INTO `personal_collections` (`id`, `book_id`, `user_id`, `is_favorite`) VALUES
(11, 12, 1, 1),
(12, 21, 1, 0),
(13, 20, 1, 1),
(14, 22, 1, 1),
(15, 19, 1, 1),
(16, 13, 1, 0),
(17, 11, 1, 0),
(20, 17, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `profile_image`) VALUES
(1, 'bryan', 'bryan', 'profile_bryan_bukuku.jpg'),
(2, 'obie', 'nicho', 'Obie_2.JPEG'),
(3, 'jesti', 'jesti', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `personal_collections`
--
ALTER TABLE `personal_collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `personal_collections`
--
ALTER TABLE `personal_collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `personal_collections`
--
ALTER TABLE `personal_collections`
  ADD CONSTRAINT `personal_collections_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `personal_collections_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
