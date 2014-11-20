-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 21-05-2011 a las 10:39:21
-- Versión del servidor: 5.1.52
-- Versión de PHP: 5.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `reymundo_fbconexion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fbc_conexiones`
--

CREATE TABLE IF NOT EXISTS `fbc_conexiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idioma` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `appid` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `appkey` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `appsecret` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `user_inserted` int(11) NOT NULL,
  `user_updated` int(11) NOT NULL,
  `inserted` date NOT NULL,
  `updated` date NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `fbc_conexiones`
--

INSERT INTO `fbc_conexiones` (`id`, `idioma`, `appid`, `appkey`, `appsecret`, `nombre`, `user_inserted`, `user_updated`, `inserted`, `updated`, `estado`) VALUES
(1, 'en', '150918424974768', '75fc30dac2603f5553961b0ee6a7aba8', '41f9e6f63aa005c8a7d27bd2e63b2b81', 'FBConexion', 1, 1, '2011-05-17', '2011-05-17', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fbc_cuentas`
--

CREATE TABLE IF NOT EXISTS `fbc_cuentas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta` varchar(255) NOT NULL,
  `pagina` varchar(255) NOT NULL,
  `tokenpagina` varchar(255) NOT NULL,
  `inserted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `user_inserted` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `fbc_cuentas`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fbc_editors`
--

CREATE TABLE IF NOT EXISTS `fbc_editors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ctleditor` text COLLATE latin1_general_ci NOT NULL,
  `ctlreal` text COLLATE latin1_general_ci NOT NULL,
  `ctlinfo` text COLLATE latin1_general_ci NOT NULL,
  `idfanpage` int(11) NOT NULL,
  `idctl` varchar(150) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=37 ;

--
-- Volcar la base de datos para la tabla `fbc_editors`
--

INSERT INTO `fbc_editors` (`id`, `ctleditor`, `ctlreal`, `ctlinfo`, `idfanpage`, `idctl`) VALUES
(36, '<img class="paresizar" src="http://www.fbconexion.com/images/bg_image.jpg" alt="Flash"  />', '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,29,0" width="100%" height="100%">\n                     <param name="movie" value="http://www.jotaaronak.com/main.swf">\n                     <param name="quality" value="best">\n                     <param name="wmode" value="transparent">\n                     <param name="flashvars" value="">\n                     <embed src="http://www.jotaaronak.com/main.swf" wmode="transparent" flashvars="" quality="best" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" swliveconnect="true">\n                 </object>', '{"flash":"http://www.jotaaronak.com/main.swf","quality":"best","flashvars":""}', 5, 'w2_1305697493');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fbc_estaticos`
--

CREATE TABLE IF NOT EXISTS `fbc_estaticos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug_es` varchar(255) NOT NULL,
  `slug_en` varchar(255) NOT NULL,
  `descripcion_es` text NOT NULL,
  `descripcion_en` text NOT NULL,
  `inserted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `user_inserted` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `fbc_estaticos`
--

INSERT INTO `fbc_estaticos` (`id`, `slug_es`, `slug_en`, `descripcion_es`, `descripcion_en`, `inserted`, `updated`, `user_inserted`, `user_updated`, `estado`) VALUES
(1, 'home', 'home', '<p>\r\n	dadssa&#39;ps</p>\r\n', '<p>\r\n	dsadfdsfyhgv</p>\r\n', NULL, NULL, NULL, NULL, 1),
(5, 'registrate', 'register', '<p>\r\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum faucibus imperdiet magna, vitae condimentum est mattis eget. Aliquam erat volutpat. In tincidunt ligula augue. Maecenas fringilla tempor mauris, eget molestie nulla vulputate eu. Mauris sed nunc non velit pharetra lobortis sed ornare lacus. Maecenas vehicula elit vitae nibh tempor dapibus. Sed scelerisque augue venenatis massa facilisis venenatis. Nullam tincidunt magna non dolor sollicitudin facilisis. Cras blandit laoreet diam, nec dapibus mi elementum vel. Integer dapibus rhoncus turpis, quis convallis sapien mattis quis. Nam dolor dolor, sagittis at faucibus eu, tincidunt ac libero. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla vitae orci magna. Vivamus at est squam. In mattis rutrum diam, sit amet pellentesque nisi feugiat at. Vivamus at mauris massa.</p>\r\n', '<p>\r\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum faucibus imperdiet magna, vitae condimentum est mattis eget. Aliquam erat volutpat. In tincidunt ligula augue. Maecenas fringilla tempor mauris, eget molestie nulla vulputate eu. Mauris sed nunc non velit pharetra lobortis sed ornare lacus. Maecenas vehicula edlit vitae nibh tempor dapibus. Sed scelerisque augue venenatis massa facilisis venenatis. Nullam tincidunt magna non dolor sollicitudin facilisis. Cras blandit laoreet diam, nec dapibus mi elementum vel. Integer dapibus rhoncus turpis, quis convallis sapien mattis quis. Nam dolor dolor, sagittis at faucibus eu, tincidunt ac libero. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla vitae orci magna. Vivamus at est quam. In mattis rutrum diam, sit amet pellentesque nisi feugiat at. Vivamus at mauris massa.</p>\r\n', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fbc_fbpages`
--

CREATE TABLE IF NOT EXISTS `fbc_fbpages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `height` int(11) NOT NULL,
  `idregistro` varchar(20) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `inserted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `user_inserted` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  `contenido` text NOT NULL,
  `fbcuenta` varchar(255) NOT NULL,
  `fbpage` varchar(255) NOT NULL,
  `fondo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `publicado` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcar la base de datos para la tabla `fbc_fbpages`
--

INSERT INTO `fbc_fbpages` (`id`, `height`, `idregistro`, `titulo`, `inserted`, `updated`, `user_inserted`, `user_updated`, `estado`, `contenido`, `fbcuenta`, `fbpage`, `fondo`, `favicon`, `publicado`) VALUES
(5, 0, '100000255493585', '1', NULL, NULL, NULL, NULL, NULL, '    <div class="wm_editor wm12" id="w12_1304614319" style="top: 0px; left: 0px; width: 260px; height: 501px; ">\n        <div class="wm_edco">\n            <img class="paresizar" src="http://www.fbconexion.com/images/bg_image.jpg" alt="V?deo" style="width: 260px; height: 501px; ">            \n        </div>\n    </div>\n    \n    \n    \n    <div class="wm_editor wm17" id="w17_1304614629" style="position: relative; z-index: 5; top: 0px; left: 0px; width: 260px; height: 503px; ">\n        <div class="wm_edco">Curabitur ultrices, risus a laoreet porttitor, magna turpis consectetur ipsum, non mollis lectus velit et augue. Quisque vehicula, arcu vitae eleifend pulvinar, quam elit semper libero, sed pulvinar est mi eget neque. Nullam quis urna leo. Nam enim augue, accumsan vitae aliquam ac, eleifend vitae mi. Cras sem felis, tristique at tincidunt eu, vehicula at sem. Vestibulum leo enim, egestas feugiat ullamcorper ac, fringilla vel sem. Integer interdum sodales enim sed auctor. Phasellus pellentesque dui ac leo vestibulum eu laoreet metus consequat. Maecenas ac leo turpis. Duis suscipit elementum fermentum. Vivamus a mauris nec lacus porttitor blandit eu ac risus. Nulla auctor pellentesque erat. Suspendisse ipsum sem, iaculis at faucibus a, posuere ut arcu. Maecenas vitae sem vitae leo suscipit egestas id nec nunc. Fusce consequat tristique sollicitudin. Vivamus sed mauris urna. Donec justo urna, fermentum a vestibulum non, cursus nec mi. Sed et odio quam. Ut rhoncus purus vitae nisl luctus sagittis. Donec id sem erat, nec condimentum odio.</div>        \n    <div id="controlbox" style="display: none; ">\n            <a title="Editar" id="ieditor_editar" onclick="return editarbox(this)" title2="Editar" href="#w17_1304614629"></a>\n            <a id="ieditor_eliminar" onclick="return eliminarbox(this)" title2="Eliminar" href="#w17_1304614629"></a>\n        </div></div>        <div class="wm_editor wm2" id="w2_1305697493" style="position: relative; z-index: 5; top: 0px; left: 0px; width: 520px; height: 260px; ">\n            <div class="wm_edco"><img class="paresizar" src="http://www.fbconexion.com/images/bg_image.jpg" alt="Flash" style="width: 520px; height: 260px; "></div>\n        </div>\n        ', '', '215585355132778', NULL, NULL, 0),
(6, 0, '1418715186', '1', NULL, NULL, NULL, NULL, NULL, '', '', '182738935353', NULL, NULL, 0),
(7, 0, '1418715186', '1', NULL, NULL, NULL, NULL, NULL, '', '', '205351732836413', NULL, NULL, 0),
(8, 0, '1418715186', '1', NULL, NULL, NULL, NULL, NULL, '', '', '182738935353', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fbc_registro`
--

CREATE TABLE IF NOT EXISTS `fbc_registro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `empresa` varchar(255) NOT NULL,
  `usuario` varchar(30) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `inserted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `user_inserted` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcar la base de datos para la tabla `fbc_registro`
--

INSERT INTO `fbc_registro` (`id`, `nombres`, `apellidos`, `empresa`, `usuario`, `password`, `inserted`, `updated`, `user_inserted`, `user_updated`, `estado`) VALUES
(12, 'cliente1nom', 'cliente1ape', 'gtjifdbnknb', 'cliente1', '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fbc_sessiones`
--

CREATE TABLE IF NOT EXISTS `fbc_sessiones` (
  `session_id` varchar(255) NOT NULL DEFAULT '',
  `session_expires` int(11) DEFAULT NULL,
  `session_data` text,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `fbc_sessiones`
--

INSERT INTO `fbc_sessiones` (`session_id`, `session_expires`, `session_data`) VALUES
('4fe9d67a454a62d2cb7d1a884622fe87', 1302058680, 'TnR6FyU4DRmwvdTe3BTHDnrH2TvfDlFq61IdhL6nAAudBMNgGcuVNqMW-ntrYwgH9Y3-lbGDw1bjmX9CtG67rua8gn9BI2MevrBRXTnxMBKGhoTa0ygX2csOC_CYhjW9DRhVI55TJRnw48ZE0Um8UBt9vv0FT-vxtYDKboxrUZioHML4h65foPJiDbgU5BLUfkeEOXWveZ3nrpG3CDQ6pqWmkMM94yQJ0I3SU5Jw6ls.'),
('4c535a42dbd669fd292b9aca1e4ecdab', 1302039709, 'JN99CKNVMalGx4xzr0OiwRuEGe07wkER49sKViH4hJxGTtg5JG4upiVWUgVipHsBNk79h0Fy4j_FEHt8EDmbPcFZbxzGqWFkDVGxTx1beUJpD7oxW3CBTnPoiqQ0bCQvDTvEc0u_qtdUYCvRxbYPiKTTEjXzVpxRLtBzPyxTt-Y5etqpMAVBvm3Zhna77avdeF6uJcb4IAslczbKfrwhf61hTOIMKRpliLMijMCjEGc.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fbc_templates`
--

CREATE TABLE IF NOT EXISTS `fbc_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contenido` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `fbc_templates`
--

INSERT INTO `fbc_templates` (`id`, `contenido`) VALUES
(1, '<div class="wm_editor wm12 ui-resizable" id="w12_1304612959" style="top: 0px; left: 0px; width: 521px; height: 200px; ">\r\n    <div class="wm_edco">\r\n        <img class="paresizar" src="http://www.fbconexion.com/images/bg_image.jpg" alt="Vídeo" style="width: 521px; height: 200px; ">       \r\n    </div>\r\n</div>\r\n<div class="wm_editor wm4 ui-resizable" id="w4_1304613044" style="top: 0px; left: 0px; width: 520px; height: 300px; ">\r\n    <div class="wm_edco">\r\n        <img class="paresizar" src="http://www.fbconexion.com/images/bg_video1.jpg" alt="Vídeo" style="width: 520px; height: 300px; ">         \r\n    </div>\r\n</div>\r\n<div class="wm_editor wm17 ui-resizable" id="w17_1304613082" style="top: 0px; left: 0px; width: 520px; height: 167px; ">\r\n    <div class="wm_edco">Cras ut ligula vel turpis elementum consectetur vitae quis odio. Cras vehicula mauris nec dolor egestas blandit. Praesent placerat volutpat quam non dictum. Morbi gravida nisl vitae justo gravida eleifend. Cras vel magna ante, in venenatis sem. Fusce egestas, diam rutrum pharetra convallis, nunc odio rutrum diam, et sodales leo velit a magna. Cras nibh ante, tincidunt eget feugiat vel, scelerisque sit amet lorem. Fusce sit amet mauris elit, varius gravida tortor. Nunc ut libero arcu. Pellentesque gravida dapibus ultricies. Donec non lectus turpis. Donec ipsum justo, gravida a vehicula ut, mollis mollis mi. Curabitur et sem nunc, vel pellentesque diam. Curabitur non metus eu ipsum pulvinar luctus. Nullam molestie nisl sit amet est tempor egestas. Vivamus at nulla arcu.</div>        \r\n</div>\r\n<div class="wm_editor wm3 ui-resizable" id="w3_1304613167" style="top: 0px; left: 0px; width: 520px; height: 238px; ">\r\n    <div class="wm_edco">\r\n        <div style="text-align:center"><img src="http://www.fbconexion.com/images/bg_comentario.jpg" alt="Flash"></div>            \r\n    </div>\r\n</div>'),
(2, '    <div class="wm_editor wm12 ui-resizable" id="w12_1304614319" style="top: 0px; left: 0px; width: 520px; height: 201px; ">\r\n        <div class="wm_edco">\r\n            <img class="paresizar" src="http://www.fbconexion.com/images/bg_image.jpg" alt="Vídeo" style="width: 520px; height: 201px; ">            \r\n        </div>\r\n    </div>\r\n    <div class="wm_editor wm17 ui-resizable" id="w17_1304614370" style="top: 0px; left: 0px; width: 258px; height: 255px; ">\r\n        <div class="wm_edco">Aliquam porta tortor quis risus elementum eget posuere dolor pretium. Aenean viverra mi eget nisl interdum pharetra scelerisque erat tristique. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin auctor, elit vitae pharetra iaculis, mauris turpis semper tellus, id molestie eros lectus sed dui. Etiam magna lorem, cursus eget malesuada ut, tempor eget mi. Pellentesque sed pharetra ligula. Vestibulum in euismod tortor. Sed urna nunc, adipiscing vel auctor ac, faucibus lobortis libero. Donec sem quam, euismod vitae molestie in.</div>        \r\n    </div>\r\n    <div class="wm_editor wm12 ui-resizable" id="w12_1304614412" style="top: 0px; left: 0px; width: 258px; height: 255px; ">\r\n        <div class="wm_edco">\r\n            <img class="paresizar" src="http://www.fbconexion.com/images/bg_image.jpg" alt="Vídeo" style="width: 258px; height: 255px; ">            \r\n        </div>\r\n    </div>\r\n    <div class="wm_editor wm12 ui-resizable" id="w12_1304614555" style="top: 0px; left: 0px; width: 520px; height: 200px; ">\r\n        <div class="wm_edco">\r\n            <img class="paresizar" src="http://www.fbconexion.com/images/bg_image.jpg" alt="Vídeo" style="width: 520px; height: 200px; ">           \r\n        </div>\r\n    </div>\r\n    <div class="wm_editor wm17 ui-resizable" id="w17_1304614629" style="position: relative; z-index: 5; top: 0px; left: 0px; width: 520px; height: 213px; ">\r\n        <div class="wm_edco">Curabitur ultrices, risus a laoreet porttitor, magna turpis consectetur ipsum, non mollis lectus velit et augue. Quisque vehicula, arcu vitae eleifend pulvinar, quam elit semper libero, sed pulvinar est mi eget neque. Nullam quis urna leo. Nam enim augue, accumsan vitae aliquam ac, eleifend vitae mi. Cras sem felis, tristique at tincidunt eu, vehicula at sem. Vestibulum leo enim, egestas feugiat ullamcorper ac, fringilla vel sem. Integer interdum sodales enim sed auctor. Phasellus pellentesque dui ac leo vestibulum eu laoreet metus consequat. Maecenas ac leo turpis. Duis suscipit elementum fermentum. Vivamus a mauris nec lacus porttitor blandit eu ac risus. Nulla auctor pellentesque erat. Suspendisse ipsum sem, iaculis at faucibus a, posuere ut arcu. Maecenas vitae sem vitae leo suscipit egestas id nec nunc. Fusce consequat tristique sollicitudin. Vivamus sed mauris urna. Donec justo urna, fermentum a vestibulum non, cursus nec mi. Sed et odio quam. Ut rhoncus purus vitae nisl luctus sagittis. Donec id sem erat, nec condimentum odio.</div>        \r\n    </div>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fbc_usuarios`
--

CREATE TABLE IF NOT EXISTS `fbc_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `usuario` varchar(30) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `inserted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `user_inserted` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Volcar la base de datos para la tabla `fbc_usuarios`
--

INSERT INTO `fbc_usuarios` (`id`, `nombres`, `apellidos`, `usuario`, `password`, `inserted`, `updated`, `user_inserted`, `user_updated`, `estado`) VALUES
(29, 'esoporte', 'esoporte', 'e', '255675816e583a92900a97058a0dd588', '0000-00-00 00:00:00', '2010-10-18 11:35:08', NULL, 54, 1),
(54, 'administrador', 'administrador', 'admin', '202cb962ac59075b964b07152d234b70', '2009-09-02 09:09:23', '0000-00-00 00:00:00', 29, 29, 1);
