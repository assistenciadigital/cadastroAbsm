<title>HM - Saúde</title>

<?php
include("requerido/conexao.php");

#CAMPOS DA TABELA
$sigla = strtoupper($_POST[fsigla]);
$descricao = trim(addslashes(htmlentities(strtoupper($_POST[fdescricao]))));
$instituicao = $_POST[finstituicao];
$hierarquia = $_POST[fhierarquia];
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#VERIFICA REGISTRO DUPLICADO
$sqlv = "SELECT * FROM insignia WHERE sigla = '$sigla'";
$rsv = mysql_query($sqlv);


while(list($insigniav, $siglav, $descricaov, $instituicaov, $hierarquiav, $imagemv, $datav, $horav, $usuariov) = mysql_fetch_row($rsv)) {
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
  @mkdir("insignia",0777);
  #pegando o caminho completo da foto
  $caminho = "insignia/".$nomefoto;
  #copiando a foto para o caminho
  move_uploaded_file($imagem["tmp_name"],$caminho);
  
  #INSERE REGISTRO NO BANCO DE DADOS
  $sql = "INSERT into insignia(sigla,descricao,instituicao,hierarquia,imagem,data,hora,usuario)
          VALUES('$sigla','$descricao','$instituicao','$hierarquia','$caminho','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
      
  #VERIFICA CODIGO DO REGISTRO INCLUIDO  
  $sqlc = "SELECT * FROM insignia WHERE sigla = '$sigla'";
  $rsc = mysql_query($sqlc);

  while(list($insigniac, $siglac, $descricaoc, $instituicaoc, $hierarquiac, $imagemc, $datac, $horac, $usuarioc) = mysql_fetch_row($rsc)) {
  $pega_insigniac = $insigniac;
}  
  #INICIA GRAVACAO DO LOG  
	
  $observacao = ("INC: $data_atual, $hora_atual, Insignia: $pega_insigniac, Sigla: $sigla, Descricao: $descricao, Instituicao: $instituicao, Hierarquia: $hierarquia, Imagem: $caminho, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
  
  header("Location: fsus_insignia.php?insignia=$pega_insigniac&sigla=$sigla&descricao=$descricao&instituicao=$instituicao&hierarquia=$hierarquia&imagem=$imagem&caminho=$caminho&data_atual=$data_atual&hora_atual=$hora_atual&usuario=$loginusuario_atual");
}
?>