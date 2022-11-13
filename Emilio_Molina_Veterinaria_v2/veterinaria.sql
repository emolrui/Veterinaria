-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-01-2022 a las 19:23:06
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `veterinaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `cliente` bigint(20) UNSIGNED NOT NULL,
  `servicio` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`cliente`, `servicio`, `fecha`, `hora`) VALUES
(10, 1, '2022-01-06', '18:25:00'),
(10, 3, '2022-01-10', '19:29:00'),
(11, 3, '2022-01-24', '11:43:00'),
(12, 3, '2022-02-10', '08:44:00'),
(13, 1, '2022-01-31', '13:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `edad` int(2) UNSIGNED NOT NULL,
  `dni_dueño` varchar(9) NOT NULL,
  `foto` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `tipo`, `nombre`, `edad`, `dni_dueño`, `foto`) VALUES
(10, 'Husky Siberiano', 'Mascotex', 2, '123456789', 'husky.jpg'),
(11, 'Bulldog', 'Coco', 1, '45615973H', 'bulldog.jpg'),
(12, 'Golden retriever', 'Thoor', 3, '12345678R', 'notici.jpg'),
(13, 'Schnauzer', 'Niebla', 2, '10579354J', 'descarga.jpg.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dueño`
--

CREATE TABLE `dueño` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `nick` varchar(15) NOT NULL,
  `pass` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dueño`
--

INSERT INTO `dueño` (`dni`, `nombre`, `telefono`, `nick`, `pass`) VALUES
('00000000', 'Administrador', '', 'admin', 'admin'),
('10579354J', 'Maria', '479214830', 'mari', 'mari'),
('123456789', 'Emilio', '123456789', 'emi', 'emi'),
('12345678R', 'Antonio', '644644644', 'toni', 'toni'),
('45615973H', 'Jose', '789456123', 'pepe', 'pepe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `contenido` varchar(300) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `fecha_publicacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id`, `titulo`, `contenido`, `imagen`, `fecha_publicacion`) VALUES
(1, 'Vivotecnia ', 'Vivotecnia firma un millón en contratos públicos tras el vídeo con vejaciones a animales.\r\nLa ONG británica Cruelty Free International recrimina a cuatro organismos españoles que recurran a una empres', 'noticia1.jpg', '2021-11-01'),
(2, 'Covid-19', 'Detectada por primera vez la covid-19 en fauna silvestre de Canadá\r\nLa enfermedad fue hallada en tres ciervos de cola blanca en Quebec. Se trata del segundo país, tras Estados Unidos, que señala casos', 'noticia2.jpg', '2021-10-25'),
(3, 'Maltrato animal', 'El calvario de 600 búfalos abandonados a su suerte para dejar paso a las plantaciones de soja en Brasil.\r\nMás de 100 animales han muerto de hambre en un caso considerado por las ONG como el más grave ', 'noticia3.jpg', '2021-11-02'),
(9, 'Venta ilegal de animales exóticos', 'La Guardia Civil investiga a una mujer de 61 años como presunta autora de un delito de tráfico ilegal de especies protegidas o en peligro de extinción. Los agentes le han incautado un bolso de piel de cocodrilo, una piel de serpiente boa del Amazonas y una manta confeccionada con pieles de güanaco.', 'noticia4.jpg', '2021-11-04'),
(10, 'Reino Unido', 'El alcance del proyecto de ley de Bienestar Animal de Reino Unido se ha ampliado durante esta semana para reconocer langostas, pulpos y cangrejos y todos los demás crustáceos decápodos y moluscos cefalópodos como seres sensibles.', 'noticia5.jpeg', '2021-11-24'),
(11, 'La Naturaleza Encendida', 'Tras un rotundo éxito en sus dos primeras ediciones en El Real Jardín Botánico de Madrid, el Oceanogràfic de Valencia acoge desde este jueves un sorprendente acontecimiento inmersivo de artes lumínicas y sensoriales en un entorno natural. Una singular propuesta inmersiva: Naturaleza Encendida.', 'noticia6.jpg', '2021-11-01'),
(12, 'Imputada en Toledo', 'La Guardia Civil ha incautado cinco perros, uno de ellos herido de gravedad, donde además se encontraron y desmantelaron 200 plantas de marihuana. La propietaria, una mujer de 38 años, ha sido citada ante la autoridad judicial imputándose un delito de maltrato animal y un delito contra la salud públ', 'noticia7.jpg', '2021-08-12'),
(13, 'Las mascotas ya pueden viajar con Uber', 'Uber ha anunciado hoy una noticia súper especial para todos aquellos que sean amantes de los animales, el lanzamiento de \'Uber Pet\' por españa, lo que permitirá a los usuarios de la plataforma solicitar viajes para ellos y sus mascotas a través de este nuevo servicio con tan solo pulsar un botón.', 'noticia8.jpg', '2021-11-02'),
(16, 'La charcutería insalubre de los 600 jabalíes', 'A los investigadores les sorprende la arrogancia con la que el dueño de la charcutería Elaborats Sant Joan seguía trabajando. El cuerpo de Agents Rurals le ha interceptado hasta 600 piezas, la inmensa mayoría jabalíes, abiertas en canal y preparadas para ser comercializadas ilegalmente en Andalucía.', 'noticia9.jpg', '2021-12-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` int(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `precio`) VALUES
(2, 'Lenda Nature Senior/Mobility', 63),
(3, 'Tender & Delicious BREKKIES Affinity', 42),
(4, 'Lenda Original Adult Chicken', 50),
(6, 'KNINE WD POWER DOG', 49);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `duracion` int(6) NOT NULL,
  `precio` int(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id`, `descripcion`, `duracion`, `precio`) VALUES
(1, 'Cortado de uñas', 19, 20),
(2, 'Desparasitacion ', 50, 50),
(3, 'Peinado', 45, 40),
(5, 'Lavado ', 25, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonio`
--

CREATE TABLE `testimonio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dni_autor` varchar(9) NOT NULL,
  `contenido` varchar(300) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `testimonio`
--

INSERT INTO `testimonio` (`id`, `dni_autor`, `contenido`, `fecha`) VALUES
(9, '45615973H', 'Súper simpáticos y se nota que les gustan los animales. Un gusto llevar a mi mascota.', '2021-11-02'),
(10, '123456789', 'Acabo de ir por primera vez y el chico que me atendió super amable. Muy contenta.', '2022-01-18'),
(11, '12345678R', 'Atención muy buena, y muy buen trato,se preocupan por todo lo q le pase a tu mascota', '2022-01-10'),
(12, '10579354J', 'Un trato excelente son súper cariñosos y siempre intentan que los animales se vayan contentos.', '2021-12-14');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`cliente`,`servicio`),
  ADD KEY `cit_servi` (`servicio`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`,`dni_dueño`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `dni_enlazado` (`dni_dueño`);

--
-- Indices de la tabla `dueño`
--
ALTER TABLE `dueño`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD PRIMARY KEY (`id`,`dni_autor`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `dni_enlazado_dos` (`dni_autor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `cit_cli` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cit_servi` FOREIGN KEY (`servicio`) REFERENCES `servicio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `dni_enlazado` FOREIGN KEY (`dni_dueño`) REFERENCES `dueño` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD CONSTRAINT `dni_enlazado_dos` FOREIGN KEY (`dni_autor`) REFERENCES `dueño` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
