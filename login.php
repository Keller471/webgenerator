<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="login.css">
</head>
<body>
	<div class="login-box">
		
		<h2>WebGenerator Gil Mauricio</h2>
		<form>

			<div class="user-box">
				<input type="text" name="email" required>
				<label>email</label>
			</div>
			<div class="user-box">
				<input type="password" name="Password" required>
				<label>Password</label>
			</div>
			<center><input type="submit" name="boton"></center>
			
			</form>
		<?php 
		$conexion = mysqli_connect("localhost", "adm_webgenerator", "”webgenerator2024", "webgenerator");
		$email = filter_input(INPUT_GET, 'email');
		$password = filter_input(INPUT_GET, 'Password');
		$boton = filter_input (INPUT_GET, 'boton');	
		if(isset($boton)){
		    $consulta = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
		    $res = mysqli_query($conexion, $consulta);
		    $resultados = [];
		    while($fila = mysqli_fetch_assoc($res)){
		        $resultados[] = $fila;
		    }
		    if(empty($resultados)){
		        echo "<center><h3>Los datos son inválidos</h3></center>";
		    }else{
		    	session_start();
	            $_SESSION ['idUsuario']=$resultados[0];
		        header('Location: panel.php');
		    }
	    }
		?>
		<div class="registro">
		<center><a href="register.php">ir al registro</a></center>
		</div>
	</div>
</body>
</html>			