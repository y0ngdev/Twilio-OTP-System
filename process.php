<?php

//Create Session
require_once("config.php");
ob_start();
session_start();

if (isset($_POST['telsign'])) {
  $phone = $_POST['tel'];



  $statement = $pdo->prepare("SELECT * FROM user WHERE tel=?");
  $statement->execute(array($_POST['tel']));
  $total = $statement->rowCount();
  if ($total) {
    $valid = 0;
    $err_message .= 'An account is already associated with the provided Phone Number<br>';
  }
  else{
  $verification = $twilio->verify->v2->services($serviceId)
    ->verifications
    ->create($phone, "call");
  if ($verification->status) {
    $_SESSION['phone']= $phone;
    header("Location: verify.php?p=signup");

    exit();
  } else {
    echo 'Unable to send verification code';
  }
}
}
if (isset($_POST['signup_verify'])) {
  $code = $_POST['code'];
  $phone = $_SESSION['phone'];

  $verification_check = $twilio->verify->v2->services($serviceId)
    ->verificationChecks
    ->create(
      $code,
      ["to" => "+" . $phone]
    );
  if ($verification_check->status == 'approved') {
    $_SESSION['init']['status'] = 'success';
    $_SESSION['init']['phone'] = $phone;

    header("location: signup.php?p=step2");
  } else {
    $err_message .= 'Invalid code entered<br>';
  }
}

//If the Signup button is triggered
if (isset($_POST['signup'])) {
  $valid = 1;

  /* Validation to check if fullname is inputed */
  if (empty($_POST['fullName'])) {
    $valid = 0;
    $err_message .= " FullName can not be empty<br>";
  }
  //Filtering fullname if not empty
  else {
    $fullname = filter_var($_POST['fullName'], FILTER_SANITIZE_STRING);
  }

  /* Validation to check if email is inputed */
  if (empty($_POST['email'])) {
    $valid = 0;
    $err_message .= 'Email address can not be empty<br>';
  }
  /* Validation to check if email is valid */ 
  else {
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
      $valid = 0;
      $err_message .= 'Email address must be valid<br>';
    }
    /* Validation to check if email already exist */ else {
      // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
      $statement = $pdo->prepare("SELECT * FROM user WHERE email=?");
      $statement->execute(array($_POST['email']));
      $total = $statement->rowCount();
      //If There is a match gives an error message
      if ($total) {
        $valid = 0;
        $err_message .= 'An account is already asociated with the provided email address<br>';
      }
    }
  }
  /* Validation to check if password is inputed */
  if (empty($_POST['password']) || empty($_POST['re_password'])) {
    $valid = 0;
    $err_message .= "Password can not be empty<br>";
  }
  /* Validation to check if passwords match*/

  if (!empty($_POST['password']) && !empty($_POST['re_password'])) {
    if ($_POST['password'] != $_POST['re_password']) {
      $valid = 0;
      $err_message .= "Passwords do not match<br>";
    }
    //If Passwords Matches Generates Hash
    else {
      //Generating Password hash
      $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }
  }

  if ($valid == 1) {
    //if There Error Messages are empty Store data in the database 
    if (empty($err_message)) {
      //Saving Data Into Database
      $statement = $pdo->prepare("INSERT INTO user (fullName,email,tel,password) VALUES (?,?,?,?)");
      $statement->execute(array($fullname, $_POST['email'], $_POST['tel'], $hashed_password));
      unset($_SESSION['phone']);
      header("location: signin.php");
    } else {
      $err_message .= "Problem in registration.Please Try Again!";
    }
  }
}

if (isset($_POST['signin'])) {
  //Checks if Both input fields are empty
  if (empty($_POST['email'] || empty($_POST['password']))) {
    $err_message .= 'Email and/or Password can not be empty<br>';
  }
  //Checks if email is valid

  else {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if ($email === false) {
      $err_message .= 'Email address must be valid<br>';
    } else {
      //Checks if email exists

      $statement = $pdo->prepare("SELECT * FROM user WHERE email=?");
      $statement->execute(array($email));
      $total = $statement->rowCount();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);

      if ($total == 0) {
        $err_message .= 'Email Address does not match<br>';
      } else {
        //if email exists save all data in the same column of the email in the row array

        foreach ($result as $row) {
          $stored_password = $row['password'];
        }
      }
    }
    //Checks Provided password matches the password in database if it does logs user in
    if (password_verify($_POST['password'], $stored_password)) {
      //setting the session variables
      $_SESSION['user'] = $row;
      $_SESSION['user']['status'] = '';
      $_SESSION['phone'] = $row['tel'];
      //setting the session signin time
      $_SESSION['user']['loggedin_time'] = time();
      $verification = $twilio->verify->v2->services($serviceId)
        ->verifications
        ->create($_SESSION['phone'], "call");
      if ($verification->status) {
       
        header("Location: verify.php?p=signin");
    
        exit();
      }
    } else {
      $err_message .= 'Password does not match<br>';
    }
  }
}
if (isset($_POST['signin_verify'])) {
  $code = $_POST['code'];
  $phone = $_SESSION['phone'];

  $verification_check = $twilio->verify->v2->services($serviceId)
    ->verificationChecks
    ->create(
      $code,
      ["to" => "+" . $phone]
    );
  if ($verification_check->status == 'approved') {
  $_SESSION['user']['status'] = 'success';
        
    header("Location: index.php");
    
    //destroy created session

  } else {
    $err_message .= 'Invalid code entered<br>';
  }
}
