<title>HM - Saúde</title>

<?php
include("requerido/conexao.php");

#CAMPOS DA TABELA


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

$classificacao = $_POST[fclassificacao];
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

$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#VERIFICA REGISTRO DUPLICADO
$sqlv = "SELECT * FROM plano WHERE descricao = '$descricao'";
$rsv = mysql_query($sqlv);


while(list($planov, $descricaov, $detalhev, $datav, $horav, $usuariov) = mysql_fetch_row($rsv)) {
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
  
  #INSERE REGISTRO NO BANCO DE DADOS
  $sql = "INSERT into plano(classificacao,descricao,detalhe,datainicio,datafim,tipo,indice,valorindice,qtdeindice,inicio,fim,valormensal,desconto,acrescimo,valorcobrado,data,hora,usuario)
          VALUES('$classificacao','$descricao','$detalhe','$datainicio','$datafim','$tipo','$indice','$valorindice','$qtdeindice','$inicio','$fim','$valormensal','$desconto','$acrescimo','$valorcobrado','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
      
  #VERIFICA CODIGO DO REGISTRO INCLUIDO  
  $sqlc = "SELECT * FROM plano WHERE descricao = '$descricao'";
  $rsc = mysql_query($sqlc);

  while(list($planoc, $classificacaoc, $descricaoc, $detalhec, $datainicioc, $datafimc, $tipoc, $indicec, $valorindicec, $qtdeindicec, $inicioc, $fimc, $valormensalc, $descontco, $acrescimoc, $valorcobradoc, $datac, $horac, $usuarioc) = mysql_fetch_row($rsc)) {
  $pega_planoc = $planoc;
}  
  #INICIA GRAVACAO DO LOG  
	
  $observacao = ("INC: $data_atual, $hora_atual, Plano: $pega_planoc, Classificacao: $classificacao, Descricao: $descricao, Detalhe: $detalhe, Tipo: $tipo, Indice: $indice, Vlr Indice: $valorindice, Qtde Indice: $qtdeindice, Inicio: $inicio, Fim: $fim, Vlr mensal: $valormensal, Desconto: $desconto, Acrescimo: $acrescimo, Vlr cobrado: $valorcobrado, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
  
  header("Location: fsus_plano.php?plano=$pega_planoc&descricao=$descricao&detalhe=$detalhe&datainicio=$datainicio&datafim=$datafim&tipo=$tipo&indice=$indice&valorindice=$valorindice&qtdeindice=$qtdeindice&inicio=$inicio&fim=$fim&valormensal=$valormensal&desconto=$desconto&acrescimo=$acrescimo&valorcobrado=$valorcobrado&data_atual=$data_atual&hora_atual=$hora_atual&usuario=$loginusuario_atual");
}
?>