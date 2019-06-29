<?php
/**
 * ShopRewardCondition数据模型
 */
class ShopRewardConditionTable {
    // 数据表模型配置
    public $config = [
      'name' => 'shop_reward_condition',
      'title' => '优惠条件',
      'search_key' => '',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 10,
      'addon' => 'shop'
  ];

    // 列表定义
    public $list_grid = [ ];

    // 字段定义
    public $fields = [
      'condition' => [
          'title' => '条件',
          'field' => 'decimal(11,2) NULL',
          'type' => 'string'
      ],
      'reward_id' => [
          'title' => '活动ID',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'money' => [
          'title' => '现在开关',
          'field' => 'decimal(10,2) NULL',
          'type' => 'string'
      ],
      'money_param' => [
          'title' => '现金参数',
          'field' => 'decimal(10,2) NULL',
          'type' => 'string'
      ],
      'postage' => [
          'title' => '免邮',
          'field' => 'tinyint(2) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'score' => [
          'title' => '积分开关',
          'field' => 'tinyint(2) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'score_param' => [
          'title' => '积分参数',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'coupon' => [
          'title' => '优惠券开关',
          'field' => 'tinyint(2) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'coupon_param' => [
          'title' => '优惠券ID',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'sort' => [
          'title' => '排序号',
          'field' => 'int(10) NULL',
          'type' => 'string',
          'value' => 0
      ]
  ];
}