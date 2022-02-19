<?php

// CRUD    
/*
   C : CREATE  ** 
   R : READ 
   U : UPDATE 
   D : DELETE 
*/
require 'dbConnection.php';
require 'helpers.php';
require './check_session.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name     = Clean($_POST['name']);
    $password = Clean($_POST['password'], 1);
    $email    = Clean($_POST['email']);
    $address    = Clean($_POST['address']);
    $content    = Clean($_POST['content']);
    $date1    = $_POST['date1'];
    $date2    = $_POST['date2'];


    # Validate ...... 

    $errors = [];

    # validate name .... 
    if (empty($name)) {
        $errors['name'] = "Field Required";
    }


    # validate email 
    if (empty($email)) {
        $errors['email'] = "Field Required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['Email']   = "Invalid Email";
    }


    # validate password 
    if (empty($password)) {
        $errors['password'] = "Field Required";
    } elseif (strlen($password) < 6) {
        $errors['Password'] = "Length Must be >= 6 chars";
    }
    # validate address 
    if (empty($address)) {
        $errors['address'] = "Field Required";
    } 
    # validate content 
    if (empty($content)) {
        $errors['content'] = "Field Required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['Email']   = "Invalid Email";
    }

    //validate date1
    if(empty($date1)){
        $errors['date1'] = "Field Required";
    } 
    //validate date2
    if(empty($date1)){
        $errors['date2'] = "Field Required";
    }


    # Validate Image ..... 
    if (empty($_FILES['image']['name'])) {
       
         $errors['Image']   = "Field Required";
    
    }else{

        $imgName  = $_FILES['image']['name'];
        $imgTemp  = $_FILES['image']['tmp_name'];
        $imgType  = $_FILES['image']['type'];   //size 

        $nameArray =  explode('.', $imgName);
        $imgExtension =  strtolower(end($nameArray));
        $imgFinalName = time() . rand() . '.' . $imgExtension;
        $allowedExt = ['png', 'jpg'];

        if (!in_array($imgExtension, $allowedExt)) {
            $errors['Image']   = "Not Allowed Extension";
        }

    }


    # Check ...... 
    if (count($errors) > 0) {
        // print errors .... 

        foreach ($errors as $key => $value) {
            # code...

            echo '* ' . $key . ' : ' . $value . '<br>';
        }
    } else {

        # DB CODE .......  

       
       
        $disPath = 'uploads/' . $imgFinalName;

        if (move_uploaded_file($imgTemp, $disPath)) {

        # Hash Password .... 
       $password = md5($password);



        $sql = "insert into users (name,email,password,image,address,content,date1,date2) values ('$name','$email','$password','$imgFinalName','$address','$content','$date1','$date2')";

        $op  =  mysqli_query($con,$sql);

        mysqli_close($con);

        if($op){
            echo 'Raw Inserted';
        }else{
            echo 'Error Try Again '.mysqli_error($con);
        }
    }else{
        echo 'Errot Try Again ... ';
    }

    }
}

/*
   
 create db   (blog)    >>> table [title , content , category ]     
 create connection by php code .... 

*/


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Register</h2>

        <form action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="name" placeholder="Enter Name">
            </div>



            <div class="form-group">
                <label for="exampleInputEmail">Email address</label>
                <input type="email" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">New Password</label>
                <input type="password" class="form-control" required id="exampleInputPassword1" name="password" placeholder="Password">
            </div>


            <div class="form-group">
                <label for="exampleInputPassword">Image</label>
                <input type="file" name="image">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">Address</label>
                <input type="text" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="address" placeholder="Enter Address">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">Content</label>
                <input type="text" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="content" placeholder="Enter Content">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword">date1</label>
                <input type="date" name="date1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword">date2</label>
                <input type="date" name="date2">
            </div>
           




            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>


</body>

</html>