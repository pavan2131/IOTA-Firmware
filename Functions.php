<?php 

/**
 * Get the value of a Application configuration setting
 * @param string $key
 * @return mixed
 */
function config($key)  {
    global $app;
    return $app[$key] ?? null;
}

/**
 * Get the value of a Post Request
 * @param string $key
 * @return mixed
 */
function post($key=null) {
    return (is_null($key)) ? $_POST : $_POST[$key] ?? null;
}


/**
 * Get the value of a Session
 * @param string $key
 * @return mixed
 */
function session($key=null){
    return (is_null($key))? $_SESSION : $_SESSION[$key] ?? null;
}


/**
 * Get the value of a Get Request
 * @param string $key
 * @return mixed
 */
function get($key=null) {
    return (is_null($key))? $_GET : $_GET[$key] ?? null;
}

/**
 * Get the value of a Request
 * @param string $key
 * @return mixed
 */
function request($key=null) {
    return (is_null($key))? $_REQUEST : $_REQUEST[$key] ?? null;
}

/**
 * Get the value of a Session
 * @param string $key
 * @return mixed
 */
function redirect($file){
    header("Location: $file");
    exit;
}

/** 
* Display Error Message with Bootstrap Alert
* @param string $message
* @return void
*/
function error($message=null){
    echo "<div class='alert alert-danger m-4'><b class='text-danger'>".config('app_name')." Error :</b> <br> $message</div>";
}


/**
 * Display Success Message with Bootstrap Alert
 * @param string $message
 * @return void
 */

function success($message=null){
    echo "<div class='alert alert-success m-4 '><b class='text-success'>".config('app_name')." Success :</b> <br> $message</div>";
}


/**
 * Display Warning Message with Bootstrap Alert
 * @param string $message
 * @return void
 */
function warning($message=null){
    echo "<div class='alert alert-warning m-4'><b class='text-warning'>".config('app_name')." Warning :</b> <br> $message</div>";
}


/**
 * return the url of the file
 * @param string $file
 * @return string
 */
function url($file){
    return config('base_url').$file;
}


/**
 * return the url of the file
 * @param string $file
 * @return string
 */
function is_logged_in(){
  if(empty(session('auth_token'))){
    redirect('login.php?error=Please login to continue');
  }else{
    return true;
  }
}


function array_print($array){
  echo "<pre>";
  print_r($array);
  echo "</pre>";
}

function scr_red($url){
  echo "<script>window.location.href='$url'</script>";
}




