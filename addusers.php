<?php

session_start();

if(!isset($_SESSION["Username"])) {
    header("Location: login.php");
}
else{
    include 'connect.php';
    $usename = $_SESSION["Username"];
    $query=$db->prepare("SELECT * FROM users WHERE Username=?");
    $query->execute(array($usename));
    $control=$query->fetch(PDO::FETCH_ASSOC);
        if($control['Admin']!= 1){
        header("Location:index.php");
    }

    $Username = $Email = "";
    $errors = array('Username'=>'','Email'=>'','Admin'=>'');
    $errorflag = 0;

    if(isset($_POST["submit"])) {   
        if(empty($_POST["Username"])) {
            $errors['Username'] = "Username is empty.<br>";
            $errorflag = 1;
        } else {
            $Username = $_POST["Username"];
        }
        if(empty($_POST["Email"])) {
            $errors['Email'] = "Email is empty.<br>";
            $errorflag = 1;
        }
        if(empty($_POST["Admin"])) {
            $errors['Admin'] = "Admin is empty.<br>";
            $errorflag = 1;
        } 

        if($errorflag == 1) {
            echo 'Errors in Form';
            $Username = mysqli_real_escape_string($conn, $_POST['Username']);
            $Email = mysqli_real_escape_string($conn, $_POST['Email']); 
            $Admin = mysqli_real_escape_string($conn, $_POST['Admin']);  
        } else {
            $Username = mysqli_real_escape_string($conn, $_POST['Username']);
            $Email = mysqli_real_escape_string($conn, $_POST['Email']);
            $Admin = mysqli_real_escape_string($conn, $_POST['Admin']);
            $sql = "INSERT into users (Username, Email) VALUES ('$Username','$Email')";
            if(mysqli_query($conn, $sql)) {
                header('location: admin.php');
            } else {
                echo 'Error'.mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<head>
    <title>Mason's cinema</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body class="wrapper">
    <h1>Welcome <?php echo $_SESSION["Username"]; ?></h1>
    <a href="admin.php">Admin menu</a><br>
    <a href="editproducts.php">Edit products</a><br>
<div>
    <form action="addusers.php" method="POST">
        <label>Username</label>
        <input type="text" name="Username" value="<?php echo htmlspecialchars($Username); ?>"><br><br>
        <div><?php echo $errors['Username']; ?></div>
        <label>Email</label>
        <input type="text" name="Email" value="<?php echo htmlspecialchars($Email); ?>"><br><br>
        <div><?php echo $errors['Email']; ?></div>
        <input type="text" name="Admin" value="<?php echo htmlspecialchars($Admin); ?>"><br><br>
        <div><?php echo $errors['Admin']; ?></div>
        <input type="submit" value="submit" name="submit">
    </form>
</div>
</body>
</html>