<?php


function establecerConexion($dominio,$usuario,$password,$database){
    
    $conexion = mysqli_connect($dominio,$usuario,$password,$database);
// Verificar si la conexion fue exitosa
    if (mysqli_connect_errno()) {
        printf("Falló la conexión: %s\n", mysqli_connect_error());
        return "error";
    }else{
        return $conexion;
    }
}

function buscarDato($conexion,$tabla,$columnaBuscar,$datoBuscado)
{
$sql = "SELECT * FROM $tabla WHERE $columnaBuscar= '$datoBuscado'";
$devolver = null;
// Ejecutar la consulta:
$rs = mysqli_query($conexion, $sql);
if( $rs )
{
// Si se encontró el registro, se obtiene una fila con los datos de los campos:
if( mysqli_num_rows($rs) > 0 )
$devolver = mysqli_fetch_row( $rs );
}
return $devolver;
}

function cerrarConexion($conexion){
    return mysqli_close($conexion);
}
?>