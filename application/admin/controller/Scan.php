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
class Scan extends Admin {
	public function index() {
		if (IS_POST) {
			$Config = D ( 'Config' );
			
			$wp_id = I ( 'wp_id' );
			$status = I ( 'status' );
			
			if ($status == 1 && empty ( $wp_id )) {
				$this->error ( '140261:请先选择服务号' );
			}
			
			$Config->setField ( 'SCAN_LOGIN_PUBLIC', $wp_id );
			$Config->setField ( 'SCAN_LOGIN', $status );
			
			$where ['id'] = $wp_id;
			$token = M ( 'publics' )->where ( $where )->value ( 'token' );
			$Config->setField ( 'SCAN_LOGIN_TOKEN', $token );
			
			$this->success ( '操作成功！' );
		} else {
			$this->assign ( 'status', config( 'SCAN_LOGIN' ) );
			$this->assign ( 'wp_id', config( 'SCAN_LOGIN_PUBLIC' ) );
			
			return $this->fetch();
		}
	}
}