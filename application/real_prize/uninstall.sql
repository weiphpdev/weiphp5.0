DELETE FROM `wp_model` WHERE `name`='real_prize' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_real_prize`;


DELETE FROM `wp_model` WHERE `name`='prize_address' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_prize_address`;


