<title>HM - Saúde</title>

<?php
include("requerido/conexao.php");

#CAMPOS DA TABELA
$sigla = strtoupper($_POST[fsigla]);
$descricao = trim(addslashes(htmlentities(strtoupper($_POST[fdescricao]))));
$capital = strtoupper($_POST[fcapital]);
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#VERIFICA REGISTRO DUPLICADO
$sqlv = "SELECT * FROM uf WHERE sigla = '$sigla'";
$rsv = mysql_query($sqlv);


while(list($ufv, $siglav, $descricaov, $capitalv, $imagemv, $datav, $horav, $usuariov) = mysql_fetch_row($rsv)) {
 $contador++;
 $pega_usuario = $usuariov;
}

if($contador >= 1) {
  #SE ENCONTROU REGISTRO DUPLICADO
  print("<script>
  alert('Registro duplicado, cadastrado por: $pega_usuario'); 
  history.back();
  </script>");
} else {
  #NAO ENCONTROU REGISTRO DUPLICADO, GRAVA NO BANCO DE DADOS	
  $imagem = $_FILES[fimagem];

  #FAZ UPLOAD DO ARQUIVO
  #pegando o nome do arquivo
  $nomefoto = $imagem["name"];
  #criando o diretorio fisico
  @mkdir("uf",0777);
  #pegando o caminho completo da foto
  $caminho = "uf/".$nomefoto;
  #copiando a foto para o caminho
  move_uploaded_file($imagem["tmp_name"],$caminho);
  
  #INSERE REGISTRO NO BANCO DE DADOS
  $sql = "INSERT into uf(sigla,descricao,capital,imagem,data,hora,usuario)
          VALUES('$sigla','$descricao','$capital','$caminho','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
      
  #VERIFICA CODIGO DO REGISTRO INCLUIDO  
  $sqlc = "SELECT * FROM uf WHERE sigla = '$sigla'";
  $rsc = mysql_query($sqlc);

  while(list($ufc, $siglac, $descricaoc, $capitalc, $imagemc, $datac, $horac, $usuarioc) = mysql_fetch_row($rsc)) {
  $pega_ufc = $ufc;
}  
  #INICIA GRAVACAO DO LOG  
	
  $observacao = ("INC: $data_atual, $hora_atual, UF: $pega_ufc, Sigla: $sigla, Descricao: $descricao, Capital: $capital, Imagem: $caminho, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
  
  header("Location: fsus_uf.php?uf=$pega_ufc&sigla=$sigla&descricao=$descricao&capital=$capital&imagem=$imagem&caminho=$caminho&data_atual=$data_atual&hora_atual=$hora_atual&usuario=$loginusuario_atual");
}
?>