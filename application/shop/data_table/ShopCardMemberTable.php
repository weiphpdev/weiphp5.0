<?php
/**
 * ShopCardMember数据模型
 */
class ShopCardMemberTable {
    // 数据表模型配置
    public $config = [
      'name' => 'shop_card_member',
      'title' => '实体店会员卡',
      'search_key' => 'username:请输入姓名',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 10,
      'addon' => 'shop'
  ];

    // 列表定义
    public $list_grid = [
      'username' => [
          'title' => '姓名'
      ],
      'phone' => [
          'title' => '手机号'
      ],
      'sex' => [
          'title' => '性别'
      ],
      'birthday' => [
          'title' => '生日',
          'function' => 'time_format'
      ],
      'address' => [
          'title' => '地址'
      ],
      'score' => [
          'title' => '导入积分'
      ],
      'card_number' => [
          'title' => '绑定会员卡号'
      ],
      'ctime' => [
          'title' => '导入时间',
          'function' => 'time_format'
      ],
      'is_get' => [
          'title' => '是否领取'
      ],
      'urls' => [
          'title' => '操作',
          'come_from' => 1,
          'href' => [
              '0' => [
                  'title' => '改变领取状态',
                  'url' => 'changeGet&id=[id]&is_get=[is_get]'
              ]
          ]
      ]
  ];

    // 字段定义
    public $fields = [
      'username' => [
          'title' => '姓名',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'phone' => [
          'title' => '手机号',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'sex' => [
          'title' => '性别',
          'field' => 'varchar(10) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'birthday' => [
          'title' => '生日',
          'field' => 'int(10) NULL',
          'type' => 'date',
          'is_show' => 1
      ],
      'address' => [
          'title' => '地址',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'ctime' => [
          'title' => '导入时间',
          'field' => 'int(10) NULL',
          'type' => 'datetime',
          'is_show' => 1
      ],
      'is_get' => [
          'title' => '是否领取',
          'field' => 'tinyint(2) NULL',
          'type' => 'bool',
          'is_show' => 1,
          'extra' => '0:否
1:是',
          'value' => 1
      ],
      'wpid' => [
          'title' => 'wpid',
          'type' => 'num',
          'field' => 'int(10) NULL',
          'is_show' => 1,
          'auto_type' => 'function',
          'auto_rule' => 'get_wpid',
          'auto_time' => 3
      ],
      'shop_code' => [
          'title' => '地址编码',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'score' => [
          'title' => '积分余额',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'is_show' => 1
      ],
      'card_number' => [
          'title' => '会员卡号',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'is_show' => 1
      ]
  ];
}