<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$servidor = "localhost"; $usuario = "root"; $contrasenia = ""; $nombreBaseDatos = "prueba";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);

// encuentra un usuario x2 
if (isset($_GET["consultar"])){
    $sqlConsultar = mysqli_query($conexionBD,"SELECT * FROM cities JOIN usuarios ON estado_id= cities.id WHERE usuarios.id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlConsultar) > 0){
        $Consultar = mysqli_fetch_all($sqlConsultar,MYSQLI_ASSOC);
        echo json_encode($Consultar);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}


    
// Consulta todos los registros de la tabla Usuarios
if (isset($_GET["users"])){
    $sqlUsers = mysqli_query($conexionBD,"SELECT * FROM cities JOIN usuarios ON estado_id= cities.id ");
    if(mysqli_num_rows($sqlUsers) > 0){
        $Users = mysqli_fetch_all($sqlUsers,MYSQLI_ASSOC);
        echo json_encode($Users);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}

// Consulta todos los estados de la tabla cities
if (isset($_GET["country"])){
    $sqlCities = mysqli_query($conexionBD,"SELECT * FROM cities WHERE country_id=".$_GET["country"]);
    if(mysqli_num_rows($sqlCities) > 0){
        $cities = mysqli_fetch_all($sqlCities,MYSQLI_ASSOC);
        echo json_encode($cities);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}

//Inserta un nuevo registro
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"), true);
    $name=$data['name'];
    $email=$data['email'];
    $password=$data['password'];
    $estado_id=$data['estado_id'];
    if (($email!="")&&($name!="")) {
        $sqlUsers = mysqli_query($conexionBD,"INSERT INTO usuarios(name, email, password, estado_id) VALUES('$name','$email', '$password', '$estado_id')");
        echo json_encode(["success"=>1]);
    }  
    exit();
}


//borrar un registro
if (isset($_GET["borrar"])){
        $sqlDestroy = mysqli_query($conexionBD,"DELETE FROM usuarios WHERE id=".$_GET["borrar"]);
        if($sqlDestroy){
            echo json_encode(["success"=>1]);
            exit();
        }
        else{  echo json_encode(["success"=>0]); }
}


//Actualiza un nuevo registro
if(isset($_GET["actualizar"])){
        $data = json_decode(file_get_contents("php://input"), true); 

        $id=(isset($data['id']))?$data['id']:$_GET["actualizar"];
        $name=$data['name'];
        $email=$data['email'];
        $password=$data['password'];
        $estado_id=$data['estado_id'];
        
        $sqlresult = mysqli_query($conexionBD,"UPDATE usuarios SET name='$name', email='$email', password='$password', estado_id='$estado_id' WHERE id='$id'");
        echo json_encode(["success"=>1]);
        exit();
}