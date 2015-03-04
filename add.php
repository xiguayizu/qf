<?php

header("content-type:text/html;charset:utf-8");

require_once './class/sql.class.php';
 
$mysql = new MySQL('localhost','root','','leave');
/*
nickname 
email
	parentnickname
	parentid
	lev
content
需要从前台传入
*/

/*判断必要的值*/
if( empty($_POST['nickname']) ){
	echo json_encode( array('static'=>0, 'msg'=>'失败，请输入昵称') );
	return ;
}
if( empty($_POST['content']) ){
	echo json_encode( array('static'=>0, 'msg'=>'失败，请输入内容') );
	return ;
}
if( !empty($_POST['email']) ){
	$email = $_POST['email'];
	$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
	if(! preg_match( $pattern, $email ) ){
		echo json_encode( array('static'=>0, 'msg'=>'邮箱格式错误') );
		return ;
	}
}

$data = array(
	'nickname' => htmlspecialchars($_POST['nickname']),
	'email' => $_POST['email'],
	'addtime' => time(),
	'parentnickname' => empty($_POST['parentnickname']) ? 0 : htmlspecialchars($_POST['parentnickname']),
	'parentid' => empty($_POST['parentid']) ? '' : $_POST['parentid'] ,
	'isshow' => 0,
	'ispass' => 0, 
	// 'lev' => empty($_POST['lev']) ? 0 : $_POST['lev'] ,
	'content' => htmlspecialchars($_POST['content']),
	'addip' => getIPaddress()
);

/*写入*/
if( $mysql->data($data)->table('message')->add() ){
	echo json_encode( array('data'=> $data, 'static'=>1, 'msg'=>'成功') );
}else{
	echo json_encode( array('static'=>0, 'msg'=>'失败') );
}











/*获取真实ip*/
function getIPaddress(){
    $IPaddress='';
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $IPaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $IPaddress = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $IPaddress = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $IPaddress = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $IPaddress = getenv("HTTP_CLIENT_IP");
        } else {
            $IPaddress = getenv("REMOTE_ADDR");
        }
    }
    return $IPaddress;
}
