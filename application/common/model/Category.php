<?php
namespace app\common\model;
use think\Model;

class Category extends Model
{
	//与database.php中有相同的设置
	protected $autoWriteTimestamp = true;
   
    /**
 	 * @author Ethan
	 * @desc 添加分类保存
 	*/	
	public function add($data){
		$data['status'] = 1;
//		$data['create_time'] = time();
		$res =  $this->save($data);
		return $res;
	}
	
    /**
 	 * @author Ethan
	 * @desc 添加分类时的一级分类显示
 	*/	
	public function getNormalFirstCategorys(){
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
	 * @desc 生活服务类的排序显示
 	*/	
	public function getFirstCategorys($parent_id = 0){
		//搜索数据
		$data = [
			'parent_id' => $parent_id,
			'status' => ['neq',-1],
		];
		//数据排序
		$order = [
			'listorder' => 'desc',
			'id' => 'desc',
		];
		//返回搜索数据
		$result =  $this->where($data)
					->order($order)
					->paginate(3);
					
//		echo $this->getLastSql();
		return $result;
	}
	/**
 	 * @author Ethan
	 * @desc 商户注册时的种类显示
 	*/	
	public function getNormalCategorysByParentId($parent_id = 0){
		$data = [
			'status' => 1,
			'parent_id' => $parent_id,
		];
		$order = [
			'id' => 'desc',
		];
		
		return $this->where($data)
				->order($order)
				->select();
	}
	
}