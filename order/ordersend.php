<?php
class put_client{
	public $posturl = 'http://www.jiandaocps.com/order_xsite.php';
	var $isGBK=true;
	var $char = null;
	public function __construct($char) {
        $this->isGBK = strlen($char) < 3 ? TRUE : FALSE;
		$this->char = $char;
    }
	
	function build_data($postdata){
		$fields = array('order_no','pname','money','clientName','address');
		foreach($fields as $k){
			if(!isset($postdata[$k])){
				return -1;
			}
		}
		if($this->isGBK){
			foreach($postdata as $k => $v){
				$postdata[$k] = iconv('gbk','utf-8',$v);
			}
		}
		$postdata['time'] = time();
		$postdata['token'] = md5($postdata['time'].'tokenCode');
		$data = serialize($postdata);		
		return base64_encode($data);
	} 
	
	function parse_data($data){
		return  unserialize(base64_decode($data));
	}
	
}
?>