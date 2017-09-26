<?php
namespace app\bis\controller;
use think\Controller;

class Base extends Controller
{
	public $account;
	/**
 	 * @author Ethan
	 * @desc 商户成功登陆后的页面显示
 	*/
	public function _initialize(){
		$isLogin = $this->isLogin();
		if(!$isLogin){
			return $this->redirect(url('login/index'));
		}
	}
	
	public function isLogin(){
		//获取session中的账户
		$account = $this->getLoginUser();
		if($account && $account->id){
			return true;
		}
		return false;
	}
	
	public function getLoginUser(){
		if(!$this->account){
			$this->account = session('bisAccount','','bis');
		}
		return $this->account;
	}
}