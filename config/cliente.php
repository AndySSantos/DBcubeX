<!--inclusion php-->
<?php 
    include('ConexionDB.php');

    //recibir los datos

    $idCliente=$_POST['idCliente'];
    $nombres=$_POST['nombres'];
    $appCl=$_POST['appCl'];
    $apmCl=$_POST['apmCl'];
    $calle=$_POST['calle'];
    $colonia=$_POST['colonia'];
    $municipio=$_POST['municipio'];
    $numExt=$_POST['numExt'];
    $numInt=$_POST['numInt'];
    $cp=$_POST['cp'];
    $telefonoCl=$_POST['telefonoCl'];
    //checamos que no se repita EL MISMO CLIENTE
    $query = mysqli_query($mysqli,"SELECT * FROM CLIENTE WHERE NOMBRES_CL='$nombres' AND APP_CL='$appCl' AND APM_CL ='$apmCl' ");
    $result= mysqli_fetch_array($query);

    if($result>0){
        echo "<script>alert('Error cliente ya registrado');</script>";
    }else{
        //consulta
        $insertar = "INSERT INTO CLIENTE (ID_CLIENTE, NOMBRES_CL, APP_CL, APM_CL, CALLE, COLONIA, MUNICIPIO, NUM_EXT, NUM_INT, CP, TELEFONOM_CL) VALUES ('$idCliente', '$nombres', '$appCl', '$apmCl', '$calle', '$colonia', '$municipio', '$numExt', '$numInt', '$cp', '$telefonoCl')";
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
            <a href="producto.php">Producto</a>
            <a href="empleado.php">Empleado</a>
            <a href="venta.php">Venta</a>
            <a class="home" href="#">Cliente</a>
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
                <form class="formulario empleado" action="cliente.php" method="POST">
                    <input type="number" name="idCliente" id="idCliente" placeholder="Id cliente" min="1" required>
                    <input type="text" name="nombres" id="nombres" placeholder="Nombre(s)" required>
                    <input type="text" name="appCl" id="appCl" placeholder="Apellido paterno" required>
                    <input type="text" name="apmCl" id="apmCl" placeholder="Apellido materno" required>
                    <input type="text" name="calle" id="calle" placeholder="calle" required>
                    <input type="text" name="colonia" id="colonia" placeholder="colonia" required>
                    <input type="text" name="municipio" id="municipio" placeholder="municipio" required>
                    <input type="number" name="numExt" id="numExt" placeholder="Num. Ext" required min="0">
                    <input type="number" name="numInt" id="numInt" placeholder="Num. Int (Opcional)" min="0">
                    <input type="number" name="cp" id="cp" placeholder="Codigo Postal" min="0" required>  
                    <input type="number" name="telefonoCl" id="telefonoCl" placeholder="Telefono" required>
                    <input type="submit" value="Agregar">
                </form>
            </article>
            <!---Tabladb--->
            <article class="vista_datos">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Calle</th>
                    <th>Colonia</th>
                    <th>Municipio</th>
                    <th>Num. Ext</th>
                    <th>Num. Int</th>
                    <th>cp</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
                <?php
                        //paginador
                        $sql_registe = mysqli_query($mysqli,"SELECT COUNT(*) AS TOTAL_REGISTRO FROM CLIENTE");
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

                        $query = mysqli_query($mysqli,"SELECT * FROM CLIENTE ORDER BY ID_CLIENTE ASC LIMIT $desde,$por_pagina ");
                        $result = mysqli_num_rows($query);

                        if($result>0){
                            while($data=mysqli_fetch_array($query)){
                            
                        ?>
                            <tr>
                                <td><?php echo $data["ID_CLIENTE"]; ?></td>
                                <td><?php echo $data["NOMBRES_CL"]; ?></td>
                                <td><?php echo $data["APP_CL"]; ?></td>
                                <td><?php echo $data["APM_CL"]; ?></td>
                                <td><?php echo $data["CALLE"]; ?></td>
                                <td><?php echo $data["COLONIA"]; ?></td>
                                <td><?php echo $data["MUNICIPIO"]; ?></td>
                                <td><?php echo $data["NUM_EXT"]; ?></td>
                                <td><?php echo $data["NUM_INT"]; ?></td>
                                <td><?php echo $data["CP"]; ?></td>
                                <td><?php echo $data["TELEFONOM_CL"]; ?></td>
                                <td>
                                    <!---<a class="link_edit" href="editProducto.php?cbr=<?php echo $data["C_BARRAS"]; ?>">Editar</a>--->
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