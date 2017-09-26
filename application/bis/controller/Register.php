<?php
namespace app\bis\controller;
use think\Controller;

class Register extends Controller
{
	/**
 	 * @author Ethan
	 * @desc 商户注册时的显示
 	*/
	public function index(){
		//获取城市的数据
		$citys = model('City')->getNormalCityByParentId();
		//获取分类的数据
		$categorys = model('Category')->getNormalCategorysByParentId();
		return $this->fetch('',[
			'citys' => $citys,
			'categorys' => $categorys,
		]);
	}
	
	/**
 	 * @author Ethan
	 * @desc 商户注册时的添加
 	*/	
 	public function add(){
 		//请求类型校验
 		if(!request()->isPost()){
 			$this->error('请求类型不正确');
 		}
 		$data = input('post.');
 		
// 		print_r($data);exit;
 		
 		//请求数据校验
 		$validate = validate('Bis');
 		if(!$validate->scene('add')->check($data)){
 			$this->error($validate->getError());
 		}
 		
 		//用户地址是否准确
		$LngLat = \Map::getLngLat($data['address']);
		
//		print_r($LngLat);exit;

		if(empty($LngLat) || $LngLat['status'] != 0){
			$this->error('无法准确获取精确的数据');
		}
 		//商户是否已经存在
 		$account = model('BisAccount')->get(['username'=>$data['username']]);
 		if($account){
 			$this->error('商户已经存在不能在添加');
 		}
 		
 		//商户基本信息入库
 		$bisData = [
		    'name' => $data['name'],
		    'city_id' => $data['city_id'],
		    'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
		    'logo' => $data['logo'],
		    'licence_logo' => $data['licence_logo'],
		    'description' => empty($data['description']) ? '' : $data['description'],
		    'bank_info' =>  $data['bank_info'],
		    'bank_user' =>  $data['bank_user'],
		    'bank_name' =>  $data['bank_name'],
		    'faren' =>  $data['faren'],
		    'faren_tel' =>  $data['faren_tel'],
		    'email' =>  $data['email'],
       		];
        	$bisId = model('Bis')->add($bisData);
        
// 		print_r($bisId);exit;
 		
 		//总店信息校验
 		$data['cat'] = '';
		if(!empty($data['se_category_id'])) {
		    $data['cat'] = implode('|', $data['se_category_id']);
		}
 		
 		//总店基本信息入库
 		$locationData = [
		    'bis_id' => $bisId,
		    'name' => $data['name'],
		    'logo' => $data['logo'],
		    'tel' => $data['tel'],
		    'contact' => $data['contact'],
		    'category_id' => $data['category_id'],
		    'category_path' => $data['category_id'] . ',' . $data['cat'],
		    'city_id' => $data['city_id'],
		    'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
		    'api_address' => $data['address'],
		    'open_time' => $data['open_time'],
		    'content' => empty($data['content']) ? '' : $data['content'],
		    'is_main' => 1,// 代表的是总店信息
		    'xpoint' => empty($LngLat['result']['location']['lng']) ? '' : $LngLat['result']['location']['lng'],
		    'ypoint' => empty($LngLat['result']['location']['lat']) ? '' : $LngLat['result']['location']['lat'],
        	];
        	$locationId = model('BisLocation')->add($locationData);
        
// 		print_r($bisId);exit; 		
 		//用户密码信息入库
 		$data['code'] = mt_rand(100, 10000);
        	$accounData = [
		    'bis_id' => $bisId,
		    'username' => $data['username'],
		    'code' => $data['code'],
		    //使用md5加密
		    'password' => md5($data['password'].$data['code']),
		    'is_main' => 1, // 代表的是总管理员
        	];

		$accountId = model('BisAccount')->add($accounData);
		if(!$accountId) {
		    $this->error('申请失败');
		}
        
//      print_r($accountId);exit; 

		//申请页面
		$this->success('申请成功',url('register/waiting',['id'=>$bisId]));
 	}

	/**
 	 * @author Ethan
	 * @desc 商户注册时的申请页面
 	*/ 	
 	public function waiting($id){
 		//错误输入校验
 		if(empty($id)){
 			$this->error('error');	
 		}
 		//获取商户信息
 		$detail = model('Bis')->get($id);
 		//页面跳转
 		return $this->fetch('',[
 			'detail' => $detail,	
 		]);
 	}
 	
}
