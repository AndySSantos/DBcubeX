<?php
 include('config/ConexionDB.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="config/hora.js"></script>
    <title>DASHBOARD</title>
</head>
<body>
    <div class="contenedor_principal">
        <header>
            <div class="imagen">
                <img src="images/logo.png" alt="logo DBCUBEX" class="logo">
            </div>
            <nav class="menu">
            <a class="home" href="#" >Home</a>
            <a href="config/producto.php">Producto</a>
            <a href="config/empleado.php">Empleado</a>
            <a href="config/venta.php">Venta</a>
            <a href="config/cliente.php">Cliente</a>
            <a href="config/proveedor.php">Proveedores</a>
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
            <!--Ventana modal--->
            <div class="modal-container">
                <div class="modal modal-close">
                    <p class="close">X</p>
                    <div class="modal-textos">
                        <img src="images/empresa.png" alt="empresa">
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
            <script src="config/main.js"></script>
            <!--Contenedor resumen sistema--->
            <div class="dashboards">
                <?php
                //dashborads
                $sql_registe= mysqli_query($mysqli, "SELECT COUNT(*) AS TOTAL_EMPLEADOS FROM EMPLEADO");
                $result_register =mysqli_fetch_array($sql_registe);
                $total_registroEm = $result_register['TOTAL_EMPLEADOS'];

                $sql_registe= mysqli_query($mysqli, "SELECT COUNT(*) AS TOTAL_VENTA FROM VENTA");
                $result_register =mysqli_fetch_array($sql_registe);
                $total_registroVe = $result_register['TOTAL_VENTA'];

                $sql_registe= mysqli_query($mysqli, "SELECT COUNT(*) AS TOTAL_CLIENTE FROM CLIENTE");
                $result_register =mysqli_fetch_array($sql_registe);
                $total_registroClie = $result_register['TOTAL_CLIENTE'];

                $sql_registe= mysqli_query($mysqli, "SELECT COUNT(*) AS TOTAL_PRODUCTO FROM PRODUCTO");
                $result_register =mysqli_fetch_array($sql_registe);
                $total_registroPr = $result_register['TOTAL_PRODUCTO'];
                ?>
                <article class="resum">
                    <img src="images/empleado.png" alt="Empleado">
                    <?php echo "<p>Total empleados $total_registroEm</p>"?>
                </article>
                <article class="resum">
                    <img src="images/cliente.png" alt="cliente">
                    <?php echo "<p>Total clientes $total_registroClie</p>"?>
                </article>
                <article class="resum">
                    <img src="images/venta.png" alt="venta">
                    <?php echo "<p>Total Ventas $total_registroVe</p>"?>
                </article>
                <article class="resum">
                    <img src="images/producto.png" alt="producto">
                    <?php echo "<p>Total Productos $total_registroPr</p>"?>
                </article>
            </div>
            <!--Contenedor para la vista de datos--->
            <article class="vista_datos">
                <h3>Productos en existencia</h3>
                <table>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad Disponible</th>
                    </tr>
                    <?php
                            //paginador
                            $sql_registe = mysqli_query($mysqli,"SELECT COUNT(*) AS TOTAL_REGISTRO FROM productos_existencia");
                            $result_register =mysqli_fetch_array($sql_registe);
                            $total_registro = $result_register['TOTAL_REGISTRO'];

                            $por_pagina=10;
                            if(empty($_GET['pagina'])){
                                $pagina=1;
                            }else{
                                $pagina= $_GET['pagina'];
                            }

                            $desde=($pagina-1)*$por_pagina;
                            $total_paginas= ceil($total_registro / $por_pagina);
                            //datos
                            $query = mysqli_query($mysqli,"SELECT PRODUCTO, CANTIDAD_DISPONIBLE FROM productos_existencia ORDER BY CANTIDAD_DISPONIBLE ASC LIMIT $desde,$por_pagina ");
                            $result = mysqli_num_rows($query);

                            if($result>0){
                                while($data=mysqli_fetch_array($query)){
                                
                            ?>
                                <tr>
                                    <td><?php echo $data["PRODUCTO"]; ?></td>
                                    <td><?php echo $data["CANTIDAD_DISPONIBLE"]; ?></td>
                                </tr>
                        <?php    

                                }
                            }
                    ?>
                    

                </table>
                <!--Paginador--->
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