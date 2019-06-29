<?php
/**
 * Stores数据模型
 */
class StoresTable {
    // 数据表模型配置
    public $config = [
      'name' => 'stores',
      'title' => '门店',
      'search_key' => 'name:店名搜索',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 20,
      'addon' => 'shop'
  ];

    // 列表定义
    public $list_grid = [
      'name' => [
          'title' => '店名'
      ],
      'img_url' => [
          'title' => '门店图片'
      ],
      'shop_code' => [
          'title' => '门店编码'
      ],
      'phone' => [
          'title' => '联系电话'
      ],
      'address' => [
          'title' => '详细地址'
      ],
      'urls' => [
          'title' => '操作',
          'come_from' => 1,
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
      'name' => [
          'title' => '店名',
          'field' => 'varchar(100) NULL',
          'type' => 'string'
      ],
      'address' => [
          'title' => '详细地址',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'phone' => [
          'title' => '联系电话',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'gps' => [
          'title' => 'GPS经纬度',
          'field' => 'varchar(50) NULL',
          'type' => 'string'
      ],
      'coupon_id' => [
          'title' => '所属优惠券编号',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'wpid' => [
          'title' => 'token',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'open_time' => [
          'title' => '营业时间',
          'field' => 'varchar(50) NULL',
          'type' => 'string'
      ],
      'img' => [
          'title' => '门店展示图',
          'field' => 'int(10) unsigned NULL',
          'type' => 'string'
      ],
      'auth_group' => [
          'title' => '门店用户组',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'shop_code' => [
          'title' => '地点编码',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'password' => [
          'title' => '确认收款密码',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'img_url' => [
          'title' => 'erp门店图片链接',
          'type' => 'string',
          'field' => 'varchar(255) NULL'
      ]
  ];
}