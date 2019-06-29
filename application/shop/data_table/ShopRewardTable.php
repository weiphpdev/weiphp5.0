<?php
/**
 * ShopReward数据模型
 */
class ShopRewardTable {
    // 数据表模型配置
    public $config = [
      'name' => 'shop_reward',
      'title' => '促销活动',
      'search_key' => 'title:请输入活动名称搜索',
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
          'title' => '活动状态'
      ],
      'start_time' => [
          'title' => '有效期'
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
      'title' => [
          'title' => '活动名称',
          'field' => 'varchar(100) NULL',
          'type' => 'string'
      ],
      'start_time' => [
          'title' => '开始时间',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'end_time' => [
          'title' => '过期时间',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'is_mult' => [
          'title' => '多级优惠',
          'field' => 'tinyint(2) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'is_all_goods' => [
          'title' => '适用的活动商品',
          'field' => 'tinyint(2) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'goods_ids' => [
          'title' => '指定商品ID串',
          'field' => 'text NULL',
          'type' => 'string'
      ],
      'cTime' => [
          'title' => '创建时间',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'wpid' => [
          'title' => 'wpid',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'manager_id' => [
          'title' => '管理员ID',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ]
  ];
}