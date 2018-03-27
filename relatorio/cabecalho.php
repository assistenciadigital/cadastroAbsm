<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>

<STYLE>
    thead { display: table-header-group; }
    tfoot { display: table-footer-group; }
</STYLE>

</head>

<body>



<table border=0 align="center" width="100%">

<thead>
  <tr>
     <th width=100%>
        AQUI FICA O CABECALHO
     </th>
  </tr>
</thead>

<?php

include("../requerido/conexao.php");



$sql = "SELECT uf, sigla, descricao, usuario FROM uf";
$rs = mysql_query($sql);

while(list($uf, $sigla, $descricao, $usuario) = mysql_fetch_row($rs)) {

    if($contador == 999)
    {
?>

        <?php    
        
    }

?>
<tfoot>
  <tr>
     <td width=100%>
        AQUI VEM O RODAPÉ
     </td>
  </tr>
</tfoot>

<tbody>

<tr>
   <td width="100%">

    <table width="700" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#333333">
        <tr bgcolor="<?php echo ($ac_sw1++%2==0)?"#E4E4E4":"#FFFFFF"; ?>" onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor=''">
            <td width="100" align="center" class="clr"><?php echo $contador; ?></td>
            <td width="100" align="center" class="clr"><?php echo $uf; ?></td>
            <td width="642" align="center" class="clr">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="400"><?php echo $sigla; ?> - <?php echo $descricao; ?> - <?php echo $usuario; ?></td>
                    </tr>
                </table>
            </td>
            <td width="100" class="clr">&nbsp;</td>
        </tr>
    </table>  
    <?php
    $contador++;
}
?>
    
   </td>
</tr>

</tbody>

</table>
</body>
</html>


