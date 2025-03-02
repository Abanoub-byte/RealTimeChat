<?php
session_start();
if(!isset($_SESSION['unique_id'])){
    header("location: ../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <section class="users">
          <header>
            <?php
                include_once "php/config.php";
                $query = "SELECT * FROM users WHERE id = $1";
                $stmt = pg_prepare($conn, "get_user", $query);
                if(!$stmt){
                    error_log("error with the statement".  pg_last_error($conn));
                }else{
                    $result = pg_execute($conn, "get_user", [$_SESSION['unique_id']]);
                    $user = pg_fetch_assoc($result);
                }

            ?>
            <div class="content">
                <img src="uploads/<?php echo $user['user_image']?>" alt=""></img>
                <div class="details">
                    <span><?php echo $user['first_name'] . " ". $user['last_name'];?></span>
                    <p><?php echo $user['status']; ?></p>
                </div>
            </div>
            <a href="php/logout.php?logout_id=<?php echo $user['id']?>" class="logout">Logout</a>
          </header>
          <div class="search">
            <span class="text">Select a user to start chating</span>
            <input type="text" placeholder="Enter name to search">
            <button><i class="fas fa-search"></i></button>
          </div>
          <div class="users-list">
             
        </section>
    </div>
    <script src="js/users.js"></script>
</body>
</html>