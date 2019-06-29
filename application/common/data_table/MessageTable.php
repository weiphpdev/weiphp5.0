<?php
/**
 * Message数据模型
 */
class MessageTable {
    // 数据表模型配置
    public $config = [
      'name' => 'message',
      'title' => '群发消息',
      'search_key' => '',
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
      'bind_keyword' => [
          'title' => '关联关键词',
          'field' => 'varchar(50) NULL',
          'type' => 'string'
      ],
      'preview_openids' => [
          'title' => '预览人OPENID',
          'field' => 'text NULL',
          'type' => 'string'
      ],
      'group_id' => [
          'title' => '群发对象',
          'field' => 'int(10) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'type' => [
          'title' => '素材来源',
          'field' => 'tinyint(2) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'media_id' => [
          'title' => '微信素材ID',
          'field' => 'varchar(100) NULL',
          'type' => 'string'
      ],
      'send_type' => [
          'title' => '发送方式',
          'field' => 'tinyint(1) NULL',
          'type' => 'string',
          'value' => 0
      ],
      'send_openids' => [
          'title' => '要发送的OpenID',
          'field' => 'text NULL',
          'type' => 'string'
      ],
      'msg_id' => [
          'title' => 'msg_id',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'content' => [
          'title' => '文本消息内容',
          'field' => 'text NULL',
          'type' => 'string'
      ],
      'msgtype' => [
          'title' => '消息类型',
          'field' => 'varchar(255) NULL',
          'type' => 'string'
      ],
      'appmsg_id' => [
          'title' => '图文id',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'voice_id' => [
          'title' => '语音id',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'video_id' => [
          'title' => '视频id',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'cTime' => [
          'title' => '群发时间',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ],
      'pbid' => [
          'title' => 'pbid',
          'field' => 'int(10) NOT NULL',
          'type' => 'string',
          'value' => 0
      ],
      'image_id' => [
          'title' => '图片ID',
          'field' => 'int(10) NULL',
          'type' => 'string'
      ]
  ];
}