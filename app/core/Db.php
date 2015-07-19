<?php
class Db
{
	static function query($sql)
	{
		global $_db;
		
		if( ! is_object($_db) )
			return 'greska! nema definirane konekcije na bazu!';
		
		return $_db->database_query($sql);
	}
	
	static function query_row($sql)
	{
		global $_db;
		
		if( ! is_object($_db) )
			return 'greska! nema definirane konekcije na bazu!';
		
		return $_db->database_query_row($sql);
	}
	
	static function query_one($sql)
	{
		global $_db;
		
		if( ! is_object($_db) )
			return 'greska! nema definirane konekcije na bazu!';
		
		return $_db->database_query_one($sql);
	}
	
	static function insert_id()
	{
		global $_db;
		return $_db->database_insert_id();
	}
	
	static function clean($string)
	{
		global $_db;
		
		if( ! is_object($_db) )
			return 'greska! nema definirane konekcije na bazu!';
		
		if ( get_magic_quotes_gpc() )
		{
			$string = stripslashes( $string );
		}
		
		return $_db->real_escape_string($string);
	}

	static function last_query($return=false)
	{
		if( $return )
			return $_SESSION['sql_log']['last_sql'];
		else
			print $_SESSION['sql_log']['last_sql']."\n";
	}
}