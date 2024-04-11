<?php  
    include("ConexionDB.php");

    session_start();
    if(empty($_SESSION['active'])){
        header('location: loginVenta.php');
    }

    $cbarras = $_POST["cProduct"];
    $cantPr = $_POST["cantPr"];
    $numeroVenta=$_POST["numeroVenta"];

    ///checa si existe el producto ingresado
    $query = mysqli_query($mysqli,"SELECT STOCK FROM PRODUCTO WHERE C_BARRAS=$cbarras");
    $result= mysqli_fetch_array($query);
    //si hay un registro que inique que existe el cbarras recibido
    if($result>0){
        //checamos que haya stock
        $total_registro = $result['STOCK'];
        if($cantPr < $total_registro){
            
            $CanNew=$total_registro-$cantPr;
            $actualizacion =mysqli_query($mysqli,"UPDATE PRODUCTO SET STOCK = '$CanNew' WHERE C_BARRAS = $cbarras");
            $insertar = "INSERT INTO GENERIC_CARRO (C_BARRAS, N_PR, N_VENTA) VALUES ('$cbarras', '$cantPr', '$numeroVenta')";
                //generamos vista
            //$prVendido = mysqli_query($mysqli,"INSERT INTO PRODUCTOS_VENDIDOS (C_BARRAS, N_VENTA, N_PR) VALUES ('$cbarras','$numeroVenta', '$cantPr')");
            $query = mysqli_query($mysqli,$insertar);
            echo $query;   
        }
    }
?>