<?php
/**
 * SignIn数据模型
 */
class SignInTable {
    // 数据表模型配置
    public $config = [
      'name' => 'sign_in',
      'title' => '签到活动',
      'search_key' => '',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 10,
      'addon' => ''
  ];

    // 列表定义
    public $list_grid = [ ];

    // 字段定义
    public $fields = [ ];
}