<?php
namespace app\material\controller;

use app\common\controller\WapBase;

/**
 * 素材管理控制器
 */
class Wap extends WapBase
{

    public function news_detail()
    {
        $map['id'] = I('id');
        $info = M('material_news')->where(wp_where($map))->find();
        $uid=get_mid();
        $pbid=get_pbid();
        $info['content'] = replaceInfo($info['content'],$uid,$pbid);
        $info['link'] = replaceInfo($info['link'],$uid,$pbid);
        $this->assign('info', $info);
        
        return $this->fetch();
    }
}
