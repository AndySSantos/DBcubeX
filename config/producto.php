<!--inclusion php-->
<?php 
    include('ConexionDB.php');

    //recibir los datos
    $cbarras = $_POST["cbarras"];
    $producto= $_POST["producto"];
    $stock = $_POST["stock"];
    $stockmin = $_POST["stockmin"];
    $precioN = $_POST["precion"];
    $precioV = $_POST["preciov"];
    $codTienda = "122230909";
    //checamos que no se repita el codigo de barras 
    $query = mysqli_query($mysqli,"SELECT C_BARRAS FROM PRODUCTO WHERE C_BARRAS=$cbarras");
    $result= mysqli_fetch_array($query);

    if($result>0){
        echo "<script>alert('Error Codigo existente');</script>";
    }else{
        //consulta
        $insertar = "INSERT INTO PRODUCTO (C_BARRAS, NOMBRE_P, STOCK, STOCK_MIN, PRECIO_N, PRECIO_V, COD_T) VALUES ('$cbarras', '$producto','$stock', '$stockmin', '$precioN', '$precioV', '$codTienda')";
        //ejecutar consulta
        $query = mysqli_query($mysqli,$insertar);
        if($query){
            echo "<script>alert('Registrado');</script>";
        }
    }
    
?>
<!--cuerpo pagina-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="hora.js"></script>
    <title>Producto</title>
</head>
<body>
    <div class="contenedor_principal">
        <header>
            <div class="imagen">
                <img src="../images/logo.png" alt="logo DBCUBEX" class="logo">
            </div>
            <nav class="menu">
            <a href="../">Home</a>
            <a class="home" href="#">Producto</a>
            <a href="empleado.php">Empleado</a>
            <a href="venta.php">Venta</a>
            <a href="cliente.php">Cliente</a>
            <a href="proveedor.php">Proveedores</a>
            </nav>
            <div class="copyright">
                <p>DBCUBEX</p>
            </div>
        </header>
        <!--Contenedor para el formulario y vista de datos--->
        <section class="contenedor_general">
            <div class="fecha">
                <h1><script>DameLaFechaHora();</script></h1>
                <a href="" class="cta">?</a>
            </div>
            <!--modal-->
            <div class="modal-container">
                <div class="modal modal-close">
                    <p class="close">X</p>
                    <div class="modal-textos">
                        <img src="../images/empresa.png" alt="empresa">
                        <p class="prin">DBCUBEX</p>
                        <p class="prin version"> Version 1.5</p>
                        <p class="prin">DESARROLLITIX</p>
                        <p class="contact">CORREO ELECTRONICO:</p>
                        <p class="contact valor"> hello@reallygreatsite.com</p>
                        <p class="contact">TELEFONO:</p>
                        <p class="contact valor">(123) 456 7890</p>
                    </div>
                </div>
            </div>
            <script src="main.js"></script>
            <!---formulario-->
            <article class="formulario_insertar">
                <form class="formulario" action="producto.php" method="POST">
                    <input type="text" name="cbarras" id="cbarras" placeholder="Codigo de barras" required>
                    <input type="text" name="producto" id="producto" placeholder="Producto" required>
                    <input type="number" name="stock" id="stock" placeholder="Stock" required>
                    <input type="number" name="stockmin" id="stockmin" placeholder="Stock Minimo">
                    <input type="text" name="precion" id="precion" placeholder="Precio neto" required>
                    <input type="text" name="preciov" id="preciov" placeholder="Precio de venta" required>
                    <input type="submit" value="Agregar">
                </form>
            </article>
            <article class="vista_datos">
            <table>
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Stock</th>
                    <th>Stock Minimo</th>
                    <th>Precio Neto</th>
                    <th>Precio venta</th>
                    <th>Acciones</th>
                </tr>
                <?php
                        //paginador
                        $sql_registe = mysqli_query($mysqli,"SELECT COUNT(*) AS TOTAL_REGISTRO FROM PRODUCTO");
                        $result_register =mysqli_fetch_array($sql_registe);
                        $total_registro = $result_register['TOTAL_REGISTRO'];

                        $por_pagina=8;
                        if(empty($_GET['pagina'])){
                            $pagina=1;
                        }else{
                            $pagina= $_GET['pagina'];
                        }

                        $desde=($pagina-1)*$por_pagina;
                        $total_paginas= ceil($total_registro / $por_pagina);

                        $query = mysqli_query($mysqli,"SELECT C_BARRAS, NOMBRE_P, STOCK, STOCK_MIN, PRECIO_N, PRECIO_V FROM PRODUCTO ORDER BY C_BARRAS ASC LIMIT $desde,$por_pagina ");
                        $result = mysqli_num_rows($query);

                        if($result>0){
                            while($data=mysqli_fetch_array($query)){
                            
                        ?>
                            <tr>
                                <td><?php echo $data["C_BARRAS"]; ?></td>
                                <td><?php echo $data["NOMBRE_P"]; ?></td>
                                <td><?php echo $data["STOCK"]; ?></td>
                                <td><?php echo $data["STOCK_MIN"]; ?></td>
                                <td><?php echo $data["PRECIO_N"]; ?></td>
                                <td><?php echo $data["PRECIO_V"]; ?></td>
                                <td>
                                    <a class="link_edit" href="editProducto.php?cbr=<?php echo $data["C_BARRAS"]; ?>">Editar</a>
                                    <!--<a class="link_delete" href="#">Eliminar</a>-->
                                </td>
                            </tr>
                    <?php    

                            }
                        }
                ?>
                

            </table>
            <div class="paginador">
                <ul>
                    <?php
                        if($pagina!=1){
                    ?>
                    <li><a href="?pagina=<?php echo 1;?>">|<</a></li>
                    <li><a href="?pagina=<?php echo $pagina-1;?>""><<</a></li>
                    <?php
                        } 
                        for ($i=1; $i <=$total_paginas ; $i++) { 
                            # code...
                            if($i==$pagina){
                                echo '<li class="pageSelected">'.$i.'</li>';
                            }else{
                                echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
                            }
                        }
                        if($pagina !=$total_paginas){

                    ?>
                    <li><a href="?pagina=<?php echo $pagina+1;?>"">>></a></li>
                    <li><a href="?pagina=<?php echo $total_paginas;?>"">>|</a></li>
                    <?php } ?>
                </ul>
            </div>
            </article>
        </section>
    </div>
</body>
</html>