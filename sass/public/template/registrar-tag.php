<div id="pagina" class="iniciar">
	<!--Section 2-->
	<div class="Menu">
		<h2 class="letra20"><?php echo(($textos["registrar"]));?></h2>
	</div>
	<!--Menu1-->

	<div class="Menu2 p40">

		<div class="bordermenu m30 ">
			<form action="?user/registrar" method="post" enctype="multipart/form-data">
				<div class="input-group">
					<label for="username"><?php echo(($textos["username"]));?><span
						class="error">*</span>:</label> <input type="text" id="username"
						name="username" value="<?php echo $bien["user"]?>">
					<span class="error"><?php echo  $errores["username"]?></span>
					<span class="error"><?php echo  $errores["existe"]?></span>
				</div>

				<div class="input-group">
					<label for="password"><?php echo(($textos["password"]));?><span
						class="error">*</span>:</label> <input type="password"
						id="password" name="password" value="<?php echo $bien["pass"]?>">
					<span class="error"><?php echo  $errores["pass"]?></span>
				</div>
				
				<div class="input-group">
					<label for="nom"><?php echo(($textos["nom"]));?>:<span
						class="error">*</span></label> <input type="text" id="nom"
						name="nom"  value="<?php echo $bien["nom"]?>">
						<span class="error"><?php echo  $errores["nom"]?></span>
				</div>
				
				<div class="input-group">
					<label for="cognom"><?php echo(($textos["cognom"]));?><span
						class="error">*</span>:</label> <input type="text" id="cognom"
						name="cognom" value="<?php echo  $bien["cog"]?>">
						<span class="error"><?php echo  $errores["cog"]?></span>
				</div>
				
				<div class="input-group">
					<label for=ident>Tipo de Ident:<span class="error">*</span>:
					</label> <select name=ident id="ident">
						<option value="DNI">DNI</option>
						<option value="NIE">NIE</option>
						<input type="text" id="numIdent"
						name="numIdent" value="<?php echo  $bien["numIdent"]?>">
						<span class="error"><?php echo  $errores["numIdent"]?></span>
					</select>
				</div>
				
				<div class="input-group">
    <label for="naci"><?php echo $textos["nacimiento"]; ?></label>
    <span>
        <input type="date" id="naci" name="naci"
               value="<?php echo date('Y-m-d'); ?>" 
               min="1900-01-01" max="<?php echo date('Y-m-d'); ?>" />
    </span>
</div>
				<div class="input-group">
					<label for="sexe" ><?php echo(($textos["sexe"]));?><span
						class="error">*</span>:</label> <select name="sexe" id="sexe">
						<option value="He">He</option>
						<option value="She">She</option>
						<option value="It">It</option>
						<option value="Node">Node</option>
					</select>
				</div>
				
				<div class="input-group">
					<label for="adreca"><?php echo(($textos["adreca"]));?>:</label> <input
						type="text" id="adreca" name="adreca" value="<?php echo $bien["adreca"]?>">
				</div>
				
				<div class="input-group">
					<label for="codi"><?php echo(($textos["codi"]));?>:</label> <input
						type="text" id="codi" name="codi" value="<?php echo $bien["codi"]?>">
				</div>
				
				<div class="input-group">
					<label for="poblacio"><?php echo(($textos["poblacio"]));?>:</label>
					<input type="text" id="poblacio" name="poblacio" value="<?php echo $bien["poblacio"]?>">
				</div>
				
				<div class="input-group">
					<label for="provincia"><?php echo(($textos["provincia"]));?>:</label>
					<input type="text" id="provincia" name="provincia" value="<?php echo $bien["provinica"]?>">
				</div>
				
				<div class="input-group">
					<label for="telefon"><?php echo(($textos["telèfon"]));?>:</label> <input
						type="text" id="telefon" name="telefon" value="<?php echo $bien["telefon"]?>">
				</div>
				
				<div class="input-group">
					<label for=Imagen><?php echo(($textos["imagen"]));?>:</label> <input
						type="file" name="Imagen" id="Imagen">
						<span class="error"><?php echo  $errores["img"]?></span>
				</div>
				
				<button type="submit" name="boto"><?php echo(($textos["registrar"]));?></button>
			</form>


		</div>
	</div>