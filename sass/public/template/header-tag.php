<header class=" fixed w250 left border ">

	<div class="black left height">
		<div class="Logo">
			<?php
			if (isset($_SESSION['user_info'])) {
				echo "<a href='?user/loginOut'><img src='{$_SESSION["user_info"]["picture"]}'></a></br>";
				echo "<p style='color:white;'>{$_SESSION["user_info"]["name"]}</p>";
			} else {
				echo "<img src='./img/logo.png'>";
			}
			?>
		</div>
		<div class="Lista lcentra f20">
			<ul>
				<a href="./index.php">
					<li>
						<?php echo ($textos["Home"]); ?>
					</li>
				</a>
				<li><a href="#">
						<?php echo ($textos["Menu"]); ?>
					</a></li>
				<li><a href="#">
						<?php echo (($textos["PHP"])); ?>
					</a></li>
				<li><a href="">
						<?php echo (($textos["Exercici"])); ?>
					</a></li>
				<?php
				if (isset($_SESSION['user_info'])) {
					echo "<li><a href='?proces/show'>Function</a></li>";
				}
				?>

				<li><a href="?user/show">
						<?php echo (($textos["Login"])); ?>
					</a></li>
				<li id="botonIdioma"><span class="idioma">
						<?php echo (($textos["Idioma"])); ?>
					</span></li>
				<div id="listaIdioma" class="noneLista">
					<li><a href="index.php?lang/set/es">Español</a></li>
					<li><a href="index.php?lang/set/cn">中文</a></li>
					<li><a href="index.php?lang/set/en">English</a></li>
				</div>
				<?php
				if ($_SESSION["admin"] === 1) {
					echo "<li><a href='?config/show'>Configuracion</a></li>";
				}
				?>
			</ul>
		</div>
	</div>
</header>