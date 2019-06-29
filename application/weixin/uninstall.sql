DELETE FROM `wp_model` WHERE `name`='user_tag' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_user_tag`;


DELETE FROM `wp_model` WHERE `name`='user_tag_link' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_user_tag_link`;


DELETE FROM `wp_model` WHERE `name`='custom_menu' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_custom_menu`;


DELETE FROM `wp_model` WHERE `name`='auto_reply' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_auto_reply`;


DELETE FROM `wp_model` WHERE `name`='custom_reply_mult' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_custom_reply_mult`;


DELETE FROM `wp_model` WHERE `name`='custom_reply_news' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_custom_reply_news`;


DELETE FROM `wp_model` WHERE `name`='custom_reply_text' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_custom_reply_text`;


