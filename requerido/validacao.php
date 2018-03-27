<?php
#VALIDACOES

// Formata data dd/mm/aaaa para aaaa-mm-dd
function data_banco($databr) {
	if (!empty($databr)){
	$p_dt = explode('/',$databr);
	$data_sql = $p_dt[2].'-'.$p_dt[1].'-'.$p_dt[0];
	return $data_sql;
	}
}

// Formata data aaaa-mm-dd para dd/mm/aaaa
function data_form($datasql) {
	if (!empty($datasql)){
	$p_dt = explode('-',$datasql);
	$data_br = $p_dt[2].'/'.$p_dt[1].'/'.$p_dt[0];
	return $data_br;
	}
}

// Formata hora hh:mm:ss para hh:mm
function hora_form($horasql) {
	if (!empty($horasql)){
	$p_hora = explode(':',$horasql);
	$hora_br = $p_hora[0].':'.$p_hora[1];
	return $hora_br;
	}
}

// Formata texto sem expacos e formatacao
function arruma_txt($txt)
{
	$txt =                                ltrim($txt);
	$txt =                                rtrim($txt);
	$txt =                                 trim($txt);
	$txt =                         stripslashes($txt);
	$txt =                         htmlentities($txt);
	$txt =                          utf8_decode($txt);
	$txt =                     htmlspecialchars($txt);
	$txt = utf8_decode(htmlspecialchars_decode($txt));
	$txt =                           strtoupper($txt);	
	return $txt;
}

// Tira acento do texto nao resolveu - nao usar
function tira_acento($str)
{
return strtr(utf8_decode($str),utf8_decode(‘àáâãäèéêëìíîïòóôõöùúûüÀÁÂÃÄÈÉÊËÌÍÎÒÓÔÕÖÙÚÛÜçÇñÑ’),
                                           ’aaaaaeeeeiiiiooooouuuuAAAAAEEEEIIIOOOOOUUUUcCnN’);
}

// Tira acento do texto nao resolveu - nao usar
function tirar_acento($str) {
$str = preg_replace("/[^a-zA-Z ]/", "", strtr($str, "áàãâéêíóôõúüçñÁÀÃÂÉÊÍÓÔÕÚÜÇÑ", "aaaaeeiooouucnAAAAEEIOOOUUCN"));
return $str ;
}

function remove_acento($str, $enc = 'UTF-8'){
 $acentos = array(
 
 	 'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
	 'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
	 'C' => '/&Ccedil;/',
	 'c' => '/&ccedil;/', 
	 'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/', 
	 'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/', 
	 'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/', 
	 'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/', 
	 'N' => '/&Ntilde;/', 
	 'n' => '/&ntilde;/', 
	 'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/', 
	 'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/', 
	 'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/', 
	 'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/', 
	 'Y' => '/&Yacute;/', 
	 'y' => '/&yacute;|&yuml;/', 
	 'a.' => '/&ordf;/', 
	 'o.' => '/&ordm;/' );
	  return preg_replace($acentos, array_keys($acentos), htmlentities($str,ENT_NOQUOTES, $enc)); 
 }

#FIM VALIDACOES
?>