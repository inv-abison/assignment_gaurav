<?php

include('db.php');
session_start();
if(!isset($_SESSION['user'])){
    header('Location: login.php');
}

$pname = "";
$pdetail = "";
$price = "";
$errors = array(
    'pname' => '',
    'price' => '',
    'file' => ''
);
if (isset($_POST['submit'])) {
    $pname =  mysqli_real_escape_string($conn, $_POST['pname']);
    $pdetail = mysqli_real_escape_string($conn, $_POST['pdetail']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    if (empty($pname)) {
        $errors['pname'] = "Please enter the product name";
    }
    if (empty($price)) {
        $errors['price'] = "Please enter the price";
    }
    $new_path = "img";
        $allowedfile = ['jpg', 'png', 'jpeg'];
        $file_name = $_FILES['image']["name"];
        $file_extension = explode('.', $file_name);
        $file_extension = end($file_extension);
        if (!in_array($file_extension, $allowedfile)) {
            $errors['file'] = "The file you uploaded is not supported";
        }
        
        $file_size = $_FILES['image']["size"];
        if($file_size > 1000000){
            $errors['file'] = "The file you uploaded is too big";
        }
        $file_name = $pname . '_' . $file_name;
        $new_path = $new_path . '/' . $file_name;
    if (array_filter($errors)) {
    } else {
        
        move_uploaded_file($_FILES['image']['tmp_name'], $new_path);
        $query = "INSERT INTO products (name, details, price, img_path) VALUES ('$pname','$pdetail','$price', '$new_path')";
        if (mysqli_query($conn, $query)) {
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
<a href="products.php" class="go-back">Back<<</a>
    <div class="main-div">
        <form method="POST" action="addproduct.php" enctype="multipart/form-data">
            <div class="input-div">
                <p class="input-lable">
                    Product Name
                </p>
                <input type="text" name="pname" value="<?php echo $pname; ?>" />

            </div>
            <?php if ($errors['pname']) : ?>
                <div class="error-div">
                    <p><?php echo $errors['pname']; ?></p>
                </div>
            <?php endif; ?>
            <div class="input-div">
                <p class="input-lable">
                    Details
                </p>
                <input type="text" name="pdetail" value="<?php echo $pdetail; ?>" />

            </div>
            <div class="input-div">
                <p class="input-lable">
                    Price
                </p>
                <input type="text" name="price" value="<?php echo $price; ?>" />

            </div>
            <?php if ($errors['price']) : ?>
                <div class="error-div">
                    <p><?php echo $errors['price']; ?></p>
                </div>
            <?php endif; ?>
            <div class="input-div">
                <p class="input-lable">
                    Image
                </p>
                <input type="file" name="image" />
            </div>
            <?php if ($errors['file']) : ?>
                <div class="error-div">
                    <p><?php echo $errors['file']; ?></p>
                </div>
            <?php endif; ?>
            <div class="submit-div">
                <input type="submit" name="submit" value="Add Product"/>
            </div>
        </form>
    </div>

</body>

</html>