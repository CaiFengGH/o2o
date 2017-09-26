<?php
namespace app\admin\controller;
use think\Controller;

class Bis extends Controller
{
	private $obj;
	public function _initialize(){
		$this->obj = model('Bis');
	}
	
	/**
 	 * @author Ethan
	 * @desc 
 	*/
 	public function index(){
 		$bis = $this->obj->getBisByStatus(1);
 		return $this->fetch('',[
 			'bis' => $bis,
 		]);
 	}	
 	
	/**
 	 * @author Ethan
	 * @desc 商户申请时的内容填充
 	*/
 	public function apply(){
 		$bis = $this->obj->getBisByStatus();
// 		print_r($bis);exit;
 		return $this->fetch('',[
 			'bis' => $bis,
 		]);
 	}	
 	
	/**
 	 * @author Ethan
	 * @desc 商户申请时的编辑
 	*/
 	public function detail(){
 		//获取传递的id
 		$id = input('get.id');
 		//id检查
 		if(!$id){
 			return $this->error('ID错误');
 		}
 		//商户的城市信息
		$citys = model('City')->getNormalCityByParentId();
		//获取分类的数据
		$categorys = model('Category')->getNormalCategorysByParentId();
 		//商户
 		$bisData = model('Bis')->get($id);
 		//总店信息
 		$locationData = model('BisLocation')->get(['bis_id'=>$id,'is_main'=>1]);
 		$accountData = model('BisAccount')->get(['bis_id'=>$id,'is_main'=>1]);
 		
 		return $this->fetch('',[
 			'citys'=>$citys,
 			'categorys'=>$categorys,
 			'bisData'=>$bisData,
 			'locationData'=>$locationData,
 			'accountData'=>$accountData,
 		]);
 	}
 	
 	/**
 	 * @author Ethan
	 * @desc 状态更改
 	*/
 	public function status(){

// 		echo "helloworld";
 		//获取数据
 		$data = input('get.');
 		
 		//数据校验
// 		$validate = validate("Bis");
// 		if(!$validate->scene('status')->check($data)){
// 			$this->error($validate->getError());
// 		}

 		//数据库更新
 		$res = $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
 		$location = model('BisLocation')
 					->save(['status'=>$data['status']],['bis_id'=>$data['id'],'is_main'=>1]);
 		$account = model('BisAccount')
 					->save(['status'=>$data['status']],['bis_id'=>$data['id'],'is_main'=>1]);
 		if($res && $location && $account){
 			// 发送邮件 不同信息状态返回给商户
            // status 1  status 2  status -1
            // \phpmailer\Email::send($data['email'],$title, $content);
 			$this->success("状态更新成功");
 		}else{
 			$this->error("状态更新失败");
 		}
 	}
}