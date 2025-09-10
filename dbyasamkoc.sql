-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 01:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbyasamkocu`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblalan`
--

CREATE TABLE `tblalan` (
  `alan_id` int(11) NOT NULL,
  `alan_isim` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `tblalan`
--

INSERT INTO `tblalan` (`alan_id`, `alan_isim`) VALUES
(2, 'Sağlık ve Spor Koçu'),
(3, 'YKS Koçu'),
(4, 'Yaşam ve İş Koçu');

-- --------------------------------------------------------

--
-- Table structure for table `tblkoclar`
--

CREATE TABLE `tblkoclar` (
  `koc_id` int(11) NOT NULL,
  `ad` varchar(30) NOT NULL,
  `soyad` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `telefonNo` varchar(15) NOT NULL,
  `alan_id` int(11) NOT NULL,
  `aciklama` varchar(250) NOT NULL,
  `url` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `tblkoclar`
--

INSERT INTO `tblkoclar` (`koc_id`, `ad`, `soyad`, `email`, `telefonNo`, `alan_id`, `aciklama`, `url`) VALUES
(1, 'Emirhan', 'Yılmaz', 'emirhan.yilmaz@example.com', '0544 239 3323', 2, 'Fiziksel ve zihinsel sağlığınızı iyileştirmek için çalışır. Egzersiz, beslenme ve stres yönetimi konularında sağlıklı alışkanlıklar kazanmanıza yardımcı olur.', 'images/staff-1.jpg'),
(3, 'Baran', ' Demir', 'baran.demir@example.com', '0523 239 3321', 3, 'Öğrencinin akademik hedeflerini belirlemesine, zaman yönetimi yapmasına, ders programı oluşturmasına ve motivasyonunu yüksek tutmasına destek olur. ', 'images/staff-3.jpg'),
(4, 'Kaan ', 'Arslan', 'kaan.arslan@example.com', '0544 123 3323', 4, 'Hayatınızda ve işinizde daha fazla tatmin ve başarı elde etmek isteyenlere yol gösterir. Kendinizi daha iyi tanımanızı sağlar', 'images/staff-4.jpg'),
(5, 'Ali', 'Çelik', 'ali.celik@example.com', '0556 639 3323', 2, 'Egzersiz, beslenme, uyku düzeni ve stres yönetimi konularında kişiye özel planlar hazırlayarak sağlıklı bir yaşam tarzı benimsemenize yardımcı olur. Zihinsel sağlığınızı güçlendirmek için gereken motivasyonu sunar.', 'images/staff-5.jpg'),
(7, 'Semih', 'Polat', 'semih.polat@example.com', '0523 239 1111', 3, 'Üniversite sınavına hazırlık sürecinde öğrencilerime rehberlik ederek hedeflerine ulaşmalarını sağlıyorum. Motivasyon, zaman yönetimi ve etkili çalışma stratejileriyle onların yanındayım. ', 'images/staff-7.jpg'),
(8, 'Emre', 'Aydın', 'emre.aydin@example.com', '0534 451 3323', 4, 'İş ve kişisel yaşam arasında denge kurmanıza yardımcı olur. Kariyer hedeflerinizle birlikte yaşam kalitenizi de iyileştirebilmeniz için gerekli stratejiler sunar.', 'images/staff-8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tblrandevu`
--

CREATE TABLE `tblrandevu` (
  `kullanici_id` int(11) NOT NULL,
  `ad_soyad` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `koc_alan` varchar(50) NOT NULL,
  `koc_isim` varchar(100) NOT NULL,
  `olusturulma_tarihi` datetime NOT NULL,
  `randevu_tarihi` datetime NOT NULL,
  `musteri_notu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `tblrandevu`
--

INSERT INTO `tblrandevu` (`kullanici_id`, `ad_soyad`, `email`, `telefon`, `koc_alan`, `koc_isim`, `olusturulma_tarihi`, `randevu_tarihi`, `musteri_notu`) VALUES
(7, 'Ahmet Arslan', 'Ahmedarslan@hotmail.com', '05333929632', '3', '7', '2025-01-04 14:52:11', '2025-01-05 17:52:00', 'Acilen ders çalışmam lazım'),
(8, 'ahmed arslan', 'Ahmedarslan@hotmail.com', '05373929632', '2', '5', '2025-01-04 14:52:58', '2025-01-05 18:54:00', 'Sporda yardım lazım '),
(9, 'deneme', 'deneme@4rt', 'deneme', '3', '7', '2025-01-05 13:18:25', '2025-01-04 18:21:00', 'deneme');

-- --------------------------------------------------------

--
-- Table structure for table `tblreferanslar`
--

CREATE TABLE `tblreferanslar` (
  `id` int(11) NOT NULL,
  `ad` varchar(15) NOT NULL,
  `soyad` varchar(15) NOT NULL,
  `yorum` varchar(350) NOT NULL,
  `url` varchar(150) NOT NULL,
  `pozisyon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `tblreferanslar`
--

INSERT INTO `tblreferanslar` (`id`, `ad`, `soyad`, `yorum`, `url`, `pozisyon`) VALUES
(1, 'Mete', 'Yılmaz', 'Yaşam koçumla çalışmaya başladıktan sonra, hedeflerime ulaşmada büyük bir adım attım. Hem kişisel hem de profesyonel hayatımda daha fazla odaklanmaya ve dengeli bir yaşam sürmeye başladım. Her seans beni bir adım daha ileriye taşıdı.', 'images/person_1.jpg', 'Pazarlama Müdürü'),
(2, 'Sami', 'Yalın', 'Yaşam koçum, bana sadece rehberlik etmekle kalmadı, aynı zamanda kendimi keşfetmemi ve potansiyelimi en iyi şekilde kullanmamı sağladı. Onun desteğiyle, yaşamımda önemli değişiklikler yapmayı başardım.', 'images/person_2.jpg', 'Pazarlama Müdürü'),
(3, 'Emirhan', 'Aydın', 'Kariyerimde karşılaştığım zorluklarla başa çıkmamı sağladı. Yaşam koçumun rehberliği sayesinde, artık iş hayatımda daha özgüvenli ve odaklıyım. Kendimi daha güçlü hissediyorum ve geleceğe dair net bir planım var.', 'images/person_3.jpg', 'Pazarlama Müdürü'),
(4, 'Murat', 'Demir', 'Birçok alanda hayatımı yeniden şekillendirmemi sağlayan koçluk deneyimim, çok değerli oldu. Yaşam koçum, bana nasıl daha iyi kararlar verebileceğimi ve zorlukların üstesinden nasıl gelebileceğimi gösterdi.', 'images/person_3.jpg', 'Girişimci'),
(5, 'Onur', 'Can', 'Yaşam koçumla çalışmak, bana sadece motivasyon değil, aynı zamanda yaşamımda istikrar ve denge sağlamak için gerekli stratejileri de öğretti. Hedeflerimi netleştirip, onlara ulaşmak için güvenle adımlar atabiliyorum.', 'images/person_2.jpg', 'Pazarlama Müdürü');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblalan`
--
ALTER TABLE `tblalan`
  ADD PRIMARY KEY (`alan_id`);

--
-- Indexes for table `tblkoclar`
--
ALTER TABLE `tblkoclar`
  ADD PRIMARY KEY (`koc_id`),
  ADD KEY `fk_alan_id` (`alan_id`);

--
-- Indexes for table `tblrandevu`
--
ALTER TABLE `tblrandevu`
  ADD PRIMARY KEY (`kullanici_id`);

--
-- Indexes for table `tblreferanslar`
--
ALTER TABLE `tblreferanslar`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblalan`
--
ALTER TABLE `tblalan`
  MODIFY `alan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblkoclar`
--
ALTER TABLE `tblkoclar`
  MODIFY `koc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblrandevu`
--
ALTER TABLE `tblrandevu`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblreferanslar`
--
ALTER TABLE `tblreferanslar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblkoclar`
--
ALTER TABLE `tblkoclar`
  ADD CONSTRAINT `fk_alan_id` FOREIGN KEY (`alan_id`) REFERENCES `tblalan` (`alan_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE tblsayfalar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sayfa_adi VARCHAR(100) NOT NULL,
    icerik TEXT NOT NULL
);

INSERT INTO tblsayfalar (sayfa_adi, icerik) VALUES
('index', '<h1>Ana Sayfa İçeriği</h1>'),
('about', '<h1>Hakkımızda İçeriği</h1>'),
('services', '<h1>Hizmetler İçeriği</h1>'),
('contact', '<h1>İletişim İçeriği</h1>');
