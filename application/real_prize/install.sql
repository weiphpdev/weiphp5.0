CREATE TABLE IF NOT EXISTS `wp_real_prize` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`prize_title`  varchar(255) NULL  COMMENT '活动标题',
`prize_name`  varchar(255) NULL  COMMENT '奖品名称',
`prize_conditions`  text NULL  COMMENT '活动说明',
`prize_count`  int(10) NULL  COMMENT '奖品个数',
`prize_image`  varchar(255) NULL  DEFAULT '上传奖品图片' COMMENT '奖品图片',
`prize_type`  tinyint(2) NULL  DEFAULT 1 COMMENT '奖品类型',
`use_content`  text NULL  COMMENT '使用说明',
`fail_content`  text NULL  COMMENT '领取失败提示',
`template`  varchar(255) NULL  DEFAULT 'default' COMMENT '素材模板',
`wpid`  int(10) NOT NULL  DEFAULT 0 COMMENT 'wpid',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('real_prize','实物奖励','0','','1','["prize_title","prize_name","prize_conditions","prize_count","prize_image","prize_type","use_content","fail_content","template"]','1:基础','','','','','prize_name:20%奖品名称\r\nprize_conditions:20%活动说明\r\nprize_count:10%奖品个数\r\nprize_type|get_name_by_status:10%奖品类型\r\nuse_content:20%使用说明\r\nid:20%操作:[EDIT]|编辑,[DELETE]|删除,address_lists?target_id=[id]|查看数据,preview?id=[id]&target=_blank|预览','20','','','1429515376','1437452269','1','MyISAM','real_prize');



CREATE TABLE IF NOT EXISTS `wp_prize_address` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`address`  varchar(255) NULL  COMMENT '奖品收货地址',
`mobile`  varchar(50) NULL  COMMENT '手机',
`turename`  varchar(255) NULL  COMMENT '收货人姓名',
`remark`  varchar(255) NULL  COMMENT '备注',
`uid`  int(10) NULL  COMMENT '用户id',
`prizeid`  int(10) NULL  COMMENT '奖品编号',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('prize_address','奖品收货地址','0','','1','["address","mobile","turename","remark"]','1:基础','','','','','prizeid:奖品名称\r\nturename:收货人\r\nmobile:联系方式\r\naddress:收货地址\r\nremark:备注\r\nids:操作:address_edit&id=[id]&_controller=RealPrize&_addons=RealPrize|编辑,[DELETE]|删除','20','','','1429521514','1447831599','1','MyISAM','real_prize');



