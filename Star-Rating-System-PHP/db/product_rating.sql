--
-- Table structure for table `product_rating`
--



CREATE TABLE `product_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating_score` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `reviewer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Block, 0 = Unblock',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Dumping data for table `product_rating`
--

INSERT INTO `product_rating` (`id`, `product_id`, `user_id`, `rating_score`, `title`, `comment`, `reviewer`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, 'its awesome', 'It''s awesome!!!','Joseph', 'joseph123@gmail.com',1, '2018-08-19 09:13:01', '2018-08-19 09:13:01'),
(2, 2, 2, 5, 'Nice product', 'Really quality product!','Mary', 'mary123@gmail.com',1,  '2018-08-19 09:13:37', '2018-08-19 09:13:37'),
(3, 1, 3, 3, 'I like it', 'its''s best but item.', 'John', 'john123@gmail.com', 1,'2018-08-19 09:14:19', '2018-08-19 09:14:19'),
(4, 1, 4, 3, 'super awesome ', 'i think its supper products','lisa', 'lisa123@gmail.com', 1, '2018-08-19 09:18:00', '2018-08-19 09:18:00'),
(5, 2, 5, 1, 'Good idea', 'Nice', 'Daniel', 'Daniel123@gmail.com',1, '2019-01-20 17:00:58',  '2019-01-20 17:00:58'),
(6, 2, 5, 5, 'Nice product', 'this is nice!', 'Lee', 'Lee23@gmail.com',1, '2019-01-20 17:01:37', '2019-01-20 17:01:37'),
(7, 1, 3, 4, 'really nice', 'Good!', 'Michael', 'Michael23@gmail.com', 1,'2019-01-20 21:06:48', '2019-01-20 21:06:48');






ALTER TABLE `product_rating` CHANGE `user_id` `user_id` INT(11) NULL DEFAULT NULL;
