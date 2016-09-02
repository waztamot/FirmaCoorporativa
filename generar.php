<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="es"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="es"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/style.css">
<!-- <link href="css/bootstrap.css" rel="stylesheet" type="text/css"> -->
<link href="css/bootstrap-3.3.4.css" rel="stylesheet" type="text/css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
  <!--[if lt IE 7]>
  <p class="chromeframe">¡Tu navegador es <em>muy antiguo!</em> <a href="http://browsehappy.com/">Actualiza a un navegador diferente</a> o <a href="http://www.google.com/chromeframe/?redirect=true">instala Google Chrome Frame</a> para disfrutar de este sitio.</p>
  <![endif]-->
  <div id="wrapper">
	<div id="header">
            <img src="img/logo.png"  style="float:left;" height="90" width="90" >
            <h1 style="text-align: center;">Sistema de Integración</h1>
            <h2 style="text-align: center;">Aplicaciones tunal</h2>
            <ul id="nav">
                <li><a href="index.php" data-hash="#index">Inicio</a></li>
                <li><a href="datos.php" data-hash="#datos">Datos</a></li>
                <li><a href="soporte.php" data-hash="#soporte">Soporte</a></li>
                <li><a href="acerca.php" data-hash="#acerca">Acerca de..</a></li>
            </ul>
	</div>
	<div class="clearfix"></div>
	<div id="contenido">
    	<h2 style="text-align: center;">
    	<span class="label label-default">Generar Firma de LotusNotes</span></h2>		
        <img src="img/User_Circle.png"  style="float:right;" height="40" width="40">
      	<div class="panel panel-default">
			<div class="panel-heading">
            	<h3 class="panel-title" align="center">Pasos a seguir</h3>
		  	</div>
            <div class="panel-body">
            	<?php 
					//	Variables
					$cedula = utf8_decode($_POST['txtCedula']);
					$nombre = $_POST['txtnombfirm'];
					$cargo	= $_POST['txtCargo'];
					$ceco	= $_POST['txtCeco'];
					if (strpos($_POST['txtCorreo'], "@")=== false) {
						$email	= $_POST['txtCorreo'];
					} else {
						$email	= substr($_POST['txtCorreo'],0,strpos($_POST['txtCorreo'], "@"));
					}
					$telf	= utf8_decode($_POST['txtTelf']);
					$telf	= substr($telf, 1);
					$exte	= utf8_decode($_POST['txtExtension']);
					$movil	= utf8_decode($_POST['txtCelular']);
					$movil	= substr($movil, 1);
					$equipo = utf8_decode($_POST['rdbEquipo']);
					
					//	Calculo interno
					// Conectar al servicio XE (es deicr, la base de datos) en la máquina "localhost"
					$conn = oci_connect('Desarrollo', 'Aa4417982', 'prodoracle.servers.int/TPROD');
					if (!$conn) {
						$e = oci_error();
						trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
					} else {
						$stid = oci_parse($conn, 
							'select e.ciasimg from tunal.datbasmails d, desarrollo.imagencompias e where d.cedula =' 
							.$cedula. ' and d.cias=e.ciassql');
						oci_execute($stid);
						while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
							foreach ($row as $item) {
								$empresa = $item;
							}
						}
					}
					
					//	Generar Firma en imagen
					include ('generarImg.php');

					//	Generar Archivador
					$var_ok1	=	$_SESSION["ok1"];
					if ($var_ok1 == 1) {
						include ('generarFirma.php');
						//include ('generarBat.php');
					} else {
						echo '<script language="javascript">
								alert("Error - No se pudo generar la firma");
							  </script>';
					}
					
					//	Proceso para Descargar Archivador
					$var_ok2	=	$_SESSION["ok2"];
					if ($var_ok1 == 1 and $var_ok2 == 1) {
						echo '<script language="javascript">
								alert("Firma generada exitosamente");
							  </script>';
						$info=detect();
						//download="FirmaDigital'.$cedula.'.zip"> 
						//<a href="arc_zip/FirmaDigital'.$cedula.'.zip;bat/ConfigurarFirma.bat">
						//<a href="down.php?cedula='.$cedula.'.zip" target="new">
						//<a href="userB/FirmaDigital'.$cedula.'.bat" download="FirmaDigital'.$cedula.'.bat">
						if ($info["browser"] == 'FIREFOX'){
							echo '<h3 class="panel-title" align="center">Por favor siga las siguientes intrucciones:</h3>';
							echo '<br>';
							echo '1) Presione el siguiente enlace para descargar su firma: 
									<a href="arc_zip/FirmaDigital'.$cedula.'.zip" download="FirmaDigital'.$cedula.'.zip">
										Firma Digital
									</a>';
							echo '<div align="center"><img src="img/Firma1_Firefox.png" width="579" height="318"/></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'por favor asegurarse de seleccionar la opcion de "Guardar"(Salve File) y 
									presionar el boton "Aceptar"(OK)</h3><br>';
							echo '<div align="center"><img src="img/Firma2_Firefox.png" width="442" height="321"/></div>';		
							echo '<br>';
							echo '2) Descargue el archivo de configuracion de su firma presionando el siguiente enlace: 
									<a href="bat/ConfigurarFirma.bat" download="ConfigurarFirma.bat">
										Configurar Firma
									</a>';
							echo '<div align="center"><img src="img/Config1_Firefox.png" width="593" height="294"/></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'por favor asegurarse de seleccionar la opcion de "Guardar" (Salve File)</h3><br>';
							echo '<div align="center"><img src="img/Config2_Firefox.png" width="453" height="201"/></div>';		
							echo '<br>';
							echo '3) Ejecute el archivo de configuracion descargado "ConfigurarFirma" para ello haga 
									lo siguiente:';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Dirigase a la parte superior derecha y haga click en el icono en forma de flecha abajo
									</h3><br>';
							echo '<div align="center"><img src="img/Ejecutar1_Firefox.png" width="545" height="257"/></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Dirigase al archivo descargado "ConfigurarFirma" y haga doble click en el mismo
									</h3><br>';
							echo '<div align="center"><img src="img/Ejecutar2_Firefox.png" width="521" height="179"/></div>';
							echo '4) Coloque la firma en el lotus notes:';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Abra el programa lotus notes y dirijase a la opcion "Archivo->Preferencias..." haga click 
									en ella</h3><br>';
							echo '<div align="center"><img src="img/Lotus1.png" width="594" height="428"/></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Dirigase a la opcion "Correo->Firma" y seleccione la opcion "Archivo HTML o de imagen"
									</h3><br>';
							echo '<div align="center"><img src="img/Lotus2.png" width="599" height="507"></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Copie la siguiente ruta:</h3><h4 align="center">C:\\SysIT\\'.$cedula.
								 '.html</h4><h3 class="panel-title" align="center"> y peguela en la casilla mostrada 
								 en la imagen</h3><br>';
							echo '<div align="center"><img src="img/Lotus3.png" width="599" height="508"></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Presione el boton "Aceptar" y listo tendra su nueva firma configurada</h3><br>';
						} elseif ($info["browser"] == 'CHROME') {
							echo '<h3 class="panel-title" align="center">Por favor siga las siguientes intrucciones:</h3>';
							echo '<br>';
							echo '1) Presione el siguiente enlace para descargar su firma: 
									<a href="arc_zip/FirmaDigital'.$cedula.'.zip" download="FirmaDigital'.$cedula.'.zip">
										Firma Digital
									</a>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'por favor asegurarse de seleccionar la opcion de "Guardar"(Salve File)</h3><br>';
							echo '<div align="center"><img src="img/Firma1_Chrome.png" width="533" height="306"/></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'en la parte inferior del navegador aparece el archivo descargado</h3><br>';
							echo '2) Descargue el archivo de configuracion de su firma presionando el siguiente enlace: 
									<a href="bat/ConfigurarFirma.bat" download="ConfigurarFirma.bat">
										Configurar Firma
									</a>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'por favor asegurarse de seleccionar la opcion de "Guardar"(Salve File)</h3><br>';
							echo '<div align="center"><img src="img/Config1_Chrome.png" width="532" height="310"/></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'en la parte inferior del navegador aparece el archivo descargado</h3><br>';
							echo '3) Ejecute el archivo de configuracion descargado "ConfigurarFirma" para ello haga 
									lo siguiente:';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Dirigase a la parte inferior izquierda donde se encuentra el archivo descargado y haga 
									click sobre el mismo</h3><br>';
							echo '<div align="center"><img src="img/Ejecutar1_Chrome.png" width="533" height="311"/></div>';
							echo '<br>';
							echo '4) Coloque la firma en el lotus notes:';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Abra el programa lotus notes y dirijase a la opcion "Archivo->Preferencias..." haga click 
									en ella</h3><br>';
							echo '<div align="center"><img src="img/Lotus1.png" width="594" height="428"/></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Dirigase a la opcion "Correo->Firma" y seleccione la opcion "Archivo HTML o de imagen"
									</h3><br>';
							echo '<div align="center"><img src="img/Lotus2.png" width="599" height="507"></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Copie la siguiente ruta:</h3><h4 align="center">C:\\SysIT\\'.$cedula.
								 '.html</h4><h3 class="panel-title" align="center"> y peguela en la casilla mostrada 
								 en la imagen</h3><br>';
							echo '<div align="center"><img src="img/Lotus3.png" width="599" height="508"></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Presione el boton "Aceptar" y listo tendra su nueva firma configurada</h3><br>';
						} else {
							echo '<h3 class="panel-title" align="center">Por favor siga las siguientes intrucciones:</h3>';
							echo '<br>';
							echo '1) Presione el siguiente enlace para descargar su firma: 
									<a href="arc_zip/FirmaDigital'.$cedula.'.zip" download="FirmaDigital'.$cedula.'.zip">
										Firma Digital
									</a>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'por favor asegurarse de seleccionar la opcion de "Guardar"(Salve File)</h3><br>';
							echo '<div align="center"><img src="img/Firma1_IE.png" width="531" height="298"/></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'verifique que se descargo completamente el archivo y haga click sobre la "X"</h3><br>';
							echo '<div align="center"><img src="img/Firma2_IE.png" width="586" height="49"/></div>';		
							echo '<br>';
							echo '2) Descargue el archivo de configuracion de su firma presionando el siguiente enlace: 
									<a href="bat/ConfigurarFirma.bat" download="ConfigurarFirma.bat">
										Configurar Firma
									</a>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'seleccione la opcion de "Guardar"(Salve File)</h3><br>';		
							echo '<div align="center"><img src="img/Config1_IE.png" width="539" height="316"/></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'una vez descargado seleccione la opcion de "Abrir Carpeta"</h3><br>';
							echo '<div align="center"><img src="img/Config2_IE.png" width="535" height="37"/></div>';		
							echo '<br>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'se abrira una nueva ventana con el archivo descargado haga docle click sobre el 
									archivo "ConfigurarFirma"</h3><br>';
							echo '<div align="center"><img src="img/Config3_IE.png" width="591" height="346"/></div>';		
							echo '<br>';
							echo '3) Coloque la firma en el lotus notes:';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Abra el programa lotus notes y dirijase a la opcion "Archivo->Preferencias..." haga click 
									en ella</h3><br>';
							echo '<div align="center"><img src="img/Lotus1.png" width="594" height="428"/></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Dirigase a la opcion "Correo->Firma" y seleccione la opcion "Archivo HTML o de imagen"
									</h3><br>';
							echo '<div align="center"><img src="img/Lotus2.png" width="599" height="507"></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Copie la siguiente ruta:</h3><h4 align="center">C:\\SysIT\\'.$cedula.
								 '.html</h4><h3 class="panel-title" align="center"> y peguela en la casilla mostrada 
								 en la imagen</h3><br>';
							echo '<div align="center"><img src="img/Lotus3.png" width="599" height="508"></div>';
							echo '<br><h3 class="panel-title" align="center">';
							echo 'Presione el boton "Aceptar" y listo tendra su nueva firma configurada</h3><br>';		
						}
					} else {
						if ($var_ok2 != 1) {
							echo '<script language="javascript">
									alert("Error - No se pudo generar la firma");
								  </script>';
						}
					}
				?>
       	  </div>
          <div class="panel-footer" align="center">
          </div>
   	  </div>
    </div>
    <div id="notif">
    </div>
  </div>
	<script src="js/libs/jquery-1.7.1.min.js"></script>
    <!-- scripts concatenated and minified via build script -->
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
    <?php
		function detect(){

			$browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
			$os=array("WIN","MAC","LINUX");

			# definimos unos valores por defecto para el navegador y el sistema operativo
			$info['browser'] = "OTHER";
			$info['os'] = "OTHER";

			# buscamos el navegador con su sistema operativo
			foreach($browser as $parent){

				$s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
				$f = $s + strlen($parent);
				$version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
				$version = preg_replace('/[^0-9,.]/','',$version);

				if ($s)	{
					$info['browser'] = $parent;
					$info['version'] = $version;
				}
			}
			
			# obtenemos el sistema operativo
			foreach($os as $val){
				if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
					$info['os'] = $val;
			}
		
			# devolvemos el array de valores
			return $info;
		}
	?>
    <!-- end scripts -->
</body>
</html>