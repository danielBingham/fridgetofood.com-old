

--
-- Table structure for table `image_votes`
--

CREATE TABLE `image_votes` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` bigint(20) unsigned DEFAULT NULL,
	`image_id` bigint(20) unsigned DEFAULT NULL,
	`vote` tinyint(2) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `image_id` (`image_id`),
	KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;




--
-- Table structure for table `images`
--

CREATE TABLE `images` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` bigint(20) unsigned DEFAULT NULL,
	`width` int(11) DEFAULT '1024',
	`height` int(11) DEFAULT '768',
	`views` bigint(20) unsigned DEFAULT '0',
	`site` varchar(64) DEFAULT 'fridge',
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;



--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) DEFAULT NULL,
	`description` text DEFAULT NULL,
	PRIMARY KEY (`id`),
	FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;


--
-- Table structure for table `measurement_aliases`
--

CREATE TABLE `measurement_aliases` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`alias` varchar(255) DEFAULT NULL,
	`measurement_id` bigint(20) unsigned DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;


--
-- Dumping data for table `measurement_aliases`
--

LOCK TABLES `measurement_aliases` WRITE;
/*!40000 ALTER TABLE `measurement_aliases` DISABLE KEYS */;
INSERT INTO `measurement_aliases` 
        VALUES 
            (1,'lb',1),
            (2,'pound',1),
            (25,'ounce',4),
            (4,'lbs',1),
            (5,'pounds',1),
            (6,'teaspoon',2),
            (7,'teaspoons',2),
            (8,'tsp',2),
            (9,'tsps',2),
            (33,'gals',5),
            (23,'tbsps',3),
            (34,'gallons',5),
            (13,'t',2),
            (14,'ts',2),
            (21,'tbsp',3),
            (17,'tablespoon',3),
            (18,'tablespoons',3),
            (19,'T',3),
            (20,'Ts',3),
            (26,'oz',4),
            (32,'gal',5),
            (29,'ounces',4),
            (31,'gallon',5),
            (35,'cup',6),
            (36,'cups',6),
            (37,'c',6),
            (38,'cs',6),
            (39,'pint',7),
            (40,'pints',7),
            (41,'pt',7),
            (42,'pts',7),
            (43,'quart',8),
            (44,'quarts',8),
            (45,'qts',8),
            (46,'qt',8),
            (47,'g',11),
            (48,'l',9),
            (49,'ml',10),
            (50,'kg',12);

/*!40000 ALTER TABLE `measurement_aliases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measurements`
--

CREATE TABLE `measurements` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`long_name` varchar(255) DEFAULT NULL,
	`system` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;


--
-- Dumping data for table `measurements`
--

LOCK TABLES `measurements` WRITE;
/*!40000 ALTER TABLE `measurements` DISABLE KEYS */;
INSERT INTO `measurements` 
        VALUES 
            (1,'pound','imperial'),
            (2,'teaspoon','imperial'),
            (3,'tablespoon','imperial'),
            (4,'ounce','imperial'),
            (5,'gallon','imperial'),
            (6,'cup','imperial'),
            (7,'pint','imperial'),
            (8,'quart','imperial'),
            (9,'liter','metric'),
            (10,'milliliter','metric'),
            (11,'gram','metric'),
            (12,'kilogram','metric'),
            (13,'fluid ounce','imperial');
/*!40000 ALTER TABLE `measurements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--
CREATE TABLE `permissions` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;


--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'administrate'),(2,'moderate');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe_comments`
--
CREATE TABLE `recipe_comments` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` bigint(20) unsigned DEFAULT NULL,
	`recipe_id` bigint(20) unsigned DEFAULT NULL,
	`content` text,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `user_id` (`user_id`),
	KEY `recipe_id` (`recipe_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;




--
-- Table structure for table `recipe_images`
--

CREATE TABLE `recipe_images` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`recipe_id` bigint(20) unsigned DEFAULT NULL,
	`image_id` bigint(20) unsigned DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `recipe_id` (`recipe_id`,`image_id`),
	KEY `recipe_id_2` (`recipe_id`),
	KEY `image_id` (`image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;



--
-- Table structure for table `recipe_instructions`
--
CREATE TABLE `recipe_instructions` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`recipe_id` bigint(20) unsigned NOT NULL,
	`recipe_section_id` bigint(20) unsigned NOT NULL,
	`number` int(11) DEFAULT NULL,
	`content` text,
	PRIMARY KEY (`id`),
	KEY `recipe_id` (`recipe_id`),
	KEY `recipe_section_id` (`recipe_section_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;


--
-- Table structure for table `recipe_items`
--

CREATE TABLE `recipe_items` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`recipe_id` bigint(20) unsigned DEFAULT NULL,
	`recipe_section_id` bigint(20) unsigned DEFAULT NULL,
	`ingredient_id` bigint(20) unsigned DEFAULT NULL,
	`preparation` varchar(255) DEFAULT NULL,
	`amount` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `recipe_id` (`recipe_id`),
	KEY `ingredient_id` (`ingredient_id`),
	KEY `recipe_section_id` (`recipe_section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;


--
-- Table structure for table `recipe_sections`
--

CREATE TABLE `recipe_sections` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`recipe_id` bigint(20) unsigned DEFAULT NULL,
	`title` varchar(512) DEFAULT NULL,
	`position` int(11) DEFAULT '0',
	`base` tinyint(1) DEFAULT NULL,
	PRIMARY KEY (`id`),
	  KEY `recipe_id` (`recipe_id`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;


--
-- Table structure for table `recipe_tags`
--

CREATE TABLE `recipe_tags` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`recipe_id` bigint(20) unsigned DEFAULT NULL,
	`tag_id` bigint(20) unsigned DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `recipe_id` (`recipe_id`),
	KEY `tag_id` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;


--
-- Table structure for table `recipe_votes`
--

CREATE TABLE `recipe_votes` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` bigint(20) unsigned DEFAULT NULL,
	`recipe_id` bigint(20) unsigned DEFAULT NULL,
	`vote` tinyint(2) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `user_id` (`user_id`),
	KEY `recipe_id` (`recipe_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;




--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`title` varchar(255) DEFAULT NULL,
	`intro` text,
	`url_title` varchar(255) DEFAULT NULL,
	`source` varchar(255) DEFAULT NULL,
	`source_url` varchar(255) DEFAULT NULL,
	`blog` varchar(255) DEFAULT NULL,
	`blog_url` varchar(255) DEFAULT NULL,
	`user_id` bigint(20) unsigned DEFAULT NULL,
	`preparation_time` varchar(255) DEFAULT NULL,
	`serves` varchar(255) DEFAULT NULL,
	`views` bigint(20) unsigned DEFAULT '0',
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	`is_community` tinyint(1) DEFAULT '0',
	`is_deleted` tinyint(1) DEFAULT '0',
	PRIMARY KEY (`id`),
	KEY `user_id` (`user_id`),
	FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;

--
-- Table structure for table `recipe_revisions`
--
	  

--
-- Table structure for table `reputation_bonuses`
--

CREATE TABLE `reputation_bonuses` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` bigint(20) unsigned DEFAULT NULL,
	`value` bigint(20) DEFAULT NULL,
	`reason` text,
	PRIMARY KEY (`id`),
	KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;




--
-- Table structure for table `ribbons`
--

CREATE TABLE `ribbons` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) DEFAULT NULL,
	`display_name` varchar(255) DEFAULT NULL,
	`description` text,
	`type` varchar(64) DEFAULT NULL,
	`repeatable` tinyint(1) DEFAULT '0',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;


--
-- Dumping data for table `ribbons`
--

LOCK TABLES `ribbons` WRITE;

INSERT INTO `ribbons` 
        VALUES 
            (22,'beta','Beta User','Registered user during the beta.','red',0),
            (23,'voter','Voter','First vote cast.','rainbow',0),
            (24,'critic','Critic','First down vote cast.','rainbow',0),
            (25,'cook','Cook','First posted recipe.','rainbow',0),
            (26,'autobiographer','Autobiographer','Filled out all profile fields.','rainbow',0),
            (27,'resident','Resident','Cast 30 recipe votes and 100 image votes.','white',0),
            (28,'electorate','Electorate','Cast 300 recipe votes and 1000 image votes.','blue',0),
            (29,'citizen','Citizen','Cast 100 recipe votes and 300 image votes.','red',0),
            (30,'chefdepartie','Chef de Partie','Posted 25 recipes.','white',0),
            (31,'souschef','Sous-Chef','Posted 100 recipes.','red',0),
            (32,'chefdecuisine','Chef de Cuisine','Posted 400 recipes.','blue',0),
            (33,'yum','Yum','First upvote received on a recipe you posted.','rainbow',0),
            (34,'yuck','Yuck','First downvote received on a recipe you posted.','rainbow',0),
            (35,'threestars','Three Star Recipe','Recipe received 10 upvotes.','white',1),
            (36,'fourstars','Four Star Recipe','Recipe received 25 upvotes.','red',1),
            (37,'fivestars','Five Star Recipe','Recipe received 100 upvotes.','blue',1);

UNLOCK TABLES;

--
-- Table structure for table `search_results`
--

CREATE TABLE `search_results` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`search_id` bigint(20) unsigned DEFAULT NULL,
	`recipe_id` bigint(20) unsigned DEFAULT NULL,
	`relevance` float DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;



--
-- Table structure for table `searches`
--

CREATE TABLE `searches` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`query` varchar(2048) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`used` datetime DEFAULT NULL,
	`type` varchar(255) DEFAULT 'ingredient',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;




--
-- Table structure for table `tag_histories`
--

CREATE TABLE `tag_histories` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`tag_id` bigint(20) unsigned DEFAULT NULL,
	`name` varchar(255) DEFAULT NULL,
	`type` varchar(64) DEFAULT 'general',
    `site` varchar(64) DEFAULT 'fridge',	
    `description` text,
	`edit_time` datetime DEFAULT NULL,
	`revision` bigint(20) unsigned DEFAULT NULL,
	`user_id` bigint(20) unsigned DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;



--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) DEFAULT NULL,
	`type` varchar(64) DEFAULT 'general',
	`site` varchar(64) DEFAULT 'fridge',
	`description` text,
	`revision` bigint(20) unsigned DEFAULT '1',
	`user_id` bigint(20) unsigned DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;




--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`permission_id` bigint(20) unsigned DEFAULT NULL,
	`user_id` bigint(20) unsigned DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;


--
-- Dumping data for table `user_permissions`
--

LOCK TABLES `user_permissions` WRITE;

INSERT INTO `user_permissions` VALUES (1,1,2,'2010-12-12 12:13:27');

UNLOCK TABLES;

--
-- Table structure for table `user_ribbons`
--

CREATE TABLE `user_ribbons` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`ribbon_id` bigint(20) unsigned DEFAULT NULL,
	`user_id` bigint(20) unsigned DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;




--
-- Table structure for table `users`
--

CREATE TABLE `users` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`email` varchar(255) DEFAULT NULL,
	`password` varchar(255) DEFAULT NULL,
	`display_name` varchar(255) DEFAULT NULL,
	`reputation` bigint(20) unsigned DEFAULT NULL,
	`website` varchar(255) DEFAULT NULL,
	`website_url` varchar(511) DEFAULT NULL,
	`import_blog` tinyint(1) DEFAULT NULL,
	`about` text,
	`image_id` bigint(20) unsigned DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`seen` datetime DEFAULT NULL,
	`notified` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `image_id` (`image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;


--
-- Table structure for table `users_facebook`
--

CREATE TABLE `user_facebooks` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` bigint(20) unsigned NOT NULL,   
    `email` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;


--
-- Table structure for table `users_google`
--

CREATE TABLE `user_googles` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` bigint(20) unsigned NOT NULL,
    `email` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;
    



--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`ip` varchar(255) DEFAULT NULL,
	`user_agent` varchar(255) DEFAULT NULL,
	`pageviews` bigint(20) unsigned DEFAULT NULL,
	`user_id` bigint(20) unsigned DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;




--
-- Table structure for table `words_preparation`
--

CREATE TABLE `words_preparation` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`word` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=UTF8;


--
-- Dumping data for table `words_preparation`
--

LOCK TABLES `words_preparation` WRITE;

INSERT INTO `words_preparation` 
        VALUES 
            (1,'peeled'),
            (2,'chopped'),
            (3,'sliced'),
            (4,'minced'),
            (5,'diced'),
            (6,'cooked'),
            (7,'cored'),
            (8,'seeded'),
            (9,'torn'),
            (10, 'fresh'),
            (11, 'freshly'),
            (12, 'squeezed');

UNLOCK TABLES;


---
---	Farm Table structures
---

/**
 * Farms table to store basic information for each farm.
 */
CREATE TABLE `farms` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`description` text DEFAULT NULL,
	`website` varchar(255) DEFAULT NULL,
	`email` varchar(255) DEFAULT NULL,
	`phone` varchar(16) DEFAULT NULL,
	`address` text DEFAULT NULL,
	`open_times` text DEFAULT NULL,
	`user_id` bigint(20) unsigned DEFAULT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	PRIMARY KEY (`id`),
	KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;

CREATE TABLE `markets` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) DEFAULT NULL,
	`description` text DEFAULT NULL,
	`website` varchar(255) DEFAULT NULL,
	`email` varchar(255) DEFAULT NULL,
	`address` text DEFAULT NULL,
	`open_times` text DEFAULT NULL,
	`start_date` date DEFAULT NULL,
	`end_date` date DEFAULT NULL,
	`user_id` bigint(20) DEFAULT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	PRIMARY KEY (`id`),
	KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;

CREATE TABLE `farm_products` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`farm_id` bigint(20) unsigned NOT NULL,
	`ingredient_id` bigint(20) unsigned NOT NULL,
	`start_date` date DEFAULT NULL,
	`end_date` date DEFAULT NULL,
	`price` varchar(32) DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `farm_id` (`farm_id`),
	KEY `ingredient_id` (`ingredient_id`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;

CREATE TABLE `farm_tags` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`farm_id` bigint(20) unsigned NOT NULL,
	`tag_id` bigint(20) unsigned NOT NULL,
	PRIMARY KEY(`id`),
	KEY `farm_id` (`farm_id`),
	KEY `tag_id` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;

CREATE TABLE `farm_images` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`farm_id` bigint(20) unsigned NOT NULL,
	`image_id` bigint(20) unsigned NOT NULL,
	PRIMARY KEY(`id`),
	KEY `farm_id` (`farm_id`),
	KEY `image_id` (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;

CREATE TABLE `market_farms` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`farm_id` bigint(20) unsigned NOT NULL,
	`market_id` bigint(20) unsigned NOT NULL,
	PRIMARY KEY(`id`),
	KEY `farm_id` (`farm_id`),
	KEY `market_id` (`market_id`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;

/***
 * Test data to be deleted later
 ***/

INSERT INTO `farms` (`name`, `description`, `website`, `email`, `phone`, `address`, `open_times`, `user_id`, `created`, `modified`)
VALUES ('Test Farm 1', 'A test farm to allow me to have data around which to build the site.', 'www.testfarm.com', 'bob@testfarm.com', '111-111-1111', '1 Test Farm ln, Bloomington, IN 47401', 'Mon - Fri, 8 am - 8 pm', NULL, NOW(), NOW()),
('Test Farm 2', 'Another test farm to allow me to build the site with data in place.', 'www.testfarm2.com', 'andy@testfarm2.com', '222-222-2222', '2 Test Farm ln, Bloomington, IN 47401', 'Mon - Fri, 8 am - 8 pm', NULL, NOW(), NOW()),
('Test Farm 3', 'A third test farm to allow me to build the site with data in place.', 'www.testfarm3.com', 'sam@testfarm3.com', '333-333-3333', '3 Test Farm ln, Bloomington, IN 47401', 'Mon - Fri, 8 am - 8 pm', NULL, NOW(), NOW());

INSERT INTO `farm_products` (`farm_id`, `ingredient_id`, `start_date`, `end_date`, `price`)
VALUES  (1, 899, '05-01', '09-01', ''),
(1, 901, '05-01', '09-01', ''),
(1, 764, '08-01', '11-01', ''),
(2, 763, '05-01', '10-01', ''),
(2, 752, '04-01', '06-01', ''),
(2, 651, '04-01', '06-01', ''),
(3, 650, '05-01', '09-01', ''),
(3, 621, '07-01', '11-01', ''),
(3, 601, '', '', '');


