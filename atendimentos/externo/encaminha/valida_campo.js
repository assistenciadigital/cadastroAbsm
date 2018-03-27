function validacampo (valida_campo) {
	
if (formulario.numero_guia.value == '') {
		alert ('Por Favor informe o Numero da Guia de Encaminhamento!');
		formulario.numero_guia.focus();
		return false;
	}

	if (formulario.data_guia.value == '') {
		alert ('Por Favor informe a Data da Guia de Encaminhamento!');
		formulario.data_guia.focus();
		return false;
	}	

	if (formulario.empresa.value == '') {
		alert ('Por Favor Selecione a Empresa!');
		formulario.empresa.focus();
		return false;
	}	
	
	if (formulario.empregado.value == '') {
		alert ('Por Favor Selecione o Empreagado!');
		formulario.empregado.focus();
		return false;
	}	
	
	if (formulario.autorizador.value == '') {
		alert ('Por Favor informe o Nome do Autorizador!');
		formulario.autorizador.focus();
		return false;
	}	
	
	if (formulario.funcao.value == '') {
		alert ('Por Favor informe a Funcao!');
		formulario.funcao.focus();
		return false;
	}	
	
	if (formulario.setor.value == '') {
		alert ('Por Favor informe o Setor!');
		formulario.setor.focus();
		return false;
	}	

	else return true;
	
}