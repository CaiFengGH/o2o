<?php
namespace app\bis\controller;
use think\Controller;

class Index extends Base
{
	/**
 	 * @author Ethan
	 * @desc 商户成功登陆后的页面显示
 	*/
	public function index(){
		return $this->fetch();
	}
	
}