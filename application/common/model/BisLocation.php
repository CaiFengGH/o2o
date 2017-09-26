<?php
namespace app\common\model;
use think\Model;

class BisLocation extends BaseModel
{
	/**
 	 * @author Ethan
	 * @desc 商户成功登陆后门店列表
 	*/
	public function getNormalLocationByBisId($bisId) {
        $data = [
            'bis_id' => $bisId,
            'status' => 1,
        ];
	$order = [
		'id'=>'desc',
	];
        $res = $this->where($data)
            ->order($order)
            ->select();
        return $res;
    }
	
}
