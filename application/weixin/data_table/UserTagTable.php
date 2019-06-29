<?php
/**
 * UserTag数据模型
 */
class UserTagTable {
    // 数据表模型配置
    public $config = [
      'name' => 'user_tag',
      'title' => '用户标签',
      'search_key' => 'title:请输入标签名称搜索',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 10,
      'addon' => 'weixin'
  ];

    // 列表定义
    public $list_grid = [ ];

    // 字段定义
    public $fields = [
      'title' => [
          'title' => '标签名称',
          'field' => 'varchar(50) NOT NULL',
          'type' => 'string'
      ],
      'mTime' => [
          'title' => '更新时间',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'rule' => [
          'title' => '所拥有的权限ID，多个用英文逗号隔开',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'type' => [
          'title' => '标签（角色）类型，0 粉丝角色 1 运营人员角色',
          'field' => 'tinyint(1) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'wid' => [
          'title' => '微信标签id',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'wtype' => [
          'title' => '公众号类型0.1.2.3',
          'field' => 'char(1) NULL',
          'type' => 'string'
      ],
      'pbid' => [
          'title' => '公众号id',
          'field' => 'int(10) NOT NULL',
          'type' => 'string',
          'value' => 0
      ]
  ];
}