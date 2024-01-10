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
    echo "<img src='". $picture."' >Welcome Name:" . $name . " , You are registered using email: " . $email;
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

            if (isset($_SESSION['datos'])) {
                echo '<h1>Ya estas en Login !!!!! Si quieres Cerrar sesión has click <a href="?user/loginOut" </h1>';
                echo '<form action="?user/loginOut" method="post">',
                    '<button type="submit" name="boto">Login Out</button>' .
                    '</form>';
            } else {

                echo '<form action="?user/login" method="post">
    <div class="input-group">
        <label for="username">' . $textos["username"] . ':</label>
        <input type="text" id="username" name="username" required>
    </div>

    <div class="input-group">
        <label for="password">' . $textos["password"] . ':</label>
        <input type="password" id="password" name="password" required>
    </div>
    <span class="error">';
                if ($loginError == true) {
                    echo $textos['logError'];
                }
                echo '</span>
    <span class="error">';
                echo '</span>
    <button type="submit" name="boto">' . $textos["Login"] . '</button>
    <span><a href="?user/regist">' . $textos["registrarText"] . '</a></span>
</form>';
        echo "<a href='?user/loginGoogle'>Login with Google</a>";
//echo "<a href='" . $client->createAuthUrl() . "'>Login with Google</a>";

            }
            ?>


        </div>
    </div>

  