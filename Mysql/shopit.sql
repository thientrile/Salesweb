-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 10, 2023 lúc 10:22 AM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shopit`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Audio'),
(2, 'Graphics'),
(3, 'Themes'),
(4, 'Video');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `deteted`
--

CREATE TABLE `deteted` (
  `id` int(11) NOT NULL,
  `function` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `deteted`
--

INSERT INTO `deteted` (`id`, `function`) VALUES
(0, 'exist'),
(1, 'deleted');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `thumnali` varchar(500) NOT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `gallery`
--

INSERT INTO `gallery` (`id`, `product_id`, `thumnali`, `type`) VALUES
(27, 42, 'Mẫu website dùng thử 123Website - MẪU WEBSITE BÁN HÀNG CÔNG NGHỆ – DGWork.mp3', 'mp3'),
(29, 44, 'dgwork-product-citynews.jpg', 'jpg'),
(31, 46, 'PM02_20230306234256.png', 'png'),
(32, 46, 'dgwork-product-surfer.jpg', 'jpg'),
(33, 46, 'dgwork-product-citynews.jpg', 'jpg'),
(34, 47, 'PM02_20230306234256.png', 'png'),
(35, 47, 'dgwork-product-surfer.jpg', 'jpg'),
(36, 47, 'dgwork-product-citynews.jpg', 'jpg'),
(37, 47, 'video_thumbnail.jpg', 'jpg'),
(38, 47, 'dgwork-product-mockup-3.jpg', 'jpg'),
(39, 47, 'z4156449901375_3d8f82d0ca0b79b132e817eb92e3e91a - Copy.jpg', 'jpg'),
(41, 42, 'video_thumbnail.jpg', 'jpg'),
(42, 48, 'dgwork-product-citynews.jpg', 'jpg'),
(43, 48, 'video_thumbnail.jpg', 'jpg'),
(44, 48, 'dgwork-product-mockup-3.jpg', 'jpg'),
(45, 48, 'z4156449901375_3d8f82d0ca0b79b132e817eb92e3e91a - Copy.jpg', 'jpg'),
(46, 49, 'dgwork-product-surfer.jpg', 'jpg'),
(47, 49, 'dgwork-product-video.jpg', 'jpg'),
(48, 49, 'focux-1024x933-1.jpg', 'jpg'),
(49, 50, 'dgwork-header-voice.jpg', 'jpg'),
(50, 50, 'dgwork-product-camera.jpg', 'jpg'),
(51, 50, 'dgwork-product-citynews.jpg', 'jpg'),
(52, 50, 'dgwork-product-surfer.jpg', 'jpg'),
(53, 50, 'dgwork-product-video.jpg', 'jpg'),
(54, 50, 'focux-1024x933-1.jpg', 'jpg'),
(55, 51, 'dgwork-product-guitar.jpg', 'jpg'),
(56, 51, 'dgwork-product-iphone-book.jpg', 'jpg'),
(57, 51, 'dgwork-product-mockup-2.jpg', 'jpg'),
(58, 51, 'dgwork-product-mockup-3.jpg', 'jpg'),
(59, 51, 'dgwork-product-phone-2.jpg', 'jpg'),
(60, 51, 'video_thumbnail.jpg', 'jpg'),
(61, 52, 'Ghostblade Webcomic by WLOP Live Wallpaper.mp4', 'mp4'),
(62, 53, 'bmn.mp3', 'mp3'),
(63, 53, 'bmt.png', 'png'),
(64, 54, 'requy.mp3', 'mp3'),
(65, 55, 'dgwork-header-voice.jpg', 'jpg'),
(66, 55, 'dgwork-product-camera.jpg', 'jpg'),
(67, 55, 'dgwork-product-citynews.jpg', 'jpg'),
(68, 55, 'dgwork-product-surfer.jpg', 'jpg'),
(69, 55, 'dgwork-product-video.jpg', 'jpg'),
(70, 55, 'focux-1024x933-1.jpg', 'jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `total` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_order` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`id`, `total`, `user_id`, `date_order`) VALUES
(96, 12, 54, '2023-03-10 10:22:57'),
(97, 4942.8, 54, '2023-03-10 10:23:23'),
(98, 0, 54, '2023-03-10 10:26:12'),
(99, 30, 54, '2023-03-10 10:26:26'),
(100, 20, 54, '2023-03-10 10:26:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `discount` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `price`, `discount`) VALUES
(29, 96, 42, 12, 0),
(30, 97, 52, 0, 0),
(31, 97, 53, 12357, 0.6),
(32, 98, 51, 0, 0),
(33, 99, 55, 30, 0),
(34, 100, 54, 20, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_product`
--

CREATE TABLE `post_product` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `content` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `title` varchar(350) NOT NULL,
  `img` varchar(500) NOT NULL,
  `source` varchar(500) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` longtext DEFAULT NULL,
  `sDescription` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `discount` double DEFAULT 0,
  `price` double NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `title`, `img`, `source`, `category_id`, `description`, `sDescription`, `discount`, `price`, `created_at`, `updated_at`, `deleted`) VALUES
(42, 'Custom Template #2', 'dgwork-product-mockup-3.jpg', 'Mẫu website dùng thử 123Website - MẪU WEBSITE BÁN HÀNG CÔNG NGHỆ – DGWork.mp3', 1, 'Page Builder\r\nAfter enabled Elementor page builder for the product post, you can customize the product template with front-end editor visually.\r\n\r\nPredefined Templates\r\nWe include some predefined section templates in the Visual Composer template list that allow you to create different section layouts fastly.\r\n\r\nFlexible Layout\r\nYou can create complex layout for the custom product template, make the product page looks more like an optmized landing page.\r\n\r\nPredefined Templates\r\nWe include some predefined section templates in the Visual Composer template list that allow you to create different section layouts fastly.', 'DGWork is a flexible shop & business WordPress EDD Theme offering deep integration with Easy Digital Downloads. It’s perfect to create your self-hosted online shop to sell the digital products like software, photography, videos, audios, eBook or graphic design works, etc. Either multi-product sh...', 0, 12, '2023-03-05 15:36:01', '2023-03-09 18:14:09', 0),
(43, 'Custom Template #1', 'video_thumbnail.jpg', '18+ - Sexy Anime Girl & The Rain - 4K - Live Wallpaper.mkv', 4, 'Flexible Layout\r\nYou can create complex layout for the custom product template, make the product page looks more like an optmized landing page.\r\n\r\nPage Builder\r\nAfter enabled Elementor page builder for the product post, you can customize the product template with front-end editor visually.\r\n\r\nPredefined Templates\r\nWe include some predefined section templates in the Visual Composer template list that allow you to create different section layouts fastly.', 'DGWork is a flexible shop & business WordPress EDD Theme offering deep integration with Easy Digital Downloads. It’s perfect to create your self-hosted online shop to sell the digital products like software, photography, videos, audios, eBook or graphic design works, etc. Either multi-product sh...\r\n\r\nPREVIEW IT\r\nPlay\r\n\r\n\r\n00:00\r\n-14:06\r\nMute\r\n\r\nSettings\r\nEnter fullscreen\r\nPlay\r\n', 0, 1000, '2023-03-05 16:24:18', '2023-03-05 23:24:18', 0),
(44, 'CityNews Theme', 'dgwork-product-citynews.jpg', 'dgwork-product-citynews.jpg', 1, 'CityNews is a newspaper style WordPress Theme that let you create a news, magazine or blog website easily.\r\n\r\nWe include Visual Composer Page Builder into this theme that you can create your own page with highly customized layout. There are four post formats support: Standard, Video, Gallery and Audio. Also, we include some shortcodes and four different blog layouts.If you’re going to create a clean and newspaper style website to focus on write the news, story or journal, don’t miss it.\r\n\r\nOverview\r\nHTML5/CSS3\r\nFully Responsive\r\nRetina Ready\r\nFour different blog Layouts\r\nBeautifu Fullwidth Swipe Slider\r\nVisual Composer Page Builder\r\nCustom Widgets Included\r\nMany Useful Shortcodes Included\r\nGallery Template Ready\r\nAdvanced Theme Options\r\nCross-browser Compatible (IE9+/Firefox/Safari/Chrome/Opera)\r\nWell Documented\r\nWPML Ready\r\nDemo Files Included (XML)\r\nExcellent Support\r\nAnd more…', 'CityNews is a Newspaper WordPress Theme that let you create a news, magazine or blog website easily.', 0, 49, '2023-03-05 16:30:49', '2023-03-09 17:24:38', 0),
(46, 'Test', 'z4156449901375_3d8f82d0ca0b79b132e817eb92e3e91a.jpg', 'import-excel.zip', 1, '', '', 0, 2000, '2023-03-07 07:46:29', '2023-03-08 15:35:58', 1),
(47, 'test', 'PM02_20230306234256.png', 'PM02_20230306234256.png', 1, '', '', 0, 30243, '2023-03-08 14:33:12', '2023-03-09 17:24:01', 1),
(48, 'test', 'z4156449901375_3d8f82d0ca0b79b132e817eb92e3e91a - Copy.jpg', 'dgwork-product-citynews.jpg', 3, '', '', 0, 3952, '2023-03-09 17:49:29', '2023-03-10 00:49:29', 1),
(49, 'Brandminute Mockups', 'dgwork-product-mockup-2.jpg', 'dgwork-product-mockup-2.jpg', 2, '', '', 0, 3000, '2023-03-10 02:51:39', '2023-03-10 09:51:39', 0),
(50, 'Standard Product Template', 'dgwork-product-guitar.jpg', 'dgwork-product-guitar.jpg', 3, '', '', 0, 12002, '2023-03-10 02:52:48', '2023-03-10 09:52:48', 0),
(51, 'Rock and Roll Demo', 'dgwork-product-dj.jpg', 'dgwork-product-dj.jpg', 3, '', '', 0, 0, '2023-03-10 02:53:32', '2023-03-10 09:53:32', 0),
(52, 'Mountain Video Clip', 'simplekey.jpg', 'Ghostblade Webcomic by WLOP Live Wallpaper.mp4', 4, '', '', 0, 0, '2023-03-10 02:54:59', '2023-03-10 09:54:59', 0),
(53, 'Jazz Background Music', 'dgwork-header-voice.jpg', 'bmn.mp3', 1, '', '', 0.6, 12357, '2023-03-10 02:56:31', '2023-03-10 09:56:31', 0),
(54, 'Rễ quý', 'requy.png', 'requy.mp3', 1, '', '', 0, 20, '2023-03-10 02:58:05', '2023-03-10 09:58:05', 0),
(55, 'SimpleKey Theme', 'simplekey.jpg', 'simplekey.jpg', 2, '', '', 0, 30, '2023-03-10 02:59:15', '2023-03-10 09:59:15', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`id`, `name`, `description`) VALUES
(1, 'Admin', 'Có tất cả các quuyền( không ai có quyền chỉnh sửa thông tin hay thêm quyền admin ngoại trừ admin)'),
(2, 'User', 'Khách hàng'),
(3, 'Manage Member', 'được phân tối cao được quản lý các tài khoản của thành viên hệ thống bao gồm người dùng và nhân viên hệ thống'),
(4, 'Product Management', 'Được toàn quyền bên sản phẩm xử lý sản phẩm'),
(5, 'Member update', 'Chỉ được quyền xem và cập nhật thông tin thành viên(lưu ý không có quyền thay đổi phân quyền có cấp lớn hơn bản thân)'),
(6, 'Product updated', 'chỉ được quyền cập nhật thông tin sản phẩm'),
(7, 'Member import', 'Được quyền thêm thành viên\r\nLưu ý chỉ được phân quyền đồng cấp'),
(8, 'Product import', 'Chỉ được quyền nhập sản phẩm'),
(9, 'Member deleted', 'Được quyền xoá thành viên'),
(10, 'Product deleted', 'Chỉ được quyền xoá sản phẩm');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `avatar` varchar(500) NOT NULL DEFAULT 'people.png',
  `fullname` varchar(50) NOT NULL,
  `balance` double NOT NULL DEFAULT 0,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pass` varchar(32) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `avatar`, `fullname`, `balance`, `email`, `phone_number`, `address`, `pass`, `role_id`, `deleted`) VALUES
(54, 'video_thumbnail.jpg', 'Lê Thiên Trí', 54752.2, 'ttri0403@hotmail.com', '0946268770', 'bà rịa vũng tàu', 'f7404b332a2777927e6e446101fdb321', 1, 0),
(55, '124.jpg', 'phạm phúc toàn', 98692.08, 'phamphuctoan2003434@gmail.com', '1234567', 'hcm', 'c8b40ce5d82c9ee082ddc5ad04f8ada8', 2, 1),
(59, 'people.png', 'con heo ngu ', 0, 'thientrile2003@gmail.com', '0919618654', 'Đồng Nai', 'f7404b332a2777927e6e446101fdb321', 2, 1),
(60, 'PM02_20230306234256.png', 'user12', 0, 'admin@admin.com', '0946268770', 'Tỉnh Bà Rịa - Vũng Tàu, Việt Nam', 'f7404b332a2777927e6e446101fdb321', 1, 0),
(61, 'people.png', 'Mmember', 0, 'mmember@gmail.com', '0946268770', '', 'f7404b332a2777927e6e446101fdb321', 5, 0),
(62, 'people.png', 'Member7', 0, 'm7@gmail.com', '', '', 'f7404b332a2777927e6e446101fdb321', 8, 1),
(63, 'people.png', 'ProudutM', 0, 'mproduct@gmail.com', '', '', 'f7404b332a2777927e6e446101fdb321', 7, 1),
(64, 'people.png', 'testnew', 0, 'test12@gmail.com', '', '', 'f7404b332a2777927e6e446101fdb321', 2, 1),
(65, 'people.png', 'product update', 0, 'proupdate@gmail.com', '', '', 'f7404b332a2777927e6e446101fdb321', 6, 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `deteted`
--
ALTER TABLE `deteted`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_id` (`product_id`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_details_order_id` (`order_id`),
  ADD KEY `fk_order_details_product_id` (`product_id`);

--
-- Chỉ mục cho bảng `post_product`
--
ALTER TABLE `post_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post_product_product_id` (`user_id`),
  ADD KEY `fk_post_product_product_id_2` (`product_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `category_id` (`category_id`),
  ADD KEY `fk_product_deleted` (`deleted`);

--
-- Chỉ mục cho bảng `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `fk_user_deleted` (`deleted`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `deteted`
--
ALTER TABLE `deteted`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `post_product`
--
ALTER TABLE `post_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_cart_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Các ràng buộc cho bảng `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_order_details_order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `fk_order_details_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `post_product`
--
ALTER TABLE `post_product`
  ADD CONSTRAINT `fk_post_product_product_id_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_post_product_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `fk_product_deleted` FOREIGN KEY (`deleted`) REFERENCES `deteted` (`id`);

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_deleted` FOREIGN KEY (`deleted`) REFERENCES `deteted` (`id`),
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
