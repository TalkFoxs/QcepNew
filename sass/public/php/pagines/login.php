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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    <link rel="stylesheet" href="../../css/main.css">
=======
>>>>>>> ffcbddf (estructura de login)
=======
    <link rel="stylesheet" href="../../css/main.css">
>>>>>>> c999872 (login1)
    <link rel="stylesheet" href="./login.css">
    <title>Document</title>
</head>
<body>
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c999872 (login1)
    <?php include '../template/header.php'?>
    <div class="container">
=======
    <title>Document</title>
</head>
<body>
>>>>>>> 2379126 (login)
=======
    <div class="container">
>>>>>>> ffcbddf (estructura de login)
    <form method="post">
        <input type="text" placeholder="email" id="mail" name="mail">
        <br>
       <span><?php if (isset($error['mail'])) { echo $error['mail']; } ?></span>
<<<<<<< HEAD
       <br>
        <input type="password" placeholder="password" id="pass" name="pass">
        <br>
        <?php  if (isset($error['pass'])) { echo $error['pass']; }?>
        <br>
=======
        <input type="password" placeholder="password" id="pass" name="pass">
        <br>
        <?php  if (isset($error['pass'])) { echo $error['pass']; }?>
>>>>>>> 2379126 (login)
        <input type="submit" id="login" name="login" value="Login">
        <br>
    </form>
    <p><a href="">Create an account</a></p>
<<<<<<< HEAD
<<<<<<< HEAD
</div>
<p>Terms of use | Privacy policy</p>
<<<<<<< HEAD
=======
>>>>>>> 2379126 (login)
=======
</div>
>>>>>>> ffcbddf (estructura de login)
=======
>>>>>>> 2e5d88b (adios)
</body>
</html>