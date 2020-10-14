<?php
function ansread($sc){
	$rt = "";
	while($st = fgets($sc,254)){
		$rt .=$st."<br />";
		if(substr($st,3,1)==" ") break;
	}
	return $rt;
}

function send_mail($data){
$smtp_prot = "ssl";
$smtp_host = "smtp.ukr.net";
$smtp_port = "465";
$smtp_pass = ""; /*Удалено в связи с безопасностью*/
$smtp_user = ""; /*Удалено в связи с безопасностью*/

$smtp_context = array(
			'ssl'=>array(
					'verify_peer'=>false,
					'verify_peer_name'=>false
					)
			);
$smtp_box="proviryalovich@ukr.net";
	if(empty($data['to']))
		return ['code'=>-1,'txt'=>'need rcpt'];
	$from="default@i.ua";
	if(!empty($data['from']))
		$from=trim($data['from']);
	$stc = stream_context_create($smtp_context);
$s = stream_socket_client(
		$smtp_prot
		."://"
		.$smtp_host
		.":"
		.$smtp_port,
		$errno,
		$errstr,10,STREAM_CLIENT_CONNECT,
		$stc
	);
if(!$s){
	echo $errstr;
	exit;
}
$a = ansread($s);  //220 ISP UkrNet SMTP.in (frv155.fwdcdn.com) ESMTP Tue, 15 Oct 2019 18:30:02 +0300
echo $a,"<br />";
if(strpos($a,"220")===false){
	echo '-1';
	exit;
}

fputs($s,"EHLO Proviryalovich\r\n");
$a = ansread($s);
echo $a,"<br />";
	if(strpos($a,"250")===false){  
/*250-frv159.fwdcdn.com Hello nikstep.com.ua [217.77.221.65]
250-SIZE 26214400
250-8BITMIME
250-PIPELINING
250-AUTH PLAIN LOGIN
250 HELP*/
		echo '-2';
		exit;
	}

fputs($s,"AUTH LOGIN\r\n");
$a=ansread($s);
echo $a,"<br />";
	if(strpos($a,"334")===false){
		//334 VXNlcm5hbWU6
		echo '-3';
		exit;
	}
fputs($s,$smtp_user."\r\n");
$a = ansread($s);
echo $a,"<br />";
if(strpos($a,"334")===false){//334 UGFzc3dvcmQ6
	echo '-4';
	exit;
}
fputs($s,$smtp_pass."\r\n");
$a=ansread($s);
echo $a,"<br />";
if(strpos($a,"235")===false){//
	echo '-5';
	exit;
}
	$ml_date=date("D,J M Y H:i:s O");
	$ml_subj=$sbj;
	$ml_cmts = $cmnt;
	$ml_to=$to;
	
	$ml_body="Date : $ml_date\r\n";
	$ml_body.="From: Proviryalovich <$smtp_box>\r\n";
	$ml_body.="To: <$ml_to>\r\n";
	$ml_body.="Subject: $ml_subj\r\n";
	$ml_body.="Comments: $ml_cmts\r\n";
	$ml_body.="MIME-Version: 1.0\r\n";
	$ml_body.="Content-Type: multipart/mixed; boundary=\"slcubound\"\r\n";
	$ml_body.="\r\n";
	$ml_body.="This is a MIME formatted message. If you see this text it means that your\r\n";
	$ml_body.="email software does not support MIME formatted messages.\r\n";
	$ml_body.="\r\n";
	$ml_body.="--slcubound\r\n";
	
	$ml_body.="Content-Type: text/html; charset=UTF-8; format=flowed\r\n";
	$ml_body.="Content-Disposition: inline\r\n";
	$ml_body.="\r\n";
	$ml_body.="Нравиться наша россылка??
	<br />
	<a href=\"#\" style=\"background:lime;border: 1px solid #333;display: inline-block;padding: 5px 15px;text-decoration: none;color: #000;\">Yes</a>
	<a href=\"#\" style=\"background:red;border: 1px solid #333;display: inline-block;padding: 5px 15px;text-decoration: none;color: #000;\">No</a>
	\r\n";
	$ml_body.="\r\n";
	
	$ml_body.="--slcubound\r\n";
	$ml_body.="Content-Type: text/plain; charset=UTF-8; format=flowed\r\n";
	$ml_body.="Content-Disposition: inline\r\n";
	$ml_body.="\r\n";
	$ml_body.="$txtpart\r\n";
	$ml_body.="\r\n";
	
	$ml_body.="--slcubound\r\n";
	$ml_body.="Content-Type: image/jpeg; name=\"$fname\"\r\n";
	$ml_body.="Content-Transfer-Encoding: base64\r\n";
	$ml_body.="Content_Disposition: attachment; filename=\"$fname\";\r\n";
	$ml_body.="\r\n";
	$ml_body.=base64_encode(file_get_contents($fname));
	$ml_body.="\r\n";
	
	$ml_body.="--slcubound--\r\n";
	$ml_body.="\r\n";
	$ml_body.=".\r\n";
	
	fputs($s,"MAIL FROM: $smtp_box\r\n");
	$a=ansread($s);
echo $a,"<br />";
	if(strpos($a,"250")===false){
		echo '-6';
		exit;
	}
	
	fputs($s,"RCPT TO: $ml_to\r\n");
	$a2=ansread($s);
	echo $a2,"<br />";
		if(strpos($a2,"250")===false){
			echo '-7';
			exit;
		}
	fputs($s,"DATA\r\n");
	$a3=ansread($s);
	echo $a3,"<br />";
	if(strpos($a3,"354")===false){
		echo '-8';
		exit;
	}
	fputs($s,$ml_body);
	$a4=ansread($s);
	echo $a4,"<br />";
		if(strpos($a4,"250")===false){
			echo '-9';
			exit;
		}
		
	fputs($s,"QUIT\r\n");
	ansread($s);
	echo $a,"<br />";
	echo "Намыленно";
}

$to=""; /*Удалено в связи с безопасностью*/
$txtpart="Text part of letter";
$fname="updown.jpg";
$sbj="Изучаем SMTP";
$cmnt="Отправлено средствами PHP";


?>