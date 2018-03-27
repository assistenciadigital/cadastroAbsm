<HTML>
<HEAD>
<TITLE>Clone de caixa de texto</TITLE>
<SCRIPT LANGUAGE="JavaScript">
function enfocus()
{
   document.forms[0].Data.focus()
   document.forms[0].Copy.value = document.forms[0].Data.value
   setTimeout("enblur()", 500)
}
function enblur()
{
   document.forms[0].Data.blur()
   setTimeout("enfocus()", 5)
}
</script>
</HEAD>
<BODY onLoad="setTimeout('enblur()', 500)">
<CENTER><FORM>
Texto comum: <INPUT TYPE="TEXT" SIZE=40 NAME="Data"><br>
Caixa repetida: <INPUT TYPE="TEXT" SIZE=40 NAME="Copy"><br>
<INPUT TYPE="BUTTON" VALUE="Clear" onClick="document.forms[0].Data.value=''">
</FORM></CENTER>
</BODY></HTML>