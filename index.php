<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" type="text/css" href="estilo.css" />
	<meta charset="UTF-8">
	<title>Inicio</title>
</head>

<body>

<div id="contenedor">

	<div id="cabecera">
        <?php
        $_GET['cab'] = 1;
        require("cabecera.php");
        ?>
	</div>

	<div id="contenido">
	</div>

</div> <!-- Fin del contenedor -->

</body>
</html>