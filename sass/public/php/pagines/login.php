<?php

function sanitize($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST["login"])){
    $mail = sanitize($_POST["mail"]);
    $pass = sanitize($_POST["pass"]);
    
    if (empty($mail)) {
        $error['mail'] = "put your email";
        unset($mail);
    } elseif (! filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $error['mail'] = "incorrect format";
        unset($mail);
    }
    
    if(empty($pass)){
        $error['pass'] = "the password";
        unset($pass);
    }
    
    if(empty($error)){
        //database
        
        //compare the database information and the inputs of the form if there the same
        
        //if does not exist, display the message $error to both inputs
        
        //else, header(Location: 'proces.php);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="./login.css">
    <title>Document</title>
</head>
<body>
    <?php include '../template/header.php'?>
    <div class="container">
    <form method="post">
        <input type="text" placeholder="email" id="mail" name="mail">
        <br>
       <span><?php if (isset($error['mail'])) { echo $error['mail']; } ?></span>
       <br>
        <input type="password" placeholder="password" id="pass" name="pass">
        <br>
        <?php  if (isset($error['pass'])) { echo $error['pass']; }?>
        <br>
        <input type="submit" id="login" name="login" value="Login">
        <br>
    </form>
    <p><a href="">Create an account</a></p>
</div>
<p>Terms of use | Privacy policy</p>
</body>
</html>