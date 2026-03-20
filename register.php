<?php
include('connect.php');
$usename = $Password = $Email = '';
$admin = 0;
$errors = array('usename'=>'','Password'=>'','Email'=>'');

if(isset($_POST["submit"])) {
    if(empty($_POST["Email"])) {
        $errors['Email'] = "Email is empty.<br>";
    } else {
        $Email = $_POST['Email'];
        if(!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $errors['Email'] = 'Please enter a valid email address';
        }
    }
    if(empty($_POST["usename"])) {
        $errors['usename'] = "Username is empty.<br>";
    } else {
        $usename = $_POST["usename"];
    }
    if(empty($_POST["Password"])) {
        $errors['Password'] = "Password is empty.<br>";
    } else {
        $Password = $_POST["Password"];
    }
    if(array_filter($errors)) {
        echo 'Errors in Form';
    } else {
        $usenmame = mysqli_real_escape_string($conn, $_POST['usename']);
        $Password = mysqli_real_escape_string($conn, $_POST['Password']);
        $Email = mysqli_real_escape_string($conn, $_POST['Email']);
        $hashed = MD5($Password);
        $sql = "INSERT into users (Username, Password, Email, Admin) VALUES ('$usename','$hashed','$Email','$Admin')";
        if(mysqli_query($conn, $sql)) {
            session_start();
            $_SESSION["Username"] = $usename;
            header('location: index.php');
        }
    }
}

?>

<!DOCTYPE html>
<head>
    <title>Mason's Cinema</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <dvi class="wrapper">
        <form method="POST" action="register.php">
                <label>Username:</label>
                <input type="text" name ="usename" Value ="<?php echo $usename; ?>"><br>
                <div class ="red-text"><?php echo $errors['usename']; ?></div>
                <label>Password:</label>
                <input type="password" name = "Password" Value ="<?php echo $Password; ?>"><br>
                <div class ="red-text"><?php echo $errors['Password']; ?></div>
                <label>Email:</label><br>
                <input type="text" name ="Email" Value ="<?php echo $Email; ?>">
                <div classs="red-text"><?php echo $errors['Email']?></div>
                <input class="submit" type="submit" name="submit" value="Register">
            </form>
        <a href="login.php">Login here</a>
    </dvi>
</body>
</html>