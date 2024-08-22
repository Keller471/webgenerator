<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="panel.css">
</head>
<body>
	<div class="panel-box">
		<?php
		session_start();
		if ($_SESSION['idUsuario']['idUsuario']==4) {
			echo "<h2>Panel de administrador</h2>";
		} else {
			echo "<h2>Bienvenido a tu panel</h2>";
		}
		
		?>
		
		<form>
			<div class="botonañadir">
			<?php 
			
			if ($_SESSION['idUsuario']['idUsuario']!=4) {
				echo '
					<div class="user-box">
						<input type="text" name="nombre" required>
						<label>Generar web de:</label>
					</div>';
			}
			?>

				<?php 
				
				$conexion = mysqli_connect("localhost", "adm_webgenerator", "”webgenerator2024", "webgenerator");
				$nombre = filter_input(INPUT_GET, 'nombre');
				$boton = filter_input (INPUT_GET, 'boton'); 
				$fecha_actual = date('Y-m-d');
				if (isset($boton)) {
					$dominio = $_SESSION['idUsuario']['idUsuario'] . $nombre;
					$consulta = "SELECT * FROM webs WHERE dominio = '$dominio'";
					$res = mysqli_query($conexion, $consulta);
					$resultados = [];
					while($fila = mysqli_fetch_assoc($res)){
						$resultados[] = $fila;
					}
					if (empty($resultados)) {
						$consulta = "INSERT INTO webs (idUsuario, dominio, fechaCreacion) VALUES ('{$_SESSION['idUsuario']['idUsuario']}', '$dominio', '$fecha_actual')";
						$res = mysqli_query($conexion, $consulta);
						shell_exec("./wix.sh $dominio");
						header('Location: panel.php');
					}else{
						echo "El dominio ingreado ya esta en uso<br>";
					}
				}
				?>
				<a>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<?php
					if ($_SESSION['idUsuario']['idUsuario']!=4) {
						echo '
							<input type="submit" name="boton">';
					}
					?>
					
				</a>
			</div>
		</form>
		<?php
			if ($_SESSION['idUsuario']['idUsuario']==4) {
				echo "Dominios existentes:"; 
			}else{
				echo "Tus dominios son:"; 
			}
			
			echo '<div class="dominios">';
			$conexion = mysqli_connect("mattprofe.com.ar", "6918", "gecko.serbal.control", "6918");
			$Descargar = filter_input (INPUT_GET, 'Descargar');
			if($_SESSION['idUsuario']['idUsuario']==4){
				$consulta = "SELECT dominio FROM webs";
				$res = mysqli_query($conexion, $consulta);
				
			}else{
				$consulta = "SELECT dominio FROM webs WHERE idUsuario = '{$_SESSION['idUsuario']['idUsuario']}'";
				$res = mysqli_query($conexion, $consulta);
				
			}
			$resultados = [];
			while($fila = mysqli_fetch_assoc($res)){
				$resultados[] = $fila;
			}
			foreach ($resultados as $value) {
				echo '<div class="dominio">
				<div class="nombre-dominio">'.$value['dominio'].'</div>
				<a href="'.$value['dominio'].'">
				<button type="button">Ir a mi pagina</button>
				</a>
				<div class="descargar-dominio">
				<form>
				<a>
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				<input type="submit" name="descarga" value="Descargar">
				<input type="hidden" name="dominio1" value="'.$value['dominio'].'">
				</a>
				</form>
				</div>
				<div class="eliminar-dominio">
				<form>
				<a>
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				<input type="submit" name="eliminar" value="Eliminar">
				<input type="hidden" name="dominio" value="'.$value['dominio'].'">
				</a>
				</form>
				</div>
				</div>';

			}
			if(isset($_GET['descarga'])){
				$descarga=$_GET['dominio1'];
				shell_exec("zip -r '$descarga'.zip '$descarga'");
				$filename = "$descarga.zip";
				if (file_exists($filename)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="'.basename($filename).'"');
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Length: ' . filesize($filename));
					ob_clean();
					flush();
					readfile($filename);
					exit;
				}
			}

			if (isset($_GET['eliminar'])) {
				$dominioAEliminar = $_GET['dominio'];
				$consulta3 = "DELETE FROM webs WHERE dominio = '$dominioAEliminar'";
				$res = mysqli_query($conexion, $consulta3);
				shell_exec("rm -r '$dominioAEliminar'");
				shell_exec("rm -r '$dominioAEliminar'.zip");
				header('Location: panel.php');
			}
			?>
			<!-- cosas por hacer: css a lso botones del login y register, , terminar el cerrar sesion, crear cuenta admin -->
		</div>

	</div>
	<div class="cerrar-sesion">
		<?php
		echo '<button><a href="logout.php">cerrar sesion de '.$_SESSION['idUsuario']['idUsuario'].' </a></button>';
		?>
	</div>
</body>
</html>			