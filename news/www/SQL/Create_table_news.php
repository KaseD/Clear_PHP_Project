<?php
unset( $db_type ) ;
@include "../db_ini.php" ;
if( empty( $db_type ) ) {
	echo "Config load error";
	exit;
}
$conStr = "$db_type:host=$db_host;dbname=$db_name;charset=$db_enc;";
try{
	$DB = new PDO( $conStr, $db_user, $db_pass ) ;
	$DB->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ) ;
}
catch(PDOException $ex){
	echo"CONNECTION ERROR:",$ex->getMessage();
	exit;
}
echo "Connect OK <br/><br/>";

$query=<<<SQL
CREATE TABLE  IF NOT EXISTS News(

id            INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
title_ru      VARCHAR(256),
content_ru    TEXT,
image_file    VARCHAR(32),
is_active     TINYINT,
views_cnt     INT DEFAULT 0,
dt_create     DATETIME DEFAULT CURRENT_TIMESTAMP,
dt_edit       DATETIME,
id_category   INT,
id_author     INT,
id_importance INT

) engine=InnoDB default charset = utf8 collate=utf8_general_ci
SQL;



try{
	$DB->query($query);
}catch(Exception $ex)
{
	echo  $ex->getMessage(),"<BR>",$query;
	exit;
}
echo "<br>create OK";
