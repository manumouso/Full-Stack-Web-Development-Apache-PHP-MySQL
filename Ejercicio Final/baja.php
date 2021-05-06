<?php
include 'validar.php';
include 'conexion.php';
include 'encriptar.php';

$usuario=$_POST['txtUsuario'];
$password=$_POST['txtPassword'];
$password2=$_POST['txtPassword2'];

validarTexto($usuario,"usuario","Debe ingresar un nombre de usuario valido, recuede solo puede ingresar caracteres y/o numeros @ ., y el usuario debe existir de lo contrario registrese.",$aErrores,$aMensajes);
if($password==$password2){
    validarTexto($password,"password","Debe ingresar una constraseña valida, recuede solo puede ingresar caracteres y/o numeros",$aErrores,$aMensajes);
}else{
    $aErrores[]="Las contraseñas ingresadas son distintas, intentelo nuevamente";
}

if(imprimirValidacion($aErrores,$aMensajes,"Hasta luego $usuario","Introduzca los datos requeridos","baja.html")){

    $conexion = establecerConexion("localhost","root","1234php","ejerciciofinaldb");
    // Verificar si la conexion fue exitosa
    if($conexion!="error"){
        $fila = buscarDato($conexion,"usuarios","nombreUsuario",$usuario);
        if($fila!= null){
            $id=$fila[0];
            if($fila[2]== encriptarClave($password)){
                $fila = buscarDato($conexion,"datospersonales","idUsuario",$id);
                if($fila!=null){
                    $bajaDatosPersonales="DELETE FROM datospersonales WHERE idUsuario='$id'";
                    $rs = mysqli_query($conexion, $bajaDatosPersonales);
                    $bajaUsuario="DELETE FROM usuarios WHERE idUsuario='$id'";
                    $rs = mysqli_query($conexion, $bajaUsuario);
                    echo "Datos eliminados Satisfactoriamente <br>";
                }else{
                    $bajaUsuario="DELETE FROM usuarios WHERE idUsuario='$id'";
                    $rs = mysqli_query($conexion, $bajaUsuario);
                    echo "Datos eliminados satisfactoriamente <br>";
                    echo "<a href='index.html' class='efecto_link'>Redireccionar al Home</a>"
             
                }
            }else{
                echo "La clave ingresada es incorrecta <br>";
                echo "<a href='baja.html' class='efecto_link'>Redireccionar a Baja</a>"

            }
        }        
    }       
  
    // Cerrar la conexión a MySQL
    cerrarConexion($conexion);
}
?>