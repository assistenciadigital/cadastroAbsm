function validacampo (valida_campo) {
	
if (formulario.especialidade.value == '') {
		alert ('Por Favor Selecione a Especialidade!');
		formulario.especialidade.focus();
		return false;
	}

	if (formulario.nome.value == '') {
		alert ('Por Favor informe a Nome!');
		formulario.nome.focus();
		return false;
	}	

	if (formulario.descricao.value == '') {
		alert ('Por Favor informe a Descricao');
		formulario.descricao.focus();
		return false;
	}

	else return true;
	
}