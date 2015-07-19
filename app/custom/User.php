<?php
class User
{
    public static function isUser($username)
    {
        if (! User::isAdmin()) {
            return false;
        }

        $is_user = Db::query_one('SELECT id FROM users WHERE username = "'.Db::clean($username).'" LIMIT 1');

        return ( $is_user ) ? true : false ;
    }

    public static function validateRegistration($post)
    {
        $err = array();
        
        if( $post['username'] == '' )
        {
            $err[] = _YOU_MUST_ENTER_USERNAME;
        }
        else if( !preg_match('/^[A-Za-z0-9_]+$/',$post['username']) )
        {
            $err[] = _USERNAME_CAN_CONTAIN;
        }
        else if( strlen($post['username']) < 4 || strlen($post['username']) > 20 )
        {
            $err[] = _USERNAME_MUST_BE;
        }
        else
        {
            $is_user = Db::query_one('SELECT id FROM users WHERE username = "'.Db::clean($post['username']).'" LIMIT 1');
            if( $is_user )
            {
                $err[] = _USERNAME_IS_TAKEN;
            }
        }
        
        if( strlen($post['password']) < 5 )
        {
            $err[] = _PASSWORD_MUST_BE_LONGER;
        }
        
        if( ! valid_email($post['email']) )
            $err[] = _EMAIL_IS_INVALID;

        if ( valid_email($post['email']) ){
            $is_email_used = Db::query_one('SELECT email FROM users WHERE email = "'.Db::clean($post['email']).'" LIMIT 1');
            if( $is_email_used )
            {
                $err[] = _EMAIL_ALREADY_USED;
            }
        }

        if( ! isset($post['user_type']) || ! in_array($post['user_type'], array('m','f','fm','mm','ff')) )
            $err[] = _MUST_SELECT_USER_TYPE;

        return $err;
    }
    
    public static function register($post)
    {
        $sql = '
            INSERT INTO users SET 
                username = "'.$post['username'].'", 
                password = "'.self::calcPassword($post['password']).'", 
                type = "'.$post['user_type'].'",
                created = NOW()
        ';
        
        $q = Db::query($sql);
        
        return ( $q ) ? true : false ;
    }
    
    public static function login($post)
    {
        $sql = 'SELECT id, username, user_type FROM users WHERE username = "'.Db::clean($post['username']).'" AND password = "'.self::calcPassword($post['password']).'" LIMIT 1';
        $correct = Db::query_row($sql);
        
        $_SESSION['user'] = null;

        if($correct)
        {
            self::setSession($correct);

            return true;
        }
        else
        {
            return false;
        }
    }
    
    private static function updateLastSeen()
    {
        if ( ! User::isLogged() )
            return false;

        Db::query('UPDATE users SET lastseen = "'.date('Y-m-d h:i:s').'" WHERE id = '.self::getId().' LIMIT 1');
    }

    private static function setSession( $data )
    {
        $_SESSION['user']['id'] = $data['id'];
        $_SESSION['user']['username'] = $data['username'];
        $_SESSION['user']['user_type'] = $data['user_type'];
        $_SESSION['user']['login_hash'] = self::calcHash($data['username'], $data['id']);

        if (self::isAdmin()) {
            $_SESSION['KCFINDER']['disabled'] = false;
        }
    }
    
    public static function saveNewPassword($p)
    {
        Db::query('UPDATE users SET password = "'.self::calcPassword($p).'" WHERE id = '.self::info('id'));
        
        return true;
    }
    
    public static function isLogged()
    {
        if( isset($_SESSION['user']) && isset($_SESSION['user']['username']) && self::calcHash($_SESSION['user']['username'], $_SESSION['user']['id']) == $_SESSION['user']['login_hash'])
            return true;
        else
            return false;
    }

    public static function isAdmin()
    {
        if(self::isLogged() && self::get('user_type') == 'admin')
            return true;
        else
            return false;
    }

    public static function logout()
    {
        $_SESSION['user'] = null;
        unset($_SESSION['KCFINDER']);
    }
    
    private static function calcHash($p1, $p2)
    {
        return md5($p1.Config::get('site_salt').$p2);
    }
    
    public static function calcPassword($password)
    {
        return md5(Config::get('site_salt').$password.'__');
    }
    
    public static function generatePassword()
    {
        $letters = range('a','z');
        $new_pas = '';
        for($i=1; $i<=6; $i++)
        {
            $num = mt_rand(0,25);
            $oj = mt_rand(0,1);
            $letter = ( $i % 2 == 0 ) ? strtoupper($letters[$num]) : $letters[$num] ;
            $new_pas .= ( $oj == 1 ) ? $letter : $num ;
        }
        
        return $new_pas;
    }
    
    public static function getId($username=false)
    {
        if ($username) {
            $id = Db::query_one('SELECT id FROM users WHERE username = "'.Db::clean($username).'" LIMIT 1');

            return $id;
        }

        return $_SESSION['user']['id'];
    }

    public static function get($var)
    {
        if( array_key_exists($var, $_SESSION['user']) )
        {
            return $_SESSION['user'][$var];
        }
        else
        {
            return Db::query_one('SELECT '.Db::clean($var).' FROM users WHERE id = '.self::getId().' LIMIT 1');
        }
    }

    public static function set($var, $val)
    {
        $_SESSION['user'][$var] = $val;
        Db::query('UPDATE users SET '.Db::clean($var).' = "'.Db::clean($val).'" WHERE id = '.self::getId().' LIMIT 1');
    }
}