<?php
/**
 * AppCategory数据模型
 */
class AppCategoryTable {
    // 数据表模型配置
    public $config = [
      'name' => 'app_category',
      'title' => '插件分类',
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
    public $fields = [
      'icon' => [
          'title' => '分类图标',
          'field' => 'int(10) unsigned NULL',
          'type' => 'string'
      ],
      'title' => [
          'title' => '分类名',
          'field' => 'varchar(255) NULL',
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