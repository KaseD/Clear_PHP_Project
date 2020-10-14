<?php

class User{
    public $id;
    public $first_name;
    public $last_name;
    public $surname;
    public $login;
    public $pass_hash;
    public $pass_salt;
    public $registered_time;
    public $last_login;
    public $role;
    public $avatar;
    public $email;
	
	function deletfile($filename)
	{
		$directory = $_SERVER['DOCUMENT_ROOT']."/uploads";
	  // открываем директорию (получаем дескриптор директории)
	  $dir = opendir($directory);
	  
	  // считываем содержание директории
	while(($file = readdir($dir)))
	{
			  // Если это файл и он равен удаляемому ...
	  if((is_file("$directory/$file")) && ("$directory/$file" == "$directory/$filename"))
	  {
		// ...удаляем его.
		unlink("$directory/$file");
					  
		 // Если файла нет по запрошенному пути, возвращаем TRUE - значит файл удалён.
		if(!file_exists($directory."/".$filename)) return $s = TRUE;
	  }
	}
	  // Закрываем дескриптор директории.
	  closedir($dir);
	}
	
	function load_from_array( $data ) {
		if( ! is_array( $data ) ) return false ;
		if( isset( $data['first_name'] ) ) $this->first_name = $data['first_name'];
		if( isset( $data['last_name']  ) ) $this->last_name  = $data['last_name'];
		if( isset( $data['surname']    ) ) $this->surname    = $data['surname'];
		if( isset( $data['login']      ) ) $this->login      = $data['login'];
		if( isset( $data['pass_hash']  ) ) $this->pass_hash  = $data['pass_hash'];
		if( isset( $data['pass_salt']  ) ) $this->pass_salt  = $data['pass_salt'];
		if( isset( $data['avatar']	   ) ) $this->avatar     = $data['avatar'];			
		if( isset( $data['email']	   ) ) $this->email      = $data['email'];			
		if( isset( $data['role']	   ) ) $this->role       = $data['role'];			
	}
	
	function update( $data = null ) {
		if( empty( $this->DB ) ) return false ;
		
		if( is_array( $data ) ) {
			$this->load_from_array( $data ) ;
		}
		return $this->DB->query( 
			"UPDATE Users SET 
			firstname = '" . $this->first_name . "',
			lastname  = '" . $this->last_name  . "',
			surname   = '" . $this->surname    . "',
			role      = "  . $this->role       . ",
			avatar    = '" . $this->avatar    . "'
			WHERE id  = "  . $this->id 
		) ;
		
	}
	
	function profile_upd($data = null){
		if( empty( $this->DB ) ) return false ;
		
		if( is_array( $data ) ) {
			$this->load_from_array( $data ) ;
		}
		return $this->DB->query( 
			"UPDATE Users SET 
			firstname = '" . $this->first_name . "',
			lastname  = '" . $this->last_name  . "',
			surname   = '" . $this->surname    . "',
			avatar    = '" . $this->avatar    . "',
			login    = '" . $this->login    . "',
			mail    = '" . $this->email    . "'
			WHERE id  = "  . $this->id 
		) ;
	}
	
	function update_last_login( ) {
		if( empty( $this->DB ) ) return false ;
		if( empty( $this->id ) ) return false ;
		return $this->DB->query( 
			"update Users set last_login = current_timestamp where id = " . $this->id 
		) ;
	}
	
	function register_user( $data = null ) {
		
        if( empty( $this->DB ) ) return false ;
		
		if( is_array( $data ) ) {
			$this->load_from_array( $data )	;
		}
		$sql = "INSERT INTO Users( 
			firstname, lastname, surname, login, pass_hash, pass_salt, registered, role, avatar, mail )
		VALUES( ?,        ?,        ?,      ?,       ?,         ?, CURRENT_TIMESTAMP, 1,    ?,     ?   )" ;
			
		$prepared = $this->DB->prepare( $sql ) ;
		
		// Вносим данные из полей объекта
		$prepared->execute( [
			$this->first_name,
		    $this->last_name ,
		    $this->surname   ,
		    $this->login     ,
		    $this->pass_hash ,
		    $this->pass_salt ,
		    $this->avatar    ,   
		    $this->email    
		] ) ;
	}

    function __construct($dbLink = null){
        if($dbLink == null){
            unset($db_type);
            include $_SERVER["DOCUMENT_ROOT"]."/db_ini.php";
            if(empty($db_type)){
                echo"Config load error";
                exit;
            }
            
            $conStr = "$db_type:host=$db_host;dbname=$db_name;charset=$db_enc;";
            
            try{
                $this->DB = new PDO($conStr, $db_user, $db_pass);
                $this->DB ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $ex){
                throw $ex;
            }

        }
        else{
            $this->DB = $dbLink;
        }
    }

    function isLoginFree($login){
        if(empty($login)) return false;

        $query = "SELECT COUNT(ID) FROM Users
                  WHERE login = '$login'";
        $answer = $this->DB->query($query);
        $n = ($answer->fetch(PDO::FETCH_NUM))[0];
        return $n == 0;
    }

    function isAuthorized($login, $pass){
        if(empty($this->DB)) return false;
        
        $query = "SELECT * FROM Users WHERE login = '$login'";
        $answer = $this->DB->query($query);

        $userdata = $answer->fetch(PDO::FETCH_ASSOC);
        if(empty($userdata)){
            return false;
        }

        if( hash( 'SHA256', $pass . $userdata['pass_salt'] ) 
			!= $userdata['pass_hash']
		) {
            return false;
        }
		
		$this->id = $userdata['id'];
        
		return true ;


        /*
        
        
        var_dump($answer);
		*/

    }
	
	function loadUserDataById( $id ) {
		if( empty( $this->DB ) ) return false ;
		if( empty( $id ) ) return false ;
		$res = $this->DB->query( 
			"SELECT * FROM Users WHERE id = " . $id
		) ;
		$row = $res->fetch( PDO::FETCH_ASSOC ) ;
		if( empty( $row ) ) return false ;
		
		$this->first_name 		= $row['firstname'];
        $this->last_name		= $row['lastname'];
        $this->surname 			= $row['surname'];
        $this->login 			= $row['login'];
        $this->registered_time 	= $row['registered'];
        $this->last_login 		= $row['last_login'];
        $this->role 			= $row['role'];
        $this->avatar 			= $row['avatar'];
        $this->email 			= $row['mail'];
		
		$this->id = $id ;
		
		return true ;
	}

};

// $user = new User();
// var_dump($user->isLoginFree("name"));




