<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );

/*
 * Name : Collection
 * Date : 20120107
 * Author : Qesy
 * QQ : 762264
 * Mail : 762264@qq.com
 *
 * (̅_̅_̅(̲̅(̅_̅_̅_̅_̅_̅_̅_̅()ڪے
 *
 */
function DbConfig(){ //接口配置
    $DevArr = array (
        'Host' => '192.168.1.55',
        'Accounts' => 'root',
        'Password' => 'Rongyi1234!@#$',
        'Name' => 'qcms',
        'Port' => '3306',
        'Prefix' => 'qc_',
        'Charset' => 'utf8'
    );
    $ReleaseArr = array (
        'Host' => '192.168.1.55',
        'Accounts' => 'Rongyi',
        'Password' => 'Rongyi1234!@#$',
        'Name' => 'qcms',
        'Port' => '3306',
        'Prefix' => 'qc_',
        'Charset' => 'utf8'
    );
    return (WEB_MODE == 'Dev') ? $DevArr : $ReleaseArr;
}

function redisConfig(){
    $DevArr = array(
        'Host' => '127.0.0.1',
        'Pwd'  => '123456',
    );
    $ReleaseArr = array(
        'Host' => '127.0.0.1',
        'Pwd'  => '123456',
    );
    return (WEB_MODE == 'Dev') ? $DevArr : $ReleaseArr;
}

function SiteConfig() {
    return array (
        'UrlType' => '1',
        'Extend' => '.html',
        'DefaultController' => 'index',
        'DefaultFunction' => 'index',
        'Language' => 'en',
        'Url' => '/'
    );
}

function BasicArr(){
    return array(
        'Client' => array('Web' => '网站', 'WcMini' => '微信小程序'),
    );
}

function autoload($classname) { // -- 自动加载类 --
    $filename = PATH_LIB . $classname . '.php';
    $filename = str_replace('\\', '/', $filename);
    if (file_exists ( $filename ))
        require $filename;
}

const WEB_MODE = 'Dev'; //Dev ,Release
const WEB_TITLE = 'Qesy Framework';
const VERSION = '1.0.0';
?>
