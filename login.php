<?PHP

include "connect.php";

if(isset($_POST["login"])) {
    
    if($_POST["Username"] == "" or $_POST["Password"] == "") {
        echo "<center><h1>Username, Password are required.</h1></center>";
    } else {
        $Username = strip_tags(trim($_POST["Username"]));
        $Password = strip_tags(trim($_POST["Password"]));
        $hash = MD5($Password);
        $query=$db->prepare("SELECT * FROM Users WHERE Username=?");
        $query->execute(array($Username));
        $control =$query->fetch(PDO::FETCH_ASSOC);
        if($control>0 && ($hash == $control['Password'])) {
            session_start();
            $_SESSION["Username"] = $Username;
            header("location:index.php");
        }
    }
}

?>

<!DOCTYPE html>
<head>
    <title> Mason's Cinema</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <div class="wrapper">
        <form method="POST" action="login.php">
            <p>
                <label for = "">Username</label>
                <input name="Username" type="text">
            </p>
            <p>
                <label for = "">Password</label>
                <input name="Password" type="Password">
            </p>
            <button type="submit" name="login">login</button>
        </form>
        <a href="register.php">Register here</a>
    </div>
</body>
</html>