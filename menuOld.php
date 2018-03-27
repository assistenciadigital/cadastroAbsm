<?php
#nome do usuario
include("verifica.php");

session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM Saúde</title>
<script src="jquery/jquery-1.5.1.min.js" type="text/javascript"></script>
<script src="jquery/jquery.orbit-1.2.3.min.js" type="text/javascript"></script>
<link href="jquery/orbit-1.2.3.css" rel="stylesheet" type="text/css" />
<style type="text/css">

dl { width: 300px; }
dl,dd { margin: 0; }
dt { background: #CCC; font-size: 18px; padding: 5px; margin: 2px; }
dt a { color: #000; font-size: 18px }
dd a { color: #000; font-size: 16px }
ul { list-style: none; padding: 16px; }


body,td,th {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 14px;
}
body {
	margin: 0;
	padding: 0;
	/*background: #ccc;*/
	text-align: center; /* hack para o IE */
	background-image: url(imagem/fundo.jpg);
	background-repeat: repeat-x;
	margin-left: 20px;
	margin-top: 0px;
	margin-right: 20px;
	margin-bottom: 10px;
}
#tudo {
width: 700px;
height: 400px;
margin:0 auto;         
text-align:left; /* "remédio" para o hack do IE */ 
}
#conteudo {
padding: 0px;
/*background-color: #eee;*/
}

</style>

<script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

$(document).ready(function(){
     $("dd").hide();
     $("dt a").click(function(){
        $("dd:visible").slideUp("slow");
        $(this).parent().next().slideDown("slow");
        return false;
     });
});



</script>

</head>

<body>
<div id="tudo">
<div id="conteudo">
     <div align="rigth">
     <strong>ABSM/MT - Associação Beneficente de Saúde dos Militares do Estado de Mato Grosso</strong>
     <br/><strong>HM - Saúde</strong>
     <hr>
     <strong>Usuário: </strong><?php print strtoupper($idusuario_atual); ?> | </strong><?php print strtoupper($loginusuario_atual); ?> | <?php print strtoupper($nomeusuario_atual); ?>
     <hr>
     <table width="700" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <th width="300" scope="col">     <strong>Menu Principal</strong>
     <dl>
    <dt><a href="#">Dados Auxiliares</li></a></dt>
    <dd>
        <ul>
            
            <li><a href="fcon_uf.php">UF</a></li>
            <li><a href="fcon_cidade.php">Cidade</a></li>
            <li><a href="fcon_bairro.php">Bairro</a></li>
            <li><a href="fcon_estadocivil.php">Estado Civil</a></li>
            <li><a href="fcon_parentesco.php">Parentesco</a></li>
            <li><a href="fcon_ocupacao.php">Ocupação</a></li>
            <li><a href="fcon_profissao.php">Profissão</a></li>
            
        </ul>
    </dd>
    <dt><a href="#">Dados Específicos</li></a></dt>
    <dd>
        <ul>
                    
            <li><a href="fcon_insignia.php">Graduação PM / CBM</a></li>
            <li><a href="fcon_classificacao.php">Classificação</a></li>
            <li><a href="fcon_tipo.php">Tipo</a></li>
            <li><a href="fcon_assistencia.php">Assistência Médica</a></li>
            <li><a href="fcon_formapagto.php">Forma de Pagamento</a></li>
            <li><a href="fcon_plano.php">Plano</a></li>
            <li><a href="fcon_area.php">Área Médica e Odontológica</a></li>
            <li><a href="fcon_medico.php">Médico / Dentista</a></li>
            
        </ul>
    </dd>
    <dt><a href="#">Cadastros</li></a></dt>
    <dd>
        <ul>
            
            <li><a href="fcon_cliente.php">Cliente</a></li>
          
        </ul>
    </dd>
            <dt><a href="#">Atendimento</li></a></dt>
    <dd>
        <ul>

            <li><a href="fcon_marcacao.php">Marcação</a></li>
                       
        </ul>
    </dd>
    
        <dt><a href="#">Relatórios</li></a></dt>
    <dd>
        <ul>

            
                       
        </ul>
    </dd>

        <dt><a href="#">Recibo</li></a></dt>
    <dd>
        <ul>
            
            <li><a href="fcad_recibo_emitente.php">Emitente</a></li>                        
            <li><a href="fcad_recibo_destinatario.php">Destinatário</a></li>
            <li><a href="fcad_recibo_referencia.php">Referência</a></li>
            <li><a href="fcad_recibo.php">Recibo - Financeiro</a></li>
			<li><a href="fcad_recibo_pa.php">Recibo - PA</a></li>
            
      </ul>
    </dd>
        <dt><a href="#">CEP Correios</li></a></dt>
    <dd>
        <ul>
            
            <li><a href="fpes_cep.php">Pesquisa CEP</a></li>
            
        </ul>
    </dd>    
   <dt><a href="#">Administrador</li></a></dt>
    <dd>
        <ul>
            
            <li><a href="fcon_usuario.php">Usuário</a></li>
            
        </ul>
    </dd>
</dl></th>
         <th width="400" align="center" valign="middle" scope="col"><div align="center">
 </th>
       </tr>
       <tr>
         <th colspan="2" align="center" valign="middle" scope="col"><strong><a href="sair.php">Sair do Sistema</a></strong>
<br/>SISHOSP - Versao 1.0 - Dez/2012
<br/>Desenvolvedor: Alex Bueno (65)3625-4089/(65)8424-6744 Brt/(65)9606-2605 Vivo</th>
       </tr>
       </table>
       </div>

     <script type="text/javascript">
     $(window).load(function() {
         $('#featured').orbit();
     });
 </script>
 
 <div id="featured" ; align="center">
        <img src="imagem/logo_absm.png" width="100" height="94" /> 
        <img src="imagem/Brasao_CBM_MT.PNG" width="100" height="94" />
        <img src="imagem/brasao_nacional_pm_mt.PNG" width="100" height="94" />
        <img src="imagem/brasaoPM.jpg" width="100" height="94" />
 </div>
   <hr>
</body>
</html>