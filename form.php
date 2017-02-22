<?php 
	if($_POST)
	{
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
		        echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}

		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
	
		$conn = mysqli_connect('localhost', 'root', '', 'phpprog');
	   if(! $conn )
	   {
	     die('Could not connect: ' . mysql_error());
	   }
	   $sql = "INSERT INTO form_detail".
	   			" (name, email, comment, path)". 
	   			" VALUES ('"
	   			.$_POST['yourname']."', '".$_POST['email']."', '".$_POST['comments']."','". $target_file."')";

		if ($conn->query($sql) === TRUE) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();
			}

?>
<html>
<body>

<form action="" method="post" enctype="multipart/form-data">
<p>Your Name: <input type="text" name="yourname" /><br />
E-mail: <input type="text" name="email" /></p>

<p>Do you like this website?
<input type="radio" name="likeit" value="Yes" checked="checked" /> Yes
<input type="radio" name="likeit" value="No" /> No
<input type="radio" name="likeit" value="Not sure" /> Not sure</p>

<p>Your comments:<br />
<textarea name="comments" rows="10" cols="40"></textarea></p>

Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">

<p><input type="submit" value="Send it!"></p>
</form>
<?php 
	$conn = mysqli_connect('localhost', 'root', '', 'phpprog');
	   if(! $conn )
	   {
	     die('Could not connect: ' . mysql_error());
	   }
	   $sql ='SELECT *
        FROM form_detail';


$result = $conn->query($sql);
if(! $result )
{
  die('Could not get data: ' . mysql_error());
}
else{if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	if(isset($row['yourname']))
    	{
    		$name = $row['yourname'];
    	}
        echo "id: " . $row["id"]. " - Name: " . $name. " " . $row["email"]. " " . $row["comment"]. " " . $row["path"]. " " ."<br>";
    }
} else {
    echo "0 results";
}}
?>
</body>
</html>