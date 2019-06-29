<?php
/**
 * CreditData数据模型
 */
class CreditDataTable {
    // 数据表模型配置
    public $config = [
      'name' => 'credit_data',
      'title' => '用户积分记录',
      'search_key' => 'uid',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 20,
      'addon' => 'core'
  ];

    // 列表定义
    public $list_grid = [
      'uid' => [
          'title' => '用户名'
      ],
      'credit_title' => [
          'title' => '积分来源'
      ],
      'score' => [
          'title' => '积分'
      ],
      'cTime' => [
          'title' => '时间'
      ],
      'urls' => [
          'title' => '操作',
          'come_from' => 1,
          'href' => [
              '0' => [
                  'title' => '删除',
                  'url' => '[DELETE]'
              ]
          ]
      ]
  ];

    // 字段定义
    public $fields = [
      'uid' => [
          'title' => '用户ID',
          'field' => 'int(10) NOT NULL',
          'type' => 'num',
          'is_show' => 1,
          'value' => 0,
          'is_must' => 1
      ],
      'score' => [
          'title' => '积分值',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'is_show' => 1,
          'value' => 0
      ],
      'credit_name' => [
          'title' => '规则标识名',
          'field' => 'varchar(50) NOT NULL',
          'type' => 'string',
          'is_show' => 1,
          'is_must' => 1
      ],
      'cTime' => [
          'title' => '记录时间',
          'field' => 'int(10) NOT NULL',
          'type' => 'datetime',
          'auto_rule' => 'time',
          'auto_time' => 1,
          'auto_type' => 'function'
      ],
      'admin_uid' => [
          'title' => '操作者UID，0表示系统自动增加',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'value' => 0
      ],
      'wpid' => [
          'title' => 'wpid',
          'field' => 'int(10) NOT NULL',
          'type' => 'string',
          'auto_rule' => 'get_wpid',
          'auto_time' => 1,
          'auto_type' => 'function',
          'value' => 0
      ],
      'credit_title' => [
          'title' => '积分描述',
          'field' => 'varchar(100) NULL',
          'type' => 'string'
      ]
  ];
}