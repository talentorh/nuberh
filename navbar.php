<style>
	#menu:hover {
		background-color: #27566E;
		color: white;
	}
</style>

<nav id="sidebar" class='mx-lt-5' style="margin-top: 7px; background-color: white;">
		
		<div class="sidebar-list">
				<a href="../sitiorecursoshumanos/principalRh" class="nav-item nav-home" id="menu"><span class='icon-field'><i class="fa fa-home"></i></span>&nbsp;Home</a>
		
		
				<a href="index.php?page=files" class="nav-item nav-files" id="menu"><span class='icon-field'><i class="fa fa-file"></i></span>&nbsp; Inicio</a>
	
		
				<?php if(isset($_SESSION['usuarioAdminRh'])): ?>
				<!--<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>-->
				
				<a href="../sitiorecursoshumanos/close_sesion" class="nav-item nav-files" id="menu" style="bottom:0px;position:relative;"><span class='icon-field'><i class="fa fa-power-off"></i></span>&nbsp;Cerrar sesión</a>
				<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>