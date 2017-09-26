<?php
namespace app\admin\controller;
use think\Controller;

class Category extends Controller
{
	private $obj;
	public function _initialize(){
		$this->obj = model('Category');
	}
	
	/**
 	 * @author Ethan
	 * @desc 生活服务类一级分类显示显示
 	*/
    public function index()
    {
		$parent_id = input('get.parent_id',0,'intval');
		//获取数据
		$categorys = $this->obj->getFirstCategorys($parent_id);
		return $this->fetch('',
				['categorys' => $categorys,]);
    }
	/**
 	 * @author Ethan
	 * @desc 生活服务类添加分类
 	*/
    public function add()
    {
    	$categorys = $this->obj->getNormalFirstCategorys();
    	
		return $this->fetch('',['categorys' => $categorys,]);
    }
	
	/**
 	 * @author Ethan
	 * @desc 生活服务类编辑
 	*/
    public function edit($id = 0)
    {
//		echo input('get.id');

		//获取此id的分类
		$category = $this->obj->get($id);
//		print_r ($category);exit;
 
		//获取所有的一级分类
    	$categorys = $this->obj->getNormalFirstCategorys();
				
		//填充到模板中
		return $this->fetch('',[
			'categorys' => $categorys,
			'category' => $category,
		]);
    }
    /**
 	 * @author Ethan
	 * @desc 添加分类保存
 	*/
    public function save()
    {
//		print_r($_POST);
//		print_r(input('post.'));
//		print_r(request()->post());
		//请求校验
		if(!request()->isPost()){
			$this->error('请求失败');
		}
		//获取添加的数据
		$data = input('post.');
//		print_r($data);exit;
		//进行校验
		$res = validate('Category');
		//判断校验结果
		if(!$res->scene('add')->check($data)){
			$this->error($res->getError());
		}
		//用于判断是添加分类还是边界
		if(!empty($data['id'])){
			return $this->update($data);
		}
		//数据传递给model层
		$isSuccess = $this->obj->add($data);
		if($isSuccess){
			$this->success('分类添加成功');
		}else{
			$this->error('分类添加失败');
		}
    }
    
    /**
 	 * @author Ethan
	 * @desc 编辑时更新
 	*/
    public function update($data){
		 $res = $this->obj->save($data,['id' => intval($data['id'])]);   	
		 if($res){
		 	$this->success("更新成功");
		 }else{
		 	$this->error("更新失败");
		 }
    }

    /**
 	 * @author Ethan
	 * @desc 编辑排序
 	*/
 	public function listorder($id,$listorder){
		$res = $this->obj->save(['listorder'=>$listorder],['id'=> $id]);
		if($res){
			$this->result($_SERVER['HTTP_REFERER'],1,'success');
		}else{
			$this->result($_SERVER['HTTP_REFERER'],0,'failure');
		}	 		
 	}
 	
 	/**
 	 * @author Ethan
	 * @desc 状态更改
 	*/
 	public function status(){

// 		echo "helloworld";
 		//获取数据
 		$data = input('get.');
 		//数据校验
 		$validate = validate("Category");
 		if(!$validate->scene('status')->check($data)){
 			$this->error($validate->getError());
 		}
 		//数据库更新
 		$res = $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
 		if($res){
 			$this->success("状态更新成功");
 		}else{
 			$this->error("状态更新失败");
 		}
 	}
 	
}