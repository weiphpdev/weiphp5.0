<?php
/**
 * ShopGoods数据模型
 */
class ShopGoodsTable {
    // 数据表模型配置
    public $config = [
      'name' => 'shop_goods',
      'title' => '商品列表',
      'search_key' => 'title:请输入商品名称',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 20,
      'addon' => 'shop'
  ];

    // 列表定义
    public $list_grid = [
      'cover' => [
          'title' => '封面图',
          'raw' => 1
      ],
      'title' => [
          'title' => '商品名称'
      ],
      'market_price' => [
          'title' => '价格'
      ],
      'stock_active' => [
          'title' => '可用库存量'
      ],
      'sale_count' => [
          'title' => '销售量'
      ],
      'is_show' => [
          'title' => '是否上架'
      ],
      'is_recommend' => [
          'title' => '是否推荐'
      ],
      'urls' => [
          'title' => '操作',
          'come_from' => 1,
          'href' => [
              '0' => [
                  'title' => '商品详情',
                  'url' => 'DiyPage/add?id=[id]&use=goodsDetail'
              ],
              '1' => [
                  'title' => '编辑',
                  'url' => '[EDIT]'
              ],
              '2' => [
                  'title' => '删除',
                  'url' => '[DELETE]'
              ],
              '3' => [
                  'title' => '评论列表',
                  'url' => 'goodsCommentLists?goods_id=[id]&target=_blank'
              ],
              '4' => [
                  'title' => '复制链接',
                  'url' => '[WAP_URL]#/goods_detail/[id]'
              ],
              '5' => [
                  'title' => 'is_show:0|上架,1|下架,2|上架',
                  'url' => 'set_show?id=[id]&is_show=[is_show]',
                  'class' => 'ajax-get'
              ]
          ]
      ]
  ];

    // 字段定义
    public $fields = [
      'title' => [
          'title' => '商品名称',
          'field' => 'varchar(255) NOT NULL',
          'type' => 'string',
          'is_show' => 1,
          'is_must' => 1
      ],
      'category_id' => [
          'title' => '商品分类',
          'field' => 'char(50) NULL',
          'type' => 'cascade',
          'is_show' => 1,
          'extra' => 'type=db&table=shop_goods_category'
      ],
      'imgs' => [
          'title' => '商品图片',
          'field' => 'varchar(255) NULL',
          'type' => 'mult_picture',
          'remark' => '可以上传多个图片,拖曳改变顺序，第一张为商品封面图，建议上传500*500正方形图片',
          'is_show' => 1
      ],
      'cover' => [
          'title' => '商品封面图',
          'field' => 'int(10) unsigned NULL',
          'type' => 'picture',
          'is_show' => 1
      ],
      'is_recommend' => [
          'title' => '是否推荐',
          'field' => 'tinyint(2) NULL',
          'type' => 'bool',
          'remark' => '推荐后首页的推荐商品里显示',
          'is_show' => 1,
          'extra' => '0:否
1:是',
          'value' => 0
      ],
      'auto_send' => [
          'title' => '自动发货',
          'field' => 'char(10) NULL',
          'type' => 'radio',
          'remark' => '自动发货在用户下单成功时会自动发送虚拟物品的信息',
          'is_show' => 1,
          'extra' => '0:人工发货|inventory@show,virtual_textarea@hide
1:自动发货|inventory@hide,virtual_textarea@show',
          'value' => 0
      ],
      'virtual_textarea' => [
          'title' => '虚拟物品信息',
          'field' => 'text NULL',
          'type' => 'textarea',
          'remark' => '每行一条信息 卡密用“|”号分开，如：weiphp@weiphp.cn|123456  ',
          'is_show' => 1
      ],
      'is_show' => [
          'title' => '是否上架',
          'field' => 'tinyint(2) NULL',
          'type' => 'bool',
          'is_show' => 1,
          'extra' => '0:下架
1:上架
2:待上架',
          'value' => 0
      ],
      'cost_price' => [
          'title' => '成本价',
          'field' => 'decimal(10,2) NULL',
          'type' => 'num',
          'is_show' => 1,
          'value' => 0.00
      ],
      'weight' => [
          'title' => '重量',
          'field' => 'float NULL',
          'type' => 'num',
          'remark' => '单位为g',
          'is_show' => 1
      ],
      'sn_code' => [
          'title' => '商品编号',
          'field' => 'text NULL',
          'type' => 'textarea',
          'is_show' => 1
      ],
      'is_delete' => [
          'title' => '是否删除',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'is_show' => 1,
          'value' => 0
      ],
      'is_new' => [
          'title' => '新品类型',
          'field' => 'varchar(100) NULL',
          'type' => 'checkbox',
          'is_show' => 1,
          'extra' => '1:新品
2:热销
3:优惠'
      ],
      'rank' => [
          'title' => '热销度',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'remark' => '热销度由发布时间、推荐状态、销量三个维度进行计算得到',
          'value' => 0
      ],
      'show_time' => [
          'title' => '上架时间',
          'field' => 'int(10) NULL',
          'type' => 'datetime',
          'auto_rule' => 'time',
          'auto_time' => 3,
          'auto_type' => 'function',
          'value' => 0
      ],
      'wpid' => [
          'title' => 'wpid',
          'type' => 'num',
          'field' => 'int(10) NULL',
          'auto_type' => 'function',
          'auto_rule' => 'get_wpid',
          'auto_time' => 3
      ],
      'diy_id' => [
          'title' => '详情页面DidId',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'value' => 0
      ],
      'reduce_score' => [
          'title' => '可抵扣积分',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'is_show' => 1,
          'value' => 0
      ],
      'distribution_price' => [
          'title' => '分销返佣金额',
          'field' => 'decimal(10,2) NULL',
          'type' => 'num',
          'remark' => '用户收益 = 返佣金额 * 分佣比例  【注：分佣比例 在功能配置里设置】',
          'is_show' => 1
      ],
      'is_spec' => [
          'title' => '是否有规格',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'value' => 0
      ],
      'file_url' => [
          'title' => '文件下载链接',
          'field' => 'varchar(255) NULL',
          'type' => 'string',
          'is_show' => 1
      ],
      'express' => [
          'title' => '邮费',
          'type' => 'num',
          'field' => 'decimal(10,2) NULL',
          'is_show' => 1,
          'value' => 0.00
      ],
      'send_type' => [
          'title' => '收货方式',
          'type' => 'checkbox',
          'field' => 'varchar(30) NULL',
          'extra' => '1:邮寄
2:自提',
          'value' => 1,
          'remark' => '至少要选择一种方式',
          'is_show' => 1
      ],
      'stores_ids' => [
          'title' => '自提门店',
          'type' => 'checkbox',
          'field' => 'varchar(100) NULL',
          'is_show' => 1
      ],
      'is_all_store' => [
          'title' => '店门类型',
          'type' => 'bool',
          'field' => 'tinyint(2) NULL',
          'extra' => '0:全部店门
1:指定门店',
          'is_show' => 1,
          'value' => 0
      ],
      'tab' => [
          'title' => '同款标签',
          'type' => 'string',
          'field' => 'varchar(100) NULL',
          'remark' => '相同的标签出现在同款列表中',
          'is_show' => 1
      ],
      'can_deposit' => [
          'title' => '是否支持定金支付',
          'field' => 'tinyint(2) NULL',
          'type' => 'string',
          'value' => 1
      ],
      'param_temp_id' => [
          'title' => '参数模板ID',
          'field' => 'int(11) NULL',
          'type' => 'string'
      ]
  ];
}