<!--inclusion php-->
<?php 
    include('ConexionDB.php');    
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
    <title>Venta</title>
</head>
<body>
    <div class="contenedor_principal">
        <header>
            <div class="imagen">
                <img src="../images/logo.png" alt="logo DBCUBEX" class="logo">
            </div>
            <nav class="menu">
            <a href="../">Home</a>
            <a href="producto.php">Producto</a>
            <a href="empleado.php">Empleado</a>
            <a class="home" href="#">Venta</a>
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
            <article class="formulario_insertar">
                <a href="nuevaVenta.php" class="nueva_venta">Nueva Venta</a>
            </article>
            <article class="vista_datos">
            <table>
                <tr>
                    <th>N venta</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th>Tipo de pago</th>
                    <th>Tipo de venta</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                <?php
                        //paginador
                        $sql_registe = mysqli_query($mysqli,"SELECT COUNT(*) AS TOTAL_REGISTRO FROM VENTA");
                        $result_register =mysqli_fetch_array($sql_registe);
                        $total_registro = $result_register['TOTAL_REGISTRO'];
                        
                        //SELECT a.N_VENTA, d.NOMBRES_EM , a.NOMBRE_CL, c.METODO, b.TIPOVENTA, a.FECHA_VENTA FROM VENTA a INNER JOIN TIPO_VENTA b ON a.ID_TIPO_VENTA=b.ID_TIPO_VENTA INNER JOIN METODO_PAGO c ON a.ID_METODO_PAGO= c.ID_METODO INNER JOIN EMPLEADO d ON a.ID_EMPLEADO=d.ID_EMPLEADO;
                        
                        $por_pagina=8;
                        if(empty($_GET['pagina'])){
                            $pagina=1;
                        }else{
                            $pagina= $_GET['pagina'];
                        }

                        $desde=($pagina-1)*$por_pagina;
                        $total_paginas= ceil($total_registro / $por_pagina);

                        $query = mysqli_query($mysqli,"SELECT a.N_VENTA, d.NOMBRES_EM , a.NOMBRE_CL, c.METODO, b.TIPOVENTA, a.FECHA_VENTA FROM VENTA a INNER JOIN TIPO_VENTA b ON a.ID_TIPO_VENTA=b.ID_TIPO_VENTA INNER JOIN METODO_PAGO c ON a.ID_METODO_PAGO= c.ID_METODO INNER JOIN EMPLEADO d ON a.ID_EMPLEADO=d.ID_EMPLEADO ORDER BY N_VENTA ASC LIMIT $desde,$por_pagina ");
                        $result = mysqli_num_rows($query);

                        if($result>0){
                            while($data=mysqli_fetch_array($query)){
                            
                        ?>
                            <tr>
                                <td><?php echo $data["N_VENTA"]; ?></td>
                                <td><?php echo $data["NOMBRES_EM"]; ?></td>
                                <td><?php echo $data["NOMBRE_CL"]; ?></td>
                                <td><?php echo $data["METODO"]; ?></td>
                                <td><?php echo $data["TIPOVENTA"]; ?></td>
                                <td><?php echo $data["FECHA_VENTA"]; ?></td>
                                <td>
                                    <a class="link_factura" href="factura.php?cbr=<?php echo $data["N_VENTA"]; ?>">Facturacion</a>
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