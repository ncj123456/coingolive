CREATE TABLE `moeda` (
  `codigo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `moeda` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `symbol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rank` int(11) DEFAULT NULL,
  `available_supply` decimal(20,2) DEFAULT NULL,
  `total_supply` decimal(20,2) DEFAULT NULL,
  `max_supply` decimal(20,2) DEFAULT NULL,
  `moeda_char` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `price_moeda` decimal(35,10) DEFAULT NULL,
  `volume_24h_moeda` decimal(20,2) DEFAULT NULL,
  `market_cap_moeda` decimal(20,2) DEFAULT NULL,
  `percent_dominance` decimal(20,6) DEFAULT NULL,
  `data_alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price_available_supply` decimal(35,10) DEFAULT NULL,
  `percent_available_supply` decimal(20,2) DEFAULT NULL,
  `percent_change_24h` decimal(20,2) DEFAULT NULL,
  `ath` decimal(35,10) DEFAULT NULL,
  `ath_date` date DEFAULT NULL,
  PRIMARY KEY (`codigo`,`moeda`),
  KEY `symbol` (`symbol`),
  KEY `name` (`name`),
  KEY `codigo` (`codigo`),
  KEY `moeda_char` (`moeda_char`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `coin_change` (
  `exchange` varchar(45) DEFAULT NULL,
  `market` varchar(45) DEFAULT NULL,
  `symbol` varchar(45) DEFAULT NULL,
  `price_last` decimal(30,8) DEFAULT '0.00000000',
  `price_high` decimal(30,8) DEFAULT '0.00000000',
  `price_low` decimal(30,8) DEFAULT '0.00000000',
  `diff_porc` decimal(12,2) DEFAULT '0.00',
  `diff_price` decimal(30,8) DEFAULT '0.00000000',
  `last_diff_porc` decimal(12,2) DEFAULT '0.00',
  `volume` decimal(30,2) DEFAULT '0.00',
  `change24h` decimal(12,2) DEFAULT '0.00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `market` (`market`),
  KEY `exchange` (`exchange`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_country` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(455) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_user_pais_idx` (`id_country`),
  CONSTRAINT `fk_user_id_country` FOREIGN KEY (`id_country`) REFERENCES `country` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4061 DEFAULT CHARSET=latin1;

CREATE TABLE `user_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `status` int(1) DEFAULT '1',
  `ip` varchar(255) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_user_access_id_user_idx` (`id_user`),
  CONSTRAINT `fk_user_access_id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=804 DEFAULT CHARSET=latin1;

CREATE TABLE `user_favorite_coin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_coin` varchar(150) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_coin` (`id_coin`),
  KEY `fk_user_favorite_coin_id_user_idx` (`id_user`),
  CONSTRAINT `fk_user_favorite_coin_id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3970 DEFAULT CHARSET=latin1;
