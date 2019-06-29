<?php
/**
 * MaterialText数据模型
 */
class MaterialTextTable {
    // 数据表模型配置
    public $config = [
      'name' => 'material_text',
      'title' => '文本素材',
      'search_key' => 'content:请输入文本内容搜索',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 10,
      'addon' => 'core'
  ];

    // 列表定义
    public $list_grid = [
      'id' => [
          'title' => '编号',
          'width' => 10
      ],
      'content' => [
          'title' => '文本内容'
      ],
      'urls' => [
          'title' => '操作',
          'come_from' => 1,
          'href' => [
              '0' => [
                  'title' => '编辑',
                  'url' => 'text_edit?id=[id]'
              ],
              '1' => [
                  'title' => '删除',
                  'url' => 'text_del?id=[id]'
              ]
          ]
      ]
  ];

    // 字段定义
    public $fields = [
      'content' => [
          'title' => '文本内容',
          'type' => 'textarea',
          'field' => 'text NULL',
          'remark' => '可使用动态替换字符， {@nickname}代表粉丝昵称，{@openid}代表粉丝在公众号下的唯一标识openid',
          'is_show' => 1
      ],
      'pbid' => [
          'title' => 'pbid',
          'field' => 'int(10) NOT NULL',
          'type' => 'string',
          'auto_rule' => 'get_pbid',
          'auto_time' => 1,
          'auto_type' => 'function',
          'value' => 0
      ],
      'uid' => [
          'title' => 'uid',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'auto_rule' => 'get_mid',
          'auto_time' => 1,
          'auto_type' => 'function'
      ],
      'admin_uid' => [
          'title' => '操作员UID',
          'field' => 'int(11) NULL',
          'type' => 'user'
      ],
      'is_use' => [
          'title' => '可否使用',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'extra' => '0:不可用
1:可用',
          'value' => 1
      ],
      'aim_id' => [
          'title' => '添加来源标识id',
          'field' => 'int(10) NULL',
          'type' => 'num'
      ],
      'aim_table' => [
          'title' => '来源表名',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'pub_id' => [
          'title' => '共享素材ID，用于去重',
          'field' => 'int(11) NULL',
          'type' => 'string'
      ]
  ];
}