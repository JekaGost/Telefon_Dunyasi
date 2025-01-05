-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 05:46 PM
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
-- Database: `phpprojesidatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Products` mediumtext NOT NULL,
  `NameAndSurname` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(100) NOT NULL,
  `ShippingAddress` varchar(300) NOT NULL,
  `BillingAddress` varchar(300) NOT NULL,
  `City` varchar(10) NOT NULL,
  `State` varchar(10) NOT NULL,
  `PostalCode` varchar(16) NOT NULL,
  `Cardname` varchar(30) NOT NULL,
  `Cardnumber` varchar(16) NOT NULL,
  `CVC` int(3) NOT NULL,
  `TotalPrice` int(11) NOT NULL,
  `OrderStatus` varchar(255) NOT NULL,
  `OrderDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `Products`, `NameAndSurname`, `Email`, `PhoneNumber`, `ShippingAddress`, `BillingAddress`, `City`, `State`, `PostalCode`, `Cardname`, `Cardnumber`, `CVC`, `TotalPrice`, `OrderStatus`, `OrderDate`) VALUES
(1, 1, '[1,Siyah,2]/[5,Beyaz,1]', 'Ahmet Yilmaz', 'ahmet.yilmaz@example.com', '5551234567', 'Ataturk Mah. No:123 D:5', 'Ataturk Mah. No:123 D:5', 'Istanbul', 'TR', '34000', 'Ahmet Yilmaz', '1234567812345678', 123, 250, 'İptal Edildi', '2024-12-10 14:00:00'),
(2, 2, '[3,Mavi,1]/[7,Siyah,3]', 'Mehmet Can', 'mehmet.can@example.com', '5552345678', 'Kocatepe Sok. No:45', 'Kocatepe Sok. No:45', 'Ankara', 'TR', '06010', 'Mehmet Can', '2345678923456789', 456, 400, 'Hazırlanıyor', '2024-12-09 16:30:00'),
(3, 3, '[4,Mavi,1]/[6,Siyah,1]/[8,Beyaz,2]', 'Ali Veli', 'ali.veli@example.com', '5553456789', 'Yildiz Mah. Sokak 18', 'Yildiz Mah. Sokak 18', 'Bursa', 'TR', '16050', 'Ali Veli', '4567890145678901', 101, 450, 'İptal Edildi', '2024-12-07 13:45:00'),
(4, 5, '[9,Siyah,2]/[12,Beyaz,1]', 'Ahmet Yilmaz', 'ahmet.yilmaz@example.com', '5551234567', 'Barbaros Mah. No:56', 'Barbaros Mah. No:56', 'Antalya', 'TR', '07030', 'Ahmet Yilmaz', '5678901256789012', 202, 350, 'Kargoya Verildi', '2024-12-06 15:20:00'),
(5, 1, '[11,Mavi,1]/[13,Siyah,2]', 'Mehmet Can', 'mehmet.can@example.com', '5552345678', 'Gazi Bulv. No:42 D:3', 'Gazi Bulv. No:42 D:3', 'Adana', 'TR', '01070', 'Mehmet Can', '6789012367890123', 303, 380, 'Hazırlanıyor', '2024-12-05 17:40:00'),
(6, 2, '[15,Siyah,1]/[18,Beyaz,2]', 'Ali Veli', 'ali.veli@example.com', '5553456789', 'Fatih Mah. No:61', 'Fatih Mah. No:61', 'Konya', 'TR', '42010', 'Ali Veli', '8901234589012345', 505, 360, 'İptal Edildi', '2024-12-03 14:25:00'),
(7, 3, '[19,Mavi,1]/[20,Siyah,3]', 'Ahmet Yilmaz', 'ahmet.yilmaz@example.com', '5551234567', 'Ismetpasa Cad. No:99', 'Ismetpasa Cad. No:99', 'Mersin', 'TR', '33070', 'Ahmet Yilmaz', '9012345690123456', 606, 500, 'Kargoya Verildi', '2024-12-02 18:55:00'),
(8, 5, '[1,Beyaz,2]/[5,Mavi,1]', 'Mehmet Can', 'mehmet.can@example.com', '5552345678', 'Sevgi Sok. No:13', 'Sevgi Sok. No:13', 'Gaziantep', 'TR', '27060', 'Mehmet Can', '1234567812345678', 123, 250, 'Hazırlanıyor', '2024-12-01 20:00:00'),
(9, 1, '[9,Mavi,3]/[12,Siyah,1]', 'Ali Veli', 'ali.veli@example.com', '5553456789', 'Atasehir Sok. No:31', 'Atasehir Sok. No:31', 'Malatya', 'TR', '44090', 'Ali Veli', '3456789034567890', 789, 410, 'İptal Edildi', '2024-11-29 16:35:00'),
(10, 2, '[13,Beyaz,1]/[16,Mavi,2]', 'Ahmet Yilmaz', 'ahmet.yilmaz@example.com', '5551234567', 'Ihlamur Sok. No:71', 'Ihlamur Sok. No:71', 'Kayseri', 'TR', '38050', 'Ahmet Yilmaz', '4567890145678901', 101, 320, 'Kargoya Verildi', '2024-11-28 19:00:00'),
(11, 3, '[17,Siyah,1]/[20,Beyaz,1]', 'Mehmet Can', 'mehmet.can@example.com', '5552345678', 'Cicek Cad. No:23', 'Cicek Cad. No:23', 'Eskisehir', 'TR', '26020', 'Mehmet Can', '5678901256789012', 202, 270, 'Hazırlanıyor', '2024-11-27 12:45:00'),
(12, 5, '[8,Beyaz,3]/[10,Mavi,1]', 'Ali Veli', 'ali.veli@example.com', '5553456789', 'Kuleli Cad. No:18', 'Kuleli Cad. No:18', 'Van', 'TR', '65040', 'Ali Veli', '7890123478901234', 404, 340, 'İptal Edildi', '2024-11-25 17:35:00'),
(13, 1, '[15,Siyah,2]/[18,Beyaz,1]', 'Ahmet Yilmaz', 'ahmet.yilmaz@example.com', '5551234567', 'Yesil Vadi Cad. No:92', 'Yesil Vadi Cad. No:92', 'Hatay', 'TR', '31050', 'Ahmet Yilmaz', '8901234589012345', 505, 380, 'Kargoya Verildi', '2024-11-24 15:10:00'),
(14, 2, '[19,Mavi,1]/[2,Siyah,3]', 'Mehmet Can', 'mehmet.can@example.com', '5552345678', 'Guzelbahce Mah. No:67', 'Guzelbahce Mah. No:67', 'Kocaeli', 'TR', '41070', 'Mehmet Can', '9012345690123456', 606, 420, 'Hazırlanıyor', '2024-11-23 19:25:00'),
(15, 1, '[1,Siyah,2]', 'John Doe', 'john.doe@example.com', '1234567892', '123 Main St, Apt 4B2', '123 Main St, Apt 4B', 'New York', 'TR', '10001', 'John Doe', '1234567890123456', 123, 2000, 'Hazırlanıyor', '2025-01-03 22:40:19'),
(16, 1, '[1,Siyah,2]/[5,Beyaz,1]/[6,Siyah,1]', 'John Doe', 'john.doe@example.com', '1234567892', '123 Main St, Apt 4B2', '123 Main St, Apt 4B', 'New York', 'TR', '10001', 'John Doe', '1234567890123457', 123, 4600, 'Hazırlanıyor', '2025-01-04 18:31:19'),
(17, 1, '[1,Siyah,2]', 'John Doe', 'john.doe@example.com', '1234567892', '123 Main St, Apt 4B2', '123 Main St, Apt 4B', 'New York', 'TR', '10001', 'John Doe', '1234567890123456', 123, 1600, 'Hazırlanıyor', '2025-01-05 11:07:01'),
(18, 1, '[1,Siyah,1]', 'John Doe', 'john.doe@example.com', '1234567890', '123 Main St, Apt 4B2', '123 Main St, Apt 4B', 'New York', 'TR', '10001', 'John Doe', '1234567890123456', 123, 800, 'Hazırlanıyor', '2025-01-05 11:39:36'),
(19, 1, '[1,Siyah,2]', 'John Doe', 'john.doe@example.com', '1234567890', '123 Main St, Apt 4B2', '123 Main St, Apt 4B', 'New York', 'TR', '10001', 'John Doe', '1234567890123456', 123, 1600, 'Hazırlanıyor', '2025-01-05 12:16:48');

-- --------------------------------------------------------

--
-- Table structure for table `previousorders`
--

CREATE TABLE `previousorders` (
  `PreviousOrdersID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Products` mediumtext NOT NULL,
  `NameAndSurname` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(100) NOT NULL,
  `ShippingAddress` varchar(300) NOT NULL,
  `BillingAddress` varchar(300) NOT NULL,
  `City` varchar(10) NOT NULL,
  `State` varchar(10) NOT NULL,
  `PostalCode` varchar(16) NOT NULL,
  `Cardname` varchar(30) NOT NULL,
  `Cardnumber` varchar(16) NOT NULL,
  `CVC` int(3) NOT NULL,
  `TotalPrice` int(11) NOT NULL,
  `OrderDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `previousorders`
--

INSERT INTO `previousorders` (`PreviousOrdersID`, `UserID`, `Products`, `NameAndSurname`, `Email`, `PhoneNumber`, `ShippingAddress`, `BillingAddress`, `City`, `State`, `PostalCode`, `Cardname`, `Cardnumber`, `CVC`, `TotalPrice`, `OrderDate`) VALUES
(1, 1, '[1,Siyah,2]/[5,Beyaz,1]', 'Ahmet Yilmaz', 'ahmet.yilmaz@example.com', '5551234567', 'Ataturk Mah. No:123 D:5', 'Ataturk Mah. No:123 D:5', 'Istanbul', 'TR', '34000', 'Ahmet Yilmaz', '1234567812345678', 123, 250, '2024-12-10 14:00:00'),
(2, 2, '[3,Mavi,1]/[7,Siyah,3]', 'Mehmet Can', 'mehmet.can@example.com', '5552345678', 'Kocatepe Sok. No:45', 'Kocatepe Sok. No:45', 'Ankara', 'TR', '06010', 'Mehmet Can', '2345678923456789', 456, 400, '2024-12-09 16:30:00'),
(3, 3, '[4,Mavi,1]/[6,Siyah,1]/[8,Beyaz,2]', 'Ali Veli', 'ali.veli@example.com', '5553456789', 'Yildiz Mah. Sokak 18', 'Yildiz Mah. Sokak 18', 'Bursa', 'TR', '16050', 'Ali Veli', '4567890145678901', 101, 450, '2024-12-07 13:45:00'),
(4, 5, '[9,Siyah,2]/[12,Beyaz,1]', 'Ahmet Yilmaz', 'ahmet.yilmaz@example.com', '5551234567', 'Barbaros Mah. No:56', 'Barbaros Mah. No:56', 'Antalya', 'TR', '07030', 'Ahmet Yilmaz', '5678901256789012', 202, 350, '2024-12-06 15:20:00'),
(5, 1, '[11,Mavi,1]/[13,Siyah,2]', 'Mehmet Can', 'mehmet.can@example.com', '5552345678', 'Gazi Bulv. No:42 D:3', 'Gazi Bulv. No:42 D:3', 'Adana', 'TR', '01070', 'Mehmet Can', '6789012367890123', 303, 380, '2024-12-05 17:40:00'),
(6, 2, '[15,Siyah,1]/[18,Beyaz,2]', 'Ali Veli', 'ali.veli@example.com', '5553456789', 'Fatih Mah. No:61', 'Fatih Mah. No:61', 'Konya', 'TR', '42010', 'Ali Veli', '8901234589012345', 505, 360, '2024-12-03 14:25:00'),
(7, 3, '[19,Mavi,1]/[20,Siyah,3]', 'Ahmet Yilmaz', 'ahmet.yilmaz@example.com', '5551234567', 'Ismetpasa Cad. No:99', 'Ismetpasa Cad. No:99', 'Mersin', 'TR', '33070', 'Ahmet Yilmaz', '9012345690123456', 606, 500, '2024-12-02 18:55:00'),
(8, 5, '[1,Beyaz,2]/[5,Mavi,1]', 'Mehmet Can', 'mehmet.can@example.com', '5552345678', 'Sevgi Sok. No:13', 'Sevgi Sok. No:13', 'Gaziantep', 'TR', '27060', 'Mehmet Can', '1234567812345678', 123, 250, '2024-12-01 20:00:00'),
(9, 1, '[9,Mavi,3]/[12,Siyah,1]', 'Ali Veli', 'ali.veli@example.com', '5553456789', 'Atasehir Sok. No:31', 'Atasehir Sok. No:31', 'Malatya', 'TR', '44090', 'Ali Veli', '3456789034567890', 789, 410, '2024-11-29 16:35:00'),
(10, 2, '[13,Beyaz,1]/[16,Mavi,2]', 'Ahmet Yilmaz', 'ahmet.yilmaz@example.com', '5551234567', 'Ihlamur Sok. No:71', 'Ihlamur Sok. No:71', 'Kayseri', 'TR', '38050', 'Ahmet Yilmaz', '4567890145678901', 101, 320, '2024-11-28 19:00:00'),
(11, 3, '[17,Siyah,1]/[20,Beyaz,1]', 'Mehmet Can', 'mehmet.can@example.com', '5552345678', 'Cicek Cad. No:23', 'Cicek Cad. No:23', 'Eskisehir', 'TR', '26020', 'Mehmet Can', '5678901256789012', 202, 270, '2024-11-27 12:45:00'),
(12, 5, '[8,Beyaz,3]/[10,Mavi,1]', 'Ali Veli', 'ali.veli@example.com', '5553456789', 'Kuleli Cad. No:18', 'Kuleli Cad. No:18', 'Van', 'TR', '65040', 'Ali Veli', '7890123478901234', 404, 340, '2024-11-25 17:35:00'),
(13, 1, '[15,Siyah,2]/[18,Beyaz,1]', 'Ahmet Yilmaz', 'ahmet.yilmaz@example.com', '5551234567', 'Yesil Vadi Cad. No:92', 'Yesil Vadi Cad. No:92', 'Hatay', 'TR', '31050', 'Ahmet Yilmaz', '8901234589012345', 505, 380, '2024-11-24 15:10:00'),
(14, 2, '[19,Mavi,1]/[2,Siyah,3]', 'Mehmet Can', 'mehmet.can@example.com', '5552345678', 'Guzelbahce Mah. No:67', 'Guzelbahce Mah. No:67', 'Kocaeli', 'TR', '41070', 'Mehmet Can', '9012345690123456', 606, 420, '2024-11-23 19:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL,
  `category` varchar(50) DEFAULT 'phones',
  `operating_system` varchar(50) NOT NULL,
  `processor` varchar(100) NOT NULL,
  `ram` varchar(10) NOT NULL,
  `storage_capacity` varchar(20) NOT NULL,
  `screen_size` varchar(10) NOT NULL,
  `battery_capacity` varchar(10) NOT NULL,
  `camera_details` varchar(255) NOT NULL,
  `connectivity` varchar(100) NOT NULL,
  `DiscountPercentage` int(11) NOT NULL,
  `IsProductNewlyArrived` varchar(255) NOT NULL,
  `Color1` varchar(7) NOT NULL,
  `Color2` varchar(7) NOT NULL,
  `Color3` varchar(7) NOT NULL,
  `Color1Stock` int(11) NOT NULL,
  `Color2Stock` int(11) NOT NULL,
  `Color3Stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `brand`, `price`, `description`, `stock_quantity`, `category`, `operating_system`, `processor`, `ram`, `storage_capacity`, `screen_size`, `battery_capacity`, `camera_details`, `connectivity`, `DiscountPercentage`, `IsProductNewlyArrived`, `Color1`, `Color2`, `Color3`, `Color1Stock`, `Color2Stock`, `Color3Stock`) VALUES
(1, 'iPhone 15 Pro', 'Apple', 999.99, 'En yeni Apple akıllı telefon, A16 Bionic işlemci ile.', 50, 'telefonlar', 'iOS', 'A16 Bionic', '8GB', '256GB', '6.7\"', '4352mAh', '48MP + 12MP + 12MP', '5G, Wi-Fi 6E', 20, 'No', 'Siyah', 'Beyaz', 'Mavi', 10, 10, 0),
(2, 'Galaxy S23 Ultra', 'Samsung', 1199.99, 'Güçlü Snapdragon işlemcili amiral gemisi telefon.', 40, 'telefonlar', 'Android', 'Snapdragon 8 Gen 2', '12GB', '512GB', '6.8\"', '5000mAh', '200MP + 12MP + 10MP + 10MP', '5G, Wi-Fi 6E', 0, 'No', 'Siyah', 'Beyaz', 'Pembe', 10, 10, 0),
(3, 'Pixel 8 Pro', 'Google', 899.99, 'Google’ın yapay zeka destekli en son telefonu.', 30, 'telefonlar', 'Android', 'Tensor G3', '12GB', '256GB', '6.7\"', '5050mAh', '50MP + 48MP + 12MP', '5G, Wi-Fi 6E', 5, 'No', 'Siyah', 'Beyaz', 'Yeşil', 10, 10, 0),
(4, 'Xperia 1 V', 'Sony', 1299.99, 'Fotoğrafçılar ve videografçılar için premium telefon.', 25, 'telefonlar', 'Android', 'Snapdragon 8 Gen 2', '12GB', '256GB', '6.5\"', '5000mAh', '48MP + 12MP + 12MP', '5G, Wi-Fi 6', 10, 'No', 'Siyah', 'Beyaz', 'Mavi', 10, 10, 0),
(5, 'OnePlus 11', 'OnePlus', 799.99, 'Hasselblad kameralarla yüksek performanslı telefon.', 60, 'telefonlar', 'Android', 'Snapdragon 8 Gen 2', '16GB', '256GB', '6.7\"', '5000mAh', '50MP + 48MP + 32MP', '5G, Wi-Fi 6E', 0, 'No', 'Siyah', 'Beyaz', 'Yeşil', 10, 10, 0),
(6, 'Galaxy Z Fold 5', 'Samsung', 1799.99, 'Amiral gemisi özelliklere sahip katlanabilir telefon.', 15, 'telefonlar', 'Android', 'Snapdragon 8 Gen 2', '12GB', '512GB', '7.6\"', '4400mAh', '50MP + 12MP + 10MP', '5G, Wi-Fi 6E', 0, 'No', 'Siyah', 'Beyaz', 'Mavi', 10, 10, 0),
(7, 'iPhone SE 2023', 'Apple', 499.99, 'Kompakt ve uygun fiyatlı iPhone.', 100, 'telefonlar', 'iOS', 'A15 Bionic', '4GB', '128GB', '4.7\"', '1821mAh', '12MP', '4G, Wi-Fi 6', 5, 'No', 'Siyah', 'Beyaz', 'Kırmızı', 10, 10, 0),
(8, 'Moto Edge 40', 'Motorola', 599.99, 'Şık tasarımlı ve yüksek performanslı telefon.', 45, 'telefonlar', 'Android', 'MediaTek Dimensity 8020', '8GB', '256GB', '6.6\"', '4600mAh', '50MP + 13MP', '5G, Wi-Fi 6', 0, 'No', 'Beyaz', 'Siyah', 'Mavi', 10, 10, 0),
(9, 'Redmi Note 13 Pro', 'Xiaomi', 329.99, 'Harika özelliklere sahip uygun fiyatlı telefon.', 80, 'telefonlar', 'Android', 'Snapdragon 7+ Gen 2', '8GB', '128GB', '6.67\"', '5000mAh', '200MP + 8MP + 2MP', '5G, Wi-Fi 6', 0, 'No', 'Siyah', 'Beyaz', 'Pembe', 10, 10, 0),
(10, 'Asus ROG Phone 7', 'Asus', 999.99, 'Oyun için tasarlanmış üst düzey telefon.', 20, 'telefonlar', 'Android', 'Snapdragon 8 Gen 2', '16GB', '512GB', '6.78\"', '6000mAh', '50MP + 13MP + 8MP', '5G, Wi-Fi 6E', 10, 'No', 'Siyah', 'Beyaz', '', 10, 10, 0),
(11, 'iPhone 14', 'Apple', 799.99, 'Harika performans ve kameraya sahip popüler telefon.', 55, 'telefonlar', 'iOS', 'A15 Bionic', '6GB', '256GB', '6.1\"', '3279mAh', '12MP + 12MP', '5G, Wi-Fi 6', 0, 'No', 'Siyah', 'Beyaz', 'Mavi', 10, 10, 0),
(12, 'Galaxy A54', 'Samsung', 449.99, 'Sağlam özelliklere sahip orta seviye telefon.', 75, 'telefonlar', 'Android', 'Exynos 1380', '8GB', '128GB', '6.4\"', '5000mAh', '50MP + 12MP + 5MP', '5G, Wi-Fi 6', 0, 'No', 'Siyah', 'Beyaz', 'Yeşil', 10, 10, 0),
(13, 'Pixel 7a', 'Google', 499.99, 'Google yapay zeka özelliklerine sahip uygun fiyatlı telefon.', 65, 'telefonlar', 'Android', 'Tensor G2', '8GB', '128GB', '6.1\"', '4385mAh', '64MP + 13MP', '5G, Wi-Fi 6E', 0, 'No', 'Siyah', 'Beyaz', 'Mavi', 10, 10, 0),
(14, 'Realme GT Neo 5', 'Realme', 599.99, 'Hızlı şarj destekli harika özelliklere sahip telefon.', 40, 'telefonlar', 'Android', 'Snapdragon 8+ Gen 1', '12GB', '256GB', '6.74\"', '4600mAh', '50MP + 8MP + 2MP', '5G, Wi-Fi 6E', 0, 'No', 'Siyah', 'Beyaz', 'Mor', 10, 10, 0),
(15, 'Poco X5 Pro', 'Poco', 349.99, 'Yüksek performanslı uygun fiyatlı telefon.', 70, 'telefonlar', 'Android', 'Snapdragon 778G', '8GB', '128GB', '6.67\"', '5000mAh', '108MP + 8MP + 2MP', '5G, Wi-Fi 6', 0, 'No', 'Siyah', 'Beyaz', 'Mavi', 10, 10, 0),
(16, 'Vivo X90 Pro', 'Vivo', 1199.99, 'Mükemmel kameralara sahip amiral gemisi telefon.', 30, 'telefonlar', 'Android', 'Dimensity 9200', '12GB', '256GB', '6.78\"', '4870mAh', '50MP + 50MP + 12MP', '5G, Wi-Fi 6E', 0, 'No', 'Siyah', 'Beyaz', 'Mavi', 10, 10, 0),
(18, 'Nokia G60', 'Nokia', 349.99, 'Dayanıklı ve güvenilir orta sınıf telefon.', 85, 'telefonlar', 'Android', 'Snapdragon 695', '6GB', '128GB', '6.58\"', '4500mAh', '50MP + 5MP + 2MP', '5G, Wi-Fi 6', 0, 'Yes', 'Siyah', 'Beyaz', '', 10, 10, 0),
(19, 'Fairphone 5', 'Fairphone', 699.99, 'Modüler tasarıma sahip sürdürülebilir telefon.', 25, 'telefonlar', 'Android', 'Qualcomm QCM6490', '8GB', '256GB', '6.46\"', '4200mAh', '50MP + 50MP', '5G, Wi-Fi 6', 0, 'Yes', 'Siyah', 'Beyaz', 'Yeşil', 10, 10, 0),
(20, 'Huawei P60 Pro', 'Huawei', 1099.99, 'Etkileyici kameralara sahip amiral gemisi telefon.', 30, 'telefonlar', 'HarmonyOS', 'Snapdragon 8+ Gen 1', '8GB', '256GB', '6.67\"', '4815mAh', '48MP + 13MP + 48MP', '4G, Wi-Fi 6', 0, 'Yes', 'Siyah', 'Beyaz', 'Yeşil', 10, 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `password_value` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `shipping_address` text NOT NULL,
  `billing_address` text DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state_region` varchar(50) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `Cardnumber` varchar(16) NOT NULL,
  `Cardname` varchar(255) NOT NULL,
  `CVC` varchar(3) NOT NULL,
  `shopping_cart` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email_address`, `password_value`, `phone_number`, `shipping_address`, `billing_address`, `city`, `state_region`, `postal_code`, `date_of_birth`, `Cardnumber`, `Cardname`, `CVC`, `shopping_cart`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', '1234', '1234567890', '123 Main St, Apt 4B2', '123 Main St, Apt 4B', 'New York', 'NY', '10001', '1990-05-15', '1234567890123456', 'John Doe', '123', '[1,Siyah,1]'),
(2, 'Jane', 'Smith', 'jane.smith@example.com', 'hashed_password_2', '9876543210', '456 Elm St, Suite 2A', NULL, 'Los Angeles', 'CA', '90001', '1985-07-20', '', '', '', '[1,Siyah,1]'),
(3, 'Alice', 'Johnson', 'alice.johnson@example.com', 'hashed_password_3', '5556667777', '789 Maple Ave', '789 Maple Ave', 'Chicago', 'IL', '60601', '1992-03-10', '', '', '', '[1,Siyah,1]'),
(5, 'Cihan', 'Toker', 'cihantoker123@gmail.com', '123', '05515546819', 'Ataköy 1.Kısım A32 Blok Daire 1 Zübeyde hanım caddesi', '', '', '', '', '2003-10-20', '', '', '', '[1,Siyah,1]'),
(6, 'Cihan', 'Toker', 'cihantoker12@gmail.com', '123', '55155468198', '', '', '', '', '', '2003-10-20', '', '', '', '[1,Siyah,1]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
