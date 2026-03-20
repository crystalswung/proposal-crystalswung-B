<?php
session_start();

if(!isset($_SESSION["Username"])) {
    header("Location: login.php");
}

else {
    include 'connect.php';
    $username = $_SESSION["Username"];
    $query=$db->prepare("SELECT * FROM users WHERE Username=?");
    $query->execute(array($username));
    $control=$query->fetch(PDO::FETCH_ASSOC);
    if ($control['Admin'] != 1){
        header("Location:index.php");
    }

    $Username = $Email = $Admin = "";
    $errors = array('Username'=>'', 'Email'=>'', 'Admin'=>'');
    $errorflag = 0;

    if((!isset($_GET['ID'])) && (!isset($_POST['ID']))) {
        header("location:admin.php");
    } else if (isset($_GET['ID'])) {
        $ID = $_GET['ID'];
        $query = $db->prepare("SELECT * FROM users WHERE ID=?");
        $query->execute(array($ID));
        $control=$query->fetch(PDO::FETCH_ASSOC);
        $Username = $control['Username'];
        $Email = $control['Email'];
        $Admin = $control['Admin'];
    }


    if(isset($_POST['submit'])) {
        $ID = $_POST['ID'];

        if(empty($_POST['Username'])) {
            $errors['Username'] = 'Username is Empty.<br>';
            $errorflag = 1;
        }
                if(empty($_POST['Email'])) {
            $errors['Email'] = 'Email is Empty.<br>';
            $errorflag = 1;
        }
        
        if($errorflag == 1) {
            echo "Errors in Form";
            $Username = mysqli_real_escape_string($conn, $_POST['Username']);
            $Email = mysqli_real_escape_string($conn, $_POST['Email']);
            $Admin = mysqli_real_escape_string($conn, $_POST['Admin']);

        } else {
            $Username = mysqli_real_escape_string($conn, $_POST['Username']);
            $Email = mysqli_real_escape_string($conn, $_POST['Email']);
            $Admin = mysqli_real_escape_string($conn, $_POST['Admin']);

            $sql = "UPDATE users SET `Username` = '$Username', Email = '$Email', Admin = '$Admin' WHERE ID = '$ID'";

            if(mysqli_query($conn, $sql)) {
                echo $name;
                header('Location:admin.php');
            } else {
                echo 'Error'.mysqli_error($conn);
            }
        }
   
    }


}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Mason's Admin</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
    <div class="wrapper">
    <h1>Welcome <?php echo $_SESSION["Username"]; ?></h1>

    <form action="updateuser.php" method="POST">
    <input type="hidden" name="ID" value="<?php echo $ID; ?>">

    <label>Userame:</label>
    <input type="text" name="Username" value="<?php echo htmlspecialchars($Username); ?>"><br><br>
    <div><?php echo $errors['Username']; ?></div>
    
    <label>Email:</label>
    <input type="text" name="Email" value="<?php echo htmlspecialchars($Email); ?>"><br><br>
    <div><?php echo $errors['Email']; ?></div>

    <label>Admin:</label>
    <input type="text" name="Admin" value="<?php echo htmlspecialchars($Admin); ?>"><br><br>
    <div><?php echo $errors['Admin']; ?></div>
    
    <input type="submit" value="submit" name="submit">
    </form>
    </div>

</body>
</html>