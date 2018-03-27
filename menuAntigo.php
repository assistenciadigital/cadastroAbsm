<?php
date_default_timezone_set("America/Cuiaba");
setlocale(LC_ALL, 'pt_BR');
include("requerido/verifica.php");

session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style type="text/css">
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
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM Saúde</title>

<link rel="stylesheet" href="jquery/jquery-ui.css" />
<script src="jquery/jquery-1.9.1.js"></script>
<script src="jquery/jquery-ui.js"></script>
<link rel="stylesheet" href="jquery/style.css" />

<script>
$(function() {
$( "#menu" ).menu();
});
</script>
<?php include("requerido/dataehora.php");?>
<style>

.ui-menu {width: 300px; background-color:transparent; font-style:italic}
#tudo {
width: 920px;
height: 500px;
margin:0 auto;         
text-align:left; /* "remédio" para o hack do IE */ 
}
#conteudo {
padding: 0px;
/*background-color: #eee;*/
}
</style>
</head>
<body>
<div id="tudo">
<div id="conteudo">
<div align="rigth">
<hr>
     <strong>ABSM/MT - Associação Beneficente de Saúde dos Militares de MT</strong>
     <hr>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="50%" align="left" valign="middle" ><strong>Usuário: </strong><?php print strtoupper($loginusuario_atual); ?> | <?php print strtoupper($nomeusuario_atual);?></td>
         <td width="50%" align="right" valign="middle" ><div align="right" id="clock"></div></td>
       </tr>
     </table>
</div>
<hr>
<ul id="menu">

<li class="ui-state-disabled"><a href="#">Menu Principal</a></li>

<li><a href="#">Dados Auxiliares</a>
       <ul>
            <li class="ui-state-disabled"><a href="#">Dados Auxiliares</a></li>
                <li><a href="#">UF</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">UF</a></li>
                        <li><a href="fcon_uf.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_uf.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>

                <li><a href="#">Cidade</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Cidade</a></li>
                        <li><a href="fcon_cidade.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_cidade.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>

                <li><a href="#">Bairro</a>
                    <ul>
                      <li class="ui-state-disabled"><a href="#">Bairro</a></li>
                        <li><a href="fcon_bairro.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_bairro.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>


                <li><a href="#">Estado Civil</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Estado Civil</a></li>
			            <li><a href="fcon_estadocivil.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_estadocivil.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>

                <li><a href="#">Parenteso</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Parentesco</a></li>
			            <li><a href="fcon_parentesco.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_parentesco.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>

                <li><a href="#">Ocupação</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Ocupação</a></li>
			            <li><a href="fcon_ocupacao.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_ocupacao.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>

                <li><a href="#">Profissão</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Profissão</a></li>
			            <li><a href="fcon_profissao.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_profissao.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>
        </ul>    
</li>

<li><a href="#">Dados Específicos</a>
       <ul>
            <li class="ui-state-disabled"><a href="#">Dados Específicos</a></li>
                <li><a href="#">CBM / PM</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">CBM / PM</a></li>
                        <li><a href="fcon_insignia.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_insignia.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>

                <li><a href="#">Classificação</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Classificação</a></li>
                        <li><a href="fcon_classificacao.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_classificacao.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>

                <li><a href="#">Tipo</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Tipo</a></li>
                        <li><a href="fcon_tipo.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_tipo.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>


                <li><a href="#">Assistência Médica</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Assistência Médica</a></li>
			            <li><a href="fcon_assistencia.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_assistencia.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>

                <li><a href="#">Forma Pgto</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Forma Pgto</a></li>
			            <li><a href="fcon_formapagto.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_formapagto.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>

                <li><a href="#">Plano</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Plano</a></li>
			            <li><a href="fcon_plano.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_plano.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>

                <li><a href="#">Área</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Área</a></li>
			            <li><a href="fcon_area.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_area.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>

                <li><a href="#">Médico / Dentista</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Médico / Dentista</a></li>
			            <li><a href="fcad_medico.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_medico.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>
        </ul>    
</li>


<li><a href="#">Cadastro</a>
       <ul>
            <li class="ui-state-disabled"><a href="#">Cadastro</a></li>
                <li><a href="#">Associado/Dependente/Agregado</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Cadastro/Impressão</a></li>
                        <li><a href="fcon_cliente.php">Cadastro</a></li>
                        <li class="ui-state-disabled"><a href="#">Impressão</a></li>	
                        <li><a href="fimp_cliente_classificacao_tipo.php" target="_blank">Titular x Classificação x Tipo</a></li>
                        <li><a href="fimp_dependente_classificacao_tipo.php" target="_blank">Dependente x Classificação x Tipo</a></li>
                    </ul>
          		</li>
                <li><a href="#">Particular/Convênio SUS</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Cadastro/Impressão</a></li>
                        <li><a href="fcon_particular.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_particular.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>
      </ul>    
</li>

<li><a href="#">Agendamento</a>
       <ul>
            <li class="ui-state-disabled"><a href="#">Agendamento</a></li>
                <li><a href="#">Associado/Dependente/Agregado</a>
                    <ul>
                        <li><a href="fcon_atendimento.php">Agendamento</a></li>
                        <li><a href="fcon_atendimentolista.php">Atendimento</a></li>
                        <li class="ui-state-disabled"><a href="#">Impressão</a></li>
                        <li><a href="fimp_atendimentomedico.php" target="_blank">Agendamento / Atendimento</a></li>
                    </ul>
          		</li>
                <li><a href="#">Particular/Convênio SUS</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Cadastro/Impressão</a></li>
                        <li><a href="fcon_particular.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_particular.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>
      </ul>    
</li>


<li><a href="#">Recibo</a>
       <ul>
            <li class="ui-state-disabled"><a href="#">Recibo</a></li>
                <li><a href="#">Favorecico</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Favorecido</a></li>
                        <li><a href="fcad_recibo_emitente.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_recibo_emitente.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>

                <li><a href="#">Destinatario</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Destinatario</a></li>
                        <li><a href="fcad_recibo_destinatario.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_recibo_destinatario.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>


                <li><a href="#">Referência</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Referência</a></li>
                        <li><a href="fcad_recibo_referencia.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_recibo_referencia.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>

                <li><a href="#">Recibo/Financeiro</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Financeiro</a></li>
                        <li><a href="fcad_recibo.php">Cadastro</a></li>
                    </ul>
          		</li>

                <li><a href="#">Recibo/PA</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">PA</a></li>
                        <li><a href="fcad_recibo_pa.php">Cadastro</a></li>
                    </ul>
          		</li>


           <li class="ui-state-disabled"><a href="#">Relatórios</a></li>

           <li><a href="fimp_recibo.php" target="_blank">Visualizar</a></li>
        </ul>    
</li>

<li><a href="#">Compras</a>
       <ul>
            <li class="ui-state-disabled"><a href="#">Compras</a></li>
                <li><a href="#">Fornecedor</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Cadastro/Impressão</a></li>
                        <li><a href="fcad_fornecedor.php">Cadastro</a></li>
                        <li><a href="" target="_blank">Impressão</a></li>
                    </ul>
          		</li>
                <li><a href="#">Estoque</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Cadastro/Impressão</a></li>
                        <li><a href="fcon_particular.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_particular.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>
      </ul>    
</li>


<li><a href="#">Farmacia</a>
       <ul>
            <li class="ui-state-disabled"><a href="#">Farmacia</a></li>
                <li><a href="#">Medicamento</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Cadastro/Impressão</a></li>
                        <li><a href="fcad_medicamento.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_cliente.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>
                <li><a href="#">Material</a>
                    <ul>
                        <li class="ui-state-disabled"><a href="#">Cadastro/Impressão</a></li>
                        <li><a href="fcon_particular.php">Cadastro</a></li>
                        <li><a href="relatorio/crel_particular.php" target="_blank">Impressão</a></li>
                    </ul>
          		</li>
      </ul>    
</li>


<li><a href="#">CEP Correios</a>
        <ul>
            <li class="ui-state-disabled"><a href="#">CEP Correios</a></li>
            <li><a href="fpes_cep.php">Pesquisa CEP</a></li>
        </ul>    
</li>

<li><a href="#">SMS</a>
        <ul>
            <li class="ui-state-disabled"><a href="#">SMS</a></li>
            <li><a href="fpes_cep.php">Mensagens Padrão</a></li>
            <li><a href="fpes_cep.php">Enviar Mensagens</a></li>
        </ul>    
</li>

<li><a href="#">Administrador</a>
        <ul>
            <li class="ui-state-disabled"><a href="#">Administrador</a></li>
            <li><a href="fcon_usuario.php">Usuário</a></li>
        </ul>    
</li>


<li><a href="sair.php">Saír do Sistema</a>
        <ul>
            <li class="ui-state-enabled"><a href="sair.php">Saída</a></li>
        </ul>    
</li>
</ul>
<img src="imagem/ABSM-HM.jpg" width="305" height="49" />
</div> 
</div>
</body>
</html>