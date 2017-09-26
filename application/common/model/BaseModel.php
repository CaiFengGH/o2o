<?php
namespace app\common\model;
use think\Model;

class BaseModel extends Model
{
	//自动添加起时间戳
	protected $autoWriteTimestamp = true;
	
    /**
 	 * @author Ethan
	 * @desc 商户入驻时的入库
 	*/	
	public function add($data){
		//申请时状态为0
		$data['status'] = 0;
		$this->save($data);
		return $this->id;
	}
	
}