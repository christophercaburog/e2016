DROP TABLE IF EXISTS `pop`;
CREATE TABLE `pop` (
  `region` varchar(64) DEFAULT NULL,
  `province` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `municipal` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `brgy` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pollingplace` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `address` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `precinct` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `total` int(11) NOT NULL,
  `cluster` varchar(128) NOT NULL,
  `clusterprecinct` varchar(128) NOT NULL,
  `clustertotal` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
