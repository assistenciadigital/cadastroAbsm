function validacampo (valida_campo) {
	
if (formulario.cpf.value == '') {
		alert ('Por Favor informe o CPF!');
		formulario.cpf.focus();
		return false;
	}

	if (formulario.identidade.value == '') {
		alert ('Por Favor informe a Identidade!');
		formulario.identidade.focus();
		return false;
	}	

	if (formulario.emissor.value == '') {
		alert ('Por Favor informe o Emissor da Identidade');
		formulario.emissor.focus();
		return false;
	}

	if (formulario.empresa.value == '') {
		alert ('Por Favor selecione a Empresa!');
		formulario.empresa.focus();
		return false;
	}		
	
	if (formulario.setor.value == '') {
		alert ('Por Favor informe o Setor!');
		formulario.setor.focus();
		return false;
	}	
	
	if (formulario.funcao.value == '') {
		alert ('Por Favor informe a Funcao!');
		formulario.funcao.focus();
		return false;
	}		

	if (formulario.matricula.value == '') {
		alert ('Por Favor informe a Matricula!');
		formulario.matricula.focus();
		return false;
	}	
	
	if (formulario.nome.value == '') {
		alert ('Por Favor informe o Nome!');
		formulario.nome.focus();
		return false;
	}	

	if (formulario.nascimento.value == ''){
		alert ('Por Favor informe a Data de Nascimento!');
		formulario.nascimento.focus();
		return false;
	}	

	if (formulario.sexo[0].checked == false && formulario.sexo[1].checked == false){
		alert ('Por Favor Selecione o Sexo!');
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
		

	if (formulario.celular.value == '') {
		alert ('Por Favor informe o Celular!');
		formulario.celular.focus();
		return false;
	}	

	
	if (formulario.fone.value == '') {
		alert ('Por Favor informe o Telefone!');
		formulario.fone.focus();
		return false;
	}	

	else return true;
	
}