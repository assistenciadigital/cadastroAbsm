<title>HM - Saúde</title>
<?php
include("requerido/conexao.php");

$pega_insignia = $_GET[insignia];

$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#INICIA GRAVACAO DO LOG
$sql = "SELECT * FROM insignia WHERE insignia=$pega_insignia";
$rs = mysql_query($sql);

list($insignia, $sigla, $descricao, $instituicao, $hierarquia, $imagem, $data, $hora, $usuario) = mysql_fetch_row($rs);

$observacao = ("ALT: $data_atual, $hora_atual, Insignia: $insignia, Sigla: $sigla, Descricao: $descricao, Instituicao: $instituicao, Hierarquia: $hierarquia, Imagem: $imagem, Usuario: $idusuario_atual - $loginusuario_atual");
    
$sql_log = "INSERT into log(observacao, data, hora, usuario) 
            VALUES('$observacao', '$data_atual', '$hora_atual', '$loginusuario_atual')";
			
$rs_log = mysql_query($sql_log);
#FIM GRAVACAO DO LOG
  
  #PEGA DADOS DO FORMULARIO  
  $sigla = strtoupper($_POST[fsigla]);
  $descricao = trim(addslashes(htmlentities(strtoupper($_POST[fdescricao]))));
  $instituicao = strtoupper($_POST[finstituicao]); 
  $hierarquia = strtoupper($_POST[fhierarquia]); 
      
  #GRAVA CAMINHO DA IMAGEM NO BANCO
  $foto = $_FILES[fimagem];
  #FAZ UPLOAD DO ARQUIVO
  #pegando o nome do arquivo
  $nomefoto = $foto["name"];
  #criando o diretorio fisico
  @mkdir("insignia",0777);
  #pegando o caminho completo da foto
  $caminho = "insignia/".$nomefoto;
  #copiando a foto para o caminho
  move_uploaded_file($foto["tmp_name"],$caminho);  
  
  #SE A IMAGEM ESTIVER VAZIO NAO GRAVA CAMINHO VAZIO NO BANCO, MANTEM O CAMINHO GRAVADO ANTERIORMENTE
  if ($caminho == "insignia/") {
	  $sql = "UPDATE insignia SET sigla='$sigla',descricao='$descricao',instituicao='$instituicao',hierarquia='$hierarquia',data='$data_atual',hora='$hora_atual',usuario='$loginusuario_atual' WHERE insignia=$pega_insignia";
     }else{
	 #SE NAO, GRAVA CAMINHO NO BANCO
      $sql = "UPDATE insignia SET sigla='$sigla',descricao='$descricao',instituicao='$instituicao',hierarquia='$hierarquia',imagem='$caminho',data='$data_atual',hora='$hora_atual',usuario='$loginusuario_atual' WHERE insignia=$pega_insignia";
  } 
  $rs = mysql_query($sql);

  header("Location: fcon_insignia.php");
#}
?>