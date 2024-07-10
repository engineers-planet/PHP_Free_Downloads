CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `price` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP

) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `product` (`id`, `name`, `description`, `price`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Frog Toy', '<ul style="margin:0px;padding:15px;">\r\n					<li>Built-in voice box </li>\r\n					<li>soft and great for cuddling</li>\r\n				<li>Special Design</li>\r\n			</ul>	', 12, 'frog.png', '2019-01-19 14:13:04', '2019-01-19 14:13:04'),
(2, 'Chicken Toy', '<ul style="margin:0px;padding:15px;">\r\n				<li>Built-in voice box </li>\r\n					<li>soft and great for cuddling</li>\r\n				<li>Special Design</li>\r\n			</ul>	', 21, 'chicken.png', '2019-01-19 14:13:04', '2019-01-19 14:13:04');
