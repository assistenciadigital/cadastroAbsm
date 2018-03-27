function validacampo (valida_campo) {

if (formulario.especialidade.value == '') {
		alert ('Por Favor Selecione a Especialidade!');
		formulario.especialidade.focus();
		return false;
	}

	else return true;
	
}