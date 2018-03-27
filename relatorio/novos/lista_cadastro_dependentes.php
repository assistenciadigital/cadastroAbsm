<?php 

	include "../../requerido/conexao.php";
	include "../../requerido/data.php";

	$titular = mysql_query("SELECT * FROM cliente where status like '".$_POST['status']."%' and classificacao like '".$_POST['classificacao']."%' and tipo like '".$_POST['tipo']."%' and assistencia like '".$_POST['assistencia']."%' order by nome");	
	
	$qtde_pesquisado = mysql_num_rows($titular);
	$qtde_registro = mysql_num_rows(mysql_query("SELECT * from cliente")); // Quantidade de registros pra paginação	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>

    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
    <title>SisHosp</title>

<script language="javascript">

function atualiza(){
 document.getElementById("frmlista").submit();	
}

function limpa() {
	document.getElementById("frmlista").reset();	
	document.getElementById("status").value = "";	
	document.getElementById("classificacao").value = "";
	document.getElementById("tipo").value = "";
	document.getElementById("frmlista").submit();	
}
</script>

  </head>
  <body>

    <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
        <div class="container-fluid">
		<div class="row"><strong>
        <hr>
        <form action="lista_cadastro.php" name="frmlista" id="frmlista" method="post" enctype="multipart/form-data">
	<p>RELATORIO CADASTRO - TITULARES COM DEPENDENTES<p/>
        Status: <select name="status" id="status" onchange="atualiza();">
            <option value=""></option>
            <?php
            $status = mysql_query ("SELECT distinct status from cliente ORDER BY status");
            if (mysql_num_rows ($status)) {
            while ($row_status= mysql_fetch_assoc($status)) {
            ?>
            <option value="<?php echo $row_status['status']?>"<?php if(($_POST['status'] == $row_status['status'])) echo "selected"?>><?php echo $row_status['status']?></option>
            <?php }}?>
          </select>
        Classificação: <select name="classificacao" id="classificacao" onchange="atualiza();">
          <option value=""></option>
          <?php
            $classificacao = mysql_query ("SELECT classificacao, descricao from classificacao where  titular = 'S' AND associado = 'S' ORDER BY descricao");
            if (mysql_num_rows ($classificacao)) {
            while ($row_classificacao= mysql_fetch_assoc($classificacao)) {
            ?>
          <option value="<?php echo $row_classificacao['classificacao']?>"<?php if(($_POST['classificacao'] == $row_classificacao['classificacao'])) echo "selected"?>><?php echo $row_classificacao['descricao']?></option>
          <?php }}?>
        </select>
        Tipo: 
        <strong>
        <select name="tipo" id="tipo" onchange="atualiza();">
          <option value=""></option>
          <?php
            $tipo = mysql_query ("SELECT tipo, descricao from tipo where classificacao = '".$_POST['classificacao']."' and titular = 'S' ORDER BY descricao");
            if (mysql_num_rows ($tipo)) {
            while ($row_tipo= mysql_fetch_assoc($tipo)) {
            ?>
          <option value="<?php echo $row_tipo['tipo']?>"<?php if(($_POST['tipo'] == $row_tipo['tipo'])) echo "selected"?>><?php echo $row_tipo['descricao']?></option>
          <?php }}?>
        </select>
        </strong>
        Assistencia: 
        <strong>
        <select name="assistencia" id="assistencia" onchange="atualiza();">
          <option value=""></option>
          <?php
            $assistencia = mysql_query ("SELECT assistencia, descricao from assistencia ORDER BY descricao");
            if (mysql_num_rows ($assistencia)) {
            while ($row_assistencia = mysql_fetch_assoc($assistencia)) {
            ?>
          <option value="<?php echo $row_assistencia['assistencia']?>"<?php if(($_POST['assistencia'] == $row_assistencia['assistencia'])) echo "selected"?>><?php echo $row_assistencia['descricao']?></option>
          <?php }}?>
        </select>
        </strong>
        <strong><a href="relatorio_cadastro.php?status=<?php echo $_POST['status']?>&classificacao=<?php echo $_POST['classificacao']?>&tipo=<?php echo $_POST['tipo']?>&assistencia=<?php echo $_POST['assistencia']?>" target="_blank">
        <input type="button" name="impressao" id="impressao" value="Impressão..." style="cursor:pointer"/>
        </a></strong>
        </form>
        <hr>
        </strong>
        </div>
        </div>
<div class="container-fluid">
	<div class="row"><strong>
		<div class="col-md-1" align="center">Codigo</div>
        <div class="col-md-3">Nome</div>
		<div class="col-md-1">Status</div>
		<div class="col-md-3">Classificacao<br/>Tipo</div>
        <div class="col-md-1">Assistencia</div>
        <div class="col-md-1" align="center">Inclusao</div>
        <div class="col-md-1" align="center">Instituicao</div></strong>
	</div>
</div>
		  <?php 
		  
  if (mysql_num_rows ($titular)) {
	  while ($row = mysql_fetch_assoc($titular)) {
$classificacao = @mysql_fetch_assoc(mysql_query("SELECT classificacao, descricao FROM classificacao WHERE classificacao = '".$row['classificacao']."'"));

$tipo = @mysql_fetch_assoc(mysql_query("SELECT tipo, descricao FROM tipo WHERE tipo = '".$row['tipo']."'"));

$assistencia = @mysql_fetch_assoc(mysql_query("SELECT assistencia, descricao FROM assistencia WHERE assistencia = '".$row['assistencia']."'"));

$dependente = @mysql_fetch_assoc(mysql_query("select dependente, status, nome, datanascimento, sexo, cpf, tipo.descricao  from dependente inner join tipo ON dependente.tipo = tipo.tipo; WHERE titular = '".$row['cliente']."'"));
  	        $i++;
    		if ($i%2) $cor = '#F0F0F0';
				else $cor = '#FFFFFF';
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-1" align="center" style="background-color:<?php echo $cor?>"><?php echo $row['cliente']?></div>
        <div class="col-md-3" style="background-color:<?php echo $cor?>"><?php echo $row['nome'].'<br/>'.$row['instituicao'].' '.$row['rg'].' '.$row['emissorrg'].' '.$row['ufrg'].' - CPF: '.$row['cpf']?></div>
		<div class="col-md-1" style="background-color:<?php echo $cor?>"><?php echo $row['status']?></div>
		<div class="col-md-3" style="background-color:<?php echo $cor?>"><?php echo $classificacao['descricao']."<br/>".$tipo['descricao']?></div>
        <div class="col-md-1" style="background-color:<?php echo $cor?>"><?php echo $assistencia['descricao']?></div>
        <div class="col-md-1" align="center" style="background-color:<?php echo $cor?>"><?php echo date_data($row['datainclusao'])?></div>
        <div class="col-md-1" align="center" style="background-color:<?php echo $cor?>"><?php echo $row['instituicao']?></div>
	</div>
</div>

<?php
 		}}
?>
<hr>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12" align="center"><strong><?php echo number_format(($qtde_pesquisado), 0, ',', '.').' de '.number_format(($qtde_registro), 0, ',', '.')?></strong></div>
	</div>
</div>

	  </div>
	</div>
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
  </body>
</html>