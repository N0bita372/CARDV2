-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 17, 2022 at 10:43 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yhostdic_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `stk` text NOT NULL,
  `name` text NOT NULL,
  `bank_name` text NOT NULL,
  `chi_nhanh` text NOT NULL,
  `logo` text,
  `ghichu` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `stk`, `name`, `bank_name`, `chi_nhanh`, `logo`, `ghichu`) VALUES
(5, '106868238271', 'Vietinbank Auto', 'NGUYEN TAN THANH', 'Tây Ninh', 'https://i.imgur.com/5lONuYM.png', 'Vui lòng nhập đúng nội dung khi chuyển khoản.\r\n'),
(7, '10002325589898', 'Vietcombank Auto', 'NGUYEN TAN THANH', 'Tay Ninh', 'https://i.imgur.com/9wOUZTv.png', 'Nhập đúng nội dung, cộng tiền ngay'),
(9, '0947838128', 'MoMo Auto', 'NGUYEN TAN THANH', '', 'https://i.imgur.com/BoGl5TM.png', 'Nhập đúng nội dung, cộng tiền sau 30s - 60s');

-- --------------------------------------------------------

--
-- Table structure for table `bank_auto`
--

CREATE TABLE `bank_auto` (
  `id` int(11) NOT NULL,
  `tid` varchar(64) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_vietnamese_ci,
  `amount` int(11) DEFAULT '0',
  `cusum_balance` int(11) DEFAULT '0',
  `time` datetime DEFAULT NULL,
  `bank_sub_acc_id` varchar(64) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `username` varchar(64) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `block_callback`
--

CREATE TABLE `block_callback` (
  `id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `reason` text COLLATE utf8_vietnamese_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_vietnamese_ci,
  `time` datetime DEFAULT NULL,
  `thoigian` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `view` int(11) DEFAULT NULL,
  `img` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `display` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `card_auto`
--

CREATE TABLE `card_auto` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `loaithe` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `menhgia` int(11) DEFAULT NULL,
  `thucnhan` int(11) DEFAULT NULL,
  `thoigian` datetime DEFAULT NULL,
  `capnhat` datetime DEFAULT NULL,
  `trangthai` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `ghichu` text COLLATE utf8_vietnamese_ci,
  `server` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `seri` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `pin` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `callback` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `request_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `card_auto`
--

INSERT INTO `card_auto` (`id`, `code`, `username`, `loaithe`, `menhgia`, `thucnhan`, `thoigian`, `capnhat`, `trangthai`, `ghichu`, `server`, `seri`, `pin`, `callback`, `request_id`, `amount`) VALUES
(10019, '9587163204', 'admin', 'VIETTEL', 20000, 20000, '2021-09-04 04:01:06', NULL, 'xuly', 'the ko hop le hoacsai', 'https://autocard365.com/', '10006139522454', '114142564423544', NULL, NULL, NULL),
(10020, '3065978214', 'admin', 'VINAPHONE', 20000, 20000, '2021-09-04 04:01:45', '2021-09-04 05:04:59', 'hoantat', '', 'https://autocard365.com/', '1242421412442', '14124124124242', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chuyentien`
--

CREATE TABLE `chuyentien` (
  `id` int(11) NOT NULL,
  `nguoinhan` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `nguoichuyen` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `sotien` int(11) DEFAULT NULL,
  `thoigian` datetime DEFAULT NULL,
  `lydo` text COLLATE utf8_vietnamese_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ck_card_auto`
--

CREATE TABLE `ck_card_auto` (
  `id` int(11) NOT NULL,
  `loaithe` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `menhgia` int(11) DEFAULT NULL,
  `ck` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `ck_card_auto`
--

INSERT INTO `ck_card_auto` (`id`, `loaithe`, `menhgia`, `ck`) VALUES
(1, 'VIETTEL', 10000, 20),
(2, 'VIETTEL', 20000, 20),
(3, 'VIETTEL', 30000, 20),
(4, 'VIETTEL', 50000, 20),
(5, 'VIETTEL', 100000, 20),
(6, 'VIETTEL', 200000, 20),
(7, 'VIETTEL', 300000, 20),
(8, 'VIETTEL', 500000, 20),
(9, 'VIETTEL', 1000000, 20),
(10, 'VINAPHONE', 10000, 20),
(11, 'VINAPHONE', 20000, 20),
(12, 'VINAPHONE', 30000, 20),
(13, 'VINAPHONE', 50000, 20),
(14, 'VINAPHONE', 100000, 20),
(15, 'VINAPHONE', 200000, 20),
(16, 'VINAPHONE', 300000, 20),
(17, 'VINAPHONE', 500000, 20),
(18, 'VINAPHONE', 1000000, 20),
(19, 'MOBIFONE', 10000, 20),
(20, 'MOBIFONE', 20000, 20),
(21, 'MOBIFONE', 30000, 20),
(22, 'MOBIFONE', 50000, 20),
(23, 'MOBIFONE', 100000, 20),
(24, 'MOBIFONE', 200000, 20),
(25, 'MOBIFONE', 300000, 20),
(26, 'MOBIFONE', 500000, 20),
(27, 'MOBIFONE', 1000000, 20),
(28, 'ZING', 10000, 20),
(29, 'ZING', 20000, 20),
(30, 'ZING', 30000, 20),
(31, 'ZING', 50000, 20),
(32, 'ZING', 100000, 20),
(33, 'ZING', 200000, 20),
(34, 'ZING', 300000, 20),
(35, 'ZING', 500000, 20),
(36, 'ZING', 1000000, 20),
(37, 'VNMOBI', 10000, 20),
(38, 'VNMOBI', 20000, 20),
(39, 'VNMOBI', 30000, 20),
(40, 'VNMOBI', 50000, 20),
(41, 'VNMOBI', 100000, 20),
(42, 'VNMOBI', 200000, 20),
(43, 'VNMOBI', 300000, 20),
(44, 'VNMOBI', 500000, 20),
(45, 'VNMOBI', 1000000, 20);

-- --------------------------------------------------------

--
-- Table structure for table `ck_card_auto_diamond`
--

CREATE TABLE `ck_card_auto_diamond` (
  `id` int(11) NOT NULL,
  `loaithe` varchar(255) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `menhgia` int(11) NOT NULL DEFAULT '0',
  `ck` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `ck_card_auto_diamond`
--

INSERT INTO `ck_card_auto_diamond` (`id`, `loaithe`, `menhgia`, `ck`) VALUES
(1, 'VIETTEL', 10000, 18),
(2, 'VIETTEL', 20000, 18),
(3, 'VIETTEL', 30000, 18),
(4, 'VIETTEL', 50000, 18),
(5, 'VIETTEL', 100000, 18),
(6, 'VIETTEL', 200000, 18),
(7, 'VIETTEL', 300000, 18),
(8, 'VIETTEL', 500000, 18),
(9, 'VIETTEL', 1000000, 18),
(10, 'VINAPHONE', 10000, 18),
(11, 'VINAPHONE', 20000, 18),
(12, 'VINAPHONE', 30000, 18),
(13, 'VINAPHONE', 50000, 18),
(14, 'VINAPHONE', 100000, 18),
(15, 'VINAPHONE', 200000, 18),
(16, 'VINAPHONE', 300000, 18),
(17, 'VINAPHONE', 500000, 18),
(18, 'VINAPHONE', 1000000, 18),
(19, 'MOBIFONE', 10000, 18),
(20, 'MOBIFONE', 20000, 18),
(21, 'MOBIFONE', 30000, 18),
(22, 'MOBIFONE', 50000, 18),
(23, 'MOBIFONE', 100000, 18),
(24, 'MOBIFONE', 200000, 18),
(25, 'MOBIFONE', 300000, 18),
(26, 'MOBIFONE', 500000, 18),
(27, 'MOBIFONE', 1000000, 18),
(28, 'ZING', 10000, 18),
(29, 'ZING', 20000, 18),
(30, 'ZING', 30000, 18),
(31, 'ZING', 50000, 18),
(32, 'ZING', 100000, 18),
(33, 'ZING', 200000, 18),
(34, 'ZING', 300000, 18),
(35, 'ZING', 500000, 18),
(36, 'ZING', 1000000, 18),
(37, 'VNMOBI', 10000, 18),
(38, 'VNMOBI', 20000, 18),
(39, 'VNMOBI', 30000, 18),
(40, 'VNMOBI', 50000, 18),
(41, 'VNMOBI', 100000, 18),
(42, 'VNMOBI', 200000, 18),
(43, 'VNMOBI', 300000, 18),
(44, 'VNMOBI', 500000, 18),
(45, 'VNMOBI', 1000000, 18);

-- --------------------------------------------------------

--
-- Table structure for table `ck_card_auto_platinum`
--

CREATE TABLE `ck_card_auto_platinum` (
  `id` int(11) NOT NULL,
  `loaithe` varchar(255) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `menhgia` int(11) NOT NULL DEFAULT '0',
  `ck` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `ck_card_auto_platinum`
--

INSERT INTO `ck_card_auto_platinum` (`id`, `loaithe`, `menhgia`, `ck`) VALUES
(1, 'VIETTEL', 10000, 19),
(2, 'VIETTEL', 20000, 19),
(3, 'VIETTEL', 30000, 19),
(4, 'VIETTEL', 50000, 19),
(5, 'VIETTEL', 100000, 19),
(6, 'VIETTEL', 200000, 19),
(7, 'VIETTEL', 300000, 19),
(8, 'VIETTEL', 500000, 19),
(9, 'VIETTEL', 1000000, 19),
(10, 'VINAPHONE', 10000, 19),
(11, 'VINAPHONE', 20000, 19),
(12, 'VINAPHONE', 30000, 19),
(13, 'VINAPHONE', 50000, 19),
(14, 'VINAPHONE', 100000, 19),
(15, 'VINAPHONE', 200000, 19),
(16, 'VINAPHONE', 300000, 19),
(17, 'VINAPHONE', 500000, 19),
(18, 'VINAPHONE', 1000000, 19),
(19, 'MOBIFONE', 10000, 19),
(20, 'MOBIFONE', 20000, 19),
(21, 'MOBIFONE', 30000, 19),
(22, 'MOBIFONE', 50000, 19),
(23, 'MOBIFONE', 100000, 19),
(24, 'MOBIFONE', 200000, 19),
(25, 'MOBIFONE', 300000, 19),
(26, 'MOBIFONE', 500000, 19),
(27, 'MOBIFONE', 1000000, 19),
(28, 'ZING', 10000, 19),
(29, 'ZING', 20000, 19),
(30, 'ZING', 30000, 19),
(31, 'ZING', 50000, 19),
(32, 'ZING', 100000, 19),
(33, 'ZING', 200000, 19),
(34, 'ZING', 300000, 19),
(35, 'ZING', 500000, 19),
(36, 'ZING', 1000000, 19),
(37, 'VNMOBI', 10000, 19),
(38, 'VNMOBI', 20000, 19),
(39, 'VNMOBI', 30000, 19),
(40, 'VNMOBI', 50000, 19),
(41, 'VNMOBI', 100000, 19),
(42, 'VNMOBI', 200000, 19),
(43, 'VNMOBI', 300000, 19),
(44, 'VNMOBI', 500000, 19),
(45, 'VNMOBI', 1000000, 19);

-- --------------------------------------------------------

--
-- Table structure for table `dongtien`
--

CREATE TABLE `dongtien` (
  `id` int(11) NOT NULL,
  `sotientruoc` int(11) DEFAULT NULL,
  `sotienthaydoi` int(11) DEFAULT NULL,
  `sotiensau` int(11) DEFAULT NULL,
  `thoigian` datetime DEFAULT NULL,
  `noidung` text COLLATE utf8_vietnamese_ci,
  `username` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `dongtien`
--

INSERT INTO `dongtien` (`id`, `sotientruoc`, `sotienthaydoi`, `sotiensau`, `thoigian`, `noidung`, `username`) VALUES
(189, 0, 1000000, 1000000, '2021-06-28 15:26:51', 'Admin thay đổi số dư ', 'admin'),
(190, 1000000, 20000, 1020000, '2021-09-04 05:04:59', 'Đổi thẻ seri (1242421412442)', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `listbank`
--

CREATE TABLE `listbank` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `sotaikhoan` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `chutaikhoan` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `nganhang` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `chinhanh` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `loaithe`
--

CREATE TABLE `loaithe` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `ck` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `loaithe`
--

INSERT INTO `loaithe` (`id`, `type`, `ck`, `status`) VALUES
(1, 'VIETTEL', 21, 1),
(2, 'VINAPHONE', 21, 1),
(3, 'MOBIFONE', 23, 1),
(4, 'GATE', 31, 1),
(5, 'ZING', 18, 1),
(6, 'VNMOBI', 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `momo`
--

CREATE TABLE `momo` (
  `id` int(11) NOT NULL,
  `request_id` varchar(64) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `tranId` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `partnerId` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `partnerName` text CHARACTER SET utf16 COLLATE utf16_vietnamese_ci,
  `amount` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci,
  `comment` text CHARACTER SET utf8 COLLATE utf8_vietnamese_ci,
  `time` datetime DEFAULT NULL,
  `username` varchar(32) CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `status` varchar(32) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT 'xuly'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `muathe`
--

CREATE TABLE `muathe` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `Telco` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `Serial` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `PinCode` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `Amount` int(11) DEFAULT NULL,
  `Trace` int(11) DEFAULT NULL,
  `gettime` datetime DEFAULT NULL,
  `time` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `value` longtext COLLATE utf8_vietnamese_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name`, `value`) VALUES
(1, 'tenweb', 'CMSNT.CO'),
(2, 'mota', 'Hệ thống đổi thẻ cào sang tiền mặt phí tốt nhất thị trường - tự động xử lý thẻ trong vài giây!'),
(3, 'tukhoa', 'card24h, doi the, trum the, đổi thẻ cào sang tiền mặt, doi the sieu nhanh, the sieu re, doi the nhanh, doi the cao sang tien mat, card24, card exchange, tst, tsr, tsn, doicardnhanh, doi thẻ cào, trum the cào, đổi thẻ giá rẻ, mua thẻ cào giá rẻ, mua thẻ cào, card online, card giá rẻ'),
(4, 'logo', 'https://i.imgur.com/ZeJ8zsO.png'),
(5, 'email', ''),
(6, 'pass_email', ''),
(11, 'noidung_naptien', 'NAPTIEN_'),
(12, 'thongbao', '<p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 14px;\"><span style=\"font-weight: 700;\">Ưu tiên thẻ Vina,Zing, Vietnammobi đến hết tháng. Viettel và Zing cần điền đúng SERI</span></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 14px;\">- Sai mệnh giá -50%. Hướng dẫn tích hợp API gạch thẻ tự động cho Shop: </p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 14px;\">- TSR nghiêm cấm sử dụng <span style=\"font-weight: 700;\">thẻ cào trộm cắp, lừa đảo</span>. Nếu phát hiện khóa vv</p>'),
(13, 'anhbia', 'https://i.imgur.com/3a1S3In.png'),
(14, 'favicon', 'https://i.imgur.com/61P2d1U.jpg'),
(17, 'baotri', 'ON'),
(18, 'chinhsach', '<p>BẰNG VIỆC SỬ DỤNG C&Aacute;C DỊCH VỤ HOẶC MỞ MỘT T&Agrave;I KHOẢN, BẠN CHO BIẾT RẰNG BẠN CHẤP NHẬN, KH&Ocirc;NG R&Uacute;T LẠI, C&Aacute;C ĐIỀU KHOẢN DỊCH VỤ N&Agrave;Y. NẾU BẠN KH&Ocirc;NG ĐỒNG &Yacute; VỚI C&Aacute;C ĐIỀU KHOẢN N&Agrave;Y, VUI L&Ograve;NG KH&Ocirc;NG SỬ DỤNG C&Aacute;C DỊCH VỤ CỦA CH&Uacute;NG T&Ocirc;I HAY TRUY CẬP TRANG WEB. NẾU BẠN DƯỚI 18 TUỔI HOẶC &quot;ĐỘ TUỔI TRƯỞNG TH&Agrave;NH&quot;PH&Ugrave; HỢP Ở NƠI BẠN SỐNG, BẠN PHẢI XIN PH&Eacute;P CHA MẸ HOẶC NGƯỜI GI&Aacute;M HỘ HỢP PH&Aacute;P ĐỂ MỞ MỘT T&Agrave;I KHOẢN V&Agrave; CHA MẸ HOẶC NGƯỜI GI&Aacute;M HỘ HỢP PH&Aacute;P PHẢI ĐỒNG &Yacute; VỚI C&Aacute;C ĐIỀU KHOẢN DỊCH VỤ N&Agrave;Y. NẾU BẠN KH&Ocirc;NG BIẾT BẠN C&Oacute; THUỘC &quot;ĐỘ TUỔI TRƯỞNG TH&Agrave;NH&quot; Ở NƠI BẠN SỐNG HAY KH&Ocirc;NG, HOẶC KH&Ocirc;NG HIỂU PHẦN N&Agrave;Y, VUI L&Ograve;NG KH&Ocirc;NG TẠO T&Agrave;I KHOẢN CHO ĐẾN KHI BẠN Đ&Atilde; NHỜ CHA MẸ HOẶC NGƯỜI GI&Aacute;M HỘ HỢP PH&Aacute;P CỦA BẠN GI&Uacute;P ĐỠ. NẾU BẠN L&Agrave; CHA MẸ HOẶC NGƯỜI GI&Aacute;M HỘ HỢP PH&Aacute;P CỦA MỘT TRẺ VỊ TH&Agrave;NH NI&Ecirc;N MUỐN TẠO MỘT T&Agrave;I KHOẢN, BẠN PHẢI CHẤP NHẬN C&Aacute;C ĐIỀU KHOẢN DỊCH VỤ N&Agrave;Y THAY MẶT CHO TRẺ VỊ TH&Agrave;NH NI&Ecirc;N Đ&Oacute; V&Agrave; BẠN SẼ CHỊU TR&Aacute;CH NHIỆM ĐỐI VỚI TẤT CẢ HOẠT ĐỘNG SỬ DỤNG T&Agrave;I KHOẢN HAY C&Aacute;C DỊCH VỤ, BAO GỒM C&Aacute;C GIAO DỊCH MUA H&Agrave;NG DO TRẺ VỊ TH&Agrave;NH NI&Ecirc;N THỰC HIỆN, CHO D&Ugrave; T&Agrave;I KHOẢN CỦA TRẺ VỊ TH&Agrave;NH NI&Ecirc;N Đ&Oacute; ĐƯỢC MỞ V&Agrave;O L&Uacute;C N&Agrave;Y HAY ĐƯỢC TẠO SAU N&Agrave;Y V&Agrave; CHO D&Ugrave; TRẺ VỊ TH&Agrave;NH NI&Ecirc;N C&Oacute; ĐƯỢC BẠN GI&Aacute;M S&Aacute;T TRONG GIAO DỊCH MUA H&Agrave;NG Đ&Oacute; HAY KH&Ocirc;NG.</p>\r\n'),
(27, 'min_ruttien', '100000'),
(28, 'ck_con', '3'),
(29, 'phi_chuyentien', '500'),
(30, 'status_chuyentien', 'ON'),
(31, 'hotline', '0947838128'),
(32, 'facebook', 'https://www.facebook.com/ntgtanetwork/'),
(33, 'theme_color', '#0875AC'),
(34, 'modal_thongbao', ''),
(35, 'tk_banthe247', ''),
(36, 'mk_banthe247', ''),
(37, 'status_muathe', 'ON'),
(38, 'status_napdt', 'ON'),
(39, 'ck_500', '3'),
(40, 'partner_id', ''),
(41, 'partner_key', ''),
(42, 'api_bank', 'vuilongthayapi'),
(43, 'status_napbank', 'ON'),
(44, 'status_demo', 'OFF'),
(45, 'api_momo', 'vuilongthayapi'),
(46, 'email_admin', ''),
(47, 'display_carousel', 'ON'),
(48, 'phi_rut_tien', '0'),
(49, 'script_live_chat', ''),
(50, 'token_momo', ''),
(51, 'password_momo', ''),
(52, 'check_time_cron_pay_momo', '0'),
(53, 'check_time_cron_momo', '0'),
(54, 'security_banthe247', ''),
(55, 'dieu_khoan', ''),
(56, 'status_blog', 'OFF'),
(57, 'status_ref', 'OFF'),
(58, 'ck_ref', '1'),
(60, 'luuy_ref', '<ul>\r\n    <li>Những tài khoản được hệ thống xác định là tài khoản sao chép của các tài\r\n        khoản khác sẽ không được dùng để tính hoa hồng.</li>\r\n    <li>Hoa hồng chỉ được tính khi bạn bè của bạn thực hiện đổi thẻ thành công.</li>\r\n    <li>Việc xác định xem ai là người giới thiệu của một người dùng phụ thuộc hoàn\r\n        toàn vào link giới thiệu. Nếu một người dùng nhấp vào nhiều link ref khác\r\n        nhau thì chỉ có link ref cuối cùng họ nhấp vào trước khi tạo tài khoản là có\r\n        hiệu lực.</li>\r\n    <li>Chúng tôi sẽ từ chối trả hoa hồng khi phát hiện bạn cố tình sao chép tài\r\n        khoản để giảm chiết khấu thẻ.</li>\r\n</ul>'),
(61, 'status_trumthe', 'ON'),
(62, 'status_cardvip', 'OFF'),
(63, 'api_cardvip', ''),
(64, 'status_cardv2', 'OFF'),
(65, 'api_cardv2', ''),
(66, 'domain_cardv2', 'https://autocard365.com/'),
(67, 'status_autocard365', 'OFF'),
(68, 'api_autocard365', ''),
(69, 'license_key', 'd98f95640687d09ef7f7a68836dc582d'),
(70, 'btnSaveLicense', ''),
(71, 'status_cardv3', 'OFF'),
(72, 'partner_id_cardv3', ''),
(73, 'partner_key_cardv3', ''),
(74, 'domain_cardv3', ''),
(75, 'status_dtsr11', 'OFF'),
(76, 'api_dtsr11', ''),
(77, 'withdrawal_fee', '0'),
(78, 'border_radius', '6'),
(79, 'phi_rut_tien_ck', '0'),
(80, 'api_card48', ''),
(81, 'status_card48', 'OFF'),
(82, 'api_thecao72', ''),
(83, 'status_thecao72', 'OFF'),
(84, 'api_thecaommo', ''),
(85, 'status_thecaommo', 'OFF'),
(86, 'api_doithe1s', ''),
(87, 'status_doithe1s', 'OFF'),
(88, 'api_payas', ''),
(89, 'status_payas', 'OFF'),
(90, 'server_buycard', '0'),
(91, 'notice_buycard', 'ahaha'),
(92, 'status_cardv4', 'OFF'),
(93, 'api_cardv4', ''),
(94, 'domain_cardv4', ''),
(95, 'status_cardv5', 'OFF'),
(96, 'usercode_cardv5', ''),
(97, 'userpass_cardv5', ''),
(98, 'domain_cardv5', ''),
(99, 'status_doithe365', 'OFF'),
(100, 'api_doithe365', '');

-- --------------------------------------------------------

--
-- Table structure for table `ruttien`
--

CREATE TABLE `ruttien` (
  `id` int(11) NOT NULL,
  `magd` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `sotien` int(11) DEFAULT NULL,
  `thanhtoan` int(11) NOT NULL DEFAULT '0',
  `nganhang` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `sotaikhoan` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `chutaikhoan` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `chinhanh` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `thoigian` datetime DEFAULT NULL,
  `trangthai` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `capnhat` datetime DEFAULT NULL,
  `ghichu` text COLLATE utf8_vietnamese_ci,
  `response` text COLLATE utf8_vietnamese_ci,
  `noidung` text COLLATE utf8_vietnamese_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `sellcards`
--

CREATE TABLE `sellcards` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sellcard_id` int(11) NOT NULL DEFAULT '0',
  `ck` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `storecards`
--

CREATE TABLE `storecards` (
  `id` int(11) NOT NULL,
  `sellcard_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255) DEFAULT NULL,
  `card` text,
  `createdate` datetime NOT NULL,
  `updatedate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `topup`
--

CREATE TABLE `topup` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `sdt` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `loai` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `transaction` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `time` varchar(0) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `gettime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `type_muathe`
--

CREATE TABLE `type_muathe` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `type_muathe`
--

INSERT INTO `type_muathe` (`id`, `type`, `name`) VALUES
(1, 'ZING', 'Zing'),
(2, 'VTT', 'Viettel'),
(3, 'VNP', 'Vinaphone'),
(4, 'GAR', 'Garena'),
(5, 'VNM', 'Vietnammobie'),
(6, 'VMS', 'Mobifone'),
(7, 'VTC', 'Vcoin'),
(8, 'FPT', 'Fpt Gate'),
(9, 'DBM', 'Mobi Data');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `password2` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `money` int(11) NOT NULL DEFAULT '0',
  `level` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `banned` int(11) NOT NULL DEFAULT '0',
  `createdate` datetime DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `ref` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `ref_click` int(11) DEFAULT '0',
  `reason_banned` text COLLATE utf8_vietnamese_ci,
  `agency` int(11) NOT NULL DEFAULT '0',
  `otp` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `time` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `used_money` int(11) NOT NULL DEFAULT '0',
  `total_money` int(11) NOT NULL DEFAULT '0',
  `phone` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `group_excard` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT 'Bronze'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `password2`, `token`, `money`, `level`, `banned`, `createdate`, `email`, `ref`, `ref_click`, `reason_banned`, `agency`, `otp`, `ip`, `time`, `used_money`, `total_money`, `phone`, `fullname`, `group_excard`) VALUES

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `bank_auto`
--
ALTER TABLE `bank_auto`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `block_callback`
--
ALTER TABLE `block_callback`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `card_auto`
--
ALTER TABLE `card_auto`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `chuyentien`
--
ALTER TABLE `chuyentien`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `ck_card_auto`
--
ALTER TABLE `ck_card_auto`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `ck_card_auto_diamond`
--
ALTER TABLE `ck_card_auto_diamond`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ck_card_auto_platinum`
--
ALTER TABLE `ck_card_auto_platinum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dongtien`
--
ALTER TABLE `dongtien`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `listbank`
--
ALTER TABLE `listbank`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `loaithe`
--
ALTER TABLE `loaithe`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `momo`
--
ALTER TABLE `momo`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `muathe`
--
ALTER TABLE `muathe`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `ruttien`
--
ALTER TABLE `ruttien`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `sellcards`
--
ALTER TABLE `sellcards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storecards`
--
ALTER TABLE `storecards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topup`
--
ALTER TABLE `topup`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `type_muathe`
--
ALTER TABLE `type_muathe`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bank_auto`
--
ALTER TABLE `bank_auto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `block_callback`
--
ALTER TABLE `block_callback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `card_auto`
--
ALTER TABLE `card_auto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10021;

--
-- AUTO_INCREMENT for table `chuyentien`
--
ALTER TABLE `chuyentien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ck_card_auto`
--
ALTER TABLE `ck_card_auto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `ck_card_auto_diamond`
--
ALTER TABLE `ck_card_auto_diamond`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `ck_card_auto_platinum`
--
ALTER TABLE `ck_card_auto_platinum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `dongtien`
--
ALTER TABLE `dongtien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `listbank`
--
ALTER TABLE `listbank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `loaithe`
--
ALTER TABLE `loaithe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `momo`
--
ALTER TABLE `momo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muathe`
--
ALTER TABLE `muathe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `ruttien`
--
ALTER TABLE `ruttien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10001;

--
-- AUTO_INCREMENT for table `sellcards`
--
ALTER TABLE `sellcards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `storecards`
--
ALTER TABLE `storecards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topup`
--
ALTER TABLE `topup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_muathe`
--
ALTER TABLE `type_muathe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
