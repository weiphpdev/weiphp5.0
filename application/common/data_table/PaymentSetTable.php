<?php
/**
 * PaymentSet数据模型
 */
class PaymentSetTable {
    // 数据表模型配置
    public $config = [
      'name' => 'payment_set',
      'title' => '支付配置',
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
      'ctime' => [
          'title' => '创建时间',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'wxappid' => [
          'title' => 'AppID',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'wxpaysignkey' => [
          'title' => '支付密钥',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'wxappsecret' => [
          'title' => 'AppSecret',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'zfbname' => [
          'title' => '帐号',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'pid' => [
          'title' => 'PID',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'key' => [
          'title' => 'KEY',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'partnerid' => [
          'title' => '财付通标识',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'partnerkey' => [
          'title' => '财付通Key',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'wappartnerid' => [
          'title' => '财付通标识WAP',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'wappartnerkey' => [
          'title' => 'WAP财付通Key',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'wxpartnerkey' => [
          'title' => '微信partnerkey',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'wxpartnerid' => [
          'title' => '微信partnerid',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'quick_security_key' => [
          'title' => '银联在线Key',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'quick_merid' => [
          'title' => '银联在线merid',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'quick_merabbr' => [
          'title' => '商户名称',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'wpid' => [
          'title' => '商店ID',
          'field' => 'int(10) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'wxmchid' => [
          'title' => '微信支付商户号',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'wx_cert_pem' => [
          'title' => '上传证书',
          'field' => 'int(10) unsigned NULL',
          'type' => 'string'
      ],
      'wx_key_pem' => [
          'title' => '上传密匙',
          'field' => 'int(10) unsigned NULL',
          'type' => 'string'
      ],
      'shop_pay_score' => [
          'title' => '支付返积分',
          'field' => 'int(10) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'deposit' => [
          'title' => '支付定金百分比',
          'field' => 'int(10) NULL',
          'type' => 'string',
          'value' => 10
      ]
  ];
}