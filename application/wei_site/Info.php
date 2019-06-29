<?php

namespace app\wei_site;

use app\common\controller\InfoBase;

/**
 * 微官网插件
 * @author 凡星
 */

class Info extends InfoBase
{

    public $info = array(
        'name'          => 'WeiSite',
        'title'         => '微官网',
        'description'   => '微3G网站、支持分类管理，文章管理、底部导航管理、微信引导信息配置，微网站统计代码部署。同时支持首页多模板切换、信息列表多模板切换、信息详情模板切换、底部导航多模板切换。并配置有详细的模板二次开发教程',
        'status'        => 1,
        'author'        => '凡星',
        'version'       => '0.1',
        'has_adminlist' => 0,
        'type'          => 1,
    );

    public function install()
    {
        $install_sql = env('app_path') . '/wei_site/install.sql';
        if (file_exists($install_sql)) {
            execute_sql_file($install_sql);
        }
        //插入菜单
        $firstMenu=M('menu')->where('menu_type',0)->where('url_type',0)->where('addon_name','wei_site')->find();
        if (empty($firstMenu)){
        	$addMenu['menu_type']=0;
        	$addMenu['pid']=0;
        	$addMenu['title']='微官网';
        	$addMenu['url_type']=0;
        	$addMenu['addon_name']='wei_site';
        	$addMenu['url']='';
        	$addMenu['target']='_self';
        	$addMenu['is_hide']=0;
        	$addMenu['sort']=0;
        	$addMenu['place']=0;
        	$pid = M('menu')->insertGetId($addMenu);
        }else {
        	$pid=$firstMenu['id'];
        }
        //二级菜单
        $secMenu=M('menu')->where('menu_type',1)->where('pid',$pid)->select();
        if (count($secMenu)<3){
        	$arr[]=array('menu_type'=>1,'pid'=>$pid,'title'=>'首页设置','url_type'=>1,'addon_name'=>'','url'=>'wei_site/Template/index','target'=>'_self','is_hide'=>0,'sort'=>1,'place'=>0);
        	$arr[]=array('menu_type'=>1,'pid'=>$pid,'title'=>'内容页配置','url_type'=>1,'addon_name'=>'','url'=>'wei_site/Template/lists','target'=>'_self','is_hide'=>0,'sort'=>2,'place'=>0);
        	$arr[]=array('menu_type'=>1,'pid'=>$pid,'title'=>'导航栏配置','url_type'=>1,'addon_name'=>'','url'=>'wei_site/Template/footer','target'=>'_self','is_hide'=>0,'sort'=>3,'place'=>0);
        	$has=[];
        	foreach ($secMenu as $vo){
        		$url=strtolower($vo['url']);
        		if ($url=='wei_site/template/index'){
        			$has[0]=1;
        		}
        		if ($url=='wei_site/template/lists'){
        			$has[1]=1;
        		}
        		if ($url=='wei_site/template/footer'){
        			$has[2]=1;
        		}
        	}
        	$addSecs=[];
        	foreach ($arr as $kk=>$vv){
        		if (isset($has[$kk]) && $has[$kk]){
        			continue;
        		}
        		$addSecs[]=$vv;
        	}
        	if (!empty($addSecs)){
        		M('menu')->insertAll($addSecs);
        	}
        }
       
        
        return true;
    }
    public function uninstall()
    {
        $uninstall_sql = env('app_path') . '/wei_site/uninstall.sql';
        if (file_exists($uninstall_sql)) {
            execute_sql_file($uninstall_sql);
        }
        //删除二级菜单
        $fid=M('menu')->where('menu_type',0)->where('url_type',0)->where('addon_name','wei_site')->value('id');
        if ($fid>0){
        	M('menu')->where('menu_type',1)->where('pid',$fid)->delete();
        }
        return true;
    }

}
