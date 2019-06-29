<?php
/**
 * PublicGroup数据模型
 */
class PublicGroupTable {
    // 数据表模型配置
    public $config = [
      'name' => 'public_group',
      'title' => '公众号等级',
      'search_key' => 'title',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 20,
      'addon' => 'core'
  ];

    // 列表定义
    public $list_grid = [ ];

    // 字段定义
    public $fields = [ ];
}