<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css?v=1.0">
</head>
<body>
    <div class="wrapper">
        <section class="form login">
            <header>Realetime Chat App</header>
            <form action="php/login.php">
                <div class="error-txt">This is an error message</div>
                <div class="name-details">

                </div>
                <div class="field input">
                    <label>Email</label>
                    <input type="text" name = "email" placeholder="Enter your email">
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name = "password" placeholder="Enter your password">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" value="continue to chat" href = "#">
                </div>
            </form>
            <div class="link">Not yet signed up? <a href="index.php">Sign up now</a></div>
        </section>
    </div>
    <script src="js/pass-show.js"></script>
    <script src="js/login.js"></script>
</body>
</html>