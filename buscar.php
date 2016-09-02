<?php
	
	$q = $_GET['q'];

	if ($q == '') {
		$q = 16866530;
	}

	// Conectar al servicio XE (es deicr, la base de datos) en la máquina "localhost"
	$conn = oci_connect('Desarrollo', 'Aa4417982', 'prodoracle.servers.int/TPROD','UTF8');
	if (!$conn) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	} else {
	
		$stid = oci_parse($conn, 'select cias,cedula,nombre,cargdescri,activi from TUNAL.DATBASMAILS where cedula =' .$q.' and activi = 1');
		oci_execute($stid);
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			foreach ($row as $item) {
				echo $item.' <br>';
			}
		}
		
		$stid = oci_parse($conn, 
					'select e.ciasimg from tunal.datbasmails d, desarrollo.imagencompias e where d.cedula =' 
					.$q. ' and d.cias=e.ciassql');
		oci_execute($stid);
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			foreach ($row as $item) {
				echo $item.' <br>';
			}
		}
	}
?>
