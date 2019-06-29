<?php
/**
 * Comment数据模型
 */
class CommentTable {
    // 数据表模型配置
    public $config = [
      'name' => 'comment',
      'title' => '评论互动',
      'search_key' => 'content:请输入评论内容',
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
      'aim_table' => [
          'title' => '评论关联数据表',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'aim_id' => [
          'title' => '评论关联ID',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'cTime' => [
          'title' => '评论时间',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'follow_id' => [
          'title' => 'follow_id',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'content' => [
          'title' => '评论内容',
          'field' => 'text NULL',
          'type' => 'string'
      ],
      'is_audit' => [
          'title' => '是否审核',
          'field' => 'tinyint(2) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'uid' => [
          'title' => 'uid',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ]
  ];
}