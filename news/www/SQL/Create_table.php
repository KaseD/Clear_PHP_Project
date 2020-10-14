<?php
	unset($db_type);
	@include "../db_ini.php";
	if(empty($db_type)){
		echo "Config load error";
		exit;
	}
	$conStr = "$db_type:host=$db_host;dbname=$db_name;charset=$db_enc;";
try{
	$DB=new PDO($conStr, $db_user, $db_pass);
	$DB ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $ex){
	echo"CONNECTION ERROR:",$ex->getMessage();
	exit;
}
echo "YOU ARE IN! <br/><br/>";

$query=<<<SQL
CREATE TABLE  IF NOT EXISTS Users(
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
firstname VARCHAR(32),
lastname VARCHAR(32),
surname VARCHAR(32),
login VARCHAR(32),
pass_hash CHAR(64),
pass_salt CHAR(32),
registered DATETIME DEFAULT CURRENT_TIMESTAMP,
lastlogin DATETIME ,
role INT,
avatar VARCHAR(32)
) engine=InnoDB default charset = utf8 collate=utf8_general_ci
SQL;



try{ $DB->query($query);
}catch(Exception $ex)
{
	echo  $ex->getMessage(),"<BR>",$query;
	exit;
}
echo "<br>Query OK";

$salt = md5(rand());
$hash = md5('123'.$salt);

$query=<<<SQL
INSERT INTO Users(firstname,lastname,surname,login,pass_hash,pass_salt,role,avatar)
VALUES('Захар','Петрович','Кузнецов','admin','$hash','$salt',1,'avatar.jpg'),
	  ('Иван','Сидорович','Стрельцов','manager','$hash','$salt',2,'avatar2.jpg'),
	  ('Кристина','Олеговна','Незнайка','бухгалтер','$hash','$salt',3,'avatar3.jpg'),
	  ('Николай','Петрович','Иванин','консультант','$hash','$salt',4,'avatar4.jpg')
SQL;

try{ $DB->query($query);
}catch(Exception $ex)
{
	echo  $ex->getMessage(),"<BR>",$query;
	exit;
}
echo "<br>Insert successful";


