<?php
namespace app\common\model;
use think\Model;

class BisAccount extends BaseModel
{
	/**
 	 * @author Ethan
	 * @desc 商户登陆时间更新
 	*/	
	public function updateById($data,$id){
		//过滤掉数据库中存在的字段值
		$this->allowField(true)->save($data,['id'=>$id]);
	}
}