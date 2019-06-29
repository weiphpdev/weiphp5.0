<?php
/**
 * ShopAttribute数据模型
 */
class ShopAttributeTable {
    // 数据表模型配置
    public $config = [
      'name' => 'shop_attribute',
      'title' => '分类属性',
      'search_key' => 'title',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 20,
      'addon' => 'shop'
  ];

    // 列表定义
    public $list_grid = [
      'title' => [
          'title' => '字段标题'
      ],
      'type' => [
          'title' => '字段类型'
      ],
      'extra' => [
          'title' => '参数'
      ],
      'sort' => [
          'title' => '排序'
      ],
      'urls' => [
          'title' => '操作',
          'come_from' => 1,
          'href' => [
              '0' => [
                  'title' => '编辑',
                  'url' => '[EDIT]&cate_id=[cate_id]'
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
          'title' => '字段标题',
          'field' => 'varchar(255) NOT NULL',
          'type' => 'string',
          'remark' => '请输入字段标题，用于表单显示',
          'is_show' => 1,
          'is_must' => 1
      ],
      'attr_type' => [
          'title' => '字段类型',
          'field' => 'char(50) NOT NULL',
          'type' => 'select',
          'remark' => '用于表单中的展示方式',
          'is_show' => 1,
          'extra' => 'string:单行输入|extra@hide
textarea:多行输入|extra@hide
radio:单选|extra@show
checkbox:多选|extra@show
select:下拉选择|extra@show
datetime:时间选择|extra@hide
picture:上传图片|extra@hide',
          'value' => 'string',
          'is_must' => 1
      ],
      'extra' => [
          'title' => '参数',
          'field' => 'text NULL',
          'type' => 'textarea',
          'remark' => '每行一个参数',
          'is_show' => 1
      ],
      'value' => [
          'title' => '默认值',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'remark' => '字段的默认值',
          'is_show' => 1
      ],
      'sort' => [
          'title' => '排序号',
          'field' => 'int(10) unsigned NULL',
          'type' => 'num',
          'remark' => '值越小越靠前',
          'is_show' => 1,
          'value' => 0
      ],
      'is_show' => [
          'title' => '是否显示',
          'field' => 'tinyint(2) NULL',
          'type' => 'select',
          'remark' => '是否显示在表单中',
          'extra' => '1:显示
0:不显示',
          'value' => 1
      ],
      'cate_id' => [
          'title' => '所属分类ID',
          'field' => 'int(10) unsigned NULL',
          'type' => 'num',
          'is_show' => 4
      ],
      'error_info' => [
          'title' => '出错提示',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'remark' => '验证不通过时的提示语'
      ],
      'validate_rule' => [
          'title' => '正则验证',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'remark' => '为空表示不作验证'
      ],
      'is_must' => [
          'title' => '是否必填',
          'field' => 'tinyint(2) NULL',
          'type' => 'bool',
          'remark' => '用于自动验证',
          'extra' => '0:否
1:是'
      ],
      'remark' => [
          'title' => '字段备注',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'remark' => '用于表单中的提示'
      ],
      'wpid' => [
          'title' => 'wpid',
          'type' => 'num',
          'field' => 'int(10) NULL',
          'auto_type' => 'function',
          'auto_rule' => 'get_wpid',
          'auto_time' => 1
      ],
      'mTime' => [
          'title' => '修改时间',
          'field' => 'int(10) NULL',
          'type' => 'datetime',
          'auto_rule' => 'time',
          'auto_time' => 3,
          'auto_type' => 'function'
      ],
      'type' => [
          'title' => '属性类型',
          'field' => 'tinyint(2) NULL',
          'type' => 'bool',
          'is_show' => 4,
          'extra' => '0:筛选属性
1:普通属性',
          'value' => 0
      ],
      'name' => [
          'title' => '属性标识',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'goods_field' => [
          'title' => '商品表中所占用的字段名',
          'field' => 'varchar(50) NULL',
          'type' => 'string'
      ]
  ];
}