function valida (formulario) {
	
	if (formulario.nome.value == '') {
		alert ('Por Favor informe o Nome!');
		formulario.nome.focus();
		return false;
	}
	
	else if (formulario.email.value.search("@") == -1 || formulario.email.value.search("[.*]") == -1) {
		alert ('E-mail não preenchido ou incorreto!');
		formulario.email.focus();
		return false;
	}
	
	else if (formulario.login.value == '') {
		alert ('Por favor informe o Login!');
		formulario.login.focus();
		return false;
	}
	
	else if (formulario.senha.value == '') {
		alert ('Por favor informe a Senha!');
		formulario.senha.focus();
		return false;
	}
	
	
	else if (formulario.confirmacao.value == '') {
		alert ('Por favor confirme a senha!');
		formulario.confirmacao.focus();
		return false;
	}
	
	else if (formulario.senha.value != formulario.confirmacao.value){
		alert ('A Comfirmação da Senha não confere com a Senha!');
		formulario.confirmacao.focus();
		return false;
	}
	else if (formulario.nivel.value == '') {
		alert ('Por favor informe o Nivel!');
		formulario.nivel.focus();
		return false;
	}
	
	
	else return true;
	
}
