<?php
session_start();
require "config.php";

$first_name = $_POST['first_name'] ?? null;
$last_name = $_POST['last_name'] ?? null;
$email = $_POST['email'] ?? null;
$image = $_FILES['image'] ?? null;
$plainTextPassowrd = $_POST['password'] ?? null;

$hashedPassword = password_hash($plainTextPassowrd, PASSWORD_DEFAULT);

$query = 'INSERT INTO users(first_name, last_name, email, password, user_image) VALUES ($1, $2, $3, $4, $5)';
$select_email = "SELECT * FROM users WHERE email = $1";
$stmt = pg_prepare($conn, "select_email", $select_email);
$result = pg_execute($conn, "select_email", [$email]);

// Validate inputs
if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($plainTextPassowrd) && isset($image)){

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo("Error: Invalid email format.");
    }else if ($result && pg_num_rows($result)> 0){
        echo("email already exists");
    }

    // the line below is for handling uploaded image
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . basename($image['name']);
        $imageName = $image['name'];

        $img_explode = explode('.', $imageName);
        $img_ext = strtolower(end($img_explode));
        $extensions = ['png', 'jpeg', 'jpg'];

        
        if(in_array($img_ext, $extensions)){
                    
                    $time = time();
                    $imageName= $time . '.' . $img_ext;
                    $uploadFile = $uploadDir . $imageName;
            if (!move_uploaded_file($image['tmp_name'], $uploadFile)) {
                echo("Error: Failed to move the uploaded file.");
                } 
                    $status = "online"; //once the user is signed up, his status will be updated to online.
        }else {
             echo("please upload an image file.");
        }
}else{
    echo("error uploading file.");
}

    $stmt = pg_prepare($conn, "insert_user", $query);
    if (!$stmt) {
        echo("Failed to prepare statement - " . pg_last_error($conn));
    }

    $result = pg_execute($conn, "insert_user", [$first_name, $last_name, $email, $hashedPassword, $imageName]);
    if (!$result) {
        echo("Failed to execute statement - " . pg_last_error($conn));
   }
  }else {
    echo("All input fields are required!");
}
echo "success";
?>
