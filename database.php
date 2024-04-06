<?php 

$name = $_POST['name']
$email = $_POST['email']
$blog_name = $_POST['blog_name']
$experience = $_POST['experience']

if (!empty($name) || !empty($email) || !empty($blog_name) || !empty($experience)) {
$host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "a3p2";   

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT email From data_table Where email = ? Limit 1";
     $INSERT = "INSERT Into data_table (name, email, blog_name, experience) values(?, ?, ?, ?)";
     //Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("ssss", $name, $email, $blog_name, $experience);
      $stmt->execute();
      echo "New record inserted sucessfully";
     } else {
      echo "Someone already register using this email";
     }
     $stmt->close();
     $conn->close();
} else {
    echo "All fields required";
    die();
}
?>