<?php
/**
 * ShopCashoutLog数据模型
 */
class ShopCashoutLogTable {
    // 数据表模型配置
    public $config = [
      'name' => 'shop_cashout_log',
      'title' => '提现记录表',
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
      'ctime' => [
          'title' => '申请日期',
          'function' => 'time_format'
      ],
      'cashout_amount' => [
          'title' => '申请金额（¥）'
      ],
      'type' => [
          'title' => '提现方式'
      ],
      'cashout_account' => [
          'title' => '提现账号'
      ],
      'name' => [
          'title' => '账号名称'
      ],
      'cashout_status' => [
          'title' => '审核状态'
      ],
      'remark' => [
          'title' => '详细'
      ]
  ];

    // 字段定义
    public $fields = [
      'cashout_amount' => [
          'title' => '提现金额',
          'field' => 'float NULL',
          'type' => 'num',
          'is_show' => 1
      ],
      'remark' => [
          'title' => '备注',
          'field' => 'text NULL',
          'type' => 'textarea',
          'is_show' => 1
      ],
      'cashout_status' => [
          'title' => '提现处理状态',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'is_show' => 1,
          'extra' => '0:处理中
1:提现成功
2:提现失败',
          'value' => 0
      ],
      'ctime' => [
          'title' => '提现时间',
          'field' => 'int(10) NULL',
          'type' => 'datetime',
          'is_show' => 1
      ],
      'wpid' => [
          'title' => 'wpid',
          'type' => 'num',
          'field' => 'int(10) NULL',
          'is_show' => 1,
          'auto_type' => 'function',
          'auto_rule' => 'get_mid',
          'auto_time' => 3
      ],
      'cashout_account' => [
          'title' => '提现账号',
          'field' => 'varchar(300) NULL',
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
      ]
  ];
}