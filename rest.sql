-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: sql307.byetcluster.com
-- Время создания: Апр 04 2024 г., 21:01
-- Версия сервера: 10.4.17-MariaDB
-- Версия PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `if0_36150696_rest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(37, 'Тимур', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(38, 'Богдан', '939c51fd9f00d8d3a6b2cb817c90a360d7a0a973'),
(39, 'sosihui', '7f5c919fdb9204e9850d40c4290f0e0dd157ba73');

-- --------------------------------------------------------

--
-- Структура таблицы `dishes`
--

CREATE TABLE `dishes` (
  `dish_id` int(11) NOT NULL,
  `dish_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cost` float NOT NULL,
  `image` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `dishes`
--

INSERT INTO `dishes` (`dish_id`, `dish_name`, `cost`, `image`) VALUES
(17, 'Чикенбургер', 280, 'burger-2.png'),
(18, 'Клубничный коктейль', 180, 'dessert-1.png'),
(16, 'Гамбургер', 300, 'burger-1.png'),
(22, 'Шоколадный торт', 350, 'dessert-2.png'),
(21, 'Карамельный коктейль', 180, 'dessert-3.png'),
(23, 'Шоколадный кекс', 180, 'dessert-4.png'),
(24, 'Клубничное мороженое', 180, 'dessert-5.png'),
(25, 'Чизкейк с клубникой', 150, 'dessert-6.png'),
(26, 'Лапша по-китайски', 200, 'dish-1.png'),
(27, 'Лапша с креветками', 250, 'dish-2.png'),
(28, 'Паста фетучини', 250, 'dish-3.png'),
(29, 'Стейк из говядины с гарниром', 300, 'dish-4.png'),
(30, 'Апельсиновый сок', 80, 'drink-1.png'),
(31, 'Кофе с молоком', 100, 'drink-2.png'),
(32, 'Мохито', 80, 'drink-3.png'),
(33, 'Пицца Пепперони', 400, 'pizza-3.png'),
(34, 'Пицца Ветчина с грибами', 400, 'pizza-5.png');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `date_created`) VALUES
(1, '2024-04-04 20:49:59');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `dish_id`) VALUES
(1, 1, 18),
(2, 1, 32);

-- --------------------------------------------------------

--
-- Структура таблицы `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `arrival_time` datetime NOT NULL,
  `departure_time` datetime DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `table_id`, `arrival_time`, `departure_time`, `customer_name`, `contact_number`) VALUES
(25, 3, '2024-03-15 13:45:00', '2024-03-15 23:59:00', 'Anton', '121212'),
(35, 6, '2024-03-19 17:00:00', '2024-03-19 23:59:00', 'Anton', '121212'),
(36, 4, '2024-03-20 12:16:00', '2024-03-20 13:00:00', 'Тимур', '+796011111111'),
(39, 5, '2024-06-11 09:42:00', '2024-06-11 23:59:00', 'Богдан', '+793021032012'),
(38, 4, '2024-03-29 08:44:00', '2024-03-29 23:59:00', 'Юля', '+712342341'),
(40, 4, '2024-04-05 00:30:00', '2024-04-05 23:59:00', 'Paul', '2141143'),
(41, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `tables`
--

CREATE TABLE `tables` (
  `table_id` int(11) NOT NULL,
  `table_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL,
  `status` enum('available','occupied') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'available'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tables`
--

INSERT INTO `tables` (`table_id`, `table_name`, `capacity`, `status`) VALUES
(3, '1', 6, 'available'),
(4, '2', 4, 'occupied'),
(5, '3', 4, 'available'),
(6, '4', 6, 'available'),
(7, '5', 3, 'available'),
(8, '6', 12, 'available'),
(9, '9', 3, 'available');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`dish_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `dish_id` (`dish_id`);

--
-- Индексы таблицы `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Индексы таблицы `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`table_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `dishes`
--
ALTER TABLE `dishes`
  MODIFY `dish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT для таблицы `tables`
--
ALTER TABLE `tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
