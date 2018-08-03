-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 31, 2018 at 10:53 PM
-- Server version: 5.7.23-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lcg`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstname`, `lastname`, `email`, `password`) VALUES
(11111, 'Steven', 'Hunt', 'sthunt@csumb.edu', '3858f62230ac3c915f300c664312c63f'),
(22222, 'Norma', 'Sanchez', 'nosanchez@csumb.edu', '3858f62230ac3c915f300c664312c63f'),
(33333, 'Lupe', 'Alejo', 'galejo@csumb.edu', '3858f62230ac3c915f300c664312c63f'),
(44444, 'Sea', 'Otter', 'test@csumb.edu', '3858f62230ac3c915f300c664312c63f');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Lunch'),
(2, 'Happy Hour'),
(3, 'Dinner'),
(4, 'Cocktails');

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `pquantity` varchar(255) NOT NULL,
  `orderid` int(11) NOT NULL,
  `productprice` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `pid`, `pquantity`, `orderid`, `productprice`) VALUES
(25, 6, '1', 23, '7.99'),
(26, 17, '1', 23, '12.95'),
(27, 13, '1', 23, '10.95');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `totalprice` varchar(255) NOT NULL,
  `orderstatus` varchar(255) NOT NULL,
  `paymentmode` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `uid`, `totalprice`, `orderstatus`, `paymentmode`, `timestamp`) VALUES
(23, 20, '31.89', 'Order Placed', 'VISA', '2018-07-31 22:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `ordertracking`
--

CREATE TABLE `ordertracking` (
  `id` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `catid` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `catid`, `price`, `thumb`, `description`) VALUES
(3, 'Bobotie Cakes', 3, '16.95', 'uploads/bobotie.jpg', 'a well-known South African dish consisting of spiced minced meat baked with an egg-based topping.'),
(4, 'Bacon and Blue Burger', 1, '10.99', 'uploads/burger.jpg', 'combined the cream cheese, blue cheese and bacon bits.'),
(5, 'Butternut Squash Soup', 1, '8.99', 'uploads/butternut.jpeg', 'Roasted squash and tart apples are blended with a touch of cream for a smooth and elegant fall soup.'),
(6, 'Cheese Plate', 2, '7.99', 'uploads/cheese.jpg', 'NY Cowâ€™s Milk Cheese, Dry Italian Sausage, Fig Chutney'),
(7, 'Heirloom Flatbread', 2, '9.95', 'uploads/flatbread.jpg', 'Garden picked heirlooms and homemade mozzarella on our famous flatbread. '),
(8, 'Smoked Halibut', 3, '18.95', 'uploads/halibut.jpg', 'Alder smoked halibut and seasonal veggies. '),
(9, 'Braised Lamp Pops', 3, '16.95', 'uploads/lamb.jpg', 'Slow braised bone-in lamb, coated in housemade pesto. '),
(10, 'Mojito', 4, '7.95', 'uploads/mojito.jpg', 'Our twist on the traditional Cuban highball. '),
(11, 'Mezcal Mule', 4, '8.95', 'uploads/mule.jpg', 'Spicy housemade ginger beer with infused Sombra.  '),
(12, 'Italian Negroni', 4, '7.95', 'uploads/negroni.jpg', '3 simple ingredients: one part gin, one part vermouth rosso, and one part Campari.'),
(13, 'Rosemary Citrus Old Fashioned', 4, '10.95', 'uploads/old.jpg', 'The orange wakes you up with a bit of zing and the rosemary gives it a warm herbal, earthy taste to help round out the deep undertones from the whiskey. '),
(14, 'Garden Picked Pasta', 3, '13.95', 'uploads/pasta.jpg', 'Fresh cherry tomatoes, homemade mozzarella, a dash of olive oil, and garnished with fresh bazil. '),
(15, 'Wood Fired Pizza', 3, '15.95', 'uploads/pizza.jpg', 'Thin homemade crust, fresh picked seasonal veggies, and a thinly sliced spicy pepperoni. '),
(16, 'Poke Bowl', 1, '11.95', 'uploads/poke.jpg', 'Fresh caught Pacific tuna, mangos, avocado, over mixed greens. '),
(17, 'Cowbow Slider and chips', 2, '12.95', 'uploads/PP_Burger.jpg', 'Slow roasted brisket, Muenster cheese, and a housemade onion ring. '),
(18, 'Roast Beef Sandwich', 1, '9.95', 'uploads/roastbeef.jpg', 'Slow roasted over 48 hours on fresh sourdough. '),
(19, 'Seafood Bites', 2, '16.95', 'uploads/seafood.jpg', 'Fresh octopus, shrimp, clams, and scallops over a bed of seasonal greens. '),
(20, 'Pickled Plate', 2, '11.95', 'uploads/sides.jpg', 'Housemade pickled seasonal veggies with an assorted of crackers and dips. '),
(21, 'Lamb Sliders', 2, '14.95', 'uploads/sliders.jpg', 'Grilled lamb slider with a roasted tomato spread and garlic aioli. '),
(22, 'Whiskey Smash', 4, '9.95', 'uploads/smash.jpg', 'Whiskey forward with a hint of sweetness and mint on the back end. '),
(23, 'Kobe Fliet', 3, '45.95', 'uploads/steak.jpg', 'A taste of a rare delicacy stateside. '),
(24, 'Al Pastor Street Tacos', 2, '14.95', 'uploads/tacos.jpg', 'Spicy marinated pork tacos in a fresh, homemade, wheat tortilla. '),
(25, 'Thai Salad', 2, '8.95', 'uploads/thai_salad.jpg', 'Sweet Thai salad mixed with seasonal Thai veggies and drizzled with a chili oil reduction. '),
(26, 'Cold Heirloom Bisque', 1, '7.95', 'uploads/tomato_soup.jpg', 'Slow roasted, garden picked, heirlooms creates this smooth and creamy \'cold\' bisque. '),
(27, 'Turkey Brie Sandwhich', 1, '10.95', 'uploads/turky.jpg', 'This strange combination makes for a beautifully unique sandwich. ');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `review` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `timestamp`) VALUES
(20, 'test@csumb.edu', '$2y$10$GXcMOxyevFeww2gP2RLQ2erpx.X9LC05As7NSO67jIKRGxkvsidH6', '2018-07-31 21:09:44');

-- --------------------------------------------------------

--
-- Table structure for table `usersmeta`
--

CREATE TABLE `usersmeta` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `company` varchar(40) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(30) NOT NULL,
  `mobile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usersmeta`
--

INSERT INTO `usersmeta` (`id`, `uid`, `firstname`, `lastname`, `company`, `address1`, `address2`, `city`, `state`, `zip`, `country`, `mobile`) VALUES
(9, 15, 'foo', 'bar', 'Foobar LLC', 'Foo St. ', '', 'Foobar', 'CA.', '95120', 'USA', '1234567'),
(10, 20, 'Some', 'Person', 'ABC Co.', '123 Main St. ', '#14', 'SF', 'CA', '90210', 'USA', '555555-1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordertracking`
--
ALTER TABLE `ordertracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `usersmeta`
--
ALTER TABLE `usersmeta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44445;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `ordertracking`
--
ALTER TABLE `ordertracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `usersmeta`
--
ALTER TABLE `usersmeta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
