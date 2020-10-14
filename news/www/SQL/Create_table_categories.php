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
CREATE TABLE  IF NOT EXISTS Categories(

id            INT NOT NULL PRIMARY KEY ,
title_ru      VARCHAR(256),
title_ua      VARCHAR(256),
title_en      VARCHAR(256)

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

$query=<<<SQL
INSERT INTO Categories VALUES
(1, 'Искусство', 'Мистецтво', 'Art'),
(2, 'Спорт', 'Спорт', 'Sport'),
(3, 'Криминал', 'Кримiнал', 'Crime'),
(4, 'События', 'Подii', 'Events')
SQL;

try{
	$DB->query( $query ) ;
} catch( Exception $ex ) {
	echo  $ex->getMessage(),"<BR>", $query ;
	exit ;
}
echo "<br>fill OK";