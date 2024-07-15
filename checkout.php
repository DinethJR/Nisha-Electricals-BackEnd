<?php 
session_start();
require_once 'connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';

$mail = new PHPMailer(true);
$alert = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $contact_number = $_POST["contact_number"];

    $grand_total = $_SESSION['grand_total'];
    $order_date = date('Y-m-d'); // Get the current date

    $query = "INSERT INTO customer_order (customer_name, customer_email, customer_address, contact_number, order_date) VALUES (?, ?, ?, ?, ?)";
    $statement = $conn->prepare($query);
    $statement->bind_param("sssss", $name, $email, $address, $contact_number, $order_date);

    if ($statement->execute()) {
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'voltageelectric0000@gmail.com';
        $mail->Password = 'ttkn vjtu daaz tgjd';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = '587';

        $mail->setFrom('voltageelectric0000@gmail.com');
        $mail->addAddress($email);
        $mail->addAddress('voltageelectric0000@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'Your Purchase Receipt';

        // Fetch cart items
        $cart_items = '';
        $select_cart_products = mysqli_query($conn, "SELECT * FROM `cart`");
        while ($fetch_cart_products = mysqli_fetch_assoc($select_cart_products)) {
            $cart_items .= "<tr>
                                <td>{$fetch_cart_products['name']}</td>
                                <td>{$fetch_cart_products['quantity']}</td>
                                <td>LKR {$fetch_cart_products['price']}</td>
                            </tr>";
        }

        $mail->Body = "
                <h2>Thank you for your purchase, $name!</h2>
                <p>Here's your receipt:</p>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    $cart_items
                </table>
                <p>Total Amount: LKR $grand_total</p>
                <p>Shipping Address: $address</p>
                <p>Contact Number: $contact_number</p>
                <p>Order Date: $order_date</p>
                <p>We hope you enjoy your purchase!</p>
            ";

        $mail->send();
        $alert = '<div class="alert-success">
            <span>Message sent! Thank you.</span>
        </div>';
    } catch (Exception $e) {
        $alert = '<div class="alert-error">
            <span>' . $e->getMessage() . '</span>
        </div>';
    }
}
else {
    $alert = '<div class="alert-error">
            <span>Failed to insert order details into the database.</span>
        </div>';
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/checkoutstyles.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="stylehome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    
<header class="header">
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

        

          
</header>
    <?php echo $alert; ?></br></br>
    <h1>Proceed to Checkout</h1></br></br>
    <form action="checkout.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea><br><br>

        <input type="submit" value="Proceed to Payment">
    </form>

    <script type="text/javascript">
        if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>
