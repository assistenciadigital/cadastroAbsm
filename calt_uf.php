<title>HM - Saúde</title>
<?php
include("requerido/conexao.php");

$pega_uf = $_GET[uf];

$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

  #INICIA GRAVACAO DO LOG  	
  $sql = "SELECT * FROM uf WHERE uf=$pega_uf";
  $rs = mysql_query($sql);

  list($uf, $sigla, $descricao, $capital, $imagem, $data, $hora, $usuario) = mysql_fetch_row($rs); 
   
  $observacao = ("ALT: $data_atual, $hora_atual, UF: $pega_uf, Sigla: $sigla, Descricao: $descricao, Capital: $capital, Imagem: $imagem, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG 
  
  #PEGA DADOS DO FORMULARIO  
  $sigla = strtoupper($_POST[fsigla]);
  $descricao = trim(addslashes(htmlentities(strtoupper($_POST[fdescricao]))));
  $capital = strtoupper($_POST[fcapital]); 
    
  #GRAVA CAMINHO DA IMAGEM NO BANCO
  $foto = $_FILES[fimagem];
  #FAZ UPLOAD DO ARQUIVO
  #pegando o nome do arquivo
  $nomefoto = $foto["name"];
  #criando o diretorio fisico
  @mkdir("uf",0777);
  #pegando o caminho completo da foto
  $caminho = "uf/".$nomefoto;
  #copiando a foto para o caminho
  move_uploaded_file($foto["tmp_name"],$caminho);  
  
  #SE A IMAGEM ESTIVER VAZIO NAO GRAVA CAMINHO VAZIO NO BANCO, MANTEM O CAMINHO GRAVADO ANTERIORMENTE
  if ($caminho == "uf/") {
	  $sql = "UPDATE uf SET sigla='$sigla',descricao='$descricao',capital='$capital',data='$data_atual',hora='$hora_atual',usuario='$loginusuario_atual' WHERE uf=$pega_uf";
     }else{
	 #SE NAO, GRAVA CAMINHO NO BANCO
      $sql = "UPDATE uf SET sigla='$sigla',descricao='$descricao',capital='$capital',imagem='$caminho',data='$data_atual',hora='$hora_atual',usuario='$loginusuario_atual' WHERE uf=$pega_uf";
  } 
  $rs = mysql_query($sql);

  header("Location: fcon_uf.php");
#}
?>