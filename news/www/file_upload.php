<h1> File uploading </h1>

<form method="POST" enctype="multipart/form-data">
<input type="file" name="file1" title="Up to 1 MB file" />
<br/>
<input type="submit" value="send" />
<!-- for Apache it is necessary -->
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
</form>

<?php  
	echo "<pre>" ;
	print_r( $_FILES ) ;
	if( ! empty( $_FILES[ 'file1' ] ) ) {
		$fname = $_FILES[ 'file1' ][ 'name' ] ; // basename( rawurldecode( $_FILES[ 'file1' ][ 'name' ] ) ) ;
		
		$move_status = move_uploaded_file(
			$_FILES[ 'file1' ][ 'tmp_name' ], 
			"uploads/" . $fname
		) ;
		
		echo "file ", $fname ;
		if( $move_status === false ) {
			echo " does not upload" ;
		} else {
			echo " upload OK" ;
		}
		echo "<br/>" ;
		
		$file_extension = strtolower( pathinfo( $fname, PATHINFO_EXTENSION ) ) ;
		switch( $file_extension ) {
			case 'jpg' :
			case 'jpeg':
			case 'png' :
				echo "<img src='uploads/" . $fname . "' />" ;
				break;
			default:
				echo "Unsupported file type" ;
		}
	}
?>