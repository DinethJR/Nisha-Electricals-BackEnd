<?php
include 'connect.php';

// Fetch product data
$product_query = mysqli_query($conn, "SELECT * FROM `products`");
$product_count = mysqli_num_rows($product_query);

// Generate report
$report_content = "Products Report\n\n";
$report_content .= "Total Products: $product_count\n\n";
$report_content .= "ID | Name | Price | Image\n";
while ($product = mysqli_fetch_assoc($product_query)) {
    $report_content .= $product['id'] . " | " . $product['name'] . " | Rs " . $product['price'] . " | " . $product['image'] . "\n";
}

// Download the report as a text file
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="products_report.txt"');
echo $report_content;
exit;
?>
