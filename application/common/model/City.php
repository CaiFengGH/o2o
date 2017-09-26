<?php
namespace app\common\model;
use think\Model;

class City extends Model
{
	protected $autoWriteTimestamp = true;
    /**
 	 * @author Ethan
	 * @desc 商户注册时城市显示
 	*/	
 	public function getNormalCityByParentId($parent_id = 0){
 		$data = [
 			'status' => 1,
 			'parent_id' => $parent_id,
 		];
 		
 		$order = [
 			'id' => 'desc',
 		];
 		
 		return $this->where($data)->order($order)->select();
 	}
 	/**
 	 * @author Ethan
	 * @desc 团购列表时的
 	*/	
 	 public function getNormalCitys() {
        $data = [
            'status' => 1,
            'parent_id' => ['gt', 0],
        ];

        $order = ['id'=>'desc'];

        return $this->where($data)
            ->order($order)
            ->select();

    }

 	/**
 	 * @author Ethan
	 * @desc 城市列表的获取
 	*/	
 	public function getFirstCitys($parent_id = 0){
 		//搜索数据
		$data = [
			'parent_id' => $parent_id,
			'status' => ['neq',-1],
		];
		//数据排序
		$order = [
			'listorder' => 'asc',
			'id' => 'desc',
		];
		//返回搜索数据
		$result =  $this->where($data)
					->order($order)
					->paginate(5);
					
//		echo $this->getLastSql();
		return $result;
 	}
 	/**
 	 * @author Ethan
	 * @desc 城市列表的一级城市获取
 	*/	
 	public function getNormalFirstCitys(){
 		//查询数据
		$data = [
			'status' => 1,
			'parent_id' => 0,
		];
		//id升序排序
		$order = [
			'id' => 'desc',
		];
		//返回查询数据
		return $this->where($data)
			->order($order)
			->select();
 	}
	/**
 	 * @author Ethan
	 * @desc 添加分类保存
 	*/	
	public function add($data){
		$data['status'] = 0;
//		$data['create_time'] = time();
		$res =  $this->save($data);
		return $res;
	}
}