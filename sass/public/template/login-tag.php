<!-- <?php
//載入一次 'vendor/autoload.php' 這個文件

//設定取得Google API 三要素：用戶端編號、用戶端密鑰、已授權的重新導向URI
$clientID = '241965399440-59ek83pl2u1scemevj8pbf868ctlgm2v.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUrl = 'http://localhost/qcep/QcepNew/sass/public/index.php';

// 建立client端 的 request需求 給 Google
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUrl);
$client->addScope('profile');
$client->addScope('email');
$client->addScope('https://www.googleapis.com/auth/drive');

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
    echo "<img src='" . $picture . "' >Welcome Name:" . $name . " , You are registered using email: " . $email;
    header('Location: http://localhost/qcep/QcepNew/sass/public/index.php?user/show');
    exit();

} else {
    echo "<a href='" . $client->createAuthUrl() . "'>Login with Google</a>";
}
?> -->
<div id="pagina" class="iniciar">
    <!--Section 2-->
    <div class="Menu">
        <h2 class="letra20">
            <?php echo (($textos["Login"])); ?>
        </h2>
    </div>
    <!--Menu1-->

    <div class="Menu2 p40">

        <div class="bordermenu m30 ">
            <?php

            if (isset($_SESSION['user_info'])) {
                echo '<h1>Ya estas en Login !!!!! Si quieres Cerrar sesión has click <a href="?user/loginOut" </h1>';
                echo '<form action="?user/loginOut" method="post">',
                    '<button type="submit" name="boto">Login Out</button>' .
                    '</form>';
            } else {
                echo "<button id='googleSignInButton' class=\"gsi-material-button\">
    <div class=\"gsi-material-button-state\"></div>
    <div class=\"gsi-material-button-content-wrapper\">
        <div class=\"gsi-material-button-icon\">
            <svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 48 48\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" style=\"display: block;\">
                <path fill=\"#EA4335\" d=\"M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z\"></path>
                <path fill=\"#4285F4\" d=\"M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z\"></path>
                <path fill=\"#FBBC05\" d=\"M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z\"></path>
                <path fill=\"#34A853\" d=\"M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z\"></path>
                <path fill=\"none\" d=\"M0 0h48v48H0z\"></path>
            </svg>
        </div>
        <span class=\"gsi-material-button-contents\">Sign in with Google</span>
        <span style=\"display: none;\">Sign in with Google</span>
    </div>
</button>";

                echo "<script>
document.getElementById('googleSignInButton').addEventListener('click', function() {
    window.location.href = 'https://www.qceproba.com?user/loginGoogle';
});
</script>";
                //echo "<a href='" . $client->createAuthUrl() . "'>Login with Google</a>";
            }
            ?>


        </div>
    </div>