<?php

    include("ConexionDB.php");

    session_start();
    if(empty($_SESSION['active'])){
        header('location: loginVenta.php');
    }
    $vista=mysqli_query($mysqli,"CREATE VIEW PRODUCTO_CARRO (PRODUCTO, CANTIDAD, PRECIO , PRECIO_VENTA) AS SELECT a.NOMBRE_P, b.N_PR,  a.PRECIO_V , b.N_PR * a.PRECIO_V FROM PRODUCTO a, GENERIC_CARRO b WHERE a.C_BARRAS=b.C_BARRAS AND b.N_VENTA= $numeroVenta");

echo '<table class="tbl_venta">
        <thead>
            <tr>
                <th colspan="2"> Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Precio total</th>
                <th>Accion</th>
            </tr>
        </thead>
        ';
        echo '<tbody id="detalle_venta">';


            
                $query = mysqli_query($mysqli,"SELECT * FROM producto_carro ");
                $result = mysqli_num_rows($query);

                while($data=mysqli_fetch_array($query)){
                    echo '<tr>
                        <td colspan="2">'.$data["PRODUCTO"].'</td>
                        <td>'.$data["CANTIDAD"].'</td>
                        <td>'.$data["PRECIO"].'</td>
                        <td>'.$data["PRECIO_VENTA"].'</td>
                        <td class="">
                            <a href="#" class="link_delete" onclick="event.preventDefault();
                                        del_product_detalle(1);">Borrar</a>
                        </td>
                    </tr>';
               

                }
                
        echo '</tbody>
        <tfoot>';
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
                        
            echo '<tr>
                <td colspan="4" class="textright">SUBTOTAL Q.</td>
                <td class="textright">'.$subtotal.'</td>
            </tr>
            <tr>
                <td colspan="4" class="textright">IVA (12%)</td>
                <td class="textright">'.$iva.'</td>
            </tr>

            <tr>
                <td colspan="4" class="textright">TOTAL Q.</td>
                <td class="textright">'.$total.'</td>
            </tr>
            </tfoot>
    </table>';

?>