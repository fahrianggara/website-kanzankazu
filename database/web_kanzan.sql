-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 02, 2022 at 04:53 PM
-- Server version: 5.7.33
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_kanzan`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `thumbnail`, `description`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'HTML', 'html', 'noimage.jpg', '', NULL, '2022-06-02 03:42:23', '2022-06-02 16:16:53'),
(2, 'CSS', 'css', 'noimage.jpg', '', NULL, '2022-06-02 03:42:23', '2022-06-02 16:18:02'),
(3, 'Javascript', 'javascript', 'noimage.jpg', '', NULL, '2022-06-02 03:42:23', '2022-06-02 16:17:55'),
(4, 'PHP', 'php', 'noimage.jpg', '', NULL, '2022-06-02 03:42:23', '2022-06-02 16:24:25'),
(5, 'Laravel', 'laravel', 'CateIMG-629854d65d0988.64483391.png', '', NULL, '2022-06-02 06:12:38', '2022-06-02 16:16:12'),
(6, 'Tutorial', 'tutorial', 'default.png', '', NULL, '2022-06-02 06:29:16', '2022-06-02 16:16:40');

-- --------------------------------------------------------

--
-- Table structure for table `category_post`
--

CREATE TABLE `category_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_post`
--

INSERT INTO `category_post` (`id`, `category_id`, `post_id`, `created_at`, `updated_at`) VALUES
(6, 5, 3, '2022-06-02 06:14:12', '2022-06-02 06:14:12'),
(8, 6, 1, '2022-06-02 06:30:57', '2022-06-02 06:30:57'),
(9, 6, 2, '2022-06-02 06:31:07', '2022-06-02 06:31:07'),
(10, 6, 3, '2022-06-02 06:32:39', '2022-06-02 06:32:39');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commenter_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commenter_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `child_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'user', 'user@gmail.com', 'Halo angga', 'saya hengker pro tzy', '2022-06-02 04:38:03', '2022-06-02 04:38:03');

-- --------------------------------------------------------

--
-- Table structure for table `email_messages`
--

CREATE TABLE `email_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_messages`
--

INSERT INTO `email_messages` (`id`, `title`, `subject`, `action`, `body`, `created_at`, `updated_at`) VALUES
(1, 'Email Verification', 'Selamat datang di KanzanKazu', 'NEWSLETTER_SUBSCRIPTION_CUSTOMER', 'Terimakasih sudah berlangganan di KanzanKazu, kamu akan mendapatkan informasi dan tutorial yang lebih awal.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_06_30_113500_create_comments_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_09_21_215033_create_contact_table', 1),
(7, '2021_09_22_121413_create_categories_table', 1),
(8, '2021_09_23_115353_create_tags_table', 1),
(9, '2021_09_23_203319_create_posts_table', 1),
(10, '2021_09_23_203625_create_category_post_table', 1),
(11, '2021_09_24_094558_create_post_tag_table', 1),
(12, '2021_09_24_181913_create_permission_tables', 1),
(13, '2021_10_17_113142_soft_delete_post', 1),
(14, '2021_10_17_162328_add_users_name_slug', 1),
(15, '2022_05_30_001803_create_email_messages_table', 1),
(16, '2022_05_30_003243_create_newsletters_table', 1),
(17, '2022_06_01_164553_create_web_settings_table', 1),
(18, '2022_06_02_115309_create_tutorials_table', 2),
(19, '2022_06_02_115402_create_tutorial_post_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletters`
--

INSERT INTO `newsletters` (`id`, `email`, `created_at`, `updated_at`) VALUES
(1, 'fahriangga30@gmail.com', '2022-06-02 06:36:31', '2022-06-02 06:36:31'),
(2, 'awdqe@gmail.com', '2022-06-02 13:43:04', '2022-06-02 13:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'post_show', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(2, 'post_create', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(3, 'post_update', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(4, 'post_detail', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(5, 'post_delete', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(6, 'category_show', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(7, 'category_create', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(8, 'category_update', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(9, 'category_delete', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(10, 'tag_show', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(11, 'tag_create', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(12, 'tag_update', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(13, 'tag_delete', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(14, 'role_show', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(15, 'role_create', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(16, 'role_update', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(17, 'role_detail', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(18, 'role_delete', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(19, 'user_show', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(20, 'user_create', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(21, 'user_update', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(22, 'user_detail', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(23, 'user_delete', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(24, 'inbox_show', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(25, 'inbox_delete', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(26, 'website_show', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('publish','draft') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `views` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `thumbnail`, `author`, `description`, `content`, `status`, `keywords`, `created_at`, `updated_at`, `user_id`, `views`, `deleted_at`) VALUES
(1, 'Membuat Dark Mode', 'membuat-dark-mode', 'POST-629847d8226ba5.60768664.png', 'Zexpher', 'Pada tutorial kali ini, mimin zexpher akan membuat tutorial membuat Dark Mode menggunakan HTML, CSS dan Java Script. Apasih itu darkmode? yaitu tampilan yang membuat warna layar ponsel menjadi lebih gelap, dan sangat berbeda dengan tampilan pada mode biasa. Dark Mode ini sedang trending lhoo makanya sekarang banyak yang menggunakan Dark Mode disetiap halaman website. okee tanpa basa basi lagi kita akan membuat tutorialnya.', '<p>Pada tutorial kali ini, mimin zexpher&nbsp; akan membuat tutorial membuat Dark Mode menggunakan HTML, CSS dan JavaScript. Apasih itu darkmode? yaitu tampilan yang membuat warna layar ponsel menjadi lebih gelap, dan sangat berbeda dengan tampilan pada mode biasa. Dark Mode ini sedang trending lhoo makanya sekarang banyak yang menggunakan Dark Mode disetiap halaman website. okee tanpa basa basi lagi kita akan membuat tutorialnya.</p>\r\n<div>1. Buatlah folder dengan nama darkmode. Selanjutnya buka text editor kesukaan kalian dan cari folder yang sudah dibuat tadi yaitu folder dengan nama darkmode.</div>\r\n<div>&nbsp;</div>\r\n<div>2. Di dalam folder darkmode, buatlah file CSS dengan nama <code class=\"language-css\">style.css</code></div>\r\n<div>dan copy semua code atau click tombol copy di dalam box code berikut:</div>\r\n<pre><code class=\"language-css\" data-prismjs-copy=\"Copy to Clipboard!\">/* Font Google: Rubik */\r\n@import url(\"https://fonts.googleapis.com/css?family=Rubik:400,500,700\");\r\n\r\n/* Membuat variabel warna untuk light mode */\r\n:root {\r\n  --body-color: #fff;\r\n  --text-color: #000;\r\n}\r\n\r\n/* Dan ini membuat variabel warna untuk dark mode  */\r\nbody.dark-theme {\r\n  --body-color: #121212;\r\n  --text-color: #fff;\r\n}\r\n\r\n/* body-theme ini adalah class di bagian element body */\r\n.body-theme {\r\n  background-color: var(--body-color);\r\n  color: var(--text-color);\r\n  transition: 0.3s;\r\n}\r\n\r\n/*\r\n   Untuk tanda bintang (*) ini berarti semua (mau element body, h1, a). pokoknya kalo bintang itu artinya semua,\r\n   jadi semua halaman kita kasih font style rubik yang sudah kita import di bagian atas\r\n*/\r\n* {\r\n  font-family: \"Rubik\", sans-serif;\r\n}\r\n\r\n/* Edit body navbar */\r\n.navbar {\r\n  background-color: var(--body-color);\r\n  box-shadow: 0 0 3px 3px rgba(0, 0, 0, 0.15);\r\n  transition: 0.3s;\r\n  position: fixed;\r\n  width: 100%;\r\n  top: 0;\r\n  z-index: 50;\r\n}\r\n\r\n/* Edit Logo biar lebih keren */\r\n.navbar-brand {\r\n  font-weight: 500;\r\n  margin-left: 15px;\r\n  color: var(--text-color);\r\n  transition: 0.3s;\r\n}\r\n.navbar-brand:hover {\r\n  color: #00829b;\r\n  transition: 0.3s;\r\n}\r\n\r\n/* Sekarang kita edit ikon bulannya */\r\n.change-theme i {\r\n  font-size: 25px;\r\n  margin-right: 20px;\r\n  cursor: pointer;\r\n  color: var(--text-color);\r\n  transition: 0.3s;\r\n}\r\n.change-theme i:hover {\r\n  color: #00829b;\r\n  transition: 0.3s;\r\n}\r\n\r\n/* di element p atau paragraph kita kasih justify */\r\np {\r\n  text-align: justify;\r\n}</code></pre>\r\n<div>3. Buatlah file JavaScript dengan nama filenya.. yaitu <code class=\"language-js\">main.js</code></div>\r\n<div>dan copy semua code atau click tombol copy di dalam box code berikut:</div>\r\n<pre><code class=\"language-js\" data-prismjs-copy=\"Copy to Clipboard!\">// Membuat variabel dengan nama themeToggle yang diambil dari id theme-toggle yang ada di ikon bulan.\r\nconst themeToggle = document.getElementById(\'theme-toggle\')\r\n\r\n// Membuat variabel dark-theme. \"min, dark-theme ini dari mana? yaitu ada di file style.css dibagian variabel warna untuk dark theme\"\r\nconst darkTheme = \'dark-theme\'\r\n// Membuat variabel lightTheme yang isinya ikon lampu, jadi kalo mau ganti icon light theme disini\r\nconst ligthTheme = \'uil-lightbulb-alt\'\r\n\r\n// Membuat variabel untuk localstorage\r\nconst selectedTheme = localStorage.getItem(\'selected-theme\')\r\nconst selectedIcon = localStorage.getItem(\'selected-icon\')\r\n\r\n// membuat variabel currentTheme. jadi ketika itu darktheme maka gelap, jika tidak maka terang\r\nconst getCurrentTheme = () =&gt; document.body.classList.contains(darkTheme) ? \'dark\' : \'light\'\r\n// membuat variabel currentIco. jadi ketika itu lightTheme maka kasih ikon bulan, jika tidak maka ikon lampu\r\nconst getCurrentIcon = () =&gt; themeToggle.classList.contains(ligthTheme) ? \'uil-moon\' : \'uil_sun\'\r\n\r\n// Logika, selectedTheme ini di ambil dari variabel selectedTheme yang sudah dibuat\r\nif (selectedTheme) {\r\n    // jika localStorage.getItem(\'selected-theme\') itu sama dengan dark maka add/menambahkan jika tidak remove/hapus\r\n    document.body.classList[selectedTheme === \'dark\' ? \'add\' : \'remove\'](darkTheme)\r\n    // themeToggle tambahkan class list yaitu selectedIcon, jika selectedIcon sama dengan ikon bulan maka add jika tidak remove\r\n    themeToggle.classList[selectedIcon === \'uil-moon\' ? \'add\' : \'remove\'](ligthTheme)\r\n}\r\n\r\n// themeToggle jika diclick maka ganti darktheme, dan sebaliknya.\r\nthemeToggle.addEventListener(\'click\', () =&gt; {\r\n    document.body.classList.toggle(darkTheme)\r\n    themeToggle.classList.toggle(ligthTheme)\r\n    /*\r\n        menyimpan tema di localstorage. jadi ketika direfresh website itu ga berubah temanya, masih sama..\r\n        jika tidak menggunakan localstorage ini maka ketika direfresh yang tadinya darkmode maka kembali jadi light theme\r\n    */\r\n    localStorage.setItem(\'selected-theme\', getCurrentTheme())\r\n    localStorage.setItem(\'selected-icon\', getCurrentIcon())\r\n});</code></pre>\r\n<div>4. Terakhir, buatlah file HTML dengan nama filenya.. yaitu <code class=\"language-html\">index.html</code></div>\r\n<div>dan copy semua code atau click tombol copy di dalam box code berikut:</div>\r\n<pre><code class=\"language-html\" data-prismjs-copy=\"Copy to Clipboard!\">&lt;!DOCTYPE html&gt;\r\n&lt;html lang=\"en\"&gt;\r\n\r\n&lt;head&gt;\r\n    &lt;meta charset=\"UTF-8\"&gt;\r\n    &lt;meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"&gt;\r\n    &lt;meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"&gt;\r\n    &lt;title&gt;Membuat Dark Mode&lt;/title&gt;\r\n    &lt;!-- Main CSS --&gt;\r\n    &lt;link rel=\"stylesheet\" href=\"style.css\"&gt;\r\n    &lt;!-- Icon --&gt;\r\n    &lt;link rel=\"stylesheet\" href=\"https://unicons.iconscout.com/release/v4.0.0/css/line.css\"&gt;\r\n    &lt;!-- Bootstrap CSS --&gt;\r\n    &lt;link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF\" crossorigin=\"anonymous\"&gt;\r\n    \r\n&lt;/head&gt;\r\n\r\n&lt;body class=\"body-theme\"&gt;\r\n\r\n    &lt;!-- Navbar atau Navigation Bar --&gt;\r\n    &lt;nav class=\"navbar navbar-expand-lg\"&gt;\r\n        &lt;div class=\"container-fluid\"&gt;\r\n            &lt;a class=\"navbar-brand\" href=\"#\"&gt;DarkMode&lt;/a&gt;\r\n            &lt;div class=\"d-flex change-theme\"&gt;\r\n                &lt;i class=\"uil uil-moon\" id=\"theme-toggle\"&gt;&lt;/i&gt;\r\n            &lt;/div&gt;\r\n        &lt;/div&gt;\r\n    &lt;/nav&gt;\r\n\r\n    &lt;!-- Content --&gt;\r\n    &lt;div class=\"container mt-3\"&gt;\r\n        &lt;div class=\"row\"&gt;\r\n            &lt;div class=\"col-lg-12\"&gt;\r\n                &lt;h4 class=\"text-center mt-3 mb-4\"&gt;Dark Mode&lt;/h4&gt;\r\n\r\n                &lt;p&gt;\r\n                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n                &lt;/p&gt;\r\n                &lt;p&gt;\r\n                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\r\n                &lt;/p&gt;\r\n                &lt;p&gt;\r\n                    At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\r\n                &lt;/p&gt;\r\n\r\n            &lt;/div&gt;\r\n        &lt;/div&gt;\r\n    &lt;/div&gt;\r\n\r\n    &lt;!-- Main JS --&gt;\r\n    &lt;script src=\"main.js\"&gt;&lt;/script&gt;\r\n    &lt;!-- Bootstrap JS --&gt;\r\n    &lt;script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ\" crossorigin=\"anonymous\"&gt;&lt;/script&gt;\r\n&lt;/body&gt;\r\n\r\n&lt;/html&gt;</code></pre>\r\n<h3>Live Demo</h3>\r\n<p><iframe style=\"width: 100%;\" title=\"Dark Mode\" src=\"https://codepen.io/fahrianggara/embed/wvqqBVy?default-tab=html%2Cresult\" height=\"420\" frameborder=\"no\" scrolling=\"no\" allowfullscreen=\"allowfullscreen\" loading=\"lazy\">\r\n  See the Pen <a href=\"https://codepen.io/fahrianggara/pen/wvqqBVy\">\r\n  Dark Mode</a> by fahrianggara (<a href=\"https://codepen.io/fahrianggara\">@fahrianggara</a>)\r\n  on <a href=\"https://codepen.io\">CodePen</a>.</iframe></p>\r\n<div>Selesai! gampang bukan membuat darkmode itu? jadi kesimpulannya kita harus membuat variabel warna di CSSnya yang satu variabelnya untuk light mode dan satunya dark mode.</div>\r\n<blockquote>\r\n<p>Jika tidak berjalan darkmodenya.. itu bug dibagian file CSS. Jika terjadi bug, copy codingan yang ada di dalam file <em>style.css</em> dan selanjutnya buat element <em>&lt;style&gt;</em> di dalam tag <em>&lt;head&gt;. </em>Jika sudah dibuat, maka selanjutnya.. yang tadi sudah di copy(codingan didalam file <em>style.css</em>). Paste di dalam element <em>&lt;style&gt;.</em></p>\r\n<p>&nbsp;</p>\r\n<p><em>&lt;style&gt;<strong>paste dalam sini</strong>&lt;/style&gt;</em></p>\r\n</blockquote>\r\n<div>Jika ada yang mau nanya tentang darkmode ini silahkan tanya di kolom komentar ya.</div>\r\n<div>&nbsp;</div>', 'publish', 'darkmode, mode gelap, membuat darkmode, simple darkmode', '2022-06-02 05:17:12', '2022-06-02 13:25:45', 2, 3, NULL),
(2, 'Menampilkan Password', 'menampilkan-password', 'POST-62984aaf5aeba1.00272313.png', 'Zexpher', 'Halo Gaess pada tutorial kali ini, mimin zexpher akan membuat atau mengubah input password menjadi input text atau bisa dibilang \"show password\". Seperti biasa tutorial ini menggunakan HTML, Bootstrap(CSS) dan JavaScript. Tanpa basa basi lagi kita gaskenn!!', '<p>Halo Gaess pada tutorial kali ini, mimin Zexpher akan membuat atau mengubah input password menjadi input text atau bisa dibilang \"show password\". Seperti biasa tutorial ini menggunakan HTML, Bootstrap(CSS) dan JavaScript. Tanpa basa basi lagi kita gaskenn!!</p>\r\n<p>1. Buatlah folder dengan nama showpassword, bebas sih kalo kalian mau pakai nama apa aja. Jika sudah..&nbsp; buat file html dan css didalam folder tersebut, contoh index.html dan style.css</p>\r\n<p>2. bukalah file style.css nya dan paste semua code dibawah ini, atau klik \"copy to clipboard\" yang ada dalam box code dibawah</p>\r\n<pre><code class=\"language-css\" data-prismjs-copy=\"Copy to Clipboard!\">/* Font Google: Rubik */\r\n@import url(\"https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&amp;display=swap\");\r\n\r\n/* mengubah fontnya jadi rubik */\r\n* {\r\n    font-family: \"Rubik\", sans-serif;\r\n}\r\n\r\n/* Content menjadi ditengah */\r\nbody {\r\n    height: 100vh;\r\n    display: flex;\r\n    flex-direction: column;\r\n    align-items: center;\r\n    justify-content: center;\r\n}\r\n\r\n/* Styling card biar ada shadownya */\r\n.card {\r\n    -webkit-box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.2);\r\n    box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.2);\r\n}\r\n\r\n/* Menampatkan posisi icon mata biar ada didalam input password */\r\n.form-group .passTog {\r\n    position: absolute;\r\n    top: 123px;\r\n    right: 30px;\r\n    cursor: pointer;\r\n}\r\n/* Agar besar iconya */\r\n.form-group .passTog i {\r\n    font-size: 18px;\r\n}</code></pre>\r\n<p>3. bukalah file index.html nya dan paste semua code dibawah ini, atau klik \"copy to clipboard\" yang ada dalam box code dibawah</p>\r\n<pre><code class=\"language-html\" data-prismjs-copy=\"Copy to Clipboard!\">&lt;!DOCTYPE html&gt;\r\n&lt;html lang=\"en\"&gt;\r\n\r\n&lt;head&gt;\r\n    &lt;meta charset=\"UTF-8\"&gt;\r\n    &lt;meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"&gt;\r\n    &lt;meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"&gt;\r\n    &lt;title&gt;Show Password&lt;/title&gt;\r\n    &lt;!-- Main CSS --&gt;\r\n    &lt;link rel=\"stylesheet\" href=\"style.css\"&gt;\r\n    &lt;!-- Bootstrap CSS --&gt;\r\n    &lt;link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\"\r\n        integrity=\"sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF\" crossorigin=\"anonymous\"&gt;\r\n    &lt;!-- BS Icons --&gt;\r\n    &lt;link rel=\"stylesheet\"\r\n        href=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.0/font/bootstrap-icons.min.css\"\r\n        integrity=\"sha512-yLNTU6YQWEtsM/WVkUqd2jRzzq5hmfFUMVvziVlkgC0R9HTElDtyF4DiWiBeMS36npvN+NWwrr764A4AWGcmQQ==\"\r\n        crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\" /&gt;\r\n&lt;/head&gt;\r\n\r\n&lt;body&gt;\r\n    &lt;div class=\"container\"&gt;\r\n        &lt;div class=\"row justify-content-center\"&gt;\r\n            &lt;div class=\"col-lg-6 col-md-12\"&gt;\r\n                &lt;div class=\"card\"&gt;\r\n                    &lt;form action=\"#\" method=\"#\" autocomplete=\"off\"&gt;\r\n                        &lt;div class=\"card-header\"&gt;\r\n                            &lt;h4 class=\"d-inline\"&gt;Show Password&lt;/h4&gt;\r\n                        &lt;/div&gt;\r\n                        &lt;div class=\"card-body\"&gt;\r\n                            &lt;!-- Email --&gt;\r\n                            &lt;div class=\"form-group row\"&gt;\r\n                                &lt;label for=\"email\" class=\"col-lg-3 col-3 col-form-label\"&gt;Email:&lt;/label&gt;\r\n                                &lt;div class=\"col-lg-9 col-9\"&gt;\r\n                                    &lt;input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Your Email\"\r\n                                        required /&gt;\r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;\r\n                            &lt;!-- Password --&gt;\r\n                            &lt;div class=\"form-group row mt-3\"&gt;\r\n                                &lt;label for=\"password\" class=\"col-lg-3 col-3 col-form-label\"&gt;Password:&lt;/label&gt;\r\n                                &lt;div class=\"col-lg-9 col-9\"&gt;\r\n                                    &lt;input type=\"password\" class=\"form-control\" id=\"password\"\r\n                                        placeholder=\"Your Password\" required /&gt;\r\n                                    &lt;!-- Icon and toggle show --&gt;\r\n                                    &lt;div class=\"passTog\"&gt;&lt;i class=\"bi bi-eye-slash-fill\" id=\"togglePassword\"&gt;&lt;/i&gt;&lt;/div&gt;\r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;\r\n\r\n                        &lt;/div&gt;\r\n                        &lt;div class=\"card-footer\"&gt;\r\n                            &lt;button type=\"submit\" class=\"btn btn-success\"&gt;Submit&lt;/button&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/form&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n        &lt;/div&gt;\r\n    &lt;/div&gt;\r\n\r\n    &lt;script&gt;\r\n        // membuat variabel tombol untuk melihat password, yang diambil dari id togglePassword\r\n        const togglePassword = document.querySelector(\"#togglePassword\");\r\n        // membuat variabel untuk input password, yang diambil dari id password didalam input password\r\n        const password = document.querySelector(\"#password\");\r\n\r\n        // Sekarang kita jalankan fungsinya biar diklik terus yang tadinya type password jadi type text.\r\n\r\n        // eventlistener ini fungsinya untuk meng-handle event yang terjadi.\r\n        togglePassword.addEventListener(\'click\', function (e) {\r\n            // kita buat variabel type + pengecekan\r\n            const type = password.getAttribute(\'type\') === \"password\" ? \"text\" : \"password\";\r\n            // maksudnya: jika kita meng-klik tombol mata. maka password akan jadi type text, jika tidak maka dijadikan type password.\r\n\r\n            // set atribute ini fugsi untuk mengganti typenya\r\n            password.setAttribute(\'type\', type);\r\n\r\n            // ketika diklik tombolnya showpassword, kita ganti icon tutup mata(default) jadi icon mata\r\n            this.classList.toggle(\"bi-eye\");\r\n        });\r\n    &lt;/script&gt;\r\n&lt;/body&gt;\r\n\r\n&lt;/html&gt;</code></pre>\r\n<p>Selesai deh, gampang bukan? membuat show password itu.. kalau begitu sekian dulu tutorial kali ini, kalau misal ada yang masih bingung komen dibawah ya! Selamat Mencoba</p>\r\n<p>Next kita akan membuat tutorial float label input. Ditunggu yaa!</p>', 'publish', 'tutorial menampilkan password, show password, cara melihat password', '2022-06-02 05:29:19', '2022-06-02 16:24:47', 2, 4, NULL),
(3, 'Membuat Multi Language', 'membuat-multi-language', 'POST-629853ee7b3483.63303766.png', 'Zexpher', 'Soo pada tutorial kali ini kita akan belajar atau membuat projek yaitu membuat multi language di laravel 8, jadi di multi language ini ada bahasa indonesia dan bahasa inggris. oke tanpa basa basi lagi kita langsung gasken..', '<div>Soo pada tutorial kali ini kita akan belajar atau membuat projek yaitu membuat multi language di laravel 8, jadi di multi language ini ada bahasa indonesia dan bahasa inggris. oke tanpa basa basi lagi kita langsung gasken..</div>\r\n<div>&nbsp;</div>\r\n<div>1. kita akan membuat middleware dengan nama Localization buka terminal kalian dan pastikan sudah didalam projek laravel kalian dan copy code dibawah ini.</div>\r\n<pre><code class=\"language-smali\" data-prismjs-copy=\"Copy to Clipboard!\">php artisan make:middleware Localization</code></pre>\r\n<div>2. buka file yang sudah dibuat yaitu di <em>App &gt; Http &gt; Middleware &gt; Localization.php </em>dan copy code dibawah ini.</div>\r\n<pre><code class=\"language-php\" data-prismjs-copy=\"Copy to Clipboard!\">&lt;?php\r\n\r\nnamespace App\\Http\\Middleware;\r\n\r\nuse Closure;\r\nuse Illuminate\\Http\\Request;\r\n\r\nclass Localization\r\n{\r\n    /**\r\n     * Handle an incoming request.\r\n     *\r\n     * @param  \\Illuminate\\Http\\Request  $request\r\n     * @param  \\Closure  $next\r\n     * @return mixed\r\n     */\r\n    public function handle(Request $request, Closure $next)\r\n    {\r\n        // pengecekan\r\n        if (session()-&gt;has(\'locale\')) {\r\n            \\App::setLocale(session()-&gt;get(\'locale\'));\r\n        }\r\n        return $next($request);\r\n    }\r\n}\r\n</code></pre>\r\n<div>3. lalu buka file <em>Kernel.php.</em> di <em>App &gt; Http &gt; Kernel.php</em>&nbsp;&nbsp;dan copy code berikut di<strong> </strong><em>$middlewareGroups </em>yang dibagian<em> web.</em></div>\r\n<pre><code class=\"language-smali\" data-prismjs-copy=\"Copy to Clipboard!\">\\App\\Http\\Middleware\\Localization::class,</code></pre>\r\n<div>4. buka terminal lagi kita akan membuat controller dengan nama LocalizationController.</div>\r\n<div>\r\n<pre><code class=\"language-smali\" data-prismjs-copy=\"Copy to Clipboard!\">php artisan make:controller LocalizationController</code></pre>\r\n<div>5. masuk ke file yang sudah dibuat yaitu <em>LocalizationController</em> dan copy code berikut.</div>\r\n</div>\r\n<pre><code class=\"language-php\" data-prismjs-copy=\"Copy to Clipboard!\">&lt;?php\r\n\r\nnamespace App\\Http\\Controllers;\r\n\r\nclass LocalizationController extends Controller\r\n{\r\n    public function switch($language = \'en\')\r\n    {\r\n        request()-&gt;session()-&gt;put(\'locale\', $language);\r\n        return redirect()-&gt;back();\r\n    }\r\n}</code></pre>\r\n<div>6. buka file <em>web.php</em> didalam folder routes dan copy code berikut.</div>\r\n<pre><code class=\"language-php\" data-prismjs-copy=\"Copy to Clipboard!\">Route::get(\'/localization/{language}\', [App\\Http\\Controllers\\LocalizationController::class, \'switch\'])-&gt;name(\'localization.switch\');</code></pre>\r\n<p><strong>Oke back end semuanya sudah jadi, sekarang kita masuk ke front end.</strong></p>\r\n<p>7. buka folder lang di directory <em>resources &gt; lang. </em>selanjutnya kita buat folder baru dengan nama id didalam folder lang, jika sudah buat folder id, kita masuk ke folder en dulu kita buat file dengan <em>localization.php.&nbsp;</em>dan juga di folder id kita buat file <em>localization.php.&nbsp;</em>selanjutnya copy code berikut.</p>\r\n<pre><code class=\"language-php\" data-prismjs-copy=\"Copy to Clipboard!\">&lt;?php\r\n\r\n// ini untuk file localization.php di dalam folder lang --&gt; en\r\nreturn [\r\n   \"id\" =&gt; \"Indonesian\",\r\n   \"en\" =&gt; \"English\".\r\n]\r\n\r\n// ini untuk file localization.php di dalam folder lang &gt; id\r\nreturn [\r\n   \"id\" =&gt; \"Bahasa Indonesia\",\r\n   \"en\" =&gt; \"Inggris\".\r\n]</code></pre>\r\n<p>8. kita buka file <em>welcome.blade.php</em> di directory&nbsp;<em>resources &gt; views &gt; welcome.blade.php&nbsp;</em>Hapus semua atau jadikan komentar,&nbsp; bebas seterah kalian dan copy code dibawah ini.</p>\r\n<pre><code class=\"language-html\" data-prismjs-copy=\"Copy to Clipboard!\">&lt;!DOCTYPE html&gt;\r\n&lt;html lang=\"{{ str_replace(\'_\', \'-\', app()-&gt;getLocale()) }}\"&gt;\r\n\r\n&lt;head&gt;\r\n\r\n    &lt;meta charset=\"UTF-8\"&gt;\r\n    &lt;meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"&gt;\r\n    &lt;meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\"&gt;\r\n    &lt;title&gt;Multi Language&lt;/title&gt;\r\n\r\n    &lt;link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css\" rel=\"stylesheet\"\r\n        integrity=\"sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU\" crossorigin=\"anonymous\"&gt;\r\n    &lt;link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css\"\r\n        integrity=\"sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==\"\r\n        crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\" /&gt;\r\n\r\n&lt;/head&gt;\r\n\r\n&lt;body&gt;\r\n\r\n    &lt;nav class=\"sb-topnav navbar navbar-expand navbar-dark bg-dark\"&gt;\r\n        &lt;a class=\"navbar-brand\" href=\"#\"&gt;\r\n            Multi Language\r\n        &lt;/a&gt;\r\n\r\n        &lt;button class=\"btn btn-link btn-sm order-1 order-lg-0\" id=\"sidebarToggle\" href=\"#\"&gt;\r\n            &lt;i class=\"fas fa-bars\"&gt;&lt;/i&gt;\r\n        &lt;/button&gt;\r\n\r\n        &lt;ul class=\"navbar-nav ml-auto\"&gt;\r\n            &lt;li class=\"nav-item dropdown\"&gt;\r\n                &lt;a class=\"nav-link dropdown-toggle\" id=\"language\" href=\"#\" role=\"button\" data-toggle=\"dropdown\"\r\n                    aria-haspopup=\"true\" aria-expanded=\"false\"&gt;\r\n                    @switch(app()-&gt;getLocale())\r\n                        @case(\'id\')\r\n                            &lt;span&gt;IND&lt;/span&gt;\r\n                        @break\r\n                        @case(\'en\')\r\n                            &lt;span&gt;ENG&lt;/span&gt;\r\n                        @break\r\n                        @default\r\n                    @endswitch\r\n                &lt;/a&gt;\r\n                &lt;div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"language\"&gt;\r\n                    &lt;a class=\"dropdown-item\"\r\n                        href=\"{{ route(\'localization.switch\', [\'language\' =&gt; \'id\']) }}\"&gt;{{ trans(\'localization.id\') }}&lt;/a&gt;\r\n                    &lt;a class=\"dropdown-item\"\r\n                        href=\"{{ route(\'localization.switch\', [\'language\' =&gt; \'en\']) }}\"&gt;{{ trans(\'localization.en\') }}&lt;/a&gt;\r\n                &lt;/div&gt;\r\n            &lt;/li&gt;\r\n        &lt;/ul&gt;\r\n    &lt;/nav&gt;\r\n\r\n    &lt;script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js\"\r\n        integrity=\"sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ\" crossorigin=\"anonymous\"&gt;\r\n    &lt;/script&gt;\r\n\r\n&lt;/body&gt;\r\n\r\n&lt;/html&gt;</code></pre>\r\n<div>dan finish!</div>\r\n<div>&nbsp;</div>\r\n<div>oke jadi kesimpulannya yaitu didalam element <code class=\"language-html\">&lt;html&gt;</code> harus ditambahkan tag <code class=\"language-html\">lang </code>&nbsp;yang berisi <code class=\"language-php\">{{ str_replace(\'_\', \'-\', app()-&gt;getLocale()) }}</code> , kenapa dikasih ini? karena untuk mengganti language nya. ketika kamu memilih bahasa indonesia maka diganti jadi <code class=\"language-php\">lang=\"id\"</code> dan sebaliknya juga, itu bagian terpentingnya dalam membuat multi language ini.</div>\r\n<div>&nbsp;</div>\r\n<div>Jika kalian mau menambahkan paragraf lagi kalian harus membuatnya manual di folder lang, dan ingat nama objeknya/file harus sama, contoh:</div>\r\n<div>kita akan membuat paragraf baru, misal tentang <em>about me&nbsp;</em>untuk membuat teks language baru..</div>\r\n<pre><code class=\"language-php\" data-prismjs-copy=\"Copy to Clipboard!\">&lt;?php\r\n/*\r\nini about me paragraf dengan menggunakan bahasa inggris.\r\n*/ \r\nreturn [\r\n   \"aboutme\" =&gt; \"hello, my name is angga\",\r\n]</code></pre>\r\n<pre><code class=\"language-php\" data-prismjs-copy=\"Copy to Clipboard!\">&lt;?php\r\n/*\r\nini about me paragraf dengan menggunakan bahasa indonesia.\r\n*/ \r\nreturn [\r\n   \"aboutme\" =&gt; \"halo, nama aku angga\",\r\n]</code></pre>\r\n<blockquote>\r\n<p><strong>NOTE :</strong></p>\r\n<p style=\"text-align: justify;\">untuk membuat paragraf baru menggunakan bahasa inggris kalian harus membuatnya di folder <em>lang &gt; en,&nbsp;</em>sedangkan bahasa indonesia jika kalian belum mempunyai folder untuk menggunakan atau membuat bahasa indonesia, kalian harus membuat folder dengan nama \"id\" di dalam folder lang.</p>\r\n</blockquote>\r\n<p>Jika kalian sudah membuatnya, kalian tinggal panggil languagenya, cara panggilnya yaitu dengan menggunakan blade trans.</p>\r\n<pre><code class=\"language-php\" data-prismjs-copy=\"Copy to Clipboard!\">{{ trans(\'about.aboutme\') }}</code></pre>\r\n<blockquote>\r\n<p>Q : about itu yang mana dan kalo aboutme itu yang mana?</p>\r\n<p>A : about itu nama filenya, sedangkan aboutme itu objeknya yang sudah kita buat tadi.</p>\r\n<p>&nbsp;</p>\r\n<p>{{ trans(\'<em>namafile</em>.<em>namaobjek</em>\') }}</p>\r\n</blockquote>\r\n<p>jadi begitu cara buat atau menambahkan languagenya, jika kalian belum mengerti kalian bisa komen dibawah ini.. Semoga bermanfaat !!</p>', 'publish', 'membuat multi language, membuat translate, multi language laravel, multi language laravel 8', '2022-06-02 06:08:46', '2022-06-02 13:33:29', 2, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_tag`
--

CREATE TABLE `post_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_tag`
--

INSERT INTO `post_tag` (`id`, `post_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2022-06-02 05:17:12', '2022-06-02 05:17:12'),
(2, 1, 1, '2022-06-02 05:17:12', '2022-06-02 05:17:12'),
(3, 1, 2, '2022-06-02 05:17:12', '2022-06-02 05:17:12'),
(4, 2, 3, '2022-06-02 05:29:19', '2022-06-02 05:29:19'),
(5, 2, 1, '2022-06-02 05:29:19', '2022-06-02 05:29:19'),
(6, 2, 2, '2022-06-02 05:29:19', '2022-06-02 05:29:19'),
(7, 3, 4, '2022-06-02 06:08:46', '2022-06-02 06:08:46'),
(8, 3, 5, '2022-06-02 06:14:12', '2022-06-02 06:14:12');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Mimin', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(2, 'Admin', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(3, 'Editor', 'web', '2022-06-02 03:42:23', '2022-06-02 03:42:23');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(24, 2),
(25, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `title`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'HTML', 'html', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(2, 'CSS', 'css', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(3, 'Javascript', 'javascript', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(4, 'PHP', 'php', '2022-06-02 03:42:23', '2022-06-02 03:42:23'),
(5, 'Laravel', 'laravel', '2022-06-02 06:13:58', '2022-06-02 06:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `tutorials`
--

CREATE TABLE `tutorials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tutorial_post`
--

CREATE TABLE `tutorial_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tutorial_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `bio` text COLLATE utf8mb4_unicode_ci,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `user_image`, `bio`, `twitter`, `github`, `instagram`, `facebook`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `slug`) VALUES
(1, 'Kanzan', 'kanzan@gmail.com', 'default.png', NULL, NULL, NULL, NULL, NULL, '2022-06-02 03:42:23', '$2y$10$Z0IFF1oL1gc4YvxzB49mNeVTejXQrdXQq3ExNjFulf24rkFVyVaH6', 'ArzNxYmYVZ', '2022-06-02 03:42:23', '2022-06-02 03:42:23', 'kanzan'),
(2, 'Zexpher', 'zexpher@gmail.com', 'USER-6298447984a1f3.50997738.jpg', 'Sleep > Eat > Ngoding > Repeat', NULL, 'https://github.com/fahrianggara', 'https://www.instagram.com/f.anggae/', NULL, '2022-06-02 03:42:23', '$2y$10$Sb.nwpBLX.aRiI82xcZ5n.f1Vo78rY/Ibe19Bz.JpqfBXn91wzG.2', 'zJFYzFqrZ47wC4AXjny1KNkZekMpjzwWJY1RvpSiR5BU6cWpn129X04WjrPU', '2022-06-02 03:42:23', '2022-06-02 05:03:32', 'zexpher'),
(3, 'Denzel', 'denzel@gmail.com', 'avatar.png', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$Vfk/1JeLY8V1ebXcALlXXuf6OlSgyDWfck3ublGHjGl.KSaxXc3ia', NULL, '2022-06-02 04:12:56', '2022-06-02 04:12:56', 'denzel');

-- --------------------------------------------------------

--
-- Table structure for table `web_settings`
--

CREATE TABLE `web_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_description` text COLLATE utf8mb4_unicode_ci,
  `site_footer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_github` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_banner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_settings`
--

INSERT INTO `web_settings` (`id`, `site_name`, `site_description`, `site_footer`, `site_email`, `site_twitter`, `site_github`, `meta_keywords`, `image_banner`, `created_at`, `updated_at`) VALUES
(1, 'KanzanKazu', 'Website Sederhana dengan seputar web development, serta berbagi source code, diskusi maupun tutorial lainnya.', '© 2022 KanzanKazu.', 'kanzankazu@protonmail.com', 'https://twitter.com/kanzankazu', 'https://github.com/kanzankazu', 'kanzankazu, kanzan, kazu', 'BANNER-62983f34db13c8.02079568.svg', NULL, '2022-06-02 15:58:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `category_post`
--
ALTER TABLE `category_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_post_category_id_foreign` (`category_id`),
  ADD KEY `category_post_post_id_foreign` (`post_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_commenter_id_commenter_type_index` (`commenter_id`,`commenter_type`),
  ADD KEY `comments_commentable_type_commentable_id_index` (`commentable_type`,`commentable_id`),
  ADD KEY `comments_child_id_foreign` (`child_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_messages`
--
ALTER TABLE `email_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_tag_post_id_foreign` (`post_id`),
  ADD KEY `post_tag_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`);

--
-- Indexes for table `tutorials`
--
ALTER TABLE `tutorials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tutorials_slug_unique` (`slug`);

--
-- Indexes for table `tutorial_post`
--
ALTER TABLE `tutorial_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tutorial_post_tutorial_id_foreign` (`tutorial_id`),
  ADD KEY `tutorial_post_post_id_foreign` (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `web_settings`
--
ALTER TABLE `web_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category_post`
--
ALTER TABLE `category_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_messages`
--
ALTER TABLE `email_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post_tag`
--
ALTER TABLE `post_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tutorials`
--
ALTER TABLE `tutorials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tutorial_post`
--
ALTER TABLE `tutorial_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `web_settings`
--
ALTER TABLE `web_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_post`
--
ALTER TABLE `category_post`
  ADD CONSTRAINT `category_post_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_post_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tutorial_post`
--
ALTER TABLE `tutorial_post`
  ADD CONSTRAINT `tutorial_post_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tutorial_post_tutorial_id_foreign` FOREIGN KEY (`tutorial_id`) REFERENCES `tutorials` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
