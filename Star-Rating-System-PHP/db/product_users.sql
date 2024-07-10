--
-- Table structure for table `product_users`
--

CREATE TABLE `product_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_users`
--

INSERT INTO `product_users` (`id`, `username`, `password`, `avatar`) VALUES
(1, 'joseph', '123', 'user1.jpg'),
(2, 'mary', '123', 'user2.jpg'),
(3, 'lisa', '123', 'user6.jpg');
