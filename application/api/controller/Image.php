<?php
namespace app\api\controller;
use think\Controller;
use think\Request;
use think\File;

class Image extends Controller
{
	/**
 	 * @author Ethan
	 * @desc 上传图片使用的
 	*/
	public function upload(){
		//
		$file = Request::instance()->file('file');
		//将file文件存放在本地public目录下面的upload目录中
		$info = $file->move('upload');
//		print_r($info);
		if($info && $info->getPathname()){
			//'/'代表网站的入口文件
			return show(1,'success','/'.$info->getPathname());
		}
		return show(0,'error');
	}
}
