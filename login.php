<?php
include('db.php');
$email = "";
$pswd = "";
$errors = array(
    'email' => '',
    'pswd' => ''
);
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pswd = mysqli_real_escape_string($conn, $_POST['password']);
    if (empty($email)) {
        $errors['email'] = "Please enter the email";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address";
    } else {
    }
    if (empty($pswd)) {
        $errors['pswd'] = "Please enter the password";
    }
    if (array_filter($errors)) {
    } else {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
        if ($user['email']) {
            if($pswd == $user['password']) {
            session_start();
            $_SESSION['user'] = $user['email'];
            header('Location:products.php');
            } else{
                $errors['pswd'] = "Invalid credentials";
            }
            
        } else {
            $errors['email'] = "The email address is not registered";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mains.css" <title>
    </title>
</head>

<body>
    <a href="index.php" class="go-back">Back<<</a>
    <div class="main-div">
        <form method="POST" action="login.php">
            <div class="input-div">
                <p class="input-lable">
                    Email Address
                </p>
                <input type="email" name="email" value="<?php echo $email; ?>" />
            </div>
            <?php if ($errors['email']) : ?>
                <div class="error-div">
                    <p><?php echo $errors['email']; ?></p>
                </div>
            <?php endif; ?>
            <div class="input-div">
                <p class="input-lable">
                    Password
                </p>
                <input type="password" name="password" />

            </div>
            <?php if ($errors['pswd']) : ?>
                <div class="error-div">
                    <p><?php echo $errors['pswd']; ?></p>
                </div>
            <?php endif; ?>
            <div class="submit-div">
                <input type="submit" name="submit" value="Login"/>
            </div>
        </form>
    </div>

</body>

</html>