<?php
	$var_ok = 1;
	
	try{
		//	Variables
		$pagina  = "
			<!doctype html>
			<html>
			<head>
			<meta charset='utf-8'>
			<style>
			body{
				font-family:'Arial';
				font-size:13px;
			}
			table{
				font-family:'Arial';
				font-size:13px;
			}
			</style>
			</head>
			<body>
				<table width='398' border='0'>
				  <tbody>
					<tr>
					  <td colspan='2'>
						<img src='img/fondoFirma_top.png' width='437' height='18'/>
					  </td>
					</tr>
					<tr>
					  <td width='145' height='117'>
						<img src='img/fondoFirma_middle-".$empresa.".png' width='123' height='96'/>
					  </td>
					  <td width='288' >
						<img src='img/user/".$cedula.".png'/>
					  </td>
					</tr>
					<tr>
					  <td height='55' colspan='2'>
						<img src='img/fondoFirma_button.png' width='437' height='55'/>
					  </td>
					</tr>
				  </tbody>
				</table>
			</body>
			</html>";
			
		ob_start(); // comienzo a guardar la salida en el buffer
		echo $pagina;
		$out = ob_get_contents(); // capturo la salida
		ob_end_clean();  // cierro buffer
		file_put_contents('userF/'.$cedula.'.html',$out);  // almaceno
	
		$zip = new ZipArchive();
		$filename = "./arc_zip/FirmaDigital".$cedula.".zip";
	
		if ($zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE)!==TRUE) {
			exit("cannot open <$filename>\n");
		} else {
			$zip->addEmptyDir('img');
			$zip->addEmptyDir("img/user");
			$zip->addFile('img/fondoFirma_button.png','img/fondoFirma_button.png');
			$zip->addFile('img/fondoFirma_middle-'.$empresa.'.png','img/fondoFirma_middle-'.$empresa.'.png');
			$zip->addFile('img/fondoFirma_top.png','img/fondoFirma_top.png');
			$zip->addFile('img/user/'.$cedula.'.png','img/user/'.$cedula.'.png');
			$zip->addFile('userF/'.$cedula.'.html',$cedula.'.html');
			$zip->close();
		}
	} catch(Exception $e) {
		//	Cambiar variable de verificacion
		$var_ok = 0;
	}
	
	//session_start();
	$_SESSION["ok2"]=$var_ok;

?>
