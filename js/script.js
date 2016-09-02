/*	Author: Javier Alarcon
	Email:	soporte.desarrollo@eltunal.com
*/

var patronTelefono 	= new Array(4,7);		// 000-000000
var patronFecha 	= new Array(2,2,4);		// DD/MM/AAAA
var	patronExt		= new Array(3,1);			// 000
var	patronCedula	= new Array(8,1);			// 00000000

function validarCedula(form){
	
	if (form.txtCedula.value.length < 6 || form.txtCedula.value.length > 8){
		alert ('Campo cedula no valido, debe poseer minimo 6 digitos');
		form.txtCedula.focus();
		return (false);
	}
	
	//Para Validar Solo numeros
  	var checkOK = "0123456789" ;//por mientras las letras
  	var checkStr = form.txtCedula.value;
  	var allValid = true;
  	var decPoints = 0;
  	var allNum = "";
	for (i = 0; i < checkStr.length; i++) {
		ch = checkStr.charAt(i);
		for (j = 0; j < checkOK.length; j++)
		  if (ch == checkOK.charAt(j))
			break;
		if (j == checkOK.length) {
		  allValid = false;
		  break;
		}
		allNum += ch;
	}
  	if (!allValid) {
		alert("Escriba solo numeros en el campo \"Cedula\".");
		form.txtCedula.focus();
		return (false);
  	}
	
	return (true);
}

function validarCampos(form) {

	for (var i=0; i<form.length; i++) {
		if(form[i].type ==='text' && form[i].name != 'txtCelular') {
			if (form[i].value === null || form[i].value.length === 0 || /^\s*$/.test(form[i].value)){
				alert("El campo '"+ form[i].alt +"' no puede estar vacío o contener sólo espacios en blanco");
				form[i].focus();
				return (false);
			}
		}
	}
	
	opciones = document.getElementsByName("rdbEquipo");
	var opcion = false;
	for(var x=0; x<opciones.length; x++){
		if (opciones[x].checked){
			opcion = true;
		}
	}
	if (!opcion){
		alert("El campo 'Comparte Equipo' no puede estar vacío, debe seleccionar una opcion");
		return (false);
	}
	
	return (true);
}

function mascara(d,sep,pat,nums){
	if(d.valant != d.value){
		val = d.value;
		largo = val.length;
		val = val.split(sep);
		val2 = '';
		for(r=0;r<val.length;r++){
			val2 += val[r];
		}
		if(nums){
			for(z=0;z<val2.length;z++){
				if(isNaN(val2.charAt(z))){
					letra = new RegExp(val2.charAt(z),"g");
					val2 = val2.replace(letra,"");
				}
			}
		}
		val = '';
		val3 = new Array();
		for(s=0; s<pat.length; s++){
			val3[s] = val2.substring(0,pat[s]);
			val2 = val2.substr(pat[s]);
		}
		for(q=0;q<val3.length; q++){
			if(q ==0){
				val = val3[q];
			}
			else{
				if(val3[q] != ""){
					val += sep + val3[q];
				}
			}
		}
		d.value = val;
		d.valant = val;
	}
}

function generarNombFirma(cant){
	
	var form = document.formGenerarFirma;
	form.txtnombfirm.value = "";
	
	for (var i = 0; i < form.length; i++) {
		if(form[i].type ==='checkbox' && form[i].name.substring(0,3) === 'ckb') {
			if (form[i].checked){
				form.txtnombfirm.value = form.txtnombfirm.value + ' ' + form[i].value;
			}
		}
	}
	
	return true;
}
