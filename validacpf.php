function validarCPF($cpf){

   $nulos = array("12345678901","12345678909","11111111111","22222222222","33333333333"
,"44444444444","55555555555","66666666666","77777777777",
                           "88888888888","99999999999","00000000000");
   $cpf = ereg_replace("[^0-9]", "", $cpf);
   if(strlen($cpf)!= 11){
         $resultado = "<b><font color='#FF0000'>Resultado:</font></b><br>O CPF tem que ter 11 números - $cpf";
   }elseif(in_array($cpf, $nulos)){
         $resultado = "<b><font color='#FF0000'>Resultado:</font></b><br>CPF Inválido. Este CPF é Nulo - $cpf";
   }else{
         for ($X = 0; $X <= (strlen($cpf)-1); $X++) {
           $numeros .= "{$cpf[$X]},";
         }
         $numeros = explode(",", $numeros);
         $conta=10*$numeros[0]+9*$numeros[1]+8*$numeros[2]+7*$
numeros[3]+6*$numeros[4]+5*$numeros[5]+4*$numeros[6]
+3*$numeros[7]+2*$numeros[8];
         $conta2=$conta-(11*(intval($conta/11)));
         if($conta2 == 0 || $conta2 == 1){
           $valor = 0;
         }else{
           $valor = (11-$conta2);
         }
         if($numeros[9] != $valor){
           $resultado = "<b><font color='#FF0000'>Resultado:</font></b><br>CPF Inválido.";
         }else{
           $conta3=11*$numeros[0]+10*$numeros[1]+9*$numeros[2]+8*$
numeros[3]+7*$numeros[4]+6*$numeros[5]+5*$numeros[6]
+4*$numeros[7]+3*$numeros[8]+2*$numeros[9];
           $conta4=$conta3-(11*(intval($conta3/11)));
           if($conta4 == 0 || $conta == 1){
                 $valor2 = 0;
           }else{
                 $valor2 = (11-$conta4);
                 if($numeros[10] != $valor2){
                 $resultado = "<b><font color='#FF0000'>Resultado:</font></b><br>CPF Inválido.";
                 }else{
                 $resultado = "<b><font color='#FF0000'>Resultado:</font></b><br> O CPF está OK - $cpf";
                 }
           }
         }
   }
   return $resultado;
}