function validacampo (valida_campo) {
	
	if (formulario.cpf.value == '') {
		alert ('Por Favor informe o CPF!');
		formulario.cpf.focus();
		return false;
	}

	if (formulario.rg.value == '') {
		alert ('Por Favor informe o RG!');
		formulario.rg.focus();
		return false;
	}	

	if (formulario.emissorrg.value == '') {
		alert ('Por Favor informe o Emissor do RG');
		formulario.emissorrg.focus();
		return false;
	}
	
	if (formulario.ufrg.value == '') {
		alert ('Por Favor selecione o UF do RG!');
		formulario.ufrg.focus();
		return false;
	}	

	if (formulario.emissaorg.value == '') {
		alert ('Por Favor informe a Emissao RG!');
		formulario.emissaorg.focus();
		return false;
	}		
	
	if (formulario.cns.value == '') {
		alert ('Por Favor informe o CNS - Cartao Nacional SUS!');
		formulario.cns.focus();
		return false;
	}		

	if (formulario.instituicao.value == '') {
		alert ('Por Favor selecione a Instituicao!');
		formulario.instituicao.focus();
		return false;
	}	
	
	if (formulario.ufinstituicao.value == '') {
		alert ('Por Favor selecione a UF Instituicao!');
		formulario.ufinstituicao.focus();
		return false;
	}	

	if (formulario.patente.value == '') {
		alert ('Por Favor selecione a Patente!');
		formulario.patente.focus();
		return false;
	}	
	
	if (formulario.incorporacao.value == '') {
		alert ('Por Favor informe a Data de Incorporacao!');
		formulario.incorporacao.focus();
		return false;
	}	
		
	if (formulario.matricula.value == '') {
		alert ('Por Favor informe a Matricula!');
		formulario.matricula.focus();
		return false;
	}
	
	if (formulario.status.value == '') {
		alert ('Por Favor selecione o Status!');
		formulario.status.focus();
		return false;
	}
	
	if (formulario.inclusao.value == ''){
		alert ('Por Favor informe Data de Inclusão!');
		formulario.inclusao.focus();
		return false;
	}
	
	if (formulario.exclusao.value != '' && formulario.motivoexclusao.value == ''){
		alert ('Por Favor selecione o Motivo da Exclusao!');
		formulario.motivoexclusao.focus();
		return false;
	}
				
	if (formulario.formapagto.value == '') {
		alert ('Por Favor selecione a Forma de Pagamento!');
		formulario.formapagto.focus();
		return false;
	}
	
	if (formulario.assistencia.value == '') {
		alert ('Por Favor selecione o Assistencia!');
		formulario.assistencia.focus();
		return false;
	}

	if (formulario.cor.value == '') {
		alert ('Por Favor selecione a Cor!');
		formulario.cor.focus();
		return false;
	}

	if (formulario.nome.value == ''){
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
	
	if (formulario.ufnaturalidade.value == ''){
		alert ('Por Favor selecione a UF Naturalidade!');
		formulario.ufnaturalidade.focus();
		return false;
	}
	
	if (formulario.naturalidade.value == ''){
		alert ('Por Favor selecione a Naturalidade!');
		formulario.naturalidade.focus();
		return false;
	}
	
	if (formulario.mae.value == '') {
		alert ('Por Favor informe o Nome da Mae!');
		formulario.mae.focus();
		return false;
	}	
	
	if (formulario.estadocivil.value == ''){
		alert ('Por Favor selecione o Estado Civil!');
		formulario.estadocivil.focus();
		return false;
	}
	
	if (formulario.estadocivil.value == 'CASADO(A)' && formulario.conjuge.value == ''){
		alert ('Por Favor informe o Conjuge!');
		formulario.conjuge.focus();
		return false;
	}
	
	if (formulario.ocupacao.value == ''){
		alert ('Por Favor selecione a Ocupacao!');
		formulario.ocupacao.focus();
		return false;
	}
	
	if (formulario.profissao.value == ''){
		alert ('Por Favor selecione a Profissao!');
		formulario.profissao.focus();
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
	
	if (formulario.cep.value == '') {
		alert ('Por Favor informe o CEP!');
		formulario.cep.focus();
		return false;
	}				
	
	if (formulario.email.value.search("@") == -1 || formulario.email.value.search("[.*]") == -1) {
		alert ('E-mail nao preenchido ou incorreto!');
		formulario.email.focus();
		return false;
	}
	
	if (formulario.fonecel.value == '' && formulario.foneres.value == '' && formulario.fonecom.value == '') {
		alert ('Por Favor informe ao menos um Telefone!');
		formulario.cep.focus();
		return false;
	}	
		
	else return true;
	
}