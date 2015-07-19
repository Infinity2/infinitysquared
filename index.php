<?php
	require_once 'app/load.php';

	if( ! $_config['production'] )
		$appStats = new PageStats;

	$app = new ShotPage;

	if (defined('_su1') && _su1 == 'admin') {
		$app->pagesPath = 'pages/admin';
	}

	$app->pageToShoot();
	$app->shotPage();

	if(is_file($app->pagesPath.'/layout_'.$app->data['header'].'.php'))
		include $app->pagesPath.'/layout_'.$app->data['header'].'.php';

	print $app->data['content'];

	if(is_file($app->pagesPath.'/layout_'.$app->data['footer'].'.php'))
		include $app->pagesPath.'/layout_'.$app->data['footer'].'.php';

	if (Config::get('site_directory') != '/' && $app->data['dont_output_js_path'] == false) {
		print '<script>var _site_root = "'.Config::get('site_directory').'";</script>';
	}

	if( ! $_config['production'] )
		print $appStats->output_result();