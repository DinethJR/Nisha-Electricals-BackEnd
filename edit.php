<?php
include "db_conn.php";
$id = $_GET['id'];

if(isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $adding_product = $_POST['adding_product'];

    $sql = "UPDATE `supplier` SET `first_name`='$first_name',`last_name`='$last_name',`email`='$email',`gender`='$gender',`adding_product`='$adding_product' WHERE id=$id";
    $result = mysqli_query($conn,$sql);

    if($result){
        header("Location: index1.php?msg=Data updated successfully");
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!--FontAwesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Add new Supplier</title>
</head>
<body>
    <nav class = "navbar navbar-light justify-content-center fs-3 mb-5"
    style="background-color: #CAF4FF;">
         Supplier Management System    
    </nav>

    <div class="container">
    <div class="text-center mb-4">
        <h3>Edit Supplier Information</h3>
        <p class="text-muted">Click update after changing any information</p>
    </div>    

    <?php
    
    $sql = "SELECT * FROM `supplier` WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    ?>

        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width:50vw;min-width:300px;">
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">First Name:</label>
                <input type="text" class="form-control" name="first_name" value="<?php echo $row['first_name']?>">
            </div>
            <div class="col">
                <label class="form-label">Last Name:</label>
                <input type="text" class="form-control" name="last_name" value="<?php echo $row['last_name']?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo $row['email']?>">
            </div>
            <div class="form-group mb-3">
                <label>Gender:</label>&nbsp;
                <input type="radio" class="form-check-input" name="gender"
                id="male" value="male" <?php echo ($row['gender']=='male')?"checked":"";?>>
                <label for="male" class="form-input-label">Male</label>
                &nbsp;
                <input type="radio" class="form-check-input" name="gender"
                id="female" value="female"<?php echo ($row['gender']=='female')?"checked":"";?>>
                <label for="female" class="form-input-label">Female</label>
            </div>
            <div class="mb-3">
                <label class="form-label">Product:</label>
                <input type="text" class="form-control" name="adding_product" value="<?php echo $row['adding_product']?>">
            </div>
            <div>
                <button type="submit" class="btn btn-success" name="submit">update</button>
                <a href="index1.php" class="btn btn-danger">Cancel</a>
            </div>
        </form>
        </div>
    </div>
<!--Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>