<?php
class SAjax
{
	protected $response = array();
	
	public function __construct($fja, $data)
	{
		if( method_exists($this, $fja) )
		{
			call_user_func_array(array($this, $fja), $data);
		}
	}
	
	public function __destruct()
	{
		print json_encode($this->response);
	}
	
	protected function out($type, $content, $id=false)
	{
		$types = array('value','html','append','prepend','script');
		
		if( in_array($type, $types) && isset($content) && ( $id || ( ! $id && $type == 'script' ) ) )
		{
			$this->response[] = array('type'=>$type, 'content'=>$content, 'id'=>$id);
		}
	}
}