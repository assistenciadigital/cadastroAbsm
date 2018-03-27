<title>HM - Saúde</title>

<?php
include("requerido/conexao.php");

#CAMPOS DA TABELA

# FORMULARIO ENVIA DATA AO BANCO ano/mes/dia - ano-mes-dia
$data_envia = explode("/",$_POST[fdata]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia-$mes_envia-$dia_envia";

  #INSERE REGISTRO NO BANCO DE DADOS
  $sql = "INSERT into testedata(data) VALUES('$data_final_envia')";
  $rs = mysql_query($sql);

  header("Location: datarecebe.php?data=$data_final_envia");
?>