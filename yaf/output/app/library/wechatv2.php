<?php
/**
 *	微信公众平台 官方API部分
 *  usage:
 *	 $weObj = new Wechat();
 *   $weObj->valid();
 *   $type = $weObj->getRev()->getRevType();
 *   switch($type) {
 *   		case Wechat::MSGTYPE_TEXT:
 *   			$weObj->text("hello, I'm wechat")->reply();
 *   			exit;
 *   			break;
 *   		case Wechat::MSGTYPE_EVENT:
 *   			....
 *   			break;
 *   		case Wechat::MSGTYPE_IMAGE:
 *   			...
 *   			break;
 *   		default:
 *   			$weObj->text("help info")->reply();
 *   }
 *   //获取菜单操作:
 *   $menu = $weObj->getMenu();
 *   //设置菜单
 *   $newmenu =  array(
 *   		"button"=>
 *   			array(
 *   				array('type'=>'click','name'=>'最新消息','key'=>'MENU_KEY_NEWS'),
 *   				array('type'=>'view','name'=>'我要搜索','url'=>'http://www.baidu.com'),
 *   				)
  *  		);
 *   $result = $weObj->createMenu($newmenu);
 */
class Wechat
{
	const MSGTYPE_TEXT = 'text';
	const MSGTYPE_IMAGE = 'image';
	const MSGTYPE_LOCATION = 'location';
	const MSGTYPE_LINK = 'link';
	const MSGTYPE_EVENT = 'event';
	const MSGTYPE_MUSIC = 'music';
	const MSGTYPE_NEWS = 'news';
	const MSGTYPE_VOICE = 'voice';
	const MSGTYPE_VIDEO = 'video';
	const API_URL_PREFIX = 'https://api.weixin.qq.com/cgi-bin';
	const AUTH_URL = '/token?grant_type=client_credential&';
	const MENU_CREATE_URL = '/menu/create?';
	const MENU_GET_URL = '/menu/get?';
	const MENU_DELETE_URL = '/menu/delete?';

	const MEDIA_GET_URL = '/media/get?';
    const MEDIA_UPLOAD_URL = '/cgi-bin/media/upload';
    const MEDIA_COUNT_URL = '/cgi-bin/material/get_materialcount';
    const MEDIA_ADD_NEWS_URL= '/cgi-bin/material/add_news';
    const MEDIA_UPDATE_NEWS_URL = '/cgi-bin/material/update_news';
    const MEDIA_DEL_URL = '/cgi-bin/material/del_material';
    const MEDIA_ADD_NEWS_IMG_URL = '/cgi-bin/media/uploadimg';
    const MEDIA_ADD_MATERIAL_URL = '/cgi-bin/material/add_material';
    const MEDIA_BATCHGET_MATERIAL_URL = '/cgi-bin/material/batchget_material';

    const SHORTURL = '/cgi-bin/shorturl';

	const QRCODE_CREATE_URL='/qrcode/create?';
    const MENU_CURRENT_SELFMENU_URL = '/get_current_selfmenu_info';
	const QR_SCENE = 0;
	const QR_LIMIT_SCENE = 1;
	const QRCODE_IMG_URL='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=';
	const USER_GET_URL='/user/get?';
	const USER_INFO_URL='/user/info?';
    const USER_BATCHGET_INFO_URL = '/user/info/batchget';
    const USER_UPDATEREMARK_URL = '/user/info/updateremark';

	const GROUP_GET_URL='/groups/get?';
    const GROUP_GETID_URL = '/cgi-bin/groups/getid';
    const GROUP_MEMBERS_BATCHUPDATE_URL = '/members/batchupdate';
    const GROUP_DEL_URL = '/groups/delete';
	const GROUP_CREATE_URL='/groups/create?';
	const GROUP_UPDATE_URL='/groups/update?';
	const GROUP_MEMBER_UPDATE_URL='/groups/members/update?';

    const DATASTAT_GETUSERSUMMARY_URL = '/datacube/getusersummary';
    const DATASTAT_GETUSERCUMULATE_URL = '/datacube/getusercumulate';
    const DATASTAT_GETARTICLESUMMARY_URL = '/datacube/getarticlesummary';
    const DATASTAT_GETARTICLETOTAL_URL = '/datacube/getarticletotal';
    const DATASTAT_GETUSERREAD_URL = '/datacube/getuserread';
    const DATASTAT_GETUSERREADHOUR_URL = '/datacube/getuserreadhour';
    const DATASTAT_GETUSERSHARE_URL= '/datacube/getusershare';
    const DATASTAT_GETUSERSHAREHOUR_URL ='/datacube/getusersharehour';
    const DATASTAT_GETUPSTREAMMSG_URL ='/datacube/getupstreammsg';
    const DATASTAT_GETUPSTREAMMSGHOUR_URL ='/datacube/getupstreammsghour';
    const DATASTAT_GETUPSTREAMMSGWEEK_URL ='/datacube/getupstreammsgweek';
    const DATASTAT_GETUPSTREAMMSGMONTH_URL ='/datacube/getupstreammsgmonth';
    const DATASTAT_GETUPSTREAMMSGDIST_URL ='/datacube/getupstreammsgdist';
    const DATASTAT_GETUPSTREAMMSGDISTWEEK_URL ='/datacube/getupstreammsgdistweek';
    const DATASTAT_GETUPSTREAMMSGDISTMONTH_URL ='/datacube/getupstreammsgdistmonth';
    const datastat_getinterfacesummary_URL = '/datacube/getinterfacesummary';

	const CUSTOM_SEND_URL='/message/custom/send?';
    const CUSTOM_SERVICE_USER_ADD_URL = '/customservice/kfaccount/add';
    const CUSTOM_SERVICE_USER_GET_URL = '/cgi-bin/customservice/getkflist';
    const CUSTOM_SERVICE_USER_OL_GET_URL = '/cgi-bin/customservice/getonlinekflist';
    const CUSTOM_SERVICE_USER_UPDATE_URL = '/customservice/kfaccount/update';
    const CUSTOM_SERVICE_USER_DEL_URL = '/customservice/kfaccount/del';
    const CUSTOM_SERVICE_USER_UPLOADHEADIMG_URL = '/customservice/kfaccount/uploadheadimg';

	const OAUTH_PREFIX = 'https://open.weixin.qq.com/connect/oauth2';
	const OAUTH_AUTHORIZE_URL = '/authorize?';
	const OAUTH_TOKEN_PREFIX = '/sns/oauth2';
	const OAUTH_TOKEN_URL = '/access_token?';
	const OAUTH_REFRESH_URL = '/refresh_token?';
	const OAUTH_USERINFO_URL = '/sns/userinfo?';

	//支付相关地址
	const PAY_DELIVERNOTIFY = '/pay/delivernotify?';
	const PAY_ORDERQUERY = '/pay/orderquery?';

    //现金红包
    const SENDREDPACK = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
    const GETHBINFO = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo';
    const SENDGROUPREDPACK = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack';
    //代金券
    const QUERY_COUPON_STOCK = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/query_coupon_stock';
    const SEND_COUPON = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/send_coupon';
    //企业付款
    const PROMOTION_TRANSFERS = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';

	private $token;
	private $appid;
	private $appsecret;
	private $access_token;
	private $user_token;
	private $partnerid;
	private $partnerkey;
	private $paysignkey;
	private $_msg;
	private $_funcflag = false;
	private $_receive;
	public $debug =  false;
	public $errCode = 40001;
	public $errMsg = "no access";
	private $_logcallback;

	public $_ci = '';

	public function __construct()
	{
	    $weichat_config = Yaf_Registry::get("config")->weichat_config->toArray();
		$this->token = $weichat_config['token'];
		$this->appid = $weichat_config['appid'];
		$this->appsecret = $weichat_config['appsecret'];
		$this->debug = $weichat_config['debug'] or false;
		$this->_logcallback = $weichat_config['logcallback'] or false;
		$this->partnerid  = $weichat_config['partnerid'];
		$this->partnerkey = $weichat_config['partnerkey'];
		$this->paysignkey = $weichat_config['paysignkey'];

	}

	/**
	 * For weixin server validation
	 */
	private function checkSignature()
	{
        $signature = isset($_GET["signature"])?$_GET["signature"]:'';
        $timestamp = isset($_GET["timestamp"])?$_GET["timestamp"]:'';
        $nonce = isset($_GET["nonce"])?$_GET["nonce"]:'';

		$token = $this->token;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * For weixin server validation
	 * @param bool $return 是否返回
	 */
	public function valid($return=false)
    {
        $echoStr = isset($_GET["echostr"]) ? $_GET["echostr"]: '';
        if ($return) {
        		if ($echoStr) {
        			if ($this->checkSignature())
        				return $echoStr;
        			else
        				return false;
        		} else
        			return $this->checkSignature();
        } else {
	        	if ($echoStr) {
	        		if ($this->checkSignature())
	        			die($echoStr);
	        		else
	        			die('no access');
	        	}  else {
	        		if ($this->checkSignature())
	        			return true;
	        		else
	        			die('no access');
	        	}
        }
        return false;
    }

	/**
	 * 设置发送消息
	 * @param array $msg 消息数组
	 * @param bool $append 是否在原消息数组追加
	 */
    public function Message($msg = '',$append = false){
    		if (is_null($msg)) {
    			$this->_msg =array();
    		}elseif (is_array($msg)) {
    			if ($append)
    				$this->_msg = array_merge($this->_msg,$msg);
    			else
    				$this->_msg = $msg;
    			return $this->_msg;
    		} else {
    			return $this->_msg;
    		}
    }

    public function setFuncFlag($flag) {
    		$this->_funcflag = $flag;
    		return $this;
    }

    private function log($log){
    		if ($this->debug && function_exists($this->_logcallback)) {
    			if (is_array($log)) $log = print_r($log,true);
    			error_log($log,3,APPPATH.'/logs/weixin_logcallback'.date('Y_m_d').'.log');
    		}
    }

    /**
     * 获取微信服务器发来的信息
     */
	public function getRev()
	{
		if ($this->_receive) return $this;
		$postStr = file_get_contents("php://input");
		$this->log($postStr);
		if (!empty($postStr)) {
			$this->_receive = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		}
		return $this;
	}

	/**
	 * 获取微信服务器发来的信息
	 */
	public function getRevData()
	{
		return $this->_receive;
	}

	/**
	 * 获取消息发送者
	 */
	public function getRevFrom() {
		if (isset($this->_receive['FromUserName']))
			return $this->_receive['FromUserName'];
		else
			return false;
	}

	/**
	 * 获取消息接受者
	 */
	public function getRevTo() {
		if (isset($this->_receive['ToUserName']))
			return $this->_receive['ToUserName'];
		else
			return false;
	}

	/**
	 * 获取接收消息的类型
	 */
	public function getRevType() {
		if (isset($this->_receive['MsgType']))
			return $this->_receive['MsgType'];
		else
			return false;
	}

	/**
	 * 获取消息ID
	 */
	public function getRevID() {
		if (isset($this->_receive['MsgId']))
			return $this->_receive['MsgId'];
		else
			return false;
	}

	/**
	 * 获取消息发送时间
	 */
	public function getRevCtime() {
		if (isset($this->_receive['CreateTime']))
			return $this->_receive['CreateTime'];
		else
			return false;
	}

	/**
	 * 获取接收消息内容正文
	 */
	public function getRevContent(){
		if (isset($this->_receive['Content']))
			return $this->_receive['Content'];
		else if (isset($this->_receive['Recognition'])) //获取语音识别文字内容，需申请开通
			return $this->_receive['Recognition'];
		else
			return false;
	}

	/**
	 * 获取接收消息图片
	 */
	public function getRevPic(){
		if (isset($this->_receive['PicUrl']))
			return $this->_receive['PicUrl'];
		else
			return false;
	}

	/**
	 * 获取接收消息链接
	 */
	public function getRevLink(){
		if (isset($this->_receive['Url'])){
			return array(
				'url'=>$this->_receive['Url'],
				'title'=>$this->_receive['Title'],
				'description'=>$this->_receive['Description']
			);
		} else
			return false;
	}

	/**
	 * 获取接收地理位置
	 */
	public function getRevGeo(){
		if (isset($this->_receive['Location_X'])){
			return array(
				'x'=>$this->_receive['Location_X'],
				'y'=>$this->_receive['Location_Y'],
				'scale'=>$this->_receive['Scale'],
				'label'=>$this->_receive['Label']
			);
		} else
			return false;
	}

	/**
	 * 获取接收事件推送
	 */
	public function getRevEvent(){
		if (isset($this->_receive['Event'])){
			return array(
				'event'=>$this->_receive['Event'],
				'key'=>$this->_receive['EventKey'],
			);
		} else
			return false;
	}

	/**
	 * 获取接收语言推送
	 */
	public function getRevVoice(){
		if (isset($this->_receive['MediaId'])){
			return array(
				'mediaid'=>$this->_receive['MediaId'],
				'format'=>$this->_receive['Format'],
			);
		} else
			return false;
	}

	/**
	 * 获取接收视频推送
	 */
	public function getRevVideo(){
		if (isset($this->_receive['MediaId'])){
			return array(
					'mediaid'=>$this->_receive['MediaId'],
					'thumbmediaid'=>$this->_receive['ThumbMediaId']
			);
		} else
			return false;
	}

	/**
	 * 获取接收TICKET
	 */
	public function getRevTicket(){
	if (isset($this->_receive['Ticket'])){
		return $this->_receive['Ticket'];
	} else
		return false;
    }

	public static function xmlSafeStr($str)
	{
		return '<![CDATA['.preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/",'',$str).']]>';
	}

	/**
	 * 数据XML编码
	 * @param mixed $data 数据
	 * @return string
	 */
	public static function data_to_xml($data) {
	    $xml = '';
	    foreach ($data as $key => $val) {
	        is_numeric($key) && $key = "item id=\"$key\"";
	        $xml    .=  "<$key>";
	        $xml    .=  ( is_array($val) || is_object($val)) ? self::data_to_xml($val)  : self::xmlSafeStr($val);
	        list($key, ) = explode(' ', $key);
	        $xml    .=  "</$key>";
	    }
	    return $xml;
	}

	/**
	 * XML编码
	 * @param mixed $data 数据
	 * @param string $root 根节点名
	 * @param string $item 数字索引的子节点名
	 * @param string $attr 根节点属性
	 * @param string $id   数字索引子节点key转换的属性名
	 * @param string $encoding 数据编码
	 * @return string
	*/
	public function xml_encode($data, $root='xml', $item='item', $attr='', $id='id', $encoding='utf-8') {
	    if(is_array($attr)){
	        $_attr = array();
	        foreach ($attr as $key => $value) {
	            $_attr[] = "{$key}=\"{$value}\"";
	        }
	        $attr = implode(' ', $_attr);
	    }
	    $attr   = trim($attr);
	    $attr   = empty($attr) ? '' : " {$attr}";
	    $xml   = "<{$root}{$attr}>";
	    $xml   .= self::data_to_xml($data, $item, $id);
	    $xml   .= "</{$root}>";
	    return $xml;
	}

	/**
	 * 设置回复消息
	 * Examle: $obj->text('hello')->reply();
	 * @param string $text
	 */
	public function text($text='')
	{
		$FuncFlag = $this->_funcflag ? 1 : 0;
		$msg = array(
			'ToUserName' => $this->getRevFrom(),
			'FromUserName'=>$this->getRevTo(),
			'MsgType'=>self::MSGTYPE_TEXT,
			'Content'=>$text,
			'CreateTime'=>time(),
			'FuncFlag'=>$FuncFlag
		);
		$this->Message($msg);
		return $this;
	}

	/**
	 * 设置回复音乐
	 * @param string $title
	 * @param string $desc
	 * @param string $musicurl
	 * @param string $hgmusicurl
	 */
	public function music($title,$desc,$musicurl,$hgmusicurl='') {
		$FuncFlag = $this->_funcflag ? 1 : 0;
		$msg = array(
			'ToUserName' => $this->getRevFrom(),
			'FromUserName'=>$this->getRevTo(),
			'CreateTime'=>time(),
			'MsgType'=>self::MSGTYPE_MUSIC,
			'Music'=>array(
				'Title'=>$title,
				'Description'=>$desc,
				'MusicUrl'=>$musicurl,
				'HQMusicUrl'=>$hgmusicurl
			),
			'FuncFlag'=>$FuncFlag
		);
		$this->Message($msg);
		return $this;
	}

	/**
	 * 设置回复图文
	 * @param array $newsData
	 * 数组结构:
	 *  array(
	 *  	[0]=>array(
	 *  		'Title'=>'msg title',
	 *  		'Description'=>'summary text',
	 *  		'PicUrl'=>'http://www.domain.com/1.jpg',
	 *  		'Url'=>'http://www.domain.com/1.html'
	 *  	),
	 *  	[1]=>....
	 *  )
	 */
	public function news($newsData=array())
	{
		$FuncFlag = $this->_funcflag ? 1 : 0;
		$count = count($newsData);

		$msg = array(
			'ToUserName' => $this->getRevFrom(),
			'FromUserName'=>$this->getRevTo(),
			'MsgType'=>self::MSGTYPE_NEWS,
			'CreateTime'=>time(),
			'ArticleCount'=>$count,
			'Articles'=>$newsData,
			'FuncFlag'=>$FuncFlag
		);
		$this->Message($msg);
		return $this;
	}

	/**
	 *
	 * 回复微信服务器, 此函数支持链式操作
	 * @example $this->text('msg tips')->reply();
	 * @param string $msg 要发送的信息, 默认取$this->_msg
	 * @param bool $return 是否返回信息而不抛出到浏览器 默认:否
	 */
	public function reply($msg=array(),$return = false)
	{
		if (empty($msg))
			$msg = $this->_msg;
		$xmldata=  $this->xml_encode($msg);
		$this->log($xmldata);
		if ($return)
			return $xmldata;
		else
			echo $xmldata;
	}


	/**
	 * GET 请求
	 * @param string $url
	 */
	private function http_get($url){
		$oCurl = curl_init();
		if(stripos($url,"https://")!==FALSE){
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
		}
		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if(intval($aStatus["http_code"])==200){
			return $sContent;
		}else{
			return false;
		}
	}

	/**
	 * POST 请求
	 * @param string $url
	 * @param array $param
	 * @return string content
	 */
	private function http_post($url,$param){
		$oCurl = curl_init();
		if(stripos($url,"https://")!==FALSE){
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
		}
		if (is_string($param)) {
			$strPOST = $param;
		} else {
			$aPOST = array();
			foreach($param as $key=>$val){
				$aPOST[] = $key."=".urlencode($val);
			}
			$strPOST =  join("&", $aPOST);
		}
		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($oCurl, CURLOPT_POST,true);
		curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if(intval($aStatus["http_code"])==200){
			return $sContent;
		}else{
			return false;
		}
	}

	/**
	 * 通用auth验证方法，暂时仅用于菜单更新操作
	 * @param string $appid
	 * @param string $appsecret
	 */
	public function checkAuth($appid='',$appsecret=''){
		if (!$appid || !$appsecret) {
			$appid = $this->appid;
			$appsecret = $this->appsecret;
		}
		//TODO: get the cache access_token
		$result = $this->http_get(self::API_URL_PREFIX.self::AUTH_URL.'appid='.$appid.'&secret='.$appsecret);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			$this->access_token = $json['access_token'];
			$expire = $json['expires_in'] ? intval($json['expires_in'])-100 : 3600;
			//TODO: cache access_token
			return $this->access_token;
		}
		return false;
	}

	/**
	 * 删除验证数据
	 * @param string $appid
	 */
	public function resetAuth($appid=''){
		$this->access_token = '';
		//TODO: remove cache
		return true;
	}

	/**
	 * 微信api不支持中文转义的json结构
	 * @param array $arr
	 */
	static function json_encode($arr) {
		$parts = array ();
		$is_list = false;
		//Find out if the given array is a numerical array
		$keys = array_keys ( $arr );
		$max_length = count ( $arr ) - 1;
		if (($keys [0] === 0) && ($keys [$max_length] === $max_length )) { //See if the first key is 0 and last key is length - 1
			$is_list = true;
			for($i = 0; $i < count ( $keys ); $i ++) { //See if each key correspondes to its position
				if ($i != $keys [$i]) { //A key fails at position check.
					$is_list = false; //It is an associative array.
					break;
				}
			}
		}
		foreach ( $arr as $key => $value ) {
			if (is_array ( $value )) { //Custom handling for arrays
				if ($is_list)
					$parts [] = self::json_encode ( $value ); /* :RECURSION: */
				else
					$parts [] = '"' . $key . '":' . self::json_encode ( $value ); /* :RECURSION: */
			} else {
				$str = '';
				if (! $is_list)
					$str = '"' . $key . '":';
				//Custom handling for multiple data types
				if (is_numeric ( $value ) && $value<2000000000)
					$str .= $value; //Numbers
				elseif ($value === false)
				$str .= 'false'; //The booleans
				elseif ($value === true)
				$str .= 'true';
				else
					$str .= '"' . addslashes ( $value ) . '"'; //All other things
				// :TODO: Is there any more datatype we should be in the lookout for? (Object?)
				$parts [] = $str;
			}
		}
		$json = implode ( ',', $parts );
		if ($is_list)
			return '[' . $json . ']'; //Return numerical JSON
		return '{' . $json . '}'; //Return associative JSON
	}

	/**
	 * 创建菜单
	 * @param array $data 菜单数组数据
	 * example:
	 {
	 "button":[
	 {
	 "type":"click",
	 "name":"今日歌曲",
	 "key":"MENU_KEY_MUSIC"
	 },
	 {
	 "type":"view",
	 "name":"歌手简介",
	 "url":"http://www.qq.com/"
	 },
	 {
	 "name":"菜单",
	 "sub_button":[
	 {
	 "type":"click",
	 "name":"hello word",
	 "key":"MENU_KEY_MENU"
	 },
	 {
	 "type":"click",
	 "name":"赞一下我们",
	 "key":"MENU_KEY_GOOD"
	 }]
	 }]
	 }
	 */
	public function createMenu($data){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::MENU_CREATE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	 * 获取菜单
	 * @return array('menu'=>array(....s))
	 */
	public function getMenu(){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::MENU_GET_URL.'access_token='.$this->access_token);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * 删除菜单
	 * @return boolean
	 */
	public function deleteMenu(){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::MENU_DELETE_URL.'access_token='.$this->access_token);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	 * 根据媒体文件ID获取媒体文件
	 * @param string $media_id 媒体文件id
	 * @return raw data
	 */
	public function getMedia($media_id){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::MEDIA_GET_URL.'access_token='.$this->access_token.'&media_id='.$media_id);
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * 创建二维码ticket
	 * @param int $scene_id 自定义追踪id
	 * @param int $type 0:临时二维码；1:永久二维码(此时expire参数无效)
	 * @param int $expire 临时二维码有效期，最大为1800秒
	 * @return array('ticket'=>'qrcode字串','expire_seconds'=>1800)
	 */
	public function getQRCode($scene_id,$type=0,$expire=1800){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$data = array(
			'action_name'=>$type?"QR_LIMIT_SCENE":"QR_SCENE",
			'expire_seconds'=>$expire,
			'action_info'=>array('scene'=>array('scene_id'=>$scene_id))
		);
		$result = $this->http_post(self::API_URL_PREFIX.self::QRCODE_CREATE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * 获取二维码图片
	 * @param string $ticket 传入由getQRCode方法生成的ticket参数
	 * @return string url 返回http地址
	 */
	public function getQRUrl($ticket) {
		return self::QRCODE_IMG_URL.$ticket;
	}

	/**
	 * 批量获取关注用户列表
	 * @param unknown $next_openid
	 */
	public function getUserList($next_openid=''){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::USER_GET_URL.'access_token='.$this->access_token.'&next_openid='.$next_openid);
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * 获取关注者详细信息
	 * @param string $openid
	 * @return array
	 */
	public function getUserInfo($openid){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::USER_INFO_URL.'access_token='.$this->access_token.'&openid='.$openid);
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * 获取用户分组列表
	 * @return boolean|array
	 */
	public function getGroup(){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::GROUP_GET_URL.'access_token='.$this->access_token);
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * 新增自定分组
	 * @param string $name 分组名称
	 * @return boolean|array
	 */
	public function createGroup($name){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$data = array(
				'group'=>array('name'=>$name)
		);
		$result = $this->http_post(self::API_URL_PREFIX.self::GROUP_CREATE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * 更改分组名称
	 * @param int $groupid 分组id
	 * @param string $name 分组名称
	 * @return boolean|array
	 */
	public function updateGroup($groupid,$name){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$data = array(
				'group'=>array('id'=>$groupid,'name'=>$name)
		);
		$result = $this->http_post(self::API_URL_PREFIX.self::GROUP_UPDATE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * 移动用户分组
	 * @param int $groupid 分组id
	 * @param string $openid 用户openid
	 * @return boolean|array
	 */
	public function updateGroupMembers($groupid,$openid){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$data = array(
				'openid'=>$openid,
				'to_groupid'=>$groupid
		);
		$result = $this->http_post(self::API_URL_PREFIX.self::GROUP_MEMBER_UPDATE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * 发送客服消息
	 * @param array $data 消息结构{"touser":"OPENID","msgtype":"news","news":{...}}
	 * @return boolean|array
	 */
	public function sendCustomMessage($data){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::CUSTOM_SEND_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * oauth 授权跳转接口
	 * @param string $callback 回调URI
	 * @return string
	 */
	public function getOauthRedirect($callback,$state='',$scope='snsapi_userinfo'){
		return self::OAUTH_PREFIX.self::OAUTH_AUTHORIZE_URL.'appid='.$this->appid.'&redirect_uri='.urlencode($callback).'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
	}

	/*
	 * 通过code获取Access Token
	 * @return array {access_token,expires_in,refresh_token,openid,scope}
	 */
	public function getOauthAccessToken(){
		$code = isset($_GET['code'])?$_GET['code']:'';
		if (!$code) return false;
		$result = $this->http_get(self::OAUTH_TOKEN_PREFIX.self::OAUTH_TOKEN_URL.'appid='.$this->appid.'&secret='.$this->appsecret.'&code='.$code.'&grant_type=authorization_code');
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			$this->user_token = $json['access_token'];
			return $json;
		}
		return false;
	}

	/**
	 * 刷新access token并续期
	 * @param string $refresh_token
	 * @return boolean|mixed
	 */
	public function getOauthRefreshToken($refresh_token){
		$result = $this->http_get(self::OAUTH_TOKEN_PREFIX.self::OAUTH_REFRESH_URL.'appid='.$this->appid.'&grant_type=refresh_token&refresh_token='.$refresh_token);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			$this->user_token = $json['access_token'];
			return $json;
		}
		return false;
	}

	/**
	 * 获取授权后的用户资料
	 * @param string $access_token
	 * @param string $openid
	 * @return array {openid,nickname,sex,province,city,country,headimgurl,privilege}
	 */
	public function getOauthUserinfo($access_token,$openid){
		$result = $this->http_get(self::OAUTH_USERINFO_URL.'access_token='.$access_token.'&openid='.$openid);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}


	/**
	 * 获取签名
	 * @param array $arrdata 签名数组
	 * @param string $method 签名方法
	 * @return boolean|string 签名值
	 */
	public function getSignature($arrdata,$method="sha1") {
		if (!function_exists($method)) return false;
		ksort($arrdata);
		$paramstring = "";
		foreach($arrdata as $key => $value)
		{
			if(strlen($paramstring) == 0)
				$paramstring .= $key . "=" . $value;
			else
				$paramstring .= "&" . $key . "=" . $value;
		}
		$paySign = $method($paramstring);
		return $paySign;
	}

	/**
	 * 生成随机字串
	 * @param number $length 长度，默认为16，最长为32字节
	 * @return string
	 */
	public function generateNonceStr($length=16){
		// 密码字符集，可任意添加你需要的字符
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for($i = 0; $i < $length; $i++)
		{
			$str .= $chars[mt_rand(0, strlen($chars) - 1)];
		}
		return $str;
	}

	/**
	 * 生成订单package字符串
	 * @param string $out_trade_no 必填，商户系统内部的订单号,32个字符内,确保在商户系统唯一
	 * @param string $body 必填，商品描述,128 字节以下
	 * @param int $total_fee 必填，订单总金额,单位为分
	 * @param string $notify_url 必填，支付完成通知回调接口，255 字节以内
	 * @param string $spbill_create_ip 必填，用户终端IP，IPV4字串，15字节内
	 * @param int $fee_type 必填，现金支付币种，默认1:人民币
	 * @param string $bank_type 必填，银行通道类型,默认WX
	 * @param string $input_charset 必填，传入参数字符编码，默认UTF-8，取值有UTF-8和GBK
	 * @param string $time_start 交易起始时间,订单生成时间,格式yyyyMMddHHmmss
	 * @param string $time_expire 交易结束时间,也是订单失效时间
	 * @param int $transport_fee 物流费用,单位为分
	 * @param int $product_fee 商品费用,单位为分,必须保证 transport_fee + product_fee=total_fee
	 * @param string $goods_tag 商品标记,优惠券时可能用到
	 * @param string $attach 附加数据，notify接口原样返回
	 * @return string
	 */
	public function createPackage($out_trade_no,$body,$total_fee,$notify_url,$spbill_create_ip,$fee_type=1,$bank_type="WX",$input_charset="UTF-8",$time_start="",$time_expire="",$transport_fee="",$product_fee="",$goods_tag="",$attach=""){
			$arrdata = array("bank_type" => $bank_type, "body" => $body, "partner" => $this->partnerid, "out_trade_no" => $out_trade_no, "total_fee" => $total_fee, "fee_type" => $fee_type, "notify_url" => $notify_url, "spbill_create_ip" => $spbill_create_ip, "input_charset" => $input_charset);
			if ($time_start)  $arrdata['time_start'] = $time_start;
			if ($time_expire)  $arrdata['time_expire'] = $time_expire;
			if ($transport_fee)  $arrdata['transport_fee'] = $transport_fee;
			if ($product_fee)  $arrdata['product_fee'] = $product_fee;
			if ($goods_tag)  $arrdata['goods_tag'] = $goods_tag;
			if ($attach)  $arrdata['attach'] = $attach;
			ksort($arrdata);
			$paramstring = "";
			foreach($arrdata as $key => $value)
			{
			if(strlen($paramstring) == 0)
				$paramstring .= $key . "=" . $value;
				else
				$paramstring .= "&" . $key . "=" . $value;
			}
			$stringSignTemp = $paramstring . "&key=" . $this->partnerkey;
			$signValue = strtoupper(md5($stringSignTemp));
			$package = http_build_query($arrdata) . "&sign=" . $signValue;
			return $package;
	}

	/**
	 * 支付签名(paySign)生成方法
	 * @param string $package 订单详情字串
	 * @param string $timeStamp 当前时间戳（需与JS输出的一致）
	 * @param string $nonceStr 随机串（需与JS输出的一致）
	 * @return string 返回签名字串
	 */
	public function getPaySign($package, $timeStamp, $nonceStr){
		$arrdata = array("appid" => $this->appid, "timestamp" => $timeStamp, "noncestr" => $nonceStr, "package" => $package, "appkey" => $this->paysignkey);
		$paySign = $this->getSignature($arrdata);
		return $paySign;
	}

	/**
	 * 回调通知签名验证
	 * @param array $orderxml 返回的orderXml的数组表示，留空则自动从post数据获取
	 * @return boolean
	 */
	public function checkOrderSignature($orderxml=''){
		if (!$orderxml) {
			$postStr = file_get_contents("php://input");
			if (!empty($postStr)) {
				$orderxml = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			} else return false;
		}
		$arrdata = array('appid'=>$orderxml['AppId'],'appkey'=>$this->paysignkey,'timestamp'=>$orderxml['TimeStamp'],'noncestr'=>$orderxml['NonceStr'],'openid'=>$orderxml['OpenId'],'issubscribe'=>$orderxml['IsSubscribe']);
		$paySign = $this->getSignature($arrdata);
		if ($paySign!=$orderxml['AppSignature']) return false;
		return true;
	}

	/**
	 * 发货通知
	 * @param string $openid 用户open_id
	 * @param string $transid 交易单号
	 * @param string $out_trade_no 第三方订单号
	 * @param int $status 0:发货失败；1:已发货
	 * @param string $msg 失败原因
	 * @return boolean|array
	 */
	public function sendPayDeliverNotify($openid,$transid,$out_trade_no,$status=1,$msg='ok'){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$postdata = array(
				"appid"=>$this->appid,
				"appkey"=>$this->paysignkey,
				"openid"=>$openid,
				"transid"=>strval($transid),
				"out_trade_no"=>strval($out_trade_no),
				"deliver_timestamp"=>strval(time()),
				"deliver_status"=>strval($status),
				"deliver_msg"=>$msg,
		);
		$postdata['app_signature'] = $this->getSignature($postdata);
		$postdata['sign_method'] = 'sha1';
		unset($postdata['appkey']);
		$result = $this->http_post(self::PAY_DELIVERNOTIFY.'access_token='.$this->access_token,self::json_encode($postdata));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/*
	 * 查询订单信息
	 * @param string $out_trade_no 订单号
	 * @return boolean|array
	 */
	public function getPayOrder($out_trade_no) {
		if (!$this->access_token && !$this->checkAuth()) return false;
		$sign = strtoupper(md5("out_trade_no=$out_trade_no&partner={$this->partnerid}&key={$this->partnerkey}"));
		$postdata = array(
				"appid"=>$this->appid,
				"appkey"=>$this->paysignkey,
				"package"=>"out_trade_no=$out_trade_no&partner={$this->partnerid}&sign=$sign",
				"timestamp"=>strval(time()),
		);
		$postdata['app_signature'] = $this->getSignature($postdata);
		$postdata['sign_method'] = 'sha1';
		unset($postdata['appkey']);
		$result = $this->http_post(self::PAY_ORDERQUERY.'access_token='.$this->access_token,self::json_encode($postdata));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'].json_encode($postdata);
				return false;
			}
			return $json["order_info"];
		}
		return false;
	}

	/**
	 * 获取收货地址JS的签名
	 * @param string $appId
	 * @param string $url
	 * @param int $timeStamp
	 * @param string $nonceStr
	 * @param string $user_token
	 * @return Ambigous <boolean, string>
	 */
	public function getAddrSign($url, $timeStamp, $nonceStr, $user_token=''){
		if (!$user_token) $user_token = $this->user_token;
		if (!$user_token) {
			$this->errMsg = 'no user access token found!';
			return false;
		}
		$url = htmlspecialchars_decode($url);
		$arrdata = array(
				'appid'=>$this->appid,
				'url'=>$url,
				'timestamp'=>strval($timeStamp),
				'noncestr'=>$nonceStr,
				'accesstoken'=>$user_token
		);
		return $this->getSignature($arrdata);
	}
}

