<?php
/**
 * VisitLog数据模型
 */
class VisitLogTable {
    // 数据表模型配置
    public $config = [
      'name' => 'visit_log',
      'title' => '网站访问日志',
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
    public $fields = [
      'wpid' => [
          'title' => 'publicid',
          'field' => 'int(10) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'module_name' => [
          'title' => 'module_name',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'controller_name' => [
          'title' => 'controller_name',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'action_name' => [
          'title' => 'action_name',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'uid' => [
          'title' => 'uid',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'ip' => [
          'title' => 'ip',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'brower' => [
          'title' => 'brower',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'param' => [
          'title' => 'param',
          'field' => 'text NULL',
          'type' => 'string'
      ],
      'referer' => [
          'title' => 'referer',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'cTime' => [
          'title' => '时间',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ]
  ];
}