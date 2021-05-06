<?php
include 'validar.php';
include 'conexion.php';
include 'encriptar.php';

$usuario=$_POST['txtUsuario'];
$password=$_POST['txtPassword'];

validarTexto($usuario,"usuario","Debe ingresar un nombre de usuario valido, recuede solo puede ingresar caracteres y/o numeros @ ., y el usuario debe existir de lo contrario registrese.",$aErrores,$aMensajes);
validarTexto($password,"password","Debe ingresar una constraseña valida, recuede solo puede ingresar caracteres y/o numeros",$aErrores,$aMensajes);
if(imprimirValidacion($aErrores,$aMensajes,"Login","Introduzca los datos requeridos","login.html")){
    $conexion = establecerConexion("localhost","root","1234php","ejerciciofinaldb");
    // Verificar si la conexion fue exitosa
    if($conexion!="error"){
        $fila = buscarDato($conexion,"usuarios","nombreUsuario",$usuario);
        if( $fila == null ){
           echo "No se encuentra Registrado <br>";
           echo "<a href='alta.html' class='efecto_link'>Redireccionar al Alta Usuario</a>";
                   
        }else{
            
            $hash=encriptarClave($password);
            $fila = buscarDato($conexion,"usuarios","claveUsuario",$hash);
            if($fila != null){
                echo "Login Satisfactorio";
            }else{
                echo "La contraseña ingresada es incorrecta, intentelo nuevamente<br>";
                echo "<a href='login.html' class='efecto_link'>Redireccionar al Login</a>";

            }
        }
    }
        
    // Cerrar la conexión a MySQL
    cerrarConexion($conexion);
}
?>