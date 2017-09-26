<?php
namespace app\common\model;
use think\Model;

class Bis extends BaseModel
{
	/**
 	 * @author Ethan
	 * @desc 商户申请时的数据获取
 	*/	
	public function getBisByStatus($status = 0){
		$data = [
			'status' => $status,
		];
		$order = [
			'id' => 'desc',
		];
		
		$res =  $this->where($data)
				->order($order)
				->paginate(3);
				
		return $res;
	}	
}