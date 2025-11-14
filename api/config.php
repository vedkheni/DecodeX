<?php 
$base_url = '';
    if($_SERVER['REQUEST_SCHEME'] && $_SERVER['HTTP_HOST'])
    {
        $base_url .= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/';	
    }
    $active_group = 'default';
    $query_builder = TRUE;
    $host_name = 'localhost';
    if (strpos($base_url, 'staff.decodex.io') !== false){ 
        $user_name = 'sagarg_staff_decodex';  
        $pass_word = 'Dev@DecodeX217&';  
        $database_name = 'sagarg_staff_decodex';
    } else{ 
        //echo "stage.site";
        $user_name = 'sagarg_stage_decodex';  
        $pass_word = 'Dev@DecodeX217&';  
        $database_name = 'sagarg_stage_decodex';
    }
    
    if(mode=="live")
    {
    $db['default'] = array(
        'dsn'	=> '',
        'hostname' => $host_name,
        'username' => $user_name,
        'password' => $pass_word,
        'database' => $database_name,
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => FALSE,
        'db_debug' => (ENVIRONMENT !== 'production'),
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => FALSE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE
        );
    }else{
        $db['default'] = array(
        'dsn'	=> '',
        'hostname' => $host_name,
        'username' => $user_name,
        'password' => $pass_word,
        'database' => $database_name,
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => FALSE,
        'db_debug' => (ENVIRONMENT !== 'production'),
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => FALSE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE
        );
    }
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'cron/vendor/autoload.php';
   /*  require_once $base_url.'/third_party/PHPMailer/src/Exception.php';
    require_once $base_url.'third_party/PHPMailer/src/PHPMailer.php';
    require_once $base_url.'third_party/PHPMailer/src/SMTP.php'; */
    
    $mail = new PHPMailer;

    $mysqli = new mysqli($db['default']['hostname'],$db['default']['username'],$db['default']['password'],$db['default']['database']);

    function generate_output($status,$message,$extra=array())
    {
        $res = array();
        $res['status'] = $status;
        $res['message'] = $message;
        if(isset($extra['number']) && $extra['number'] == 1){
            echo json_encode($res,JSON_NUMERIC_CHECK);
        }
        else{
            echo json_encode($res);
        }
        exit();
    }

?>