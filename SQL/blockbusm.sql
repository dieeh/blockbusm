-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2022 a las 00:15:58
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `blockbusm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(256) NOT NULL,
  `admin_password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_username`, `admin_password`) VALUES
(1, 'dieehadmin', '$2y$10$iVnHWHpSzi1//F4jMkVsOOHbd8UBd6jPMhD3wrY31hpdMk9t9qEre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movies_carac`
--

CREATE TABLE `movies_carac` (
  `id_movie` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `gender` varchar(64) NOT NULL,
  `public` varchar(3) NOT NULL,
  `lenght` int(11) NOT NULL,
  `cast` text NOT NULL,
  `description` varchar(256) NOT NULL,
  `image` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `movies_carac`
--

INSERT INTO `movies_carac` (`id_movie`, `title`, `gender`, `public`, `lenght`, `cast`, `description`, `image`) VALUES
(23, 'The Dark Knight', 'Action', 'PG', 152, 'Christian Bale, Heath Ledger, Aaron Eckhart', 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.', 'The Dark Knight (2008).jpeg'),
(25, 'The Godfather Part II', 'Crime', 'R', 202, 'Al Pacino, Robert De Niro, Robert Duvall', 'The early life and career of Vito Corleone in 1920s New York City is portrayed, while his son, Michael, expands and tightens his grip on the family crime syndicate.', 'The Godfather Part II (1974).png'),
(27, 'Fight Club', 'Drama', 'R', 139, 'Brad Pitt, Edward Norton, Meat Loaf', 'An insomniac office worker and a devil-may-care soap maker form an underground fight club that evolves into much more.', 'Fight Club (1999).jpg'),
(28, 'The Shawshank Redemption', 'Drama', 'R', 142, 'Tim Robbins, Morgan Freeman, Bob Gunton', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 'The Shawshank Redemption (1994).png'),
(30, 'The Avengers', 'Action', 'PG', 143, 'Robert Downey Jr., Chris Evans, Scarlett Johansson', 'Earth\'s mightiest heroes must come together and learn to fight as a team if they are going to stop the mischievous Loki and his alien army from enslaving humanity.', 'The Avengers (2012).jpeg'),
(31, 'Star Wars: Episode I - The Phantom Menace', 'Action', 'PG', 136, 'Ewan McGregor, Liam Neeson, Natalie Portman', 'Two Jedi escape a hostile blockade to find allies and come across a young boy who may bring balance to the Force, but the long dormant Sith resurface to claim their original glory.', 'Star Wars- Episode I - The Phantom Menace (1999).jpeg'),
(32, 'Star Wars: Episode II - Attack of the Clones', 'Action', 'PG', 142, 'Hayden Christensen, Natalie Portman, Ewan McGregor', 'Ten years after initially meeting, Anakin Skywalker shares a forbidden romance with Padmé Amidala, while Obi-Wan Kenobi investigates an assassination attempt on the senator and discovers a secret clone army crafted for the Jedi.', 'Star Wars- Episode II - Attack of the Clones (2002).jpeg'),
(33, 'Star Wars: Episode III - Revenge of the Sith', 'Action', 'PG', 140, 'Hayden Christensen, Natalie Portman, Ewan McGregor', 'Three years into the Clone Wars, the Jedi rescue Palpatine from Count Dooku. As Obi-Wan pursues a new threat, Anakin acts as a double agent between the Jedi Council and Palpatine and is lured into a sinister plan to rule the galaxy.', 'Star Wars- Episode III - Revenge of the Sith (2005).jpeg'),
(34, 'Star Wars: Episode VI - Return of the Jedi', 'Action', 'PG', 131, 'Mark Hamill, Harrison Ford, Carrie Fisher', 'After a daring mission to rescue Han Solo from Jabba the Hutt, the Rebels dispatch to Endor to destroy the second Death Star. Meanwhile, Luke struggles to help Darth Vader back from the dark side without falling into the Emperor\'s trap.', 'Return of the Jedi (1983).jpeg'),
(35, 'Star Wars: Episode V - The Empire Strikes Back', 'Action', 'PG', 124, 'Mark Hamill, Harrison Ford, Carrie Fisher', 'After the Rebels are brutally overpowered by the Empire on the ice planet Hoth, Luke Skywalker begins Jedi training with Yoda, while his friends are pursued across the galaxy by Darth Vader and bounty hunter Boba Fett.', 'The Empire Strikes Back (1980).jpeg'),
(36, 'American Psycho', 'Crime', 'R', 102, 'Christian Bale, Justin Theroux, Josh Lucas', 'A wealthy New York City investment banking executive, Patrick Bateman, hides his alternate psychopathic ego from his co-workers and friends as he delves deeper into his violent, hedonistic fantasies.', 'American Psycho (2000).png'),
(37, 'Pulp Fiction', 'Crime', 'R', 154, 'John Travolta, Uma Thurman, Samuel L. Jackson', 'The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine in four tales of violence and redemption.', 'Pulp Fiction (1994).jpeg'),
(38, 'Spider-Man', 'Action', 'PG', 121, 'Tobey Maguire, Kirsten Dunst, Willem Dafoe', 'After being bitten by a genetically-modified spider, a shy teenager gains spider-like abilities that he uses to fight injustice as a masked superhero and face a vengeful enemy.', 'Spider-Man (2002).jpg'),
(39, 'Spider-Man 2', 'Action', 'PG', 127, 'Tobey Maguire, Kirsten Dunst, Alfred Molina', 'Peter Parker is beset with troubles in his failing personal life as he battles a brilliant scientist named Doctor Otto Octavius.', 'Spider-Man 2 (2004).jpg'),
(40, 'Spider-Man 3', 'Action', 'PG', 136, 'Tobey Maguire, Kirsten Dunst, Topher Grace', 'A strange black entity from another world bonds with Peter Parker and causes inner turmoil as he contends with new villains, temptations, and revenge.', 'Spider-Man 3 (2007).jpg'),
(41, 'The Godfather Part III', 'Crime', 'R', 162, 'Al Pacino, Diane Keaton, Andy García', 'Follows Michael Corleone, now in his 60s, as he seeks to free his family from crime and find a suitable successor to his empire.', 'The Godfather Part III (1990).jpeg'),
(42, 'The Godfather', 'Crime', 'R', 175, 'Marlon Brando, Al Pacino, James Caan', 'The aging patriarch of an organized crime dynasty in postwar New York City transfers control of his clandestine empire to his reluctant youngest son.', 'The Godfather (1972).jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movies_data`
--

CREATE TABLE `movies_data` (
  `id_movie` int(11) NOT NULL,
  `price` bigint(20) NOT NULL,
  `times_rented` int(11) NOT NULL,
  `available_units` int(11) NOT NULL,
  `total_units` int(11) NOT NULL,
  `site_score` int(11) NOT NULL,
  `usmtomatoes_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'dieeh', '$2y$10$Q2xAolr/zs75sjhZl7T1vup871PjwNGtrm17eszB35EPXQcJgMlG6');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indices de la tabla `movies_carac`
--
ALTER TABLE `movies_carac`
  ADD PRIMARY KEY (`id_movie`);

--
-- Indices de la tabla `movies_data`
--
ALTER TABLE `movies_data`
  ADD PRIMARY KEY (`id_movie`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `movies_carac`
--
ALTER TABLE `movies_carac`
  MODIFY `id_movie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `movies_data`
--
ALTER TABLE `movies_data`
  MODIFY `id_movie` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `movies_data`
--
ALTER TABLE `movies_data`
  ADD CONSTRAINT `test` FOREIGN KEY (`id_movie`) REFERENCES `movies_carac` (`id_movie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
