<?php 
session_start();
$base_url = 'http'; // default http, use https if your domain is using ssl
$base_url .= "://".$_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

$model_url = $base_url."model/";

/**
 * @return boolean
 */
function isLoggedin() {
    if(!empty($_SESSION)){
        if ($_SESSION['is_loggedin'] == true) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function logout() {
    $_SESSION = array();
	session_destroy();
    header('Location: login.php');
}