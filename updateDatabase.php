<?php error_reporting (E_ALL ^ E_NOTICE);

    session_start();


    $link = mysqli_connect("localhost", "root", "", "users");

    if (mysqli_connect_error()) {

        die ("There was an error connecting to the database");

    }

    if(array_key_exists("content",$_POST)){
        echo $_POST['content'];
    }

    $query="UPDATE `login` SET diary = '" .mysqli_real_escape_string($link,$_POST['content'])."' WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."' LIMIT 1";

    if(mysqli_query($link,$query)){
        echo "success";
    }
    else{
        echo "fail";
    }
?>