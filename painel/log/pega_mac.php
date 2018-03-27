<?php
function pegaMac(){
exec("ipconfig /all", $output);
foreach($output as $line){
if (preg_match("/(.*)Endereço físico(.*)/", $line)){
$mac = $line;
$mac = str_replace("Endereço físico . . . . . . . . . . :","",$mac);
}
}
return $mac;
}
?> 