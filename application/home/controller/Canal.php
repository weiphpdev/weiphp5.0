<?php
// +----------------------------------------------------------------------
// | WeiPHP [ 移动应用的后端运营管理系统 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.weiphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 凡星 <weiphp@weiphp.cn> <QQ:203163051>
// +----------------------------------------------------------------------
namespace app\home\controller;

use app\common\controller\Base;

/**
 * 缓存自动更新控制器
 * 支持File，Memcache，Redis等类型的缓存自动更新功能
 */
class Canal extends Base
{
/**
接收到的数据格式：
    {"data":{"addon_status":"","appid":"","area":"","authorizer_refresh_token":"","cert_pem":"","domain":"","encodingaeskey":"","group_id":"0","headface_url":"","id":"45","interface_url":"","is_bind":"0","is_use":"0","key_pem":"","mch_id":"","partner_key":"","public_id":"","public_name":"55555","secret":"","tips_url":"","type":"0","uid":"","wechat":""},"eventType":"INSERT","schemaName":"shengxun","tableName":"wp_publics"}

    {"data":{"addon_status":"","appid":"","area":"","authorizer_refresh_token":"","cert_pem":"","domain":"","encodingaeskey":"","group_id":"0","headface_url":"","id":"45","interface_url":"","is_bind":"0","is_use":"0","key_pem":"","mch_id":"","partner_key":"","public_id":"","public_name":"55555","secret":"","tips_url":"","type":"0","uid":"","wechat":""},"eventType":"DELETE","schemaName":"shengxun","tableName":"wp_publics"}
**/
    // 处理入口
    public function index()
    {
        $content = wp_file_get_contents('php://input');
        $log = json_decode($content, true);
        
        if ($log['schemaName'] != config('database.database')) {
            // 不是本项目数据库的，直接无视
            exit('-1');
        }
        //file_log($content, 'canal'); //记录文件日志
        
        $tableName = $log['tableName'];
        
        $key_config = keys_list($log['tableName']);
        
        if (empty($key_config)) {
            // 当前数据表没有缓存，直接返回
            exit('-2');
        }
        
        if ($log['eventType'] == 'UPDATE') {
            // 老数据对应的缓存也要清空
            $this->ClearCache($log, $log['befdata'], $key_config);
        }
        $this->ClearCache($log, $log['data'], $key_config);
        
        return $this->success('成功');
    }
    //执行清缓存操作
    function ClearCache($log, $data, $key_config)
    {
        // 先取出新增数据的数据表下的所有key规则，然后根据key规则和增加的数据，逐个生成各个key，然后把这些key的值全部设置为null，相当于清它的缓存。
        $search = $replace = [];
        foreach ($data as $k => $v) {
            $search[] = '[' . $k . ']';
            $replace[] = $v;
        }
        
        foreach ($key_config as $info) {
            $key = str_replace($search, $replace, $info['key_rule']);
            
            // 还可以额外判断缓存的数据是否被更新过，如果没更新，则可以不清空缓存。
            $update = true;            
            if ($log['eventType'] == 'UPDATE' && ! empty($info['data_field'])) {
                $data_field = wp_explode($info['data_field'], ',');
                
                // 判断这些字段是否被更新过
                $update = false;
                foreach ($data_field as $field) {
                    if ($log['befdata'][$field] != $log['data'][$field]) {
                        $update = true;
                        break;
                    }
                }
            } 
                if ($update === true) {
                cache($key, NULL);
            }
        }
    }
}
