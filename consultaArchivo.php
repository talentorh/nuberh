<?php
	  require 'db_connect.php';
      $id = $_POST['descr'];
    clearstatcache();
	$sql = $conn->query("SELECT file_path,user_id from files where id = $id");
		$row = mysqli_fetch_assoc($sql);
	$nameFile = $row['file_path'];
	$userid = $row['user_id'];
    $path = 'uploads/'.$userid.'/'.$nameFile;
    if (file_exists($path)) {
        //$directorio = opendir($path);
        //$archivo = readdir($directorio);
            if (!is_dir($path)) {
                echo "<div data='" . $path . "/" . $nameFile . "'><a href='" . $path . "/" . $nameFile . "' ></a></div><br>";

                echo "<iframe src='uploads/$userid/$nameFile' class='form-control' style='height: 500px;'></iframe>";
                //echo "<a href='uploads/1983/$nameFile' target='_blank'> <i title='Ver Archivo Adjunto' id='guardar'class='fas fa-file-pdf'></i></a>";
            }
    }
    ?>