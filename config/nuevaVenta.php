<?php 
    include("ConexionDB.php");
    $numVenta = $_POST["numVenta"];
    $idVendedor= $_POST["idVendedor"];
    $nombreCliente = $_POST["nombreCliente"];
    $metodo = $_POST["metodo"];
    $tipo = $_POST["tipo"];
    if(empty($nombreCliente)){
        $nombreCliente='DESCONOCIDO';
    }
    $query=mysqli_query($mysqli, "INSERT INTO VENTA (N_VENTA, ID_EMPLEADO, NOMBRE_CL, ID_METODO_PAGO, ID_TIPO_VENTA, FECHA_VENTA) VALUES ('$numVenta', '$idVendedor', '$nombreCliente', '$metodo', '$tipo', NOW())");
    if($query){
        //SALVANDO LA VENTA
        $query=mysqli_query($mysqli,"SELECT * FROM GENERIC_CARRO");
        $result = mysqli_num_rows($query);
        if($result>0){
            while($cargo=mysqli_fetch_array($query)){
                $cbarras=$cargo['C_BARRAS'];
                $numeroVenta=$cargo['N_VENTA'];
                $cantPr=$cargo['N_PR'];
                $prVendido = mysqli_query($mysqli,"INSERT INTO PRODUCTOS_VENDIDOS (C_BARRAS, N_VENTA, N_PR) VALUES ('$cbarras','$numeroVenta', '$cantPr')");
            }
        }

        //REUSANDO CODIGO
        $vacialist=mysqli_query($mysqli,"DROP VIEW producto_carro");
        $vaciaGENERIC=mysqli_query($mysqli,"DELETE FROM GENERIC_CARRO WHERE N_VENTA=$numVenta");
        
        echo "<script>alert('Venta generada');</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styleVenta.css">
    <script src="jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#btnguardar').click(function(){
                //Obteniedo los datos
                function obtener_datos(){
                    $.ajax({
                        url: "tabla.php",
                        method: "POST",
                        success:function(data){
                            $("#resultado").html(data)
                        }
                    });
                }
                obtener_datos();
                return false;
            });
        });


    </script>
    <title>Document</title>
</head>
<body>
    <?php
        session_start();
        if(empty($_SESSION['active'])){
            header('location: loginVenta.php');
        }
    ?>
    <div class="contenedor_venta">
        <section class="resum">
            <article class="datos_venta"> 
                <?php 
                    //generamos un número aleatorio
                    $numeroVenta = rand(1,1000000); 
                    $idEm= $_SESSION['idVendedor'];
                ?>
                <img src="../images/logo.png" alt="logo">
                <p class="etique nombre_vendedor">Vendedor: <?php echo $_SESSION['nombre']?> </p>
                <p class="etique numero_venta"> Venta:  <?php echo "$numeroVenta"?></p>
                <a class="salir" href="salir.php">Salir</a>
            </article>
            <article class="insproducto">
                <h3>Producto</h3>
                <form id="frmajax" class="formulario" method="post">
                    <input type="hidden" name="numeroVenta" id="numeroVenta" value="<?php echo $numeroVenta;?>">
                    <input type="number" name="cProduct" placeholder="Codigo de barras" id="cProduct" min="0" required>
                    <input type="number" name="cantPr" id="cantPr" placeholder="Cantidad" min="1" value="1">
                    <button id="btnguardar">Guardar</button>
                </form>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('#btnguardar').click(function(){
                            var datos=$('#frmajax').serialize();
                            $.ajax({
                                type: "POST",
                                url: "insertar.php",
                                data: datos,
                                success: function(r){
                                    if(r==1){
                                        alert("agregado con exito");
                                    }else{
                                        alert("Fallo");
                                    }
                                }
                            });
                            return false;
                        });
                    });
                </script>
            </article>
        </section>
        <section  class="previsualizacion">
            
            <article id="resultado">
                <!---codigo ajax-->
            </article>
            <!----
            <table class="tbl_venta">
                <thead>
                    <tr>
                        <th colspan="2"> Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Precio total</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody id="detalle_venta">

                <?php 
                        $vista=mysqli_query($mysqli,"CREATE VIEW PRODUCTO_CARRO (PRODUCTO, CANTIDAD, PRECIO , PRECIO_VENTA) AS SELECT a.NOMBRE_P, b.N_PR,  a.PRECIO_V , b.N_PR * a.PRECIO_V FROM PRODUCTO a, GENERIC_CARRO b WHERE a.C_BARRAS=b.C_BARRAS AND b.N_VENTA= $numeroVenta");
                        $query = mysqli_query($mysqli,"SELECT * FROM producto_carro ");
                        $result = mysqli_num_rows($query);

                        if($result==0 || $result>0){
                            while($data=mysqli_fetch_array($query)){
                            
                        ?>
                            <tr>
                                <td colspan="2"><?php echo $data["PRODUCTO"]; ?></td>
                                <td><?php echo $data["CANTIDAD"]; ?></td>
                                <td><?php echo $data["PRECIO"]; ?></td>
                                <td><?php echo $data["PRECIO_VENTA"]; ?></td>
                                <td class="">
                                    <a href="#" class="link_delete" onclick="event.preventDefault();
                                        del_product_detalle(1);">Borrar</a>
                                </td>
                            </tr>
                    <?php    

                            }
                        }
                ?>
                </tbody>
                <tfoot>
                    <?php 
                        $subtotal=0;
                        $total=0;
                        $iva=0;
                        $vista=mysqli_query($mysqli,"CREATE VIEW PRODUCTO_CARRO (PRODUCTO, CANTIDAD, PRECIO , PRECIO_VENTA) AS SELECT a.NOMBRE_P, b.N_PR,  a.PRECIO_V , b.N_PR * a.PRECIO_V FROM PRODUCTO a, GENERIC_CARRO b WHERE a.C_BARRAS=b.C_BARRAS AND b.N_VENTA= $numeroVenta");
                        $query = mysqli_query($mysqli,"SELECT PRECIO_VENTA FROM producto_carro ");
                        $result = mysqli_num_rows($query);

                        if($result>0){
                            while($data=mysqli_fetch_array($query)){
                                $subtotal=$subtotal + $data["PRECIO_VENTA"];
                            }
                        }
                        $iva=$subtotal*0.12;
                        $total=$subtotal +$iva;
                        
                        ?>
                    <tr>
                        <td colspan="4" class="textright">SUBTOTAL Q.</td>
                        <td class="textright"><?php echo "$subtotal"; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="textright">IVA (12%)</td>
                        <td class="textright"><?php echo "$iva"; ?></td>
                    </tr>

                    <tr>
                        <td colspan="4" class="textright">TOTAL Q.</td>
                        <td class="textright"><?php echo "$total"; ?></td>
                    </tr>
                </tfoot>
            </table>
            -->
            <!---Formulario de generacion venta---->
            <form class="formulario" action="" method="post">
                <input type="hidden" name="numVenta" value="<?php echo $numeroVenta; ?>">

                <input type="hidden" name="idVendedor" value="<?php echo $idEm; ?>">
                <input type="text" name="nombreCliente" id="nombreCliente" placeholder="Nombre cliente">
                    <?php
                        $query_cargo=mysqli_query($mysqli,"SELECT * FROM METODO_PAGO");
                        $result_cargo = mysqli_num_rows($query_cargo);
                    ?>
                    <label for="metodo">Metodo de pago:</label>
                    <select name="metodo" id="metodo">
                        <?php
                            if($result_cargo>0){
                                while($cargo=mysqli_fetch_array($query_cargo)){
                        ?>
                            <option value="<?php echo $cargo['ID_METODO'];?>"><?php echo $cargo['METODO']?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <?php
                        $query_cargo=mysqli_query($mysqli,"SELECT * FROM TIPO_VENTA");
                        $result_cargo = mysqli_num_rows($query_cargo);
                    ?>
                    <label for="tipo">Tipo de venta:</label>
                    <select name="tipo" id="tipo">
                        <?php
                            if($result_cargo>0){
                                while($cargo=mysqli_fetch_array($query_cargo)){
                        ?>
                            <option value="<?php echo $cargo['ID_TIPO_VENTA'];?>"><?php echo $cargo['TIPOVENTA']?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <input class="genera_venta" type="submit" value="Procesar">
            </form>
        </section>
    </div>
</body>
</html>