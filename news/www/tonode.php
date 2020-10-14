<?php
$s = stream_socket_client('tcp://10.6.6.22:8088', $e, $t);
if(!$s){
	echo $t;
	exit;
}

fwrite( $s,"GET /API/getRandom HTTP/1.1\r\nHost: localhost\r\n\r\n");
$res = fgets($s);
if(strpos($res,'HTTP') !=-1){
	do{
		$res=fgets($s);
	}while($res != "\r\n");
}
while(!feof($s)){
	$res .=fgets($s);
}
$data = json_decode($res);
echo <<<HTML
$data->rnd
<img src="/404.php" />
HTML;
