-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2022 at 04:13 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlineauction`
--

-- --------------------------------------------------------

--
-- Table structure for table `bidding`
--

CREATE TABLE `bidding` (
  `bidding_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `bidding_amount` float(10,2) NOT NULL,
  `bidding_date_time` datetime NOT NULL,
  `note` text NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bidding`
--

INSERT INTO `bidding` (`bidding_id`, `customer_id`, `product_id`, `bidding_amount`, `bidding_date_time`, `note`, `status`) VALUES
(2, 37, 188, 250.00, '2022-02-25 17:02:54', '', 'Active'),
(3, 37, 187, 90.00, '2022-02-27 11:11:11', '', 'Active'),
(4, 37, 187, 125.00, '2022-02-27 11:11:33', '', 'Active'),
(5, 37, 187, 150.00, '2022-02-27 11:37:42', '', 'Active'),
(6, 37, 187, 170.00, '2022-02-27 12:13:10', '', 'Active'),
(7, 36, 195, 250.00, '2022-02-27 12:54:17', '', 'Active'),
(8, 36, 187, 190.00, '2022-03-06 17:59:26', '', 'Active'),
(9, 36, 195, 280.00, '2022-03-06 19:42:48', '', 'Active'),
(10, 36, 195, 300.00, '2022-03-07 15:12:22', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `billing_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `product_id` int(10) NOT NULL,
  `purchase_date` date NOT NULL,
  `purchase_amount` float(10,2) NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `card_type` varchar(50) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `expire_date` date NOT NULL,
  `cvv_number` varchar(5) NOT NULL,
  `card_holder` varchar(50) NOT NULL,
  `verify_token` varchar(191) NOT NULL,
  `verify_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=no,1=yes',
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`billing_id`, `customer_id`, `email_id`, `product_id`, `purchase_date`, `purchase_amount`, `payment_type`, `card_type`, `card_number`, `expire_date`, `cvv_number`, `card_holder`, `verify_token`, `verify_status`, `status`) VALUES
(23, 37, ' ranadiya715@gmail.com', 188, '2022-02-26', 250.00, 'Winners', 'Debit Card', '123456789', '2022-12-01', '123', 'Diya', 'fd02ed6772c997113577bf59fee9c567', 1, 'Active'),
(24, 36, ' ranadrishti06@gmail.com', 195, '2022-03-06', 250.00, 'Winners', 'Credit card', '123456789', '2022-12-01', '123', 'Drishti', 'c9fb89404320201a31280acc443399c5', 0, 'Active'),
(25, 36, ' ranadrishti06@gmail.com', 195, '2022-03-07', 250.00, 'Winners', 'Credit card', '1234567890', '2022-12-01', '123', 'Drishti', 'bb9daca4e98d7a135af4c8a1b87c9278', 0, 'Active'),
(26, 36, ' ranadrishti06@gmail.com', 195, '2022-03-07', 250.00, 'Winners', 'Credit card', '1234567890', '2022-12-01', '123', 'Drishti', '0bba156dc5de384a138c2f5b862dfe13', 0, 'Active'),
(27, 36, ' ranadrishti06@gmail.com', 195, '2022-03-07', 250.00, 'Winners', 'Credit card', '12345678', '2022-04-01', '123', 'Diya', 'd1e77ea16b94d79dbfb532082fd9ace1', 0, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(10) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_icon` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_icon`, `description`, `status`) VALUES
(16548, 'Mobile Phones', '9433188871028327282Mobile Accessories.png', 'Mobiles and phones', 'Active'),
(16549, 'Electronics Items', '290574709electronics.jpg', 'All types of Electronics Items', 'Active'),
(16552, 'Watches', '179699349watchescategory.jpg', 'Watches', 'Active'),
(16558, 'Collectibles', 'oldcoinandnotes.jpg', 'Old Coin and Notes', 'Active'),
(16560, 'Accessories', '2011027608accessoriescategory.jpg', 'Accessories', 'Active'),
(16561, 'Sports and Games', '2075867780Sports & Games.jpg', 'Sports & Games', 'Active'),
(16562, 'Clothes', '1131583716wholesale+boutique+clothing.jpg', 'Clothes', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(10) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `email_id`, `password`, `address`, `mobile_no`, `status`) VALUES
(2, 'Rajesh Krishna', 'rajeshkrishna@gmail.com', '123456123456', 'Junction, Bendoorwell, Kankanady', '7894561230', 'Active'),
(7, 'Mahesh Kumar', 'maheshkumar@gmail.com', '123456789', '', '8217727968', 'Active'),
(8, 'Preetham Bhat', 'preethambhat@gmail.com', 'q1w2e3r4', 'Kathmandu', '9874563210', 'Active'),
(9, 'Hudson A K', 'hudsonak@gmail.com', 't5y6u7i8', ' ', '7894561230', 'Active'),
(22, 'Manthesh kumar', 'mantheshkumar@gmail.com', '123456789', '', '9874563210', 'Active'),
(24, 'Manish Kumar', 'manishkumar@gmail.com', '123456789', 'Near kupondole', '8217727968', 'Active'),
(25, 'Suraj Mishra', 'surajmishra@gmail.com', '123456789', '', '8217778968', 'Active'),
(26, 'Susheel kumar', 'susheelkumar@gmail.com', 'susheel123456789', '', '8217778968', 'Active'),
(27, 'Prateek shetty', 'prathikshetty@gmail.com', 'pratik', '', '8217778968', 'Active'),
(28, 'Surendra kumar', 'surendrakumar23@gmail.com', '123456789', '', '9986051445', 'Active'),
(29, 'Pranesh', 'mvaravinda@gmail.com', 'q1w2e3r4/', '', '9986058114', 'Active'),
(31, 'Vilass kumar', 'vilaskumar@gmail.com', 'q1w2e3r4', '', '9876543211', 'Active'),
(35, 'ARavinda', 'actingtoys@gmail.com', 'q1w2e3r4a', '', '9874563210', 'Active'),
(36, 'Drishti Rana', 'ranadrishti06@gmail.com', 'Asdzxc31', 'Satdobato', '9821265532', 'Active'),
(37, 'Diya Rana', 'ranadiya715@gmail.com', 'Qweasd31', 'Satdobato', '9821265532', 'Active'),
(46, 'srishti thapa', 'ranadrishti31@gmail.com', 'Asdzxc31', '', '9821264441', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(10) NOT NULL,
  `employee_name` varchar(50) NOT NULL,
  `login_id` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `employee_type` varchar(50) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `employee_name`, `login_id`, `password`, `employee_type`, `status`) VALUES
(1, 'Administrator', 'admin', 'admin', 'Admin', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(10) NOT NULL,
  `sender_id` int(10) NOT NULL,
  `receiver_id` int(10) NOT NULL,
  `message_date_time` datetime NOT NULL,
  `product_id` int(10) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `sender_id`, `receiver_id`, `message_date_time`, `product_id`, `message`, `status`) VALUES
(1, 36, 37, '2022-02-27 12:55:11', 195, 'hello\n', 'Customer'),
(7, 46, 37, '2022-02-27 19:20:24', 195, 'hello\n', 'Customer'),
(8, 46, 37, '2022-02-27 19:23:33', 195, 'yes how can i help?\n', 'Seller'),
(10, 36, 37, '2022-03-07 15:06:59', 195, 'Can i ask about the dress brand?\n', 'Customer'),
(11, 36, 37, '2022-03-07 15:07:22', 195, 'Yes it is from zara and i have only worn it once.\n', 'Seller');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `product_id` int(10) NOT NULL,
  `bidding_id` int(10) NOT NULL,
  `paid_amount` float(10,2) NOT NULL,
  `paid_date` date NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `customer_id`, `payment_type`, `product_id`, `bidding_id`, `paid_amount`, `paid_date`, `status`) VALUES
(8, 36, 'Credit card', 195, 0, 250.00, '2022-03-07', 'Active'),
(9, 36, 'Credit card', 195, 0, 250.00, '2022-03-07', 'Active'),
(10, 36, 'Credit card', 195, 0, 250.00, '2022-03-07', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `category_id` int(10) NOT NULL,
  `product_description` text NOT NULL,
  `starting_bid` float(10,2) NOT NULL,
  `ending_bid` float(10,2) NOT NULL,
  `start_date_time` datetime NOT NULL,
  `end_date_time` datetime NOT NULL,
  `product_cost` float(10,2) NOT NULL,
  `product_image` text NOT NULL,
  `product_warranty` varchar(100) NOT NULL,
  `product_delivery` text NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `customer_id`, `product_name`, `category_id`, `product_description`, `starting_bid`, `ending_bid`, `start_date_time`, `end_date_time`, `product_cost`, `product_image`, `product_warranty`, `product_delivery`, `company_name`, `status`) VALUES
(126, 7, 'Xiaomi Redmi Note 8', 16548, 'Xiaomi Redmi Note 8 is a mid-range that can impress the buyers with its stylish design. The device offers no bezels except for a thin chin. It offers an amazing viewing experience that knows no boundary. It also delivers stellar performance with the strong internal hardware along with long-hour battery backup coupled with Fast Charging technology.', 100.00, 0.00, '2020-02-05 10:18:00', '2020-02-08 05:30:00', 10000.00, '2020024625xiaomi-redmi-note-8.jpg', '1', 'Excellent camerasGreat performanceGood battery backupFast Charging suppor', 'Xiami', 'Active'),
(127, 8, 'Lenovo Ideapad S145 8th Gen', 16549, 'Operating System: Pre-loaded Windows 10 Home with lifetime validity and Microsoft Office 2019\r\nDisplay: 15.6-inch screen with (1920X1080) full HD display | Anti Glare technology\r\nMemory and Storage: 4 GB RAM | Storage 256 GB SSD\r\nDesign and battery: Thin and light Laptop| 180 Degree Hinge| Laptop weight 1.85kg | Battery Life: Upto 5.5 hours as per MobileMark\r\nThis genuine Lenovo Laptop comes with 1 year onsite domestic warranty from Lenovo covering manufacturing defects and not covering physical damage. For more details, see Warranty section\r\nInside the box: Laptop, Charger, User Manual | With Microsoft Office 2019\r\nPorts and Optical Drive: 1 HDMI, 2 USB 3.0, USB 2.0 |4-in-1 card reader (SD,SDHC,SDXC,MMC)|Combo audio and microphone jack |No Optical Drive', 1.00, 1.00, '2020-02-05 10:51:46', '2020-02-07 05:30:00', 10000.00, '1160091601laptop.jpg', '1', 'Delivery in 7 - 8 days', 'Lenovo', 'Active'),
(128, 8, 'Canon EOS R Mirrorless Digital Camera', 16550, 'The first step in Canon\'s mirrorless evolution, the EOS R pairs a redeveloped lens mount and updated full-frame image sensor for a unique and sophisticated multimedia camera system. Revolving around the new RF lens mount, the EOS R is poised to be the means from which to make the most of a new series of lenses and optical technologies.', 1.00, 525.00, '2020-02-05 10:55:36', '2021-02-05 05:30:00', 50000.00, '1249798823Camera.jpg', 'Mangalore', 'test', 'aishu', 'Active'),
(129, 9, 'Redmi Note 7S', 16548, 'With its 13 MP AI front camera, the Redmi Note 7S takes your selfie game to the next level, allowing you to click gorgeous and Instagram-worthy pictures effortlessly.', 25.00, 40.00, '2020-02-06 10:53:42', '2020-09-29 05:30:00', 8999.00, '19660redmi note7.jpeg', '1 year', '3 Days', 'Redmi', 'Active'),
(138, 2, 'Acer A315-21 Aspire 3 Laptop', 16549, 'You\'re looking at the Acer Aspire 3 A315-21 laptop. This is one of the most affordable laptops around and it still offers a great bang for your buck. For this price, you get a lot more than you might imagine. It runs an AMD A4 9120 dual-core processor and even 4GB of RAM. This really is more than enough for running most software you might use daily. There is even an integrated Radeon R3 series of graphics solution on this laptop. The benefit is a surprisingly decent performance in running some graphics intensive software, that can include streaming movies, even some basic image and video editing tools. If you thought you would get very limited storage options, you\'re wrong. It has a massive 1TB hard disk drive, which is way more than you\'ll need to store all your favourite software, photos, music and movies. This is by no means a netbook, it\'s a full-functional notebook, so it comes with a large 15.6-inch display, even a full-sized keyboard. These things about it make it ideal as a desktop replacement for home.', 100.00, 100.00, '2020-03-04 10:05:05', '2020-09-04 05:30:00', 25000.00, 'acerlaptop.jpg', '', '3-4 Days', 'acer', 'Active'),
(140, 9, 'OnePlus', 16548, '48+12+16MP triple rear camera with telephoto lens + ultrawide angle lens | 16MP front camera with 4K video capture @ 30/60 FPS, ultrashot, nightscape, portrait, pro mode, panorama, HDR, AI scene detection, RAW image', 1.00, 1.00, '2020-03-04 20:34:00', '2020-03-05 20:34:00', 35000.00, 'oneplus-7t-dual-sim.jpg', '', '4-5 days', 'One Plus', 'Active'),
(141, 9, 'OnePlus T', 16548, 'Glacier Blue, 8GB RAM, Fluid AMOLED Display, 128GB Storage, 3800mAH Battery', 1.00, 1.00, '2021-03-04 20:42:00', '2020-03-05 20:42:00', 34999.00, '7t-9_1_1-473x473.jpg', '', '5-7 days', 'OnePlus', 'Active'),
(151, 8, 'INDIA 2006 1000 RUPEES FIRST PREFIX SOLID NUMBER', 16558, 'The Indian 1000-rupee banknote (?1000) was a denomination of the Indian rupee. It was first introduced by the Reserve Bank of India in 1938 under British rule and subsequently demonetized in 1946.', 150.00, 0.00, '2020-08-24 16:48:00', '2020-09-25 16:18:00', 50000.00, 's-l1600.jpg', 'NA', '3-4 Days', 'CoinGate', 'Active'),
(153, 2, 'India 1996 Complete Stamps collection', 16558, 'India 1996 Complete Year Pack Stamp Full Set 43 Different Stamps from Stampbazar', 100.00, 0.00, '2020-08-24 15:48:00', '2020-09-25 16:18:00', 3000.00, 'stamp.jpg', 'NA', '3-4 Days', 'Stampbazar', 'Active'),
(154, 2, 'Dell 7386 Inspiron Laptop', 16549, 'with an innovative design, the versatile and lightweight Inspiron 13 7000 2-in-1 allows you to switch easily beetween four different modes. Tent mode is perfect for using receipts in real time, stand mode for movies on the aeroplane, laptop mode for trying your novel or emailing work, and tablet mode makes reading while you\'re reclined easier than ever.', 2000.00, 0.00, '2020-08-24 10:05:05', '2020-10-04 05:30:00', 25000.00, 'dell.jpg', '', '3-4 Days', 'dell', 'Active'),
(155, 8, 'Olympus 8-16 x 40 Zoom DPS I Binocular, Black', 16550, 'The Olympus binocular feature 8-16x zoom optical power that brigns sports enthusiasts to easily focus on their game, good for keeping up with fast moving subjects. A large diameter lenses offer upgraded field of view and clear view under dark environment. They also provide UV ray protection so you never have to worry against the sun.', 1000.00, 0.00, '2020-02-05 10:55:36', '2021-02-05 05:30:00', 8000.00, 'Olympus-.jpg', 'One Year', '1-3 days', 'DSL', 'Active'),
(156, 8, 'Fujifilm Instax Mini 9 Party box, Lime Green Insta', 16550, 'This Fujifilm Instax Mini9 Point and Shoot Cameras image is for illustration purpose only. Actual image may vary.', 100.00, 25.00, '2020-02-05 10:55:36', '2021-02-05 05:30:00', 8000.00, 'fujifilm.jpg', 'One Year', '7-10 days', 'DSL', 'Active'),
(157, 28, 'AlloyJewelSeT', 16560, 'Special Design And Unique Structure, A Popular Item\r\nWomen Love Jewellery\r\nSpecially Artificial Jewellery Adore A Women. They Wear It On Different Occasion. They Have Special Importance On Ring Ceremony, Wedding And Festive Time. They Can Also Wear It On Regular Basis . Make Your Moment Memorable With This Range. This Jewellery Features A Unique One Of A Kind Traditional Embellish With Antique Finish.\r\nThis Rich & Famous 2 In 1 Valentine Day Special Heart Pendant With Chain.\r\nRich & Famous Is A Tazs Brand In Fashion Jewelry Sector.', 255.00, 255.00, '2020-08-27 18:23:00', '2020-08-28 18:23:00', 50000.00, '1269626786gold.jpeg', '', '5-7 days', 'Akshaa', 'Active'),
(164, 35, 'AMD Ryzen', 16549, 'Immerse yourself in your chosen entertainment with an ultra-narrow 5.1 mm bezel offering up to 85.73%1 screen-to-body ratio. With up to 300 nits1, and 100% sRGB1, the 14\" FHD IPS non-glare1 display with DC dimming1 pumps out a consistently rich, bright, and unwavering picture.', 200.00, 200.00, '2021-08-24 22:58:00', '2022-03-05 22:58:00', 50000.00, 'a:3:{i:0;s:29:\"818613015Swift-3_ksp-01_l.jpg\";i:1;s:30:\"1827631035Swift-3_ksp-02_l.jpg\";i:2;s:31:\"1813918504Swift-3_Main_2560.jpg\";}', '', '3-4 Days', 'icon', 'Pending'),
(168, 35, 'AMD Ryzen', 16549, 'Immerse yourself in your chosen entertainment with an ultra-narrow 5.1 mm bezel offering up to 85.73%1 screen-to-body ratio. With up to 300 nits1, and 100% sRGB1, the 14\" FHD IPS non-glare1 display with DC dimming1 pumps out a consistently rich, bright, and unwavering picture.', 200.00, 200.00, '2021-08-24 22:58:00', '2022-03-05 22:58:00', 50000.00, 'a:3:{i:0;s:29:\"606326386Swift-3_ksp-01_l.jpg\";i:1;s:30:\"1473510392Swift-3_ksp-02_l.jpg\";i:2;s:30:\"351725804Swift-3_Main_2560.jpg\";}', '', '3-4 Days', 'icon', 'Pending'),
(169, 35, 'AMD Ryzen', 16549, 'Immerse yourself in your chosen entertainment with an ultra-narrow 5.1 mm bezel offering up to 85.73%1 screen-to-body ratio. With up to 300 nits1, and 100% sRGB1, the 14\" FHD IPS non-glare1 display with DC dimming1 pumps out a consistently rich, bright, and unwavering picture.', 200.00, 200.00, '2021-08-24 22:58:00', '2022-03-05 22:58:00', 50000.00, 'a:3:{i:0;s:29:\"116277223Swift-3_ksp-01_l.jpg\";i:1;s:29:\"952594467Swift-3_ksp-02_l.jpg\";i:2;s:30:\"482735923Swift-3_Main_2560.jpg\";}', '', '3-4 Days', 'icon', 'Pending'),
(171, 35, 'AMD Ryzen', 16549, 'Immerse yourself in your chosen entertainment with an ultra-narrow 5.1 mm bezel offering up to 85.73%1 screen-to-body ratio. With up to 300 nits1, and 100% sRGB1, the 14\" FHD IPS non-glare1 display with DC dimming1 pumps out a consistently rich, bright, and unwavering picture.', 200.00, 200.00, '2021-08-24 22:58:00', '2022-03-05 22:58:00', 50000.00, 'a:3:{i:0;s:30:\"1261047173Swift-3_ksp-01_l.jpg\";i:1;s:29:\"441165800Swift-3_ksp-02_l.jpg\";i:2;s:30:\"627807598Swift-3_Main_2560.jpg\";}', '', '3-4 Days', 'icon', 'Pending'),
(176, 35, 'test abc xyz', 16549, 'test', 12.00, 12.00, '2021-08-24 23:23:00', '2021-08-25 23:23:00', 3434.00, 'a:3:{i:0;s:30:\"1800037143Swift-3_ksp-01_l.jpg\";i:1;s:30:\"1973478127Swift-3_ksp-02_l.jpg\";i:2;s:31:\"1305099833Swift-3_Main_2560.jpg\";}', '', '5-7 days', 'gtest', 'Pending'),
(179, 35, 'test test test', 16549, 'teat ', 23.00, 23.00, '2021-08-24 23:34:00', '2021-08-25 23:34:00', 4545.00, 'a:3:{i:0;s:27:\"8062364Swift-3_ksp-01_l.jpg\";i:1;s:29:\"684976078Swift-3_ksp-02_l.jpg\";i:2;s:31:\"1960013548Swift-3_Main_2560.jpg\";}', '', '4-5 days', 'abcd', 'Pending'),
(180, 35, 'test test etst', 16549, 'abc', 21.00, 21.00, '2021-08-24 23:34:00', '2021-08-25 23:34:00', 4545.00, 'a:3:{i:0;s:46:\"12617914284a3c8c74375e8fbe5adf99db215ca0e2.jpg\";i:1;s:103:\"52549108715-75-x11-81-beautiful-scenery-5d-diy-diamond-painting-kit-full-original-imaf66kewnc9s69t.jpeg\";i:2;s:27:\"1055854593download (1).jfif\";}', '', '4-5 days', 'test', 'Pending'),
(184, 35, 'test test test', 16549, 'abc abc', 32.00, 32.00, '2021-08-24 23:36:00', '2021-08-25 23:36:00', 4545.00, 'a:1:{i:0;s:29:\"562732850Swift-3_ksp-02_l.jpg\";}', '', '4-5 days', 'abcd', 'Pending'),
(186, 35, 'HP 15s Ryzen 5 Quad Core 3500U', 16549, 'Sales Package\r\nLaptop, Battery, Adapter, Cables and User Manuals\r\nModel Number\r\n15s-gr0500AU\r\nPart Number\r\n440L7PA\r\nSeries\r\n15s\r\nColor\r\nNatural Silver\r\nType\r\nThin and Light Laptop\r\nSuitable For\r\nProcessing & Multitasking\r\nBattery Backup\r\nUp to 6 Hours\r\nPower Supply\r\n65 W Smart AC Adapter\r\nBattery Cell\r\n3 Cell\r\nMS Office Provided\r\nNo\r\nProcessor And Memory Features\r\nProcessor Brand\r\nAMD\r\nProcessor Name\r\nRyzen 5 Quad Core\r\nSSD\r\nYes\r\nSSD Capacity\r\n512 GB\r\nRAM\r\n8 GB\r\nRAM Type\r\nDDR4\r\nProcessor Variant\r\n3500U\r\nChipset\r\nAMD Integrated SoC\r\nClock Speed\r\n2.1 GHz with Turbo Boost Upto 3.7 GHz\r\nRAM Frequency\r\n2400 MHz\r\nCache\r\n4\r\nGraphic Processor\r\nAMD Radeon\r\nNumber of Cores\r\n4\r\nOperating System\r\nOS Architecture\r\n64 bit\r\nOperating System\r\nWindows 10 Home\r\nSystem Architecture\r\n64\r\nPort And Slot Features\r\nMic In\r\nYes\r\nRJ45\r\nYes\r\nUSB Port\r\n1 x SuperSpeed USB Type-C 5 Gbps Signaling Rate, 2 x SuperSpeed USB Type A 5Gbps Signaling Rate\r\nHDMI Port\r\n1 x HDMI 1.4b\r\nMulti Card Slot\r\n1 x Multi-format SD Media Card Reader\r\nHardware Interface\r\nPCIe NVMe\r\nDisplay And Audio Features\r\nTouchscreen\r\nNo\r\nScreen Size\r\n39.62 cm (15.6 inch)\r\nScreen Resolution\r\n1920 x 1080 Pixels\r\nScreen Type\r\nFull HD Diagonal Micro-edge, Anti-glare Display (220 nits, 45% NTSC)\r\nSpeakers\r\nBuilt-in Dual Speakers\r\nInternal Mic\r\nBuilt-in Microphone\r\nConnectivity Features\r\nWireless LAN\r\nRealtek RTL8821CE 802.11a/b/g/n/ac (1x1) Wi-Fi\r\nBluetooth\r\nv4.2\r\nEthernet\r\nIntegrated 10/100/1000 GbE LAN\r\nDimensions\r\nDimensions\r\n358.5 x 242 x 19.9\r\nWeight\r\n1.74 Kg\r\nAdditional Features\r\nDisk Drive\r\nNot Available\r\nWeb Camera\r\nHP True Vision 720p HD Webcam\r\nFinger Print Sensor\r\nNo\r\nKeyboard\r\nFull-size, Natural Silver Keyboard with Numeric Keypad\r\nBacklit Keyboard\r\nNo\r\nPointer Device\r\nTouchpad with Multi-touch Gesture Support, Precision Touchpad Support\r\nIncluded Software\r\nMcAfee LiveSafe\r\nAdditional Features\r\n41 Wh Li-ion, Supports Battery Fast Charge: Approximately 50% in 45 Minutes\r\nWarranty\r\nWarranty Summary\r\n1 Year Onsite Warranty\r\nWarranty Service Type\r\nOnsite\r\nCovered in Warranty\r\nManufacturing Defects\r\nNot Covered in Warranty\r\nPhysical Damage\r\nDomestic Warranty\r\n1 Year', 10.00, 10.00, '2021-08-24 23:39:00', '2022-08-25 23:39:00', 25000.00, 'a:3:{i:0;s:67:\"665453083na-thin-and-light-laptop-hp-original-imag4r6xquheeasd.jpeg\";i:1;s:43:\"2058028497hp-original-imafug7gazzawdzv.jpeg\";i:2;s:68:\"1851719731na-thin-and-light-laptop-hp-original-imag4r6xxpg9yvkk.jpeg\";}', '', '4-5 days', 'ABCd', 'Pending'),
(187, 35, 'HP 15s Ryzen 5 Quad Core 3500U', 16549, 'Sales Package\r\nLaptop, Battery, Adapter, Cables and User Manuals\r\nModel Number\r\n15s-gr0500AU\r\nPart Number\r\n440L7PA\r\nSeries\r\n15s\r\nColor\r\nNatural Silver\r\nType\r\nThin and Light Laptop\r\nSuitable For\r\nProcessing & Multitasking\r\nBattery Backup\r\nUp to 6 Hours\r\nPower Supply\r\n65 W Smart AC Adapter\r\nBattery Cell\r\n3 Cell\r\nMS Office Provided\r\nNo\r\nProcessor And Memory Features\r\nProcessor Brand\r\nAMD\r\nProcessor Name\r\nRyzen 5 Quad Core\r\nSSD\r\nYes\r\nSSD Capacity\r\n512 GB\r\nRAM\r\n8 GB\r\nRAM Type\r\nDDR4\r\nProcessor Variant\r\n3500U\r\nChipset\r\nAMD Integrated SoC\r\nClock Speed\r\n2.1 GHz with Turbo Boost Upto 3.7 GHz\r\nRAM Frequency\r\n2400 MHz\r\nCache\r\n4\r\nGraphic Processor\r\nAMD Radeon\r\nNumber of Cores\r\n4\r\nOperating System\r\nOS Architecture\r\n64 bit\r\nOperating System\r\nWindows 10 Home\r\nSystem Architecture\r\n64\r\nPort And Slot Features\r\nMic In\r\nYes\r\nRJ45\r\nYes\r\nUSB Port\r\n1 x SuperSpeed USB Type-C 5 Gbps Signaling Rate, 2 x SuperSpeed USB Type A 5Gbps Signaling Rate\r\nHDMI Port\r\n1 x HDMI 1.4b\r\nMulti Card Slot\r\n1 x Multi-format SD Media Card Reader\r\nHardware Interface\r\nPCIe NVMe\r\nDisplay And Audio Features\r\nTouchscreen\r\nNo\r\nScreen Size\r\n39.62 cm (15.6 inch)\r\nScreen Resolution\r\n1920 x 1080 Pixels\r\nScreen Type\r\nFull HD Diagonal Micro-edge, Anti-glare Display (220 nits, 45% NTSC)\r\nSpeakers\r\nBuilt-in Dual Speakers\r\nInternal Mic\r\nBuilt-in Microphone\r\nConnectivity Features\r\nWireless LAN\r\nRealtek RTL8821CE 802.11a/b/g/n/ac (1x1) Wi-Fi\r\nBluetooth\r\nv4.2\r\nEthernet\r\nIntegrated 10/100/1000 GbE LAN\r\nDimensions\r\nDimensions\r\n358.5 x 242 x 19.9\r\nWeight\r\n1.74 Kg\r\nAdditional Features\r\nDisk Drive\r\nNot Available\r\nWeb Camera\r\nHP True Vision 720p HD Webcam\r\nFinger Print Sensor\r\nNo\r\nKeyboard\r\nFull-size, Natural Silver Keyboard with Numeric Keypad\r\nBacklit Keyboard\r\nNo\r\nPointer Device\r\nTouchpad with Multi-touch Gesture Support, Precision Touchpad Support\r\nIncluded Software\r\nMcAfee LiveSafe\r\nAdditional Features\r\n41 Wh Li-ion, Supports Battery Fast Charge: Approximately 50% in 45 Minutes\r\nWarranty\r\nWarranty Summary\r\n1 Year Onsite Warranty\r\nWarranty Service Type\r\nOnsite\r\nCovered in Warranty\r\nManufacturing Defects\r\nNot Covered in Warranty\r\nPhysical Damage\r\nDomestic Warranty\r\n1 Year', 25.00, 190.00, '2021-08-24 23:41:00', '2022-08-25 23:41:00', 50000.00, 'a:3:{i:0;s:43:\"1054890393hp-original-imafug7gazzawdzv.jpeg\";i:1;s:67:\"423877211na-thin-and-light-laptop-hp-original-imag4r6xquheeasd.jpeg\";i:2;s:67:\"641779853na-thin-and-light-laptop-hp-original-imag4r6xxpg9yvkk.jpeg\";}', '', '7-10 days', 'Hewlett Packard', 'Active'),
(195, 37, 'Cotton Dress', 16562, 'cottion', 200.00, 300.00, '2022-02-27 12:16:00', '2022-03-06 12:16:00', 1500.00, 'a:1:{i:0;s:19:\"1251899467dress.jpg\";}', '', '3-4 Days', 'second chance', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE `winners` (
  `winner_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `winners_image` varchar(100) NOT NULL,
  `winning_bid` float(10,2) NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `winners`
--

INSERT INTO `winners` (`winner_id`, `product_id`, `customer_id`, `winners_image`, `winning_bid`, `end_date`, `status`) VALUES
(2, 195, 36, '1886903858', 250.00, '2022-02-27', 'Active'),
(3, 126, 36, '[value-4]', 600.00, '2022-03-03', '[pending]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bidding`
--
ALTER TABLE `bidding`
  ADD PRIMARY KEY (`bidding_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `customer_id_2` (`customer_id`,`product_id`),
  ADD KEY `customer_id_3` (`customer_id`,`product_id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`billing_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `customer_id_2` (`customer_id`,`product_id`),
  ADD KEY `customer_id_3` (`customer_id`,`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_id_2` (`product_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `customer_id` (`customer_id`,`product_id`,`bidding_id`),
  ADD KEY `customer_id_2` (`customer_id`,`product_id`,`bidding_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `customer_id` (`customer_id`,`category_id`),
  ADD KEY `customer_id_2` (`customer_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `winners`
--
ALTER TABLE `winners`
  ADD PRIMARY KEY (`winner_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`,`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bidding`
--
ALTER TABLE `bidding`
  MODIFY `bidding_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `billing_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16563;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `winners`
--
ALTER TABLE `winners`
  MODIFY `winner_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bidding`
--
ALTER TABLE `bidding`
  ADD CONSTRAINT `bidding_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `winners`
--
ALTER TABLE `winners`
  ADD CONSTRAINT `winners_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `winners_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
