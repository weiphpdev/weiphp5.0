CREATE TABLE IF NOT EXISTS `wp_weisite_category` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`title`  varchar(100) NOT NULL  COMMENT '分类标题',
`icon`  int(10) unsigned NULL  COMMENT '分类图片',
`url`  varchar(255) NULL  COMMENT '外链',
`is_show`  tinyint(2) NULL  DEFAULT 1 COMMENT '显示',
`sort`  int(10) NULL  DEFAULT 0 COMMENT '排序号',
`pid`  int(10) NULL  DEFAULT 0 COMMENT '一级目录',
`wpid`  int(10) NOT NULL  DEFAULT 0 COMMENT 'wpid',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('weisite_category','微官网分类','0','','1','["title","icon","url","is_show","sort","pid"]','1:基础','','','','','title:15%分类标题\r\nicon|get_img_html:分类图片\r\nurl:30%外链\r\nsort:10%排序号\r\npid:10%一级目录\r\nis_show|get_name_by_status:10%显示\r\nid:10%操作:[EDIT]|编辑,[DELETE]|删除','20','title','','1395987942','1439522869','1','MyISAM','wei_site');



CREATE TABLE IF NOT EXISTS `wp_weisite_footer` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`pid`  tinyint(2) NULL  DEFAULT 0 COMMENT '一级菜单',
`title`  varchar(50) NOT NULL  COMMENT '菜单名',
`url`  varchar(255) NULL  COMMENT '关联URL',
`sort`  tinyint(4) NULL  DEFAULT 0 COMMENT '排序号',
`icon`  int(10) unsigned NULL  COMMENT '图标',
`wpid`  int(10) NOT NULL  DEFAULT 0 COMMENT 'wpid',
PRIMARY KEY (`id`),
KEY `token` (`pid`,sort)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('weisite_footer','底部导航','0','','1','["pid","title","url","sort","icon"]','1:基础','','','','','title:15%菜单名\r\nicon:10%图标\r\nurl:50%关联URL\r\nsort:8%排序号\r\nids:20%操作:[EDIT]|编辑,[DELETE]|删除','20','title','','1394518309','1464705675','1','MyISAM','wei_site');



CREATE TABLE IF NOT EXISTS `wp_weisite_cms` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`keyword`  varchar(100) NULL  COMMENT '关键词',
`keyword_type`  tinyint(2) NULL  COMMENT '关键词类型',
`title`  varchar(255) NOT NULL  COMMENT '标题',
`intro`  text NULL  COMMENT '简介',
`cate_id`  int(10) unsigned NULL  DEFAULT 0 COMMENT '所属类别',
`cover`  int(10) unsigned NULL  COMMENT '封面图片',
`content`  text NULL  COMMENT '内容',
`sort`  int(10) unsigned NULL  DEFAULT 0 COMMENT '排序号',
`cTime`  int(10) NULL  COMMENT '发布时间',
`view_count`  int(10) unsigned NULL  DEFAULT 0 COMMENT '浏览数',
`show_type`  varchar(100) NULL  DEFAULT 0 COMMENT '显示方式',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('weisite_cms','文章管理','0','','1','["keyword","keyword_type","title","intro","cate_id","cover","content","sort"]','1:基础','','','','','keyword:关键词\r\nkeyword_type|get_name_by_status:关键词类型\r\ntitle:标题\r\ncate_id:所属分类\r\nsort:排序号\r\nview_count:浏览数\r\nids:操作:[EDIT]&module_id=[pid]|编辑,[DELETE]|删除','20','title','','1396061373','1408326292','1','MyISAM','wei_site');



CREATE TABLE IF NOT EXISTS `wp_weisite_slideshow` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`title`  varchar(255) NULL  COMMENT '标题',
`img`  int(10) unsigned NOT NULL  COMMENT '图片',
`url`  varchar(255) NULL  COMMENT '链接地址',
`is_show`  tinyint(2) NULL  DEFAULT 1 COMMENT '是否显示',
`sort`  int(10) NULL  DEFAULT 0 COMMENT '排序',
`wpid`  int(10) NOT NULL  DEFAULT 0 COMMENT 'wpid',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('weisite_slideshow','幻灯片','0','','1','["title","img","url","is_show","sort"]','1:基础','','','','','title:标题\r\nimg:图片\r\nurl:链接地址\r\nis_show|get_name_by_status:显示\r\nsort:排序\r\nids:操作:[EDIT]&module_id=[pid]|编辑,[DELETE]|删除','20','title','','1396098264','1408323347','1','MyISAM','wei_site');



