<?php

header("content-type:text/html;charset:utf-8");
 
require_once './class/sql.class.php';
 
$mysql = new MySQL('localhost','root','','leave');



// $sou = $mysql->table('message')->where(' isshow=1 and ispass=1 ')->select();

$sou = $mysql->query( ' SELECT id,nickname,addtime,parentnickname,parentid,content FROM message where isshow=1 and ispass=1 ' );

function subtree( $arr, $pid, $lev = 1 ){
	static $sons = array();
	foreach ( $arr as $k => $v ){
		if( $v['parentid'] == $pid ) {
			$v['lev'] = $lev;
			$sons[] = $v;  # [$v['id']]
			subtree( $arr, $v['id'], $lev+1 );
		}
	}
	return $sons;
}

echo json_encode( subtree( $sou, 0, 1 ) );





