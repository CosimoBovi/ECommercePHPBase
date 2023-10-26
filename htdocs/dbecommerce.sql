-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Ott 26, 2023 alle 10:04
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbecommerce`
--

DELIMITER $$
--
-- Procedure
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindPasswordByUsername` (IN `username` VARCHAR(255))  BEGIN
    DECLARE user_password VARCHAR(255);

    SELECT Password
    FROM Users
    WHERE Username = username;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllUserTypes` ()  BEGIN
    SELECT * FROM UserTypes;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetImageURLByID` (IN `image_id` INT)  BEGIN
    SELECT Image_URL
    FROM product_images
    WHERE ImageID = image_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetImageURLsByProductID` (IN `product_id` INT)  BEGIN
    SELECT Image_URL
    FROM product_images
    WHERE ProductID = product_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertCart` (IN `user_id` INT)  BEGIN
    INSERT INTO Cart (User_ID) VALUES (user_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertCategory` (IN `name` VARCHAR(255), IN `description` TEXT, IN `parent_id` INT)  BEGIN
    INSERT INTO Categories (Name, Description, Parent_ID) VALUES (name, description, parent_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertCategoryProduct` (IN `product_id` INT, IN `category_id` INT)  BEGIN
    INSERT INTO CategoriesProducts (Product_ID, Category_ID) VALUES (product_id, category_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertOrder` (IN `customer_id` INT, IN `order_date` DATE)  BEGIN
    INSERT INTO Orders (Customer_ID, OrderDate) VALUES (customer_id, order_date);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertProduct` (IN `name` VARCHAR(255), IN `description` TEXT, IN `unit_price` DECIMAL(10,2), IN `user_seller_id` INT)  BEGIN
    INSERT INTO Products (Name, Description, UnitPrice, UserSeller_ID) VALUES (name, description, unit_price, user_seller_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertProductImage` (IN `product_id` INT, IN `image_url` VARCHAR(255))  BEGIN
    INSERT INTO product_images (ProductID, Image_URL)
    VALUES (product_id, image_url);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertProductOrder` (IN `order_id` INT, IN `product_id` INT, IN `quantity` INT)  BEGIN
    INSERT INTO ProductsOrders (Order_ID, Product_ID, Quantity) VALUES (order_id, product_id, quantity);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertUser` (IN `username` VARCHAR(255), IN `password` VARCHAR(255), IN `usertype_id` INT)  BEGIN
    INSERT INTO Users (Username, Password, UserType_ID) VALUES (username, password, usertype_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertUserType` (IN `type` VARCHAR(255), IN `description` TEXT)  BEGIN
    INSERT INTO UserTypes (Type, Description) VALUES (type, description);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `cart`
--

CREATE TABLE `cart` (
  `Cart_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `categories`
--

CREATE TABLE `categories` (
  `Category_ID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Parent_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `categoriesproducts`
--

CREATE TABLE `categoriesproducts` (
  `CategoryProduct_ID` int(11) NOT NULL,
  `Product_ID` int(11) DEFAULT NULL,
  `Category_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `orders`
--

CREATE TABLE `orders` (
  `Order_ID` int(11) NOT NULL,
  `Customer_ID` int(11) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `products`
--

CREATE TABLE `products` (
  `Product_ID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `UserSeller_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `productsorders`
--

CREATE TABLE `productsorders` (
  `ProductOrder_ID` int(11) NOT NULL,
  `Order_ID` int(11) DEFAULT NULL,
  `Product_ID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `Username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `UserType_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`User_ID`, `Username`, `Password`, `UserType_ID`) VALUES
(4, 'test', '$2y$10$jdSBtgiNeGkTCuv/D9BS7.ALGhBIvIoGLSoO5AkWKvjVGO/YfC7te', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `usertypes`
--

CREATE TABLE `usertypes` (
  `UserType_ID` int(11) NOT NULL,
  `Type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `usertypes`
--

INSERT INTO `usertypes` (`UserType_ID`, `Type`, `Description`) VALUES
(1, 'Buyer', 'Represents a user who makes purchases.'),
(2, 'Seller', 'Represents a user who sells products.');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`Cart_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indici per le tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Category_ID`),
  ADD KEY `Parent_ID` (`Parent_ID`);

--
-- Indici per le tabelle `categoriesproducts`
--
ALTER TABLE `categoriesproducts`
  ADD PRIMARY KEY (`CategoryProduct_ID`),
  ADD KEY `Product_ID` (`Product_ID`),
  ADD KEY `Category_ID` (`Category_ID`);

--
-- Indici per le tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`);

--
-- Indici per le tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `UserSeller_ID` (`UserSeller_ID`);

--
-- Indici per le tabelle `productsorders`
--
ALTER TABLE `productsorders`
  ADD PRIMARY KEY (`ProductOrder_ID`),
  ADD KEY `Order_ID` (`Order_ID`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indici per le tabelle `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `UC_Username` (`Username`),
  ADD KEY `UserType_ID` (`UserType_ID`);

--
-- Indici per le tabelle `usertypes`
--
ALTER TABLE `usertypes`
  ADD PRIMARY KEY (`UserType_ID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `cart`
--
ALTER TABLE `cart`
  MODIFY `Cart_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `categories`
--
ALTER TABLE `categories`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `categoriesproducts`
--
ALTER TABLE `categoriesproducts`
  MODIFY `CategoryProduct_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `products`
--
ALTER TABLE `products`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `productsorders`
--
ALTER TABLE `productsorders`
  MODIFY `ProductOrder_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `usertypes`
--
ALTER TABLE `usertypes`
  MODIFY `UserType_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);

--
-- Limiti per la tabella `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`Parent_ID`) REFERENCES `categories` (`Category_ID`);

--
-- Limiti per la tabella `categoriesproducts`
--
ALTER TABLE `categoriesproducts`
  ADD CONSTRAINT `categoriesproducts_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `products` (`Product_ID`),
  ADD CONSTRAINT `categoriesproducts_ibfk_2` FOREIGN KEY (`Category_ID`) REFERENCES `categories` (`Category_ID`);

--
-- Limiti per la tabella `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `users` (`User_ID`);

--
-- Limiti per la tabella `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`UserSeller_ID`) REFERENCES `users` (`User_ID`);

--
-- Limiti per la tabella `productsorders`
--
ALTER TABLE `productsorders`
  ADD CONSTRAINT `productsorders_ibfk_1` FOREIGN KEY (`Order_ID`) REFERENCES `orders` (`Order_ID`),
  ADD CONSTRAINT `productsorders_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `products` (`Product_ID`);

--
-- Limiti per la tabella `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`Product_ID`);

--
-- Limiti per la tabella `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`UserType_ID`) REFERENCES `usertypes` (`UserType_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
