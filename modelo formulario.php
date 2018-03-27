<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM - Saúde</title>
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
</head>

<body>
<form name="form" id="form">
  <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
    <option value="modelo formulario.php?cid="></option>
    <option value="modelo formulario.php?cid=mt">Mato Grosso</option>
    <option value="modelo formulario.php?cid=sp">Sao paulo</option>
    <option value="modelo formulario.php?cid=rj">Rio de Janeiro</option>
    <option value="modelo formulario.php?cid=pb">Pernambuco</option>


  </select>
</form>
<form id="form1" name="form1" method="post" action="">
  <p>Cidades</p>
  <?php
  include("requerido/conexao.php");
  $pegacidade = $_GET[cid];

$sql = "SELECT uf, descricao FROM cidade WHERE uf = '$pegacidade' ORDER BY uf, descricao";
$rs = mysql_query($sql);
  ?>
    <select name="select" id="select">
    
    <?php while(list($uf, $descricao) = mysql_fetch_row($rs)) {  ?>
      <option value="teste"><?php print("$descricao <br>"); ?> </option>
    
    <?php }?>
    
    </select>
  </p>
</form>
</body>
</html>