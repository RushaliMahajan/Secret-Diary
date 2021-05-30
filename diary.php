<?php

    $link = mysqli_connect("localhost", "root", "", "users");
    error_reporting (E_ALL ^ E_NOTICE);
    session_start();

    if(array_key_exists('id',$_COOKIE)){
        $_SESSION['id']=$_COOKIE['id'];
    }

    if(array_key_exists('id',$_SESSION)){

        $query="SELECT `diary` FROM `login` WHERE `id` = '".mysqli_real_escape_string($link,$_SESSION['id'])."' ";
        $result=mysqli_query($link,$query);
        $row=mysqli_fetch_array($result);

        $diaryContent = $row['diary'];
    }

    else{
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diary</title>

        <!--BootStrap Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!--Jquery Link-->
    <script src="jquery-ui/jquery-ui.js"></script>
    <link href="jquery-ui/jquery-ui.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>

        body{
            background-image: url('https://cdn.wallpapersafari.com/5/44/KEVnkW.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }

        .nav{
            background-color:white;
            height:50px;
            padding:8px;
        }

        .first{
            float:left;
            width:45%;
            margin-left:30px;
        }

        .second{
            float:right;
            width:50%;
             
        }

        .btn{
            float:right;
            margin-right:20px;
        }


        #textarea{
            margin-top:15px;
            width:100%;
            height:680px;
            resize:none;
        }

        .container{
            margin-top:50px;
        }

    </style>

</head>
<body>

        <div class="nav fixed-top">
                <div class="first"><h3>Secret Diary</h3></div>
                <div class="second"><a href="index.php?Logout=1"><button type="button" class="btn btn-outline-success">Logout</button></a></div>
        </div>

        <div class="container">

            <form>
            <textarea id="textarea" name="textarea"><?php echo $diaryContent;?></textarea>
            </form>     

        </div>

        <script type="text/javascript"> 
        
        function update(){
            $content=$("#textarea").val();
            $.ajax({
                method: "POST",
                url: "updateDatabase.php",
                data: {content:$("#textarea").val()}
                });
        }
        
        $("textarea").on('change keyup paste', function(){
            update();
        });
        </script>
    
</body>
</html>