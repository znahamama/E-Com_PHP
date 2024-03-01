<?php
include 'config.php' ;

session_start();

$user_id = $_SESSION['user_id'];
if(!isset($user_id)){

    header('location:login.php');
}
if(isset($_POST['add_to_cart'])){

$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_image = $_POST['product_image'];
$product_quantity = $_POST['product_quantity'];

$check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
if(mysqli_num_rows($check_cart_numbers) > 0){
$message[] = 'Already Added To Cart!';
}else{
mysqli_query($conn,"INSERT INTO `cart`(user_id, name, price, quantity,image)
 VALUES('$user_id','$product_name','$product_price','$product_quantity', '$product_image')") or die('query failed');
    $message[] = 'Product Added To Cart!';
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Shop</title>
</head>
<body>
<?php include 'header.php'; ?>
<section class="products">
<h2>Featured Products</h2>
<p>Winter Collection New Modern Design</p>
    <div class="box-container">
    <?php
$select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
if(mysqli_num_rows($select_products) > 0){
while($fetch_products = mysqli_fetch_assoc($select_products)){
?>
<form action="" method="post" class="box">

<img src="images/<?php echo $fetch_products['image']; ?>" alt="">
<div class="name"><?php echo $fetch_products['name']; ?></div> 
<div class="price"><?php echo $fetch_products['price']; ?>LE</div>
<div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
<input type="number" min="1" name="product_quantity" value="1" class="qty">
 <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>"> 
 <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
<input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
<input type="submit" value="Add To Cart" name="add_to_cart" class="btn">
</form>
 <?php
}
}else{
echo '<p class="empty">no products added yet!</p>';
}
?>
    </div>
</section>
<?php include 'footer.php' ?>
<script src="script.js"></script>
</body>
</html>