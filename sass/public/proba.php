<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
phpinfo();
//載入一次 'vendor/autoload.php' 這個文件
require_once './glogin/vendor/autoload.php';

//設定取得Google API 三要素：用戶端編號、用戶端密鑰、已授權的重新導向URI
$clientID = '241965399440-59ek83pl2u1scemevj8pbf868ctlgm2v.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUrl = 'http://localhost/qcep/QcepNew/sass/public/proba.php';

// 建立client端 的 request需求 給 Google
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUrl);
$client->addScope('profile');
$client->addScope('email');

//$_GET['code']的'code' 是取得 [授權碼]
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    //取得GOOGLE使用者帳號資訊
    $gauth = new Google_Service_Oauth2($client);
    $google_info = $gauth->userinfo->get();
    $email = $google_info->email;
    $name = $google_info->name;
    $picture = $google_info->picture;
    
    echo "<img src='". $picture."' >Welcome Name:" . $name . " , You are registered using email: " . $email;
} else {
    echo "<a href='" . $client->createAuthUrl() . "'>Login with Google</a>";
}
?>
<!-- 

require_once './glogin/vendor/autoload.php';
// init configuration 
$clientID = '241965399440-59ek83pl2u1scemevj8pbf868ctlgm2v.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUrl = 'http://localhost/qcep/QcepNew/sass/public/proba.php';
 
// create Client Request to access Google API 
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUrl);
$client->addScope("email");
$client->addScope("profile");
// authenticate code from Google OAuth Flow 
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);
 
  // get profile info 
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;
  // now you can use this profile info to create account in your website and make user logged in. 
} else {
  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}
?> -->