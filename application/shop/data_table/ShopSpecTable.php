<?php
/**
 * ShopSpec数据模型
 */
class ShopSpecTable {
    // 数据表模型配置
    public $config = [
      'name' => 'shop_spec',
      'title' => '商品规格',
      'search_key' => 'title:请输入规格名称',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 10,
      'addon' => 'shop'
  ];

    // 列表定义
    public $list_grid = [
      'title' => [
          'title' => '规格名称'
      ],
      'remark' => [
          'title' => '规格属性'
      ],
      'urls' => [
          'title' => '操作',
          'come_from' => 1,
          'href' => [
              '0' => [
                  'title' => '编辑',
                  'url' => '[EDIT]'
              ],
              '1' => [
                  'title' => '删除',
                  'url' => '[DELETE]'
              ]
          ]
      ]
  ];

    // 字段定义
    public $fields = [
      'title' => [
          'title' => '规格名称',
          'field' => 'varchar(30) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'remark' => [
          'title' => '备注',
          'field' => 'varchar(100) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'spec_sort' => [
          'title' => '排序',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'remark' => '排序号越大排列越靠前',
          'is_show' => 1,
          'value' => 0
      ],
      'uid' => [
          'title' => '用户ID',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'auto_rule' => 'get_mid',
          'auto_time' => 1,
          'auto_type' => 'function'
      ],
      'wpid' => [
          'title' => 'wpid',
          'type' => 'num',
          'field' => 'int(10) NULL',
          'auto_type' => 'function',
          'auto_rule' => 'get_wpid',
          'auto_time' => 3
      ]
  ];
}