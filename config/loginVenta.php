<?php
    include("ConexionDB.php");
    session_start();
    if(!empty($_SESSION['active'])){
        header('location: nuevaVenta.php');
    }else{
        
        if(!empty($_POST)){
            $idVendedor = $_POST['vendedor'];
            //SELECT a.NOMBRES_EM FROM EMPLEADO a INNER JOIN EMPLEADOS_CARGO b ON a.ID_EMPLEADO =b.ID_EMPLEADO INNER JOIN CARGOS c ON b.ID_CARGO = c.ID_CARGO WHERE CARGO='VENDEDOR';
            //SELECT a.NOMBRES_EM FROM EMPLEADO a INNER JOIN EMPLEADOS_CARGO b ON a.ID_EMPLEADO =b.ID_EMPLEADO INNER JOIN CARGOS c ON b.ID_CARGO = c.ID_CARGO WHERE a.ID_EMPLEADO=3 AND CARGO='VENDEDOR'
            $consulta= "SELECT a.NOMBRES_EM FROM EMPLEADO a INNER JOIN EMPLEADOS_CARGO b ON a.ID_EMPLEADO =b.ID_EMPLEADO INNER JOIN CARGOS c ON b.ID_CARGO = c.ID_CARGO WHERE a.ID_EMPLEADO=$idVendedor AND CARGO='VENDEDOR'";
            $checa_cargo= mysqli_query($mysqli,$consulta);
            $result= mysqli_fetch_array($checa_cargo);
            if($result>0){
                $query= mysqli_query($mysqli,"SELECT ID_EMPLEADO, NOMBRES_EM FROM EMPLEADO WHERE ID_EMPLEADO=$idVendedor");
                $resultV= mysqli_num_rows($query);
                if($resultV>0){
                    $data=mysqli_fetch_array($query);
                    print_r($data);
    
                    $_SESSION['active'] = true;
                    $_SESSION['idVendedor']= $data['ID_EMPLEADO'];
                    $_SESSION['nombre']= $data['NOMBRES_EM'];
                    header('Location: nuevaVenta.php');
                }
                //echo "<script>alert('Bienvenido');</script>";
            }else{
                echo "<script>alert('Error una venta solo la realiza un Vendedor');</script>";
                session_destroy();
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="cont_form">
        <form class="formulario_ed" action="" method="post">

        <h3>Iniciar venta</h3>
        <img src="../images/vendedor.png" width="50px" alt="vendedor">
        
        <input type="text" name="vendedor" id="vendedor" placeholder="Ingresa tu Identificador de vendedor" required>
        <input type="submit" value="Nueva venta">
        </form>
        <a href="producto.php" class="back">Regresa</a>
    </div>
</body>
</html>