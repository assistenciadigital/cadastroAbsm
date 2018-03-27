<title>HM - Saúde</title>
<?php
include("requerido/conexao.php");

$pega_plano = $_GET[plano];

$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#INICIA GRAVACAO DO LOG
$sql = "SELECT * FROM plano WHERE plano=$pega_plano";
$rs = mysql_query($sql);

list($plano, $descricao, $detalhe, $data, $hora, $usuario) = mysql_fetch_row($rs);

$observacao = ("ALT: $data_atual, $hora_atual, Plano: $pega_planoc, Descricao: $descricao, Detalhe: $detalhe, Tipo: $tipo, Indice: $indice, Vlr Indice: $valorindice, Qtde Indice: $qtdeindice, Inicio: $inicio, Fim: $fim, Vlr mensal: $valormensal, Desconto: $desconto, Acrescimo: $acrescimo, Vlr cobrado: $valorcobrado, Usuario: $idusuario_atual - $loginusuario_atual");
    
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			
  $rs_log = mysql_query($sql_log);
  #FIM GRAVACAO DO LOG
  
  #PEGA DADOS DO FORMULARIO  
  # FORMULARIO ENVIA DATA AO BANCO ano/mes/dia - ano-mes-dia
	
  #data vigencia inicio
  $data_envia = explode("/",$_POST[fdatainicio]); 
  $dia_envia = $data_envia[0];
  $mes_envia = $data_envia[1];
  $ano_envia = $data_envia[2];
  $data_final_envia = "$ano_envia-$mes_envia-$dia_envia";
  $datainicio = $data_final_envia;
	
	#data vigencia fim
	$data_envia = explode("/",$_POST[fdatafim]); 
	$dia_envia = $data_envia[0];
	$mes_envia = $data_envia[1];
	$ano_envia = $data_envia[2];
	$data_final_envia = "$ano_envia-$mes_envia-$dia_envia";
	$datafim = $data_final_envia;
	
	$descricao = trim(addslashes(htmlentities(strtoupper($_POST[fdescricao]))));
	$detalhe = trim(addslashes(htmlentities(strtoupper($_POST[fdetalhe]))));
	$tipo = $_POST[ftipo];
	$inicio = $_POST[finicio];
	$fim = $_POST[ffim];
	$indice = strtoupper($_POST[findice]);
	$valorindice = $_POST[fvalorindice];
	$qtdeindice = $_POST[fqtdeindice];
	$valormensal = $_POST[fvalormensal];
	$desconto = $_POST[fdesconto];
	$acrescimo = $_POST[facrescimo];
	$valorcobrado = $_POST[fvalorcobrado];  
    
  $sql = "UPDATE plano SET descricao='$descricao',detalhe='$detalhe',datainicio='$datainicio',datafim='$datafim',tipo='$tipo',inicio='$inicio',fim='$fim',indice='$indice',valorindice='$valorindice',qtdeindice='$qtdeindice',valormensal='$valormensal',desconto='$desconto',acrescimo='$acrescimo',valorcobrado='$valorcobrado',data='$data_atual',hora='$hora_atual',usuario='$loginusuario_atual' WHERE plano=$pega_plano";
  $rs = mysql_query($sql);

  header("Location: fcon_plano.php");
#}
?>