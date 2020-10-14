<?php

function view( ) {
	global $msg ;
	include "reg_view.php" ;
	exit ;
}

session_start( ) ;
//echo "TEst";
//var_dump($_POST);
if( ! empty( $_POST ) ) {	
	$msg = "" ;
	//echo $msg;
	if( empty( $_POST[ 'login' ] ) ) {
		$msg = "Логин не может быть пустым" ;
		view( ) ;
	} else $_SESSION[ 'login' ] = $_POST[ 'login' ] ;
			
	if( empty( $_POST[ 'name' ] ) ) {
		$msg = "Имя не может быть пустым" ;
		view( ) ;
	} else $_SESSION[ 'name' ]  = $_POST[ 'name' ]  ;
	
	if( empty( $_POST[ 'secname' ] ) ) {
		$msg = "Отчество не может быть пустым" ;
		view( ) ;
	} else $_SESSION[ 'secname' ]  = $_POST[ 'secname' ]  ;
	
	if( empty( $_POST[ 'surname' ] ) ) {
		$msg = "Фамилия не может быть пустой" ;
		view( ) ;
	} else $_SESSION[ 'surname' ]  = $_POST[ 'surname' ]  ;
	
	if( empty( $_POST[ 'pass' ] ) ) {
		$msg = "Пароль не может быть пустым" ;
		view( ) ;
	} else if( strlen( $_POST[ 'pass' ] ) < 5 ) {
		$msg = "Пароль слишком короткий (5 символов как минимум)" ;
		view( ) ;
	} else if( ! preg_match( "~\d~", $_POST[ 'pass' ] ) ) {
		$msg = "Пароль должен содержать цифру" ;
		view( ) ;
	} else if( ! preg_match( "~\D~", $_POST[ 'pass' ] ) ) {
		$msg = "Пароль не должен состоять только из цифр" ;
		view( ) ;
	} else if( ! preg_match( "~^.*\W.*$~", $_POST[ 'pass' ] ) ) {
		$msg = "Пароль должен содержать спецсимвол (!\"№;%:)" ;
		view( ) ;
	}
	
	if( $_POST[ 'pass' ] !== $_POST[ 'pass2' ] ) {
		$msg = "Пароли не совпадают" ;
		view( ) ;
	}
	
	if( empty( $_POST[ 'email' ] ) ) {
		$msg = "Укажите эл. почту" ;
		view( ) ;
	} else {
		$_SESSION[ 'email' ] = $_POST[ 'email' ] ;
		if( ! preg_match( "~^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$~", $_POST[ 'email' ] ) ) {
			$msg = "Укажите валидную эл. почту" ;
			view( ) ;
		}
	}
	
	@include "classes/user.php" ;

	if( ! class_exists( "User" ) ) {
		$msg = "User.php load error" ;
		view( ) ;
	} 

	try {
		$user = new User( ) ;
		$login_free = $user->isLoginFree( $_POST[ 'login' ] ) ;
	} catch( Exception $ex ) {
		$msg = $ex->getMessage( ) ;
		view( ) ;
	}
	
	if( ! $login_free ) {
		$msg = "Логин уже используется другим пользователем" ;
		view( ) ;
	}
	
// echo "<pre>";print_r($_FILES); exit;	
	//var_dump($_FILES)
	if( empty( $_FILES[ 'ava' ][ 'name' ] ) ) {
		$fname = "non-ava.jpg" ;
		view( ) ;
	} else if( $_FILES[ 'ava' ][ 'error' ] != 0 ) {
		$msg = "Возникли проблемы с загрузкой файла (возможно, превышен размер)" ;
		view( ) ;
	} else {
		$fname = 
			$_POST[ 'login' ] 
			. "_ava." 
			. strtolower( pathinfo( $_FILES[ 'ava' ][ 'name' ], PATHINFO_EXTENSION ) ) ;
		$move_status = move_uploaded_file(
			$_FILES[ 'ava' ][ 'tmp_name' ], 
			"uploads/" . $fname
		) ;
		if( $move_status === false ) {
			$msg = "Возникли проблемы с сохранением файла" ;
			view( ) ;
		} 
	}
	
	if( empty( $msg ) ) {
		//echo "Данные приняты, хеш пароля ";
		$salt = md5( rand( ) ) ;
		$pass = hash( 
			'SHA256', 
			$_POST[ 'pass' ] . $salt 
		) ;
	
		$user_data = [
			'first_name' => $_POST[ 'name' ] ,
			'last_name'  => $_POST[ 'secname' ],
			'surname'    => $_POST[ 'surname' ],
			'login'      => $_POST[ 'login' ],
			'pass_hash'  => $pass,
			'pass_salt'  => $salt,
			'avatar'     => $fname,
			'email'      => $_POST[ 'email' ]
		] ;
		
		try {
			$user->register_user( $user_data ) ;
		} catch( Exception $ex ) {
			$msg = $ex->getMessage( ) ;
			view( ) ;
		}
		
		echo "<script>setInterval(
				()=>{
					var v=countdown.innerText-1;
					if(v<0)window.location='/';
					else countdown.innerText=v
				},
				1000
			)</script>
			<h1>Данные приняты</h1>
			<p id='countdown'>3</p>
			<pre>" ;
		//print_r( $user_data ) ;
		if( $user->isAuthorized( $_POST[ 'login' ], $_POST[ 'pass' ] ) ) {
					$_SESSION[ 'userid' ] = $user->id ;
					$_SESSION['logged'] = true;
					$user->update_last_login( ) ;
					
					header( "Location: /" ) ;
					exit ;
				} else {
					unset( $_SESSION[ 'userid' ] ) ;
					unset( $_SESSION[ 'logged' ] ) ;
					$msg = "Incorrect auth data" ;
				}
		session_unset( ) ;
		exit ;
	} 
}else {
	session_unset( ) ;
	view( ) ;
}