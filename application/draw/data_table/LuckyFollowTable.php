<?php
/**
 * LuckyFollow数据模型
 */
class LuckyFollowTable {
    // 数据表模型配置
    public $config = [
      'name' => 'lucky_follow',
      'title' => '中奖者信息',
      'search_key' => 'award_name:输入奖品名称',
      'add_button' => 0,
      'del_button' => 0,
      'search_button' => 1,
      'check_all' => 0,
      'list_row' => 20,
      'addon' => 'draw'
  ];

    // 列表定义
    public $list_grid = [
      'draw_id' => [
          'title' => '活动名称'
      ],
      'follow_id' => [
          'title' => '微信昵称'
      ],
      'zjtime' => [
          'title' => '中奖时间'
      ],
      'award_id' => [
          'title' => '奖品'
      ],
      'state' => [
          'title' => '发奖状态'
      ],
      'urls' => [
          'title' => '操作',
          'come_from' => 1,
          'href' => [
              '0' => [
                  'title' => '发放奖品',
                  'url' => 'setState?id=[id]'
              ]
          ]
      ]
  ];

    // 字段定义
    public $fields = [
      'draw_id' => [
          'title' => '活动编号',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'is_show' => 1
      ],
      'sport_id' => [
          'title' => '场次编号',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'is_show' => 1
      ],
      'award_id' => [
          'title' => '奖品编号',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'is_show' => 1
      ],
      'follow_id' => [
          'title' => '粉丝id',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'is_show' => 1
      ],
      'address' => [
          'title' => '地址',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'num' => [
          'title' => '获奖数',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'is_show' => 1,
          'value' => 0
      ],
      'state' => [
          'title' => '兑奖状态',
          'type' => 'bool',
          'field' => 'tinyint(2) NULL',
          'extra' => '0:未兑奖
1:已兑奖
2:通过验证',
          'is_show' => 1,
          'value' => 0
      ],
      'zjtime' => [
          'title' => '中奖时间',
          'field' => 'int(10) NULL',
          'type' => 'datetime',
          'is_show' => 1
      ],
      'djtime' => [
          'title' => '兑奖时间',
          'field' => 'int(10) NULL',
          'type' => 'datetime',
          'is_show' => 1
      ],
      'remark' => [
          'title' => '备注',
          'field' => 'text NULL',
          'type' => 'textarea',
          'is_show' => 1
      ],
      'scan_code' => [
          'title' => '核销码',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'uid' => [
          'title' => 'uid',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'auto_rule' => 'get_mid',
          'auto_time' => 3,
          'auto_type' => 'function'
      ],
      'wpid' => [
          'title' => 'wpid',
          'field' => 'int(10) NOT NULL',
          'type' => 'string',
          'auto_rule' => 'get_wpid',
          'auto_time' => 3,
          'auto_type' => 'function',
          'value' => 0
      ],
      'aim_table' => [
          'title' => '活动标识',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'error_remark' => [
          'title' => '发放失败备注',
          'type' => 'textarea',
          'field' => 'text NULL'
      ],
      'send_aim_id' => [
          'title' => '发送奖品对应id',
          'type' => 'num',
          'field' => 'int(10) NULL',
          'value' => 0
      ]
  ];
}