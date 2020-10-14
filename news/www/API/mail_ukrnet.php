<?php

function ansread( $sc ) {  // Получение ответа из сокета 
  $rt = "" ;
  while( $st = fgets( $sc, 254 ) ) {
    $rt .= $st . "<br/>" ;
    if( substr($st,3,1) == " " )  break; 
  }
  return $rt ;
}

include_once "send_res.php";

function send_mail( $data ) {
	/** Config **/
	$smtp_prot = "ssl";
	$smtp_host = "smtp.ukr.net";
	$smtp_port = "465";
	$smtp_pass = "UmF6cmFiMHRrYQ==";  // base64 from Razrab0tka
	$smtp_box  = "proviryalovich@ukr.net";
	$smtp_user = "cHJvdmlyeWFsb3ZpY2hAdWtyLm5ldA==";  // base64 from $smtp_box
	$smtp_context = array(
		'ssl' => array(
			'verify_peer'=> false, 
			'verify_peer_name' => false
		)
	);
	$to      = "denis37557@gmail.com";
	$txtpart = ( empty( $data[ 'content_ru' ] ) )
		? "Text part of letter"
		: $data[ 'content_ru' ] ;
	$fname   = ( empty( $data[ 'image_file' ] ) )
		? ""
		: "../" . $data[ 'image_file' ] ;
		
	$sbj     = ( empty( $data[ 'title_ru' ] ) )
		? "No subject"
		: $data[ 'title_ru' ] ;
		
	$cmnt    = "Отправлено средствами РНР";

	$stc = stream_context_create( $smtp_context ) ;
	$s = stream_socket_client(
		$smtp_prot
		. "://"
		. $smtp_host
		. ":"
		. $smtp_port,
		$errno,
		$errstr,
		10,
		STREAM_CLIENT_CONNECT,
		$stc
	) ;
	if( ! $s ) {  // Проверяем успещность открытия сокета
		send_result( -1, $errstr ) ;
	}
	// Считываем ответ - сбрасываем буфер обмена
	$a = ansread( $s ) ; if( strpos( $a, "220" ) === false )	send_result( -2, $a ) ;
	fputs( $s, "EHLO Proviryalovich\r\n" ) ;
	$a = ansread( $s ) ; if( strpos( $a, "250" ) === false )	send_result( -3, $a ) ;
	fputs( $s, "AUTH LOGIN\r\n" ) ;
	$a = ansread( $s ) ; if( strpos( $a, "334" ) === false )	send_result( -4, $a ) ;
	fputs( $s, $smtp_user . "\r\n" ) ;
	$a = ansread( $s ) ; if( strpos( $a, "334" ) === false )	send_result( -5, $a ) ;
	fputs( $s, $smtp_pass . "\r\n" ) ;
	$a = ansread( $s ) ; if( strpos( $a, "235" ) === false )	send_result( -6, $a ) ;
	
	//Формируем письмо
	$ml_date = date("D, j M Y H:i:s O");  // Дата для заголовка по RFC2822
	$ml_subj = $sbj ;  // Тема письма
	$ml_cmts = $cmnt;  // Комментарии для заголовков
	$ml_to   = $to;    // Адрессат
    
	$ml_body  = "Date: $ml_date\r\n";
    $ml_body .= "From: Proviryalovich <$smtp_box>\r\n";
    $ml_body .= "To: <$ml_to>\r\n";
    $ml_body .= "Subject: $ml_subj\r\n";
    $ml_body .= "Comments: $ml_cmts\r\n";
    $ml_body .= "MIME-Version: 1.0\r\n";
    $ml_body .= "Content-Type: multipart/mixed; boundary=\"c30steplocal\"\r\n";
    $ml_body .= "\r\n";
    $ml_body .= "This is a MIME formatted message.  If you see this text it means that your\r\n";
    $ml_body .= "email software does not support MIME formatted messages.\r\n";
    $ml_body .= "\r\n";
	
	// text part
    $ml_body .= "--c30steplocal\r\n";
    $ml_body .= "Content-Type: text/plain; charset=UTF-8; format=flowed\r\n";
    $ml_body .= "Content-Disposition: inline\r\n";
    $ml_body .= "\r\n";
    $ml_body .= "$txtpart\r\n";
    $ml_body .= "\r\n";
	
	if( ! empty( $fname ) ) {
		//file part
		$ml_body .= "--c30steplocal\r\n";
		$ml_body .= "Content-Type: image/jpeg; name=\"$fname\"\r\n";
		$ml_body .= "Content-Transfer-Encoding: base64\r\n";
		$ml_body .= "Content-Disposition: attachment; filename=\"$fname\";\r\n";
		$ml_body .= "\r\n";
		$ml_body .= base64_encode(file_get_contents($fname));
		$ml_body .= "\r\n";
	}
    //final part
    $ml_body .= "--c30steplocal--\r\n";
    $ml_body .= "\r\n";
    $ml_body .= ".\r\n";
	
	fputs($s,"MAIL FROM: $smtp_box\r\n");
	$a = ansread( $s ) ; if( strpos( $a, "250" ) === false )	send_result( -7, $a ) ;
	fputs($s,"RCPT TO: $ml_to\r\n");
	$a = ansread( $s ) ; if( strpos( $a, "250" ) === false )	send_result( -8, $a ) ;
	fputs($s,"DATA\r\n");
	$a = ansread( $s ) ; if( strpos( $a, "354" ) === false )	send_result( -9, $a ) ;
	fputs($s,$ml_body);
	$a = ansread( $s ) ; if( strpos( $a, "250" ) === false )	send_result( -9, $a ) ;
	fputs($s,"QUIT\r\n");  ansread($s);  send_result( 1, $a ) ;
}