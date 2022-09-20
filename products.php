<?php

include('db.php');
session_start();
if(!isset($_SESSION['user'])){
    header('Location: login.php');
    return;
}
$results_per_page = 5;
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
$number_of_results = mysqli_num_rows($result);
$number_of_pages = ceil($number_of_results/$results_per_page);
if (!isset($_GET['page'])) {
    $page = 1;
  } else {
    $page = $_GET['page'];
  }

  
$this_page_first_result = ($page-1)*$results_per_page;
$query='SELECT * FROM products ORDER BY id DESC LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
$result = mysqli_query($conn, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM products WHERE id = '$id'";
    if(mysqli_query($conn, $query )){
        header('Location:products.php');
    }else{
        echo "ERROR";
    }
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mains.css" <title>
    <title>Document</title>
</head>

<body>
    <a href="addproduct.php" class="go-back">Add Product</a>
    <form action="products.php" method="post">
        <input type="submit" value="Log Out" name="logout" class = "logout-btn" />
    <div class="product-container">
        <?php foreach ($products as $product) : ?>
            <div class="product-div">
                <div class="product-col">
                    <p>Name : <?php echo $product['name']; ?></p>
                </div>
                <div class="product-col">
                    <p>Details : <?php echo $product['details']; ?></p>
                </div>
                <div class="product-col">
                    <p>Price : <?php echo $product['price']; ?></p>
                </div>
                <div class="product-col">
                    <img src="<?php echo $product['img_path']; ?>" width="200px" height="200px" style = "object-fit: cover" >
                </div>
                <div class="product-col">
                    <a href="edit.php?id=<?php echo $product['id']; ?>" class="edit-btn">Edit</a>
                </div>
                <div class="product-col">
                    <form action="products.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                        <input type="submit" name="submit" value="Delete" class="delete-btn">
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="pagination">
        <?php
        for ($page=1;$page<=$number_of_pages;$page++) {
            echo '<a href="products.php?page=' . $page . '">' . $page . '</a> ';
          }
          ?>
    </div>
</body>

</html>