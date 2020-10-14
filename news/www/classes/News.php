<?php
class News{
	public $id            ;
	public $title_ru      ;
	public $content_ru    ;
	public $image_file    ; 
	public $is_active     ;
	public $views_cnt     ;	
	public $dt_create     ;
	public $dt_edit       ;
	public $id_category   ; 
	public $id_author     ;
	public $id_importance ;
	
	private $DB ;
	
	function search($serch){
		if( empty( $this->DB ) )
				return false ;
		$all_active_news = $this->DB->query( "SELECT * FROM News WHERE title_ru LIKE'%". $serch ."%' OR content_ru LIKE'%". $serch ."%'" ) ;
		$ret = [] ;
		while( $news = $all_active_news->fetch( PDO::FETCH_ASSOC ) ) {
			$ret[] = $news ;
		}
		return $ret ;
	}
	
	function deletfile($filename)	{
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
	
	function seeNews($id = ""){
		if(empty($id)){
			echo "Ошибка пустого ID;";
			return false;
		}else{
			if( empty( $this->DB ) )
				return false ;
			
			$sql = "UPDATE News SET views_cnt =? where id=?";
			$pre_que = $this->DB->prepare($sql);
			$this->load_by_id($id);
			$cnt = ($this->views_cnt + 1);
			$data[ 'views_cnt'] = $cnt;
			$this->load_from_array($data);
			$pre_que->execute([$this->views_cnt,$id]);
			return true;
		}
	}
	
	function get_all_active(){
		if( empty( $this->DB ) )
			return false ;
		
		$all_active_news = $this->DB->query( "SELECT * FROM News WHERE is_active = 1" ) ;
		$ret = [] ;
		while( $news = $all_active_news->fetch( PDO::FETCH_ASSOC ) ) {
			$ret[] = $news ;
		}
		return $ret ;
	}
	
	function update_in_db($data=null){
		if( empty( $this->DB ) )
			return false ;
		
		if( is_array( $data ) ) 
			$this->load_from_array( $data ) ;
		
		$prepared_sql="UPDATE News SET
			title_ru		=?,
			content_ru      =?,
			id_category     =?,
			id_importance   =?,
			id_author       =?,
			dt_edit         =CURRENT_TIMESTAMP,
			image_file      =?,
			is_active       =?
			WHERE id = ?
			";
		$prepared_que=$this->DB->prepare($prepared_sql);
		$prepared_que->execute([
			$this->title_ru,
			$this->content_ru,
			$this->id_category,
			$this->id_importance,
			$this->id_author,
			$this->image_file,
			$this->is_active,
			$this->id
		]);
		return true;
	}
	
	function set_active($act){
		if( empty( $this->DB ) )
			return false ;
		if( empty( $this->id ) )
			return false ;
		$data = $this
			->DB
			->query( "UPDATE News SET is_active= "
				     .((empty($act))?0:1)
					 ." WHERE id = "
					 .$this->id 
					);
		return true;
	}
	
	function delete_by_id($ID){
		if( empty( $this->DB ) )
			return false ;
		$data = $this
			->DB
			->query( "DELETE FROM News WHERE id = $ID" );
		return true;
	}
	
	function load_by_id( $ID ) {
		if( empty( $this->DB ) )
			return false ;
		if(!empty($ID)){
			$data = $this
				->DB
				->query( "SELECT * FROM News WHERE id = $ID" )
				->fetch( PDO::FETCH_ASSOC ) ;
			if( empty( $data ) )
				return false ;
	// echo "<pre>" ; print_r( $data ) ; exit ;		
			$this->id            = $data[ 'id'            ];
			$this->title_ru      = $data[ 'title_ru'      ];
			$this->content_ru    = $data[ 'content_ru'    ];
			$this->image_file    = $data[ 'image_file'    ];
			$this->is_active     = $data[ 'is_active'     ];
			$this->views_cnt     = $data[ 'views_cnt'     ];
			$this->dt_create     = $data[ 'dt_create'     ];
			$this->dt_edit       = $data[ 'dt_edit'       ];
			$this->id_category   = $data[ 'id_category'   ];
			$this->id_author     = $data[ 'id_author'     ];
			$this->id_importance = $data[ 'id_importance' ];
			
			return $data ;
		}
	}
	
	function get_importances( ) {
		if( empty( $this->DB ) )
			return false ;
		
		$all_news = $this->DB->query( "SELECT * FROM Importance" ) ;
		$ret = [] ;
		while( $news = $all_news->fetch( PDO::FETCH_ASSOC ) ) {
			$ret[] = $news ;
		}
		return $ret ;
	}
	
	function get_categories( ) {
		if( empty( $this->DB ) )
			return false ;
		
		$all_news = $this->DB->query( "SELECT * FROM Categories" ) ;
		$ret = [] ;
		while( $news = $all_news->fetch( PDO::FETCH_ASSOC ) ) {
			$ret[] = $news ;
		}
		return $ret ;
	}
	
	function get_all_news( ) {
		if( empty( $this->DB ) )
			return false ;
		global $lang;
		$all_news = $this->DB->query( "
			SELECT 
				N.* ,
				C.title_$lang as ctg ,
				I.title_$lang as imp
			FROM
				News N
				JOIN Categories C ON N.id_category   = C.Id
				JOIN Importance I ON N.id_importance = I.Id
			ORDER BY
				N.DT_create DESC
		" ) ;
		$ret = [] ;
		while( $news = $all_news->fetch( PDO::FETCH_ASSOC ) ) {
			$ret[] = $news ;
		}
		return $ret ;
	}
	
	function __dump() {
		return 
			'id'            . ' : ' . ($this->id            ?? '--' ) . '<br>' .
			'title_ru'      . ' : ' . ($this->title_ru      ?? '--' ) . '<br>' .
			'content_ru'    . ' : ' . ($this->content_ru    ?? '--' ) . '<br>' .
			'image_file'    . ' : ' . ($this->image_file    ?? '--' ) . '<br>' .
			'is_active'     . ' : ' . ($this->is_active     ?? '--' ) . '<br>' .
			'views_cnt'     . ' : ' . ($this->views_cnt     ?? '--' ) . '<br>' .
			'dt_create'     . ' : ' . ($this->dt_create     ?? '--' ) . '<br>' .
			'dt_edit'       . ' : ' . ($this->dt_edit       ?? '--' ) . '<br>' .
			'id_category'   . ' : ' . ($this->id_category   ?? '--' ) . '<br>' .
			'id_author'     . ' : ' . ($this->id_author     ?? '--' ) . '<br>' .
			'id_importance' . ' : ' . ($this->id_importance ?? '--' ) . '<br>' 
		;
	}
	
	function add_to_db( $data = null ) {
		if( empty( $this->DB ) )
			return false ;
		
		if( is_array( $data ) ) 
			$this->load_from_array( $data ) ;
			
		$prepared_sql = "INSERT INTO News
		(title_ru, content_ru, id_category, id_importance, id_author, dt_create, image_file, views_cnt, is_active)
		VALUES(?,     ?,          ?,           ?,             ?,    CURRENT_TIMESTAMP, ?,        0,         ?    )
		" ;
		$prepared_que = $this->DB->prepare( $prepared_sql ) ;
		$prepared_que->execute( [ 
			$this->title_ru      ,
			$this->content_ru    ,
			$this->id_category   ,
			$this->id_importance ,
			$this->id_author     ,
			$this->image_file    ,
			$this->is_active    
		] ) ;
		return true ;
	}
	
	function __construct( $data = null ) {		
		if(is_readable("db_ini.php"))
			include "db_ini.php";
		else if(is_readable("../db_ini.php"))
			include "../db_ini.php";
		
		if( empty( $db_type ) ) {
			throw new Exception( "NewsCtr: Config load error" ) ;
		}
		
		$conStr = "$db_type:host=$db_host;dbname=$db_name;charset=$db_enc;";
		
		try{
			$this->DB = new PDO( $conStr, $db_user, $db_pass ) ;
			$this->DB ->setAttribute(
				PDO::ATTR_ERRMODE, 
				PDO::ERRMODE_EXCEPTION
			) ;
		}
		catch( PDOException $ex ) {
			throw $ex;
		}
		
		if( is_array( $data ) ) {
			$this->load_from_array( $data ) ;
		}
	}
	
	function load_from_array( $data ) {
		if( isset( $data[ 'id'            ] ) ) $this->id            = $data[ 'id'            ];
		if( isset( $data[ 'title_ru'      ] ) ) $this->title_ru      = $data[ 'title_ru'      ];
		if( isset( $data[ 'content_ru'    ] ) ) $this->content_ru    = $data[ 'content_ru'    ];
		if( isset( $data[ 'image_file'    ] ) ) $this->image_file    = $data[ 'image_file'    ];
		if( isset( $data[ 'is_active'     ] ) ) $this->is_active     = $data[ 'is_active'     ];
		if( isset( $data[ 'views_cnt'     ] ) ) $this->views_cnt     = $data[ 'views_cnt'     ];
		if( isset( $data[ 'dt_create'     ] ) ) $this->dt_create     = $data[ 'dt_create'     ];
		if( isset( $data[ 'dt_edit'       ] ) ) $this->dt_edit       = $data[ 'dt_edit'       ];
		if( isset( $data[ 'id_category'   ] ) ) $this->id_category   = $data[ 'id_category'   ];
		if( isset( $data[ 'id_author'     ] ) ) $this->id_author     = $data[ 'id_author'     ];
		if( isset( $data[ 'id_importance' ] ) ) $this->id_importance = $data[ 'id_importance' ];	
	}
}