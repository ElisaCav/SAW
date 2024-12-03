
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light mx-3">
  <a class="navbar-brand image-container" href="home.php">
  		<span>
			<img src="../images/logo2.png" alt="Genova Gatherings" class="custom-logo">
		</span>
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
		<ul id="navbar-ul" class="navbar-nav ml-auto nav-fill w-100"> <!--data-toglle="collapse" data-target=".navbar-collapse.show"-->
			<li class="nav-item">
				<a class="nav-link" href="home.php">Home</a></li>
			<li class="nav-item">
				<a class="nav-link" href="show_locations.php">Spazi</a></li>
			<li class="nav-item">
				<a class="nav-link" href="about.php">Chi siamo</a></li>			
	<?php
	 
		require_once "../php/dbconnections.php";
		require_once "../db/mysql_credentials.php";
		if(!isAuthenticated($con)){  
	?>			
			<li class="nav-item">
				<a class="nav-link" href="registration_form.php">Registrati</a></li>
			<li class="nav-item">
				<a class="nav-link" href="login_form.php">Login</a>
			</li>	
	<?php
		}else{    
	?>			
			<li class="nav-item">
				<a class="nav-link" href="show_profile.php">Account</a></li>
			<li class="nav-item"> 
				<a class="nav-link" href="show_booking_history.php">Archivio</a></li>
			<li class="nav-item"> 
				<a class="nav-link" href="logout.php">Logout</a></li>			
		<?php			
			}	
		?>	
			<li class="nav-item">
				<a class="nav-link" href="show_cart.php" aria-label="Il tuo carrello" data-bs-toggle="tooltip" data-bs-placement="top" title="Il tuo carrello">
					<i class="fa fa-shopping-cart fa-2x" style="color:#041122;"></i>
				</a>
			</li>
		</ul>
		<form id="searchForm" name="searchForm" class="form-inline" method="post" action="search.php">
			<input class="form-control mr-sm-2" id="searchInput" name="searchInput" type="text" placeholder="Cerca..."></input>
		</form>	
	</div>
</nav>


	

