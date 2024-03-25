<?php
require 'db_connect.php';
$id = $_POST['descr'];
$sql = $conn->query("SELECT file_path,user_id from files where id = $id");
		$row = mysqli_fetch_assoc($sql);
	$nameFile = $row['file_path'];
	$userid = $row['user_id'];
    $path = 'uploads/'.$userid.'/'.$nameFile;
    
            unlink($path);   
    $sql = $conn->query("DELETE from files where id = $id");

    if($sql != false){
    echo "<script> Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Registro eliminado',
        showConfirmButton: false,
        timer: 1500
    })</script>";
    }
?>