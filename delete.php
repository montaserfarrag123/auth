<?php 

require 'dbConnection.php';
require './check_session.php';

 $id = $_GET['id'];
 
 $sql = "select image  from users where id = $id";

 $op   = mysqli_query($con,$sql);
 $data = mysqli_fetch_assoc($op);

 


 $sql = "delete from users where id = $id";

 $op = mysqli_query($con,$sql);


 if($op){

   unlink('./uploads/'.$data['image']);
   
    $Message =  'Raw Removed';
 }else{
    $Message = 'Error Try Again';
 }


  # SET  ERROR   SESSION .... 

  $_SESSION['Message'] = $Message;


   header("location: index.php");


?>