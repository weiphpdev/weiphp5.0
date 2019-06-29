<?php
/**
 * ShopPage数据模型
 */
class ShopPageTable {
    // 数据表模型配置
    public $config = [
      'name' => 'shop_page',
      'title' => '自定义页面',
      'search_key' => '',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 10,
      'addon' => 'shop'
  ];

    // 列表定义
    public $list_grid = [
      'title' => [
          'title' => '页面标题',
          'width' => 25
      ],
      'ctime' => [
          'title' => '创建时间',
          'function' => 'time_format',
          'width' => 25
      ],
      'urls' => [
          'title' => '操作',
          'come_from' => 1,
          'href' => [
              '0' => [
                  'title' => '预览',
                  'url' => 'preview?id=[id]&target=_blank'
              ],
              '1' => [
                  'title' => '编辑',
                  'url' => '[EDIT]'
              ],
              '2' => [
                  'title' => '删除',
                  'url' => '[DELETE]'
              ]
          ],
          'width' => 25
      ],
      'copy' => [
          'title' => '复制链接',
          'raw' => 1,
          'width' => 10
      ]
  ];

    // 字段定义
    public $fields = [
      'title' => [
          'title' => '页面名称',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'ctime' => [
          'title' => '创建时间',
          'field' => 'int(15) NULL',
          'type' => 'datetime',
          'is_show' => 1,
          'auto_rule' => 'time',
          'auto_time' => 1,
          'auto_type' => 'function'
      ],
      'config' => [
          'title' => '配置参数',
          'field' => 'text NULL',
          'type' => 'textarea',
          'is_show' => 1
      ],
      'desc' => [
          'title' => '描述',
          'field' => 'text NULL',
          'type' => 'textarea',
          'is_show' => 1
      ],
      'wpid' => [
          'title' => 'wpid',
          'type' => 'num',
          'field' => 'int(10) NULL',
          'is_show' => 1,
          'auto_type' => 'function',
          'auto_rule' => 'get_wpid',
          'auto_time' => 1
      ],
      'manager_id' => [
          'title' => '创建者ID',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'is_show' => 1,
          'auto_rule' => 'get_mid',
          'auto_time' => 1,
          'auto_type' => 'function'
      ],
      'use' => [
          'title' => '哪里使用',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'is_show' => 1,
          'value' => 'page'
      ],
      'is_show' => [
          'title' => '是否显示底部导航',
          'field' => 'tinyint(2) NULL',
          'type' => 'radio',
          'is_show' => 1,
          'extra' => '0:不显示
1:显示',
          'value' => 0
      ],
      'is_index' => [
          'title' => '设为首页',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'is_show' => 1,
          'extra' => '0:否
1:是',
          'value' => 0
      ]
  ];
}