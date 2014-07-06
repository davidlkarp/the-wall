<?php
session_start();
// session_destroy();
// die;
require_once('connection.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style type='text/css'>
    body{
      background-color: #00002d;
    }
    .smallLogin{
      margin-top: 50px;
      max-width: 400px;
    }
    .smallLogin h2{
      text-align: center;
      color:white;
    }
    .marginA{
      margin-bottom: 5px;
    }
    .white{
      color:white;
    }
    /*#myModalLabel{
      color:black;
    }*/
    li{
      list-style: none;
      margin-top: 5px;
    }
    /*input:hover, input:active, input:focus:hover, input:active:focus{
      border:2px solid green;
    }*/
  </style>

  

   
</head>
<body>

  <?php
    if (isset($_SESSION['error_type']) && $_SESSION['error_type'] == 'login') {
      if (isset($_SESSION['error'])){
        foreach ($_SESSION['error'] as $error) {
          echo '<p>' .$error .'</p>';
        } 
        unset($_SESSION['error_type']);
        unset($_SESSION['error']);
      }
    }
  ?>

  <!-- LOGIN CONTAINER -->
  <div class="container smallLogin">

    <form class="form-signin" role="form" action='process.php' method='post' enctype='multipart/form-data'>
      <h2 class="form-signin-heading">Login</h2>
      <input type='hidden' name='action' value='login'>
      <input type="text" name='email' class="form-control marginA" placeholder="Email address" >
      <input type="password" name='password' class="form-control" placeholder="Password" >
      <label class="checkbox">
        <input type="checkbox" value="remember-me"> <span class='white'>Remember me</span>
      </label>
      <button class="btn btn-lg btn-primary btn-block" type="submit" value='login'>Sign in</button>
    </form>
    <p class='white'> Not a member? <a href="" data-toggle="modal" data-target="#myModal">Click to Register</a>

  </div> 
  <!-- END LOGIN CONTAINER -->


  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Registration</h4>
        </div>
        <!-- MODAL BODY -->
        <div class="modal-body">

          <?php
            if (isset($_SESSION['error_type']) && $_SESSION['error_type'] == 'register') {
              if (isset($_SESSION['error'])){
                foreach ($_SESSION['error'] as $name => $message) {
                  echo '<p>' .$message .'</p>';
                  // unset($_SESSION['error']);
                  // unset($_SESSION['error_type']);
                }
                 
              }
            }
          ?>

          <p> * required</p>
          <form action='process.php' method='post' enctype='multipart/form-data'>
            <ul>
              <li><input type='text' name='first_name' placeholder='First Name'><sup>*</sup></li>
              <li><input type='text' name='last_name' placeholder='Last Name'><sup>*</sup></li>
              <li><input type='text' name='email' placeholder='Email Address'><sup>*</sup></li>
              <li><input type='password' name='password' placeholder='Password'><sup>*</sup></li>
              <li><input type='password' name='c_password' placeholder='Confirm Password'><sup>*</sup></li>
              <li><input type='text' name='birthday' placeholder='Birthdate yyyy/mm/dd'><sup>*</sup></li>
              <li><input type='submit' value='register'>
            </ul>
            <input type='hidden' name='action' value='register'>
          </form>
        </div>
        <!-- /MODAL BODY -->
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> -->
      </div>
    </div>
  </div>
  <!-- END MODAL -->










    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

   <?php
            if (isset($_SESSION['error_type']) && $_SESSION['error_type'] == 'register') {
              if (isset($_SESSION['error'])){
                foreach ($_SESSION['error'] as $name => $message) {
                  unset($_SESSION['error']);
                  unset($_SESSION['error_type']);
                }
                ?> <script>$('#myModal').modal('toggle')</script> <?php 
              }
            }
          ?>

  </body>
</html>
