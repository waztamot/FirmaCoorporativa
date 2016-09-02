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
	<div class="clearfix">
		<?php
			$cedula = $_POST['txtCedula'];
			$activi = -1;
			$nombre = '';
			$cargo  = '';
			$ceco	= '';
			$activitxt = '------';
			
			// Conectar al servicio XE (es deicr, la base de datos) en la máquina "localhost"
			$conn = oci_connect('Desarrollo', 'Aa4417982', 'prodoracle.servers.int/TPROD','UTF8');
			
			if (!$conn) {
				$e = oci_error();
				trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			} else {
				$stid = oci_parse($conn, 
					'select nombre,cargdescri,activi,cecodescri from TUNAL.DATBASMAILS where cedula =' .$cedula);
				oci_execute($stid);
				$nro = 0;
				while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
					foreach ($row as $item) {
						if ($nro == 0) {
						 	$nombre = $item;
						}
						if ($nro == 1) {
							$cargo = $item;
						}
						if ($nro == 2){
							$activi = (int)$item;
						}
						if ($nro == 3){
							$ceco = $item;
						}
						$nro = $nro + 1;
					}
				}
				if ($activi == 0 or $activi == 9) {
					$activitxt = 'Inactivo';
				} else {
					
					if ($activi > 0) {
						$arrnombre = explode(" ", $nombre);
						$cntnombre = count($arrnombre);
						$activitxt = 'Activo';
					}
				}
			}
        ?>
    </div>
	<div id="contenido">
    	<h2 style="text-align: center;">
    	<span class="label label-default">Generar Firma de LotusNotes</span></h2>		
        <img src="img/User_Circle.png"  style="float:right;" height="40" width="40">
      	<div class="panel panel-default">
			<div class="panel-heading">
            	<h3 class="panel-title" align="center">Datos del Empleado</h3>
		  	</div>
       	  	<form name="formGenerarFirma" method="post" onSubmit="return validarCampos(this)" action="generar.php">
                <div class="panel-body">
                    <div id="txtHint">
                   	  <div class="input-group input-group-sm">
                            <span class="input-group-addon" style="width:100px">Cédula</span>
                            <input 	type="text" class="form-control" placeholder="Ingrese la cédula" 
                            		style="width:190px" maxlength="8" name="txtCedula" alt="Cedula"
                                    onkeyup="mascara(this,'-',patronCedula,true)"
                                    id="cedula" value="<?php echo $cedula?>" 
																			<?php if ($activi != -1) {
                                                                                      echo 'readonly';
                                                                                   }
                                                                            ?>> &nbsp;
                          <span class="label btn btn-primary">
                       		  <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                              &nbsp;Buscar
                          </span>
                        </div>
                        <div class="input-group input-group-sm">
                        	<span class="input-group-addon" style="width:100px">Nombre</span>
                          	<input 	type="text" class="form-control" placeholder="Nombres y apellidos" 
                            		readonly required name="txtNombre" alt="Nombres"
                                    id="nombre" value="<?php echo $nombre?>">
                          	<span class="input-group-addon" style="width:100px">Cargo</span>
                          	<input 	type="text" class="form-control" placeholder="Cargo  en la empresa"
                            		readonly required name="txtCargo" alt="Cargo"
                                    id="cargo" value="<?php echo $cargo?>">
                            <span class="input-group-addon" > Estatus: &nbsp;
                            	<?php 
									if ($activi == 0 or $activi == 9) {
										echo "<span class='label label-danger'>";
									} else {
										echo "<span class='label label-info'>";
									}
									echo $activitxt;
								?>
                                </span>
                            </span>
                        </div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Centro de Costo</span>
							<input 	type="text" class="form-control" placeholder="Centro de Costo" 
                            		readonly required name="txtCeco" alt="Area"
                                    id="ceco" value="<?php echo $ceco?>">
						</div>
                        <br>
                        <?php
							if ($activi != -1 and $activi != 0 and $activi != 9) {
								echo "<div class='input-group input-group-sm'>";
								for ($g = 0; $g < $cntnombre; $g++){
									echo "
										<span class='input-group-addon'>
											<input 	type='checkbox' value='$arrnombre[$g]' checked='checked'
													id='ckb' name='ckb$g' onClick=\"generarNombFirma($cntnombre)\">
												&nbsp;&nbsp;$arrnombre[$g]
										</span>";
								}
								echo "
									</div>
									<div class='input-group input-group-sm'>
										<span class='input-group-addon'>
											Nombre que sera mostrado en la firma
										</span>
										<input 	type='text' class='form-control' placeholder='Nombre que aparecera en la firma'
												readonly required name='txtnombfirm' alt='Nombre Firma' id='nombrefirma'
												value='$nombre'>
									</div>";
								echo "
									<div class='input-group input-group-sm'>
										<span class='input-group-addon' style='width:100px'>Telef. Directo</span>
										<input 	type='text' class='form-control' placeholder='N° Fijo de la empresa'
												style='width:288px' maxlength='12' max='12' min='12'
												name='txtTelf' alt='Telefono' id='telefono' 
												onkeyup=\"mascara(this,'-',patronTelefono,true)\">
										<span class='input-group-addon' style='width:100px'>Extensión</span>
										<input 	type='text' class='form-control' placeholder='N° Ext'
												style='width:100px' maxlength='3' min='3' max='3'
												name='txtExtension' alt='Extension' id='ext'
												onkeyup=\"mascara(this,'-',patronExt,true)\">
										<span class='input-group-addon' style='width:100px'>Movil</span>
										<input 	type='text' class='form-control' placeholder='N° Telf. Celular (Opcional)'
												style='width:200px' maxlength='12' max='12' min='12'
												name='txtCelular' alt='Celular' id='celular'
												onkeyup=\"mascara(this,'-',patronTelefono,true)\">
									</div>
									<div class='input-group input-group-sm'>
										<span class='input-group-addon' style='width:100px'>Correo</span>
										<input 	type='text' class='form-control' placeholder='Correo de la empresa'
												maxlength='50' name='txtCorreo' alt='Correo' id='correo'>
										 <span class='input-group-addon'>@eltunal.com</span>
									</div>
									<div class='input-group input-group-sm'>
										<span class='input-group-addon'>
											Comparte esta cuenta de correo con otras personas en este mismo equipo?
											&nbsp;&nbsp;&nbsp;
											<input type='radio' id='Equipo' name='rdbEquipo' alt='Comparte Equipo' value='SI'>Si&nbsp;&nbsp;
											<input type='radio' id='Equipo' name='rdbEquipo' alt='Comparte Equipo' value=''>No
										</span>
										<span class='input-group-addon'></span>
									</div>";
							}
						?>
                    </div>
                </div>
           		<div class="panel-footer" align="center">
            		<?php
						if ($activi != -1 and $activi != 0 and $activi != 9) {
							echo "
                  				<button type='submit' class='btn btn-primary'>Generar</button>&nbsp;
                  				<button type='reset' class='btn btn-primary'>Cancelar</button>
								<a href='datos.php'>
									<button type='button' class='btn btn-primary'>Atras</button>
								</a>
								<script type='text/javascript'>
									formGenerarFirma.txtTelf.focus();
								</script>
								";
						} else {
							echo "
								<a href='datos.php'>
									<button type='button' class='btn btn-primary'>Atras</button>
								</a>
								<script type='text/javascript'>
									formGenerarFirma.txtCedula.focus();
								</script>
								";
						}
						if ($activi == -1) {
							echo '<script language="javascript">
									alert("Error - La Cedula no existe");
								  </script>';
						} else {
							if ($activi == 0 and $activi == 9){
								echo '<script language="javascript">
										alert("Error - El Empleado se encuentra inactivo");
									  </script>';
							}
						}
					?>
           	  </div>
            </form>
   	  </div>
    </div>
        <div id="notif">
			
        </div>
  </div>
	<script src="js/libs/jquery-1.7.1.min.js"></script>
    <!-- scripts concatenated and minified via build script -->
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
    <!-- end scripts -->
</body>
</html>
