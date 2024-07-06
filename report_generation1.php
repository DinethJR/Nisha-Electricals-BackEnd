<?php
include 'db_conn.php';

// Fetch product data
$supplier_query = mysqli_query($conn, "SELECT * FROM `supplier`");
$supplier_count = mysqli_num_rows($supplier_query);

// Generate report
$report_content = "Supplier Report\n\n";
$report_content .= "Total Suppliers: $supplier_count\n\n";
$report_content .= "ID | First Name | Last Name | Email | Gender | Product\n\n";
while ($supplier = mysqli_fetch_assoc($supplier_query)) {
$report_content .= $supplier['id'] . " | " . $supplier['first_name'] . " | " . $supplier['last_name'] . " | " . $supplier['email'] ."|".$supplier['gender']."|".$supplier['adding_product'] ."\n";
}



// Download the report as a text file
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="suppliers_report.txt"');
echo $report_content;
exit;
?>