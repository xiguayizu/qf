<?php
header("content-type:text/html;charset:utf-8");
 
require_once 'sql.class.php';
 
$mysql = new MySQL('localhost','root','','leave');



$sou = $mysql->table('message')->select();


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





exit;
# echo json_encode($mysql->table('message')->select());


$sou = $mysql->table('message')->select();
print_r($sou);

$ar = array();



while( $v=current($sou) ){
	if( $v['parentid'] != 0 ){
		continue;
	}

	next($sou);
}

// print_r($ar);
exit;

while ( !empty($sou) ) {
	if( $sou[0]['parentid'] != 0 ){
		echo $sou[0]['parentid'];
		continue;
	}
	$tmpvar = $ar[] = array_pop($sou);
	// print_r( $sou );
	foreach ($sou as $k => $v) {
		// echo $v['path'],'|||' ,$tmpvar['id'].'-', '<br>';

		if ( strpos($v['path'], $tmpvar['id'].'-') !== false ) {
			$ar[] = array_pop($sou);
		}
	}
}









exit;

echo '<pre>';
//获取表字段
//print_r($mysql->getFields('test'));
//增
echo $mysql->data(array('nickname'=>'test','addtime'=>'123456'))->table('message')->add();
exit;
//删
echo $mysql->table('test')->where('id=1')->delete();
//改
echo $mysql->table('test')->data(array('name'=>'bbbbbbbbbbbb'))->where('id<3')->update();
//查
print_r($mysql->table('test')->where('id=4')->select());
print_r($mysql->table('test')->order('id desc')->select());
 
//
$mysql->query('select * from `test`');
$mysql->execute('update `test` set password = 123');
 
echo '</pre>';
echo '查询次数:'.$mysql->query_count.'<br>';
echo '查询时间:'.number_format(microtime(true)-($mysql->query_start_time),10).' 秒<br>';
echo '错误信息:'.$mysql->error().'<br>';