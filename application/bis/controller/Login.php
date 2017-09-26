<?php
namespace app\bis\controller;
use think\Controller;

class Login extends Controller
{
	/**
 	 * @author Ethan
	 * @desc 商户登陆
 	*/
	public function index(){
		//判断是否是post请求
		if(request()->isPost()){
			//获取post的请求数据
			$data = input('post.');
			//验证用户的用户名和密码的准确性
			//验证数据库是否包含该商户或者商户是否验证通过
			$res = model('BisAccount')->get(['username'=>$data['username']]);
//			print_r($res);exit;
			if(!$res || $res->status != 1){
				$this->error('商户不存在或者未通过');
			}
			//验证密码是否正确
			if($res->password != md5($data['password'].$res->code)){
				$this->error('商户密码不正确');
			}
			//更新商户的最新登陆时间
			model('BisAccount')->updateById(['last_login_time'=>time()],$res->id);
			//保存在session会话中
			session('bisAccount',$res,'bis');
			return $this->success('登录成功',url('index/index'));
			
		}else{
			//获取session中的内容
			$account = session('bisAccount','','bis');
			if($account){
				//重定向到新的内容
				return $this->redirect(url('index/index'));
			}
			return $this->fetch();
		}
	}
	/**
 	 * @author Ethan
	 * @desc 商户退出
 	*/
	public function logout(){
		//清除session中bis作用域
		session(null,'bis');
		return $this->redirect(url('login/index'));
	}
}