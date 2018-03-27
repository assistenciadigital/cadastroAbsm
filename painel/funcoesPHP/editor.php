<?php
include_once($relativo."html_editor/fckeditor.php");
$oFCKeditor = new FCKeditor($nome_do_campo) ;
$oFCKeditor->BasePath = $relativo.'html_editor/' ;
$oFCKeditor->Width = $largura;
$oFCKeditor->Height = $altura;
$oFCKeditor->Value = $texto_padrao;
$oFCKeditor->Create() ;
?>