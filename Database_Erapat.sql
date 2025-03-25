-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 05:25 AM
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
-- Database: `erapat`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `schedule_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `invitation_letter` varchar(255) DEFAULT NULL,
  `documentation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id`, `schedule_name`, `date`, `description`, `location`, `invitation_letter`, `documentation`) VALUES
(17, 'Rapat Persiapan Reviu Arsitektur dan Peta Rencana SPBE', '2025-01-08', 'Mempersiapan Reviu Arsitektur dan Peta Rencana SPBE', 'Dinas Komunikasi dan Informatika Kabupaten Bojonegoro Gedung Pemerintahan Kabupaten Bojonegoro Lt.3', 'uploads/invitation_1742868049.pdf', 'uploads/documentation_1742868049.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(11) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`) VALUES
(1, 'Internship at E-Government Division'),
(2, 'Manager'),
(3, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `id` int(11) NOT NULL,
  `id_agenda` int(11) NOT NULL,
  `pimpinan_rapat` varchar(255) NOT NULL,
  `peserta_rapat` text NOT NULL,
  `notulen` varchar(255) NOT NULL,
  `perihal` text NOT NULL,
  `pembahasan` text NOT NULL,
  `kesimpulan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`id`, `id_agenda`, `pimpinan_rapat`, `peserta_rapat`, `notulen`, `perihal`, `pembahasan`, `kesimpulan`, `created_at`, `time`) VALUES
(4, 17, 'Kepala Dinas Komunikasi dan Informatika', '<ol>\r\n<li>Inspektorat</li>\r\n<li>Badan Perencanaan dan Pembangunan Daerah</li>\r\n<li>Bagian Organisasi Setda</li>\r\n<li>Dinas Komunikasi dan Informatika</li>\r\n</ol>', 'Nur Rohmah Hidayatin', '<p>Rapat Persiapan Reviu Arsitektur dan Peta Rencana SPBE</p>', '<ol>\r\n<li>Rapat dibuke oleh Kepala Dinas Komunikasi dan Informatika Kabupaten Bojonegoro.</li>\r\n<li>Menentukan dasar untuk pembuatan Arsitektur dan Peta Rencana SPBE (RPD, RPJMD).</li>\r\n<li>Kebutuhan Reviu dan Input SIA SPBE mutakhir.</li>\r\n</ol>', '<ol>\r\n<li>Ada beberapa hal yang harus dibenahi agar indeks SPBE Kabupaten Bojonegoro belum mendapat predikat memuaskan ( <span style=\"text-decoration: underline;\">&gt;</span>4,2) termasuk melakukan Reviu Arsitektur dan Peta Rencana SPBE.</li>\r\n<li>Peta proses bisnis dan dokumen kebutuhan untuk kebutuhan input SIA SPBE Mutakhir diakomodir Ortala mengingat sebenarnya dokumen kebutuhan SIA SPBE juga merupakan dokumen SAKIP. Jika memungkinkan Pihak ke-3 membuat peta proses bisnis dengan pihak ke-3 input SIA SPBE dapat saling komunikasi.</li>\r\n<li>Mengingat usia RPD hanya sampai 2026 maka dasar pembuatan Arsitektur dan Peta Rencana SPBE dapat menggunakan Visi Misi, RPJMD Teknokratik dan RPJPD 2025-2045.</li>\r\n<li>Hal-hal yang masih kurang/tidak termuat di dokumen lama, melalui reviu ini dapat dilakukan evaluasi sehingga dapat dimuat di dokumen terbaru.</li>\r\n<li>OPD harus dikumpulkan dalam rangka menyiapkan dokumen yang dibutuhkan dalam persiapan SIA SPBE Mutakhir.</li>\r\n<li>Tugas dan Tanggung jawab pihak-pihak terkait</li>\r\n</ol>\r\n<table style=\"border-collapse: collapse; width: 100.072%;\" border=\"1\"><colgroup><col style=\"width: 49.8925%;\"><col style=\"width: 49.8925%;\"></colgroup>\r\n<tbody>\r\n<tr>\r\n<td style=\"text-align: center;\"><strong>PIC</strong></td>\r\n<td style=\"text-align: center;\"><strong>Tugas</strong></td>\r\n</tr>\r\n<tr>\r\n<td>Proses Bisnis Kabupaten</td>\r\n<td>Ortala Setda</td>\r\n</tr>\r\n<tr>\r\n<td>Visi Misi Pemimpin Baru, RPJMD, RPJPD</td>\r\n<td>BAPPEDA</td>\r\n</tr>\r\n<tr>\r\n<td>Reviu</td>\r\n<td>Inspektorat</td>\r\n</tr>\r\n<tr>\r\n<td>Arsitektur dan Peta Rencana SPBE</td>\r\n<td>Dinkominfo</td>\r\n</tr>\r\n<tr>\r\n<td>Proses Bisnis PD dan Dokumen SAKIP untuk input SIA SPBE</td>\r\n<td>OPD</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', '2025-03-25 03:19:44', '09:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `presence`
--

CREATE TABLE `presence` (
  `nip` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `signature` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presence`
--

INSERT INTO `presence` (`nip`, `name`, `schedule_id`, `photo`, `signature`) VALUES
('0', 'MBKM Sistem Informasi UIN Sunan Ampel Surabaya', 17, '1742876632_Bukti Rapat.jpg', 'signature_1742876632.png');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `nip` varchar(20) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `jabatan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`nip`, `nama`, `foto`, `username`, `jabatan_id`) VALUES
('0', 'MBKM Sistem Informasi UIN Sunan Ampel Surabaya', '00.png', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
('0', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_agenda` (`id_agenda`);

--
-- Indexes for table `presence`
--
ALTER TABLE `presence`
  ADD KEY `fk_presence_nip` (`nip`),
  ADD KEY `fk_presence_schedule` (`schedule_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`nip`),
  ADD KEY `fk_profile_users` (`username`),
  ADD KEY `jabatan_id` (`jabatan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`id_agenda`) REFERENCES `agenda` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `presence`
--
ALTER TABLE `presence`
  ADD CONSTRAINT `fk_presence_nip` FOREIGN KEY (`nip`) REFERENCES `profile` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_presence_schedule` FOREIGN KEY (`schedule_id`) REFERENCES `agenda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_profile_users` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
