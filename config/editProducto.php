<?php 
    include('ConexionDB.php');

    if(!empty($_POST)){
        //recibir los datos
        $cbarras = $_POST["cbarras"];
        $producto= $_POST["producto"];
        $stock = $_POST["stock"];
        $stockmin = $_POST["stockmin"];
        $precioN = $_POST["precion"];
        $precioV = $_POST["preciov"];
        $codTienda = "122230909";
        //UPDATE
        $upda = "UPDATE PRODUCTO SET NOMBRE_P = '$producto', STOCK='$stock', STOCK_MIN='$stockmin', PRECIO_N='$precioN', PRECIO_V='$precioV' WHERE C_BARRAS = $cbarras";
        //ejecutar consulta
        $query = mysqli_query($mysqli,$upda);
        if($query){
            echo "<script>alert('Actualizado correctamente');</script>";
        }
    }

    ///recuperacion de datos
    if(empty($_GET['cbr'])){
        //regresamos al listado
        header('Location: producto.php');
    }else{
        //obtener codigo de barras o clave principal
        $codigoB=$_GET['cbr'];
        //haciendo una consulta para el actualizado de datos posterior
        $sql= mysqli_query($mysqli,"SELECT C_BARRAS, NOMBRE_P, STOCK, STOCK_MIN, PRECIO_N, PRECIO_V FROM PRODUCTO WHERE C_BARRAS=$codigoB");
        $result_sql = mysqli_num_rows($sql);

        if($result_sql==0){
            //si el c_barras no  existe
            header('Location: producto.php');
        }else{
            while($data=mysqli_fetch_array($sql)){
                $cBarras = $data["C_BARRAS"];
                $Producto= $data["NOMBRE_P"];
                $Stock = $data["STOCK"];
                $Stockmin = $data["STOCK_MIN"];
                $PrecioN = $data["PRECIO_N"];
                $PrecioV = $data["PRECIO_V"];
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
    <meta name="author" content="LeonardoSsgif"></meta>
    <link rel="stylesheet" href="../css/style.css">
    <title>Actualizar Producto </title>
</head>
<body>
    <div class="cont_form">
        <h1>Actualizar producto</h1>
        <form class="formulario_ed" action="" method="POST">
            <label for="cbarras">Codigo</label>
            <input type="text" name="cbarras" id="cbarras" placeholder="Codigo de barras" readonly value="<?php echo $cBarras?>">
            <label for="producto">Producto</label>
            <input type="text" name="producto" id="producto" placeholder="Producto" required value="<?php echo $Producto?>">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" placeholder="Stock" required value="<?php echo $Stock?>">
            <label for="stockmin">Stock minimo</label>
            <input type="number" name="stockmin" id="stockmin" placeholder="Stock Minimo" value="<?php echo $Stockmin?>">
            <label for="presion">Precio neto</label>
            <input type="text" name="precion" id="precion" placeholder="Precio neto" required value="<?php echo $PrecioN?>">
            <label for="preciov">Precio de Venta</label>
            <input type="text" name="preciov" id="preciov" placeholder="Precio de venta" required value="<?php echo $PrecioV?>">
            <input type="submit" value="Actualizar">
        </form>
        <a href="producto.php" class="back">Regresa</a>
    </div>
    
</body>
</html>