<?php 
	   $conn = mysqli_connect('localhost', 'root','');
	   if(! $conn )
	   {
	     die('Could not connect: ' . mysql_error());
	   }
	   $query = 'CREATE DATABASE IF NOT EXISTS myphpform;';
	   $conn->query($query);
	   $conn->close();
	   $query1='CREATE TABLE IF NOT EXISTS formdetail (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		firstname VARCHAR(30) NOT NULL,
		lastname VARCHAR(30) NOT NULL,
		email VARCHAR(50),
		profilepic VARCHAR(30),
		state VARCHAR(30),
		city VARCHAR(30),
		dob VARCHAR(30)
		);';
		$conn = mysqli_connect('localhost', 'root','','myphpform');
	   if(! $conn )
	   {
	     die('Could not connect: ' . mysql_error());
	   }
		$conn->query($query1);
		$conn->close();

		/* delete code start */
		if (isset($_POST['delete'])) {

			$conn = mysqli_connect('localhost', 'root','','myphpform');
		   if(! $conn )
		   {
		     die('Could not connect: ' . mysql_error());
		   }
		   $delete = "DELETE FROM formdetail WHERE id=".$_POST['deleteId'];

			if ($conn->query($delete) === TRUE) {
			    echo "Record deleted successfully";
			} else {
			    echo "Error deleting record: " . $conn->error;
			}
			$conn->close();
		/*delete code end*/
		}

	/* data insert code start */
	if(isset($_POST['submit']))
	{
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
		        //echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}

		$conn = mysqli_connect('localhost', 'root', '','myphpform');
	   if(! $conn )
	   {
	     die('Could not connect: ' . mysql_error());
	   }
	   $sql = "INSERT INTO formdetail".
	   			" (firstname, lastname, email, profilepic,state,city,dob)". 
	   			" VALUES ('"
	   			.$_POST['firstname']."', '".$_POST['lastname']."', '".$_POST['email']."','".$_FILES["fileToUpload"]["name"]."', '".$_POST['state']."', '".$_POST['city']."', '".$_POST['dob']."')";
			
		/*validation of form*/
		if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']))
		{
			if(ctype_alpha($_POST['firstname']) && ctype_alpha($_POST['lastname']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			{
				$conn->query($sql);
		    	echo "New record created successfully";
		    	$conn->close();
		    }
		    else
		    {
		    	echo 'first name and last name must be alphabetic and email should be correct';
		    }
		}
		else
		{
			echo 'Fill All The Fields First';
		}
		/*validation of form end*/
	}
	/* data insert code end */
?>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
</head>
<body>
<!-- form data input start -->
	<div class="container">
		<form method="post" name="formdata" action="" enctype="multipart/form-data">
			<div class="form-group">
				<label>First Name</label>
				<input type="text" name="firstname" placeholder="enter first name" pattern="[a-zA-Z]{3,}" title="only alphabets" required />
			</div>
			<div class="form-group">
				<label>Last Name</label>
				<input type="text" name="lastname" placeholder="enter last name" pattern="[a-zA-Z]{2,}" title="only alphabets" required />
			</div>
			<div class="form-group">
				<label>Email</label>
				<input type="email" name="email" placeholder="enter email" />
			</div>

			<div class="form-group">
				<label>Select Profile picture</label>
				<input type="file" name="fileToUpload" id="fileToUpload" />
			</div>
			<div class="form-group">
				<label>State</label>
				<input type="text" name="state" placeholder="enter state" required />
			</div>
			<div class="form-group">
				<label>City</label>
				<input type="text" name="city" placeholder="enter city" required />
			</div>
			<div class="form-group">
				<label>Date Of Birth</label>
				<input type="date" name="dob" placeholder="select date" id="datepicker" />
			</div>
			<div class="form-group">
				<p>Do you like this website?
					<input type="radio" name="likeit" value="Yes" checked="checked" /> Yes
					<input type="radio" name="likeit" value="No" /> No
					<input type="radio" name="likeit" value="Not sure" /> Not sure
				</p>
			</div>
			<input type="submit" value="submit" name="submit" class="btn" />
		</form>
	</div>
<!-- input forn end -->
<!-- *************************************************************************************************************************** -->
<!-- display data start -->
 	<div class="form-group">
 	<form method="post" action="" name="showform">
	<label>Display all data</label>
	<input type="submit" name="show" value="show data" class="btn"s/>
	</form> 
	<table class="table table-striped">
		<?php 

		if(isset($_POST['show']))
		{
			?>
				<tr>
				<th>id</th>
				<th>firstname</th>
				<th>lastname</th>
				<th>email</th>
				<th>profile picture</th>
				<th>date of birth</th>
				<th>state</th>
				<th>city</th>
				<th>delete user</th>
			</tr>
			<?php
			$conn = mysqli_connect('localhost', 'root', '', 'myphpform');
			   if(! $conn )
			   {
			     die('Could not connect: ' . mysql_error());
			   }
			   $sql ='SELECT *
		        FROM formdetail';


			$result = $conn->query($sql);
			if(! $result )
			{
			  die('Could not get data: ' . mysql_error());
			}
			else{if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			    	if(isset($row['firstname']))
			    	{
			    		$name = $row['firstname'];
			    	}
			        //echo "id: " . $row["id"]. " - Name: " . $name. " " . $row["email"]. " " . $row["comment"]. " " . $row["path"]. " " ."<br>";
			    	//var_dump($row);
			    	?>
			    	<tr>
			    		<td><?php echo $row['id']; ?></td>
			    		<td><?php echo $row['firstname']; ?></td>
			    		<td><?php echo $row['lastname']; ?></td>
			    		<td><?php echo $row['email']; ?></td>
			    		<td><img src="uploads/<?php echo $row['profilepic']; ?>" width="50px" alt = "<?php echo $row['profilepic'];?>"/></td>
			    		<td><?php echo $row['dob']; ?></td>
			    		<td><?php echo $row['state']; ?></td>
			    		<td><?php echo $row['city']; ?></td>
			    		<td>
			    			<form action="" method="post" name="deletedata">
				    			<input type="hidden" name="deleteId" value="<?php echo $row['id']; ?>" />
				    			<input type="submit" name="delete" value="delete" class="btn">
			    			</form>
			    		</td>
			    	</tr>
			    	<?php

			    }
			} else {
			    echo "0 results";
			}}
		}
		?>	
		 
	</table>	
 	</div>
 <!-- display data end -->
</body>
</html>