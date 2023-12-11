<div id="pagina" class="iniciar">
	<!--Section 2-->
	<div class="Menu">
		<h2 class="letra20"><?php echo(($textos["Login"]));?></h2>
	</div>
	<!--Menu1-->

	<div class="Menu2 p40">

		<div class="bordermenu m30 ">
		<?php

if (isset($_SESSION['datos'])) {
    echo '<h1>Ya estas en Login !!!!! Si quieres Cerrar sesión has click <a href="?user/loginOut" </h1>';
    echo '<form action="?user/loginOut" method="post">', 
    '<button type="submit" name="boto">Login Out</button>'.
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
}
?>


		</div>
	</div>