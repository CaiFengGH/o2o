<?php
namespace app\bis\controller;
use think\Controller;

class Deal extends Base
{
	/**
 	 * @author Ethan
	 * @desc 商户成功登陆后团购列表
 	*/
	public function index(){
		$bisId = $this->getLoginUser()->bis_id;
		$deals = model('Deal')->getDealsByBisId($bisId);
//		print_r($deals);exit;
		return $this->fetch('',[
			'deals'=>$deals,
		]);
	}
	
	/**
 	 * @author Ethan
	 * @desc 商户成功登陆后新增门店
 	*/
	public function add(){
		//获取商户id
		$bisId = $this->getLoginUser()->bis_id;
		
		if(request()->isPost()){
			// 第一点 检验数据 tp5 validate机制， 小伙伴自行完成

            $data = input('post.');
            
            $data['cat'] = '';
            if(!empty($data['se_category_id'])) {
                $data['cat'] = implode('|', $data['se_category_id']);
            }
			//团购商品
			$deals = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'image' => $data['image'],
                'category_id' => $data['category_id'],
                'se_category_id' => empty($data['se_category_id']) ? '' : implode(',', $data['se_category_id']),
                'city_id' => $data['city_id'],
                'location_ids' => empty($data['location_ids']) ? '' : implode(',', $data['location_ids']),
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'total_count' => $data['total_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'notes' => empty($data['notes']) ? '' : $data['notes'],
                'description' => empty($data['description']) ? '' : $data['description'],
                'bis_account_id' => $this->getLoginUser()->id,
            ];
//			print_r($deals);exit;
            $id = model('Deal')->add($deals);
//			print_r($id);exit;
			if($id){
				$this->success('添加成功',url('deal/index'));
			}else{
				$this->error('添加失败');
			}
		}else{
			//获取城市的数据
			$citys = model('City')->getNormalCityByParentId();
			//获取分类的数据
			$categorys = model('Category')->getNormalCategorysByParentId();
			//获取门店信息
			$bisLocation = model('BisLocation')->getNormalLocationByBisId($bisId);
//			print_r($bisLocation);exit;
			return $this->fetch('',[
				'citys' => $citys,
				'categorys' => $categorys,
				'bisLocation' => $bisLocation,
			]);
		}
	}

 	
 	public function status(){
 		//获取数据
 		$data = input('get.');
//		print_r($data);exit;
 		//数据库更新
 		$location = model('Deal')
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