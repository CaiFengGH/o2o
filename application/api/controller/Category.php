<?php
namespace app\api\controller;
use think\Controller;

class Category extends Controller
{
	private $obj;
	
	public function _initialize(){
		$this->obj = model('Category');
	}
	/**
 	 * @author Ethan
	 * @desc 商户注册时的城市显示
 	*/
 	public function getCategorysByParentId(){
 		$id = input('post.id');
		//异常判断
		if(!$id){
			$this->error("ID不正确");
		}
 		$categorys = $this->obj->getNormalCategorysByParentId($id);
		if(!$categorys){
			//位于api中common.php中的show函数
			return show(0,'error');
		}
		return show(1,'success',$categorys);
 	}
}
