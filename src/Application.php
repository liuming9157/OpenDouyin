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
	 * @return object
	 * @author 
	 **/
	public function token()
	{
		$response=$this->client->get('/oauth/access_token/',['query'=>[
			'client_key'=>$this->ck,
			'client_secret'=>$this->cs,
			'code'=>$this->code(),
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
	/**
	 * 刷新access_token
	 * @param refresh_token
	 * @return object
	 * @author 
	 **/
	public function refreshToken($refresh_token)
	{
		$response=$this->client->get('/oauth/refresh_token/',['query'=>[
			'client_key'=>$this->ck,
			'refresh_token'=>$refresh_token,
			'grant_type'=>'refresh_token'

		]]);
		$responseData=$response->getBody()->getContents();
		$responseData=json_decode($responseData)->data;
		$error_code=$responseData->error_code;
		if($error_cdoe==0){
			return $responseData
		}
		throw new Exception('failed to refresh token');

	}
	/**
	 * 获取client_token
	 *
	 * @return object
	 * @author 
	 **/
	public function clientToken()
	{
		$response=$this->client->get('/oauth/client_token/',['query'=>[
			'client_key'=>$this->ck,
			'client_secret'=>$this->cs,
			'grant_type'=>'client_credential'

		]]);
		$responseData=$response->getBody()->getContents();
		$responseData=json_decode($responseData)->data;
		$error_code=$responseData->error_code;
		if($error_cdoe==0){
			return $responseData
		}
		throw new Exception('failed to get client_token');

	}
	/**
	 * 获取用户公开信息
	 * @param access_token
	 * @param open_id
	 * @return object
	 * @author 
	 **/
	public function user($access_token,$open_id)
	{
		$response=$this->client->get('/oauth/userinfo/',['query'=>[
			'access_token'=>$access_token,
			'open_id'=>$this->$open_id,

		]]);
		$responseData=$response->getBody()->getContents();
		$responseData=json_decode($responseData)->data;
		$error_code=$responseData->error_code;
		if($error_cdoe==0){
			return $responseData
		}
		throw new Exception('failed to get userinfo');

	}
	/**
	 * 获取粉丝列表
	 * @param access_token
	 * @param open_id
	 * @param count
	 * @return object
	 * @author 
	 **/
	public function fans($access_token,$open_id,$count=50)
	{
		$response=$this->client->get('/fans/list/',['query'=>[
			'access_token'=>$access_token,
			'open_id'=>$open_id,
			'count'=>$count

		]]);
		$responseData=$response->getBody()->getContents();
		$responseData=json_decode($responseData)->data;
		$error_code=$responseData->error_code;
		if($error_cdoe==0){
			return $responseData
		}
		throw new Exception('failed to get fans_list');

	}
	/**
	 * 获取关注列表
	 * @param access_token
	 * @param open_id
	 * @param count
	 * @return object
	 * @author 
	 **/
	public function follow($access_token,$open_id,$count=50)
	{
		$response=$this->client->get('/following/list/',['query'=>[
			'access_token'=>$access_token,
			'open_id'=>$open_id,
			'count'=>$count

		]]);
		$responseData=$response->getBody()->getContents();
		$responseData=json_decode($responseData)->data;
		$error_code=$responseData->error_code;
		if($error_cdoe==0){
			return $responseData
		}
		throw new Exception('failed to get following_list');

	}
	/**
	 * 获取粉丝统计数据
	 * @param access_token
	 * @param open_id
	 * @return object
	 * @author 
	 **/
	public function fansData($access_token,$open_id)
	{
		$response=$this->client->get('/fans/data/',['query'=>[
			'access_token'=>$access_token,
			'open_id'=>$open_id

		]]);
		$responseData=$response->getBody()->getContents();
		$responseData=json_decode($responseData)->data;
		$error_code=$responseData->error_code;
		if($error_cdoe==0){
			return $responseData
		}
		throw new Exception('failed to get fans_data');

	}
	/**
	 * 获取实时热点词
	 * @param client_token
	 * @return object
	 * @author 
	 **/
	public function hotWords($client_token)
	{
		$response=$this->client->get('/hotsearch/sentences/',['query'=>[
			'access_token'=>$client_token,

		]]);
		$responseData=$response->getBody()->getContents();
		$responseData=json_decode($responseData)->data;
		$error_code=$responseData->error_code;
		if($error_cdoe==0){
			return $responseData
		}
		throw new Exception('failed to get hot words');

	}
	/**
	 * 获取实时热点词
	 * @param client_token
	 * @return object
	 * @author 
	 **/
	public function hotVideo($client_token)
	{
		$response=$this->client->get('/hotsearch/videos/',['query'=>[
			'access_token'=>$client_token,

		]]);
		$responseData=$response->getBody()->getContents();
		$responseData=json_decode($responseData)->data;
		$error_code=$responseData->error_code;
		if($error_cdoe==0){
			return $responseData
		}
		throw new Exception('failed to get hot video');

	}
	/**
	 * POI搜索
	 * @param client_token
	 * @param keyword
	 * @param city
	 * @return object
	 * @author 
	 **/
	public function hotVideo($client_token,$keyword='美食',$city='北京')
	{
		$response=$this->client->get('/poi/search/keywords/',['query'=>[
			'access_token'=>$client_token,
			''

		]]);
		$responseData=$response->getBody()->getContents();
		$responseData=json_decode($responseData)->data;
		$error_code=$responseData->error_code;
		if($error_cdoe==0){
			return $responseData
		}
		throw new Exception('failed to get poi info');

	}

} 