<?php

$aErrores = array();
$aMensajes = array();

function validarTexto($datoEntrada,$mensaje,$error,&$aErrores,&$aMensajes){
    if($mensaje=="usuario" || $mensaje=="usuario anterior"){
        $patron_texto = '/^[a-zA-Z\d@.]+$/';
    }elseif($mensaje=="nombre" || $mensaje=="apellido"){
        $patron_texto = '/^[a-zA-Z]+$/';
    }else{
        $patron_texto = '/^[a-zA-Z\d]+$/';
    }
    
    $patron_prohibido='/\bselect\b/i';
    if(empty($datoEntrada)){
        $aErrores[]="$error";
    }else{
        if(!preg_match($patron_prohibido,$datoEntrada) && preg_match($patron_texto,$datoEntrada)){
            if($mensaje!="password"){
                $aMensajes[]="$mensaje: $datoEntrada";
            }
           
        }else{
            $aErrores[]="$error";    
        }
    }
}

function validarNumeros($datoEntrada,$mensaje,$error,&$aErrores,&$aMensajes){
    if(empty($datoEntrada)){
        $aErrores[]="$error";
    }else{
        if(is_numeric($datoEntrada) && $datoEntrada >0 && $datoEntrada < 150){
            $aMensajes[]="$mensaje: $datoEntrada";
        }else{
            $aErrores[]="$error";    
        }
    }    
}
function validarSet($datoEntrada,$mensaje,&$aMensajes){
    if(isset($datoEntrada)){
        $aMensajes[]="$mensaje: $datoEntrada";
    }
}

function imprimirValidacion($aErrores,$aMensajes,$tituloMensaje,$tituloError,$link){
    if(count($aErrores) >0){
        echo "<h3> $tituloError </h3><br>";
        foreach($aErrores as $errores){
            echo $errores."<br>";
        }
        echo "<p><a href =$link>Haz clic aquí para volver al formulario</a></p>";
        return false;
    }else{
        echo "<h3>$tituloMensaje </h3><br>";
        foreach($aMensajes as $mensaje){
            echo $mensaje."<br>";
        }
        return true;
    }
}
?>