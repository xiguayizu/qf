<?php


if( empty($_GET['ca']) ){
	header('HTTP/1.1 404 Not Found'); 
	header('status: 404 Not Found');
print<<<EOF
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL /qf/admin/admin was not found on this server.</p>
</body></html>
EOF;
	exit();
}
#+----------------------------------------------------------+----------------------------------------------------------处理事物  start
if($_GET['ca']=='edit'){
	include "../class/sql.class.php";
	$mysql = new MySQL('localhost','root','','leave');

	$mysql->table('message')->data(array('isshow'=>'1', 'ispass'=>$_POST['action']))->where('id in ('.$_POST['dataJson'].')')->update();
	// print_r( $_POST['action'] );	
	return ;
}
#+----------------------------------------------------------+----------------------------------------------------------处理事物  end
header("Content-type:text/html;charset=utf-8");
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
   <title>后台列表</title>
   <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
   <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
   <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
   <style>
	.list-group-item{
		position: relative;
	}

	.list-group-item .button{
		position: absolute;
		right: 50px;
		top: 20px;
	}

	.selction{
		position: absolute;
		left: 5px;
		top: 20px;
		width:20px; height:20px; padding:0px; font-size:5px;
	}
	.nickname{
		color: #08c;
		text-decoration: underline;
	}
   </style>
</head>
<body>

	
	<div class="list-group">
	   <a href="#" class="list-group-item active">
	      <h4 class="list-group-item-heading">
	         留言管理
	      </h4>
	   </a>

<?php
include "../class/sql.class.php";
$mysql = new MySQL('localhost','root','','leave');
$source = $mysql->table('message')->where('isshow=0')->select();

foreach( $source as $k => $v ){
print 	'<a href="#" class="list-group-item item-a" data-id="'.$v['id'].'">';
		print			'<div><button class="everyAction btn btn-default btn-lg selction" data-id="'.$v['id'].'">选中</button>';
	if($v['parentid'] == 0){
		print			'<h4 class="list-group-item-heading" style="padding-left:20px;">-'.$v['id'].'--<span class="nickname">'.$v['nickname'].'</span> 说 &nbsp;&nbsp;&nbsp; <span style="font-size:12px;">来源：'.$v['addip'].'</span> </h4>';
	}else{
		print			'<h4 class="list-group-item-heading" style="padding-left:20px;">-'.$v['id'].'--<span class="nickname">'.$v['nickname'].'</span> 对 <span class="nickname">'.$v['parentnickname'].'</span> 说 &nbsp;&nbsp;&nbsp; <span style="font-size:12px;">来源：'.$v['addip'].'</span> </h4>';		
	}
print	'<p class="list-group-item-text" style="padding-left:40px;">'.$v['content'].'</p>';
print 	'<p class="button"><button class="btn btn-success success-sigle" data-id="'.$v['id'].'">通过</button><button class="btn btn-danger danger-sigle" data-id="'.$v['id'].'">不通过</button></p></div></a>';
}
?>

	</div>

	<button id="allAction">全选</button>
	<button id="reAction">反选</button>
   <button class="btn btn-success success-sel">选中-通过</button>
   <button class="btn btn-danger success-sel">选中-不通过</button>
<div style="height:40px;"></div>



<script>
$(function(){
	/*全选*/
	$("#allAction").click(function(){
		$(".everyAction").each(function(){
			$(this).addClass('active');
		});
	});
	/*反选*/
	$("#reAction").click(function(){
		$(".everyAction").each(function(){
			if( $(this).hasClass('active') ){
				$(this).removeClass('active');
			}else{
				$(this).addClass('active');
			}
		});
	});
	/*添加每一行的事件*/
	$(".item-a").each(function(){
		$(this).click(function(){
			var everyEle = $(this).find('.everyAction');
			if( everyEle.hasClass('active') ){
				everyEle.removeClass('active');
			}else{
				everyEle.addClass('active');
			}
			return false;
		});
	});
	/*点击每一行的通过*/
	$(".success-sigle").each(function(){
		$(this).click(function(event){
			event.stopPropagation();
			editAction( $(this).attr('data-id'), 1 );
			$(this).parent().parent().parent().slideUp('fast');
			return false;
		});	
	});
	$(".danger-sigle").each(function(){
		$(this).click(function(event){
			event.stopPropagation();
			editAction( $(this).attr('data-id'), 0 );
			$(this).parent().parent().parent().slideUp('fast');
			return false;
		});	
	});


	/*点击选中的元素的时候*/
	$(".success-sel").click(function(){
		// 获取所选中的
		editAction( getSelEle(), 1 )
		return false;
	});
	/*点击选中的元素的时候*/
	$(".danger-sel").click(function(){
		// 获取所选中的
		editAction( getSelEle(), 0 )
		return false;
	});


	/*	
	return x,x,x格式
	*/
	var numSel = new Array();
	function getSelEle(){
		var numArr = new Array();
		$(".everyAction").each(function(){
			if( $(this).hasClass('active') ){
				numSel.push( $(this).parent().parent() );
				numArr.push( $(this).attr('data-id') );
			}
		});
		return numArr;
	}
	/*
		dataJson 传入的元素数组
		pass = 1 通过
			 = 0 失败
	*/
	function editAction( dataJson, pass ){
		
		// console.log( 'ajax:'+ dataJson +':'+pass );
		$.ajax({
			url: './admin.php?ca=edit',
			type: 'POST',
			// dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
			data: "dataJson="+dataJson+"&action="+pass,
		})
		.done(function(msg) {
			console.log("success");
			console.log(msg);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function(msg) {
			console.log("complete");
			console.log(msg);
		});
		
		
		for( row in numSel ){
			numSel[row].slideUp('fast');
		}
		delete numSel;
	}
});
</script>
</body>
</html>	











