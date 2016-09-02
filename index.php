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
  <link href="css/bootstrap-3.3.4.css" rel="stylesheet" type="text/css">	
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
		<div align="center">
        	<img src="img/org_tunal_logo.png" width="400" height="400" alt="Organizacion El Tunal C.A."/>
        </div>
	</div>
  </div>
  <div align="center" class="ejemplo">
	Copyright 2015 &copy; Webmaster <a href="http://www.eltunal.com/">Organización El Tunal C.A.</a>
  </div>

  <script src="js/libs/jquery-1.7.1.min.js"></script>

  <!-- scripts concatenated and minified via build script -->
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <!-- end scripts -->
  <script type="text/javascript">
	(function($){
		var contenido = $('div#contenido'), 
                    url_anterior = '', 
                    extension = '.php', 
                    original = window.location;
		$('ul#nav a').each(function(){ //Cambiamos los href por el contenido del atributo data-hash
			$(this).attr('href', $(this).data('hash'));
		});
		$('ul#nav a').on('click', function(e){			
			var hash = $(this).attr('href'); 
			e.preventDefault();  
			revisarURL(hash).done(function(){
				window.location.href = hash; // Buen hash, cambiemoslo en la URL			
			}).fail(function(){
				window.location.href = '#error';
			}).always(function(datos){
				contenido.html(datos);
			});
			
		});
		
		revisarURL(); // Si hay un hash en la URL (ej, copiamos y pegamos en una conversación) cargará la URL correcta.
		setInterval(function(){
			revisarURL().fail(function(){
				window.location.href = '#error';
			}).always(function(datos){
				contenido.html(datos);
			});
		},250); // Revisamos cualquier cambio en el Hash cada 250 milisegundos
		
		function revisarURL (hash){
			var deferred = $.Deferred();
			if (!hash) { // Esto ocurre	cuando se pulsa el botón de atrás o adelante en el navegador o al pasar una URL con hash
				hash = window.location.hash;
			}
			if (!hash) { // Esto puede pasar si es la primera URL - index.html en nuestro caso
				var url = window.location.pathname; // Obtenemos la URL completa
				var archivo = url.substring(url.lastIndexOf('/')+1); // Nos quedamos con el nombre del archivo (index.html)
				hash = archivo.replace(extension,''); // Le quitamos la extensión para convertirlo en "hash"
			}
			if (hash !== url_anterior){ 
				url_anterior = hash; 
				cargarPagina(hash).done(
					function(data){	
						var html = $(data);
						var filtrado = html.find('#contenido');
						deferred.resolve(filtrado.html());
					}
				).fail(function(){ // La URL no existe					
					deferred.reject('<p>La página no existe.</p>'); // Rechazamos nuestro deferred		
				});
			}
			return deferred.promise(); // Devolvemos una promesa, no un deferred
		}
		function cargarPagina(hash){
			url = hash.replace('#','');  //Quitamos la almohadilla
			return $.ajax({
				url: url + extension,
				async: true,
				dataType: "html"});			
		}
	})(jQuery);
  </script>
</body>
</html>
