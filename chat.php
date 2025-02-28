<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
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
        <section class="chat-area">
          <header>

            <?php
                include_once "php/config.php";

              if(isset($_GET['id'])){

                    $user_id = $_GET['id'];
                    $query = "SELECT * FROM users WHERE id = $1";
                    $stmt = pg_prepare($conn, "get_id", $query);
                    $result = pg_execute($conn, "get_id", [$user_id]);

                    if(pg_num_rows($result) > 0){
                        $user = pg_fetch_assoc($result);
                    }

              }else{
                print_r($user);
              }
            ?>
            <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
            <div class="content">
            <img src="uploads/<?php echo $user['user_image'];?>" alt=""></img>
        </div> 
        <div class="details">
            <span><?php echo  $user['first_name']. " ". $user['last_name'];?></span>
            <p><?php echo  $user['status']; ?></p>
        </div>
          </header>
         
          <div class="chat-box">
          
       
        </div>
        <form action="#" class="typing-area" autocomplete= "off">
            <input type="text" name= "sender_id" value="<?php echo $_SESSION['unique_id']; ?> "hidden>
            <input type="text" name = "receiver_id" value="<?php echo $user['id']; ?>"hidden>
            <input type="text" name = "message" class="input-field" placeholder="Type a message">
            <button><i class="fab fa-telegram-plane"></i></button>
        </form>
        </section>
    </div>
    <script src = "js/chat.js" ></script>
    
</body>
</html>