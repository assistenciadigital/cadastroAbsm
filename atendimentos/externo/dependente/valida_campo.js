function validacampo (valida_campo) {

if (formulario.nome.value == '') {
		alert ('Por Favor informe o Nome!');
		formulario.nome.focus();
		return false;
	}

	if (formulario.nascimento.value == '') {
		alert ('Por Favor informe o Nascimento!');
		formulario.nascimento.focus();
		return false;
	}	
	
	if (formulario.sexo[0].checked == false && formulario.sexo[1].checked == false){
		alert ('Por Favor Selecione o Sexo!');
		return false;
	}		
	
	if (formulario.parentesco[0].checked == false && formulario.parentesco[1].checked == false){
		alert ('Por Favor Selecione o Parentesco!');
		return false;
	}	

	else return true;
	
}