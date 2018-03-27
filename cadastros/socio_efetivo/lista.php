<?php
session_start();
if(($_SESSION['login']) AND($_SESSION['nivel'])){
	
	include "../../painel/funcoesPHP/conexao.php";
	include "../../painel/funcoesPHP/data.php";
		
	//######### INICIO Paginação
	$numreg = 10; // Quantos registros por página vai ser mostrado
	if (!isset($pg)) {
	$pg = 0;
	}

	$inicial = @$_GET['pg'] * $numreg;
	$registro_por_pagina = $inicial + $numreg;
	
	//######### FIM dados Paginação
	
	// Faz o Select pegando o registro inicial até a quantidade de registros para página
	//$sql = mysql_query("select * from convenio_empregado order by razao LIMIT $inicial, $numreg");
	
	// Serve para contar quantos registros você tem na seua tabela para fazer a paginação
	$sql_conta = mysql_query("SELECT * FROM cadastro WHERE nome LIKE '%".$_POST['nome']."%'");
	
	$quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação
		
	$consulta = mysql_query("SELECT * FROM cadastro WHERE nome LIKE '%".$_POST['nome']."%' order by nome LIMIT $inicial, $numreg");
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../painel/css/estilos.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../painel/funcoesJS/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="../../painel/funcoesJS/funcoes.js"></script>

<script language="javascript">
function excluir (id){
	if(confirm ('Você tem certeza de que deseja excluir este registro? '+ id)) {
		location = 'processando.php?acao=deleta&id='+id;
	}
}
</script>
</head>
<body onLoad="reajusta()">

<div class="conteudo" align="center" height:"500px">

<table width="800" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr align="center" valign="top">
    <th height="400" scope="col">

  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="10%" align="center" valign="middle" bgcolor="#4DBDCB"><img src="icon.png"></td>
      <td width="90%" align="left" bgcolor="#4DBDCB"><h2 class="txtBranco"><strong>GERENCIAMENTO DE SÓCIOS EFETIVOS - CBM / PM</strong></h2></td>
    </tr>
    <tr>
      <td width="10%">&nbsp;</td>
      <td width="90%">&nbsp;</td>
    </tr>
    <tr>
      <td align="center" bgcolor="#F0F0F0"><img src="../../painel/imgs/i_novo.png"></td>
      <td onClick="location='cadastro.php'" onMouseOut="this.style.backgroundColor='#F0F0F0'" onMouseOver="this.style.backgroundColor='#E0E0E0'" style="cursor:hand" colspan="2" valign="middle" bgcolor="#F0F0F0" class="tip-tip" alt="Aqui você cadastrar os usuários que terão acesso ao seu Painel!"><h6><strong>Cadastrar Novo</strong></h6></td>
    </tr>
  </table>
<form action="lista.php" name="formulario" id="formulario" method="post" enctype="multipart/form-data">
  <table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr valign="middle">
    <td width="10%" align="center" scope="col"><h6><img src="../../painel/imgs/i_filtro.png" alt="" /></h6>      <h6>&nbsp;</h6></td>
    <td width="70%" align="left" scope="col"><h6>
       
        Nome:
        <input class="form" name="nome" id="nome" style=" width:380px; HEIGHT: 20px;" value="<?php echo $_POST['nome']?>" /></h6></td>
    <td width="20%" align="center" scope="col"><h6><input name="image" type="image" src="../../painel/imgs/bt_procurar.png" /></h6></td>
  </tr>
  </table>
</form>

<table width="800" border="0" cellpadding="1" cellspacing="1" bgcolor="#E0E0E0">
  <tr valign="middle">
    <td width="136" height="0" align="center" valign="top" bgcolor="#008000" scope="col"><h6><strong>Ativo</strong></h6></td>
    <td width="136" height="0" align="center" valign="top" bgcolor="#FF00FF" scope="col"><h6><strong>Bloqueado</strong></h6></td>
    <td width="136" height="0" align="center" valign="top" bgcolor="#FF0000" scope="col"><h6><strong>Excluído</strong></h6></td>
    <td width="136" height="0" align="center" valign="top" bgcolor="#FF0000" scope="col"><h6><strong>Inativo</strong></h6></td>
    <td width="136" height="0" align="center" valign="top" bgcolor="#FFFF00" scope="col"><h6><strong>Recadastrar</strong></h6></td>
  </tr>
  </table>    
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="10%" align="center" scope="col"><h6><strong>ID</strong></h6></td>
      <td width="60%" align="left" scope="col"><h6><strong>Nome</strong></h6></td>
      <td width="5%" align="center" scope="col"><h6><strong>Agen.</strong></h6></td>
      <td width="5%" align="center" scope="col"><h6><strong>Fin.</strong></h6></td>
      <td width="5%" align="center" scope="col"><h6><strong>Dep.</strong></h6></td>
      <td width="5%" align="center" scope="col"><h6><strong>Ficha</strong></h6></td>
      <td width="5%" align="center" scope="col"><h6><strong>Cart.</strong></h6></td>
      <td width="5%" align="center" scope="col"><h6><strong>Edita</strong></h6></td>
      </tr>
  </table>
<?php
    if (@mysql_num_rows($consulta)){
        while ($c = mysql_fetch_assoc ($consulta)){
	        $i++;
    	    //if ($i%2) $cor = '#F0F0F0';
			//else $cor = '#FFFFFF';
		
		switch($c['status']){
			case "Ativo":       $status = $c['status']."/Liberado";           $cor = '#008000';break; 
			case "Bloqueado":   $status = $c['status']."/Procure Financeiro"; $cor = '#FFFF00"';break;
			case "Excluido":    $status = $c['status'];                       $cor = '#FF0000'; break;
			case "Inativo":     $status = $c['status'];                       $cor = '#FF0000'; break;
			case "Recadastrar": $status = $c['status']."/Procure Cadastro";   $cor = '#FFFF00'; break;						
			}
    ?>   
    <table width="800" border="0" cellpadding="1" cellspacing="1" bgcolor="#E0E0E0">
    <tr>
    <td width="10%" height="30" align="center" valign="middle" onMouseOut="this.style.backgroundColor='<?php echo $cor?>'" onMouseOver="this.style.backgroundColor='#E0E0E0'" style="cursor:hand" bgcolor="<?php echo $cor?>"><h6><strong><?php echo $c['id']?>&nbsp;</strong></h6>  
    </td>
    <td width="60%" onMouseOut="this.style.backgroundColor='<?php echo $cor?>'" onMouseOver="this.style.backgroundColor='#E0E0E0'" style="cursor:hand" bgcolor="<?php echo $cor?>" ><h6><strong><?php echo $c['nome'];echo '<br>';echo 'Nascimento: '.date_data($c['nascimento']).' | CPF: '.$c['cpf'].' | '.$status?></strong></h6></td>
    <td width="5%" align="center" bgcolor="<?php echo $cor?>" style="cursor:hand" onMouseOver="this.style.backgroundColor='#E0E0E0'" onMouseOut="this.style.backgroundColor='<?php echo $cor?>'" ><strong><a href="../../agenda/socio_efetivo/lista.php?id=<?php echo $c['id']?>" target="_self" class="tip-tip"><img src="../../painel/imgs/i_agenda.png" alt="Clique aqui para Alterar o dependente: <?php echo $c['nome'] ?>" name="bt_agenda" width="30" height="30" id="bt_financeiro2" border="0" /></a></strong></td>
    <td width="5%" align="center" bgcolor="<?php echo $cor?>" style="cursor:hand" onMouseOver="this.style.backgroundColor='#E0E0E0'" onMouseOut="this.style.backgroundColor='<?php echo $cor?>'" ><strong><a href="../../cadastros/recebimento_socio_efetivo/lista.php?id=<?php echo $c['id']?>" target="_self" class="tip-tip"><img src="../../painel/imgs/i_financeiro.png" alt="Clique aqui para Alterar o dependente: <?php echo $c['nome'] ?>" name="bt_financeiro" width="30" height="30" id="bt_financeiro" border="0" /></a></strong></td>
    <td width="5%" align="center" valign="middle" onMouseOut="this.style.backgroundColor='<?php echo $cor?>'" onMouseOver="this.style.backgroundColor='#E0E0E0'" style="cursor:hand" bgcolor="<?php echo $cor?>"><strong><a href="../dependente_socio_efetivo/lista.php?id=<?php echo $c['id']?>"class="tip-tip"><img src="../../painel/imgs/i_dependente.png" alt="Clique aqui para Alterar o dependente: <?php echo $c['nome'] ?>" name="bt_dependente" width="30" height="30" border="0"></a></strong></td>
    <td width="5%" align="center" valign="middle" onMouseOut="this.style.backgroundColor='<?php echo $cor?>'" onMouseOver="this.style.backgroundColor='#E0E0E0'" style="cursor:hand" bgcolor="<?php echo $cor?>"><a href="../../relatorio/crel_ficha_atendimento.php?id=<?php echo $c['id']?>" target="_blank" class="tip-tip" alt="Clique aqui para Alterar o usuário: <?php echo $c['nome'] ?>"><img src="../../painel/imgs/i_ficha.png" alt="" name="bt_ficha" width="30" height="30" id="bt_ficha" border="0"></a></td>
    <td width="5%" align="center" valign="middle" onMouseOut="this.style.backgroundColor='<?php echo $cor?>'" onMouseOver="this.style.backgroundColor='#E0E0E0'" style="cursor:hand" bgcolor="<?php echo $cor?>"><strong><a href="../dependente/lista.php?id=<?php echo $c['id']?>"class="tip-tip"><img src="../../painel/imgs/ico-carteira.png" alt="Clique aqui para Alterar o dependente: <?php echo $c['nome'] ?>" name="bt_carteira" width="30" height="30" id="bt_carteira" border="0"></a></strong></td>
    <td width="5%" align="center" valign="middle" onMouseOut="this.style.backgroundColor='<?php echo $cor?>'" onMouseOver="this.style.backgroundColor='#E0E0E0'" style="cursor:hand" bgcolor="<?php echo $cor?>"><strong><a href="cadastro.php?id=<?php echo $c['id']?>" class="tip-tip" alt="Clique aqui para Alterar o usuário: <?php echo $c['nome'] ?>"><img name="bt_editar" src="../../painel/imgs/i_editar.png" width="23" height="23" border="0" alt=""></a></strong></td>
    </tr>
</table>


  <?php }}?>

    </th>
  </tr>
</table>

    <table width="800px" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="70%" align="left"  valign="middle"><h6><strong><?php include("../../painel/funcoesPHP/paginacao.php")?></strong></h6></td>
          <td width="30%" align="right" valign="middle"><h6><strong><?php if ($registro_por_pagina > $quantreg){$registro_por_pagina = $quantreg;}else{$registro_por_pagina=$registro_por_pagina;}print 'Registro(s) ['.$registro_por_pagina.'] de ['.$quantreg.']'?></strong></h6></td>
         </tr>
         <tr>
          <td width="100%" colspan="2" align="right" class="voltar"><img src="../../painel/imgs/space.png" width="10" height="25"><a href="../../abertura.php"><img src="../../painel/imgs/bt_voltar.png" border="0"></a><img src="../../painel/imgs/space.png" width="10" height="25"><img src="../../painel/imgs/spaceT.png" width="20" height="25"></td>
        </tr>
    </table>

</div>
</body>
</html>

<?php }
else {
	$url_de_destino = "../../expira.php";
	$target = "_parent";
	include "../../painel/funcoesPHP/redireciona.php";
}
?>