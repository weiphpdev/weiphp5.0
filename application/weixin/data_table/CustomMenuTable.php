<?php
/**
 * CustomMenu数据模型
 */
class CustomMenuTable {
    // 数据表模型配置
    public $config = [
      'name' => 'custom_menu',
      'title' => '自定义菜单',
      'search_key' => 'title',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 20,
      'addon' => 'weixin'
  ];

    // 列表定义
    public $list_grid = [
      'title' => [
          'title' => '菜单名',
          'width' => '10%'
      ],
      'keyword' => [
          'title' => '关联关键词',
          'width' => '10%'
      ],
      'url' => [
          'title' => '关联URL',
          'width' => '10%'
      ],
      'sort' => [
          'title' => '排序号',
          'width' => '5%'
      ],
      'urls' => [
          'title' => '操作',
          'come_from' => 1,
          'width' => '10%',
          'href' => [
              '0' => [
                  'title' => '编辑',
                  'url' => '[EDIT]'
              ],
              '1' => [
                  'title' => '删除',
                  'url' => '[DELETE]'
              ]
          ]
      ]
  ];

    // 字段定义
    public $fields = [
      'pid' => [
          'title' => '一级菜单',
          'field' => 'int(10) NULL',
          'type' => 'select',
          'remark' => '如果是一级菜单，选择“无”即可',
          'is_show' => 1,
          'extra' => '0:无',
          'value' => 0
      ],
      'title' => [
          'title' => '菜单名',
          'field' => 'varchar(50) NOT NULL',
          'type' => 'string',
          'remark' => '可创建最多 3 个一级菜单，每个一级菜单下可创建最多 5 个二级菜单。编辑中的菜单不会马上被用户看到，请放心调试。',
          'is_show' => 1,
          'is_must' => 1
      ],
      'type' => [
          'title' => '内容类型：
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
          'field' => 'varchar(30) NOT NULL',
          'type' => 'bool',
          'is_show' => 1,
          'extra' => 'click:点击推事件|keyword@show,url@hide
scancode_push:扫码推事件|keyword@show,url@hide
scancode_waitmsg:扫码带提示|keyword@show,url@hide
pic_sysphoto:弹出系统拍照发图|keyword@show,url@hide
pic_photo_or_album:弹出拍照或者相册发图|keyword@show,url@hide
pic_weixin:弹出微信相册发图器|keyword@show,url@hide
location_select:弹出地理位置选择器|keyword@show,url@hide
none:无事件的一级菜单|keyword@hide,url@hide',
          'value' => 'click',
          'is_must' => 1
      ],
      'keyword' => [
          'title' => '关键词',
          'field' => 'varchar(100) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'url' => [
          'title' => 'URL',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'sort' => [
          'title' => '排序号',
          'field' => 'tinyint(4) NULL',
          'type' => 'num',
          'remark' => '数值越小越靠前',
          'is_show' => 1,
          'value' => 0
      ],
      'pbid' => [
          'title' => '公众号id',
          'type' => 'string',
          'field' => 'int(10) NULL',
          'auto_type' => 'function',
          'auto_rule' => 'get_wpid',
          'auto_time' => 1
      ],
      'from' => [
          'title' => '来源 0一级菜单，1素材 2URL 3自定义',
          'field' => 'char(50) NOT NULL',
          'type' => 'string',
          'value' => 0
      ],
      'rule_id' => [
          'title' => '个性化菜单ID，0表示默认菜单',
          'field' => 'int(11) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'material' => [
          'title' => 'material',
          'field' => 'varchar(50) NULL',
          'type' => 'string'
      ],
      'appid' => [
          'title' => 'appid',
          'field' => 'varchar(50) NULL',
          'type' => 'string'
      ],
      'pagepath' => [
          'title' => 'pagepath',
          'field' => 'varchar(100) NULL',
          'type' => 'string'
      ],
      'appurl' => [
          'title' => 'appurl',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ]
  ];
}