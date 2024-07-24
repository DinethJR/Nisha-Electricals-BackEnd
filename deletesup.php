<?php
include "db_conn.php";
$id = $_GET['id'];
$sql = "DELETE FROM `supplier` WHERE id = $id";
$result = mysqli_query($conn, $sql);
if($result){
    header("Location: index1.php?msg=Record deleted successfully");
}
else{
    echo "Failed: " . mysqli_error($conn);
}
?>