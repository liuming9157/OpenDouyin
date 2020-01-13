<?php
namespace OpenDouyin;
use GuzzleHttp\Client;
use think\Controller;
use think\Request;
use Exception;
class Application extends Controller{
	protected $client;
	protected $ck='';
	protected $cs='';
	protected $redirect_uri='';
	protected $base_uri='https://open.douyin.com';
	public function __construct($config=[]){
		$this->client=new Client([
			'base_uri'=>$this->base_uri
		]);
		$this->ck=$config['ClientKey'];
		$this->cs=$config['ClientSecret'];
		$this->redirect_uri=$config['redirect_uri'];
	}
	/**
	 * 跳转到授权页
	 *
	 * @return void
	 * @author 
	 **/
	public function jump()
	{
		$url='https://open.douyin.com/platform/oauth/connect?client_key='.$this->ck.'&response_type=code&scope=&redirect_uri='$this->redirect_uri;
		echo "<script language='javascript' type='text/javascript'>window.location.href = '$url'</script>";

	}
	/**
	 * 获取授权码
	 *
	 * @return void
	 * @author 
	 **/
	public function code()
	{
		$code=Request::instane()->param('code');
		return $code;
	}
	/**
	 * 获取access_token
	 *
	 * @return void
	 * @author 
	 **/
	public function token()
	{
		$response=$this->client->get('/oauth/access_token/',['query'=>[
			'client_key'=>$this->ck;
			'client_secret'=>$this->cs;
			'code'=>$this->code();
			'grant_type'=>'authorization_code'

		]]);
		$responseData=$response->getBody()->getContents();
		$responseData=json_decode($responseData)->data;
		$error_code=$responseData->error_code;
		if($error_cdoe==0){
			return $responseData
		}
		throw new Exception('failed to get token');

	}
} 