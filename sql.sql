-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 27, 2024 at 03:31 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `graduation_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1: Active, 0: Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `category_id`, `title`, `slug`, `content`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 77, 'Apple phát hành bản beta đầu tiên của iOS 18.3 và iPadOS 18.3, bạn đã cập nhật chưa?', 'apple-phat-hanh-ban-beta-dau-tien-cua-ios-183-va-ipados-183-ban-da-cap-nhat-chua', '<p class=\"ql-align-justify\"><strong>Hôm nay,&nbsp;</strong><a href=\"https://cellphones.com.vn/apple\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\"><strong>Apple</strong></a><strong>&nbsp;đã tung ra bản beta đầu tiên của bản cập nhật iOS 18.3 và iPadOS 18.3 sắp ra mắt cho các nhà phát triển để họ thử nghiệm trước các tính năng mới.</strong></p><p class=\"ql-align-justify\">Được biết, iOS/iPadOS 18.3 beta 1 xuất hiện chỉ sau khoảng 1 tuần kể từ khi “Nhà Táo” chính thức phát hành các bản cập nhật iOS 18.2 và iPadOS 18.2 để mang đến hàng loạt tính năng mới cho người dùng.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/trannghia/apple-phat-hanh-ios-18-3.jpg\" alt=\"Apple phát hành bản beta đầu tiên của iOS 18.3 \" height=\"675\" width=\"1200\">Apple phát hành bản beta đầu tiên của iOS 18.3</p><p class=\"ql-align-justify\">Hiện tại, các nhà phát triển đã có thể tải xuống iOS 18.3 và iPadOS 18.3t trên&nbsp;<a href=\"https://cellphones.com.vn/mobile/apple.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">iPhone</a>/<a href=\"https://cellphones.com.vn/tablet/ipad.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">iPad</a>&nbsp;tương thích bằng cách mở&nbsp;<a href=\"https://cellphones.com.vn/sforum/thu-thuat/ung-dung\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">ứng dụng</a>&nbsp;<strong>Cài đặt</strong>, chọn&nbsp;<strong>Cài đặt chung</strong>&nbsp;&gt;&nbsp;<strong>Cập nhật phần mềm</strong>.</p><p class=\"ql-align-justify\">Đáng tiếc là chúng ta hiện chưa có thông tin về các tính năng mà Apple đã mang đến bản thử nghiệm mới nhất của&nbsp;<a href=\"https://cellphones.com.vn/sforum/cach-cap-nhat-ios-18\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">hệ điều hành iOS 18</a>, nhưng Apple vẫn đang nỗ lực triển khai các tính năng Apple Intelligence. iOS 18.2 và iPadOS 18.2 đã tích hợp Image Playground, Genmoji và Siri&nbsp;<a href=\"https://cellphones.com.vn/sforum/cach-dung-chat-gpt\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">ChatGPT</a>, nhưng vẫn còn các chức năng ‌Siri‌ mới dự kiến sẽ ra mắt vào năm sau.</p><p class=\"ql-align-justify\">Chúng ta có thể thấy các bản cập nhật cho ‌Siri‌ với iOS 18.3 và các tính năng mà Apple đang phát triển bao gồm ngữ cảnh cá nhân, nhận thức trên&nbsp;<a href=\"https://cellphones.com.vn/man-hinh.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">màn hình</a>&nbsp;và khả năng làm nhiều việc hơn trong các ứng dụng. Cùng chờ xem nhé!</p><p class=\"ql-align-justify\">Nguồn: Macrumors</p>', 'blog/2QXT5jutqjtVD2jeo1xNjF4T43ddEaVaRsDhPKUl.jpg', 1, '2024-12-16 20:42:11', '2024-12-16 21:09:07'),
(2, 77, 'Gaming Phone không chỉ có hiệu năng, những tính năng này đã tạo ra trải nghiệm gaming vượt trôi', 'gaming-phone-khong-chi-co-hieu-nang-nhung-tinh-nang-nay-da-tao-ra-trai-nghiem-gaming-vuot-troi', '<p class=\"ql-align-justify\"><strong>Khi lựa chọn một chiếc&nbsp;</strong><a href=\"https://cellphones.com.vn/mobile.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\"><strong>điện thoại</strong></a><strong>&nbsp;chuyên game, hầu hết thứ mà mọi người nghĩ đến đầu tiên có lẽ là hiệu năng - bộ vi xử lý mạnh mẽ, tần số quét siêu cao và hệ thống tản nhiệt mạnh. Đúng vậy, đó là cốt lõi của một chiếc điện thoại gaming, nhưng thực tế, việc nâng cao trải nghiệm chơi game không chỉ phụ thuộc vào hiệu năng phần cứng mà còn dựa vào những tính năng khác hỗ trợ cho cấu hình đó.</strong></p><p class=\"ql-align-justify\">Một số tính năng nhỏ nhưng lại cực kỳ hữu dụng có thể giúp quá trình chơi game mượt mà và thú vị hơn. Hôm nay, chúng ta sẽ cùng tìm hiểu về những tính năng được trang bị trên những chiếc điện thoại chuyên game như iQOO Neo10 Pro và&nbsp;Red Magic 10 PRO+, cùng xem những chi tiết này đã khiến chúng trở nên khác biệt như thế nào nhé!</p><h2 class=\"ql-align-justify\">Những công nghệ ấn tượng trên iQOO Neo10 Pro&nbsp;</h2><p class=\"ql-align-justify\">Điểm nổi bật của iQOO Neo10 Pro chắc chắn là hiệu năng chơi game ấn tượng. Thiết bị tiếp tục được trang bị cấu hình phần cứng với bộ đôi chip xử lý hàng đầu. Với nhiều năm kinh nghiệm tinh chỉnh chip Dimensity, hãng&nbsp;<a href=\"https://cellphones.com.vn/mobile/vivo.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">Vivo</a>&nbsp;đã nâng cao hơn nữa hiệu năng và hiệu suất năng lượng của chip Dimensity 9400, kết hợp với chip tự nghiên cứu Q2, cho ra được&nbsp;<a href=\"https://cellphones.com.vn/sforum\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">công nghệ</a>&nbsp;ổn định khung hình cho các tựa game phổ biến, giúp cho trải nghiệm chơi&nbsp;<a href=\"https://cellphones.com.vn/sforum/tag/genshin-impact\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">Genshin Impact</a>, Honkai: Star Rail, Vương Giả Vinh Diệu trong thời gian dài mà không bị giật lag.</p><p class=\"ql-align-justify\">Chi tiết cấu hình của chip Dimensity 9400 sẽ không được đi sâu trong bài viết này, thay vào đó hãy tìm hiểu về nó tại những bài viết khác trên Sforum. Chúng ta sẽ tiến đến&nbsp;phần điểm benchmark của máy được cập nhật mới nhất:</p><p class=\"ql-align-justify\">Từ kết quả có thể thấy, điểm AnTuTu của iQOO Neo10 Pro có thể đạt 2,950,905, điểm số này đã có thể dễ dàng xử lý các tựa game di động nặng. Trong bài kiểm tra 3DMark Wild Life Extreme, tổng điểm của iQOO Neo10 Pro là 6509, điểm GeekBench đơn nhân là 2778 và đa nhân là 8908.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-1.jpg\" alt=\"Tính năng gaming phone vượt trội\">điểm AnTuTu của iQOO Neo10 Pro có thể đạt 2,950,905, điểm số này đã có thể dễ dàng xử lý các tựa game di động nặng</p><p class=\"ql-align-justify\">Quan trọng nhất là, iQOO Neo10 Pro được trang bị chip tự nghiên cứu Q2 giống như iQOO 13. Sự bổ sung của Q2 đã nâng cao hơn nữa khả năng xử lý đồ họa, được tối ưu hóa đặc biệt cho game. Khi xử lý hình ảnh game có thể thể hiện kết cấu tinh tế hơn, hiệu ứng ánh sáng chân thực hơn, giúp chất lượng hình ảnh game được cải thiện đáng kể.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-2.jpg\" alt=\"Tính năng gaming phone vượt trội\">iQOO Neo10 Pro được trang bị chip tự nghiên cứu Q2 giống như iQOO 13 giúp&nbsp;giúp chất lượng hình ảnh game được cải thiện đáng kể</p><p class=\"ql-align-justify\">Công nghệ siêu phân giải 1.5K có thể khiến hình ảnh game thể hiện độ nét vượt qua độ phân giải gốc, trong các tựa game như Genshin Impact, các chi tiết như khuôn mặt nhân vật trong game, kết cấu kiến trúc đều phong phú hơn, mang chất lượng hình ảnh tốt hơn trên điện thoại di động.</p><p class=\"ql-align-justify\">Để các bạn độc giả có thể hiểu hơn về bài viết, Sforum xin phép đưa ra một thuật ngữ và định nghĩa có tên là&nbsp;Nội suy khung hình: Tăng số FPS bằng cách tạo ra khung hình mới, bổ sung thông tin hình ảnh và làm mượt chuyển động.&nbsp;Nó phân tích chuyển động của các vật thể trong các khung hình gốc và dự đoán vị trí của chúng ở các thời điểm giữa hai khung hình. Sau đó, nó vẽ ra các khung hình mới dựa trên những dự đoán này. Kết quả là video mượt mà hơn, ít bị giật hình, đặc biệt là trong các cảnh chuyển động nhanh.&nbsp;</p><p class=\"ql-align-justify\">Khác với những chiếc điện thoại khác, iQOO Neo10 có thể đo và thấy được tốc độ khung hình nội suy, có thể xem tốc độ khung hình nội suy theo thời gian thực trong Perfdog, cũng có thể xem hiển thị tốc độ khung hình theo thời gian thực trong Game Box. Ba tựa game PUBG Mobile, Vương Giả Vinh Diệu, Garena&nbsp;<a href=\"https://cellphones.com.vn/sforum/tag/free-fire\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">Free Fire</a>&nbsp;được lựa chọn để kiểm tra hiệu ứng 144Hz.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-3.jpg\" alt=\"Tính năng gaming phone vượt trội\"></p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-4.jpg\" alt=\"Tính năng gaming phone vượt trội\"></p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-5.jpg\" alt=\"Tính năng gaming phone vượt trội\"></p><p class=\"ql-align-justify\">Sau khi kiểm tra, kết quả cho thấy cả ba tựa game trên đều hoàn toàn có thể đạt khung hình tối đa, trong đó chỉ số ổn định khung hình của PUBG Mobile và Vương Giả Vinh Diệu chỉ là 0.x. Thuật toán nội suy khung hình tự nghiên cứu hoàn toàn mới kết hợp với sức mạnh tính toán hiệu quả năng lượng cao chuyên dụng do Q2 cung cấp đã giải quyết các vấn đề thường gặp ở chất lượng hình ảnh, độ trễ, mức tiêu thụ điện năng,... của chức năng nội suy khung hình, mang lại trải nghiệm rất tốt.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-6.jpg\" alt=\"Tính năng gaming phone vượt trội\">Chức năng nội suy khung hình trên&nbsp;iQOO 13 mang lại trải nghiệm rất tốt</p><p class=\"ql-align-justify\">Có thể thấy, công nghệ siêu khung hình 144FPS gốc đảm bảo sự mượt mà của hình ảnh game. Ở chế độ tốc độ khung hình cao, quá trình chuyển đổi hình ảnh tự nhiên mượt mà, hầu như không có hiện tượng giật lag, đồng thời vẫn kiểm soát hiệu quả mức tiêu thụ điện năng, cho phép người chơi thoải mái chơi game trong thời gian dài mà không cần lo lắng về vấn đề pin.</p><p class=\"ql-align-justify\">Ngoài ra, khi lấy Genshin Impact làm ví dụ thử nghiệm thực tế trong nửa giờ. Neo10 gần đạt 60 khung hình tối đa, nhiệt độ mặt sau chỉ là 43.5 độ C.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-7.jpg\" alt=\"Tính năng gaming phone vượt trội\">Neo10 gần đạt 60 khung hình tối đa trong Genshin Impact</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-8.jpg\" alt=\"Tính năng gaming phone vượt trội\">Nhiệt độ&nbsp;Neo10 gần đạt 43.5 độ với 30 phút chơi Genshin Impact</p><p class=\"ql-align-justify\">iQOO Neo10 cũng hỗ trợ rung 4D, bổ sung thêm phản hồi xúc giác phong phú cho game. Trong các cảnh game khác nhau, như bắn súng, nổ trong game bắn súng, va chạm, tăng tốc trong game đua xe, v.v., điện thoại sẽ cung cấp hiệu ứng rung tương ứng theo cảnh, cho phép người chơi cảm nhận trực quan hơn các hành động và sự kiện khác nhau trong game, nâng cao hơn nữa cảm giác đắm chìm và trải nghiệm thao tác của game.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-9.jpg\" alt=\"Tính năng gaming phone vượt trội\">iQOO Neo10 cũng hỗ trợ rung 4D, bổ sung thêm phản hồi xúc giác phong phú cho game</p><p class=\"ql-align-justify\">So với thế hệ Neo9 trước, dung lượng pin của iQOO Neo10 tăng thêm 940mAh cho tổng dung lượng lên tới 6100mAh. Trong đó, phiên bản vỏ sau Armor có độ mỏng chỉ 7.99mm, trọng lượng chỉ 199g. Điều này không thể không nhắc đến công nghệ pin mới được trang bị trên iQOO Neo10. Công nghệ pin mật độ năng lượng cao cực âm silicon carbon thế hệ thứ ba giúp pin có dung lượng lớn và thân máy mỏng nhẹ.</p><p class=\"ql-align-justify\">Điều đáng nói là, khả năng tương thích sạc của iQOO Neo10 là hàng đầu trong thế giới smartphone hiện nay. iQOO Neo10 hỗ trợ sạc nhanh siêu tốc 120W và hỗ trợ công nghệ sạc PPS tối đa 100W, được trang bị bộ sạc nhanh siêu tốc mini 120W tiêu chuẩn, hỗ trợ công nghệ sạc PD tối đa 100W, một bộ thiết bị có thể đáp ứng nhu cầu sạc của nhiều thiết bị.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-10.jpg\" alt=\"Tính năng gaming phone vượt trội\">Từ mức pin 0% sạc đến 100%, Neo10 mất tổng cộng 33 phút, 25 phút đầu tiên Neo10 sạc được 83% pin, có thể đáp ứng nhu cầu sạc nhanh hàng ngày của người dùng.</p><p class=\"ql-align-justify\">Về thời lượng pin, sử dụng mô hình kiểm tra thời lượng pin cường độ cao trong 5 giờ ở trong môi trường nhiệt độ phòng, kết nối Wi-Fi, tắt Bluetooth, GPS, độ sáng&nbsp;<a href=\"https://cellphones.com.vn/man-hinh.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">màn hình</a>, âm lượng đều được đặt mức 50% cho ra kết quả như sau:</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-11.jpg\" alt=\"Tính năng gaming phone vượt trội\">Với đa tác vụ sử dụng trong cơ bản trong 5 giờ,&nbsp;iQOO Neo10 còn lại 70% pin</p><p class=\"ql-align-justify\">Ngoài ra, chức năng cấp nguồn trực tiếp là một điểm nổi bật của dòng iQOO Neo10, rất thiết thực đối với những người chơi thích vừa sạc vừa chơi. Trong quá trình chơi game tải nặng, nó có thể đảm bảo hiệu suất khung hình ổn định của điện thoại, đồng thời kiểm soát hiệu quả nhiệt độ thân máy, tránh hiện tượng giảm tần số do quá nhiệt, cho phép người chơi tận hưởng trải nghiệm chơi game mượt mà ngay cả khi đang sạc.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-12.jpg\" alt=\"Tính năng gaming phone vượt trội\">Chức năng cấp nguồn trực tiếp là một điểm nổi bật của dòng iQOO Neo10</p><p class=\"ql-align-justify\"><br></p><h2 class=\"ql-align-justify\">Trên gaming phone Red Magic 10 PRO+, những tính năng cũng thú vị không kém</h2><p class=\"ql-align-justify\">Red Magic 10 PRO+ được trang bị vi xử lý Snapdragon 8 Gen 2 với hai lõi siêu lớn có tần số lên đến 4.32GHz. So với Snapdragon 8 Gen 1 trước đó, hiệu năng đơn nhân tăng 35%, hiệu năng đa nhân tăng 30%. Toàn bộ dòng máy được trang bị bộ nhớ LPDDR5X Ultra và bộ nhớ UFS 4.0 PRO tiêu chuẩn, đồng thời cũng được trang bị chip Redcore R3 tự nghiên cứu của Red Magic.</p><p class=\"ql-align-justify\">Công cụ tính toán về năng lượng tiêu thụ dự đoán chính xác nhu cầu sức mạnh, mang lại tỷ lệ hiệu suất năng lượng cao hơn, hỗ trợ đồng thời siêu phân giải và siêu khung hình 2K+120FPS.</p><p class=\"ql-align-justify\">Câu hỏi về hiệu năng thực tế của Red Magic 10 PRO+ sẽ được khám quá qua bài kiểm tra điểm benchmark như sau:</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-13.jpg\" alt=\"Tính năng gaming phone vượt trội\">Điểm AnTuTu của Red Magic 10 PRO+ có thể đạt 2.95 triệu điểm, một điểm số rất ấn tượng</p><p class=\"ql-align-justify\">Từ kết quả điểm benchmark, điểm AnTuTu của Red Magic 10 PRO+ có thể đạt 2.95 triệu, trong bài kiểm tra Geekbench 6, điểm đơn nhân của Red Magic 10 PRO+ là 3186, điểm đa nhân đạt 9987, cũng có sự tiến bộ rõ rệt so với sản phẩm thế hệ trước.</p><p class=\"ql-align-justify\">Trải nghiệm hiệu năng tốt cũng không chỉ dừng lại ở các thông số phần cứng và điểm benchmark, để hiểu rõ hơn về hiệu suất của những phần cứng này trên Red Magic 10 PRO+, một bài kiểm tra khác trên ba tựa game khá phổ biến là Genshin Impact, Honkai: Star Rail,&nbsp;<a href=\"https://cellphones.com.vn/sforum/tag/lien-minh-huyen-thoai\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">Liên Minh Huyền Thoại</a>: Tốc Chiến để kiểm tra hiệu năng thực tế của Red Magic 10 PRO+.</p><p class=\"ql-align-justify\">Trong Genshin Impact, khi bật chất lượng hình ảnh cao và 60 khung hình, Red Magic 10 PRO+ đạt tốc độ khung hình trung bình 59.3 khung hình trong quá trình chơi game nửa giờ, hiệu suất tổng thể khá ổn định, xứng đáng với danh xưng \"gaming phone\".</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-14.jpg\" alt=\"Tính năng gaming phone vượt trội\">Trong Genshin Impact, khi bật chất lượng hình ảnh cao và 60 khung hình, Red Magic 10 PRO+ đạt tốc độ khung hình trung bình 59.3</p><p class=\"ql-align-justify\">Trong Honkai: Star Rail, khi bật chất lượng hình ảnh cao và 60 khung hình, Red Magic 10 PRO+ đạt tốc độ khung hình trung bình 61.2 khung hình trong quá trình chơi game 30 phút, hiệu suất tổng thể cũng ổn định.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-15.jpg\" alt=\"Tính năng gaming phone vượt trội\">Trong Honkai: Star Rail, khi bật chất lượng hình ảnh cao + 60 khung hình, Red Magic 10 PRO+ đạt tốc độ khung hình trung bình 61.2</p><p class=\"ql-align-justify\">Red Magic cũng không lãng phí màn hình 144Hz được trang bị trên chiếc máy này, nó hỗ trợ chế độ 144Hz cho Liên Minh Huyền Thoại: Tốc Chiến. Sau một trận đấu xếp hạng hơn mười phút, tốc độ khung hình trung bình đạt 143.8 khung hình, chỉ số ổn định khung hình chỉ 0.3, ngay cả trong các trận giao tranh quy mô lớn phải xứ lý đồ họa nhiều, máy vẫn có thể giữ ổn định khung hình.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-16.jpg\" alt=\"Tính năng gaming phone vượt trội\">Neo hỗ trợ chế độ 144Hz cho Liên Minh Huyền Thoại: Tốc Chiến,&nbsp;đạt 143.8 khung hình thực tế rất ổn định</p><p class=\"ql-align-justify\">Điều ngạc nhiên nhất là khả năng tản nhiệt của Red Magic sau khi ba tựa game được kiểm tra liên tục, nhiệt độ mặt sau thân máy chỉ 34 độ C, đây cũng là điểm đáng tiền nhất khiến việc chơi game trên Red Magic rất sướng. Cảm giác chơi game liên tục mà thiết bị điện tử bạn đang cầm trực tiếp trên tay không nóng lên quá nhiều thật sự là một cảm giác khác biệt.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-17.jpg\" alt=\"Tính năng gaming phone vượt trội\">Sau khi cả ba tựa game được kiểm tra liên tục, nhiệt độ mặt sau thân máy của&nbsp;Red Magic 10 PRO+ chỉ ở mức 34 độ C - cực kỳ xuất sắc</p><p class=\"ql-align-justify\">Red Magic 10 PRO+ lần đầu tiên trong thế giới smartphone áp dụng công nghệ tản nhiệt \"kim loại lỏng phức hợp\" là vật liệu tản nhiệt cấp hàng không vũ trụ và dành cho máy tính xách tay chuyên chơi game. Khả năng dẫn nhiệt của nó cao hơn nhiều so với gel tản nhiệt, nguyên lý hoạt động là sau khi bị nóng thì sẽ nhanh chóng hấp thụ nhiệt, bản thân nó chuyển từ trạng thái rắn sang lỏng, sau khi làm mát sẽ trở lại trạng thái rắn.</p><p class=\"ql-align-justify\">Nhờ có vậy, ở bên trong điện thoại thì kim loại lỏng có thể nhanh chóng truyền nhiệt do CPU hoặc GPU tạo ra đến mô-đun tản nhiệt, từ đó làm giảm nhiệt độ của chip một cách hiệu quả. Còn \"cấu trúc sandwich\" sáng tạo của Red Magic cũng góp phần không nhỏ, hai lớp trên và dưới sử dụng hợp kim nhiệt độ thấp, lớp giữa là indium, khi nhiệt độ thân máy tăng cao, hợp kim nhiệt độ thấp sẽ ở trạng thái nóng chảy nhẹ bám vào indium, đảm bảo hiệu suất dẫn nhiệt đồng thời không bị chảy, đảm bảo an toàn, giải quyết điểm khó trong quy trình đóng gói kim loại lỏng truyền thống.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-18.jpg\" alt=\"Tính năng gaming phone vượt trội\">Red Magic 10 PRO+ lần đầu tiên trong thế giới smartphone áp dụng công nghệ tản nhiệt \"kim loại lỏng phức hợp\" mang đến hiệu quả xuất sắc</p><p class=\"ql-align-justify\">Red Magic 10 PRO+ còn được trang bị quạt ly tâm tốc độ cao hoàn toàn mới, tốc độ quay 23,000 vòng/phút với thiết kế cánh quạt cao thấp được nâng cấp, tăng diện tích quét gió, tốc độ gió tăng 10%. Hệ thống tản nhiệt ICEX Magic Cool cũng được nâng cấp toàn diện, trong 10 lớp hệ thống tản nhiệt Magic.</p><h2 class=\"ql-align-justify\">Tổng kết</h2><p class=\"ql-align-justify\">Tóm lại, dù là iQOO Neo10 Pro, Red Magic 10 PRO+ hay các sản phẩm gaming phone khác đều thể hiện rõ tham vọng dẫn đầu trong phân khúc điện thoại chơi game. Không chỉ sở hữu hiệu năng mạnh mẽ nhờ vi xử lý hàng đầu và chip xử lý đồ họa chuyên dụng, những thiết bị này được trang bị những tính năng hỗ trợ chơi game chuyên sâu, từ công nghệ ổn định và nội suy khung hình, tản nhiệt tiên tiến, cho đến những chi tiết nhỏ như rung 4D và phím trigger siêu nhạy.</p><p class=\"ql-align-justify\">Sự nâng cấp ghi điểm với công nghệ pin kép mới, cho khả năng sạc nhanh vượt trội, hệ thống tản nhiệt \"kim loại lỏng phức hợp\" giúp máy luôn mát mẻ ngay cả khi chơi game nặng.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/tinh-nang-gamingphone-vuot-troi-thumb.jpg\" alt=\"Tính năng gaming phone vượt trội\">iQOO Neo10 Pro và Red Magic 10 PRO+ là những mẫu máy tiêu biểu cho nhiều bước tiến của gaming phone</p><p class=\"ql-align-justify\">Việc nâng cấp tính năng tạo ra lợi thế trong thị trường cạnh tranh khốc liệt giữa thị trường những chiếc gaming phone hứa hẹn sẽ mang đến cho người dùng những trải nghiệm chơi game di động đỉnh cao.</p><p class=\"ql-align-justify\">Mỗi hãng điện thoại đều đang trang bị cho những sản phẩm của mình những tính năng nâng cao để mang đến trải nghiệm tuyệt vời nhất cho người dùng. Nhìn chung, trong một thị trường có sự cạnh tranh như vậy thì người dùng chúng ta sẽ là phía được lợi nhất. Tương lai của gaming phone là rất đáng chờ đợi.</p><p class=\"ql-align-justify\">Nguồn: zol</p>', 'blog/TToR8r6EE3IF9FIYwEZiOLXxjPXcM9yGt5RBuHAn.jpg', 1, '2024-12-16 22:59:15', '2024-12-16 22:59:15'),
(3, 77, 'Đánh giá ZTE Nubia Z70 Ultra: Trải nghiệm flagship khác biệt', 'danh-gia-zte-nubia-z70-ultra-trai-nghiem-flagship-khac-biet', '<p class=\"ql-align-justify\"><strong>ZTE Nubia Z70 Ultra là một flagship mới với thiết kế&nbsp;</strong><a href=\"https://cellphones.com.vn/man-hinh.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\"><strong>màn hình</strong></a><strong>&nbsp;\"True Full Screen\" ấn tượng, chip Snapdragon 8 Gen 3 mạnh mẽ,&nbsp;</strong><a href=\"https://cellphones.com.vn/phu-kien/camera.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\"><strong>camera</strong></a><strong>&nbsp;35mm, pin 6150mAh và&nbsp;</strong><a href=\"https://cellphones.com.vn/sforum\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\"><strong>công nghệ</strong></a><strong>&nbsp;sạc nhanh 80W, mang đến hiệu suất mạnh mẽ và trải nghiệm hình ảnh tuyệt vời.</strong></p><p class=\"ql-align-justify\">Năm nay là một năm có nhiều thay đổi lớn về diện mạo của các mẫu&nbsp;<a href=\"https://cellphones.com.vn/mobile.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">điện thoại</a>&nbsp;flagship. Từ đầu năm đến cuối năm, nhiều flagship đã dần dần từ bỏ thiết kế bo tròn và màn hình cong bốn cạnh, thiết kế vuông vức có thể nói đã trở thành xu hướng chính trên thị trường. Giữa xu hướng thay đổi này,<a href=\"https://cellphones.com.vn/mobile/nubia.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">&nbsp;Nubia</a>&nbsp;- hãng đang nỗ lực tạo ra màn hình tràn viền thực sự với không lỗ khoét camera đã nổi lên. Năm nay, họ không làm người dùng thất vọng, mang đến flagship mới với “True Full Screen” Z70 Ultra, đồng thời tạo ra một số trải nghiệm AI độc đáo.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/danh-gia-zte-nubia-z70-ultra-1.jpg\" alt=\"Đánh giá ZTE Nubia Z70 Ultra\">Flagship mới đến từ hãng Nubia với màn hình tràn viền - Z70 Ultra hứa hẹn tạo ra một số trải nghiệm AI độc đáo</p><h2 class=\"ql-align-justify\">Thiết kế toát lên vẻ mạnh mẽ và nút chụp ảnh mới</h2><p class=\"ql-align-justify\">Như đã đề cập ở đầu bài, diện mạo của Nubia Z70 Ultra vẫn giữ vững thẩm mỹ độc đáo của hãng, và mẫu máy mới này cũng tiếp tục phong cách mạnh mẽ, không quá góc cạnh nhưng vẫn có hình dáng tổng thể khá vuông vức. Máy cũng có các chi tiết bo tròn hoặc cong ở mỗi góc, làm nổi bật vẻ tinh tế mà không gây cảm giác khó chịu khi cầm nắm.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/danh-gia-zte-nubia-z70-ultra-2.jpg\" alt=\"Đánh giá ZTE Nubia Z70 Ultra\">Nubia Z70 Ultra vẫn giữ vững thẩm mỹ độc đáo, làm nổi bật vẻ tinh tế mà không gây cảm giác khó chịu khi cầm nắm</p><p class=\"ql-align-justify\">Trong khuôn khổ bài viết, mẫu máy được đề cập đến có màu sắc “Shampoo”, tổng thể có màu vàng nhạt kết hợp với những màu sắc đỏ và đen khá bắt mắt. Quy trình xử lý chất liệu có tên \"Star Dome Soft Sand\" để tạo ra mặt kính AG mờ có thể nói là sự kết hợp hoàn hảo, cùng với các đường nét vuông vức và mạnh mẽ, tạo nên sự tương phản, nhưng vẫn toát lên cảm giác trẻ trung.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/danh-gia-zte-nubia-z70-ultra-3.jpg\" alt=\"Đánh giá ZTE Nubia Z70 Ultra\">Mặt kính AG mờ kết hợp hoàn hảo cùng với các đường nét vuông vức và mạnh mẽ, tạo nên sự tương phản, nhưng vẫn toát lên cảm giác trẻ trung của&nbsp;ZTE Nubia Z70 Ultra</p><p class=\"ql-align-justify\">Về phần cụm camera ở mặt sau, Nubia Z70 Ultra cũng được xử lý khá tinh tế và khéo léo của nhà sản xuất. Toàn bộ bề mặt trang trí của nó được chia thành hai phần, bên trên được thiết kế chi tiết phù hợp với màu sắc của mặt lưng, trong khi phần dưới là một tấm kính trang trí màu đen, được sắp xếp với hai camera phụ, và các chi tiết được xử lý cong ở cạnh, dù không có quá nhiều yếu tố trang trí nhưng vẫn rất chi tiết, tạo ra sự sang trọng cho sản phẩm.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/danh-gia-zte-nubia-z70-ultra-4.jpg\" alt=\"Đánh giá ZTE Nubia Z70 Ultra\">Thiết kế cụm camera của Nubia Z70 Ultra được xử lý tinh tế với hai phần cụm camera được tách ra và sắp xếp hài hòa</p><p class=\"ql-align-justify\">So với các mẫu Z series trước đây, Nubia Z70 Ultra vẫn giữ lại nút trượt, nhưng đã được chuyển sang bên trái của thân máy, vị trí ban đầu của nó giờ là một nút chụp ảnh chuyên dụng mới.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/danh-gia-zte-nubia-z70-ultra-5.jpg\" alt=\"Đánh giá ZTE Nubia Z70 Ultra\">Hình ảnh nút chụp ảnh mới trên&nbsp;ZTE Nubia Z70 Ultra</p><p class=\"ql-align-justify\"><br></p><h2 class=\"ql-align-justify\">Màn hình tràn viền thực thụ, sắc nét và bảo vệ mắt tốt hơn</h2><p class=\"ql-align-justify\">Mặt trước của Nubia Z70 Ultra vẫn giữ “Màn hình tràn viền thực thụ” đặc trưng của hãng. Màn hình từ BOE đã được nâng cấp với vật liệu phát sáng Q9+, và quan trọng nhất, độ phân giải đã được nâng lên mức 2688×1216, đồng thời giấu camera trước ở phía trên, tạo nên sự độc đáo ngay từ cái nhìn đầu tiên.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/danh-gia-zte-nubia-z70-ultra-6.jpg\" alt=\"Đánh giá ZTE Nubia Z70 Ultra\">ZTE Nubia Z70 Ultra giấu camera trước ở phía trên, màn hình tạo nên sự độc đáo ngay từ cái nhìn đầu tiên</p><p class=\"ql-align-justify\">Cùng với độ phân giải được nâng cấp, màn hình vẫn mang lại chất lượng hiển thị ấn tượng. Trước hết, về khả năng hiển thị màu sắc, các màu chuẩn của Nubia Z70 Ultra đạt 98.5% và 135.6% dải màu sRGB và ở chế độ sống động (Vivid Mode), nó thậm chí có thể đạt 127.4% dải màu DCI P3.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/danh-gia-zte-nubia-z70-ultra-7.jpg\" alt=\"Đánh giá ZTE Nubia Z70 Ultra\">Thông số hiển thị màu sắc của&nbsp;ZTE Nubia Z70 Ultra&nbsp;(chế độ chuẩn bên trái và chế độ sống động bên phải)</p><p class=\"ql-align-justify\">Cùng với phạm vi màu sắc tuyệt vời, màn hình còn có độ chính xác màu sắc xuất sắc. Ở chế độ chuẩn, giá trị ΔE trung bình chỉ là 0.28, và ΔE tối đa chỉ là 0.98, rất chính xác. Thậm chí ở chế độ sống động, độ chính xác màu sắc vẫn rất cao, với giá trị ΔE trung bình chỉ là 0.38, và ΔE tối đa chỉ là 1.74, thể hiện sự chính xác khá cao về hiệu suất màu sắc.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/danh-gia-zte-nubia-z70-ultra-8.jpg\" alt=\"Đánh giá ZTE Nubia Z70 Ultra\">Màn hình&nbsp;ZTE Nubia Z70 Ultra còn có độ chính xác màu sắc xuất sắc (Bên trên: Chế độ chuẩn, bên dưới: Chế độ sống động)</p><p class=\"ql-align-justify\">Màn hình của Nubia Z70 Ultra cũng rất xuất sắc về bảo vệ mắt, đã đạt chứng nhận ánh sáng xanh thấp cấp độ phần cứng SGS, chưa kể đến việc nó còn hỗ trợ điều chỉnh độ sáng PWM tần số siêu cao lên tới 2592Hz. Tổng thể, màn hình này không chỉ có thiết kế tuyệt vời mà còn nổi bật về bảo vệ mắt và khả năng hiển thị, giúp Nubia tiếp tục dẫn đầu trong xu hướng “màn hình tràn viền thực thụ”.</p><h2 class=\"ql-align-justify\">Cụm camera cho chất lượng ảnh tuyệt vời</h2><p class=\"ql-align-justify\">Module camera của Nubia Z70 Ultra vẫn gồm ba camera, được xây dựng xung quanh một camera chính 35mm, và cảm biến của camera chính vẫn là cảm biến Sony 9-Series kinh điển. Tuy nhiên, có rất nhiều thay đổi ở các ống kính, camera chính được bổ sung thiết kế khẩu độ thay đổi, góc siêu rộng đã giảm còn 13mm, và camera telephoto periscope đã rút ngắn khoảng cách lấy nét gần nhất, giờ đây bạn có thể chụp ảnh macro telephoto. Tổng thể, đây là một bản nâng cấp toàn diện để tăng cường tính thực tế và tiện lợi.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/haianh/icemag/danh-gia-zte-nubia-z70-ultra-9.jpg\" alt=\"Đánh giá ZTE Nubia Z70 Ultra\">Module camera của Nubia Z70 Ultra vẫn gồm ba camera, được xây dựng xung quanh một camera chính 35mm và nâng cấp camera tele</p><p class=\"ql-align-justify\">Hãy cùng xem qua các bức ảnh mẫu. Camera chính của Nubia Z70 Ultra vẫn giữ được chất lượng như trước về độ phân giải và khả năng tái tạo màu sắc, với độ bão hòa và sống động, và với tính năng \"Auto Blue Sky Enhancement\" được bật mặc định trong cài đặt, nó mang lại cảm giác rõ nét khi ghi lại hình ảnh bầu trời, chẳng hạn. Camera cũng có khẩu độ chụp phong cảnh rất thú vị, tương thích chụp với khẩu độ tối đa F/1.59 trong nhiều điều kiện sử dụng và chuyển sang khẩu độ nhỏ hơn khi chụp cận cảnh.</p><p><br></p>', 'blog/SLQWxfuyQGvqsiwU7M345zik9mYyXF5SFOzzcoRu.jpg', 1, '2024-12-16 23:01:00', '2024-12-16 23:01:46'),
(4, 77, 'Apple chính thức phát hành iOS 18.2 và iPadOS 18.2 với hàng loạt tính năng mới, mời bạn cập nhật', 'apple-chinh-thuc-phat-hanh-ios-182-va-ipados-182-voi-hang-loat-tinh-nang-moi-moi-ban-cap-nhat', '<p class=\"ql-align-justify\"><strong>Sau nhiều tuần thử nghiệm,&nbsp;</strong><a href=\"https://cellphones.com.vn/apple\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\"><strong>Apple</strong></a><strong>&nbsp;hôm nay đã chính thức phát hành iOS 18.2 và iPadOS 18.2, bản cập nhật lớn thứ hai của các hệ điều hành iOS/iPadOS 18.</strong></p><p class=\"ql-align-justify\">Các phần mềm mới này xuất hiện chỉ sau khoảng hơn 1 tháng kể từ khi “Táo Khuyết” phát hành iOS 18.1 và iPadOS 18.1 để mang đến hàng loạt tính năng AI thú vị cho người dùng iPhone/iPad.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/trannghia/iOS-18-2-duoc-phat-hanh.jpg\" alt=\"Apple phát hành iOS 18.2\" height=\"675\" width=\"1200\">Apple phát hành iOS 18.2</p><p class=\"ql-align-justify\">Hiện tại, iOS 18.2 và iPadOS 18.2 đã có thể được tải xuống qua mạng trên các iPhone, iPad đủ điều kiện bằng cách vào&nbsp;<strong>Cài đặt&nbsp;</strong>&gt;<strong>&nbsp;Cài đặt chung&nbsp;</strong>&gt;<strong>&nbsp;Cập nhật phần mềm.</strong></p><p class=\"ql-align-justify\">iOS 18.2 và iPadOS 18.2 giới thiệu các tính năng mới của Apple Intelligence, bao gồm khả năng tạo hình ảnh. Image Playground là ứng dụng mới để tạo hình ảnh dựa trên mô tả văn bản và bạn có thể thêm mọi loại trang phục, vật phẩm, hình nền,... Bạn thậm chí có thể làm cho hình ảnh của mình trông giống như bạn bè và thành viên gia đình.</p><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/trannghia/iOS-18-2-duoc-phat-hanh-1.jpg\" alt=\"iOS 18.2 mang đến hàng loạt tính năng mới cho người dùng\" height=\"675\" width=\"1200\">iOS 18.2 mang đến hàng loạt tính năng mới cho người dùng</p><p class=\"ql-align-justify\">Genmoji tương tự như ‌Image Playground‌, nhưng nó dùng để tạo các ký tự biểu tượng cảm xúc tùy chỉnh mà bạn có thể sử dụng trong Message. Tính năng tạo hình ảnh thứ ba là Image Wand, cũng là ‌Image Playground‌ nhưng nằm trong ứng dụng Ghi chú. Bạn có thể phác thảo sơ bộ và sử dụng ‌Apple Intelligence‌ để hoàn thiện hơn. Bản cập nhật bao gồm tích hợp&nbsp;<a href=\"https://cellphones.com.vn/sforum/cach-dung-chat-gpt\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">ChatGPT</a>&nbsp;cho Siri, do đó trợ lý ảo này có thể chuyển các yêu cầu phức tạp cho ChatGPT của OpenAI. Đối với người dùng&nbsp;<a href=\"https://cellphones.com.vn/mobile/apple/iphone-16.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">iPhone 16</a>, bản cập nhật bổ sung Visual Intelligence vào tính năng Camera Control, do đó bạn có thể biết thêm thông tin về các chủ thể và vị trí xung quanh mình.</p><p class=\"ql-align-justify\">Ngoài ra còn có các tính năng mới cho Photos, Safari, Mail và nhiều tính năng khác, với ghi chú phát hành đầy đủ của Apple có sẵn bên dưới.</p><p class=\"ql-align-justify\"><strong>Image Playground</strong></p><ul><li class=\"ql-align-justify\">Một ứng dụng mới cho phép bạn sử dụng các khái niệm, mô tả và con người từ thư viện ảnh của mình để tạo ra những hình ảnh vui nhộn, ngộ nghĩnh theo nhiều phong cách</li><li class=\"ql-align-justify\">Vuốt qua các bản xem trước và chọn khi bạn thêm các khái niệm vào Image Playground của mình</li><li class=\"ql-align-justify\">Chọn từ các kiểu hoạt hình và minh họa khi tạo hình ảnh của bạn</li><li class=\"ql-align-justify\">Tạo hình ảnh trong Tin nhắn và Freeform cũng như các ứng dụng của bên thứ ba</li><li class=\"ql-align-justify\">Hình ảnh được đồng bộ hóa trong thư viện Image Playground trên tất cả các thiết bị của bạn bằng iCloud</li></ul><p class=\"ql-align-justify\"><strong>Genmoji</strong></p><ul><li class=\"ql-align-justify\">Genmoji cho phép bạn tạo biểu tượng cảm xúc tùy chỉnh ngay từ bàn phím</li><li class=\"ql-align-justify\">Genmoji được đồng bộ hóa trong ngăn kéo sticker trên tất cả các thiết bị của bạn bằng iCloud</li></ul><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/trannghia/iOS-18-2-hero-1.jpg\" alt=\"iOS 18.2 mang đến nhiều tính năng mới\" height=\"600\" width=\"1200\">iOS 18.2 mang đến nhiều tính năng mới</p><p class=\"ql-align-justify\"><strong>Hỗ trợ ChatGPT</strong></p><ul><li class=\"ql-align-justify\">Có thể truy cập ChatGPT của OpenAI ngay từ Siri hoặc Writing Tools</li><li class=\"ql-align-justify\">Compose trong Writing Tools cho phép bạn tạo nội dung từ đầu bằng ChatGPT</li><li class=\"ql-align-justify\">Siri có thể sử dụng ChatGPT khi cần thiết để cung cấp cho bạn câu trả lời</li><li class=\"ql-align-justify\">Không yêu cầu tài khoản ChatGPT, các yêu cầu của bạn sẽ được ẩn danh và không được sử dụng để đào tạo các mô hình của OpenAI</li><li class=\"ql-align-justify\">Đăng nhập bằng ChatGPT để truy cập các lợi ích của tài khoản và các yêu cầu sẽ được bảo vệ theo chính sách dữ liệu của OpenAI</li><li class=\"ql-align-justify\">Image Wand biến các bản phác thảo và ghi chú viết tay hoặc đánh máy thành hình ảnh trong Notes</li><li class=\"ql-align-justify\">Mô tả thay đổi trong Writing Tools cho phép bạn đề xuất cách bản thân muốn viết lại một cái gì đó, ví dụ như thành một bài thơ</li></ul><p class=\"ql-align-justify\"><strong>Camera Control (iPhone 16,&nbsp;</strong><a href=\"https://cellphones.com.vn/iphone-16-plus.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\"><strong>iPhone 16 Plus</strong></a><strong>,&nbsp;</strong><a href=\"https://cellphones.com.vn/iphone-16-pro.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\"><strong>iPhone 16 Pro</strong></a><strong>,&nbsp;</strong><a href=\"https://cellphones.com.vn/iphone-16-pro-max.html\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\"><strong>iPhone 16 Pro Max</strong></a><strong>)</strong></p><ul><li class=\"ql-align-justify\">Visual Intelligence với Camera Control giúp bạn tìm hiểu ngay lập tức về các địa điểm hoặc tương tác với thông tin chỉ bằng cách hướng iPhone vào đối tượng, với tùy chọn chạm vào Google Search hoặc ChatGPT</li><li class=\"ql-align-justify\">Màn trập hai giai đoạn của Camera Control cho phép bạn khóa tiêu điểm và phơi sáng trong ứng dụng Camera khi nhấn nhẹ nút này.</li></ul><p class=\"ql-align-justify\"><strong>Mail</strong></p><ul><li class=\"ql-align-justify\">Phân loại mail giúp sắp xếp để bạn biết được các email quan trọng nhất</li><li class=\"ql-align-justify\">Chế độ xem Tóm tắt nhóm tất cả các tin nhắn từ một người gửi thành một nhóm duy nhất để duyệt dễ dàng</li></ul><p class=\"ql-align-center\"><img src=\"https://cdn-media.sforum.vn/storage/app/media/trannghia/iOS-18-2-hero-2.jpg\" alt=\"Phiên bản iOS 18.2 chính thức sẽ được phát hành vào tuần tới\" height=\"675\" width=\"1200\"><a href=\"https://cellphones.com.vn/sforum/cach-cap-nhat-ios-18\" target=\"_blank\" style=\"color: rgb(26, 109, 180);\">Phiên bản iOS 18</a>.2 chính thức sẽ được phát hành vào tuần tới</p><p class=\"ql-align-justify\"><strong>Photo</strong></p><ul><li class=\"ql-align-justify\">Cải thiện chế độ xem video, bao gồm khả năng tua từng khung hình và cài đặt để tắt phát lại video tự động lặp lại</li><li class=\"ql-align-justify\">Cải thiện khi điều hướng chế độ xem Collections, bao gồm khả năng vuốt sang phải để quay lại chế độ xem trước đó</li><li class=\"ql-align-justify\">Có thể xóa lịch sử album Đã xem gần đây và Đã chia sẻ gần đây</li></ul><p class=\"ql-align-justify\"><strong>Safari</strong></p><ul><li class=\"ql-align-justify\">Hình nền mới để tùy chỉnh Trang bắt đầu Safari của bạn</li><li class=\"ql-align-justify\">Import và Export cho phép bạn xuất dữ liệu duyệt web từ Safari và nhập dữ liệu duyệt web từ ứng dụng khác vào Safari</li><li class=\"ql-align-justify\">HTTPS Priority nâng cấp URL lên HTTPS bất cứ khi nào có thể</li><li class=\"ql-align-justify\">Hoạt động tải xuống file trực tiếp hiển thị tiến trình tải xuống tệp trong Dynamic Island và trên màn hình chính của bạn</li></ul><p class=\"ql-align-justify\"><strong>Bản cập nhật này cũng bao gồm các cải tiến và sửa lỗi sau:</strong></p><ul><li class=\"ql-align-justify\">Voice Memos hỗ trợ ghi âm nhiều lớp, cho phép bạn thêm giọng hát vào ý tưởng bài hát hiện có mà không cần tai nghe -- sau đó nhập các dự án hai bản nhạc của bạn trực tiếp vào Logic Pro (chỉ hỗ trợ trên iPhone 16 Pro, iPhone 16 Pro Max)</li><li class=\"ql-align-justify\">Share Item Location trong Find My giúp bạn định vị và tìm các đồ vật bị thất lạc bằng cách chia sẻ vị trí của AirTag hoặc phụ kiện Find My Network với các bên thứ ba đáng tin cậy, chẳng hạn như hãng hàng không</li><li class=\"ql-align-justify\">Tìm kiếm ngôn ngữ tự nhiên trong ứng dụng Apple Music và Apple TV cho phép mô tả những gì bạn đang tìm kiếm bằng thể loại, tâm trạng, diễn viên, thập kỷ,...</li><li class=\"ql-align-justify\">Favorite Categories trong Podcast cho phép bạn chọn danh mục yêu thích của mình và nhận các đề xuất chương trình có liên quan mà bạn có thể dễ dàng truy cập trong Library</li><li class=\"ql-align-justify\">Trang Tìm kiếm được cá nhân hóa trong Podcast làm nổi bật các danh mục có liên quan nhất và các bộ sưu tập được biên tập viên tuyển chọn phù hợp với bạn</li><li class=\"ql-align-justify\">Tựa game Sudoku trong Apple News+ (chỉ dành cho người đăng ký News+)</li><li class=\"ql-align-justify\">Hỗ trợ tính năng Kiểm tra thính lực trên AirPods Pro 2 tại Síp, Séc, Pháp, Ý, Luxembourg, Romania, Tây Ban Nha, Các Tiểu vương quốc Ả Rập Thống nhất và Vương quốc Anh</li><li class=\"ql-align-justify\">Hỗ trợ tính năng Trợ thính trên AirPods Pro 2 tại Các Tiểu vương quốc Ả Rập Thống nhất</li><li class=\"ql-align-justify\">Báo giá trước giờ mở cửa trong Stocks cho phép bạn theo dõi mã chứng khoán NASDAQ và NYSE trước khi thị trường mở cửa</li><li class=\"ql-align-justify\">Khắc phục sự cố khiến ảnh chụp gần đây không xuất hiện ngay trong lưới All Photos</li><li class=\"ql-align-justify\">Khắc phục sự cố khiến ảnh chụp ở chế độ Ban đêm trong Máy ảnh có thể bị giảm chất lượng khi chụp phơi sáng lâu (iPhone 16 Pro, iPhone 16 Pro Max)</li></ul><p class=\"ql-align-justify\">Một số tính năng có thể không khả dụng cho tất cả các khu vực hoặc trên tất cả các thiết bị Apple. Để biết thông tin về nội dung bảo mật của các bản cập nhật phần mềm Apple, vui lòng truy cập trang web này: https://support.apple.com/100100.</p><p class=\"ql-align-justify\">Nguồn: Macrumors</p><p><br></p>', 'blog/hWtQ2RUjZhZt8pELPtu9c4QKduRsJTkJMTfV0ge0.jpg', 1, '2024-12-16 23:03:09', '2024-12-16 23:03:09');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(77, 3, 69, 1, '2024-12-22 01:29:14', '2024-12-22 01:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `parent_id` int DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `parent_id`, `type`, `created_at`, `updated_at`) VALUES
(77, 'Điện thoại', 'dien-thoai', 'category-images/dien-thoai.png', NULL, '', '2024-10-13 20:02:42', '2024-10-25 23:00:25'),
(81, 'Phụ kiện', 'phu-kien', 'category-images/phu-kien.png', NULL, '', '2024-10-13 20:28:04', '2024-10-25 23:00:20'),
(82, 'Laptop', 'laptop', 'category-images/laptop.jpg', NULL, '', '2024-10-13 23:28:39', '2024-10-25 23:38:35'),
(83, 'Đồng hồ thông minh', 'dong-ho-thong-minh', 'category-images/dong-ho-thong-minh.png', NULL, '', '2024-10-25 23:00:45', '2024-10-25 23:00:45'),
(84, 'Tivi', 'tivi', 'category-images/tivi.png', NULL, '', '2024-10-25 23:01:00', '2024-10-25 23:01:00'),
(85, 'Máy tính để bàn', 'may-tinh', 'category-images/may-tinh.png', NULL, '', '2024-10-25 23:57:25', '2024-10-25 23:59:04'),
(88, 'Iphone', 'iphone', 'category-images/iphone.png', 77, 'manufacturer', '2024-10-30 08:12:44', '2024-11-12 20:45:38'),
(89, 'Samsung', 'dien-thoai-samsung', 'category-images/dien-thoai-samsung.png', 77, 'manufacturer', '2024-10-30 09:08:44', '2024-11-12 20:45:33'),
(90, 'Oppo', 'oppo', 'category-images/oppo.png', 77, 'manufacturer', '2024-10-30 09:10:55', '2024-11-12 20:29:56'),
(92, 'Lenovo', 'lenovo', 'category-images/lenovo.jpg', 82, 'manufacturer', '2024-11-13 18:24:02', '2024-11-13 18:24:02'),
(93, 'Acer', 'acer', 'category-images/acer.jpg', 82, 'manufacturer', '2024-11-13 19:25:19', '2024-11-13 19:25:19'),
(94, 'HP', 'hp', 'category-images/hp.png', 82, 'manufacturer', '2024-11-14 00:18:31', '2024-11-14 00:18:31'),
(95, 'Xiaomi', 'xiaomi', 'category-images/xiaomi.png', 77, 'manufacturer', '2024-11-14 00:23:02', '2024-11-14 00:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text,
  `discount_value` decimal(10,2) NOT NULL,
  `min_order_value` decimal(10,0) DEFAULT NULL,
  `usage_limit` int UNSIGNED DEFAULT NULL,
  `used_count` int UNSIGNED DEFAULT '0',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `code`, `description`, `discount_value`, `min_order_value`, `usage_limit`, `used_count`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'LANT@10-20', '', 10.00, 20000000, 4, 2, '2024-12-13 23:47:00', '2024-12-19 14:45:00', 1, '2024-12-16 09:45:51', '2024-12-17 23:41:08'),
(2, 'LTech@30&5', '', 30.00, 5000000, 10, 0, '2024-12-18 13:42:00', '2025-01-19 13:42:00', 1, '2024-12-17 23:42:45', '2024-12-17 23:43:51');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `action` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `created_at`, `updated_at`) VALUES
(3, 2, 'Đã đăng nhập vào hệ thống !', '2024-12-23 20:43:56', '2024-12-23 20:43:56'),
(4, 2, 'Đã đăng nhập vào hệ thống !', '2024-12-26 19:11:17', '2024-12-26 19:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `user_address_id` int DEFAULT NULL,
  `shipping_method_id` int DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total_price` decimal(15,2) DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `discount_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `user_address_id`, `shipping_method_id`, `payment_method`, `total_price`, `status`, `note`, `created_at`, `updated_at`, `discount_id`) VALUES
(16, 2, 3, 2, NULL, 30382400.00, 'shipped', '', '2024-12-15 02:26:02', '2024-12-15 10:19:43', NULL),
(17, 4, 5, 4, NULL, 30764900.00, 'completed', 'gói hàng cẩn thận giúp e', '2024-12-16 08:52:39', '2024-12-16 09:26:12', NULL),
(18, 2, 3, 2, NULL, 37253160.00, 'cancelled', NULL, '2024-12-17 08:38:13', '2024-12-17 09:10:57', 1),
(19, 2, 1, 2, NULL, 25801560.00, 'shipped', NULL, '2024-12-17 08:53:29', '2024-12-17 08:54:27', 1),
(21, 2, 1, 2, NULL, 17879750.00, 'cancelled', NULL, '2024-12-21 22:57:57', '2024-12-21 22:59:00', 2),
(22, 2, 1, 2, NULL, 17879750.00, 'pending', NULL, '2024-12-21 22:59:25', '2024-12-21 22:59:25', 2),
(23, 2, 2, 4, 'thanh-toan-vnpay', 3275900.00, 'pending', NULL, '2024-12-21 23:09:44', '2024-12-21 23:09:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(22, 16, 73, 3, 32970000.00, '2024-12-15 02:26:02', '2024-12-15 02:26:02'),
(23, 17, 70, 1, 20671200.00, '2024-12-16 08:52:39', '2024-12-16 08:52:39'),
(24, 17, 71, 1, 9993700.00, '2024-12-16 08:52:39', '2024-12-16 08:52:39'),
(25, 18, 70, 2, 41342400.00, '2024-12-17 08:38:13', '2024-12-17 08:38:13'),
(26, 19, 68, 1, 3175900.00, '2024-12-17 08:53:29', '2024-12-17 08:53:29'),
(27, 19, 69, 1, 25492500.00, '2024-12-17 08:53:29', '2024-12-17 08:53:29'),
(29, 21, 69, 1, 25492500.00, '2024-12-21 22:57:57', '2024-12-21 22:57:57'),
(30, 22, 69, 1, 25492500.00, '2024-12-21 22:59:25', '2024-12-21 22:59:25'),
(31, 23, 68, 1, 3175900.00, '2024-12-21 23:09:44', '2024-12-21 23:09:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_status_history`
--

CREATE TABLE `order_status_history` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `changed_by` int NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `base_price` decimal(15,2) NOT NULL,
  `sale_price` decimal(15,2) NOT NULL,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `category_id` int NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `additional_images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `quantity` int NOT NULL DEFAULT '0',
  `stored_at` date DEFAULT NULL,
  `reserved_quantity` int NOT NULL DEFAULT '0',
  `sold_quantity` int NOT NULL DEFAULT '0',
  `discount_percentage` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `base_price`, `sale_price`, `short_description`, `description`, `category_id`, `featured_image`, `additional_images`, `quantity`, `stored_at`, `reserved_quantity`, `sold_quantity`, `discount_percentage`, `status`, `created_at`, `updated_at`) VALUES
(60, 'Điện thoại OPPO Reno11 Pro 5G 12GB/512GB', 'oppo-reno11-pro', 16990000.00, 12062900.00, NULL, '<p><br></p>', 90, '/storage/products/67598ad12b374.webp', '[\"\\/storage\\/products\\/67591a2d50710.webp\"]', 5, NULL, 0, 0, 29, 1, '2024-12-10 21:50:53', '2024-12-11 08:26:50'),
(67, 'Điện thoại OPPO Find X8 5G 16GB/512GB Xám', 'oppo-find-x8-xam', 22990000.00, 22990000.00, '<p>Hệ điều hành: Android 15</p>', '<p><img src=\"https://cdnv2.tgdd.vn/mwg-static/dmx/Products/Images/42/322128/Kit/oppo-find-x8-note-638684904716120254.jpg\" alt=\"OPPO Find X8 5G 16GB/512GB\"></p>', 90, '/storage/products/675996a76afa1.webp', '[\"\\/storage\\/products\\/6759968934bc4.webp\",\"\\/storage\\/products\\/6759968934fd7.webp\",\"\\/storage\\/products\\/67599689354a0.webp\"]', 331, NULL, 0, 0, 0, 1, '2024-12-11 06:41:29', '2024-12-11 08:26:29'),
(68, 'Điện thoại Samsung Galaxy A06 4GB 128GB Đen', 'samsung-galaxy-a06-4g-black', 3490000.00, 3175900.00, '<ul><li>Hệ điều hành:</li><li><a href=\"https://www.dienmayxanh.com/kinh-nghiem-hay/android-p-la-gi-co-phai-android-9-hay-khong-co-gi-1126028\" target=\"_blank\" style=\"color: rgb(41, 151, 255);\">Android 9 (Pie)</a></li><li>Chip xử lý (CPU):</li><li><a href=\"https://www.dienmayxanh.com/kinh-nghiem-hay/tong-hop-cac-dong-chip-exynos-pho-bien-nhat-cua-sa-1113549#exynos-7904\" target=\"_blank\" style=\"color: rgb(41, 151, 255);\">Exynos 7904</a></li><li><a href=\"https://www.dienmayxanh.com/kinh-nghiem-hay/toc-do-cpu-la-gi-1299740\" target=\"_blank\" style=\"color: rgb(41, 151, 255);\">Tốc độ CPU:</a></li><li>1.8 GHz</li><li>Chip đồ họa (GPU):</li><li><a href=\"https://www.dienmayxanh.com/kinh-nghiem-hay/tim-hieu-chip-xu-li-do-hoa-tren-smartphone-gpu-1113786#mali-g71\" target=\"_blank\" style=\"color: rgb(41, 151, 255);\">Mali-G71</a></li><li><a href=\"https://www.dienmayxanh.com/kinh-nghiem-hay/ram-la-gi-co-y-nghia-gi-trong-cac-thiet-bi-dien-tu-596492\" target=\"_blank\" style=\"color: rgb(41, 151, 255);\">RAM:</a></li><li>4 GB</li><li>Dung lượng lưu trữ:</li><li>64 GB</li><li>Dung lượng còn lại (khả dụng) khoảng:</li><li>Khoảng 49 GB</li><li>Thẻ nhớ:</li><li><a href=\"https://www.dienmayxanh.com/the-nho-dien-thoai\" target=\"_blank\" style=\"color: rgb(41, 151, 255);\">MicroSD, hỗ trợ tối đa 512 GB</a></li><li>Danh bạ:</li><li>Không giới hạn</li></ul><p><br></p>', '<p><br></p>', 89, '/storage/products/675997a7286b5.webp', '[\"\\/storage\\/products\\/675997a728cd4.webp\",\"\\/storage\\/products\\/675997a729066.webp\",\"\\/storage\\/products\\/675997a7296ec.webp\"]', 10, NULL, 1, 1, 9, 1, '2024-12-11 06:46:15', '2024-12-21 23:09:44'),
(69, 'Điện thoại Samsung Galaxy S24 Ultra 5G 12GB/256GB Xám', 'samsung-galaxy-s24-ultra-5g-grey', 33990000.00, 25492500.00, '<ul><li><a href=\"https://www.thegioididong.com/hoi-dap/he-dieu-hanh-la-gi-804907#hmenuid1\" target=\"_blank\" style=\"color: rgb(41, 151, 255);\">Hệ điều hành:</a></li><li>Android 14</li><li>Chip xử lý (CPU):</li><li>Snapdragon 8 Gen 3 for Galaxy</li></ul><p><br></p>', '<p><img src=\"https://cdn.tgdd.vn/Products/Images/42/307174/Kit/samsung-galaxy-s24-ultra-note.jpg\" alt=\"Samsung Galaxy S24 Ultra 5G 12GB/256GB\"></p>', 89, '/storage/products/6759a8e91a105.webp', '[\"\\/storage\\/products\\/6759a8e91a6b1.webp\",\"\\/storage\\/products\\/6759a8e91ac76.webp\",\"\\/storage\\/products\\/6759a8e91b038.webp\",\"\\/storage\\/products\\/6759a8e91b404.webp\"]', 421, NULL, 1, 1, 25, 1, '2024-12-11 07:59:53', '2024-12-23 07:06:44'),
(70, 'Laptop Lenovo Gaming LOQ 15IAX9 i5 12450HX/24GB/512GB/4GB RTX2050/144Hz/Win11 (83GS00DBVN)', 'lenovo-loq-15iax9-i5-83gs00dbvn', 23490000.00, 20671200.00, '<ul><li>Công nghệ CPU:</li><li><a href=\"https://www.thegioididong.com/hoi-dap/intel-the-he-12-alder-lake-tren-laptop-cau-hinh-va-thoi-1396454\" target=\"_blank\" style=\"color: rgb(41, 151, 255);\">Intel Core i5 Alder Lake</a>&nbsp;- 12450HX</li><li>Số nhân:</li><li>8</li><li>Số luồng:</li><li>12</li><li>Tốc độ CPU:</li><li>Hãng không công bố</li></ul>', '<p><img src=\"https://cdn.tgdd.vn/Products/Images/44/328483/Kit/lenovo-loq-15iax9-i5-83gs00dbvn-note.jpg\" alt=\"Lenovo Gaming LOQ 15IAX9 i5 12450HX/24GB/512GB/4GB RTX2050/144Hz/Win11 (83GS00DBVN)\"></p>', 92, '/storage/products/6759b2195c490.webp', '[\"\\/storage\\/products\\/6759b1efcdaed.webp\",\"\\/storage\\/products\\/6759b1efce1e9.webp\",\"\\/storage\\/products\\/6759b1efce5f9.webp\",\"\\/storage\\/products\\/6759b1efce9f7.webp\"]', 199, NULL, 0, 1, 12, 1, '2024-12-11 08:38:23', '2024-12-17 09:10:57'),
(71, 'Laptop HP 15s fq5229TU i3 1215U/8GB/512GB/Win11 (8U237PA)', 'hp-15s-fq5229tu-i3-8u237', 13690000.00, 9993700.00, '<ul><li>Công nghệ CPU:</li><li><a href=\"https://www.thegioididong.com/tin-tuc/chip-intel-the-he-12-la-gi-1400953\" target=\"_blank\" style=\"color: rgb(41, 151, 255);\">Intel Core i3 Alder Lake</a>&nbsp;-&nbsp;<a href=\"https://www.thegioididong.com/hoi-dap/tim-hieu-chip-intel-core-i3-1215u-chi-tiet-ve-1473649\" target=\"_blank\" style=\"color: rgb(41, 151, 255);\">1215U</a></li><li>Số nhân:</li><li>6</li><li>Số luồng:</li><li>8</li><li>Tốc độ CPU:</li><li>1.2GHz</li></ul><p><br></p>', '<p><img src=\"https://cdn.tgdd.vn/Products/Images/44/313084/Kit/hp-15s-fq5229tu-i3-8u237pa-glr-note-2.jpg\" alt=\"HP 15s fq5229TU i3 1215U/8GB/512GB/Win11 (8U237PA)\"></p>', 94, '/storage/products/6759b2f033314.webp', '[\"\\/storage\\/products\\/6759b2f0338a7.webp\",\"\\/storage\\/products\\/6759b2f033e29.webp\",\"\\/storage\\/products\\/6759b2f0342db.webp\"]', 30, NULL, 0, 2, 27, 1, '2024-12-11 08:42:40', '2024-12-23 07:08:23'),
(72, 'Laptop Dell Inspiron 15 3530 i7 1355U/16GB/1TB/120Hz/OfficeHS/Win11 (P16WD)', 'dell-inspiron-15-3530-i7-p16wd', 23490000.00, 23490000.00, '', '<ul><li>Công nghệ CPU:</li><li>Intel Core i7 Raptor Lake - 1355U</li><li>Số nhân:</li><li>10</li><li>Số luồng:</li><li>12</li><li>Tốc độ CPU:</li><li>Hãng không công bố</li></ul><p><br></p>', 82, '/storage/products/6759b39fc4605.webp', '[\"\\/storage\\/products\\/6759b39fc4b7e.webp\",\"\\/storage\\/products\\/6759b39fc4ede.webp\",\"\\/storage\\/products\\/6759b39fc5571.webp\",\"\\/storage\\/products\\/6759b39fc59e9.webp\"]', 35, NULL, 0, 0, 0, 1, '2024-12-11 08:45:35', '2024-12-11 08:45:35'),
(73, 'Điện thoại Samsung Galaxy A55 5G 8GB/256GB', 'samsung-galaxy-a55-5g-8-256-black', 10990000.00, 10110800.00, '<ul><li><a href=\"https://www.thegioididong.com/hoi-dap/he-dieu-hanh-la-gi-804907#hmenuid1\" target=\"_blank\" style=\"color: rgb(41, 151, 255);\">Hệ điều hành:</a></li><li>Android 14</li><li>Chip xử lý (CPU):</li><li>Exynos 1480 8 nhân</li><li><a href=\"https://www.thegioididong.com/hoi-dap/toc-do-cpu-la-gi-co-y-nghia-gi-trong-cac-thiet-bi-dien-tu-1299483\" target=\"_blank\" style=\"color: rgb(41, 151, 255);\">Tốc độ CPU:</a></li><li>4 nhân 2.7 GHz &amp; 4 nhân 2 GHz</li><li>Chip đồ họa (GPU):</li><li>AMD Titan 1WGP</li><li><a href=\"https://www.thegioididong.com/hoi-dap/ram-la-gi-co-y-nghia-gi-trong-cac-thiet-bi-dien-t-1216259\" target=\"_blank\" style=\"color: rgb(41, 151, 255);\">RAM:</a></li><li>8 GB</li><li>Dung lượng lưu trữ:</li><li>256 GB</li><li>Dung lượng còn lại (khả dụng) khoảng:</li><li>235.5 GB</li></ul><p><br></p>', '<p> </p>', 89, '/storage/products/675ea080333ac.webp', '[\"\\/storage\\/products\\/675ea080371c0.webp\",\"\\/storage\\/products\\/675ea08037618.webp\",\"\\/storage\\/products\\/675ea080379db.webp\"]', 10, NULL, 0, 3, 8, 1, '2024-12-15 02:25:20', '2024-12-17 06:21:59');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `user_id`, `product_id`, `parent_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(22, 2, 69, NULL, 3, 'haha', '2024-12-15 09:41:56', '2024-12-15 09:41:56');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `name`, `created_at`, `updated_at`) VALUES
(1, 'chatbot_name', 'Lân Tech AI', '', NULL, NULL),
(2, 'chatbot_color', '#1f3bb3', '', NULL, NULL),
(3, 'chatbot_logo', NULL, '', NULL, NULL),
(4, 'chatbot_icon', NULL, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `shipping_methods`
--

INSERT INTO `shipping_methods` (`id`, `name`, `description`, `price`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Nhanh', 'test\n', 50000.00, 1, '2024-11-28 22:06:20', '2024-11-28 22:22:36'),
(4, 'Hỏa tốc', '', 100000.00, 1, '2024-11-28 22:13:21', '2024-11-28 22:18:59'),
(8, 'Tiết kiệm', '', 10000.00, 1, '2024-11-28 22:22:12', '2024-11-28 22:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `description`, `image`, `link_url`, `status`, `created_at`, `updated_at`) VALUES
(1, '321', '', '/storage/sliders/675cf18bbc7b0.webp', 'http://graduation-project.test/', 1, '2024-12-13 09:15:08', '2024-12-13 19:46:35'),
(2, 'samsung galaxy s24', '', '/storage/sliders/675ce4dfa9595.webp', 'http://graduation-project.test/san-pham/samsung-galaxy-s24-ultra-5g-grey', 1, '2024-12-13 09:57:34', '2024-12-13 18:52:31'),
(3, 'oppo find x8 mo ban home', '', '/storage/sliders/67655f05da6c9.webp', 'http://graduation-project.test/san-pham/oppo-find-x8-xam', 1, '2024-12-20 05:11:49', '2024-12-20 05:11:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `phone`, `address`, `role`, `created_at`, `updated_at`) VALUES
(2, 'lan2k2', 'lan2k2@gmail.com', '$2y$12$lTfl25VcXTzBHm6hPhPZQOfaKujNoIPE6TureYW8LtfXfgF9PfUtm', 'mhkV76oQDbscswnctwSfd4QjcPaUpnUXpsT4h8NjipSOcjQPbwFcm6ZyTeR3', NULL, NULL, 'admin', '2024-10-01 06:11:45', '2024-12-24 03:43:50'),
(3, 'minhvku', 'minhvku@gmail.com', '$2y$12$j5hcYIx/onhXSioeQL0QJ.d3FtsMELezWDEoXMn6.4pD5LRdXEl0C', NULL, NULL, NULL, 'user', '2024-12-09 08:52:55', '2024-12-09 08:52:55'),
(4, 'hiếu thứ 2', 'hieudinh@gmail.com', '$2y$12$Z/8o61w/4s3VJdx5asms5.xRClm8RJN01XFaJPm00ZvZj6BKVFlku', NULL, NULL, NULL, 'employee', '2024-12-15 07:35:39', '2024-12-23 02:57:44');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ward` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `name`, `phone`, `city`, `district`, `ward`, `address`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 2, 'Nguyễn Văn Lân', '0905914203', '89', '892', '30607', 'thôn Phú Hòa 2', 1, '2024-11-28 05:03:17', '2024-12-22 00:25:31'),
(2, 2, 'Nguyễn Thị Kim Quyền', '09051124151', '24', '223', '07840', 'thôn Phú Hòa 1', 0, '2024-11-28 05:40:51', '2024-12-22 00:25:51'),
(3, 2, 'Minh ', '0905010101', '49', '511', '20728', '32 Lê Lợi', 0, '2024-12-14 23:42:09', '2024-12-22 00:26:31'),
(5, 4, 'trần đình hiếu', '0905914203', NULL, NULL, NULL, '43 le dinh ly', 1, '2024-12-16 08:34:03', '2024-12-16 08:39:31'),
(7, 3, 'Lưu Quang Minh', '0905114552', '49', '503', '20425', '12 Lạc Long Quân', 1, '2024-12-23 04:21:03', '2024-12-23 07:05:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_discount_id` (`discount_id`),
  ADD KEY `fk_shipping_method` (`shipping_method_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_ibfk_1` (`order_id`),
  ADD KEY `order_items_ibfk_2` (`product_id`);

--
-- Indexes for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `changed_by` (`changed_by`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_discount_id` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_shipping_method` FOREIGN KEY (`shipping_method_id`) REFERENCES `shipping_methods` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD CONSTRAINT `order_status_history_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_status_history_ibfk_2` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `category_id ` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `product_reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
