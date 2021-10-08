<?php
	include_once('header.php');
?>
	<div class="container">
		<br>
		<br>
		<h2 class="text-center">Shorten URL</h2>
		<div class="row justify-content-center mt-5">
			<div class="form-shorten w-50">
				<?php
		            if(isset($_SESSION['error'])){
		        ?>
		        <div class="alert alert-danger alert-dismissible">
		            <strong><?php echo $_SESSION['msg']; ?></strong>
		            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		        </div>

		        <?php
		    		}
		            if(isset($_SESSION['success'])){
		        ?>
		        <div class="alert alert-success alert-dismissible">
				  	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				  	<strong>Success!</strong> <?php echo $_SESSION['msg']?>
				</div>
		        <?php
		        	}
		        	unset($_SESSION["success"]);
		        	unset($_SESSION["error"]);
		        	unset($_SESSION["msg"]);
		        ?>
				<form method="post" action="middle.php">
					<div class="form-group">
						<input type="text" name="original_url" class="form-control" placeholder="Please enter the url here" required>
					</div>
					<div class="form-group">
						<input type="submit" name="to_shorten" class="btn btn-primary d-block m-auto">
					</div>
				</form>
			</div>
		</div>
		<br>
		<br>
		<div class="table-content">
			<h3 class="text-center mb-5">Often accessed URLs</h3>
			<table class="table table-bordered">
			    <thead>
			      <tr>
			        <th>Origin URL</th>
			        <th>Shorten Code</th>
			        <th>Access count</th>
			      </tr>
			    </thead>
			    <tbody>
			      <?php echo $crud->getTopUsedUrl();?>
			    </tbody>
		  </table>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>