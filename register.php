<?php
include('db.php');
$fname = "";
$lname = "";
$uname = "";
$email = "";
$pswd = "";
$pswd2 = "";
$pcode = "";
$errors = array(
    'fname' => '',
    'lname' => '',
    'uname' => '',
    'email' => '',
    'pswd' => '',
    'pswd2' => '',
    'pcode' => ''
);
if (isset($_POST['submit'])) {
    $fname =  mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $uname = mysqli_real_escape_string($conn, $_POST['uname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pswd = mysqli_real_escape_string($conn, $_POST['password']);
    $pswd2 = mysqli_real_escape_string($conn, $_POST['password2']);
    $pcode = mysqli_real_escape_string($conn, $_POST['pincode']);
    if (empty($fname)) {
        $errors['fname'] = "Please enter the first name";
    }
    if (empty($lname)) {
        $errors['lname'] = "Please enter the last name";
    }
    if (empty($uname)) {
        $errors['uname'] = "Please enter the username";
    }
    if (!ctype_alnum($uname)) {
        $errors['uname'] = "The username must be alphanumeric";
    }
    if (strlen($uname) < 5) {
        $errors['uname'] = "Username must be at least 5 characters long";
    } else if (strlen($uname) > 10) {
        $errors['uname'] = "Username must be at most 10 characters long";
    } else {
    }

    if (empty($email)) {
        $errors['email'] = "Please enter the email";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address";
    } else {
    }
    if (empty($pswd)) {
        $errors['pswd'] = "Please enter the password";
    }
    if (empty($pswd2)) {
        $errors['pswd2'] = "Please enter the confirm password";
    }
    if ($pswd != $pswd2) {
        $errors['pswd2'] = "Passwords do not  match ";
    }
    if (empty($pcode)) {
        $errors['pcode'] = "Please enter the pin code";
    }
    if (strlen($pcode) > 6) {
        $errors['pcode'] = "Please enter a valid 6 digit pin code";
    }
    if (array_filter($errors)) {
    } else {
        session_start();
        $query = "INSERT INTO users (fname, lname, uname, email, password, pincode) VALUES ('$fname','$lname','$uname','$email','$pswd','$pcode')";
        if (mysqli_query($conn, $query)) {
           $_SESSION['user'] = $email;
           header('Location:products.php');
        } else {
            echo "error adding". mysqli_error($conn);
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
        <form method="POST" action="register.php">
            <div class="input-div">
                <p class="input-lable">
                    First Name
                </p>
                <input type="text" name="fname" value="<?php echo $fname; ?>" />

            </div>
            <?php if ($errors['fname']) : ?>
                <div class="error-div">
                    <p><?php echo $errors['fname']; ?></p>
                </div>
            <?php endif; ?>
            <div class="input-div">
                <p class="input-lable">
                    Last Name
                </p>
                <input type="text" name="lname" value="<?php echo $lname; ?>" />

            </div>
            <?php if ($errors['lname']) : ?>
                <div class="error-div">
                    <p><?php echo $errors['lname']; ?></p>
                </div>
            <?php endif; ?>
            <div class="input-div">
                <p class="input-lable">
                    Username
                </p>
                <input type="text" name="uname" value="<?php echo $uname; ?>" />

            </div>
            <?php if ($errors['uname']) : ?>
                <div class="error-div">
                    <p><?php echo $errors['uname']; ?></p>
                </div>
            <?php endif; ?>
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
            <div class="input-div">
                <p class="input-lable">
                    Confirm Password
                </p>
                <input type="password" name="password2" />

            </div>
            <?php if ($errors['pswd2']) : ?>
                <div class="error-div">
                    <p><?php echo $errors['pswd2']; ?></p>
                </div>
            <?php endif; ?>
            <div class="input-div">
                <p class="input-lable">
                    PIN Code
                </p>
                <input type="text" name="pincode" value="<?php echo $pcode; ?>" />

            </div>
            <?php if ($errors['pcode']) : ?>
                <div class="error-div">
                    <p><?php echo $errors['pcode']; ?></p>
                </div>
            <?php endif; ?>
            <div class="submit-div">
                <input type="submit" name="submit" value="Sign Up"/>
            </div>
        </form>
    </div>

</body>

</html>