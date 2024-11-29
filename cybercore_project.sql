-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 04:09 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cybercore_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_fname` varchar(100) NOT NULL COMMENT 'ชื่อลูกค้า',
  `customer_lname` varchar(100) NOT NULL COMMENT 'นามสกุลลุกค้า',
  `customer_telephone` varchar(10) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `c_address` varchar(255) NOT NULL COMMENT 'ที่อยู่',
  `c_email` varchar(100) NOT NULL COMMENT 'อีเมลที่ลงทะเบียน',
  `c_password` varchar(100) NOT NULL COMMENT 'รหัสผ่าน',
  `customer_username` varchar(100) NOT NULL COMMENT 'username ',
  `c_status` varchar(1) NOT NULL COMMENT 'สถานะลูกค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_fname`, `customer_lname`, `customer_telephone`, `c_address`, `c_email`, `c_password`, `customer_username`, `c_status`) VALUES
(1, 'ก้องภพ', 'สุภาวงศ์', '1234567890', '-', 'kongpob@gnail.com', '123456', 'kongpob', '1'),
(2, 'ลูกค้า 1', 'ลูกค้า 1', '1234567890', '-', 'customer@gmail.com', '123456', 'customer1', '1'),
(3, 'customer-2', 'customer-2', '1234567890', '-', 'customer2@gmail.com', '123456', 'customer2', '1');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `employee_fname` varchar(100) NOT NULL COMMENT 'ชื่อพนักงาน',
  `employee_lname` varchar(100) NOT NULL COMMENT 'นามสกุลพนักงาน',
  `employee_username` varchar(100) NOT NULL COMMENT 'username',
  `employee_password` varchar(100) NOT NULL COMMENT 'password',
  `employee_status` varchar(1) NOT NULL COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_fname`, `employee_lname`, `employee_username`, `employee_password`, `employee_status`) VALUES
(1, 'admin-1', 'admin-1', 'admin', '123456', '1');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL COMMENT 'รหัสการสั่งซื้อ',
  `customer_id` int(11) NOT NULL COMMENT 'รหัสผู้สั่งซื้อ',
  `order_date` datetime NOT NULL COMMENT 'วันที่สั่งซื้อ',
  `order_status` varchar(1) NOT NULL COMMENT 'สถานะการสั่งซื้อ',
  `order_details` varchar(255) NOT NULL COMMENT 'รายละเพิ่มเติม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_date`, `order_status`, `order_details`) VALUES
(1, 3, '2024-11-18 22:29:00', '4', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders_detail`
--

CREATE TABLE `orders_detail` (
  `orderdetail_id` int(11) NOT NULL COMMENT 'รหัสการสั่งซื้อสินค้า',
  `order_id` int(11) NOT NULL COMMENT 'รหัสการสั่งซื้อสินค้า',
  `product_id` int(11) NOT NULL COMMENT 'รหัสสินค้า',
  `order_qty` varchar(10) NOT NULL COMMENT 'จำนวนสินค้า',
  `product_price` varchar(10) NOT NULL COMMENT 'ราคาสินค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders_detail`
--

INSERT INTO `orders_detail` (`orderdetail_id`, `order_id`, `product_id`, `order_qty`, `product_price`) VALUES
(1, 1, 1, '1', '13990'),
(2, 1, 2, '1', '17990');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pay_id` int(11) NOT NULL COMMENT 'เลขที่การชำระเงิน',
  `order_id` int(11) NOT NULL COMMENT 'รหัสการสั่งซื้อ',
  `pay_date` date NOT NULL COMMENT 'วันที่ชำระเงิน',
  `pay_total` varchar(20) NOT NULL COMMENT 'ยอดในการชำระ',
  `pay_bank` varchar(100) NOT NULL COMMENT 'ธนาคารที่ชำระ',
  `pay_image` varchar(255) NOT NULL COMMENT 'รูปภาพสลิปในการชำระ',
  `pay_time` time NOT NULL COMMENT 'เวลาที่ทำการชำระ',
  `pay_detail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`pay_id`, `order_id`, `pay_date`, `pay_total`, `pay_bank`, `pay_image`, `pay_time`, `pay_detail`) VALUES
(1, 1, '2024-11-18', '31980', 'kbank', '[\"Cute Cartoon Anime Girl Avatar (1).png\"]', '22:31:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `protype_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL COMMENT 'ชื่อสินค้า',
  `product_detail` varchar(255) NOT NULL COMMENT 'รายละเอียดสินค้า',
  `product_price` varchar(10) NOT NULL COMMENT 'ราคาสินค้า',
  `product_num` varchar(10) NOT NULL COMMENT 'จำนวนสินค้า',
  `product_status` varchar(1) NOT NULL COMMENT 'สถานะ',
  `product_image` varchar(255) NOT NULL COMMENT 'รูปสินค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `protype_id`, `product_name`, `product_detail`, `product_price`, `product_num`, `product_status`, `product_image`) VALUES
(1, 1, 'Notebook Acer TravelMate TMP216-51-349Q/T005 (Steel Gray)', 'หน้าจอแสดงผลขนาด 16.0\" ระดับ WUXGA IPS หน่วยประมวลผล Intel Core i3-1315U Processor หน่วยประมวลผลกราฟิก Intel UHD Graphics (Integrated) มาพร้อม SSD ความจุ 512GB และ RAM DDR4 8GB บานพับกางได้ 180° แบ่งปันหน้าจอกับคนรอบข้างได้ง่ายขึ้น เทคโนโลยีตัดเสียงรบกวน ', '17990', '9', '1', 'Screenshot 2024-11-18 184102.png'),
(2, 2, 'KEYBOARD (คีย์บอร์ด) RAPOO NK2400-BK (BLACK)', '• เชื่อมต่อด้วย USB-A • คีย์แคป อังกฤษ / ไทย • ดีไซน์ที่ช่วยป้องกันน้ำหกบนแป้นพิมพ์ • ปุ่มที่แกะสลักด้วยเลเซอร์ช่วยให้ตัวอักษรไม่หลุดลอก • ปุ่มลัดฟังก์ชันมัลติมีเดีย เช่น เพิ่ม-ลดเสียง หยุดเพลง ฯลฯ', '269', '10', '1', 'Screenshot 2024-11-29 202654.png'),
(3, 1, 'NOTEBOOK (โน้ตบุ๊ค) HP 15-FC1001AU (SILVER)', '• AMD Ryzen 5 7535HS • 8GB DDR5 • 512GB NVMe PCIe M.2 SSD • 15.6\" FHD (1920x1080) Non-Touch • AMD Radeon Graphics (Integrated) • Windows 11 Home + Office Home & Student 2021', '16990', '12', '1', 'Screenshot 2024-11-29 215855.png'),
(4, 3, 'SOUNDBAR (ลำโพงซาวด์บาร์) CREATIVE STAGE SE MINI (BLACK)', '• ขนาดเล็กกะทัดรัด วางใต้จอมอนิเตอร์ได้อย่างลงตัว • เทคโนโลยี SuperWide สัมผัสมิติเสียงที่กว้างขวางและสมจริง • มาพร้อมกับ Neodymium Drivers เพื่อให้เสียงเบสแน่น ทรงพลัง • การควบคุม ปุ่มปรับระดับเสียง, ปุ่มเปิด/ปิด, ปุ่มจับคู่ Bluetooth • การเชื่อมต่อ Blue', '1190', '8', '1', 'Screenshot 2024-11-29 220406.png'),
(5, 2, 'WIRELESS KEYBOARD (คีย์บอร์ดไร้สาย) ROYAL KLUDGE RK-S98 (LIGHTCLOUD) (CHARTREUSE SWITCH RGB EN/TH)', '• Chartreuse Switch (Linear) • RGB • English / Thai Keycap • ANSI • LCD Display • Wired (Detachable USB-C to USB-A) • 2.4GHz Wireless • Bluetooth • Hot Swappable • Windows / macOS / Android', '2730', '21', '1', 'Screenshot 2024-11-29 220729.png');

-- --------------------------------------------------------

--
-- Table structure for table `producttype`
--

CREATE TABLE `producttype` (
  `protype_id` int(11) NOT NULL,
  `protype_name` varchar(255) NOT NULL COMMENT 'ชื่อประเภทสินค้า',
  `protype_status` varchar(1) NOT NULL COMMENT 'สถานะสินค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `producttype`
--

INSERT INTO `producttype` (`protype_id`, `protype_name`, `protype_status`) VALUES
(1, 'Notebook', '1'),
(2, 'คีย์บอร์ด และ เมาส์', '1'),
(3, 'ลำโพง และ หูฟัง', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD PRIMARY KEY (`orderdetail_id`) USING BTREE,
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `protype_id` (`protype_id`);

--
-- Indexes for table `producttype`
--
ALTER TABLE `producttype`
  ADD PRIMARY KEY (`protype_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการสั่งซื้อ', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders_detail`
--
ALTER TABLE `orders_detail`
  MODIFY `orderdetail_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสการสั่งซื้อสินค้า', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'เลขที่การชำระเงิน', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `producttype`
--
ALTER TABLE `producttype`
  MODIFY `protype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `protype_id` FOREIGN KEY (`protype_id`) REFERENCES `producttype` (`protype_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
