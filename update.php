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

    $name = $description = $cert = $trailer = "";
    $errors = array('name'=>'', 'description'=>'', 'cert'=>'', 'trailer'=>'');
    $errorflag = 0;

    if((!isset($_GET['ID'])) && (!isset($_POST['ID']))) {
        header("location:admin.php");
    } else if (isset($_GET['ID'])) {
        $ID = $_GET['ID'];
        $query = $db->prepare("SELECT * FROM films WHERE ID=?");
        $query->execute(array($ID));
        $control=$query->fetch(PDO::FETCH_ASSOC);
        $name = $control['name'];
        $cert = $control['cert'];
        $description = $control['description'];
        $trailer = $control['trailer'];
    }


    if(isset($_POST['submit'])) {
        $ID = $_POST['ID'];

        if(empty($_POST['name'])) {
            $errors['name'] = 'Name is Empty.<br>';
            $errorflag = 1;
        }
                if(empty($_POST['description'])) {
            $errors['description'] = 'Description is Empty.<br>';
            $errorflag = 1;
        }
                if(empty($_POST['cert'])) {
            $errors['cert'] = 'Cert is Empty.<br>';
            $errorflag = 1;
        }
                if(empty($_POST['trailer'])) {
            $errors['trailer'] = 'Trailer is Empty.<br>';
            $errorflag = 1;
        }
        
        if($errorflag == 1) {
            echo "Errors in Form";
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $cert = mysqli_real_escape_string($conn, $_POST['cert']);
            $trailer = mysqli_real_escape_string($conn, $_POST['trailer']);

        } else {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $cert = mysqli_real_escape_string($conn, $_POST['cert']);
            $trailer = mysqli_real_escape_string($conn, $_POST['trailer']);

            $sql = "UPDATE films SET `name` = '$name', description = '$description', cert = '$cert', trailer = '$trailer' WHERE ID = '$ID'";

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
    <a href="logout.php">Logout Here</a><br>

    <form action="update.php" method="POST">
    <input type="hidden" name="ID" value="<?php echo $ID; ?>">
    <label>Film Name:</label>
    
    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"><br><br>
    <div><?php echo $errors['name']; ?></div>
    
    <label>Description:</label>
    <input type="text" name="description" value="<?php echo htmlspecialchars($description); ?>"><br><br>
    <div><?php echo $errors['description']; ?></div>

    <label>Certificate:</label>
    <input type="text" name="cert" value="<?php echo htmlspecialchars($cert); ?>"><br><br>
     <div><?php echo $errors['cert']; ?></div>

    <label>YouTube Embed:</label>
    <input  type="text" name="trailer" value="<?php echo $trailer; ?>"><br><br>
    <div><?php echo $errors['trailer']; ?></div>
    
    <input type="submit" value="submit" name="submit">
    </form>
    </div>

</body>
</html>