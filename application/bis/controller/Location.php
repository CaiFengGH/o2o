<?php
namespace app\bis\controller;
use think\Controller;

class Location extends Base
{
	/**
 	 * @author Ethan
	 * @desc 商户成功登陆后门店列表
 	*/
	public function index(){
        $bisId = $this->getLoginUser()->bis_id;
		$bisLocation = model('BisLocation')->getNormalLocationByBisId($bisId);
//		print_r($res);exit;
		return $this->fetch('',[
			'bisLocation'=>$bisLocation,
		]);
	}
	
	/**
 	 * @author Ethan
	 * @desc 商户成功登陆后新增门店
 	*/
	public function add(){
		if(request()->isPost()){
			// 第一点 检验数据 tp5 validate机制， 小伙伴自行完成

            $data = input('post.');
            $bisId = $this->getLoginUser()->bis_id;
            
            $data['cat'] = '';
            if(!empty($data['se_category_id'])) {
                $data['cat'] = implode('|', $data['se_category_id']);
            }

            // 获取经纬度
            $lnglat = \Map::getLngLat($data['address']);
            if(empty($lnglat) || $lnglat['status'] !=0) {
                $this->error('无法获取数据，或者匹配的地址不精确');
            }

            // 门店入库操作
            // 总店相关信息入库
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
                'is_main' => 0,
                'status' => 1,
                'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
                'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
            ];
            $locationId = model('BisLocation')->add($locationData);
            if($locationId) {
                return $this->success('门店申请成功',url('location/add'));
            }else {
                return $this->error('门店申请失败',url('location/add'));
            }
		}else{
			//获取城市的数据
			$citys = model('City')->getNormalCityByParentId();
			//获取分类的数据
			$categorys = model('Category')->getNormalCategorysByParentId();
			return $this->fetch('',[
				'citys' => $citys,
				'categorys' => $categorys,
			]);
		}
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
// 		print_r($categorys);exit;
 		//商户
 		//总店信息
 		$locationData = model('BisLocation')->get(['id'=>$id]);
 		
 		
 		return $this->fetch('',[
 			'citys'=>$citys,
 			'categorys'=>$categorys,
 			'locationData'=>$locationData,
 		]);
 	}
 	
 	/**
 	 * @author Ethan
	 * @desc 状态更改
 	*/
 	public function status(){

 		//获取数据
 		$data = input('get.');
//		print_r($data);exit;
 		//数据库更新
 		$location = model('BisLocation')
 					->save(['status'=>$data['status']],['id'=>$data['id']]);
 		if($location){
 			// 发送邮件 不同信息状态返回给商户
            // status 1  status 2  status -1
            // \phpmailer\Email::send($data['email'],$title, $content);
 			$this->success("删除成功");
 		}else{
 			$this->error("删除失败");
 		}
 	}
	
	
}