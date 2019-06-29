<?php
/**
 * CheckinRule数据模型
 */
class CheckinRuleTable {
    // 数据表模型配置
    public $config = [
      'name' => 'checkin_rule',
      'title' => '签到规则',
      'search_key' => '',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 10,
      'addon' => 'core'
  ];

    // 列表定义
    public $list_grid = [ ];

    // 字段定义
    public $fields = [ ];
}