<?php  
// session_start( ) ;

// echo "<pre>"; print_r( $_GET ) ;
if( empty( $_GET[ 'cmd' ] ) ) {
	echo "<h1 style='transform:rotate(10deg);margin-top:30vh;text-align:center'>404</h1>" ;
	exit ;
}

$lang = $_GET[ 'lang' ] ;

$controller = 
	"controller/" 
	. $_GET[ 'cmd' ]
	. ".php" ;

if( is_readable( $controller ) )
	include $controller ;
else {
	echo "<h1 style='color:tomato;transform:rotate(20deg);margin-top:30vh;text-align:center'>404</h1>" ;
	exit ;
}
