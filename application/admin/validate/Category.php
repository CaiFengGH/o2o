<?php
namespace app\admin\validate;
use think\Validate;

class Category extends Validate
{
	//校验规则
	protected $rule = [
		['name', 'require|max:100','生活服务分类名称必须填写|生活服务分类名称不超过10个字符'],
		['parent_id','number'],
		['id','number'],
		['status','number|in:-1,0,1','状态必须为数字|状态数字不合法'],
		['listorder','number'],	
	];
	
	//不同场景
	protected $scene = [
		'add' => ['name','parent_id','id'],
		'listorder' => ['id','listorder'],
		'status' => ['id','status'],
	];
}