<?php
/**
 * ShopGoodsSkuConfig数据模型
 */
class ShopGoodsSkuConfigTable {
    // 数据表模型配置
    public $config = [
      'name' => 'shop_goods_sku_config',
      'title' => '商品规格配置',
      'search_key' => '',
      'add_button' => 1,
      'del_button' => 1,
      'search_button' => 1,
      'check_all' => 1,
      'list_row' => 10,
      'addon' => 'shop'
  ];

    // 列表定义
    public $list_grid = [ ];

    // 字段定义
    public $fields = [
      'goods_id' => [
          'title' => '商品ID',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'value' => 0
      ],
      'spec_id' => [
          'title' => '规格ID',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'value' => 0
      ],
      'option_id' => [
          'title' => '属性ID',
          'field' => 'int(10) NULL',
          'type' => 'num',
          'value' => 0
      ],
      'img' => [
          'title' => '属性加图',
          'field' => 'int(10) unsigned NULL',
          'type' => 'picture'
      ]
  ];
}