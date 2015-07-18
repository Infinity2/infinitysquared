<?php
class ShotPage
{
	private $languages, $page_to_shoot;
	private $routes = Array();
	private $segments = Array();
	public $data;
	public $pagesPath = 'pages';
	
	public function __construct()
	{
		$this->languages = Config::get('languages');
		$this->extractUri();
		// $this->languageRedirect();
		self::loadLang();
	}
	
	protected function extractUri()
	{
		$uri = ( isset($_GET['url']) ) ? explode("/", $_GET['url']) : Array() ;
		
		if( count($uri) > 0 )
		{
			$i = 0;
			foreach($uri as $k => $v)
			{
				if( $this->languages )
				{
					if( $i == 0 && ! in_array($v, $this->languages) )
					{
						define('_LNG', $this->languages[0]);
						$_SESSION['lng'] = _LNG;

						define('_su1', $v);
						$this->segments['_su1'] = $v;

						$i++;
					}
					else if ($i == 0 && in_array($v, $this->languages))
					{
						define('_LNG', $v);
						$_SESSION['lng'] = _LNG;
					}
					else
					{
						if( $v != '' )
						{
							define('_su'.$i, $v);
							$this->segments['_su'.$i] = $v;
						}
					}
				}
				else
				{
					if( $v != '' )
					{
						define('_su'.($i+1), $v);
						$this->segments['_su'.($i+1)] = $v;
					}
				}
				
				$i++;
			}
		}
		else if ( $this->languages )
		{
			define('_LNG', $this->languages[0]);
			$_SESSION['lng'] = _LNG;
		}
	}

	public function pageToShoot()
	{
		if( ! defined('_su1') )
		{
			if( $this->languages && is_file( $this->pagesPath.'/home_'._LNG.'.php' ) )
				$this->page_to_shoot = 'home_'._LNG.'.php';
			else
				$this->page_to_shoot = 'home.php';
		}
		else
		{
			if( $target = $this->getConfRoutes() )
				$this->page_to_shoot = $target.'.php';
			else if( is_file( $this->pagesPath.'/'._su1.'.php' ) && ! defined('_su2') )
				$this->page_to_shoot = _su1.'.php';
			else if( is_file( $this->pagesPath.'/'._su1.'.php' ) && defined('_su2') && ! is_file($this->pagesPath.'/'._su2.'.php') )
				$this->page_to_shoot = _su1.'.php';
			else if( defined('_su2') && is_file($this->pagesPath.'/'._su2.'.php') )
				$this->page_to_shoot = _su2.'.php';
			else if( defined('_su2') && defined('_su3') && is_file($this->pagesPath.'/'._su3.'.php') )
				$this->page_to_shoot = _su3.'.php';
			
			// ako je site višejezični onda traži fajlove na osnovu definiranih konstanti za urlove
			/*else if( defined('_LNG') && array_key_exists(_su1, $this->routes) && is_file( $this->pagesPath.'/'.$this->routes[_su1].'.php' ) )
				$this->page_to_shoot = $this->routes[_su1].'.php';
			else if( defined('_LNG') && array_key_exists(_su1, $this->routes) && is_file( $this->pagesPath.'/'.$this->routes[_su1].'_'._LNG.'.php' ) )
				$this->page_to_shoot = $this->routes[_su1].'_'._LNG.'.php';
			else if( $this->languages && array_key_exists(_su2, $this->routes) && is_file( $this->pagesPath.'/'.$this->routes[_su2].'_'._LNG.'.php' ) )
				$this->page_to_shoot = $this->routes[_su2].'_'._LNG.'.php';*/
			
			else
				$this->page_to_shoot = '404.php';
		}
	}
	
	protected function getConfRoutes()
	{
		$routes = Config::get('routes');
		
		if( count($routes) > 0 )
		{
			$r = array();
			foreach($routes as $k => $v)
			{
				$r[$k.':'.$v] = substr_count($k, '/');
			}
			
			arsort($r, SORT_NUMERIC);
			
			foreach($r as $k1 => $v1)
			{
				list($k, $v) = explode(':', $k1);
				
				if( strpos($k, '/') !== false && isset($this->segments['_su2']) )
				{
					$s = explode('/', $k);
					$c = count($s)-1;
					
					$shot = true;
					for($i=0; $i<=$c; $i++)
					{
						if( ( ! isset($this->segments['_su'.($i+1)]) || $this->segments['_su'.($i+1)] != $s[$i] ) && $s[$i] != '*' )
							$shot = false;
					}
					
					if( $shot && is_file($this->pagesPath.'/'.$v.'.php') )
						return $v;
				}
				else
				{
					if( $k == _su1 )
						return $v;
				}
			}
			
			return false;
		}
		else
		{
			return false;
		}
	}
	
	protected function languageRedirect()
	{
		if( $this->languages )
		{
			$languages = Config::get('languages');
			if( ( ! defined('_LNG') || ! in_array(_LNG, $languages) ) && is_array($languages) )
			{
				if( isset($_COOKIE['site_lng']) && in_array($_COOKIE['site_lng'], $languages) )
				{
					header('Location: '._SITE_URL.$_COOKIE['site_lng'].'/');
				}
				else
				{
					setcookie('site_lng', $languages[0], time()+(60*60*24*365), '/');
					header('Location: '._SITE_URL.$languages[0].'/');
				}
			}
			else
			{
				if( ! isset($_COOKIE['site_lng']) || _LNG != $_COOKIE['site_lng'] )
				{
					setcookie('site_lng', _LNG, time()+(60*60*24*365), '/');
				}
			}
		}
	}
	
	public static function loadLang()
	{
		$languages = Config::get('languages');

		if( ! $languages )
			return false;

		if(! isset($_SESSION['lng']) || ! in_array($_SESSION['lng'], Config::get('languages'))) {
			$_SESSION['lng'] = reset(Config::get('languages'));
		}

		define('_LNG', $_SESSION['lng']);

		$handle = @fopen('app/translations/lang_'._LNG.'.txt', "r");

		if( $handle )
		{
			while ( $buffer = fgets($handle) )
			{
				if( $buffer != '' && substr($buffer,0,1) == '_' )
				{
					$pos = strpos($buffer, '=');
					
					if( $pos !== false )
					{
						$const = trim(substr($buffer,0,$pos));
						$val = trim(substr($buffer,($pos+1)));
						
						if( substr($const, 0, 5) === '_URL_' )
						{
							$this->routes[$val] = mb_strtolower(substr($const,5));
						}
						
						define($const, $val);
					}
				}
			}
			
			fclose ($handle);
		}
	}

	public function shotPage()
	{
		ob_start();

		include ($this->pagesPath.'/'.$this->page_to_shoot);
		$bullet['title'] = ( isset($title) ) ? $title : '' ;
		$bullet['keywords'] = ( isset($keywords) ) ? $keywords : $bullet['title'] ;
		
		$bullet['fb_title'] = ( isset($fb_title) ) ? $fb_title : false ;
		$bullet['fb_url'] = ( isset($fb_url) ) ? $fb_url : false ;
		$bullet['fb_img'] = ( isset($fb_img) ) ? $fb_img : false ;
		$bullet['fb_desc'] = ( isset($fb_desc) ) ? $fb_desc : false ;
		
		$bullet['header'] = ( isset($header) ) ? $header : 'header' ;
		$bullet['footer'] = ( isset($footer) ) ? $footer : 'footer' ;

		$bullet['dont_output_js_path'] = ( isset($dont_output_js_path) ) ? $dont_output_js_path : false ;
		
		$bullet['content'] = ob_get_contents();
		
		ob_end_clean();
		
		$this->data = $bullet;
	}
}