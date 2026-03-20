<?php
$ID = 101;
$targer_dir = "uploads/";
$imageFileType = strtolower(string: pathinfo(path: $_FILES["fileToUpload"]["name"], flags: PATHINFO_EXTENSION));
$target_file = $targer_dir . $ID . "." . $imageFileType;
$uploadok = 1;

if(isset($_POST['submit'])) {
    $check = getimagesize(filename: $_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false){
        echo "File is a image - ".$check["mime"].".";
    } else {
        echo "File is not a image";
        $uploadok = 0;
    }
}
if(file_exists(filename: $target_file)) {
    echo "File already exists";
    $uploadok = 0;
}
if($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "File is to big";
    $uploadok = 0;
}
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "jpeg"){
    echo "Invalid File Type";
    $uploadok = 0;
}
if($uploadok == 0) {
    echo "Sorry your file cannot be uploaded";
} else {
    if(move_uploaded_file(from: $_FILES["fileToUpload"]["tmp_name"], to: $target_file)){
        echo"Success";
    } else {
        echo "failure";
    }
}

?>