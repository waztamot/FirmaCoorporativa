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
            	<h3 class="panel-title" align="center">Datos del Empleado</h3>
		  	</div>
            <div class="panel-body">
            	<div id="txtHint">
                	<form name="formBCed" method="post" onSubmit="return validarCedula(this)" action="datosCedula.php">
						<div class="input-group input-group-sm">
                        	<span class="input-group-addon" style="width:100px">Cédula</span>
                            <input 	type="text" class="form-control" placeholder="Ingrese la cédula" 
                            		style="width:190px" maxlength="8" name="txtCedula" alt="Cedula"
                                    onkeyup="mascara(this,'-',patronCedula,true)"
                                    id="cedula"> &nbsp;
                          	<button type="submit" class="label btn btn-primary">
                       			<span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                              	&nbsp;Buscar
                          	</button>
                        </div>
					</form>
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon" style="width:100px">Nombre</span>
                        <input 	type="text" class="form-control" placeholder="Nombres y apellidos" 
                                readonly required name="txtNombre" alt="Nombres"
                                id="nombre">
                        <span class="input-group-addon" style="width:100px">Cargo</span>
                        <input 	type="text" class="form-control" placeholder="Cargo  en la empresa"
                                readonly required name="txtCargo" alt="Cargo"
                                id="cargo">
                        <span class="input-group-addon" > Estatus: &nbsp;
                            <span class="label label-info">
                                <?php 
                                    echo "------";
                                ?>
                            </span>
                        </span>
                    </div>
					<div class="input-group input-group-sm">
						<span class="input-group-addon" style="width:100px">Centro de Costo</span>
						<input 	type="text" class="form-control" placeholder="Centro de Costo" 
                            		readonly required name="txtCeco" alt="Area"
                                    id="ceco">
						<span class="input-group-addon"></span>
					</div>
                    <br>
                </div>
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
<!-- end scripts -->
<script type="text/javascript">
	formBCed.txtCedula.focus();
</script>
</body>
</html>