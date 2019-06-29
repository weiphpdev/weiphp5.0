<?php
/**
 * User数据模型
 */
class UserTable {
    // 数据表模型配置
    public $config = [
      'name' => 'user',
      'title' => '用户信息表',
      'search_key' => '',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 20,
      'addon' => 'core'
  ];

    // 列表定义
    public $list_grid = [
      'headimgurl' => [
          'title' => '头像',
          'function' => 'url_img_html',
          'raw' => 1
      ],
      'login_name' => [
          'title' => '登录账号'
      ],
      'login_password' => [
          'title' => '登录密码'
      ],
      'nickname' => [
          'title' => '用户昵称'
      ],
      'sex' => [
          'title' => '性别'
      ],
      'group' => [
          'title' => '分组'
      ],
      'score' => [
          'title' => '金币值'
      ],
      'urls' => [
          'title' => '操作',
          'come_from' => 1,
          'href' => [
              '0' => [
                  'title' => '设置登录账号',
                  'url' => 'set_login?uid=[uid]'
              ],
              '1' => [
                  'title' => '详细资料',
                  'url' => 'detail?uid=[uid]'
              ],
              '2' => [
                  'title' => '编辑',
                  'url' => '[EDIT]'
              ]
          ]
      ]
  ];

    // 字段定义
    public $fields = [
      'come_from' => [
          'title' => '来源',
          'field' => 'tinyint(1) NULL',
          'type' => 'select',
          'extra' => '0:PC注册用户
1:微信同步用户
2:手机注册用户',
          'value' => 0
      ],
      'nickname' => [
          'title' => '用户名',
          'field' => 'text NULL',
          'type' => 'string'
      ],
      'password' => [
          'title' => '登录密码',
          'field' => 'varchar(100) NULL',
          'type' => 'string'
      ],
      'truename' => [
          'title' => '真实姓名',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'mobile' => [
          'title' => '联系电话',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'email' => [
          'title' => '邮箱地址',
          'field' => 'varchar(100) NULL',
          'type' => 'string'
      ],
      'sex' => [
          'title' => '性别',
          'field' => 'tinyint(2) NULL',
          'type' => 'radio',
          'extra' => '0:保密
1:男
2:女'
      ],
      'headimgurl' => [
          'title' => '头像地址',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'city' => [
          'title' => '城市',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'province' => [
          'title' => '省份',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'country' => [
          'title' => '国家',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'language' => [
          'title' => '语言',
          'field' => 'varchar(20) NULL',
          'type' => 'string',
          'value' => 'zh-cn'
      ],
      'score' => [
          'title' => '积分值',
          'type' => 'num',
          'field' => 'float NULL',
          'value' => 0
      ],
      'unionid' => [
          'title' => '微信第三方ID',
          'field' => 'varchar(50) NULL',
          'type' => 'string'
      ],
      'login_count' => [
          'title' => '登录次数',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'value' => 0
      ],
      'reg_ip' => [
          'title' => '注册IP',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'reg_time' => [
          'title' => '注册时间',
          'field' => 'int(10) NULL',
          'type' => 'datetime'
      ],
      'last_login_ip' => [
          'title' => '最近登录IP',
          'field' => 'varchar(30) NULL',
          'type' => 'string'
      ],
      'last_login_time' => [
          'title' => '最近登录时间',
          'field' => 'int(10) NULL',
          'type' => 'datetime'
      ],
      'status' => [
          'title' => '状态',
          'field' => 'tinyint(2) NULL',
          'type' => 'bool',
          'extra' => '0:禁用
1:启用',
          'value' => 1
      ],
      'is_init' => [
          'title' => '初始化状态',
          'field' => 'tinyint(2) NULL',
          'type' => 'bool',
          'extra' => '0:未初始化
1:已初始化',
          'value' => 0
      ],
      'is_audit' => [
          'title' => '审核状态',
          'field' => 'tinyint(2) NULL',
          'type' => 'bool',
          'extra' => '0:未审核
1:已审核',
          'value' => 0
      ],
      'subscribe_time' => [
          'title' => '用户关注公众号时间',
          'field' => 'int(10) NULL',
          'type' => 'datetime'
      ],
      'remark' => [
          'title' => '微信用户备注',
          'field' => 'varchar(100) NULL',
          'type' => 'string'
      ],
      'groupid' => [
          'title' => '微信端的分组ID',
          'field' => 'int(10) NULL',
          'type' => 'num'
      ],
      'login_name' => [
          'title' => '登录账号',
          'field' => 'varchar(100) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'level' => [
          'title' => '-1:机器人0:粉丝1:超级管理员2:A级管理员
3:B级管理员
4:C级管理员',
          'field' => 'tinyint(2) NULL',
          'type' => 'num',
          'value' => 0
      ],
      'login_password' => [
          'title' => '登录密码',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'manager_id' => [
          'title' => '公众号管理员ID',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'value' => 0
      ],
      'membership' => [
          'title' => '会员等级',
          'field' => 'char(50) NULL',
          'type' => 'select',
          'remark' => '请在会员等级 添加会员级别名称',
          'value' => 0
      ],
      'bind_openid' => [
          'title' => '绑定的openid',
          'field' => 'varchar(50) NULL',
          'type' => 'string'
      ],
      'audit_time' => [
          'title' => '审核时间',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'remark' => '审核通过时间'
      ],
      'grade' => [
          'title' => '当前用户的等级',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'value' => 0
      ],
      'tagid_list' => [
          'title' => '用户被打上的标签ID列表',
          'type' => 'string',
          'field' => 'varchar(555) NULL'
      ],
      'in_blacklist' => [
          'title' => '是否拉黑',
          'type' => 'bool',
          'field' => 'tinyint(2) NULL',
          'extra' => '0:未拉黑
1:拉黑',
          'value' => 0
      ],
      'wpid' => [
          'title' => 'wpid',
          'field' => 'int(11) NULL',
          'type' => 'string',
          'value' => 0
      ]
  ];
}