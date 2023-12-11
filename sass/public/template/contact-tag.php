<div id="pagina" class="iniciar">
	<!--Section 2-->
	<div class="Menu">
	</div>
	<!--Menu1-->

	<div class="Menu2 p40">

		<div class="bordermenu m30 ">
		<form action="?contact/info" method="post">
		<?php
		    echo '<h1>Hola!!Usuario :'.$_SESSION['datos']['id']. '</h1>';
		    echo"Tienes algun problema ? Enviame un mensaje explicando eñ problema !!";
		    echo " <textarea name='missatge'></textarea>";
		    if($errors["missatge"]){
		        echo "<span class='error'>".$errors['missatge'].'</span>';
		    }
		    echo "  <button type='submit' name='boto'>".$textos["send"]."</button>";
		
        ?>
       
      
    	</form>


		</div>
	</div>