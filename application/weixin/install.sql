CREATE TABLE IF NOT EXISTS `wp_user_tag` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`title`  varchar(50) NOT NULL  COMMENT '标签名称',
`mTime`  int(10) NULL  COMMENT '更新时间',
`rule`  varchar(255) NULL  COMMENT '所拥有的权限ID，多个用英文逗号隔开',
`type`  tinyint(1) NULL  DEFAULT 0 COMMENT '标签（角色）类型，0 粉丝角色 1 运营人员角色',
`wid`  int(10) NULL  COMMENT '微信标签id',
`wtype`  char(1) NULL  COMMENT '公众号类型0.1.2.3',
`pbid`  int(10) NOT NULL  DEFAULT 0 COMMENT '公众号id',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('user_tag','用户标签','0','','1','["title"]','1:基础','','','','','id:标签编号\r\ntitle:标签名称\r\nids:操作:[EDIT]|编辑,[DELETE]|删除','10','title:请输入标签名称搜索','','1463990100','1463993574','1','MyISAM','weixin');



CREATE TABLE IF NOT EXISTS `wp_user_tag_link` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`uid`  int(10) NOT NULL  COMMENT 'uid',
`tag_id`  int(10) NOT NULL  COMMENT 'tag_id',
`cTime`  int(10) NOT NULL  COMMENT '记录时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('user_tag_link','用户标签关系表','0','','1','','1:基础','','','','','','10','','','1463992911','1463992911','1','MyISAM','weixin');



CREATE TABLE IF NOT EXISTS `wp_custom_menu` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`pid`  int(10) NULL  DEFAULT 0 COMMENT '一级菜单',
`title`  varchar(50) NOT NULL  COMMENT '菜单名',
`type`  varchar(30) NOT NULL  DEFAULT 'click' COMMENT '内容类型：
text:素材文本
img:素材图片
news:素材图文
video:素材视频
voice：素材语音
url:URL地址
click：点击推事件
scancode_push：扫码推事件 
scancode_waitmsg：扫码带提示
pic_sysphoto：弹出系统拍照发图  
pic_photo_or_album： 弹出拍照或者相册发图  
pic_weixin：弹出微信相册发图器  
location_select：弹出地理位置选择器',
`keyword`  varchar(100) NULL  COMMENT '关键词',
`url`  varchar(255) NULL  COMMENT 'URL',
`sort`  tinyint(4) NULL  DEFAULT 0 COMMENT '排序号',
`pbid`  int(10) NULL  COMMENT '公众号id',
`from`  char(50) NOT NULL  DEFAULT 0 COMMENT '来源 0一级菜单，1素材 2URL 3自定义',
`rule_id`  int(11) NULL  DEFAULT 0 COMMENT '个性化菜单ID，0表示默认菜单',
`material`  varchar(50) NULL  COMMENT 'material',
`appid`  varchar(50) NULL  COMMENT 'appid',
`pagepath`  varchar(100) NULL  COMMENT 'pagepath',
`appurl`  varchar(255) NULL  COMMENT 'appurl',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('custom_menu','自定义菜单','0','','1','["pid","title","from_type","type","jump_type","addon","sucai_type","keyword","url","sort"]','1:基础','','','','','title:10%菜单名\r\nkeyword:10%关联关键词\r\nurl:50%关联URL\r\nsort:5%排序号\r\nid:10%操作:[EDIT]|编辑,[DELETE]|删除','20','title','','1394518309','1446533816','1','MyISAM','weixin');



CREATE TABLE IF NOT EXISTS `wp_auto_reply` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`img_id`  int(10) unsigned NULL  COMMENT '上传图片',
`news_id`  int(10) NULL  COMMENT '图文',
`keyword`  varchar(255) NULL  COMMENT '关键词',
`video_id`  int(10) NULL  COMMENT '视频素材id',
`voice_id`  int(10) NULL  COMMENT '语音素材id',
`image_material`  int(10) NULL  COMMENT '素材图片id',
`pbid`  varchar(50) NULL  COMMENT '公众号id',
`manager_id`  int(10) NULL  COMMENT '管理员ID',
`msg_type`  char(50) NULL  DEFAULT 'text' COMMENT '消息类型',
`text_id`  int(10) NULL  COMMENT '文本素材id',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('auto_reply','自动回复','0','','1','["img_id","group_id","content","keyword"]','1:基础','','','','','keyword:关键词\r\ntext_id:文本\r\ngroup_id:图文\r\nimg_id:图片\r\nvoice_id:语音\r\nvideo_id:视频\r\nids:操作:[EDIT]&type=[msg_type]|编辑,[DELETE]|删除','10','','','0','0','0','MyISAM','weixin');



CREATE TABLE IF NOT EXISTS `wp_custom_reply_mult` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`keyword`  varchar(255) NULL  COMMENT '关键词',
`keyword_type`  tinyint(2) NULL  DEFAULT 0 COMMENT '关键词类型',
`mult_ids`  varchar(255) NULL  COMMENT '多图文ID',
`wpid`  int(10) NOT NULL  DEFAULT 0 COMMENT 'wpid',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('custom_reply_mult','多图文配置','0','','1','','1:基础','','','','','','20','','','1396602475','1396602475','1','MyISAM','weixin');



CREATE TABLE IF NOT EXISTS `wp_custom_reply_news` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`keyword`  varchar(100) NULL  COMMENT '关键词',
`keyword_type`  tinyint(2) NULL  COMMENT '关键词类型',
`title`  varchar(255) NOT NULL  COMMENT '标题',
`intro`  text NULL  COMMENT '简介',
`cate_id`  int(10) unsigned NULL  DEFAULT 0 COMMENT '所属类别',
`cover`  int(10) unsigned NULL  COMMENT '封面图片',
`content`  text NULL  COMMENT '内容',
`sort`  int(10) unsigned NULL  DEFAULT 0 COMMENT '排序号',
`jump_url`  varchar(255) NULL  COMMENT '外链',
`author`  varchar(50) NULL  COMMENT '作者',
`cTime`  int(10) NULL  COMMENT '发布时间',
`view_count`  int(10) unsigned NULL  DEFAULT 0 COMMENT '浏览数',
`wpid`  int(10) NOT NULL  DEFAULT 0 COMMENT 'wpid',
`show_type`  varchar(100) NULL  DEFAULT 0 COMMENT '显示方式',
`is_show`  char(10) NULL  DEFAULT 1 COMMENT '图片是否显示在内容页',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('custom_reply_news','图文回复','0','','1','["keyword","keyword_type","title","intro","cate_id","cover","content","sort","jump_url","author"]','1:基础','','','','','id:5%ID\r\nkeyword:10%关键词\r\nkeyword_type|get_name_by_status:20%关键词类型\r\ntitle:30%标题\r\ncate_id:10%所属分类\r\nsort:7%排序号\r\nview_count:8%浏览数\r\nids:10%操作:[EDIT]|编辑,[DELETE]|删除','20','title','','1396061373','1466505161','1','MyISAM','weixin');



CREATE TABLE IF NOT EXISTS `wp_custom_reply_text` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`keyword`  varchar(255) NULL  COMMENT '关键词',
`keyword_type`  tinyint(2) NULL  DEFAULT 0 COMMENT '关键词类型',
`content`  text NULL  COMMENT '回复内容',
`view_count`  int(10) unsigned NULL  DEFAULT 0 COMMENT '浏览数',
`sort`  int(10) unsigned NULL  DEFAULT 0 COMMENT '排序号',
`wpid`  int(10) NOT NULL  DEFAULT 0 COMMENT 'wpid',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`,`addon`) VALUES ('custom_reply_text','文本回复','0','','1','["keyword","keyword_type","content","sort"]','1:基础','','','','','id:ID\r\nkeyword:关键词\r\nkeyword_type|get_name_by_status:关键词类型\r\nsort:排序号\r\nview_count:浏览数\r\nids:操作:[EDIT]|编辑,[DELETE]|删除','20','keyword','','1396578172','1401017369','1','MyISAM','weixin');



