<?php session_start();
include 'db_connect.php';
if(isset($_SESSION['usuarioAdminRh'])){ $usernameSesion = $_SESSION['usuarioAdminRh']; }else if(isset($_SESSION['usuarioJefe'])){ $usernameSesion = $_SESSION['usuarioJefe']; }else if(isset($_SESSION['usuarioDatos'])){ $usernameSesion = $_SESSION['usuarioDatos'];}

$sql = $conexion->query("SELECT Empleado from plantillahraei where correo = '$usernameSesion'");
	$row = mysqli_fetch_assoc($sql);
$id_empleado = $row['Empleado'];
$qry = $conn->query("SELECT * FROM files where id=".$_GET['id'])->fetch_array();

extract($_POST);

 		$fname=$qry['file_path'];   
       $file = ('uploads/'.$id_empleado.'/'.$fname);
       
       header ("Content-Type: ".filetype($file));
       header ("Content-Length: ".filesize($file));
       header ("Content-Disposition: attachment; filename=".$qry['name'].'.'.$qry['file_type']);

       readfile($file);