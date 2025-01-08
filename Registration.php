<?php
$loginFailed = false;
$usernameTaken = false;
$emailTaken = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $host = "";
        $user = "";
        $pass = "";
        $dbname = "pethub";

        $username = $_POST['Username'];
        $password = $_POST['Password'];
        $email = $_POST['Email'];

        $conn = mysqli_connect($host, $user, $pass, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result)>0) {
            $usernameTaken = true;
        }
        
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result)>0) {
            $emailTaken = true;
        }
        
        if(!$usernameTaken AND !$emailTaken) {
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                header('Location: index.html'); 
            }
        }
      
        mysqli_close($conn);
    }
    elseif (isset($_POST['login'])) {
        $host = "";
        $user = "";
        $pass = "";
        $dbname = "pethub";

        $username = $_POST['lUsername'];
        $password = $_POST['lPassword'];

        $conn = mysqli_connect($host, $user, $pass, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result)>0) {
            header('Location: index.html');
        } 
        else{
            $loginFailed = true;
            echo "<script> registerForm.style.display = 'none';
                 loginForm.style.display = 'block'; </script>";
        }
        mysqli_close($conn);
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--=============== BOXICONS ===============-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/stylesReg.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>PetHub - Registration</title>
</head>
<body>
<!--==================== HEADER ====================-->
<header class="header" id="header">
    <nav class="nav container">
        <a href="index.html" class="nav__logo">
            <img src="assets/img/logo.png" alt="PetHub Logo" class="nav__logo-icon" />
        </a>
        <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
                <li class="nav__item">
                    <a href="index.html" class="nav__link active-link">Home</a>
                </li>
                <li class="nav__item">
                    <a href="index.html#products" class="nav__link">Products</a>
                </li>
            </ul>
            <div class="nav__close" id="nav-close">
                <i class='bx bx-x'></i>
            </div>
        </div>
        <div class="nav__btns">
            <i class='bx bx-log-in' id="logout-icon"></i>
            <i id="login-icon" class="fas fa-user-circle"></i>
            <div class="nav__toggle" id="nav-toggle">
                <i class='bx bx-grid-alt'></i>
            </div>
        </div>
    </nav>
</header>

<!--==================== MAIN SECTION ====================-->
<main class="main container">
    <section class="login-register section" id="login-register">
        <h2 class="section__title">Register / Sign In</h2>

        <div class="form-container grid">
            <!-- Registration Form -->
            <form action="" method="POST" class="form form--register" id="register-form" <?php echo $loginFailed ? 'style="display: none;"' : 'style="display: block;"'; ?>>
                <h3>Create Account</h3>
                <div class="form__input-group">
                    <input type="text" class="form__input" placeholder="Username" id="Username" name="Username" minlength="3" pattern="[A-Za-z][A-Za-z0-9]*" title="Must be 3 characters or more and should start with a letter" required />
                    <label id="Uerror" style="color: red; display: none;">The username is already taken</label>
                </div>
                <div class="form__input-group">
                    <input type="email" class="form__input" placeholder="Email" id="Email" name="Email" required />
                    <label id="Eerror" style="color: red; display: none;">An account with this email already exist</label>
                </div>
                <div class="form__input-group">
                    <input type="password" class="form__input" placeholder="Password" id="Password" name="Password" minlength="8" required />
                </div>
                <div class="form__input-group">
                    <button type="submit" class="button button--primary" id="register" name="register">Register</button>
                </div>
                <div class="form__input-group">
                    <p>Already have an account? 
                        <button type="button" id="show-login" class="button button--link">Sign In</button>
                    </p>
                </div>
            </form>

            <!-- Login Form -->
            <form action="" method="POST" class="form form--login" id="login-form" <?php echo $loginFailed ? 'style="display: block;"' : 'style="display: none;"'; ?>>
                <h3>Sign In</h3>
                <div class="form__input-group">
                    <input type="text" class="form__input" id="username" name="lUsername" placeholder="Username" minlength="3" pattern="[A-Za-z][A-Za-z0-9]*" title="Must be 3 characters or more and should start with a letter" required />
                </div>
                <div class="form__input-group">
                    <input type="password" class="form__input" id="password" name="lPassword" placeholder="Password" minlength="8" required />
                </div>
                <label id="error" style="color: red; display: none;">Incorrect username or password</label>
                <div class="form__input-group">
                    <button type="submit" class="button button--primary" id="login" name="login">Login</button>
                </div>
                <div class="form__input-group">
                    <p>Don't have an account? 
                        <button type="button" id="show-register" class="button button--link">Create Account</button>
                    </p>
                </div>
            </form>
        </div>
    </section>
</main>

<script src="assets/js/main.js"></script>

<script>
    // JavaScript to toggle between login and register forms
    const registerForm = document.getElementById('register-form');
    const loginForm = document.getElementById('login-form');
    const showLoginButton = document.getElementById('show-login');
    const showRegisterButton = document.getElementById('show-register');

    showLoginButton.addEventListener('click', () => {
        registerForm.style.display = 'none';
        loginForm.style.display = 'block';
    });

    showRegisterButton.addEventListener('click', () => {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
    });
</script>

    <?php
    if ($loginFailed) {
        echo '<script> document.getElementById("error").style.display = "block"</script>';
    }
    if($usernameTaken){
        echo '<script> document.getElementById("Uerror").style.display = "block"</script>';
    }
    if($emailTaken){
        echo '<script> document.getElementById("Eerror").style.display = "block"</script>';
    }
    ?>

</body>
</html>
