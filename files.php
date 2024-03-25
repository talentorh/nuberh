
<?php 
include 'header.php';
include 'db_connect.php';
if(isset($_SESSION['usuarioAdminRh'])){ $usernameSesion = $_SESSION['usuarioAdminRh']; }else if(isset($_SESSION['usuarioDatos'])){ $usernameSesion = $_SESSION['usuarioDatos']; }
	
$sql = $conexion->query("SELECT Empleado from plantillahraei where correo = '$usernameSesion'");
	$row = mysqli_fetch_assoc($sql);
$id_empleado = $row['Empleado'];
$folder_parent = isset($_GET['fid'])? $_GET['fid'] : 0;
$folders = $conn->query("SELECT * FROM folders where parent_id = $folder_parent and user_id = $id_empleado  order by name asc");


$files = $conn->query("SELECT * FROM files where folder_id = $folder_parent and user_id = $id_empleado order by name asc");

?>
<style>
	.folder-item{
		cursor: pointer;
	}
	.folder-item:hover{
		background: #eaeaea;
	    color: black;
	    box-shadow: 3px 3px #0000000f;
	}
	.custom-menu {
        z-index: 1000;
	    position: absolute;
	    background-color: #ffffff;
	    border: 1px solid #0000001c;
	    border-radius: 5px;
	    padding: 8px;
	    min-width: 13vw;
}
a.custom-menu-list {
    width: 100%;
    display: flex;
    color: #4c4b4b;
    font-weight: 600;
    font-size: 1em;
    padding: 1px 11px;
}
.file-item{
	cursor: pointer;
}
a.custom-menu-list:hover,.file-item:hover,.file-item.active {
    background: #80808024;
}
table th,td{
	border-left:1px solid gray;
}
a.custom-menu-list span.icon{
		width:1em;
		margin-right: 5px
}
.container-fluid {
	padding: 0px;
	
}
body {
	background-color: #F8FEFF;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<div class="container-fluid">
	<div class="col-lg-12" >
		<div class="row" >
			<div class="card col-lg-12" style="height: auto; padding: 0px; margin-top: 0px; background-color: #ffffff; color: black;">
				<div class="card-body" id="paths" style="color: black;">
				<a href="index?page=files" class="">..</a>
				<?php 
				$id=$folder_parent;
				while($id > 0){

					$path = $conn->query("SELECT * FROM folders where id = $id  order by name asc")->fetch_array();
					echo '<script>
						$("#paths").prepend("<a href=\"index?page=files&fid='.$path['id'].'\">'.$path['name'].'</a>/")
					</script>';
					$id = $path['parent_id'];

				}
				echo '<script>
						$("#paths").prepend("<a href=\"index?page=files\">..</a>/")
					</script>';
				?>
					
				</div>
			</div>
		</div>

		<div class="row" style="margin-top: 10px;">
			<button class="btn btn-success btn-sm" id="new_folder"><i class="fa fa-plus"></i> Nueva carpeta</button>
			<button class="btn btn-warning btn-sm ml-4" id="new_file"><i class="fa fa-upload"></i> Subir archivo</button>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-12">
			<div class="col-md-4 input-group offset-4">
			<div class="input-group-append">
   					 <span class="input-group-text" id="inputGroup-sizing-sm" style="background-color: #ffffff;"><i class="fa fa-search"></i></span>
  				</div>
  				<input type="text" class="form-control" id="search" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
  				
			</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12"><h4><b>Carpetas</b></h4></div>
		</div>
		<hr>
		<div class="row">
			<?php 
			while($row=$folders->fetch_assoc()):
			?>
				<div class="card col-md-3 mt-2 ml-2 mr-2 mb-2 folder-item" data-id="<?php echo $row['id'] ?>">
					<div class="card-body">
							<large><span><i class="fa fa-folder"></i></span><b class="to_folder"> <?php echo $row['name'] ?></b></large>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
		<hr>
		<style>
		
		</style>
		<div class="row">
			<div class="card col-md-12" style="padding: 0px; font-size: 15px;">
				<div class="card-body">
					<table id="example" class="table table-striped table-bordered table-darkgray table-hover">
						<thead>
						<tr>
							<th>Nombre del archivo</th>
							<th>Fecha de carga</th>
							<th>Descripción</th>
							<th>Ver</th>
							<th>Eliminar</th>
						</tr>
						</thead>
						<?php 
					while($row=$files->fetch_assoc()):
						$name = explode(' ||',$row['name']);
						$name = isset($name[1]) ? $name[0] ." (".$name[1].").".$row['file_type'] : $name[0] .".".$row['file_type'];
						$img_arr = array('png','jpg','jpeg','gif','psd','tif');
						$doc_arr =array('doc','docx');
						$pdf_arr =array('pdf','ps','eps','prn');
						$icon ='fa-file';
						if(in_array(strtolower($row['file_type']),['png','jpg','jpeg','gif','psd','tif']))
							$icon ='fa-image';
						if(in_array(strtolower($row['file_type']),$doc_arr))
							$icon ='fa-file-word';
						if(in_array(strtolower($row['file_type']),$pdf_arr))
							$icon ='fa-file-pdf';
						if(in_array(strtolower($row['file_type']),['xlsx','xls','xlsm','xlsb','xltm','xlt','xla','xlr','csv']))
							$icon ='fa-file-excel';
						if(in_array(strtolower($row['file_type']),['zip','rar','tar']))
							$icon ='fa-file-archive';
							
						
					?>
					
						<tr class='//file-item' data-id="<?php echo $row['id'] ?>" data-name="<?php echo $name ?>">
							<td><large><span><i class="fa <?php echo $icon ?>"></i></span><b class="to_file"></b> <?php echo $name ?></large>
							<input type="text" class="rename_file" value="<?php echo $row['name'] ?>" data-id="<?php echo $row['id'] ?>" data-type="<?php echo $row['file_type'] ?>" style="display: none">

							</td>
							<td><i class="to_file"><?php echo date('Y/m/d h:i A',strtotime($row['date_updated'])) ?></i></td>
							<td><i class="to_file"><?php echo $row['description'] ?></i></td>
							<td><a href="#" class="verydescargar" data-descr="<?php echo $row['id'] ?>" style="font-size: 15px; color: green; background: none; border: none;"><i class="fa fa-eye"></i> Ver y Descargar</a></td>
							<!--<td><button type="button" value='<?php echo  $row['id'] ?>' style="font-size: 15px; color: green; background: none; border: none;"><i class="fa fa-download"></i>Descargar</button></td>-->
							<td><a href="#" class="eliminar" data-descr="<?php echo $row['id'] ?>" style="font-size: 15px; color: red; background: none; border: none;"><i class="fa fa-trash"></i> Eliminar</a></td>
						</tr>
					
					<?php endwhile; ?>
					
					</table>
					<script>
        new DataTable('#example', {
            initComplete: function() {
                this.api()
                    .columns()
                    .every(function() {
                        let column = this;
                        let title = column.footer().textContent;

                        // Create input element
                        let input = document.createElement('input');
                        input.placeholder = title;
                        column.footer().replaceChildren(input);

                        // Event listener for user input
                        input.addEventListener('keyup', () => {
                            if (column.search() !== this.value) {
                                column.search(input.value).draw();
                            }
							
                        });
						
                    });
            }
        });
        $('#example tfoot tr').appendTo('#example thead');
		var table = new DataTable('#example', {
    language: {
        url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
    },
});
        </script>
		<script type="text/javascript">
    /*$("button").click(function() {
        var id = $(this).val(); 
        let ob = {
            id: id
        };
		
		window.open('download.php?id='+$(this).val());*/
            /*$.ajax({
                data: ob,
                url: '',
                method: 'POST',
                beforeSend: function() {

                },
                success: function(response) {
                    //$("#tabla_resultado").html(response);
                    //$("#tabla_resultado").load('consultaCarga.php');
                }
            });*/
        
    //});
	$(document).on('click', '.verydescargar', function () {

var descr = $(this).attr('data-descr');
$('#exampleModal input[name=identificador]').val(descr);
let ob = {descr:descr}
$.ajax({
                url: 'consultaArchivo.php',
                type: 'POST',
				data: ob,
                dataType: 'html',
            })

            .done(function(resultado) {
                $("#tabla_resultado").html(resultado);
            })
// aquí es cuando tienes que mirar la documentación de tu framework
$('#exampleModal').modal('show'); // o similar

});

$(document).on('click', '.eliminar', function () {

var descr = $(this).attr('data-descr');
$('#exampleModal input[name=identificador]').val(descr);

var mensaje = confirm("el registro se eliminara")
        let ob = {
            descr: descr
        };
		if (mensaje == true) {
$.ajax({
                url: 'eliminarDocumento.php',
                type: 'POST',
				data: ob,
                dataType: 'html',
            })

            .done(function(resultado) {
                $("#tabla_mensaje").html(resultado);
				setTimeout(function() {
                                window.location.reload();
                            }, 2000);
            })
		} else {
            Swal.fire({
            position: 'top-end',
            icon: 'warning',
            title: 'Acción cancelada',
            showConfirmButton: false,
            timer: 1500
        })
        }
// aquí es cuando tienes que mirar la documentación de tu framework
//$('#exampleModal').modal('show'); // o similar

});
</script>
    </div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<div id="tabla_mensaje"></div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #F8FEFF;">
        <h5 class="modal-title" id="exampleModalLabel">Documento</h5>
      </div>
      <div class="modal-body">
	  <input type="hidden" name="identificador" id="identificador" value="" placeholder="Cédula">
	  
			<div id="tabla_resultado"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
        <!--<a href="<?php echo "uploads/1983/$nameFile" ?>" class="btn btn-primary" target='_blank'>Descargar</a>-->
		<?php 
	
	?>
      </div>
    </div>
  </div>
</div>
<div id="menu-folder-clone" style="display: none;">
	<a href="javascript:void(0)" class="custom-menu-list file-option edit">Renombrar</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option delete">Elimnar</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option delete">Comprimir y descargar</a>
</div>
<div id="menu-file-clone" style="display: none;">
	<a href="javascript:void(0)" class="custom-menu-list file-option edit"><span><i class="fa fa-edit"></i> </span>Renombrar</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option download"><span><i class="fa fa-download"></i> </span>Descargar</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option delete"><span><i class="fa fa-trash"></i> </span>Elimnar</a>
</div>

<script>
	
	$('#new_folder').click(function(){
		uni_modal('','manage_folder.php?fid=<?php echo $folder_parent ?>')
	})
	$('#new_file').click(function(){
		uni_modal('','manage_files.php?fid=<?php echo $folder_parent ?>')
	})
	$('.folder-item').dblclick(function(){
		location.href = 'index.php?page=files&fid='+$(this).attr('data-id')
	})
	$('.folder-item').bind("contextmenu", function(event) { 
    event.preventDefault();
    $("div.custom-menu").hide();
    var custom =$("<div class='custom-menu'></div>")
        custom.append($('#menu-folder-clone').html())
        custom.find('.edit').attr('data-id',$(this).attr('data-id'))
        custom.find('.delete').attr('data-id',$(this).attr('data-id'))
    custom.appendTo("body")
	custom.css({top: event.pageY + "px", left: event.pageX + "px"});

	$("div.custom-menu .edit").click(function(e){
		e.preventDefault()
		uni_modal('Rename Folder','manage_folder.php?fid=<?php echo $folder_parent ?>&id='+$(this).attr('data-id') )
	})
	$("div.custom-menu .delete").click(function(e){
		e.preventDefault()
		_conf("Are you sure to delete this Folder?",'delete_folder',[$(this).attr('data-id')])
	})
})

	//FILE
	$('.file-item').bind("contextmenu", function(event) { 
    event.preventDefault();

    $('.file-item').removeClass('active')
    $(this).addClass('active')
    $("div.custom-menu").hide();
    var custom =$("<div class='custom-menu file'></div>")
        custom.append($('#menu-file-clone').html())
        custom.find('.edit').attr('data-id',$(this).attr('data-id'))
        custom.find('.delete').attr('data-id',$(this).attr('data-id'))
        custom.find('.download').attr('data-id',$(this).attr('data-id'))
    custom.appendTo("body")
	custom.css({top: event.pageY + "px", left: event.pageX + "px"});

	$("div.file.custom-menu .edit").click(function(e){
		e.preventDefault()
		$('.rename_file[data-id="'+$(this).attr('data-id')+'"]').siblings('large').hide();
		$('.rename_file[data-id="'+$(this).attr('data-id')+'"]').show();
	})
	$("div.file.custom-menu .delete").click(function(e){
		e.preventDefault()
		_conf("Are you sure to delete this file?",'delete_file',[$(this).attr('data-id')])
	})
	$("div.file.custom-menu .download").click(function(e){
		e.preventDefault()
		window.open('download.php?id='+$(this).attr('data-id'))
	})

	$('.rename_file').keypress(function(e){
		var _this = $(this)
		if(e.which == 13){
			start_load()
			$.ajax({
				url:'ajax.php?action=file_rename',
				method:'POST',
				data:{id:$(this).attr('data-id'),name:$(this).val(),type:$(this).attr('data-type'),folder_id:'<?php echo $folder_parent ?>'},
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp);
						if(resp.status== 1){
								_this.siblings('large').find('b').html(resp.new_name);
								end_load();
								_this.hide()
								_this.siblings('large').show()
						}
					}
				}
			})
		}
	})

})
//FILE


	$('.file-item').click(function(){
		if($(this).find('input.rename_file').is(':visible') == true)
    	return false;
		uni_modal($(this).attr('data-name'),'manage_files.php?<?php echo $folder_parent ?>&id='+$(this).attr('data-id'))
	})
	$(document).bind("click", function(event) {
    $("div.custom-menu").hide();
    $('#file-item').removeClass('active')

});
	$(document).keyup(function(e){

    if(e.keyCode === 27){
        $("div.custom-menu").hide();
    $('#file-item').removeClass('active')

    }

});
	$(document).ready(function(){
		$('#search').keyup(function(){
			var _f = $(this).val().toLowerCase()
			$('.to_folder').each(function(){
				var val  = $(this).text().toLowerCase()
				if(val.includes(_f))
					$(this).closest('.card').toggle(true);
					else
					$(this).closest('.card').toggle(false);

				
			})
			$('.to_file').each(function(){
				var val  = $(this).text().toLowerCase()
				if(val.includes(_f))
					$(this).closest('tr').toggle(true);
					else
					$(this).closest('tr').toggle(false);

				
			})
		})
	})
	function delete_folder($id){
		start_load();
		$.ajax({
			url:'ajax.php?action=delete_folder',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp == 1){
					alert_toast("Folder successfully deleted.",'success')
						setTimeout(function(){
							location.reload()
						},1500)
				}
			}
		})
	}
	function delete_file($id){
		start_load();
		$.ajax({
			url:'ajax.php?action=delete_file',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp == 1){
					alert_toast("Folder successfully deleted.",'success')
						setTimeout(function(){
							location.reload()
						},1500)
				}
			}
		})
	}

</script>