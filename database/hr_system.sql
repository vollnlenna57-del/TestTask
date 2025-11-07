-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 07 2025 г., 12:48
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `hr_system`
--

-- --------------------------------------------------------

--
-- Структура таблицы `departments`
--

CREATE TABLE `departments` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'IT отдел'),
(2, 'Отдел продаж'),
(3, 'Бухгалтерия'),
(4, 'Отдел кадров'),
(5, 'Маркетинг');

-- --------------------------------------------------------

--
-- Структура таблицы `employees`
--

CREATE TABLE `employees` (
  `id` int NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `passport` varchar(10) NOT NULL,
  `phone` varchar(18) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `department_id` int NOT NULL,
  `position_id` int NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `hire_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `employees`
--

INSERT INTO `employees` (`id`, `last_name`, `first_name`, `middle_name`, `birth_date`, `passport`, `phone`, `email`, `address`, `department_id`, `position_id`, `salary`, `hire_date`) VALUES
(1, 'Иванов', 'Иван', 'Иванович', '1985-03-15', '4510123456', '+7 (999) 123-45-67', 'ivanov@company.ru', 'г. Москва, ул. Ленина, д. 10, кв. 25', 1, 1, '180000.00', '2020-01-15'),
(2, 'Петрова', 'Мария', 'Сергеевна', '1990-07-22', '4511654321', '+7 (999) 234-56-78', 'petrova@company.ru', 'г. Москва, ул. Пушкина, д. 5, кв. 12', 1, 2, '120000.00', '2021-03-10'),
(3, 'Сидоров', 'Алексей', 'Петрович', '1988-11-30', '4512789012', '+7 (999) 345-67-89', 'sidorov@company.ru', 'г. Москва, пр. Мира, д. 15, кв. 8', 2, 1, '150000.00', '2025-11-05'),
(4, 'Козлова', 'Елена', 'Владимировна', '1992-05-18', '4513345678', '+7 (999) 456-78-90', 'kozlova@company.ru', 'г. Москва, ул. Гагарина, д. 20, кв. 30', 3, 2, '95000.00', '2022-02-20'),
(5, 'Васильев', 'Дмитрий', 'Олегович', '1983-12-10', '4514901234', '+7 (999) 567-89-01', 'vasilev@company.ru', 'г. Москва, ул. Садовая, д. 3, кв. 15', 4, 1, '110000.00', '2018-06-15'),
(6, 'Смирнова', 'Ольга', 'Александровна', '1991-08-14', '4515567890', '+7 (999) 678-90-12', 'smirnova@company.ru', 'г. Москва, ул. Цветочная, д. 8, кв. 42', 5, 2, '88000.00', '2025-01-10'),
(7, 'Николаев', 'Сергей', 'Викторович', '1995-02-25', '4516112233', '+7 (999) 789-01-23', 'nikolaev@company.ru', 'г. Москва, ул. Лесная, д. 12, кв. 18', 2, 3, '65000.00', '2025-05-20');

-- --------------------------------------------------------

--
-- Структура таблицы `positions`
--

CREATE TABLE `positions` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `positions`
--

INSERT INTO `positions` (`id`, `title`) VALUES
(1, 'Руководитель'),
(2, 'Специалист'),
(3, 'Помощник');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `position_id` (`position_id`);

--
-- Индексы таблицы `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
