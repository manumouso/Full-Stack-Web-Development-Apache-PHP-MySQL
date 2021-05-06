<?php

function encriptarClave($clave){
    
    if( CRYPT_SHA512 == 1 ){
        $encriptada=crypt($clave, '$6$rounds=20$usesomesillystringforsalt$');

        return substr($encriptada,40,10);
    }else{
        return "error";
    }
    
}
?>