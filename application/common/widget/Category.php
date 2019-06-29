<?php
namespace app\common\widget;

use app\common\controller\base;

/**
 * 级联菜单插件
 *
 * @author 凡星
 */
class Category extends base
{

    public $info = array(
        'name' => 'Category',
        'title' => '通用分类树形结构',
        'description' => '',
        'status' => 1,
        'author' => '凡星',
        'version' => '0.1',
        'has_adminlist' => 0,
        'type' => 0
    );

    public function install()
    {
        return true;
    }

    public function uninstall()
    {
        return true;
    }

    /**
     * 编辑器挂载的后台文档模型文章内容钩子
     *
     * type=db&table=common_category&module=shop_category&value_field=id&custom_field=id,title,pid,sort&custom_pid=0
     * type=text&data=[广西[南宁,桂林], 广东[广州, 深圳[福田区, 龙岗区, 宝安区]]]
     */
    public function tree($data)
    {
        $this->assign($data);
        
        $content = $this->fetch('common@widget/tree');
        return $content;
    }
}
