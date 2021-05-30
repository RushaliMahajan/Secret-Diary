<?php error_reporting (E_ALL ^ E_NOTICE);

    $link = mysqli_connect("localhost", "root", "", "users");
    session_start();

    if(array_key_exists("Logout",$_GET)){
        unset($_SESSION);
        setcookie("id","",time()-60*60*24*365);
        $_COOKIE['id']="";
    }
    else if(array_key_exists("id",$_SESSION) OR array_key_exists("id",$_COOKIE)){
        header("Location:diary.php");
    }

    if($_POST){

        $link = mysqli_connect("localhost", "root", "", "users");

        if (mysqli_connect_error()) {
    
            die ("There was an error connecting to the database");
    
        }

        if($_POST["email-login"]){

            $query="SELECT `id` FROM `login` WHERE email='".mysqli_real_escape_string($link,$_POST["email-login"])."' ";
            $result=mysqli_query($link,$query);

            if(mysqli_num_rows($result)==0){
                echo "You are not registered, please signup";
            }

            if(mysqli_num_rows($result)>0){

                $query="SELECT `password` FROM `login` WHERE `email`='".mysqli_real_escape_string($link,$_POST["email-login"])."' AND `password`='".mysqli_real_escape_string($link,$_POST["password-login"])."' ";
                $result=mysqli_query($link,$query);

                if(mysqli_num_rows($result)==0){
                    echo "Wrong Password, please try again!";
                }

                else{
                    
                    $query="SELECT `id` FROM `login` WHERE `email` = '" .mysqli_real_escape_string($link,$_POST[email-login]). "' ";
                    $result=mysqli_query($link,$query);
                    $row=mysqli_fetch_array($result);
                     $_SESSION["id"]=$row['id'];

                    if($_POST['check-login']=='1'){
                        setcookie("id",$row['id'],time()+60*60*24*365);
            
                    }
                    header("Location: diary.php");


                }
            }

        }

        if($_POST["email-signup"]){
        
            $query="SELECT `id` FROM `login` WHERE email='".mysqli_real_escape_string($link,$_POST["email-signup"])."' ";
            $result=mysqli_query($link,$query);

            if(mysqli_num_rows($result)>=1){
                echo "This email is already registered, please login";
            }
            else{
                
                $query="INSERT INTO `login` (`email`,`password`) VALUES ('" .mysqli_real_escape_string($link,$_POST['email-signup'])."','" .mysqli_real_escape_string($link,$_POST['password-signup'])."' )";

                if($result=mysqli_query($link,$query)){
                
                    $_SESSION["id"]=mysqli_insert_id($link);
        

                    if($_POST["check-signup"]=="1"){
                        setcookie("id",mysqli_insert_id($link),time()+60*60*24*365);
                        
                    }
                    header("Location: diary.php");
                }
                
               
                

            }
        
        
        }


    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret Diary</title>

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
            color:white;
        }

        .container{
            text-align:center;
            margin: 10% auto;
            width:35%;
        }

        #msg{
            display:none;
        }

        .login{
            color:#79afe0;
        }

        .signin{
            color:#79afe0;
        }

        #loginForm{
            display:none;
        }

    </style>

</head>

<body>

        <div class="container">

            <h1>Secret Diary</h1>
            <h4>Store your thoughts permanently and securely.</h4>


            <div id="msg" class="alert alert-danger" role="alert"></div>
           
            <form id="signinForm" method="post"> 
                <div class="change">Interested?Sign up now!</div><br>
                <div class="form-group">
                    <input type="email" class="form-control" id="email-signup" name="email-signup" aria-describedby="emailHelp" placeholder="Your Email">
                </div>
                <br>
                <div class="form-group">
                    <input type="password" class="form-control" id="password-signup" name="password-signup" placeholder="Password">
                </div>
                <br>
                <div class="form-check">
                    <input type="checkbox" name="check-signup" value=1>
                    <label class="form-check-label" for="check"  name="signinCheck"><h6>Stay logged in!</h6></label>
    
                </div>
                <button type="submit" class="btn btn-success" id="signup">Sign Up!</button>
                <div><a class="login toggleForm" href=""><strong>Login</strong></a></div>
            </form>

            <form id="loginForm" method="post">
            <div class="change">Login using your email and password!</div><br>
            <div class="form-group">
                    <input type="email" class="form-control" id="email-login" name="email-login" aria-describedby="emailHelp" placeholder="Your Email">
                </div>
                <br>
                <div class="form-group">
                    <input type="password" class="form-control" id="password-login" placeholder="Password" name="password-login">
                </div>
                <br>
                <div class="form-check">
                <input type="checkbox" name="check-login" value=1>
                    <label class="form-check-label" for="check"  name="signinCheck"><h6>Stay logged in!</h6></label>
    
                </div>
                <button type="submit" class="btn btn-success" id="login">Login!</button>
                <div><a class="signin toggleForm" href=""><strong>Sign in</strong></a></div>

            </form>

        </div>

        <script type="text/javascript">

            $(".toggleForm").click(function(){


            $("#loginForm").toggle();
            $("#signinForm").toggle();
            return false;

            });
        

            $("#signup").click(function(){

            $error="";
                
            if($("#email-signup").val()==""){
                $error+="Email cannot be empty<br>";
            }
            if($("#password-signup").val()==""){
                $error+="Password cannot be empty<br>";
            }

            if($error==""){
                return true;
            }
            else{
                $("#msg").html("<p><strong>These are the following errors:</strong></p>"+$error);
                $("#msg").show();
                return false;
            }
        });

            $("#login").click(function(){
                $error="";
                
                if($("#email-login").val()==""){
                    $error+="Email cannot be empty<br>";
                }
                if($("#password-login").val()==""){
                    $error+="Password cannot be empty<br>";
                }

                if($error==""){
                    return true;
                }
                else{
                    $("#msg").html("<p><strong>These are the following errors:</strong></p>"+$error);
                    $("#msg").show();
                    return false;
                }

                });


            
        
        </script>
    


</body>
</html>