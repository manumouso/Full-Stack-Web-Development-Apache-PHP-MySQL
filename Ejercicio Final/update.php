<?php
include 'validar.php';
include 'conexion.php';
include 'encriptar.php';

$usuarioAnterior=$_POST['txtUsuarioAnterior'];;
$passwordAnterior=$_POST['txtPasswordAnterior'];;
$usuario=$_POST['txtUsuario'];
$password=$_POST['txtPassword'];
$nombre=$_POST['txtNombre'];
$apellido=$_POST['txtApellido'];
$edad=$_POST['numEdad'];

validarTexto($usuarioAnterior,"usuario anterior","Debe ingresar un nombre de usuario valido, recuede solo puede ingresar caracteres y/o numeros @ .",$aErrores,$aMensajes);
validarTexto($passwordAnterior,"password","Debe ingresar una constraseña valida, recuede solo puede ingresar caracteres y/o numeros",$aErrores,$aMensajes);
validarTexto($usuario,"usuario","Debe ingresar un nombre de usuario valido, recuede solo puede ingresar caracteres y/o numeros @ .",$aErrores,$aMensajes);
validarTexto($password,"password","Debe ingresar una constraseña valida, recuede solo puede ingresar caracteres y/o numeros",$aErrores,$aMensajes);
validarTexto($nombre,"nombre","Debe ingresar un nombre valido, recuede solo puede ingresar caracteres A-z",$aErrores,$aMensajes);
validarTexto($apellido,"apellido","Debe ingresar un apellido valido, recuede solo puede ingresar caracteres A-z",$aErrores,$aMensajes);
validarNumeros($edad,"edad","Debe ingresar una edad valida, un numero mayor a 0 y menor a 150",$aErrores,$aMensajes);
if(!empty($_POST['radSexo'])){
        
    validarSet($_POST['radSexo'],"sexo",$aMensajes);
        
}else{
    $aErrores[]="No selecciono sexo";
}
if(imprimirValidacion($aErrores,$aMensajes,"Actualización","Ingrese los datos correctamente","alta.html")){
    $sexo=$_POST['radSexo'];
  
    $conexion = establecerConexion("localhost","root","1234php","ejerciciofinaldb");
    // Verificar si la conexion fue exitosa
    if($conexion!="error"){
        $fila = buscarDato($conexion,"usuarios","nombreUsuario",$usuarioAnterior);
        if( $fila != null ){
            if($fila[2]== encriptarClave($passwordAnterior)){
                $hash=encriptarClave($password);
                $actualizarDatosUsuario="UPDATE usuarios SET nombreUsuario='$usuario',claveUsuario ='$hash' WHERE nombreUsuario='$usuarioAnterior'";
                $rs = mysqli_query($conexion, $actualizarDatosUsuario);
                
                $fila = buscarDato($conexion,"usuarios","nombreUsuario",$usuario);
                if($fila != null){
                    $id=$fila[0];
                    $actualizarDatosPersonales="UPDATE datospersonales SET nombre='$nombre',apellido='$apellido',edad='$edad',sexo='$sexo' WHERE idUsuario='$id'";
                    $rs = mysqli_query($conexion, $actualizarDatosPersonales);
                    echo "Datos actualizados satisfactoriamente <br>";
                    echo "<br><a href='login.html' class='efecto_link'>Redirecionar al Login</a>";
                }
            }else{
                echo "Contraseña ingresada incorrecta, no puede modificar los datos de este usuario<br>";
                echo "<a href='update.html' class='efecto_link'>Redireccionar a Actualizar Datos</a>";

            }
        }else{
            echo "Usuario ingresado incorrecto, intentelo nuevamente <br>";
            echo "<a href='update.html' class='efecto_link'>Redireccionar a Actualizar Datos</a>";
        }    
    }        
    // Cerrar la conexión a MySQL
    cerrarConexion($conexion);
}
?>