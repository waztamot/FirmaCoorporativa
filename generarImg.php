<?php
	$var_ok = 1;
	
	try{
		header("Content-Type: text/html;charset=utf-8");
	
		//	Varialbes
		/*
			$cedula = '16866530';
			$nombre = 'Javier Alarcon';
			$cargo  = 'Especialista de desarrollo y aplicaciones';
			$ceco   = 'UNIDAD DE TECNOLOGIA DE LA INFORMACION';
			$email  = 'soporte.desarrollo'
			$telf   = '251-4200200';
			$exte   = '235';
			$movil  = '424-5096118';
		*/
		$cedulaImg = utf8_decode($cedula);
		//		$nombre = utf8_decode('Javier Alarcón');
		if (empty(trim($equipo))){
			$nombreImg = utf8_decode($nombre);
			//		$cargo  = utf8_decode('Especialista de desarrollo y aplicaciones');
			$cargoImg  = utf8_decode($cargo);
		} else {
			$nombreImg = '';
			$cargoImg  = '';
		}

		//		$cargo  = utf8_decode('Especialista de desarrollo y aplicaciones');
		$cecoImg  = utf8_decode($ceco);
		//		$email  = utf8_decode('soporte.desarrollo@eltunal.com');
		$emailImg  = utf8_decode($email.'@eltunal.com');
		//		$telf   = utf8_decode('Directo: '. '0251-4200200'. ' Ext. '. '230');
		$telfImg   = utf8_decode('Directo: +58 '.$telf.' Ext. '.$exte);
		//		$movil	= utf8_decode('Móvil:   '. '0424-5096118');
		if (empty(trim($movil))){
			$movilImg  = ' ';
		} else {
			$movilImg  = utf8_decode('Móvil:   +58 '.$movil);
		}

		$paginaImg = utf8_decode('http://www.eltunal.com');
		if (isset($website)){
			if (!empty(trim($website))){
				$paginaImg = utf8_decode('http://'.$website);
			}
		}

		$Nrolin	= 10;
		
		// 	Crear una imagen en blanco	
		$im = imagecreate(288, 115);
		
		//	Darle color al texto y al fondo
		$color_fondo = imagecolorallocate($im, 255, 255, 255);
		$color_text0 = imagecolorallocate($im, 0, 0, 0);
		$color_text1 = imagecolorallocate($im, 0, 153, 255);
		//	Prueba de cambio de letra
		/*$fuente = 'ttf/chiller.ttf'; 
		$tamanoFuente=12;
		imagettftext($im, $tamanoFuente, 0, 8, $Nrolin+10, $color_text0, $fuente, trim($nombreImg));
		$Nrolin = $Nrolin + 15;*/
		
		//	Añadir algún texto
		imagestring($im, 3, 8, $Nrolin,  trim($nombreImg), $color_text0);
		$Nrolin = $Nrolin + 15;
		imagestring($im, 2, 8, $Nrolin,  $cargoImg, $color_text0);
		$Nrolin = $Nrolin + 15;
		imagestring($im, 2, 8, $Nrolin,  $cecoImg, $color_text0);
		$Nrolin = $Nrolin + 15;
		imagestring($im, 2, 8, $Nrolin,  $emailImg, $color_text1);
		$Nrolin = $Nrolin + 15;
		imagestring($im, 2, 8, $Nrolin,  $telfImg, $color_text0);
		$Nrolin = $Nrolin + 15;
		imagestring($im, 2, 8, $Nrolin,  $movilImg, $color_text0);
		$Nrolin = $Nrolin + 15;
		imagestring($im, 2, 8, $Nrolin,  $paginaImg, $color_text1);
		
	
		// Guardar la imagen como archivo png
		imagepng($im, 'img/user/'.$cedula.'.png');
	
		// Liberar memoria
		imagedestroy($im);
	} catch(Exception $e) {
		//	Cambiar variable de verificacion
		$var_ok = 0;
	}
	
	session_start();
	$_SESSION["ok1"]=$var_ok;
?>