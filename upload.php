<?php
require_once('PHPMailer/class.phpmailer.php');

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "legistify";
$var_value = $_GET['varname'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection


$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);


// Check file size
if ($_FILES["fileToUpload"]["size"] > 3000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow only docx file format
if($FileType != "docx") {
    echo "Sorry, docx files are only allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

        $email = new PHPMailer();
		$email->From      = 'hjcooljohny75@gmail.com';
		$email->FromName  = 'hemant';
		$email->Subject   = 'hello';
		$email->Body      = $_POST["message"];
		$email->AddAddress( 'hjcooljohny75@gmail.com' );
		$email->AddAttachment( $target_file, $target_dir );
		if($email->Send())
		{
			echo "File sent";
		}	
			

		
		else
		{
			echo "Error! file not sent ";
		}	
		if ($conn->connect_error) {
    			die("Connection failed: " . $conn->connect_error);
			} 
			$sql = "DELETE From queries where id =". $var_value;
			$result = $conn->query($sql);
			header("Location:index.php");


    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>