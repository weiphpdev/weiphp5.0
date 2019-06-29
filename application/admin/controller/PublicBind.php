<?php
// +----------------------------------------------------------------------
// | WeiPHP [ 公众号和小程序运营管理系统 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.weiphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 凡星 <weiphp@weiphp.cn> <QQ:203163051>
// +----------------------------------------------------------------------
namespace app\admin\controller;

/**
 * 模型数据管理控制器
 *
 * @author 凡星
 */
class PublicBind extends Admin {
	public function index() {
		if (IS_POST) {
			$Config = D ( 'Config' );
			
			$appid = I ( 'appid' );
			$appsecret = I ( 'appsecret' );
			$status = I ( 'status' );
			
			if ($status == 1) {
				if (empty ( $appid )) {
					$this->error( '140208:请先填写AppID' );
				} elseif (empty ( $appsecret )) {
					$this->error( '140209:请先填写AppSecret' );
				}
			}
			
			$map ['name'] = 'COMPONENT_APPID';
			$Config->where ( $map )->setField ( 'value', $appid );
			
			$map ['name'] = 'COMPONENT_APPSECRET';
			$Config->where ( $map )->setField ( 'value', $appsecret );
			
			$map ['name'] = 'PUBLIC_BIND';
			$Config->where ( $map )->setField ( 'value', $status );
			
			S ( 'DB_CONFIG_DATA', null );
			
			$this->success ( '操作成功！' );
		} else {
			$this->assign ( 'status', config( 'PUBLIC_BIND' ) );
			$this->assign ( 'appid', config( 'COMPONENT_APPID' ) );
			$this->assign ( 'appsecret', config( 'COMPONENT_APPSECRET' ) );
			
			$arr = parse_url ( SITE_URL );
			$this->assign ( 'host', $arr ['host'] );
			
			$encodingaeskey = config( 'ENCODING_AES_KEY' );
			
			if (empty ( $encodingaeskey )) {
				$length = 43;
				$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
				$encodingaeskey = "";
				for($i = 0; $i < $length; $i ++) {
					$encodingaeskey .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
				}
				
				D('Config')->setField ( 'ENCODING_AES_KEY', $encodingaeskey );
			}
			$this->assign ( 'encodingaeskey', $encodingaeskey );
			
			return $this->fetch();
		}
	}
}