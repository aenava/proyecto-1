<?php
    session_start();

    if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2){
        header("location: ./");
    }

    include "../conexion.php";

    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['codigo']) || empty($_POST['proveedor']) || empty($_POST['producto']) || empty($_POST['precio']) || $_POST['precio'] <= 0 
        || empty($_POST['cantidad']) || $_POST['cantidad'] <= 0){
            $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{
            $codigo = $_POST['codigo'];
            $proveedor = $_POST['proveedor'];
            $producto = $_POST['producto'];
            $precio = $_POST['precio'];
            $cantidad = $_POST['cantidad'];
            $usuario_id = $_SESSION['idUser'];

            $query_insert = mysqli_query($conection,"INSERT INTO producto(codigo,proveedor,descripcion,precio,existencia,usuario_id)
                                        VALUES('$codigo','$proveedor','$producto','$precio','$cantidad','$usuario_id')");

            if($query_insert){
                $alert='<p class="msg_save">Producto guardado correctamente.</p>';
            }else{
                $alert='<p class="msg_error">Error al guardar producto.</p>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
    <title>Registro Producto</title>
    
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="form_register">
            <h1>Registro Producto</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post" enctype="multipart/form-data">
                <label for="codigo">Codigo</label>
                <input type="text" name="codigo" id="codigo" placeholder="Codigo">
                <label for="proveedor">Proveedor</label>
                <?php
                    $query_proveedor = mysqli_query($conection,"SELECT codproveedor, proveedor FROM proveedor 
                                                                WHERE estatus = 1 ORDER BY proveedor ASC");
                    $result_proveedor = mysqli_num_rows($query_proveedor);
                    mysqli_close($conection);
                ?>
                <select name="proveedor" id="proveedor">
                <?php
                    if($result_proveedor > 0){
                        while($proveedor = mysqli_fetch_array($query_proveedor)){
                ?>
                    <option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
                <?php
                        }
                    }
                ?>
                </select>
                <label for="producto">Producto</label>
                <input type="text" name="producto" id="producto" placeholder="Nombre del producto">
                <label for="precio">Precio</label>
                <input type="number" name="precio" id="precio" placeholder="Precio del producto">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad del producto">
                <!--<div class="photo">
	                <label for="foto">Foto</label>
                    <div class="prevPhoto">
                        <span class="delPhoto notBlock">X</span>
                        <label for="foto"></label>
                    </div>
                    <div class="upimg">
                    <input type="file" name="foto" id="foto">
                    </div>
                    <div id="form_alert"></div>
                </div>-->
                <button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar Producto</button>
            </form>
        </div>
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>