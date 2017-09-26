<?php
namespace app\admin\controller;
use think\Controller;

class Deal extends Controller
{
	private $obj;
	public function _initialize(){
		$this->obj = model('Deal');
	}
	
	/**
 	 * @author Ethan
	 * @desc 主后台团购列表
 	*/
 	public function index(){
	 	//获取提交数据
	 	$data = input('get.');
	 	$sdata = [];
	 	//对日期进行验证
	 	if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time']) > strtotime($data['start_time'])) {
	    		$sdata['create_time'] = [
	    			['gt', strtotime($data['start_time'])],
	    			['lt', strtotime($data['end_time'])],
	    		];
	    	}
	 	//分别对分类 城市 商户名进行验证
	 	if(!empty($data['category_id'])) {
	    	$sdata['category_id'] = $data['category_id'];
	    	}
	    	if(!empty($data['city_id'])) {
	    		$sdata['city_id'] = $data['city_id'];
	   	 }
	    	if(!empty($data['name'])) {
	    		$sdata['name'] = ['like', '%'.$data['name'].'%'];
	    	}
	 	//数据获取，使用关联数组的方式
	 	$cityArrs = $categoryArrs = [];
        	$categorys = model("Category")->getNormalCategorysByParentId();
        	foreach($categorys as $category) {
        	$categoryArrs[$category->id] = $category->name;
        	}

        	$citys = model("City")->getNormalCitys();
        	foreach($citys as $city) {
        		$cityArrs[$city->id] = $city->name;
        	}

	 	//团购获取
	 	$deals = $this->obj->getNormalDeals($sdata);
	 		
//	 	print_r($deals);exit;
	 	return $this->fetch('',[
	 		'citys' => $citys,
	 		'categorys' => $categorys,
	 			//下面填充的用于数据回显
	 		'category_id' => empty($data['category_id']) ? '' : $data['category_id'],
	        	'city_id' => empty($data['city_id']) ? '' : $data['city_id'],
	        	'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
	        	'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
	        	'name' => empty($data['name']) ? '' : $data['name'],
	        	//下面的用于搜索的结果
	 		'deals' => $deals,
	 		'categoryArrs' => $categoryArrs,
        		'cityArrs' => $cityArrs,
	 	]);
 	}
}
