<?php
session_start();

include "proyectoM.php";
    $objeto = new Usuario();
    
    $r = $objeto->Registrar(
        $_POST["nombre"],           
        $_POST["tipo_usuario"],     
        $_POST["nom_usuario"],      
        $_POST["contrasena"],      
        $_POST["correo_electronico"], 
        $_POST["direccion"],        
        $_POST["telefono"],         
        $_POST["documento_identidad"], 
        $_POST["eps"],              
        $_POST["tipo_sangre"],      
        $_POST["RH"],               
        $_POST["estado_civil"]      
    );
    header("Location: Login.html");

?>

