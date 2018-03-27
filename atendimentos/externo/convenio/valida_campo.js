function validacampo (valida_campo) {
	
if (formulario.razao.value == '') {
		alert ('Por Favor informe a Razao Social!');
		formulario.razao.focus();
		return false;
	}

	if (formulario.fantasia.value == '') {
		alert ('Por Favor informe o Nome Fantasia!');
		formulario.fantasia.focus();
		return false;
	}	

	if (formulario.inscricao.value == '') {
		alert ('Por Favor informe o CPF ou CNPJ!');
		formulario.inscricao.focus();
		return false;
	}	
	
	if (formulario.endereco.value == '') {
		alert ('Por Favor informe o Endereco!');
		formulario.endereco.focus();
		return false;
	}	
	
	if (formulario.numero.value == '') {
		alert ('Por Favor informe o Numero!');
		formulario.numero.focus();
		return false;
	}	
	
	if (formulario.bairro.value == '') {
		alert ('Por Favor informe o Bairro!');
		formulario.bairro.focus();
		return false;
	}	
	
	if (formulario.cep.value == '') {
		alert ('Por Favor informe o CEP!');
		formulario.cep.focus();
		return false;
	}				

	if (formulario.uf.value == '') {
		alert ('Por Favor informe a UF!');
		formulario.uf.focus();
		return false;
	}
	
	if (formulario.cidade.value == '') {
		alert ('Por Favor informe a Cidade!');
		formulario.cidade.focus();
		return false;
	}
	
	if (formulario.email.value.search("@") == -1 || formulario.email.value.search("[.*]") == -1) {
		alert ('E-mail nao preenchido ou incorreto!');
		formulario.email.focus();
		return false;
	}
		
	
	if (formulario.fone.value == '') {
		alert ('Por Favor informe o Telefone!');
		formulario.fone.focus();
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