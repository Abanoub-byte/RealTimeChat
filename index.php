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
        <section class="form signup">
            <header>MemChat</header>
            <form action="#" enctype = "multipart/form-data">
                <div class="error-txt"></div>
                <div class="name-details">
                    <div class="field input">
                        <label>First Name</label>
                        <input type="text" name="first_name" placeholder="Enter your first name">
                    </div>
                    <div class="field input">
                        <label>Last Name</label>
                        <input type="text" name = "last_name" placeholder="Enter your last name">
                    </div>
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

                <div class="field">
                    <label>Select Image</label>
                    <input type="file" name = "image">
                </div>
                <div class="field button">
                    <input type="submit" value="Sign up" href="#">
                </div>
            </form>
            <div class="link">Already signed up? <a href="login.php">Login now</a></div>
        </section>
    </div>
    
    <script src="js/signup.js"></script>
    <script src="js/pass-show.js"></script>
</body>
</html>