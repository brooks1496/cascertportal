<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<link rel="stylesheet" href="css/index.css">
<html>
<head>
	<?php 
	include('/scripts/scripts.html');
	?>
	<title>Index</title>
</head>
<body>

	<div class="container" id="form-container">
			<form method="post" action='skulist.php'>
				<img src="site images/cassellie.png">
				<input type="text" class="form-control" name="Username" id="Username" placeholder="Please Enter Your Cassellie Login">
				<input type="Password" class="form-control" name="Password" id="Password" placeholder="Please Enter Your Password">
				<button class="btn btn-secondary"  type="Submit" name="">Submit</button>
			</form>
	</div>

</body>
</html>