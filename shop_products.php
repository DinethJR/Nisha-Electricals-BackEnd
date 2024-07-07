<?php
include 'connect.php';

// Initialize default price range values
$min_price = isset($_GET['min_price']) ? intval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) ? intval($_GET['max_price']) : 10000;

// Initialize search keyword
$search_keyword = isset($_GET['search']) ? sanitize($conn, $_GET['search']) : '';

// Function to sanitize input
function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags($input)));
}

// Add to cart functionality
if(isset($_POST['add_to_cart'])){
    $product_name = sanitize($conn, $_POST['product_name']);
    $product_price = sanitize($conn, $_POST['product_price']);
    $product_image = sanitize($conn, $_POST['product_image']);
    $product_quantity = 1;

    $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity) VALUES ('$product_name','$product_price','$product_image','$product_quantity')");
    if($insert_product) {
        $message = "Product Added to the Cart";
    } else {
        $message = "Failed to add product to the cart";
    }
}

// Construct the SQL query
$sql = "SELECT * FROM `products` WHERE price BETWEEN $min_price AND $max_price";
if (!empty($search_keyword)) {
    $sql .= " AND name LIKE '%$search_keyword%'";
}

// Retrieve products based on the constructed query
$select_products = mysqli_query($conn, $sql);
$product_count = mysqli_num_rows($select_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Products-project</title>
    <!--css file-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="stylehome.css">
    <!--Font awsome link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="navbar">
		<div class="logo">
			<!--logo-->
			<img src="volt2.jpeg" width="300px" >
		</div>
		<nav>
			<ul>
				<li><a href="home.html">Home</a></li>
				<li><a href="aboutus.html">About Us</a></li>
				<li><a href="shop_products.php">Products</a></li>
				<li><a href="">Profile</a></li>
                <li><a href="feedback.html">Feedback</a></li>
				<a href="cart.php" class="cart"><i class="fa-solid fa-cart-shopping"></i></a>
			</ul>
		</nav>
	</div>
   
    <div class="container">
        <!-- Price Range Filter -->
        <div class="filter">
            <h2>Filter by Price</h2>
            <form method="GET" action="">
                <label for="min_price">Min Price:</label>
                <input type="number" id="min_price" name="min_price" value="<?php echo $min_price ?>" min="0">
                <label for="max_price">Max Price:</label>
                <input type="number" id="max_price" name="max_price" value="<?php echo $max_price ?>" min="0">
                <input type="submit" value="Apply" class="apply_btn">
            </form>
        </div>
        
        <!-- Search Form -->
        <div class="search">
            <h2>Search Products</h2>
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search..." value="<?php echo $search_keyword ?>">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    
        <section class="products">
            <h1 class="heading">Let's Shop</h1>
            <div class="product_container">
                <?php if($product_count > 0): ?>
                    <?php while($fetch_product = mysqli_fetch_assoc($select_products)): ?>
                        <form method="post" action="">
                            <div class="edit_form">
                                <img src="images/<?php echo $fetch_product['image']; ?>" alt="">
                                <h3><?php echo $fetch_product['name']; ?></h3>
                                <div class="price">Price: Rs<?php echo $fetch_product['price']; ?>/=</div>
                                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                                <input type="submit" class="submit_btn cart_btn" value="Add to Cart" name="add_to_cart">
                            </div>
                        </form>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty_text">No Products Available</div>
                <?php endif; ?>
            </div>
        </section>
        <br>
       
<!-- Button for generating product report -->
<button onclick="window.location.href='generate_report.php'" class="report-btn">Generate Product Report</button>


    </div>
</body>
</html>
