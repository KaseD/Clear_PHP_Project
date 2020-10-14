<?php
$s = stream_socket_client("tcp://192.168.88.21:80",$err_code,$err_text);

if(!empty($err_code)){
	echo "ERROR: ",$err_txt;
	exit;
}

fwrite($s,"POST https://www.google.com/webhp HTTP/1.1\r\nHost: 192.168.88.21\r\n\r\n");

echo "<plaintext>";

while($line = fgets($s,1024)){
	echo $line;
}
