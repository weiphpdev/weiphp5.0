<?php
/**
 * StoresUser数据模型
 */
class StoresUserTable {
    // 数据表模型配置
    public $config = [
      'name' => 'stores_user',
      'title' => '用户默认选择的门店ID',
      'search_key' => '',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 20,
      'addon' => 'shop'
  ];

    // 列表定义
    public $list_grid = [ ];

    // 字段定义
    public $fields = [
      'wpid' => [
          'title' => 'wpid',
          'type' => 'num',
          'field' => 'int(10) NULL',
          'is_show' => 1
      ],
      'uid' => [
          'title' => 'uid',
          'type' => 'num',
          'field' => 'int(10) NULL',
          'is_show' => 1
      ],
      'store_id' => [
          'title' => 'store_id',
          'type' => 'num',
          'field' => 'int(10) NULL',
          'is_show' => 1
      ]
  ];
}