<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);



/* Custom Code Start */
$protocol = ($_SERVER['REQUEST_SCHEME'] && $_SERVER['HTTP_HOST']) ? $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/stage.decodex.io/' : "http://localhost/stage.decodex.io/";
defined('BASE') || define('BASE',$protocol);
if (strpos(BASE, 'staff.com/') !== false){
    define('mode', 'live');
    define('SITE_KEY', '6LcLfwAgAAAAAFiUDTvT8BpmSzmp8wd2GaKETkXn');
}else{
    define('mode', 'stage');
    define('SITE_KEY', '6LcLfwAgAAAAAFiUDTvT8BpmSzmp8wd2GaKETkXn');
    define('SECRET_KEY', '6LcLfwAgAAAAANmkUVC2BVtzVKX479AvSQxAPXKi');
}



defined('google_secret') || define('google_secret', '6LcLfwAgAAAAAFiUDTvT8BpmSzmp8wd2GaKETkXn');
defined('google_key') || define('google_key', '6LcLfwAgAAAAANmkUVC2BVtzVKX479AvSQxAPXKi');

// define('SITE_KEY', '6LfYo98ZAAAAAHEj1mY5cYbyRxJ5KTeF4ZhzoNTT'); 

// $config['google_key'] = '6Lej170UAAAAALoLazJctl2tBVc3FSO6Rk4Wb98T';
// $config['google_secret'] = '6Lej170UAAAAADa0b_jDwNF49iqtejzVbr7kqGhg';


// defined('LOGIN_ATTEMPT') || define('LOGIN_ATTEMPT', '2'); // 3 times attempt
// defined('USER_BLOCK_TIME_MIN') || define('USER_BLOCK_TIME_MIN', '30');
// defined('ADMIN_MAIL') || define('ADMIN_MAIL', 'sagargeek435@gmail.com');
// defined('CURRENT_TIME') || define('CURRENT_TIME',$current_time_zone);
// defined('MONTH_NAME') || define('MONTH_NAME',$months);
// defined('Prof_Tax') || define('Prof_Tax',1);
// defined('Unapproved_Leave') || define('Unapproved_Leave',0.5);
// defined('CHANGE_TIME') || define('CHANGE_TIME','2020-12-01');
// defined('VER') || define("VER", "1.1.2");

define('CURRENCY', 'INR'); // 3 times attempt
define('LOGIN_ATTEMPT', '2'); // 3 times attempt
define('USER_BLOCK_TIME_MIN', '30');
define('ADMIN_MAIL', 'sagargeek435@gmail.com');
date_default_timezone_set('Asia/Kolkata');
$current_time_zone=date('Y-m-d H:i');
define('CURRENT_TIME',$current_time_zone);
$months = array(
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July ',
    'August',
    'September',
    'October',
    'November',
    'December',
);
define('MONTH_NAME',$months);
// 0 - deactive 
// 1 - active
define('Prof_Tax',1);
define('Unapproved_Leave',0.5);
define('CHANGE_TIME','2020-12-01');
// define("VER", "1.2.2");
define("VER", time());
define('API_URL',"https://staff.decodex.io/api/");

function moneyFormat($amount){
    setlocale(LC_MONETARY, 'en_IN');
    return money_format('%!i', ceil($amount));
}
function dateFormat($givenDate=null)
{
	return date('d M, Y', strtotime($givenDate));
}
function Format_date($givenDate=null)
{
	if($givenDate != null){
		$date = explode(', ',$givenDate);
		if(isset($date[1])){
			$given_Date = $date[1].'-'.date('m-d',strtotime($givenDate));
		}else{
			$given_Date = $givenDate;
		}
		return date('Y-m-d', strtotime($given_Date));
	}else{
		return $givenDate;
	}
}
define('averageMonthday',22);
define('composer_autoload','vendor/autoload.php');
// $this->session = session();
/* Custom Code End */