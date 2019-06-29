<?php
/**
 * Manager数据模型
 */
class ManagerTable {
    // 数据表模型配置
    public $config = [
      'name' => 'manager',
      'title' => '公众号管理员配置',
      'search_key' => '',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 20,
      'addon' => 'core'
  ];

    // 列表定义
    public $list_grid = [ ];

    // 字段定义
    public $fields = [
      'uid' => [
          'title' => '用户ID',
          'field' => 'int(10) NOT NULL',
          'type' => 'string',
          'value' => 0
      ],
      'has_public' => [
          'title' => '是否配置公众号',
          'field' => 'tinyint(2) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'headface_url' => [
          'title' => '管理员头像',
          'field' => 'int(10) unsigned NULL',
          'type' => 'string'
      ],
      'GammaAppId' => [
          'title' => '摇电视的AppId',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'GammaSecret' => [
          'title' => '摇电视的Secret',
          'field' => 'varchar(100) NULL',
          'type' => 'string'
      ],
      'copy_right' => [
          'title' => '授权信息',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'tongji_code' => [
          'title' => '统计代码',
          'field' => 'text NULL',
          'type' => 'string'
      ],
      'website_logo' => [
          'title' => '网站LOGO',
          'field' => 'int(10) unsigned NULL',
          'type' => 'string'
      ]
  ];
}