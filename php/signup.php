<?php
session_start();
require "config.php";

$first_name = $_POST['first_name'] ?? null;
$last_name = $_POST['last_name'] ?? null;
$email = $_POST['email'] ?? null;
$image = $_FILES['image'] ?? null;
$plainTextPassword = $_POST['password'] ?? null;

$hashedPassword = password_hash($plainTextPassword, PASSWORD_DEFAULT);

$query = 'INSERT INTO users(first_name, last_name, email, password, user_image) VALUES ($1, $2, $3, $4, $5)';
$select_email = "SELECT * FROM users WHERE email = $1";
$stmt = pg_prepare($conn, "select_email", $select_email);
$result = pg_execute($conn, "select_email", [$email]);

// Validate inputs
if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($plainTextPassword) && isset($image)){

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email format.");
    }else if ($result && pg_num_rows($result)> 0){
        die("email already exists");
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
                die("Error: Failed to move the uploaded file.");
                } 
                    $status = "online"; //once the user is signed up, his status will be updated to online.
        }else {
             die("please upload an image file.");
        }
}else{
    die("error uploading file.");
}

    $stmt = pg_prepare($conn, "insert_user", $query);
  
    
    if (!$stmt) {
        die("Failed to prepare statement - " . pg_last_error($conn));
    }

    $result = pg_execute($conn, "insert_user", [$first_name, $last_name, $email, $hashedPassword, $imageName]);
    if (!$result) {
        die("Failed to execute statement - " . pg_last_error($conn));
   }else{
    $query = "SELECT id FROM users WHERE email = $1 ";
    $stmt = pg_prepare($conn, "select_user", $query);
    $result = pg_execute($conn, "select_user",[$email]);

    if(pg_num_rows($result)>0){
        $row = pg_fetch_assoc($result);
        $_SESSION['unique_id'] = $row['id'];
        echo "success";
    }
   }
  }else {
    die("All input fields are required!");
}

?>
