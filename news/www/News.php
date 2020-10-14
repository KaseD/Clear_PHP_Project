<?php
class News{
	public $title_ru;
	public $content_ru;
	public $id_category; 
	public $id_author;
	public $image_file; 
	public $dt_create;
	public $dt_edit;
	public $is_active;
	public $id_importance;
	public $views_cnt;
	
	
	function __construct($dbLink=null){
		if($dbLink==null){
			unset($db_type);
			include "db_ini.php";
			$conStr = "$db_type:host=$db_location;dbname=$db_schema;charset=$db_encoding";
			try{$this->DB = new PDO($conStr, $db_user, $db_pass);
			$this->DB->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);}
			catch(PDOException $ex){throw $ex;}
		} else $this->DB = $dbLink;
	}
}