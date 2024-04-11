<!--inclusion php-->
<?php 
    include('ConexionDB.php');

    //recibir los datos
   $nombres=$_POST["nombres"];
   $appEm=$_POST["appEm"];
   $apmEm=$_POST["apmEm"];
   $calle=$_POST["calle"];
   $colonia=$_POST["colonia"];
   $municipio=$_POST["municipio"];
   $numExt=$_POST["numExt"];
   $numInt=$_POST["numInt"];
   $cp=$_POST["cp"];
   $telefonoEm=$_POST["telefonoEm"];
   $idcargo=$_POST["cargo"];
   $total_registroEm=0;

   //checar unico duenio
   $checa_cargo= mysqli_query($mysqli,"SELECT * FROM EMPLEADOS_CARGO WHERE ID_CARGO=$idcargo AND ID_CARGO=2839823");///BUSCAMOS SI HAY CON EL CARGO ENCARGADO PUES SU ID =2839823;
   $checa_cliente = mysqli_query($mysqli,"SELECT * FROM EMPLEADO WHERE NOMBRES_EM='$nombres' AND APP_EM='$appEm' AND APM_EM ='$apmEm' ");
   $result= mysqli_fetch_array($checa_cargo);
   $resultcl= mysqli_fetch_array($checa_cliente);
   if($result>0){
       echo "<script>alert('Error solo un empleado es encargado');</script>";
    }else if($resultcl>0){
        echo "<script>alert('Error solo puede registrarse una vez este empleado');</script>";
    }else{
        //consulta
        $insertarEm = "INSERT INTO EMPLEADO (ID_EMPLEADO, NOMBRES_EM, APP_EM, APM_EM, CALLE, COLONIA, MUNICIPIO, NUM_EXT, NUM_INT, CP, TELEFONO_EM) VALUES (NULL, '$nombres', '$appEm', '$apmEm', '$calle', '$colonia', '$municipio', '$numExt', '$numInt', '$cp', '$telefonoEm')";
        //PARA OBTENER EN QUE ID EMPLEADO VA EL CARGO
        $sql_registe= mysqli_query($mysqli, "SELECT COUNT(*) AS TOTAL_EMPLEADOS FROM EMPLEADO");
        $result_register =mysqli_fetch_array($sql_registe);
        $total_registroEm = $result_register['TOTAL_EMPLEADOS'];
        $insertarCargo= "INSERT INTO EMPLEADOS_CARGO (ID_EMPLEADO, ID_CARGO) VALUES($total_registroEm+1,'$idcargo')";
        //ejecutar consulta
        $queryE = mysqli_query($mysqli,$insertarEm);
        $queryC= mysqli_query($mysqli, $insertarCargo);
        if($queryE){
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
    <title>Empleado</title>
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
            <a class="home" href="#">Empleado</a>
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
                <form class="formulario empleado" action="empleado.php" method="POST">
                    <input type="text" name="nombres" id="nombres" placeholder="Nombre(s)" required>
                    <input type="text" name="appEm" id="appEm" placeholder="Apellido Paterno" required>
                    <input type="text" name="apmEm" id="apmEm" placeholder="Apellido materno" required>
                    <input type="text" name="calle" id="calle" placeholder="Calle" required>
                    <input type="text" name="colonia" id="colonia" placeholder="Colonia" required> 
                    <input type="text" name="municipio" id="municipio" placeholder="Municipio" required>
                    <input type="number" name="numExt" id="numExt" placeholder="Num. Ext" min="0" required>
                    <input type="number" name="numInt" id="numInt" placeholder="Num. Int (Opcional)" min="0">
                    <input type="number" name="cp" id="cp" placeholder="Codigo postal" required min="0">
                    <input type="number" name="telefonoEm" id="telefonoEm" placeholder="Telefono Movil" required>

                    <?php
                        $query_cargo=mysqli_query($mysqli,"SELECT * FROM CARGOS");
                        $result_cargo = mysqli_num_rows($query_cargo);
                    ?>
                    <label for="cargo">Cargo:</label>
                    <select name="cargo" id="cargo">
                        <?php
                            if($result_cargo>0){
                                while($cargo=mysqli_fetch_array($query_cargo)){
                        ?>
                            <option value="<?php echo $cargo['ID_CARGO'];?>"><?php echo $cargo['CARGO']?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <input type="submit" value="Agregar">
                </form>
            </article>
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
                    <th>NumExt</th>
                    <th>NumInt</th>
                    <th>CP</th>
                    <th>Telefono</th>
                    <th>Cargo</th>
                    <th>Acciones</th>
                </tr>
                <?php
                        //paginador
                        $sql_registe = mysqli_query($mysqli,"SELECT COUNT(*) AS TOTAL_REGISTRO FROM EMPLEADO");
                        $result_register =mysqli_fetch_array($sql_registe);
                        $total_registro = $result_register['TOTAL_REGISTRO'];

                        $por_pagina=6;
                        if(empty($_GET['pagina'])){
                            $pagina=1;
                        }else{
                            $pagina= $_GET['pagina'];
                        }

                        $desde=($pagina-1)*$por_pagina;
                        $total_paginas= ceil($total_registro / $por_pagina);
                        //mostrando la tabla db
                        //sql consulta ejemplo SELECT a.NOMBRES_EM, c.CARGO FROM EMPLEADO a INNER JOIN EMPLEADOS_CARGO b ON a.ID_EMPLEADO=b.ID_EMPLEADO INNER JOIN CARGOS c ON b.ID_CARGO=c.ID_CARGO
                        $query = mysqli_query($mysqli,"SELECT a.ID_EMPLEADO, a.NOMBRES_EM, a.APP_EM, a.APM_EM, a.CALLE,a.COLONIA,a.MUNICIPIO,a.NUM_EXT,a.NUM_INT,a.CP,a.TELEFONO_EM, c.CARGO FROM EMPLEADO a INNER JOIN EMPLEADOS_CARGO b ON a.ID_EMPLEADO=b.ID_EMPLEADO INNER JOIN CARGOS c ON b.ID_CARGO=c.ID_CARGO ORDER BY ID_EMPLEADO ASC LIMIT $desde,$por_pagina ");
                        $result = mysqli_num_rows($query);

                        if($result>0){
                            while($data=mysqli_fetch_array($query)){
                            
                        ?>
                            <tr>
                                <td><?php echo $data["ID_EMPLEADO"]; ?></td>
                                <td><?php echo $data["NOMBRES_EM"]; ?></td>
                                <td><?php echo $data["APP_EM"]; ?></td>
                                <td><?php echo $data["APM_EM"]; ?></td>
                                <td><?php echo $data["CALLE"]; ?></td>
                                <td><?php echo $data["COLONIA"]; ?></td>
                                <td><?php echo $data["MUNICIPIO"]; ?></td>
                                <td><?php echo $data["NUM_EXT"]; ?></td>
                                <td><?php echo $data["NUM_INT"]; ?></td>
                                <td><?php echo $data["CP"]; ?></td>
                                <td><?php echo $data["TELEFONO_EM"]; ?></td>
                                <td><?php echo $data["CARGO"]; ?></td>
                                <td>
                                    <!---<a class="link_edit" href="editEmpleado.php?cbr=<?php echo $data["ID_EMPLEADO"]; ?>">Editar</a>-->
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