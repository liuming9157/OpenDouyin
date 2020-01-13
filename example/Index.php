<?php
namespace app\api\controller;
use OpenDouyin\Application;
use think\Controller;
use think\Request;
class Index extends Controller{
	protected $config=[
		'ClientKey'=>'',
		'ClientSecret'=>'',
		'redirect_uri'=>''

	];
	protected $app;
	
	public function __construct(){
		
		$this->app=new Application($this->config);
	}
	//跳转到授权页
	public function goAuthPage(){
		$this->app->jump();
	}
	//获取access_token
	public function getToken(){
		$tokenData=$this->app->token();
		$token=$tokenData->access_token;
		return $token;
	}
	

} 