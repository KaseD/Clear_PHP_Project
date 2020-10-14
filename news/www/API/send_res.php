<?php
function send_result($status, $descr){
	echo json_encode([
	'status'=>$status,
	'descr'=>$descr
	], JSON_UNESCAPED_UNICODE );
	exit;
}