<?php
//this script will handle login

session_start();

//check if thw usr is already logged in
if(isset($_SESSION['username']))
{
    header("location : welcome.php");
    exit;
}
require_once "config.php";

$username =$password = "";
$username_err =$password_err = "";
 
//if request method is post
if($_SERVER['REQUEST_METHOD']=="POST"){
    if(empty(trim($_POST['username'])))
    {
        $username_err= "Please enter username";
    }
    else{
        $username =trim($_POST['username']);
        $password =trim($_POST['password']);
    }
}

if(empty($err))
{
    $sql ="SELECT id, username,password FROM users WHERE username=?";
    $stmt= mysqli_prepare($conn,$sql );
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    //TRY TO execute the query
    if(mysqli_stmt_execute($stmt))
    {
        mysqli_stmt_store_result($stmt); 
        if(mysqli_stmt_num_rows($stmt)==1)
        {
            mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
            if(mysqli_stmt_fetch($stmt))
            {
                if(password_verify($password,$hashed_password))
                {
                    //this means password is correct. allow user to login
                    session_start();
                    $_SESSION["username"]=$username;
                    $_SESSION["id"]=$id;
                    $_SESSION["loggedin"]=true;

                    //redirct user to welcome page
                    header("location: welcome.php");
                }
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <title>PHP login system</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PHP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">LOGIn</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h3>Please login here</h3>


     <form action="" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>

    <!--Bootstrap script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>

</html>