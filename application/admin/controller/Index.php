<?php
namespace app\admin\controller;
use think\Controller;

class Index extends Controller
{
	//后台主页面
    public function index()
    {
	return $this->fetch();
    }
	//后台主页面的显示
    public function welcome()
    {
    	//邮箱验证失败
//    	\phpmailer\Email::send(1,1,1);
//    	return "发送邮件成功";
	return "Welcome o2o.caifeng.com";
    }
    //百度地图经纬度获取测试
    public function test()
    {
  	return  \Map::staticimage("河南济源");
    }
}
