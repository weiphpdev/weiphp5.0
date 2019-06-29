CREATE TABLE IF NOT EXISTS `wp_signin_log` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`score`  int(10) NOT NULL  COMMENT '积分',
`wpid`  int(10) NOT NULL  DEFAULT 0 COMMENT 'wpid',
`sTime`  int(10) unsigned NOT NULL  COMMENT '签到时间',
`uid`  varchar(255) NOT NULL  COMMENT '用户ID',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('SignIn_Log','签到记录','0','','1','{"1":["uid","score"]}','1:基础','','','','','uid:用户ID\r\nnickname:呢称\r\nsTime|time_format:签到时间\r\nscore:积分\r\n','10','uid','','1396061373','1404694493','1','MyISAM','sing_in');



