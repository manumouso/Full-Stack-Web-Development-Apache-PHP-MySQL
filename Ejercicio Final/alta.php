<?php
include 'validar.php';
include 'conexion.php';
include 'encriptar.php';

$usuario=$_POST['txtUsuario'];
$password=$_POST['txtPassword'];
$nombre=$_POST['txtNombre'];
$apellido=$_POST['txtApellido'];
$edad=$_POST['numEdad'];


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
if(imprimirValidacion($aErrores,$aMensajes,"Registrado Satisfactoriamente","Ingrese los datos correctamente","alta.html")){
    $sexo=$_POST['radSexo'];
  
    $conexion = establecerConexion("localhost","root","1234php","ejerciciofinaldb");
    // Verificar si la conexion fue exitosa
    if($conexion!="error"){
        $fila = buscarDato($conexion,"usuarios","nombreUsuario",$usuario);
        if( $fila == null ){
           
            $hash=encriptarClave($password);
            $insertarDatosUsuario="INSERT INTO usuarios(nombreUsuario,claveUsuario) VALUES('$usuario','$hash')";
            $rs = mysqli_query($conexion, $insertarDatosUsuario);
            $fila = buscarDato($conexion,"usuarios","nombreUsuario",$usuario);
            if($fila != null){
                $id=$fila[0];
                $insertarDatosPersonales="INSERT INTO datospersonales(nombre,apellido,edad,sexo,idUsuario) VALUES('$nombre','$apellido','$edad','$sexo','$id')";
                $rs = mysqli_query($conexion, $insertarDatosPersonales);
                echo "<br><a href='login.html' class='efecto_link'>Redirecionar al Login</a>";
                
            }
        }else{
            echo "El usuario $usuario ya se encuentra registrado, intentenlo con otro email";
        }
    }
  
    // Cerrar la conexión a MySQL
    cerrarConexion($conexion);
}

?>