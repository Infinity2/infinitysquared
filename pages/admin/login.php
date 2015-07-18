<?php
    $header = '';
    $footer = '';

    // echo User::calcPassword('inf2211');

    if ($_POST && User::login($_POST)) {
        Redirect::to(Config::get('site_url').'admin');
    }
?>
<!doctype html>
<html lang="en">
<head>
    <base href="<?php echo Config::get('site_url') ?>" />
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="css/style_admin.css" rel="stylesheet" type="text/css" />
</head>
<body style="width:100%;">
    <div class="login_content">
        <form action="" method="post">
            <h1><?php echo Config::get('app_name') ?></h1>
            <label>
                <span>Username</span>
                <input type="text" name="username">
            </label>
        
            <label>
                <span>Password</span>
                <input type="password" name="password">
            </label>
            <input type="submit" value="Login" class="submit">
        </form>
    </div>
</body>
</html>